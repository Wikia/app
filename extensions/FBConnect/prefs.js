/* global FB, wgServer, wgScript */

function enableDisablePushAllow(force_enable) {
	var inputNever = $('#fbconnect-push-allow-never');
	var inputs = inputNever.closest('fieldset').find('input');
	var input;
	for (var i = 0; i < inputs.length; i++){
		input = $(inputs[i]);

		if(input.attr('id').indexOf('fbconnect-push-allow') || input.attr('id') != 'fbconnect-push-allow-never') {
			if (inputNever.attr('checked') && (!force_enable)) {
				input.attr('disabled','disabled');
			} else {
				input.removeAttr('disabled');
			}

		}
	}
}


$(function(){
	'use strict';

	$('#fbConnectDisconnect').click(function() {
		$('#fbConnectDisconnectDone').hide();
		$('#fbDisconnectProgress').show();
		$.postJSON(wgServer + wgScript + "?action=ajax&rs=FBConnect::disconnectFromFB" ,
			null,
		function(data) {
			if (data.status === "ok") {
				$('#fbDisconnectLink').hide();
				$('#fbDisconnectProgressImg').hide();
				$('#fbDisconnectDone').show();
				$('#fbConnectDisconnectDone').show();

				// Wikia - UC-18
				window.Wikia.Tracker.track({
					category: 'user-sign-up',
					trackingMethod: 'both',
					action: window.Wikia.Tracker.ACTIONS.CLICK,
					label: 'fb-disconnect'
				});
				// Wikia end
			} else {
				window.location.reload();
			}
		});
	});

	$('#fbconnect-push-allow-never').change( function() { enableDisablePushAllow(false); });
	enableDisablePushAllow(false);
	$('#mw-preferences-form').submit(function() { enableDisablePushAllow(true); });

	// BugId:93549
	$.loadFacebookAPI(function() {
		FB.XFBML.parse(document.getElementById('preferences'));
		// BugId:19603
		fixXFBML('fbPrefsConnect');
	});
});
