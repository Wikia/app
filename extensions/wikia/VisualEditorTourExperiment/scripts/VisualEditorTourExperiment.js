define('VisualEditorTourExperiment', ['jquery', 'wikia.loader', 'wikia.mustache'],
	function ($, loader, mustache) {
		'use strict';

		function Tour(tourConfig) {
			this.tourConfig = tourConfig;
			this.steps = [];
		}

		Tour.prototype.start = function() {
			this.step = -1;
			loader({
				type: loader.MULTI,
				resources: {
					mustache: 'extensions/wikia/VisualEditorTourExperiment/templates/VisualEditorTourExperiment_content.mustache',
				}
			}).done(this._setupTour.bind(this));
		}

		Tour.prototype.destroyStep = function(step) {
			var tourStepData = this.steps[step],
				$element = tourStepData ? tourStepData.$element : null;

			if ($element) {
				$element.popover('destroy');
			}
		}

		Tour.prototype.openStep = function(step) {
			var tourStepData = this.steps[step],
				$element = tourStepData ? tourStepData.$element : null;

			if (!$element) {
				return;
			}

			$element.popover({
				content: tourStepData.content,
				html: true,
				placement: this.tourConfig[step].placement,
				trigger: 'manual'
			});

			$element.popover('show');
		}

		Tour.prototype.next = function() {
			if (this.step === this.steps.length - 1) {
				this.dismiss();
				return;
			}
			this.destroyStep(this.step);
			this.openStep(++this.step);
		}

		Tour.prototype.dismiss = function() {
			this.destroyStep(this.step);
			$.cookie('vetourdismissed', 1, { expires : 30 });
		}

		Tour.prototype._setupTour = function (assets) {
			$('body').on('click', '.ve-tour-next', this.next.bind(this));
			$('body').on('click', '.ve-tour-experiment .close', this.dismiss.bind(this));
			this.contentTemplate = assets.mustache[0];
			this.tourConfig.forEach(this._setupStep.bind(this));
			this.next();
		}

		Tour.prototype._setupStep = function (item, id) {
			var buttonLabel = id === this.tourConfig.length - 1 ? 'Start editing' : 'Next';

			this.steps[id] = {
				$element: $(item.selector),
				content: mustache.render(this.contentTemplate, {
					title: item.title,
					description: item.description,
					buttonLabel: buttonLabel
				})
			};
		}


		return Tour;
	}
);
