define('ext.wikia.recirculation.helpers.recommendationBlacklist', [
    'wikia.cache',
    'wikia.window',
    'wikia.cookies'
], function (cache, window, cookies) {
    'use strict';

    var CACHE_KEY = 'recommendations_blacklist';
    var CURRENT_SESSION_KEY = cookies.get('wikia_session_id');
    var cachedItems;

    function get() {
        if (cachedItems) {
            return cachedItems;
        }

        var cachedData = cache.get(CACHE_KEY);

        cachedItems = cachedData ? cachedData[CURRENT_SESSION_KEY] : [];

        return cachedItems;
    }

    function cacheItems(items) {
        var objToSave = {};

        objToSave[CURRENT_SESSION_KEY] = items;

        cache.set(CACHE_KEY, objToSave);
    }

    /**
     * @param itemId String - created like `wikiId_articleId`
     */
    function update(itemId) {
        cacheItems(get().concat(itemId));
    }

    function remove(itemCount) {
        cacheItems(get().slice(itemCount));
    }

    function clear() {
        var items = get();

        if (!items) {
            cache.del(CACHE_KEY);
        }
    }

    clear();

    return {
        get: get,
        update: update,
        clear: clear,
        remove: remove,
    };
});
