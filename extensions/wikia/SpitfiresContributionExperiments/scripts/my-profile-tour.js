require(['jquery', 'wikia.loader', 'wikia.mustache'], function($, loader, mustache){
	var modalConfig = {
			vars: {
				id: 'MyProfileModal',
				classes: ['my-profile-modal'],
				size: 'medium', // size of the modal
				content: '' // content
			}
		},
		templates = [],
		currentStep = 1,
		templateData = {
			prefix: 'my-profile',
			step: currentStep
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
		loader.processStyle(resources.styles);
		modalConfig.vars.content = mustache.render(resources.mustache[0], templateData);

		templates = resources.mustache;

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

		$('#MyProfileModal').on('click', '.next-step', function() {
			currentStep++;
			templateData.step = currentStep;
			modalInstance.$element.html(mustache.render(templates[currentStep - 1], templateData));
		});
	}

});