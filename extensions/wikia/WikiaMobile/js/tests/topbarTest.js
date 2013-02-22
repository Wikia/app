/*
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/Wikia.utils.js
 @test-require-asset /resources/wikia/libraries/deferred/deferred.js
 @test-require-asset /resources/wikia/libraries/deferred/deferred.api.js
 @test-require-asset /resources/wikia/modules/deferred.js
 @test-require-asset /resources/wikia/modules/window.js
 @test-require-asset /resources/wikia/modules/location.js
 @test-require-asset /resources/wikia/modules/querystring.js
 @test-require-asset /resources/wikia/modules/ajax.js
 @test-require-asset /resources/wikia/modules/nirvana.js
 @test-require-asset /resources/wikia/modules/cookies.js
 @test-require-asset /resources/wikia/modules/log.js
 @test-require-asset /resources/wikia/modules/loader.js
 @test-require-asset /resources/wikia/modules/tracker.stub.js
 @test-require-asset /resources/wikia/modules/tracker.js
 @test-require-asset /extensions/wikia/JSMessages/js/JSMessages.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/events.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/track.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/throbber.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/sections.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/toc.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/topbar.js
 */

/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Topbar module", function () {
	'use strict';
	var async = new AsyncSpec(this);

	define.mock('track', {
		event: function(){}
	});

	beforeEach(function(){
		document.body.innerHTML = '';
	});

	async.it('should be defined', function(done){
		require(['topbar'], function(topbar){

			expect(topbar).toBeDefined();
			expect(typeof topbar.initAutocomplete).toBe('function');
			expect(typeof topbar.openLogin).toBe('function');
			expect(typeof topbar.openProfile).toBe('function');
			expect(typeof topbar.openSearch).toBe('function');
			expect(typeof topbar.closeProfile).toBe('function');
			expect(typeof topbar.closeNav).toBe('function');
			expect(typeof topbar.closeSearch).toBe('function');
			expect(typeof topbar.closeDropDown).toBe('function');

			done();
		});
	});

});
