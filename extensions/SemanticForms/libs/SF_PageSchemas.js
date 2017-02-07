jQuery.fn.toggleFormDataDisplay = function() {
	if ( jQuery( this ).is( ":checked" ) ) {
		jQuery('#sf-page-name-formula').css('display', 'none');
		jQuery('#sf-edit-title').css('display', 'block');
	} else {
		jQuery('#sf-page-name-formula').css('display', 'block');
		jQuery('#sf-edit-title').css('display', 'none');
	}
	return this;
};

jQuery( document ).ready( function () {
	jQuery('#sf-two-step-process')
		.toggleFormDataDisplay()
		.click( function() {
			jQuery(this).toggleFormDataDisplay();
		} );
} );
