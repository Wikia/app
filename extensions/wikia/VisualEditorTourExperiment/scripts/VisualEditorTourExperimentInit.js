define('VisualEditorTourExperimentInit', ['wikia.window', 'jquery', 'mw', 'wikia.loader', 'wikia.mustache'],
	function (w, $, mw, loader, mustache) {
		'use strict';

		var tour = [
				{selector: '#WikiaArticle', placement: 'top', title: 'Write content',
					description: 'Share your knowledge with the Community! This space is yours: write, fix typos, ' +
					'add links. Make this article better with each edit'},
			];

		function start() {
			loader({
				type: loader.MULTI,
				resources: {
					mustache: 'extensions/wikia/VisualEditorTourExperiment/templates/VisualEditorTourExperiment_content.mustache',
				}
			}).done(function (assets) {
				var content = mustache.render(assets.mustache[0], {
						title: tour[0].title,
						description: tour[0].description
					}),
					element = $(tour[0].selector).popover({
						placement:tour[0].placement,
						trigger:'manual',
						html:true,
						content: content
					});

				element.popover('show');
			});

		}

		return {
			start: start
		}
	}
);
