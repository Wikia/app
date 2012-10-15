/* Scap roadmap viewer, version [0.0.7]
 * Originally from: http://www.mediawiki.org/wiki/User:Splarka/scapmap.js
 *
 *
 * Loads on, for example: http://www.mediawiki.org/wiki/Special:Code/MediaWiki
 * Click [overview] to generate map.
 * Text in the "path" input box is stripped from the path line in the summary.
 * Clicking a colored box takes you to that relevant line, and a backlink is created in the id column on focus.
 * Hovering over a colored box pops up a little info packet box.
 */
jQuery( function( $ ) {
	// check if we're on a page with a useful list of revisions
	if( $( '#path' ).size() && $('table.TablePager').size() ) {
		var portlet = $( '#p-namespaces' ).size() ? 'p-namespaces' : 'p-cactions';
		mw.util.addPortletLink(
				portlet,
				'#',
				mw.msg( 'codereview-overview-title' ),
				'ca-scapmap',
				mw.msg( 'codereview-overview-desc' )
				);
	}

	$('#ca-scapmap').click( function () {
		var $tr = $('table.TablePager tr');
		if( $tr.size() < 2 ){
			return;
		} else if( $('#overviewmap').size() ) {
			// We've already created it; maybe they just want to toggle it on and off
			$('#overviewmap').slideToggle();
			return;
		}

		var overviewPopupData = {};

		$( '#contentSub' ).after( $( '<div id="overviewmap">' ) );
		$( '#overviewmap' ).slideUp( 0 );

		var vpath = $( '#path' ).val();
		var totals = {};
		$tr.each( function( i ){
			var status = false;

			var trc = $(this).attr( 'class' );
			if( !trc || !trc.length ) {
				return;
			} else {
				trc = trc.split( ' ' );
			}
			for( var j = 0; j < trc.length; j++ ) {
				if( trc[j].substring( 0, 21 ) == 'mw-codereview-status-' ) {
					status = trc[j].substring( 21 );
				}
			}
			var $td = $( 'td', $(this) );

			var statusname = $td.filter( '.TablePager_col_cr_status' ).text();

			if( !statusname || !status ) {
				return;
			}

			var rev = $td.filter( '.TablePager_col_cr_id, .TablePager_col_cp_rev_id' ).text();
			overviewPopupData[i] = {
				'status' : status,
				'statusname' : statusname,
				'notes' : $td.filter( '.TablePager_col_comments' ).text(),
				'author' : $td.filter( '.TablePager_col_cr_author' ).text(),
				'rev' : rev
			};

			var path = $td.filter( '.TablePager_col_cr_path' ).text();
			if( path && path.indexOf( vpath ) == 0 && path != vpath && vpath != '' ) {
				path = '\u2026' + path.substring( vpath.length );
			}
			overviewPopupData[i]['path'] = path;

			if( !totals[statusname] ) {
				totals[statusname] = 0;
			}
			totals[statusname]++;

			$(this).attr( 'id', 'TablePager-row-' + rev );

			$td.filter( '.TablePager_col_selectforchange' )
				.append( $( '<a href="#box-' + i + '" class="overview-backlink">^</a>' ) );

			var $box = $( '<a href="#TablePager-row-' + rev + '" class="mw-codereview-status-' + status + '" id="box-' + i + '"> </a>' );
			$( '#overviewmap' ).append( $box );
		});

		var sumtext = [];
		for( var i in totals ) {
			if( typeof i != 'string' || typeof totals[i] != 'number' ) {
				continue;
			}
			sumtext.push( i + ': ' + totals[i] );
		}
		sumtext.sort();
		var $summary = $( '<div class="summary">' )
			.text( 'Total revisions: ' + ( $tr.size() - 1 ) + '. [' + sumtext.join(', ') + ']' );

		$( '#overviewmap' )
			.append( $summary )
			.css( 'max-width', Math.floor( Math.sqrt( $tr.size() ) ) * 30 )
			.slideDown();

		// Add the hover popup
		$( '#overviewmap > a' )
			.mouseenter( function () {

			var $el = $( this );
				if ( $el.data('overviewPopup') ) {
					return; // already processed
				}
				$el.tipsy( { fade: true, gravity: 'sw', html:true } );
				var id = parseInt( $(this).attr( 'id' ).replace( /box\-/i, '' ) );

				var $popup = $( '<div id="overviewpop">' +
					'<div>Rev: r<span id="overviewpop-rev">' + overviewPopupData[id]['rev'] +
					'</span> (<span id="overviewpop-status">' + overviewPopupData[id]['status'] + '</span>)</div>' +
					'<div>Number of notes: <span id="overviewpop-notes">' + overviewPopupData[id]['notes'] + '</span></div>' +
					'<div>Path: <span id="overviewpop-path">' + overviewPopupData[id]['path'] + '</span></div>' +
					'<div>Author: <span id="overviewpop-author">' + overviewPopupData[id]['author'] + '</span></div>' +
					'</div>')
				$el.attr( 'title', $popup.html() );
				$el.data( 'codeTooltip', true );
				$el.tipsy( 'show' );
			});
	});
} );
