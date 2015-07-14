/*global describe, it, expect, modules, spyOn */
describe('ext.wikia.adEngine.template.modal', function () {
    'use strict';

    function noop() {
    }

    var adsModule = {
            openLightbox: function () {
            }
        },
        mocks = {
            log: noop,
            adContext: {
                getContext: function () {
                    return {
                        targeting: {
                            skin: 'mercury'
                        }
                    }
                }
            },
            iframeWriter: {
                getIframe: function () {
                    return {
                        style: {}
                    }
                }
            },
            win: {
                addEventListener: noop,
                Mercury: {
                    Modules: {
                        Ads: {
                            getInstance: function () {
                                return adsModule
                            }
                        }
                    }
                }
            },
            params: {
                width: 100,
                height: 100,
                scalable: true
            }
        };

    beforeEach(function() {
        mocks.win.innerWidth = 0;
        mocks.win.innerHeight = 0;
    });

    function getModule() {
        return modules['ext.wikia.adEngine.template.modal'](
            mocks.adContext,
            mocks.log,
            mocks.iframeWriter,
            mocks.win
        );
    }

    it('Ad should be scaled by height', function () {
        spyOn(adsModule, 'openLightbox');
        mocks.win.innerWidth = 300;
        mocks.win.innerHeight = 240;
        getModule().show(mocks.params);
        expect(adsModule.openLightbox.calls.mostRecent().args[0].style.transform).toBe('scale(2)');
    });

    it('Ad should be scaled by width', function () {
        spyOn(adsModule, 'openLightbox');
        mocks.win.innerWidth = 300;
        mocks.win.innerHeight = 600;
        getModule().show(mocks.params);
        expect(adsModule.openLightbox.calls.mostRecent().args[0].style.transform).toBe('scale(3)');
    });

});
