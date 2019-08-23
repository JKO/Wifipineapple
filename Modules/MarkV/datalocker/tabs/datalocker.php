<?php
namespace pineapple;
$pineapple = new Pineapple(__FILE__);

// Include the pineapple API
include "../functions.php";

?>

<h2>Data Locker</h2>

<hr />
<br />

<center><div id="datalockerStatus"></div></center>

<br />

<div style="float:left; width:49%;">
  <fieldset>
    <legend><b>Encrypt File</b></legend>

    <form method="POST" id="encrypt" action="/components/infusions/datalocker/functions.php?encrypt">
      <table cellpadding="5">
        <tr>
          <td><label for="file">File To Encrypt</label></td>
          <td><input type="text" name="file" id="file" placeholder="/path/to/my/file.example" required></td>
        </tr>

        <tr>
          <td><label for="algo">Algorithm</label></td>
          <td><select id="algo" name="algo">
            <option value="aes256">AES-256</option>
            <option value="aes128">AES-128</option>
          </select></td>
        </tr>

        <tr>
          <td><label for="key">Encryption Key</label></td>
          <td><input type="password" name="key" id="key" placeholder="Secret Encryption Key" required></td>
        </tr>

        <tr>
          <td><button type="button" onclick="postToBar('#encrypt');">Encrypt File</button></td>
        </tr>
      </table>
    </form>
  </fieldset>
</div>

<div style="float:right; width:49%;">
  <fieldset>
    <legend><b>Decrypt File</b></legend>

    <form method="POST" id="decrypt" action="/components/infusions/datalocker/functions.php?decrypt">
      <table cellpadding="5">
        <tr>
          <td><label for="file">File To Decrypt</label></td>
          <td><input type="text" name="file" id="file" placeholder="/path/to/my/file.encrypted" required></td>
        </tr>

        <tr>
          <td><label for="algo">Algorithm</label></td>
          <td><select id="algo" name="algo">
            <option value="aes256">AES-256</option>
            <option value="aes128">AES-128</option>
          </select></td>
        </tr>

        <tr>
          <td><label for="key">Encryption Key</label></td>
          <td><input type="password" name="key" id="key" placeholder="Secret Encryption Key" required></td>
        </tr>

        <tr>
          <td><button type="button" onclick="postToBar('#decrypt');">Decrypt File</button></td>
        </tr>

      </table>
    </form>

  </fieldset>
</div>

<br />

<div id="fileTracker" style="float:left; width:100%; padding-top:20px;">
  <fieldset>
    <legend><b>File Tracker</b> - <a href="#" onclick="refreshTracker();">Refresh</a></legend>
      <div id="fileTrackerFiles">
        <?=showFileTracker(); ?>
      </div>
  </fieldset>
</div>
