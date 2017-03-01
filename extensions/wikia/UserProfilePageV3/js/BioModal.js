/**
 * @author: Flightmare (http://elderscrolls.wikia.com/wiki/User:Flightmare)
 * @version: 1.0
 * @license: CC-BY-SA 3.0
 */
require(['jquery', 'wikia.ui.factory'], function ($, uiFactory) {
	'use strict';

	var bioContent = $("#bio-content"),
		bioToggler = $("#bio-toggler");

	function getModalConfig() {
		return {
			type: 'default',
			vars: {
				id: 'discussionsbiomodal',
				size: 'content-size',
				content: '<p>' + bioContent.text().replace(/(?:\r\n|\r|\n)/g, '<br />') + '</p>',
				class: 'styleguide-example-content-size',
				title: bioToggler[0].dataset.modalTitle,
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
	}

	function showModal(uiModal, modalConfig, callback) {
		if (typeof callback !== 'function') {
			callback = function (demoModal) {
				demoModal.show();
			};
		}
		uiModal.createComponent(modalConfig, callback);
	}

	uiFactory.init('modal').then(function (uiModal) {
		$(function () {
			//Add expand toggle button if overflow happens
			if (bioContent.prop('scrollHeight') > bioContent.outerHeight()) {
				bioToggler.show();
				// opening a content-size modal example
				bioToggler.click(function () {
					showModal(uiModal, getModalConfig());
				});
			}
		});
	})
});
