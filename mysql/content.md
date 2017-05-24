class: title-slide longtitle

.conference[![](logos/%%conference%%.png)]
.introimg[![](mysql/images/mysql.png)]

# Adventures in mySQL
## Awesome features<br />you're probably missing

???

- In all liklihood, we've been using mySQL for years
- Many projects use, you learn to persist data with mySQL very early on
- However, if you're like me, you might not keep up to date with it
 - With our other tools, languages, frameworks, IDEs, we keep abreast of the latest goings-on, but mySQL can be forgotton

---

class: vanity-cover

background-image: url(logos/phptek-sponsor.png)

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

???

- We're probably all using mySQL every day, it stores data - surely there isn't much more to learn?

---

class: summary-slide middle

- MySQL has always been the 'go to' RDBMS for most PHP devs
- However, we tend to use the same core features over and over
- Over the years MySQL has added lots of new features

???

- Yes, we sometimes use other things, Mongo, maybe even Postgres, but if you open a 'learn to build websites with PHP' - type book,
- Or you look at the online resources, mySQL is probably where it'll lead you.
- However, (and this doesn't apply to everyone), many developers just us it to persist data, and perhaps don't look at how it could actually make your apps better, and your development lives easier
- So, in the next 45 minutes, we are going to look at 10 features from mySQl you may not know
- I'm going to start with what I think is the biggest new feature:


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
   - This means that the text doesn't need to be parsed each time.
   - Sub-objects and nested values can be queried directly

???

---

class: content-even
# Indexing

- Like other binary columns, you cannot index JSON columns
- There are some alternative solutions

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
SELECT * FROM talks WHERE
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
class: content-even

- In this example, let's say that you are looking to find something deeper within the object

```sql
INSERT INTO talks
(id, data)
values (
unhex(replace(uuid(),'-','')),
'{"talkdata":
  {"title": "Lockdown: Linux Security 101",
   "summary": "You missed my tutorial!"}
  }');
```
---
class: content-even

```sql
SELECT * FROM talks WHERE JSON_CONTAINS(
  data,
  '{"title": "Lockdown: Linux Security 101"}',
  "$.talkdata"
);

SELECT * FROM talks WHERE
data->"$.talkdata.title" = "Lockdown: Linux Security 101";
```


---

class: content-even

# A Note on Quotes

- `JSON_EXTRACT` and `->` will return a quoted string:
```sql
mysql> SELECT data->"$.title" FROM talks;
+-----------------------+
| data->"$.title"       |
+-----------------------+
| "Adventures in mySQL" |
| "This is a new test"  |
+-----------------------+
```
---
class: content-even

# A Note on Quotes

- To unquote it, there is an additional method `JSON_UNQUOTE`
 - Otherwise `->>` works like `JSON_UNQUOTE(JSON_EXTRACT())`
```sql
mysql> SELECT data->>"$.title" FROM talks;
+---------------------+
| data->>"$.title"    |
+---------------------+
| Adventures in mySQL |
| This is a new test  |
+---------------------+
```

???

- If the data to be returned is a JSON object in itself, then both will work the same way.

---

class: section-title-a center centralimg
# Spatial Data

![](mysql/images/map.jpg)

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

- Geometry - Can hold any geo object:
 - Point
 - Linestring
 - Polygon

???
- The thing to rememebr is that each piece of geometric data is an object, and each has a storage type that relates to that object
- mySQL has a number of data types that allow representation of different data
 - For our most common use cases, store locators, we'd be storing a point
- The generic Geometry type can store any geometric object, the other types only allow storage of that specific type

---

class: content-odd
# Spatial Collection Data Types

- MySQL also has some multi data types that allow storage of collections:
 - GeometryCollection
  - MultiPoint
  - MultiLinestring
  - MultiPolygon

???

- GeometryCollection can be a collection of objects of any of the other types (so it coul bd one point, one polygon and two strings)
- The other ones are collections of just that object

---

class: content-odd
# Querying Spatial Data

- mySQL has functions for both 'flat' spatial calculations, and spherical ones (since 5.7)
- For most of our purposes, we are probably dealing with the Earth!
 - ST_Distance_Sphere

???
- By default ST_DISTANCE_SPHERE will assume we are talking about a spherical earth.
 - However, it does take an optional third argument - a radius in meters,
  - So when Elon Musk needs a Tesla store locator on Mars, he should be fine

---

class: content-odd tinycode noheader

```sql
CREATE TABLE conferences (
  id BINARY(16),
  name VARCHAR(32),
*  location POINT
);

INSERT into conferences (id, name, location)
values
(unhex(replace(uuid(),'-','')), 'php[tek]',
*  Point(-84.451879, 33.62397)),
(unhex(replace(uuid(),'-','')), 'Sunshine PHP',
*  Point(-80.264138, 25.806893));

SELECT *,
* ST_Distance_Sphere(Point(-80.017949, 40.4467648), location)
FROM conferences;
```

???

- WE set up a basic table, and add some data - notice when specifying points, the longitude comes first
- Then we want to find out how far away from Heinz field they are
- This will give you the distance in meters
---
class: content-odd tinycode noheader

```sql
root@localhost:[mysqltest]> SELECT *, ST_Distance_Sphere(
  Point(-80.017949, 40.4467648), location
) AS distance FROM conferences;

+------------------+--------------+---------------------------+-------------------+
| id               | name         | location                  | distance          |
+------------------+--------------+---------------------------+-------------------+
| ��B_��7�<�$]�  | php[tek]     |  |N՘�U�#K�X��@@    | 854361.4989842452 |
| ��}_��7�<�$]�  | Sunshine PHP |  ����T�]X����9@ | 1628035.220738256 |
+------------------+--------------+---------------------------+-------------------+
2 rows in set (0.00 sec)
```

???

- You can see, as with the JSON data beforem that the Geo data is stored in binary
 - So of no use on it's own, you have to apply functions to it ot make sense of it
- Also, just to re-iterate, the distance result is in meters

---

class: content-odd tinycode

# Readable Data
- Few different ways to make your geo data readable:
 - ST_AsText - Converts to WKT
 - ST_AsGeoJSON - Converts to JSON

```sql
root@localhost:[mysqltest]> SELECT ST_AsGeoJSON(location) FROM conferences;
+-------------------------------------------------------------+
| ST_AsGeoJSON(location)                                      |
+-------------------------------------------------------------+
| {"type": "Point", "coordinates": [-84.4518797, 33.623973]}  |
| {"type": "Point", "coordinates": [-80.2641387, 25.8068938]} |
+-------------------------------------------------------------+
2 rows in set (0.00 sec)

```

???
So, let's assume you actually need this data in a usable format
There are a few ways of doing it, but the two you are most likely to use are
ST_AsText and ST_AsGeoJSON
Your use will guide you hwere - there are PHP Geo libraries that use WKT, but if you are just wanting to output it, JSON may be the way to go

---

class: section-title-a middle halfhalf reverse
background-image: url(mysql/images/replication.jpg)

# &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GTID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Replication

---

class: content-even

# [5.6] Master->Slave Replication with GTID

- Anyone who has set up mySQL slaves before knows it's not always straightforward
- GTIDs are a unique references to every transaction in a cluster
- We can leverage GTIDs to make replication easier to setup and more robust

---

class: content-even tinycode

# Replication with GTID

- GTID must be enabled - my.cnf

```bash
[mysqld]
gtid_mode=on
enforce_gtid_consistency=true
```

```sql
CHANGE MASTER TO MASTER_HOST='192.168.1.110', MASTER_USER='replication', MASTER_PASSWORD='reppwd',
* MASTER_AUTO_POSITION=1;
START SLAVE;

```

???

This isn't every step to setting up replication - this is assuming that you have used the binary logs to do replication before, and just highlights some of the changes to make use of GTID

- You have to configure all the nodes to use GTID
- Once they are all configured (and the usual settings such as server ids, binary logging are done),
you can make and load a db dump as usual, and then use auto-positioning to allow mySQL to worry about getting everything in step

---

class: content-even

```sql
root@localhost:[mysqltest]> SHOW MASTER STATUS \G
 *************************** 1. row ***************************
             File: li443-233-bin.000001
         Position: 492
     Binlog_Do_DB:
 Binlog_Ignore_DB:
* Executed_Gtid_Set: 29faeb5e-fb7f-11e6-bad3-f23c91245dba:1

```

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
class: content-odd noheader tinycode

```sql
root@localhost:[mysqltest]> EXPLAIN INSERT into news_archive
  SELECT * FROM news WHERE date < '2015-01-01';

+----+-------------+--------------+------------+-------+---------------+
-- ------+---------+------+------+----------+-----------------------+
| id | select_type | table        | partitions | type  | possible_keys |
 key  | key_len | ref  | rows | filtered | Extra                 |
+----+-------------+--------------+------------+-------+---------------+
-- ------+---------+------+------+----------+-----------------------+
|  1 | INSERT      | news_archive | NULL       | ALL   | NULL          |
NULL | NULL    | NULL | NULL |     NULL | NULL                  |

|  1 | SIMPLE      | news         | NULL       | range | date,summary  |
date | 6       | NULL |    1 |   100.00 | Using index condition |
+----+-------------+--------------+------------+-------+---------------+
-- ------+---------+------+------+----------+-----------------------+

```

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
class: content-even tinycode noheader

```sql
EXPLAIN FORMAT=json SELECT * FROM slides WHERE talk_id = 5;
```

```json
{
  "query_block": {
    "select_id": 1,
    "cost_info": {
      "query_cost": "1.20"
    },
    "table": {
      "table_name": "slides",
      "access_type": "ALL",
      "possible_keys": [
        "talk_id"
      ],
      "rows_examined_per_scan": 1,
      "rows_produced_per_join": 1,
      "filtered": "100.00",
```
---
class: content-even tinycode noheader

```json
      "cost_info": {
        "read_cost": "1.00",
        "eval_cost": "0.20",
        "prefix_cost": "1.20",
        "data_read_per_join": "280"
      },
      "used_columns": [
        "talk_id",
        "url"
      ],
      "attached_condition": "(`mysqltest`.`slides`.`talk_id` = 5)"
    }
  }
}
```

???

- JSON Format explains are really powerful, as they can give you lots more hints than a standard explain would:
 - WHERE covering indexes might be useful

---

class: section-title-c middle center

# User Roles

![](mysql/images/authorization.png)

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

class: content-even

# [5.6] Generated Columns

- Generated columns are defined when you create a mySQL table
 - They are effectively defining an expression that generates a value for that row
- There are two types of generated columns:
 - Virtual
 - Stored

???

- For example, you might have a firstname and lastname in separate columns, and need the full name - this could be defined as a generated column
- Or more likely you might use it to create indexes on otherwise unindexable data - for example a part of a JSON document!

---

class: content-even noheader

```sql
--- No index, every row will need checking
SELECT * FROM talks WHERE data->>"$.title" LIKE 'Adventure%';

--- Add a generated column and index it
ALTER TABLE talks
  ADD talk_title varchar(256) GENERATED ALWAYS
    AS (data->>"$.title") STORED;

ALTER TABLE talks
  ADD INDEX (talk_title(25));

--- Now we can use the index :)
SELECT * FROM talks WHERE talk_title LIKE 'Adventure%';
```

---

class: content-odd

# Virtual Generated Column

- A virtual generated column is materialized at read time
 - No additional storage requirements
 - Changes to virtual columns are fast
- If you have a large resultset with an expensive expression, it will get quite slow

???

- Indexing: With InnoDB you can generate an index on a virtual column
 - The index value is materialized ON INSERT or UPDATE
 - If you make a covering index, then mySQL won't re-materialize the values
 - If it's not a covering index however then the values will be re-materizlied as part of the row reads

---

class: content-even

# Stored Generated Column

- As the name suggests, the value for this column is martialized as part of the INSERT or UPDATE, and stored
- After this point, it acts just like a normal column
- Doesn't have the performance impact at read time, but lots of generated columns will bloat your tables

---

class: section-title-b middle center

# Offline Mode

![](mysql/images/offline.jpg)
---

class: content-odd

# [5.7] Offline Mode

- Restrict access to the DB to only users with SUPER
- Can be done without server restart - e.g. to do maintenance
 - May have application-level restrictions anyway
 - Provides an extra failsafe - no-one can touch the DB while you are making your changes

```sql
SET GLOBAL offline_mode = on;
```

---

class: section-title-c middle halfhalf
background-image: url(mysql/images/index.jpg)

# Indexes

---

class: content-odd

# [8.0] Invisible Indexes

- Allows you to test the impact of removing an index without doing so
- The index will still be maintined
- But will not be visible to the optimizer

???

- Being able to test the impact of indexes is a great feature
- Particularly on big tables, dropping or adding indexes can be really expensive
- So being able to test the impact of removing an index without actually having to do it us useful
 - Of course, if you do deduce that the index isn't required then you should then remove it, to remove the overhead of maintining the index

---

class: content-odd

&nbsp;

```sql
ALTER TABLE t1 ALTER INDEX i_idx INVISIBLE;


ALTER TABLE t1 ALTER INDEX i_idx VISIBLE;
```

---

class: content-even

# [8.0] Descending Indexes

- We regularly use indexes to speed up queries, lookups etc
- However currently all indexes are stored ascending
- This results in performance issues when we need descending data

???

- You probably have plenty of situations where you almost always want the data in descending order
 - Showing the neweset records first
 - Since mySQL 5.7 we can scan an index in reverse, but it is still slower than reading an index forwards

---

class: content-even

```sql
SELECT `date`, `headline` FROM news  ORDER BY date DESC;
75000 rows in set (0.10 sec)


SELECT `date`, `headline` FROM news  ORDER BY date ASC;
75000 rows in set (0.05 sec)
```

???

- As a very basic example, let's assume you have a news table
- You show summaries (headline, date), so you create a covering index
 - Presumably you want to show latest first
- Because of the reverse scan, even in 5.7 the query is slower

---

class: content-even

- Instead, if you have a common requirement to use a descending index, you can do so:

```sql
ALTER TABLE news ADD INDEX summary (date DESC, headline ASC));
```

---

class: center middle

![](mysql/images/snes.jpg)

???

- Ok, so I said that there would be 10 features
- However, like the SNES there is one that is an oldie, but a goodie

---

class: content-odd

# --i-am-a-dummy

- Only allow UPDATE or DELETE to be used with a WHERE clause that specifies a key
- In other words, you can't accidently UPDATE or DELETE everything!
- Only available in the mySQL CLI

???

- The i am a dummy CLI flag has been around forever more or less
 - And yet, I only found out about it 6 months ago

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


