require(
	['jquery', 'wikia.document', 'wikia.loader', 'wikia.nirvana', 'wikia.mustache', 'mw', 'wikia.tracker'],
	function ($, document, loader, nirvana, mustache, mw, tracker)
{
	'use strict';

	/* Modal component configuration */
	var modalConfig = {
		vars: {
			id: 'ContentReviewModal',
			classes: ['content-review-status-modal'],
			size: 'small', // size of the modal
			content: '' // content
		}
	};

	/* Tracking wrapper function */
	//track = Wikia.Tracker.buildTrackingFunction({
	//	action: tracker.ACTIONS.CLICK,
	//	category: 'flags-edit',
	//	trackingMethod: 'analytics'
	//}),

	/* Label for on submit tracking event */
	//labelForSubmitAction = 'submit-form-untouched';

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
		//require(['wikia.ui.factory'], function (uiFactory) {
		//	/* Initialize the modal component */
		//	uiFactory.init(['modal']).then(createComponent);
		//});
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

		require(['wikia.ui.factory'], function (uiFactory) {
			/* Initialize the modal component */
			uiFactory.init(['modal']).then(createModalComponent);
		});
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
		require(['ext.wikia.contentReview.module'], function (contentReviewModule) {
			contentReviewModule.init();
		});
	}

	/**
	 * CreateComponent callback that finally shows modal
	 * and binds submit action to Done button
	 * One of sub-tasks for getting modal shown
	 */
	function processInstance(modalInstance) {
		//var $flagsEditForm = modalInstance.$element.find('#flagsEditForm');
		//if ($flagsEditForm.length > 0) {
		//	/* Submit flags edit form on Done button click */
		//	modalInstance.bind('done', function () {
		//		track({
		//			action: tracker.ACTIONS.CLICK_LINK_BUTTON,
		//			label: labelForSubmitAction
		//		});
		//		$flagsEditForm.trigger('submit');
		//	});
		//	/* Track clicks on modal form */
		//	$flagsEditForm.bind('click', trackModalFormClicks);
		//	/* Detect form change */
		//	$flagsEditForm.on('change', function () {
		//		labelForSubmitAction = 'submit-form-touched';
		//		$flagsEditForm.off('change');
		//	});
		//}

		/* Track all ways of closing modal */
		//modalInstance.bind('close', function () {
		//	track({
		//		label: 'modal-close'
		//	});
		//});

		/* Show the modal */
		modalInstance.show();

		initReviewSubmitButton();

		//track({
		//	action: tracker.ACTIONS.IMPRESSION,
		//	label: 'modal-shown'
		//});
	}

	/**
	 * Track clicks within modal form
	 * (links and checkboxes)
	 */
	//function trackModalFormClicks(e) {
	//	var $target = $(e.target),
	//		$targetLinkDataId;
	//
	//	/* Track checkbox toggling */
	//	if ($target.is('input[type=checkbox]')) {
	//		if ($target[0].checked) {
	//			track({
	//				action: tracker.ACTIONS.CLICK,
	//				label: 'checkbox-checked'
	//			});
	//		} else {
	//			track({
	//				action: tracker.ACTIONS.CLICK,
	//				label: 'checkbox-unchecked'
	//			});
	//		}
	//		return;
	//	}
	//
	//	/* Track links clicks */
	//	if ($target.is('a')) {
	//		$targetLinkDataId = $target.data('id');
	//		if ($targetLinkDataId) {
	//			track({
	//				action: tracker.ACTIONS.CLICK_LINK_TEXT,
	//				label: $targetLinkDataId
	//			});
	//		}
	//	}
	//}

	// Run initialization method on DOM ready
	$(init);
});
