/*global require*/
define('ext.wikia.recirculation.discussions', [
	'jquery',
	'wikia.window',
	'wikia.abTest',
	'wikia.nirvana',
	'ext.wikia.recirculation.tracker'
], function ($, w, abTest, nirvana, tracker) {
	var experimentName = 'RECIRCULATION_MIX';

	function injectDiscussions(done) {
		nirvana.sendRequest({
			controller: 'Recirculation',
			method: 'discussions',
			format: 'html',
			type: 'get',
			data: {
				cityId: w.wgCityId
			},
			callback: function (response) {
				var $WikiaArticleFooter = $('#WikiaArticleFooter');

				if ($WikiaArticleFooter.length) {
					$WikiaArticleFooter.before(response);
				} else {
					$('#WikiaArticleBottomAd').before(response);
				}

				done();
			}
		});
	}

	return injectDiscussions;
});
