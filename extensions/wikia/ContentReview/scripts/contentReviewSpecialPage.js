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
            var $button = $(this),
                data = {
                    wikiId: $button.attr('data-wiki-id'),
                    pageId: $button.attr('data-page-id'),
                    status: $button.attr('data-status'),
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
