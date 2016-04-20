require(['jquery', 'mw', 'VisualEditorTourExperimentInit', 'ext.wikia.spitfires.experiments.tracker'],
	function ($, mw, veTourInit, tracker) {
		'use strict';

		var EXPERIMENT_NAME = 'CONTRIB_EXPERIMENTS';

		function initEntry() {
			var $editButton = $('#ca-ve-edit');

			if (veTourInit.isEnabled() &&
				mw.config.get('wgNamespaceNumber') === 0 &&
				mw.config.get('wgVisualEditorPreferred')
			) {
				$editButton.popover({
					content: '<div class="ve-tour-experiment">' +
						'<div class="close"></div>' +
						'<h2>Enter edit mode</h2>' +
						'<p>Click on the Edit button to go into edit mode - there you will be able to add content ' +
						'and media to an article page.</p>' +
						'<nav class="nav-buttons"><button class="ve-tour-next">Next</button></nav>' +
						'</div>',
					html: true,
					placement: 'right',
					trigger: 'manual'
				});

				$editButton.popover('show');
				$('.ve-tour-next').click(startTour.bind(this, $editButton));
				$('.ve-tour-experiment .close').click(startTour.bind(this, $editButton));

				tracker.trackVerboseImpression(EXPERIMENT_NAME, 'tour-step-article-entry-point');
			}
		}

		function startTour($editButton) {
			$editButton.click();
			$.cookie('vetourdisabled', 1, {expires: 30});
			$editButton.popover('destroy');
			tracker.trackVerboseClick(EXPERIMENT_NAME, 'edit-entry-point');
		}

		function close($element) {
			$.cookie('vetourdismissed', 1, { expires: 30 });
			$element.popover('destroy');
			tracker.trackVerboseClick(EXPERIMENT_NAME, 'close-article-entry-point');
		}
		$(initEntry);
	}
);
