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

---

class: content-odd

.center[![](security/images/task.png)]

Think about your day-to-day server platform
- List the things you do to satisfy each standards
- List the things you could add to improve.

TODO: Worksheet

---

class: content-even

# Defense In Depth

- Multiple levels of security are better
- Independent
- Overlapping
- Multiple small security mechanisms are better than one big one

---

class: content-even

.center[![](security/images/task.png)]

What examples of defense in depth (multiple overlapping security mechanisms) are you using?


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

---

class: content-even

.center[![](security/images/task.png)]

Think about your existing platform
 - What are you logging
 - What are you not logging


TODO: Worksheet

---

class: content-odd

# Failsafe Defaults
- The default should be total lockdown, with privilege granted
 - Worst case, someone can't access something they should
- The opposite, where prohibitions are added makes it very easy to accidently give someone access to something they shouldn't


---

class: content-odd

.center[![](security/images/task.png)]

- What examples can you think of of good failsafe defaults

---

class: content-even

# Least Privilege

- Users and applications should have *just enough* access to do what they need to do
 - You almost never need full root access!

---

class: content-even middle center noheader

![](security/images/chmod.jpg)

---

class: content-odd

# Secure The Weakest Link First
- There is no point adding more security to something that is already secure, if another part of the system is insecure
 - List every component of your platform (software, network, users etc.) and grade it's existing security
 - Then work from the lowest score up

???

Imagine you are charged with transporting some gold securely from one homeless guy who lives in a park bench (we’ll call him Linux) to another homeless person who lives across town on a steam grate (we’ll call her Android).  You hire an armored truck to transport the gold.  The name of the transport company is "Applied Crypto, Inc."  Now imagine you’re an attacker who is supposed to steal the gold.  Would you attack the Applied Crypto truck, Linux the homeless guy, or Android the homeless woman?  Pretty easy experiment, huh?  (Hint: the answer is, "Anything but the crypto.")


---

class: content-odd

.center[![](security/images/task.png)]

- Identify the weak links in your platform
- What could you do today to secure them?

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

---

class: content-even

.center[![](security/images/task.png)]

- Check the current update status of the platform
- Add a new yum repo (remi)
- Update all the packages on your server.

???

---

class: content-odd

# Secure Configuration

- Ensure user accounts are as restricted as possible
- Only install/enable required services
- Remove default accounts / change default passwords
- Enforce password strength

---

class: content-odd

.center[![](security/images/task.png)]

- Look at the list of currently running services
 - Remove un-needed services
- Look through the list of system user
 - Remove un-ndeeded users

???

---

class: content-even
# User security

- Users should have minimal access by default
- Enforce strong passwords
- Root access is almost never required
- Configure sudo for just the required commands
- Log use of sudo

---

class: content-even

.center[![](security/images/task.png)]

- Configure sudo to allow access to certain commands for each user
- Enforce the use of strong passwords

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

---

class: content-even

.center[![](security/images/task.png)]

- Review the logs for evidence of an attack

???

---

class: content-odd
# Anti-Virus

- Use it - clamav
- Rootkits are also a problem - which clamAV may or may not secure against
- Example rootkit
- Rootkit hunter is a good RK detector

---

class: content-odd

.center[![](security/images/task.png)]

- Install clamAV
- Update definitions
- Install rkhunter
- Scan for rootkits

???

---

class: section-title-b halfhalf reverse middle


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
- Enable X-XSS Protection

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

---

class: content-even

# Configuring SELinux


???

---

class: section-title-c center

# Network Security Principles

&nbsp;

![](security/images/wificonfig.png)

---

class: content-even

# Zone Your Network

- What parts of your network do need public addess? Which parts don't
- Set up internal firewalls (and ideally user authorization) to separate public and private areas of the network

---
class: content-even

.center[![](security/images/task.png)]

- From the given list of servers, identify which zones they should go into

TODO: Worksheet!

---

class: content-odd

# Port/Source Restriction

- If you don't need access to a port, then don't allow access!
 - Combine this with component restrictions - if you have an admin application, a non-default HTTP IP can be restricted to known IPs
- If you have access to a network-level firewall, that's preferable
- If not, use IPTables
- Don't just lock down ports, lock down ports to IP addresses

---

class: content-odd

.center[![](security/images/task.png)]

- Configure IPTables to allow:
 - Global access to HTTP/HTTPS
 - Single-IP access to SSH
 - Local network access to mySQL

???

---

class: content-even

# Frequency of access

- If you know there is never a reason for more than 100 requests a minute to a section of your network, then don't alow more!
- Use mod_evasive

---

class: content-even

.center[![](security/images/task.png)]

- Install mod_evasive
 - Configure to block visitors for 1 minute if they:
  - Hit the same page 5 or more times a second -or-
  - Hit any page on the site more than 100 times a minute

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

---

class: content-odd

.center[![](security/images/task.png)]

- Suggest ways we can mitigate a DDOS attack

???

---

class: content-even

# Virus/Ransomware

- Any infrastructure where data is accepted from untrusted sources is potentially at risk
 - Rootkits
 - Cryptolocker variants
 - Mail spam/Botnets

---

class: content-even

.center[![](security/images/task.png)]

- Suggest ways we can protect against viruses/ransomware

???

---
class: content-even

# Phishing

- Scenario - dumpster diving
- Scenario - someone rings/emails pretending to be someone else

---
class: content-even

.center[![](security/images/task.png)]

- Suggest ways we can protect against phishing

---

class: content-odd

# Brute force

---

class: content-odd

.center[![](security/images/task.png)]

- Suggest ways we can protect against brute force attacks

---

class: section-title-b center

# Fail2Ban

&nbsp;

![](security/images/firewall.gif)

---

class: content-even

# What is Fail2Ban

- A log analyser and firewall configurator
- You can write rules for it to check against for given log files, and then define actions to take based on those rules
 - Filters define the rules to search for
 - Actions are the result of a match - ban, send email etc
 - Jails are the combination of a filter and one or more actions

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

- Install Fail2Ban using yum

???

---

class: content-odd

# Creating Filters

- Filters are stored in /etc/fail2ban/filters.d/
- Create a filter that checks for users trying to access c99.php


???

---

class: content-even

# Available Actions

- Actions are stored in /etc/fail2ban/actions.d/
- Probably little need to create new ones (unless you want to integrate with external APIs etc)
- Review the act exist

???


class: content-odd

# Creating Jails

- You can have has many jails as you like watching different things
- Jails are stored in
- Create a jail for our c99.php filter that blocks the user for 1 hour if that jail is accessed once

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

![]()

---

class: content-even

# Cardholder Data

- Almost everything in PCI-DSS-land is focussed around 'cardholder data'
 - Full PAN (card number)
 - Cardholder name
 - Expiry date
 - Service code

- If you are holding/sending the PAN, PCI-DSS compliance becomes a whole lots more complicated


---

class: content-odd

# Levels of Compliance

- For most sites (the rules are different if you process 6 million+ card transactions), there are 3 main levels:
 - SAQ-A
  - This is mostly for sites that use a redirect or iframe - where the *entire* payment page is hosted and managed by a third party
 - SAQ-A-EP
  - This covers other situations where card data doesn't touch your server, but your codebase has a hand in generating the inputs for that data - direct post, javascript etc
 - SAQ-D
  - This covers situations where card data does hit your server (even if only in memory before being passed on via XML for example)

???

- Personally, I don't like the SAQ-A - this mostly removes your website from scope, but I don't see that it's any more secure. If your website contains an iframe to yor payment processor, what is to stop a hacker from gaining access and re-pointing the iframe to their own server to collect card details?
- The further down the list you are, the more difficult compliance is. Unless you have dedicated staff, I really don't recommend you do anything that puts you in SAQ-D band!

---

class: content-even

# Requirements of Compliance

- SAQs
 - Every compliance level has a self-assessment questionnaire.
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
