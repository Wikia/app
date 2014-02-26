/*exported AdProviderRemnantDart*/
var AdProviderRemnantDart = function ( adTracker, log, slotTweaker, wikiaGpt, adSlotMapConfig) {
    'use strict';

    var logGroup = 'AdProviderRemnantDart',
        srcName = 'rh',
	    slotMap = adSlotMapConfig.getConfig(srcName);

    function canHandleSlot( slotname ) {

        if ( !slotMap[slotname] ) {
            return false;
        }

        return true;
    }

    function fillInSlot( slotname, success ) {

        log( ['fillInSlot', slotname], 5, logGroup );

        var slotTracker = adTracker.trackSlot( 'addriver2', slotname );

        slotTracker.init();

        wikiaGpt.pushAd(
            slotname,
            function () { // Success
                slotTweaker.removeDefaultHeight( slotname );
                slotTweaker.removeTopButtonIfNeeded( slotname );
                slotTweaker.adjustLeaderboardSize( slotname );

                success();
            },
            function () { // Hop
                log( slotname + ' was not filled by DART', 'info', logGroup );

                slotTweaker.hide( slotname );
                slotTweaker.hideSelfServeUrl( slotname );

                success();
            },
            srcName
        );

        wikiaGpt.flushAds();
    }

    return {
        name: 'RemnantDart',
        canHandleSlot: canHandleSlot,
        fillInSlot: fillInSlot
    };
};
