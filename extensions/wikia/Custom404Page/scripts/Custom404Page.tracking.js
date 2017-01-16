require([
    'jquery',
    'wikia.tracker'
], function ($, tracker) {
    'use strict';

    var track = tracker.buildTrackingFunction({
        action: tracker.ACTIONS.CLICK,
        category: 'custom-404-page',
        trackingMethod: 'analytics'
    });

    $(function () {
        track({
            action: tracker.ACTIONS.IMPRESSION,
            label: 'alternative-suggestion-present'
        });

        $('.noarticletext').on('click', '.alternative-suggestion', function(event) {
            track({
                action: tracker.ACTIONS.CLICK,
                label: $(event.target).closest('.alternative-suggestion').data('type')
            });
        });
    });
});
