/* global describe, it, expect, modules */
describe('customAdsLoader', function () {
	'use strict';

	var mocks = {
		log: function() {},
		bfaa: {
			show: function() {}
		},
		floorAdhesion: {
			show: function() {}
		}
	};

	function getModule() {
		return modules['ext.wikia.adEngine.customAdsLoader'](
			mocks.log,
			mocks.bfaa,
			undefined,
			undefined,
			undefined,
			mocks.floorAdhesion
		);
	}

	it('customAdsLoader calls the bfaa template', function () {
		var customAdsLoader = getModule();

		spyOn(mocks.bfaa, 'show');

		customAdsLoader.loadCustomAd({type: 'bfaa'});

		expect(mocks.bfaa.show).toHaveBeenCalled();
	});

	it('customAdsLoader calls the floorAdhesion template', function () {
		var customAdsLoader = getModule();

		spyOn(mocks.floorAdhesion, 'show');

		customAdsLoader.loadCustomAd({type: 'floorAdhesion'});

		expect(mocks.floorAdhesion.show).toHaveBeenCalled();
	});



	it('customAdsLoader returns template execution output', function () {
		var customAdsLoader = getModule();

		spyOn(mocks.bfaa, 'show').and.returnValue('bfaa output');

		expect(customAdsLoader.loadCustomAd({type: 'bfaa'})).toEqual('bfaa output');

		expect(mocks.bfaa.show).toHaveBeenCalled();
	});

});
