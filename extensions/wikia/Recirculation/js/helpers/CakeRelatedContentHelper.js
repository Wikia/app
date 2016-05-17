define('ext.wikia.recirculation.helpers.cakeRelatedContent', [
    'jquery',
    'wikia.nirvana'
], function($, nirvana) {
    var options = {
        limit: 3
    };

    function loadData() {
        var deferred = $.Deferred();

        nirvana.sendRequest({
            controller: 'RecirculationApi',
            method: 'getCakeRelatedContent',
            format: 'json',
            type: 'get',
            data: {
                relatedTo: ""
            },
            callback: function(data) {
                data = formatData(data);
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

    function formatData(data) {
        return data;
    }

    return function(config) {
        $.extend(options, config);
        return {
            loadData: loadData
        }
    }
});
