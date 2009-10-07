
var ShareFeature = {};
var ShareFeatureEnabled = false;

ShareFeature.ajax = function( provider ) {
	$.post( wgScript + '?action=ajax&rs=wfShareFeatureAjaxUpdateStats', {
		 'provider' : provider
		}, function() {
			 $('.modalWrapper').closeModal();
		}
	);
};

ShareFeature.openDialog = function() {
	if( false == ShareFeatureEnabled ) {
		ShareFeatureEnabled = true;
		$().getModal(
			wgScript + '?action=ajax&rs=wfShareFeatureAjaxGetDialog&title=' + encodeURIComponent(wgPageName) + '&wiki=' + wgCityId,
				'#shareFeatureInside',
			{
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
}

ShareFeature.mouseDown = function( provider ) {
	var event = $.getEvent();
	switch( event.button ) {
		case 0:
			this.ajax( provider );
			this.track( 'leftClick/' + provider );
			break;
		case 1:
			this.ajax( provider );
			this.track( 'middleClick/' + provider  );
			break;
		case 2:
			this.track( 'rightClick/' + provider );
			break;
		default:
			break;
	}
}

ShareFeature.track = function( str ) {
	WET.byStr('ShareFeature/' + str);
};

$(function() {
		if( $( '#control_share_feature' ).exists() && $( '#ca-share_feature' ).exists() ) {
			$('#control_share_feature').removeClass( 'disabled' );
			// open dialog on clicking
			$('#ca-share_feature').click( ShareFeature.openDialog );
			$('#fe_sharefeature_link').click( ShareFeature.openDialog );
		}
});
