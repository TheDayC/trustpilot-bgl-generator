$(document).on('click', '.alert .close', function(){
  $(this).closest('.alert').stop().slideUp(300, function(){
    $(this).remove();
  });
});