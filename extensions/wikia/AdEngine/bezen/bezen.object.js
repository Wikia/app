/*
 * bezen.object.js - Object utilities
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
bezen.object = (function() {
  // Builder of
  // Closure for Object utilities
   
  var beget = function(prototype){
    // Create a new object inheriting properties through a link to the given 
    // prototype.
    //
    // Adapted from code of Object.beget, p.22 in
    //   "Javascript: The Good Parts"
    //   by Douglas Crockford.
    //   Copyright 2008 Yahoo! Inc.
    //   ISBN13: 978-0-596-51774-8
    // used under conditions defined in "Using Code Examples".
     
    var F = function(){};
    F.prototype = prototype;
    return new F();
  };
   
  var exists = function(object) {
    // Check whether an object exists, and, by providing extra arguments,
    // whether each following argument can be accessed in turn on the object
    //
    // For example, calling
    //   exists({list: ['A','B', 0, 2] }, 'list', 1)
    // will return true, while calling
    //   exists(null)
    // is false, and so is
    //   exists({list:[]}, 'list', 0)
    // since the array list has no item defined at 0
    //
    // Note that this method checks for undefined and null, so
    //   exists( {list:[null]}, 'list', 0)
    // would return false as well
    //
    // You can provide extra arguments to check deeper into the object.
    // 
    // The intent of this method is to allow doing at once
    // if ( exists(a,b,c,d,e,f) ) {
    //   a.b.c.d.e.f.g = 'safe';
    // }
    // without risking to access a non-existing property if one of
    // a,b,c,d,e,f is not defined...
    //
    // params:
    //   object - (object) (null) (undefined) 
    //            an object to check for existence and properties
    //   ... (following arguments) - (list of strings) properties to be looked
    //                               for in chain: object.a.b.c ...
    // return: (boolean)
    //   true if the whole chain exists,
    //   false if null or undefined is found at some point in the chain.
    //
    if ( object===null || object===undefined ) {
      return false;
    }
    
    for (var i=1; i<arguments.length; i++) {
      object = object[ arguments[i] ];
      if ( object===null || object===undefined ) {
        return false;
      }
    }
    
    return true;
  };
  
  var isArray = function(that) {
    // Return true iff that is an array
    // Adapted from code of is_array, p.61 in
    //   "Javascript: The Good Parts"
    //   by Douglas Crockford.
    //   Copyright 2008 Yahoo! Inc.
    //   ISBN13: 978-0-596-51774-8
    // used under conditions defined in "Using Code Examples".
    //
    // params:
    //   that - (any) the object or value to check
    //
    // return: (boolean)
    //   true iff that is considered to be an array
    //   false otherwise
    
    var result =
      that &&
      typeof that === 'object' &&
      typeof that.length === 'number' &&
      typeof that.splice === 'function' &&
      !( that.propertyIsEnumerable('length') );
    return result? true: false; // return false, even if that is only falsy
  };

  var isString = function(that) {
    // check whether that is a string,
    // either a String object or a string litteral
    //
    // params:
    //   that - (any) the object or value to check
    //
    // return: (boolean)
    //   true iff that is a string
    //   false otherwise
     
    return typeof that === 'string' ||
           that instanceof String;
  };

  return { // public API
    beget: beget,
    exists: exists,
    isArray: isArray,
    isString: isString,
     
    _:{ // private section, for unit tests
    }
  };
}());
