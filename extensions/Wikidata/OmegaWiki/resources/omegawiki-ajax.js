
jQuery(function() {
	
	// sort all tables
	sortAll();

	// create the dropdown menu (e.g. to select a language in the Expression: namespace)
	$("span.wd-dropdown").hover(function() {
		//Drop down the dropdownmenu
		$(this).parent().find("ul.wd-dropdownlist").show();
	}, function(){  //On Hover Out 
		$(this).parent().find("ul.wd-dropdownlist").hide();
	});
}); // jQuery

//TODO: convert the functions below to jQuery...

window.elementsToSort = new Array();

window.isFormElement = function (node) {
	var name = node.nodeName.toLowerCase();

	return name == 'select' || name == 'option' || name == 'input' || name == 'textarea' || name == 'button';
}

window.isLink = function (node) {
	return node.nodeName.toLowerCase() == 'a';
}

window.getExpansionElementTypes = function () {
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

window.setExpanded = function (elementType) {
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

window.setDefaultCollapsed = function (elementType) {
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

window.getCollapsableId = function (elementName) {
	return 'collapsable-' + elementName;
}

window.getCollapsableClass = function (element) {
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

window.stripPrefix = function (source, delimiter) {
	if(source) {
		var position = source.indexOf(delimiter) + 1;
		return source.substr(position, source.length - position);
	}
	else
		return "";
}

window.toggle = function (element, event) {
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

window.show = function (element, isShown) {
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

window.getExpandedPrefix = function (element) {
	return document.getElementById(element.id.replace('collapse-', 'prefix-expanded-'));
}

window.getCollapsedPrefix = function (element) {
	return document.getElementById(element.id.replace('collapse-', 'prefix-collapsed-'));
}

window.expandEditors = function (event) {
	var expansionElementTypes = getExpansionElementTypes();
	for(var i=0; i<expansionElementTypes.length; i++)
		if(expansionElementTypes[i].substr(0, 7) == "expand-")
			expandCssClass(expansionElementTypes[i].substr(7), true);
		else
			expandCssClass(expansionElementTypes[i].substr(9), false);
}

window.expandCssClass = function (cssClass, isExpanded) {
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

window.isCssClassExpanded = function (cssClass) {
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

window.getParentNode = function (node, nodeName) {
	var result = node.parentNode;
	
	while (result != null && result.tagName.toLowerCase() != nodeName)
		result = result.parentNode;
		
	return result; 
}

window.getInnerText = function (element) {
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

window.ColumnSortInformation = function (index, direction) {
	this.index = index;
	this.direction = direction;
	
	this.toText = function () {
		return this.index + "," + this.direction;
	}
}

window.SortOrder = function () {
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

window.stringToSortOrder = function (value) {
	var result = new SortOrder();
	var columns = value.split(';');
	
	for (var i = 0; i < columns.length; i++) {
		var fields = columns[i].split(',');
		result.addColumn(new ColumnSortInformation(fields[0], fields[1]));
	}
	
	return result;
}

// remove accents for comparison
window.normalizeText = function (text) {
	text = text.replace(new RegExp("[àáâãäå]", 'g'),"a");
	text = text.replace(new RegExp("æ", 'g'),"ae");
	text = text.replace(new RegExp("ç", 'g'),"c");
	text = text.replace(new RegExp("[èéêë]", 'g'),"e");
	text = text.replace(new RegExp("[ìíîï]", 'g'),"i");
	text = text.replace(new RegExp("ñ", 'g'),"n");
	text = text.replace(new RegExp("[òóôõö]", 'g'),"o");
	text = text.replace(new RegExp("œ", 'g'),"oe");
	text = text.replace(new RegExp("[ùúûü]", 'g'),"u");
	text = text.replace(new RegExp("[ýÿ]", 'g'),"y");
	return text ;
}

window.compareTexts = function (text1, text2) {
	text1 = text1.toLowerCase();
	text2 = text2.toLowerCase();

	text1 = normalizeText(text1) ;
	text2 = normalizeText(text2) ;

	if (text1 == text2)
		return 0;
	else if (text1 > text2)
		return 1;
	else
		return -1;
}

window.compareTableRows = function (row1, row2) {
	var result = 0;
	var i = 0;
	
	while (result == 0 && i < window.sortOrder.length) {
		var column = window.sortOrder.getColumn(i);
		result = column.direction * compareTexts(getInnerText(row1.cells[column.index]), getInnerText(row2.cells[column.index]));		
		i++;
	} 

	return result;
}

window.getAllColumnHeaders = function (tableNode) {
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

window.nodeHasClass = function (node, className) {
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

window.removeNodeClass = function (node, className) {
	var nodeClasses = node.className.split(' ');
	var newClasses = new Array();
	
	for (var i = 0; i < nodeClasses.length; i++)
		if (nodeClasses[i] != className)
			newClasses.push(nodeClasses[i]);
			
	node.className = newClasses.join(" ");
}

window.columnIsSortable = function (sortedColumnNode) {
	return nodeHasClass(sortedColumnNode, "sortable");
}

window.changeSortIcons = function (tableNode, sortedColumnNode, sortDirection) {
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

window.sortTable = function (columnNode, skipRows, columnIndex) {
	var tableNode = getParentNode(columnNode, 'table');
	var rowsToSort = new Array();
	
	for (var i = skipRows; i < tableNode.rows.length; i++)
		rowsToSort.push(tableNode.rows[i]);
	
	var sortAttribute = tableNode.getAttribute('sort-order');	
	
	if (sortAttribute != null)
		window.sortOrder = stringToSortOrder(sortAttribute);
	else 
		window.sortOrder = new SortOrder();
		
	window.sortOrder.alterOrder(columnIndex);
	rowsToSort.sort(compareTableRows);

	for (var i = 0; i < rowsToSort.length; i++)
		tableNode.tBodies[0].appendChild(rowsToSort[i]);	
		
	tableNode.setAttribute('sort-order', window.sortOrder.toText());
	changeSortIcons(tableNode, columnNode, window.sortOrder.getColumn(0).direction);		
}

window.stripSuffix = function (source, suffix) {
	return source.substr(0, source.length - suffix.length);
}

window.changePopupLinkArrow = function (popupLink, newArrow) {
	var linkHTML = popupLink.innerHTML;
	popupLink.innerHTML = linkHTML.substr(0, linkHTML.length - 1) + newArrow;
}

window.togglePopup = function (popupLink, event) {
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

window.rollBackOptionChanged = function (rollBackSelect) {
	var versionSelector = document.getElementById(rollBackSelect.name + '-version-selector');
	
	if (rollBackSelect.value == 'previous-version')
		versionSelector.style.display = 'block';
	else
		versionSelector.style.display = 'none';
}

window.sortAll = function () {
	for (elementId in window.elementsToSort) {

		var params=window.elementsToSort[elementId];
		
		var myElement=document.getElementById(params["elementName"]);
		var skipRows=params["skipRows"];
		var columnIndex=params["columnIndex"];
		
		sortTable(myElement, skipRows, columnIndex);
	}
}

window.toSort = function (elementName,skipRows, columnIndex) {
	var params=new Array();

	params["elementName"]=elementName;
	params["skipRows"]=skipRows;
	params["columnIndex"]=columnIndex;
	
	window.elementsToSort.push(params);
}

window.startsWith = function (value, prefix) {
	return value.toLowerCase().substr(0, prefix.length) == prefix.toLowerCase();
}

window.IsNumeric = function (sText){
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

window.trim = function (value){
	value = value.replace(/^\s+/,'');
	value = value.replace(/\s+$/,'');
	return value;
}

window.MD5 = function (string) {

	function RotateLeft(lValue, iShiftBits) {
		return (lValue<<iShiftBits) | (lValue>>>(32-iShiftBits));
	}

	function AddUnsigned(lX,lY) {
		var lX4,lY4,lX8,lY8,lResult;
		lX8 = (lX & 0x80000000);
		lY8 = (lY & 0x80000000);
		lX4 = (lX & 0x40000000);
		lY4 = (lY & 0x40000000);
		lResult = (lX & 0x3FFFFFFF)+(lY & 0x3FFFFFFF);
		if (lX4 & lY4) {
			return (lResult ^ 0x80000000 ^ lX8 ^ lY8);
		}
		if (lX4 | lY4) {
			if (lResult & 0x40000000) {
				return (lResult ^ 0xC0000000 ^ lX8 ^ lY8);
			} else {
				return (lResult ^ 0x40000000 ^ lX8 ^ lY8);
			}
		} else {
			return (lResult ^ lX8 ^ lY8);
		}
	}

	function F(x,y,z) { return (x & y) | ((~x) & z); }
	function G(x,y,z) { return (x & z) | (y & (~z)); }
	function H(x,y,z) { return (x ^ y ^ z); }
	function I(x,y,z) { return (y ^ (x | (~z))); }

	function FF(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(F(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	};

	function GG(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(G(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	};

	function HH(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(H(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	};

	function II(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(I(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	};

	function ConvertToWordArray(string) {
		var lWordCount;
		var lMessageLength = string.length;
		var lNumberOfWords_temp1=lMessageLength + 8;
		var lNumberOfWords_temp2=(lNumberOfWords_temp1-(lNumberOfWords_temp1 % 64))/64;
		var lNumberOfWords = (lNumberOfWords_temp2+1)*16;
		var lWordArray=Array(lNumberOfWords-1);
		var lBytePosition = 0;
		var lByteCount = 0;
		while ( lByteCount < lMessageLength ) {
			lWordCount = (lByteCount-(lByteCount % 4))/4;
			lBytePosition = (lByteCount % 4)*8;
			lWordArray[lWordCount] = (lWordArray[lWordCount] | (string.charCodeAt(lByteCount)<<lBytePosition));
			lByteCount++;
		}
		lWordCount = (lByteCount-(lByteCount % 4))/4;
		lBytePosition = (lByteCount % 4)*8;
		lWordArray[lWordCount] = lWordArray[lWordCount] | (0x80<<lBytePosition);
		lWordArray[lNumberOfWords-2] = lMessageLength<<3;
		lWordArray[lNumberOfWords-1] = lMessageLength>>>29;
		return lWordArray;
	};

	function WordToHex(lValue) {
		var WordToHexValue="",WordToHexValue_temp="",lByte,lCount;
		for (lCount = 0;lCount<=3;lCount++) {
			lByte = (lValue>>>(lCount*8)) & 255;
			WordToHexValue_temp = "0" + lByte.toString(16);
			WordToHexValue = WordToHexValue + WordToHexValue_temp.substr(WordToHexValue_temp.length-2,2);
		}
		return WordToHexValue;
	};

	function Utf8Encode(string) {
		string = string.replace(/\r\n/g,"\n");
		var utftext = "";

		for (var n = 0; n < string.length; n++) {

			var c = string.charCodeAt(n);

			if (c < 128) {
				utftext += String.fromCharCode(c);
			}
			else if((c > 127) && (c < 2048)) {
				utftext += String.fromCharCode((c >> 6) | 192);
				utftext += String.fromCharCode((c & 63) | 128);
			}
			else {
				utftext += String.fromCharCode((c >> 12) | 224);
				utftext += String.fromCharCode(((c >> 6) & 63) | 128);
				utftext += String.fromCharCode((c & 63) | 128);
			}

		}

		return utftext;
	};

	var x=Array();
	var k,AA,BB,CC,DD,a,b,c,d;
	var S11=7, S12=12, S13=17, S14=22;
	var S21=5, S22=9 , S23=14, S24=20;
	var S31=4, S32=11, S33=16, S34=23;
	var S41=6, S42=10, S43=15, S44=21;

	string = Utf8Encode(string);

	x = ConvertToWordArray(string);

	a = 0x67452301; b = 0xEFCDAB89; c = 0x98BADCFE; d = 0x10325476;

	for (k=0;k<x.length;k+=16) {
		AA=a; BB=b; CC=c; DD=d;
		a=FF(a,b,c,d,x[k+0], S11,0xD76AA478);
		d=FF(d,a,b,c,x[k+1], S12,0xE8C7B756);
		c=FF(c,d,a,b,x[k+2], S13,0x242070DB);
		b=FF(b,c,d,a,x[k+3], S14,0xC1BDCEEE);
		a=FF(a,b,c,d,x[k+4], S11,0xF57C0FAF);
		d=FF(d,a,b,c,x[k+5], S12,0x4787C62A);
		c=FF(c,d,a,b,x[k+6], S13,0xA8304613);
		b=FF(b,c,d,a,x[k+7], S14,0xFD469501);
		a=FF(a,b,c,d,x[k+8], S11,0x698098D8);
		d=FF(d,a,b,c,x[k+9], S12,0x8B44F7AF);
		c=FF(c,d,a,b,x[k+10],S13,0xFFFF5BB1);
		b=FF(b,c,d,a,x[k+11],S14,0x895CD7BE);
		a=FF(a,b,c,d,x[k+12],S11,0x6B901122);
		d=FF(d,a,b,c,x[k+13],S12,0xFD987193);
		c=FF(c,d,a,b,x[k+14],S13,0xA679438E);
		b=FF(b,c,d,a,x[k+15],S14,0x49B40821);
		a=GG(a,b,c,d,x[k+1], S21,0xF61E2562);
		d=GG(d,a,b,c,x[k+6], S22,0xC040B340);
		c=GG(c,d,a,b,x[k+11],S23,0x265E5A51);
		b=GG(b,c,d,a,x[k+0], S24,0xE9B6C7AA);
		a=GG(a,b,c,d,x[k+5], S21,0xD62F105D);
		d=GG(d,a,b,c,x[k+10],S22,0x2441453);
		c=GG(c,d,a,b,x[k+15],S23,0xD8A1E681);
		b=GG(b,c,d,a,x[k+4], S24,0xE7D3FBC8);
		a=GG(a,b,c,d,x[k+9], S21,0x21E1CDE6);
		d=GG(d,a,b,c,x[k+14],S22,0xC33707D6);
		c=GG(c,d,a,b,x[k+3], S23,0xF4D50D87);
		b=GG(b,c,d,a,x[k+8], S24,0x455A14ED);
		a=GG(a,b,c,d,x[k+13],S21,0xA9E3E905);
		d=GG(d,a,b,c,x[k+2], S22,0xFCEFA3F8);
		c=GG(c,d,a,b,x[k+7], S23,0x676F02D9);
		b=GG(b,c,d,a,x[k+12],S24,0x8D2A4C8A);
		a=HH(a,b,c,d,x[k+5], S31,0xFFFA3942);
		d=HH(d,a,b,c,x[k+8], S32,0x8771F681);
		c=HH(c,d,a,b,x[k+11],S33,0x6D9D6122);
		b=HH(b,c,d,a,x[k+14],S34,0xFDE5380C);
		a=HH(a,b,c,d,x[k+1], S31,0xA4BEEA44);
		d=HH(d,a,b,c,x[k+4], S32,0x4BDECFA9);
		c=HH(c,d,a,b,x[k+7], S33,0xF6BB4B60);
		b=HH(b,c,d,a,x[k+10],S34,0xBEBFBC70);
		a=HH(a,b,c,d,x[k+13],S31,0x289B7EC6);
		d=HH(d,a,b,c,x[k+0], S32,0xEAA127FA);
		c=HH(c,d,a,b,x[k+3], S33,0xD4EF3085);
		b=HH(b,c,d,a,x[k+6], S34,0x4881D05);
		a=HH(a,b,c,d,x[k+9], S31,0xD9D4D039);
		d=HH(d,a,b,c,x[k+12],S32,0xE6DB99E5);
		c=HH(c,d,a,b,x[k+15],S33,0x1FA27CF8);
		b=HH(b,c,d,a,x[k+2], S34,0xC4AC5665);
		a=II(a,b,c,d,x[k+0], S41,0xF4292244);
		d=II(d,a,b,c,x[k+7], S42,0x432AFF97);
		c=II(c,d,a,b,x[k+14],S43,0xAB9423A7);
		b=II(b,c,d,a,x[k+5], S44,0xFC93A039);
		a=II(a,b,c,d,x[k+12],S41,0x655B59C3);
		d=II(d,a,b,c,x[k+3], S42,0x8F0CCC92);
		c=II(c,d,a,b,x[k+10],S43,0xFFEFF47D);
		b=II(b,c,d,a,x[k+1], S44,0x85845DD1);
		a=II(a,b,c,d,x[k+8], S41,0x6FA87E4F);
		d=II(d,a,b,c,x[k+15],S42,0xFE2CE6E0);
		c=II(c,d,a,b,x[k+6], S43,0xA3014314);
		b=II(b,c,d,a,x[k+13],S44,0x4E0811A1);
		a=II(a,b,c,d,x[k+4], S41,0xF7537E82);
		d=II(d,a,b,c,x[k+11],S42,0xBD3AF235);
		c=II(c,d,a,b,x[k+2], S43,0x2AD7D2BB);
		b=II(b,c,d,a,x[k+9], S44,0xEB86D391);
		a=AddUnsigned(a,AA);
		b=AddUnsigned(b,BB);
		c=AddUnsigned(c,CC);
		d=AddUnsigned(d,DD);
	}

	var temp = WordToHex(a)+WordToHex(b)+WordToHex(c)+WordToHex(d);

	return temp.toLowerCase();
}
