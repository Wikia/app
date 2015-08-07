/*global describe, it, expect, modules, spyOn, beforeEach*/
describe('ext.wikia.adEngine.slot.scrollHandler', function () {
    'use strict';

    function noop() {
        return;
    }

    var mocks = {
            log: noop,
            win: {
                innerHeight: 1000,
                scrollY: 0,
                adslot2: {
                    push: function (slotName) {
                        return slotName
                    }
                },
                addEventListener: function (event, callback) {
                    if (event === 'scroll') {
                        callback()
                    }
                },
            },
            doc: {
                getElementById: function (slotName) {
                    return {
                        offsetTop: 3000,
                        offsetParent: 0
                    };
                }
            }
        };

    beforeEach(function () {
        mocks.win.scrollY = 0;
    });

    function getModule() {
        return modules['ext.wikia.adEngine.slot.scrollHandler'](
            mocks.log,
            mocks.doc,
            mocks.win
        );
    }

    it('Prefooters should be refreshed', function () {
        var slotNames = {}
        spyOn(mocks.win.adslot2, 'push').and.returnValue(slotNames);

        mocks.win.scrollY = 2000;
        getModule().init();
        expect(slotNames).toBe('');
    });

    it('Prefooters should not be refreshed', function () {
        var slotNames = {}
        spyOn(mocks.win.adslot2, 'push').and.returnValue(slotNames);

        mocks.win.scrollY = 1000;
        getModule().init();
        expect(slotNames).toBe('');
    });

});
