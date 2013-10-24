var ChatBanModal = function(title, okCallback, options) {
	'use strict';

	var data = {};

	if (options) {
		data = {
			userId: options.userId || ''
		};
	}

	// TODO: Remove isChangeBan - back end will check for this
	$.get( window.wgScript + '?action=ajax&rs=ChatAjax&method=BanModal', data, function( data ) {
		require( [ 'wikia.ui.factory' ], function( uiFactory ) {
			uiFactory.init( [ 'button', 'modal' ] ).then( function( uiComponents ) {
				var primaryBtnMsg = data.isChangeBan ?
						$.msg('chat-ban-modal-button-change-ban') : $.msg('chat-ban-modal-button-ok'),
					uiButton = uiComponents[0],
					uiModal = uiComponents[1],
					modalPrimaryBtn = uiButton.render( {
						'type': 'link',
						'vars': {
							'id': 'ok',
							'href': '#',
							'classes': [ 'normal', 'primary' ],
							'value': primaryBtnMsg,
							'title': primaryBtnMsg
						}
					} ),
					secondaryBtnMsg = $.msg( 'chat-ban-modal-button-cancel' ),
					modalSecondaryBtn = uiButton.render( {
						'type': 'link',
						'vars': {
							'id': 'cancel',
							'href': '#',
							'classes': [ 'normal', 'secondary' ],
							'value': secondaryBtnMsg,
							'title': secondaryBtnMsg
						}
					}),
					modalId = 'ChatBanModal',
					banModal = uiModal.render( {
						type: 'default',
						vars: {
							id: modalId,
							size: 'small',
							content: data.template,
							title: title,
							closeButton: true,
							closeText: $.msg( 'close' ),
							primaryBtn: modalPrimaryBtn,
							secondBtn: modalSecondaryBtn
						}
					} );

				require( [ 'wikia.ui.modal' ], function( modal ) {
					banModal = modal.init( modalId, banModal );

					banModal.$element.find( '#cancel' ).click( function( event ) {
						event.preventDefault();
						banModal.close();
					} );

					var banModalOkBtn = banModal.$element.find( '#ok'),
						reasonInput = banModal.$element.find( 'input[name=reason]' );

					reasonInput.placeholder().keydown( function( e ) {
						if( e.which === 13 ) {
							// Submit when 'enter' key is pressed (BugId:28101).
							e.preventDefault();
							banModalOkBtn.click();
						}
					} );

					banModalOkBtn.click( function( event ) {
						event.preventDefault();

						var reason = reasonInput.val(),
							expires = banModal.$element.find( 'select[name=expires]' ).val();

						okCallback( expires, reason );

						banModal.close();
					} );

					banModal.show();
				} );
			} );
		} );
	} );
};
