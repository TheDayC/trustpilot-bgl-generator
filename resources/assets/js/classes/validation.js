class Validation {
  constructor(password_length = 6, valid_class = "valid", invalid_class = "invalid"){
    this.password_length = password_length;
    this.valid_class = valid_class;
    this.invalid_class = invalid_class;
  }

  passwordLength(field_one, field_two, on_event){
    let password_length = this.password_length;
    let valid_class = this.valid_class;
    let invalid_class = this.invalid_class;

    $(field_one).on(on_event, function (e) {
      if ($(this).val().length >= password_length) {
        if ($(this).val() != $(field_two).val()) {
          $(field_two).removeClass(valid_class).addClass(invalid_class);
        } else {
          $(field_two).removeClass(invalid_class).addClass(valid_class);
        }
      }
    });
  }
  passwordConfirmLength(field_one, field_two, on_event){
    let password_length = this.password_length;
    let valid_class = this.valid_class;
    let invalid_class = this.invalid_class;

    $(field_one).on(on_event, function (e) {
      if ($(this).val().length >= password_length) {
        if ($(field_two).val() != $(this).val()) {
          $(this).removeClass(valid_class).addClass(invalid_class);
        } else {
          $(this).removeClass(invalid_class).addClass(valid_class);
        }
      }
    });
  }
}

export default Validation;