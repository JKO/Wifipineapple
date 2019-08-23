var notify_showDots;

var notify_showLoadingDots = function() {
    clearInterval(notify_showDots);
	if (!$("#notify_loadingDots").length>0) return false;
    notify_showDots = setInterval(function(){            
        var d = $("#notify_loadingDots");
        d.text().length >= 3 ? d.text('') : d.append('.');
    },300);
}

function notify_init() {
	
	$("#notify ul").idTabs();
	
	notify_refresh();
}

function notify_init_small() {
		
	notify_refresh_tile();
}

function notify_myajaxStart()
{
	$('#notify_loading').css("background-image", "url(/includes/img/throbber.gif)");

	$("#notify.refresh_text").html('<em>Loading<span id="notify_loadingDots"></span></em>'); 
	notify_showLoadingDots();
}

function notify_myajaxStop(msg)
{
	$('#notify_loading').css("background-image", "url(/includes/img/refresh.png)");

	$("#notify.refresh_text").html(msg); 
	clearInterval(notify_showDots);
}

function notify_refresh() {
	$.ajax({
		type: "GET",
		data: "status",
		beforeSend: notify_myajaxStart(),
		url: "/components/infusions/notify/includes/data.php",
		success: function(msg){
			$("#notify_large_tile").html(msg);
			notify_myajaxStop('');
		}
	});
}

function notify_refresh_tile() {
	$.ajax({
		type: "GET",
		data: "status",
		beforeSend: notify_myajaxStart(),
		url: "/components/infusions/notify/includes/data.php",
		success: function(msg){
			$("#notify_small_tile").html(msg);
			notify_myajaxStop('');
		}
	});
}

function notify_test_push() {
	$.ajax({
		type: "GET",
		data: "test_push",
		beforeSend: notify_myajaxStart(),
		url: "/components/infusions/notify/includes/actions.php",
		success: function(msg){
			notify_myajaxStop(msg);
		}
	});
}

function notify_test_email() {
	$.ajax({
		type: "GET",
		data: "test_email",
		beforeSend: notify_myajaxStart(),
		url: "/components/infusions/notify/includes/actions.php",
		success: function(msg){
			notify_myajaxStop(msg);
		}
	});
}

function notify_update_conf(data, what) {
	$.ajax({
		type: "POST",
		data: "set_conf="+what+"&"+data,
		beforeSend: notify_myajaxStart(),
		url: "/components/infusions/notify/includes/conf.php",
		success: function(msg){
			notify_myajaxStop(msg);
			
			notify_refresh();	
			notify_refresh_tile();
		}
	});
}

function notify_notificationtype_toggle(notificationtype, action) {		
	$.ajax({
		type: "POST",
		data: "notification=1&action="+action+"&notificationtype="+notificationtype,
		beforeSend: notify_myajaxStart(),
		url: "/components/infusions/notify/includes/actions.php",
		success: function(msg){
			notify_myajaxStop(msg);
			
			notify_refresh();	
			notify_refresh_tile();
		}
	});

}

function notify_reload() {
	draw_large_tile('notify', 'infusions');
	refresh_small('notify','infusions');
}

function notify_install(what, where) {
	$.ajax({
		type: "GET",
		data: "install&where=" + where +"&what=" + what,
		beforeSend: notify_myajaxStart(),
		url: "/components/infusions/notify/includes/actions.php",
		success: function(msg){
			$("#notify_output").val(msg);
			notify_myajaxStop('');
			
			notify_reload();
		}
	});
}