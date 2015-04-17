<?php

try {
    $pass = $_GET['pass'];
    $fn = $_GET['fn'];

    $passFromFile = file_get_contents("./../assets/pass.dat") or die('Unable to read file');
    $passFromFile = substr($passFromFile, 0, strlen($passFromFile)); //remove EOF

    if (md5($pass) === $passFromFile) {

        $fileMoved = rename("./pending/" . $fn, "./" . $fn);
        if (!$fileMoved) {
            echo "Cannot move file : " . $fn;
        } else {
            echo "1";
        }
    } else {
        echo 'Password did not match, your:' . $pass;
    }
} catch (Exception $e) {
    echo $e;
}

