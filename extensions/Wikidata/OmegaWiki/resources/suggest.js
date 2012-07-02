window.getHTTPObject = function () {
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

window.getSuggestPrefix = function (node, postFix) {
	var nodeId = node.id;
	return stripSuffix(nodeId, postFix);
}

window.leftTrim = function (sString) {
	while (sString.substring(0,1) == ' ' || sString.substring(0,1) == "\n") {
			sString = sString.substring(1, sString.length);
		}
	return sString;
}

/*
* suggests a list (of languages, classes...) according to the letters typed in the query field
* or to the arrows "next" "previous"
*/
window.updateSuggestions = function (suggestPrefix) {
	var http = getHTTPObject();
	var table = document.getElementById(suggestPrefix + "table");
	var suggestQuery = document.getElementById(suggestPrefix + "query").value;
	var suggestOffset = document.getElementById(suggestPrefix + "offset").value;
	var dataSet = document.getElementById(suggestPrefix + "dataset").value;	

	suggestText = document.getElementById(suggestPrefix + "text");
	suggestText.className = "suggest-loading";
	var suggestTextVal = suggestText.value ; // we copy the value to compare it later to the current value

	var suggestAttributesLevel = document.getElementById(suggestPrefix + "parameter-level");
	var suggestDefinedMeaningId = document.getElementById(suggestPrefix + "parameter-definedMeaningId");
	var suggestSyntransId = document.getElementById(suggestPrefix + "parameter-syntransId");
	var suggestAnnotationAttributeId = document.getElementById(suggestPrefix + "parameter-annotationAttributeId");
	
	var URL = 'index.php';
	var location = "" + document.location;
	
	if (location.indexOf('index.php/') > 0)	URL = '../' + URL;

	URL = 
		wgScript +
		'?title=Special:Suggest&search-text=' + encodeURI(suggestTextVal) + 
		'&prefix=' + encodeURI(suggestPrefix) + 
		'&query=' + encodeURI(suggestQuery) + 
		'&offset=' + encodeURI(suggestOffset) + 
		'&dataset='+dataSet;

	if (suggestAttributesLevel != null)
		URL = URL + '&attributesLevel=' + encodeURI(suggestAttributesLevel.value);
	
	if (suggestDefinedMeaningId != null) 
		URL = URL + '&definedMeaningId=' + encodeURI(suggestDefinedMeaningId.value);
		
	if (suggestSyntransId != null) 
		URL = URL + '&syntransId=' + encodeURI(suggestSyntransId.value);
		
	if (suggestAnnotationAttributeId != null)
		URL = URL + '&annotationAttributeId=' + encodeURI(suggestAnnotationAttributeId.value);
			
	http.onreadystatechange = function() {
		if (http.readyState == 4) {
			var newTable = document.createElement('div');
			//alert(http.responseText);
			if (http.responseText != '') {
				newTable.innerHTML = leftTrim(http.responseText);
				table.parentNode.replaceChild(newTable.firstChild, table);
			}
			suggestText.className = "";

			// comparing the stored value send in the URL, and the actual value
			if ( suggestTextVal != suggestText.value ) {
				window.suggestionTimeOut = setTimeout("updateSuggestions(\"" + suggestPrefix + "\")", 100);
			}
		}
	};

	http.open('GET', URL, true);
	http.send(null);
}

window.suggestionTimeOut = null;

window.scheduleUpdateSuggestions = function (suggestPrefix) {
	if (window.suggestionTimeOut != null)
		clearTimeout(window.suggestionTimeOut);

	var suggestOffset = document.getElementById(suggestPrefix + "offset");
	suggestOffset.value = 0;
	window.suggestionTimeOut = setTimeout("updateSuggestions(\"" + suggestPrefix + "\")", 600);
}

window.suggestTextChanged = function (suggestText) {
	scheduleUpdateSuggestions(getSuggestPrefix(suggestText, "text"));
}

window.mouseOverRow = function (row) {
	row.className = "suggestion-row active";
}

window.mouseOutRow = function (row) {
	row.className = "suggestion-row inactive";
}

window.stopEventHandling = function (event) {
	event.cancelBubble = true;

	if (event.stopPropagation)
		event.stopPropagation();

	if (event.preventDefault)
		event.preventDefault();
	else
		event.returnValue = false;
}

window.suggestLinkClicked = function (event, suggestLink) {
	var suggestLinkId = suggestLink.id;
	// removing the "link" at the end of the Id
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

window.updateSelectOptions = function (id, objectId, value) {
	var http = getHTTPObject();
	var URL = 'index.php';
	var location = "" + document.location;

	if (location.indexOf('index.php/') > 0) URL = '../' + URL;
	http.open('GET', URL + '/Special:Select?optnAtt=' + encodeURI(value) + '&attribute-object=' + encodeURI(objectId), true);
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

window.updateSuggestValue = function (suggestPrefix, value, displayValue) {
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

window.suggestClearClicked = function (event, suggestClear) {
	updateSuggestValue(getSuggestPrefix(suggestClear, 'clear'), "", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
	stopEventHandling(event);
}

window.suggestCloseClicked = function (event, suggestClose) {
	var suggestPrefix = getSuggestPrefix(suggestClose, 'close');
	var suggestDiv = document.getElementById(suggestPrefix + 'div');
	suggestDiv.style.display = 'none';
	stopEventHandling(event);
}

window.suggestNextClicked = function (event, suggestNext, dataSetOverride) {
	var suggestPrefix = getSuggestPrefix(suggestNext, 'next');
	var suggestOffset = document.getElementById(suggestPrefix + 'offset');
	suggestOffset.value = parseInt(suggestOffset.value) + 10;
	updateSuggestions(suggestPrefix);
	stopEventHandling(event);
}

window.suggestPreviousClicked = function (event, suggestPrevious) {
	var suggestPrefix = getSuggestPrefix(suggestPrevious, 'previous');
	var suggestOffset = document.getElementById(suggestPrefix + 'offset');
	suggestOffset.value = Math.max(parseInt(suggestOffset.value) - 10, 0);
	updateSuggestions(suggestPrefix);
	stopEventHandling(event);
}

window.suggestRowClicked = function (event, suggestRow) {
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

window.enableChildNodes = function (node, enabled) {
	if (enabled)
		var disabled = "";
	else
		var disabled = "disabled";

	childNodes = node.getElementsByTagName('select');

	for (var i = 0; i < childNodes.length; i++)
		childNodes[i].disabled = disabled;
}

window.removeClicked = function (checkBox) {
	var container = checkBox.parentNode.parentNode;

	if (checkBox.checked)
		container.className = "to-be-removed";
	else
		container.className = "";

}
