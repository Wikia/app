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
	}
};
