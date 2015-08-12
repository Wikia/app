define('AuthModal', [ 'jquery', 'wikia.ui.factory' ], function( $, uiFactory ) {
	'use strict';
	// get the UI factory
	require( [ 'wikia.ui.factory' ], function( uiFactory ) {
		// initialize the modal component
		uiFactory.init( [ 'modal' ] ).then( function( uiModal ) {
			// modal component configuration
			var modalConfig = {
				vars: {
					id: 'sampleModal',
					size: 'medium', // size of the modal
					content: 'Modal Content', // content
					title: 'Modal Title', // title
					buttons: [  // buttons in the footer
						{
							vars: {
								value: 'Save',
								data: [
									{
										key: 'event',
										value: 'save',
									}
								]
							}
						},
						{
							vars: {
								value: 'Back',
								data: [
									{
										key: 'event',
										value: 'close'
									}
								]
							}
						}
					]
				}
			};

			// create the wrapping JS Object using the modalConfig
			uiModal.createComponent( modalConfig, function( sampleModal ) {
				require(['AuthComponent'], function (ac) {
					debugger;
					sampleModal.show();
				});

				// show the modal
			});
		});
	});
} );
