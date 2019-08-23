<div class="my_tile_content">
	
<?php

global $directory, $rel_dir, $version, $name;
require($directory."includes/vars.php");

?>

<script type='text/javascript' src='/components/infusions/monitor/includes/js/jquery.idTabs.min.js'></script>
<script type='text/javascript' src='/components/infusions/monitor/includes/js/infusion.js'></script>
<style>@import url('/components/infusions/monitor/includes/css/infusion.css')</style>

<script type="text/javascript">
	$(document).ready(function(){ monitor_init_small(); });
</script>

<div style='text-align:right'><a href="#" id="monitor_loading" class="refresh" onclick='javascript:monitor_refresh_tile();'></a></div>

<?php

if($is_vnstat_installed && $is_vnstati_installed)
{
	echo '<div id="monitor_content_small"></div>';
}
else
{
	echo "vnStat";
	echo "&nbsp;<span id=\"vnstat_status\"><font color=\"red\"><strong>&#10008;</strong></font></span><br />";
	echo '<script type="text/javascript">notify("vnStat is not installed", "monitor", "red");</script>';
}

?>

</div>