define(
	'wikia.recommendations',
	['wikia.loader', 'wikia.window', 'wikia.mustache', 'JSMessages'],
	function(loader, win, mustache, msg) {
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
					styles: 'extensions/wikia/Recommendations/styles/recommendations.scss',
					messages: 'Recommendations',
					templates: [{
						controller: 'RecommendationsApi',
						method: 'getArticle',
						params: {
							id: win.wgArticleId
						}
					}]
				}
			}).done(function (res) {
				var data;

				loader.processStyle(res.styles);
				//loader.processScript(res.scripts);
				console.log(res);

				if (typeof(callback) === 'function') {

					data = {
						header: msg('recommendations-header')
					};
					callback(mustache.render(res.mustache[0], data)); // TODO
				}
			});
		}

		return {
			loadTemplate: loadTemplate
	};
});
