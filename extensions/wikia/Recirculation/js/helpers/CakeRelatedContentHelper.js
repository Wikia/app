define('ext.wikia.recirculation.helpers.cakeRelatedContent', [
    'jquery',
    'wikia.nirvana'
], function($, nirvana) {
    var options = {
        limit: 3
    };

    function loadData() {
        var deferred = $.Deferred(),
            currentArticle = window.location.pathname.replace('_', ' ');

        if (currentArticle.startsWith('/wiki/')) {
            currentArticle =  currentArticle.split('/wiki/')[1];
        }

        nirvana.sendRequest({
            controller: 'RecirculationApi',
            method: 'getCakeRelatedContent',
            format: 'json',
            type: 'get',
            data: {
                relatedTo: currentArticle,
                ignore: window.location.pathname,
                limit: options.limit
            },
            callback: function(data) {
                if (data.items && data.items.length >= options.limit) {
                    deferred.resolve(data)
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

    return function(config) {
        $.extend(options, config);
        return {
            loadData: loadData
        }
    }
});
