<?php

global $directory, $rel_dir, $version, $name;
require($directory."includes/vars.php");

?>

<script type='text/javascript' src='/components/infusions/strip-n-inject/includes/js/infusion.js'></script>
<style>@import url('/components/infusions/strip-n-inject/includes/css/infusion.css')</style>

<script type="text/javascript">
  $(document).ready(function(){ codeinject_init_small(); });
</script>

<?php

echo '[<a id="refresh" href="javascript:codeinject_refresh_tile();">Refresh</a>]&nbsp;<span id="codeinject_small" class="refresh_text"></span><br/><br/>';

if($is_codeinject_installed)
{
  if ($is_codeinject_running) 
  {
    echo "strip-n-sniff <span id=\"status_small\"><font color=\"lime\"><strong>enabled</strong></font></span>";
    echo " | <a id=\"codeinject_link_small\" href=\"javascript:codeinject_toggle('stop');\"><strong>Stop</strong></a><br /><br />";
  }
  else
  { 
    echo "strip-n-sniff <span id=\"status_small\"><font color=\"red\"><strong>disabled</strong></font></span>";
    echo " | <a id=\"codeinject_link_small\" href=\"javascript:codeinject_toggle('start');\"><strong>Start</strong></a><br /><br />"; 
  }
  
  echo "<textarea class='codeinject' readonly class='codeinject' id='log_output_small' name='log_output_small'></textarea>";
}
else
{
  echo "strip-n-sniff";
  echo "&nbsp;<font color=\"red\"><strong>not installed</strong></font><br /><br />";
}

?>
