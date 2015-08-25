/*global describe, it, expect, modules, spyOn, document, window, beforeEach*/
describe('ext.wikia.adEngine.utils.cssTweaker', function () {
	'use strict';

	function noop() { return undefined; }

	var cssTweaker,
		mocks = {
			destination: {},
			log: noop,
			source: {}
		};

	beforeEach(function () {
		mocks.destination = document.createElement('div');
		mocks.destination.style = {};
		mocks.source = document.createElement('div');
		mocks.source.style.cssText = 'background-color: rgb(255, 255, 255); display: inline; ';

		cssTweaker = modules['ext.wikia.adEngine.utils.cssTweaker'](
			document,
			mocks.log,
			window
		);
		spyOn(document, 'getElementById').and.callFake(function (id) {
			return mocks[id];
		});
		spyOn(window, 'getComputedStyle').and.callFake(function (element) {
			return element.style;
		});
	});

	it('Initialization should prepare googletag object and configure pubads', function () {
		cssTweaker.copyStyles('source', 'destination');

		expect(mocks.destination.style.cssText).toBe('background-color: rgb(255, 255, 255); display: inline; ');
	});
});
