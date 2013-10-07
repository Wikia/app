/* @desc Open the Lightbox when when TouchStorm videos are clicked
 * @see Lightbox extension
 * @author lizlux
 */
define( 'wikia.touchstorm', [], function() {
	'use strict';

	function TouchStorm() {
		if( !window.wgEnableLightboxExt ) {
			throw 'Lightbox must be enabled for TouchStorm to work.';
		}
		this.wrapper = $( '#TouchStormModule' );
		this.lightboxInited = false;
		this.init();
	}

	TouchStorm.prototype = {
		init: function() {
			this.bindEvents();
		},

		bindEvents: function() {
			var that = this;

			// bind click even to all touchstorm DOM elements that should open the lightbox
			this.wrapper.on( 'click', 'img, p', function() {
				that.handleClick( $( this ) );
			});

			// called from Lightbox.js, so we know the Lightbox code is fully loaded.
			$( window ).on( 'lightboxOpened', $.proxy( this.setupLightbox, this ) );
		},

		/* @desc when a touchstorm video is clicked, load the lightbox
		 * @return void
		 */
		handleClick: function( $elem ) {
			var that = this,
				videoKey = this.getKeyFromUrl( $elem.attr( 'url' ) );

			window.LightboxLoader.loadLightbox( videoKey, {
				parent: that.wrapper,
				carouselType: 'touchStorm',
				clickSource: 'touchStorm'
			});
		},

		/* @desc Plug touchstorm into Lightbox.  Note: we had to wait until the 'lightboxOpened' event to ensure the
		 * Lightbox code was fully loaded.
		 * @return void
		 */
		setupLightbox: function() {
			if( !this.lightboxInited ) {
				this.getVideoList();

				// Add touchstorm to carousel types
				window.Lightbox.carouselTypes.splice( 1, 0, 'touchStorm' );
				window.LightboxLoader.cache.touchStorm = [];

				// Add method for collecting touchstorm thumbs for carousel
				window.Lightbox.getMediaThumbs.touchStorm = $.proxy( this.getCarouselThumbs, this );

				// Make sure this code runs once
				this.lightboxInited = true;
			}
		},

		/* @desc Get data from touchstorm videos to be sent to getCarouselThumbs
		 * @return void
		 */
		getVideoList: function() {
			var that = this,
				videos = [];

			this.wrapper.find( '.veeseoRCWInlineVItem' ).each( function() {
				var $this = $( this ),
					p = $this.find( '.veeseoRCWInlineVItemContentLabel' );

				videos.push({
					key: that.getKeyFromUrl( p.attr( 'url' ) ),
					thumb: $this.find( '.veeseoRCWInlineVItemImg' ).attr( 'src' ),
					title: p.text()
				});
			});

			this.videoList = videos;
		},

		/* @desc Add another carousel thumb method to Lightbox in order to populate the lightboxcarousel
		 * @return void
		 */
		getCarouselThumbs: function( backfill ) {
			var cached = window.LightboxLoader.cache.touchStorm,
				thumbArr = [],
				playButton = window.Lightbox.thumbPlayButton,
				videoIds = this.videoList,
				i,
				arrLength,
				key,
				title;

			if( cached.length ) {
				thumbArr = cached;
			} else {

				for( i = 0, arrLength = videoIds.length; i < arrLength; i++ ) {
					key = videoIds[i].key;
					title = videoIds[i].title;

					thumbArr.push({
						thumbUrl: window.Lightbox.thumbParams( videoIds[ i ].thumb, 'video' ),
						key: key,
						title: title,
						type: 'video',
						playButtonSpan: playButton
					});
				}

				// Fill touchStorm cache
				window.LightboxLoader.cache.touchStorm = thumbArr;

				// Count backfill items for progress bar
				if( backfill ) {
					window.Lightbox.backfillCount += thumbArr.length;
				}

			}

			// Add thumbs to current lightbox cache
			window.Lightbox.current.thumbs = window.Lightbox.current.thumbs.concat( thumbArr );

			window.Lightbox.addThumbsToCarousel( thumbArr, backfill );

		},

		/* @desc Parse URL for video key.
		 * @todo: It's possible that "File:" could be in the video key, so we may want to handle this edge case at a
		 * later date.
		 * @return string Video key
		 */
		getKeyFromUrl: function( url ) {
			return url.split( 'File:' )[ 1 ];
		}
	};

	return TouchStorm;
});

require( [ 'wikia.touchstorm' ], function( TouchStorm ) {
	'use strict';

	$( function() {
		return new TouchStorm();
	});
});