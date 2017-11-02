(function () {
    'use strict';

    var connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;

    if (connection && connection.effectiveType) {
        Wikia.Tracker.track({
            action: Wikia.Tracker.ACTIONS.VIEW,
            category: 'connection-type',
            label: Wikia.getConnectionType(),
            trackingMethod: 'analytics'
        });
    }
})();
