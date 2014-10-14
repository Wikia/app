/*
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/Wikia.utils.js
 @test-require-asset /resources/wikia/libraries/deferred/deferred.js
 @test-require-asset /resources/wikia/libraries/deferred/deferred.api.js
 @test-require-asset /resources/wikia/modules/window.js
 @test-require-asset /resources/wikia/modules/deferred.js
 @test-require-asset /resources/wikia/modules/ajax.js
 @test-require-asset /resources/wikia/modules/nirvana.js
 @test-require-asset /resources/wikia/modules/tracker.stub.js
 @test-require-asset /resources/wikia/modules/tracker.js
 @test-require-asset /extensions/wikia/JSMessages/js/JSMessages.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/events.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/track.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/sections.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/toc.js
 */

describe("Toc module", function() {
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
