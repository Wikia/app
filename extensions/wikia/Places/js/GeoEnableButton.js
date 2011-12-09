/*global google: true*/
var GeoEnableButton = {
	offButton: null,
	onButton: null,
	init: function() {
		$().log('asdadad1');
		$('#WikiaPageHeader').delegate('a[data-id="places-category-switch-off"]', 'click', GeoEnableButton.switchOn )
		$('#WikiaPageHeader').delegate('a[data-id="places-category-switch-on"]', 'click', GeoEnableButton.switchOff )
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
			elemFrom.before('<img class="geoThrobber" src="http://images.wikia.com/common/skins/common/images/ajax.gif" />');
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
