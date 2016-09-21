/*global describe, it, expect, modules, beforeEach, spyOn*/
describe('ext.wikia.adEngine.video.vastBuilder', function () {
	'use strict';

	function noop () {}

	var mocks = {
			adContext: {
				addCallback: noop
			},
			adUnitBuilder: {
				build: noop
			},
			page: {
				getPageLevelParams: function () {
					return {
						uno: 'foo',
						due: 15,
						tre: [ 'bar', 'zero' ],
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
			src: 'src',
			slotName: 'SLOT_NAME'

	};

	function getModule() {
		return modules['ext.wikia.adEngine.video.vastBuilder'](
			mocks.adContext,
			mocks.page,
			mocks.adUnitBuilder,
			mocks.loc,
			mocks.log
		);
	}

	it('Build VAST URL with DFP domain', function () {
		var vastUrl = getModule().build();

		expect(vastUrl).toMatch(/^https:\/\/pubads\.g\.doubleclick\.net\/gampad\/ads/gi);
	});

	it('Build VAST URL with required DFP parameters', function () {
		var vastUrl = getModule().build();

		expect(vastUrl).toMatch(/output=vast&/g);
		expect(vastUrl).toMatch(/&env=vp&/g);
		expect(vastUrl).toMatch(/&gdfp_req=1&/g);
		expect(vastUrl).toMatch(/&impl=s&/g);
		expect(vastUrl).toMatch(/&unviewed_position_start=1&/g);
	});

	it('Build VAST URL with ad size horizontal', function () {
		var vastUrl = getModule().build(mocks.src, mocks.slotName, 1.5);

		expect(vastUrl).toMatch(/&sz=640x480&/g);
	});

	it('Build VAST URL with ad size vertical', function () {
		var vastUrl = getModule().build(mocks.src, mocks.slotName, 0.5);

		expect(vastUrl).toMatch(/&sz=320x480&/g);
	});

	it('Build VAST URL with ad size squared (horizontal)', function () {
		var vastUrl = getModule().build(mocks.src, mocks.slotName, 1);

		expect(vastUrl).toMatch(/&sz=640x480&/);
	});

	it('Build VAST URL with referrer', function () {
		var vastUrl = getModule().build();

		expect(vastUrl).toMatch(/&url=http:\/\/foo\.url/g);
	});

	it('Build VAST URL with numeric correlator', function () {
		var vastUrl = getModule().build();

		expect(vastUrl).toMatch(/&correlator=\d+&/g);
	});

	it('Build VAST URL with page level params', function () {
		var vastUrl = getModule().build();

		expect(vastUrl).toMatch(/&cust_params=uno%3Dfoo%26due%3D15%26tre%3Dbar%2Czero%26s0%3Dlife%26s1%3D_project43%26s2%3Darticle$/g);
	});
});
