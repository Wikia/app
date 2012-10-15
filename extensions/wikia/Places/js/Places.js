/*global google: true, WikiaMobile: true, PlacesEditor: true*/
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

		$.nirvana.getJson(
			'Places',
			'getMarkersRelatedToCurrentTitle',
			{
				'title':	wgTitle,
				'format':	'json',
				'category':	element.attr('data-categories') || ''
			},
			function(res){
				if(res.center && res.markers){
					var height = (isWikiaMobile) ? '100%' : ($(window).height() - 250).toString() + 'px',
						html = '<div id="popup-map" style="height:' + height + '"></div>' +
							'<div id="places-map-caption">' + res.caption + '</div>';

					res.mapId = 'popup-map';

					$.showModal(wgTitle, html, {
						'id': 'places-modal',
						'width' : ($(window).width() - 100),
						'callback' : function () {
							Places.renderMap(res);
						}
					});
				}
			}
		);
	}

	function positionError(error){
		$.showModal(
			$.msg('places-geolocation-modal-error-title'),
			'<p>' + $.msg('places-geolocation-modal-error', error.message) + '</p>'
		);
	}

	function getPosition(callback){
		if(navigator.geolocation){
			navigator.geolocation.getCurrentPosition(callback, positionError);
			return true;
		}

		return false;
	}

	function setArticleLocation(lat, lon) {
		var data = {
			lat: lat,
			lon: lon,
			width: $('#WikiaArticle img').eq(0).width(),
			align: $('#WikiaArticle figure').eq(0).css('float'),
			articleId: window.wgArticleId
		};

		// TODO: add progress indicator
		$.nirvana.postJson('Places', 'saveNewPlaceToArticle', data, function() {
			document.location.reload();
		});
	}

	/** @public **/

	return {
		init: function() {
			var miniMaps = $('.placemap'),
				geoButton = $('#geotagButton');

			if(miniMaps.exists()){
				$.loadGoogleMaps(function(){
					$('#WikiaMainContent').delegate('.placemap > img', clickEvent, showModal);
				});
			}

			if(geoButton.length){
				geoButton.bind('click', function(){
					if(isWikiaMobile){
						// support mobile localisation
						getPosition(function(geoposition) {
							var location = geoposition.coords;
							setArticleLocation(location.latitude, location.longitude);
						});
					}else{
						// lazy load the editor
						$.getResources([
								$.loadGoogleMaps,
								function(cb) {$.getMessages('Places', cb);},
								wgExtensionsPath + '/wikia/Places/js/PlacesEditor.js',
								$.getSassCommonURL('extensions/wikia/Places/css/PlacesEditor.scss')
							],
							function() {
								PlacesEditor.createNew(function(location) {
									setArticleLocation(location.lat, location.lon);
								});
							}
						);
					}
				});
			}
		},

		renderMap: function( options ){
			options = options || {};
			options.markers = options.markers || [];
			options.center = options.center || false;

			if ( options.markers.length > 0 ){
				var lanSum = 0,
					latSum = 0;

				var maxLat = -181.0,
					maxLan = -181.0,
					minLat = 181.0,
					minLan = 181.0;

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

				var mapConfig = {
						'center': new google.maps.LatLng( 0, 0 ),
						'mapTypeId': google.maps.MapTypeId.ROADMAP,
						'zoom': 14
					},
					map = new google.maps.Map(
						document.getElementById(options.mapId),
						mapConfig
					);

				// fit all markers inside a map
				if ( options.center !== false ){
					var latDistance = Math.max( Math.abs( maxLat - options.center.lat ), Math.abs( options.center.lat - minLat ) );
					var lanDistance = Math.max( Math.abs( maxLan - options.center.lan ), Math.abs( options.center.lan - minLan ) );
					minLat = options.center.lat - latDistance;
					minLan = options.center.lan - lanDistance;
					maxLat = options.center.lat + latDistance;
					maxLan = options.center.lan + lanDistance;
				}

				map.fitBounds(
					new google.maps.LatLngBounds(
						new google.maps.LatLng( minLat, minLan ),
						new google.maps.LatLng( maxLat, maxLan )
					)
				);

				// generate markers and tooltips
				var aMarkers = [],
					aInfoWindows = [];

				$.each( options.markers, function( index, value ){
					if ( ( typeof value.lat != 'undefined' ) && ( typeof value.lan != 'undefined' ) && ( typeof value.label != 'undefined' ) && ( typeof value.tooltip != 'undefined' ) ){
						var marker = new google.maps.Marker({
								position:	new google.maps.LatLng( value.lat, value.lan ),
								map:		map,
								title:		value.label
							}),
							tooltip = new google.maps.InfoWindow({
								content: value.tooltip,
								maxWidth: 300
							});

						google.maps.event.addListener( marker, clickEvent, function() {
							tooltip.open(map, marker);
						});

						// open a tooltip for the place map was initialized from
						if ( options.center && (options.center.label == value.label) ){
							tooltip.open(map, marker);
						}

						aMarkers.push(marker);
						aInfoWindows.push(tooltip);
					}
				});

				// support animations
				if (options.animate > 0) {
					var current = 0,
						count = aInfoWindows.length;

					// first frame
					aInfoWindows[current].open(map, aMarkers[current]);

					setInterval(function() {
						aInfoWindows[current].close(map, aMarkers[current]);

						current = (++current) % count;
						aInfoWindows[current].open(map, aMarkers[current]);
					}, options.animate * 1000);
				}
			}
		}
	};
})();