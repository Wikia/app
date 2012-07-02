/*
    geoXML3.js

    Renders KML on the Google Maps JavaScript API Version 3 
    http://code.google.com/p/geoxml3/

   Copyright 2009 Sterling Udell

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.

*/

// Extend the global String with a method to remove leading and trailing whitespace
if (!String.prototype.trim) {
  String.prototype.trim = function () {
    return this.replace(/^\s+|\s+$/g, '');
  };
}

// Declare namespace
geoXML3 = window.geoXML3 || {};

// Constructor for the root KML parser object
geoXML3.parser = function (options) {
  // Private variables
  var parserOptions = geoXML3.combineOptions(options, {
    singleInfoWindow: false,
    processStyles: true,
    zoom: true
  });
  var docs = []; // Individual KML documents
  var lastMarker;

  // Private methods

  var parse = function (urls) {
    // Process one or more KML documents
  
    if (typeof urls === 'string') {
      // Single KML document
      urls = [urls];
    }

    // Internal values for the set of documents as a whole
    var internals = {
      docSet: [],
      remaining: urls.length,
      parserOnly: !parserOptions.afterParse
    }; 

    var thisDoc;
    for (var i = 0; i < urls.length; i++) {
      thisDoc = {
        url: urls[i], 
        internals: internals
      };
      internals.docSet.push(thisDoc);
      geoXML3.fetchXML(thisDoc.url, function (responseXML) {render(responseXML, thisDoc);});
    }
  };

  var hideDocument = function (doc) {
    // Hide the map objects associated with a document 
    var i;
    for (i = 0; i < doc.markers.length; i++) {
      this.markers[i].set_visible(false);
    }
    for (i = 0; i < doc.overlays.length; i++) {
      doc.overlays[i].setOpacity(0);
    }
  };
  
  var showDocument = function (doc) {
    // Show the map objects associated with a document 
    var i;
    for (i = 0; i < doc.markers.length; i++) {
      doc.markers[i].set_visible(true);
    }
    for (i = 0; i < doc.overlays.length; i++) {
      doc.overlays[i].setOpacity(doc.overlays[i].percentOpacity_);
    }
  };

  var render = function (responseXML, doc) {
    // Callback for retrieving a KML document: parse the KML and display it on the map

    if (!responseXML) {
      // Error retrieving the data
      geoXML3.log('Unable to retrieve ' + doc.url);
      if (parserOptions.failedParse) {
        parserOptions.failedParse(doc);
      }
    } else if (!doc) {
      throw 'geoXML3 internal error: render called with null document';
    } else {
      doc.styles = {};
      doc.placemarks = [];
      doc.groundOverlays = [];
      if (parserOptions.zoom && !!parserOptions.map)
        doc.bounds = new google.maps.LatLngBounds();
  
      // Parse styles
      var styleID, iconNodes, i;
      var styleNodes = responseXML.getElementsByTagName('Style');
      for (i = 0; i < styleNodes.length; i++) {
        styleID   = styleNodes[i].getAttribute('id');
        iconNodes = styleNodes[i].getElementsByTagName('Icon');
        if (!!iconNodes.length) {
          doc.styles['#' + styleID] = {
            href: geoXML3.nodeValue(iconNodes[0].getElementsByTagName('href')[0])
          };
        }
      }
      if (!!parserOptions.processStyles || !parserOptions.createMarker) {
        // Convert parsed styles into GMaps equivalents
        processStyles(doc);
      }
      
      // Parse placemarks
      var placemark, node, coords, path;
      var placemarkNodes = responseXML.getElementsByTagName('Placemark');
      for (i = 0; i < placemarkNodes.length; i++) {
        // Init the placemark object
        node = placemarkNodes[i];
        placemark = {
          name:  geoXML3.nodeValue(node.getElementsByTagName('name')[0]),
          description: geoXML3.nodeValue(node.getElementsByTagName('description')[0]),
          styleUrl: geoXML3.nodeValue(node.getElementsByTagName('styleUrl')[0])
        };
        placemark.style = doc.styles[placemark.styleUrl] || {};
        if (/^https?:\/\//.test(placemark.description)) {
          placemark.description = '<a href="' + placemark.description + '">' + placemark.description + '</a>';
        }

        // Extract the coordinates
        coords = geoXML3.nodeValue(node.getElementsByTagName('coordinates')[0]).trim();
        coords = coords.replace(/\s+/g, ' ').replace(/, /g, ',');
        path = coords.split(' ');

        // What sort of placemark?
        if (path.length === 1) {
          // Polygons/lines not supported in v3, so only plot markers
          coords = path[0].split(',');
          placemark.point = {
            lat: parseFloat(coords[1]), 
            lng: parseFloat(coords[0]), 
            alt: parseFloat(coords[2])
          };
          if (!!doc.bounds) {
            doc.bounds.extend(new google.maps.LatLng(placemark.point.lat, placemark.point.lng));
          }

          // Call the appropriate function to create the marker
          if (!!parserOptions.createMarker) {
            parserOptions.createMarker(placemark, doc);
          } else {
            createMarker(placemark, doc);
          }
        }
      }
  
      // Parse ground overlays
      var groundOverlay, color, transparency;
      var groundNodes = responseXML.getElementsByTagName('GroundOverlay');
      for (i = 0; i < groundNodes.length; i++) {
        node = groundNodes[i];
        
        // Init the ground overlay object
        groundOverlay = {
          name:        geoXML3.nodeValue(node.getElementsByTagName('name')[0]),
          description: geoXML3.nodeValue(node.getElementsByTagName('description')[0]),
          icon: {href: geoXML3.nodeValue(node.getElementsByTagName('href')[0])},
          latLonBox: {
            north: parseFloat(geoXML3.nodeValue(node.getElementsByTagName('north')[0])),
            east:  parseFloat(geoXML3.nodeValue(node.getElementsByTagName('east')[0])),
            south: parseFloat(geoXML3.nodeValue(node.getElementsByTagName('south')[0])),
            west:  parseFloat(geoXML3.nodeValue(node.getElementsByTagName('west')[0]))
          }
        };
        if (!!doc.bounds) {
          doc.bounds.union(new google.maps.LatLngBounds(
            new google.maps.LatLng(groundOverlay.latLonBox.south, groundOverlay.latLonBox.west),
            new google.maps.LatLng(groundOverlay.latLonBox.north, groundOverlay.latLonBox.east)
          ));
        }

        // Opacity is encoded in the color node
        color = geoXML3.nodeValue(node.getElementsByTagName('color')[0]);
        if ((color !== '') && (color.length == 8)) {
          transparency = parseInt(color.substring(0, 2), 16);
          groundOverlay.opacity = Math.round((255 - transparency) / 2.55);
        } else {
          groundOverlay.opacity = 100;
        }
  
        // Call the appropriate function to create the overlay
        if (!!parserOptions.createOverlay) {
          parserOptions.createOverlay(groundOverlay, doc);
        } else {
          createOverlay(groundOverlay, doc);
        }
      }

      if (!!doc.bounds) {
        doc.internals.bounds = doc.internals.bounds || new google.maps.LatLngBounds();
        doc.internals.bounds.union(doc.bounds); 
      }
      if (!!doc.styles || !!doc.markers || !!doc.overlays) {
        doc.internals.parserOnly = false;
      }

      doc.internals.remaining -= 1;
      if (doc.internals.remaining === 0) {
        // We're done processing this set of KML documents

        // Options that get invoked after parsing completes
        if (!!doc.internals.bounds) {
          parserOptions.map.fitBounds(doc.internals.bounds); 
        }
        if (parserOptions.afterParse) {
          parserOptions.afterParse(doc.internals.docSet);
        }

        if (!doc.internals.parserOnly) {
          // geoXML3 is not being used only as a real-time parser, so keep the parsed documents around
          docs.concat(doc.internals.docSet);
        }
      }
    }
  };
    
  var processStyles = function (doc) {
    var stdRegEx = /\/(red|blue|green|yellow|lightblue|purple|pink|orange)(-dot)?\.png/;
    for (var styleID in doc.styles) {
      if (!!doc.styles[styleID].href) {
        // Init the style object with a standard KML icon
        doc.styles[styleID].icon =  new google.maps.MarkerImage(
          doc.styles[styleID].href,
          new google.maps.Size(32, 32),
          new google.maps.Point(0, 0),
          new google.maps.Point(16, 12)
        );

        // Look for a predictable shadow
        if (stdRegEx.test(doc.styles[styleID].href)) {
          // A standard GMap-style marker icon
          doc.styles[styleID].shadow = new google.maps.MarkerImage(
              'http://maps.google.com/mapfiles/ms/micons/msmarker.shadow.png',
              new google.maps.Size(59, 32),
              new google.maps.Point(0, 0),
              new google.maps.Point(16, 12));
        } else if (doc.styles[styleID].href.indexOf('-pushpin.png') > -1) {
          // Pushpin marker icon
          doc.styles[styleID].shadow = new google.maps.MarkerImage(
            'http://maps.google.com/mapfiles/ms/micons/pushpin_shadow.png',
            new google.maps.Size(59, 32),
            new google.maps.Point(0, 0),
            new google.maps.Point(16, 12));
        } else {
          // Other MyMaps KML standard icon
          doc.styles[styleID].shadow = new google.maps.MarkerImage(
            doc.styles[styleID].href.replace('.png', '.shadow.png'),
            new google.maps.Size(59, 32),
            new google.maps.Point(0, 0),
            new google.maps.Point(16, 12));
        }
      }
    }
  };

  var createMarker = function (placemark, doc) {
    // create a Marker to the map from a placemark KML object

    // Load basic marker properties
    var markerOptions = geoXML3.combineOptions(parserOptions.markerOptions, {
      map:      parserOptions.map,
      position: new google.maps.LatLng(placemark.point.lat, placemark.point.lng),
      title:    placemark.name,
      zIndex:   Math.round(-placemark.point.lat * 100000),
      icon:     placemark.style.icon,
      shadow:   placemark.style.shadow 
    });
  
    // Create the marker on the map
    var marker = new google.maps.Marker(markerOptions);

    // Set up and create the infowindow
    var infoWindowOptions = geoXML3.combineOptions(parserOptions.infoWindowOptions, {
      content: '<div class="infowindow"><h3>' + placemark.name + 
               '</h3><div>' + placemark.description + '</div></div>',
      pixelOffset: new google.maps.Size(0, 2)
    });
    marker.infoWindow = new google.maps.InfoWindow(infoWindowOptions);

    // Infowindow-opening event handler
    google.maps.event.addListener(marker, 'click', function() {
      if (!!parserOptions.singleInfoWindow) {
        if (!!lastMarker && !!lastMarker.infoWindow) {
          lastMarker.infoWindow.close();
        }
        lastMarker = this;
      }
      this.infoWindow.open(this.map, this);
    });
    
    if (!!doc) {
      doc.markers = doc.markers || [];
      doc.markers.push(marker);
    }

    return marker;
  };
  
  var createOverlay = function (groundOverlay, doc) {
    // Add a ProjectedOverlay to the map from a groundOverlay KML object

    if (!window.ProjectedOverlay) {
      throw 'geoXML3 error: ProjectedOverlay not found while rendering GroundOverlay from KML';
    }

    var bounds = new google.maps.LatLngBounds(
        new google.maps.LatLng(groundOverlay.latLonBox.south, groundOverlay.latLonBox.west),
        new google.maps.LatLng(groundOverlay.latLonBox.north, groundOverlay.latLonBox.east)
    );
    var overlayOptions = geoXML3.combineOptions(parserOptions.overlayOptions, {percentOpacity: groundOverlay.opacity});
    var overlay = new ProjectedOverlay(parserOptions.map, groundOverlay.icon.href, bounds, overlayOptions);
    
    if (!!doc) {
      doc.overlays = doc.overlays || [];
      doc.overlays.push(overlay);
    }

    return 
  };

  return {
    // Expose some properties and methods

    options: parserOptions,
    docs:    docs,
    
    parse:         parse,
    hideDocument:  hideDocument,
    showDocument:  showDocument,
    processStyles: processStyles, 
    createMarker:  createMarker,
    createOverlay: createOverlay
  };
};
// End of KML Parser

// Helper objects and functions

// Log a message to the debugging console, if one exists
geoXML3.log = function(msg) {
  if (!!window.console) {
    console.log(msg);
  }
};

// Combine two options objects, a set of default values and a set of override values 
geoXML3.combineOptions = function (overrides, defaults) {
  var result = {};
  if (!!overrides) {
    for (var prop in overrides) {
      if (overrides.hasOwnProperty(prop)) {
        result[prop] = overrides[prop];
      }
    }
  }
  if (!!defaults) {
    for (prop in defaults) {
      if (defaults.hasOwnProperty(prop) && (result[prop] === undefined)) {
        result[prop] = defaults[prop];
      }
    }
  }
  return result;
};

// Retrieve a text document from url and pass it to callback as a string
geoXML3.fetchers = [];
geoXML3.fetchXML = function (url, callback) {
  function timeoutHandler() {
    callback();
  };

  var xhrFetcher;
  if (!!geoXML3.fetchers.length) {
    xhrFetcher = geoXML3.fetchers.pop();
  } else {
    if (!!window.XMLHttpRequest) {
      xhrFetcher = new window.XMLHttpRequest(); // Most browsers
    } else if (!!window.ActiveXObject) {
      xhrFetcher = new window.ActiveXObject('Microsoft.XMLHTTP'); // Some IE
    }
  }

  if (!xhrFetcher) {
    geoXML3.log('Unable to create XHR object');
    callback(null);
  } else {
    xhrFetcher.open('GET', url, true);
    xhrFetcher.onreadystatechange = function () {
      if (xhrFetcher.readyState === 4) {
        // Retrieval complete
        if (!!xhrFetcher.timeout)
          clearTimeout(xhrFetcher.timeout);
        if (xhrFetcher.status >= 400) {
          geoXML3.log('HTTP error ' + xhrFetcher.status + ' retrieving ' + url);
          callback();
        } else {
          // Returned successfully
          callback(xhrFetcher.responseXML);
        }
        // We're done with this fetcher object
        geoXML3.fetchers.push(xhrFetcher);
      }
    };
    xhrFetcher.timeout = setTimeout(timeoutHandler, 60000);
    xhrFetcher.send(null);
  }
};

//nodeValue: Extract the text value of a DOM node, with leading and trailing whitespace trimmed
geoXML3.nodeValue = function(node) {
  if (!node) {
    return '';
  } else {
    return (node.innerText || node.text || node.textContent).trim();
  }
};
