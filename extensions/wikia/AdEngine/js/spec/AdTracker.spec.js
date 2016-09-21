/*global beforeEach, describe, it, expect, modules, spyOn, jasmine*/
/*jshint camelcase:false*/
describe('ext.wikia.adEngine.adTracker', function () {
	'use strict';

	function noop() { return; }

	var trackerMock = { track: noop },
		windowMock = {},
		logMock = noop;

	beforeEach(function () {
		windowMock = {
			wgNow: new Date(new Date().getTime() - 888),
			ads: {
				runtime: {
					sp: {}
				}
			}
		};
	});

	it('track: simple event', function () {
		var adTracker = modules['ext.wikia.adEngine.adTracker'](trackerMock, windowMock, logMock);

		spyOn(trackerMock, 'track');
		adTracker.track('test/event');
		expect(trackerMock.track).toHaveBeenCalledWith({
			ga_category: 'ad/test/event',
			ga_action: 'nodata',
			ga_label: '',
			ga_value: 0,
			trackingMethod: 'ad'
		});
	});

	it('track: event with extra data', function () {
		var adTracker = modules['ext.wikia.adEngine.adTracker'](trackerMock, windowMock, logMock);

		spyOn(trackerMock, 'track');
		adTracker.track('test/event', {data1: 'one', data2: ['two', 'three']});
		expect(trackerMock.track).toHaveBeenCalledWith({
			ga_category: 'ad/test/event',
			ga_action: 'data1=one;data2=two,three',
			ga_label: '',
			ga_value: 0,
			trackingMethod: 'ad'
		});
	});

	it('track: event with sp=yes data', function () {
		var adTracker = modules['ext.wikia.adEngine.adTracker'](trackerMock, windowMock, logMock);

		windowMock.ads.runtime.sp.blocking = true;

		spyOn(trackerMock, 'track');
		adTracker.track('test/event', {data1: 'one'});
		expect(trackerMock.track).toHaveBeenCalledWith({
			ga_category: 'ad/test/event',
			ga_action: 'data1=one;sp=yes',
			ga_label: '',
			ga_value: 0,
			trackingMethod: 'ad'
		});
	});

	it('track: event with sp=no data', function () {
		var adTracker = modules['ext.wikia.adEngine.adTracker'](trackerMock, windowMock, logMock);

		windowMock.ads.runtime.sp.blocking = false;

		spyOn(trackerMock, 'track');
		adTracker.track('test/event', {data1: 'one'});
		expect(trackerMock.track).toHaveBeenCalledWith({
			ga_category: 'ad/test/event',
			ga_action: 'data1=one;sp=no',
			ga_label: '',
			ga_value: 0,
			trackingMethod: 'ad'
		});
	});

	it('track: event without sp data', function () {
		var adTracker = modules['ext.wikia.adEngine.adTracker'](trackerMock, windowMock, logMock);

		spyOn(trackerMock, 'track');
		adTracker.track('test/event', {data1: 'one'});
		expect(trackerMock.track).toHaveBeenCalledWith({
			ga_category: 'ad/test/event',
			ga_action: 'data1=one',
			ga_label: '',
			ga_value: 0,
			trackingMethod: 'ad'
		});
	});

	it('track: event with a value (time buckets)', function () {
		var adTracker,
			timeBuckets = [
				[32191, '20-60'],
				[16778, '8-20'],
				[19323, '8-20'],
				[12196, '8-20'],
				[24786, '20-60'],
				[6480, '5-8'],
				[1651, '1.5-2'],
				[4008, '3.5-5'],
				[7896, '5-8'],
				[0, '0-0.5']
			],
			i,
			len,
			value,
			timeBucket;

		adTracker = modules['ext.wikia.adEngine.adTracker'](trackerMock, windowMock, logMock);

		spyOn(trackerMock, 'track');

		for (i = 0, len = timeBuckets.length; i < len; i += 1) {
			value = timeBuckets[i][0];
			timeBucket = timeBuckets[i][1];
			adTracker.track('test/event', {}, value);
			expect(trackerMock.track).toHaveBeenCalledWith({
				ga_category: 'ad/test/event',
				ga_action: 'nodata',
				ga_label: timeBucket,
				ga_value: value,
				trackingMethod: 'ad'
			});
		}
	});

	it('track: event with a wrong value (time buckets)', function () {
		var adTracker,
			timeBuckets = [
				[100 * 1000, '60+'], // 100 seconds
				[10e10, '60+'],
				[-100, 'invalid'],
				[-5, 'invalid']
			],
			i,
			len,
			value,
			timeBucket;

		adTracker = modules['ext.wikia.adEngine.adTracker'](trackerMock, windowMock, logMock);

		spyOn(trackerMock, 'track');

		for (i = 0, len = timeBuckets.length; i < len; i += 1) {
			value = timeBuckets[i][0];
			timeBucket = timeBuckets[i][1];
			adTracker.track('test/event', {}, value);
			expect(trackerMock.track).toHaveBeenCalledWith({
				ga_category: 'ad/error/test/event',
				ga_action: 'nodata',
				ga_label: timeBucket,
				ga_value: value,
				trackingMethod: 'ad'
			});
		}
	});

	it('track: event with a float value (time buckets + value rounding)', function () {
		var adTracker,
			timeBuckets = [
				[32191.5, '20-60', 32192],
				[16778.1, '8-20', 16778],
				[19323.0, '8-20', 19323],
				[12196.4, '8-20', 12196],
				[24786.3, '20-60', 24786],
				[6480.1, '5-8', 6480],
				[1651.45, '1.5-2', 1651],
				[4008.333, '3.5-5', 4008],
				[7896.123, '5-8', 7896],
				[0.001, '0-0.5', 0]
			],
			i,
			len,
			value,
			expectedValue,
			timeBucket;

		adTracker = modules['ext.wikia.adEngine.adTracker'](trackerMock, windowMock, logMock);

		spyOn(trackerMock, 'track');

		for (i = 0, len = timeBuckets.length; i < len; i += 1) {
			value = timeBuckets[i][0];
			timeBucket = timeBuckets[i][1];
			expectedValue = timeBuckets[i][2];
			adTracker.track('test/event', {}, value);
			expect(trackerMock.track).toHaveBeenCalledWith({
				ga_category: 'ad/test/event',
				ga_action: 'nodata',
				ga_label: timeBucket,
				ga_value: expectedValue,
				trackingMethod: 'ad'
			});
		}
	});

	it('track: event with an invalid value', function () {
		var adTracker = modules['ext.wikia.adEngine.adTracker'](trackerMock, windowMock, logMock);

		spyOn(trackerMock, 'track');

		adTracker.track('test/event', {}, 'goat');
		expect(trackerMock.track).toHaveBeenCalledWith({
			ga_category: 'ad/error/test/event',
			ga_action: 'nodata',
			ga_label: 'invalid',
			ga_value: 0,
			trackingMethod: 'ad'
		});
	});

	it('measureTime and track', function () {
		var adTracker = modules['ext.wikia.adEngine.adTracker'](trackerMock, windowMock, logMock);

		spyOn(trackerMock, 'track');

		adTracker.measureTime('test/event', {abc: 'def', xyz: 123}).track();

		expect(trackerMock.track).toHaveBeenCalledWith({
			ga_category: 'ad/timing/test/event',
			ga_action: 'abc=def;xyz=123',
			ga_label: '0.5-1',
			ga_value: jasmine.any(Number),
			trackingMethod: 'ad'
		});

		expect(trackerMock.track.calls.mostRecent().args[0].ga_value).not.toBeLessThan(888);
	});

	it('measureTime: no track call after measure', function () {
		var adTracker = modules['ext.wikia.adEngine.adTracker'](trackerMock, windowMock, logMock);

		spyOn(trackerMock, 'track');

		adTracker.measureTime('test/event', {abc: 'def', xyz: 123});

		// No tracking yet
		expect(trackerMock.track.calls.count()).toBe(0);
	});

	it('measureTime with eventType param and track', function () {
		var adTracker = modules['ext.wikia.adEngine.adTracker'](trackerMock, windowMock, logMock);

		spyOn(trackerMock, 'track');

		adTracker.measureTime('testEvent', {abc: 'def', xyz: 123}, 'start').track();

		expect(trackerMock.track).toHaveBeenCalledWith({
			ga_category: 'ad/timing/testEvent/start',
			ga_action: 'abc=def;xyz=123',
			ga_label: '0.5-1',
			ga_value: jasmine.any(Number),
			trackingMethod: 'ad'
		});

		expect(trackerMock.track.calls.count()).toBe(1);

		expect(trackerMock.track.calls.mostRecent().args[0].ga_value).not.toBeLessThan(888);
	});

	it('measureDiff: no track call after measure', function () {
		var adTracker = modules['ext.wikia.adEngine.adTracker'](trackerMock, windowMock, logMock);

		spyOn(trackerMock, 'track');

		adTracker.measureTime('test/event', {abc: 'def', xyz: 123}).measureDiff({abc: 'def', xyz: 123}, 'diff');

		// No tracking yet
		expect(trackerMock.track.calls.count()).toBe(0);
	});

	it('measureTime, measureDiff and track', function () {
		var timer,
			adTracker = modules['ext.wikia.adEngine.adTracker'](trackerMock, windowMock, logMock);

		spyOn(trackerMock, 'track');

		timer = adTracker.measureTime('test/event', {abc: 'def', xyz: 123});

		windowMock.wgNow = new Date(windowMock.wgNow.getTime() - 110);

		timer = timer.measureDiff({abc: 'def', xyz: 123}, 'diff');

		timer.track();

		expect(trackerMock.track).toHaveBeenCalledWith({
			ga_category: 'ad/timing/test/event/diff',
			ga_action: 'abc=def;xyz=123',
			ga_label: '0-0.5',
			ga_value: jasmine.any(Number),
			trackingMethod: 'ad'
		});

		expect(trackerMock.track.calls.count()).toBe(1);

		expect(trackerMock.track.calls.mostRecent().args[0].ga_value).not.toBeLessThan(110);
		expect(trackerMock.track.calls.mostRecent().args[0].ga_value).not.toBeGreaterThan(888);
	});
});
