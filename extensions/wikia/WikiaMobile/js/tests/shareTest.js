/*
 * @test-require-asset resources/wikia/libraries/define.mock.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/share.js
 */

/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Share module", function () {
	'use strict';

	window.wgStyleVersion = 1234567890;
	window.wgServer = 'http://test.com';
	window.wgArticlePath = '/$1';
	window.wgPageName = 'Test';
	window.wgTitle = 'Test';
	window.wgSitename = 'Test Wiki';


	var cache = {
		getVersioned: function(){
			return false;
		},
		setVersioned: function(){}
	};

	var JSMessages = function(){
		return function(){
			return 'TEST';
		}
	};

	var loader = function(){
		return {
			done: function(callback){
				callback({
					templates: {
						WikiaMobileSharingService_index: '<ul class=wkLst><li class=facebookShr><a href="http://www.facebook.com/sharer.php?u=__1__&t=__2__" target=_blank>&nbsp;</a></li><li class=twitterShr><a href="http://twitter.com/home?status=__1__%20__2__\" target=_blank>&nbsp;</a></li><li class=plusoneShr><a href="https://plusone.google.com/_/+1/confirm?hl=pl&url=__1__" target=_blank>&nbsp;</a></li><li class=emailShr><a href="mailto:?body=__3__%20__1__&subject=__4__" target=_blank>&nbsp;</a></li></ul>'
					},
					styles: ''
				})
			}
		};
	};

	loader.processStyle = function(){};

	var share = define.getModule(cache, JSMessages, loader);

	it('should be defined', function(){
		expect(share).toBeDefined();
		expect(typeof share).toBe('function');
	});

	it('should return function', function(){
		share('link to share');

		expect(typeof share('link to share')).toBe('function');
		expect(typeof share()).toBe('function');
		expect(typeof share(true)).toBe('function');
	});

	it('should create sharing list', function(){
		document.body.innerHTML = '<div id="sharePlace"></div>';

		var sharePlace = document.getElementById('sharePlace');

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
	});
});
