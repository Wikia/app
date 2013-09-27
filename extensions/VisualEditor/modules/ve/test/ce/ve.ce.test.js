/*!
 * VisualEditor ContentEditable tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.ce' );

/* Tests */

QUnit.test( 'whitespacePattern', 4, function ( assert ) {
	assert.equal( 'a b'.match( ve.ce.whitespacePattern ), ' ', 'matches spaces' );
	assert.equal( 'a\u00A0b'.match( ve.ce.whitespacePattern ), '\u00A0', 'matches non-breaking spaces' );
	assert.equal( 'a\tb'.match( ve.ce.whitespacePattern ), null, 'does not match tab' );
	assert.equal( 'ab'.match( ve.ce.whitespacePattern ), null, 'does not match non-whitespace' );
} );

QUnit.test( 'getDomText', 1, function ( assert ) {
	assert.equal( ve.ce.getDomText(
		$( '<span>a<b><a href="#">b</a></b><span></span><i>c</i>d</span>' )[0] ),
		'abcd'
	);
} );

QUnit.test( 'getDomHash', 1, function ( assert ) {
	assert.equal(
		ve.ce.getDomHash( $( '<span>a<b><a href="#">b</a></b><span></span><i>c</i>d</span>' )[0] ),
		'<SPAN>#<B><A>#</A></B><SPAN></SPAN><I>#</I>#</SPAN>'
	);
} );

QUnit.test( 'getOffsetFrom(Element|Text)Node', function ( assert ) {
	var i, surface, documentModel, documentView,
		expected = 0,
		testCases = [
			{
				'msg': 'Annotated alien',
				'html': '<p>Foo<b><cite>Bar</cite></b>Baz</p>',
				// CE html summary;
				// <p>Foo<b><span [protectedNode]><cite>Bar</cite><img [shield]></span></b>Baz</p>
				'expected': [
					0,
					1, 1,
					2,
					3,
					4, 4, 4,
					6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6,
					7,
					8,
					9, 9,
					10
				]
			}
		];

	for ( i = 0; i < testCases.length; i++ ) {
		expected += testCases[i].expected.length;
	}

	QUnit.expect( expected );

	function testOffsets( parent, testCase, expectedIndex ) {
		var i;
		switch ( parent.nodeType ) {
			case Node.ELEMENT_NODE:
				for ( i = 0; i <= parent.childNodes.length; i++ ) {
					expectedIndex++;
					assert.equal(
						ve.ce.getOffsetFromElementNode( parent, i ),
						testCase.expected[expectedIndex],
						testCase.msg + ': offset ' + i + ' in <' + parent.nodeName.toLowerCase() + '>'
					);
					if ( parent.childNodes[i] ) {
						expectedIndex = testOffsets( parent.childNodes[i], testCase, expectedIndex );
					}
				}
				break;
			case Node.TEXT_NODE:
				for ( i = 0; i <= parent.data.length; i++ ) {
					expectedIndex++;
					assert.equal(
						ve.ce.getOffsetFromTextNode( parent, i ),
						testCase.expected[expectedIndex],
						testCase.msg + ': offset ' + i + ' in "' + parent.data + '"'
					);
				}
				break;
		}
		return expectedIndex;
	}

	for ( i = 0; i < testCases.length; i++ ) {
		surface = ve.test.utils.createSurfaceFromHtml( testCases[i].html );
		documentModel = surface.getModel().getDocument();
		documentView = surface.getView().getDocument();

		testOffsets( documentView.documentNode.$[0], testCases[i], -1 );
	}
} );

// TODO: ve.ce.getOffset

// TODO: ve.ce.getOffsetOfSlug

QUnit.test( 'isLeftOrRightArrowKey', 4, function ( assert ) {
	assert.equal( ve.ce.isLeftOrRightArrowKey( ve.Keys.LEFT ), true, 'Left' );
	assert.equal( ve.ce.isLeftOrRightArrowKey( ve.Keys.RIGHT ), true, 'Right' );
	assert.equal( ve.ce.isLeftOrRightArrowKey( ve.Keys.UP ), false, 'Up' );
	assert.equal( ve.ce.isLeftOrRightArrowKey( ve.Keys.DOWN ), false, 'Down' );
} );

QUnit.test( 'isUpOrDownArrowKey', 4, function ( assert ) {
	assert.equal( ve.ce.isUpOrDownArrowKey( ve.Keys.LEFT ), false, 'Left' );
	assert.equal( ve.ce.isUpOrDownArrowKey( ve.Keys.RIGHT ), false, 'Right' );
	assert.equal( ve.ce.isUpOrDownArrowKey( ve.Keys.UP ), true, 'Up' );
	assert.equal( ve.ce.isUpOrDownArrowKey( ve.Keys.DOWN ), true, 'Down' );
} );

QUnit.test( 'isArrowKey', 5, function ( assert ) {
	assert.equal( ve.ce.isArrowKey( ve.Keys.LEFT ), true, 'Left' );
	assert.equal( ve.ce.isArrowKey( ve.Keys.RIGHT ), true, 'Right' );
	assert.equal( ve.ce.isArrowKey( ve.Keys.UP ), true, 'Up' );
	assert.equal( ve.ce.isArrowKey( ve.Keys.DOWN ), true, 'Down' );
	assert.equal( ve.ce.isArrowKey( ve.Keys.ENTER ), false, 'Enter' );
} );

QUnit.test( 'isShortcutKey', 3, function ( assert ) {
	assert.equal( ve.ce.isShortcutKey( { 'ctrlKey': true } ), true, 'ctrlKey' );
	assert.equal( ve.ce.isShortcutKey( { 'metaKey': true } ), true, 'metaKey' );
	assert.equal( ve.ce.isShortcutKey( {} ), false, 'Not set' );
} );
