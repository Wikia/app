/*!
 * UnicodeJS Base module tests
 *
 * @copyright 2013 UnicodeJS team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 'unicodeJS' );

QUnit.test( 'charRangeArrayRegexp', function ( assert ) {
	var i, test, doTestFunc, equalityTests, throwTests;

	equalityTests = [
		[[0x0040], '\\u0040', 'single BMP character'],
		[[0xFFFF], '\\uffff', 'highest BMP character'],
		[
			[0x005F, [0x203F, 0x2040], 0x2054, [0xFE33, 0xFE34],
				[0xFE4D, 0xFE4F], 0xFF3F],
			'[\\u005f\\u203f-\\u2040\\u2054\\ufe33-\\ufe34\\ufe4d-\\ufe4f\\uff3f]',
			'multiple BMP ranges (= ExtendNumLet from wordbreak rules)'
		],
		[[0xD7FF], '\\ud7ff', 'just below surrogate range'],
		[[0xE000], '\\ue000', 'just above surrogate range'],
		[[0x10000], '\\ud800\\udc00', 'lowest non-BMP character'],
		[[0x10001], '\\ud800\\udc01', 'second-lowest non-BMP character'],
		[[0x103FF], '\\ud800\\udfff', 'highest character with D800 leading surrogate'],
		[[0x10400], '\\ud801\\udc00', 'lowest character with D801 leading surrogate'],
		[
			[[0xFF00, 0xFFFF]],
			'[\\uff00-\\uffff]',
			'single range at top of BMP'
		],
		[
			[[0xFF00, 0x10000]],
			'[\\uff00-\\uffff]|\\ud800\\udc00',
			'single range spanning BMP and non-BMP'
		],
		[
			[0xFFFF, 0x10000, 0x10002],
			'\\uffff|\\ud800\\udc00|\\ud800\\udc02', // TODO: could compact
			'single characters, both BMP and non-BMP'
		],
		[
			[[0x0300, 0x0400], 0x10FFFF],
			'[\\u0300-\\u0400]|\\udbff\\udfff',
			'BMP range and non-BMP character'
		],
		[
			[[0xFF00, 0x103FF]],
			'[\\uff00-\\uffff]|\\ud800[\\udc00-\\udfff]',
			'range to top of D800 leading surrogate range'
		],
		[
			[[0xFF00, 0x10400]],
			'[\\uff00-\\uffff]|\\ud800[\\udc00-\\udfff]|\\ud801\\udc00',
			'range to start of D801 leading surrogate range'
		],
		[
			[[0xFF00, 0x10401]],
			'[\\uff00-\\uffff]|\\ud800[\\udc00-\\udfff]|\\ud801[\\udc00-\\udc01]',
			'range past start of D801 leading surrogate range'
		],
		[
			[[0xFF00, 0x15555]],
			'[\\uff00-\\uffff]|[\\ud800-\\ud814][\\udc00-\\udfff]|\\ud815[\\udc00-\\udd55]',
			'range spanning multiple leading surrogate ranges'
		],
		[
			[[0x10454, 0x10997]],
			'\\ud801[\\udc54-\\udfff]|\\ud802[\\udc00-\\udd97]',
			'range starting within one leading surrogate range, and ending in the next'
		],
		[
			[[0x20222, 0x29999]],
			'\\ud840[\\ude22-\\udfff]|[\\ud841-\\ud865][\\udc00-\\udfff]|\\ud866[\\udc00-\\udd99]',
			'range starting within one leading surrogate range, and ending in a distant one'
		],
		[
			[0x00AD, [0x0600, 0x0604], 0x06DD, 0x070F,
				[0x200E, 0x200F], [0x202A, 0x202E], [0x2060, 0x2064],
				[0x206A, 0x206F], 0xFEFF, [0xFFF9, 0xFFFB],
				0x110BD, [0x1D173, 0x1D17A],
				0xE0001, [0xE0020, 0xE007F]],
			// TODO: could compact
			'[\\u00ad\\u0600-\\u0604\\u06dd\\u070f' +
				'\\u200e-\\u200f\\u202a-\\u202e\\u2060-\\u2064' +
				'\\u206a-\\u206f\\ufeff\\ufff9-\\ufffb]' +
				'|\\ud804\\udcbd|\\ud834[\\udd73-\\udd7a]|\\udb40\\udc01' +
				'|\\udb40[\\udc20-\\udc7f]',
			'multiple BMP and non-BMP ranges (= Format from wordbreak rules)'
		],
		[
			[[0x0, 0xD7FF], [0xE000, 0xFFFF], [0x10000, 0x10FFFF]],
			'[\\u0000-\\ud7ff\\ue000-\\uffff]|[\\ud800-\\udbff][\\udc00-\\udfff]',
			'largest possible range'
		]
	];
	throwTests = [
		[[0xD800], 'surrogate character U+D800'],
		[[0xDFFF], 'surrogate character U+DFFF'],
		[[[0xCCCC, 0xDDDD]], 'surrogate overlap 1'],
		[[[0xDDDD, 0xEEEE]], 'surrogate overlap 2'],
		[[[0xDDDD, 0xEEEEE]], 'surrogate overlap 3'],
		[[[0xCCCC, 0xEEEE]], 'surrogate overlap 4']
	];

	QUnit.expect( equalityTests.length + throwTests.length );
	for ( i = 0; i < equalityTests.length; i++ ) {
		test = equalityTests[i];
		assert.equal(
			unicodeJS.charRangeArrayRegexp( test[0] ),
			test[1],
			test[2]
		);
	}
	for ( i = 0; i < throwTests.length; i++ ) {
		/*jshint loopfunc:true */
		test = throwTests[i];
		doTestFunc = function () {
			unicodeJS.charRangeArrayRegexp( test[0] );
		};
		assert.throws(
			doTestFunc,
			Error,
			'throw: ' + test[1]
		);
	}
});
