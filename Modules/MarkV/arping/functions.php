<?php
$ok = 'no';
$cmd = "arping";
if($_POST['f'] == '1'){
$cmd .= " -f";
$ok = 'yes';
}
if($_POST['b'] == '1'){
$cmd .= " -b";
}
if($_POST['D'] == '1'){
$cmd .= " -D";
}
if($_POST['U'] == '1'){
$cmd .= " -U";
}
if($_POST['A'] == '1'){
$cmd .= " -A";
}
if($_POST['c'] == '1'){
$cmd .= " -c ";
$cmd .= $_POST['CNT'];
$ok = 'yes';
}
if($_POST['w'] == '1'){
$cmd .= " -w ";
$cmd .= $_POST['TIMEOUT'];
}
$cmd .= " -I ";
$cmd .= 
$_POST['IFACE'];
$cmd .= " -s ";
$cmd .= preg_replace('/[^0-9.]/','',$_POST['SRC_IP']); // strip all chars that shouldn't be in an ip
$cmd .= " ";
$cmd .= preg_replace('/[^0-9.]/','',$_POST['DST_IP']); 
if($_POST['q'] == '1'){
$cmd .= " |at now"; // might as well start a new process because we don't care about the output and it's better not to hang php
exec($cmd);
} else {
if($ok == 'yes'){
exec('rm /tmp/computerchris.arping.output & touch /tmp/computerchris.arping.output'); //We want to make sure this file is blank
$cmd .= ' >> /tmp/computerchris.arping.output';
exec($cmd);
$out = array();
exec('cat /tmp/computerchris.arping.output', $out);
foreach($out as $line){
echo $line;
echo ('<BR />'); //line break between lines so the text doesn't look jumbled up
}
} else { echo("You need to specify either don't show output, count, or quit on first reply"); } } 
//TO DO: add feature to small tile to tell if it is running in the background("Don't show output") and add feature stop it from both tiles
?>
