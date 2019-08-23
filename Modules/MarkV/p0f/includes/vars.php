<?php

putenv('LD_LIBRARY_PATH='.getenv('LD_LIBRARY_PATH').':/sd/lib:/sd/usr/lib');   
putenv('PATH='.getenv('PATH').':/sd/usr/bin:/sd/usr/sbin');

global $directory, $rel_dir;

$is_p0f_installed = exec("which p0f") != "" ? 1 : 0;
$is_p0f_running = exec("ps auxww | grep p0f | grep -v -e grep | grep -v -e php") != "" ? 1 : 0;
$is_p0f_onboot = exec("cat /etc/rc.local | grep p0f/includes/autostart.sh") != "" ? 1 : 0;

$interfaces = explode("\n", trim(shell_exec("cat /proc/net/dev | tail -n +3 | cut -f1 -d: | sed 's/ //g'")));
$current_interface = trim(file_get_contents($directory."includes/infusion.run"));

$custom_commands = explode("\n", trim(file_get_contents($directory."includes/infusion.conf")));

$is_executable = exec("if [ -x ".$directory."includes/autostart.sh ]; then echo '1'; fi") != "" ? 1 : 0;
if(!$is_executable) exec("chmod +x ".$directory."includes/autostart.sh");

?>