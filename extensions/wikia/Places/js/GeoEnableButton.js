var GeoEnableButton = {
	offButton: null,
	onButton: null,
	init: function() {
		$('#pageHeader').
			delegate('a[data-id="places-category-switch-off"]', 'click', GeoEnableButton.switchOn).
			delegate('a[data-id="places-category-switch-on"]', 'click', GeoEnableButton.switchOff);
	},
	switchOn: function(e){
		e.preventDefault();
		GeoEnableButton.doSwitch(
			$('a[data-id="places-category-switch-off"]'),
			$('a[data-id="places-category-switch-on"]'),
			'enableGeoTagging'
		);
	},
	switchOff: function(e){
		e.preventDefault();
		GeoEnableButton.doSwitch(
			$('a[data-id="places-category-switch-on"]'),
			$('a[data-id="places-category-switch-off"]'),
			'disableGeoTagging'
		);
	},
	doSwitch: function( elemFrom, elemTo, methodName ){
		elemFrom.addClass('disabled');
		if( $('.geoThrobber').length == 0 ){
			// 2DO: Style me
			elemFrom.before('<img class="geoThrobber" src="' + stylepath + '/common/images/ajax.gif" />');
			$.nirvana.getJson(
				'PlacesCategoryController',
				methodName,
				{
					pageName: wgPageName
				},
				function( res ) {
					if ( res.error == 0 ) {
						$('.geoThrobber').remove();
						elemTo.removeClass('disabled');
					} else {
						$('.geoThrobber').remove();
					elemFrom.removeClass('disabled');
					}
				},
				function(){
					$('.geoThrobber').remove();
					elemFrom.removeClass('disabled');
				}
			);
		}
	}
};

GeoEnableButton.init();
