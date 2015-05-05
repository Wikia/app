/*global describe, it, expect, modules, jasmine, spyOn*/
describe('ext.wikia.paidAssetDrop.paidAssetDrop', function () {
	'use strict';

	function noop() {
		return;
	}

	var mocks = {
		log: noop,
		qs: {
			getVal: noop
		},
		getInstantGlobals: function () { return {}; },
		querystring: function () {
			return mocks.qs;
		},
		win: {}
	};

	function getModule() {
		return modules['ext.wikia.paidAssetDrop.paidAssetDrop'](mocks.getInstantGlobals(), mocks.log, mocks.querystring, mocks.win);
	}

	it('now is not valid when wgPaidAssetDropConfig is not set', function () {
		expect(getModule().isNowValid()).toEqual(false);
	});

	it('now is not valid when wgPaidAssetDropConfig start day is not set', function () {
		var config = [];
		expect(getModule().isNowValid(config)).toEqual(false);
	});

	it('now is not valid when wgPaidAssetDropConfig end day is not set', function () {
		var config = ['2015-04-12'];
		expect(getModule().isNowValid(config)).toEqual(false);
	});

	it('now is not valid when it is before start date', function () {
		var config = ['2015-04-14', '2015-04-21'];
		jasmine.clock().mockDate(new Date('2015-04-13'));
		expect(getModule().isNowValid(config)).toEqual(false);
		jasmine.clock().mockDate();
	});

	it('now is not valid when it is after end date', function () {
		var config = ['2015-04-14', '2015-04-21'];
		jasmine.clock().mockDate(new Date('2015-04-22'));
		expect(getModule().isNowValid(config)).toEqual(false);
		jasmine.clock().mockDate();
	});

	it('now is valid', function () {
		var config = ['2015-04-14', '2015-04-21'];
		jasmine.clock().mockDate(new Date('2015-04-20'));
		expect(getModule().isNowValid(config)).toEqual(true);
		jasmine.clock().mockDate();
	});

	it('now is not valid when it is before start date (case with time)', function () {
		var config = ['2015-04-14T12:00:00Z', '2015-04-14T20:00:00Z'];
		jasmine.clock().mockDate(new Date('2015-04-14T10:00:00Z'));
		expect(getModule().isNowValid(config)).toEqual(false);
		jasmine.clock().mockDate();
	});

	it('now is not valid when it is after end date (case with time)', function () {
		var config = ['2015-04-14T12:00:00Z', '2015-04-14T20:00:00Z'];
		jasmine.clock().mockDate(new Date('2015-04-14T22:00:00Z'));
		expect(getModule().isNowValid(config)).toEqual(false);
		jasmine.clock().mockDate();
	});

	it('now is valid (case with time)', function () {
		var config = ['2015-04-14T12:00:00Z', '2015-04-14T20:00:00Z'];
		jasmine.clock().mockDate(new Date('2015-04-14T16:00:00Z'));
		expect(getModule().isNowValid(config)).toEqual(true);
		jasmine.clock().mockDate();
	});

	it('now is invalid when both dates are invalid', function () {
		var config = ['foo', 'bar'];
		expect(getModule().isNowValid(config)).toEqual(false);
	});

	it('now is invalid when end date is invalid', function () {
		var config = ['2015-04-20', 'bar'];
		expect(getModule().isNowValid(config)).toEqual(false);
	});

	it('URL param', function () {
		var config = false;
		spyOn(mocks, 'querystring').and.returnValue({
			getVal: function (param) {
				return param === 'forcepad' ? '1' : undefined;
			}
		});
		expect(getModule().isNowValid(config)).toEqual(true);
	});

	it('Disaster recovery + valid date', function () {
		var config = ['2015-04-14T12:00:00Z', '2015-04-14T20:00:00Z'];
		jasmine.clock().mockDate(new Date('2015-04-14T16:00:00Z'));
		spyOn(mocks, 'getInstantGlobals').and.returnValue({
			wgSitewideDisablePaidAssetDrop: true
		});
		expect(getModule().isNowValid(config)).toEqual(false);
		jasmine.clock().mockDate();
	});

	it('Disaster recovery + URL param', function () {
		var config = false;
		spyOn(mocks, 'getInstantGlobals').and.returnValue({
			wgSitewideDisablePaidAssetDrop: true
		});
		spyOn(mocks, 'querystring').and.returnValue({
			getVal: function (param) {
				return param === 'forcepad' ? '1' : undefined;
			}
		});
		expect(getModule().isNowValid(config)).toEqual(true);
	});
});
