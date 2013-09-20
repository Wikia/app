describe("JSMessages", function () {
	'use strict';

	var async = new AsyncSpec(this),
		nirvanaMock = {},
		window = {
			wgMessages: {
				foo: 'bar',
				complex: '$1 is $2',
				plural: 'Na imprezie {{PLURAL:$1|jest $1 slon|sa $1 slonie|jest $1 sloni}}',
				pluralComplex: '{{PLURAL:$1|$1 arbuz|$1 arbuzy|$1 arbuzow}} i {{PLURAL:$2|$2 melon|$2 melony|$2 melonow}}',
				defaultPlural: '{{PLURAL:$1|$1 single|$1 multiple}}',
				sharedPlural: '{{PLURAL:$1|one|two|five}}',
				caseInsensitivePlural: '{{pLuRaL:$1|one|two}}'
			},
			wgUserLanguage: 'foo',
			wgJSMessagesCB: 123
		},
		defaultLang = window.wgUserLanguage,
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
		window.wgUserLanguage = defaultLang;
		expect(msg('foo')).toBe('bar');
	});

	it('message with parameters is parsed', function() {
		window.wgUserLanguage = defaultLang;
		expect(msg('complex', '123', '456')).toBe('123 is 456');
	});

	it('message with plural is working', function() {
		window.wgUserLanguage = 'pl';
		expect(msg('plural', 1)).toBe('Na imprezie jest 1 slon');
		expect(msg('plural', 2)).toBe('Na imprezie sa 2 slonie');
		expect(msg('plural', 8)).toBe('Na imprezie jest 8 sloni');
	});

	it('message with several plurals is working', function() {
		window.wgUserLanguage = 'pl';
		expect(msg('pluralComplex', 2, 5)).toBe('2 arbuzy i 5 melonow');
		expect(msg('pluralComplex', 1, 2)).toBe('1 arbuz i 2 melony');
		expect(msg('pluralComplex', 5, 1)).toBe('5 arbuzow i 1 melon');
	});

	it('shared plural rule definiton is working', function() {
		window.wgUserLanguage = 'sk';
		expect(msg('sharedPlural', 1)).toBe('one');
		expect(msg('sharedPlural', 2)).toBe('two');
		expect(msg('sharedPlural', 5)).toBe('five');
	});

	it('default plural rule is working', function() {
		window.wgUserLanguage = 'klingon';
		expect(msg('defaultPlural', 1)).toBe('1 single');
		expect(msg('defaultPlural', 2)).toBe('2 multiple');
		expect(msg('defaultPlural', 10)).toBe('10 multiple');
	});

	it('passing string as a plural argument is working', function() {
		window.wgUserLanguage = 'klingon';
		expect(msg('defaultPlural', '1')).toBe('1 single');
		expect(msg('defaultPlural', '2')).toBe('2 multiple');
	});

	it('PLURAL keyword in a message in case insensitive', function() {
		window.wgUserLanguage = 'en';
		expect(msg('caseInsensitivePlural', 1)).toBe('one');
		expect(msg('caseInsensitivePlural', 2)).toBe('two');
	});

	it('PLURAL without parameter uses the last form', function() {
		window.wgUserLanguage = 'en';
		expect(msg('defaultPlural')).toBe('$1 multiple');
	});

	it('PLURAL with non numerical parameter uses the last form', function() {
		window.wgUserLanguage = 'en';
		expect(msg('defaultPlural', 'foo')).toBe('foo multiple');
	});

	it('if there is no rule for language sub-code, use the general language rule', function() {
		window.wgUserLanguage = 'pl-PL';
		expect(msg('plural', 1)).toBe('Na imprezie jest 1 slon');
		expect(msg('plural', 2)).toBe('Na imprezie sa 2 slonie');
		expect(msg('plural', 8)).toBe('Na imprezie jest 8 sloni');
	});

	async.it('package with messages is properly loaded and applied', function(done) {
		window.wgUserLanguage = defaultLang;
		var packageName = ['foo', 'bar'],
			nirvanaMock = {
				sendRequest: function(attr) {
					expect(attr.data.uselang).toBe(defaultLang);
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
