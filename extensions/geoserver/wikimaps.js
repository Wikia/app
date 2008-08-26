// The following OpenLayers classes are derived from OpenLayers, which is
// available under the following license. These derived classes are available
// under the same license
/* Copyright (c) 2006 MetaCarta, Inc., published under the BSD license.
 * See http://svn.openlayers.org/trunk/openlayers/release-license.txt 
 * for the full text of the license. */

/**
 * @class 
 * 
 * @requires OpenLayers/Control/PanZoom.js
 */
OpenLayers.Control.Zoom = OpenLayers.Class.create();
OpenLayers.Control.Zoom.X = 4;
OpenLayers.Control.Zoom.Y = 4;
OpenLayers.Control.Zoom.prototype = 
  OpenLayers.Class.inherit( OpenLayers.Control.PanZoom, {

    /** @type Array(...) */
    buttons: null,

    /** @type int */
    zoomStopWidth: 18,

    /** @type int */
    zoomStopHeight: 11,

    initialize: function() {
        OpenLayers.Control.PanZoom.prototype.initialize.apply(this, arguments);
        this.position = new OpenLayers.Pixel(OpenLayers.Control.Zoom.X,
                                             OpenLayers.Control.Zoom.Y);
    },

    /**
     * @param {OpenLayers.Map} map
     */
    setMap: function(map) {
        OpenLayers.Control.PanZoom.prototype.setMap.apply(this, arguments);
        this.map.events.register("changebaselayer", this, this.redraw);
    },

    /** clear the div and start over.
     * 
     */
    redraw: function() {
        if (this.div != null) {
            this.div.innerHTML = "";
        }  
        this.draw();
    },
    
    /**
    * @param {OpenLayers.Pixel} px
    */
    draw: function(px) {
        // initialize our internal div
        OpenLayers.Control.prototype.draw.apply(this, arguments);
        px = this.position.clone();

        // place the controls
        this.buttons = new Array();

        var sz = new OpenLayers.Size(18,18);
        var centered = new OpenLayers.Pixel(px.x+sz.w/2, px.y);

        this._addButton("zoomin", "zoom-plus-mini.png", centered.add(0, sz.h*1), sz);
        this._addButton("zoomout", "zoom-minus-mini.png", centered.add(0, sz.h*2), sz);
        return this.div;
    },

    
    CLASS_NAME: "OpenLayers.Control.Zoom"
});
/* Copyright (c) 2006 MetaCarta, Inc., published under the BSD license.
 * See http://svn.openlayers.org/trunk/openlayers/release-license.txt 
 * for the full text of the license. */

 
/**
 * @class
 * 
 * @requires OpenLayers/Layer/HTTPRequest.js
 * @requires OpenLayers/Layer/WMS.js
 * @requires OpenLayers/Layer/WMS/Untiled.js
 */
OpenLayers.Layer.WMS.MultiUntiled = OpenLayers.Class.create();
OpenLayers.Layer.WMS.MultiUntiled.prototype = 
  OpenLayers.Class.inherit( OpenLayers.Layer.WMS.Untiled, {

    /** which layers to use for which zoomlevel
     * @type Array */
    layerForLevel: null,
    

    /**
    * @constructor
    *
    * @param {String} name
    * @param {String} url
    * @param {Object} params
    */
    initialize: function(name, url, params, options) {
        var newArguments = new Array();
        //uppercase params
        params = OpenLayers.Util.upperCaseObject(params);
        newArguments.push(name, url, params, options);
        OpenLayers.Layer.HTTPRequest.prototype.initialize.apply(this, 
                                                                newArguments);
        OpenLayers.Util.applyDefaults(
                       this.params, 
                       OpenLayers.Util.upperCaseObject(this.DEFAULT_PARAMS)
                       );

        // unless explicitly set in options, if the layer is transparent, 
        // it will be an overlay        
        if ((options == null) || (options.isBaseLayer == null)) {
            this.isBaseLayer = ((this.params.TRANSPARENT != "true") && 
                                (this.params.TRANSPARENT != true));
        }
        this.layerForLevel = new Array();
        for ( i=0; i<=35; i++ ) {
            this.layerForLevel[i] = this.params.LAYERS;
        }
    },    

    /**
     * 
     */
    destroy: function() {
        this.layerForLevel = null;
        OpenLayers.Layer.WMS.Untiled.prototype.destroy.apply(this, arguments);
    },
    
    /**
     * @param {Object} obj
     * 
     * @returns An exact clone of this OpenLayers.Layer.WMS.Untiled
     * @type OpenLayers.Layer.WMS.Untiled
     */
    clone: function (obj) {
        
        if (obj == null) {
            obj = new OpenLayers.Layer.WMS.MultiUntiled(this.name,
                                                   this.url,
                                                   this.params,
                                                   this.options);
        }

        //get all additions from superclasses
        obj = OpenLayers.Layer.WMS.Untiled.prototype.clone.apply(this, [obj]);

        // copy/set any non-init, non-simple values here

        return obj;
    },    
    
    
    /** Once HTTPRequest has set the map, we can load the image div
     * 
     * @param {OpenLayers.Map} map
     */
    setMap: function(map) {
        OpenLayers.Layer.WMS.Untiled.prototype.setMap.apply(this, arguments);
    },

    /** When it is not a dragging move (ie when done dragging)
     *   reload and recenter the div.
     * 
     * @param {OpenLayers.Bounds} bounds
     * @param {Boolean} zoomChanged
     * @param {Boolean} dragging
     */
    moveTo:function(bounds, zoomChanged, dragging) {
        
        if (bounds == null) {
            bounds = this.map.getExtent();
        }

	if ( zoomChanged ) {
            this.params.LAYERS = this.layerForLevel[this.map.getZoom()];
	}

        OpenLayers.Layer.WMS.Untiled.prototype.moveTo.apply(this,arguments);
    },


    setLayerForLevel:function(layer,zoomlevel) {
        this.layerForLevel[zoomlevel] = layer;
    },
    
    /** @final @type String */
    CLASS_NAME: "OpenLayers.Layer.WMS.MultiUntiled"
});

// The following code, until the end of the file, is (c) 2007 Jens Frank
// released to the Public Domain, or where this is not possible, under the
// Metacarta BSD license as mentioned at the top.

//var WikiMapsLon = 0;
//var WikiMapsLat = 0;
//var zoom = 4;
var map, layer;
var counter = 0;
var clickCoord;
var popup = null;
var args = OpenLayers.Util.getArgs();

if ( WikiMapsLon == undefined ) {
	var WikiMapsLon = args.lon;
}
if ( WikiMapsLat == undefined ) {
        var WikiMapsLat = args.lat;
}
if ( WikiMapsZoom == undefined ) {
        var WikiMapsZoom = args.zoom;
}




function WikiMapsSetHTML(response) {
    xmldom = OpenLayers.parseXMLString( response.responseText );
    if ( xmldom.firstChild.firstChild.firstChild.tagName != 'gml:null' ) {
        title        = xmldom.getElementsByTagNameNS('http://www.openplans.org/topp','title')[0].firstChild.data;
        displaytitle = xmldom.getElementsByTagNameNS('http://www.openplans.org/topp','displaytitle')[0].firstChild.data;
        ptags = xmldom.getElementsByTagNameNS('http://www.openplans.org/topp','population');

        if ( ptags.length != 0 && ptags[0].firstChild.data != 0 ) {
                population   = ptags[0].firstChild.data + " Inhabitants<br>";
        } else {
                population = "";
        }
        counter++;
	URL = wgServer + wgArticlePath.replace( /\$1/, title );

        HTML = "<div class=\"displaytitle\">" + displaytitle +
		"</div><small class=\"popup\">" + population +
		"<ul class=\"popup\"><li><a href=\"" + URL + "\">Open article</a></li><li><a href=\"" +
                URL + "\" target=\"_new\">Open in a new window</a></li></ul></small>";
    } else {
        latabs = Math.abs( clickCoord.lat );
        latdeg = Math.floor( latabs );
        latmin = Math.round( ( latabs - latdeg ) * 60000 )/1000;
        latns  = clickCoord.lat < 0 ? "S" : "N";

        lonabs = Math.abs( clickCoord.lon );
        londeg = Math.floor( lonabs );
        lonmin = Math.round( ( lonabs - londeg ) * 60000 )/1000;
        lonew  = clickCoord.lon < 0 ? "W" : "E";

        HTML = "<div class=\"displaytitle\">?</div><small>" + latdeg + "&deg; " + latmin + " " + latns + " " +
                        londeg + "&deg; " + lonmin + " " + lonew + "</small>";
    }
    if ( wgFullscreen ) {
       if ( popup != null ) {
           popup.destroy();
        }
        popup = new OpenLayers.Popup( "popup", clickCoord, new OpenLayers.Size(250,100),HTML,true);
        popup.setOpacity(0.8);
        map.addPopup(popup);
    } else { 
    	$('selectbox').style.display='block';
    	$('selectboxbody').innerHTML = HTML;
    }
}

function WikiMapsInit(){
    OpenLayers.IMAGE_RELOAD_ATTEMPTS = 3;
    OpenLayers.ProxyHost = '/cgi-bin/proxy.cgi?url=';

    var options = {
		controls: [new OpenLayers.Control.MouseDefaults()]
    };
    map = new OpenLayers.Map( $('map'), options );
    map.addControl(new OpenLayers.Control.Zoom());

    WikiMapsInitLayers( map );

    // Place the marker
    var markers = new OpenLayers.Layer.Markers( "Markers" );
    map.addLayer(markers);

    var size = new OpenLayers.Size(16,16);
    var offset = new OpenLayers.Pixel(-8,-16);
    var icon = new OpenLayers.Icon(wgWikiMapsIcon,size,offset);
    markers.addMarker(new OpenLayers.Marker(new OpenLayers.LonLat(WikiMapsLon, WikiMapsLat),icon));


    // make the map clickable

    map.events.register('click', map, function (e) {
        $('selectbox').style.display='none';
        var tolerance = new OpenLayers.Pixel(5, 5);
	clickCoord = map.getLonLatFromPixel( new OpenLayers.Pixel( e.xy.x + tolerance.x, e.xy.y + tolerance.y) );
        var min_px = new OpenLayers.Pixel(
                            e.xy.x - tolerance.x, e.xy.y + tolerance.y);
        var max_px = new OpenLayers.Pixel(
                            e.xy.x + tolerance.x, e.xy.y - tolerance.y);
        var min_ll = map.getLonLatFromPixel(min_px);
        var max_ll = map.getLonLatFromPixel(max_px);
        var url =  wms.getFullRequestString({ SERVICE: "WFS", REQUEST: "GetFeature",
                    EXCEPTIONS: "application/vnd.ogc.se_xml",
                    BBOX: min_ll.lon+','+min_ll.lat+','+max_ll.lon+','+max_ll.lat,
		    MAXFEATURES: 20,
                    TYPENAME: wms.params.LAYERS,
        });
        url=url.replace( /SERVICE=WMS/, "SERVICE=WFS" ); // Somehow getFullRequestString ignores the explicit setting of SERVICE
        OpenLayers.loadURL(url, '', this, WikiMapsSetHTML);
        Event.stop(e);
    });
    map.setCenter(new OpenLayers.LonLat(WikiMapsLon, WikiMapsLat), WikiMapsZoom);
    map.addControl( new OpenLayers.Control.LayerSwitcher() );
    if ( !wgFullscreen ) {
        map.addControl(new OpenLayers.Control.MousePosition());
        function WikiMapsFullscreen() {
	    center = map.getCenter();
	    zoom   = map.getZoom();
	    document.location = wgServer + wgArticlePath.replace( /\$1/, "Special:Wikimaps" ) 
				+ '?lon='+center.lon+'&lat='+center.lat+'&zoom='+zoom ;
        }
        $('wikimapsfullscreen').innerHTML='<a id="wikimapsfullscreenlink">Fullscreen</a>';
        $('wikimapsfullscreenlink').onclick = WikiMapsFullscreen;
    }
}
