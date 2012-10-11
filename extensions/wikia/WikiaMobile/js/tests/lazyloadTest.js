/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /resources/wikia/modules/thumbnailer.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/lazyload.js
 */

/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Test lazyload module", function () {
	'use strict';
	var async = new AsyncSpec(this);

	async.it('should be defined', function(done){
		require(['lazyload'], function(lazyload){

			expect(lazyload).toBeDefined();

			done();
		});
	});


});