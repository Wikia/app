/*
 * bezen.load.js - Dynamic script loading utilities
 *
 * author:    Eric Bréchemier <bezen@eric.brechemier.name>
 * license:   Creative Commons Attribution 3.0 Unported
 *            http://creativecommons.org/licenses/by/3.0/
 * version:   2010-01-14 "Calvin's Snowball"
 *
 * To Cecile, with Love,
 * you were the first to wait for the conception of this library
 *
 * Tested successfully in
 *   Firefox 2, Firefox 3, Firefox 3.5,
 *   Internet Explorer 6, Internet Explorer 7, Internet Explorer 8,
 *   Chrome 3, Safari 3, Safari 4,
 *   Opera 9.64, Opera 10.10
 */
/*requires bezen.js */
/*requires bezen.array.js */
/*requires bezen.object.js */
/*requires bezen.dom.js */
/*jslint nomen:false, white:false, onevar:false, plusplus:false */
/*global bezen, setTimeout, document */
bezen.load = (function() {
  // Builder of
  // Closure for Dynamic script loading utilities
  
  // Define aliases
  var nix = bezen.nix,
      isString = bezen.object.isString,
      unshift = bezen.array.unshift,
      appendScript = bezen.dom.appendScript,
      element = bezen.dom.element;
   
  var loadScript = function(parent, attributes, callback, delay) {
    // create a dynamic script element in given location
    //
    // params:
    //   parent - (DOM element) (optional) (default: document.body) parent to 
    //            append the dynamic script element to
    //
    //   attributes - (object or string) (!nil) object with properties 
    //                corresponding to the attributes of the script to create,
    //                including at least the mandatory "src" attribute;
    //                alternatively a string with the "src" attribute value.
    //
    //   callback - (function) (optional) (default: bezen.nix) the callback to
    //              trigger after the script has successfully loaded
    //
    //   delay - (integer) (optional) (default: 0) waiting delay, in 
    //           milliseconds, in the setTimeout prior to the insertion of 
    //           the new script in DOM
    //
    // Note:
    //   Firefox waits for a 250ms delay before the initial paint of the page,
    //   a tradeoff to avoid some reflows while loading data that changes the
    //   contents and layout of the page. In order to give some breeze to the
    //   browser before loading dynamic scripts, the delay of the first script
    //   in the chain should be set to a value higher than 250ms. On the 
    //   contrary, the scripts that provide core functionalities of your web
    //   site should be loaded with a static script tag or a delay of 0ms.
    //
    //   You may want to wait for a user action to start the dynamic loading;
    //   the description of the Google Fade In Effect, although it is not used
    //   for the purpose of dynamic script loading, is a good illustration of
    //   this technique:
    //
    //        Fade In Effect in Google Home Page
    //    
    //   At the end of 2009, Google changed its own page to display only the
    //   core UI at first (the logo, search form and sometimes a featured ad), 
    //   and load the rest of the page dynamically, with a fade in.
    //
    //   The fade is triggered when the mouse moves or when the focus leaves
    //   the search input box by pressing the tab key (but it will not get
    //   triggered if you just input keywords and validate with enter):
    //
    //   www.google.com
    //   <!doctype html><html onmousemove="google&&google.fade&&google.fade()">
    //   (...)
    //   <input autocomplete="off" onblur="google&&google.fade&&google.fade()"
    //   (...)
    //   <form action="/search" name=f onsubmit="google.fade=null">
    //   (...)
    //
    //   Google also uses dynamic script loading on its home page, but it is 
    //   not triggered by this mechanism. The dynamic loading code is called
    //   in a setTimeout with a delay of 0ms, from an internal script at the
    //   end of the page.
    //
    // Reference:
    //   nglayout.initialpaint.delay - MozillaZine Knowledge Base
    //   http://kb.mozillazine.org/nglayout.initialpaint.delay
    //
    if ( parent && !parent.nodeType ) {
      // optional parent omitted, add null parent first and shift arguments
      unshift(arguments,null);
      return loadScript.apply(null,arguments);
    }
    if ( isString(attributes) ) {
      return loadScript(parent, {src:attributes}, callback, delay);
    }
    callback = callback || nix;
    parent = parent || document.body;
    delay = delay || 0;
     
    // Note: setTimeout allows Firefox to behave like IE and Safari for
    // asynchronous loading, and take the burden off the onload thread to
    // improve user experience, by letting user events fire: scrolling, click 
    // for navigation...
    //
    // Reference:
    // http://www.artzstudio.com/2008/07
    //                          /beating-blocking-javascript-asynchronous-js/
    setTimeout(function(){
      appendScript(parent, element("script", attributes), callback);
    },delay);
  };
   
  var getSingleCallback = function(total, callback) {
    // get a unique callback for a set of listeners
    // The intent is to wait for all listeners before triggering the
    // provided callback function. This is done by setting the one
    // callback returned by this function to each listener.
    //
    // Note: all listeners must fire for the provided callback to be called
    //
    // params:
    //   total - (integer) (!nil) the number of listeners to wait for
    //   callback - (function) the callback function
    //
    // return:
    //   the expected single callback function if the callback is defined,
    //   bezen.nix otherwise
    // 
    if (!callback) {
      return nix;
    }
     
    var count = 0;
    return function() {
      count++;
      if (count < total) {
        return;
      }
      callback();
    };
  };

  var loadScripts = function(parent, attributesArray, callback, delay) {
    // load a set of external scripts in parallel
    // 
    // params:
    //   parent - (DOM element) (optional) (default: document.body) the parent
    //            to append dynamic scripts elements to
    //
    //   attributesArray - (array) (!nil) a list of objects with properties
    //                     corresponding to the attributes of scripts to
    //                     create, including at least the "src" attribute
    //                     Alternatively an array of strings corresponding
    //                     to the "src" attribute value for each script.
    //
    //   callback - (function) (optional) (default: bezen.nix) the callback to
    //              trigger after all scripts have successfully loaded
    //
    //   delay - (integer) (optional) (default: 0) waiting delay, in 
    //           milliseconds, in the setTimeout prior to the insertion of 
    //           each new script element in DOM
    if (parent && !parent.nodeType) {
      // optional parent omitted, add null parent first and shift arguments
      unshift(arguments,null);
      return loadScripts.apply(null,arguments);
    }
     
    var commonCallback = getSingleCallback(attributesArray.length, callback);
    for (var i=0; i<attributesArray.length; i++) {
      loadScript(parent, attributesArray[i], commonCallback, delay);
    }
  };
   
  return { // public API
    script: loadScript,
    scripts: loadScripts,
    
    _: { // private section, for unit tests
      getSingleCallback: getSingleCallback
    }
  };
}());
