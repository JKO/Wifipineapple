var monitor_auto_refresh;
var monitor_showDots;

var monitor_showLoadingDots = function() {
    clearInterval(monitor_showDots);
	if (!$("#monitor_loadingDots").length>0) return false;
    monitor_showDots = setInterval(function(){            
        var d = $("#monitor_loadingDots");
        d.text().length >= 3 ? d.text('') : d.append('.');
    },300);
}

$.fn.toggleClick=function() {
	var functions=arguments, iteration=0
		return this.click(function(){
			functions[iteration].apply(this,arguments)
			iteration= (iteration+1) %functions.length
		})
}

function monitor_myajaxStart()
{
	$('#monitor_loading').css("background-image", "url(/includes/img/throbber.gif)");
	
	if(monitor_auto_refresh == null)
	{
		$("#monitor.refresh_text").html('<em>Loading<span id="monitor_loadingDots"></span></em>'); 
		monitor_showLoadingDots();
	}
}

function monitor_myajaxStop(msg)
{
	$('#monitor_loading').css("background-image", "url(/includes/img/refresh.png)");
	
	if(monitor_auto_refresh == null)
	{
		$("#monitor.refresh_text").html(msg); 
		clearInterval(monitor_showDots);
	}
}

function monitor_init_small() {
	
	monitor_refresh_tile();
	
}

function monitor_init() {

	monitor_refresh();
		
    $("#monitor_auto_refresh").toggleClick(function() {
			$("#monitor_auto_refresh").html('<font color="lime">On</font>');
			$('#auto_time').attr('disabled', 'disabled');
			
			monitor_auto_refresh = setInterval(
			function ()
			{
				monitor_refresh();
			},
			$("#auto_time").val());
		}, function() {
			$("#monitor_auto_refresh").html('<font color="red">Off</font>');
			$('#auto_time').removeAttr('disabled');
				
            clearInterval(monitor_auto_refresh);
			monitor_auto_refresh = null;
		});	
}

function monitor_refresh() {
	$.ajax({
		type: "POST",
		beforeSend: monitor_myajaxStart(),
		url: "/components/infusions/monitor/includes/data.php?large",
		success: function(msg){
			$("#monitor_content").html(msg);
			monitor_myajaxStop('');
		}
	});
}

function monitor_force() {
	$.ajax({
		type: "GET",
		data: "force",
		beforeSend: monitor_myajaxStart(),
		url: "/components/infusions/monitor/includes/actions.php",
		success: function(msg){
			monitor_myajaxStop('');
			monitor_refresh();
		}
	});
}

function monitor_daemon_toggle(action) {
	$.get('/components/infusions/monitor/includes/actions.php?daemon', {action: action});
	
	if(action == 'enable'){
		$('#vnstatdi_link').html('<strong>Uninstall</strong>');
		$('#vnstatdi_status').html('<font color="lime"><strong>&#10004;</strong></font>');
		$('#vnstatdi_link').attr("href", "javascript:monitor_daemon_toggle('disable');");
	}
	else{
		$('#vnstatdi_link').html('<strong>Install</strong>');
		$('#vnstatdi_status').html('<font color="red"><strong>&#10008;</strong></font>');
		$('#vnstatdi_link').attr("href", "javascript:monitor_daemon_toggle('enable');");
	}
}

function sd_toggle(action) {
	$.get('/components/infusions/monitor/includes/actions.php?sd', {action: action});
	
	if(action == 'enable'){
		$('#db_link').html('<strong>Uninstall from SD</strong>');
		$('#db_status').html('<font color="lime"><strong>persistent</strong></font>');
		$('#db_link').attr("href", "javascript:sd_toggle('disable');");
	}
	else{
		$('#db_link').html('<strong>Install on SD</strong>');
		$('#db_status').html('<font color="red"><strong>not persistent</strong></font>');
		$('#db_link').attr("href", "javascript:sd_toggle('enable');");
	}
}

function reset() {
	$.ajax({
		type: "GET",
		data: "reset",
		beforeSend: monitor_myajaxStart(),
		url: "/components/infusions/monitor/includes/actions.php",
		success: function(msg){
			monitor_myajaxStop('');
			monitor_refresh();
		}
	});
}

function monitor_refresh_tile() {
	$.ajax({
		type: "POST",
		beforeSend: monitor_myajaxStart(),
		url: "/components/infusions/monitor/includes/data.php?small",
		success: function(msg){
			$("#monitor_content_small").html(msg);
			monitor_myajaxStop('');
		}
	});
}