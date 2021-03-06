
class: title-slide longtitle

.conference[![](logos/%%conference%%.png)]
.introimg[![](machinelearning/images/lightbulb.png)]

# Learning
## <small>Machine Learning</small>

???
- Data is everywhere
- We see far too many examples of data being used badly
- Can we use data responsibly - protect players and server owners?

- Thanks to organisers, volunteers etc.

---

class: section-title-c bottom left vanity-slide

.introimg[![](https://www.tebex.io/assets/img/logos/tebex.svg)]

# Liam Wiltshire
## CTO

---

class: vanity-cover title-slide

background-image: url(logos/mcft.png)

---

class: vanity-cover title-slide

background-image: url(logos/mcft-hiring.png)

---


class: summary-slide middle center noheader

![](machinelearning/images/chargebacks.jpg)

???
- Tebex is primarily a payment processor
- As with anyone in the payment or eCommerce industry, chargebacks are a significant problem.
 - Braintree - yeah they don't like our merchants
 - Stripe are not exactly big fans either...
- When I say 'chargeback', I don't always mean credit card chargebacks - I'm also including paypal disputes and similar mechanisms.
- But, a few chargebacks are not a big deal right? What numbers are we talking about


---
class: section-title-a middle center noheader

# 0.5%
## &nbsp;<sup>&nbsp;</sup>

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
## &nbsp;<sup>&nbsp;</sup>

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
## &nbsp;<sup>&nbsp;</sup>

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
## &nbsp;<sup>&nbsp;</sup>

---

class: summary-slide middle noheader center

# 0.85%
## 23,844 payments<sup>&nbsp;</sup>

???

- That's a lot of payments!
- The problem is, a lot of chargebacks are not legitimate

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
- Clearly, this isn't the server owner's fault, but these chargebacks damage the servers and the honest players

---

class: content-odd 

# The Challenge
- Use our existing data to predict if a given payment is likely to be charged back in future
- Avoid false positives as far as possible
- Ideally, provide feedback to the store owner about why the payment has been flagged for manual review

???

- We want to try to help our server owners as much as possible, so this is a problem that we come back to regularly
- We have various tools to try to protect our server owners from fraud, but could we do more?
- Then we had an idea. We have lots of data (some 19 million payment records at last count) - there must be a way to use them.
- So we set ourselves a challenge.... [slide]

---

class: section-title-b middle noheader

![](machinelearning/images/confused.jpg)

???

- How hard can it be?!
- As I mentioned, I've been to ML talks before, and somewhere from the depths of my memory, 2 words cropped up...

---

class: content-even

# Supervised Learning

- Supervised learning involves giving your learning function a set of training data with known answers
- Your learning function will analyze the training data to provide an answer for previously unseen data.

???

- Supervised Learning
- Totally couldn't remember what it actually was, however - Google to the rescue!
- It turns out that supervised learning was pretty much what we wanted - we had data that we knew the answers for, so hopefully we can train a function
- Or something?!

---

class: content-even
# Classification

- Within supervised learning there are two problems we could be solving:
 - Classification - Analyze a piece of data to predict which category it is most similar to
 - Regression - Analyze a piece of data to predict where along a continuous line it would fit
 
???
- When are are talking about supervised learning, we are usually trying to solve one of two problems:
- Classification: Is something an apple or an orange, or is a tumor malignant or benign  
- Regression: Given a set of variables, where along a house price line would this property fit?

- We are looking at classification - now we know what we are trying to do, we need to find an...

---
class: content-odd center middle

![](machinelearning/images/algorithms.png)

???

- There are many potential algorithms for Machine Learning and classification in particular
- Given that we are engineers and not data-scientists, we wanted to look to use the simplest one that would do the job we wanted it to do

---

class: content-odd

# Level 1: Naive Bayes Classifier

- The simplest algorithm
- Used for text categorisation
- Calculates the probability of a block of text belonging to a category based on word frequency

???

- If you do any research around ML, the algorithm that comes up the most as being the most straightforward and easy to understand is the Naive Bayes Classifier
- Based around categorising text, and in particular used quite a bit for spam filters and similar
- So that's where we started

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

- This algorithm is essentially just working out which category each word is seen in the most
- Then, based on all the words and the probability of it being part of each category, which category overall has the highest probability
- Standardising could include removing punctuation, standardising plurals, in some languages standardising gender (french) etc
- The percentage of appearances is, in other words, calculating the probability that the given word belongs to that label

---

class: section-title-a center

# Live Demo

![](machinelearning/images/fire0a.gif)

???

- Shit

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
- As an example, let's think about describing fruit
 - Obviously colours and shapes are words, but if in our data seed and stone are binary, we need to handle those
 - otherwise if we just returned a 1 or a 0, we wouldn't know _what_ was true or false

---

class: content-odd tinycode

# Attempt 1

```php
$str = "country:{$payment->country} gateway:{$payment->gateway}";
$str .= "usddollars:".round($payment->usdamount)." sigfig:".$sigFig;
$str .= " countrygateway:{$payment->country}{$payment->gateway}";
$str .= " usernamesbyip:{$usernameCount->cnt} ".secondsToTime($timeSince)."";
```

???
- So that's what we did - we took the data that we wanted to use in our algorithm, and made them into tokens.
- Most of the values are prefixed - this is because where a number of the items are IDs, the same number could show up in multiple places
- PHP-ML actually has a tokenizer function.... but we didn't realise this at the time!
---

class: content-odd tinycode

# Attempt 1

```php
$str = "country:{$payment->country} gateway:{$payment->gateway}";
*$str .= "usddollars:".round($payment->usdamount)." sigfig:".$sigFig;
$str .= " countrygateway:{$payment->country}{$payment->gateway}";
$str .= " usernamesbyip:{$usernameCount->cnt} ".secondsToTime($timeSince)."";
```

???

- Notice the sigfig - this is the value of the first digit - was added as Benford's Law suggests some leading figures should be more common than others

---

class: content-odd tinycode

# Attempt 1

```php
$str = "country:{$payment->country} gateway:{$payment->gateway}";
$str .= "usddollars:".round($payment->usdamount)." sigfig:".$sigFig;
*$str .= " countrygateway:{$payment->country}{$payment->gateway}";
$str .= " usernamesbyip:{$usernameCount->cnt} ".secondsToTime($timeSince)."";
```

???

- Also, notice how country and gateway show up separately, then as a combined countrygateway
 - With our Naive Bayes Classifier, the 'Naive' part relates to how there is no assumed relation between tokens.
 - Obviously in our data set this might not be the case. A gateway that is used lots in Europe, but not in Asia wouldn't be suspicious for a European transaction but might be worth investigating if the transaction originates from Asia
 - This will only be flagged with related tokens.

---

class: content-odd

# Attempt 1 - Results

- Total Rows: 200

???

- Now we've got something we can try, let's test it! 
- For most of our tests we picked 100 rows of 'good' payments and 100 rows of chargebacks at random from 2017 (training data came from 2018)

---

class: content-odd

# Attempt 1 - Results

- Total Rows: 200
- False Positives: 0

???

- So far so good

---

class: content-odd

# Attempt 1 - Results

- Total Rows: 200
- False Positives: 0
- Identified Fraud: 0
- Missed Fraud: 100
- Identified Ok: 100

???

- Yeah.
- In other words, it decided every single row _wasn't_ fraud!!
---



class: content-odd middle center noheader

![](machinelearning/images/head-in-hands.jpg)


???

- So, this didn't work so well! Obviously doing one Google search wasn't enough!

---

class: section-title-a middle center

???

- We didn't really know what the problem was to start with
- We did some further research, and we learned our first important lesson:


---

class: section-title-a middle center

# Lesson 1: Imbalanced Data Is The Enemy

???

- Many ML algorithms are sensitive to imbalanced data - in our situation, we had 2.8 million 'good' payments and 24k chargebacks - little bit unbalanced

---

class: content-even

# Imbalanced Data

- With many datasets, you will likely find that some labels have more data than others
- This results in the algorithm being skewed towards those labels with more data
- Given that less than 1% of our data is fraud, the algorithm can just pick 'not fraud' every time and be over 99% accurate!

???

- When we thought about it, this makes sense. If the algorithm is counting how many times a word/token appears in a category, it's likely to appear  more times in a category with more data 
- Example: Some apples are red, and some are green. If you have 10,000 apples in your training data and only 2,000 cherries, anything that is red will have a higher probability of being an apple. 
- Wierdly, this also makes it very accurate - _technically_ by picking 'not fraud' every time, our algorithm is over 99% accurate - just totally useless at the same time!


---

class: content-even

# Imbalanced Data - Solutions 

???

- Thankfully there are a few potential solutions:

---

class: content-even

# Imbalanced Data - Solutions 

- Collect more data

???

- If it's possible, you can collect more data for the categories with less data
- Obviously for something like fraudulent transactions, that's not really possible - we don't want to be _asking_ players to create fradulant transactions!

---

class: content-even

# Imbalanced Data - Solutions 

- Collect more data
- Change your metrics

???

- At the moment we're looking at returning a single answer - the label
- Perhaps instead we can also look at the probability of it being in the 'fraud category'
- So perhaps if the 'fraud' category has a probability > 35% for example, it needs looking at?

---

class: content-even

# Imbalanced Data - Solutions 

- Collect more data
- Change your metrics
- Resample your data

???
- This could be two options:
- Undersampling the over-represented categories (only picking 1% of the records at random)
- Oversampling the under-represented categories (adding each set of test data multiple times)
 - For us, this would mean having to insert each fraud record over 100 times!!
 

---

class: content-odd

# Attempt 2

- We can't realistically collect more data, so we mixed resampling and changing our metric:
    - We upsampled fraud records by counting each record twice and then selected 48000 'Ok' records at random
    - We then returned the probability of the 'Fraud' label as part of our result, to see if there was a 'threshold' we could realistically set:

???

- Collecting more data isn't an option, so we decided to try a mix of re-sampling (we counted each fraud record twice and only used )
- And also changing our metrics - we returned the fraud probability for each type, to see if there was any useful patterns:
- Again, we pulled 200 records, 100 of each, to test with

---

class: content-odd

# Attempt 2 - Results

- Total Rows: 200
- False Positives 71
- Identified Fraud 70
- Missed Fraud 30
- Identified Ok: 29


???

- We can see that we are 'moving the needle' now, but accuracy is poor - 50% accuracy
- With the result being so mixed, there wasn't really any value in looking at the fraud probability
    - accepting anything with a fraud probability of 46% or more results in more fraud being caught, but also increases the number of false positives
- This was quite frustrating - we were sure there must be something obvious we were missing...


---

class: section-title-b middle center


???


- We played with the algorithm a bit, but we were not really getting anywhere.
- Again, after a bit more Googling, we started to question our approach:


---

class: section-title-b middle center

# Lesson 2: Understand Your Data

???


- We realised there were a number of potential flaws in our approach
    - We had already recognised that the different tokens we were considering were related, perhaps it's more important than we thought - someone paying 30 USD in Germany is much less suspicious than in Argentina for example, where the average purchase price is around 8 USD.

---
class: section-title-b middle center

# Lesson 2: Understand Your Data

???

- Do we need to consider context more? A store where all items are $3 USD or less would make a $35 transaction look strange, where a store selling ranks for $35 each it would be perfectly normal.
- What about prices? Purchase prices are not discrete, but continuous - a $3 purchase and a $4 purchase are probably not that exceptional, but in token classifier terms they are totally different.  

---

class: content-even

# The Hunt For A New Algorithm

- We were looking for an algorithm where
    - The combination of data points has an affect
    - Continuous data is handled as well as discrete data

- Ideally also something that we don't have to be a math genius for!

???

- So, Naive Bayes wasn't working for us - we wanted to try to resolve some of the issues we'd considered
- We still didn't want anything too complex if we could avoid it - it would be nice to understand what we were doing!!
- We're still looking at supervised learning algorithsm of course, and after a bit more research we came accross

---

class: content-odd

# Level 2: k-Nearest Neighbours

- k-Nearest Neighbours (k-NN) is another fairly simple algorithm
- k-NN is less naive, because distances between data points is considered.
- Because we are measuring distance, continuous data is better handled

???

- k-NN is fairly straightforward to understand - essentially it means 'which k (k being a number) other results is this one most like'
- It met alot of our criteria: handling continuous data, assigning some association between the different data points
 - Not causal, but variations in one dimension alter the distances in relation to others
- As a side benefit, it is less sensitive to a data imbalance (considering local neighbourhood), a large imbalance will still affect results
- The easiest way to show this is with a graph:

---

class: content-odd center middle

# k-Nearest Neighbours

![](machinelearning/images/knn1.png)

???

- This is a representation of some training data with two parameters
 - it doesn't really matter what they are
- Using this data, if we add another point, we can see which group it's most likely to be in

---

class: content-odd center middle

# k-Nearest Neighbours

![](machinelearning/images/knn2.png)

???

- The k in k-NN is the number of nearest neighbours to fetch. Each neighbour is a 'vote'
- So if we had 1-NN...

---

class: content-odd center middle

# k-Nearest Neighbours

![](machinelearning/images/knn3.png)

???

- The result would be the 'white category'
- 2-NN...

---

class: content-odd center middle

# k-Nearest Neighbours

![](machinelearning/images/knn4.png)

???

- Would be a tie (which is why as a rule you use an odd number of votes)
- 3-NN...

---

class: content-odd center middle

# k-Nearest Neighbours

![](machinelearning/images/knn5.png)

???

- Would go back to the white category and so on
- Whichever number you select for k, the category with the most votes...

---

class: content-odd center middle

# k-Nearest Neighbours

![](machinelearning/images/knn6.png)

???

- is the result
- This example works using 2 axes/dimensions, however the k-NN algorithm can work with any number of dimensions, meaning we can apply it to our use case.
- No pseudo-code this time, as I don't understand it enough!

---

class: content-odd tinycode noheader

```php
    $classifier = $this->app->makeWith(
        KNearestNeighbors::class,
        ['k' => 3]
    );

    $samples = [
        [1, 3, 5, 1], [1, 4, 5, 2], [2, 4, 6, 2], [2, 3, 5, 1],
        [3, 1, 2, 2], [4, 1, 2, 2], [4, 2, 1, 3], [3, 2, 1, 3]
    ];
    $labels = [
        'a', 'a', 'a', 'a',
        'b', 'b', 'b', 'b'
    ];

    $classifier->train($samples, $labels);

    $test = [1, 3, 2, 1];
    $this->comment("Classification: " . $classifier->predict($test));
```
???

- Thankfully there is a library for machine learning in PHP - it actually will do the Bayes Naive as well, but I understood that enough to write something!
- This is fairly straightforward - we are using some 4-dimensional training data, then we can predict from our test

---

class: section-title-a center

# Live Demo

![](machinelearning/images/fire.gif)

???


---

class: section-title-c middle center



???

- You might have spotted in these demos, something specific about the data...
- They are all numeric

---

class: section-title-c middle center

# Lesson 3: k-NN ❤️ Numbers

???

- Because k-NN is based on calculating the distance, it needs to be based on numeric data.
- There are distance functions for text, but that's usually the number of changes to make 'red' into 'bed' for example, not the 'distance' between USD and EUR! 
- Most of our data isn't numeric *sadface*
- We need to find a way to convert it  

---

class: content-even

# Handling Nominal Data

- We need to convert our textual data to numerical data
- k-NN is concerned with distance, so a larger distance means data is less related than a smaller distance
 - We need to be careful about _how_ we convert the data

???

- First off, we thought - no problem - most of our data is normalised, so we have a country_id, a currency_id etc.
- However, this brings challenges - the distance between country_id 1 and country_id 2 is less than between country_id 4 and country_id 50
 - So the distance between Australia and Austria would be 1, but the distance between Australia and New Zealand would be 160?!
- This could then skew our results.
 

---

class: content-even
 
# Sequential Data

- In an ideal world, your nominal data will be sequential
- In this situation, you need to estimate the distance between them
- E.G. Intern -> Non-Management Employee -> Line Manager -> Department Manager -> Executive
- 1 -> 3 -> 6 -> 10 -> 15 

???
- If your textural data is sequential, then it's not too bad - like school grades, or positions at an old-fashioned company!
- Although if you ask an executive, they'd probably give their distance to be 100!

---

class: content-even

# Non-Sequential Data

- Non-sequential data makes this trickier
- Countries
 - Lat/Lon?
 - Ordered by popularity?
- Currencies
- Gateways
    
???
- We tried to think of ways of making our data sequential, but it wasn't really working
- In our situation, we don't have sequential data. For countries, we thought about using Lat/Lon to measure the distance around the globe.
- However that would give a distance between two points within Russia as 360 (straddle 180 deg), so that doesn't work 
- And what about currencies and payment methods?
    
---

class: content-even

# Binary

- The simplest solution is to make all the data binary
- With only a simple 'on' or 'off', there is no risk of incorrect measurements
 - Does result in a large number of dimensions, which can result in it's own issues
- Usually you'll want to normalize all data to the same scale
    
???

- After doing more research, the best method we could come up with was to binarise everything
- This means turning the data into a series of yes/no options: 
 - Is the country US
 - Is the country GB
 - Is the country FR
 - Is the country DE
- Obviously this results in many dimensions, so you certainly wouldn't want to do this by hand! There can also be problems with lots of dimensions

- If you are not careful to normalize your data, some dimension will end up having a larger impact than others
 - think about a 2D graph with is_red and length - if the length is between 0 and 100, but is_red is only 0 and 1, the length dimension will have a greater impact
 - Of course, you can use this to your advantage to weight particular parameters - if one of your dimensions is more important, you could increase the scale of that dimension slightly to add more weight
 
- PHPML has a normalizing pre-processor
    
---

class: content-even noheader tinycode

```php
$trainingData = [
   'apples' => [
      ['length' => 6.5, 'color' => 'red', 'shape' => 'round'],
      ['length' => 7, 'color' => 'green', 'shape' => 'round'],
      ['length' => 6.6, 'color' => 'yellow', 'shape' => 'round'],
      ['length' => 6.8, 'color' => 'red', 'shape' => 'round'],
   ],
   'bananas' => [
      ['length' => 12, 'color' => 'yellow', 'shape' => 'crescent'],
      ['length' => 12.5, 'color' => 'yellow', 'shape' => 'crescent'],
      ['length' => 11.8, 'color' => 'yellow', 'shape' => 'crescent'],
      ['length' => 11.5, 'color' => 'yellow', 'shape' => 'crescent'],      
   ],
   'oranges' => [
      ['length' => 7, 'color' => 'orange', 'shape' => 'round'],
      ['length' => 7.2, 'color' => 'red', 'shape' => 'round'],
      ['length' => 6.9, 'color' => 'orange', 'shape' => 'round'],
      ['length' => 7.5, 'color' => 'red', 'shape' => 'round'],      
   ]
];
```

???
- Given we have data in this format

---
class: content-even noheader tinycode

```php
$shapes = [];
$colors = [];
$maxLength = 0;

foreach ($trainingData as $fruits) {
   foreach ($fruits as $fruit) {
      $shapes[$fruit['shape']] = $fruit['shape'];
      $colors[$fruit['color']] = $fruit['color'];
      if ($fruit['length'] > $maxLength) {
         $maxLength = $fruit['length'];
      }
   }
}
```

???
- First we need to get a list of shapes and colours and find the maximum length

---
class: content-even noheader tinycode

```php
$samples = [];

foreach ($trainingData as $label => $fruits) {
   foreach ($fruits as $fruit) {
      $data = [
         'length' => $fruit['length'] / $maxLength
      ];
      foreach ($shapes as $shape) {
         $data['is_' . $shape] = (int) ($fruit['shape'] == $shape);
      }
      foreach ($colors as $color) {
         $data['is_' . $color] = (int) ($fruit['color'] == $color);
      }
      $samples[] = array_values($data);
      
      $labels[] = $label;
   }
}
```

???
- Then we need to assign a binary value for each `is_` statement, and normalize the length into a scale between 0 and 1

---
class: content-even noheader tinycode

```php
//length, is_round, is_crescent, is_red, is_green, is_yellow, is_orange

(0.52,1,0,1,0,0,0),
(0.56,1,0,0,1,0,0),
(0.528,1,0,0,0,1,0),
(0.552,1,0,0,0,1,0),
(0.544,1,0,1,0,0,0),
(0.96,0,1,0,0,1,0),
(1,0,1,0,0,1,0),
(0.984,0,1,0,0,1,0),
(0.944,0,1,0,0,1,0),
(0.92,0,1,0,0,1,0),
(0.56,1,0,0,0,0,1),
(0.568,1,0,0,0,0,1),
(0.576,1,0,1,0,0,0),
(0.552,1,0,0,0,0,1),
(0.6,1,0,1,0,0,0)
```

???

- This will give us some data like this - essentially very complex, multi-dimensional co-ordinates

---

class: section-title-b center middle bigcentralimg
# Stop, Demotime


![](machinelearning/images/explode.gif)

???

- Hell, if I'm going to do 1, I may as well do 3!

---

class: content-odd

# Attempt 3



???

- So, this is what we did - we took our data, normalised the numeric values and binarized the nominal data
- This resulted in quite a large test data - almost 200 dimensions!

---

class: content-odd

# Attempt 3

- Total Rows: 200
- False Positives: 42
- Missed Fraud: 33
- Identified Fraud: 67
- Identified Ok: 58

???

- With all the tests, the training data came from 2018 and the test data came from 2017
- A little better, but not great. Accuracy has improved to 62.5%
- The false positives dropped by 29 so that's good, but we also identified 3 fewer examples of fraud

---

class: section-title-c middle center

???

- Now this last set of results was better in that it reduced false positive (and false positives are worse than missed fraud in many ways, as customers will start to ignore the warnings)
- However, it still wasn't particularly accurate
- We played with the specific data a little and we could make it a little better, but it was still quite hit and miss

---

class: section-title-c middle center

# Lesson 4: Data Without Context is Meaningless

???

- We had already thought about context, however in our excitement to try out k-NN we didn't do anything about it!
- Now we started thinking perhaps that was something we needed to look at in more detail

---

class: content-even

# Context

- Consider 2 stores:
 - Average price $3 and the highest priced item $5
 - Average price $30 and the highest priced item $50
 
- Consider a player who makes all their purchases from France with an average price of $20
 - Suddenly now makes a purchase worth $40 from the USA
 
???

- This kinda makes sense - on a store where the average product price is $30 and there is a $60 rank, a  $50 purchase would be perfectly normal
- On a store where the average product price was $3 and the highest priced item was $5, that would be more suspect.
- Likewise, a purchase coming from the US is nothing suspicious, but if the player who made it usually makes all their purchases from France, it's probably worth investigating further.
- This is context - we need to provide a frame of reference to determine if something appears odd 


---

class: content-even

# Just Add Context

- We realised we needed to have a more 'representative' set of test data
- Decided to use k-NN again, but for a payment test it in two contexts
 - Is it normal for this store?
 - Is it normal for this player? 

???

- Considering what is normal for one store or one player might be different for another store, we decided that we should be asking two questions
- This will mean building 'per store' and 'per player' training data
- However, this may mean we have bigger data issues - what if a player has never charged back?!

---

class: content-even

# Per-Store Detection

- We created a custom test dataset for a single large store
 - For 2018 the store had 1,144 chargebacks, so we quadruple sampled those and took 5,000 'good' payments
- We then ran the same test (100 random chargebacks, 100 random 'good' payments from 2017):

???

- We started off with per-store detection to test our our theory
- We're still using k-NN, however this time we built a training dataset just using one large store.

---

class: content-even

# Per-Store Detection
- Total Rows: 200
- False Positives 40
- Missed Fraud 22
- Identified Fraud 78
- Identified Ok: 60

???
- We're making more progress - false positives are still high, but they are moving in the right direction, so we're on the right track
- Accuracy has improved overall to 69%, so we're getting there

---
class: content-even

# Next Steps
- Weighting dimensions
- Using different dimensions
- Different values for `k`
- Removing outliers from training data
- Different distance functions
- Weighted distance

???

- We're not finished with per store detection yet - we've identified a number of changes that we want to make to hopefully increase the accuracy further
- For all our tests we used the same dimensions - this wasn't based on any particular research, rather than what our gut instinct was as to what was important, so we're doing more research here
- Weighted distance we're particularly interested in - in standard kNN all votes are equal, but with a weighted distance, the closer the neighbour, the higher the vote.
 - Also further reduces the problem of imbalanced datasets

---
class: content-odd bigcentralimg center

# Per-Customer Detection

![](machinelearning/images/outlier.png)

???

- By applying a narrow context, it's likely that we won't have data for the two categories 
 - Particularly when looking at players, although it could apply to some lucky stores!
 

---

class: content-odd
# Anomaly (Outlier) Detection

- The main challenge with this approach is what happens if there is no data for a category?
- Instead of classifying, you need to be able to detect if something is dissimilar to the standard
- There are specific algorithms for anomaly detection, however we wanted to see first if we could use what we already had

???


- So in this situation we need to look at if the data doesn't match the pattern.
- We could have looked at other algorithms for anomaly detection, however we wanted to try and build upon what we were already doing, rather than having to start over.
 - Given that the k-NN is based on distances, could we use the distance to figure out if something was an outlier or not?

---
class: content-odd tinycode
# Average Distance
- Using the average distance that our test node is from its neighbours, we can see how close the relation is

```php
$this->distanceResults = [];

foreach ($distances as $idx => $distance) {
    $category = $this->targets[$idx];
    if (!isset($this->distanceResults[$category])) {
        $this->distanceResults[$category] = (object) ['count' => 0, 'total' => 0];
    }
    $this->distanceResults[$category]->count++;
    $this->distanceResults[$category]->total += $distance;
}
```

???
- If we compare the average distance against a 'baseline', we can then consider if the relation to its neighbours is strong or not
- In particular if we only have a single category, while it will be associated with that category, a high average distance suggests it's an outlier
- To test this theory, we added a basic distance gather to the PHPML library

---
class: content-odd noheader


```bash
Enter values (length shape color):12 crescent red
Classification: bananas

/var/www/html/talks/machinelearning/demos/k-nnNominal/knn.php:84:
array(1) {
  'bananas' =>
  class stdClass#4 (2) {
    public $count =>
    int(5)
    public $total =>
    double(7.0724930953961)
  }
}
```

???
- This was something totally new to us, so we wanted to test it a little to see if we were on the right track
- Using our test fruit data, this will clearly end in the banana category, but with a wrong colour, the average distance is 1.4
- At the moment we don't really know what this means! 

---
class: content-odd noheader


```bash
Enter values (length shape color):20 crescent green
Classification: bananas

/var/www/html/talks/machinelearning/demos/k-nnNominal/knn.php:84:
array(1) {
  'bananas' =>
  class stdClass#4 (2) {
    public $count =>
    int(5)
    public $total =>
    double(7.7592234379052)
  }
}
```

???
- Given something even further out (longer than all measured bananas as well as the wrong colour), the average becomes 1.6
- It looks like we should be able to use the distance metric, but we still need to understand what 'normal' looks like


---
class: content-odd noheader


```bash
Enter values (length shape color):12 crescent yellow
Classification: bananas

/var/www/html/talks/machinelearning/demos/k-nnNominal/knn.php:84:
array(1) {
  'bananas' =>
  class stdClass#4 (2) {
    public $count =>
    int(5)
    public $total =>
    double(0.12)
  }
}
```

???
- Now something that fits right in the middle of our definition, the average distance is 0.03 - clearly a much closer relationship

---

class: content-even

# Testing Outlier Data

- Identify players who had chargebacks and payments
- We used the same k-NN logic
 - Slightly weighting towards the gateway and price
- Our training data consisted of all their 'good' payments, minus 2 selected at random to provide a 'benchmark'
- Calculate the average distances from the 3 closest nodes for each chargeback and the 2 benchmarks

???
- It's clear that distance should be usable - now we just need to see if we can apply it to our data
- We wanted to test our theory that we could use per user data and k-NN to detect outliers
- We couldn't _just_ use the chargebacks in our tests - we needed a benchmark, otherwise we wouldn't know if the distances actually indicated anything! 
- The challenge is that we can't 're-use' nodes that are in the training data, as this would result in a direct node match
 - So we hold back a few rows, but we don't want to do too many, as it will make the training data less accurate
 
---

class: content-odd noheader

```text
Testing 190xxxxxxxxxxxxxxxxxxxxxxx....
==================================

Chargeback Payment:1.1872336570396
Chargeback Payment:1.4779211824791
Chargeback Payment:1.6229499861217
Chargeback Payment:1.5236747120244
Chargeback Payment:1.5237703564851
Chargeback Payment:0.60773455316207

Good Payment:0.1679864461184
Good Payment:0.14942297231428

```

???

- Promising start - the chargebacks clearly have a larger average distance, and all but 1 of them are greater than 1

---
class: content-even noheader

```text
Testing 02exxxxxxxxxxxxxxxxxxxxxxx....
==================================

Chargeback Payment:3.0020142747812
Chargeback Payment:1.1864034895882
Chargeback Payment:0.87523976545558
Chargeback Payment:2.1651125859505

Good Payment:0.55511596217409
Good Payment:0.81945260174838

```
???

- It's a little close between one of the 'good' payments and one of the chargebacks, but again the is a larger distance


---
class: content-odd noheader

```text
Testing 831xxxxxxxxxxxxxxxxxxxxxxx....
==================================

Chargeback Payment:0.63938892472403
Chargeback Payment:0.019601099746028
Chargeback Payment:0.019600041892108

Good Payment:0.48301644066744
Good Payment:0.000003491556342439
```

???

- Not so clear cut here perhaps!


---
class: content-even noheader

```text
Testing 000xxxxxxxxxxxxxxxxxxxxxxx....
==================================

Chargeback Payment:0.32017785763205
Chargeback Payment:1.6980250494606
Chargeback Payment:1.0208325570467
Chargeback Payment:0.37633747952314
Chargeback Payment:0.18633733492969
Chargeback Payment:0.15680374121066
Chargeback Payment:1.4603719860593
Chargeback Payment:0.60438004711323

Good Payment:0.0000015421118358009
Good Payment:0.0066896309102721

```

???

- Again this is clearly different in the two groups, but the average distance is generally much smaller


---
class: content-odd noheader

```text
Testing 6A7xxxxxxxxxxxxxxxxxxxxxxx....
==================================

Chargeback Payment:0.56366499476764
Chargeback Payment:1.8057199858974
Chargeback Payment:2.0016497657224
Chargeback Payment:2.0098944414866
Chargeback Payment:2.0825587191076
Chargeback Payment:2.5291528630334
Chargeback Payment:2.5000000421223
Chargeback Payment:2.5291796811078
Chargeback Payment:2.5019182493386

Good Payment:0.000093996082221433
Good Payment:0.000055741862712711

```

???

- And again, a fairly clear difference!

---

class: content-odd

# Testing Outlier Data

- In many situations, the distance for a chargeback is greater than the distance of our 'control' payments
- We can use this to detect outliers - however there isn't a 'fixed' value we can use
- We have to calculate what 'outlier' means for each customer

???

- These tests were very promising - it does indeed appear that the distances are often greater for chargebacks
- However it's clear we can't just pluck an arbitary number out of the air for what constitues a chargeback! 

---

class: content-odd

# Testing Outlier Data

- Calculate the average 3-NN distance between the 'known' values
- If the 3-NN distance of this payment is greater than the average + standard deviation, then flag the payment
- So, how did this work?

???

- So, we added some logic to work out what a typical 'good' payment looks like for a given customer
 - based on the average distance between the good payments in the training data'
- Even based on the numbers above, we're not going to pick up on every payment, but that's not the point
- If we reduced chargebacks by 20% that would relate to 4,700 payments in 2018, which would be a win in itself
- Knowing what you are trying to achieve is important - in our situation reducing chargebacks by 30% is a better win than reducing chargebacks by 60% but flagging 30% of legitimate payments


---

class: content-even

# Testing Outlier Data

- Total 'good' payments in test: 336
- Total 'chargeback' payments in test: 786
- 'Good' payments correctly identified: 286 (85%)
- 'Chargeback' payments correctly identified: 242 (31%)

???

- We did quite a big test of this - we found a number of customers that had chargebacks we could test with but also had 'good' payments - again we kept a few 'good' payments back from each dataset to validate
- As much as 31% doesn't sound impressive, this seems to be moving in the right direction
 - Reducing false positives was the big priority, and we've brought that down from 42% in our first k-NN test to 15%
 - If in 2018 we'd identified 31% of chargebacks that would equate to 7,000 payments - still a big improvement! 

---

class: content-odd center

# Progress!

![](machinelearning/images/progress.jpg)

???

- Ok, so we're not at the end yet, but we've managed to go from something totally unusable to something that has benefits
- We still have a way to go, sure, but applying some of the ideas we discussed before:
    - Weighting dimensions /  different dimensions
    - Different values for `k`
    - Removing outliers from training data
- we should be able to improve this further.



---

class: summary-slide noheader

- Have an aim before you start - understand what you are trying to achieve
- Machine Learning is hard! Use the simplest techniques that will achieve your aims
- Supervised learning algorithms are sensitive to misleading data - data will need processing to remedy this
- Experiment! Trying ideas, testing theory and iterating will help you learn more and more as you progress


???

- For Tebex, this is very much the beginning - we've continually re-defined what we want to achieve, and setting these aims early has helped us better refine our algorithm and data choices
 - From trying these things out, we know that certain dimensions are a better pointer than others, and that localised per-user and per-store testing is better than global testing

 
 
---


class: summary-slide noheader

- Have an aim before you start - understand what you are trying to achieve
- Machine Learning is hard! Use the simplest techniques that will achieve your aims
- Supervised learning algorithms are sensitive to misleading data - data will need processing to remedy this
- Experiment! Trying ideas, testing theory and iterating will help you learn more and more as you progress


???

- Perhaps we will consider more complex algorithms in future, but ultimately if we can understand what's going on and why we get certain results, we're more likely to be able to improve it
 - In particular, if you don't _know_ your data, try things out on simple, predictable experiments first - just to make sure what you think you are predicting you are actually predicting!
 
---


class: summary-slide noheader

- Have an aim before you start - understand what you are trying to achieve
- Machine Learning is hard! Use the simplest techniques that will achieve your aims
- Supervised learning algorithms are sensitive to misleading data - data will need processing to remedy this
- Experiment! Trying ideas, testing theory and iterating will help you learn more and more as you progress


???

- We learned so much doing this - we've made many mistakes, and learned many lessons during our journey. We're still on this journey ourselves -
now comes the easy bit - working out how to integrate this into our application (!), and iterating and improving some more.

 
---

class: thanks-slide

.conference[![](logos/%%conference%%.png)]
.introimg[![](http://tebex.co.uk/img/tebex.svg)]

# Thank You

### %%joindin%%
### Liam Wiltshire
### @l_wiltshire
### liam@tebex.co.uk
