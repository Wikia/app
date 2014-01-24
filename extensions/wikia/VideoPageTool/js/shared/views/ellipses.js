( function( exports ) {
	'use strict';
	var factory = function( $ ) {
		function Ellipses( $el, opts ) {
			this.$el = $el;
			if ( opts ) {
				$.extend( this.settings, opts );
			}
			this.render();
		}

		Ellipses.prototype = {
			settings: {
				maxLines: 2,
				// words hidden on last visible line
				wordsHidden: 1
			},
			render: function() {
				var oText = this.$el.text(),
						words = oText.split( ' ' ),
						len = words.length,
						i,
						$spans,
						lineCount = 0,
						maxLines = this.settings.maxLines,
						$tar,
						spanTop = null,
						currSpanTop,
						self;

				self = this;

				for( i = 0; i < len; i++ ) {
					words[ i ] = '<span>' + words[ i ] + '</span>';
				}

				this.$el.html( words.join( ' ' ) );

				$spans = this.$el.find( 'span' );

				for ( i = 0; i < $spans.length; i++ ) {
					$tar = $( $spans[i] );

					currSpanTop = $tar.offset().top;

					// if it's the first span, set the value and move on
					if ( spanTop === null ) {
						spanTop = currSpanTop;
					} else if ( lineCount === maxLines ) {
						// hide everthing if we've already reached our max lines
						$tar.hide();
					} else {
						if ( spanTop !== currSpanTop ) {
							// we're at a new line, increment lineCount
							lineCount += 1;
							// update span top with the new y coordinate
							spanTop = currSpanTop;
						}

						if ( lineCount === maxLines ) {
							// hide the first word on the new line and the nth word in
							// the line before the max lines
							// reached
							$tar
								.hide()
							.prevUntil( ':nth-child( ' + ( i - self.settings.wordsHidden )  + ' )' )
								.hide()
							.eq( 0 )
								.before( '<span class="ellipses">...</span>' );

							self.trimDashes();
						}
					}
				}
			},
			/**
			 * @description if the last span before the ... is a -, trim it
			 */
			trimDashes: function() {
				var $ellipses,
						$prev;
				$ellipses = this.$el.find( '.ellipses' );
				$prev = $ellipses.prev( 'span' );
				if ( $prev.text() === '-' ) {
					$prev.hide();
				}
			}
		};

		$.fn.ellipses = function( opts ) {
			return this.each( function() {
				var $this = $( this );
				$this.data( 'ellipses', new Ellipses( $this, opts ) );
			} );
		};
	};

	if ( typeof define === 'function' && define.amd ) {
		define( 'jquery.ellipses', [ 'jquery' ], factory );
	} else {
		factory( exports.jQuery );
	}
} )( this );
