/*!
 * VisualEditor ContentEditable Document tests.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.ce.Document' );

/* Tests */

// FIXME runner copypasted from core, use data provider
QUnit.test( 'getRelativeRange (mwBlockImage / mwInlineImage)', function ( assert ) {
	var documentModel, surface, documentView, i, j, expectCount = 0,
		store = new ve.dm.IndexValueStore(),
		storeItems = [
			ve.dm.mwExample.MWBlockImage.storeItems,
			ve.dm.mwExample.MWInlineImage.storeItems
		],
		tests = [
			{
				data: [
					/* 0 */ ve.copy( ve.dm.mwExample.MWBlockImage.data[0] ),
					/* 1 */ { type: '/mwBlockImage' }
				],
				cases: [
					{
						direction: 1,
						expand: false,
						given: new ve.Range( 0 ),
						//expected: new ve.Range( 0, 2 )
						expected: new ve.Range( -1 )
					},
					{
						direction: 1,
						expand: false,
						given: new ve.Range( 0, 2 ),
						//expected: new ve.Range( 2 )
						expected: new ve.Range( -1 )
					},
					{
						direction: 1,
						expand: true,
						given: new ve.Range( 0 ),
						//expected: new ve.Range( 0, 2 )
						expected: new ve.Range( 0, -1 )
					},
					{
						direction: 1,
						expand: true,
						given: new ve.Range( 0, 2 ),
						//expected: new ve.Range( 0, 2 )
						expected: new ve.Range( 0, -1 )
					},
					{
						direction: -1,
						expand: false,
						given: new ve.Range( 2 ),
						expected: new ve.Range( 2, 0 )
					},
					{
						direction: -1,
						expand: false,
						given: new ve.Range( 2, 0 ),
						expected: new ve.Range( 0 )
					},
					{
						direction: -1,
						expand: false,
						given: new ve.Range( 0, 2 ),
						//expected: new ve.Range( 0 )
						expected: new ve.Range( 2, 0 )
					},
					{
						direction: -1,
						expand: true,
						given: new ve.Range( 2 ),
						expected: new ve.Range( 2, 0 )
					},
					{
						direction: -1,
						expand: true,
						given: new ve.Range( 2, 0 ),
						expected: new ve.Range( 2, 0 )
					},
					{
						direction: -1,
						expand: true,
						given: new ve.Range( 0, 2 ),
						expected: new ve.Range( 0 )
					}
				]
			},
			{
				data: [
					/* 0 */ ve.copy( ve.dm.mwExample.MWBlockImage.data[0] ),
					/* 1 */ { type: '/mwBlockImage' },
					/* 2 */ ve.copy( ve.dm.mwExample.MWBlockImage.data[0] ),
					/* 3 */ { type: '/mwBlockImage' }
				],
				cases: [
					{
						direction: 1,
						expand: false,
						given: new ve.Range( 0, 2 ),
						//expected: new ve.Range( 2 )
						expected: new ve.Range( -1 )
					},
					{
						direction: 1,
						expand: false,
						given: new ve.Range( 2, 4 ),
						//expected: new ve.Range( 4 )
						expected: new ve.Range( -1 )
					},
					{
						direction: 1,
						expand: true,
						given: new ve.Range( 0, 2 ),
						//expected: new ve.Range( 0, 4 )
						expected: new ve.Range( 0, -1 )
					},
					{
						direction: -1,
						expand: true,
						given: new ve.Range( 4, 2 ),
						expected: new ve.Range( 4, 0 )
					},
					{
						direction: -1,
						expand: true,
						given: new ve.Range( 2, 4 ),
						//expected: new ve.Range( 2 )
						expected: new ve.Range( 2, -1 )
					}
				]
			},
			{
				data: [
					/* 0 */ { type: 'alienBlock' },
					/* 1 */ { type: '/alienBlock' },
					/* 2 */ ve.copy( ve.dm.mwExample.MWBlockImage.data[0] ),
					/* 3 */ { type: '/mwBlockImage' },
					/* 4 */ { type: 'alienBlock' },
					/* 5 */ { type: '/alienBlock' }
				],
				cases: [
					{
						direction: 1,
						expand: false,
						given: new ve.Range( 0 ),
						//expected: new ve.Range( 0, 2 )
						expected: new ve.Range( -1 )
					},
					{
						direction: 1,
						expand: false,
						given: new ve.Range( 2 ),
						//expected: new ve.Range( 2, 4 )
						expected: new ve.Range( -1 )
					},
					{
						direction: 1,
						expand: false,
						given: new ve.Range( 2, 4 ),
						//expected: new ve.Range( 4 )
						expected: new ve.Range( -1 )
					},
					{
						direction: 1,
						expand: false,
						given: new ve.Range( 4 ),
						//expected: new ve.Range( 4, 6 )
						expected: new ve.Range( -1 )
					},
					{
						direction: 1,
						expand: true,
						given: new ve.Range( 0 ),
						//expected: new ve.Range( 0, 2 )
						expected: new ve.Range( 0, -1 )
					},
					{
						direction: 1,
						expand: true,
						given: new ve.Range( 0, 2 ),
						//expected: new ve.Range( 0, 4 )
						expected: new ve.Range( 0, -1 )
					},
					{
						direction: 1,
						expand: true,
						given: new ve.Range( 0, 4 ),
						//expected: new ve.Range( 0, 6 )
						expected: new ve.Range( 0, -1 )
					}
				]
			},
			{
				data: [
					/* 0 */ { type: 'paragraph' },
					/* 1 */ { type: 'alienInline' },
					/* 2 */ { type: '/alienInline' },
					/* 3 */ ve.copy( ve.dm.mwExample.MWInlineImage.data ),
					/* 4 */ { type: '/mwInlineImage' },
					/* 5 */ { type: 'alienInline' },
					/* 6 */ { type: '/alienInline' },
					/* 7 */ { type: '/paragraph' }
				],
				cases: [
					{
						direction: 1,
						expand: false,
						given: new ve.Range( 1 ),
						expected: new ve.Range( 1, 3 )
					},
					{
						direction: 1,
						expand: false,
						given: new ve.Range( 5 ),
						expected: new ve.Range( 5, 7 )
					}
				]
			}
		];

	for ( i = 0; i < storeItems.length; i++ ) {
		for ( j = 0; j < storeItems[i].length; j++ ) {
			store.index( storeItems[i][j].value, storeItems[i][j].hash );
		}
	}
	for ( i = 0; i < tests.length; i++ ) {
		documentModel = new ve.dm.Document( new ve.dm.ElementLinearData( store, tests[i].data ) );
		surface = ve.test.utils.createSurfaceFromDocument( documentModel );
		documentView = surface.getView().getDocument();
		for ( j = 0; j < tests[i].cases.length; j++ ) {
			expectCount++;
			assert.equalRange(
				documentView.getRelativeRange(
					tests[i].cases[j].given,
					tests[i].cases[j].direction,
					'character',
					tests[i].cases[j].expand
				),
				tests[i].cases[j].expected,
				'i: ' + i + ', j: ' + j
			);
		}
		surface.destroy();
	}
	QUnit.expect( expectCount );
} );
