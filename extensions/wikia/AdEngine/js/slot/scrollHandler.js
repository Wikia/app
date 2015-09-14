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
        isRefreshed = {
            PREFOOTER_LEFT_BOXAD: false,
            PREFOOTER_RIGHT_BOXAD: false
        },
        reloadedView = {
            PREFOOTER_LEFT_BOXAD: 0,
            PREFOOTER_RIGHT_BOXAD: 0
        },
        reloadedViewMax = {
            PREFOOTER_LEFT_BOXAD: 1,
            PREFOOTER_RIGHT_BOXAD: 3
        };

    function init() {
        if (adContext.getContext().opts.enableScrollHandler) {
            win.addEventListener('scroll', adHelper.throttle(function () {
                log('Scroll event listener has been added', 'debug', logGroup);
                for (var slotName in isRefreshed) {
                    if (isRefreshed.hasOwnProperty(slotName)) {
                        if (reloadedViewMax.hasOwnProperty(slotName) &&
                            reloadedViewMax[slotName] >= 0 &&
                            reloadedViewMax[slotName] <= reloadedView[slotName]) {
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
