<?php

$users = [
    'liam@tebex.co.uk' => password_hash('testtest123', PASSWORD_DEFAULT),
    'liam@w.iltshi.re' => password_hash('testtest123', PASSWORD_DEFAULT),
];

$tests = ['nouser@test.com', 'liam@tebex.co.uk', 'anothernonuser@example.com'];

$password = 'asdjashdkajshd';

$times = [];

$targetTime = 750000;

foreach ($tests as $test) {
    echo "\n";
    $times[$test] = 0;
    $x = 1;
    while ($x <= 5) {
        echo ".";
        $start = microtime(true);
        usleep(rand(10000,99999));
        $user = $users[$test] ?? false;
        if ($user) {
            password_verify($password, $user);
        }

        if (microtime(true) - $start < $targetTime) {
            usleep($targetTime - (microtime(true) - $start));
        }

        $times[$test] += (microtime(true) - $start);
        $x++;
    }

    $times[$test] /= 5;
}

var_dump($times);