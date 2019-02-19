/*global beforeEach, describe, it, expect, modules*/
describe('ext.wikia.adEngine.slot.service.srcProvider', function () {
	'use strict';

	var mocks = {
		adContext: {
			get: function () {
				return false;
			}
		},
		babDetection: {
			isBlocking: function () {
				return false;
			}
		}
	};

	function getModule() {
		return modules['ext.wikia.adEngine.slot.service.srcProvider'](
			mocks.adContext,
			mocks.babDetection
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

	it('doesn\'t change src to rec if ad is not recoverable', function () {
		mockContext({
			'targeting.skin': 'oasis'
		});

		spyOn(mocks.babDetection, 'isBlocking').and.returnValue(false);

		expect(getModule().get('asd')).toEqual('asd');
	});

	it('changes src to rec if ad is recoverable', function () {
		mockContext({
			'targeting.skin': 'oasis'
		});

		spyOn(mocks.babDetection, 'isBlocking').and.returnValue(true);

		expect(getModule().get('asd')).toBe('rec');
	});

	it('overrides src=rec for test wiki', function () {
		mockContext({
			'targeting.skin': 'oasis',
			'opts.isAdTestWiki': true
		});

		spyOn(mocks.babDetection, 'isBlocking').and.returnValue(true);

		expect(getModule().get('abc')).toBe('test-rec');
	});

	it('returns by default rec as src value for rec', function () {
		expect(getModule().getRecSrc()).toBe('rec');
	});

	it('returns by test-rec to rec & test wikis', function () {
		mockContext({
			'opts.isAdTestWiki': true
		});

		expect(getModule().getRecSrc()).toBe('test-rec');
	});

	it('returns srcTest from WF config preserving original one', function () {
		mockContext({
			'opts.isAdTestWiki': true,
			'targeting.testSrc': 'externaltest'
		});

		expect(getModule().get('gpt')).toBe('gpt,externaltest');
	});
});
