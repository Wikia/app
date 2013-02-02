/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/define.mock.js
 @test-require-asset /resources/wikia/modules/querystring.js
 */

describe("Querystring", function () {
	"use strict";

	// mock location
	var locationMock = {
			host: 'poznan.wikia.com',
			protocol: 'http',
			pathname: '/wiki/Gzik',
			search: '',
			hash: ''
		},
		querystring = define.getModule(locationMock);

	it('registers AMD module', function() {
		expect(querystring).toBeDefined();
		expect(querystring).toBeFunction('querystring');
	});

	it('exposes itself to Wikia namespace', function() {
		expect(Wikia.Querystring).toBeDefined();
		expect(Wikia.Querystring).toBeFunction('Wikia.Querystring');
	});

	it('gives nice and clean API', function() {
		var qs = new querystring();

		expect(qs.getPath).toBeFunction('getPath');
		expect(qs.setPath).toBeFunction('setPath');
		expect(qs.getVal).toBeFunction('getVal');
		expect(qs.setVal).toBeFunction('setVal');
		expect(qs.removeVal).toBeFunction('removeVal');
		expect(qs.getHash).toBeFunction('getHash');
		expect(qs.setHash).toBeFunction('setHash');
		expect(qs.removeHash).toBeFunction('removeHash');
		expect(qs.addCb).toBeFunction('addCb');
		expect(qs.toString).toBeFunction('toString');
		expect(qs.goTo).toBeFunction('goTo');
	});

	it('works with new and without new operand', function(){

		expect(function(){
			new querystring()
		}).not.toThrow();

		expect(function(){
			querystring()
		}).not.toThrow();
	});

	it('changes location with goTo()', function() {
		var qs = new querystring();
		qs.goTo();

		expect(locationMock.href).toBe('http//poznan.wikia.com/wiki/Gzik');
	});

	it('can work with search string correctly', function(){
		var qs = new querystring();

		expect(qs.getVal('test')).not.toBeDefined();
		expect(qs.getVal('test', null)).toBeNull();
		expect(qs.getVal('test', 1)).toBe(1);
		expect(qs.getVal('test', '')).toBe('');
		expect(qs.getVal('test', [])).toEqual([]);
		expect(qs.getVal('test', [1])).toEqual([1]);
		expect(qs.getVal('test', 'string')).toBe('string');

		qs.setVal('test');

		expect(qs.getVal('test')).not.toBeDefined();

		qs.setVal('test', 'test');

		expect(qs.getVal('test')).toBe('test');

		qs.setVal('test', 'test1');

		expect(qs.getVal('test')).toBe('test1');

		qs.setVal('test');

		expect(qs.getVal('test')).toBe('test1');

		qs.removeVal('test');

		expect(qs.getVal('test')).not.toBeDefined();

		qs.setVal('test', 'test');
		qs.setVal('test1', 'test1');

		expect(qs.getVal('test')).toBe('test');
		expect(qs.getVal('test1')).toBe('test1');

		qs.removeVal(['test', 'test1']);

		expect(qs.getVal('test')).not.toBeDefined();
		expect(qs.getVal('test1')).not.toBeDefined();

		qs.setVal({
			test: 'test',
			test1: 'test1'
		});

		expect(qs.getVal('test')).toBe('test');
		expect(qs.getVal('test1')).toBe('test1');

		qs.setVal({
			test: 'test',
			test1: 'test1'
		});

		expect(qs.getVal('test')).toBe('test');
		expect(qs.getVal('test1')).toBe('test1');

		qs.setVal(
			{
				A: 'a',
				B: 'b'
			},
			'prefix'
		);

		expect(qs.getVal('prefixA')).toBe('a');
		expect(qs.getVal('prefixB')).toBe('b');

		qs.setVal(['val1' , 'val2']);

		expect(qs.getVal('0')).toBe('val1');
		expect(qs.getVal('1')).toBe('val2');

		qs.setVal(['val1' , 'val2'], 'prefix');

		expect(qs.getVal('prefix0')).toBe('val1');
		expect(qs.getVal('prefix1')).toBe('val2');

		expect(qs.toString()).toBe('http//poznan.wikia.com/wiki/Gzik?test=test&test1=test1&prefixA=a&prefixB=b&0=val1&1=val2&prefix0=val1&prefix1=val2');

	});

	it('can work with hash correctly', function(){
		var qs = new querystring();

		expect(qs.getHash()).toBe('');

		qs.setHash('test');

		expect(qs.getHash()).toBe('test');

		qs.setHash('test1')

		expect(qs.getHash()).toBe('test1');

		qs.removeHash();

		expect(qs.getHash()).toBe('');

		qs.setHash('test');

		expect(qs.getHash()).toBe('test');

		qs.removeHash('test');

		expect(qs.getHash()).toBe('');

		qs.setHash('test');

		expect(qs.getHash()).toBe('test');

		qs.removeHash(['a', 'b']);

		expect(qs.getHash()).toBe('test');

		qs.removeHash(['a', 'test']);

		expect(qs.getHash()).toBe('');
	});

	it('adds random cb to querystring', function(){
		var qs = new querystring();

		expect(qs.getVal('cb')).not.toBeDefined();

		qs.addCb();

		expect(qs.getVal('cb')).toMatch(/\d*/);
	});

	it('can work with path correctly', function(){
		var qs = new querystring();

		expect(qs.getPath()).toBe('/wiki/Gzik');

		qs.setPath('NEW');

		expect(qs.getPath()).toBe('NEW');

		qs.setPath('/wiki/Wodna');

		expect(qs.toString()).toBe('http//poznan.wikia.com/wiki/Wodna')

	});

	it('parses given url correctly', function(){
		var qs = new querystring('http://wikia.com/Mobile?useskin=wikiamobile&uselang=en#sectionA');

		expect(qs.getVal('useskin')).toBe('wikiamobile');
		expect(qs.getVal('uselang')).toBe('en');
		expect(qs.getHash()).toBe('sectionA');
		expect(qs.getPath()).toBe('/Mobile');

		qs = querystring('https://wikia.com/Mobile?url=http://wikia.com&url2=http://glee.wikia.com');

		expect(qs.getVal('url')).toBe('http://wikia.com');
		expect(qs.getVal('url2')).toBe('http://glee.wikia.com');
		expect(qs.getPath()).toBe('/Mobile');
	});

	it('is chainable', function(){
		expect(function(){
			expect(
				querystring()
					.setPath('/wiki/Wodna')
					.setVal('action', 'purge')
					.setVal([1,2])
					.setHash('sectionA')
					.toString()
			).toBe(
				'http//poznan.wikia.com/wiki/Wodna?action=purge&0=1&1=2#sectionA'
			);
		}).not.toThrow();
	});

	it('can cast itself toString', function(){
		var qs = new querystring();

		expect(qs + '').toBe('http//poznan.wikia.com/wiki/Gzik');
		expect(qs.toString()).toBe('http//poznan.wikia.com/wiki/Gzik');
	});
});