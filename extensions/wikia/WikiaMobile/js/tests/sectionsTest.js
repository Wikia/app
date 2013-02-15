/*
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /resources/wikia/libraries/zepto/zepto-0.8.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/Wikia.utils.js
 @test-require-asset /resources/wikia/libraries/deferred/deferred.js
 @test-require-asset /resources/wikia/libraries/deferred/deferred.api.js
 @test-require-asset /resources/wikia/modules/window.js
 @test-require-asset /resources/wikia/modules/deferred.js
 @test-require-asset /resources/wikia/modules/ajax.js
 @test-require-asset /resources/wikia/modules/nirvana.js
 @test-require-asset /extensions/wikia/JSMessages/js/JSMessages.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/events.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/sections.js
 */

/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Sections module", function () {
	'use strict';
	var async = new AsyncSpec(this);

	define.mock('JSMessages', function(){
		return 'TEST';
	});

	async.it('should be defined', function(done){
		require(['sections'], function(sections){

			expect(sections).toBeDefined();
			expect(typeof sections).toBe('object');
			expect(typeof sections.init).toBe('function');
			expect(typeof sections.toggle).toBe('function');
			expect(typeof sections.open).toBe('function');
			expect(typeof sections.close).toBe('function');
			expect(typeof sections.addEventListener).toBe('function');
			expect(typeof sections.removeEventListener).toBe('function');

			done();
		});
	});

	async.it('should init sections', function(done){

		document.body.innerHTML = '<div id="wkPage"><div id="mw-content-text"><h2>one</h2><p>test</p>test<p>test</p><p>test</p><h2>two</h2><p>test</p><div>test</div></div></div>';

		require(['sections'], function(sections){
			sections.init();

			var h2s = document.querySelectorAll('h2');

			expect(h2s).toBeDefined();

			for(var i = 0, l = h2s.length; i < l; i++) {
				expect(h2s[i].className).toMatch('collSec');
				expect(h2s[i].children[0].className).toMatch('chev');
				expect(h2s[i].nextElementSibling).toBeDefined();
				expect(h2s[i].nextElementSibling.className).toMatch('artSec');
			}

			done();
		});
	});

	async.it('should open/close/toggle section', function(done){

		document.body.innerHTML = '<div id="wkPage"><div id="mw-content-text"><div></div><h2 id="one">one</h2><p>test</p>test<p>test</p><p>test</p><h2>two</h2><p>test</p><div>test</div></div></div>';

		require(['sections'], function(sections){
			sections.init();

			var h2s = document.querySelectorAll('h2');

			for(var i = 0, l = h2s.length; i < l; i++) {
				sections.open(h2s[i]);
				expect(h2s[i].className).toMatch('open');
				expect(h2s[i].nextElementSibling.className).toMatch('open');
			}

			for(i = 0; i < l; i++) {
				sections.close(h2s[i]);
				expect(h2s[i].className).not.toMatch('open');
				expect(h2s[i].nextElementSibling.className).not.toMatch('open');
			}

			for(i = 0; i < l; i++) {
				sections.toggle(h2s[i]);
				expect(h2s[i].className).toMatch('open');
				expect(h2s[i].nextElementSibling.className).toMatch('open');
			}

			for(i = 0; i < l; i++) {
				sections.toggle(h2s[i]);
				expect(h2s[i].className).not.toMatch('open');
				expect(h2s[i].nextElementSibling.className).not.toMatch('open');
			}

			sections.open('one');
			expect(h2s[0].className).toMatch('open');
			expect(h2s[0].nextElementSibling.className).toMatch('open');


			sections.close('one');
			expect(h2s[0].className).not.toMatch('open');
			expect(h2s[0].nextElementSibling.className).not.toMatch('open');

			done();
		});
	});

	async.it('should fire events', function(done){
		document.body.innerHTML = '<div id="wkPage"><div id="mw-content-text"><h2>one</h2><p>test</p>test<p>test</p><p>test</p><h2>two</h2><p>test</p><div>test</div></div></div>';

		require(['sections'], function(sections){
			sections.init();

			sections.addEventListener('open', function(){
				sections.close(document.getElementsByTagName('h2')[0]);
			});

			sections.addEventListener('close', function(){
				done();
			});

			sections.open(document.getElementsByTagName('h2')[0]);
		});
	});
});
