// script of Online Status Bar extension
// created by Brion Vibber and Petr Bena

$(function() {

var $statusbar = $('#status-top'),
	$iconbar = $('.onlinestatusbaricon');

// Only do the rest if we have the statusbar!
if ($statusbar.length > 0) {
	function updateOnlineStatusBar() {
		// ... code to fetch and update
		$.ajax({
			url: mw.config.get('wgScriptPath') + '/api' + mw.config.get('wgScriptExtension'),
			data: {
				action: "query",
				prop: "onlinestatus",
				onlinestatususer: mw.config.get('wgTitle'),
				format: 'json'
			},
			success: function( data ) {
				// code to update the statusbar based on the returned message
				var statusMap = {
					offline:'red',
					online:'green',
					away:'orange',
					busy:'orange'
				};
				var imgName = statusMap[data.onlinestatus.result] + '.png';
				var $icon = mw.html.element('img', {
					src: mw.config.values.wgExtensionAssetsPath + "/OnlineStatusBar/resources/images/status" + imgName
				});
				$statusbar.html(mw.msg('onlinestatusbar-line', mw.config.get('wgTitle'),$icon,mw.msg('onlinestatusbar-status-' + data.onlinestatus.result)));
			}
		});
	}

	// Update the status every couple minutes if we leave the page open
	window.setInterval(updateOnlineStatusBar, 120 * 1000);
	updateOnlineStatusBar();
}

});
