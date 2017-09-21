ve.ui.WikiaAnonWarningWidget = function VeUiWikiaAnonWarningWidget() {
	ve.ui.WikiaAnonWarningWidget.super.call( this );
};

OO.inheritClass( ve.ui.WikiaAnonWarningWidget, OO.ui.Widget );

ve.ui.WikiaAnonWarningWidget.prototype.setupAnonWarning = function (predecessor ) {
	if ( mw.user.anonymous() ) {
		this.getAnonWarning().insertAfter( predecessor.$element );
	}
};

ve.ui.WikiaAnonWarningWidget.prototype.getAnonWarning = function () {
	var loginLink = this.$( '<a>' )
			.addClass('ve-ui-wikia-anon-warning__login-link')
			.text( ve.msg( 'wikia-visualeditor-anon-log-in' ) ),
		registerLink = this.$( '<a>' )
			.addClass('ve-ui-wikia-anon-warning__register-link')
			.text( ve.msg( 'wikia-visualeditor-anon-register' ) );

	this.$anonWarning = this.$( '<div>' )
		.addClass( 've-ui-wikia-anon-warning' )
		.html( ve.msg(
			'wikia-visualeditor-anon-warning',
			loginLink.get(0).outerHTML,
			registerLink.get(0).outerHTML
		) );

	this.$anonWarning.find('.ve-ui-wikia-anon-warning__login-link')
		.on( 'click', function () {
			window.wikiaAuthModal.load( {
				url: '/signin?redirect=' + encodeURIComponent(window.location.href),
				onAuthSuccess: this.emit.bind(this, 'logInSuccess')
			} );
		}.bind( this ) );
	this.$anonWarning.find('.ve-ui-wikia-anon-warning__register-link')
		.on( 'click', function () {
			window.wikiaAuthModal.load( {
				onAuthSuccess: this.emit.bind(this, 'logInSuccess')
			} );
		}.bind( this ) );

	return this.$anonWarning;
};

ve.ui.WikiaAnonWarningWidget.prototype.removeAnonWarning = function () {
	if ( this.$anonWarning ) {
		this.$anonWarning.remove();
		this.$anonWarning = null;
	}
};
