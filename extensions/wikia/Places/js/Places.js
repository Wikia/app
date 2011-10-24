var Places = {
	init: function() {
		$('#WikiaMainContent').delegate( '.placemap img', 'click', Places.showModal );
	},
	showModal: function(e){
		var element = $( this );
		e.preventDefault();
		var latlng = new google.maps.LatLng( element.attr('data-lat'), element.attr('data-lon') );
		var options = {
			'zoom': parseInt( element.attr('data-zoom') ),
			'center': latlng,
			'mapTypeId': google.maps.MapTypeId.ROADMAP
		}
		$.showModal( wgTitle, '<div id="places-modal-map" style="height:' + ( $(window).height() - 200 ) + 'px"></div>', {
			'id': 'places-modal',
			'width' : ( $(window).width() - 100 ),
			'callback' : function () {
				var map = new google.maps.Map(
					document.getElementById("places-modal-map"),
					options
				);
				var marker = new google.maps.Marker({
					position: latlng,
					map: map,
					title: wgTitle
				});
			}
		});
	},
	displayDynamic: function( ){

		var markers = [
			{'lat': 1.23,	'lan': 1.001,	'label': '123123123'},
			{'lat': 1,	'lan': 1.002,	'label': 'rwer'},
			{'lat': 0.387,	'lan': -9.6123,	'label': 'asda12312dsa'},
			{'lat': -1.387, 'lan': 2.6123,	'label': 'asasdasdsa'},
			{'lat': 13.987, 'lan': 1.0123,	'label': 'as3434 222 sa'}
		];

		if ( markers.length > 0 ){
			var lanSum = 0;
			var latSum = 0;
			
			var maxLat = -10;
			var maxLan = -10;
			var minLat = 10;
			var minLan = 10;

			$.each( markers,
				function(index, value) {
					lanSum += value.lan;
					latSum += value.lat;
					if ( maxLat < value.lat ){ maxLat = value.lat }
					if ( maxLan < value.lan ){ maxLan = value.lan }
					if ( minLat > value.lat ){ minLat = value.lat }
					if ( minLan > value.lan ){ minLan = value.lan }
				}
			)

			var options = {
				'center': new google.maps.LatLng( 0, 0 ),
				'mapTypeId': google.maps.MapTypeId.ROADMAP,
				'zoom': 14
			}

			var map = new google.maps.Map(
				document.getElementById("places-dynamic-map"),
				options
			);

			map.fitBounds(
				new google.maps.LatLngBounds(
					new google.maps.LatLng( minLat, minLan ),
					new google.maps.LatLng( maxLat, maxLan )
				)
			);

			var aMarker = [];
			$.each( markers, function( index, value ){
				aMarker.push(
					new google.maps.Marker({
						position: new google.maps.LatLng( value.lat, value.lan ),
						map: map,
						title: value.label
					})
				);
			});			
		}
	}
};
