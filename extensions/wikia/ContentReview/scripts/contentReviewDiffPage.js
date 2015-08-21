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
            $('.content-review-diff-approve').on('click', removeAndUpdateLogs);
            $('.content-review-diff-reject').on('click', removeAndUpdateLogs);
        }

        function removeAndUpdateLogs(e) {
            var self = $(this),
                data = {
                    wikiId: self.attr("data-wiki-id"),
                    pageId: self.attr("data-page-id"),
                    status: self.attr("data-status")
                };
            e.preventDefault();
            nirvana.sendRequest({
                controller: 'ContentReviewApiController',
                method: 'changeRevisionStatus',
                data: data
            });
        }

        return {
            init: init
        };
    });
