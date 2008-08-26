var undefined;

function getFirstNodeOfType(nodeType,parent) {
	parent = (parent) ? parent : document;
	for ( var m = parent.firstChild; m != null; m = m.nextSibling ) {
		switch (nodeType) {
			case Node.ELEMENT_NODE:
				if (m.nodeType == 1) return m;
				break;
			case Node.TEXT_NODE:
				if (m.nodeType == 3) return m;
				break;
		}
	}
	return null;
}

function getFirstElementOfClass(tagName,className,root) {
    var nodeOfInterest, kids;
    root = (root) ? root : window.document;
    kids = root.getElementsByTagName(tagName);
    for ( var j = 0; j < kids.length; j++ ) {
        if ( kids[j].className.indexOf(className) != -1 ) nodeOfInterest = kids[j];
    }
    return nodeOfInterest;
}

function getElementsByClassName(tagName,className,root) {
    var nodesOfInterest, kids;
    root = (root) ? root : window.document;
    nodesOfInterest = new Array();
    kids = root.getElementsByTagName(tagName);
    for ( var j = 0; j < kids.length; j++ ) {
        if ( kids[j].className.indexOf(className) != -1 ) nodesOfInterest[nodesOfInterest.length] = kids[j];
    }
    return nodesOfInterest;
}

function getFirstAncestorOfTagName(n,tagName) {
	//alert('entering recurse');
	if (!n.parentNode) {
		return;
	} else if (n.parentNode.nodeName == tagName.toUpperCase()) {
		return n.parentNode;
	} else {
		getFirstAncestorOfTagName(n.parentNode,tagName);
	}
}

function getFirstChildOfTagName(n,tagName) {
	tagName = tagName.toUpperCase();
	if (n.hasChildNodes()) {
		for ( var i = 0; i < n.childNodes.length; i++ ) {
			if ( n.childNodes[i].nodeName == tagName ) {
				return n.childNodes[i];
			}
		}
	}
	return;
}

function addEventListeners(EventSource,EventType,EventHandler,captures) {
	captures = (captures) ? captures : false;
	if ( document.addEventListener ) {
		EventSource.addEventListener(EventType,EventHandler,captures);
	} else if (document.attachEvent) {
		EventType = "on" + EventType;
		EventSource.attachEvent(EventType,EventHandler);
	} else {
		EventType = "on" + EventType;
		EventSource[EventType] = EventHandler;
	}
}

function removeEventListeners(EventSource,EventType,EventHandler,captures) {
	captures = (captures) ? captures : false;
	if ( document.removeEventListener ) {
		EventSource.removeEventListener(EventType,EventHandler,captures);
	} else if (document.detachEvent) {
		EventType = "on" + EventType;
		EventSource.detachEvent(EventType,EventHandler);
	} else {
		EventType = "on" + EventType;
		EventSource[EventType] = null;
	}
}

function getEvent(evt) {
	return (evt) ? evt : (window.event) ? window.event : null;
}

function getTarget(evt) {
	return (evt.target) ? evt.target : (evt.srcElement) ? evt.srcElement : null;
}

function getCurrentTarget(evt,currentTarget) {
	return (evt.currentTarget) ? evt.currentTarget : (currentTarget) ? currentTarget : (this) ? this : null;
}

function getPos(n,evt) {
	if (n == 'X') {
		return (evt.pageX) ? evt.pageX : (document.documentElement.scrollLeft) ? (document.documentElement.scrollLeft + evt.clientX) : (document.body.scrollLeft) ? (document.body.scrollLeft + evt.clientX) : evt.clientX;
	} else {
		return (evt.pageY) ? evt.pageY : (document.documentElement.scrollTop) ? (document.documentElement.scrollTop + evt.clientY) : (document.body.scrollTop) ? (document.body.scrollTop + evt.clientY) : evt.clientY;
	}
}


function bubbleCancel(evt) {
	if (!evt) return;
	if (evt.stopPropagation) {
		evt.stopPropagation();
		evt.preventDefault();
	} else if (typeof evt.cancelBubble != undefined) {
		evt.cancelBubble = true;
		evt.returnValue = false;
	} else {
		return false;
		evt = null;
	}
}

var isOpera = false;
var isSafari = false;
var isIE5Mac = false;
var isIEWin = false;
var isIEWin50 = false;
var isIEWin55plus = false;

function UADetect() {
	var UA = navigator.userAgent;
	//document.write(UA);
	if (UA.indexOf("Opera") != -1)
		isOpera = true;
	else if (UA.indexOf("AppleWebKit") != -1)
		isSafari = true;
	else if (UA.indexOf("Mac") != -1 && UA.indexOf("MSIE ") != -1)
		isIE5Mac = true;
	else if (UA.indexOf("Win") != -1 && UA.indexOf("MSIE") != -1 && UA.indexOf("Opera") == -1) {
		isIEWin = true;
		if (UA.indexOf("MSIE 5.0") != -1)
			isIEWin50 = true;
		else
			isIEWin55plus = true;
	}
}

UADetect();

var slider;
var target;
var wrapper;
var posX;
var deltaX;
var delta;

var kMinXPos = 112;
var kMaxXPos = 300;

var kMinSliderValue = 60;
var kMaxSliderValue = 200;
var kSliderIncrements = 20;

function initImageInsert() {
	document.body.ondrag = function () { return false; };
	document.body.onselectstart = function () { return false; };
	console = document.getElementById("console");
	slider = document.getElementById("slider");
	image = document.getElementById("file");
	wrapper = document.getElementById("wrapper");
	
	var imgWidth = image.getAttribute("wpWidth");
	var imgHeight = image.getAttribute("wpHeight");
	if ( imgWidth < kMaxSliderValue )
        kMaxSliderValue = imgWidth;
    if ( imgWidth < kMinSliderValue )
        kMinSliderValue = imgWidth;
	
	updateImageDim(image, dimensionsForMaximumSize(image, (kMaxSliderValue - kMinSliderValue)/2.0 + kMinSliderValue));
	
	addEventListeners(slider,"mousedown",slideDownHandle);
}

function setAlignment(align) {
    var imgElem = document.getElementById('file');
    imgElem.style.cssFloat = align;
    imgElem.style.styleFloat = align;
}

function dimensionsForMaximumSize(image, maxValue)
{
    var scaleFactor;
    var nativeWidth = image.getAttribute("wpWidth");
    var nativeHeight = image.getAttribute("wpHeight");
    
    if ( nativeWidth < maxValue && nativeHeight < maxValue )
        return {width: nativeWidth, height: nativeHeight};
        
    if ( nativeWidth > nativeHeight )
    {
        scaleFactor = maxValue / nativeWidth;
    }
    else
    {
        scaleFactor = maxValue / nativeHeight;
    }

    //alert("image: " + image + ", wpWidth: " + nativeWidth + ", wpHeight: " + nativeHeight);
    return {width: Math.floor(scaleFactor * nativeWidth), height: Math.floor(scaleFactor * nativeHeight)};
}

function valueForSliderPos(position) {
    return (position / (kMaxXPos - kMinXPos)) * (kMaxSliderValue - kMinSliderValue) + kMinSliderValue;
}

function updateImageDim(imgElem, dim)
{
    var thumbSize = document.getElementById('thumbSizeValue');
    var imgName = document.getElementById('imgName').value;
    
    var wrapperWidth = parseInt(wrapper.style.width);
    var wrapperHeight = parseInt(wrapper.style.height);
    
    var imgX = Math.floor(wrapperWidth / 2.0 - dim.width / 2.0);
    var imgY = Math.floor(wrapperHeight / 2.0 - dim.height / 2.0);
    
    imgElem.style.left = imgX + "px";
    imgElem.style.top = imgY + "px";
    imgElem.style.width = dim.width + "px";
    imgElem.style.height = dim.height + "px";
    
    //alert("set new image size: " + imgX + ", " + imgY + ", " + dim.width + ", " + dim.height);
    
	thumbSize.innerHTML = dim.width + "px";
}

function insertRadioSelect(control,event)
{
    //alert("insertRadioSelect: " + control.value);
    if ( control.value == "Original" ) {
        document.getElementById('wrapper').style.display = "none";
        document.getElementById('userControls').style.display = "none";
    }
    else {
        document.getElementById('wrapper').style.display = "block";
        document.getElementById('userControls').style.display = "block";
    }
}

function doInsertImage(localizedImageTag)
{
    var imgElem = document.getElementById('file');
    var insertFullSize = document.getElementById('insertFullSize');
    var insertThumbnail = document.getElementById('insertThumbnail');
    var thumbSizeValue = document.getElementById('thumbSizeValue');
    var imgName = document.getElementById('imgName').value;
    var caption = document.getElementById('captionText').value;
    var align = "";
    var insertText = "";
    
    if ( caption && caption.length > 0 )
        caption = "|" + caption;  
    
    if ( insertFullSize.checked && !insertThumbnail.checked ) {
        insertText = caption + ']]';
    }
    else if ( !insertFullSize.checked && insertThumbnail.checked )
    {     
        if ( imgElem.style.cssFloat )
            align = "|" + imgElem.style.cssFloat;
        else if ( imgElem.style.styleFloat )
            align = "|" + imgElem.style.styleFloat;
        
        insertText = align + '|thumb|' + thumbSizeValue.innerHTML + caption +  ']]';
    }
    else
        alert("error with radios!");
            
    if ( window.opener ) {
        window.opener.document.insertTags('[[' + localizedImageTag + ':', insertText, imgName);
        window.close();
    }
}

function slideDownHandle(evt) {
    var imgElem = document.getElementById('file');

 	evt = getEvent(evt);
 	target = getTarget(evt);
	target.src = gid("imgPath").value + "slider_thumb_bg_on.png";

	posX = getPos('X',evt);
	deltaX = posX - parseInt(target.style.left);
	addEventListeners(document,"mousemove",slideMoveHandle);
	addEventListeners(document,"mouseup",slideUpHandle);
	bubbleCancel(evt);

	function slideMoveHandle(evt) {
		evt = getEvent(evt);
		posX = getPos('X',evt);
		posX = posX - deltaX;
		posX = (posX < kMinXPos) ? kMinXPos : posX;
		posX = (posX > kMaxXPos) ? kMaxXPos: posX;
		target.style.left = posX + "px";
		delta = Math.abs(posX - kMinXPos);

		var sliderValue = valueForSliderPos(delta);
		var dim = dimensionsForMaximumSize(imgElem, sliderValue);

		//alert("dim for sliderValue: " + sliderValue + ", " + dim.width + ", " + dim.height);
		//imgElem.style.width = (delta/.5 + 16) + "px";
    	//imgElem.style.height = (delta/.5 + 16) + "px";

    	updateImageDim(imgElem, dim);
		bubbleCancel(evt);
	}

	function slideUpHandle(evt) {
		evt = getEvent(evt);
		target.src = gid("imgPath").value + "slider_thumb_bg.png";

		removeEventListeners(document,"mousemove",slideMoveHandle);
		removeEventListeners(document,"mouseup",slideUpHandle);		
		bubbleCancel(evt);
	}
}
