var oAutoComp,
	categories = [],
	csAjaxUrl = wgServer + wgScript + '?action=ajax',
	csType = 'edit',
	csMaxTextLength = 28,
	csDraggingEvent = false,
	csMode = 'wysiwyg';

function positionSuggestBox() {
	if(csType != 'module') {
		var $csCategoryInput = $('#csCategoryInput');
		var $csSuggestContainer = $('#csSuggestContainer');
		$csSuggestContainer.
			css('top', ($csCategoryInput.get(0).offsetTop + $csCategoryInput.height() + 5) + 'px').
			css('left', Math.min($csCategoryInput.get(0).offsetLeft, ($(window).width() - $('#csItemsContainer').get(0).offsetLeft - $csSuggestContainer.width() - 10)) + 'px');
	}
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
	categories[catId] = null;
	$('#csWikitext').val(generateWikitextForCategories());

	$('#csItemsContainer').trigger('categorySelectDelete');
}

function modifyCategory(e) {
	var catId = e.parentNode.getAttribute('catId'),
		defaultSortkey = categories[catId].sortkey != '' ? categories[catId].sortkey : (csDefaultSort != '' ? csDefaultSort : wgTitle);

	var category = categories[catId].category;
	var sortkey = defaultSortkey;
	var dialogContent = '<label for="csInfoboxCategory">' + csInfoboxCategoryText + '</label>' +
		'<br/><input type="text" id="csInfoboxCategory" />' +
		'<br/><label for="csInfoboxSortKey">' + csInfoboxSortkeyText.replace('$1', categories[catId].category).replace('<', '&lt;').replace('>', '&gt;') + '</label>' +
		'<br/><input type="text" id="csInfoboxSortKey" />';
	var dialogOptions = {
		id: 'sortDialog',
		width: 500,
		callbackBefore: function() {
			//fill up initial values
			$('#csInfoboxCategory').val(category);
			$('#csInfoboxSortKey').val(sortkey);
		},
		callback: function() {
			//focus input on displayed dialog
			$('#csInfoboxCategory').focus();
		},
		buttons: [
			{id:'sortDialogSave', defaultButton:true, message:csInfoboxSave, handler:function() {
				var category = $('#csInfoboxCategory').val();
				var sortkey = $('#csInfoboxSortKey').val();
				extractedParams = extractSortkey(category);
				category = extractedParams['name'];
				if (category == '') {
					//TODO: use jQuery dialog
					alert(csEmptyName);
					return;
				}



				$().log(category, "Cat");
				if (categories[catId].category != category) {
					categories[catId].category = category;
					$('#csItemsContainer a,#csItemsContainer li').each(function(i) {
						if ($(this).attr('catId') == catId) {
							$().log(category, "Cat");
							var elementText = category;
							if(csType == 'module') {
								elementText = $('<span>' + category + '</span>').get(0);
							}

							$(this).contents().eq(0).replaceWith(elementText);
							return false;
						}
					});
				}

				if (sortkey !== null) {
					if (sortkey == wgTitle || sortkey == csDefaultSort) {
						sortkey = '';
					}
					sortkey = extractedParams['sort'] + sortkey;
					categories[catId].sortkey = sortkey;
				}

				$('#csWikitext').val(generateWikitextForCategories());
				$('#sortDialog').closeModal();
			}}
		]
	};

	$.showCustomModal(csInfoboxCaption, dialogContent, dialogOptions);

	$('#csItemsContainer').trigger('categorySelectEdit');
}

function replaceAddToInput(e) {
	if(csType != 'module') {
		$('#csAddCategoryButton').hide();
		$('#csCategoryInput').show();
		positionSuggestBox();
		$('#csHintContainer').show();
	}
	$('#csCategoryInput').focus();
}

function addAddCategoryButton() {
	var $csAddCategoryButton = $('#csAddCategoryButton');
	if ($csAddCategoryButton.length > 0) {
		$csAddCategoryButton.show();
	} else {
		if(csType != 'module') {
			elementA = document.createElement('span');
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
}

function inputBlur() {
	var input = $('#csCategoryInput');
	if(csType != 'module') {
		input.hide();
		addAddCategoryButton();
	}
	$('#csHintContainer').hide();
}


function inputFocus(e) {
	collapseAutoComplete();
	$(e.target).val("").addClass('focus');
}

function addCategoryBase(category, params, index, checkdupes) {
	if (params === undefined) {
		params = {
			'namespace': csDefaultNamespace,
			'outerTag': '',
			'sortkey': ''
		};
	}

	if (index === undefined) {
		index = categories.length;
	}

	//replace full wikitext that user may provide (eg. [[category:abc]]) to just a name (abc)
	category = category.replace(fixCategoryRegexp, '$1');

	//if user provides "abc|def" explode this into category "abc" and sortkey "def"
	extractedParams = extractSortkey(category);
	category = extractedParams.name;
	params.sortkey = extractedParams.sort + params.sortkey;
	params.category = category;

	if (category == '') {
		alert(csEmptyName);
		return;
	}

	// Don't add duplicate categories
	if(checkdupes){
		for (var c=0; c < categories.length; c++) {
			if (categories[c] === null) continue;

			if(categoryIsDuplicate(params, categories[c])) {
				return false;
			}
		}
	}

	categories[index] = {
		'namespace': params.namespace ? params.namespace : csDefaultNamespace,
		'category': category,
		'outerTag': params.outerTag,
		'sortkey': params.sortkey
	};

	var categoryText = category;
	if(csType == 'module') {

		elementA = document.createElement('li');
		/*
if(categoryText.length > csMaxTextLength) {
			elementA.title = categoryText;
			categoryText = categoryText.substr(0,csMaxTextLength)  + '...';
		}
*/
		elementText = $('<span>' + categoryText + '</span>').get(0);
	} else {
		elementA = document.createElement('a');
		elementText = document.createTextNode(categoryText);
	}

	elementA.className = 'CSitem';	//setAttribute doesn't work in IE
	elementA.tabindex = '-1';
	elementA.onfocus = 'this.blur()';
	elementA.setAttribute('catId', index);


	elementA.appendChild(elementText);

	elementImg = document.createElement('img');
	elementImg.src = wgBlankImgUrl;
	elementImg.className = 'sprite-small edit';
	elementImg.onclick = function(e) {
		if (csDraggingEvent) {
			return;
		}

		modifyCategory(this);
		return false;
	};

	elementA.appendChild(elementImg);

	elementImg = document.createElement('img');
	elementImg.src = wgBlankImgUrl;
	elementImg.className = 'sprite-small delete';

	elementImg.onclick = function(e) {
		if (csDraggingEvent) {
			return;
		}

		deleteCategory(this);
		return false;
	};

	elementA.appendChild(elementImg);

	if(csType == 'module') {
		$("#csItemsContainer").append( elementA );
		$('#csItemsContainerDiv').scrollTop(100*100);
	} else {
		$(elementA).insertBefore( $('#csCategoryInput') );
	}

	if ($('#csCategoryInput').css('display') != 'none') {
		collapseAutoComplete();
	}
}


function addCategory(category, params, index) {
	var checkdupes = true;
	addCategoryBase(category, params, index, checkdupes);

	$('#csCategoryInput').attr('value', '');

	$('#csItemsContainer').trigger('categorySelectAdd');
}


function generateWikitextForCategories() {
	var categoriesStr = '';

	if (categories.length) {
		for (var c=0; c < categories.length; c++) {
			if (categories[c] === null) continue;
			catTmp = '\n[[' + categories[c].namespace + ':' + categories[c].category + (categories[c].sortkey == '' ? '' : ('|' + categories[c].sortkey)) + ']]';
			if (categories[c].outerTag != '') {
				catTmp = '<' + categories[c].outerTag + '>' + catTmp + '</' + categories[c].outerTag + '>';
			}
			categoriesStr += catTmp;
		}
		categoriesStr = categoriesStr.replace(/^\n+/, '');
	}
	else {
		// fix for initialization in wikitext mode (BugId:10880)
		categoriesStr = $.trim($('#csWikitext').attr('data-initial-value'));
	}

	return categoriesStr;
}

function categoryIsDuplicate(cat1, cat2) {

	// Check if category name, outertag and sort key are all the same.  If they are, don't add to categories array
	if(cat1.category.toLowerCase() == cat2.category.toLowerCase()
		&& cat1.outerTag == cat2.outerTag 
		&& cat1.sortkey == cat2.sortkey
	){
		return true;
	}
	return false;
}

function removeDuplicatecategories() {
	// Cache unique categories
	// We know the first category isn't a dupe yet
	var nonDupes = [categories[0]];

	// Loop through all categories, skipping the first one
	for (var c = 1; c < categories.length; c++) {
		// Compare category with cached unique categories (nonDupes)
		for (var d = 0, nonDupesLength = nonDupes.length; d < nonDupesLength; d++) {
			if(categoryIsDuplicate(categories[c], nonDupes[d])){
				break;
			} 
			// Last iteration
			if(d == nonDupes.length - 1) {
				nonDupes.push(categories[c]);
			}
		}
	}

	return nonDupes;
}

function initializeCategories(cats) {
	window.fixCategoryRegexp = new RegExp('\\[\\[(?:' + csCategoryNamespaces + '):([^\\]]+)]]', 'i');

	//move categories metadata from hidden field [JSON encoded] into array
	if (typeof cats == 'undefined') {
		cats = $('#wpCategorySelectWikitext').length == 0 ? '' : $('#wpCategorySelectWikitext').attr('value');
		categories = cats == '' ? [] : eval(cats);
	} else {
		categories = cats;
	}

	// Filter out duplicate categories on init
	if(categories.length) {
		categories = removeDuplicatecategories();
		$('#csWikitext').val(generateWikitextForCategories());

	}
	
	//inform PHP what source should it use [this field exists only in 'edit page' mode]
	var $wpCategorySelectSourceType = $('#wpCategorySelectSourceType');
	if ($wpCategorySelectSourceType.length > 0 && window.csMode === 'json') {
		$wpCategorySelectSourceType.attr('value', 'json');
	}

	// Only on view page, not on edit page
	addAddCategoryButton();

	for (var c=0; c < categories.length; c++) {
		addCategoryBase(categories[c].category, {'namespace': categories[c].namespace, 'outerTag': categories[c].outerTag, 'sortkey': categories[c].sortkey}, c);
	}
	var input = $('#csCategoryInput');
}

function initializeDragAndDrop() {
	// sortable is a part of jQuery UI library - ensure it's loaded
	mw.loader.use('jquery.ui.sortable').then(function() {
		$('#csItemsContainer').sortable({
			items: '.CSitem:not(.CSaddCategory)',
			revert: 200,
			start: function(event, ui) {
				var srcEl = ui.item;
				var $srcEl = $(srcEl);
				var width = ( parseInt($srcEl.css('width') ) +  3 ) + 'px';
				$srcEl.css('width', width);
				csDraggingEvent = true;
			},
			stop: function(event, ui) {
				csDraggingEvent = false;
			},
			update: function(event, ui) {
				var srcEl = ui.item;

				var prevSibId = srcEl.prev('a, li').attr('catid');
				if (typeof prevSibId == 'undefined') prevSibId = -1;
				$().log('moving ' + srcEl.attr('catid') + ' before ' + prevSibId);
				moveElement(srcEl.attr('catid'), prevSibId);
			}
		});
	});
}

function toggleCodeView() {
	if ($('#csWikitextContainer').css('display') != 'block') {	//switch to code view
		$('#csWikitext').val(generateWikitextForCategories());
		$('#csItemsContainerDiv').hide();
		$('#csHintContainer').hide();
		$('#csCategoryInput').prop('disabled', true).removeAttr('placeholder');
		$('#csSwitchView').html(csVisualView);
		$('#csWikitextContainer').show();
		$('#wpCategorySelectWikitext').attr('value', '');	//remove JSON - this will inform PHP to use wikitext instead
		$('#wpCategorySelectSourceType').attr('value', 'wiki');	//inform PHP what source it should use

		window.csMode = 'source';

		$().log(window.csMode, 'CS mode');
	} else {	//switch to visual code
		$.post(csAjaxUrl, {rs: "CategorySelectAjaxParseCategories", rsargs: [$('#csWikitext').val() + ' ']}, function(result){
			if (typeof result.error !== 'undefined') {
				alert(result.error);
			} else if (typeof result.categories !== 'undefined') {
				// delete old categories [HTML items]
				$('#csItemsContainer .CSitem[catid]').remove();

				initializeCategories(result['categories']);
				$('#csSwitchView').html(csCodeView);
				$('#csWikitextContainer').hide();
				$('#csItemsContainerDiv').show();
				$('#csCategoryInput').prop('disabled', false).attr('placeholder', $('#csCategoryInput').attr('data-placeholder'));
			}

			window.csMode = 'wysiwyg';

			$().log(window.csMode, 'CS mode');
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
	var items = $('#csItemsContainer').find('a, li');
	for (var catId=0; catId < newCat.length; catId++) {
		if (newCat[catId] === undefined) {
			continue;
		}
		var catitem = $(items[itemId++])
		catitem.attr('catId', catId);
	}
	//save changes into main array
	categories = newCat;

	$('#csItemsContainer').trigger('categorySelectMove');
}

function inputKeyPress(e) {
	if(e.keyCode == 13) {
		//TODO: stop AJAX call for AutoComplete
		e.preventDefault();
		var category = $('#csCategoryInput').val();

		if (category != '') {
			if(window.oAutoComp && window.oAutoComp._oCurItem == null){ /* BugId:5671 */
				addCategory(category);
				$('#csWikitext').val(generateWikitextForCategories());
			}
		} else {
			//on view page, hide input and show button when [enter] pressed with empty input
			if(csType != 'module'){
				$('#csCategoryInput').blur();
				inputBlur();
			}
		}
	}
	if(e.keyCode == 27) {
		$('#csCategoryInput').blur();
		inputBlur();
	}
	positionSuggestBox();
}

function submitAutoComplete(comp, resultListItem) {
	addCategory(resultListItem[2][0]);
	replaceAddToInput();
	$('#csWikitext').val(generateWikitextForCategories());
}

function collapseAutoComplete() {
	if ((csType != 'module') && $('#csCategoryInput').css('display') != 'none' && $('#csWikitextContainer').css('display') != 'block') {
		$('#csHintContainer').show();
	}
        var wikiaMainContent = $('#WikiaMainContent');
        $('#WikiaFooter').css('z-index', Math.min(1, wikiaMainContent.css('z-index')));
        wikiaMainContent.css('z-index', 1);
}

function expandAutoComplete(sQuery , aResults) {
	$('#csHintContainer').hide();
        var wikiaFooter = $('#WikiaFooter');
        $('#WikiaMainContent').css('z-index', Math.max(2, wikiaFooter.css('z-index')));
        wikiaFooter.css('z-index', 1);
}

function regularEditorSubmit(e) {
	$('#wpCategorySelectWikitext').attr('value', JSON.stringify(categories));
}

function getCategories(sQuery) {
	if(typeof categoryArray != 'object') {
		return;
	}
	var resultsFirst = [];
	var resultsSecond = [];
	sQuery = decodeURIComponent(sQuery);
	sQuery = sQuery.toLowerCase().replace(/_/g, ' ');

	// remove "Category:" prefix when querying for suggestions
	sQuery = sQuery.replace(/^category:/, '');

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

function getCategoriesDataSource() {
	return new YAHOO.widget.DS_JSFunction(getCategories);
}

// TODO: PORT AWAY FROM YUI
var autoCompleteLoaded = false;
function initAutoComplete() {
	if(!autoCompleteLoaded){
		// grab categoryArray var
		$.when(
			// gets JS code with categoryArray global variable with a list of all categories
			$.getScript(wgServer + wgScriptPath + '?action=ajax&rs=CategorySelectGetCategories'),
			$.loadYUI()
		).then(function() {
			// Init datasource
			var oDataSource = getCategoriesDataSource();

			// Init AutoComplete object and assign datasource object to it
			oAutoComp = new YAHOO.widget.AutoComplete('csCategoryInput', 'csSuggestContainer', oDataSource);
			oAutoComp.autoHighlight = false;
			oAutoComp.queryDelay = 0;
			oAutoComp.highlightClassName = 'CSsuggestHover';
			//fix for some ff problem
			oAutoComp._selectText = $.noop;
			oAutoComp.queryMatchContains = true;
			oAutoComp.itemSelectEvent.subscribe(submitAutoComplete);
			oAutoComp.containerCollapseEvent.subscribe(collapseAutoComplete);
			oAutoComp.containerExpandEvent.subscribe(expandAutoComplete);
			//do not show delayed ajax suggestion when user already added the category
			oAutoComp.doBeforeExpandContainer = function (elTextbox, elContainer, sQuery, aResults) {
				return elTextbox.value != '';
			};

			autoCompleteLoaded = true;
		});
	}
}

// BugId:11168
function initSourceModeSuggest() {
	// requires LinkSuggest extension
	if (typeof LS_PrepareTextarea != 'function') {
		return;
	}

	$.loadYUI(function() {
		// Init datasource
		var oDataSource = getCategoriesDataSource();

		// TODO: cleaner integration with LinkSuggest
		var oAutoComp = LS_PrepareTextarea('csWikitext', oDataSource);

		// add "Category:" prefix when adding an item from suggest dropdown
		oAutoComp.updateValueEvent.subscribe(function(eventName, data) {
			var node = data[1];
			if (node) {
				node._oResultData[0] = 'Category:' + node._oResultData[0];
			}
		});
	});
}

function initHandlers() {
	//handle [enter] for non existing categories
	var $csCategoryInput = $('#csCategoryInput');
	$csCategoryInput.keypress(inputKeyPress);
	$csCategoryInput.blur(inputBlur);
	if(csType == 'module') {
		$csCategoryInput.focus(inputFocus);
	}

	//TODO: add foucs
	if (typeof formId != 'undefined') {
		$('#'+formId).submit(regularEditorSubmit);
	}
}

//`view article` mode
function showCSpanel() {
	$.when(
		$.getJSON(wgScript, {action: 'ajax', rs: 'CategorySelectGenerateHTMLforView', uselang: wgUserLanguage}),
		mw.loader.use('jquery.ui.sortable'),
		$.getResources([
			$.getSassCommonURL('/extensions/wikia/CategorySelect/oasis.scss')
		])
	).
	then(function(ajaxData) {
		var data = ajaxData[0];

		// emit lazy-loaded global variables (BugId:24570)
		for (var key in data.vars) {
			window[key] = data.vars[key];
		}

		csType = 'view';

		//prevent multiple instances when user click very fast
		if ($('#csMainContainer').exists()) {
			return;
		}

		$('#catlinks').
			removeClass('csLoading').
			append('<div>' + data.html + '</div>');

		initHandlers();
		initAutoComplete();
		initializeDragAndDrop();
		initializeCategories();
		replaceAddToInput();

		// give browser some time before repositioning the tooltip
		setTimeout(positionSuggestBox, 0);

		$('#csAddCategorySwitch').hide();
	});
}

function csSave() {
	var $csCategoryInput = $('#csCategoryInput');
	if ($csCategoryInput.attr('value') != '') {
		addCategory($csCategoryInput.attr('value'));
	}
	var pars = 'rs=CategorySelectAjaxSaveCategories&rsargs[]=' + wgArticleId + '&rsargs[]=' + encodeURIComponent(JSON.stringify(categories));
	$.ajax({
		url: csAjaxUrl,
		data: pars,
		dataType: "json",
		success: function(result){
			if (result.info == 'ok' && result.html != '') {
				tmpDiv = document.createElement('div');
				tmpDiv.innerHTML = result['html'];
				var innerCatlinks = $('#mw-normal-catlinks').get(0);
				if (innerCatlinks) {
					$('#mw-normal-catlinks').get(0).parentNode.replaceChild(tmpDiv.firstChild, $('#mw-normal-catlinks').get(0));
				} else {
					$('#catlinks').get(0).insertBefore(tmpDiv.firstChild, $('#catlinks').get(0).firstChild);
				}
			} else if (result.error != undefined) {
				alert(result.error);
			}
			csCancel();
		}
	});

	// add loading indicator and disable buttons
	$('#csButtonsContainer').addClass('csSaving');
	$('#csSave').get(0).disabled = true;
	$('#csCancel').get(0).disabled = true;
}

function csCancel() {
	var csMainContainer = $('#csMainContainer').get(0);
	csMainContainer.parentNode.removeChild(csMainContainer);
	$('#csAddCategorySwitch').show();
}

initCatSelectForEdit = function() {
	initHandlers();
	$('#csCategoryInput').focus(initAutoComplete);
	initSourceModeSuggest();
	initializeDragAndDrop();
	initializeCategories();
	$('#csHintContainer').hide();
	$('#csMainContainer').show();
}

// BugId:2823
$(window).bind('editTitleUpdated', function(ev, title) {
	window.csDefaultSort = title;
});
