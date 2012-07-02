/**
 * JavasSript for the Special:UploadCampaigns of the UploadWizard MediaWiki extension.
 * @see https://secure.wikimedia.org/wikipedia/mediawiki/wiki/Extension:UploadWizard
 * 
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $ ) { $( document ).ready( function() {
	
	function deleteCampaign( options, successCallback, failCallback ) {
		$.post(
			wgScriptPath + '/api.php',
			{
				'action': 'deleteuploadcampaign',
				'format': 'json',
				'ids': options.id,
				'token': options.token
			},
			function( data ) {
				if ( data.success ) {
					successCallback();
				} else {
					failCallback( mw.msg( 'mwe-upwiz-campaigns-delete-failed' ) );
				}
			}
		);	
	}
	
	$( '.campaign-delete' ).click( function() {
		$this = $( this );
		
		if ( confirm( mw.msg( 'mwe-upwiz-campaigns-confirm-delete' ) ) ) {
			deleteCampaign(
				{
					id: $this.attr( 'data-campaign-id' ),
					token: $this.attr( 'data-campaign-token' )
				},
				function() {
					$this.closest( 'tr' ).slideUp( 'slow', function() { $( this ).remove(); } );
				},
				function( error ) {
					alert( error );
				}
			);
		}
		return false;
	} );
	
} ); })( jQuery );