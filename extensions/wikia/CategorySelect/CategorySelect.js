
var oAutoComp;
var categories;
var fixCategoryRegexp = new RegExp('\\[\\[(?:' + csCategoryNamespaces + '):([^\\]]+)]]', 'i');
var ajaxUrl = wgServer + wgScript + '?action=ajax';
var csType = 'edit';

// TODO: PORT AWAY FROM YUI
function initCatSelect() {
	if ( (typeof(initCatSelect.isint) != "undefined") && (initCatSelect.isint) ) {
		return true;
	}
	initCatSelect.isint = true;
	YAHOO.namespace('CategorySelect');
	Event = YAHOO.util.Event;
	Dom = YAHOO.util.Dom;
	DDM = YAHOO.util.DragDropMgr;
}

function positionSuggestBox() {
	$('#csSuggestContainer').css('top', ($('#csCategoryInput').offset().top + $('#csCategoryInput').height() + 5) + 'px');
	$('#csSuggestContainer').css('left', Math.min($('#csCategoryInput').offset().left, ($(window).width() - $('#csItemsContainer').offset().left - $('#csSuggestContainer').width() - 10)) + 'px');
}

function extractSortkey(text) {
	var result = {'name': text, 'sort' : ''};
	var len = text.length;
	var curly = 0;
	var square = 0;
	var pipePos = -1;
	for (var i = 0; i < len && pipePos == -1; i++) {
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
	var catId = e.parentNode.getAttribute('catId');
	e.parentNode.parentNode.removeChild(e.parentNode);
	delete categories[catId];
}

// TODO: PORT AWAY FROM YUI
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
		WET.byStr('articleAction/sortSave');
		
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
	$('#csInfoboxCategory').attr('value', data['data']['category']);
	$('#csInfoboxSortKey').attr('value', data['data']['sortkey']);
	Dialog.show();
	//focus input on displayed dialog
	$('#csInfoboxCategory').focus();
}

function modifyCategory(e) {
	var catId = e.parentNode.getAttribute('catId');
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
			$('#csItemsContainer').find('a').each(function(i){
				if (this.getAttribute('catId') == catId) {
					this.firstChild.firstChild.nodeValue = data['category'];
					return false;
				}
			});
		}
		var sortkey = data['sortkey'];
		if (sortkey !== null) {
			if (sortkey == wgTitle || sortkey == csDefaultSort) {
				sortkey = '';
			}
			sortkey = extractedParams['sort'] + sortkey;
			categories[catId].sortkey = sortkey;
		}
		if (categories[catId].sortkey == '') {
			oldClassName = 'sorted';
			newClassName = 'sort';
		} else {
			oldClassName = 'sort';
			newClassName = 'sorted';
		}
		$(e).removeClass(oldClassName).addClass(newClassName);
	});
}

function replaceAddToInput(e) {
	$('#csAddCategoryButton').css('display', 'none');
	$('#csCategoryInput').css('display', 'block');
	positionSuggestBox();
	$('#csHintContainer').css('display', 'block');
	$('#csCategoryInput').focus();
}

function addAddCategoryButton() {
	if ($('#csAddCategoryButton').length > 0) {
		$('#csAddCategoryButton').css('display', 'block');
	} else {
		elementA = document.createElement('a');
		elementA.id = 'csAddCategoryButton';
		elementA.className = 'CSitem CSaddCategory'; //setAttribute doesn't work in IE
		elementA.tabindex = '-1';
		elementA.onfocus = 'this.blur()';
		elementA.onclick = function(e) {replaceAddToInput(this); return false;};

		elementImg = document.createElement('img');
		elementImg.src = wgBlankImgUrl;
		elementImg.className = 'sprite-small add';
		elementImg.onclick = function(e) {replaceAddToInput(this); return false;};
		elementA.appendChild(elementImg);

		elementText = document.createTextNode(csAddCategoryButtonText);
		elementA.appendChild(elementText);

		$('#csItemsContainer').get(0).appendChild(elementA);
	}
}

function inputBlur() {
	if ($('#csCategoryInput').attr('value') == '') {
		$('#csCategoryInput').css('display', 'none');
		$('#csHintContainer').css('display', 'none');
		addAddCategoryButton();
	}
}

// TODO: PORT AWAY FROM YUI
function addCategory(category, params, index) {
	if (params === undefined) {
		params = {'namespace': csDefaultNamespace, 'outerTag': '', 'sortkey': ''};
	}

	if (index === undefined) {
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

	elementText = document.createTextNode(category);
	elementA.appendChild(elementText);

	elementImg = document.createElement('img');
	elementImg.src = wgBlankImgUrl;
	elementImg.className = 'sprite-small ' + (params['sortkey'] == '' ? 'sort' : 'sorted');
	elementImg.onclick = function(e) {WET.byStr('articleAction/sortCategory'); modifyCategory(this); return false;};
	elementA.appendChild(elementImg);

	elementImg = document.createElement('img');
	elementImg.src = wgBlankImgUrl;
	elementImg.className = 'sprite-small close';
	elementImg.onclick = function(e) {WET.byStr('articleAction/deleteCategory'); deleteCategory(this); return false;};
	elementA.appendChild(elementImg);

	$('#csItemsContainer').get(0).insertBefore(elementA, $('#csCategoryInput').get(0));
	if ($('#csCategoryInput').css('display') != 'none') {
		$('#csHintContainer').css('display', 'block');
	}
	$('#csCategoryInput').attr('value', '');

	//Drag&Drop
	new YAHOO.CategorySelect.DDList(elementA);
}

function generateWikitextForCategories() {
	var categoriesStr = '';
	for (var c=0; c < categories.length; c++) {
		catTmp = '\n[[' + categories[c].namespace + ':' + categories[c].category + (categories[c].sortkey == '' ? '' : ('|' + categories[c].sortkey)) + ']]';
		if (categories[c].outerTag != '') {
			catTmp = '<' + categories[c].outerTag + '>' + catTmp + '</' + categories[c].outerTag + '>';
		}
		categoriesStr += catTmp;
	}
	return categoriesStr;
}

// TODO: PORT AWAY FROM YUI
function initializeCategories(cats) {
	//move categories metadata from hidden field [JSON encoded] into array
	if (cats === undefined) {
		cats = $('#wpCategorySelectWikitext').length == 0 ? '' : $('#wpCategorySelectWikitext').attr('value');
		categories = cats == '' ? [] : eval(cats);
	} else {
		categories = cats;
	}

	//inform PHP what source should it use [this field exists only in 'edit page' mode]
	if ($('#wpCategorySelectSourceType').length > 0) {
		$('#wpCategorySelectSourceType').attr('value', 'json');
	}

	addAddCategoryButton();
	for (var c=0; c < categories.length; c++) {
		addCategory(categories[c].category, {'namespace': categories[c].namespace, 'outerTag': categories[c].outerTag, 'sortkey': categories[c].sortkey}, c);
	}

	//Drag&Drop
	new YAHOO.util.DDTarget('csItemsContainer');
}

// TODO: PORT AWAY FROM YUI
function initializeDragAndDrop() {
	initCatSelect();
	YAHOO.CategorySelect.DDList = function(id, sGroup, config) {
		YAHOO.CategorySelect.DDList.superclass.constructor.call(this, id, sGroup, config);
		this.logger = this.logger || YAHOO;
		var el = this.getDragEl();
		$(el).css('opacity', '0.67'); // The proxy is slightly transparent

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
			$(clickEl).css('visibility', 'hidden');

			dragEl.innerHTML = clickEl.innerHTML;

			$(dragEl).css('color', $(clickEl).css('color'));
			$(dragEl).css('backgroundColor', $(clickEl).css('backgroundColor'));
			$(dragEl).css('font-size', $(clickEl).css('font-size'));
			$(dragEl).css('line-height', $(clickEl).css('line-height'));
			$(dragEl).css('border', '1px solid gray');
		},

		endDrag: function(e) {
			var srcEl = this.getEl();
			var proxy = this.getDragEl();

			// Show the proxy element and animate it to the src element's location
			$(proxy).css('visibility', '');
			var a = new YAHOO.util.Motion(
				proxy, {
					points: {
						to: Dom.getXY(srcEl)
					}
				},
				0.2,
				YAHOO.util.Easing.easeOut
			);
			var proxyid = proxy.id;
			var thisid = this.id;

			// Hide the proxy and show the source element when finished with the animation
			a.onComplete.subscribe(function() {
					$('#'+proxyid).css('visibility', 'hidden');
					$('#'+thisid).css('visibility', '');
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

// TODO: PORT AWAY FROM YUI
function toggleCodeView() {
	if ($('#csWikitextContainer').css('display') != 'block') {	//switch to code view
		WET.byStr('editpage/codeviewCategory');

		$('#csWikitext').attr('value', generateWikitextForCategories());
		$('#csItemsContainer').css('display', 'none');
		$('#csHintContainer').css('display', 'none');
		$('#csCategoryInput').css('display', 'none');
		$('#csSwitchView').get(0).innerHTML = csVisualView;
		$('#csWikitextContainer').css('display', 'block');
		$('#wpCategorySelectWikitext').attr('value', '');	//remove JSON - this will inform PHP to use wikitext instead
		$('#wpCategorySelectSourceType').attr('value', 'wiki');	//inform PHP what source it should use
	} else {	//switch to visual code
		WET.byStr('editpage/visualviewCategory');

		var pars = 'rs=CategorySelectAjaxParseCategories&rsargs=' + encodeURIComponent($('#csWikitext').attr('value') + ' ');
		var callback = {
			success: function(originalRequest) {
				var result = eval('(' + originalRequest.responseText + ')');
				if (result['error'] != undefined) {
					YAHOO.log('AJAX result: error');
					alert(result['error']);
				} else if (result['categories'] != undefined) {
					YAHOO.log('AJAX result: OK');
					//delete old categories [HTML items] (done in reverse to prevent race-conditions)
					var items = $('#csItemsContainer').find('a');
					for (var i=items.length-1; i>=0; i--) {
						if (items.get(i).getAttribute('catId') !== null) {
							items.get(i).parentNode.removeChild(items.get(i));
						}
					}

					initializeCategories(result['categories']);
					$('#csSwitchView').html(csCodeView);
					$('#csWikitextContainer').css('display', 'none');
					$('#csItemsContainer').css('display', 'block');
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
	newCat = [];
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
	var items = $('#csItemsContainer').get(0).getElementsByTagName('a');
	for (var catId=0; catId < newCat.length; catId++) {
		if (newCat[catId] === undefined) {
			continue;
		}
		items[itemId++].setAttribute('catId', catId);
	}
	//save changes into main array
	categories = newCat;
}

// TODO: PORT AWAY FROM YUI
function inputKeyPress(e) {
	if(e.keyCode == 13) {
		WET.byStr('articleAction/enterCategory');

		//TODO: stop AJAX call for AutoComplete
		YAHOO.util.Event.preventDefault(e);
		category = $('#csCategoryInput').attr('value');
		if (category != '' && oAutoComp._oCurItem == null) {
			addCategory(category);
		}
		//hide input and show button when [enter] pressed with empty input
		if (category == '') {
			WET.byStr('articleAction/enterCategoryEmpty');

			inputBlur();
		}
	}
	if(e.keyCode == 27) {
		WET.byStr('articleAction/escapeCategory');

		inputBlur();
	}
	positionSuggestBox();
}

function submitAutoComplete(comp, resultListItem) {
	addCategory(resultListItem[2][0]);
	positionSuggestBox();
}

function collapseAutoComplete() {
	if ($('#csCategoryInput').css('display') != 'none' && $('#csWikitextContainer').css('display') != 'block') {
		$('#csHintContainer').css('display', 'block');
	}
}

function expandAutoComplete(sQuery , aResults) {
	$('#csHintContainer').css('display', 'none');
}

// TODO: PORT AWAY FROM YUI
function regularEditorSubmit(e) {
	$('#wpCategorySelectWikitext').attr('value', YAHOO.Tools.JSONEncode(categories));
}

function getCategories(sQuery) {
	if(typeof categoryArray != 'object') {
		return;
	}
	var resultsFirst = [];
	var resultsSecond = [];
	sQuery = decodeURIComponent(sQuery);
	sQuery = sQuery.toLowerCase().replace(/_/g, ' ');
	for (var i = 0, len = categoryArray.length; i < len; i++) {
		var index = categoryArray[i].toLowerCase().indexOf(sQuery);
		if (index == 0) {
			resultsFirst.push([categoryArray[i]]);
		} else if (index > 0) {
			resultsSecond.push([categoryArray[i]]);
		}
		if (resultsFirst.length == 10) {
			break;
		}
	}
	return resultsFirst.concat(resultsSecond).slice(0,10);
}

// TODO: PORT AWAY FROM YUI
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

// TODO: PORT AWAY FROM YUI
function initHandlers() {
	//handle [enter] for non existing categories
	YAHOO.util.Event.addListener('csCategoryInput', 'keypress', inputKeyPress);
	YAHOO.util.Event.addListener('csCategoryInput', 'blur', inputBlur);
	if (typeof formId != 'undefined') {
		YAHOO.util.Event.addListener(formId, 'submit', regularEditorSubmit);
	}
}

// TODO: PORT AWAY FROM YUI
//`view article` mode
function showCSpanel() {
	$.loadYUI(function() {
		initCatSelect();
		csType = 'view';
		var pars = 'rs=CategorySelectGenerateHTMLforView';
		var callback = {
			success: function(originalRequest) {
				//prevent multiple instances when user click very fast
				if ($('#csMainContainer').length > 0) {
					return;
				}
				var el = document.createElement('div');
				el.innerHTML = originalRequest.responseText;
				$('#catlinks').get(0).appendChild(el);
				initHandlers();
				initAutoComplete();
				initializeDragAndDrop();
				initializeCategories();
				YAHOO.util.Get.css(wgExtensionsPath+'/wikia/CategorySelect/CategorySelect.css?'+wgStyleVersion, {onSuccess:function() {
					setTimeout(replaceAddToInput, 60);
					setTimeout(positionSuggestBox, 666);	//sometimes it can take more time to parse downloaded CSS - be sure to position hint in proper place
					$('#catlinks').removeClass('csLoading');
				}});
			},
			timeout: 30000
		};
		YAHOO.util.Connect.asyncRequest('POST', ajaxUrl, callback, pars);
		$('#csAddCategorySwitch').css('display', 'none');
	});
}

// TODO: PORT AWAY FROM YUI
function csSave() {
	if ($('#csCategoryInput').attr('value') != '') {
		addCategory($('#csCategoryInput').attr('value'));
	}
	var pars = 'rs=CategorySelectAjaxSaveCategories&rsargs[]=' + wgArticleId + '&rsargs[]=' + encodeURIComponent(YAHOO.Tools.JSONEncode(categories));
	var callback = {
		success: function(originalRequest) {
			var result = eval('(' + originalRequest.responseText + ')');
			if (result['info'] == 'ok' && result['html'] != '') {
				tmpDiv = document.createElement('div');
				tmpDiv.innerHTML = result['html'];
				var innerCatlinks = $G('mw-normal-catlinks');
				if (innerCatlinks) {
					$('#mw-normal-catlinks').get(0).parentNode.replaceChild(tmpDiv.firstChild, $G('mw-normal-catlinks'));
				} else {
					$('#catlinks').get(0).insertBefore(tmpDiv.firstChild, $G('catlinks').firstChild);
				}
			} else if (result['error'] != undefined) {
				alert(result['error']);
			}
			csCancel();
		},
		timeout: 30000
	};
	YAHOO.util.Connect.asyncRequest('POST', ajaxUrl, callback, pars);

	// add loading indicator and disable buttons
	$('#csButtonsContainer').addClass('csSaving');
	$('#csSave').get(0).disabled = true;
	$('#csCancel').get(0).disabled = true;
}

function csCancel() {
	var csMainContainer = $('#csMainContainer').get(0);
	csMainContainer.parentNode.removeChild(csMainContainer);
	$('#csAddCategorySwitch').css('display', 'block');
}

wgAfterContentAndJS.push(function() {
	if (csType == 'edit') {
		initHandlers();
		initAutoComplete();
		initializeDragAndDrop();
		initializeCategories();
		//show switch after loading categories
		$('#csSwitchViewContainer').css('display', 'block');
	}
});
