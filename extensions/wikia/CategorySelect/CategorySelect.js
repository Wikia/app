var Event = YAHOO.util.Event;
var Dom = YAHOO.util.Dom;
var categories, fixCategoryRegexp;
//HTML IDs
csCategoryInputId = 'csCategoryInput';
csHintContainerId = 'csHintContainer';
csSuggestContainerId = 'csSuggestContainer';
csMainContainerId = 'csMainContainer';
csItemsContainerId = 'csItemsContainer';
csWikitextId = 'csWikitext';
csWikitextContainerId = 'csWikitextContainer';
csSwitchViewContainerId = 'csSwitchViewContainer';
csSwitchViewId = 'csSwitchView';
csSourceTypeId = 'wpCategorySelectSourceType';
csCategoryFieldId = 'wpCategorySelectWikitext';
csAddCategoryButtonId = 'csAddCategoryButton';
csDefaultNamespace = 'Category';	//TODO: default namespace

function positionSuggestBox() {
	$(csSuggestContainerId).style.top = $(csCategoryInputId).offsetTop + jQuery("#" + csCategoryInputId).height() + 5 + 'px';
	$(csSuggestContainerId).style.left = Math.min($(csCategoryInputId).offsetLeft, (Dom.getViewportWidth() - jQuery('#' + csItemsContainerId).offset().left - jQuery("#" + csSuggestContainerId).width() - 10)) + 'px';
}

function deleteCategory(e) {
	var catId = e.parentNode.parentNode.getAttribute('catId');
	YAHOO.log('deleting catId = ' + catId);
	YAHOO.log(e.parentNode.parentNode);
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

	YAHOO.log(data);

	var buttons = [ { text: data.save, handler: function() {
		// close dialog
		this.hide();

		var returnObject = {
			'params': data,
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
	$('csInfoboxSortKey').value = data['data']['sortkey'];
	Dialog.show();
	//focus input on displayed dialog
	$('csInfoboxSortKey').focus();
}

function modifyCategory(e) {
	var catId = e.parentNode.parentNode.getAttribute('catId');
	YAHOO.log('catId = ' + catId);
	YAHOO.log(categories[catId]);
	defaultSortkey = categories[catId].sortkey != '' ? categories[catId].sortkey : (csDefaultSort != '' ? csDefaultSort : wgTitle);

	modifyCategoryDialog({
		'catId': catId,
		'caption': csProvideCategoryCaption,
		'content': '<label for="csInfoboxSortKey">' + csProvideCategoryText.replace('$1', categories[catId].category) + '</label>' +
			'<input type="text" id="csInfoboxSortKey" />',
		'data': {'sortkey': defaultSortkey},
		'save': csProvideCategorySave
	},
	function(data) {
		YAHOO.log(data);

		var sortkey = data['sortkey'];
		if (sortkey != null) {
			if (sortkey == wgTitle || sortkey == csDefaultSort) {
				sortkey = '';
			}
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
	$(csAddCategoryButtonId).style.display = 'none';
	$(csCategoryInputId).style.display = 'block';
	positionSuggestBox();
	$(csHintContainerId).style.display = 'block';
	$(csCategoryInputId).focus();
}

function addAddCategoryButton() {
	if ($(csAddCategoryButtonId) != null) {
		$(csAddCategoryButtonId).style.display = 'block';
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

		$(csItemsContainerId).appendChild(elementA);
	}
}

function inputBlur() {
	if ($(csCategoryInputId).value == '') {
		$(csCategoryInputId).style.display = 'none';
		$(csHintContainerId).style.display = 'none';
		addAddCategoryButton();
	}
}

function addCategory(category, params, index) {
	YAHOO.log('addCategory: index = ' + index + ', category = ' + category);
	if (params == undefined) {
		params = {'outerTag': '', 'sortkey': ''};
	}

	if (index == undefined) {
		index = categories.length;
	}
	//replace full wikitext that user may provide (eg. [[category:abc]]) to just a name (abc)
	category = category.replace(fixCategoryRegexp, '$1');

	categories[index] = {'namespace': csDefaultNamespace, 'category': category, 'outerTag': params['outerTag'], 'sortkey': params['sortkey']};

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

	$(csItemsContainerId).insertBefore(elementA, $(csCategoryInputId));

	$(csCategoryInputId).value = '';
}

function generateWikitextForCategories() {
	var categoriesStr = '';
	for(c in categories) {
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
		cats = $(csCategoryFieldId).value;
		categories = cats == '' ? new Array() : eval(cats);
	} else {
		categories = cats;
	}

	//inform PHP what source should it use
	$(csSourceTypeId).value = 'json';

	addAddCategoryButton();
	for(c in categories) {
		addCategory(categories[c].category, {'outerTag': categories[c].outerTag, 'sortkey': categories[c].sortkey}, c);
	}
}

function toggleCodeView() {
	if ($(csWikitextContainerId).style.display != 'block') {	//switch to code view
		$(csWikitextId).value = generateWikitextForCategories();
		$(csItemsContainerId).style.display = 'none';
		$(csSwitchViewId).innerHTML = csVisualView;
		$(csWikitextContainerId).style.display = 'block';
		$(csCategoryFieldId).value = '';	//remove JSON - this will inform PHP to use wikitext instead
		$(csSourceTypeId).value = 'wiki';	//inform PHP what source should it use
	} else {	//switch to visual code
		var ajaxUrl = wgServer + wgScript + '?action=ajax';
		var pars = 'rs=CategorySelectAjaxParseCategories&rsargs=' + escape($(csWikitextId).value);
		var callback = {
			success: function(originalRequest) {
				result = eval('(' + originalRequest.responseText + ')');
				if (result['error'] != undefined) {
					YAHOO.log('AJAX result: error');
					alert(result['error']);
				} else if (result['categories'] != undefined) {
					YAHOO.log('AJAX result: OK');
					//delete old categories [HTML items]
					var items = $(csItemsContainerId).getElementsByTagName('a');
					for (i=items.length-1; i>=0; i--) {
						if (items[i].getAttribute('catId') != null) {
							items[i].parentNode.removeChild(items[i]);
						}
					}
					initializeCategories(result['categories']);
					$(csSwitchViewId).innerHTML = csCodeView;
					$(csWikitextContainerId).style.display = 'none';
					$(csItemsContainerId).style.display = 'block';
				}
			},
			timeout: 30000
		};
		YAHOO.util.Connect.asyncRequest('POST', ajaxUrl, callback, pars);
	}
}

function moveElement(movedId, prevSibbId) {
	movedItem = categories[movedId];
	newCat = new Array();
	if (movedId < prevSibbId) {	//move right
		newCat = newCat.concat(categories.slice(0, movedId),
			categories.slice(movedId+1, prevSibbId+1),
			movedItem,
			categories.slice(prevSibbId+1));
	} else {	//move left
		if (prevSibbId != -1) {
			newCat = newCat.concat(categories.slice(0, prevSibbId+1));
		}
		newCat = newCat.concat(movedItem,
			categories.slice(prevSibbId+1, movedId),
			categories.slice(movedId+1));
	}
	//reorder catId in HTML elements
	var itemId = 0;
	var items = $(csItemsContainerId).getElementsByTagName('a');
	for (catId in newCat) {
		if (newCat[catId] == undefined) {
			continue;
		}
		items[itemId++].setAttribute('catId', catId);
	}
	//save changes into main array
	categories = newCat;
}

Event.onDOMReady(function() {
	YAHOO.log('onDOMReady');

	fixCategoryRegexp = new RegExp('\\[\\[(?:' + csCategoryNamespaces + '):([^\\]]+)]]', 'i');
	initializeCategories();
	//show switch after loading categories
	$(csSwitchViewContainerId).style.display = 'block';

	var submitAutoComplete = function(comp, resultListItem) {
		YAHOO.log('selected category:' + resultListItem[2]);
		addCategory(resultListItem[2][0]);
	};

	var collapseAutoComplete = function() {
		$(csHintContainerId).style.display = 'block';
	}

	var expandAutoComplete = function(sQuery , aResults) {
		$(csHintContainerId).style.display = 'none';
	}

	var inputKeyPress = function(e) {
		if(e.keyCode == 13) {
			//TODO: stop AJAX call for AutoComplete
			YAHOO.util.Event.preventDefault(e);
			category = $(csCategoryInputId).value;
			YAHOO.log('enter pressed, value = ' + category);
			if (category != '') {
				addCategory(category);
			}
		}
		positionSuggestBox();
	};

	//handle [enter] for non existing categories
	YAHOO.util.Event.addListener(csCategoryInputId, 'keypress', inputKeyPress);
	YAHOO.util.Event.addListener(csCategoryInputId, 'blur', inputBlur);

	var regularEditorSubmit = function(e) {
		$(csCategoryFieldId).value = YAHOO.Tools.JSONEncode(categories);
	}

	YAHOO.util.Event.addListener(formId, 'submit', regularEditorSubmit);

	// Init datasource
	var oDataSource = new YAHOO.widget.DS_XHR(wgServer + wgScriptPath + '/', ["\n"]);
	oDataSource.responseType = YAHOO.widget.DS_XHR.TYPE_FLAT;
	oDataSource.scriptQueryAppend = 'action=ajax&rs=CategorySelectAjaxGetCategories';

	// Init AutoComplete object and assign datasource object to it
	var oAutoComp = new YAHOO.widget.AutoComplete(csCategoryInputId, csSuggestContainerId, oDataSource);
	oAutoComp.autoHighlight = false;
	oAutoComp.queryDelay = 0.5;
	oAutoComp.highlightClassName = 'CSsuggestHover';
	oAutoComp.queryMatchContains = true;
	oAutoComp.itemSelectEvent.subscribe(submitAutoComplete);
	oAutoComp.containerCollapseEvent.subscribe(collapseAutoComplete);
	oAutoComp.containerExpandEvent.subscribe(expandAutoComplete);

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
});