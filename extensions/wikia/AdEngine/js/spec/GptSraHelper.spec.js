/*global describe, it, expect, modules, spyOn*/
describe('ext.wikia.adEngine.gptSraHelper', function () {
	'use strict';

	function noop() {}

	var mocks = {
			log: noop
		};

	function getModule() {
		return modules['ext.wikia.adEngine.gptSraHelper'](
			mocks.log
		);
	}

	it('Return true when flush-only slot passed', function () {
		expect(getModule().shouldFlush('GPT_FLUSH')).toEqual(true);
	});

	it('Returns false when SRA slot passed', function () {
		expect(getModule().shouldFlush('TOP_LEADERBOARD')).toEqual(false);
	});

	it('Returns always true when at least one slot has been flushed', function () {
		var sraHelper = getModule();

		expect(sraHelper.shouldFlush('TOP_RIGHT_BOXAD')).toEqual(true);
		expect(sraHelper.shouldFlush('TOP_LEADERBOARD')).toEqual(true);
	});
});
