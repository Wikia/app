define(
    'ext.wikia.contentReview.special.page',
    ['jquery', 'mw', 'wikia.loader', 'wikia.nirvana'],
    function ($, mw, loader, nirvana) {
        /**
         * TODO add messages
         */
        function init() {
            $.when(loader({
                type: loader.MULTI,
                resources: {
                    messages: 'ContentReviewSpecialPage'
                }
            })).done(function (res) {
                mw.messages.set(res.messages);
                bindEvents();
            });

        }

        function bindEvents() {
            $('.content-review-diff').on('click', updateReviewStatus);
        }

        function updateReviewStatus() {
            var self = $(this);
            var data = {
                wikiId: self.attr("data-wiki-id"),
                pageId: self.attr("data-page-id"),
                status: self.attr("data-status")
            };
            nirvana.sendRequest({
                controller: 'ContentReviewSpecialController',
                method: 'updateReviewsStatus',
                data: data
            });
        }

        return {
            init: init
        };
    });
