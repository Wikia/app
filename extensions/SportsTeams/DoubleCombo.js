var DoubleCombo = {
	addOption: function( id, value, name ) {
		var option = new Option( name, value );
		try {
			document.getElementById( id ).add( option, null );
		} catch ( e ) {
			document.getElementById( id ).add( option, -1 );
		}
	},

	update: function( id, func, args ) {
		// If no arguments were passed, just pass an empty array; originally this
		// function did not allow custom arguments to be passed
		if ( !args ) {
			args = [];
		}
		sajax_do_call( func, args, function( originalRequest ) {
			if( originalRequest.responseText ) {
				var opts = '';
				document.getElementById( id ).options.length = 0;
				opts = eval( '(' + originalRequest.responseText + ')' );

				DoubleCombo.addOption( id, 0, '-' );
				for( var x = 0; x <= opts.options.length - 1; x++ ) {
					DoubleCombo.addOption(
						id,
						opts.options[x].id,
						opts.options[x].name
					);
				}
			} else {
				alert( 'Error in DoubleCombo.js, DoubleCombo.update: AJAX request returned no data?!' );
			}
		} );
	}
};