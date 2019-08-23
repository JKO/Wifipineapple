var p0f_auto_refresh;
var p0f_showDots;

var p0f_showLoadingDots = function() {
    clearInterval(p0f_showDots);
	if (!$("#p0f_loadingDots").length>0) return false;
    p0f_showDots = setInterval(function(){            
        var d = $("#p0f_loadingDots");
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

function p0f_myajaxStart()
{
	$('#p0f_loading').css("background-image", "url(/includes/img/throbber.gif)");
	
	if(p0f_auto_refresh == null)
	{
		$("#p0f.refresh_text").html('<em>Loading<span id="p0f_loadingDots"></span></em>'); 
		p0f_showLoadingDots();
	}
}

function p0f_myajaxStop(msg)
{
	$('#p0f_loading').css("background-image", "url(/includes/img/refresh.png)");
	
	if(p0f_auto_refresh == null)
	{
		$("#p0f.refresh_text").html(msg); 
		clearInterval(p0f_showDots);
	}
}

function p0f_init_small() {
	
	p0f_refresh_tile();
}

function p0f_init() {

	p0f_refresh();
	p0f_refresh_history();
	p0f_refresh_custom();
	p0f_refresh_config();
	
	$("#p0f ul").idTabs();
				
    $("#p0f_auto_refresh").toggleClick(function() {
			$("#p0f_auto_refresh").html('<font color="lime">On</font>');
			$('#auto_time').attr('disabled', 'disabled');
			
			p0f_auto_refresh = setInterval(
			function ()
			{
				p0f_refresh();
			},
			$("#auto_time").val());
		}, function() {
			$("#p0f_auto_refresh").html('<font color="red">Off</font>');
			$('#auto_time').removeAttr('disabled');
				
            clearInterval(p0f_auto_refresh);
			p0f_auto_refresh = null;
		});	
}

function p0f_toggle(action) {
	$.get('/components/infusions/p0f/includes/actions.php?p0f&'+action, {int: $("#interface").val()} , function() { refresh_small('p0f','infusions'); });

	if(action == 'stop') {
		$("#p0f_link").html('<strong>Start</strong>');
		$("#p0f_status").html('<font color="red"><strong>&#10008;</strong></font>');
		$("#p0f_link").attr("href", "javascript:p0f_toggle('start');");
		$('#p0f_output').val('p0f has been stopped...');
		
		$('#interface').removeAttr('disabled');	
				
		p0f_refresh_history();
	}
	else {
		$("#p0f_link").html('<strong>Stop</strong>');
		$("#p0f_status").html('<font color="lime"><strong>&#10004;</strong></font>');
		$("#p0f_link").attr("href", "javascript:p0f_toggle('stop');");
		$('#p0f_output').val('p0f is running...');
		
		$('#interface').attr('disabled', 'disabled');
				
		p0f_refresh_history();
	}
}

function p0f_toggle_small(action) {
	$.get('/components/infusions/p0f/includes/actions.php?p0f&'+action, {int: $("#interface").val()});

	if(action == 'stop') {
		$("#p0f_link_small").html('<strong>Start</strong>');
		$("#p0f_small").html('<font color="red"><strong>&#10008;</strong></font>');
		$("#p0f_link_small").attr("href", "javascript:p0f_toggle_small('start');");
		$('#p0f_output_small').val('p0f has been stopped...');
		
		$('#p0f_interface_small').removeAttr('disabled');
	}
	else {
		$("#p0f_link_small").html('<strong>Stop</strong>');
		$("#p0f_small").html('<font color="lime"><strong>&#10004;</strong></font>');
		$("#p0f_link_small").attr("href", "javascript:p0f_toggle_small('stop');");
		$('#p0f_output_small').val('p0f is running...');
		
		$('#p0f_interface_small').attr('disabled', 'disabled');
	}
}

function p0f_refresh() {
	$.ajax({
		type: "GET",
		data: "lastlog&filter="+$("#filter").val(),
		beforeSend: p0f_myajaxStart(),
		url: "/components/infusions/p0f/includes/data.php",
		success: function(msg){
			$("#p0f_output").val(msg).scrollTop($("#p0f_output")[0].scrollHeight - $("#p0f_output").height());
			
			p0f_myajaxStop('');
		}
	});
}

function p0f_refresh_history() {
	$.ajax({
		type: "GET",
		data: "history",
		beforeSend: p0f_myajaxStart(),
		url: "/components/infusions/p0f/includes/data.php",
		success: function(msg){
			$("#content_history").html(msg);
			p0f_myajaxStop('');
		}
	});
}

function p0f_refresh_custom() {
	$.ajax({
		type: "GET",
		data: "custom",
		beforeSend: p0f_myajaxStart(),
		url: "/components/infusions/p0f/includes/data.php",
		success: function(msg){
			$("#content_custom").html(msg);
			p0f_myajaxStop('');
		}
	});
}

function p0f_load_file(what, which) {
    $.get('/components/infusions/p0f/includes/actions.php?load', {file: which, what: what}, function(data){
	    $('.popup_content').html(data);
	    $('.popup').css('visibility', 'visible');
    });
}

function p0f_delete_file(what, which) {
	$.ajax({
		type: "GET",
		data: "delete&file=" + which + "&" + what,
		beforeSend: p0f_myajaxStart(),
		url: "/components/infusions/p0f/includes/actions.php",
		success: function(msg){
			$("#content_history").html(msg);
			p0f_myajaxStop('');
			p0f_refresh_history();
			p0f_refresh_custom();
		}
	});
}

function p0f_boot_toggle(action) {
	$.get('/components/infusions/p0f/includes/actions.php?boot', {action: action});
	
	if(action == 'disable') {
		$("#boot_link").html('<strong>Enable</strong>');
		$("#boot_status").html('<font color="red"><strong>&#10008;</strong></font>');
		$("#boot_link").attr("href", "javascript:p0f_boot_toggle('enable');");
	}
	else {
		$("#boot_link").html('<strong>Disable</strong>');
		$("#boot_status").html('<font color="lime"><strong>&#10004;</strong></font>');
		$("#boot_link").attr("href", "javascript:p0f_boot_toggle('disable');");
	}
}

function p0f_execute_custom_script(cmd) {
	$.ajax({
		type: "GET",
		data: "execute&cmd="+cmd,
		beforeSend: p0f_myajaxStart(),
		url: "/components/infusions/p0f/includes/actions.php",
		success: function(msg){
			$("#p0f_output").val(msg);
			$('#p0f_output').val('Custom script is running...');
			
			p0f_myajaxStop('');
			
			p0f_refresh_history();
			p0f_refresh_custom();
		}
	});
}

function p0f_refresh_config() {
	$.ajax({
		type: "GET",
		data: "get_conf",
		beforeSend: p0f_myajaxStart(),
		url: "/components/infusions/p0f/includes/conf.php",
		success: function(msg){
			$("#content_conf").html(msg);
			p0f_myajaxStop('');
		}
	});
}

function p0f_set_config() {
	$.ajax({
		type: "POST",
		data: "set_conf=1&commands="+$.base64.encode($("#command_File").val()),
		beforeSend: p0f_myajaxStart(),
		url: "/components/infusions/p0f/includes/conf.php",
		success: function(msg){
			p0f_myajaxStop(msg);
		}
	});
}

function p0f_reload() {
	draw_large_tile('p0f', 'infusions');
	refresh_small('p0f','infusions');
}

function p0f_install(where) {
	$.ajax({
		type: "GET",
		data: "install&where=" + where,
		beforeSend: p0f_myajaxStart(),
		url: "/components/infusions/p0f/includes/actions.php",
		success: function(msg){
			$("#p0f_output").val(msg);
			p0f_myajaxStop('');
			
			p0f_reload();
		}
	});
}

function p0f_refresh_tile() {
	$.ajax({
		type: "GET",
		data: "lastlog",
		beforeSend: p0f_myajaxStart(),
		url: "/components/infusions/p0f/includes/data.php",
		success: function(msg){
			p0f_myajaxStop('');
			$("#p0f_output_small").val(msg).scrollTop($("#p0f_output_small")[0].scrollHeight - $("#p0f_output_small").height());
		}
	});
}