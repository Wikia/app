/*global describe, it, modules, expect, spyOn, beforeEach*/
/*jshint maxlen:200*/
describe('adaptersRegistry', function () {
	'use strict';

    var mocks = null;

    function AdapterMock(name, enabled) {
        this.getName = function () {
            return name;
        };

        this.isEnabled = function () {
            return Boolean(enabled);
        };
    }

    function getModule() {
		return modules['ext.wikia.adEngine.lookup.prebid.adaptersRegistry'](
            mocks.adapters.aol,
            mocks.adapters.appnexus,
            mocks.adapters.appnexusAst,
            mocks.adapters.audienceNetwork,
            mocks.adapters.indexExchange,
            mocks.adapters.openx,
            mocks.adapters.rubicon,
            mocks.adapters.wikia,
            mocks.adapters.veles,
            mocks.win
		);
	}

    beforeEach(function () {
        mocks = {
            adapters: {
                aol: new AdapterMock('aol', true),
                appnexus: new AdapterMock('appnexus', true),
                appnexusAst: new AdapterMock('appnexusAst', true),
                audienceNetwork: new AdapterMock('audienceNetwork', true),
                indexExchange: new AdapterMock('indexExchange', true),
                openx: new AdapterMock('openx', true),
                rubicon: new AdapterMock('rubicon', true),
                wikia: new AdapterMock('wikia', true),
                veles: new AdapterMock('veles', true)
            },
            win: {
                pbjs: {
                    que: [],
                    registerBidAdapter: function () {}
                }
            }
        };
    });

    it('returns a list of adapters', function () {
        var adapters = getModule().getAdapters(),
            expectedAdapters = [
                mocks.adapters.aol,
                mocks.adapters.appnexus,
                mocks.adapters.appnexusAst,
                mocks.adapters.audienceNetwork,
                mocks.adapters.indexExchange,
                mocks.adapters.openx,
                mocks.adapters.rubicon
            ];

        expectedAdapters.forEach(function (adapter) {
            expect(adapters).toContain(adapter);
        });
    });

    it('adds adapters to the list', function () {
        var adaptersRegistry = getModule(),
            adapters = adaptersRegistry.getAdapters(),
            newAdapter = new AdapterMock('newAdapter', true);

        expect(adapters).not.toContain(newAdapter);
        adaptersRegistry.push(newAdapter);
        adapters = adaptersRegistry.getAdapters();
        expect(adapters).toContain(newAdapter);
    });

    it('registers and initializes custom adapters if they\'re enabled', function () {
        var adaptersRegistry = getModule(),
            adapters = adaptersRegistry.getAdapters(),
            customAdapters = [
                mocks.adapters.wikia,
                mocks.adapters.veles
            ];

        spyOn(mocks.win.pbjs, 'registerBidAdapter');

        customAdapters.forEach(function (adapter) {
            expect(adapters).not.toContain(adapter);
        });

        adaptersRegistry.setupCustomAdapters();
        adapters = adaptersRegistry.getAdapters();

        customAdapters.forEach(function (adapter) {
            expect(adapters).toContain(adapter);
        });

        mocks.win.pbjs.que.forEach(function (callback) {
            callback();
        });

        expect(mocks.win.pbjs.registerBidAdapter).toHaveBeenCalled();
    });
});
