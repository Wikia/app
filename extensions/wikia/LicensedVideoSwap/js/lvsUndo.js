
define( 'lvs.undo', ['wikia.querystring', 'lvs.containerdom'], function( QueryString, containerDOM ) {

	return function( $container ) {
		var videoTitle,
			newTitle,
			title,
			msg,
			qs,
			sort,
			wasSwap;

		function doRequest() {
			$.nirvana.sendRequest({
				controller: 'LicensedVideoSwapSpecialController',
				method: 'restoreVideo',
				data: {
					videoTitle: videoTitle,
					newTitle: newTitle,
					sort: sort
				},
				callback: function( data ) {
					containerDOM( $container, data);
				}
			});
		}

		$( 'body' ).on( 'click', '.global-notification .undo', function( e ) {
			e.preventDefault();

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

});


