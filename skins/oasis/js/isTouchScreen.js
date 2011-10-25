if (document.createElement( 'div' ).hasOwnProperty('ontouchstart')) {
	$.getResources( [ $.getSassCommonURL(  '/skins/oasis/css/touchScreen.scss' ), stylepath + '/oasis/js/touchScreen.js?' + wgStyleVersion ] );
}
