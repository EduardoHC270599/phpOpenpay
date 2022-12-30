OpenPay.setId('mk5dcrg2zbdmliypqgpf');
OpenPay.setApiKey('pk_c72f1977f9814ddc8ece56379a83e58e');
OpenPay.setSandboxMode(true);
OpenPay.getSandboxMode(true);
var deviceSessionId = OpenPay.deviceData.setup("processCard", "deviceIdHiddenFieldName");
console.log(deviceSessionId);
var btnPagar = document.getElementById("makeRequestCard");
let arrayDatos = [];

$('#holder_name').val('Eduardo');
$('#card_number').val('4111111111111111');
$('#expiration_year').val('24');
$('#expiration_month').val('11');
$('#cvv2-').val('123');


$('#makeRequestCard').on('click', function(event) {
    event.preventDefault();
    $("#makeRequestCard").prop( "disabled", true);
    OpenPay.token.extractFormAndCreate('processCard', success_callbak, error_callbak);
});

var success_callbak = function(response) {
  var token_id = response.data.id;
  $('#token_id').val(token_id);
  $('#processCardm').submit();
  pagar();
};

var error_callbak = function(response) {
  var desc = response.data.description != undefined ?
     response.data.description : response.message;
  alert("ERROR [" + response.status + "] " + desc);
  $("#makeRequestCard").prop("disabled", false);
};
   
function pagar(){
    console.log("Pagando...");
    var deviceIdHiddenFieldName = document.getElementById("deviceIdHiddenFieldName").value;
    var token_id = document.getElementById("token_id").value;
    arrayDatos = [token_id,deviceIdHiddenFieldName ];
    $(document).ready(function(){
      $.ajax({                    
          url: "../Model/cargos.php",
          method: "POST",
          data:{
              ban:"c1",
              arrayDatosTarjeta: JSON.stringify(arrayDatos)
          }
      }).done(function(res){
        // console.log(res);       
        if (res === 1) {
          alert("Cargo Completado");
        } else {
          alert("CARGO RECHAZADO");          
        }
        $("#makeRequestCard").prop( "disabled", false);
      });
    });
}
