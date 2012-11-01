/**
 * @test-framework Jasmine
 * @test-require-asset resources/wikia/libraries/modil/modil.js
 * @test-require-asset resources/wikia/modules/cachebuster.js
 */

describe("CacheBuster module", function() {
	var async = new AsyncSpec(this);

	async.it("loads as expected", function(done) {
		require(['cachebuster'], function(cb){
			expect(cb).toBeDefined();
			expect(typeof cb.reloadPageWithCacheBuster === 'function').toBe(true);
			done();
		});
	});

	async.it("reloads", function(done) {
		require(['cachebuster'], function(cb) {
			var url = 'http://www.wikia.com/Wikia';
			
			spyOn(cb, 'getUrl').andReturn(url);
			spyOn(cb, 'getRandomCb').andReturn(1234);
			spyOn(cb, 'setUrl');
		
			cb.reloadPageWithCacheBuster();
			
			expect(cb.setUrl).toHaveBeenCalledWith(url + '?cb=1234');
			
			done();
		});
	});
	
	async.it("reloads when having existing params", function(done) {
		require(['cachebuster'], function(cb) {
			var url = 'http://www.wikia.com/Wikia?awesomesauce=true';
			
			spyOn(cb, 'getUrl').andReturn(url);
			spyOn(cb, 'getRandomCb').andReturn(1234);
			spyOn(cb, 'setUrl');
		
			cb.reloadPageWithCacheBuster();
			
			expect(cb.setUrl).toHaveBeenCalledWith(url + '&cb=1234');
			
			done();
		});
	});

});