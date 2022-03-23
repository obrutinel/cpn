	
	function initialize() {
		
		var map;
		var bounds = new google.maps.LatLngBounds();
		
		var styles = [
		  {
			stylers: [
			  { hue: "#00ffe6" },
			  { saturation: -20 }
			]
		  },{
			featureType: "landscape",
			stylers: [
			  { hue: "#FFBB00" },
			  { saturation: 43.400000000000006 },
			  { lightness: 37.599999999999994 },
			  { gamma: 1 }
			]
		  },{
			featureType: "road.highway",
			stylers: [
			  { hue: "#FFC200" },
			  { saturation: -61.8 },
			  { lightness: 45.599999999999994 },
			  { gamma: 1 }
			]
		  },{
			featureType: "road.local",
			stylers: [
			  { hue: "#497eb5" },
			  { saturation: -100 },
			  { lightness: 52 },
			  { gamma: 1 }
			]
		  },{
			featureType: "water",
			stylers: [
			  { hue: "#0078FF" },
			  { saturation: -13.200000000000003 },
			  { lightness: 2.4000000000000057 },
			  { gamma: 1 }
			]
		  },{
			featureType: "poi",
			stylers: [
			  { hue: "#00FF6A" },
			  { saturation: -1.0989010989011234 },
			  { lightness: 11.200000000000017 },
			  { gamma: 1 }
			]
		  }
		];

		
		var mapOptions = {
			mapTypeId: 'roadmap',
			styles: styles
		};
		
		
						
		// Display a map on the page
		map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
		map.setTilt(45);
			
		// Multiple Markers
		var markers = [
			['Parc Le Florembeau', 49.736010, 2.438348],
			['Parc Le Fond de l\'être', 43.951439, 4.806130],
			['Un autre parc..', 44.199008, 5.942352],
		];
							
		// Info Window Content
		var infoWindowContent = [
			['<div class="info_content">' +
			'<h5>Parc Le Florembeau</h5>' +
			'' + '</div>'],
			['<div class="info_content">' +
			'<h5>Parc Le Fond de l\'être</h5>' +
			'<p><a href="detail.html">En savoir plus sur ce parc.</a></p>' +
			'</div>'],
			['<div class="info_content">' +
			'<h5>Un autre parc..</h5>' +
			'<p><a href="detail.html">En savoir plus sur ce parc.</a></p>' +
			'</div>']							
		];
			
		// Display multiple markers on a map
		var infoWindow = new google.maps.InfoWindow(), marker, i;
		
		// Loop through our array of markers & place each one on the map  
		for( i = 0; i < markers.length; i++ ) {
			
			var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
			bounds.extend(position);
			
			if(i == 0) {
			
				var icon = {
					 url: 'images/rural-house-with-wind-mill.png',
				};
			
				marker = new google.maps.Marker({
					position: position,
					map: map,
					title: markers[i][0],
					icon: icon
				});
			
			}
			else {
			
				var icon = {
					 url: 'images/wind-mill-ecological-generator.png',
				};
			
				marker = new google.maps.Marker({
					position: position,
					map: map,
					title: markers[i][0],
					icon: icon
				});
			
			}
			
			// Allow each marker to have an info window    
			google.maps.event.addListener(marker, 'click', (function(marker, i) {
				return function() {
					infoWindow.setContent(infoWindowContent[i][0]);
					infoWindow.open(map, marker);
				}
			})(marker, i));

			// Automatically center the map fitting all markers on the screen
			map.fitBounds(bounds);
		}

		// Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
		var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
			this.setZoom(5);
			google.maps.event.removeListener(boundsListener);
		});
		
	}