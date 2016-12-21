
ve.ui.WikiaLoginWidget = function VeUiWikiaLoginWidget() {
	ve.ui.WikiaLoginWidget.super.call(this);
};

OO.inheritClass( ve.ui.WikiaLoginWidget, OO.ui.Widget );

ve.ui.WikiaLoginWidget.prototype.getAnonWarning = function () {
	if (!this.$anonWarning) {
		this.$anonWarning = this.$('<div>')
			.addClass('ve-ui-wikia-anon-warning')
			.text(ve.msg('wikia-visualeditor-anon-warning'))
			.append(
				this.$('<a>')
					.text(ve.msg('wikia-visualeditor-anon-log-in'))
					.on('click', function () {
						window.wikiaAuthModal.load({
							forceLogin: true,
							onAuthSuccess: this.onAuthSuccess.bind(this)
						});
					}.bind(this))
			);
	}
	return this.$anonWarning;
};

ve.ui.WikiaLoginWidget.prototype.removeAnonWarning = function () {
	this.$anonWarning.remove();
};

ve.ui.WikiaLoginWidget.prototype.setupAnonWarning = function (predecessor) {
	if ( mw.user.anonymous() ) {
		this.getAnonWarning().insertAfter( predecessor.$element );
	}
};

ve.ui.WikiaLoginWidget.prototype.onAuthSuccess = function () {
	var getEditTokenUrl = '/api.php?action=query&prop=info&titles=' +
		window.wgPageName +
		'&intoken=edit&format=json';

	this.removeAnonWarning();
	$.ajax( getEditTokenUrl )
		.done( function ( response ) {
			var editToken = response.query.pages[window.wgArticleId].edittoken;

			mw.user.tokens.set( 'editToken', editToken );
			// TODO
			// If we want to get the real user name, we need to make two API calls, to whoami and user-attribute service
			// Do we really want to do this? Do we need it for anything?
			mw.config.set( 'wgUserName', 'VE_LOGGED_IN' );
		} );
};