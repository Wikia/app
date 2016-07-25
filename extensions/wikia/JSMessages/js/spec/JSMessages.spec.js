describe('JSMessages', function () {
	'use strict';

	mw.messages.set({
		foo: 'bar',
		complex: '$1 is $2',
	});
	var defaultLang = window.wgUserLanguage,
		msg = modules.JSMessages(mw, $);

	it('registers AMD module', function () {
		expect(typeof msg).toBe('function');
		expect(typeof msg.get).toBe('function');
		expect(typeof msg.getForContent).toBe('function');
	});

	it('has jQuery API', function () {
		expect(typeof $.msg).toBe('function');
		expect(typeof $.getMessages).toBe('function');
		expect(typeof $.getMessagesForContent).toBe('function');
	});

	it('message is returned', function () {
		window.wgUserLanguage = defaultLang;
		expect(msg('foo')).toBe('bar');
	});

	it('message with parameters is parsed', function () {
		window.wgUserLanguage = defaultLang;
		expect(msg('complex', '123', '456')).toBe('123 is 456');
	});
});
