/**
 * Modal containing Benefits of joining Community;
 * modal is an entry point for Community Page
 */
define('CommunityPageBenefitsModal',
	['jquery', 'wikia.loader', 'mw', 'wikia.mustache', 'wikia.tracker'],
	function ($, loader, mw, mustache, tracker) {
		'use strict';
		var modalConfig = {
				vars: {
					id: 'CommunityPageBenefitsModal',
					classes: ['community-page-benefits-modal'],
					size: 'content-size'
				}
			},
			specialCommunityTitle = new mw.Title('Community', -1),
			track = tracker.buildTrackingFunction({
				action: tracker.ACTIONS.CLICK,
				category: 'community-page-benefits-modal',
				trackingMethod: 'analytics'
			});

		function openModal() {
			loader({
				type: loader.MULTI,
				resources: {
					mustache: 'extensions/wikia/CommunityPage/templates/benefitsModal.mustache',
					messages: 'CommunityPageBenefits'
				}
			}).then(handleRequestsForModal);
		}

		/**
		 * Handle messages, render modal and call createComponent
		 * One of sub-tasks for getting modal shown
		 * @param {Object} loaderRes
		 */
		function handleRequestsForModal(loaderRes) {
			var wikiTopic = mw.config.get('wgSiteName');

			mw.messages.set(loaderRes.messages);

			modalConfig.vars.content = mustache.render(loaderRes.mustache[0], {
				mainTitle: mw.message('communitypage-entrypoint-modal-title', wikiTopic, '').plain(),
				editSubtitle: mw.message('communitypage-entrypoint-modal-edit-title').plain(),
				connectSubtitle: mw.message('communitypage-entrypoint-modal-connect-title').plain(),
				exploreSubtitle: mw.message('communitypage-entrypoint-modal-explore-title').plain(),
				editText: mw.message('communitypage-entrypoint-modal-edit-text', wikiTopic).plain(),
				connectText: mw.message('communitypage-entrypoint-modal-connect-text', wikiTopic).plain(),
				exploreText: mw.message('communitypage-entrypoint-modal-explore-text', wikiTopic).plain(),
				buttonText: mw.message('communitypage-entrypoint-modal-button-text').plain(),
				buttonUrl: specialCommunityTitle.getUrl()
			});

			require(['wikia.ui.factory'], function (uiFactory) {
				uiFactory.init(['modal']).then(createComponent);
			});
		}

		/**
		 * Creates modal UI component
		 * One of sub-tasks for getting modal shown
		 */
		function createComponent(uiModal) {
			/* Create the wrapping JS Object using the modalConfig */
			uiModal.createComponent(modalConfig, processInstance);
		}

		/**
		 * CreateComponent callback that finally shows modal.
		 * Bind tracking events.
		 * One of sub-tasks for getting modal shown.
		 */
		function processInstance(modalInstance) {
			modalInstance.show();

			// Send tracking event for modal shown
			track({
				action: tracker.ACTIONS.IMPRESSION,
				label: 'benefits-modal-shown'
			});

			// Bind tracking links that navigate away
			modalInstance.$element.find('[data-track-mousedown]').bind('mousedown', function (e) {
				track({label: $(e.target).data('trackMousedown')});
			});

			// Bind tracking clicks on elements with data-track attribute
			modalInstance.$element.find('[data-track]').click(function (e) {
				track({label: $(e.target).data('track')});
			});

			// Bind tracking modal close
			modalInstance.bind('close', function () {
				track({
					action: tracker.ACTIONS.CLOSE,
					label: 'modal-closed'
				});
			});
		}

		return {
			open: openModal
		};
	}
);
