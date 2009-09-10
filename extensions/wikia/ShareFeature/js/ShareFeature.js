
// open dialog on clicking

$(function() {
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
