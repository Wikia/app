
define( 'lvs.undo', ['wikia.querystring', 'lvs.containerdom'], function( QueryString, containerDOM ) {

	return function( $container ) {
		var videoTitle,
			newTitle,
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
				$.confirm({
					title: $.msg( 'lvs-confirm-undo-swap-title' ),
					content: $.msg( 'lvs-confirm-undo-swap-message' ),
					onOk: function() {
						doRequest();
					},
					width: 700
				});
			} else {
				doRequest();
			}

		});
	}

});


