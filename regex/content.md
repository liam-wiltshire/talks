
class: title-slide

.conference[![](logos/%%conference%%.png)]
.introimg[![](regex/images/magnifyingglass.png)]

# RegEx
## is your friend

???
- RegEx is a funny old thing - for some developers, mentioning the words Regular Expressions generates a noise more usually heard fromr motor mechanics - (suck in teeth, tut, cost you...)
- Why, why the sucky-iny noise?
- Well, it's hard to maintain isn't it, well, it's slow

However, this doesn't have to be the case - treated well, RegEx can be a powerful tool in your toolbox

Yes, there are alternatives, and sometimes these will do the job better than regular expressions could (more on that below), but often a regular expression is the right tool for the job.


---

class: section-title-c bottom left vanity-slide

.introimg[![](http://tebex.co.uk/img/tebex.svg)]

# Liam Wiltshire
## Senior PHP Developer<br /> & Business Manager

---

class: vanity-cover

background-image: url(logos/mcft.png)

---

class: section-title-a middle center

>  Some people, when confronted with a problem, think
>  "I know, I'll use regular expressions."
>
>   Now they have two problems.

<small style="float:right;font-size:20px;">Jamie Zawinski, 1997 (sort of)</small>

???

This is a quote that does get banded about - however it's actually based on an even older quote about awk
Even then it's taken out of context - rather think of it as saying it's the overuse of RegEx that could be a problem - there is a time and a place

---

class: section-title-b middle halfhalf
background-image: url(regex/images/qbert.png)

# What Are
# Regular
# Expressions?

---

class: summary-slide middle

- Regular Expression (RegEx) are patterns used to match strings of text
- Work similar to wildcards, but with a lot more power to specify exactly what you want to match
- Global - most OSes, Programming Languages, DBMSes etc have some RegEx support

---

class: section-title-a middle halfhalf reverse
background-image: url(regex/images/usesofregex.png)

# What Can
# We Use
# RegEx For?

???

While it's easy to find plenty of examples of regular expressions in use, and it's easy to list all sorts of things they can be used for, most uses boil down to one of the following:

---

class: section-title-b center centralimg

#Data Validation

&nbsp;

![](regex/images/datavalidation.png)

???

If you are handing user data, you almost certainly want to check that the data matches what you are expecting - that if you've asked for a phone number then the user has entered a phone number, or that you're not about to add 'Little Bobby Tables' to your database https://xkcd.com/327/. Checking user provided data (for example from a form, or $_SERVER variables that the user could have spoofed) against a regular expression pattern that matches the format you are expecting can be a very effective way of validating data you receive. Equally a regular expression can be used to validate that some data doesn't contain something - for example checking that the bio that the user has provided doesn't contain HTML if you don't want it to.

---

class: section-title-c bottom left vanity-cover

background-image: url(regex/images/textreplacement.png)

# .left[Text]
# .left[Replacement]

???

Find and replace is a tool that most of us use regularly. That could be in your OS (for example sed), in your email client or word processor, amongst many other things. Regular expressions are often used (including in sed mentioned above) to allow you to do text replacement when you don't know the exact text you want to replace. For example, if you want to strip out HTML from some text (where you might not know what the tags are), or you want to strip all URLs out of a posted comment (where you don't know what the URL might be). The key benefit of regular expressions here is the unknown bit - you can replace based on text that 'looks like' something, rather than requiring an exact match.

---

class: section-title-a bottom center centralimg

![](regex/images/textextraction.png)

# Text Extraction

???

In our jobs, we tend to deal with alot of data manipulation. Hopefully all your data is well formatted, structured and easy to deal with... 

Regular expressions can be used to extract a block of text from within a larger block, by using simple patterns.

For example, if you work for a spam.... I mean, email marketing company...
Want to sell your viagra and let people know about Nigerian princes, this is the tool for you

---

class: section-title-b center centralimg

# Pattern Matching/Configuration

&nbsp;

![](regex/images/configuration.png)

???

If you've ever had to set up redirects on a web server (be that Apache or NGINX), you've probably had to work with regular expressions. Many different servers use regular expressions as a test for conditional rules, such as IP address matches, or partial URL matches, user agent matches etc. Understanding how regular expressions work makes this process substantially easier!

---

class: section-title-a

```php

    protected static $_tokens = array(
        "/^(root)/" => "T_ROOT",
        "/^(map)/" => "T_MAP",
        "/^(\s+)/" => "T_WHITESPACE",
        "/^(\/[A-Za-z0-9\/:]+[^\s])/" => "T_URL",
        "/^(->)/" => "T_BLOCKSTART",
        "/^(::)/" => "T_DOUBLESEPARATOR",
        "/^(\w+)/" => "T_IDENTIFIER",
        "/^\$(\w+)/" => "T_VARIABLE",
    );

```

---

class: section-title-c halfhalf reverse middle

background-image: url(regex/images/yesterdayregex.png)

# When Shouldn't
# We Use
# Regular Expressions?

???

Wait, so an article about regular expressions is telling us not to use regular expressions? As with anything in PHP (or even PHP itself), it is only one tool in your arsenal, and as always it's a case of using the right tool for the job - there are certainly alternatives to regular expressions, and they may do a better job in some situations.

---

class: content-even

# Simple String Replacements

- Most programming languages have built in string replacement functions
- If you are trying to replace a fixed string, these are almost always going to be quicker
- Obviously if your string contains unknowns, then this isn't an option

???

This goes for most situations - if there is a built in alternative, then there is probably a good reason to use that!!
Certainly something that is built in will usually be faster, and it means you don't need to maintain it!

---

class: content-odd

# Data Validation Libraries

- In alot of languages there are either built in methods of libraries for basic data validation
- Sometimes there will be performance benifits if they do things in an optimised way
- Otherwise, why not let the library maintain the expressions for you?

???

For example, filter_* functions in PHP or Fluent in .NET
If your validation is on 'standard' types - emails, URLs etc, then built in or existing libraries will usually cover these
Looking at emails as an example, there is a regular expression for validating RFC 822 email addresses which is over 6,000 characters long (seriously!). While no-one would recommend using that expression in practice, any shorter ones result in tradeoffs between what is practical, and the 'official' rules on what an email address can be
The argument here is similar to the above - if there is something available that will be faster, or mean that you don't need to maintain the RegEx, then use it!

---

class: section-title-a top center

# RegEx 101

![](regex/images/regex101.jpg)

---

class: content-even

#RegEx 101

- Regular Expressions are massively powerful
- We will work through a few common examples
    - Validating a phone number
    - Replacing images in markdown
    - Extracing data from a webpage

---

class: content-odd

# Phone Number

- Simple example, we are validating input of a UK mobile number
- 07123 456789, +44 7123 456789 with or wthout space

```regexp
^(\+44( )?|0)7[0-9]{3}( )?[0-9]{6}$
```

---

class: content-odd

```regexp
^(\+44( )?|0)7[0-9]{3}( )?[0-9]{6}$
```

- `^...$` is the string anchor (must start and end)
- `(\+44( )?|0)` Either +44 (optionally with a space), or the number 0
    - `[\^$.|?*+()` are reserved characters
- `7` - a single number 7
- `[0-9]{3}` exactly 3 numbers between 0-9
    - `{3,6}` would mean between 3 and 6

---

class: content-even

# No Images Please!

- Can't use a string replace as we don't know the specific image or alt will be

```perl
$text =~ s/!\[.*?\]\(.*?\)/"NO IMAGES ALLOWED!"/sg;
```

---

class: content-even

```regexp
/!\[.*?\]\(.*?\)/sg
```

- The forward slashes mark the start and end of the pattern
    - With some flags which we'll come to
- `.*?` - match 0 or more of any character (except newlines *usualy*)
    - The `?` makes it lazy
    
---

class: content-odd

#Flags

- There are a number of flags available that modify the behaviour of RegEx
    - Some of these vary between different RegEx flavours
- The common ones are
    - `i` - case insensitive
    - `s` - `.` character matches everything (includes newlines)
    - `g` - global
    
???
- The s flag we used in our expression means that the script can be on multiple lines
- Global is handled by different functions in some languages (e.g. PHP), but is needed in others (e.g. JS)

---

class: content-even

#Extracting Data

- As well as testing/replacing data, RegEx is useful for extracting data
- In this example, we are going to extract the temperature from a location page on Accuweather

???
- Specifically, my hometown of Nottingham

---

class: content-even

#Extracting Data

- Checking the source code of the page, we can see the temperature is displayed with `<span class="temp">12&deg;</span>`
- This means we have a predictable pattern we can use to get the temperature
- We can fetch the contents of the page, and then extract the content we need

---

class: content-even

```php
$data = file_get_contents(
  "http://www.accuweather.com/en/gb/nottingham/ng1-7/weather-forecast/330088"
);

preg_match_all(
  "/<span class=\"temp\">(-?[0-9]+)&deg;<\/span>/i",
  $data,
  $matches
);

var_dump($matches);
```

???

- Notice how we are not using start and end anchors this time - we are matching content within a larger piece of text.
- This also uses a new symbol - the + character. Similar to *, this matches one or more, instead of 0 or more.

---

class: content-even

```
    array(2) {
      [0]=>
      array(4) {
        [0]=>
        string(29) "<strong class="temp">13<span>"
        [1]=>
        string(29) "<strong class="temp">24<span>"
      }
      [1]=>
      array(4) {
        [0]=>
        string(2) "13"
        [1]=>
        string(2) "24"
      }
    }
```

???

- Notice how we have both the full match, but also the part of the pattern we enclosed in brackets is extracted seperately.
- If we had multiple groupings, each one would be extracted separately

---

class: section-title-b top center

# RegEx 102

&nbsp;
### What regex are you most likely to see at Christmas?

## [^L]

---

class: content-odd

#Performance

- Regular Expressions can be quite complicated to process and execute
- Often what appears to be a simple expression can take lots of 'steps' to test
- We need to understand and test the execution of our expressions to ensure they perform well

---

class: content-odd center middle

```regexp
(.*?)!
```
---

class: content-odd
# (.*?)!

- If we test this against the string "I really like PHP!"
    - It will take 39 steps to match the whole string!
    
![](regex/images/regexsteps.png)

???

- This is because the * (0 or more) will 'give back' content to try to satisfy the pattern in as few as characters a possible
 - These backtracks can be expensive in terms of requiring alot more steps

---

class: content-odd

- Where possible, avoid using matchall
    - Be as specific as possible in your regex, so that the work the engine needs to do is reduced.
- But what if you can't? What if you need to match everything?
    - First of all, try to use + instead of *
    
???

Where * is 0 or more, it involves a few more tests than + does, which must match at least once


---

class: content-even center middle

```regexp
([^!]+)
```
---

class: content-even
# ([^!]+)

- This is a negative character class
    - We are basically definine a match rule that matches anything *except* !, one or more times
- Negative character classes are typically quicker and use less steps than a similar positive character class

???

It also means we don't need to use the lazy ? as it will automatically stop at the first !, so generally it's a much tigher expression.

---

class: middle center content-even

![](regex/images/negative.png)

---

class: content-odd

#Data Capture

- We use brackets to group our expressions
    - The engine will also return the matched data of each group as separate parts
- However, if you have lots of groups, you are probably returning plenty of data that you don't actually need!
    
???

As we saw in the weather example

---

class: content-odd

- Let's assume we want to extract the filename and filesize from a *nix `ls -lah` command

```
drwxrwxr-x.  3 liam liam 4.0K May 29 21:00 .
drwxrwxr-x. 12 liam liam 4.0K May 26 15:43 ..
-rw-rw-r--.  1 liam liam  20K May 29 21:00 content.md
drwxrwxr-x.  2 liam liam 4.0K Dec  7 14:44 images
```

```regexp
([0-9\.]+[MKG])\s+([a-zA-Z]+)\s+([0-9]+)\s([0-9:]+\s+)([^\n]+)
```

???

- This would extract the data we want, but also various bits of data we don't need - by default groups in RegEx are 'capturing'

---

class: content-odd tinycode
#Non-Capturing Groups

- We can use ?: at the start of a group to make it non-capturing:

```regexp
([0-9\.]+[MKG])\s+(?:[a-zA-Z]+)\s+(?:[0-9]+)\s(?:[0-9:]+\s+)([^\n]+)
```

???

-This doesn't reduce the number of steps needed, but will reduce the memory required to store the data

---

class: content-even
#<del>Don't</del> Be Lazy

- Regular expressions are greedy by default. 
- If we consider the pattern `(.*)PHP` and the string "I really like PHP, but I also like Perl", 
    - It requires 108 steps. 
    - Adding ? to make the matchall lazy doesn't change the result, but brings it down to 84 steps
    
---
class: content-even
#Lazy Is Good (Sometimes)
- With a greedy selector, the engine has to check every character position to the end of the string in order to ensure that PHP doesn't appear again
- Making the match lazy however means it can stop as soon as it hits the first PHP string, saving these additional lookups.

???

We can see that PHP doesn't appear again, but the engine doesn't know that without checking every character.

---

class: section-title-c middle center

# RegEx
# `/(?![02-9])\d[^a-z](?<![1-9])\063/`

---

class: content-odd
#Atomic Groups

- A cause of slowdowns can be multiple options in a match
- Consider `\b(package|packed|pack)\b`
- If we consider the phrase "Delivery rejected - badly packaged", a RegEx engine will take 27 steps to figure out there isn't a match
    - The engine has to test every variation in the group and then test if it satisfies the word boundaries

???

- In RegEx, `\b` is a word boundary - in other words we are matching a whole word
- In other words, we want to match the extact word package, or packed, or pack

---

class: content-odd
#Atomic Groups

- Atomic groups allow use to tell the engine to skip the rest of the group as soon as a match is found
- If we consider `\b(?>package|packed|pack)\b`, this brings the number of steps down to 16
    - The engine will match 'package' to the string
    - It will then ignore the other options - the boundary test will still fail, but it won't try packed or pack

???

- The ?> is the atomic group operator
- We are essentially telling the engine that if the first option is matched, then the other two can't possibly be better options
 - If you remember back to when we mentioned the + and * would 'give back' characters, this is the same thing - by default each 'failed' match will then give those characters back to try the next option - the atomic group means that they won't be given back

---

class: content-odd
#Atomic Groups

- The sequence of the options is important
- Consider `\b(?>pack|packaged|packed)\b`
    - With the previous string, 'packaged' would be a match
    - The engine would match 'pack', forget about the other options, and would fail the word boundary test
- \b(?>packaged|packed|pack)\b fixes this

???

- As a general rule, putting the options in length order ensures your atomic groups will behave as you expect
- As a side note, atomic groups are non-capturing - in other words they don't return the match within the group, in the same way as ?: above

---

class: content-even
# Conditionals

- RegEx supports conditionals, alowing you to define different patterns depending on a certain condition
- Combined with lookaheads, it can make life much easier!
- The general pattern for a conditional is

    `(?(Condition)Then|Else)`

???
Lookaheads - which allows you to check for something later in the subject string first
We've got a nice simple example to show this

---

class: content-even
#GB/US Postal Code

```regexp
(?
 ? (?=.*GB)
 ? ([A-PR-UWYZ]([0-9]{1,2}|([A-HK-Y][0-9]|[A-HK-Y][0-9]
    ? ([0-9]|[ABEHMNPRV-Y]))|[0-9][A-HJKPS-UW]) ?
    ? [0-9][ABD-HJLNP-UW-Z]{2})
 ? |
 ? ([0-9]{5})
)
```

???

Ok, let's take this one step at a time

---

class: content-even
#GB/US Postal Code

```regexp
* (?
 ? (?=.*GB)
 ? ([A-PR-UWYZ]([0-9]{1,2}|([A-HK-Y][0-9]|[A-HK-Y][0-9]
    ? ([0-9]|[ABEHMNPRV-Y]))|[0-9][A-HJKPS-UW]) ?
    ? [0-9][ABD-HJLNP-UW-Z]{2})
 ? |
 ? ([0-9]{5})
* )
```

???

This shows that the group is a conditional

---

class: content-even
#GB/US Postal Code

```regexp
(?
* ? (?=.*GB)
 ? ([A-PR-UWYZ]([0-9]{1,2}|([A-HK-Y][0-9]|[A-HK-Y][0-9]
    ? ([0-9]|[ABEHMNPRV-Y]))|[0-9][A-HJKPS-UW]) ?
    ? [0-9][ABD-HJLNP-UW-Z]{2})
 ? |
 ? ([0-9]{5})
)
```

???

- This is the condition - this is a lookahead that means we are looking for GB
- So, if we find GB, then we will look for the first pattern

---

class: content-even
#GB/US Postal Code

```regexp
(?
 ? (?=.*GB)
* ? ([A-PR-UWYZ]([0-9]{1,2}|([A-HK-Y][0-9]|[A-HK-Y][0-9]
*    ? ([0-9]|[ABEHMNPRV-Y]))|[0-9][A-HJKPS-UW]) ?
*    ? [0-9][ABD-HJLNP-UW-Z]{2})
 ? |
 ? ([0-9]{5})
)
```

???

- This matches a British postcode
- Trust me, it just does :-)

---

class: content-even
#GB/US Postal Code

```regexp
(?
 ? (?=.*GB)
 ? ([A-PR-UWYZ]([0-9]{1,2}|([A-HK-Y][0-9]|[A-HK-Y][0-9]
    ? ([0-9]|[ABEHMNPRV-Y]))|[0-9][A-HJKPS-UW]) ?
    ? [0-9][ABD-HJLNP-UW-Z]{2})
* ? |
 ? ([0-9]{5})
)
```

???

- If the lookahead didn't find GB

---

class: content-even
#GB/US Postal Code

```regexp
(?
 ? (?=.*GB)
 ? ([A-PR-UWYZ]([0-9]{1,2}|([A-HK-Y][0-9]|[A-HK-Y][0-9]
    ? ([0-9]|[ABEHMNPRV-Y]))|[0-9][A-HJKPS-UW]) ?
    ? [0-9][ABD-HJLNP-UW-Z]{2})
 ? |
* ? ([0-9]{5})
)
```

???

Look for a US zip code

---

class: content-odd
#Backrefernces

- Backreferences allow you to create a capturing group, and then use it later in the pattern
- In different situations, the syntax is different

---

class: content-odd
#Backreferences

```regexp
<([A-Z]+).*?>.+?<\/\1>
```

- This is a backreference in it's most basic form
- Each capturing group is numbered from 1 - 99

???

This example will match a HTML tag, the contents of that tag, and then the backreference to test for a matching closing tag

---



class: content-odd
#Backreferences

```regexp
^(?:(START)|(BEGIN))(.*?)(?(1)STOP|END)$
```

- By combining conditionals with backreferences, we can vary what we look for later in the expression based on what we saw earlier.

???

-This example assumes that you know that text is delineated by either START/STOP or BEGIN/END, but you don't know which.
-Depending on what is matched in the first group, it acts as a backreference in the conditional at the end

---

class: content-odd
#Named Backreferences

```regexp
(?P<msg>[0-9]+)\|(?P<dock>[0-9]+)\|
 ? (?P<tstamp>[0-9]+)\|DOOR (?P<doorstate>OPEN|CLOSED)
```

- By default, capturing groups are numbered.
- However by using ?P<name>, you can give each group a name

???

This is useful if you are matching quite a few pieces of data to be extracted and used elswhere in your application, without having to remember the numbers

---

class: middle center section-title-b

![](regex/images/free-bonuses.gif)

---

class: content-even
#The 'x' Flag

- In most modern RegEx flavours, there is an 'x' flag
- This makes the engine ignore whitespace
- *and* provide the ability to add comments with #

???

- Certainly, PHP, Perl, Python (using re.VERBOSE), .NET all support it

---

class: content-even

```regexp
/# Match a 20th or 21st century date in yyyy-mm-dd format
(19|20)\d\d                # year (19 or 20, then two digits)
[- \/.]                    # separator - one of dash, space, slash or dot
(0[1-9]|1[012])            # month (group 2)
[- \/.]                    # separator
(0[1-9]|[12][0-9]|3[01])   # day (group 3)
/x
```

---

class: summary-slide middle

- Regular expressions are a powerful tool in your toolbelt
- With great power comes great responsibility
- Understand how your expressions work, and how the engine will process them
- It's biggest benifit is portability - with a few exceptions, your expressions will work cross-language and cross-OS.

---

class: thanks-slide

.conference[![](logos/%%conference%%.png)]
.introimg[![](http://tebex.co.uk/img/tebex.svg)]

# Thank You

### %%joindin%%
### Liam Wiltshire
### @l_wiltshire
### liam@tebex.co.uk
