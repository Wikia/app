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
	mg = modules.mediagallery(mediaMock, modalMock);

	it('should be defined', function(done){
		getBody().innerHTML = '<div id="wkPage"><section id="mw-content-text"></section></div>';

		expect(typeof mg.init).toBe('function');
		expect(typeof mg.open).toBe('function');
	});
});
