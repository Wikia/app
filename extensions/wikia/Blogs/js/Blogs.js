YAHOO.namespace("Wikia.Blogs");

YAHOO.Wikia.Blogs.callback = {
    success: function( oResponse ) {
        var data = YAHOO.Tools.JSONParse( oResponse.responseText );
		YAHOO.Wikia.Blogs.callback.add( data );
    },
    failure: function( oResponse ) {
    },
    timeout: 500000
};

YAHOO.Wikia.Blogs.callback.add = function( data ) {
	if( ! data[ "error" ] ) {
		// remove zero comments div
		var zero = YAHOO.util.Dom.get("blog-comments-zero");
		if( zero ) {
			zero.innerHTML = "";
		}
		var li = document.createElement( "li" );
		li.innerHTML = data["text"];
		YAHOO.util.Dom.get( "blog-comments-ul" ).appendChild( li );
		document.body.style.cursor = "default";
		var bottom = YAHOO.util.Dom.get( "blog-comm-bottom" );
		if ( bottom ) {
			bottom.readonly = false;
			bottom.value = "";
			bottom.style.cursor = "auto";
		}
		var top = YAHOO.util.Dom.get( "blog-comm-top" );
		if( top ) {
			top.readonly = false;
			top.value = "";
			top.style.cursor = "auto";
		}
		if (typeof TieDivLibrary != "undefined" ) {
			TieDivLibrary.calculate();
		}
	}
};

/**
 * so far simply submit of form
 */
YAHOO.Wikia.Blogs.submit = function( event, id ) {

	var oForm = YAHOO.util.Dom.get( id );

	if( id == "blog-comm-form-select" ) {
		oForm.submit();
	}
	else {
		document.body.style.cursor = "wait";
		var bottom = YAHOO.util.Dom.get( "blog-comm-bottom" );
		if( bottom ) {
			bottom.readonly = true;
			bottom.style.cursor = "wait";
		}
		var top = YAHOO.util.Dom.get( "blog-comm-top" );
		if( top ) {
			top.readonly = true;
			top.style.cursor = "wait";
		}
		YAHOO.util.Event.preventDefault( event );
		YAHOO.util.Connect.setForm( oForm, false );
		YAHOO.util.Connect.asyncRequest( "POST", wgServer + wgScriptPath + wgScript + "?action=ajax&rs=BlogComments::axPost&title=" + wgTitle.replace(" ", "_"), YAHOO.Wikia.Blogs.callback );
	}
};

YAHOO.Wikia.Blogs.mouseover = function( event ) {
	console.log( event );
	var overlay = document.createElement( "span" );
	var div = event.relatedTarget;
	div.style.position = 'relative';

	overlay.className = "avatar-overlay";
	overlay.style.visibility = 'visible';
	overlay.innerHTML = "blabla";
	overlay.id = "blog-avatar-overlay";
	div.appendChild( overlay );
};

YAHOO.Wikia.Blogs.mouseout = function( event ) {
	console.log( event.currentTarget );
};

YAHOO.util.Event.addListener( "blog-comm-submit-top", "click", YAHOO.Wikia.Blogs.submit, "blog-comm-form-top" );
YAHOO.util.Event.addListener( "blog-comm-submit-bottom", "click", YAHOO.Wikia.Blogs.submit, "blog-comm-form-bottom" );
YAHOO.util.Event.addListener( "blog-comm-form-select", "change", YAHOO.Wikia.Blogs.submit, "blog-comm-form-select" );

// dropdown for images
/**
YAHOO.Wikia.Blogs.images = YAHOO.util.Dom.getElementsByClassName( "avatar-self","img" );
YAHOO.util.Event.addListener( YAHOO.Wikia.Blogs.images, "mouseover", YAHOO.Wikia.Blogs.mouseover );
YAHOO.util.Event.addListener( YAHOO.Wikia.Blogs.images, "mouseout", YAHOO.Wikia.Blogs.mouseout );
**/
