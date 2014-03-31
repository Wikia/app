/* jshint maxlen: 250 */
describe('ImgLzy', function () {
	'use strict';

	function getImgLzyMock(supportsWebP) {
		var logMock = function() {},
			windowMock = {
				wgEnableWebPThumbnails: true,
			},
			ImgLzy;

		logMock.levels = {};

		ImgLzy = modules['wikia.ImgLzy'](jQuery, logMock, windowMock);
		ImgLzy.browserSupportsWebP = supportsWebP === true;

		return ImgLzy;
	}

	var ImgLzy = getImgLzyMock(true), // "force" WebP support to test URL rewrites
		urls;

	// API check
	expect(typeof ImgLzy).toBe('object');
	expect(typeof ImgLzy.init).toBe('function');
	expect(typeof ImgLzy.rewriteURLForWebP).toBe('function');

	// test thumbnail URL rewrites
	urls = [
		{
			url: 'http://images.macbre.wikia-dev.com/__cb20120211200134/muppet/images/thumb/9/96/Early_elmo.jpg/300px-Early_elmo.png',
			webp: true
		},
		{
			url: 'http://images.macbre.wikia-dev.com/__cb20120211200134/muppet/images/thumb/9/96/Early_elmo.png/300px-Early_elmo.png',
			webp: true
		},
		// skip GIFs
		{
			url: 'http://images.macbre.wikia-dev.com/__cb20120211200134/muppet/images/thumb/9/96/Early_elmo.gif/300px-Early_elmo.gif',
			webp: false
		},
		// not a thumb
		{
			url: 'http://images.macbre.wikia-dev.com/__cb20060721230014/muppet/images/4/45/Rovelive.jpg',
			web: false,
		},
		// video thumb
		{
			url: 'http://images.macbre.wikia-dev.com/__cb20120603092251/muppet/images/thumb/b/b2/The_Muppets_Bollywood_Spoof_trailer_Official_HD/150px-The_Muppets_Bollywood_Spoof_trailer_Official_HD.jpg',
			webp: false
		}
	];

	urls.forEach(function(testCase) {
		var url = ImgLzy.rewriteURLForWebP(testCase.url);
		expect(url.indexOf('.webp') > -1).toBe(testCase.webp === true);
	});
});
