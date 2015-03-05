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
        <style>
            input[type="search"],select{
                background: #EEEEEE;
                border: lightgrey solid 1px;
            }
            tr:not(:first-child){
                height: 50px;
            }
            th{
                height: 35px;
                color: black;
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
                <a class="navbar-brand animated zoomIn" href="#">List of Movies</a>


            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-left">
                    <li><a class="btn-success" style="color: white;" href="./multi-uploader/uploadm.php">Upload Movie</a></li>
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
          if (filemtime($a) === filemtime($b)) return 0;
          return filemtime($a) > filemtime($b) ? -1 : 1; 
        }

        // Then sort with usort()
        usort($files, "filetime_callback");


        echo ' <a href="../" > <img width="20" src="./../images/up.png"/>Go up </a><br><br>';
        echo '<table id="table1">';
        echo '<thead><tr><th>Server Contents</th><th>Size</th><th>Genre/Category</th><th>Description</th><th>Uploader</th><th>Added On</th><th></th><th>Options</th></tr></thead>';
        echo '<tbody>';

        $genres = array();
        $handle = fopen("./../assets/movie_data.dat", "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $genres[explode(' ', $line)[0]] = explode(' ', $line)[2];
                $uploader = explode(' ', $line)[1];
                $temp = explode(' ', $line);
                $description = "";
                for ($j = 3; $j < count($temp); $j++) {
                    $description = $description . " " . $temp[$j];
                }
                $genres[explode(' ', $line)[0] . "d"] = $description;
                $genres[explode(' ', $line)[0] . "u"] = $uploader;
            }
            fclose($handle);
        } else {
            echo "Error Reading genre file";
        }

        for ($i = 0; $i < count($files); $i++) {
            if (strlen($files[$i]) < 3 && strpos($files[$i], '.') === 0) {
                continue;
            } else if ($files[$i] === "index.php" || $files[$i] === "delete.php" || $files[$i] === "pending.php" || $files[$i] === "approve.php" || $files[$i] === "pending" || $files[$i] === "multi-uploader") {
                continue;
            }
            if (strpos($files[$i], '.') > 1 && strpos($files[$i], '~') < 1) {
                echo '<tr>';
                echo " <td><a id='" . substr($files[$i], 0, count($files[$i]) - 5) . "a' href='" . $files[$i] . "' download><img width='20' src='./../images/file.png'/> " . $files[$i] . "</a></td><td>" . formatSizeUnits(filesize($files[$i])) . "</td><td>" . $genres[$files[$i]] . "</td><td>" . $genres[$files[$i] . "d"] . "</td><td style='text-align:center;'>" . $genres[$files[$i] . "u"] . "</td><td>".date ("d F,Y", filemtime($files[$i]))."</td>";
                if (strpos($files[$i], '.mp4') > 1 || strpos($files[$i], '.avi') > 1 || strpos($files[$i], '.mkv') > 1 || strpos($files[$i], '.3gp') > 1) {
                    echo " <td><input type='button' class='btn-success' onclick='playvid(this.id)' id='" . substr($files[$i], 0, count($files[$i]) - 5) . "' value='Play' /></td><td><input type='button' style='margin-right: 10px;' class='btn-primary' onclick='download(this.id)' id='" . substr($files[$i], 0, count($files[$i]) - 5) . "' value='Download' /><input type='button' class='btn-danger' onclick='deletev(this.id)' id='" . $files[$i] . "' value='Delete' /></td></tr><div style='text-align:center;margin-left: 10px;' id='div" . substr($files[$i], 0, count($files[$i]) - 5) . "'> </div>";
                } else {
                    echo " <td></td><td><input type='button' class='btn-primary' style='margin-right: 10px;' onclick='download(this.id)' id='" . substr($files[$i], 0, count($files[$i]) - 5) . "' value='Download' /><input type='button' class='btn-danger' onclick='deletev(this.id)' id='" . $files[$i] . "' value='Delete' /></td></tr><br>";
                }
            } else if (!strpos($files[$i], '~') > 0) {
                echo " <td><a href='" . $files[$i] . "' ><img width='20' src='./../images/folder.png'/> " . $files[$i] . "/</a></td><br>";
            }
        }
        echo '</tbody>';
        echo '</table>';
        ?>



        <script type="text/javascript">
            var isOpera = !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
            var isChrome = !!window.chrome && !isOpera;
            var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
            var validBrow = false;
            if (isChrome || isSafari) {
                validBrow = true;
            }
            if (!validBrow) {
                $('#broserError').html("Videos might not play in this browser, please use google chrome <br><br>");
            }
            function playvid(id) {
                $("div[id^='div']").html("");
                $("#div" + id).html("<video style='width:480px;' controls><source src='" + id + "'>Your browser does not support HTML5 video.</video><br><input type='button' class='btn-danger' id='" + id + "' value='Close Player' onclick='stopvid(this.id)'/><br>");
            }
            function stopvid(id) {
                $("#div" + id).html("");
            }
            function download(id) {
                $("#" + id + "a").focus();
                document.getElementById(id + "a").click();
            }
            function deletev(id) {
                var passs = prompt("Enter password to continue");
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        if (xmlhttp.responseText == "1")
                        {
                            location.reload();
                        }
                        else
                        {
                            alert(xmlhttp.responseText);
                        }
                    }
                }
                xmlhttp.open("GET", "delete.php?pass=" + passs + "&fn=" + id, true);
                xmlhttp.send();
            }

            var app = angular.module("myApp", []);
            app.controller("myCtrl", function ($scope) {
                $scope.content = "movie";
                $scope.genre = "n/a";
                $scope.playable = "true";
            });
            $(document).ready(function () {
                var table = $('#table1').DataTable({
                    "order": [],
                    "sDom": 'T<"clear">lfrtip',
                    "aoColumns": [
                        null,
                        {"sType": "file-size"},
                        null,
                        null,
                        null,
                        null,
                        { "bSortable": false },
                        { "bSortable": false },
                    ]
                });
                $('input').addClass('btn');
                $('select').addClass('btn');
                $('input[type=search]').addClass('animated wobble');
                $("tr:even").css("background-color", "#EEEEEE");
            });
            jQuery.fn.dataTableExt.oSort['file-size-asc'] = function (a, b) {
                var x = a.substring(0, a.length - 2);
                var y = b.substring(0, b.length - 2);

                var x_unit = (a.substring(a.length - 2, a.length) == "MB" ? 1000 : (a.substring(a.length - 2, a.length) == "GB" ? 1000000 : 1));
                var y_unit = (b.substring(b.length - 2, b.length) == "MB" ? 1000 : (b.substring(b.length - 2, b.length) == "GB" ? 1000000 : 1));

                x = parseInt(x * x_unit);
                y = parseInt(y * y_unit);

                return ((x < y) ? -1 : ((x > y) ? 1 : 0));
            };

            jQuery.fn.dataTableExt.oSort['file-size-desc'] = function (a, b) {
                var x = a.substring(0, a.length - 2);
                var y = b.substring(0, b.length - 2);

                var x_unit = (a.substring(a.length - 2, a.length) == "MB" ? 1000 : (a.substring(a.length - 2, a.length) == "GB" ? 1000000 : 1));
                var y_unit = (b.substring(b.length - 2, b.length) == "MB" ? 1000 : (b.substring(b.length - 2, b.length) == "GB" ? 1000000 : 1));

                x = parseInt(x * x_unit);
                y = parseInt(y * y_unit);

                return ((x < y) ? 1 : ((x > y) ? -1 : 0));
            };
            jQuery.fn.dataTableExt.aTypes.push(
                    function (sData)
                    {
                        var sValidChars = "0123456789";
                        var Char;

                        /* Check the numeric part */
                        for (i = 0; i < (sData.length - 3); i++)
                        {
                            Char = sData.charAt(i);
                            if (sValidChars.indexOf(Char) == -1)
                            {
                                return null;
                            }
                        }

                        /* Check for size unit KB, MB or GB */
                        if (sData.endsWith("KB") || sData.endsWith("MB") || sData.endsWith("GB"))
                        {
                            return 'size';
                        }
                        return null;
                    }
            );
        </script>
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
