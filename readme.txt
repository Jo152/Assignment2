Download PHP QR-code generator library:
http://phpqrcode.sourceforge.net/
click download
click the green download button

unzip to app/core/phpqrcode
in init.php below include autoload, add
require "core/phpqrcode/qrlib.php";

php.ini uncomment extension=gd (line 925 for me)
you may have to restart apache

add method to output png

change view to call on this method instead

change getbarcodeurl to avoid google api

