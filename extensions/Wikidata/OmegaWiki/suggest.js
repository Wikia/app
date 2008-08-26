window.onload=sortAll;

function getHTTPObject() {
	var xmlhttp;

	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (e) {
			try {
				xmlhttp = new XMLHttpRequest();
			} catch (e) {
				xmlhttp = false;
			}
		}
	}

	return xmlhttp;
}

function stripSuffix(source, suffix) {
	return source.substr(0, source.length - suffix.length);
}

function getSuggestPrefix(node, postFix) {
	var nodeId = node.id;
	return stripSuffix(nodeId, postFix);
}

function leftTrim(sString) {
	while (sString.substring(0,1) == ' ' || sString.substring(0,1) == "\n") {
			sString = sString.substring(1, sString.length);
		}
	return sString;
}

function updateSuggestions(suggestPrefix) {
	var http = getHTTPObject();
	var table = document.getElementById(suggestPrefix + "table");
	var suggestQuery = document.getElementById(suggestPrefix + "query").value;
	var suggestOffset = document.getElementById(suggestPrefix + "offset").value;
	var dataSet = document.getElementById(suggestPrefix + "dataset").value;	

	suggestText = document.getElementById(suggestPrefix + "text");
	suggestText.className = "suggest-loading";

	var suggestAttributesLevel = document.getElementById(suggestPrefix + "parameter-level");
	var suggestDefinedMeaningId = document.getElementById(suggestPrefix + "parameter-definedMeaningId");
	var suggestAnnotationAttributeId = document.getElementById(suggestPrefix + "parameter-annotationAttributeId");
	
	var URL = 'index.php';
	var location = "" + document.location;
	
	if (location.indexOf('index.php/') > 0)
		URL = '../' + URL;

	URL = 
		URL + 
		'/Special:Suggest?search-text=' + encodeURI(suggestText.value) + 
		'&prefix=' + encodeURI(suggestPrefix) + 
		'&query=' + encodeURI(suggestQuery) + 
		'&offset=' + encodeURI(suggestOffset) + 
		'&dataset='+dataSet;
		
	if (suggestAttributesLevel != null)
		URL = URL + '&attributesLevel=' + encodeURI(suggestAttributesLevel.value);
	
	if (suggestDefinedMeaningId != null) 
		URL = URL + '&definedMeaningId=' + encodeURI(suggestDefinedMeaningId.value);
		
	if (suggestAnnotationAttributeId != null)
		URL = URL + '&annotationAttributeId=' + encodeURI(suggestAnnotationAttributeId.value);
			
	http.open('GET', URL, true);
	http.onreadystatechange = function() {
		if (http.readyState == 4) {
			var newTable = document.createElement('div');
			//alert(http.responseText);
			if (http.responseText != '') {
				newTable.innerHTML = leftTrim(http.responseText);
				table.parentNode.replaceChild(newTable.firstChild, table);
			}
			suggestText.className = "";
		}
	};

	http.send(null);
}

var suggestionTimeOut = null;

function scheduleUpdateSuggestions(suggestPrefix) {
	if (suggestionTimeOut != null)
		clearTimeout(suggestionTimeOut);

	var suggestOffset = document.getElementById(suggestPrefix + "offset");
	suggestOffset.value = 0;
	suggestionTimeOut = setTimeout("updateSuggestions(\"" + suggestPrefix + "\")", 600);
}

function suggestTextChanged(suggestText) {
	scheduleUpdateSuggestions(getSuggestPrefix(suggestText, "text"));
}

function mouseOverRow(row) {
	row.className = "suggestion-row active";
}

function mouseOutRow(row) {
	row.className = "suggestion-row inactive";
}

function stopEventHandling(event) {
	event.cancelBubble = true;

	if (event.stopPropagation)
		event.stopPropagation();

	if (event.preventDefault)
		event.preventDefault();
	else
		event.returnValue = false;
}

function suggestLinkClicked(event, suggestLink) {
	var suggestLinkId = suggestLink.id;
	var suggestPrefix = suggestLinkId.substr(0, suggestLinkId.length - 4);

	var suggestDiv = document.getElementById(suggestPrefix + "div");
	var suggestField = document.getElementById(suggestPrefix + "text");
	suggestDiv.style.display = 'block';

	if (suggestField != null) {
		suggestField.focus();
		updateSuggestions(suggestPrefix);
	}
	
	stopEventHandling(event);
}

function updateSelectOptions(id, objectId, value) {
	var http = getHTTPObject();
	var URL = 'index.php';
	var location = "" + document.location;

	if (location.indexOf('index.php/') > 0)
		URL = '../' + URL;
	http.open('GET', URL + '/Special:Select?option-attribute=' + encodeURI(value) + '&attribute-object=' + encodeURI(objectId), true);
	http.send(null);

	http.onreadystatechange = function() {
		if (http.readyState == 4) {
			var select = document.getElementById(id);
			select.options.length = 0;
			var options = http.responseText.split("\n");

			for (idx in options) {
				option = options[idx].split(";");
				select.add(new Option(option[1],option[0]),null);
			}
		}
	};
}

function updateSuggestValue(suggestPrefix, value, displayValue) {
	var suggestLink = document.getElementById(suggestPrefix + "link");
	var suggestValue = document.getElementById(suggestPrefix + "value");
	var suggestDiv = document.getElementById(suggestPrefix + "div");
	var suggestField = document.getElementById(stripSuffix(suggestPrefix, "-suggest-"));

	suggestField.value = value;

	suggestLink.innerHTML = displayValue;
	suggestDiv.style.display = 'none';
	suggestLink.focus();

	var suggestOnUpdate = document.getElementById(suggestPrefix + "parameter-onUpdate");
	if(suggestOnUpdate != null) 
		eval(suggestOnUpdate.value + "," + value + ")");
}

function suggestClearClicked(event, suggestClear) {
	updateSuggestValue(getSuggestPrefix(suggestClear, 'clear'), "", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
	stopEventHandling(event);
}

function suggestCloseClicked(event, suggestClose) {
	var suggestPrefix = getSuggestPrefix(suggestClose, 'close');
	var suggestDiv = document.getElementById(suggestPrefix + 'div');
	suggestDiv.style.display = 'none';
	stopEventHandling(event);
}

function suggestNextClicked(event, suggestNext, dataSetOverride) {
	var suggestPrefix = getSuggestPrefix(suggestNext, 'next');
	var suggestOffset = document.getElementById(suggestPrefix + 'offset');
	suggestOffset.value = parseInt(suggestOffset.value) + 10;
	updateSuggestions(suggestPrefix);
	stopEventHandling(event);
}

function suggestPreviousClicked(event, suggestPrevious) {
	var suggestPrefix = getSuggestPrefix(suggestPrevious, 'previous');
	var suggestOffset = document.getElementById(suggestPrefix + 'offset');
	suggestOffset.value = Math.max(parseInt(suggestOffset.value) - 10, 0);
	updateSuggestions(suggestPrefix);
	stopEventHandling(event);
}

function suggestRowClicked(event, suggestRow) {
	var suggestPrefix = getSuggestPrefix(suggestRow.parentNode.parentNode.parentNode.parentNode, "div"); 
	var idColumnsField = document.getElementById(suggestPrefix + "id-columns");
	var displayLabelField = document.getElementById(suggestPrefix + "label-columns");
	var displayLabelColumnIndices = displayLabelField.value.split(", ");
	var labels = new Array();
	
	for (var i = 0; i < displayLabelColumnIndices.length; i++) {
		var columnValue = suggestRow.getElementsByTagName('td')[displayLabelColumnIndices[i]].innerHTML;
		
		if (columnValue != "")
			labels.push(columnValue);
	} 
	
	var idColumns = 1;
	
	if (idColumnsField != null)
		idColumns = idColumnsField.value;
	
	var values = suggestRow.id.split('-');
	var ids = new Array();
	
	for (var i = idColumns - 1; i >= 0; i--) 
		ids.push(values[values.length - i - 1]);

	updateSuggestValue(suggestPrefix, ids.join('-'), labels.join(', '));
	stopEventHandling(event);
}

function enableChildNodes(node, enabled) {
	if (enabled)
		var disabled = "";
	else
		var disabled = "disabled";

	childNodes = node.getElementsByTagName('select');

	for (var i = 0; i < childNodes.length; i++)
		childNodes[i].disabled = disabled;
}

function removeClicked(checkBox) {
	var container = checkBox.parentNode.parentNode;

	if (checkBox.checked)
		container.className = "to-be-removed";
	else
		container.className = "";

	//enableChildNodes(container, !checkBox.checked);
}

function isFormElement(node) {
	var name = node.nodeName.toLowerCase();

	return name == 'select' || name == 'option' || name == 'input' || name == 'textarea' || name == 'button';
}

function isLink(node) {
	return node.nodeName.toLowerCase() == 'a';
}

function getExpansionElementTypes() {
	var cookies = document.cookie.split(';');
	for(var i=0;i < cookies.length;i++) {
		var cookie = cookies[i];
		while(cookie.charAt(0)==' ')
			cookie = cookie.substring(1,cookie.length);
		if(cookie.indexOf("expansion=") == 0) {
			var expansionElementTypesStr = cookie.substring(10,cookie.length);
			var elementTypes = expansionElementTypesStr.split('|');
			if(elementTypes[0] == "")
				elementTypes.splice(0,1);
			return elementTypes;
		}
	}
	return new Array();
}

function setExpanded(elementType) {
	// Ensure the element type isn't yet set to expand.
	// This could be more efficient by avoiding the clear/rewrite.
	var expansionElementTypes = getExpansionElementTypes();
	for(var i=0;i<expansionElementTypes.length;i++) {
		if(expansionElementTypes[i]=="expand-" + elementType)
			return;
		else if(expansionElementTypes[i]=="collapse-" + elementType) {
			expansionElementTypes[i] = "expand-" + elementType;
			document.cookie = "expansion=" + expansionElementTypes.join("|");
			return;
		}
	}

	expansionElementTypes[expansionElementTypes.length] = "expand-" + elementType;
	document.cookie = "expansion=" + expansionElementTypes.join("|");
}

function setDefaultCollapsed(elementType) {
	// Ensure the element type isn't yet set to collapse.
	// This could be more efficient by avoiding the clear/rewrite.
	var expansionElementTypes = getExpansionElementTypes();
	for(var i=0;i<expansionElementTypes.length;i++) {
		if(expansionElementTypes[i]=="collapse-" + elementType)
			return;
		else if(expansionElementTypes[i]=="expand-" + elementType) {
			expansionElementTypes[i] = "collapse-" + elementType;
			document.cookie = "expansion=" + expansionElementTypes.join("|");
			return;
		}
	}
	expansionElementTypes[expansionElementTypes.length] = "collapse-" + elementType;
	document.cookie = "expansion=" + expansionElementTypes.join("|");
}

function getCollapsableId(elementName) {
	return 'collapsable-' + elementName;
}

function getCollapsableClass(element) {
	if(element) {
		var splitClassNames = element.className.split(' ');
		var index = 0;

		while(splitClassNames[index].indexOf("collapsable") == -1) {
			index++;
		}
		return stripPrefix(splitClassNames[index], "-");
	}
	else
		return "";
}

function stripPrefix(source, delimiter) {
	if(source) {
		var position = source.indexOf(delimiter) + 1;
		return source.substr(position, source.length - position);
	}
	else
		return "";
}

function toggle(element, event) {
	var source = event.target;

	if (!source)
		source = event.srcElement;

	if (!isFormElement(source) && !isLink(source)) {
		var elementName = stripPrefix(element.id, "-");
		var collapsableNode = document.getElementById(getCollapsableId(elementName));
		if (collapsableNode.style.display == 'inline' ||
			(collapsableNode.style.display != 'none' &&
			isCssClassExpanded(getCollapsableClass(element)))) {
			setDefaultCollapsed(getCollapsableClass(element));
			show(element, false);
		}
		else {
			setExpanded(getCollapsableClass(element));
			show(element, true);
		}

		stopEventHandling(event);
	}
}

function show(element, isShown) {
	var elementName = stripPrefix(element.id, "-");
	var collapsableNode = document.getElementById(getCollapsableId(elementName));
	var expandedPrefixNode = getExpandedPrefix(element);
	var collapsedPrefixNode = getCollapsedPrefix(element);

	if(isShown) {
		collapsableNode.style.display = 'inline';
		expandedPrefixNode.style.display = 'inline';
		collapsedPrefixNode.style.display = 'none';
	}
	else {
		collapsableNode.style.display = 'none';
		expandedPrefixNode.style.display = 'none';
		collapsedPrefixNode.style.display = 'inline';
	}
}

function getExpandedPrefix(element) {
	return document.getElementById(element.id.replace('collapse-', 'prefix-expanded-'));
}

function getCollapsedPrefix(element) {
	return document.getElementById(element.id.replace('collapse-', 'prefix-collapsed-'));
}

function expandEditors(event) {
	var expansionElementTypes = getExpansionElementTypes();
	for(var i=0; i<expansionElementTypes.length; i++)
		if(expansionElementTypes[i].substr(0, 7) == "expand-")
			expandCssClass(expansionElementTypes[i].substr(7), true);
		else
			expandCssClass(expansionElementTypes[i].substr(9), false);
}

/*function shouldExpand(element) {
	var candidateElementType = getTypeOf(element);
	var expansionElementTypes = getExpansionElementTypes();
	for(var i=0; i<expansionElementTypes.length; i++)
		if(expansionElementTypes[i] == "expand-" + candidateElementType)
			return true;

	return false;
}*/

function expandCssClass(cssClass, isExpanded) {
	var rulesKey;
	var is_opera = (navigator.userAgent.toLowerCase().indexOf("opera") != -1);

	if (document.all && !is_opera)
		rulesKey = 'rules';
	else
		rulesKey = 'cssRules';
	for(var sheet=0; sheet<document.styleSheets.length; sheet++)
		for(var rule=0; rule<document.styleSheets[sheet][rulesKey].length; rule++) {
			if(document.styleSheets[sheet][rulesKey][rule].selectorText == '.expand-'+cssClass)
				document.styleSheets[sheet][rulesKey][rule].style['display'] = (isExpanded?'inline':'none');
			else if(document.styleSheets[sheet][rulesKey][rule].selectorText == '.collapse-'+cssClass)
				document.styleSheets[sheet][rulesKey][rule].style['display'] = (isExpanded?'none':'inline');
		}
}

function isCssClassExpanded(cssClass) {
	var rulesKey;
	var is_opera = (navigator.userAgent.toLowerCase().indexOf("opera") != -1);

	if (document.all && !is_opera)
		rulesKey = 'rules';
	else
		rulesKey = 'cssRules';

	for(var sheet=0; sheet<document.styleSheets.length; sheet++) {
		for(var rule=0; rule<document.styleSheets[sheet][rulesKey].length; rule++) {
			if(document.styleSheets[sheet][rulesKey][rule].selectorText == '.expand-' + cssClass)
				return document.styleSheets[sheet][rulesKey][rule].style['display'] == 'inline';
		}
	}

	return false;
}

function getParentNode(node, nodeName) {
	var result = node.parentNode;
	
	while (result != null && result.tagName.toLowerCase() != nodeName)
		result = result.parentNode;
		
	return result; 
}

function getInnerText(element) {
	if (typeof element == "string") return element;
	if (typeof element == "undefined") { return element };
	if (element.innerText) return element.innerText;
	var str = "";
	
	var cs = element.childNodes;
	var l = cs.length;
	for (var i = 0; i < l; i++) {
		switch (cs[i].nodeType) {
			case 1: //ELEMENT_NODE
				str += getInnerText(cs[i]);
				break;
			case 3:	//TEXT_NODE
				str += cs[i].nodeValue;
				break;
		}
	}
	
	return str;
}

function ColumnSortInformation(index, direction) {
	this.index = index;
	this.direction = direction;
	
	this.toText = function () {
		return this.index + "," + this.direction;
	}
}

function SortOrder() {
	this.columns = new Array();
	this.length = 0;
	
	this.addColumn = function (column) {
		this.columns.push(column);
		this.length++;
	}
	
	this.extractColumn = function (index) {
		var result = this.columns[index];
		this.columns.splice(index, 1);
		this.length--;
		return result;
	}
	
	this.insertColumn = function (column) {
		this.columns.unshift(column);
		this.length++;
	}
	
	this.getColumn = function (index) {
		return this.columns[index];
	}
	
	this.toText = function () {
		var result = new Array();
		
		for (var i = 0; i < this.columns.length; i++)
			result.push(this.columns[i].toText());
			
		return result.join(';');
	}
	
	this.indexOfColumn = function(columnIndex) {
		var result = -1;
		var i = 0;
		
		while (result == -1 && i < this.columns.length)
			if (this.getColumn(i).index == columnIndex)
				result = i;
			else
				i++; 
		
		return result;
	}
	
	this.alterOrder = function (columnIndex) {
		var index = this.indexOfColumn(columnIndex);
		
		if (index == 0)
			this.getColumn(0).direction *= -1;
		else if (index == -1)
			this.insertColumn(new ColumnSortInformation(columnIndex, 1));
		else {
			var column = this.extractColumn(index);
			column.direction = 1;
			
			this.insertColumn(column);
		}
	}
}

function stringToSortOrder(value) {
	var result = new SortOrder();
	var columns = value.split(';');
	
	for (var i = 0; i < columns.length; i++) {
		var fields = columns[i].split(',');
		result.addColumn(new ColumnSortInformation(fields[0], fields[1]));
	}
	
	return result;
}

var sortOrder;

function compareTexts(text1, text2) {
	text1 = text1.toLowerCase();
	text2 = text2.toLowerCase();

	if (text1 == text2)
		return 0;
	else if (text1 > text2)
		return 1;
	else
		return -1;
}

function compareTableRows(row1, row2) {
	var result = 0;
	var i = 0;
	
	while (result == 0 && i < sortOrder.length) {
		var column = sortOrder.getColumn(i);
		result = column.direction * compareTexts(getInnerText(row1.cells[column.index]), getInnerText(row2.cells[column.index]));		
		i++;
	} 

	return result;
}

function getAllColumnHeaders(tableNode) {
	var headerRowCount = 0;

	while (headerRowCount < tableNode.rows.length && tableNode.rows[headerRowCount].cells[0].nodeName.toLowerCase() == "th") 
		headerRowCount++;
		
	var result = new Array();
			
	for (var i = 0; i < headerRowCount; i++) {
		var headerRow = tableNode.rows[i];
		
		for (j = 0; j < headerRow.cells.length; j++)
			result.push(headerRow.cells[j]);
	}

	return result;	
}

function nodeHasClass(node, className) {
	var nodeClasses = node.className.split(' ');
	var result = false;
	var i = 0;
	
	while (!result && i < nodeClasses.length)
		if (nodeClasses[i] == className)
			result = true;
		else
			i++;
			
	return result;
}

function removeNodeClass(node, className) {
	var nodeClasses = node.className.split(' ');
	var newClasses = new Array();
	
	for (var i = 0; i < nodeClasses.length; i++)
		if (nodeClasses[i] != className)
			newClasses.push(nodeClasses[i]);
			
	node.className = newClasses.join(" ");
}

function columnIsSortable(sortedColumnNode) {
	return nodeHasClass(sortedColumnNode, "sortable");
}

function changeSortIcons(tableNode, sortedColumnNode, sortDirection) {
	var columnHeaders = getAllColumnHeaders(tableNode);
	
	for (var i = 0; i < columnHeaders.length; i++) {
		var columnHeader = columnHeaders[i];
		
		if (columnIsSortable(columnHeader)) {
			removeNodeClass(columnHeader, "sortedUp");
			removeNodeClass(columnHeader, "sortedDown");
			
			if (columnHeader == sortedColumnNode) { 
				if (sortDirection == -1)
					columnHeader.className += " sortedUp";
				else
					columnHeader.className += " sortedDown";
			}
		}
	}
}

function sortTable(columnNode, skipRows, columnIndex) {
	var tableNode = getParentNode(columnNode, 'table');
	var rowsToSort = new Array();
	
	for (var i = skipRows; i < tableNode.rows.length; i++)
		rowsToSort.push(tableNode.rows[i]);
	
	var sortAttribute = tableNode.getAttribute('sort-order');	
	
	if (sortAttribute != null)
		sortOrder = stringToSortOrder(sortAttribute);
	else 
		sortOrder = new SortOrder();
		
	sortOrder.alterOrder(columnIndex);
	rowsToSort.sort(compareTableRows);

	for (var i = 0; i < rowsToSort.length; i++)
		tableNode.tBodies[0].appendChild(rowsToSort[i]);	
		
	tableNode.setAttribute('sort-order', sortOrder.toText());
	changeSortIcons(tableNode, columnNode, sortOrder.getColumn(0).direction);		
}

function changePopupLinkArrow(popupLink, newArrow) {
	var linkHTML = popupLink.innerHTML;
	popupLink.innerHTML = linkHTML.substr(0, linkHTML.length - 1) + newArrow;
}

function togglePopup(popupLink, event) {
	var popupLinkId = popupLink.id;
	var popup = document.getElementById(stripSuffix(popupLinkId, 'link') + 'toggleable');
  
 	if (popup.style.display == 'none') {
 		popup.style.display = 'block';
 		changePopupLinkArrow(popupLink, '&laquo;');
	}
	else {
		popup.style.display = 'none';
 		changePopupLinkArrow(popupLink, '&raquo;');
	}
}

function rollBackOptionChanged(rollBackSelect) {
	var versionSelector = document.getElementById(rollBackSelect.name + '-version-selector');
	
	if (rollBackSelect.value == 'previous-version')
		versionSelector.style.display = 'block';
	else
		versionSelector.style.display = 'none';
}

var elementsToSort=new Array();
	
function sortAll() {
	for (elementId in elementsToSort) {
		var params=elementsToSort[elementId];
		
		var myElement=document.getElementById(params["elementName"]);
		var skipRows=params["skipRows"];
		var columnIndex=params["columnIndex"];
		
		sortTable(myElement, skipRows, columnIndex);
	}
}


function toSort(elementName,skipRows, columnIndex) {
	var params=new Array();

	params["elementName"]=elementName;
	params["skipRows"]=skipRows;
	params["columnIndex"]=columnIndex;
	
	elementsToSort.push(params);
}

function startsWith(value, prefix) {
	return value.toLowerCase().substr(0, prefix.length) == prefix.toLowerCase();
}

function IsNumeric(sText){
   var ValidChars = "0123456789. ";
   var IsNumber=true;
   var Char;

 
   for (i = 0; i < sText.length && IsNumber == true; i++){ 
      Char = sText.charAt(i); 
      if (ValidChars.indexOf(Char) == -1){
         IsNumber = false;
      }
   }
   return IsNumber;   
}

function trim(value){
  value = value.replace(/^\s+/,'');
  value = value.replace(/\s+$/,'');
  return value;
}

function urlFieldChanged(urlField) {
	var labelField = document.getElementById(stripSuffix(urlField.id, "url") + "label");
	var url = urlField.value;

	if (startsWith(url, "http://www.ncbi.nlm.nih.gov")  ) {
		pubMedIdRec = ExtractText( url, "TermToSearch=", 0, "&ordinalpos", 0 );
		if ( pubMedIdRec != null ){
			labelField.value = getPubMedTitle(pubMedIdRec[1]);
		}
	}
	else if ( IsNumeric( url ) ){
		labelField.value = getPubMedTitle(trim(url));
		urlField.value = "http://www.ncbi.nlm.nih.gov/sites/entrez?Db=pubmed&Cmd=ShowDetailView&TermToSearch=" + trim(url) + "&ordinalpos=1&itool=EntrezSystem2.PEntrez.Pubmed.Pubmed_ResultsPanel.Pubmed_RVDocSum";
	}
}

// Knewco specific Javascript

function GetOffset( text, Pattern, inclusive ){
    var extra = 0;

    try{
        offset = text.indexOf( Pattern );

        if ( offset != -1 ){
            if ( inclusive ){
                 offset = offset + Pattern.length;
            }
        
             return offset;
        }
        return -1;
    }
    catch(e){
        return -1;
    }   
   
}

function ExtractText( text, startTag, startOffset, endTag, endOffset ){
    var extra  = 0;
    var offset = 0;
    var endPos = 0;
   
    try{
        /* search for a starting pattern in the text and return the remainder */
        offset = GetOffset( text, startTag, true );       
        if ( offset == -1 ){
            return null;
        }
       
        offset += startOffset;
        text2 = text.slice( offset );
       
        if ( endTag != '' ){
            /* search for an ending pattern in the text and return the part before */
            endPos = GetOffset( text2, endTag, false );
           
            if ( endPos == -1 ){
                return [offset,text2];
            }
            endPos += endOffset + offset;
            text3 = text.slice( offset, endPos );   
        }
        else{
            return [offset,text2];
        }       
        return [offset,text3];
    }
    catch(e){
        return null;
    }   
}

function getPubMedTitle( pmid ){
    try {
        xmlhttp = GetXMLHttpRequest();
        try{
            xmlhttp.async = false;
        } catch(e){
        }

        xmlhttp.open( "GET", "http://"+ HOST + "/knewco/get.py?http://www.ncbi.nlm.nih.gov/entrez/utils/pmfetch.fcgi?db=PubMed&id="+pmid+"&report=xml&mode=text", false );
        xmlhttp.send(null);

        if ( xmlhttp.status == 200){
            AuthorsRec = ExtractText( xmlhttp.responseText, "<AuthorList", 0, "</AuthorList>", 0 );
            if ( AuthorsRec != null ) {
                Authors = AuthorsRec[1];
            }
            else{
                Authors = "";
            }

            var Offset = 0;
            var AuthorText = "";
            while (true) {
                AuthorRec = ExtractText( Authors.slice( Offset ), "<Author", 0, "</Author>", 0 );
                if ( AuthorRec == null ){
                    break;
                }
                Offset += AuthorRec[0]
                AuthorXml = AuthorRec[1]
                LastNameRec  = ExtractText( AuthorXml, "<LastName>", 0, "</LastName>", 0 );
                if ( LastNameRec != null ){
                    LastName = LastNameRec[1];
                } else{
                    LastName = "";
                }
                FirstNameRec = ExtractText( AuthorXml, "<FirstName>", 0, "</FirstName>", 0 );
                if ( FirstNameRec == null ){
                    FirstNameRec = ExtractText( AuthorXml, "<ForeName>", 0, "</ForeName>", 0 );
                }
                
                if ( FirstNameRec != null ){
                    FirstName = FirstNameRec[1];
                } else {
                    FirstName = "";
                }

                if ( LastName != "" ){
                    if ( AuthorText != "" ){
                        AuthorText += "; "
                    }

                    if ( FirstName != "" ){
                        AuthorText += LastName + ", " + FirstName;
                    }
                    else {
                        AuthorText += LastName;
                    }
                }
            }
            TitleRec = ExtractText( xmlhttp.responseText, "<ArticleTitle>", 0, "</ArticleTitle>", 0 );
            if ( TitleRec != null ){
            	if ( AuthorText != "" ){
                	return AuthorText + ". " + TitleRec[1];
            	}
            	else {
                	return TitleRec[1];            		
            	}
            }
            else {
                return AuthorText;
            }
        }
    } catch(e){
    }
    return "";
}
