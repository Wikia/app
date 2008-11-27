YAHOO.namespace("Wikia.Blogs");


/**
 * so far simply submit of form
 */
YAHOO.Wikia.Blogs.submit = function( event, id ) {
	var oForm = YAHOO.util.Dom.get( id );
	oForm.submit();
};

YAHOO.util.Event.addListener( "blog-comm-submit-top", "click", YAHOO.Wikia.Blogs.submit, "blog-comm-form-top" );
YAHOO.util.Event.addListener( "blog-comm-submit-bottom", "click", YAHOO.Wikia.Blogs.submit, "blog-comm-form-bottom" );
