/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Share module", function () {
	'use strict';

	var cache = {
		getVersioned: function(){
			return false;
		},
		setVersioned: function(){}
	},
	window = {
		wgStyleVersion: 1234567890,
		wgServer: 'http://test.com',
		wgArticlePath: '/$1',
		wgPageName: 'Test',
		wgTitle: 'Test',
		wgSitename: 'Test Wiki'
	},
	JSMessages = function(){
		return function(){
			return 'TEST';
		}
	},
	loader = function(){
		return {
			done: function(callback){
				callback({
					templates: {
						WikiaMobileSharingService_index: 'SHARING_HTML __1__'
					},
					styles: ''
				})
			}
		};
	};

	loader.processStyle = function(){};

	var share = modules.share(cache, JSMessages, loader, window);

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
		var sharePlace = {};

		share()(sharePlace);

		expect(sharePlace.innerHTML).toBe('SHARING_HTML http://test.com/Test');

		share('TEST')(sharePlace);

		expect(sharePlace.innerHTML).toBe('SHARING_HTML http://test.com/Test?file=TEST');

		share('TEST2')(sharePlace);

		expect(sharePlace.innerHTML).toBe('SHARING_HTML http://test.com/Test?file=TEST2');
	});
});
