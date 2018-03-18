class Repeater{
  constructor(){}

  addRow(container_id, field_data, row_class, before){
      // Generate row html
      let row_html = this.createRowHtml(container_id, row_class, field_data);

      // Prepend the created html
      $(row_html).insertBefore(container_id + " " + before).slideDown(300);

      // Reinitialize material select objects incase we added some.
      $('select').material_select();
  }

  createRowHtml(container_id, row_class, field_data = []){
    let row_html = "";
    if(field_data.length){
      var row_count_next = $(container_id + " ." + row_class).length;
      row_html += '<div class="' + row_class + ' row no-gutter"><div class="remove"><i class="material-icons">close</i></div>';
      field_data.forEach((element, index) => {
        
        if (index % 3 === 0 && index !== 0) { row_html += '</div>'; }
        if (index % 3 === 0 || index === 0) { row_html += '<div class="input-collection col s12 no-gutter">'; }
        row_html += '<div class="input-field col s12 m4">';

        switch(element.type){
          case "select":
            row_html += '<select name="payload[' + row_count_next + '][' + element.name + ']">';
            row_html += '<option value="">Choose vertical...</option>';
              for(var key in element.data){
                row_html += '<option value="' + key + '">' + element.data[key] + '</option>';
              };
            row_html += '</select>';
          break;
          default:
            row_html += '<input type="' + element.type + '" class="validate" placeholder="' + element.placeholder + '" name="payload[' + row_count_next + '][' + element.name + ']" required>';
        }

        row_html += '</div>';
        
      });
      row_html += '</div>';
    }
    return row_html;
  }


}

export default Repeater;