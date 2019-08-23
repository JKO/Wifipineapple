/* Load the next step */
function nextStep(newContent) {
  document.getElementById("wizard").innerHTML = newContent;
}

function refreshHTMLPreview(newContent) {
  document.getElementById("htmlView").value = newContent;
}

function refreshBackEndPreview(newContent) {
  document.getElementById("phpView").value = newContent;
}

function addText() {

  //var
  var headingSize = document.getElementById("headingSize").value;
  var newHeading = "";
  var paragraphText = document.getElementById("paragraphText").value;
  var newParagraph = "";
  var currentCode = document.getElementById("portal_code").value;
  //var

  if (headingSize != "0") {
    newHeading = "<h" + headingSize + ">" + document.getElementById("headingText").value + "</h" + headingSize + ">";
  }

  if (paragraphText != "") {
    newParagraph = "<p>" + paragraphText + "</p>";
  }
  
  document.getElementById("portal_code").value = currentCode + newHeading + "\n";
  currentCode = document.getElementById("portal_code").value;
  document.getElementById("portal_code").value = currentCode + newParagraph + "\n";
  close_popup();

}

function addLink() {

  //var

  //var

}

function unlock(id) {
  if (document.getElementById(id).disabled) {
  	document.getElementById(id).disabled = false;
  	document.getElementById("unlock_" + id).innerHTML = "Lock";
  } else {
  	document.getElementById(id).disabled = true;
  	document.getElementById("unlock_" + id).innerHTML = "Unlock";
  }
}