/*!
 * VisualEditor test utilities.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * @class
 * @singleton
 * @ignore
 */
ve.test = { 'utils': {} };

// TODO: this is a hack to make normal heading/preformatted
// nodes the most recently registered, instead of the MW versions
ve.dm.modelRegistry.register( ve.dm.HeadingNode );
ve.dm.modelRegistry.register( ve.dm.PreformattedNode );

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
	assert.equalRange( surface.getModel().getSelection(), expectedSelection, msg + ': selections match' );

	surface.getModel().undo();

	assert.deepEqual( surface.getModel().getDocument().getFullData(), originalData, msg + ' (undo): data models match' );
	assert.equalRange( surface.getModel().getSelection(), range, msg + ' (undo): selections match' );

	surface.destroy();
};

ve.test.utils.countGetModelFromDomTests = function ( cases ) {
	var msg, n = 0;
	for ( msg in cases ) {
		if ( cases[msg].head !== undefined || cases[msg].body !== undefined ) {
			n += 2;
			if ( cases[msg].storeItems ) {
				n += cases[msg].storeItems.length;
			}
		}
	}
	return n;
};

ve.test.utils.runGetModelFromDomTest = function ( assert, caseItem, msg ) {
	var model, i, length, hash, html,
		// Make sure we've always got a <base> tag
		defaultHead = '<base href="' + ve.dm.example.base + '">';

	if ( caseItem.head !== undefined || caseItem.body !== undefined ) {
		html = '<head>' + ( caseItem.head || defaultHead ) + '</head><body>' + caseItem.body + '</body>';
		model = ve.dm.converter.getModelFromDom( ve.createDocumentFromHtml( html ) );
		ve.dm.example.preprocessAnnotations( caseItem.data, model.getStore() );
		assert.deepEqualWithDomElements( model.getFullData(), caseItem.data, msg + ': data' );
		assert.deepEqual( model.getInnerWhitespace(), caseItem.innerWhitespace || new Array( 2 ), msg + ': inner whitespace' );
		// check storeItems have been added to store
		if ( caseItem.storeItems ) {
			for ( i = 0, length = caseItem.storeItems.length; i < length; i++ ) {
				hash = caseItem.storeItems[i].hash || OO.getHash( caseItem.storeItems[i].value );
				assert.deepEqualWithDomElements(
					model.getStore().value( model.getStore().indexOfHash( hash ) ) || {},
					caseItem.storeItems[i].value,
					msg + ': store item ' + i + ' found'
				);
			}
		}
	}
};

ve.test.utils.runGetDomFromModelTest = function ( assert, caseItem, msg ) {
	var originalData, doc, store, i, length, html;

	store = new ve.dm.IndexValueStore();
	// Load storeItems into store
	if ( caseItem.storeItems ) {
		for ( i = 0, length = caseItem.storeItems.length; i < length; i++ ) {
			store.index( caseItem.storeItems[i].value, caseItem.storeItems[i].hash );
		}
	}
	if ( caseItem.modify ) {
		caseItem.modify( caseItem.data );
	}
	doc = new ve.dm.Document( ve.dm.example.preprocessAnnotations( caseItem.data, store ) );
	doc.innerWhitespace = caseItem.innerWhitespace ? ve.copy( caseItem.innerWhitespace ) : new Array( 2 );
	originalData = ve.copy( doc.getFullData() );
	html = '<body>' + ( caseItem.normalizedBody || caseItem.body ) + '</body>';
	assert.equalDomElement(
		ve.dm.converter.getDomFromModel( doc ),
		ve.createDocumentFromHtml( html ),
		msg
	);
	assert.deepEqualWithDomElements( doc.getFullData(), originalData, msg + ' (data hasn\'t changed)' );
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
	target.setup( doc );
	return target.surface;
};
