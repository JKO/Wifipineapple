<?php

// for ubuntu
//global $directory, $rel_dir, $version, $name;
//require("/pineapple/components/infusions/get/includes/vars.php");

// for pineapple
global $directory, $rel_dir, $version, $name;
//require($directory."includes/vars.php");

require("/pineapple/components/infusions/get/includes/vars.php");


?>

<!-- for ubuntu
<script type='text/javascript' src='/pineapple/components/infusions/get/includes/js/jquery.idTabs.min.js'></script>
<script type='text/javascript' src='/pineapple/components/infusions/get/includes/js/infusion.js'></script>

<style>@import url('/pineapple/components/infusions/get/includes/css/infusion.css')</style>
-->

<!-- for pineapple -->
<script type='text/javascript' src='/components/infusions/get/includes/js/jquery.idTabs.min.js'></script>
<script type='text/javascript' src='/components/infusions/get/includes/js/infusion.js'></script>

<style>@import url('/components/infusions/get/includes/css/infusion.css')</style>

<script type="text/javascript">
  // this script is found in ./includes/js/infusion.js and executes when the tile loads
  $(document).ready(function() {  getInfusion_init(); } );
</script>

<?php
//require("/components/infusions/get/includes/install_header.php");
require($directory."includes/install_header.php");
?>

<div class="all">
  <div class="m">
    <div id="main">
      <div id="header">
        <table><tr><td>MAC</td><td>IP</td><td>Host Name</td><td>Options</td></tr></table>
      </div>

      <div id="content"></div>

      <div id="footer" align="right">
        <!--<p>(<a href="javascript:getInfusion_init();">Refresh</a>) (<a href="index.php">Connected Clients</a>) (<a href="javascript:getInfusion_init();">Client History</a>)</p>-->
        <p>(<a href="javascript:getInfusion_init();">Refresh</a>) | (<a href="javascript:getInfusion_eraseData();">Erase data</a>)</p>
        
      </div>

      <div id="content_info"></div>
      </div>

      <div id="comments">
      </div>
  </div>
</div>

