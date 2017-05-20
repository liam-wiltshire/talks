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

class: content-odd noheader

.center[![](security/images/task.png)]

Think about your day-to-day server platform
- List the things you do to satisfy each standards
- List the things you could add to improve.

---

class: content-even

# Defense In Depth

- Multiple levels of security are better
- Independent
- Overlapping
- Multiple small security mechanisms are better than one big one

---

class: content-even noheader

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

class: content-even noheader

.center[![](security/images/task.png)]

Think about your existing platform
 - What are you logging
 - What are you not logging


---

class: content-odd

# Failsafe Defaults
- The default should be total lockdown, with privilege granted
 - Worst case, someone can't access something they should
- The opposite, where prohibitions are added makes it very easy to accidently give someone access to something they shouldn't


---

class: content-odd noheader

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

class: content-odd noheader

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

class: content-even noheader

.center[![](security/images/task.png)]

- Check the current update status of the platform

```bash
# yum check-update
```

???

- This may take a few seconds to run, as we are waiting for yum to fetch latest information
- Everyone done? Take a look through, look at the versions being updated to particulary httpd, php
 - What do you notice (old versions)
- RHEL - not most up to date
 - Does backport fixes, but it's up to you. The alterntaive is to install an alternative repo that contains up to date software

---

class: content-odd

# Alternative Repos
- There are lots of repos out there
 - Some are officially supported by RHEL or CentOS
 - Others are provided by third party
- It comes down to trust
 - Personally, I use EPEL and Remi

---

class: content-odd noheader

.center[![](security/images/task.png)]

- Add the EPEL and Remi repos
 - https://blog.remirepo.net/pages/Config-en

```
[remi-php71]
name=Remi's PHP 7.1 RPM repository for Enterprise Linux 6 - $basearch
#baseurl=http://rpms.remirepo.net/enterprise/6/php71/$basearch/
mirrorlist=http://rpms.remirepo.net/enterprise/6/php71/mirror
* enabled=0
gpgcheck=1
gpgkey=file:///etc/pki/rpm-gpg/RPM-GPG-KEY-remi
```
---

class: content-odd noheader

.center[![](security/images/task.png)]


- Update all the packages on your server.

```bash
# yum update
```

???
- Go to https://blog.remirepo.net/post/2016/02/14/Install-PHP-7-on-CentOS-RHEL-Fedora

---

class: content-even

# Secure Configuration

- Only install/enable required services
- Remove unneeded users
 - There are some system users installed by default
 - There might also be old users that are no longer needed
 - Or even a backdoor user that someone has added!

---

class: content-even noheader

.center[![](security/images/task.png)]

- Look at the list of installed services
 - Remove un-needed services using `yum erase`
 - You may find that some services are a dependency of something else

```bash
# chkconfig --list
```

???
- Have a look through the list - what is there that is unneeded (vsftpd, smb)
- postfix is a dependency of cron, so if you need scheduled tasks, then you cant remove it

---

class: content-even noheader

.center[![](security/images/task.png)]


- Look through the list of users
 - Remove un-ndeeded users

 ```bash
 # cat /etc/password
 # ps aux
 # userdel [username]
 ```

???

---

class: content-odd
# User security

- Users should have minimal access by default
- Enforce strong passwords
- Root access is almost never required
- Configure sudo for just the required commands
- Log use of sudo

---

class: content-odd noheader tinycode

.center[![](security/images/task.png)]

- Enforce the use of strong passwords

```bash
# cat /etc/pam.d/system-auth

# password  requisite  pam_cracklib.so try_first_pass retry=3
* minlength=12
* ocredit=-1
* ucredit=-1
* dcredit=-1
* lcredit=-1
```

???

Minimum complexity of 12, at least one upper, at least one digit at least one lower, at least one other

---

class: content-odd noheader

- Add a new user `useradd [username]`
- Set a temporary password `passwd [username]`
- Switch to that user account `su [username]`
- Try to change the password to something insecure `passwd`

```bash
BAD PASSWORD: it does not contain enough DIFFERENT characters
BAD PASSWORD: it is too short
```

---

class: content-odd noheader

.center[![](security/images/task.png)]

- Configure sudo to allow access to certain commands for each user
 - By default, sudo isn't allowed for any users in CentOS
 - Open up a new terminal, login with your new user and try to restart httpd
 - `service httpd restart`

???
- First off, login with another terminal and your new user
 - Try to restart httpd (service httpd restart) - what happens?
- Let's add a rule to sudo

---


class: noheader content-odd tinycode

```bash
# visudo
[username] ALL=[commands]
```

???

- The sudoers file can be shared between multiple machines, so there are ways of setting rules by user and machine
 - However, we're going to keep it simple
 - The general format is username ALL= comma separated list of commands. The command must include a full path
- So, can anyone suggest what the line will look like?

---

class: noheader content-odd tinycode

```bash
# visudo
[username] ALL=[commands]
* liam ALL=/sbin/service httpd restart
```

```bash
sudo service httpd restart
```

???

- At the moment, you can only restart that one service - what if you need access to another service?

---

class: noheader content-odd tinycode

```bash
# visudo
[username] ALL=[commands]
liam ALL=/sbin/service httpd restart
```

```bash
sudo service httpd restart
```

```bash
* liam ALL=/sbin/service httpd restart, /sbin/service mysqld restart
```

---

class: content-even tinycode

# Sudo logs

- Sudo actions are stored in the `/var/log/secure` file

```bash
grep "sudo" /var/log/secure

May 13 16:12:07 li1167-84 sudo:     liam : TTY=pts/1 ; PWD=/home/liam ; USER=root ; COMMAND=/sbin/service httpd restart
May 13 16:20:02 li1167-84 sudo:     liam : TTY=pts/1 ; PWD=/home/liam ; USER=root ; COMMAND=/sbin/service httpd restart
May 13 16:20:09 li1167-84 sudo:     liam : command not allowed ; TTY=pts/1 ; PWD=/home/liam ; USER=root ; COMMAND=/sbin/service mysqld restart
May 13 16:20:36 li1167-84 sudo:     liam : TTY=pts/1 ; PWD=/home/liam ; USER=root ; COMMAND=/sbin/service mysqld restart
```

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

.center[![](security/images/Log-all-the-things.png)]

???
- Log as much as possible - user actions, login attempts, running services, SQL queries, everything
- Logging servces two purposes
 - Being able to catch issues before they become a problem - *so long as you are reviewing your logs regularly*
 - If the worst does happen, the more logging you have, the more likely you can identify what happened and why

---

class: content-even tinycode noheader

.center[![](security/images/task.png)]

- Log all user commands
 - To log all entered (bash) commands, we will tweak the global bash config, and create a new syslog

```bash
# vi /etc/profile.d/userlog.sh

export PROMPT_COMMAND='RETRN_VAL=$?;logger -p local6.debug
"$(whoami) [$$]: $(history 1 | sed "s/^[ ]*[0-9]\+[ ]*//" ) [$RETRN_VAL]"'
```

???

- That's quite a long command do type, so I have put it in a text file - /root/log.txt!
- Explain what it does
- Limitation - can be overridden if someone resets the PROMPT_COMMAND variable
 - Could be used in conjunction with the acct service, but that only provides commands, not arguments

---

class: content-even tinycode noheader

```bash
# vi /etc/rsyslog.d/bash.conf

local6.*    /var/log/commands.log

service rsyslog restart
tail -f /var/log/commands.log
```

???

Now logout. and log back in with your other terminal, and start running some commands - you should see them show up in the log

---

class: content-even tinycode noheader

.center[![](security/images/task.png)]

- Log all mySQL queries
 - This is useful in the instance of a suspected data breach, as you can see exactly what queries were run and thus what data was accessed
 - It is a tradeoff between performance and logging

---

class: content-even noheader

```bash
# mkdir /var/log/mysql
# chown -R mysql:mysql /var/log/mysql
# vi /etc/my.cnf

[mysqld]
log = /var/log/mysql/general.log
```

???

- Once you set up the log, restart mysqld, and then connect to the database in your other connection - you should see connection and query information in the log file.

---

class: content-odd
# Anti-Virus

- Use it - clamav
- Rootkits are also a problem - which clamAV may or may not secure against
- Linux Malware Detect is a good malware solution, and works well alongside clamav

???

- More and more, viruses are being written to target linux
 - Ransomware, Mail spammers and rootkits are common
- No reason not to install antivirus.
 - There are paid-for sollutions such as McAfee, so by all means use those
 - But at the least, use ClamAV
- Multiple layers of protection are good - clamAV may not pick up on rootkits
 - Open up a browser and go to your ip address /shell.php
 - ClamAV may not pick up things such as this, so a dedicated rootkit scanner is valuable
- Until recently I mostly used rkhunter, but I've switched to LMD as I found it to be more accurate, and it uses the clamav scan engine instead of rolling it's own.

---

class: content-odd noheader

.center[![](security/images/task.png)]

- Install clamAV
- Update definitions
- Perform a scan

```bash
# yum install clamav
# freshclam
# clamscan -r /root
```

---

class: content-odd noheader tinycode

.center[![](security/images/task.png)]

- Install LMD
- Scan for rootkits

```bash
# wget http://www.rfxn.com/downloads/maldetect-current.tar.gz
# tar -xzf maldetect-current.tar.gz
# cd maldetect-1.6/
# chmod +x install.sh
# ./install.sh
```

---

class: content-odd noheader tinycode

```bash
# vi /usr/local/maldetect/conf.maldet
scan_ignore_root="0"

# /usr/local/maldetect/maldet --update-sigs
# /usr/local/maldetect/maldet --scan-all /var/www/html

```

???

---

class: section-title-b halfhalf reverse middle


# Securing Common Services

???

---

class: content-even tinycode

# SSH

- Disable root
 - Root access should never be needed, and there is no reason anyone should need to ssh in as root

```bash
# vi /etc/ssh/sshd_config
PermitRootLogin no
```

???
- Restart the service, then try to connect a new terminal as root

---

class: content-even tinycode

# SSH

- Limit number of sign-ins
 - Slow down brute force attempts

```bash
# vi /etc/ssh/sshd_config
MaxAuthTries 3
```

???

- We set it to 3 as some ssh clients will always try to login with an ssh key first.
- Reset the service and try it out :-)

---

class: content-even tinycode

# SSH

- Change default port

```bash
# vi /etc/ssh/sshd_config
Port 2002
```

???

- Restart the service, and try to login on port 22 - should be rejected


---

class: content-even tinycode

# SSH

- Restrict who can login
 - Useful if you have system users for other services who should't have SSH access

```bash
# vi /etc/ssh/sshd_config
AllowUsers liam
```

???

- Create a test user (who isn't on the list, and try to login with them)

---

class: content-even

# SSH

- No matter what we do, passwords tend to be weak, and are susceptible to brute force
 - Using key-based authentication removes these problems
- The issue is that someone with access to your computer has your private key
 - But this can be mitigated by using a passphrase on the key

---

class: content-even

# SSH

- We generate the key on our local machine - for Linux/Mac:
```bash
ssh-keygen
```
- For Windowsm PuTTY comes with a PuTTYgen tool
 - Key Type: SSH-2 RSA

- Follow the steps, make sure you save the private key on your machine

---

class: content-even noheader

- Copy the public key into your clipboard

- On the server (logged in as the user you are securing):
```bash
# vi ~/.ssh/authorized_keys
# chmod -R 600 ~/.ssh/
```
- Paste the public key onto a new line
- Only allow key based authentication:
```bash
# vi /etc/ssh/sshd_config
PasswordAuthentication no
```

???

Make sure you test your ssh key before you disable password login - if you don't and it doesn't work, you'll be locked out!!!

---


class: content-odd

# Apache

- Disable unwanted HTTP Methods
- Enable SSL
 - Only allow TLS encryption
 - Generate Unique DH Group
 - Disable weak ciphers
- PHP SetHandler vs AddHandler
- Disable ServerSignature and ServerTokens
- Disable FileETag
- Install mod_security

???

- By default, apache can be quite 'open' - both in terms of things that could be useful to an attacker, and things that are not security holes in themselves, but could be used to find out more information about the system

---

class: content-odd noheader

- Disable unwanted HTTP methods
 - HTTP methods are not a vulnerability in themselves, but could leave expliots available
 - Simplest way is to do a re-write - may need to be done for any vhosts you are runnings

```bash
# vi /etc/httpd/conf/httpd.conf

RewriteEngine On
RewriteCond %{REQUEST_METHOD} !^(GET|POST|HEAD)
RewriteRule .* - [R=405,L]

```

---

class: content-odd noheader

- Enable SSL
 - We are going to install mod_ssl for apache, and generate a free SSL certificate
```bash
# yum install mod_ssl
```
- The easiest way to install a LE certificate is using Certbot
 - Different methods depending on OS and server
 - Check out https://certbot.eff.org/

---
class: content-odd noheader

```bash
# cd ~
# wget https://dl.eff.org/certbot-auto
# chmod a+x certbot-auto
# ./certbot-auto --apache
```

---

class: content-odd noheader tinycode
- Only allow TLS encryption
 - Older encyption methods have various vulnerabilities

```bash
# vi /etc/httpd/conf.d/ssl.conf
SSLProtocol -all +TLSv1 +TLSv1.1 +TLSv1.2
```
- Generate unique DH group
 - The default DH group can be insecure

```bash
# openssl dhparam -out /etc/pki/tls/dhparams.pem 2048
# cat /etc/pki/tls/dhparams.pem >> /etc/letsencrypt/live/phptek1.w.iltshi.re/cert.pem
```


???
- Moreso on nginx - was part of the reason for the logjam issue

---

class: content-odd noheader tinycode
- Disable weak ciphers
 - A number of older ciphers have been proven to be weak or compromised, but are supported in default configurations

```bash
# vi /etc/httpd/conf.d/ssl.conf
SSLCipherSuite ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-ECDSA-AES128-SHA:ECDHE-ECDSA-AES256-SHA:ECDHE-ECDSA-AES128-SHA256:ECDHE-ECDSA-AES256-SHA384:ECDHE-RSA-AES128-GCM-SHA256:ECDHE-RSA-AES256-GCM-SHA384:ECDHE-RSA-AES128-SHA:ECDHE-RSA-AES256-SHA:ECDHE-RSA-AES128-SHA256:ECDHE-RSA-AES256-SHA384:DHE-RSA-AES128-GCM-SHA256:DHE-RSA-AES256-GCM-SHA384:DHE-RSA-AES128-SHA:DHE-RSA-AES256-SHA:DHE-RSA-AES128-SHA256:DHE-RSA-AES256-SHA256
```
- https://goo.gl/ujdHdI

???
- It goes on a bit - I'd never recommend you try to remember all the ciphers yourself. SSLLabs provide a good list
---
class: content-odd tinycode
- SetHandler vs AddHandler
 - Apache has two ways of handling scripts
 - AddHandler defines a handler based on an extension
 - SetHandler defines a single handler for a request
- /notanimage.php.jpg
```bash
# vi /etc/httpd/conf.d/php.conf
<FilesMatch \.php$>
    SetHandler application/x-httpd-php
</FilesMatch>
```
???

The problem comes that apache will recognise multiple externsions
 - Check the url /notanimage.php.jpg to see what I mean!
 - This could be a security vulnability
  - Swapping Handler means we can create a rule that only loads the php handler if the file ends with .php
---
class: content-odd tinycode noheader
- Disable ServerSignature and ServerTokens
 - Can might provide useful information to an attacker
```bash
# vi /etc/httpd/conf/httpd.conf
ServerSignature Off
ServerTokens Prod
```
- Disable FileETag
 - ETag exposes information like inode number, MIME boundary, child process
```bash
# vi /etc/httpd/conf/httpd.conf
FileETag Off
```
???

Disabling ETag is required for PCI compliance

---
class: content-odd tinycode noheader
- Install mod_security
 - mod_security is a WAF that helps protect against common attacks
 - It's designed to allow you to create your own rules, but comes with some default rules that we will use
- /shell.php?user=<?php echo "hi"; ?>

```bash
# yum install mod_security
```

???
That's the easy bit - by default there are no rules, so we need to fetch all the rules, and set it up!



---
class: content-odd  noheader
```bash
# mkdir /etc/httpd/modsecurity.d/available-rules
# cd /etc/httpd/modsecurity.d/available-rules
# wget https://github.com/SpiderLabs/owasp-modsecurity-crs/archive/v3.0.2.tar.gz
# tar -zxf v3.0.2.tar.gz
# cd owasp-modsecurity-crs-3.0.2/
# mv crs-setup.conf.example /etc/httpd/modsecurity.d/mod_security_crs.conf
# ln -s /etc/httpd/modsecurity.d/available-rules/owasp-modsecurity-crs-3.0.2/rules/* /etc/httpd/modsecurity.d/activated_rules/
```

- The default rules will protect against common attacks, such as SQL injection, large post bodies, JS in the query string etc.

???

Download the core rules, use the core setup file
 - We will link all the rules into the activated_rules directory
 - Note, there a couple of rules that do not work, depending on your config
 - Attempt to restart apache, then remove the rule/rules it complains about

---

class: content-even

# mySQL

- Use `mysql_secure_installation`
 - This will take you through some 'good practise' steps - setting passwords, removing remote access etc
- Limit connection attempts - `max_connect_errors = 5`
- Disable local infile
 - By default, `LOAD DATA LOCAL` can be used to read DB files:

---

class: content-even

```sql
CREATE TABLE `exploit` (`path` longtext);
LOAD DATA LOCAL INFILE '/etc/passwd'
  INTO TABLE exploit;
SELECT * FROM exploit;
```
---

class: content-even noheader tinycode

```sql
+----------------------------------------------------------------------+
| path                                                                 |
+----------------------------------------------------------------------+
| root:x:0:0:root:/root:/bin/bash                                      |
| bin:x:1:1:bin:/bin:/sbin/nologin                                     |
| daemon:x:2:2:daemon:/sbin:/sbin/nologin                              |
| adm:x:3:4:adm:/var/adm:/sbin/nologin                                 |
| lp:x:4:7:lp:/var/spool/lpd:/sbin/nologin                             |
| sync:x:5:0:sync:/sbin:/bin/sync                                      |
| shutdown:x:6:0:shutdown:/sbin:/sbin/shutdown                         |
| halt:x:7:0:halt:/sbin:/sbin/halt                                     |
| mail:x:8:12:mail:/var/spool/mail:/sbin/nologin                       |
| uucp:x:10:14:uucp:/var/spool/uucp:/sbin/nologin                      |
| operator:x:11:0:operator:/root:/sbin/nologin                         |
| gopher:x:13:30:gopher:/var/gopher:/sbin/nologin                      |
| apache:x:48:48:Apache:/var/www:/sbin/nologin                         |
| mysql:x:27:27:MySQL Server:/var/lib/mysql:/bin/bash                  |
| clam:x:498:498:Clam Anti Virus Checker:/var/lib/clamav:/sbin/nologin |
+----------------------------------------------------------------------+
```
---

class: content-even

```bash
# vi /etc/my.conf

local-infile=0
```

???

---

class: content-even

# SELinux

- All too often, usrs disable SELinux as soon as it starts causing problems - Don't!!
- TL;DR - SELinux maintains access and transaction rights between users, processes and files
- Helps prevent applications accessing files they shouldn't, or executing things they shouldn't
 - SELinux uses the least-privilege model - everything is denied by default, and then exceptions are made

---

class: content-even

# Configuring SELinux

- First, we need to enable SELinux and reboot
```bash
# vi /etc/selinux/config
SELINUX=enforcing
```


???
Rebooting takes a few minutes:
- The usual reason - service has one context, trying to access files from nother context
 - Services are installed with default rules, but to work outside those rules you need to add exceptions
 - Common one is vhosts in the /home directory
---

class: content-even noheader tinycode

```bash
# ps axZ | grep httpd
# ls -lahZ /home/test/
# ls -lahZ /var/www/html
# yum install policycoreutils-python
# semanage fcontext -a -t httpd_sys_content_t "/home(/.*)?"
# restorecon -Rv /home
# ls -lahZ /home/test/
```

???

You can find out the context  of a service, and the context of files using -Z
 - If they are not part of the same domain, the service cannot access them!
 - To fix this, we need to update the context of the files - this required a new tool
 - We set the context, then 'restore' (so that it matches the new rules)
 - If we check again now, the context is updated

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

---

class: content-odd

# Port/Source Restriction

- If you don't need access to a port, then don't allow access!
 - Combine this with component restrictions - if you have an admin application, a non-default HTTP IP can be restricted to known IPs
- If you have access to a network-level firewall, that's preferable
- If not, use IPTables
- Don't just lock down ports, lock down ports to IP addresses

---

class: content-odd noheader tinycode

.center[![](security/images/task.png)]

- Configure IPTables to allow:
 - Access to established connections
 - Global access to HTTP/HTTPS
 - Single-IP access to SSH

???

---

class: content-odd noheader tinycode

```bash
# iptables -L
# iptables -A INPUT -m state --state ESTABLISHED,RELATED -j ACCEPT
# iptables -A INPUT -p tcp --dport 80 -j ACCEPT
```
- To specify a specific source, use `-s` - This can take a /mask
```bash
# iptables -L
```
- We need to deny everything else! (But first, we need to accept everything local!)
```bash
# iptables -L --line-numbers
# iptables -I INPUT 1 -i lo -j ACCEPT
# iptables -A INPUT -j DROP
```

???
- Explain
- So, do the same for port 443, and then the same for port 2002, but with a source set
- Explain line numbers, inserting, and dropping

---

class: content-even

# Frequency of access restriction

- If you know there is never a reason for more than 30 requests a second to a section of your network, then don't alow more!
 - Mod_evasive is an apache module designed to apply basic rate limiting to your web-server
```bash
# yum install mod_evasive
# vi /etc/httpd/conf.d/mod_evasive.conf
```
- Out of the box the settings are ok
 - Suggest setting up email notifications
 - Consider the per-page setting - in our modern world of AJAX, is 2 requests a second sufficient?


???

Play with some settings, and test it out :-)
There is a test script in vi /usr/share/doc/mod_evasive-1.10.1/test.pl that you can use

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

- Attackers with very fast (or lots of) machines can simply try every password until they find the right one
- This hits you in two ways - potentially they can find your password, and the continuous requests also act as a semi-DDOS

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

```bash
# yum install fail2ban
# chkconfig fail2ban on
```

???

---

class: content-odd

# Creating Filters

- Filters are stored in /etc/fail2ban/filter.d/
- Create a filter that checks for users trying to access shell.php
 - `<HOST>` - a pre-defined group that matches the host (IP or hostname) that will be banned
 - Failban will automatically detect/match the timestamp

```bash
# vi /etc/fail2ban/filter.d/phpshell.conf
```

???

- There a lots of different example filters already available - some of which you might use out of the box
 - The key points are to have a failregex -  this is the expression (or expresions which trigger a fail), and an ignoreregex that can contain patterns that should be allowed to pass (your own IP for example)
 - Take a look at php_url_fopen.conf for inspiration

---

class: content-odd tinycode

```regex
[Definition]
failregex = ^<HOST> -.*(GET|POST).*?/shell\.php(\?.*?)? HTTP\/.*$
ignoreregex =
```

- Now we can test it - as long as we have a log file with an entry to match!

```bash
# fail2ban-regex /var/log/httpd/access_log /etc/fail2ban/filter.d/phpshell.conf
```

???

- It's useful to be able to test your paterns - fail2ban has a tool for this
- First of all, hit the shell script on your box to create a rule in your apache log file if you haven't already.


---

class: content-even

# Available Actions

- Actions are stored in /etc/fail2ban/actions.d/
- Probably little need to create new ones (unless you want to integrate with external APIs etc)
- Review the existing actions - we are going to use dummy to test

???

- We are doing to use the dummy action - this just writes actions to a file. In real life, you'd probably use the iptables or iptables-allports actions

---

class: content-odd noheader

# Creating Jails

- Jails are stored in /etc/fail2ban/jails.d/*.local
- Create a jail for our filter that blocks for 1 hour
 - `filter` - the filters to use
 - `action` - the action (or actions) to take
 - `logpath` - which logs to scan
 - `maxretry` - Number of matches to trigger action
 - `findtime` - The length of time to find `maxretry` matches
 - `bantime` - How long a ban should last

???

- You can have as many jails as you like
- Some of the pre-built jails are quite confusing, but do take a look to get an idea

---

class: content-odd noheader tinycode

```bash
# vi /etc/fail2ban/jail.d/phpfilter.conf

[phpfilter]
enabled=true
filter=phpshell
action=dummy
logpath=/var/log/httpd/access_log
maxretry=1
findtime=10
bantime=3600
```

---
class: content-odd

- Now let's test it:
 - Start fail2ban `service fail2ban start`
 - `tail -f /var/run/fail2ban/fail2ban.dummy`
 - Hit the shell with your browser


---
class: content-even
# Test Regularly

- It's good to have some forms of benchmark on how will secured your platform is
 - You could perform lots of manual tests, but there is a good chance something will get overlooked
- There are a number of audit tools available - my preferred one is lynis
 - https://cisofy.com/lynis/

---
class: content-even

```bash
# cd ~
# wget https://cisofy.com/files/lynis-2.5.0.tar.gz
# tar -xzf lynis-2.5.0.tar.gz
# chmod +x lynis/lynis
# cd lynis
# ./lynis audit system
```

???
- Run lynis - you might bb interested to know that the start box had a score of just 10!!
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
