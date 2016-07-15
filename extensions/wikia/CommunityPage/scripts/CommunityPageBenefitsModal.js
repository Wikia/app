/**
 * Modal containing Benefits of joining Community;
 * modal is an entry point for Community Page
 */
define('CommunityPageBenefitsModal',
	['jquery', 'wikia.loader', 'mw', 'wikia.mustache', 'wikia.tracker', 'wikia.nirvana'],
	function ($, loader, mw, mustache, tracker, nirvana) {
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
			$.when(
				loader({
					type: loader.MULTI,
					resources: {
						mustache: 'extensions/wikia/CommunityPage/templates/benefitsModal.mustache',
						messages: 'CommunityPageBenefits'
					}
				}),
				nirvana.sendRequest({
					controller: 'CommunityPageSpecial',
					method: 'getBenefitsModalData',
					type: 'get',
					format: 'json'
				})
			).then(handleRequestsForModal);
		}

		/**
		 * Handle messages, render modal and call createComponent
		 * One of sub-tasks for getting modal shown
		 * @param {Object} loaderRes
		 * @param {Object} nirvanaRes
		 */
		function handleRequestsForModal(loaderRes, nirvanaRes) {
			var wikiTopic = nirvanaRes[0].wikiTopic,
				allMembersCount = nirvanaRes[0].memberCount,
				modalImageUrl = nirvanaRes[0].modalImageUrl,
				image = new Image();

			mw.messages.set(loaderRes.messages);

			modalConfig.vars.content = mustache.render(loaderRes.mustache[0], {
				mainTitle: mw.message('communitypage-entrypoint-modal-title', wikiTopic, allMembersCount).plain(),
				editSubtitle: mw.message('communitypage-entrypoint-modal-edit-title').plain(),
				connectSubtitle: mw.message('communitypage-entrypoint-modal-connect-title').plain(),
				exploreSubtitle: mw.message('communitypage-entrypoint-modal-explore-title').plain(),
				editText: mw.message('communitypage-entrypoint-modal-edit-text', wikiTopic).plain(),
				connectText: mw.message('communitypage-entrypoint-modal-connect-text', wikiTopic).plain(),
				exploreText: mw.message('communitypage-entrypoint-modal-explore-text', wikiTopic).plain(),
				buttonText: mw.message('communitypage-entrypoint-modal-button-text').plain(),
				benefitsImageUrl: modalImageUrl
			});

			// wait for image to load, or show it
			image.onload = image.onerror = function () {
				require(['wikia.ui.factory'], function (uiFactory) {
					uiFactory.init(['modal']).then(createComponent);
				});
			};
			// preload the image to run on load action
			image.src = modalImageUrl;
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

			// Fire action on click on modal content
			modalInstance.$element.on('click', function() {
				window.location.pathname = specialCommunityTitle.getUrl();
			});

			// Bind tracking on elements with data-track attribute
			modalInstance.$element.find('[data-track]').on('mousedown', function (e) {
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
