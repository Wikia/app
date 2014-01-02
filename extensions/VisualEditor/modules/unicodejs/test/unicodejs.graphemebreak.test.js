/*!
 * UnicodeJS Grapheme Break module tests
 *
 * @copyright 2013 UnicodeJS team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 'unicodeJS.graphemebreak' );

QUnit.test( 'splitClusters', 1, function ( assert ) {
	var expected = [
		'a',
		' ',
		' ',
		'b',
		'カ',
		'タ',
		'カ',
		'ナ',
		'c\u0300\u0327', // c with two combining chars
		'\ud800\udf08', // U+10308 OLD ITALIC LETTER THE
		'\ud800\udf08\u0302', // U+10308 + combining circumflex
		'\r\n',
		'\n',
		'\u1104\u1173', // jamo L+V
		'\u1105\u1161\u11a8', // jamo L+V+T
		'\ud83c\udded\ud83c\uddf0' // 2*regional indicator characters
	];
	assert.deepEqual(
		unicodeJS.graphemebreak.splitClusters( expected.join( '' ) ),
		expected,
		'Split clusters'
	);
});
