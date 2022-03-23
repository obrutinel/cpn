
    var autocomplete;
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        postal_code: 'short_name'
    };

    function initAutocomplete() {
		
		// On priorise la France
		var defaultBounds = new google.maps.LatLngBounds(
			new google.maps.LatLng(48.856614, 2.3522219000000177),
			new google.maps.LatLng(48.856614, 2.3522219000000177));

        var options = {
			bounds: defaultBounds,
            types: ['geocode'],
			componentRestrictions: {country: ["fr", "gp", "mq", "gf", "re", "pm", "yt", "nc", "pf", "mf", "tf"]}
        };

        autocomplete = new google.maps.places.Autocomplete((document.getElementById('autocomplete')), options);
        autocomplete.addListener('place_changed', fillInAddress);

    }

    function fillInAddress() {

        var place = autocomplete.getPlace();

        for (var component in componentForm) {
            document.getElementById(component).value = '';
            document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(addressType).value = val;
            }
        }

        document.getElementById('lat').value = place.geometry.location.lat();
        document.getElementById('lng').value = place.geometry.location.lng();

    }