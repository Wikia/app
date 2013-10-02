/*!
 * UnicodeJS Word Break module tests
 *
 * @copyright 2013 UnicodeJS team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 'unicodeJS.wordbreak' );

QUnit.test( 'isBreak', function ( assert ) {
	var i, pos, result, context, breakOffsets, textString,
		broken = [
			'\u0300', 'xyz\'d', ' ', 'a', '\'', ' ',
			'\'', 'a', ' ', 'a', '-', 'b', ' ', '1a', '\r\n',
			'カタカナ', '3,1.2', ' ',
			'a_b_3_ナ_', ' ',
			'汉', '字', '/', '漢', '字', ' ',
			'c\u0300\u0327k', ' ',
			// Test ALetter characters above U+FFFF.
			// ALetter+ should be a single word
			// (ALetter Extend*)+ should be a single word
			//
			// We'll use:
			// U+10308 OLD ITALIC LETTER THE \ud800\udf08
			// U+1030A OLD ITALIC LETTER KA \ud800\udf0a
			// U+0302 COMBINING CIRCUMFLEX \u0302
			'\ud800\udf08' + '\ud800\udf08\u0302' + '\ud800\udf0a',
			' ',
			'\ud800\udf0a' + '\ud800\udf0a',
			' ', '뜨락또르', ' ', '트랙터', ' ', // hangul (composed)
			//// TODO: test the equivalent hangul decomposed into jamo
			//// '\u1104\u1173\u1105\u1161\u11a8\u1104\u1169\u1105\u1173 ' +
			//// '\u1110\u1173\u1105\u1162\u11a8\u1110\u1165' +
			' ', 'c\u0300\u0327', ' ', 'a', '.'
		];
	breakOffsets = [0];
	pos = 0;
	for ( i = 0; i < broken.length; i++ ) {
		pos += unicodeJS.graphemebreak.splitClusters( broken[i] ).length;
		breakOffsets.push( pos );
	}
	textString = new unicodeJS.TextString( broken.join( '' ) );

	QUnit.expect( textString.getLength() + 1 );

	for ( i = 0; i <= textString.getLength(); i++ ) {
		result = ( breakOffsets.indexOf( i ) !== -1 );
		context =
			textString.substring( Math.max( i - 4, 0 ), i ).getString() +
			'│' +
			textString.substring( i, Math.min( i + 4, textString.getLength() ) ).getString()
		;
		assert.equal(
			unicodeJS.wordbreak.isBreak( textString, i ),
			result,
			'Break at position ' + i + ' (expect ' + result + '): ' + context
		);
	}
});

QUnit.test( 'nextBreakOffset/prevBreakOffset', function ( assert ) {
	var i, offset = 0,
		text = 'The quick brown fox',
		textString = new unicodeJS.TextString( text ),
		breaks = [ 0, 0, 3, 4, 9, 10, 15, 16, 19, 19 ];

	QUnit.expect( 2*(breaks.length - 2) );

	for ( i = 2; i < breaks.length; i++ ) {
		offset = unicodeJS.wordbreak.nextBreakOffset( textString, offset );
		assert.equal( offset, breaks[i], 'Next break is at position ' + breaks[i] );
	}
	for ( i = breaks.length - 3; i >= 0; i-- ) {
		offset = unicodeJS.wordbreak.prevBreakOffset( textString, offset );
		assert.equal( offset, breaks[i], 'Previous break is at position ' + breaks[i] );
	}
});

QUnit.test( 'nextBreakOffset/prevBreakOffset (ignore whitespace)', function ( assert ) {
	var i, offset = 0,
		text = '   The quick  brown ..fox jumps... 3.14159 すどくスドク   ',
		textString = new unicodeJS.TextString( text ),
		nextBreaks = [ 6, 12, 19, 25, 31, 42, 49, 52 ],
		prevBreaks = [ 46, 35, 26, 22, 14, 7, 3, 0 ];

	QUnit.expect( nextBreaks.length + prevBreaks.length + 6 );

	for ( i = 0; i < nextBreaks.length; i++ ) {
		offset = unicodeJS.wordbreak.nextBreakOffset( textString, offset, true );
		assert.equal( offset, nextBreaks[i], 'Next break is at position ' + nextBreaks[i] );
	}
	for ( i = 0; i < prevBreaks.length; i++ ) {
		offset = unicodeJS.wordbreak.prevBreakOffset( textString, offset, true );
		assert.equal( offset, prevBreaks[i], 'Previous break is at position ' + prevBreaks[i] );
	}

	assert.equal( unicodeJS.wordbreak.nextBreakOffset( textString, 9, true ),
		 12, 'Jump to end of word when starting in middle of word');
	assert.equal( unicodeJS.wordbreak.nextBreakOffset( textString, 3, true ),
		 6, 'Jump to end of word when starting at start of word');
	assert.equal( unicodeJS.wordbreak.nextBreakOffset( textString, 13, true ),
		 19, 'Jump to end of word when starting in double whitespace');
	assert.equal( unicodeJS.wordbreak.prevBreakOffset( textString, 17, true ),
		 14, 'Jump to start of word when starting in middle of word');
	assert.equal( unicodeJS.wordbreak.prevBreakOffset( textString, 6, true ),
		 3, 'Jump to start of word when starting at end of word');
	assert.equal( unicodeJS.wordbreak.prevBreakOffset( textString, 13, true ),
		 7, 'Jump to start of word when starting in double whitespace');
});
