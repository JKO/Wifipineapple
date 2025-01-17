var getInfusion_auto_refresh;
var getInfusion_showDots;

var getInfusion_showLoadingDots = function() 
{
    clearInterval(getInfusion_showDots);
    if (!$("#getInfusion_loadingDots").length>0) return false;
    getInfusion_showDots = setInterval(function(){            
        var d = $("#getInfusion_loadingDots");
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

function getInfusion_myajaxStart()
{
    if(getInfusion_auto_refresh == null)
    {
        $("#getInfusion.refresh_text").html('<em>Loading<span id="getInfusion_loadingDots"></span></em>'); 
        getInfusion_showLoadingDots(); $("#getInfusion.loading").show();
    }
}


function getInfusion_myajaxStop(msg)
{
    if(getInfusion_auto_refresh == null)
    {
        $("#getInfusion.refresh_text").html(msg); 
        clearInterval(getInfusion_showDots); $("#getInfusion.loading").hide();
    }
}


function getInfusion_init() 
{
    getInfusion_refresh();
    
        
    $("#getInfusion_auto_refresh").toggleClick(function() {
            $("#getInfusion_auto_refresh").html('<font color="lime">On</font>');
            $('#auto_time').attr('disabled', 'disabled');
            
            getInfusion_auto_refresh = setInterval(
            function ()
            {
                getInfusion_refresh();
            },
            $("#auto_time").val());
        }, function() {
            $("#getInfusion_auto_refresh").html('<font color="red">Off</font>');
            $('#auto_time').removeAttr('disabled');
                            
                    clearInterval(getInfusion_auto_refresh);
            getInfusion_auto_refresh = null;
    });
}

function getInfusion_eraseData() 
{
    // hide both divs.
    $("#comments").hide();
    $("#content_info").hide();

    $.ajax({
        type: "GET",
        data: "action=erase_data",
        beforeSend: getInfusion_myajaxStart(),
        url: "/components/infusions/get/includes/actions.php",
        success: function(msg){
            $("#content").html("<table>"+msg+"</table>");
            getInfusion_myajaxStop('');
        }
    });
}

function getInfusion_refresh() {
        // hide both divs.
        $("#comments").hide();
        $("#content_info").hide();

    $.ajax({
        type: "GET",
        data: "action=get_all",
        beforeSend: getInfusion_myajaxStart(),
        url: "/components/infusions/get/includes/actions.php",
        success: function(msg){
            $("#content").html("<table>"+msg+"</table>");
            getInfusion_myajaxStop('');
        }
    });
}


function getInfusion_getinfo(data) {
        // hide the INFO div.
        $("#comments").hide();
        
        // Show the div we require for this functionality
        $("#content_info").show();
    $.ajax({
        type: "GET",
        data: "action=get_info&mac="+data,
        beforeSend: getInfusion_myajaxStart(),
        url: "/components/infusions/get/includes/actions.php",
        success: function(msg){
            $("#content_info").html(msg);
            getInfusion_myajaxStop('');
        }
    });
}

function getInfusion_editcomments(data) 
{
        // hide the INFO div.
        $("#content_info").hide();
        
        // Show the div we require for this functionality
        $("#comments").show();
        $.ajax({
        type: "GET",
        data: "action=edit_comments&mac="+data,
        beforeSend: getInfusion_myajaxStart(),
        url: "/components/infusions/get/includes/actions.php",
        success: function(msg){
                    $("#comments").html(msg);
            getInfusion_myajaxStop('');
        }
    });
}


function getInfusion_viewcomments(data) 
{
        // hide the INFO div.
        $("#content_info").hide();
        
        // Show the div we require for this functionality
        $("#comments").show();
        $.ajax({
        type: "GET",
        data: "action=view_comments&mac="+data,
        beforeSend: getInfusion_myajaxStart(),
        url: "/components/infusions/get/includes/actions.php",
        success: function(msg){
                    $("#comments").html(msg);
            getInfusion_myajaxStop('');
        }
    });
}

function savecomments()
{
        var file = $('input#save_file').val();
        var content = $('textarea#content').val();
        content = content.trim();
    //alert("action=save_comments&save_file="+file+"&content="+content);
    $("#comments").html("Saving... filename [" + file + "] content: [" + content + "]");

    $.ajax({
        type: "POST",
        data: "action=save_comments&save_file="+file+"&content="+content,
        beforeSend: getInfusion_myajaxStart(),
        url: "/components/infusions/get/includes/actions.php",
        success: function(msg){
                    $("#comments").html(msg);
            getInfusion_myajaxStop('');
        },
                error: function(msg) {
                        $("comments").html("Error: " + msg.error);
                }
    });
}

function getInfusion_savecomments() 
{
        var file = $('input#save_file').val();
        var content = $('textarea#content').val();

    //alert("filename1 [" + file + "] content1: [" + content + "]");
    
/*
        $.ajax({
        type: "POST",
        data: "action=save_comments&save_file="+file+"&content="+content,
        beforeSend: getInfusion_myajaxStart(),
        url: "/components/infusions/get/includes/actions.php",
                error: function (msg) {
                        //alert("error: [" + JSON.stringify(msg) + "]");
                        alert("error: " + msg.error);
                },
        success: function(msg){
                       // alert("Success");
                    $("#comments").html(msg);
            getInfusion_myajaxStop('');
        }
    });
*/

 $("comments").html("Test");
}

function getInfusion_uninstall()
{
        $.ajax({
        type: "GET",
        data: "action=uninstall",
        beforeSend: getInfusion_myajaxStart(),
        url: "/components/infusions/get/includes/actions.php",
        success: function(msg){
                    $("#infoGetter").html(msg);
            getInfusion_myajaxStop('');
        },
                error: function(msg) {
                        $("comments").html("Error: " + msg.error);
                }
    });
}

function getInfusion_install()
{
        $.ajax({
        type: "GET",
        data: "action=install",
        beforeSend: getInfusion_myajaxStart(),
        url: "/components/infusions/get/includes/actions.php",
        success: function(msg){
                    $("#infoGetter").html(msg);
            getInfusion_myajaxStop('');
        },
                error: function(msg) {
                        $("comments").html("Error: " + msg.error);
                }
    });
}

function getInfusion_unredirect()
{
        $.ajax({
        type: "GET",
        data: "action=unredirect",
        beforeSend: getInfusion_myajaxStart(),
        url: "/components/infusions/get/includes/actions.php",
        success: function(msg){
                    $("#hiddenIframe").html(msg);
            getInfusion_myajaxStop('');
        },
                error: function(msg) {
                        $("comments").html("Error: " + msg.error);
                }
    });
}

function getInfusion_redirect()
{
        $.ajax({
        type: "GET",
        data: "action=redirect",
        beforeSend: getInfusion_myajaxStart(),
        url: "/components/infusions/get/includes/actions.php",
        success: function(msg){
                    $("#hiddenIframe").html(msg);
            getInfusion_myajaxStop('');
        },
                error: function(msg) {
                        $("comments").html("Error: " + msg.error);
                }
    });
}

function getInfusion_outSD()
{
        $.ajax({
        type: "GET",
        data: "action=outSD",
        beforeSend: getInfusion_myajaxStart(),
        url: "/components/infusions/get/includes/actions.php",
        success: function(msg){
                    $("#databaseonSD").html(msg);
            getInfusion_myajaxStop('');
        },
                error: function(msg) {
                        $("comments").html("Error: " + msg.error);
                }
    });
}

function getInfusion_inSD()
{
        $.ajax({
        type: "GET",
        data: "action=inSD",
        beforeSend: getInfusion_myajaxStart(),
        url: "/components/infusions/get/includes/actions.php",
        success: function(msg){
                    $("#databaseonSD").html(msg);
            getInfusion_myajaxStop('');
        },
                error: function(msg) {
                        $("comments").html("Error: " + msg.error);
                }
    });
}
