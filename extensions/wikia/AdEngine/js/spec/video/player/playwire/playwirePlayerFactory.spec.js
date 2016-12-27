/*global describe, it, expect, modules, beforeEach, spyOn*/
describe('ext.wikia.adEngine.video.player.playwire.playwirePlayerFactory', function () {
	'use strict';

	function noop () {}

	var mocks = {
			api: {
				dispatchEvent: noop,
				on: noop,
				playMedia: noop,
				resizeVideo: noop,
				stopMedia: noop
			},
			params: {
				container: 'barContainer'
			}
		},
		factory;

	function getModule() {
		return modules['ext.wikia.adEngine.video.player.playwire.playwirePlayerFactory']();
	}

	beforeEach(function () {
		factory = getModule();
	});

	it('Player with proper interface', function () {
		var player = factory.create(mocks.api, 'fooId', mocks.params);

		expect(player.id).toBe('fooId');
		expect(player.container).toBe('barContainer');
		expect(typeof player.addEventListener).toBe('function');
		expect(typeof player.play).toBe('function');
		expect(typeof player.stop).toBe('function');
		expect(typeof player.resize).toBe('function');
	});

	it('Add event listener on API event', function () {
		var player = factory.create(mocks.api, 'fooId', mocks.params);

		spyOn(mocks.api, 'on');
		player.addEventListener('fooEvent', noop);

		expect(mocks.api.on.calls.mostRecent().args[0]).toEqual('fooId');
		expect(mocks.api.on.calls.mostRecent().args[1]).toEqual('fooEvent');
	});

	it('Resize video with given dimensions', function () {
		var player = factory.create(mocks.api, 'fooId', mocks.params);

		spyOn(mocks.api, 'resizeVideo');
		player.resize(300, 250);

		expect(mocks.api.resizeVideo.calls.mostRecent().args[0]).toEqual('fooId');
		expect(mocks.api.resizeVideo.calls.mostRecent().args[1]).toEqual('300px');
		expect(mocks.api.resizeVideo.calls.mostRecent().args[2]).toEqual('250px');
	});

	it('Play media using API and dispatch wikia event', function () {
		var player = factory.create(mocks.api, 'fooId', mocks.params);

		spyOn(mocks.api, 'playMedia');
		spyOn(mocks.api, 'dispatchEvent');
		player.play(300, 250);

		expect(mocks.api.playMedia.calls.mostRecent().args[0]).toEqual('fooId');
		expect(mocks.api.dispatchEvent.calls.mostRecent().args[0]).toEqual('fooId');
		expect(mocks.api.dispatchEvent.calls.mostRecent().args[1]).toEqual('wikiaAdStarted');
	});

	it('Stop media using API and dispatch wikia event', function () {
		var player = factory.create(mocks.api, 'fooId', mocks.params);

		spyOn(mocks.api, 'stopMedia');
		spyOn(mocks.api, 'dispatchEvent');
		player.stop();

		expect(mocks.api.stopMedia.calls.mostRecent().args[0]).toEqual('fooId');
		expect(mocks.api.dispatchEvent.calls.mostRecent().args[0]).toEqual('fooId');
		expect(mocks.api.dispatchEvent.calls.mostRecent().args[1]).toEqual('wikiaAdCompleted');
	});
});
