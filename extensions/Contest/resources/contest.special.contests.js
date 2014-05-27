/**
 * JavasSript for the Contest MediaWiki extension.
 * @see https://www.mediawiki.org/wiki/Extension:Contest
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $, mw ) { $( document ).ready( function() {

	function deleteContest( options, successCallback, failCallback ) {
		$.post(
			wgScriptPath + '/api.php',
			{
				'action': 'deletecontest',
				'format': 'json',
				'ids': options.id,
				'token': options.token
			},
			function( data ) {
				if ( data.success ) {
					successCallback();
				} else {
					failCallback( mw.msg( 'contest-special-delete-failed' ) );
				}
			}
		);
	}

	$( '.contest-delete' ).click( function() {
		$this = $( this );

		if ( confirm( mw.msg( 'contest-special-confirm-delete' ) ) ) {
			deleteContest(
				{
					id: $this.attr( 'data-contest-id' ),
					token: $this.attr( 'data-contest-token' )
				},
				function() {
					$this.closest( 'tr' ).slideUp( 'slow', function() {
						$( this ).remove();

						if ( $( '.contests-table tr' ).length < 2 ) {
							$( '.contests-table' ).remove();
							$( '.contests-title' ).remove();
						}
					} );
				},
				function( error ) {
					alert( error );
				}
			);
		}
		return false;
	} );

} ); })( window.jQuery, window.mediaWiki );
