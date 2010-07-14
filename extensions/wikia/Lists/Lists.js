
var oAutoComp;
var categories;
var fixCategoryRegexp = new RegExp('\\[\\[(?:' + listsCategoryNamespaces + '):([^\\]]+)]]', 'i');
var ajaxUrl = wgServer + wgScript + '?action=ajax';
var listsType = 'edit';

function initLists() {
	if ( (typeof(initLists.isint) != "undefined") && (initLists.isint) ) {
		return true;
	}
	initLists.isint = true;
}

function positionSuggestBox() {
	$('#csSuggestContainer').css('top', ($('#csCategoryInput').get(0).offsetTop + $('#csCategoryInput').height() + 5) + 'px');
	$('#csSuggestContainer').css('left', Math.min($('#csCategoryInput').get(0).offsetLeft, ($(window).width() - $('#csItemsContainer').get(0).offsetLeft - $('#csSuggestContainer').width() - 10)) + 'px');
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
		result.name = text.slice(0, pipePos);
		result.sort = text.slice(pipePos + 1);
	}
	return result;
}

function deleteCategory(e) {
	var catId = e.parentNode.getAttribute('catId');
	e.parentNode.parentNode.removeChild(e.parentNode);
	categories.splice(catId, 1);
}

function replaceAddToInput(e) {
	$('#listsAddItemButton').css('display', 'none');
	$('#listsItemInput').css('display', 'block');
	positionSuggestBox();
	$('#listsHintContainer').css('display', 'block');
	$('#listsItemInput').focus();
}

function addAddItemButton() {
	if ($('#listsAddItemButton').length > 0) {
		$('#listsAddItemButton').css('display', 'block');
	} else {
		elementA = document.createElement('a');
		elementA.id = 'listsAddItemButton';
		elementA.className = 'LISTSitem LISTSaddItem'; //setAttribute doesn't work in IE
		elementA.tabindex = '-1';
		elementA.onfocus = 'this.blur()';
		elementA.onclick = function(e) {replaceAddToInput(this); return false;};

		elementImg = document.createElement('img');
		elementImg.src = wgBlankImgUrl;
		elementImg.className = 'sprite-small add';
		elementImg.onclick = function(e) {replaceAddToInput(this); return false;};
		elementA.appendChild(elementImg);

		elementText = document.createTextNode(listsAddItemButtonText);
		elementA.appendChild(elementText);

		$('#listsItemsContainer').get(0).appendChild(elementA);
	}
}

function inputBlur() {
	if ($('#listsItemInput').attr('value') == '') {
		$('#listsItemInput').css('display', 'none');
		$('#listsHintContainer').css('display', 'none');
		addAddItemButton();
	}
}

function addCategory(category, params, index) {
	if (params === undefined) {
		params = {'namespace': listsDefaultNamespace, 'outerTag': '', 'sortkey': ''};
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
		alert(listsEmptyName);
		return;
	}

	categories[index] = {'namespace': params['namespace'] ? params['namespace'] : listsDefaultNamespace, 'category': category, 'outerTag': params['outerTag']};

	elementA = document.createElement('a');
	elementA.className = 'LISTSitem';	//setAttribute doesn't work in IE
	elementA.tabindex = '-1';
	elementA.onfocus = 'this.blur()';
	elementA.setAttribute('catId', index);

	elementText = document.createTextNode(category);
	elementA.appendChild(elementText);

	elementImg = document.createElement('img');
	elementImg.src = wgBlankImgUrl;
	elementImg.className = 'sprite-small close';
	elementImg.onclick = function(e) {WET.byStr('articleAction/deleteListItem'); deleteCategory(this); return false;};
	elementA.appendChild(elementImg);

	$('#listsItemsContainer').get(0).insertBefore(elementA, $('#listsItemInput').get(0));
	if ($('#listsItemInput').css('display') != 'none') {
		$('#listsHintContainer').css('display', 'block');
	}
	$('#listsItemInput').attr('value', '');

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

function initializeCategories(cats) {
	//move categories metadata from hidden field [JSON encoded] into array
	if (cats === undefined) {
		cats = $('#wpListsWikitext').length == 0 ? '' : $('#wpListsWikitext').attr('value');
		categories = cats == '' ? [] : eval(cats);
	} else {
		categories = cats;
	}

	//inform PHP what source should it use [this field exists only in 'edit page' mode]
	if ($('#wpListsSourceType').length > 0) {
		$('#wpListsSourceType').attr('value', 'json');
	}

	addAddItemButton();
	for (var c=0; c < categories.length; c++) {
		addCategory(categories[c].category, {'namespace': categories[c].namespace, 'outerTag': categories[c].outerTag, 'sortkey': categories[c].sortkey}, c);
	}
}

function initializeDragAndDrop() {
	initLists();
	// TODO: If we want drag & drop, we'll have to write it from scratch in jQuery.  Once done, try to also update CategorySelect to not use YUI.
}

function toggleCodeView() {
	if ($('#listsWikitextContainer').css('display') != 'block') {	//switch to code view
		WET.byStr('editpage/codeviewLists');

		$('#listsWikitext').attr('value', generateWikitextForCategories());
		$('#listsItemsContainer').css('display', 'none');
		$('#listsHintContainer').css('display', 'none');
		$('#listsCategoryInput').css('display', 'none');
		$('#listsSwitchView').html(listsVisualView);
		$('#listsWikitextContainer').css('display', 'block');
		$('#wpListsWikitext').attr('value', '');	//remove JSON - this will inform PHP to use wikitext instead
		$('#wpListsSourceType').attr('value', 'wiki');	//inform PHP what source it should use
	} else {	//switch to visual code
		WET.byStr('editpage/visualviewLists');

		$.post(ajaxUrl, {rs: "CategorySelectAjaxParseCategories", rsargs: $('#listsWikitext').attr('value') + ' '}, function(result){
			if (result.error !== undefined) {
				$().log('AJAX result: error');
				alert(result.error);
			} else if (result.categories !== undefined) {
				$().log('AJAX result: OK');
				//delete old categories [HTML items]
				var items = $('#listsItemsContainer').find('a');
				for (var i=items.length-1; i>=0; i--) {
					if (items.get(i).getAttribute('catId') !== null) {
						items.get(i).parentNode.removeChild(items.get(i));
					}
				}

				initializeCategories(result['categories']);
				$('#listsSwitchView').html(listsCodeView);
				$('#listsWikitextContainer').css('display', 'none');
				$('#listsItemsContainer').css('display', 'block');
			}
		}, "json");
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
	var items = $('#listsItemsContainer').get(0).getElementsByTagName('a');
	for (var catId=0; catId < newCat.length; catId++) {
		if (newCat[catId] === undefined) {
			continue;
		}
		items[itemId++].setAttribute('catId', catId);
	}
	//save changes into main array
	categories = newCat;
}

function inputKeyPress(e) {
	if(e.keyCode == 13) {
		WET.byStr('articleAction/enterListItem');

		//TODO: stop AJAX call for AutoComplete
		e.preventDefault();
		category = $('#listsCategoryInput').attr('value');
		if (category != '' && oAutoComp._oCurItem == null) {
			addCategory(category);
		}
		//hide input and show button when [enter] pressed with empty input
		if (category == '') {
			WET.byStr('articleAction/enterListItemEmpty');

			inputBlur();
		}
	}
	if(e.keyCode == 27) {
		WET.byStr('articleAction/escapeListItem');

		inputBlur();
	}
	positionSuggestBox();
}

function submitAutoComplete(comp, resultListItem) {
	addCategory(resultListItem[2][0]);
	positionSuggestBox();
}

function collapseAutoComplete() {
	if ($('#listsCategoryInput').css('display') != 'none' && $('#listsWikitextContainer').css('display') != 'block') {
		$('#listsHintContainer').css('display', 'block');
	}
}

function expandAutoComplete(sQuery , aResults) {
	$('#listsHintContainer').css('display', 'none');
}

function regularEditorSubmit(e) {
	$('#wpListsWikitext').attr('value', $.toJSON(categories));
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

function initAutoComplete() {
	// TODO: PORT FROM YUI TO jQuery IN CategorySelect then merge over here.
}

function initHandlers() {
	//handle [enter] for non existing categories
	$('#listsCategoryInput').keypress(inputKeyPress);
	$('#listsCategoryInput').blur(inputBlur);
	if (typeof formId != 'undefined') {
		$('#'+formId).submit(regularEditorSubmit);
	}
}

//`view article` mode
function showLISTSpanel() {
	$.loadYUI(function() {
		initLists();
		listsType = 'view';
		$.post(ajaxUrl, {rs: 'ListsGenerateHTMLforView'}, function(result){
			//prevent multiple instances when user click very fast
			if ($('#listsMainContainer').length > 0) {
				return;
			}
			var el = document.createElement('div');
			el.innerHTML = result;
			$('#listlinks').get(0).appendChild(el);
			initHandlers();
			initAutoComplete();
			initializeDragAndDrop();
			initializeCategories();

			// Dynamically load & apply the CSS.
			$("head").append("<link>");
			css = $("head").children(":last");
			css.attr({
				rel:  "stylesheet",
				type: "text/css",
				href: wgExtensionsPath+'/wikia/Lists/Lists.css?'+wgStyleVersion
			});
			setTimeout(replaceAddToInput, 60);
			setTimeout(positionSuggestBox, 666); //sometimes it can take more time to parse downloaded CSS - be sure to position hint in proper place
			$('#listlinks').removeClass('listsLoading');
		}, "html");

		$('#listsAddItemSwitch').css('display', 'none');
	});
}

function listsSave() {
	if ($('#listsCategoryInput').attr('value') != '') {
		addCategory($('#listsCategoryInput').attr('value'));
	}
	var pars = 'rs=CategorySelectAjaxSaveCategories&rsargs[]=' + wgArticleId + '&rsargs[]=' + encodeURIComponent($.toJSON(categories));
	//$.post(ajaxUrl, {rs: 'CategorySelectAjaxSaveCategories', 'rsargs[]': [wgArticleId, $.toJSON(categories)]}, function(result){
	$.ajax({
		url: ajaxUrl,
		data: pars,
		dataType: "json",
		success: function(result){
			if (result.info == 'ok' && result.html != '') {
				tmpDiv = document.createElement('div');
				tmpDiv.innerHTML = result['html'];
				var innerListLinks = $('#mw-normal-listlinks').get(0);
				if (innerListLinks) {
					$('#mw-normal-listlinks').get(0).parentNode.replaceChild(tmpDiv.firstChild, $('#mw-normal-listlinks').get(0));
				} else {
					$('#listlinks').get(0).insertBefore(tmpDiv.firstChild, $('#listlinks').get(0).firstChild);
				}
			} else if (result.error != undefined) {
				alert(result.error);
			}
			listsCancel();
		}
	});

	// add loading indicator and disable buttons
	$('#listsButtonsContainer').addClass('listsSaving');
	$('#listsSave').get(0).disabled = true;
	$('#listsCancel').get(0).disabled = true;
}

function listsCancel() {
	var listsMainContainer = $('#listsMainContainer').get(0);
	listsMainContainer.parentNode.removeChild(listsMainContainer);
	$('#listsAddItemSwitch').css('display', 'block');
}

wgAfterContentAndJS.push(function() {
	if (listsType == 'edit') {
		initHandlers();
		initAutoComplete();
		initializeDragAndDrop();
		initializeCategories();
		//show switch after loading categories
		$('#listsSwitchViewContainer').css('display', 'block');
	}
});
