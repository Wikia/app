define( 'views.videohomepage.featured', [], function() {

	'use strict';

	function Featured() {
		this.$sliderWrapper = $( '#featured-video-slider' );
		this.$featuredBXSlider = $( '#featured-video-bxslider' );
		this.$featuredThumbs = $( '#featured-video-thumbs' );

		this.init();
	}

	Featured.prototype = {
		init: function() {
			this.fixDOM();
			this.initSlider();
		},
		fixDOM: function() {
			// TODO: this is a hack, ideally it would be done on the back end
			this.$featuredThumbs.find( 'a' ).each( function() {
				$( this )
					// Don't open lightbox when clicked
					.addClass( 'no-lightbox' )
					.on( 'click', function( e ) {
						e.preventDefault();
					})
					// format the play button so it can be responsive
					.find( '.Wikia-video-play-button' )
					.css( 'width', 'inherit' );
			});
		},
		initSlider: function() {

			this.$featuredBXSlider.bxSlider({
				//autoControls: true,
				//video: true, // TODO: add video support?
				onSliderLoad: $.proxy( this.onSliderLoad, this )
			});

		},
		onSliderLoad: function() {
			var that = this;

			this.$sliderWrapper.css( 'visibility', 'visible' );

			this.$sliderControls = this.$sliderWrapper.find( '.bx-pager' ).on( 'mouseenter', function() {
				that.$featuredThumbs.slideDown();
			});

			this.$featuredThumbs.on( 'mouseleave', function() {
				$( this ).slideUp();
			});
		}
	};

	return Featured;
});

require( ['views.videohomepage.featured'], function( FeaturedVideoView ) {
	'use strict';

	$(function() {
		return new FeaturedVideoView();
	});
});
