define( 'views.videohomepage.featured', [ 'jquery', 'wikia.nirvana', 'wikia.videoBootstrap', 'vpt.models.featured' ], function( $, nirvana, VideoBootstrap, FeaturedModel ) {

	'use strict';

	function Featured() {
		// cache DOM elements
		this.$sliderWrapper = $( '#featured-video-slider' );
		this.$bxSlider = $( '#featured-video-bxslider' );
		this.$thumbs = $( '#featured-video-thumbs' );

		// The slider starts off as an image slider, then switches to a video slider when the first video is clicked
		this.isVideoSlider = false;

		// When the window is resized, request video at current size
		this.windowResized = false;

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
			this.initSlider();
		},
		initSlider: function() {
			this.slider = this.$bxSlider.bxSlider({
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

		/*
		 * @desc This is called after the bxSlider finishes loading
		 */
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

			$( window ).on( 'resize', function() {
				that.windowResized = true;
			});

		},
		/*
		 * @desc When a thumbnail is clicked, convert to video slider and slide to the corresponding slide
		 */
		handleThumbClick: function( $thumb ){
			var index = $thumb.index();

			this.switchToVideoSlider();

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
			this.switchToVideoSlider();

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
					window.GlobalNotification.show( json.error, 'error', null, 4000);
				} else {
					// cache embed data
					slide.embedData = json;
				}

				// Actually do the video embed
				that.videoInstance = new VideoBootstrap(
					slide.$video[ 0 ],
					slide.embedData.embedCode,
					'videoHomePage'
				);

				// TODO: Still figuring out if we want to use this or not
				//slide.$video.fitVids();
			});
		},
		/*
		 * @desc Get video data if we don't have it already or if the window has resized and we want to get the embed
		 * code at a different size.
		 */
		getEmbedCode: function( slide ) {
			var that = this,
				data;

			if( slide.embedData === null || this.windowResized ) {
				// Get video embed data for this slide
				data = nirvana.sendRequest({
					controller: 'VideoHandler',
					method: 'getEmbedCode',
					type: 'GET',
					data: {
						fileTitle: slide.videoKey,
						width: that.getWidthForVideo( slide ),
						autoplay: 1
					}
				});
				// We just got the embed data so reset windowResized flag
				this.windowResized = false;
			} else {
				data = slide.embedData;
			}

			// return a promise or a plain object
			return data;

		},

		getWidthForVideo: function( slide ) {
			var width = this.$sliderWrapper.width();

			// center the video in the space by setting the container width. This is just in case the browser window
			// gets bigger;
			slide.$video.width( width );

			return width;
		},

		/*
		 * @desc Funnel all video play events to onSliderAfter (unless the current slide was clicked)
		 */
		onSlideAfter: function( $slide, oldIndex, newIndex ) {
			if( this.isVideoSlider ) {
				this.playVideo( this.slides[ newIndex ] );
			}
		},

		switchToVideoSlider: function() {
			var len = this.slides.length,
				i;

			// It's now a video slider, don't show thumbnails anymore
			this.isVideoSlider = true;

			// Stop slider autoscroll because we're watching videos now
			this.slider.stopAuto();

			// don't let the slider start autoHover again
			this.$bxSlider.off( 'hover.autoHover' );

			for( i = 0; i < len; i++ ) {
				this.slides[ i ].$image.hide();
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
