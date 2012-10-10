/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /extensions/wikia/WikiaTracker/js/WikiaTracker.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/events.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/track.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/sections.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/toc.js
 */

describe("Test Toc Module", function() {
	var async = new AsyncSpec(this);

	async.beforeEach(function(done){
		define.mock('track', {
			event: function(){},
			CLICK: ''
		});

		define.mock('sections', {
			open: function(){}
		});

		done();
	});

	async.it('should be defined', function(done){
		require(['toc'], function(toc){
			expect(toc).toBeDefined();
			expect(typeof toc.init).toEqual('function');
			expect(typeof toc.open).toEqual('function');
			expect(typeof toc.close).toEqual('function');

			done();
		});
	});

	async.it('should init', function(done){
		document.body.innerHTML = '<div id="mw-content-text"><table id="toc" class="toc"><div id="toctitle"></div></table></div>';

		require(['toc'], function(toc){
			toc.init();

			expect(document.body.className).toMatch('hasToc');

			var chev = document.getElementById('toctitle').querySelectorAll('.chev');
			expect(chev.length).toEqual(1);

			done();
		});
	});

	async.it('should open/close toc', function(done){
		document.body.innerHTML = '<div id="mw-content-text"><table id="toc" class="toc"><div id="toctitle"></div></table></div>';

		require(['toc'], function(toc){
			toc.init();
			toc.open();

			expect(document.getElementById('toc').className).toMatch('open');
			expect(document.body.className).toMatch('hidden');

			toc.close();

			expect(document.getElementById('toc').className).not.toMatch('open');
			expect(document.body.className).not.toMatch('hidden');

			done();
		});

	})
});