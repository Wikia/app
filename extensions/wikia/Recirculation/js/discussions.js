define('ext.wikia.recirculation.discussions', [
	'jquery',
	'wikia.window',
	'wikia.abTest',
	'wikia.nirvana',
	'ext.wikia.recirculation.tracker'
], function ($, w, abTest, nirvana, tracker) {
	'use strict';

	function injectDiscussions() {
		nirvana.sendRequest({
			controller: 'Recirculation',
			method: 'discussions',
			format: 'html',
			type: 'get',
			data: {
				cityId: w.wgCityId,
				limit: 5
			},
			callback: function (response) {
				var $WikiaArticleFooter = $('#WikiaArticleFooter'),
					$response = $(response);

				if ($WikiaArticleFooter.length) {
					$WikiaArticleFooter.before($response);
				} else {
					$('#WikiaMainContentContainer').append($response);
				}

				tracker.trackImpression('discussions');
				$response.find('.discussion-timestamp').timeago();

				$response.find('.discussion-thread').click(function () {
					var slot = $(this).index() + 1,
						label = 'discussions-tile=slot-' + slot + '=discussions';
					tracker.trackClick(label);
					w.location = $(this).data('link');
				});

				$response.find('.discussion-link').mousedown(function() {
					tracker.trackClick('discussions-link');
				});
			}
		});
	}

	return injectDiscussions;
});
