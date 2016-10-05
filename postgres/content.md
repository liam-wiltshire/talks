
class: title-slide

.conference[![](logos/%%conference%%.png)]
.introimg[![](postgres/images/pglogo.png)]

# PostgreSQL
## For mySQL users

---

class: section-title-c bottom left vanity-slide

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
# Partial Indexes

- Indexes can be defined that are only created for rows that meet a certain condition
- For example, if you had a table that used soft delets, then you could index *only* non-deleted rows

---

class: content-odd

```sql
liamwiltshire=> CREATE INDEX page_slugs ON pages  ( slug )
 ↳ WHERE deleted = 0;
 CREATE INDEX
```

---

class: content-even
# Connection Model

- Postgres uses a process per connection model
    - By comparison, mySQL has a single process with multiple threads
- While it does create extra overhad when creating the connection, there are multiple benefits

---

class: content-even
# Connection Model

- Works with *nix tools like ps, top, kill
    - Use the OS to identify/kill individual problem connections
- Processes are isolated from each other
- Concurrency tends to be improved

---

class: content-odd
# Stored Procedures

- Both Postgres and mySQL support stored procedures (stored functions)
- Postgres will let you write them in many languages:
    - SQL, Perl, Python, JavaScript etc.
- mySQL only supports SQL

---

class: content-even
# Expression Indexes

- Postgres will let you create an index based on the result of an expression
- This can then be relied on in queries that would otherwise have to run this (potentially expensive expression at runtime)

---

class: content-even

```sql
CREATE INDEX last_name_lower ON people (lower(last_name));

SELECT * FROM people WHERE
  lower(last_name) = lower('Wiltshire');
```

---

class: content-odd
# Data Types

- Postgres has lots of interesting data types for specific cases:
    - Geometry - point, line, box, polygon, circle.
    - Network - macaddr, cidr, inet
    - UUID
    - Range - int4range, tsrange, daterange

---

class: section-title-c middle halfhalf
background-image: url(postgres/images/nosql.png)

.col1[# 'NoSQL' Features]

---

class: content-even
# JSON/JSONB

---

class: content-odd
# XML

---

class: content-even
# hstore

---

class: section-title-a middle halfhalf reverse
background-image: url(postgres/images/elephantsbetter.png)

# Using Postgres
## (as a mySQL user)

---

class: content-odd
#Installation

- Can be installed using your OS package manager (yum, apt, dnf etc)
- Creates a user `postgres`
    - This account is required for admin access
    
---

class: content-odd

```bash
[root@w ~]# su postgres 
bash-4.1$ psql
psql (8.4.20)
Type "help" for help.
postgres=# CREATE DATABASE lwdatabase;
CREATE DATABASE 
postgres=# CREATE USER lwuser;
CREATE ROLE
```
