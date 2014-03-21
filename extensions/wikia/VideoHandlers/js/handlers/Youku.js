/**
 * NOTE: This file currently isn't being used, we're embedding videos with iframes for the
 * time being. The plan is to switch over to the javascript player in the future so we can
 * more accurately track playing events. We can use this file when we do make that switch.
 */
define('wikia.videohandler.youku', function() {
    'use strict';

    /**
     * Set up Youku player
     * @param {Object} params Player params sent from the video handler
     * @param {Constructor} vb Instance of video player
     */
    return function(params, vb) {
        var player = new YKU.Player('youkuplayer',{
            styleid: params.playerColor,
            client_id: params.client_id,
            vid: params.vid,
            autoplay: params.autoplay
        });
    };
});