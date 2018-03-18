import Nav from '../classes/nav';

$(document).ready(function () {
  var dropdown_element = ".dropdown-button";
  var dropdown_params = { belowOrigin: true, hover: false };

  var Navigation = new Nav();
  Navigation.dropdown(dropdown_element, dropdown_params);
});