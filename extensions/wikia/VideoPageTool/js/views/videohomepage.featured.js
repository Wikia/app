define( 'views.videohomepage.featured', [ 'jquery', 'wikia.nirvana', 'wikia.videoBootstrap', 'vpt.models.featured' ], function( $, nirvana, VideoBootstrap, FeaturedModel ) {

	'use strict';

	function Featured() {
		this.$sliderWrapper = $( '#featured-video-slider' );
		this.$bxSlider = $( '#featured-video-bxslider' );
		this.$thumbs = $( '#featured-video-thumbs' );

		// The slider starts off as an image slider, then switches to a video slider when the first video is clicked
		this.isVideoSlider = false;
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
				onSlideNext: $.proxy( this.onArrowClick, this ),
				onSlidePrev: $.proxy( this.onArrowClick, this ),
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
		bindEvents: function() {
			var that = this;

			// thumbs visibility toggle
			this.initThumbShowHide();

			// play video
			this.$thumbs.on( 'click', '.video', function( e ) {
				e.preventDefault();

				that.handleThumbClick( $( this ) );
			});
		},
		handleThumbClick: function( $video ){
			var that = this,
				videoKey = $video.children( 'img' ).attr( 'data-video-key' ),
				idx = $video.index(),
				slide = this.slides[ idx ];

			// It's now a video slider
			this.isVideoSlider = true;

			// Stop slider autoscroll because we're watching videos now
			this.slider.stopAuto();

			// Go to the selected slide based on thumbnail that was clicked
			this.slider.goToSlide( idx );

			if( slide.embedData === null ) {
				// Get video embed data for this slide
				nirvana.sendRequest({
					controller: 'VideoHandler',
					method: 'getEmbedCode',
					data: {
						fileTitle: videoKey,
						width: 750,
						autoplay: 1
					}
				})
					.done( function( data ) {
						// cache embed data
						that.sliderModel.addVideoEmbedData( slide, data );
						that.playVideo( slide );
					});

			} else {
				// We already have video embed data, play it.
				that.playVideo( slide );
			}

		},
		/* @desc When an arrow is clicked, if it's already a video slider, play the next video. Otherwise, do nothing,
		 * just let the slider switch to the next image.
		 */
		onArrowClick: function( $slide, oldIndex, newIndex ) {
			if( this.isVideoSlider ) {
				this.slides[ newIndex ].switchToVideo();
				this.$thumbs.find( '.video' ).eq( newIndex ).click();
			}
		},
		playVideo: function( slide ) {
			this.videoInstance && this.videoInstance.destroy(); // TODO: maybe move this somewhere else

			// Hide image container, show video container
			slide.switchToVideo();

			this.videoInstance = new VideoBootstrap( slide.$video[ 0 ], slide.embedData.embedCode, 'videoHomePage' );
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
