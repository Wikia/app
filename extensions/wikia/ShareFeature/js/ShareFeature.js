
var ShareFeature = {};
var ShareFeatureEnabled = false;

ShareFeature.ajax = function( provider ) {
	this.track( 'provider/' + provider );
	$.post( wgScript + '?action=ajax&rs=wfShareFeatureAjaxUpdateStats', {
		 'provider' : provider
		}, function() {
			$('#shareFeatureWrapper').closeModal();
		}
	);
};

ShareFeature.track = function( str ) {
	WET.byStr('ShareFeature/' + str);
};

$(function() {
		$G('control_share_feature').className = 'enabled';
		// open dialog on clicking
		$('#ca-share_feature').click(function() {
			if( false == ShareFeatureEnabled ) {
				ShareFeatureEnabled = true;
				$().getModal(
					wgScript + '?action=ajax&rs=wfShareFeatureAjaxGetDialog&title=' + encodeURIComponent(wgPageName) + '&wiki=' + wgCityId,
					'#shareFeatureInside',
					{
						id: 'shareFeatureWrapper',
						width: 300,
						callback: function() {
							ShareFeatureEnabled = false;
							ShareFeature.track( 'open' );
						},
						onClose: function() {
							ShareFeature.track('close');
						}
					}
				);
			}
		});
});
