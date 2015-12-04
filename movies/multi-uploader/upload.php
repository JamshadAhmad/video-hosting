<html>
    <head>
        <title>Uploaded</title>
        <link rel="stylesheet" href = "./../../assets/bootstrap.min.css">
    </head>
    <body>
        <div class="navbar navbar-inverse" style="height: 10px;">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="./../index.php">Back To Movies</a>
            </div>
            <div class="navbar-collapse collapse">

            </div>
        </div>

        <h4>
            <?php
            if (!isset($_FILES["item_file"]))
                die("Error: no files uploaded!");

            $genre = $_POST["genre"];
            $desc = $_POST["desc"];
            $ip = $_POST["ip"];
            if(strlen($desc)<=1){
                $desc = "N_A";
            }
            if($genre==="null"){
                $genre = "N_A";
            }

            $file_count = count($_FILES["item_file"]['name']);

            echo $file_count . " file(s) were selected <BR><BR>";

            if (count($_FILES["item_file"]['name']) > 0) { //check if any file uploaded
                for ($j = 0; $j < count($_FILES["item_file"]['name']); $j++) { //loop the uploaded file array
                    $filen = $_FILES["item_file"]['name'][$j];

                    // ingore empty input fields
                    if ($filen != "") {
                        $notAllowed = array("(", "{", "[", ")", "}", "]", ".", "-", ",", "'", " ");
                        $filen = str_replace($notAllowed, "_", $filen);
                        $filen = substr_replace($filen, ".", strrpos($filen, "_"), strlen("_"));

                        $path = "./../pending/" . $filen;

                        if (move_uploaded_file($_FILES["item_file"]['tmp_name']["$j"], $path)) {

                            echo "File # " . ($j + 1) . " ($filen) uploaded successfully!<br>";

                            //Save genre here if needed for file type
                            $mdata = json_decode(file_get_contents("./../../assets/movie_data.json"));
                            $mdata->$filen->uploader = $ip;
                            $mdata->$filen->genre = $genre;
                            $mdata->$filen->desc = $desc;
                            file_put_contents("./../../assets/movie_data.json", json_encode($mdata));

                        } else {
                            echo "Errors occoured during file upload!";
                        }
                    }
                }
            }
            ?>
        </h4>
    </body>
</html>
