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
			abTest: {
				getGroup: noop
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
			mocks.abTest,
			mocks.geo,
			mocks.instantGlobals,
			mocks.log,
			mocks.window,
			mocks.document
		);
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

	it('Cannot handle slot without AbTest group', function () {
		spyOn(mocks.abTest, 'getGroup').and.returnValue(undefined);
		var taboola = getTaboola();

		expect(taboola.canHandleSlot('NATIVE_TABOOLA_ARTICLE')).toBeFalsy();
	});

	it('Cannot handle slot from not listed country', function () {
		spyOn(mocks.abTest, 'getGroup').and.returnValue('YES');
		mocks.instantGlobals.wgAdDriverTaboolaConfig.NATIVE_TABOOLA_ARTICLE.regular = ['ZZ'];
		var taboola = getTaboola();

		expect(taboola.canHandleSlot('NATIVE_TABOOLA_ARTICLE')).toBeFalsy();
	});

	it('Handles NATIVE_TABOOLA_ARTICLE for given country and AbTest group', function () {
		spyOn(mocks.abTest, 'getGroup').and.returnValue('YES');
		var taboola = getTaboola();

		expect(taboola.canHandleSlot('NATIVE_TABOOLA_ARTICLE')).toBeTruthy();
	});

	it('Cannot handle recovery NATIVE_TABOOLA_ARTICLE when AbTest group is wrong', function () {
		spyOn(mocks.abTest, 'getGroup').and.returnValue('NO');
		mocks.instantGlobals.wgAdDriverTaboolaConfig.NATIVE_TABOOLA_ARTICLE = {
			recovery: ['CURRENT'],
			regular: []
		};
		var taboola = getTaboola();

		expect(taboola.canHandleSlot('NATIVE_TABOOLA_ARTICLE')).toBeFalsy();
	});

	it('Cannot handle recovery NATIVE_TABOOLA_ARTICLE from not listed country', function () {
		spyOn(mocks.abTest, 'getGroup').and.returnValue('YES');
		mocks.instantGlobals.wgAdDriverTaboolaConfig.NATIVE_TABOOLA_ARTICLE = {
			recovery: [],
			regular: []
		};
		var taboola = getTaboola();

		expect(taboola.canHandleSlot('NATIVE_TABOOLA_ARTICLE')).toBeFalsy();
	});

	it('Handles recovery NATIVE_TABOOLA_RAIL for given country and AbTest group', function () {
		spyOn(mocks.abTest, 'getGroup').and.returnValue('YES');
		mocks.instantGlobals.wgAdDriverTaboolaConfig.NATIVE_TABOOLA_RAIL = {
			recovery: ['CURRENT'],
			regular: []
		};
		var taboola = getTaboola();

		expect(taboola.canHandleSlot('NATIVE_TABOOLA_RAIL')).toBeTruthy();
	});

	it('Fills regular slot without using recovery helper', function () {
		spyOn(mocks.recoveryHelper, 'addOnBlockingCallback');
		spyOn(mocks.slotTweaker, 'show');
		spyOn(mocks.abTest, 'getGroup').and.returnValue('YES');
		mocks.instantGlobals.wgAdDriverTaboolaConfig.NATIVE_TABOOLA_RAIL = {
			recovery: ['CURRENT'],
			regular: []
		};
		var taboola = getTaboola();

		taboola.canHandleSlot('NATIVE_TABOOLA_ARTICLE');
		taboola.fillInSlot('NATIVE_TABOOLA_ARTICLE', mocks.document.node, noop);

		expect(mocks.recoveryHelper.addOnBlockingCallback).not.toHaveBeenCalled();
		expect(mocks.slotTweaker.show).toHaveBeenCalled();
	});

	it('Fills recovery slot using recovery helper', function () {
		mocks.instantGlobals.wgAdDriverTaboolaConfig.NATIVE_TABOOLA_RAIL = {
			recovery: ['CURRENT'],
			regular: []
		};
		spyOn(mocks.abTest, 'getGroup').and.returnValue('YES');
		spyOn(mocks.recoveryHelper, 'addOnBlockingCallback');
		var taboola = getTaboola();

		taboola.canHandleSlot('NATIVE_TABOOLA_RAIL');
		taboola.fillInSlot('NATIVE_TABOOLA_RAIL', mocks.document.node, noop);

		expect(mocks.recoveryHelper.addOnBlockingCallback).toHaveBeenCalled();
	});
});
