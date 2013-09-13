/*!
 * VisualEditor ContentEditable WikiaBlockImageNode tests.
 */

QUnit.module( 've.ce.WikiaBlockImageNode' );

/* Tests */

var getOutputHTML = (function () {
	var alignClasses = {
			'default': {
				'default': 'tright',
				'left': 'tleft',
				'right': 'tright',
				'center' : 'tnone',
				'none' : 'tnone'
			},
			'none': {
				'default': '',
				'left': 'floatleft',
				'right': 'floatright',
				'center' : 'floatnone',
				'none' : 'floatnone'
			}
		},
		mocks = {};

	mocks.attribution = [
		'<div class="picture-attribution">',
			'<img class="avatar" alt="Foo" height="16" src="Foo.png" width="16">',
			$.msg( 'oasis-content-picture-added-by', '<a href="/wiki/User:Foo">Foo</a>' ),
		'</div>'
	].join( '' );

	mocks.shield = '<img class="ve-ce-protectedNode-shield" ' +
		'src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">';

	mocks.frame = [
		'<figure class="thumb thumbinner" style="">',
			'<a class="image" href="Foo"><img src="Bar"></a>',
			'<a class="internal sprite details magnify ve-no-shield"></a>',
			'<figcaption class="thumbcaption ve-ce-branchNode">',
				'<p class="ve-ce-generated-wrapper ve-ce-branchNode">abc</p>',
			'</figcaption>',
		'</figure>'
	].join( '' );

	mocks.frameless = [
		'<div class="" style="">',
			'<a class="image" href="Foo"><img src="Bar"></a>',
		'</div>'
	].join( '' );

	mocks.thumb = mocks.frame;
	mocks.none = mocks.frameless;

	return function ( attributes ) {
		var $root,
			$mock = $( mocks[ attributes.type ] ),
			alignType = (
				attributes.type === 'frameless' ||
				attributes.type === 'none'
			) ? 'none' : 'default',
			height = attributes.height || 1,
			width = attributes.width || 2;

		$mock.addClass( alignClasses[ alignType ][ attributes.align ] );

		if ( alignType !== 'none' ) {
			$mock.css( 'width', ( width + 2 ) + 'px' );
		} else {
			$mock.removeAttr( 'style' );
		}

		if ( attributes.align === 'center' ) {
			$root = $( '<div>' ).addClass( 'center' ).append( $mock );
			$mock = $root;
		}

		$mock
			.addClass( 've-ce-branchNode ve-ce-protectedNode' )
			.attr( 'contenteditable', false )
			.append( mocks.shield )
			.find( 'img[src="Bar"]' )
				.attr({
					height: height,
					width: width
				});

		if ( width >= 102 ) {
			$mock.find( 'figcaption' ).append( mocks.attribution );
		}

		return $mock[ 0 ].outerHTML;
	};
})();

var getInputHTML = (function () {
	var alignClasses = {
			'center': 'mw-halign-center',
			'left': 'mw-halign-left',
			'none': 'mw-halign-none',
			'right': 'mw-halign-right'
		},
		mock = [
			'<figure data-mw=\'{"attribution":{"username":"Foo","avatar":"Foo.png"}}\'>',
				'<a href="Foo"><img src="Bar" resource="FooBar"></a>',
				'<figcaption>abc</figcaption>',
			'</figure>'
		].join( '' ),
		type = 'mw:Image';

	function ucFirst( str ) {
		return str.charAt( 0 ).toUpperCase() + str.slice( 1 );
	}

	return function( attributes ) {
		var $mock = $( mock ),
			typeOf = type + (
				attributes.type !== 'none' ? '/' + ucFirst( attributes.type ) : ''
			);

		if ( attributes.height === null && attributes.width === null ) {
			$mock.addClass( 'mw-default-size' );
		}

		$mock
			.addClass( alignClasses[ attributes.align ] )
			.attr( 'typeof', typeOf )
			.find( 'img[src="Bar"]' )
				.attr({
					height: attributes.height || 1,
					width: attributes.width || 2
				});

		return $mock[ 0 ].outerHTML;
	};
})();

QUnit.test( 'Verify rendered content', function( assert ) {
	var $fixture = $( '#qunit-fixture' ),
		a, h, t, w, attributes,
		cases = {
			'align': [
				'default',
				'center',
				'left',
				'none',
				'right'
			],
			'height': [
				null,
				100
			],
			'type': [
				'frame',
				'frameless',
				'none',
				'thumb'
			],
			'width': [
				null,
				200
			]
		},
		doc,
		documentModel,
		documentView,
		nodeView,
		surface,
		surfaceModel,
		surfaceView,
		target,
		ti,
		test,
		tl,
		expectCount = 0,
		tests = [];

	// TODO: make this less fugly
	for ( a = 0; a < cases.align.length; a++ ) {
		for ( h = 0; h < cases.height.length; h++ ) {
			for ( t = 0; t < cases.type.length; t++ ) {
				for ( w = 0; w < cases.width.length; w++ ) {
					attributes = {
						align: cases.align[ a ],
						height: cases.height[ h ],
						type: cases.type[ t ],
						width: cases.width[ w ]
					};

					tests.push({
						attributes: attributes,
						inputHTML: getInputHTML( attributes ),
						outputHTML: getOutputHTML( attributes )
					});
				}
			}
		}
	}

	function makeAssertion() {
		// TODO: figure out a better way to remove debug styles
		nodeView.$.find( '.ve-ce-generated-wrapper' ).removeAttr( 'style' );
		assert.equalDomElement( nodeView.$[ 0 ], $( test.outputHTML )[ 0 ], JSON.stringify( test.attributes ) || 'default' );
		expectCount++;
	}

	for ( ti = 0, tl = tests.length; ti < tl; ti++ ) {
		test = tests[ ti ];

		// Set up the document
		doc = ve.createDocumentFromHtml( test.inputHTML );
		target = new ve.init.sa.Target( $fixture, doc );
		surface = target.surface;
		surfaceModel = surface.getModel();
		surfaceView = surface.getView();
		documentModel = surfaceModel.getDocument();
		documentView = surfaceView.getDocument();

		// Get the node
		nodeView = documentView.documentNode.children[ 0 ];

		makeAssertion();

/*
		surfaceModel.change(
			ve.dm.Transaction.newFromAttributeChanges(
				documentModel,
				nodeView.getOffset(),
				test.attributes
			)
		);

		// Test inverse
		if ( ci > 0 ) {
			surfaceModel.undo();
			// TODO: more useful msg
			makeAssertion( testCases[ ci - 1 ] );
			surfaceModel.redo();
		}
*/
	}

	QUnit.expect( expectCount );
});