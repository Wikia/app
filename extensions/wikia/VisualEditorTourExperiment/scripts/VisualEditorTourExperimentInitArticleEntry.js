require(['jquery', 'mw', 'VisualEditorTourExperimentInit', 'wikia.tracker'],
	function ($, mw, veTourInit, tracker) {
		'use strict';

		var track = tracker.buildTrackingFunction({
			category: 've-editing-tour',
			trackingMethod: 'analytics'
		});

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
						'<button class="ve-tour-next">Next</button>' +
						'</div>',
					html: true,
					placement: 'bottom',
					trigger: 'manual'
				});

				$editButton.popover('show');
				$('.ve-tour-next').click(startTour.bind(this, $editButton));
				$('.ve-tour-experiment .close').click(startTour.bind(this, $editButton));

				track({
					action: tracker.ACTIONS.IMPRESSION,
					label: 'tour-step-article-entry-point'
				});
			}
		}

		function startTour($editButton) {
			$editButton.click();
			$editButton.popover('destroy');
			track({
				action: tracker.ACTIONS.CLICK,
				label: 'edit-entry-point'
			});
		}

		function close($element) {
			$.cookie('vetourdismissed', 1, { expires : 30 });
			$element.popover('destroy');
			track({
				action: tracker.ACTIONS.CLICK,
				label: 'close-article-entry-point'
			});
		}
		$(initEntry);
	}
);
