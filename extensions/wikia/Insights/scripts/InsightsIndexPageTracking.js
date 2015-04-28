require(['wikia.tracker'],
	function (tracker) {
		'use strict';

		function linkTrack(e) {
			/* Track a click on an insights type link */
			var trackingParams = {
				trackingMethod: 'both',
				category: 'insights-index',
				action: tracker.ACTIONS.CLICK_LINK_TEXT,
				label: $(e.currentTarget).parent().data('type')
			};
			tracker.track(trackingParams);
		}

		function onKeydownTrack(e) {
			if(e.keyCode === 13) {// Enter keycode
				linkTrack(e);
			}
		}

		function init() {
			/* Setup click events on all links within special insights container section
			 * Bind mousedown and keydown to invoke tracking logs earlier than regular click to avoid loosing log
			 * when reload happens quicker than tracking log */
			var $insightsContainer = $('.insights-container-landing');
			$insightsContainer.on('mousedown', 'a', linkTrack);
			$insightsContainer.on('keydown', 'a', onKeydownTrack);
		}

		$(init);
	}
);
