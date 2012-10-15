$(function() {
	var toggle = $('#mw-input-unsubscribed');
	var form = toggle.closest( 'form' );

	var affectedInputs = '#mw-htmlform-email input[type="checkbox"], #mw-htmlform-wikiemail input[type="checkbox"], #mw-htmlform-emailv2 input[type="checkbox"], #mw-input-enotiffollowedpages, #mw-input-enotiffollowedminoredits, #mw-input-watchlistdigest';

	function UnsubscribeTogglePreferences() {
		var MailEnabled = !toggle.attr('checked');

		$( affectedInputs ).each(function() {
			if ( $(this).attr( 'id' ) == toggle.attr( 'id' ) ) {
				return;
			}

			if ( MailEnabled ) {
				if ($(this).attr('id').indexOf('mw-input-founderemails-') < 0) {
					$(this).attr('disabled', false);
				}
			} else {
				$(this).attr('disabled', true );
			}
		});
	}

	function UnsubscribeReenableBeforeSubmit() {
		$( affectedInputs ).attr('disabled', false );
	}

	toggle.click( UnsubscribeTogglePreferences );
	form.submit( UnsubscribeReenableBeforeSubmit );

	UnsubscribeTogglePreferences();
});
