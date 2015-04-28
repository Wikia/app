require(['wikia.tracker'],
	function (tracker) {
		'use strict';

		var insightType;

		function linkTrack() {
			/* Track a click on an insights item link */
			var trackingParams = {
				trackingMethod: 'both',
				category: 'insights-list',
				action: tracker.ACTIONS.CLICK_LINK_TEXT,
				label: insightType+'-insights-list-item'
			};
			tracker.track(trackingParams);
		}

		function onKeydownTrack(e) {
			if(e.keyCode === 13) {// Enter keycode
				linkTrack(e);
			}
		}

		function init() {
			var $insightsList = $('.insights-list');

			insightType = $insightsList.data('type');

			/* Bind mousedown and keydown to invoke tracking logs earlier than regular click to avoid loosing log
			 * when reload happens quicker than tracking log */
			$insightsList.on('mousedown', '.insights-list-item-title', linkTrack);
			$insightsList.on('keydown', '.insights-list-item-title', onKeydownTrack);
		}

		$(init);
	}
);
