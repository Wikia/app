define('VisualEditorTourExperimentInit', ['wikia.window', 'jquery', 'mw', 'wikia.loader', 'wikia.mustache'],
	function (w, $, mw, loader, mustache) {
		'use strict';

		var contentTemplate,
			step = -1,
			tourConfig = [
				{selector: '#WikiaArticle', placement: 'top', title: 'Write content',
					description: 'Share your knowledge with the Community! This space is yours: write, fix typos, ' +
					'add links. Make this article better with each edit'},
				{selector: '#WikiaArticle', placement: 'top', title: 'Write content2',
					description: 'Share your knowledge with the Community! This space is yours: write, fix typos, ' +
					'add links. Make this article better with each edit'},
			],
			tourData = [];

		function start() {
			step = -1;
			loader({
				type: loader.MULTI,
				resources: {
					mustache: 'extensions/wikia/VisualEditorTourExperiment/templates/VisualEditorTourExperiment_content.mustache',
				}
			}).done(function (assets) {
				contentTemplate = assets.mustache[0];
				tourConfig.forEach(setupStep);
				next();
			});
		}

		function setupStep(item, id) {
			tourData[id] = {
				$element: $(item.selector),
				content: mustache.render(contentTemplate, {
					title: item.title,
					description: item.description
				})
			};
		}

		function destroyStep(step) {
			var tourStepData = tourData[step],
				$element = tourStepData ? tourStepData.$element : null;

			if ($element) {
				$element.popover('destroy');
			}
		}

		function openStep(step) {
			var tourStepData = tourData[step],
				$element = tourStepData ? tourStepData.$element : null;

			if (!$element) {
				return;
			}

			$element.popover({
				content: tourStepData.content,
				html: true,
				placement: tourConfig[step].placement,
				trigger: 'manual'
			});

			$element.popover('show');
		}

		function next() {
			destroyStep(step);
			openStep(++step);
		}

		$('body').on('click', '.ve-tour-next', next);
		return {
			start: start
		}
	}
);
