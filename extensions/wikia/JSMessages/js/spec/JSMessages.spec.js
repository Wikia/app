describe("JSMessages", function () {
	'use strict';

	var async = new AsyncSpec(this),
		nirvanaMock = {},
		window = {
			wgMessages: {
				foo: 'bar',
				complex: '$1 is $2'
			},
			wgUserLanguage: 'foo',
			wgJSMessagesCB: 123
		},
		msg = modules.JSMessages(nirvanaMock, $, window);

	it('registers AMD module', function() {
		expect(typeof msg).toBe('function');
		expect(typeof msg.get).toBe('function');
		expect(typeof msg.getForContent).toBe('function');
	});

	it('has jQuery API', function() {
		expect(typeof $.msg).toBe('function');
		expect(typeof $.getMessages).toBe('function');
		expect(typeof $.getMessagesForContent).toBe('function');
	});

	it('message is returned', function() {
		expect(msg('foo')).toBe('bar');
	});

	it('message with parameters is parsed', function() {
		expect(msg('complex', '123', '456')).toBe('123 is 456');
	});

	it('default value is returned for unknown message', function() {
		expect(msg('unknown')).toBe('unknown');
	});

	async.it('package with messages is properly loaded and applied', function(done) {
		var packageName = ['foo', 'bar'],
			nirvanaMock = {
				sendRequest: function(attr) {
					expect(attr.data.uselang).toBe('foo');
					expect(attr.data.packages).toBe(packageName.join(','));
					expect(attr.data.cb).toBe(123);

					var dfd = new $.Deferred();

					dfd.resolve({
						messages: {
							foo: 'bar123'
						}
					});

					return dfd.promise();
				}
			},
			msg = modules.JSMessages(nirvanaMock, jQuery, window);

		msg.get(packageName).then(function(resp) {
			// new message value should be used
			expect(msg('foo')).toBe('bar123');
			done();
		});
	});
});
