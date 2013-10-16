define( 'models.videohomepage.featured', [ 'jquery' ], function( $ ) {

	'use strict';

	function Featured( options ) {
		this.thumbs = this.createThumbs( options.$thumbs );
		this.slides = this.createSlides( options.$slides );
	}

	Featured.prototype = {
		createThumbs: function( $thumbs ) {
			var thumbs = [];

			$thumbs.find( '.video' ).each( function() {
				thumbs.push({
					$video: $( this )
				});
			});

			return thumbs;
		},
		createSlides: function( $slides ) {
			var that = this,
				slides = [];

			$slides.each( function() {
				var $this = $( this );

				slides.push({
					$elem: $this,
					$video: $this.find( '.slide-video' ),
					$videoThumb: that.thumbs[ slides.length ].$video,
					$image: $this.find( '.slide-image' ),
					videoKey: that.thumbs[ slides.length ].$video.children( 'img' ).attr( 'data-video-key' ),
					embedData: null
				});
			});

			return slides;
		}
	};

	return Featured;
});
