require([ 'jquery', 'wikia.ui.factory', 'wikia.nirvana' ], function( $, uiFactory, nirvana ) {
	var menuPromise = nirvana.sendRequest({
			controller: 'GlobalHeaderController',
			method: 'getGlobalMenuItems',
			format: 'json',
			type: 'GET',
			data: {
				cb: Date.now()
			}
		}),
		drawerPromise = uiFactory.init( [ 'drawer' ] );

	$.when(menuPromise, drawerPromise).done( function(menuXhr, uiDrawer) {
		var menuItems = menuXhr[0],
			drawerConfig = {
				vars: {
					//style: 'fixed',
					closeText: 'Close',
					side: 'left',
					content: 'Lorem'
				}
			};

			uiDrawer.createComponent(drawerConfig, function(drawer) {
				$('.WikiaLogo').on('click', function(e) {
					e.preventDefault();

					console.log(menuItems);

					drawer.open();
				});
			});
	} );
} );
