/**
 * jQuery Zid v0.9
 *
 * Terms of Use - Zid
 * under the MIT (http://www.opensource.org/licenses/mit-license.php) License.
 *
 * Copyright 2013 Wikia. All rights reserved.
 * ( https://github.com/kvas-damian/zid )
 *
 * Requires jQuery throttle plugin: http://benalman.com/projects/jquery-throttle-debounce-plugin/
 *
 */


// Zid magic

( function( $ ) {
	'use strict';
	var Zid = function( options, element ) {
		this.element = $( element );
		this._init( options );
	};

	Zid.settings = {
		selector: '.item',
		minColumnWidth: 225,
		gutter: 20,
		ThrottleThreshold: 50,
		onColumnCountChangeCallback: null
	};

	Zid.prototype = {
		/**
		 * Initialize Zid and render items in columns
		 * @param object options - see Zid.settings
		 * @private
		 */
		_init: function( options ) {
			var container = this;
			this.cols = 0;
			this.name = Math.random().toString( 36 ).substr( 7 );
			this.box = this.element;
			this.options = $.extend( true, {}, Zid.settings, options );
			this.itemsArr = $.makeArray( this.box.find( this.options.selector ) );
			this.minBreakPoint = 1;
			this.maxBreakPoint = 1;
			this.onColumnCountChangeCallback = this.options.onColumnCountChangeCallback;

			this.columns = [];

			// build columns
			this._setCols();
			// render items in columns
			this._renderItems( 'append', this.itemsArr );
			// add class 'zid' to container
			$( this.box ).addClass( 'zid' );
			// bind on resize
			$( window ).on( 'resize', $.throttle( this.options.ThrottleThreshold, $.proxy( container.resize, this ) ) )
				.on( 'orientationchange', $.proxy( container.resize, this ));
		},

		/**
		 * Create and append columns to zid container
		 * @private
		 */
		_setCols: function() {
			var i,
				div,
				clear = $( '<div></div>' ).css( {
					'clear': 'both',
					'height': '0',
					'width': '0',
					'display': 'block'
				} ).attr( 'id', 'clear' + this.name );
			// calculate columns count
			this.cols = Math.floor( this.box.width() / ( this.options.minColumnWidth + this.options.gutter ) );
			// We should always render at least one column
			if ( this.cols < 1 ) {
				this.cols = 1;
			}
			// add columns to box
			for ( i = 0; i < this.cols; i++ ) {
				div = $( '<div></div>' ).addClass( 'zidcolumn' ).css( {
					'width': this._getColumnWidthStyle(),
					'paddingLeft': ( i === 0 ) ? 0 : this.options.gutter,
					'paddingBottom': this.options.gutter,
					'float': 'left'
				});
				this.box.append( div );
				this.columns.push( div );
			}


			this.box.find( $( '#clear' + this.name ) ).remove();
			// add clear float
			this.box.append( clear );
			this._setbreakPoints();
		},

		/**
		 * Set breakpoint on which we need to re-render whole zid
		 * @private
		 */
		_setbreakPoints: function() {
			this.maxBreakPoint = ( this.cols + 1 ) * ( this.options.minColumnWidth + this.options.gutter );
			this.minBreakPoint = ( this.cols <= 1 ) ?
				1 :
				this.cols * ( this.options.minColumnWidth + this.options.gutter );
		},

		/**
		 * Get width style for zid column
		 * @returns {string}
		 * @private
		 */
		_getColumnWidthStyle: function() {
			var out = 'calc(' + ( 100 / this.cols ) + '% - ' +
				( ( ( this.cols - 1 ) * this.options.gutter ) / this.cols ) + 'px )';

			if ($.browser.webkit) {
				out = '-webkit-' + out;
			}

			return out;
		},

		/**
		 * Render items in zid
		 * @param String method - 'append' or 'prepend'
		 * @param Array arr array of items that should be added to zid
		 * @private
		 */
		_renderItems: function( method, arr ) {
			// push out the items to the columns
			$.each( arr, $.proxy(
				function( index, value ) {
					var item = $( value ),
						col = this._getShortestColumn();
					// prepend on append to column
					if ( method === 'prepend' ) {
						col.prepend( item );
					} else {
						col.append( item );
					}
				},
				this
			));
		},

		/**
		 * Get shortest columns from zid columns.
		 * In most cases this is the column when we're going to add next item
		 * @private
		 */
		_getShortestColumn: function() {
			var shortest = this.columns[ 0 ],
				shortestHeight = shortest.height();

			$.each( this.columns, function( index, currentColumn ) {
				var currHeight = currentColumn.height();
				if ( currHeight < shortestHeight ) {
					shortest = currentColumn;
					shortestHeight = currHeight;
				}
			});

			return shortest;
		},

		/**
		 * repaint whole zid
		 */
		repaint: function() {
			// hide columns in box
			var oldCols = this.box.find( $( '.zidcolumn' ) );
			this.columns = [];
			// build columns
			this._setCols();

			if ( typeof this.onColumnCountChangeCallback === 'function' ) {
				this.onColumnCountChangeCallback(this.cols, this.itemsArr);
			}

			// render items in columns
			this._renderItems( 'append', this.itemsArr );
			oldCols.remove();
		},

		/**
		 * Window resize callback. When we reach breakpoint then it repaints zid
		 */
		resize: function() {
			var boxWidth = this.box.width();
			if ( boxWidth < this.minBreakPoint || boxWidth >= this.maxBreakPoint ) {
				this.repaint();
			}
		},

		/**
		 * Add new elements to zid at the end
		 * @param items
		 */
		append: function( items ) {
			this.itemsArr = this.itemsArr.concat( $.makeArray( items ) );
			this._renderItems( 'append', items );
		},

		/**
		 * Add elements to zid at the beginning
		 * @param items
		 */
		prepend: function( items ) {
			this.itemsArr = $.makeArray( items ).concat( this.itemsArr );
			this._renderItems( 'prepend', items );
		}
	};

	$.fn.zid = function( options, e ) {
		if ( typeof options === 'string' ) {
			this.each( function() {
				var container = $.data( this, 'zid' );
				container[ options ].apply( container, [ e ] );
			});
		} else {
			this.each( function() {
				$.data( this, 'zid', new Zid( options, this ) );
			} );
		}
		return this;
	};
} )( jQuery );
