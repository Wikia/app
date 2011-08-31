document.write('');

if(typeof(dartCallbackObjects) == "undefined")
  var dartCallbackObjects = new Array();
if(typeof(dartCreativeDisplayManagers) == "undefined")
  var dartCreativeDisplayManagers = new Object();
if(typeof(dartMotifAds) == "undefined")
  var dartMotifAds = new Array();
if(!self.dartLoadedGlobalTemplates_57_03) {
  self.dartLoadedGlobalTemplates_57_03 = {};
}
if(self.dartLoadedGlobalTemplates_57_03["@GT_TYPE@"]) {
  self.dartLoadedGlobalTemplates_57_03["@GT_TYPE@"].isLoaded = true;
}

function RichMediaCore_57_03() {
  this.CREATIVE_TYPE_EXPANDING = "ExpandingFlash";
  this.CREATIVE_TYPE_FLOATING = "FloatingFlash";
  this.CREATIVE_TYPE_INPAGE = "InpageFlash";
  this.CREATIVE_TYPE_INPAGE_WITH_FLOATING = "InpageFlashFloatingFlash";
  this.CREATIVE_TYPE_FLOATING_WITH_REMINDER = "FloatingFlashReminderFlash";
  this.CREATIVE_TYPE_INPAGE_WITH_OVERLAY = "InpageFlashOverlayFlash";
  this.ASSET_TYPE_FLOATING = "Floating";
  this.ASSET_TYPE_INPAGE = "Inpage";
  this.ASSET_TYPE_EXPANDING = "Expanding";
  this.ASSET_TYPE_REMINDER = "Reminder";
  this.ASSET_TYPE_OVERLAY = "Overlay";
  this.STANDARD_EVENT_DISPLAY_TIMER = "DISPLAY_TIMER";
  this.STANDARD_EVENT_INTERACTION_TIMER = "INTERACTION_TIMER";
  this.STANDARD_EVENT_INTERACTIVE_IMPRESSION = "EVENT_USER_INTERACTION";
  this.STANDARD_EVENT_FULL_SCREEN_VIDEO_PLAYS = "";
  this.STANDARD_EVENT_FULL_SCREEN_VIDEO_COMPLETES = "";
  this.STANDARD_EVENT_FULL_SCREEN_AVERAGE_VIEW_TIME = "";
  this.STANDARD_EVENT_MANUAL_CLOSE = "EVENT_MANUAL_CLOSE";
  this.STANDARD_EVENT_BACKUP_IMAGE = "BACKUP_IMAGE_IMPRESSION";
  this.STANDARD_EVENT_EXPAND_TIMER = "EXPAND_TIMER";
  this.STANDARD_EVENT_VIDEO_PLAY = "EVENT_VIDEO_PLAY";
  this.STANDARD_EVENT_VIDEO_VIEW_TIMER = "EVENT_VIDEO_VIEW_TIMER";
  this.STANDARD_EVENT_VIDEO_VIEW_COMPLETE = "EVENT_VIDEO_COMPLETE";
  this.STANDARD_EVENT_VIDEO_INTERACTION = "EVENT_VIDEO_INTERACTION";
  this.STANDARD_EVENT_VIDEO_PAUSE = "EVENT_VIDEO_PAUSE";
  this.STANDARD_EVENT_VIDEO_MUTE = "EVENT_VIDEO_MUTE";
  this.STANDARD_EVENT_VIDEO_REPLAY = "EVENT_VIDEO_REPLAY";
  this.STANDARD_EVENT_VIDEO_MIDPOINT = "EVENT_VIDEO_MIDPOINT";
  this.STANDARD_EVENT_VIDEO_FULLSCREEN = "";
  this.STANDARD_EVENT_VIDEO_STOP = "EVENT_VIDEO_STOP";
  this.STANDARD_EVENT_VIDEO_UNMUTE = "EVENT_VIDEO_UNMUTE";
  this.STANDARD_EVENT_FULLSCREEN = "EVENT_FULLSCREEN";
  this.STANDARD_EVENT_DYNAMIC_CREATIVE_IMPRESSION = "DYNAMIC_CREATIVE_IMPRESSION";
};
RichMediaCore_57_03.prototype.isPageLoaded = false;
RichMediaCore_57_03.prototype.csiTimes = new Object();
RichMediaCore_57_03.prototype.setCsiEventsRecordedDuringBreakout = function(creative) {
  if(creative.gtStartLoadingTime != undefined)
    this.csiTimes["gb"] = creative.gtStartLoadingTime;
};
RichMediaCore_57_03.prototype.csiHasValidStart = function(creative) {
  return ((creative.csiAdRespTime >= 0) && (creative.csiAdRespTime < 1e5));
};
RichMediaCore_57_03.prototype.shouldReportCsi = function(creative) {
  
  return this.csiHasValidStart(creative) || (Math.floor(Math.random() * 1001) == 1);
};
RichMediaCore_57_03.prototype.shouldCsi = function(asset, creativeType) {
  switch (creativeType) {
    case this.CREATIVE_TYPE_INPAGE_WITH_FLOATING:
      return asset.assetType == this.ASSET_TYPE_INPAGE;
    case this.CREATIVE_TYPE_FLOATING_WITH_REMINDER:
      return asset.assetType == this.ASSET_TYPE_FLOATING;
    case this.CREATIVE_TYPE_INPAGE_WITH_OVERLAY:
      return asset.assetType == this.ASSET_TYPE_INPAGE;
    default: return true;
  }
};
RichMediaCore_57_03.prototype.trackCsiEvent = function(event) {
  this.csiTimes[event] = new Date().getTime();
};
RichMediaCore_57_03.prototype.getCsiServer = function() {
  return (self.location.protocol &&
      self.location.protocol.toString().toLowerCase() == 'https:') ?
        "https://static.doubleclick.net" : "http://static.2mdn.net"; 
};
RichMediaCore_57_03.prototype.reportCsi = function(creative) {
  if (!creative.previewMode && this.shouldReportCsi(creative)) {
    var url = this.getCsiServer() + "/csi/d?s=rmad&v=2&rt=";
    var beginTimes = "";
    var intervals = "";
    for(var event in this.csiTimes) {
      var loadingTime = (this.csiTimes[event] - creative.csiBaseline);
      url += event + "." + (loadingTime > 0 ? loadingTime : 0) + ",";
      if (event == "pb" || event == "gb" || event == "fb" ) {
        beginTimes += event + "." + (loadingTime > 0 ? loadingTime : 0) + ",";
      }
    }
    url = url.replace(/\,$/, '');
    var plcrLoadingTime = this.csiTimes["pe"] - this.csiTimes["pb"];
    var gtLoadingTime = this.csiTimes["ge"] - this.csiTimes["gb"];
    var flashLoadingTime = this.csiTimes["fe"] - this.csiTimes["fb"];
    intervals = "pl." + (plcrLoadingTime > 0 ? plcrLoadingTime : 0) + ","
        + "gl." + (gtLoadingTime > 0 ? gtLoadingTime : 0) + ","
        + "fl." + (flashLoadingTime > 0 ? flashLoadingTime : 0);
    url += "&irt=" + beginTimes.replace(/\,$/, '') + "&it=" + intervals;
    var regEx = new RegExp(/(.*\/\/)/);
    url += "&adi=asd_" + creative.adServer.replace(regEx, '')
          + ",csd_" + creative.mediaServer.replace(regEx, '')
          + ",gt_" + creative.globalTemplateJs.replace(/(.*\/)/, '');
    if (this.csiHasValidStart(creative)) {
      url += "&srt=" + creative.csiAdRespTime;
    }
    this.trackUrl(url, true, creative.previewMode);
  }
};
RichMediaCore_57_03.prototype._isValidStartTime = function(startTime) {
  return this._isValidNumber(startTime);
};
RichMediaCore_57_03.prototype._convertDuration = function(duration) {
  if(duration) {
    duration = duration.toString().toUpperCase();
    switch(duration) {
    case "AUTO": return "AUTO";
    case "NONE": return 0;
    default: return (this._isValidNumber(duration) ? eval(duration) : 0);
    }
  }
  return 0;
};
RichMediaCore_57_03.prototype.convertUnit = function(pos) {
  if(pos != "") {
    pos = pos.toLowerCase().replace(new RegExp("pct", "g"), "%");
    if(pos.indexOf("%") < 0 && pos.indexOf("px") < 0 && pos.indexOf("pxc") < 0)
      pos += "px";
  }
  return pos;
};
RichMediaCore_57_03.prototype._isValidNumber = function(num) {
  var floatNum = parseFloat(num);
  if(isNaN(floatNum) || floatNum < 0)
    return false;
  return (floatNum == num);
};
RichMediaCore_57_03.prototype.writeSurveyURL = function(creative) {
  if(!creative.previewMode && creative.surveyUrl.length > 0) {
    document.write('<scr' + 'ipt src="' + creative.surveyUrl + '" language="JavaScript"></scr' + 'ipt>');
  }
};
RichMediaCore_57_03.prototype.postPublisherData = function(creative, publisherURL) {
  if(!creative.previewMode && this.isInterstitialCreative(creative) && publisherURL != "") {
    var postImg = new Image();
    postImg.src = publisherURL;
  }
};
RichMediaCore_57_03.prototype.isInterstitialCreative = function(creative) {
  return (creative.type == this.CREATIVE_TYPE_FLOATING
          || creative.type == this.CREATIVE_TYPE_FLOATING_WITH_REMINDER);
};
RichMediaCore_57_03.prototype.isBrowserComplient = function(plugin) {
  return (this.isInternetExplorer() || this.isFirefox() || this.isSafari() || this.isChrome()) && (this.isWindows() || this.isMac()) && this.getPluginInfo() >= plugin;
};
RichMediaCore_57_03.prototype.shouldDisplayFloatingAsset = function(duration) {
  return !this.isInternetExplorer() || this._convertDuration(duration) || this.getIEVersion() >= 5.5;
};
RichMediaCore_57_03.prototype.isWindows = function() {
	return true
  return (navigator.appVersion.indexOf("Windows") != -1);
};
RichMediaCore_57_03.prototype.isFirefox = function() {
  var appUserAgent = navigator.userAgent.toUpperCase();
  if(appUserAgent.indexOf("GECKO") != -1) {
    if(appUserAgent.indexOf("FIREFOX") != -1) {
      var version = parseFloat(appUserAgent.substr(appUserAgent.lastIndexOf("/") + 1));
      return (version >= 1);
    }
    else if(appUserAgent.indexOf("NETSCAPE") != -1) {
      version = parseFloat(appUserAgent.substr(appUserAgent.lastIndexOf("/") + 1));
      return (version >= 8);
    } else {
      return false;
    }
  }
  else {
    return false;
  }
};
RichMediaCore_57_03.prototype.isSafari = function() {
  var br = "Safari";
  var index = navigator.userAgent.indexOf(br);
  var appVendor = (navigator.vendor != undefined) ? navigator.vendor.toUpperCase() : "";
  return (navigator.appVersion.indexOf(br) != -1) && parseFloat(navigator.userAgent.substring(index + br.length + 1)) >= 312.6 && (appVendor.indexOf("APPLE") != -1);
};
RichMediaCore_57_03.prototype.isChrome = function() {
  var appUserAgent = navigator.userAgent.toUpperCase();
  var appVendor = (navigator.vendor != undefined) ? navigator.vendor.toUpperCase() : "";
  return (appUserAgent.indexOf("CHROME") != -1) && (appVendor.indexOf("GOOGLE") != -1);
};
RichMediaCore_57_03.prototype.isMac = function() {
  return (navigator.appVersion.indexOf("Mac") != -1);
};
RichMediaCore_57_03.prototype.isInternetExplorer = function() {
  return (navigator.appVersion.indexOf("MSIE") != -1 && navigator.userAgent.indexOf("Opera") < 0);
};
RichMediaCore_57_03.prototype.getIEVersion = function() {
  var version = 0;
  if(this.isInternetExplorer()) {
    var key = "MSIE ";
    var index = navigator.appVersion.indexOf(key) + key.length;
    var subString = navigator.appVersion.substr(index);
    version = parseFloat(subString.substring(0, subString.indexOf(";")));
  }
  return version;
};
RichMediaCore_57_03.prototype.getPluginInfo = function() {
  return (this.isInternetExplorer() && this.isWindows()) ? this._getIeWindowsFlashPluginVersion() : this._detectNonWindowsFlashPluginVersion();
};
RichMediaCore_57_03.prototype._detectNonWindowsFlashPluginVersion = function() {
  var flashVersion = 0;
  var key = "Shockwave Flash";
  if(navigator.plugins && (navigator.plugins["Shockwave Flash 2.0"] || navigator.plugins[key])) {
    var version2Offset = navigator.plugins["Shockwave Flash 2.0"] ? " 2.0" : "";
    var flashDescription = navigator.plugins[key + version2Offset].description;
    var keyIndex = flashDescription.indexOf(key) + (key.length+1);
    var dotIndex = flashDescription.indexOf(".");
    var majorVersion = flashDescription.substring(keyIndex, dotIndex);
    var descArray = flashDescription.split(" ");
    var minorVersion = (parseInt(descArray[descArray.length - 1].replace(new RegExp("[A-Za-z]", "g"), "")));
    if(isNaN(minorVersion)) {
      minorVersion = "0";
    }
    flashVersion = parseFloat(majorVersion + "." + minorVersion);
    if(flashVersion > 6.0 && flashVersion < 6.65) {
      flashVersion = 0 ;
    }
  }
  return flashVersion;
};
RichMediaCore_57_03.prototype._getIeWindowsFlashPluginVersion = function() {
  var versionStr = "";
  var flashVersion = 0;
  var versionArray = new Array();
  var tempArray = new Array();
  var lineFeed = "\r\n";
  var defSwfVersion = 0;
  var str = 'swfVersion = '+ defSwfVersion + lineFeed +
    'mtfIsOk = ' + false + lineFeed +
    'On Error Resume Next' + lineFeed +
    'set motifSwfObject = CreateObject(\"ShockwaveFlash.ShockwaveFlash\")' + lineFeed +
    'mtfIsOk = IsObject(motifSwfObject)' + lineFeed +
    'if mtfIsOk = true then' + lineFeed +
    'swfVersion = motifSwfObject.GetVariable(\"$version\")' + lineFeed +
    'end if' + lineFeed + '';
  window.execScript(str, "VBScript");
  if(mtfIsOk) {
    versionStr = swfVersion;
    tempArray = versionStr.split(" ");
    if(tempArray.length > 1) {
      versionArray = tempArray[1].split(",");
      var versionMajor = versionArray[0];
      var versionRevision = versionArray[2];
      if(versionMajor > 9 && versionArray.length > 3) {
        versionRevision = versionArray[versionArray.length - 1];
      }
      flashVersion = parseFloat(versionMajor + "." + versionRevision);
    }
  }
  return flashVersion;
};
RichMediaCore_57_03.prototype.trackBackupImageEvent = function(adserverUrl) {
  var activityString = "eid1=9;ecn1=1;etm1=0;";
  var timeStamp = new Date();
  var postImage = document.createElement("IMG");
  postImage.src = adserverUrl + "&timestamp=" + timeStamp.getTime() + ";" + activityString;
};
RichMediaCore_57_03.prototype.trackUrl = function(url, createElement, previewMode) {
  if(previewMode || url == "") {
    return;
  }
  if (createElement) {
    var postImage = document.createElement("IMG");
    postImage.src = url;
  }
  else {
    document.write('<IMG SRC="'+ url + '" style="display:none" width="0px" height="0px" alt="">');
  }
};
RichMediaCore_57_03.prototype.logThirdPartyImpression = function(creative) {
  this.trackUrl(creative.thirdPartyImpUrl, false, creative.previewMode);
};
RichMediaCore_57_03.prototype.logThirdPartyBackupImageImpression = function(creative, createElement) {
  this.trackUrl(creative.thirdPartyBackupImpUrl, createElement, creative.previewMode);
};
RichMediaCore_57_03.prototype.logThirdPartyFlashDisplayImpression = function(creative, createElement) {
  this.trackUrl(creative.thirdPartyFlashDisplayUrl, createElement, creative.previewMode);
};
RichMediaCore_57_03.prototype.isPartOfArrayPrototype = function(subject) {
  for(var prototypeItem in Array.prototype) {
    if(prototypeItem == subject) {
      return true;
    }
  }
  return false;
};
RichMediaCore_57_03.prototype.toObject = function(variableName) {
  try {
    if(document.layers) {
      return (document.layers[variableName]) ? eval(document.layers[variableName]) : null;
    }
    else if(document.all && !document.getElementById) {
      return (eval("window." + variableName)) ? eval("window." + variableName) : null;
    }
    else if(document.getElementById && document.body.style) {
      return (document.getElementById(variableName)) ? eval(document.getElementById(variableName)) : null;
    }
  } catch(e){}
  return null;
};
RichMediaCore_57_03.prototype.getCallbackObjectIndex = function(obj) {
  for(var i = 0; i < dartCallbackObjects.length; i++) {
    if(dartCallbackObjects[i] == obj)
      return i;
  }
  dartCallbackObjects[dartCallbackObjects.length] = obj;
  return dartCallbackObjects.length - 1;
};
RichMediaCore_57_03.prototype.registerPageLoadHandler = function(handler, obj) {
  var callback = this.generateGlobalCallback(handler, obj);
  if(this.isInternetExplorer()) {
    if(self.document.readyState == "complete")
      callback();
    else
      self.attachEvent("onload", callback);
  }
  else if(this.isFirefox()) {
    if(this.isPageLoaded) {
      callback();
    }
    
    else {
      self.addEventListener("load", callback, true);
    }
  }
  else if(this.isSafari() || this.isChrome()) {
    if(self.document.readyState == "complete")
      callback();
    else
      self.addEventListener("load", callback, true);
  }
};
RichMediaCore_57_03.prototype.pageLoaded = function() {
  RichMediaCore_57_03.prototype.isPageLoaded = true;
};
RichMediaCore_57_03.prototype.registerPageUnLoadHandler = function(handler, obj) {
  var callback = this.generateGlobalCallback(handler, obj);
  if(this.isInternetExplorer() && this.isWindows()) {
    self.attachEvent("onunload", callback);
  }
  else if(this.isFirefox() || this.isSafari() || this.isChrome()) {
    self.addEventListener("unload", callback, true);
  }
};
RichMediaCore_57_03.prototype.registerTimeoutHandler = function(timeout, handler, obj) {
  window.setTimeout(this.generateGlobalCallback(handler, obj), timeout);
};
RichMediaCore_57_03.prototype.createFunction = function(name, ownerObject, args) {
  var fun = "dartCallbackObjects[" + this.getCallbackObjectIndex(ownerObject) + "]." + name + "(";
  for(var i = 0; i < args.length; i++) {
    fun += "dartCallbackObjects[" + this.getCallbackObjectIndex(args[i]) + "]";
    if(i != (args.length - 1))
      fun += ",";
  }
  fun += ")";
  return new Function(fun);
};
RichMediaCore_57_03.prototype.generateGlobalCallback = function(handler, obj) {
  if(obj) {
    var index = this.getCallbackObjectIndex(obj);
    handler = "if(dartCallbackObjects["+ index +"] != null) dartCallbackObjects["+ index +"]." + handler;
  }
  return new Function(handler);
};
RichMediaCore_57_03.prototype.registerEventHandler = function(event, element, handler, obj) {
  var callback = this.generateGlobalCallback(handler, obj);
  if(this.isInternetExplorer() && this.isWindows()) {
    self.attachEvent("on" + event, callback);
  }
  else if(this.isFirefox() || this.isSafari() || this.isChrome()) {
    element.addEventListener(event, callback, false);
  }
};
RichMediaCore_57_03.prototype.scheduleCallbackOnLoad = function(callback) {
  var onloadCheckInterval = 200;
  if(window.document.readyState.toLowerCase() == "complete")
    eval(callback);
  else
    this.registerTimeoutHandler(onloadCheckInterval, "scheduleCallbackOnLoad('" + callback + "')", this);
};
RichMediaCore_57_03.prototype.getStyle = function(obj) {
  if(window.getComputedStyle)
    return window.getComputedStyle(obj, "");
  else if(obj.currentStyle)
    return obj.currentStyle;
  else
    return obj.style;
};
RichMediaCore_57_03.prototype.getWindowDimension = function() {
  var dimension = new Object();
  if(document.documentElement && document.compatMode == "CSS1Compat") {
    dimension.width = document.documentElement.clientWidth;
    dimension.height = document.documentElement.clientHeight;
  } else if(document.body && (document.body.clientWidth || document.body.clientHeight) && !this.isSafari()) {
    dimension.width = document.body.clientWidth;
    dimension.height = document.body.clientHeight;
  } else if(typeof(window.innerWidth) == 'number') {
    dimension.width = window.innerWidth;
    dimension.height = window.innerHeight;
  }
  return dimension;
};
RichMediaCore_57_03.prototype.getScrollbarPosition = function() {
  var scrollPos = new Object();
  scrollPos.scrollTop = 0;
  scrollPos.scrollLeft = 0;
  if(typeof(window.pageYOffset) == 'number') {
    scrollPos.scrollTop = window.pageYOffset;
    scrollPos.scrollLeft = window.pageXOffset;
  } else if(document.body && (document.body.scrollLeft || document.body.scrollTop)) {
    scrollPos.scrollTop = document.body.scrollTop;
    scrollPos.scrollLeft = document.body.scrollLeft;
  } else if(document.documentElement && (document.documentElement.scrollLeft || document.documentElement.scrollTop)) {
    scrollPos.scrollTop = document.documentElement.scrollTop;
    scrollPos.scrollLeft = document.documentElement.scrollLeft;
  }
  return scrollPos;
};
RichMediaCore_57_03.prototype.isInFriendlyIFrame = function() {
  return (this.isInMsnFriendlyIFrame() || this.isInAolFriendlyIFrame()
          || this.isInYahooFriendlyIFrame() || this.isInClientPreviewIFrame());
};
RichMediaCore_57_03.prototype.isInMsnFriendlyIFrame = function() {
  return (typeof(inDapIF) != "undefined" && inDapIF);
};
RichMediaCore_57_03.prototype.isInAolFriendlyIFrame = function() {
  return (typeof(inFIF) != "undefined" && inFIF);
};
RichMediaCore_57_03.prototype.isInMsnAjaxEnvironment = function() {
  return (typeof(inDapMgrIf) != "undefined" && inDapMgrIf);
};
RichMediaCore_57_03.prototype.isInYahooFriendlyIFrame = function() {
  return (typeof(isAJAX) != "undefined" && isAJAX);
};
RichMediaCore_57_03.prototype.isInClientPreviewIFrame = function() {
  if(typeof(StudioPreviewResponse) != "undefined") {
    return !(new StudioPreviewResponse()).isAdslotDetected;
  } else {
    return false;
  }
};
RichMediaCore_57_03.prototype.isInAdSenseIFrame = function() {
  return (typeof(IN_ADSENSE_IFRAME) != "undefined") && IN_ADSENSE_IFRAME;
};
RichMediaCore_57_03.prototype.checkDimension = function(dim) {
  if (typeof dim == "number") {
    return dim + "px";
  } else {
    return dim + (dim != "" && dim != "auto" && dim.indexOf("px") < 0 ? "px" : "");
  }
};
RichMediaCore_57_03.prototype.setFlashVariable = function(asVersion, flashObject, variableName, value) {
  if (asVersion == 1) {
    flashObject.SetVariable("_root." + variableName, value);
  } else {
    flashObject.changeInputVariable(variableName, value);
  }
};
RichMediaCore_57_03.prototype.getFlashVariable = function(asVersion, flashObject, variableName) {
  if (asVersion == 1) {
    return flashObject.GetVariable("_root." + variableName);
  } else {
    return flashObject.getFlashVariable(variableName);
  }
};
RichMediaCore_57_03.prototype.getSalign = function(expandedWidth, expandedHeight, offsetTop, offsetLeft, offsetRight, offsetBottom) {
  var salign = "";
  if (offsetTop == 0 && offsetBottom != expandedHeight) {
    salign += "T";
  } else if (offsetTop != 0 && offsetBottom == expandedHeight) {
    salign += "B";
  }
  if (offsetLeft == 0 && offsetRight != expandedWidth) {
    salign += "L";
  } else if (offsetLeft != 0 && offsetRight == expandedWidth) {
    salign += "R";
  }
  if ((salign == "T" || salign == "B") && (offsetLeft != 0 || offsetRight != expandedWidth)) {
    return "";
  }
  if ((salign == "L" || salign == "R") && (offsetTop != 0 || offsetBottom != expandedHeight)) {
    return "";
  }
  return salign;
};
RichMediaCore_57_03.prototype.usesSalignForExpanding = function(salign, wmode) {
  return ( (this.isMac() && (this.isSafari() || this.isFirefox()))
           || (this.isWindows() && this.isFirefox() && wmode.toLowerCase() == "window") ) && salign.length > 0;
};
RichMediaCore_57_03.prototype.unclipFlashObject = function(asset, width, height) {
  this.clipFlashObject(asset, width, height, "auto", "auto", "auto", "auto");
};
RichMediaCore_57_03.prototype.clipFlashObject = function(asset, width, height, offsetTop, offsetRight, offsetBottom, offsetLeft) {
  width        = this.checkDimension(width);
  height       = this.checkDimension(height);
  offsetTop    = this.checkDimension(offsetTop);
  offsetRight  = this.checkDimension(offsetRight);
  offsetBottom = this.checkDimension(offsetBottom);
  offsetLeft   = this.checkDimension(offsetLeft);
  if (this.usesSalignForExpanding(asset.salign, asset.wmode)) {
    var fl = document.getElementById("FLASH_"+asset.variableName);
    fl.style.width = width;
    fl.style.height = height;
    fl.width = width;
    fl.height = height;
    fl.style.marginLeft = offsetLeft == "auto" ? "0px" : offsetLeft;
    fl.style.marginTop = offsetTop == "auto" ? "0px" : offsetTop;
  }
  var exp = this.toObject("DIV_" + asset.variableName);
  exp.style.clip = "rect(" + offsetTop + " " + offsetRight + " " + offsetBottom + " " + offsetLeft + ")";
};
RichMediaCore_57_03.prototype.getSitePageUrl = function(creative) {
  if (creative.type == this.CREATIVE_TYPE_INPAGE_WITH_OVERLAY) {
    return "";
  }
  if (creative.previewMode) {
    return creative.livePreviewSiteUrl;
  } else {
    if (creative.type == this.CREATIVE_TYPE_INPAGE && creative.servingMethod == "i") {
      return self.document.referrer;
    } else {
      return self.location.href;
    }
  }
};
RichMediaCore_57_03.prototype.getElementPosition = function(elementName) {
  var obj = this.toObject(elementName);
  var adPosition = new Object();
  if(obj.getBoundingClientRect) {
  	adPosition.left = obj.getBoundingClientRect().left;
  	adPosition.top = obj.getBoundingClientRect().top;
  } else {
    adPosition.left = 0;
    adPosition.top = 0;
    if (obj.offsetParent) {
      do {
        adPosition.left += obj.offsetLeft;
        adPosition.top += obj.offsetTop;
      } while (obj = obj.offsetParent);
    }
    var windowScroll = this.getScrollbarPosition();
    adPosition.top -= windowScroll.scrollTop;
    adPosition.left -= windowScroll.scrollLeft;
  }
  return adPosition;
};
RichMediaCore_57_03.prototype.isFlashObjectReady = function(asVersion, flashObject, assetName) {
  if(asVersion == 1) {
    return (flashObject && (typeof(flashObject.PercentLoaded) != "undefined") && flashObject.PercentLoaded() > 0
        && this.getAsset(assetName).conduitInitialized);
  } else {
    return flashObject != null && (typeof(flashObject.changeInputVariable) != "undefined");
  }
};

document.write('\n');

function IFrameBuster_57_03() {
};
IFrameBuster_57_03.prototype = new RichMediaCore_57_03;
IFrameBuster_57_03.prototype.getSiteHost = function(pageUrl) {
  var siteHost = "";
  if((pageUrl.length >= 7) && (pageUrl.substr(0, 7) == "http://"))
    siteHost = pageUrl.substr(7);
  else if((pageUrl.length >= 8) && (pageUrl.substr(0, 8) == "https://"))
  siteHost = pageUrl.substr(8);
  else
    siteHost = pageUrl;
  var index = siteHost.indexOf("/");
  if(index > 0)
    siteHost = siteHost.substr(0, index);
  return siteHost;
};
IFrameBuster_57_03.prototype.getSiteProtocol = function(pageUrl) {
  var siteProtocol = "";
  if((pageUrl.length >= 5) && (pageUrl.substr(0, 5) == "http:"))
    siteProtocol = "http:";
  else if((pageUrl.length >= 6) && (pageUrl.substr(0, 6) == "https:"))
  siteProtocol = "https:";
  else
    siteProtocol = "http:";
  return siteProtocol;
};
IFrameBuster_57_03.prototype.canAccessParentPage = function() {
  try {
    self.parent.document.body;
    return true;
  } catch(e) {
    return false;
  }
};
IFrameBuster_57_03.prototype.writeIFrame = function(creative, plcrJs, globalTemplateJs) {
  if(this.isInFriendlyIFrame()) {
    this.processFriendlyIFrameBreakout(creative, plcrJs, globalTemplateJs);
  } else {
    this.processBreakoutUsingPublisherFile(creative, plcrJs, globalTemplateJs);
  }
};
IFrameBuster_57_03.prototype.processFriendlyIFrameBreakout = function(creative, plcrJs, globalTemplateJs) {
  var targetWindow = self.parent;
  this.targetWindow = targetWindow;
  var iframe = this.getThisIFrame();
  if(typeof(targetWindow.richMediaIFrameCreatives) == "undefined") {
    targetWindow.richMediaIFrameCreatives = {};
  }
  if(creative.isInterstitial && this.isInterstitialPlaying(targetWindow)) {
    return;
  }
  this.setInterstitialPlaying(targetWindow);
  targetWindow.richMediaIFrameCreatives[creative["uniqueId"]] = {
    baseCreative: creative,
    sourceIFrame: iframe,
    plcrScript: plcrJs
  };
  if(creative.customScriptFileUrl != "") {
    this.loadScriptFile(targetWindow, creative, iframe, creative.customScriptFileUrl, false);
  }
  if(this.checkAndLoadGlobalTemplate(targetWindow, creative, iframe, globalTemplateJs)) {
    (new targetWindow.IFrameCreativeRenderer_57_03()).loadPlCrJs(plcrJs, iframe, targetWindow);
  }
  var unloadCallback = "removeCreative('" + creative.globalTemplateVersion + "','" + creative.creativeIdentifier + "'," + !this.isInYahooFriendlyIFrame() + ")";
  this.registerPageUnLoadHandler(unloadCallback, this);
};
IFrameBuster_57_03.prototype.removeCreative = function(gtVersion, creativeIdentifier, deleteOnlyJSObjects) {
  var iframeObj = this.getDARTIFrameObject();
    iframeObj.removeCreative(creativeIdentifier, deleteOnlyJSObjects);
};
IFrameBuster_57_03.prototype.getDARTIFrameObject = function() {
  return eval("(new this.targetWindow.IFrameCreativeRenderer_57_03())");
};
IFrameBuster_57_03.prototype.processBreakoutUsingPublisherFile = function(creative, plcrJs, globalTemplateJs) {
  var docReferrer = self.document.referrer;
  if(docReferrer == "") {
    try {
      docReferrer = self.parent.location.href;
      if(docReferrer == "")
        return;
    }
    catch(e) {
      return;
    }
  }
  if(creative.previewMode)
    docReferrer = self.location.href;
  var filePath = "";
  if(filePath == "")
    filePath = "/doubleclick/DARTIframe.html";
  else
    filePath += "DARTIframe.html";
  var mediaServer = "http://s0.2mdn.net/879366";
  var siteProtocol = this.getSiteProtocol(docReferrer);
  var siteHost = this.getSiteHost(docReferrer);
  siteHost = siteProtocol + "//" + siteHost + filePath;
  var adParameters = escape(this.serialize(creative));
  var getSizeLimit = 1800;
  var staticParams = "&gtVersion=" + escape(creative.globalTemplateVersion)
    + "&mediaserver=" + escape(mediaServer)
    + "&cid=" + escape(creative.creativeIdentifier) + "&plcrjs=" + escape(plcrJs)
    + "&globalTemplateJs=" + escape(globalTemplateJs)
    + "&customScriptFile=" + escape(creative.customScriptFileUrl);
  var masterParamLength = getSizeLimit - staticParams.length - siteHost.length - "?adParams=".length;
  var needSlaves = false;
  if(masterParamLength >= adParameters.length)
    masterParamLength = adParameters.length;
  else
    needSlaves = true;
  var slaveParams = "";
  var slaveParamLength = 0;
  var numberOfSlaves = 0;
  if(needSlaves) {
    slaveParams = "&gtVersion=" + escape(creative.globalTemplateVersion)
      + "&mediaserver=" + escape(mediaServer) + "&cid=" + escape(creative.creativeIdentifier);
    slaveParamLength = getSizeLimit - siteHost.length - "?adParams=".length - slaveParams.length - "&index=".length;
    numberOfSlaves = Math.ceil((adParameters.length - masterParamLength)/slaveParamLength);
  }
  masterParamLength = this.adjustParamLength(adParameters, masterParamLength);
  var masterParams = adParameters.substring(0, masterParamLength);
  var iframeLocation = siteHost + "?adParams=" + masterParams + staticParams + "&needSlaves=" + needSlaves + "&numberOfSlaves=" + numberOfSlaves;
  
  if(this.isFirefox() || this.isSafari() || this.isChrome()) {
    this.createIframe(iframeLocation, creative.creativeIdentifier);
  }
  else {
    document.write("<iframe src='" + iframeLocation + "' width='0px' height='0px' frameborder='0' scrolling='no'></iframe>");
  }
  if(needSlaves) {
    adParameters = adParameters.substring(masterParamLength);
    var paramLength = 0;
    var slaveIndex = 0;
    while(adParameters.length > 0) {
      paramLength = (slaveParamLength >= adParameters.length) ?
                    adParameters.length : this.adjustParamLength(adParameters, slaveParamLength);
      this.writeSlaveIFrame(siteHost, adParameters.substring(0, paramLength), slaveParams, slaveIndex++, creative.creativeIdentifier);
      adParameters = adParameters.substring(paramLength);
    }
  }
};
IFrameBuster_57_03.prototype.adjustParamLength = function (params, paramLength) {
  for (var i = 1; i < 3; i++) {
    if(params.charAt(paramLength - i) == "%")
      return paramLength - i;
    }
  return paramLength;
};
IFrameBuster_57_03.prototype.writeSlaveIFrame = function(siteHost, adParams, slaveParams, index, cid) {
  var iframeLocation = siteHost + "?adParams=" + adParams + slaveParams + "&index=" + index;
  
  if(this.isFirefox() || this.isSafari() || this.isChrome()) {
    this.createIframe(iframeLocation, cid + "_" + index);
  }
  else {
    document.write("<iframe src='" + iframeLocation + "' name='" + cid + "_" + index + "' width='0px' height='0px' frameborder='0' scrolling='no'></iframe>");
  }
};
IFrameBuster_57_03.prototype.createIframe = function(iframeLocation, iframeName) {
  var  iframe = document.createElement("IFRAME");
  iframe.setAttribute("name", iframeName);
  iframe.style.width = "0px";
  iframe.style.height = "0px";
  iframe.frameBorder = "0";
  iframe.scrolling = "no";
  if(document.body) {
	document.body.appendChild(iframe);
  } else {
	document.documentElement.appendChild(iframe);
  }
  iframe.setAttribute("src", iframeLocation);
};
IFrameBuster_57_03.prototype.isInIFrame = function() {
  var pageIFrameRequest = "";
  var iframeReq = "";
  if(this.isInAdSenseIFrame())
    return false;
  if(this.isInClientPreviewIFrame())
    return true;
  if(typeof(iframeRequest) != "undefined")
    pageIFrameRequest = iframeRequest;
  if(iframeReq != "")
    pageIFrameRequest = iframeReq;
  if(self == top)
    return false;
  else if(String(pageIFrameRequest).toLowerCase() == "false")
    return false;
  else if(self.location.href.toLowerCase().indexOf("doubleclick.net/adi") > -1)
    return true;
  else if(("j") == "i")
    return true;
  else
    return this.checkWithTryCatch();
};
IFrameBuster_57_03.prototype.checkWithTryCatch = function() {
  try {
    if(self.parent.document) {
      if(self.parent.document.getElementsByTagName("frame").length == 0) {
        var frames = self.parent.frames;
        for(var i = 0; i < frames.length; i++) {
          if(frames[i] == self)
            return true;
        }
      }
    }
    else if ((this.isSafari() || this.isChrome()) && self.parent.document == undefined) {
      return true;
    }
    return false;
  }
  catch(e) {
    return true;
  }
};
IFrameBuster_57_03.prototype.isBreakoutSuccessful = function() {
  try {
    return (self.frames[0].frames.length > 0 && typeof(self.frames[0].frames['DARTMotifIFrame']) != "undefined");
  }
  catch(e) {
    return true;
  }
};
IFrameBuster_57_03.prototype.getThisIFrame = function() {
  if(this.isFirefox() || this.isSafari() || this.isChrome()) {
    var iframeElements = self.parent.document.getElementsByTagName("iframe");
    for(var k = 0; k < iframeElements.length; k++) {
      var iframeEle = iframeElements[k];
      if(iframeEle.contentWindow == self) {
        return iframeEle;
      }
    }
    return null;
  }
  var targetWindow = self.parent;
  var frames = targetWindow.frames;
  for(var i = 0; i < frames.length; i++) {
    if(frames[i] == self)
      return targetWindow.document.getElementsByTagName("iframe")[i];
  }
  return null;
};
IFrameBuster_57_03.prototype.isInterstitialPlaying = function(targetWindow) {
  return (typeof(targetWindow.DoNotDisplayIA) == "number");
};
IFrameBuster_57_03.prototype.setInterstitialPlaying = function(targetWindow) {
  this.createJSVariable(targetWindow, "DoNotDisplayIA", 1);
};
IFrameBuster_57_03.prototype.createJSVariable = function(targetWindow, variableName, variableValue) {
  targetWindow[variableName] = variableValue;
};
IFrameBuster_57_03.prototype.serialize = function(obj) {
  var str = "";
  for(var key in obj) {
    str += escape(key) + "=";
    str += escape(obj[key]) + "&";
  }
  return str.substr(0, str.length - 1);
};
IFrameBuster_57_03.prototype.checkAndLoadGlobalTemplate = function(targetWindow, creative, iframe, jsFile) {
    var key = "";
    if(creative.type == this.CREATIVE_TYPE_EXPANDING) {
        key = "expandingIframe";
    } else if(creative.type == this.CREATIVE_TYPE_FLOATING) {
        key = "floatingIframe";
    } else if(creative.type == this.CREATIVE_TYPE_INPAGE_WITH_FLOATING) {
        key = "inpageFloatingIframe";
    }
    var shouldLoad = false;
    if(!targetWindow.dartLoadedGlobalTemplates_57_03) {
      targetWindow.dartLoadedGlobalTemplates_57_03 = {};
      shouldLoad = true;
    }
    var map = targetWindow.dartLoadedGlobalTemplates_57_03; 
    if(!map[key]) {
      map[key] = {
        isLoading: false,
        isLoaded: false
      };
      shouldLoad = true;
    }
    if(shouldLoad) {
      this.loadScriptFile(targetWindow, creative, iframe, jsFile, true);
      map[key].isLoading = true;
      return false;
    } else {
      return map[key].isLoaded;
  }
};
IFrameBuster_57_03.prototype.loadScriptFile = function(targetWindow, creative, iframe, jsFile, isGlobalTemplate) {
    var script = targetWindow.document.createElement("SCRIPT");
    if(isGlobalTemplate) {
      creative.gtStartLoadingTime = new Date().getTime();
    }
    script.src = jsFile;
    var elements = targetWindow.document.getElementsByTagName("head");
    if(this.isInternetExplorer() && elements.length > 0) {
      elements[0].appendChild(script);
    } else if(iframe.parentNode.parentNode) {
      iframe.parentNode.parentNode.appendChild(script);
    } else {
      iframe.parentNode.insertBefore(script, iframe);
    }
};

document.write('\n \n      ');

      function DARTExpandingUtil_57_03() {
        this.displayImageOnBreakoutFailure = function(variableName, target, hRef, imgSrc, width, height, altText, creative) {
          var callback = this.createFunction("displayImage", this, arguments);
          if(this.isInternetExplorer()) {
            if(self.document.readyState == "complete")
              callback();
            else
              self.attachEvent("onload", callback);
          }
          else if(this.isFirefox()) {
            self.addEventListener("load", callback, true);
          }
          else if(this.isSafari()) {
           if(self.document.readyState == "complete")
              callback();
            else
              self.addEventListener("load", callback, true);
          }
        }
        this.displayImage = function(variableName, target, hRef, imgSrc, width, height, altText, creative) {
          var iframeBuster = new IFrameBuster_57_03();
          if(!iframeBuster.isBreakoutSuccessful()) {
            var outerDiv = this.toObject("IMAGE_PLACEHOLDER_DIV_" + variableName);
              outerDiv.innerHTML = '<A TARGET="'+target+'" HREF="'+hRef+'"><IMG id="IMG_'+variableName+'" SRC="'+imgSrc+'" width="'+width+'" height="'+height+'" BORDER=0 alt="'+altText+'"/></A>';
            this.trackBackupImageEvent(creative.adserverUrl);
            this.logThirdPartyBackupImageImpression(creative, true);
          } else {
            this.logThirdPartyFlashDisplayImpression(creative, true);
          }
        }
        this.getSalign = function(expandedWidth, expandedHeight, offsetTop,offsetLeft,offsetRight,offsetBottom) {
         var salign = "";
         if (offsetTop == 0 && offsetBottom != expandedHeight) {
           salign += "T";
         } else if (offsetTop != 0 && offsetBottom == expandedHeight) {
           salign += "B";
         }
         if (offsetLeft == 0 && offsetRight != expandedWidth) {
           salign += "L";
         } else if (offsetLeft != 0 && offsetRight == expandedWidth) {
           salign += "R";
         }
         if ((salign == "T" || salign == "B") && (offsetLeft != 0 || offsetRight != expandedWidth)) {
           return "";
         }
         if ((salign == "L" || salign == "R") && (offsetTop != 0 || offsetBottom != expandedHeight)) {
           return "";
         }
         return salign;
        }
      }
      DARTExpandingUtil_57_03.prototype = new RichMediaCore_57_03;
    
document.write('\n      \n              ');

              function PlcrInfo(filename, uid) {
                this.filename = filename;
                this.uniqueId = uid;
              }
              var richMediaPlcrMap = {};
              richMediaPlcrMap["0"] = new PlcrInfo("plcr_1419504_0_1285718599097.js", "1285718592568");
              var richMediaPlcrMap_1285718592568 = richMediaPlcrMap;
              var plcrInfo_1285718592568 = richMediaPlcrMap_1285718592568["229976553"];
              if (!plcrInfo_1285718592568) {
                plcrInfo_1285718592568 = richMediaPlcrMap_1285718592568["0"];
              }
              function RichMediaCreative_1285718592568(type) {
                var core = new RichMediaCore_57_03();
                this.creativeIdentifier = "GlobalTemplate_" + "1285718592568" + (new Date()).getTime();
                this.mtfNoFlush = "".toLowerCase();
                this.globalTemplateVersion = "57_03";
                this.isInterstitial = false;
                this.mediaServer = "http://s0.2mdn.net";
                this.adServer = "http://ad.doubleclick.net";
                this.adserverUrl = "http://ad.doubleclick.net/activity;src=2060153;met=1;v=1;pid=51682862;aid=229976553;ko=0;cid=38614472;rid=38632229;rv=1;";
                this.stringPostingUrl = "http://ad.doubleclick.net/activity;src=2060153;stragg=1;v=1;pid=51682862;aid=229976553;ko=0;cid=38614472;rid=38632229;rv=1;rn=7936480;";
                this.swfParams = 'ct=US&st=VA&ac=757&zp=23503&bw=3&dma=46&city=13400&src=2060153&rv=1&rid=38632229';
                this.renderingId = "38632229";
                this.previewMode = (("%PreviewMode" == "true") ? true : false);
                this.debugEventsMode = (("%DebugEventsMode" == "true") ? true : false);
                this.pubHideObjects = "";
                this.pubHideApplets = "";
                this.mtfInline = ("".toLowerCase() == "true");
                this.pubTop  = core.convertUnit("");
                this.pubLeft = core.convertUnit("");
                this.pubDuration = "";
                this.pubWMode = "";
                this.isRelativeBody = ("" == "relative") ? true : false;
                this.debugJSMode = ("" == "true") ? true : false;
                this.adjustOverflow = ("true" == "true");
                this.asContext = (('' != "") ? ('&keywords=' + '') : "")
                                  + (('' != "") ? ('&latitude=' + '') : "")
                                  + (('' != "") ? ('&longitude=' + '') : "");
                this.clickThroughUrl = "http://ad.doubleclick.net/click%3Bh%3Dv8/3a3e/7/75/%2a/s%3B229976553%3B0-0%3B0%3B51682862%3B3454-728/90%3B38614472/38632229/1%3B%3B%7Esscs%3D%3fhttp%3A//gannett.gcion.com/adlink%2F5111%2F1263064%2F0%2F225%2FAdId%3D1072617%3BBnId%3D2%3Bitime%3D31172261%3Blink%3D";
                this.clickN = "";
                this.type = type;
                this.uniqueId = plcrInfo_1285718592568.uniqueId;
                this.thirdPartyImpUrl = "";
                this.thirdPartyFlashDisplayUrl = "";
                this.thirdPartyBackupImpUrl = "";
                this.surveyUrl = "";
                this.googleContextDiscoveryUrl = "http://pagead2.googlesyndication.com/pagead/ads?client=dclk-3pas-query&output=xml&geo=true";
                this.livePreviewSiteUrl = "%LivePreviewSiteUrl";
                this.customScriptFileUrl = "";
                this.servingMethod = "j";
                if(this.previewMode && this.googleContextDiscoveryUrl.indexOf("adtest=on") == -1) {
                  this.googleContextDiscoveryUrl += "&adtest=on";
                }
                this.macro_j = "0-2079922656";
                this.macro_eenv = "j";
                this.macro_g = "ct=US&st=VA&ac=757&zp=23503&bw=3&dma=46&city=13400";
                this.macro_s = "N4518.USA_Today";
                this.macro_eaid = "229976553";
                this.macro_n = "7936480";
                this.macro_m = "0";
                this.macro_erid = "38632229";
                this.macro_ebuy = "4748135";
                this.macro_ecid = "38614472";
                this.macro_erv = "1";
                this.macro_epid = "51682862";
                this.macro_eadv = "2060153";
                this.macro_esid = "450437";
                this.macro_ekid = "0";
              }
              eval("RichMediaCreative_"+plcrInfo_1285718592568.uniqueId+" = RichMediaCreative_1285718592568;");
              
document.write('\n          \n              ');

              function generateExpandingFlashCode() {
                var core = new RichMediaCore_57_03();
                var creative = new RichMediaCreative_1285718592568(core.CREATIVE_TYPE_EXPANDING);
                RichMediaCreative_1285718592568.prototype.csiBaseline = new Date().getTime();
                RichMediaCreative_1285718592568.prototype.csiAdRespTime =
                    isNaN("") ? -1 : RichMediaCreative_1285718592568.prototype.csiBaseline - parseFloat("");
				core.logThirdPartyImpression(creative);
                if(core.isBrowserComplient(9)) {
                  var mediaServer = "http://s0.2mdn.net";
                  var altImgTarget = "_blank";
                  var altImgHRef = "http://ad.doubleclick.net/activity;src%3D2060153%3Bmet%3D1%3Bv%3D1%3Bpid%3D51682862%3Baid%3D229976553%3Bko%3D0%3Bcid%3D38614472%3Brid%3D38632229%3Brv%3D1%3Bcs%3Dq%3Beid1%3D408011%3Becn1%3D1%3Betm1%3D0%3B_dc_redir%3Durl%3fhttp://ad.doubleclick.net/click%3Bh%3Dv8/3a3e/7/75/%2a/s%3B229976553%3B0-0%3B0%3B51682862%3B3454-728/90%3B38614472/38632229/1%3B%3B%7Esscs%3D%3fhttp%3A//gannett.gcion.com/adlink%2F5111%2F1263064%2F0%2F225%2FAdId%3D1072617%3BBnId%3D2%3Bitime%3D31172261%3Blink%3Dhttp://www.princess.com/learn/cruise_vacationing/escape_completely/index.html?IgnBnr=16&utm_source=standard&utm_content=Ship_Flags_Watch_more_videos&utm_medium=banner&utm_campaign=Brand_Fall_2010";
                  var altImgSrc = "http://s0.2mdn.net/2060153/PID_1419504_backup728x90.jpg";
                  var altImgWidth = "728";
                  var altImgHeight = "90";
                  var altImgAltText = "";
                  var expandingUtil = new DARTExpandingUtil_57_03();
                  var iframeBuster = new IFrameBuster_57_03();
                  var plcrJs = "http://s0.2mdn.net/2060153/" + plcrInfo_1285718592568.filename;
                  if(iframeBuster.isInIFrame()) {
                    var iframeJs = "http://s0.2mdn.net/879366/expandingIframeGlobalTemplate_v2_57_03"
                        + (creative.debugJSMode ? "_origin" : "" ) + ".js";
                    RichMediaCreative_1285718592568.prototype.globalTemplateJs = iframeJs;
                    iframeBuster.writeIFrame(creative, plcrJs, iframeJs);
                    if(!iframeBuster.isInFriendlyIFrame()) {
                      var variableName = "38632229_1_" + (new Date()).getTime();
                      document.write('<div id="IMAGE_PLACEHOLDER_DIV_' + variableName + '"></div>');
                      expandingUtil.displayImageOnBreakoutFailure(variableName, altImgTarget, altImgHRef, altImgSrc, altImgWidth, altImgHeight, altImgAltText, creative);
                    }
                  }
                  else {
                    if(creative.customScriptFileUrl != "") {
                      document.write('<scr' + 'ipt src="' + creative.customScriptFileUrl + '" language="JavaScript"></scr' + 'ipt>');
                    }
                    RichMediaCreative_1285718592568.prototype.globalTemplateJs = "http://s0.2mdn.net/879366/expandingGlobalTemplate_v2_57_03"
                        + (creative.debugJSMode ? "_origin" : "" ) + ".js";
                    RichMediaCore_57_03.prototype.trackCsiEvent("pb");  
                    document.write('<scr' + 'ipt src="' + plcrJs + '" language="JavaScript"></scr' + 'ipt>');
                  }
                }
                else {
                  document.write('<A TARGET="_blank" HREF="http://ad.doubleclick.net/activity;src%3D2060153%3Bmet%3D1%3Bv%3D1%3Bpid%3D51682862%3Baid%3D229976553%3Bko%3D0%3Bcid%3D38614472%3Brid%3D38632229%3Brv%3D1%3Bcs%3Dq%3Beid1%3D408011%3Becn1%3D1%3Betm1%3D0%3B_dc_redir%3Durl%3fhttp://ad.doubleclick.net/click%3Bh%3Dv8/3a3e/7/75/%2a/s%3B229976553%3B0-0%3B0%3B51682862%3B3454-728/90%3B38614472/38632229/1%3B%3B%7Esscs%3D%3fhttp%3A//gannett.gcion.com/adlink%2F5111%2F1263064%2F0%2F225%2FAdId%3D1072617%3BBnId%3D2%3Bitime%3D31172261%3Blink%3Dhttp://www.princess.com/learn/cruise_vacationing/escape_completely/index.html?IgnBnr=16&utm_source=standard&utm_content=Ship_Flags_Watch_more_videos&utm_medium=banner&utm_campaign=Brand_Fall_2010"><IMG id="IMG_'+ variableName +'" SRC="http://s0.2mdn.net/2060153/PID_1419504_backup728x90.jpg" width="728" height="90" BORDER=0 alt=""/></A>');
                  core.trackBackupImageEvent(creative.adserverUrl);
                  core.logThirdPartyBackupImageImpression(creative, false);
                }
                core.writeSurveyURL(creative);
              }
              generateExpandingFlashCode();
              
document.write('\n            <NOSCRIPT>\n              <A TARGET=\"_blank\" HREF=\"http://ad.doubleclick.net/activity;src%3D2060153%3Bmet%3D1%3Bv%3D1%3Bpid%3D51682862%3Baid%3D229976553%3Bko%3D0%3Bcid%3D38614472%3Brid%3D38632229%3Brv%3D1%3Bcs%3Dq%3Beid1%3D408011%3Becn1%3D1%3Betm1%3D0%3B_dc_redir%3Durl%3fhttp://ad.doubleclick.net/click%3Bh%3Dv8/3a3e/7/75/%2a/s%3B229976553%3B0-0%3B0%3B51682862%3B3454-728/90%3B38614472/38632229/1%3B%3B%7Esscs%3D%3fhttp%3A//gannett.gcion.com/adlink%2F5111%2F1263064%2F0%2F225%2FAdId%3D1072617%3BBnId%3D2%3Bitime%3D31172261%3Blink%3Dhttp://www.princess.com/learn/cruise_vacationing/escape_completely/index.html?IgnBnr=16&utm_source=standard&utm_content=Ship_Flags_Watch_more_videos&utm_medium=banner&utm_campaign=Brand_Fall_2010\">\n              <IMG SRC=\"http://s0.2mdn.net/2060153/PID_1419504_backup728x90.jpg\" width=\"728\" height=\"90\" BORDER=\"0\" alt=\"\">\n              </A>\n              <IMG SRC=\"http://ad.doubleclick.net/activity;src=2060153;met=1;v=1;pid=51682862;aid=229976553;ko=0;cid=38614472;rid=38632229;rv=1;&timestamp=7936480;eid1=9;ecn1=1;etm1=0;\" width=\"0px\" height=\"0px\" style=\"visibility:hidden\" BORDER=\"0\"/>\n              <IMG SRC=\"\" width=\"0px\" height=\"0px\" style=\"visibility:hidden\" BORDER=\"0\"/>\n              <IMG SRC=\"\" width=\"0px\" height=\"0px\" style=\"visibility:hidden\" BORDER=\"0\"/>\n            </NOSCRIPT>\n            ');

              var core = new RichMediaCore_57_03();
              if(core.isInMsnAjaxEnvironment()) {
                window.setTimeout("document.close();", 1000);
              }
            
document.write('\n');
