require(['wikia.tracker'],
	function (tracker) {
		'use strict';

		function onLinkClick() {
			/* Track a click on an insights type link */
			var trackingParams = {
				trackingMethod: 'both',
				category: 'insights-index',
				action: tracker.ACTIONS.CLICK_LINK_TEXT,
				label: $(this).parent().data('type')
			};
			tracker.track(trackingParams);
		}

		function init() {
			/* Setup click events on all links within special insights container section */
			var $insightsContainer = $('.insights-container-landing');
			$insightsContainer.find('a').each(function(){
				$(this).click(onLinkClick);
			});
		}

		init();
	}
);
