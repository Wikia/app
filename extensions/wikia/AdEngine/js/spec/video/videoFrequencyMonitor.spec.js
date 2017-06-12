/*global describe, it, expect, modules, spyOn*/
describe('ext.wikia.adEngine.video.videoFrequencyMonitor', function () {
	'use strict';

	var mocks = {
		store: {
			save: function () {}
		},
		adLogicPageViewCounter: {
			get: function () {
				return 1;
			}
		}
	};

	beforeEach(function () {
		jasmine.clock().install();
	});

	afterEach(function () {
		jasmine.clock().uninstall();
	});

	function getModule() {
		return modules['ext.wikia.adEngine.video.videoFrequencyMonitor'](
			mocks.adLogicPageViewCounter,
			mocks.store
		);
	}

	it('Should send to store current pv and date', function () {
		var callArguments,
			currentDate = new Date();

		spyOn(mocks.store, 'save');
		spyOn(mocks.adLogicPageViewCounter, 'get').and.returnValue(10);
		jasmine.clock().mockDate(currentDate);

		getModule().registerLaunchedVideo();

		callArguments = mocks.store.save.calls.all()[0].args[0];

		expect(callArguments.date).toEqual(currentDate.getTime());
		expect(callArguments.pv).toEqual(10);
	});

	it('Should enable video for no previous videos play registered', function () {
		expect(getModule().videoCanBeLaunched()).toBeTruthy();
	});

});

