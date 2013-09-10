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
		protectedNodeShield = '<img class="ve-ce-protectedNode-shield" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">',
		tests = [
			{
				type: 'mw:Image/Thumb',
				html: [
					'<body>',
						'<figure typeof="mw:Image/Thumb" data-mw=\'{"attribution":{"username":"Foo","avatar":"Foo.png"}}\'>',
							'<a href="Foo"><img src="Bar" width="1" height="2" resource="FooBar"></a>',
							'<figcaption>abc</figcaption>',
						'</figure>',
					'</body>'
				].join( '' ),
				cases: [
					{
						html: [
							'<figure class="thumb thumbinner tright ve-ce-branchNode ve-ce-protectedNode" style="width: 3px;" contenteditable="false">',
								'<a class="image" href="Foo"><img src="Bar" width="1" height="2"></a>',
								'<a class="internal sprite details magnify ve-no-shield"></a>',
								'<figcaption class="thumbcaption ve-ce-branchNode">',
									'<p class="ve-ce-generated-wrapper ve-ce-branchNode">abc</p>',
								'</figcaption>',
								protectedNodeShield,
							'</figure>'
						].join( '' )
					},
					{
						data: {
							align: 'left'
						},
						html: [
							'<figure class="thumb thumbinner tleft ve-ce-branchNode ve-ce-protectedNode" style="width: 3px;" contenteditable="false">',
								'<a class="image" href="Foo"><img src="Bar" width="1" height="2"></a>',
								'<a class="internal sprite details magnify ve-no-shield"></a>',
								'<figcaption class="thumbcaption ve-ce-branchNode">',
									'<p class="ve-ce-generated-wrapper ve-ce-branchNode">abc</p>',
								'</figcaption>',
								protectedNodeShield,
							'</figure>'
						].join( '' )
					},
					{
						data: {
							align: 'center'
						},
						html: [
							'<div class="center ve-ce-branchNode ve-ce-protectedNode" contenteditable="false">',
								'<figure class="thumb thumbinner tnone" style="width: 3px;">',
									'<a class="image" href="Foo"><img src="Bar" width="1" height="2"></a>',
									'<a class="internal sprite details magnify ve-no-shield"></a>',
									'<figcaption class="thumbcaption ve-ce-branchNode">',
										'<p class="ve-ce-generated-wrapper ve-ce-branchNode">abc</p>',
									'</figcaption>',
								'</figure>',
								protectedNodeShield,
							'</div>'
						].join( '' )
					},
					{
						data: {
							height: 10
						},
						html: [
							'<div class="center ve-ce-branchNode ve-ce-protectedNode" contenteditable="false">',
								'<figure class="thumb thumbinner tnone" style="width: 3px;">',
									'<a class="image" href="Foo"><img src="Bar" width="1" height="10"></a>',
									'<a class="internal sprite details magnify ve-no-shield"></a>',
									'<figcaption class="thumbcaption ve-ce-branchNode">',
										'<p class="ve-ce-generated-wrapper ve-ce-branchNode">abc</p>',
									'</figcaption>',
								'</figure>',
								protectedNodeShield,
							'</div>'
						].join( '' )
					},
					{
						data: {
							width: 10
						},
						html: [
							'<div class="center ve-ce-branchNode ve-ce-protectedNode" contenteditable="false">',
								'<figure class="thumb thumbinner tnone" style="width: 12px;">',
									'<a class="image" href="Foo"><img src="Bar" width="10" height="10"></a>',
									'<a class="internal sprite details magnify ve-no-shield"></a>',
									'<figcaption class="thumbcaption ve-ce-branchNode">',
										'<p class="ve-ce-generated-wrapper ve-ce-branchNode">abc</p>',
									'</figcaption>',
								'</figure>',
								protectedNodeShield,
							'</div>'
						].join( '' )
					}
				]
			},
			{
				type: 'mw:Image/Frame',
				html: [
					'<body>',
						'<figure typeof="mw:Image/Frame" data-mw=\'{"attribution":{"username":"Foo","avatar":"Foo.png"}}\'>',
							'<a href="Foo"><img src="Bar" width="1" height="2" resource="FooBar"></a>',
							'<figcaption>abc</figcaption>',
						'</figure>',
					'</body>'
				].join( '' ),
				cases: [
					{
						html: [
							'<figure class="thumb thumbinner tright ve-ce-branchNode ve-ce-protectedNode" style="width: 3px;" contenteditable="false">',
								'<a class="image" href="Foo"><img src="Bar" width="1" height="2"></a>',
								'<a class="internal sprite details magnify ve-no-shield"></a>',
								'<figcaption class="thumbcaption ve-ce-branchNode">',
									'<p class="ve-ce-generated-wrapper ve-ce-branchNode">abc</p>',
								'</figcaption>',
								protectedNodeShield,
							'</figure>'
						].join( '' )
					},
					{
						data: {
							align: 'left'
						},
						html: [
							'<figure class="thumb thumbinner tleft ve-ce-branchNode ve-ce-protectedNode" style="width: 3px;" contenteditable="false">',
								'<a class="image" href="Foo"><img src="Bar" width="1" height="2"></a>',
								'<a class="internal sprite details magnify ve-no-shield"></a>',
								'<figcaption class="thumbcaption ve-ce-branchNode">',
									'<p class="ve-ce-generated-wrapper ve-ce-branchNode">abc</p>',
								'</figcaption>',
								protectedNodeShield,
							'</figure>'
						].join( '' )
					},
					{
						data: {
							align: 'center'
						},
						html: [
							'<div class="center ve-ce-branchNode ve-ce-protectedNode" contenteditable="false">',
								'<figure class="thumb thumbinner tnone" style="width: 3px;">',
									'<a class="image" href="Foo"><img src="Bar" width="1" height="2"></a>',
									'<a class="internal sprite details magnify ve-no-shield"></a>',
									'<figcaption class="thumbcaption ve-ce-branchNode">',
										'<p class="ve-ce-generated-wrapper ve-ce-branchNode">abc</p>',
									'</figcaption>',
								'</figure>',
								protectedNodeShield,
							'</div>'
						].join( '' )
					},
					{
						data: {
							height: 10
						},
						html: [
							'<div class="center ve-ce-branchNode ve-ce-protectedNode" contenteditable="false">',
								'<figure class="thumb thumbinner tnone" style="width: 3px;">',
									'<a class="image" href="Foo"><img src="Bar" width="1" height="10"></a>',
									'<a class="internal sprite details magnify ve-no-shield"></a>',
									'<figcaption class="thumbcaption ve-ce-branchNode">',
										'<p class="ve-ce-generated-wrapper ve-ce-branchNode">abc</p>',
									'</figcaption>',
								'</figure>',
								protectedNodeShield,
							'</div>'
						].join( '' )
					},
					{
						data: {
							width: 10
						},
						html: [
							'<div class="center ve-ce-branchNode ve-ce-protectedNode" contenteditable="false">',
								'<figure class="thumb thumbinner tnone" style="width: 12px;">',
									'<a class="image" href="Foo"><img src="Bar" width="10" height="10"></a>',
									'<a class="internal sprite details magnify ve-no-shield"></a>',
									'<figcaption class="thumbcaption ve-ce-branchNode">',
										'<p class="ve-ce-generated-wrapper ve-ce-branchNode">abc</p>',
									'</figcaption>',
								'</figure>',
								protectedNodeShield,
							'</div>'
						].join( '' )
					}
				]
			}
		];

	function makeAssertion( testCase, msg ) {
		// TODO: figure out a better way to remove debug styles
		node.$.find( '.ve-ce-generated-wrapper' ).removeAttr( 'style' );
		assert.equalDomElement( node.$[ 0 ], $( testCase.html )[ 0 ], test.type + ' - ' + msg );
		expectCount++;
	}

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

		// TODO: test inverses
		for ( ci = 0, cl = testCases.length; ci < cl; ci++ ) {
			testCase = testCases[ ci ];

			if ( testCase.data !== undefined ) {
				surfaceModel.change( ve.dm.Transaction.newFromAttributeChanges( documentModel, node.getOffset(), testCase.data ) );
			}

			makeAssertion( testCase, JSON.stringify( testCase.data ) || 'default' );
		}
	}

	QUnit.expect( expectCount );
});