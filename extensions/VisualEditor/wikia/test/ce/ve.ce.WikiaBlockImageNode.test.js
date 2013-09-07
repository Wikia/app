/*!
 * VisualEditor ContentEditable WikiaBlockImageNode tests.
 */

QUnit.module( 've.ce.WikiaBlockImageNode' );

/* Tests */

QUnit.test( 'Verify rendered content', function( assert ) {
	var cl,
		ci,
		doc,
		documentModel,
		documentView,
		node,
		surface,
		surfaceModel,
		surfaceView,
		target,
		ti,
		test,
		testCase,
		testCases,
		tl,
		$fixture = $( '#qunit-fixture' ),
		expectCount = 0,
		tests = [
			{
				name: 'mw:Image/Thumb',
				html: '<body><figure typeof="mw:Image/Thumb" class="mw-halign-right foobar" data-mw=\'{"attribution":{"username":"Foo","avatar":"Foo.png"}}\'><a href="Foo"><img src="Bar" width="1" height="2" resource="FooBar"></a><figcaption>abc</figcaption></figure></body>',
				cases: [
					{
						msg: 'no changes',
						html: '<figure class="thumb thumbinner tright ve-ce-branchNode ve-ce-protectedNode" style="width: 3px;" contenteditable="false"><a class="image" href="Foo"><img src="Bar" width="1" height="2"></a><a class="internal sprite details magnify ve-no-shield"></a><figcaption class="thumbcaption ve-ce-branchNode"><p class="ve-ce-generated-wrapper ve-ce-branchNode">abc</p></figcaption><img class="ve-ce-protectedNode-shield" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"></figure>'
					}
				]
			}
		];

	for ( ti = 0, tl = tests.length; ti < tl; ti++ ) {
		test = tests[ ti ];
		testCases = test.cases;

		// Set up the document
		doc = ve.createDocumentFromHtml( test.html );
		target = new ve.init.sa.Target( $fixture, doc );
		surface = target.surface;
		surfaceModel = surface.getModel();
		surfaceView = surface.getView();
		documentModel = surfaceModel.getDocument();
		documentView = surfaceView.getDocument();

		// Get the node
		node = documentView.documentNode.children[ 0 ];

		for ( ci = 0, cl = testCases.length; ci < cl; ci++ ) {
			testCase = testCases[ ci ];

			if ( testCase.data !== undefined ) {
				documentModel.change( ve.dm.Transaction.newFromAttributeChanges( documentModel, node.getOffset(), testCase.data ) );
			}

			// TODO: figure out a better way to remove debug styles
			node.$.find( '.ve-ce-generated-wrapper' ).removeAttr( 'style' );
			assert.equalDomElement( node.$[ 0 ], $( testCase.html )[ 0 ], test.name + ' - ' + testCase.msg );
			expectCount++;
		}
	}

	QUnit.expect( expectCount );
});