/**
 * Updates all links related to search to contain specified parameters.
 */
describe('SearchAbTest.LinkUpdater', function(  ) {
	'use strict';
	var logMock = function() {};
	logMock.levels = { debug: 13 };

	var jqueryMock = function(){};

	it("modifies simple local links correctly.", function() {
		var linkUpdater = modules['SearchAbTest.DomUpdater'](jqueryMock, logMock).linkUpdater;
		var modifiedLink = linkUpdater.modifyLink('/', {foo: 'x'});
		expect(modifiedLink).toBe('/?foo=x');
	});

	it("modifies link that ends with '?' correctly.", function() {
		var linkUpdater = modules['SearchAbTest.DomUpdater'](jqueryMock, logMock).linkUpdater;
		var modifiedLink = linkUpdater.modifyLink('/?', {foo: 'x'});
		expect(modifiedLink).toBe('/?foo=x');
	});

	it("modifies simple global links correctly.", function() {
		var linkUpdater = modules['SearchAbTest.DomUpdater'](jqueryMock, logMock).linkUpdater;
		var modifiedLink = linkUpdater.modifyLink('http://domain/path/', {foo: 'x'});
		expect(modifiedLink).toBe('http://domain/path/?foo=x');
	});

	it("does not modify link if passed object is empty.", function() {
		var linkUpdater = modules['SearchAbTest.DomUpdater'](jqueryMock, logMock).linkUpdater;
		var modifiedLink = linkUpdater.modifyLink('http://domain/path', {});
		expect(modifiedLink).toBe('http://domain/path');
	});

	it("does not modify link if parameter is null.", function() {
		var linkUpdater = modules['SearchAbTest.DomUpdater'](jqueryMock, logMock).linkUpdater;
		var modifiedLink = linkUpdater.modifyLink('http://domain/path', null);
		expect(modifiedLink).toBe('http://domain/path');
	});

	it("modifies links with existing undefined arguments correctly.", function() {
		var linkUpdater = modules['SearchAbTest.DomUpdater'](jqueryMock, logMock).linkUpdater;
		var modifiedLink = linkUpdater.modifyLink('http://domain/path?asd', {foo: 'bar'});
		expect(modifiedLink).toBe('http://domain/path?asd&foo=bar');
	});

	it("modifies links with existing arguments correctly.", function() {
		var linkUpdater = modules['SearchAbTest.DomUpdater'](jqueryMock, logMock).linkUpdater;
		var modifiedLink = linkUpdater.modifyLink('http://domain/path?asd=1', {foo: 'bar'});
		expect(modifiedLink).toBe('http://domain/path?asd=1&foo=bar');
	});

});
