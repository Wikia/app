/*!
 * VisualEditor ContentEditable WikiaBlockImageNode tests.
 */

QUnit.module( 've.ce.WikiaBlockImageNode', {
	setup: function() {
		var a,
			data,
			h,
			t,
			w;

		this.$fixture = $( '#qunit-fixture' );
		this.permutations = [];
		this.type = 'mw:Image';

		data = ve.ce.wikiaExample.data[ this.type ];

		// TODO: make this less fugly
		for ( a = 0; a < data.align.length; a++ ) {
			for ( h = 0; h < data.height.length; h++ ) {
				for ( t = 0; t < data.type.length; t++ ) {
					for ( w = 0; w < data.width.length; w++ ) {
						this.permutations.push({
							align: data.align[ a ],
							height: data.height[ h ],
							type: data.type[ t ],
							width: data.width[ w ]
						});
					}
				}
			}
		}
	},
	teardown: function() {
		this.$fixture = null;
		this.permutations = null;
		this.type = null;
	}
} );

/* Tests */

QUnit.test( 'HTMLDOM to NodeView', function ( assert ) {
	var attributes,
		attributesDiffed,
		doc,
		documentModel,
		documentView,
		i,
		l,
		nodeView,
		previousAttributes = {},
		surface,
		surfaceModel,
		surfaceView,
		target,
		expectCount = 0;

	for ( i = 0, l = this.permutations.length; i < l; i++ ) {
		attributes = this.permutations[ i ];
		attributesDiffed = ve.ce.wikiaExample.getAttributeChanges( previousAttributes, attributes );

		doc = ve.createDocumentFromHtml(
			ve.ce.wikiaExample.getBlockMediaHTMLDOM( this.type, attributes )
		);

		target = new ve.init.sa.Target( this.$fixture, doc );
		surface = target.surface;
		surfaceModel = surface.getModel();
		surfaceView = surface.getView();
		documentModel = surfaceModel.getDocument();
		documentView = surfaceView.getDocument();
		nodeView = documentView.documentNode.children[ 0 ];

		expectCount += ve.ce.wikiaExample.assertEqualNodeView(
			assert,
			nodeView,
			ve.ce.wikiaExample.getImageHTML( attributes ),
			ve.ce.wikiaExample.getAssertMessageFromAttributes( 'Attributes: ', attributes )
		);

		previousAttributes = attributes;
	}

	QUnit.expect( expectCount );
} );

QUnit.test( 'NodeView changes', function ( assert ) {
	var attributes,
		attributesDiffed,
		attributesMerged,
		doc,
		documentModel,
		documentView,
		i,
		l,
		nodeView,
		previousAttributes = this.permutations[ 0 ],
		surface,
		surfaceModel,
		surfaceView,
		target,
		expectCount = 0;

	doc = ve.createDocumentFromHtml(
		ve.ce.wikiaExample.getBlockMediaHTMLDOM( this.type, previousAttributes )
	);

	target = new ve.init.sa.Target( this.$fixture, doc );
	surface = target.surface;
	surfaceModel = surface.getModel();
	surfaceView = surface.getView();
	documentModel = surfaceModel.getDocument();
	documentView = surfaceView.getDocument();
	nodeView = documentView.documentNode.children[ 0 ];

	expectCount += ve.ce.wikiaExample.assertEqualNodeView(
		assert,
		nodeView,
		ve.ce.wikiaExample.getImageHTML( previousAttributes ),
		ve.ce.wikiaExample.getAssertMessageFromAttributes( 'Default: ', previousAttributes )
	);

	for ( i = 1, l = this.permutations.length; i < l; i++ ) {
		attributes = this.permutations[ i ];
		attributesDiffed = ve.ce.wikiaExample.getAttributeChanges( previousAttributes, attributes );
		attributesMerged = ve.ce.wikiaExample.getAttributeChanges( previousAttributes, attributes, true );

		surfaceModel.change(
			ve.dm.Transaction.newFromAttributeChanges(
				documentModel,
				nodeView.getOffset(),
				attributesDiffed
			)
		);

		expectCount += ve.ce.wikiaExample.assertEqualNodeView(
			assert,
			nodeView,
			ve.ce.wikiaExample.getImageHTML( attributesMerged ),
			ve.ce.wikiaExample.getAssertMessageFromAttributes( 'Changes: ', attributesDiffed )
		);

		previousAttributes = attributesMerged;
	}

	QUnit.expect( expectCount );
} );