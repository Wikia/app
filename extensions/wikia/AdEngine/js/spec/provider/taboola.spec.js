/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('Taboola ', function () {
	'use strict';

	var noop = function () {},
		mocks = {
			adContext: {
				getContext: function () {
					return {
						targeting: {
							pageType: 'article'
						}
					};
				}
			},
			recoveryHelper: {
				addOnBlockingCallback: noop
			},
			slotTweaker: {
				show: noop
			},
			taboolaHelper: {
				initializeWidget: function ( widget ) {
					mocks.window._taboola = [widget];
				}
			},
			geo: {
				isProperGeo: function (countries) {
					return countries.indexOf('CURRENT') !== -1;
				}
			},
			instantGlobals: {},
			log: noop,
			window: {},
			document: {
				node: {
					appendChild: noop,
					parentNode: {
						removeChild: noop
					}
				},
				createElement: function () {
					return mocks.document.node;
				},
				getElementById: function () {
					return mocks.document.node;
				},
				getElementsByTagName: function () {
					return [mocks.document.node];
				}
			}
		};

	function getTaboola() {
		return modules['ext.wikia.adEngine.provider.taboola'](
			mocks.adContext,
			mocks.recoveryHelper,
			mocks.slotTweaker,
			mocks.taboolaHelper,
			mocks.geo,
			mocks.instantGlobals,
			mocks.log,
			mocks.window,
			mocks.document
		);
	}

	function createSlot(slotName) {
		return {
			name: slotName,
			container: mocks.document.node,
			success: noop
		};
	}

	beforeEach(function () {
		mocks.instantGlobals.wgAdDriverTaboolaConfig = {
			'NATIVE_TABOOLA_ARTICLE': {
				recovery: [],
				regular: ['CURRENT']
			},
			'NATIVE_TABOOLA_RAIL': {
				recovery: [],
				regular: []
			},
			'TOP_LEADERBOARD_AB': {
				recovery: [],
				regular: []
			}
		};
	});

	it('Cannot handle not defined slot', function () {
		var taboola = getTaboola();

		expect(taboola.canHandleSlot('NOT_SUPPORTED_SLOT')).toBeFalsy();
	});

	it('Cannot handle below article slot if there is no read more', function () {
		spyOn(mocks.document, 'getElementById').and.returnValue(undefined);
		var taboola = getTaboola();

		expect(taboola.canHandleSlot('NATIVE_TABOOLA_ARTICLE')).toBeFalsy();
	});

	it('Cannot handle slot from not listed country', function () {
		mocks.instantGlobals.wgAdDriverTaboolaConfig.NATIVE_TABOOLA_ARTICLE.regular = ['ZZ'];
		var taboola = getTaboola();

		expect(taboola.canHandleSlot('NATIVE_TABOOLA_ARTICLE')).toBeFalsy();
	});

	it('Handles NATIVE_TABOOLA_ARTICLE for given country', function () {
		var taboola = getTaboola();

		expect(taboola.canHandleSlot('NATIVE_TABOOLA_ARTICLE')).toBeTruthy();
	});

	it('Cannot handle recovery NATIVE_TABOOLA_ARTICLE from not listed country', function () {
		mocks.instantGlobals.wgAdDriverTaboolaConfig.NATIVE_TABOOLA_ARTICLE = {
			recovery: [],
			regular: []
		};
		var taboola = getTaboola();

		expect(taboola.canHandleSlot('NATIVE_TABOOLA_ARTICLE')).toBeFalsy();
	});

	it('Handles recovery NATIVE_TABOOLA_RAIL for given country', function () {
		mocks.instantGlobals.wgAdDriverTaboolaConfig.NATIVE_TABOOLA_RAIL = {
			recovery: ['CURRENT'],
			regular: []
		};
		var taboola = getTaboola();

		expect(taboola.canHandleSlot('NATIVE_TABOOLA_RAIL')).toBeTruthy();
	});

	it('Handles recovery TOP_LEADERBOARD_AB for given country', function () {
		mocks.instantGlobals.wgAdDriverTaboolaConfig.TOP_LEADERBOARD_AB = {
			recovery: ['CURRENT'],
			regular: []
		};
		var taboola = getTaboola();

		expect(taboola.canHandleSlot('TOP_LEADERBOARD_AB')).toBeTruthy();
	});

	it('Fills regular slot without using recovery helper', function () {
		spyOn(mocks.recoveryHelper, 'addOnBlockingCallback');
		spyOn(mocks.slotTweaker, 'show');
		mocks.instantGlobals.wgAdDriverTaboolaConfig.NATIVE_TABOOLA_RAIL = {
			recovery: ['CURRENT'],
			regular: []
		};
		var taboola = getTaboola();

		taboola.canHandleSlot('NATIVE_TABOOLA_ARTICLE');
		taboola.fillInSlot(createSlot('NATIVE_TABOOLA_ARTICLE'));

		expect(mocks.recoveryHelper.addOnBlockingCallback).not.toHaveBeenCalled();
		expect(mocks.slotTweaker.show).toHaveBeenCalled();
	});

	it('Fills in NATIVE_TABOOLA_RAIL recovery slot using recovery helper', function () {
		mocks.instantGlobals.wgAdDriverTaboolaConfig.NATIVE_TABOOLA_RAIL = {
			recovery: ['CURRENT'],
			regular: []
		};
		spyOn(mocks.recoveryHelper, 'addOnBlockingCallback');
		var taboola = getTaboola();

		taboola.canHandleSlot('NATIVE_TABOOLA_RAIL');
		taboola.fillInSlot(createSlot('NATIVE_TABOOLA_RAIL'));

		expect(mocks.recoveryHelper.addOnBlockingCallback).toHaveBeenCalled();
	});

	it('Fills in TOP_LEADERBOARD_AB recovery slot using recovery helper', function () {
		mocks.instantGlobals.wgAdDriverTaboolaConfig.TOP_LEADERBOARD_AB = {
			recovery: ['CURRENT'],
			regular: []
		};
		spyOn(mocks.recoveryHelper, 'addOnBlockingCallback');
		var taboola = getTaboola();

		taboola.canHandleSlot('TOP_LEADERBOARD_AB');
		taboola.fillInSlot(createSlot('TOP_LEADERBOARD_AB'));

		expect(mocks.recoveryHelper.addOnBlockingCallback).toHaveBeenCalled();
	});
});
