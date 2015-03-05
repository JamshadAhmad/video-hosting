<?php

try {
    $pass = $_GET['pass'];
    $fn = $_GET['fn'];
    $pending = $_GET['pending'];
    if ($pending == "yes") {
        $fn = './pending/' . $fn;
    }

    $passFromFile = 'null';
    $passFromFile = file_get_contents("./../assets/pass.dat") or die('Unable to read file');
    $passFromFile = substr($passFromFile, 0, strlen($passFromFile) - 1); //remove EOF

    if (md5($pass) === $passFromFile) {
        $fileDeleted = unlink($fn);
        if (!$fileDeleted) {
            echo "Cannot find/delete file : " . $fn;
        }
        //Also delete its description
        //./../assets/movie_data.dat
        if ($fileDeleted) {
            $arr = file("./../assets/movie_data.dat");
            // remove second line
            $targetline = 0;
            foreach ($arr as $line) {
                if (explode(" ", $line)[0] === $fn) {
                    break;
                }
                $targetline = $targetline + 1;
            }
            if ($targetline < count($arr)) { //If found
                unset($arr[$targetline]);
            }

            $arr = array_values($arr);

            file_put_contents("./../assets/movie_data.dat", implode($arr));


            echo "1";
        }
    } else {
        echo 'Password did not match, your:' . $pass;
    }
} catch (Exception $e) {
    echo $e;
}

