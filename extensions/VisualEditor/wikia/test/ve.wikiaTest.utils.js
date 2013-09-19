/*!
 * VisualEditor Wikia test utilities.
 *
 * TODO: determine what can be moved to ve.test.utils.js
 */

( function () {
	var utils = {};

	// TODO: figure out a better way to remove debug styles
	//

	/**
	 * @method
	 * @static
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
	 * @method
	 * @static
	 */
	utils.getObjectDescription = function ( obj, joinStr, pairStr ) {
		var key,
			parts = [];

		if ( !joinStr ) {
			joinStr = ', ';
		}

		if ( !pairStr ) {
			pairStr = ': ';
		}

		for ( key in obj ) {
			parts.push( key + pairStr + obj[ key ] );
		}

		return parts.join( joinStr );
	};

	/**
	 * @method
	 * @static
	 */
	utils.getObjectDiff = function ( target, source ) {
		var key,
			result = {},
			value;

		for ( key in source ) {
			value = source[ key ];
			if ( value !== null && target[ key ] !== value ) {
				result[ key ] = value;
			}
		}

		return result;
	};

	/**
	 * @method
	 * @static
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
	 * @method
	 * @static
	 */
	utils.stripDebugStyles = function ( obj ) {
		return $( obj );
	};

	/**
	 * @method
	 * @static
	 */
	utils.ucFirst = function ( str ) {
		return str.charAt( 0 ).toUpperCase() + str.slice( 1 );
	};

	/* Media Utils */

	utils.media = {};

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

			previous = current;
		}

		QUnit.expect( testCases.length );
	};

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

	/**
	 * Exports
	 * @namespace
	 * @ignore
	 */
	ve.wikiaTest = { 'utils': utils };
}() );