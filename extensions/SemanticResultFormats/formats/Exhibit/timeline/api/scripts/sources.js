/*==================================================
 *  Default Event Source
 *==================================================
 */


Timeline.DefaultEventSource = function(eventIndex) {
    this._events = (eventIndex instanceof Object) ? eventIndex : new SimileAjax.EventIndex();
    this._listeners = [];
};

Timeline.DefaultEventSource.prototype.addListener = function(listener) {
    this._listeners.push(listener);
};

Timeline.DefaultEventSource.prototype.removeListener = function(listener) {
    for (var i = 0; i < this._listeners.length; i++) {
        if (this._listeners[i] == listener) {
            this._listeners.splice(i, 1);
            break;
        }
    }
};

Timeline.DefaultEventSource.prototype.loadXML = function(xml, url) {
    var base = this._getBaseURL(url);

    var wikiURL = xml.documentElement.getAttribute("wiki-url");
    var wikiSection = xml.documentElement.getAttribute("wiki-section");

    var dateTimeFormat = xml.documentElement.getAttribute("date-time-format");
    var parseDateTimeFunction = this._events.getUnit().getParser(dateTimeFormat);

    var node = xml.documentElement.firstChild;
    var added = false;
    while (node != null) {
        if (node.nodeType == 1) {
            var description = "";
            if (node.firstChild != null && node.firstChild.nodeType == 3) {
                description = node.firstChild.nodeValue;
            }
            // instant event: default is true. Or use values from isDuration or durationEvent
            var instant = (node.getAttribute("isDuration")    === null &&
                           node.getAttribute("durationEvent") === null) ||
                          node.getAttribute("isDuration") == "false" ||
                          node.getAttribute("durationEvent") == "false";

            var evt = new Timeline.DefaultEventSource.Event( {
                          id: node.getAttribute("id"),
                       start: parseDateTimeFunction(node.getAttribute("start")),
                         end: parseDateTimeFunction(node.getAttribute("end")),
                 latestStart: parseDateTimeFunction(node.getAttribute("latestStart")),
                 earliestEnd: parseDateTimeFunction(node.getAttribute("earliestEnd")),
                     instant: instant,
                        text: node.getAttribute("title"),
                 description: description,
                       image: this._resolveRelativeURL(node.getAttribute("image"), base),
                        link: this._resolveRelativeURL(node.getAttribute("link") , base),
                        icon: this._resolveRelativeURL(node.getAttribute("icon") , base),
                       color: node.getAttribute("color"),
                   textColor: node.getAttribute("textColor"),
                   hoverText: node.getAttribute("hoverText"),
                   classname: node.getAttribute("classname"),
                   tapeImage: node.getAttribute("tapeImage"),
                  tapeRepeat: node.getAttribute("tapeRepeat"),
                     caption: node.getAttribute("caption"),
                     eventID: node.getAttribute("eventID"),
                    trackNum: node.getAttribute("trackNum")
            });

            evt._node = node;
            evt.getProperty = function(name) {
                return this._node.getAttribute(name);
            };
            evt.setWikiInfo(wikiURL, wikiSection);

            this._events.add(evt);

            added = true;
        }
        node = node.nextSibling;
    }

    if (added) {
        this._fire("onAddMany", []);
    }
};


Timeline.DefaultEventSource.prototype.loadJSON = function(data, url) {
    var base = this._getBaseURL(url);
    var added = false;
    if (data && data.events){
        var wikiURL = ("wikiURL" in data) ? data.wikiURL : null;
        var wikiSection = ("wikiSection" in data) ? data.wikiSection : null;

        var dateTimeFormat = ("dateTimeFormat" in data) ? data.dateTimeFormat : null;
        var parseDateTimeFunction = this._events.getUnit().getParser(dateTimeFormat);

        for (var i=0; i < data.events.length; i++){
            var evnt = data.events[i];

            // New feature: attribute synonyms. The following attribute names are interchangable.
            // The shorter names enable smaller load files.
            //    eid -- eventID
            //      s -- start
            //      e -- end
            //     ls -- latestStart
            //     ee -- earliestEnd
            //      d -- description
            //     de -- durationEvent
            //      t -- title,
            //      c -- classname

            // Fixing issue 33:
            // instant event: default (for JSON only) is false. Or use values from isDuration or durationEvent
            // isDuration was negated (see issue 33, so keep that interpretation
            var instant = evnt.isDuration ||
                          (('durationEvent' in evnt) && !evnt.durationEvent) ||
                          (('de' in evnt) && !evnt.de);
            var evt = new Timeline.DefaultEventSource.Event({
                          id: ("id" in evnt) ? evnt.id : undefined,
                       start: parseDateTimeFunction(evnt.start || evnt.s),
                         end: parseDateTimeFunction(evnt.end || evnt.e),
                 latestStart: parseDateTimeFunction(evnt.latestStart || evnt.ls),
                 earliestEnd: parseDateTimeFunction(evnt.earliestEnd || evnt.ee),
                     instant: instant,
                        text: evnt.title || evnt.t,
                 description: evnt.description || evnt.d,
                       image: this._resolveRelativeURL(evnt.image, base),
                        link: this._resolveRelativeURL(evnt.link , base),
                        icon: this._resolveRelativeURL(evnt.icon , base),
                       color: evnt.color,
                   textColor: evnt.textColor,
                   hoverText: evnt.hoverText,
                   classname: evnt.classname || evnt.c,
                   tapeImage: evnt.tapeImage,
                  tapeRepeat: evnt.tapeRepeat,
                     caption: evnt.caption,
                     eventID: evnt.eventID  || evnt.eid,
                    trackNum: evnt.trackNum
            });
            evt._obj = evnt;
            evt.getProperty = function(name) {
                return this._obj[name];
            };
            evt.setWikiInfo(wikiURL, wikiSection);

            this._events.add(evt);
            added = true;
        }
    }

    if (added) {
        this._fire("onAddMany", []);
    }
};

/*
 *  Contributed by Morten Frederiksen, http://www.wasab.dk/morten/
 */
Timeline.DefaultEventSource.prototype.loadSPARQL = function(xml, url) {
    var base = this._getBaseURL(url);

    var dateTimeFormat = 'iso8601';
    var parseDateTimeFunction = this._events.getUnit().getParser(dateTimeFormat);

    if (xml == null) {
        return;
    }

    /*
     *  Find <results> tag
     */
    var node = xml.documentElement.firstChild;
    while (node != null && (node.nodeType != 1 || node.nodeName != 'results')) {
        node = node.nextSibling;
    }

    var wikiURL = null;
    var wikiSection = null;
    if (node != null) {
        wikiURL = node.getAttribute("wiki-url");
        wikiSection = node.getAttribute("wiki-section");

        node = node.firstChild;
    }

    var added = false;
    while (node != null) {
        if (node.nodeType == 1) {
            var bindings = { };
            var binding = node.firstChild;
            while (binding != null) {
                if (binding.nodeType == 1 &&
                    binding.firstChild != null &&
                    binding.firstChild.nodeType == 1 &&
                    binding.firstChild.firstChild != null &&
                    binding.firstChild.firstChild.nodeType == 3) {
                    bindings[binding.getAttribute('name')] = binding.firstChild.firstChild.nodeValue;
                }
                binding = binding.nextSibling;
            }

            if (bindings["start"] == null && bindings["date"] != null) {
                bindings["start"] = bindings["date"];
            }

            // instant event: default is true. Or use values from isDuration or durationEvent
            var instant = (bindings["isDuration"]    === null &&
                           bindings["durationEvent"] === null) ||
                          bindings["isDuration"] == "false" ||
                          bindings["durationEvent"] == "false";

            var evt = new Timeline.DefaultEventSource.Event({
                          id: bindings["id"],
                       start: parseDateTimeFunction(bindings["start"]),
                         end: parseDateTimeFunction(bindings["end"]),
                 latestStart: parseDateTimeFunction(bindings["latestStart"]),
                 earliestEnd: parseDateTimeFunction(bindings["earliestEnd"]),
                     instant: instant, // instant
                        text: bindings["title"], // text
                 description: bindings["description"],
                       image: this._resolveRelativeURL(bindings["image"], base),
                        link: this._resolveRelativeURL(bindings["link"] , base),
                        icon: this._resolveRelativeURL(bindings["icon"] , base),
                       color: bindings["color"],
                   textColor: bindings["textColor"],
                   hoverText: bindings["hoverText"],
                     caption: bindings["caption"],
                   classname: bindings["classname"],
                   tapeImage: bindings["tapeImage"],
                  tapeRepeat: bindings["tapeRepeat"],
                     eventID: bindings["eventID"],
                    trackNum: bindings["trackNum"]
            });
            evt._bindings = bindings;
            evt.getProperty = function(name) {
                return this._bindings[name];
            };
            evt.setWikiInfo(wikiURL, wikiSection);

            this._events.add(evt);
            added = true;
        }
        node = node.nextSibling;
    }

    if (added) {
        this._fire("onAddMany", []);
    }
};

Timeline.DefaultEventSource.prototype.add = function(evt) {
    this._events.add(evt);
    this._fire("onAddOne", [evt]);
};

Timeline.DefaultEventSource.prototype.addMany = function(events) {
    for (var i = 0; i < events.length; i++) {
        this._events.add(events[i]);
    }
    this._fire("onAddMany", []);
};

Timeline.DefaultEventSource.prototype.clear = function() {
    this._events.removeAll();
    this._fire("onClear", []);
};

Timeline.DefaultEventSource.prototype.getEvent = function(id) {
    return this._events.getEvent(id);
};

Timeline.DefaultEventSource.prototype.getEventIterator = function(startDate, endDate) {
    return this._events.getIterator(startDate, endDate);
};

Timeline.DefaultEventSource.prototype.getEventReverseIterator = function(startDate, endDate) {
    return this._events.getReverseIterator(startDate, endDate);
};

Timeline.DefaultEventSource.prototype.getAllEventIterator = function() {
    return this._events.getAllIterator();
};

Timeline.DefaultEventSource.prototype.getCount = function() {
    return this._events.getCount();
};

Timeline.DefaultEventSource.prototype.getEarliestDate = function() {
    return this._events.getEarliestDate();
};

Timeline.DefaultEventSource.prototype.getLatestDate = function() {
    return this._events.getLatestDate();
};

Timeline.DefaultEventSource.prototype._fire = function(handlerName, args) {
    for (var i = 0; i < this._listeners.length; i++) {
        var listener = this._listeners[i];
        if (handlerName in listener) {
            try {
                listener[handlerName].apply(listener, args);
            } catch (e) {
                SimileAjax.Debug.exception(e);
            }
        }
    }
};

Timeline.DefaultEventSource.prototype._getBaseURL = function(url) {
    if (url.indexOf("://") < 0) {
        var url2 = this._getBaseURL(document.location.href);
        if (url.substr(0,1) == "/") {
            url = url2.substr(0, url2.indexOf("/", url2.indexOf("://") + 3)) + url;
        } else {
            url = url2 + url;
        }
    }

    var i = url.lastIndexOf("/");
    if (i < 0) {
        return "";
    } else {
        return url.substr(0, i+1);
    }
};

Timeline.DefaultEventSource.prototype._resolveRelativeURL = function(url, base) {
    if (url == null || url == "") {
        return url;
    } else if (url.indexOf("://") > 0) {
        return url;
    } else if (url.substr(0,1) == "/") {
        return base.substr(0, base.indexOf("/", base.indexOf("://") + 3)) + url;
    } else {
        return base + url;
    }
};


Timeline.DefaultEventSource.Event = function(args) {
  //
  // Attention developers!
  // If you add a new event attribute, please be sure to add it to
  // all three load functions: loadXML, loadSPARCL, loadJSON.
  // Thanks!
  //
  // args is a hash/object. It supports the following keys. Most are optional
  //   id            -- an internal id. Really shouldn't be used by events.
  //                    Timeline library clients should use eventID
  //   eventID       -- For use by library client when writing custom painters or
  //                    custom fillInfoBubble
  //   start
  //   end
  //   latestStart
  //   earliestEnd
  //   instant      -- boolean. Controls precise/non-precise logic & duration/instant issues
  //   text         -- event source attribute 'title' -- used as the label on Timelines and in bubbles.
  //   description  -- used in bubbles
  //   image        -- used in bubbles
  //   link         -- used in bubbles
  //   icon         -- on the Timeline
  //   color        -- Timeline label and tape color
  //   textColor    -- Timeline label color, overrides color attribute
  //   hoverText    -- deprecated, here for backwards compatibility.
  //                   Superceeded by caption
  //   caption      -- tooltip-like caption on the Timeline. Uses HTML title attribute
  //   classname    -- used to set classname in Timeline. Enables better CSS selector rules
  //   tapeImage    -- background image of the duration event's tape div on the Timeline
  //   tapeRepeat   -- repeat attribute for tapeImage. {repeat | repeat-x | repeat-y }

  function cleanArg(arg) {
      // clean up an arg
      return (args[arg] != null && args[arg] != "") ? args[arg] : null;
  }

  var id = args.id ? args.id.trim() : "";
  this._id = id.length > 0 ? id : Timeline.EventUtils.getNewEventID();

  this._instant = args.instant || (args.end == null);

  this._start = args.start;
  this._end = (args.end != null) ? args.end : args.start;

  this._latestStart = (args.latestStart != null) ?
                       args.latestStart : (args.instant ? this._end : this._start);
  this._earliestEnd = (args.earliestEnd != null) ? args.earliestEnd : this._end;

  // check sanity of dates since incorrect dates will later cause calculation errors
  // when painting
  var err=[];
  if (this._start > this._latestStart) {
          this._latestStart = this._start;
          err.push("start is > latestStart");}
  if (this._start > this._earliestEnd) {
          this._earliestEnd = this._latestStart;
          err.push("start is > earliestEnd");}
  if (this._start > this._end) {
          this._end = this._earliestEnd;
          err.push("start is > end");}
  if (this._latestStart > this._earliestEnd) {
          this._earliestEnd = this._latestStart;
          err.push("latestStart is > earliestEnd");}
  if (this._latestStart > this._end) {
          this._end = this._earliestEnd;
          err.push("latestStart is > end");}
  if (this._earliestEnd > this._end) {
          this._end = this._earliestEnd;
          err.push("earliestEnd is > end");}

  this._eventID = cleanArg('eventID');
  this._text = (args.text != null) ? SimileAjax.HTML.deEntify(args.text) : ""; // Change blank titles to ""
  if (err.length > 0) {
          this._text += " PROBLEM: " + err.join(", ");
  }

  this._description = SimileAjax.HTML.deEntify(args.description);
  this._image = cleanArg('image');
  this._link =  cleanArg('link');
  this._title = cleanArg('hoverText');
  this._title = cleanArg('caption');

  this._icon = cleanArg('icon');
  this._color = cleanArg('color');
  this._textColor = cleanArg('textColor');
  this._classname = cleanArg('classname');
  this._tapeImage = cleanArg('tapeImage');
  this._tapeRepeat = cleanArg('tapeRepeat');
  this._trackNum = cleanArg('trackNum');
  if (this._trackNum != null) {
      this._trackNum = parseInt(this._trackNum);
  }

  this._wikiURL = null;
  this._wikiSection = null;
};

Timeline.DefaultEventSource.Event.prototype = {
    getID:          function() { return this._id; },

    isInstant:      function() { return this._instant; },
    isImprecise:    function() { return this._start != this._latestStart || this._end != this._earliestEnd; },

    getStart:       function() { return this._start; },
    getEnd:         function() { return this._end; },
    getLatestStart: function() { return this._latestStart; },
    getEarliestEnd: function() { return this._earliestEnd; },

    getEventID:     function() { return this._eventID; },
    getText:        function() { return this._text; }, // title
    getDescription: function() { return this._description; },
    getImage:       function() { return this._image; },
    getLink:        function() { return this._link; },

    getIcon:        function() { return this._icon; },
    getColor:       function() { return this._color; },
    getTextColor:   function() { return this._textColor; },
    getClassName:   function() { return this._classname; },
    getTapeImage:   function() { return this._tapeImage; },
    getTapeRepeat:  function() { return this._tapeRepeat; },
    getTrackNum:    function() { return this._trackNum; },

    getProperty:    function(name) { return null; },

    getWikiURL:     function() { return this._wikiURL; },
    getWikiSection: function() { return this._wikiSection; },
    setWikiInfo: function(wikiURL, wikiSection) {
        this._wikiURL = wikiURL;
        this._wikiSection = wikiSection;
    },

    fillDescription: function(elmt) {
        if (this._description) {
            elmt.innerHTML = this._description;
        }
    },
    fillWikiInfo: function(elmt) {
        // Many bubbles will not support a wiki link.
        //
        // Strategy: assume no wiki link. If we do have
        // enough parameters for one, then create it.
        elmt.style.display = "none"; // default

        if (this._wikiURL == null || this._wikiSection == null) {
          return; // EARLY RETURN
        }

        // create the wikiID from the property or from the event text (the title)
        var wikiID = this.getProperty("wikiID");
        if (wikiID == null || wikiID.length == 0) {
            wikiID = this.getText(); // use the title as the backup wiki id
        }

        if (wikiID == null || wikiID.length == 0) {
          return; // No wikiID. Thus EARLY RETURN
        }

        // ready to go...
        elmt.style.display = "inline";
        wikiID = wikiID.replace(/\s/g, "_");
        var url = this._wikiURL + this._wikiSection.replace(/\s/g, "_") + "/" + wikiID;
        var a = document.createElement("a");
        a.href = url;
        a.target = "new";
        a.innerHTML = Timeline.strings[Timeline.clientLocale].wikiLinkLabel;

        elmt.appendChild(document.createTextNode("["));
        elmt.appendChild(a);
        elmt.appendChild(document.createTextNode("]"));
    },

    fillTime: function(elmt, labeller) {
        if (this._instant) {
            if (this.isImprecise()) {
                elmt.appendChild(elmt.ownerDocument.createTextNode(labeller.labelPrecise(this._start)));
                elmt.appendChild(elmt.ownerDocument.createElement("br"));
                elmt.appendChild(elmt.ownerDocument.createTextNode(labeller.labelPrecise(this._end)));
            } else {
                elmt.appendChild(elmt.ownerDocument.createTextNode(labeller.labelPrecise(this._start)));
            }
        } else {
            if (this.isImprecise()) {
                elmt.appendChild(elmt.ownerDocument.createTextNode(
                    labeller.labelPrecise(this._start) + " ~ " + labeller.labelPrecise(this._latestStart)));
                elmt.appendChild(elmt.ownerDocument.createElement("br"));
                elmt.appendChild(elmt.ownerDocument.createTextNode(
                    labeller.labelPrecise(this._earliestEnd) + " ~ " + labeller.labelPrecise(this._end)));
            } else {
                elmt.appendChild(elmt.ownerDocument.createTextNode(labeller.labelPrecise(this._start)));
                elmt.appendChild(elmt.ownerDocument.createElement("br"));
                elmt.appendChild(elmt.ownerDocument.createTextNode(labeller.labelPrecise(this._end)));
            }
        }
    },

    fillInfoBubble: function(elmt, theme, labeller) {
        var doc = elmt.ownerDocument;

        var title = this.getText();
        var link = this.getLink();
        var image = this.getImage();

        if (image != null) {
            var img = doc.createElement("img");
            img.src = image;

            theme.event.bubble.imageStyler(img);
            elmt.appendChild(img);
        }

        var divTitle = doc.createElement("div");
        var textTitle = doc.createTextNode(title);
        if (link != null) {
            var a = doc.createElement("a");
            a.href = link;
            a.appendChild(textTitle);
            divTitle.appendChild(a);
        } else {
            divTitle.appendChild(textTitle);
        }
        theme.event.bubble.titleStyler(divTitle);
        elmt.appendChild(divTitle);

        var divBody = doc.createElement("div");
        this.fillDescription(divBody);
        theme.event.bubble.bodyStyler(divBody);
        elmt.appendChild(divBody);

        var divTime = doc.createElement("div");
        this.fillTime(divTime, labeller);
        theme.event.bubble.timeStyler(divTime);
        elmt.appendChild(divTime);

        var divWiki = doc.createElement("div");
        this.fillWikiInfo(divWiki);
        theme.event.bubble.wikiStyler(divWiki);
        elmt.appendChild(divWiki);
    }
};


