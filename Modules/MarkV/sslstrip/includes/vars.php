<?php

putenv('LD_LIBRARY_PATH='.getenv('LD_LIBRARY_PATH').':/sd/lib:/sd/usr/lib');   
putenv('PATH='.getenv('PATH').':/sd/usr/bin:/sd/usr/sbin');

global $directory, $rel_dir;

$is_sslstrip_installed = exec("which sslstrip") != "" ? 1 : 0;
$is_sslstrip_running = exec("ps auxww | grep sslstrip | grep -v -e grep | grep -v -e php") != "" ? 1 : 0;
$is_sslstrip_onboot = exec("cat /etc/rc.local | grep sslstrip/includes/autostart.sh") != "" ? 1 : 0;
$is_verbose = exec("ps auxww | grep \"sslstrip -a\" | grep -v -e grep | grep -v -e php");

if(!file_exists("/usr/lib/python2.7/site-packages/OpenSSL") && file_exists("/sd/usr/lib/python2.7/site-packages/OpenSSL"))
{
	exec("ln -s /sd/usr/lib/python2.7/site-packages/OpenSSL /usr/lib/python2.7/site-packages/");
}

if(!file_exists("/usr/lib/python2.7/site-packages/twisted/web") && file_exists("/sd/usr/lib/python2.7/site-packages/twisted/web"))
{
	exec("ln -s /sd/usr/lib/python2.7/site-packages/twisted/web /usr/lib/python2.7/site-packages/twisted/");
}

$is_executable = exec("if [ -x ".$directory."includes/autostart.sh ]; then echo '1'; fi") != "" ? 1 : 0;
if(!$is_executable) exec("chmod +x ".$directory."includes/autostart.sh");

$custom_commands = explode("\n", trim(file_get_contents($directory."includes/infusion.conf")));

?>