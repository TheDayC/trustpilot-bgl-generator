import Repeater from '../classes/repeater';
var PayloadRepeater = new Repeater();

if($("#payload-repeater").length){
  var vertical = $('#payload-repeater').data('vertical');
  var study = $('#payload-repeater').data('study');

  // Create field data for repeater.
  let field_data = [
    { "name":"uid", "placeholder":"ID", "type":"text" },
    { "name":"name", "placeholder":"Name", "type":"text" },
    { "name":"email", "placeholder":"Email", "type":"email" }
  ];

  // Setup add / remove row capabilities
  $("#payload-repeater .button-row .add-row").on('click', function (e) {
    e.preventDefault();
    PayloadRepeater.addRow("#payload-repeater", field_data, "payload-row", ".button-row");
  });

  $(document).on('click', "#payload-repeater .payload-row .remove", function (e) {
    e.preventDefault();
    $(this).closest(".payload-row").slideUp(300, function () {
      $(this).remove();
    });
  });
}