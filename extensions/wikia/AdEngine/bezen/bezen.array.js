/*
 * bezen.array.js - Array utilities
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
bezen.array = (function() {
  // Builder of
  // Closure for Array utilities
  
  var ARRAY = []; // used to borrow instance methods for array-like objects
                  // e.g. ARRAY.push.call(arguments,null);
                  // This technique was documented by Matthew Wilson,
                  // http://diakopter.blogspot.com
                  //       /2009/05/efficient-javascript-arguments.html 
   
  var empty = function(array) {
    // remove all elements from an array
    // by setting its length to 0
    //
    // params:
    //   array - (array)(!nil) an array
     
    array.length = 0;
  };

  var last = function(array) {
    // get the last item of an array
    //
    // params:
    //   array - (array)(!nil) an array
    //
    // return:
    //   the last item in the array,
    //   or null in case the array is undefined, null or empty
    if (!array || array.length===0) {
      return null;
    }
     
    return array[array.length -1];
  };
  
  var push = function(array, item){
    // simulate Array.push for array-like objects
    // Note: while push allows unlimited items, this method is limited to 
    //       a single item and will ignore any following arguments.
    //
    // params:
    //   array - (object) array-like object, e.g. function arguments
    //   item - (any) the item to push to the array
    //
    // return: (integer)
    //   the new length of the array
     
    if (Array.push) {
      // use native method
      return Array.push(array,item);
    } else {
      return ARRAY.push.call(array,item);
    }
  };

  var pop = function(array){
    // simulate Array.pop for array-like objects
    //
    // params:
    //   array - (object) array-like object, e.g. function arguments
    //
    // return: (any)
    //   the last element, removed from the array if the array was not empty,
    //   undefined if the array was empty
     
    if (Array.pop) {
      // use native method
      return Array.pop(array);
    } else {
      return ARRAY.pop.call(array);
    }
  };
   
  var shift = function(array){
    // simulate Array.shift for array-like objects
    //
    // params:
    //   array - (object) array-like object, e.g. function arguments
    //
    // return: (any)
    //   the first element, removed from the array if the array was not empty,
    //   undefined if the array was empty
     
    if (Array.shift) {
      // use native method
      return Array.shift(array);
    } else {
      return ARRAY.shift.call(array);
    }
  };
  
  var unshift = function(array, item){
    // simulate Array.unshift for array-like objects
    // Note: while unshift allows unlimited items, this method is limited to 
    //       a single item and will ignore any following arguments.
    //
    // params:
    //   array - (object) array-like object, e.g. function arguments
    //   item - (any) the item to prepend to the array
    //
    // return: (integer)
    //   the new length of the array
    //   Note: in IE, this method returns undefined
     
    if (Array.unshift) {
      // use native method
      return Array.unshift(array,item);
    } else {
      return ARRAY.unshift.call(array,item);
    }
  };

  var copy = function(array){
    // return a swallow copy of the given array/array-like object
    //
    // param:
    //   array - (array or object) the array or array-like object to copy
    //
    // return:
    //   null if the array is null or undefined,
    //   a new array with the same items as the given array otherwiser
    if (!array){
      return null;
    }
    
    var duplicate = [];
    for (var i=0; i<array.length; i++){
      duplicate.push(array[i]);
    }
    return duplicate;
  };

  var hash = function(array){
    // return a hash of values in the given array/array-like object
    //
    // params:
    //   array - (array or object) an array or array-like object with a list
    //           of property names to set to the resulting unordered hash
    //
    // return: (object)
    //   an array-like object with a property set to true for each name in the
    //   given array.
    //
    if (!array){
      return null;
    }
     
    var arrayhash = {};
    for (var i=0; i<array.length; i++) {
      arrayhash[ array[i] ] = true;
    }
    return arrayhash;
  };

  return { // public API
    empty: empty,
    last: last,
    // isArray: see bezen.object.isArray
    push: push,
    pop: pop,
    shift: shift,
    unshift: unshift,
    copy: copy,
    hash: hash,

    _:{ // private section, for unit tests
    }
  };
}());
