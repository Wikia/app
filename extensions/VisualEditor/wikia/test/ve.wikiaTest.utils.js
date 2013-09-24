/*!
 * VisualEditor Wikia test utilities.
 *
 * TODO: determine what can be moved to ve.test.utils.js
 */

/**
 * @namespace
 * @ignore
 */
ve.wikiaTest = ( function () {
	var utils = {};

	/**
	 * Disables debug mode while tests are running.
	 *
	 * @method
	 * @static
	 * @returns {Object} Setup and teardown methods for module.
	 */
	utils.disableDebugModeForTests = function () {
		var debug;
		return {
			setup: function() {
				debug = ve.debug;
				ve.debug = false;
			},
			teardown: function() {
				ve.debug = debug;
			}
		};
	};

	/**
	 * Generates a string which describes an objects contents.
	 * @example 'key1: value1, key2: value2'
	 *
	 * @method
	 * @static
	 * @param {Object} obj The object to describe.
	 * @param {String} joinStr The string used to join keys and values.
	 * @param {String} pairStr The string used to join key/value pairs.
	 * @returns {String} The object description string.
	 */
	utils.getObjectDescription = function ( obj, joinStr, pairStr ) {
		var key,
			parts = [];

		joinStr = joinStr || ', ';
		pairStr = pairStr || ': ';

		for ( key in obj ) {
			parts.push( key + pairStr + obj[ key ] );
		}

		return parts.join( joinStr );
	};

	/**
	 * Creates the diff of an object based on value.
	 * Null values are ignored.
	 *
	 * @method
	 * @static
	 * @param {Object} first The base object.
	 * @param {Object} second The object to compare values from.
	 * @returns {Object} An object containing all the different values.
	 */
	utils.getObjectDiff = function ( first, second ) {
		var key,
			result = {},
			value;

		for ( key in second ) {
			value = second[ key ];
			if ( value !== null && first[ key ] !== value ) {
				result[ key ] = value;
			}
		}

		return result;
	};

	/**
	 * Generates all of the permutations from the given data to produce
	 * a set of test cases to use in unit tests.
	 *
	 * @method
	 * @static
	 * @param {Object} data An object containing arrays of possible values for each key.
	 * @returns {Array} An array of test case permutations.
	 */
	utils.getTestCases = function ( data ) {
		var i,
			j,
			k,
			l,
			testCases = [];

		// TODO: make this actually recursive
		for ( i = 0; i < data.align.length; i++ ) {
			for ( j = 0; j < data.height.length; j++ ) {
				for ( k = 0; k < data.type.length; k++ ) {
					for ( l = 0; l < data.width.length; l++ ) {
						testCases.push({
							align: data.align[ i ],
							height: data.height[ j ],
							type: data.type[ k ],
							width: data.width[ l ]
						});
					}
				}
			}
		}

		return testCases;
	};

	/**
	 * Uppercase the first letter in a string.
	 *
	 * @method
	 * @static
	 * @param {String} str The string.
	 * @returns {String} The string with the first letter uppercased.
	 */
	utils.ucFirst = function ( str ) {
		return str.charAt( 0 ).toUpperCase() + str.slice( 1 );
	};

	/* Media Utils */

	utils.media = {};

	/**
	 * Runs the QUnit tests for generating node views from HTML DOM.
	 * Should be used inside of a QUnit.test()
	 *
	 * @method
	 * @static
	 * @param {Object} assert QUnit.assert object
	 * @param {String} displayType The node's display type: 'block' or 'inline'
	 * @param {String} rdfaType The node's RDFa type: 'mw:Image' or 'mw:Video'
	 * @param {Function} callback A function that returns the proper node view from a document node
	 */
	utils.media.runHtmlDomToNodeViewTests = function ( assert, displayType, rdfaType, callback ) {
		var $fixture = $( '#qunit-fixture' ),
			current,
			doc,
			documentModel,
			documentView,
			getHtml,
			i,
			media = ve.ce.wikiaExample.media,
			nodeView,
			previous = {},
			surface,
			testCases = utils.getTestCases( media.data.testCases[ displayType ][ rdfaType ] );

		getHtml = media[ displayType ][ rdfaType ].getHtml;

		for ( i = 0; i < testCases.length; i++ ) {
			current = testCases[i];

			doc = ve.createDocumentFromHtml(
				media.getHtmlDom( displayType, rdfaType, current )
			);

			surface = new ve.init.sa.Target( $fixture, doc ).surface;
			documentModel = surface.getModel().getDocument();
			documentView = surface.getView().getDocument();
			nodeView = callback( documentView.getDocumentNode() );

			assert.equalDomStructure(
				nodeView.$,
				getHtml( current ),
				'Built with attributes: ' + utils.getObjectDescription( current )
			);

			surface.destroy();

			previous = current;
		}

		QUnit.expect( testCases.length );
	};

	/**
	 * Runs the QUnit tests for performing transaction changes on node views.
	 * Should be used inside of a QUnit.test()
	 *
	 * @method
	 * @static
	 * @param {Object} assert QUnit.assert object
	 * @param {String} displayType The node's display type: 'block' or 'inline'
	 * @param {String} rdfaType The node's RDFa type: 'mw:Image' or 'mw:Video'
	 * @param {Function} callback A function that returns the proper node view from a document node
	 */
	utils.media.runNodeViewTransactionTests = function ( assert, displayType, rdfaType, callback ) {
		var $fixture = $( '#qunit-fixture' ),
			current,
			diff,
			doc,
			documentModel,
			documentView,
			getHtml,
			i,
			media = ve.ce.wikiaExample.media,
			merged,
			nodeView,
			previous,
			surface,
			surfaceModel,
			testCases = utils.getTestCases( media.data.testCases[ displayType ][ rdfaType ] );

		getHtml = media[ displayType ][ rdfaType ].getHtml;
		previous = testCases[0];

		doc = ve.createDocumentFromHtml(
			media.getHtmlDom( displayType, rdfaType, previous )
		);

		surface = new ve.init.sa.Target( $fixture, doc ).surface;
		surfaceModel = surface.getModel();
		documentModel = surfaceModel.getDocument();
		documentView = surface.getView().getDocument();
		nodeView = callback( documentView.getDocumentNode() );

		assert.equalDomStructure(
			nodeView.$,
			getHtml( previous ),
			'Starting with attributes: ' + utils.getObjectDescription( previous )
		);

		for ( i = 1; i < testCases.length; i++ ) {
			current = testCases[i];
			diff = utils.getObjectDiff( previous, current );
			merged = ve.extendObject( {}, previous, current, true );

			surfaceModel.change(
				ve.dm.Transaction.newFromAttributeChanges(
					documentModel,
					nodeView.getOffset(),
					diff
				)
			);

			assert.equalDomStructure(
				nodeView.$,
				getHtml( merged ),
				'Attributes changed: ' + utils.getObjectDescription( diff )
			);

			previous = merged;
		}

		QUnit.expect( testCases.length );
	};

	// Exports
	return { 'utils': utils };
}() );
