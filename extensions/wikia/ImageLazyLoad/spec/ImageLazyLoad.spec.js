/* jshint maxlen: 250 */
describe('ImgLzy', function () {
	'use strict';

	/**
	 * @desc creates ImgLzy mock
	 * @param {Boolean} supportsWebP
	 * @returns {Object}
	 */
	function getImgLzyMock(supportsWebP) {
		var logMock = function () {},
			windowMock = {
				wgEnableWebPThumbnails: true
			},
			ImgLzy;

		logMock.levels = {};

		ImgLzy = require('wikia.ImgLzy'](jQuery, logMock, windowMock, modules['wikia.thumbnailer')());
		ImgLzy.browserSupportsWebP = (supportsWebP === true);

		return ImgLzy;
	}

	it('uses webp for selected old thumbnails', function () {
		var ImgLzy = getImgLzyMock(true); // "force" WebP support to test URL rewrites

		// API check
		expect(typeof ImgLzy).toBe('object');
		expect(typeof ImgLzy.init).toBe('function');
		expect(typeof ImgLzy.rewriteURLForWebP).toBe('function');

		[
			{
				url: 'http://images.macbre.wikia-dev.com/__cb20120211200134/muppet/images/thumb/9/96/Early_elmo.jpg/' +
				'300px-Early_elmo.png',
				webp: true
			},
			{
				url: 'http://images.macbre.wikia-dev.com/__cb20120211200134/muppet/images/thumb/9/96/Early_elmo.png/' +
				'300px-Early_elmo.png',
				webp: true
			},
			// skip GIFs
			{
				url: 'http://images.macbre.wikia-dev.com/__cb20120211200134/muppet/images/thumb/9/96/Early_elmo.gif/' +
				'300px-Early_elmo.gif',
				webp: false
			},
			// not a thumb
			{
				url: 'http://images.macbre.wikia-dev.com/__cb20060721230014/muppet/images/4/45/Rovelive.jpg',
				web: false
			},
			// video thumb
			{
				url: 'http://images.macbre.wikia-dev.com/__cb20120603092251/muppet/images/thumb/9/92/' +
				'The_Muppets_Bollywood_Spoof_trailer_Official_HD/' +
				'150px-The_Muppets_Bollywood_Spoof_trailer_Official_HD.jpg',
				webp: false
			}
		].forEach(function (testCase) {
			var url = ImgLzy.rewriteURLForWebP(testCase.url);
			expect(url.indexOf('.webp') > -1).toBe(testCase.webp === true);
		});
	});

	it('handles Vignette URLs', function () {
		var ImgLzy = getImgLzyMock(true);

		[
			{
				url: 'http://vignette1.wikia.nocookie.net/nordycka/images/c/c5/' +
				'Svolder%2C_by_Otto_Sinding.jpg/revision/latest/scale-to-width/300?cb=20141031163618&path-prefix=pl',
				expected: 'http://vignette1.wikia.nocookie.net/nordycka/images/c/c5/Svolder%2C_by_Otto_Sinding.jpg/' +
				'revision/latest/scale-to-width/300?cb=20141031163618&path-prefix=pl&format=webp'
			},
			// replace the existing "format" parameter
			{
				url: 'http://vignette1.wikia.nocookie.net/nordycka/images/c/c5/Svolder%2C_by_Otto_Sinding.jpg/' +
				'revision/latest/scale-to-width/300?cb=20141031163618&path-prefix=pl&format=jpg',
				expected: 'http://vignette1.wikia.nocookie.net/nordycka/images/c/c5/Svolder%2C_by_Otto_Sinding.jpg/' +
				'revision/latest/scale-to-width/300?cb=20141031163618&path-prefix=pl&format=webp'
			},
			{
				url: 'http://vignette1.wikia.nocookie.net/nordycka/images/c/c5/Svolder%2C_by_Otto_Sinding.jpg/' +
				'revision/latest/scale-to-width/300?cb=20141031163618&path-prefix=pl&format=jpg&foo=bar',
				expected: 'http://vignette1.wikia.nocookie.net/nordycka/images/c/c5/Svolder%2C_by_Otto_Sinding.jpg/' +
				'revision/latest/scale-to-width/300?cb=20141031163618&path-prefix=pl&foo=bar&format=webp'
			}
		].forEach(function (testCase) {
			var url = ImgLzy.rewriteURLForWebP(testCase.url);
			expect(url).toBe(testCase.expected);
		});
	});
});
