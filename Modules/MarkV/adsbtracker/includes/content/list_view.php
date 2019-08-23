<fieldset>
  <legend>List View</legend>
	<pre>

<?php
$adsbtracker_running = exec("pidof dump1090");
if($adsbtracker_running == "") {
  echo "The dump1090 daemon is not running. Please start the service from the Configuration tab.";
} else {
  echo file_get_contents("http://127.0.0.1:9090/output");
}
?>

	</pre>
</fieldset>

