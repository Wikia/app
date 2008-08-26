/**
 * The Cookie utility provides methods for reading and setting persistent
 * client-side cookies.
 * See: http://wp.netscape.com/newsref/std/cookie_spec.html
 *
 * @module cookie
 * @namespace YAHOO.util
 * @requires yahoo
 */

YAHOO.util.Cookie = {

    /**
     * Retrieves a cookie value
     *
     * @method get
     * @param {String} name The name of the cookie to retrieve
     * @return {String} The cookie value, or null if none is found
     * @static
     */
    get: function(name) {

        var pattern = new RegExp('(?:^|; )' + escape(name) + '=([^;]*)');
        var match = document.cookie.match(pattern);

        if (match) {
            return unescape(match[1]);
        } else {
            return null;
        }
    },

    /**
     * Writes a cookie with a given name and value
     *
     * @method set
     * @param {Object} attr An object literal containing properties to set
     *                 for this cookie. Valid properties are:
     *                 {String} name (required)
     *                 {String} value
     *                 {Date} expires
     *                 {int} seconds
     *                 {int} minutes
     *                 {int} hours
     *                 {int} days
     *                 {int} weeks
     *                 {int} months
     *                 {int} years
     *                 {String} domain
     *                 {String} path
     *                 {boolean} secure
     *                 Time properties are added to the date specified by
     *                 the expires property, or the current date/time if
     *                 none is supplied.
     * @static
     */
    set: function(attr) {

        if (!attr || typeof attr.name == 'undefined') {
            // cannot proceed without a name
            return;
        }

        var toMillis = function(n, factor) {
            if (isNaN(n)) {
                return 0;
            } else {
                return (n * factor * 1000);
            }
        };

        var name = escape(attr.name);
        var value = '';

        if (attr.value) {
            value = escape(attr.value);
        }

        var cookie = [name + '=' + value];
        var expires;

        if (attr.expires instanceof Date) {
            expires = attr.expires;
        }

        var ms = 0;

        if (attr.seconds) {
            ms += toMillis(attr.seconds, 1);
        }

        if (attr.minutes) {
            ms += toMillis(attr.minutes, 60);
        }

        if (attr.hours) {
            ms += toMillis(attr.hours, 3600);
        }

        if (attr.days) {
            ms += toMillis(attr.days, 86400);
        }

        if (attr.weeks) {
            // 1 week == 7 days
            ms += toMillis(attr.weeks, 604800);
        }

        if (attr.months) {
            // 1 month == 30 days
            ms += toMillis(attr.months, 2592000);
        }

        if (attr.years) {
            // 1 year == 365 days
            ms += toMillis(attr.years, 31536000);
        }

        if (expires || ms != 0) {
            if (!expires) {
                expires = new Date();
            }
            var date = new Date(expires.getTime() + ms);
            cookie.push('expires=' + date.toUTCString());
        }

        if (attr.domain) {
            cookie.push('domain=' + attr.domain);
        }

        if (attr.path) {
            cookie.push('path=' + attr.path);
        }

        if (attr.secure) {
            cookie.push('secure');
        }

        document.cookie = cookie.join('; ');
    }
};
