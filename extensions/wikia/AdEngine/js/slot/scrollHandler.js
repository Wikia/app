/*global define*/
define('ext.wikia.adEngine.slot.scrollHandler', [
    'ext.wikia.adEngine.adContext',
    'ext.wikia.adEngine.adHelper',
    'wikia.log',
    'wikia.document',
    'wikia.window'
], function (adContext, adHelper, log, doc, win) {

    var logGroup = 'ext.wikia.adEngine.slot.scrollHandler',
        isRefreshed = {
            PREFOOTER_LEFT_BOXAD: false,
            PREFOOTER_RIGHT_BOXAD: false
        };

    function init() {
        if (adContext.getContext().opts.enableScrollHandler) {
            win.addEventListener('scroll', adHelper.throttle(function () {
                log('Scroll event listener has been added', 'debug', logGroup);
                for (var slotName in isRefreshed) {
                    if (isRefreshed.hasOwnProperty(slotName)) {
                        refreshSlot(slotName);
                    }
                }
            }));
        }
    }

    function refreshSlot(slotName) {
        var status = isReached(doc.getElementById(slotName));
        if (!isRefreshed[slotName] && status) {
            win.adslots2.push(slotName);
            log(['refreshSlot', slotName + ' has been refreshed'], 'debug', logGroup);
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

    return {
        init: init
    };
});
