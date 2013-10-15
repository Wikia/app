(function( exports ) {
		'use strict';
		var factory = function( $ ) {
			function Ellipses( $el ) {
				this.$el = $el;
				this.render();
			}

			Ellipses.prototype = {
				render: function() {
					console.log(this.$el);
					var oText = this.$el.text(),
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

					this.$el.html( words.join( ' ' ) );

					$spans = this.$el.find( 'span' );

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
								// hide the first word on the new line and the last word in
								// the line before the max lines
								// reached
								$this.hide().prev().hide().before( '...' );
							}
						}
					});
				}
			};

			$.fn.ellipses = function() {

				return this.each(function() {
						var $this = $( this );
						$this.data( 'ellipses', new Ellipses( $this ));
				});
			};
		};

		if ( typeof define === 'function' && define.amd ) {
			define( 'jquery.ellipses', [ 'jquery' ], factory );
		} else {
			factory( exports.jQuery );
		}
})( this );
