(function( window ) {
	var track = Wikia.Tracker.buildTrackingFunction({
		category: 'sitewidemessages',
		trackingMethod: 'internal'
	});

	$(document).ready(function(){
		$("span.SWM_dismiss a").each(function(){
			var rxId = new RegExp(/&mID=(\d+)/);
			var id = rxId.exec($(this).attr('href'))[1];
			if (id) {
				$(this).bind('click', {id: id}, SWMAjaxDismiss);
			}
		});
		$( '.SWM_message' ).each( function() {
			track({
				action: Wikia.Tracker.ACTIONS.IMPRESSION,
				label: 'swm-impression',
				value: parseInt( $( this ).attr( 'id' ).substr( 4 ) )
			});

			$( this ).find( 'p a' ).click( function (e) {
				track({
					action: Wikia.Tracker.ACTIONS.CLICK_LINK_TEXT,
					browserEvent: e,
					href: $( this ).attr( 'href' ),
					label: 'swm-link',
					value: msgId
				});
			} );
		} );
	});

	function SWMAjaxDismiss( e ) {
		e.preventDefault();
		var	id = e.data.id,
			ajaxUrl = wgServer + wgScript + "?title=" + wgPageName + "&action=ajax&rs=SiteWideMessagesAjaxDismiss&rsargs[]=" + id,
			request = $.get(ajaxUrl,function(data){
				$("#msg_"+id).remove();
			});

		track({
			action: Wikia.Tracker.ACTIONS.CLICK_LINK_BUTTON,
			label: 'swm-dismiss',
			value: id
		});
	}

	// Exports
	window.SWMAjaxDismiss = SWMAjaxDismiss;
})( window );
