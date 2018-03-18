// Handle our button click
$(document).on('click', '#change-roles', function (e) {
  // Perform no action if the button is disabled.
  if ($(this).hasClass('disabled')) { e.preventDefault(); return; }

  let data = {};

  // On click show the loader
  changeLoader();

  // Fetch user ids to have new role assignments
  data["user_ids"] = getUserIds();
  data["role_id"] = getRoleId();

  // If our payload ids exist, send them to an api endpoint to be handled
  if (Object.keys(data).length) {
    changeRoles(data, "/admin/change-roles");
  }
});

// Handle our checkbox interaction
$(document).on('change', '.change-role', function () {
  validateSubmission();
});

// Handle select field interaction
$(document).on('change', '#roles', function () {
  validateSubmission();
});

// Validate the potential submission.
function validateSubmission(){
  $checkbox_length = $('.change-role:checked').length;
  $role_selection = $('#roles').val();

  if ($checkbox_length >= 1 && $role_selection !== "") {
    $('#change-roles').addClass('secondary').removeClass('disabled');
  } else if (!$('#change-roles').hasClass('disabled')){
    $('#change-roles').removeClass('secondary').addClass('disabled');
  }
}

function getUserIds() {
  let user_ids = [];
  $('.change-role:checked').each(function (index, value) {
    user_ids[index] = parseInt($(this).val());
  });

  return user_ids;
}

function getRoleId(){
  let role_id = $('#roles').val();
  
  return role_id;
}

function changeRoles(data, endpoint_url) {
  $.ajax({
    url: endpoint_url,
    type: "POST",
    data: data,
    dataType: "json",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function (data) {
      // Success! Show feedback to user.
      showNotification(data.status, data.message);

      // On response, remove loader.
      changeLoader();
    },
    error: function (data) {
      var response = JSON.parse(data.responseText);

      // Failure... Show feedback to user.
      showNotification(data.status, response.message);

      // On response, remove loader.
      changeLoader();
    }
  });
}

function changeLoader() {
  $('#loader').toggleClass('active');
  changeButton();
}

function changeButton() {
  $('#change-roles').toggleClass('secondary').toggleClass('disabled');
}

function showNotification(status, msg) {
  var card_css = "red";
  if (status === "success") {
    card_css = "green";
  }
  var message = '<div class="row"><div class="container">';
  message += '<div class="card alert ' + card_css + ' lighten-5">';
  message += '<div class="card-content ' + card_css + '-text">';
  message += '<p>' + msg + '</p>';
  message += '</div>';
  message += '<button type="button" class="close ' + card_css + '-text" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
  message += '</div></div></div>';

  $('#app .card.alert').each(function () {
    $(this).slideUp(300, function () {
      $(this).remove();
    });
  });
  $('#app').prepend(message);
}