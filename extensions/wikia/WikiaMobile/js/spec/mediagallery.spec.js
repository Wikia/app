/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Media Gallery module", function () {
	'use strict';

	var mediaMock = {
			getMedia: function() {}
		},
		modalMock = {
			getWrapper: function() {}
		},
		pagerMock = {

		},
		thumbnailerMock = {},
		lazyloadMock = {},
		trackMock = {},
		mg = modules.mediagallery(mediaMock, modalMock, pagerMock, thumbnailerMock, lazyloadMock, trackMock);

	it('should be defined', function(){
		expect(typeof mg.init).toBe('function');
		expect(typeof mg.open).toBe('function');
	});
});
