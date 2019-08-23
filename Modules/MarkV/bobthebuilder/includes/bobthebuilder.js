/**
 * bobViewPage(url)
 * @param url
 * Open url in an iframe in a popup overlay
 */
function bobViewPage(url) {
	popup("<br /><iframe src='" + url + "' width='100%' height='80%' />");
}

/**
 * bobRefreshLibrary()
 * Refresh the div that contains the library table
 */
function bobRefreshLibrary() {
	$.get('/components/infusions/bobthebuilder/includes/requests.php?library', function(data) {
		$("#bobLibrary").html(data);
	});
}

/**
 * bobRequestDelete()
 * Show a popup to confirm deleting the file
 */
function bobRequestDelete(file) {
	message = "<b>Are you sure you want to delete " + file + "?<b/>";
	yesOption = "<a href='#' onclick='bobDeleteFile(\"" + file + "\"); close_popup();'>Yes</a>";
	noOption = "<a href='#' onclick='close_popup();'>No</a>";
	popup("<center>" + message + "<br/><br/>" + yesOption + " " + noOption + "</center>");
}

/**
 * bobDeleteFile(file)
 * Delete a file
 */
function bobDeleteFile(file) {
	$.get('/components/infusions/bobthebuilder/includes/requests.php?delete=' + file + '', function(data) {
		$("#bobLibrary").html(data);
	});
}

/**
 * bobEditFile
 * Request to open the editor for a file
 */
function bobEditFile(file, message) {
	message = message || '';
	$.get('/components/infusions/bobthebuilder/includes/requests.php?edit=' + file + '&message=' + message + '', function(data) {
		popup(data);
	});
}

/**
 * bobEditorDisplaySaveAs
 * Display the elements for the save as option
 */
function bobEditorDisplaySaveAs() {
	document.getElementById('bobSaveName').type = "text";
	document.getElementById('bobSaveButton').style.display = "block";
}

/**
 * bobEditorSaveFile
 * Send a request to save a file from the editor window
 */
function bobEditorSaveFile() {
	fileName = document.getElementById('bobSaveName').value;
	fileData = document.getElementById('bobTextEditor').value;
	$.post('/components/infusions/bobthebuilder/includes/requests.php?save=' + fileName + '', {data:fileData}, function(data) {
		bobRefreshLibrary();
		bobEditFile(fileName, data);
		//$("#editorStatus").html(data);
	});
}

/**
 * bobBuilderSaveFile()
 * Send a request to save a file from the builder window
 */
function bobBuilderSaveFile() {
	fileName = document.getElementById('bobSaveName').value;
	fileData = document.getElementById('bobTextEditor').value;
	if (fileName != "") {
		$.post('/components/infusions/bobthebuilder/includes/requests.php?save=' + fileName + '', {data:fileData}, function(data) {
			$("#editorStatus").html(data);
		});
	} else {
		$("#editorStatus").html("<font color='red'>Your file has no name!</font>");
	}
}

/**
 * bobRequestFileRename
 * Open a popup window to rename a file
 */
function bobRequestFileRename(file) {
	$.get('/components/infusions/bobthebuilder/includes/requests.php?requestRename=' + file + '', function(data) {
		popup(data);
	});
}


/**
 * bobFileRename
 * Send the request to rename a file
 */
function bobFileRename() {
	oldName = document.getElementById('oldFileName').value;
	newName = document.getElementById('newFileName').value;

	$.get('/components/infusions/bobthebuilder/includes/requests.php?rename=' + oldName + '&newName=' + newName + '', function(data) {
		$("#bobLibrary").html(data);
		close_popup();
	});
}

/**
 * newEmptyFile
 * Create a new empty file
 */
function newEmptyFile() {
	fileName = document.getElementById("bobEmptyFile").value;
	$.get('/components/infusions/bobthebuilder/includes/requests.php?createEmpty=' + fileName + '', function(data) {
		bobRefreshLibrary();
		$("#bobLibraryMessages").html(data);
		document.getElementById("bobEmptyFile").value = "";
	});
}

/**
 * bobShowPHPLibrary()
 * Show the library of pre-made PHP functions
 */
function bobShowFunctionLibrary(library) {
	$.get('/components/infusions/bobthebuilder/includes/requests.php?showFunctions=' + library + '', function(data) {
		popup(data);
	});
}

/**
 * bobAddPHPFunction()
 * Adds a PHP function to the page
 */
function bobAddPHPFunction(func, location) {

	textEditor = document.getElementById("bobTextEditor")
	currentCode = textEditor.value;
	addedCode = "";

	switch(func) {
		case "writeDataToFile":
			addedCode = "<?php\n";
			addedCode += "function writeDataToFile($fileName, $data) {\n";
			addedCode += "\t$f = fopen($fileName, 'a');\n";
			addedCode += "\tfwrite($f, $data . '\\n');\n";
			addedCode += "\tfclose($f);\n"
			addedCode += "}\n\n";
			addedCode += "writeDataToFile('/www/demoFile.txt', 'hello world');\n";
			addedCode += "?>";
			break;

		case "redirect":
			addedCode = "<?php\n";
			addedCode += "function preformRedirect($url) {\n";
			addedCode += "\theader('Location: ' . $url);\n";
			addedCode += "}\n\n";
			addedCode += "preformRedirect('https://exmaple.com');\n";
			addedCode += "?>";
			break;
	}

	switch(location) {
		case "append":
			textEditor.value = currentCode + "\n\n" + addedCode;
			break;

		case "prepend":
			textEditor.value = addedCode + "\n\n" + currentCode;
			break;
	}
}

/**
 * bobAddPHPFunction()
 * Adds Javascript Functions to the page
 */
function bobAddJSFunction(func, location) {

	textEditor = document.getElementById("bobTextEditor")
	currentCode = textEditor.value;
	addedCode = "";

	switch(func) {
		case "ajaxCalls":
			addedCode = "<script type='text/javascript'>\n";
			addedCode += "function create_ajax_request() {\n";
			addedCode += "\tif (window.XMLHttpRequest)  {\n";
			addedCode += "\t\treturn new XMLHttpRequest();\n";
			addedCode += "\t} else if (window.ActiveXObject) {\n"
			addedCode += "\t\treturn new ActiveXObject('Microsoft.XMLHTTP');\n";
			addedCode += "\t} else {\n";
			addedCode += "\t\treturn false;";
			addedCode += "\t}\n";
			addedCode += "}\n\n";
			addedCode += "function ajax_get(toChange, change, getFrom) {\n";
			addedCode += "\tvar xmlhttp = new create_ajax_request();\n";
			addedCode += "\txmlhttp.onreadystatechange=function() {\n";
			addedCode += "\t\tif (xmlhttp.readyState==4 && xmlhttp.status==200) {\n";
			addedCode += "\t\t\tif (change == true) {\n";
			addedCode += "\t\t\t\tdocument.getElementById(toChange).innerHTML=xmlhttp.responseText;\n";
			addedCode += "\t\t\t}\n";
			addedCode += "\t\t}\n";
			addedCode += "\t}\n";
			addedCode += "\txmlhttp.open('GET', getFrom, true);\n";
			addedCode += "\txmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');\n";
			addedCode += "\txmlhttp.send();\n";
			addedCode += "}\n\n";
			addedCode += "function ajax_post(toChange, change, postValue, postTo) {\n";
			addedCode += "\tvar xmlhttp = new create_ajax_request();\n";
			addedCode += "\txmlhttp.onreadystatechange=function() {\n";
			addedCode += "\t\tif (xmlhttp.readyState==4 && xmlhttp.status==200) {\n";
			addedCode += "\t\t\tif (change == true) {\n";
			addedCode += "\t\t\t\tdocument.getElementById(toChange).innerHTML=xmlhttp.responseText;\n";
			addedCode += "\t\t\t}\n";
			addedCode += "\t\t}\n";
			addedCode += "\t}\n";
			addedCode += "\tvar parameters='values='+encodeURIComponent(postValue);\n";
			addedCode += "\txmlhttp.open('POST', postTo, true);\n";
			addedCode += "\txmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');\n";
			addedCode += "\txmlhttp.send(parameters);\n";
			addedCode += "}\n\n";
			addedCode += "</script>";
			break;

		case "redirect":
			addedCode = "<script type='text/javascript'>\n";
			addedCode += "\twindow.location = 'http://exmaple.com';\n";
			addedCode += "</script>";
			break;

		case "alert":
			addedCode = "<script type='text/javascript'>\n";
			addedCode += "\talert('hello world!');\n";
			addedCode += "</script>";
			break;
	}

	switch(location) {
		case "append":
			textEditor.value = currentCode + "\n" + addedCode;
			break;

		case "prepend":
			textEditor.value = addedCode + "\n" + currentCode;
			break;
	}
}

/**
 * bobAddPHPFunction()
 * Adds HTML elements to the page
 */
function bobAddHTMLElement(elem) {

	textEditor = document.getElementById("bobTextEditor")
	currentCode = textEditor.value;
	addedCode = "";

	switch(elem) {
		case "h1Heading":
			addedCode = "<h1>" + document.getElementById(elem).value + "</h1>";
			break;

		case "h2Heading":
			addedCode = "<h2>" + document.getElementById(elem).value + "</h2>";
			break;

		case "h3Heading":
			addedCode = "<h3>" + document.getElementById(elem).value + "</h3>";
			break;

		case "bobImage":
			addedCode = "<img src='" + document.getElementById(elem).value + "' />";
			break;

		case "linkhref":
			addedCode = "<a href='" + document.getElementById(elem).value + "'>" + document.getElementById("linkTitle").value + "</a>";
			break;

		case "buttonName":
			addedCode = "<button type='button' onclick='" + document.getElementById("buttonClick").value + "'>" + document.getElementById(elem).value + "<button>";

	}

	textEditor.value = currentCode + "\n" + addedCode + "\n";

}

/**
 * bobAddForm()
 * Adds a HTML form the page
 */
function bobAddForm() {

	textEditor = document.getElementById("bobTextEditor");
	fieldNumber = document.getElementById("bobInputNumber").value;
	currentCode = textEditor.value;
	addedCode = "";

	method = document.getElementById("formMethod").value;
	action = document.getElementById("formAction").value;
	buttonTitle = document.getElementById("submitTitleValue").value;
	formOnSubmit = document.getElementById("submitOnclick").value;

	addedCode = "<form method='" + method + "' action='" + action + "' onsubmit='" + formOnSubmit + "'>\n";
	for (var i=0; i < fieldNumber; i++) {
		try {
			name = document.getElementById("inputName" + i + "").value;
			id = document.getElementById("inputID" + i + "").value;
			placeHolder = document.getElementById("inputHolder" + i + "").value;
			defaultValue = document.getElementById("inputValue" + i + "").value;
			type = document.getElementById("typeField" + i + "").value;
			addedCode += "\t<input type='" + type + "' name='" + name + "' id='" + id + "' value='" + defaultValue + "' placeholder='" + placeHolder + "'>\n";		
		} catch(err) {

		}
	}
	addedCode += "\t<input type='submit' value='" + buttonTitle + "'>\n";
	addedCode += "</form>";

	textEditor.value = currentCode + "\n" + addedCode + "\n";

}

/**
 * bobAddInputField()
 * Add an input fied to the formbuilder
 */
function bobAddInputField(inputType) {

	var formBuilderWindow = document.getElementById("bobFormBuilder");
	var inputFieldSet = document.createElement("fieldset");
	var inputLegend = document.createElement("legend");
	
	var inputTable = document.createElement("table");

	var typeField = document.createElement("input");

	var sebIsADick = document.createElement("input");
	var sebIsADickLabel = document.createElement("label");

	var inputID = document.createElement("input");
	var inputIDLabel = document.createElement("label");

	var inputPlaceholder = document.createElement("input");
	var inputPlaceholderLabel = document.createElement("label");

	var defaultValue = document.createElement("input");
	var defaultValueLabel = document.createElement("label");

	var fieldSetBreak = document.createElement("br");
	var inputDeleteOption = document.createElement("a");
	var valueField = document.getElementById("bobInputNumber");
	var fieldNumber = valueField.value;

	inputFieldSet.id = "bobField-" + fieldNumber;
	fieldSetBreak.id = "bobBreak-" + fieldNumber;

	typeField.type = "hidden";
	typeField.id = "typeField" + fieldNumber;
	typeField.value = inputType;

	inputTable.style = "margin:auto; width:100%;";
	inputTable.cellSpacing = "10";

	sebIsADick.type = "text";
	sebIsADick.id = "inputName" + fieldNumber;
	sebIsADickLabel.setAttribute("for", "inputName" + fieldNumber);
	sebIsADickLabel.innerHTML = "Field Name";

	inputID.type = "text";
	inputID.id = "inputID" + fieldNumber;
	inputIDLabel.setAttribute("for", "inputID" + fieldNumber);
	inputIDLabel.innerHTML = "Field ID";

	inputPlaceholder.type = "text";
	inputPlaceholder.id = "inputHolder" + fieldNumber;
	inputPlaceholderLabel.setAttribute("for", "inputHolder" + fieldNumber);
	inputPlaceholderLabel.innerHTML = "Place Holder";

	defaultValue.type = "text";
	defaultValue.id = "inputValue" + fieldNumber;
	defaultValueLabel.setAttribute("for", "inputValue" + fieldNumber);
	defaultValueLabel.innerHTML = "Defualt Value";

	inputDeleteOption.href = "#";
	inputDeleteOption.setAttribute("onclick", "bobDeleteInputField('" + inputFieldSet.id + "', '" + fieldSetBreak.id + "')");
	inputDeleteOption.innerHTML = "Delete";
	inputLegend.innerHTML = inputType + " Input - ";

	inputLegend.appendChild(inputDeleteOption);
	inputFieldSet.appendChild(inputLegend);

	nameRow = inputTable.insertRow(0);
	nameRow.insertCell(0).appendChild(sebIsADickLabel);
	nameRow.insertCell(1).appendChild(sebIsADick);

	inputRow = inputTable.insertRow(1);
	inputRow.insertCell(0).appendChild(inputIDLabel);
	inputRow.insertCell(1).appendChild(inputID);
	
	placeholderRow = inputTable.insertRow(2);
	placeholderRow.insertCell(0).appendChild(inputPlaceholderLabel);
	placeholderRow.insertCell(1).appendChild(inputPlaceholder);

	defaultValueRow = inputTable.insertRow(3);
	defaultValueRow.insertCell(0).appendChild(defaultValueLabel);
	defaultValueRow.insertCell(1).appendChild(defaultValue);

	inputFieldSet.appendChild(inputTable);
	inputFieldSet.appendChild(typeField);

	formBuilderWindow.appendChild(inputFieldSet);
	formBuilderWindow.appendChild(fieldSetBreak);

	valueField.value = parseInt(valueField.value) + 1;

}

/*
 * bobDeleteInputField()
 * Delete an input field in the form builder
 */
function bobDeleteInputField(fieldID, breakID) {

	var fieldToDelete = document.getElementById(fieldID);
	var breakToDelete = document.getElementById(breakID);

	fieldToDelete.remove();
	breakToDelete.remove();

}