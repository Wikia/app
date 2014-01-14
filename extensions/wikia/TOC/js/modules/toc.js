define( 'wikia.toc', function() {
	'use strict';

	/**
	 *  Create TOC data structure
	 *
	 *  @param {Array} headers - array of nodes of all headers for TOC
	 *  @param {function(object, number)} createSection - function that returns object for single TOC element
	 *         and takes single DOM header element as parameter. The returned object must have 'sections: []' param.
	 *
	 *         example: function createTOCSection(header) {
	 *                      return {
	 *                          title: header.text(),
	 *                          id: header.attr('id'),
	 *                          sections: [] // This is required !!!!!!
	 *                      }
	 *                  }
	 *  @param {function(object)} checkHeader [OPTIONAL] - function that returns object that will be passed
	 *    to createSection as a header
	 *    or a falsy value if the object is not valid section heading
	 *    by default raw header will be passed to createSection function
	 *  @returns {Object} - TOC data structure of all the subsections
	 */

	function getData( headers, createSection, checkHeader ) {
		var toc = {
				sections: []
			}, // set base object for TOC data structure
			levels =  [ toc.sections ], // level placeholders
			headersLength = headers.length,
			hToLevel = [], // header to TOC level dictionary
			level = -1,
			lastHeader = -1,
			headerLevel,
			i,
			obj,
			header;

		for ( i = 0 ; i < headersLength; i++ ) {
			header = headers[ i ];
			headerLevel = parseInt( header.nodeName.slice( 1 ), 10 ); // get position from header node (exp. <h2>)

			if ( checkHeader ) {
				header = checkHeader( header );
			}

			// skip corrupted TOC section element
			if ( !header ) {
				continue;
			}

			if ( headerLevel > lastHeader ) {
				level += 1;
			} else if ( headerLevel < lastHeader && level > 0 ) {
				level = 0;

				if ( typeof hToLevel[ headerLevel ] !== 'undefined' ) { // jump to the designated level if it is set
					level = hToLevel[ headerLevel ];
				}
			}

			obj = createSection( header, level + 1 ); // create section object from HTML header node

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
