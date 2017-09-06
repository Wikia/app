/*global describe, expect, it, jasmine, modules, spyOn*/
describe('ext.wikia.adEngine.lookup.prebid.adapters.audienceNetwork', function () {
	'use strict';

	function noop() {}

	var mocks = {
		instantGlobals: {
			wgAdDriverIndexExchangeBidderCountries: null
		},
		geo: {
			isProperGeo: noop
		},
		slotsContext: {},
		adContext: {
			getContext: noop
		},
		instartLogic: {
			isBlocking: noop
		}
	};

	function getAudienceNetwork() {
		return modules['ext.wikia.adEngine.lookup.prebid.adapters.audienceNetwork'](
			mocks.slotsContext,
			mocks.instartLogic,
			mocks.geo,
			mocks.instantGlobals,
			mocks.adContext
		);
	}

	it('Is disabled when geo does not match and skin is merury', function () {
		spyOn(mocks.geo, 'isProperGeo').and.returnValue(false);
		spyOn(mocks.adContext, 'getContext').and.returnValue({
			targeting: {
				skin: 'mercury'
			},
			providers: {
				audienceNetwork: true
			}
		});
		var audienceNetwork = getAudienceNetwork();

		expect(audienceNetwork.isEnabled()).toBeFalsy();
	});

	it('Is disabled when geo matches and skin is oasis', function () {
		spyOn(mocks.geo, 'isProperGeo').and.returnValue(false);
		spyOn(mocks.adContext, 'getContext').and.returnValue({
			targeting: {
				skin: 'oasis'
			},
			providers: {
				audienceNetwork: true
			}
		});

		var audienceNetwork = getAudienceNetwork();

		expect(audienceNetwork.isEnabled()).toBeFalsy();
	});

	it('Is enabled when geo matches and skin is merury', function () {
		spyOn(mocks.geo, 'isProperGeo').and.returnValue(true);
		spyOn(mocks.adContext, 'getContext').and.returnValue({
			targeting: {
				skin: 'mercury'
			},
			providers: {
				audienceNetwork: true
			}
		});

		var audienceNetwork = getAudienceNetwork();

		expect(audienceNetwork.isEnabled()).toBeTruthy();
	});

	it('Is disabled when geo matches, skin is merury but traffic is recovered', function () {
		spyOn(mocks.geo, 'isProperGeo').and.returnValue(true);
		spyOn(mocks.adContext, 'getContext').and.returnValue({
			targeting: {
				skin: 'mercury'
			},
			providers: {
				audienceNetwork: true
			}
		});
		spyOn(mocks.instartLogic, 'isBlocking').and.returnValue(true);

		var audienceNetwork = getAudienceNetwork();

		expect(audienceNetwork.isEnabled()).toBeFalsy();
	});
});
