<?php
// url locations
$hdr_image = "http://www.bolitech.com/~bolitest/ContactMailer/images/BolitechLogo.JPG";
$url_images = "http://www.bolitech.com/~bolitest/ContactMailer/images/";
$url_secure_php = "http://www.bolitech.com/~bolitest/ContactMailer/php/";


// set path for location of files on the server
$html_files = "/home/bolitest/public_html/ContactMailer/html/";
$php_files  = "/home/bolitest/public_html/ContactMailer/php/";
$images_files  = "/home/bolitest/public_html/ContactMailer/images/";
$mailer_files = "/home/bolitest/public_html/ContactMailer/mailer/";
$secured_php = "/home/bolitest/php/ContactMailer/";

// reply email address on the regemail header
// regmail Jesus Caritas Lay Fraternity title
$regemailaddr = "sales@bolitech.com";
$regemailtitle = "Contact Mailer Web App";

#######################################################
/* optional configuration options */
#######################################################

# table settings for images display
define('ROWS', 3);
define('COLS', 5);

# thumbnail demensions
define('THMBWIDTH', 160);
define('THMBHEIGHT',160);

# Application title
define('TITLE', "Contact Mailer Web Application");

# watermark your images, ie,
# define('WATERMARK', "This is a watermark");
define('WATERMARK', $_SERVER['HTTP_HOST']);

#######################################################
/* advanced configuration options */
#######################################################
# for extra security, store your images in a folder outside
# of the public webtree and define the path, ie,
# define('PATH', '/home/inaccessible_folder/images');
# NOTE: there is no ending slash
// define('PATH', str_replace('\\', '/', getcwd()));
define('PRIVATE_SESSION', '/home/bolitest/php/');
define('PRIVATE_DB', '/home/bolitest/php/ContactMailer/');

# location to self
define('SELF', $_SERVER['PHP_SELF']);

# allowed image MIME types
define('TYPE', serialize(array('image/jpg', 'image/jpeg', 'image/pjpeg', 'image/gif', 'image/png')));

# check for GD library
if(!function_exists('imagegif')) {
    die("<html>\r\n<body>\r\n<b>ERROR:</b> You either do not have the GD library installed, or you are using an outdated version of the library that does not support GIF images. If you are not concerned about GIF images, then you may remove this check from the configuration file. Otherwise, you will need to install or upgrade the GD library before you are able to use this gallery. Please visit <a href=\"http://www.php.net/gd\">http://www.php.net/gd</a> for more information.\r\n</body>\r\n</html>");
}
