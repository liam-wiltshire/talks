

- Offline Mode
- Invisible Indexes
- Descending Indexes
- I am a dummy flag

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
- I've provided version numbers of when these things came inyl mySQL - if you use MariaDB or Percona versions will be different (or the feature may not be availalbe at all!)

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
CREATE TABLE talks (id BINARY(16), data JSON);

INSERT INTO talks values (
  unhex(replace(uuid(),'-','')),
  '{
     "title": "Adventures in mySQL",
     "summary": "An awesome talk"
   }');
```

???
- Because, of course we're all using UUIDs now right?!
- As an aside, mySQL 8.0 has a new UUID_TO_BIN() method to do the above

---

class: content-even
```sql
-- Find rows that contains this data
SELECT * FROM talks 
JSON_CONTAINS(data, '{"title": "Adventures in mySQL"}');
-- Find rows that have any summary
SELECT * FROM talks WHERE data->"$.summary" IS NOT NULL;
-- Extract a part of the JSON
SELECT id, data->"$.title" FROM talks;
```

???

- When dealing with JSON, there are a couple of options
 - mySQL provides a number of functions JSON_CONTAINS, JSON_EXTRACT etc
 - mySQL also provides some shortcut methods
- In all instances, the $ is used to represent the root of the document

---

class: section-title-a center centralimg
# Spatial Data

![](postgres/images/performance.png)

---

class: content-odd
# [5.5+] OpenGIS Support

- Unless you've had prior experience, OpenGIS is pretty hard to get into
- mySQL support is getting better with each new release
- Consider if you really need to use it, or it could be done another way

???

- OpenGIS is fairly unwieldy, and the mySQL implementation is still changing on a verson-by-version basis
- GeoSpatial allows you to use points, lines, polygons etc to do spatial operations
- Contains specialised functions and indexes for better performance
- You could use it to find your nearest store from your list of 5, but realistically there are probably easier and quicker ways to do it!

---

class: content-odd
# Spatial Data Types

---

class: content-odd
# Querying Spatial Data

- ST_Distance_Sphere
- ST_Within

---

class: section-title-a middle

# GTID Replication

---

class: content-even

# [5.6] Master->Slave Replication with GITD

- Anyone who has set up mySQL slaves before knows it's not always straightforward
- GTIDs are a unique references to every transaction in a cluster
- We can leverage GTIDs to make replication easier to setup and more robust

---

class: content-even

---

class: section-title-b middle

# EXPLAIN

???

- Now obviously, explain isn't new!
- However, they've added some pretty cool new wrinkles to it

---

class: content-odd

# [5.6] EXPLAIN on Write Queries

- Previously, we could only use EXPLAIN on SELECTs
- This allows us to profile UPDATE, DELETE INSERT...SELECT etc.

???

- As a workaround we could re-write UPDATES to SELECTs, but it's not always ideal
- There are some limitations - for example EXPLAIN INSERT is pretty useless unless you are using an INSERT...SELECT
- Would be nice to see the FK checks, but because of the architecture (the FK checks are handled by the storage engine, not the optimizer) this is difficult (if not impossible) to impliment

---

class: content-even

# [5.6] EXPLAIN FORMAT=json

- Because everyone needs more JSON!
- Using JSON gives us a much more flexible output format
- Allows greater depth of detail
 - Including the EXTENDED and PARTITIONS data

---

class: content-even
```sql
EXPLAIN FORMAT=json
   INSERT INTO talks
     SELECT * FROM talks
        WHERE data->"$.name" LIKE '%mySQL%'
```

---

class: content-even tinycode noheader

```json
EXPLAIN: {
  "query_block": {
    "select_id": 1,
    "cost_info": {
      "query_cost": "1.20"
    },
    "table": {
      "insert": true,
      "select_id": 1,
      "table_name": "talks",
      "access_type": "ALL"
    },
    "insert_from": {
      "buffer_result": {
        "using_temporary_table": true,
        "table": {
          "table_name": "talks",
          "access_type": "ALL",
```
---

class: content-even tinycode noheader

```json
          "rows_examined_per_scan": 1,
          "rows_produced_per_join": 1,
          "filtered": "100.00",
          "cost_info": {
            "read_cost": "1.00",
            "eval_cost": "0.20",
            "prefix_cost": "1.20",
            "data_read_per_join": "32"
          },
          "used_columns": [
            "id",
            "data"
          ],
          "attached_condition": "(json_extract(`mysqltest`.`talks`.`data`,'$.name') like '%mySQL%')"
        }
      }
    }
  }
}
```
---

class: section-title-c middle

# User Roles

---

class: content-odd

# [8.0] User Roles

- Roles are groups of privileges that are given a label
- For example you could have an `analytics` role, a `maintenance` role
 - Each would have a predefined list of privileges
- If requirements change, privileges can be added/removed from a role
 - This will then apply to all users already given that role

---

class: content-odd


```sql
--- Create two new roles
CREATE ROLE 'developer', 'analytics';

--- Define the privileges for each role
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE
   ON testdb.* TO 'developer';
GRANT SELECT ON testdb.stats TO 'analytics';

--- Assign the roles to users
GRANT 'developer' TO 'liam'@'localhost';
GRANT 'analytics' TO 'seo'@'localhost';

```

---

class: section-title-a middle
# Generated Columns

---

class: summary-slide middle

- With the wide range of technologies we use, it's easy to fall behind of the latest updates
- By keeping track of what's going on, it just might make our lives easier, and help us build better apps
- This is just a selection of a few new features - there are many more, so go forth and explore!

---

class: thanks-slide

.conference[![](logos/%%conference%%.png)]
.introimg[![](http://tebex.co.uk/img/tebex.svg)]

# Thank You

### %%joindin%%
### Liam Wiltshire
### @l_wiltshire
### liam@tebex.co.uk


