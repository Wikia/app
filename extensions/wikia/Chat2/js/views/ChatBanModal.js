var ChatBanModal = function(title, okCallback, options) {
	var self = this,
		data = {};

	if (options) {
		data = {
			userId: options.userId || ""
		}
	}

	// TODO: Remove isChangeBan - back end will check for this
	$.get( wgScript + '?action=ajax&rs=ChatAjax&method=BanModal', data, function( data ) {
		require( [ 'wikia.ui.factory' ], function( uiFactory ) {
			uiFactory.init( 'button' ).then( function( uiButton ) {
				var primaryBtnMsg = data.isChangeBan ? $.msg('chat-ban-modal-button-change-ban') : $.msg('chat-ban-modal-button-ok'),
					modalPrimaryBtn = uiButton.render( {
						"type": "link",
						"vars": {
							"id": "ok",
							"href": "#",
							"classes": [ "normal", "primary" ],
							"value": primaryBtnMsg,
							"title": primaryBtnMsg
						}
					} ),
					secondaryBtnMsg = $.msg( 'chat-ban-modal-button-cancel' ),
					modalSecondaryBtn = uiButton.render( {
						"type": "link",
						"vars": {
							"id": "cancel",
							"href": "#",
							"classes": [ "normal", "secondary" ],
							"value": secondaryBtnMsg,
							"title": secondaryBtnMsg
						}
					} );

				uiFactory.init( 'modal' ).then( function( uiModal ) {
					var modalId = "ChatBanModal";
					require( [ 'wikia.ui.modal' ], function( modal ) {
						var banModal = uiModal.render( {
							type: "default",
							vars: {
								"id": modalId,
								"size": 'small',
								"content": data.template,
								"title": title,
								"closeButton": true,
								"closeText": $.msg( "close" ),
								"primaryBtn": modalPrimaryBtn,
								"secondBtn": modalSecondaryBtn
							}
						} );

						banModal = modal.init( modalId, banModal );
						banModal.show();
					} );
				} );
			} );
		} );
		/*
		TODO: remove code below once DAR-2415 is finished
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
		*/
	} );
};
