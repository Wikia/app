/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/events.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/ads.js
 */

describe("Test ads module", function() {
	it("is ad module defined", function() {
		var ad,
			flag = false;

		runs(function(){
			require('ads', function(ads){
				ad = ads;
				flag = true;
			})
		});

		waitsFor(function(){
			if ( flag ){
				expect(ad).toBeDefined();
				expect(ad).toHaveBeenCalled();
			}

			return flag;
		}, 'is ad module defined', 200);
	});

	it("does ad module have moveSlot function", function() {
		var ad,
			flag = false;

		runs(function(){
			require('ads', function(ads){
				ad = ads;
				flag = true;
			})
		});

		waitsFor(function(){
			if ( flag ){
				expect(ad.moveSlot).toBeDefined();
				expect(typeof ad.moveSlot).toEqual('function');
			}

			return flag;
		}, 'is ad module defined', 200);
	});
});