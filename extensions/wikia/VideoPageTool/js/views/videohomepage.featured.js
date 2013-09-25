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
		this.sliderModel = new FeaturedModel( {
			slides: this.$bxSlider.children(),
			thumbs: this.$thumbs
		});

		this.slides = this.sliderModel.slides;
		this.thumbs = this.sliderModel.thumbs;


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
						that.sliderModel.addVideoEmbedData( slide, data );
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
			slide.current = 'video';

			this.videoInstance = new VideoBootstrap( slide.$video[ 0 ], slide.embedData.embedCode, 'videoHomePage' );
		},
		bindEvents: function() {
			var that = this;

			// Thumb visibility toggle
			this.initThumbShowHide();

			// play video
			this.$thumbs.on( 'click', '.video', function( e ){
				var $this = $( this );

				e.preventDefault();

				that.nextVideo = $this.children( 'img' ).attr( 'data-video-key' );
				that.slider.goToSlide( $this.index() );
			});
		},
		/* @desc Toggle thumb visibility using a timeout so hovering over controls will not hide thumbs
		 *
		 */
		initThumbShowHide: function() {
			var that = this,
				hoverTimeout = 0;

			function setHoverTimeout() {
				hoverTimeout = setTimeout( function() {
					that.$thumbs.slideUp();
				}, 300 );
			}

			this.$sliderControls
				.on( 'mouseenter', '.bx-pager-item', function() {
					clearTimeout( hoverTimeout );
					that.$thumbs.slideDown();
				})
				.on('mouseleave', '.bx-pager-item', function() {
					setHoverTimeout();
				});
			that.$thumbs
				.on( 'mouseenter', function() {
					clearTimeout( hoverTimeout );
				})
				.on( 'mouseleave', function() {
					setHoverTimeout();
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
