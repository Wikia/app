ve.ui.WikiaUploadWidget = function VeUiWikiaUploadWidget( config ) {
	// Parent constructor
	ve.ui.Widget.call( this, config );

	this.$uploadIcon = this.$$( '<span class="ve-ui-iconedElement-icon ve-ui-icon-upload"></span>' );

	this.$uploadLabel = this.$$( '<span>' + ve.msg( 'visualeditor-wikiauploadwidget-label' ) + '</span>' );

	this.uploadButton = new ve.ui.ButtonWidget( {
		'$$': this.$$,
		'label': ve.msg( 'visualeditor-wikiauploadwidget-button' ),
		'flags': ['constructive']
	} );

	// Initialization
	this.$
		.addClass( 've-ui-wikiaUploadButtonWidget' )
		.append( this.$uploadIcon )
		.append( this.$uploadLabel )
		.append( this.uploadButton.$ )
		.append( '<input type="file">' );
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaUploadWidget, ve.ui.Widget );
