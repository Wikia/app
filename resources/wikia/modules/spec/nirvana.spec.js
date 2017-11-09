/*global describe, it, expect, dump, afterEach */
describe('Nirvana', function () {
	'use strict';

	var jQuery = {
			ajax: function () {},
			param: function (string) {
				dump(string);
				return string.join('&');
			}
		},
		nirvana = modules['wikia.nirvana'](jQuery),
		controllerName = 'foo',
		methodName = 'bar',
		origwgScriptPath,
		jQueryParamMock = function (data) {
			var ret = '';

			for (var key in data) {
				ret += key + '=' + data[key] + '&';
			}

			if (ret) {
				ret = ret.slice(0, -1);
			}

			return ret;
		};

	beforeEach(function () {
		origwgScriptPath = window.wgScriptPath;

		// set up the environment
		window.wgScriptPath = '';
	});

	afterEach(function () {
		window.wgScriptPath = origwgScriptPath;
	});

	it('registers AMD module', function () {
		expect(typeof nirvana).toBe('object');
		expect(typeof nirvana.sendRequest).toBe('function');
		expect(typeof nirvana.getJson).toBe('function');
		expect(typeof nirvana.postJson).toBe('function');
		expect(typeof nirvana.getUrl).toBe('function');
	});

	it('has jQuery API', function () {
		expect(typeof $.nirvana).toBe('object');
		expect(typeof $.nirvana.sendRequest).toBe('function', 'sendRequest');
		expect(typeof $.nirvana.getJson).toBe('function', 'getJson');
		expect(typeof $.nirvana.postJson).toBe('function', 'postJson');
		expect(typeof $.nirvana.getUrl).toBe('function', 'getUrl');
	});

	it('controller name is required', function () {
		expect(function () {
			nirvana.sendRequest({});
		}).toThrow('controller and method are required');
	});

	it('method name is required', function () {
		expect(function () {
			nirvana.sendRequest({
				controller: controllerName
			});
		}).toThrow('controller and method are required');
	});

	it('correct format is required', function () {
		expect(function () {
			nirvana.sendRequest({
				controller: controllerName,
				method: methodName,
				format: 'foo'
			});
		}).toThrow('Only Json,Jsonp and Html format are allowed');
	});

	it('sendRequest uses POST and JSON by default', function (done) {
		var jQuery = {
				ajax: function (params) {
					expect(params.url).toBe('/wikia.php?controller=foo&method=bar&format=json');
					expect(params.dataType).toBe('json'); // default format
					expect(params.type).toBe('POST'); // default request method
					expect(typeof params.data).toBe('object');
					expect(params.data.userName).toBe('Wikia');

					// fire callback
					params.success({
						res: true
					});
				},
				param: jQueryParamMock
			},
			nirvana = modules['wikia.nirvana'](jQuery);

		nirvana.sendRequest({
			controller: controllerName,
			method: methodName,
			data: {
				userName: 'Wikia'
			},
			callback: function (resp) {
				expect(typeof resp).toBe('object');
				expect(resp.res).toBe(true);

				done();
			}
		});
	});

	it('onErrorCallback is called', function (done) {
		var jQuery = {
				ajax: function (params) {
					expect(typeof params.error).toBe('function');

					// fire error callback
					params.error();
				},
				param: jQueryParamMock
			},
			nirvana = modules['wikia.nirvana'](jQuery);

		nirvana.sendRequest({
			controller: controllerName,
			method: methodName,
			onErrorCallback: function () {
				done();
			}
		});
	});

	it('getJson uses GET and JSON', function (done) {
		var jQuery = {
				ajax: function (params) {
					expect(params.url).toBe('/wikia.php?controller=foo&method=bar&format=json&userName=Wikia');
					expect(params.dataType).toBe('json');
					expect(params.type).toBe('GET');

					// fire callback
					params.success({
						res: true
					});
				},
				param: jQueryParamMock
			},
			nirvana = modules['wikia.nirvana'](jQuery);

		nirvana.getJson(
			controllerName,
			methodName, {
				userName: 'Wikia'
			},
			function (resp) {
				expect(typeof resp).toBe('object');
				expect(resp.res).toBe(true);

				done();
			}
		);
	});

	it('postJson uses POST and JSON', function (done) {
		var jQuery = {
				ajax: function (params) {
					expect(params.url).toBe('/wikia.php?controller=foo&method=bar&format=json');
					expect(params.dataType).toBe('json');
					expect(params.type).toBe('POST');
					expect(typeof params.data).toBe('object');
					expect(params.data.userName).toBe('Wikia');

					// fire callback
					params.success({
						res: true
					});
				},
				param: jQueryParamMock
			},
			nirvana = modules['wikia.nirvana'](jQuery);

		nirvana.postJson(
			controllerName,
			methodName, {
				userName: 'Wikia'
			},
			function (resp) {
				expect(typeof resp).toBe('object');
				expect(resp.res).toBe(true);

				done();
			}
		);
	});

	it('request parameters are sorted', function (done) {
		// mock the request
		var jQuery = {
				ajax: function (params) {
					expect(params.url)
						.toBe('/wikia.php?controller=foo&method=bar&abc=xyz&format=json&userName=Wikia&value=1');
					expect(typeof params.data).toBe('object');

					// fire callback
					params.success();
				},
				param: jQueryParamMock
			},
			nirvana = modules['wikia.nirvana'](jQuery);

		nirvana.getJson(
			controllerName,
			methodName, {
				value: '1',
				userName: 'Wikia',
				abc: 'xyz'
			},
			function () {
				done();
			}
		);
	});

	it('data can be a string', function (done) {
		// mock the request
		var urlParams = 'value=1&abc=xyz',
			jQuery = {
				ajax: function (params) {
					expect(params.url).toBe('/wikia.php?controller=foo&method=bar&' + urlParams + '&format=json');

					// fire callback
					params.success();
				},
				param: jQueryParamMock
			},
			nirvana = modules['wikia.nirvana'](jQuery);

		nirvana.getJson(
			controllerName,
			methodName,
			urlParams,
			function () {
				done();
			}
		);
	});
});
