window.raRecordForms = function () {
	for( i = 0; i < window.forms.length; i++ ) {
		var type = forms[i];
		var form = document.getElementById( type.toLowerCase() + '-form' );
		if( form.onsubmit() === false ) return false;
		var tags = [ 'input', 'select', 'textarea' ];
		for( j = 0; j < tags.length; j++ ) {
			var inputs = form.getElementsByTagName( tags[j] );
			for( k = 0; k < inputs.length; k++ ) {
				var input = jQuery( inputs[k] );
				if( input.attr('type') != 'checkbox' || input.attr('checked') ) {
					var multi = input.val();
					if( typeof( multi ) == 'object' ) multi = multi.join('\n');
					var key = type + ':' + inputs[k].getAttribute('name');
					var hidden = jQuery( document.createElement( 'input' ) );
					hidden.attr( 'name', key );
					hidden.attr( 'type', 'hidden' );
					hidden.val( multi );
					jQuery( '#editform' ).append( hidden );
				}
			}
		}
	}
};
jQuery( '#editform' ).submit( raRecordForms );
