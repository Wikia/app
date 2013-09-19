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

			// Strip out debug styles
			nodeView.$.find( '.ve-ce-generated-wrapper' ).removeAttr( 'style' );

			assert.equalDomStructure(
				nodeView.$,
				getHtml( current ),
				'Built with attributes: ' + utils.getObjectDescription( current )
			);

			previous = current;
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