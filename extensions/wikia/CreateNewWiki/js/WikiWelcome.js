/* global Mustache */
var WikiWelcome = {

	init: function () {
		'use strict';

		$.nirvana.sendRequest( {
			controller: 'FinishCreateWiki',
			method: 'WikiWelcomeModal',
			format: 'json',
			type: 'get',
			callback: this.renderModal
		} );
	},

	renderModal: function ( data ) {
		'use strict';

		require( [ 'wikia.ui.factory', 'wikia.loader' ], function ( uiFactory, loader ) {
			var templatePath = 'extensions/wikia/CreateNewWiki/templates/FinishCreateWiki_WikiWelcomeModal.mustache';

			$.when(
					uiFactory.init( [ 'modal' ] ),
					loader( {
						type: loader.MULTI,
						resources: {
							mustache: templatePath
						}
					} )
				).then( function ( uiModal, resources ) {
					var modalConfig = {
						vars: {
							id: 'WikiWelcomeModal',
							size: 'medium',
							title: data.title,
							content: Mustache.render( resources.mustache[0], data )
						}
					};

					uiModal.createComponent( modalConfig, function ( wikiWelcomeModal ) {
						wikiWelcomeModal.bind( 'createpage', function ( event ) {
							event.preventDefault();
							window.CreatePage.requestDialog( event );
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
