define(
	'wikia.recommendations',
	['wikia.loader', 'wikia.window', 'jquery', 'wikia.nirvana', 'wikia.arrayHelper'],
	function(loader, win, $, nirvana, arrayHelper) {
		'use strict';


		/**
		 * @desc Lazy load and insert to DOM Recommendations module
		 * @param DOMNode container for appending module
		 */
		function init(container) {
			load(insertModule, container);
		}

		/**
		 * @desc Insert recommendation HTML code and attach tracking
		 * @param {String} data recommendations HTML code
		 * @param {Node} container parent element for recommendations
		 */
		function insertModule(data, container) {
			require(['wikia.recommendations.tracking', 'wikia.document'], function(tracking, d){
				var moduleContainer = d.createElement('footer');

				moduleContainer.id = 'recommendations';
				moduleContainer.classList.add('recommendations');

				moduleContainer.innerHTML = data;

				container.appendChild(moduleContainer);

				tracking.init(moduleContainer);
			});
		}

		/**
		 * @desc Load recommendations template
		 * @param {Function} callback function passed to process received template
		 * @param {Node} container parent element for recommendations
		 */
		function load(callback, container) {
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
				loader.processStyle(res.styles);
				loader.processScript(res.scripts);

				if (typeof(callback) === 'function') {
					require(['wikia.recommendations.view'], function (view) {
						var template;

						slotsData = arrayHelper.shuffle(slotsData[0].items);

						template = view.render(slotsData, res.mustache);
						callback(template, container);
					});
				}
			});
		}

		return {
			init: init,
			load: load
	};
});
