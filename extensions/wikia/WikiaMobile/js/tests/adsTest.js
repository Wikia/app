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
				return true;
			}
		}, 'ad module to be defined', 200);
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

				return true;
			}


		}, 'moveSlot to be a function', 200);
	});

	it("ad place is removed (it takes 6s)", function() {
		var ads;

		document.body.innerHTML = '<aside id=wkAdPlc><div id=wkAdCls>close</div></aside><div id=wkFtr></div>';

		expect( document.getElementById('wkAdPlc') ).toBeDefined();
		expect( document.getElementById('wkAdCls') ).toBeDefined();
		expect( document.getElementById('wkFtr') ).toBeDefined();

		runs(function(){
			require('ads', function(ad){
				ads = ad;
				ads.init();
			});
		});

		waitsFor(function(){
			if(ads && document.getElementById('wkAdPlc') === null){
				expect( document.getElementById('wkAdPlc') ).toBe(null);
				expect( document.getElementById('wkAdCls') ).toBe(null);
				expect( document.getElementById('wkFtr') ).toBeDefined();
				return true;
			}
		}, 'ad place to be removed', 7000);
	});
});