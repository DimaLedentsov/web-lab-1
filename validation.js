// Валидация данных
// https://monsterlessons.com/project/lessons/validaciya-formy-v-javascript  ---- вдохновлялся этим

var form= document.querySelector('.validate_form');
var validatedButton = document.querySelector('.validate_button');
var yCoordinate = document.querySelector(".y");
var rCoordinate = document.querySelector(".R");
var fields = document.querySelectorAll('.field');




//функция для генерации ошибок
var generateTip = function (text, color) { 
    var tip = document.createElement('div');
    tip.className = 'tip';
    tip.style.color = color;
    tip.innerHTML = text;
    return tip;
}


//функция для очистки подсказок при повторной валидации 
var removeValidation = function () {
    var tips = form.querySelectorAll('.tip')      
    for (var i = 0; i < tips.length; i++) {
        tips[i].remove()
    }
  }


//функция для проверки наличия значений в полях
var checkFieldsPresence = function () {
    for (var i = 0; i < fields.length; i++) {
      if (!fields[i].value) {
        console.log('field is blank', fields[i])
        var error = generateTip('The field cannot be empty >:(','red')
        fields[i].parentElement.insertBefore(error, fields[i])
        return false;
      }        
    }
    return true;
}

// проверка значения в поле на попадание в заданный диапазон
var validateField = function(coordinate,min,max){
  if(coordinate.value){
      if((coordinate.value<=min || coordinate.value>=max || isNaN(coordinate.value))){
          var error = generateTip('Wrong data =(','red')
          coordinate.parentElement.insertBefore(error, coordinate)              
          return false;
      }
      else{
          var correct = generateTip('Correct data =)','green');
          coordinate.parentElement.insertBefore(correct, coordinate)              
          return true;              
      }
  }
  return false
}


// фунция для повторной проверки, что поля заполнены верно, чтобы передать их php скрипту
function isReady(){
  return validateField(yCoordinate,-5,5) && validateField(rCoordinate,2,5) && checkFieldsPresence();
}  




$("#inpform").on("submit", function(event){
  event.preventDefault(); 

    console.log("Циферки упали на проверочку =)" );
    console.log('y: ', yCoordinate.value);
    console.log('R: ', rCoordinate.value);
    removeValidation();

    if(!isReady()){
      console.log("post-запрос отменяется. давай по новой")
      return
    }
    console.log("начинается отправка данных")
    console.log($(this).serialize());
    $.ajax({
      url: 'script.php',
      method: "POST",
      data: $(this).serialize() + "&timezone=" + new Date().getTimezoneOffset(),
      dataType: "html",

      headers: { "Accept": "application/json",
      "Access-Control-Allow-Origin": "*",
      "X-Requested-With": "XMLHttpRequest",
      "Access-Control-Allow-Methods" : "GET,POST,PUT,DELETE,OPTIONS",
      "Access-Control-Allow-Headers": "Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"},
    
      success: function(data){
        console.log(data);
        $(".validate_button").attr("disabled", false);	
        $("#result_table").append(data);
      },
      error: function(error){
        console.log(error);
        $(".validate_button").attr("disabled", false);	
      },
    })
});
