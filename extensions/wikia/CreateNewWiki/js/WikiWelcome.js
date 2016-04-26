/* global define, require, Mustache */

/**
 * A module that displays a "welcome" modal when the CreateNewWiki process is finished
 */
define('WikiWelcome', ['wikia.ui.factory', 'wikia.loader'], function (uiFactory, loader) {
	'use strict';

	var templatePath = 'extensions/wikia/CreateNewWiki/templates/FinishCreateWiki_WikiWelcomeModal.mustache';

	/**
	 * Sends a request to a WikiWelcomeModal method to initialize the module
	 *
	 * @returns {void}
	 */
	function init() {
		$.nirvana.sendRequest({
			controller: 'FinishCreateWiki',
			method: 'WikiWelcomeModal',
			format: 'json',
			type: 'get',
			callback: loadModal
		});
	}

	/**
	 * @param {Object} data
	 *
	 * @returns {Object}
	 */
	function getModalConfig(data, resources) {
		return {
			vars: {
				id: 'WikiWelcomeModal',
				size: 'medium',
				title: data.title,
				content: Mustache.render(resources.mustache[0], data)
			}
		};
	}

	/**
	 * @param {Object} uiModal
	 * @param {Object} resources
	 * @param {Object} data
	 *
	 * @returns {void}
	 */
	function createModalComponent(uiModal, resources, data) {
		var modalConfig = getModalConfig(data, resources);

		uiModal.createComponent(modalConfig, function (wikiWelcomeModal) {
			wikiWelcomeModal.bind('createpage', function (event) {
				event.preventDefault();
				window.CreatePage.requestDialog(event);
				wikiWelcomeModal.trigger('close');
				return false;
			});
			wikiWelcomeModal.show();
		});
	}

	/**
	 * Initializes uiFactory modal and downloads mustache template for it's contents
	 *
	 * @param {Object} data
	 *
	 * @returns {void}
	 */
	function loadModal(data) {
		$.when(
			uiFactory.init(['modal']),
			loader({
				type: loader.MULTI,
				resources: {
					mustache: templatePath
				}
			})
		).then(function (uiModal, resources) {
			createModalComponent(uiModal, resources, data);
		});
	}

	return {
		init: init
	};
});

$(function () {
	'use strict';

	require(['WikiWelcome'], function (wikiWelcome) {
		wikiWelcome.init();
	});
});
