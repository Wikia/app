define( 'wikia.toc', function() {
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

	function getData( headers, createSection ) {
		var toc = {
				sections: []
			}, // set base object for TOC data structure
			levels = [toc.sections], // level placeholders
			headersLength = headers.length,
			hToLevel = [], // header to TOC level dictionary
			level = -1,
			lastHeader = -1,
			headerLevel,
			i = 0,
			obj,
			header;

		for ( ; i < headersLength; i++ ) {
			header = headers[i];
			obj = createSection( header ); // create section object from HTML header node

			// skip corrupted TOC section element
			if ( obj === false || typeof obj.sections  === 'undefined' || !( obj.sections instanceof Array ) ) {
				continue;
			}

			headerLevel = parseInt( header.nodeName.slice( 1 ), 10 ); // get position from header node (exp. <h2>)

			if ( headerLevel > lastHeader ) {
				level += 1;
			} else if ( headerLevel < lastHeader && level > 0 ) {
				level = 0;
				if ( typeof hToLevel[ headerLevel ] !== 'undefined' ) { // jump to the designated level if it is set
					level = hToLevel[ headerLevel ];
				}
			}
			hToLevel[ headerLevel ] = level;
			lastHeader = headerLevel;
			levels[ level ].push( obj );
			levels[ level + 1 ] = obj.sections;
		}

		return toc;
	}

	/** PUBLIC API */
	return {
		getData: getData
	};

});
