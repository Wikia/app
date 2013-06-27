
define( 'lvs.undo', [ 'wikia.querystring', 'lvs.commonajax', 'wikia.window', 'lvs.videocontrols', 'wikia.nirvana', 'jquery', 'lvs.tracker' ], function( QueryString, commonAjax, window, videoControls, nirvana, $, tracker ) {

	var $container,
		videoTitle,
		newTitle,
		title,
		msg,
		qs,
		sort,
		page,
		wasSwap;


	function doRequest() {
		commonAjax.startLoadingGraphic();

		nirvana.sendRequest({
			controller: 'LicensedVideoSwapSpecialController',
			method: 'restoreVideo',
			data: {
				videoTitle: videoTitle,
				newTitle: newTitle,
				sort: sort,
				page: page
			},
			callback: function( data ) {
				// send info to common success method: response data and tracking label
				commonAjax.success( data, tracker.UNDO);
			},
			onErrorCallback: function() {
				commonAjax.failure();
			}
		});
	}

	function init( $elem ) {
		$container = $elem;

		$( 'body' ).on( 'click', '.global-notification .undo', function( e ) {
			e.preventDefault();

			window.GlobalNotification.hide();
			videoControls.reset();

			var $this = $( this );

			videoTitle = $this.attr( 'data-video-title' );
			newTitle = $this.attr( 'data-new-title' ) || '';
			qs = new QueryString();
			sort = qs.getVal ( 'sort', 'recent' );
			page = qs.getVal ( 'page', 1 );
			wasSwap = !!newTitle;

			if ( wasSwap ) {
				title = $.msg( 'lvs-confirm-undo-swap-title' );
				msg = $.msg( 'lvs-confirm-undo-swap-message' );
			} else {
				title = $.msg( 'lvs-confirm-undo-keep-title' );
				msg = $.msg( 'lvs-confirm-undo-keep-message' );
			}

			$.confirm({
				title: title,
				content: msg,
				onOk: function() {
					doRequest();
				},
				width: 700
			});

			tracker.track( {
				action: tracker.CLICK,
				label: tracker.UNDO
			});
		});
	}

	return {
		init: init
	};
});


