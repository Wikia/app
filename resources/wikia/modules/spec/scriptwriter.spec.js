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

	it('injectScriptByText ghostwriter', function () {
		spyOn(mocks, 'ghostwriter');
		getGwModule().injectScriptByText('foo', 'document.write("aaa");');

		expect(mocks.ghostwriter).toHaveBeenCalledWith(
			mocks.domElement,
			{
				insertType: 'append',
				script: {
					text: 'document.write("aaa");'
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
});
