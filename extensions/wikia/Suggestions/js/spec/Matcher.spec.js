ddescribe('Test matcher', function() {
	'use strict';
	var matcher = modules.suggest_matcher();

	it('is defined', function() {
		expect(matcher).toBeDefined();
	});

	it('checks matching logic', function() {
		var test;
		expect(matcher.match(test, '')).toBeNull();
		test = '';
		expect(matcher.match(test, '')).toBeNull();
		test = 'abcd';
		expect(matcher.match(test, 'a')).toEqual( { prefix: '', match: 'a', suffix: 'bcd' } );
		test = 'a:b:c:d:e';
		expect(matcher.match(test, 'b')).toEqual( { prefix: 'a:', match: 'b', suffix: ':c:d:e' } );
		expect(matcher.match(test, 'bc')).toBeNull();
	});

});
