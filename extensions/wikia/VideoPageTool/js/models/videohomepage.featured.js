define('vpt.models.featured', [ 'jquery' ], function( $ ) {

	'use strict';

	function Featured( options ) {
		this.slides = this.createSlides( options.slides );
		this.thumbs = this.createThumbs( options.thumbs );
		this.init();
	}

	Featured.prototype = {
		init: function() {

		},
		createThumbs: function( $thumbs ) {
			var thumbs = [];

			$thumbs.each( function() {
				var $this = $( this );

				thumbs.push({
					$elem: $this
				});
			});

			return thumbs;
		},
		createSlides: function( $slides ) {
			var slides = [];

			$slides.each( function() {
				var $this = $( this );

				slides.push({
					$elem: $this,
					$video: $this.find( '.slide-video' ),
					$image: $this.find( '.slide-image' ),
					current: 'image',
					embedData: null
				});
			});

			return slides;
		},
		addVideoEmbedData: function( slide, data) {
			slide.embedData = data;
		},
		switchToVideo: function( slide ) {

		},
		switchToImage: function( slide ) {

		}
	};

	return Featured;
});
