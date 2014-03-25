(function ( window, $ ) {
	'use strict';

	var $window = $( window ),
		scroll = 'scroll.SharingToolbar',
		Wikia = window.Wikia || {},

		SharingToolbar = {
			buttonHeight: 0,
			init: function ( options ) {
				this.$button = options.button;
				this.$toolbar = options.toolbar;
				this.buttonHeight = this.$button.height();

				// Bind events
				this.$button.bind( 'click', $.proxy( this.toggleToolbar, this ) );
				this.$toolbar.find( '.email-link' ).bind( 'click', this.onEmailClick );
			},
			onScroll: function () {
				var fixed = $window.scrollTop() >= this.$button.offset().top - this.buttonHeight;
				this.$toolbar.toggleClass( 'fixed', fixed );
			},
			onEmailClick: function ( event ) {
				event.preventDefault();

				var node = $( this ),
					shareEmailLabel = node.attr( 'data-lightboxShareEmailLabel' ),
					sendLabel = node.attr( 'data-lightboxSend' ),
					shareEmailLabelAddress = node.attr( 'data-lightboxShareEmailLabelAddress' ),
					cancelLabel = node.attr( 'data-lightboxcancel' ),
					showEmailModal = function () {
						SharingToolbar.showEmailModal( shareEmailLabel, sendLabel, shareEmailLabelAddress,
							cancelLabel );
					},
					UserLoginModal = window.UserLoginModal;

				if ( window.wgUserName === null ) {
					if ( window.wgComboAjaxLogin ) {
						showComboAjaxForPlaceHolder( false, false, function () {
							window.AjaxLogin.doSuccess = function () {
								$( '#AjaxLoginBoxWrapper' ).closest( '.modalWrapper' ).closeModal();
								showEmailModal();
							};
							window.AjaxLogin.close = function () {
								$( '#AjaxLoginBoxWrapper' ).closeModal();
							};
						}, false, true );
					} else {
						UserLoginModal.show( {
							origin: 'sharing-toolbar',
							callback: function () {
								window.UserLogin.forceLoggedIn = true;
								showEmailModal();
							}
						} );
					}
					return false;
				}
				else {
					showEmailModal();
				}
			},
			showEmailModal: function ( labelShareEmail, labelSend, labelShareEmailAddress, labelCancel ) {
				require( [ 'wikia.ui.factory' ], function ( uiFactory ) {
					uiFactory.init( [ 'modal' ] ).then( function ( uiModal ) {
							var modalTemplate = '<label>{{label}}<br/>' +
									'<input type="text" id="lightbox-share-email-text" /></label>',
								modalContent = window.Mustache.to_html( modalTemplate,
									{ label: labelShareEmailAddress} ),
								shareEmailModalConfig = {
									vars: {
										id: 'ShareEmailModal',
										size: 'small',
										content: modalContent,
										title: labelShareEmail,
										buttons: [
											{
												vars: {
													value: labelCancel,
													data: [
														{
															key: 'event',
															value: 'close'
														}
													]
												}
											},
											{
												vars: {
													value: labelSend,
													classes: [ 'normal', 'primary' ],
													data: [
														{
															key: 'event',
															value: 'send'
														}
													]
												}
											}
										]
									}
								};

						uiModal.createComponent( shareEmailModalConfig, function ( shareEmailModal ) {
							shareEmailModal.bind( 'send', function ( event ) {
								event.preventDefault();

								$.nirvana.sendRequest( {
									controller: 'SharingToolbarController',
									method: 'sendMail',
									format: 'json',
									data: {
										pageName: window.wgPageName,
										addresses: $( '#lightbox-share-email-text' ).val(),
										messageId: 1
									},
									callback: function ( data ) {
										var result = data.result,
											afterShareModalConfig = {
												vars: {
													id: 'AfterShareEmailModal',
													size: 'small',
													content: result[ 'info-content' ],
													title: result[ 'info-caption' ]
												}
											};

										uiModal.createComponent( afterShareModalConfig,
											function ( afterShareEmailModal ) {
												afterShareEmailModal.bind( 'close', function ( event ) {
													event.preventDefault();

													if ( result.success ) {
														window.UserLogin.refreshIfAfterForceLogin();
													}
												} );
												afterShareEmailModal.show();
											} );

										// close email modal when share is successful (BugId:16061)
										if ( result.success ) {
											shareEmailModal.trigger( 'close' );

											window.UserLogin.refreshIfAfterForceLogin();
										}
									}
								} );
							} );

							shareEmailModal.bind( 'close', function () {
								window.UserLogin.refreshIfAfterForceLogin();
							} );

							shareEmailModal.show();
						} );
					} );
				} );
			},
			checkWidth: function () {
				var maxWidth = 0,
					nodes = this.$toolbar.children();

				$.each( nodes, function ( key, value ) {
					var node = $( value ),
						elementWidth = Math.max( node.outerWidth(), node.children().outerWidth() );

					maxWidth = Math.max( elementWidth, maxWidth );
				} );

				this.$toolbar.css( 'width', maxWidth );
			},
			toggleToolbar: function ( event ) {
				var show = this.$toolbar.hasClass( 'loading' );

				event.preventDefault();

				if ( show ) {
					this.$toolbar.removeClass( 'loading' );

				} else {
					show = this.$toolbar.hasClass( 'hidden' );
				}

				this.$button.toggleClass( 'share-enabled', show );
				this.$toolbar.toggleClass( 'hidden', !show );

				if ( show ) {
					$window.on( scroll, $.proxy( this.onScroll, this ) );

				} else {
					this.checkWidth();
					$window.off( scroll );
				}
			}
		};

// Exports
	Wikia.SharingToolbar = SharingToolbar;
	window.Wikia = Wikia;

})( window, jQuery );
