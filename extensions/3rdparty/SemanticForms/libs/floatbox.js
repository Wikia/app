/***************************************************************************************************
* Floatbox v2.39
*
* Image and IFrame viewer by Byron McGregor
*	May 23, 2008
*   Website: http://randomous.com
* License: Creative Commons Attribution 3.0 License (http://creativecommons.org/licenses/by/3.0/)
* Credit: Derived from Lytebox v3.22, the original work of Markus F. Hay
*   Website: http://www.dolem.com/lytebox
*   Lytebox was originally derived from the Lightbox class (v2.02) that was written by Lokesh Dhakar
*   Website: http://huddletogether.com/projects/lightbox2/
****************************************************************************************************/

function Floatbox() {
this.defaultOptions = {

/***** BEGIN OPTIONS CONFIGURATION *****/
// see docs/options.html for detailed descriptions

/*** <General Options> ***/
'theme':          'white'  ,// 'black'|'white'|'blue'|'yellow'|'red'|'custom'
'padding':         12      ,// pixels
'panelPadding':    8       ,// pixels
'outerBorder':     4       ,// pixels
'innerBorder':     1       ,// pixels
'autoResize':      true    ,// true|false
'overlayOpacity':  25      ,// 0-100
'upperOpacity':    65      ,// 0-100
'showResize':      true    ,// true|false
'showCaption':     true    ,// true|false
'showItemNumber':  true    ,// true|false
'showClose':       true    ,// true|false
'hideFlash':       true    ,// true|false
'disableScroll':   false   ,// true|false
'enableCookies':   false   ,// true|false
'url404Image':    '/floatbox/images/404.jpg'  ,// change this if you install in another location
/*** </General Options> ***/

/*** <Navigation Options> ***/
'navType':            'both'  ,// 'upper'|'lower'|'both'|'none'
'upperNavWidth':       42     ,// 0-50
'upperNavPos':         20     ,// 0-100
'showUpperNav':       'once'  ,// 'always'|'once'|'never'
'showHints':          'once'  ,// 'always'|'once'|'never'
'enableKeyboardNav':   true   ,// true|false
'outsideClickCloses':  true   ,// true|false
/*** </Navigation Options> ***/

/*** <Animation Options> ***/
'resizeOrder':         'both'  ,// 'both'|'width'|'height'|'random'
'resizeDuration':       0    ,// 0-10
'imageFadeDuration':    0    ,// 0-10
'overlayFadeDuration':  0      ,// 0-10
/*** </Animation Options> ***/

/*** <Slideshow Options> ***/
'slideInterval':  4.1    ,// seconds
'endTask':       'exit'  ,// 'stop'|'exit'|'loop'
'showPlayPause':  true   ,// true|false
'startPaused':    false  ,// true|false
'pauseOnPrev':    true   ,// true|false
'pauseOnNext':    false  ,// true|false
/*** </Slideshow Options> ***/

/*** <String Localization> ***/
'strHintClose':    'exit (kbd: esc)'       ,
'strHintPrev':     'prev (kbd: lt.arrow)'  ,
'strHintNext':     'next (kbd: rt.arrow)'  ,
'strHintPlay':     'play (kbd: spacebar)'  ,
'strHintPause':    'pause (kbd: spacebar)' ,
'strHintResize':   'resize (kbd: tab)'     ,
'strImageCount':   'image %1 of %2'        ,
'strIframeCount':  'page %1 of %2'
/*** </String Localization> ***/

/***** END OPTIONS CONFIGURATION *****/
};
this.doc = top.document;
this.body = this.doc.body;
this.arrAnchors = new Array();
this.arrImageHrefs = new Array();
this.arrItems = new Array();
this.arrResize1 = new Array();
this.arrResize2 = new Array();
this.objTimeouts = new Object();
this.objImagePreloads = new Object();
this.lowerPanelSpace = 24;
this.resizeSpace = 6;
this.initialSize = 300;
var ie = !!document.all && !window.opera;
this.ie6 = ie && /*@cc_on @if(@_jscript_version < 5.7) ! @end @*/ false;
this.ieQuirks = ie && this.doc.compatMode == 'BackCompat';
this.operaQuirks = !!window.opera && this.doc.compatMode == 'BackCompat';
this.ff2 = /firefox\/[12]/i.test(navigator.userAgent);
this.ff3 = /firefox\/3/i.test(navigator.userAgent);
this.tagAnchors = function(doc) {
	var reIsFbxd = new RegExp('^(gallery|iframe|slideshow|lytebox|lyteshow|lyteframe|lightbox)', 'i');
	var reIsImg = new RegExp('\.(jpg|jpeg|png|gif|bmp)\s*$', 'i');
	var reAuto = new RegExp('autoStart\s*[:=]\s*true', 'i');
	var click = function () { fb.start(this); return false; };
	function tagAnchor(anchor) {
		var href = anchor.getAttribute('href') || '';
		var rel = anchor.getAttribute('rel') || '';
		var rev = anchor.getAttribute('rev') || '';
		if (reIsFbxd.test(rel)) {
			anchor.onclick = click;
			fb.arrAnchors.push(anchor);
			if (reIsImg.test(href)) fb.arrImageHrefs.push(href);
			if (reAuto.test(rev)) fb.autoStart = anchor;
		}
	};
	var anchors = doc.getElementsByTagName('a');
	for (var i = 0, len = anchors.length; i < len; i++) {
		tagAnchor(anchors[i]);
	}
	anchors = doc.getElementsByTagName('area');
	for (var i = 0, len = anchors.length; i < len; i++) {
		tagAnchor(anchors[i]);
	}
};
this.preloadNextImage = function(href) {
	if (!href && !this.blockPreloadChain) {
		for (var i = 0, len = this.arrImageHrefs.length; i < len; i++) {
			var h = this.arrImageHrefs[i];
			if (!this.objImagePreloads[h]) {
				var href = h;
				break;
			}
		}
	}
	if (href) {
		this.objImagePreloads[href] = new Image();
		this.objImagePreloads[href].onload = this.objImagePreloads[href].onerror =
			function() { fb.preloadNextImage() };
		this.objImagePreloads[href].src = href;
	}
};
this.setNode = function(nodeType, id, parentNode, title) {
	var node = this.doc.getElementById(id);
	if (!node) {
		node = this.doc.createElement(nodeType);
		if (id) node.id = id;
		if (nodeType == 'a') node.setAttribute('href', '#');
		if (title && this.showHints != 'never') node.setAttribute('title', title);
		if (nodeType == 'iframe') {
			node.setAttribute('scrolling', this.itemScrolling);
			node.setAttribute('frameBorder', '0');
			node.setAttribute('align', 'middle');
		}
		parentNode.appendChild(node);
	}
	node.className = id + '_' + this.theme;
	node.style.display = 'none';
	return node;
};
this.buildDOM = function() {
	this.fbOverlay		= this.setNode('div', 'fbOverlay', this.body);
	this.fbFloatbox		= this.setNode('div', 'fbFloatbox', this.body);
	this.fbLoader		= this.setNode('div', 'fbLoader', this.fbFloatbox);
	this.fbContentPanel	= this.setNode('div', 'fbContentPanel', this.fbFloatbox);
	if (this.upperNav) {
		this.fbLeftNav		= this.setNode('a', 'fbLeftNav', this.fbContentPanel);
		this.fbRightNav		= this.setNode('a', 'fbRightNav', this.fbContentPanel);
		this.fbUpperPrev	= this.setNode('a', 'fbUpperPrev', this.fbContentPanel, this.strHintPrev);
		this.fbUpperNext	= this.setNode('a', 'fbUpperNext', this.fbContentPanel, this.strHintNext);
	}
	this.fbResize		= this.setNode('a', 'fbResize', this.fbContentPanel, this.strHintResize);
	this.fbInfoPanel	= this.setNode('div', 'fbInfoPanel', this.fbContentPanel);
	this.fbCaption		= this.setNode('span', 'fbCaption', this.fbInfoPanel);
	this.fbItemNumber	= this.setNode('span', 'fbItemNumber', this.fbInfoPanel);
	this.fbControlPanel	= this.setNode('div', 'fbControlPanel', this.fbContentPanel);
	this.fbLowerNav		= this.setNode('div', 'fbLowerNav', this.fbControlPanel);
	this.fbLowerPrev	= this.setNode('a', 'fbLowerPrev', this.fbLowerNav, this.strHintPrev);
	this.fbLowerNext	= this.setNode('a', 'fbLowerNext', this.fbLowerNav, this.strHintNext);
	this.fbControls		= this.setNode('div', 'fbControls', this.fbControlPanel);
	this.fbClose		= this.setNode('a', 'fbClose', this.fbControls, this.strHintClose);
	this.fbPlayPause	= this.setNode('div', 'fbPlayPause', this.fbControls);
	this.fbPlay			= this.setNode('a', 'fbPlay', this.fbPlayPause, this.strHintPlay);
	this.fbPause		= this.setNode('a', 'fbPause', this.fbPlayPause, this.strHintPause);
};
this.parseOptionString = function(str) {
	if (!str) return {};
	var pairs = new Object();
	str = str.replace(/\s*[:=]\s*/g, ':');
	str = str.replace(/\s*[;&]\s*/g, ' ');
	str = str.replace(/^\s+|\s+$/g, '');
	var aVars = str.split(/\s+/);
	var i = aVars.length;  while (i--) {
		var aThisVar = aVars[i].split(':');
		pairs[aThisVar[0]] = aThisVar[1].toLowerCase();
	}
	return pairs;
};
this.setOptions = function(pairs) {
	for (var name in pairs) {
		var value = pairs[name];
		if (typeof(value) == 'string') {
			if (name.indexOf('str') != 0) value = value.toLowerCase();
			if (isNaN(value)) {
				if (value == 'true') {
					this[name] = true;
				} else if (value == 'false') {
					this[name] = false;
				} else if (value) {
					this[name] = value;
				}
			} else {
				this[name] = +value;
			}
		} else {
			this[name] = value;
		}
	}
};
this.start = function(anchor) {
	this.itemCount = this.arrItems.length = this.itemsShown = this.resizeCounter = 0;
	this.currentItem = -1;
	var href = anchor.getAttribute('href') || '';
	var rel = anchor.getAttribute('rel') || '';
	var rev = anchor.getAttribute('rev') || '';
	this.isIframe = /^(iframe|lyteframe)/i.test(rel);
	if (!this.isIframe) {
		this.blockPreloadChain = true;
		this.preloadNextImage(href);
	}
	if (/^(gallery|iframe|lytebox|lyteframe|lightbox)$/i.test(rel)) {
		if (href && rev.indexOf('showThis:false') == -1) {
			this.arrItems.push( {'href': href, 'title': anchor.getAttribute('title'), 'rev': rev, 'seen': false} );
		}
	} else {
		for (var i = 0, len = this.arrAnchors.length; i < len; i++) {
			var href_i = this.arrAnchors[i].getAttribute('href') || '';
			var rev_i = this.arrAnchors[i].getAttribute('rev') || '';
			if (this.arrAnchors[i].getAttribute('rel') == rel) {
				if (href_i && rev_i.indexOf('showThis:false') == -1) {
					this.arrItems.push( {
						'href': this.arrAnchors[i].getAttribute('href'),
						'title': this.arrAnchors[i].getAttribute('title') || '',
						'rev': rev_i, 'seen': false
					} );
				}
			}
		}
	}
	this.itemCount = this.arrItems.length;
	this.modal = this.doSlideshow = this.loadPageOnClose = false;
	this.setOptions(this.defaultOptions);
	if (typeof(top.setFloatboxOptions) == 'function') top.setFloatboxOptions();
	if (this.enableCookies) {
		var match = /fbOptions=(.+?)(;|$)/.exec(this.doc.cookie);
		if (match) this.setOptions(this.parseOptionString(match[1]));
		var strOptions = '';
		for (var name in this.defaultOptions) {
			if (name.indexOf('str') != 0) strOptions += ' ' + name + ':' + this[name];
		}
		var tlp = top.location.pathname;
		this.doc.cookie = 'fbOptions=' + strOptions + '; path=' + tlp.substring(0, tlp.lastIndexOf('/') + 1);
	}
	this.setOptions(this.parseOptionString(rev));
	this.setOptions(this.parseOptionString(window.location.search.substring(1)));
	if (this.endTask == 'cont') this.endTask = 'loop';
	if (this.theme == 'grey') this.theme = 'white';
	if (!/^(black|white|blue|yellow|red|custom)$/.test(this.theme)) this.theme='black';
	this.isSlideshow = this.itemCount > 1 && (/^(slideshow|lyteshow)/i.test(rel) || this.doSlideshow);
	this.isPaused = this.startPaused;
	if (this.isIframe) {
		this.autoResize = this.showResize = false;
		if (this.ff2) this.disableScroll = true;
	}
	if (this.modal && (this.isSlideshow || this.isIframe)) {
		this.navType = 'none';
		this.showClose = false;
		this.showPlayPause = false;
		this.enableKeyboardNav = false;
		this.outsideClickCloses = false;
		this.showHints = 'never';
	}
	if (!/^(upper|lower|both|none)$/i.test(this.navType)) this.navType = 'both';
	if (this.itemCount <= 1) {
		this.navType = 'none';
		this.showItemNumber = false;
	} else if (this.isIframe && /upper|both/i.test(this.navType)) {
		this.navType = 'lower';
	}
	this.upperNav = /upper|both/i.test(this.navType);
	this.lowerNav = /lower|both/i.test(this.navType);
	if (this.upperNav) {
		if (this.upperNavWidth < 0) this.upperNavWidth = 0;
		if (this.upperNavWidth > 50) this.upperNavWidth = 50;
	}
	if (this.showHints == 'once') {
		this.hideHint = function(id) {
			if (this[id].title) this.objTimeouts[id] = setTimeout(function() { fb[id].title = ''; }, 1600);
		};
	} else {
		this.hideHint = function() { return; };
	}
	this.buildDOM();
	this.fbResize.onclick = function() { fb.scaleItem = this.scaleItem; fb.loadItem(fb.currentItem); return false; };
	this.fbPlay.onclick = function() { fb.setPause(false); return false; };
	this.fbPause.onclick = function() { fb.setPause(true); return false; };
	this.fbClose.onclick = function() { fb.end(); return false; };
	if (this.outsideClickCloses) this.fbOverlay.onclick = function() { fb.end(); return false; };
	this.fbLowerPrev.onclick = function() {
		fb.loadItem((fb.currentItem == 0)? fb.itemCount - 1 : fb.currentItem - 1);
		if (fb.isSlideshow  && fb.pauseOnPrev && !fb.isPaused && fb.showPlayPause) {
			fb.setPause(true);
		}
		return false;
	};
	this.fbLowerNext.onclick = function() {
		fb.loadItem((fb.currentItem == fb.itemCount - 1)? 0 : fb.currentItem + 1);
		if (fb.isSlideshow && fb.pauseOnNext && !fb.isPaused && fb.showPlayPause) {
			fb.setPause(true);
		}
		return false;
	};
	if (this.upperNav) {
		this.fbLeftNav.onclick = this.fbUpperPrev.onclick = this.fbLowerPrev.onclick;
		this.fbRightNav.onclick = this.fbUpperNext.onclick = this.fbLowerNext.onclick;
		this.fbLeftNav.onmouseover = this.fbLeftNav.onmousemove =
		this.fbUpperPrev.onmousemove = function() {
			if (!fb.objTimeouts.fbContentPanel) fb.fbUpperPrev.style.visibility = 'visible';
			if (fb.lowerNav && !fb.showUpperNav) fb.fbLowerPrev.style.backgroundPosition = 'bottom';
			return true;
		};
		this.fbRightNav.onmouseover = this.fbRightNav.onmousemove =
		this.fbUpperNext.onmousemove = function() {
			if (!fb.objTimeouts.fbContentPanel) fb.fbUpperNext.style.visibility = 'visible';
			if (fb.lowerNav && !fb.showUpperNav) fb.fbLowerNext.style.backgroundPosition = 'bottom';
			return true;
		};
		this.fbUpperPrev.onmouseover = this.fbUpperNext.onmouseover = function() {
			this.onmousemove();
			fb.hideHint(this.id);
			return true;
		};
		this.fbLeftNav.onmouseout = function() {
			fb.fbUpperPrev.style.visibility = 'hidden';
			if (fb.lowerNav) fb.fbLowerPrev.style.backgroundPosition = 'top';
		};
		this.fbRightNav.onmouseout = function() {
			fb.fbUpperNext.style.visibility = 'hidden';
			if (fb.lowerNav) fb.fbLowerNext.style.backgroundPosition = 'top';
		};
		this.fbUpperPrev.onmouseout = this.fbUpperNext.onmouseout = function() {
			this.style.visibility = 'hidden';
			fb.clearTimeout(this.id);
		};
		this.fbLeftNav.onmouseup = this.fbRightNav.onmouseup = function(evt) {
			var e = evt || window.event;
			if (e.button == 2) {
				fb.fbLeftNav.style.display = fb.fbRightNav.style.display = 'none';
				setTimeout(function() { fb.fbLeftNav.style.display = fb.fbRightNav.style.display = ''; }, 10);
			}
		};
	}
/*
	this.fbPlay.onmouseover = this.fbPause.onmouseover =
	this.fbClose.onmouseover = this.fbLowerPrev.onmouseover =
	this.fbLowerNext.onmouseover = this.fbResize.onmouseover = function() {
		if (this.id != 'fbResize') this.style.backgroundPosition = 'bottom';
		fb.hideHint(this.id);
		return true;
	};
	this.fbPlay.onmouseout = this.fbPause.onmouseout =
	this.fbClose.onmouseout = this.fbLowerPrev.onmouseout =
	this.fbLowerNext.onmouseout = this.fbResize.onmouseout = function() {
		if (this.id != 'fbResize') this.style.backgroundPosition = 'top';
		fb.clearTimeout(this.id);
	};
*/
	if (this.enableKeyboardNav) {
		this.priorOnkeydown = document.onkeydown;
		document.onkeydown = this.keyboardAction;
	}
	if (window.opera) {
		this.priorOnkeypress = document.onkeypress;
		document.onkeypress = function() { return false; };
	}
	if (this.ie6 || this.ieQuirks) {
		this.setVisibility('select', 'hidden');
		this.fbOverlay.style.position = 'absolute';
		top.attachEvent('onresize', fb.stretchOverlay);
		top.attachEvent('onscroll', fb.stretchOverlay);
	}
	if (this.ie6 && this.isIframe) this.innerBorder = 0;
	if (this.hideFlash) {
		this.setVisibility('object', 'hidden');
		this.setVisibility('embed', 'hidden');
	}
	var callback = function() {
		setTimeout(function() { fb.turnOn(href); }, 20);
	};
	this.fade(this.fbOverlay, 10, this.overlayOpacity, callback);
};
this.turnOn = function(href) {
	this.fbFloatbox.style.position = 'absolute';
	this.fbFloatbox.style.width = this.fbFloatbox.style.height = this.fbFloatbox.style.borderWidth = '0';
	this.fbFloatbox.style.left = (this.getDisplayWidth() / 2 + this.getXScroll()) + 'px';
	this.fbFloatbox.style.top = (this.getDisplayHeight() / 3 + this.getYScroll()) + 'px';
	this.fbFloatbox.style.display = this.fbContentPanel.style.display = this.fbLoader.style.display = '';
	if (this.upperNav) {
		this.fbLeftNav.style.display = this.fbRightNav.style.display = '';
		this.fbLeftNav.style.top = this.fbRightNav.style.top =
		this.fbLeftNav.style.left = this.fbRightNav.style.right =
		this.fbUpperPrev.style.left = this.fbUpperNext.style.right =
			(this.padding + this.innerBorder) + 'px';
		if (this.showUpperNav == 'never' || (this.showUpperNav == 'once' && this.upperNavShown)) {
			this.showUpperNav = false;
		} else {
			this.fade(this.fbUpperPrev, this.upperOpacity);
			this.fade(this.fbUpperNext, this.upperOpacity);
		}
	}
	if (this.lowerNav) {
		this.fbLowerNav.style.display = this.fbLowerPrev.style.display = this.fbLowerNext.style.display = '';
	}
	this.fbResize.style.left = this.fbResize.style.top = (this.padding + this.innerBorder) + 'px';
	if (!this.isSlideshow) this.showPlayPause = false;
	if (this.showClose || this.showPlayPause || this.lowerNav) {
		this.fbControlPanel.style.display = '';
		this.fbControlPanel.style.right = Math.max(this.padding, 8) + 'px';
	}
    var controlsWidth = 0;
	if (this.showClose) {
		this.fbControls.style.display = '';
		this.fbClose.style.display = '';
		controlsWidth = this.fbClose.offsetWidth;
	}
	if (this.showPlayPause) {
		this.fbControls.style.display = '';
		this.fbPlayPause.style.display = '';
		this[this.isPaused? 'fbPause' : 'fbPlay'].style.display = '';
		controlsWidth += this.fbPlayPause.offsetWidth;
	}
	this.fbControls.style.width = controlsWidth + 'px';
	this.fbControlPanel.style.width = (this.fbLowerNav.offsetWidth + this.fbControls.offsetWidth) + 'px';
	this.xFramework = 2*(this.outerBorder + this.innerBorder + this.padding);
	this.yFramework = this.xFramework - this.padding;
	for (i = this.itemCount - 1; i > 0; i--) if (this.arrItems[i].href == href) break;
	this.loadItem(i);
};
this.loadItem = function(newItem) {
	this.clearTimeout('slideshow');
	this.clearTimeout('resizeGroup');
	this.blockPreloadChain = true;
	self.focus();
	this.isFirstItem = (this.currentItem == -1);
	if (this.currentItem != newItem) {
		this.resizeActive = false;
		if (this.showUpperNav == 'once' && this.upperNavShown) this.showUpperNav = false;
		this.currentItem = newItem;
	}
	this.currentHref = this.arrItems[this.currentItem].href;
	if (this.displayWidth != (this.displayWidth = this.getDisplayWidth())) this.resizeActive = false;
	if (this.displayHeight != (this.displayHeight = this.getDisplayHeight())) this.resizeActive = false;
	this.fbContentPanel.style.visibility = 'hidden';
	this.fbResize.style.display = 'none';
	if (this.fbItem) {
		this.fbContentPanel.removeChild(this.fbItem);
		delete this.fbItem;
	};
	if (this.upperNav) {
		this.fbUpperPrev.style.visibility = this.fbUpperNext.style.visibility = 'hidden';
		this.fbLeftNav.style.height = this.fbRightNav.style.height = '0';
		if (!this.showUpperNav) this.fbUpperPrev.style.display = this.fbUpperNext.style.display = 'none';
	}
	if (this.fbFloatbox.style.position == 'fixed') {
		this.fbFloatbox.style.left = (this.fbFloatbox.offsetLeft + this.getXScroll()) + 'px';
		this.fbFloatbox.style.top = (this.fbFloatbox.offsetTop + this.getYScroll()) + 'px';
		this.fbFloatbox.style.position = 'absolute';
	}
	this.fbCaption.style.display = this.fbItemNumber.style.display = 'none';
	if (this.showCaption) {
		var sCaption = this.arrItems[this.currentItem].title || '';
		if (sCaption == 'href') sCaption = this.currentHref;
		this.fbCaption.innerHTML = sCaption;
		if (sCaption) this.fbCaption.style.display = '';
	}
	if (this.showItemNumber) {
		var sCount = this.isIframe? this.strIframeCount : this.strImageCount;
		sCount = sCount.replace('%1', this.currentItem + 1);
		sCount = sCount.replace('%2', this.itemCount);
		this.fbItemNumber.innerHTML = sCount;
		if (sCount) this.fbItemNumber.style.display = '';
	}
	if (this.isFirstItem) {
		this.objTimeouts.firstLoad = setTimeout(function() {
			fb.fbFloatbox.style.left = (fb.fbFloatbox.offsetLeft - fb.initialSize/2) + 'px';
			fb.fbFloatbox.style.top = (fb.fbFloatbox.offsetTop - fb.initialSize/3) + 'px';
			fb.fbFloatbox.style.width = fb.fbFloatbox.style.height = fb.initialSize + 'px';
			fb.fbFloatbox.style.borderWidth = fb.outerBorder + 'px';
		}, 500);
	} else {
		this.objTimeouts.loader = setTimeout(function() { fb.fbLoader.style.display = ''; }, 120);
	}
	if (this.isIframe) {
		setTimeout(function() { fb.setSize(); }, 20);
	} else {
		var loader = new Image();
		loader.onload = function() { fb.setSize(this.width, this.height); };
		loader.onerror = function() {
			fb.fbCaption.innerHTML = fb.currentHref.substring(fb.currentHref.lastIndexOf('/') + 1);
			fb.fbCaption.style.display = '';
			if (fb.currentHref != fb.url404Image) {
				this.src = fb.currentHref = fb.url404Image;
			} else {
				fb.setSize();
			}
		};
		loader.src = this.currentHref;
	}
};
this.setSize = function(imageWidth, imageHeight) {
	this.clearTimeout('firstLoad');
	if (typeof(this.panelHeight) == 'undefined') {
		if (!this.fbCaption.style.display || !this.fbItemNumber.style.display || !this.fbControlPanel.style.display || this.lowerNav) {
			this.panelHeight = 15 + 2*this.panelPadding;
			if (!this.fbCaption.style.display && this.showItemNumber) this.panelHeight += 15;
		} else {
			this.panelHeight = this.padding;
		}
	}
	var maxWidth = this.displayWidth - this.xFramework - 2*this.resizeSpace;
	var maxHeight = this.displayHeight - this.yFramework - this.panelHeight - 2*this.resizeSpace;
	var width = 0, height = 0;
	this.itemScrolling = 'auto';
	var options = this.parseOptionString(this.arrItems[this.currentItem].rev);
	if (options.width) width = (options.width == 'max')? maxWidth : parseInt(options.width);
	if (options.height) height = (options.height == 'max')? maxHeight : parseInt(options.height);
	if (options.scrolling) {
		if (this.isIframe && /yes|no/i.test(options.scrolling)) this.itemScrolling = options.scrolling;
	}
	width = width || imageWidth || 500;
	height = height || imageHeight || 300;
	this.nativeWidth = width;
	this.nativeHeight = height;
	if (typeof(this.scaleItem) == 'undefined') this.scaleItem = this.autoResize;
	if (this.scaleItem) {
		var scale = Math.min(maxWidth / width, maxHeight / height);
		if (scale < 1) {
			width = Math.round(width * scale);
			height = Math.round(height * scale);
		}
	}
	if (this.isFirstItem) this.fbFloatbox.style.borderWidth = this.outerBorder + 'px';
	if (this.upperNav && this.showUpperNav) {
		this.fbUpperPrev.style.top = this.fbUpperNext.style.top =
			(height * this.upperNavPos/100 + this.padding + this.innerBorder) + 'px';
	}
	this.newWidth = width + this.xFramework;
	this.infoPanelHeight = 0;
	this.fbInfoPanel.style.display = this.fbControlPanel.style.display = '';
	if (!this.fbCaption.style.display || !this.fbItemNumber.style.display) {
		var ipWidth = this.newWidth - 2*(this.outerBorder + Math.max(this.padding, 8)) - this.lowerPanelSpace - this.fbControlPanel.offsetWidth;
		if (ipWidth > 80) {
			this.fbInfoPanel.style.width = ipWidth + 'px';
			this.fbInfoPanel.style.left = '-9999px';
			this.infoPanelHeight = this.fbInfoPanel.offsetHeight;
		}
	}
	this.panelHeight = Math.max(this.infoPanelHeight, this.fbControlPanel.offsetHeight);
	this.fbInfoPanel.style.display = this.fbControlPanel.style.display = 'none';
	if (this.panelHeight) this.panelHeight += 2*this.panelPadding;
	this.panelHeight = Math.max(this.panelHeight, this.padding);
	this.newHeight = this.yFramework + height + this.panelHeight;
	if ((this.scaleItem || height == maxHeight) && this.newHeight > this.displayHeight) {
		if (this.resizeCounter++ < 3) {
			return this.loadItem(this.currentItem);
		}
	}
	var freeSpace = this.displayWidth - this.newWidth;
	var newLeft = (freeSpace <= 0)? 0 : Math.floor(freeSpace/2);
	var freeSpace = this.displayHeight - this.newHeight;
	var ratio = freeSpace / this.displayHeight;
	if (ratio <= .15) {
		var factor = 2;
	} else if (ratio >= .3) {
		var factor = 3;
	} else {
		var factor = 2 + (ratio - .15)/.15;
	}
	var newTop = (freeSpace <= 0)? 0 : Math.floor(freeSpace/factor);
	if (this.getXScroll() || this.getYScroll()) {
		this.fbFloatbox.style.display = 'none';
		if (this.ie6 || this.ieQuirks) this.stretchOverlay();
		newLeft += this.getXScroll();
		newTop += this.getYScroll();
		this.fbFloatbox.style.display = '';
	}
	this.itemWidth = width;
	this.itemHeight = height;
	var oldLeft = this.fbFloatbox.offsetLeft, oldTop = this.fbFloatbox.offsetTop;
	var oldWidth = this.fbFloatbox.offsetWidth, oldHeight = this.fbFloatbox.offsetHeight;
	this.arrResize1.length = this.arrResize2.length = 0;
	if (oldLeft != newLeft)
		var resizeL = [this.fbFloatbox, 'left', oldLeft, newLeft];
	if (oldTop != newTop)
		var resizeT = [this.fbFloatbox, 'top', oldTop, newTop];
	var borderAdjust = this.ieQuirks? 0 : 2*this.outerBorder;
	if (oldWidth != this.newWidth)
		var resizeW = [this.fbFloatbox, 'width', oldWidth - borderAdjust, this.newWidth - borderAdjust];
	if (oldHeight != this.newHeight)
		var resizeH = [this.fbFloatbox, 'height', oldHeight - borderAdjust, this.newHeight - borderAdjust];
	switch ((this.resizeOrder == 'random')? Math.floor(Math.random()*3) : this.resizeOrder) {
		case 'width': case 1:
			if (resizeL) this.arrResize1.push(resizeL);
			if (resizeW) this.arrResize1.push(resizeW);
			if (resizeT) this.arrResize2.push(resizeT);
			if (resizeH) this.arrResize2.push(resizeH);
			break;
		case 'height': case 2:
			if (resizeL) this.arrResize2.push(resizeL);
			if (resizeW) this.arrResize2.push(resizeW);
			if (resizeT) this.arrResize1.push(resizeT);
			if (resizeH) this.arrResize1.push(resizeH);
			break;
		default:
			if (resizeL) this.arrResize1.push(resizeL);
			if (resizeW) this.arrResize1.push(resizeW);
			if (resizeT) this.arrResize1.push(resizeT);
			if (resizeH) this.arrResize1.push(resizeH);
	}
	this.fbInfoPanel.style.left = Math.max(this.padding, 8) + 'px';
	this.resizeGroup(this.arrResize1, function() {
		fb.resizeGroup(fb.arrResize2, function() { fb.showContent(); })
	});
};
this.showContent = function() {
	this.clearTimeout('loader');
	var vscrollChanged = (this.displayWidth != (this.displayWidth = this.getDisplayWidth()));
	var hscrollChanged = (this.displayHeight != (this.displayHeight = this.getDisplayHeight()));
	if (this.resizeCounter++ < 4) {
		var tolerance = 25 + 2*this.resizeSpace;
		if ((vscrollChanged && Math.abs(this.newWidth - this.displayWidth) < tolerance)
		||  (hscrollChanged && Math.abs(this.newHeight - this.displayHeight) < tolerance))
			return this.loadItem(this.currentItem);
	}
	this.resizeCounter = 0;
	if (this.ie6 || this.ieQuirks) this.stretchOverlay();
	if (this.disableScroll && !(this.ie6 || this.ieQuirks || this.operaQuirks)) {
		if (this.newWidth <= this.displayWidth && this.newHeight <= this.displayHeight) {
			this.fbFloatbox.style.position = 'fixed';
			this.fbFloatbox.style.left = (this.fbFloatbox.offsetLeft - this.getXScroll()) + 'px';
			this.fbFloatbox.style.top = (this.fbFloatbox.offsetTop - this.getYScroll()) + 'px';
		}
	}
	this.fbItem = this.setNode((this.isIframe? 'iframe' : 'img'), 'fbItem', this.fbContentPanel);
	this.fbItem.width = this.itemWidth;
	this.fbItem.height = this.itemHeight;
	this.fbItem.src = this.currentHref;
	this.fbItem.style.left = this.fbItem.style.top = this.padding + 'px';
	this.fbItem.style.borderWidth = this.innerBorder + 'px';
	if (this.upperNav) {
		this.fbLeftNav.style.width = this.fbRightNav.style.width = Math.max(this.upperNavWidth/100 * this.itemWidth, this.fbUpperPrev.offsetWidth) + 'px';
		this.fbLeftNav.style.height = this.fbRightNav.style.height = this.itemHeight + 'px';
	}
	var panelTop = this.itemHeight + 2*this.innerBorder + this.padding;
	if (this.infoPanelHeight) {
		this.fbInfoPanel.style.display = '';
		this.fbInfoPanel.style.top = (panelTop + (this.panelHeight - this.fbInfoPanel.offsetHeight) / 2) + 'px';
	}
	if (this.showClose || this.showPlayPause || this.lowerNav) {
		this.fbControlPanel.style.display = '';
		this.fbControlPanel.style.top = (panelTop + (this.panelHeight - this.fbControlPanel.offsetHeight) / 2) + 'px';
	}
	if (this.isFirstItem && this.showPlayPause) {
		this.fbPlay.style.display = this.isPaused? '' : 'none';
		this.fbPause.style.display = this.isPaused? 'none' : '';
	}
	delete this.panelHeight;
	delete this.scaleItem;
	if (this.showResize) {
		if (this.resizeActive) {
			this.fbResize.scaleItem = !this.fbResize.scaleItem;
		} else {
			var xtra = this.outerBorder;
			if (this.newWidth - xtra - this.padding > this.displayWidth
			|| this.newHeight - xtra - this.panelPadding > this.displayHeight) {
				this.fbResize.scaleItem = true;
				this.resizeActive = true;
			} else {
				xtra += this.resizeSpace;
				if (this.itemWidth < this.nativeWidth - xtra - this.padding
				|| this.itemHeight < this.nativeHeight - xtra - this.panelPadding) {
					this.fbResize.scaleItem = false;
					this.resizeActive = true;
				}
			}
		}
		if (this.resizeActive) {
			this.fbResize.style.backgroundPosition = this.fbResize.scaleItem? 'bottom' : 'top';
			this.fade(this.fbResize, this.upperOpacity);
		}
	}
	this.fade(this.fbContentPanel, 10, 100);
	this.fbLoader.style.display = 'none';
	this.fbItem.style.display = '';
	if (window.opera && this.isIframe) {
		var src = this.fbItem.src;
		this.fbItem.src = '';
		setTimeout(function() { fb.fbItem.src = src; }, 10);
	}
	if (!this.arrItems[this.currentItem].seen) {
		this.arrItems[this.currentItem].seen = true;
		this.itemsShown++;
	}
	this.nextItem = (this.currentItem < this.itemCount - 1)? this.currentItem + 1 : 0;
	this.prevItem = this.currentItem? this.currentItem - 1 : this.itemCount - 1;
	if (this.lowerNav) {
		if (window.opera || this.ff3) {
			this.fbLowerPrev.href = this.fbLowerNext.href = this.currentHref;
		} else {
			this.fbLowerPrev.href = this.arrItems[this.prevItem].href;
			this.fbLowerNext.href = this.arrItems[this.nextItem].href;
		}
	}
	if (this.upperNav) {
		if (window.opera || this.ff3) {
			this.fbLeftNav.href = this.fbUpperPrev.href =
			this.fbRightNav.href = this.fbUpperNext.href = this.currentHref;
		} else {
			this.fbLeftNav.href = this.fbUpperPrev.href = this.arrItems[this.prevItem].href;
			this.fbRightNav.href = this.fbUpperNext.href = this.arrItems[this.nextItem].href;
		}
		this.upperNavShown = true;
	}
	this.blockPreloadChain = false;
	this.preloadNextImage(this.isIframe? '' : this.arrItems[this.nextItem].href);
	if (this.isSlideshow && !this.isPaused) {
		if (this.endTask == 'loop' || this.itemsShown < this.itemCount) {
			this.objTimeouts.slideshow = setTimeout(function() { fb.loadItem(fb.nextItem); }, this.slideInterval*1000);
		} else if (this.endTask == 'exit')  {
			this.objTimeouts.slideshow = setTimeout(function() { fb.end(); }, this.slideInterval*1000);
		} else {
			this.objTimeouts.slideshow = setTimeout(function() { fb.setPause(true); }, this.slideInterval*1000);
			var i = this.itemCount;
			while (i--) this.arrItems[i].seen = false;
			this.itemsShown = 0;
		}
	}
};
this.end = function() {
	for (var key in this.objTimeouts) {
		this.clearTimeout(key);
	}
	if (this.enableKeyboardNav) {
		document.onkeydown = this.priorOnkeydown;
	}
	if (window.opera) document.onkeypress = this.priorOnkeypress;
	this.fbOverlay.onclick = null;
	this.fbFloatbox.style.display = 'none';
	if (this.ie6 || this.ieQuirks) {
		top.detachEvent('onresize', fb.stretchOverlay);
		top.detachEvent('onscroll', fb.stretchOverlay);
	}
	var callBack = function() {
		fb.fbOverlay.style.display = 'none';
		if (fb.hideFlash) {
			fb.setVisibility('object', '');
			fb.setVisibility('embed', '');
		}
		if (fb.ie6 || fb.ieQuirks) fb.setVisibility('select', '');
	};
	this.fade(this.fbOverlay, this.overlayOpacity, 0, callBack);
	function remove(el) { el.parentNode.removeChild(el); };
	if (this.upperNav) {
		remove(this.fbUpperPrev); delete this.fbUpperPrev;
		remove(this.fbUpperNext); delete this.fbUpperPrev;
		remove(this.fbLeftNav); delete this.fbLeftNav;
		remove(this.fbRightNav); delete this.fbRightNav;
	}
	if (this.fbItem) { remove(this.fbItem); delete this.fbItem; }
	remove(this.fbCaption); delete this.fbCaption;
	remove(this.fbItemNumber); delete this.fbItemNumber;
	remove(this.fbInfoPanel); delete this.fbInfoPanel;
	if (this.loadPageOnClose) {
		if (this.loadPageOnClose == 'this') {
			location.reload(true);
		} else if (this.loadPageOnClose == 'back') {
			history.back();
		} else {
			location.replace(this.loadPageOnClose);
		}
	}
};
this.keyboardAction = function(evt) {
	var e = evt || window.event;
	var keyCode = e.which || e.keyCode;
	switch (keyCode) {
		case 37: case 39:
			if (fb.itemCount > 1) {
				(keyCode == 37)? fb.fbLowerPrev.onclick() : fb.fbLowerNext.onclick();
				if (fb.showHints == 'once') {
					fb.fbLowerPrev.title = fb.fbLowerNext.title = '';
					if (fb.upperNav) fb.fbUpperPrev.title = fb.fbUpperNext.title = '';
				}
			}
			return false;
		case 32:
			if (fb.isSlideshow) {
				fb.setPause(!fb.isPaused);
				if (fb.showHints == 'once') fb.fbPlay.title = fb.fbPause.title = '';
			}
			return false;
		case 9:
			if (fb.resizeActive) {
				fb.fbResize.onclick();
				if (fb.showHints == 'once') fb.fbResize.title = '';
			}
			return false;
		case 27:
			if (fb.showHints == 'once') fb.fbClose.title = '';
			fb.end();
			return false;
		case 13:
			return false;
	}
};
this.setPause = function(bPause) {
	this.isPaused = bPause;
	if (bPause) {
		this.clearTimeout('slideshow');
	} else {
		this.loadItem(this.nextItem);
	}
	if (this.showPlayPause) {
		this.fbPlay.style.display = bPause? '' : 'none';
		this.fbPause.style.display = bPause? 'none' : '';
	}
};
this.fade = function(obj, startOp, finishOp, funcOnComplete) {
	if (!funcOnComplete) var funcOnComplete = function() { return; };
	this.clearTimeout(obj.id);
	if (typeof(finishOp) == 'undefined') finishOp = startOp;
	var fadeIn = (startOp <= finishOp && finishOp > 0);
	var duration = (obj.id == 'fbOverlay')? this.overlayFadeDuration : this.imageFadeDuration;
	if (duration > 10) duration = 10;
	if (duration < 0) duration = 0;
	if (duration == 0) {
		startOp = finishOp;
		var incr = 100;
	} else {
		var root = Math.pow(100, .1);
		var power = duration + ((10 - duration)/9) * (Math.log(2)/Math.log(root) - 1);
		var incr = Math.round(100/Math.pow(root, power));
	}
	if (!fadeIn) incr = -incr;
	this.setOpacity(obj, startOp, finishOp, incr, fadeIn, funcOnComplete);
	if (fadeIn) {
		obj.style.display = '';
		obj.style.visibility = 'visible';
	}
};
this.setOpacity = function(obj, thisOp, finishOp, incr, fadeIn, funcOnComplete) {
	if (funcOnComplete) arguments.callee.oncomplete = funcOnComplete;
	if ((fadeIn && thisOp >= finishOp) || (!fadeIn && thisOp <= finishOp)) thisOp = finishOp;
	obj.style.opacity = obj.style.MozOpacity = obj.style.KhtmlOpacity = thisOp/100;
	obj.style.filter = 'alpha(opacity=' + thisOp + ')';
	if (thisOp == finishOp) {
		this.objTimeouts[obj.id] = null;
		if (finishOp >= 100) {
			try { obj.style.removeAttribute('filter'); } catch(e) {}
		}
		if (arguments.callee.oncomplete) arguments.callee.oncomplete();
	} else {
		this.objTimeouts[obj.id] = setTimeout(function() { fb.setOpacity(fb[obj.id], thisOp + incr, finishOp, incr, fadeIn); }, 20);
	}
};
this.resizeGroup = function(arr, funcOnComplete) {
	if (!funcOnComplete) var funcOnComplete = function() { return; };
	var i = arr.length;
	if (!i) return funcOnComplete();
	this.clearTimeout('resizeGroup');
	var diff = 0;
	while (i--) diff = Math.max(diff, Math.abs(arr[i][3] - arr[i][2]));
	var rate = (diff && this.resizeDuration)? Math.pow(Math.max(1, 2.2 - this.resizeDuration/10), (Math.log(diff))) / diff : 1;
	i = arr.length;
	while (i--) {
		arr[i][3] -= arr[i][2]
	}
	this.resize(rate, 1, arr, funcOnComplete);
};
this.resize = function(rate, count, arr, funcOnComplete) {
	if (arr) arguments.callee.arr = arr;
	if (funcOnComplete) arguments.callee.oncomplete = funcOnComplete;
	var arr = arguments.callee.arr;
	var increment = rate * count;
	if (increment > 1) increment = 1;
	var i = arr.length;
	while (i--) {
		var obj = arr[i][0], prop = arr[i][1], startPx = arr[i][2], diff = arr[i][3];
		obj.style[prop] = (startPx + diff * increment) + 'px';
	}
	if (increment >= 1) {
		this.objTimeouts.resizeGroup = null;
		if (arguments.callee.oncomplete) arguments.callee.oncomplete();
	} else {
		this.objTimeouts.resizeGroup = setTimeout(function() { fb.resize(rate, count + 1); }, 20);
	}
};
this.getXScroll = function() {
	return top.pageXOffset || this.body.scrollLeft || this.doc.documentElement.scrollLeft || 0;
};
this.getYScroll = function() {
	return top.pageYOffset || this.body.scrollTop || this.doc.documentElement.scrollTop || 0;
};
this.getDisplayWidth = function() {
	return (this.doc.documentElement && this.doc.documentElement.clientWidth) || this.body.clientWidth;
};
this.getDisplayHeight = function() {
	if (this.doc.childNodes && !this.doc.all && !navigator.taintEnabled && !this.doc.evaluate) {
		return top.innerHeight;
	}
	if (window.opera) {
		var h = this.body.clientHeight;
		if (this.body.currentStyle) {
			if (this.body.currentStyle.borderTopStyle != 'none') {
				h += parseInt(this.body.currentStyle.borderTopWidth);
			}
			if (this.body.currentStyle.borderBottomStyle != 'none') {
				h += parseInt(this.body.currentStyle.borderBottomWidth);
			}
		}
		return h;
	}
	var elementHeight = (this.doc.documentElement && this.doc.documentElement.clientHeight) || 0;
	if (!elementHeight || (this.doc.compatMode && this.doc.compatMode == 'BackCompat')) {
		return this.body.clientHeight;
	}
	return elementHeight;
};
this.setVisibility = function(tagName, state, thisWindow) {
	if (!thisWindow) {
		arguments.callee(tagName, state, top)
	} else {
		try {
			var els = thisWindow.document.getElementsByTagName(tagName);
			var i = els.length; while (i--) {
				els[i].style.visibility = state;
			}
		} catch(e) {}
		var frames = thisWindow.frames;
		i = frames.length; while (i--) {
			if (typeof(frames[i].window) == 'object') arguments.callee(tagName, state, frames[i].window);
		}
	}
};
this.clearTimeout = function(key) {
	if (this.objTimeouts[key]) {
		clearTimeout(this.objTimeouts[key]);
		this.objTimeouts[key] = null;
	}
};
this.stretchOverlay = function() {
	if (arguments.length == 1) {
		fb.clearTimeout('onresize');
		fb.objTimeouts.onresize = setTimeout(function() { fb.stretchOverlay(); }, 50);
	} else {
		fb.objTimeouts.onresize = null;
		var width = fb.fbFloatbox.offsetLeft + fb.fbFloatbox.offsetWidth;
		var height = fb.fbFloatbox.offsetTop + fb.fbFloatbox.offsetHeight;
		var style = fb.fbOverlay.style;
		style.width = style.height = '0';
		style.width = Math.max(width, fb.body.scrollWidth, fb.body.clientWidth, fb.doc.documentElement.clientWidth, fb.getDisplayWidth() + fb.getXScroll()) + 'px';
		style.height = Math.max(height, fb.body.scrollHeight, fb.body.clientHeight, fb.doc.documentElement.clientHeight, fb.getDisplayHeight() + fb.getYScroll()) + 'px';
	}
};
};
function initfb() {
	if (arguments.callee.done) return;
	arguments.callee.done = true;
	if (!top.floatbox) top.floatbox = new Floatbox();
	fb = top.floatbox;
	fb.tagAnchors(self.document);
	if (fb.autoStart) fb.start(fb.autoStart);
};
/*@cc_on
/*@if (@_win32 || @_win64)
	intervalID = setInterval(function() {
		try {
			document.documentElement.doScroll('left');
			clearInterval(intervalID);
			initfb();
		} catch (e) {}
	}, 50);
@else @*/
	if (/Apple|KDE/i.test(navigator.vendor)) {
		intervalID = setInterval(function() {
			if (/loaded|complete/.test(document.readyState)) {
				clearInterval(intervalID);
				initfb();
			}
		}, 50);
	} else if (document.addEventListener) {
		document.addEventListener('DOMContentLoaded', initfb, false);
	}
/*@end
@*/
function onloadClosure(priorOnload, thisOnload) {
    return function() {
    	if (priorOnload) priorOnload();
    	thisOnload();
    };
};
window.onload = onloadClosure(window.onload, function() {
	if (typeof(intervalID) != 'undefined') clearInterval(intervalID);
	initfb();
	if (!fb.itemCount) fb.preloadNextImage();
});
