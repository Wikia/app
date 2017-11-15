/*global beforeEach, describe, it, expect, modules*/
describe('ext.wikia.adEngine.slot.service.srcProvider', function () {
	'use strict';

	var noop = function () {},
		mocks = {
			adContext: {
				get: function () {
					return false;
				}
			},
			adBlockDetection: {
				isBlocking: noop
			},
			adBlockRecovery: {
				isEnabled: noop
			},
			instartLogic: {
				isEnabled: noop
			}
		};

	function getModule() {
		return modules['ext.wikia.adEngine.slot.service.srcProvider'](
			mocks.adContext,
			mocks.adBlockDetection,
			mocks.adBlockRecovery,
			mocks.instartLogic
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

	it('doesn\'t change src to rec if ad is not recoverable', function () {
		var extra = {
			isPageFairRecoverable: false
		};

		spyOn(mocks.adBlockDetection, 'isBlocking').and.returnValue(true);
		spyOn(mocks.adBlockRecovery, 'isEnabled').and.returnValue(true);

		expect(getModule().get('asd', extra)).toEqual('asd');
	});

	it('changes src to rec if ad is recoverable', function () {
		var extra = {
			isPageFairRecoverable: true
		};

		spyOn(mocks.adBlockDetection, 'isBlocking').and.returnValue(true);
		spyOn(mocks.adBlockRecovery, 'isEnabled').and.returnValue(true);

		expect(getModule().get('asd', extra)).toBe('rec');
	});

	it('sets src=premium if article is premium', function () {
		mockContext({'opts.premiumOnly': true});

		expect(getModule().get('asd', {})).toBe('premium');

	});

	it('change src to rec if on premium pages', function () {
		var extra = {
			isPageFairRecoverable: true
		};

		mockContext({'opts.premiumOnly': true});
		spyOn(mocks.adBlockDetection, 'isBlocking').and.returnValue(true);
		spyOn(mocks.adBlockRecovery, 'isEnabled').and.returnValue(true);

		expect(getModule().get('asd', extra)).toBe('rec');
	});

	it('overrides src=rec for test wiki', function () {
		spyOn(mocks.adBlockDetection, 'isBlocking').and.returnValue(true);
		spyOn(mocks.adBlockRecovery, 'isEnabled').and.returnValue(true);

		var extra = {
			isPageFairRecoverable: true
		};

		expect(getModule().get('abc', extra)).toBe('rec');

		mockContext({'opts.isAdTestWiki': true});
		expect(getModule().get('abc', extra)).toBe('test-rec');
	});

	it('doesn\'t set src=premium if article isn\'t premium', function () {
		mockContext({'opts.premiumOnly': false});
		expect(getModule().get('abc')).not.toBe('premium');
	});

	it('doesn\'t set src=rec if recovery service is enabled and ad is recoverable but adblock is off', function () {
		var extra = {
			isPageFairRecoverable: true
		};

		spyOn(mocks.adBlockRecovery, 'isEnabled').and.returnValue(true);
		spyOn(mocks.adBlockDetection, 'isBlocking').and.returnValue(false);

		expect(getModule().get('abc', extra)).not.toBe('rec');
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
