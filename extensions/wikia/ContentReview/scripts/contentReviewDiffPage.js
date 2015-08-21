define(
    'ext.wikia.contentReview.diff.page',
    ['jquery', 'mw', 'wikia.loader', 'wikia.nirvana'],
    function ($, mw, loader, nirvana) {
        /**
         * TODO add messages
         */
        function init() {
            $.when(loader({
                type: loader.MULTI,
                resources: {
                    messages: 'ContentReviewDiffPage'
                }
            })).done(function (res) {
                mw.messages.set(res.messages);
                bindEvents();
            });

        }

        function bindEvents() {
            $('.content-review-diff-approve').on('click', updateReviewStatus);
            $('.content-review-diff-reject').on('click', updateReviewStatus);
        }

        function updateReviewStatus() {
            var self = $(this);
            var data = {
                wikiId: self.attr("data-wiki-id"),
                pageId: self.attr("data-page-id"),
                status: self.attr("data-status")
            };
            console.log(data);
            nirvana.sendRequest({
                controller: 'ContentReviewApiController',
                method: '',
                data: data
            });
        }

        return {
            init: init
        };
    });
