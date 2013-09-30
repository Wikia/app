define( 'views.videohomepage.featured', [ 'jquery', 'wikia.nirvana', 'wikia.videoBootstrap', 'vpt.models.featured' ], function( $, nirvana, VideoBootstrap, FeaturedModel ) {

	'use strict';

	function Featured() {
		// cache DOM elements
		this.$sliderWrapper = $( '#featured-video-slider' );
		this.$bxSlider = $( '#featured-video-bxslider' );
		this.$thumbs = $( '#featured-video-thumbs' );
		this.$thumbVideos = this.$thumbs.find( '.video' );

		// The slider starts off as an image slider, then switches to a video slider when the first video is clicked
		this.isVideoSlider = false;

		// Track the video that's playing at any given time
		this.videoInstance = null;

		// values will be assigned after slider inits
		this.$sliderControls = null;
		this.slider = null;

		// Get data from model
		var sliderModel = new FeaturedModel( {
			$slides: this.$bxSlider.children(),
			$thumbs: this.$thumbs
		});

		this.slides = sliderModel.slides;
		this.thumbs = sliderModel.thumbs;


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
				onSlideNext: $.proxy( this.onArrowClick, this ),
				onSlidePrev: $.proxy( this.onArrowClick, this ),
				onSlideAfter: $.proxy( this.onSlideAfter, this ),
				nextText: '',
				prevText: '',
				auto: true,
				speed: 400,
				autoHover: true
			});
		},
		onSliderLoad: function() {
			// Show the slider now that it's done loading
			this.$sliderWrapper.css( 'visibility', 'visible' );

			// Controls are loaded, cache their jQuery DOM object
			this.$sliderControls = this.$sliderWrapper.find( '.bx-pager' );

			this.bindEvents();
		},
		bindEvents: function() {
			var that = this;

			// thumbs visibility toggle
			this.initThumbShowHide();

			// play video
			this.$thumbs.on( 'click', '.video', function( e ) {
				e.preventDefault();

				that.handleThumbClick( $( this ) );
			});

			this.$bxSlider.on( 'click', '.slide-image', function() {
				that.handleSlideClick( $( this ) );
			});
		},
		/*
		 * @desc When a thumbnail is clicked, convert to video slider and slide to the corresponding slide
		 */
		handleThumbClick: function( $thumb ){
			var index = $thumb.index();

			// It's now a video slider, don't show thumbnails anymore
			this.isVideoSlider = true;

			// Stop slider autoscroll because we're watching videos now
			this.slider.stopAuto();

			if( this.slider.getCurrentSlide() === index ) {
				// play the video
				this.playVideo( this.slides[ index ] );
			} else {
				// Go to the selected slide based on thumbnail that was clicked
				this.slider.goToSlide( index );
			}

		},
		/*
		 * @desc When a slide is clicked, convert to video slider and play the video
		 */
		handleSlideClick: function( $slideImage ) {
			// It's now a video slider, don't show thumbnails anymore
			this.isVideoSlider = true;

			// Stop slider autoscroll because we're watching videos now
			this.slider.stopAuto();

			// Get the slide's index from the data attr instead of index() b/c slides are cloned in bxSlider
			var index = $slideImage.data( 'index' );

			this.playVideo( this.slides[ index ] );
		},
		/* @desc When an arrow is clicked, if it's already a video slider, play the next video. Otherwise, do nothing,
		 * just let the slider switch to the next image.
		 */
		playVideo: function( slide ) {
			var that = this,
				data = this.getEmbedCode( slide );

			// Stop the video that's playing
			if( this.videoInstance ) {
				this.videoInstance.destroy();
			}

			slide.switchToVideo();

			$.when( data ).done( function( json ) {
				if( json.error ) {
					window.GlobalNotification.show( json.error, 'error' );
				} else {
					// cache embed data
					slide.embedData = json;
				}

				// Actually do the video embed
				that.videoInstance = new VideoBootstrap( slide.$video[ 0 ], slide.embedData.embedCode, 'videoHomePage' );
			});
		},
		getEmbedCode: function( slide ) {
			var data;

			if( slide.embedData === null ) {
				// Get video embed data for this slide
				data = nirvana.sendRequest({
					controller: 'VideoHandler',
					method: 'getEmbedCode',
					type: 'GET',
					data: {
						fileTitle: slide.videoKey,
						width: 750,
						autoplay: 1
					}
				});
			} else {
				data = slide.embedData;
			}

			// return a promise or a plain object
			return data;

		},

		/*
		 * @desc Funnel all video play events to onSliderAfter (unless the current slide was clicked)
		 */
		onSlideAfter: function( $slide, oldIndex, newIndex ) {
			if( this.isVideoSlider ) {
				this.playVideo( this.slides[ newIndex ] );
			}
		},

		/*
		 * @desc Toggle thumb visibility using a timeout so hovering over controls will not hide thumbs
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
