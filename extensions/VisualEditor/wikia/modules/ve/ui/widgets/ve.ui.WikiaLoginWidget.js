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
						onAuthSuccess: function () {
							this.emit( 'logInSuccess' )
						}.bind( this )
					} );
				}.bind( this ) )
		);

	return this.$anonWarning;
};

ve.ui.WikiaLoginWidget.prototype.removeAnonWarning = function () {
	if ( this.$anonWarning ) {
		this.$anonWarning.remove();
		this.$anonWarning = null;
	}
};
