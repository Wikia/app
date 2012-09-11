/*
@test-framework QUnit
 @test-require-asset resources/wikia/modules/querystring.js
 @test-require-asset resources/wikia/modules/cookies.js
 @test-require-asset resources/wikia/modules/log.js
 @test-require-asset extensions/wikia/AdEngine/ghost/gw-11.6.7/lib/gw.js
 @test-require-asset extensions/wikia/WikiaTracker/js/WikiaTracker.js
 @test-require-asset extensions/wikia/AdEngine/js/AdProviderEvolve.js
 @test-require-asset extensions/wikia/AdEngine/js/AdProviderGamePro.js
 @test-require-asset extensions/wikia/AdEngine/js/AdProviderAdDriver2.js
 @test-require-asset extensions/wikia/AdEngine/js/AdConfig2.js
 @test-require-asset extensions/wikia/AdEngine/js/AdEngine2.js
*/

// Sorry for that
AdProviderDummy = {};

module('AdEngine2', {
	setup: function() {
		this.getProvider = AdConfig2.getProvider;
		AdConfig2.getProvider = function() {
			return AdProviderDummy;
		};
	},
	teardown: function() {
		AdConfig2.getProvider = this.getProvider;
	}
});

test('moveQueue', function() {
	// setup
	var slots_done = [];
	AdProviderDummy = {};
	AdProviderDummy.fillInSlot = function(slot) {
		slots_done.push(slot);
	};

	window.adslots2 = [];
	window.adslots2.push(['foo']);
	window.adslots2.push(['bar']);
	AdEngine2.init();

	equal(slots_done.length, 2, 'pre move');

	window.adslots2.push(['baz']);

	equal(slots_done.length, 3, 'post move');
});

test('moveQueue empty', function() {
	// setup
	var slots_done = [];
	AdProviderDummy = {};
	AdProviderDummy.fillInSlot = function(slot) {
		slots_done.push(slot);
	};

	window.adslots2 = [];
	AdEngine2.init();

	equal(slots_done.length, 0, 'pre move');

	window.adslots2.push(['baz']);

	equal(slots_done.length, 1, 'post move');
});

test('moveQueue null', function() {
	// setup
	var slots_done = [];
	AdProviderDummy = {};
	AdProviderDummy.fillInSlot = function(slot) {
		slots_done.push(slot);
	};

	//window.adslots2 = [];
	AdEngine2.init();

	equal(slots_done.length, 0, 'pre move');

	window.adslots2.push(['baz']);

	equal(slots_done.length, 1, 'post move');
});