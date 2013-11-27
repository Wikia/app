var WikiWelcome = {

	init: function () {
		'use strict';

		$.nirvana.sendRequest( {
			controller: 'FinishCreateWiki',
			method: 'WikiWelcomeModal',
			format: 'html',
			type: 'get',
			callback: this.renderModal
		} );
	},

	renderModal: function ( html ) {
		'use strict';

		var modalHtml = html;
		require( [ 'wikia.ui.factory' ], function ( uiFactory ) {
			uiFactory.init( [ 'modal' ] ).then( function ( uiModal ) {
				var modalConfig = {
					vars: {
						id: 'WikiWelcomeModal',
						size: 'small',
						content: modalHtml
					}
				};

				uiModal.createComponent( modalConfig, function ( wikiWelcomeModal ) {
					wikiWelcomeModal.bind( 'createpage', function ( event ) {
						event.preventDefault();
						window.CreatePage.openDialog( event );
						wikiWelcomeModal.trigger( 'close' );
						return false;
					} );
					wikiWelcomeModal.show();
				} );
			} );
		} );
	}
};

$( function () {
	'use strict';

	WikiWelcome.init();
} );
