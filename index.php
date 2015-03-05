<html>
    <head> 
        <script src="./assets/angular.min.js"></script>
        <script src="./assets/jquery-1.9.1.js"></script>
        <link rel="stylesheet" href = "./assets/bootstrap.min.css">
    </head>
    <body>
        <script>
            //Redirecting to actual file
            window.location.href = './movies/index.php';
        </script>
        <div class="navbar navbar-inverse" style="height: 10px;">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Contents</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>hello</li>
                    <li>guest</li>
                </ul>

            </div>
        </div>


        <h1>List of files</h1>

        <?php
        $dir = '.';
        $files = scandir($dir);


        for ($i = 0; $i < count($files); $i++) {
            if (strlen($files[$i]) < 3 && strpos($files[$i], '.') === 0) {
                continue;
            } else if ($files[$i] === "index.php" || $files[$i] === "assets" || $files[$i] === "images") {
                continue;
            }
            if (strpos($files[$i], '.') > 1 && strpos($files[$i], '~') < 1) {
                echo " <a href='" . $files[$i] . "' ><img width='20' src='./images/file.png'/> " . $files[$i] . "</a>";
                if (strpos($files[$i], '.mp4') > 1 || strpos($files[$i], '.avi') > 1 || strpos($files[$i], '.mkv') > 1) {
                    echo " <input type='button' class='btn-success' onclick='playvid(this.id)' id='" . substr($files[$i], 0, count($files[$i]) - 5) . "' value='play' /><div style='text-align:center;' id='div" . substr($files[$i], 0, count($files[$i]) - 5) . "'> </div>";
                } else {
                    echo '<br>';
                }
            } else if (!strpos($files[$i], '~') > 0) {
                echo " <a href='" . $files[$i] . "' ><img width='20' src='./images/folder.png'/> " . $files[$i] . "/</a><br>";
            }
        }
        ?>


        <script type="text/javascript">
            function playvid(id) {
                $("#div" + id).html("<video controls><source src='" + id + "'>Your browser does not support HTML5 video.</video><br><input type='button' class='btn-danger' id='" + id + "' value='Close Player' onclick='stopvid(this.id)'/><br>");
            }
            function stopvid(id) {
                $("#div" + id).html("");
            }

            var app = angular.module("myApp", []);
            app.controller("myCtrl", function ($scope) {
                $scope.firstName = "John";
                $scope.lastName = "Doe";
            });
        </script>
    </body>
</html>
