define('chat-ban-modal', function () {
	'use strict';

	return {
		open: function (title, okCallback, options) {
			var data = {};

			if (options) {
				data = {
					userId: options.userId || ''
				};
			}

			// TODO: Remove isChangeBan - back end will check for this
			$.get(window.wgScript + '?action=ajax&rs=ChatAjax&method=BanModal', data, function (data) {
				require(['wikia.ui.factory'], function (uiFactory) {
					uiFactory.init(['modal']).then(function (uiModal) {
						var banModalConfig = {
							type: 'default',
							vars: {
								id: 'ChatBanModal',
								size: 'small',
								content: data.template,
								title: title,
								buttons: [
									{
										vars: {
											value: data.isChangeBan ?
												$.msg('chat-ban-modal-button-change-ban') :
												$.msg('chat-ban-modal-button-ok'),
											classes: ['normal', 'primary'],
											data: [
												{
													key: 'event',
													value: 'ok'
												}
											]
										}
									},
									{
										'vars': {
											'value': $.msg('chat-ban-modal-button-cancel'),
											data: [
												{
													key: 'event',
													value: 'close'
												}
											]
										}

									}
								]
							}
						};

						uiModal.createComponent(banModalConfig, function (banModal) {

							var reasonInput = banModal.$element.find('input[name=reason]');

							function banUser() {
								var reason = reasonInput.val(),
									expires = banModal.$element.find('select[name=expires]').val();

								okCallback(expires, reason);

								banModal.trigger('close');
							}

							reasonInput.placeholder().keydown(function (e) {
								if (e.which === 13) {
									// Submit when 'enter' key is pressed (BugId:28101).
									e.preventDefault();
									banUser();
								}
							});

							banModal.bind('ok', function (event) {
								event.preventDefault();
								banUser();
							});

							banModal.show();
						});
					});
				});
			});
		}
	};
});
