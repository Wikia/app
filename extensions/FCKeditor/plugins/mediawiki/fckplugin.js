/*
 * FCKeditor - The text editor for Internet - http://www.fckeditor.net
 * Copyright (C) 2003-2007 Frederico Caldeira Knabben
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU General Public License Version 2 or later (the "GPL")
 *    http://www.gnu.org/licenses/gpl.html
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 *  - Mozilla Public License Version 1.1 or later (the "MPL")
 *    http://www.mozilla.org/MPL/MPL-1.1.html
 *
 * == END LICENSE ==
 *
 * Main MediaWiki integration plugin.
 *
 * Wikitext syntax reference:
 *	http://meta.wikimedia.org/wiki/Help:Wikitext_examples
 *	http://meta.wikimedia.org/wiki/Help:Advanced_editing
 *
 * MediaWiki Sandbox:
 *	http://www.mediawiki.org/wiki/Sandbox
 */

// Rename the "Source" buttom to "Wikitext".
FCKToolbarItems.RegisterItem( 'Source', new FCKToolbarButton( 'Source', 'Wikitext', null, FCK_TOOLBARITEM_ICONTEXT, true, true, 1 ) );

// Register our toolbar buttons.
var tbButton = new FCKToolbarButton( 'MW_Template', 'Template',  FCKLang.wikiBtnTemplate || 'Insert/Edit Template' );
tbButton.IconPath = FCKConfig.PluginsPath + 'mediawiki/images/tb_icon_template.gif';
FCKToolbarItems.RegisterItem( 'MW_Template', tbButton );

// Ref button
tbButton = new FCKToolbarButton( 'MW_Ref', 'Ref', FCKLang.wikiBtnReference || 'Insert/Edit Reference' );
tbButton.IconPath = FCKConfig.PluginsPath + 'mediawiki/images/tb_icon_ref.gif';
FCKToolbarItems.RegisterItem( 'MW_Ref', tbButton );
if ( !FCKConfig.showreferences ) { // hack to disable MW_Ref  button
	tbButton.Create = function(){ return 0; }
	tbButton.Disable  = function(){ return 0; }
	tbButton.RefreshState  = function(){ return 0; }
}

// References button
var FCKReferences = function(){};
FCKReferences.prototype.GetState = function(){ return ( FCK.EditMode == FCK_EDITMODE_WYSIWYG ? FCK_TRISTATE_OFF : FCK_TRISTATE_DISABLED ) };
FCKCommands.RegisterCommand( 'MW_References', new FCKReferences() );
tbButton = new FCKToolbarButton( 'MW_References', 'References', FCKLang.wikiBtnReferences || 'Insert <references /> tag', FCK_TOOLBARITEM_ICONTEXT,true, true, 1 );
tbButton.IconPath = FCKConfig.PluginsPath + 'mediawiki/images/tb_icon_ref.gif';
if ( !FCKConfig.showreferences ) { // hack to disable MW_References  button
	tbButton.Create = function(){ return 0; }
	tbButton.Disable  = function(){ return 0; }
	tbButton.RefreshState  = function(){ return 0; }
}

FCKReferences.prototype.Execute = function(){
	if ( FCK.EditMode != FCK_EDITMODE_WYSIWYG )
		return;

	FCKUndo.SaveUndoStep();

	var e = FCK.EditorDocument.createElement( 'span' );
	e.setAttribute( '_fck_mw_customtag', 'true' );
	e.setAttribute( '_fck_mw_tagname', 'references' );
	e.className = 'fck_mw_references';

	oFakeImage = FCK.InsertElement( FCKDocumentProcessor_CreateFakeImage( 'FCK__MWReferences', e ) );
}
FCKToolbarItems.RegisterItem( 'MW_References', tbButton );

// Signature button
var FCKSignature = function(){};
FCKSignature.prototype.GetState = function(){ return ( FCK.EditMode == FCK_EDITMODE_WYSIWYG ? FCK_TRISTATE_OFF : FCK_TRISTATE_DISABLED ) };
FCKCommands.RegisterCommand( 'MW_Signature', new FCKSignature() );
tbButton = new FCKToolbarButton( 'MW_Signature', 'Signature', FCKLang.wikiBtnSignature || 'Insert signature', FCK_TOOLBARITEM_ONLYICON,true, true, 1 );
tbButton.IconPath = FCKConfig.PluginsPath + 'mediawiki/images/tb_signature.gif';

FCKSignature.prototype.Execute = function(){
	if ( FCK.EditMode != FCK_EDITMODE_WYSIWYG )
		return;

	FCKUndo.SaveUndoStep();
	var e = FCK.EditorDocument.createElement( 'span' );
	e.className = 'fck_mw_signature';

	oFakeImage = FCK.InsertElement( FCKDocumentProcessor_CreateFakeImage( 'FCK__MWSignature', e ) );
}
FCKToolbarItems.RegisterItem( 'MW_Signature', tbButton );

tbButton = new FCKToolbarButton( 'MW_Math', 'Formula', FCKLang.wikiBtnFormula || 'Insert/Edit Formula' );
tbButton.IconPath = FCKConfig.PluginsPath + 'mediawiki/images/tb_icon_math.gif';
FCKToolbarItems.RegisterItem( 'MW_Math', tbButton );

tbButton = new FCKToolbarButton( 'MW_Source', 'Source', FCKLang.wikiBtnSourceCode || 'Insert/Edit Source Code' );
tbButton.IconPath = FCKConfig.PluginsPath + 'mediawiki/images/tb_icon_source.gif';
FCKToolbarItems.RegisterItem( 'MW_Source', tbButton );
if ( !FCKConfig.showsource ) { // hack to disable MW_Source  button
	tbButton.Create = function(){ return 0; }
	tbButton.Disable  = function(){ return 0; }
	tbButton.RefreshState  = function(){ return 0; }
}

tbButton = new FCKToolbarButton( 'MW_Special', 'Special Tag', FCKLang.wikiBtnSpecial || 'Insert/Edit Special Tag' );
tbButton.IconPath = FCKConfig.PluginsPath + 'mediawiki/images/tb_icon_special.gif';
FCKToolbarItems.RegisterItem( 'MW_Special', tbButton );

tbButton = new FCKToolbarButton( 'MW_Category', 'Categories', FCKLang.wikiBtnCategories || 'Insert/Edit categories' );
tbButton.IconPath = FCKConfig.PluginsPath + 'mediawiki/images/tb_icon_category.gif';
FCKToolbarItems.RegisterItem( 'MW_Category', tbButton );

// Override some dialogs.
FCKCommands.RegisterCommand( 'MW_Template', new FCKDialogCommand( 'MW_Template', ( FCKLang.wikiCmdTemplate || 'Template Properties' ), FCKConfig.PluginsPath + 'mediawiki/dialogs/template.html', 400, 330 ) );
FCKCommands.RegisterCommand( 'MW_Ref', new FCKDialogCommand( 'MW_Ref', ( FCKLang.wikiCmdReference || 'Reference Properties' ), FCKConfig.PluginsPath + 'mediawiki/dialogs/ref.html', 400, 250 ) );
FCKCommands.RegisterCommand( 'MW_Math', new FCKDialogCommand( 'MW_Math', ( FCKLang.wikiCmdFormula || 'Formula' ), FCKConfig.PluginsPath + 'mediawiki/dialogs/math.html', 400, 300 ) );
FCKCommands.RegisterCommand( 'MW_Special', new FCKDialogCommand( 'MW_Special', ( FCKLang.wikiCmdSpecial || 'Special Tag Properties' ), FCKConfig.PluginsPath + 'mediawiki/dialogs/special.html', 400, 330 ) );
FCKCommands.RegisterCommand( 'MW_Source', new FCKDialogCommand( 'MW_Source', ( FCKLang.wikiCmdSourceCode || 'Source Code Properties' ), FCKConfig.PluginsPath + 'mediawiki/dialogs/source.html', 720, 380 ) );
FCKCommands.RegisterCommand( 'Link', new FCKDialogCommand( 'Link', FCKLang.DlgLnkWindowTitle, FCKConfig.PluginsPath + 'mediawiki/dialogs/link.html', 400, 250 ) );
FCKCommands.RegisterCommand( 'MW_Category', new FCKDialogCommand( 'MW_Category', ( FCKLang.wikiCmdCategories || 'Categories' ), FCKConfig.PluginsPath + 'mediawiki/dialogs/category.html', 400, 500 ) );
FCKCommands.RegisterCommand( 'Image', new FCKDialogCommand( 'Image', FCKLang.DlgImgTitle, FCKConfig.PluginsPath + 'mediawiki/dialogs/image.html', 450, 300 ) );

FCKToolbarItems.OldGetItem = FCKToolbarItems.GetItem;

FCKToolbarItems.GetItem = function( itemName ){
	var oItem = FCKToolbarItems.LoadedItems[ itemName ];

	if ( oItem )
		return oItem;

	switch ( itemName ){
		case 'Bold':
			oItem = new FCKToolbarButton( 'Bold', FCKLang.Bold, null, null, true, true, 20 );
			break;
		case 'Italic':
			oItem = new FCKToolbarButton( 'Italic', FCKLang.Italic, null, null, true, true, 21 );
			break;
		case 'Underline':
			oItem = new FCKToolbarButton( 'Underline', FCKLang.Underline, null, null, true, true, 22 );
			break;
		case 'StrikeThrough':
			oItem = new FCKToolbarButton( 'StrikeThrough', FCKLang.StrikeThrough, null, null, true, true, 23 );
			break;
		case 'Link':
			oItem = new FCKToolbarButton( 'Link', FCKLang.InsertLinkLbl, FCKLang.InsertLink, null, true, true, 34 );
			break;

		default:
			return FCKToolbarItems.OldGetItem( itemName );
	}

	FCKToolbarItems.LoadedItems[ itemName ] = oItem;

	return oItem;
}

FCKToolbarButton.prototype.Click = function(){
	var oToolbarButton = this._ToolbarButton || this;

	// for some buttons, do something else instead...
	var CMode = false;
	if ( oToolbarButton.SourceView && ( FCK_EDITMODE_SOURCE == FCK.EditMode ) ){
		if ( !window.parent.popup )
			var oDoc = window.parent;
		else
			var oDoc = window.parent.popup;

		switch( oToolbarButton.CommandName ){
			case 'Bold':
				oDoc.FCKeditorInsertTags( '\'\'\'', '\'\'\'', 'Bold text', document );
				CMode = true;
				break;
			case 'Italic':
				oDoc.FCKeditorInsertTags( '\'\'', '\'\'', 'Italic text', document );
				CMode = true;
				break;
			case 'Underline':
				oDoc.FCKeditorInsertTags( '<u>', '</u>', 'Underlined text', document );
				CMode = true;
				break;
			case 'StrikeThrough':
				oDoc.FCKeditorInsertTags( '<strike>', '</strike>', 'Strikethrough text', document );
				CMode = true;
				break;
			case 'Link':
				oDoc.FCKeditorInsertTags ('[[', ']]', 'Internal link', document );
				CMode = true;
				break;
		}
	}

	if ( !CMode )
		FCK.ToolbarSet.CurrentInstance.Commands.GetCommand( oToolbarButton.CommandName ).Execute();
}

// MediaWiki Wikitext Data Processor implementation.
FCK.DataProcessor = {
	_inPre : false,
	_inLSpace : false,

	/**
	 * Returns a string representing the HTML format of "data". The returned
	 * value will be loaded in the editor.
	 * The HTML must be from <html> to </html>, eventually including
	 * the DOCTYPE.
	 *     @param {String} data The data to be converted in the
	 *            DataProcessor specific format.
	 */
	ConvertToHtml : function( data ){
		// Call the original code.
		return FCKDataProcessor.prototype.ConvertToHtml.call( this, data );
	},

	/**
	 * Converts a DOM (sub-)tree to a string in the data format.
	 *     @param {Object} rootNode The node that contains the DOM tree to be
	 *            converted to the data format.
	 *     @param {Boolean} excludeRoot Indicates that the root node must not
	 *            be included in the conversion, only its children.
	 *     @param {Boolean} format Indicates that the data must be formatted
	 *            for human reading. Not all Data Processors may provide it.
	 */
	ConvertToDataFormat : function( rootNode, excludeRoot, ignoreIfEmptyParagraph, format ){
		// rootNode is <body>.

		// Normalize the document for text node processing (except IE - #1586).
		if ( !FCKBrowserInfo.IsIE )
			rootNode.normalize();

		var stringBuilder = new Array();
		this._AppendNode( rootNode, stringBuilder, '' );
		return stringBuilder.join( '' ).RTrim().replace(/^\n*/, "");
	},

	/**
	 * Makes any necessary changes to a piece of HTML for insertion in the
	 * editor selection position.
	 *     @param {String} html The HTML to be fixed.
	 */
	FixHtml : function( html ){
		return html;
	},

	// Collection of element definitions:
	//		0 : Prefix
	//		1 : Suffix
	//		2 : Ignore children
	_BasicElements : {
		body	: [ ],
		b		: [ "'''", "'''" ],
		strong	: [ "'''", "'''" ],
		i		: [ "''", "''" ],
		em		: [ "''", "''" ],
		p		: [ '\n', '\n' ],
		h1		: [ '\n= ', ' =\n' ],
		h2		: [ '\n== ', ' ==\n' ],
		h3		: [ '\n=== ', ' ===\n' ],
		h4		: [ '\n==== ', ' ====\n' ],
		h5		: [ '\n===== ', ' =====\n' ],
		h6		: [ '\n====== ', ' ======\n' ],
		br		: [ '<br>', null, true ],
		hr		: [ '\n----\n', null, true ]
	} ,

	// This function is based on FCKXHtml._AppendNode.
	_AppendNode : function( htmlNode, stringBuilder, prefix ){
		if ( !htmlNode )
			return;

		switch ( htmlNode.nodeType ){
			// Element Node.
			case 1 :

				// Here we found an element that is not the real element, but a
				// fake one (like the Flash placeholder image), so we must get the real one.
				if ( htmlNode.getAttribute('_fckfakelement') && !htmlNode.getAttribute( '_fck_mw_math' ) )
					return this._AppendNode( FCK.GetRealElement( htmlNode ), stringBuilder );

				// Mozilla insert custom nodes in the DOM.
				if ( FCKBrowserInfo.IsGecko && htmlNode.hasAttribute( '_moz_editor_bogus_node' ) )
					return;

				// This is for elements that are instrumental to FCKeditor and
				// must be removed from the final HTML.
				if ( htmlNode.getAttribute( '_fcktemp' ) )
					return;

				// Get the element name.
				var sNodeName = htmlNode.tagName.toLowerCase();

				if ( FCKBrowserInfo.IsIE ){
					// IE doens't include the scope name in the nodeName. So, add the namespace.
					if ( htmlNode.scopeName && htmlNode.scopeName != 'HTML' && htmlNode.scopeName != 'FCK' )
						sNodeName = htmlNode.scopeName.toLowerCase() + ':' + sNodeName;
				} else {
					if ( sNodeName.StartsWith( 'fck:' ) )
						sNodeName = sNodeName.Remove( 0, 4 );
				}

				// Check if the node name is valid, otherwise ignore this tag.
				// If the nodeName starts with a slash, it is a orphan closing tag.
				// On some strange cases, the nodeName is empty, even if the node exists.
				if ( !FCKRegexLib.ElementName.test( sNodeName ) )
					return;

				if ( sNodeName == 'br' && ( this._inPre || this._inLSpace ) ){
					stringBuilder.push( "\n" );
					if ( this._inLSpace )
						stringBuilder.push( " " );
					return;
				}

				// Remove the <br> if it is a bogus node.
				if ( sNodeName == 'br' && htmlNode.getAttribute( 'type', 2 ) == '_moz' )
					return;

				// The already processed nodes must be marked to avoid then to be duplicated (bad formatted HTML).
				// So here, the "mark" is checked... if the element is Ok, then mark it.
				if ( htmlNode._fckxhtmljob && htmlNode._fckxhtmljob == FCKXHtml.CurrentJobNum )
					return;

				var basicElement = this._BasicElements[ sNodeName ];
				if ( basicElement ){
					var basic0 = basicElement[0];
					var basic1 = basicElement[1];

					if ( ( basicElement[0] == "''" || basicElement[0] == "'''" ) && stringBuilder.length > 2 ){
						var pr1 = stringBuilder[stringBuilder.length-1];
						var pr2 = stringBuilder[stringBuilder.length-2];

						if ( pr1 + pr2 == "'''''") {
							if ( basicElement[0] == "''" ){
								basic0 = '<i>';
								basic1 = '</i>';
							}
							if ( basicElement[0] == "'''" ){
								basic0 = '<b>';
								basic1 = '</b>';
							}
						}
					}

					if ( basic0 )
						stringBuilder.push( basic0 );

					var len = stringBuilder.length;

					if ( !basicElement[2] ){
						this._AppendChildNodes( htmlNode, stringBuilder, prefix );
						// only empty element inside, remove it to avoid quotes
						if ( ( stringBuilder.length == len || ( stringBuilder.length == len + 1 && !stringBuilder[len].length ) )
							&& basicElement[0] && basicElement[0].charAt(0) == "'" ){
							stringBuilder.pop();
							stringBuilder.pop();
							return;
						}
					}

					if ( basic1 )
						stringBuilder.push( basic1 );
				} else {
					switch ( sNodeName ){
						case 'ol' :
						case 'ul' :
							var isFirstLevel = !htmlNode.parentNode.nodeName.IEquals( 'ul', 'ol', 'li', 'dl', 'dt', 'dd' );

							this._AppendChildNodes( htmlNode, stringBuilder, prefix );

							if ( isFirstLevel && stringBuilder[ stringBuilder.length - 1 ] != "\n" ) {
								stringBuilder.push( '\n' );
							}

							break;

						case 'li' :

							if( stringBuilder.length > 1 ){
								var sLastStr = stringBuilder[ stringBuilder.length - 1 ];
								if ( sLastStr != ";" && sLastStr != ":" && sLastStr != "#" && sLastStr != "*" )
 									stringBuilder.push( '\n' + prefix );
							}

							var parent = htmlNode.parentNode;
							var listType = "#";

							while ( parent ){
								if ( parent.nodeName.toLowerCase() == 'ul' ){
									listType = "*";
									break;
								} else if ( parent.nodeName.toLowerCase() == 'ol' ){
									listType = "#";
									break;
								}
								else if ( parent.nodeName.toLowerCase() != 'li' )
									break;

								parent = parent.parentNode;
							}

							stringBuilder.push( listType );
							this._AppendChildNodes( htmlNode, stringBuilder, prefix + listType );

							break;

						case 'a' :

							var pipeline = true;
							// Get the actual Link href.
							var href = htmlNode.getAttribute( '_fcksavedurl' );
							var hrefType = htmlNode.getAttribute( '_fck_mw_type' ) || '';

							if ( href == null )
								href = htmlNode.getAttribute( 'href' , 2 ) || '';

							var isWikiUrl = true;

							if ( hrefType == "media" )
								stringBuilder.push( '[[Media:' );
							else if ( htmlNode.className == "extiw" ){
								stringBuilder.push( '[[' );
								var isWikiUrl = true;
							} else {
								var isWikiUrl = !( href.StartsWith( 'mailto:' ) || /^\w+:\/\//.test( href ) );
								stringBuilder.push( isWikiUrl ? '[[' : '[' );
							}
							// #2223
							if( htmlNode.getAttribute( '_fcknotitle' ) && htmlNode.getAttribute( '_fcknotitle' ) == "true" ){
								var testHref = FCKConfig.ProtectedSource.Revert( href, 0 );
								var testInner = FCKConfig.ProtectedSource.Revert( htmlNode.innerHTML, 0 );
								if ( href.toLowerCase().StartsWith( 'category:' ) )
									testInner = 'Category:' + testInner;
								if ( testHref.toLowerCase().StartsWith( 'rtecolon' ) )
									testHref = testHref.replace( /rtecolon/, ":" );
								testInner = testInner.replace( /&amp;/, "&" );
								if ( testInner == testHref )
									pipeline = false;
							}
							if( href.toLowerCase().StartsWith( 'rtecolon' ) ){ // change 'rtecolon=' => ':' in links
								stringBuilder.push(':');
								href = href.substring(8);
							}
							stringBuilder.push( href );
							if ( pipeline && htmlNode.innerHTML != '[n]' && ( !isWikiUrl || href != htmlNode.innerHTML || !href.toLowerCase().StartsWith( "category:" ) ) ){
								stringBuilder.push( isWikiUrl? '|' : ' ' );
								this._AppendChildNodes( htmlNode, stringBuilder, prefix );
							}
							stringBuilder.push( isWikiUrl ? ']]' : ']' );

							break;

						case 'dl' :

							this._AppendChildNodes( htmlNode, stringBuilder, prefix );
							var isFirstLevel = !htmlNode.parentNode.nodeName.IEquals( 'ul', 'ol', 'li', 'dl', 'dd', 'dt' );
							if ( isFirstLevel && stringBuilder[ stringBuilder.length - 1 ] != "\n" )
								stringBuilder.push( '\n' );

							break;

						case 'dt' :

							if( stringBuilder.length > 1 ){
								var sLastStr = stringBuilder[ stringBuilder.length - 1 ];
								if ( sLastStr != ";" && sLastStr != ":" && sLastStr != "#" && sLastStr != "*" )
 									stringBuilder.push( '\n' + prefix );
							}
							stringBuilder.push( ';' );
							this._AppendChildNodes( htmlNode, stringBuilder, prefix + ";" );

							break;

						case 'dd' :

							if( stringBuilder.length > 1 ){
								var sLastStr = stringBuilder[ stringBuilder.length - 1 ];
								if ( sLastStr != ";" && sLastStr != ":" && sLastStr != "#" && sLastStr != "*" )
 									stringBuilder.push( '\n' + prefix );
							}
							stringBuilder.push( ':' );
							this._AppendChildNodes( htmlNode, stringBuilder, prefix + ":" );

							break;

						case 'table' :

							var attribs = this._GetAttributesStr( htmlNode );

							stringBuilder.push( '\n{|' );
							if ( attribs.length > 0 )
								stringBuilder.push( attribs );
							stringBuilder.push( '\n' );

							if ( htmlNode.caption && htmlNode.caption.innerHTML.length > 0 ){
								stringBuilder.push( '|+ ' );
								this._AppendChildNodes( htmlNode.caption, stringBuilder, prefix );
								stringBuilder.push( '\n' );
							}

							for ( var r = 0; r < htmlNode.rows.length; r++ ){
								attribs = this._GetAttributesStr( htmlNode.rows[r] );

								stringBuilder.push( '|-' );
								if ( attribs.length > 0 )
									stringBuilder.push( attribs );
								stringBuilder.push( '\n' );

								for ( var c = 0; c < htmlNode.rows[r].cells.length; c++ ){
									attribs = this._GetAttributesStr( htmlNode.rows[r].cells[c] );

									if ( htmlNode.rows[r].cells[c].tagName.toLowerCase() == "th" )
										stringBuilder.push( '!' );
									else
										stringBuilder.push( '|' );

									if ( attribs.length > 0 )
										stringBuilder.push( attribs + ' |' );

									stringBuilder.push( ' ' );

									this._IsInsideCell = true;
									this._AppendChildNodes( htmlNode.rows[r].cells[c], stringBuilder, prefix );
									this._IsInsideCell = false;

									stringBuilder.push( '\n' );
								}
							}

							stringBuilder.push( '|}\n' );

							break;

						case 'img' :

							var formula = htmlNode.getAttribute( '_fck_mw_math' );

							if ( formula && formula.length > 0 ){
								stringBuilder.push( '<math>' );
								stringBuilder.push( formula );
								stringBuilder.push( '</math>' );
								return;
							}

							var imgName		= htmlNode.getAttribute( '_fck_mw_filename' );
							var imgCaption	= htmlNode.getAttribute( 'alt' ) || '';
							var imgType		= htmlNode.getAttribute( '_fck_mw_type' ) || '';
							var imgLocation	= htmlNode.getAttribute( '_fck_mw_location' ) || '';
							var imgWidth	= htmlNode.getAttribute( '_fck_mw_width' ) || '';
							var imgHeight	= htmlNode.getAttribute( '_fck_mw_height' ) || '';
							var imgStyleWidth	= ( parseInt(htmlNode.style.width) || '' ) + '';
							var imgStyleHeight	= ( parseInt(htmlNode.style.height) || '' ) + '';
							var imgRealWidth	= ( htmlNode.getAttribute( 'width' ) || '' ) + '';
							var imgRealHeight	= ( htmlNode.getAttribute( 'height' ) || '' ) + '';

							stringBuilder.push( '[[Image:' );
							stringBuilder.push( imgName );

							if ( imgStyleWidth.length > 0 )
								imgWidth = imgStyleWidth;
							else if ( imgWidth.length > 0 && imgRealWidth.length > 0 )
								imgWidth = imgRealWidth;

							if ( imgStyleHeight.length > 0 )
								imgHeight = imgStyleHeight;
							else if ( imgHeight.length > 0 && imgRealHeight.length > 0 )
								imgHeight = imgRealHeight;

							if ( imgType.length > 0 )
								stringBuilder.push( '|' + imgType );

							if ( imgLocation.length > 0 )
								stringBuilder.push( '|' + imgLocation );

							if ( imgWidth.length > 0 ){
								stringBuilder.push( '|' + imgWidth );

								if ( imgHeight.length > 0 )
									stringBuilder.push( 'x' + imgHeight );

								stringBuilder.push( 'px' );
							}

							if ( imgCaption.length > 0 )
								stringBuilder.push( '|' + imgCaption );

							stringBuilder.push( ']]' );

							break;

						case 'span' :
							switch ( htmlNode.className ){
								case 'fck_mw_source' :
									var refLang = htmlNode.getAttribute( 'lang' );

									stringBuilder.push( '<source' );
									stringBuilder.push( ' lang="' + refLang + '"' );
									stringBuilder.push( '>' );
									stringBuilder.push( FCKTools.HTMLDecode(htmlNode.innerHTML).replace(/fckLR/g,'\r\n') );
									stringBuilder.push( '</source>' );
									return;

								case 'fck_mw_ref' :
									var refName = htmlNode.getAttribute( 'name' );

									stringBuilder.push( '<ref' );

									if ( refName && refName.length > 0 )
										stringBuilder.push( ' name="' + refName + '"' );

									if ( htmlNode.innerHTML.length == 0 )
										stringBuilder.push( ' />' );
									else {
										stringBuilder.push( '>' );
										stringBuilder.push( htmlNode.innerHTML );
										stringBuilder.push( '</ref>' );
									}
									return;

								case 'fck_mw_references' :
									stringBuilder.push( '<references />' );
									return;

								case 'fck_mw_signature' :
									stringBuilder.push( FCKConfig.WikiSignature );
									return;

								case 'fck_mw_template' :
									stringBuilder.push( FCKTools.HTMLDecode(htmlNode.innerHTML).replace(/fckLR/g,'\r\n') );
									return;

								case 'fck_mw_magic' :
									stringBuilder.push( htmlNode.innerHTML );
									return;

								case 'fck_mw_nowiki' :
									sNodeName = 'nowiki';
									break;

								case 'fck_mw_html' :
									sNodeName = 'html';
									break;

								case 'fck_mw_includeonly' :
									sNodeName = 'includeonly';
									break;

								case 'fck_mw_noinclude' :
									sNodeName = 'noinclude';
									break;

								case 'fck_mw_gallery' :
									sNodeName = 'gallery';
									break;

								case 'fck_mw_onlyinclude' :
									sNodeName = 'onlyinclude';

									break;
							}

							// Change the node name and fell in the "default" case.
							if ( htmlNode.getAttribute( '_fck_mw_customtag' ) )
								sNodeName = htmlNode.getAttribute( '_fck_mw_tagname' );

						case 'pre' :
							var attribs = this._GetAttributesStr( htmlNode );

							if ( htmlNode.className == "_fck_mw_lspace" ){
								stringBuilder.push( "\n " );
								this._inLSpace = true;
								this._AppendChildNodes( htmlNode, stringBuilder, prefix );
								this._inLSpace = false;
								var len = stringBuilder.length;
								if ( len > 1 ) {
									var tail = stringBuilder[len-2] + stringBuilder[len-1];
									if ( len > 2 ) {
										tail = stringBuilder[len-3] + tail;
									}
									if (tail.EndsWith("\n ")) {
										stringBuilder[len-1] = stringBuilder[len-1].replace(/ $/, "");
									} else if ( !tail.EndsWith("\n") ) {
										stringBuilder.push( "\n" );
									}
								}
							} else {
								stringBuilder.push( '<' );
								stringBuilder.push( sNodeName );

								if ( attribs.length > 0 )
									stringBuilder.push( attribs );
								if( htmlNode.innerHTML == '' )
									stringBuilder.push( ' />' );
								else {
									stringBuilder.push( '>' );
									this._inPre = true;
									this._AppendChildNodes( htmlNode, stringBuilder, prefix );
									this._inPre = false;

									stringBuilder.push( '<\/' );
									stringBuilder.push( sNodeName );
									stringBuilder.push( '>' );
								}
							}

							break;
						default :
							var attribs = this._GetAttributesStr( htmlNode );

							stringBuilder.push( '<' );
							stringBuilder.push( sNodeName );

							if ( attribs.length > 0 )
								stringBuilder.push( attribs );

							stringBuilder.push( '>' );
							this._AppendChildNodes( htmlNode, stringBuilder, prefix );
							stringBuilder.push( '<\/' );
							stringBuilder.push( sNodeName );
							stringBuilder.push( '>' );
							break;
					}
				}

				htmlNode._fckxhtmljob = FCKXHtml.CurrentJobNum;
				return;

			// Text Node.
			case 3 :

				var parentIsSpecialTag = htmlNode.parentNode.getAttribute( '_fck_mw_customtag' );
				var textValue = htmlNode.nodeValue;
				if ( !parentIsSpecialTag ){
					if ( FCKBrowserInfo.IsIE && this._inLSpace ) {
						textValue = textValue.replace( /\r/g, "\r " );
						if (textValue.EndsWith( "\r " )) {
							textValue = textValue.replace( /\r $/, "\r" );
						}
					}
					if ( !FCKBrowserInfo.IsIE && this._inLSpace ) {
						textValue = textValue.replace( /\n(?! )/g, "\n " );
					}

					if (!this._inLSpace && !this._inPre) {
						textValue = textValue.replace( /[\n\t]/g, ' ' );
					}

					textValue = FCKTools.HTMLEncode( textValue );
					textValue = textValue.replace( /\u00A0/g, '&nbsp;' );

					if ( ( !htmlNode.previousSibling ||
					( stringBuilder.length > 0 && stringBuilder[ stringBuilder.length - 1 ].EndsWith( '\n' ) ) ) && !this._inLSpace && !this._inPre ){
						textValue = textValue.LTrim();
					}

					if ( !htmlNode.nextSibling && !this._inLSpace && !this._inPre && ( !htmlNode.parentNode || !htmlNode.parentNode.nextSibling ) )
						textValue = textValue.RTrim();

					if( !this._inLSpace && !this._inPre )
						textValue = textValue.replace( / {2,}/g, ' ' );

					if ( this._inLSpace && textValue.length == 1 && textValue.charCodeAt(0) == 13 )
						textValue = textValue + " ";

					if ( !this._inLSpace && !this._inPre && textValue == " " ) {
						var len = stringBuilder.length;
						if( len > 1 ) {
							var tail = stringBuilder[len-2] + stringBuilder[len-1];
							if ( tail.toString().EndsWith( "\n" ) )
								textValue = '';
						}
					}

					if ( this._IsInsideCell ) {
						var result, linkPattern = new RegExp( "\\[\\[.*?\\]\\]", "g" );
						while( result = linkPattern.exec( textValue ) ) {
							textValue = textValue.replace( result, result.toString().replace( /\|/g, "<!--LINK_PIPE-->" ) );
						}
						textValue = textValue.replace( /\|/g, '&#124;' );
						textValue = textValue.replace( /<!--LINK_PIPE-->/g, '|' );
					}
				} else {
					textValue = FCKTools.HTMLDecode(textValue).replace(/fckLR/g,'\r\n');
				}

				stringBuilder.push( textValue );
				return;

			// Comment
			case 8 :
				// IE catches the <!DOTYPE ... > as a comment, but it has no
				// innerHTML, so we can catch it, and ignore it.
				if ( FCKBrowserInfo.IsIE && !htmlNode.innerHTML )
					return;

				stringBuilder.push( "<!--"  );

				try	{
					stringBuilder.push( htmlNode.nodeValue );
				} catch( e ) { /* Do nothing... probably this is a wrong format comment. */ }

				stringBuilder.push( "-->" );
				return;
		}
	},

	_AppendChildNodes : function( htmlNode, stringBuilder, listPrefix ){
		var child = htmlNode.firstChild;

		while ( child ){
			this._AppendNode( child, stringBuilder, listPrefix );
			child = child.nextSibling;
		}
	},

	_GetAttributesStr : function( htmlNode ){
		var attStr = '';
		var aAttributes = htmlNode.attributes;

		for ( var n = 0; n < aAttributes.length; n++ ){
			var oAttribute = aAttributes[n];

			if ( oAttribute.specified ){
				var sAttName = oAttribute.nodeName.toLowerCase();
				var sAttValue;

				// Ignore any attribute starting with "_fck".
				if ( sAttName.StartsWith( '_fck' ) )
					continue;
				// There is a bug in Mozilla that returns '_moz_xxx' attributes as specified.
				else if ( sAttName.indexOf( '_moz' ) == 0 )
					continue;
				// For "class", nodeValue must be used.
				else if ( sAttName == 'class' ){
					// Get the class, removing any fckXXX we can have there.
					sAttValue = oAttribute.nodeValue.replace( /(^|\s*)fck\S+/, '' ).Trim();

					if ( sAttValue.length == 0 )
						continue;
				} else if ( sAttName == 'style' && FCKBrowserInfo.IsIE ) {
					sAttValue = htmlNode.style.cssText.toLowerCase();
				}
				// XHTML doens't support attribute minimization like "CHECKED". It must be trasformed to cheched="checked".
				else if ( oAttribute.nodeValue === true )
					sAttValue = sAttName;
				else
					sAttValue = htmlNode.getAttribute( sAttName, 2 );	// We must use getAttribute to get it exactly as it is defined.

				// leave templates
				if ( sAttName.StartsWith( '{{' ) && sAttName.EndsWith( '}}' ) ) {
					attStr += ' ' + sAttName;
				} else {
					attStr += ' ' + sAttName + '="' + String(sAttValue).replace( '"', '&quot;' ) + '"';
				}
			}
		}
		return attStr;
	}
};

// Here we change the SwitchEditMode function to make the Ajax call when
// switching from Wikitext.
(function(){
	if( window.parent.showFCKEditor & ( 2 | 4 ) ){ // if popup or toggle link
		var original_ULF = FCK.UpdateLinkedField;
		FCK.UpdateLinkedField = function(){
			if( window.parent.showFCKEditor & 1 ){ // only if editor is up-to-date
				original_ULF.apply();
			}
		}
	}
	var original = FCK.SwitchEditMode;
	window.parent.oFCKeditor.ready = true;
	FCK.SwitchEditMode = function(){
		var args = arguments;
		window.parent.oFCKeditor.ready = false;
		var loadHTMLFromAjax = function( result ){
			FCK.EditingArea.Textarea.value = result.responseText;
			original.apply( FCK, args );
			window.parent.oFCKeditor.ready = true;
		}
		var edittools_markup = parent.document.getElementById( 'editpage-specialchars' );

		if ( FCK.EditMode == FCK_EDITMODE_SOURCE ){
			// Hide the textarea to avoid seeing the code change.
			FCK.EditingArea.Textarea.style.visibility = 'hidden';
			var loading = document.createElement( 'span' );
			loading.innerHTML = '&nbsp;'+ ( FCKLang.wikiLoadingWikitext || 'Loading Wikitext. Please wait...' ) + '&nbsp;';
			loading.style.position = 'absolute';
			loading.style.left = '5px';
//			loading.style.backgroundColor = '#ff0000';
			FCK.EditingArea.Textarea.parentNode.appendChild( loading, FCK.EditingArea.Textarea );
			// if we have a standard Edittools div, hide the one containing wikimarkup
			if( edittools_markup ) {
				edittools_markup.style.display = 'none';
			}

			// Use Ajax to transform the Wikitext to HTML.
			if( window.parent.popup ){
				window.parent.popup.parent.FCK_sajax( 'wfSajaxWikiToHTML', [FCK.EditingArea.Textarea.value], loadHTMLFromAjax );
			} else {
				window.parent.FCK_sajax( 'wfSajaxWikiToHTML', [FCK.EditingArea.Textarea.value], loadHTMLFromAjax );
			}
		} else {
			original.apply( FCK, args );
			if( edittools_markup ) {
				edittools_markup.style.display = '';
			}
			window.parent.oFCKeditor.ready = true;
		}
	}
})();

// MediaWiki document processor.
FCKDocumentProcessor.AppendNew().ProcessDocument = function( document ){
	// #1011: change signatures to SPAN elements
	var aTextNodes = document.getElementsByTagName( '*' );
	var i = 0;
	var signatureRegExp = new RegExp( FCKConfig.WikiSignature.replace( /([*:.*?();|$])/g, "\\$1" ), "i" );
	while( element = aTextNodes[i++] ){
		var nodes = element.childNodes;
		var j = 0;
		while ( node = nodes[j++] ){
			if ( node.nodeType == 3 ){ // textNode
				var index = 0;

				while ( aSignatures = node.nodeValue.match( signatureRegExp ) ){
					index = node.nodeValue.indexOf( aSignatures[0] );
					if ( index != -1 ){
						var e = FCK.EditorDocument.createElement( 'span' );
						e.className = "fck_mw_signature";
						var oFakeImage = FCKDocumentProcessor_CreateFakeImage( 'FCK__MWSignature', e );

						var substr1 = FCK.EditorDocument.createTextNode( node.nodeValue.substring(0, index) );
						var substr2 = FCK.EditorDocument.createTextNode( node.nodeValue.substring(index + aSignatures[0].length) );

						node.parentNode.insertBefore( substr1, node );
						node.parentNode.insertBefore( oFakeImage, node );
						node.parentNode.insertBefore( substr2, node );

						node.parentNode.removeChild( node );
						if ( node )
							node.nodeValue = '';
					}
				}
			}
		}
	}

	// Templates and magic words.
	var aSpans = document.getElementsByTagName( 'SPAN' );

	var eSpan;
	var i = aSpans.length - 1;
	while ( i >= 0 && ( eSpan = aSpans[i--] ) ){
		var className = null;
		switch ( eSpan.className ){
			case 'fck_mw_source' :
				className = 'FCK__MWSource';
			case 'fck_mw_ref' :
				if (className == null)
					className = 'FCK__MWRef';
			case 'fck_mw_references' :
				if ( className == null )
					className = 'FCK__MWReferences';
			case 'fck_mw_template' :
				if ( className == null ) //YC
					className = 'FCK__MWTemplate'; //YC
			case 'fck_mw_magic' :
				if ( className == null )
					className = 'FCK__MWMagicWord';
			case 'fck_mw_magic' :
				if ( className == null )
					className = 'FCK__MWMagicWord';
			case 'fck_mw_special' : //YC
				if ( className == null )
					className = 'FCK__MWSpecial';
			case 'fck_mw_nowiki' :
				if ( className == null )
					className = 'FCK__MWNowiki';
			case 'fck_mw_html' :
				if ( className == null )
					className = 'FCK__MWHtml';
			case 'fck_mw_includeonly' :
				if ( className == null )
					className = 'FCK__MWIncludeonly';
			case 'fck_mw_gallery' :
				if ( className == null )
					className = 'FCK__MWGallery';
			case 'fck_mw_noinclude' :
				if ( className == null )
					className = 'FCK__MWNoinclude';
			case 'fck_mw_onlyinclude' :
				if ( className == null )
					className = 'FCK__MWOnlyinclude';

				var oImg = FCKDocumentProcessor_CreateFakeImage( className, eSpan.cloneNode(true) );
				oImg.setAttribute( '_' + eSpan.className, 'true', 0 );

				eSpan.parentNode.insertBefore( oImg, eSpan );
				eSpan.parentNode.removeChild( eSpan );
			break;
		}
	}

	// Math tags without Tex.
	var aImgs = document.getElementsByTagName( 'IMG' );
	var eImg;
	i = aImgs.length - 1;
	while ( i >= 0 && ( eImg = aImgs[i--] ) ){
		var className = null;
		switch ( eImg.className ){
			case 'FCK__MWMath' :
				eImg.src = FCKConfig.PluginsPath + 'mediawiki/images/icon_math.gif';
			break;
		}
	}

	// InterWiki / InterLanguage links
	var aHrefs = document.getElementsByTagName( 'A' );
	var a;
	var i = aHrefs.length - 1;
	while ( i >= 0 && ( a = aHrefs[i--] ) ){
		if( a.className == 'extiw' ){
			a.href = a.title;
			a.setAttribute( '_fcksavedurl', a.href );
		} else {
			if( a.href.toLowerCase().StartsWith( 'rtecolon' ) ){
				a.href = ":" + a.href.substring(8);
				if( a.innerHTML.toLowerCase().StartsWith( 'rtecolon' ) ){
					a.innerHTML = a.innerHTML.substring(8);
				}
			}
		}
	}
}

// Context menu for templates.
FCK.ContextMenu.RegisterListener({
	AddItems : function( contextMenu, tag, tagName ){
		if ( tagName == 'IMG' ){
			if ( tag.getAttribute( '_fck_mw_template' ) ){
				contextMenu.AddSeparator();
				contextMenu.AddItem( 'MW_Template', FCKLang.wikiMnuTemplate || 'Template Properties' );
			}
			if ( tag.getAttribute( '_fck_mw_magic' ) ){
				contextMenu.AddSeparator();
				contextMenu.AddItem( 'MW_MagicWord', FCKLang.wikiMnuMagicWord || 'Modify Magic Word' );
			}
			if ( tag.getAttribute( '_fck_mw_ref' ) ){
				contextMenu.AddSeparator();
				contextMenu.AddItem( 'MW_Ref', FCKLang.wikiMnuReference || 'Reference Properties' );
			}
			if ( tag.getAttribute( '_fck_mw_html' ) ){
				contextMenu.AddSeparator();
				contextMenu.AddItem( 'MW_Special', 'Edit HTML code' );
			}
			if ( tag.getAttribute( '_fck_mw_source' ) ){
				contextMenu.AddSeparator();
				contextMenu.AddItem( 'MW_Source', FCKLang.wikiMnuSourceCode || 'Source Code Properties' );
			}
			if ( tag.getAttribute( '_fck_mw_math' ) ){
				contextMenu.AddSeparator();
				contextMenu.AddItem( 'MW_Math', FCKLang.wikiMnuFormula || 'Edit Formula' );
			}
			if ( tag.getAttribute( '_fck_mw_special' ) || tag.getAttribute( '_fck_mw_nowiki' ) || tag.getAttribute( '_fck_mw_includeonly' ) || tag.getAttribute( '_fck_mw_noinclude' ) || tag.getAttribute( '_fck_mw_onlyinclude' ) || tag.getAttribute( '_fck_mw_gallery' ) ){ //YC
				contextMenu.AddSeparator();
				contextMenu.AddItem( 'MW_Special', FCKLang.wikiMnuSpecial || 'Special Tag Properties' );
			}
		}
	}
});
