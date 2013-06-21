
define( 'lvs.undo', ['wikia.querystring', 'lvs.commonajax', 'wikia.window', 'lvs.videocontrols', 'wikia.nirvana', 'jquery'], function( QueryString, commonAjax, window, videoControls, nirvana, $ ) {

	var $container,
		videoTitle,
		newTitle,
		title,
		msg,
		qs,
		sort,
		wasSwap;

	function doRequest() {
		commonAjax.startLoadingGraphic();

		nirvana.sendRequest({
			controller: 'LicensedVideoSwapSpecialController',
			method: 'restoreVideo',
			data: {
				videoTitle: videoTitle,
				newTitle: newTitle,
				sort: sort
			},
			callback: function( data ) {
				commonAjax.success( $container, data);
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
		});
	}

	return {
		init: init
	};
});


