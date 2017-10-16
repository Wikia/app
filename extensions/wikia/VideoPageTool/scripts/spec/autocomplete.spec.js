/*global describe, it, expect, afterEach, beforeEach, modules */
describe('VideoPageTool: Admin AutocompleteView ( Backbone ):', function () {
	'use strict';
	var AutocompleteView,
		instance;

	function createMockCollection() {
		var collection = {};
		collection.on = function () {};
		return collection;
	}

	beforeEach(function () {
		$('body').append('<div id="autocompleteTest"><input data-autocomplete type="text" value="" /></div>');
		AutocompleteView = modules['videopageadmin.views.autocomplete'](jQuery);
		instance = new AutocompleteView({
			collection: createMockCollection(),
			el: $('#autocompleteTest')
		});
	});

	afterEach(function () {
		$('#autocompleteTest').remove();
	});

	it('should export a constructor', function () {
		expect(typeof AutocompleteView).toBe('function');
	});

	it('should construct be newable', function () {
		expect(typeof instance).toBe('object');
	});

	it('should extend Backbone.View', function () {
		expect(instance instanceof Backbone.View).toBe(true);
	});
});
