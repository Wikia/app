/**
 * Initialize an instance of InlineCategorizer into mw.page
 */
mw.page.inlineCategorizer = new mw.InlineCategorizer();
jQuery( document ).ready( function(){
	// Separate function for call to prevent jQuery
	// from executing it in the document context.
	mw.page.inlineCategorizer.setup();
} );
