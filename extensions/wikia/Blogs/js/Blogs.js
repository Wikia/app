YAHOO.namespace("Wikia.Blogs");

YAHOO.Wikia.Blogs.callback = {
    success: function( oResponse ) {
		if (typeof YAHOO.lang.JSON != "undefined" ) {
			var data = YAHOO.lang.JSON.parse( oResponse.responseText )
		}
		else {
			var data = YAHOO.Tools.JSONParse( oResponse.responseText );
		}
		YAHOO.Wikia.Blogs.callback.add( data );
    },
    failure: function( oResponse ) {
    },
    timeout: 5000000
};

YAHOO.Wikia.Blogs.hideCallback = {
    success: function( oResponse ) {
		if (typeof YAHOO.lang.JSON != "undefined" ) {
			var data = YAHOO.lang.JSON.parse( oResponse.responseText )
		}
		else {
			var data = YAHOO.Tools.JSONParse( oResponse.responseText );
		}
		YAHOO.Wikia.Blogs.callback.toggle( data );
    },
    failure: function( oResponse ) {
    },
    timeout: 5000000
};

YAHOO.Wikia.Blogs.callback.toggle = function( data ) {
	if( ! data[ "error" ] ) {
		YAHOO.util.Dom.get( "comm-" + data["id"]).innerHTML = data["text"];

		/**
		 * connect signals
		 */
		YAHOO.Wikia.Blogs.actions = YAHOO.util.Dom.get( data[ "id" ] );
		YAHOO.util.Event.addListener( YAHOO.Wikia.Blogs.actions, "click", YAHOO.Wikia.Blogs.toggle );
		document.body.style.cursor = "default";

		if (typeof TieDivLibrary != "undefined" ) {
			TieDivLibrary.calculate();
		}
	}
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
		YAHOO.util.Dom.get("blog-comm-bottom-info").innerHTML = "&nbsp;";
	}
	else {
		YAHOO.util.Dom.get("blog-comm-bottom-info").innerHTML = data[ "msg" ];
	}
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
		YAHOO.util.Connect.asyncRequest( "POST", wgServer + wgScript + "?action=ajax&rs=BlogComment::axPost&article=" + wgArticleId, YAHOO.Wikia.Blogs.callback );
	}
};

YAHOO.Wikia.Blogs.toggle = function( event ) {
	YAHOO.util.Event.preventDefault( event );
	document.body.style.cursor = "wait";
	YAHOO.util.Connect.asyncRequest( "GET", wgServer + wgScript + "?action=ajax&rs=BlogComment::axToggle&id=" + event.target.id + "&article=" + wgArticleId, YAHOO.Wikia.Blogs.hideCallback );
};

YAHOO.util.Event.addListener( "blog-comm-submit-top", "click", YAHOO.Wikia.Blogs.submit, "blog-comm-form-top" );
YAHOO.util.Event.addListener( "blog-comm-submit-bottom", "click", YAHOO.Wikia.Blogs.submit, "blog-comm-form-bottom" );
YAHOO.util.Event.addListener( "blog-comm-form-select", "change", YAHOO.Wikia.Blogs.submit, "blog-comm-form-select" );

YAHOO.Wikia.Blogs.actions = YAHOO.util.Dom.getElementsByClassName( "blog-comm-hide", "a" );
YAHOO.util.Event.addListener( YAHOO.Wikia.Blogs.actions, "click", YAHOO.Wikia.Blogs.toggle );
