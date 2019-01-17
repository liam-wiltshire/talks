
class: title-slide longtitle

.conference[![](logos/%%conference%%.png)]
.introimg[![](machinelearning/images/lightbulb.png)]

# Learning
## <small>the Hows and Whys of Machine Learning</small>

???
- Data is everywhere
- We see far too many examples of data being used badly
- Can we use data responsibly - protect players and server owners?

- Thanks to organisers, voluenteers etc.

---

class: section-title-c bottom left vanity-slide

.introimg[![](http://tebex.co.uk/img/tebex.svg)]

# Liam Wiltshire
## CTO

---

class: vanity-cover title-slide

background-image: url(logos/mcft.png)

---

class: summary-slide middle center noheader

![](machinelearning/images/chargebacks.jpg)

???

- Tebex is primarily a payment processor
- Like anyone in the payment or eCommerce industry, chargebacks are a significant problem.
 - Braintree - yeah they don't like our merchants
 - Stripe are not exactly big fans either...
- But, a few chargebacks are not a big deal right? What numbers are we talking about


---
class: section-title-a middle center noheader

# 0.5%

???

---

class: section-title-a middle center noheader

# 0.5%
## Clothing & Apparel <sup>[1]</sup>

???

- Travel is also roughly the same
- [1] https://chargebacks911.com/chargeback-stats-2017/

---

class: section-title-b middle center noheader

# 0.56%

???

---

class: section-title-b middle center noheader

# 0.56%
## Media & eContent <sup>[2]</sup>

???

- [2] https://chargebacks911.com/chargeback-stats-2017/

---

class: section-title-c middle center noheader

# 0.65%

???

---

class: section-title-c middle center noheader

# 0.65%
## Financial Services <sup>[3]</sup>

???

- [3] https://chargebacks911.com/chargeback-stats-2017/

---

class: summary-slide middle noheader center

# 0.85%

---

class: summary-slide middle noheader center

# 0.85%
## 23,844 payments

???

- That's alot of payments!
- The problem is, alot of chargebacks are not legitimate

---

class: summary-slide center middle

>>> Chargeback can be used in cases of goods **not arriving at all**, goods that are **damaged**, goods that are **different from the description**, or where the merchant has **ceased trading**.

???

- This is the definition of a chargeback from which (a UK consumer's association)
- It's a fairly clear definition, so, in our experience, is this how chargebacks are used?

---

class: summary-slide middle noheader center

# No
    
???

- We see plenty of examples of players charging back 'just because' (and openly admitting to it!)
- Perhaps they broke a rule on the server 3 weeks later and got banned - chargeback
- Perhaps they just decided to stop playing 2 months later - chargeback
- Sometimes they just do it to try to grief another player
- Clearly this isn't the server owner's fault, but these chargeback damage the servers and the honest players

---

class: content-odd 

# The Challenge
- Use our existing data to try to predict if a given payment is likely to be charged back in future
- Avoid false positives as far as possible
- Ideally, provide feedback to the store owner about why the payment has been flagged for manual review

???

- We want to try to help our our server owners as much as possible, so this is a problem that we come back to regularly
- We have various tools to try to protect our server owners from fraud, but could we do more?
- Then we had an idea. We have lots of data (some 19 million payment records at last count) - there must be a way to use them.
- Right?

---

class: section-title-b middle noheader

![](machinelearning/images/confused.jpg)

???

---

class: content-even

# Supervised Learning

- Supervised learning involves giving your learning function set of pre-labeled data as training data
- Your learning function will analyze the training data to classify previously unseen data.

???

- Thankfully, I vaguely remembered some snippets of a talk I went to a few years before, and from somewhere "Supervised Learning" came to mind.
- Totally couldn't remember what it actually was however - Google to the rescue
- It turns out that supervised learning was pretty much what we wanted - we had data that we knew the label for, so hopefully we can train a function
- How hard can it be!

---

class: content-even
# Classification

- Within supervised learning there are two problems we could be solving:
 - Classification - Analyze a piece of data to predict the probability of it belonging in a discreet category
 - Regression - Analyze a piece of data to predict where along a continuous line it would fit
 
???

- Example: Classification: Is a tumor benign or malign 
- Example: Regression: Given a set of variables, where along a house price line would this proprty fit?

- We are looking at classification

---

class: content-odd

# Level 1: Naive Bayes Classifier

- The simplest algorithm
- Used for text categorisation
- Calculates the probability of a block of text belonging to a category based on word frequency

???

---

class: content-odd noheader tinycode

```text

Split the given text into individual words
Standardise the words where possible
For each word:
    For each category:
        Calculate the percentage of all appearances of the word
        in the training data where the appearance is against this category
        
For each category:
    Calculate the average percentage for the category

Return the category with the highest average percentage as our prediction
  
```
???

- Standardising could include remocing punctuation, standardising plurals etc
- The percentage of appearances is, in other words, calculating the probability that the given word belongs to that label


---

class: section-title-c middle center noheader

# 100%

???

- Oh look, another statistic
---

class: section-title-c middle center noheader

# 100%
### Percentage of talks with live demos where Liam has criticised or called the speaker brave for a live demo

???

---

class: section-title-a center

# Live Demo

![](machinelearning/images/fire.jpg)

???

---

class: content-even

# Not Words

- If we replace 'words' with 'tokens':
 - Apple: col_red, shp_round, seed_1, stone_0
 - Apple: col_green, shp_round, seed_1, stone_0
 - Banana: col_yellow, shp_crescent, seed_0, stone_0
 - Orange: col_orange, shp_round, seed_1, stone_0
 - Orange: col_orange, shp_round, seed_0, stone_0
 - Peach: col_red, shp_round, seed_0, stone_1

???

- It's all very well being able to classify text, but we are not dealing with words
- If we assume words are actually tokens, could we use this to categorise other things

---

class: section-title-b center centralimg

# Only Supports Default Strings

&nbsp;

![](i18n/images/nectar.png)

???

- Translations only support the strings in the default template
- Paying customers can build their own templates
 - These might have different text 
 - There is no way to then translate these other strings

---

class: section-title-b center centralimg

# High Maintenance Cost

![](i18n/images/maintenance.jpg)

???

- every time we add a new feature that changes teh template we need to go back through every language and source a translation
 - More often than not we don't

---

class: section-title-c bottom center centralimg

![](i18n/images/fallback.jpg)

# No Fallbacks

???

- For for whatever reason a certain placeholder doesn't exist in a certain language there is no fallback
 - It will juut not display anything

---

class: summary-slide middle

#Aims

- Produce an i18n layer that allows users to customise the translations to fit them
 - This includes supporting custom strings, or entirely new languages
- It needs to be fast
- It needs to be easy for non-technical store owners to update


???

We often hit 25-30k requests a minute, well over a million requests an hour, so we need a solution that's not going to cause undue load

---

class: section-title-a

# Option 1 - GNU gettext

???
Now, I had a problem with getting an image fr this slide 

---

class: section-title-a center

# Option 1 - GNU gettext 

![](i18n/images/llama.jpg)

???
So here's a Llama!

---

class: content-odd

# GNU gettext

- GNU gettext is a great set of tools and libraries 
- Gives developers a framework for providing multi-lingual messages
- Used by WordPress (and others)

???

---

class: content-even

# gettext - Pros

- Mature
- PHP already has a gettext - compatible library
- Lots of examples of it in use
- Everyone can provide their own translation files
- Fast - machine readable 
- Supports plurals

---
class: content-odd
# gettext - Cons

- Placeholders are not supported directly:

```php
<?php
sprintf(_('Are you sure you want to block %s?'),'Alice');
?>
```

- Not user friendly

???
- You have to constantly refer back to some type of documentation to know what the placeholders are
 - Not ideal for users who are trying to make basic changes to their store
---

class: content-odd noheader tinycode

```bash
msgid ""
msgstr ""
"Language: de\n"
"MIME-Version: 1.0\n"
"Plural-Forms: nplurals=2; plural=n != 1;\n"
"X-Loco-Target-Locale: de_DE\n"
"X-Poedit-SearchPath-0: .\n"
"X-Poedit-SearchPathExcluded-0: includes\n"

#: options/index.php:59 utils/stcr_manage.php:230 utils/stcr_manage.php:413
#: utils/stcr_manage.php:414
msgid "Manage subscriptions"
msgstr "Verwalte deine Abonnements"

#: options/index.php:60 utils/stcr_manage.php:419 utils/stcr_manage.php:420
msgid "Comment Form"
msgstr "Kommentarformular"

#: options/index.php:61 utils/stcr_manage.php:425 utils/stcr_manage.php:426
msgid "Management Page"
msgstr "Verwaltungsseite"

#: options/index.php:62 utils/stcr_manage.php:431 utils/stcr_manage.php:432
msgid "Notifications"
msgstr "Benachrichtigungen"

#: options/index.php:63 options/panel2.php:58 options/panel3.php:82
#: options/panel4.php:89 utils/stcr_manage.php:437 utils/stcr_manage.php:438
msgid "Options"
msgstr "Optionen"
```

???

- While most server owners are not completely technically inept, this would be something completely new to them


---

class: section-title-b center

# Option 2 - Illuminate\Translation 

![](i18n/images/laravel.png)

???

- Our codebase is Laravel, so it made sense to look at the built-in option
 - That's right, Laravel - granted there are some bits of it we don't use 
 (Facades, looking at you!), but it does a good job for our application

---

class: content-even

# Illuminate\Translation

- Laravel's built in L10n tool
- Being built-in a number of Laravel extensions already support it
- Has been around since version 4, so fairly mature now

???

- As a general rule, I'll try to use default where possible
- Laravel has such an option, so we took a good look at the posiblity of using it

---

class: content-odd tinycode noheader

# Illuminate\Translation - Pros

- Built in support in Laravel
- Support plurals
```php
'apples' => 'There is one apple|There are many apples',
```
- Support readable placeholders
```php
'goodbye' => 'Goodbye, :Name', // Goodbye, Dayle
```
- Translations are stored as arrays - pretty fast
???

- Looking good - we were seriously considering this, as it seemed to tick most of our boxes

---

class: content-odd tinycode noheader

# Illuminate\Translation - Cons

- Translations are stored as arrays
 - Not user friendly
- Translations are stored on the filesystem
 - App scales across 10+ AWS instances?!
 - Storing files for every webstore?!
- Translation 'key' is still a shortcode
 - This is actually fixed in newer versions of Laravel
 
???

Writing arrays and plural formatting, neither ideal

---

class: content-odd tinycode noheader

# Storing Translations in a DB

- It's fairly easy to replace Laravel's FileLoader
- This means you *can* load the translations from a DB
 - You have to know which webstore to ensure the correct translations are loaded
- We could then use whatever format we want for user input

???

We could even upgrade to a new version of Laravel?!

---

class: section-title-b middle center noheader


![](i18n/images/winning.jpg)

---

class: section-title-b middle center noheader


![](i18n/images/notwinning.jpg)


---

class: content-odd

# !Winning

- Although we use Laravel, we don't use it everywhere
- Some of the webstore code is legacy
- Who says we'll always use Laravel?
 - What if we want to use a JS frontend?
 - Or mobile apps?

???

Couldn't bring myself to write CI2!
 

---

class: section-title-b middle halfhalf reverse
background-image: url(i18n/images/onemore.jpg)
 
# Option 3 - Roll Our Own

???

I wouldn't normally condone the build your own solution
However we had very specific ideas of what we wanted
Everything else seemed to require some form of compromise

---

class: summary-slide noheader

# Requirements
- Support plurals
- The 'key' should be the default translation
 - With readable placeholders
- Can be over-written and customised on a per user basis
 - In a format users can understand
- Support languages we don't even know exist!
- Translations should be loadable to arrays for speed
    
???

Our final requirements were essentially combining things we liked from both gettext and Illuminate/Translation    
    
---

class: content-even center
# Plurals


![](i18n/images/plural.png)


???
Embarrassed to say how naieve I was about plurals
I had always taken plurals for granted - even though actually I knew french handles plurals slightly differently

---

class: content-even

# Plural Rules
- Only one form
- Two forms, singular used for one only
- Two forms, singular used for zero and one
- Three forms, special case for zero

???
- Asian languages such as Japanese, Korean
- Many languages, including English, German, Dutch, Italian, Spanish
- French, Some forms of portuguese
- Latvian

---
class: content-even

# Plural Rules
- Three forms, special cases for one and two
- Three forms, special case for numbers ending in 00 or [2-9][0-9]
- Three forms, special case for numbers ending in 1[2-9]
- Three forms, special cases for numbers ending in 1 and 2, 3, 4, except those ending in 1[1-4]

???

- Galic
- Romanian
- Lthuanian
- Russian, Ukrainian etc

---

class: content-even

# Plural Rules
- Three forms, special cases for 1 and 2, 3, 4
- Three forms, special case for one and some numbers ending in 2, 3, or 4
- Four forms, special case for one and all numbers ending in 02, 03, or 04
- Six forms, special cases for one, two, all numbers ending in 02, 03, … 10, all numbers ending in 11 … 99, and others

???

- Czech, Slovak
- Polish
- Slovenian
- Arabic

---


class: section-title-b center middle


![](i18n/images/confused.jpg)

---

class: section-title-c top center

#Our Solution

&nbsp; 

![](i18n/images/solution.png)

???

- We needed to come up with a solution that would handle any set of rules without our input
 - Including rules that we didn't understand!

---

class: content-odd

#Plurals

- While it's not the most straightforward, we decided to borrow gettext's rules
 - Not totally user-friendly, but we know they work
 
```bash
nplurals=2; plural=n != 1
```
- However, now we need a parser for those rules...

???

 - Also, there are published lists for the rules for almost every world language, so we accepted this was a resonable compromise

---
class: content-odd

#Drupal to the rescue
- Drupal has their own .po header handler
 - ... which of course includes parsing plural rules
- Thanks Drupal!

???

We re-worked the code slightly to allow us to pass a plural rule as a constructor argument, then we can feed it a number and it will tell us which plural form we are using
This is then fed into our i18n layer to use the correct plural form for the string we are translating

---

class: content-odd noheader tinycode
- Key: "You have an item in your basket"
 - Form 1 - You have an item your basket
 - Form 2 - You have items in your basket

```twig
{⁣{ _p("You have an item in your basket", basket.packages|length) }}
```

---

class: summary-slide noheader

# Requirements
- Support plurals &#10004;
- The 'key' should be the default translation
 - With readable placeholders
- Can be over-written and customised on a per user basis
 - In a format users can understand
- Support languages we don't even know exist!
- Translations should be loadable to arrays for speed
    
???

Our final requirements were essentially combining things we liked from both gettext and Illuminate/Translation    
    
---

class: content-even tinycode
# Default Translation

- Considering we are allowing merchants to upload their own translations, we didn't want situations where there wasn't a default
 - With shortcodes this could be the case
- Also makes templates etc more readable without having to lookup what a shortcode means

```twig
<a href='#'>{⁣{ __("Click here to continue") }}</a>
```

???

- We know that our solution will use the key as the fallback - if no translation exists, then the text that has been entered here is what we will use

---

class: content-even tinycode noheader

```php
    public function getTranslation($string, $replacements = false)
    {
        if (isset($this->translation->translations->$string)) {
            return $this->doReplacements(
                $this->translation->translations->$string,
                $replacements
            );
        }

        return $this->doReplacements($string, $replacements);
    }
```

---

class: content-odd tinycode
# With Readable Placeholders

- Unlike gettext, we want the placeholders to be obvious as to their meaning without documentation
- Our merchants create their own templates by using the default to start, so everything needs to be self explanatory
 
```twig
{⁣{ __("Are you sure you wish to delete :itemname from your 
 ↳ basket, :username?",
 ↳ {'itemname' : package.name, 'username' : basket.username}) }}
```

???
- This is something that Laravel did very well, so we stole their idea!
- This was one of our top priorities - having that context when merchants are creating new templates simplifies the process
- Just by reading it's easy to see what's waht
 - Also means that a translation can easily reverse the placeholder order if required

---

class: content-odd tinycode

```php
private function doReplacements($string, $replacements = false)
{
    if ($replacements) {
        foreach ($replacements as $placeholder => $value) {
            $string = str_replace(":{$placeholder}", $value, $string);
        }
    }
    return $string;
}
```

---

class: summary-slide noheader

# Requirements
- Support plurals &#10004;
- The 'key' should be the default translation &#10004;
 - With readable placeholders &#10004;
- Can be over-written and customised on a per user basis
 - In a format users can understand
- Support languages we don't even know exist!
- Translations should be loadable to arrays for speed
    
???

Our final requirements were essentially combining things we liked from both gettext and Illuminate/Translation    
    
---

class: content-even
# Per-store customisation

- We will create a set of initial translations, but stores should be able to add their own
 - If they want to replace our default translations
 - Or if they want to translate custom strings that appear in their template
 - Or even if they want to add a totally new language!

???

---

class: content-even
# Format - json
- We decided to use JSON for the translation files
 - Generally understood by our merchants already
 - Doesn't require any additional parsing to turn into an array
 
---

class: content-even tinycode noheader

```json
{  
   "meta":{  
      "locale":"en_GB",
      "pluralrule":"plural=(n != 1)",
      "name":"English"
   },
   "translations":{  
      "Welcome":"Welcome",
      "Please enter your username to continue":"Please enter your username to continue",
      "Terms and conditions":"Terms and conditions",
      "Empty basket":"Empty basket",
      "Please confirm that you're a human":"Please confirm that you're a human",
      ":count item for :amount :currency":[  
         ":count item for :amount :currency",
         ":count items for :amount :currency"
      ],      
   }
}
```
---
class: content-even
# Inheritance
- If a merchant only wants to replace one or two translations, it is silly for them to have to provide every translation
 - Every translation has a full locale, so we can easily work out if there is a default to fallback to
 
---

class: content-even noheader center

![](i18n/images/translations.png)

---

class: content-even tinycode 

# Inheritance
- This provides a nice fallback chain:

```php
public function getTranslation($string, $replacements = false)
{
    if (isset($this->translation->translations->$string)) {
        return $this->doReplacements($this->translation->translations->$string, $replacements);
    }
    if (isset($this->parentTranslation->translations->$string)) {
        return $this->doReplacements($this->parentTranslation->translations->$string, $replacements);
    }
    return $this->doReplacements($string, $replacements);
}
```

---

class: content-even tinycode

# Inheritance
- This provides a nice fallback chain:

```php
public function getTranslation($string, $replacements = false)
{
*    if (isset($this->translation->translations->$string)) {
*        return $this->doReplacements($this->translation->translations->$string, $replacements);
*    }
    if (isset($this->parentTranslation->translations->$string)) {
        return $this->doReplacements($this->parentTranslation->translations->$string, $replacements);
    }
    return $this->doReplacements($string, $replacements);
}
```

---

class: content-even  tinycode

# Inheritance
- This provides a nice fallback chain:

```php
public function getTranslation($string, $replacements = false)
{
    if (isset($this->translation->translations->$string)) {
        return $this->doReplacements($this->translation->translations->$string, $replacements);
    }
*    if (isset($this->parentTranslation->translations->$string)) {
*        return $this->doReplacements($this->parentTranslation->translations->$string, $replacements);
*    }
    return $this->doReplacements($string, $replacements);
}
```

---

class: content-even tinycode

# Inheritance
- This provides a nice fallback chain:

```php
public function getTranslation($string, $replacements = false)
{
    if (isset($this->translation->translations->$string)) {
        return $this->doReplacements($this->translation->translations->$string, $replacements);
    }
    if (isset($this->parentTranslation->translations->$string)) {
        return $this->doReplacements($this->parentTranslation->translations->$string, $replacements);
    }
*    return $this->doReplacements($string, $replacements);
}
```

---

class: summary-slide noheader

# Requirements
- Support plurals &#10004;
- The 'key' should be the default translation &#10004;
 - With readable placeholders &#10004;
- Can be over-written and customised on a per user basis &#10004;
 - In a format users can understand &#10004;
- Support languages we don't even know exist! &#10004;
- Translations should be loadable to arrays for speed &#10004;
    
???

Our final requirements were essentially combining things we liked from both gettext and Illuminate/Translation    
    
---

class: section-title-a halfhalf middle
background-image:url(i18n/images/performance.jpg)

# Performance

???

- So, we now have the basics of our system
- We can provide translations, users can provide translations
 - But what about performance?
 - At peak times we serve alot of traffic, so we need to ensure there are no problems

---

class: content-odd tinycode
# Extra DB queries

- Adding this new translation layer added 2 extra queries to each page load
 - 1 to fetch their translation file
 - 1 to try to fetch the base file (if it exists)

???

- Two extra queries doesn't sound like much
 - but that could be an extra 60k requests a minute!
 


---

class: content-odd tinycode
# Extra Logic

- Parsing two JSON objects on every page request
  - Each translatable item could require checking two arrays
 

???

- Again, we are talking tiny differences
 - But the key point is that we are doing everything twice
 - So it's not just speed, but memory as well - these json files can be large!


---

class: section-title-b middle center

# Does Any Of This Matter?
    
---

class: section-title-c middle center

# Not Really.

???

- You know what? The performance was actually fine as it was.
 - The extra DB queries are the only 'real' problem - everything else, two json_decodes, two issets... big deal
- However, it bugged me as it felt unfinished, so I 'fixed' it anyway! 

---

class: content-odd
#Merge and Cache

- These arrays both have sets of shared keys
 - Or at least, they might do
- We can combine the two arrays, and then cache the result


???

Fix all the things
 - Merge the arrays - now we don't have two checks
 - Cache the result - now we don't have to hit the DB
 
---

class: section-title-b middle center noheader


![](i18n/images/winning-2.png)

---

class: section-title-b middle center noheader


![](i18n/images/notwinning-2.png)


---

class: content-even
#Gotcha - External Cache

- We use CloudFlare to help with DDOS protection
 - As part of that, we also use them to cache webstore homepages
- We don't have separate URLs based on language
 - The locale you select is stored in a cookie
 
???

- If Cloudflare has a cache, it won't serve a cookie
 -  Even if you have a cookie, if cloudflare has a cache for the main URL, you'll get that
- Even better, if you visit the site for the first time, but the cache miss was generated by someone loading the page in german, you'll be confused! 

---

class: content-even tinycode
# Custom External Cache

```lua
local currency = cookie_obj:get('buycraft_currency')
local locale = cookie_obj:get('buycraft_locale')

if not currency then
    currency = "default"
end
if not locale then
    locale = "default"
end

local cache_key_fmt = st_format('${scheme}://${host_header}${uri}::%s::%s::%s', currency:lower(), language:lower(), locale:lower())
```

???
- Step 1 - include locale into a custom cache key

---

class: content-even tinycode
# Custom External Cache

```lua
if args["currency"] and args["currency"] ~= true then
    currency = args["currency"]
    args_tab["buycraft_currency"] = args["currency"]
end

if args["locale"] and args["locale"] ~= true then
    locale = args["locale"]
    args_tab["buycraft_locale"] = args["locale"]
end
```

???
- Step 2 - If we have a new query string, this superceeds the cookie

---

class: content-even tinycode
# Custom External Cache

```lua
for key, value in pairs(args_tab) do
    if value then
       table.insert(cookie_push, key)
       table.insert(cookie_push, st_format("%s; Max-Age=%s; Path=/; Domain=.%s", value:lower(), 2592000, regdom))
    end
end
```

???
- Step 3 - Oh, and if it came from a query string we best set a cookie


---

class: section-title-b middle center noheader


![](i18n/images/winning.jpg)

---

class: section-title-b middle center noheader


![](i18n/images/notwinning.jpg)


---

class: section-title-c middle center

# 01/02/03

???

- What does this date show?
- 1st Feb 2003?
- 3rd Feb 2001?
- 2nd Jan 2003?

---

class: content-odd

# Beyond Language
- Localisation is more than just language
- We have different ways of handling numbers, dates, currency

???

- Our first step was to get the language side of things working
 - But it's a much bigger job than that
 - We still have a way to go, but we are now looking at improving other areas of the experience

---

class: content-odd
# Numbers and Dates
```json
{  
   "meta":{  
      "locale":"en_GB",
      "pluralrule":"plural=(n != 1)",
      "name":"English",
*     "dateformat":"d-m-Y",
*     "decimalpoint":".",
*     "thousandssep":","
   }
}
```

---
class: content-odd
# Numbers and Dates
```twig
Purchase Date:
{⁣{ _d(purchase.date) }}

Purchase Value:
{⁣{ purchase.currency }}{⁣{ _n(purchase.value) }} 
```

???

- We then expose two additional methods to twig - _d (date) and _n (number).
- This could (and probably will) be taken further still - control over where the currency symbol goes for example
---
class: content-odd tinycode
```php
public function formatDate($date)
{
    $date = $this->carbon->parse($date);
    return $date->format($this->getDateFormat()); 
}

public function formatNumber($number)
{
    return number_format(
        $number,
        2,
        $this->getDecimalPoint(),
        $this->getThousandsSep()
    ); 
}
```

---

class: section-title-b middle center noheader


![](i18n/images/winning3.png)

---

class: section-title-b middle center noheader


![](i18n/images/notwinning3.jpg)


---

class: section-title-a center middle noheader

![](i18n/images/eu-nokey.jpg)

???

- Can anyone guess what this map shows?

---

class: section-title-a center middle noheader

![](i18n/images/eu.jpg)

---

class: section-title-a center middle noheader

![](i18n/images/na.jpg)

---

class: section-title-a center middle noheader

![](i18n/images/sa.jpg)

---

class: section-title-a center middle noheader

![](i18n/images/asia.jpg)

---

class: content-even
#Payments

- Credit/Debit cards are *not* global
- Neither is PayPal!
 - This applies double when we consider the market our merchants are targeting

???

---
class: content-even
# Payments

- Different payment methods have strongholds in different regions
 - Speak to our merchants, discover what would make a difference for their players
- Integrate as many gateways as possible
 - Including some multi-gateway providers such as Xsolla, Mollie who have broad reach 

---

class: content-even
# Payments

- We can't support every gateway however
 - With everything we do we are now aiming to provide ways for merchants to 'do it themselves'
- This includes being able to integrate their own payment methods
 - Not a 'first class citizen', but provides a way to make it work

---

class: content-odd
# Self-Integration

- Player go through the checkout as normal
- Instead of going to one of our gateways at the end of the process, we create a payment with a pending state
- We then redirect the player to a page that the merchant controls the content of
 - Could be a button to redirect to their payment method, or some Javascript etc

???




---



class: content-odd center
#Self-Integration

![](i18n/images/manual.png)

---

class: content-odd
#Self-Integration

- We then provide two APIs to be able to confirm the purchase when they receive the money:
 - Check the details of a purchase, to confirm the amount they received matches the purchase price 
 - Set the status of the payment
 

???

- Once the payment status is changed, we start with the standard fulfilment processes

---

class: middle center content-odd

![](i18n/images/api.png)

---

class: summary-slide noheader

- We don't know everything - now our merchants are empowered to target their market in ways we would never think of
- We reduce support requests for things like incorrect translations, translation of strings that haven't been, and new payment gateways
- Our solutions are portable - we could use the same layers and approach to apply this to a SPA, or a mobile app

???

- And you know, we;re not finished yet - we are always having to talk to our merchants, there are always things that we can do better
- Error messages, currencies, plugins - the more useable our applications are, the more successful they will be.

---


class: section-title-b middle center noheader


![](i18n/images/winning.jpg)
 
---

class: thanks-slide

.conference[![](logos/%%conference%%.png)]
.introimg[![](http://tebex.co.uk/img/tebex.svg)]

# Thank You

### %%joindin%%
### Liam Wiltshire
### @l_wiltshire
### liam@tebex.co.uk
