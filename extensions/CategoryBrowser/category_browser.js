/**
 * ***** BEGIN LICENSE BLOCK *****
 * This file is part of CategoryBrowser.
 *
 * CategoryBrowser is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * CategoryBrowser is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with CategoryBrowser; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * ***** END LICENSE BLOCK *****
 *
 * CategoryBrowser is an AJAX-enabled category filter and browser for MediaWiki.
 *
 * To activate this extension :
 * * Create a new directory named CategoryBrowser into the directory "extensions" of MediaWiki.
 * * Place the files from the extension archive there.
 * * Add this line at the end of your LocalSettings.php file :
 * require_once "$IP/extensions/CategoryBrowser/CategoryBrowser.php";
 *
 * @version 0.3.1
 * @link http://www.mediawiki.org/wiki/Extension:CategoryBrowser
 * @author Dmitriy Sintsov <questpc@rambler.ru>
 * @addtogroup Extensions
 */

/*
 * basic functions
 */
var CB_lib = {
	log : function( s ) {
		if ( typeof console != "undefined" ) {
			console.log( s );
		}
	},

	/**
	 * get Internet Explorer version
	 * @return version of Internet Explorer or 1000 (indicating the use of another browser)
	 */
	getIEver : function() {
		var rv = 1000;
		if (navigator.appName == 'Microsoft Internet Explorer') {
			var ua = navigator.userAgent;
			var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
			if (re.exec(ua) != null) {
				rv = parseFloat( RegExp.$1 );
			}
		}
		return rv;
	},

	/*** general event handling ***/
	addEvent : function ( domObj, type, fn ) {
		if ( domObj.addEventListener ) {
			domObj.addEventListener( type, fn, false );
		} else if ( domObj.attachEvent ) {
			domObj["e"+type+fn] = fn;
			domObj[type+fn] = function() { domObj["e"+type+fn]( window.event ); }
			domObj.attachEvent( "on"+type, domObj[type+fn] );
		} else {
			domObj["on"+type] = domObj["e"+type+fn];
			alert( 'Your browser does not support proper event attaching' );
		}
	},

	getEventObj : function ( event, stopPropagation ) {
		var obj;
		if ( typeof event.target !== 'undefined' ) {
			obj = event.target;
			if ( stopPropagation ) {
				event.stopPropagation();
			}
		} else {
			obj = event.srcElement;
			if ( stopPropagation ) {
				event.cancelBubble = true;
			}
		}
		return obj;
	},

	// basename prefix of user's cookies
	cookiePrefix : null,

	/**
	 * TODO: unused, remove
	 */
	 setCookiePrefix : function( name ) {
		this.cookiePrefix = name;
	},

	/**
	 * TODO: unused, remove
	 * @return empty string in case cookie value is empty, null when cookie is not set
	 */
	getCookie : function ( cookieName ) {
		var ca, cn, keyval, key, val;
		ca = document.cookie.split( ';' );
		for ( var i=0; i < ca.length; i++ ) {
			keyval = ca[i].split( '=' );
			// trim whitespace
			key = keyval[0].replace(/^\s+|\s+$/g, '');
			if ( key == (this.cookiePrefix + cookieName) ) {
				if ( keyval.length > 1 ) {
					return unescape( keyval[1].replace(/^\s+|\s+$/g, '') );
				} else {
					// cookie exists but has no value
					return "";
				}
			}
		}
		// cookie not found
		return null;
	},

	findParentByClassName : function( obj, className ) {
		for ( var parentObj = obj.parentNode; parentObj != null; parentObj = parentObj.parentNode ) {
			if ( parentObj.nodeType == 1 && parentObj.className == className ) {
				return parentObj;
			}
		}
		return parentObj;
	},

	/**
	 * TODO: unused, remove
	 * usage example: CB_lib.setCookie( 'rootcond', eventObj.value, 24 * 60 * 60, '/' );
	 */
	setCookie : function( cookieName, value, expires, path, domain, secure ) {
		// set time, it's in milliseconds
		var today = new Date();
		today.setTime( today.getTime() );

		/*
		if the expires variable is set, make the correct
		expires time, the current script below will set
		it for x number of days, to make it for hours,
		delete * 24, for minutes, delete * 60 * 24
		*/
		if ( expires ) {
			expires = expires * 1000 // * 60 * 60 * 24;
		}
		var expires_date = new Date( today.getTime() + expires );

		document.cookie = this.cookiePrefix + cookieName + "=" +escape( value ) +
		( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) +
		( ( path ) ? ";path=" + path : "" ) +
		( ( domain ) ? ";domain=" + domain : "" ) +
		( ( secure ) ? ";secure" : "" );
	},

	/*** simple form elements generators ***/
	/**
	 * generate select/option from the list given
	 * @param optionsList - object key/value pairs
	 * @param selectedOption - selected key in optionsList
	 */
	htmlSelector : function( optionsList, selectedOption ) {
		var option;
		var select = document.createElement( 'select' );
		for ( var key in optionsList ) {
			option = document.createElement( 'option' );
			option.setAttribute( 'value', key );
			option.appendChild( document.createTextNode( optionsList[ key ] ) );
			if ( key == selectedOption ) {
				option.setAttribute( 'selected', '' );
			}
			select.appendChild( option );
		}
		return select;
	},

	/**
	 * generate input box from value given
	 * @param value to put into input box
	 */
	textInput : function( value ) {
		var vs = value.toString();
		var input = document.createElement( 'input' );
		input.setAttribute( 'type', 'text' );
		input.style.width = (vs.length) * 0.75 + "em";
		input.setAttribute( 'value', vs );
		return input;
	},

	/**
	 * find option node of select which has the specified value of value attribute
	 * @param select select node
	 * @param value of option attribute to find (if not specified, uses select.value)
	 * @param attribute name of option attribute which value has to be searched for (if not specified, used 'value' attribute)
	 */
	getSelectOption : function( select, value, attribute ) {
		var node;
		var attribute = typeof attribute == 'undefined' ? 'value' : attribute;
		var valueToFind = typeof value == 'undefined' ? select.value : value;
		if ( typeof valueToFind == 'undefined' ) {
			alert( 'No value to find or no selected option in CB_lib.getSelectOption' );
			return null;
		}
		for ( var i=0; i < select.childNodes.length; i++ ) {
			node = select.childNodes[i];
			if ( node.nodeType == 1 ) {
				if ( node.getAttribute( attribute ) == valueToFind ) {
					return select.childNodes[i];
				}
			}
		}
		return null;
	},

	divButton : function( buttonOperation, buttonText, buttonTitle ) {
		var element = document.createElement( 'div' );
		element.className = 'cb_control_button';
		element.appendChild( document.createTextNode( buttonText ) );
		element.setAttribute( 'buttonoperation', buttonOperation );
		if ( typeof buttonTitle !== 'undefined' && buttonTitle != '' ) {
			element.setAttribute( 'title', buttonTitle );
		}
		return element;
	}

} /* end of CB_lib */

/*
 * UI settings
 */
var CB_Setup = {
	isIE: CB_lib.getIEver(),

	// various colors used in CB_ConditionEditor / CB_EditLine / CB_Token
	colors : {
		'samples': { 'color': 'white', 'bgr': 'gray' },
		'error': { 'color': 'red', 'bgr': 'aquamarine' },
		'copy': { 'color': 'white', 'bgr': 'blue' }
	},
	// delay in milliseconds before performing ajax call to reduce server load
	'ajaxPollTimeout' : 2000
} /* end of CB_Setup */

var CategoryBrowser = {

/*
 * AJAX category tree section
 */

	// {{{ root query condition parameters
	// currently selected encoded reverse polish queue (constructed in CB_ConditionEditor)
	rootCond : null,
	// query only categories which has no parents
	noParentsOnly : false,
	// category name filter (LIKE)
	nameFilter : '',
	// category name filter case-insensetive flag (when true, queries use LIKE COLLATE)
	nameFilterCI : false,
	// }}}

	// limit of pager query (also passed further via AJAX call)
	pagerLimit : null,
	// nested container object
	container : null,

	/**
	 * @param encPolishQueue encoded queue in reverse polish format (SQL condition)
	 * @param rootCond condition string in encoded polish format
	 * @param offset queue offset
	 * @param limit (optional)
	 */
	rootCats : function( rootCond, offset, limit ) {
		this.rootCond = rootCond;
		var param = [this.rootCond, this.nameFilter, this.nameFilterCI, this.noParentsOnly, offset];
		if ( limit ) {
			param.push( limit );
		} else {
			if ( this.pagerLimit !== null ) {
				param.push( this.pagerLimit );
			}
		}
		sajax_do_call( "CategoryBrowser::getRootOffsetHtml", param, document.getElementById( "cb_root_container" ) );
		return false;
	},

	/**
	 * find DOM node of currently clicked control
	 * @param eventObj - click event object
	 * @return DOM node (which lastChild may contain the nested list of entries) if found, null otherwise
	 */
	findNode : function( eventObj ) {
		for ( var node = eventObj.parentNode; node != null; node = node.parentNode ) {
			if ( node.className == 'cb_cat_container' ) {
				break;
			}
		}
		return node;
	},

	/**
	 * create / get nested DOM container of the specified category DOM node
	 * @param node - category DOM node
	 * @return DOM node of current nested container
	 */
	getNestedContainer : function( node ) {
		var container = node.lastChild;
		if ( !( container &&
				container.nodeType == 1 &&
				container.className == 'cb_nested_container' ) ) {
			container = document.createElement( 'DIV' );
			container.style.display = 'none';
			container.className = 'cb_nested_container';
			node.appendChild( container );
		}
		return container;
	},

	/**
	 * switch visibility of container
	 * @param: id - set id attribute of nested container (indicates the type of content placed into container)
	 */
	setContainerVisibility : function( id, isVisible ) {
		if ( isVisible ) {
			this.container.style.display = 'block';
		} else {
			this.container.innerHTML = '';
			this.container.style.display = 'none';
		}
		this.container.setAttribute( 'id', id );
	},

	subLink : function( eventObj, catName, pagerType, plusMode ) {
		eventObj.blur();
		// find 'cat_expand_sign' container
		var expandSign = CB_lib.findParentByClassName( eventObj, 'cb_cat_controls' );
		if ( expandSign === null ||
				(expandSign = expandSign.firstChild) === null ||
				(expandSign = expandSign.firstChild) === null ) {
			alert( 'Cannot find expand sign container in CategoryBrowser.subCatsLink() ' );
		}
		var treeNode = this.findNode( eventObj );
		if ( treeNode == null ) {
			alert( 'Cannot find DOM node object of event click object in CategoryBrowser.subCatsLink()' );
			return;
		}
		this.container = this.getNestedContainer( treeNode );
		// when clicking an expanded (opened) node "sign", force collapsing (close node)
		var forceCollapsing = typeof plusMode !== 'undefined' && expandSign.innerHTML == '-';
		if ( forceCollapsing ||
				( this.container.style.display != 'none' &&
					this.container.getAttribute( 'id' ) == 'cb_nested_'+pagerType ) ) {
			// collapsing
			expandSign.innerHTML = '+';
			this.setContainerVisibility( '', false );
		} else {
			// expanding
			expandSign.innerHTML = '-';
			var param = [pagerType, catName];
			sajax_do_call( "CategoryBrowser::getSubOffsetHtml", param, this.container );
			this.setContainerVisibility( 'cb_nested_'+pagerType, true );
		}
		return false;
	},

	subCatsPlus : function( eventObj, catName ) {
		return this.subLink( eventObj, catName, 'subcats', true );
	},

	subCatsLink : function( eventObj, catName ) {
		return this.subLink( eventObj, catName, 'subcats' );
	},

	pagesLink : function( eventObj, catName ) {
		return this.subLink( eventObj, catName, 'pages' );
	},

	filesLink : function( eventObj, catName ) {
		return this.subLink( eventObj, catName, 'files' );
	},

	parentCatsLink : function( eventObj, catName ) {
		return this.subLink( eventObj, catName, 'parents' );
	},

	subNav : function( eventObj, param ) {
		var treeNode = this.findNode( eventObj );
		if ( treeNode == null ) {
			alert( 'Cannot find DOM node object of event click object in CategoryBrowser.subNav()' );
			return;
		}
		this.container = this.getNestedContainer( treeNode );
		sajax_do_call( "CategoryBrowser::getSubOffsetHtml", param, this.container );
	},

	subCatsNav : function( eventObj, catName, offset, limit ) {
		var param = ['subcats', catName];
		if ( offset ) {
			param.push( offset );
			if ( limit ) {
				param.push( limit );
			}
		}
		// used .parentNode to skip self container
		this.subNav( eventObj.parentNode, param );
		return false;
	},

	pagesNav : function( eventObj, catName, offset, limit ) {
		var param = ['pages', catName];
		if ( offset ) {
			param.push( offset );
			if ( limit ) {
				param.push( limit );
			}
		}
		// used .parentNode to skip self container
		this.subNav( eventObj.parentNode, param );
		return false;
	},

	filesNav : function( eventObj, catName, offset, limit ) {
		var param = ['files', catName];
		if ( offset ) {
			param.push( offset );
			if ( limit ) {
				param.push( limit );
			}
		}
		// used .parentNode to skip self container
		this.subNav( eventObj.parentNode, param );
		return false;
	},

	parentCatsNav : function( eventObj, catName, offset, limit ) {
		var param = ['parents', catName];
		if ( offset ) {
			param.push( offset );
			if ( limit ) {
				param.push( limit );
			}
		}
		// used .parentNode to skip self container
		this.subNav( eventObj.parentNode, param );
		return false;
	},

	searchForRoot : function( eventObj, catName ) {
		eventObj.blur();
		document.getElementById( 'cb_cat_name_filter' ).value = catName;
		this.setFilter();
		return false;
	},

	setFilter : function() {
		if ( this.rootCond === null ) {
			this.rootCond = document.getElementById( 'cb_expr_select' ).value;
			if ( this.rootCond === null ) {
				alert( 'Cannot find selected rootCond option in CategoryBrowser.setFilter' );
			}
		}
		window.setTimeout( function() { CategoryBrowser.filterPoll(); }, CB_Setup.ajaxPollTimeout );
		return true;
	},

	clearNameFilter : function( eventObj ) {
		this.searchForRoot( eventObj, '' );
		document.getElementById( 'cb_cat_name_filter' ).focus();
		return false;
	},

	filterPoll : function() {
		if ( this.rootCond === null ) {
			this.rootCond = document.getElementById( 'cb_expr_select' ).value;
		}
		var nameFilter = document.getElementById( 'cb_cat_name_filter' ).value;
		var CIcheckbox = document.getElementById( 'cb_cat_name_filter_ci' );
		var nameFilterCI = CIcheckbox !== null ? CIcheckbox.checked : false;
		var noParentsCheckbox = document.getElementById( 'cb_cat_no_parents_only' );
		var noParentsOnly = noParentsCheckbox !== null ? noParentsCheckbox.checked : false;
		if ( this.rootCond !== null &&
				( this.nameFilter != nameFilter ||
					this.nameFilterCI != nameFilterCI ||
					this.noParentsOnly != noParentsOnly ) ) {
			// in case nameFilter field was changed, update the root pager
			this.nameFilter = nameFilter;
			this.nameFilterCI = nameFilterCI;
			this.noParentsOnly = noParentsOnly;
			var param = [this.rootCond, this.nameFilter, this.nameFilterCI, this.noParentsOnly, 0];
			if ( this.pagerLimit !== null ) {
				param.push( this.pagerLimit );
			}
			sajax_do_call( "CategoryBrowser::getRootOffsetHtml", param, document.getElementById( "cb_root_container" ) );
		}
		window.setTimeout( function() { CategoryBrowser.filterPoll(); }, CB_Setup.ajaxPollTimeout );
	},

	/**
	 * condition selector (with cookie manager)
	 * warning! use CB_lib.log(); placing debug alert() in js code may screw up event handling
	 */
	setExpr : function( eventObj, pagerLimit ) {
		this.rootCond = eventObj.value;
		var selectedOption = CB_lib.getSelectOption( eventObj );
		if ( selectedOption === null ) {
			alert( 'Cannot find selected option in CategoryBrowser.setExpr' );
		}
		var selectedEncInfixQueue = selectedOption.getAttribute( 'infixexpr' );
		CB_lib.log('setExpr selectedEncInfixQueue='+selectedEncInfixQueue);
		this.pagerLimit = pagerLimit;
		CB_lib.log( 'setExpr refreshing with value='+eventObj.value );
		sajax_do_call( "CategoryBrowser::getRootOffsetHtml", [this.rootCond, this.nameFilter, this.nameFilterCI, this.noParentsOnly, 0, this.pagerLimit], document.getElementById( "cb_root_container" ) );
		CB_ConditionEditor.createExpr( selectedEncInfixQueue );
		return true;
	}

} /* end of CategoryBrowser */

/*
 * editor part
 */

 /*
 * token mvc all in one
 * mvc is not separated to avoid unnecessarily code monstrousity
 * @token - encoded infix token string (single)
 * @lineInstanceName - string property name of CB_ConditionEditor, where the token is stored
 *     ( CB_ConditionEditor[lineInstanceName] is an instance of CB_EditLine )
 * @index - numeric index of CB_Token instance in CB_ConditionEditor[lineInstanceName]
 *     ( CB_ConditionEditor[lineInstanceName][index] is an instance of CB_Token )
 *     (also should match DOM container attribute in CB_Token.prototype.findLineInstanceName method)
 * @colors - optional object {'color':color, 'bgr':backgroundColor} colors of node (node is a DOM container)
 */
function CB_Token( token, lineInstanceName, index, colors ) {
	this.type = 'undef';
	CB_lib.log( 'token='+token );
	switch ( token.toLowerCase() ) {
	case 'all': this.type = 'select'; this.op = 'all'; break;
	case '(' : this.type = 'bracket'; this.op = 'lbracket'; break;
	case ')' : this.type = 'bracket'; this.op = 'rbracket'; break;
	case 'and' : this.type = 'logic'; this.op = 'and'; break;
	case 'or' : this.type = 'logic'; this.op = 'or'; break;
	default :
		var cmp = token.split( /^(ge|le|eq)(p|s|f)(\d+)$/g );
		if ( cmp.length == 5 ) {
			// comparsion operation
			this.type = 'comparsion';
			this.op = cmp[1].toLowerCase();
			this.field = cmp[2];
			this.number = parseInt( cmp[3] );
		} else {
			// IE regexp fix
			if ( token.length > 3 ) {
				var op = token.substring( 0, 2 );
				var field = token.substring( 2, 3 );
				var number = token.substring( 3 );
				if ( op.match( /^ge|le|eq$/ ) !== null &&
						field.match( /^p|s|f$/ ) !== null &&
						number.match( /^\d+$/ ) !== null ) {
					// comparsion operation
					this.type = 'comparsion';
					this.op = op;
					this.field = field;
					this.number = number;
				}
			}
		}
	}
	this.lineInstanceName = lineInstanceName;
	this.node = document.createElement( 'div' );
	this.node.className = 'cb_token_container';
	this.colors = { 'color': '', 'bgr': '' };
	// controlButtonsList - object key / value pair of controlButtons
	this.controlButtonsList = {};
	if ( typeof colors !== 'undefined' ) {
		this.setColors( colors );
	}
	this.setIndex( index );
	this.clearNode();
	CB_lib.addEvent( this.node, 'mouseover', CB_Token.prototype.nodeMouseOver );
	if ( this.type == 'undef' ) {
		alert( 'Invalid token type='+this.type+' in CB_Token constructor' );
	} else if ( this.type == 'bracket' ) {
		this.buildNodePoly = CB_Token.prototype.buildBracketNode;
		this.toString = CB_Token.prototype.BracketToString;
	} else if ( this.type == 'select' ) {
		this.buildNodePoly = CB_Token.prototype.buildSelectNode;
		this.toString = CB_Token.prototype.OpToString;
	} else if ( this.type == 'logic' ) {
		this.buildNodePoly = CB_Token.prototype.buildLogicNode;
		this.toString = CB_Token.prototype.OpToString;
	} else if ( this.type == 'comparsion' ) {
		this.buildNodePoly = CB_Token.prototype.buildComparsionNode;
		this.toString = CB_Token.prototype.Op2ToString;
	} else {
		alert( 'Unimplemented node type='+this.type+' in CB_Token constructor' );
	}
}
/***
 * token's CB_EditLine instance name find, CB_EditLine.tokens index set / find
***/
CB_Token.prototype.findLineInstanceName = function( domObj ) {
	var instanceName;
	for ( var obj = domObj; obj !== null; obj = obj.parentNode ) {
		if ( ( instanceName = obj.getAttribute( 'lineinstancename' ) ) !== null ) {
			return instanceName;
		}
	}
	alert( 'Cannot find token\'s CB_EditLine instance name in CB_Token.findLineInstanceName' );
}
CB_Token.prototype.setIndex = function( index ) {
	this.index = index;
	this.node.setAttribute( 'tokenindex', index );
}
CB_Token.prototype.findIndex = function( domObj ) {
	var index, result = null;
	for ( var obj = domObj; obj !== null; obj = obj.parentNode ) {
		if ( ( index = obj.getAttribute( 'tokenindex' ) ) !== null ) {
			result = parseInt( index );
			if ( isNaN( result ) || result < 0 ) {
				alert( 'Invalid (non-numeric or negative) value of token index='+result+' in CB_Token.findIndex' );
			}
			return result;
		}
	}
	alert( 'Cannot find token index in CB_Token.findIndex' );
}
/*** token DOM node colors, currently used in token copy / paste / validation code ***/
CB_Token.prototype.setColors = function( colors ) {
	// we need a copy of properties, not a source object reference!
	if ( typeof colors !== 'undefined' ) {
		if ( typeof colors.color !== 'undefined' ) {
			this.colors.color = colors.color;
			this.node.style.color = colors.color;
		}
		if ( typeof colors.bgr !== 'undefined' ) {
			this.colors.bgr = colors.bgr;
			this.node.style.backgroundColor = colors.bgr;
		}
	}
}
/*
 * adds / removes buttons in token controlButtonsList
 * @param appendControlButtons object key / value pairs (use value=null to "remove" the button)
 */
CB_Token.prototype.setControlButtons = function( appendControlButtons ) {
	for ( var key in appendControlButtons ) {
		this.controlButtonsList[ key ] = appendControlButtons[ key ];
	}
}
/***
 * token editor controls (move / delete existing tokens)
***/
/*
 * initialize the node by removing the dynamic controls and appending editor's buttons
 * called by buildNodePoly() implementations
 */
CB_Token.prototype.clearNode = function() {
	this.node.innerHTML = '';
	this.node.appendChild( this.createPopupControls() );
}
/*
 * creates token control (container)
 * 1. div class='cb_popup_controls' contains move / delete buttons (whole expression editor)
 * TODO: do not display 'left' button for the first token, do not display 'right' button for the last token
 */
CB_Token.prototype.createPopupControls = function() {
	var popupControls = document.createElement( 'div' );
	var hint;
	popupControls.className = 'cb_popup_controls';
	for ( var key in this.controlButtonsList ) {
		if ( this.controlButtonsList[ key ] !== null ) {
			// button was not removed, add it
			hint = '';
			if ( typeof CB_ConditionEditor.localEditHints[ key ] !== 'undefined' ) {
				hint = CB_ConditionEditor.localEditHints[ key ];
			}
			popupControls.appendChild( this.controlButton( key, this.controlButtonsList[ key ], hint ) );
		}
	}
	return popupControls;
}
CB_Token.prototype.controlButton = function( op, text, hint ) {
	var button = CB_lib.divButton( op, text, hint );
	CB_lib.addEvent( button, 'click', CB_Token.prototype.controlButtonClick );
	return button;
}
/*
 * creates token control (container)
 * 2. div class='cb_token_inputs' contains dynamical selects / inputs (single token editor)
 */
CB_Token.prototype.createTokenInputs = function() {
	tokenInputs = document.createElement( 'div' );
	tokenInputs.className = 'cb_token_inputs';
	for ( var i = 0; i < arguments.length; i++ ) {
		tokenInputs.appendChild( arguments[i] );
	}
	return tokenInputs;
}
/*
 * get current token's control container of className given
 * currently node has two childs (control containers):
 * 1. div class='cb_popup_controls' contains move / delete buttons (whole expression editor)
 * 2. div class='cb_token_inputs' contains dynamical selects / inputs (single token editor)
 */
CB_Token.prototype.getControlContainer = function( className ) {
	var node;
	for ( var i = 0; i < this.node.childNodes.length; i++ ) {
		var node = this.node.childNodes[i];
		if ( node.nodeType == 1 && node.className == className ) {
			return node;
		}
	}
	alert( 'Cannot get control class='+className+' of node index=['+this.index+'] in CB_Token' );
	return null;
}
/***
 * display current token popup controls, hide another tokens popup controls
**/
CB_Token.prototype.nodeMouseOver = function( event ) {
	var obj = CB_lib.getEventObj( event, true );
	var lineInstanceName = CB_Token.prototype.findLineInstanceName( obj );
	var index = CB_Token.prototype.findIndex( obj );
	// {{{ switch the context
	if ( index < CB_ConditionEditor[ lineInstanceName ].tokens.length ) {
		CB_Token.prototype._nodeMouseOver.call( CB_ConditionEditor[ lineInstanceName ].tokens[ index ], obj );
	}
	// switch the context }}}
}
/*
 * @param domObj is current node here (currently unused)
 */
CB_Token.prototype._nodeMouseOver = function( domObj ) {
	CB_ConditionEditor[ this.lineInstanceName ].showPopupControls( this.index );
}
/***
 * click edit buttons located inside popup controls
**/
CB_Token.prototype.controlButtonClick = function( event ) {
	var obj = CB_lib.getEventObj( event, true );
	var lineInstanceName = CB_Token.prototype.findLineInstanceName( obj );
	var index = CB_Token.prototype.findIndex( obj );
	// {{{ switch the context
	if ( index < CB_ConditionEditor[ lineInstanceName ].tokens.length ) {
		CB_Token.prototype._controlButtonClick.call( CB_ConditionEditor[ lineInstanceName ].tokens[ index ], obj );
	}
	// switch the context }}}
}
/*
 * @param domObj is control button which was clicked
 */
CB_Token.prototype._controlButtonClick = function( domObj ) {
	var editOp = domObj.getAttribute( 'buttonoperation' );
	CB_ConditionEditor[ this.lineInstanceName ].doEdit( this.index, editOp );
}
/***
 * dynamic elements ( text input, select/option) handling
 * this kind of selector appears dynamically only during mouseover event over the created span class='cb_virtual_select' element
 * and becomes the same div (with selected option value) back after the mouseout event over the selector
***/
/*
 * creates dynamical (linked to current CB_Token object property) text input field
 */
CB_Token.prototype.dynamicTextInput = function() {
	var element = CB_lib.textInput( this.number );
	CB_lib.addEvent( element, 'change', CB_Token.prototype.dynamicTextInputChange );
	CB_lib.addEvent( element, 'keyup', CB_Token.prototype.dynamicTextInputChange );
//	CB_lib.addEvent( element, 'mouseout', CB_Token.prototype.dynamicTextInputChange );
	return element;
}
CB_Token.prototype.dynamicTextInputChange = function( event ) {
	var obj = CB_lib.getEventObj( event, true );
	var lineInstanceName = CB_Token.prototype.findLineInstanceName( obj );
	var index = CB_Token.prototype.findIndex( obj );
	// {{{ switch the context
	if ( index < CB_ConditionEditor[ lineInstanceName ].tokens.length ) {
		CB_Token.prototype._dynamicTextInputChange.call( CB_ConditionEditor[ lineInstanceName ].tokens[ index ], obj );
	}
	// switch the context }}}
}
/* domObj is a text input here */
CB_Token.prototype._dynamicTextInputChange = function( domObj ) {
	var number = parseInt( domObj.value );
	this.number = isNaN( number ) ? 0 : Math.abs( number );
	domObj.style.width = (this.number.toString().length) * 0.75 + "em";
	// deselect highlighted sample value, because input value was changed
	// TODO: implement in cleaner way?
	if ( this.lineInstanceName == 'samplesLine' ) {
		CB_ConditionEditor.clearSelection();
	}
}
/*
 * @param optionsList string property name of object instance in CB_ConditionEditor containing key / value pairs list
 * @param property string name of property in CB_Token object has to be changed by dynamicSelector ('op', 'field')
 * @param selectedOption selected key in optionsList
 */
CB_Token.prototype.dynamicSelector = function( optionsList, property, selectedOption ) {
	var element = document.createElement( 'span' );
	element.className = 'cb_virtual_select';
	element.appendChild( document.createTextNode( CB_ConditionEditor[ optionsList ][ selectedOption ] ) );
	element.setAttribute( 'optionslist', optionsList );
	element.setAttribute( 'tokenproperty', property );
	CB_lib.addEvent( element, 'mouseover', CB_Token.prototype.dynamicSelectorMouseover );
	return element;
}
CB_Token.prototype.dynamicSelectorMouseover = function( event ) {
	var obj = CB_lib.getEventObj( event, true );
	var lineInstanceName = CB_Token.prototype.findLineInstanceName( obj );
	var index = CB_Token.prototype.findIndex( obj );
	// {{{ switch the context
	if ( index < CB_ConditionEditor[ lineInstanceName ].tokens.length ) {
		CB_Token.prototype._dynamicSelectorMouseover.call( CB_ConditionEditor[ lineInstanceName ].tokens[ index ], obj );
	}
	// switch the context }}}
}
/* domObj is a span of cb_virtual_select' class here */
CB_Token.prototype._dynamicSelectorMouseover = function( domObj ) {
	var optionsList = domObj.getAttribute( 'optionslist' );
	var property = domObj.getAttribute( 'tokenproperty' );
	var selector = CB_lib.htmlSelector( CB_ConditionEditor[ optionsList ], this[ property ] );
	selector.setAttribute( 'optionslist', optionsList );
	selector.setAttribute( 'tokenproperty', property );
	CB_lib.addEvent( selector, 'change', CB_Token.prototype.dynamicSelectorChange );
	CB_lib.addEvent( selector, 'blur', CB_Token.prototype.dynamicSelectorBlur );
	domObj.parentNode.replaceChild( selector, domObj ); // selector - new element, domObj - old element
	// refresh all another nodes but this one
	CB_ConditionEditor[ this.lineInstanceName ].viewCached( this.index );
}
CB_Token.prototype.dynamicSelectorChange = function( event ) {
	var obj = CB_lib.getEventObj( event, true );
	var lineInstanceName = CB_Token.prototype.findLineInstanceName( obj );
	var index = CB_Token.prototype.findIndex( obj );
	// {{{ switch the context
	if ( index < CB_ConditionEditor[ lineInstanceName ].tokens.length ) {
		CB_Token.prototype._dynamicSelectorChange.call( CB_ConditionEditor[ lineInstanceName ].tokens[ index ], obj );
	}
	// switch the context }}}
}
/* domObj is a dynamically generated select/option here */
CB_Token.prototype._dynamicSelectorChange = function( domObj ) {
	var property = domObj.getAttribute( 'tokenproperty' );
	var selectedOption, option;
	if ( typeof domObj.selectedIndex !== 'undefined' ) {
		CB_lib.log( 'property='+property );
		CB_lib.log( 'selected index='+domObj.options[ domObj.selectedIndex ].value );
		// note that is select tag index, not a this.index!
		if ( property == 'op' ) {
			this.op = domObj.options[ domObj.selectedIndex ].value;
		} else if ( property == 'field' ) {
			this.field = domObj.options[ domObj.selectedIndex ].value;
		} else {
			alert( 'Unknown property='+property+' in CB_Token._dynamicSelectorChange' );
		}
		// deselect highlighted sample value, because selector's value was changed
		// TODO: implement in cleaner way?
		if ( this.lineInstanceName == 'samplesLine' ) {
			CB_ConditionEditor.clearSelection();
		}
		CB_ConditionEditor[ this.lineInstanceName ].view();
	}
}
CB_Token.prototype.dynamicSelectorBlur = function( event ) {
	var obj = CB_lib.getEventObj( event, true );
	var lineInstanceName = CB_Token.prototype.findLineInstanceName( obj );
	var index = CB_Token.prototype.findIndex( obj );
	// {{{ switch the context
	if ( index < CB_ConditionEditor[ lineInstanceName ].tokens.length ) {
		CB_Token.prototype._dynamicSelectorBlur.call( CB_ConditionEditor[ lineInstanceName ].tokens[ index ], obj );
	}
	// switch the context }}}
}
/* domObj is a dynamically generated select/option here */
CB_Token.prototype._dynamicSelectorBlur = function( domObj ) {
	// note that is select tag index, not a this.index!
	CB_lib.log( 'blur selected index='+domObj.options[ domObj.selectedIndex ].value );
	CB_lib.log('this.type='+this.type);
	this.buildNode();
}
/*
 * param @controlButtonsList - optional object key / value pair of controlButtons (old buttons will be removed)
 */
CB_Token.prototype.buildNode = function( controlButtonsList ) {
	if ( typeof controlButtonsList !== 'undefined' ) {
		this.controlButtonsList = controlButtonsList;
	}
	this.buildNodePoly();
}
CB_Token.prototype.buildNodeCached = function() {
	this.buildNodePoly( true );
}
/***
 * buildNodePoly() polymorphic prototypes (initialized in the constructor of CB_Token)
***/
CB_Token.prototype.buildSelectNode = function() {
	this.clearNode();
	var tokenInputs = this.createTokenInputs( document.createTextNode( CB_ConditionEditor.localMessages[ 'all_op' ] ) );
	this.node.appendChild( tokenInputs );
}
CB_Token.prototype.buildBracketNode = function() {
	this.clearNode();
	var tokenInputs = this.createTokenInputs( document.createTextNode( CB_ConditionEditor.localBrackets[ this.op ] ) );
	this.node.appendChild( tokenInputs );
}
CB_Token.prototype.buildLogicNode = function() {
	this.clearNode();
	var tokenInputs = this.createTokenInputs( this.dynamicSelector( 'localBoolOps', 'op', this.op ) );
	this.node.appendChild( tokenInputs );
}
CB_Token.prototype.buildComparsionNode = function( cacheTextInput ) {
	// if cacheTextInput was passed, do not re-generate the dynamic text input
	var dynamicTextInput = ( typeof cacheTextInput == 'undefined' ) ? this.dynamicTextInput() : this.getControlContainer( 'cb_token_inputs' ).childNodes[2];
	this.clearNode();
	var positions = CB_ConditionEditor.localMessages[ 'op2_template' ].match( /\$\d/g );
	var parameters = {
		'$1' : this.dynamicSelector( 'localDbFields', 'field', this.field ),
		'$2' : this.dynamicSelector( 'localCmpOps', 'op', this.op ),
		'$3' : dynamicTextInput
	}
	var tokenInputs = this.createTokenInputs(
		// this.getControlContainer( 'cb_token_inputs' ).childNodes[0]
		parameters[ positions[0] ],
		// this.getControlContainer( 'cb_token_inputs' ).childNodes[1]
		parameters[ positions[1] ],
		// this.getControlContainer( 'cb_token_inputs' ).childNodes[2]
		parameters[ positions[2] ]
	);
	this.node.appendChild( tokenInputs );
}
/***
 * toString() polymorphic prototypes (initialized in the constructor of CB_Token)
***/
/* operator */
CB_Token.prototype.OpToString = function() {
	return this.op;
}
/* decoded operator */
CB_Token.prototype.BracketToString = function() {
	if ( this.op == 'lbracket' ) { return '('; }
	if ( this.op == 'rbracket' ) { return ')'; }
	return 'error';
}
/* two operands and operator */
CB_Token.prototype.Op2ToString = function() {
	return this.op+this.field+this.number;
}
/*
 * returns a paste type (which is the similar to token type, just l/r brackets are separated types)
 */
CB_Token.prototype.getPasteType = function() {
	if ( this.type != 'bracket' ) {
		return this.type;
	} else {
		return this.op;
	}
}
/* end of CB_Token */

/***
 * condition edit line constructor
 * @param type - type of edit line ('condition', 'samples') used to initialize polymorphic methods
 * @param domContainer - visual DOM container of editor expression
 * @param lineInstanceName - name of property ( CB_ConditionEditor[lineInstanceName] )
 */
function CB_EditLine( type, domContainer, lineInstanceName ) {
	this.type = type;
	// editor expression visual container
	this.node = domContainer;
	this.node.setAttribute( 'lineinstancename', lineInstanceName );
	// array of generated token objects (currently edited expression)
	this.tokens = new Array();
	// {{{ token highlighting (currently only single token, because the clipboard is single token)
	// note: currently implemented and used only for type='samples'
	this.hilitedIndex = -1;
	this.savedTokenColors = { 'color': '', 'bgr': '' };
	// }}}
	switch ( type ) {
	case 'condition' :
		this.view = CB_EditLine.prototype.viewCondition;
		this.viewCached = CB_EditLine.prototype.viewCachedCondition;
		this.doEdit = CB_EditLine.prototype.doEditCondition;
		break;
	case 'samples' :
		this.view = CB_EditLine.prototype.viewSamples;
		this.viewCached = CB_EditLine.prototype.viewCachedSamples;
		this.doEdit = CB_EditLine.prototype.doEditSamples;
		break;
	default :
		alert( 'Unknown type='+type+' in CB_EditLine constructor' );
		return;
	}
}
/*
 * view current expression (completely)
 *     also re-indexes tokens, because they might have been moved in doEdit() calls
 *     should be performing cleanly consequently
 *     used for the visual updating after editing / moving / inserting / deleting / adding tokens in this.tokens array
 */
CB_EditLine.prototype.viewCondition = function() {
	var cbFirst, cbLast, cb, cbAll;
	// add paste buttons, when these are available
	if ( CB_ConditionEditor.clipboard == '' ) {
		cbFirst = { 'right': '→', 'remove': 'x' };
		cbLast = { 'left': '←', 'remove': 'x' };
		cb = { 'left': '←', 'right': '→', 'remove': 'x' };
		cbAll = {};
	} else {
		cbFirst = { 'right': '→', 'paste': '+' };
		cbLast = { 'left': '←', 'paste': '+', 'paste_right': '>+' };
		cb = { 'left': '←', 'right': '→', 'paste': '+' };
		cbAll = { 'paste': '+' };
	}
	var i;
	this.node.innerHTML = '';
	for ( i = 0; i < this.tokens.length; i++ ) {
		this.tokens[i].setIndex( i );
		if ( this.tokens[i].type == 'select' ) {
			this.tokens[i].buildNode( cbAll );
		} else {
			if ( i == 0 ) {
				this.tokens[i].buildNode( cbFirst );
			} else if ( i == this.tokens.length - 1 ) {
				this.tokens[i].buildNode( cbLast );
			} else {
				this.tokens[i].buildNode( cb );
			}
		}
		this.node.appendChild( this.tokens[i].node );
	}
	var errorPos = this.validate();
	this.applyButton( errorPos == -1 );
}
CB_EditLine.prototype.viewSamples = function( cachedIndex ) {
	var i;
	this.node.innerHTML = '';
	for ( i = 0; i < this.tokens.length; i++ ) {
		this.tokens[i].setIndex( i );
		if ( this.tokens[i].type == 'select' ) {
			this.tokens[i].buildNode( { 'clear': '=' } );
		} else {
			this.tokens[i].buildNode( { 'copy': '+', 'append': '>+' } );
		}
		this.node.appendChild( this.tokens[i].node );
	}
}
/*** prototypes of polymorphic viewCached method ***/
CB_EditLine.prototype.viewCachedCondition = function( cachedIndex ) {
	if ( CB_Setup.isIE < 9  ) {
		// cached rendering optimization does not works in IE 8, unfortunately
		// TODO: check in IE9
		// https://developer.mozilla.org/en/Browser_Detection_and_Cross_Browser_Support
		// http://msdn.microsoft.com/en-us/library/ms537509(VS.85).aspx
		return;
	}
	this.viewCachedSamples( cachedIndex );
	var errorPos = this.validate();
	this.applyButton( errorPos == -1 );
}
/*
 * @param cachedIndex - optional index of token in this.tokens that
 *     should not be regenerated but taken from already built token node instead
 *     enables to view partially cached expression (during various events in token node)
 *     also does not re-build dynamic text input fields, otherwise these may lose their values
 */
CB_EditLine.prototype.viewCachedSamples = function( cachedIndex ) {
	if ( CB_Setup.isIE < 9  ) {
		// cached rendering optimization does not works in IE 8, unfortunately
		// TODO: check in IE9
		// https://developer.mozilla.org/en/Browser_Detection_and_Cross_Browser_Support
		// http://msdn.microsoft.com/en-us/library/ms537509(VS.85).aspx
		return;
	}
	var i;
	var idx = ( typeof cachedIndex == 'undefined' ) ? -1 : cachedIndex;
	this.node.innerHTML = '';
	for ( i = 0; i < this.tokens.length; i++ ) {
		if ( i != idx ) {
			// cached (partial) node build (see buildNode prototypes)
			this.tokens[i].buildNodeCached();
		}
		this.node.appendChild( this.tokens[i].node );
	}
}
CB_EditLine.prototype.applyButton = function( isEnabled ) {
	var div = document.createElement( 'div' );
	div.className = 'cb_token_container';
	div.style.marginBottom = '0.5em';
	var applyButton = document.createElement( 'input' );
	applyButton.setAttribute( 'type', 'button' );
	applyButton.setAttribute( 'id', 'cb_apply_button' );
	applyButton.setAttribute( 'value', CB_ConditionEditor.localMessages[ 'apply_button' ] );
	if ( !isEnabled ) {
		div.style.color = CB_Setup.colors.error.color;
		div.style.backgroundColor = CB_Setup.colors.error.bgr;
		applyButton.disabled = !isEnabled;
	}
	CB_lib.addEvent( applyButton, 'click', CB_ConditionEditor.applyButtonClick );
	div.appendChild( applyButton );
	var buttonContainer = this.node.parentNode.lastChild;
	buttonContainer.innerHTML = '';
	buttonContainer.appendChild( div );
}
CB_EditLine.prototype.showPopupControls = function( currentIndex ) {
	var popupControls;
	for ( var i = 0; i < this.tokens.length; i++ ) {
		popupControls = this.tokens[i].getControlContainer( 'cb_popup_controls' );
		popupControls.style.visibility = (i == currentIndex) ? 'visible' : 'hidden';
	}
}
/*
 * set / reset currently highlighted token
 * @param index - index of this.tokens[]; use value = -1 to reset highlighting completely
 * @param colors - object { 'color':color, 'bgr':background} - color, background color of highlighted token
 */
CB_EditLine.prototype.setHighlight = function( index, colors ) {
	// restore original colors of previousely highlighted token
	if ( this.hilitedIndex >= 0 && this.hilitedIndex < this.tokens.length ) {
		this.tokens[ this.hilitedIndex ].setColors( this.savedTokenColors );
	}
	if ( index >= 0 && index < this.tokens.length ) {
		// save original colors of new highlighted token
		// we need a copy of properties, not a source object reference!
		this.savedTokenColors.color = this.tokens[ index ].colors.color;
		this.savedTokenColors.bgr = this.tokens[ index ].colors.bgr;
		// set new highlighted token
		this.hilitedIndex = index;
		this.tokens[ index ].setColors( colors );
	} else {
		this.hilitedIndex = -1;
	}
}
/***
 * tokens move / remove section (expression editor)
***/
CB_EditLine.prototype.doEditCondition = function( currentIndex, editOp ) {
	CB_lib.log( 'editOp='+editOp+' token index='+currentIndex );
	// remove previous erroneous highlighted tokens, there will be new ones or no one
	this.setHighlight( -1 );
	switch ( editOp ) {
		case 'left' : this.tokenLeft( currentIndex ); break;
		case 'right' : this.tokenRight( currentIndex ); break;
		case 'remove' : this.tokenRemove( currentIndex ); break;
		case 'paste': this.tokenPaste( currentIndex ); break;
		case 'paste_right': this.tokenPaste( currentIndex + 1 ); break;
		default :
			alert( 'Unknown editOp='+editOp+' in CB_EditLine.prototype.doEditCondition' );
	}
	// re-index & view is a MUST after edit operations
	this.view();
}
CB_EditLine.prototype.doEditSamples = function( currentIndex, editOp ) {
	CB_lib.log( 'editOp='+editOp+' token index='+currentIndex );
	switch ( editOp ) {
		case 'append' :
		case 'clear' : // 'clear' is 'append' called with token 'select all', only edit hints are different
			this.tokenCopy( currentIndex );
			CB_ConditionEditor.conditionLine.doEdit( CB_ConditionEditor.conditionLine.tokens.length, 'paste' );
			break;
		case 'copy' :
			this.tokenCopy( currentIndex );
			break;
		default :
			alert( 'Unknown editOp='+editOp+' in CB_EditLine.prototype.doEditSamples' );
	}
	this.view();
}
CB_EditLine.prototype.tokenCopy = function( currentIndex ) {
	var tokenStr = this.tokens[ currentIndex ].toString();
	if ( CB_ConditionEditor.clipboard != tokenStr ) {
		// highlight clicked token to indicate it's being copied
		this.setHighlight( currentIndex, CB_Setup.colors.copy );
		// set clipboard string
		CB_ConditionEditor.clipboard = tokenStr;
	} else {
		// attempt to paste the same value twice, clear the selection
		CB_ConditionEditor.clearSelection();
	}
	// refresh condition line to display / hide paste buttons (these are available only when clipboard is not empty)
	CB_ConditionEditor.conditionLine.view();
}
CB_EditLine.prototype.tokenPaste = function( currentIndex ) {
	var pastedToken = new CB_Token( CB_ConditionEditor.clipboard, 'conditionLine', currentIndex );
	if ( this.doPaste( pastedToken ) ) {
		// paste was successful, clear the selection
		CB_ConditionEditor.clearSelection();
	}
}
CB_EditLine.allowedPaste = {
// paste is being performed between 'prev' and 'curr'
// key 'curr' may be equal to 'next' sometimes (when the token inbetween is being checked)
// allowedPaste key is PasteType of new (inserted) token
// see this.validate() for usage
// curr.notexists is lastpos, prev.notexists is pos0
	'lbracket' : {
		'curr': { 'notexists': false, 'lbracket': true, 'rbracket': false, 'logic': false, 'comparsion': true },
		'prev': { 'notexists': true, 'lbracket': true, 'rbracket': false, 'logic': true, 'comparsion': false }
	},
	'rbracket' : {
		'curr': { 'notexists': true, 'lbracket': false, 'rbracket': true, 'logic': true, 'comparsion': false },
		'prev': { 'notexists': false, 'lbracket': false, 'rbracket': true, 'logic': false, 'comparsion': true }
	},
	'logic' : {
		'curr': { 'notexists': false, 'lbracket': true, 'rbracket': false, 'logic': false, 'comparsion': true },
		'prev': { 'notexists': false, 'lbracket': false, 'rbracket': true, 'logic': false, 'comparsion': true }
	},
	'comparsion' : {
		'curr': { 'notexists': true, 'lbracket': false, 'rbracket': true, 'logic': true, 'comparsion': true },
		'prev': { 'notexists': true, 'lbracket': true, 'rbracket': false, 'logic': true, 'comparsion': false }
	},
	'select' : {
		'curr': { 'notexists': true, 'lbracket': false, 'rbracket': false, 'logic': false, 'comparsion': false },
		'prev': { 'notexists': true, 'lbracket': false, 'rbracket': false, 'logic': false, 'comparsion': false }
	}
};
/*
 * validates current expression
 * @return errorPos = -1, when there are no errors, otherwise errorPos contains index of erroneous token
 */
CB_EditLine.prototype.validate = function() {
	var errorPos = -1;
	var lastBracketPos = -1;
	var bracketsLevel = 0;
	var prevToken, nextToken, currToken;
	var currType, prevType, currType; // paste types, not token.type !
	for ( var i = 0; i < this.tokens.length; i++ ) {
		currToken = this.tokens[i];
		currType = currToken.getPasteType();
		prevToken = this.getToken( i - 1 );
		prevType = (prevToken == null) ? 'notexists' : prevToken.getPasteType();
		nextToken = this.getToken( i + 1 );
		nextType = (nextToken == null) ? 'notexists' : nextToken.getPasteType();
		// check brackets nesting
		if ( currToken.type == 'bracket' ) {
			lastBracketPos = i;
			if ( currToken.op == 'lbracket' ) {
				bracketsLevel++;
			} else { // this.tokens[i].op == 'rbracket'
				bracketsLevel--;
			}
		}
		if ( errorPos == -1 && bracketsLevel < 0 ) {
			errorPos = i;
		}
		// check, whether the token "fits" to the current position
		if ( !CB_EditLine.allowedPaste[ currType ].curr[ nextType ] ||
				!CB_EditLine.allowedPaste[ currType ].prev[ prevType ] ) {
			errorPos = i;
		}
	}
	if ( errorPos == -1 && bracketsLevel != 0 ) {
		errorPos = lastBracketPos;
	}
	this.setHighlight( errorPos, CB_Setup.colors.error );
	return errorPos;
}
/*
 * try to paste new token at the selected position
 * @param newToken - instance of CB_Token
 *     newToken.index indicates "desired" position (may be corrected in this method)
 * @return true, when paste was successful, false otherwise
 */
CB_EditLine.prototype.doPaste = function( newToken ) {
	var currToken = this.getToken( newToken.index );
	var prevToken = this.getToken( newToken.index - 1 );
	var currType = (currToken == null) ? 'notexists' : currToken.getPasteType();
	var prevType = (prevToken == null) ? 'notexists' : prevToken.getPasteType();
	var newType = newToken.getPasteType();
	switch ( newType ) {
	case 'lbracket' :
	case 'rbracket' :
	case 'logic' :
	case 'comparsion' :
		break;
	case 'select' :
		// "select all" clears the whole condition line when being pasted
		this.tokens = [ new CB_Token( 'all', 'conditionLine', 0 ) ];
		return true;
	default :
		alert( 'Unimplemented token type='+newToken.type+' in CB_EditLine.doPaste' );
		return true;
	}
	if ( currType == 'select' || prevType == 'select' ) {
		// "select all" disappears when pasting over it
		newToken.setIndex( 0 );
		this.tokens = [ newToken ];
		return true;
	}
	// allow to paste at 0 & last index of expression ( 'notexists' )
	// at all other indexes allow to paste only when newToken "fits" between prevToken and currToken
	if ( currType == 'notexists' || prevType == 'notexists' ||
			( CB_EditLine.allowedPaste[ newType ].curr[ currType ] &&
				CB_EditLine.allowedPaste[ newType ].prev[ prevType ] ) ) {
		return this.insertToken( newToken );
	}
	return false;
}
CB_EditLine.prototype.tokenLeft = function( currentIndex ) {
	var movedToken = this.tokens[ currentIndex ];
	// move single token by default
	var movedTypes = [ movedToken.getPasteType() ];
	var currToken, currType;
	var prevToken, prevType;
	var nextToken, nextType;
	var i;
	if ( movedTypes[ 0 ] == 'select' || currentIndex == 0 ) {
		return;
	}
	switch ( movedTypes[ 0 ] ) {
	case 'logic' :
		nextToken = this.getToken( currentIndex + 1 );
		nextType = (nextToken == null) ? 'notexists' : nextToken.getPasteType();
		if ( nextType != 'comparsion' ) {
			return;
		}
		// move current 'logic' and next 'comparsion' token
		movedTypes.push( nextType );
		break;
	case 'comparsion' :
		prevToken = this.getToken( currentIndex - 1 );
		prevType = (prevToken == null) ? 'notexists' : prevToken.getPasteType();
		if ( prevType != 'logic' ) {
			return;
		}
		// move previous 'logic' and current 'comparsion' token
		movedTypes.unshift( prevType );
		// start to move from previous token
		currentIndex--;
		break;
	}
	for ( i = currentIndex - 1; i >= 0; i-- ) {
		prevToken = this.getToken( i - 1 );
		currToken = this.getToken( i );
		currType = (currToken == null) ? 'notexists' : currToken.getPasteType();
		prevType = (prevToken == null) ? 'notexists' : prevToken.getPasteType();
		if ( CB_EditLine.allowedPaste[ movedTypes[ movedTypes.length - 1 ] ].curr[ currType ] &&
				CB_EditLine.allowedPaste[ movedTypes[ 0 ] ].prev[ prevType ] ) {
			if ( this.moveTokens( currentIndex, i, movedTypes.length ) ) { return; }
		}
	}
}
CB_EditLine.prototype.tokenRight = function( currentIndex ) {
	var movedToken = this.tokens[ currentIndex ];
	// move single token by default
	var movedTypes = [ movedToken.getPasteType() ];
	var currToken, currType;
	var prevToken, prevType;
	var nextToken, nextType;
	var i;
	if ( movedTypes[ 0 ] == 'select' || currentIndex == this.tokens.length - 1 ) {
		return;
	}
	switch ( movedTypes[ 0 ] ) {
	case 'logic' :
		nextToken = this.getToken( currentIndex + 1 );
		nextType = (nextToken == null) ? 'notexists' : nextToken.getPasteType();
		if ( nextType != 'comparsion' ) {
			return;
		}
		// move current 'logic' and next 'comparsion' token
		movedTypes.push( nextType );
		break;
	case 'comparsion' :
		prevToken = this.getToken( currentIndex - 1 );
		prevType = (prevToken == null) ? 'notexists' : prevToken.getPasteType();
		if ( prevType != 'logic' ) {
			return;
		}
		// move previous 'logic' and current 'comparsion' token
		movedTypes.unshift( prevType );
		// start to move from previous token
		currentIndex--;
		break;
	}
	for ( i = currentIndex + 1; i <= this.tokens.length; i++ ) {
		prevToken = this.getToken( i - 1 );
		currToken = this.getToken( i );
		currType = (currToken == null) ? 'notexists' : currToken.getPasteType();
		prevType = (prevToken == null) ? 'notexists' : prevToken.getPasteType();
		if ( CB_EditLine.allowedPaste[ movedTypes[ movedTypes.length - 1 ] ].curr[ currType ] &&
				CB_EditLine.allowedPaste[ movedTypes[ 0 ] ].prev[ prevType ] ) {
			if ( this.moveTokens( currentIndex, i, movedTypes.length ) ) { return; }
		}
	}
}
CB_EditLine.prototype.tokenRemove = function( currentIndex ) {
	var token = this.tokens[ currentIndex ];
	var type = token.type;
	var op = token.op;
	var i, bracketSublevel;
	switch ( type ) {
	case 'bracket' :
		bracketSublevel = 0;
		if ( op == 'lbracket' ) {
			// search for next matching rbracket, then delete the both
			for ( i = currentIndex + 1; i < this.tokens.length; i++ ) {
				if ( this.tokens[i].type == 'bracket' ) {
					if ( this.tokens[i].op == 'lbracket' ) {
						++bracketSublevel;
					} else { // this.tokens[i].op == 'rbracket' )
						if ( --bracketSublevel <= 0 ) {
							// the order of next two operations is important
							this.removeTokens( i, 1 );
							this.removeTokens( currentIndex, 1 );
							return;
						}
					}
				}
			}
		} else { // op == 'rbracket'
			// search for previous matching lbracket, then delete the both
			for ( i = currentIndex - 1; i >= 0; i-- ) {
				if ( this.tokens[i].type == 'bracket' ) {
					if ( this.tokens[i].op == 'rbracket' ) {
						--bracketSublevel;
					} else { // this.tokens[i].op == 'lbracket' )
						if ( ++bracketSublevel >= 0 ) {
							// the order of next two operations is important
							this.removeTokens( currentIndex, 1 );
							this.removeTokens( i, 1 );
							return;
						}
					}
				}
			}
		}
		break;
	case 'select' :
		return;
	case 'logic' :
		if ( currentIndex == 0 || currentIndex == this.tokens.length - 1 ) {
			break;
		}
		var p1 = this.tokens[currentIndex + 1];
		if ( p1.type == 'comparsion' ) {
			// remove current logical token and the next comparsion right to it
			this.removeTokens( currentIndex, 2 );
			return;
		}
		if ( p1.type != 'bracket' || p1.op != 'lbracket' ) {
			// next (right) token is not lbracket
			break;
		}
		// try to remove the whole subexpression right to current token
		bracketSublevel = 0;
		// search for next matching rbracket, then delete the whole subexpression and logic just before it (left side)
		for ( i = currentIndex + 1; i < this.tokens.length; i++ ) {
			if ( this.tokens[i].type == 'bracket' ) {
				if ( this.tokens[i].op == 'lbracket' ) {
					++bracketSublevel;
				} else { // this.tokens[i].op == 'rbracket' )
					if ( --bracketSublevel <= 0 ) {
						this.removeTokens( currentIndex, i - currentIndex + 1 );
						return;
					}
				}
			}
		}
		break;
	case 'comparsion' :
		if ( currentIndex == 0 ) {
			break;
		}
		if ( this.tokens[currentIndex - 1].type == 'logic' ) {
			// remove current comparsion and logical op before it
			this.removeTokens( currentIndex - 1, 2 );
			return;
		}
		if ( currentIndex <= 1 || currentIndex >= this.tokens.length - 1 ) {
			break;
		}
		var m2 = this.tokens[currentIndex - 2];
		var m1 = this.tokens[currentIndex - 1];
		var p1 = this.tokens[currentIndex + 1];
		if ( m2.type == 'logic' &&
				m1.type == 'bracket' && m1.op == 'lbracket' &&
				p1.type == 'bracket' && p1.op == 'rbracket' ) {
			// remove current comparsion with brackets around it and also logical op before it
			this.removeTokens( currentIndex - 2, 4 );
		}
		break;
	default :
		alert( 'Unimplemented token type='+token.type+' in CB_EditLine.tokenRemove' );
	}
	// "smart" remove was unsuccessful, delete only current token
	this.removeTokens( currentIndex, 1 );
	if ( this.tokens.length == 0 ) {
		// empty line becomes 'select' 'all'
		this.tokens = [ new CB_Token( 'all', 'conditionLine', 0 ) ];
	}
}
CB_EditLine.prototype.getToken = function( index ) {
	if ( index >= 0 && index < this.tokens.length ) {
		return this.tokens[ index ];
	} else {
		return null;
	}
}
/***
 * psysically changes this.tokens, from source parameters provided in control buttons handlers (defined just above)
***/
/* insert new token at selected position
 * @param newToken
 *     newToken.index indicates "desired" position (may be corrected in this method)
 * @return true, when paste was successful, false otherwise
 */
CB_EditLine.prototype.insertToken = function( newToken ) {
	if ( newToken.index >=0 && newToken.index <= this.tokens.length ) {
		this.tokens.splice( newToken.index, 0, newToken );
		return true;
	} else {
		alert( 'An attempt to insert token to non-defined index='+newToken.index+' in CB_EditLine.insertToken' );
		return false;
	}
}
/*
 * moves count of tokens from currentIndex to newIndex, tokens at newIndex are moved next to RIGHT
 * @param currentIndex source index in this.tokens
 * @param newIndex destination index in this.tokens
 * @param count number of tokens to move
 * @result true, move is complete; false, attempt to move into itself
 */
CB_EditLine.prototype.moveTokens = function( currentIndex, newIndex, count ) {
	if ( currentIndex <= newIndex && newIndex - currentIndex <= count ) {
		return false;
	}
	// save our tokens to temporary array
	var ourTokens = this.tokens.slice( currentIndex, currentIndex + count );
	if ( ourTokens.length != count ) {
		alert( 'Slice after the end of tokens array in CB_EditLine.moveTokens' );
		return true;
	}
	// remove our tokens from their current position
	this.tokens.splice( currentIndex, count );
	if ( newIndex > currentIndex ) {
		// correct newIndex, because we've already removed count of entries BEFORE newIndex
		newIndex -= count;
	}
	// insert our tokens into their new position, more already existing ones to RIGHT
	this.tokens = this.tokens.slice( 0, newIndex ).concat( ourTokens.concat( this.tokens.slice( newIndex ) ) );
	return true;
}
CB_EditLine.prototype.removeTokens = function( index, count ) {
	this.tokens.splice( index, count );
}
/***
 * end of tokens move / remove section (expression editor)
***/
CB_EditLine.prototype.getEncodedExpr = function() {
	var encodedExpr = '';
	var firstElem = true;
	for ( i = 0; i < this.tokens.length; i++ ) {
		if ( firstElem ) {
			firstElem = false;
		} else {
			encodedExpr += '_';
		}
		encodedExpr += this.tokens[i].toString();
	}
	return encodedExpr;
}

/***
 * condition editor
 */
var CB_ConditionEditor = {

	// local interface messages (object key/val pairs)
	// also includes local 'all' op and one/two operands operators templates
	localMessages : null,
	// messages for tokens control buttons
	localEditHints : null,
	// local views of tokens
	localDbFields : null, // local db fields
	localBrackets : null, // local expression brackets
	localBoolOps : null, // local boolean operator names
	localCmpOps : null, // local comparsion operators

	// CB_EditLine instance of currently edited expression
	conditionLine : null,
	// CB_EditLine instance of samples to add to currently edited expression
	samplesLine : null,
	// token string clipboard (single token to copy/paste)
	// TODO: implement clipboardLine? (multple tokens copy/paste with visual clipboard)
	clipboard : '',

	setLocalNames : function( localMessages, localEditHints, localDbFields, localBrackets, localBoolOps, localCmpOps ) {
		this.localMessages = localMessages;
		this.localEditHints = localEditHints;
		this.localDbFields = localDbFields;
		this.localBrackets = localBrackets;
		this.localBoolOps = localBoolOps;
		this.localCmpOps = localCmpOps;
	},

	/**
	 * creates a visual editor from encoded infix expression given
	 */
	createExpr : function( encInfixQueue ) {
		var i, ea, oToken;
		CB_lib.log( 'createExpr encInfixQueue='+encInfixQueue);
		ea = encInfixQueue.split( '_' );
		var cbEditorContainer = document.getElementById( 'cb_editor_container' );
		// show previousely hidden toolbox cell
		cbEditorContainer.parentNode.style.display = (CB_Setup.isIE > 7) ? 'table-cell' : 'block';
		// condition editor does not work in IE versions less than 7
		// better to upgrade than try to fix (IE6 produced "memory read errors" while executing CB_Token / CB_EditLine code)
		if ( CB_Setup.isIE < 7 ) {
			cbEditorContainer.innerHTML = '';
			var textNode = document.createTextNode( this.localMessages[ 'ie6_warning' ] );
			cbEditorContainer.appendChild( textNode );
			return;
		}
		// pass property name to CB_EditLine constructor,
		// otherwise event handlers won't be able to call() proper instance of CB_EditLine
		this.conditionLine = new CB_EditLine( 'condition', cbEditorContainer, 'conditionLine' );
		if ( ea.length > 0 ) {
			for ( i = 0; i < ea.length; i++ ) {
				// pass lineInstanceName and index to CB_Token constructor,
				// otherwise event handlers won't be able to call() proper instance of CB_Token
				oToken = new CB_Token( ea[i], 'conditionLine', i  );
				if ( oToken.type == 'undef' || oToken.type == 'select' ) {
					this.conditionLine.tokens = [ new CB_Token( 'all', 'conditionLine', 0 ) ];
					break;
				}
				this.conditionLine.tokens.push( oToken );
			}
		} else {
			this.conditionLine.tokens = [ new CB_Token( 'all', 'conditionLine', 0 ) ];
		}
		this.conditionLine.view();
		this.createEditSamples();
	},

	createEditSamples : function() {
		var i = 0;
		var cbEditorControls = document.getElementById( 'cb_samples_container' );
		// show previousely hidden toolbox cell
		cbEditorControls.parentNode.style.display = (CB_Setup.isIE > 7) ? 'table-cell' : 'block';
		this.samplesLine = new CB_EditLine( 'samples', cbEditorControls, 'samplesLine' );
//		commented out because does not works in IE7
//		this.samplesLine.node.style.borderTopColor = 'lightgray';
//		this.samplesLine.node.style.borderTopWidth = '2px';
//		this.samplesLine.node.style.borderTopStyle = 'dashed';
		// pass lineInstanceName and index to CB_Token constructor,
		// otherwise event handlers won't be able to call() proper instance of CB_Token
		this.samplesLine.tokens.push( new CB_Token( '(', 'samplesLine', i++, CB_Setup.colors.samples ) );
		this.samplesLine.tokens.push( new CB_Token( ')', 'samplesLine', i++, CB_Setup.colors.samples ) );
		this.samplesLine.tokens.push( new CB_Token( 'or', 'samplesLine', i++, CB_Setup.colors.samples ) );
		this.samplesLine.tokens.push( new CB_Token( 'and', 'samplesLine', i++, CB_Setup.colors.samples ) );
		this.samplesLine.tokens.push( new CB_Token( 'ges1', 'samplesLine', i++, CB_Setup.colors.samples ) );
		this.samplesLine.tokens.push( new CB_Token( 'all', 'samplesLine', i++, CB_Setup.colors.samples ) );
		this.samplesLine.view();
	},

	clearSelection : function() {
		this.clipboard = '';
		this.samplesLine.setHighlight( -1 );
	},

	applyButtonClick : function( event ) {
		var obj = CB_lib.getEventObj( event, true );
		obj.blur();
		// {{{ switch the context
		CB_ConditionEditor.submitExpr.call( CB_ConditionEditor );
		// switch the context }}}
	},

	submitExpr : function() {
		this.conditionLine.view();
		var encInfixQueue = this.conditionLine.getEncodedExpr();
		var appliedOption = CB_lib.getSelectOption( document.getElementById( 'cb_expr_select' ), encInfixQueue, 'infixexpr' );
		var setCookie = appliedOption == null ? 1 : 0;
		var param = [ encInfixQueue, CategoryBrowser.nameFilter, CategoryBrowser.nameFilterCI, CategoryBrowser.noParentsOnly, setCookie ];
		if ( CategoryBrowser.pagerLimit !== null ) {
			param.push( CategoryBrowser.pagerLimit );
		}
		CB_lib.log('destination encodedExpr='+param[0]);
		CB_lib.log('destination setCookie='+param[1]);
		CB_lib.log('destination pagerLimit='+param[2]);
		sajax_do_call( "CategoryBrowser::applyEncodedQueue", param, document.getElementById( 'cb_root_container' ) );
		if ( setCookie ) {
			sajax_do_call( "CategoryBrowser::generateSelectedOption", [encInfixQueue], CB_ConditionEditor.appendSelectedOption );
		}
	},

	/**
	 * @param request.responsetext html representation of select's option for new expression value just applied
	 */
	appendSelectedOption : function( request ) {
		// {{{ switch the context
		CB_ConditionEditor._appendSelectedOption.call( CB_ConditionEditor, this, request );
		// switch the context }}}
	},

	_appendSelectedOption : function( eventObj, request ) {
		if ( request.status != 200 ) {
			alert( 'Invalid AJAX response in CB_ConditionEditor._appendSelectedOption, request.status='+request.status );
			return;
		}
		// cannot create option node from innerHTML in IE
		var div = document.createElement( 'div' );
		div.innerHTML = request.responseText;
		div = div.firstChild; // get div received from PHP via AJAX result
		// cannot import innerHTML directly to select node in IE
		var option = document.createElement( 'option' );
		CategoryBrowser.rootCond = div.getAttribute( 'value' );
		option.setAttribute( 'value', CategoryBrowser.rootCond );
		option.setAttribute( 'selected', div.getAttribute( 'selected' ) );
		option.setAttribute( 'infixexpr', div.getAttribute( 'infixexpr' ) );
		option.innerHTML = div.innerHTML;
		document.getElementById( 'cb_expr_select' ).appendChild( option );
	}

} /* end of CB_ConditionEditor */
