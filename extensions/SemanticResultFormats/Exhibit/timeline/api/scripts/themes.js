/*==================================================
 *  Classic Theme
 *==================================================
 */



Timeline.ClassicTheme = new Object();

Timeline.ClassicTheme.implementations = [];

Timeline.ClassicTheme.create = function(locale) {
    if (locale == null) {
        locale = Timeline.getDefaultLocale();
    }
    
    var f = Timeline.ClassicTheme.implementations[locale];
    if (f == null) {
        f = Timeline.ClassicTheme._Impl;
    }
    return new f();
};

Timeline.ClassicTheme._Impl = function() {
    this.firstDayOfWeek = 0; // Sunday
          
    // Note: Many styles previously set here are now set using CSS
    //       The comments indicate settings controlled by CSS, not
    //       lines to be un-commented.
    //
    //
    // Attributes autoWidth, autoWidthAnimationTime, timeline_start 
    // and timeline_stop must be set on the first band's theme.
    // The other attributes can be set differently for each 
    // band by using different themes for the bands.
    this.autoWidth = false; // Should the Timeline automatically grow itself, as
                            // needed when too many events for the available width
                            // are painted on the visible part of the Timeline?
    this.autoWidthAnimationTime = 500; // mSec
    this.timeline_start = null; // Setting a date, eg new Date(Date.UTC(2008,0,17,20,00,00,0)) will prevent the
                                // Timeline from being moved to anytime before the date.
    this.timeline_stop = null;  // Use for setting a maximum date. The Timeline will not be able 
                                // to be moved to anytime after this date.
    this.ether = {
        backgroundColors: [
        //    "#EEE",
        //    "#DDD",
        //    "#CCC",
        //    "#AAA"
        ],
     //   highlightColor:     "white",
        highlightOpacity:   50,
        interval: {
            line: {
                show:       true,
                opacity:    25
               // color:      "#aaa",
            },
            weekend: {
                opacity:    30
              //  color:      "#FFFFE0",
            },
            marker: {
                hAlign:     "Bottom",
                vAlign:     "Right"
                                        /*
                hBottomStyler: function(elmt) {
                    elmt.className = "timeline-ether-marker-bottom";
                },
                hBottomEmphasizedStyler: function(elmt) {
                    elmt.className = "timeline-ether-marker-bottom-emphasized";
                },
                hTopStyler: function(elmt) {
                    elmt.className = "timeline-ether-marker-top";
                },
                hTopEmphasizedStyler: function(elmt) {
                    elmt.className = "timeline-ether-marker-top-emphasized";
                },
                */
                                        
                    
               /*
                                  vRightStyler: function(elmt) {
                    elmt.className = "timeline-ether-marker-right";
                },
                vRightEmphasizedStyler: function(elmt) {
                    elmt.className = "timeline-ether-marker-right-emphasized";
                },
                vLeftStyler: function(elmt) {
                    elmt.className = "timeline-ether-marker-left";
                },
                vLeftEmphasizedStyler:function(elmt) {
                    elmt.className = "timeline-ether-marker-left-emphasized";
                }
                */
            }
        }
    };
    
    this.event = {
        track: {
                   height: 10, // px. You will need to change the track
                               //     height if you change the tape height.
                      gap:  2, // px. Gap between tracks
                   offset:  2, // px. top margin above tapes
          autoWidthMargin:  1.5
          /* autoWidthMargin is only used if autoWidth (see above) is true.
             The autoWidthMargin setting is used to set how close the bottom of the
             lowest track is to the edge of the band's div. The units are total track
             width (tape + label + gap). A min of 0.5 is suggested. Use this setting to
             move the bottom track's tapes above the axis markers, if needed for your
             Timeline.
          */
        },
        overviewTrack: {
                  offset: 20, // px -- top margin above tapes 
              tickHeight:  6, // px
                  height:  2, // px
                     gap:  1, // px
         autoWidthMargin:  5 // This attribute is only used if autoWidth (see above) is true.
        },
        tape: {
            height:         4 // px. For thicker tapes, remember to change track height too.
        },
        instant: {
                           icon: Timeline.urlPrefix + "images/dull-blue-circle.png", 
                                 // default icon. Icon can also be specified per event
                      iconWidth: 10,
                     iconHeight: 10,
               impreciseOpacity: 20, // opacity of the tape when durationEvent is false
            impreciseIconMargin: 3   // A tape and an icon are painted for imprecise instant
                                     // events. This attribute is the margin between the
                                     // bottom of the tape and the top of the icon in that
                                     // case.
    //        color:             "#58A0DC",
    //        impreciseColor:    "#58A0DC",
        },
        duration: {
            impreciseOpacity: 20 // tape opacity for imprecise part of duration events
      //      color:            "#58A0DC",
      //      impreciseColor:   "#58A0DC",
        },
        label: {
            backgroundOpacity: 50,// only used in detailed painter
               offsetFromLine:  3 // px left margin amount from icon's right edge
      //      backgroundColor:   "white",
      //      lineColor:         "#58A0DC",
        },
        highlightColors: [  // Use with getEventPainter().setHighlightMatcher
                            // See webapp/examples/examples.js
            "#FFFF00",
            "#FFC000",
            "#FF0000",
            "#0000FF"
        ],
        highlightLabelBackground: false, // When highlighting an event, also change the event's label background?
        bubble: {
            width:          250, // px
            maxHeight:        0, // px Maximum height of bubbles. 0 means no max height. 
                                 // scrollbar will be added for taller bubbles
            titleStyler: function(elmt) {
                elmt.className = "timeline-event-bubble-title";
            },
            bodyStyler: function(elmt) {
                elmt.className = "timeline-event-bubble-body";
            },
            imageStyler: function(elmt) {
                elmt.className = "timeline-event-bubble-image";
            },
            wikiStyler: function(elmt) {
                elmt.className = "timeline-event-bubble-wiki";
            },
            timeStyler: function(elmt) {
                elmt.className = "timeline-event-bubble-time";
            }
        }
    };
    
    this.mouseWheel = 'scroll'; // 'default', 'zoom', 'scroll'
};