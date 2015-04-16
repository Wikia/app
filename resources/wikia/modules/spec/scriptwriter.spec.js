/*global describe, expect, it, jasmine, modules, spyOn*/
describe('wikia.scriptwriter', function () {
	'use strict';

	function noop() {
		return;
	}

	var mocks = {
		document: {
			getElementById: function () {
				return mocks.domElement;
			}
		},
		domElement: {},
		ghostwriter: noop,
		postscribe: noop,
		lazyQueue: {
			makeQueue: function (queue, callback) {
				queue.start = function () {
					callback(queue[0]);
				};
			}
		},
		loader: function () {
			return {
				done: function (callback) {
					callback();
				}
			};
		},
		log: noop,
		getGwWindow: function () {
			return {
				ghostwriter: mocks.ghostwriter
			};
		},
		getPsWindow: function () {
			return {
				wgUsePostScribe: true,
				postscribe: mocks.postscribe
			};
		}
	};

	function getGwModule() {
		return modules['wikia.scriptwriter'](
			mocks.document,
			mocks.lazyQueue,
			mocks.log,
			mocks.getGwWindow(),
			mocks.loader
		);
	}

	function getPsModule() {
		return modules['wikia.scriptwriter'](
			mocks.document,
			mocks.lazyQueue,
			mocks.log,
			mocks.getPsWindow(),
			mocks.loader
		);
	}

	it('injectScriptByText ghostwriter', function () {
		spyOn(mocks, 'ghostwriter');
		getGwModule().injectScriptByText('foo', 'document.write("aaa");');

		expect(mocks.ghostwriter).toHaveBeenCalledWith(
			mocks.domElement,
			{
				insertType: 'append',
				script: {
					text: 'document.write("<script>document.write(\\"aaa\\");</script>");'
				},
				done: jasmine.any(Function)
			}
		);
	});

	it('injectScriptByUrl ghostwriter', function () {
		spyOn(mocks, 'ghostwriter');
		getGwModule().injectScriptByUrl('foo', 'http://some.url/script.js');

		expect(mocks.ghostwriter).toHaveBeenCalledWith(
			mocks.domElement,
			{
				insertType: 'append',
				script: {
					text: 'document.write("<script src=\\\"http://some.url/script.js\\\"></script>");'
				},
				done: jasmine.any(Function)
			}
		);
	});

	it('injectHtml ghostwriter', function () {
		spyOn(mocks, 'ghostwriter');
		getGwModule().injectHtml('foo', '<div id="aaa">Hello!</div>');

		expect(mocks.ghostwriter).toHaveBeenCalledWith(
			mocks.domElement,
			{
				insertType: 'append',
				script: {
					text: 'document.write("<div id=\\\"aaa\\\">Hello!</div>");'
				},
				done: jasmine.any(Function)
			}
		);
	});

	it('injectScriptByText postscribe', function () {
		spyOn(mocks, 'postscribe');
		getPsModule().injectScriptByText('foo', 'document.write("aaa");');
		expect(mocks.postscribe).toHaveBeenCalledWith(
			mocks.domElement,
			'<script>document.write("aaa");</script>',
			jasmine.any(Object)
		);
	});

	it('injectScriptByUrl postscribe', function () {
		spyOn(mocks, 'postscribe');
		getPsModule().injectScriptByUrl('foo', 'http://some.url/script.js');
		expect(mocks.postscribe).toHaveBeenCalledWith(
			mocks.domElement,
			'<script src="http://some.url/script.js"></script>',
			jasmine.any(Object)
		);
	});

	it('injectHtml postscribe', function () {
		spyOn(mocks, 'postscribe');
		getPsModule().injectHtml('foo', '<div id="aaa">Hello!</div>');
		expect(mocks.postscribe).toHaveBeenCalledWith(
			mocks.domElement,
			'<div id="aaa">Hello!</div>',
			jasmine.any(Object)
		);
	});
});
