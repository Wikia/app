/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /resources/wikia/libraries/zepto/zepto-0.8.js
 @test-require-asset /resources/wikia/modules/cache.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/share.js
 */

/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Test share module", function () {
	'use strict';
	var async = new AsyncSpec(this);

	window.wgStyleVersion = 1234567890;
	window.wgServer = 'http://test.com';
	window.wgArticlePath = '/$1';
	window.wgPageName = 'Test';
	window.wgTitle = 'Test';
	window.wgSitename = 'Test Wiki';

	$.msg = function(){return 'MSG'};

	define.mock('cache', {
		get: function(){return false}
	});

	window.Wikia = {
		getMultiTypePackage: function(obj){
			obj.callback({
				templates: {
					WikiaMobileSharingService_index: '<ul class=wkLst><li class=facebookShr><a href="http://www.facebook.com/sharer.php?u=__1__&t=__2__" target=_blank>&nbsp;</a></li><li class=twitterShr><a href="http://twitter.com/home?status=__1__%20__2__\" target=_blank>&nbsp;</a></li><li class=plusoneShr><a href="https://plusone.google.com/_/+1/confirm?hl=pl&url=__1__" target=_blank>&nbsp;</a></li><li class=emailShr><a href="mailto:?body=__3__%20__1__&subject=__4__" target=_blank>&nbsp;</a></li></ul>'
				},
				styles: ''
			});
		},
		processStyle: function(){}
	};

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

	async.it('should throw', function(done){
		document.body.innerHTML = '<div id="sharePlace"></div>';

		require(['share'], function(share){

			expect(function(){
				share('TESTTEST')();
			}).toThrow();

			expect(function(){
				share('TESTTEST')(document.getElementById('nope'));
			}).toThrow();


			done();
		});
	});

	async.it('should create sharing list', function(done){
		document.body.innerHTML = '<div id="sharePlace"></div>';

		var sharePlace = document.getElementById('sharePlace');

		require(['share'], function(share){
			share('TESTTEST')(sharePlace);

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