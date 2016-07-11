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
		return uiFactory.init(['modal']);
	}

	function getModalContents() {
		return nirvana.sendRequest({
			controller: 'CommunityPageSpecial',
			method: 'getFirstTimeEditorModalData',
			data: {
				uselang: mw.config.get('wgUserLanguage')
			},
			format: 'json',
			type: 'get',
		});
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
				var contents = modalContents[0];

				modal.$content
					.html(mustache.render(templates.firstEditModal, {
						heading: contents.headingText,
						subheading: contents.subheadingText,
						getStarted: contents.getStartedText,
						maybeLater: contents.maybeLaterText,
						getStartedLink: contents.getStartedLink,
					}));

				modal.show();
				initModalTracking();

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

	function handleClick(event) {
		var label = event.currentTarget.getAttribute('data-tracking');

		if (label !== null && label.length > 0) {
			track({
				label: label,
			});
		}
	}

	function openModalOnFirstEdit() {
		var cookieName = 'community-page-first-time',
			cookie = cookies.get(cookieName);

		// If cookie is set on load, show dialog, this happens after CE edit
		if (cookie) {
			openModal();

			// Delete the cookie
			cookies.set(cookieName, null, {
				domain: mw.config.get('wgCookieDomain'),
				path: mw.config.get('wgCookiePath'),
			});
		}
	}

	$(function() {
		openModalOnFirstEdit();

		// Hook to show modal after VE edit completes (no page reload)
		mw.hook('postEdit').add( function() {
			openModalOnFirstEdit();
		});

		// Hook to show modal after comment (no page reload)
		mw.hook('wikipage.content').add( function() {
			openModalOnFirstEdit();
		});
	});
});
