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
        //./../assets/movie_data.json
        if ($fileDeleted) {

            //For json
            $mdata = json_decode(file_get_contents("./../assets/movie_data.json"));
                unset($mdata->$fn);

                $mdata->$fn = null;

            
            file_put_contents("./../assets/movie_data.json", json_encode($mdata));


            echo "1";
        }
    } else {
        echo 'Password did not match, your:' . $pass;
    }
} catch (Exception $e) {
    //echo $e;
}

