<?php

namespace pineapple;
$pineapple = new Pineapple(__FILE__);

include "../functions.php";

/**
 * This is my first attempt at a page builder type thingy.
 * The main purpose of this is to get some idea of what will work best for the Portal Wizard in the next version of Evil Portal
 */

?>

<h2>Page Builder</h2>
<hr />

<table id="bobToolBar" style="margin-left:auto; margin-right:auto;" cellpadding="10px">
  <tr>
  	<td><a href="#" id="bobSavePage" onclick="bobBuilderSaveFile();"><b>Save File</b></a></td>
  	<td>-</td>
    <td><a href="#" id="phpFunctions" onclick="bobShowFunctionLibrary('php');">PHP Functions</a></td>
    <td><a href="#" id="jsFunctions" onclick="bobShowFunctionLibrary('javascript');">JavaScript Functions</a></td>
    <td><a href="#" id="htmlElements" onclick="bobShowFunctionLibrary('html');">HTML Elements</a></td>
    <td><a href="#" id="bobFormBuilder" onclick="bobShowFunctionLibrary('forms');">Form Builder</a></td>
  </tr>
</table>
<br />

<div id="editorStatus" style="text-align:center;"></div>

<label for="bobSaveName">File Name</label>
<input type="text" id="bobSaveName" placeholder="exmapleName.php">
<br />
<br />
<textarea style="width:100%; height:500px;" id="bobTextEditor" placeholder="Put the contents of your page here"></textarea>
<br />