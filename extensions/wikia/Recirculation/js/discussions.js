/*global require*/
require([
	'jquery',
	'wikia.abTest',
	'wikia.nirvana',
	'ext.wikia.recirculation.tracker'
], function ($, abTest, nirvana, tracker) {
	var experimentName = 'RECIRCULATION_DISCUSSIONS';

	function injectDiscussions(done) {
		nirvana.sendRequest({
			controller: 'Recirculation',
			method: 'discussions',
			format: 'html',
			type: 'get',
			callback: function (response) {
				$('#WikiaArticle').append(response);
				done();
			}
		});
	}

	if (abTest.inGroup(experimentName, 'ARTICLE_FOOTER')) {
		injectDiscussions(function () {
			tracker.trackVerboseImpression(experimentName, 'discussions');
			$('.discussion-timestamp').timeago();

			$('.discussion-thread').click(function () {
				tracker.trackVerboseClick(experimentName, 'discussions-tile');
				window.location = $(this).data('link');
			});

			$('.discussion-link').mousedown(function() {
				tracker.trackVerboseClick(experimentName, 'discussions-link');
			});
		});
	}
});
