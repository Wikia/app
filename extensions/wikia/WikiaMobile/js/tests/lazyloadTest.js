/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /extensions/wikia/JSMessages/js/JSMessages.wikiamobile.js
 @test-require-asset /resources/wikia/modules/thumbnailer.js
 @test-require-asset /resources/wikia/modules/querystring.js
 @test-require-asset /extensions/wikia/WikiaTracker/js/WikiaTracker.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/track.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/events.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/loader.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/modal.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/sections.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/media.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/layout.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/lazyload.js
 */

/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Lazyload module", function () {
	'use strict';

	var async = new AsyncSpec(this);

	window.Features = {};
	window.wgStyleVersion = 123;

	async.it('should be defined', function(done){
		document.body.innerHTML = '<section id="mw-content-text"></section>';

		require(['lazyload'], function(lazyload){

			expect(lazyload).toBeDefined();

			done();
		});
	});

	async.it('should lazyload images', function(done){
		document.body.innerHTML = '<section id="mw-content-text"><img alt="Sectionals2.jpg" width="480" height="207" data-src="/usr/wikia/source/trunk/extensions/wikia/WikiaMobile/js/tests/fixtures/blank.png" class="lazy media" data-params="[{&quot;name&quot;:&quot;Sectionals2.jpg&quot;,&quot;full&quot;:&quot;/usr/wikia/source/trunk/extensions/wikia/WikiaMobile/js/tests/fixtures/blank.png&quot;}]"></section>';

		require(['lazyload'], function(lazyload){

			lazyload(document.getElementsByTagName('img'));

			var img = document.getElementsByTagName('img')[0];

			setInterval(function(){
				if(img.src){
					expect(img.src).toMatch('blank.png');
					done();
				}
			},100);
		});
	});


});