/*!
 * VisualEditor ContentEditable tests.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
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

/*
TODO: In Wikia case this test is failing because we do not support block slugs.
QUnit.test( 'getOffset', function ( assert ) {
	var i, surface, documentModel, documentView,
		expected = 0,
		testCases = [
			{
				'msg': 'Empty paragraph',
				'html': '<p></p>',
				// CE HTML summary:
				// <p><span [inlineSlug]>&#xFEFF;</span></p>
				// Linmod:
				// [<p>, </p>]
				'expected': [
					0,
					1, 1, 1, 1, 1, 1,
					2
				]
			},
			{
				'msg': 'Annotations',
				'html': '<p><i><b>Foo</b></i></p>',
				// Linmod:
				// [<p>, F, o, o, </p>]
				'expected': [
					0,
					1, 1, 1, 1,
					2,
					3,
					4, 4, 4, 4,
					5
				]
			},
			{
				'msg': 'Multiple siblings',
				'html': '<p><b><i>Foo</i><s><u>Bar</u><span>Baz</span></s></b></p>',
				// Linmod:
				// [<p>, F, o, o, B, a, r, B, a, z, </p>]
				'expected': [
					0,
					1, 1, 1, 1,
					2,
					3,
					4, 4, 4, 4, 4, 4,
					5,
					6,
					7, 7, 7, 7, 7,
					8,
					9,
					10, 10, 10, 10, 10,
					11
				]
			},
			{
				'msg': 'Annotated alien',
				'html': '<p>Foo<b><span rel="ve:Alien">Bar</span></b>Baz</p>',
				// CE HTML summary;
				// <p>Foo<b><span [focusableNode]><span [alien]>Bar</span></span></b>Baz</p>
				// Linmod:
				// [<p>, F, o, o, <alineinline>, </alineinline>, B, a, z, </p>]
				'expected': [
					0,
					1, 1,
					2,
					3,
					4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4,
					6, 6, 6,
					7,
					8,
					9, 9,
					10
				]
			},
			{
				'msg': 'Table with block slugs',
				'html': '<table><tr><td>Foo</td></tr></table>',
				// CE HTML summary;
				// <div [slugWrapper]><p [blockSlug]></p></div>
				// <table><tbody><tr><td>
				//  <p>Foo</p>
				// </td></tr></tbody></table>
				// <div [slugWrapper]><p [blockSlug]></p></div>
				// Linmod:
				// [<table>, <tbody>, <tr>, <td>, <p>, F, o, o, </p>, </td>, </tr>, </tbody>, </table>]
				'expected': [
					0, 0, 0, 0, 0, 0, 0, 0,
					1,
					2,
					3,
					4,
					5, 5,
					6,
					7,
					8, 8,
					9,
					10,
					11,
					12,
					13, 13, 13, 13, 13, 13, 13, 13
				]
			},
			{
				'msg': 'Paragraph with inline slugs',
				'html': '<p><span rel="ve:Alien">Foo</span><span rel="ve:Alien">Bar</span><br></p>',
				// CE HTML summary:
				// <p><span [inlineSlug]>&#xFEFF;</span><span [focusableNode]><span [alien]>Foo</span></span>
				// <span [inlineSlug]>&#xFEFF;</span><span [focusableNode]><span [alien]>Bar</span></span>
				// <span [inlineSlug]>&#xFEFF;</span><br></br><span [inlineSlug]>&#xFEFF;</span></p>
				// Linmod:
				// [<p>, <alineinline>, </alineinline>, <alineinline>, </alineinline>, <break>, </break>, </p>]
				'expected': [
					0,
					1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1,
					3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3,
					5, 5, 5, 5, 5, 5,
					6,
					7, 7, 7, 7, 7, 7,
					8
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
						ve.ce.getOffset( parent, i ),
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
						ve.ce.getOffset( parent, i ),
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

		testOffsets( documentView.getDocumentNode().$element[0], testCases[i], -1 );
		surface.destroy();
	}
} );
*/

// TODO: ve.ce.getOffset

// TODO: ve.ce.getOffsetOfSlug

QUnit.test( 'isLeftOrRightArrowKey', 4, function ( assert ) {
	assert.equal( ve.ce.isLeftOrRightArrowKey( OO.ui.Keys.LEFT ), true, 'Left' );
	assert.equal( ve.ce.isLeftOrRightArrowKey( OO.ui.Keys.RIGHT ), true, 'Right' );
	assert.equal( ve.ce.isLeftOrRightArrowKey( OO.ui.Keys.UP ), false, 'Up' );
	assert.equal( ve.ce.isLeftOrRightArrowKey( OO.ui.Keys.DOWN ), false, 'Down' );
} );

QUnit.test( 'isUpOrDownArrowKey', 4, function ( assert ) {
	assert.equal( ve.ce.isUpOrDownArrowKey( OO.ui.Keys.LEFT ), false, 'Left' );
	assert.equal( ve.ce.isUpOrDownArrowKey( OO.ui.Keys.RIGHT ), false, 'Right' );
	assert.equal( ve.ce.isUpOrDownArrowKey( OO.ui.Keys.UP ), true, 'Up' );
	assert.equal( ve.ce.isUpOrDownArrowKey( OO.ui.Keys.DOWN ), true, 'Down' );
} );

QUnit.test( 'isArrowKey', 5, function ( assert ) {
	assert.equal( ve.ce.isArrowKey( OO.ui.Keys.LEFT ), true, 'Left' );
	assert.equal( ve.ce.isArrowKey( OO.ui.Keys.RIGHT ), true, 'Right' );
	assert.equal( ve.ce.isArrowKey( OO.ui.Keys.UP ), true, 'Up' );
	assert.equal( ve.ce.isArrowKey( OO.ui.Keys.DOWN ), true, 'Down' );
	assert.equal( ve.ce.isArrowKey( OO.ui.Keys.ENTER ), false, 'Enter' );
} );

QUnit.test( 'isShortcutKey', 3, function ( assert ) {
	assert.equal( ve.ce.isShortcutKey( { 'ctrlKey': true } ), true, 'ctrlKey' );
	assert.equal( ve.ce.isShortcutKey( { 'metaKey': true } ), true, 'metaKey' );
	assert.equal( ve.ce.isShortcutKey( {} ), false, 'Not set' );
} );

QUnit.test( 'resolveTestOffset', function ( assert ) {
	var i, ilen, j, jlen, tests, test, testOffset, elt, pre, post, count, dom;
	tests = [
		['o', 'k'],
		// TODO: doesn't handle tags correctly yet!
		// ['w', '<b>', 'x', 'y', '</b>', 'z'],
		// ['q', '<b>', 'r', '<b>', 's', 't', '</b>', 'u', '</b>', 'v']
		['h', 'e', 'l', 'l', 'o']
	];
	count = 0;
	for ( i = 0, ilen = tests.length; i < ilen; i++ ) {
		count += tests[i].length + 1;
	}
	QUnit.expect( 2 * count );
	dom = ve.createDocumentFromHtml( '' );
	elt = dom.createElement( 'div' );
	for ( i = 0, ilen = tests.length; i < ilen; i++ ) {
		test = tests[i];
		elt.innerHTML = test.join( '' );
		for ( j = 0, jlen = test.length; j < jlen + 1; j++ ) {
			testOffset = new ve.ce.TestOffset( 'forward', j );
			pre = test.slice( 0, j ).join( '' );
			post = test.slice( j ).join( '' );
			assert.equal(
				testOffset.resolve( elt ).slice,
				pre + '|' + post
			);
			testOffset = new ve.ce.TestOffset( 'backward', j );
			pre = test.slice( 0, jlen - j ).join( '' );
			post = test.slice( jlen - j ).join( '' );
			assert.equal(
				testOffset.resolve( elt ).slice,
				pre + '|' + post
			);
		}
	}
} );

QUnit.test( 'fakeImes', function ( assert ) {
	var i, ilen, j, jlen, surface, testRunner, testName, testActions, seq, testInfo,
		action, args, count, foundEndLoop, fakePreventDefault;

	// count tests
	count = 0;
	for ( i = 0, ilen = ve.ce.imetests.length; i < ilen; i++ ) {
		testName = ve.ce.imetests[i][0];
		if ( ve.ce.imetestsBroken[testName] ) {
			// Skip broken test for now
			continue;
		}
		testActions = ve.ce.imetests[i][1];
		// For the test that there is at least one endLoop
		count++;
		for ( j = 1, jlen = testActions.length; j < jlen; j++ ) {
			action = testActions[j].action;
			if ( action === 'endLoop' ) {
				// For the test that the model and CE surface are in sync
				count++;
			}
		}
	}
	if ( !count ) {
		throw new Error( 'No IME tests found' );
	}
	QUnit.expect( count );

	// TODO: make this function actually affect the events triggered
	fakePreventDefault = function () {};

	for ( i = 0, ilen = ve.ce.imetests.length; i < ilen; i++ ) {
		testName = ve.ce.imetests[i][0];
		if ( ve.ce.imetestsBroken[testName] ) {
			// Skip broken test for now
			continue;
		}
		testActions = ve.ce.imetests[i][1];
		foundEndLoop = false;
		// First element is the testInfo
		testInfo = testActions[0];
		surface = ve.test.utils.createSurfaceFromHtml( testInfo.startDom || '' );
		surface.getModel().setSelection( new ve.Range( 1 ) );
		testRunner = new ve.ce.TestRunner( surface );
		// start at 1 to omit the testInfo
		for ( j = 1, jlen = testActions.length; j < jlen; j++ ) {
			action = testActions[j].action;
			args = testActions[j].args;
			seq = testActions[j].seq;
			if ( action === 'sendEvent' ) {
				// TODO: make preventDefault work
				args[1].preventDefault = fakePreventDefault;
			}
			testRunner[action].apply( testRunner, args );
			// Check synchronized at the end of each event loop
			if ( action === 'endLoop' ) {
				// Test that the model and CE surface are in sync
				testRunner.testEqual( assert, testName, seq );
				foundEndLoop = true;
			}
		}
		// Test that there is at least one endLoop
		assert.equal( foundEndLoop, true, testName + ' found at least one endLoop' );
		surface.destroy();
	}
} );
