function postToBar(id) {
  $(id).AJAXifyForm(datalockerStatus);
  refreshTracker();
  return false;
}

function postToPop(id) {
  $(id).AJAXifyForm(datalockerStatus);
  refreshTracker();
  return false;
}

function datalockerStatus(message) {
  document.getElementById("datalockerStatus").innerHTML = message;
}

function refreshTracker() {
  $.get('/components/infusions/datalocker/functions.php?filetracker', function(data) {
    $("#fileTrackerFiles").html(data);
  });
}