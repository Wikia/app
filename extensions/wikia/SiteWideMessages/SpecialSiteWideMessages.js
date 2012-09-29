$(document).ready(function(){
	$("span.SWM_dismiss a").each(function(){
		var rxId = new RegExp(/&mID=(\d+)/);
		var id = rxId.exec($(this).attr('href'))[1];
		if (id) {
			$(this).bind('click', {id: id}, SWMAjaxDismiss);
		}
	});
	$( '.SWM_message' ).each( function() {
		var msgId = parseInt( $( this ).attr( 'id' ).substr( 4 ) ),
			impTrackObj = {
				ga_category: 'sitewidemessages',
				ga_action: WikiaTracker.ACTIONS.IMPRESSION,
				ga_label: 'swm-impression',
				ga_value: msgId
			};
		WikiaTracker.trackEvent(
			'trackingevent',
			impTrackObj,
			'internal'
		);
		$( this ).find( 'p a' ).click( function () {
			var trackObj = {
				ga_category: 'sitewidemessages',
				ga_action: WikiaTracker.ACTIONS.CLICK_LINK_TEXT,
				ga_label: 'swm-link',
				ga_value: msgId,
				href: $( this ).attr( 'href' )
			};
			WikiaTracker.trackEvent(
				'trackingevent',
				trackObj,
				'internal'
			);
		} );
	} );
});

function SWMAjaxDismiss( e ) {
	e.preventDefault();
	var	id = e.data.id,
		ajaxUrl = wgServer + wgScript + "?title=" + wgPageName + "&action=ajax&rs=SiteWideMessagesAjaxDismiss&rsargs[]=" + id,
		request = $.get(ajaxUrl,function(data){
			$("#msg_"+id).remove();
		}),
		trackObj = {
			ga_category: 'sitewidemessages',
			ga_action: WikiaTracker.ACTIONS.CLICK_LINK_BUTTON,
			ga_label: 'swm-dismiss',
			ga_value: id
		};
	WikiaTracker.trackEvent(
		'trackingevent',
		trackObj,
		'internal'
	);
}