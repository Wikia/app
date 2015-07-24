define('ext.wikia.curatedTour.tourNavigator',
	[
		'ext.wikia.curatedTour.stepProjector',
		'ext.wikia.curatedTour.tourManager',
		'mw',
		'wikia.window'
	],
	function (StepProjector, TourManager, mw, window) {
		'use strict';

		function goToStep(step) {
			var index = getIndexFromStep(step);

			TourManager.getPlan(function (tourPlan) {
				var stepData = tourPlan[index];

				window.location.href = mw.config.get('wgServer') + '/' + stepData.PageName + '?curatedTour=' + step;
			});
		}

		function getIndexFromStep(step) {
			return step - 1;
		}

		function goToPreviousStep() {
			var previous = getCurrentStep() - 1;
			goToStep(previous);
		}

		function goToNextStep() {
			var next = getCurrentStep() + 1;
			goToStep(next);
		}

		function getCurrentStep() {
			return parseInt(getUrlParam('curatedTour'));
		}

		function displayCurrentStep() {
			var currentStep = getCurrentStep();

			if (currentStep > 0) {
				var previous = currentStep === 1 ? null : goToPreviousStep;

				TourManager.getPlan(function (tourPlan) {
					var stepData = tourPlan[getIndexFromStep(currentStep)];

					StepProjector.show(
						currentStep,
						stepData.Selector,
						stepData.StepHeader,
						stepData.StepNotes,
						goToNextStep,
						previous
					);
				});
			}
		}

		function getUrlParam(name) {
			var results = new RegExp("[\?&]" + name + "=([^&#]*)").exec(window.location.href);
			if (results == null) {
				return null;
			} else {
				return results[1] || 0;
			}
		}

		return {
			goToStep: goToStep,
			goToNextStep: goToNextStep,
			goToPreviousStep: goToPreviousStep,
			getCurrentStep: getCurrentStep,
			displayCurrentStep: displayCurrentStep
		};
	}
);
