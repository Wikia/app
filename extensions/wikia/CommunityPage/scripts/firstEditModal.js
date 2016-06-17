require([
	'jquery',
	'wikia.ui.factory',
	'wikia.mustache',
	'communitypage.templates.mustache',
	'wikia.nirvana',
	'wikia.tracker',
	'wikia.window',
	'wikia.cookies',
], function ($, uiFactory, mustache, templates, nirvana, tracker, window, cookies) {
	'use strict';

	 var track = tracker.buildTrackingFunction({
		 action: tracker.ACTIONS.CLICK,
		 category: 'community-page-first-edit',
		 trackingMethod: 'analytics'
	 });

	function getUiModalInstance() {
		var $deferred = $.Deferred();

		uiFactory.init(['modal']).then(function (uiModal) {
			$deferred.resolve(uiModal);
		});

		return $deferred;
	}

	function getModalContents() {
		var $deferred = $.Deferred();

		nirvana.sendRequest({
			controller: 'CommunityPageSpecial',
			method: 'getFirstTimeEditorModalData',
			data: {
				uselang: window.wgUserLanguage
			},
			format: 'json',
			type: 'get',
		}).then(function (response) {
			$deferred.resolve(response);
		});

		return $deferred;
	}

	function openModal() {
		// Track impression
		track({
			action: tracker.ACTIONS.IMPRESSION,
			label: 'first-edit-modal-loaded',
		});

		$.when(
			getUiModalInstance(),
			getModalContents()
		).then(function (uiModal, modalContents) {
			var createPageModalConfig = {
				vars: {
					classes: ['CommunityPageFirstEditModal'],
					content: '',
					id: 'CommunityPageFirstEditModal',
					size: 'medium',
				}
			};

			uiModal.createComponent(createPageModalConfig, function (modal) {
				modal.$content
					.html(mustache.render(templates.firstEditModal, {
						heading: modalContents.headingText,
						subheading: modalContents.subheadingText,
						getStarted: modalContents.getStartedText,
						maybeLater: modalContents.maybeLaterText,
						getStartedLink: modalContents.getStartedLink,
					}));

				modal.show();
				initModalTracking(modal);

				modal.$element
					.on('click', '#community-page-first-edit-maybelater-button', function (event) {
						modal.trigger('close', event);
						event.preventDefault();
					});
			});
		});
	}

	function initModalTracking() {
		// Track clicks in modal
		$('#CommunityPageFirstEditModal').on('mousedown touchstart', 'a', function (event) {
			handleClick(event);
		});
	}

	function handleClick (event) {
		var label = event.currentTarget.getAttribute('data-tracking');

		if (label !== null && label.length > 0) {
			track({
				label: label,
			});
		}
	}

	function openModalOnFirstEdit() {
		var cookieName = 'community-page-first-time';
		var cookie = cookies.get(cookieName);

		// If cookie is set on load, show dialog, this happens after CE edit
		if (cookie) {
			openModal();

			// Delete the cookie
			cookies.set(cookieName, null, {
				domain: wgCookieDomain,
				path: '/',
			});
		}
	}

	$(function() {
		openModalOnFirstEdit();

		// Hook to show modal after VE edit completes (no page reload)
		mw.hook('postEdit').add( function() {
			openModalOnFirstEdit();
		});
	});
});
