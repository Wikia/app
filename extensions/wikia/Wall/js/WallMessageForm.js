(function( window, $ ) {
	'use strict';

	Wall.MessageForm = $.createClass( Observable, {
		constructor: function( page, model ) {
			Wall.MessageForm.superclass.constructor.apply( this,arguments );
			this.model = model;
			this.page = page;
			this.wall = $( '#Wall' );
		},

		showPreviewModal: function( format, metatitle, body, width, publishCallback ) {
			require( [ 'wikia.ui.factory' ], function( uiFactory ) {
				uiFactory.init( [ 'modal' ] ).then( function( uiModal ) {
					var previewModalConfig = {
							vars: {
								id: 'WallPreviewModal',
								size: 'medium',
								content: '<div class="WallPreview"><div class="WikiaArticle"></div></div>',
								title: $.msg( 'preview' ),
								buttons: [
									{
										vars: {
											value: $.msg( 'savearticle' ),
											classes: [ 'normal', 'primary' ],
											data: [
												{
													key: 'event',
													value: 'publish'
												}
											]
										}
									},
									{
										vars: {
											value: $.msg( 'back' ),
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

					uiModal.createComponent( previewModalConfig, function( previewModal ) {

						previewModal.bind( 'publish', function() {
							previewModal.trigger( 'close' );
							publishCallback();
						});

						previewModal.show();
						previewModal.deactivate();

						$.nirvana.sendRequest({
							controller: 'WallExternalController',
							method: 'preview',
							format: 'json',
							data: {
								convertToFormat: format,
								metatitle: metatitle,
								body: body
							},
							callback: function( data ) {
								previewModal.$content.find( '.WallPreview .WikiaArticle' ).html( data.body );
								previewModal.activate();
							}
						});
					});
				});
			});

			return false;
		},

		getMessageWidth: function( msg ) {
			return msg.find( '.editarea' ).width();
		},

		loginBeforeSubmit: function( action ) {

			var UserLoginModal = window.UserLoginModal;

			if( window.wgDisableAnonymousEditing  && !window.wgUserName ) {
				UserLoginModal.show( {
					origin: 'wall-and-forum',
					callback: this.proxy( function() {
						action( false );
						return true;
					} )
				} );
			} else {
				action( true );
				return true;
			}
		},

		reloadAfterLogin: function() {
			UserLoginAjaxForm.prototype.reloadPage();
		},

		getFormat: function() {
			// gets overriden if MiniEditor is enabled
			return '';
		},

		proxy: function( func ) {
			return $.proxy( func, this );
		}
	});

})( window, jQuery );
