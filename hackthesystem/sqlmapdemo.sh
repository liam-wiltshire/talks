#!/bin/bash

cd /home/liam/Projects/talks/hackthesystem/tools/sqlmap-dev
./sqlmap.py  --purge  > /dev/null 2>&1

echo '[liam@liam-laptop hackthesystem]$ ./sqlmap.py -u "http://localhost:9999/mysql?title=pride&year=1810" --sql-shell'

sleep 5

./sqlmap.py -u "http://localhost:9999/mysql?title=pride&year=1810" --sql-shell

cd /home/liam/Projects/talks/hackthesystem/
