define('wikia.toc',['jquery', 'wikia.loader', 'wikia.mustache'], function($, loader, mustache) {
	'use strict';

	/**
	 *  Create TOC data structure
	 *
	 *  @param {Object} $headers - jQuery selector object with all headers for TOC
	 *  @param {function(object)} createSection - function that returns object for single TOC element
	 *         and takes jQuery selector as parameter. The returned object must have 'sections: []' param.
	 *
	 *         example: function createTOCSection($header) {
	 *                      $header = $header.children('.mw-headline');
	 *
	 *                      return {
	 *                          title: $header.text(),
	 *                          id: $header.attr('id'),
	 *                          sections: [] // This is required !!!!!!
	 *                      }
	 *                  }
	 *
	 *  @returns {Object} - TOC data structure of all the subsections
	 */

	function getData($headers, createSection) {

		var toc = {
				sections: []
			},
			stack = [toc],
			pos = 1,
			i;

		for (i = 0; i < $headers.length; i++) {

			var header = $headers[i],
				obj = createSection($(header)),
				tempoPos = parseInt(header.nodeName.slice(1), 10);

			// skip corrupted TOC section element
			if (obj === false || typeof obj.sections  === 'undefined' || !(obj.sections instanceof Array)) {
				continue;
			}

			if (tempoPos > pos) {
				tempoPos = pos + 1; // fix pos problem with header 1,3 => 1,2
			} else {
				var itemsToRemove = pos - tempoPos + 1;

				stack.splice(-itemsToRemove);
			}

			pos = tempoPos; // update current position
			stack.push(obj);
			stack[stack.length - 2].sections.push(stack[stack.length - 1]);
		}

		return stack[0];
	}

	/**
	 *  Renders TOC HTML
	 *
	 *  @param  {String} templateUrl - URL for the mustache TOC template
	 *  @param {Object} data - object with variables for mustache template
	 *  @returns {Object} - promise with TOC HTML
	 */

	function render(templateUrl, data) {

		var deferred = new $.Deferred;

		loader({
			type: loader.MULTI,
			resources: {
				mustache: templateUrl
			}
		}).done(function(resources) {
			var html = mustache.render(resources.mustache[0], data);
			deferred.resolve(html);
		});

		return deferred.promise();
	}


	/** PUBLIC API */
	return {
		getData: getData,
		render: render
	}

});