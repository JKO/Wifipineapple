var base64encdecInfusion_auto_refresh;
var base64encdecInfusion_showDots;

var base64encdecInfusion_showLoadingDots = function() 
{
    clearInterval(base64encdecInfusion_showDots);
    if (!$("#base64encdecInfusion_loadingDots").length>0) return false;
    base64encdecInfusion_showDots = setInterval(function(){            
        var d = $("#base64encdecInfusion_loadingDots");
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

function base64encdecInfusion_myajaxStart()
{
    if(base64encdecInfusion_auto_refresh == null)
    {
        $("#base64encdecInfusion.refresh_text").html('<em>Loading<span id="base64encdecInfusion_loadingDots"></span></em>'); 
        base64encdecInfusion_showLoadingDots(); $("#base64encdecInfusion.loading").show();
    }
}


function base64encdecInfusion_myajaxStop(msg)
{
    if(base64encdecInfusion_auto_refresh == null)
    {
        $("#base64encdecInfusion.refresh_text").html(msg); 
        clearInterval(base64encdecInfusion_showDots); $("#base64encdecInfusion.loading").hide();
    }
}


function base64encdecInfusion_init() 
{
    base64encdecInfusion_refresh();
    
    $("#base64encdecInfusion_auto_refresh").toggleClick(
        function() {
            $('#auto_time').attr('disabled', 'disabled');
            
            base64encdecInfusion_auto_refresh = setInterval(
            function ()
            {
                base64encdecInfusion_refresh();
            },
            $("#auto_time").val());
        }, 
        function() {
            $('#auto_time').removeAttr('disabled');
                            
            clearInterval(base64encdecInfusion_auto_refresh);
            base64encdecInfusion_auto_refresh = null;
        }
    );
}



function base64encdecInfusion_refresh() {
    //alert("do nothing");
}


function process()
{
    var content = $('textarea#content').val();
    var operation = $('select#operation').val();
    content = content.trim();
    operation = operation.trim();
    
    $.ajax({
        type: "GET",
        data: "action=process&content="+content+"&operation="+operation,
        beforeSend: base64encdecInfusion_myajaxStart(),
        url: "/components/infusions/base64encdec/includes/actions.php",
        success: function(msg){
            var myhtml = "<center></br>Output:</br>"+msg+"</center>";
            $("#result").html(myhtml);
            base64encdecInfusion_myajaxStop('');
        },
        error: function(msg){
            $("result").html("Error: " + msg.error);
            //base64encdecInfusion_myajaxStop('');
        }
    });
}

