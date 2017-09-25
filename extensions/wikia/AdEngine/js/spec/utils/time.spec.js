/*global describe, it, expect, modules, beforeEach, spyOn*/
describe('ext.wikia.adEngine.utils.time', function () {
	'use strict';

	var TIME_VALUE = {
		SECOND: 1000,
		MINUTE: 1000 * 60,
		HOUR: 1000 * 60 * 60
	};

	function getModule() {
		return modules['ext.wikia.adEngine.utils.time']();
	}

	it('Should return correct time interval', function () {
		var timeUtil = getModule();

		expect(timeUtil.getInterval(5, 'min')).toEqual(5 * TIME_VALUE.MINUTE);
		expect(timeUtil.getInterval(14, 'minutes')).toEqual(14 * TIME_VALUE.MINUTE);
		expect(timeUtil.getInterval(13, 's')).toEqual(13 * TIME_VALUE.SECOND);
		expect(timeUtil.getInterval(17, 'seconds')).toEqual(17 * TIME_VALUE.SECOND);
		expect(timeUtil.getInterval(2, 'hours')).toEqual(2 * TIME_VALUE.HOUR);
		expect(timeUtil.getInterval(3, 'h')).toEqual(3 * TIME_VALUE.HOUR);
		expect(timeUtil.getInterval(1, 'hour')).toEqual(TIME_VALUE.HOUR);
	});

	it('Should guess correctly time unit from string', function () {
		var timeUtil = getModule();
		expect(timeUtil.guessTimeUnit('12min')).toEqual('min');
		expect(timeUtil.guessTimeUnit('66h6')).toEqual('h');
		expect(timeUtil.guessTimeUnit('1 minute')).toEqual('minute');
		expect(timeUtil.guessTimeUnit('3 sec')).toEqual('sec');
	});

	it('Should recognize if it is time unit in string', function () {
		var timeUtil = getModule();
		expect(timeUtil.hasTimeUnit('12min')).toBeTruthy();
		expect(timeUtil.hasTimeUnit('66h6')).toBeTruthy();
		expect(timeUtil.hasTimeUnit('1 minute')).toBeTruthy();
		expect(timeUtil.hasTimeUnit('3 sec')).toBeTruthy();

		expect(timeUtil.hasTimeUnit('3 xyz')).toBeFalsy();
		expect(timeUtil.hasTimeUnit('333')).toBeFalsy();
		expect(timeUtil.hasTimeUnit('45 qqq')).toBeFalsy();
	});

});
