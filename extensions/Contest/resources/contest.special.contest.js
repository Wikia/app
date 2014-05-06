/**
 * JavasSript for the Contest MediaWiki extension.
 * @see https://www.mediawiki.org/wiki/Extension:Contest
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $, mw ) { $( document ).ready( function() {

	var _this = this;

	this.sendReminder = function( callback ) {
		var requestArgs = {
			'action': 'mailcontestants',
			'format': 'json',
			'token': $( '#send-reminder' ).attr( 'data-token' ),
			'contestids': $( '#send-reminder' ).attr( 'data-contest-id' )
		};

		$.post(
			wgScriptPath + '/api.php',
			requestArgs,
			function( data ) {
				callback( data );
			}
		);
	};

	this.showReminderDialog = function() {
		var $dialog = null;

		$dialog = $( '<div />' ).html( '' ).dialog( {
			'title': mw.msg( 'contest-contest-reminder-title' ),
			'minWidth': 550,
			'buttons': [
				{
					'text': mw.msg( 'contest-contest-reminder-send' ),
					'id': 'reminder-send-button',
					'click': function() {
						var $send = $( '#reminder-send-button' );
						var $cancel = $( '#reminder-cancel-button' );

						$send.button( 'option', 'disabled', true );
						$send.button( 'option', 'label', mw.msg( 'contest-contest-reminder-sending' ) );

						_this.sendReminder( function( data ) {
							if ( data.success ) {
								$dialog.msg( 'contest-contest-reminder-success', data.contestantcount );
								$send.remove();
								$cancel.button( 'option', 'label', mw.msg( 'contest-contest-reminder-close' ) );
							}
							else {
								$send.button( 'option', 'label', mw.msg( 'contest-contest-reminder-retry' ) );
								$send.button( 'option', 'disabled', false );

								alert( window.gM( 'contest-contest-reminder-failed', data.contestantcount ) );
							}
						} );
					}
				},
				{
					'text': mw.msg( 'contest-contest-reminder-cancel' ),
					'id': 'reminder-cancel-button',
					'click': function() {
						$dialog.dialog( 'close' );
					}
				}
			]
		} );

		$dialog.append( $( '<p />' ).text( mw.msg( 'contest-contest-reminder-preview' ) ) ).append( '<hr />' );

		$dialog.append( $( '<p />' )
			.html( $( '<b />' )
				.text( mw.msg( 'contest-contest-reminder-subject' ) ) )
				.append( ' ' + $( '#send-reminder' ).attr( 'data-reminder-subject' ) ) )
			.append( '<hr />' );

		$dialog.append( $( '#reminder-content' ).html() );
	};

	$( '.contest-pager-clear' ).click( function() {
		var $form = $( this ).closest( 'form' );
		$form.find( 'select' ).val( '' );
		$form.submit();
		return false;
	} );
	
	$( '#send-reminder' ).button().click( this.showReminderDialog );

} ); })( window.jQuery, window.mediaWiki );
