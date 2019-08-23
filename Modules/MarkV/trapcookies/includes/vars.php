<?php

putenv('LD_LIBRARY_PATH='.getenv('LD_LIBRARY_PATH').':/sd/lib:/sd/usr/lib');   
putenv('PATH='.getenv('PATH').':/sd/usr/bin:/sd/usr/sbin');

global $directory, $rel_dir;

$is_ngrep_installed = exec("which ngrep") != "" ? 1 : 0;
$is_ngrep_running = exec("ps auxww | grep ngrep | grep -v -e \"grep ngrep\" | grep -v -e php") != "" ? 1 : 0;
$is_ngrep_onboot = exec("cat /etc/rc.local | grep trapcookies/includes/autostart.sh") != "" ? 1 : 0;

$is_dnsspoof_running = exec("ps auxww | grep dnsspoof | grep -v -e grep | grep -v -e php") != "" ? 1 : 0;

$is_landing_installed = file_exists("/www/index.php.backup") ? 1 : 0;

$hosts_path = "/etc/pineapple/spoofhost";
$landing_path = "/www/index.php";

$is_executable = exec("if [ -x ".$directory."includes/autostart.sh ]; then echo '1'; fi") != "" ? 1 : 0;
if(!$is_executable) exec("chmod +x ".$directory."includes/autostart.sh");

?>