// Rewrite the link command to use our link.html
FCKCommands.RegisterCommand('Link', new FCKDialogCommand('Link', FCKLang.DlgLnkWindowTitle, FCKConfig.PluginsPath + 'wikitext/dialogs/link.html', 400, 250));

// Register templates editor
FCK.TemplateClickCommand = new FCKDialogCommand('Template', '&nbsp;', FCKConfig.PluginsPath + 'wikitext/dialogs/template.html', 600, 350);

// Wikitext infobox
FCK.InputClickCommand = new FCKDialogCommand('inputClickCommand', '&nbsp;', FCKConfig.PluginsPath + 'wikitext/dialogs/inputClick.html', 400, 100);

// signature toolbar button
var FCKTildesCommand = function() {
	this.Name = 'Tildes' ;
}
FCKTildesCommand.prototype = {
	Execute : function() {
		FCKUndo.SaveUndoStep() ;

		var text = document.createTextNode('--');
		FCK.InsertElement(text) ;

		FCK.wysiwygData.push({'type':'tilde','description':'~~~~'});

		var input = document.createElement('input');
		input.value = "~~~~";
		input.className = 'wysiwygDisabled';
		input.type = 'button';
		input.setAttribute('refid', FCK.wysiwygData.length-1);

		FCK.InsertElement(input) ;
	},
	GetState : function() {
		if ( FCK.EditMode != FCK_EDITMODE_WYSIWYG )
			return FCK_TRISTATE_DISABLED ;
		return FCK_TRISTATE_OFF;
	}
} ;
FCKCommands.RegisterCommand('Tildes', new FCKTildesCommand());
var oTildesItem = new FCKToolbarButton( 'Tildes', 'Your signature with timestamp' ) ;
oTildesItem.IconPath = FCKConfig.PluginsPath + 'wikitext/sig.gif' ;
FCKToolbarItems.RegisterItem( 'Tildes', oTildesItem );


// "add image" toolbar button
var FCKAddImageCommand = function() {
	this.Name = 'AddImage' ;
}
FCKAddImageCommand.prototype = {
	Execute : function() {
		FCKUndo.SaveUndoStep() ;
		FCK.log('opening "add image" dialog');
		window.parent.WMU_show(-1);
	},
	GetState : function() {
		if ( FCK.EditMode != FCK_EDITMODE_WYSIWYG )
			return FCK_TRISTATE_DISABLED ;
		return FCK_TRISTATE_OFF;
	}
} ;
FCKCommands.RegisterCommand('AddImage', new FCKAddImageCommand());
var oTildesItem = new FCKToolbarButton( 'AddImage', 'Add image' ) ;
oTildesItem.IconPath = FCKConfig.PluginsPath + 'wikitext/addImage.png' ;
FCKToolbarItems.RegisterItem( 'AddImage', oTildesItem );


//
// modes switching
//

FCK.originalSwitchEditMode = FCK.SwitchEditMode;

FCK.WysiwygSwitchToolbars = function(switchToWikitext) {
	var toolbarItems = document.getElementById('xToolbar').getElementsByTagName('tr')[0].childNodes;
	var MWtoolbar = window.parent.document.getElementById('toolbar');
	var FCKiframe = window.parent.document.getElementById('wpTextbox1___Frame');

	// move MW toolbar next to "Source" button
	if (MWtoolbar) {
		MWtoolbar.style.marginLeft = (toolbarItems[1].offsetWidth+27) + 'px';
		MWtoolbar.style.top = (FCKiframe.offsetTop - FCK.GetParentForm().offsetTop + 3) + 'px';
	}

	// show/hide FCK toolbar items
	for (t=0; t<toolbarItems.length; t++) {
		toolbarItems[t].style.display = (switchToWikitext && t > 1) ? 'none' : '';
	}

	// show/hide MW toolbar
	if (MWtoolbar) {
		MWtoolbar.style.visibility = switchToWikitext ? 'visible' : 'hidden';
	}
}

FCK.SwitchEditMode = function() {

	if(FCK.InProgress == true) {
		return true;
	}

	FCK.InProgress = true;

	var args = arguments;

	if(FCK.EditMode == FCK_EDITMODE_WYSIWYG) {

		FCK.EditingArea.TargetElement.className = 'childrenHidden';
		FCK.originalSwitchEditMode.apply(FCK, args);

	} else if(FCK.EditMode == FCK_EDITMODE_SOURCE) {

		FCK.EditingArea.TargetElement.className = 'childrenHidden';

		window.parent.sajax_request_type = 'POST';
		window.parent.sajax_do_call('Wysywig_Ajax', ['wiki2html', FCK.EditingArea.Textarea.value, false, window.parent.wgArticleId], function(res) {
			var edgecases = res.getResponseHeader('X-edgecases');
			if(typeof edgecases == "undefined") edgecases = res.getResponseHeader('X-Edgecases');
			if (edgecases == '1') {
				messages = res.responseText;
				//macbre: just show old-school alert()
				alert(messages);
			} else {
				var separator = res.getResponseHeader('X-sep');
				if(typeof separator == "undefined") separator = res.getResponseHeader('X-Sep');
				var res_array = res.responseText.split('--'+separator+'--');
				FCK.wysiwygData = eval("{"+res_array[1]+"}");
				if(!FCK.wysiwygData) {
					FCK.wysiwygData = [];
				}
				FCK.EditingArea.Textarea.value = res_array[0];
				FCK.originalSwitchEditMode.apply(FCK, args);
				FCK.WysiwygSwitchToolbars(false);
				if (FCK.Track) FCK.Track('/switchMode/wiki2html');
				window.parent.document.getElementById('wysiwygTemporarySaveType').value = "0";
			}
			FCK.EditingArea.TargetElement.className = '';
			setTimeout(function() {FCK.InProgress = false;}, 100);
			FCK.EditingArea.Focus(); // macbre: moved here from fck.js
		});
	}

	return true;
}

//
// misc functions
//

FCK.InsertDirtySpanBefore = function(node) {
	var span = FCKTools.GetElementDocument(node).createElement('SPAN');
	span.setAttribute('type', '_moz');
	span.className = '_moz_dirty';
	node.parentNode.insertBefore(span, node);
}

FCK.InsertDirtySpanAfter = function(node) {
	var span = FCKTools.GetElementDocument(node).createElement('SPAN');
	span.setAttribute('type', '_moz');
	span.className = '_moz_dirty';
	FCKDomTools.InsertAfterNode(node, span);
}

// return next free refId
FCK.GetFreeRefId = function() {
	// JSONEncode & JSONParse sometimes breaks FCK.wysiwygData.length value
	for (refid in FCK.wysiwygData) {}
	return parseInt(refid) + 1;
}

FCK.GetElementByRefId = function(refId) {
	return FCK.NodesWithRefId[refId];
}

FCK.NodesWithRefId = {};

FCK.GetNodesWithRefId = function() {
	var nodes = [];
	
	FCK.NodesWithRefId = {};

	// get elements using XPath (at least try)
	if (FCKBrowserInfo.IsIE) {
		// of course IE has it's own standards...
		var method = function(node) {
			return (node.getAttribute('refid') != undefined);
		};

		var add = function(node) {
			FCK.NodesWithRefId[ node.getAttribute('refid') ] = node;
		}

		var nodes = FCK.YD.getElementsBy(method, false, FCK.EditorDocument.body, add);
	}
	else {
		// @see http://www.w3schools.com/XPath/xpath_examples.asp
		// Mozilla-based browser - use XPath
		var results = FCK.EditorDocument.evaluate('//@refid', FCK.EditorDocument, null, XPathResult.ANY_TYPE, null);

		while (attr = results.iterateNext()) {
			node = attr.ownerElement;
			nodes.push(node);
			FCK.NodesWithRefId[ node.getAttribute('refid') ] = node;
		}
	}

	FCK.log('returning ' + nodes.length + ' nodes with refId');

	return nodes;
}

//
// block given event (prevenDefault + stopPropagation)
//
FCK.BlockEvent = function(elem, eventType) {
	FCKTools.AddEventListener(elem, eventType, function(e) {
		FCK.YE.stopEvent( FCK.YE.getEvent(e) );
	});
}

//
// setup handlers for placeholders when in wysiwyg mode
//
FCK.Events.AttachEvent( 'OnAfterSetHTML', function() {
	if(FCK.EditingArea.TargetElement.className == 'childrenHidden') {
		var html = FCK.GetData();
		var wysiwygDataEncoded =  FCK.YAHOO.Tools.encodeArr(FCK.wysiwygData);

		window.parent.sajax_request_type = 'POST';
		window.parent.sajax_do_call('Wysywig_Ajax', ['html2wiki', html, wysiwygDataEncoded], function(res) {
			FCK.EditingArea.Textarea.value = res.responseText;
			FCK.EditingArea.TargetElement.className = '';
			setTimeout(function() {FCK.InProgress = false;}, 100);
			FCK.EditingArea.Focus(); // macbre: moved here from fck.js
			FCK.WysiwygSwitchToolbars(true);
			if (FCK.Track) FCK.Track('/switchMode/html2wiki');
			window.parent.document.getElementById('wysiwygTemporarySaveType').value = "1";
		});
	}
	if(!FCK.wysiwygData) {
		FCK.wysiwygData = eval("{"+window.parent.document.getElementById('wysiwygData').value+"}");
		if(!FCK.wysiwygData) {
			FCK.wysiwygData = [];
		}
		FCK.log(FCK.wysiwygData);

	}

	if(FCK.EditMode == FCK_EDITMODE_WYSIWYG) {
		// handle drag&drop
		FCKTools.AddEventListener(FCK.EditorDocument, 'mousedown', function(e) {
			var target = FCK.YAHOO.util.Event.getTarget(e);
			if(target.tagName == 'INPUT') {
					FCKSelection.SelectNode(target);
			}
		});

		// Drag'n'Drop (Gecko browsers)
		//
		// @see https://developer.mozilla.org/en/Drag_and_drop_events
		//
		// handle begin of drag&drop -> save Undo step do we can easily revert any prohibited drag&drop
		//
		FCK.DragNDropInProgress = false;
		FCK.DragNDropUndoStep = {};

		FCKTools.AddEventListener(FCK.EditorDocument, 'drag', function(e) {
			if (!FCK.DragNDropInProgress) {
				FCK.log('drag&drop started - saved undo step');
				FCK.DragNDropInProgress = true;
				FCK.DragNDropUndoStep = {html: FCK.EditorDocument.body.innerHTML, cursor: FCKUndo._GetBookmark()};
			}
		});

		// handle finish of drag&drop -> regenerate elements with refId
		//
		FCKTools.AddEventListener(FCK.EditorDocument, 'dragdrop', function(e) {
			FCK.DragNDropInProgress = false;

			// setup elements with refid (templates, images, ...)
			FCK.SetupElementsWithRefId();

			// check where image was droped
			var target = FCK.YE.getTarget(e);

			var selection = FCKSelection.GetSelection();

			// detect prohibited drag&drops inside image <div> (IE handles contentEditable correctly, really!)
			if (target.getAttribute && target.getAttribute('contentEditable') == "false") {
				FCK.log('prohibited drag&drop detected - undo');

				FCK.EditorDocument.body.innerHTML =  FCK.DragNDropUndoStep.html;
				FCKUndo._SelectBookmark(FCK.DragNDropUndoStep.cursor);

				FCK.SetupElementsWithRefId();

				FCK.Events.FireEvent("OnSelectionChange");
			}

			// remove drag&drop undo step
			FCK.DragNDropUndoStep = {};

			// unselect any selection
			if (selection.removeAllRanges) {
				selection.removeAllRanges();
			}

			FCK.ImageDragDrop = false;
		});

		// IE
		if (FCKBrowserInfo.IsIE) {
			FCK.EditorDocument.body.ondrop = function(e) {
				FCK.log('drag&drop finished');

				// setup elements with refid (templates, images, ...)
				FCK.SetupElementsWithRefId();
			};
		}

		// open wikitext dialog
		FCKTools.AddEventListener(FCK.EditorDocument, 'click', function(e) {
			var target = FCK.YAHOO.util.Event.getTarget(e);
			if(target.tagName == 'INPUT') {
				var refid = target.getAttribute('refid');
				var type = target.getAttribute('_fck_type');
				if(refid && type != 'template') {
					if (FCK.Track && FCK.wysiwygData) {
						FCK.Track('/wikitextbox/' + (FCK.wysiwygData[refid] ? FCK.wysiwygData[refid].type : 'unknown'));
					}
					FCK.InputClickCommand.Execute();
				}
			}
			// probably IE - go up the DOM tree looking for refid element of the image
			else if (target.getAttribute('contentEditable') == 'false') {
				while (!target.getAttribute('refid')) {
					target = target.parentNode;
				}

				var refid = target.getAttribute('refid');

				// fix list of nodes with refids
				FCK.NodesWithRefId[refid] = target;

				// call WMU dialog
				FCK.ProtectImageEdit(refid);
			}
		});

		// setup elements with refid (templates, images, ...)
		FCK.SetupElementsWithRefId();
	}

	// for QA team tests
	FCK.GetParentForm().className = (FCK.EditMode == FCK_EDITMODE_WYSIWYG ? 'wysiwyg' : 'source') + '_mode';

});

// setup elements with refId (after switching to wysiwyg mode and after drag&drop is finished)
FCK.SetupElementsWithRefId = function() {

	// init templates preview
	FCK.TemplatePreviewInit();
		
	// get all elements with refid attribute and handle them by value of _fck_type attribute
	var nodes = FCK.GetNodesWithRefId();
	FCK.log(nodes);

	for (n=nodes.length-1; n>=0; n--) {
		var node = nodes[n];
		var refid = node.getAttribute('refid');
		if (!refid) {
			continue;
		}

		var data = FCK.wysiwygData[refid];
		var type = node.getAttribute('_fck_type') || data.type;
		var name = node.nodeName.toLowerCase();

		switch(type) {
			case 'template':
				FCK.TemplatePreviewAdd(node);
				break;

			case 'image':
				FCK.ProtectImage(node);
				break;

			// add tooltip to links
			case 'internal link':
				node.title = data.href;
				break;

			case 'external link':
				node.title = data.href;
				break;
		}

		// fix issues with input tags and cursor
		if (name == 'input') {
			FCK.FixWikitextPlaceholder(node);
		}
	}

	FCK.log('setup of nodes with refid finished');

	return true;
}

// setup grey wikitext placeholder: block context menu, add dirty span(s) if needed
FCK.FixWikitextPlaceholder = function(placeholder) {
	// disable context menu
	placeholder.setAttribute('_fckContextMenuDisabled', true);

	// placeholder is last child of p, div, li, dt or dd node - add dirty span
	if (placeholder.parentNode.nodeName.IEquals(['p', 'div', 'li', 'dt', 'dd']) &&  placeholder == placeholder.parentNode.lastChild) {
		if (FCKBrowserInfo.IsGecko10) {
			// add &nbsp; for FF2.x
			var frag = FCK.EditorDocument.createDocumentFragment();
			frag.appendChild(FCK.EditorDocument.createTextNode('\xA0'));
			placeholder.parentNode.appendChild(frag);
		}
		else {
			// add 'dirty' <br/>
			FCKTools.AppendBogusBr(placeholder.parentNode);
		}
	}

	// insert <span type="_moz">:
	// 1. between input tags
	if ( (placeholder.nextSibling && placeholder.nextSibling.nodeName.IEquals('input'))) {
		FCK.InsertDirtySpanAfter(placeholder);
	}

	// 2. at the beginning of the line
	if (placeholder.parentNode.firstChild == placeholder) {
		FCK.InsertDirtySpanBefore(placeholder);
	}

	// 3. after input tag if parent node is body ("<table>" template placeholder)
	if (placeholder.parentNode.nodeName.IEquals('body')) {
		FCK.InsertDirtySpanBefore(placeholder);
		FCK.InsertDirtySpanAfter(placeholder);
	}
}

// check whether given page exists (API query returns pageid != 0)
// if not -> add "new" class to simulate MW parser behaviour
FCK.CheckInternalLink = function(title, link) {
	var callback = {
		success: function(o) {
			FCK = o.argument.FCK;
			title = o.argument.title;
			link =  o.argument.link;

			result = eval('(' + o.responseText + ')');
			pageExists = (typeof result.query.pages[-1] == 'undefined');

			FCK.log('"' + title + '" ' + (pageExists ? 'exists' : 'doesn\'t exist'));

			if (link) {
				if (pageExists) {
					FCK.YD.removeClass(link, 'new');
					link.href = window.parent.wgServer + window.parent.wgArticlePath.replace(/\$1/, encodeURI(title.replace(/ /g, '_')));
				} else {
					FCK.YD.addClass(link, 'new');
					link.href = window.parent.wgServer + window.parent.wgScript + '?title=' + encodeURIComponent(title.replace(/ /g, '_')) + '&action=edit&redlink=1';
				}
				FCK.log('href: ' + link.href);
			}
		},
		failure: function(o) {},
		argument: {'FCK': FCK, 'link': link, 'title': title}
	}
	FCK.YAHOO.util.Connect.asyncRequest("POST", window.parent.wgScriptPath + '/api.php', callback, "action=query&format=json&prop=info&titles=" +   encodeURIComponent(title) );
}

//
// InsertTemplate - dropdown in menu
//
FCKCommands.RegisterCommand('InsertTemplate', new FCKAddImageCommand());

var FCKToolbarInsertTemplateCombo = function(tooltip, style) {
	this.CommandName	= 'InsertTemplate';
	this.Label = this.GetLabel();

	this.Tooltip = tooltip ? tooltip : this.Label;
	this.Style = style ? style : FCK_TOOLBARITEM_ICONTEXT;

	this.DefaultLabel = 'Insert template';
	this.FieldWidth = 100 ;
}
FCKToolbarInsertTemplateCombo.prototype = new FCKToolbarSpecialCombo;
FCKToolbarInsertTemplateCombo.prototype.GetLabel = function() {
	return '';
}
FCKToolbarInsertTemplateCombo.prototype.CreateItems = function( targetSpecialCombo ) {
	targetSpecialCombo.AddItem("1", "1");
	targetSpecialCombo.AddItem("2", "2");
	targetSpecialCombo.AddItem("2", "3");
}

var oInsertTemplateItem = new FCKToolbarInsertTemplateCombo();
FCKToolbarItems.RegisterItem('InsertTemplate', oInsertTemplateItem);



//
// support for non-editable images
//

// image overlay with edit/delete link
FCK.ProtectImageOverlay = false;

FCK.ProtectImage = function(image) {
	//FCK.log(image);
	var refid = parseInt(image.getAttribute('refid'));

	// for browsers supporting contentEditable
	if (FCK.UseContentEditable) {
		// don't use iframes -> use contentEditable
		image.setAttribute('contentEditable', false);

		// apply contentEditable to all child nodes of image
		FCK.YD.getElementsBy(
			function(node) {
				return true;
			},
			false,
			image,
			function(node) {
				node.setAttribute('contentEditable', false);
			}
		);

		// setup events (remove listener first to avoid multiple event firing)
		FCKTools.RemoveEventListener(image, 'click', FCK.ImageProtectOnClick);
		FCKTools.AddEventListener(image, 'click', FCK.ImageProtectOnClick);

		FCKTools.RemoveEventListener(image, 'mousedown', FCK.ImageProtectOnMousedown);
		FCKTools.AddEventListener(image, 'mousedown', FCK.ImageProtectOnMousedown);

		FCK.BlockEvent(image, 'contextmenu');

		// check whether given image exists
		FCK.wysiwygData[refid].exists = image.nodeName.IEquals('a') 
			? (!FCK.YD.hasClass(image, 'new'))
			: !( /class=\"new\"/.test(image.innerHTML) );

		// store node with refId
		FCK.NodesWithRefId[ refid ] = image;

		// image overlay menu (edit / delete)
		FCK.ImageProtectSetupOverlayMenu(refid, image); // image.nodeName.IEquals('a') ? image : image.firstChild);

		return;
	}
	
	//
	// support older browsers
	//
	var iframe = FCK.EditingArea.Document.createElement('iframe');
	var coveringDiv = FCK.EditingArea.Document.createElement('div');

	// fix FF2.x issue with iframes with "generated content": use "ajax" html provider
	iframe.src = window.parent.wgServer + window.parent.wgScript + '?action=ajax&rs=WysiwygImage&articleid=' + encodeURIComponent(window.parent.wgArticleId) + '&wikitext=' + encodeURIComponent(FCK.wysiwygData[refid].original);

	iframe.name = 'image' + refid;

	iframe.setAttribute('refid', refid);
	iframe.className = image.className;

	if (image.nodeName.IEquals('a')) {
		var size = {width: image.firstChild.width, height: image.firstChild.height + 6};
	}
	else {
		var size = {width: image.firstChild.style.width, height: image.clientHeight + 6};
	}

	// external CSS may not be fully loaded - use style value from inline CSS for width
	iframe.style.width = parseInt(size.width) + 20 + 'px';
	iframe.style.height = parseInt(size.height) + 6 + 'px';
	iframe.style.border = 'none';
	iframe.style.overflow = 'hidden';

	// DOM stuff
	image.parentNode.insertBefore(iframe, image);
	image.parentNode.removeChild(image);

	// update list of nodes with refId
	FCK.NodesWithRefId[refid] = iframe;

	// iframe covering div
	var docObj = FCKTools.GetElementDocument(FCK.EditingArea.TargetElement);

	coveringDiv = docObj.getElementById('cover' + refid);

	if (!coveringDiv) {
		// create cover
		coveringDiv = docObj.createElement('DIV');
		coveringDiv.id = 'cover' + refid;
		coveringDiv.setAttribute('refid', refid);
		docObj.body.appendChild(coveringDiv);
	}

	coveringDiv.className = 'cover ' + image.className;
	coveringDiv.style.width = iframe.style.width;
	coveringDiv.style.height = iframe.style.height;
	coveringDiv.style.position = 'absolute';
	coveringDiv.style.cursor = 'pointer';
	//coveringDiv.style.border = 'solid 1px red';
	coveringDiv.innerHTML = '&nbsp;';

	FCK.ProtectImageRepositionCover(refid);

	// check whether given image exists
	var re = /class=\"new\"/;
	FCK.wysiwygData[refid].exists = !re.test(image.innerHTML);

	// image overlay menu (edit / delete)
	FCK.ImageProtectSetupOverlayMenu(refid, coveringDiv);
}

// go up the DOM tree to find image root element based on its child
FCK.GetParentImage = function(child) {
	var node = child;
	while(node && node.getAttribute && !node.getAttribute('refid')) {
		node = node.parentNode;
	}

	if (node.getAttribute('refid')) {
		return node;
	}
	else {
		return false;
	}
}

FCK.ImageProtectOnClick = function(e) {
	var e = FCK.YE.getEvent(e);
	var target = FCK.YE.getTarget(e);
		
	FCK.YE.stopEvent(e);

	// ignore buttons different then left
	if (e.button == 0) {

		var image = FCK.GetParentImage(target);
		var refid = parseInt(image.getAttribute('refid'));

		FCK.log('image #' + refid  + ' clicked');
		// choose action based on original target CSS class
		switch (target.className) {
			case 'imageOverlayRemove':
				FCK.ProtectImageRemove(refid);
				break;

			case 'imageOverlayEdit':
				FCK.ProtectImageEdit(refid);
				break;
		}
	}
};

FCK.ImageProtectOnMousedown = function(e) {
	var e = FCK.YE.getEvent(e);
	var target = FCK.YE.getTarget(e);

	if (target.className == 'imageOverlayDrag') {

		var image = FCK.GetParentImage(target);
		var refid = parseInt(image.getAttribute('refid'));
		
		FCK.log('image #' + refid  + ' drag&drop catched');

		FCK.Track('/image/move');

		// select whole image
		FCK.Selection.SelectNode(image);
		FCK.ImageDragDrop = image;
	}
	else {
		FCK.YE.stopEvent(e);
	}
};


// set images iframe overlaying divs (FF2.x)
FCK.ImageProtectSetupOverlayMenu = function(refid, div) {

	// remove old overlayMenu (if any)
	if (div.lastChild && FCK.YD.hasClass(div.lastChild,'imageOverlay')) {
		FCKDomTools.RemoveNode(div.lastChild);
	}

	div.setAttribute('refid', refid);

	var docObj = FCKTools.GetElementDocument(div);

	var overlay = docObj.createElement('SPAN');

	// position menu based on alignment of an image
	overlay.className = 'imageOverlay ' + (FCK.YD.hasClass(div, 'thumb') ?   'imageOverlay' + (FCK.YD.hasClass(div, 'tright') ? 'Right' : 'Left') : '');
	overlay.style.visibility = 'hidden';

	div.style.position = 'relative';

	// move to the upper corner when image is wrapped using <a>
	if (div.nodeName.IEquals('a') && !FCKBrowserInfo.IsIE) {
		var height = parseInt(div.firstChild.offsetHeight / 2);
		overlay.style.top = (-height + 8) + 'px';
	}
			
	div.appendChild(overlay);

	overlay.innerHTML = '<span class="imageOverlayEdit" onclick="FCK.ProtectImageEdit('+refid+')">edit</span><span class="imageOverlayRemove" onclick="FCK.ProtectImageRemove('+refid+')">remove</span>';

	// add "move" option for images handled by contentEditable
	if (FCK.UseContentEditable) {
		overlay.innerHTML += '<span class="imageOverlayDrag" onmousedown="FCK.ProtectImageDrag('+refid+')">move</span>';
	}

	// show overlay menu
	FCKTools.AddEventListener(div, 'mouseover', function(e) {
		overlay.style.visibility = 'visible';
	});

	// hide overlay menu
	FCKTools.AddEventListener(div, 'mouseout', function(e) {
		overlay.style.visibility = 'hidden';
	});
}	


FCK.ProtectImageRepositionCover = function(refid) {

	if (FCK.EditMode == 1) {
		// leave when switched to source mode
		return;
	}

	var iframe = FCK.GetElementByRefId(refid);
	var cover = FCKTools.GetElementDocument(FCK.EditingArea.TargetElement).getElementById('cover' + refid);

	if (!iframe) {
		// image has just been removed
		FCKDomTools.RemoveNode(cover);
		return;
	}

	var xy = FCK.YD.getXY(iframe);
	var offsetY = FCK.EditorDocument.body.scrollTop;

	FCK.YD.setXY(cover, [xy[0],xy[1] -  offsetY + 30]);
	cover.style.width = iframe.style.width;
	cover.style.height = iframe.style.height;

	// recalculate after 750ms
	setTimeout('FCK.ProtectImageRepositionCover('+refid+')', 750);
}

// handle images edit
FCK.ProtectImageEdit = function(refid) {

	FCK.log('click on image #' + refid);
	FCK.log(FCK.wysiwygData[refid]);

	// tracker
	FCK.Track('/image/click');

	// open WikiaMiniUpload
	window.parent.WMU_show( parseInt(refid) );
}

// remove image from the article
FCK.ProtectImageRemove = function(refid, dontAsk) {
	if (dontAsk || confirm('Are you sure you want to remove this image?')) {

		FCKUndo.SaveUndoStep();

		FCK.log('removed image #' + refid);

		var node = FCK.GetElementByRefId(refid);

		FCKDomTools.RemoveNode(node);

		// clear meta data
		delete FCK.wysiwygData[refid];
		delete FCK.NodesWithRefId[refid];

		// tracker
		FCK.Track('/image/remove');
	}
}

// to simplify things we actually replace old image with the new one
FCK.ProtectImageUpdate = function(refid, wikitext, extraData) {
	FCK.log('updating #' + refid +' with >>' + wikitext + '<<');

	FCK.Track('/image/update');

	FCKUndo.SaveUndoStep();

	// update metaData
	var params = wikitext.substring(2, wikitext.length-2).split('|');
	FCK.wysiwygData[refid].href = params.shift();
	FCK.wysiwygData[refid].description = params.join('|');
	FCK.wysiwygData[refid].original = wikitext;

	// merge with extraData
	FCK.wysiwygData[refid] = FCK.YAHOO.lang.merge(FCK.wysiwygData[refid], extraData);

	FCK.log(FCK.wysiwygData[refid]);

	// parse given wikitext
	var callback = {
		success: function(o) {
			FCK = o.argument.FCK;
			refid =  o.argument.refid;
		
			var oldImage = FCK.GetElementByRefId(refid);
			FCK.log(oldImage);

			result = eval('(' + o.responseText + ')');
			html = result.parse.text['*'];

			// remove newPP comment and whitespaces
			html = FCK.YAHOO.lang.trim(html.split('<!-- \nNewPP limit report')[0]);

			// insert html into editing area (before old image)...
			var wrapper = FCKTools.GetElementDocument(oldImage).createElement('DIV');

			// fix IE's "unknown runtine error" by always adding wrapper before block elements (FF will try to validate, IE will throw an error)
			// @see http://piecesofrakesh.blogspot.com/2007/02/ies-unknown-runtime-error-when-using.html
			if (oldImage.nodeName.IEquals('a') && FCKBrowserInfo.IsIE) {
				oldImage.parentNode.parentNode.insertBefore(wrapper, oldImage.parentNode);
			}
			else {
				oldImage.parentNode.insertBefore(wrapper, oldImage);
			}

			// set HTML
			wrapper.innerHTML = html;

			// is "simple" image wrapped by <p></p> ?
			if (html.substr(0,3) == '<p>') {
				// remove wrapping <p></p>
				wrapper.innerHTML = html.substr(3, html.length-7);
			}

			// ...and "protect" it
			wrapper.firstChild.setAttribute('refid', refid);
			FCK.ProtectImage(wrapper.firstChild);

			// remove wrapper and old image
			FCKDomTools.RemoveNode(oldImage, false); // including child nodes
			FCKDomTools.RemoveNode(wrapper, true);
		},
		failure: function(o) {},
		argument: {'FCK': FCK, 'refid': refid}
	}

	FCK.YAHOO.util.Connect.asyncRequest(
		'POST',
		window.parent.wgScriptPath + '/api.php',
		callback,
		"action=parse&format=json&prop=text&title=" + encodeURIComponent(window.parent.wgPageName) + "&text=" +  encodeURIComponent(wikitext)
	);
}

FCK.ProtectImageAdd = function(wikitext, extraData) {
	var refid = FCK.GetFreeRefId();

	FCK.log('adding new image #' + refid + ' using >>' + wikitext + '<<');

	FCK.Track('/image/add');

	// fill metaData up
	var params = wikitext.substring(2, wikitext.length-2).split('|');
	FCK.wysiwygData[refid] = {
		'type': 'image',
		'href': params.shift(),
		'description': params.join('|'),
		'original': wikitext,
		'exists': true
	};

	// merge with extraData
	FCK.wysiwygData[refid] = FCK.YAHOO.lang.merge(FCK.wysiwygData[refid], extraData);

	// parse given wikitext
	var callback = {
		success: function(o) {
			FCK = o.argument.FCK;
			refid =  o.argument.refid;

			result = eval('(' + o.responseText + ')');
			html = result.parse.text['*'];

			// remove newPP comment and whitespaces
			html = FCK.YAHOO.lang.trim(html.split('<!-- \nNewPP limit report')[0]);

			// insert html into editing area...
			var wrapper = FCK.EditorDocument.createElement('DIV');
			FCK.InsertElement(wrapper);
			wrapper.innerHTML = html;

			// is "simple" image wrapped by <p></p> ?
			if (html.substr(0,3) == '<p>') {
				// remove wrapping <p></p>
				wrapper.innerHTML = html.substr(3, html.length-7);
			}

			// ...and "protect" it
			wrapper.firstChild.setAttribute('refid', refid);
			FCK.ProtectImage(wrapper.firstChild);

			// remove wrapper
			FCKDomTools.RemoveNode(wrapper, true);

			FCK.log(FCK.wysiwygData[refid]);
		},
		failure: function(o) {},
		argument: {'FCK': FCK, 'refid': refid}
	}

	FCK.YAHOO.util.Connect.asyncRequest(
		'POST',
		window.parent.wgScriptPath + '/api.php',
		callback,
		"action=parse&format=json&prop=text&title=" + encodeURIComponent(window.parent.wgPageName) + "&text=" +  encodeURIComponent(wikitext)
	);
}

//
// onmouseover template preview
// 

FCK.TemplatePreviewCloud = false;
FCK.TemplatePreviewTimeouts = {Tag: false, Cloud: false};

FCK.TemplatePreviewInit = function() {
	if (FCK.TemplatePreviewCloud) {
		FCK.TemplatePreviewCloud.parentNode.removeChild(FCK.TemplatePreviewCloud);
		FCK.TemplatePreviewCloud = false;
		FCK.TemplatePreviewTimeouts = {Tag: false, Cloud: false};
	}
}

FCK.TemplatePreviewAdd = function(placeholder) {

	var docObj = FCKTools.GetElementDocument(FCK.EditingArea.TargetElement);

	// initialize preview cloud
	if (!FCK.TemplatePreviewCloud) {
		FCK.TemplatePreviewCloud = docObj.createElement('DIV');
		docObj.body.appendChild(FCK.TemplatePreviewCloud);

		FCK.TemplatePreviewCloud.id = 'wysiwygTemplatePreviewCloud';
		FCK.TemplatePreviewCloud.innerHTML = '<div id="wysiwygTemplatePreviewCloudInner"></div>';

		FCKTools.AddEventListener(FCK.TemplatePreviewCloud, 'mouseover', function(e) {
			// clear timeouts
			clearTimeout(FCK.TemplatePreviewTimeouts.Tag);
			clearTimeout(FCK.TemplatePreviewTimeouts.Cloud);
		});
	
		FCKTools.AddEventListener(FCK.TemplatePreviewCloud, 'mouseout', function(e) {
			// hide preview 1 sec. after mouseout from cloud
			FCK.TemplatePreviewTimeouts.Cloud = setTimeout('FCK.TemplatePreviewHide()', 1000);
		});
	}

	var refId = placeholder.getAttribute('refid');

	// copy template previews to clouds
	var preview = placeholder.nextSibling;
	var previewDiv = docObj.createElement('div');
	
	FCK.TemplatePreviewCloud.firstChild.appendChild( previewDiv );
	
	previewDiv.id = 'wysiwygTemplatePreview' + refId;
	placeholder.title = 'Click to edit this template or use drag&drop to move template';

	// try to use cached preview from wysiwygData
	previewDiv.innerHTML = (FCK.wysiwygData[refId].preview ? FCK.wysiwygData[refId].preview : preview.value);
	previewDiv.setAttribute('refid', refId);

	// sometimes innerHTML contains whitespices at the end -> fix it
	previewDiv.innerHTML = previewDiv.innerHTML.Trim();
	previewDiv.style.display = 'none';

	// reset template's margin/padding/align
	FCK.TemplatePreviewReset(previewDiv);

	// remove preview div from editing area and store preview in wysiwygData
	if (preview && preview.nodeName.IEquals('input') && preview.type == 'text') {
		preview.parentNode.removeChild(preview);
		FCK.wysiwygData[refId].preview = previewDiv.innerHTML;
	}

	// setup events (remove listener first to avoid multiple event firing)
	FCKTools.RemoveEventListener(placeholder, 'mouseover', FCK.TemplatePreviewOnPlaceholderMouseover);
	FCKTools.RemoveEventListener(placeholder, 'mouseout', FCK.TemplatePreviewOnPlaceholderMouseout);
	FCKTools.RemoveEventListener(placeholder, 'click', FCK.TemplatePreviewOnPlaceholderClick);
	FCKTools.RemoveEventListener(previewDiv, 'click', FCK.TemplatePreviewOnPreviewClick);

	// register events handlers
	FCKTools.AddEventListener(placeholder, 'mouseover', FCK.TemplatePreviewOnPlaceholderMouseover);
	FCKTools.AddEventListener(placeholder, 'mouseout', FCK.TemplatePreviewOnPlaceholderMouseout);

	// events firing template editor
	FCKTools.AddEventListener(placeholder, 'click', FCK.TemplatePreviewOnPlaceholderClick);
	FCKTools.AddEventListener(previewDiv, 'click', FCK.TemplatePreviewOnPreviewClick);
}

FCK.TemplatePreviewOnPlaceholderMouseover = function(e) {
	FCK.TemplatePreviewShow( FCK.YE.getTarget(e) );

	clearTimeout(FCK.TemplatePreviewTimeouts.Tag);
	clearTimeout(FCK.TemplatePreviewTimeouts.Cloud);
}

FCK.TemplatePreviewOnPlaceholderMouseout = function(e) {
	// hide preview 0,5 sec. after mouseout from tag
	FCK.TemplatePreviewTimeouts.Tag = setTimeout('FCK.TemplatePreviewHide()', 500);
}

FCK.TemplatePreviewOnPlaceholderClick = function(e) {
	var e = FCK.YE.getEvent(e);
	var target = FCK.YE.getTarget(e);

	FCK.TemplateRefId = target.getAttribute('refid');
	FCK.TemplateClickCommand.Execute();
}

FCK.TemplatePreviewOnPreviewClick = function(e) {
	// prevent clicking on links inside template preview
	FCK.YE.stopEvent( FCK.YE.getEvent(e) );

	// pass refId to template editor
	FCK.TemplateRefId = FCK.TemplatePreviewCloud.getAttribute('refid');
	FCK.TemplateClickCommand.Execute();
}


// show template preview
FCK.TemplatePreviewShow = function(placeholder) {
	
	var refId = placeholder.getAttribute('refid');
	var preview = FCKTools.GetElementDocument(FCK.TemplatePreviewCloud).getElementById('wysiwygTemplatePreview' + refId);

	// hide all previews / show just the one we need
	var previews = FCK.TemplatePreviewCloud.firstChild.childNodes;

	for (p=0; p<previews.length; p++) {
		previews[p].style.display = 'none';
	}

	preview.style.display = '';

	// calculate cloud placement
	var x = placeholder.offsetLeft;
	var y = placeholder.offsetTop + placeholder.clientHeight + 32;

	// editor area scroll
	var scrollXY = [FCK.EditorDocument.body.scrollLeft, FCK.EditorDocument.body.scrollTop];

	// iframe position
	//var iFrameXY = FCK.YAHOO.util.Dom.getXY('wpTextbox1___Frame');
	var iFrameXY = [0, 0];

	// calculate preview position
	var cloudPos = {x: parseInt(x + iFrameXY[0] - scrollXY[0]), y: parseInt(y + iFrameXY[1] - scrollXY[1])};

	// should we show preview over the placeholder?
	var iFrameHeight = FCK.EditingArea.IFrame.offsetHeight;
	var previewHeight = preview.offsetHeight < 250 ? preview.offsetHeight : 250;
	var showUnder = true;

	if (cloudPos.y + previewHeight > iFrameHeight) {
		// show it over the placeholder
		cloudPos.y -= parseInt(placeholder.clientHeight + 25 + previewHeight);
		showUnder = false;
	}

	// set preview position
	FCK.TemplatePreviewCloud.style.left = cloudPos.x + 'px';
	FCK.TemplatePreviewCloud.style.top = cloudPos.y + 'px';

	// show template preview and cloud
	FCK.TemplatePreviewCloud.style.visibility = 'visible';
	FCK.TemplatePreviewCloud.className = showUnder ? 'cloudUnder' : 'cloudOver';

	FCK.TemplatePreviewCloud.setAttribute('refid', refId);
}

FCK.TemplatePreviewHide = function() {
	FCK.TemplatePreviewCloud.style.visibility = 'hidden';
}

// set/get preview cloud HTML for given template
FCK.TemplatePreviewSetHTML = function(refid, html) {
	var preview = FCKTools.GetElementDocument(FCK.TemplatePreviewCloud).getElementById('wysiwygTemplatePreview' + refid);
	preview.innerHTML = html;

	FCK.wysiwygData[refid].preview = html;

	// reset margin/padding/align
	FCK.TemplatePreviewReset(preview);

	FCK.log('saved template preview for #' + refid);
}

FCK.TemplatePreviewGetHTML = function(refid) {
	return FCK.wysiwygData[refid].preview;
}

FCK.TemplatePreviewSetName = function(refid, name) {
	var input = FCK.GetElementByRefId(refid);
	input.value = FCK.YAHOO.lang.trim(name);
}

// reset template preview margins/padding/float/align
FCK.TemplatePreviewReset = function(previewDiv) {
	if (previewDiv.firstChild && previewDiv.firstChild.nodeType == 1) {
		FCK.YD.addClass(previewDiv.firstChild, 'resetTemplate');
		previewDiv.firstChild.removeAttribute('align');
	}
}

// regenerate elements with refid after redo/undo
FCK.Events.AttachEvent("OnUndoRedo", function() {
	FCK.log('undo/redo catched');
	FCK.SetupElementsWithRefId();
});

//
// runtime setup
//

// YUI reference
FCK.YAHOO = window.parent.YAHOO;
FCK.YD = FCK.YAHOO.util.Dom;
FCK.YE = FCK.YAHOO.util.Event;

// log functionality
FCK.log = function(msg) {
	if (FCK.YAHOO) {
		FCK.YAHOO.log(msg, 'info', 'Wysiwyg');
	}
}

// macbre: setup tracker object
FCK.Tracker = (typeof window.parent.YAHOO != 'undefined' && typeof window.parent.YAHOO.Wikia != 'undefined') ? window.parent.YAHOO.Wikia.Tracker : false;

FCK.Track = function(fakeUrl) {
	if (FCK.Tracker) {
		FCK.Tracker.trackByStr(null, 'wysiwyg'+fakeUrl);
	}
}

// track the fact of using FCK + send the name of edited page
FCK.Track('/init/' + window.parent.wgPageName);

// store editor state (current mode and data) when leaving editor
// IE doesn't seem to support that
if (!FCKBrowserInfo.IsIE) {
	FCKTools.AddEventListener(window, 'beforeunload', function() {
		var typeField = window.parent.document.getElementById('wysiwygTemporarySaveType');
		var contentField = window.parent.document.getElementById('wysiwygTemporarySaveContent');
		var metaField = window.parent.document.getElementById('wysiwygData');

		// save editor state in hidden editor fields
		typeField.value = FCK.EditMode;
		contentField.value = (FCK.EditMode == FCK_EDITMODE_SOURCE) ? FCK.GetData() : FCK.EditorDocument.body.innerHTML;
		metaField.value = FCK.YAHOO.Tools.encodeArr(FCK.wysiwygData);

		FCK.log('editor state saved');
		FCK.Track('/temporarySave/store');
	});
}
else {
	FCK.log('temporary save not supported in your browser');
}

// browsers supporting "contentEditable"
FCK.UseContentEditable = FCKBrowserInfo.IsIE || FCKBrowserInfo.IsGecko19; // IE6+ and FF3

if (FCK.UseContentEditable) {
	FCK.log('using contentEditable');
}

// for us, developers ;)
window.parent.FCK = FCK;
