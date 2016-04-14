define('VisualEditorTourExperimentInit', ['wikia.window', 'jquery', 'mw', 'wikia.loader'],
	function (w, $, mw, loader) {
		'use strict';

		var tour = [
			{selector: '#WikiaArticle', placement: 'top', title: 'Write content',
				description: 'Share your knowledge with the Community! This space is yours: write, fix typos, ' +
				'add links. Make this article better with each edit'},

		];
		function start() {
			var element = $(tour[0].selector).popover({
				placement:tour[0].placement,
				trigger:'manual',
				html:true,
				content:'<div class="ve-tour-experiment">' +
					'<h2>' + tour[0].title + '</h2>' +
					'<p>' + tour[0].description + '</p>' +
					'</div>'

			});

			element.popover('show');
		}

		return {
			start: start
		}
	}
);
