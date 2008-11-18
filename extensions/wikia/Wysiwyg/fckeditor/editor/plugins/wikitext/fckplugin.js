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

FCK.GetNodesWithRefId = function() {
	var nodes = [];

	// get elements using XPath (at least try)
	if (FCKBrowserInfo.IsIE) {
		// of course IE has it's own standards...
		var method = function(node) {
			return (node.getAttribute('refid') != undefined);
		};

		var nodes = FCK.YAHOO.util.Dom.getElementsBy(method, false, FCK.EditorDocument.body, false);
	}
	else {
		// @see http://www.w3schools.com/XPath/xpath_examples.asp
		// Mozilla-based browser - use XPath
		var results = FCK.EditorDocument.evaluate('//@refid', FCK.EditorDocument, null, XPathResult.ANY_TYPE, null);

		while (attr = results.iterateNext()) {
			nodes.push(attr.ownerElement);
		}
	}

	FCK.log('returning ' + nodes.length + ' nodes with refId');

	return nodes;
}

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
		});

		// get all elements with refid attribute and handle them by value of _fck_type attribute
		var nodes = FCK.GetNodesWithRefId();
		FCK.log(nodes);

		FCK.TemplatePreviewInit();

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
	}

	// for QA team tests
	FCK.GetParentForm().className = (FCK.EditMode == FCK_EDITMODE_WYSIWYG ? 'wysiwyg' : 'source') + '_mode';

});

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
					FCK.YAHOO.util.Dom.removeClass(link, 'new');
					link.href = window.parent.wgServer + window.parent.wgArticlePath.replace(/\$1/, encodeURI(title.replace(/ /g, '_')));
				} else {
					FCK.YAHOO.util.Dom.addClass(link, 'new');
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
// support for non-editable images
//

FCK.ProtectImage = function(image) {
	//FCK.log(image);

	// simple image
	if (image.nodeName.IEquals('a')) {
		// block onclick / onmousedown events
		FCKTools.AddEventListener(image, 'click', function(e) {
			e.preventDefault();
			e.stopPropagation();
			if (e.button == 0) {
				FCK.ProtectImageClick(this.getAttribute('refid'));
			}
		});

		FCKTools.AddEventListener(image, 'contextmenu', function(e) {
			e.preventDefault();
			e.stopPropagation();
		});

		FCKTools.AddEventListener(image, 'mousedown', function(e) {
			e.preventDefault();
			e.stopPropagation();
		});

		return;
	}

	// get image dimensions (including padding)
	var size = [image.clientWidth, image.clientHeight];
	var refid = image.getAttribute('refid');
	
	var iframe = FCK.EditingArea.Document.createElement('iframe');
	iframe.id  = 'image' + refid;
	iframe.src = 'javascript:void()';

	iframe.setAttribute('refid', refid);
	iframe.className = image.className;

	iframe.style.width = parseInt(size[0] + 5) + 'px';
	iframe.style.height = parseInt(size[1] + 5) + 'px';
	iframe.style.border = 'none';
	iframe.style.overflow = 'hidden';

	// store innerHTML
	FCK.wysiwygData[refid].html = image.innerHTML;
	
	// DOM stuff
	image.parentNode.insertBefore(iframe, image);
	image.parentNode.removeChild(image);

	// fill iframe and setup events
	FCK.ProtectImageSetup(refid);
}

FCK.ProtectImageSetup = function(refid) {
	iframe = FCK.EditorDocument.getElementById('image' + refid);

	// fired during the switch between wysiwyg and source mode
	if (!iframe.contentDocument) {
		return true;
	}

	// fill iframe
	iframe.contentDocument.write('<style type="text/css">* {cursor: default !important}</style>');
	iframe.contentDocument.write(FCK.wysiwygData[refid].html);
	iframe.contentDocument.close();
	iframe.contentDocument.body.setAttribute('refid', refid);

	// set event handlers
	FCKTools.AddEventListener(iframe.contentDocument, 'click', function(e) {
		e.preventDefault();
		e.stopPropagation();
		if (e.button == 0) {
			FCK.ProtectImageClick(this.body.getAttribute('refid'));
		}
	});

	FCKTools.AddEventListener(iframe.contentDocument, 'contextmenu', function(e) {
		e.preventDefault();
		e.stopPropagation();
	});

	FCKTools.AddEventListener(iframe.contentDocument, 'mousedown', function(e) {
		e.preventDefault();
		e.stopPropagation();
	});

	FCKTools.AddEventListener(iframe.contentWindow, 'unload', function(e) {
		var target = FCK.YAHOO.util.Event.getTarget(e);
		var refId = target.body.getAttribute('refid');

		FCK.log('iframe #' + refid  + ' unload captured');

		setTimeout('FCK.ProtectImageSetup('+refid+')', 50);
	});


	// load CSS files
	css = document.createElement("link");
	css.type = "text/css";
	css.rel = "stylesheet";
	css.href = FCKConfig.EditorAreaStyles + '?' + FCKConfig.StyleVersion;
	iframe.contentDocument.getElementsByTagName("head")[0].appendChild(css);

	css = document.createElement("link");
	css.type = "text/css";
	css.rel = "stylesheet";
	css.href = FCKConfig.EditorAreaCSS + '?' + FCKConfig.StyleVersion;
	iframe.contentDocument.getElementsByTagName("head")[0].appendChild(css);

	FCK.log('set up image #' + refid + ' iframe');
}

FCK.ProtectImageClick = function(refid) {
	FCK.log('click on image #' + refid);

	// tracker
	FCK.Track('/image/click');

	FCK.ProtectImageRefId = refid;

	// TODO: handle onclick event (only left mouse button)
	// wmuShow();
}

FCK.ProtectImageUpdate = function(refid, wikitext) {
	// TODO: call it from WMU to update and rescale iframe
	FCK.log('updating #' + refid +' with >>' + wikitext + '<<');

	// update metaData
	var params = wikitext.substring(2, wikitext.length-2).split('|');
	FCK.wysiwygData[refid].href = params.shift();
	FCK.wysiwygData[refid].description = params.join('|');

	FCK.log(FCK.wysiwygData[refid]);

	// get image placeholder
	iframe = FCK.EditorDocument.getElementById('image' + refid);

	// parse given wikitext
	var callback = {
		success: function(o) {
			FCK = o.argument.FCK;
			iframe = o.argument.iframe;
			refid =  o.argument.refid;

			result = eval('(' + o.responseText + ')');
			html = result.parse.text['*'];

			// remove newPP comment and whitespaces
			html = FCK.YAHOO.lang.trim(html.split('<!-- \nNewPP limit report')[0]);

			// fill and rescale iframe
			FCK.wysiwygData[refid].html = html;
			FCK.ProtectImageSetup(refid);

			// root element inside iframe (image thumb wrapper)
			var rootElement = iframe.contentDocument.body.firstChild;

			iframe.className = rootElement.className;

			// get image dimensions (including padding) and rescale iframe
			var size = [rootElement.clientWidth, rootElement.clientHeight];
			iframe.style.width = parseInt(size[0] + 5) + 'px';
			iframe.style.height = parseInt(size[1] + 5) + 'px';
			
			// remove rootElement by moving up his children nodes
			FCKDomTools.RemoveNode(rootElement, true);
		},
		failure: function(o) {},
		argument: {'FCK': FCK, 'refid': refid, 'iframe': iframe}
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
	placeholder.id = 'wysiwygTemplate' + refId;	

	previewDiv.innerHTML = preview.value + '<br style="clear:both" />';
	previewDiv.setAttribute('refid', refId);

	// sometimes innerHTML contains whitespices at the end -> fix it
	previewDiv.innerHTML = previewDiv.innerHTML.Trim();
	previewDiv.style.display = 'none';

	// remove preview div from editing area
	preview.parentNode.removeChild(preview);

	// remove any whitespaces from the end of placeholder's parent
	lastChild = placeholder.parentNode.lastChild;
	if (lastChild.nodeType == 3 && (lastChild.textContent.Trim() == '') ) {
		lastChild.parentNode.removeChild(lastChild);
	}

	// register events handlers
	FCKTools.AddEventListener(placeholder, 'mouseover', function(e) {
		FCK.TemplatePreviewShow(FCK.YAHOO.util.Event.getTarget(e));

		clearTimeout(FCK.TemplatePreviewTimeouts.Tag);
		clearTimeout(FCK.TemplatePreviewTimeouts.Cloud);
	});
	
	FCKTools.AddEventListener(placeholder, 'mouseout', function(e) {
		// hide preview 0,5 sec. after mouseout from tag
		FCK.TemplatePreviewTimeouts.Tag = setTimeout('FCK.TemplatePreviewHide()', 500);
	});

	// template editor
	FCKTools.AddEventListener(placeholder, 'click', function(e) {
		var target = FCK.YAHOO.util.Event.getTarget(e);
		FCK.TemplateRefId = target.getAttribute('refid');
		FCK.TemplateClickCommand.Execute();
	});

	FCKTools.AddEventListener(previewDiv, 'click', function(e) {
		e.preventDefault();
		e.stopPropagation();

		FCK.TemplateRefId = this.getAttribute('refid');
		FCK.TemplateClickCommand.Execute();
	});
}

FCK.TemplatePreviewShow = function(placeholder) {
	
	var refId = placeholder.getAttribute('refid');
	var preview = FCKTools.GetElementDocument(FCK.TemplatePreviewCloud).getElementById('wysiwygTemplatePreview' + refId);

	// hide all previews / show just the one we need
	var previews = FCK.TemplatePreviewCloud.firstChild.childNodes;

	for (p=0; p<previews.length; p++) {
		previews[p].style.display = 'none';
	}

	preview.style.display = '';

	// reset margin/padding
	if (preview.firstChild && preview.firstChild.nodeType == 1) {
		preview.firstChild.style.padding = 0;
		preview.firstChild.style.margin = 0;
	}

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
}

FCK.TemplatePreviewHide = function() {
	FCK.TemplatePreviewCloud.style.visibility = 'hidden';
}

// set/get preview cloud HTML for given template
FCK.TemplatePreviewSetHTML = function(refid, html) {
	var preview = FCKTools.GetElementDocument(FCK.TemplatePreviewCloud).getElementById('wysiwygTemplatePreview' + refid);
	preview.innerHTML = html;

	// add "floats clearing" <br> after complicated infoboxes
	if ( (!preview.firstChild.nodeName.IEquals('p')) || (preview.childNodes.length != 1) ) {
		preview.innerHTML += '<br style="clear:both" />';
	}

	FCK.log('saved template preview for #' + refid);
}

FCK.TemplatePreviewGetHTML = function(refid) {
	var preview = FCKTools.GetElementDocument(FCK.TemplatePreviewCloud).getElementById('wysiwygTemplatePreview' + refid);
	return preview.innerHTML;
}

FCK.TemplatePreviewSetName = function(refid, name) {
	var input = FCK.EditorDocument.getElementById('wysiwygTemplate' + refid);
	input.value = name;
}

//
// misc
//

// YUI reference
FCK.YAHOO = window.parent.YAHOO;

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

// for us, developers ;)
window.parent.FCK = FCK;
