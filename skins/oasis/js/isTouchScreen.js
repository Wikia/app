if ( 'ontouchstart' in document.createElement( 'div' ) ) {
	$.getResources( [ $.getSassCommonURL(  '/skins/oasis/css/touchScreen.scss' ), stylepath + '/oasis/js/touchScreen.js?' + wgStyleVersion ] );
}
