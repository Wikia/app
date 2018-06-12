/*global beforeEach, describe, it, expect, modules*/
describe('ext.wikia.adEngine.slot.service.srcProvider', function () {
	'use strict';

	var mocks = {
			adContext: {
				get: function () {
					return false;
				}
			}
		};

	function getModule() {
		return modules['ext.wikia.adEngine.slot.service.srcProvider'](
			mocks.adContext,
		);
	}

	function mockContext(map) {
		spyOn(mocks.adContext, 'get').and.callFake(function (name) {
			return map[name];
		});
	}

	it('pass provided src param for non-test wikis', function () {
		expect(getModule().get('xyz')).toBe('xyz');
		expect(getModule().get('abc')).toBe('abc');
	});

	it('adds test- prefix for test wikis', function () {
		spyOn(mocks.adContext, 'get').and.returnValue(true);

		expect(getModule().get('xyz')).toBe('test-xyz');
		expect(getModule().get('abc')).toBe('test-abc');
	});

	it('overrides src for test wiki if it is passed', function () {
		mockContext({
			'opts.isAdTestWiki': true
		});

		expect(getModule().get('xyz', {testSrc: 'BBB'})).toBe('BBB');
	});

	it('sets src=premium if article is premium', function () {
		mockContext({
			'opts.premiumOnly': true
		});

		expect(getModule().get('xyz')).toBe('premium');
	});

	it('returns test even for premium pages', function () {
		mockContext({
			'opts.isAdTestWiki': true,
			'opts.premiumOnly': true
		});

		expect(getModule().get('xyz')).toBe('test-xyz');
	});

	it('sets src=premium if article is premium', function () {
		mockContext({'opts.premiumOnly': true});

		expect(getModule().get('asd', {})).toBe('premium');

	});

	it('doesn\'t set src=premium if article isn\'t premium', function () {
		mockContext({'opts.premiumOnly': false});
		expect(getModule().get('abc')).not.toBe('premium');
	});

	it('returns by default rec as src value for recovery', function () {
		expect(getModule().getRecoverySrc()).toBe('rec');
	});

	it('returns by test-rec to recovery & test wikis', function () {
		mockContext({
			'opts.isAdTestWiki': true
		});
		expect(getModule().getRecoverySrc()).toBe('test-rec');
	});
});
