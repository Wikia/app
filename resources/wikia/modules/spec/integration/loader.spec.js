/*global describe, getBody, spyOn, modules*/
describe('Loader Module', function () {
	'use strict';

	var windowMock = {
			document: window.document,
			wgCdnRootUrl: '',
			wgAssetsManagerQuery: '/__am/%4$d/%1$s/%3$s/%2$s',
			wgUserLanguage: 'ja',
			wgStyleVersion: ~~(Math.random() * 99999)
		},
		mwMock,
		nirvanaMock = {},
		logMock = function () {},
		fbLocale = modules['wikia.fbLocale']();

	logMock.levels = {};

	var loader = modules['wikia.loader'](windowMock, mwMock, nirvanaMock, jQuery, logMock, fbLocale);

	it('registers itself', function () {
		expect(typeof loader).toBe('function');
		expect(typeof loader.processScript).toBe('function');
		expect(typeof loader.processStyle).toBe('function');
	});

	it('gives meaningful types', function () {
		expect(loader.JS).toEqual('js');
		expect(loader.AM_GROUPS).toEqual('amgroups');
		expect(loader.CSS).toEqual('css');
		expect(loader.SCSS).toEqual('scss');
		expect(loader.MULTI).toEqual('multi');
		expect(loader.LIBRARY).toEqual('library');
	});

	it('gives meaningful errors', function () {
		expect(loader.NOT_LOADED).toEqual('Some of resources not loaded');
		expect(loader.CORRUPT_FORMAT).toEqual('Wrong object format');
	});

	it('style should be processed', function () {
		var body = getBody();

		body.innerHTML = '<div class=test></div>';

		var div = body.getElementsByClassName('test')[0];

		expect(div.style.width).toBe('');
		loader.processStyle('.test{width:100px}');
		expect(getComputedStyle(div).width).toBe('100px');
	});

	it('scripts should be processed', function () {
		loader.processScript('window.run = true');
		expect(window.run).toBe(true);
	});

	it('support deferred', function () {
		expect(typeof loader('some/path').then).toBe('function');
		expect(typeof loader('some/path').done).toBe('function');
		expect(typeof loader('some/path').fail).toBe('function');
	});

	it('should fire on fail callback', function (done) {
		var path = 'some/path/asd',
			path1 = 'some/other/path/dd';

		loader(path, path1)
			.done(function () {
				//if this runs there is something wrong
				//email someone!!! :)
				expect(false).toBe(true);
				done();
			})
			.fail(function (resources) {
				expect(resources).toBeDefined();
				expect(resources.error).toEqual(loader.NOT_LOADED);
				expect(resources.resources[1].type).toEqual(loader.UNKNOWN);

				done();
			});
	});

	it('should accept arrays as resources', function (done) {
		loader({
			type: loader.JS,
			resources: ['test', 'test/test']
		}).always(function (fail) {
			expect(fail.resources.length).toBe(2);
			done();
		});
	});

	it('RL module is properly loaded', function (done) {
		var mwMock = {
				loader: {
					using: function (use) {
						expect(JSON.stringify(use)).toEqual('["jquery.mustache"]');

						// mock and return deferred object
						return {
							done: function (cb) {
								cb();

								return {
									fail: function () {}
								};
							}
						};
					}
				}
			},
			loader = modules['wikia.loader'](windowMock, mwMock, nirvanaMock, jQuery, logMock, fbLocale);

		// check calls to this function
		spyOn(mwMock.loader, 'using').and.callThrough();

		loader({
			type: loader.LIBRARY,
			resources: ['mustache']
		}).
		done(function () {
			expect(mwMock.loader.using).toHaveBeenCalled();
			done();
		});
	});

	it('Facebook library is properly initialized when lazy loaded', function (done) {
		var windowMock = {
				document: window.document,
				wgUserLanguage: 'ja',
				onFBloaded: function () {}
			},
			loader = modules['wikia.loader'](windowMock, mwMock, nirvanaMock, jQuery, logMock, fbLocale);

		document.head.appendChild = function (script) {
			script.onload();
		};

		// check calls to this function
		spyOn(windowMock, 'onFBloaded').and.callThrough();

		loader({
			type: loader.LIBRARY,
			resources: ['facebook']
		}).
		done(function () {
			expect(windowMock.onFBloaded).toHaveBeenCalled();
			done();
		});
	});
});
