<?php

putenv('LD_LIBRARY_PATH='.getenv('LD_LIBRARY_PATH').':/sd/lib:/sd/usr/lib');   
putenv('PATH='.getenv('PATH').':/sd/usr/bin:/sd/usr/sbin');

global $directory, $rel_dir;

$is_dnsspoof_installed = exec("which dnsspoof") != "" ? 1 : 0;
$is_dnsspoof_running = exec("ps auxww | grep dnsspoof | grep -v -e grep | grep -v -e php") != "" ? 1 : 0;
$is_dnsspoof_onboot = exec("cat /etc/rc.local | grep dnsspoof/includes/autostart.sh") != "" ? 1 : 0;

$hosts_path = "/etc/pineapple/spoofhost";
$redirect_path = "/www/redirect.php";

$fake_files_installed = file_exists("/www/ncsi.txt") && file_exists("/www/library/test/success.html") ? 1 : 0;

$is_executable = exec("if [ -x ".$directory."includes/autostart.sh ]; then echo '1'; fi") != "" ? 1 : 0;
if(!$is_executable) exec("chmod +x ".$directory."includes/autostart.sh");

?>