<?php

$name = 'strip-n-inject';  #Name of tile
$updatable = 'false';  #Should this tile auto-refresh
$version = '1.2';

include('/pineapple/includes/api/tile_functions.php');
$directory = realpath(dirname(__FILE__)).'/';
$rel_dir = str_replace('/pineapple', '', $directory);
include('/pineapple/includes/api/handler_helper.php');

?>
