<?php

namespace pineapple;
$pineapple = new Pineapple(__FILE__);

/**
 * loadFiles
 * Get all of the files in the /www directory and display them
 */
function loadFiles() {
	global $pineapple;

	// get an array of files in /www
	$files = scandir("/www/");

?>
  <table style="width:75%; text-align:center; margin-left:auto; margin-right:auto;" cellpadding="0" cellspacing="10">
<?php

	foreach ($files as $file) {
		if ($file != ".." && $file != ".") {
			echo '<tr><td>' . $file . '</td><td><a href="#" onclick="bobViewPage(\'http://172.16.42.1/' . $file . '\')">View</a></td><td><a href="#" onclick="bobEditFile(\'' . $file . '\')">Edit</a></td><td><a href="#" onclick="bobRequestFileRename(\'' . $file . '\')">Rename</a></td><td><a href="#" onclick="bobRequestDelete(\'' . $file . '\')">Delete</td></tr>';
		}
	}

?>
  </table>
<?php

}

/**
 * showFileEditor
 * Open the file editor and display the contents of $fileName
 */
function showFileEditor($fileName, $message='') {
	$file = "/www/" . $fileName;

	if (file_exists($file)) {
		$f = fopen($file, "r");
		try{
			$data = fread($f, filesize($file));
		} catch (Exception $e) {}
		fclose($f);

?>
	<div id="editorStatus" style="text-align:center;"><?=$message ?></div>
	<br />
	<fieldset style="height:100%;">
		<legend>Editing <?=$fileName ?> - <a href="#" onclick="bobEditorSaveFile();"><b>Save</b></a> - <a href="#" onclick="bobEditorDisplaySaveAs();"><b>Save As</b></a> - <a href="#" onclick="close_popup();"><b>Cancel</b></a></legend>
		<input type="hidden" value="<?=$fileName ?>" id="bobSaveName"/>
		<button type="button" style="display:none;" id="bobSaveButton" onclick="bobEditorSaveFile();">Save</button>
		<br />
		<textarea style="width:100%; height:500px;" id="bobTextEditor"><?=$data ?></textarea>
		<br />
	</fieldset>

<?php
	}
}

/**
 * saveFile
 * Save a file
 */
function saveFile($fileName, $fileContent) {
	$file = "/www/" . $fileName;

	$f = fopen($file, 'w');
	fwrite($f, $fileContent);
	fclose($f);

	echo '<font color="green">Saved file ' . $fileName . ' sucessfully!</font>';
}

/**
 * showRenameWindow
 * Open the window to rename a file
 */
function showRenameWindow($fileName) {
	$file = "/www/" . $fileName;

	if (file_exists($file)) {
?>

	<br />
	<fieldset>
		<legend>Renaming <?=$fileName ?> - <a href="#" onclick="close_popup();">Cancel</a></legend>
		<br />
		<input type="hidden" id="oldFileName" value="<?=$fileName ?>" />
		<input type="text" id="newFileName" placeholder="New File Name" />
		<br />
		<br />
		<button type="button" id="bobRenameButton" onclick="bobFileRename();">Rename</button>
		<br />
	</fieldset>

<?php
	} else {
		echo "File does not exist";
	}
}

/**
 * renameFile
 * Rename a file
 */
function renameFile($fileName, $newName) {
	$oldFile = "/www/" . $fileName;
	$newFile = "/www/" . $newName;

	if (file_exists($oldFile) && !file_exists($newFile)) {
		rename($oldFile, $newFile);
	} else {
		echo "Unable to rename the file " . $oldFile;
	}


}

/**
 * bobDeleteFile
 * Delete file $fileName
 */
function bobDeleteFile($fileName) {
	$file = "/www/" . $fileName;

	if (file_exists($file)) {
		unlink($file);
	} else
		echo "file not found " . $file;
}

/**
 * createEmptyFile
 * Create an empty file in /www/
 */
function createEmptyFile($fileName) {
	$file = "/www/" . $fileName;

	if (!file_exists($file)) {
		$f = fopen($file, "w");
		fclose($f);
	} else {
		echo "<font color='red'>A file with that name already exists!</font>";
	}
}

/**
 * showPHPFunctions
 * Show the library of PHP functions
 */
function showPHPFunctions() {
?>

	<center>
		<h2>PHP Functions</h2>
		<table cellpadding="5px">
			<tr>
				<td>writeDataToFile($fileName, $data)</td>
				<td>Write data to a file</td>
				<td><a href="#" onclick="bobAddPHPFunction('writeDataToFile', 'prepend');">[+] Prepend</a></td>
				<td><a href="#" onclick="bobAddPHPFunction('writeDataToFile', 'append');">[+] Append</a></td>
			</tr>
			<tr>
				<td>redirect($url)</td>
				<td>Redirect to a URL</td>
				<td><a href="#" onclick="bobAddPHPFunction('redirect', 'prepend');">[+] Prepend</a></td>
				<td><a href="#" onclick="bobAddPHPFunction('redirect', 'append');">[+] Append</a></td>
			</tr>
		</table>
	</center>

<?php
}

/**
 * showJavaScriptFunctions
 * Show the library of JavaScript functions
 */
function showJavaScriptFunctions() {
?>

	<center>
		<h2>JavaScript Functions</h2>
		<table cellpadding="5px">
			<tr>
				<td>ajax calls</td>
				<td>Functions to submit data with AJAX</td>
				<td><a href="#" onclick="bobAddJSFunction('ajaxCalls', 'prepend');">[+] Prepend</a></td>
				<td><a href="#" onclick="bobAddJSFunction('ajaxCalls', 'append');">[+] Append</a></td>
			</tr>
			<tr>
				<td>redirect(url)</td>
				<td>Redirect to a URL</td>
				<td><a href="#" onclick="bobAddJSFunction('redirect', 'prepend');">[+] Prepend</a></td>
				<td><a href="#" onclick="bobAddJSFunction('redirect', 'append');">[+] Append</a></td>
			</tr>
			<tr>
				<td>alert(message)</td>
				<td>Popup a message</td>
				<td><a href="#" onclick="bobAddJSFunction('alert', 'prepend');">[+] Prepend</a></td>
				<td><a href="#" onclick="bobAddJSFunction('alert', 'append');">[+] Append</a></td>
			</tr>
		</table>
	</center>

<?php
}

/**
 * showHTMLElements
 * Show the library of HTML Elements
 */
function showHTMLElements() {
?>

	<center>
		<h2>HTML Elements</h2>
		<table cellpadding="5px">
			<tr>
				<td>Large Heading</td>
				<td><input type="text" id="h1Heading" placeholder="My Heading Here"></td>
				<td></td>
				<td><a href="#" onclick="bobAddHTMLElement('h1Heading')">[+] Add</a></td>
			</tr>
			<tr>
				<td>Medium Heading</td>
				<td><input type="text" id="h2Heading" placeholder="My Heading Here"></td>
				<td></td>
				<td><a href="#" onclick="bobAddHTMLElement('h2Heading')">[+] Add</a></td>
			</tr>
			<tr>
				<td>Small Heading</td>
				<td><input type="text" id="h3Heading" placeholder="My Heading Here"></td>
				<td></td>
				<td><a href="#" onclick="bobAddHTMLElement('h3Heading')">[+] Add</a></td>
			</tr>
			<tr>
				<td>Image</td>
				<td><input type="text" id="bobImage" placeholder="Image URL or path"></td>
				<td></td>
				<td><a href="#" onclick="bobAddHTMLElement('bobImage');">[+] Add</a></td>
			</tr>
			<tr>
				<td>Link</td>
				<td><input type="text" id="linkhref" placeholder="Link URL"></td>
				<td><input type="text" id="linkTitle" placeholder="Link Title"></td>
				<td><a href="#" onclick="bobAddHTMLElement('linkhref');">[+] Add</a></td>
			</tr>
			<tr>
				<td>Button</td>
				<td><input type="text" id="buttonName" placeholder="Button Title"></td>
				<td><input type="text" id="buttonClick" placeholder="Onclick Javascript call"></td>
				<td><a href="#" onclick="bobAddHTMLElement('buttonName');">[+] Add</a></td>
			</tr>
		</table>
	</center>

<?php
}

/**
 * formBuilder
 * Show the form builder
 */
function formBuilder() {
?>

	<center>
		<h2>Form Builder</h2>
	</center>
	<br />

	<div id="bobFormBuilder">
		<input type="hidden" value="0" id="bobInputNumber">
		<fieldset>
			<legend>Form - <a href="#" onclick="bobAddInputField('Text');">[+] Add Text Field</a> - <a href="#" onclick="bobAddInputField('Password');">[+] Add Password Field</a></legend>


			<table style="margin:auto; width:100%;" cellspacing="10">
				<tr>
					<td><label for="formMethod">Method</label></td>
					<td><select id="formMethod">
						<option value="GET">GET</option>
						<option value="POST">POST</option>
					</select></td>
				</tr>

				<tr>
					<td><label for="formAction">Action</label></td>
					<td><input type="text" id="formAction" placeholder="URL to submit to"></td>
				</tr>

				<tr>
					<td><label for="submitTitleValue">Submit Button Title</label></td>
					<td><input type="text" id="submitTitleValue" placeholder="Title for submit button"></td>
				</tr>

				<tr>
					<td><label for="submitOnclick">Submit Button Onclick</label></td>
					<td><input type="text" id="submitOnclick" placeholder="Javascript call for onclick event"></td>
				</tr>

			</table>

		</fieldset>

		<br />

	</div>

	<br />

	<button type="button" onclick="bobAddForm();">Add Form</button>

<?php
}

?>