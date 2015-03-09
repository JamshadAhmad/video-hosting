<html>
    <head> 
        <title>Pending movies</title>
        <script src="./../assets/angular.min.js"></script>
        <script src="./../assets/jquery-1.9.1.js"></script>
        <link href="./../assets/jquery.dataTables.css" rel="stylesheet" type="text/css" />
        <script src="./../assets/jquery.dataTables.js"></script>
        <script src="./../assets/bootstrap.min.js"></script><!--No need-->
        <link rel="stylesheet" href = "./../assets/bootstrap.min.css">
        <script src="./../assets/sweet-alert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="./../assets/sweet-alert.css">
        <style>
            input[type="search"] {
                background: lightgray;
            }
            .pw_prompt {
                position:fixed;
                left: 50%;
                top:50%;
                margin-left:-100px;
                padding:15px;
                width:200px;
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
    <body>  
        <div class="navbar navbar-inverse" style="height: 10px;">
            <div class="navbar-header">

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>

                </button>

                <a class="navbar-brand" href="#">List of Pending Movies</a>


            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-left">
                    <li><a class="btn-success" style="color: white;background: darkgray;" href="./index.php"><img style="height:18px" src="./../images/back-icon.jpg"> Back to Movies</a></li>
                </ul>

            </div>
        </div>
        <h1>List of pending files</h1>
        <span id="broserError"></span>
        <?php
        $dir = './pending/';
        $files = scandir($dir);

        echo ' <a href="../" > <img width="20" src="./../images/up.png"/>Go up </a><br><br>';
        echo '<table id="table1">';
        echo '<thead><tr><th>Server Contents</th><th>Genre/Category</th><th>Description</th><th>Uploader</th><th></th><th>Options</th></tr></thead>';
        echo '<tbody>';

        $mdata = json_decode(file_get_contents("./../assets/movie_data.json"));

        for ($i = 0; $i < count($files); $i++) {
            if (strlen($files[$i]) < 3 && strpos($files[$i], '.') === 0) {
                continue;
            } else if ($files[$i] === "index.php" || $files[$i] === "delete.php" || $files[$i] === "pending.php" || $files[$i] === "multi-uploader") {
                continue;
            }
            if (strpos($files[$i], '.') > 1 && strpos($files[$i], '~') < 1) {
                echo '<tr>';
                echo " <td><a id='" . substr($files[$i], 0, count($files[$i]) - 5) . "a' href='#'><img width='20' src='./../images/file.png'/> " . $files[$i] . "</a></td><td>" . $mdata->$files[$i]->genre . "</td><td>" . $mdata->$files[$i]->desc . "</td><td>" . $mdata->$files[$i]->uploader . "</td>";
                echo " <td></td><td><input type='button' class='btn-primary' style='margin-right: 10px;' onclick='download(this.id)' id='" . $files[$i] . "' value='Approve' /><input type='button' class='btn-danger' onclick='deletev(this.id)' id='" . $files[$i] . "' value='Delete' /></td></tr><br>";
            } else if (!strpos($files[$i], '~') > 0) {
                echo "  <td> <a href='" . $files[$i] . "' > &nbsp;<img width='20' src='./../images/folder.png'/> " . $files[$i] . "/</a></td><br>";
            }
        }
        echo '</tbody>';
        echo '</table>';
        ?>



        <script type="text/javascript">

            function download(id) {
                //move to Download/Approved folder here
                var promptCount = 0;
                window.pw_prompt = function (options) {
                    var lm = options.lm || "Password:",
                            bm = options.bm || "Submit";
                    if (!options.callback) {
                        alert("No callback function provided! Please provide one.")
                    }
                    ;

                    var prompt = document.createElement("div");
                    prompt.className = "pw_prompt";

                    var submit = function () {
                        options.callback(input.value);
                        document.body.removeChild(prompt);
                    };

                    var label = document.createElement("label");
                    label.textContent = lm;
                    label.for = "pw_prompt_input" + (++promptCount);
                    prompt.appendChild(label);

                    var input = document.createElement("input");
                    input.id = "pw_prompt_input" + (promptCount);
                    input.type = "password";
                    input.addEventListener("keyup", function (e) {
                        if (e.keyCode == 13)
                            submit();
                    }, false);
                    prompt.appendChild(input);

                    var button = document.createElement("button");
                    button.textContent = bm;
                    button.addEventListener("click", submit, false);
                    prompt.appendChild(button);

                    document.body.appendChild(prompt);
                };

                pw_prompt({
                    lm: "Please enter your password:",
                    callback: function (password) {
                        passs = password;
                        if (passs.length < 4) {
                            if (Notification.permission !== "granted")
                                Notification.requestPermission();

                            var notification = new Notification('Hey there!', {
                                body: "Don't mess with this site!",
                                icon: "./../images/movie.png"
                            });

                            notification.onclick = function () {

                            };
                            return;
                        }
                        var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function () {
                            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                if (xmlhttp.responseText == "1")
                                {
                                    location.reload();
                                }
                                else
                                {
                                    sweetAlert({title: "Password Error", text: xmlhttp.responseText, timer: 3000});
                                }
                            }
                        }
                        xmlhttp.open("GET", "approve.php?pass=" + passs + "&fn=" + id, true);
                        xmlhttp.send();
                    }
                });

            }
            function deletev(id) {
                var promptCount = 0;
                window.pw_prompt = function (options) {
                    var lm = options.lm || "Password:",
                            bm = options.bm || "Submit";
                    if (!options.callback) {
                        alert("No callback function provided! Please provide one.")
                    }
                    ;

                    var prompt = document.createElement("div");
                    prompt.className = "pw_prompt";

                    var submit = function () {
                        options.callback(input.value);
                        document.body.removeChild(prompt);
                    };

                    var label = document.createElement("label");
                    label.textContent = lm;
                    label.for = "pw_prompt_input" + (++promptCount);
                    prompt.appendChild(label);

                    var input = document.createElement("input");
                    input.id = "pw_prompt_input" + (promptCount);
                    input.type = "password";
                    input.addEventListener("keyup", function (e) {
                        if (e.keyCode == 13)
                            submit();
                    }, false);
                    prompt.appendChild(input);

                    var button = document.createElement("button");
                    button.textContent = bm;
                    button.addEventListener("click", submit, false);
                    prompt.appendChild(button);

                    document.body.appendChild(prompt);
                };

                pw_prompt({
                    lm: "Please enter your password:",
                    callback: function (password) {
                        passs = password;
                        var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function () {
                            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                                if (xmlhttp.responseText === "1")
                                {
                                    location.reload();
                                }
                                else
                                {
                                    sweetAlert({title: "Password Error", text: xmlhttp.responseText, timer: 3000});
                                }
                            }
                        }
                        xmlhttp.open("GET", "delete.php?pass=" + passs + "&fn=" + id + "&pending=yes", true);
                        xmlhttp.send();
                    }
                });


            }

            var app = angular.module("myApp", []);
            app.controller("myCtrl", function ($scope) {
                $scope.content = "movie";
                $scope.genre = "n/a";
                $scope.playable = "true";
            });
            $(document).ready(function () {
                $('#table1').DataTable();
                $('input').addClass('btn');
                $('select').addClass('btn');
            });
        </script>
    </body>
</html>
