YAHOO.namespace("Wikia.Blogs");

YAHOO.Wikia.Blogs.callback = {
	success: function( response ) {
		YAHOO.Wikia.Blogs.add( YAHOO.Tools.JSONParse( response.responseText ) );
	},
	failure: function( responde ) {
		answer = YAHOO.Tools.JSONParse( response.responseText );
	},
	timeout: 50000
};

YAHOO.Wikia.Blogs.add = function( answer ) {

//	var elem = document.createElement( "<li>");
//	elem.innerHTML = document.createTextNode( answer[ "text" ] );
	YAHOO.util.Dom.get( "blog-comments-ul" ).appendChild( document.createTextNode( answer[ "text" ] ) );
};

YAHOO.Wikia.Blogs.submit = function( event, id ) {

	YAHOO.util.Event.preventDefault( event );
	var oForm = YAHOO.util.Dom.get( id );
	YAHOO.util.Connect.setForm( oForm, false );
	YAHOO.util.Connect.asyncRequest( "POST", wgServer+wgScriptPath+wgScript+"?action=ajax&rs=BlogComments::axPost&title=" + wgTitle , YAHOO.Wikia.Blogs.callback );
};

YAHOO.util.Event.addListener( "blog-comm-form-top", "submit", YAHOO.Wikia.Blogs.submit, "blog-comm-form-top" );
YAHOO.util.Event.addListener( "blog-comm-form-bottom", "submit", YAHOO.Wikia.Blogs.submit, "blog-comm-form-bottom" );
