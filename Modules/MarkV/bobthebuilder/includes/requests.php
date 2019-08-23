<?php

namespace pineapple;
$pineapple = new Pineapple(__FILE__);

include "../functions.php";

// A delete request was made
if (isset($_GET['delete'])) {
	bobDeleteFile($_GET['delete']);
	loadFiles();
}

// A edit request has been made
if (isset($_GET['edit'])) {
	@showFileEditor($_GET['edit'], $_GET['message']);
}

// A library listing was requested
if (isset($_GET['library'])) {
	loadFiles();
}

// A save request was made
if (isset($_GET['save'])) {
	saveFile($_GET['save'], $_POST['data']);
}

// A request to rename a file was made
if (isset($_GET['requestRename'])) {
	showRenameWindow($_GET['requestRename']);
}

if (isset($_GET['rename'])) {
	renameFile($_GET['rename'], $_GET['newName']);
	loadFiles();
}

if (isset($_GET['createEmpty'])) {
	createEmptyFile($_GET['createEmpty']);
}

if (isset($_GET['showFunctions'])) {
	$library = $_GET['showFunctions'];

	switch ($library) {
		case "php":
			showPHPFunctions();
			break;

		case "javascript":
			showJavaScriptFunctions();
			break;

		case "html":
			showHTMLElements();
			break;

		case "forms":
			formBuilder();
			break;

		case "css":
			break;

		case "upload":
			break;
	}
}

?>