jQuery(document).ready(function($) {
	
	function maPosition(position) {
		
		var infopos = "Position déterminée :\n";

		infopos += "Latitude : "+position.coords.latitude +"\n";
		infopos += "Longitude: "+position.coords.longitude+"\n";
		infopos += "Altitude : "+position.coords.altitude +"\n";

		geocodeLatLng(position.coords.latitude, position.coords.longitude); 
	  
	}

	function erreurPosition(error) {
		
		var info = "Erreur lors de la géolocalisation : ";
		
		switch(error.code) {
			
			case error.TIMEOUT:
				info += "Timeout !";
			break;
			
			case error.PERMISSION_DENIED:
			info += "Vous n’avez pas donné la permission";
			break;
			
			case error.POSITION_UNAVAILABLE:
				info += "La position n’a pu être déterminée";
			break;
			
			case error.UNKNOWN_ERROR:
				info += "Erreur inconnue";
			break;
			
		}
		
		//document.getElementById("infoposition").innerHTML = info;
		console.log(info);
		
	}

	function geocodeLatLng(lat, lng) {

		var geocoder = new google.maps.Geocoder;
		var latlng = {lat: lat, lng: lng};
		
		geocoder.geocode({'location': latlng}, function(results, status) {
			
			if (status === 'OK') {
				if (results[1]) {
					
					var searchAddressComponents = results[0].address_components;
					var bruteAdress, street_number, route, postal_code, locality, location, autocomplete;
					
					$.each(searchAddressComponents, function(){
						if(this.types[0]=="street_number")	{ street_number = this.short_name;	$('#street_number').val(street_number); }
						if(this.types[0]=="route")			{ route = this.short_name;			$('#route').val(route);                 }
						if(this.types[0]=="postal_code")	{ postal_code = this.short_name;	$('#postal_code').val(postal_code);		}
						if(this.types[0]=="locality")		{ locality = this.short_name;		$('#locality').val(locality);			}
						if(this.types[0]=="location")		{ location = this.short_name;		$('#location').val(location);			}
						
					});
					
					location = '('+lat+','+lng+')';
					bruteAdress = street_number + ' ' + route + ', ' + locality + ', France';
					autocomplete = street_number + ' ' + route + ' ' + postal_code + ' ' + locality;

					$("#autocomplete").val(bruteAdress);
					$("#lat").val(lat);
					$("#lng").val(lng);
					
				} 
			} 
		  
		});
	}

	
	if(/Mobi/.test(navigator.userAgent) && navigator.geolocation) {
	//if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(maPosition, erreurPosition);
	} else {
		console.log("Ce navigateur ne supporte pas la géolocalisation");
	}
	
});
