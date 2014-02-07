/* global Features */
define( 'tables', ['events', 'track', 'wikia.window', 'jquery'], function ( ev, track, w, $ ) {
	'use strict';

	var d = w.document,
		pageContent = d.getElementById( 'mw-content-text' ) || d.getElementById( 'wkMainCnt' ),
		realWidth = pageContent.offsetWidth,
		initialized = false,
		handledTables = $();

	function check () {
		var table,
			isWrapped,
			isBig,
			x = 0,
			y = handledTables.length;

		realWidth = pageContent.offsetWidth;

		for ( ; x < y; x++ ) {
			table = handledTables.eq( x );
			isBig = table[0].scrollWidth > realWidth;
			isWrapped = table.parent().is( '.bigTable' );

			if ( isBig && !isWrapped ) {
				table.wrap( '<div class="bigTable" />' );
			} else if ( !isBig && isWrapped ) {
				table = table.unwrap()[0];

				if ( table.wkScroll ) {
					table.wkScroll.destroy();
					table.wkScroll = null;
				}
			}
		}
	}

	function process ( tables ) {
		//if the table width is bigger than any screen dimension (device can rotate)
		//then wrap it and add it to
		//the list of handled tables for speeding up successive calls
		handledTables = tables.add( handledTables );

		tables.filter( function ( index, element ) {
			var tr = $( element ).find( 'tr' ),
				trLength = tr.length,
				correctRows = 0,
				l,
				i = 0;

			if ( trLength > 2 ) {
				//sample only the first X rows
				tr = tr.slice( 0, 9 );
				l = tr.length;

				for ( ; i < l; i++ ) {
					if ( tr[i].cells.length === 2 ) {
						correctRows++;
					}
				}
			}

			return correctRows > Math.floor( trLength / 2 );
		} ).addClass( 'infobox' );

		tables.filter( function ( index, element ) {
			return element.scrollWidth > realWidth;
		} ).wrap( '<div class="bigTable" />' );

		if ( !initialized && handledTables.length > 0 ) {
			initialized = true;

			w.addEventListener( 'viewportsize', check );

			if ( !Features.overflow ) {
				$( d.body ).on( ev.touch, '.bigTable', function () {
					var table = this.getElementsByTagName( 'table' )[0];

					if ( !table.wkScroll ) {
						table.wkScroll = new w.IScroll( this, {
							eventPassthrough: true,
							click: true,
							scrollY: false,
							scrollX: true
						} );

						table.wkScroll.on( 'scrollEnd', function (){
							track.event( 'tables', track.SWIPE );
						} );

						this.className += ' active';
					}
				} );
			}
		}
	}

	return {
		process: process,
		check: check
	};
} );
