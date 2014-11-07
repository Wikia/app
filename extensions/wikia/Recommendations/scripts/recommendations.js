define('wikia.recommendations', ['wikia.loader'], function(loader){
	'use strict';

	/**
	 * Load recommendations template
	 *
	 * @param {Function} callback function passed to process recieved template
	 */
	function loadTemplate(callback) {
		var template = 'Recommendations_index',
			html;

		loader({
			type: loader.MULTI,
			resources: {
				templates: [{
					controller: 'Recommendations',
					method: 'index'
				}]
			}
		}).done(function(data) {
			html = data.templates[template];

			if (typeof(callback) === 'function') {
				loader.processStyle(data.styles);
				callback(html);
			}
		});
	}

	return {
		loadTemplate: loadTemplate
	};
});
