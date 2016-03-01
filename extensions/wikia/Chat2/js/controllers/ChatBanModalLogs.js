var ChatBanLogController = function() {
    $('.chat-change-ban').click(function(e) {
        e.preventDefault();
		var title = mw.html.escape($.msg('chat-ban-modal-change-ban-heading')),
            userId = $(this).data('user-id'),
			okCallback = function(expires, reason) {
			 	$.post(wgScript + '?action=ajax&rs=ChatAjax&method=blockOrBanChat' ,{
						userToBanId: userId,
						time: expires,
						reason: reason,
						mode: 'global',
						token: mw.user.tokens.get('editToken')
					},
					$.proxy(function(data) {
						window.location.reload();
					})
			 	);
 			};

		var chatBanModal = new ChatBanModal(title, okCallback, {'isChangeBan':true, userId:userId });
    });
}

//
// Bootstrap the app
//
$(function() {
    window.ChatBanLogPage = new ChatBanLogController();
});
