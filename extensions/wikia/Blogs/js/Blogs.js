YAHOO.namespace("Wikia.Blogs");

YAHOO.Wikia.Blogs.callback = {
    success: function( oResponse ) {
		if (typeof YAHOO.lang.JSON != "undefined" ) {
			var data = YAHOO.lang.JSON.parse( oResponse.responseText )
		}
		else {
			var data = YAHOO.Tools.JSONParse( oResponse.responseText );
		}
		if ( (data['commentId']) && (data['commentId'] != 0) ) {
			YAHOO.Wikia.Blogs.callback.replace( data );
		} else {
			YAHOO.Wikia.Blogs.callback.add( data );
		}
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
		var order = YAHOO.util.Dom.get("blog-comm-order");
		if( order ) {
			if( order.value == "asc") {
				YAHOO.util.Dom.insertAfter(li, YAHOO.util.Dom.getLastChild("blog-comments-ul"));
			} else {
				YAHOO.util.Dom.insertBefore(li, YAHOO.util.Dom.getFirstChild("blog-comments-ul"));
			}
		}
		else {
			/**
			 * by default after
			 */
			YAHOO.util.Dom.insertAfter(li, YAHOO.util.Dom.getLastChild("blog-comments-ul"));
		}
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

YAHOO.Wikia.Blogs.callback.replace = function( data ) {
	if( ! data[ "error" ] ) {
		var commentId = data['commentId'];		
		var li = YAHOO.util.Dom.get( "comm-" + commentId );
		li.innerHTML = data["text"];
		YAHOO.util.Dom.get("blog-comm-bottom-info").innerHTML = "&nbsp;";
		YAHOO.util.Event.addListener( YAHOO.util.Dom.getElementsByClassName( "blog-comm-edit", "a" ), "click", YAHOO.Wikia.Blogs.edit );
	}
	else {
		YAHOO.util.Dom.get("blog-comm-text").innerHTML = data[ "msg" ];
	}
	document.body.style.cursor = "default";
	if (typeof TieDivLibrary != "undefined" ) {
		TieDivLibrary.calculate();
	}
};

YAHOO.Wikia.Blogs.callback.edit = function( data ) {
	if( ! data[ "error" ] ) {
		YAHOO.util.Dom.get( "comm-text-" + data["id"]).innerHTML = data["text"];

		/**
		 * connect signals
		 */
		YAHOO.util.Event.addListener( YAHOO.util.Dom.get( "blog-comm-submit-" + data[ "id" ] ), "click", YAHOO.Wikia.Blogs.save, data[ "id" ] );
		
		document.body.style.cursor = "default";

		if (typeof TieDivLibrary != "undefined" ) {
			TieDivLibrary.calculate();
		}
	}
};

YAHOO.Wikia.Blogs.editCallback = {
    success: function( oResponse ) {
		if (typeof YAHOO.lang.JSON != "undefined" ) {
			var data = YAHOO.lang.JSON.parse( oResponse.responseText )
		}
		else {
			var data = YAHOO.Tools.JSONParse( oResponse.responseText );
		}
		YAHOO.Wikia.Blogs.callback.edit( data );
    },
    failure: function( oResponse ) {
    },
    timeout: 5000000
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
		WET.byStr('articleAction/postComment');
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

YAHOO.Wikia.Blogs.save = function( event, id ) {
	var oForm = YAHOO.util.Dom.get( "blog-comm-form-" + id );

	if (oForm) {
		WET.byStr('articleAction/postComment');
		document.body.style.cursor = "wait";
		var textfield = YAHOO.util.Dom.get( "blog-comm-textfield-" + id );
		if( textfield ) {
			textfield.readonly = true;
			textfield.style.cursor = "wait";
		}
		YAHOO.util.Event.preventDefault( event );
		YAHOO.util.Connect.setForm( oForm, false );
		YAHOO.util.Connect.asyncRequest( "POST", wgServer + wgScript + "?action=ajax&rs=BlogComment::axSave&article=" + wgArticleId + "&id=" + id, YAHOO.Wikia.Blogs.callback );
	}
};

YAHOO.Wikia.Blogs.toggle = function( event ) {
	YAHOO.util.Event.preventDefault( event );
	document.body.style.cursor = "wait";
	YAHOO.util.Connect.asyncRequest( "GET", wgServer + wgScript + "?action=ajax&rs=BlogComment::axToggle&id=" + event.target.id + "&article=" + wgArticleId, YAHOO.Wikia.Blogs.hideCallback );
};

YAHOO.Wikia.Blogs.edit = function( event ) {
	YAHOO.util.Event.preventDefault( event );
	document.body.style.cursor = "wait";
	YAHOO.util.Connect.asyncRequest( "GET", wgServer + wgScript + "?action=ajax&rs=BlogComment::axEdit&id=" + event.target.id + "&article=" + wgArticleId, YAHOO.Wikia.Blogs.editCallback );
};

YAHOO.util.Event.addListener( "blog-comm-submit-top", "click", YAHOO.Wikia.Blogs.submit, "blog-comm-form-top" );
YAHOO.util.Event.addListener( "blog-comm-submit-bottom", "click", YAHOO.Wikia.Blogs.submit, "blog-comm-form-bottom" );
YAHOO.util.Event.addListener( "blog-comm-form-select", "change", YAHOO.Wikia.Blogs.submit, "blog-comm-form-select" );

YAHOO.Wikia.Blogs.actions = YAHOO.util.Dom.getElementsByClassName( "blog-comm-hide", "a" );
YAHOO.util.Event.addListener( YAHOO.Wikia.Blogs.actions, "click", YAHOO.Wikia.Blogs.toggle );

YAHOO.Wikia.Blogs.edits = YAHOO.util.Dom.getElementsByClassName( "blog-comm-edit", "a" );
YAHOO.util.Event.addListener( YAHOO.Wikia.Blogs.edits, "click", YAHOO.Wikia.Blogs.edit );
