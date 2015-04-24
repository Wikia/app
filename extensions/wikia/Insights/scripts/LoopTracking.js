define(
	'ext.wikia.Insights.LoopTracking',
	[
		'wikia.tracker'
	],
	function (tracker) {
		'use strict';

		var insightType;

		function onLinkClick() {
			// Track a click on an insights item link
			var trackingParams = {
				trackingMethod: 'both',
				category: 'insights',
				action: tracker.ACTIONS.CLICK_LINK_TEXT,
				label: insightType+'-insights-list-item'
			};
			tracker.track(trackingParams);
		}

		function init() {
			var $insightsList = $('.insights-list');
			insightType = $insightsList.data('type');
			$insightsList.find('.insights-list-item-title').each(function(){
				$(this).click(onLinkClick);
			});
		}

		return {
			init: init
		};
	}
);
