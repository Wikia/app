describe('AdProviderEvolve', function(){
	"use strict";

	var slotTweakerMock;

// dart has problems with sending back scripts based on key-val %p
// http://ad.doubleclick.net/adj/wka.gaming/_starcraft/article;s0=gaming;s1=_starcraft;dmn=wikia-devcom;pos=TOP_LEADERBOARD;ord=7121786175
// yields window.AdEngine2.hop('=TOP_LEADERBOARD;ord=7121786175');
// instead of window.AdEngine2.hop('TOP_LEADERBOARD');
	it('sanitizeSlotname', function() {
		var  logMock = function() {}
			, scriptWriterMock
			, windowMock = { wgInsideUnitTest: true }
			, documentMock
			, evolveHelperMock = {}
			, adProviderEvolve
			, evolveSlotConfig = modules['ext.wikia.adEngine.evolveSlotConfig'](logMock)
			;

		adProviderEvolve = modules['ext.wikia.adEngine.provider.evolve'](
			logMock, windowMock, documentMock, scriptWriterMock, slotTweakerMock, evolveHelperMock, evolveSlotConfig
		);

		expect(adProviderEvolve.sanitizeSlotname('foo')).toBe('', 'foo');
		expect(adProviderEvolve.sanitizeSlotname('TOP_LEADERBOARD')).toBe('TOP_LEADERBOARD', 'TOP_LEADERBOARD');
		expect(adProviderEvolve.sanitizeSlotname('=TOP_LEADERBOARD;ord=1')).toBe('TOP_LEADERBOARD', '=TOP_LEADERBOARD;ord=1');
	});

	it('getUrl', function() {
		var logMock = function() {}
			, scriptWriterMock
			, windowMock = {wgInsideUnitTest: true, location: {hostname: 'mock'}}
			, documentMock
			, evolveHelperMock = {
				getSect: function() {return 'randomsection';},
				getTargeting: function() {return 'dmn=mock;hostpre=mock;esrb=teen;s1=_somedb;'; }
			}
			, adProviderEvolve
			, expected
			, actual
			, evolveSlotConfig = modules['ext.wikia.adEngine.evolveSlotConfig'](logMock)
			;

		adProviderEvolve = modules['ext.wikia.adEngine.provider.evolve'](
			logMock, windowMock, documentMock, scriptWriterMock, slotTweakerMock, evolveHelperMock, evolveSlotConfig
		);

		windowMock.wgDartCustomKeyValues = null;
		windowMock.cscoreCat = null;

		expected = 'http://n4403ad.doubleclick.net/adj/gn.wikia4.com/randomsection;sect=randomsection;mtfInline=true;pos=TOP_LEADERBOARD;dmn=mock;hostpre=mock;esrb=teen;s1=_somedb;sz=728x90;dcopt=ist;type=pop;type=int;tile=1;ord=1234567890?';
		expected = expected.replace(/;ord=[0-9]+\?$/, ''); // ord is random cb

		actual = adProviderEvolve.getUrl('TOP_LEADERBOARD');
		actual = actual.replace(/;ord=[0-9]+\?$/, ''); // ord is random cb

		expect(actual).toBe(expected, 'TOP_LEADERBOARD');

		expected = 'http://n4403ad.doubleclick.net/adj/gn.wikia4.com/randomsection;sect=randomsection;mtfInline=true;pos=TOP_RIGHT_BOXAD;dmn=mock;hostpre=mock;esrb=teen;s1=_somedb;sz=300x250,300x600;type=pop;type=int;tile=2;ord=1234567890?';
		expected = expected.replace(/;ord=[0-9]+\?$/, ''); // ord is random cb

		actual = adProviderEvolve.getUrl('TOP_RIGHT_BOXAD');
		actual = actual.replace(/;ord=[0-9]+\?$/, ''); // ord is random cb

		expect(actual).toBe(expected, 'TOP_RIGHT_BOXAD');
		// http://n4403ad.doubleclick.net/adj/gn.wikia4.com/randomsection;sect=randomsection;mtfInline=true;pos=TOP_RIGHT_BOXAD;dmn=mock;hostpre=mock;esrb=teen;s1=_somedb;sz=300x250,300x600;type=pop;type=int;tile=2
		// http://n4403ad.doubleclick.net/adj/gn.wikia4.com/randomsection;sect=randomsection;mtfInline=true;pos=TOP_RIGHT_BOXAD;esrb=teen;s1=_somedb;dmn=mock;hostpre=mock;sz=300x250,300x600;type=pop;type=int;tile=2
	});

	it('Evolve canHandleSlot AU', function() {
		var logMock = function() {}
			, scriptWriterMock
			, documentMock
			, windowMock = {wgInsideUnitTest: true}
			, evolveHelperMock = {}
			, adProviderEvolve
			, evolveSlotConfig = modules['ext.wikia.adEngine.evolveSlotConfig'](logMock)
			;

		adProviderEvolve = modules['ext.wikia.adEngine.provider.evolve'](
			logMock, windowMock, documentMock, scriptWriterMock, slotTweakerMock, evolveHelperMock, evolveSlotConfig
		);

		expect(adProviderEvolve.canHandleSlot(['TOP_LEADERBOARD'])).toBeTruthy('TOP_LEADERBOARD');
		expect(adProviderEvolve.canHandleSlot(['TOP_RIGHT_BOXAD'])).toBeTruthy('TOP_RIGHT_BOXAD');
		expect(adProviderEvolve.canHandleSlot(['LEFT_SKYSCRAPER_2'])).toBeTruthy('LEFT_SKYSCRAPER_2');

		expect(adProviderEvolve.canHandleSlot(['INCONTENT_BOXAD_1'])).toBeFalsy('INCONTENT_BOXAD_1');
		expect(adProviderEvolve.canHandleSlot(['PREFOOTER_LEFT_BOXAD'])).toBeFalsy('PREFOOTER_LEFT_BOXAD');
		expect(adProviderEvolve.canHandleSlot(['PREFOOTER_MIDDLE_BOXAD'])).toBeFalsy('PREFOOTER_MIDDLE_BOXAD');
		expect(adProviderEvolve.canHandleSlot(['PREFOOTER_RIGHT_BOXAD'])).toBeFalsy('PREFOOTER_RIGHT_BOXAD');
	});
});
