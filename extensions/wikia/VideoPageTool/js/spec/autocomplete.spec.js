/*global describe, it, expect, beforeEach, modules */
describe( 'VideoPageAdmin AutocompleteView (Backbone):', function() {
	'use strict';
	var AutocompleteView,
			instance;

	function createMockCollection() {
		var collection = {};
		collection.on = function() {};
		return collection;
	}

	beforeEach(function() {
		AutocompleteView = modules[ 'views.videopageadmin.autocomplete' ]( jQuery );
		instance = new AutocompleteView({
			collection: createMockCollection()
		});
	});

	it( 'should export a constructor', function() {
		expect( typeof AutocompleteView ).toBe( 'function' );
	});

	it( 'should construct be newable', function() {
		expect( typeof instance ).toBe( 'object' );
	});

	it( 'should be an extension of a Backbone class', function() {
		expect( instance.constructor.toString() ).toBe( 'function () { return parent.apply(this, arguments); }' );
	});
});
