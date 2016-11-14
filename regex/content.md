
class: title-slide

.conference[![](logos/%%conference%%.png)]
.introimg[![](regex/images/magnifyingglass.png)]

# RegEx
## is your friend

???

Regular expressions are scary. At least, if you ask Google, that's what you might think (500,000 results). And slow (1,460,000). For many developers they are something best avoided, something unmaintainable and difficult to understand. From personal experience, I've seen some amazing attempts to avoid using them - from 10 chained explodes to str_replaceing everything except the bits you need, piece by piece. However, this doesn't have to be the case - regular expressions are neither scary or slow, and indeed when used correctly are a powerful tool in your utility belt.

Yes, there are alternatives, and sometimes these will do the job better than regular expressions could (more on that below), but often a regular expression is the right tool for the job.


---

class: section-title-c bottom left vanity-slide

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

In our jobs, we tend to deal with alot of data manipulation. Hopefully all your data is well formatted, structured and easy to deal with... but let's face it, everyone has had to pull data out of a webpage at some point! Regular expressions can be used to extract a block of text from within a larger block, by using simple patterns. What's more, if you want to pull out multiple pieces of data (perhaps you work for 'S. Pammer' and want to extract all the email addresses for example!), you could use regular expressions to do that too.

---

class: section-title-b center centralimg

# Pattern Matching/Configuration

&nbsp;

![](regex/images/configuration.png)

???

If you've ever had to set up redirects on a web server (be that Apache or NGINX), you've probably had to work with regular expressions. Many different servers use regular expressions as a test for conditional rules, such as IP address matches, or partial URL matches, user agent matches etc. Understanding how regular expressions work makes this process substantially easier!


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

---

class: content-even

#RegEx 101

- Regular Expressions are massively powerful
- We will work through a few common examples
    - Validating a phone number
    - Replacing `<script>` tags
    - Extracing data from a webpage

---

class: content-odd

# Phone Number

- Simple example, we are validating input of a US phone number
- (123) 456-7890, (123) 456 7890 or 123-456-7890

```regexp
^\(?[0-9]{3}\)?( |-)[0-9]{3}( |-)[0-9]{4}$
```

---

class: content-odd

```regexp
^\(?[0-9]{3}\)?( |-)[0-9]{3}( |-)[0-9]{4}$
```

- `^...$` is the string anchor (must start and end)
- `\(?` optionally, start with an open bracket
    - `[\^$.|?*+()` are reserved characters
- `[0-9]{3}` exactly 3 numbers between 0-9
    - `{3,6}` would mean between 3 and 6
- `( |-)` either a space or a dash

---

class: content-even

# &lt;script> is not allowed!

- Can't use `str_replace` as we don't know what's between tags
- Can't use `strip_tags` as that only strips the tags themselves

```php
    $noscript = preg_replace(
      "/<script.*?>.*?<\/script.*?>/is",
      "NO JAVASCRIPT ALLOWED!",
      $text
    );
```

---

class: content-even

```regexp
/<script.*?>.*?<\/script.*?>/is
```

- The forward slashes mark the start and end of the pattern
    - With some flags which we'll come to
- `.*?` match 0 or more of any character
    - The `?` makes it lazy