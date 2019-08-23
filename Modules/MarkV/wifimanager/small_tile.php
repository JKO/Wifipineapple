<div class="my_tile_content">
	
<?php

global $directory, $version, $name;
require($directory."includes/vars.php");

?>

<script type='text/javascript' src='/components/infusions/wifimanager/includes/js/infusion.js'></script>
<style>@import url('/components/infusions/wifimanager/includes/css/infusion.css')</style>

<script type="text/javascript">
	$(document).ready(function(){ wifimanager_init_small(); });
</script>

<div style='text-align:right'><a href="#" id="wifimanager_loading" class="refresh" onclick='javascript:wifimanager_refresh_tile();'></a></div>

<?php

echo '<div id="wifimanager_interfaces_tile"></div>';

?>

<div id="wifimanager" class="loading"></div>

</div>