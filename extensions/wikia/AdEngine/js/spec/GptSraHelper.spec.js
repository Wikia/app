/*global describe, it, expect, modules, spyOn*/
describe('ext.wikia.adEngine.gptSraHelper', function () {
	'use strict';

	function noop() {}

	var mocks = {
			gptHelper: {
				pushAd: noop,
				flushAds: noop
			},
			log: noop
		};

	function getModule() {
		return modules['ext.wikia.adEngine.gptSraHelper'](
			mocks.gptHelper,
			mocks.log
		);
	}

	it('Do not push when flush-only slot passed', function () {
		spyOn(mocks.gptHelper, 'pushAd');

		getModule().pushAd('GPT_FLUSH', '', {flushOnly: true}, noop, noop);

		expect(mocks.gptHelper.pushAd).not.toHaveBeenCalled();
	});

	it('Push when any other slot passed', function () {
		spyOn(mocks.gptHelper, 'pushAd');

		getModule().pushAd('TOP_LEADERBOARD');

		expect(mocks.gptHelper.pushAd).toHaveBeenCalled();
	});

	it('Do not flush when pushing SRA slot', function () {
		spyOn(mocks.gptHelper, 'flushAds');

		getModule().pushAd('TOP_LEADERBOARD');

		expect(mocks.gptHelper.flushAds).not.toHaveBeenCalled();
	});

	it('Flush when pushing non SRA slot', function () {
		spyOn(mocks.gptHelper, 'flushAds');

		getModule().pushAd('TOP_RIGHT_BOXAD');

		expect(mocks.gptHelper.flushAds).toHaveBeenCalled();
	});
});
