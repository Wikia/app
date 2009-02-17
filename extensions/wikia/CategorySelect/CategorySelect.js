var Event = YAHOO.util.Event;
var Dom = YAHOO.util.Dom;
var categories;
var fixCategoryRegexp = new RegExp('\\[\\[(?:' + csCategoryNamespaces + '):([^\\]]+)]]', 'i');
var ajaxUrl = wgServer + wgScript + '?action=ajax';
var csType = 'edit';
var csDefaultNamespace = 'Category';	//TODO: default namespace

function positionSuggestBox() {
	$('csSuggestContainer').style.top = $('csCategoryInput').offsetTop + jQuery("#" + 'csCategoryInput').height() + 5 + 'px';
	$('csSuggestContainer').style.left = Math.min($('csCategoryInput').offsetLeft, (Dom.getViewportWidth() - jQuery('#' + 'csItemsContainer').offset().left - jQuery("#" + 'csSuggestContainer').width() - 10)) + 'px';
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

	$('csItemsContainer').insertBefore(elementA, $('csCategoryInput'));

	$('csCategoryInput').value = '';
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
	for(c in categories) {
		addCategory(categories[c].category, {'outerTag': categories[c].outerTag, 'sortkey': categories[c].sortkey}, c);
	}
}

function toggleCodeView() {
	if ($('csWikitextContainer').style.display != 'block') {	//switch to code view
		$('csWikitext').value = generateWikitextForCategories();
		$('csItemsContainer').style.display = 'none';
		$('csSwitchView').innerHTML = csVisualView;
		$('csWikitextContainer').style.display = 'block';
		$('wpCategorySelectWikitext').value = '';	//remove JSON - this will inform PHP to use wikitext instead
		$('wpCategorySelectSourceType').value = 'wiki';	//inform PHP what source should it use
	} else {	//switch to visual code
		var pars = 'rs=CategorySelectAjaxParseCategories&rsargs=' + encodeURIComponent($('csWikitext').value);
		var callback = {
			success: function(originalRequest) {
				result = eval('(' + originalRequest.responseText + ')');
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
	var items = $('csItemsContainer').getElementsByTagName('a');
	for (catId in newCat) {
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
		YAHOO.log('enter pressed, value = ' + category);
		if (category != '') {
			addCategory(category);
		}
	}
	positionSuggestBox();
}

function submitAutoComplete(comp, resultListItem) {
	YAHOO.log('selected category:' + resultListItem[2]);
	addCategory(resultListItem[2][0]);
}

function collapseAutoComplete() {
	$('csHintContainer').style.display = 'block';
}

function expandAutoComplete(sQuery , aResults) {
	$('csHintContainer').style.display = 'none';
}

function regularEditorSubmit(e) {
	$('wpCategorySelectWikitext').value = YAHOO.Tools.JSONEncode(categories);
}

function initAutoComplete() {
	YAHOO.log('initAutoComplete');
	// Init datasource
	var oDataSource = new YAHOO.widget.DS_XHR(wgServer + wgScriptPath + '/', ["\n"]);
	oDataSource.responseType = YAHOO.widget.DS_XHR.TYPE_FLAT;
	oDataSource.scriptQueryAppend = 'action=ajax&rs=CategorySelectAjaxGetCategories';

	// Init AutoComplete object and assign datasource object to it
	var oAutoComp = new YAHOO.widget.AutoComplete('csCategoryInput', 'csSuggestContainer', oDataSource);
	oAutoComp.autoHighlight = false;
	oAutoComp.queryDelay = 0.5;
	oAutoComp.highlightClassName = 'CSsuggestHover';
	oAutoComp.queryMatchContains = true;
	oAutoComp.itemSelectEvent.subscribe(submitAutoComplete);
	oAutoComp.containerCollapseEvent.subscribe(collapseAutoComplete);
	oAutoComp.containerExpandEvent.subscribe(expandAutoComplete);
}

function initHandlers() {
	YAHOO.log('initHandlers: begin');
	//handle [enter] for non existing categories
	YAHOO.util.Event.addListener('csCategoryInput', 'keypress', inputKeyPress);
	YAHOO.log('initHandlers: keypress done');
	YAHOO.util.Event.addListener('csCategoryInput', 'blur', inputBlur);
	YAHOO.log('initHandlers: blur done');
	if (typeof formId != 'undefined') {
		YAHOO.util.Event.addListener(formId, 'submit', regularEditorSubmit);
	}
	YAHOO.log('initHandlers: end');
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
	var pars = 'rs=CategorySelectGenerateHTMLforView';
	var callback = {
		success: function(originalRequest) {
			$('csAddCategorySwitch').style.display = 'none';
			var el = document.createElement('div');
			el.innerHTML = originalRequest.responseText;
			$('catlinks').appendChild(el);
			YAHOO.log('category html added');
			csType = 'view';
			initHandlers();
			initAutoComplete();
			initializeCategories();
		},
		timeout: 30000
	};
	YAHOO.util.Connect.asyncRequest('POST', ajaxUrl, callback, pars);
}

function csSave() {
	var pars = 'rs=CategorySelectAjaxSaveCategories&rsargs[]=' + wgArticleId + '&rsargs[]=' + encodeURIComponent(YAHOO.Tools.JSONEncode(categories));
	var callback = {
		success: function(originalRequest) {
			if (originalRequest.responseText == 'ok') {
				csCancel();
			}
		},
		timeout: 30000
	};
	YAHOO.util.Connect.asyncRequest('POST', ajaxUrl, callback, pars);
}

function csCancel() {
	$('csMainContainer').parentNode.removeChild($('csMainContainer'));
	$('csAddCategorySwitch').style.display = 'block';
}

Event.onDOMReady(function() {
	YAHOO.log('onDOMReady');
	if (csType == 'edit') {
		initHandlers();
		initAutoComplete();
		initializeCategories();
		//show switch after loading categories
		$('csSwitchViewContainer').style.display = 'block';

		// Init tooltip
		initTooltip();
	}
});