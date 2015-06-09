/*!
 * VisualEditor DataModel MWImageModel tests.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.MWImageModel' );

/* Tests */

QUnit.test( 'Create and manipulate image nodes', function ( assert ) {
	var i, imageType, imageModel, value, result, expected, expectedAlignment, method, dir,
		expect = 0,
		imageNode = {},
		images = {
			mwInlineImage: {
				dir: 'ltr',
				attrs: {
					type: 'frameless',
					href: './File:Foo.jpg',
					src: 'http://upload.wikimedia.org/wikipedia/commons/thumb/0/06/Foo.jpg/229px-Foo.jpg',
					resource: './File:Foo.jpg',
					align: 'left',
					width: '100',
					height: '150',
					mediaType: 'BITMAP',
					defaultSize: true
				},
				tests: [
					{
						methods: {
							setType: 'thumb',
							setAlignment: 'default'
						},
						results: {
							expect: {
								getImageNodeType: 'wikiaBlockImage',
								isBorderable: false
							},
							position: 'oppositeToText'
						}
					}
				]
			},
			mwBlockImage: {
				dir: 'rtl',
				attrs: {
					href: './File:Foo.jpg',
					src: 'http://upload.wikimedia.org/wikipedia/commons/thumb/0/06/Foo.jpg/229px-Foo.jpg',
					resource: './File:Foo.jpg',
					type: 'thumb',
					align: 'default',
					width: '100',
					height: '150',
					mediaType: 'DRAWING',
					defaultSize: false
				},
				tests: [
					{
						methods: {
							setType: 'frameless',
							setAlignment: 'none'
						},
						results: {
							expect: {
								getImageNodeType: 'mwInlineImage',
								getAlignment: 'none'
							},
							position: 'none'
						}
					},
					{
						methods: {
							setType: 'none',
							setAlignment: 'default',
							toggleBorder: true
						},
						results: {
							expect: {
								getImageNodeType: 'mwInlineImage',
								isBorderable: true,
								isDefaultSize: false
							},
							position: 'none'
						}
					},
					{
						methods: {
							setType: 'frame',
							setAlignment: 'default',
							toggleDefaultSize: true
						},
						results: {
							expect: {
								getImageNodeType: 'wikiaBlockImage',
								isBorderable: false,
								isDefaultSize: true
							},
							position: 'oppositeToText'
						}
					},
					{
						methods: {
							setType: 'frame',
							setAlignment: 'right'
						},
						results: {
							expect: {
								getImageNodeType: 'wikiaBlockImage'
							},
							position: 'withText'
						}
					}
				]
			}
		};

	for ( imageType in images ) {
		// Type test
		expect++;
		for ( i = 0; i < images[imageType].tests.length; i++ ) {
			// Method tests
			expect += Object.keys( images[imageType].tests[i].results.expect ).length;
			if ( images[imageType].tests[i].results.position ) {
				// Position test
				expect++;
			}
		}
	}

	QUnit.expect( expect );

	for ( imageType in images ) {
		// Create the node
		imageNode[imageType] = ve.dm.MWImageModel.static.createImageNode(
			images[imageType].attrs,
			imageType
		);

		// Verify node type
		assert.strictEqual(
			imageNode[imageType].type,
			imageType,
			'createImageNode node type: ' + imageType
		);

		// Run tests
		for ( i = 0; i < images[imageType].tests.length; i++ ) {
			dir = images[imageType].dir;

			// Start from original details
			imageModel = ve.dm.MWImageModel.static.newFromImageAttributes( images[imageType].attrs, dir );

			// Run attributes
			for ( method in images[imageType].tests[i].methods ) {
				value = images[imageType].tests[i].methods[method];
				imageModel[method]( value );
			}

			// Check result
			for ( method in images[imageType].tests[i].results.expect ) {
				result = imageModel[method]();
				expected = images[imageType].tests[i].results.expect[method];
				assert.deepEqual(
					result,
					expected,
					method
				);
			}

			// Run language-specific tests
			if ( images[imageType].tests[i].results.position ) {
				// Definition:
				// * withText (document direction; 'left' for ltr, 'right' for rtl)
				// * oppositeToText (opposite the document direction; 'right' for ltr, 'left' for rtl)
				// * none (no alignment set)
				switch ( images[imageType].tests[i].results.position ) {
					case 'withText':
						expectedAlignment = dir === 'ltr' ? 'left' : 'right';
						break;
					case 'oppositeToText':
						expectedAlignment = dir === 'ltr' ? 'right' : 'left';
						break;
					case 'none':
						expectedAlignment = 'none';
						break;
				}

				assert.strictEqual(
					imageModel.getAlignment(),
					expectedAlignment,
					'getAlignment'
				);
			}
		}
	}
} );

// TODO: ve.dm.MWImageModel#updateImageNode
// TODO: ve.dm.MWImageModel#insertImageNode
// TODO: ve.dm.MWImageModel#getUpdatedAttributes
// TODO: ve.dm.MWImageModel#onScalableDefaultSizeChange
// TODO: ve.dm.MWImageModel#setMediaNode
// TODO: ve.dm.MWImageModel#getMediaNode
// TODO: ve.dm.MWImageModel#hasBorder
// TODO: ve.dm.MWImageModel#isAligned
// TODO: ve.dm.MWImageModel#isDefaultAligned
// TODO: ve.dm.MWImageModel#getAltText
// TODO: ve.dm.MWImageModel#getType
// TODO: ve.dm.MWImageModel#getSizeType
// TODO: ve.dm.MWImageModel#getMediaType
// TODO: ve.dm.MWImageModel#getVerticalAlignment
// TODO: ve.dm.MWImageModel#getScalable
// TODO: ve.dm.MWImageModel#getCurrentDimensions
// TODO: ve.dm.MWImageModel#getCaptionDocument
// TODO: ve.dm.MWImageModel#toggleBorderable
// TODO: ve.dm.MWImageModel#cacheOriginalImageAttributes
// TODO: ve.dm.MWImageModel#getOriginalImageAttributes
// TODO: ve.dm.MWImageModel#setCurrentDimensions
// TODO: ve.dm.MWImageModel#setAltText
// TODO: ve.dm.MWImageModel#resetDefaultDimensions
// TODO: ve.dm.MWImageModel#getDefaultDimensions
// TODO: ve.dm.MWImageModel#setSizeType
// TODO: ve.dm.MWImageModel#setVerticalAlignment
// TODO: ve.dm.MWImageModel#getDefaultDir
// TODO: ve.dm.MWImageModel#getDir
// TODO: ve.dm.MWImageModel#setDir
// TODO: ve.dm.MWImageModel#setScalable
// TODO: ve.dm.MWImageModel#setCaptionDocument
