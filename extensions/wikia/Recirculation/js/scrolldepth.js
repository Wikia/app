/*global require*/
require([
	'jquery',
	'wikia.tracker',
	'wikia.abTest',
	'ext.wikia.recirculation.views.incontent'
], function ($, tracker, abTest, incontent) {
	'use strict';

	if (!abTest.inGroup('RECIRCULATION_SCROLLDEPTH', 'YES')) { return; }

	$(function() {
		// Add markers to the page so we can track whether users see them.
		// RECIRCULATION_RAIL gets added on the server which is why it's not here
		$('#WikiaArticle').append('<div id="RECIRCULATION_FOOTER">');
		incontent().findSuitableSection().before('<div id="RECIRCULATION_INCONTENT">');

		$.scrollDepth({
			percentage: true,
			userTiming: false,
			pixelDepth: false,
			percentageInterval: 10,
			elements: ['#RECIRCULATION_RAIL', '#RECIRCULATION_INCONTENT', '#RECIRCULATION_FOOTER'],
			eventHandler: function(data) {
				var label = data.eventAction + '=' + data.eventLabel;
				tracker.track({
					action: 'scroll',
					category: 'recirculation',
					label: label,
					trackingMethod: 'internal'
				});
			}
		});
	});
});
