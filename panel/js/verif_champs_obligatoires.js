function verif_nombre(form) {

	if (form.check) {
		if (!form.check.value) 
		{ 	document.getElementById('verifcheck').innerHTML='Veuillez renseigner le nombre de check';
			document.getElementById('verifcheck').style.display='block'; return false;}
		if (isNaN(parseInt(form.check.value)))
		{ 	document.getElementById('verifcheck').innerHTML='Format invalide'; 
			document.getElementById('verifcheck').style.display='block'; return false;}
		if (parseInt(form.check.value) > parseInt(form.check_max.value))
		{ 	document.getElementById('verifcheck').innerHTML='Le nombre de check doit &ecirc;tre inf&eacute;rieur ou &eacute;gal &agrave; ' + form.check_max.value; 
			document.getElementById('verifcheck').style.display='block'; return false;}
	}
	if (form.radio) {
		if (!form.radio.value) 
		{ 	document.getElementById('verifradio').innerHTML='Veuillez renseigner le nombre de radio';
			document.getElementById('verifradio').style.display='block'; return false;}
		if (isNaN(parseInt(form.radio.value)))
		{ 	document.getElementById('verifradio').innerHTML='Format invalide'; 
			document.getElementById('verifradio').style.display='block'; return false;}
		if (parseInt(form.radio.value) > parseInt(form.radio_max.value))
		{ 	document.getElementById('verifradio').innerHTML='Le nombre de radio doit &ecirc;tre inf&eacute;rieur ou &eacute;gal &agrave; ' + form.radio_max.value; 
			document.getElementById('verifradio').style.display='block'; return false;}
	}
	if (form.text) {
		if (!form.text.value) 
		{ 	document.getElementById('veriftext').innerHTML='Veuillez renseigner le nombre de text';
			document.getElementById('veriftext').style.display='block'; return false;}
		if (isNaN(parseInt(form.text.value)))
		{ 	document.getElementById('veriftext').innerHTML='Format invalide'; 
			document.getElementById('veriftext').style.display='block'; return false;}
		if (parseInt(form.text.value) > parseInt(form.text_max.value))
		{ 	document.getElementById('veriftext').innerHTML='Le nombre de champs texte doit &ecirc;tre inf&eacute;rieur ou &eacute;gal &agrave; ' + form.text_max.value; 
			document.getElementById('veriftext').style.display='block'; return false;}
	}
	return true;
}


function clear_verif(form) {
	document.getElementById(form).innerHTML='';
	document.getElementById(form).style.display='none';
}
