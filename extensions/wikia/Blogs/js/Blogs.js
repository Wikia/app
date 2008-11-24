YAHOO.namespace("Wikia.Blogs");
YAHOO.util.Event.addListener( "" );

YAHOO.Wikia.Blogs.callback = {
	success: function( response ) {
		console.log( "success");
	},
	failure: function( responde ) {
		console.log( "failure");
	},
	timeout: 50000
};

YAHOO.Wikia.Blogs.submit = function( form ) {

//	console.log( form );
	var oForm = YAHOO.util.Dom.get( "form" );
	YAHOO.util.Connect.setForm( oForm, false );
	YAHOO.util.Connect.asyncRequest( "POST", "/index.php?action=ajax&rs=BlogComments::axPost", YAHOO.Wikia.Blogs.callback );

	return false;
};
