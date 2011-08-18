if( navigator.platform.indexOf("iPad") != -1 ) {
	$.getResources( [ $.getSassCommonURL(  '/skins/oasis/css/ipad.scss' ), stylepath + '/oasis/js/ipad.js?' + wgStyleVersion ] );
}
