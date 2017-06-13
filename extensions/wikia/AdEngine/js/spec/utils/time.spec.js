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

});
