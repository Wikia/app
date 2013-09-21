define( 'views.videohomepage.featured', [], function() {

	'use strict';

	function Featured() {
		this.$sliderWrapper = $( '#featured-video-slider' );
		this.$bxSlider = $( '#featured-video-bxslider' );
		this.$thumbs = $( '#featured-video-thumbs' );

		// value will be assigned after slider inits
		this.$sliderControls = null;
		this.slider = null;

		this.init();
	}

	Featured.prototype = {
		init: function() {
			this.fixDOM();
			this.initSlider();
		},
		fixDOM: function() {
			// TODO: this is a hack, ideally it would be done on the back end
			this.$thumbs.find( 'a' ).each( function() {
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

			this.slider = this.$bxSlider.bxSlider({
				//video: true, // TODO: add video support?
				onSliderLoad: $.proxy( this.onSliderLoad, this ),
				nextText: '',
				prevText: '',
				//auto: true,
				speed: 400,
				autoHover: true
			});

		},
		onSliderLoad: function() {
			// Show the feature now that it's done loading
			this.$sliderWrapper.css( 'visibility', 'visible' );

			// Controls are loaded, cache them
			this.$sliderControls = this.$sliderWrapper.find( '.bx-pager' );

			this.bindEvents();
		},
		bindEvents: function() {
			var that = this;

			// Show thumbs
			this.$sliderControls.on( 'mouseenter', function() {
				that.$thumbs.slideDown();
			});
			// Hide thumbs
			this.$thumbs.on( 'mouseleave', function() {
				$( this ).slideUp();
			})
			// play video
			.on( 'click', '.video', function( e ){
				e.preventDefault();
				that.playVideo( $( this ) );
			});
		},
		playVideo: function( $elem ) {

			var videoKey = $elem.children( 'img' ).attr( 'data-video-key' ),
				idx = $elem.index();

			this.slider.goToSlide( idx );
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
