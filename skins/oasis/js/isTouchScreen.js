if ( $().isTouchscreen() ) {
	$.getResources([
		$.getSassCommonURL('/skins/oasis/css/touchScreen.scss'),
		stylepath + '/oasis/js/touchScreen.js'
	]);
}
