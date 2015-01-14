/*global describe,it,expect,modules,spyOn,beforeEach */
/*jslint nomen: true*/
describe('GptSlotConfig', function(){
	'use strict';

	it('getConfig() returns a global configuration', function() {

		var gptSlotConfig = modules['ext.wikia.adEngine.gptSlotConfig'](),
			configuration = gptSlotConfig.getConfig();

		expect(configuration).not.toBeUndefined();
		expect(configuration.gpt).not.toBeUndefined();
		expect(configuration.mobile).not.toBeUndefined();
		expect(configuration.remnant).not.toBeUndefined();
		expect(configuration.mobile_remnant).not.toBeUndefined();
	});

	it('getConfig(src) returns a provider configuration', function() {
		var gptSlotConfig = modules['ext.wikia.adEngine.gptSlotConfig'](),
			configuration = gptSlotConfig.getConfig(), gptConfig = gptSlotConfig.getConfig('gpt');

		expect(gptConfig).not.toBeUndefined();
		expect(gptConfig.HOME_TOP_LEADERBOARD).not.toBeUndefined();


		expect(configuration.gpt).toEqual(gptSlotConfig.getConfig('gpt'));
		expect(configuration.mobile).toEqual(gptSlotConfig.getConfig('mobile'));
		expect(configuration.remnant).toEqual(gptSlotConfig.getConfig('remnant'));
		expect(configuration.mobile_remnant).toEqual(gptSlotConfig.getConfig('mobile_remnant'));
	});

	it('getConfig() never return same objects', function() {
		var gptSlotConfig = modules['ext.wikia.adEngine.gptSlotConfig']();
		expect(gptSlotConfig.getConfig()).toEqual(gptSlotConfig.getConfig());
		expect(gptSlotConfig.getConfig()).not.toBe(gptSlotConfig.getConfig());
		expect(gptSlotConfig.getConfig('gpt')).toEqual(gptSlotConfig.getConfig('gpt'));
		expect(gptSlotConfig.getConfig('gpt')).not.toBe(gptSlotConfig.getConfig('gpt'));
	});

	it('extendSlotParams saves params', function() {
		var gptSlotConfig = modules['ext.wikia.adEngine.gptSlotConfig'](),
			newConfigGlobal, newConfigGpt, configBase = gptSlotConfig.getConfig('gpt');

		gptSlotConfig.extendSlotParams();
		expect(configBase).toEqual(gptSlotConfig.getConfig('gpt'));
		gptSlotConfig.extendSlotParams('gpt');
		expect(configBase).toEqual(gptSlotConfig.getConfig('gpt'));
		gptSlotConfig.extendSlotParams('gpt', 'HOME_TOP_LEADERBOARD');
		expect(configBase).toEqual(gptSlotConfig.getConfig('gpt'));
		gptSlotConfig.extendSlotParams('gpt', 'UNDEFINED_SLOT', {});
		expect(configBase).toEqual(gptSlotConfig.getConfig('gpt'));
		gptSlotConfig.extendSlotParams('gpt', 'HOME_TOP_LEADERBOARD', {});
		expect(configBase).toEqual(gptSlotConfig.getConfig('gpt'));
		gptSlotConfig.extendSlotParams('gpt', 'HOME_TOP_LEADERBOARD', {'test': 'test'});
		expect(configBase).not.toEqual(gptSlotConfig.getConfig('gpt'));

		newConfigGlobal = gptSlotConfig.getConfig();
		newConfigGpt = gptSlotConfig.getConfig('gpt');

		expect(newConfigGlobal.gpt).toEqual(newConfigGpt);
		expect(newConfigGpt.TOP_LEADERBOARD.test).toBeUndefined();
		expect(newConfigGpt.HOME_TOP_LEADERBOARD.test).not.toBeUndefined();
		expect(newConfigGpt.HOME_TOP_LEADERBOARD.test).toEqual('test');
	});

});