<?php
$up_id = uniqid();
?>

<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Movie Uploader</title>
        <!--Progress Bar and iframe Styling-->
        <link href="style-progress.css" rel="stylesheet" type="text/css" />

        <!--Get jQuery-->
        <script src="./../../assets/jquery-1.9.1.js" type="text/javascript"></script>
        <link rel="stylesheet" href = "./../../assets/bootstrap.min.css">

        <script language="JavaScript" type="text/javascript">

            // allow all extensions
            var exts = "";

            // only allow specific extensions
            // var exts = "jpg|jpeg|gif|png|bmp|tiff|pdf";

            function checkExtension(value)
            {
                if (value == "")
                    return true;
                var re = new RegExp("^.+\.(" + exts + ")$", "i");
                if (!re.test(value))
                {
                    alert("Your file extension is not allowed: \n" + value + "\n\nOnly the following extensions are allowed: " + exts.replace(/\|/g, ',') + " \n\n");
                    return false;
                }

                return true;
            }

            $(document).ready(function () {
                //

                //show the progress bar only if a file field was clicked
                var show_bar = 0;
                $('input[type="file"]').click(function () {
                    show_bar = 1;
                });

                //show iframe on form submit
                $("#upload-form").submit(function () {

                    if (show_bar === 1) {
                        $('#progress-frame').show();
                        function set() {
                            $('#progress-frame').attr('src', 'progress-frame.php?up_id=<?php echo $up_id; ?>');
                        }
                        setTimeout(set);
                    }
                });
                //

            });


            var next_id = 0;

            var max_number = 20;

            function _add_more() {

                if (next_id >= max_number)
                {
                    alert("You reached maximum number of 20 files!");
                    return;
                }

                next_id = next_id + 1;
                var next_div = next_id + 1;
                var txt = "<br><input type=\"file\" name=\"item_file[]\" onChange=\"checkExtension(this.value)\">";
                txt += '<div id="dvFile' + next_div + '"></div>';
                document.getElementById("dvFile" + next_id).innerHTML = txt;
            }


            function validate(f) {
                var chkFlg = false;
                for (var i = 0; i < f.length; i++) {
                    if (f.elements[i].type == "file" && f.elements[i].value != "") {
                        chkFlg = true;
                    }
                }
                if (!chkFlg) {
                    alert('Please browse/choose at least one file');
                    return false;
                }
                f.pgaction.value = 'upload';
                return true;
            }
            $(document).ready(function () {
                var ip = $("#ip").val();
                $("#ipdiv").append(ip);
            });
        </script>


    </head>

    <body>
        <div class="navbar navbar-inverse" style="height: 10px;">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="./../index.php"><img width="28px" src="../../images/back-icon.jpg" style="background: dimgray"/> Back to Movies</a>
            </div>
            <div class="navbar-collapse collapse" style="float: right;">
                <div style="color: #AAAAAA;padding-top: 15px;" id="ipdiv">Your IP Will be Recorded : </div>
            </div>
        </div>
        <div class="container">
            <p><b>Movie Uploader</b></p>

            <form enctype="multipart/form-data"  action="upload.php" method="post" name="upload-form" id="upload-form">

                <!--hidden field-->
                <input type="hidden" value="demo" name="<?php echo ini_get("session.upload_progress.name"); ?>"/>
                <!---->


                <div id="dvFile0"><input type="file" name="item_file[]" onChange="checkExtension(this.value)"></div><div id="dvFile1"></div>
                <br>
                <a href="javascript:_add_more(0);"><B>(+) Add file</B></a>
                <br><br>
                <select id="multi" name="genre"  class="btn">
                    <option value="null">Select Genre/type</option>
                    <option value="Action">Action</option>
                    <option value="Animation">Animation</option>
                    <option value="Biography">Biography</option>
                    <option value="Bollywood">Bollywood</option>
                    <option value="Drama">Drama</option>
                    <option value="Funny_Comedy">Funny/Comedy</option>
                    <option value="Horror">Horror</option>
                    <option value="Mystery">Mystery</option>
                    <option value="Sci_fi">Sci-fi</option>
                    <option value="Song/Music/Musical">Song/Music/Musical</option>
                    <option value="Thriller">Thriller</option>
                    <option value="Other">Other</option>
                </select>
                <br><br>
                <textarea name="desc" rows="3" cols="26" placeholder="Description"></textarea>

                </textarea>
                <br><br>
                <input type="submit" class="btn btn-success" style="width:175px" value="Upload!">
                <?php
                $ip = 'N/A';
                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                    $ip = $_SERVER['REMOTE_ADDR'];
                }
                echo '<input type="hidden" id="ip" name="ip" value="' . $ip . '"  hidden="hidden"/>';
                ?>
            </form>

            <!--Include the progress bar frame-->
            <iframe style="position: relative; top: 5px;" id="progress-frame" name="progress-frame" border="0" src="" scrollbar="no" frameborder="0" scrolling="no"> </iframe>
            <!---->
        </div>
    </body>

</html> 


