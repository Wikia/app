/*!
 * @test-framework QUnit
 * @test-require-asset extensions/wikia/AdEngine/js/AdEngine2.js
 */

module('AdEngine2');

test('run with something in queue', function() {
	// setup
	var slots_done = []
		, logMock = function() {}
		, adConfigMock;

	adConfigMock = {
		getProvider: function(slot) {
			// AdProviderMock:
			return {
				name: 'Mock',
				fillInSlot: function(slot) {
					slots_done.push(slot);
				}
			};
		}
	};

	window.adslots2 = [];
	window.adslots2.push(['foo']);
	window.adslots2.push(['bar']);

	// Mock logMock and window as well!
	AdEngine2(adConfigMock, logMock, window).run();

	equal(slots_done.length, 2, 'pre move');

	window.adslots2.push(['baz']);

	equal(slots_done.length, 3, 'post move');
});

test('run with empty queue', function() {
	// setup
	var slots_done = []
		, logMock = function() {}
		, adConfigMock;

	adConfigMock = {
		getProvider: function(slot) {
			// AdProviderMock:
			return {
				name: 'Mock',
				fillInSlot: function(slot) {
					slots_done.push(slot);
				}
			};
		}
	};

	window.adslots2 = [];

	// Mock logMock and window as well!
	AdEngine2(adConfigMock, logMock, window).run();

	equal(slots_done.length, 0, 'pre move');

	window.adslots2.push(['baz']);

	equal(slots_done.length, 1, 'post move');
});

test('run with null queue', function() {
	// setup
	// setup
	var slots_done = []
		, logMock = function() {}
		, adConfigMock;

	adConfigMock = {
		getProvider: function(slot) {
			// AdProviderMock:
			return {
				name: 'Mock',
				fillInSlot: function(slot) {
					slots_done.push(slot);
				}
			};
		}
	};

	// Mock logMock and window as well!
	AdEngine2(adConfigMock, logMock, window).run();

	equal(slots_done.length, 0, 'pre move');

	window.adslots2.push(['baz']);

	equal(slots_done.length, 1, 'post move');
});
