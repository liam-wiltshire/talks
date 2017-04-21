class: title-slide

.conference[![](logos/%%conference%%.png)]
.introimg[![](security/images/padlock.png)]

# Lockdown
## Linux security 101

???

Scaling is one of those things that we're often guilty of ignoring early on.

It's only when the spikes start happening, and your application gets slower and slower, that we realise we need to do something about it

There are a lot of different ways we can scale - this talk covers some of the basic approaches, including how you can apply them to existing applications

---

class: section-title-c bottom left vanity-slide

.introimg[![](http://tebex.co.uk/img/tebex.svg)]

# Liam Wiltshire
## Senior PHP Developer<br /> & Business Manager

---

class: vanity-cover

background-image: url(logos/mcft.png)

---

class: section-title-a center centralimage
# What We Will Cover
![](scaling/images/film-shot.jpg)

???

- Security is a massive topic, no way we can cover everything in 3 hours!
- This is very much a '101' session - a high-level introduction

---

class: summary-slide middle

- First Steps - Securing a new box
- Basic security principles
- Security tools
- Introduction to network security
- PCI DSS 101

???

- Will look at some key tools and principles you can go away and start to apply
- Hopefully starting points to go and expand your own knowledge
- We are *not* looking at application security - other then where you can harden your server to protect against potential application holes

---

class: section-title-c middle halfhalf reverse
background-image: url(scaling/images/worst-case.jpg)

# Principles
# of
# Security

???

- Every action we take and every decision we make should
- Each thing we do to secure our system should tick off one or more of these
- Our overally approach should tick off all of these

---

class: content-odd

# Accountability

- Bank - Lock, Key, Camera
- Gold Standard
 - Authorization
 - Authentication
 - Audit

TASK: Think about your platforms - list ways you satisfy each standard, and things you could add to improve

---

class: content-even

# Defense In Depth

- Multiple levels of security are better
- Independent
- Overlapping
- Multiple small security mechanisms are better than one big one

TASK: Think of examples of defense in depth

???

- 2FA
- Multiple firewalls at network and hardware level
- Security at network, server and application level

---

class: content-odd

# Non-Secrecy of Design

- "Security by Obscurity" cannot be relied upon
- Assuming that implementation details *will* be discovered
 - Hackers might know the encryption algorithm, but not the key

???

- Kerckhoffs's Principle
- Not to say don't use it - but it can never be your primary method of security
- E.g. don't use a predictable URL for your admin area

---

class: content-even

# Audit Everything
- As hard as we try, a failure is still possible
- In any situation, we should be able to see exactly what happened and why
- Data can be used to improve the system and prevent future attacks

TASK: Think about your existing systems - do you have holes in your logging?

---

class: content-odd

# Failsafe Defaults
- The default should be total lockdown, with privilege granted
 - Worst case, someone can't access something they should
- The opposite, where prohibitions are added makes it very easy to accidently give someone access to something they shouldn't

TASK: Give examples of granting of privilege and addition of prohibitions

---

class: content-even

# Least Privilege

- Users and applications should have *just enough* access to do what they need to do
 - You almost never need full root access!
 - 777 file permissions

TASK: Think about times where you've granted too much access


---

class: content-odd

# Secure The Weakest Link First
- There is no point adding more security to something that is already secure, if another part of the system is insecure
 - List every component of your platform (software, network, users etc.) and grade it's existing security
 - Then work from the lowest score up

TASK: Do the exercise above!

???

Imagine you are charged with transporting some gold securely from one homeless guy who lives in a park bench (we’ll call him Linux) to another homeless person who lives across town on a steam grate (we’ll call her Android).  You hire an armored truck to transport the gold.  The name of the transport company is "Applied Crypto, Inc."  Now imagine you’re an attacker who is supposed to steal the gold.  Would you attack the Applied Crypto truck, Linux the homeless guy, or Android the homeless woman?  Pretty easy experiment, huh?  (Hint: the answer is, "Anything but the crypto.")

---

class: section-title-a center

# Server Security - First Steps

![](scaling/images/first-step.jpg)

???

- These are the first thing you should think about when you get a new box
- You should then revisit them and recheck them regularly

---

class: content-even

# Keep your OS up to date

- Includes monitoring appropriate mailling lists
- If you are using RHEL based OSes, the updates may not be available in the main REPO

TASK: Update the OS - adding a new source (remi) if required

???

---

class: content-odd

# Secure Configuration

- Ensure user accounts are as restricted as possible
- Only install/enable required services
- Remove default accounts / change default passwords
- Enforce password strength

TASK: List running servers, disable unneeded
      Look though list of users, remove unneeded
      Change passwords
      Configure enforced password strengh

???

---

class: content-even
# User security

- Users should have minimal access by default
- Root access is almost never required
- Configure sudo for just the required commands
- Log use of sudo

TASK: Sudo configuration

???

---

class: content-odd

#Per Service Security

- Do reading for the services you are using, to advise on how to harden them
- SSH - Key-based authentication / disable root login / set restrictions to sign-in attempts / non-default port
- mySQL - Disable 'open' remote access - only allow remote access from IPs that need it
- Apache - Disable TRACE, Run it as it's own user, only use TSL for encyption
- FTP - Disable unauthenticated FTP (or even better, don't use FTP!)

---

class: content-even
# Logging/Audit

- Log user actions
- Log all access attempts (successful or otherwise) on all exposed ports
- Regularly review the logs
- Ensure logs are enabled for every running service

TASK: Review some logs for things that might be suspicious

???

---

class: content-odd
# Anti-Virus

- Use it - clamav
- Rootkits are also a problem - which clamAV may or may not secure against
- Show example rootkit
- Rootkit hunter is a good RK detector

TASK: Install clamAV and update / Install rkhunter

???

---

class: section-title-b halfhalf reverse middle
background-image: url(scaling/images/scaling.jpg)

# Securing Common Services

???

---

class: content-even

# SSH

- Disable root
- Key based auth
- Change IP
- Limit number of sign-ins

---

class: content-odd

# Apache

- Install mod_security
- Disable unwanted HTTP Methods
- Only allow TLS encryption
- Generate Unique DH Group
- Disable weak ciphers
- Enforce restrictive permissions
- PHP SetHandler vs AddHandler
- Disable ServerSignature and ServerTokens
- Disable FileETag

???

---

class: content-even

# Nginx

- Only allow TLS encryption
- Disable weak ciphers
- Reduce buffer sizes
- Generate Unique DH Group
- Disable unwanted HTTP Methods
- Install ModSecurity
- Turn off server_tokens
-  Enable X-XSS Protection

???

---

class: content-odd

# PHP

- Disable shell/OS functions if you don't need them
- Enforce a basedir

???

---

class: content-even

# SELinux

- Use it!
- How to properly configure

???

---

class: section-title-c center

# Network Security Principles

&nbsp;

![](scaling/images/cache.jpg)

---

class: content-even

# Zone Your Network

- What parts of your network do need public addess? Which parts don't
- Set up internal firewalls (and ideally user authorization) to separate public and private areas of the network

TASK: Given a list of servers, identify which zones they should go into

---

class: content-odd

# Port/Source Restriction

- If you don't need access to a port, then don't allow access!
 - Combine this with component restrictions - if you have an admin application, a non-default HTTP IP can be restricted to known IPs
- If you have access to a network-level firewall, that's preferable
- If not, use IPTables
- Don't just lock down ports, lock down ports to IP addresses

TASK: Configure IP tables

???

---

class: content-even

# Frequency of access

- If you know there is never a reason for more than 100 requests a minute to a section of your network, then don't alow more!
- Use mod_evasive

TASK: Install mod_evasive

???

---

class: content-odd

# Third-Party Tools

- For alot of this stuff, you could use a third party service such as CloudFlare
- If you have the resources to do it, then I strongly recommend that's the way to go.

???

---

class: section-title-a halfhalf middle
background-image: url(scaling/images/DDOS.jpg)

# Types of Attacks


---

class: content-odd

# (D)DOS Attack

- An attempt to flood your infrastructure with traffic to remove available resources
- Network Level
- Layer 7

TASK: How can we mitigate a (D)DOS attack

???

---

class: content-even

# Virus/Ransomware

- Any infrastructure where data is accepted from untrusted sources is potentially at risk
 - Rootkits
 - Cryptolocker variants
 - Mail spam/Botnets

TASK: How can we protected against viruses/Ransomeware

???

---

class: content-odd

# Man in the Middle

?!?

???

---

class: content-even

# Phishing

- Scenario - dumpster diving
- Scenario - someone rings/emails pretending to be someone else

TASK: How can we protect against phishing

---

class: content-odd

# Brute force

?!?

---

class: section-title-b center

# Fail2Ban

&nbsp;

![](scaling/images/cache.jpg)

---

class: content-even

# What is Fail2Ban

- A log analyser and firewall configurator
- You can write rules for it to check against for given log files, and then define actions to take based on those rules
 - Filters / Jails

TASK: Example

---

class: content-odd

# What is Fail2Ban used for

- Blocking IPs that are deemed to pose a threat
 - Too many requests
 - Brute force attacks
 - Attempting to access files they shouldn't be
 - Suspicious signatures that look like an attack


???

---

class: content-even

# Installing Fail2Ban


???

---

class: content-odd

# Creating Filters


???

---

class: content-even

# Creating Jails


???

---

class: summary-slide middle

- Fresh box, set up an automated attack on as many vectors as possible
- Working in teams, identify the attacks and mitigate against them
- Before the attacks start, 20 minutes to 'harden' the servers
- Once the attacks of started, they will run for 25 minutes
- Prizes for the team who mitigates the most

---

class: section-title-c center

# Introduction to PCI-DSS compliance

&nbsp;

![](scaling/images/cache.jpg)

---

class: content-even

# Cardholder Data


---

class: content-odd

# Levels of Compliance


???

---

class: content-even

# Requirements of Compliance

- AVS scans
- PEN tests
- Policy documents

???

---


class: thanks-slide

.conference[![](logos/%%conference%%.png)]
.introimg[![](http://tebex.co.uk/img/tebex.svg)]

# Thank You

### %%joindin%%
### Liam Wiltshire
### @l_wiltshire
### liam@tebex.co.uk
