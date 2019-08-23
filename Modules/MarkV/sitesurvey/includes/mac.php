<?php

require("/pineapple/components/infusions/sitesurvey/handler.php");
require("/pineapple/components/infusions/sitesurvey/functions.php");

global $directory;

require($directory."includes/vars.php");

$content = file_get_contents("http://standards.ieee.org/cgi-bin/ouisearch?".$_GET['w']);
echo $content;

?>