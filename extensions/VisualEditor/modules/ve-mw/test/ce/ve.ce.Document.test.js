/*!
 * VisualEditor ContentEditable Document tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.ce.Document' );

/* Tests */

// FIXME runner copypasted from core, use data provider
QUnit.test( 'getRelativeRange (mwBlockImage / mwInlineImage)', function ( assert ) {
	var documentModel, documentView, i, j, expectCount = 0,
		tests = [
		{
			data: [
				/* 0 */ { type: 'mwBlockImage' },
				/* 1 */ { type: '/mwBlockImage' }
			],
			cases: [
				{
					direction: 1,
					expand: false,
					given: new ve.Range( 0 ),
					expected: new ve.Range( 0, 2 )
				},
				{
					direction: 1,
					expand: false,
					given: new ve.Range( 0, 2 ),
					expected: new ve.Range( 2 )
				},
				{
					direction: 1,
					expand: true,
					given: new ve.Range( 0 ),
					expected: new ve.Range( 0, 2 )
				},
				{
					direction: 1,
					expand: true,
					given: new ve.Range( 0, 2 ),
					expected: new ve.Range( 0, 2 )
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
					expected: new ve.Range( 0 )
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
				/* 0 */ { type: 'mwBlockImage' },
				/* 1 */ { type: '/mwBlockImage' },
				/* 2 */ { type: 'mwBlockImage' },
				/* 3 */ { type: '/mwBlockImage' }
			],
			cases: [
				{
					direction: 1,
					expand: false,
					given: new ve.Range( 0, 2 ),
					expected: new ve.Range( 2 )
				},
				{
					direction: 1,
					expand: false,
					given: new ve.Range( 2, 4 ),
					expected: new ve.Range( 4 )
				},
				{
					direction: 1,
					expand: true,
					given: new ve.Range( 0, 2 ),
					expected: new ve.Range( 0, 4 )
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
					expected: new ve.Range( 2 )
				}
			]
		},
		{
			data: [
				/* 0 */ { type: 'alienBlock' },
				/* 1 */ { type: '/alienBlock' },
				/* 2 */ { type: 'mwBlockImage' },
				/* 3 */ { type: '/mwBlockImage' },
				/* 4 */ { type: 'alienBlock' },
				/* 5 */ { type: '/alienBlock' }
			],
			cases: [
				{
					direction: 1,
					expand: false,
					given: new ve.Range( 0 ),
					expected: new ve.Range( 2 )
				},
				{
					direction: 1,
					expand: false,
					given: new ve.Range( 2 ),
					expected: new ve.Range( 2, 4 )
				},
				{
					direction: 1,
					expand: false,
					given: new ve.Range( 2, 4 ),
					expected: new ve.Range( 4 )
				},
				{
					direction: 1,
					expand: false,
					given: new ve.Range( 4 ),
					expected: new ve.Range( 6 )
				},
				{
					direction: 1,
					expand: true,
					given: new ve.Range( 0 ),
					expected: new ve.Range( 0, 2 )
				},
				{
					direction: 1,
					expand: true,
					given: new ve.Range( 0, 2 ),
					expected: new ve.Range( 0, 4 )
				},
				{
					direction: 1,
					expand: true,
					given: new ve.Range( 0, 4 ),
					expected: new ve.Range( 0, 6 )
				}
			]
		},
		{
			data: [
				/* 0 */ { type: 'paragraph' },
				/* 1 */ { type: 'alienInline' },
				/* 2 */ { type: '/alienInline' },
				/* 3 */ { type: 'mwInlineImage' },
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
					expected: new ve.Range( 3 )
				},
				{
					direction: 1,
					expand: false,
					given: new ve.Range( 5 ),
					expected: new ve.Range( 7 )
				}
			]
		}
	];
	for ( i = 0; i < tests.length; i++ ) {
		documentModel = new ve.dm.Document( tests[i].data );
		documentView = new ve.ce.Document( documentModel );
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
	}
	QUnit.expect( expectCount );
} );
