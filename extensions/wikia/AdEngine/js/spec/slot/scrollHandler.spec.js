/*global describe, it, expect, modules, spyOn, beforeEach*/
describe('ext.wikia.adEngine.slot.scrollHandler', function () {
    'use strict';

    function noop() {
        return;
    }

    var mocks = {
            log: noop,
            context: {
                opts: {
                    enableScrollHandler: function () {
                        return true;
                    }
                }
            },
            win: {
                innerHeight: 1000,
                scrollY: 0,
                adslots2: {
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
                        offsetParent: null
                    };
                }
            }
        };

    beforeEach(function () {
        mocks.win.scrollY = 0;
    });

    function getModule() {
        return modules['ext.wikia.adEngine.slot.scrollHandler'](
            mocks.context,
            mocks.log,
            mocks.doc,
            mocks.win
        );
    }

    it('Prefooters should be refreshed', function () {
        spyOn(mocks.win.adslots2, 'push');
        mocks.win.scrollY = 2000;
        getModule().init();
        expect(mocks.win.adslots2.push).toHaveBeenCalled();
    });

    it('Prefooters should not be refreshed', function () {
        spyOn(mocks.win.adslots2, 'push')
        mocks.win.scrollY = 1000;
        getModule().init();
        expect(mocks.win.adslots2.push).not.toHaveBeenCalled();
    });

});
