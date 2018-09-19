class: title-slide longtitle

.conference[![](logos/%%conference%%.png)]
.introimg[![](scaling/images/shark.png)]

# We Need A Bigger Boat
## Introduction to application scaling

???

Scaling is one of those things that we're often guilty of ignoring early on.

It's only when the spikes start happening, and your application gets slower and slower, that we realise we need to do something about it

There are a lot of different ways we can scale - this talk covers some of the basic approaches, including how you can apply them to existing applications

---

class: section-title-c bottom left vanity-slide

.introimg[![](http://tebex.co.uk/img/tebex.svg)]

# Liam Wiltshire
## CTO

---

class: vanity-cover title-slide

background-image: url(logos/mcft.png)

---

class: section-title-a center centralimage
# What We Will Cover
![](scaling/images/film-shot.jpg)

???

- Scaling is a very big topic, with hundreds of books, articles etc
- This talk is very much an introduction to the topic

---

class: summary-slide middle

- Why do we need to scale?
- First steps - what could I do today?
- Horizontal and vertical scaling
- Threat protection
- What we are doing better this time

???

- We are going to take a high-level look at various scaling strategies
- Most of these things are either things we have done on our platform
- Or things we are doing on the new product we are currently building

---

class: section-title-b middle
background-image: url(scaling/images/overview/1.png)

???

- First we have the admin panel
 - Nothing really to write home about, Laravel, DB, not much to see

---

class: section-title-b middle
background-image: url(scaling/images/overview/2.png)

???

- THen we have our customer control panel
 - This gets quite a bit of use
 - Does all the customer reporting
 - Pulls data in not just from the DB, but a third party service we use to do some of the stats/analytics

- Then it gets interesting....

---

class: section-title-b middle
background-image: url(scaling/images/overview/3.png)

???

- Every single customer has one or more web stores - these are unique to each customer in that it shows their products, categories and content, and on the paid plans they can build their own themes and templates as well

- At the moment we have around 611,000 of these

---

class: section-title-b middle
background-image: url(scaling/images/overview/4.png)

???
- Every webstore than has at least one server attached to it - these could be game servers, mySQL servers, RCON etc.
 - Game servers phone home at different intervals depending on the account type, pulling down any commands to be run on the server. Other server types we push requests to, which is also something we're working on for Game servers.
 - But also you can buy directly in game via commands, so on top of the phone home, there are other API calls being made all the time
- We have just under 650,000 servers

---


class: summary-slide middle

- On an 'average' day, we serve 500k - 600k requests /hour
- Regular spikes - up to 3 or 4x the traffic
 - Black Friday
 - Enterprise customer releases a new product / has a sale
 - Christmas Day (!) - at one point we served 1.4m requests in an hour
- DOS attacks - up to 100k requests per hour
 - Recent attack accounted for over 1m requests /hour

???

- One client on xmas day did nearly $200k

---

class: section-title-c middle halfhalf reverse
background-image: url(scaling/images/worst-case.jpg)

# Why Do 
# We Need
# To Scale

???

- Scaling is something that I wouldn't do if I didn't have to!
- We do it becuase we are too successful!
- We get to a point where we are handling too much data, too much traffic - our servers are under too much load

---

class: content-odd

- Slow Performance
 - Users trying to access your application, but the wait for resources to be available makes it slow
- Outages
 - Hardware cannot keep up - errors for some users
- Unavailability
 - High load eventually causes your server to thrash, taking everything down

???

- This results in Slow performance, Outages and Unavailability

---

class: section-title-a center

# First Steps

![](scaling/images/first-step.jpg)

???

---

class: content-even

# Separation Of Concerns

- Not just web/db
 - Separate server to handle queued tasks/cron
- When you work out your architecture, consider if different componants of your platform could be standalone
 - These can then communicate using APIs when required

???

- Separating your platform out onto different servers provides more resources
- Allows you to scale just the parts of the application that need it
- Also means that if one part was to go down, it doesn't take everything else down with it
- On our existing application, we have a separate web server handing the Laravel Queue
- In the new version of the product we are building, we are building wholly separate platforms for different parts of the product, which will be hosted separately, and then use OAuth and APIs when we need to communicate between them

---

class: content-odd

# Optimisation

- Isn't strictly scaling, but achieves the same
 - More throughput from your existing hardware
- Install something like NewRelic, enable your DB slow query log
 - Tackle the common bottlenecks

???

- Consider what is taking up the most resource - a transaction taking 40 seconds, but only run once a day during quiet times isn't a problem, but perhaps a transaction that locks up a DB connection for 150ms that is run 10 times a second would be a problem

---

class: content-even

#N+1 Issue

- The N+1 issue is common when using many ORMs
- ORMs usually lazy-load relationships by default
- This means that data related to the model will only be loaded on request
 - Less data to start, but consider when we use it in a loop...

---

class: content-even
# N+1 Issue

```php
$users = User::where('company', 5)->get();

foreach($users as $user) {
	$departmentName = $user->relatedDepartment->name;
}
```

???

- In this example, we will load all the user records for that company
- Then we will loop through each user, and run another query to fetch the department for each user
- If a company had 5000 users, that's a lot of queries!

---

class: content-even
# 2N+1 Issue

```php
$users = User::where('company', 5)->get();

foreach($users as $user) {
	$departmentName = $user->relatedDepartment->name;
	$supervisorName = $user->relatedDepartment
						↳	->relatedSupervisor->name;
}
```

???

- Very quick, the number of queries will spiral out of control!

---
class: content-odd

#JIT Model

- We use Laravel, and we had a number of N+1 issues
- Most ORMs will provide a way to eager load relationships
 - Difficult to find all of them
 - They can change over time
- We extended standard Eloquent model 
 - Check if a model is part of a collection, load the relationship for the whole collection

???

- When you change your views, new relationships might be needed, or a relationship you previously needed might become redundant

---

class: content-odd tinycode

```php
public function getRelationshipFromMethod($method)
{
   $relations = $this->$method();
   if (!$relations instanceof Relation) {
      throw new LogicException('Relationship method must return an object of type '
      . 'Illuminate\Database\Eloquent\Relations\Relation');
   }

*   if ($this->parentCollection
*       && count($this->parentCollection) > 1
*       && count($this->parentCollection) <= $this->autoloadThreshold) {
*       $this->parentCollection->load($method);
*   }
   return $this->$method()->getResults();
}
```

???



---

class: section-title-b halfhalf reverse middle
background-image: url(scaling/images/scaling.jpg)

# &nbsp;&nbsp;&nbsp;&nbsp;Hardware<br /> &nbsp;&nbsp;&nbsp;&nbsp;Scaling

???

Improving the nperformance of your application will probably get you so far, but there will be a point where you need more hardware.

Hardware scaling can be quite straightforward, but needs to be well thought out before you just jump in to be successful

---

class: content-even

# What Are You Scaling?

- Scaling only works if you scale the right thing
- Often the DB will start to struggle before the web nodes
- Use a performance monitoring tool to prioritise

---

class: content-odd

# Vertical Scaling

- In other words - a bigger server
- Simple to set up
 - Less moving parts 
- Higher cost
- Single point of failure

???

- The usual first 'port of call' when scaling is vertical.
- Vertical scaling is nice and straight forward - you get a bigger box, and migrate the application to it.
- It is pretty much a one-way transaction however - if you have seasonal peaks, you can't really move to a bigger server and then move back
- A single server is still a single point of failure - if your single DB server goes down, you need some other failover in place.

---

class: content-even

# Horizontal Scaling

- Lots of smaller servers working in unison
- You might have different clusters of servers for web, db etc
- More complicated to set up
 - Particularly if you rely on storing things to the filesystem 
- Built in redundancy, burstable

???
- Horizontal scaling allows you to have many smaller, cheaper servers
- We are focusing on horizontal scaling of web services at the moment
- Will come onto applying this to DBs in more detail in a minute
- Potential issues: Storing things to filesystem - file uploads, user sessions
- You can add and remove nodes as demand requires, and if a node fails, the whole system doesn't go down

---

class: content-even center

# Horizontal Scaling


![](scaling/images/horizontal.png)

---

class: content-even

# Know Your Architecture
- Horizontal scaling as worked well for us
- We do large amounts of communication with external servers
 - Many of these want fixed IPs to whitelist

???

- Initially our scaling didn't allow for this - each EC2 instance would have it's own IP, and these would change as we scaled up and down.
- The solution was to have 2 NAT gateways that the traffic goes through.

---

class: content-odd

# Horizontal Scaling DBs

- Scaling out DBs horizontally is achieved by one of two methods
 - Sharding
 - Replication

- Both of which are valid, but potentially have their problems

???

- Scaling DBs is something that can be quite trickey
- Blog post - "Relational DBs are not designed to scale"
 - We have a few ways we can go about it, but non of them are really 'complete' - there are usually compomises to be made

---

class: content-odd

# Sharding

- The data is shared accross different servers
 - Each server contains different data
- Either the database server or your application layer need to know which DB to use to fetch the specific data

???

Sharding is something you often hear spoken about at really big companies (Google, Facebook etc)

However, Sharding is very difficult to get right

You have to come up with a scheme of sharding your data - doing queries that involve getting data from multiple shards becomes complex, and your sharding scheme needs to avoid it as far as possible.

If you have an existing application, sharding is even more difficult - you'd have to migrate your existing data onto multiple shards, then update your application logic to know which shard to go to etc.

Not normally a route I'd recommend unless you've exahusted all other options.

---

class: content-even

# Replication

- Unlike sharding, a replicated database will have the entire DB on evey instance
- This means you can query any instance of the DB and get the same data out of it
 - Mostly...

---

class: content-even

# Master -> Slave Replication

- Generally, when we talk about DB replication, we mean Master -> Slave replication
 - One DB instance is the master, write requests are directed to this
 - The DB changes are then propagated to the slave nodes

- However this only increases your read capacity
 - There can be a delay on the slaves being updated

???

Master -> Slave replication means you have one master DB which gets written to, and the changes are then written to the slaves
 - This usually happens quickly (within 100ms or so), but sometimes the slaves can fall behind
This does allow for failover, since if a slave dies, as long as you a monitoring, it's fine, and if the master dies, you promote one of the slaves to master and away you go...
In theory at least

This should give you an infinitely scalable read-throughput (as long as you can handle the small times when a replica falls behind). But what if you have a write heavy application?

---

class: content-odd

# Master -> Master Replication

- Galera Cluster allows for Master -> Master replication
- It works synchronously, allowing writes to be to any node
- We had three DB nodes and used Galera to keep them in sync

???

This is what we did - we set up three nodes with master -> master -> master replication

Using HAproxy again to monitor the health of the nodes and to route the traffic as appropriate.

---

class: content-even

# How Did It Go?

- Not well!
 - We experienced big issues with write performance and network latency
- Temporarily we moved back to vertical scaling
- Longer term, moved to Amazon Aurora - only provides read-replicas
 - But with a substantially better throughput

???

Notice how we use 'had' - we had issues where our writes were too frequent, and the replication queue grew to a point where Galera would start throtelling our DBs... not good

As a temporary solution we went back to vertical scaling, but we are now moving to Amazon aurora which provides better throughput, and low latency read-replicas.

As mentioned before, for our new product, we are building each componant totally standalone, which essentially is a form of sharding.

---

class: section-title-c center

# Caching

&nbsp;

![](scaling/images/cache.jpg)

---

class: content-even

# Dynamic Content Is Bad

- Serving static content is always faster
- Anything that requires 'work' to be generated will be slow
 - 3rd party API calls
 - DB queries
 - Even data processing
- Use a memory cache to improve response times, and reduce server load


---
class: middle center

![](scaling/images/cache-all-the-things.jpg)

???

- Ok, so maybe we don't cache all the things
 - Something that will only be loaded once every 24 hours is a waste of cache
 - But we do cache as much as possible
- We use a shared Redis instance
 - Available to all our web nodes

---

class: content-even

# How Long Should I Cache?

- Different data can be cached for different periods of time
 - Particularly in high-traffic areas (such as our webstores), even caching for 1 minute can save a huge number of DB requests
 - The reporting data is cached for 15 minutes
 - Some 'fixed' data in the APIs is cached for an hour or more

???

Something that we don't currently do is full page caching.
We cache static HTML pages, but actually, we could potentially full page cache quite a few webstore pages, even API outputs
 - This is something we are looking at for our new product

Something we are also experementing with at the moment is caching until changed - so our cache has an essentially infinate lifetime, and it's held in cache until either redis kicks it out, or a change is made that invalidates it. 

---

class: content-odd

#Pre-Warming

- If you have high traffic pages you *know* will be requested
 - Particularly if those pages as slow to build
- Automate the flushing and re-caching of the busiest pages
- Again consider how long the cache is valid

???

- In a previous life I worked for a Magento house
 - Often pages such as top level categories, offers pages etc would be slow
- We'd use pre-warming to fetch those pages once the daily imports etc were run, and expire the cache the following day
 - This wouldn't work on pages that change regularly, such as if you different content depending on the user login
 - However in that instance you could pre-cache the 'fixed' areas of the page, and then have a placeholder to replace with the dynamic content.

---

class: section-title-a halfhalf middle
background-image: url(scaling/images/DDOS.jpg)

# Threat Protection


---

class: content-odd

# Threat Protection

- Without realising it, you could potentially be burning requests on illegitamate traffic
 - DDOS attacks
 - API consumers gone mad
 - Rougue crawlers

???

- You might be surprised at how much 'background noise' is actually
threat traffic - we have a continual 70k requests per hour on an almost
continual basis - this would quickly consume your resources (and your
network) if you let that traffic through to your servers.

---

class: content-even

#Rate Limiting

- Consider what a reasonable number of requests would be
	- In many cases, even 1 request a second is probably high
- As a starting point, rate-limiting the entire API platform would rule out the worse offenders

???

- We looked at our worst case - enterprise customers with 10 servers behind one external IP
 - 1 request a minute + 20 store requests pm = 105 total
- For simplicity we just rate-limited the entire API platform, but you could put more granularity in
 - Rate limit different IPs different depending on use.
- Rate limiting can be done in the application layer, but equally you could use something like fail2ban to monitor the logs and block at a firewall level from that.

---

class: content-odd

#CloudFlare

- Make use of a service like CloudFlare
 - Caches static pages
 - Provides a CDN
 - Protects us against a variety of attacks through traffic profiling, rate limiting and shared intelligence

???

 We use
CloudFlare to mitigate, as well as providing caching for our static pages.

---

class: summary-slide middle

- In an ideal world, scalability is considered during the original build
- However, this is often not the case, but there are still things you can do
- Critical to understand your profile first - use tools such as NewRelic, and measure your platform
- Isolate the problem parts of your application from everything else, this will make it much easier to scale where it's needed

---

class: thanks-slide

.conference[![](logos/%%conference%%.png)]
.introimg[![](http://tebex.co.uk/img/tebex.svg)]

# Thank You

### %%joindin%%
### Liam Wiltshire
### @l_wiltshire
### liam@tebex.co.uk
