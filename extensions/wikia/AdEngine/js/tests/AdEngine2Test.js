/*
@test-framework QUnit
 @test-require-asset resources/wikia/modules/querystring.js
 @test-require-asset resources/wikia/modules/cookies.js
 @test-require-asset resources/wikia/modules/log.js
 @test-require-asset extensions/wikia/AdEngine/js/tests/AdConfig2.js
 @test-require-asset extensions/wikia/AdEngine/AdEngine2.js
*/
module('AdEngine2');

test('moveQueue', function() {
	// setup
	var slots_done = [];
	adProviderDummy = {};
	adProviderDummy.fillInSlot = function(slot) {
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
	window.adProviderDummy = {};
	window.adProviderDummy.fillInSlot = function(slot) {
		slots_done.push(slot);
	};

	window.adslots2 = [];
	window.AdEngine2.init();

	equal(slots_done.length, 0, 'pre move');

	window.adslots2.push(['baz']);

	equal(slots_done.length, 1, 'post move');
});

test('moveQueue null', function() {
	// setup
	var slots_done = [];
	window.adProviderDummy = {};
	window.adProviderDummy.fillInSlot = function(slot) {
		slots_done.push(slot);
	};

	//window.adslots2 = [];
	window.AdEngine2.init();

	equal(slots_done.length, 0, 'pre move');

	window.adslots2.push(['baz']);

	equal(slots_done.length, 1, 'post move');
});