// almost-100% GUI Google Maps Builder for MediaWiki.
// Copyright 2006-2008 Evan Miller, except as noted below.

/*
 * Hello! Welcome to the source of the Editor's Map. This is broken down
 * into four classes:
 *
 * 1. EditorsMarker: a wrapper around the GMarker path that provides the
 *            references necessary for the linked list structures, as well
 *            as information about captions and tabs
 * 2. EditorsSingletons: a linked list of unaffiliated markers
 * 3. EditorsPath: a linked list representing a path of connected markers
 * 4. EditorsMap: the Big One. This is the application class that contains
 *            everything else.
 *
 * You'll also notice references to a hash called "_". That's a structure of
 * messages created by GoogleMaps.i18n.php.
 *
 * Anyway, feel free to poke around. I put a lot of work into cleaning and
 * documenting this code so you can understand it. If you make improvements,
 * please take time to send me a patch, so the program is better for everyone.
 * You can reach me at emmiller@gmail.com. Thanks!
 *
 */

// TODO: make path joints draggable only in "edit this path" mode for performance.

// "Class" is taken from the Prototype library. This makes it so we can
// declare new classes with arguments, instead of having to
// call the initialize method ourselves.

var Class = { create: function() { return function() { this.initialize.apply(this, arguments); } } };

// The application object.
var emap;

// Used for measuring paths.
var GME_CONVERSION = { 'kilometers':1 / 1000, 'meters':1, 'miles': 100 / 2.54 / 12 / 5280 };
var GME_RADII = { 'earth': 6378137,
    'mars':3389.5 * 1000,
    'moon': 1737.4 * 1000
};
var GME_SIGFIGS = 4;

var abbreviations = { 'kilometers':'km', 'meters':'m', 'miles':'mi' };

var colorSelectorRegistry = Array();

// a wrapper around the GMarker class
// This adds the variables we need to play with
// EditorsPath, which also makes it easier
// for us to swap out the underlying GMarker.
var EditorsMarker = Class.create();
EditorsMarker.prototype = {
    initialize: function(point, emap, title, icon) {
                  this.gmarker = new GMarker(point, { 'draggable':true, 'title': title ? title : '', 'icon':icon });
                  this.gmarker.emarker = this;
                  this.container = document.createElement("span");
                  this.container.appendChild(document.createTextNode(emap.round(this.gmarker.getPoint().lat())+', '+emap.round(this.gmarker.getPoint().lng())));
                  this.container.appendChild(document.createElement("br"));
                  this.emap = emap;
                  this.tabs = new Array();
                  var this_marker = this;
                  GEvent.addListener(this.gmarker, 'dragend', function() { this_marker.updateLocation() } );
                },

    getIcon: function() {
	       return this.gmarker.getIcon();
	     },

    setCaption: function(caption) {
          this.caption = caption;
          if (!this.icon_name) {
              if (this.caption || this.gmarker.getTitle()) {
                  this.setIcon(this.emap.default_icon);
              } else if (this.path) {
                  this.setIcon(GME_SMALL_ICON);
              }
          }
          this.dump();
    },

    setTitle: function(title) {
          if (!title) {
              title = '';
          }
          if (this.gmarker.getTitle() != title) {
              this.rebuildMarker(title, this.getIcon());
              if (!this.icon_name) {
                  if (this.caption || title) {
                      this.setIcon(this.emap.default_icon);
                  } else {
                      this.setIcon(GME_SMALL_ICON);
                  }
              }
          }
          this.dump();
    },

    dump: function() {
        this.container.innerHTML = '';
        var line = '';
        if (this.icon_name)
            line += '('+this.icon_name+') ';
        line += this.emap.round(this.getPoint().lat())+', '+this.emap.round(this.getPoint().lng());
        if (this.gmarker.getTitle())
            line += ', '+this.gmarker.getTitle();
        this.container.appendChild(document.createTextNode(line));
        this.container.appendChild(document.createElement('br'));
        for(var i=0;i<this.tabs.length;i++) {
            this.container.appendChild(document.createTextNode('/'+this.tabs[i].title+"\\"));
            if (this.tabs[i].content) {
                this.container.appendChild(document.createElement('br'));
                this.container.appendChild(document.createTextNode(this.tabs[i].content));
            }
            this.container.appendChild(document.createElement('br'));
        }
        if (this.caption) {
            var lines = this.caption.split("\r\n");
            for(var i=0;i<lines.length;i++) {
                this.container.appendChild(document.createTextNode(lines[i]));
                this.container.appendChild(document.createElement('br'));
            }
        }
    },

    addTab: function(title, content) {
              this.tabs[this.tabs.length] = { 'title':title, 'content':content };
              if (this.getIcon() == GME_SMALL_ICON)
                this.setIcon(this.emap.default_icon);
              this.dump();
            },

// The API doesn't let us change a marker's icon on the fly,
// so we need to instantiate a new GMarker. No problem, though,
// because all the references that this application uses are
// here in the wrapper class.

    rebuildMarker: function(title, icon) {
                 this.emap.zapGMarker(this.gmarker);
	       this.gmarker = new GMarker(this.gmarker.getPoint(),
                       { 'icon':icon,
                         'draggable':this.gmarker.draggable(),
                         'title':title });
	       this.emap.gmap.addOverlay(this.gmarker);
	       this.gmarker.emarker = this;
	       var this_marker = this;
	       GEvent.addListener(this.gmarker, 'dragend', function() { this_marker.updateLocation() } );
                   },
    setIcon: function(icon) {
        if (this.getIcon() != icon) {
            this.rebuildMarker(this.gmarker.getTitle(), icon);
        }
    },

    setIconImage: function(label, url) {
        this.gmarker.setImage(url);
        this.icon_name = label;
    },

    getPoint: function() {
                return this.gmarker.getPoint();
	      },

    hide: function() {
        return this.gmarker.hide();
    },

    show: function() {
        return this.gmarker.show();
    },

// Called at the end of a drag. We recalculate the
// path's distance and draw new Polyline segments.
    updateLocation: function() {
      if( this.path ) {
        this.path.redraw();
        this.path.distance = 0;
      }
      this.dump();
      this.emap.dumpPaths();
    },

                    // we need this logic in a couple places, so might as well put it here.
    getBalloonFooter: function() {
      var message = '';
      message += '<a href="javascript:void(0)" onclick="emap.updateActiveMarker()">'+_['gm-save-point']+'</a>'+
	  '&nbsp;&nbsp;<a href="javascript:void(0)" onclick="emap.removeActiveMarker()">'+_['gm-remove']+'</a>';
      if (GME_PATHS_SUPPORTED && this.path == undefined) {
	  message += '&nbsp;&nbsp;<a href="javascript:void(0)" onclick="emap.startPath()">'+_['gm-start-path']+'</a>';
      }
      message += '<br /><span style="color: #aaa; font-size: 10px;">'+
	  this.emap.round(this.getPoint().lat())+', '+
	  this.emap.round(this.getPoint().lng())+'</span><br /><br />';
      return message;
    },

    openEditWindow: function() {
      if (this.tabs.length) {
	  var tabs = [];
	  for(var t=0; t < this.tabs.length; t++) {
              label = this.emap.rtl ? ((parseInt(t)+1)+' '+_['gm-tab']) : _['gm-tab']+' '+(parseInt(t)+1);
              content = _['gm-tab-title']+':<br />'+'<input size="24" id="tab_title_'+t+'" value="'+this.tabs[t].title+'" />'+
		      '<br />'+_['gm-caption']+':<br />'+
		      '<textarea class="balloon_textarea" id="tab_content_'+t+'">'+
		      this.tabs[t].content+'</textarea><br />';
              content += this.getBalloonFooter();
              if (this.emap.rtl) {
                  content = '<div style="direction: rtl;">'+content+'</div>';
              }
              tabs[t] = new GInfoWindowTab( label, content );
	  }
	  this.gmarker.openInfoWindowTabsHtml(tabs);
      } else {
          var content = '';
          content += _['gm-balloon-link-article'];
          content += '<br /><input style="width: 260px;" type="text" id="balloon_title" value="'+this.gmarker.getTitle()+'"/>';
          content += '<br />';
          content += _['gm-make-marker'];
          content += '<br /><textarea style="width: 260px;" id="balloon_textarea" class="balloon_textarea">';
          content += this.caption;
          content += '</textarea><br />';
          if (this.getIcon() != GME_SMALL_ICON) {
              content += 'Icon: ';
              content += '<select onchange="emap.changeActiveMarkerIcon(this.value)"><option value="">default</option>'+this.optionRange(this.icon_name)+'</select>';
              content += '<br />';
          }
          content += this.getBalloonFooter();

          if (this.emap.rtl) {
              content = '<div style="direction: rtl;">'+content+'</div>';
          } else {
              content = '<div>'+content+'</div>';
          }
          this.gmarker.openInfoWindowHtml( content, { maxWidth:270 });
      }
    },

    optionRange: function(selected) {
                     var content = '';
          for(var i=0; i<this.emap.icon_labels.length; i++) {
              var str = this.emap.icon_labels[i];
              if (str == selected) {
              content += '<option selected="selected">'+str+'</option>';
              } else {
              content += '<option>'+str+'</option>';
              }
          }
          return content;
     },

    caption: ''
};

// It's: a very simple linked list
var EditorsSingletons = Class.create();
EditorsSingletons.prototype = {
    initialize: function() {
                  this.container = document.createElement("span");
                  document.getElementById("map_dump_body").appendChild(this.container);
                },

    reset: function() {
             this.head = undefined;
             this.container = document.createElement("span");
             document.getElementById("map_dump_body").appendChild(this.container);
           },

    removeMarker: function(doomed_marker) {
            if (!doomed_marker) {
              return;
            }
            var p = this.head;
            // First, remove it from the singletons' linked list.
            while(p) {
              if (p == doomed_marker) {
                if (p.previous_marker) {
                  p.previous_marker.next_marker = p.next_marker;
                }
                if (p.next_marker) {
                  p.next_marker.previous_marker = p.previous_marker;
                }
                this.container.removeChild(doomed_marker.container);
              }
              p = p.previous_marker;
            }

            // If we're removing the head of the list, update
            // the head reference
            if (this.head == doomed_marker) {
              this.head = doomed_marker.previous_marker;
            }

            doomed_marker.previous_marker = undefined;
            doomed_marker.next_marker = undefined;
    },

    addMarker: function(marker) {
         marker.previous_marker = this.head;
         if (this.head) { this.head.next_marker = marker; }
         this.head = marker;
         this.container.appendChild(marker.container);
    }
};

// A slightly more complicated linked list. This object also stores
// information about the path, such as its color and total distance.
var EditorsPath = Class.create();
EditorsPath.prototype = {
    initialize: function(lineColor, lineOpacity, fillColor, fillOpacity, stroke, editors_map, isPoly) {
        this.poly = isPoly;
        this.container = document.createElement("span");
        this.container.appendChild( document.createTextNode( '' ) );
        this.container.appendChild( document.createElement( 'br' ) );
        document.getElementById("map_dump_body").appendChild(this.container);

        this.colorSelector = new color_select('#'+lineColor);
        colorSelectorRegistry[this.colorSelector.id] = { 'path':this, 'type':'line' };
        this.setLineColor(lineColor, lineOpacity);

        this.colorSelectorFill = new color_select('#'+fillColor);
        colorSelectorRegistry[this.colorSelectorFill.id] = { 'path':this, 'type':'fill' };
        this.setFillColor(fillColor, fillOpacity);

        this.emap = editors_map;
        this.gmap = editors_map.gmap;
        this.units = editors_map.units;
        this.stroke = stroke;
        this.size = 0;
        this.distance = 0;
        this.markers = Array( );
        this.overlay = null;
    },

    addFill: function() {
                 this.poly = true;
                 this.setFillColor(this.fill_color, this.fill_opacity);
                 this.redraw();
                 emap.dumpPaths();
     },

    removeFill: function() {
                 this.poly = false;
                 this.redraw();
                 emap.dumpPaths();
     },

    jump: function() {
              bounds = this.overlay.getBounds();
              this.gmap.setCenter(bounds.getCenter(), zoom = this.gmap.getBoundsZoomLevel(bounds));
    },

    addMarker: function(marker) {
      marker.path = this;

      this.markers.push( marker );

      this.container.appendChild(marker.container);
      this.redraw( );
      this.distance = 0;
    },

    redraw: function( ) {
        var old_overlay = this.overlay;
        this.overlay = this.poly ? this.rebuildArea() : this.rebuildLine();
        if ( old_overlay ) {
            this.gmap.removeOverlay(old_overlay);
        }
        this.gmap.addOverlay( this.overlay );
        this.updateDistance();
        this.overlay.epath = this;
    },

    rebuildLine: function() {
        var points = Array( );
        for( var i = 0; i <  this.markers.length; i++ ) {
            points[i] = this.markers[i].getPoint( );
        }
        return new GPolyline( points, '#'+this.line_color, this.stroke, this.line_opacity );
    },

    rebuildArea: function() {
        var points = Array( );
        if( this.markers.length > 1 ) {
            this.markers.push( this.markers[0] );
        }
        for( var i = 0; i <  this.markers.length; i++ ) {
            points[i] = this.markers[i].getPoint( );
        }
        if( this.markers.length > 1 ) {
            this.markers.pop( );
        }
        return new GPolygon( points, '#'+this.line_color, this.stroke, this.line_opacity,
                '#'+this.fill_color, this.fill_opacity );
    },

    removeMarker: function(doomed_marker) {
      for( var i = 0; i < this.markers.length; i++ ) {
        if( doomed_marker == this.markers[i] ) {
            doomed_marker.path = null;
          this.markers.splice( i, 1 );
        }
      }

      this.redraw();
      this.distance = 0;
    },

    distanceExpression: function() {
      if( this.distance == 0 ) {
          this.updateDistance();
      }
      dist = this.distance * GME_CONVERSION[this.units];
      return this.formatNumber(dist, GME_SIGFIGS)+' '+abbreviations[this.units];
    },

    areaExpression: function() {
        if (this.distance == 0) {
            this.updateDistance();
        }
        area = this.overlay.getArea() * Math.pow(GME_CONVERSION[this.units], 2) * Math.pow(this.emap.radius / GME_RADII['earth'], 2);
        return this.formatNumber(area, GME_SIGFIGS)+' '+abbreviations[this.units]+'<sup>2</sup>';
    },

    updateDistance: function() {
    // we calculate the perimeter for purposes of comparing with other lines
        if (this.markers.length) {
            this.distance = 0;
            for( var i = 1; i < this.markers.length; i ++ ) {
                this.distance += this.markers[i].getPoint().distanceFrom( this.markers[i-1].getPoint(), this.emap.radius );
            }
            if (this.overlay.getArea) {
                this.distance += this.markers[0].getPoint().distanceFrom( this.markers[this.markers.length - 1].getPoint(), this.emap.radius );
            }
        }
    },

    formatNumber: function(num, GME_SIGFIGS) {
      places = Math.max(GME_SIGFIGS - (Math.round(num)+'').length, 0);
      return Math.round(num * Math.pow(10, places)) / Math.pow(10, places);
    },

    setLineColor: function(color, opacity) {
        if(!this.poly) {
  	      this.fill_color = color;
              this.fill_opacity = opacity;
        }
        this.line_color = color;
        this.line_opacity = opacity;
        this.updateColorInfo();
  },

    setFillColor: function(color, opacity) {
        this.fill_color = color;
        this.fill_opacity = opacity;
        this.updateColorInfo();
  },

    updateColorInfo: function() {
         this.container.childNodes[0].nodeValue = this.stroke+'#'+this.fraction2hex(this.line_opacity)+this.line_color;
         if (this.poly) {
             this.container.childNodes[0].nodeValue += ' (#'+this.fraction2hex(this.fill_opacity)+this.fill_color+')';
         }
     },

    setFillOpacity: function(opacity, index) {
        this.setFillColor(this.fill_color, opacity);
        if (navigator.appName.indexOf("Microsoft") != -1) {
            document.getElementById('area_'+index).style.filters.alpha.opacity = opacity * 100;
        } else {
            document.getElementById('area_'+index).style.MozOpacity = opacity;
        }
        this.redraw();
    },

    setLineOpacity: function(opacity, index) {
        this.setLineColor(this.line_color, opacity);
        if (navigator.appName.indexOf("Microsoft") != -1) {
            document.getElementById('path_'+index).style.filters.alpha.opacity = opacity * 100;
        } else {
            document.getElementById('path_'+index).style.MozOpacity = opacity;
        }
        this.redraw();
    },

    setStroke: function(stroke, index) {
        this.stroke = stroke;
        this.redraw();
        document.getElementById('path_'+index).style.height = stroke+'px';
        this.updateColorInfo();
    },

    fraction2hex: function(frac) {
        lets = "0123456789ABCDEF".split('');
        return lets[parseInt(frac * 255) >> 4] + lets[parseInt(frac * 255) & 0xf];
    },

    updateLineColor: function(new_color) {
        this.setLineColor(new_color, this.line_opacity);
        this.redraw();
    },

    updateFillColor: function(new_color) {
        this.setFillColor(new_color, this.fill_opacity);
        this.redraw();
    },

    deselect: function() {
        for(var i=0;i<this.markers.length;i++) {
            if (!this.markers[i].caption && !this.markers[i].gmarker.getTitle()) {
                this.markers[i].hide();
            }
        }
    },

    select: function() {
        for(var i=0;i<this.markers.length;i++) {
            this.markers[i].show();
        }
    }
};

var EditorsMap = Class.create();
EditorsMap.prototype = {

/********* Initialization *********/

    initialize: function(options) {
	if (!GBrowserIsCompatible()) {
	    this.mother_div = document.createElement('div');
	    this.mother_div.innerHTML = _['gm-no-editor'];
	    document.getElementById(options.container).appendChild(this.mother_div);
	    return;
	}
          // Initialize
	this.icon_base = options.icons;
        this.icon_labels = options.iconlabels.split(",");
        this.default_icon = this.copyIcon(G_DEFAULT_ICON);
        this.default_icon.shadow = options.shadow;

        var iconSize = options.iconsize.split("x");
        this.default_icon.iconSize = new GSize(iconSize[0], iconSize[1]);
        var shadowSize = options.shadowsize.split("x");
        this.default_icon.shadowSize = new GSize(shadowSize[0], shadowSize[1]);
        var iconAnchor = options.iconanchor.split("x");
        this.default_icon.iconAnchor = new GPoint(iconAnchor[0], iconAnchor[1]);
        var infoWindowAnchor = options.windowanchor.split("x");
        this.default_icon.infoWindowAnchor = new GPoint(infoWindowAnchor[0], infoWindowAnchor[1]);

	this.precision = options.precision; // how many decimal places?
	this.paths_supported = GME_PATHS_SUPPORTED;
	this.default_color = options.color.replace(/#/, '');
	this.default_opacity = options.opacity;
        this.stroke = options.stroke;
	this.paths = new Array();
        this.includes = new Array();
	this.units = options.units;
        this.world = options.world;
        this.rtl = options.rtl;
	this.textbox = document.getElementById(options.textbox);
	this.defaults = options; // keep a copy for later

	this.mother_div = this.getEditorsMapNode(options); // build all the HTML

	// stick it somewhere useful
	document.getElementById(options.container).appendChild(this.mother_div);

	this.singletons = new EditorsSingletons();

	// Closures are great, but they make it harder to have short-ish functions.
	// Here's how we cheat and let the closure bind to "this" but stick the workhorse
	// function somewhere else.
	var this_emap = this;

	// Now make the API components and attach to the appropriate places.
	this.gmap = new GMap2(this.map_div, { 'googleBarOptions': 
                { 'showOnLoad': options.localsearch,
                'onGenerateMarkerHtmlCallback': function(marker, info, result) { 
                var result_div = document.createElement("div");
                result_div.innerHTML = this_emap.generateResultText(result);
                this_emap.active_result_marker = marker;
                return result_div; }
                },
               'mapTypes': this.getMapTypes(this.world) });
        this.gmap.enableGoogleBar();
	this.controls = { 'selector': new GMapTypeControl(), 'scale':new GScaleControl(), 'overview':new GOverviewMapControl() };
	this.active_controls = {};

	if (options.geocoder) {
	    this.geocoder = new GClientGeocoder();
	}

	this.configureMap( options );

	if (this.maps_in_article == 1)
	    this.loadMap(1);

	// Keep the map's center up-to-date.
	GEvent.addListener(this.gmap, 'moveend', function() { this_emap.dumpMapAttributes() });

	// one click listener to rule them all...
	GEvent.addListener(this.gmap, 'click', function(overlay, point) { this_emap.clickMap(overlay, point); });
    },

    getEditorsMapNode: function(options) {
          // Crack your knuckles. It's time to build a big fat DOM node with everything you see.
         this.map_div = document.createElement("div");
         this.map_div.style.width = options.width+"px";
         this.map_div.style.height = options.height+"px";
         this.map_div.style.direction = "ltr";

         this.search_div = document.createElement("div");
         this.search_div.innerHTML = _['gm-no-search-preface'];

         // We need to hang on to this reference for later,
         // so this is scoped for the object, not just the initializer
         this.load_map_div = document.createElement("div");
         this.load_map_div.style.padding = "10px 0px";
         this.refreshMapList();

         this.path_info_div = document.createElement("div");
         this.path_info_div.style.padding = "15px 0px";
         this.path_info_div.style.width   = "460px";

         this.instructions_div = document.createElement("div");
         this.instructions_div.innerHTML = '<p>'+_['gm-instructions']+'&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="if(confirm(\''+_['gm-are-you-sure']+'\')) { emap.clearMap(); }">'+_['gm-clear-all-points']+'</a></p>';

         this.map_dump_div = document.createElement("pre");

         this.map_dump_attributes_div = document.createElement("span");
         this.map_dump_body_div = document.createElement("span");
         this.map_dump_body_div.setAttribute("id", "map_dump_body");
         this.map_dump_includes_div = document.createElement("span");

         this.map_dump_div.appendChild(this.map_dump_attributes_div);
         this.map_dump_div.appendChild(this.map_dump_includes_div);
         this.map_dump_div.appendChild(this.map_dump_body_div);
         this.map_dump_div.appendChild(document.createTextNode('</googlemap>'));

         this.note_div = document.createElement("div");
         this.note_div.style.padding = "10px";
         this.note_div.style.fontWeight = 'bold';
         this.note_div.style.fontStyle = 'italic';
         this.note_div.innerHTML = _['gm-note'];

         this.root_div = document.createElement("div");
         this.root_div.setAttribute('id', 'mother_div');

         this.root_div.appendChild(this.search_div);

         if (this.map_table) {
             this.root_div.appendChild(this.map_table);
         }

         this.kml_div = this.getKmlNode();
         this.kml_list = document.createElement("ul");
         this.kml_div.appendChild(this.kml_list);

         this.root_div.appendChild(this.map_div);
         this.root_div.appendChild(this.path_info_div);
         this.root_div.appendChild(this.getControlPanelNode());
         this.root_div.appendChild(this.kml_div);
         this.root_div.appendChild(this.instructions_div);
         this.root_div.appendChild(this.map_dump_div);
         this.root_div.appendChild(this.note_div);
         this.root_div.appendChild(this.load_map_div);
         return this.root_div;
    },

getKmlNode: function() {
                var text_sep = '&nbsp;&nbsp;&nbsp;';
                var div = document.createElement("div");
              var html =
                  _['gm-kml-include'] +
              '<input onfocus="if(this.value == \'http://\') { this.value = \'\'; }" id="kml_include" type="text" style="width: 300px" value="http://" /> '+
              '<a id="kml_include_link" href="javascript:void(0)" onclick="this.blur(); emap.addXmlSource(document.getElementById(\'kml_include\').value)">'+_['gm-kml-include-link']+'</a>'+
              '<span id="kml_include_loading" style="display: none;">'+_['gm-kml-loading']+'</span>';
          div.innerHTML = html;
          return div;
            },

    getControlPanelNode: function() {
          /* of course, at some point, DOM methods are more pain than they're worth.
           That's when innerHTML comes to the rescue. */ 
          var control_panel_div = document.createElement("div");
		  control_panel_div.style.fontSize = "10px";
          var text_sep = '&nbsp;&nbsp;&nbsp;'+
              '&nbsp;&nbsp;&nbsp;'+
              '&nbsp;&nbsp;&nbsp;'+
              '&nbsp;&nbsp;&nbsp;';
          var html = '';
          /*
          html += '<select id="select_world" onchange="emap.configureMap({\'world\':this.value})">';
          html += '<option value="earth">'+_['gm-earth']+'</option>';
          html += '<option value="moon">'+_['gm-moon']+'</option>';
          html += '<option value="mars">'+_['gm-mars']+'</option>';
          html += '</select>'+
              '&nbsp;&nbsp;&nbsp;';
              */
          html += _['gm-zoom-control']+': '+
              this.getRadioOption('controls', 'large', _['gm-large'])+
              this.getRadioOption('controls', 'medium', _['gm-medium'])+
              this.getRadioOption('controls', 'small', _['gm-small'])+
              this.getRadioOption('controls', 'none', _['gm-no-zoom-control'])+
              '&nbsp;&nbsp;&nbsp;'+
              '&nbsp;&nbsp;&nbsp;'+
              '&nbsp;&nbsp;&nbsp;'+
		      _['gm-width']+': '+
		      '<select id="select_width" onchange="emap.configureMap({\'width\':this.value})">'+
              '<option></option>';
          for(var i=50;i<=700;i+=25)
		      html += '<option value="'+i+'">'+i+'</option>';
		  html += '</select>'+
		      '&nbsp;&nbsp;&nbsp;'+
		      '&nbsp;&nbsp;&nbsp;'+
		      _['gm-height']+': '+
		      '<select id="select_height" onchange="emap.configureMap({\'height\':this.value})">'+
              '<option></option>';
          for(var i=50;i<=600;i+=25)
		      html += '<option value="'+i+'">'+i+'</option>';
          html += '</select>';
          html += '<br />'+
              this.getControlSwitch('selector')+
              text_sep+
              this.getControlSwitch('scale')+
              text_sep+
              this.getControlSwitch('overview');
          control_panel_div.innerHTML = html;
          return control_panel_div;
                         },

    getRadioOption: function(key, value, label) {
                        var id = 'control_'+key+'_'+value;
		      return ' <input id="'+id+'" type="radio" '+
                      'name="control_'+key+'" '+
                      'onclick="this.blur()" '+
                      'onchange="emap.configureMap({\''+key+'\':\''+value+'\'});" />'+
                      '<label for="'+id+'">'+label+'</label>';
                    },

    getControlSwitch: function(control) {
		      return _['gm-'+control+'-control']+': '+
              this.getRadioOption(control, 'yes', _['gm-yes'])+
              this.getRadioOption(control, 'no', _['gm-no']);
                      },

/********** Map methods ************/

// call this instead of the set* functions
// to update the printed map attributes at
// the same time.
    configureMap: function(attrs) {
                    if (attrs.width)
                      this.setMapWidth(attrs.width);
                    if (attrs.height)
                      this.setMapHeight(attrs.height);
                    if (attrs.lat && attrs.lon)
                      this.gmap.setCenter(new GLatLng(parseFloat(attrs.lat), 
                              parseFloat(attrs.lon)), attrs.zoom ? parseInt(attrs.zoom) : undefined);
                    if (attrs.world)
                      this.setWorld(attrs.world, attrs.type);
                    if (attrs.type)
                        this.setType(attrs.type);
                    if (attrs.selector)
                      this.setControl('selector', attrs.selector);
                    if (attrs.scale)
                      this.setControl('scale', attrs.scale);
                    if (attrs.overview)
                      this.setControl('overview', attrs.overview);
                    if (attrs.controls)
                      this.setControlSize(attrs.controls);
                    this.dumpMapAttributes();
    },

// this gets called when you click the link by the toolbar
    toggleGoogleMap: function() {
		   if (this.mother_div.style.display == "") {
		     this.mother_div.style.display = "none";
		   } else {
		     this.mother_div.style.display = "";
		   }
		 },

// Intercepts clicks to the map. Click may be on a point ("overlay"),
// or not.
    clickMap: function(overlay, point) {
                if (overlay == undefined) {
                  if (this.active_path != undefined) {
                    // a new point along a path
                    var path_marker = new EditorsMarker(point, this, '', GME_SMALL_ICON);
                    this.addMarkerToActivePath(path_marker);
                  } else {
                      if (this.selected_path != undefined
                              && this.paths[this.selected_path]) {
                          this.paths[this.selected_path].deselect();
                          this.selected_path = undefined;
                          this.dumpPaths();
                      } else {
                          // Not along a path. This gets blown away if there is a click anywhere else.
                          var my_marker = new EditorsMarker(point, this);
                          this.newMarker(my_marker, undefined, '');
                          this.temp_marker = my_marker;
                      }
                  }
                } else if (overlay && overlay.emarker) { // marker
                  this.active_marker = overlay.emarker;
                  overlay.emarker.openEditWindow();
                } else if (overlay && overlay.epath) { // polyline or polygon
                    this.selectPath(overlay.epath);
                    // TODO
                }
	      },

// Blow away everything. Or at least, get rid of the references.
// I think IE might suck at circular references, so there might
// be a memory leak here.
    clearMap: function() {
                this.gmap.clearOverlays();
                this.map_dump_body_div.innerHTML = '';
                this.map_dump_includes_div.innerHTML = '';
                this.kml_list.innerHTML = '';
                this.singletons.reset();
                this.paths = [];
                this.dumpPaths();
	      },

/************* Path methods *************/

    addPath: function(lineColor, lineOpacity, lineWeight, fillColor, fillOpacity, isPoly) {
	   var path = new EditorsPath(lineColor, lineOpacity, fillColor, fillOpacity, lineWeight, this, isPoly);
	   this.active_path = this.paths.length;
	   this.paths[this.paths.length] = path;
           this.selectPath(path);
	   return path;
     },

    activatePath: function(which) {
        this.active_path = which;
        this.dumpPaths();
    },

    startPath: function() {
                 this.singletons.removeMarker(this.active_marker);
                 this.addPath(this.default_color, this.default_opacity,
                         this.stroke, this.default_color, this.default_opacity).addMarker(this.active_marker);
                 this.updateActiveMarker();
                 this.gmap.closeInfoWindow();
                 this.dumpPaths();
	       },

    endPath: function() {
               if (this.active_path == undefined) {
                 return;
               }

               this.pruneOneMarkerPaths();
               this.active_path = undefined;
               this.active_marker = undefined;
               this.gmap.closeInfoWindow();
               this.dumpPaths();
	     },

    pruneOneMarkerPaths: function() {
         for(var i=0;i<this.paths.length;i++) {
             if (this.active_path == i) {
                 this.active_path = undefined;
             }
             if (this.paths[i] && this.paths[i].markers.length == 1) {
                 var marker = this.paths[i].markers[0];
                 this.paths[i].removeMarker(marker);
                 this.singletons.addMarker(marker);
                 this.map_dump_body_div.removeChild(this.paths[i].container);
                 this.paths[i] = undefined;
             } else if (this.paths[i] && this.paths[i].markers.length == 0) {
                 this.map_dump_body_div.removeChild(this.paths[i].container);
                 this.paths[i] = undefined;
             }
         }
     },

    selectPath: function(path) {
        if (this.selected_path != undefined
                && this.paths[this.selected_path]) {
            this.paths[this.selected_path].deselect();
        }
        for(var i=0;i<this.paths.length;i++) {
            if (this.paths[i] == path) {
                this.selected_path = i;
            }
        }
        path.select();
        this.dumpPaths();
    },

/********** Marker methods ***********/

// Used when you "clip" a search result, get a geo-code result,
// or just click the map to make a new marker.
    newMarker: function(marker, title, text) {
                 this.zapTempMarker();
                 this.addMarkerToActivePath(marker);
                 marker.setTitle(title);
                 marker.setCaption(text);
                 marker.openEditWindow();
               },

    addMarkerToActivePath: function(marker) {
         this.active_marker = marker;
         this.singletons.removeMarker(marker);
         if (this.paths_supported && this.active_path != undefined) {
             this.paths[this.active_path].addMarker(marker);
             this.gmap.addOverlay(marker.gmarker);
             this.dumpPaths();
         } else {
             this.singletons.addMarker(marker);
             this.gmap.addOverlay(marker.gmarker);
         }
    },

// Could be removing from a path, or from the singletons
    updateActiveMarker: function() {
        // we could have a caption, or some tabs.
        if (document.getElementById('balloon_textarea')) {
            var caption = document.getElementById('balloon_textarea').value;
            var title = document.getElementById('balloon_title').value;
            // we need to close the info window before setting the caption,
            // because it gets upset when it tries to close an info window
            // that sprung up from a now-defunct marker.
            this.gmap.closeInfoWindow();
            this.active_marker.setCaption(caption);
            this.active_marker.setTitle(title);
        } else { // tabs
            for(var i=0;document.getElementById("tab_title_"+i);i++) {
                this.active_marker.tabs[i] = { 'title':document.getElementById("tab_title_"+i).value,
                    'content':document.getElementById("tab_content_"+i).value };
            }
            this.active_marker.dump();
            this.gmap.closeInfoWindow();
        }
        this.temp_marker = undefined;
    },

    removeActiveMarker: function() {
        if (this.active_marker.path) {
            var path = this.active_marker.path;
            path.removeMarker(this.active_marker);
            this.zapGMarker(this.active_marker);
            this.pruneOneMarkerPaths();
        } else {
            this.singletons.removeMarker(this.active_marker);
        }
        this.dumpPaths();
        this.gmap.closeInfoWindow();
        this.zapGMarker(this.active_marker.gmarker);
    },

    changeActiveMarkerIcon: function(label) {
        this.active_marker.setIconImage(label, label ? this.icon_base.replace('{label}', label) : this.default_icon.image);
    },

    removeActiveMarkerAndJumpBack: function() {
       this.removeActiveMarker();
       this.gmap.returnToSavedPosition();
    },

    zapTempMarker: function() {
       if (this.temp_marker) {
           this.singletons.removeMarker(this.temp_marker);
           this.zapGMarker(this.temp_marker.gmarker);
           this.temp_marker = undefined;
       }
   },

// I found myself doing these two things in the same
// order all the time, so I thought, what the hell.
    zapGMarker: function(marker) {
		  GEvent.clearInstanceListeners(marker);
		  this.gmap.removeOverlay(marker);
		},

/************** Search methods ***************/

    generateResultTextCaption: function(result, sep) {
                         var phone = '';
                         var text = '';
                         if (result.phoneNumbers) {
                             for (var p=0; p < result.phoneNumbers.length; p++) {
                                 if (result.phoneNumbers[p].type == "main") {
                                     phone = result.phoneNumbers[p].number;
                                 }
                             }
                         }
                         if (result.streetAddress)
                             text += result.streetAddress+sep;
                         text += result.city+", "+result.region;
                         if (phone)
                             text += sep+phone;
                         return text;
                   },
    generateResultText: function(result) {
                         var text = '';
                         text += "<b>"+result.title+"</b><br />";
                         text += this.generateResultTextCaption(result, "<br />") + "<br />";
                         text += '<a href="javascript:void(0)" onclick="emap.clipResult(\''+result.titleNoFormatting.replace(/'/g, '\\\'')+
                             '\', \''+this.generateResultTextCaption(result, '\\r\\n').replace(/'/g, '\\\'')+'\', '+result.lat+', '+result.lng+')">'+_['gm-clip-result']+'</a>';
                         return text;

                    },

    clipResult: function(title, caption, lat, lng) {
          var my_marker = new EditorsMarker(new GLatLng(lat, lng), this);
          this.newMarker(my_marker, title, caption);
          if (this.active_result_marker) { this.active_result_marker.hide(); }
    },

/************ Super-boring "set" methods **************/

    setControlSize: function(type) {
                      document.getElementById('control_controls_'+type).checked = true;
                      this.current_control_type = type;
                      this.gmap.removeControl(this.current_control);
                      if (this.current_control_type == "small") {
                        this.current_control = new GSmallZoomControl();
                      }
                      if (this.current_control_type == "medium") {
                        this.current_control = new GSmallMapControl();
                      }
                      if (this.current_control_type == "large") {
                        this.current_control = new GLargeMapControl();
                      }
                      if (this.current_control_type != "none") {
                        this.gmap.addControl(this.current_control);
                      }
                    },

    setControl: function(which, whether) {
              document.getElementById('control_'+which+'_'+whether).checked = true;
              this.active_controls[which] = whether;
              if (whether == "yes") {
                  this.gmap.addControl(this.controls[which]);
              } else {
                  this.gmap.removeControl(this.controls[which]);
              }
    },

    setUnitOfDistance: function(u) {
		     this.units = u;
		     this.dumpPaths();
		   },

    setMapWidth: function(width) {
           document.getElementById('select_width').value = width;
           if (width != parseInt(this.map_div.style.width)) {
             this.map_div.style.width = width+'px';
             this.gmap.checkResize();
           }
    },

    setMapHeight: function(height) {
            document.getElementById('select_height').value = height;
            if (height != parseInt(this.map_div.style.height)) {
                this.map_div.style.height = height+'px';
                this.gmap.checkResize();
            }
    },

    setType: function(type) {
                  var set_map_type = this.translateMapNameToType(this.world, type);
                  this.gmap.setCenter(this.gmap.getCenter(), this.gmap.getZoom(), set_map_type);
             },

    setWorld: function(world, type) {
                  if (document.getElementById('select_world'))
                      document.getElementById('select_world').value = world;
                  var i;
                  var old_world = this.world;
                  this.world = world;
                  var map_types_orig = this.gmap.getMapTypes().slice();
                  var map_types = this.getMapTypes(world);

                  var map_types_orig_check = {};
                  var map_types_check = {};
                  for(i=0;i<map_types_orig.length;i++) {
                      map_types_orig_check[old_world+map_types_orig[i].getName()] = 1;
                  }
                  for(i=0;i<map_types.length;i++) {
                      map_types_check[world+map_types[i].getName()] = 1;
                  }

                  for(i=0;i<map_types.length;i++) {
                      if (!map_types_orig_check[world+map_types[i].getName()]) {
                          this.gmap.addMapType(map_types[i]);
                      }
                  }

                  this.setType(type)

                  for(i=0;i<map_types_orig.length;i++) {
                      if (!map_types_check[old_world+map_types_orig[i].getName()]) {
                          this.gmap.removeMapType(map_types_orig[i]);
                      }
                  }
                  this.setRadius(GME_RADII[this.world]);
              },

    setRadius: function(radius) {
                   this.radius = radius;
               },

/********* Slightly less boring "dump" methods *********/

    dumpMapAttributes: function() {
// but only those which differ from defaults
       var str = '';
       str += '&lt;googlemap';
       str += ' version="0.9"';
       str += ' lat="'+this.round(this.gmap.getCenter().lat())+'"';
       str += ' lon="'+this.round(this.gmap.getCenter().lng())+'"';
       var type = this.translateMapTypeToName(this.world, this.gmap.getCurrentMapType());
       if (this.defaults.type != type)
	       str += ' type="'+type+'"';
       var world = this.world;
       if (this.defaults.world != world)
           str += ' world="'+world+'"';
       var zoom = this.gmap.getZoom();
       if (this.defaults.zoom != zoom)
	       str += ' zoom="'+zoom+'"';
       var width = parseInt(this.map_div.style.width);
       if (this.defaults.width != width)
	       str += ' width="'+width+'"';
       var height = parseInt(this.map_div.style.height);
       if (this.defaults.height != height)
	       str += ' height="'+height+'"';
       for(i in this.active_controls)
         if(this.defaults[i] != this.active_controls[i])
	       str += ' '+i+'="'+this.active_controls[i]+'"';
       if (this.defaults.controls != this.current_control_type)
	       str += ' controls="'+this.current_control_type+'"';
	   str += '&gt;<br />';
	   this.map_dump_attributes_div.innerHTML = str;
	 },

// a bit crude. This is called whenever any part
// of any path changes. It iterates through all
// the paths and spits out information about them
    dumpPaths: function() {
         if (this.suppress_dumps) {
             return;
         }
         var do_show = false;
         var str = '';
         var max = 0;
         // first, get the distances.
         for(var p=0; p < this.paths.length; p++) {
             if (this.paths[p]) {
                 if (this.paths[p].distance == 0) {
                     this.paths[p].updateDistance();
                 }
                 if (this.paths[p].distance > max) {
                     max = this.paths[p].distance;
                 }
                 do_show = true;
             }
         }
         if (!do_show) {
             this.path_info_div.innerHTML = '';
             return;
         }
         for(var p=0; p<this.paths.length; p++) {
             if (this.paths[p] && this.selected_path == p) {
                 // This part lets us show the relative lengths of paths.
                 str += '<div style="margin-left: 4px; margin-bottom: 20px; clear: both;">';
                 str += this.getLineOptionsHtml(this.paths[p], p);
                 str += this.getLineLegendHtml(this.paths[p], p);
                 if (this.paths[p].poly) {
                     str += this.getFillOptionsHtml(this.paths[p], p);
                 }
                 if (p == this.active_path) {
                     str += '<div style="margin: 4px; clear: both;">'+
                         '<b>'+_['gm-editing-path']+'</b>&nbsp;&nbsp;'+
                         '<a href="javascript:void(0)" onclick="emap.endPath()">'+_['gm-save-path']+'</a>&nbsp;&nbsp;'+
                         '</div>';
                 } else {
                     str += this.getLineLinksHtml(this.paths[p], p);
                 }
                 str += '</div>';
             }
         }
         this.path_info_div.innerHTML = str;
         this.path_info_div.style.display = '';
         for(var p=0; p < this.paths.length; p++) {
             if (this.paths[p] && document.getElementById('pick_color_'+p)) {
                 this.paths[p].colorSelector.attach_to_element(document.getElementById('pick_color_'+p));
                 if(this.paths[p].poly) {
                     this.paths[p].colorSelectorFill.attach_to_element(document.getElementById('fill_color_'+p));
                 }
             }
         }
     },

    getLineLegendHtml: function(path, index) {
       str = '';
       str += '<div style="' +
           'width: 270px; '+
           'float: left; '+
           'height: '+path.stroke+'px; '+
           'margin-top: 6px; '+
           'margin-right: 4px; '+
           '-moz-opacity: '+path.line_opacity+'; '+
           'filter: alpha(opacity='+(100*path.line_opacity)+'); '+
           'font-size: 2px; '+
           'background-color: #'+path.line_color+'; '+
           '" id="path_'+index+'"></div>';
       str += '<div style="float: left;">('+path.distanceExpression()+')</div>';
       return str;
    },

    getLineLinksHtml: function(path, index) {
          str = '<div style="clear: both;">';
          str += '<a onclick="javascript:emap.activatePath('+index+')" href="javascript:void(0)">'+
              _['gm-edit-path']+
              '</a>';
          str += ' - '+
              '<a onclick="javascript:emap.paths['+index+'].jump()" href="javascript:void(0)">'+
              _['gm-show-path']+
              '</a>';

          if (path.poly) {
              str += ' - '+
                  '<a onclick="emap.paths['+index+'].removeFill()"'+
                  ' href="javascript:void(0)">'+_['gm-remove-fill']+'</a>'+
                  '&nbsp;&nbsp;';
          } else {
              str += ' - '+
                  '<a onclick="emap.paths['+index+'].addFill()"'+
                  ' href="javascript:void(0)">'+_['gm-add-fill']+'</a>';
          }
          str += '</div>';
          return str;
      },

    getLineOptionsHtml: function(path, index) {
         str = '';
         str += '<div style="float: left; clear: left;">'+_['gm-line-color']+':</div>';
         str += '<div ';
         str += 'onclick="emap.paths['+index+'].colorSelector.toggle_color_select()" ';
         str += 'id="pick_color_'+index+'" ';
         str += 'style="float: left; '+
             'margin: 2px; '+
             'background-color: #'+path.line_color+'; '+
             'border: 1px solid black; '+
             'height: 12px; '+
             'width: 12px;"';
         str += '></div>';
         str += '<div style="float: left; padding: 0px 3px;">';
         str += _['gm-opacity']+': <select style="font-size: 10px;" onchange="emap.paths['+index+'].setLineOpacity(this.value, '+index+'); this.blur()">';
         for (i=0;i<=100;i+=10) {
             str += '<option ';
             if (i == parseInt(path.line_opacity*10+0.999)*10) {
                 str += ' selected="selected" ';
             }
             str += 'value="'+(i/100)+'">'+i+'%</option>';
         }
         str += '</select>';
         str += '&nbsp;&nbsp;'+_['gm-line-width']+': ';
         str += '<select style="font-size: 10px;" onchange="emap.paths['+index+'].setStroke(this.value, '+index+'); this.blur()">';
         for (i=1;i<=12;i++) {
             str += '<option ';
             if (i == path.stroke) {
                 str += ' selected="selected" ';
             }
             str += 'value="'+i+'">'+i+'</option>';
         }
         str += '</select>';
         str += '</div>';
         return str;
    },

    getFillOptionsHtml: function(path, p) {
        str = '';
        str += '<div style="clear: both;">';

        str += '<div style="float: left;">'+_['gm-fill-color']+':</div>';
        str += '<div ';
        str += 'onclick="emap.paths['+p+'].colorSelectorFill.toggle_color_select()" ';
        str += 'id="fill_color_'+p+'" ';
        str += 'style="'+
            'float: left; '+
            'margin: 2px; '+
            'background-color: #'+path.fill_color+'; '+
            'border: 1px solid black; '+
            'height: 12px; '+
            'width: 12px;';
        str += '"></div>';
        str += '<div style="float: left; padding: 0px 3px;">';
        str += _['gm-opacity']+': '+
            '<select style="font-size: 10px;" onchange="emap.paths['+p+'].setFillOpacity(this.value, '+p+'); this.blur()">';
        for (i=0;i<=100;i+=10) {
            str += '<option ';
            if (i/100 == path.fill_opacity) {
                str += ' selected="selected" ';
            }
            str += 'value="'+(i/100)+'">'+i+'%</option>';
        }
        str += '</select>&nbsp;&nbsp;';
        str += '</div>';
        str += '<div style="'+
            'float: left; '+
            'background-color: #'+path.fill_color+'; '+
            'margin-top: 4px; '+
            'height: 12px; '+
            'width: 100px; '+
            '-moz-opacity: '+path.fill_opacity+'; '+
            'filter: alpha(opacity='+(100*path.fill_opacity)+'); '+
            '" id="area_'+p+'">';
        str += '</div>';
        str += '<div style="float: left;">';
        str += '('+path.areaExpression()+')';
        str += '</div>';

        str += '</div>';
        return str;
    },
/********** Parser methods ************/

    listMaps: function() {
                // Parse the existing article for maps that we might want to load,
                // since we're such nice guys.
                var text = this.textbox.value;
                var lines = text.split("\r\n");
                var existing_maps = [];
                var i = 0;
                for(var l=0; l < lines.length; l++) {
                  if (lines[l].match(/<googlemap[ >]/)) {
                    attrs = this.getXMLishAttributes(lines[l]);
                    if (attrs['name'] != undefined) {
                      existing_maps[i] = attrs['name'];
                    } else {
                      existing_maps[i] = _['gm-map']+' #'+(i+1);
                    }
                    i++;
                  }
                }
                this.maps_in_article = i;
                if (existing_maps[0]) {
                  map_selector_html = _['gm-load-map-from-article']+' <select id="load_map_selector">';
                  for (var e=0; e < existing_maps.length; e++) {
                    map_selector_html += '<option value="'+(+e+1)+'">'+existing_maps[e]+"</option>";
                  }
                  map_selector_html += '</select>&nbsp;&nbsp;'+
                      '<a href="javascript:void(0)" onclick="emap.loadMap(document.getElementById(\'load_map_selector\').value)">'+
                      _['gm-load-map']+'</a>&nbsp;&nbsp;&nbsp;'+
                      '<a href="javascript:void(0)" onclick="javascript:emap.refreshMapList()">'+
                      _['gm-refresh-list']+'</a>';
                  return map_selector_html;
                }
                return _['gm-no-maps']+' <a href="javascript:void(0)" onclick="javascript:emap.refreshMapList()">'+_['gm-refresh-list']+'</a>';
	      },

    refreshMapList: function() {
		      this.load_map_div.innerHTML = this.listMaps();
		    },

// reads a <googlemap> opening tag and returns a hash of the
// attributes. Somewhat fragile, use with caution.
    getXMLishAttributes: function(line) {
       var attr_hash = {};
       var attrs = line.split(' ');
       for (var a=0; a < attrs.length; a++) {
           if (attrs[a].match(/(\w+)="(.*)"/))
               attr_hash[RegExp.$1] = RegExp.$2;
       }
       return attr_hash;
    },

    translateMapNameToType: function(world, type) {
        if (world == 'earth') {
            if (type == 'hybrid')
                return G_HYBRID_MAP;
            if (type == 'satellite')
                return G_SATELLITE_MAP;
            if (type == 'terrain')
                return G_PHYSICAL_MAP;
            return G_NORMAL_MAP;
        }
        if (world == 'moon') {
            if (type =='elevation') {
                return G_MOON_ELEVATION_MAP;
            }
            return G_MOON_VISIBLE_MAP;
        }
        if (world == 'mars') {
            if (type == 'elevation') {
                return G_MARS_ELEVATION_MAP;
            }
            return G_MARS_VISIBLE_MAP;
        }
        return G_NORMAL_MAP;
    },

    translateMapTypeToName: function(world, type) {
         if (world == 'earth') {
             if (type == G_HYBRID_MAP)
                 return 'hybrid';
             if (type == G_SATELLITE_MAP)
                 return 'satellite';
             if (type == G_PHYSICAL_MAP)
                 return 'terrain';
             return 'map';
         }
         if (world == 'moon') {
             if (type == G_MOON_ELEVATION_MAP) {
                 return 'elevation';
             }
             return 'map';
         }
         if (world == 'mars') {
             if (type == G_MARS_ELEVATION_MAP) {
                 return 'elevation';
             }
             return 'map';
         }
     },

    getMapTypes: function(world) {
                     if (world == 'earth') {
                         return [G_NORMAL_MAP, G_SATELLITE_MAP, G_HYBRID_MAP, G_PHYSICAL_MAP];
                     }
                     if (world == 'moon') {
                         return G_MOON_MAP_TYPES;
                     }
                     if (world == 'mars') {
                         return G_MARS_MAP_TYPES;
                     }
                     return [];
                 },



    loadMap: function(which) {
               var text = this.textbox.value;
               var lines = text.split("\n");
               var number_maps = 0;
               var map_syntax = undefined;
               var import_mode = true;
               var attrs = {};
               var state = this.PARSE_STATE_INCLUDES;
               this.endPath(); // just in case.
               this.suppress_dumps = true;
               for (var l=0; l < lines.length; l++) {
                 if (lines[l].match(/^<googlemap[> ]/)) {
                   // OK, we have a map
                   number_maps++;
                   if (number_maps == which) {
                     this.clearMap();
                     attrs = this.getXMLishAttributes(lines[l]);
                     this.configureMap( attrs );
                     map_syntax = attrs.version ? attrs.version : "0";
                   }
                 } else if (map_syntax) { // we've started the map we're loading
                     if (lines[l].match(/^<\/googlemap>/)) {
                         this.endPath();
                         this.suppress_dumps = false;
                         this.dumpPaths();
                         // our work here is done.
                         return;
                     } else {
                         state = this.processLine(lines[l].replace(/\r$/, ''), map_syntax, state);
                     }
                 }
               }
             },

             /* constructor is broken in Safari */
copyIcon: function(orig) {
              icon = {};
              for (var i in orig) {
                  icon[i] = orig[i];
              }
              return icon;
          },

PARSE_STATE_INCLUDES: 0,
PARSE_STATE_POINTS: 1,

 // If you make a change with semantic significance, please make a
 // new syntax version
    processLine: function(line, map_syntax, state) {
         if (map_syntax == "0") {
             if (line.match(/^#([0-9a-fA-F]{6})(?: \(#([0-9a-fA-F]{6})\))?/)) {
                 if (this.paths_supported) {
                     c = this.hex2alpha(RegExp.$1);
                     if (RegExp.$2.length) {
                         f = this.hex2alpha(RegExp.$2);
                         this.addPath(c.color, c.opacity, this.stroke, f.color, f.opacity, true);
                     } else {
                         this.addPath(c.color, c.opacity, this.stroke, c.color, c.opacity, false);
                     }
                 }
             } else if (line.match(/^\/(.*?)\\ *(.*)/)) {
                 this.active_marker.addTab(RegExp.$1, RegExp.$2);
             } else { // It's a point, we hope?
                 line.match(/^(?:\((.*?)\) *)?([^, ]+), *([^ ,]+)(?:, *(.+))?/);
                 var icon = RegExp.$1;
                 var lat = parseFloat(RegExp.$2);
                 var lon = parseFloat(RegExp.$3);
                 var caption = RegExp.$4;
                 if (icon && !mapIcons[icon]) { // Just-in-time icon creation
                     mapIcons[icon] = this.copyIcon(this.default_icon);
                     mapIcons[icon].image = this.icon_base.replace('{label}', icon);
                 }
                 if (lat && lon) {
                     var mkr = new EditorsMarker(new GLatLng(lat, lon), this, '', mapIcons[icon]);
                     mkr.icon_name = icon;
                     this.addMarkerToActivePath(mkr);
                     mkr.setCaption(caption);
                 }
             }
         } else if (map_syntax == "0.9") {
             if (line.match(/^(\d+)#([0-9a-fA-F]{2})([0-9a-fA-F]{6})(?: \(#([0-9a-fA-F]{2})([0-9a-fA-F]{6})\))?/)) {
                 if (this.paths_supported) {
                     if (RegExp.$4.length) {
                         this.addPath(RegExp.$3, parseInt(RegExp.$2, 16) / 255,
                                 RegExp.$1, RegExp.$5, parseInt(RegExp.$4, 16) / 255, true);
                     } else {
                         this.addPath(RegExp.$3, parseInt(RegExp.$2, 16) / 255,
                                 RegExp.$1, RegExp.$3, parseInt(RegExp.$2, 16) / 255, false);
                     }
                 }
             } else if (line.match(/^(http:\/\/.*)/) && state == this.PARSE_STATE_INCLUDES) {
                 this.addXmlSource(RegExp.$1);
             } else if (line.match(/^\/(.*?)\\/)) {
                 this.active_marker.addTab(RegExp.$1);
             } else if (line.match(/^(?:\((.*?)\) *)?([^, ]+), *([^ ,]+)(?:, *(.+))?/)) {
                 state = this.PARSE_STATE_POINTS;
                 var icon = RegExp.$1;
                 var lat = parseFloat(RegExp.$2);
                 var lon = parseFloat(RegExp.$3);
                 var title = RegExp.$4;
                 if (icon && !mapIcons[icon]) { // Just-in-time icon creation
                     mapIcons[icon] = this.copyIcon(this.default_icon);
                     mapIcons[icon].image = this.icon_base.replace('{label}', icon);
                 }
                 if (lat && lon) {
                     var mkr = new EditorsMarker(new GLatLng(lat, lon), this, title, mapIcons[icon]);
                     mkr.icon_name = icon;
                     this.addMarkerToActivePath(mkr);
                     mkr.setCaption('');
                 }
             } else if (this.active_marker) {
                 if (this.active_marker.tabs.length) {
                     if (this.active_marker.tabs[this.active_marker.tabs.length-1].content) {
                         this.active_marker.tabs[this.active_marker.tabs.length-1].content += "\r\n" + line;
                     } else {
                         this.active_marker.tabs[this.active_marker.tabs.length-1].content = line;
                     }
                     this.active_marker.dump();
                 } else {
                     if (this.active_marker.caption) {
                         this.active_marker.setCaption(this.active_marker.caption + "\r\n" + line);
                     } else {
                         this.active_marker.setCaption(line);
                     }
                 }
             }
         }
         return state;
    },
/******* XML sources (KML/GeoRSS) *********/

addXmlSource: function(url) {
                  document.getElementById('kml_include_link').style.display = 'none';
                  document.getElementById('kml_include_loading').style.display = '';
                  document.getElementById('kml_include').value = 'http://';
                  var emap = this;
                  geoxml = new GGeoXml(url,
                      function() {
                          if (!geoxml.loadedCorrectly()) {
                              alert("Failed to load XML file");
                          }
                          emap.includes[emap.includes.length] = { 'url':url, 'overlay': geoxml };
                          emap.dumpXmlSources();
                          document.getElementById('kml_include_link').style.display = '';
                          document.getElementById('kml_include_loading').style.display = 'none';
                          var span = document.createElement("span");
                          span.innerHTML = url + "<br />";
                          emap.map_dump_includes_div.appendChild(span);
                  });
                  this.gmap.addOverlay(geoxml);
              },

dumpXmlSources: function() {
                    emap.kml_list.innerHTML = '';
                    for(var i=0; i<this.includes.length; i++) {
                          var li = document.createElement("li");
                          li.innerHTML = this.includes[i].url +
                          ' (<a href="javascript:void(0)" onclick="emap.showXmlPoints('+i+')">show points</a>)'+
                          ' (<a href="javascript:void(0)" onclick="emap.removeXmlSource('+i+')">remove</a>)';
                          emap.kml_list.appendChild(li);
                    }
                },

showXmlPoints: function(which) {
                   this.includes[which].overlay.gotoDefaultViewport(this.gmap);
               },

removeXmlSource: function(which) {
                     this.kml_list.removeChild(this.kml_list.childNodes[which]);
                     this.gmap.removeOverlay(this.includes[which].overlay);
                     this.includes.splice(which, 1);
                     this.map_dump_includes_div.removeChild(this.map_dump_includes_div.childNodes[which]);
                     this.dumpXmlSources();
                },

/********** Math library! *********/  // <-- joke

    round: function(number) {
                  return Math.round(number * Math.pow(10, this.precision)) / Math.pow(10, this.precision);
                },

// This method treats whiteness as transparency,
// returning a renormalized hex value and the
// opacity level. Works well for the "map" view,
// not so well for others. Might need to do something
// different for the satellite imagery, in the future...
    hex2alpha: function(hex) {
                 hex = hex.replace(/#/, '');
                 hex = hex.toUpperCase();
                 var rgb = [ parseInt(hex.substring(0, 2), 16),
                     parseInt(hex.substring(2, 4), 16),
                     parseInt(hex.substring(4, 6), 16) ];
                 var lets = "0123456789ABCDEF".split('');
                 var min = 255;
                 for(var i=0; i<rgb.length; i++) {
                   if (rgb[i] < min) {
                     min = rgb[i];
                   }
                 }
                 for(var i=0; i<rgb.length; i++) {
                   // re-normalize
                   rgb[i] = (rgb[i] - min) * (256 / (256 - min));
                   // hexify
                   rgb[i] = lets[rgb[i] >> 4] + lets[rgb[i] & 0xf];
                 }
                 return( { 'color': '#'+rgb.join(''), 'opacity': (256 - min) * 1.0 / 256 } );
               }
};

// These are required by color_select.js, which is a great tool,
// but rather rude javascript. I wish I just pass it a function reference.

function color_change_update(new_color, selector_id) {
    new_color = new_color.replace(/#/, '');
    var info = colorSelectorRegistry[selector_id];
    for( var i = 0; i <  emap.paths.length; i++ ) {
        if( emap.paths[i] == info.path ) {
            if( info.type == 'line' ) {
                if (document.getElementById('path_'+i))
                    document.getElementById('path_'+i).style.backgroundColor = '#'+new_color;
                if (document.getElementById('pick_color_'+i))
                    document.getElementById('pick_color_'+i).style.backgroundColor = '#'+new_color;
                info.path.updateLineColor(new_color);
            } else {
                if (document.getElementById('area_'+i))
                    document.getElementById('area_'+i).style.backgroundColor = '#'+new_color;
                if (document.getElementById('fill_color_'+i))
                    document.getElementById('fill_color_'+i).style.backgroundColor = '#'+new_color;
                info.path.updateFillColor(new_color);
            }
        }
    }
}

function color_hide_update(new_color, selector_id) {
  var info = colorSelectorRegistry[selector_id];
  if (info.type == 'fill') {
      info.path.updateFillColor(new_color.replace(/#/, ''));
  } else {
      info.path.updateLineColor(new_color.replace(/#/, ''));
  }
}
