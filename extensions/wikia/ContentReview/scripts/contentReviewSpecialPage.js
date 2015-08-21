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
            $('.content-review-status-unreviewed').on('click', updateReviewStatus);
        }

        function updateReviewStatus() {
            var self = $(this),
                data = {
                    wikiId: self.attr('data-wiki-id'),
                    pageId: self.attr('data-page-id'),
                    status: self.attr('data-status'),
                    editToken: mw.user.tokens.get('editToken')
                };

            nirvana.sendRequest({
                controller: 'ContentReviewApiController',
                method: 'updateReviewsStatus',
                data: data
            });
        }

        return {
            init: init
        };
    });
