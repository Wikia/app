CKEDITOR.plugins.add( 'rte-infobox', {
	init: function( editor ) {

		editor.addCommand( 'addinfobox', {
			exec: function( editor ) {
				console.log("Hello Infobox!");
			}
		});


	}

});
