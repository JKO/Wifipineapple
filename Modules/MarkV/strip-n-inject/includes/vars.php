<?php

putenv('LD_LIBRARY_PATH='.getenv('LD_LIBRARY_PATH').':/sd/lib:/sd/usr/lib');   
putenv('PATH='.getenv('PATH').':/sd/usr/bin:/sd/usr/sbin');

global $directory, $rel_dir;

$code_path = "/pineapple/components/infusions/strip-n-inject/includes/proxy/injection.txt";
$ip_path = "/pineapple/components/infusions/strip-n-inject/includes/proxy/attacker_ip.txt";

$is_codeinject_installed = exec("if [ -e ".$directory."includes/installed ]; then echo '1'; fi") != "" ? 1 : 0;
$is_codeinject_running = exec("ps aux | grep python | grep -v grep") != "" ? 1 : 0;

$is_executable = exec("if [ -x ".$directory."includes/start.sh ]; then echo '1'; fi") != "" ? 1 : 0;
if(!$is_executable) exec("chmod +x ".$directory."includes/start.sh");

?>

