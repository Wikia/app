define('ext.wikia.recirculation.helpers.cakeRelatedContent', [
    'jquery',
    'wikia.window',
    'wikia.nirvana',
    'ext.wikia.recirculation.utils'
], function($, w, nirvana, utils) {
    var options = {
        limit: 5
    };

    function loadData() {
        var deferred = $.Deferred(),
            articleTitle = w.wgTitle;

        nirvana.sendRequest({
            controller: 'RecirculationApi',
            method: 'getCakeRelatedContent',
            format: 'json',
            type: 'get',
            data: {
                relatedTo: articleTitle,
                ignore: w.location.pathname,
                limit: options.limit
            },
            callback: function(data) {
                if (data.items && data.items.length >= options.limit) {
                    deferred.resolve(formatData(data));
                } else {
                    deferred.reject('Recirculation widget not shown - not enough items returned from CAKE API');
                }
            },
            error: function() {
                deferred.reject('Recirculation widget not shown - error while getting related content from CAKE API');
            }
        });

        return deferred.promise();
    }

    function formatData(data) {
        data.items = data.items.map(function(item) {
            item.title = item.title.replace('| Fandom - Powered by Wikia', '');
            return item;
        }).sort(utils.sortThumbnails);

        return data;
    }

    return function(config) {
        $.extend(options, config);
        return {
            loadData: loadData
        }
    }
});
