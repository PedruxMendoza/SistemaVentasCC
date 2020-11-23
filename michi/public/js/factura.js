      $('select[name="pagos"]').change(function(event){
        var selected = $(this).find('option:selected');
        var value = selected.attr("value");
        var name=  $(this).attr("name");
        var selector = '[for-field="'+name+'"]';
        $('.accordion-body'+selector).addClass('collapse');
        var selectorForValue = selector+'[for-value="'+value+'"]';
        var selectedPanel = $('.accordion-body'+ selectorForValue  );
        selectedPanel.removeClass('collapse');
      })

      $('select[name="modo"]').change(function(event){
        var selected = $(this).find('option:selected');
        var value = selected.attr("value");
        var name=  $(this).attr("name");
        var selector = '[for-field="'+name+'"]';
        $('.accordion-body'+selector).addClass('collapse');
        var selectorForValue = selector+'[for-value="'+value+'"]';
        var selectedPanel = $('.accordion-body'+ selectorForValue  );
        selectedPanel.removeClass('collapse');
      })

      $("#oculto").hide();

      $("#pagos").change(function(){
       if($(this).val()==2)
       {    
         $("#oculto").show();
       }
       else
       {
        $("#oculto").hide();
      }      
    });       

      $('#tipocard option:not(:selected)').attr('disabled',true);

      function aleatorio(minimo,maximo){
        return Math.round(Math.random() * (maximo - minimo) + minimo);
      }

      function obtenerCodigo(minimo, maximo) {
        var numb = aleatorio(minimo,maximo);
        $('#authnumber').val(numb);  
      }

      function obtenerRespuesta() {
        var answers = ['Activo', 'Inactivo'];
        var answer = answers[Math.floor(Math.random()*answers.length)];
        $('#statuscard').val(answer);
      }

      function efectuarTarjeta(texto) {
        if (texto == 'Inactivo') {
          $('#btnFacturar').prop('disabled', true);
        }else{
          $('#btnFacturar').prop('disabled', false);
        }
      }

      $("#tarjeta").keyup(function(){
        var input = $(this).val();
        /*Expresiones Regulares de Tarjetas de Creditos*/
        var mastercard = new RegExp("^(?:5[1-5][0-9]{2}|2720|27[01][0-9]|2[3-6][0-9]{2}|22[3-9][0-9]|222[1-9])[ /._\-|,]*[0-9]{4}[ /._\-|,]*[0-9]{4}[ /._\-|,]*[0-9]{4}");
        var visa = new RegExp("^4[0-9]{3}[ /._\-|,]*[0-9]{4}[ /._\-|,]*[0-9]{4}[ /._\-|,]*[0-9](?:[0-9]{3})?");
        var american = new RegExp("^3[47][0-9]{2}[ /._\-|,]*[0-9]{6}[ /._\-|,]*[0-9]{5}");
        var discover = new RegExp("^6(?:011|5[0-9]{2})[ /._\-|,]*[0-9]{4}[ /._\-|,]*[0-9]{4}[ /._\-|,]*[0-9]{4}");
        /*Arreglo donde iran la informacion de las tarjetas de credito*/
        var arrayCreditCard  = ["Visa", "Mastercard", "American Express", "Discover"];
        var arrayRegex  = [visa, mastercard, american, discover];
        for (var i = 0; i < arrayCreditCard.length; i++) {
          if(input.match(arrayRegex[i])) {
            var card = arrayCreditCard[i];
            $("#tipocard > option").each(function() {
              if (this.text == card) {
                $('[name=tipocard] option').filter(function() {
                  return ($(this).text() == card);
                }).prop('selected', true); 

                $('[name=typecard] option').filter(function() {
                  return ($(this).text() == card);
                }).prop('selected', true); 
              }             
            });
            setTimeout('obtenerCodigo(100000, 999999)', 2000)
            setTimeout('obtenerRespuesta()', 4000)
            setTimeout('efectuarTarjeta($("#statuscard").val())', 4000)
          }  

        }
      });

      function validarfact(){

        var cliente     =   document.getElementById('selecli').selectedIndex;
        var tipopago    =   document.getElementById('pagos').selectedIndex;        
        var modopago    =   document.getElementById('modo').selectedIndex;
        var total       =   document.getElementById('totals').value;
        var credtotal   =   document.getElementById('total').value;

        if(cliente == 0){
          document.getElementById("selecli").style.boxShadow = '0 0 15px red';
          alertify.notify('Error: No ha selecionado un cliente!', 'error', 5, null);
          return false;
        }else{
          document.getElementById("selecli").style.boxShadow = '0 0 0px green';
        }

        if(tipopago == 0){
          document.getElementById("pagos").style.boxShadow = '0 0 15px red';
          alertify.notify('Error: No ha selecionado un Tipo de Pago!', 'error', 5, null);
          return false;
        }else{
          document.getElementById("pagos").style.boxShadow = '0 0 0px green';
        }

        if (tipopago == 2) {
          if(modopago == 0){
            document.getElementById("modo").style.boxShadow = '0 0 15px red';
            alertify.notify('Error: No ha selecionado un Modo de Pago!', 'error', 5, null);
            return false;
          }else{
            document.getElementById("modo").style.boxShadow = '0 0 0px green';
          }
          
          if(isNaN(total) || total.length == 0){
            document.getElementById("totals").style.boxShadow = '0 0 15px red';
            alertify.notify('Error: No ha ingresado un producto!', 'error', 5, null);
            return false;
          }else{
            document.getElementById("totals").style.boxShadow = '0 0 0px green';

          }

          if(total == 0){
            document.getElementById("totals").style.boxShadow = '0 0 15px red';
            alertify.notify('Error: No ha ingresado producto!', 'error', 5, null);
            return false;
          }else{
            document.getElementById("totals").style.boxShadow = '0 0 0px green';
          }          
        }else{
          if(isNaN(credtotal) || credtotal.length == 0){
            document.getElementById("total").style.boxShadow = '0 0 15px red';
            alertify.notify('Error: Cliente no tiene credito!', 'error', 5, null);
            return false;
          }else{
            document.getElementById("total").style.boxShadow = '0 0 0px green';

          }

          if(credtotal <= 0){
            document.getElementById("total").style.boxShadow = '0 0 15px red';
            alertify.notify('Error: El Credito no debe ser negativo!', 'error', 5, null);
            return false;
          }else{
            document.getElementById("total").style.boxShadow = '0 0 0px green';
          }

          if(isNaN(total) || total.length == 0){
            document.getElementById("totals").style.boxShadow = '0 0 15px red';
            alertify.notify('Error: No ha ingresado un producto!', 'error', 5, null);
            return false;
          }else{
            document.getElementById("totals").style.boxShadow = '0 0 0px green';

          }

          if(total == 0){
            document.getElementById("totals").style.boxShadow = '0 0 15px red';
            alertify.notify('Error: No ha ingresado producto!', 'error', 5, null);
            return false;
          }else{
            document.getElementById("totals").style.boxShadow = '0 0 0px green';
          }          
        }

        return true;

      }