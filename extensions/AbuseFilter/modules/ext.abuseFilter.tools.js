/**
 * AbuseFilter tools JS
 */
new ( function( $, mw ) {
	/**
	 * Reference to this
	 */
	var that = this;

	/**
	 * Submits the expression to be evaluated
	 */
	this.doExprSubmit = function() {
		var expr = $( '#wpTestExpr' ).val();
		$( this ).injectSpinner( 'abusefilter-expr' );
		$.getJSON(
			mw.util.wikiScript( 'api' ), {
				action: 'abusefilterevalexpression',
				expression: expr,
				format: 'json'
			}, that.processExprResult
		);
	};

	/**
	 * Processes the result of the evaluation
	 *
	 * @param {Object} data
	 */
	this.processExprResult = function( data ) {
		$.removeSpinner( 'abusefilter-expr' );

		$( '#mw-abusefilter-expr-result' )
			.text( data.abusefilterevalexpression.result );
	};

	/**
	 * Submits a call to unblock autopromotions for a user
	 */
	this.doReautoSubmit = function() {
		var name = $( '#reautoconfirm-user' ).val();

		if ( name == '' ) {
			return;
		}

		$( this ).injectSpinner( 'abusefilter-reautoconfirm' );
		$.post(
			mw.util.wikiScript( 'api' ), {
				action: 'abusefilterunblockautopromote',
				user: name,
				token: mw.user.tokens.get( 'editToken' ),
				format: 'json'
			}, that.processReautoconfirm, 'json'
		);
	};

	/**
	 * Processes the result of the unblocking autopromotions for a user
	 * 
	 * @param {Object} data
	 */
	this.processReautoconfirm = function( data ) {
		var msg;

		if ( data.error !== undefined ) {
			switch ( data.error.code ) {
				case 'permissiondenied':
					msg = mw.msg( 'abusefilter-reautoconfirm-notallowed' );
					break;
				case 'notsuspended':
					msg = data.error.info;
					break;
			}
		} else {
			msg = mw.message( 'abusefilter-reautoconfirm-done', data.abusefilterunblockautopromote.user ).toString();
		}

		mw.util.jsMessage( msg );

		$.removeSpinner( 'abusefilter-reautoconfirm' );
	};

	$( function( $ ) {
		$( '#mw-abusefilter-submitexpr' ).click( that.doExprSubmit );
		$( '#mw-abusefilter-reautoconfirmsubmit' ).click( that.doReautoSubmit );
	} );

})( jQuery, mediaWiki );