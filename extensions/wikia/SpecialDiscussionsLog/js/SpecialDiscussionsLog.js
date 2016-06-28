(function() {

    var ipCache = {};
    var url = 'http://ipinfo.io/{IP}/json';

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
        $.getJSON(url.replace('{IP}', ip), function (data) {
            var locationArr = [],
                locationProps = ['city', 'region', 'country'];

            for (var i = 0; i < locationProps.length; i++) {
                var prop = locationProps[i];
                if (data.hasOwnProperty(prop) && data[prop].length) {
                    locationArr.push(data[prop]);
                }
            }

            if (locationArr.length > 0)
                displayLocation(ip, locationArr.join(', '));
        });
    }

    function displayLocation(ip, locationStr) {
        $.each(ipCache[ip], function (i, elem) {
            elem.find('.location').html(locationStr);
        });
    }

})();