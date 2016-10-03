
class: title-slide

.conference[![](logos/%%conference%%.png)]
.introimg[![](postgres/images/pglogo.png)]

# PostgreSQL
## For mySQL users

---

class: section-title-c bottom left

# Liam Wiltshire
## Senior PHP Developer & Business Manager

---

?

---

class: summary-slide middle

- Working with PHP for 10 years
- Still involved in a hands-on role
- Awesome Facilitator, great leader

---

class: section-title-a middle center

# What is PostgreSQL?

---

class: summary-slide middle

- A database management system
- Over 20 years old
- Obsessed with data consistency
- Feature rich
- ACID compliant

---

class: centralimg middle center

![](postgres/images/elephantsbetter.png)

---

class: summary-slide middle center

?

---

class: section-title-a center centralimg

# Performance

![](postgres/images/performance.png)

---

Todo

---

class: section-title-b center centralimg

![](postgres/images/swissarmy.png)

# Features

---

class: content-odd

#.center[Partial Indexes]

- Indexes can be defined that are only created for rows that meet a certain condition
- For example, if you had a table that used soft delets, then you could index *only* non-deleted rows

---

class: content-odd

```sql
liamwiltshire=> CREATE INDEX page_slugs ON pages  ( slug )
 ↳ WHERE deleted = 0;
 CREATE INDEX
```