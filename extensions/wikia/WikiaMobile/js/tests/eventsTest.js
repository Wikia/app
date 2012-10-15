/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/events.js
 */

describe("Test event object", function() {
	it("check if events are set", function() {
		var events;

		runs(function(){
			require(['events'], function(eve){
				events = eve;
			})
		});

		waitsFor(function(){

			if ( events ){
				expect(events).toBeDefined();
				expect(events.click).toMatch('click');
				expect(events.size).toMatch('resize');
				expect(events.touch).toMatch('touchstart');
				expect(events.move).toMatch('touchmove');
				expect(events.end).toMatch('touchend');
				expect(events.cancel).toMatch('touchcancel');
			}

			return events;
		}, 'events to be set', 200);
	});
});