/*!
 * VisualEditor ContentEditable WikiaBlockImageNode tests.
 */

QUnit.module( 've.ce.WikiaBlockImageNode', {
	setup: function() {
		var a,
			attributes,
			data = ve.ce.wikiaExample.data[ 'mw:Image' ],
			h,
			t,
			w;

		this.$fixture = $( '#qunit-fixture' );
		this.testCases = [];

		// TODO: make this less fugly
		for ( a = 0; a < data.align.length; a++ ) {
			for ( h = 0; h < data.height.length; h++ ) {
				for ( t = 0; t < data.type.length; t++ ) {
					for ( w = 0; w < data.width.length; w++ ) {
						attributes = {
							align: data.align[ a ],
							height: data.height[ h ],
							type: data.type[ t ],
							width: data.width[ w ]
						};

						this.testCases.push({
							attributes: attributes,
							HTML: ve.ce.wikiaExample.getImageHTML( attributes ),
							HTMLDOM: ve.ce.wikiaExample.getImageHTMLDOM( attributes )
						});
					}
				}
			}
		}
	},
	teardown: function() {
		this.$fixture = null;
		this.testCases = null;
	}
} );

/* Tests */

QUnit.test( 'HTMLDOM to NodeView', function ( assert ) {
	var doc,
		documentModel,
		documentView,
		i,
		l,
		nodeView,
		surface,
		surfaceModel,
		surfaceView,
		target,
		testCase,
		expectCount = 0;

	for ( i = 0, l = this.testCases.length; i < l; i++ ) {
		testCase = this.testCases[ i ];

		doc = ve.createDocumentFromHtml( testCase.HTMLDOM );
		target = new ve.init.sa.Target( this.$fixture, doc );
		surface = target.surface;
		surfaceModel = surface.getModel();
		surfaceView = surface.getView();
		documentModel = surfaceModel.getDocument();
		documentView = surfaceView.getDocument();
		nodeView = documentView.documentNode.children[ 0 ];

		expectCount += ve.ce.wikiaExample.assertEqualNodeView( assert, nodeView, testCase );
	}

	QUnit.expect( expectCount );
} );

/*
QUnit.test( 'NodeView changes', function () {

		// Test inverse
		if ( i > 0 ) {
			debugger;
			surfaceModel.change(
				ve.dm.Transaction.newFromAttributeChanges(
					documentModel,
					nodeView.getOffset(),
					previous.nodeView.model.getAttributes()
				)
			);

			makeAssertion( previous.test );

			surfaceModel.undo();
		}

		previous = {
			nodeView: nodeView,
			test: test
		};

} );
*/