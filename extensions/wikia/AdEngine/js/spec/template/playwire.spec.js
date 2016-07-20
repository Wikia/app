/*global describe, it, expect, modules, beforeEach, spyOn*/
describe('ext.wikia.adEngine.template.playwire', function () {
	'use strict';

	function noop () {}

	var mocks = {
			log: noop,
			player: {
				inject: noop,
				getConfigUrl: function () {
					return '//foo.url';
				}
			}
		};

	function getModule() {
		return modules['ext.wikia.adEngine.template.playwire'](
			mocks.player,
			mocks.log
		);
	}

	beforeEach(function () {
		mocks.player.inject = noop;
	});

	it('Cannot show without container', function () {
		var template = getModule();

		spyOn(mocks.player, 'inject');

		template.show({});

		expect(mocks.player.inject).not.toHaveBeenCalled();
	});

	it('Show without custom config url (should get config url from player)', function () {
		var template = getModule();

		spyOn(mocks.player, 'inject');

		template.show({
			container: {}
		});

		expect(mocks.player.inject.calls.mostRecent().args[0]).toEqual('//foo.url');
	});

	it('Show with custom config url', function () {
		var template = getModule();

		spyOn(mocks.player, 'inject');

		template.show({
			configUrl: '//foo.bar',
			container: {}
		});

		expect(mocks.player.inject.calls.mostRecent().args[0]).toEqual('//foo.bar');
	});
});
