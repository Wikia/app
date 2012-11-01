/**
 * @test-framework Jasmine
 * @test-require-asset resources/wikia/modules/cachebuster.js
 */

describe("CacheBuster module", function() {
	it("loads as expected", function() {
		expect(Wikia).toBeDefined();
		expect(Wikia.CacheBuster).toBeDefined();
		expect(typeof Wikia.CacheBuster.reloadPageWithCacheBuster === 'function').toBe(true);
	});
	
	it("reloads", function() {
		var cb = Wikia.CacheBuster,
			url = 'http://www.wikia.com/Wikia';
		
		spyOn(cb, 'getUrl').andReturn(url);
		spyOn(cb, 'getRandomCb').andReturn(1234);
		spyOn(cb, 'setUrl');
	
		cb.reloadPageWithCacheBuster();
		
		expect(cb.setUrl).toHaveBeenCalledWith(url + '?cb=1234');
	});
	
	it("reloads with additional existing params", function() {
		var cb = Wikia.CacheBuster,
			url = 'http://www.wikia.com/Wikia?deliciouspie=true';
		
		spyOn(cb, 'getUrl').andReturn(url);
		spyOn(cb, 'getRandomCb').andReturn(1234);
		spyOn(cb, 'setUrl');
	
		cb.reloadPageWithCacheBuster();
		
		expect(cb.setUrl).toHaveBeenCalledWith(url + '&cb=1234');
	});
	
});