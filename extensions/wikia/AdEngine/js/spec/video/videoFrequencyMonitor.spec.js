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
		spyOn(window, 'Date').and.returnValue(currentDate);

		getModule().registerLaunchedVideo();

		callArguments = mocks.store.save.calls.all()[0].args[0];

		expect(window.Date).toHaveBeenCalled();
		expect(callArguments.date).toEqual(currentDate);
		expect(callArguments.pv).toEqual(10);
	});
});

