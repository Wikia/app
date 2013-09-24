define( 'wikia.touchstorm', [], function() {
	'use strict';

	function TouchStorm() {
		this.wrapper = $( '#TouchStormModule' );
		this.lightboxInited = false;
		this.init();
	}

	TouchStorm.prototype = {
		init: function() {
			this.bindEvents();
		},
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
		bindEvents: function() {
			var that = this;

			this.wrapper.on( 'click', 'img, p', function() {
				// TODO: maybe use loader() to know when script is loaded and dom is ready?
				that.handleClick( $( this ) );
			});

			$( window ).on( 'lightboxOpened', $.proxy( this.setupLightbox, this ) );
		},
		handleClick: function( $elem ) {
			var that = this,
				videoKey = this.getKeyFromUrl( $elem.attr( 'url' ) );

			window.LightboxLoader.loadLightbox( videoKey, { parent: that.wrapper, carouselType: 'touchStorm' } );
		},
		setupLightbox: function() {

			if( !this.lightboxInited ) {
				this.getVideoList();

				// Add touchstorm to carousel types
				window.Lightbox.carouselTypes.splice( 1, 0, 'touchStorm' );
				window.LightboxLoader.cache.touchStorm = [];

				// Add method for collecting touchstorm thumbs for carousel
				window.Lightbox.getMediaThumbs.touchStorm = $.proxy( this.getCarouselThumbs, this );

				this.lightboxInited = true;
			}
		},
		getCarouselThumbs: function( backfill ) {
console.log(this);
			var cached = window.LightboxLoader.cache.touchStorm,
				thumbArr = [],
				playButton = window.Lightbox.thumbPlayButton,
				videoIds = this.videoList,
				i,
				arrLength,
				key,
				title;

			if(cached.length) {
				thumbArr = cached;
			} else {

				for(i = 0, arrLength = videoIds.length; i < arrLength; i++) {
					key = videoIds[i].key;
					title = videoIds[i].title;

					thumbArr.push({
						thumbUrl: window.Lightbox.thumbParams(videoIds[i].thumb, 'video'),
						key: key,
						title: title,
						type: 'video',
						playButtonSpan: playButton
					});

				}

				// Fill touchStorm cache
				window.LightboxLoader.cache.touchStorm = thumbArr;

				// Count backfill items for progress bar
				if(backfill) {
					window.Lightbox.backfillCount += thumbArr.length;
				}

			}

			// Add thumbs to current lightbox cache
			window.Lightbox.current.thumbs = window.Lightbox.current.thumbs.concat(thumbArr);

			window.Lightbox.addThumbsToCarousel(thumbArr, backfill);

		},
		// Parse URL for video key
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