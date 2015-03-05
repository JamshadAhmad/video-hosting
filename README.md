# video-hosting
A video hosting site, custom for Coeus LAN network. Doesn't use any kind of Database and runs perfectly even without internet connection . It has download options for all kind of files and HTML5 supported streaming for video files.

**Runs on PHP 5.4+**

Steps to Deploy:

1) Clone this [Repo](https://github.com/JamshadAhmad/video-hosting.git) where you place your web apps

2) Update your php version to 5.4+

    sudo apt-get install python-software-properties
    sudo add-apt-repository ppa:ondrej/php5-oldstable
    sudo apt-get update 
    sudo apt-get install php5

3) Set your movies directory by placing the path Line#47 of `video-hosting/movies/multi-uploader/upload.php`

`$path = "/var/www/video-hosting/movies/pending" . $filen;`

`$path = "/var/www/video-hosting/movies/" . $filen;` in 'approve.php'

to

`$path = "[Custom Path]" . $filen;`

4) Add write permissions to Movies Directory

5) Increase php `upload_max_filesize` and `post_max_size` from

    php.ini

in ubuntu, `/etc/php5/cli/php.ini` and `/etc/php5/apache2/php.ini`

by default it would be 40M, make it like 9999M for large files.

6) Restart your apache server

7) Change delete password by placing its md5 eqvalent in `/assets/pass.dat` file

8) Enjoy the Awesomeness by going `[yourIP]/video-hosting/` . 

On server, you can place videos by using web ui or just by copying them to `/movies` directory.
