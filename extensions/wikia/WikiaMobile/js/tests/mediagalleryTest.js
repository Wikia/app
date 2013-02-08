/*
 @test-require-asset /resources/wikia/libraries/define.mock.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/mediagallery.js
 */

/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Media Gallery module", function () {
	'use strict';

	var mediaMock = {
		getImages: function() {},
	},
	modalMock = {
		getWrapper: function() {}
	},
	// ['media', 'modal', 'pager', 'thumbnailer', 'lazyload', 'track']
	mg = define.getModule(mediaMock, modalMock);

	it('should be defined', function(done){
		document.body.innerHTML = '<div id="wkPage"><section id="mw-content-text"></section></div>';

		expect(typeof mg.init).toBe('function');
		expect(typeof mg.open).toBe('function');
	});
});
