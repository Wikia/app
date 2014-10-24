$(function(){
	$('#fbConnectDisconnect').click(function() {
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

	// BugId:93549
	$.loadFacebookAPI(function() {
		FB.XFBML.parse(document.getElementById('preferences'));
		// BugId:19603
		fixXFBML('fbPrefsConnect');
	});
});
