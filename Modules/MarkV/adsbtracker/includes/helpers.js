$(document).ready(function () {

  $('#tabs li a:not(:first)').addClass('inactive');
  selectTabContent($('#tabs li a:first').attr('id'));
  $('#tabs li a').click(function () {
    var t = $(this).attr('id');
    if ($(this).hasClass('inactive')) {
      $('#tabs li a').addClass('inactive');
      $(this).removeClass('inactive');
      selectTabContent(t);
    }else{
      selectTabContent(t);
    }
  });

});

function selectTabContent(id){
  $.ajaxSetup({async:false});
  $.get("/components/infusions/adsbtracker/includes/content/"+id+".php", function(data){
    $(".tabContainer").html(data);
  });
  $.ajaxSetup({async:true});
}

function updateMessage(data){
  $("#adsbtracker_message").html(data);
}
