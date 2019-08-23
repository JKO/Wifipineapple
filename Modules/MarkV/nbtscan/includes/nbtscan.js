function installNBTScan(tile, storage) {
	popup('<br /><center>Dependencies are being installed. This box will automatically go away.<br /><br /><img style="height: 2em; width: 2em;" src="/includes/img/throbber.gif"</center>');

	setTimeout(function() {$.get('/components/infusions/nbtscan/includes/requests.php?install=' + storage + '', function(data){
		notify(data);
		nbtscanlRefreshTile(tile);
		close_popup();
	});} , 2000);

}

function handleNbtscanCommand() {
	var cmdValue = parseInt(document.getElementById("nbtscanCommands").value);

	switch(cmdValue) {
		case 0:
			displayNbtScanHistory('small');
			break;
		case 1:
			nbtscanShowRouting();
			break;
		case 2:
			var win = window.open("https://forums.hak5.org/index.php?/topic/33836-support-nbtscan/", "_blank");
			win.focus();
			break;
		default:
			popup("Seb are you a wizard?!");
			break;
	}

}

function nbtscanlRefreshTile(tile) {
  if (tile == "large") { // the large tile made the call so re-draw it
    draw_large_tile("nbtscan", "infusions");
  }

  // small tile will always need to be refreshed so refresh it
  refresh_small("nbtscan", "user"); // <-- Im a dumb shit *laughs at self in the future*
}


function preformNbtScan(tile) {

	// Show the spinny pineapple
	document.getElementById("spinny").style.display = "block";


	if (tile == "large")
		$("#startScan").AJAXifyForm(refreshNbtScanResults); // Put the results in the large tile
	else
		$("#startScan").AJAXifyForm(popup); // Put the results in a popup window

	// Hide the spinny pineapple
	document.getElementById("spinny").style.display = "none";
}

function refreshNbtScanResults(content) {
	document.getElementById("results").innerHTML = content;
}

function displayNbtScanHistory(tile) {
	if (tile == "large") {
		$.get('/components/infusions/nbtscan/includes/requests.php?history=' + tile + '', function(data){
			$('#history').html(data);
		});
	} else {
		$.get('/components/infusions/nbtscan/includes/requests.php?history=' + tile + '', function(data){
			popup(data);
		});
	}
}

function viewSingleNbtScanResult(scanName) {
	$.get('/components/infusions/nbtscan/includes/requests.php?result=' + scanName + '', function(data){
		popup(data);
	});
}

function deleteSingleNbtScanResult(tile, scanName) {
	if (tile == "large") {
		$.get('/components/infusions/nbtscan/includes/requests.php?delete=' + scanName + '&tile=' + tile + '', function(data){
			$('#history').html(data);
		});
	} else {
		$.get('/components/infusions/nbtscan/includes/requests.php?delete=' + scanName + '&tile=' + tile + '', function(data){
			popup(data);
		});
	}
}

function clearScanResults(id) {
	document.getElementById(id).innerHTML = "";
}

function nbtscanShowRouting() {
	$.get('/components/infusions/nbtscan/includes/requests.php?routing', function(data){
                popup(data);
        });
}
