/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/events.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/ads.js
 */

describe("Test ads module", function() {
	it("is ad module defined", function() {
		var ad;

		runs(function(){
			require('ads', function(ads){
				ad = ads;
			})
		});

		waitsFor(function(){
			if ( ad ){
				expect(ad).toBeDefined();
			}

			return ad;
		}, 'is ad module defined', 200);
	});

	it("does ad module have moveSlot function", function() {
		var ad;

		runs(function(){
			require('ads', function(ads){
				ad = ads;
			})
		});

		waitsFor(function(){
			if ( ad ){
				expect(ad.moveSlot).toBeDefined();
				expect(typeof ad.moveSlot).toEqual('function');
			}

			return ad;
		}, 'is ad module defined', 200);
	});
});