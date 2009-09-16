
var ShareFeature = {};

ShareFeature.ajax = function( provider ) {
	$.getJSON( wgScript + '?action=ajax&rs=wfShareFeatureAjaxUpdateStats', {
		 'provider' : provider,
		}, function() {
		});
}

$(function() {
		// open dialog on clicking
		$('#ca-share_feature').click(function() {
			$().getModal(
				wgScript + '?action=ajax&rs=wfShareFeatureAjaxGetDialog&title=' + encodeURIComponent(wgPageName) + '&wiki=' + wgCityId,
				'#shareFeatureRound',
				{
					width: 300,
					callback: function() {}
				}
			);
		});
});
