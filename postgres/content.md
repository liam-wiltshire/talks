
class: title-slide

.conference[![](logos/%%conference%%.png)]
.introimg[![](postgres/images/pglogo.png)]

# PostgreSQL
## For mySQL users

---

class: section-title-c bottom left vanity-slide

# Liam Wiltshire
## Senior PHP Developer<br /> & Business Manager

---

class: vanity-cover

background-image: url(logos/mcft.png)

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

<span style='font-size:100px'>?</span>

---

class: section-title-a center centralimg
# Performance

![](postgres/images/performance.png)

---

class: content-even
- For simple uses, there isn't going to be much difference
   - Until recently, mySQL was faster for simple SELECTs
   - This has become more even in recent releases
   - mySQL still tends to be faster for writes

- Performance benefits come in more complex situations
   - Joins
   - Unions
   - Sub Queries

---

class: content-even
# Basic SELECT

---

class: content-even
# JOINs

---

class: content-even
# UNIONs

---

class: content-even
# Sub Select

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

- Postgres has two JSON document types
   - JSON is really just a text field that enforces validation
   - JSONB stores the data as a binary representation
- JSONB data tends to be larger than JSON data, but is much more flexible and quicker to query

---

class: content-even
# JSONB

- Slightly slower write, much quicker read
- Indexable with a GIN index
- Data returned may not be identical

???

Doesn't need re-parsing
Steal this example: https://www.citusdata.com/blog/2016/07/14/choosing-nosql-hstore-json-jsonb/

---

class: content-even

```sql
CREATE TABLE talks (id UUID, data JSONB);
INSERT INTO talks values (
  uuid_generate_v4(),
  '{
     "title": "Postgres for mySQL Users",
     "summary": "An awesome talk"
   }');
```

---

class: content-even
```sql
CREATE INDEX idx_talks_data 
ON talks USING gin(data);
```

```sql
-- Find rows that contains this data
SELECT * FROM talks 
WHERE data @> '{"title": "Postgres for mySQL Users"}';
-- Find rows that have any summary
SELECT * FROM talks WHERE data ? 'summary';
```

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

```sql
[root@w ~]# su postgres 
bash-4.1$ psql
psql (8.4.20)
Type "help" for help.
postgres=# CREATE DATABASE lwdatabase;
CREATE DATABASE 
postgres=# CREATE USER lwuser;
CREATE ROLE
```

---

class: content-odd

```sql
postgres=# GRANT ALL ON DATABASE lwdatabase TO lwuser;
GRANT
postgres=# ALTER USER lwuser WITH PASSWORD 'pgpass';
ALTER ROLE
```

## Now you can access postgres as that user

```bash
[root@w ~]# psql lwdatabase lwuser
```

---

class: content-even
# Schemas

- A single database can have multiple chemas
    - The default is 'public'
- Essentially gives a single database namespaces
    - Different schemas can have different owners / users with different levels of access
    
---

class: content-even

```sql
SELECT * FROM public.staff;
-- ewwww

set search_path TO public;
SELECT * FROM staff;
```

---

class: content-odd
# Auto Increment

- `AUTO_INCREMENT` doesn't exist!
    - Isn't SQL-Standard
- In Postgres, we define a `SEQUENCE` - this is a separate entity to the table
- We then use the `nextval()` function to use it in our table

---

class: content-odd

```sql
CREATE SEQUENCE talks_sequence_id INCREMENT BY 1
 ↳ START 1 NO CYCLE;
CREATE SEQUENCE 
```

---

class: content-odd

```sql
CREATE TABLE talks (
* talk_id smallint NOT NULL DEFAULT
*   ↳ nextval('talks_sequence_id'),
date timestamp,
* title character varying(254),
slides character varying(254)
);
CREATE TABLE
```

---

class: content-odd
# Auto Increment

- We don't have to do it all manually
- There is a 'serial' datatype that will create a sequence automagically

---

class: content-even
# Enums

- Postgres doesn't have an enum type
    - Instead, you have to define an enum as it's own data type
- Enums are not directly comparable
    - You have to cast them to something else (a string usually) to compare them
    
---

class: content-even

```sql
CREATE TYPE display_state AS ENUM
   ('public','password','private');
CREATE TYPE
```

---

class: content-even

```sql
CREATE TABLE abstracts (
* abstract_id SERIAL, 
title character varying(254), description text,
* display display_state );

NOTICE:  CREATE TABLE will create implicit sequence 
"abstracts_abstract_id_seq" for serial column "abstracts.abstract_id"
CREATE TABLE
```

---

class: content-odd
#What Fields Do We Have?

```sql
DESCRIBE talks;
ERROR:  syntax error at or near "DESCRIBE" 
```
Ahh...
```sql
SELECT column_name, data_type, character_maximum_length 
  FROM INFORMATION_SCHEMA.COLUMNS 
  WHERE table_name = 'abstracts';
```

---

class: content-odd
```
column_name  | 	data_type     | character_maximum_length
-------------+-------------------+--------------------------
 abstract_id | integer           |
 title       | character varying |                  	254
 description | text              |
 notes       | text              |
 slides      | character varying |                  	254
 display     | USER-DEFINED      |
(6 rows) 
```

---

class: summary-slide middle

- Postgres *isn't* the solution for every database requirement
- But it should be considered as an option, particularly in complex-read-heavy situations
- Benchmark!

---

class: thanks-slide

.conference[![](logos/%%conference%%.png)]
.introimg[![](http://tebex.co.uk/img/tebex.svg)]

# Thank You

### %%joindin%%
### Liam Wiltshire
### @l_wiltshire
### liam.wiltshire@tebex.co.uk


