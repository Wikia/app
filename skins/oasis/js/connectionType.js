(function (window) {
    'use strict';

    window.Wikia = window.Wikia || {};

    var connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;

    Wikia.getConnectionType = function () {
        return connection.effectiveType;
    };

    if (Wikia.getConnectionType()) {
        Wikia.Tracker.track({
            action: Wikia.Tracker.ACTIONS.VIEW,
            category: 'connection-type',
            label: Wikia.getConnectionType(),
            trackingMethod: 'analytics'
        });
    }
})(window);