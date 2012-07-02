/*
 * ElmEasyRef v 0.8.2b:
 * Add popup field to display reference's content
 * When user click on reference he would be not jumped down to "References" section.
 * Text will be shown in popup field
 *
 * author: Elancev Michael
 */

// addEventListener || attachEvent to elem
//
function elm_addEvent( elem, event, func ){
    if ( elem.addEventListener ) {
        elem.addEventListener( event, func, false );
    } else {
        // For IE <9
        var self = elem;
        elem.attachEvent(
            // Event type
            'on' + event,

            // Callback
            function() {
                var event = {
                    target:        window.event.srcElement,
                    currentTarget: self,
                    ctrlKey:       window.event.ctrlKey,
                    keyCode:       window.event.keyCode,
                    eventObj:      window.event,

                    preventDefault:  function (){ this.eventObj.returnValue = false; },
                    stopPropagation: function (){ this.eventObj.cancelBubble = true; }
                };
                return func.apply( self, [event] );
            }
        );

    }
}


// Check if classname is in elem.className
//
function elm_hasClass( elem, classname ){
    var classes = elem.className;
    if ( classes == classname ) return true;
    var whitespace = /\s+/;
    if ( !whitespace.test( classes ) ) return false;
    var cs = classes.split( whitespace );
    for ( var i = 0; i < cs.length; i++ ){
        if ( cs[i] == classname ) return true;
    }
    return false;
}

// Find elements with class classname in all children of elem
// Return array of founded elems
//
function elm_getElementsByClassName( elem, classname ){
    if ( elem.getElementsByClassName ){
        return elem.getElementsByClassName( classname );

    } else {
        var elements = elem.getElementsByTagName( "*" );

        if ( !classname ) return elements;

        var returnlist = [];
        for ( var i = 0; i < elements.length; i++ ){
            if ( elm_hasClass(elements[i], classname)) returnlist.push(elements[i]);
        }

        return returnlist;
    }
}

// Determine current window size
// Return {x: <val>, y: <val>} - width and height of window
//
function elm_getWindowSize(){
    if( typeof( window.innerWidth ) == 'number' ) {
        //Non-IE
        return {x: window.innerWidth, y: window.innerHeight};
    } else if( document.documentElement && typeof(document.documentElement.clientWidth) == 'number') {
        //IE 6+ in 'standards compliant mode'
        return {x: document.documentElement.clientWidth, y: document.documentElement.clientHeight};

    // Not compatible
    } else return false;
}

// Determine window scroll position
// Return {x: <val>, y: <val>} - left and top scroll position
//
function elm_getWindowScroll(){
    if( typeof( window.pageYOffset ) == 'number' ) {
        //
        return {x: window.pageXOffset, y: window.pageYOffset};
    } else if( document.body && (document.body.scrollLeft || document.body.scrollTop)) {
        //
        return {x: document.body.scrollLeft, y: document.body.scrollTop};
    } else if ( document.documentElement && typeof(document.documentElement.scrollLeft) == 'number') {
        //
        return {x: document.documentElement.scrollLeft, y: document.documentElement.scrollTop};

    // Not compatible
    } else return false;
}

// Main object
//      - keep properties of extension
//      - init extension
//      - control global event listeners
//
var elmEasyRef = {
    // Show debug alerts
    debug: false,

    // Nodes
    references: null,       // block with text of references
    refField:   null,       // block where reference text will be displayed
    refText:    null,       // node which contain text of reference

    // Id of node that contain article
    bodyContentId: "bodyContent",

    // Retrieve data regular expression
    // retrieve number of reference (for links look like: [123])
    regRefNum_rp:  /(<.*?>)/,    // strip that first
    regRefNum_mt:  /([0-9]+)/,   // search

    // Displayed messages
    messages: {
            elm_easyref_ref:   'Reference $1',
            elm_easyref_close: 'Close'
        },

    // Animation properties
    animation: {
        enable: true,
        delay:  50,
        stepw:  2,
        steph:  3
    },

    // Field metrics
    fieldm: {
        // Min size of popup field
        min_width:  140,
        min_height:  40,

        // Size of collapsed popup field
        col_width:  400,
        col_height: 140,

        // Size of expanded popup field (Max size)
        exp_width:  400,
        exp_height: 380
    },

    // Keep pointer to last clicked reference node
    lastRef: null,

    // Add event listeners to references
    prepare: function(){
            // where search references
            var bodyContent = document.getElementById( this.bodyContentId );
            if ( !bodyContent ) {
                if ( this.debug ) alert( "bodyContent node not found" );
                return;
            }


            // add event listeneres to all refs
            var elems = elm_getElementsByClassName( bodyContent, "reference" );
            for ( var i = 0; i < elems.length; i++ ){
                if ( elems[i].firstChild && elems[i].firstChild.tagName == "A" ){
                    elm_addEvent( elems[i].firstChild, "click", this.refClickListener );
                }
            }

            // if references are in page
            if ( elems.length ){
                // block with text of references
                this.references = elm_getElementsByClassName( bodyContent, "references" )[0];
                if ( !this.references ) {
                    if ( this.debug ) alert( "References block not found" );
                    return;
                }

                // element which temporary keep reference's text
                this.refText = document.createElement( "div" );
            }


            // Close shown popup field, when user click out of field
            elm_addEvent( document.body,
                          "mousedown",
                          function( event ){
                            if ( elmEasyRef.refField && elmEasyRef.refField.is_shown &&
                                 elmEasyRef.lastRef != event.target &&
                                 !elmEasyRef.refField.isInsideField(event.target) ){

                                    elmEasyRef.refField.hide();
                            }
                        }
                  );


            // Update popup position, wnen user resize window
            elm_addEvent( window,
                          "resize",
                          function( event ){
                            if ( elmEasyRef.refField && elmEasyRef.refField.is_shown ){
                                    elmEasyRef.refField.updatePos();
                            }
                        }
                  );
        },

    // Mouse click event listener for reference
    refClickListener: function( event ){
            var n = event.currentTarget,
                rf = elmEasyRef.refField;

            if ( elmEasyRef.lastRef == n && rf && rf.is_shown ) {
                // Click when already shown -> hide popup
                rf.hide();
            } else {
                // Show popup
                if ( !elmEasyRef.showRefField(n) ) return;
            }
            event.preventDefault();
            elmEasyRef.lastRef = n;
        },

    // Show popup reference field for reference node
    // Return true if all ok, and false if error
    showRefField: function( node ){
        var refContent = document.getElementById( node.hash.substr(1) );
        if ( !refContent) {
            if ( this.debug) alert( "Reference content not found" );
            return false;
        }

        this.refText.innerHTML = refContent.innerHTML;
        this.cutUselessNodes(this.refText);

        if ( !this.refField ) {
            // ElmEasyRefField is not initialized yet
            this.refField = new ElmEasyRefField();
        }

        this.refField.setRefLink( this.getRefNum(node), node.href );
        this.refField.setInnerNode( this.refText.innerHTML );
        this.refField.attachToAnchor( node );
        this.refField.show();

        // Free
        this.refText.innerHTML = "";

        return true;
    },

    // Return number of reference
    getRefNum: function ( node ){
        // Cut tags
        var t = String( node.innerHTML ).replace( this.regRefNum_rp, '' );
        // Match number
        t = this.regRefNum_mt.exec( t );

        return (t ? t[0] : 0);
    },

    // Remove needless elems from reference content
    cutUselessNodes: function ( root ){

        // Remove prepend
        var nodes = root.childNodes;
        var i;
        for ( i = nodes.length - 1; i >= 0; i-- ){
            var node = null;
            if ( nodes[i].tagName == "A" ) node = nodes[i];
            else if ( nodes[i].firstChild && nodes[i].firstChild.tagName == "A" ) node = nodes[i].firstChild;


            if ( node && node.hash){
                var wl = window.location.pathname,
                    nl = node.pathname;

                // Make them same
                if (wl.charAt(0) == '/') wl = wl.substr(1);
                if (nl.charAt(0) == '/') nl = nl.substr(1);

                if (wl == nl || nl == 'blank') {
                    // Founded back link to reference
                    // Remove prepend before founded
                    for ( var j = 0; j <= i; j++ ) root.removeChild( nodes[0] );
                    break;
                }
            }
        }


        // Remove <SCRIPT> tag
        nodes = root.getElementsByTagName( "SCRIPT" );

        for ( i = 0; i < nodes.length; i++ ){
            nodes[i].parentNode.removeChild( nodes[i] );
        }

        nodes = null;
    }

};

// Displayable popup reference field
//      - keep settings and state of one popup field
//      - create elems
//      - control event listeners of current field
//      - deal with animation
//
function ElmEasyRefField(){

    // References to important parts of popup field
    this.elems = {
            container:      null,
            frame:          null,
            header:         null,
            link:           null,
            close:          null,
            field:          null,
            content:        null,
            more:           null,
            corner:         null
        };

    // Metrics data
    this.metrics = {
        width:  0,
        height: 0
    };

    // Animation data
    if ( elmEasyRef.animation.enable) {
        this.animation = {
            // Curent values
            curw:       0,
            curh:       0,
            // Interval object
            interval:   null
        };
    }

    // Pointer to attached anchor
    this.anchor = null;

    // Check if shown
    this.is_shown = false;

    //
    // GENERATE DOM
    //
    //    DOM structure:
    //
    //        .elems.container
    //         |- .elemst.frame
    //         |   |- .elems.header
    //         |   |   |- .elems.link    - link to "Reference" Section
    //         |   |   |- .elems.close   - close popup button
    //         |   |
    //         |   |- .elems.field
    //         |       |- .elems.content - keep text of reference
    //         |       |- .elems.more    - expand button
    //         |
    //         |- .elm-easyref-corner

    var el = this.elems.container = document.createElement( "div" );
    el.className = "elm-easyref-container";
    el.style.display = "none";
    el.style.visibility = "hidden";
    el.style.position = "absolute";

    // Create frame
    el = this.elems.frame = document.createElement( "div" );
    el.className = "elm-easyref-frame";
    this.elems.container.appendChild( el );

    // Create corner
    el = this.elems.corner = document.createElement( "div" );
    el.className = "elm-easyref-corner-l";
    this.elems.container.appendChild( el );

    // Create header
    el = this.elems.header = document.createElement( "div" );
    el.className = "elm-easyref-header";
    this.elems.frame.appendChild( el );

    // Create "link" button
    el = this.elems.link = document.createElement( "a" );
    el.href = "#";
    el.className = "elm-easyref-link";
    this.elems.header.appendChild( el );

    // Create "close" button
    el = this.elems.close = document.createElement( "a" );
    el.href = "#";
    el.className = "elm-easyref-close";
    el.title = elmEasyRef.messages.elm_easyref_close;
    this.elems.header.appendChild( el );

    // Create field
    el = this.elems.field = document.createElement( "div" );
    el.className = "elm-easyref-field";
    this.elems.frame.appendChild( el );

    // Create content - will keep content of reference
    el = this.elems.content = document.createElement( "div" );
    el.className = "elm-easyref-content";
    this.elems.field.appendChild( el );

    // Create "more" button
    el = this.elems.more = document.createElement( "div" );
    el.className = "elm-easyref-more";
    el.innerHTML = '<a href="#">...</a>';
    this.elems.field.appendChild( el );

    // Set size of "More" button
    el.style.width = ( elmEasyRef.fieldm.col_width - 2 ) + "px";

    // Append container to document
    document.getElementById( elmEasyRef.bodyContentId ).appendChild( this.elems.container );

    //
    // ADD EVENT LISTENERS
    //

    // hide popup
    elm_addEvent( this.elems.close, 'click', this.closeButtonListener );
    elm_addEvent( this.elems.link,  'click', this.linkButtonListener  );

    // expand popup
    elm_addEvent( this.elems.more, 'click', this.moreButtonListener );

}

// Set label of link to "References" Section
//
ElmEasyRefField.prototype.setRefLink = function( num, href ){
    this.elems.link.href = href;
    this.elems.link.innerHTML = elmEasyRef.messages.elm_easyref_ref.replace( "$1", num );
};

// Set text of reference
ElmEasyRefField.prototype.setInnerNode = function( html ){
    this.elems.content.innerHTML = html;
};



// Show this field (collapse mode) and calc width
//
ElmEasyRefField.prototype.show = function(){
    var cont = this.elems.container;

    // Prepare
    cont.style.display = "block";
    cont.style.visibility = "hidden";

    // Calc metrics

    // Change width to default
    this.elems.field.style.width = elmEasyRef.fieldm.col_width + "px";
    // Get text width
    this.metrics.width = this.elems.content.clientWidth;
    if ( this.metrics.width < elmEasyRef.fieldm.min_width ) {
        this.metrics.width = elmEasyRef.fieldm.min_width;
    }
    // Apply new width
    this.elems.field.style.width = this.metrics.width + "px";
    this.elems.frame.style.width = this.metrics.width + "px";


    // Get text height
    this.metrics.height = this.elems.content.clientHeight;
    if ( this.metrics.height > elmEasyRef.fieldm.col_height ) {
        // More button
        this.metrics.height = elmEasyRef.fieldm.col_height;
        this.elems.more.style.display = "block";
        this.elems.more.style.visibility = "visible";
    } else {
        if ( this.metrics.height < elmEasyRef.fieldm.min_height ) {
            this.metrics.height = elmEasyRef.fieldm.min_height;
        }
        this.elems.more.style.display = "none";
        this.elems.more.style.visibility = "hidden";
    }
    // Apply new height
    this.elems.field.style.height = this.metrics.height + "px";

    // Position
    this.updatePos();

    // Scroll to it
    this.scrollDownToMe();

    // Animation
    if ( this.animation) {
        this.animation.curw = elmEasyRef.fieldm.min_width;
        this.animation.curh = elmEasyRef.fieldm.min_height;
        this.startAnimation();
    }



    // Make visible now
    cont.style.visibility = "visible";
    this.is_shown = true;


};


// Attach this popup to node
// If node will change position, popup should change it too
//
ElmEasyRefField.prototype.attachToAnchor = function( node ){
    this.anchor = node;
};

// Calculate anchor positon relatively of contentBody element
//
ElmEasyRefField.prototype.calcAnchorPos = function(){
    var ret = { x: this.anchor.offsetLeft, y: this.anchor.offsetTop },
        parent = this.anchor.offsetParent;

    while ( parent && parent.id != elmEasyRef.bodyContentId ){
        ret.x += parent.offsetLeft;
        ret.y += parent.offsetTop;
        parent = parent.offsetParent;
    }
    return ret;
};

// Update position of popup field and corner position
//
ElmEasyRefField.prototype.updatePos = function(){
    var cont = this.elems.container;

    var anchpos = this.calcAnchorPos(),
        x = anchpos.x + Math.round( this.anchor.offsetWidth / 2 ),
        y = anchpos.y  + this.anchor.offsetHeight,
        d = cont.offsetParent.offsetWidth - x - cont.clientWidth;

    if ( d < 0) {
       // Need to shift corner
       x += d;
       this.elems.corner.style.left = (-d) + "px";
       if ( cont.clientWidth + d < this.elems.corner.clientWidth ||
             d / cont.clientWidth < -0.5 ){

            // Show right corner
            this.elems.corner.className = "elm-easyref-corner-r";
       } else {

            // Show left corner
            this.elems.corner.className = "elm-easyref-corner-l";
       }
    } else {
       // Show left corner without offset
       this.elems.corner.style.left = '';
       this.elems.corner.className = "elm-easyref-corner-l";
    }

    cont.style.left = (x) + "px";
    cont.style.top  = (y) + "px";

};

// Scroll down to this popup
//
ElmEasyRefField.prototype.scrollDownToMe = function(){
    var cont = this.elems.container;
    if ( cont.getBoundingClientRect && window.scrollTo ){
        var bound = cont.getBoundingClientRect(),
            wsize = elm_getWindowSize(),
            wscroll = elm_getWindowScroll();
        if ( wsize && wscroll && bound.bottom > wsize.y ){
            // If supported
            window.scrollTo( wscroll.x, wscroll.y + bound.bottom - wsize.y + 10 );
        }
    }
};

// Change to expand mode
//
ElmEasyRefField.prototype.expand = function( node ){
    var cont = this.elems.container;

    // Hide more button
    this.elems.more.style.visibility = "hidden";
    this.elems.more.style.display = "none";

    // Calc metrics

    // Get text width
    this.metrics.width = elmEasyRef.fieldm.exp_width;
    // Apply new width
    this.elems.field.style.width = this.metrics.width + "px";
    this.elems.frame.style.width = this.metrics.width + "px";


    // Get text height
    this.metrics.height = this.elems.content.clientHeight;
    if ( this.metrics.height > elmEasyRef.fieldm.exp_height ) {
        // Add scroll
        this.metrics.height = elmEasyRef.fieldm.exp_height;
        this.elems.field.style.overflow = "auto";
    }

    // Apply new height
    this.elems.field.style.height = this.metrics.height + "px";

    // Position
    this.updatePos();

    // Scroll to it
    this.scrollDownToMe();

    // Animation
    if ( this.animation) {
        this.animation.curw = elmEasyRef.fieldm.col_width;
        this.animation.curh = elmEasyRef.fieldm.col_height;
        this.startAnimation();
    }



};

// Clear expand mode
ElmEasyRefField.prototype.removeExpandStyles = function(){
    this.elems.field.style.overflow = "";
    this.elems.field.scrollTop = 0;
}

// Hide this popup
//
ElmEasyRefField.prototype.hide = function(){
    this.finishAnimation();

    var cont = this.elems.container;
    cont.style.left = "-1000px";
    cont.style.top  = "-1000px";
    cont.style.visibility = "hidden";
    // cont.style.display = "none";
    this.removeExpandStyles();

    this.is_shown = false;

};

// Close button listener - close this popup
//
ElmEasyRefField.prototype.closeButtonListener = function( event ){
    if ( elmEasyRef.refField ) elmEasyRef.refField.hide();
    event.preventDefault();
};

// Link button listener - goto reference section and close this popup
//
ElmEasyRefField.prototype.linkButtonListener = function( event ){
    if ( elmEasyRef.refField ) elmEasyRef.refField.hide();
};

// More button listener - expand this popup
//
ElmEasyRefField.prototype.moreButtonListener = function( event ){
    if ( elmEasyRef.refField ) elmEasyRef.refField.expand();
    event.preventDefault();
};

// Check if node belong to popup field frame
// (If user click on such elems, popou should not to close)
// Return true, if node belongs to field frame
//
ElmEasyRefField.prototype.isInsideField = function( node ) {
    var rf = elmEasyRef.refField;
    if ( !rf ) return false;

    while ( node ){
        if ( node == rf.elems.frame ) return true;
        node = node.parentNode;
    }

    return false;
};

// Start animation and do first step
// this.animation curw and curh should be already set
//
ElmEasyRefField.prototype.startAnimation = function(){
    if ( this.animation ){
        if ( !this.animation.interval ) {
            this.animation.interval = setInterval( this.stepAnimation, elmEasyRef.animation.delay );
        }
        this.stepAnimation();
    }
};

// Next step of animation
// Stop animation when
//      rf.metrics.width  == rf.animation.curw and
//      rf.metrics.height == rf.animation.curh
//
ElmEasyRefField.prototype.stepAnimation = function(){
    var rf = elmEasyRef.refField;
    if ( rf ){
        var chg = false;

        // Force browser redisplay div
        rf.elems.container.style.visibility = "hidden";

        // Change width
        // Will be changed FRAME width
        var d = ( rf.metrics.width - rf.animation.curw ) / elmEasyRef.animation.stepw;
        if ( d > 0.5){
            rf.animation.curw += d;
            rf.elems.frame.style.width  = Math.round( rf.animation.curw ) + "px";
            chg = true;
        }

        // Change height
        // Will be changed FIELD height
        d = ( rf.metrics.height - rf.animation.curh ) / elmEasyRef.animation.steph;
        if ( d > 0.5 ){
            rf.animation.curh += d;
            rf.elems.field.style.height = Math.round( rf.animation.curh ) + "px";
            chg = true;
        }

        if ( !chg ) rf.finishAnimation();

        // Update pos
        rf.updatePos();

        // Force browser redisplay div
        rf.elems.container.style.visibility = "visible";
    }
};

// Stop animation
//
ElmEasyRefField.prototype.finishAnimation = function(){
    if ( this.animation ){
        this.elems.content.style.wordWrap  = "";
        this.elems.content.style.wordBreak = "";
        this.elems.frame.style.width  = this.metrics.width  + "px";
        this.elems.field.style.height = this.metrics.height + "px";
        if ( this.animation.interval ) clearInterval( this.animation.interval );
        this.animation.interval = null;
    }
};
