/*global describe, it, expect, modules, beforeEach, spyOn*/
describe('ext.wikia.adEngine.utils.hooks', function () {
	'use strict';

	var mocks = {},
		registerHooks;

	function noop () {}

	function getModule() {
		return modules['ext.wikia.adEngine.utils.hooks']();
	}

	beforeEach(function () {
		mocks.fooObject = {
			foo: noop,
			bar: noop,
			baz: noop
		};
		registerHooks = getModule();
	});

	it('Throw exception on registering not existing method', function () {
		expect(function () {
			registerHooks(mocks.fooObject, ['qux']);
		}).toThrowError('Method qux does not exist.');
	});

	it('Throw exception on adding callbacks to not registered method', function () {
		registerHooks(mocks.fooObject, ['foo', 'bar']);
		expect(function () {
			mocks.fooObject.pre('baz', noop);
		}).toThrowError('Method baz is not registered.');
	});

	it('Call pre hooks on correctly registered method', function () {
		var spies = {
			preFoo1: noop,
			preFoo2: noop
		};
		registerHooks(mocks.fooObject, ['foo', 'bar']);
		spyOn(mocks.fooObject, 'foo').and.callThrough();
		spyOn(spies, 'preFoo1');
		spyOn(spies, 'preFoo2');

		mocks.fooObject.pre('foo', spies.preFoo1);
		mocks.fooObject.pre('foo', spies.preFoo2);
		mocks.fooObject.foo();

		expect(mocks.fooObject.foo).toHaveBeenCalled();
		expect(spies.preFoo1).toHaveBeenCalled();
		expect(spies.preFoo2).toHaveBeenCalled();
	});

	it('Call method and all pre hooks with correct arguments', function () {
		var spies = {
			preFoo: noop
		};
		registerHooks(mocks.fooObject, ['foo', 'bar']);
		spyOn(mocks.fooObject, 'foo').and.callThrough();
		spyOn(spies, 'preFoo').and.callThrough();

		mocks.fooObject.pre('foo', spies.preFoo);
		mocks.fooObject.foo('barArgument', []);

		expect(mocks.fooObject.foo.calls.mostRecent().args[0]).toEqual('barArgument');
		expect(mocks.fooObject.foo.calls.mostRecent().args[1]).toEqual([]);

		expect(spies.preFoo.calls.mostRecent().args[0]).toEqual('barArgument');
		expect(spies.preFoo.calls.mostRecent().args[1]).toEqual([]);
	});

	it('Call post hooks on correctly registered method', function () {
		var spies = {
			postBar1: noop,
			postBar2: noop
		};
		registerHooks(mocks.fooObject, ['foo', 'bar']);
		spyOn(mocks.fooObject, 'bar').and.callThrough();
		spyOn(spies, 'postBar1');
		spyOn(spies, 'postBar2');

		mocks.fooObject.post('bar', spies.postBar1);
		mocks.fooObject.post('bar', spies.postBar2);
		mocks.fooObject.bar();

		expect(mocks.fooObject.bar).toHaveBeenCalled();
		expect(spies.postBar1).toHaveBeenCalled();
		expect(spies.postBar2).toHaveBeenCalled();
	});

	it('Call method and all post hooks with correct arguments', function () {
		var spies = {
			postBar: noop
		};
		registerHooks(mocks.fooObject, ['foo', 'bar']);
		spyOn(mocks.fooObject, 'bar').and.callThrough();
		spyOn(spies, 'postBar').and.callThrough();

		mocks.fooObject.post('bar', spies.postBar);
		mocks.fooObject.bar('fooArgument', {a:1});

		expect(mocks.fooObject.bar.calls.mostRecent().args[0]).toEqual('fooArgument');
		expect(mocks.fooObject.bar.calls.mostRecent().args[1]).toEqual({a:1});

		expect(spies.postBar.calls.mostRecent().args[0]).toEqual('fooArgument');
		expect(spies.postBar.calls.mostRecent().args[1]).toEqual({a:1});
	});

	it('Do not call hooks of different method', function () {
		var spies = {
			preFoo: noop
		};
		registerHooks(mocks.fooObject, ['foo', 'bar']);
		spyOn(spies, 'preFoo');

		mocks.fooObject.pre('foo', spies.preFoo);
		mocks.fooObject.bar();

		expect(spies.preFoo).not.toHaveBeenCalled();
	});
});
