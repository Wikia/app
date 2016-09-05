define('VisualEditorTourExperiment', ['jquery', 'wikia.loader', 'wikia.mustache', 'mw', 'ext.wikia.spitfires.experiments.tracker'],
	function ($, loader, mustache, mw, tracker) {
		'use strict';

		var EXPERIMENT_NAME = 'contribution-experiments';

		function Tour(tourConfig) {
			this.tourConfig = tourConfig;
			this.steps = [];
		}

		Tour.prototype.start = function () {
			this.step = -1;
			loader({
				type: loader.MULTI,
				resources: {
					mustache: 'extensions/wikia/VisualEditorTourExperiment/templates/' +
					'VisualEditorTourExperiment_content.mustache'
				}
			}).done(this._setupTour.bind(this));
		};

		Tour.prototype.destroyStep = function (step) {
			var tourStepData = this.steps[step],
				$element = tourStepData ? tourStepData.$element : null;

			if ($element) {
				$element.popover('destroy');
			}
		};

		Tour.prototype.openStep = function (step) {
			var tourStepData = this.steps[step],
				$element = tourStepData ? tourStepData.$element : null;

			if (!$element) {
				return;
			}

			$element.popover({
				content: tourStepData.content,
				html: true,
				placement: this.tourConfig[step].placement,
				trigger: 'manual',
				template: '<div class="popover ve-tour">' +
				'<div class="arrow"></div>' +
				'<div class="popover-inner">' +
				'<div class="popover-content"></div>' +
				'</div>' +
				'</div>'
			});

			$element.popover('show');

			tracker.trackVerboseImpression(EXPERIMENT_NAME, 'tour-step-' + this.step);
		};

		Tour.prototype.nextHandle = function () {
			this._setDisabled();
			this.next();
			tracker.trackVerboseClick(EXPERIMENT_NAME, 'next-go-to-' + this.step);
		};

		Tour.prototype.next = function () {
			if (this.step === this.steps.length - 1) {
				this.destroyStep(this.step);
				tracker.trackVerboseClick(EXPERIMENT_NAME, 'tour-complete');
				return;
			}
			this.destroyStep(this.step);
			this.openStep(++this.step);
		};

		Tour.prototype.prevHandle = function () {
			this.destroyStep(this.step);
			this.openStep(--this.step);
			tracker.trackVerboseClick(EXPERIMENT_NAME, 'next-go-to-' + this.step);
		};

		Tour.prototype.close = function () {
			this._setDisabled();
			this.destroyStep(this.step);
			tracker.trackVerboseClick(EXPERIMENT_NAME, 'close-' + this.step);
		};

		Tour.prototype._setDisabled = function () {
			if (!$.cookie('vetourdisabled')) {
				$.cookie('vetourdisabled', 1, {
					expires: 30,
					path: mw.config.get('wgCookiePath'),
					domain: mw.config.get('wgCookieDomain')
				});
			}
		};

		Tour.prototype._setupTour = function (assets) {
			var $body = $('body');

			mw.hook('ve.cancelButton').add(function () {
				$body.off('.VETour');
				this.destroyStep(this.step);
			}.bind(this));

			$body.on('click.VETour', '.ve-tour-next', this.nextHandle.bind(this));
			$body.on('click.VETour', '.ve-tour-prev', this.prevHandle.bind(this));
			$body.on('click.VETour', '.ve-tour-experiment .close', this.close.bind(this));

			this.contentTemplate = assets.mustache[0];
			this.tourConfig.forEach(this._setupStep.bind(this));
			// Set delay to let VE show animation finish and position first step properly
			setTimeout(this.next.bind(this), 200);
		};

		Tour.prototype._setupStep = function (item, id) {
			var buttonLabel = id === this.tourConfig.length - 1 ? '編集を開始' : '次へ',
				showPrev = id > 0;

			this.steps[id] = {
				$element: $(item.selector),
				content: mustache.render(this.contentTemplate, {
					title: item.title,
					description: item.description,
					buttonLabel: buttonLabel,
					showPrev: showPrev
				})
			};
		};

		return Tour;
	}
);
