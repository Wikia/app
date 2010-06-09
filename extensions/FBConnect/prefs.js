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
	$('#fbConnectDisconnect').click(
	function() {
		$('#fbConnectDisconnectDone').hide();
		$('#fbDisconnectProgress').show();
		$.postJSON(wgServer + wgScript + "?action=ajax&rs=FBConnect::disconnectFromFB" , 
			null, 
		function(data) {
			if (data.status = "ok") {
				$('#fbDisconnectLink').hide();
				$('#fbDisconnectProgressImg').hide();
				$('#fbDisconnectDone').show();
				$('#fbConnectDisconnectDone').show();
			} else {
				window.location.reload();
			}	
		});
	});

	$('#fbconnect-push-allow-never').change( function() { enableDisablePushAllow(false); });
	enableDisablePushAllow(false);
	$('#mw-preferences-form').submit(function() { enableDisablePushAllow(true); });
});

