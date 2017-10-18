/*global beforeEach, describe, it, expect, modules*/
describe('ext.wikia.adEngine.slot.service.srcProvider', function () {
	'use strict';

	var noop = function () {},
		mocks = {
			adContext: {
				get: function () { return false; }
			},
			adBlockDetection: {
				isBlocking: noop
			},
			adBlockRecovery: {
				isEnabled: noop
			}
		};

	function getModule() {
		return modules['ext.wikia.adEngine.slot.service.srcProvider'](
			mocks.adContext,
			mocks.adBlockDetection,
			mocks.adBlockRecovery
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
});
