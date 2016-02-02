/*global require*/
require([
	'jquery',
	'wikia.abTest',
	'wikia.tracker',
	'wikia.nirvana',
], function ($, abTest, tracker, nirvana) {
	console.log('DISCUSSIONS');

	function trackClick(location) {
		tracker.track({
			action: tracker.ACTIONS.CLICK,
			category: 'recirculation',
			label: 'discussions-' + location,
			trackingMethod: 'analytics'
		});
	}

	function trackImpression() {
		tracker.track({
			action: tracker.ACTIONS.IMPRESSION,
			category: 'recirculation',
			label: 'discussions',
			trackingMethod: 'analytics'
		});
	}

	function injectDiscussions(cb) {
		nirvana.sendRequest({
			controller: 'Recirculation',
			method: 'discussions',
			format: 'html',
			type: 'get',
			callback: function (response) {
				$('#WikiaArticle').append(response);
				cb();
			}
		});
	}

	if (abTest.inGroup('RECIRCULATION_DISCUSSIONS', 'ARTICLE_FOOTER')) {
		console.log('in test!');
		injectDiscussions(function () {
			trackImpression();
			$('.discussion-timestamp').timeago();

			$('.discussion-thread').click(function () {
				trackClick('tile');
				window.location = $(this).data('link');
			});

			$('.discussion-link').mousedown(function() {
				trackClick('link');
			});
		});
	}
});
