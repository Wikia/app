define('wikia.toc', function() {
	'use strict';

	/**
	 *  Create TOC data structure
	 *
	 *  @param {Array} headers - array of nodes of all headers for TOC
	 *  @param {function(object)} createSection - function that returns object for single TOC element
	 *         and takes single DOM header element as parameter. The returned object must have 'sections: []' param.
	 *
	 *         example: function createTOCSection(header) {
	 *
	 *                      header = $(header).children('.mw-headline');
	 *
	 *                      return {
	 *                          title: header.text(),
	 *                          id: header.attr('id'),
	 *                          sections: [] // This is required !!!!!!
	 *                      }
	 *                  }
	 *
	 *  @returns {Object} - TOC data structure of all the subsections
	 */

	function getData(headers, createSection) {

		var toc = {
				sections: []
			},
			stack = [toc],
			pos = 1,
			i,
			headersLength = headers.length;

		for (i = 0; i < headersLength; i++) {

			var header = headers[i],
				obj = createSection(header),
				tempoPos = parseInt(header.nodeName.slice(1), 10),
				sections = obj.sections;

			// skip corrupted TOC section element
			if (obj === false || typeof sections  === 'undefined' || !(sections instanceof Array)) {
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

	/** PUBLIC API */
	return {
		getData: getData
	}

});
