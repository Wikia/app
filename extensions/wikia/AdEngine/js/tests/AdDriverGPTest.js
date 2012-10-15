/**
 * @test-framework QUnit
 * @test-require-asset extensions/wikia/AdEngine/AdDriverGP.js
 */
module('AdDriverGP');

test('slots', function() {
	window.gpslots = [ [ "a", 1 ], [ "b", 2 ] ];

	var pushedSlots = [];

	AdDriverGP.fillInSlot = function(s) {
		pushedSlots.push(s);
	}

	AdDriverGP.init();

	equal( pushedSlots.length, 2 );

	window.gpslots.push( [ "c", 3 ] );

	equal( pushedSlots.length, 3 );
});
