(function () {
	'use strict';

	/* Modal component configuration */
	var $ = require('jquery'),
		loader = require('wikia.loader'),
		nirvana = require('wikia.nirvana'),
		mustache = require('wikia.mustache'),
		mw = require('mw'),
		modalConfig = {
		vars: {
			id: 'ContentReviewModal',
			classes: ['content-review-status-modal'],
			size: 'small', // size of the modal
			content: '' // content
		}
	};

	function init() {
		$('body').on('click', '#ca-content-review', showModal);
	}

	/**
	 * Function for showing modal.
	 * First function in showing modal process.
	 * Performs all necessary job to display modal with flags ready to edit
	 */
	function showModal(event) {
		event.preventDefault();

		$.when(
			nirvana.sendRequest({
				controller: 'ContentReviewApi',
				method: 'renderStatusModal',
				data: {
					'pageName': window.wgPageName
				},
				type: 'get'
			}),
			loader({
				type: loader.MULTI,
				resources: {
					mustache: '/extensions/wikia/ContentReview/controllers/templates/ContentReviewModule.mustache',
					messages: 'ContentReviewModule',
					styles: '/skins/oasis/css/modules/ContentReview.scss'
				}
			})
		).done(renderModalContent);
	}

	function renderModalContent (contentReviewStatusData, resources) {
		var altLink,
			statusBoxTemplate;

		contentReviewStatusData = contentReviewStatusData[0];
		/* Process resources */
		loader.processStyle(resources.styles);
		mw.messages.set(resources.messages);
		statusBoxTemplate = resources.mustache[0];

		/* Prepare messages for template */
		modalConfig.vars.title = mw.message('content-review-module-title').escaped();
		contentReviewStatusData.headerLatest = mw.message('content-review-module-header-latest').plain();
		contentReviewStatusData.headerLast = mw.message('content-review-module-header-last').plain();
		contentReviewStatusData.headerLive = mw.message('content-review-module-header-live').plain();
		contentReviewStatusData.submit = mw.message('content-review-module-submit').plain();
		contentReviewStatusData.disableTestMode = mw.message('content-review-module-test-mode-disable').plain();
		contentReviewStatusData.enableTestMode = mw.message('content-review-module-test-mode-enable').plain();

		/* Add help link */
		altLink = {
			href: contentReviewStatusData.helpUrl,
			text: contentReviewStatusData.helpTitle
		};
		modalConfig.vars.altLink = altLink;

		/* Prevent displaying title and help sections in default places */
		contentReviewStatusData.title = null;
		contentReviewStatusData.help = null;

		/* Render content */
		modalConfig.vars.content = mustache.render(statusBoxTemplate, contentReviewStatusData);

		/* Initialize the modal component */
		require('wikia.ui.factory').init(['modal']).then(createModalComponent);
	}

	/**
	 * Creates modal UI component
	 * One of sub-tasks for getting modal shown
	 */
	function createModalComponent(uiModal) {
		/* Create the wrapping JS Object using the modalConfig */
		uiModal.createComponent(modalConfig, processInstance);
	}

	function initReviewSubmitButton() {
		require('ext.wikia.contentReview.module').init();
	}

	/**
	 * CreateComponent callback that finally shows modal
	 * and binds submit action to Done button
	 * One of sub-tasks for getting modal shown
	 */
	function processInstance(modalInstance) {
		/* Show the modal */
		modalInstance.show();

		initReviewSubmitButton();
	}

	// Run initialization method on DOM ready
	$(init);
})();
