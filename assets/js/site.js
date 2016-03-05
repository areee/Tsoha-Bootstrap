$(document).ready(function(){
  //alert('Hello World!');

  // Valitaan kaikki form-elementit, joihin liittyy destroy-form-luokka ja lisätään niihin kuuntelija, joka kutsuu parametrina annettua funktiota, kun lomake lähetetään
  $('form.destroy-form').on('submit', function(submit){
    // Otetaan kohdelomakkeesta data-confirm-attribuutin arvo
    var confirm_message = $(this).attr('data-confirm');
    // Pyydetään käyttäjältä vahvistusta
    if(!confirm(confirm_message)){
      // Jos käyttäjä ei anna vahvistusta, ei lähetetä lomaketta
      submit.preventDefault();
    }
  });
});

function newInput(option) {
    var volumeElement = document.createElement("input");
    var unitElement = document.createElement("input");
    var foodElement1 = document.createElement("select");
    var foodElement2 = document.createElement("option");
    var tableElement = document.createElement("table");
    var tr = document.createElement("tr");
    var td1 = document.createElement("td");
    var td2 = document.createElement("td");
    var td3 = document.createElement("td");

    tableElement.setAttribute("class", 'form-group');

    volumeElement.setAttribute("type", 'text');
    unitElement.setAttribute("type", 'text');
    foodElement1.setAttribute("class",'form-control');

    var volumeFieldName = "volume";
    var unitFieldName = "unit";
    var foodFieldName = "food";
    if (option == 0) {
        volumeFieldName += "New";
        unitFieldName += "New";
        foodFieldName += "New";
    }

    var volumeField = volumeFieldName + "[" + ++indexCountForFood + "]";
    var unitField = unitFieldName + "[" + indexCountForFood + "]";
    var foodField = foodFieldName + "[" + indexCountForFood + "]";

    volumeElement.setAttribute("name", volumeField);
    volumeElement.setAttribute("class", 'form-control');
    volumeElement.setAttribute("placeholder", 'Määrä');

    unitElement.setAttribute("name", unitField);
    unitElement.setAttribute("class", 'form-control');
    unitElement.setAttribute("placeholder", 'Yksikkö');

    foodElement1.setAttribute("name", foodField);

    foodElement2.setAttribute("value", '{{food.id}}');

    foodElement1.appendChild(foodElement2);

    td1.appendChild(volumeElement);
    td2.appendChild(unitElement);
    td3.appendChild(foodElement1);

    tr.appendChild(td1);
    tr.appendChild(td2);
    tr.appendChild(td3);
    tableElement.appendChild(tr);


    var foodElement = document.getElementById("newIngredient");

    foodElement.appendChild(tableElement);
}

// $(function() {
//         var scntDiv = $('#p_scents');
//         var i = $('#p_scents p').size() + 1;
//
//         $('#addScnt').live('click', function() {
//                 $('<p><label for="p_scnts"><input type="text" id="p_scnt" size="20" name="p_scnt_' + i +'" value="" placeholder="Input Value" /></label> <a href="#" id="remScnt">Remove</a></p>').appendTo(scntDiv);
//                 i++;
//                 return false;
//         });
//
//         $('#remScnt').live('click', function() {
//                 if( i > 2 ) {
//                         $(this).parents('p').remove();
//                         i--;
//                 }
//                 return false;
//         });
// });
