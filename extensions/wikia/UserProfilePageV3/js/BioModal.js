/**
 * @author: Flightmare (http://elderscrolls.wikia.com/wiki/User:Flightmare)
 * @version: 1.0
 * @license: CC-BY-SA 3.0
 */
require(['jquery', 'wikia.ui.factory'], function ($, uiFactory) {
	'use strict';
	uiFactory.init('modal').then(function (uiModal) {
		$(function () {
			/**
			 * Shows a modal; unified function for different modals
			 *
			 * @param {Object} modalConfig - uiFactory modal config object
			 * @param {Function} callback - optional; Callback after modal is initialized
			 */
			function showModal(modalConfig, callback) {
				if (typeof callback !== 'function') {
					callback = function (demoModal) {
						demoModal.show();
					};
				}
				uiModal.createComponent(modalConfig, callback);
			}

			var disBio = $("#discussion-bio");
			var disBioToggle = $("#discussion-bio-toggle");

			//Add expand toggle button if overflow happens
			if (disBio.prop('scrollHeight') > disBio.outerHeight()) {
				disBioToggle.show();
				// opening a content-size modal example
				disBioToggle.click(function () {
					var modalConfig = {
						type: 'default',
						vars: {
							id: 'discussionsbiomodal',
							size: 'content-size',
							content: '<p>' + disBio.text().replace(/(?:\r\n|\r|\n)/g, '<br />') + '</p>',
							class: 'styleguide-example-content-size',
							title: disBioToggle[0].dataset.modalTitle,
							closeText: 'Close',
							buttons: [
								{
									vars: {
										value: 'Close',
										classes: 'primary',
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
					showModal(modalConfig);
				});
			}
		});
	})
});
