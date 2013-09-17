define('wikia.toc', function() {
	'use strict';

	var MAXHEADER = 2; // <h2> is the highest article header

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
			}, // set base object for TOC data structure
			stack = [toc],
			pos = MAXHEADER - 1, // set starting position
			i,
			headersLength = headers.length;

		for (i = 0; i < headersLength; i++) {

			var header = headers[i],
				obj = createSection(header), // create section object from HTML header node
				tempoPos = parseInt(header.nodeName.slice(1), 10), // get position from header node (exp. <h2>)
				sections = obj.sections;

			// skip corrupted TOC section element
			if (obj === false || typeof sections  === 'undefined' || !(sections instanceof Array)) {
				continue;
			}

			if (tempoPos > pos) {
				tempoPos = pos + 1; // fix pos problem with header 1,3 => 1,2
			} else {
				var itemsToRemove = pos - tempoPos + 1; // (+1) at least one item need to be removed from stack

				stack.splice(-itemsToRemove);
			}

			pos = tempoPos; // update current position
			stack.push(obj); // add object as last element of the stack
			stack[stack.length - 2].sections.push(stack[stack.length - 1]); // add last object from stack to sections array of its parent
		}

		return toc;
	}

	/** PUBLIC API */
	return {
		getData: getData
	}

});
