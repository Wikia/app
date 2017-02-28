/*global describe, expect, it, jasmine, modules*/
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
		}
	};

	function getAudienceNetwork() {
		return modules['ext.wikia.adEngine.lookup.prebid.adapters.audienceNetwork'](
			mocks.slotsContext,
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
			}
		});

		var audienceNetwork = getAudienceNetwork();

		expect(audienceNetwork.isEnabled()).toBeTruthy();
	});
});
