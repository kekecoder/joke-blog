<?php

if (!isset($_COOKIE['visits'])) {
    $_COOKIE['visits'] = 0;
}

$visit = $_COOKIE['visits'] + 1;
setcookie('visits', $visit, time() + 3600 * 24 * 365);

if ($visit > 1) {
    echo "This is visit number $visit";
} else {
    echo 'Welcome to our website';
}
