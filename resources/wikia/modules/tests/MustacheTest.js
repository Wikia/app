/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /resources/jquery/jquery-1.8.2.js
 @test-require-asset /resources/wikia/libraries/mustache/mustache.js
 @test-require-asset /resources/wikia/libraries/mustache/jquery.mustache.js
 */

/*global describe, it, runs, waitsFor, expect, require, document, Mustache*/

describe("Mustache", function () {
	'use strict';

	var async = new AsyncSpec(this),
		template = '{{foo}} is {{{bar}}}!',
		data = {
			foo: 'User',
			bar: 'awesome'
		};

	async.it('registers AMD module', function(done) {
		require(['wikia.mustache'], function(mustache) {
			expect(typeof mustache).toBe('object');
			expect(typeof mustache.render).toBe('function');

			done();
		});
	});

	it('renders a template', function() {
		expect(Mustache.render(template, data)).toBe('User is awesome!');
	});

	it('encodes HTML', function() {
		// {{{}}} doesn't encode HTML characters
		expect(Mustache.render(template, {
			foo: '<foo>',
			bar: '<bar>'
		})).toBe('&lt;foo&gt; is <bar>!');
	});

	it('has jQuery API', function() {
		expect(typeof $.mustache).toBe('function');
		expect(typeof $.fn.mustache).toBe('function');
	});

	it('renders template using $.mustache', function() {
		expect($.mustache(template, data)).toBe('User is awesome!');
	});

	it('renders template stored in script tag', function() {
		var tmpl = $('<script type="text/mustache">' + template + '</script>').appendTo('body');
		expect(tmpl.mustache(data)).toBe('User is awesome!');
	});
});
