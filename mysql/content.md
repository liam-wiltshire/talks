
- NoSQL Features
- Spatial Data
- GTID replicas
- EXPLAIN on DELETE/UPDATE/INSERT/REPLACE
- User Roles
- Generated Columns
- EXPLAIN FORMAT = JSON
- Offline Mode
- Invisible Indexes
- Descending Indexes

---

class: title-slide longtitle

.conference[![](logos/%%conference%%.png)]
.introimg[![](mysql/images/mysql.png)]

# Adventures in mySQL
## Awesome features<br />you're probably missing

???

- Postgres is a DB that we've probably all heard of, but perhaps not used
- It's actually has a lot of selling points in a number of situations
- Hopefully by the end of the talk I'll have convinced you to consider Postgres for your next project

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
# But, everyone knows MySQL right?

---

class: summary-slide middle

- MySQL has always been the 'go to' RDBMS for most PHP devs
- However, we tend to use the same core features over and over
- Over the years MySQL has added lots of new features

???



---

class: middle center section-title-b

# New Storage Engine: IRLdb

![](mysql/images/query.png)

---

class: middle center section-title-b

# New Storage Engine: IRLdb

![](mysql/images/query-no.png)

???

- In real life DB... ok, so that doens't exist yet, but I'm sure we'll get there!

---

class: summary-slide middle center

<span style='font-size:100px'>?</span>

???

- Ok, so we will look at some actual features that are in mySQL
- Some of them are brand new, some of them are a little older, but possibly overlooked
- If any of you know about all of these features, come see me afterwards, and you can deliver the talk next time!


---


class: section-title-c middle halfhalf
background-image: url(postgres/images/nosql.png)

.col1[# 'NoSQL' - JSON]

---

class: content-even
# [5.7] JSON

- MySQL now has a native JSON type
- Data is stored in a binary format
   - This means that the text doens't need to be parsed each time.
   - Sub-objects and nested values can be queried directly

???

---

class: content-even
# Indexing

- Like other binary columns, you cannot index JSON columns
- There are some alternative solutions
- MySQL will do some type juggling of JSON data
    - Review the documentation

???


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

???

- These examples are by no means exhaustive
- Testing on a pretty standard server
- Just gives a rough idea of performance
- Using a modified version of a dummy 'employee' database with c. 300,000 records 

---

class: content-even
# Basic SELECT (no index)

```sql
lwdatabase=> SELECT * FROM employees WHERE gender = 'F';

Postgres: 0.35 sec / mySQL: 0.15 sec
```

???

- First value is postgres, second is mySQL

---

class: content-even
# JOINs

```sql
SELECT * FROM employees e
 INNER JOIN dept_emp de ON de.emp_no = e.emp_no
 INNER JOIN departments d ON d.dept_no = de.dept_no
 WHERE e.gender = 'F' AND d.dept_name = 'Development';

Postgres: 0.57 sec / mySQL: 0.61 sec
```

---

class: content-even
# UNIONs
```sql
( SELECT e.* FROM employees e INNER JOIN dept_emp de ON de.emp_no = e.emp_no
 INNER JOIN departments d ON d.dept_no = de.dept_no
 WHERE e.gender = 'M' AND d.dept_name = 'Finance' )
UNION ( SELECT e.* FROM employees e INNER JOIN dept_emp de ON de.emp_no = e.emp_no
 INNER JOIN departments d ON d.dept_no = de.dept_no
 WHERE e.gender = 'F' AND d.dept_name = 'Development' );

Postgres: 0.61 sec / mySQL: 0.81 sec
```
---

class: content-even
# Sub Select

```sql
SELECT * FROM (
SELECT e.* FROM employees e INNER JOIN dept_emp de ON de.emp_no = e.emp_no
INNER JOIN departments d ON d.dept_no = de.dept_no
WHERE e.gender = 'F' AND d.dept_name = 'Development'
) a 
WHERE first_name LIKE 'F%';
Postgres: 0.37 sec / mySQL: 0.60 sec
```

---

class: section-title-b center centralimg

![](postgres/images/swissarmy.png)

# Features

---

class: content-odd
# Partial Indexes

- Indexes can be defined that are only created for rows that meet a certain condition
- For example, if you had a table that used soft deletes, then you could index *only* non-deleted rows

???

- Creating good indexes are important for getting the best performance out of any RDBMS
- However, you can end up in situations where you index data you don't need - making updating the INDEX slower
- With PostGres, you can add a where clause to your INDEX, to only index rows that satisfy that condition

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

???

- THis is similar to Firefox/Chrome


---

class: content-even
# Connection Model

- Works with *nix tools like ps, top, kill
    - Use the OS to identify/kill individual problem connections
- Processes are isolated from each other
- Concurrency tends to be improved

???

- Who has had the situation where all the mySQL connections are used, and you can't even get onto the server to kill some?
- Postgres this isn't an issue as you can use your standard *nix tools to remove processes

---

class: content-odd
# Stored Procedures

- Both Postgres and mySQL support stored procedures (stored functions)
- Postgres will let you write them in many languages:
    - SQL, Perl, Python, JavaScript etc.
- mySQL only supports SQL

???

- Most languages support stored procedures in some way, so why is this a feature?
- It's to do with the wide range of languages you can write stored procedures in

---

class: content-odd

```sql
CREATE FUNCTION stripwww(text) RETURNS text AS
'
import re
Text1 = re.sub(''www.'', '''',args[0])
return Text1
'
LANGUAGE 'plpython';
```

---

class: content-even
# Expression Indexes

- Postgres will let you create an index based on the result of an expression
- This can then be relied on in queries that would otherwise have to run this (potentially expensive expression at runtime)

???

- Similar to partial indexes before, Postgres will also let you create an index on the result of an expression
- This might be a function that would otherwise be expensive, or some data transformation that is regularly needed
- Arguably, you should store the data better if you are having to perform expensive functions often, but sometimes it's unavoidable

---

class: content-even

```sql
CREATE INDEX last_name_lower ON people (lower(last_name));

SELECT * FROM people WHERE
  lower(last_name) = lower('Wiltshire');
```

???

- This is a common example, because Postgres is case sensitive

---

class: content-odd
# Data Types

- Postgres has lots of interesting data types for specific cases:
    - Geometry - point, line, box, polygon, circle.
    - Network - macaddr, cidr, inet
    - UUID
    - Range - int4range, tsrange, daterange

???

- Some of this stuff is starting to working into it's way into mySQL
 - Spatial data for example
 - But it's more mature in Postgres
- The range fields are particularly interesting

---

class: content-even
# RETURNING

- In Postgres we can define an expression to return from an input
- This could be one column (say the increment ID), or the whole row

```sql
INSERT INTO talks (title)
 VALUES ('Postgres for mySQL Users') RETURNING talk_id
```



???

- This works in the same way as aclling last_insert_id(), but without having to call it!!

---

class: section-title-a middle halfhalf reverse
background-image: url(postgres/images/confusion.jpg)

# Using Postgres
## (as a mySQL user)

???
- Despite my 'halarious' image, ut's not that bad!
- But there are a few things that are different that are likely to trip you up
- These are a few things I ran into that particularly caught me out

---

class: content-odd
#Installation

- Can be installed using your OS package manager (yum, apt, dnf etc)
- Creates a user `postgres`
    - This account is required for admin access
- Out of the box, very few features are installed
    - Most need enabling (hstore, uuid_generate, jsonb)
    - Enabling is done at a database level

???

- With new versions of Postgres, there are a few oddities about the way it installs
- Doesn't use the same binary name for each version - similar to using SCL
- The Postgres user is authed by 'ident' out of the box - doens't require a password
- Enabling new features is easy - is actually done in SQL
    - Per database features are interesting, as it means you can just enable what you need for each database.

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

- A single database can have multiple schemas
    - The default is 'public'
- Essentially gives a single database namespaces
    - Different schemas can have different owners / users with different levels of access

???

- Multiple schemas is one of the wierdest things about Postgres as a mySQL users
- Alot of the time you'll probably just use the one schema and not think about it
- The common example of a use case is if you need the separation of data, but with the ability to query accross the whole dataset

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

class: content-odd

- If you are using the psql cli, you can use \d

```bash
liamwiltshire=# \dS+ talks;
```

---

class: content-odd tinycode

```bash
                                  Table "public.talks"
  Column   |            Type             |  Modifiers  | Storage  | Description 
-----------+-----------------------------+-------------+----------+-------------
 talk_id   | smallint                    | not null... | plain    | 
 date      | timestamp without time zone |             | plain    | 
 title     | character varying(254)      |             | extended | 
 slides    | character varying(254)      |             | extended | 
 location  | character varying(254)      |             | extended | 
 eventlink | character varying(254)      |             | extended | 
 icon      | character varying(15)       |             | extended | 
 logo      | character varying(254)      |             | extended | 
 joindin   | character varying(254)      |             | extended | 
Indexes:
    "talk_id" UNIQUE, btree (talk_id)
Has OIDs: no

```


---

class: summary-slide middle

- Postgres *isn't* the solution for every database requirement
- But if it's performance strengths match your requirements, or you need it's features, then do it!
- Benchmark!

---

class: thanks-slide

.conference[![](logos/%%conference%%.png)]
.introimg[![](http://tebex.co.uk/img/tebex.svg)]

# Thank You

### %%joindin%%
### Liam Wiltshire
### @l_wiltshire
### liam@tebex.co.uk


