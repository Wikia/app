/*global describe, it, expect, modules*/
describe('ext.wikia.adEngine.video.vastUrlBuilder', function () {
	'use strict';

	function noop() {
	}

	var REGULAR_AD_UNIT_QUERY_PARAM = '&iu=my\/ad\/unit&',
		PREMIUM_AD_UNIT_QUERY_PARAM = '&iu=premium\/ad\/unit&',
		mocks = {
			adContext: {
				getContext: function () {
					return {opts: {}};
				}
			},
			adUnitBuilder: {
				build: function () {
					return 'my/ad/unit';
				}
			},
			megaAdUnitBuilder: {
				build: function () {
					return 'premium/ad/unit';
				}
			},
			slotTargeting: {
				getWikiaSlotId: function () {
					return 'xxxx';
				}
			},
			page: {
				getPageLevelParams: function () {
					return {
						uno: 'foo',
						due: 15,
						tre: ['bar', 'zero'],
						quattro: null,
						s0: 'life',
						s1: '_project43',
						s2: 'article'
					};
				}
			},
			loc: {
				href: 'http://foo.url'
			},
			log: noop,
			slotParams: {
				src: 'src',
				pos: 'SLOT_NAME'
			}
	};

	function getModule() {
		return modules['ext.wikia.adEngine.video.vastUrlBuilder'](
			mocks.adContext,
			mocks.page,
			mocks.adUnitBuilder,
			mocks.megaAdUnitBuilder,
			mocks.slotTargeting,
			mocks.loc,
			mocks.log
		);
	}

	it('Build VAST URL with DFP domain', function () {
		var vastUrl = getModule().build('', '', 1);

		expect(vastUrl).toMatch(/^https:\/\/pubads\.g\.doubleclick\.net\/gampad\/ads/gi);
	});

	it('Build VAST URL with required DFP parameters', function () {
		var vastUrl = getModule().build('', '', 1);

		expect(vastUrl).toMatch(/output=vast&/g);
		expect(vastUrl).toMatch(/&env=vp&/g);
		expect(vastUrl).toMatch(/&gdfp_req=1&/g);
		expect(vastUrl).toMatch(/&impl=s&/g);
		expect(vastUrl).toMatch(/&unviewed_position_start=1&/g);
	});

	it('Build VAST URL with ad size horizontal', function () {
		var vastUrl = getModule().build(1.5, mocks.slotParams);

		expect(vastUrl).toMatch(/&sz=640x480&/g);
	});

	it('Build VAST URL with ad size vertical', function () {
		var vastUrl = getModule().build(0.5, mocks.slotParams);

		expect(vastUrl).toMatch(/&sz=320x480&/g);
	});

	it('Build VAST URL with ad size squared (horizontal)', function () {
		var vastUrl = getModule().build(1, mocks.slotParams);

		expect(vastUrl).toMatch(/&sz=640x480&/);
	});

	it('Build VAST URL with no ad size parameters', function () {
		var vastUrl = getModule().build(NaN, mocks.slotParams);

		expect(vastUrl).toMatch(/&sz=640x480&/);
	});

	it('Build VAST URL with referrer', function () {
		var vastUrl = getModule().build(1, mocks.slotParams);

		expect(vastUrl).toMatch(/&url=http%3A%2F%2Ffoo\.url/g);
	});

	it('Build VAST URL with description_url', function () {
		var vastUrl = getModule().build(1, mocks.slotParams);

		expect(vastUrl).toMatch(/&description_url=http%3A%2F%2Ffoo\.url/g);
	});

	it('Build VAST URL with numeric correlator', function () {
		var vastUrl = getModule().build(1, mocks.slotParams);

		expect(vastUrl).toMatch(/&correlator=\d+&/g);
	});

	it('Build VAST URL with page level params and wsi param', function () {
		var vastUrl = getModule().build(1, {});

		expect(vastUrl).toMatch(/&cust_params=wsi%3Dxxxx%26uno%3Dfoo%26due%3D15%26tre%3Dbar%2Czero%26s0%3Dlife%26s1%3D_project43%26s2%3Darticle$/g);
	});

	it('Build VAST URL with page level params, slot level params and wsi param', function () {
		var vastUrl = getModule().build(1, {
			passback: 'playwire',
			pos: 'TEST_SLOT',
			src: 'remnant'
		});

		expect(vastUrl).toMatch(/&cust_params=wsi%3Dxxxx%26uno%3Dfoo%26due%3D15%26tre%3Dbar%2Czero%26s0%3Dlife%26s1%3D_project43%26s2%3Darticle%26passback%3Dplaywire%26pos%3DTEST_SLOT%26src%3Dremnant$/);
	});

	it('Build VAST URL with regular ad unit', function () {
		var vastUrl = getModule().build(1, mocks.slotParams);

		expect(vastUrl).toMatch(REGULAR_AD_UNIT_QUERY_PARAM);
	});

	it('Build VAST URL with regular ad unit for premium ad layout and without correct video pos name', function () {
		spyOn(mocks.adContext, 'getContext').and.returnValue({opts:{premiumAdLayoutEnabled: true}});
		var vastUrl = getModule().build(1, mocks.slotParams);

		expect(vastUrl).toMatch(REGULAR_AD_UNIT_QUERY_PARAM);
	});

	it('Build VAST URL with regular ad unit for regular ad layout and with correct video pos name', function () {
		var vastUrl = getModule().build(1, mocks.slotParams, {}, 'featured');

		expect(vastUrl).toMatch(REGULAR_AD_UNIT_QUERY_PARAM);
	});

	it('Build VAST URL with premium ad unit for premium ad layout and with correct video pos name', function () {
		spyOn(mocks.adContext, 'getContext').and.returnValue({opts:{megaAdUnitBuilderEnabled: true}});
		var vastUrl = getModule().build(1, mocks.slotParams, {},'featured');

		expect(vastUrl).toMatch(PREMIUM_AD_UNIT_QUERY_PARAM);
	});

	it('Build VAST URL with restricted number of ads', function () {
		var vastUrl = getModule().build(1, mocks.slotParams, {
			numberOfAds: 1
		});

		expect(vastUrl).toMatch(/&pmad=1/);
	});

	it('Build VAST URL with restricted ads position', function () {
		var vastUrl = getModule().build(1, mocks.slotParams, {
			prerollOnly: true
		});

		expect(vastUrl).toMatch(/&vpos=preroll/);
	});

	it('Build VAST URL with content source and video ids', function () {
		var vastUrl = getModule().build(1, mocks.slotParams, {
			contentSourceId: '123',
			videoId: 'abc'
		});

		expect(vastUrl).toMatch(/&cmsid=123&vid=abc/);
	});

	it('Build VAST URL without content source and video ids when at least one is missing', function () {
		var vastUrl = getModule().build(1, mocks.slotParams, {
			contentSourceId: '123'
		});

		expect(vastUrl).not.toMatch(/&cmsid=123/);
	});

	it('Build VAST URL without content source and video ids when at least one is missing', function () {
		var vastUrl = getModule().build(1, mocks.slotParams, {
			videoId: 'abc'
		});

		expect(vastUrl).not.toMatch(/&vid=abc/);
	});
});

