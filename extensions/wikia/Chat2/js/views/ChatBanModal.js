var ChatBanModal = function(title, okCallback, options) {
	var self = this,
		data = {};

	if (options) {
		data = {
			userId: options.userId || ""
		}
	}

	// TODO: Remove isChangeBan - back end will check for this
	$.get(wgScript + '?action=ajax&rs=ChatAjax&method=BanModal', data, function(data) {
		$.showCustomModal(title, data.template, {
			id: "ChatBanModal",
			width: 404,
			buttons: [
				{
					id: 'cancel',
					message: $.msg('chat-ban-modal-button-cancel'),
					handler: function(){
						var dialog = $('#ChatBanModal');
						dialog.closeModal();
					}
				},
				{
					id: 'ok',
					defaultButton: true,
					message: data.isChangeBan ? $.msg('chat-ban-modal-button-change-ban') : $.msg('chat-ban-modal-button-ok'),
					handler: function() {
						var reason = self.reasonInput.val(),
							expires = self.expiresInput.val();

						okCallback(expires, reason);

						self.dialog.closeModal();
					}
				}
			],
			callback: function() {
				var dialog, reasonInput, expiresInput;

				self.dialog = dialog = $('#ChatBanModal');
				self.reasonInput = reasonInput = dialog.find("input[name=reason]");
				self.expiresInput = expiresInput = dialog.find("select[name=expires]");
				reasonInput.placeholder().keydown(function(e) {
					// Submit when 'enter' key is pressed (BugId:28101).
					if (e.which == 13) {
						e.preventDefault();
						$('#ok').click();
					}
				});
			}
		});
	});
};
