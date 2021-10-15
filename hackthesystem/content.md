class: title-slide longtitle

.conference[![](logos/%%conference%%.png)]
.introimg[![](hackthesystem/images/hack.png)]

# Hack The System
## Common ways to attack your platform

???

@TODO

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

- Checkout and payments platform in the gaming space
- We do all the boring 'business' - 100 int'l payment methods, tax, compliance, AML, so our partners can focus on what they do best - making awesome games and experiences

- For the context of this talk, when we refer to a 'hack' or 'hacker', we're referring to the type that is involved in system vulnerabilities, breaking into systems etc - not the developer sort! 

---

class: section-title-a center centralimage
# What This Talk Is
.highres[![](impostor/images/question.png)]

.reference[Human Vectors by Vecteezy (vecteezy.com/free-vector/human)]

???

---
class: section-title-a centralimage
# What This Talk Is

- How to think about attacks
- Attacks I've seen in the real world
- Things that are likely to be in your codebase
- Things that can be fixed quickly
- Tools that you can use yourself

???

- We're not going to look at really old, attacks that won't work on any half-patched system today
- We're not going to look at the crazy-complicated attacks that you're unlikely to see unless you are facebook

- So, before we look at some actual examples of attacks, I want to help you find vulnerabilities in your own systems, and know what to do when you find one (or have one reported to you)
 - In order to do this, it's often helpful to think like a hacker.
---

class: section-title-b center centralimage

# What are Attacks Intended For?
.highres[![](hackthesystem/images/whyhack.png)]

.reference[Technology vector created by macrovector (freepik.com/vectors/technology)]

???

- To start to identify likely targets, it's useful to think about _why_ a hacker might attack a system.
- After all, a hacker is unlikely to waste time trying to find a way into a particular part of the system if it's not worthwhile for them
 - So what are some of the reasons a hacker might attack a system?

---

class: content-even

# Take Down A System

- For profit or for fun
- Is likely to target parts of the system that can cause network or hardware disruption
 - CPU or network expensive activities
 - Self-replicating activities (fork bomb)

???

- Profit could be ransom
- It could also be a DDOS service that is being purchased by someone else

---

class: content-odd

# Gain Access To Data

- Data is valuable
 - Personal data can be resold
- You might not think the data you have is valuable
 - Could it be combined with other data?

???

- Doesn't have to be login data
- Imagine you had a service that allowed you to send yourself birthday reminders
 - Those dates might be 'memorable details' associated with that email address on another system (or a PIN number etc)

---

class: content-even

# Promoting Skills and Software

- Some attacks can be a 'billboard' to advertise the attackers skills, services or software
- Attacks will be promoted on hacker forums
- A DDOS service might launch attacks to demonstrate the power of their network, in order to gain customers

???

- Likely to be against more visible or known targets - at least within a certain industry

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
- Some of the others are the sorts of attacks we'll talk about in 'level 1'

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

- VRT is a resource that outlines baseline priority ratings for common vulnerabilites
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

- The highre the 'P' score, the more critical
 - obviously bypassing authentication is bad!!
 - Application-level DOS (rather than being at the network-level) - it's more critical because it's either wide-reaching or easy to do - there is another (lower) rating for harder or narrower in scope attacks
 - Session Fixation - requires quite a few things to go 'right' (we'll look at what session fixation is shortly), and usually only catches a single user at a time, hence lower rating
 - Email triggering - most likely not going to have a major impact, more annoying for the recipient, with a potential loss of goodwill for the company
- There are also P5s, which in most uses are effectively ignored (no reward on a bug bounty, not really addressed unless a developer literally has nothing else to do)

---

class: content-odd

# Risk Impact Matrix

![](hackthesystem/images/riskimpact.png)

???

- Another way to assess is with a risk-impact matrix
_ Here you assess the probability of a given exploit being used (consider how easy it is and how readily discoverable it is) and the impact
   - Something that would be difficult to exploit and would (for example) only result in some emails being sent would likely be 'Very Low', whereas the ability to bypass authentication using a query string that gave full admin access to all your customer a would be Critical!

---
class: content-odd

# Coping Mechanisms
- Refrain from comparison
- Keep a 'success log'
- Ask for support
- Break the cycle

???

- Sometimes, impostor syndrome will just be there - there will be bad days that you just have to survive
- Some of the things I've done (and still do):

- Try to avoid comparing yourself wth others
 - as we've discovered, your brain will exaggerate their successes (and what is perceives as your failures) to fit it's own narrative

- Keep a 'success log'
 - I still keep a notebook with achievements in that have been recognised by my peers as successful - you can then refer to this when you are having a tough day to remind yourself that you have recognised successes that counter-balance the current struggles
  
---
class: content-odd

# Coping Mechanisms
- Refrain from comparison
- Keep a 'success log'
- Ask for support
- Break the cycle

???

- Ask for support
  - Remember how we said success was a team sport? Ask someone you know and trust to help you make some wins - remember your brain might try to pass the wins off as completely down to the other person, so keep note of your contributions as evidence that it was a combined win
- Break the cycle
  - Trying to do something new (or particularly difficult) on a 'survival' day provides your dumb brain with plenty of ammo to remind yourself that you are a fraud - the fact you can't immediately do 'x', which your brain will tell you everyone else can (even though they probably can't), will trigger the cognative bias into overdrive.
  - Do something else - partake in a guilty pleasure, if that's singing in the shower, or a glass of wine in the bath go for it!, or pick up other task that you know will be a 'quick win' to remind you of your successes.

---
class: content-even

# Retrain Your Brain
- Talk
- Be a mentor
- Assessments
- Learning and Development

???

- While we can survive the difficult days, and surviving those days is an achievement in itself, we can do more
- Our brains love data, and forming patterns in data, so with a little (ok, a lot) of persuading, we can start getting it to think in different ways
- As with anything involving the brain, practice, practice, practice - repetition is vital

- Talk
 - Find a safe space, a support group that you can share with - with Impostor syndrome we often believe we're the only ones - no-one else seems to be strugling, it's just me
 - The reality is that they probably are (remember that statistic at the start), but, like you, they do their best to hide it
 - Sharing experiences, coping mechanisms, and wins reminds us that, we're all human, we're all imperfect, but that's the best way to be!


---
class: content-even

# Retrain Your Brain
- Talk
- Be a mentor
- Assessments
- Learning and Development


???

- Being a mentor might seem insane - if you can't convince yourself you know what you are talking about, how in hell can you convince someone else?
 - But that's kind of the point
 - By taking the time to mentor someone else, and share with them what you _do_ know, you are proving to yourself (and your dumb brain) that actually you know alot more than it gives you credit for
 - And, remember there is a good chance they are thinking/feeling the same as you, that they don't know what they are doing - so by teaching them, and helping them skill up, you are actually giving them ammo to fight their own Impostor syndrome as well

---
class: content-even

# Retrain Your Brain
- Talk
- Be a mentor
- Assessments
- Learning and Development

???

- Remember we said your brain likes evidence? But it also likes to twist evidence?
 - Look at potential external assessments you can do - maybe that will be a short course with an exam at the end, or an industry-recognised certification
 - If you have data from an un-associated third party (one that, let's be honest, probably doesn't care if you pass or fail!), then your brain can't really twist that to fit it's narrative, and has to start accepting, maybe you do know something after all!
- Finally, learning and development - we'll come onto this shortly, but essentially, by learning new skils and undertaking personal development, you are proving to your brain that you must have the skills and knowledge required to learn new things

---

class: section-title-c center centralimage

# Impostor Syndrome As A Superpower
.highres[![](impostor/images/success.png)]

.reference[Human Vectors by Vecteezy (vecteezy.com/free-vector/human)]

???

- So far, we've looked at how impostor syndrome can negatively impact you, and how to overcome it
- However, it's not all bad
- There are actually a number of ways in which Impostor Syndrome can help you become your very own superhero!

---

class: content-odd

# Soft Skills

- Studies (Tewfik, B, 2021) have shown that individuals who experience impostor syndrome are considered to have better interpersonal skills, be more empathetic and be better facilitators and collaborators
- This may well be because we use those skills to hide the fact we are frauds (or at least, we think we are)

---

class: content-even

# Continually Improving Skills

.smallish[- Someone with impostor syndrome may spend more time trying to develop the skills they think they are missing
- Studies show that experiencing impostor syndrome drives diligence, hard work and desire to reach higher standards (Flett et al.,
1992) and (Stober & Childs, 2010).
- To someone with impostor syndrome, any amount of improvement probably never seems good enough, but we can harness this to maximse our development]

???

- When you think about it, it makes sense that someone who believes they are faking it and doesn't have the skills they need will spend contact hours trying to develop and build those skills
 - Studies find they still won't display those skills in public, but they're continually spending time trying practising their craft
- This can be dangerous, as impostor syndrome and perfectionism often go hand in hand, and holding yourself to an impossibly high standard is again giving your brain evidence that fits what it believes
 - and that is where our success log and external assessment comes in
- But what if we can harness that desire, maximise our ability to learn, and prove to our dumb brain that we are better than that, all at the same time?

---

class: content-odd halfhalf

# Power Up Your Learning

.withtitle[.smallish[- The often make is going 'too fast', trying to jump up the ladder as quickly as possible
- However, we actually gain the most from being in the 'sweet spot']]

.right[![](impostor/images/target.png)]

???

- If you feel you are missing skills, the danger is to try and learn everything all at once. However, it's important to learn in your 'sweet spot'
  
- Imagine that target represents your ability - right now you are in the red zone:
- Too easy (the middle), and no learning takes place
- At your current skill level re-enforces what you know, but doesn't help you improve
- Slightly harder (the ourter circle), builds upon what you already know, but in an achivable way
- Significantly harder (off the target) - you might struggle through it with help (depending on _how_ much harder it is), but you are not going to be able to learn from it

---

class: content-odd halfhalf

# Power Up Your Learning

.withtitle[.smallish[- The often make is going 'too fast', trying to jump up the ladder as quickly as possible
- However, we actually gain the most from being in the 'sweet spot']]

.right[![](impostor/images/target.png)]

???

- An example of this is learning to read - a child who knows the letters of the alphabet won't gain too much (other than confidence) by repeating the letters of the alphabet over and over.
- They are likewise not going to be able to go from knowing the individual letters to reading war and peace, no matter how much help they get.
- However, with a little bit of guidance and help from a teacher or an older student, could read words like 'dog' or 'cat'.

- This is called Vygotsky scaffolding (Vi - got - ski), where you can build upon your existing knowledge (and prove your existing knowledge to yourself at the same time) with a little assistance (be that a mentor, or a resource online for example) in incremental steps, like building scaffolding a layer at a time

- Remember, record all the learning you do in your achievement log, so that can can build up this 'portfolio of proof' to show your brain when it's trying to screw you over.
---
class: halfhalf reverse content-even

# Teach Others

.withtitle[.smallish[- Teaching something you've learned to others helps you to fully understand it
- Explaining concepts to another person is a different way of learning - the more methods you use, the more effective it will be]]

.left[![](impostor/images/teaching.png)]

???

- We've already discussed how mentoring and sharing knowledge is a method of retaining your brain
- By using this method to share something you've just learned, you get two effects for the price of one:
 - Explaining new concepts is a common method of consolidating and internalizing learning, as well as proving to yourself that you have learned this new topic at the same time!


---

class: content-odd

# Observations

- Please don't tell someone they have impostor syndrome
 - While well-intentioned, it often makes things worse
- There are other reasons individuals can feel like frauds
 - External discrimination or outdated views repeated often enough can be internalised
- There is an opposite of Impostor Syndrome - the Dunning-Kruger Effect!

???

- Something that can be very dangerous is telling someone they have impostor syndrome.
- Imagine a situation where someone is trying to do something really hard - way above their current level. They ask for help, saying they don't understand it and can't do it, but the response they get is "Oh, that's just impostor syndrome, you'll be fine".
 - Actually, in that situation they need help!! If someone trusts you enough to share their struggles with you, then help them cope, then help them retrain their brain, but please don't make an assumption first
- While way outside the scope of this talk, not all feelings of inadequacy or feelings of being a fraud are impostor syndrome - many minorities have been the subject of outdated views, for example, that when repeated often enough, can feel true to the individual involved
- In case anyone is wondering, there is an opposite of Impostor Syndrome - unfortunately we don't have time to talk about it right now, but let's just say the study that gave it it's name, the Dunning-Kruger effect came from a news report of a bank robber who covered his face in lemon juice, thinking it would hide his face in the same way it can be used as inivisble ink!!

---
class: summary-slide middle

Impostor syndrome is way more common than we realise - we see our peers as successful and high-achieving, when inside they might feel just the same as we do. Support each other on the bad days, and share in successes on the good.

Impostor syndrome is usually seen as bad - but using it as your superpower lets you prove to yourself that you are way more skilled than you give yourself credit for.

---



class: thanks-slide

.conference[![](logos/%%conference%%.png)]
.introimg[![](http://tebex.co.uk/img/tebex.svg)]

# Thank You

### %%joindin%%
### Liam Wiltshire
### @l_wiltshire
### liam@tebex.co.uk
