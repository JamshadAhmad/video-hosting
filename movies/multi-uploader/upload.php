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

            $needToSaveGenre = false;
            $genre = $_POST["genre"];
            $desc = $_POST["desc"];
            $ip = $_POST["ip"];
            if ($genre !== "null") {
                $needToSaveGenre = true;
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
                            $ext = explode(".", $filen)[1];
                            if ($needToSaveGenre === true) {
                                if ($ext == "mpg" || $ext == "avi" || $ext == "mkv" || $ext == "mp4" || $ext == "zip" || $ext == "3gp") {
                                    $file = "./../../assets/movie_data.dat";

                                    $current = file_get_contents($file);

                                    $current .= $filen . " " . $ip . " " . $genre . " " . $desc . "\n";

                                    file_put_contents($file, $current);
                                }
                            }
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


