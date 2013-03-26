/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Topbar module", function () {
	'use strict';

	var qs = function(){return {
			getHash: function(){},
			setHash: function(){}
		}},
		loader = {},
		toc = {},
		track = {
			event: function(){}
		},
		throbber = {},
		body = getBody(),
		window = {
			document: {
				body: body,
				getElementById: function(id){
					body.querySelector('#' + id);
				}
			}
		},
		topbar = modules.topbar(qs, loader, toc, null, track, throbber, window);

	it('should be defined', function(){
		expect(topbar).toBeDefined();
		expect(typeof topbar.initAutocomplete).toBe('function');
		expect(typeof topbar.openLogin).toBe('function');
		expect(typeof topbar.openProfile).toBe('function');
		expect(typeof topbar.openSearch).toBe('function');
		expect(typeof topbar.closeProfile).toBe('function');
		expect(typeof topbar.closeNav).toBe('function');
		expect(typeof topbar.closeSearch).toBe('function');
		expect(typeof topbar.closeDropDown).toBe('function');
	});

});
