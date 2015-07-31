/*global describe, it, expect, modules, spyOn, document, beforeEach*/
describe('ext.wikia.adEngine.provider.gpt.googleTag', function () {
	'use strict';

	function noop() { return undefined; }

	var googleTag,
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
		googleTag = modules['ext.wikia.adEngine.provider.gpt.googleTag'](
			mocks.adContext,
			mocks.adTracker,
			document,
			mocks.log,
			mocks.window
		);
	});

	it('Initialization should prepare googletag object and configure pubads', function () {
		spyOn(mocks.pubads, 'collapseEmptyDivs');
		spyOn(mocks.pubads, 'enableSingleRequest');
		spyOn(mocks.pubads, 'disableInitialLoad');
		spyOn(mocks.pubads, 'addEventListener');
		spyOn(mocks.window.googletag, 'enableServices');

		googleTag.init();

		expect(googleTag.isInitialized()).toBe(true);
		expect(mocks.pubads.collapseEmptyDivs).toHaveBeenCalled();
		expect(mocks.pubads.enableSingleRequest).toHaveBeenCalled();
		expect(mocks.pubads.disableInitialLoad).toHaveBeenCalled();
		expect(mocks.pubads.addEventListener).toHaveBeenCalled();
		expect(mocks.window.googletag.enableServices).toHaveBeenCalled();
	});

	it('Init should add sp.ready event listener if SourcePoint is enabled', function () {
		spyOn(document, 'addEventListener');
		adContextOpts.sourcePoint = true;
		adContextOpts.sourcePointUrl = '//foo.bar';
		googleTag.init();

		expect(document.addEventListener.calls.mostRecent().args[0]).toEqual('sp.blocking');
	});

	it('Init should not add sp.ready event listener if SourcePoint is disabled', function () {
		spyOn(document, 'addEventListener');
		adContextOpts.sourcePoint = false;
		googleTag.init();

		expect(document.addEventListener).not.toHaveBeenCalled();
	});

	it('Push should call googletag cmd method', function () {
		spyOn(mocks.window.googletag.cmd, 'push');
		googleTag.init();

		googleTag.push(noop);

		expect(mocks.window.googletag.cmd.push).toHaveBeenCalled();
	});

	it('Cannot flush without initialization', function () {
		spyOn(mocks.window.googletag.cmd, 'push');

		googleTag.flush();

		expect(mocks.window.googletag.cmd.push).not.toHaveBeenCalled();
	});

	it('Flush with empty slots queue should not refresh pubads', function () {
		spyOn(mocks.pubads, 'refresh');
		googleTag.init();

		googleTag.flush();

		expect(mocks.pubads.refresh).not.toHaveBeenCalled();
	});

	it('Flush with not empty slots queue should refresh pubads', function () {
		spyOn(mocks.pubads, 'refresh');
		googleTag.init();
		googleTag.addSlot(mocks.element);

		googleTag.flush();

		expect(mocks.pubads.refresh).toHaveBeenCalled();
	});

	it('Already added slot should be displayed once (called display method on googletag)', function () {
		spyOn(mocks.window.googletag, 'display');
		googleTag.init();

		googleTag.addSlot(mocks.element);
		googleTag.addSlot(mocks.element);

		expect(mocks.window.googletag.display.calls.count()).toEqual(1);
	});

	it('Set page targeting params using pubads', function () {
		spyOn(mocks.pubads, 'setTargeting');
		googleTag.init();

		googleTag.setPageLevelParams({
			foo: 7,
			bar: 6
		});

		expect(mocks.pubads.setTargeting.calls.count()).toEqual(2);
	});
});
