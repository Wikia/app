YAHOO.namespace('CategorySelect');

var Event = YAHOO.util.Event;
var Dom = YAHOO.util.Dom;
var DDM = YAHOO.util.DragDropMgr;
var oAutoComp;
var categories;
var fixCategoryRegexp = new RegExp('\\[\\[(?:' + csCategoryNamespaces + '):([^\\]]+)]]', 'i');
var ajaxUrl = wgServer + wgScript + '?action=ajax';
var csType = 'edit';

function positionSuggestBox() {
	$('csSuggestContainer').style.top = $('csCategoryInput').offsetTop + jQuery("#" + 'csCategoryInput').height() + 5 + 'px';
	$('csSuggestContainer').style.left = Math.min($('csCategoryInput').offsetLeft, (Dom.getViewportWidth() - jQuery('#' + 'csItemsContainer').offset().left - jQuery("#" + 'csSuggestContainer').width() - 10)) + 'px';
}

function extractSortkey(text) {
	var result = {'name': text, 'sort' : ''};
	var len = text.length;
	var curly = square = 0;
	var pipePos = -1;
	for (i = 0; i < len && pipePos == -1; i++) {
		switch (text.charAt(i)) {
			case '{':
				curly++;
				break;
			case '}':
				curly--;
				break;
			case '[':
				square++;
				break;
			case ']':
				square--;
				break;
			case '|':
				if (curly == 0 && square == 0) {
					pipePos = i;
			}
		}
	}
	if (pipePos != -1) {
		result['name'] = text.slice(0, pipePos);
		result['sort'] = text.slice(pipePos + 1);
	}
	return result;
}

function deleteCategory(e) {
	var catId = e.parentNode.parentNode.getAttribute('catId');
	e.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode);
	delete categories[catId];
}

function modifyCategoryDialog(data, handler) {
	Dialog = new YAHOO.widget.SimpleDialog('csModifyCategoryDialog',
	{
		width: "300px",
		zIndex: 999,
		effect: {effect: YAHOO.widget.ContainerEffect.FADE, duration: 0.25},
		fixedcenter: true,
		modal: true,
		draggable: true,
		close: true
	});

	var buttons = [ { text: data.save, handler: function() {
		// close dialog
		this.hide();

		var returnObject = {
			'params': data,
			'category': document.getElementById('csInfoboxCategory').value,
			'sortkey': document.getElementById('csInfoboxSortKey').value
		};

		// return control to handler
		handler(returnObject);

	}} ];

	Dialog.setHeader(data.caption);
	Dialog.setBody(data.content);
	Dialog.cfg.queueProperty("buttons", buttons);

	Dialog.render(document.body);
	//fill up initial values
	$('csInfoboxCategory').value = data['data']['category'];
	$('csInfoboxSortKey').value = data['data']['sortkey'];
	Dialog.show();
	//focus input on displayed dialog
	$('csInfoboxCategory').focus();
}

function modifyCategory(e) {
	var catId = e.parentNode.parentNode.getAttribute('catId');
	defaultSortkey = categories[catId].sortkey != '' ? categories[catId].sortkey : (csDefaultSort != '' ? csDefaultSort : wgTitle);

	modifyCategoryDialog({
		'catId': catId,
		'caption': csInfoboxCaption,
		'content': '<label for="csInfoboxCategory">' + csInfoboxCategoryText + '</label>' +
			'<br/><input type="text" id="csInfoboxCategory" />' +
			'<br/><label for="csInfoboxSortKey">' + csInfoboxSortkeyText.replace('$1', categories[catId].category).replace('<', '&lt;').replace('>', '&gt;') + '</label>' +
			'<br/><input type="text" id="csInfoboxSortKey" />',
		'data': {'category': categories[catId].category, 'sortkey': defaultSortkey},
		'save': csInfoboxSave
	},
	function(data) {
		extractedParams = extractSortkey(data['category']);
		data['category'] = extractedParams['name'];

		if (data['category'] == '') {
			alert(csEmptyName);
			return;
		}

		if (categories[catId].category != data['category']) {
			categories[catId].category = data['category'];
			var items = $('csItemsContainer').getElementsByTagName('a');
			for (i=0; i<items.length; i++) {
				if (items[i].getAttribute('catId') == catId) {
					items[i].firstChild.firstChild.nodeValue = data['category'];
					break;
				}
			}
		}
		var sortkey = data['sortkey'];
		if (sortkey != null) {
			if (sortkey == wgTitle || sortkey == csDefaultSort) {
				sortkey = '';
			}
			sortkey = extractedParams['sort'] + sortkey;
			categories[catId].sortkey = sortkey;
		}
		if (categories[catId].sortkey == '') {
			oldClassName = 'CScontrolSorted';
			newClassName = 'CScontrolSort';
		} else {
			oldClassName = 'CScontrolSort';
			newClassName = 'CScontrolSorted';
		}
		Dom.replaceClass(e, oldClassName , newClassName);
	});
}

function replaceAddToInput(e) {
	$('csAddCategoryButton').style.display = 'none';
	$('csCategoryInput').style.display = 'block';
	positionSuggestBox();
	$('csHintContainer').style.display = 'block';
	$('csCategoryInput').focus();
}

function addAddCategoryButton() {
	if ($('csAddCategoryButton') != null) {
		$('csAddCategoryButton').style.display = 'block';
	} else {
		elementA = document.createElement('a');
		elementA.id = 'csAddCategoryButton';
		elementA.className = 'CSitem CSaddCategory'; //setAttribute doesn't work in IE
		elementA.tabindex = '-1';
		elementA.onfocus = 'this.blur()';
		elementA.onclick = function(e) {replaceAddToInput(this); return false;};

		elementSpanOuter = document.createElement('span');
		elementSpanOuter.className = 'CSitemOuterAddCategory';
		elementA.appendChild(elementSpanOuter);

		elementText = document.createTextNode(csAddCategoryButtonText);
		elementSpanOuter.appendChild(elementText);

		elementSpan = document.createElement('span');
		elementSpan.className = 'CScontrol CScontrolAdd';
		elementSpan.onclick = function(e) {replaceAddToInput(this); return false;};
		elementSpanOuter.appendChild(elementSpan);

		$('csItemsContainer').appendChild(elementA);
	}
}

function inputBlur() {
	if ($('csCategoryInput').value == '') {
		$('csCategoryInput').style.display = 'none';
		$('csHintContainer').style.display = 'none';
		addAddCategoryButton();
	}
}

function addCategory(category, params, index) {
	if (params == undefined) {
		params = {'namespace': csDefaultNamespace, 'outerTag': '', 'sortkey': ''};
	}

	if (index == undefined) {
		index = categories.length;
	}

	//replace full wikitext that user may provide (eg. [[category:abc]]) to just a name (abc)
	category = category.replace(fixCategoryRegexp, '$1');
	//if user provides "abc|def" explode this into category "abc" and sortkey "def"
	extractedParams = extractSortkey(category);
	category = extractedParams['name'];
	params['sortkey'] = extractedParams['sort'] + params['sortkey'];

	if (category == '') {
		alert(csEmptyName);
		return;
	}

	categories[index] = {'namespace': params['namespace'] ? params['namespace'] : csDefaultNamespace, 'category': category, 'outerTag': params['outerTag'], 'sortkey': params['sortkey']};

	elementA = document.createElement('a');
	elementA.className = 'CSitem';	//setAttribute doesn't work in IE
	elementA.tabindex = '-1';
	elementA.onfocus = 'this.blur()';
	elementA.setAttribute('catId', index);

	elementSpanOuter = document.createElement('span');
	elementSpanOuter.className = 'CSitemOuter';
	elementA.appendChild(elementSpanOuter);

	elementText = document.createTextNode(category);
	elementSpanOuter.appendChild(elementText);

	elementSpan = document.createElement('span');
	elementSpan.className = 'CScontrol CScontrolRemove';
	elementSpan.onclick = function(e) {deleteCategory(this); return false;};
	elementSpanOuter.appendChild(elementSpan);

	elementSpan = document.createElement('span');
	elementSpan.className = 'CScontrol ' + (params['sortkey'] == '' ? 'CScontrolSort' : 'CScontrolSorted');
	elementSpan.onclick = function(e) {modifyCategory(this); return false;};
	elementSpanOuter.appendChild(elementSpan);

	$('csItemsContainer').insertBefore(elementA, $('csCategoryInput'));
	if ($('csCategoryInput').style.display != 'none') {
		$('csHintContainer').style.display = 'block';
	}
	$('csCategoryInput').value = '';

	//Drag&Drop
	new YAHOO.CategorySelect.DDList(elementA);
}

function generateWikitextForCategories() {
	var categoriesStr = '';
	for (c=0; c < categories.length; c++) {
		catTmp = '[[' + categories[c].namespace + ':' + categories[c].category + (categories[c].sortkey == '' ? '' : ('|' + categories[c].sortkey)) + ']]';
		if (categories[c].outerTag != '') {
			catTmp = '<' + categories[c].outerTag + '>' + catTmp + '</' + categories[c].outerTag + '>';
		}
		categoriesStr += catTmp + "\n";
	}
	return categoriesStr;
}

function initializeCategories(cats) {
	//move categories metadata from hidden field [JSON encoded] into array
	if (cats == undefined) {
		cats = $('wpCategorySelectWikitext') == null ? '' : $('wpCategorySelectWikitext').value;
		categories = cats == '' ? new Array() : eval(cats);
	} else {
		categories = cats;
	}

	//inform PHP what source should it use [this field exists only in 'edit page' mode]
	if ($('wpCategorySelectSourceType') != null) {
		$('wpCategorySelectSourceType').value = 'json';
	}

	addAddCategoryButton();
	for (c=0; c < categories.length; c++) {
		addCategory(categories[c].category, {'namespace': categories[c].namespace, 'outerTag': categories[c].outerTag, 'sortkey': categories[c].sortkey}, c);
	}

	//Drag&Drop
	new YAHOO.util.DDTarget('csItemsContainer');
}

function initializeDragAndDrop() {

	YAHOO.CategorySelect.DDList = function(id, sGroup, config) {
		YAHOO.CategorySelect.DDList.superclass.constructor.call(this, id, sGroup, config);
		this.logger = this.logger || YAHOO;
		var el = this.getDragEl();
		Dom.setStyle(el, 'opacity', 0.67); // The proxy is slightly transparent

		this.goingLeft = false;
		this.lastX = 0;
		this.useShim = true;
	};

	YAHOO.extend(YAHOO.CategorySelect.DDList, YAHOO.util.DDProxy, {

		startDrag: function(x, y) {
			this.logger.log(this.id + ' startDrag');

			// make the proxy look like the source element
			var dragEl = this.getDragEl();
			var clickEl = this.getEl();
			Dom.setStyle(clickEl, 'visibility', 'hidden');

			dragEl.innerHTML = clickEl.innerHTML;

			Dom.setStyle(dragEl, 'color', Dom.getStyle(clickEl, 'color'));
			Dom.setStyle(dragEl, 'backgroundColor', Dom.getStyle(clickEl, 'backgroundColor'));
			Dom.setStyle(dragEl, 'font-size', Dom.getStyle(clickEl, 'font-size'));
			Dom.setStyle(dragEl, 'line-height', Dom.getStyle(clickEl, 'line-height'));
			Dom.setStyle(dragEl, 'border', '1px solid gray');
		},

		endDrag: function(e) {
			var srcEl = this.getEl();
			var proxy = this.getDragEl();

			// Show the proxy element and animate it to the src element's location
			Dom.setStyle(proxy, 'visibility', '');
			var a = new YAHOO.util.Motion(
				proxy, {
					points: {
						to: Dom.getXY(srcEl)
					}
				},
				0.2,
				YAHOO.util.Easing.easeOut
			)
			var proxyid = proxy.id;
			var thisid = this.id;

			// Hide the proxy and show the source element when finished with the animation
			a.onComplete.subscribe(function() {
					Dom.setStyle(proxyid, 'visibility', 'hidden');
					Dom.setStyle(thisid, 'visibility', '');
				});
			a.animate();

			var prevSibId = (srcEl.previousSibling && srcEl.previousSibling.nodeType == 1 && srcEl.previousSibling.nodeName.toLowerCase() == 'a') ? srcEl.previousSibling.getAttribute('catid') : -1;
			moveElement(srcEl.getAttribute('catid'), prevSibId);
		},

		onDrag: function(e) {
			// Keep track of the direction of the drag for use during onDragOver
			var x = Event.getPageX(e);

			if (x < this.lastX) {
				this.goingLeft = true;
			} else if (x > this.lastX) {
				this.goingLeft = false;
			}

			this.lastX = x;
		},

		onDragOver: function(e, id) {
			var srcEl = this.getEl();
			var destEl = Dom.get(id);

			// We are only concerned with list items, we ignore the dragover
			// notifications for the list.
			if (destEl.nodeName.toLowerCase() == 'a') {
				var orig_p = srcEl.parentNode;
				var p = destEl.parentNode;

				if (this.goingLeft) {
					p.insertBefore(srcEl, destEl); // insert on left
				} else {
					p.insertBefore(srcEl, destEl.nextSibling); // insert on right
				}

				DDM.refreshCache();
			}
		}
	});
}

function toggleCodeView() {
	if ($('csWikitextContainer').style.display != 'block') {	//switch to code view
		$('csWikitext').value = generateWikitextForCategories();
		$('csItemsContainer').style.display = 'none';
		$('csHintContainer').style.display = 'none';
		$('csCategoryInput').style.display = 'none';
		$('csSwitchView').innerHTML = csVisualView;
		$('csWikitextContainer').style.display = 'block';
		$('wpCategorySelectWikitext').value = '';	//remove JSON - this will inform PHP to use wikitext instead
		$('wpCategorySelectSourceType').value = 'wiki';	//inform PHP what source should it use
	} else {	//switch to visual code
		var pars = 'rs=CategorySelectAjaxParseCategories&rsargs=' + encodeURIComponent($('csWikitext').value + ' ');
		var callback = {
			success: function(originalRequest) {
				var result = eval('(' + originalRequest.responseText + ')');
				if (result['error'] != undefined) {
					YAHOO.log('AJAX result: error');
					alert(result['error']);
				} else if (result['categories'] != undefined) {
					YAHOO.log('AJAX result: OK');
					//delete old categories [HTML items]
					var items = $('csItemsContainer').getElementsByTagName('a');
					for (i=items.length-1; i>=0; i--) {
						if (items[i].getAttribute('catId') != null) {
							items[i].parentNode.removeChild(items[i]);
						}
					}
					initializeCategories(result['categories']);
					$('csSwitchView').innerHTML = csCodeView;
					$('csWikitextContainer').style.display = 'none';
					$('csItemsContainer').style.display = 'block';
				}
			},
			timeout: 30000
		};
		YAHOO.util.Connect.asyncRequest('POST', ajaxUrl, callback, pars);
	}
}

function moveElement(movedId, prevSibId) {
	movedId = parseInt(movedId);
	prevSibId = parseInt(prevSibId);

	movedItem = categories[movedId];
	newCat = new Array();
	if (movedId < prevSibId) {	//move right
		newCat = newCat.concat(categories.slice(0, movedId),
			categories.slice(movedId+1, prevSibId+1),
			movedItem,
			categories.slice(prevSibId+1));
	} else {	//move left
		if (prevSibId != -1) {
			newCat = newCat.concat(categories.slice(0, prevSibId+1));
		}
		newCat = newCat.concat(movedItem,
			categories.slice(prevSibId+1, movedId),
			categories.slice(movedId+1));
	}
	//reorder catId in HTML elements
	var itemId = 0;
	var items = $('csItemsContainer').getElementsByTagName('a');
	for (catId=0; catId < newCat.length; catId++) {
		if (newCat[catId] == undefined) {
			continue;
		}
		items[itemId++].setAttribute('catId', catId);
	}
	//save changes into main array
	categories = newCat;
}

function inputKeyPress(e) {
	if(e.keyCode == 13) {
		//TODO: stop AJAX call for AutoComplete
		YAHOO.util.Event.preventDefault(e);
		category = $('csCategoryInput').value;
		if (category != '' && oAutoComp._oCurItem == null) {
			addCategory(category);
		}
	}
	positionSuggestBox();
}

function submitAutoComplete(comp, resultListItem) {
	addCategory(resultListItem[2][0]);
	positionSuggestBox();
}

function collapseAutoComplete() {
	if ($('csCategoryInput').style.display != 'none' && $('csWikitextContainer').style.display != 'block') {
		$('csHintContainer').style.display = 'block';
	}
}

function expandAutoComplete(sQuery , aResults) {
	$('csHintContainer').style.display = 'none';
}

function regularEditorSubmit(e) {
	$('wpCategorySelectWikitext').value = YAHOO.Tools.JSONEncode(categories);
}

function getCategories(sQuery) {
	if(typeof categoryArray != 'object') {
		return;
	}
	var resultsFirst = [];
	var resultsSecond = [];
	sQuery = unescape(sQuery);
	sQuery = sQuery.toLowerCase().replace(/_/g, ' ');

	for (var i = 0, len = categoryArray.length; i < len; i++) {
		var index = categoryArray[i].toLowerCase().indexOf(sQuery);
		if (index == 0) {
			resultsFirst.push([categoryArray[i]]);
		} else if (index > 0) {
			resultsSecond.push([categoryArray[i]]);
		}
		if ((resultsFirst.length + resultsSecond.length) == 10) {
			break;
		}
	}
	return resultsFirst.concat(resultsSecond);
}

function initAutoComplete() {
	// Init datasource
	var oDataSource = new YAHOO.widget.DS_JSFunction(getCategories);
	//oDataSource.queryMatchCase = true;

	// Init AutoComplete object and assign datasource object to it
	oAutoComp = new YAHOO.widget.AutoComplete('csCategoryInput', 'csSuggestContainer', oDataSource);
	oAutoComp.autoHighlight = false;
	oAutoComp.queryDelay = 0;
	oAutoComp.highlightClassName = 'CSsuggestHover';
	oAutoComp.queryMatchContains = true;
	oAutoComp.itemSelectEvent.subscribe(submitAutoComplete);
	oAutoComp.containerCollapseEvent.subscribe(collapseAutoComplete);
	oAutoComp.containerExpandEvent.subscribe(expandAutoComplete);
	//do not show delayed ajax suggestion when user already added the category
	oAutoComp.doBeforeExpandContainer = function (elTextbox, elContainer, sQuery, aResults) {return elTextbox.value != '';};
}

function initHandlers() {
	//handle [enter] for non existing categories
	YAHOO.util.Event.addListener('csCategoryInput', 'keypress', inputKeyPress);
	YAHOO.util.Event.addListener('csCategoryInput', 'blur', inputBlur);
	if (typeof formId != 'undefined') {
		YAHOO.util.Event.addListener(formId, 'submit', regularEditorSubmit);
	}
}

function initTooltip() {
	// Init tooltip
	var tooltip =  YAHOO.util.Dom.get('csTooltip');

	if (tooltip) {
		tooltip.style.display = 'block';
		tooltip.style.top = ((jQuery('#csTooltip').height() + 8) * -1) + 'px';
		YAHOO.util.Event.addListener('csTooltipClose', 'click', function(e) {
			YAHOO.util.Dom.get('csTooltip').style.display = 'none';
			sajax_do_call('CategorySelectRemoveTooltip', [], function() {});
		});
	}
}

//`view article` mode
function showCSpanel() {
	csType = 'view';
	var pars = 'rs=CategorySelectGenerateHTMLforView';
	var callback = {
		success: function(originalRequest) {
			var el = document.createElement('div');
			el.innerHTML = originalRequest.responseText;
			$('catlinks').appendChild(el);
			initHandlers();
			initAutoComplete();
			initializeDragAndDrop();
			initializeCategories();
			YAHOO.util.Get.css(wgExtensionsPath+'/wikia/CategorySelect/CategorySelect.css?'+wgStyleVersion, {onSuccess:function() {
				setTimeout('replaceAddToInput()', 60);
				setTimeout('positionSuggestBox()', 666);	//sometimes it can take more time to parse downloaded CSS - be sure to position hint in proper place
				YAHOO.util.Dom.removeClass('catlinks', 'csLoading');
			}});
		},
		timeout: 30000
	};
	YAHOO.util.Connect.asyncRequest('POST', ajaxUrl, callback, pars);
	$('csAddCategorySwitch').style.display = 'none';
}

function csSave() {
	var pars = 'rs=CategorySelectAjaxSaveCategories&rsargs[]=' + wgArticleId + '&rsargs[]=' + encodeURIComponent(YAHOO.Tools.JSONEncode(categories));
	var callback = {
		success: function(originalRequest) {
			var result = eval('(' + originalRequest.responseText + ')');
			if (result['info'] == 'ok' && result['html'] != '') {
				tmpDiv = document.createElement('div');
				tmpDiv.innerHTML = result['html'];
				var innerCatlinks = $('mw-normal-catlinks');
				if (innerCatlinks) {
					$('mw-normal-catlinks').parentNode.replaceChild(tmpDiv.firstChild, $('mw-normal-catlinks'));
				} else {
					$('catlinks').insertBefore(tmpDiv.firstChild, $('catlinks').firstChild);
				}
			}
			csCancel();
		},
		timeout: 30000
	};
	YAHOO.util.Connect.asyncRequest('POST', ajaxUrl, callback, pars);

	// add loading indicator and disable buttons
	YAHOO.util.Dom.addClass('csButtonsContainer', 'csSaving');
	$('csSave').disabled = true;
	$('csCancel').disabled = true;
}

function csCancel() {
	var csMainContainer = $('csMainContainer');
	csMainContainer.parentNode.removeChild(csMainContainer);
	$('csAddCategorySwitch').style.display = 'block';
}

wgAfterContentAndJS.push(function() {
	if (csType == 'edit') {
		initHandlers();
		initAutoComplete();
		initializeDragAndDrop();
		initializeCategories();
		//show switch after loading categories
		$('csSwitchViewContainer').style.display = 'block';

		// Init tooltip
		initTooltip();
	}
});