<?php

namespace pineapple;
$pineapple = new Pineapple(__FILE__);

// Include the pineapple API
include "../functions.php";

?>

<h2>Library</h2>
<hr />
<center>
  <div id="bobLibraryMessages"></div>
  <br />
  <input type="text" placeholder="Empty File Name" id="bobEmptyFile">
  <a href="#" onclick="newEmptyFile();">Create Empty File</a>
</center>
<br />
<br />

<div id="bobLibrary">
  <?=loadFiles() ?>
</div>
