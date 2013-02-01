/*
 @test-require-asset /resources/wikia/libraries/define.mock.js
 @test-require-asset /resources/wikia/modules/querystring.js
 */

describe("Querystring", function () {
	'use strict';

	// mock location
	var locationMock = {
			host: 'poznan.wikia.com',
			protocol: 'http',
			pathname: '/wiki/Gzik',
			search: '',
			hash: ''
		},
		querystring = define.getModule(locationMock);

	it('registers AMD module', function() {
		expect(typeof querystring).toBe('function');
	});

	it('goTo() changes location', function() {
		var qs = new querystring();
		qs.goTo();

		expect(locationMock.href).toBe('http//poznan.wikia.com/wiki/Gzik');
	});
});
