define( 'views.videohomepage.featured', [ 'jquery', 'wikia.nirvana', 'wikia.videoBootstrap', 'vpt.models.featured' ], function( $, nirvana, VideoBootstrap, FeaturedModel ) {

	'use strict';

	function Featured() {
		this.$sliderWrapper = $( '#featured-video-slider' );
		this.$bxSlider = $( '#featured-video-bxslider' );
		this.$thumbs = $( '#featured-video-thumbs' );

		// Track which video should play next
		this.nextVideo = false;
		this.videoInstance = null;

		// value will be assigned after slider inits
		this.$sliderControls = null;
		this.slider = null;

		// Get data from model
		var sliderData = new FeaturedModel( {
			slides: this.$bxSlider.children(),
			thumbs: this.$thumbs
		});

		this.slides = sliderData.slides;
		this.thumbs = sliderData.thumbs;


		this.init();
	}

	Featured.prototype = {
		init: function() {
			this.fixDOM();
			this.initSlider();
		},
		// TODO: this is a hack, ideally it would be done on the back end
		fixDOM: function() {
			this.$thumbs.find( 'a' ).each( function() {
				$( this )
					// Don't open lightbox when clicked
					.addClass( 'no-lightbox' )
					// format the play button so it can be responsive
					.find( '.Wikia-video-play-button' )
					.css( 'width', 'inherit' );
			});
		},
		initSlider: function() {

			this.slider = this.$bxSlider.bxSlider({
				//video: true, // TODO: add video support?
				onSliderLoad: $.proxy( this.onSliderLoad, this ),
				onSlideAfter: $.proxy( this.onSlideAfter, this ),
				nextText: '',
				prevText: '',
				auto: true,
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
		// TODO: if the user clicks on a video thumb when the larger image is already in view, the video should still
		// play
		onSlideAfter: function( $slide, oldIndex, newIndex ) {

			var that = this,
				slide = this.slides[ newIndex ];

			if ( this.nextVideo ) {
				if( slide.embedData === null ) {
					nirvana.sendRequest({
						controller: 'VideoHandler',
						method: 'getEmbedCode',
						data: {
							fileTitle: this.nextVideo,
							width: 750,
							autoplay: 1
						}
					})
					.done( function( data ) {
						// cache embed data
						slide.embedData = data;
						that.handleVideoSwitch( slide );
					});

				} else {
					that.handleVideoSwitch( slide );
				}
			} else {
				this.videoInstance && this.videoInstance.destroy(); // TODO: maybe move this somewhere else
			}

			this.nextVideo = false;
		},
		handleVideoSwitch: function( slide ) {
			this.slider.stopAuto();

			this.videoInstance && this.videoInstance.destroy(); // TODO: maybe move this somewhere else

			slide.$image.hide();
			slide.$video.show();

			this.videoInstance = new VideoBootstrap( slide.$video[ 0 ], slide.embedData.embedCode, 'videoHomePage' );
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
				var $this = $( this );

				e.preventDefault();

				that.nextVideo = $this.children( 'img' ).attr( 'data-video-key' );
				that.slider.goToSlide( $this.index() );
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
