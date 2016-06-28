var SpecialDiscussionsLog = (function() {

    var ipCache = {};
    var primaryURL = 'http://ipinfo.io/{IP}/json';
    var fallbackURL = 'https://geoiptool.com/en/?ip={IP}';
    var unknownLocationMsg = 'Click for info';

    registerUniqueIPs();

    for (var ip in ipCache) {
        if (!ipCache.hasOwnProperty(ip)) continue;
        getLocationFromIP(ip);
    }

    function registerUniqueIPs() {
        $('.record').each(function (i, elem) {
            var ip = $(elem).find('.ip').text();

            if (ip in ipCache) {
                ipCache[ip].push($(elem));
            } else {
                ipCache[ip] = [$(elem)];
            }
        });
    }

    function getLocationFromIP(ip) {
        $.getJSON(primaryURL.replace('{IP}', ip), function (data) {
            var locationArr = [],
                locationProps = ['city', 'region', 'country'],
                locationStr;

            for (var i = 0; i < locationProps.length; i++) {
                var prop = locationProps[i];
                if (data.hasOwnProperty(prop) && data[prop].length) {
                    locationArr.push(data[prop]);
                }
            }

            if (locationArr.length > 0) {
                locationStr = locationArr.join(', ');
            } else {
                locationStr = unknownLocationMsg;
            }

            displayLocation(ip, locationStr);
        }).error(function () {
            displayLocation(ip, unknownLocationMsg);
        });
        }

    function displayLocation(ip, locationStr) {
        $.each(ipCache[ip], function (i, elem) {
            elem.find('.location').html('<a href=\'' + fallbackURL.replace('{IP}', ip) + '\' target=\'_blank\'>' + locationStr + '</a>');
        });
    }
})();