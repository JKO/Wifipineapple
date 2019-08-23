<?php

namespace pineapple;
$pineapple = new Pineapple(__FILE__);

include "../functions.php";

$file = "/etc/nodogsplash/htdocs/splash.html";

showConfigFile($file, $pineapple);

?>
