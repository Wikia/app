/*global require*/
define('ext.wikia.recirculation.discussions', [
	'jquery',
	'wikia.window',
	'wikia.abTest',
	'wikia.nirvana',
	'ext.wikia.recirculation.tracker'
], function ($, w, abTest, nirvana, tracker) {

	function injectDiscussions(experimentName) {
		nirvana.sendRequest({
			controller: 'Recirculation',
			method: 'discussions',
			format: 'html',
			type: 'get',
			data: {
				cityId: w.wgCityId
			},
			callback: function (response) {
				var $WikiaArticleFooter = $('#WikiaArticleFooter'),
					$response = $(response);

				if ($WikiaArticleFooter.length) {
					$WikiaArticleFooter.before($response);
				} else {
					$('#WikiaArticleBottomAd').before($response);
				}

				tracker.trackVerboseImpression(experimentName, 'discussions');
				$response.find('.discussion-timestamp').timeago();

				$response.find('.discussion-thread').click(function () {
					var slot = $(this).index() + 1,
						label = 'discussions-tile=slot-' + slot + '=discussions';
					tracker.trackVerboseClick(experimentName, label);
					w.location = $(this).data('link');
				});

				$response.find('.discussion-link').mousedown(function() {
					tracker.trackVerboseClick(experimentName, 'discussions-link');
				});
			}
		});
	}

	return injectDiscussions;
});
