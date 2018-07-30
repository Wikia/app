/*global describe, expect, it, jasmine, modules, spyOn*/
describe('ext.wikia.adEngine.lookup.prebid.adapters.audienceNetwork', function () {
	'use strict';

	function noop() {}

	var mocks = {
		slotsContext: {},
		adContext: {
			get: noop,
			getContext: noop
		},
		babDetection: {
			isBlocking: function () {
				return false;
			}
		}
	};

	function getAudienceNetwork() {
		return modules['ext.wikia.adEngine.lookup.prebid.adapters.audienceNetwork'](
			mocks.adContext,
			mocks.slotsContext,
			mocks.babDetection
		);
	}

	it('Is disabled when flag is off and skin is mercury', function () {
		spyOn(mocks.adContext, 'get').and.returnValue(false);
		spyOn(mocks.adContext, 'getContext').and.returnValue({
			targeting: {
				skin: 'mercury'
			},
			providers: {
				audienceNetwork: true
			}
		});

		expect(getAudienceNetwork().isEnabled()).toBeFalsy();
	});

	it('Is disabled when flag is on and skin is oasis', function () {
		spyOn(mocks.adContext, 'get').and.returnValue(true);
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
		spyOn(mocks.adContext, 'get').and.returnValue(true);
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
});
