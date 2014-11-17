define(
	'wikia.recommendations',
	['wikia.loader', 'wikia.window', 'wikia.mustache'],
	function(loader, win, mustache) {
		'use strict';

		/**
		 * Load recommendations template
		 *
		 * @param {Function} callback function passed to process recieved template
		 */
		function loadTemplate(callback) {
			// TODO rethink loading template & recommendation data in one request
			loader({
				type: loader.MULTI,
				resources: {
					mustache: '/extensions/wikia/Recommendations/templates/Recommendations_index.mustache',
					//scripts: 'wikiamobile_smartbanner_js',
					styles: 'extensions/wikia/Recommendations/styles/recommendations.scss',
					//messages: 'SmartBanner',
					templates: [{
						controller: 'RecommendationsApi',
						method: 'getArticle',
						params: {
							id: win.wgArticleId
						}
					}]
				}
			}).done(function (res) {
				loader.processStyle(res.styles);
				//loader.processScript(res.scripts);
				console.log(res);

				if (typeof(callback) === 'function') {
					callback(mustache.render(res.mustache[0])); // TODO
				}
			});
		}

		return {
			loadTemplate: loadTemplate
	};
});
