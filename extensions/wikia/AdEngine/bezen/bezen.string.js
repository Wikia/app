/*
 * bezen.string.js - String utilities
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
/*jslint nomen:false, white:false, onevar:false, plusplus:false */
/*global bezen */
bezen.string = (function() {
  // Builder of
  // Closure for String utilities

  var trim = function(string) {
    // trim a string 
    //
    // param:
    //   string - (string) (!nil) a string
    //
    // return: (string)
    //   a copy of the string, with initial and final whitespace removed
    //
    // I use here the trim1 algorithm described by Steven Levithan
    // as "a general-purpose implementation which is fast cross-browser"
    // http://blog.stevenlevithan.com/archives/faster-trim-javascript
    
    string = string.replace(/^\s\s*/, ''); // remove leading whitespace
    return string.replace(/\s\s*$/, ''); // remove trailing whitespace
  };
  
  var startsWith = function(string, prefix) {
    // whether a string starts with a given prefix
    //
    // params:
    //   string - (string)(!nil) a string
    //   prefix - (string, ...) a prefix to be searched for at the start of
    //            the string. Note: the prefix is first converted to a string.
    //
    // return: (boolean)
    //   true when the prefix is found at start
    //   false otherwise
    //
    // This implementation compares the prefix with the start of the string,
    // up to the length of the prefix.
    prefix = String(prefix);
    
    return string.slice(0,prefix.length) === prefix;
  };

  var endsWith = function(string, suffix) {
    // whether a string ends with a given suffix
    //
    // params:
    //   string - (string) a string
    //   suffix - (string, ...) a suffix to be searched for at the end of
    //            the string. Note: the prefix is first converted to a string.
    //
    // return: (boolean)
    //   true when the suffix is found at end
    //   false otherwise
    //
    // This implementation compares the suffix with the end of the string,
    // up to the length of the suffix.
    suffix = String(suffix);

    return string.slice(string.length-suffix.length) === suffix;
  };

  return { // public API
    trim: trim,
    startsWith: startsWith,
    endsWith: endsWith,
     
    _: { // private section, for unit tests
    }
  };
}());
