require(['jquery', 'wikia.loader', 'wikia.mustache', 'mw'], function($, loader, mustache, mw){
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
			userName: mw.user.name()
		},
		answers = [];

	$.when(
		loader({
			type: loader.MULTI,
			resources: {
				mustache: '/extensions/wikia/SpitfiresContributionExperiments/templates/MyProfileTourExperimentModal.mustache,' +
				'/extensions/wikia/SpitfiresContributionExperiments/templates/MyProfileTourExperimentStep1.mustache,' +
				'/extensions/wikia/SpitfiresContributionExperiments/templates/MyProfileTourExperimentStep2.mustache,' +
				'/extensions/wikia/SpitfiresContributionExperiments/templates/MyProfileTourExperimentStep3.mustache,' +
				'/extensions/wikia/SpitfiresContributionExperiments/templates/MyProfileTourExperimentStep4.mustache',
				styles: '/extensions/wikia/SpitfiresContributionExperiments/styles/my-profile-tour.scss'
			}
		})
	).done(renderModal);

	function renderModal(resources) {
		loader.processStyle(resources.styles);
		modalConfig.vars.content = mustache.render(resources.mustache[0], {});

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

		modalInstance.$element.find('.my-profile-content').html(mustache.render(templates[currentStep], templateData));

		$('#MyProfileModal').on('click', '.next-step', function() {
			currentStep++;
			saveAnswer();
			modalInstance.$element.find('.my-profile-content').html(mustache.render(templates[currentStep], templateData));
		});

		modalInstance.bind('close', function(){

		});
	}

	function saveAnswer() {
		var answer = $('#MyProfileModal').find('.my-profile-answer').val().trim();

		if (answer.length) {
			answers.push(answer);
		}
	}

});