YAHOO.namespace("wikia.MiniUpload");

var image;
var imgWidth;
var imgHeight;
var wrapper;
var kMinSliderValue = 60;
var kMaxSliderValue = 200;
var kMinXPos = 112;
var kMaxXPos = 300;

(function() {

var Dom = YAHOO.util.Dom;
var Event = YAHOO.util.Event;
var DDM = YAHOO.util.DragDropMgr;

YAHOO.wikia.MiniUpload = {

	init: function() {

		if(window.opener == null) {
			document.body.style.display = 'none';
		}

		var slider = Dom.get("slider");
		if(slider) {
			image = Dom.get("imgThumbnail");
 			wrapper = Dom.get("wrapper");
			imgWidth = Dom.get("imgWidth").value;
			imgHeight = Dom.get("imgHeight").value;

			if(imgWidth < kMaxSliderValue) {
				kMaxSliderValue = imgWidth;
			}
			if(imgWidth < kMinSliderValue) {
				kMinSliderValue = imgWidth;
			}

			this.updateImageDim(image, this.dimensionsForMaximumSize(image, (kMaxSliderValue - kMinSliderValue)/2.0 + kMinSliderValue));

			Event.addListener(slider, 'mousedown', YAHOO.wikia.MiniUpload.slideDownHandle);
			Event.addListener(['insertFullSize','insertThumbnail'], 'click', YAHOO.wikia.MiniUpload.changeMode);
			Event.addListener(['alignLeft','alignRight'], 'click', YAHOO.wikia.MiniUpload.changeAlign);
			Event.addListener('insertimage', 'click', YAHOO.wikia.MiniUpload.insertImage);
		}

		Event.addListener(document, 'click', YAHOO.wikia.MiniUpload.documentClick);
	},

	documentClick: function(e) {

		var el = Event.getTarget(e);
		var href = null;

		if(el.nodeName == 'A') {
			href = el.href;
		}

		if(el.nodeName == 'IMG') {
			if(el.parentNode.nodeName == 'A') {
				href = el.parentNode.href;
			}
		}

		if(href != null) {
			window.opener.open(href);
			Event.preventDefault(e);
		}

	},

	insertImage: function() {
		var insertFullSize = Dom.get('insertFullSize');
		var insertThumbnail = Dom.get('insertThumbnail');
		var thumbSizeValue = Dom.get('thumbSizeValue');
	    var imgName = Dom.get('imgName').value;
		var caption = Dom.get('captionText').value;
		var align = "";
		var insertText = "";

	    if(caption && caption.length > 0) {
			caption = "|" + caption;
		}

		if(insertFullSize.checked && !insertThumbnail.checked) {
			insertText = caption + ']]';
		} else if(!insertFullSize.checked && insertThumbnail.checked) {
			if(image.style.cssFloat) {
				align = "|" + image.style.cssFloat;
			}
			else if(image.style.styleFloat) {
				align = "|" + image.style.styleFloat;
			}

			insertText = align + '|thumb|' + thumbSizeValue.innerHTML + caption +  ']]';
	    }

		if (window.opener) {
			window.opener.insertTags('[[' + Dom.get("imageLocalized").value + ':', insertText, imgName);
			window.close();
	    }
	},

	changeAlign: function(e) {
		target = Event.getTarget(e);
		align = (target.id == "alignLeft") ? "left" : "right";
		image.style.cssFloat = align;
		image.style.styleFloat = align;
	},

	changeMode: function(e) {
		target = Event.getTarget(e);

		if(target.id == "insertFullSize") {
			Dom.get('wrapper').style.display = "none";
			Dom.get('userControls').style.display = "none";
		}
		else {
			Dom.get('wrapper').style.display = "block";
			Dom.get('userControls').style.display = "block";
		}
	},

	slideDownHandle: function(evt) {
		Event.preventDefault(evt);
		evt = Event.getEvent(evt);
		target = Event.getTarget(evt);
//		target.src = "/skins/common/slider_thumb_bg_on.png";
		posXY = Event.getXY(evt);
		deltaX = posXY[0] - parseInt(target.style.left);

		Event.addListener(document, 'mousemove', YAHOO.wikia.MiniUpload.slideMoveHandle);
		Event.addListener(document, 'mouseup', YAHOO.wikia.MiniUpload.slideUpHandle);
	},

	slideMoveHandle: function(evt) {
		Event.preventDefault(evt);
		evt = Event.getEvent(evt);
		posXY = Event.getXY(evt);
		posX = posXY[0] - deltaX;
		posX = (posX < kMinXPos) ? kMinXPos : posX;
		posX = (posX > kMaxXPos) ? kMaxXPos: posX;

		target.style.left = posX + "px";
		delta = Math.abs(posX - kMinXPos);

		var sliderValue = YAHOO.wikia.MiniUpload.valueForSliderPos(delta);
		var dim =  YAHOO.wikia.MiniUpload.dimensionsForMaximumSize(image, sliderValue);
		YAHOO.wikia.MiniUpload.updateImageDim(image, dim);
	},

	slideUpHandle: function(evt) {
		Event.preventDefault(evt);
		evt = Event.getEvent(evt);
		target = Event.getTarget(evt);
//		target.src = "/skins/common/slider_thumb_bg.png";

		Event.removeListener(document, 'mousemove', YAHOO.wikia.MiniUpload.slideMoveHandle);
		Event.removeListener(document, 'mouseup', YAHOO.wikia.MiniUpload.slideUpHandle);
	},

	valueForSliderPos: function(position) {
		return (position / (kMaxXPos - kMinXPos)) * (kMaxSliderValue - kMinSliderValue) + kMinSliderValue;
	},

	updateImageDim: function(imgElem, dim) {
		var thumbSize = Dom.get('thumbSizeValue');
	    var imgName = Dom.get('imgName').value;

	    var wrapperWidth = parseInt(wrapper.style.width);
	    var wrapperHeight = parseInt(wrapper.style.height);

	    var imgX = Math.floor(wrapperWidth / 2.0 - dim.width / 2.0);
	    var imgY = Math.floor(wrapperHeight / 2.0 - dim.height / 2.0);

	    imgElem.style.left = imgX + "px";
	    imgElem.style.top = imgY + "px";
	    imgElem.style.width = dim.width + "px";
	    imgElem.style.height = dim.height + "px";

		thumbSize.innerHTML = dim.width + "px";
	},

	dimensionsForMaximumSize: function(image, maxValue) {
		var scaleFactor;
		var nativeWidth = imgWidth;
		var nativeHeight = imgHeight;

		if(nativeWidth < maxValue && nativeHeight < maxValue) {
			return {
				width: nativeWidth,
				height: nativeHeight
			};
		}

		if(nativeWidth > nativeHeight) {
			scaleFactor = maxValue / nativeWidth;
		}
		else {
			scaleFactor = maxValue / nativeHeight;
		}
	    return {
	    	width: Math.floor(scaleFactor * nativeWidth),
	    	height: Math.floor(scaleFactor * nativeHeight)
	    };
	}

}
Event.onDOMReady(YAHOO.wikia.MiniUpload.init, YAHOO.wikia.MiniUpload, true);
})();