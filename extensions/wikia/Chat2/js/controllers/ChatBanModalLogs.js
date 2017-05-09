var ChatBanLogController = function () {
	$('.chat-change-ban').click(function (event) {
		var title = mw.message('chat-ban-modal-change-ban-heading').escaped(),
			userId = $(this).data('user-id'),
			okCallback = function (expires, reason) {
				$.post(wgScript + '?action=ajax&rs=ChatAjax&method=blockOrBanChat', {
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
			},
			chatBanModal = new ChatBanModal(title, okCallback, {'isChangeBan': true, userId: userId});

		event.preventDefault();
	});
};

//
// Bootstrap the app
//
$(function () {
	window.ChatBanLogPage = new ChatBanLogController();
});
