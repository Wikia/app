//alert('loaded');

$(function() {
	'use strict';

	var pagerIdx = 0;
	$( '#featured-video-bx-pager li' ).children( 'a' ).each( function() {
		$( this ).addClass( 'no-lightbox' ).attr( 'data-slide-index', pagerIdx );
		pagerIdx += 1;
	});
	$('#featured-video-bxslider').bxSlider({
		autoControls: true
		//video: true, // TODO: add video support?
		//pagerCustom: '#featured-video-bx-pager'
	});

});