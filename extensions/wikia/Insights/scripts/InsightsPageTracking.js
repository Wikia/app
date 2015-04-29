require(['wikia.tracker'],
	function (tracker) {
		'use strict';

		var track,
			insightType;

		track = Wikia.Tracker.buildTrackingFunction({
			trackingMethod: 'both',
			action: tracker.ACTIONS.CLICK_LINK_TEXT
		});

		function linkTrack(e) {
			if(e.type === 'keydown' && e.keyCode !== 13) {
				return;
			}

			/* Track a click on an insights type link */
			track({
				category: 'insights-index',
				label: $(e.currentTarget).parent().data('type')
			});
		}

		function linkTrackList(e) {
			if(e.type === 'keydown' && e.keyCode !== 13) {
				return;
			}

			/* Track a click on an insights item link */
			track({
				category: 'insights-list',
				label: insightType+'-insights-list-item'
			});
		}

		function init() {
			var $insightsContainer = $('.insights-container-landing'),
				$insightsList = $('.insights-list');

			/* Bind mousedown and keydown to invoke tracking logs earlier than regular click to avoid loosing log
			 * when reload happens quicker than tracking log */
			if ($insightsContainer.length) {
				$insightsContainer.on('mousedown keydown', 'a', linkTrack);
			}

			if ($insightsList) {
				insightType = $insightsList.data('type');

				$insightsList.on('mousedown keydown', '.insights-list-item-title', linkTrackList);
			}

		}

		$(init);
	}
);
