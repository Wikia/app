/*global describe, it, expect, modules, beforeEach, spyOn*/
describe('ext.wikia.adEngine.video.dfpVastUrl', function () {
	'use strict';

	function noop () {}

	var mocks = {
			adContext: {
				addCallback: noop
			},
			page: {
				getPageLevelParams: function () {
					return {
						uno: 'foo',
						due: 15,
						tre: [ 'bar', 'zero' ],
						quattro: null
					};
				}
			},
			loc: {
				href: 'http://foo.url'
			},
			log: noop
		};

	function getModule() {
		return modules['ext.wikia.adEngine.video.dfpVastUrl'](
			mocks.adContext,
			mocks.page,
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

	it('Build VAST URL with ad unit id', function () {
		var vastUrl = getModule().build();

		expect(vastUrl).toMatch(/&iu=\/5441\/WIKIA_ATG&/g);
	});

	it('Build VAST URL with ad size', function () {
		var vastUrl = getModule().build();

		expect(vastUrl).toMatch(/&sz=640x480&/g);
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

		expect(vastUrl).toMatch(/&cust_params=uno%3Dfoo%26due%3D15%26tre%3Dbar%2Czero$/g);
	});
});
