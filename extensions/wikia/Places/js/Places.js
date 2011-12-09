/*global google: true*/
var Places = Places || (function(){
	/** @private **/

	var isWikiaMobile = (typeof WikiaMobile != 'undefined'),
		clickEvent = (isWikiaMobile) ? WikiaMobile.getClickEvent() : 'click';

	function showModal(event){
		event.preventDefault();
		event.stopPropagation();

		var element = $(this),
			latlng = new google.maps.LatLng(element.attr('data-lat'), element.attr('data-lon')),
			options = {
				'zoom': parseInt( element.attr('data-zoom') ),
				'center': latlng,
				'mapTypeId': google.maps.MapTypeId.ROADMAP
			};

		$.nirvana.postJson(
			'PlacesSpecialController',
			'getMarkersRelatedToCurrentTitle',
			{
				title: wgTitle,
				format: 'json'
			},
			function(res){
				if(res.center && res.markers){
					var height = (isWikiaMobile) ? '100%' : ($(window).height() - 200).toString() + 'px';

					$.showModal(wgTitle, '<div id="places-dynamic-map" style="height:' + height + '"></div>', {
						'id': 'places-modal',
						'width' : ($(window).width() - 100),
						'callback' : function () {
							Places.displayDynamic(res)
						}
					});
				}
			}
		);
	}

	function getPosition(){
		if(navigator.geolocation){
			navigator.geolocation.getCurrentPosition(positionFound, positionError);

			return true;
		}

		return false;
	}

	function positionFound(position){
		alert(JSON.stringify(position));
	}

	function positionError(error){
		$.showModal(
			$.msg('places-geolocation-modal-error-title'),
			'<p>' + $.msg('places-geolocation-modal-error', error.message) + '</p>'
		);
	}

	/** @public **/

	return {
		init: function() {
			var miniMaps = $('.placemap'),
				geoButton = $('#geotagButton');

			if(miniMaps.length){
				$.loadGoogleMaps(function(){
					$('#WikiaMainContent').delegate('.placemap img', clickEvent, showModal);
				});
			}

			if(geoButton.length){
				geoButton.bind('click', function(){
					var check = getPosition();
					
					if(check){
						
					}else{
						$.showModal(
							$.msg('places-geolocation-modal-error-title'),
							'<p>' + $.msg('places-geolocation-modal-not-available') + '</p>'
						);
					}
				});
			}
		},

		displayDynamic: function( options ){
			options = options || {};
			options.markers = options.markers || [];
			options.center = options.center || false;

			$().log( options.markers, 'markers' );

			if ( options.markers.length > 0 ){
				var lanSum = 0;
				var latSum = 0;

				var maxLat = -181.0;
				var maxLan = -181.0;
				var minLat = 181.0;
				var minLan = 181.0;

				$.each( options.markers,
					function( index, value ) {
						lanSum += value.lan;
						latSum += value.lat;
						if ( maxLat < value.lat ){maxLat = value.lat}
						if ( maxLan < value.lan ){maxLan = value.lan}
						if ( minLat > value.lat ){minLat = value.lat}
						if ( minLan > value.lan ){minLan = value.lan}
					}
				);
				$().log( options.center, 'center' );
				if ( options.center != false ){

					var latDistance = Math.max( Math.abs( maxLat - options.center.lat ), Math.abs( options.center.lat - minLat ) );
					var lanDistance = Math.max( Math.abs( maxLan - options.center.lan ), Math.abs( options.center.lan - minLan ) );
					minLat = options.center.lat - latDistance;
					minLan = options.center.lan - lanDistance;
					maxLat = options.center.lat + latDistance;
					maxLan = options.center.lan + lanDistance;

				}
				var mapConfig = {
					'center': new google.maps.LatLng( 0, 0 ),
					'mapTypeId': google.maps.MapTypeId.ROADMAP,
					'zoom': 14
				}

				var map = new google.maps.Map(
					document.getElementById("places-dynamic-map"),
					mapConfig
				);

				map.fitBounds(
					new google.maps.LatLngBounds(
						new google.maps.LatLng( minLat, minLan ),
						new google.maps.LatLng( maxLat, maxLan )
					)
				);

				var aMarker = [];
				var aInfoWindow = [];
				$.each( options.markers, function( index, value ){
					if ( ( typeof value.lat != 'undefined' ) && ( typeof value.lat != 'undefined' ) && ( typeof value.label != 'undefined' ) && ( typeof value.tooltip != 'undefined' ) ){
						aMarker.push(
							new google.maps.Marker({
								position:	new google.maps.LatLng( value.lat, value.lan ),
								map:		map,
								title:		value.label
							})
						);
						aInfoWindow.push(
							new google.maps.InfoWindow({
								content: value.tooltip,
								maxWidth: 300
							})
						);
						var key = aMarker.length - 1;
						google.maps.event.addListener( aMarker[ key ], clickEvent, function() {
							aInfoWindow[ key ].open(map, aMarker[ key ] );
						});

						if ( options.center.label == value.label  ){
							aInfoWindow[ key ].open(map, aMarker[ key ] );
						}
					}
				});
			}
		}
	};
})();