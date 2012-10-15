/*=================================================
 *
 * Coding standards:
 *
 * We aim towards Douglas Crockford's Javascript conventions.
 * See:  http://javascript.crockford.com/code.html
 * See also: http://www.crockford.com/javascript/javascript.html
 *
 * That said, this JS code was written before some recent JS
 * support libraries became widely used or available.
 * In particular, the _ character is used to indicate a class function or
 * variable that should be considered private to the class.
 *
 * The code mostly uses accessor methods for getting/setting the private
 * class variables.
 *
 * Over time, we'd like to formalize the convention by using support libraries
 * which enforce privacy in objects.
 *
 * We also want to use jslint:  http://www.jslint.com/
 *
 *
 *==================================================
 */



/*==================================================
 *  Timeline VERSION
 *==================================================
 */
// Note: version is also stored in the build.xml file
Timeline.version = 'pre 2.4.0';  // use format 'pre 1.2.3' for trunk versions
Timeline.ajax_lib_version = SimileAjax.version;
Timeline.display_version = Timeline.version + ' (with Ajax lib ' + Timeline.ajax_lib_version + ')';
 // cf method Timeline.writeVersion

/*==================================================
 *  Timeline
 *==================================================
 */
Timeline.strings = {}; // localization string tables
Timeline.HORIZONTAL = 0;
Timeline.VERTICAL = 1;
Timeline._defaultTheme = null;

Timeline.getDefaultLocale = function() {
    return Timeline.clientLocale;
};

Timeline.create = function(elmt, bandInfos, orientation, unit) {
    if (Timeline.timelines == null) {
        Timeline.timelines = [];
        // Timeline.timelines array can have null members--Timelines that
        // once existed on the page, but were later disposed of.
    }

    var timelineID = Timeline.timelines.length;
    Timeline.timelines[timelineID] = null; // placeholder until we have the object
    var new_tl = new Timeline._Impl(elmt, bandInfos, orientation, unit,
      timelineID);
    Timeline.timelines[timelineID] = new_tl;
    return new_tl;
};

Timeline.createBandInfo = function(params) {
    var theme = ("theme" in params) ? params.theme : Timeline.getDefaultTheme();

    var decorators = ("decorators" in params) ? params.decorators : [];

    var eventSource = ("eventSource" in params) ? params.eventSource : null;

    var ether = new Timeline.LinearEther({
        centersOn:          ("date" in params) ? params.date : new Date(),
        interval:           SimileAjax.DateTime.gregorianUnitLengths[params.intervalUnit],
        pixelsPerInterval:  params.intervalPixels,
        theme:              theme
    });

    var etherPainter = new Timeline.GregorianEtherPainter({
        unit:       params.intervalUnit,
        multiple:   ("multiple" in params) ? params.multiple : 1,
        theme:      theme,
        align:      ("align" in params) ? params.align : undefined
    });

    var eventPainterParams = {
        showText:   ("showEventText" in params) ? params.showEventText : true,
        theme:      theme
    };
    // pass in custom parameters for the event painter
    if ("eventPainterParams" in params) {
        for (var prop in params.eventPainterParams) {
            eventPainterParams[prop] = params.eventPainterParams[prop];
        }
    }

    if ("trackHeight" in params) {
        eventPainterParams.trackHeight = params.trackHeight;
    }
    if ("trackGap" in params) {
        eventPainterParams.trackGap = params.trackGap;
    }

    var layout = ("overview" in params && params.overview) ? "overview" : ("layout" in params ? params.layout : "original");
    var eventPainter;
    if ("eventPainter" in params) {
        eventPainter = new params.eventPainter(eventPainterParams);
    } else {
        switch (layout) {
            case "overview" :
                eventPainter = new Timeline.OverviewEventPainter(eventPainterParams);
                break;
            case "detailed" :
                eventPainter = new Timeline.DetailedEventPainter(eventPainterParams);
                break;
            default:
                eventPainter = new Timeline.OriginalEventPainter(eventPainterParams);
        }
    }

    return {
        width:          params.width,
        eventSource:    eventSource,
        timeZone:       ("timeZone" in params) ? params.timeZone : 0,
        ether:          ether,
        etherPainter:   etherPainter,
        eventPainter:   eventPainter,
        theme:          theme,
        decorators:     decorators,
        zoomIndex:      ("zoomIndex" in params) ? params.zoomIndex : 0,
        zoomSteps:      ("zoomSteps" in params) ? params.zoomSteps : null
    };
};

Timeline.createHotZoneBandInfo = function(params) {
    var theme = ("theme" in params) ? params.theme : Timeline.getDefaultTheme();

    var eventSource = ("eventSource" in params) ? params.eventSource : null;

    var ether = new Timeline.HotZoneEther({
        centersOn:          ("date" in params) ? params.date : new Date(),
        interval:           SimileAjax.DateTime.gregorianUnitLengths[params.intervalUnit],
        pixelsPerInterval:  params.intervalPixels,
        zones:              params.zones,
        theme:              theme
    });

    var etherPainter = new Timeline.HotZoneGregorianEtherPainter({
        unit:       params.intervalUnit,
        zones:      params.zones,
        theme:      theme,
        align:      ("align" in params) ? params.align : undefined
    });

    var eventPainterParams = {
        showText:   ("showEventText" in params) ? params.showEventText : true,
        theme:      theme
    };
    // pass in custom parameters for the event painter
    if ("eventPainterParams" in params) {
        for (var prop in params.eventPainterParams) {
            eventPainterParams[prop] = params.eventPainterParams[prop];
        }
    }
    if ("trackHeight" in params) {
        eventPainterParams.trackHeight = params.trackHeight;
    }
    if ("trackGap" in params) {
        eventPainterParams.trackGap = params.trackGap;
    }

    var layout = ("overview" in params && params.overview) ? "overview" : ("layout" in params ? params.layout : "original");
    var eventPainter;
    if ("eventPainter" in params) {
        eventPainter = new params.eventPainter(eventPainterParams);
    } else {
        switch (layout) {
            case "overview" :
                eventPainter = new Timeline.OverviewEventPainter(eventPainterParams);
                break;
            case "detailed" :
                eventPainter = new Timeline.DetailedEventPainter(eventPainterParams);
                break;
            default:
                eventPainter = new Timeline.OriginalEventPainter(eventPainterParams);
        }
    }
    return {
        width:          params.width,
        eventSource:    eventSource,
        timeZone:       ("timeZone" in params) ? params.timeZone : 0,
        ether:          ether,
        etherPainter:   etherPainter,
        eventPainter:   eventPainter,
        theme:          theme,
        zoomIndex:      ("zoomIndex" in params) ? params.zoomIndex : 0,
        zoomSteps:      ("zoomSteps" in params) ? params.zoomSteps : null
    };
};

Timeline.getDefaultTheme = function() {
    if (Timeline._defaultTheme == null) {
        Timeline._defaultTheme = Timeline.ClassicTheme.create(Timeline.getDefaultLocale());
    }
    return Timeline._defaultTheme;
};

Timeline.setDefaultTheme = function(theme) {
    Timeline._defaultTheme = theme;
};

Timeline.loadXML = function(url, f) {
    var fError = function(statusText, status, xmlhttp) {
        alert("Failed to load data xml from " + url + "\n" + statusText);
    };
    var fDone = function(xmlhttp) {
        var xml = xmlhttp.responseXML;
        if (!xml.documentElement && xmlhttp.responseStream) {
            xml.load(xmlhttp.responseStream);
        }
        f(xml, url);
    };
    SimileAjax.XmlHttp.get(url, fError, fDone);
};


Timeline.loadJSON = function(url, f) {
    var fError = function(statusText, status, xmlhttp) {
        alert("Failed to load json data from " + url + "\n" + statusText);
    };
    var fDone = function(xmlhttp) {
        f(eval('(' + xmlhttp.responseText + ')'), url);
    };
    SimileAjax.XmlHttp.get(url, fError, fDone);
};

Timeline.getTimelineFromID = function(timelineID) {
    return Timeline.timelines[timelineID];
};

// Write the current Timeline version as the contents of element with id el_id
Timeline.writeVersion = function(el_id) {
  document.getElementById(el_id).innerHTML = this.display_version;
};



/*==================================================
 *  Timeline Implementation object
 *==================================================
 */
Timeline._Impl = function(elmt, bandInfos, orientation, unit, timelineID) {
    SimileAjax.WindowManager.initialize();

    this._containerDiv = elmt;

    this._bandInfos = bandInfos;
    this._orientation = orientation == null ? Timeline.HORIZONTAL : orientation;
    this._unit = (unit != null) ? unit : SimileAjax.NativeDateUnit;
    this._starting = true; // is the Timeline being created? Used by autoWidth
                           // functions
    this._autoResizing = false;

    // autoWidth is a "public" property of the Timeline object
    this.autoWidth = bandInfos && bandInfos[0] && bandInfos[0].theme &&
                     bandInfos[0].theme.autoWidth;
    this.autoWidthAnimationTime = bandInfos && bandInfos[0] && bandInfos[0].theme &&
                     bandInfos[0].theme.autoWidthAnimationTime;
    this.timelineID = timelineID; // also public attribute
    this.timeline_start = bandInfos && bandInfos[0] && bandInfos[0].theme &&
                     bandInfos[0].theme.timeline_start;
    this.timeline_stop  = bandInfos && bandInfos[0] && bandInfos[0].theme &&
                     bandInfos[0].theme.timeline_stop;
    this.timeline_at_start = false; // already at start or stop? Then won't
    this.timeline_at_stop = false;  // try to move further in the wrong direction

    this._initialize();
};

//
// Public functions used by client sw
//
Timeline._Impl.prototype.dispose = function() {
    for (var i = 0; i < this._bands.length; i++) {
        this._bands[i].dispose();
    }
    this._bands = null;
    this._bandInfos = null;
    this._containerDiv.innerHTML = "";
    // remove from array of Timelines
    Timeline.timelines[this.timelineID] = null;
};

Timeline._Impl.prototype.getBandCount = function() {
    return this._bands.length;
};

Timeline._Impl.prototype.getBand = function(index) {
    return this._bands[index];
};

Timeline._Impl.prototype.finishedEventLoading = function() {
    // Called by client after events have been loaded into Timeline
    // Only used if the client has set autoWidth
    // Sets width to Timeline's requested amount and will shrink down the div if
    // need be.
    this._autoWidthCheck(true);
    this._starting = false;
};

Timeline._Impl.prototype.layout = function() {
    // called by client when browser is resized
    this._autoWidthCheck(true);
    this._distributeWidths();
};

Timeline._Impl.prototype.paint = function() {
    for (var i = 0; i < this._bands.length; i++) {
        this._bands[i].paint();
    }
};

Timeline._Impl.prototype.getDocument = function() {
    return this._containerDiv.ownerDocument;
};

Timeline._Impl.prototype.addDiv = function(div) {
    this._containerDiv.appendChild(div);
};

Timeline._Impl.prototype.removeDiv = function(div) {
    this._containerDiv.removeChild(div);
};

Timeline._Impl.prototype.isHorizontal = function() {
    return this._orientation == Timeline.HORIZONTAL;
};

Timeline._Impl.prototype.isVertical = function() {
    return this._orientation == Timeline.VERTICAL;
};

Timeline._Impl.prototype.getPixelLength = function() {
    return this._orientation == Timeline.HORIZONTAL ?
        this._containerDiv.offsetWidth : this._containerDiv.offsetHeight;
};

Timeline._Impl.prototype.getPixelWidth = function() {
    return this._orientation == Timeline.VERTICAL ?
        this._containerDiv.offsetWidth : this._containerDiv.offsetHeight;
};

Timeline._Impl.prototype.getUnit = function() {
    return this._unit;
};

Timeline._Impl.prototype.getWidthStyle = function() {
    // which element.style attribute should be changed to affect Timeline's "width"
    return this._orientation == Timeline.HORIZONTAL ? 'height' : 'width';
};

Timeline._Impl.prototype.loadXML = function(url, f) {
    var tl = this;


    var fError = function(statusText, status, xmlhttp) {
        alert("Failed to load data xml from " + url + "\n" + statusText);
        tl.hideLoadingMessage();
    };
    var fDone = function(xmlhttp) {
        try {
            var xml = xmlhttp.responseXML;
            if (!xml.documentElement && xmlhttp.responseStream) {
                xml.load(xmlhttp.responseStream);
            }
            f(xml, url);
        } finally {
            tl.hideLoadingMessage();
        }
    };

    this.showLoadingMessage();
    window.setTimeout(function() { SimileAjax.XmlHttp.get(url, fError, fDone); }, 0);
};

Timeline._Impl.prototype.loadJSON = function(url, f) {
    var tl = this;

    var fError = function(statusText, status, xmlhttp) {
        alert("Failed to load json data from " + url + "\n" + statusText);
        tl.hideLoadingMessage();
    };
    var fDone = function(xmlhttp) {
        try {
            f(eval('(' + xmlhttp.responseText + ')'), url);
        } finally {
            tl.hideLoadingMessage();
        }
    };

    this.showLoadingMessage();
    window.setTimeout(function() { SimileAjax.XmlHttp.get(url, fError, fDone); }, 0);
};


//
// Private functions used by Timeline object functions
//

Timeline._Impl.prototype._autoWidthScrollListener = function(band) {
    band.getTimeline()._autoWidthCheck(false);
};

// called to re-calculate auto width and adjust the overall Timeline div if needed
Timeline._Impl.prototype._autoWidthCheck = function(okToShrink) {
    var timeline = this; // this Timeline
    var immediateChange = timeline._starting;
    var newWidth = 0;

    function changeTimelineWidth() {
        var widthStyle = timeline.getWidthStyle();
        if (immediateChange) {
            timeline._containerDiv.style[widthStyle] = newWidth + 'px';
        } else {
        	  // animate change
        	  timeline._autoResizing = true;
        	  var animateParam ={};
        	  animateParam[widthStyle] = newWidth + 'px';

        	  SimileAjax.jQuery(timeline._containerDiv).animate(
        	      animateParam, timeline.autoWidthAnimationTime,
        	      'linear', function(){timeline._autoResizing = false;});
        }
    }

    function checkTimelineWidth() {
        var targetWidth = 0; // the new desired width
        var currentWidth = timeline.getPixelWidth();

        if (timeline._autoResizing) {
        	return; // early return
        }

        // compute targetWidth
        for (var i = 0; i < timeline._bands.length; i++) {
            timeline._bands[i].checkAutoWidth();
            targetWidth += timeline._bandInfos[i].width;
        }

        if (targetWidth > currentWidth || okToShrink) {
            // yes, let's change the size
            newWidth = targetWidth;
            changeTimelineWidth();
            timeline._distributeWidths();
        }
    }

    // function's mainline
    if (!timeline.autoWidth) {
        return; // early return
    }

    checkTimelineWidth();
};

Timeline._Impl.prototype._initialize = function() {
    var containerDiv = this._containerDiv;
    var doc = containerDiv.ownerDocument;

    containerDiv.className =
        containerDiv.className.split(" ").concat("timeline-container").join(" ");

	/**
	 * Set css-class on container div that will define orientation
	 */
	var orientation = (this.isHorizontal()) ? 'horizontal' : 'vertical'
	containerDiv.className +=' timeline-'+orientation;


    while (containerDiv.firstChild) {
        containerDiv.removeChild(containerDiv.firstChild);
    }

    /*
     *  inserting copyright and link
     */
    var elmtCopyright = SimileAjax.Graphics.createTranslucentImage(Timeline.urlPrefix + (this.isHorizontal() ? "images/copyright-vertical.png" : "images/copyright.png"));
    elmtCopyright.className = "timeline-copyright";
    elmtCopyright.title = "SIMILE Timeline - http://www.simile-widgets.org/";
    SimileAjax.DOM.registerEvent(elmtCopyright, "click", function() { window.location = "http://www.simile-widgets.org/"; });
    containerDiv.appendChild(elmtCopyright);

    /*
     *  creating bands
     */
    this._bands = [];
    for (var i = 0; i < this._bandInfos.length; i++) {
        var band = new Timeline._Band(this, this._bandInfos[i], i);
        this._bands.push(band);
    }
    this._distributeWidths();

    /*
     *  sync'ing bands
     */
    for (var i = 0; i < this._bandInfos.length; i++) {
        var bandInfo = this._bandInfos[i];
        if ("syncWith" in bandInfo) {
            this._bands[i].setSyncWithBand(
                this._bands[bandInfo.syncWith],
                ("highlight" in bandInfo) ? bandInfo.highlight : false
            );
        }
    }


    if (this.autoWidth) {
        for (var i = 0; i < this._bands.length; i++) {
            this._bands[i].addOnScrollListener(this._autoWidthScrollListener);
        }
    }


    /*
     *  creating loading UI
     */
    var message = SimileAjax.Graphics.createMessageBubble(doc);
    message.containerDiv.className = "timeline-message-container";
    containerDiv.appendChild(message.containerDiv);

    message.contentDiv.className = "timeline-message";
    message.contentDiv.innerHTML = "<img src='" + Timeline.urlPrefix + "images/progress-running.gif' /> Loading...";

    this.showLoadingMessage = function() { message.containerDiv.style.display = "block"; };
    this.hideLoadingMessage = function() { message.containerDiv.style.display = "none"; };
};

Timeline._Impl.prototype._distributeWidths = function() {
    var length = this.getPixelLength();
    var width = this.getPixelWidth();
    var cumulativeWidth = 0;

    for (var i = 0; i < this._bands.length; i++) {
        var band = this._bands[i];
        var bandInfos = this._bandInfos[i];
        var widthString = bandInfos.width;
        var bandWidth;

        if (typeof widthString == 'string') {
          var x =  widthString.indexOf("%");
          if (x > 0) {
              var percent = parseInt(widthString.substr(0, x));
              bandWidth = Math.round(percent * width / 100);
          } else {
              bandWidth = parseInt(widthString);
          }
        } else {
        	// was given an integer
        	bandWidth = widthString;
        }

        band.setBandShiftAndWidth(cumulativeWidth, bandWidth);
        band.setViewLength(length);

        cumulativeWidth += bandWidth;
    }
};

Timeline._Impl.prototype.shiftOK = function(index, shift) {
    // Returns true if the proposed shift is ok
    //
    // Positive shift means going back in time
    var going_back = shift > 0,
        going_forward = shift < 0;

    // Is there an edge?
    if ((going_back    && this.timeline_start == null) ||
        (going_forward && this.timeline_stop  == null) ||
        (shift == 0)) {
        return (true);  // early return
    }

    // If any of the bands has noted that it is changing the others,
    // then this shift is a secondary shift in reaction to the real shift,
    // which already happened. In such cases, ignore it. (The issue is
    // that a positive original shift can cause a negative secondary shift,
    // as the bands adjust.)
    var secondary_shift = false;
    for (var i = 0; i < this._bands.length && !secondary_shift; i++) {
       secondary_shift = this._bands[i].busy();
    }
    if (secondary_shift) {
        return(true); // early return
    }

    // If we are already at an edge, then don't even think about going any further
    if ((going_back    && this.timeline_at_start) ||
        (going_forward && this.timeline_at_stop)) {
        return (false);  // early return
    }

    // Need to check all the bands
    var ok = false; // return value
    // If any of the bands will be or are showing an ok date, then let the shift proceed.
    for (var i = 0; i < this._bands.length && !ok; i++) {
       var band = this._bands[i];
       if (going_back) {
           ok = (i == index ? band.getMinVisibleDateAfterDelta(shift) : band.getMinVisibleDate())
                >= this.timeline_start;
       } else {
           ok = (i == index ? band.getMaxVisibleDateAfterDelta(shift) : band.getMaxVisibleDate())
                <= this.timeline_stop;
       }
    }

    // process results
    if (going_back) {
       this.timeline_at_start = !ok;
       this.timeline_at_stop = false;
    } else {
       this.timeline_at_stop = !ok;
       this.timeline_at_start = false;
    }
    // This is where you could have an effect once per hitting an
    // edge of the Timeline. Eg jitter the Timeline
    //if (!ok) {
        //alert(going_back ? "At beginning" : "At end");
    //}
    return (ok);
};

Timeline._Impl.prototype.zoom = function (zoomIn, x, y, target) {
  var matcher = new RegExp("^timeline-band-([0-9]+)$");
  var bandIndex = null;

  var result = matcher.exec(target.id);
  if (result) {
    bandIndex = parseInt(result[1]);
  }

  if (bandIndex != null) {
    this._bands[bandIndex].zoom(zoomIn, x, y, target);
  }

  this.paint();
};

