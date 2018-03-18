import Validation from '../classes/validation';
var checkPassVal = new Validation(6, "valid", "invalid");

// Perform validation on change password form
if($('#change-pass-form').length){
  // Validate on new password field focus
  checkPassVal.passwordLength("#new-password", "#new-password-confirmation", "focusout");
  
  // Validate on new password confirmation field keyup
  checkPassVal.passwordConfirmLength("#new-password-confirmation", "#new-password", "keyup");
}

// Perform validation on register form
if ($('#register-form').length) {
  // Validate on new password field focus
  checkPassVal.passwordLength("#password", "#password-confirm", "focusout");

  // Validate on new password confirmation field keyup
  checkPassVal.passwordConfirmLength("#password-confirm", "#password", "keyup");
}