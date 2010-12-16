/*
 * Group-level based edit page access for MediaWiki. Monitors current edit sessions.
 * Version 0.4.2
 *
 */

var EditConflict = {

	// time of sleep before looped AJAX call during the editpage (in seconds)
	// !! should be at least twice shorter than 'EC_AJAX_EXPIRE_TIME' defined in PHP !!
	editSleep: 30,
	// non-existent editId, which means that the editing session was finished
	nobodyEditing: -1,

	// called from body.onload to display copied pages notification list via AJAX (if there's any)
	// @param:   args[0] - article id
	// @param:   args[1..n] - list of revid's created by current user which were copied due to edit conflict
	getNotifyText : function ( args ) {
		// PHP will build copied pages notification list
		// ajax callback will display them (if available)
		sajax_do_call( "EditConflict::getNotifyText", args , EditConflict.displayNotification );
	},

	// called from copied pages notification list link
	clearRevId : function ( revId ) {
		// PHP will remove the selected revid from the edit conflicts table
		// ajax callback will remove the corresponding DOM entry
		sajax_do_call( "EditConflict::clearRevId", [ revId ], EditConflict.hideCheckout );
	},

	// loop for watching the editing page
	// can be called in two ways:
	// initlal call is performed from body.onload
	// @param   request - numeric editId
	// further calls are performed via AJAX every editSleep seconds
	// @param   request - AJAX request object, containing the value of editId
	watchEdit : function ( request ) {
		// non-existent editId indicates an error
		// OR the session is over (editid entry in DB was deleted)
		var editId = EditConflict.nobodyEditing;
		if ( request.responseText ) {
			if ( request.status == 200) {
				// get editId from AJAX callback
				editId = request.responseText;
			}
		} else {
			// get editId from the header script call parameter
			editId = request;
		}
		if ( editId != EditConflict.nobodyEditing ) {
			// php will update edit_time in the current edits table so the ongoing editing session won't expire
			// ajax callback will loop until the user will leave an editpage
			// setTimeout() is used to reduce server load
			window.setTimeout( function () { sajax_do_call( "EditConflict::markEditing", [ editId ], EditConflict.watchEdit ); },
				EditConflict.editSleep * 1000 );
		}
	},

	// AJAX callback for displaying generated copied revisions notify list before the Skin 'siteSub' element
	// ( list of the copied conflicting edits )
	// @param    request.responseText - html text of "copied resivions notify list" that will be placed before the 'siteSub'
	displayNotification : function ( request ) {
		var taglist = request.responseText;
		if (request.status != 200) {
			taglist = "<div class='error'> " + request.status + " " + request.statusText + ": " + taglist + "</div>";
		}
		if ( taglist != '' ) {
			try {
				var div = document.createElement( 'DIV' );
				div.setAttribute( 'id', 'editconflict_notify' );
				div.innerHTML = taglist;
		var siteSub = document.getElementById( 'siteSub' );
				siteSub.parentNode.insertBefore( div, siteSub );
			} catch ( e ) {
				alert( 'Error: current Skin doesn\'t have \'siteSub\' element' );
			}
		}
	},

	// @return   boolean: whether the element has next 'SPAN' sibling or not
	nextSpanSibling : function ( element ) {
		var next = element;
		do {
			next = next.nextSibling;
			if ( next && next.nodeType == 1 && next.tagName == 'SPAN' ) {
				return true;
			}
		} while ( next );
		return false;
	},

	// @return   boolean: whether the element has previous 'SPAN' sibling or not
	prevSpanSibling : function ( element ) {
		var prev = element;
		do {
			prev = prev.previousSibling;
			if ( prev && prev.nodeType == 1 && prev.tagName == 'SPAN' ) {
				return true;
			}
		} while ( prev );
		return false;
	},

	// called via ajax callback
	// removes a DOM node which contains revid notification entry
	// from the displayed "copied revision notify list"
	// @param   request.responseText - single revid value
	hideCheckout : function ( request ) {
		var revid = request.responseText;
		var parent_li, hasSpanSiblings;
		// !warning! the following code is depending on the structure of generated 'DIV' id='editconflict_notify' element!
		if (request.status == 200 && revid != '') {
			try {
				// get span with selected revid link
				var span = document.getElementById( 'EditConflict_' + revid );
				// check whether selected span has prev or next span siblings
				hasSpanSiblings = EditConflict.nextSpanSibling( span ) || EditConflict.prevSpanSibling( span );
				// get parent 'LI' of the current 'SPAN' list
				parent_li = span.parentNode;
				if ( hasSpanSiblings ) {
					// remove only current element
					parent_li.removeChild( span );
				} else {
					// no siblings - remove the parent (the whole 'LI')
					parent_li.parentNode.removeChild( parent_li );
				}
			} catch ( e ) {
				alert( 'Error: non-existent revid was given' );
			}
		}
	},

	// browser-independent addevent function
	addEvent : function ( obj, type, fn ) {
		if ( document.getElementById && document.createTextNode ) {
			if (obj.addEventListener) {
				obj.addEventListener( type, fn, false );
			}
			else if (obj.attachEvent) {
				obj["e"+type+fn] = fn;
				obj[type+fn] = function() { obj["e"+type+fn]( window.event ); }
				obj.attachEvent( "on"+type, obj[type+fn] );
			}
			else {
				obj["on"+type] = obj["e"+type+fn];
			}
		}
	},

	// get absolute on-page coordinates of the selected DOM obj
	// @param    obj - DOM obj
	// @return   object { left:x,top:y } - the values of coordinates
	GetElementPosition : function ( obj ) {
		var coords = { left: 0, top: 0 };
		while ( obj ) {
			coords.left += obj.offsetLeft;
			coords.top += obj.offsetTop;
			obj = obj.offsetParent;
		}
		return coords;
	},

	// edit action anchor
	editAnchor : null,
	// original (saved) value of edit action anchor href
	editHref : null,
	// popup div element
	popup : null,

	// attach ajax php call to anchor onclick event
	// @param    articleId - article_id of the current title
	// @param    a - anchor
	// @param    disallowEdit - whether the user of higher weight already edits the article
	attachToEditAnchor : function ( articleId, a, disallowEdit ) {
		EditConflict.editAnchor = a;
		// save original anchor href
		EditConflict.editHref = a.getAttribute( 'href' );
		EditConflict.editTooltip = a.getAttribute( 'title' );
		// disable anchor href because event "return false" may fail sometimes
		// ( we will use window.location.href instead )
		a.href = '#';
		if ( disallowEdit ) {
			// clear invitation tooltip
			a.setAttribute( 'title', '' );
		}
		EditConflict.addEvent( a, "click",
			function () {
				// php will check, whether another user with higher edit weight alreay edits the page
				// ajax callback will go to edit page or will display a warning that editing is not allowed,
				// ( based on the result from php call )
				sajax_do_call( "EditConflict::checkEditButton", [ articleId ] , EditConflict.clickEventResult );
				return true;
			}
		);
	},

	// create popup div message
	// this.popup property will store div popup object
	createPopup : function ( text ) {
		var div = document.createElement( 'DIV' );
		div.setAttribute( 'id', 'editconflict_popup' );
		div.innerHTML = text;
		document.body.appendChild( div );
		EditConflict.popup = div;
	},

	// display the popup div message just below the obj in the selected number of seconds
	displayPopup : function ( obj, seconds ) {
		var obj_coords = EditConflict.GetElementPosition( obj );
		var displayShift = { x: 20, y: obj.offsetHeight };
		var ec_size = { w: EditConflict.popup.offsetWidth, h: EditConflict.popup.offsetHeight };
		delta = document.body.scrollWidth - obj_coords.left - displayShift.x - ec_size.w;
		if ( delta < 0 ) {
			displayShift.x -= delta;
		}
		delta = document.body.scrollHeight - obj_coords.top - displayShift.y - ec_size.h;
		if ( delta < 0 ) {
			displayShift.y -= delta;
		}
		EditConflict.popup.style.left = (obj_coords.left + displayShift.x) + "px";
		EditConflict.popup.style.top = (obj_coords.top + displayShift.y) + "px";
		EditConflict.popup.style.visibility = 'visible';
		window.setTimeout(
			function () {
				EditConflict.popup.style.visibility = 'hidden';
			},
			seconds * 1000
		);
	},

	// called from body.onload to find edit anchor and to attach an event to it
	// @param    articleId - article_id of current title
	// @param    disallowEdit - whether the user of higher weight already edits the article
	findEditKey : function ( articleId, disallowEdit ) {
		var as = document.body.getElementsByTagName('a');
		for ( var i=0; i<as.length; i++ ) {
			// find an edit access key
			if ( as[i].getAttribute( 'accesskey' ) == 'e' ) {
				EditConflict.createPopup( ec_already_editing );
				EditConflict.attachToEditAnchor( articleId, as[i], disallowEdit );
				return;
			}
		}
	},

	// ajax callback
	// @param    request.responseText - 'y' allows to go to edit page; 'n' - blocks edit link and outputs a popup warning
	clickEventResult : function ( request ) {
		var result = request.responseText;
		var clickEventResult = true;
		if (request.status == 200 ) {
			if (request.responseText == 'y') {
				// editing is allowed, going to edit location
				window.location.href = EditConflict.editHref;
			} else {
				// editing is disabled - show a popup warning for 5 seconds
				EditConflict.editAnchor.blur();
				EditConflict.editAnchor.setAttribute('title','');
				EditConflict.displayPopup( EditConflict.editAnchor, 5 );
			}
		}
	}
}
