require(['jquery', 'ext.wikia.spitfires.experiments.tracker', 'wikia.loader', 'wikia.nirvana', 'wikia.mustache', 'mw'],
	function ($, tracker, loader, nirvana, mustache, mw) {
		'use strict';

		var experimentName = 'CONTRIB_EXPERIMENTS',
			modalConfig = {
				vars: {
					id: 'MyProfileModal',
					classes: ['my-profile-modal'],
					size: 'medium', // size of the modal
					content: '' // content
				},
				confirmCloseModal: function () {
					if (!saved && answers.length) {
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
			answers = {},
			saved = false,
			seenCookieName = 'myprofiletour-seen',
			currentStep = 1,
			userName = mw.user.name(),
			userPage = 'User:' + userName.replace(/ /g, '_'),
			templateData = {
				userName: userName
			},
			lastStepTemplateData = [];

		function init() {
			if ($.cookie(seenCookieName)) {
				return;
			}
			$.when(
				nirvana.sendRequest({
					controller: 'ContributionExperiments',
					method: 'getNextPages',
					type: 'get'
				}),
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
		}

		function renderModal(data, resources) {
			$.cookie(seenCookieName, 1, {expires: 30});
			templates = resources.mustache;
			lastStepTemplateData = data[0];

			loader.processStyle(resources.styles);
			modalConfig.vars.content = mustache.render(resources.mustache[0], {});

			require(['wikia.ui.factory'], function (uiFactory) {
				uiFactory.init(['modal']).then(createModalComponent);
			});
		}

		function createModalComponent(uiModal) {
			uiModal.createComponent(modalConfig, processInstance);
		}

		function processInstance(modalInstance) {
			var modalContent = modalInstance.$element.find('.my-profile-content'),
				$profileModal;

			modal = modalInstance;

			modalInstance.show();

			modalContent.html(mustache.render(templates[currentStep], templateData));

			tracker.trackVerboseImpression(experimentName, 'step-1-first-time');

			$profileModal = $('#MyProfileModal');
			$profileModal.on('click', '.next-step', function () {
				addAnswer();

				currentStep++;
				templateData.answer = answers[currentStep];
				if (currentStep === 4) {
					sendProfileData().done(function () {
						modalContent.html(mustache.render(templates[currentStep], lastStepTemplateData));
					});
				} else {
					modalContent.html(mustache.render(templates[currentStep], templateData));
				}

				tracker.trackVerboseClick(experimentName, 'go-next-to-step-' + currentStep);
			});

			$profileModal.on('click', '.my-profile-header-go-back', function () {
				addAnswer();
				currentStep--;
				templateData.answer = answers[currentStep];
				modalContent.html(mustache.render(templates[currentStep], templateData));

				tracker.trackVerboseClick(experimentName, 'go-back-to-step-' + currentStep);
			});

			$profileModal.on('click', '.my-profile-next-pages a', function () {
				tracker.trackVerboseClick(experimentName, 'last-step-go-to-article');
			});
		}

		function addAnswer() {
			answers[currentStep] = $('#MyProfileModal').find('.my-profile-textarea').val().trim();
		}

		function saveProfile() {
			sendProfileData().done(function () {
				modal.trigger('close');
			});
		}

		function sendProfileData() {
			var dfd = $.Deferred(),
				formattedAnswers;

			if (answers.length) {
				modal.$element.find('.my-profile-content').startThrobbing();

				formattedAnswers = Object.keys(answers).map(function (value, index) {
					switch (index + 1) {
						case 1:
							return "===My favorite moment in the game===\n" + answers[index + 1];
							break;
						case 2:
							return "===My gaming platforms===\n" + answers[index + 1];
							break;
						case 3:
							return "===About me===\n" + answers[index + 1];
							break;
					}
				});

				$.ajax({
					type: 'post',
					url: '/api.php',
					data: {
						action: 'edit',
						title: userPage,
						text: formattedAnswers.join('\n\n'),
						token: mw.user.tokens.get('editToken')
					}
				}).done(function () {
					saved = true;
					tracker.trackVerboseSuccess(experimentName, 'user-data-saved');
				}).always(function () {
					modal.$element.find('.my-profile-content').stopThrobbing();
					dfd.resolve(true);
				});
			} else {
				dfd.resolve(true);
			}

			return dfd.promise();
		}

		init();
	}
);
