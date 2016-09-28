jQuery.fn.displayInputParams = function () {
	var inputParamsDiv = this.closest( '.formField' ).find( '.otherInputParams' );
	jQuery.ajax( {
		url: window.location.href +
			'&showinputtypeoptions=' + this.val() +
			'&formfield=' + this.attr('formfieldid'),
		context: document.body,
		success: function ( data ){
			inputParamsDiv.html( data );
		}
	});
};

jQuery(document).ready( function () {
	jQuery( '.inputTypeSelector' ).change( function () {
		jQuery( this ).displayInputParams();
	} );
	jQuery( '#addsection' ).click( function( event ) {
		if( jQuery( '#sectionname' ).val() === '' ) {
			event.preventDefault();
			jQuery( '#section_error' ).remove();
			jQuery( '<div/>' ).append( '<span class="error" id="section_error">' + mediaWiki.msg( 'sf_blank_error' ) + '</span>' ).appendTo( '#sectionerror' );
		}
	} );
} );

jQuery( "input,select" ).keypress( function ( event ) {
	// Don't submit the form if enter is pressed on a text input box or a select.
	return event.keyCode !== 13;
} );
