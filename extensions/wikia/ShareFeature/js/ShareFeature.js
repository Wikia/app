
var ShareFeature = {};
var ShareFeatureEnabled = false;

ShareFeature.ajax = function( provider ) {
	$.post(wgScript,
			{
		   		'action':'ajax', 
		   		'rs':'wfShareFeatureAjaxUpdateStats',
		   		'provider': provider
			},
			function() {
				 $('.modalWrapper').closeModal();
			}
		);
};

ShareFeature.openDialog = function( footer ) {
	if( false == ShareFeatureEnabled ) {
		ShareFeatureEnabled = true;
		$().getModal(
			wgScript + '?action=ajax&rs=wfShareFeatureAjaxGetDialog&title=' + encodeURIComponent(wgPageName) + '&wiki=' + wgCityId + '&footer=' + encodeURIComponent(footer),
				'#shareFeatureInside',
			{
					width: 300,
					callback: function() {
						ShareFeatureEnabled = false;
						ShareFeature.track( footer + 'open' );
					},
				onClose: function() {
					ShareFeature.track( footer + 'close');
				}
			}
		);
	}
}

ShareFeature.mouseDown = function( provider, footer ) {
	var event = $.getEvent();
	switch( event.button ) {
		case 0:
			this.ajax( provider );
			this.track( footer + 'leftClick/' + provider );
			break;
		case 1:
			this.ajax( provider );
			this.track( footer + 'middleClick/' + provider  );
			break;
		case 2:
			this.track( footer + 'rightClick/' + provider );
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
			$('#ca-share_feature').click( function() {
				ShareFeature.openDialog( '' );
			});
			$('#fe_sharefeature_link').click( function() {
				ShareFeature.openDialog( 'articleFooter/' );
			});
		}
});
