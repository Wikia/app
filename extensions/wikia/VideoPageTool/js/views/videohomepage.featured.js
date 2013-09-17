//alert('loaded');

$(function() {
	'use strict';

	var $sliderWrapper = $( '#featured-video-slider' ),
		$featuredBXSlider = $( '#featured-video-bxslider' ),
		$featuredThumbs = $( '#featured-video-thumbs' ),
		$sliderControls;

	$featuredThumbs.find( 'a' ).each( function() {
		$( this )
			.addClass( 'no-lightbox' )
			.on( 'click', function( e ) {
				e.preventDefault();
			})
		.find( '.Wikia-video-play-button' )
			.css( 'width', 'inherit' );
	});

	$featuredBXSlider.bxSlider({
		autoControls: true,
		onSliderLoad: function() {
			$sliderControls = $sliderWrapper.find( '.bx-pager' ).on( 'mouseenter', function() {
				$featuredThumbs.slideDown();
			});

			$featuredThumbs.on( 'mouseleave', function() {
				$( this ).slideUp();
			});
		}
		//video: true, // TODO: add video support?
	});

});