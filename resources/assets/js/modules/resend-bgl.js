// Handle our button click
$(document).on('click', '#resend-bgl', function(e){
  // Perform no action if the button is disabled.
  if ($(this).hasClass('disabled')) { e.preventDefault(); return; }

  let payload_ids = [];
  
  // On click show the loader
  changeLoader();
  
  // Loop through each checked checkbox and add to array 
  payload_ids = getPayloadIds(payload_ids);

  // If our payload ids exist, send them to an api endpoint to be handled
  if(payload_ids){
    sendPayloadIds(payload_ids, "/payload/send");
  }
});

// Handle our checkbox interaction
$(document).on('change', '.resend-bgl', function () {
  if ($('.resend-bgl:checked').length === 0 || $('.resend-bgl:checked').length === 1){
    changeButton();
  }
});

function getPayloadIds(payload_ids){
  $('.resend-bgl:checked').each(function (index, value) {
    payload_ids[index] = parseInt($(this).val());
  });

  return payload_ids;
}

function sendPayloadIds(payload_ids, endpoint_url){
  
  $.ajax({
    url: endpoint_url,
    type: "POST",
    data: { "payload_ids": payload_ids },
    dataType: "json",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(data){      
      // Success! Show feedback to user.
      showNotification(data.status, data.message);

      // On response, remove loader.
      changeLoader();
    },
    error: function(data){
      var response = JSON.parse(data.responseText);

      // Failure... Show feedback to user.
      showNotification(data.status, response.message);

      // On response, remove loader.
      changeLoader();
    }
  });
}

function changeLoader(){
  $('#resend-loader').toggleClass('active');
  changeButton();
}

function changeButton(){
  $('#resend-bgl').toggleClass('secondary').toggleClass('disabled');
}

function showNotification(status, msg){
  var card_css = "red";
  if(status === "success"){
    card_css = "green";
  }
  var message = '<div class="row"><div class="container">';
  message += '<div class="card alert ' + card_css + ' lighten-5">';
  message += '<div class="card-content ' + card_css + '-text">';
  message += '<p>' + msg + '</p>';
  message += '</div>';
  message += '<button type="button" class="close ' + card_css + '-text" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
  message += '</div></div></div>';

  $('#app .card.alert').each(function(){
    $(this).slideUp(300, function(){
      $(this).remove();
    });
  });
  $('#app').prepend(message);
}