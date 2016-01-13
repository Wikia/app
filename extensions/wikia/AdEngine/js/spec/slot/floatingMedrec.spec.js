/*global describe, it, expect, modules, spyOn, beforeEach*/
describe('ext.wikia.adEngine.slot.floatingMedrec', function () {
	'use strict';

	function noop() {
	}

	var mocks = {
		context: {
			getContext: function () {
				return {
					opts: {
						floatingMedrec: true
					}
				};
			}
		},
		win: {
			addEventListener: noop,
			wgIsContentNamespace: true,
			adslots2: {
				push: noop
			}
		},
		log: noop,
		adHelper: {
			throttle: noop
		},
		css: noop,
		jQuery: function (selector) {
			return {
				'<div class="wikia-ad"></div>': {
					attr: function () {
						return {
							height: function () {
								return 10;
							},
							css: mocks.css
						};
					}
				},
				'#WikiaAdInContentPlaceHolder': {
					offset: function () {
						return {
							top: 100
						};
					},
					append: noop,
					length: 1
				},
				'#WikiaFooter': {
					offset: function () {
						return {
							top: 200
						};
					},
					append: noop
				},
				'#LEFT_SKYSCRAPER_3': {},
				'#globalNavigation': {
					height: function () {
						return 0;
					}
				}
			}[selector];
		}
	};

	beforeEach(function () {
		mocks.win.scrollY = 0;
		spyOn(mocks, 'css');
	});

	function getModule() {
		return modules['ext.wikia.adEngine.slot.floatingMedrec'](
			mocks.context,
			mocks.adHelper,
			mocks.jQuery,
			mocks.log,
			mocks.win
		);
	}

	it('FMR should have relative position when viewport is higher than FMR zone', function () {
		mocks.win.scrollY = 0;

		getModule().init();

		expect(mocks.css.calls.mostRecent().args[0].position).toEqual('relative');
	});

	it('FMR should have fixed position when viewport is inside of FMR zone', function () {
		mocks.win.scrollY = 150;

		getModule().init();

		expect(mocks.css.calls.mostRecent().args[0].position).toEqual('fixed');
	});

	it('FMR should have absolute position when viewport is lower of FMR zone', function () {
		mocks.win.scrollY = 250;

		getModule().init();

		expect(mocks.css.calls.mostRecent().args[0].position).toEqual('absolute');
	});
});
