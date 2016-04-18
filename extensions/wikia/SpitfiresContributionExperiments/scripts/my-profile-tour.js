require(['jquery', 'wikia.loader', 'wikia.mustache'], function($, loader, mustache){
	var modalConfig = {
		vars: {
			id: 'MyProfileModal',
			classes: ['my-profile-modal'],
			size: 'medium', // size of the modal
			content: '' // content
		}
	};

	$.when(
		loader({
			type: loader.MULTI,
			resources: {
				mustache: '/extensions/wikia/SpitfiresContributionExperiments/templates/MyProfileTourExperimentStep1.mustache,' +
				'/extensions/wikia/SpitfiresContributionExperiments/templates/MyProfileTourExperimentStep2.mustache',
				styles: '/extensions/wikia/SpitfiresContributionExperiments/styles/my-profile-tour.scss'
			}
		})
	).done(renderModal);

	function renderModal(resources) {
		var templateData = {
			prefix: 'my-profile',
			step: 1
		};

		loader.processStyle(resources.styles);
		modalConfig.vars.content = mustache.render(resources.mustache[0], templateData);

		require(['wikia.ui.factory'], function (uiFactory) {
			/* Initialize the modal component */
			uiFactory.init(['modal']).then(createModalComponent);
		});
	}

	function createModalComponent(uiModal) {
		/* Create the wrapping JS Object using the modalConfig */
		uiModal.createComponent(modalConfig, processInstance);
	}

	function processInstance(modalInstance) {
		modalInstance.show();
	}

});