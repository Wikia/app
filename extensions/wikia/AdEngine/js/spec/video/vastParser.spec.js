/*global beforeEach, describe, it, expect, modules, window*/
describe('ext.wikia.adEngine.video.vastParser', function () {
	'use strict';

	function noop() {
	}

	var dummyVast = 'dummy.vast?sz=640x480&foo=bar&cust_params=foo1%3Dbar1%26foo2%3Dbar2' +
		'%26customTitle%3D100%25%20Orange%20Juice%3Dbar2&vpos=preroll',
		mocks = {
			log: noop
		},
		parser;

	mocks.log.levels = {};

	function getModule() {
		return modules['ext.wikia.adEngine.video.vastParser'](
			mocks.log,
			modules['wikia.querystring'](window.location, {})
		);
	}

	function getImaAd(wrapperIds, wrapperCreativeIds) {
		return {
			getAdId: function () {
				return '000';
			},
			getContentType: function () {
				return 'text/javascript';
			},
			getCreativeId: function () {
				return '999';
			},
			getWrapperAdIds: function () {
				return wrapperIds || [];
			},
			getWrapperCreativeIds: function () {
				return wrapperCreativeIds || [];
			}
		};
	}

	beforeEach(function () {
		parser = getModule();
	});

	it('Parse custom parameters from VAST url', function () {
		var adInfo = parser.parse(dummyVast);

		expect(adInfo.customParams).toEqual({
			foo1: 'bar1',
			foo2: 'bar2',
			customTitle: '100% Orange Juice'
		});
	});

	it('Parse size from VAST url', function () {
		var adInfo = parser.parse(dummyVast);

		expect(adInfo.size).toEqual('640x480');
	});

	it('Parse position from VAST url', function () {
		var adInfo = parser.parse(dummyVast);

		expect(adInfo.position).toEqual('preroll');
	});

	it('Current ad info is not set by default', function () {
		var adInfo = parser.parse(dummyVast);

		expect(adInfo.contentType).toEqual(undefined);
		expect(adInfo.creativeId).toEqual(undefined);
		expect(adInfo.lineItemId).toEqual(undefined);
	});

	it('Current ad info is passed from base object', function () {
		var adInfo = parser.parse(dummyVast, {
			contentType: 'video/mp4',
			creativeId: '123',
			lineItemId: '456'
		});

		expect(adInfo.contentType).toEqual('video/mp4');
		expect(adInfo.creativeId).toEqual('123');
		expect(adInfo.lineItemId).toEqual('456');
	});

	it('Parse ad info from from IMA object', function () {
		var adInfo = parser.parse(dummyVast, {
			contentType: 'video/mp4',
			creativeId: '123',
			imaAd: getImaAd(),
			lineItemId: '456'
		});

		expect(adInfo.contentType).toEqual('text/javascript');
		expect(adInfo.creativeId).toEqual('999');
		expect(adInfo.lineItemId).toEqual('000');
	});

	it('Parse ad info from from IMA object\'s wrapper ids', function () {
		var adInfo = parser.parse(dummyVast, {
			contentType: 'video/mp4',
			creativeId: '123',
			imaAd: getImaAd(['222', '333'], ['555', '666']),
			lineItemId: '456'
		});

		expect(adInfo.contentType).toEqual('text/javascript');
		expect(adInfo.creativeId).toEqual('555');
		expect(adInfo.lineItemId).toEqual('222');
	});
});
