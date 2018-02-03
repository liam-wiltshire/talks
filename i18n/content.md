
class: title-slide longtitle

.conference[![](logos/%%conference%%.png)]
.introimg[![](i18n/images/language.png)]

# London Calling:
## <small>Creating a customisable, multi-tenanted i18n solution</small>

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

class: section-title-a middle center

![](i18n/images/earth.png)

???

- Company logo?!
- The world is a big place
 - Internet access is growing worldwide
 - In all corners of the globe there are massively expanding markets opening up
 - Most of these do not use English as their native tongue
  - Some might speak English anyway, but firstly that's a horrible assumption to make
  - Secondly, it's certainly not true for everyone.
- The internet makes any business potentially global, so we need to make the most of that opportunity

---
class: summary-slide middle noheader

- The digital games market is now worth over $100bn globally <sup>[1]</sup>
- Mobile gaming accounts for about 40% of that <sup>[2]</sup>
- Europe and North America now represent less than half the total spend in the gaming industry <sup>[2]</sup>
- In China, secondary sales account for 88% of the digital gaming market <sup>[3]</sup>

???

- China now spends more on digital gaming that the USA
- Secondary purchases: in app, in game boosters etc
 - Good for us, as that's what we do!

- [1] https://www.juniperresearch.com/press/press-releases/digital-games-reaches-next-level-becoming-$100-bi
- [2] https://newzoo.com/insights/articles/the-global-games-market-will-reach-108-9-billion-in-2017-with-mobile-taking-42/
- [3] https://ukie.org.uk/sites/default/files/UK%20Games%20Industry%20Fact%20Sheet%20February%202018.pdf

---

class: section-title-b middle halfhalf
background-image: url(i18n/images/buycraft.png)

# About
# Buycraft

---

class: summary-slide middle

- Buycraft is a gCommerce platform for sandbox games
- We operate a SaaS platform (think Shopify for Minecraft)
- Global - over half a million webstores from 169 different countries
 - Handled over 16 million payments from 255 counties

???

- Mainly minecraft at the moment, but working with some different studios to integrate the platform into some upcoming games

---

class: content-even

# Current Solution

- Each customer who visits a webstore can pick from a limited range of languages
 - We then have a centralised list of translations:

```php
$lang['title.username'] = "Jätkamiseks sisesta palun kasutajanimi";
$lang['title.terms'] = "Kasutustingimused";
$lang['title.basket.empty'] = "Tühi ostukorv";
$lang['title.basket.checkout'] = "Maksma";
$lang['title.basket.free'] = "Palun kinnita, et oled inimene";
```

---

class: content-even

# Current Solution

- Each webstore then can use a `lang()` function in their templates to reference one of the short codes
 - This will then display the translation (assuming it exists)

```twig
<h2>{{ lang("title.username") }}</h2>
```

---

class: section-title-c middle halfhalf reverse
background-image: url(i18n/images/fixing_problems.png)

# Problems?

???

While it's easy to find plenty of examples of regular expressions in use, and it's easy to list all sorts of things they can be used for, most uses boil down to one of the following:

---

class: section-title-a center

# Restricted Language Set


![](i18n/images/rtl.png)

???



---

class: section-title-b center centralimg

# Only supports default strings

&nbsp;

![](i18n/images/nectar.png)

???



---

class: section-title-c bottom center centralimg

![](i18n/images/fallback.jpg)

# No Fallbacks

???

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


![](i18n/images/confused.png)

---

class: section-title-c top center

#Our Solution

&nbsp; 

![](i18n/images/solution.png)

---

class: content-odd

#Plurals

- While it's not the most straightforward, we decided to borrow gettext's rules
 - Not totally user-friendly, but we know they work
- However, now we need a parser for those rules...

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
{{ _p("You have an item in your basket", basket.packages|length) }}
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
<a href='#'>{{ __("Click here to continue") }}</a>
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
{{ __("Are you sure you wish to delete :itemname from your 
 ↳ basket, :username?",
 ↳ {'itemname' : package.name, 'username' : basket.username}) }}
```

???
This is something that Laravel did very well, so we stole their idea!

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


![](i18n/images/winning.jpg)

---

class: section-title-b middle center noheader


![](i18n/images/notwinning.jpg)


---

class: content-even
#Gotcha - External Cache

- We use CloudFlare to help with DDOS protection
 - As part of that, we also use them to cache webstore homepages
- We don't have separate URLs based on language
 - The local you select is stored in a cookie
 
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

class: section-title-a center middle noheader

![](i18n/images/eu-nokey.jpg)

???

- Can anyone guess what this map shows?

---

class: section-title-a center middle noheader

![](i18n/images/eu.jpg)

---

class: section-title-a center middle noheader

![](i18n/images/sa.jpg)

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
