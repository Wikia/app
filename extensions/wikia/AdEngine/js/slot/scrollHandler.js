/*global define*/
define('ext.wikia.adEngine.slot.scrollHandler', [
    'ext.wikia.adEngine.adContext',
    'wikia.log',
    'wikia.document',
    'wikia.window'
], function (adContext, log, doc, win) {

    var logGroup = 'ext.wikia.adEngine.slot.scrollHandler',
        config = {
            PREFOOTER_LEFT_BOXAD: false,
            PREFOOTER_RIGHT_BOXAD: false
        };

    function init() {
        if (adContext.opts.enableScrollHandler) {
            win.addEventListener('scroll', function () {
                log('Scroll event listener has been added', 'debug', logGroup);
                for (var slotName in config) {
                    refreshSlot(slotName);
                }
            });
        }
    }

    function refreshSlot(slotName) {
        var status = isReached(doc.getElementById(slotName));
        if (!config[slotName] && status) {
            win.adslots2.push(slotName);
            log(['refreshSlot', slotName + ' has been refreshed'], 'debug', logGroup);
            config[slotName] = true;
        } else if (!status) {
            config[slotName] = false;
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
