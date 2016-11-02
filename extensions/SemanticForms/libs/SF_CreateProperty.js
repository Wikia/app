function toggleDefaultForm( property_type ) {
	var default_form_div = document.getElementById("default_form_div");
	if ( property_type === mediaWiki.config.get( 'wgPageTypeLabel' ) ) {
		default_form_div.style.display = "";
	} else {
		default_form_div.style.display = "none";
	}
}

function toggleAllowedValues( property_type ) {
	var allowed_values_div = document.getElementById("allowed_values");
	// Page, String (or Text, for SMW 1.9+), Number, Email - is that a
	// reasonable set of types for which enumerations should be allowed?
	if ( property_type === mediaWiki.config.get( 'wgPageTypeLabel' ) ||
		property_type === mediaWiki.config.get( 'wgStringTypeLabel' ) ||
		property_type === mediaWiki.config.get( 'wgNumberTypeLabel' ) ||
		property_type === mediaWiki.config.get( 'wgEmailTypeLabel' ) ) {
		allowed_values_div.style.display = "";
	} else {
		allowed_values_div.style.display = "none";
	}
}

jQuery( document ).ready( function() {
	jQuery( "#property_dropdown" ).change( function() {
		toggleDefaultForm( this.value );
		toggleAllowedValues( this.value );
	} );
} );
