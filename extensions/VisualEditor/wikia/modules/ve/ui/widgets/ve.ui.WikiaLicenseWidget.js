ve.ui.WikiaLicenseWidget = function VeUiWikiaLicenseWidget() {
	ve.ui.WikiaLicenseWidget.super.call( this );
};

OO.inheritClass( ve.ui.WikiaLicenseWidget, OO.ui.Widget );

ve.ui.WikiaLicenseWidget.prototype.setupLicense = function ( predecessor ) {
	this.getLicense().insertAfter( predecessor );
};

ve.ui.WikiaLicenseWidget.prototype.getLicense = function () {
	if ( !this.$license ) {
		this.$license = this.$('<div>')
			.append(
				this.$( '<p>' ).addClass( 've-ui-wikia-license' )
					.html( ve.init.platform.getParsedMessage( 'copyrightwarning' ) )
					.find( 'a' ).attr( 'target', '_blank' ).end()
			);
	}
	return this.$license;
};

ve.ui.WikiaLicenseWidget.prototype.removeLicense = function () {
	if ( this.$license ) {
		this.$license.remove();
	}
};
