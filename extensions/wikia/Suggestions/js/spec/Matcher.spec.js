describe('Test matcher', function() {
	'use strict';
	var matcher = modules.SuggestionsMatcher();

	it('is defined', function() {
		expect(matcher).toBeDefined();
	});

	it('checks suggestion match', function() {
		var suggestion = {
			title: '',
			redirects: []
		};
		expect(matcher.matchSuggestion( suggestion, '')).toBeUndefined();
		suggestion = {
			title: 'asdf',
			redirects: [ 'asd fig', 'asd fih', 'asdfj' ]
		};
		expect(matcher.matchSuggestion( suggestion, 'asd')).toEqual(
			{ prefix : '', match : 'asd', suffix : 'f', type : 'title' }
		);
		expect(matcher.matchSuggestion( suggestion, 'fig')).toEqual(
			{ prefix : 'asd ', match : 'fig', suffix : '', type : 'redirect' }
		);
		suggestion = {
			title: 'Ascension',
			redirects: ['Ascension (Zombie Map)']
		};
		expect(matcher.matchSuggestion( suggestion, 'map')).toEqual(
			{ prefix : 'Ascension (Zombie ', match : 'Map', suffix : ')', type : 'redirect' }
		);
	});

	it('checks matching logic', function() {
		var test = undefined;
		expect(matcher.match(test, '')).toBeNull();
		test = '';
		expect(matcher.match(test, '')).toBeNull();
		test = 'abcd';
		expect(matcher.match(test, 'a')).toEqual( { prefix: '', match: 'a', suffix: 'bcd' } );
		expect(matcher.match(test, 'd')).toBeNull();
		test = 'a:b:c:d:e';
		expect(matcher.match(test, 'b')).toEqual( { prefix: 'a:', match: 'b', suffix: ':c:d:e' } );
		expect(matcher.match(test, 'bc')).toEqual( { prefix: 'a:', match: 'b:c', suffix: ':d:e' } );
		test = 'the a-test';
		expect(matcher.match(test, 'a:')).toEqual( { prefix: 'the ', match: 'a', suffix: '-test' } );
		test = 'Map Pack';
		expect(matcher.match(test, 'map:')).toEqual( { prefix: '', match: 'Map', suffix: ' Pack' } );
		test = 'Maps';
		expect(matcher.match(test, 'map:')).toEqual( { prefix: '', match: 'Map', suffix: 's' } );
		expect(matcher.match(test, 'map: ')).toEqual( { prefix: '', match: 'Map', suffix: 's' } );
		expect(matcher.match(test, 'maps:')).toEqual( { prefix: '', match: 'Maps', suffix: '' } );
		expect(matcher.match(test, 'maps: ')).toEqual( { prefix: '', match: 'Maps', suffix: '' } );
		expect(matcher.match(test, ':!@maps ')).toEqual( { prefix: '', match: 'Maps', suffix: '' } );
		test = 'Map';
		expect(matcher.match(test, 'maps')).toBeNull();
		test = 'first second third';
		expect(matcher.match(test, 'firs:')).toEqual( { prefix: '', match: 'firs', suffix: 't second third' } );
		expect(matcher.match(test, 'first second third')).toEqual( { prefix: '', match: 'first second third', suffix: '' } );
		test = 'missions';
		expect(matcher.match(test, 'mission')).toEqual( { prefix: '', match: 'mission', suffix: 's' } );
		test = 'a b';
		expect(matcher.match(test, 'a[-^[]_)(*&%$#@! 	:"\<>(){}?\/~`+=\\;., b')).toEqual( { prefix: '', match: 'a b', suffix: '' } );
	});

});
