/**
 * Modal containing Benefits of joining Community;
 * modal is an entry point for Community Page
 */
define('CommunityPageBenefitsModal',
	['jquery', 'wikia.loader', 'mw', 'wikia.mustache', 'wikia.tracker', 'wikia.nirvana', 'wikia.cookies'],
	function ($, loader, mw, mustache, tracker, nirvana, cookies) {
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
						mustache: 'extensions/wikia/CommunityPage/templates/benefitsModal.mustache,' +
							'extensions/wikia/CommunityPage/templates/inspectlet.mustache',
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
				inspectletExperimentId =  nirvanaRes[0].inspectletExperimentId,
				image = new Image(),
				inspectletCode =  mustache.render(loaderRes.mustache[1], {
					inspectletExperimentId: inspectletExperimentId
				});

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
				buttonUrl: specialCommunityTitle.getUrl(),
				benefitsImageUrl: modalImageUrl,
				inspectletCode: inspectletCode
			});

			// wait for image to load, or show it on error
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

			// Bind tracking on modal on mousedown action
			modalInstance.$element.on('mousedown', function(e) {
				track({
					label: $(e.target).data('track') || 'modal-area'
				});

				// set cookie that user clicked on the modal area
				if (e.target.title !== 'close') {
					cookies.set('cpBenefitsModalClicked', 1, {
						domain: mw.config.get('wgCookieDomain'),
						expires: 2592000000, // 30 days
						path: mw.config.get('wgCookiePath')
					});
				}
			});

			// Bind tracking modal close
			modalInstance.bind('close', function () {
				track({
					action: tracker.ACTIONS.CLOSE,
					label: 'modal-closed'
				});
			});

			setModalShownCookie();
		}

		function setModalShownCookie() {
			cookies.set('cpBenefitsModalShown', getTimestamp(), {
				domain: mw.config.get('wgCookieDomain'),
				expires: 2592000000, // 30 days
				path: mw.config.get('wgCookiePath')
			});
		}

		// Gets timestamp in format of YYYY-mm-dd HH:mm:ss
		function getTimestamp() {
			return (new Date()).toISOString().substr(0, 19).replace('T', ' ');
		}

		return {
			open: openModal
		};
	}
);
