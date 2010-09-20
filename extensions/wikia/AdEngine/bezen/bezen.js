/*
 * bezen.js - Root of bezen.org Javascript library
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
/*jslint nomen:false, white:false, onevar:false, plusplus:false */
/*global window, bezen, document */
// preserve the library, if already loaded
window.bezen = window.bezen || (function() {
  // Builder of
  // Closure for Root of bezen.org Javascript library

  var nix = function(){  
    // an empty function that does nothing
    // declared here to be reused as a constant where needed, instead
    // of creating a new similar-looking function in many places
  };
   
  var $ = function(id) {
    // The classic shortcut for getElementById(), in its simplest form.
    // Note: nothing fancy here, this is just an alias for getElementById.
    //
    // param:
    //   id - (string) a DOM element identifier
    //
    // return: (DOM node) (null)
    //   same result as document.getElementById
     
    return document.getElementById(id);
  };
   
  return { // public API
    $: $,
    nix: nix,
     
    _: { // private section, for unit tests
    }
  };
}());
