
var ShareFeature = {};
var ShareFeatureEnabled = false;

ShareFeature.ajax = function( provider ) {
	$.post( wgScript + '?action=ajax&rs=wfShareFeatureAjaxUpdateStats', {
		 'provider' : provider
		}, function() {}
	);
};

$(function() {
		$G('control_share_feature').className = 'enabled';
		// open dialog on clicking
		$('#ca-share_feature').click(function() {
			if( false == ShareFeatureEnabled ) {
				ShareFeatureEnabled = true;
				$().getModal(
					wgScript + '?action=ajax&rs=wfShareFeatureAjaxGetDialog&title=' + encodeURIComponent(wgPageName) + '&wiki=' + wgCityId,
					'#shareFeatureRound',
					{
						width: 300,
						callback: function() {
							ShareFeatureEnabled = false;
						}
					}
				);
			}
		});
});
