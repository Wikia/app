define(
    'ext.wikia.contentReview.special.page',
    ['jquery', 'mw', 'wikia.loader', 'wikia.nirvana', 'BannerNotification'],
    function ($, mw, loader, nirvana, BannerNotification) {
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
            $('.content-review-status-unreviewed').on('click', updateReviewStatus);
        }

        function updateReviewStatus() {
            var $button = $(this),
                notification,
                data = {
                    wikiId: $button.attr('data-wiki-id'),
                    pageId: $button.attr('data-page-id'),
                    status: $button.attr('data-status'),
                    oldStatus: $button.attr('data-old-status'),
                    editToken: mw.user.tokens.get('editToken')
                };

            nirvana.sendRequest({
                controller: 'ContentReviewApiController',
                method: 'updateReviewsStatus',
                data: data,
                callback: function() {
                    notification = new BannerNotification(
                       mw.message('content-review-special-review-started').escaped(),
                        'confirm'
                    );

                    notification.show();
                },
                onErrorCallback: function(response) {
                    var e, errorMsg;
                    if (response.responseText.length > 0) {
                        e = $.parseJSON(response.responseText);
                        if (e.exception.details.length > 0) {
                            errorMsg = e.exception.details;
                        } else {
                            errorMsg = e.exception.message;
                        }
                        notification = new BannerNotification(
                            mw.message('content-review-special-error', errorMsg).escaped(),
                            'error'
                        );

                        notification.show();
                    }
                }
            });
        }

        return {
            init: init
        };
    });
