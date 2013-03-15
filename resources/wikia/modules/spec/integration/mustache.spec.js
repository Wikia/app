/*global describe, it, runs, waitsFor, expect, require, document, Mustache*/
describe("Mustache", function () {
	'use strict';

	var mustache = modules['wikia.mustache'],
		template = '{{foo}} is {{{bar}}}!',
		data = {
			foo: 'User',
			bar: 'awesome'
		};

	it('registers AMD module', function(done) {
		expect(typeof mustache).toBe('object');
		expect(typeof mustache.render).toBe('function');
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
