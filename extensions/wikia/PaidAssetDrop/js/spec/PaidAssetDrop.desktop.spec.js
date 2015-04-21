/*global describe, it, expect, modules, jasmine*/
describe('ext.wikia.PaidAssetDrop', function () {
	'use strict';

	function noop() {
		return;
	}

	function getModule() {
		return modules['ext.wikia.PaidAssetDrop'](mocks.jquery, mocks.log, mocks.win);
	}

	var mocks = {
		jquery: {},
		log: noop,
		win: {}
	};

	it('today is not valid when wgPaidAssetDrop is not set', function () {
		expect(getModule().isTodayValid()).toEqual(false);
	});

	it('today is not valid when wgPaidAssetDrop start day is not set', function () {
		mocks.win.wgPaidAssetDrop = [];
		expect(getModule().isTodayValid()).toEqual(false);
	});

	it('today is not valid when wgPaidAssetDrop start day is not set', function () {
		mocks.win.wgPaidAssetDrop = ['2015-04-12'];
		expect(getModule().isTodayValid()).toEqual(false);
	});

	it('today is not valid when it is before start date', function () {
		mocks.win.wgPaidAssetDrop = ['2015-04-14', '2015-04-21'];
		jasmine.clock().mockDate(new Date('2015-04-13'));
		expect(getModule().isTodayValid()).toEqual(false);
	});

	it('today is not valid when it is after end date', function () {
		mocks.win.wgPaidAssetDrop = ['2015-04-14', '2015-04-21'];
		jasmine.clock().mockDate(new Date('2015-04-22'));
		expect(getModule().isTodayValid()).toEqual(false);
	});

	it('today is valid', function () {
		mocks.win.wgPaidAssetDrop = ['2015-04-14', '2015-04-21'];
		jasmine.clock().mockDate(new Date('2015-04-20'));
		expect(getModule().isTodayValid()).toEqual(true);
	});

	it('today is not valid when it is before start date (case with time)', function () {
		mocks.win.wgPaidAssetDrop = ['2015-04-14T12:00:00Z', '2015-04-14T20:00:00Z'];
		jasmine.clock().mockDate(new Date('2015-04-14T10:00:00Z'));
		expect(getModule().isTodayValid()).toEqual(false);
	});

	it('today is not valid when it is after end date (case with time)', function () {
		mocks.win.wgPaidAssetDrop = ['2015-04-14T12:00:00Z', '2015-04-14T20:00:00Z'];
		jasmine.clock().mockDate(new Date('2015-04-14T22:00:00Z'));
		expect(getModule().isTodayValid()).toEqual(false);
	});

	it('today is valid (case with time)', function () {
		mocks.win.wgPaidAssetDrop = ['2015-04-14T12:00:00Z', '2015-04-14T20:00:00Z'];
		jasmine.clock().mockDate(new Date('2015-04-14T16:00:00Z'));
		expect(getModule().isTodayValid()).toEqual(true);
	});

	it('today is invalid when both dates are invalid', function () {
		mocks.win.wgPaidAssetDrop = ['foo', 'bar'];
		expect(getModule().isTodayValid()).toEqual(false);
	});

	it('today is invalid when end date is invalid', function () {
		mocks.win.wgPaidAssetDrop = ['2015-04-20', 'bar'];
		expect(getModule().isTodayValid()).toEqual(false);
	});
});
