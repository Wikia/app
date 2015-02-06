/* global UserBaseAjaxForm */

describe('Base class for User Ajax Forms', function () {
	'use strict';

	var proto = UserBaseAjaxForm.prototype;

	it ('Has base methods that other classes depend on', function () {
		expect(typeof proto.init).toBe('function');
	});
});
