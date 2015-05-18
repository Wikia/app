require(['jquery'], function($) {
	'use strict';

	var init,
		showModal;

	init = function init() {
		$('#ca-flags').on('click', showModal);
	};

	showModal = function showModal() {
		require(['wikia.ui.factory'], function( uiFactory ) {
			// initialize the modal component
			uiFactory.init(['modal']).then(function(uiModal) {
				// modal component configuration
				var modalConfig = {
					vars: {
						id: 'sampleModal',
						size: 'medium', // size of the modal
						content: 'Modal Content', // content
						title: 'Flags', // title
						buttons: [  // buttons in the footer
							{
								vars: {
									value: 'Done',
									data: [
										{
											key: 'event',
											value: 'save'
										}
									]
								}
							},
							{
								vars: {
									value: 'Cancel',
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
				uiModal.createComponent(modalConfig, function(sampleModal) {

					// bind the Save button to this anon. function
					sampleModal.bind('save', function(event) {
						event.preventDefault();
						// do something

						// to close the modal, call the trigger event with 'close'
						sampleModal.trigger('close');
					});

					// show the modal
					sampleModal.show();

					// deactivate the modal and show the throbbing image
					//sampleModal.deactivate();

					//getAjaxData( function( data ) {
					//	// do something with the data
					//
					//	// activate the modal when everything is ready
					//	sampleModal.activate();
					//});
				});
			});
		});
	};

	// Run initialization
	init();
});
