/* global define, require, Mustache */

/**
 * A module that displays a "welcome" modal when the CreateNewWiki process is finished
 */
define('WikiWelcome', ['wikia.ui.factory', 'wikia.loader', 'wikia.tracker'], function (uiFactory, loader, tracker) {
	'use strict';

	var templatePath = 'extensions/wikia/CreateNewWiki/templates/FinishCreateWiki_WikiWelcomeModal.mustache',
		modalWrapper,
		track = tracker.buildTrackingFunction({
			action: tracker.ACTIONS.CLICK,
			category: 'create-new-wiki',
			trackingMethod: 'analytics'
		});


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
			bindEventHandlers();
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


	function bindEventHandlers(){
		modalWrapper = $('#WikiWelcomeModal');
		modalWrapper.find('button.createpage').bind('click', onCreatePageButtonClick);
		modalWrapper.find('.help > a').bind('mousedown', onCommCentralLinkClick);
		modalWrapper.find('header a.close').bind('click', onModalClose);
		modalWrapper.bind('click mousedown', onModalWrapperClick);
		$('#blackout_WikiWelcomeModal').bind('click', onModalClose);
	}

	function onCreatePageButtonClick(){
		track({
			label: 'welcome-modal-add-page-clicked'
		});
	}

	function onCommCentralLinkClick(){
		track({
			label: 'welcome-modal-community-central-clicked'
		});
	}

	function onModalWrapperClick(e) {
		// to prevent tracking the modal closing event when clicking within modal area
		e.originalEvent.preventCloseTracking = true;
	}

	function onModalClose(e){
		if(!e.originalEvent.preventCloseTracking) {
			track({
				label: 'welcome-modal-closed'
			});
		}
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
