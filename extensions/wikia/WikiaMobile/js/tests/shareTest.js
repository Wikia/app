/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /resources/wikia/libraries/zepto/zepto-0.8.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/Wikia.utils.js
 @test-require-asset /resources/wikia/libraries/deferred/deferred.js
 @test-require-asset /resources/wikia/libraries/deferred/deferred.api.js
 @test-require-asset /resources/wikia/modules/window.js
 @test-require-asset /resources/wikia/modules/mw.js
 @test-require-asset /resources/wikia/modules/ajax.js
 @test-require-asset /resources/wikia/modules/querystring.js
 @test-require-asset /resources/wikia/modules/cookies.js
 @test-require-asset /resources/wikia/modules/log.js
 @test-require-asset /resources/wikia/modules/nirvana.js
 @test-require-asset /resources/wikia/modules/loader.js
 @test-require-asset /resources/wikia/modules/cache.js
 @test-require-asset /extensions/wikia/JSMessages/js/JSMessages.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/share.js
 */

/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Share module", function () {
	'use strict';
	var async = new AsyncSpec(this);

	window.wgStyleVersion = 1234567890;
	window.wgServer = 'http://test.com';
	window.wgArticlePath = '/$1';
	window.wgPageName = 'Test';
	window.wgTitle = 'Test';
	window.wgSitename = 'Test Wiki';

	define.mock('JSMessages', function(){
		return function(){
			return 'TEST';
		}
	});

	define.mock('wikia.cache', {
		get: function(){return false}
	});


	var loader = function(obj){
		var dfd = new Wikia.Deferred();

		dfd.resolve({
			templates: {
				WikiaMobileSharingService_index: '<ul class=wkLst><li class=facebookShr><a href="http://www.facebook.com/sharer.php?u=__1__&t=__2__" target=_blank>&nbsp;</a></li><li class=twitterShr><a href="http://twitter.com/home?status=__1__%20__2__\" target=_blank>&nbsp;</a></li><li class=plusoneShr><a href="https://plusone.google.com/_/+1/confirm?hl=pl&url=__1__" target=_blank>&nbsp;</a></li><li class=emailShr><a href="mailto:?body=__3__%20__1__&subject=__4__" target=_blank>&nbsp;</a></li></ul>'
			},
			styles: ''
		});

		return dfd.promise();
	};

	loader.processStyle = function(){};

	define.mock('wikia.loader', loader);

	async.it('should be defined', function(done){
		require(['share'], function(share){
			expect(share).toBeDefined();
			expect(typeof share).toBe('function');

			done();
		});
	});

	async.it('should return function', function(done){
		require(['share'], function(share){
			share('link to share');

			expect(typeof share('link to share')).toBe('function');
			expect(typeof share()).toBe('function');
			expect(typeof share(true)).toBe('function');

			done();
		});
	});

	async.it('should create sharing list', function(done){
		document.body.innerHTML = '<div id="sharePlace"></div>';

		var sharePlace = document.getElementById('sharePlace');

		require(['share'], function(share){
			share('TESTTEST')(sharePlace);

throw sharePlace.children.length;
			expect(sharePlace.children.length).toBe(1);
			expect(sharePlace.children[0].className).toBe('wkLst');
			expect(sharePlace.querySelector('.wkLst').children.length).toBe(4);

			var as = sharePlace.querySelectorAll('.wkLst a');

			for(var i = 0, l = as.length; i < l; i++){
				expect(as[i].href).toContain('http://test.com/Test?file=TESTTEST');
				expect(as[i].target).toMatch('_blank');
				expect(as[i].parentElement.className).toMatch('Shr');
			}

			done();
		});
	});
});
