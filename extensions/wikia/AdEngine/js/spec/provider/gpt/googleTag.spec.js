/*global describe, it, expect, modules, spyOn, document, beforeEach*/
describe('ext.wikia.adEngine.provider.gpt.googleTag', function () {
	'use strict';

	function noop() { return undefined; }

	var googleApi,
		adContextOpts = {},
		mocks = {
			adContext: {
				getContext: function () {
					return {
						opts: adContextOpts
					};
				}
			},
			adTracker: {
				track: noop
			},
			element: {
				getId: noop,
				setSizes: noop,
				getSizes: noop,
				getSlotPath: noop,
				setPageLevelParams: noop,
				configureSlot: noop
			},
			log: noop,
			pubads: {
				collapseEmptyDivs: noop,
				enableSingleRequest: noop,
				disableInitialLoad: noop,
				addEventListener: noop,
				refresh: noop,
				setTargeting: noop
			},
			window: {
				googletag: {
					cmd: {
						push: function (callback) {
							callback();
						}
					},
					pubads: function () {
						return mocks.pubads;
					},
					enableServices: noop,
					display: noop,
					defineSlot: function () {
						return {
							addService: noop
						};
					}
				}
			}
		};

	beforeEach(function () {
		adContextOpts = {};
		var GoogleTag = modules['ext.wikia.adEngine.provider.gpt.googleTag'](
			document,
			mocks.log,
			mocks.window
		);
		googleApi = new GoogleTag();
	});

	it('Initialization should prepare googletag object and configure pubads', function () {
		spyOn(mocks.pubads, 'collapseEmptyDivs');
		spyOn(mocks.pubads, 'enableSingleRequest');
		spyOn(mocks.pubads, 'disableInitialLoad');
		spyOn(mocks.pubads, 'addEventListener');
		spyOn(mocks.window.googletag, 'enableServices');

		googleApi.init();

		expect(googleApi.isInitialized()).toBe(true);
		expect(mocks.pubads.collapseEmptyDivs).toHaveBeenCalled();
		expect(mocks.pubads.enableSingleRequest).toHaveBeenCalled();
		expect(mocks.pubads.disableInitialLoad).toHaveBeenCalled();
		expect(mocks.pubads.addEventListener).toHaveBeenCalled();
		expect(mocks.window.googletag.enableServices).toHaveBeenCalled();
	});

	it('Push should call googletag cmd method', function () {
		spyOn(mocks.window.googletag.cmd, 'push');
		googleApi.init();

		googleApi.push(noop);

		expect(mocks.window.googletag.cmd.push).toHaveBeenCalled();
	});

	it('Cannot flush without initialization', function () {
		spyOn(mocks.window.googletag.cmd, 'push');

		googleApi.flush();

		expect(mocks.window.googletag.cmd.push).not.toHaveBeenCalled();
	});

	it('Flush with empty slots queue should not refresh pubads', function () {
		spyOn(mocks.pubads, 'refresh');
		googleApi.init();

		googleApi.flush();

		expect(mocks.pubads.refresh).not.toHaveBeenCalled();
	});

	it('Flush with not empty slots queue should refresh pubads', function () {
		spyOn(mocks.pubads, 'refresh');
		googleApi.init();
		googleApi.addSlot(mocks.element);

		googleApi.flush();

		expect(mocks.pubads.refresh).toHaveBeenCalled();
	});

	it('Already added slot should be displayed once (called display method on googletag)', function () {
		spyOn(mocks.window.googletag, 'display');
		googleApi.init();

		googleApi.addSlot(mocks.element);
		googleApi.addSlot(mocks.element);

		expect(mocks.window.googletag.display.calls.count()).toEqual(1);
	});

	it('Set page targeting params using pubads', function () {
		spyOn(mocks.pubads, 'setTargeting');
		googleApi.init();

		googleApi.setPageLevelParams({
			foo: 7,
			bar: 6
		});

		expect(mocks.pubads.setTargeting.calls.count()).toEqual(2);
	});
});
