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
	this.$anonWarning = this.$( '<div>' )
		.addClass( 've-ui-wikia-anon-warning' )
		.text( ve.msg( 'wikia-visualeditor-anon-warning' ) )
		.append(
			this.$( '<a>' )
				.addClass('ve-ui-wikia-anon-warning__login-link')
				.text( ve.msg( 'wikia-visualeditor-anon-log-in' ) )
				.on( 'click', function () {
					window.wikiaAuthModal.load( {
						onAuthSuccess: function () {
							this.emit( 'logInSuccess' );
						}.bind( this )
					} );
				}.bind( this ) )
		);

	return this.$anonWarning;
};

ve.ui.WikiaAnonWarningWidget.prototype.removeAnonWarning = function () {
	if ( this.$anonWarning ) {
		this.$anonWarning.remove();
		this.$anonWarning = null;
	}
};
