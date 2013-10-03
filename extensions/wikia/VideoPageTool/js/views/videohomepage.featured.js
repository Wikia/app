define( 'views.videohomepage.featured', [
	'jquery',
	'wikia.nirvana',
	'wikia.videoBootstrap',
	'wikia.tracker',
	'models.videohomepage.featured'
], function( $, nirvana, VideoBootstrap, Tracker, FeaturedModel ) {

	'use strict';
	var track = Tracker.buildTrackingFunction({
			action: Tracker.ACTIONS.CLICK,
			category: 'video-home-page',
			trackingMethod: 'both'
	});

	function Featured() {
		// cache DOM elements
		this.$sliderWrapper = $( '#featured-video-slider' );
		this.$bxSlider = $( '#featured-video-bxslider' );
		this.$thumbs = $( '#featured-video-thumbs' );

		// The slider starts off as an image slider, then switches to a video slider when the first video is clicked
		this.isVideoSlider = false;

		// Track the video that's playing at any given time
		this.videoInstance = null;

		// values will be assigned after slider inits
		this.$sliderControls = null;
		this.slider = null;
		this.videoPadding = null;

		// Get data from model
		var sliderModel = new FeaturedModel( {
			$slides: this.$bxSlider.children(),
			$thumbs: this.$thumbs
		});

		this.slides = sliderModel.slides;
		this.thumbs = sliderModel.thumbs;

		this.videoPlays = 0;

		this.init();
	}

	Featured.prototype = {
		init: function() {
			this.initSlider();
			this.initTitleEllipses();
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
				mode: 'fade',
				// not using this b/c it's buggy
				autoHover: false
			});

		},

		/*
		 * @desc This is called after the bxSlider finishes loading
		 */
		onSliderLoad: function() {
			// Show the slider now that it's done loading
			this.$sliderWrapper.removeClass( 'hidden' );

			// Controls are loaded, cache their jQuery DOM object
			this.$sliderControls = this.$sliderWrapper.find( '.bx-pager' );

			// left/right padding for videos so arrows don't overlap
			this.videoPadding = ( this.$sliderWrapper.find( '.bx-prev' ).width() * 2 ) + 130;

			this.bindEvents();
		},

		bindEvents: function() {
			var that = this;

			// thumbs visibility toggle
			this.initThumbShowHide();

			// play video when thumbnail is clicked
			this.$thumbs.on( 'click', '.video', function( e ) {
				e.preventDefault();

				that.handleThumbClick( $( this ) );
			});

			// play video when large image is clicked
			this.$bxSlider.on( 'click', '.slide-image', function() {
				that.handleSlideClick( $( this ) );
			});

			// pause the slider when mouseenter, start it up again on mouseleave
			// bxSlider has it's own handling but it's buggy when you combine it with the 'auto' setting then try to
			// stop it later
			this.$bxSlider.on({
				'mouseenter.autoHover': function(){
					that.$bxSlider.stopAuto();
				},
				'mouseleave.autohover': function(){
					that.$bxSlider.startAuto();
				}
			});


			$( window ).on( 'resize', $.proxy( this.resetEmbedData, this ) );

		},
		/*
		 * @desc When a thumbnail is clicked, convert to video slider and slide to the corresponding slide
		 */
		handleThumbClick: function( $thumb ){
			var index = $thumb.closest( 'li' ).index();

			if( !$thumb.hasClass( 'playing' ) ) {
				if ( !this.isVideoSlider ) {
					this.switchToVideoSlider();
				}

				this.$thumbs.slideUp();

				track({
						label: 'featured-thumbnail'
				});

				if( this.slider.getCurrentSlide() === index ) {
					// play the video
					this.playVideo( this.slides[ index ] );

				} else {
					// Go to the selected slide based on thumbnail that was clicked
					this.slider.goToSlide( index );
				}
			}
		},
		/*
		 * @desc When a slide is clicked, convert to video slider and play the video
		 */
		handleSlideClick: function( $slideImage ) {
			if ( !this.isVideoSlider ) {
				this.switchToVideoSlider();
			}

			// Get the slide's index from the data attr instead of index() b/c slides are cloned in bxSlider
			var index = $slideImage.data( 'index' );

			this.playVideo( this.slides[ index ] );
		},
		/*
		 * @desc When an arrow is clicked, if it's already a video slider, play the next video. Otherwise, do nothing,
		 * just let the slider switch to the next image.
		 */
		playVideo: function( slide ) {
			var that = this,
				data = this.getEmbedCode( slide );

			// Stop the video that's playing
			if( this.videoInstance ) {
				this.videoInstance.destroy();
			}


			this.$thumbs.find( '.playing' ).removeClass( 'playing' );
			slide.$videoThumb.addClass( 'playing' );

			$.when( data ).done( function( json ) {
				if( json.error ) {
					window.GlobalNotification.show( json.error, 'error', null, 4000);
				} else {
					// cache embed data
					slide.embedData = json;

					// Actually do the video embed
					that.videoInstance = new VideoBootstrap(
						slide.$video[ 0 ],
						slide.embedData.embedCode,
						'videoHomePage'
					);

					// Wait till video has loaded and update the slider viewport height.
					setTimeout(function() {
						that.$bxSlider.redrawSlider();
					}, 1000);
				}
			});

			track({
					label: 'featured-video-plays',
					value: this.videoPlays++
			});
		},

		/*
		 * @desc Get video data if we don't have it already or if the window has resized and we want to get the embed
		 * code at a different size.
		 */
		getEmbedCode: function( slide ) {
			var that = this,
				data;

			if( slide.embedData === null ) {
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
			} else {
				data = slide.embedData;
			}

			// return a promise or a plain object
			return data;
		},

		/*
		 * @desc Calculate the width at which the video should be loaded.  It can change based on container width
		 */
		getWidthForVideo: function( slide ) {
			// get the container width minus videoPadding for left/right arrows
			var width = this.$sliderWrapper.width() - this.videoPadding;

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

		/*
		 * @desc Update settings because it's not a video slider
		 */
		switchToVideoSlider: function() {
			// It's now a video slider, don't show thumbnails anymore
			this.isVideoSlider = true;

			// don't let the slider start autoHover again
			this.$bxSlider.off( '.autohover' );

			// Stop slider autoscroll because we're watching videos now
			this.$bxSlider.stopAuto();

			// hide all images so they don't show up on slide and show all videos
			// note: looping through slide.$image/$video doesn't work because it doesn't count clones
			this.$bxSlider.find( '.slide-image' ).hide()
				.find( '.slide-video' ).show();
		},

		/*
		 * @desc Toggle thumb row visibility using a timeout so hovering over controls will not hide thumbs
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
		},

		/*
		 * @desc Something has happened (like container resize) to invalidate cached embed data, so clear it.
		 */
		resetEmbedData: function() {
			var len = this.slides.length,
				i;

			for( i = 0; i < len; i++ ) {
				this.slides[ i ].embedData = null;
			}

		},

		initTitleEllipses: function() {
			var that = this,
				$titles = this.$thumbs.find( '.title' ).find( 'p' );

			$titles.each( function() {
				var $this = $( this );
				if( $this.height() > $this.parent().height() ) {
					that.doEllipses( $this );
				}
			});
		},

		doEllipses: function( $elem ) {
			var oText = $elem.text(),
				words = oText.split( ' ' ),
				len = words.length,
				i,
				$spans,
				lineCount = 0,
				maxLines = 2,
				spanTop = null,
				currSpanTop;

			for( i = 0; i < len; i++ ) {
				words[ i ] = '<span>' + words[ i ] + '</span>';
			}

			$elem.html( words.join( ' ' ) );

			$spans = $elem.find( 'span' );

			$spans.each( function() {
				var $this = $( this );

				currSpanTop = $this.offset().top;

				// if it's the first span, set the value and move on
				if( spanTop === null ) {
					spanTop = currSpanTop;
				} else if( lineCount === maxLines ) {
					// hide everthing if we've already reached our max lines
					$this.hide();
				} else {
					if( spanTop !== currSpanTop ) {
						// we're at a new line, increment lineCount
						lineCount += 1;
						// update span top with the new y coordinate
						spanTop = currSpanTop;
					}

					if( lineCount === maxLines ) {
						// hide the first word on the new line and the last word in the line before the max lines
						// reached
						$this.hide().prev().hide().before( '...' );
					}
				}
			});
		}
	};

	return Featured;
});
