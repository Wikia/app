if( navigator.platform.indexOf("iPad") != -1 ) {
	$.getResources( [ $.getSassCommonURL( '/skins/oasis/css/ipad.scss' ), '/skins/common/zepto/orientation.js' ,'/skins/oasis/js/ipad.js' ] );
}