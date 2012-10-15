/**
 * Filter checking for examine
 */
new ( function( $, mw ) {
	/**
	 * Reference to this
	 */
	var that = this;

	/**
	 * Syntax result div
	 *
	 * @type {jQuery}
	 */
	var $syntaxResult = $( '#mw-abusefilter-syntaxresult' );

	/**
	 * Tests the filter against an rc event or abuse log entry
	 */
	this.examinerTestFilter = function() {
		var filter = $( '#wpTestFilter' ).val(),
			examine = mw.config.get( 'abuseFilterExamine' ),
			params = {};
		$( this ).injectSpinner( 'filter-check' );

		if ( examine.type == 'rc' ) {
			params = {
				rcid: examine.id
			}
		} else {
			params = {
				logid: examine.id
			}
		}

		// Large amount of data
		$.post(
			mw.util.wikiScript( 'api' ), $.extend( params, {
				action: 'abusefiltercheckmatch',
				filter: filter,
				format: 'json'
			} ), that.examinerTestProcess, 'json'
		);
	};

	/**
	 * Processes the results of the filter test
	 *
	 * @param {Object} data
	 */
	this.examinerTestProcess = function( data ) {
		var msg;
		$.removeSpinner( 'filter-check' );

		if ( data.error !== undefined ) {
			// Hmm, something went awry
			if ( data.error.code == 'badsyntax' ) {
				$syntaxResult.attr(
					'class', 'mw-abusefilter-examine-syntaxerror'
				);
				msg = 'abusefilter-examine-syntaxerror';
			} else if ( data.error.code == 'nosuchrcid'
				|| data.error.code == 'nosuchlogid'
			) {
				msg = 'abusefilter-examine-notfound';
			} else if ( data.error.code == 'nopermission' ) {
				return;
			}
		} else {
			var exClass;
			if ( data.abusefiltercheckmatch.result ) {
				exClass = 'mw-abusefilter-examine-match';
				msg = 'abusefilter-examine-match';
			} else {
				exClass = 'mw-abusefilter-examine-nomatch';
				msg = 'abusefilter-examine-nomatch';
			}
			$syntaxResult.attr( 'class', exClass );
		}

		$syntaxResult
			.text( mw.msg( msg ) )
			.show();
	};

	$( function( $ ) {
		$( '#mw-abusefilter-examine-test' ).click( that.examinerTestFilter );
	} );
} )( jQuery, mediaWiki );