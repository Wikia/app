/**
 * Modal containing Benefits of joining Community;
 * modal is an entry point for Community Page
 */
define('CommunityPageBenefitsModal',
	['wikia.loader', 'wikia.mustache'],
	function (loader, mustache) {
		'use strict';
		var modalConfig = {
			vars: {
				id: 'CommunityPageBenefitsModal',
				classes: ['community-page-benefits-modal'],
				size: 'medium'
			}
		};

		function openEditModal() {
			loader({
				type: loader.MULTI,
				resources: {
					mustache: 'extensions/wikia/CommunityPage/templates/benefitsModal.mustache'
				}
			}).then(handleRequestsForModal);
		}

		function handleRequestsForModal(loaderRes) {
			modalConfig.vars.content = mustache.render(loaderRes.mustache[0]);

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
			open: openEditModal
		};
	}
);
