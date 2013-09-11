/*!
 * VisualEditor ContentEditable WikiaBlockImageNode tests.
 */

QUnit.module( 've.ce.WikiaBlockImageNode' );

/* Tests */

var getOutputHTML = function( type, align, size ) {
	var sizeAttr = size ? size : 100,
		out,
		alignClass = ve.ce.WikiaBlockMediaNode.static.cssClasses.default[align];

	if ( align === 'center' ) {
		out = [
			'<div class="center ve-ce-branchNode ve-ce-protectedNode" contenteditable="false">',
				'<figure class="thumb thumbinner tnone" style="width: ' + ( sizeAttr + 2 ) + 'px;">',
					'<a class="image" href="Foo"><img src="Bar" width="' + sizeAttr + '" height="' + sizeAttr + '"></a>',
					'<a class="internal sprite details magnify ve-no-shield"></a>',
					'<figcaption class="thumbcaption ve-ce-branchNode">',
						'<p class="ve-ce-generated-wrapper ve-ce-branchNode">abc</p>',
					'</figcaption>',
				'</figure>',
				'<img class="ve-ce-protectedNode-shield" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">',
			'</div>'
		];
	} else {
		out = [
			'<figure class="thumb thumbinner ' + alignClass + ' ve-ce-branchNode ve-ce-protectedNode" contenteditable="false" style="width: ' + ( sizeAttr + 2 ) + 'px;">',
				'<a class="image" href="Foo"><img src="Bar" width="' + sizeAttr + '" height="' + sizeAttr + '"></a>',
				'<a class="internal sprite details magnify ve-no-shield"></a>',
				'<figcaption class="thumbcaption ve-ce-branchNode">',
					'<p class="ve-ce-generated-wrapper ve-ce-branchNode">abc</p>',
				'</figcaption>',
				'<img class="ve-ce-protectedNode-shield" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">',
			'</figure>'
		];		
	}
	return out.join( '' );
};

var getInputHTML = function( type, align, size ) {
	var typeofAttr = 'mw:Image/' + ( ( type === 'thumb' ) ? 'Thumb' : 'Frame' ),
		classes = [],
		classAttr = '',
		sizeAttr = size ? size : 100;

	if ( size === null ) {
		classes.push( 'mw-default-size' );
	}

	switch ( align ) {
		case 'left':
			classes.push( 'mw-halign-left' );
			break;
		case 'right':
			classes.push( 'mw-halign-right' );
			break;
		case 'center':
			classes.push( 'mw-halign-center' );
			break;
		case 'none':
			classes.push( 'mw-halign-none' );
			break;
	}

	if ( classes.length > 0 ) {
		classAttr = 'class="' + classes.join( ' ' ) + '" '; 
	}

	return [
		'<figure ' + classAttr + 'typeof="' + typeofAttr + '" data-mw=\'{"attribution":{"username":"Foo","avatar":"Foo.png"}}\'>',
			'<a href="Foo"><img src="Bar" width="' + sizeAttr + '" height="' + sizeAttr + '" resource="FooBar"></a>',
			'<figcaption>abc</figcaption>',
		'</figure>'
	].join( '' );
}

QUnit.test( 'Verify rendered content - alternative', function( assert ) {
	var attributes = {
			'type': ['thumb', 'frame'], // frameless, none
			'align': ['left', 'center', 'right', 'none'], // right, default, none
			'size': [null, 1]
		},
		i, j, k,
		doc,
		target,
		surface,
		surfaceView,
		surfaceModel,
		documentView,
		documentModel,
		nodeView,
		attribute,
		item, 
		items = [],
		expectCount = 0;

	for ( i = 0; i < attributes.type.length; i++ ) {
		for ( j = 0; j < attributes.align.length; j++ ) {
			for ( k = 0; k < attributes.size.length; k++ ) {
				item = {
					'type': attributes.type[i],
					'align': attributes.align[j],
					'size': attributes.size[k]
				};
				item.input = getInputHTML( item.type, item.align, item.size );
				item.output = getOutputHTML( item.type, item.align, item.size );
				items.push( item );
			}
		}
	}
	
	for ( i = 0; i < items.length; i++ ) {
		doc = ve.createDocumentFromHtml( '<body>' + items[i].input + '</body>' );
		target =  new ve.init.sa.Target( $( '#qunit-fixture' ), doc );
		surface = target.surface;
		surfaceView = surface.getView();
		documentView = surfaceView.getDocument();
		nodeView = documentView.documentNode.children[ 0 ];

		nodeView.$.find( '.ve-ce-generated-wrapper' ).removeAttr( 'style' );

		assert.equalDomElement(
			nodeView.$[0],
			$( items[i].output )[0]
		);

		expectCount++;
	}

	for ( i = 0; i < items.length; i++ ) {
		for ( j = 0; j < items.length; j++ ) {
			if ( i !== j ) {
				doc = ve.createDocumentFromHtml( '<body>' + items[i].input + '</body>' );
				target =  new ve.init.sa.Target( $( '#qunit-fixture' ), doc );
				surface = target.surface;
				surfaceView = surface.getView();
				surfaceModel = surface.getModel();
				documentView = surfaceView.getDocument();
				documentModel = surfaceModel.getDocument();
				nodeView = documentView.documentNode.children[ 0 ];

				surfaceModel.change(
					ve.dm.Transaction.newFromAttributeChanges(
						documentModel,
						nodeView.getOffset(),
						{
							'type': items[j].type,
							'align': items[j].align,
							'width': items[j].size ? items[j].size : 100,
							'height': items[j].size ? items[j].size : 100,
						}
					)
				);

				nodeView.$.find( '.ve-ce-generated-wrapper' ).removeAttr( 'style' );

				assert.equalDomElement(
					nodeView.$[0],
					$( items[j].output )[0]
				);

				expectCount++;
			}
		}
	}

	console.log( 'items', items );

	QUnit.expect( expectCount );
});

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

	function makeAssertion( testCase ) {
		var msg = JSON.stringify( testCase.data ) || 'default';

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

		for ( ci = 0, cl = testCases.length; ci < cl; ci++ ) {
			testCase = testCases[ ci ];

			if ( testCase.data !== undefined ) {
				surfaceModel.change( ve.dm.Transaction.newFromAttributeChanges( documentModel, node.getOffset(), testCase.data ) );
			}

			makeAssertion( testCase );

			// Test inverse
			if ( ci > 0 ) {
				surfaceModel.undo();
				// TODO: more useful msg
				makeAssertion( testCases[ ci - 1 ] );
				surfaceModel.redo();
			}
		}
	}

	QUnit.expect( expectCount );
});