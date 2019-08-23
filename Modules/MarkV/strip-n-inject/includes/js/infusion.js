var codeinject_auto_refresh;
var codeinject_showDots;
var codeinject_small_showDots;

var codeinject_showLoadingDots = function() {
    clearInterval(codeinject_showDots);
  if (!$("#codeinject_loadingDots").length>0) return false;
    codeinject_showDots = setInterval(function(){            
        var d = $("#codeinject_loadingDots");
        d.text().length >= 3 ? d.text('') : d.append('.');
    },300);
}

var codeinject_small_showLoadingDots = function() {
    clearInterval(codeinject_small_showDots);
  if (!$("#codeinject_small_loadingDots").length>0) return false;
    codeinject_small_showDots = setInterval(function(){            
        var d = $("#codeinject_small_loadingDots");
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

function codeinject_myajaxStart()
{
  if(codeinject_auto_refresh == null)
  {
    $("#codeinject.refresh_text").html('<em>Loading<span id="codeinject_loadingDots"></span></em>'); 
    codeinject_showLoadingDots();
  
    $("#codeinject_small.refresh_text").html('<em>Loading<span id="codeinject_small_loadingDots"></span></em>'); 
    codeinject_small_showLoadingDots();
  }
}

function codeinject_myajaxStop(msg)
{
  if(codeinject_auto_refresh == null)
  {
    $("#codeinject.refresh_text").html(msg); 
    clearInterval(codeinject_showDots);
  
    $("#codeinject_small.refresh_text").html(msg); 
    clearInterval(codeinject_small_showDots);
  }
}

function codeinject_init_small() {
  
  codeinject_refresh_tile();
}

function codeinject_init() {

  codeinject_refresh();  
  $("#tabs ul").idTabs();
        
    $("#codeinject_auto_refresh").toggleClick(function() {
      $("#codeinject_auto_refresh").html('<font color="lime">On</font>');
      $('#auto_time').attr('disabled', 'disabled');
      
      codeinject_auto_refresh = setInterval(
      function ()
      {
        codeinject_refresh();
      },
      $("#auto_time").val());
    }, function() {
      $("#codeinject_auto_refresh").html('<font color="red">Off</font>');
      $('#auto_time').removeAttr('disabled');
        
            clearInterval(codeinject_auto_refresh);
      codeinject_auto_refresh = null;
    });  
}

function codeinject_toggle(action) {
  $.get('/components/infusions/strip-n-inject/includes/actions.php?codeinject&'+action, function() { refresh_small('codeinject','infusions'); });

  if(action == 'stop') {
    $("#codeinject_link").html('<strong>Start</strong>');
    $("#codeinject_status").html('<font color="red"><strong>disabled</strong></font>');
    $("#codeinject_link").attr("href", "javascript:codeinject_toggle('start');");
    $('codeinject_output').val('code injection is stopped...');  
  } else {
    $("#codeinject_link").html('<strong>Stop</strong>');
    $("#codeinject_status").html('<font color="lime"><strong>enabled</strong></font>');
    $("#codeinject_link").attr("href", "javascript:codeinject_toggle('stop');");
    $('codeinject_output').val('codeinject is running...');
        
  }
}

function codeinject_toggle_small(action) {
  $.get('/components/infusions/strip-n-inject/includes/actions.php?codeinject&'+action);

  if(action == 'stop') {
    $("#codeinject_link_small").html('<strong>Start</strong>');
    $("#codeinject_small").html('<font color="red"><strong>disabled</strong></font>');
    $("#codeinject_link_small").attr("href", "javascript:codeinject_toggle('start');");
    $('codeinject_output_small').val('code injection is stopped...');  
  } else {
    $("#codeinject_link_small").html('<strong>Stop</strong>');
    $("#codeinject_small").html('<font color="lime"><strong>enabled</strong></font>');
    $("#codeinject_link_small").attr("href", "javascript:codeinject_toggle('stop');");
    $('codeinject_output_small').val('code injection is running...');
  }
}

function codeinject_install(action) {
  //$.get('/components/infusions/strip-n-inject/includes/actions.php?codeinject', {action: action});
  $.get('/components/infusions/strip-n-inject/includes/actions.php?codeinject&'+action);

   if(action == 'install'){
     $('#code_inject').html('<strong>Uninstall</strong>');
     $('#codeinject_install_link').attr("href", "javascript:codeinject_install('uninstall');");
     $('#codeinject_install_status').html('<font color="lime"><strong>installed</strong></font>');
   } else {
     $('#codeinject_install_link').html('<strong>Install</strong>');
     $('#codeinject_install_status').html('<font color="red"><strong>not installed</strong></font>');
     $('#codeinject_install_link').attr("href", "javascript:codeinject_install('install');");
   }
}


function codeinject_refresh() {
  $.ajax({
    type: "GET",
    data: "proxylog",
    beforeSend: codeinject_myajaxStart(),
    url: "/components/infusions/strip-n-inject/includes/data.php",
    success: function(msg){
      $("#status_output").val(msg).scrollTop($("#status_output")[0].scrollHeight - $("#status_output").height());
      
      codeinject_myajaxStop('');
    }
  });
}

function codeinject_refresh_history() {
  $.ajax({
    type: "GET",
    data: "history",
    beforeSend: codeinject_myajaxStart(),
    url: "/components/infusions/strip-n-inject/includes/data.php",
    success: function(msg){
      $("#codeinject_content_history").html(msg);
      codeinject_myajaxStop('');
    }
  });
}

function codeinject_showTab()
{
  $("#Output").show(); 
  $("#History").hide();
  $("#History_link").removeClass("selected"); 
  $("#Output_link").addClass("selected");
}

function codeinject_load_file(what) {
  $.ajax({
    type: "GET",
    data: "load&file=" + what,
    beforeSend: codeinject_myajaxStart(),
    url: "/components/infusions/strip-n-inject/includes/actions.php",
    success: function(msg){
      $("#codeinject_output").val(msg);
      codeinject_showTab();    
      codeinject_myajaxStop('');
    }
  });
}

function codeinject_delete_file(what, which) {
  $.ajax({
    type: "GET",
    data: "delete&file=" + which + "&" + what,
    beforeSend: codeinject_myajaxStart(),
    url: "/components/infusions/strip-n-inject/includes/actions.php",
    success: function(msg){
      $("#codeinject_content_history").html(msg);
      codeinject_myajaxStop('');
      codeinject_refresh_history();
    }
  });
}

function codeinject_update_code(data, what) {
  $.ajax({
    type: "POST",
    data: "set_code="+what+"&newdata="+data,
    beforeSend: codeinject_myajaxStart(),
    url: "/components/infusions/strip-n-inject/includes/conf.php",
    success: function(msg){
      codeinject_myajaxStop(msg);
    }
  });
}

function codeinject_update_ip(data, what) {
  $.ajax({
    type: "POST",
    data: "set_ip="+what+"&newdata="+data,
    beforeSend: codeinject_myajaxStart(),
    url: "/components/infusions/strip-n-inject/includes/conf.php",
    success: function(msg){
      codeinject_myajaxStop(msg);
    }
  });
}

function codeinject_refresh_tile() {
  $.ajax({
    type: "GET",
    data: "proxylog",
    beforeSend: codeinject_myajaxStart(),
    url: "/components/infusions/strip-n-inject/includes/data.php",
    success: function(msg){
      codeinject_myajaxStop('');
      $("#log_output_small").val(msg).scrollTop($("#log_output_small")[0].scrollHeight - $("#log_output_small").height());
    }
  });
}
