/*global describe, it, expect, modules*/
describe('ext.wikia.adEngine.video.vastUrlBuilder', function () {
	'use strict';

	function noop () {}

	var mocks = {
			adContext: {
				addCallback: noop
			},
			adUnitBuilder: {
				build: function() {
					return 'my/ad/unit';
				}
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

		expect(vastUrl).toMatch(/&url=http:\/\/foo\.url/g);
	});

	it('Build VAST URL with numeric correlator', function () {
		var vastUrl = getModule().build(1, mocks.slotParams);

		expect(vastUrl).toMatch(/&correlator=\d+&/g);
	});

	it('Build VAST URL with page level params', function () {
		var vastUrl = getModule().build(1, {});

		expect(vastUrl).toMatch(/&cust_params=uno%3Dfoo%26due%3D15%26tre%3Dbar%2Czero%26s0%3Dlife%26s1%3D_project43%26s2%3Darticle$/g);
	});

	it('Build VAST URL with page level params and slot level params', function () {
		var vastUrl = getModule().build(1, {
			passback: 'playwire',
			pos: 'TEST_SLOT',
			src: 'remnant'
		});

		expect(vastUrl).toMatch(/&cust_params=uno%3Dfoo%26due%3D15%26tre%3Dbar%2Czero%26s0%3Dlife%26s1%3D_project43%26s2%3Darticle%26passback%3Dplaywire%26pos%3DTEST_SLOT%26src%3Dremnant$/);
	});

	it('Build VAST URL with ad unit id', function () {
		var vastUrl = getModule().build(1, mocks.slotParams);

		expect(vastUrl).toMatch('&iu=my\/ad\/unit&');
	});
});

