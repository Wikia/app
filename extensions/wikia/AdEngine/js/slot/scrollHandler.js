/*global define*/
define('ext.wikia.adEngine.slot.scrollHandler', [
    'ext.wikia.adEngine.adContext',
    'ext.wikia.adEngine.adHelper',
    'wikia.log',
    'wikia.document',
    'wikia.window'
], function (adContext, adHelper, log, doc, win) {
    'use strict';

    var logGroup = 'ext.wikia.adEngine.slot.scrollHandler',
        isRefreshed = {},
        reloadedView = {},
        config = {
            PREFOOTER_LEFT_BOXAD: { rv_max: 1 },
            PREFOOTER_RIGHT_BOXAD: { rv_max: 3 }
        };

    function init() {
        for (var slotName in config) {
            if (config.hasOwnProperty(slotName)) {
                isRefreshed[slotName] = false;
                reloadedView[slotName] = 0;
            }
        }
        if (adContext.getContext().opts.enableScrollHandler) {
            win.addEventListener('scroll', adHelper.throttle(function () {
                log('Scroll event listener has been added', 'debug', logGroup);
                for (var slotName in config) {
                    if (config.hasOwnProperty(slotName)) {
                        if (config[slotName].hasOwnProperty('rv_max') &&
                            config[slotName].rv_max >= 0 &&
                            config[slotName].rv_max <= reloadedView[slotName]) {
                            continue;
                        }
                        refreshSlot(slotName);
                    }
                }
            }));
        }
    }

    function refreshSlot(slotName) {
        var status = isReached(doc.getElementById(slotName));
        if (!isRefreshed[slotName] && status) {
            log(['refreshSlot', slotName + ' has been refreshed'], 'debug', logGroup);
            reloadedView[slotName]++;
            win.adslots2.push(slotName);
            isRefreshed[slotName] = true;
        } else if (!status) {
            isRefreshed[slotName] = false;
        }
    }

    function isReached(el) {
        return win.innerHeight + win.scrollY >= getTopPos(el);
    }

    function getTopPos(el) {
        for (var topPos = 0; el != null; topPos += el.offsetTop, el = el.offsetParent);
        return topPos;
    }

    function getReloadedViewCount(slotName) {
        if (reloadedView.hasOwnProperty(slotName)) {
            return reloadedView[slotName];
        }

        return null;
    }

    return {
        init: init,
        getReloadedViewCount: getReloadedViewCount
    };
});
