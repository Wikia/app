describe('EvolveHelper', function(){
	it('getSect', function() {
		var logMock = function() {}
			, windowMock = {}
			;

		evolveHelper = modules['ext.wikia.adEngine.evolveHelper'](logMock, windowMock);

		windowMock.wgDBname = null;
		windowMock.wgDartCustomKeyValues = null;
		windowMock.cscoreCat = null;

		expect(evolveHelper.getSect()).toBe('ros', 'ros');

		windowMock.wgDartCustomKeyValues = 'foo=bar;media=tv';
		windowMock.cscoreCat = 'Entertainment';

		expect(evolveHelper.getSect()).toBe('tv', 'tv entertainment');

		windowMock.wgDartCustomKeyValues = 'foo=bar';
		windowMock.cscoreCat = 'Entertainment';

		expect(evolveHelper.getSect()).toBe('entertainment', 'foo entertainment');

		windowMock.wgDartCustomKeyValues = 'foo=bar;media=movie';
		windowMock.cscoreCat = 'Entertainment';

		expect(evolveHelper.getSect()).toBe('movies', 'movie entertainment');
	});
});