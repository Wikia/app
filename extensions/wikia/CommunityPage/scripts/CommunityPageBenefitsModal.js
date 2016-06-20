/**
 * Modal containing Benefits of joining Community;
 * modal is an entry point for Community Page
 */
define('CommunityPageBenefitsModal',
	['wikia.loader', 'mw', 'wikia.mustache'],
	function (loader, mw, mustache) {
		'use strict';
		var modalConfig = {
				vars: {
					id: 'CommunityPageBenefitsModal',
					classes: ['community-page-benefits-modal'],
					size: 'content-size'
				}
			},
			specialCommunityTitle = new mw.Title('Community', -1),
			wikiTopic = mw.config.get('wgSiteName');

		function openModal() {
			loader({
				type: loader.MULTI,
				resources: {
					mustache: 'extensions/wikia/CommunityPage/templates/benefitsModal.mustache',
					messages: 'CommunityPageBenefits'
				}
			}).then(handleRequestsForModal);
		}


		function handleRequestsForModal(loaderRes) {
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
		 * CreateComponent callback that finally shows modal
		 * and binds submit action to Done button
		 * One of sub-tasks for getting modal shown
		 */
		function processInstance(modalInstance) {
			modalInstance.show();
		}

		return {
			open: openModal
		};
	}
);
