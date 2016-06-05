/**
 * Bootstrap the app
 */
$(function () {
	'use strict';

	$('.chat-change-ban').click(function (event) {
		var userId = $(this).data('user-id');

		require(['chat-ban-modal'], function (chatBanModal) {
			chatBanModal.open(
				$.msg('chat-ban-modal-change-ban-heading'),
				function (expires, reason) {
					$.post(window.wgScript + '?action=ajax&rs=ChatAjax&method=blockOrBanChat', {
							userToBanId: userId,
							time: expires,
							reason: reason,
							mode: 'global',
							token: mw.user.tokens.get('editToken')
						},
						function () {
							window.location.reload();
						}
					);
				}, {
					isChangeBan: true,
					userId: userId
				});
		});

		event.preventDefault();
	});
});
