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
    // var foodElement1 = document.createElement("select");
    // var foodElement2 = document.createElement("option");
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


    var foodElement = document.getElementById("newFood");

    foodElement.appendChild(tableElement);
}

// $(function() {
//         var foodDiv = $('#food_section');
//         var i = $('#food_section select').size()-1 + 1;
//
//         $('#addFood').live('click', function() {
//                 $('<select class="form-control" name="food['+i+']">{% for food in foods %}<option value="{{food.id}}">{{food.name}}</option>{% endfor %}</select>').appendTo(foodDiv);
//                 i++;
//                 return false;
//         });
// });
