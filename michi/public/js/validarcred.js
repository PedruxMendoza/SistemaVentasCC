function validarcred() {
	var cliente		=	document.getElementById('cliente').selectedIndex;

	if(cliente == 0){
		document.getElementById("cliente").style.boxShadow = '0 0 15px red';
		alertify.notify('Error: No ha selecionado un Cliente!', 'error', 5, null);
		return false;
	}else{
		document.getElementById("cliente").style.boxShadow = '0 0 0px green';
	}//cierre else

	return true;

}