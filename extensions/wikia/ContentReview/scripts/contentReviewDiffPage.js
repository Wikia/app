define(
    'ext.wikia.contentReview.diff.page',
    ['jquery', 'mw', 'wikia.loader', 'wikia.nirvana'],
    function ($, mw, loader, nirvana) {

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
            $('.content-review-diff-button').on('click', removeCompletedAndUpdateLogs);
        }

        function removeCompletedAndUpdateLogs(e) {
            var self = $(this),
                data = {
                    wikiId: self.attr("data-wiki-id"),
                    pageId: self.attr("data-page-id"),
                    status: self.attr("data-status")
                };
            e.preventDefault();
            nirvana.sendRequest({
                controller: 'ContentReviewApiController',
                method: 'removeCompletedAndUpdateLogs',
                data: data,
                callback: function (response) {
                    var notification;
                    if (response.notification) {
                        notification = new BannerNotification(
                            response.notification,
                            'confirm'
                        );
                        notification.show();
                    }
                },
                onErrorCallback: function () {
                    var notification = new BannerNotification(
                        mw.message('content-review-diff-page-error').escaped(),
                        'error'
                    );
                    notification.show();
                }
            });
        }

        return {
            init: init
        };
    });
