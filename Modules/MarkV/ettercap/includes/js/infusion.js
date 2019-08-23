var ettercap_auto_refresh;
var ettercap_showDots;

var ettercap_showLoadingDots = function() {
    clearInterval(ettercap_showDots);

	if (!$("#ettercap_loadingDots").length>0) return false;
    ettercap_showDots = setInterval(function(){            
        var d = $("#ettercap_loadingDots");
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

function ettercap_myajaxStart()
{
	$('#ettercap_loading').css("background-image", "url(/includes/img/throbber.gif)");
	
	if(ettercap_auto_refresh == null)
	{
		$("#ettercap.refresh_text").html('<em>Loading<span id="ettercap_loadingDots"></span></em>'); 
		ettercap_showLoadingDots();
	}
}

function ettercap_myajaxStop(msg)
{
	$('#ettercap_loading').css("background-image", "url(/includes/img/refresh.png)");
	
	if(ettercap_auto_refresh == null)
	{
		$("#ettercap.refresh_text").html(msg); 
		clearInterval(ettercap_showDots);
	}
}

function ettercap_init_small() {
	$('#ettercap_interface_small').change(function() { ettercap_update_small() });
	ettercap_refresh_tile();
}

function ettercap_init() {
	
	ettercap_refresh();
	ettercap_refresh_history();
	
	$("#ettercap ul").idTabs();
	$("#ettercap2 ul").idTabs();
	
	$('#interface').change(function() { ettercap_update() });
	$('#visualization_format').change(function() { ettercap_update() });
	$('#mitm_options').change(function() { ettercap_update_mitm_param(); ettercap_update() });
	$('#mitm_options_param').change(function() { ettercap_update() });
	$('#proto_options').change(function() { ettercap_update() });
	$(':checkbox').click(function() { ettercap_update() });
	$('#filter').change(function() { ettercap_update() });
	
	$('#filter_editor').change(function() { ettercap_show_filter() });
	
	$('#target_1').keyup(function() { ettercap_update() });
	$('#target_2').keyup(function() { ettercap_update() });
	
	$("#ettercap_auto_refresh").toggleClick(function() {
			$("#ettercap_auto_refresh").html('<font color="lime">On</font>');
			$('#auto_time').attr('disabled', 'disabled');
			
			ettercap_auto_refresh = setInterval(
			function ()
			{
				ettercap_refresh();
			},
			$("#auto_time").val());
		}, function() {
			$("#ettercap_auto_refresh").html('<font color="red">Off</font>');
			$('#auto_time').removeAttr('disabled');
				
            clearInterval(ettercap_auto_refresh);
			ettercap_auto_refresh = null;
		});
}

function ettercap_refresh() {
	$.ajax({
		type: "GET",
		data: "lastlog",
		beforeSend: ettercap_myajaxStart(),
		url: "/components/infusions/ettercap/includes/data.php",
		success: function(msg){
			ettercap_myajaxStop('');
			$("#ettercap_output").val(msg).scrollTop($("#ettercap_output")[0].scrollHeight - $("#ettercap_output").height());
		}
	});
}

function ettercap_refresh_history() {
	$.ajax({
		type: "GET",
		data: "history",
		beforeSend: ettercap_myajaxStart(),
		url: "/components/infusions/ettercap/includes/data.php",
		success: function(msg){
			$("#content").html(msg);
			ettercap_myajaxStop('');
		}
	});
}

function ettercap_toggle(action) {	
	$.get('/components/infusions/ettercap/includes/actions.php?ettercap&'+action, {action: action} , function() { refresh_small('ettercap','infusions'); });
	
	if(action == 'start') {
		ettercap_start();
		$("#launch").html('<font color="red"><strong>Stop</strong></font>');
		$("#launch").attr("href", "javascript:ettercap_toggle('stop');");
	}
	else {
		ettercap_cancel();
		$("#launch").html('<font color="lime"><strong>Start</strong></font>');
		$("#launch").attr("href", "javascript:ettercap_toggle('start');");
	}
}

function ettercap_toggle_small(action) {	
	$.get('/components/infusions/ettercap/includes/actions.php?ettercap&'+action, {action: action});
	
	if(action == 'start') {
		ettercap_start_small();
		$("#launch_small").html('<font color="red"><strong>Stop</strong></font>');
		$("#launch_small").attr("href", "javascript:ettercap_toggle_small('stop');");
	}
	else {
		ettercap_cancel_small();
		$("#launch_small").html('<font color="lime"><strong>Start</strong></font>');
		$("#launch_small").attr("href", "javascript:ettercap_toggle_small('start');");
	}
}

function ettercap_update() {
	$('#command').val("ettercap " + ettercap_interface() + ettercap_options() + ettercap_proto() + ettercap_visualization() + ettercap_filter() + ettercap_mitm() + ettercap_target_1() + ettercap_target_2());
}

function ettercap_update_small() {
	$('#ettercap_command_small').val("ettercap " + ettercap_interface_small());
}

function ettercap_update_mitm_param() {
	
	if($("#mitm_options").val() != "--")
	{
		$('#mitm_options_param').find('option').remove();
		
		$('#mitm_options_param').append($("<option></option>").text("--"));
		
		if($("#mitm_options option:selected").text() == "arp")
		{
			$('#mitm_options_param').append($("<option></option>").attr("value","oneway").text("oneway"));
			$('#mitm_options_param').append($("<option></option>").attr("value","remote").text("remote"));
			$('#mitm_options_param').append($("<option></option>").attr("value","oneway,remote").text("oneway,remote"));
		}
		else if($("#mitm_options option:selected").text() == "port")
		{ 
			$('#mitm_options_param').append($("<option></option>").attr("value","remote").text("remote"));
			$('#mitm_options_param').append($("<option></option>").attr("value","tree").text("tree"));
			$('#mitm_options_param').append($("<option></option>").attr("value","remote,tree").text("remote,tree"));
		}
		else
		{
			$('#mitm_options_param').find('option').remove();
			$('#mitm_options_param').append($("<option></option>").text("--"));
		}
	}
	else
	{
		$('#mitm_options_param').find('option').remove();
		$('#mitm_options_param').append($("<option></option>").text("--"));
	}
}

function ettercap_start() {
	$.ajax({
		type: "GET",
		data: "launch&int="+$('#interface').find(":selected").text()+"&cmd="+$('#command').val(),
		beforeSend: ettercap_myajaxStart(),
		url: "/components/infusions/ettercap/includes/actions.php",
		success: function(msg){
			$("#ettercap_output").val(msg);
			$('#ettercap_output').val('Ettercap is running...');
			ettercap_myajaxStop('');
			
			ettercap_refresh_history();
			
			refresh_small('ettercap','infusions');
		}
	});
}

function ettercap_start_small() {
	$.ajax({
		type: "GET",
		data: "launch&int="+$('#ettercap_interface_small').find(":selected").text()+"&cmd="+$('#ettercap_command_small').val(),
		beforeSend: ettercap_myajaxStart(),
		url: "/components/infusions/ettercap/includes/actions.php",
		success: function(msg){
			$("#ettercap_output_small").val(msg);
			$('#ettercap_output_small').val('Ettercap is running...');
			ettercap_myajaxStop('');
			
			ettercap_refresh_history();
		}
	});
}

function ettercap_cancel() {
	$.ajax({
		type: "GET",
		data: "cancel",
		beforeSend: ettercap_myajaxStart(),
		url: "/components/infusions/ettercap/includes/actions.php",
		success: function(msg){
			$("#ettercap_output").val(msg);
			$('#ettercap_output').val('Ettercap has been stopped...');
			ettercap_myajaxStop('');
			
			ettercap_refresh_history();
			
			refresh_small('ettercap','infusions');
		}
	});
}

function ettercap_cancel_small() {
	$.ajax({
		type: "GET",
		data: "cancel",
		beforeSend: ettercap_myajaxStart(),
		url: "/components/infusions/ettercap/includes/actions.php",
		success: function(msg){
			$("#ettercap_output_small").val(msg);
			$('#ettercap_output_small').val('Ettercap has been stopped...');
			ettercap_myajaxStop('');
		}
	});
}

function ettercap_delete_file(what) {
	$.ajax({
		type: "GET",
		data: "delete&file=" + what,
		beforeSend: ettercap_myajaxStart(),
		url: "/components/infusions/ettercap/includes/actions.php",
		success: function(msg){
			$("#content").html(msg);
			ettercap_refresh_history();
			ettercap_myajaxStop('');
		}
	});
}

function ettercap_load_file(which) {
    $.get('/components/infusions/ettercap/includes/actions.php?load', {file: which}, function(data){
	    $('.popup_content').html(data);
	    $('.popup').css('visibility', 'visible');
    });
}

function ettercap_target_1() {
	var return_value = "";
		
	if($("#target_1").val() != "--")
		return_value = $("#target_1").val() + " ";
	
	return return_value;
}

function ettercap_target_2() {
	var return_value = "";
		
	if($("#target_2").val() != "--")
		return_value = $("#target_2").val() + " ";
	
	return return_value;
}

function ettercap_options(which) {
	var return_value = "";

    $('input:checked').each(function() {
      return_value += $(this).val() + " ";
    });
	
	return return_value;
}

function ettercap_interface() {
    var return_value = "";
	
	if($("#interface").val() != "--")
		return_value = $("#interface").val() + " ";
	
	return return_value;
}

function ettercap_interface_small() {
    var return_value = "";
	
	if($("#ettercap_interface_small").val() != "--")
		return_value = $("#ettercap_interface_small").val() + " ";
	
	return return_value;
}

function ettercap_visualization() {
    var return_value = "";
	
	if($("#visualization_format").val() != "--")
		return_value = $("#visualization_format").val() + " ";
	
	return return_value;
}

function ettercap_proto() {
    var return_value = "";
	
	if($("#proto_options").val() != "--")
		return_value = $("#proto_options").val() + " ";
	
	return return_value;
}

function ettercap_mitm() {
    var return_value = "";
	
	if($("#mitm_options").val() != "--")
		if($("#mitm_options_param").val() != "--")
			return_value = $("#mitm_options").val() + ":" +$("#mitm_options_param").val() + " ";
		else
			return_value = $("#mitm_options").val() + " ";
	
	return return_value;
}

function ettercap_filter() {
    var return_value = "";
	
	if($("#filter").val() != "--")
		return_value = $("#filter").val() + " ";
	
	return return_value;
}

function ettercap_show_filter() {
	
	if($("#filter_editor").val() != "--")
	{
		$('#filter_name').val($("#filter_editor").val());
		
		$.ajax({
			type: "GET",
			data: "show_filter&which=" + $("#filter_editor").val(),
			beforeSend: ettercap_myajaxStart(),
			url: "/components/infusions/ettercap/includes/filters.php",
			success: function(msg){
				$("#filter_content").val(msg);
				ettercap_myajaxStop('');
			}
		});
	}
	else
	{
		$('#filter_name').val("");
		$('#filter_content').val("");
	}
}

function ettercap_delete_filter() {	
	if($("#filter_editor").val() != "--")
	{
		$.ajax({
			type: "GET",
			data: "delete_filter&which=" + $("#filter_editor").val(),
			beforeSend: ettercap_myajaxStart(),
			url: "/components/infusions/ettercap/includes/filters.php",
			success: function(msg){
				$("#filter_editor option:selected").remove();
				$('#filter_name').val("");
				$('#filter_content').val("");
				
				ettercap_myajaxStop(msg);
				
				ettercap_refresh_filter();
			}
		});
	}
}

function ettercap_save_filter() {	
	if($("#filter_content").val() != "" && $("#filter_editor").val() != "--" && $("#filter_name").val() != "")
	{
		$.ajax({
			type: "POST",
			data: "save_filter=1&which="+$("#filter_editor").val()+"&newdata="+escape($("#filter_content").val()),
			beforeSend: ettercap_myajaxStart(),
			url: "/components/infusions/ettercap/includes/filters.php",
			success: function(msg){
				ettercap_myajaxStop(msg);
			}
		});
	}
}

function ettercap_new_filter() {	
	if($("#filter_name").val() != "" && $("#filter_name").val() != $("#filter_editor").val())
	{
		$.ajax({
			type: "POST",
			data: "new_filter=1&which="+$("#filter_name").val()+"&newdata="+escape($("#filter_content").val()),
			beforeSend: ettercap_myajaxStart(),
			url: "/components/infusions/ettercap/includes/filters.php",
			success: function(msg){
				$('#filter_editor').append($("<option></option>").attr("value",$("#filter_name").val()).text($("#filter_name").val()+".filter"));
				$('#filter_editor').val($("#filter_name").val());
				ettercap_myajaxStop(msg);
			}
		});
	}
}

function ettercap_compile_filter() {	
	if($("#filter_editor").val() != "--")
	{
		$.ajax({
			type: "GET",
			data: "compile_filter=1&which="+$("#filter_editor").val(),
			beforeSend: ettercap_myajaxStart(),
			url: "/components/infusions/ettercap/includes/filters.php",
			success: function(msg){
				$("#ettercap_output").val(msg);
				ettercap_myajaxStop(msg);
				ettercap_refresh_filter();
			}
		});
	}
}

function ettercap_refresh_filter() {
	
	var previous_val = $('#filter option:selected').text();
	
	$.ajax({
		type: "GET",
		data: "filter_list",
		beforeSend: ettercap_myajaxStart(),
		url: "/components/infusions/ettercap/includes/filters.php",
		success: function(msg){
			$('#filter').html(msg);
			$('#filter').val(previous_val);
			ettercap_update();
			
			ettercap_myajaxStop('');
		}
	});	
}

function ettercap_reload() {
	draw_large_tile('ettercap', 'infusions');
	refresh_small('ettercap','infusions');
}

function ettercap_install() {
	$.ajax({
		type: "GET",
		data: "install_dep",
		beforeSend: ettercap_myajaxStart(),
		url: "/components/infusions/ettercap/includes/actions.php",
		cache: false,
		success: function(msg){
		}
	});

    var loop=self.setInterval(
	function ()
	{
	    $.ajax({
			url: '/components/infusions/ettercap/includes/status.php',
			cache: false,
			success: function(msg){
				if(msg != 'working')
				{
					ettercap_reload();
					clearInterval(loop);
				}
			}
		});
	}
	,5000);
}

function ettercap_refresh_tile() {
	$.ajax({
		type: "GET",
		data: "lastlog",
		beforeSend: ettercap_myajaxStart(),
		url: "/components/infusions/ettercap/includes/data.php",
		success: function(msg){
			ettercap_myajaxStop('');
			$("#ettercap_output_small").val(msg).scrollTop($("#ettercap_output_small")[0].scrollHeight - $("#ettercap_output_small").height());
		}
	});
}