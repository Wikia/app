/*==================================================
 *  Exhibit.TimelineView
 *==================================================
 */

Exhibit.TimelineView = function(containerElmt, uiContext) {
    this._div = containerElmt;
    this._uiContext = uiContext;

    this._settings = {};
    this._accessors = {
        getEventLabel:  function(itemID, database, visitor) { visitor(database.getObject(itemID, "label")); },
        getProxy:       function(itemID, database, visitor) { visitor(itemID); },
        getColorKey:    null,
        getIconKey:     null
    };

    this._selectListener = null;
    this._largestSize = 0;

    var view = this;
    this._listener = {
        onItemsChanged: function() {
            view._reconstruct();
        }
    };
    uiContext.getCollection().addListener(this._listener);
};

Exhibit.TimelineView._intervalChoices = [
    "millisecond", "second", "minute", "hour", "day", "week", "month", "year", "decade", "century", "millennium"
];

Exhibit.TimelineView._settingSpecs = {
    "topBandHeight":           { type: "int",        defaultValue: 75 },
    "topBandUnit":             { type: "enum",       choices: Exhibit.TimelineView._intervalChoices },
    "topBandPixelsPerUnit":    { type: "int",        defaultValue: 200 },
    "bottomBandHeight":        { type: "int",        defaultValue: 25 },
    "bottomBandUnit":          { type: "enum",       choices: Exhibit.TimelineView._intervalChoices },
    "bottomBandPixelsPerUnit": { type: "int",        defaultValue: 200 },
    "timelineHeight":          { type: "int",        defaultValue: 400 },
    "timelineConstructor":     { type: "function",   defaultValue: null },
    "colorCoder":              { type: "text",       defaultValue: null },
    "iconCoder":               { type: "text",       defaultValue: null },
    "selectCoordinator":       { type: "text",       defaultValue: null },
    "showHeader":              { type: "boolean",    defaultValue: true },
    "showSummary":             { type: "boolean",    defaultValue: true },
    "showFooter":              { type: "boolean",    defaultValue: true }
};

Exhibit.TimelineView._accessorSpecs = [
    {   accessorName:   "getProxy",
        attributeName:  "proxy"
    },
    {   accessorName: "getDuration",
        bindings: [
            {   attributeName:  "start",
                type:           "date",
                bindingName:    "start"
            },
            {   attributeName:  "end",
                type:           "date",
                bindingName:    "end",
                optional:       true
            }
        ]
    },
    {   accessorName:   "getColorKey",
        attributeName:  "marker", // backward compatibility
        type:           "text"
    },
    {   accessorName:   "getColorKey",
        attributeName:  "colorKey",
        type:           "text"
    },
    {   accessorName:   "getIconKey",
        attributeName:  "iconKey",
        type:           "text"
    },
    {   accessorName:   "getEventLabel",
        attributeName:  "eventLabel",
        type:           "text"
    },
    {
        accessorName:   "getHoverText",
        attributeName:  "hoverText",
        type:           "text"
    }
];


Exhibit.TimelineView.create = function(configuration, containerElmt, uiContext) {
    var view = new Exhibit.TimelineView(
        containerElmt,
        Exhibit.UIContext.create(configuration, uiContext)
    );
    Exhibit.TimelineView._configure(view, configuration);

    view._internalValidate();
    view._initializeUI();
    return view;
};

Exhibit.TimelineView.createFromDOM = function(configElmt, containerElmt, uiContext) {
    var configuration = Exhibit.getConfigurationFromDOM(configElmt);
    var view = new Exhibit.TimelineView(
        containerElmt != null ? containerElmt : configElmt,
        Exhibit.UIContext.createFromDOM(configElmt, uiContext)
    );

    Exhibit.SettingsUtilities.createAccessorsFromDOM(configElmt, Exhibit.TimelineView._accessorSpecs, view._accessors);
    Exhibit.SettingsUtilities.collectSettingsFromDOM(configElmt, Exhibit.TimelineView._settingSpecs, view._settings);
    Exhibit.TimelineView._configure(view, configuration);

    view._internalValidate();
    view._initializeUI();
    return view;
};

Exhibit.TimelineView._configure = function(view, configuration) {
    Exhibit.SettingsUtilities.createAccessors(configuration, Exhibit.TimelineView._accessorSpecs, view._accessors);
    Exhibit.SettingsUtilities.collectSettings(configuration, Exhibit.TimelineView._settingSpecs, view._settings);

    var accessors = view._accessors;
    view._getDuration = function(itemID, database, visitor) {
        accessors.getProxy(itemID, database, function(proxy) {
            accessors.getDuration(proxy, database, visitor);
        });
    };
};

Exhibit.TimelineView.prototype.dispose = function() {
    this._uiContext.getCollection().removeListener(this._listener);

    this._timeline = null;

    if (this._selectListener != null) {
        this._selectListener.dispose();
        this._selectListener = null;
    }

    this._toolboxWidget.dispose();
    this._toolboxWidget = null;

    this._dom.dispose();
    this._dom = null;

    this._div.innerHTML = "";
    this._div = null;

    this._uiContext.dispose();
    this._uiContext = null;
};

Exhibit.TimelineView.prototype._internalValidate = function() {
    if ("getColorKey" in this._accessors) {
        if ("colorCoder" in this._settings) {
            this._colorCoder = this._uiContext.getExhibit().getComponent(this._settings.colorCoder);
        }

        if (this._colorCoder == null) {
            this._colorCoder = new Exhibit.DefaultColorCoder(this._uiContext);
        }
    }
    if ("getIconKey" in this._accessors) {
        this._iconCoder = null;
        if ("iconCoder" in this._settings) {
            this._iconCoder = this._uiContext.getExhibit().getComponent(this._settings.iconCoder);
        }
    }
    if ("selectCoordinator" in this._settings) {
        var selectCoordinator = exhibit.getComponent(this._settings.selectCoordinator);
        if (selectCoordinator != null) {
            var self = this;
            this._selectListener = selectCoordinator.addListener(function(o) {
                self._select(o);
            });
        }
    }
};

Exhibit.TimelineView.prototype._initializeUI = function() {
    var self = this;
    var legendWidgetSettings = {};

    legendWidgetSettings.colorGradient = (this._colorCoder != null && "_gradientPoints" in this._colorCoder);
    legendWidgetSettings.iconMarkerGenerator = function(iconURL) {
        elmt = document.createElement('img');
        elmt.src = iconURL;
        elmt.style.verticalAlign = "middle";
        return elmt;
    }

    this._div.innerHTML = "";
    this._dom = Exhibit.ViewUtilities.constructPlottingViewDom(
        this._div,
        this._uiContext,
        this._settings.showSummary && this._settings.showHeader,
        {   onResize: function() {
                self._timeline.layout();
            }
        },
        legendWidgetSettings
    );
    this._toolboxWidget = Exhibit.ToolboxWidget.createFromDOM(this._div, this._div, this._uiContext);

    this._eventSource = new Timeline.DefaultEventSource();
    this._reconstruct();
};

Exhibit.TimelineView.prototype._reconstructTimeline = function(newEvents) {
    var settings = this._settings;

    if (this._timeline != null) {
        this._timeline.dispose();
    }

    if (newEvents) {
        this._eventSource.addMany(newEvents);
    }

    var timelineDiv = this._dom.plotContainer;
    if (settings.timelineConstructor != null) {
        this._timeline = settings.timelineConstructor(timelineDiv, this._eventSource);
    } else {
        timelineDiv.style.height = settings.timelineHeight + "px";
        timelineDiv.className = "exhibit-timelineView-timeline";

        var theme = Timeline.ClassicTheme.create();
        theme.event.bubble.width = this._uiContext.getSetting("bubbleWidth");
        theme.event.bubble.height = this._uiContext.getSetting("bubbleHeight");

        var topIntervalUnit, bottomIntervalUnit;
        if (settings.topBandUnit != null || settings.bottomBandUnit != null) {
            if (Exhibit.TimelineView._intervalLabelMap == null) {
                Exhibit.TimelineView._intervalLabelMap = {
                    "millisecond":      Timeline.DateTime.MILLISECOND,
                    "second":           Timeline.DateTime.SECOND,
                    "minute":           Timeline.DateTime.MINUTE,
                    "hour":             Timeline.DateTime.HOUR,
                    "day":              Timeline.DateTime.DAY,
                    "week":             Timeline.DateTime.WEEK,
                    "month":            Timeline.DateTime.MONTH,
                    "year":             Timeline.DateTime.YEAR,
                    "decade":           Timeline.DateTime.DECADE,
                    "century":          Timeline.DateTime.CENTURY,
                    "millennium":       Timeline.DateTime.MILLENNIUM
                };
            }

            if (settings.topBandUnit == null) {
                bottomIntervalUnit = Exhibit.TimelineView._intervalLabelMap[settings.bottomBandUnit];
                topIntervalUnit = bottomIntervalUnit - 1;
            } else if (settings.bottomBandUnit == null) {
                topIntervalUnit = Exhibit.TimelineView._intervalLabelMap[settings.topBandUnit];
                bottomIntervalUnit = topIntervalUnit + 1;
            } else {
                topIntervalUnit = Exhibit.TimelineView._intervalLabelMap[settings.topBandUnit];
                bottomIntervalUnit = Exhibit.TimelineView._intervalLabelMap[settings.bottomBandUnit];
            }
        } else { // figure this out dynamically
            var earliest = this._eventSource.getEarliestDate();
            var latest = this._eventSource.getLatestDate();

            var totalDuration = latest.getTime() - earliest.getTime();
            var totalEventCount = this._eventSource.getCount();
            if (totalDuration > 0 && totalEventCount > 1) {
                var totalDensity = totalEventCount / totalDuration;

                var topIntervalUnit = Timeline.DateTime.MILLENNIUM;
                while (topIntervalUnit > 0) {
                    var intervalDuration = Timeline.DateTime.gregorianUnitLengths[topIntervalUnit];
                    var eventsPerPixel = totalDensity * intervalDuration / settings.topBandPixelsPerUnit;
                    if (eventsPerPixel < 0.01) {
                        break;
                    }
                    topIntervalUnit--;
                }
            } else {
                topIntervalUnit = Timeline.DateTime.YEAR;
            }
            bottomIntervalUnit = topIntervalUnit + 1;
        }

        var bandInfos = [
            Timeline.createBandInfo({
                width:          settings.topBandHeight + "%",
                intervalUnit:   topIntervalUnit,
                intervalPixels: settings.topBandPixelsPerUnit,
                eventSource:    this._eventSource,
                //date:           earliest,
                theme:          theme
            }),
            Timeline.createBandInfo({
                width:          settings.bottomBandHeight + "%",
                intervalUnit:   bottomIntervalUnit,
                intervalPixels: settings.bottomBandPixelsPerUnit,
                eventSource:    this._eventSource,
                //date:           earliest,
                overview:       true,
                theme:          theme
            })
        ];
        bandInfos[1].syncWith = 0;
        bandInfos[1].highlight = true;

        this._timeline = Timeline.create(timelineDiv, bandInfos, Timeline.HORIZONTAL);
    }

    var self = this;
    var listener = function(eventID) {
        if (self._selectListener != null) {
            self._selectListener.fire({ itemIDs: [ eventID ] });
        }
    }
    for (var i = 0; i < this._timeline.getBandCount(); i++) {
        this._timeline.getBand(i).getEventPainter().addOnSelectListener(listener);
    }
};

Exhibit.TimelineView.prototype._reconstruct = function() {
    var self = this;
    var collection = this._uiContext.getCollection();
    var database = this._uiContext.getDatabase();
    var settings = this._settings;
    var accessors = this._accessors;

    /*
     *  Get the current collection and check if it's empty
     */
    var currentSize = collection.countRestrictedItems();
    var unplottableItems = [];

    this._dom.legendWidget.clear();
    this._eventSource.clear();

    if (currentSize > 0) {
        var currentSet = collection.getRestrictedItems();
        var hasColorKey = (this._accessors.getColorKey != null);
        var hasIconKey = (this._accessors.getIconKey != null && this._iconCoder != null);
        var hasHoverText = (this._accessors.getHoverText != null);
        var colorCodingFlags = { mixed: false, missing: false, others: false, keys: new Exhibit.Set() };
        var iconCodingFlags = { mixed: false, missing: false, others: false, keys: new Exhibit.Set() };
        var events = [];

        var addEvent = function(itemID, duration, color, icon, hoverText) {
            var label;
            accessors.getEventLabel(itemID, database, function(v) { label = v; return true; });

            var evt = new Timeline.DefaultEventSource.Event({
                id:             itemID,
                eventID:        itemID,
                start:          duration.start,
                end:            duration.end,
                instant:        duration.end == null,
                text:           label,
                description:    "",
                icon:           icon,
                color:          color,
                textColor:      color,
                hoverText:      hoverText
            });
            evt._itemID = itemID;
            evt.getProperty = function(name) {
                return database.getObject(this._itemID, name);
            };
            evt.fillInfoBubble = function(elmt, theme, labeller) {
                self._fillInfoBubble(this, elmt, theme, labeller);
            };

            events.push(evt);
        };

        currentSet.visit(function(itemID) {
            var durations = [];
            self._getDuration(itemID, database, function(duration) { if ("start" in duration) durations.push(duration); });

            if (durations.length > 0) {
                var color = null;
                var icon = null;
                var hoverText = null;
                if (hasColorKey) {
                    var colorKeys = new Exhibit.Set();
                    accessors.getColorKey(itemID, database, function(key) { colorKeys.add(key); });

                    color = self._colorCoder.translateSet(colorKeys, colorCodingFlags);
                }

                var icon = null;
                if (hasIconKey) {
                    var iconKeys = new Exhibit.Set();
                    accessors.getIconKey(itemID, database, function(key) { iconKeys.add(key); });

                    icon = self._iconCoder.translateSet(iconKeys, iconCodingFlags);
                }

                if(hasHoverText) {
                    var hoverKeys = new Exhibit.Set();
                    accessors.getHoverText(itemID, database, function(key) { hoverKeys.add(key); });
                    for(var i in hoverKeys._hash)
                        hoverText = i;
                }

                for (var i = 0; i < durations.length; i++) {
                    addEvent(itemID, durations[i], color, icon, hoverText);
                }
            } else {
                unplottableItems.push(itemID);
            }
        });

        if (hasColorKey) {
            var legendWidget = this._dom.legendWidget;
            var colorCoder = this._colorCoder;
            var keys = colorCodingFlags.keys.toArray().sort();
            if(this._colorCoder._gradientPoints != null) {
                legendWidget.addGradient(this._colorCoder._gradientPoints);
            } else {
                for (var k = 0; k < keys.length; k++) {
                    var key = keys[k];
                    var color = colorCoder.translate(key);
                    legendWidget.addEntry(color, key);
                }
            }

            if (colorCodingFlags.others) {
                legendWidget.addEntry(colorCoder.getOthersColor(), colorCoder.getOthersLabel());
            }
            if (colorCodingFlags.mixed) {
                legendWidget.addEntry(colorCoder.getMixedColor(), colorCoder.getMixedLabel());
            }
            if (colorCodingFlags.missing) {
                legendWidget.addEntry(colorCoder.getMissingColor(), colorCoder.getMissingLabel());
            }
        }

        if (hasIconKey) {
            var legendWidget = this._dom.legendWidget;
            var iconCoder = this._iconCoder;
            var keys = iconCodingFlags.keys.toArray().sort();
            if (settings.iconLegendLabel != null) {
                legendWidget.addLegendLabel(settings.iconLegendLabel, 'icon');
            }
            for (var k = 0; k < keys.length; k++) {
                var key = keys[k];
                var icon = iconCoder.translate(key);
                legendWidget.addEntry(icon, key, 'icon');
            }
            if (iconCodingFlags.others) {
                legendWidget.addEntry(iconCoder.getOthersIcon(), iconCoder.getOthersLabel(), 'icon');
            }
            if (iconCodingFlags.mixed) {
                legendWidget.addEntry(iconCoder.getMixedIcon(), iconCoder.getMixedLabel(), 'icon');
            }
            if (iconCodingFlags.missing) {
                legendWidget.addEntry(iconCoder.getMissingIcon(), iconCoder.getMissingLabel(), 'icon');
            }
        }

        var plottableSize = currentSize - unplottableItems.length;
        if (plottableSize > this._largestSize) {
            this._largestSize = plottableSize;
            this._reconstructTimeline(events);
        } else {
            this._eventSource.addMany(events);
        }

        var band = this._timeline.getBand(0);
        var centerDate = band.getCenterVisibleDate();
        var earliest = this._eventSource.getEarliestDate();
        var latest = this._eventSource.getLatestDate();
        if (earliest != null && centerDate < earliest) {
            band.scrollToCenter(earliest);
        } else if (latest != null && centerDate > latest) {
            band.scrollToCenter(latest);
        }
    }
    this._dom.setUnplottableMessage(currentSize, unplottableItems);
};

Exhibit.TimelineView.prototype._select = function(selection) {
    var itemID = selection.itemIDs[0];
    var c = this._timeline.getBandCount();
    for (var i = 0; i < c; i++) {
        var band = this._timeline.getBand(i);
        var evt = band.getEventSource().getEvent(itemID);
        if (evt) {
            band.showBubbleForEvent(itemID);
            break;
        }
    }
};

Exhibit.TimelineView.prototype._fillInfoBubble = function(evt, elmt, theme, labeller) {
    this._uiContext.getLensRegistry().createLens(evt._itemID, elmt, this._uiContext);
};
