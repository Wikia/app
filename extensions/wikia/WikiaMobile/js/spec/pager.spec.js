/*global describe, it, expect*/
describe('Pager module', function () {
	'use strict';

	var windowMock = {
			setTimeout: function (func) {
				func();
			},
			addEventListener: function () {}
		},
		p = modules.pager(windowMock);

	it('should be defined', function () {
		expect(p).toBeDefined();
		expect(typeof p).toBe('function');
	});

	it('should throw', function (done) {
		expect(function () {
			p();
		}).toThrow();

		expect(function () {
			p({
				container: ''
			});
		}).toThrow();

		expect(function () {
			p({
				pages: ''
			});
		}).toThrow();

		expect(function () {
			p({
				container: '',
				pages: ''
			});
		}).toThrow();

		done();
	});

	it('should return helper functions', function () {
		var pager = p({
			container: {
				childNodes: [{}, {}],
				addEventListener: function () {}
			},
			pages: ['1', '2']
		});

		expect(typeof pager.prev).toBe('function');
		expect(typeof pager.next).toBe('function');
		expect(typeof pager.reset).toBe('function');
		expect(typeof pager.cleanup).toBe('function');
		expect(typeof pager.getCurrent).toBe('function');
	});

	it('should return current page', function () {
		var secondPage = {
				className: '',
				innerHTML: 2,
				style: {}
			},
			container = {
				childNodes: [{
						className: '',
						innerHTML: 1,
						style: {},
						nextElementSibling: secondPage
					},
					secondPage
				],
				addEventListener: function () {}
			},
			pager = p({
				container: container,
				pages: ['', '']
			});

		expect(pager.getCurrent().innerHTML).toBe(1);
		pager.next();
		expect(pager.getCurrent().innerHTML).toBe(2);
	});
});
