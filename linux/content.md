class: title-slide

.conference[![](logos/%%conference%%.png)]
.introimg[![](linux/images/cog.png)]

# Linux
## Sysadmin 101

???





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

- Linux is a massive topic, no way we can cover everything in 3 hours!
- This is very much a '101' session - a high-level introduction

---

class: summary-slide middle

- Different flavours of Linux
- The Linux CLI
- Common tools
- LAMP / LEMP setup
- Server troubleshooting
- Server performance monitoring

???

- Look at different flavours of Linux, and understand the differences of each
- Introduce the Linux CLI, and some common tools you will need to use
- Understand how to set up LAMP and LEMP stacks, including VirtualHosts and SSL
- Provide ways to troubleshoot a problem server
- Provide a guide on monitoring server performance

---

class: content-odd

# Connect To Your Server

- ssh madison00.w.iltshi.re
- user root
- pass madison2017

---

class: content-odd center middle

![](linux/images/putty.png)

---

class: section-title-b middle halfhalf reverse
background-image: url(linux/images/flavours.jpg)

# Flavours
# of
# Linux

???

-

---


class: content-odd

# Linux Flavours

<table>
<tr>
<td>
<h2>RPM</h2>
<ul>
    <li>RHEL, CentOS, Fedora</li>
    <li>httpd</li>
    <li>/var/www/html</li>
    <li>service</li>
    <li>vim</li>
    <li>root</li>
</ul>
</td>
<td>
<h2>Deb</h2>
<ul>
    <li>Debian, Ubuntu, Mint</li>
    <li>apache2</li>
    <li>/var/www/</li>
    <li>/etc/init.d/</li>
    <li>nano</li>
    <li>sudo</li>
</ul>
</td>
</tr>
</table>

---

class: content-even

# A Note On Security

- Often, 'fresh' servers come with direct root access via SSH
- You will find examples of these trying to be brute forces

.center[![](linux/images/logins.png)]

---

class: content-odd

# Security Considerations

- Disable root SSH access
- Use key-based authentication
- Be careful who has root access
- Add additional layers of security where possible
???

- Disable root SSH access
 - SSH Config, have personal logins then make use of sudo or su to gain root access
- Use key-based authentication
- Be careful who has root access
 - Both sudo and su have security concerns if used too freely
- Add additional layers of security where possible
---

class: section-title-c center

# Basic Linux Concepts

![](scaling/images/first-step.jpg)

???


---

class: content-even

# Users and Groups

- Everyone connects to a Linux (or other *nix) machine as a user
- A user can then be a member of one or more groups
- Users and groups are used to set controls for different aspects of the system (files, access to commands, ability to impersonate other users etc)

---

class: content-odd

# File Permissions

- Files are owned by a user and a group
- File permissions are then split into three parts:
 - What can the file user do
 - What can the file group do
 - What can everyone else do

---

class: content-odd

# File Permissions

- Each 'part' of the permission is represented by a number
- This is a sum of values that represent different actions:
 - 1 = execute (--x)
 - 2 = write (-w-)
 - 4 = read (r--)
- So for example you might have 744
- Or 666

---

class: content-odd middle center noheader

![](security/images/chmod.jpg)


---

class: content-even

# Shells

- When you connect to a Linux server, you are actually connecting to a piece of software called a shell
- The common ones are:
 - Bash (bash)
 - Bourne (sh)
 - Korn (ksh)
- Due to it's widespread availability, we are focusing on bash

---

class: section-title-a center

# Basic Linux Commands

![](linux/images/prompt.png)

???

---

class: content-even

# Filesystem Navigation

- Filesystem root - `/`
- Current Directory - `.`
- Parent Directory - `..`
- Home Directory - `~`

---

class: content-even

# Filesystem Navigation

- Change Directories - `cd`
```bash
cd /root/linux101
```
- List Directory Contents - `ls`
```bash
ls
```

---

class: content-even

# Filesystem Navigation

- Show Current Directory - `pwd`
```bash
pwd
```

---

class: content-even noheader

.center[![](security/images/task.png)]

# Find These Files
- File called linux101.txt within a directory called otherstuff in the home directory
- Find out what log files are available (logs are stored in /var/log)

---

class: content-odd

# Manual

- There are a huge number of commands on most servers
 - And lots of different flags (options)
- The manual is a system-based help guide that goes through all the different options

```bash
man ls
```

---

class: content-odd middle center

![](linux/images/manls.png)

???


---

class: content-even

# Text Editors

- vim
 - Default text editor in many situations for rpm-based Linuxes
 - Because it uses 'modes', it can take a little while to get used to

- nano
 - The other standard editor - slightly easier to use

---

class: content-even noheader

.center[![](security/images/task.png)]

Create a file in the home directory called "myfirstfile.txt" - add some content to it and save :)

???

If you pass a filename to nano or vi, when you save the first time it will create the file

---

class: content-odd
# Search Contents of Files

- Grep
 - Allows you to search within files for regular expressions
 - Allows for recursive search of files using the -r flag

```bash
grep -r "hello" ~
```

---

class: content-odd noheader

.center[![](security/images/task.png)]

- Search for the string "MadisonPHP" within any file in your home directory (case insensitive)
- Find a file that mentions a reward


???



---

class: content-even

# Find Files

- `find` allows you to search for files by a range of attributes:
 - Name
 - Modified Type
 - File Type

```bash
find /root/ -name "*stuff*"
```

---

class: content-even noheader

.center[![](security/images/task.png)]

- Find files that have been editied in the last day
- Find files that contain the word 'note' in their name (case **insensitive**)

???


---

class: content-odd

# Plumbing

- The Linux OS is made up of lots of little applications that do one job well
 - However, alot of the time you might need to perform multiple tasks - doing this one at a time would be horrible.
- Linux allows you to pass the output of commands around
---

class: content-odd

# Plumbing

- You can pipe the output of one command to another:

```bash
ls -lah | grep ".php"; #Only show php files
```

- You can also direct the output of a command to a file

```bash

ls -lah > dirlist.txt; #Write the directory list to dirlist.txt
ls -lah >> dirlist.txt; #Append to the file
```
---

class: content-odd noheader

.center[![](security/images/task.png)]

- Find files in ~/linux101 that are also .txt files
- Append the contents of ~/linux101/instructions.txt to ~/linux101/story.txt
 - HINT: To output the full contents of the file check out `cat`
 - Check the contents of the appended file

???


---
class: content-even
#Tail

- Return the end (or tail!) of a file
 - Great for checking logs - what is the flag for **f**ollowing the file?

---
class: content-even
#Tail

- Return the end (or tail!) of a file
 - Great for checking logs - what is the flag for **f**ollowing the file?

```bash
tail -f /var/log/dmesg
```
---

class: content-even noheader

.center[![](security/images/task.png)]

Get the last 5 lines of ~/linux101/bigfile.txt and append to ~/linux101/story.txt

???

---

class: content-odd

# Paging Files

- Particularly when working with log files or data exports, the file might be quite long
- Linux provides two main ways of paging files:
 - `more` - basic pager, only allows you to scroll down one line or one page at a time
 - `less` - more advanced, can scroll both up and down, jump down to a certain point

---

class: content-odd noheader

.center[![](security/images/task.png)]

- Find a file called ReallyLongFile.txt in the filesystem
- Page through it until you find the secret spy message (!)


???



---

class: content-even
# File Permissions

- As we've discussed, there are two different 'parts' to consider:
 - Who is the owner
 - What are the permissions
- You may find that you have files that you need to change who the owner is, or change permissions

---

class: content-even
# File Permissions

- Changing owner - `chown`
 - `chown root:root /root/linux101.sh`
 - Or shorter: `chown root. /root/linux101.sh`
- Changing permissions - `chmod`
 - `chmod 755 /root/linux.sh`
---

class: content-even tinycode noheader

.center[![](security/images/task.png)]

What if you want to change the mode or owner of a whole directory of files.

???

---

class: section-title-b  middle center


# Cron

![](linux/images/cronflakes.jpg)

???

---

class: content-even

# Scheduling Tasks with Cron

- Cron is what we use to schedule tasks in Linux (and other *nix) OSes
- This has a range of uses:
 - Log rotation
 - Running repeated tasks
 - System measurements etc.
- To write a scheduled task we use crontab (Cron Table)


???


---
class: content-even noheader

```bash
 *   *   *   *   *       /command/to/execute
 -   -   -   -   -
 |   |   |   |   |
 |   |   |   |   +------ day of week (0-6)
 |   |   |   +------ month (1-12)
 |   |   +------ day of month (1-31)
 |   +------ hour (0-23)
 +----- min (0-59)

```

---

class: content-even middle center

![](linux/images/cron_mail.png)


---

class: section-title-c  middle center


# Installing Packages

![](linux/images/installer.png)

???

---

class: content-even tinycode

# Yum

- Yum is a ultility for managing packages using the rpm package manager
- Like any package manager, this will look after your dependencies, avoid conflicts, and generally help you not screw up your system


???

- Alternatives - dnf (fedora, apt etc)

---

class: content-even

# Yum

- Install
- Update
- List
 - Looks at package names
- Provides
- Search
 - Looks at full meta data

---

class: content-even noheader center

.center[![](security/images/task.png)]

## How could you find out what php packages are available?

???

---
class: content-odd
# Where Are The Packages?

- Sometimes you might need to install something not in the default packages
 - It may be that you can add additional repos to provide that package
- Otherwise you may have to download and compile from source

---
class: content-odd
# Compiling from source

- Compiling from source can be different depending on what you are compiling, however the basic steps are the same:
 - Download the source code
 - Configure the options
 - (try to) Compile
 - Resolve dependencies
 - Compile again

---
class: content-odd
# Download the source

```bash
wget http://ftp.gnu.org/gnu/bc/bc-1.07.tar.gz
```

---
class: content-odd
# Extract the source
```bash
tar -zxf bc-1.07.tar.gz
```

---
class: content-odd
# Configuration

```bash
cd bc-1.07
./configure
```

---
class: content-odd
# Build tools
- Common build tools include:
 - make
 - cmake
 - gcc
 - cpp

```bash
yum install gcc cpp make cmake
```
---
class: content-odd
# Now?
```bash
./configure
make
```

- Not quite, but getting there :)
---
class: content-odd
# Rinse and repeat

- Find out the missing dependncies, work out what provides them and install
- Eventually, the install will work :)

```bash
make
make install
bc
```
---

class: section-title-a  halfhalf middle
background-image: url(linux/images/ilovelamp.jpg)

# LAMP


---

class: content-odd

# LAMP

- LAMP is our standard server stack:
 - Linux
 - Apache
 - MySQL
 - PHP

---

class: content-even

# Apache

- What is the Apache package called?
- In RPM based distros, the apache package is usually referred to as http*d* (http server daemon)
- In deb based distros, the apache package is usually called apache2

```bash
yum install httpd
```

???

---


class: content-odd

# mySQL

- Post Oracle, many distros no longer use mySQL
- They use a binary replacement (essentially a fork, perhaps with some changes)
 - MariaDB
 - Percona (not strictly a direct replacement)
- Make sure you understand the difference between mysql (the client) and mysqld (the server daemon)

---

class: content-odd noheader center

.center[![](security/images/task.png)]

## What package provides mysqld?

???

---

class: content-odd

#mysqld

```bash
yum provides */mysqld
```

```bash
yum install mariadb-server
```

???

- If you wanted to, most distros have a version of phpmyadmin in their repos as well... bleh
- Otherwisem you can install the mysql command line too to connect on the command line

---

class: content-even

# PHP

- PHP comes with a wide range of packages - not just the core, but all the other bits you may need
- What packages are available?
- We can install multiple packages using yum in one go:

```bash
yum install php php-gd php-xml php-mbstring php-pdo php-mysql
```

???

---

class: content-odd

# A note on package versions

- Look at the versions of software being installed, particulary httpd, php
 - What do you notice?

???

- Being enterprise, RHEL don't update major or minor versions during a release
 - THey do backport fixes, but it may not be fool-proof. The alterntaive is to install an alternative repo that contains up to date software

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

# Installing !== Running
- Just because we've installed the packages, that doesn't mean they are running
- If you tried to access the server in a browser you wouldn't get much
```bash
service [servicename] start
```

---
class: content-even

- The problem with service ... start is that it only starts it one time.
- You actually want to enable the service, so that it starts every time the maching boots


```bash
systemctl list-unit-files
```

```bash
chkconfig [servicename] on
```

---
class: content-odd

# PHP Config

- /etc/php.ini
- The standard setup is reasonable, but depending on your needs, you might need to change memory limites, short tags etc.
- Of course, as well as editing the ini, some settings can be changed in .htaccess or using ini_set()
- If you make a config change, you will need to restart apache
```bash
service httpd restart
```

???


---
class: content-even

# Apache Config

- Apache splits up it's config files into /etc/httpd/conf and /etc/httpd/conf.d
- This that you might want to change include ServerAdmin, MaxClients, ServerName
- One thing you'll almost certainly need to change is AllowOverrides

???

---
class: content-even noheader tinycode

```bash
vi /etc/httpd/conf/httpd.conf

<Directory "/var/www/html">
    #
    # Possible values for the Options directive are "None", "All",
   ...
    #
    Options Indexes FollowSymLinks

    #
    # AllowOverride controls what directives may be placed in .htaccess files.
   ...
    #
*    AllowOverride None

    #
    # Controls who can get stuff from this server.
    #
    Require all granted
</Directory>
```

???

---

class: content-odd

# mod_ssl

- All websites should be served over https
 - We are going to install mod_ssl, and generate a free cert
```bash
# yum install mod_ssl
```
- The easiest way to install a certificate is using Certbot
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

class: content-odd tinycode

# SSL Security
- Only allow TLS encryption
 - Older encyption methods have various vulnerabilities
- Generate unique DH group
 - The default DH group can be insecure
- Disable weak ciphers
 - A number of older ciphers have been proven to be weak or compromised, but are enabled by default

???
- Moreso on nginx - was part of the reason for the logjam issue

---
class: content-odd

# SSL Testing
- As with everything security, we should test regularly
- SSLLabs has a create testing tool that covers all the main bases.

---

class: content-even

# VirtualHosts

- Apache will let you have multiple hosted sites on one server, by using vhosts
- The most commond way of doing this is by name-based virtual hosting
- Name-based vhosts work by defining a server name (or a name and multiple aliases), and then giving their own document root.

???
- Used to also be done by IP, particularly for SSL, but isn't needed these days

---
class: content-even  noheader


```bash
NameVirtualHost *:80
NameVirtualHost *:443

<VirtualHost *:80>
    ServerName www.domain.tld
    ServerAlias domain.tld *.domain.tld
    DocumentRoot /var/www/html/domain
</VirtualHost>

<VirtualHost *:443>
    ServerName www.domain.tld
    ServerAlias domain.tld *.domain.tld
    DocumentRoot /var/www/html/domain
*    SSLCertificateFile /etc/pki/tls/certs/domain.crt
*    SSLCertificateKeyFile /etc/pki/tls/private/domain.key
</VirtualHost>
```

???
- Recommend to create a new .conf file in /etc/httpd/conf.d/ for vhosts on rpm - in debian they tend to go in the sites-available/ and sites-enabled/ directories


---

class: section-title-b  halfhalf middle reverse
background-image: url(linux/images/ilovelemp.jpg)

# LEMP


---

class: content-odd

# LEMP

- LEMP is an alternative server stack:
 - Linux ?
 - Nginx (I know, I know)
 - MySQL
 - PHP(-FPM)


---

class: content-odd noheader center


.center[![](security/images/task.png)]

## Install a LEMP Stack
### Good luck!

---

class: content-odd noheader

- Hints:
 - The packages are called nginx and php-fpm
 - You can't run httpd and nginx at the same time (on the same port)
 - Nginx doesn't invoke php directly - it passes everything it needs off to php-fpm as a separate server - You'll need to tell nginx how to do this
 - Nginx's default document root **isn't** /var/www/html
 - php-fpm is a service, so needs starting

---

class: content-odd noheader

You'll need to add the following within nginx's server block to tell it how to handle php:

```bash

location ~ \.php$ {
    root           html;
    fastcgi_pass   127.0.0.1:9000;
    fastcgi_index  index.php;
    fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
    include        fastcgi_params;
}

```

---

class: section-title-c halfhalf middle reverse
background-image: url(linux/images/logs.jpg)


# &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;Logs



---

class: content-even

# Logs

- When something goes wrong, the first place to check are the logs - lots of helpful hints!
 - Logs are usually stored within /var/log/
- Each searvice generates their own logs
- Log files can get quite long, so don't try to load the whole file in one go
 - What could we use?

---

class: content-even

# Tail

- We use tail to read the last few lines of a file
 - We can also follow the lice action in real time - as we reproduce an issue for example

```bash
tail -f /var/log/nginx/access.log

```

---

class: content-even

# Grep

- If we are looking for something specific within a log (e.g. a date, an ip address, a filename etc)

```bash
grep "22/Sep/2017" /var/log/nginx/access.log

```

---

class: section-title-a halfhalf middle reverse
background-image: url(linux/images/performance.jpg)

#Monitoring
#Performance

???

---

class: content-even

# What is Running


- Any computer is running a number of processes at any one time - OS process, web server etc
- Linux will let us get a list of currently running processes in a few different ways

---

class: content-odd

# ps

- ps provides a snapshot of the running processes at that point in time
- Can be combined with a number of flags (commonly aux to show all processes and who owns them)

```bash
ps aux
```

- If we want a specific process, what might we do?


???

---

class: content-even

# top

- top provides a real-time updating lists of processes and their resource consumption
- Useful for checkout for CPU bound processes, memory leaks etc

```bash
top
```


???
- show how to change sort

---

class: content-odd

# Bad Apples

- Logs, CPU usage and RAM are likely to point to problem processes
 - If you have a process that is causing issues, then you should try to diagnose the issue
 - If it is a one-off occurance however you may just need to terminate the process

```bash
kill [pid]
```
???
The pid, or process ID is the ID given to the process by the OS - you can get this from both top and ps
If a straightforward kill doesn't work, you can roll out the big guns - kill -9 [pid] - this forces the process to stop
---

class: content-even center

# Load Averages

![](linux/images/loadaverage.png)

Load averages always assume 1 processor/core

???

- In top, you will see load averages - but what do these numbers actually mean?
- An easy way to look at it, is using the traffic analogy
So, Bridge Operator, what numbering system are you going to use? How about:

0.00 means there's no traffic on the bridge at all. In fact, between 0.00 and 1.00 means there's no backup, and an arriving car will just go right on.
1.00 means the bridge is exactly at capacity. All is still good, but if traffic gets a little heavier, things are going to slow down.
over 1.00 means there's backup. How much? Well, 2.00 means that there are two lanes worth of cars total -- one lane's worth on the bridge, and one lane's worth waiting. 3.00 means there are three lane's worth total -- one lane's worth on the bridge, and two lanes' worth waiting. Etc.
---
class: content-odd

# Memory

- RAM usage is just as important to keep an eye on
- `free` allows you to identify the amount of memory being used
```bash
free -m
```
- This provides RAM usage both including and excluding buffers (paging files) and cache

???


---
class: content-even

# Disk

- Ok, so RAM and CPU are great, but running out of disk space can also cause just as many problems
 - You may want to see how much space is being used
 - You may also want to find out what is taking up so much space!!

---
class: content-odd

# df

- `df` shows the currently mounted filesystems, and how much space is left

```bash
df -h
```

???

 \-h is used in alot of contexts to mean 'human readable'

---
class: content-even

# du

- `du` will descent through your directory tree and report how much space is being used in each directory
 - By default it will return alot of records - and probably not be too helpful!
 - We can restrict how far it goes by using --max-depth (it still counts up below that, but doesn't display it)

```bash
du -h --max-depth=3 /var/www/
```

???
There are lots of options for du - for example printing out individual file sizes, just showing a total, showing inode use etc - see man!
I'll often combine it with grep to find directories that are using gigabytes of disk space to know what I need to clean up
---

class: section-title-b center

# Without needing to be awake 24/7

![](linux/images/sleepytux.png)



---

class: content-even

# Sysstat

- Sysstat will monitor the status of memory, cpu, disk throughput and more on a snapshot basis, and log this data for future analysis
- Systat comes with two different parts
 - `sa` - data collection
 - `sar` - data parsing and reporting

---
class: content-even noheader

.center[![](security/images/task.png)]

- Install sysstat
- Start the sysstat process (and set it to start on boot)
- Add a cron task to collect data every minute
 - root /usr/lib64/sa/sa1 1 1
- Add a cron task to generate a daily summary at 23:59
 - root /usr/lib64/sa/sa2 -A

---

class: content-even

# Sysstat

- Logs are stored in /var/log/sa/sa**
- Try using `cat` to read it.....
- Daily reports are stored in /var/log/sa/sar**, and these are readable
- But what if you want to check today's?

---

class: content-odd

# Sar

- Sar can be used to parse the log data for today, see the output for a previous day, and extract particular parts of the data:
 - By time - using start time (-s) and end time (-e)
 - Disk transfer (-b), (-d)
 - Network (-n)
 - CPU stats (-P)
 - Memory (-r)


---


class: summary-slide middle

# What Have We Covered?

- Basic Linux Concepts
- Basic Linux Commands
- Installing LAMP/LEMP
- Introduction to Security
- Logging and Performance Monitoring

---



class: thanks-slide

.conference[![](logos/%%conference%%.png)]
.introimg[![](http://tebex.co.uk/img/tebex.svg)]

# Thank You

### %%joindin%%
### Liam Wiltshire
### @l_wiltshire
### liam@tebex.co.uk
