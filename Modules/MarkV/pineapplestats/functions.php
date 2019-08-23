<?php

function remoteFileExists($url) {
	$status = exec("curl -k -o /dev/null --silent --head --write-out '%{http_code}\n' ".$url);
	
	if($status == "200") return TRUE;
	else return FALSE;
}

?>