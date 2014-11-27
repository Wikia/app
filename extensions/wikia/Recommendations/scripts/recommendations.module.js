define(
	'wikia.recommendations',
	['wikia.loader', 'wikia.window', 'jquery', 'wikia.nirvana', 'wikia.arrayHelper'],
	function(loader, win, $, nirvana, arrayHelper) {
		'use strict';


		/**
		 * @desc Lazy load and insert to DOM Recommendations module
		 * @param DOMNode moduleLocation put recommendation module after this DOM element
		 */
		function init(moduleLocation) {
			load(insertModule, moduleLocation);
		}

		/**
		 * @desc Insert recommendation HTML code and attach tracking
		 * @param {String} data recommendations HTML code
		 * @param {Node} moduleLocation parent element for recommendations
		 */
		function insertModule(data, moduleLocation) {
			require(['wikia.recommendations.tracking', 'wikia.document'], function(tracking, d){
				var moduleContainer = d.createElement('footer');

				moduleContainer.id = 'recommendations';
				moduleContainer.classList.add('recommendations');

				moduleContainer.innerHTML = data;

				$(moduleLocation).after(moduleContainer);

				tracking.init(moduleContainer);
			});
		}

		/**
		 * @desc Load recommendations template
		 * @param {Function} callback function passed to process received template
		 * @param {Node} moduleLocation parent element for recommendations
		 */
		function load(callback, moduleLocation) {
			$.when(
				nirvana.sendRequest({
					controller: 'RecommendationsApi',
					method: 'getForArticle',
					data: {
						cb: win.wgStyleVersion,
						id: win.wgArticleId
					},
					type: 'get'
				}),
				loader({
					type: loader.MULTI,
					resources: {
						mustache: '/extensions/wikia/Recommendations/templates/Recommendations_index.mustache,/extensions/wikia/Recommendations/templates/Recommendations_image.mustache,/extensions/wikia/Recommendations/templates/Recommendations_video.mustache',
						scripts: 'recommendations_view_js',
						styles: 'extensions/wikia/Recommendations/styles/recommendations.scss',
						messages: 'Recommendations'
					}
				})
			).done(function (slotsData, res) {
				slotsData = slotsData[0].items;

				if (slotsData.length > 0) {
					loader.processStyle(res.styles);
					loader.processScript(res.scripts);
					if (typeof(callback) === 'function') {
						require(['wikia.recommendations.view'], function (view) {
							var template;

							slotsData = arrayHelper.shuffle(slotsData);

							template = view.render(slotsData, res.mustache);
							callback(template, moduleLocation);
						});
					}
				}
			});
		}

		return {
			init: init,
			load: load
	};
});
