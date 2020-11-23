function validar(){

    var pass1   = document.getElementById('pass1').value;
    var pass2   = document.getElementById('pass2').value;

    //Validar campo obligatorio
    if(pass1.length == 0){ 
        document.getElementById("pass1").style.boxShadow = '0 0 15px red'; 
        document.getElementById("pass1").placeholder = "Este campo es obligatorio";
        
        return false;
    }else{
        document.getElementById("pass1").style.boxShadow = '0 0 0px green';
    }   

    if(pass2.length == 0){ 
        document.getElementById("pass2").style.boxShadow = '0 0 15px red'; 
        document.getElementById("pass2").placeholder = "Este campo es obligatorio";
        
        return false;
    }else{
        document.getElementById("pass2").style.boxShadow = '0 0 0px green';
    }

    return true;
}