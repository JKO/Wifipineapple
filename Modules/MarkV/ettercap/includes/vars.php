<?php

putenv('LD_LIBRARY_PATH='.getenv('LD_LIBRARY_PATH').':/sd/lib:/sd/usr/lib');   
putenv('PATH='.getenv('PATH').':/sd/usr/bin:/sd/usr/sbin');

global $directory, $rel_dir;

$installed = file_exists($directory."includes/installed") ? 1 : 0;
$is_ettercap_installed = exec("which ettercap") != "" ? 1 : 0;
$is_ettercap_running = exec("ps auxww | grep ettercap | grep -v -e grep | grep -v -e php") != "" ? 1 : 0;
$is_log_running = file_exists($directory."includes/log/tmp") != "" ? 1 : 0;

if(!$is_ettercap_running && $is_log_running) exec("rm -rf ".$directory."includes/log/tmp &");

$interfacesArray = explode("\n", trim(shell_exec("cat /proc/net/dev | tail -n +3 | cut -f1 -d: | sed 's/ //g'")));

$ettercap_run = parse_ini_file($directory."includes/infusion.run");
$int_run = $ettercap_run['int'];
$cmd_run = $ettercap_run['cmd'];

$interfaces = array();
for($i=0;$i<count($interfacesArray);$i++)
{
	$interfaces[$interfacesArray[$i]] = "-i ".$interfacesArray[$i];
}

$mitm_options = array(
				"arp" => "-M arp",
				"icmp" => "-M icmp",
				"dhcp" => "-M dhcp",
				"port" => "-M port"
				);

$proto_options = array(
				"tcp" => "-t tcp",
				"udp" => "-t udp",
				"all" => "-t all"
				);

$sniffing_and_attack_options = array(
				"Don't sniff, only perform the mitm attack" => "-o",
				"Do not put the iface in promisc mode" => "-p",
				"Do not forward packets" => "-u",
				"Use reversed TARGET matching" => "-R"
				);

$ui_type = array(
				"Do not display packet contents" => "-q",
				"Use console interface" => "-T"
				 );
				
$visualization_options = array(
				"Resolves ip addresses into hostnames" => "-d",  
				"Print extended header for every packet" => "-E",  
				"Do not display user and password" => "-Q"
				 );
				
$visualization_format = array(
				"hex" => "-V hex",  
				"ascii" => "-V ascii",  
				"text" => "-V text",
				"ebcdic" => "-V ebcdic",  
				"html" => "-V html",  
				"utf8" => "-V utf8"
				 );

$general_options = array(
				"Do not perform the initial ARP scan" => "-z"
				 );							
?>