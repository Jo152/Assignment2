<?php
session_start();
require "autoload.php";

// For Windows:
 $path = getcwd();
 $path = preg_replace('/^.+\\\\htdocs\\\\/', '/', $path);
 $path = str_replace('\\', '/', $path);
 define("BASE", $path);

// For Mac:
/*$path = getcwd();
$path = preg_replace('/^.+\\/htdocs\\//', '/', $path);
$path = str_replace("\\/", "/", $path);
define("BASE", $path);
*/
$unread = 0;
define("UNREAD", $unread);
$read = 1;
define("READ", $read);
$reread = 2;
define("REREAD", $reread);

$private = 0;
define("PRIVATE_MSG", $private);
$public = 1;
define("PUBLIC_MSG", $public);

$unseen = 0;
define("UNSEEN", $unseen);
$seen = 1;
define("SEEN", $seen);

?>