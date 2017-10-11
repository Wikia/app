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

	it('customAdsLoader call the bfaa template', function () {
		var customAdsLoader = getModule();

		spyOn(mocks.bfaa, 'show');

		customAdsLoader.loadCustomAd({type: 'bfaa'});

		expect(mocks.bfaa.show).toHaveBeenCalled();
	});

	it('customAdsLoader call the floorAdhesion template', function () {
		var customAdsLoader = getModule();

		spyOn(mocks.floorAdhesion, 'show');

		customAdsLoader.loadCustomAd({type: 'floorAdhesion'});

		expect(mocks.floorAdhesion.show).toHaveBeenCalled();
	});

});
