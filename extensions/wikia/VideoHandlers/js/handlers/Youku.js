define('wikia.videohandler.youku', function() {
    'use strict';

    /**
     * Set up Youku player
     * @param {Object} params Player params sent from the video handler
     * @param {Constructor} vb Instance of video player
     */
    return function(params, vb) {
        var player = new YKU.Player('youkuplayer',{
            styleid: '0',
            client_id: params.client_id,
            vid: params.vid,
            autoplay: params.autoplay
        });
    };
});