/* Refresh tile for evilportal */
function evilportalRefreshTile(tile) {
  if (tile == "large") { // the large tile made the call so re-draw it
    draw_large_tile("evilportal", "infusions");
  }

  // small tile will always need to be refreshed so refresh it
  refresh_small("evilportal", "user"); // <-- Im a dumb shit *laughs at self in the future*
}

/* submit the form to install the depends and show a nice message */
function evilportalInstallDepends(id, tile) {
  popup('<br /><center>Dependencies are being installed. This box will automatically go away.<br /><br /><img style="height: 2em; width: 2em;" src="/includes/img/throbber.gif"</center>');
  setTimeout(function(){$(id).AJAXifyForm(notify); evilportalRefreshTile(tile); close_popup();}, 2000);
  return false;
}

/* submit the form to configure EP and show a nice message */
function evilportalConfigure(id, tile) {
  popup('<br /><center>Configuration changes are being made. This box will automatically go away.<br /><br /><img style="height: 2em; width: 2em;" src="/includes/img/throbber.gif"</center>');
  setTimeout(function(){ $(id).AJAXifyForm(notify); }, 2000);
  setTimeout(function(){ evilportalRefreshTile(tile); close_popup(); }, 4000);
  return false;
}

/* submit a form to popup */
function evilportalAjaxPopup(id) {
  $(id).AJAXifyForm(popup);
  return false;
}

/* submit a form to notify */
function evilportalAjaxNotify(id) {
  $(id).AJAXifyForm(notify);
  return false;
}

/* submit a form to notify and refresh */
function evilportalAjaxNotifyAndRefresh(id, tile) {
  document.getElementById("spinny").style.display = "block";
  setTimeout(function(){ $(id).AJAXifyForm(notify); evilportalRefreshTile(tile); }, 2000);
  return false;
}

function evilportalRefreshLibrary(data) {
  document.getElementById("evilportalLibrary").innerHTML = data;
}

/* submit a control for ep */
function evilportalSubmitControl(id, tile) {

  $(id).AJAXifyForm(notify);
  refresh_small("evilportal", "user");

  if (tile == "large")
    $("#refresh_ep_controls").AJAXifyForm(evilportalRefreshControls);
}

/* refresh the evil portal controls */
function evilportalRefreshControls(content) {
  document.getElementById("evilportalStatus").innerHTML = content;
}

function evilportalShowLog(id) {
  if (document.getElementById(id).style.display == "none") {
    document.getElementById(id).style.display = "block";
    document.getElementById(id + "show").innerHTML = "Hide Log";
  } else {
    document.getElementById(id).style.display = "none";
    document.getElementById(id + "show").innerHTML = "Show Log";
  }
}