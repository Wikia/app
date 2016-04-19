require(['jquery', 'wikia.loader', 'wikia.mustache', 'mw'], function($, loader, mustache, mw){
	var modalConfig = {
			vars: {
				id: 'MyProfileModal',
				classes: ['my-profile-modal'],
				size: 'medium', // size of the modal
				content: '' // content
			},
			confirmCloseModal: function() {
				if (!saved && /*answers.length*/ true) {
					saveProfile();
				} else {
					if (saved) {
						window.location.href = wgServer + '/wiki/' + userPage;
					} else {
						return true;
					}
				}
			}
		},
		modal = null,
		templates = [],
		currentStep = 1,
		userName = mw.user.name(),
		userPage = 'User:' + userName.replace(/ /g, '_'),
		templateData = {
			userName: userName
		},
		answers = [],
		saved = false;

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
			uiFactory.init(['modal']).then(createModalComponent);
		});
	}

	function createModalComponent(uiModal) {
		uiModal.createComponent(modalConfig, processInstance);
	}

	function processInstance(modalInstance) {
		var modalContent = modalInstance.$element.find('.my-profile-content');

		modal = modalInstance;

		modalInstance.show();

		modalContent.html(mustache.render(templates[currentStep], templateData));

		$('#MyProfileModal').on('click', '.next-step', function() {
			addAnswer();

			currentStep++;
			if (currentStep === 4) {
				sendProfileData().done(function () {
					modalContent.html(mustache.render(templates[currentStep], templateData));
				});
			} else {
				modalContent.html(mustache.render(templates[currentStep], templateData));
			}
		});
	}

	function addAnswer() {
		var answer = $('#MyProfileModal').find('.my-profile-textarea').val().trim();

		if (answer.length) {
			switch (currentStep) {
				case 1: answer = "My favorite moment in the game:\n" + answer; break;
				case 2: answer = "My gaming platforms:\n" + answer; break;
				case 3: answer = "About me:\n" + answer; break;
			}
			answers.push(answer);
		}
	}

	function saveProfile() {
		sendProfileData().done(function () {
			modal.trigger('close');
		});
	}

	function sendProfileData() {
		var dfd = $.Deferred();

		modal.$element.find('.my-profile-content').startThrobbing();

		$.ajax({
			type: 'post',
			url: '/api.php',
			data: {
				action: 'edit',
				title: userPage,
				text: answers.join('\n\n'),
				token: mw.user.tokens.get('editToken')
			}
		}).done(function(){
			saved = true;
		}).always(function(){
			modal.$element.find('.my-profile-content').stopThrobbing();
			dfd.resolve(true);
		});

		return dfd.promise();
	}
});