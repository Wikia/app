/*global describe, it, modules, expect, spyOn, beforeEach*/
describe('DOMElementTweaker', function () {
	'use strict';

	function noop() {}

	var mocks = {
		log: noop,
		window: {}
	};

	function getModule() {
		return modules['ext.wikia.adEngine.domElementTweaker'](
			mocks.log,
			mocks.window
		);
	}

	beforeEach(function () {
		mocks.element = document.createElement('div');
		mocks.element.classList.add('a');
		mocks.element.classList.add('b');
		mocks.element.classList.add('c');

	});

	it('Test remove existing class', function () {
		var domElementTweaker = getModule();

		domElementTweaker.removeClass(mocks.element, 'b');

		expect(mocks.element.classList).not.toContain('b');
		expect(mocks.element.classList).toContain('a');
		expect(mocks.element.classList).toContain('c');
		expect(mocks.element.classList.length).toEqual(2);
	});

	it('Test remove non-existing class', function () {
		var domElementTweaker = getModule();

		domElementTweaker.removeClass(mocks.element, 'x');

		expect(mocks.element.classList).toContain('a');
		expect(mocks.element.classList).toContain('b');
		expect(mocks.element.classList).toContain('c');
		expect(mocks.element.classList).not.toContain('x');
		expect(mocks.element.classList.length).toEqual(3);
	});

	it('Test remove duplicated class', function () {
		var domElementTweaker = getModule();

		mocks.element.className += ' a a a';

		domElementTweaker.removeClass(mocks.element, 'a');

		expect(mocks.element.classList).toContain('b');
		expect(mocks.element.classList).toContain('c');
		expect(mocks.element.classList).not.toContain('x');
		expect(mocks.element.classList.length).toEqual(2);
		expect(mocks.element.className.trim()).toEqual('b c');
	});
});
