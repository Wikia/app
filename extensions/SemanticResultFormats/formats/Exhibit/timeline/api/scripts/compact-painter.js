/*==================================================
 *  Compact Event Painter
 *==================================================
 */

Timeline.CompactEventPainter = function(params) {
    this._params = params;
    this._onSelectListeners = [];

    this._filterMatcher = null;
    this._highlightMatcher = null;
    this._frc = null;

    this._eventIdToElmt = {};
};

Timeline.CompactEventPainter.prototype.getType = function() {
    return 'compact';
};

Timeline.CompactEventPainter.prototype.initialize = function(band, timeline) {
    this._band = band;
    this._timeline = timeline;

    this._backLayer = null;
    this._eventLayer = null;
    this._lineLayer = null;
    this._highlightLayer = null;

    this._eventIdToElmt = null;
};

Timeline.CompactEventPainter.prototype.supportsOrthogonalScrolling = function() {
    return true;
};

Timeline.CompactEventPainter.prototype.addOnSelectListener = function(listener) {
    this._onSelectListeners.push(listener);
};

Timeline.CompactEventPainter.prototype.removeOnSelectListener = function(listener) {
    for (var i = 0; i < this._onSelectListeners.length; i++) {
        if (this._onSelectListeners[i] == listener) {
            this._onSelectListeners.splice(i, 1);
            break;
        }
    }
};

Timeline.CompactEventPainter.prototype.getFilterMatcher = function() {
    return this._filterMatcher;
};

Timeline.CompactEventPainter.prototype.setFilterMatcher = function(filterMatcher) {
    this._filterMatcher = filterMatcher;
};

Timeline.CompactEventPainter.prototype.getHighlightMatcher = function() {
    return this._highlightMatcher;
};

Timeline.CompactEventPainter.prototype.setHighlightMatcher = function(highlightMatcher) {
    this._highlightMatcher = highlightMatcher;
};

Timeline.CompactEventPainter.prototype.paint = function() {
    var eventSource = this._band.getEventSource();
    if (eventSource == null) {
        return;
    }

    this._eventIdToElmt = {};
    this._prepareForPainting();

    var metrics = this._computeMetrics();
    var minDate = this._band.getMinDate();
    var maxDate = this._band.getMaxDate();

    var filterMatcher = (this._filterMatcher != null) ?
        this._filterMatcher :
        function(evt) { return true; };

    var highlightMatcher = (this._highlightMatcher != null) ?
        this._highlightMatcher :
        function(evt) { return -1; };

    var iterator = eventSource.getEventIterator(minDate, maxDate);

    var stackConcurrentPreciseInstantEvents = "stackConcurrentPreciseInstantEvents" in this._params && typeof this._params.stackConcurrentPreciseInstantEvents == "object";
    var collapseConcurrentPreciseInstantEvents = "collapseConcurrentPreciseInstantEvents" in this._params && this._params.collapseConcurrentPreciseInstantEvents;
    if (collapseConcurrentPreciseInstantEvents || stackConcurrentPreciseInstantEvents) {
        var bufferedEvents = [];
        var previousInstantEvent = null;

        while (iterator.hasNext()) {
            var evt = iterator.next();
            if (filterMatcher(evt)) {
                if (!evt.isInstant() || evt.isImprecise()) {
                    this.paintEvent(evt, metrics, this._params.theme, highlightMatcher(evt));
                } else if (previousInstantEvent != null &&
                        previousInstantEvent.getStart().getTime() == evt.getStart().getTime()) {
                    bufferedEvents[bufferedEvents.length - 1].push(evt);
                } else {
                    bufferedEvents.push([ evt ]);
                    previousInstantEvent = evt;
                }
            }
        }

        for (var i = 0; i < bufferedEvents.length; i++) {
            var compositeEvents = bufferedEvents[i];
            if (compositeEvents.length == 1) {
                this.paintEvent(compositeEvents[0], metrics, this._params.theme, highlightMatcher(evt));
            } else {
                var match = -1;
                for (var j = 0; match < 0 && j < compositeEvents.length; j++) {
                    match = highlightMatcher(compositeEvents[j]);
                }

                if (stackConcurrentPreciseInstantEvents) {
                    this.paintStackedPreciseInstantEvents(compositeEvents, metrics, this._params.theme, match);
                } else {
                    this.paintCompositePreciseInstantEvents(compositeEvents, metrics, this._params.theme, match);
                }
            }
        }
    } else {
        while (iterator.hasNext()) {
            var evt = iterator.next();
            if (filterMatcher(evt)) {
                this.paintEvent(evt, metrics, this._params.theme, highlightMatcher(evt));
            }
        }
    }

    this._highlightLayer.style.display = "block";
    this._lineLayer.style.display = "block";
    this._eventLayer.style.display = "block";

    this._setOrthogonalOffset(metrics);
};

Timeline.CompactEventPainter.prototype.softPaint = function() {
    this._setOrthogonalOffset(this._computeMetrics());
};

Timeline.CompactEventPainter.prototype.getOrthogonalExtent = function() {
    var metrics = this._computeMetrics();
    return 2 * metrics.trackOffset + this._tracks.length * metrics.trackHeight;
};

Timeline.CompactEventPainter.prototype._setOrthogonalOffset = function(metrics) {
    var orthogonalOffset = this._band.getViewOrthogonalOffset();

    this._highlightLayer.style.top =
        this._lineLayer.style.top =
            this._eventLayer.style.top =
                orthogonalOffset + "px";
};

Timeline.CompactEventPainter.prototype._computeMetrics = function() {
    var theme = this._params.theme;
    var eventTheme = theme.event;

    var metrics = {
        trackOffset:            "trackOffset" in this._params ? this._params.trackOffset : 10,
        trackHeight:            "trackHeight" in this._params ? this._params.trackHeight : 10,

        tapeHeight:             theme.event.tape.height,
        tapeBottomMargin:       "tapeBottomMargin" in this._params ? this._params.tapeBottomMargin : 2,

        labelBottomMargin:      "labelBottomMargin" in this._params ? this._params.labelBottomMargin : 5,
        labelRightMargin:       "labelRightMargin" in this._params ? this._params.labelRightMargin : 5,

        defaultIcon:            eventTheme.instant.icon,
        defaultIconWidth:       eventTheme.instant.iconWidth,
        defaultIconHeight:      eventTheme.instant.iconHeight,

        customIconWidth:        "iconWidth" in this._params ? this._params.iconWidth : eventTheme.instant.iconWidth,
        customIconHeight:       "iconHeight" in this._params ? this._params.iconHeight : eventTheme.instant.iconHeight,

        iconLabelGap:           "iconLabelGap" in this._params ? this._params.iconLabelGap : 2,
        iconBottomMargin:       "iconBottomMargin" in this._params ? this._params.iconBottomMargin : 2
    };
    if ("compositeIcon" in this._params) {
        metrics.compositeIcon = this._params.compositeIcon;
        metrics.compositeIconWidth = this._params.compositeIconWidth || metrics.customIconWidth;
        metrics.compositeIconHeight = this._params.compositeIconHeight || metrics.customIconHeight;
    } else {
        metrics.compositeIcon = metrics.defaultIcon;
        metrics.compositeIconWidth = metrics.defaultIconWidth;
        metrics.compositeIconHeight = metrics.defaultIconHeight;
    }
    metrics.defaultStackIcon = ("stackConcurrentPreciseInstantEvents" in this._params && "icon" in this._params.stackConcurrentPreciseInstantEvents) ?
        this._params.stackConcurrentPreciseInstantEvents.icon : metrics.defaultIcon;
    metrics.defaultStackIconWidth = ("stackConcurrentPreciseInstantEvents" in this._params && "iconWidth" in this._params.stackConcurrentPreciseInstantEvents) ?
        this._params.stackConcurrentPreciseInstantEvents.iconWidth : metrics.defaultIconWidth;
    metrics.defaultStackIconHeight = ("stackConcurrentPreciseInstantEvents" in this._params && "iconHeight" in this._params.stackConcurrentPreciseInstantEvents) ?
        this._params.stackConcurrentPreciseInstantEvents.iconHeight : metrics.defaultIconHeight;

    return metrics;
};

Timeline.CompactEventPainter.prototype._prepareForPainting = function() {
    var band = this._band;

    if (this._backLayer == null) {
        this._backLayer = this._band.createLayerDiv(0, "timeline-band-events");
        this._backLayer.style.visibility = "hidden";

        var eventLabelPrototype = document.createElement("span");
        eventLabelPrototype.className = "timeline-event-label";
        this._backLayer.appendChild(eventLabelPrototype);
        this._frc = SimileAjax.Graphics.getFontRenderingContext(eventLabelPrototype);
    }
    this._frc.update();
    this._tracks = [];

    if (this._highlightLayer != null) {
        band.removeLayerDiv(this._highlightLayer);
    }
    this._highlightLayer = band.createLayerDiv(105, "timeline-band-highlights");
    this._highlightLayer.style.display = "none";

    if (this._lineLayer != null) {
        band.removeLayerDiv(this._lineLayer);
    }
    this._lineLayer = band.createLayerDiv(110, "timeline-band-lines");
    this._lineLayer.style.display = "none";

    if (this._eventLayer != null) {
        band.removeLayerDiv(this._eventLayer);
    }
    this._eventLayer = band.createLayerDiv(115, "timeline-band-events");
    this._eventLayer.style.display = "none";
};

Timeline.CompactEventPainter.prototype.paintEvent = function(evt, metrics, theme, highlightIndex) {
    if (evt.isInstant()) {
        this.paintInstantEvent(evt, metrics, theme, highlightIndex);
    } else {
        this.paintDurationEvent(evt, metrics, theme, highlightIndex);
    }
};

Timeline.CompactEventPainter.prototype.paintInstantEvent = function(evt, metrics, theme, highlightIndex) {
    if (evt.isImprecise()) {
        this.paintImpreciseInstantEvent(evt, metrics, theme, highlightIndex);
    } else {
        this.paintPreciseInstantEvent(evt, metrics, theme, highlightIndex);
    }
}

Timeline.CompactEventPainter.prototype.paintDurationEvent = function(evt, metrics, theme, highlightIndex) {
    if (evt.isImprecise()) {
        this.paintImpreciseDurationEvent(evt, metrics, theme, highlightIndex);
    } else {
        this.paintPreciseDurationEvent(evt, metrics, theme, highlightIndex);
    }
}

Timeline.CompactEventPainter.prototype.paintPreciseInstantEvent = function(evt, metrics, theme, highlightIndex) {
    var commonData = {
        tooltip: evt.getProperty("tooltip") || evt.getText()
    };

    var iconData = {
        url: evt.getIcon()
    };
    if (iconData.url == null) {
        iconData.url = metrics.defaultIcon;
        iconData.width = metrics.defaultIconWidth;
        iconData.height = metrics.defaultIconHeight;
        iconData.className = "timeline-event-icon-default";
    } else {
        iconData.width = evt.getProperty("iconWidth") || metrics.customIconWidth;
        iconData.height = evt.getProperty("iconHeight") || metrics.customIconHeight;
    }

    var labelData = {
        text:       evt.getText(),
        color:      evt.getTextColor() || evt.getColor(),
        className:  evt.getClassName()
    };

    var result = this.paintTapeIconLabel(
        evt.getStart(),
        commonData,
        null, // no tape data
        iconData,
        labelData,
        metrics,
        theme,
        highlightIndex
    );

    var self = this;
    var clickHandler = function(elmt, domEvt, target) {
        return self._onClickInstantEvent(result.iconElmtData.elmt, domEvt, evt);
    };
    SimileAjax.DOM.registerEvent(result.iconElmtData.elmt, "mousedown", clickHandler);
    SimileAjax.DOM.registerEvent(result.labelElmtData.elmt, "mousedown", clickHandler);

    this._eventIdToElmt[evt.getID()] = result.iconElmtData.elmt;
};

Timeline.CompactEventPainter.prototype.paintCompositePreciseInstantEvents = function(events, metrics, theme, highlightIndex) {
    var evt = events[0];

    var tooltips = [];
    for (var i = 0; i < events.length; i++) {
        tooltips.push(events[i].getProperty("tooltip") || events[i].getText());
    }
    var commonData = {
        tooltip: tooltips.join("; ")
    };

    var iconData = {
        url: metrics.compositeIcon,
        width: metrics.compositeIconWidth,
        height: metrics.compositeIconHeight,
        className: "timeline-event-icon-composite"
    };

    var labelData = {
        text: String.substitute(this._params.compositeEventLabelTemplate, [ events.length ])
    };

    var result = this.paintTapeIconLabel(
        evt.getStart(),
        commonData,
        null, // no tape data
        iconData,
        labelData,
        metrics,
        theme,
        highlightIndex
    );

    var self = this;
    var clickHandler = function(elmt, domEvt, target) {
        return self._onClickMultiplePreciseInstantEvent(result.iconElmtData.elmt, domEvt, events);
    };

    SimileAjax.DOM.registerEvent(result.iconElmtData.elmt, "mousedown", clickHandler);
    SimileAjax.DOM.registerEvent(result.labelElmtData.elmt, "mousedown", clickHandler);

    for (var i = 0; i < events.length; i++) {
        this._eventIdToElmt[events[i].getID()] = result.iconElmtData.elmt;
    }
};

Timeline.CompactEventPainter.prototype.paintStackedPreciseInstantEvents = function(events, metrics, theme, highlightIndex) {
    var limit = "limit" in this._params.stackConcurrentPreciseInstantEvents ?
        this._params.stackConcurrentPreciseInstantEvents.limit : 10;
    var moreMessageTemplate = "moreMessageTemplate" in this._params.stackConcurrentPreciseInstantEvents ?
        this._params.stackConcurrentPreciseInstantEvents.moreMessageTemplate : "%0 More Events";
    var showMoreMessage = limit <= events.length - 2; // We want at least 2 more events above the limit.
                                                      // Otherwise we'd need the singular case of "1 More Event"

    var band = this._band;
    var getPixelOffset = function(date) {
        return Math.round(band.dateToPixelOffset(date));
    };
    var getIconData = function(evt) {
        var iconData = {
            url: evt.getIcon()
        };
        if (iconData.url == null) {
            iconData.url = metrics.defaultStackIcon;
            iconData.width = metrics.defaultStackIconWidth;
            iconData.height = metrics.defaultStackIconHeight;
            iconData.className = "timeline-event-icon-stack timeline-event-icon-default";
        } else {
            iconData.width = evt.getProperty("iconWidth") || metrics.customIconWidth;
            iconData.height = evt.getProperty("iconHeight") || metrics.customIconHeight;
            iconData.className = "timeline-event-icon-stack";
        }
        return iconData;
    };

    var firstIconData = getIconData(events[0]);
    var horizontalIncrement = 5;
    var leftIconEdge = 0;
    var totalLabelWidth = 0;
    var totalLabelHeight = 0;
    var totalIconHeight = 0;

    var records = [];
    for (var i = 0; i < events.length && (!showMoreMessage || i < limit); i++) {
        var evt = events[i];
        var text = evt.getText();
        var iconData = getIconData(evt);
        var labelSize = this._frc.computeSize(text);
        var record = {
            text:       text,
            iconData:   iconData,
            labelSize:  labelSize,
            iconLeft:   firstIconData.width + i * horizontalIncrement - iconData.width
        };
        record.labelLeft = firstIconData.width + i * horizontalIncrement + metrics.iconLabelGap;
        record.top = totalLabelHeight;
        records.push(record);

        leftIconEdge = Math.min(leftIconEdge, record.iconLeft);
        totalLabelHeight += labelSize.height;
        totalLabelWidth = Math.max(totalLabelWidth, record.labelLeft + labelSize.width);
        totalIconHeight = Math.max(totalIconHeight, record.top + iconData.height);
    }
    if (showMoreMessage) {
        var moreMessage = String.substitute(moreMessageTemplate, [ events.length - limit ]);

        var moreMessageLabelSize = this._frc.computeSize(moreMessage);
        var moreMessageLabelLeft = firstIconData.width + (limit - 1) * horizontalIncrement + metrics.iconLabelGap;
        var moreMessageLabelTop = totalLabelHeight;

        totalLabelHeight += moreMessageLabelSize.height;
        totalLabelWidth = Math.max(totalLabelWidth, moreMessageLabelLeft + moreMessageLabelSize.width);
    }
    totalLabelWidth += metrics.labelRightMargin;
    totalLabelHeight += metrics.labelBottomMargin;
    totalIconHeight += metrics.iconBottomMargin;

    var anchorPixel = getPixelOffset(events[0].getStart());
    var newTracks = [];

    var trackCount = Math.ceil(Math.max(totalIconHeight, totalLabelHeight) / metrics.trackHeight);
    var rightIconEdge = firstIconData.width + (events.length - 1) * horizontalIncrement;
    for (var i = 0; i < trackCount; i++) {
        newTracks.push({ start: leftIconEdge, end: rightIconEdge });
    }
    var labelTrackCount = Math.ceil(totalLabelHeight / metrics.trackHeight);
    for (var i = 0; i < labelTrackCount; i++) {
        var track = newTracks[i];
        track.end = Math.max(track.end, totalLabelWidth);
    }

    var firstTrack = this._fitTracks(anchorPixel, newTracks);
    var verticalPixelOffset = firstTrack * metrics.trackHeight + metrics.trackOffset;

    var iconStackDiv = this._timeline.getDocument().createElement("div");
    iconStackDiv.className = 'timeline-event-icon-stack';
    iconStackDiv.style.position = "absolute";
    iconStackDiv.style.overflow = "visible";
    iconStackDiv.style.left = anchorPixel + "px";
    iconStackDiv.style.top = verticalPixelOffset + "px";
    iconStackDiv.style.width = rightIconEdge + "px";
    iconStackDiv.style.height = totalIconHeight + "px";
    iconStackDiv.innerHTML = "<div style='position: relative'></div>";
    this._eventLayer.appendChild(iconStackDiv);

    var self = this;
    var onMouseOver = function(domEvt) {
        try {
            var n = parseInt(this.getAttribute("index"));
            var childNodes = iconStackDiv.firstChild.childNodes;
            for (var i = 0; i < childNodes.length; i++) {
                var child = childNodes[i];
                if (i == n) {
                    child.style.zIndex = childNodes.length;
                } else {
                    child.style.zIndex = childNodes.length - i;
                }
            }
        } catch (e) {
        }
    };
    var paintEvent = function(index) {
        var record = records[index];
        var evt = events[index];
        var tooltip = evt.getProperty("tooltip") || evt.getText();

        var labelElmtData = self._paintEventLabel(
            { tooltip: tooltip },
            { text: record.text },
            anchorPixel + record.labelLeft,
            verticalPixelOffset + record.top,
            record.labelSize.width,
            record.labelSize.height,
            theme
        );
        labelElmtData.elmt.setAttribute("index", index);
        labelElmtData.elmt.onmouseover = onMouseOver;

        var img = SimileAjax.Graphics.createTranslucentImage(record.iconData.url);
        var iconDiv = self._timeline.getDocument().createElement("div");
        iconDiv.className = 'timeline-event-icon' + ("className" in record.iconData ? (" " + record.iconData.className) : "");
        iconDiv.style.left = record.iconLeft + "px";
        iconDiv.style.top = record.top + "px";
        iconDiv.style.zIndex = (records.length - index);
        iconDiv.appendChild(img);
        iconDiv.setAttribute("index", index);
        iconDiv.onmouseover = onMouseOver;

        iconStackDiv.firstChild.appendChild(iconDiv);

        var clickHandler = function(elmt, domEvt, target) {
            return self._onClickInstantEvent(labelElmtData.elmt, domEvt, evt);
        };

        SimileAjax.DOM.registerEvent(iconDiv, "mousedown", clickHandler);
        SimileAjax.DOM.registerEvent(labelElmtData.elmt, "mousedown", clickHandler);

        self._eventIdToElmt[evt.getID()] = iconDiv;
    };
    for (var i = 0; i < records.length; i++) {
        paintEvent(i);
    }

    if (showMoreMessage) {
        var moreEvents = events.slice(limit);
        var moreMessageLabelElmtData = this._paintEventLabel(
            { tooltip: moreMessage },
            { text: moreMessage },
            anchorPixel + moreMessageLabelLeft,
            verticalPixelOffset + moreMessageLabelTop,
            moreMessageLabelSize.width,
            moreMessageLabelSize.height,
            theme
        );

        var moreMessageClickHandler = function(elmt, domEvt, target) {
            return self._onClickMultiplePreciseInstantEvent(moreMessageLabelElmtData.elmt, domEvt, moreEvents);
        };
        SimileAjax.DOM.registerEvent(moreMessageLabelElmtData.elmt, "mousedown", moreMessageClickHandler);

        for (var i = 0; i < moreEvents.length; i++) {
            this._eventIdToElmt[moreEvents[i].getID()] = moreMessageLabelElmtData.elmt;
        }
    }
    //this._createHighlightDiv(highlightIndex, iconElmtData, theme);
};

Timeline.CompactEventPainter.prototype.paintImpreciseInstantEvent = function(evt, metrics, theme, highlightIndex) {
    var commonData = {
        tooltip: evt.getProperty("tooltip") || evt.getText()
    };

    var tapeData = {
        start:          evt.getStart(),
        end:            evt.getEnd(),
        latestStart:    evt.getLatestStart(),
        earliestEnd:    evt.getEarliestEnd(),
        color:          evt.getColor() || evt.getTextColor(),
        isInstant:      true
    };

    var iconData = {
        url: evt.getIcon()
    };
    if (iconData.url == null) {
        iconData = null;
    } else {
        iconData.width = evt.getProperty("iconWidth") || metrics.customIconWidth;
        iconData.height = evt.getProperty("iconHeight") || metrics.customIconHeight;
    }

    var labelData = {
        text:       evt.getText(),
        color:      evt.getTextColor() || evt.getColor(),
        className:  evt.getClassName()
    };

    var result = this.paintTapeIconLabel(
        evt.getStart(),
        commonData,
        tapeData,
        iconData,
        labelData,
        metrics,
        theme,
        highlightIndex
    );

    var self = this;
    var clickHandler = iconData != null ?
        function(elmt, domEvt, target) {
            return self._onClickInstantEvent(result.iconElmtData.elmt, domEvt, evt);
        } :
        function(elmt, domEvt, target) {
            return self._onClickInstantEvent(result.labelElmtData.elmt, domEvt, evt);
        };

    SimileAjax.DOM.registerEvent(result.labelElmtData.elmt, "mousedown", clickHandler);
    SimileAjax.DOM.registerEvent(result.impreciseTapeElmtData.elmt, "mousedown", clickHandler);

    if (iconData != null) {
        SimileAjax.DOM.registerEvent(result.iconElmtData.elmt, "mousedown", clickHandler);
        this._eventIdToElmt[evt.getID()] = result.iconElmtData.elmt;
    } else {
        this._eventIdToElmt[evt.getID()] = result.labelElmtData.elmt;
    }
};

Timeline.CompactEventPainter.prototype.paintPreciseDurationEvent = function(evt, metrics, theme, highlightIndex) {
    var commonData = {
        tooltip: evt.getProperty("tooltip") || evt.getText()
    };

    var tapeData = {
        start:          evt.getStart(),
        end:            evt.getEnd(),
        color:          evt.getColor() || evt.getTextColor(),
        isInstant:      false
    };

    var iconData = {
        url: evt.getIcon()
    };
    if (iconData.url == null) {
        iconData = null;
    } else {
        iconData.width = evt.getProperty("iconWidth") || metrics.customIconWidth;
        iconData.height = evt.getProperty("iconHeight") || metrics.customIconHeight;
    }

    var labelData = {
        text:       evt.getText(),
        color:      evt.getTextColor() || evt.getColor(),
        className:  evt.getClassName()
    };

    var result = this.paintTapeIconLabel(
        evt.getLatestStart(),
        commonData,
        tapeData,
        iconData,
        labelData,
        metrics,
        theme,
        highlightIndex
    );

    var self = this;
    var clickHandler = iconData != null ?
        function(elmt, domEvt, target) {
            return self._onClickInstantEvent(result.iconElmtData.elmt, domEvt, evt);
        } :
        function(elmt, domEvt, target) {
            return self._onClickInstantEvent(result.labelElmtData.elmt, domEvt, evt);
        };

    SimileAjax.DOM.registerEvent(result.labelElmtData.elmt, "mousedown", clickHandler);
    SimileAjax.DOM.registerEvent(result.tapeElmtData.elmt, "mousedown", clickHandler);

    if (iconData != null) {
        SimileAjax.DOM.registerEvent(result.iconElmtData.elmt, "mousedown", clickHandler);
        this._eventIdToElmt[evt.getID()] = result.iconElmtData.elmt;
    } else {
        this._eventIdToElmt[evt.getID()] = result.labelElmtData.elmt;
    }
};

Timeline.CompactEventPainter.prototype.paintImpreciseDurationEvent = function(evt, metrics, theme, highlightIndex) {
    var commonData = {
        tooltip: evt.getProperty("tooltip") || evt.getText()
    };

    var tapeData = {
        start:          evt.getStart(),
        end:            evt.getEnd(),
        latestStart:    evt.getLatestStart(),
        earliestEnd:    evt.getEarliestEnd(),
        color:          evt.getColor() || evt.getTextColor(),
        isInstant:      false
    };

    var iconData = {
        url: evt.getIcon()
    };
    if (iconData.url == null) {
        iconData = null;
    } else {
        iconData.width = evt.getProperty("iconWidth") || metrics.customIconWidth;
        iconData.height = evt.getProperty("iconHeight") || metrics.customIconHeight;
    }

    var labelData = {
        text:       evt.getText(),
        color:      evt.getTextColor() || evt.getColor(),
        className:  evt.getClassName()
    };

    var result = this.paintTapeIconLabel(
        evt.getLatestStart(),
        commonData,
        tapeData,
        iconData,
        labelData,
        metrics,
        theme,
        highlightIndex
    );

    var self = this;
    var clickHandler = iconData != null ?
        function(elmt, domEvt, target) {
            return self._onClickInstantEvent(result.iconElmtData.elmt, domEvt, evt);
        } :
        function(elmt, domEvt, target) {
            return self._onClickInstantEvent(result.labelElmtData.elmt, domEvt, evt);
        };

    SimileAjax.DOM.registerEvent(result.labelElmtData.elmt, "mousedown", clickHandler);
    SimileAjax.DOM.registerEvent(result.tapeElmtData.elmt, "mousedown", clickHandler);

    if (iconData != null) {
        SimileAjax.DOM.registerEvent(result.iconElmtData.elmt, "mousedown", clickHandler);
        this._eventIdToElmt[evt.getID()] = result.iconElmtData.elmt;
    } else {
        this._eventIdToElmt[evt.getID()] = result.labelElmtData.elmt;
    }
};

Timeline.CompactEventPainter.prototype.paintTapeIconLabel = function(
    anchorDate,
    commonData,
    tapeData,
    iconData,
    labelData,
    metrics,
    theme,
    highlightIndex
) {
    var band = this._band;
    var getPixelOffset = function(date) {
        return Math.round(band.dateToPixelOffset(date));
    };

    var anchorPixel = getPixelOffset(anchorDate);
    var newTracks = [];

    var tapeHeightOccupied = 0;         // how many pixels (vertically) the tape occupies, including bottom margin
    var tapeTrackCount = 0;             // how many tracks the tape takes up, usually just 1
    var tapeLastTrackExtraSpace = 0;    // on the last track that the tape occupies, how many pixels are left (for icon and label to occupy as well)
    if (tapeData != null) {
        tapeHeightOccupied = metrics.tapeHeight + metrics.tapeBottomMargin;
        tapeTrackCount = Math.ceil(metrics.tapeHeight / metrics.trackHeight);

        var tapeEndPixelOffset = getPixelOffset(tapeData.end) - anchorPixel;
        var tapeStartPixelOffset = getPixelOffset(tapeData.start) - anchorPixel;

        for (var t = 0; t < tapeTrackCount; t++) {
            newTracks.push({ start: tapeStartPixelOffset, end: tapeEndPixelOffset });
        }

        tapeLastTrackExtraSpace = metrics.trackHeight - (tapeHeightOccupied % metrics.tapeHeight);
    }

    var iconStartPixelOffset = 0;        // where the icon starts compared to the anchor pixel;
                                         // this can be negative if the icon is center-aligned around the anchor
    var iconHorizontalSpaceOccupied = 0; // how many pixels the icon take up from the anchor pixel,
                                         // including the gap between the icon and the label
    if (iconData != null) {
        if ("iconAlign" in iconData && iconData.iconAlign == "center") {
            iconStartPixelOffset = -Math.floor(iconData.width / 2);
        }
        iconHorizontalSpaceOccupied = iconStartPixelOffset + iconData.width + metrics.iconLabelGap;

        if (tapeTrackCount > 0) {
            newTracks[tapeTrackCount - 1].end = Math.max(newTracks[tapeTrackCount - 1].end, iconHorizontalSpaceOccupied);
        }

        var iconHeight = iconData.height + metrics.iconBottomMargin + tapeLastTrackExtraSpace;
        while (iconHeight > 0) {
            newTracks.push({ start: iconStartPixelOffset, end: iconHorizontalSpaceOccupied });
            iconHeight -= metrics.trackHeight;
        }
    }

    var text = labelData.text;
    var labelSize = this._frc.computeSize(text);
    var labelHeight = labelSize.height + metrics.labelBottomMargin + tapeLastTrackExtraSpace;
    var labelEndPixelOffset = iconHorizontalSpaceOccupied + labelSize.width + metrics.labelRightMargin;
    if (tapeTrackCount > 0) {
        newTracks[tapeTrackCount - 1].end = Math.max(newTracks[tapeTrackCount - 1].end, labelEndPixelOffset);
    }
    for (var i = 0; labelHeight > 0; i++) {
        if (tapeTrackCount + i < newTracks.length) {
            var track = newTracks[tapeTrackCount + i];
            track.end = labelEndPixelOffset;
        } else {
            newTracks.push({ start: 0, end: labelEndPixelOffset });
        }
        labelHeight -= metrics.trackHeight;
    }

    /*
     *  Try to fit the new track on top of the existing tracks, then
     *  render the various elements.
     */
    var firstTrack = this._fitTracks(anchorPixel, newTracks);
    var verticalPixelOffset = firstTrack * metrics.trackHeight + metrics.trackOffset;
    var result = {};

    result.labelElmtData = this._paintEventLabel(
        commonData,
        labelData,
        anchorPixel + iconHorizontalSpaceOccupied,
        verticalPixelOffset + tapeHeightOccupied,
        labelSize.width,
        labelSize.height,
        theme
    );

    if (tapeData != null) {
        if ("latestStart" in tapeData || "earliestEnd" in tapeData) {
            result.impreciseTapeElmtData = this._paintEventTape(
                commonData,
                tapeData,
                metrics.tapeHeight,
                verticalPixelOffset,
                getPixelOffset(tapeData.start),
                getPixelOffset(tapeData.end),
                theme.event.duration.impreciseColor,
                theme.event.duration.impreciseOpacity,
                metrics,
                theme
            );
        }
        if (!tapeData.isInstant && "start" in tapeData && "end" in tapeData) {
            result.tapeElmtData = this._paintEventTape(
                commonData,
                tapeData,
                metrics.tapeHeight,
                verticalPixelOffset,
                anchorPixel,
                getPixelOffset("earliestEnd" in tapeData ? tapeData.earliestEnd : tapeData.end),
                tapeData.color,
                100,
                metrics,
                theme
            );
        }
    }

    if (iconData != null) {
        result.iconElmtData = this._paintEventIcon(
            commonData,
            iconData,
            verticalPixelOffset + tapeHeightOccupied,
            anchorPixel + iconStartPixelOffset,
            metrics,
            theme
        );
    }
    //this._createHighlightDiv(highlightIndex, iconElmtData, theme);

    return result;
};

Timeline.CompactEventPainter.prototype._fitTracks = function(anchorPixel, newTracks) {
    var firstTrack;
    for (firstTrack = 0; firstTrack < this._tracks.length; firstTrack++) {
        var fit = true;
        for (var j = 0; j < newTracks.length && (firstTrack + j) < this._tracks.length; j++) {
            var existingTrack = this._tracks[firstTrack + j];
            var newTrack = newTracks[j];
            if (anchorPixel + newTrack.start < existingTrack) {
                fit = false;
                break;
            }
        }

        if (fit) {
            break;
        }
    }
    for (var i = 0; i < newTracks.length; i++) {
        this._tracks[firstTrack + i] = anchorPixel + newTracks[i].end;
    }

    return firstTrack;
};


Timeline.CompactEventPainter.prototype._paintEventIcon = function(commonData, iconData, top, left, metrics, theme) {
    var img = SimileAjax.Graphics.createTranslucentImage(iconData.url);
    var iconDiv = this._timeline.getDocument().createElement("div");
    iconDiv.className = 'timeline-event-icon' + ("className" in iconData ? (" " + iconData.className) : "");
    iconDiv.style.left = left + "px";
    iconDiv.style.top = top + "px";
    iconDiv.appendChild(img);

    if ("tooltip" in commonData && typeof commonData.tooltip == "string") {
        iconDiv.title = commonData.tooltip;
    }

    this._eventLayer.appendChild(iconDiv);

    return {
        left:   left,
        top:    top,
        width:  metrics.iconWidth,
        height: metrics.iconHeight,
        elmt:   iconDiv
    };
};

Timeline.CompactEventPainter.prototype._paintEventLabel = function(commonData, labelData, left, top, width, height, theme) {
    var doc = this._timeline.getDocument();

    var labelDiv = doc.createElement("div");
    labelDiv.className = 'timeline-event-label';

    labelDiv.style.left = left + "px";
    labelDiv.style.width = (width + 1) + "px";
    labelDiv.style.top = top + "px";
    labelDiv.innerHTML = labelData.text;

    if ("tooltip" in commonData && typeof commonData.tooltip == "string") {
        labelDiv.title = commonData.tooltip;
    }
    if ("color" in labelData && typeof labelData.color == "string") {
        labelDiv.style.color = labelData.color;
    }
    if ("className" in labelData && typeof labelData.className == "string") {
        labelDiv.className += ' ' + labelData.className;
    }

    this._eventLayer.appendChild(labelDiv);

    return {
        left:   left,
        top:    top,
        width:  width,
        height: height,
        elmt:   labelDiv
    };
};

Timeline.CompactEventPainter.prototype._paintEventTape = function(
    commonData, tapeData, height, top, startPixel, endPixel, color, opacity, metrics, theme) {

    var width = endPixel - startPixel;

    var tapeDiv = this._timeline.getDocument().createElement("div");
    tapeDiv.className = "timeline-event-tape"

    tapeDiv.style.left = startPixel + "px";
    tapeDiv.style.top = top + "px";
    tapeDiv.style.width = width + "px";
    tapeDiv.style.height = height + "px";

    if ("tooltip" in commonData && typeof commonData.tooltip == "string") {
        tapeDiv.title = commonData.tooltip;
    }
    if (color != null && typeof tapeData.color == "string") {
        tapeDiv.style.backgroundColor = color;
    }

    if ("backgroundImage" in tapeData && typeof tapeData.backgroundImage == "string") {
        tapeDiv.style.backgroundImage = "url(" + backgroundImage + ")";
        tapeDiv.style.backgroundRepeat =
            ("backgroundRepeat" in tapeData && typeof tapeData.backgroundRepeat == "string")
                ? tapeData.backgroundRepeat : 'repeat';
    }

    SimileAjax.Graphics.setOpacity(tapeDiv, opacity);

    if ("className" in tapeData && typeof tapeData.className == "string") {
        tapeDiv.className += ' ' + tapeData.className;
    }

    this._eventLayer.appendChild(tapeDiv);

    return {
        left:   startPixel,
        top:    top,
        width:  width,
        height: height,
        elmt:   tapeDiv
    };
}

Timeline.CompactEventPainter.prototype._createHighlightDiv = function(highlightIndex, dimensions, theme) {
    if (highlightIndex >= 0) {
        var doc = this._timeline.getDocument();
        var eventTheme = theme.event;

        var color = eventTheme.highlightColors[Math.min(highlightIndex, eventTheme.highlightColors.length - 1)];

        var div = doc.createElement("div");
        div.style.position = "absolute";
        div.style.overflow = "hidden";
        div.style.left =    (dimensions.left - 2) + "px";
        div.style.width =   (dimensions.width + 4) + "px";
        div.style.top =     (dimensions.top - 2) + "px";
        div.style.height =  (dimensions.height + 4) + "px";
//        div.style.background = color;

        this._highlightLayer.appendChild(div);
    }
};

Timeline.CompactEventPainter.prototype._onClickMultiplePreciseInstantEvent = function(icon, domEvt, events) {
    var c = SimileAjax.DOM.getPageCoordinates(icon);
    this._showBubble(
        c.left + Math.ceil(icon.offsetWidth / 2),
        c.top + Math.ceil(icon.offsetHeight / 2),
        events
    );

    var ids = [];
    for (var i = 0; i < events.length; i++) {
        ids.push(events[i].getID());
    }
    this._fireOnSelect(ids);

    domEvt.cancelBubble = true;
    SimileAjax.DOM.cancelEvent(domEvt);

    return false;
};

Timeline.CompactEventPainter.prototype._onClickInstantEvent = function(icon, domEvt, evt) {
    var c = SimileAjax.DOM.getPageCoordinates(icon);
    this._showBubble(
        c.left + Math.ceil(icon.offsetWidth / 2),
        c.top + Math.ceil(icon.offsetHeight / 2),
        [evt]
    );
    this._fireOnSelect([evt.getID()]);

    domEvt.cancelBubble = true;
    SimileAjax.DOM.cancelEvent(domEvt);
    return false;
};

Timeline.CompactEventPainter.prototype._onClickDurationEvent = function(target, domEvt, evt) {
    if ("pageX" in domEvt) {
        var x = domEvt.pageX;
        var y = domEvt.pageY;
    } else {
        var c = SimileAjax.DOM.getPageCoordinates(target);
        var x = domEvt.offsetX + c.left;
        var y = domEvt.offsetY + c.top;
    }
    this._showBubble(x, y, [evt]);
    this._fireOnSelect([evt.getID()]);

    domEvt.cancelBubble = true;
    SimileAjax.DOM.cancelEvent(domEvt);
    return false;
};

Timeline.CompactEventPainter.prototype.showBubble = function(evt) {
    var elmt = this._eventIdToElmt[evt.getID()];
    if (elmt) {
        var c = SimileAjax.DOM.getPageCoordinates(elmt);
        this._showBubble(c.left + elmt.offsetWidth / 2, c.top + elmt.offsetHeight / 2, [evt]);
    }
};

Timeline.CompactEventPainter.prototype._showBubble = function(x, y, evts) {
    var div = document.createElement("div");

    evts = ("fillInfoBubble" in evts) ? [evts] : evts;
    for (var i = 0; i < evts.length; i++) {
        var div2 = document.createElement("div");
        div.appendChild(div2);

        evts[i].fillInfoBubble(div2, this._params.theme, this._band.getLabeller());
    }

    SimileAjax.WindowManager.cancelPopups();
    SimileAjax.Graphics.createBubbleForContentAndPoint(div, x, y, this._params.theme.event.bubble.width);
};

Timeline.CompactEventPainter.prototype._fireOnSelect = function(eventIDs) {
    for (var i = 0; i < this._onSelectListeners.length; i++) {
        this._onSelectListeners[i](eventIDs);
    }
};
