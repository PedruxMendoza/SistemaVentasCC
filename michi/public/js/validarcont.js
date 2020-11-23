function validarcont() {
	var modo		=	document.getElementById('modo').selectedIndex;

	if(modo == 0){
		document.getElementById("modo").style.boxShadow = '0 0 15px red';
		return false;
	}else{
		document.getElementById("modo").style.boxShadow = '0 0 0px green';
	}//cierre else

	return true;	

}