define('InsightsModule', ['wikia.tracker'],
	function(tracker) {
		'use strict';

		function init() {
			setupTracking();
		}

		function setupTracking() {
			$('.insights-module-list').on('mousedown', '.insights-module-link', function (e) {
				tracker.track({
					trackingMethod: 'analytics',
					category: 'insights-module',
					action: tracker.ACTIONS.CLICK,
					label: $(e.currentTarget).data('type')
				});
			});
		}

		return {
			init: init
		};
	}
);

require(['InsightsModule'], function (InsightsModule) {
	'use strict';
	$(InsightsModule.init);
});
