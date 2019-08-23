<?php
// for pineapple
require("/pineapple/components/infusions/base64encdec/includes/vars.php");
?>

<!-- for pineapple -->
<script type='text/javascript' src='/components/infusions/base64encdec/includes/js/jquery.idTabs.min.js'></script>
<script type='text/javascript' src='/components/infusions/base64encdec/includes/js/infusion.js'></script>

<style>@import url('/components/infusions/base64encdec/includes/css/infusion.css')</style>

<script type="text/javascript">
  // this script is found in ./includes/js/infusion.js and executes when the tile loads
  $(document).ready(function() {  base64encdecInfusion_init(); } );
</script>

<div class="all">
    <div id="base64-box">
       <center>
       Input
       <form accept-charset="utf-8">
           <textarea id="content" name="content" style="width: 50%; height: 30%; border-top-left-radius: 5px; border-top-right-radius: 5px; border-bottom-right-radius: 5px; border-bottom-left-radius: 5px;"/><br />
           <select id="operation">
              <option value="encode">Encode</option>
              <option value="decode">Decode</option>
           </select>
           <input type="reset" value="Reset data" />
           <input type="button" value="Submit" onclick="javascript:process();"/>
       </form>
       </center>
    </div>
    
    <div id="result">
    
    </div>
</div>

</center>
</div>
