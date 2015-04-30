<html>
    <head> 
        <title>Download Movies</title>
        <script src="./../assets/angular.min.js"></script>
        <script src="./../assets/jquery-1.9.1.js"></script>
        <link href="./../assets/jquery.dataTables.css" rel="stylesheet" type="text/css" />
        <script src="./../assets/jquery.dataTables.js"></script>
        <script src="./../assets/file-size.js"></script>
        <script src="./../assets/bootstrap.min.js"></script><!--No need-->
        <link rel="stylesheet" href = "./../assets/bootstrap.min.css">
        <link rel="stylesheet" href = "./../assets/animate.min.css">
        <script src="./../assets/sweet-alert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="./../assets/sweet-alert.css">
        <style>
            input[type="search"],select{
                background: #EEEEEE;
                border: lightgrey solid 1px;
            }
            tr:not(:first-child){
                height: 50px;
            }
	    td{
                word-wrap: break-word;
  		word-break: break-all;
            }
            th{
                text-shadow: 1px 1px #AAA;
                height: 35px;
                color: black;
            }
            .pw_prompt {
                position:fixed;
                left: 50%;
                top:15%;
                margin-left:-100px;
                padding:15px;
                width:parent;
                border:1px solid black;
            }
            .pw_prompt label {
                display:block; 
                margin-bottom:5px;
            }
            .pw_prompt input {
                margin-bottom:10px;
            }
        </style>
    </head>

    <body background='./../images/b.png'>  

        <div class="navbar navbar-inverse" style="height: 10px;">
            <div class="navbar-header">

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>

                </button>
                <img src="./../images/movie.png" style="float:left;height:50px">
                <a class="navbar-brand animated zoomIn active" href="#">List of Movies</a>


            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-left">
                    <li><a class="btn-success" style="color: white;" href="./multi-uploader/uploadm.php"><img src="./../images/upload.png" style="height: 18;"> Upload Movie</a></li>
                    <?php
                    $pfiles = scandir("./pending/");
                    if (count($pfiles) > 2) {
                        echo '  <li>  <a class="btn-primary" style="color: white;" href="./pending.php">Approve Pending Movies (' . (count($pfiles) - 2) . ')</a></li>';
                    }
                    ?>
                </ul>
                <p style="float:right;margin-top: 15px" class="text-muted">by Jamshad Ahmad for Coeus Solutions.</p>
            </div>
        </div>
        <h1 style="text-align:center" class="animated zoomIn">List of files</h1>
        <span id="broserError"></span>
        <?php
        $dir = '.';
        $files = scandir($dir);

        function filetime_callback($a, $b)
        {
            if (filemtime($a) === filemtime($b))
                return 0;
            return filemtime($a) > filemtime($b) ? -1 : 1;
        }

        // Then sort with usort()
        usort($files, "filetime_callback");


        echo ' <a href="../" > <img width="20" src="./../images/up.png"/>Go up </a><br><br>';
        echo '<table id="table1">';
        echo '<thead><tr><th style="max-width:325">Server Contents</th><th>Size</th><th>Genre/Category</th><th style="max-width:150px">Description</th><th>Uploader</th><th>Added On</th><th></th><th>Options</th></tr></thead>';
        echo '<tbody>';

        $mdata = json_decode(file_get_contents("./../assets/movie_data.json"));

        for ($i = 0; $i < count($files); $i++) {
            if (strlen($files[$i]) < 3 && strpos($files[$i], '.') === 0) {
                continue;
            } else if ($files[$i] === "index.php" || $files[$i] === "delete.php" || $files[$i] === "pending.php" || $files[$i] === "approve.php" || $files[$i] === "pending" || $files[$i] === "multi-uploader" || $files[$i] === ".DS_Store") {
                continue;
            }
            if (strpos($files[$i], '.') > 1 && strpos($files[$i], '~') < 1) {
                echo '<tr>';
                echo " <td style='max-width:325'><a id='" . substr($files[$i], 0, count($files[$i]) - 5) . "a' href='" . $files[$i] . "' download><img width='20' src='./../images/file.png'/> " . $files[$i] . "</a></td><td>" . formatSizeUnits(filesize($files[$i])) . "</td><td>" . $mdata->$files[$i]->genre . "</td><td style='max-width:150px;  font-size: 14;'>" . $mdata->$files[$i]->desc . "</td><td style='text-align:center;'><a >" . $mdata->$files[$i]->uploader . "</a></td><td>" . date("d F,Y", filemtime($files[$i])) . "</td>";

                if (strpos($files[$i], '.mp4') > 1 || strpos($files[$i], '.avi') > 1 || strpos($files[$i], '.mkv') > 1 || strpos($files[$i], '.3gp') > 1 ||  strpos($files[$i], '.mpg') > 1) {
                    echo " <td><button class='btn btn-success' onclick='playvid(this.id)' id='" . substr($files[$i], 0, count($files[$i]) - 5) . "' ><img src='./../images/play.jpg' style='height: 18;'>  Play</button></td><td><input type='button' style='margin-right: 10px;background: deepskyblue;color:white;' class='btn' onclick='download(this.id)' id='" . substr($files[$i], 0, count($files[$i]) - 5) . "' value='Download' /><input type='button' class='btn btn-danger' onclick='deletev(this.id)' id='" . $files[$i] . "' value='Delete' /></td></tr><div style='text-align:center;margin-left: 10px;' id='div" . substr($files[$i], 0, count($files[$i]) - 5) . "'> </div>";
                }else if(strpos($files[$i], '.mp3') > 1) {
                    echo " <td><button class='btn btn-success' onclick='playaud(this.id)' id='" . substr($files[$i], 0, count($files[$i]) - 5) . "' ><img src='./../images/play.jpg' style='height: 18;'>  Play</button></td><td><input type='button' style='margin-right: 10px;background: deepskyblue;color:white;' class='btn' onclick='download(this.id)' id='" . substr($files[$i], 0, count($files[$i]) - 5) . "' value='Download' /><input type='button' class='btn btn-danger' onclick='deletev(this.id)' id='" . $files[$i] . "' value='Delete' /></td></tr><div style='text-align:center;margin-left: 10px;' id='div" . substr($files[$i], 0, count($files[$i]) - 5) . "'> </div>";
                } else {
                    echo " <td></td><td><input type='button' class= 'btn btn-primary' style='margin-right: 10px;' onclick='download(this.id)' id='" . substr($files[$i], 0, count($files[$i]) - 5) . "' value='Download' /><input type='button' class='btn btn-danger' onclick='deletev(this.id)' id='" . $files[$i] . "' value='Delete' /></td></tr><br>";
                }
            } else if (!strpos($files[$i], '~') > 0) {
                echo " <td><a href='" . $files[$i] . "' ><img width='20' src='./../images/folder.png'/> " . $files[$i] . "/</a></td><br>";
            }
        }
        echo '</tbody>';
        echo '</table>';
        ?>

        <script type="text/javascript" src="./../assets/ml.js"></script>
    </body>
</html>
<?php

//helper method
function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . 'GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . 'MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . 'KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . 'B';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}
?>
