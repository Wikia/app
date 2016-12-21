ve.ui.WikiaLoginWidget = function VeUiWikiaLoginWidget() {
	ve.ui.WikiaLoginWidget.super.call( this );
};

OO.inheritClass( ve.ui.WikiaLoginWidget, OO.ui.Widget );

ve.ui.WikiaLoginWidget.prototype.setupAnonWarning = function ( predecessor ) {
	if ( mw.user.anonymous() ) {
		this.getAnonWarning().insertAfter( predecessor.$element );
	}
};

ve.ui.WikiaLoginWidget.prototype.getAnonWarning = function () {
	this.$anonWarning = this.$( '<div>' )
		.addClass( 've-ui-wikia-anon-warning' )
		.text( ve.msg( 'wikia-visualeditor-anon-warning' ) )
		.append(
			this.$( '<a>' )
				.text( ve.msg( 'wikia-visualeditor-anon-log-in' ) )
				.on( 'click', function () {
					window.wikiaAuthModal.load( {
						onAuthSuccess: this.onAuthSuccess.bind( this )
					} );
				}.bind( this ) )
		);

	return this.$anonWarning;
};

ve.ui.WikiaLoginWidget.prototype.removeAnonWarning = function () {
	this.$anonWarning.remove();
};

ve.ui.WikiaLoginWidget.prototype.onAuthSuccess = function () {
	var getEditTokenUrl = '/api.php?action=query&prop=info&titles=' +
		window.wgPageName +
		'&intoken=edit&format=json';

	this.removeAnonWarning();

	$.ajax( getEditTokenUrl )
		.done( function ( response ) {
			// wgArticleId returns 0 for new articles but the API returns -1
			var articleId = window.wgArticleId || -1,
				editToken = response.query.pages[articleId].edittoken;

			mw.user.tokens.set( 'editToken', editToken );
			/**
			 * If we want to get the real user name, we would have to make two service calls:
			 * - to whoami for the user id
			 * - to user-attribute for the user name
			 * For now we don't need it, as the page is reloaded anyway after recently logged in user closes the editor.
			 * We just need it to not be empty to make mw.user.anonymous() work as expected.
			 */
			mw.config.set( 'wgUserName', 'FAKE_NAME_VE_LOGGED_IN' );

			// This is used to reload the page after recently logged in user closes the editor
			ve.init.target.userLoggedInDuringEdit = true;
		} );
};
