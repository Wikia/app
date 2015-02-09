/* global UserBaseAjaxForm */

describe('Base class for User Ajax Forms', function () {
	'use strict';

	var instance, $el, options,
		proto = UserBaseAjaxForm.prototype;

	beforeEach(function () {
		$el = $('<div><form><input type="text"></form></div>');
		options = {
			skipFocus: true
		};
	});

	it ('Has base methods that other classes depend on', function () {
		expect(typeof proto.init).toBe('function');
		expect(typeof proto.cacheDOM).toBe('function');
		expect(typeof proto.bindEvents).toBe('function');
		expect(typeof proto.submitLogin).toBe('function');
		expect(typeof proto.submitLoginHandler).toBe('function');
		expect(typeof proto.resetValidation).toBe('function');
		expect(typeof proto.onOkayResponse).toBe('function');
		expect(typeof proto.onErrorResponse).toBe('function');
		expect(typeof proto.onUnconfirmedEmailResponse).toBe('function');
		expect(typeof proto.errorValidation).toBe('function');
		expect(typeof proto.mailPassword).toBe('function');
		expect(typeof proto.reloadPage).toBe('function');
	});

	it ('Requires an element as the first param', function () {
		expect(function () {
			instance = new UserBaseAjaxForm();
		}).toThrow();
	});

});
