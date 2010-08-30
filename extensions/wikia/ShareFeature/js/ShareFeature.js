var ShareFeature = {};
ShareFeature.enabled = false;

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


// footer is a String to differentiate between clicking link on menu bar and article footer
ShareFeature.openDialog = function(event, footer) {
	event.preventDefault();
	
	if( false == ShareFeature.enabled ) {
		ShareFeature.enabled = true;

		var width = (window.skin == 'oasis' ? 200 : 300);

		$().getModal(
			wgScript + '?action=ajax&rs=wfShareFeatureAjaxGetDialog&title=' + encodeURIComponent(wgPageName) + '&wiki=' + wgCityId + '&footer=' + encodeURIComponent(footer),
			'#shareFeatureInside',
			{
				width: width,
				callback: function() {
					ShareFeature.enabled = false;
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
			$('#ca-share_feature').click(function(event) {
				ShareFeature.openDialog(event, '');
			});
			$('#fe_sharefeature_link').click( function(event) {
				ShareFeature.openDialog(event, 'articleFooter/');
			});
		}
});
