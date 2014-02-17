/*!
 * VisualEditor test utilities.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * @class
 * @singleton
 * @ignore
 */
ve.test = { 'utils': {} };

ve.test.utils.runIsolateTest = function ( assert, type, range, expected, label ) {
	var doc = ve.dm.example.createExampleDocument( 'isolationData' ),
		surface = new ve.dm.Surface( doc ),
		fragment = new ve.dm.SurfaceFragment( surface, range ),
		data;

	data = ve.copy( doc.getFullData() );
	fragment.isolateAndUnwrap( type );
	expected( data );

	assert.deepEqual( doc.getFullData(), data, label );
};

ve.test.utils.runFormatConverterTest = function ( assert, range, type, attributes, expectedSelection, expectedData, msg ) {
	var surface = ve.test.utils.createSurfaceFromHtml( ve.dm.example.isolationHtml ),
		formatAction = new ve.ui.FormatAction( surface ),
		data = ve.copy( surface.getModel().getDocument().getFullData() ),
		originalData = ve.copy( data );

	expectedData( data );

	surface.getModel().setSelection( range );
	formatAction.convert( type, attributes );

	assert.deepEqual( surface.getModel().getDocument().getFullData(), data, msg + ': data models match' );
	assert.deepEqual( surface.getModel().getSelection(), expectedSelection, msg + ': selections match' );

	surface.getModel().undo();

	assert.deepEqual( surface.getModel().getDocument().getFullData(), originalData, msg + ' (undo): data models match' );
	assert.deepEqual( surface.getModel().getSelection(), range, msg + ' (undo): selections match' );

	surface.destroy();
};

ve.test.utils.runGetDataFromDomTests = function( assert, cases ) {
	var msg, doc, store, i, length, hash, data, html, n = 0;

	// TODO: this is a hack to make normal heading/preformatted
	// nodes the most recently registered, instead of the MW versions
	ve.dm.modelRegistry.register( ve.dm.HeadingNode );
	ve.dm.modelRegistry.register( ve.dm.PreformattedNode );

	for ( msg in cases ) {
		if ( cases[msg].head !== undefined || cases[msg].body !== undefined ) {
			n += 2;
			if ( cases[msg].storeItems ) {
				n += cases[msg].storeItems.length;
			}
		}
	}
	QUnit.expect( n );

	for ( msg in cases ) {
		if ( cases[msg].head !== undefined || cases[msg].body !== undefined ) {
			doc = new ve.dm.Document( [] );
			store = doc.getStore();

			html = '<head>' + ( cases[msg].head || '' ) + '</head><body>' + cases[msg].body + '</body>';
			data = ve.dm.converter.getDataFromDom(
				ve.createDocumentFromHtml( html ), store, doc.getInternalList(), doc.getInnerWhitespace()
			);
			ve.dm.example.preprocessAnnotations( cases[msg].data, store );
			assert.deepEqualWithDomElements( data.getData(), cases[msg].data, msg + ': data' );
			assert.deepEqual( doc.getInnerWhitespace(), cases[msg].innerWhitespace || new Array( 2 ), msg + ': inner whitespace' );
			// check storeItems have been added to store
			if ( cases[msg].storeItems ) {
				for ( i = 0, length = cases[msg].storeItems.length; i < length; i++ ) {
					hash = cases[msg].storeItems[i].hash || OO.getHash( cases[msg].storeItems[i].value );
					assert.deepEqualWithDomElements(
						store.value( store.indexOfHash( hash ) ) || {},
						cases[msg].storeItems[i].value,
						msg + ': store item ' + i + ' found'
					);
				}
			}
		}
	}
};

ve.test.utils.runGetDomFromDataTests = function( assert, cases ) {
	var msg, originalData, doc, store, i, length, html, n = 0;

	for ( msg in cases ) {
		n++;
	}
	QUnit.expect( 2*n );

	for ( msg in cases ) {
		store = new ve.dm.IndexValueStore();
		// Load storeItems into store
		if ( cases[msg].storeItems ) {
			for ( i = 0, length = cases[msg].storeItems.length; i < length; i++ ) {
				store.index( cases[msg].storeItems[i].value, cases[msg].storeItems[i].hash );
			}
		}
		if ( cases[msg].modify ) {
			cases[msg].modify( cases[msg].data );
		}
		doc = new ve.dm.Document( ve.dm.example.preprocessAnnotations( cases[msg].data, store ) );
		doc.innerWhitespace = cases[msg].innerWhitespace ? ve.copy( cases[msg].innerWhitespace ) : new Array( 2 );
		originalData = ve.copy( doc.getFullData() );
		html = '<body>' + ( cases[msg].normalizedBody || cases[msg].body ) + '</body>';
		assert.equalDomElement(
			ve.dm.converter.getDomFromData( doc.getFullData(), doc.getStore(), doc.getInternalList(), doc.getInnerWhitespace() ),
			ve.createDocumentFromHtml( html ),
			msg
		);
		assert.deepEqualWithDomElements( doc.getFullData(), originalData, msg + ' (data hasn\'t changed)' );
	}
};

/**
 * Create a UI surface from some HTML
 *
 * @param {string} html Document HTML
 * @returns {ve.ui.Surface} UI surface
 */
ve.test.utils.createSurfaceFromHtml = function ( html ) {
	return this.createSurfaceFromDocument( ve.createDocumentFromHtml( html ) );
};

/**
 * Create a UI surface from a document
 * @param {ve.dm.Document|HTMLDocument} doc Document
 * @returns {ve.ui.Surface} UI surface
 */
ve.test.utils.createSurfaceFromDocument = function ( doc ) {
	var target = new ve.init.sa.Target( $( '#qunit-fixture' ), doc );
	return target.surface;
};