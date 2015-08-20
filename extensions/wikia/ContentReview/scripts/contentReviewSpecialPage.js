/**
 * Created by mariusz on 20.08.15.
 */
define(
    'ext.wikia.contentReview.special.page',
    ['jquery', 'mw', 'wikia.loader', 'wikia.nirvana'],
    function ($, mw, loader, nirvana) {

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
            var data = {
                wikiId: $(this).attr("data-wiki-id"),
                pageId: $(this).attr("data-page-id"),
                status: '2'
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
