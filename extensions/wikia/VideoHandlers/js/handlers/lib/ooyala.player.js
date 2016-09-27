try {
(function() {
  var OO = {};
OO.playerParams={"analytics_server":"http://player.ooyala.com","analytics_ssl_server":"https://player.ooyala.com","api_server":"http://player.ooyala.com","api_ssl_server":"https://player.ooyala.com","auth_server":"http://player.ooyala.com/sas","auth_ssl_server":"https://player.ooyala.com/sas","backlot_api_server":"cdn-api.ooyala.com","branding":{"accent_color":16777215,"text_color":16777215},"canary":false,"core_version":3,"debug":true,"environment":"production","flash_performance":false,"module_params":{"base":{"wm_h_inset":"0","wm_image_url":"http://csg-eng.ooyala.com:8081/wikia/Powered-by-Ooyala.png","wm_opacity":"50","wm_v_inset":"0"},"modules":{"cue-point-ui":{"metadata":{"placeHolderUrl":""},"mjolnir_plugin":"","type":"cue-point-ui"}}},"pcode":"J0MTUxOtPDJVNZastij14_v7VDRS","platform":"html5-priority","playerBrandingId":"52bc289bedc847e3aa8eb2b347644f68","request_url":"http://player.ooyala.com/v3/52bc289bedc847e3aa8eb2b347644f68?platform=html5-priority\u0026debug=1","use_asp_flash_route":false,"v3_version":"b5f3533045aa845e5bdf4488cd722df4e30387a5","v3_version_source":"default","vast_proxy_url":"http://player.ooyala.com/adinsertion/vast_proxy"};
  OO.publicApi = OO.publicApi || {};

  // used for inserting player_params in dev harness version
  // please don't remove
  // the corresponding insertion code is found at start.js

  /*INSERT_PLAYER_PARAMS*/
  OO.playerParams = OO.playerParams || {};

  OO.log = function() {
    if (typeof(window.console) != "undefined" && typeof(window.console.log) == "function") {
      if(OO.playerParams.debug) {
        window.console.log.apply(window.console, arguments);
      }
    }
  };

  // Compatibility for browsers without native JSON library (IE)
  if(!window.JSON) {
    window.JSON = {
        stringify: function(obj) {return '<object>';},
        __end_marker: true
    };
  }

  // Compatibility for browsers without native Array.prototype.indexOf (IE..)
  if(!Array.prototype.indexOf) {
    Array.prototype.indexOf = function(obj, start) {
      var i, j = this.length;
      for (i = (start || 0); i < j; i++) {
         if (this[i] === obj) { return i; }
      }
      return -1;
    };
  }

  // namespace resolution
  var namespace = OO.playerParams.namespace || 'OO'; // default namespace is OO
  // Check if there is any conflicts here. (If we load one version of player already.)
  if (window[namespace] && window[namespace].Player) {
    OO.log("PlayerV3 is loaded already!!!");
    if (window[namespace].REV != OO.publicApi.REV) {
      OO.log("there is a different VERSION loaded:", window[namespace].REV, OO.publicApi.REV);
    }
    throw "PlayerV3 already defined!!";
  }

  //we want to maintain a subset of the namespace so that OO.ready is available
  //as soon as this first script loads
  //do not clobber namespace.__static
  if (window[namespace] && window[namespace].__static) {
    OO.publicApi.__static = window[namespace].__static;
  } else {
    OO.publicApi.__static = {
      readyList:[],
      docReady: false,
      apiReady: false
   };
  }
  window[namespace] = OO.publicApi;
  window[namespace].__internal = OO;

  OO.isReady = function() {
    return OO.publicApi.__static.apiReady && OO.publicApi.__static.docReady;
  };

  OO.tryCallReady = function() {
    if (!OO.isReady()) { return;}
    while (OO.publicApi.__static.readyList.length > 0) {
      var fn = OO.publicApi.__static.readyList.pop();
      if (typeof fn === "function") {
        try {
          fn(OO.publicApi);
        } catch(e) {
          OO.log("Error executing ready function", e, e.stack);
        }
      }
    }
    return;
  };


/**
 * Wrapper function within which to create the player. This ensures the script has loaded and initialized.
 * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">HTML5, Flash</p><br/>
 *
 * @method ready
 * @memberOf OO
 */
  OO.publicApi.ready = function(fn) {
    OO.publicApi.__static.readyList.unshift(fn);
    OO.tryCallReady();
  };

  var curOO = OO;
  OO.publicApi.plugin = function(moduleName, moduleClassFactory) {
    // This is to make sure side load module will register to the correct canary code.
    if (curOO.isReady()) {
      OO.log("plugin is ready to register", curOO, moduleName);
      curOO.plugin(moduleName, moduleClassFactory);
    } else {
      OO.log("plugin", moduleName);
      // Make sure third party module is evaluated before normal ready callback.
      OO.publicApi.__static.readyList.push(function(ns){ ns.plugin(moduleName, moduleClassFactory); });
    }

  };
//     Underscore.js 1.3.3
//     (c) 2009-2012 Jeremy Ashkenas, DocumentCloud Inc.
//     Underscore is freely distributable under the MIT license.
//     Portions of Underscore are inspired or borrowed from Prototype,
//     Oliver Steele's Functional, and John Resig's Micro-Templating.
//     For all details and documentation:
//     http://documentcloud.github.com/underscore

(function() {

  // Baseline setup
  // --------------

  // Establish the root object, `window` in the browser, or `global` on the server.
  var root = this;

  // Save the previous value of the `_` variable.
  var previousUnderscore = root._;

  // Establish the object that gets returned to break out of a loop iteration.
  var breaker = {};

  // Save bytes in the minified (but not gzipped) version:
  var ArrayProto = Array.prototype, ObjProto = Object.prototype, FuncProto = Function.prototype;

  // Create quick reference variables for speed access to core prototypes.
  var slice            = ArrayProto.slice,
      unshift          = ArrayProto.unshift,
      toString         = ObjProto.toString,
      hasOwnProperty   = ObjProto.hasOwnProperty;

  // All **ECMAScript 5** native function implementations that we hope to use
  // are declared here.
  var
    nativeForEach      = ArrayProto.forEach,
    nativeMap          = ArrayProto.map,
    nativeReduce       = ArrayProto.reduce,
    nativeReduceRight  = ArrayProto.reduceRight,
    nativeFilter       = ArrayProto.filter,
    nativeEvery        = ArrayProto.every,
    nativeSome         = ArrayProto.some,
    nativeIndexOf      = ArrayProto.indexOf,
    nativeLastIndexOf  = ArrayProto.lastIndexOf,
    nativeIsArray      = Array.isArray,
    nativeKeys         = Object.keys,
    nativeBind         = FuncProto.bind;

  // Create a safe reference to the Underscore object for use below.
  var _ = function(obj) { return new wrapper(obj); };

  // Export the Underscore object for **Node.js**, with
  // backwards-compatibility for the old `require()` API. If we're in
  // the browser, add `_` as a global object via a string identifier,
  // for Closure Compiler "advanced" mode.
  if (typeof exports !== 'undefined') {
    if (typeof module !== 'undefined' && module.exports) {
      exports = module.exports = _;
    }
    exports._ = _;
  } else {
    root['_'] = _;
  }

  // Current version.
  _.VERSION = '1.3.3';

  // Collection Functions
  // --------------------

  // The cornerstone, an `each` implementation, aka `forEach`.
  // Handles objects with the built-in `forEach`, arrays, and raw objects.
  // Delegates to **ECMAScript 5**'s native `forEach` if available.
  var each = _.each = _.forEach = function(obj, iterator, context) {
    if (obj == null) return;
    if (nativeForEach && obj.forEach === nativeForEach) {
      obj.forEach(iterator, context);
    } else if (obj.length === +obj.length) {
      for (var i = 0, l = obj.length; i < l; i++) {
        if (i in obj && iterator.call(context, obj[i], i, obj) === breaker) return;
      }
    } else {
      for (var key in obj) {
        if (_.has(obj, key)) {
          if (iterator.call(context, obj[key], key, obj) === breaker) return;
        }
      }
    }
  };

  // Return the results of applying the iterator to each element.
  // Delegates to **ECMAScript 5**'s native `map` if available.
  _.map = _.collect = function(obj, iterator, context) {
    var results = [];
    if (obj == null) return results;
    if (nativeMap && obj.map === nativeMap) return obj.map(iterator, context);
    each(obj, function(value, index, list) {
      results[results.length] = iterator.call(context, value, index, list);
    });
    if (obj.length === +obj.length) results.length = obj.length;
    return results;
  };

  // **Reduce** builds up a single result from a list of values, aka `inject`,
  // or `foldl`. Delegates to **ECMAScript 5**'s native `reduce` if available.
  _.reduce = _.foldl = _.inject = function(obj, iterator, memo, context) {
    var initial = arguments.length > 2;
    if (obj == null) obj = [];
    if (nativeReduce && obj.reduce === nativeReduce) {
      if (context) iterator = _.bind(iterator, context);
      return initial ? obj.reduce(iterator, memo) : obj.reduce(iterator);
    }
    each(obj, function(value, index, list) {
      if (!initial) {
        memo = value;
        initial = true;
      } else {
        memo = iterator.call(context, memo, value, index, list);
      }
    });
    if (!initial) throw new TypeError('Reduce of empty array with no initial value');
    return memo;
  };

  // The right-associative version of reduce, also known as `foldr`.
  // Delegates to **ECMAScript 5**'s native `reduceRight` if available.
  _.reduceRight = _.foldr = function(obj, iterator, memo, context) {
    var initial = arguments.length > 2;
    if (obj == null) obj = [];
    if (nativeReduceRight && obj.reduceRight === nativeReduceRight) {
      if (context) iterator = _.bind(iterator, context);
      return initial ? obj.reduceRight(iterator, memo) : obj.reduceRight(iterator);
    }
    var reversed = _.toArray(obj).reverse();
    if (context && !initial) iterator = _.bind(iterator, context);
    return initial ? _.reduce(reversed, iterator, memo, context) : _.reduce(reversed, iterator);
  };

  // Return the first value which passes a truth test. Aliased as `detect`.
  _.find = _.detect = function(obj, iterator, context) {
    var result;
    any(obj, function(value, index, list) {
      if (iterator.call(context, value, index, list)) {
        result = value;
        return true;
      }
    });
    return result;
  };

  // Return all the elements that pass a truth test.
  // Delegates to **ECMAScript 5**'s native `filter` if available.
  // Aliased as `select`.
  _.filter = _.select = function(obj, iterator, context) {
    var results = [];
    if (obj == null) return results;
    if (nativeFilter && obj.filter === nativeFilter) return obj.filter(iterator, context);
    each(obj, function(value, index, list) {
      if (iterator.call(context, value, index, list)) results[results.length] = value;
    });
    return results;
  };

  // Return all the elements for which a truth test fails.
  _.reject = function(obj, iterator, context) {
    var results = [];
    if (obj == null) return results;
    each(obj, function(value, index, list) {
      if (!iterator.call(context, value, index, list)) results[results.length] = value;
    });
    return results;
  };

  // Determine whether all of the elements match a truth test.
  // Delegates to **ECMAScript 5**'s native `every` if available.
  // Aliased as `all`.
  _.every = _.all = function(obj, iterator, context) {
    var result = true;
    if (obj == null) return result;
    if (nativeEvery && obj.every === nativeEvery) return obj.every(iterator, context);
    each(obj, function(value, index, list) {
      if (!(result = result && iterator.call(context, value, index, list))) return breaker;
    });
    return !!result;
  };

  // Determine if at least one element in the object matches a truth test.
  // Delegates to **ECMAScript 5**'s native `some` if available.
  // Aliased as `any`.
  var any = _.some = _.any = function(obj, iterator, context) {
    iterator || (iterator = _.identity);
    var result = false;
    if (obj == null) return result;
    if (nativeSome && obj.some === nativeSome) return obj.some(iterator, context);
    each(obj, function(value, index, list) {
      if (result || (result = iterator.call(context, value, index, list))) return breaker;
    });
    return !!result;
  };

  // Determine if a given value is included in the array or object using `===`.
  // Aliased as `contains`.
  _.include = _.contains = function(obj, target) {
    var found = false;
    if (obj == null) return found;
    if (nativeIndexOf && obj.indexOf === nativeIndexOf) return obj.indexOf(target) != -1;
    found = any(obj, function(value) {
      return value === target;
    });
    return found;
  };

  // Invoke a method (with arguments) on every item in a collection.
  _.invoke = function(obj, method) {
    var args = slice.call(arguments, 2);
    return _.map(obj, function(value) {
      return (_.isFunction(method) ? method || value : value[method]).apply(value, args);
    });
  };

  // Convenience version of a common use case of `map`: fetching a property.
  _.pluck = function(obj, key) {
    return _.map(obj, function(value){ return value[key]; });
  };

  // Return the maximum element or (element-based computation).
  _.max = function(obj, iterator, context) {
    if (!iterator && _.isArray(obj) && obj[0] === +obj[0]) return Math.max.apply(Math, obj);
    if (!iterator && _.isEmpty(obj)) return -Infinity;
    var result = {computed : -Infinity};
    each(obj, function(value, index, list) {
      var computed = iterator ? iterator.call(context, value, index, list) : value;
      computed >= result.computed && (result = {value : value, computed : computed});
    });
    return result.value;
  };

  // Return the minimum element (or element-based computation).
  _.min = function(obj, iterator, context) {
    if (!iterator && _.isArray(obj) && obj[0] === +obj[0]) return Math.min.apply(Math, obj);
    if (!iterator && _.isEmpty(obj)) return Infinity;
    var result = {computed : Infinity};
    each(obj, function(value, index, list) {
      var computed = iterator ? iterator.call(context, value, index, list) : value;
      computed < result.computed && (result = {value : value, computed : computed});
    });
    return result.value;
  };

  // Shuffle an array.
  _.shuffle = function(obj) {
    var shuffled = [], rand;
    each(obj, function(value, index, list) {
      rand = Math.floor(Math.random() * (index + 1));
      shuffled[index] = shuffled[rand];
      shuffled[rand] = value;
    });
    return shuffled;
  };

  // Sort the object's values by a criterion produced by an iterator.
  _.sortBy = function(obj, val, context) {
    var iterator = _.isFunction(val) ? val : function(obj) { return obj[val]; };
    return _.pluck(_.map(obj, function(value, index, list) {
      return {
        value : value,
        criteria : iterator.call(context, value, index, list)
      };
    }).sort(function(left, right) {
      var a = left.criteria, b = right.criteria;
      if (a === void 0) return 1;
      if (b === void 0) return -1;
      return a < b ? -1 : a > b ? 1 : 0;
    }), 'value');
  };

  // Groups the object's values by a criterion. Pass either a string attribute
  // to group by, or a function that returns the criterion.
  _.groupBy = function(obj, val) {
    var result = {};
    var iterator = _.isFunction(val) ? val : function(obj) { return obj[val]; };
    each(obj, function(value, index) {
      var key = iterator(value, index);
      (result[key] || (result[key] = [])).push(value);
    });
    return result;
  };

  // Use a comparator function to figure out at what index an object should
  // be inserted so as to maintain order. Uses binary search.
  _.sortedIndex = function(array, obj, iterator) {
    iterator || (iterator = _.identity);
    var low = 0, high = array.length;
    while (low < high) {
      var mid = (low + high) >> 1;
      iterator(array[mid]) < iterator(obj) ? low = mid + 1 : high = mid;
    }
    return low;
  };

  // Safely convert anything iterable into a real, live array.
  _.toArray = function(obj) {
    if (!obj)                                     return [];
    if (_.isArray(obj))                           return slice.call(obj);
    if (_.isArguments(obj))                       return slice.call(obj);
    if (obj.toArray && _.isFunction(obj.toArray)) return obj.toArray();
    return _.values(obj);
  };

  // Return the number of elements in an object.
  _.size = function(obj) {
    return _.isArray(obj) ? obj.length : _.keys(obj).length;
  };

  // Array Functions
  // ---------------

  // Get the first element of an array. Passing **n** will return the first N
  // values in the array. Aliased as `head` and `take`. The **guard** check
  // allows it to work with `_.map`.
  _.first = _.head = _.take = function(array, n, guard) {
    return (n != null) && !guard ? slice.call(array, 0, n) : array[0];
  };

  // Returns everything but the last entry of the array. Especcialy useful on
  // the arguments object. Passing **n** will return all the values in
  // the array, excluding the last N. The **guard** check allows it to work with
  // `_.map`.
  _.initial = function(array, n, guard) {
    return slice.call(array, 0, array.length - ((n == null) || guard ? 1 : n));
  };

  // Get the last element of an array. Passing **n** will return the last N
  // values in the array. The **guard** check allows it to work with `_.map`.
  _.last = function(array, n, guard) {
    if ((n != null) && !guard) {
      return slice.call(array, Math.max(array.length - n, 0));
    } else {
      return array[array.length - 1];
    }
  };

  // Returns everything but the first entry of the array. Aliased as `tail`.
  // Especially useful on the arguments object. Passing an **index** will return
  // the rest of the values in the array from that index onward. The **guard**
  // check allows it to work with `_.map`.
  _.rest = _.tail = function(array, index, guard) {
    return slice.call(array, (index == null) || guard ? 1 : index);
  };

  // Trim out all falsy values from an array.
  _.compact = function(array) {
    return _.filter(array, function(value){ return !!value; });
  };

  // Return a completely flattened version of an array.
  _.flatten = function(array, shallow) {
    return _.reduce(array, function(memo, value) {
      if (_.isArray(value)) return memo.concat(shallow ? value : _.flatten(value));
      memo[memo.length] = value;
      return memo;
    }, []);
  };

  // Return a version of the array that does not contain the specified value(s).
  _.without = function(array) {
    return _.difference(array, slice.call(arguments, 1));
  };

  // Produce a duplicate-free version of the array. If the array has already
  // been sorted, you have the option of using a faster algorithm.
  // Aliased as `unique`.
  _.uniq = _.unique = function(array, isSorted, iterator) {
    var initial = iterator ? _.map(array, iterator) : array;
    var results = [];
    // The `isSorted` flag is irrelevant if the array only contains two elements.
    if (array.length < 3) isSorted = true;
    _.reduce(initial, function (memo, value, index) {
      if (isSorted ? _.last(memo) !== value || !memo.length : !_.include(memo, value)) {
        memo.push(value);
        results.push(array[index]);
      }
      return memo;
    }, []);
    return results;
  };

  // Produce an array that contains the union: each distinct element from all of
  // the passed-in arrays.
  _.union = function() {
    return _.uniq(_.flatten(arguments, true));
  };

  // Produce an array that contains every item shared between all the
  // passed-in arrays. (Aliased as "intersect" for back-compat.)
  _.intersection = _.intersect = function(array) {
    var rest = slice.call(arguments, 1);
    return _.filter(_.uniq(array), function(item) {
      return _.every(rest, function(other) {
        return _.indexOf(other, item) >= 0;
      });
    });
  };

  // Take the difference between one array and a number of other arrays.
  // Only the elements present in just the first array will remain.
  _.difference = function(array) {
    var rest = _.flatten(slice.call(arguments, 1), true);
    return _.filter(array, function(value){ return !_.include(rest, value); });
  };

  // Zip together multiple lists into a single array -- elements that share
  // an index go together.
  _.zip = function() {
    var args = slice.call(arguments);
    var length = _.max(_.pluck(args, 'length'));
    var results = new Array(length);
    for (var i = 0; i < length; i++) results[i] = _.pluck(args, "" + i);
    return results;
  };

  // If the browser doesn't supply us with indexOf (I'm looking at you, **MSIE**),
  // we need this function. Return the position of the first occurrence of an
  // item in an array, or -1 if the item is not included in the array.
  // Delegates to **ECMAScript 5**'s native `indexOf` if available.
  // If the array is large and already in sort order, pass `true`
  // for **isSorted** to use binary search.
  _.indexOf = function(array, item, isSorted) {
    if (array == null) return -1;
    var i, l;
    if (isSorted) {
      i = _.sortedIndex(array, item);
      return array[i] === item ? i : -1;
    }
    if (nativeIndexOf && array.indexOf === nativeIndexOf) return array.indexOf(item);
    for (i = 0, l = array.length; i < l; i++) if (i in array && array[i] === item) return i;
    return -1;
  };

  // Delegates to **ECMAScript 5**'s native `lastIndexOf` if available.
  _.lastIndexOf = function(array, item) {
    if (array == null) return -1;
    if (nativeLastIndexOf && array.lastIndexOf === nativeLastIndexOf) return array.lastIndexOf(item);
    var i = array.length;
    while (i--) if (i in array && array[i] === item) return i;
    return -1;
  };

  // Generate an integer Array containing an arithmetic progression. A port of
  // the native Python `range()` function. See
  // [the Python documentation](http://docs.python.org/library/functions.html#range).
  _.range = function(start, stop, step) {
    if (arguments.length <= 1) {
      stop = start || 0;
      start = 0;
    }
    step = arguments[2] || 1;

    var len = Math.max(Math.ceil((stop - start) / step), 0);
    var idx = 0;
    var range = new Array(len);

    while(idx < len) {
      range[idx++] = start;
      start += step;
    }

    return range;
  };

  // Function (ahem) Functions
  // ------------------

  // Reusable constructor function for prototype setting.
  var ctor = function(){};

  // Create a function bound to a given object (assigning `this`, and arguments,
  // optionally). Binding with arguments is also known as `curry`.
  // Delegates to **ECMAScript 5**'s native `Function.bind` if available.
  // We check for `func.bind` first, to fail fast when `func` is undefined.
  _.bind = function bind(func, context) {
    var bound, args;
    if (func.bind === nativeBind && nativeBind) return nativeBind.apply(func, slice.call(arguments, 1));
    if (!_.isFunction(func)) throw new TypeError;
    args = slice.call(arguments, 2);
    return bound = function() {
      if (!(this instanceof bound)) return func.apply(context, args.concat(slice.call(arguments)));
      ctor.prototype = func.prototype;
      var self = new ctor;
      var result = func.apply(self, args.concat(slice.call(arguments)));
      if (Object(result) === result) return result;
      return self;
    };
  };

  // Bind all of an object's methods to that object. Useful for ensuring that
  // all callbacks defined on an object belong to it.
  _.bindAll = function(obj) {
    var funcs = slice.call(arguments, 1);
    if (funcs.length == 0) funcs = _.functions(obj);
    each(funcs, function(f) { obj[f] = _.bind(obj[f], obj); });
    return obj;
  };

  // Memoize an expensive function by storing its results.
  _.memoize = function(func, hasher) {
    var memo = {};
    hasher || (hasher = _.identity);
    return function() {
      var key = hasher.apply(this, arguments);
      return _.has(memo, key) ? memo[key] : (memo[key] = func.apply(this, arguments));
    };
  };

  // Delays a function for the given number of milliseconds, and then calls
  // it with the arguments supplied.
  _.delay = function(func, wait) {
    var args = slice.call(arguments, 2);
    return setTimeout(function(){ return func.apply(null, args); }, wait);
  };

  // Defers a function, scheduling it to run after the current call stack has
  // cleared.
  _.defer = function(func) {
    return _.delay.apply(_, [func, 1].concat(slice.call(arguments, 1)));
  };

  // Returns a function, that, when invoked, will only be triggered at most once
  // during a given window of time.
  _.throttle = function(func, wait) {
    var context, args, timeout, throttling, more, result;
    var whenDone = _.debounce(function(){ more = throttling = false; }, wait);
    return function() {
      context = this; args = arguments;
      var later = function() {
        timeout = null;
        if (more) func.apply(context, args);
        whenDone();
      };
      if (!timeout) timeout = setTimeout(later, wait);
      if (throttling) {
        more = true;
      } else {
        result = func.apply(context, args);
      }
      whenDone();
      throttling = true;
      return result;
    };
  };

  // Returns a function, that, as long as it continues to be invoked, will not
  // be triggered. The function will be called after it stops being called for
  // N milliseconds. If `immediate` is passed, trigger the function on the
  // leading edge, instead of the trailing.
  _.debounce = function(func, wait, immediate) {
    var timeout;
    return function() {
      var context = this, args = arguments;
      var later = function() {
        timeout = null;
        if (!immediate) func.apply(context, args);
      };
      if (immediate && !timeout) func.apply(context, args);
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
    };
  };

  // Returns a function that will be executed at most one time, no matter how
  // often you call it. Useful for lazy initialization.
  _.once = function(func) {
    var ran = false, memo;
    return function() {
      if (ran) return memo;
      ran = true;
      return memo = func.apply(this, arguments);
    };
  };

  // Returns the first function passed as an argument to the second,
  // allowing you to adjust arguments, run code before and after, and
  // conditionally execute the original function.
  _.wrap = function(func, wrapper) {
    return function() {
      var args = [func].concat(slice.call(arguments, 0));
      return wrapper.apply(this, args);
    };
  };

  // Returns a function that is the composition of a list of functions, each
  // consuming the return value of the function that follows.
  _.compose = function() {
    var funcs = arguments;
    return function() {
      var args = arguments;
      for (var i = funcs.length - 1; i >= 0; i--) {
        args = [funcs[i].apply(this, args)];
      }
      return args[0];
    };
  };

  // Returns a function that will only be executed after being called N times.
  _.after = function(times, func) {
    if (times <= 0) return func();
    return function() {
      if (--times < 1) { return func.apply(this, arguments); }
    };
  };

  // Object Functions
  // ----------------

  // Retrieve the names of an object's properties.
  // Delegates to **ECMAScript 5**'s native `Object.keys`
  _.keys = nativeKeys || function(obj) {
    if (obj !== Object(obj)) throw new TypeError('Invalid object');
    var keys = [];
    for (var key in obj) if (_.has(obj, key)) keys[keys.length] = key;
    return keys;
  };

  // Retrieve the values of an object's properties.
  _.values = function(obj) {
    return _.map(obj, _.identity);
  };

  // Return a sorted list of the function names available on the object.
  // Aliased as `methods`
  _.functions = _.methods = function(obj) {
    var names = [];
    for (var key in obj) {
      if (_.isFunction(obj[key])) names.push(key);
    }
    return names.sort();
  };

  // Extend a given object with all the properties in passed-in object(s).
  _.extend = function(obj) {
    each(slice.call(arguments, 1), function(source) {
      for (var prop in source) {
        obj[prop] = source[prop];
      }
    });
    return obj;
  };

  // Return a copy of the object only containing the whitelisted properties.
  _.pick = function(obj) {
    var result = {};
    each(_.flatten(slice.call(arguments, 1)), function(key) {
      if (key in obj) result[key] = obj[key];
    });
    return result;
  };

  // Fill in a given object with default properties.
  _.defaults = function(obj) {
    each(slice.call(arguments, 1), function(source) {
      for (var prop in source) {
        if (obj[prop] == null) obj[prop] = source[prop];
      }
    });
    return obj;
  };

  // Create a (shallow-cloned) duplicate of an object.
  _.clone = function(obj) {
    if (!_.isObject(obj)) return obj;
    return _.isArray(obj) ? obj.slice() : _.extend({}, obj);
  };

  // Invokes interceptor with the obj, and then returns obj.
  // The primary purpose of this method is to "tap into" a method chain, in
  // order to perform operations on intermediate results within the chain.
  _.tap = function(obj, interceptor) {
    interceptor(obj);
    return obj;
  };

  // Internal recursive comparison function.
  function eq(a, b, stack) {
    // Identical objects are equal. `0 === -0`, but they aren't identical.
    // See the Harmony `egal` proposal: http://wiki.ecmascript.org/doku.php?id=harmony:egal.
    if (a === b) return a !== 0 || 1 / a == 1 / b;
    // A strict comparison is necessary because `null == undefined`.
    if (a == null || b == null) return a === b;
    // Unwrap any wrapped objects.
    if (a._chain) a = a._wrapped;
    if (b._chain) b = b._wrapped;
    // Invoke a custom `isEqual` method if one is provided.
    if (a.isEqual && _.isFunction(a.isEqual)) return a.isEqual(b);
    if (b.isEqual && _.isFunction(b.isEqual)) return b.isEqual(a);
    // Compare `[[Class]]` names.
    var className = toString.call(a);
    if (className != toString.call(b)) return false;
    switch (className) {
      // Strings, numbers, dates, and booleans are compared by value.
      case '[object String]':
        // Primitives and their corresponding object wrappers are equivalent; thus, `"5"` is
        // equivalent to `new String("5")`.
        return a == String(b);
      case '[object Number]':
        // `NaN`s are equivalent, but non-reflexive. An `egal` comparison is performed for
        // other numeric values.
        return a != +a ? b != +b : (a == 0 ? 1 / a == 1 / b : a == +b);
      case '[object Date]':
      case '[object Boolean]':
        // Coerce dates and booleans to numeric primitive values. Dates are compared by their
        // millisecond representations. Note that invalid dates with millisecond representations
        // of `NaN` are not equivalent.
        return +a == +b;
      // RegExps are compared by their source patterns and flags.
      case '[object RegExp]':
        return a.source == b.source &&
               a.global == b.global &&
               a.multiline == b.multiline &&
               a.ignoreCase == b.ignoreCase;
    }
    if (typeof a != 'object' || typeof b != 'object') return false;
    // Assume equality for cyclic structures. The algorithm for detecting cyclic
    // structures is adapted from ES 5.1 section 15.12.3, abstract operation `JO`.
    var length = stack.length;
    while (length--) {
      // Linear search. Performance is inversely proportional to the number of
      // unique nested structures.
      if (stack[length] == a) return true;
    }
    // Add the first object to the stack of traversed objects.
    stack.push(a);
    var size = 0, result = true;
    // Recursively compare objects and arrays.
    if (className == '[object Array]') {
      // Compare array lengths to determine if a deep comparison is necessary.
      size = a.length;
      result = size == b.length;
      if (result) {
        // Deep compare the contents, ignoring non-numeric properties.
        while (size--) {
          // Ensure commutative equality for sparse arrays.
          if (!(result = size in a == size in b && eq(a[size], b[size], stack))) break;
        }
      }
    } else {
      // Objects with different constructors are not equivalent.
      if ('constructor' in a != 'constructor' in b || a.constructor != b.constructor) return false;
      // Deep compare objects.
      for (var key in a) {
        if (_.has(a, key)) {
          // Count the expected number of properties.
          size++;
          // Deep compare each member.
          if (!(result = _.has(b, key) && eq(a[key], b[key], stack))) break;
        }
      }
      // Ensure that both objects contain the same number of properties.
      if (result) {
        for (key in b) {
          if (_.has(b, key) && !(size--)) break;
        }
        result = !size;
      }
    }
    // Remove the first object from the stack of traversed objects.
    stack.pop();
    return result;
  }

  // Perform a deep comparison to check if two objects are equal.
  _.isEqual = function(a, b) {
    return eq(a, b, []);
  };

  // Is a given array, string, or object empty?
  // An "empty" object has no enumerable own-properties.
  _.isEmpty = function(obj) {
    if (obj == null) return true;
    if (_.isArray(obj) || _.isString(obj)) return obj.length === 0;
    for (var key in obj) if (_.has(obj, key)) return false;
    return true;
  };

  // Is a given value a DOM element?
  _.isElement = function(obj) {
    return !!(obj && obj.nodeType == 1);
  };

  // Is a given value an array?
  // Delegates to ECMA5's native Array.isArray
  _.isArray = nativeIsArray || function(obj) {
    return toString.call(obj) == '[object Array]';
  };

  // Is a given variable an object?
  _.isObject = function(obj) {
    return obj === Object(obj);
  };

  // Is a given variable an arguments object?
  _.isArguments = function(obj) {
    return toString.call(obj) == '[object Arguments]';
  };
  if (!_.isArguments(arguments)) {
    _.isArguments = function(obj) {
      return !!(obj && _.has(obj, 'callee'));
    };
  }

  // Is a given value a function?
  _.isFunction = function(obj) {
    return toString.call(obj) == '[object Function]';
  };

  // Is a given value a string?
  _.isString = function(obj) {
    return toString.call(obj) == '[object String]';
  };

  // Is a given value a number?
  _.isNumber = function(obj) {
    return toString.call(obj) == '[object Number]';
  };

  // Is a given object a finite number?
  _.isFinite = function(obj) {
    return _.isNumber(obj) && isFinite(obj);
  };

  // Is the given value `NaN`?
  _.isNaN = function(obj) {
    // `NaN` is the only value for which `===` is not reflexive.
    return obj !== obj;
  };

  // Is a given value a boolean?
  _.isBoolean = function(obj) {
    return obj === true || obj === false || toString.call(obj) == '[object Boolean]';
  };

  // Is a given value a date?
  _.isDate = function(obj) {
    return toString.call(obj) == '[object Date]';
  };

  // Is the given value a regular expression?
  _.isRegExp = function(obj) {
    return toString.call(obj) == '[object RegExp]';
  };

  // Is a given value equal to null?
  _.isNull = function(obj) {
    return obj === null;
  };

  // Is a given variable undefined?
  _.isUndefined = function(obj) {
    return obj === void 0;
  };

  // Has own property?
  _.has = function(obj, key) {
    // Original Underscore Code
    //return hasOwnProperty.call(obj, key);

    // Replacement code (the reason for this is that IE<9 don't define hasOwnProperty on DOM nodes)
    if(typeof (obj.hasOwnProperty) === "function") {
      return obj.hasOwnProperty(key);
    } else {
      return !(typeof (obj[key]) === undefined);
    }
  };

  // Utility Functions
  // -----------------

  // Run Underscore.js in *noConflict* mode, returning the `_` variable to its
  // previous owner. Returns a reference to the Underscore object.
  _.noConflict = function() {
    root._ = previousUnderscore;
    return this;
  };

  // Keep the identity function around for default iterators.
  _.identity = function(value) {
    return value;
  };

  // Run a function **n** times.
  _.times = function (n, iterator, context) {
    for (var i = 0; i < n; i++) iterator.call(context, i);
  };

  // Escape a string for HTML interpolation.
  _.escape = function(string) {
    return (''+string).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#x27;').replace(/\//g,'&#x2F;');
  };

  // If the value of the named property is a function then invoke it;
  // otherwise, return it.
  _.result = function(object, property) {
    if (object == null) return null;
    var value = object[property];
    return _.isFunction(value) ? value.call(object) : value;
  };

  // Add your own custom functions to the Underscore object, ensuring that
  // they're correctly added to the OOP wrapper as well.
  _.mixin = function(obj) {
    each(_.functions(obj), function(name){
      addToWrapper(name, _[name] = obj[name]);
    });
  };

  // Generate a unique integer id (unique within the entire client session).
  // Useful for temporary DOM ids.
  var idCounter = 0;
  _.uniqueId = function(prefix) {
    var id = idCounter++;
    return prefix ? prefix + id : id;
  };

  // By default, Underscore uses ERB-style template delimiters, change the
  // following template settings to use alternative delimiters.
  _.templateSettings = {
    evaluate    : /<%([\s\S]+?)%>/g,
    interpolate : /<%=([\s\S]+?)%>/g,
    escape      : /<%-([\s\S]+?)%>/g
  };

  // When customizing `templateSettings`, if you don't want to define an
  // interpolation, evaluation or escaping regex, we need one that is
  // guaranteed not to match.
  var noMatch = /.^/;

  // Certain characters need to be escaped so that they can be put into a
  // string literal.
  var escapes = {
    '\\': '\\',
    "'": "'",
    'r': '\r',
    'n': '\n',
    't': '\t',
    'u2028': '\u2028',
    'u2029': '\u2029'
  };

  for (var p in escapes) escapes[escapes[p]] = p;
  var escaper = /\\|'|\r|\n|\t|\u2028|\u2029/g;
  var unescaper = /\\(\\|'|r|n|t|u2028|u2029)/g;

  // Within an interpolation, evaluation, or escaping, remove HTML escaping
  // that had been previously added.
  var unescape = function(code) {
    return code.replace(unescaper, function(match, escape) {
      return escapes[escape];
    });
  };

  // JavaScript micro-templating, similar to John Resig's implementation.
  // Underscore templating handles arbitrary delimiters, preserves whitespace,
  // and correctly escapes quotes within interpolated code.
  _.template = function(text, data, settings) {
    settings = _.defaults(settings || {}, _.templateSettings);

    // Compile the template source, taking care to escape characters that
    // cannot be included in a string literal and then unescape them in code
    // blocks.
    var source = "__p+='" + text
      .replace(escaper, function(match) {
        return '\\' + escapes[match];
      })
      .replace(settings.escape || noMatch, function(match, code) {
        return "'+\n_.escape(" + unescape(code) + ")+\n'";
      })
      .replace(settings.interpolate || noMatch, function(match, code) {
        return "'+\n(" + unescape(code) + ")+\n'";
      })
      .replace(settings.evaluate || noMatch, function(match, code) {
        return "';\n" + unescape(code) + "\n;__p+='";
      }) + "';\n";

    // If a variable is not specified, place data values in local scope.
    if (!settings.variable) source = 'with(obj||{}){\n' + source + '}\n';

    source = "var __p='';" +
      "var print=function(){__p+=Array.prototype.join.call(arguments, '')};\n" +
      source + "return __p;\n";

    var render = new Function(settings.variable || 'obj', '_', source);
    if (data) return render(data, _);
    var template = function(data) {
      return render.call(this, data, _);
    };

    // Provide the compiled function source as a convenience for build time
    // precompilation.
    template.source = 'function(' + (settings.variable || 'obj') + '){\n' +
      source + '}';

    return template;
  };

  // Add a "chain" function, which will delegate to the wrapper.
  _.chain = function(obj) {
    return _(obj).chain();
  };

  // The OOP Wrapper
  // ---------------

  // If Underscore is called as a function, it returns a wrapped object that
  // can be used OO-style. This wrapper holds altered versions of all the
  // underscore functions. Wrapped objects may be chained.
  var wrapper = function(obj) { this._wrapped = obj; };

  // Expose `wrapper.prototype` as `_.prototype`
  _.prototype = wrapper.prototype;

  // Helper function to continue chaining intermediate results.
  var result = function(obj, chain) {
    return chain ? _(obj).chain() : obj;
  };

  // A method to easily add functions to the OOP wrapper.
  var addToWrapper = function(name, func) {
    wrapper.prototype[name] = function() {
      var args = slice.call(arguments);
      unshift.call(args, this._wrapped);
      return result(func.apply(_, args), this._chain);
    };
  };

  // Add all of the Underscore functions to the wrapper object.
  _.mixin(_);

  // Add all mutator Array functions to the wrapper.
  each(['pop', 'push', 'reverse', 'shift', 'sort', 'splice', 'unshift'], function(name) {
    var method = ArrayProto[name];
    wrapper.prototype[name] = function() {
      var wrapped = this._wrapped;
      method.apply(wrapped, arguments);
      var length = wrapped.length;
      if ((name == 'shift' || name == 'splice') && length === 0) delete wrapped[0];
      return result(wrapped, this._chain);
    };
  });

  // Add all accessor Array functions to the wrapper.
  each(['concat', 'join', 'slice'], function(name) {
    var method = ArrayProto[name];
    wrapper.prototype[name] = function() {
      return result(method.apply(this._wrapped, arguments), this._chain);
    };
  });

  // Start chaining a wrapped Underscore object.
  wrapper.prototype.chain = function() {
    this._chain = true;
    return this;
  };

  // Extracts the result from a wrapped and chained object.
  wrapper.prototype.value = function() {
    return this._wrapped;
  };

}).call(this);
/*!
 * jQuery JavaScript Library v1.8.3
 * http://jquery.com/
 *
 * Includes Sizzle.js
 * http://sizzlejs.com/
 *
 * Copyright 2012 jQuery Foundation and other contributors
 * Released under the MIT license
 * http://jquery.org/license
 *
 * Date: Tue Nov 13 2012 08:20:33 GMT-0500 (Eastern Standard Time)
 */
(function( window, undefined ) {
var
	// A central reference to the root jQuery(document)
	rootjQuery,

	// The deferred used on DOM ready
	readyList,

	// Use the correct document accordingly with window argument (sandbox)
	document = window.document,
	location = window.location,
	navigator = window.navigator,

	// Map over jQuery in case of overwrite
	_jQuery = window.jQuery,

	// Map over the $ in case of overwrite
	_$ = window.$,

	// Save a reference to some core methods
	core_push = Array.prototype.push,
	core_slice = Array.prototype.slice,
	core_indexOf = Array.prototype.indexOf,
	core_toString = Object.prototype.toString,
	core_hasOwn = Object.prototype.hasOwnProperty,
	core_trim = String.prototype.trim,

	// Define a local copy of jQuery
	jQuery = function( selector, context ) {
		// The jQuery object is actually just the init constructor 'enhanced'
		return new jQuery.fn.init( selector, context, rootjQuery );
	},

	// Used for matching numbers
	core_pnum = /[\-+]?(?:\d*\.|)\d+(?:[eE][\-+]?\d+|)/.source,

	// Used for detecting and trimming whitespace
	core_rnotwhite = /\S/,
	core_rspace = /\s+/,

	// Make sure we trim BOM and NBSP (here's looking at you, Safari 5.0 and IE)
	rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,

	// A simple way to check for HTML strings
	// Prioritize #id over <tag> to avoid XSS via location.hash (#9521)
	rquickExpr = /^(?:[^#<]*(<[\w\W]+>)[^>]*$|#([\w\-]*)$)/,

	// Match a standalone tag
	rsingleTag = /^<(\w+)\s*\/?>(?:<\/\1>|)$/,

	// JSON RegExp
	rvalidchars = /^[\],:{}\s]*$/,
	rvalidbraces = /(?:^|:|,)(?:\s*\[)+/g,
	rvalidescape = /\\(?:["\\\/bfnrt]|u[\da-fA-F]{4})/g,
	rvalidtokens = /"[^"\\\r\n]*"|true|false|null|-?(?:\d\d*\.|)\d+(?:[eE][\-+]?\d+|)/g,

	// Matches dashed string for camelizing
	rmsPrefix = /^-ms-/,
	rdashAlpha = /-([\da-z])/gi,

	// Used by jQuery.camelCase as callback to replace()
	fcamelCase = function( all, letter ) {
		return ( letter + "" ).toUpperCase();
	},

	// The ready event handler and self cleanup method
	DOMContentLoaded = function() {
		if ( document.addEventListener ) {
			document.removeEventListener( "DOMContentLoaded", DOMContentLoaded, false );
			jQuery.ready();
		} else if ( document.readyState === "complete" ) {
			// we're here because readyState === "complete" in oldIE
			// which is good enough for us to call the dom ready!
			document.detachEvent( "onreadystatechange", DOMContentLoaded );
			jQuery.ready();
		}
	},

	// [[Class]] -> type pairs
	class2type = {};

jQuery.fn = jQuery.prototype = {
	constructor: jQuery,
	init: function( selector, context, rootjQuery ) {
		var match, elem, ret, doc;

		// Handle $(""), $(null), $(undefined), $(false)
		if ( !selector ) {
			return this;
		}

		// Handle $(DOMElement)
		if ( selector.nodeType ) {
			this.context = this[0] = selector;
			this.length = 1;
			return this;
		}

		// Handle HTML strings
		if ( typeof selector === "string" ) {
			if ( selector.charAt(0) === "<" && selector.charAt( selector.length - 1 ) === ">" && selector.length >= 3 ) {
				// Assume that strings that start and end with <> are HTML and skip the regex check
				match = [ null, selector, null ];

			} else {
				match = rquickExpr.exec( selector );
			}

			// Match html or make sure no context is specified for #id
			if ( match && (match[1] || !context) ) {

				// HANDLE: $(html) -> $(array)
				if ( match[1] ) {
					context = context instanceof jQuery ? context[0] : context;
					doc = ( context && context.nodeType ? context.ownerDocument || context : document );

					// scripts is true for back-compat
					selector = jQuery.parseHTML( match[1], doc, true );
					if ( rsingleTag.test( match[1] ) && jQuery.isPlainObject( context ) ) {
						this.attr.call( selector, context, true );
					}

					return jQuery.merge( this, selector );

				// HANDLE: $(#id)
				} else {
					elem = document.getElementById( match[2] );

					// Check parentNode to catch when Blackberry 4.6 returns
					// nodes that are no longer in the document #6963
					if ( elem && elem.parentNode ) {
						// Handle the case where IE and Opera return items
						// by name instead of ID
						if ( elem.id !== match[2] ) {
							return rootjQuery.find( selector );
						}

						// Otherwise, we inject the element directly into the jQuery object
						this.length = 1;
						this[0] = elem;
					}

					this.context = document;
					this.selector = selector;
					return this;
				}

			// HANDLE: $(expr, $(...))
			} else if ( !context || context.jquery ) {
				return ( context || rootjQuery ).find( selector );

			// HANDLE: $(expr, context)
			// (which is just equivalent to: $(context).find(expr)
			} else {
				return this.constructor( context ).find( selector );
			}

		// HANDLE: $(function)
		// Shortcut for document ready
		} else if ( jQuery.isFunction( selector ) ) {
			return rootjQuery.ready( selector );
		}

		if ( selector.selector !== undefined ) {
			this.selector = selector.selector;
			this.context = selector.context;
		}

		return jQuery.makeArray( selector, this );
	},

	// Start with an empty selector
	selector: "",

	// The current version of jQuery being used
	jquery: "1.8.3",

	// The default length of a jQuery object is 0
	length: 0,

	// The number of elements contained in the matched element set
	size: function() {
		return this.length;
	},

	toArray: function() {
		return core_slice.call( this );
	},

	// Get the Nth element in the matched element set OR
	// Get the whole matched element set as a clean array
	get: function( num ) {
		return num == null ?

			// Return a 'clean' array
			this.toArray() :

			// Return just the object
			( num < 0 ? this[ this.length + num ] : this[ num ] );
	},

	// Take an array of elements and push it onto the stack
	// (returning the new matched element set)
	pushStack: function( elems, name, selector ) {

		// Build a new jQuery matched element set
		var ret = jQuery.merge( this.constructor(), elems );

		// Add the old object onto the stack (as a reference)
		ret.prevObject = this;

		ret.context = this.context;

		if ( name === "find" ) {
			ret.selector = this.selector + ( this.selector ? " " : "" ) + selector;
		} else if ( name ) {
			ret.selector = this.selector + "." + name + "(" + selector + ")";
		}

		// Return the newly-formed element set
		return ret;
	},

	// Execute a callback for every element in the matched set.
	// (You can seed the arguments with an array of args, but this is
	// only used internally.)
	each: function( callback, args ) {
		return jQuery.each( this, callback, args );
	},

	ready: function( fn ) {
		// Add the callback
		jQuery.ready.promise().done( fn );

		return this;
	},

	eq: function( i ) {
		i = +i;
		return i === -1 ?
			this.slice( i ) :
			this.slice( i, i + 1 );
	},

	first: function() {
		return this.eq( 0 );
	},

	last: function() {
		return this.eq( -1 );
	},

	slice: function() {
		return this.pushStack( core_slice.apply( this, arguments ),
			"slice", core_slice.call(arguments).join(",") );
	},

	map: function( callback ) {
		return this.pushStack( jQuery.map(this, function( elem, i ) {
			return callback.call( elem, i, elem );
		}));
	},

	end: function() {
		return this.prevObject || this.constructor(null);
	},

	// For internal use only.
	// Behaves like an Array's method, not like a jQuery method.
	push: core_push,
	sort: [].sort,
	splice: [].splice
};

// Give the init function the jQuery prototype for later instantiation
jQuery.fn.init.prototype = jQuery.fn;

jQuery.extend = jQuery.fn.extend = function() {
	var options, name, src, copy, copyIsArray, clone,
		target = arguments[0] || {},
		i = 1,
		length = arguments.length,
		deep = false;

	// Handle a deep copy situation
	if ( typeof target === "boolean" ) {
		deep = target;
		target = arguments[1] || {};
		// skip the boolean and the target
		i = 2;
	}

	// Handle case when target is a string or something (possible in deep copy)
	if ( typeof target !== "object" && !jQuery.isFunction(target) ) {
		target = {};
	}

	// extend jQuery itself if only one argument is passed
	if ( length === i ) {
		target = this;
		--i;
	}

	for ( ; i < length; i++ ) {
		// Only deal with non-null/undefined values
		if ( (options = arguments[ i ]) != null ) {
			// Extend the base object
			for ( name in options ) {
				src = target[ name ];
				copy = options[ name ];

				// Prevent never-ending loop
				if ( target === copy ) {
					continue;
				}

				// Recurse if we're merging plain objects or arrays
				if ( deep && copy && ( jQuery.isPlainObject(copy) || (copyIsArray = jQuery.isArray(copy)) ) ) {
					if ( copyIsArray ) {
						copyIsArray = false;
						clone = src && jQuery.isArray(src) ? src : [];

					} else {
						clone = src && jQuery.isPlainObject(src) ? src : {};
					}

					// Never move original objects, clone them
					target[ name ] = jQuery.extend( deep, clone, copy );

				// Don't bring in undefined values
				} else if ( copy !== undefined ) {
					target[ name ] = copy;
				}
			}
		}
	}

	// Return the modified object
	return target;
};

jQuery.extend({
	noConflict: function( deep ) {
		if ( window.$ === jQuery ) {
			window.$ = _$;
		}

		if ( deep && window.jQuery === jQuery ) {
			window.jQuery = _jQuery;
		}

		return jQuery;
	},

	// Is the DOM ready to be used? Set to true once it occurs.
	isReady: false,

	// A counter to track how many items to wait for before
	// the ready event fires. See #6781
	readyWait: 1,

	// Hold (or release) the ready event
	holdReady: function( hold ) {
		if ( hold ) {
			jQuery.readyWait++;
		} else {
			jQuery.ready( true );
		}
	},

	// Handle when the DOM is ready
	ready: function( wait ) {

		// Abort if there are pending holds or we're already ready
		if ( wait === true ? --jQuery.readyWait : jQuery.isReady ) {
			return;
		}

		// Make sure body exists, at least, in case IE gets a little overzealous (ticket #5443).
		if ( !document.body ) {
			return setTimeout( jQuery.ready, 1 );
		}

		// Remember that the DOM is ready
		jQuery.isReady = true;

		// If a normal DOM Ready event fired, decrement, and wait if need be
		if ( wait !== true && --jQuery.readyWait > 0 ) {
			return;
		}

		// If there are functions bound, to execute
		readyList.resolveWith( document, [ jQuery ] );

		// Trigger any bound ready events
		if ( jQuery.fn.trigger ) {
			jQuery( document ).trigger("ready").off("ready");
		}
	},

	// See test/unit/core.js for details concerning isFunction.
	// Since version 1.3, DOM methods and functions like alert
	// aren't supported. They return false on IE (#2968).
	isFunction: function( obj ) {
		return jQuery.type(obj) === "function";
	},

	isArray: Array.isArray || function( obj ) {
		return jQuery.type(obj) === "array";
	},

	isWindow: function( obj ) {
		return obj != null && obj == obj.window;
	},

	isNumeric: function( obj ) {
		return !isNaN( parseFloat(obj) ) && isFinite( obj );
	},

	type: function( obj ) {
		return obj == null ?
			String( obj ) :
			class2type[ core_toString.call(obj) ] || "object";
	},

	isPlainObject: function( obj ) {
		// Must be an Object.
		// Because of IE, we also have to check the presence of the constructor property.
		// Make sure that DOM nodes and window objects don't pass through, as well
		if ( !obj || jQuery.type(obj) !== "object" || obj.nodeType || jQuery.isWindow( obj ) ) {
			return false;
		}

		try {
			// Not own constructor property must be Object
			if ( obj.constructor &&
				!core_hasOwn.call(obj, "constructor") &&
				!core_hasOwn.call(obj.constructor.prototype, "isPrototypeOf") ) {
				return false;
			}
		} catch ( e ) {
			// IE8,9 Will throw exceptions on certain host objects #9897
			return false;
		}

		// Own properties are enumerated firstly, so to speed up,
		// if last one is own, then all properties are own.

		var key;
		for ( key in obj ) {}

		return key === undefined || core_hasOwn.call( obj, key );
	},

	isEmptyObject: function( obj ) {
		var name;
		for ( name in obj ) {
			return false;
		}
		return true;
	},

	error: function( msg ) {
		throw new Error( msg );
	},

	// data: string of html
	// context (optional): If specified, the fragment will be created in this context, defaults to document
	// scripts (optional): If true, will include scripts passed in the html string
	parseHTML: function( data, context, scripts ) {
		var parsed;
		if ( !data || typeof data !== "string" ) {
			return null;
		}
		if ( typeof context === "boolean" ) {
			scripts = context;
			context = 0;
		}
		context = context || document;

		// Single tag
		if ( (parsed = rsingleTag.exec( data )) ) {
			return [ context.createElement( parsed[1] ) ];
		}

		parsed = jQuery.buildFragment( [ data ], context, scripts ? null : [] );
		return jQuery.merge( [],
			(parsed.cacheable ? jQuery.clone( parsed.fragment ) : parsed.fragment).childNodes );
	},

	parseJSON: function( data ) {
		if ( !data || typeof data !== "string") {
			return null;
		}

		// Make sure leading/trailing whitespace is removed (IE can't handle it)
		data = jQuery.trim( data );

		// Attempt to parse using the native JSON parser first
		if ( window.JSON && window.JSON.parse ) {
			return window.JSON.parse( data );
		}

		// Make sure the incoming data is actual JSON
		// Logic borrowed from http://json.org/json2.js
		if ( rvalidchars.test( data.replace( rvalidescape, "@" )
			.replace( rvalidtokens, "]" )
			.replace( rvalidbraces, "")) ) {

			return ( new Function( "return " + data ) )();

		}
		jQuery.error( "Invalid JSON: " + data );
	},

	// Cross-browser xml parsing
	parseXML: function( data ) {
		var xml, tmp;
		if ( !data || typeof data !== "string" ) {
			return null;
		}
		try {
			if ( window.DOMParser ) { // Standard
				tmp = new DOMParser();
				xml = tmp.parseFromString( data , "text/xml" );
			} else { // IE
				xml = new ActiveXObject( "Microsoft.XMLDOM" );
				xml.async = "false";
				xml.loadXML( data );
			}
		} catch( e ) {
			xml = undefined;
		}
		if ( !xml || !xml.documentElement || xml.getElementsByTagName( "parsererror" ).length ) {
			jQuery.error( "Invalid XML: " + data );
		}
		return xml;
	},

	noop: function() {},

	// Evaluates a script in a global context
	// Workarounds based on findings by Jim Driscoll
	// http://weblogs.java.net/blog/driscoll/archive/2009/09/08/eval-javascript-global-context
	globalEval: function( data ) {
		if ( data && core_rnotwhite.test( data ) ) {
			// We use execScript on Internet Explorer
			// We use an anonymous function so that context is window
			// rather than jQuery in Firefox
			( window.execScript || function( data ) {
				window[ "eval" ].call( window, data );
			} )( data );
		}
	},

	// Convert dashed to camelCase; used by the css and data modules
	// Microsoft forgot to hump their vendor prefix (#9572)
	camelCase: function( string ) {
		return string.replace( rmsPrefix, "ms-" ).replace( rdashAlpha, fcamelCase );
	},

	nodeName: function( elem, name ) {
		return elem.nodeName && elem.nodeName.toLowerCase() === name.toLowerCase();
	},

	// args is for internal usage only
	each: function( obj, callback, args ) {
		var name,
			i = 0,
			length = obj.length,
			isObj = length === undefined || jQuery.isFunction( obj );

		if ( args ) {
			if ( isObj ) {
				for ( name in obj ) {
					if ( callback.apply( obj[ name ], args ) === false ) {
						break;
					}
				}
			} else {
				for ( ; i < length; ) {
					if ( callback.apply( obj[ i++ ], args ) === false ) {
						break;
					}
				}
			}

		// A special, fast, case for the most common use of each
		} else {
			if ( isObj ) {
				for ( name in obj ) {
					if ( callback.call( obj[ name ], name, obj[ name ] ) === false ) {
						break;
					}
				}
			} else {
				for ( ; i < length; ) {
					if ( callback.call( obj[ i ], i, obj[ i++ ] ) === false ) {
						break;
					}
				}
			}
		}

		return obj;
	},

	// Use native String.trim function wherever possible
	trim: core_trim && !core_trim.call("\uFEFF\xA0") ?
		function( text ) {
			return text == null ?
				"" :
				core_trim.call( text );
		} :

		// Otherwise use our own trimming functionality
		function( text ) {
			return text == null ?
				"" :
				( text + "" ).replace( rtrim, "" );
		},

	// results is for internal usage only
	makeArray: function( arr, results ) {
		var type,
			ret = results || [];

		if ( arr != null ) {
			// The window, strings (and functions) also have 'length'
			// Tweaked logic slightly to handle Blackberry 4.7 RegExp issues #6930
			type = jQuery.type( arr );

			if ( arr.length == null || type === "string" || type === "function" || type === "regexp" || jQuery.isWindow( arr ) ) {
				core_push.call( ret, arr );
			} else {
				jQuery.merge( ret, arr );
			}
		}

		return ret;
	},

	inArray: function( elem, arr, i ) {
		var len;

		if ( arr ) {
			if ( core_indexOf ) {
				return core_indexOf.call( arr, elem, i );
			}

			len = arr.length;
			i = i ? i < 0 ? Math.max( 0, len + i ) : i : 0;

			for ( ; i < len; i++ ) {
				// Skip accessing in sparse arrays
				if ( i in arr && arr[ i ] === elem ) {
					return i;
				}
			}
		}

		return -1;
	},

	merge: function( first, second ) {
		var l = second.length,
			i = first.length,
			j = 0;

		if ( typeof l === "number" ) {
			for ( ; j < l; j++ ) {
				first[ i++ ] = second[ j ];
			}

		} else {
			while ( second[j] !== undefined ) {
				first[ i++ ] = second[ j++ ];
			}
		}

		first.length = i;

		return first;
	},

	grep: function( elems, callback, inv ) {
		var retVal,
			ret = [],
			i = 0,
			length = elems.length;
		inv = !!inv;

		// Go through the array, only saving the items
		// that pass the validator function
		for ( ; i < length; i++ ) {
			retVal = !!callback( elems[ i ], i );
			if ( inv !== retVal ) {
				ret.push( elems[ i ] );
			}
		}

		return ret;
	},

	// arg is for internal usage only
	map: function( elems, callback, arg ) {
		var value, key,
			ret = [],
			i = 0,
			length = elems.length,
			// jquery objects are treated as arrays
			isArray = elems instanceof jQuery || length !== undefined && typeof length === "number" && ( ( length > 0 && elems[ 0 ] && elems[ length -1 ] ) || length === 0 || jQuery.isArray( elems ) ) ;

		// Go through the array, translating each of the items to their
		if ( isArray ) {
			for ( ; i < length; i++ ) {
				value = callback( elems[ i ], i, arg );

				if ( value != null ) {
					ret[ ret.length ] = value;
				}
			}

		// Go through every key on the object,
		} else {
			for ( key in elems ) {
				value = callback( elems[ key ], key, arg );

				if ( value != null ) {
					ret[ ret.length ] = value;
				}
			}
		}

		// Flatten any nested arrays
		return ret.concat.apply( [], ret );
	},

	// A global GUID counter for objects
	guid: 1,

	// Bind a function to a context, optionally partially applying any
	// arguments.
	proxy: function( fn, context ) {
		var tmp, args, proxy;

		if ( typeof context === "string" ) {
			tmp = fn[ context ];
			context = fn;
			fn = tmp;
		}

		// Quick check to determine if target is callable, in the spec
		// this throws a TypeError, but we will just return undefined.
		if ( !jQuery.isFunction( fn ) ) {
			return undefined;
		}

		// Simulated bind
		args = core_slice.call( arguments, 2 );
		proxy = function() {
			return fn.apply( context, args.concat( core_slice.call( arguments ) ) );
		};

		// Set the guid of unique handler to the same of original handler, so it can be removed
		proxy.guid = fn.guid = fn.guid || jQuery.guid++;

		return proxy;
	},

	// Multifunctional method to get and set values of a collection
	// The value/s can optionally be executed if it's a function
	access: function( elems, fn, key, value, chainable, emptyGet, pass ) {
		var exec,
			bulk = key == null,
			i = 0,
			length = elems.length;

		// Sets many values
		if ( key && typeof key === "object" ) {
			for ( i in key ) {
				jQuery.access( elems, fn, i, key[i], 1, emptyGet, value );
			}
			chainable = 1;

		// Sets one value
		} else if ( value !== undefined ) {
			// Optionally, function values get executed if exec is true
			exec = pass === undefined && jQuery.isFunction( value );

			if ( bulk ) {
				// Bulk operations only iterate when executing function values
				if ( exec ) {
					exec = fn;
					fn = function( elem, key, value ) {
						return exec.call( jQuery( elem ), value );
					};

				// Otherwise they run against the entire set
				} else {
					fn.call( elems, value );
					fn = null;
				}
			}

			if ( fn ) {
				for (; i < length; i++ ) {
					fn( elems[i], key, exec ? value.call( elems[i], i, fn( elems[i], key ) ) : value, pass );
				}
			}

			chainable = 1;
		}

		return chainable ?
			elems :

			// Gets
			bulk ?
				fn.call( elems ) :
				length ? fn( elems[0], key ) : emptyGet;
	},

	now: function() {
		return ( new Date() ).getTime();
	}
});

jQuery.ready.promise = function( obj ) {
	if ( !readyList ) {

		readyList = jQuery.Deferred();

		// Catch cases where $(document).ready() is called after the browser event has already occurred.
		// we once tried to use readyState "interactive" here, but it caused issues like the one
		// discovered by ChrisS here: http://bugs.jquery.com/ticket/12282#comment:15
		if ( document.readyState === "complete" ) {
			// Handle it asynchronously to allow scripts the opportunity to delay ready
			setTimeout( jQuery.ready, 1 );

		// Standards-based browsers support DOMContentLoaded
		} else if ( document.addEventListener ) {
			// Use the handy event callback
			document.addEventListener( "DOMContentLoaded", DOMContentLoaded, false );

			// A fallback to window.onload, that will always work
			window.addEventListener( "load", jQuery.ready, false );

		// If IE event model is used
		} else {
			// Ensure firing before onload, maybe late but safe also for iframes
			document.attachEvent( "onreadystatechange", DOMContentLoaded );

			// A fallback to window.onload, that will always work
			window.attachEvent( "onload", jQuery.ready );

			// If IE and not a frame
			// continually check to see if the document is ready
			var top = false;

			try {
				top = window.frameElement == null && document.documentElement;
			} catch(e) {}

			if ( top && top.doScroll ) {
				(function doScrollCheck() {
					if ( !jQuery.isReady ) {

						try {
							// Use the trick by Diego Perini
							// http://javascript.nwbox.com/IEContentLoaded/
							top.doScroll("left");
						} catch(e) {
							return setTimeout( doScrollCheck, 50 );
						}

						// and execute any waiting functions
						jQuery.ready();
					}
				})();
			}
		}
	}
	return readyList.promise( obj );
};

// Populate the class2type map
jQuery.each("Boolean Number String Function Array Date RegExp Object".split(" "), function(i, name) {
	class2type[ "[object " + name + "]" ] = name.toLowerCase();
});

// All jQuery objects should point back to these
rootjQuery = jQuery(document);
// String to Object options format cache
var optionsCache = {};

// Convert String-formatted options into Object-formatted ones and store in cache
function createOptions( options ) {
	var object = optionsCache[ options ] = {};
	jQuery.each( options.split( core_rspace ), function( _, flag ) {
		object[ flag ] = true;
	});
	return object;
}

/*
 * Create a callback list using the following parameters:
 *
 *	options: an optional list of space-separated options that will change how
 *			the callback list behaves or a more traditional option object
 *
 * By default a callback list will act like an event callback list and can be
 * "fired" multiple times.
 *
 * Possible options:
 *
 *	once:			will ensure the callback list can only be fired once (like a Deferred)
 *
 *	memory:			will keep track of previous values and will call any callback added
 *					after the list has been fired right away with the latest "memorized"
 *					values (like a Deferred)
 *
 *	unique:			will ensure a callback can only be added once (no duplicate in the list)
 *
 *	stopOnFalse:	interrupt callings when a callback returns false
 *
 */
jQuery.Callbacks = function( options ) {

	// Convert options from String-formatted to Object-formatted if needed
	// (we check in cache first)
	options = typeof options === "string" ?
		( optionsCache[ options ] || createOptions( options ) ) :
		jQuery.extend( {}, options );

	var // Last fire value (for non-forgettable lists)
		memory,
		// Flag to know if list was already fired
		fired,
		// Flag to know if list is currently firing
		firing,
		// First callback to fire (used internally by add and fireWith)
		firingStart,
		// End of the loop when firing
		firingLength,
		// Index of currently firing callback (modified by remove if needed)
		firingIndex,
		// Actual callback list
		list = [],
		// Stack of fire calls for repeatable lists
		stack = !options.once && [],
		// Fire callbacks
		fire = function( data ) {
			memory = options.memory && data;
			fired = true;
			firingIndex = firingStart || 0;
			firingStart = 0;
			firingLength = list.length;
			firing = true;
			for ( ; list && firingIndex < firingLength; firingIndex++ ) {
				if ( list[ firingIndex ].apply( data[ 0 ], data[ 1 ] ) === false && options.stopOnFalse ) {
					memory = false; // To prevent further calls using add
					break;
				}
			}
			firing = false;
			if ( list ) {
				if ( stack ) {
					if ( stack.length ) {
						fire( stack.shift() );
					}
				} else if ( memory ) {
					list = [];
				} else {
					self.disable();
				}
			}
		},
		// Actual Callbacks object
		self = {
			// Add a callback or a collection of callbacks to the list
			add: function() {
				if ( list ) {
					// First, we save the current length
					var start = list.length;
					(function add( args ) {
						jQuery.each( args, function( _, arg ) {
							var type = jQuery.type( arg );
							if ( type === "function" ) {
								if ( !options.unique || !self.has( arg ) ) {
									list.push( arg );
								}
							} else if ( arg && arg.length && type !== "string" ) {
								// Inspect recursively
								add( arg );
							}
						});
					})( arguments );
					// Do we need to add the callbacks to the
					// current firing batch?
					if ( firing ) {
						firingLength = list.length;
					// With memory, if we're not firing then
					// we should call right away
					} else if ( memory ) {
						firingStart = start;
						fire( memory );
					}
				}
				return this;
			},
			// Remove a callback from the list
			remove: function() {
				if ( list ) {
					jQuery.each( arguments, function( _, arg ) {
						var index;
						while( ( index = jQuery.inArray( arg, list, index ) ) > -1 ) {
							list.splice( index, 1 );
							// Handle firing indexes
							if ( firing ) {
								if ( index <= firingLength ) {
									firingLength--;
								}
								if ( index <= firingIndex ) {
									firingIndex--;
								}
							}
						}
					});
				}
				return this;
			},
			// Control if a given callback is in the list
			has: function( fn ) {
				return jQuery.inArray( fn, list ) > -1;
			},
			// Remove all callbacks from the list
			empty: function() {
				list = [];
				return this;
			},
			// Have the list do nothing anymore
			disable: function() {
				list = stack = memory = undefined;
				return this;
			},
			// Is it disabled?
			disabled: function() {
				return !list;
			},
			// Lock the list in its current state
			lock: function() {
				stack = undefined;
				if ( !memory ) {
					self.disable();
				}
				return this;
			},
			// Is it locked?
			locked: function() {
				return !stack;
			},
			// Call all callbacks with the given context and arguments
			fireWith: function( context, args ) {
				args = args || [];
				args = [ context, args.slice ? args.slice() : args ];
				if ( list && ( !fired || stack ) ) {
					if ( firing ) {
						stack.push( args );
					} else {
						fire( args );
					}
				}
				return this;
			},
			// Call all the callbacks with the given arguments
			fire: function() {
				self.fireWith( this, arguments );
				return this;
			},
			// To know if the callbacks have already been called at least once
			fired: function() {
				return !!fired;
			}
		};

	return self;
};
jQuery.extend({

	Deferred: function( func ) {
		var tuples = [
				// action, add listener, listener list, final state
				[ "resolve", "done", jQuery.Callbacks("once memory"), "resolved" ],
				[ "reject", "fail", jQuery.Callbacks("once memory"), "rejected" ],
				[ "notify", "progress", jQuery.Callbacks("memory") ]
			],
			state = "pending",
			promise = {
				state: function() {
					return state;
				},
				always: function() {
					deferred.done( arguments ).fail( arguments );
					return this;
				},
				then: function( /* fnDone, fnFail, fnProgress */ ) {
					var fns = arguments;
					return jQuery.Deferred(function( newDefer ) {
						jQuery.each( tuples, function( i, tuple ) {
							var action = tuple[ 0 ],
								fn = fns[ i ];
							// deferred[ done | fail | progress ] for forwarding actions to newDefer
							deferred[ tuple[1] ]( jQuery.isFunction( fn ) ?
								function() {
									var returned = fn.apply( this, arguments );
									if ( returned && jQuery.isFunction( returned.promise ) ) {
										returned.promise()
											.done( newDefer.resolve )
											.fail( newDefer.reject )
											.progress( newDefer.notify );
									} else {
										newDefer[ action + "With" ]( this === deferred ? newDefer : this, [ returned ] );
									}
								} :
								newDefer[ action ]
							);
						});
						fns = null;
					}).promise();
				},
				// Get a promise for this deferred
				// If obj is provided, the promise aspect is added to the object
				promise: function( obj ) {
					return obj != null ? jQuery.extend( obj, promise ) : promise;
				}
			},
			deferred = {};

		// Keep pipe for back-compat
		promise.pipe = promise.then;

		// Add list-specific methods
		jQuery.each( tuples, function( i, tuple ) {
			var list = tuple[ 2 ],
				stateString = tuple[ 3 ];

			// promise[ done | fail | progress ] = list.add
			promise[ tuple[1] ] = list.add;

			// Handle state
			if ( stateString ) {
				list.add(function() {
					// state = [ resolved | rejected ]
					state = stateString;

				// [ reject_list | resolve_list ].disable; progress_list.lock
				}, tuples[ i ^ 1 ][ 2 ].disable, tuples[ 2 ][ 2 ].lock );
			}

			// deferred[ resolve | reject | notify ] = list.fire
			deferred[ tuple[0] ] = list.fire;
			deferred[ tuple[0] + "With" ] = list.fireWith;
		});

		// Make the deferred a promise
		promise.promise( deferred );

		// Call given func if any
		if ( func ) {
			func.call( deferred, deferred );
		}

		// All done!
		return deferred;
	},

	// Deferred helper
	when: function( subordinate /* , ..., subordinateN */ ) {
		var i = 0,
			resolveValues = core_slice.call( arguments ),
			length = resolveValues.length,

			// the count of uncompleted subordinates
			remaining = length !== 1 || ( subordinate && jQuery.isFunction( subordinate.promise ) ) ? length : 0,

			// the master Deferred. If resolveValues consist of only a single Deferred, just use that.
			deferred = remaining === 1 ? subordinate : jQuery.Deferred(),

			// Update function for both resolve and progress values
			updateFunc = function( i, contexts, values ) {
				return function( value ) {
					contexts[ i ] = this;
					values[ i ] = arguments.length > 1 ? core_slice.call( arguments ) : value;
					if( values === progressValues ) {
						deferred.notifyWith( contexts, values );
					} else if ( !( --remaining ) ) {
						deferred.resolveWith( contexts, values );
					}
				};
			},

			progressValues, progressContexts, resolveContexts;

		// add listeners to Deferred subordinates; treat others as resolved
		if ( length > 1 ) {
			progressValues = new Array( length );
			progressContexts = new Array( length );
			resolveContexts = new Array( length );
			for ( ; i < length; i++ ) {
				if ( resolveValues[ i ] && jQuery.isFunction( resolveValues[ i ].promise ) ) {
					resolveValues[ i ].promise()
						.done( updateFunc( i, resolveContexts, resolveValues ) )
						.fail( deferred.reject )
						.progress( updateFunc( i, progressContexts, progressValues ) );
				} else {
					--remaining;
				}
			}
		}

		// if we're not waiting on anything, resolve the master
		if ( !remaining ) {
			deferred.resolveWith( resolveContexts, resolveValues );
		}

		return deferred.promise();
	}
});
jQuery.support = (function() {

	var support,
		all,
		a,
		select,
		opt,
		input,
		fragment,
		eventName,
		i,
		isSupported,
		clickFn,
		div = document.createElement("div");

	// Setup
	div.setAttribute( "className", "t" );
	div.innerHTML = "  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>";

	// Support tests won't run in some limited or non-browser environments
	all = div.getElementsByTagName("*");
	a = div.getElementsByTagName("a")[ 0 ];
	if ( !all || !a || !all.length ) {
		return {};
	}

	// First batch of tests
	select = document.createElement("select");
	opt = select.appendChild( document.createElement("option") );
	input = div.getElementsByTagName("input")[ 0 ];

	a.style.cssText = "top:1px;float:left;opacity:.5";
	support = {
		// IE strips leading whitespace when .innerHTML is used
		leadingWhitespace: ( div.firstChild.nodeType === 3 ),

		// Make sure that tbody elements aren't automatically inserted
		// IE will insert them into empty tables
		tbody: !div.getElementsByTagName("tbody").length,

		// Make sure that link elements get serialized correctly by innerHTML
		// This requires a wrapper element in IE
		htmlSerialize: !!div.getElementsByTagName("link").length,

		// Get the style information from getAttribute
		// (IE uses .cssText instead)
		style: /top/.test( a.getAttribute("style") ),

		// Make sure that URLs aren't manipulated
		// (IE normalizes it by default)
		hrefNormalized: ( a.getAttribute("href") === "/a" ),

		// Make sure that element opacity exists
		// (IE uses filter instead)
		// Use a regex to work around a WebKit issue. See #5145
		opacity: /^0.5/.test( a.style.opacity ),

		// Verify style float existence
		// (IE uses styleFloat instead of cssFloat)
		cssFloat: !!a.style.cssFloat,

		// Make sure that if no value is specified for a checkbox
		// that it defaults to "on".
		// (WebKit defaults to "" instead)
		checkOn: ( input.value === "on" ),

		// Make sure that a selected-by-default option has a working selected property.
		// (WebKit defaults to false instead of true, IE too, if it's in an optgroup)
		optSelected: opt.selected,

		// Test setAttribute on camelCase class. If it works, we need attrFixes when doing get/setAttribute (ie6/7)
		getSetAttribute: div.className !== "t",

		// Tests for enctype support on a form (#6743)
		enctype: !!document.createElement("form").enctype,

		// Makes sure cloning an html5 element does not cause problems
		// Where outerHTML is undefined, this still works
		html5Clone: document.createElement("nav").cloneNode( true ).outerHTML !== "<:nav></:nav>",

		// jQuery.support.boxModel DEPRECATED in 1.8 since we don't support Quirks Mode
		boxModel: ( document.compatMode === "CSS1Compat" ),

		// Will be defined later
		submitBubbles: true,
		changeBubbles: true,
		focusinBubbles: false,
		deleteExpando: true,
		noCloneEvent: true,
		inlineBlockNeedsLayout: false,
		shrinkWrapBlocks: false,
		reliableMarginRight: true,
		boxSizingReliable: true,
		pixelPosition: false
	};

	// Make sure checked status is properly cloned
	input.checked = true;
	support.noCloneChecked = input.cloneNode( true ).checked;

	// Make sure that the options inside disabled selects aren't marked as disabled
	// (WebKit marks them as disabled)
	select.disabled = true;
	support.optDisabled = !opt.disabled;

	// Test to see if it's possible to delete an expando from an element
	// Fails in Internet Explorer
	try {
		delete div.test;
	} catch( e ) {
		support.deleteExpando = false;
	}

	if ( !div.addEventListener && div.attachEvent && div.fireEvent ) {
		div.attachEvent( "onclick", clickFn = function() {
			// Cloning a node shouldn't copy over any
			// bound event handlers (IE does this)
			support.noCloneEvent = false;
		});
		div.cloneNode( true ).fireEvent("onclick");
		div.detachEvent( "onclick", clickFn );
	}

	// Check if a radio maintains its value
	// after being appended to the DOM
	input = document.createElement("input");
	input.value = "t";
	input.setAttribute( "type", "radio" );
	support.radioValue = input.value === "t";

	input.setAttribute( "checked", "checked" );

	// #11217 - WebKit loses check when the name is after the checked attribute
	input.setAttribute( "name", "t" );

	div.appendChild( input );
	fragment = document.createDocumentFragment();
	fragment.appendChild( div.lastChild );

	// WebKit doesn't clone checked state correctly in fragments
	support.checkClone = fragment.cloneNode( true ).cloneNode( true ).lastChild.checked;

	// Check if a disconnected checkbox will retain its checked
	// value of true after appended to the DOM (IE6/7)
	support.appendChecked = input.checked;

	fragment.removeChild( input );
	fragment.appendChild( div );

	// Technique from Juriy Zaytsev
	// http://perfectionkills.com/detecting-event-support-without-browser-sniffing/
	// We only care about the case where non-standard event systems
	// are used, namely in IE. Short-circuiting here helps us to
	// avoid an eval call (in setAttribute) which can cause CSP
	// to go haywire. See: https://developer.mozilla.org/en/Security/CSP
	if ( div.attachEvent ) {
		for ( i in {
			submit: true,
			change: true,
			focusin: true
		}) {
			eventName = "on" + i;
			isSupported = ( eventName in div );
			if ( !isSupported ) {
				div.setAttribute( eventName, "return;" );
				isSupported = ( typeof div[ eventName ] === "function" );
			}
			support[ i + "Bubbles" ] = isSupported;
		}
	}

	// Run tests that need a body at doc ready
	jQuery(function() {
		var container, div, tds, marginDiv,
			divReset = "padding:0;margin:0;border:0;display:block;overflow:hidden;",
			body = document.getElementsByTagName("body")[0];

		if ( !body ) {
			// Return for frameset docs that don't have a body
			return;
		}

		container = document.createElement("div");
		container.style.cssText = "visibility:hidden;border:0;width:0;height:0;position:static;top:0;margin-top:1px";
		body.insertBefore( container, body.firstChild );

		// Construct the test element
		div = document.createElement("div");
		container.appendChild( div );

		// Check if table cells still have offsetWidth/Height when they are set
		// to display:none and there are still other visible table cells in a
		// table row; if so, offsetWidth/Height are not reliable for use when
		// determining if an element has been hidden directly using
		// display:none (it is still safe to use offsets if a parent element is
		// hidden; don safety goggles and see bug #4512 for more information).
		// (only IE 8 fails this test)
		div.innerHTML = "<table><tr><td></td><td>t</td></tr></table>";
		tds = div.getElementsByTagName("td");
		tds[ 0 ].style.cssText = "padding:0;margin:0;border:0;display:none";
		isSupported = ( tds[ 0 ].offsetHeight === 0 );

		tds[ 0 ].style.display = "";
		tds[ 1 ].style.display = "none";

		// Check if empty table cells still have offsetWidth/Height
		// (IE <= 8 fail this test)
		support.reliableHiddenOffsets = isSupported && ( tds[ 0 ].offsetHeight === 0 );

		// Check box-sizing and margin behavior
		div.innerHTML = "";
		div.style.cssText = "box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;padding:1px;border:1px;display:block;width:4px;margin-top:1%;position:absolute;top:1%;";
		support.boxSizing = ( div.offsetWidth === 4 );
		support.doesNotIncludeMarginInBodyOffset = ( body.offsetTop !== 1 );

		// NOTE: To any future maintainer, we've window.getComputedStyle
		// because jsdom on node.js will break without it.
		if ( window.getComputedStyle ) {
			support.pixelPosition = ( window.getComputedStyle( div, null ) || {} ).top !== "1%";
			support.boxSizingReliable = ( window.getComputedStyle( div, null ) || { width: "4px" } ).width === "4px";

			// Check if div with explicit width and no margin-right incorrectly
			// gets computed margin-right based on width of container. For more
			// info see bug #3333
			// Fails in WebKit before Feb 2011 nightlies
			// WebKit Bug 13343 - getComputedStyle returns wrong value for margin-right
			marginDiv = document.createElement("div");
			marginDiv.style.cssText = div.style.cssText = divReset;
			marginDiv.style.marginRight = marginDiv.style.width = "0";
			div.style.width = "1px";
			div.appendChild( marginDiv );
			support.reliableMarginRight =
				!parseFloat( ( window.getComputedStyle( marginDiv, null ) || {} ).marginRight );
		}

		if ( typeof div.style.zoom !== "undefined" ) {
			// Check if natively block-level elements act like inline-block
			// elements when setting their display to 'inline' and giving
			// them layout
			// (IE < 8 does this)
			div.innerHTML = "";
			div.style.cssText = divReset + "width:1px;padding:1px;display:inline;zoom:1";
			support.inlineBlockNeedsLayout = ( div.offsetWidth === 3 );

			// Check if elements with layout shrink-wrap their children
			// (IE 6 does this)
			div.style.display = "block";
			div.style.overflow = "visible";
			div.innerHTML = "<div></div>";
			div.firstChild.style.width = "5px";
			support.shrinkWrapBlocks = ( div.offsetWidth !== 3 );

			container.style.zoom = 1;
		}

		// Null elements to avoid leaks in IE
		body.removeChild( container );
		container = div = tds = marginDiv = null;
	});

	// Null elements to avoid leaks in IE
	fragment.removeChild( div );
	all = a = select = opt = input = fragment = div = null;

	return support;
})();
var rbrace = /(?:\{[\s\S]*\}|\[[\s\S]*\])$/,
	rmultiDash = /([A-Z])/g;

jQuery.extend({
	cache: {},

	deletedIds: [],

	// Remove at next major release (1.9/2.0)
	uuid: 0,

	// Unique for each copy of jQuery on the page
	// Non-digits removed to match rinlinejQuery
	expando: "jQuery" + ( jQuery.fn.jquery + Math.random() ).replace( /\D/g, "" ),

	// The following elements throw uncatchable exceptions if you
	// attempt to add expando properties to them.
	noData: {
		"embed": true,
		// Ban all objects except for Flash (which handle expandos)
		"object": "clsid:D27CDB6E-AE6D-11cf-96B8-444553540000",
		"applet": true
	},

	hasData: function( elem ) {
		elem = elem.nodeType ? jQuery.cache[ elem[jQuery.expando] ] : elem[ jQuery.expando ];
		return !!elem && !isEmptyDataObject( elem );
	},

	data: function( elem, name, data, pvt /* Internal Use Only */ ) {
		if ( !jQuery.acceptData( elem ) ) {
			return;
		}

		var thisCache, ret,
			internalKey = jQuery.expando,
			getByName = typeof name === "string",

			// We have to handle DOM nodes and JS objects differently because IE6-7
			// can't GC object references properly across the DOM-JS boundary
			isNode = elem.nodeType,

			// Only DOM nodes need the global jQuery cache; JS object data is
			// attached directly to the object so GC can occur automatically
			cache = isNode ? jQuery.cache : elem,

			// Only defining an ID for JS objects if its cache already exists allows
			// the code to shortcut on the same path as a DOM node with no cache
			id = isNode ? elem[ internalKey ] : elem[ internalKey ] && internalKey;

		// Avoid doing any more work than we need to when trying to get data on an
		// object that has no data at all
		if ( (!id || !cache[id] || (!pvt && !cache[id].data)) && getByName && data === undefined ) {
			return;
		}

		if ( !id ) {
			// Only DOM nodes need a new unique ID for each element since their data
			// ends up in the global cache
			if ( isNode ) {
				elem[ internalKey ] = id = jQuery.deletedIds.pop() || jQuery.guid++;
			} else {
				id = internalKey;
			}
		}

		if ( !cache[ id ] ) {
			cache[ id ] = {};

			// Avoids exposing jQuery metadata on plain JS objects when the object
			// is serialized using JSON.stringify
			if ( !isNode ) {
				cache[ id ].toJSON = jQuery.noop;
			}
		}

		// An object can be passed to jQuery.data instead of a key/value pair; this gets
		// shallow copied over onto the existing cache
		if ( typeof name === "object" || typeof name === "function" ) {
			if ( pvt ) {
				cache[ id ] = jQuery.extend( cache[ id ], name );
			} else {
				cache[ id ].data = jQuery.extend( cache[ id ].data, name );
			}
		}

		thisCache = cache[ id ];

		// jQuery data() is stored in a separate object inside the object's internal data
		// cache in order to avoid key collisions between internal data and user-defined
		// data.
		if ( !pvt ) {
			if ( !thisCache.data ) {
				thisCache.data = {};
			}

			thisCache = thisCache.data;
		}

		if ( data !== undefined ) {
			thisCache[ jQuery.camelCase( name ) ] = data;
		}

		// Check for both converted-to-camel and non-converted data property names
		// If a data property was specified
		if ( getByName ) {

			// First Try to find as-is property data
			ret = thisCache[ name ];

			// Test for null|undefined property data
			if ( ret == null ) {

				// Try to find the camelCased property
				ret = thisCache[ jQuery.camelCase( name ) ];
			}
		} else {
			ret = thisCache;
		}

		return ret;
	},

	removeData: function( elem, name, pvt /* Internal Use Only */ ) {
		if ( !jQuery.acceptData( elem ) ) {
			return;
		}

		var thisCache, i, l,

			isNode = elem.nodeType,

			// See jQuery.data for more information
			cache = isNode ? jQuery.cache : elem,
			id = isNode ? elem[ jQuery.expando ] : jQuery.expando;

		// If there is already no cache entry for this object, there is no
		// purpose in continuing
		if ( !cache[ id ] ) {
			return;
		}

		if ( name ) {

			thisCache = pvt ? cache[ id ] : cache[ id ].data;

			if ( thisCache ) {

				// Support array or space separated string names for data keys
				if ( !jQuery.isArray( name ) ) {

					// try the string as a key before any manipulation
					if ( name in thisCache ) {
						name = [ name ];
					} else {

						// split the camel cased version by spaces unless a key with the spaces exists
						name = jQuery.camelCase( name );
						if ( name in thisCache ) {
							name = [ name ];
						} else {
							name = name.split(" ");
						}
					}
				}

				for ( i = 0, l = name.length; i < l; i++ ) {
					delete thisCache[ name[i] ];
				}

				// If there is no data left in the cache, we want to continue
				// and let the cache object itself get destroyed
				if ( !( pvt ? isEmptyDataObject : jQuery.isEmptyObject )( thisCache ) ) {
					return;
				}
			}
		}

		// See jQuery.data for more information
		if ( !pvt ) {
			delete cache[ id ].data;

			// Don't destroy the parent cache unless the internal data object
			// had been the only thing left in it
			if ( !isEmptyDataObject( cache[ id ] ) ) {
				return;
			}
		}

		// Destroy the cache
		if ( isNode ) {
			jQuery.cleanData( [ elem ], true );

		// Use delete when supported for expandos or `cache` is not a window per isWindow (#10080)
		} else if ( jQuery.support.deleteExpando || cache != cache.window ) {
			delete cache[ id ];

		// When all else fails, null
		} else {
			cache[ id ] = null;
		}
	},

	// For internal use only.
	_data: function( elem, name, data ) {
		return jQuery.data( elem, name, data, true );
	},

	// A method for determining if a DOM node can handle the data expando
	acceptData: function( elem ) {
		var noData = elem.nodeName && jQuery.noData[ elem.nodeName.toLowerCase() ];

		// nodes accept data unless otherwise specified; rejection can be conditional
		return !noData || noData !== true && elem.getAttribute("classid") === noData;
	}
});

jQuery.fn.extend({
	data: function( key, value ) {
		var parts, part, attr, name, l,
			elem = this[0],
			i = 0,
			data = null;

		// Gets all values
		if ( key === undefined ) {
			if ( this.length ) {
				data = jQuery.data( elem );

				if ( elem.nodeType === 1 && !jQuery._data( elem, "parsedAttrs" ) ) {
					attr = elem.attributes;
					for ( l = attr.length; i < l; i++ ) {
						name = attr[i].name;

						if ( !name.indexOf( "data-" ) ) {
							name = jQuery.camelCase( name.substring(5) );

							dataAttr( elem, name, data[ name ] );
						}
					}
					jQuery._data( elem, "parsedAttrs", true );
				}
			}

			return data;
		}

		// Sets multiple values
		if ( typeof key === "object" ) {
			return this.each(function() {
				jQuery.data( this, key );
			});
		}

		parts = key.split( ".", 2 );
		parts[1] = parts[1] ? "." + parts[1] : "";
		part = parts[1] + "!";

		return jQuery.access( this, function( value ) {

			if ( value === undefined ) {
				data = this.triggerHandler( "getData" + part, [ parts[0] ] );

				// Try to fetch any internally stored data first
				if ( data === undefined && elem ) {
					data = jQuery.data( elem, key );
					data = dataAttr( elem, key, data );
				}

				return data === undefined && parts[1] ?
					this.data( parts[0] ) :
					data;
			}

			parts[1] = value;
			this.each(function() {
				var self = jQuery( this );

				self.triggerHandler( "setData" + part, parts );
				jQuery.data( this, key, value );
				self.triggerHandler( "changeData" + part, parts );
			});
		}, null, value, arguments.length > 1, null, false );
	},

	removeData: function( key ) {
		return this.each(function() {
			jQuery.removeData( this, key );
		});
	}
});

function dataAttr( elem, key, data ) {
	// If nothing was found internally, try to fetch any
	// data from the HTML5 data-* attribute
	if ( data === undefined && elem.nodeType === 1 ) {

		var name = "data-" + key.replace( rmultiDash, "-$1" ).toLowerCase();

		data = elem.getAttribute( name );

		if ( typeof data === "string" ) {
			try {
				data = data === "true" ? true :
				data === "false" ? false :
				data === "null" ? null :
				// Only convert to a number if it doesn't change the string
				+data + "" === data ? +data :
				rbrace.test( data ) ? jQuery.parseJSON( data ) :
					data;
			} catch( e ) {}

			// Make sure we set the data so it isn't changed later
			jQuery.data( elem, key, data );

		} else {
			data = undefined;
		}
	}

	return data;
}

// checks a cache object for emptiness
function isEmptyDataObject( obj ) {
	var name;
	for ( name in obj ) {

		// if the public data object is empty, the private is still empty
		if ( name === "data" && jQuery.isEmptyObject( obj[name] ) ) {
			continue;
		}
		if ( name !== "toJSON" ) {
			return false;
		}
	}

	return true;
}
jQuery.extend({
	queue: function( elem, type, data ) {
		var queue;

		if ( elem ) {
			type = ( type || "fx" ) + "queue";
			queue = jQuery._data( elem, type );

			// Speed up dequeue by getting out quickly if this is just a lookup
			if ( data ) {
				if ( !queue || jQuery.isArray(data) ) {
					queue = jQuery._data( elem, type, jQuery.makeArray(data) );
				} else {
					queue.push( data );
				}
			}
			return queue || [];
		}
	},

	dequeue: function( elem, type ) {
		type = type || "fx";

		var queue = jQuery.queue( elem, type ),
			startLength = queue.length,
			fn = queue.shift(),
			hooks = jQuery._queueHooks( elem, type ),
			next = function() {
				jQuery.dequeue( elem, type );
			};

		// If the fx queue is dequeued, always remove the progress sentinel
		if ( fn === "inprogress" ) {
			fn = queue.shift();
			startLength--;
		}

		if ( fn ) {

			// Add a progress sentinel to prevent the fx queue from being
			// automatically dequeued
			if ( type === "fx" ) {
				queue.unshift( "inprogress" );
			}

			// clear up the last queue stop function
			delete hooks.stop;
			fn.call( elem, next, hooks );
		}

		if ( !startLength && hooks ) {
			hooks.empty.fire();
		}
	},

	// not intended for public consumption - generates a queueHooks object, or returns the current one
	_queueHooks: function( elem, type ) {
		var key = type + "queueHooks";
		return jQuery._data( elem, key ) || jQuery._data( elem, key, {
			empty: jQuery.Callbacks("once memory").add(function() {
				jQuery.removeData( elem, type + "queue", true );
				jQuery.removeData( elem, key, true );
			})
		});
	}
});

jQuery.fn.extend({
	queue: function( type, data ) {
		var setter = 2;

		if ( typeof type !== "string" ) {
			data = type;
			type = "fx";
			setter--;
		}

		if ( arguments.length < setter ) {
			return jQuery.queue( this[0], type );
		}

		return data === undefined ?
			this :
			this.each(function() {
				var queue = jQuery.queue( this, type, data );

				// ensure a hooks for this queue
				jQuery._queueHooks( this, type );

				if ( type === "fx" && queue[0] !== "inprogress" ) {
					jQuery.dequeue( this, type );
				}
			});
	},
	dequeue: function( type ) {
		return this.each(function() {
			jQuery.dequeue( this, type );
		});
	},
	// Based off of the plugin by Clint Helfers, with permission.
	// http://blindsignals.com/index.php/2009/07/jquery-delay/
	delay: function( time, type ) {
		time = jQuery.fx ? jQuery.fx.speeds[ time ] || time : time;
		type = type || "fx";

		return this.queue( type, function( next, hooks ) {
			var timeout = setTimeout( next, time );
			hooks.stop = function() {
				clearTimeout( timeout );
			};
		});
	},
	clearQueue: function( type ) {
		return this.queue( type || "fx", [] );
	},
	// Get a promise resolved when queues of a certain type
	// are emptied (fx is the type by default)
	promise: function( type, obj ) {
		var tmp,
			count = 1,
			defer = jQuery.Deferred(),
			elements = this,
			i = this.length,
			resolve = function() {
				if ( !( --count ) ) {
					defer.resolveWith( elements, [ elements ] );
				}
			};

		if ( typeof type !== "string" ) {
			obj = type;
			type = undefined;
		}
		type = type || "fx";

		while( i-- ) {
			tmp = jQuery._data( elements[ i ], type + "queueHooks" );
			if ( tmp && tmp.empty ) {
				count++;
				tmp.empty.add( resolve );
			}
		}
		resolve();
		return defer.promise( obj );
	}
});
var nodeHook, boolHook, fixSpecified,
	rclass = /[\t\r\n]/g,
	rreturn = /\r/g,
	rtype = /^(?:button|input)$/i,
	rfocusable = /^(?:button|input|object|select|textarea)$/i,
	rclickable = /^a(?:rea|)$/i,
	rboolean = /^(?:autofocus|autoplay|async|checked|controls|defer|disabled|hidden|loop|multiple|open|readonly|required|scoped|selected)$/i,
	getSetAttribute = jQuery.support.getSetAttribute;

jQuery.fn.extend({
	attr: function( name, value ) {
		return jQuery.access( this, jQuery.attr, name, value, arguments.length > 1 );
	},

	removeAttr: function( name ) {
		return this.each(function() {
			jQuery.removeAttr( this, name );
		});
	},

	prop: function( name, value ) {
		return jQuery.access( this, jQuery.prop, name, value, arguments.length > 1 );
	},

	removeProp: function( name ) {
		name = jQuery.propFix[ name ] || name;
		return this.each(function() {
			// try/catch handles cases where IE balks (such as removing a property on window)
			try {
				this[ name ] = undefined;
				delete this[ name ];
			} catch( e ) {}
		});
	},

	addClass: function( value ) {
		var classNames, i, l, elem,
			setClass, c, cl;

		if ( jQuery.isFunction( value ) ) {
			return this.each(function( j ) {
				jQuery( this ).addClass( value.call(this, j, this.className) );
			});
		}

		if ( value && typeof value === "string" ) {
			classNames = value.split( core_rspace );

			for ( i = 0, l = this.length; i < l; i++ ) {
				elem = this[ i ];

				if ( elem.nodeType === 1 ) {
					if ( !elem.className && classNames.length === 1 ) {
						elem.className = value;

					} else {
						setClass = " " + elem.className + " ";

						for ( c = 0, cl = classNames.length; c < cl; c++ ) {
							if ( setClass.indexOf( " " + classNames[ c ] + " " ) < 0 ) {
								setClass += classNames[ c ] + " ";
							}
						}
						elem.className = jQuery.trim( setClass );
					}
				}
			}
		}

		return this;
	},

	removeClass: function( value ) {
		var removes, className, elem, c, cl, i, l;

		if ( jQuery.isFunction( value ) ) {
			return this.each(function( j ) {
				jQuery( this ).removeClass( value.call(this, j, this.className) );
			});
		}
		if ( (value && typeof value === "string") || value === undefined ) {
			removes = ( value || "" ).split( core_rspace );

			for ( i = 0, l = this.length; i < l; i++ ) {
				elem = this[ i ];
				if ( elem.nodeType === 1 && elem.className ) {

					className = (" " + elem.className + " ").replace( rclass, " " );

					// loop over each item in the removal list
					for ( c = 0, cl = removes.length; c < cl; c++ ) {
						// Remove until there is nothing to remove,
						while ( className.indexOf(" " + removes[ c ] + " ") >= 0 ) {
							className = className.replace( " " + removes[ c ] + " " , " " );
						}
					}
					elem.className = value ? jQuery.trim( className ) : "";
				}
			}
		}

		return this;
	},

	toggleClass: function( value, stateVal ) {
		var type = typeof value,
			isBool = typeof stateVal === "boolean";

		if ( jQuery.isFunction( value ) ) {
			return this.each(function( i ) {
				jQuery( this ).toggleClass( value.call(this, i, this.className, stateVal), stateVal );
			});
		}

		return this.each(function() {
			if ( type === "string" ) {
				// toggle individual class names
				var className,
					i = 0,
					self = jQuery( this ),
					state = stateVal,
					classNames = value.split( core_rspace );

				while ( (className = classNames[ i++ ]) ) {
					// check each className given, space separated list
					state = isBool ? state : !self.hasClass( className );
					self[ state ? "addClass" : "removeClass" ]( className );
				}

			} else if ( type === "undefined" || type === "boolean" ) {
				if ( this.className ) {
					// store className if set
					jQuery._data( this, "__className__", this.className );
				}

				// toggle whole className
				this.className = this.className || value === false ? "" : jQuery._data( this, "__className__" ) || "";
			}
		});
	},

	hasClass: function( selector ) {
		var className = " " + selector + " ",
			i = 0,
			l = this.length;
		for ( ; i < l; i++ ) {
			if ( this[i].nodeType === 1 && (" " + this[i].className + " ").replace(rclass, " ").indexOf( className ) >= 0 ) {
				return true;
			}
		}

		return false;
	},

	val: function( value ) {
		var hooks, ret, isFunction,
			elem = this[0];

		if ( !arguments.length ) {
			if ( elem ) {
				hooks = jQuery.valHooks[ elem.type ] || jQuery.valHooks[ elem.nodeName.toLowerCase() ];

				if ( hooks && "get" in hooks && (ret = hooks.get( elem, "value" )) !== undefined ) {
					return ret;
				}

				ret = elem.value;

				return typeof ret === "string" ?
					// handle most common string cases
					ret.replace(rreturn, "") :
					// handle cases where value is null/undef or number
					ret == null ? "" : ret;
			}

			return;
		}

		isFunction = jQuery.isFunction( value );

		return this.each(function( i ) {
			var val,
				self = jQuery(this);

			if ( this.nodeType !== 1 ) {
				return;
			}

			if ( isFunction ) {
				val = value.call( this, i, self.val() );
			} else {
				val = value;
			}

			// Treat null/undefined as ""; convert numbers to string
			if ( val == null ) {
				val = "";
			} else if ( typeof val === "number" ) {
				val += "";
			} else if ( jQuery.isArray( val ) ) {
				val = jQuery.map(val, function ( value ) {
					return value == null ? "" : value + "";
				});
			}

			hooks = jQuery.valHooks[ this.type ] || jQuery.valHooks[ this.nodeName.toLowerCase() ];

			// If set returns undefined, fall back to normal setting
			if ( !hooks || !("set" in hooks) || hooks.set( this, val, "value" ) === undefined ) {
				this.value = val;
			}
		});
	}
});

jQuery.extend({
	valHooks: {
		option: {
			get: function( elem ) {
				// attributes.value is undefined in Blackberry 4.7 but
				// uses .value. See #6932
				var val = elem.attributes.value;
				return !val || val.specified ? elem.value : elem.text;
			}
		},
		select: {
			get: function( elem ) {
				var value, option,
					options = elem.options,
					index = elem.selectedIndex,
					one = elem.type === "select-one" || index < 0,
					values = one ? null : [],
					max = one ? index + 1 : options.length,
					i = index < 0 ?
						max :
						one ? index : 0;

				// Loop through all the selected options
				for ( ; i < max; i++ ) {
					option = options[ i ];

					// oldIE doesn't update selected after form reset (#2551)
					if ( ( option.selected || i === index ) &&
							// Don't return options that are disabled or in a disabled optgroup
							( jQuery.support.optDisabled ? !option.disabled : option.getAttribute("disabled") === null ) &&
							( !option.parentNode.disabled || !jQuery.nodeName( option.parentNode, "optgroup" ) ) ) {

						// Get the specific value for the option
						value = jQuery( option ).val();

						// We don't need an array for one selects
						if ( one ) {
							return value;
						}

						// Multi-Selects return an array
						values.push( value );
					}
				}

				return values;
			},

			set: function( elem, value ) {
				var values = jQuery.makeArray( value );

				jQuery(elem).find("option").each(function() {
					this.selected = jQuery.inArray( jQuery(this).val(), values ) >= 0;
				});

				if ( !values.length ) {
					elem.selectedIndex = -1;
				}
				return values;
			}
		}
	},

	// Unused in 1.8, left in so attrFn-stabbers won't die; remove in 1.9
	attrFn: {},

	attr: function( elem, name, value, pass ) {
		var ret, hooks, notxml,
			nType = elem.nodeType;

		// don't get/set attributes on text, comment and attribute nodes
		if ( !elem || nType === 3 || nType === 8 || nType === 2 ) {
			return;
		}

		if ( pass && jQuery.isFunction( jQuery.fn[ name ] ) ) {
			return jQuery( elem )[ name ]( value );
		}

		// Fallback to prop when attributes are not supported
		if ( typeof elem.getAttribute === "undefined" ) {
			return jQuery.prop( elem, name, value );
		}

		notxml = nType !== 1 || !jQuery.isXMLDoc( elem );

		// All attributes are lowercase
		// Grab necessary hook if one is defined
		if ( notxml ) {
			name = name.toLowerCase();
			hooks = jQuery.attrHooks[ name ] || ( rboolean.test( name ) ? boolHook : nodeHook );
		}

		if ( value !== undefined ) {

			if ( value === null ) {
				jQuery.removeAttr( elem, name );
				return;

			} else if ( hooks && "set" in hooks && notxml && (ret = hooks.set( elem, value, name )) !== undefined ) {
				return ret;

			} else {
				elem.setAttribute( name, value + "" );
				return value;
			}

		} else if ( hooks && "get" in hooks && notxml && (ret = hooks.get( elem, name )) !== null ) {
			return ret;

		} else {

			ret = elem.getAttribute( name );

			// Non-existent attributes return null, we normalize to undefined
			return ret === null ?
				undefined :
				ret;
		}
	},

	removeAttr: function( elem, value ) {
		var propName, attrNames, name, isBool,
			i = 0;

		if ( value && elem.nodeType === 1 ) {

			attrNames = value.split( core_rspace );

			for ( ; i < attrNames.length; i++ ) {
				name = attrNames[ i ];

				if ( name ) {
					propName = jQuery.propFix[ name ] || name;
					isBool = rboolean.test( name );

					// See #9699 for explanation of this approach (setting first, then removal)
					// Do not do this for boolean attributes (see #10870)
					if ( !isBool ) {
						jQuery.attr( elem, name, "" );
					}
					elem.removeAttribute( getSetAttribute ? name : propName );

					// Set corresponding property to false for boolean attributes
					if ( isBool && propName in elem ) {
						elem[ propName ] = false;
					}
				}
			}
		}
	},

	attrHooks: {
		type: {
			set: function( elem, value ) {
				// We can't allow the type property to be changed (since it causes problems in IE)
				if ( rtype.test( elem.nodeName ) && elem.parentNode ) {
					jQuery.error( "type property can't be changed" );
				} else if ( !jQuery.support.radioValue && value === "radio" && jQuery.nodeName(elem, "input") ) {
					// Setting the type on a radio button after the value resets the value in IE6-9
					// Reset value to it's default in case type is set after value
					// This is for element creation
					var val = elem.value;
					elem.setAttribute( "type", value );
					if ( val ) {
						elem.value = val;
					}
					return value;
				}
			}
		},
		// Use the value property for back compat
		// Use the nodeHook for button elements in IE6/7 (#1954)
		value: {
			get: function( elem, name ) {
				if ( nodeHook && jQuery.nodeName( elem, "button" ) ) {
					return nodeHook.get( elem, name );
				}
				return name in elem ?
					elem.value :
					null;
			},
			set: function( elem, value, name ) {
				if ( nodeHook && jQuery.nodeName( elem, "button" ) ) {
					return nodeHook.set( elem, value, name );
				}
				// Does not return so that setAttribute is also used
				elem.value = value;
			}
		}
	},

	propFix: {
		tabindex: "tabIndex",
		readonly: "readOnly",
		"for": "htmlFor",
		"class": "className",
		maxlength: "maxLength",
		cellspacing: "cellSpacing",
		cellpadding: "cellPadding",
		rowspan: "rowSpan",
		colspan: "colSpan",
		usemap: "useMap",
		frameborder: "frameBorder",
		contenteditable: "contentEditable"
	},

	prop: function( elem, name, value ) {
		var ret, hooks, notxml,
			nType = elem.nodeType;

		// don't get/set properties on text, comment and attribute nodes
		if ( !elem || nType === 3 || nType === 8 || nType === 2 ) {
			return;
		}

		notxml = nType !== 1 || !jQuery.isXMLDoc( elem );

		if ( notxml ) {
			// Fix name and attach hooks
			name = jQuery.propFix[ name ] || name;
			hooks = jQuery.propHooks[ name ];
		}

		if ( value !== undefined ) {
			if ( hooks && "set" in hooks && (ret = hooks.set( elem, value, name )) !== undefined ) {
				return ret;

			} else {
				return ( elem[ name ] = value );
			}

		} else {
			if ( hooks && "get" in hooks && (ret = hooks.get( elem, name )) !== null ) {
				return ret;

			} else {
				return elem[ name ];
			}
		}
	},

	propHooks: {
		tabIndex: {
			get: function( elem ) {
				// elem.tabIndex doesn't always return the correct value when it hasn't been explicitly set
				// http://fluidproject.org/blog/2008/01/09/getting-setting-and-removing-tabindex-values-with-javascript/
				var attributeNode = elem.getAttributeNode("tabindex");

				return attributeNode && attributeNode.specified ?
					parseInt( attributeNode.value, 10 ) :
					rfocusable.test( elem.nodeName ) || rclickable.test( elem.nodeName ) && elem.href ?
						0 :
						undefined;
			}
		}
	}
});

// Hook for boolean attributes
boolHook = {
	get: function( elem, name ) {
		// Align boolean attributes with corresponding properties
		// Fall back to attribute presence where some booleans are not supported
		var attrNode,
			property = jQuery.prop( elem, name );
		return property === true || typeof property !== "boolean" && ( attrNode = elem.getAttributeNode(name) ) && attrNode.nodeValue !== false ?
			name.toLowerCase() :
			undefined;
	},
	set: function( elem, value, name ) {
		var propName;
		if ( value === false ) {
			// Remove boolean attributes when set to false
			jQuery.removeAttr( elem, name );
		} else {
			// value is true since we know at this point it's type boolean and not false
			// Set boolean attributes to the same name and set the DOM property
			propName = jQuery.propFix[ name ] || name;
			if ( propName in elem ) {
				// Only set the IDL specifically if it already exists on the element
				elem[ propName ] = true;
			}

			elem.setAttribute( name, name.toLowerCase() );
		}
		return name;
	}
};

// IE6/7 do not support getting/setting some attributes with get/setAttribute
if ( !getSetAttribute ) {

	fixSpecified = {
		name: true,
		id: true,
		coords: true
	};

	// Use this for any attribute in IE6/7
	// This fixes almost every IE6/7 issue
	nodeHook = jQuery.valHooks.button = {
		get: function( elem, name ) {
			var ret;
			ret = elem.getAttributeNode( name );
			return ret && ( fixSpecified[ name ] ? ret.value !== "" : ret.specified ) ?
				ret.value :
				undefined;
		},
		set: function( elem, value, name ) {
			// Set the existing or create a new attribute node
			var ret = elem.getAttributeNode( name );
			if ( !ret ) {
				ret = document.createAttribute( name );
				elem.setAttributeNode( ret );
			}
			return ( ret.value = value + "" );
		}
	};

	// Set width and height to auto instead of 0 on empty string( Bug #8150 )
	// This is for removals
	jQuery.each([ "width", "height" ], function( i, name ) {
		jQuery.attrHooks[ name ] = jQuery.extend( jQuery.attrHooks[ name ], {
			set: function( elem, value ) {
				if ( value === "" ) {
					elem.setAttribute( name, "auto" );
					return value;
				}
			}
		});
	});

	// Set contenteditable to false on removals(#10429)
	// Setting to empty string throws an error as an invalid value
	jQuery.attrHooks.contenteditable = {
		get: nodeHook.get,
		set: function( elem, value, name ) {
			if ( value === "" ) {
				value = "false";
			}
			nodeHook.set( elem, value, name );
		}
	};
}


// Some attributes require a special call on IE
if ( !jQuery.support.hrefNormalized ) {
	jQuery.each([ "href", "src", "width", "height" ], function( i, name ) {
		jQuery.attrHooks[ name ] = jQuery.extend( jQuery.attrHooks[ name ], {
			get: function( elem ) {
				var ret = elem.getAttribute( name, 2 );
				return ret === null ? undefined : ret;
			}
		});
	});
}

if ( !jQuery.support.style ) {
	jQuery.attrHooks.style = {
		get: function( elem ) {
			// Return undefined in the case of empty string
			// Normalize to lowercase since IE uppercases css property names
			return elem.style.cssText.toLowerCase() || undefined;
		},
		set: function( elem, value ) {
			return ( elem.style.cssText = value + "" );
		}
	};
}

// Safari mis-reports the default selected property of an option
// Accessing the parent's selectedIndex property fixes it
if ( !jQuery.support.optSelected ) {
	jQuery.propHooks.selected = jQuery.extend( jQuery.propHooks.selected, {
		get: function( elem ) {
			var parent = elem.parentNode;

			if ( parent ) {
				parent.selectedIndex;

				// Make sure that it also works with optgroups, see #5701
				if ( parent.parentNode ) {
					parent.parentNode.selectedIndex;
				}
			}
			return null;
		}
	});
}

// IE6/7 call enctype encoding
if ( !jQuery.support.enctype ) {
	jQuery.propFix.enctype = "encoding";
}

// Radios and checkboxes getter/setter
if ( !jQuery.support.checkOn ) {
	jQuery.each([ "radio", "checkbox" ], function() {
		jQuery.valHooks[ this ] = {
			get: function( elem ) {
				// Handle the case where in Webkit "" is returned instead of "on" if a value isn't specified
				return elem.getAttribute("value") === null ? "on" : elem.value;
			}
		};
	});
}
jQuery.each([ "radio", "checkbox" ], function() {
	jQuery.valHooks[ this ] = jQuery.extend( jQuery.valHooks[ this ], {
		set: function( elem, value ) {
			if ( jQuery.isArray( value ) ) {
				return ( elem.checked = jQuery.inArray( jQuery(elem).val(), value ) >= 0 );
			}
		}
	});
});
var rformElems = /^(?:textarea|input|select)$/i,
	rtypenamespace = /^([^\.]*|)(?:\.(.+)|)$/,
	rhoverHack = /(?:^|\s)hover(\.\S+|)\b/,
	rkeyEvent = /^key/,
	rmouseEvent = /^(?:mouse|contextmenu)|click/,
	rfocusMorph = /^(?:focusinfocus|focusoutblur)$/,
	hoverHack = function( events ) {
		return jQuery.event.special.hover ? events : events.replace( rhoverHack, "mouseenter$1 mouseleave$1" );
	};

/*
 * Helper functions for managing events -- not part of the public interface.
 * Props to Dean Edwards' addEvent library for many of the ideas.
 */
jQuery.event = {

	add: function( elem, types, handler, data, selector ) {

		var elemData, eventHandle, events,
			t, tns, type, namespaces, handleObj,
			handleObjIn, handlers, special;

		// Don't attach events to noData or text/comment nodes (allow plain objects tho)
		if ( elem.nodeType === 3 || elem.nodeType === 8 || !types || !handler || !(elemData = jQuery._data( elem )) ) {
			return;
		}

		// Caller can pass in an object of custom data in lieu of the handler
		if ( handler.handler ) {
			handleObjIn = handler;
			handler = handleObjIn.handler;
			selector = handleObjIn.selector;
		}

		// Make sure that the handler has a unique ID, used to find/remove it later
		if ( !handler.guid ) {
			handler.guid = jQuery.guid++;
		}

		// Init the element's event structure and main handler, if this is the first
		events = elemData.events;
		if ( !events ) {
			elemData.events = events = {};
		}
		eventHandle = elemData.handle;
		if ( !eventHandle ) {
			elemData.handle = eventHandle = function( e ) {
				// Discard the second event of a jQuery.event.trigger() and
				// when an event is called after a page has unloaded
				return typeof jQuery !== "undefined" && (!e || jQuery.event.triggered !== e.type) ?
					jQuery.event.dispatch.apply( eventHandle.elem, arguments ) :
					undefined;
			};
			// Add elem as a property of the handle fn to prevent a memory leak with IE non-native events
			eventHandle.elem = elem;
		}

		// Handle multiple events separated by a space
		// jQuery(...).bind("mouseover mouseout", fn);
		types = jQuery.trim( hoverHack(types) ).split( " " );
		for ( t = 0; t < types.length; t++ ) {

			tns = rtypenamespace.exec( types[t] ) || [];
			type = tns[1];
			namespaces = ( tns[2] || "" ).split( "." ).sort();

			// If event changes its type, use the special event handlers for the changed type
			special = jQuery.event.special[ type ] || {};

			// If selector defined, determine special event api type, otherwise given type
			type = ( selector ? special.delegateType : special.bindType ) || type;

			// Update special based on newly reset type
			special = jQuery.event.special[ type ] || {};

			// handleObj is passed to all event handlers
			handleObj = jQuery.extend({
				type: type,
				origType: tns[1],
				data: data,
				handler: handler,
				guid: handler.guid,
				selector: selector,
				needsContext: selector && jQuery.expr.match.needsContext.test( selector ),
				namespace: namespaces.join(".")
			}, handleObjIn );

			// Init the event handler queue if we're the first
			handlers = events[ type ];
			if ( !handlers ) {
				handlers = events[ type ] = [];
				handlers.delegateCount = 0;

				// Only use addEventListener/attachEvent if the special events handler returns false
				if ( !special.setup || special.setup.call( elem, data, namespaces, eventHandle ) === false ) {
					// Bind the global event handler to the element
					if ( elem.addEventListener ) {
						elem.addEventListener( type, eventHandle, false );

					} else if ( elem.attachEvent ) {
						elem.attachEvent( "on" + type, eventHandle );
					}
				}
			}

			if ( special.add ) {
				special.add.call( elem, handleObj );

				if ( !handleObj.handler.guid ) {
					handleObj.handler.guid = handler.guid;
				}
			}

			// Add to the element's handler list, delegates in front
			if ( selector ) {
				handlers.splice( handlers.delegateCount++, 0, handleObj );
			} else {
				handlers.push( handleObj );
			}

			// Keep track of which events have ever been used, for event optimization
			jQuery.event.global[ type ] = true;
		}

		// Nullify elem to prevent memory leaks in IE
		elem = null;
	},

	global: {},

	// Detach an event or set of events from an element
	remove: function( elem, types, handler, selector, mappedTypes ) {

		var t, tns, type, origType, namespaces, origCount,
			j, events, special, eventType, handleObj,
			elemData = jQuery.hasData( elem ) && jQuery._data( elem );

		if ( !elemData || !(events = elemData.events) ) {
			return;
		}

		// Once for each type.namespace in types; type may be omitted
		types = jQuery.trim( hoverHack( types || "" ) ).split(" ");
		for ( t = 0; t < types.length; t++ ) {
			tns = rtypenamespace.exec( types[t] ) || [];
			type = origType = tns[1];
			namespaces = tns[2];

			// Unbind all events (on this namespace, if provided) for the element
			if ( !type ) {
				for ( type in events ) {
					jQuery.event.remove( elem, type + types[ t ], handler, selector, true );
				}
				continue;
			}

			special = jQuery.event.special[ type ] || {};
			type = ( selector? special.delegateType : special.bindType ) || type;
			eventType = events[ type ] || [];
			origCount = eventType.length;
			namespaces = namespaces ? new RegExp("(^|\\.)" + namespaces.split(".").sort().join("\\.(?:.*\\.|)") + "(\\.|$)") : null;

			// Remove matching events
			for ( j = 0; j < eventType.length; j++ ) {
				handleObj = eventType[ j ];

				if ( ( mappedTypes || origType === handleObj.origType ) &&
					 ( !handler || handler.guid === handleObj.guid ) &&
					 ( !namespaces || namespaces.test( handleObj.namespace ) ) &&
					 ( !selector || selector === handleObj.selector || selector === "**" && handleObj.selector ) ) {
					eventType.splice( j--, 1 );

					if ( handleObj.selector ) {
						eventType.delegateCount--;
					}
					if ( special.remove ) {
						special.remove.call( elem, handleObj );
					}
				}
			}

			// Remove generic event handler if we removed something and no more handlers exist
			// (avoids potential for endless recursion during removal of special event handlers)
			if ( eventType.length === 0 && origCount !== eventType.length ) {
				if ( !special.teardown || special.teardown.call( elem, namespaces, elemData.handle ) === false ) {
					jQuery.removeEvent( elem, type, elemData.handle );
				}

				delete events[ type ];
			}
		}

		// Remove the expando if it's no longer used
		if ( jQuery.isEmptyObject( events ) ) {
			delete elemData.handle;

			// removeData also checks for emptiness and clears the expando if empty
			// so use it instead of delete
			jQuery.removeData( elem, "events", true );
		}
	},

	// Events that are safe to short-circuit if no handlers are attached.
	// Native DOM events should not be added, they may have inline handlers.
	customEvent: {
		"getData": true,
		"setData": true,
		"changeData": true
	},

	trigger: function( event, data, elem, onlyHandlers ) {
		// Don't do events on text and comment nodes
		if ( elem && (elem.nodeType === 3 || elem.nodeType === 8) ) {
			return;
		}

		// Event object or event type
		var cache, exclusive, i, cur, old, ontype, special, handle, eventPath, bubbleType,
			type = event.type || event,
			namespaces = [];

		// focus/blur morphs to focusin/out; ensure we're not firing them right now
		if ( rfocusMorph.test( type + jQuery.event.triggered ) ) {
			return;
		}

		if ( type.indexOf( "!" ) >= 0 ) {
			// Exclusive events trigger only for the exact event (no namespaces)
			type = type.slice(0, -1);
			exclusive = true;
		}

		if ( type.indexOf( "." ) >= 0 ) {
			// Namespaced trigger; create a regexp to match event type in handle()
			namespaces = type.split(".");
			type = namespaces.shift();
			namespaces.sort();
		}

		if ( (!elem || jQuery.event.customEvent[ type ]) && !jQuery.event.global[ type ] ) {
			// No jQuery handlers for this event type, and it can't have inline handlers
			return;
		}

		// Caller can pass in an Event, Object, or just an event type string
		event = typeof event === "object" ?
			// jQuery.Event object
			event[ jQuery.expando ] ? event :
			// Object literal
			new jQuery.Event( type, event ) :
			// Just the event type (string)
			new jQuery.Event( type );

		event.type = type;
		event.isTrigger = true;
		event.exclusive = exclusive;
		event.namespace = namespaces.join( "." );
		event.namespace_re = event.namespace? new RegExp("(^|\\.)" + namespaces.join("\\.(?:.*\\.|)") + "(\\.|$)") : null;
		ontype = type.indexOf( ":" ) < 0 ? "on" + type : "";

		// Handle a global trigger
		if ( !elem ) {

			// TODO: Stop taunting the data cache; remove global events and always attach to document
			cache = jQuery.cache;
			for ( i in cache ) {
				if ( cache[ i ].events && cache[ i ].events[ type ] ) {
					jQuery.event.trigger( event, data, cache[ i ].handle.elem, true );
				}
			}
			return;
		}

		// Clean up the event in case it is being reused
		event.result = undefined;
		if ( !event.target ) {
			event.target = elem;
		}

		// Clone any incoming data and prepend the event, creating the handler arg list
		data = data != null ? jQuery.makeArray( data ) : [];
		data.unshift( event );

		// Allow special events to draw outside the lines
		special = jQuery.event.special[ type ] || {};
		if ( special.trigger && special.trigger.apply( elem, data ) === false ) {
			return;
		}

		// Determine event propagation path in advance, per W3C events spec (#9951)
		// Bubble up to document, then to window; watch for a global ownerDocument var (#9724)
		eventPath = [[ elem, special.bindType || type ]];
		if ( !onlyHandlers && !special.noBubble && !jQuery.isWindow( elem ) ) {

			bubbleType = special.delegateType || type;
			cur = rfocusMorph.test( bubbleType + type ) ? elem : elem.parentNode;
			for ( old = elem; cur; cur = cur.parentNode ) {
				eventPath.push([ cur, bubbleType ]);
				old = cur;
			}

			// Only add window if we got to document (e.g., not plain obj or detached DOM)
			if ( old === (elem.ownerDocument || document) ) {
				eventPath.push([ old.defaultView || old.parentWindow || window, bubbleType ]);
			}
		}

		// Fire handlers on the event path
		for ( i = 0; i < eventPath.length && !event.isPropagationStopped(); i++ ) {

			cur = eventPath[i][0];
			event.type = eventPath[i][1];

			handle = ( jQuery._data( cur, "events" ) || {} )[ event.type ] && jQuery._data( cur, "handle" );
			if ( handle ) {
				handle.apply( cur, data );
			}
			// Note that this is a bare JS function and not a jQuery handler
			handle = ontype && cur[ ontype ];
			if ( handle && jQuery.acceptData( cur ) && handle.apply && handle.apply( cur, data ) === false ) {
				event.preventDefault();
			}
		}
		event.type = type;

		// If nobody prevented the default action, do it now
		if ( !onlyHandlers && !event.isDefaultPrevented() ) {

			if ( (!special._default || special._default.apply( elem.ownerDocument, data ) === false) &&
				!(type === "click" && jQuery.nodeName( elem, "a" )) && jQuery.acceptData( elem ) ) {

				// Call a native DOM method on the target with the same name name as the event.
				// Can't use an .isFunction() check here because IE6/7 fails that test.
				// Don't do default actions on window, that's where global variables be (#6170)
				// IE<9 dies on focus/blur to hidden element (#1486)
				if ( ontype && elem[ type ] && ((type !== "focus" && type !== "blur") || event.target.offsetWidth !== 0) && !jQuery.isWindow( elem ) ) {

					// Don't re-trigger an onFOO event when we call its FOO() method
					old = elem[ ontype ];

					if ( old ) {
						elem[ ontype ] = null;
					}

					// Prevent re-triggering of the same event, since we already bubbled it above
					jQuery.event.triggered = type;
					elem[ type ]();
					jQuery.event.triggered = undefined;

					if ( old ) {
						elem[ ontype ] = old;
					}
				}
			}
		}

		return event.result;
	},

	dispatch: function( event ) {

		// Make a writable jQuery.Event from the native event object
		event = jQuery.event.fix( event || window.event );

		var i, j, cur, ret, selMatch, matched, matches, handleObj, sel, related,
			handlers = ( (jQuery._data( this, "events" ) || {} )[ event.type ] || []),
			delegateCount = handlers.delegateCount,
			args = core_slice.call( arguments ),
			run_all = !event.exclusive && !event.namespace,
			special = jQuery.event.special[ event.type ] || {},
			handlerQueue = [];

		// Use the fix-ed jQuery.Event rather than the (read-only) native event
		args[0] = event;
		event.delegateTarget = this;

		// Call the preDispatch hook for the mapped type, and let it bail if desired
		if ( special.preDispatch && special.preDispatch.call( this, event ) === false ) {
			return;
		}

		// Determine handlers that should run if there are delegated events
		// Avoid non-left-click bubbling in Firefox (#3861)
		if ( delegateCount && !(event.button && event.type === "click") ) {

			for ( cur = event.target; cur != this; cur = cur.parentNode || this ) {

				// Don't process clicks (ONLY) on disabled elements (#6911, #8165, #11382, #11764)
				if ( cur.disabled !== true || event.type !== "click" ) {
					selMatch = {};
					matches = [];
					for ( i = 0; i < delegateCount; i++ ) {
						handleObj = handlers[ i ];
						sel = handleObj.selector;

						if ( selMatch[ sel ] === undefined ) {
							selMatch[ sel ] = handleObj.needsContext ?
								jQuery( sel, this ).index( cur ) >= 0 :
								jQuery.find( sel, this, null, [ cur ] ).length;
						}
						if ( selMatch[ sel ] ) {
							matches.push( handleObj );
						}
					}
					if ( matches.length ) {
						handlerQueue.push({ elem: cur, matches: matches });
					}
				}
			}
		}

		// Add the remaining (directly-bound) handlers
		if ( handlers.length > delegateCount ) {
			handlerQueue.push({ elem: this, matches: handlers.slice( delegateCount ) });
		}

		// Run delegates first; they may want to stop propagation beneath us
		for ( i = 0; i < handlerQueue.length && !event.isPropagationStopped(); i++ ) {
			matched = handlerQueue[ i ];
			event.currentTarget = matched.elem;

			for ( j = 0; j < matched.matches.length && !event.isImmediatePropagationStopped(); j++ ) {
				handleObj = matched.matches[ j ];

				// Triggered event must either 1) be non-exclusive and have no namespace, or
				// 2) have namespace(s) a subset or equal to those in the bound event (both can have no namespace).
				if ( run_all || (!event.namespace && !handleObj.namespace) || event.namespace_re && event.namespace_re.test( handleObj.namespace ) ) {

					event.data = handleObj.data;
					event.handleObj = handleObj;

					ret = ( (jQuery.event.special[ handleObj.origType ] || {}).handle || handleObj.handler )
							.apply( matched.elem, args );

					if ( ret !== undefined ) {
						event.result = ret;
						if ( ret === false ) {
							event.preventDefault();
							event.stopPropagation();
						}
					}
				}
			}
		}

		// Call the postDispatch hook for the mapped type
		if ( special.postDispatch ) {
			special.postDispatch.call( this, event );
		}

		return event.result;
	},

	// Includes some event props shared by KeyEvent and MouseEvent
	// *** attrChange attrName relatedNode srcElement  are not normalized, non-W3C, deprecated, will be removed in 1.8 ***
	props: "attrChange attrName relatedNode srcElement altKey bubbles cancelable ctrlKey currentTarget eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),

	fixHooks: {},

	keyHooks: {
		props: "char charCode key keyCode".split(" "),
		filter: function( event, original ) {

			// Add which for key events
			if ( event.which == null ) {
				event.which = original.charCode != null ? original.charCode : original.keyCode;
			}

			return event;
		}
	},

	mouseHooks: {
		props: "button buttons clientX clientY fromElement offsetX offsetY pageX pageY screenX screenY toElement".split(" "),
		filter: function( event, original ) {
			var eventDoc, doc, body,
				button = original.button,
				fromElement = original.fromElement;

			// Calculate pageX/Y if missing and clientX/Y available
			if ( event.pageX == null && original.clientX != null ) {
				eventDoc = event.target.ownerDocument || document;
				doc = eventDoc.documentElement;
				body = eventDoc.body;

				event.pageX = original.clientX + ( doc && doc.scrollLeft || body && body.scrollLeft || 0 ) - ( doc && doc.clientLeft || body && body.clientLeft || 0 );
				event.pageY = original.clientY + ( doc && doc.scrollTop  || body && body.scrollTop  || 0 ) - ( doc && doc.clientTop  || body && body.clientTop  || 0 );
			}

			// Add relatedTarget, if necessary
			if ( !event.relatedTarget && fromElement ) {
				event.relatedTarget = fromElement === event.target ? original.toElement : fromElement;
			}

			// Add which for click: 1 === left; 2 === middle; 3 === right
			// Note: button is not normalized, so don't use it
			if ( !event.which && button !== undefined ) {
				event.which = ( button & 1 ? 1 : ( button & 2 ? 3 : ( button & 4 ? 2 : 0 ) ) );
			}

			return event;
		}
	},

	fix: function( event ) {
		if ( event[ jQuery.expando ] ) {
			return event;
		}

		// Create a writable copy of the event object and normalize some properties
		var i, prop,
			originalEvent = event,
			fixHook = jQuery.event.fixHooks[ event.type ] || {},
			copy = fixHook.props ? this.props.concat( fixHook.props ) : this.props;

		event = jQuery.Event( originalEvent );

		for ( i = copy.length; i; ) {
			prop = copy[ --i ];
			event[ prop ] = originalEvent[ prop ];
		}

		// Fix target property, if necessary (#1925, IE 6/7/8 & Safari2)
		if ( !event.target ) {
			event.target = originalEvent.srcElement || document;
		}

		// Target should not be a text node (#504, Safari)
		if ( event.target.nodeType === 3 ) {
			event.target = event.target.parentNode;
		}

		// For mouse/key events, metaKey==false if it's undefined (#3368, #11328; IE6/7/8)
		event.metaKey = !!event.metaKey;

		return fixHook.filter? fixHook.filter( event, originalEvent ) : event;
	},

	special: {
		load: {
			// Prevent triggered image.load events from bubbling to window.load
			noBubble: true
		},

		focus: {
			delegateType: "focusin"
		},
		blur: {
			delegateType: "focusout"
		},

		beforeunload: {
			setup: function( data, namespaces, eventHandle ) {
				// We only want to do this special case on windows
				if ( jQuery.isWindow( this ) ) {
					this.onbeforeunload = eventHandle;
				}
			},

			teardown: function( namespaces, eventHandle ) {
				if ( this.onbeforeunload === eventHandle ) {
					this.onbeforeunload = null;
				}
			}
		}
	},

	simulate: function( type, elem, event, bubble ) {
		// Piggyback on a donor event to simulate a different one.
		// Fake originalEvent to avoid donor's stopPropagation, but if the
		// simulated event prevents default then we do the same on the donor.
		var e = jQuery.extend(
			new jQuery.Event(),
			event,
			{ type: type,
				isSimulated: true,
				originalEvent: {}
			}
		);
		if ( bubble ) {
			jQuery.event.trigger( e, null, elem );
		} else {
			jQuery.event.dispatch.call( elem, e );
		}
		if ( e.isDefaultPrevented() ) {
			event.preventDefault();
		}
	}
};

// Some plugins are using, but it's undocumented/deprecated and will be removed.
// The 1.7 special event interface should provide all the hooks needed now.
jQuery.event.handle = jQuery.event.dispatch;

jQuery.removeEvent = document.removeEventListener ?
	function( elem, type, handle ) {
		if ( elem.removeEventListener ) {
			elem.removeEventListener( type, handle, false );
		}
	} :
	function( elem, type, handle ) {
		var name = "on" + type;

		if ( elem.detachEvent ) {

			// #8545, #7054, preventing memory leaks for custom events in IE6-8
			// detachEvent needed property on element, by name of that event, to properly expose it to GC
			if ( typeof elem[ name ] === "undefined" ) {
				elem[ name ] = null;
			}

			elem.detachEvent( name, handle );
		}
	};

jQuery.Event = function( src, props ) {
	// Allow instantiation without the 'new' keyword
	if ( !(this instanceof jQuery.Event) ) {
		return new jQuery.Event( src, props );
	}

	// Event object
	if ( src && src.type ) {
		this.originalEvent = src;
		this.type = src.type;

		// Events bubbling up the document may have been marked as prevented
		// by a handler lower down the tree; reflect the correct value.
		this.isDefaultPrevented = ( src.defaultPrevented || src.returnValue === false ||
			src.getPreventDefault && src.getPreventDefault() ) ? returnTrue : returnFalse;

	// Event type
	} else {
		this.type = src;
	}

	// Put explicitly provided properties onto the event object
	if ( props ) {
		jQuery.extend( this, props );
	}

	// Create a timestamp if incoming event doesn't have one
	this.timeStamp = src && src.timeStamp || jQuery.now();

	// Mark it as fixed
	this[ jQuery.expando ] = true;
};

function returnFalse() {
	return false;
}
function returnTrue() {
	return true;
}

// jQuery.Event is based on DOM3 Events as specified by the ECMAScript Language Binding
// http://www.w3.org/TR/2003/WD-DOM-Level-3-Events-20030331/ecma-script-binding.html
jQuery.Event.prototype = {
	preventDefault: function() {
		this.isDefaultPrevented = returnTrue;

		var e = this.originalEvent;
		if ( !e ) {
			return;
		}

		// if preventDefault exists run it on the original event
		if ( e.preventDefault ) {
			e.preventDefault();

		// otherwise set the returnValue property of the original event to false (IE)
		} else {
			e.returnValue = false;
		}
	},
	stopPropagation: function() {
		this.isPropagationStopped = returnTrue;

		var e = this.originalEvent;
		if ( !e ) {
			return;
		}
		// if stopPropagation exists run it on the original event
		if ( e.stopPropagation ) {
			e.stopPropagation();
		}
		// otherwise set the cancelBubble property of the original event to true (IE)
		e.cancelBubble = true;
	},
	stopImmediatePropagation: function() {
		this.isImmediatePropagationStopped = returnTrue;
		this.stopPropagation();
	},
	isDefaultPrevented: returnFalse,
	isPropagationStopped: returnFalse,
	isImmediatePropagationStopped: returnFalse
};

// Create mouseenter/leave events using mouseover/out and event-time checks
jQuery.each({
	mouseenter: "mouseover",
	mouseleave: "mouseout"
}, function( orig, fix ) {
	jQuery.event.special[ orig ] = {
		delegateType: fix,
		bindType: fix,

		handle: function( event ) {
			var ret,
				target = this,
				related = event.relatedTarget,
				handleObj = event.handleObj,
				selector = handleObj.selector;

			// For mousenter/leave call the handler if related is outside the target.
			// NB: No relatedTarget if the mouse left/entered the browser window
			if ( !related || (related !== target && !jQuery.contains( target, related )) ) {
				event.type = handleObj.origType;
				ret = handleObj.handler.apply( this, arguments );
				event.type = fix;
			}
			return ret;
		}
	};
});

// IE submit delegation
if ( !jQuery.support.submitBubbles ) {

	jQuery.event.special.submit = {
		setup: function() {
			// Only need this for delegated form submit events
			if ( jQuery.nodeName( this, "form" ) ) {
				return false;
			}

			// Lazy-add a submit handler when a descendant form may potentially be submitted
			jQuery.event.add( this, "click._submit keypress._submit", function( e ) {
				// Node name check avoids a VML-related crash in IE (#9807)
				var elem = e.target,
					form = jQuery.nodeName( elem, "input" ) || jQuery.nodeName( elem, "button" ) ? elem.form : undefined;
				if ( form && !jQuery._data( form, "_submit_attached" ) ) {
					jQuery.event.add( form, "submit._submit", function( event ) {
						event._submit_bubble = true;
					});
					jQuery._data( form, "_submit_attached", true );
				}
			});
			// return undefined since we don't need an event listener
		},

		postDispatch: function( event ) {
			// If form was submitted by the user, bubble the event up the tree
			if ( event._submit_bubble ) {
				delete event._submit_bubble;
				if ( this.parentNode && !event.isTrigger ) {
					jQuery.event.simulate( "submit", this.parentNode, event, true );
				}
			}
		},

		teardown: function() {
			// Only need this for delegated form submit events
			if ( jQuery.nodeName( this, "form" ) ) {
				return false;
			}

			// Remove delegated handlers; cleanData eventually reaps submit handlers attached above
			jQuery.event.remove( this, "._submit" );
		}
	};
}

// IE change delegation and checkbox/radio fix
if ( !jQuery.support.changeBubbles ) {

	jQuery.event.special.change = {

		setup: function() {

			if ( rformElems.test( this.nodeName ) ) {
				// IE doesn't fire change on a check/radio until blur; trigger it on click
				// after a propertychange. Eat the blur-change in special.change.handle.
				// This still fires onchange a second time for check/radio after blur.
				if ( this.type === "checkbox" || this.type === "radio" ) {
					jQuery.event.add( this, "propertychange._change", function( event ) {
						if ( event.originalEvent.propertyName === "checked" ) {
							this._just_changed = true;
						}
					});
					jQuery.event.add( this, "click._change", function( event ) {
						if ( this._just_changed && !event.isTrigger ) {
							this._just_changed = false;
						}
						// Allow triggered, simulated change events (#11500)
						jQuery.event.simulate( "change", this, event, true );
					});
				}
				return false;
			}
			// Delegated event; lazy-add a change handler on descendant inputs
			jQuery.event.add( this, "beforeactivate._change", function( e ) {
				var elem = e.target;

				if ( rformElems.test( elem.nodeName ) && !jQuery._data( elem, "_change_attached" ) ) {
					jQuery.event.add( elem, "change._change", function( event ) {
						if ( this.parentNode && !event.isSimulated && !event.isTrigger ) {
							jQuery.event.simulate( "change", this.parentNode, event, true );
						}
					});
					jQuery._data( elem, "_change_attached", true );
				}
			});
		},

		handle: function( event ) {
			var elem = event.target;

			// Swallow native change events from checkbox/radio, we already triggered them above
			if ( this !== elem || event.isSimulated || event.isTrigger || (elem.type !== "radio" && elem.type !== "checkbox") ) {
				return event.handleObj.handler.apply( this, arguments );
			}
		},

		teardown: function() {
			jQuery.event.remove( this, "._change" );

			return !rformElems.test( this.nodeName );
		}
	};
}

// Create "bubbling" focus and blur events
if ( !jQuery.support.focusinBubbles ) {
	jQuery.each({ focus: "focusin", blur: "focusout" }, function( orig, fix ) {

		// Attach a single capturing handler while someone wants focusin/focusout
		var attaches = 0,
			handler = function( event ) {
				jQuery.event.simulate( fix, event.target, jQuery.event.fix( event ), true );
			};

		jQuery.event.special[ fix ] = {
			setup: function() {
				if ( attaches++ === 0 ) {
					document.addEventListener( orig, handler, true );
				}
			},
			teardown: function() {
				if ( --attaches === 0 ) {
					document.removeEventListener( orig, handler, true );
				}
			}
		};
	});
}

jQuery.fn.extend({

	on: function( types, selector, data, fn, /*INTERNAL*/ one ) {
		var origFn, type;

		// Types can be a map of types/handlers
		if ( typeof types === "object" ) {
			// ( types-Object, selector, data )
			if ( typeof selector !== "string" ) { // && selector != null
				// ( types-Object, data )
				data = data || selector;
				selector = undefined;
			}
			for ( type in types ) {
				this.on( type, selector, data, types[ type ], one );
			}
			return this;
		}

		if ( data == null && fn == null ) {
			// ( types, fn )
			fn = selector;
			data = selector = undefined;
		} else if ( fn == null ) {
			if ( typeof selector === "string" ) {
				// ( types, selector, fn )
				fn = data;
				data = undefined;
			} else {
				// ( types, data, fn )
				fn = data;
				data = selector;
				selector = undefined;
			}
		}
		if ( fn === false ) {
			fn = returnFalse;
		} else if ( !fn ) {
			return this;
		}

		if ( one === 1 ) {
			origFn = fn;
			fn = function( event ) {
				// Can use an empty set, since event contains the info
				jQuery().off( event );
				return origFn.apply( this, arguments );
			};
			// Use same guid so caller can remove using origFn
			fn.guid = origFn.guid || ( origFn.guid = jQuery.guid++ );
		}
		return this.each( function() {
			jQuery.event.add( this, types, fn, data, selector );
		});
	},
	one: function( types, selector, data, fn ) {
		return this.on( types, selector, data, fn, 1 );
	},
	off: function( types, selector, fn ) {
		var handleObj, type;
		if ( types && types.preventDefault && types.handleObj ) {
			// ( event )  dispatched jQuery.Event
			handleObj = types.handleObj;
			jQuery( types.delegateTarget ).off(
				handleObj.namespace ? handleObj.origType + "." + handleObj.namespace : handleObj.origType,
				handleObj.selector,
				handleObj.handler
			);
			return this;
		}
		if ( typeof types === "object" ) {
			// ( types-object [, selector] )
			for ( type in types ) {
				this.off( type, selector, types[ type ] );
			}
			return this;
		}
		if ( selector === false || typeof selector === "function" ) {
			// ( types [, fn] )
			fn = selector;
			selector = undefined;
		}
		if ( fn === false ) {
			fn = returnFalse;
		}
		return this.each(function() {
			jQuery.event.remove( this, types, fn, selector );
		});
	},

	bind: function( types, data, fn ) {
		return this.on( types, null, data, fn );
	},
	unbind: function( types, fn ) {
		return this.off( types, null, fn );
	},

	live: function( types, data, fn ) {
		jQuery( this.context ).on( types, this.selector, data, fn );
		return this;
	},
	die: function( types, fn ) {
		jQuery( this.context ).off( types, this.selector || "**", fn );
		return this;
	},

	delegate: function( selector, types, data, fn ) {
		return this.on( types, selector, data, fn );
	},
	undelegate: function( selector, types, fn ) {
		// ( namespace ) or ( selector, types [, fn] )
		return arguments.length === 1 ? this.off( selector, "**" ) : this.off( types, selector || "**", fn );
	},

	trigger: function( type, data ) {
		return this.each(function() {
			jQuery.event.trigger( type, data, this );
		});
	},
	triggerHandler: function( type, data ) {
		if ( this[0] ) {
			return jQuery.event.trigger( type, data, this[0], true );
		}
	},

	toggle: function( fn ) {
		// Save reference to arguments for access in closure
		var args = arguments,
			guid = fn.guid || jQuery.guid++,
			i = 0,
			toggler = function( event ) {
				// Figure out which function to execute
				var lastToggle = ( jQuery._data( this, "lastToggle" + fn.guid ) || 0 ) % i;
				jQuery._data( this, "lastToggle" + fn.guid, lastToggle + 1 );

				// Make sure that clicks stop
				event.preventDefault();

				// and execute the function
				return args[ lastToggle ].apply( this, arguments ) || false;
			};

		// link all the functions, so any of them can unbind this click handler
		toggler.guid = guid;
		while ( i < args.length ) {
			args[ i++ ].guid = guid;
		}

		return this.click( toggler );
	},

	hover: function( fnOver, fnOut ) {
		return this.mouseenter( fnOver ).mouseleave( fnOut || fnOver );
	}
});

jQuery.each( ("blur focus focusin focusout load resize scroll unload click dblclick " +
	"mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave " +
	"change select submit keydown keypress keyup error contextmenu").split(" "), function( i, name ) {

	// Handle event binding
	jQuery.fn[ name ] = function( data, fn ) {
		if ( fn == null ) {
			fn = data;
			data = null;
		}

		return arguments.length > 0 ?
			this.on( name, null, data, fn ) :
			this.trigger( name );
	};

	if ( rkeyEvent.test( name ) ) {
		jQuery.event.fixHooks[ name ] = jQuery.event.keyHooks;
	}

	if ( rmouseEvent.test( name ) ) {
		jQuery.event.fixHooks[ name ] = jQuery.event.mouseHooks;
	}
});
/*!
 * Sizzle CSS Selector Engine
 * Copyright 2012 jQuery Foundation and other contributors
 * Released under the MIT license
 * http://sizzlejs.com/
 */
(function( window, undefined ) {

var cachedruns,
	assertGetIdNotName,
	Expr,
	getText,
	isXML,
	contains,
	compile,
	sortOrder,
	hasDuplicate,
	outermostContext,

	baseHasDuplicate = true,
	strundefined = "undefined",

	expando = ( "sizcache" + Math.random() ).replace( ".", "" ),

	Token = String,
	document = window.document,
	docElem = document.documentElement,
	dirruns = 0,
	done = 0,
	pop = [].pop,
	push = [].push,
	slice = [].slice,
	// Use a stripped-down indexOf if a native one is unavailable
	indexOf = [].indexOf || function( elem ) {
		var i = 0,
			len = this.length;
		for ( ; i < len; i++ ) {
			if ( this[i] === elem ) {
				return i;
			}
		}
		return -1;
	},

	// Augment a function for special use by Sizzle
	markFunction = function( fn, value ) {
		fn[ expando ] = value == null || value;
		return fn;
	},

	createCache = function() {
		var cache = {},
			keys = [];

		return markFunction(function( key, value ) {
			// Only keep the most recent entries
			if ( keys.push( key ) > Expr.cacheLength ) {
				delete cache[ keys.shift() ];
			}

			// Retrieve with (key + " ") to avoid collision with native Object.prototype properties (see Issue #157)
			return (cache[ key + " " ] = value);
		}, cache );
	},

	classCache = createCache(),
	tokenCache = createCache(),
	compilerCache = createCache(),

	// Regex

	// Whitespace characters http://www.w3.org/TR/css3-selectors/#whitespace
	whitespace = "[\\x20\\t\\r\\n\\f]",
	// http://www.w3.org/TR/css3-syntax/#characters
	characterEncoding = "(?:\\\\.|[-\\w]|[^\\x00-\\xa0])+",

	// Loosely modeled on CSS identifier characters
	// An unquoted value should be a CSS identifier (http://www.w3.org/TR/css3-selectors/#attribute-selectors)
	// Proper syntax: http://www.w3.org/TR/CSS21/syndata.html#value-def-identifier
	identifier = characterEncoding.replace( "w", "w#" ),

	// Acceptable operators http://www.w3.org/TR/selectors/#attribute-selectors
	operators = "([*^$|!~]?=)",
	attributes = "\\[" + whitespace + "*(" + characterEncoding + ")" + whitespace +
		"*(?:" + operators + whitespace + "*(?:(['\"])((?:\\\\.|[^\\\\])*?)\\3|(" + identifier + ")|)|)" + whitespace + "*\\]",

	// Prefer arguments not in parens/brackets,
	//   then attribute selectors and non-pseudos (denoted by :),
	//   then anything else
	// These preferences are here to reduce the number of selectors
	//   needing tokenize in the PSEUDO preFilter
	pseudos = ":(" + characterEncoding + ")(?:\\((?:(['\"])((?:\\\\.|[^\\\\])*?)\\2|([^()[\\]]*|(?:(?:" + attributes + ")|[^:]|\\\\.)*|.*))\\)|)",

	// For matchExpr.POS and matchExpr.needsContext
	pos = ":(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + whitespace +
		"*((?:-\\d)?\\d*)" + whitespace + "*\\)|)(?=[^-]|$)",

	// Leading and non-escaped trailing whitespace, capturing some non-whitespace characters preceding the latter
	rtrim = new RegExp( "^" + whitespace + "+|((?:^|[^\\\\])(?:\\\\.)*)" + whitespace + "+$", "g" ),

	rcomma = new RegExp( "^" + whitespace + "*," + whitespace + "*" ),
	rcombinators = new RegExp( "^" + whitespace + "*([\\x20\\t\\r\\n\\f>+~])" + whitespace + "*" ),
	rpseudo = new RegExp( pseudos ),

	// Easily-parseable/retrievable ID or TAG or CLASS selectors
	rquickExpr = /^(?:#([\w\-]+)|(\w+)|\.([\w\-]+))$/,

	rnot = /^:not/,
	rsibling = /[\x20\t\r\n\f]*[+~]/,
	rendsWithNot = /:not\($/,

	rheader = /h\d/i,
	rinputs = /input|select|textarea|button/i,

	rbackslash = /\\(?!\\)/g,

	matchExpr = {
		"ID": new RegExp( "^#(" + characterEncoding + ")" ),
		"CLASS": new RegExp( "^\\.(" + characterEncoding + ")" ),
		"NAME": new RegExp( "^\\[name=['\"]?(" + characterEncoding + ")['\"]?\\]" ),
		"TAG": new RegExp( "^(" + characterEncoding.replace( "w", "w*" ) + ")" ),
		"ATTR": new RegExp( "^" + attributes ),
		"PSEUDO": new RegExp( "^" + pseudos ),
		"POS": new RegExp( pos, "i" ),
		"CHILD": new RegExp( "^:(only|nth|first|last)-child(?:\\(" + whitespace +
			"*(even|odd|(([+-]|)(\\d*)n|)" + whitespace + "*(?:([+-]|)" + whitespace +
			"*(\\d+)|))" + whitespace + "*\\)|)", "i" ),
		// For use in libraries implementing .is()
		"needsContext": new RegExp( "^" + whitespace + "*[>+~]|" + pos, "i" )
	},

	// Support

	// Used for testing something on an element
	assert = function( fn ) {
		var div = document.createElement("div");

		try {
			return fn( div );
		} catch (e) {
			return false;
		} finally {
			// release memory in IE
			div = null;
		}
	},

	// Check if getElementsByTagName("*") returns only elements
	assertTagNameNoComments = assert(function( div ) {
		div.appendChild( document.createComment("") );
		return !div.getElementsByTagName("*").length;
	}),

	// Check if getAttribute returns normalized href attributes
	assertHrefNotNormalized = assert(function( div ) {
		div.innerHTML = "<a href='#'></a>";
		return div.firstChild && typeof div.firstChild.getAttribute !== strundefined &&
			div.firstChild.getAttribute("href") === "#";
	}),

	// Check if attributes should be retrieved by attribute nodes
	assertAttributes = assert(function( div ) {
		div.innerHTML = "<select></select>";
		var type = typeof div.lastChild.getAttribute("multiple");
		// IE8 returns a string for some attributes even when not present
		return type !== "boolean" && type !== "string";
	}),

	// Check if getElementsByClassName can be trusted
	assertUsableClassName = assert(function( div ) {
		// Opera can't find a second classname (in 9.6)
		div.innerHTML = "<div class='hidden e'></div><div class='hidden'></div>";
		if ( !div.getElementsByClassName || !div.getElementsByClassName("e").length ) {
			return false;
		}

		// Safari 3.2 caches class attributes and doesn't catch changes
		div.lastChild.className = "e";
		return div.getElementsByClassName("e").length === 2;
	}),

	// Check if getElementById returns elements by name
	// Check if getElementsByName privileges form controls or returns elements by ID
	assertUsableName = assert(function( div ) {
		// Inject content
		div.id = expando + 0;
		div.innerHTML = "<a name='" + expando + "'></a><div name='" + expando + "'></div>";
		docElem.insertBefore( div, docElem.firstChild );

		// Test
		var pass = document.getElementsByName &&
			// buggy browsers will return fewer than the correct 2
			document.getElementsByName( expando ).length === 2 +
			// buggy browsers will return more than the correct 0
			document.getElementsByName( expando + 0 ).length;
		assertGetIdNotName = !document.getElementById( expando );

		// Cleanup
		docElem.removeChild( div );

		return pass;
	});

// If slice is not available, provide a backup
try {
	slice.call( docElem.childNodes, 0 )[0].nodeType;
} catch ( e ) {
	slice = function( i ) {
		var elem,
			results = [];
		for ( ; (elem = this[i]); i++ ) {
			results.push( elem );
		}
		return results;
	};
}

function Sizzle( selector, context, results, seed ) {
	results = results || [];
	context = context || document;
	var match, elem, xml, m,
		nodeType = context.nodeType;

	if ( !selector || typeof selector !== "string" ) {
		return results;
	}

	if ( nodeType !== 1 && nodeType !== 9 ) {
		return [];
	}

	xml = isXML( context );

	if ( !xml && !seed ) {
		if ( (match = rquickExpr.exec( selector )) ) {
			// Speed-up: Sizzle("#ID")
			if ( (m = match[1]) ) {
				if ( nodeType === 9 ) {
					elem = context.getElementById( m );
					// Check parentNode to catch when Blackberry 4.6 returns
					// nodes that are no longer in the document #6963
					if ( elem && elem.parentNode ) {
						// Handle the case where IE, Opera, and Webkit return items
						// by name instead of ID
						if ( elem.id === m ) {
							results.push( elem );
							return results;
						}
					} else {
						return results;
					}
				} else {
					// Context is not a document
					if ( context.ownerDocument && (elem = context.ownerDocument.getElementById( m )) &&
						contains( context, elem ) && elem.id === m ) {
						results.push( elem );
						return results;
					}
				}

			// Speed-up: Sizzle("TAG")
			} else if ( match[2] ) {
				push.apply( results, slice.call(context.getElementsByTagName( selector ), 0) );
				return results;

			// Speed-up: Sizzle(".CLASS")
			} else if ( (m = match[3]) && assertUsableClassName && context.getElementsByClassName ) {
				push.apply( results, slice.call(context.getElementsByClassName( m ), 0) );
				return results;
			}
		}
	}

	// All others
	return select( selector.replace( rtrim, "$1" ), context, results, seed, xml );
}

Sizzle.matches = function( expr, elements ) {
	return Sizzle( expr, null, null, elements );
};

Sizzle.matchesSelector = function( elem, expr ) {
	return Sizzle( expr, null, null, [ elem ] ).length > 0;
};

// Returns a function to use in pseudos for input types
function createInputPseudo( type ) {
	return function( elem ) {
		var name = elem.nodeName.toLowerCase();
		return name === "input" && elem.type === type;
	};
}

// Returns a function to use in pseudos for buttons
function createButtonPseudo( type ) {
	return function( elem ) {
		var name = elem.nodeName.toLowerCase();
		return (name === "input" || name === "button") && elem.type === type;
	};
}

// Returns a function to use in pseudos for positionals
function createPositionalPseudo( fn ) {
	return markFunction(function( argument ) {
		argument = +argument;
		return markFunction(function( seed, matches ) {
			var j,
				matchIndexes = fn( [], seed.length, argument ),
				i = matchIndexes.length;

			// Match elements found at the specified indexes
			while ( i-- ) {
				if ( seed[ (j = matchIndexes[i]) ] ) {
					seed[j] = !(matches[j] = seed[j]);
				}
			}
		});
	});
}

/**
 * Utility function for retrieving the text value of an array of DOM nodes
 * @param {Array|Element} elem
 */
getText = Sizzle.getText = function( elem ) {
	var node,
		ret = "",
		i = 0,
		nodeType = elem.nodeType;

	if ( nodeType ) {
		if ( nodeType === 1 || nodeType === 9 || nodeType === 11 ) {
			// Use textContent for elements
			// innerText usage removed for consistency of new lines (see #11153)
			if ( typeof elem.textContent === "string" ) {
				return elem.textContent;
			} else {
				// Traverse its children
				for ( elem = elem.firstChild; elem; elem = elem.nextSibling ) {
					ret += getText( elem );
				}
			}
		} else if ( nodeType === 3 || nodeType === 4 ) {
			return elem.nodeValue;
		}
		// Do not include comment or processing instruction nodes
	} else {

		// If no nodeType, this is expected to be an array
		for ( ; (node = elem[i]); i++ ) {
			// Do not traverse comment nodes
			ret += getText( node );
		}
	}
	return ret;
};

isXML = Sizzle.isXML = function( elem ) {
	// documentElement is verified for cases where it doesn't yet exist
	// (such as loading iframes in IE - #4833)
	var documentElement = elem && (elem.ownerDocument || elem).documentElement;
	return documentElement ? documentElement.nodeName !== "HTML" : false;
};

// Element contains another
contains = Sizzle.contains = docElem.contains ?
	function( a, b ) {
		var adown = a.nodeType === 9 ? a.documentElement : a,
			bup = b && b.parentNode;
		return a === bup || !!( bup && bup.nodeType === 1 && adown.contains && adown.contains(bup) );
	} :
	docElem.compareDocumentPosition ?
	function( a, b ) {
		return b && !!( a.compareDocumentPosition( b ) & 16 );
	} :
	function( a, b ) {
		while ( (b = b.parentNode) ) {
			if ( b === a ) {
				return true;
			}
		}
		return false;
	};

Sizzle.attr = function( elem, name ) {
	var val,
		xml = isXML( elem );

	if ( !xml ) {
		name = name.toLowerCase();
	}
	if ( (val = Expr.attrHandle[ name ]) ) {
		return val( elem );
	}
	if ( xml || assertAttributes ) {
		return elem.getAttribute( name );
	}
	val = elem.getAttributeNode( name );
	return val ?
		typeof elem[ name ] === "boolean" ?
			elem[ name ] ? name : null :
			val.specified ? val.value : null :
		null;
};

Expr = Sizzle.selectors = {

	// Can be adjusted by the user
	cacheLength: 50,

	createPseudo: markFunction,

	match: matchExpr,

	// IE6/7 return a modified href
	attrHandle: assertHrefNotNormalized ?
		{} :
		{
			"href": function( elem ) {
				return elem.getAttribute( "href", 2 );
			},
			"type": function( elem ) {
				return elem.getAttribute("type");
			}
		},

	find: {
		"ID": assertGetIdNotName ?
			function( id, context, xml ) {
				if ( typeof context.getElementById !== strundefined && !xml ) {
					var m = context.getElementById( id );
					// Check parentNode to catch when Blackberry 4.6 returns
					// nodes that are no longer in the document #6963
					return m && m.parentNode ? [m] : [];
				}
			} :
			function( id, context, xml ) {
				if ( typeof context.getElementById !== strundefined && !xml ) {
					var m = context.getElementById( id );

					return m ?
						m.id === id || typeof m.getAttributeNode !== strundefined && m.getAttributeNode("id").value === id ?
							[m] :
							undefined :
						[];
				}
			},

		"TAG": assertTagNameNoComments ?
			function( tag, context ) {
				if ( typeof context.getElementsByTagName !== strundefined ) {
					return context.getElementsByTagName( tag );
				}
			} :
			function( tag, context ) {
				var results = context.getElementsByTagName( tag );

				// Filter out possible comments
				if ( tag === "*" ) {
					var elem,
						tmp = [],
						i = 0;

					for ( ; (elem = results[i]); i++ ) {
						if ( elem.nodeType === 1 ) {
							tmp.push( elem );
						}
					}

					return tmp;
				}
				return results;
			},

		"NAME": assertUsableName && function( tag, context ) {
			if ( typeof context.getElementsByName !== strundefined ) {
				return context.getElementsByName( name );
			}
		},

		"CLASS": assertUsableClassName && function( className, context, xml ) {
			if ( typeof context.getElementsByClassName !== strundefined && !xml ) {
				return context.getElementsByClassName( className );
			}
		}
	},

	relative: {
		">": { dir: "parentNode", first: true },
		" ": { dir: "parentNode" },
		"+": { dir: "previousSibling", first: true },
		"~": { dir: "previousSibling" }
	},

	preFilter: {
		"ATTR": function( match ) {
			match[1] = match[1].replace( rbackslash, "" );

			// Move the given value to match[3] whether quoted or unquoted
			match[3] = ( match[4] || match[5] || "" ).replace( rbackslash, "" );

			if ( match[2] === "~=" ) {
				match[3] = " " + match[3] + " ";
			}

			return match.slice( 0, 4 );
		},

		"CHILD": function( match ) {
			/* matches from matchExpr["CHILD"]
				1 type (only|nth|...)
				2 argument (even|odd|\d*|\d*n([+-]\d+)?|...)
				3 xn-component of xn+y argument ([+-]?\d*n|)
				4 sign of xn-component
				5 x of xn-component
				6 sign of y-component
				7 y of y-component
			*/
			match[1] = match[1].toLowerCase();

			if ( match[1] === "nth" ) {
				// nth-child requires argument
				if ( !match[2] ) {
					Sizzle.error( match[0] );
				}

				// numeric x and y parameters for Expr.filter.CHILD
				// remember that false/true cast respectively to 0/1
				match[3] = +( match[3] ? match[4] + (match[5] || 1) : 2 * ( match[2] === "even" || match[2] === "odd" ) );
				match[4] = +( ( match[6] + match[7] ) || match[2] === "odd" );

			// other types prohibit arguments
			} else if ( match[2] ) {
				Sizzle.error( match[0] );
			}

			return match;
		},

		"PSEUDO": function( match ) {
			var unquoted, excess;
			if ( matchExpr["CHILD"].test( match[0] ) ) {
				return null;
			}

			if ( match[3] ) {
				match[2] = match[3];
			} else if ( (unquoted = match[4]) ) {
				// Only check arguments that contain a pseudo
				if ( rpseudo.test(unquoted) &&
					// Get excess from tokenize (recursively)
					(excess = tokenize( unquoted, true )) &&
					// advance to the next closing parenthesis
					(excess = unquoted.indexOf( ")", unquoted.length - excess ) - unquoted.length) ) {

					// excess is a negative index
					unquoted = unquoted.slice( 0, excess );
					match[0] = match[0].slice( 0, excess );
				}
				match[2] = unquoted;
			}

			// Return only captures needed by the pseudo filter method (type and argument)
			return match.slice( 0, 3 );
		}
	},

	filter: {
		"ID": assertGetIdNotName ?
			function( id ) {
				id = id.replace( rbackslash, "" );
				return function( elem ) {
					return elem.getAttribute("id") === id;
				};
			} :
			function( id ) {
				id = id.replace( rbackslash, "" );
				return function( elem ) {
					var node = typeof elem.getAttributeNode !== strundefined && elem.getAttributeNode("id");
					return node && node.value === id;
				};
			},

		"TAG": function( nodeName ) {
			if ( nodeName === "*" ) {
				return function() { return true; };
			}
			nodeName = nodeName.replace( rbackslash, "" ).toLowerCase();

			return function( elem ) {
				return elem.nodeName && elem.nodeName.toLowerCase() === nodeName;
			};
		},

		"CLASS": function( className ) {
			var pattern = classCache[ expando ][ className + " " ];

			return pattern ||
				(pattern = new RegExp( "(^|" + whitespace + ")" + className + "(" + whitespace + "|$)" )) &&
				classCache( className, function( elem ) {
					return pattern.test( elem.className || (typeof elem.getAttribute !== strundefined && elem.getAttribute("class")) || "" );
				});
		},

		"ATTR": function( name, operator, check ) {
			return function( elem, context ) {
				var result = Sizzle.attr( elem, name );

				if ( result == null ) {
					return operator === "!=";
				}
				if ( !operator ) {
					return true;
				}

				result += "";

				return operator === "=" ? result === check :
					operator === "!=" ? result !== check :
					operator === "^=" ? check && result.indexOf( check ) === 0 :
					operator === "*=" ? check && result.indexOf( check ) > -1 :
					operator === "$=" ? check && result.substr( result.length - check.length ) === check :
					operator === "~=" ? ( " " + result + " " ).indexOf( check ) > -1 :
					operator === "|=" ? result === check || result.substr( 0, check.length + 1 ) === check + "-" :
					false;
			};
		},

		"CHILD": function( type, argument, first, last ) {

			if ( type === "nth" ) {
				return function( elem ) {
					var node, diff,
						parent = elem.parentNode;

					if ( first === 1 && last === 0 ) {
						return true;
					}

					if ( parent ) {
						diff = 0;
						for ( node = parent.firstChild; node; node = node.nextSibling ) {
							if ( node.nodeType === 1 ) {
								diff++;
								if ( elem === node ) {
									break;
								}
							}
						}
					}

					// Incorporate the offset (or cast to NaN), then check against cycle size
					diff -= last;
					return diff === first || ( diff % first === 0 && diff / first >= 0 );
				};
			}

			return function( elem ) {
				var node = elem;

				switch ( type ) {
					case "only":
					case "first":
						while ( (node = node.previousSibling) ) {
							if ( node.nodeType === 1 ) {
								return false;
							}
						}

						if ( type === "first" ) {
							return true;
						}

						node = elem;

						/* falls through */
					case "last":
						while ( (node = node.nextSibling) ) {
							if ( node.nodeType === 1 ) {
								return false;
							}
						}

						return true;
				}
			};
		},

		"PSEUDO": function( pseudo, argument ) {
			// pseudo-class names are case-insensitive
			// http://www.w3.org/TR/selectors/#pseudo-classes
			// Prioritize by case sensitivity in case custom pseudos are added with uppercase letters
			// Remember that setFilters inherits from pseudos
			var args,
				fn = Expr.pseudos[ pseudo ] || Expr.setFilters[ pseudo.toLowerCase() ] ||
					Sizzle.error( "unsupported pseudo: " + pseudo );

			// The user may use createPseudo to indicate that
			// arguments are needed to create the filter function
			// just as Sizzle does
			if ( fn[ expando ] ) {
				return fn( argument );
			}

			// But maintain support for old signatures
			if ( fn.length > 1 ) {
				args = [ pseudo, pseudo, "", argument ];
				return Expr.setFilters.hasOwnProperty( pseudo.toLowerCase() ) ?
					markFunction(function( seed, matches ) {
						var idx,
							matched = fn( seed, argument ),
							i = matched.length;
						while ( i-- ) {
							idx = indexOf.call( seed, matched[i] );
							seed[ idx ] = !( matches[ idx ] = matched[i] );
						}
					}) :
					function( elem ) {
						return fn( elem, 0, args );
					};
			}

			return fn;
		}
	},

	pseudos: {
		"not": markFunction(function( selector ) {
			// Trim the selector passed to compile
			// to avoid treating leading and trailing
			// spaces as combinators
			var input = [],
				results = [],
				matcher = compile( selector.replace( rtrim, "$1" ) );

			return matcher[ expando ] ?
				markFunction(function( seed, matches, context, xml ) {
					var elem,
						unmatched = matcher( seed, null, xml, [] ),
						i = seed.length;

					// Match elements unmatched by `matcher`
					while ( i-- ) {
						if ( (elem = unmatched[i]) ) {
							seed[i] = !(matches[i] = elem);
						}
					}
				}) :
				function( elem, context, xml ) {
					input[0] = elem;
					matcher( input, null, xml, results );
					return !results.pop();
				};
		}),

		"has": markFunction(function( selector ) {
			return function( elem ) {
				return Sizzle( selector, elem ).length > 0;
			};
		}),

		"contains": markFunction(function( text ) {
			return function( elem ) {
				return ( elem.textContent || elem.innerText || getText( elem ) ).indexOf( text ) > -1;
			};
		}),

		"enabled": function( elem ) {
			return elem.disabled === false;
		},

		"disabled": function( elem ) {
			return elem.disabled === true;
		},

		"checked": function( elem ) {
			// In CSS3, :checked should return both checked and selected elements
			// http://www.w3.org/TR/2011/REC-css3-selectors-20110929/#checked
			var nodeName = elem.nodeName.toLowerCase();
			return (nodeName === "input" && !!elem.checked) || (nodeName === "option" && !!elem.selected);
		},

		"selected": function( elem ) {
			// Accessing this property makes selected-by-default
			// options in Safari work properly
			if ( elem.parentNode ) {
				elem.parentNode.selectedIndex;
			}

			return elem.selected === true;
		},

		"parent": function( elem ) {
			return !Expr.pseudos["empty"]( elem );
		},

		"empty": function( elem ) {
			// http://www.w3.org/TR/selectors/#empty-pseudo
			// :empty is only affected by element nodes and content nodes(including text(3), cdata(4)),
			//   not comment, processing instructions, or others
			// Thanks to Diego Perini for the nodeName shortcut
			//   Greater than "@" means alpha characters (specifically not starting with "#" or "?")
			var nodeType;
			elem = elem.firstChild;
			while ( elem ) {
				if ( elem.nodeName > "@" || (nodeType = elem.nodeType) === 3 || nodeType === 4 ) {
					return false;
				}
				elem = elem.nextSibling;
			}
			return true;
		},

		"header": function( elem ) {
			return rheader.test( elem.nodeName );
		},

		"text": function( elem ) {
			var type, attr;
			// IE6 and 7 will map elem.type to 'text' for new HTML5 types (search, etc)
			// use getAttribute instead to test this case
			return elem.nodeName.toLowerCase() === "input" &&
				(type = elem.type) === "text" &&
				( (attr = elem.getAttribute("type")) == null || attr.toLowerCase() === type );
		},

		// Input types
		"radio": createInputPseudo("radio"),
		"checkbox": createInputPseudo("checkbox"),
		"file": createInputPseudo("file"),
		"password": createInputPseudo("password"),
		"image": createInputPseudo("image"),

		"submit": createButtonPseudo("submit"),
		"reset": createButtonPseudo("reset"),

		"button": function( elem ) {
			var name = elem.nodeName.toLowerCase();
			return name === "input" && elem.type === "button" || name === "button";
		},

		"input": function( elem ) {
			return rinputs.test( elem.nodeName );
		},

		"focus": function( elem ) {
			var doc = elem.ownerDocument;
			return elem === doc.activeElement && (!doc.hasFocus || doc.hasFocus()) && !!(elem.type || elem.href || ~elem.tabIndex);
		},

		"active": function( elem ) {
			return elem === elem.ownerDocument.activeElement;
		},

		// Positional types
		"first": createPositionalPseudo(function() {
			return [ 0 ];
		}),

		"last": createPositionalPseudo(function( matchIndexes, length ) {
			return [ length - 1 ];
		}),

		"eq": createPositionalPseudo(function( matchIndexes, length, argument ) {
			return [ argument < 0 ? argument + length : argument ];
		}),

		"even": createPositionalPseudo(function( matchIndexes, length ) {
			for ( var i = 0; i < length; i += 2 ) {
				matchIndexes.push( i );
			}
			return matchIndexes;
		}),

		"odd": createPositionalPseudo(function( matchIndexes, length ) {
			for ( var i = 1; i < length; i += 2 ) {
				matchIndexes.push( i );
			}
			return matchIndexes;
		}),

		"lt": createPositionalPseudo(function( matchIndexes, length, argument ) {
			for ( var i = argument < 0 ? argument + length : argument; --i >= 0; ) {
				matchIndexes.push( i );
			}
			return matchIndexes;
		}),

		"gt": createPositionalPseudo(function( matchIndexes, length, argument ) {
			for ( var i = argument < 0 ? argument + length : argument; ++i < length; ) {
				matchIndexes.push( i );
			}
			return matchIndexes;
		})
	}
};

function siblingCheck( a, b, ret ) {
	if ( a === b ) {
		return ret;
	}

	var cur = a.nextSibling;

	while ( cur ) {
		if ( cur === b ) {
			return -1;
		}

		cur = cur.nextSibling;
	}

	return 1;
}

sortOrder = docElem.compareDocumentPosition ?
	function( a, b ) {
		if ( a === b ) {
			hasDuplicate = true;
			return 0;
		}

		return ( !a.compareDocumentPosition || !b.compareDocumentPosition ?
			a.compareDocumentPosition :
			a.compareDocumentPosition(b) & 4
		) ? -1 : 1;
	} :
	function( a, b ) {
		// The nodes are identical, we can exit early
		if ( a === b ) {
			hasDuplicate = true;
			return 0;

		// Fallback to using sourceIndex (in IE) if it's available on both nodes
		} else if ( a.sourceIndex && b.sourceIndex ) {
			return a.sourceIndex - b.sourceIndex;
		}

		var al, bl,
			ap = [],
			bp = [],
			aup = a.parentNode,
			bup = b.parentNode,
			cur = aup;

		// If the nodes are siblings (or identical) we can do a quick check
		if ( aup === bup ) {
			return siblingCheck( a, b );

		// If no parents were found then the nodes are disconnected
		} else if ( !aup ) {
			return -1;

		} else if ( !bup ) {
			return 1;
		}

		// Otherwise they're somewhere else in the tree so we need
		// to build up a full list of the parentNodes for comparison
		while ( cur ) {
			ap.unshift( cur );
			cur = cur.parentNode;
		}

		cur = bup;

		while ( cur ) {
			bp.unshift( cur );
			cur = cur.parentNode;
		}

		al = ap.length;
		bl = bp.length;

		// Start walking down the tree looking for a discrepancy
		for ( var i = 0; i < al && i < bl; i++ ) {
			if ( ap[i] !== bp[i] ) {
				return siblingCheck( ap[i], bp[i] );
			}
		}

		// We ended someplace up the tree so do a sibling check
		return i === al ?
			siblingCheck( a, bp[i], -1 ) :
			siblingCheck( ap[i], b, 1 );
	};

// Always assume the presence of duplicates if sort doesn't
// pass them to our comparison function (as in Google Chrome).
[0, 0].sort( sortOrder );
baseHasDuplicate = !hasDuplicate;

// Document sorting and removing duplicates
Sizzle.uniqueSort = function( results ) {
	var elem,
		duplicates = [],
		i = 1,
		j = 0;

	hasDuplicate = baseHasDuplicate;
	results.sort( sortOrder );

	if ( hasDuplicate ) {
		for ( ; (elem = results[i]); i++ ) {
			if ( elem === results[ i - 1 ] ) {
				j = duplicates.push( i );
			}
		}
		while ( j-- ) {
			results.splice( duplicates[ j ], 1 );
		}
	}

	return results;
};

Sizzle.error = function( msg ) {
	throw new Error( "Syntax error, unrecognized expression: " + msg );
};

function tokenize( selector, parseOnly ) {
	var matched, match, tokens, type,
		soFar, groups, preFilters,
		cached = tokenCache[ expando ][ selector + " " ];

	if ( cached ) {
		return parseOnly ? 0 : cached.slice( 0 );
	}

	soFar = selector;
	groups = [];
	preFilters = Expr.preFilter;

	while ( soFar ) {

		// Comma and first run
		if ( !matched || (match = rcomma.exec( soFar )) ) {
			if ( match ) {
				// Don't consume trailing commas as valid
				soFar = soFar.slice( match[0].length ) || soFar;
			}
			groups.push( tokens = [] );
		}

		matched = false;

		// Combinators
		if ( (match = rcombinators.exec( soFar )) ) {
			tokens.push( matched = new Token( match.shift() ) );
			soFar = soFar.slice( matched.length );

			// Cast descendant combinators to space
			matched.type = match[0].replace( rtrim, " " );
		}

		// Filters
		for ( type in Expr.filter ) {
			if ( (match = matchExpr[ type ].exec( soFar )) && (!preFilters[ type ] ||
				(match = preFilters[ type ]( match ))) ) {

				tokens.push( matched = new Token( match.shift() ) );
				soFar = soFar.slice( matched.length );
				matched.type = type;
				matched.matches = match;
			}
		}

		if ( !matched ) {
			break;
		}
	}

	// Return the length of the invalid excess
	// if we're just parsing
	// Otherwise, throw an error or return tokens
	return parseOnly ?
		soFar.length :
		soFar ?
			Sizzle.error( selector ) :
			// Cache the tokens
			tokenCache( selector, groups ).slice( 0 );
}

function addCombinator( matcher, combinator, base ) {
	var dir = combinator.dir,
		checkNonElements = base && combinator.dir === "parentNode",
		doneName = done++;

	return combinator.first ?
		// Check against closest ancestor/preceding element
		function( elem, context, xml ) {
			while ( (elem = elem[ dir ]) ) {
				if ( checkNonElements || elem.nodeType === 1  ) {
					return matcher( elem, context, xml );
				}
			}
		} :

		// Check against all ancestor/preceding elements
		function( elem, context, xml ) {
			// We can't set arbitrary data on XML nodes, so they don't benefit from dir caching
			if ( !xml ) {
				var cache,
					dirkey = dirruns + " " + doneName + " ",
					cachedkey = dirkey + cachedruns;
				while ( (elem = elem[ dir ]) ) {
					if ( checkNonElements || elem.nodeType === 1 ) {
						if ( (cache = elem[ expando ]) === cachedkey ) {
							return elem.sizset;
						} else if ( typeof cache === "string" && cache.indexOf(dirkey) === 0 ) {
							if ( elem.sizset ) {
								return elem;
							}
						} else {
							elem[ expando ] = cachedkey;
							if ( matcher( elem, context, xml ) ) {
								elem.sizset = true;
								return elem;
							}
							elem.sizset = false;
						}
					}
				}
			} else {
				while ( (elem = elem[ dir ]) ) {
					if ( checkNonElements || elem.nodeType === 1 ) {
						if ( matcher( elem, context, xml ) ) {
							return elem;
						}
					}
				}
			}
		};
}

function elementMatcher( matchers ) {
	return matchers.length > 1 ?
		function( elem, context, xml ) {
			var i = matchers.length;
			while ( i-- ) {
				if ( !matchers[i]( elem, context, xml ) ) {
					return false;
				}
			}
			return true;
		} :
		matchers[0];
}

function condense( unmatched, map, filter, context, xml ) {
	var elem,
		newUnmatched = [],
		i = 0,
		len = unmatched.length,
		mapped = map != null;

	for ( ; i < len; i++ ) {
		if ( (elem = unmatched[i]) ) {
			if ( !filter || filter( elem, context, xml ) ) {
				newUnmatched.push( elem );
				if ( mapped ) {
					map.push( i );
				}
			}
		}
	}

	return newUnmatched;
}

function setMatcher( preFilter, selector, matcher, postFilter, postFinder, postSelector ) {
	if ( postFilter && !postFilter[ expando ] ) {
		postFilter = setMatcher( postFilter );
	}
	if ( postFinder && !postFinder[ expando ] ) {
		postFinder = setMatcher( postFinder, postSelector );
	}
	return markFunction(function( seed, results, context, xml ) {
		var temp, i, elem,
			preMap = [],
			postMap = [],
			preexisting = results.length,

			// Get initial elements from seed or context
			elems = seed || multipleContexts( selector || "*", context.nodeType ? [ context ] : context, [] ),

			// Prefilter to get matcher input, preserving a map for seed-results synchronization
			matcherIn = preFilter && ( seed || !selector ) ?
				condense( elems, preMap, preFilter, context, xml ) :
				elems,

			matcherOut = matcher ?
				// If we have a postFinder, or filtered seed, or non-seed postFilter or preexisting results,
				postFinder || ( seed ? preFilter : preexisting || postFilter ) ?

					// ...intermediate processing is necessary
					[] :

					// ...otherwise use results directly
					results :
				matcherIn;

		// Find primary matches
		if ( matcher ) {
			matcher( matcherIn, matcherOut, context, xml );
		}

		// Apply postFilter
		if ( postFilter ) {
			temp = condense( matcherOut, postMap );
			postFilter( temp, [], context, xml );

			// Un-match failing elements by moving them back to matcherIn
			i = temp.length;
			while ( i-- ) {
				if ( (elem = temp[i]) ) {
					matcherOut[ postMap[i] ] = !(matcherIn[ postMap[i] ] = elem);
				}
			}
		}

		if ( seed ) {
			if ( postFinder || preFilter ) {
				if ( postFinder ) {
					// Get the final matcherOut by condensing this intermediate into postFinder contexts
					temp = [];
					i = matcherOut.length;
					while ( i-- ) {
						if ( (elem = matcherOut[i]) ) {
							// Restore matcherIn since elem is not yet a final match
							temp.push( (matcherIn[i] = elem) );
						}
					}
					postFinder( null, (matcherOut = []), temp, xml );
				}

				// Move matched elements from seed to results to keep them synchronized
				i = matcherOut.length;
				while ( i-- ) {
					if ( (elem = matcherOut[i]) &&
						(temp = postFinder ? indexOf.call( seed, elem ) : preMap[i]) > -1 ) {

						seed[temp] = !(results[temp] = elem);
					}
				}
			}

		// Add elements to results, through postFinder if defined
		} else {
			matcherOut = condense(
				matcherOut === results ?
					matcherOut.splice( preexisting, matcherOut.length ) :
					matcherOut
			);
			if ( postFinder ) {
				postFinder( null, results, matcherOut, xml );
			} else {
				push.apply( results, matcherOut );
			}
		}
	});
}

function matcherFromTokens( tokens ) {
	var checkContext, matcher, j,
		len = tokens.length,
		leadingRelative = Expr.relative[ tokens[0].type ],
		implicitRelative = leadingRelative || Expr.relative[" "],
		i = leadingRelative ? 1 : 0,

		// The foundational matcher ensures that elements are reachable from top-level context(s)
		matchContext = addCombinator( function( elem ) {
			return elem === checkContext;
		}, implicitRelative, true ),
		matchAnyContext = addCombinator( function( elem ) {
			return indexOf.call( checkContext, elem ) > -1;
		}, implicitRelative, true ),
		matchers = [ function( elem, context, xml ) {
			return ( !leadingRelative && ( xml || context !== outermostContext ) ) || (
				(checkContext = context).nodeType ?
					matchContext( elem, context, xml ) :
					matchAnyContext( elem, context, xml ) );
		} ];

	for ( ; i < len; i++ ) {
		if ( (matcher = Expr.relative[ tokens[i].type ]) ) {
			matchers = [ addCombinator( elementMatcher( matchers ), matcher ) ];
		} else {
			matcher = Expr.filter[ tokens[i].type ].apply( null, tokens[i].matches );

			// Return special upon seeing a positional matcher
			if ( matcher[ expando ] ) {
				// Find the next relative operator (if any) for proper handling
				j = ++i;
				for ( ; j < len; j++ ) {
					if ( Expr.relative[ tokens[j].type ] ) {
						break;
					}
				}
				return setMatcher(
					i > 1 && elementMatcher( matchers ),
					i > 1 && tokens.slice( 0, i - 1 ).join("").replace( rtrim, "$1" ),
					matcher,
					i < j && matcherFromTokens( tokens.slice( i, j ) ),
					j < len && matcherFromTokens( (tokens = tokens.slice( j )) ),
					j < len && tokens.join("")
				);
			}
			matchers.push( matcher );
		}
	}

	return elementMatcher( matchers );
}

function matcherFromGroupMatchers( elementMatchers, setMatchers ) {
	var bySet = setMatchers.length > 0,
		byElement = elementMatchers.length > 0,
		superMatcher = function( seed, context, xml, results, expandContext ) {
			var elem, j, matcher,
				setMatched = [],
				matchedCount = 0,
				i = "0",
				unmatched = seed && [],
				outermost = expandContext != null,
				contextBackup = outermostContext,
				// We must always have either seed elements or context
				elems = seed || byElement && Expr.find["TAG"]( "*", expandContext && context.parentNode || context ),
				// Nested matchers should use non-integer dirruns
				dirrunsUnique = (dirruns += contextBackup == null ? 1 : Math.E);

			if ( outermost ) {
				outermostContext = context !== document && context;
				cachedruns = superMatcher.el;
			}

			// Add elements passing elementMatchers directly to results
			for ( ; (elem = elems[i]) != null; i++ ) {
				if ( byElement && elem ) {
					for ( j = 0; (matcher = elementMatchers[j]); j++ ) {
						if ( matcher( elem, context, xml ) ) {
							results.push( elem );
							break;
						}
					}
					if ( outermost ) {
						dirruns = dirrunsUnique;
						cachedruns = ++superMatcher.el;
					}
				}

				// Track unmatched elements for set filters
				if ( bySet ) {
					// They will have gone through all possible matchers
					if ( (elem = !matcher && elem) ) {
						matchedCount--;
					}

					// Lengthen the array for every element, matched or not
					if ( seed ) {
						unmatched.push( elem );
					}
				}
			}

			// Apply set filters to unmatched elements
			matchedCount += i;
			if ( bySet && i !== matchedCount ) {
				for ( j = 0; (matcher = setMatchers[j]); j++ ) {
					matcher( unmatched, setMatched, context, xml );
				}

				if ( seed ) {
					// Reintegrate element matches to eliminate the need for sorting
					if ( matchedCount > 0 ) {
						while ( i-- ) {
							if ( !(unmatched[i] || setMatched[i]) ) {
								setMatched[i] = pop.call( results );
							}
						}
					}

					// Discard index placeholder values to get only actual matches
					setMatched = condense( setMatched );
				}

				// Add matches to results
				push.apply( results, setMatched );

				// Seedless set matches succeeding multiple successful matchers stipulate sorting
				if ( outermost && !seed && setMatched.length > 0 &&
					( matchedCount + setMatchers.length ) > 1 ) {

					Sizzle.uniqueSort( results );
				}
			}

			// Override manipulation of globals by nested matchers
			if ( outermost ) {
				dirruns = dirrunsUnique;
				outermostContext = contextBackup;
			}

			return unmatched;
		};

	superMatcher.el = 0;
	return bySet ?
		markFunction( superMatcher ) :
		superMatcher;
}

compile = Sizzle.compile = function( selector, group /* Internal Use Only */ ) {
	var i,
		setMatchers = [],
		elementMatchers = [],
		cached = compilerCache[ expando ][ selector + " " ];

	if ( !cached ) {
		// Generate a function of recursive functions that can be used to check each element
		if ( !group ) {
			group = tokenize( selector );
		}
		i = group.length;
		while ( i-- ) {
			cached = matcherFromTokens( group[i] );
			if ( cached[ expando ] ) {
				setMatchers.push( cached );
			} else {
				elementMatchers.push( cached );
			}
		}

		// Cache the compiled function
		cached = compilerCache( selector, matcherFromGroupMatchers( elementMatchers, setMatchers ) );
	}
	return cached;
};

function multipleContexts( selector, contexts, results ) {
	var i = 0,
		len = contexts.length;
	for ( ; i < len; i++ ) {
		Sizzle( selector, contexts[i], results );
	}
	return results;
}

function select( selector, context, results, seed, xml ) {
	var i, tokens, token, type, find,
		match = tokenize( selector ),
		j = match.length;

	if ( !seed ) {
		// Try to minimize operations if there is only one group
		if ( match.length === 1 ) {

			// Take a shortcut and set the context if the root selector is an ID
			tokens = match[0] = match[0].slice( 0 );
			if ( tokens.length > 2 && (token = tokens[0]).type === "ID" &&
					context.nodeType === 9 && !xml &&
					Expr.relative[ tokens[1].type ] ) {

				context = Expr.find["ID"]( token.matches[0].replace( rbackslash, "" ), context, xml )[0];
				if ( !context ) {
					return results;
				}

				selector = selector.slice( tokens.shift().length );
			}

			// Fetch a seed set for right-to-left matching
			for ( i = matchExpr["POS"].test( selector ) ? -1 : tokens.length - 1; i >= 0; i-- ) {
				token = tokens[i];

				// Abort if we hit a combinator
				if ( Expr.relative[ (type = token.type) ] ) {
					break;
				}
				if ( (find = Expr.find[ type ]) ) {
					// Search, expanding context for leading sibling combinators
					if ( (seed = find(
						token.matches[0].replace( rbackslash, "" ),
						rsibling.test( tokens[0].type ) && context.parentNode || context,
						xml
					)) ) {

						// If seed is empty or no tokens remain, we can return early
						tokens.splice( i, 1 );
						selector = seed.length && tokens.join("");
						if ( !selector ) {
							push.apply( results, slice.call( seed, 0 ) );
							return results;
						}

						break;
					}
				}
			}
		}
	}

	// Compile and execute a filtering function
	// Provide `match` to avoid retokenization if we modified the selector above
	compile( selector, match )(
		seed,
		context,
		xml,
		results,
		rsibling.test( selector )
	);
	return results;
}

if ( document.querySelectorAll ) {
	(function() {
		var disconnectedMatch,
			oldSelect = select,
			rescape = /'|\\/g,
			rattributeQuotes = /\=[\x20\t\r\n\f]*([^'"\]]*)[\x20\t\r\n\f]*\]/g,

			// qSa(:focus) reports false when true (Chrome 21), no need to also add to buggyMatches since matches checks buggyQSA
			// A support test would require too much code (would include document ready)
			rbuggyQSA = [ ":focus" ],

			// matchesSelector(:active) reports false when true (IE9/Opera 11.5)
			// A support test would require too much code (would include document ready)
			// just skip matchesSelector for :active
			rbuggyMatches = [ ":active" ],
			matches = docElem.matchesSelector ||
				docElem.mozMatchesSelector ||
				docElem.webkitMatchesSelector ||
				docElem.oMatchesSelector ||
				docElem.msMatchesSelector;

		// Build QSA regex
		// Regex strategy adopted from Diego Perini
		assert(function( div ) {
			// Select is set to empty string on purpose
			// This is to test IE's treatment of not explictly
			// setting a boolean content attribute,
			// since its presence should be enough
			// http://bugs.jquery.com/ticket/12359
			div.innerHTML = "<select><option selected=''></option></select>";

			// IE8 - Some boolean attributes are not treated correctly
			if ( !div.querySelectorAll("[selected]").length ) {
				rbuggyQSA.push( "\\[" + whitespace + "*(?:checked|disabled|ismap|multiple|readonly|selected|value)" );
			}

			// Webkit/Opera - :checked should return selected option elements
			// http://www.w3.org/TR/2011/REC-css3-selectors-20110929/#checked
			// IE8 throws error here (do not put tests after this one)
			if ( !div.querySelectorAll(":checked").length ) {
				rbuggyQSA.push(":checked");
			}
		});

		assert(function( div ) {

			// Opera 10-12/IE9 - ^= $= *= and empty values
			// Should not select anything
			div.innerHTML = "<p test=''></p>";
			if ( div.querySelectorAll("[test^='']").length ) {
				rbuggyQSA.push( "[*^$]=" + whitespace + "*(?:\"\"|'')" );
			}

			// FF 3.5 - :enabled/:disabled and hidden elements (hidden elements are still enabled)
			// IE8 throws error here (do not put tests after this one)
			div.innerHTML = "<input type='hidden'/>";
			if ( !div.querySelectorAll(":enabled").length ) {
				rbuggyQSA.push(":enabled", ":disabled");
			}
		});

		// rbuggyQSA always contains :focus, so no need for a length check
		rbuggyQSA = /* rbuggyQSA.length && */ new RegExp( rbuggyQSA.join("|") );

		select = function( selector, context, results, seed, xml ) {
			// Only use querySelectorAll when not filtering,
			// when this is not xml,
			// and when no QSA bugs apply
			if ( !seed && !xml && !rbuggyQSA.test( selector ) ) {
				var groups, i,
					old = true,
					nid = expando,
					newContext = context,
					newSelector = context.nodeType === 9 && selector;

				// qSA works strangely on Element-rooted queries
				// We can work around this by specifying an extra ID on the root
				// and working up from there (Thanks to Andrew Dupont for the technique)
				// IE 8 doesn't work on object elements
				if ( context.nodeType === 1 && context.nodeName.toLowerCase() !== "object" ) {
					groups = tokenize( selector );

					if ( (old = context.getAttribute("id")) ) {
						nid = old.replace( rescape, "\\$&" );
					} else {
						context.setAttribute( "id", nid );
					}
					nid = "[id='" + nid + "'] ";

					i = groups.length;
					while ( i-- ) {
						groups[i] = nid + groups[i].join("");
					}
					newContext = rsibling.test( selector ) && context.parentNode || context;
					newSelector = groups.join(",");
				}

				if ( newSelector ) {
					try {
						push.apply( results, slice.call( newContext.querySelectorAll(
							newSelector
						), 0 ) );
						return results;
					} catch(qsaError) {
					} finally {
						if ( !old ) {
							context.removeAttribute("id");
						}
					}
				}
			}

			return oldSelect( selector, context, results, seed, xml );
		};

		if ( matches ) {
			assert(function( div ) {
				// Check to see if it's possible to do matchesSelector
				// on a disconnected node (IE 9)
				disconnectedMatch = matches.call( div, "div" );

				// This should fail with an exception
				// Gecko does not error, returns false instead
				try {
					matches.call( div, "[test!='']:sizzle" );
					rbuggyMatches.push( "!=", pseudos );
				} catch ( e ) {}
			});

			// rbuggyMatches always contains :active and :focus, so no need for a length check
			rbuggyMatches = /* rbuggyMatches.length && */ new RegExp( rbuggyMatches.join("|") );

			Sizzle.matchesSelector = function( elem, expr ) {
				// Make sure that attribute selectors are quoted
				expr = expr.replace( rattributeQuotes, "='$1']" );

				// rbuggyMatches always contains :active, so no need for an existence check
				if ( !isXML( elem ) && !rbuggyMatches.test( expr ) && !rbuggyQSA.test( expr ) ) {
					try {
						var ret = matches.call( elem, expr );

						// IE 9's matchesSelector returns false on disconnected nodes
						if ( ret || disconnectedMatch ||
								// As well, disconnected nodes are said to be in a document
								// fragment in IE 9
								elem.document && elem.document.nodeType !== 11 ) {
							return ret;
						}
					} catch(e) {}
				}

				return Sizzle( expr, null, null, [ elem ] ).length > 0;
			};
		}
	})();
}

// Deprecated
Expr.pseudos["nth"] = Expr.pseudos["eq"];

// Back-compat
function setFilters() {}
Expr.filters = setFilters.prototype = Expr.pseudos;
Expr.setFilters = new setFilters();

// Override sizzle attribute retrieval
Sizzle.attr = jQuery.attr;
jQuery.find = Sizzle;
jQuery.expr = Sizzle.selectors;
jQuery.expr[":"] = jQuery.expr.pseudos;
jQuery.unique = Sizzle.uniqueSort;
jQuery.text = Sizzle.getText;
jQuery.isXMLDoc = Sizzle.isXML;
jQuery.contains = Sizzle.contains;


})( window );
var runtil = /Until$/,
	rparentsprev = /^(?:parents|prev(?:Until|All))/,
	isSimple = /^.[^:#\[\.,]*$/,
	rneedsContext = jQuery.expr.match.needsContext,
	// methods guaranteed to produce a unique set when starting from a unique set
	guaranteedUnique = {
		children: true,
		contents: true,
		next: true,
		prev: true
	};

jQuery.fn.extend({
	find: function( selector ) {
		var i, l, length, n, r, ret,
			self = this;

		if ( typeof selector !== "string" ) {
			return jQuery( selector ).filter(function() {
				for ( i = 0, l = self.length; i < l; i++ ) {
					if ( jQuery.contains( self[ i ], this ) ) {
						return true;
					}
				}
			});
		}

		ret = this.pushStack( "", "find", selector );

		for ( i = 0, l = this.length; i < l; i++ ) {
			length = ret.length;
			jQuery.find( selector, this[i], ret );

			if ( i > 0 ) {
				// Make sure that the results are unique
				for ( n = length; n < ret.length; n++ ) {
					for ( r = 0; r < length; r++ ) {
						if ( ret[r] === ret[n] ) {
							ret.splice(n--, 1);
							break;
						}
					}
				}
			}
		}

		return ret;
	},

	has: function( target ) {
		var i,
			targets = jQuery( target, this ),
			len = targets.length;

		return this.filter(function() {
			for ( i = 0; i < len; i++ ) {
				if ( jQuery.contains( this, targets[i] ) ) {
					return true;
				}
			}
		});
	},

	not: function( selector ) {
		return this.pushStack( winnow(this, selector, false), "not", selector);
	},

	filter: function( selector ) {
		return this.pushStack( winnow(this, selector, true), "filter", selector );
	},

	is: function( selector ) {
		return !!selector && (
			typeof selector === "string" ?
				// If this is a positional/relative selector, check membership in the returned set
				// so $("p:first").is("p:last") won't return true for a doc with two "p".
				rneedsContext.test( selector ) ?
					jQuery( selector, this.context ).index( this[0] ) >= 0 :
					jQuery.filter( selector, this ).length > 0 :
				this.filter( selector ).length > 0 );
	},

	closest: function( selectors, context ) {
		var cur,
			i = 0,
			l = this.length,
			ret = [],
			pos = rneedsContext.test( selectors ) || typeof selectors !== "string" ?
				jQuery( selectors, context || this.context ) :
				0;

		for ( ; i < l; i++ ) {
			cur = this[i];

			while ( cur && cur.ownerDocument && cur !== context && cur.nodeType !== 11 ) {
				if ( pos ? pos.index(cur) > -1 : jQuery.find.matchesSelector(cur, selectors) ) {
					ret.push( cur );
					break;
				}
				cur = cur.parentNode;
			}
		}

		ret = ret.length > 1 ? jQuery.unique( ret ) : ret;

		return this.pushStack( ret, "closest", selectors );
	},

	// Determine the position of an element within
	// the matched set of elements
	index: function( elem ) {

		// No argument, return index in parent
		if ( !elem ) {
			return ( this[0] && this[0].parentNode ) ? this.prevAll().length : -1;
		}

		// index in selector
		if ( typeof elem === "string" ) {
			return jQuery.inArray( this[0], jQuery( elem ) );
		}

		// Locate the position of the desired element
		return jQuery.inArray(
			// If it receives a jQuery object, the first element is used
			elem.jquery ? elem[0] : elem, this );
	},

	add: function( selector, context ) {
		var set = typeof selector === "string" ?
				jQuery( selector, context ) :
				jQuery.makeArray( selector && selector.nodeType ? [ selector ] : selector ),
			all = jQuery.merge( this.get(), set );

		return this.pushStack( isDisconnected( set[0] ) || isDisconnected( all[0] ) ?
			all :
			jQuery.unique( all ) );
	},

	addBack: function( selector ) {
		return this.add( selector == null ?
			this.prevObject : this.prevObject.filter(selector)
		);
	}
});

jQuery.fn.andSelf = jQuery.fn.addBack;

// A painfully simple check to see if an element is disconnected
// from a document (should be improved, where feasible).
function isDisconnected( node ) {
	return !node || !node.parentNode || node.parentNode.nodeType === 11;
}

function sibling( cur, dir ) {
	do {
		cur = cur[ dir ];
	} while ( cur && cur.nodeType !== 1 );

	return cur;
}

jQuery.each({
	parent: function( elem ) {
		var parent = elem.parentNode;
		return parent && parent.nodeType !== 11 ? parent : null;
	},
	parents: function( elem ) {
		return jQuery.dir( elem, "parentNode" );
	},
	parentsUntil: function( elem, i, until ) {
		return jQuery.dir( elem, "parentNode", until );
	},
	next: function( elem ) {
		return sibling( elem, "nextSibling" );
	},
	prev: function( elem ) {
		return sibling( elem, "previousSibling" );
	},
	nextAll: function( elem ) {
		return jQuery.dir( elem, "nextSibling" );
	},
	prevAll: function( elem ) {
		return jQuery.dir( elem, "previousSibling" );
	},
	nextUntil: function( elem, i, until ) {
		return jQuery.dir( elem, "nextSibling", until );
	},
	prevUntil: function( elem, i, until ) {
		return jQuery.dir( elem, "previousSibling", until );
	},
	siblings: function( elem ) {
		return jQuery.sibling( ( elem.parentNode || {} ).firstChild, elem );
	},
	children: function( elem ) {
		return jQuery.sibling( elem.firstChild );
	},
	contents: function( elem ) {
		return jQuery.nodeName( elem, "iframe" ) ?
			elem.contentDocument || elem.contentWindow.document :
			jQuery.merge( [], elem.childNodes );
	}
}, function( name, fn ) {
	jQuery.fn[ name ] = function( until, selector ) {
		var ret = jQuery.map( this, fn, until );

		if ( !runtil.test( name ) ) {
			selector = until;
		}

		if ( selector && typeof selector === "string" ) {
			ret = jQuery.filter( selector, ret );
		}

		ret = this.length > 1 && !guaranteedUnique[ name ] ? jQuery.unique( ret ) : ret;

		if ( this.length > 1 && rparentsprev.test( name ) ) {
			ret = ret.reverse();
		}

		return this.pushStack( ret, name, core_slice.call( arguments ).join(",") );
	};
});

jQuery.extend({
	filter: function( expr, elems, not ) {
		if ( not ) {
			expr = ":not(" + expr + ")";
		}

		return elems.length === 1 ?
			jQuery.find.matchesSelector(elems[0], expr) ? [ elems[0] ] : [] :
			jQuery.find.matches(expr, elems);
	},

	dir: function( elem, dir, until ) {
		var matched = [],
			cur = elem[ dir ];

		while ( cur && cur.nodeType !== 9 && (until === undefined || cur.nodeType !== 1 || !jQuery( cur ).is( until )) ) {
			if ( cur.nodeType === 1 ) {
				matched.push( cur );
			}
			cur = cur[dir];
		}
		return matched;
	},

	sibling: function( n, elem ) {
		var r = [];

		for ( ; n; n = n.nextSibling ) {
			if ( n.nodeType === 1 && n !== elem ) {
				r.push( n );
			}
		}

		return r;
	}
});

// Implement the identical functionality for filter and not
function winnow( elements, qualifier, keep ) {

	// Can't pass null or undefined to indexOf in Firefox 4
	// Set to 0 to skip string check
	qualifier = qualifier || 0;

	if ( jQuery.isFunction( qualifier ) ) {
		return jQuery.grep(elements, function( elem, i ) {
			var retVal = !!qualifier.call( elem, i, elem );
			return retVal === keep;
		});

	} else if ( qualifier.nodeType ) {
		return jQuery.grep(elements, function( elem, i ) {
			return ( elem === qualifier ) === keep;
		});

	} else if ( typeof qualifier === "string" ) {
		var filtered = jQuery.grep(elements, function( elem ) {
			return elem.nodeType === 1;
		});

		if ( isSimple.test( qualifier ) ) {
			return jQuery.filter(qualifier, filtered, !keep);
		} else {
			qualifier = jQuery.filter( qualifier, filtered );
		}
	}

	return jQuery.grep(elements, function( elem, i ) {
		return ( jQuery.inArray( elem, qualifier ) >= 0 ) === keep;
	});
}
function createSafeFragment( document ) {
	var list = nodeNames.split( "|" ),
	safeFrag = document.createDocumentFragment();

	if ( safeFrag.createElement ) {
		while ( list.length ) {
			safeFrag.createElement(
				list.pop()
			);
		}
	}
	return safeFrag;
}

var nodeNames = "abbr|article|aside|audio|bdi|canvas|data|datalist|details|figcaption|figure|footer|" +
		"header|hgroup|mark|meter|nav|output|progress|section|summary|time|video",
	rinlinejQuery = / jQuery\d+="(?:null|\d+)"/g,
	rleadingWhitespace = /^\s+/,
	rxhtmlTag = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/gi,
	rtagName = /<([\w:]+)/,
	rtbody = /<tbody/i,
	rhtml = /<|&#?\w+;/,
	rnoInnerhtml = /<(?:script|style|link)/i,
	rnocache = /<(?:script|object|embed|option|style)/i,
	rnoshimcache = new RegExp("<(?:" + nodeNames + ")[\\s/>]", "i"),
	rcheckableType = /^(?:checkbox|radio)$/,
	// checked="checked" or checked
	rchecked = /checked\s*(?:[^=]|=\s*.checked.)/i,
	rscriptType = /\/(java|ecma)script/i,
	rcleanScript = /^\s*<!(?:\[CDATA\[|\-\-)|[\]\-]{2}>\s*$/g,
	wrapMap = {
		option: [ 1, "<select multiple='multiple'>", "</select>" ],
		legend: [ 1, "<fieldset>", "</fieldset>" ],
		thead: [ 1, "<table>", "</table>" ],
		tr: [ 2, "<table><tbody>", "</tbody></table>" ],
		td: [ 3, "<table><tbody><tr>", "</tr></tbody></table>" ],
		col: [ 2, "<table><tbody></tbody><colgroup>", "</colgroup></table>" ],
		area: [ 1, "<map>", "</map>" ],
		_default: [ 0, "", "" ]
	},
	safeFragment = createSafeFragment( document ),
	fragmentDiv = safeFragment.appendChild( document.createElement("div") );

wrapMap.optgroup = wrapMap.option;
wrapMap.tbody = wrapMap.tfoot = wrapMap.colgroup = wrapMap.caption = wrapMap.thead;
wrapMap.th = wrapMap.td;

// IE6-8 can't serialize link, script, style, or any html5 (NoScope) tags,
// unless wrapped in a div with non-breaking characters in front of it.
if ( !jQuery.support.htmlSerialize ) {
	wrapMap._default = [ 1, "X<div>", "</div>" ];
}

jQuery.fn.extend({
	text: function( value ) {
		return jQuery.access( this, function( value ) {
			return value === undefined ?
				jQuery.text( this ) :
				this.empty().append( ( this[0] && this[0].ownerDocument || document ).createTextNode( value ) );
		}, null, value, arguments.length );
	},

	wrapAll: function( html ) {
		if ( jQuery.isFunction( html ) ) {
			return this.each(function(i) {
				jQuery(this).wrapAll( html.call(this, i) );
			});
		}

		if ( this[0] ) {
			// The elements to wrap the target around
			var wrap = jQuery( html, this[0].ownerDocument ).eq(0).clone(true);

			if ( this[0].parentNode ) {
				wrap.insertBefore( this[0] );
			}

			wrap.map(function() {
				var elem = this;

				while ( elem.firstChild && elem.firstChild.nodeType === 1 ) {
					elem = elem.firstChild;
				}

				return elem;
			}).append( this );
		}

		return this;
	},

	wrapInner: function( html ) {
		if ( jQuery.isFunction( html ) ) {
			return this.each(function(i) {
				jQuery(this).wrapInner( html.call(this, i) );
			});
		}

		return this.each(function() {
			var self = jQuery( this ),
				contents = self.contents();

			if ( contents.length ) {
				contents.wrapAll( html );

			} else {
				self.append( html );
			}
		});
	},

	wrap: function( html ) {
		var isFunction = jQuery.isFunction( html );

		return this.each(function(i) {
			jQuery( this ).wrapAll( isFunction ? html.call(this, i) : html );
		});
	},

	unwrap: function() {
		return this.parent().each(function() {
			if ( !jQuery.nodeName( this, "body" ) ) {
				jQuery( this ).replaceWith( this.childNodes );
			}
		}).end();
	},

	append: function() {
		return this.domManip(arguments, true, function( elem ) {
			if ( this.nodeType === 1 || this.nodeType === 11 ) {
				this.appendChild( elem );
			}
		});
	},

	prepend: function() {
		return this.domManip(arguments, true, function( elem ) {
			if ( this.nodeType === 1 || this.nodeType === 11 ) {
				this.insertBefore( elem, this.firstChild );
			}
		});
	},

	before: function() {
		if ( !isDisconnected( this[0] ) ) {
			return this.domManip(arguments, false, function( elem ) {
				this.parentNode.insertBefore( elem, this );
			});
		}

		if ( arguments.length ) {
			var set = jQuery.clean( arguments );
			return this.pushStack( jQuery.merge( set, this ), "before", this.selector );
		}
	},

	after: function() {
		if ( !isDisconnected( this[0] ) ) {
			return this.domManip(arguments, false, function( elem ) {
				this.parentNode.insertBefore( elem, this.nextSibling );
			});
		}

		if ( arguments.length ) {
			var set = jQuery.clean( arguments );
			return this.pushStack( jQuery.merge( this, set ), "after", this.selector );
		}
	},

	// keepData is for internal use only--do not document
	remove: function( selector, keepData ) {
		var elem,
			i = 0;

		for ( ; (elem = this[i]) != null; i++ ) {
			if ( !selector || jQuery.filter( selector, [ elem ] ).length ) {
				if ( !keepData && elem.nodeType === 1 ) {
					jQuery.cleanData( elem.getElementsByTagName("*") );
					jQuery.cleanData( [ elem ] );
				}

				if ( elem.parentNode ) {
					elem.parentNode.removeChild( elem );
				}
			}
		}

		return this;
	},

	empty: function() {
		var elem,
			i = 0;

		for ( ; (elem = this[i]) != null; i++ ) {
			// Remove element nodes and prevent memory leaks
			if ( elem.nodeType === 1 ) {
				jQuery.cleanData( elem.getElementsByTagName("*") );
			}

			// Remove any remaining nodes
			while ( elem.firstChild ) {
				elem.removeChild( elem.firstChild );
			}
		}

		return this;
	},

	clone: function( dataAndEvents, deepDataAndEvents ) {
		dataAndEvents = dataAndEvents == null ? false : dataAndEvents;
		deepDataAndEvents = deepDataAndEvents == null ? dataAndEvents : deepDataAndEvents;

		return this.map( function () {
			return jQuery.clone( this, dataAndEvents, deepDataAndEvents );
		});
	},

	html: function( value ) {
		return jQuery.access( this, function( value ) {
			var elem = this[0] || {},
				i = 0,
				l = this.length;

			if ( value === undefined ) {
				return elem.nodeType === 1 ?
					elem.innerHTML.replace( rinlinejQuery, "" ) :
					undefined;
			}

			// See if we can take a shortcut and just use innerHTML
			if ( typeof value === "string" && !rnoInnerhtml.test( value ) &&
				( jQuery.support.htmlSerialize || !rnoshimcache.test( value )  ) &&
				( jQuery.support.leadingWhitespace || !rleadingWhitespace.test( value ) ) &&
				!wrapMap[ ( rtagName.exec( value ) || ["", ""] )[1].toLowerCase() ] ) {

				value = value.replace( rxhtmlTag, "<$1></$2>" );

				try {
					for (; i < l; i++ ) {
						// Remove element nodes and prevent memory leaks
						elem = this[i] || {};
						if ( elem.nodeType === 1 ) {
							jQuery.cleanData( elem.getElementsByTagName( "*" ) );
							elem.innerHTML = value;
						}
					}

					elem = 0;

				// If using innerHTML throws an exception, use the fallback method
				} catch(e) {}
			}

			if ( elem ) {
				this.empty().append( value );
			}
		}, null, value, arguments.length );
	},

	replaceWith: function( value ) {
		if ( !isDisconnected( this[0] ) ) {
			// Make sure that the elements are removed from the DOM before they are inserted
			// this can help fix replacing a parent with child elements
			if ( jQuery.isFunction( value ) ) {
				return this.each(function(i) {
					var self = jQuery(this), old = self.html();
					self.replaceWith( value.call( this, i, old ) );
				});
			}

			if ( typeof value !== "string" ) {
				value = jQuery( value ).detach();
			}

			return this.each(function() {
				var next = this.nextSibling,
					parent = this.parentNode;

				jQuery( this ).remove();

				if ( next ) {
					jQuery(next).before( value );
				} else {
					jQuery(parent).append( value );
				}
			});
		}

		return this.length ?
			this.pushStack( jQuery(jQuery.isFunction(value) ? value() : value), "replaceWith", value ) :
			this;
	},

	detach: function( selector ) {
		return this.remove( selector, true );
	},

	domManip: function( args, table, callback ) {

		// Flatten any nested arrays
		args = [].concat.apply( [], args );

		var results, first, fragment, iNoClone,
			i = 0,
			value = args[0],
			scripts = [],
			l = this.length;

		// We can't cloneNode fragments that contain checked, in WebKit
		if ( !jQuery.support.checkClone && l > 1 && typeof value === "string" && rchecked.test( value ) ) {
			return this.each(function() {
				jQuery(this).domManip( args, table, callback );
			});
		}

		if ( jQuery.isFunction(value) ) {
			return this.each(function(i) {
				var self = jQuery(this);
				args[0] = value.call( this, i, table ? self.html() : undefined );
				self.domManip( args, table, callback );
			});
		}

		if ( this[0] ) {
			results = jQuery.buildFragment( args, this, scripts );
			fragment = results.fragment;
			first = fragment.firstChild;

			if ( fragment.childNodes.length === 1 ) {
				fragment = first;
			}

			if ( first ) {
				table = table && jQuery.nodeName( first, "tr" );

				// Use the original fragment for the last item instead of the first because it can end up
				// being emptied incorrectly in certain situations (#8070).
				// Fragments from the fragment cache must always be cloned and never used in place.
				for ( iNoClone = results.cacheable || l - 1; i < l; i++ ) {
					callback.call(
						table && jQuery.nodeName( this[i], "table" ) ?
							findOrAppend( this[i], "tbody" ) :
							this[i],
						i === iNoClone ?
							fragment :
							jQuery.clone( fragment, true, true )
					);
				}
			}

			// Fix #11809: Avoid leaking memory
			fragment = first = null;

			if ( scripts.length ) {
				jQuery.each( scripts, function( i, elem ) {
					if ( elem.src ) {
						if ( jQuery.ajax ) {
							jQuery.ajax({
								url: elem.src,
								type: "GET",
								dataType: "script",
								async: false,
								global: false,
								"throws": true
							});
						} else {
							jQuery.error("no ajax");
						}
					} else {
						jQuery.globalEval( ( elem.text || elem.textContent || elem.innerHTML || "" ).replace( rcleanScript, "" ) );
					}

					if ( elem.parentNode ) {
						elem.parentNode.removeChild( elem );
					}
				});
			}
		}

		return this;
	}
});

function findOrAppend( elem, tag ) {
	return elem.getElementsByTagName( tag )[0] || elem.appendChild( elem.ownerDocument.createElement( tag ) );
}

function cloneCopyEvent( src, dest ) {

	if ( dest.nodeType !== 1 || !jQuery.hasData( src ) ) {
		return;
	}

	var type, i, l,
		oldData = jQuery._data( src ),
		curData = jQuery._data( dest, oldData ),
		events = oldData.events;

	if ( events ) {
		delete curData.handle;
		curData.events = {};

		for ( type in events ) {
			for ( i = 0, l = events[ type ].length; i < l; i++ ) {
				jQuery.event.add( dest, type, events[ type ][ i ] );
			}
		}
	}

	// make the cloned public data object a copy from the original
	if ( curData.data ) {
		curData.data = jQuery.extend( {}, curData.data );
	}
}

function cloneFixAttributes( src, dest ) {
	var nodeName;

	// We do not need to do anything for non-Elements
	if ( dest.nodeType !== 1 ) {
		return;
	}

	// clearAttributes removes the attributes, which we don't want,
	// but also removes the attachEvent events, which we *do* want
	if ( dest.clearAttributes ) {
		dest.clearAttributes();
	}

	// mergeAttributes, in contrast, only merges back on the
	// original attributes, not the events
	if ( dest.mergeAttributes ) {
		dest.mergeAttributes( src );
	}

	nodeName = dest.nodeName.toLowerCase();

	if ( nodeName === "object" ) {
		// IE6-10 improperly clones children of object elements using classid.
		// IE10 throws NoModificationAllowedError if parent is null, #12132.
		if ( dest.parentNode ) {
			dest.outerHTML = src.outerHTML;
		}

		// This path appears unavoidable for IE9. When cloning an object
		// element in IE9, the outerHTML strategy above is not sufficient.
		// If the src has innerHTML and the destination does not,
		// copy the src.innerHTML into the dest.innerHTML. #10324
		if ( jQuery.support.html5Clone && (src.innerHTML && !jQuery.trim(dest.innerHTML)) ) {
			dest.innerHTML = src.innerHTML;
		}

	} else if ( nodeName === "input" && rcheckableType.test( src.type ) ) {
		// IE6-8 fails to persist the checked state of a cloned checkbox
		// or radio button. Worse, IE6-7 fail to give the cloned element
		// a checked appearance if the defaultChecked value isn't also set

		dest.defaultChecked = dest.checked = src.checked;

		// IE6-7 get confused and end up setting the value of a cloned
		// checkbox/radio button to an empty string instead of "on"
		if ( dest.value !== src.value ) {
			dest.value = src.value;
		}

	// IE6-8 fails to return the selected option to the default selected
	// state when cloning options
	} else if ( nodeName === "option" ) {
		dest.selected = src.defaultSelected;

	// IE6-8 fails to set the defaultValue to the correct value when
	// cloning other types of input fields
	} else if ( nodeName === "input" || nodeName === "textarea" ) {
		dest.defaultValue = src.defaultValue;

	// IE blanks contents when cloning scripts
	} else if ( nodeName === "script" && dest.text !== src.text ) {
		dest.text = src.text;
	}

	// Event data gets referenced instead of copied if the expando
	// gets copied too
	dest.removeAttribute( jQuery.expando );
}

jQuery.buildFragment = function( args, context, scripts ) {
	var fragment, cacheable, cachehit,
		first = args[ 0 ];

	// Set context from what may come in as undefined or a jQuery collection or a node
	// Updated to fix #12266 where accessing context[0] could throw an exception in IE9/10 &
	// also doubles as fix for #8950 where plain objects caused createDocumentFragment exception
	context = context || document;
	context = !context.nodeType && context[0] || context;
	context = context.ownerDocument || context;

	// Only cache "small" (1/2 KB) HTML strings that are associated with the main document
	// Cloning options loses the selected state, so don't cache them
	// IE 6 doesn't like it when you put <object> or <embed> elements in a fragment
	// Also, WebKit does not clone 'checked' attributes on cloneNode, so don't cache
	// Lastly, IE6,7,8 will not correctly reuse cached fragments that were created from unknown elems #10501
	if ( args.length === 1 && typeof first === "string" && first.length < 512 && context === document &&
		first.charAt(0) === "<" && !rnocache.test( first ) &&
		(jQuery.support.checkClone || !rchecked.test( first )) &&
		(jQuery.support.html5Clone || !rnoshimcache.test( first )) ) {

		// Mark cacheable and look for a hit
		cacheable = true;
		fragment = jQuery.fragments[ first ];
		cachehit = fragment !== undefined;
	}

	if ( !fragment ) {
		fragment = context.createDocumentFragment();
		jQuery.clean( args, context, fragment, scripts );

		// Update the cache, but only store false
		// unless this is a second parsing of the same content
		if ( cacheable ) {
			jQuery.fragments[ first ] = cachehit && fragment;
		}
	}

	return { fragment: fragment, cacheable: cacheable };
};

jQuery.fragments = {};

jQuery.each({
	appendTo: "append",
	prependTo: "prepend",
	insertBefore: "before",
	insertAfter: "after",
	replaceAll: "replaceWith"
}, function( name, original ) {
	jQuery.fn[ name ] = function( selector ) {
		var elems,
			i = 0,
			ret = [],
			insert = jQuery( selector ),
			l = insert.length,
			parent = this.length === 1 && this[0].parentNode;

		if ( (parent == null || parent && parent.nodeType === 11 && parent.childNodes.length === 1) && l === 1 ) {
			insert[ original ]( this[0] );
			return this;
		} else {
			for ( ; i < l; i++ ) {
				elems = ( i > 0 ? this.clone(true) : this ).get();
				jQuery( insert[i] )[ original ]( elems );
				ret = ret.concat( elems );
			}

			return this.pushStack( ret, name, insert.selector );
		}
	};
});

function getAll( elem ) {
	if ( typeof elem.getElementsByTagName !== "undefined" ) {
		return elem.getElementsByTagName( "*" );

	} else if ( typeof elem.querySelectorAll !== "undefined" ) {
		return elem.querySelectorAll( "*" );

	} else {
		return [];
	}
}

// Used in clean, fixes the defaultChecked property
function fixDefaultChecked( elem ) {
	if ( rcheckableType.test( elem.type ) ) {
		elem.defaultChecked = elem.checked;
	}
}

jQuery.extend({
	clone: function( elem, dataAndEvents, deepDataAndEvents ) {
		var srcElements,
			destElements,
			i,
			clone;

		if ( jQuery.support.html5Clone || jQuery.isXMLDoc(elem) || !rnoshimcache.test( "<" + elem.nodeName + ">" ) ) {
			clone = elem.cloneNode( true );

		// IE<=8 does not properly clone detached, unknown element nodes
		} else {
			fragmentDiv.innerHTML = elem.outerHTML;
			fragmentDiv.removeChild( clone = fragmentDiv.firstChild );
		}

		if ( (!jQuery.support.noCloneEvent || !jQuery.support.noCloneChecked) &&
				(elem.nodeType === 1 || elem.nodeType === 11) && !jQuery.isXMLDoc(elem) ) {
			// IE copies events bound via attachEvent when using cloneNode.
			// Calling detachEvent on the clone will also remove the events
			// from the original. In order to get around this, we use some
			// proprietary methods to clear the events. Thanks to MooTools
			// guys for this hotness.

			cloneFixAttributes( elem, clone );

			// Using Sizzle here is crazy slow, so we use getElementsByTagName instead
			srcElements = getAll( elem );
			destElements = getAll( clone );

			// Weird iteration because IE will replace the length property
			// with an element if you are cloning the body and one of the
			// elements on the page has a name or id of "length"
			for ( i = 0; srcElements[i]; ++i ) {
				// Ensure that the destination node is not null; Fixes #9587
				if ( destElements[i] ) {
					cloneFixAttributes( srcElements[i], destElements[i] );
				}
			}
		}

		// Copy the events from the original to the clone
		if ( dataAndEvents ) {
			cloneCopyEvent( elem, clone );

			if ( deepDataAndEvents ) {
				srcElements = getAll( elem );
				destElements = getAll( clone );

				for ( i = 0; srcElements[i]; ++i ) {
					cloneCopyEvent( srcElements[i], destElements[i] );
				}
			}
		}

		srcElements = destElements = null;

		// Return the cloned set
		return clone;
	},

	clean: function( elems, context, fragment, scripts ) {
		var i, j, elem, tag, wrap, depth, div, hasBody, tbody, len, handleScript, jsTags,
			safe = context === document && safeFragment,
			ret = [];

		// Ensure that context is a document
		if ( !context || typeof context.createDocumentFragment === "undefined" ) {
			context = document;
		}

		// Use the already-created safe fragment if context permits
		for ( i = 0; (elem = elems[i]) != null; i++ ) {
			if ( typeof elem === "number" ) {
				elem += "";
			}

			if ( !elem ) {
				continue;
			}

			// Convert html string into DOM nodes
			if ( typeof elem === "string" ) {
				if ( !rhtml.test( elem ) ) {
					elem = context.createTextNode( elem );
				} else {
					// Ensure a safe container in which to render the html
					safe = safe || createSafeFragment( context );
					div = context.createElement("div");
					safe.appendChild( div );

					// Fix "XHTML"-style tags in all browsers
					elem = elem.replace(rxhtmlTag, "<$1></$2>");

					// Go to html and back, then peel off extra wrappers
					tag = ( rtagName.exec( elem ) || ["", ""] )[1].toLowerCase();
					wrap = wrapMap[ tag ] || wrapMap._default;
					depth = wrap[0];
					div.innerHTML = wrap[1] + elem + wrap[2];

					// Move to the right depth
					while ( depth-- ) {
						div = div.lastChild;
					}

					// Remove IE's autoinserted <tbody> from table fragments
					if ( !jQuery.support.tbody ) {

						// String was a <table>, *may* have spurious <tbody>
						hasBody = rtbody.test(elem);
							tbody = tag === "table" && !hasBody ?
								div.firstChild && div.firstChild.childNodes :

								// String was a bare <thead> or <tfoot>
								wrap[1] === "<table>" && !hasBody ?
									div.childNodes :
									[];

						for ( j = tbody.length - 1; j >= 0 ; --j ) {
							if ( jQuery.nodeName( tbody[ j ], "tbody" ) && !tbody[ j ].childNodes.length ) {
								tbody[ j ].parentNode.removeChild( tbody[ j ] );
							}
						}
					}

					// IE completely kills leading whitespace when innerHTML is used
					if ( !jQuery.support.leadingWhitespace && rleadingWhitespace.test( elem ) ) {
						div.insertBefore( context.createTextNode( rleadingWhitespace.exec(elem)[0] ), div.firstChild );
					}

					elem = div.childNodes;

					// Take out of fragment container (we need a fresh div each time)
					div.parentNode.removeChild( div );
				}
			}

			if ( elem.nodeType ) {
				ret.push( elem );
			} else {
				jQuery.merge( ret, elem );
			}
		}

		// Fix #11356: Clear elements from safeFragment
		if ( div ) {
			elem = div = safe = null;
		}

		// Reset defaultChecked for any radios and checkboxes
		// about to be appended to the DOM in IE 6/7 (#8060)
		if ( !jQuery.support.appendChecked ) {
			for ( i = 0; (elem = ret[i]) != null; i++ ) {
				if ( jQuery.nodeName( elem, "input" ) ) {
					fixDefaultChecked( elem );
				} else if ( typeof elem.getElementsByTagName !== "undefined" ) {
					jQuery.grep( elem.getElementsByTagName("input"), fixDefaultChecked );
				}
			}
		}

		// Append elements to a provided document fragment
		if ( fragment ) {
			// Special handling of each script element
			handleScript = function( elem ) {
				// Check if we consider it executable
				if ( !elem.type || rscriptType.test( elem.type ) ) {
					// Detach the script and store it in the scripts array (if provided) or the fragment
					// Return truthy to indicate that it has been handled
					return scripts ?
						scripts.push( elem.parentNode ? elem.parentNode.removeChild( elem ) : elem ) :
						fragment.appendChild( elem );
				}
			};

			for ( i = 0; (elem = ret[i]) != null; i++ ) {
				// Check if we're done after handling an executable script
				if ( !( jQuery.nodeName( elem, "script" ) && handleScript( elem ) ) ) {
					// Append to fragment and handle embedded scripts
					fragment.appendChild( elem );
					if ( typeof elem.getElementsByTagName !== "undefined" ) {
						// handleScript alters the DOM, so use jQuery.merge to ensure snapshot iteration
						jsTags = jQuery.grep( jQuery.merge( [], elem.getElementsByTagName("script") ), handleScript );

						// Splice the scripts into ret after their former ancestor and advance our index beyond them
						ret.splice.apply( ret, [i + 1, 0].concat( jsTags ) );
						i += jsTags.length;
					}
				}
			}
		}

		return ret;
	},

	cleanData: function( elems, /* internal */ acceptData ) {
		var data, id, elem, type,
			i = 0,
			internalKey = jQuery.expando,
			cache = jQuery.cache,
			deleteExpando = jQuery.support.deleteExpando,
			special = jQuery.event.special;

		for ( ; (elem = elems[i]) != null; i++ ) {

			if ( acceptData || jQuery.acceptData( elem ) ) {

				id = elem[ internalKey ];
				data = id && cache[ id ];

				if ( data ) {
					if ( data.events ) {
						for ( type in data.events ) {
							if ( special[ type ] ) {
								jQuery.event.remove( elem, type );

							// This is a shortcut to avoid jQuery.event.remove's overhead
							} else {
								jQuery.removeEvent( elem, type, data.handle );
							}
						}
					}

					// Remove cache only if it was not already removed by jQuery.event.remove
					if ( cache[ id ] ) {

						delete cache[ id ];

						// IE does not allow us to delete expando properties from nodes,
						// nor does it have a removeAttribute function on Document nodes;
						// we must handle all of these cases
						if ( deleteExpando ) {
							delete elem[ internalKey ];

						} else if ( elem.removeAttribute ) {
							elem.removeAttribute( internalKey );

						} else {
							elem[ internalKey ] = null;
						}

						jQuery.deletedIds.push( id );
					}
				}
			}
		}
	}
});
// Limit scope pollution from any deprecated API
(function() {

var matched, browser;

// Use of jQuery.browser is frowned upon.
// More details: http://api.jquery.com/jQuery.browser
// jQuery.uaMatch maintained for back-compat
jQuery.uaMatch = function( ua ) {
	ua = ua.toLowerCase();

	var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
		/(webkit)[ \/]([\w.]+)/.exec( ua ) ||
		/(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
		/(msie) ([\w.]+)/.exec( ua ) ||
		ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
		[];

	return {
		browser: match[ 1 ] || "",
		version: match[ 2 ] || "0"
	};
};

matched = jQuery.uaMatch( navigator.userAgent );
browser = {};

if ( matched.browser ) {
	browser[ matched.browser ] = true;
	browser.version = matched.version;
}

// Chrome is Webkit, but Webkit is also Safari.
if ( browser.chrome ) {
	browser.webkit = true;
} else if ( browser.webkit ) {
	browser.safari = true;
}

jQuery.browser = browser;

jQuery.sub = function() {
	function jQuerySub( selector, context ) {
		return new jQuerySub.fn.init( selector, context );
	}
	jQuery.extend( true, jQuerySub, this );
	jQuerySub.superclass = this;
	jQuerySub.fn = jQuerySub.prototype = this();
	jQuerySub.fn.constructor = jQuerySub;
	jQuerySub.sub = this.sub;
	jQuerySub.fn.init = function init( selector, context ) {
		if ( context && context instanceof jQuery && !(context instanceof jQuerySub) ) {
			context = jQuerySub( context );
		}

		return jQuery.fn.init.call( this, selector, context, rootjQuerySub );
	};
	jQuerySub.fn.init.prototype = jQuerySub.fn;
	var rootjQuerySub = jQuerySub(document);
	return jQuerySub;
};

})();
var curCSS, iframe, iframeDoc,
	ralpha = /alpha\([^)]*\)/i,
	ropacity = /opacity=([^)]*)/,
	rposition = /^(top|right|bottom|left)$/,
	// swappable if display is none or starts with table except "table", "table-cell", or "table-caption"
	// see here for display values: https://developer.mozilla.org/en-US/docs/CSS/display
	rdisplayswap = /^(none|table(?!-c[ea]).+)/,
	rmargin = /^margin/,
	rnumsplit = new RegExp( "^(" + core_pnum + ")(.*)$", "i" ),
	rnumnonpx = new RegExp( "^(" + core_pnum + ")(?!px)[a-z%]+$", "i" ),
	rrelNum = new RegExp( "^([-+])=(" + core_pnum + ")", "i" ),
	elemdisplay = { BODY: "block" },

	cssShow = { position: "absolute", visibility: "hidden", display: "block" },
	cssNormalTransform = {
		letterSpacing: 0,
		fontWeight: 400
	},

	cssExpand = [ "Top", "Right", "Bottom", "Left" ],
	cssPrefixes = [ "Webkit", "O", "Moz", "ms" ],

	eventsToggle = jQuery.fn.toggle;

// return a css property mapped to a potentially vendor prefixed property
function vendorPropName( style, name ) {

	// shortcut for names that are not vendor prefixed
	if ( name in style ) {
		return name;
	}

	// check for vendor prefixed names
	var capName = name.charAt(0).toUpperCase() + name.slice(1),
		origName = name,
		i = cssPrefixes.length;

	while ( i-- ) {
		name = cssPrefixes[ i ] + capName;
		if ( name in style ) {
			return name;
		}
	}

	return origName;
}

function isHidden( elem, el ) {
	elem = el || elem;
	return jQuery.css( elem, "display" ) === "none" || !jQuery.contains( elem.ownerDocument, elem );
}

function showHide( elements, show ) {
	var elem, display,
		values = [],
		index = 0,
		length = elements.length;

	for ( ; index < length; index++ ) {
		elem = elements[ index ];
		if ( !elem.style ) {
			continue;
		}
		values[ index ] = jQuery._data( elem, "olddisplay" );
		if ( show ) {
			// Reset the inline display of this element to learn if it is
			// being hidden by cascaded rules or not
			if ( !values[ index ] && elem.style.display === "none" ) {
				elem.style.display = "";
			}

			// Set elements which have been overridden with display: none
			// in a stylesheet to whatever the default browser style is
			// for such an element
			if ( elem.style.display === "" && isHidden( elem ) ) {
				values[ index ] = jQuery._data( elem, "olddisplay", css_defaultDisplay(elem.nodeName) );
			}
		} else {
			display = curCSS( elem, "display" );

			if ( !values[ index ] && display !== "none" ) {
				jQuery._data( elem, "olddisplay", display );
			}
		}
	}

	// Set the display of most of the elements in a second loop
	// to avoid the constant reflow
	for ( index = 0; index < length; index++ ) {
		elem = elements[ index ];
		if ( !elem.style ) {
			continue;
		}
		if ( !show || elem.style.display === "none" || elem.style.display === "" ) {
			elem.style.display = show ? values[ index ] || "" : "none";
		}
	}

	return elements;
}

jQuery.fn.extend({
	css: function( name, value ) {
		return jQuery.access( this, function( elem, name, value ) {
			return value !== undefined ?
				jQuery.style( elem, name, value ) :
				jQuery.css( elem, name );
		}, name, value, arguments.length > 1 );
	},
	show: function() {
		return showHide( this, true );
	},
	hide: function() {
		return showHide( this );
	},
	toggle: function( state, fn2 ) {
		var bool = typeof state === "boolean";

		if ( jQuery.isFunction( state ) && jQuery.isFunction( fn2 ) ) {
			return eventsToggle.apply( this, arguments );
		}

		return this.each(function() {
			if ( bool ? state : isHidden( this ) ) {
				jQuery( this ).show();
			} else {
				jQuery( this ).hide();
			}
		});
	}
});

jQuery.extend({
	// Add in style property hooks for overriding the default
	// behavior of getting and setting a style property
	cssHooks: {
		opacity: {
			get: function( elem, computed ) {
				if ( computed ) {
					// We should always get a number back from opacity
					var ret = curCSS( elem, "opacity" );
					return ret === "" ? "1" : ret;

				}
			}
		}
	},

	// Exclude the following css properties to add px
	cssNumber: {
		"fillOpacity": true,
		"fontWeight": true,
		"lineHeight": true,
		"opacity": true,
		"orphans": true,
		"widows": true,
		"zIndex": true,
		"zoom": true
	},

	// Add in properties whose names you wish to fix before
	// setting or getting the value
	cssProps: {
		// normalize float css property
		"float": jQuery.support.cssFloat ? "cssFloat" : "styleFloat"
	},

	// Get and set the style property on a DOM Node
	style: function( elem, name, value, extra ) {
		// Don't set styles on text and comment nodes
		if ( !elem || elem.nodeType === 3 || elem.nodeType === 8 || !elem.style ) {
			return;
		}

		// Make sure that we're working with the right name
		var ret, type, hooks,
			origName = jQuery.camelCase( name ),
			style = elem.style;

		name = jQuery.cssProps[ origName ] || ( jQuery.cssProps[ origName ] = vendorPropName( style, origName ) );

		// gets hook for the prefixed version
		// followed by the unprefixed version
		hooks = jQuery.cssHooks[ name ] || jQuery.cssHooks[ origName ];

		// Check if we're setting a value
		if ( value !== undefined ) {
			type = typeof value;

			// convert relative number strings (+= or -=) to relative numbers. #7345
			if ( type === "string" && (ret = rrelNum.exec( value )) ) {
				value = ( ret[1] + 1 ) * ret[2] + parseFloat( jQuery.css( elem, name ) );
				// Fixes bug #9237
				type = "number";
			}

			// Make sure that NaN and null values aren't set. See: #7116
			if ( value == null || type === "number" && isNaN( value ) ) {
				return;
			}

			// If a number was passed in, add 'px' to the (except for certain CSS properties)
			if ( type === "number" && !jQuery.cssNumber[ origName ] ) {
				value += "px";
			}

			// If a hook was provided, use that value, otherwise just set the specified value
			if ( !hooks || !("set" in hooks) || (value = hooks.set( elem, value, extra )) !== undefined ) {
				// Wrapped to prevent IE from throwing errors when 'invalid' values are provided
				// Fixes bug #5509
				try {
					style[ name ] = value;
				} catch(e) {}
			}

		} else {
			// If a hook was provided get the non-computed value from there
			if ( hooks && "get" in hooks && (ret = hooks.get( elem, false, extra )) !== undefined ) {
				return ret;
			}

			// Otherwise just get the value from the style object
			return style[ name ];
		}
	},

	css: function( elem, name, numeric, extra ) {
		var val, num, hooks,
			origName = jQuery.camelCase( name );

		// Make sure that we're working with the right name
		name = jQuery.cssProps[ origName ] || ( jQuery.cssProps[ origName ] = vendorPropName( elem.style, origName ) );

		// gets hook for the prefixed version
		// followed by the unprefixed version
		hooks = jQuery.cssHooks[ name ] || jQuery.cssHooks[ origName ];

		// If a hook was provided get the computed value from there
		if ( hooks && "get" in hooks ) {
			val = hooks.get( elem, true, extra );
		}

		// Otherwise, if a way to get the computed value exists, use that
		if ( val === undefined ) {
			val = curCSS( elem, name );
		}

		//convert "normal" to computed value
		if ( val === "normal" && name in cssNormalTransform ) {
			val = cssNormalTransform[ name ];
		}

		// Return, converting to number if forced or a qualifier was provided and val looks numeric
		if ( numeric || extra !== undefined ) {
			num = parseFloat( val );
			return numeric || jQuery.isNumeric( num ) ? num || 0 : val;
		}
		return val;
	},

	// A method for quickly swapping in/out CSS properties to get correct calculations
	swap: function( elem, options, callback ) {
		var ret, name,
			old = {};

		// Remember the old values, and insert the new ones
		for ( name in options ) {
			old[ name ] = elem.style[ name ];
			elem.style[ name ] = options[ name ];
		}

		ret = callback.call( elem );

		// Revert the old values
		for ( name in options ) {
			elem.style[ name ] = old[ name ];
		}

		return ret;
	}
});

// NOTE: To any future maintainer, we've window.getComputedStyle
// because jsdom on node.js will break without it.
if ( window.getComputedStyle ) {
	curCSS = function( elem, name ) {
		var ret, width, minWidth, maxWidth,
			computed = window.getComputedStyle( elem, null ),
			style = elem.style;

		if ( computed ) {

			// getPropertyValue is only needed for .css('filter') in IE9, see #12537
			ret = computed.getPropertyValue( name ) || computed[ name ];

			if ( ret === "" && !jQuery.contains( elem.ownerDocument, elem ) ) {
				ret = jQuery.style( elem, name );
			}

			// A tribute to the "awesome hack by Dean Edwards"
			// Chrome < 17 and Safari 5.0 uses "computed value" instead of "used value" for margin-right
			// Safari 5.1.7 (at least) returns percentage for a larger set of values, but width seems to be reliably pixels
			// this is against the CSSOM draft spec: http://dev.w3.org/csswg/cssom/#resolved-values
			if ( rnumnonpx.test( ret ) && rmargin.test( name ) ) {
				width = style.width;
				minWidth = style.minWidth;
				maxWidth = style.maxWidth;

				style.minWidth = style.maxWidth = style.width = ret;
				ret = computed.width;

				style.width = width;
				style.minWidth = minWidth;
				style.maxWidth = maxWidth;
			}
		}

		return ret;
	};
} else if ( document.documentElement.currentStyle ) {
	curCSS = function( elem, name ) {
		var left, rsLeft,
			ret = elem.currentStyle && elem.currentStyle[ name ],
			style = elem.style;

		// Avoid setting ret to empty string here
		// so we don't default to auto
		if ( ret == null && style && style[ name ] ) {
			ret = style[ name ];
		}

		// From the awesome hack by Dean Edwards
		// http://erik.eae.net/archives/2007/07/27/18.54.15/#comment-102291

		// If we're not dealing with a regular pixel number
		// but a number that has a weird ending, we need to convert it to pixels
		// but not position css attributes, as those are proportional to the parent element instead
		// and we can't measure the parent instead because it might trigger a "stacking dolls" problem
		if ( rnumnonpx.test( ret ) && !rposition.test( name ) ) {

			// Remember the original values
			left = style.left;
			rsLeft = elem.runtimeStyle && elem.runtimeStyle.left;

			// Put in the new values to get a computed value out
			if ( rsLeft ) {
				elem.runtimeStyle.left = elem.currentStyle.left;
			}
			style.left = name === "fontSize" ? "1em" : ret;
			ret = style.pixelLeft + "px";

			// Revert the changed values
			style.left = left;
			if ( rsLeft ) {
				elem.runtimeStyle.left = rsLeft;
			}
		}

		return ret === "" ? "auto" : ret;
	};
}

function setPositiveNumber( elem, value, subtract ) {
	var matches = rnumsplit.exec( value );
	return matches ?
			Math.max( 0, matches[ 1 ] - ( subtract || 0 ) ) + ( matches[ 2 ] || "px" ) :
			value;
}

function augmentWidthOrHeight( elem, name, extra, isBorderBox ) {
	var i = extra === ( isBorderBox ? "border" : "content" ) ?
		// If we already have the right measurement, avoid augmentation
		4 :
		// Otherwise initialize for horizontal or vertical properties
		name === "width" ? 1 : 0,

		val = 0;

	for ( ; i < 4; i += 2 ) {
		// both box models exclude margin, so add it if we want it
		if ( extra === "margin" ) {
			// we use jQuery.css instead of curCSS here
			// because of the reliableMarginRight CSS hook!
			val += jQuery.css( elem, extra + cssExpand[ i ], true );
		}

		// From this point on we use curCSS for maximum performance (relevant in animations)
		if ( isBorderBox ) {
			// border-box includes padding, so remove it if we want content
			if ( extra === "content" ) {
				val -= parseFloat( curCSS( elem, "padding" + cssExpand[ i ] ) ) || 0;
			}

			// at this point, extra isn't border nor margin, so remove border
			if ( extra !== "margin" ) {
				val -= parseFloat( curCSS( elem, "border" + cssExpand[ i ] + "Width" ) ) || 0;
			}
		} else {
			// at this point, extra isn't content, so add padding
			val += parseFloat( curCSS( elem, "padding" + cssExpand[ i ] ) ) || 0;

			// at this point, extra isn't content nor padding, so add border
			if ( extra !== "padding" ) {
				val += parseFloat( curCSS( elem, "border" + cssExpand[ i ] + "Width" ) ) || 0;
			}
		}
	}

	return val;
}

function getWidthOrHeight( elem, name, extra ) {

	// Start with offset property, which is equivalent to the border-box value
	var val = name === "width" ? elem.offsetWidth : elem.offsetHeight,
		valueIsBorderBox = true,
		isBorderBox = jQuery.support.boxSizing && jQuery.css( elem, "boxSizing" ) === "border-box";

	// some non-html elements return undefined for offsetWidth, so check for null/undefined
	// svg - https://bugzilla.mozilla.org/show_bug.cgi?id=649285
	// MathML - https://bugzilla.mozilla.org/show_bug.cgi?id=491668
	if ( val <= 0 || val == null ) {
		// Fall back to computed then uncomputed css if necessary
		val = curCSS( elem, name );
		if ( val < 0 || val == null ) {
			val = elem.style[ name ];
		}

		// Computed unit is not pixels. Stop here and return.
		if ( rnumnonpx.test(val) ) {
			return val;
		}

		// we need the check for style in case a browser which returns unreliable values
		// for getComputedStyle silently falls back to the reliable elem.style
		valueIsBorderBox = isBorderBox && ( jQuery.support.boxSizingReliable || val === elem.style[ name ] );

		// Normalize "", auto, and prepare for extra
		val = parseFloat( val ) || 0;
	}

	// use the active box-sizing model to add/subtract irrelevant styles
	return ( val +
		augmentWidthOrHeight(
			elem,
			name,
			extra || ( isBorderBox ? "border" : "content" ),
			valueIsBorderBox
		)
	) + "px";
}


// Try to determine the default display value of an element
function css_defaultDisplay( nodeName ) {
	if ( elemdisplay[ nodeName ] ) {
		return elemdisplay[ nodeName ];
	}

	var elem = jQuery( "<" + nodeName + ">" ).appendTo( document.body ),
		display = elem.css("display");
	elem.remove();

	// If the simple way fails,
	// get element's real default display by attaching it to a temp iframe
	if ( display === "none" || display === "" ) {
		// Use the already-created iframe if possible
		iframe = document.body.appendChild(
			iframe || jQuery.extend( document.createElement("iframe"), {
				frameBorder: 0,
				width: 0,
				height: 0
			})
		);

		// Create a cacheable copy of the iframe document on first call.
		// IE and Opera will allow us to reuse the iframeDoc without re-writing the fake HTML
		// document to it; WebKit & Firefox won't allow reusing the iframe document.
		if ( !iframeDoc || !iframe.createElement ) {
			iframeDoc = ( iframe.contentWindow || iframe.contentDocument ).document;
			iframeDoc.write("<!doctype html><html><body>");
			iframeDoc.close();
		}

		elem = iframeDoc.body.appendChild( iframeDoc.createElement(nodeName) );

		display = curCSS( elem, "display" );
		document.body.removeChild( iframe );
	}

	// Store the correct default display
	elemdisplay[ nodeName ] = display;

	return display;
}

jQuery.each([ "height", "width" ], function( i, name ) {
	jQuery.cssHooks[ name ] = {
		get: function( elem, computed, extra ) {
			if ( computed ) {
				// certain elements can have dimension info if we invisibly show them
				// however, it must have a current display style that would benefit from this
				if ( elem.offsetWidth === 0 && rdisplayswap.test( curCSS( elem, "display" ) ) ) {
					return jQuery.swap( elem, cssShow, function() {
						return getWidthOrHeight( elem, name, extra );
					});
				} else {
					return getWidthOrHeight( elem, name, extra );
				}
			}
		},

		set: function( elem, value, extra ) {
			return setPositiveNumber( elem, value, extra ?
				augmentWidthOrHeight(
					elem,
					name,
					extra,
					jQuery.support.boxSizing && jQuery.css( elem, "boxSizing" ) === "border-box"
				) : 0
			);
		}
	};
});

if ( !jQuery.support.opacity ) {
	jQuery.cssHooks.opacity = {
		get: function( elem, computed ) {
			// IE uses filters for opacity
			return ropacity.test( (computed && elem.currentStyle ? elem.currentStyle.filter : elem.style.filter) || "" ) ?
				( 0.01 * parseFloat( RegExp.$1 ) ) + "" :
				computed ? "1" : "";
		},

		set: function( elem, value ) {
			var style = elem.style,
				currentStyle = elem.currentStyle,
				opacity = jQuery.isNumeric( value ) ? "alpha(opacity=" + value * 100 + ")" : "",
				filter = currentStyle && currentStyle.filter || style.filter || "";

			// IE has trouble with opacity if it does not have layout
			// Force it by setting the zoom level
			style.zoom = 1;

			// if setting opacity to 1, and no other filters exist - attempt to remove filter attribute #6652
			if ( value >= 1 && jQuery.trim( filter.replace( ralpha, "" ) ) === "" &&
				style.removeAttribute ) {

				// Setting style.filter to null, "" & " " still leave "filter:" in the cssText
				// if "filter:" is present at all, clearType is disabled, we want to avoid this
				// style.removeAttribute is IE Only, but so apparently is this code path...
				style.removeAttribute( "filter" );

				// if there there is no filter style applied in a css rule, we are done
				if ( currentStyle && !currentStyle.filter ) {
					return;
				}
			}

			// otherwise, set new filter values
			style.filter = ralpha.test( filter ) ?
				filter.replace( ralpha, opacity ) :
				filter + " " + opacity;
		}
	};
}

// These hooks cannot be added until DOM ready because the support test
// for it is not run until after DOM ready
jQuery(function() {
	if ( !jQuery.support.reliableMarginRight ) {
		jQuery.cssHooks.marginRight = {
			get: function( elem, computed ) {
				// WebKit Bug 13343 - getComputedStyle returns wrong value for margin-right
				// Work around by temporarily setting element display to inline-block
				return jQuery.swap( elem, { "display": "inline-block" }, function() {
					if ( computed ) {
						return curCSS( elem, "marginRight" );
					}
				});
			}
		};
	}

	// Webkit bug: https://bugs.webkit.org/show_bug.cgi?id=29084
	// getComputedStyle returns percent when specified for top/left/bottom/right
	// rather than make the css module depend on the offset module, we just check for it here
	if ( !jQuery.support.pixelPosition && jQuery.fn.position ) {
		jQuery.each( [ "top", "left" ], function( i, prop ) {
			jQuery.cssHooks[ prop ] = {
				get: function( elem, computed ) {
					if ( computed ) {
						var ret = curCSS( elem, prop );
						// if curCSS returns percentage, fallback to offset
						return rnumnonpx.test( ret ) ? jQuery( elem ).position()[ prop ] + "px" : ret;
					}
				}
			};
		});
	}

});

if ( jQuery.expr && jQuery.expr.filters ) {
	jQuery.expr.filters.hidden = function( elem ) {
		return ( elem.offsetWidth === 0 && elem.offsetHeight === 0 ) || (!jQuery.support.reliableHiddenOffsets && ((elem.style && elem.style.display) || curCSS( elem, "display" )) === "none");
	};

	jQuery.expr.filters.visible = function( elem ) {
		return !jQuery.expr.filters.hidden( elem );
	};
}

// These hooks are used by animate to expand properties
jQuery.each({
	margin: "",
	padding: "",
	border: "Width"
}, function( prefix, suffix ) {
	jQuery.cssHooks[ prefix + suffix ] = {
		expand: function( value ) {
			var i,

				// assumes a single number if not a string
				parts = typeof value === "string" ? value.split(" ") : [ value ],
				expanded = {};

			for ( i = 0; i < 4; i++ ) {
				expanded[ prefix + cssExpand[ i ] + suffix ] =
					parts[ i ] || parts[ i - 2 ] || parts[ 0 ];
			}

			return expanded;
		}
	};

	if ( !rmargin.test( prefix ) ) {
		jQuery.cssHooks[ prefix + suffix ].set = setPositiveNumber;
	}
});
var r20 = /%20/g,
	rbracket = /\[\]$/,
	rCRLF = /\r?\n/g,
	rinput = /^(?:color|date|datetime|datetime-local|email|hidden|month|number|password|range|search|tel|text|time|url|week)$/i,
	rselectTextarea = /^(?:select|textarea)/i;

jQuery.fn.extend({
	serialize: function() {
		return jQuery.param( this.serializeArray() );
	},
	serializeArray: function() {
		return this.map(function(){
			return this.elements ? jQuery.makeArray( this.elements ) : this;
		})
		.filter(function(){
			return this.name && !this.disabled &&
				( this.checked || rselectTextarea.test( this.nodeName ) ||
					rinput.test( this.type ) );
		})
		.map(function( i, elem ){
			var val = jQuery( this ).val();

			return val == null ?
				null :
				jQuery.isArray( val ) ?
					jQuery.map( val, function( val, i ){
						return { name: elem.name, value: val.replace( rCRLF, "\r\n" ) };
					}) :
					{ name: elem.name, value: val.replace( rCRLF, "\r\n" ) };
		}).get();
	}
});

//Serialize an array of form elements or a set of
//key/values into a query string
jQuery.param = function( a, traditional ) {
	var prefix,
		s = [],
		add = function( key, value ) {
			// If value is a function, invoke it and return its value
			value = jQuery.isFunction( value ) ? value() : ( value == null ? "" : value );
			s[ s.length ] = encodeURIComponent( key ) + "=" + encodeURIComponent( value );
		};

	// Set traditional to true for jQuery <= 1.3.2 behavior.
	if ( traditional === undefined ) {
		traditional = jQuery.ajaxSettings && jQuery.ajaxSettings.traditional;
	}

	// If an array was passed in, assume that it is an array of form elements.
	if ( jQuery.isArray( a ) || ( a.jquery && !jQuery.isPlainObject( a ) ) ) {
		// Serialize the form elements
		jQuery.each( a, function() {
			add( this.name, this.value );
		});

	} else {
		// If traditional, encode the "old" way (the way 1.3.2 or older
		// did it), otherwise encode params recursively.
		for ( prefix in a ) {
			buildParams( prefix, a[ prefix ], traditional, add );
		}
	}

	// Return the resulting serialization
	return s.join( "&" ).replace( r20, "+" );
};

function buildParams( prefix, obj, traditional, add ) {
	var name;

	if ( jQuery.isArray( obj ) ) {
		// Serialize array item.
		jQuery.each( obj, function( i, v ) {
			if ( traditional || rbracket.test( prefix ) ) {
				// Treat each array item as a scalar.
				add( prefix, v );

			} else {
				// If array item is non-scalar (array or object), encode its
				// numeric index to resolve deserialization ambiguity issues.
				// Note that rack (as of 1.0.0) can't currently deserialize
				// nested arrays properly, and attempting to do so may cause
				// a server error. Possible fixes are to modify rack's
				// deserialization algorithm or to provide an option or flag
				// to force array serialization to be shallow.
				buildParams( prefix + "[" + ( typeof v === "object" ? i : "" ) + "]", v, traditional, add );
			}
		});

	} else if ( !traditional && jQuery.type( obj ) === "object" ) {
		// Serialize object item.
		for ( name in obj ) {
			buildParams( prefix + "[" + name + "]", obj[ name ], traditional, add );
		}

	} else {
		// Serialize scalar item.
		add( prefix, obj );
	}
}
var
	// Document location
	ajaxLocParts,
	ajaxLocation,

	rhash = /#.*$/,
	rheaders = /^(.*?):[ \t]*([^\r\n]*)\r?$/mg, // IE leaves an \r character at EOL
	// #7653, #8125, #8152: local protocol detection
	rlocalProtocol = /^(?:about|app|app\-storage|.+\-extension|file|res|widget):$/,
	rnoContent = /^(?:GET|HEAD)$/,
	rprotocol = /^\/\//,
	rquery = /\?/,
	rscript = /<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi,
	rts = /([?&])_=[^&]*/,
	rurl = /^([\w\+\.\-]+:)(?:\/\/([^\/?#:]*)(?::(\d+)|)|)/,

	// Keep a copy of the old load method
	_load = jQuery.fn.load,

	/* Prefilters
	 * 1) They are useful to introduce custom dataTypes (see ajax/jsonp.js for an example)
	 * 2) These are called:
	 *    - BEFORE asking for a transport
	 *    - AFTER param serialization (s.data is a string if s.processData is true)
	 * 3) key is the dataType
	 * 4) the catchall symbol "*" can be used
	 * 5) execution will start with transport dataType and THEN continue down to "*" if needed
	 */
	prefilters = {},

	/* Transports bindings
	 * 1) key is the dataType
	 * 2) the catchall symbol "*" can be used
	 * 3) selection will start with transport dataType and THEN go to "*" if needed
	 */
	transports = {},

	// Avoid comment-prolog char sequence (#10098); must appease lint and evade compression
	allTypes = ["*/"] + ["*"];

// #8138, IE may throw an exception when accessing
// a field from window.location if document.domain has been set
try {
	ajaxLocation = location.href;
} catch( e ) {
	// Use the href attribute of an A element
	// since IE will modify it given document.location
	ajaxLocation = document.createElement( "a" );
	ajaxLocation.href = "";
	ajaxLocation = ajaxLocation.href;
}

// Segment location into parts
ajaxLocParts = rurl.exec( ajaxLocation.toLowerCase() ) || [];

// Base "constructor" for jQuery.ajaxPrefilter and jQuery.ajaxTransport
function addToPrefiltersOrTransports( structure ) {

	// dataTypeExpression is optional and defaults to "*"
	return function( dataTypeExpression, func ) {

		if ( typeof dataTypeExpression !== "string" ) {
			func = dataTypeExpression;
			dataTypeExpression = "*";
		}

		var dataType, list, placeBefore,
			dataTypes = dataTypeExpression.toLowerCase().split( core_rspace ),
			i = 0,
			length = dataTypes.length;

		if ( jQuery.isFunction( func ) ) {
			// For each dataType in the dataTypeExpression
			for ( ; i < length; i++ ) {
				dataType = dataTypes[ i ];
				// We control if we're asked to add before
				// any existing element
				placeBefore = /^\+/.test( dataType );
				if ( placeBefore ) {
					dataType = dataType.substr( 1 ) || "*";
				}
				list = structure[ dataType ] = structure[ dataType ] || [];
				// then we add to the structure accordingly
				list[ placeBefore ? "unshift" : "push" ]( func );
			}
		}
	};
}

// Base inspection function for prefilters and transports
function inspectPrefiltersOrTransports( structure, options, originalOptions, jqXHR,
		dataType /* internal */, inspected /* internal */ ) {

	dataType = dataType || options.dataTypes[ 0 ];
	inspected = inspected || {};

	inspected[ dataType ] = true;

	var selection,
		list = structure[ dataType ],
		i = 0,
		length = list ? list.length : 0,
		executeOnly = ( structure === prefilters );

	for ( ; i < length && ( executeOnly || !selection ); i++ ) {
		selection = list[ i ]( options, originalOptions, jqXHR );
		// If we got redirected to another dataType
		// we try there if executing only and not done already
		if ( typeof selection === "string" ) {
			if ( !executeOnly || inspected[ selection ] ) {
				selection = undefined;
			} else {
				options.dataTypes.unshift( selection );
				selection = inspectPrefiltersOrTransports(
						structure, options, originalOptions, jqXHR, selection, inspected );
			}
		}
	}
	// If we're only executing or nothing was selected
	// we try the catchall dataType if not done already
	if ( ( executeOnly || !selection ) && !inspected[ "*" ] ) {
		selection = inspectPrefiltersOrTransports(
				structure, options, originalOptions, jqXHR, "*", inspected );
	}
	// unnecessary when only executing (prefilters)
	// but it'll be ignored by the caller in that case
	return selection;
}

// A special extend for ajax options
// that takes "flat" options (not to be deep extended)
// Fixes #9887
function ajaxExtend( target, src ) {
	var key, deep,
		flatOptions = jQuery.ajaxSettings.flatOptions || {};
	for ( key in src ) {
		if ( src[ key ] !== undefined ) {
			( flatOptions[ key ] ? target : ( deep || ( deep = {} ) ) )[ key ] = src[ key ];
		}
	}
	if ( deep ) {
		jQuery.extend( true, target, deep );
	}
}

jQuery.fn.load = function( url, params, callback ) {
	if ( typeof url !== "string" && _load ) {
		return _load.apply( this, arguments );
	}

	// Don't do a request if no elements are being requested
	if ( !this.length ) {
		return this;
	}

	var selector, type, response,
		self = this,
		off = url.indexOf(" ");

	if ( off >= 0 ) {
		selector = url.slice( off, url.length );
		url = url.slice( 0, off );
	}

	// If it's a function
	if ( jQuery.isFunction( params ) ) {

		// We assume that it's the callback
		callback = params;
		params = undefined;

	// Otherwise, build a param string
	} else if ( params && typeof params === "object" ) {
		type = "POST";
	}

	// Request the remote document
	jQuery.ajax({
		url: url,

		// if "type" variable is undefined, then "GET" method will be used
		type: type,
		dataType: "html",
		data: params,
		complete: function( jqXHR, status ) {
			if ( callback ) {
				self.each( callback, response || [ jqXHR.responseText, status, jqXHR ] );
			}
		}
	}).done(function( responseText ) {

		// Save response for use in complete callback
		response = arguments;

		// See if a selector was specified
		self.html( selector ?

			// Create a dummy div to hold the results
			jQuery("<div>")

				// inject the contents of the document in, removing the scripts
				// to avoid any 'Permission Denied' errors in IE
				.append( responseText.replace( rscript, "" ) )

				// Locate the specified elements
				.find( selector ) :

			// If not, just inject the full result
			responseText );

	});

	return this;
};

// Attach a bunch of functions for handling common AJAX events
jQuery.each( "ajaxStart ajaxStop ajaxComplete ajaxError ajaxSuccess ajaxSend".split( " " ), function( i, o ){
	jQuery.fn[ o ] = function( f ){
		return this.on( o, f );
	};
});

jQuery.each( [ "get", "post" ], function( i, method ) {
	jQuery[ method ] = function( url, data, callback, type ) {
		// shift arguments if data argument was omitted
		if ( jQuery.isFunction( data ) ) {
			type = type || callback;
			callback = data;
			data = undefined;
		}

		return jQuery.ajax({
			type: method,
			url: url,
			data: data,
			success: callback,
			dataType: type
		});
	};
});

jQuery.extend({

	getScript: function( url, callback ) {
		return jQuery.get( url, undefined, callback, "script" );
	},

	getJSON: function( url, data, callback ) {
		return jQuery.get( url, data, callback, "json" );
	},

	// Creates a full fledged settings object into target
	// with both ajaxSettings and settings fields.
	// If target is omitted, writes into ajaxSettings.
	ajaxSetup: function( target, settings ) {
		if ( settings ) {
			// Building a settings object
			ajaxExtend( target, jQuery.ajaxSettings );
		} else {
			// Extending ajaxSettings
			settings = target;
			target = jQuery.ajaxSettings;
		}
		ajaxExtend( target, settings );
		return target;
	},

	ajaxSettings: {
		url: ajaxLocation,
		isLocal: rlocalProtocol.test( ajaxLocParts[ 1 ] ),
		global: true,
		type: "GET",
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		processData: true,
		async: true,
		/*
		timeout: 0,
		data: null,
		dataType: null,
		username: null,
		password: null,
		cache: null,
		throws: false,
		traditional: false,
		headers: {},
		*/

		accepts: {
			xml: "application/xml, text/xml",
			html: "text/html",
			text: "text/plain",
			json: "application/json, text/javascript",
			"*": allTypes
		},

		contents: {
			xml: /xml/,
			html: /html/,
			json: /json/
		},

		responseFields: {
			xml: "responseXML",
			text: "responseText"
		},

		// List of data converters
		// 1) key format is "source_type destination_type" (a single space in-between)
		// 2) the catchall symbol "*" can be used for source_type
		converters: {

			// Convert anything to text
			"* text": window.String,

			// Text to html (true = no transformation)
			"text html": true,

			// Evaluate text as a json expression
			"text json": jQuery.parseJSON,

			// Parse text as xml
			"text xml": jQuery.parseXML
		},

		// For options that shouldn't be deep extended:
		// you can add your own custom options here if
		// and when you create one that shouldn't be
		// deep extended (see ajaxExtend)
		flatOptions: {
			context: true,
			url: true
		}
	},

	ajaxPrefilter: addToPrefiltersOrTransports( prefilters ),
	ajaxTransport: addToPrefiltersOrTransports( transports ),

	// Main method
	ajax: function( url, options ) {

		// If url is an object, simulate pre-1.5 signature
		if ( typeof url === "object" ) {
			options = url;
			url = undefined;
		}

		// Force options to be an object
		options = options || {};

		var // ifModified key
			ifModifiedKey,
			// Response headers
			responseHeadersString,
			responseHeaders,
			// transport
			transport,
			// timeout handle
			timeoutTimer,
			// Cross-domain detection vars
			parts,
			// To know if global events are to be dispatched
			fireGlobals,
			// Loop variable
			i,
			// Create the final options object
			s = jQuery.ajaxSetup( {}, options ),
			// Callbacks context
			callbackContext = s.context || s,
			// Context for global events
			// It's the callbackContext if one was provided in the options
			// and if it's a DOM node or a jQuery collection
			globalEventContext = callbackContext !== s &&
				( callbackContext.nodeType || callbackContext instanceof jQuery ) ?
						jQuery( callbackContext ) : jQuery.event,
			// Deferreds
			deferred = jQuery.Deferred(),
			completeDeferred = jQuery.Callbacks( "once memory" ),
			// Status-dependent callbacks
			statusCode = s.statusCode || {},
			// Headers (they are sent all at once)
			requestHeaders = {},
			requestHeadersNames = {},
			// The jqXHR state
			state = 0,
			// Default abort message
			strAbort = "canceled",
			// Fake xhr
			jqXHR = {

				readyState: 0,

				// Caches the header
				setRequestHeader: function( name, value ) {
					if ( !state ) {
						var lname = name.toLowerCase();
						name = requestHeadersNames[ lname ] = requestHeadersNames[ lname ] || name;
						requestHeaders[ name ] = value;
					}
					return this;
				},

				// Raw string
				getAllResponseHeaders: function() {
					return state === 2 ? responseHeadersString : null;
				},

				// Builds headers hashtable if needed
				getResponseHeader: function( key ) {
					var match;
					if ( state === 2 ) {
						if ( !responseHeaders ) {
							responseHeaders = {};
							while( ( match = rheaders.exec( responseHeadersString ) ) ) {
								responseHeaders[ match[1].toLowerCase() ] = match[ 2 ];
							}
						}
						match = responseHeaders[ key.toLowerCase() ];
					}
					return match === undefined ? null : match;
				},

				// Overrides response content-type header
				overrideMimeType: function( type ) {
					if ( !state ) {
						s.mimeType = type;
					}
					return this;
				},

				// Cancel the request
				abort: function( statusText ) {
					statusText = statusText || strAbort;
					if ( transport ) {
						transport.abort( statusText );
					}
					done( 0, statusText );
					return this;
				}
			};

		// Callback for when everything is done
		// It is defined here because jslint complains if it is declared
		// at the end of the function (which would be more logical and readable)
		function done( status, nativeStatusText, responses, headers ) {
			var isSuccess, success, error, response, modified,
				statusText = nativeStatusText;

			// Called once
			if ( state === 2 ) {
				return;
			}

			// State is "done" now
			state = 2;

			// Clear timeout if it exists
			if ( timeoutTimer ) {
				clearTimeout( timeoutTimer );
			}

			// Dereference transport for early garbage collection
			// (no matter how long the jqXHR object will be used)
			transport = undefined;

			// Cache response headers
			responseHeadersString = headers || "";

			// Set readyState
			jqXHR.readyState = status > 0 ? 4 : 0;

			// Get response data
			if ( responses ) {
				response = ajaxHandleResponses( s, jqXHR, responses );
			}

			// If successful, handle type chaining
			if ( status >= 200 && status < 300 || status === 304 ) {

				// Set the If-Modified-Since and/or If-None-Match header, if in ifModified mode.
				if ( s.ifModified ) {

					modified = jqXHR.getResponseHeader("Last-Modified");
					if ( modified ) {
						jQuery.lastModified[ ifModifiedKey ] = modified;
					}
					modified = jqXHR.getResponseHeader("Etag");
					if ( modified ) {
						jQuery.etag[ ifModifiedKey ] = modified;
					}
				}

				// If not modified
				if ( status === 304 ) {

					statusText = "notmodified";
					isSuccess = true;

				// If we have data
				} else {

					isSuccess = ajaxConvert( s, response );
					statusText = isSuccess.state;
					success = isSuccess.data;
					error = isSuccess.error;
					isSuccess = !error;
				}
			} else {
				// We extract error from statusText
				// then normalize statusText and status for non-aborts
				error = statusText;
				if ( !statusText || status ) {
					statusText = "error";
					if ( status < 0 ) {
						status = 0;
					}
				}
			}

			// Set data for the fake xhr object
			jqXHR.status = status;
			jqXHR.statusText = ( nativeStatusText || statusText ) + "";

			// Success/Error
			if ( isSuccess ) {
				deferred.resolveWith( callbackContext, [ success, statusText, jqXHR ] );
			} else {
				deferred.rejectWith( callbackContext, [ jqXHR, statusText, error ] );
			}

			// Status-dependent callbacks
			jqXHR.statusCode( statusCode );
			statusCode = undefined;

			if ( fireGlobals ) {
				globalEventContext.trigger( "ajax" + ( isSuccess ? "Success" : "Error" ),
						[ jqXHR, s, isSuccess ? success : error ] );
			}

			// Complete
			completeDeferred.fireWith( callbackContext, [ jqXHR, statusText ] );

			if ( fireGlobals ) {
				globalEventContext.trigger( "ajaxComplete", [ jqXHR, s ] );
				// Handle the global AJAX counter
				if ( !( --jQuery.active ) ) {
					jQuery.event.trigger( "ajaxStop" );
				}
			}
		}

		// Attach deferreds
		deferred.promise( jqXHR );
		jqXHR.success = jqXHR.done;
		jqXHR.error = jqXHR.fail;
		jqXHR.complete = completeDeferred.add;

		// Status-dependent callbacks
		jqXHR.statusCode = function( map ) {
			if ( map ) {
				var tmp;
				if ( state < 2 ) {
					for ( tmp in map ) {
						statusCode[ tmp ] = [ statusCode[tmp], map[tmp] ];
					}
				} else {
					tmp = map[ jqXHR.status ];
					jqXHR.always( tmp );
				}
			}
			return this;
		};

		// Remove hash character (#7531: and string promotion)
		// Add protocol if not provided (#5866: IE7 issue with protocol-less urls)
		// We also use the url parameter if available
		s.url = ( ( url || s.url ) + "" ).replace( rhash, "" ).replace( rprotocol, ajaxLocParts[ 1 ] + "//" );

		// Extract dataTypes list
		s.dataTypes = jQuery.trim( s.dataType || "*" ).toLowerCase().split( core_rspace );

		// A cross-domain request is in order when we have a protocol:host:port mismatch
		if ( s.crossDomain == null ) {
			parts = rurl.exec( s.url.toLowerCase() );
			s.crossDomain = !!( parts &&
				( parts[ 1 ] !== ajaxLocParts[ 1 ] || parts[ 2 ] !== ajaxLocParts[ 2 ] ||
					( parts[ 3 ] || ( parts[ 1 ] === "http:" ? 80 : 443 ) ) !=
						( ajaxLocParts[ 3 ] || ( ajaxLocParts[ 1 ] === "http:" ? 80 : 443 ) ) )
			);
		}

		// Convert data if not already a string
		if ( s.data && s.processData && typeof s.data !== "string" ) {
			s.data = jQuery.param( s.data, s.traditional );
		}

		// Apply prefilters
		inspectPrefiltersOrTransports( prefilters, s, options, jqXHR );

		// If request was aborted inside a prefilter, stop there
		if ( state === 2 ) {
			return jqXHR;
		}

		// We can fire global events as of now if asked to
		fireGlobals = s.global;

		// Uppercase the type
		s.type = s.type.toUpperCase();

		// Determine if request has content
		s.hasContent = !rnoContent.test( s.type );

		// Watch for a new set of requests
		if ( fireGlobals && jQuery.active++ === 0 ) {
			jQuery.event.trigger( "ajaxStart" );
		}

		// More options handling for requests with no content
		if ( !s.hasContent ) {

			// If data is available, append data to url
			if ( s.data ) {
				s.url += ( rquery.test( s.url ) ? "&" : "?" ) + s.data;
				// #9682: remove data so that it's not used in an eventual retry
				delete s.data;
			}

			// Get ifModifiedKey before adding the anti-cache parameter
			ifModifiedKey = s.url;

			// Add anti-cache in url if needed
			if ( s.cache === false ) {

				var ts = jQuery.now(),
					// try replacing _= if it is there
					ret = s.url.replace( rts, "$1_=" + ts );

				// if nothing was replaced, add timestamp to the end
				s.url = ret + ( ( ret === s.url ) ? ( rquery.test( s.url ) ? "&" : "?" ) + "_=" + ts : "" );
			}
		}

		// Set the correct header, if data is being sent
		if ( s.data && s.hasContent && s.contentType !== false || options.contentType ) {
			jqXHR.setRequestHeader( "Content-Type", s.contentType );
		}

		// Set the If-Modified-Since and/or If-None-Match header, if in ifModified mode.
		if ( s.ifModified ) {
			ifModifiedKey = ifModifiedKey || s.url;
			if ( jQuery.lastModified[ ifModifiedKey ] ) {
				jqXHR.setRequestHeader( "If-Modified-Since", jQuery.lastModified[ ifModifiedKey ] );
			}
			if ( jQuery.etag[ ifModifiedKey ] ) {
				jqXHR.setRequestHeader( "If-None-Match", jQuery.etag[ ifModifiedKey ] );
			}
		}

		// Set the Accepts header for the server, depending on the dataType
		jqXHR.setRequestHeader(
			"Accept",
			s.dataTypes[ 0 ] && s.accepts[ s.dataTypes[0] ] ?
				s.accepts[ s.dataTypes[0] ] + ( s.dataTypes[ 0 ] !== "*" ? ", " + allTypes + "; q=0.01" : "" ) :
				s.accepts[ "*" ]
		);

		// Check for headers option
		for ( i in s.headers ) {
			jqXHR.setRequestHeader( i, s.headers[ i ] );
		}

		// Allow custom headers/mimetypes and early abort
		if ( s.beforeSend && ( s.beforeSend.call( callbackContext, jqXHR, s ) === false || state === 2 ) ) {
				// Abort if not done already and return
				return jqXHR.abort();

		}

		// aborting is no longer a cancellation
		strAbort = "abort";

		// Install callbacks on deferreds
		for ( i in { success: 1, error: 1, complete: 1 } ) {
			jqXHR[ i ]( s[ i ] );
		}

		// Get transport
		transport = inspectPrefiltersOrTransports( transports, s, options, jqXHR );

		// If no transport, we auto-abort
		if ( !transport ) {
			done( -1, "No Transport" );
		} else {
			jqXHR.readyState = 1;
			// Send global event
			if ( fireGlobals ) {
				globalEventContext.trigger( "ajaxSend", [ jqXHR, s ] );
			}
			// Timeout
			if ( s.async && s.timeout > 0 ) {
				timeoutTimer = setTimeout( function(){
					jqXHR.abort( "timeout" );
				}, s.timeout );
			}

			try {
				state = 1;
				transport.send( requestHeaders, done );
			} catch (e) {
				// Propagate exception as error if not done
				if ( state < 2 ) {
					done( -1, e );
				// Simply rethrow otherwise
				} else {
					throw e;
				}
			}
		}

		return jqXHR;
	},

	// Counter for holding the number of active queries
	active: 0,

	// Last-Modified header cache for next request
	lastModified: {},
	etag: {}

});

/* Handles responses to an ajax request:
 * - sets all responseXXX fields accordingly
 * - finds the right dataType (mediates between content-type and expected dataType)
 * - returns the corresponding response
 */
function ajaxHandleResponses( s, jqXHR, responses ) {

	var ct, type, finalDataType, firstDataType,
		contents = s.contents,
		dataTypes = s.dataTypes,
		responseFields = s.responseFields;

	// Fill responseXXX fields
	for ( type in responseFields ) {
		if ( type in responses ) {
			jqXHR[ responseFields[type] ] = responses[ type ];
		}
	}

	// Remove auto dataType and get content-type in the process
	while( dataTypes[ 0 ] === "*" ) {
		dataTypes.shift();
		if ( ct === undefined ) {
			ct = s.mimeType || jqXHR.getResponseHeader( "content-type" );
		}
	}

	// Check if we're dealing with a known content-type
	if ( ct ) {
		for ( type in contents ) {
			if ( contents[ type ] && contents[ type ].test( ct ) ) {
				dataTypes.unshift( type );
				break;
			}
		}
	}

	// Check to see if we have a response for the expected dataType
	if ( dataTypes[ 0 ] in responses ) {
		finalDataType = dataTypes[ 0 ];
	} else {
		// Try convertible dataTypes
		for ( type in responses ) {
			if ( !dataTypes[ 0 ] || s.converters[ type + " " + dataTypes[0] ] ) {
				finalDataType = type;
				break;
			}
			if ( !firstDataType ) {
				firstDataType = type;
			}
		}
		// Or just use first one
		finalDataType = finalDataType || firstDataType;
	}

	// If we found a dataType
	// We add the dataType to the list if needed
	// and return the corresponding response
	if ( finalDataType ) {
		if ( finalDataType !== dataTypes[ 0 ] ) {
			dataTypes.unshift( finalDataType );
		}
		return responses[ finalDataType ];
	}
}

// Chain conversions given the request and the original response
function ajaxConvert( s, response ) {

	var conv, conv2, current, tmp,
		// Work with a copy of dataTypes in case we need to modify it for conversion
		dataTypes = s.dataTypes.slice(),
		prev = dataTypes[ 0 ],
		converters = {},
		i = 0;

	// Apply the dataFilter if provided
	if ( s.dataFilter ) {
		response = s.dataFilter( response, s.dataType );
	}

	// Create converters map with lowercased keys
	if ( dataTypes[ 1 ] ) {
		for ( conv in s.converters ) {
			converters[ conv.toLowerCase() ] = s.converters[ conv ];
		}
	}

	// Convert to each sequential dataType, tolerating list modification
	for ( ; (current = dataTypes[++i]); ) {

		// There's only work to do if current dataType is non-auto
		if ( current !== "*" ) {

			// Convert response if prev dataType is non-auto and differs from current
			if ( prev !== "*" && prev !== current ) {

				// Seek a direct converter
				conv = converters[ prev + " " + current ] || converters[ "* " + current ];

				// If none found, seek a pair
				if ( !conv ) {
					for ( conv2 in converters ) {

						// If conv2 outputs current
						tmp = conv2.split(" ");
						if ( tmp[ 1 ] === current ) {

							// If prev can be converted to accepted input
							conv = converters[ prev + " " + tmp[ 0 ] ] ||
								converters[ "* " + tmp[ 0 ] ];
							if ( conv ) {
								// Condense equivalence converters
								if ( conv === true ) {
									conv = converters[ conv2 ];

								// Otherwise, insert the intermediate dataType
								} else if ( converters[ conv2 ] !== true ) {
									current = tmp[ 0 ];
									dataTypes.splice( i--, 0, current );
								}

								break;
							}
						}
					}
				}

				// Apply converter (if not an equivalence)
				if ( conv !== true ) {

					// Unless errors are allowed to bubble, catch and return them
					if ( conv && s["throws"] ) {
						response = conv( response );
					} else {
						try {
							response = conv( response );
						} catch ( e ) {
							return { state: "parsererror", error: conv ? e : "No conversion from " + prev + " to " + current };
						}
					}
				}
			}

			// Update prev for next iteration
			prev = current;
		}
	}

	return { state: "success", data: response };
}
var oldCallbacks = [],
	rquestion = /\?/,
	rjsonp = /(=)\?(?=&|$)|\?\?/,
	nonce = jQuery.now();

// Default jsonp settings
jQuery.ajaxSetup({
	jsonp: "callback",
	jsonpCallback: function() {
		var callback = oldCallbacks.pop() || ( jQuery.expando + "_" + ( nonce++ ) );
		this[ callback ] = true;
		return callback;
	}
});

// Detect, normalize options and install callbacks for jsonp requests
jQuery.ajaxPrefilter( "json jsonp", function( s, originalSettings, jqXHR ) {

	var callbackName, overwritten, responseContainer,
		data = s.data,
		url = s.url,
		hasCallback = s.jsonp !== false,
		replaceInUrl = hasCallback && rjsonp.test( url ),
		replaceInData = hasCallback && !replaceInUrl && typeof data === "string" &&
			!( s.contentType || "" ).indexOf("application/x-www-form-urlencoded") &&
			rjsonp.test( data );

	// Handle iff the expected data type is "jsonp" or we have a parameter to set
	if ( s.dataTypes[ 0 ] === "jsonp" || replaceInUrl || replaceInData ) {

		// Get callback name, remembering preexisting value associated with it
		callbackName = s.jsonpCallback = jQuery.isFunction( s.jsonpCallback ) ?
			s.jsonpCallback() :
			s.jsonpCallback;
		overwritten = window[ callbackName ];

		// Insert callback into url or form data
		if ( replaceInUrl ) {
			s.url = url.replace( rjsonp, "$1" + callbackName );
		} else if ( replaceInData ) {
			s.data = data.replace( rjsonp, "$1" + callbackName );
		} else if ( hasCallback ) {
			s.url += ( rquestion.test( url ) ? "&" : "?" ) + s.jsonp + "=" + callbackName;
		}

		// Use data converter to retrieve json after script execution
		s.converters["script json"] = function() {
			if ( !responseContainer ) {
				jQuery.error( callbackName + " was not called" );
			}
			return responseContainer[ 0 ];
		};

		// force json dataType
		s.dataTypes[ 0 ] = "json";

		// Install callback
		window[ callbackName ] = function() {
			responseContainer = arguments;
		};

		// Clean-up function (fires after converters)
		jqXHR.always(function() {
			// Restore preexisting value
			window[ callbackName ] = overwritten;

			// Save back as free
			if ( s[ callbackName ] ) {
				// make sure that re-using the options doesn't screw things around
				s.jsonpCallback = originalSettings.jsonpCallback;

				// save the callback name for future use
				oldCallbacks.push( callbackName );
			}

			// Call if it was a function and we have a response
			if ( responseContainer && jQuery.isFunction( overwritten ) ) {
				overwritten( responseContainer[ 0 ] );
			}

			responseContainer = overwritten = undefined;
		});

		// Delegate to script
		return "script";
	}
});
// Install script dataType
jQuery.ajaxSetup({
	accepts: {
		script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"
	},
	contents: {
		script: /javascript|ecmascript/
	},
	converters: {
		"text script": function( text ) {
			jQuery.globalEval( text );
			return text;
		}
	}
});

// Handle cache's special case and global
jQuery.ajaxPrefilter( "script", function( s ) {
	if ( s.cache === undefined ) {
		s.cache = false;
	}
	if ( s.crossDomain ) {
		s.type = "GET";
		s.global = false;
	}
});

// Bind script tag hack transport
jQuery.ajaxTransport( "script", function(s) {

	// This transport only deals with cross domain requests
	if ( s.crossDomain ) {

		var script,
			head = document.head || document.getElementsByTagName( "head" )[0] || document.documentElement;

		return {

			send: function( _, callback ) {

				script = document.createElement( "script" );

				script.async = "async";

				if ( s.scriptCharset ) {
					script.charset = s.scriptCharset;
				}

				script.src = s.url;

				// Attach handlers for all browsers
				script.onload = script.onreadystatechange = function( _, isAbort ) {

					if ( isAbort || !script.readyState || /loaded|complete/.test( script.readyState ) ) {

						// Handle memory leak in IE
						script.onload = script.onreadystatechange = null;

						// Remove the script
						if ( head && script.parentNode ) {
							head.removeChild( script );
						}

						// Dereference the script
						script = undefined;

						// Callback if not abort
						if ( !isAbort ) {
							callback( 200, "success" );
						}
					}
				};
				// Use insertBefore instead of appendChild  to circumvent an IE6 bug.
				// This arises when a base node is used (#2709 and #4378).
				head.insertBefore( script, head.firstChild );
			},

			abort: function() {
				if ( script ) {
					script.onload( 0, 1 );
				}
			}
		};
	}
});
var xhrCallbacks,
	// #5280: Internet Explorer will keep connections alive if we don't abort on unload
	xhrOnUnloadAbort = window.ActiveXObject ? function() {
		// Abort all pending requests
		for ( var key in xhrCallbacks ) {
			xhrCallbacks[ key ]( 0, 1 );
		}
	} : false,
	xhrId = 0;

// Functions to create xhrs
function createStandardXHR() {
	try {
		return new window.XMLHttpRequest();
	} catch( e ) {}
}

function createActiveXHR() {
	try {
		return new window.ActiveXObject( "Microsoft.XMLHTTP" );
	} catch( e ) {}
}

// Create the request object
// (This is still attached to ajaxSettings for backward compatibility)
jQuery.ajaxSettings.xhr = window.ActiveXObject ?
	/* Microsoft failed to properly
	 * implement the XMLHttpRequest in IE7 (can't request local files),
	 * so we use the ActiveXObject when it is available
	 * Additionally XMLHttpRequest can be disabled in IE7/IE8 so
	 * we need a fallback.
	 */
	function() {
		return !this.isLocal && createStandardXHR() || createActiveXHR();
	} :
	// For all other browsers, use the standard XMLHttpRequest object
	createStandardXHR;

// Determine support properties
(function( xhr ) {
	jQuery.extend( jQuery.support, {
		ajax: !!xhr,
		cors: !!xhr && ( "withCredentials" in xhr )
	});
})( jQuery.ajaxSettings.xhr() );

// Create transport if the browser can provide an xhr
if ( jQuery.support.ajax ) {

	jQuery.ajaxTransport(function( s ) {
		// Cross domain only allowed if supported through XMLHttpRequest
		if ( !s.crossDomain || jQuery.support.cors ) {

			var callback;

			return {
				send: function( headers, complete ) {

					// Get a new xhr
					var handle, i,
						xhr = s.xhr();

					// Open the socket
					// Passing null username, generates a login popup on Opera (#2865)
					if ( s.username ) {
						xhr.open( s.type, s.url, s.async, s.username, s.password );
					} else {
						xhr.open( s.type, s.url, s.async );
					}

					// Apply custom fields if provided
					if ( s.xhrFields ) {
						for ( i in s.xhrFields ) {
							xhr[ i ] = s.xhrFields[ i ];
						}
					}

					// Override mime type if needed
					if ( s.mimeType && xhr.overrideMimeType ) {
						xhr.overrideMimeType( s.mimeType );
					}

					// X-Requested-With header
					// For cross-domain requests, seeing as conditions for a preflight are
					// akin to a jigsaw puzzle, we simply never set it to be sure.
					// (it can always be set on a per-request basis or even using ajaxSetup)
					// For same-domain requests, won't change header if already provided.
					if ( !s.crossDomain && !headers["X-Requested-With"] ) {
						headers[ "X-Requested-With" ] = "XMLHttpRequest";
					}

					// Need an extra try/catch for cross domain requests in Firefox 3
					try {
						for ( i in headers ) {
							xhr.setRequestHeader( i, headers[ i ] );
						}
					} catch( _ ) {}

					// Do send the request
					// This may raise an exception which is actually
					// handled in jQuery.ajax (so no try/catch here)
					xhr.send( ( s.hasContent && s.data ) || null );

					// Listener
					callback = function( _, isAbort ) {

						var status,
							statusText,
							responseHeaders,
							responses,
							xml;

						// Firefox throws exceptions when accessing properties
						// of an xhr when a network error occurred
						// http://helpful.knobs-dials.com/index.php/Component_returned_failure_code:_0x80040111_(NS_ERROR_NOT_AVAILABLE)
						try {

							// Was never called and is aborted or complete
							if ( callback && ( isAbort || xhr.readyState === 4 ) ) {

								// Only called once
								callback = undefined;

								// Do not keep as active anymore
								if ( handle ) {
									xhr.onreadystatechange = jQuery.noop;
									if ( xhrOnUnloadAbort ) {
										delete xhrCallbacks[ handle ];
									}
								}

								// If it's an abort
								if ( isAbort ) {
									// Abort it manually if needed
									if ( xhr.readyState !== 4 ) {
										xhr.abort();
									}
								} else {
									status = xhr.status;
									responseHeaders = xhr.getAllResponseHeaders();
									responses = {};
									xml = xhr.responseXML;

									// Construct response list
									if ( xml && xml.documentElement /* #4958 */ ) {
										responses.xml = xml;
									}

									// When requesting binary data, IE6-9 will throw an exception
									// on any attempt to access responseText (#11426)
									try {
										responses.text = xhr.responseText;
									} catch( e ) {
									}

									// Firefox throws an exception when accessing
									// statusText for faulty cross-domain requests
									try {
										statusText = xhr.statusText;
									} catch( e ) {
										// We normalize with Webkit giving an empty statusText
										statusText = "";
									}

									// Filter status for non standard behaviors

									// If the request is local and we have data: assume a success
									// (success with no data won't get notified, that's the best we
									// can do given current implementations)
									if ( !status && s.isLocal && !s.crossDomain ) {
										status = responses.text ? 200 : 404;
									// IE - #1450: sometimes returns 1223 when it should be 204
									} else if ( status === 1223 ) {
										status = 204;
									}
								}
							}
						} catch( firefoxAccessException ) {
							if ( !isAbort ) {
								complete( -1, firefoxAccessException );
							}
						}

						// Call complete if needed
						if ( responses ) {
							complete( status, statusText, responses, responseHeaders );
						}
					};

					if ( !s.async ) {
						// if we're in sync mode we fire the callback
						callback();
					} else if ( xhr.readyState === 4 ) {
						// (IE6 & IE7) if it's in cache and has been
						// retrieved directly we need to fire the callback
						setTimeout( callback, 0 );
					} else {
						handle = ++xhrId;
						if ( xhrOnUnloadAbort ) {
							// Create the active xhrs callbacks list if needed
							// and attach the unload handler
							if ( !xhrCallbacks ) {
								xhrCallbacks = {};
								jQuery( window ).unload( xhrOnUnloadAbort );
							}
							// Add to list of active xhrs callbacks
							xhrCallbacks[ handle ] = callback;
						}
						xhr.onreadystatechange = callback;
					}
				},

				abort: function() {
					if ( callback ) {
						callback(0,1);
					}
				}
			};
		}
	});
}
var fxNow, timerId,
	rfxtypes = /^(?:toggle|show|hide)$/,
	rfxnum = new RegExp( "^(?:([-+])=|)(" + core_pnum + ")([a-z%]*)$", "i" ),
	rrun = /queueHooks$/,
	animationPrefilters = [ defaultPrefilter ],
	tweeners = {
		"*": [function( prop, value ) {
			var end, unit,
				tween = this.createTween( prop, value ),
				parts = rfxnum.exec( value ),
				target = tween.cur(),
				start = +target || 0,
				scale = 1,
				maxIterations = 20;

			if ( parts ) {
				end = +parts[2];
				unit = parts[3] || ( jQuery.cssNumber[ prop ] ? "" : "px" );

				// We need to compute starting value
				if ( unit !== "px" && start ) {
					// Iteratively approximate from a nonzero starting point
					// Prefer the current property, because this process will be trivial if it uses the same units
					// Fallback to end or a simple constant
					start = jQuery.css( tween.elem, prop, true ) || end || 1;

					do {
						// If previous iteration zeroed out, double until we get *something*
						// Use a string for doubling factor so we don't accidentally see scale as unchanged below
						scale = scale || ".5";

						// Adjust and apply
						start = start / scale;
						jQuery.style( tween.elem, prop, start + unit );

					// Update scale, tolerating zero or NaN from tween.cur()
					// And breaking the loop if scale is unchanged or perfect, or if we've just had enough
					} while ( scale !== (scale = tween.cur() / target) && scale !== 1 && --maxIterations );
				}

				tween.unit = unit;
				tween.start = start;
				// If a +=/-= token was provided, we're doing a relative animation
				tween.end = parts[1] ? start + ( parts[1] + 1 ) * end : end;
			}
			return tween;
		}]
	};

// Animations created synchronously will run synchronously
function createFxNow() {
	setTimeout(function() {
		fxNow = undefined;
	}, 0 );
	return ( fxNow = jQuery.now() );
}

function createTweens( animation, props ) {
	jQuery.each( props, function( prop, value ) {
		var collection = ( tweeners[ prop ] || [] ).concat( tweeners[ "*" ] ),
			index = 0,
			length = collection.length;
		for ( ; index < length; index++ ) {
			if ( collection[ index ].call( animation, prop, value ) ) {

				// we're done with this property
				return;
			}
		}
	});
}

function Animation( elem, properties, options ) {
	var result,
		index = 0,
		tweenerIndex = 0,
		length = animationPrefilters.length,
		deferred = jQuery.Deferred().always( function() {
			// don't match elem in the :animated selector
			delete tick.elem;
		}),
		tick = function() {
			var currentTime = fxNow || createFxNow(),
				remaining = Math.max( 0, animation.startTime + animation.duration - currentTime ),
				// archaic crash bug won't allow us to use 1 - ( 0.5 || 0 ) (#12497)
				temp = remaining / animation.duration || 0,
				percent = 1 - temp,
				index = 0,
				length = animation.tweens.length;

			for ( ; index < length ; index++ ) {
				animation.tweens[ index ].run( percent );
			}

			deferred.notifyWith( elem, [ animation, percent, remaining ]);

			if ( percent < 1 && length ) {
				return remaining;
			} else {
				deferred.resolveWith( elem, [ animation ] );
				return false;
			}
		},
		animation = deferred.promise({
			elem: elem,
			props: jQuery.extend( {}, properties ),
			opts: jQuery.extend( true, { specialEasing: {} }, options ),
			originalProperties: properties,
			originalOptions: options,
			startTime: fxNow || createFxNow(),
			duration: options.duration,
			tweens: [],
			createTween: function( prop, end, easing ) {
				var tween = jQuery.Tween( elem, animation.opts, prop, end,
						animation.opts.specialEasing[ prop ] || animation.opts.easing );
				animation.tweens.push( tween );
				return tween;
			},
			stop: function( gotoEnd ) {
				var index = 0,
					// if we are going to the end, we want to run all the tweens
					// otherwise we skip this part
					length = gotoEnd ? animation.tweens.length : 0;

				for ( ; index < length ; index++ ) {
					animation.tweens[ index ].run( 1 );
				}

				// resolve when we played the last frame
				// otherwise, reject
				if ( gotoEnd ) {
					deferred.resolveWith( elem, [ animation, gotoEnd ] );
				} else {
					deferred.rejectWith( elem, [ animation, gotoEnd ] );
				}
				return this;
			}
		}),
		props = animation.props;

	propFilter( props, animation.opts.specialEasing );

	for ( ; index < length ; index++ ) {
		result = animationPrefilters[ index ].call( animation, elem, props, animation.opts );
		if ( result ) {
			return result;
		}
	}

	createTweens( animation, props );

	if ( jQuery.isFunction( animation.opts.start ) ) {
		animation.opts.start.call( elem, animation );
	}

	jQuery.fx.timer(
		jQuery.extend( tick, {
			anim: animation,
			queue: animation.opts.queue,
			elem: elem
		})
	);

	// attach callbacks from options
	return animation.progress( animation.opts.progress )
		.done( animation.opts.done, animation.opts.complete )
		.fail( animation.opts.fail )
		.always( animation.opts.always );
}

function propFilter( props, specialEasing ) {
	var index, name, easing, value, hooks;

	// camelCase, specialEasing and expand cssHook pass
	for ( index in props ) {
		name = jQuery.camelCase( index );
		easing = specialEasing[ name ];
		value = props[ index ];
		if ( jQuery.isArray( value ) ) {
			easing = value[ 1 ];
			value = props[ index ] = value[ 0 ];
		}

		if ( index !== name ) {
			props[ name ] = value;
			delete props[ index ];
		}

		hooks = jQuery.cssHooks[ name ];
		if ( hooks && "expand" in hooks ) {
			value = hooks.expand( value );
			delete props[ name ];

			// not quite $.extend, this wont overwrite keys already present.
			// also - reusing 'index' from above because we have the correct "name"
			for ( index in value ) {
				if ( !( index in props ) ) {
					props[ index ] = value[ index ];
					specialEasing[ index ] = easing;
				}
			}
		} else {
			specialEasing[ name ] = easing;
		}
	}
}

jQuery.Animation = jQuery.extend( Animation, {

	tweener: function( props, callback ) {
		if ( jQuery.isFunction( props ) ) {
			callback = props;
			props = [ "*" ];
		} else {
			props = props.split(" ");
		}

		var prop,
			index = 0,
			length = props.length;

		for ( ; index < length ; index++ ) {
			prop = props[ index ];
			tweeners[ prop ] = tweeners[ prop ] || [];
			tweeners[ prop ].unshift( callback );
		}
	},

	prefilter: function( callback, prepend ) {
		if ( prepend ) {
			animationPrefilters.unshift( callback );
		} else {
			animationPrefilters.push( callback );
		}
	}
});

function defaultPrefilter( elem, props, opts ) {
	var index, prop, value, length, dataShow, toggle, tween, hooks, oldfire,
		anim = this,
		style = elem.style,
		orig = {},
		handled = [],
		hidden = elem.nodeType && isHidden( elem );

	// handle queue: false promises
	if ( !opts.queue ) {
		hooks = jQuery._queueHooks( elem, "fx" );
		if ( hooks.unqueued == null ) {
			hooks.unqueued = 0;
			oldfire = hooks.empty.fire;
			hooks.empty.fire = function() {
				if ( !hooks.unqueued ) {
					oldfire();
				}
			};
		}
		hooks.unqueued++;

		anim.always(function() {
			// doing this makes sure that the complete handler will be called
			// before this completes
			anim.always(function() {
				hooks.unqueued--;
				if ( !jQuery.queue( elem, "fx" ).length ) {
					hooks.empty.fire();
				}
			});
		});
	}

	// height/width overflow pass
	if ( elem.nodeType === 1 && ( "height" in props || "width" in props ) ) {
		// Make sure that nothing sneaks out
		// Record all 3 overflow attributes because IE does not
		// change the overflow attribute when overflowX and
		// overflowY are set to the same value
		opts.overflow = [ style.overflow, style.overflowX, style.overflowY ];

		// Set display property to inline-block for height/width
		// animations on inline elements that are having width/height animated
		if ( jQuery.css( elem, "display" ) === "inline" &&
				jQuery.css( elem, "float" ) === "none" ) {

			// inline-level elements accept inline-block;
			// block-level elements need to be inline with layout
			if ( !jQuery.support.inlineBlockNeedsLayout || css_defaultDisplay( elem.nodeName ) === "inline" ) {
				style.display = "inline-block";

			} else {
				style.zoom = 1;
			}
		}
	}

	if ( opts.overflow ) {
		style.overflow = "hidden";
		if ( !jQuery.support.shrinkWrapBlocks ) {
			anim.done(function() {
				style.overflow = opts.overflow[ 0 ];
				style.overflowX = opts.overflow[ 1 ];
				style.overflowY = opts.overflow[ 2 ];
			});
		}
	}


	// show/hide pass
	for ( index in props ) {
		value = props[ index ];
		if ( rfxtypes.exec( value ) ) {
			delete props[ index ];
			toggle = toggle || value === "toggle";
			if ( value === ( hidden ? "hide" : "show" ) ) {
				continue;
			}
			handled.push( index );
		}
	}

	length = handled.length;
	if ( length ) {
		dataShow = jQuery._data( elem, "fxshow" ) || jQuery._data( elem, "fxshow", {} );
		if ( "hidden" in dataShow ) {
			hidden = dataShow.hidden;
		}

		// store state if its toggle - enables .stop().toggle() to "reverse"
		if ( toggle ) {
			dataShow.hidden = !hidden;
		}
		if ( hidden ) {
			jQuery( elem ).show();
		} else {
			anim.done(function() {
				jQuery( elem ).hide();
			});
		}
		anim.done(function() {
			var prop;
			jQuery.removeData( elem, "fxshow", true );
			for ( prop in orig ) {
				jQuery.style( elem, prop, orig[ prop ] );
			}
		});
		for ( index = 0 ; index < length ; index++ ) {
			prop = handled[ index ];
			tween = anim.createTween( prop, hidden ? dataShow[ prop ] : 0 );
			orig[ prop ] = dataShow[ prop ] || jQuery.style( elem, prop );

			if ( !( prop in dataShow ) ) {
				dataShow[ prop ] = tween.start;
				if ( hidden ) {
					tween.end = tween.start;
					tween.start = prop === "width" || prop === "height" ? 1 : 0;
				}
			}
		}
	}
}

function Tween( elem, options, prop, end, easing ) {
	return new Tween.prototype.init( elem, options, prop, end, easing );
}
jQuery.Tween = Tween;

Tween.prototype = {
	constructor: Tween,
	init: function( elem, options, prop, end, easing, unit ) {
		this.elem = elem;
		this.prop = prop;
		this.easing = easing || "swing";
		this.options = options;
		this.start = this.now = this.cur();
		this.end = end;
		this.unit = unit || ( jQuery.cssNumber[ prop ] ? "" : "px" );
	},
	cur: function() {
		var hooks = Tween.propHooks[ this.prop ];

		return hooks && hooks.get ?
			hooks.get( this ) :
			Tween.propHooks._default.get( this );
	},
	run: function( percent ) {
		var eased,
			hooks = Tween.propHooks[ this.prop ];

		if ( this.options.duration ) {
			this.pos = eased = jQuery.easing[ this.easing ](
				percent, this.options.duration * percent, 0, 1, this.options.duration
			);
		} else {
			this.pos = eased = percent;
		}
		this.now = ( this.end - this.start ) * eased + this.start;

		if ( this.options.step ) {
			this.options.step.call( this.elem, this.now, this );
		}

		if ( hooks && hooks.set ) {
			hooks.set( this );
		} else {
			Tween.propHooks._default.set( this );
		}
		return this;
	}
};

Tween.prototype.init.prototype = Tween.prototype;

Tween.propHooks = {
	_default: {
		get: function( tween ) {
			var result;

			if ( tween.elem[ tween.prop ] != null &&
				(!tween.elem.style || tween.elem.style[ tween.prop ] == null) ) {
				return tween.elem[ tween.prop ];
			}

			// passing any value as a 4th parameter to .css will automatically
			// attempt a parseFloat and fallback to a string if the parse fails
			// so, simple values such as "10px" are parsed to Float.
			// complex values such as "rotate(1rad)" are returned as is.
			result = jQuery.css( tween.elem, tween.prop, false, "" );
			// Empty strings, null, undefined and "auto" are converted to 0.
			return !result || result === "auto" ? 0 : result;
		},
		set: function( tween ) {
			// use step hook for back compat - use cssHook if its there - use .style if its
			// available and use plain properties where available
			if ( jQuery.fx.step[ tween.prop ] ) {
				jQuery.fx.step[ tween.prop ]( tween );
			} else if ( tween.elem.style && ( tween.elem.style[ jQuery.cssProps[ tween.prop ] ] != null || jQuery.cssHooks[ tween.prop ] ) ) {
				jQuery.style( tween.elem, tween.prop, tween.now + tween.unit );
			} else {
				tween.elem[ tween.prop ] = tween.now;
			}
		}
	}
};

// Remove in 2.0 - this supports IE8's panic based approach
// to setting things on disconnected nodes

Tween.propHooks.scrollTop = Tween.propHooks.scrollLeft = {
	set: function( tween ) {
		if ( tween.elem.nodeType && tween.elem.parentNode ) {
			tween.elem[ tween.prop ] = tween.now;
		}
	}
};

jQuery.each([ "toggle", "show", "hide" ], function( i, name ) {
	var cssFn = jQuery.fn[ name ];
	jQuery.fn[ name ] = function( speed, easing, callback ) {
		return speed == null || typeof speed === "boolean" ||
			// special check for .toggle( handler, handler, ... )
			( !i && jQuery.isFunction( speed ) && jQuery.isFunction( easing ) ) ?
			cssFn.apply( this, arguments ) :
			this.animate( genFx( name, true ), speed, easing, callback );
	};
});

jQuery.fn.extend({
	fadeTo: function( speed, to, easing, callback ) {

		// show any hidden elements after setting opacity to 0
		return this.filter( isHidden ).css( "opacity", 0 ).show()

			// animate to the value specified
			.end().animate({ opacity: to }, speed, easing, callback );
	},
	animate: function( prop, speed, easing, callback ) {
		var empty = jQuery.isEmptyObject( prop ),
			optall = jQuery.speed( speed, easing, callback ),
			doAnimation = function() {
				// Operate on a copy of prop so per-property easing won't be lost
				var anim = Animation( this, jQuery.extend( {}, prop ), optall );

				// Empty animations resolve immediately
				if ( empty ) {
					anim.stop( true );
				}
			};

		return empty || optall.queue === false ?
			this.each( doAnimation ) :
			this.queue( optall.queue, doAnimation );
	},
	stop: function( type, clearQueue, gotoEnd ) {
		var stopQueue = function( hooks ) {
			var stop = hooks.stop;
			delete hooks.stop;
			stop( gotoEnd );
		};

		if ( typeof type !== "string" ) {
			gotoEnd = clearQueue;
			clearQueue = type;
			type = undefined;
		}
		if ( clearQueue && type !== false ) {
			this.queue( type || "fx", [] );
		}

		return this.each(function() {
			var dequeue = true,
				index = type != null && type + "queueHooks",
				timers = jQuery.timers,
				data = jQuery._data( this );

			if ( index ) {
				if ( data[ index ] && data[ index ].stop ) {
					stopQueue( data[ index ] );
				}
			} else {
				for ( index in data ) {
					if ( data[ index ] && data[ index ].stop && rrun.test( index ) ) {
						stopQueue( data[ index ] );
					}
				}
			}

			for ( index = timers.length; index--; ) {
				if ( timers[ index ].elem === this && (type == null || timers[ index ].queue === type) ) {
					timers[ index ].anim.stop( gotoEnd );
					dequeue = false;
					timers.splice( index, 1 );
				}
			}

			// start the next in the queue if the last step wasn't forced
			// timers currently will call their complete callbacks, which will dequeue
			// but only if they were gotoEnd
			if ( dequeue || !gotoEnd ) {
				jQuery.dequeue( this, type );
			}
		});
	}
});

// Generate parameters to create a standard animation
function genFx( type, includeWidth ) {
	var which,
		attrs = { height: type },
		i = 0;

	// if we include width, step value is 1 to do all cssExpand values,
	// if we don't include width, step value is 2 to skip over Left and Right
	includeWidth = includeWidth? 1 : 0;
	for( ; i < 4 ; i += 2 - includeWidth ) {
		which = cssExpand[ i ];
		attrs[ "margin" + which ] = attrs[ "padding" + which ] = type;
	}

	if ( includeWidth ) {
		attrs.opacity = attrs.width = type;
	}

	return attrs;
}

// Generate shortcuts for custom animations
jQuery.each({
	slideDown: genFx("show"),
	slideUp: genFx("hide"),
	slideToggle: genFx("toggle"),
	fadeIn: { opacity: "show" },
	fadeOut: { opacity: "hide" },
	fadeToggle: { opacity: "toggle" }
}, function( name, props ) {
	jQuery.fn[ name ] = function( speed, easing, callback ) {
		return this.animate( props, speed, easing, callback );
	};
});

jQuery.speed = function( speed, easing, fn ) {
	var opt = speed && typeof speed === "object" ? jQuery.extend( {}, speed ) : {
		complete: fn || !fn && easing ||
			jQuery.isFunction( speed ) && speed,
		duration: speed,
		easing: fn && easing || easing && !jQuery.isFunction( easing ) && easing
	};

	opt.duration = jQuery.fx.off ? 0 : typeof opt.duration === "number" ? opt.duration :
		opt.duration in jQuery.fx.speeds ? jQuery.fx.speeds[ opt.duration ] : jQuery.fx.speeds._default;

	// normalize opt.queue - true/undefined/null -> "fx"
	if ( opt.queue == null || opt.queue === true ) {
		opt.queue = "fx";
	}

	// Queueing
	opt.old = opt.complete;

	opt.complete = function() {
		if ( jQuery.isFunction( opt.old ) ) {
			opt.old.call( this );
		}

		if ( opt.queue ) {
			jQuery.dequeue( this, opt.queue );
		}
	};

	return opt;
};

jQuery.easing = {
	linear: function( p ) {
		return p;
	},
	swing: function( p ) {
		return 0.5 - Math.cos( p*Math.PI ) / 2;
	}
};

jQuery.timers = [];
jQuery.fx = Tween.prototype.init;
jQuery.fx.tick = function() {
	var timer,
		timers = jQuery.timers,
		i = 0;

	fxNow = jQuery.now();

	for ( ; i < timers.length; i++ ) {
		timer = timers[ i ];
		// Checks the timer has not already been removed
		if ( !timer() && timers[ i ] === timer ) {
			timers.splice( i--, 1 );
		}
	}

	if ( !timers.length ) {
		jQuery.fx.stop();
	}
	fxNow = undefined;
};

jQuery.fx.timer = function( timer ) {
	if ( timer() && jQuery.timers.push( timer ) && !timerId ) {
		timerId = setInterval( jQuery.fx.tick, jQuery.fx.interval );
	}
};

jQuery.fx.interval = 13;

jQuery.fx.stop = function() {
	clearInterval( timerId );
	timerId = null;
};

jQuery.fx.speeds = {
	slow: 600,
	fast: 200,
	// Default speed
	_default: 400
};

// Back Compat <1.8 extension point
jQuery.fx.step = {};

if ( jQuery.expr && jQuery.expr.filters ) {
	jQuery.expr.filters.animated = function( elem ) {
		return jQuery.grep(jQuery.timers, function( fn ) {
			return elem === fn.elem;
		}).length;
	};
}
var rroot = /^(?:body|html)$/i;

jQuery.fn.offset = function( options ) {
	if ( arguments.length ) {
		return options === undefined ?
			this :
			this.each(function( i ) {
				jQuery.offset.setOffset( this, options, i );
			});
	}

	var docElem, body, win, clientTop, clientLeft, scrollTop, scrollLeft,
		box = { top: 0, left: 0 },
		elem = this[ 0 ],
		doc = elem && elem.ownerDocument;

	if ( !doc ) {
		return;
	}

	if ( (body = doc.body) === elem ) {
		return jQuery.offset.bodyOffset( elem );
	}

	docElem = doc.documentElement;

	// Make sure it's not a disconnected DOM node
	if ( !jQuery.contains( docElem, elem ) ) {
		return box;
	}

	// If we don't have gBCR, just use 0,0 rather than error
	// BlackBerry 5, iOS 3 (original iPhone)
	if ( typeof elem.getBoundingClientRect !== "undefined" ) {
		box = elem.getBoundingClientRect();
	}
	win = getWindow( doc );
	clientTop  = docElem.clientTop  || body.clientTop  || 0;
	clientLeft = docElem.clientLeft || body.clientLeft || 0;
	scrollTop  = win.pageYOffset || docElem.scrollTop;
	scrollLeft = win.pageXOffset || docElem.scrollLeft;
	return {
		top: box.top  + scrollTop  - clientTop,
		left: box.left + scrollLeft - clientLeft
	};
};

jQuery.offset = {

	bodyOffset: function( body ) {
		var top = body.offsetTop,
			left = body.offsetLeft;

		if ( jQuery.support.doesNotIncludeMarginInBodyOffset ) {
			top  += parseFloat( jQuery.css(body, "marginTop") ) || 0;
			left += parseFloat( jQuery.css(body, "marginLeft") ) || 0;
		}

		return { top: top, left: left };
	},

	setOffset: function( elem, options, i ) {
		var position = jQuery.css( elem, "position" );

		// set position first, in-case top/left are set even on static elem
		if ( position === "static" ) {
			elem.style.position = "relative";
		}

		var curElem = jQuery( elem ),
			curOffset = curElem.offset(),
			curCSSTop = jQuery.css( elem, "top" ),
			curCSSLeft = jQuery.css( elem, "left" ),
			calculatePosition = ( position === "absolute" || position === "fixed" ) && jQuery.inArray("auto", [curCSSTop, curCSSLeft]) > -1,
			props = {}, curPosition = {}, curTop, curLeft;

		// need to be able to calculate position if either top or left is auto and position is either absolute or fixed
		if ( calculatePosition ) {
			curPosition = curElem.position();
			curTop = curPosition.top;
			curLeft = curPosition.left;
		} else {
			curTop = parseFloat( curCSSTop ) || 0;
			curLeft = parseFloat( curCSSLeft ) || 0;
		}

		if ( jQuery.isFunction( options ) ) {
			options = options.call( elem, i, curOffset );
		}

		if ( options.top != null ) {
			props.top = ( options.top - curOffset.top ) + curTop;
		}
		if ( options.left != null ) {
			props.left = ( options.left - curOffset.left ) + curLeft;
		}

		if ( "using" in options ) {
			options.using.call( elem, props );
		} else {
			curElem.css( props );
		}
	}
};


jQuery.fn.extend({

	position: function() {
		if ( !this[0] ) {
			return;
		}

		var elem = this[0],

		// Get *real* offsetParent
		offsetParent = this.offsetParent(),

		// Get correct offsets
		offset       = this.offset(),
		parentOffset = rroot.test(offsetParent[0].nodeName) ? { top: 0, left: 0 } : offsetParent.offset();

		// Subtract element margins
		// note: when an element has margin: auto the offsetLeft and marginLeft
		// are the same in Safari causing offset.left to incorrectly be 0
		offset.top  -= parseFloat( jQuery.css(elem, "marginTop") ) || 0;
		offset.left -= parseFloat( jQuery.css(elem, "marginLeft") ) || 0;

		// Add offsetParent borders
		parentOffset.top  += parseFloat( jQuery.css(offsetParent[0], "borderTopWidth") ) || 0;
		parentOffset.left += parseFloat( jQuery.css(offsetParent[0], "borderLeftWidth") ) || 0;

		// Subtract the two offsets
		return {
			top:  offset.top  - parentOffset.top,
			left: offset.left - parentOffset.left
		};
	},

	offsetParent: function() {
		return this.map(function() {
			var offsetParent = this.offsetParent || document.body;
			while ( offsetParent && (!rroot.test(offsetParent.nodeName) && jQuery.css(offsetParent, "position") === "static") ) {
				offsetParent = offsetParent.offsetParent;
			}
			return offsetParent || document.body;
		});
	}
});


// Create scrollLeft and scrollTop methods
jQuery.each( {scrollLeft: "pageXOffset", scrollTop: "pageYOffset"}, function( method, prop ) {
	var top = /Y/.test( prop );

	jQuery.fn[ method ] = function( val ) {
		return jQuery.access( this, function( elem, method, val ) {
			var win = getWindow( elem );

			if ( val === undefined ) {
				return win ? (prop in win) ? win[ prop ] :
					win.document.documentElement[ method ] :
					elem[ method ];
			}

			if ( win ) {
				win.scrollTo(
					!top ? val : jQuery( win ).scrollLeft(),
					 top ? val : jQuery( win ).scrollTop()
				);

			} else {
				elem[ method ] = val;
			}
		}, method, val, arguments.length, null );
	};
});

function getWindow( elem ) {
	return jQuery.isWindow( elem ) ?
		elem :
		elem.nodeType === 9 ?
			elem.defaultView || elem.parentWindow :
			false;
}
// Create innerHeight, innerWidth, height, width, outerHeight and outerWidth methods
jQuery.each( { Height: "height", Width: "width" }, function( name, type ) {
	jQuery.each( { padding: "inner" + name, content: type, "": "outer" + name }, function( defaultExtra, funcName ) {
		// margin is only for outerHeight, outerWidth
		jQuery.fn[ funcName ] = function( margin, value ) {
			var chainable = arguments.length && ( defaultExtra || typeof margin !== "boolean" ),
				extra = defaultExtra || ( margin === true || value === true ? "margin" : "border" );

			return jQuery.access( this, function( elem, type, value ) {
				var doc;

				if ( jQuery.isWindow( elem ) ) {
					// As of 5/8/2012 this will yield incorrect results for Mobile Safari, but there
					// isn't a whole lot we can do. See pull request at this URL for discussion:
					// https://github.com/jquery/jquery/pull/764
					return elem.document.documentElement[ "client" + name ];
				}

				// Get document width or height
				if ( elem.nodeType === 9 ) {
					doc = elem.documentElement;

					// Either scroll[Width/Height] or offset[Width/Height] or client[Width/Height], whichever is greatest
					// unfortunately, this causes bug #3838 in IE6/8 only, but there is currently no good, small way to fix it.
					return Math.max(
						elem.body[ "scroll" + name ], doc[ "scroll" + name ],
						elem.body[ "offset" + name ], doc[ "offset" + name ],
						doc[ "client" + name ]
					);
				}

				return value === undefined ?
					// Get width or height on the element, requesting but not forcing parseFloat
					jQuery.css( elem, type, value, extra ) :

					// Set width or height on the element
					jQuery.style( elem, type, value, extra );
			}, type, chainable ? margin : undefined, chainable, null );
		};
	});
});
// Expose jQuery to the global object
window.jQuery = window.$ = jQuery;

// Expose jQuery as an AMD module, but only for AMD loaders that
// understand the issues with loading multiple versions of jQuery
// in a page that all might call define(). The loader will indicate
// they have special allowances for multiple jQuery versions by
// specifying define.amd.jQuery = true. Register as a named module,
// since jQuery can be concatenated with other files that may use define,
// but not use a proper concatenation script that understands anonymous
// AMD modules. A named AMD is safest and most robust way to register.
// Lowercase jquery is used because AMD module names are derived from
// file names, and jQuery is normally delivered in a lowercase file name.
// Do this after creating the global so that if an AMD module wants to call
// noConflict to hide this version of jQuery, it will work.
if ( typeof define === "function" && define.amd && define.amd.jQuery ) {
	define( "jquery", [], function () { return jQuery; } );
}

})( window );
var HazmatBuilder = function(_,root) {
  // Actual Hazmat Code
  // top level module
  var Hazmat  = function(config) {
    this.config = config || {};
    if(!_.isObject(this.config)) {
      throw new Error('Hazmat is not initialized properly');
    }
    this.fail = _.isFunction(this.config.fail) ? this.config.fail : Hazmat.fail;
    this.warn = _.isFunction(this.config.warn) ? this.config.warn : Hazmat.warn;
    this.log = _.isFunction(this.config.log) ? this.config.log : Hazmat.log;
  };

  _.extend(Hazmat, {

    // constants
    ID_REGEX : /^[\_\-A-Za-z0-9]+$/,

    // factory
    create : function(config) {
      return new Hazmat(config);
    },

    // noConflict
    noConflict : function() {
      root.Hazmat = Hazmat.original;
      return Hazmat;
    },

    // default log function
    log : function() {
      if(window.console && _.isFunction(window.console.log)) {
        window.console.log.apply(window.console, arguments);
      }
    },

    // default fail function
    fail : function(_reason, _data) {
      var reason = _reason || "", data = _data || {};
      Hazmat.log('Hazmat Failure::', reason, data);
      throw new Error('Hazmat Failure '+reason.toString());
    },

    // default warn function
    warn : function(_reason, _data) {
      var reason = _reason || "", data = _data || {};
      Hazmat.log('Hazmat Warning::', reason, data);
    },

    // global fixers
    fixDomId : function(_value) {
      if(_.isString(_value) && _value.length > 0) {
        return _value.replace(/[^A-Za-z0-9\_]/g,'');
      } else {
        return null;
      }
    },

    // global testers
    isDomId : function(value) {
      return _.isString(value) && value.match(Hazmat.ID_REGEX);
    },


    __placeholder : true
  });

  _.extend(Hazmat.prototype, {
    _safeValue : function(name, value, fallback, type) {
      // make fallback safe and eat exceptions
      var _fallback = fallback;
      if(_.isFunction(fallback)) {
        fallback = _.once(function() {
          try {
            return _fallback.apply(this, arguments);
          } catch(e) {
          }
        });
      }

      if(type.checker(value)) {
        return value;
      } else if(type.evalFallback && _.isFunction(fallback) && type.checker(fallback(value))){
        this.warn('Expected valid '+type.name+' for '+name+' but was able to sanitize it:', [value, fallback(value)]);
        return fallback(value);
      } else if(type.checker(_fallback)){
        this.warn('Expected valid '+type.name+' for '+name+' but was able to fallback to default value:', [value, _fallback]);
        return _fallback;
      } else {
        this.fail('Expected valid '+type.name+' for '+name+' but received:', value);
      }
    },

    safeString : function(name, value, fallback) {
      return this._safeValue(name, value, fallback, {name: 'String', checker: _.isString, evalFallback:true});
    },

    safeStringOrNull : function(name, value, fallback) {
      if(value == null) {
        return value;
      } else {
        return this._safeValue(name, value, fallback, {name: 'String', checker: _.isString, evalFallback:true});
      }
    },

    safeDomId : function(name, value, fallback) {
      return this._safeValue(name, value, fallback, {name: 'DOM ID', checker: Hazmat.isDomId, evalFallback:true});
    },

    safeFunction : function(name, value, fallback) {
      return this._safeValue(name, value, fallback, {name: 'Function', checker: _.isFunction, evalFallback:false});
    },

    safeFunctionOrNull : function(name, value, fallback) {
      if(value == null) {
        return value;
      } else {
        return this._safeValue(name, value, fallback, {name: 'Function', checker: _.isFunction, evalFallback:false});
      }
    },

    safeObject : function(name, value, fallback) {
      return this._safeValue(name, value, fallback, {name: 'Object', checker: _.isObject, evalFallback:false});
    },

    safeObjectOrNull : function(name, value, fallback) {
      if(value == null) {
        return value;
      } else {
        return this._safeValue(name, value, fallback, {name: 'Object', checker: _.isObject, evalFallback:false});
      }
    },
    
    safeArray : function(name, value, fallback) {
      return this._safeValue(name, value, fallback, {name: 'Array', checker: _.isArray, evalFallback:false});
    },
    
    safeArrayOfElements : function(name, value, elementValidator, fallback) {
      var safeArray = this._safeValue(name, value, fallback, {name: 'Array', checker: _.isArray, evalFallback:false});
      return _.map(safeArray, elementValidator);
    },

    __placeholder:true
  });

  return Hazmat;
};

// Integration with Node.js/Browser
if(typeof window !== 'undefined' && typeof window._ !== 'undefined') {
  var hazmat = HazmatBuilder(window._, window);
  hazmat.original = window.Hazmat;
  window.Hazmat = hazmat;
} else {
  var _ = require('underscore');
  var hazmat = HazmatBuilder(_);
  _.extend(exports,hazmat);
}
/*!  SWFObject v2.2 <http://code.google.com/p/swfobject/>
  is released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
*/
var swfobject = function() {
  // NOTE[jigish]: this has been trimmed down significantly. The original version uses onDomLoad to embed an
  // object on the page and test the version that way. the "ua" function below is actually a fallback but it
  // seems to work just fine and is a *lot* smaller so we're using it instead.

  var UNDEF = "undefined",
    OBJECT = "object",
    SHOCKWAVE_FLASH = "Shockwave Flash",
    SHOCKWAVE_FLASH_AX = "ShockwaveFlash.ShockwaveFlash",
    FLASH_MIME_TYPE = "application/x-shockwave-flash",

    win = window,
    doc = document,
    nav = navigator,

  /* Centralized function for browser feature detection
    - User agent string detection is only used when no good alternative is possible
    - Is executed directly for optimal performance
  */
  ua = function() {
    var w3cdom = typeof doc.getElementById != UNDEF && typeof doc.getElementsByTagName != UNDEF &&
                 typeof doc.createElement != UNDEF,
      u = nav.userAgent.toLowerCase(),
      p = nav.platform.toLowerCase(),
      windows = p ? /win/.test(p) : /win/.test(u),
      mac = p ? /mac/.test(p) : /mac/.test(u),
      webkit = /webkit/.test(u) ? parseFloat(u.replace(/^.*webkit\/(\d+(\.\d+)?).*$/, "$1")) :
                                  false, // returns either the webkit version or false if not webkit
      ie = !+"\v1", // feature detection based on Andrea Giammarchi's solution:
                    // http://webreflection.blogspot.com/2009/01/32-bytes-to-know-if-your-browser-is-ie.html
      playerVersion = [0,0,0],
      d = null;
    if (typeof nav.plugins != UNDEF && typeof nav.plugins[SHOCKWAVE_FLASH] == OBJECT) {
      d = nav.plugins[SHOCKWAVE_FLASH].description;
      // navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin indicates whether plug-ins are
      // enabled or disabled in Safari 3+
      if (d && !(typeof nav.mimeTypes != UNDEF && nav.mimeTypes[FLASH_MIME_TYPE] &&
                 !nav.mimeTypes[FLASH_MIME_TYPE].enabledPlugin)) {
        ie = false; // cascaded feature detection for Internet Explorer
        d = d.replace(/^.*\s+(\S+\s+\S+$)/, "$1");
        playerVersion[0] = parseInt(d.replace(/^(.*)\..*$/, "$1"), 10);
        playerVersion[1] = parseInt(d.replace(/^.*\.(.*)\s.*$/, "$1"), 10);
        playerVersion[2] = /[a-zA-Z]/.test(d) ? parseInt(d.replace(/^.*[a-zA-Z]+(.*)$/, "$1"), 10) : 0;
      }
    }
    else if (typeof win.ActiveXObject != UNDEF) {
      try {
        var a = new ActiveXObject(SHOCKWAVE_FLASH_AX);
        if (a) { // a will return null when ActiveX is disabled
          d = a.GetVariable("$version");
          if (d) {
            ie = true; // cascaded feature detection for Internet Explorer
            d = d.split(" ")[1].split(",");
            playerVersion = [parseInt(d[0], 10), parseInt(d[1], 10), parseInt(d[2], 10)];
          }
        }
      }
      catch(e) {}
    }
    return { w3:w3cdom, pv:playerVersion, wk:webkit, ie:ie, win:windows, mac:mac };
  }();

  function hasPlayerVersion(rv) {
    var pv = ua.pv, v = rv.split(".");
    v[0] = parseInt(v[0], 10);
    v[1] = parseInt(v[1], 10) || 0; // supports short notation, e.g. "9" instead of "9.0.0"
    v[2] = parseInt(v[2], 10) || 0;
    return (pv[0] > v[0] || (pv[0] == v[0] && pv[1] > v[1]) ||
            (pv[0] == v[0] && pv[1] == v[1] && pv[2] >= v[2])) ? true : false;
  }

  return {
    ua: ua,

    getFlashPlayerVersion: function() {
      return { major:ua.pv[0], minor:ua.pv[1], release:ua.pv[2] };
    },

    hasFlashPlayerVersion: hasPlayerVersion
  };
}();
/* A JavaScript implementation of the SHA family of hashes, as defined in FIPS
 * PUB 180-2 as well as the corresponding HMAC implementation as defined in
 * FIPS PUB 198a
 *
 * Version 1.31 Copyright Brian Turek 2008-2012
 * Distributed under the BSD License
 * See http://caligatio.github.com/jsSHA/ for more information
 *
 * Several functions taken from Paul Johnson
 */
(function ()
{
	var charSize = 8,
	b64pad = "",
	hexCase = 0,

	str2binb = function (str)
	{
		var bin = [], mask = (1 << charSize) - 1,
			length = str.length * charSize, i;

		for (i = 0; i < length; i += charSize)
		{
			bin[i >> 5] |= (str.charCodeAt(i / charSize) & mask) <<
				(32 - charSize - (i % 32));
		}

		return bin;
	},

	hex2binb = function (str)
	{
		var bin = [], length = str.length, i, num;

		for (i = 0; i < length; i += 2)
		{
			num = parseInt(str.substr(i, 2), 16);
			if (!isNaN(num))
			{
				bin[i >> 3] |= num << (24 - (4 * (i % 8)));
			}
			else
			{
				return "INVALID HEX STRING";
			}
		}

		return bin;
	},

	binb2hex = function (binarray)
	{
		var hex_tab = (hexCase) ? "0123456789ABCDEF" : "0123456789abcdef",
			str = "", length = binarray.length * 4, i, srcByte;

		for (i = 0; i < length; i += 1)
		{
			srcByte = binarray[i >> 2] >> ((3 - (i % 4)) * 8);
			str += hex_tab.charAt((srcByte >> 4) & 0xF) +
				hex_tab.charAt(srcByte & 0xF);
		}

		return str;
	},

	binb2b64 = function (binarray)
	{
		var tab = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz" +
			"0123456789+/", str = "", length = binarray.length * 4, i, j,
			triplet;

		for (i = 0; i < length; i += 3)
		{
			triplet = (((binarray[i >> 2] >> 8 * (3 - i % 4)) & 0xFF) << 16) |
				(((binarray[i + 1 >> 2] >> 8 * (3 - (i + 1) % 4)) & 0xFF) << 8) |
				((binarray[i + 2 >> 2] >> 8 * (3 - (i + 2) % 4)) & 0xFF);
			for (j = 0; j < 4; j += 1)
			{
				if (i * 8 + j * 6 <= binarray.length * 32)
				{
					str += tab.charAt((triplet >> 6 * (3 - j)) & 0x3F);
				}
				else
				{
					str += b64pad;
				}
			}
		}
		return str;
	},

	rotr = function (x, n)
	{
		return (x >>> n) | (x << (32 - n));
	},

	shr = function (x, n)
	{
		return x >>> n;
	},

	ch = function (x, y, z)
	{
		return (x & y) ^ (~x & z);
	},

	maj = function (x, y, z)
	{
		return (x & y) ^ (x & z) ^ (y & z);
	},

	sigma0 = function (x)
	{
		return rotr(x, 2) ^ rotr(x, 13) ^ rotr(x, 22);
	},

	sigma1 = function (x)
	{
		return rotr(x, 6) ^ rotr(x, 11) ^ rotr(x, 25);
	},

	gamma0 = function (x)
	{
		return rotr(x, 7) ^ rotr(x, 18) ^ shr(x, 3);
	},

	gamma1 = function (x)
	{
		return rotr(x, 17) ^ rotr(x, 19) ^ shr(x, 10);
	},

	safeAdd_2 = function (x, y)
	{
		var lsw = (x & 0xFFFF) + (y & 0xFFFF),
			msw = (x >>> 16) + (y >>> 16) + (lsw >>> 16);

		return ((msw & 0xFFFF) << 16) | (lsw & 0xFFFF);
	},

	safeAdd_4 = function (a, b, c, d)
	{
		var lsw = (a & 0xFFFF) + (b & 0xFFFF) + (c & 0xFFFF) + (d & 0xFFFF),
			msw = (a >>> 16) + (b >>> 16) + (c >>> 16) + (d >>> 16) +
				(lsw >>> 16);

		return ((msw & 0xFFFF) << 16) | (lsw & 0xFFFF);
	},

	safeAdd_5 = function (a, b, c, d, e)
	{
		var lsw = (a & 0xFFFF) + (b & 0xFFFF) + (c & 0xFFFF) + (d & 0xFFFF) +
				(e & 0xFFFF),
			msw = (a >>> 16) + (b >>> 16) + (c >>> 16) + (d >>> 16) +
				(e >>> 16) + (lsw >>> 16);

		return ((msw & 0xFFFF) << 16) | (lsw & 0xFFFF);
	},

	coreSHA2 = function (message, messageLen, variant)
	{
		var a, b, c, d, e, f, g, h, T1, T2, H, lengthPosition, i, t, K, W = [],
			appendedMessageLength;

		if (variant === "SHA-224" || variant === "SHA-256")
		{
			lengthPosition = (((messageLen + 65) >> 9) << 4) + 15;
			K = [
					0x428A2F98, 0x71374491, 0xB5C0FBCF, 0xE9B5DBA5,
					0x3956C25B, 0x59F111F1, 0x923F82A4, 0xAB1C5ED5,
					0xD807AA98, 0x12835B01, 0x243185BE, 0x550C7DC3,
					0x72BE5D74, 0x80DEB1FE, 0x9BDC06A7, 0xC19BF174,
					0xE49B69C1, 0xEFBE4786, 0x0FC19DC6, 0x240CA1CC,
					0x2DE92C6F, 0x4A7484AA, 0x5CB0A9DC, 0x76F988DA,
					0x983E5152, 0xA831C66D, 0xB00327C8, 0xBF597FC7,
					0xC6E00BF3, 0xD5A79147, 0x06CA6351, 0x14292967,
					0x27B70A85, 0x2E1B2138, 0x4D2C6DFC, 0x53380D13,
					0x650A7354, 0x766A0ABB, 0x81C2C92E, 0x92722C85,
					0xA2BFE8A1, 0xA81A664B, 0xC24B8B70, 0xC76C51A3,
					0xD192E819, 0xD6990624, 0xF40E3585, 0x106AA070,
					0x19A4C116, 0x1E376C08, 0x2748774C, 0x34B0BCB5,
					0x391C0CB3, 0x4ED8AA4A, 0x5B9CCA4F, 0x682E6FF3,
					0x748F82EE, 0x78A5636F, 0x84C87814, 0x8CC70208,
					0x90BEFFFA, 0xA4506CEB, 0xBEF9A3F7, 0xC67178F2
				];

			if (variant === "SHA-224")
			{
				H = [
						0xc1059ed8, 0x367cd507, 0x3070dd17, 0xf70e5939,
						0xffc00b31, 0x68581511, 0x64f98fa7, 0xbefa4fa4
					];
			}
			else
			{
				H = [
						0x6A09E667, 0xBB67AE85, 0x3C6EF372, 0xA54FF53A,
						0x510E527F, 0x9B05688C, 0x1F83D9AB, 0x5BE0CD19
					];
			}
		}

		message[messageLen >> 5] |= 0x80 << (24 - messageLen % 32);
		message[lengthPosition] = messageLen;

		appendedMessageLength = message.length;

		for (i = 0; i < appendedMessageLength; i += 16)
		{
			a = H[0];
			b = H[1];
			c = H[2];
			d = H[3];
			e = H[4];
			f = H[5];
			g = H[6];
			h = H[7];

			for (t = 0; t < 64; t += 1)
			{
				if (t < 16)
				{
					W[t] = message[t + i];
				}
				else
				{
					W[t] = safeAdd_4(
							gamma1(W[t - 2]), W[t - 7],
							gamma0(W[t - 15]), W[t - 16]
						);
				}

				T1 = safeAdd_5(h, sigma1(e), ch(e, f, g), K[t], W[t]);
				T2 = safeAdd_2(sigma0(a), maj(a, b, c));
				h = g;
				g = f;
				f = e;
				e = safeAdd_2(d, T1);
				d = c;
				c = b;
				b = a;
				a = safeAdd_2(T1, T2);
			}

			H[0] = safeAdd_2(a, H[0]);
			H[1] = safeAdd_2(b, H[1]);
			H[2] = safeAdd_2(c, H[2]);
			H[3] = safeAdd_2(d, H[3]);
			H[4] = safeAdd_2(e, H[4]);
			H[5] = safeAdd_2(f, H[5]);
			H[6] = safeAdd_2(g, H[6]);
			H[7] = safeAdd_2(h, H[7]);
		}

		switch (variant)
		{
		case "SHA-224":
			return [
				H[0], H[1], H[2], H[3],
				H[4], H[5], H[6]
			];
		case "SHA-256":
			return H;
		default:
			return [];
		}
	},

	jsSHA = function (srcString, inputFormat)
	{

		this.sha224 = null;
		this.sha256 = null;

		this.strBinLen = null;
		this.strToHash = null;

		if ("HEX" === inputFormat)
		{
			if (0 !== (srcString.length % 2))
			{
				return "TEXT MUST BE IN BYTE INCREMENTS";
			}
			this.strBinLen = srcString.length * 4;
			this.strToHash = hex2binb(srcString);
		}
		else if (("ASCII" === inputFormat) ||
			 ('undefined' === typeof(inputFormat)))
		{
			this.strBinLen = srcString.length * charSize;
			this.strToHash = str2binb(srcString);
		}
		else
		{
			return "UNKNOWN TEXT INPUT TYPE";
		}
	};

	jsSHA.prototype = {
		getHash : function (variant, format)
		{
			var formatFunc = null, message = this.strToHash.slice();

			switch (format)
			{
			case "HEX":
				formatFunc = binb2hex;
				break;
			case "B64":
				formatFunc = binb2b64;
				break;
			default:
				return "FORMAT NOT RECOGNIZED";
			}

			switch (variant)
			{
			case "SHA-224":
				if (null === this.sha224)
				{
					this.sha224 = coreSHA2(message, this.strBinLen, variant);
				}
				return formatFunc(this.sha224);
			case "SHA-256":
				if (null === this.sha256)
				{
					this.sha256 = coreSHA2(message, this.strBinLen, variant);
				}
				return formatFunc(this.sha256);
			default:
				return "HASH NOT RECOGNIZED";
			}
		},

		getHMAC : function (key, inputFormat, variant, outputFormat)
		{
			var formatFunc, keyToUse, i, retVal, keyBinLen, hashBitSize,
				keyWithIPad = [], keyWithOPad = [];

			switch (outputFormat)
			{
			case "HEX":
				formatFunc = binb2hex;
				break;
			case "B64":
				formatFunc = binb2b64;
				break;
			default:
				return "FORMAT NOT RECOGNIZED";
			}

			switch (variant)
			{
			case "SHA-224":
				hashBitSize = 224;
				break;
			case "SHA-256":
				hashBitSize = 256;
				break;
			default:
				return "HASH NOT RECOGNIZED";
			}

			if ("HEX" === inputFormat)
			{
				if (0 !== (key.length % 2))
				{
					return "KEY MUST BE IN BYTE INCREMENTS";
				}
				keyToUse = hex2binb(key);
				keyBinLen = key.length * 4;
			}
			else if ("ASCII" === inputFormat)
			{
				keyToUse = str2binb(key);
				keyBinLen = key.length * charSize;
			}
			else
			{
				return "UNKNOWN KEY INPUT TYPE";
			}

			if (64 < (keyBinLen / 8))
			{
				keyToUse = coreSHA2(keyToUse, keyBinLen, variant);
				keyToUse[15] &= 0xFFFFFF00;
			}
			else if (64 > (keyBinLen / 8))
			{
				keyToUse[15] &= 0xFFFFFF00;
			}

			for (i = 0; i <= 15; i += 1)
			{
				keyWithIPad[i] = keyToUse[i] ^ 0x36363636;
				keyWithOPad[i] = keyToUse[i] ^ 0x5C5C5C5C;
			}

			retVal = coreSHA2(
						keyWithIPad.concat(this.strToHash),
						512 + this.strBinLen, variant);
			retVal = coreSHA2(
						keyWithOPad.concat(retVal),
						512 + hashBitSize, variant);

			return (formatFunc(retVal));
		}
	};

	window.jsSHA = jsSHA;
}());
window.LZW = {
  // LZW-compress a string
  encode: function (s) {
      var dict = {};
      var data = (s + "").split("");
      var out = [];
      var currChar;
      var phrase = data[0];
      var code = 256;
      for (var i=1; i<data.length; i++) {
          currChar=data[i];
          if (dict[phrase + currChar] != null) {
              phrase += currChar;
          }
          else {
              out.push(phrase.length > 1 ? dict[phrase] : phrase.charCodeAt(0));
              dict[phrase + currChar] = code;
              code++;
              phrase=currChar;
          }
      }
      out.push(phrase.length > 1 ? dict[phrase] : phrase.charCodeAt(0));
      for (var i=0; i<out.length; i++) {
          out[i] = String.fromCharCode(out[i]);
      }
      return out.join("");
  },

  // Decompress an LZW-encoded string
  decode: function (s) {
      var dict = {};
      var data = (s + "").split("");
      var currChar = data[0];
      var oldPhrase = currChar;
      var out = [currChar];
      var code = 256;
      var phrase;
      for (var i=1; i<data.length; i++) {
          var currCode = data[i].charCodeAt(0);
          if (currCode < 256) {
              phrase = data[i];
          }
          else {
             phrase = dict[currCode] ? dict[currCode] : (oldPhrase + currChar);
          }
          out.push(phrase);
          currChar = phrase.charAt(0);
          dict[code] = oldPhrase + currChar;
          code++;
          oldPhrase = phrase;
      }
      return out.join("");
  }

};/* base64 encode/decode compatible with window.btoa/atob
 *
 * window.atob/btoa is a Firefox extension to convert binary data (the "b")
 * to base64 (ascii, the "a").
 *
 * It is also found in Safari and Chrome.  It is not available in IE.
 *
 * if (!window.btoa) window.btoa = base64.encode
 * if (!window.atob) window.atob = base64.decode
 *
 * The original spec's for atob/btoa are a bit lacking
 * https://developer.mozilla.org/en/DOM/window.atob
 * https://developer.mozilla.org/en/DOM/window.btoa
 *
 * window.btoa and base64.encode takes a string where charCodeAt is [0,255]
 * If any character is not [0,255], then an DOMException(5) is thrown.
 *
 * window.atob and base64.decode take a base64-encoded string
 * If the input length is not a multiple of 4, or contains invalid characters
 *   then an DOMException(5) is thrown.
 */

(function () {
  var base64 = {};
  base64.PADCHAR = '=';
  base64.ALPHA = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';

  base64.makeDOMException = function() {
    // sadly in FF,Safari,Chrome you can't make a DOMException
    var e, tmp;

    try {
      return new DOMException(DOMException.INVALID_CHARACTER_ERR);
    } catch (tmp) {
      // not available, just passback a duck-typed equiv
      // https://developer.mozilla.org/en/Core_JavaScript_1.5_Reference/Global_Objects/Error
      // https://developer.mozilla.org/en/Core_JavaScript_1.5_Reference/Global_Objects/Error/prototype
      var ex = new Error("DOM Exception 5");

      // ex.number and ex.description is IE-specific.
      ex.code = ex.number = 5;
      ex.name = ex.description = "INVALID_CHARACTER_ERR";

      // Safari/Chrome output format
      ex.toString = function() { return 'Error: ' + ex.name + ': ' + ex.message; };
      return ex;
    }
  }

  base64.getbyte64 = function(s,i) {
    // This is oddly fast, except on Chrome/V8.
    //  Minimal or no improvement in performance by using a
    //   object with properties mapping chars to value (eg. 'A': 0)
    var idx = base64.ALPHA.indexOf(s.charAt(i));
    if (idx === -1) {
      throw base64.makeDOMException();
    }
    return idx;
  }

  base64.decode = function(s) {
    // convert to string
    s = '' + s;
    var getbyte64 = base64.getbyte64;
    var pads, i, b10;
    var imax = s.length
    if (imax === 0) {
      return s;
    }

    if (imax % 4 !== 0) {
      throw base64.makeDOMException();
    }

    pads = 0
    if (s.charAt(imax - 1) === base64.PADCHAR) {
      pads = 1;
      if (s.charAt(imax - 2) === base64.PADCHAR) {
        pads = 2;
      }
      // either way, we want to ignore this last block
      imax -= 4;
    }

    var x = [];
    for (i = 0; i < imax; i += 4) {
      b10 = (getbyte64(s,i) << 18) | (getbyte64(s,i+1) << 12) |
      (getbyte64(s,i+2) << 6) | getbyte64(s,i+3);
      x.push(String.fromCharCode(b10 >> 16, (b10 >> 8) & 0xff, b10 & 0xff));
    }

    switch (pads) {
      case 1:
        b10 = (getbyte64(s,i) << 18) | (getbyte64(s,i+1) << 12) | (getbyte64(s,i+2) << 6);
        x.push(String.fromCharCode(b10 >> 16, (b10 >> 8) & 0xff));
        break;
      case 2:
        b10 = (getbyte64(s,i) << 18) | (getbyte64(s,i+1) << 12);
        x.push(String.fromCharCode(b10 >> 16));
        break;
    }
    return x.join('');
  }

  base64.getbyte = function(s,i) {
    var x = s.charCodeAt(i);
    if (x > 255) {
      throw base64.makeDOMException();
    }
    return x;
  }

  base64.encode = function(s) {
    if (arguments.length !== 1) {
      throw new SyntaxError("Not enough arguments");
    }
    var padchar = base64.PADCHAR;
    var alpha   = base64.ALPHA;
    var getbyte = base64.getbyte;

    var i, b10;
    var x = [];

    // convert to string
    s = '' + s;

    var imax = s.length - s.length % 3;

    if (s.length === 0) {
      return s;
    }
    for (i = 0; i < imax; i += 3) {
      b10 = (getbyte(s,i) << 16) | (getbyte(s,i+1) << 8) | getbyte(s,i+2);
      x.push(alpha.charAt(b10 >> 18));
      x.push(alpha.charAt((b10 >> 12) & 0x3F));
      x.push(alpha.charAt((b10 >> 6) & 0x3f));
      x.push(alpha.charAt(b10 & 0x3f));
    }
    switch (s.length - imax) {
      case 1:
        b10 = getbyte(s,i) << 16;
        x.push(alpha.charAt(b10 >> 18) + alpha.charAt((b10 >> 12) & 0x3F) +
        padchar + padchar);
        break;
      case 2:
        b10 = (getbyte(s,i) << 16) | (getbyte(s,i+1) << 8);
        x.push(alpha.charAt(b10 >> 18) + alpha.charAt((b10 >> 12) & 0x3F) +
        alpha.charAt((b10 >> 6) & 0x3f) + padchar);
        break;
    }
    return x.join('');
  }

  window.base64 = base64;
}());
  (function(OO) {
    // Resolve all 3rd parties conflicts
    // Beyond this point we can use OO._ for underscore and OO.$ for zepto
    OO._ = window._.noConflict();
    OO.$ = window.$.noConflict(true);

    OO.HM = window.Hazmat.noConflict().create();

    OO.swfobject = swfobject;

    OO.jsSHA = window.jsSHA;

    OO.LZW = window.LZW;

    if(!window.console || !window.console.log) {
      window.console = window.console || {};
      window.console.log = function() {};
    }

  }(OO));
  (function(OO,_,HM) {
    // Ensure playerParams exists
    OO.playerParams = HM.safeObject('environment.playerParams', OO.playerParams,{});
    OO.playerParams.platform = HM.safeString('environment.playerParams.platform', OO.playerParams.platform,'flash');

    // process tweaks
    // tweaks is optional. Hazmat takes care of this but throws an undesirable warning.
    OO.playerParams.tweaks = OO.playerParams.tweaks || '';
    OO.playerParams.tweaks = HM.safeString('environment.playerParams.tweaks', OO.playerParams.tweaks,'');
    OO.playerParams.tweaks = OO.playerParams.tweaks.split(',');

    // explicit list of supported tweaks
    OO.tweaks = {};
    OO.tweaks["android-enable-hls"] = _.contains(OO.playerParams.tweaks, 'android-enable-hls');
    OO.tweaks["html5-force-mp4"] = _.contains(OO.playerParams.tweaks, 'html5-force-mp4');

    // Max timeout for fetching ads metadata, default to 3 seconds.
    OO.playerParams.maxAdsTimeout = OO.playerParams.maxAdsTimeout || 5;
    // max wrapper ads depth we look, we will only look up to 3 level until we get vast inline ads
    OO.playerParams.maxVastWrapperDepth = OO.playerParams.maxVastWrapperDepth || 3;
    OO.playerParams.minLiveSeekWindow = OO.playerParams.minLiveSeekWindow || 10;

    // Ripped from: http://stackoverflow.com/questions/105034/how-to-create-a-guid-uuid-in-javascript
    OO.guid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
      var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
      return v.toString(16);
    });
    OO.playerCount = 0;

    // Check environment to see if this is prod
    OO.isProd = OO.playerParams.environment &&
                OO.playerParams.environment.match(/^prod/i);

    // Environment invariant.
    OO.platform = window.navigator.platform;
    OO.os = window.navigator.appVersion;
    OO.supportsVideo = !!document.createElement('video').canPlayType;
    OO.supportsFlash = OO.swfobject && OO.swfobject.getFlashPlayerVersion && OO.swfobject.getFlashPlayerVersion().major >= 10 && !OO.os.match(/Android/);

    OO.browserSupportsCors = (function() {
      try {
        return _.has(new XMLHttpRequest(), "withCredentials") ||
          _.has(XMLHttpRequest.prototype, "withCredentials");
      } catch(e) {
        return false;
      }
    }());

    OO.isWindows = (function() {
      return OO.platform.match(/Win/);
    }());

    OO.isIos = (function() {
      return OO.platform.match(/iPhone/) || OO.platform.match(/iPad/) || OO.platform.match(/iPod/);
    }());

    OO.isIphone = (function() {
      return OO.platform.match(/iPhone/) || OO.platform.match(/iPod/);
    }());

    OO.isIpad = (function() {
      return OO.platform.match(/iPad/);
    }());

    OO.iosMajorVersion = (function() {
      try {
        if (window.navigator.userAgent.match(/(iPad|iPhone|iPod)/)) {
          return parseInt(window.navigator.userAgent.match(/OS (\d+)/)[1], 10);
        } 
      } catch(err) {
        return null;
      }
    }());

    OO.isAndroid = (function() {
      return OO.os.match(/Android/);
    }());

    OO.isAndroid4Plus = (function() {
      return OO.isAndroid && !OO.os.match(/Android [23]/);
    }());

    OO.isRimDevice = (function() {
      return OO.os.match(/BlackBerry/) ||  OO.os.match(/PlayBook/);
    }());

    OO.isFirefox = (function() {
      return !!window.navigator.userAgent.match(/Firefox/);
    }());

    OO.isChrome = (function () {
      return !!window.navigator.userAgent.match(/Chrome/);
    }());

    OO.isSafari = (function () {
      return !!window.navigator.userAgent.match(/AppleWebKit/);
    }());

    OO.chromeMajorVersion = (function () {
      try {
        return parseInt(window.navigator.userAgent.match(/Chrome.([0-9]*)/)[1], 10);
      } catch(err) {
        return null;
      }
    }());

    OO.isChromecast = (function() {
      return !!window.navigator.userAgent.match(/CrKey/);
    }());

    OO.isIE = (function(){
      return !!window.navigator.userAgent.match(/MSIE/) || !!window.navigator.userAgent.match(/Trident/);
    }());

    OO.isIE11Plus = (function(){
      // check if IE
      if (!window.navigator.userAgent.match(/Trident/)) {
        return false;
      }

      // extract version number
      var ieVersionMatch = window.navigator.userAgent.match(/rv:(\d*)/);
      var ieVersion = ieVersionMatch && ieVersionMatch[1];
      return ieVersion >= 11;
    }());

    OO.isWinPhone = (function(){
      return !!OO.os.match(/Windows Phone/) || !!OO.os.match(/ZuneWP/) || !!OO.os.match(/XBLWP/);
    }());

    OO.isSmartTV = (function(){
      return (!!window.navigator.userAgent.match(/SmartTV/) ||
             !!window.navigator.userAgent.match(/NetCast/));
    }());

    OO.isMacOs = (function() {
      return !OO.isIos && !!OO.os.match(/Mac/);
    }());

    OO.isMacOsLionOrLater = (function() {
      // TODO: revisit for Firefox when possible/necessary
      var macOs = OO.os.match(/Mac OS X ([0-9]+)_([0-9]+)/);
      if (macOs == null || macOs.length < 3) { return false; }
      return (parseInt(macOs[1],10) >= 10 && parseInt(macOs[2],10) >= 7);
    }());

    OO.isKindleHD = (function(){
      return !!OO.os.match(/Silk\/2/);
    }());

    OO.supportAds = (function() {
      // We are disabling ads for Android 2/3 device, the reason is that main video is not resuming after
      // ads finish. Util we can figure out a work around, we will keep ads disabled.
      return !OO.isWinPhone && !OO.os.match(/Android [23]/);
    }());

    OO.allowGesture = (function() {
      return OO.isIos;
    }());

    OO.allowAutoPlay = (function() {
      return !OO.isIos && !OO.isAndroid;
    }());

    OO.supportTouch = (function() {
      // IE8- doesn't support JS functions on DOM elements
      if (document.documentElement.hasOwnProperty && document.documentElement.hasOwnProperty("ontouchstart")) { return true; }
      return false;
    }());

    OO.docDomain = (function() {
      var domain = null;
      try {
        domain = document.domain;
      } catch(e) {}
      if (!OO._.isEmpty(domain)) { return domain; }
      if (OO.isSmartTV) { return 'SmartTV'; }
      return 'unknown';
    }());

    OO.uiParadigm = (function() {
      var paradigm = 'tablet';

      // The below code attempts to decide whether or not we are running in 'mobile' mode
      // Meaning that no controls are displayed, chrome is minimized and only fullscreen playback is allowed
      // Unfortunately there is no clean way to figure out whether the device is tablet or phone
      // or even to properly detect device screen size http://tripleodeon.com/2011/12/first-understand-your-screen/
      // So there is a bunch of heuristics for doing just that
      // Anything that is not explicitly detected as mobile defaults to desktop
      // so worst case they get ugly chrome instead of unworking player
      if (OO.playerParams.platform === 'html5-nativeui') {
        paradigm = 'mobile-native';
      } else if(OO.isAndroid4Plus && OO.tweaks["android-enable-hls"]) {
        // special case for Android 4+ running HLS
        paradigm = 'tablet';
      } else if(OO.isIphone) {
        paradigm = 'mobile-native';
      } else if(OO.os.match(/BlackBerry/)) {
        paradigm = 'mobile-native';
      } else if(OO.os.match(/iPad/)) {
        paradigm = 'tablet';
      } else if(OO.isKindleHD) {
        // Kindle Fire HD
        paradigm = 'mobile-native';
      } else if(OO.os.match(/Silk/)) {
        // Kindle Fire
        paradigm = 'mobile';
      } else if(OO.os.match(/Android 2/)) {
        // On Android 2+ only window.outerWidth is reliable, so we are using that and window.orientation
        if((window.orientation % 180) == 0 &&  (window.outerWidth / window.devicePixelRatio) <= 480 ) {
          // portrait mode
          paradigm = 'mobile';
        } else if((window.outerWidth / window.devicePixelRatio) <= 560 ) {
          // landscape mode
          paradigm = 'mobile';
        }
      } else if(OO.os.match(/Android/)) {
          paradigm = 'tablet';
      } else if (OO.isWinPhone) {
        // Windows Phone is mobile only for now, tablets not yet released
        paradigm = 'mobile';
      } else if(!!OO.platform.match(/Mac/)    // Macs
                || !!OO.platform.match(/Win/)  // Winboxes
                || !!OO.platform.match(/Linux/)) {    // Linux
        paradigm = 'desktop';
      }

      return paradigm;
    }());

    OO.supportMultiVideo = (function() {
      // short cut for Android non-chrome browser.
      if (OO.isAndroid && !OO.isChrome) { return false; }
      return !OO.isIos && !OO.os.match(/Android [23]/);
    }());

    OO.supportedVideoTypes = (function() {
      // tweak to force MP4 playback
      if (!!OO.tweaks["html5-force-mp4"]) {
        return { mp4:true };
      }

      // (PBW-1969) Special case since Windows user-agent includes 'like iPhone'
      if (!!OO.isWinPhone) {
        return { mp4:true };
      }

      // Sony OperaTV based supports HLS but doesn't properly report it so we are forcing it here
      if(window.navigator.userAgent.match(/SonyCEBrowser/)) {
        return { m3u8:true };
      }

      // The android is a special case because of it's crappy HLS support
      if(!!OO.isAndroid) {
        if (OO.tweaks["android-enable-hls"] && OO.isAndroid4Plus) {
          return { m3u8:true, mp4:true }; // Allow HLS despite our best intentions (PBK-125)
        }
        return { mp4:true };
      }

      // Smart TV hack, neither Samsung/LG plays hls correctly for their 2012 models.
      if (OO.isSmartTV) {
        return { mp4:true };
      }

      if (OO.isChromecast) {
        return { smooth:true, m3u8: true, mp4: true };
      }

      var video = document.createElement('video');
      if (typeof video.canPlayType !== "function") {
        return {};
      }
      return {
        m3u8: (!!video.canPlayType("application/vnd.apple.mpegurl") ||
               !!video.canPlayType("application/x-mpegURL")) &&
               !OO.isRimDevice && (!OO.isMacOs || OO.isMacOsLionOrLater),
        mp4: !!video.canPlayType("video/mp4"),
        webm: !!video.canPlayType("video/webm")
      };
    }());

    // TODO(jj): need to make this more comprehensive
    // Note(jj): only applies to mp4 videos for now
    OO.supportedVideoProfiles = (function() {
      // iOS only supports baseline profile
      if (OO.isIos || OO.isAndroid) {
        return "baseline";
      }
      return null;
    }());

    // TODO(bz): add flash for device when we decide to use stream data from sas
    // TODO(jj): add AppleTV and other devices as necessary
    OO.device = (function() {
        var device = 'html5';
        if (OO.isIphone) { device = 'iphone-html5'; }
        else if (OO.isIpad) { device = 'ipad-html5'; }
        else if (OO.isAndroid) { device = 'android-html5'; }
        else if (OO.isRimDevice) { device = 'rim-html5'; }
        else if (OO.isWinPhone) { device = 'winphone-html5'; }
        else if (OO.isSmartTV) { device = 'smarttv-html5'; }
        else if (OO.isChromecast) { device = 'chromecast-html5'; }
        return device;
    }());

    // list of environment-specific modules needed by the environment or empty to include all
    // Note: should never be empty because of flash/html5
    OO.environmentRequiredFeatures = (function(){
      var features = [];

      // initial chromecast check avoids complications with platform checks below since chromecast always uses cast-playback
      if (OO.isChromecast) {
        features.push('cast-playback');
        features.push('default-ui');
      } else if (!OO.supportsVideo) {
        features.push('flash-playback');
        features.push('flash-ui');
      // enable flash in 'flash-only' and in 'flash-adset'
      } else if (OO.playerParams.platform === 'flash-only' || OO.playerParams.platform === "flash-adset") {
        features.push('flash-playback');
        features.push('flash-ui');
      // either desktop mode detected or flash supported in 'flash' mode
      } else if ( (OO.supportsFlash || OO.uiParadigm == 'desktop') && OO.playerParams.platform === 'flash') {
        features.push('flash-playback');
        features.push('flash-ui');
      // if flash supported and in 'flash-priority' mode
      } else if ( OO.supportsFlash && _.indexOf(['flash-priority', 'html5-fallback'], OO.playerParams.platform) !== -1 ) {
        features.push('flash-playback');
        features.push('flash-ui');
      // if FF detected, and it doesn't support MP4 playback
      } else if ( OO.isFirefox && !OO.supportedVideoTypes.mp4) {
        features.push('flash-playback');
        features.push('flash-ui');
      } else if(OO.os.match(/Android 2/)) {  // safari android
        features.push('android-ui');
        features.push('html5-playback');
      } else { // normal html5
        features.push('html5-playback');
        features.push('default-ui');
        if (OO.supportAds) { features.push('ads'); }
      }

      return _.reduce(features, function(memo, feature) {return memo+feature+' ';}, '');
    }());

    OO.supportMidRollAds = (function() {
      return (OO.uiParadigm === "desktop" && !OO.isIos && !OO.isRimDevice);
    }());

    OO.supportCookies = (function() {
      document.cookie = "ooyala_cookie_test=true";
      var cookiesSupported = document.cookie.indexOf("ooyala_cookie_test=true") >= 0;
      document.cookie = "ooyala_cookie_test=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
      return cookiesSupported;
    }());

    OO.isSSL = document.location.protocol == "https:";

    OO.SERVER =
    {
      API: OO.isSSL ? OO.playerParams.api_ssl_server || "https://player-ssl.ooyala.com" :
                      OO.playerParams.api_server || "http://player.ooyala.com",
      AUTH: OO.isSSL ? OO.playerParams.auth_ssl_server || "https://player-ssl.ooyala.com/sas" :
                      OO.playerParams.auth_server || "http://player.ooyala.com/sas",
      ANALYTICS: OO.isSSL ? OO.playerParams.analytics_ssl_server || "https://player-ssl.ooyala.com" :
                            OO.playerParams.analytics_server || "http://player.ooyala.com",
      HASTUR: OO.isSSL ? OO.playerParams.hastur_ssl_server ||
                         (OO.isProd ? "https://l.ooyala.com/player_events" :
                                      "https://l-staging.ooyala.com/player_events") :
                         OO.playerParams.hastur_server ||
                         (OO.isProd ? "http://l.ooyala.com/player_events" :
                                      "http://l-staging.ooyala.com/player_events")
    };

    // returns true iff environment-specific feature is required to run in current environment
    OO.requiredInEnvironment = OO.featureEnabled = function(feature) {
      return !!OO.environmentRequiredFeatures.match(new RegExp(feature));
    };

    // Detect Chrome Extension. We will recieve an acknowledgement from the content script, which will prompt us to start sending logs
    OO.chromeExtensionEnabled = document.getElementById('ooyala-extension-installed') ? true : false;

    // Locale Getter and Setter
    OO.locale = "";
    OO.setLocale = function(locale) {
      OO.locale = locale.toUpperCase();
    };
    OO.getLocale = function() {
      return (OO.locale || document.documentElement.lang || navigator.language ||
              navigator.userLanguage || "en").substr(0,2).toUpperCase();
    };
  }(OO, OO._, OO.HM));
(function(OO, $, _){
  /*
   *  extend jquery lib
   */

  // add support for ie8/9 cross domain requests to jquery
  // see more here: http://bugs.jquery.com/ticket/8283
  // and here: https://github.com/jaubourg/ajaxHooks/blob/master/src/xdr.js
  if (window.XDomainRequest) {
    OO.$.ajaxTransport(function(s) {
      if (s.crossDomain && s.async) {
        if (s.timeout) {
          s.xdrTimeout = s.timeout;
          delete s.timeout;
        }
        var xdr;
        return {
          send: function(_, complete) {
            function callback(status, statusText, responses, responseHeaders) {
              xdr.onload = xdr.onerror = xdr.ontimeout = OO.$.noop;
              xdr = undefined;
              complete(status, statusText, responses, responseHeaders);
            }
            xdr = new XDomainRequest();
            xdr.open(s.type, s.url);
            xdr.onload = function() {
              callback(200, "OK", {
                text: xdr.responseText
              }, "Content-Type: " + xdr.contentType);
            };
            xdr.onerror = function() {
              callback(404, "Not Found");
            };
            xdr.onprogress = function() {};
            if (s.xdrTimeout) {
              xdr.ontimeout = function() {
                callback(0, "timeout");
              };
              xdr.timeout = s.xdrTimeout;
            }
            xdr.send((s.hasContent && s.data) || null);
          },
          abort: function() {
            if (xdr) {
              xdr.onerror = OO.$.noop();
              xdr.abort();
            }
          }
        };
      }
    });
  }


  $.getScriptRetry = function (url, callback, options) {
    options = options || {};
    var errorCallBack = options.error;
    var removeOptions = ['error', 'dataType', 'success'];
    _.each(removeOptions, function(k) { delete(options[k]); });

    // default settings; may be overridden by passing options
    var settings = {
      'url': url,
      'type': 'get',
      'dataType': 'script',
      'success': callback,
      'cache': true,
      'timeout': 5000,
      'tryCount': 0,
      'retryLimit': 1,
      'warning': false,
      'warningMessage': 'Can not load URL',
      'error': function () {
        if (this.tryCount < this.retryLimit) {
          this.tryCount++;
          $.ajax(this);
        } else {
          if (this.warning) {
            alert(this.warningMessage);
          }
          if (errorCallBack) { errorCallBack.apply(null, arguments); }
        }
      }
    }

    _.extend(settings, options);

    $.ajax(settings);
  };


}(OO, OO.$, OO._));
  /**
   * @namespace OO
   */
  (function(OO,_){

    // External States
	/**
	 * @description The Ooyala Player run-time states apply to an Ooyala player while it is running. These states apply equally to both HTML5 and Flash players. 
	 * State changes occur either through user interaction (for example, the user clickes the PLAY button), or programmatically via API calls. For more information, 
	 * see <a href="http://support.ooyala.com/developers/documentation/api/player_v3_api_events.html" target="target">Player Message Bus Events</a>.
	 * @summary Represents the Ooyala Player run-time states.
	 * @namespace OO.STATE
	 */	  
    OO.STATE = {
      /** The embed code has been set. The movie and its metadata is currently being loaded into the player. */    		
      LOADING : 'loading',
      /**
       * One of the following applies:
       * <ul>
       *   <li>All of the necessary data is loaded in the player. Playback of the movie can begin.</li>
       *   <li>Playback of the asset has finished and is ready to restart from the beginning.</li>
       * </ul>
       */
      READY : 'ready',
      /** The player is currently playing video content. */
      PLAYING : 'playing',
      /** The player has currently paused after playback had begun. */
      PAUSED : 'paused',
      /** Playback has currently stopped because it doesn't have enough movie data to continue and is downloading more. */
      BUFFERING : 'buffering',
      /** The player has encountered an error that prevents playback of the asset. The error could be due to many reasons, 
       * such as video format, syndication rules, or the asset being disabled. Refer to the list of errors for details. 
       * The error code for the root cause of the error is available from the [OO.Player.getErrorCode()]{@link OO.Player#getErrorCode} method. 
       */
      ERROR : 'error',
      /** The player has been destroyed via its [OO.Player.destroy(<i>callback</i>)]{@link OO.Player#destroy} method. */
      DESTROYED : 'destroyed',

      __end_marker : true
    };

    // All Events Constants
    /**
     * @description The Ooyala Player events are default events that are published by the event bus.Your modules can subscribe to any and all of these events. 
     * Use message bus events to subscribe to or publish player events from video to ad playback. For more information, 
     * see <a href="http://support.ooyala.com/developers/documentation/api/player_v3_api_events.html" target="target">Player Message Bus Events</a>.
     * @summary Represents the Ooyala Player events.
     * @namespace OO.EVENTS
     */
    OO.EVENTS = {
    
     /**
      * A player was created. This is the first event that is sent after player creation. 
      * This event provides the opportunity for any other modules to perform their own initialization. 
      * The handler is called with the query string parameters.  
      * The DOM has been created at this point, and plugins may make changes or additions to the DOM.<br/><br/>
      * 
      * <h5>Compatibility: </h5>
      * <p style="text-indent: 1em;">HTML5, Flash</p>
      * 
      * @event OO.EVENTS#PLAYER_CREATED
      */
      PLAYER_CREATED : 'playerCreated',

      PLAYER_EMBEDDED: 'playerEmbedded',

      /**
       * An attempt has been made to set the embed code.  
       * If you are developing a plugin, reset the internal state since the player is switching to a new asset.
       * Depending on the context, the handler is called with: 
       *   <ul>
       *     <li>The ID (embed code) of the asset.</li>
       *     <li>The ID (embed code) of the asset, with options.</li>
       *   </ul>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5, Flash</p>
       * 
       * @event OO.EVENTS#SET_EMBED_CODE
       */
      SET_EMBED_CODE : 'setEmbedCode',

      /**
       * The player's embed code has changed. The handler is called with two parameters:
       * <ul> 
       *    <li>The ID (embed code) of the asset.</li>
       *    <li>The options JSON object.</li>
       * </ul>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5, Flash</p>
       * 
       * @event OO.EVENTS#EMBED_CODE_CHANGED
       */
      EMBED_CODE_CHANGED : 'embedCodeChanged',

      /**
       * An <code>AUTH_TOKEN_CHANGED</code> event is triggered when an authorization token is issued by the 
       * <a href="http://support.ooyala.com/developers/documentation/concepts/player_v3_authorization_api.html" target="target">Player Authorization API</a>.<br/>
       * For example, in device registration, an authorization token is issued, as described in 
       * <a href="http://support.ooyala.com/developers/documentation/concepts/device_registration.html" target="target">Device Registration</a>.
       * The handler is called with a new value for the authorization token.<br/><br/>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">Flash</p>
       * 
       * @event OO.EVENTS#AUTH_TOKEN_CHANGED
       */
      AUTH_TOKEN_CHANGED: "authTokenChanged",

      /**
       * The GUID has been set. The handler is called with the GUID.
       * <p>This event notifies plugin or page developers that a unique ID has been either generated or loaded for the current user's browser. 
       * This is useful for analytics.</p> 
       * <p>In HTML5, Flash, and Chromecast environments, a unique user is identified by local storage or a cookie. </p>
       * <p>To generate the GUID, Flash players use the timestamp indicating when the GUID is generated, and append random data to it. 
       * The string is then converted to base64.</p> 
       * <p>To generate the GUID, HTML5 players use the current time, browser
       * information, and random data and hash it and convert it to base64.</p> 
       * <p>Within the same browser on the desktop, once a GUID is set by one platform
       * it is used for both platforms for the user. If a user clears their browser cache, that user's (device's) ID will be regenerated the next time 
       * they watch video. Incognito modes will track a user for a single session, but once the browser is closed the GUID is erased.</p>
       * <p>For more information, see <b>unique user</b> <a href="http://support.ooyala.com/users/users/documentation/reference/glossary.html" target="target">Glossary</a>.</p>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5</p>
       * 
       * @event OO.EVENTS#GUID_SET
       */
      GUID_SET : 'guidSet',

      WILL_FETCH_PLAYER_XML: 'willFetchPlayerXml',
      PLAYER_XML_FETCHED: 'playerXmlFetched',
      WILL_FETCH_CONTENT_TREE: 'willFetchContentTree',

      /**
       * A content tree was fetched. The handler is called with a JSON object that represents the content data for the current asset.<br/><br/>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5, Flash</p>
       * 
       * <h5>Analytics:</h5>
       * <p style="text-indent: 1em;">Records a <code>display</code> event. For more information see
       * <a href="http://support.ooyala.com/developers/documentation/concepts/analytics_plays-and-displays.html" target="target">Displays, Plays, and Play Starts</a>.</p>
       * 
       * @event OO.EVENTS#CONTENT_TREE_FETCHED
       */
      CONTENT_TREE_FETCHED: 'contentTreeFetched',

      WILL_FETCH_METADATA: 'willFetchMetadata',

      /**
       * The metadata, which is typically set in Backlot, has been retrieved. 
       * The handler is called with the JSON object containing all metadata associated with the current asset.
       * The metadata includes page-level, asset-level, player-level, and account-level metadata, in addition to 
       * metadata specific to 3rd party plugins. This is typically used for ad and anlytics plugins, but can be used
       * wherever you need specific logic based on the asset type.<br/><br/>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5, Flash</p>
       * 
       * @event OO.EVENTS#METADATA_FETCHED
       */
      METADATA_FETCHED: 'metadataFetched',

      WILL_FETCH_AUTHORIZATION: 'willFetchAuthorization',

      /**
       * Playback was authorized. The handler is called with an object containing the entire SAS response, and includes the value of <code>video_bitrate</code>.
       * <p>For more information see 
       * <a href="http://support.ooyala.com/developers/documentation/concepts/encodingsettings_videobitrate.html" target="target">Video Bit Rate</a>.</p>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5</p>
       * 
       * @event OO.EVENTS#AUTHORIZATION_FETCHED
       */
      AUTHORIZATION_FETCHED: 'authorizationFetched',

      WILL_FETCH_AD_AUTHORIZATION: 'willFetchAdAuthorization',
      AD_AUTHORIZATION_FETCHED: 'adAuthorizationFetched',

      PRELOAD_STREAM: 'preloadStream',
      RELOAD_STREAM: 'reloadStream',
      WILL_PLAY_STREAM: 'willPlayStream',
      PLAY_STREAM: 'playStream',
      PAUSE_STREAM: 'pauseStream',
      STREAM_PLAYING: 'streamPlaying',
      STREAM_PLAY_FAILED: 'streamPlayFailed',
      STREAM_PAUSED: 'streamPaused',
      STREAM_PLAYED: 'streamPlayed',
      SEEK_STREAM: 'seekStream',
      CAN_SEEK: 'canSeek',
      PLAY_MIDROLL_STREAM: 'playMidrollStream',
      MIDROLL_STREAM_PLAYED: 'midrollStreamPlayed',
      WILL_RESUME_MAIN_VIDEO: 'willResumeMainVideo',

      /**
       * The player has indicated that it is in a playback-ready state. 
       * All preparations are complete, and the player is ready to receive playback commands 
       * such as play, seek, and so on. The default UI shows the <b>Play</b> button, 
       * displaying the non-clickable spinner before this point. <br/><br/>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5, Flash</p>
       * 
       * @event OO.EVENTS#PLAYBACK_READY
       */
      PLAYBACK_READY: 'playbackReady',

      /**
       * Play has been called for the first time. <br/><br/>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5</p>
       * 
       * @event OO.EVENTS#INITIAL_PLAY
       */
      INITIAL_PLAY: "initialPlay", // when play is called for the very first time ( in start screen )

      /**
       * Special event for Chromecast player initializaiton by default receiver. <br/><br/>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5</p>
       * 
       * @event OO.EVENTS#CHROMECAST_INIT
       */
      CHROMECAST_INIT: "chromecastInit",

      WILL_PLAY : 'willPlay',

      /**
       * The playhead time changed. The handler is called with the following arguments:
       * <ul>
       *   <li>The current time.</li>
       *   <li>The duration.</li>
       *   <li>The name of the buffer.</li>
       *   <li>The seek range.</li>
       * </ul>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5, Flash</p>
       * 
       * <h5>Analytics:</h5>
       * <p style="text-indent: 1em;">The first event is <code>video start</code>. Other instances of the event feed the <code>% completed data points</code>.</p>
       * <p style="text-indent: 1em;">For more information, see <a href="http://support.ooyala.com/developers/documentation/concepts/analytics_plays-and-displays.html">Displays, Plays, and Play Starts</a>.</p>
       * 
       * @event OO.EVENTS#PLAYHEAD_TIME_CHANGED
       */
      PLAYHEAD_TIME_CHANGED: 'playheadTimeChanged',

      /**
       * The player is buffering the data stream.<br/><br/>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5, Flash</p>
       * 
       * @event OO.EVENTS#BUFFERING
       */
      BUFFERING: 'buffering', // playing stops because player is buffering

      /**
       * Play resumes because the player has completed buffering. The handler is called with the URL of the stream.<br/><br/>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5</p>
       * 
       * @event OO.EVENTS#BUFFERED
       */
      BUFFERED: 'buffered',

      /**
       * The player is downloading content (it can play while downloading). The handler is called with the time of the event.<br/><br/>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5</p>
       * 
       * @event OO.EVENTS#DOWNLOADING
       */
      DOWNLOADING:  'downloading', // player is downloading content (could be playing while downloading)

      /**
       * Lists the available bitrate information. The handler is called with an object containing the entire SAS response, and includes:
       *   <ul>
       *     <li>The bitrate qualities.</li>
       *     <li>The bitrates.</li>
       *     <li>The target bitrate's quality.</li>
       *     <li>The target bitrate.</li>
       *   </ul>
       * <p>For more information see 
       * <a href="http://support.ooyala.com/developers/documentation/concepts/encodingsettings_videobitrate.html" target="target">Video Bit Rate</a>.</p>
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">Flash</p>
       * 
       * @event OO.EVENTS#BITRATE_INFO_AVAILABLE
       */
      BITRATE_INFO_AVAILABLE: 'bitrateInfoAvailable',
      SET_TARGET_BITRATE: 'setTargetBitrate',
      SET_TARGET_BITRATE_QUALITY: 'setTargetBitrateQuality',
      
      /**
       * The currently playing bitrate has changed. The handler is called with the video bitrate.
       * <p>For more information see 
       * <a href="http://support.ooyala.com/developers/documentation/concepts/encodingsettings_videobitrate.html" target="target">Video Bit Rate</a>.</p>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">Flash</p>
       * 
       * @event OO.EVENTS#BITRATE_CHANGED
       */
      BITRATE_CHANGED: 'bitrateChanged',

      CLOSED_CAPTIONS_INFO_AVAILABLE: 'closedCaptionsInfoAvailable',
      SET_CLOSED_CAPTIONS_LANGUAGE: 'setClosedCaptionsLanguage',

      INSERT_CUE_POINT: 'insertCuePoint',

      SCRUBBING: 'scrubbing',
      SCRUBBED: 'scrubbed',

      /**
       * A request to perform a seek has occurred. The playhead is requested to move to 
       * a specific location, specified in milliseconds. The handler is called with the position to which to seek.<br/><br/>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5</p>
       * 
       * @event OO.EVENTS#SEEK
       */
      SEEK: 'seek',

      /**
       * The player has finished seeking to the requested position.<br/><br/>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5</p>
       * 
       * @event OO.EVENTS#SEEKED
       */
      SEEKED: 'seeked',

      /**
       * A playback request has been made. <br/><br/>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5, Flash</p>
       * 
       * @event OO.EVENTS#PLAY
       */
      PLAY: 'play',
      PLAYING: 'playing',
      PLAY_FAILED: 'playFailed',
      CAN_PLAY: 'canPlay',

      /**
       * A player pause has been requested. <br/><br/>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5, Flash</p>
       * 
       * @event OO.EVENTS#PAUSE
       */
      PAUSE: 'pause',

      /**
       * The player was paused. <br/><br/>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5, Flash</p>
       * 
       * @event OO.EVENTS#PAUSED
       */
      PAUSED: 'paused',

      /**
       * The video and asset were played. The handler is called with the arguments that were passed.<br/><br/>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">Flash</p>
       * 
       * @event OO.EVENTS#PLAYED
       */
      PLAYED: 'played',

      TOGGLE_SHARE_PANEL: 'toggleSharePanel',
      SHARE_PANEL_CLICKED: 'sharePanelClicked',
      TOGGLE_INFO_PANEL: 'toggleInfoPanel',
      INFO_PANEL_CLICKED: 'infoPanelClicked',

      SHOULD_DISPLAY_CUE_POINTS: 'shouldDisplayCuePoints',

      /**
       * This event is triggered before a change is made to the full screen setting of the player. 
       * The handler is called with <code>true</code> if the full screen setting will be enabled, 
       * and is called with <code>false</code> if the full screen setting will be disabled.
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5</p>
       * 
       * @event OO.EVENTS#WILL_CHANGE_FULLSCREEN
       */
      WILL_CHANGE_FULLSCREEN: 'willChangeFullscreen',

      /**
       * The fullscreen state has changed. Depending on the context, the handler is called with: 
       *   <ul>
       *     <li><code>isFullscreen</code> is set to <code>true</code> or <code>false</code>.</li>
       *     <li><code>isFullscreen</code> and <code>paused</code> are each set to <code>true</code> or <code>false</code>.</li>
       *   </ul>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5, Flash</p>
       * 
       * @event OO.EVENTS#FULLSCREEN_CHANGED
       */
      FULLSCREEN_CHANGED: 'fullscreenChanged',

      /**
       * The screen size has changed. This event can also be triggered by a screen orientation change for handheld devices. 
       * Depending on the context, the handler is called with:
       *   <ul>
       *     <li>The width of the player.</li>
       *     <li>The height of the player.</li>
       *   </ul>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5</p>
       * 
       * @event OO.EVENTS#SIZE_CHANGED
       */
      SIZE_CHANGED: 'sizeChanged',

      /**
       * A request to change volume has been made. The handler is called with the volume level.<br/><br/>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5, Flash</p>
       * 
       * @event OO.EVENTS#CHANGE_VOLUME
       */
      CHANGE_VOLUME: 'changeVolume',

      /**
       * The volume has changed. The handler is called with the current volume, which has a value between 0 and 1, inclusive.<br/><br/>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5, Flash</p>
       * 
       * @event OO.EVENTS#VOLUME_CHANGED
       */
      VOLUME_CHANGED: 'volumeChanged',

      /**
       * Controls are shown.<br/><br/>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5</p>
       * 
       * @event OO.EVENTS#CONTROLS_SHOWN
       */
      CONTROLS_SHOWN: 'controlsShown',

      /**
       * Controls are hidden.<br/><br/>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5</p>
       * 
       * @event OO.EVENTS#CONTROLS_HIDDEN
       */
      CONTROLS_HIDDEN: 'controlsHidden',
      END_SCREEN_SHOWN: 'endScreenShown',

      PLAYER_CLICKED: 'playerClicked',

      /**
       * An error has occurred. The handler is called with a JSON object that always includes an error code field, 
       * and may also include other error-specific fields.<br/><br/>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5, Flash</p>
       * 
       * @event OO.EVENTS#ERROR
       */
      ERROR: 'error',

      /**
       * The player is currently being destroyed, and anything created by your module must also be deleted. 
       * After the destruction is complete, there is nothing left to send an event.
       * Any plugin that creates or has initialized any long-living logic should listen to this event and clean up that logic.
       * <br/><br/>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5, Flash</p>
       * 
       * @event OO.EVENTS#DESTROY
       */
      DESTROY: 'destroy',

      WILL_PLAY_FROM_BEGINNING: 'willPlayFromBeginning',

      DISABLE_PLAYBACK_CONTROLS: 'disablePlaybackControls',      
      ENABLE_PLAYBACK_CONTROLS: 'enablePlaybackControls',
      WILL_FETCH_ADS: 'willFetchAds',

      /**
       * This event is triggered before an ad is played. Depending on the context, the handler is called with:
       *   <ul>
       *     <li>The duration of the ad.</li>
       *     <li>The ID of the ad.</li>
       *   </ul>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5, Flash</p>
       * 
       * <h5>Analytics:</h5>
       * <p style="text-indent: 1em;"Triggers an <b>Ad Analytics</b> <code>AD_IMPRESSION</code> event.</p>
       * 
       * @event OO.EVENTS#WILL_PLAY_ADS
       */
      WILL_PLAY_ADS: 'willPlayAds',
      WILL_PLAY_SINGLE_AD: 'willPlaySingleAd',
      WILL_PAUSE_ADS: 'willPauseAds',

      /**
       * A set of ads have been played. Depending on the context, the handler is called with:
       *   <ul>
       *     <li>The duration of the ad.</li>
       *     <li>The ID of the item to play.</li>
       *   </ul>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">Flash</p>
       * 
       * @event OO.EVENTS#ADS_PLAYED
       */
      ADS_PLAYED: 'adsPlayed',

      SINGLE_AD_PLAYED: 'singleAdPlayed',

      /**
       * This event is triggered when an error has occurred with an ad. <br/><br/>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5</p>
       * 
       * @event OO.EVENTS#ADS_ERROR
       */
      ADS_ERROR: 'adsError',

      /**
       * This event is triggered when an ad has been clicked. <br/><br/>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5</p>
       * 
       * @event OO.EVENTS#ADS_CLICKED
       */
      ADS_CLICKED: 'adsClicked',

      FIRST_AD_FETCHED: "firstAdFetched",
      AD_CONFIG_READY: "adConfigReady",

      /**
       * This event is triggered before the companion ads are shown. 
       * Companion ads are displayed on a customer page and are not displayed in the player.
       * This event notifies the page handler to display the specified ad, and is the only means by which companion ads can appear. 
       * If the page does not handle this event, companion ads will not appear.
       * Depending on the context, the handler is called with: 
       *   <ul>
       *     <li>The ID of all companion ads.</li>
       *     <li>The ID of a single companion ad.</li>
       *   </ul>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5</p>
       * 
       * <h5>Analytics:</h5>
       * <p style="text-indent: 1em;"Triggers an <b>Ad Analytics</b> <code>AD_IMPRESSION</code> event.</p>
       * 
       * @event OO.EVENTS#WILL_SHOW_COMPANION_ADS
       */
      WILL_SHOW_COMPANION_ADS: "willShowCompanionAds",
      AD_FETCH_FAILED: "adFetchFailed",

      MIDROLL_PLAY_FAILED: "midrollPlayFailed",
      SKIP_AD: "skipAd",
      UPDATE_AD_COUNTDOWN: "updateAdCountdown",
      SHOW_AD_MARQUEE: "showAdMarquee",
      BLOCK_INITIAL_TIME: "blockInitialTime",

      ADOBE_PASS_WAITING_FOR_TOKEN: "adobePassWaitingForToken", // When the flash player is waiting for token
      ADOBE_PASS_TOKEN_FETCHED: "adobePassTokenFetched",
      ADOBE_PASS_AUTH_STATUS: "setAuthenticationStatus",

      // this player is part of these experimental variations
      REPORT_EXPERIMENT_VARIATIONS: "reportExperimentVariations",

      FETCH_STYLE: "fetchStyle",
      STYLE_FETCHED: "styleFetched",
      SET_STYLE: "setStyle",

      USE_SERVER_SIDE_HLS_ADS: "useServerSideHlsAds",

      LOAD_ALL_VAST_ADS: "loadAllVastAds",
      ADS_FILTERED: "adsFiltered",
      ADS_MANAGER_HANDLING_ADS: "adsManagerHandlingAds",
      ADS_MANAGER_FINISHED_ADS: "adsManagerFinishedAds",

      // Window published beforeUnload event. It's still user cancellable.
      /**
       * The window, document, and associated resources are being unloaded.
       * The handler is called with <code>true</code> if a page unload has been requested, <code>false</code> otherwise.
       * This event may be required since some browsers perform asynchronous page loading while the current page is still active, 
       * meaning that the end user loads a page with the Ooyala player, plays an asset, then redirects the page to a new URL they have specified.
       * Some browsers will start loading the new data while still displaying the player, which will result in an error since the networking has already been reset. 
       * To prevent such false errors, listen to this event and ignore any errors raised after such actions have occurred. 
       * <br/><br/>
       * 
       * <h5>Compatibility: </h5>
       * <p style="text-indent: 1em;">HTML5</p>
       * 
       * @event OO.EVENTS#PAGE_UNLOAD_REQUESTED
       */
      PAGE_UNLOAD_REQUESTED: "pageUnloadRequested",
      // Either 1) The page is refreshing (almost certain) or 2) The user tried to refresh
      // the page, the embedding page had an "Are you sure?" prompt, the user clicked
      // on "stay", and a real error was produced due to another reason during the
      // following few seconds. The real error, if any, will be received in some seconds.
      // If we are certain it has unloaded, it's too late to be useful.
      PAGE_PROBABLY_UNLOADING: "pageProbablyUnloading",

      // DiscoveryApi publishes these, OoyalaAnalytics listens for them and propagates to reporter.js
      REPORT_DISCOVERY_IMPRESSION: "reportDiscoveryImpression",
      REPORT_DISCOVERY_CLICK: "reportDiscoveryClick",

      __end_marker : true
    };

    /**
    * @description Represents the Ooyala V3 Player Errors. Use message bus events to handle errors by subscribing to or intercepting the <code>OO.EVENTS.ERROR</code> event. 
    * For more information, see <a href="http://support.ooyala.com/developers/documentation/concepts/errors_overview.html" target="target">Errors and Error Handling Overview</a>.
    * @summary Represents the Ooyala V3 Player Errors.
    * @namespace OO.ERROR
    */
    OO.ERROR = {
     /**
      * @description Represents the <code>OO.ERROR.API</code> Ooyala V3 Player Errors. Use message bus events to handle errors by subscribing to or intercepting the <code>OO.EVENTS.ERROR</code> event. 
      * For more information, see <a href="http://support.ooyala.com/developers/documentation/concepts/errors_overview.html" target="target">Errors and Error Handling Overview</a>.
      * @summary Represents the <code>OO.ERROR.API</code> Ooyala V3 Player Errors.
      * @namespace OO.ERROR.API
      */
      API: {
       /**
        * @description <code>OO.ERROR.API.NETWORK ('network')</code>: Cannot contact the server.
    	* @constant OO.ERROR.API.NETWORK
    	* @type {string}
    	*/
        NETWORK:'network',
        /**
         * @description Represents the <code>OO.ERROR.API.SAS</code> Ooyala V3 Player Errors for the Stream Authorization Server. 
         * Use message bus events to handle errors by subscribing to or intercepting the <code>OO.EVENTS.ERROR</code> event. 
         * For more information, see <a href="http://support.ooyala.com/developers/documentation/concepts/errors_overview.html" target="target">Errors and Error Handling Overview</a>.
          * @summary Represents the <code>OO.ERROR.API.SAS</code> Ooyala V3 Player Errors.
         * @namespace OO.ERROR.API.SAS
         */
        SAS: {
         /**
          * @description <code>OO.ERROR.API.SAS.GENERIC ('sas')</code>: Invalid authorization response.
          * @constant OO.ERROR.API.SAS.GENERIC
          * @type {string}
          */
          GENERIC:'sas',
          /**
           * @description <code>OO.ERROR.API.SAS.GEO ('geo')</code>: This video is not authorized for your location.
           * @constant OO.ERROR.API.SAS.GEO
           * @type {string}
           */
          GEO:'geo',
          /**
           * @description <code>OO.ERROR.API.SAS.DOMAIN ('domain')</code>: This video is not authorized for your domain.
           * @constant OO.ERROR.API.SAS.DOMAIN
           * @type {string}
           */
          DOMAIN:'domain',
          /**
           * @description <code>OO.ERROR.API.SAS.FUTURE ('future')</code>: This video will be available soon.
           * @constant OO.ERROR.API.SAS.FUTURE
           * @type {string}
           */
          FUTURE:'future',
          /**
           * @description <code>OO.ERROR.API.SAS.PAST ('past')</code>: This video is no longer available.
           * @constant OO.ERROR.API.SAS.PAST
           * @type {string}
           */
          PAST:'past',
          /**
           * @description <code>OO.ERROR.API.SAS.DEVICE ('device')</code>: This video is not authorized for playback on this device.
           * @constant OO.ERROR.API.SAS.DEVICE
           * @type {string}
           */
          DEVICE:'device',
          /**
           * @description <code>OO.ERROR.API.SAS.PROXY ('proxy')</code>: An anonymous proxy was detected. Please disable the proxy and retry.
           * @constant OO.ERROR.API.SAS.PROXY
           * @type {string}
           */
          PROXY:'proxy',
          /**
           * @description <code>OO.ERROR.API.SAS.CONCURRENT_STREAM ('concurrent_streams')S</code>: You have exceeded the maximum number of concurrent streams.
           * @constant OO.ERROR.API.SAS.CONCURRENT_STREAMS
           * @type {string}
           */
          CONCURRENT_STREAMS:'concurrent_streams',
          /**
           * @description <code>OO.ERROR.API.SAS.INVALID_HEARTBEAT ('invalid_heartbeat')</code>: Invalid heartbeat response.
           * @constant OO.ERROR.API.SAS.INVALID_HEARTBEAT
           * @type {string}
           */
          INVALID_HEARTBEAT:'invalid_heartbeat',
          /**
           * @description <code>OO.ERROR.API.SAS.ERROR_DEVICE_INVALID_AUTH_TOKEN ('device_invalid_auth_token')</code>: Invalid Ooyala Player token.
           * @constant OO.ERROR.API.SAS.ERROR_DEVICE_INVALID_AUTH_TOKEN
           * @type {string}
           */
          ERROR_DEVICE_INVALID_AUTH_TOKEN:'device_invalid_auth_token',
          /**
           * @description <code>OO.ERROR.API.SAS.ERROR_DEVICE_LIMIT_REACHED ('device_limit_reached')</code>: The device limit has been reached.
           * The device limit is the maximum number of devices that can be registered with the viewer. 
           * When the number of registered devices exceeds the device limit for the account or provider, this error is displayed.
           * @constant OO.ERROR.API.SAS.ERROR_DEVICE_LIMIT_REACHED
           * @type {string}
           */
          ERROR_DEVICE_LIMIT_REACHED:'device_limit_reached',
          /**
           * @description <code>OO.ERROR.API.SAS.ERROR_DEVICE_BINDING_FAILED ('device_binding_failed')</code>: Device binding failed.
           * If the number of devices registered is already equal to the number of devices that may be bound for the account, 
           * attempting to register a new device will result in this error.
           * @constant OO.ERROR.API.SAS.ERROR_DEVICE_BINDING_FAILED
           * @type {string}
           */
          ERROR_DEVICE_BINDING_FAILED:'device_binding_failed',
          /**
           * @description <code>OO.ERROR.API.SAS.ERROR_DEVICE_ID_TOO_LONG ('device_id_too_long')</code>: The device ID is too long.
           * The length limit for the device ID is 1000 characters.
           * @constant OO.ERROR.API.SAS.ERROR_DEVICE_ID_TOO_LONG
           * @type {string}
           */
          ERROR_DEVICE_ID_TOO_LONG:'device_id_too_long',
          /**
           * @description <code>OO.ERROR.API.SAS.ERROR_DRM_RIGHTS_SERVER_ERROR ('drm_server_error')</code>: DRM server error.
           * @constant OO.ERROR.API.SAS.ERROR_DRM_RIGHTS_SERVER_ERROR
           * @type {string}
           */
          ERROR_DRM_RIGHTS_SERVER_ERROR:'drm_server_error',
          /**
           * @description <code>OO.ERROR.API.SAS.ERROR_DRM_GENERAL_FAILURE ('drm_general_failure')</code>: General error with acquiring license.
           * @constant OO.ERROR.API.SAS.ERROR_DRM_GENERAL_FAILURE
           * @type {string}
           */
          ERROR_DRM_GENERAL_FAILURE:'drm_general_failure',

          /**
           * @description <code>OO.ERROR.API.SAS.ERROR_INVALID_ENTITLEMENTS ('invalid_entitlements')</code>: User Entitlement Terminated - Stream No Longer Active for the User.
           * @constant OO.ERROR.API.SAS.ERROR_INVALID_ENTITLEMENTS
           * @type {string}
           */
          ERROR_INVALID_ENTITLEMENTS:'invalid_entitlements'
        },
       /**
        * @description <code>OO.ERROR.API.CONTENT_TREE ('content_tree')</code>: Invalid Content.
     	* @constant OO.ERROR.API.CONTENT_TREE
     	* @type {string}
     	*/
        CONTENT_TREE:'content_tree',
       /**
        * @description <code>OO.ERROR.API.METADATA ('metadata')</code>: Invalid Metadata.
      	* @constant OO.ERROR.API.METADATA
      	* @type {string}
      	*/
        METADATA:'metadata'
      },
     /**
      * @description Represents the <code>OO.ERROR.PLAYBACK</code> Ooyala V3 Player Errors. Use message bus events to handle errors by subscribing to or intercepting the <code>OO.EVENTS.ERROR</code> event. 
      * For more information, see <a href="http://support.ooyala.com/developers/documentation/concepts/errors_overview.html" target="target">Errors and Error Handling Overview</a>.
      * @summary Represents the <code>OO.ERROR.PLAYBACK</code> Ooyala V3 Player Errors.
      * @namespace OO.ERROR.PLAYBACK
      */
      PLAYBACK: {
       /**
        * @description <code>OO.ERROR.PLAYBACK.GENERIC ('playback')</code>: Could not play the content.
        * @constant OO.ERROR.PLAYBACK.GENERIC
        * @type {string}
        */
        GENERIC:'playback',
        /**
         * @description <code>OO.ERROR.PLAYBACK.STREAM ('stream')</code>: This video is not encoded for your device.
         * @constant OO.ERROR.PLAYBACK.STREAM
         * @type {string}
         */
        STREAM:'stream',
        /**
         * @description <code>OO.ERROR.PLAYBACK.LIVESTREAM ('livestream')</code>: Live stream is off air.
         * @constant OO.ERROR.PLAYBACK.LIVESTREAM
         * @type {string}
         */
        LIVESTREAM:'livestream',
        /**
         * @description <code>OO.ERROR.PLAYBACK.NETWORK ('network_error')</code>: The network connection was temporarily lost.
         * @constant OO.ERROR.PLAYBACK.NETWORK
         * @type {string}
         */
        NETWORK: 'network_error'
      },
      CHROMECAST: {
        MANIFEST:'chromecast_manifest',
        MEDIAKEYS:'chromecast_mediakeys',
        NETWORK:'chromecast_network',
        PLAYBACK:'chromecast_playback',
        INVALID_MESSAGE: 'chromecast_invalid_message'
      },
     /**
      * @description <code>OO.ERROR.UNPLAYABLE_CONTENT ('unplayable_content')</code>: This video is not playable on this player.
   	  * @constant OO.ERROR.UNPLAYABLE_CONTENT
   	  * @type {string}
   	  */
      UNPLAYABLE_CONTENT:'unplayable_content',
     /**
      * @description <code>OO.ERROR.INVALID_EXTERNAL_ID ('invalid_external_id')</code>: Invalid External ID.
      * @constant OO.ERROR.INVALID_EXTERNAL_ID
      * @type {string}
      */
      INVALID_EXTERNAL_ID:'invalid_external_id',
      /**
       * @description <code>OO.ERROR.EMPTY_CHANNEL ('empty_channel')</code>: This channel is empty.
       * @constant OO.ERROR.EMPTY_CHANNEL
       * @type {string}
       */
      EMPTY_CHANNEL:'empty_channel',
      /**
       * @description <code>OO.ERROR.EMPTY_CHANNEL_SET ('empty_channel_set')</code>: This channel set is empty.
       * @constant OO.ERROR.EMPTY_CHANNEL_SET
       * @type {string}
       */
      EMPTY_CHANNEL_SET:'empty_channel_set',
      /**
       * @description <code>OO.ERROR.CHANNEL_CONTENT ('channel_content')</code>: This channel is not playable at this time.
       * @constant OO.ERROR.CHANNEL_CONTENT
       * @type {string}
       */
      CHANNEL_CONTENT:'channel_content'
    };

    // All Server-side URLS
    OO.URLS = {
      ADOBE_AE_URL_STAGING: "https://entitlement.auth-staging.adobe.com/entitlement/AccessEnabler.js",
      ADOBE_AE_URL: "https://entitlement.auth.adobe.com/entitlement/AccessEnabler.js",
      TOKEN_VERIFIER_URL:  _.template('/sas/embed_token/pcode/<%=embedCode%>?auth_type=adobepass&requestor=<%=requestor%>&token=<%=token%>&resource=<%=resource%>&mvpd_id=<%=mvpd_id%>'),
      VAST_PROXY: _.template('http://player.ooyala.com/nuplayer/mobile_vast_ads_proxy?callback=<%=cb%>&embed_code=<%=embedCode%>&expires=<%=expires%>&tag_url=<%=tagUrl%>'),
      EXTERNAL_ID: _.template('<%=server%>/player_api/v1/content_tree/external_id/<%=pcode%>/<%=externalId%>'),
      CONTENT_TREE: _.template('<%=server%>/player_api/v1/content_tree/embed_code/<%=pcode%>/<%=embedCode%>'),
      METADATA: _.template('<%=server%>/player_api/v1/metadata/embed_code/<%=playerBrandingId%>/<%=embedCode%>?videoPcode=<%=pcode%>'),
      SAS: _.template('<%=server%>/player_api/v1/authorization/embed_code/<%=pcode%>/<%=embedCode%>'),
      ANALYTICS: _.template('<%=server%>/reporter.js'),
      PLAYER_XML: _.template('<%=server%>/nuplayer?embedCode=<%=embedCode%>&playerBrandingId=<%=playerBrandingId%>'),
      PLAYER_SWF: _.template('<%=server%>?player=<%=player%>'),
      CAST_RECEIVER_LIB: "//www.gstatic.com/cast/sdk/libs/receiver/2.0.0/cast_receiver.js",
      MEDIA_PLAYER_LIB: "//www.gstatic.com/cast/sdk/libs/mediaplayer/1.0.0/media_player.js",
      __end_marker : true
    };

    OO.CSS = {
      VISIBLE_POSITION : "0px",
      INVISIBLE_POSITION : "-100000px",
      SUPER_Z_INDEX: 20000,
      TRANSPARENT_COLOR : "rgba(255, 255, 255, 0)",

      __end_marker : true
    };

    // flash embed attribute: http://helpx.adobe.com/flash/kb/flash-object-embed-tag-attributes.html
    OO.TEMPLATES = {
      RANDOM_PLACE_HOLDER: ['[place_random_number_here]', '<now>', '[timestamp]', '<rand-num>', '[cache_buster]', '[random]'],
      REFERAK_PLACE_HOLDER: ['[referrer_url]', '[LR_URL]'],
      EMBED_CODE_PLACE_HOLDER: ['[oo_embedcode]'],
      FLASH : '\
         <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" \
             id="<%= playerId %>" class="video" width="100%" height="100%">\
          <param name="movie" value="<%= swfUrl %>" />\
          <!--[if !IE]>-->\
          <object type="application/x-shockwave-flash" id="<%= playerId %>_internal" data="<%= swfUrl %>"\
              width="100%" height="100%">\
          <!--<![endif]-->\
          <param name="allowScriptAccess" value="always">\
          <param name="allowFullScreen" value="true">\
          <param name="bgcolor" value="#000000">\
          <param name="wmode" value="<%= wmode %>">\
          <param name="flashvars" value="<%= flashVars %>">\
           <p>Please upgrade your Flash Plugin</p>\
          <!--[if !IE]>-->\
          </object>\
          <!--<![endif]-->\
         </object>\
         ',
         FLASH_IE : '\
            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" \
                id="<%= playerId %>" class="video" width="100%" height="100%">\
             <param name="movie" value="<%= swfUrl %>" />\
             <param name="allowScriptAccess" value="always">\
             <param name="allowFullScreen" value="true">\
             <param name="bgcolor" value="#000000">\
             <param name="wmode" value="<%= wmode %>">\
             <param name="flashvars" value="<%= flashVars %>">\
              <p>Please upgrade your Flash Plugin</p>\
            </object>\
            ',
      MESSAGE : '\
                  <table width="100%" height="100%" bgcolor="black" style="padding-left:55px; padding-right:55px; \
                  background-color:black; color: white;">\
                  <tbody>\
                  <tr valign="middle">\
                  <td align="right"><span style="font-family:Arial; font-size:20px">\
                  <%= message %>\
                  </span></td></tr></tbody></table>\
                  ',

      FLASH_INSTALL : '\
                        <div style="color:white">You need to have the Adobe Flash Player to view this content.</div>\
                        <div style="font-size:16px;"><a href="http://www.adobe.com/go/getflash/" style="color:white">Please click here to continue.</a></div>\
                        ',

      __end_marker : true
    };

    OO.CONSTANTS = {
      STANDALONE_AD_HOLDER: "third_party_standalone_ad_holder",

      // Ad frequency constants
      AD_PLAY_COUNT_KEY: "oo_ad_play_count",
      AD_ID_TO_PLAY_COUNT_DIVIDER: ":",
      AD_PLAY_COUNT_DIVIDER: "|",
      MAX_AD_PLAY_COUNT_HISTORY_LENGTH: 20,

      GOOGLE_CAST_NAMESPACE: "urn:x-cast:com.google.cast.media",
      CAST_NAMESPACE: "urn:x-cast:ooyala",
      __end_marker : true
    };

  }(OO,OO._));
(function(OO) {
  // place holder for all text resource key
  OO.TEXT = {
    ADS_COUNTDOWN: 'adsCountdown',
    LIVE: 'LIVE',
    HOOK_PROMPT: 'hookPrompt',
    HOOK_DOWNLOAD: 'hookDownload',
    HOOK_INSTALLED: 'hookInstalled',
    HOOK_IGNORE: 'hookIgnore',

    __end_marker: true
  };

}(OO));
(function(OO) {
  OO.MESSAGES = {
    EN: {},
    ES: {},
    FR: {},
    JA: {}
  };

  var en = OO.MESSAGES.EN;
  var es = OO.MESSAGES.ES;
  var fr = OO.MESSAGES.FR;
  var ja = OO.MESSAGES.JA;

  // ENGLISH
  en[OO.ERROR.API.NETWORK] = "Cannot Contact Server";
  en[OO.ERROR.API.SAS.GENERIC] = "Invalid Authorization Response";
  en[OO.ERROR.API.SAS.GEO] = "This video is not authorized in your location";
  en[OO.ERROR.API.SAS.DOMAIN] = "This video is not authorized for your domain";
  en[OO.ERROR.API.SAS.FUTURE] = "This video will be available soon";
  en[OO.ERROR.API.SAS.PAST] = "This video is no longer available";
  en[OO.ERROR.API.SAS.DEVICE] = "This video is not authorized for playback on this device";
  en[OO.ERROR.API.SAS.PROXY] = "An anonymous proxy was detected. Please disable the proxy and retry.";
  en[OO.ERROR.API.SAS.CONCURRENT_STREAMS] = "You have exceeded the maximum number of concurrent streams";
  en[OO.ERROR.API.SAS.INVALID_HEARTBEAT] = "Invalid heartbeat response";
  en[OO.ERROR.API.SAS.ERROR_DEVICE_INVALID_AUTH_TOKEN] = "Invalid Ooyala Player Token";
  en[OO.ERROR.API.SAS.ERROR_DEVICE_LIMIT_REACHED] = "Device limit reached";
  en[OO.ERROR.API.SAS.ERROR_DEVICE_BINDING_FAILED] = "Device binding failed";
  en[OO.ERROR.API.SAS.ERROR_DEVICE_ID_TOO_LONG] = "Device id too long";
  en[OO.ERROR.API.SAS.ERROR_DRM_RIGHTS_SERVER_ERROR] =
    "General SOAP error from DRM server, will pass message from server to event";
  en[OO.ERROR.API.SAS.ERROR_INVALID_ENTITLEMENTS] = "User Entitlement Terminated - Stream No Longer Active for the User";
  en[OO.ERROR.API.CONTENT_TREE] = "Invalid Content";
  en[OO.ERROR.API.METADATA] = "Invalid Metadata";
  en[OO.ERROR.PLAYBACK.GENERIC] = "Could not play the content";
  en[OO.ERROR.PLAYBACK.STREAM] = "This video isn't encoded for your device";
  en[OO.ERROR.PLAYBACK.LIVESTREAM] = "Live stream is off air";
  en[OO.ERROR.PLAYBACK.NETWORK] = "Network connection temporarily lost";
  en[OO.ERROR.UNPLAYABLE_CONTENT] = "This video is not playable on this player";
  en[OO.ERROR.INVALID_EXTERNAL_ID] = "Invalid External ID";
  en[OO.ERROR.EMPTY_CHANNEL] = "This channel is empty";
  en[OO.ERROR.EMPTY_CHANNEL_SET] = "This channel set is empty";
  en[OO.ERROR.CHANNEL_CONTENT] = "This channel is not playable at this time";
  en[OO.ERROR.STREAM_PLAY_FAILED] = "This video is not encoded for your device";

  // Chromecast Specific Errors
  // https://developers.google.com/cast/docs/reference/player/cast.player.api.ErrorCode
  en[OO.ERROR.CHROMECAST.MANIFEST] = "Error loading or parsing the manifest";
  en[OO.ERROR.CHROMECAST.MEDIAKEYS] = "Error fetching the keys or decrypting the content";
  en[OO.ERROR.CHROMECAST.NETWORK] = "Network error";
  en[OO.ERROR.CHROMECAST.PLAYBACK] = "Error related to media playback";

  en[OO.TEXT.ADS_COUNTDOWN] = "Advertisement: Your Video will resume shortly";
  en[OO.TEXT.LIVE] = "LIVE";
  en[OO.TEXT.HOOK_PROMPT] = "The Hook Player is required to watch this video";
  en[OO.TEXT.HOOK_DOWNLOAD] = "Download Hook";
  en[OO.TEXT.HOOK_INSTALLED] = "I Already Have It";
  en[OO.TEXT.HOOK_IGNORE] = "Remind Me Later";

  // SPANISH
  es[OO.ERROR.API.NETWORK] = "No se puede contactar al servidor";
  es[OO.ERROR.API.SAS.GENERIC] = "Respuesta de autorización no válida";
  es[OO.ERROR.API.SAS.GEO] = "El vídeo no está autorizado en su ubicación";
  es[OO.ERROR.API.SAS.DOMAIN] = "El vídeo no está autorizado para su dominio";
  es[OO.ERROR.API.SAS.FUTURE] = "El vídeo estará disponible pronto";
  es[OO.ERROR.API.SAS.PAST] = "El vídeo ya no está disponible";
  es[OO.ERROR.API.SAS.DEVICE] = "El vídeo no está autorizado para reproducirse en este dispositivo";
  es[OO.ERROR.API.SAS.PROXY] = "Se detectó un proxy anónimo. Deshabilite el proxy e intente nuevamente.";
  es[OO.ERROR.API.SAS.CONCURRENT_STREAMS] = "Ha superado la cantidad máxima de transmisiones concurrentes";
  es[OO.ERROR.API.SAS.INVALID_HEARTBEAT] = "Respuesta de pulso no válida";
  es[OO.ERROR.API.SAS.ERROR_INVALID_ENTITLEMENTS] = "La suscripción del usuario a terminado - El video ya no está disponible para el usuario";
  es[OO.ERROR.API.CONTENT_TREE] = "Contenido no válido";
  es[OO.ERROR.API.METADATA] = "Metadatos no válidos";
  es[OO.ERROR.PLAYBACK.GENERIC] = "No se pudo reproducir el contenido";
  es[OO.ERROR.PLAYBACK.STREAM] = "El vídeo no está codificado para su dispositivo";
  es[OO.ERROR.PLAYBACK.LIVESTREAM] = "La transmisión en vivo está fuera del aire";
  es[OO.ERROR.PLAYBACK.NETWORK] = "La conexión de red se halla temporalmente perdida";
  es[OO.ERROR.UNPLAYABLE_CONTENT] = "El vídeo no se puede reproducir en este reproductor";
  es[OO.ERROR.INVALID_EXTERNAL_ID] = "ID externo no válido";
  es[OO.ERROR.EMPTY_CHANNEL] = "El canal está vacío";
  es[OO.ERROR.EMPTY_CHANNEL_SET] = "El conjunto de canales está vacío";
  es[OO.ERROR.CHANNEL_CONTENT] = "El canal no se puede reproducir en este momento";
  es[OO.ERROR.STREAM_PLAY_FAILED] = "El vídeo no está codificado para su dispositivo";
  es[OO.TEXT.ADS_COUNTDOWN] = "Anuncio: el vídeo se reanudará en breve";
  es[OO.TEXT.LIVE] = "EN VIVO";
  es[OO.TEXT.HOOK_PROMPT] = "Se requiere Hook Player para ver este vídeo";
  es[OO.TEXT.HOOK_DOWNLOAD] = "Descargar Hook";
  es[OO.TEXT.HOOK_INSTALLED] = "Ya lo tengo";
  es[OO.TEXT.HOOK_IGNORE] = "Recordarme más tarde";

  // FRENCH
  fr[OO.ERROR.API.NETWORK] = "Impossible de contacter le serveur";
  fr[OO.ERROR.API.SAS.GENERIC] = "Réponse d'autorisation non valide";
  fr[OO.ERROR.API.SAS.GEO] = "Cette vidéo n'est pas autorisée dans votre pays";
  fr[OO.ERROR.API.SAS.DOMAIN] = "Cette vidéo n'est pas autorisée pour votre domaine";
  fr[OO.ERROR.API.SAS.FUTURE] = "Cette vidéo sera bientôt disponible";
  fr[OO.ERROR.API.SAS.PAST] = "Cette vidéo n'est plus disponible";
  fr[OO.ERROR.API.SAS.DEVICE] = "La lecture de cette vidéo n'est pas autorisée sur cet appareil";
  fr[OO.ERROR.API.SAS.PROXY] = "Un proxy anonyme a été détecté. Désactivez le proxy, puis réessayez.";
  fr[OO.ERROR.API.SAS.CONCURRENT_STREAMS] = "Vous avez dépassé le nombre maximum de flux simultanés.";
  fr[OO.ERROR.API.SAS.INVALID_HEARTBEAT] = "Réponse du signal de pulsation ('heartbeat') non valide";
  fr[OO.ERROR.API.CONTENT_TREE] = "Contenu non valide";
  fr[OO.ERROR.API.METADATA] = "Métadonnées non valides";
  fr[OO.ERROR.PLAYBACK.GENERIC] = "Impossible de lire le contenu";
  fr[OO.ERROR.PLAYBACK.STREAM] = "Cette vidéo n'est pas encodée pour votre appareil";
  fr[OO.ERROR.PLAYBACK.LIVESTREAM] = "Le flux direct a été interrompu";
  fr[OO.ERROR.PLAYBACK.NETWORK] = "Connexion au réseau temporairement interrompue";
  fr[OO.ERROR.UNPLAYABLE_CONTENT] = "Vous ne pouvez pas lire cette vidéo sur ce lecteur";
  fr[OO.ERROR.INVALID_EXTERNAL_ID] = "Identifiant externe non valide";
  fr[OO.ERROR.EMPTY_CHANNEL] = "Cette chaîne est vide";
  fr[OO.ERROR.EMPTY_CHANNEL_SET] = "Ce groupe de chaînes est vide";
  fr[OO.ERROR.CHANNEL_CONTENT] = "Vous ne pouvez pas lire cette chaîne pour le moment";
  fr[OO.ERROR.STREAM_PLAY_FAILED] = "Cette vidéo n'est pas encodée pour votre appareil";
  fr[OO.TEXT.ADS_COUNTDOWN] = "Publicité : votre vidéo reprendra bientôt";
  fr[OO.TEXT.LIVE] = "EN DIRECT";
  fr[OO.TEXT.HOOK_PROMPT] = "Le lecteur Hook est nécessaire pour visionner cette vidéo";
  fr[OO.TEXT.HOOK_DOWNLOAD] = "Télécharger Hook";
  fr[OO.TEXT.HOOK_INSTALLED] = "Je l'ai déjà";
  fr[OO.TEXT.HOOK_IGNORE] = "Me le rappeler plus tard";

  // JAPANESE
  ja[OO.ERROR.API.NETWORK] = "後でご確認ください。";
  ja[OO.ERROR.API.SAS.GENERIC] = "ビデオを認証できません。";
  ja[OO.ERROR.API.SAS.GEO] = "この地域ではこのビデオは許可されていません。";
  ja[OO.ERROR.API.SAS.DOMAIN] = "お使いのドメインではこのビデオは許可されていません。";
  ja[OO.ERROR.API.SAS.FUTURE] = "このビデオはしばらくすると再生可能になります。";
  ja[OO.ERROR.API.SAS.PAST] = "このビデオは、既に御利用いただけません。";
  ja[OO.ERROR.API.SAS.DEVICE] = "このビデオは、このデバイスでの再生は許可されていません。";
  ja[OO.ERROR.API.SAS.CONCURRENT_STREAMS] = "最大同時接続数を超えています。";
  ja[OO.ERROR.API.SAS.INVALID_HEARTBEAT] = "同時再生ストリームの最大数に達しました。";
  ja[OO.ERROR.API.CONTENT_TREE] = "不正なコンテンツです。";
  ja[OO.ERROR.API.METADATA] = "不正なメタデータです。";
  ja[OO.ERROR.PLAYBACK.GENERIC] = "このコンテンツを再生できませんでした。";
  ja[OO.ERROR.PLAYBACK.STREAM] = "このビデオは、お使いのデバイス向けにエンコードされていません。";
  ja[OO.ERROR.PLAYBACK.LIVESTREAM] = "ライブ配信はされておりません。";
  ja[OO.ERROR.PLAYBACK.NETWORK] = "ネットワークに一時的に接続できません。";
  ja[OO.ERROR.UNPLAYABLE_CONTENT] = "このビデオは、このプレーヤーでは再生できません。";
  ja[OO.ERROR.INVALID_EXTERNAL_ID] = "External IDが不正です。";
  ja[OO.ERROR.EMPTY_CHANNEL] = "このチャンネルは空です。";
  ja[OO.ERROR.EMPTY_CHANNEL_SET] = "このチャンネルセットは空です。";
  ja[OO.ERROR.CHANNEL_CONTENT] = "このチャンネルは、現在再生できません。";
  ja[OO.ERROR.STREAM_PLAY_FAILED] = "このビデオは、お使いのデバイス向けにエンコードされていません。";
  ja[OO.TEXT.ADS_COUNTDOWN] = "広告：";
  ja[OO.TEXT.LIVE] = "ライブ";
  ja[OO.TEXT.HOOK_PROMPT] = "このビデオを視聴するには<br />Hook Video Playerが必要です。";
  ja[OO.TEXT.HOOK_DOWNLOAD] = "Hook Video Playerをダウンロード";
  ja[OO.TEXT.HOOK_INSTALLED] = "既にダウンロード済み";
  ja[OO.TEXT.HOOK_IGNORE] = "あとで通知";
  OO.getLocalizedMessage = function(code) {
    var language = OO.getLocale();
    return (OO.MESSAGES[language] ? OO.MESSAGES[language][code] : undefined) ||
           OO.MESSAGES.EN[code] ||
           "";
  };
}(OO));
  (function(OO) { 
    OO.asset_list = {
      'image/png:discovery_dots' : 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAYAAABw4pVUAAAACXBIWXMAAAsTAAALEwEAmpwYAAA5pGlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS42LWMwMTQgNzkuMTU2Nzk3LCAyMDE0LzA4LzIwLTA5OjUzOjAyICAgICAgICAiPgogICA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPgogICAgICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgICAgICAgICB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iCiAgICAgICAgICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgICAgICAgICB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIKICAgICAgICAgICAgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgICAgICAgICAgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIgogICAgICAgICAgICB4bWxuczpwaG90b3Nob3A9Imh0dHA6Ly9ucy5hZG9iZS5jb20vcGhvdG9zaG9wLzEuMC8iCiAgICAgICAgICAgIHhtbG5zOnRpZmY9Imh0dHA6Ly9ucy5hZG9iZS5jb20vdGlmZi8xLjAvIgogICAgICAgICAgICB4bWxuczpleGlmPSJodHRwOi8vbnMuYWRvYmUuY29tL2V4aWYvMS4wLyI+CiAgICAgICAgIDx4bXA6Q3JlYXRvclRvb2w+QWRvYmUgUGhvdG9zaG9wIENDIDIwMTQgKE1hY2ludG9zaCk8L3htcDpDcmVhdG9yVG9vbD4KICAgICAgICAgPHhtcDpDcmVhdGVEYXRlPjIwMTQtMTEtMjZUMTY6NDA6MzQtMDY6MDA8L3htcDpDcmVhdGVEYXRlPgogICAgICAgICA8eG1wOk1vZGlmeURhdGU+MjAxNC0xMS0yNlQxNjo0NTozNC0wNjowMDwveG1wOk1vZGlmeURhdGU+CiAgICAgICAgIDx4bXA6TWV0YWRhdGFEYXRlPjIwMTQtMTEtMjZUMTY6NDU6MzQtMDY6MDA8L3htcDpNZXRhZGF0YURhdGU+CiAgICAgICAgIDx4bXBNTTpJbnN0YW5jZUlEPnhtcC5paWQ6MzdhNjJiOTItMzk5Mi00Y2NiLTkzOWMtNzQ0ODZiN2JmYmIzPC94bXBNTTpJbnN0YW5jZUlEPgogICAgICAgICA8eG1wTU06RG9jdW1lbnRJRD54bXAuZGlkOjgxOEM0NzcwRTMxODExRTE4REFFREJGNjJEMzIwMkJCPC94bXBNTTpEb2N1bWVudElEPgogICAgICAgICA8eG1wTU06RGVyaXZlZEZyb20gcmRmOnBhcnNlVHlwZT0iUmVzb3VyY2UiPgogICAgICAgICAgICA8c3RSZWY6aW5zdGFuY2VJRD54bXAuaWlkOjgxOEM0NzZERTMxODExRTE4REFFREJGNjJEMzIwMkJCPC9zdFJlZjppbnN0YW5jZUlEPgogICAgICAgICAgICA8c3RSZWY6ZG9jdW1lbnRJRD54bXAuZGlkOjgxOEM0NzZFRTMxODExRTE4REFFREJGNjJEMzIwMkJCPC9zdFJlZjpkb2N1bWVudElEPgogICAgICAgICA8L3htcE1NOkRlcml2ZWRGcm9tPgogICAgICAgICA8eG1wTU06T3JpZ2luYWxEb2N1bWVudElEPnhtcC5kaWQ6ODE4QzQ3NzBFMzE4MTFFMThEQUVEQkY2MkQzMjAyQkI8L3htcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD4KICAgICAgICAgPHhtcE1NOkhpc3Rvcnk+CiAgICAgICAgICAgIDxyZGY6U2VxPgogICAgICAgICAgICAgICA8cmRmOmxpIHJkZjpwYXJzZVR5cGU9IlJlc291cmNlIj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OmFjdGlvbj5zYXZlZDwvc3RFdnQ6YWN0aW9uPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6aW5zdGFuY2VJRD54bXAuaWlkOjM3YTYyYjkyLTM5OTItNGNjYi05MzljLTc0NDg2YjdiZmJiMzwvc3RFdnQ6aW5zdGFuY2VJRD4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OndoZW4+MjAxNC0xMS0yNlQxNjo0NTozNC0wNjowMDwvc3RFdnQ6d2hlbj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OnNvZnR3YXJlQWdlbnQ+QWRvYmUgUGhvdG9zaG9wIENDIDIwMTQgKE1hY2ludG9zaCk8L3N0RXZ0OnNvZnR3YXJlQWdlbnQ+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDpjaGFuZ2VkPi88L3N0RXZ0OmNoYW5nZWQ+CiAgICAgICAgICAgICAgIDwvcmRmOmxpPgogICAgICAgICAgICA8L3JkZjpTZXE+CiAgICAgICAgIDwveG1wTU06SGlzdG9yeT4KICAgICAgICAgPGRjOmZvcm1hdD5pbWFnZS9wbmc8L2RjOmZvcm1hdD4KICAgICAgICAgPHBob3Rvc2hvcDpDb2xvck1vZGU+MzwvcGhvdG9zaG9wOkNvbG9yTW9kZT4KICAgICAgICAgPHRpZmY6T3JpZW50YXRpb24+MTwvdGlmZjpPcmllbnRhdGlvbj4KICAgICAgICAgPHRpZmY6WFJlc29sdXRpb24+NzIwMDAwLzEwMDAwPC90aWZmOlhSZXNvbHV0aW9uPgogICAgICAgICA8dGlmZjpZUmVzb2x1dGlvbj43MjAwMDAvMTAwMDA8L3RpZmY6WVJlc29sdXRpb24+CiAgICAgICAgIDx0aWZmOlJlc29sdXRpb25Vbml0PjI8L3RpZmY6UmVzb2x1dGlvblVuaXQ+CiAgICAgICAgIDxleGlmOkNvbG9yU3BhY2U+NjU1MzU8L2V4aWY6Q29sb3JTcGFjZT4KICAgICAgICAgPGV4aWY6UGl4ZWxYRGltZW5zaW9uPjEwMDwvZXhpZjpQaXhlbFhEaW1lbnNpb24+CiAgICAgICAgIDxleGlmOlBpeGVsWURpbWVuc2lvbj4xMDA8L2V4aWY6UGl4ZWxZRGltZW5zaW9uPgogICAgICA8L3JkZjpEZXNjcmlwdGlvbj4KICAgPC9yZGY6UkRGPgo8L3g6eG1wbWV0YT4KICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAKPD94cGFja2V0IGVuZD0idyI/PpJZWkkAAAAgY0hSTQAAeiUAAICDAAD5/wAAgOkAAHUwAADqYAAAOpgAABdvkl/FRgAAnLRJREFUeAEApJxbYwH///8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABAAAAAABAQEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wcAAAApAAAALwAAACcAAAAgAAAAIgAAABMAAAASAAAAEgAAAAAAAAAAAAAAAAAAAAAAAADuAAAA7QAAAO4AAADeAAAA4AAAANgAAADSAAAA1gEBAfoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////AAAAAAAB////AAEBAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8HAAAAPAAAAEYAAAA9AAAAMwAAAAYAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD5AAAAzQAAAMMAAAC6AAAAxAEBAfoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8AAAAAAAD///8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wn///9T////qf////X////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////0////qP///1P///8JAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wD///8AAP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///y7///+T////8P////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////D///+T////LQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////AP///wAA////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///0b///+6////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////uv///0UAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8A////AAD///8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///z/////E/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////8P///8/AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wD///8AAP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///yT///+w//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////+w////IwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////AP///wAA////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wX///99////+P/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////4////fP///wUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8A////AAH///8AAQEBAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8tAAAApAAAAC4AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA0QAAAFwBAQHUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wAAAAAAAgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////bQAAAMsAAAAuAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAvAAAAzP///2wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAB////AAEBAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////CwAAAJoAAABaAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD1AAAA+wAAAPIAAAAMAAAABwAAAAsAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAKYAAABmAQEB9QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8AAAAAAAH///8AAQEBAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///xoAAAC0AAAAMQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA+gAAANAAAADTAAAAywAAANgAAADfAAAA6gEBAfgAAAAAAAAAAAAAAAAAAAAA////EgAAAB8AAAAbAAAAJwAAACcAAAAzAAAALwAAAAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAM8AAABMAQEB5gAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wAAAAAAAP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8s////4//////////////////////////////////////////////////////////////////////////////////////////////////////////k////mf///1P///8SAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8V////Vv///5f////o/////////////////////////////////////////////////////////////////////////////////////////////////////////+L///8sAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////AP///wAA////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////M////+v///////////////////////////////////////////////////////////////////////////////////////////////b///+n////Tv///wIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wT///9Q////p/////n//////////////////////////////////////////////////////////////////////////////////////////////+v///8yAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8A////AAD///8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///zP////x/////////////////////////////////////////////////////////////////////////////////////////+3///+K////HgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////Iv///43////u//////////////////////////////////////////////////////////////////////////////////////////H///8yAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wD///8AAP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8s////6/////////////////////////////////////////////////////////////////////////////////////X///+Q////FwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///xn///+V////9////////////////////////////////////////////////////////////////////////////////////+v///8sAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////AP///wAA////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////Gv///+L///////////////////////////////////////////////////////////////////////////////////+5////KwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8s////vf///////////////////////////////////////////////////////////////////////////////////+L///8aAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8A////AAD///8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wv////O///////////////////////////////////////////////////////////////////////////////w////aAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////cP////H//////////////////////////////////////////////////////////////////////////////87///8LAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wD///8AAP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////pf//////////////////////////////////////////////////////////////////////////////zP///ygAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////Kf///87//////////////////////////////////////////////////////////////////////////////6UAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////AP///wAA////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///23//////////////////////////////////////////////////////////////////////////////6X///8LAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////Df///6j//////////////////////////////////////////////////////////////////////////////2wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8A////AAD///8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8s////+P////////////////////////////////////////////////////////////////////////+HAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///4n/////////////////////////////////////////////////////////////////////////+P///ywAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wD///8AAP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////Bf///9H////////////////////////////////////////////////////////////////////9////bgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///3n/////////////////////////////////////////////////////////////////////////0P///wUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////AP///wAA////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///98/////////////////////////////////////////////////////////////////////////3IAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///3P/////////////////////////////////////////////////////////////////////////fAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8A////AAD///8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////JP////j///////////////////////////////////////////////////////////////////+EAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///43////////////////////////////////////////////////////////////////////4////IwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wD///8AAP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///+w////////////////////////////////////////////////////////////////////oQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///6X///////////////////////////////////////////////////////////////////+wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////AP///wAA////AAAAAAAAAAAAAAAAAAAAAAAAAAAA////P////////////////////////////////////////////////////////////////////8X///8JAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////Qv///4wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////C////8////////////////////////////////////////////////////////////////////8/AAAAAAAAAAAAAAAAAAAAAAAAAAD///8A////AAD///8AAAAAAAAAAAAAAAAAAAAAAAAAAAD////D///////////////////////////////////////////////////////////////w////HQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8B////Tv///8j/////////cAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////Lv////D//////////////////////////////////////////////////////////////8MAAAAAAAAAAAAAAAAAAAAAAAAAAP///wD///8AAP///wAAAAAAAAAAAAAAAAAAAAAA////Rv///////////////////////////////////////////////////////////////////1oAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8E////Wf///9P///////////////v///8VAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////a////////////////////////////////////////////////////////////////////0UAAAAAAAAAAAAAAAAAAAAA////AP///wAA////AAAAAAAAAAAAAAAAAAAAAAD///+6//////////////////////////////////////////////////////////////+wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8G////Zv///9z/////////////////////////sAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////v///////////////////////////////////////////////////////////////ugAAAAAAAAAAAAAAAAAAAAD///8A////AAD///8AAAAAAAAAAAAAAAAA////Lf//////////////////////////////////////////////////////////////9////yEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8M////cf///+X///////////////////////////////////9SAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8s////9f//////////////////////////////////////////////////////////////LQAAAAAAAAAAAAAAAP///wD///8AAP///wAAAAAAAAAAAAAAAAD///+T//////////////////////////////////////////////////////////////+HAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8Q////ff///+z/////////////////////////////////////////7P///wYAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///+T//////////////////////////////////////////////////////////////+TAAAAAAAAAAAAAAAA////AP///wAA////AAAAAAAAAAAA////Cf////D/////////////////////////////////////////////////////////8P///xUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8Y////iP////P//////////////////////////////+H///////////////////+SAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///xr////x//////////////////////////////////////////////////////////D///8JAAAAAAAAAAD///8A////AAD///8AAAAAAAAAAAD///9T//////////////////////////////////////////////////////////////+FAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8e////lf////f//////////////////////////////8r///9Q////Yv///////////////////zIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///4z//////////////////////////////////////////////////////////////1MAAAAAAAAAAP///wD///8AAP///wAAAAAAAAAAAP///6j/////////////////////////////////////////////////////////9////xUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8p////oP////z//////////////////////////////8D///9FAAAAAAAAAAD////A///////////////UAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////If////n/////////////////////////////////////////////////////////qAAAAAAAAAAA////AP///wAA////AAAAAAD///8G////9f////////////////////////////////////////////////////////+jAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8y////rP////7//////////////////////////////7P///84AAAAAAAAAAAAAAAA////If///////////////////3QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////rP/////////////////////////////////////////////////////////z////BgAAAAD///8A////AAD///8AAAAAAP///0L//////////////////////////////////////////////////////////////0IAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8+////uP///////////////////////////////f///6j///8vAAAAAAAAAAAAAAAAAAAAAAAAAAD///9////////////////8////GAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///9M//////////////////////////////////////////////////////////////9CAAAAAP///wD///8AAP///wAAAAAA////iP/////////////////////////////////////////////////////////h////AQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wH///9I////xP//////////////////////////////+v///5v///8kAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////Af///93//////////////7QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wL////n/////////////////////////////////////////////////////////4gAAAAA////AP///wAA////AAAAAAD////F/////////////////////////////////////////////////////////5QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wL///9W////z///////////////////////////////9f///5D///8dAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8+////////////////////VgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///53/////////////////////////////////////////////////////////xQAAAAD///8A////AAD///8A////B/////j/////////////////////////////////////////////////////////SQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wb///9g////2f//////////////////////////////8P///4T///8UAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///57//////////////+////8HAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////U//////////////////////////////////////////////////////////4////Bv///wD///8AAP///wD///8w//////////////////////////////////////////////////////////n///8IAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wH///9t////4v//////////////////////////////6f///3j///8PAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8K////8v//////////////lgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8S/////P////////////////////////////////////////////////////////8w////AP///wAA////AP///1//////////////////////////////////////////////////////////ywAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////QP//////////////////////////////4v///23///8JAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///1z///////////////////82AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD////O/////////////////////////////////////////////////////////17///8A////AAQAAAAAAAAAJwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADKAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABgAAAAAAAAAAAAAAAAAAAAAAAAAOkAAAA2AQEB6AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAYAAAAAAAAAAAAAAA2AEBAcoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAM0AAAAxAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAKAAAAAAAAAAAAgAAAAAAAAAgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAANgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////DAAAAFQAAAAAAAAAAAAAAAAAAAAAAAAAFwAAALz///8cAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///x4AAABCAAAAAAAAAAAAAAChAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA1gAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgAAAAAAAAAAACAAAAAAAAACIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA4AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABSAAAACwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAKwAAAMb///8nAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAXAAAAAEAAAAAAAAA/gAAAKMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACIAAAAAAAAAAAIAAAAAAAAAEwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADTAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAHQAAAMT///81AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABgAAAAAAAAAAAAAAC7AQEB5QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEgAAAAAAAAAAAP///wD////t/////////////////////////////////////////////////////////wgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8g/////v////////////////////////////////////////////////////P///9EAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////Ov///////////////////1kAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////DP/////////////////////////////////////////////////////////t////AP///wAA////AP/////////////////////////////////////////////////////////zAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///37///////////////////////////////////////////////////////////////r///9VAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///+a///////////////x////CQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA/////P////////////////////////////////////////////////////////8A////AAD///8A/////////////////////////////////////////////////////////+4AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8B////2/////////////////////////////////////////////////////////////////////3///9qAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////CP////H//////////////5oAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD////x/////////////////////////////////////////////////////////wD///8AAgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA9AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADsAAAAkAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgAAAJX///9/AAAAAAAAAAAAAAAAAAAAAAAAAAAAAABQAAAADgAAAAAAAAAAAAAAoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAPQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////AP/////////////////////////////////////////////////////////xAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////nP////////////////////////////////////////////////////////////////////////////////////////+T////AgAAAAAAAAAAAAAAAP///7j//////////////9oAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////8P////////////////////////////////////////////////////////8A////AAD///8A//////////////////////////////////////////////////////////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wn////y//////////////////////////////////////////////////////////////////////////////////////////////+o////BgAAAAD///8b/////f//////////////fAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD////8/////////////////////////////////////////////////////////wD///8AAgAAAAAAAADuAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////w0AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAUQAAAA0AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAFcAAAC0////CwAAAFsAAAACAAAAAAAAAP8AAACiAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////BgAAAAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADuAAAAAAAAAAAEAAAAAAAAAO4AAAASAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAIgAAANEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEUAAAC+AAAAEQAAAAAAAAAAAAAAvgEBAeIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAbAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAO0AAAAAAAAAAAIAAAAAAAAA7QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAhAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////HAAAAEQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADYAAAAlAAAAAAAAAAAAAACgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA7gAAAAAAAAAAAgAAAAAAAADeAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABdAAAAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA9AAAAK8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAIwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADeAAAAAAAAAAACAAAAAAAAAOAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAJwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAF8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACrAQEB9QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAtAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOAAAAAAAAAAAAIAAAAAAAAA2QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA0AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///84AAAAJwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAKAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADcAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA2QAAAAAAAAAAAgAAAAAAAADRAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAC////8SAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOMAAABtAAAAwwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8KAAAAMgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADRAAAAAAAAAAAA////AP///wf////5/////////////////////////////////////////////////////////1EAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8H////7////////////////////////////////////////////////////////////////////////////////////////////////////////////////////9f///9g////BQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///0T/////////////////////////////////////////////////////////+P///wb///8A////AAIAAAAAAQEB+QAAAM0AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAASwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAE8AAAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAANAAAABWAAAAKwEBAaABAQH7AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADNAQEB+gAAAAAAAAAAAgAAAAAAAAAAAAAAwwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABM////BAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAYAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMQAAABJAQEBMQEBAasBAQH+AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wEAAABRAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMMAAAAAAAAAAAAAAAAA////AAAAAAD///9C//////////////////////////////////////////////////////////////9NAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///xn////9/////////////////////////////////////////////////////////////////////////////////////////7j///89AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////O///////////////////////////////////////////////////////////////QgAAAAD///8A////AAD///8AAAAAAP///wf////1/////////////////////////////////////////////////////////6kAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////dP///////////////////////////////////////////////////////////////////////////////v///6v///8xAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///+k//////////////////////////////////////////////////////////X///8GAAAAAP///wD///8AAP///wAAAAAAAAAAAP///6n/////////////////////////////////////////////////////////+f///yIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD////U////////////////////////////////////////////////////////////////////+////6D///8oAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////Fv////n/////////////////////////////////////////////////////////qAAAAAAAAAAA////AP///wAA////AAAAAAAAAAAA////U///////////////////////////////////////////////////////////////iwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////NP//////////////////////////////////////////////////////////////9////5T///8eAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///+A//////////////////////////////////////////////////////////////9TAAAAAAAAAAD///8A////AAD///8AAAAAAAAAAAD///8J////8P/////////////////////////////////////////////////////////v////GQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///+U////////////////////////////////////////////////////8v///4j///8YAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////Ef////D/////////////////////////////////////////////////////////8P///wkAAAAAAAAAAP///wD///8AAP///wAAAAAAAAAAAAAAAAD///+T//////////////////////////////////////////////////////////////+VAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////Bv///+z/////////////////////////////////////////7P///3z///8QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///+I//////////////////////////////////////////////////////////////+TAAAAAAAAAAAAAAAA////AP///wAA////AAAAAAAAAAAAAAAAAP///y3///////////////////////////////////////////////////////////////f///8qAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///9S////////////////////////////////////5P///3D///8MAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////IP////X//////////////////////////////////////////////////////////////y0AAAAAAAAAAAAAAAD///8A////AAD///8AAAAAAAAAAAAAAAAAAAAAAP///7r//////////////////////////////////////////////////////////////70AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///7L/////////////////////////3P///2b///8GAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///+4//////////////////////////////////////////////////////////////+6AAAAAAAAAAAAAAAAAAAAAP///wD///8AAP///wAAAAAAAAAAAAAAAAAAAAAA////Rv///////////////////////////////////////////////////////////////////3AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8W////+///////////////0v///1j///8EAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////Wv///////////////////////////////////////////////////////////////////0UAAAAAAAAAAAAAAAAAAAAA////AP///wAA////AAAAAAAAAAAAAAAAAAAAAAAAAAAA////xP//////////////////////////////////////////////////////////////7v///ykAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///3D/////////yP///07///8BAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///yH////v///////////////////////////////////////////////////////////////DAAAAAAAAAAAAAAAAAAAAAAAAAAD///8A////AAD///8AAAAAAAAAAAAAAAAAAAAAAAAAAAD///8/////////////////////////////////////////////////////////////////////z////w0AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////jP///0EAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8G////yv///////////////////////////////////////////////////////////////////z8AAAAAAAAAAAAAAAAAAAAAAAAAAP///wD///8AAP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///+w////////////////////////////////////////////////////////////////////qAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///5r///////////////////////////////////////////////////////////////////+wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////AP///wAA////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///yT////4////////////////////////////////////////////////////////////////////gwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///9+////////////////////////////////////////////////////////////////////+P///yMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8A////AAD///8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///3z/////////////////////////////////////////////////////////////////////////bgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////Y/////////////////////////////////////////////////////////////////////////98AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wD///8AAP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////Bf///9H////////////////////////////////////////////////////////////////////9////cAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///2n/////////////////////////////////////////////////////////////////////////0P///wUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////AP///wAA////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////LP////j/////////////////////////////////////////////////////////////////////////ggAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///95//////////////////////////////////////////////////////////////////////////j///8sAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8A////AAD///8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////bf//////////////////////////////////////////////////////////////////////////////o////wsAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8H////nf//////////////////////////////////////////////////////////////////////////////awAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wD///8AAP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////pf//////////////////////////////////////////////////////////////////////////////z////y4AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////Hf///8r//////////////////////////////////////////////////////////////////////////////6UAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////AP///wAA////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8L////zv//////////////////////////////////////////////////////////////////////////////8P///2kAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///2D////w///////////////////////////////////////////////////////////////////////////////O////CwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8A////AAD///8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8a////4v///////////////////////////////////////////////////////////////////////////////////77///8vAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///x////+1////////////////////////////////////////////////////////////////////////////////////4v///xoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wD///8AAP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8s////6/////////////////////////////////////////////////////////////////////////////////////f///+N////GQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///xD///+K////+P///////////////////////////////////////////////////////////////////////////////////+v///8sAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////AP///wAA////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8z////8f/////////////////////////////////////////////////////////////////////////////////////////x////jP///xwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///xf///+C////7f/////////////////////////////////////////////////////////////////////////////////////////x////MgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8A////AAD///8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8z////6///////////////////////////////////////////////////////////////////////////////////////////////+P///67///9Q////AgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////Av///0D///+f////+f//////////////////////////////////////////////////////////////////////////////////////////////6////zIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wD///8AAP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8s////4v/////////////////////////////////////////////////////////////////////////////////////////////////////////i////nv///1j///8PAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8M////SP///4/////m/////////////////////////////////////////////////////////////////////////////////////////////////////////+L///8sAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////AP///wAB////AAEBAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8aAAAAtAAAADEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAPoAAADWAAAA0QAAAM8AAADQAAAA4wAAAOQBAQH6AAAAAAAAAAAAAAAAAAAAAP///wcAAAAVAAAAIgAAACQAAAAuAAAAOAAAADQAAAADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADPAAAATAEBAeYAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8AAAAAAAH///8AAQEBAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8LAAAAmgAAAFoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAPgAAAD5AAAA8AAAAA0AAAAGAAAADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAApgAAAGYBAQH1AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wAAAAAAAP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////bf////j/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////+P///2sAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////AP///wAB////AAEBAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////LAAAAKUAAAAuAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAANEAAABcAQEB1AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8AAAAAAAIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABAQHUAAAANAAAAH0AAAD5AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAPkAAAB8AAAANQEBAdQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///yT///+w//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////+w////IgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////AP///wAA////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8/////xP/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////C////PwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8A////AAD///8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////Rv///7r///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////+6////RQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wD///8AAP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///y3///+T////8P////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////D///+T////LAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////AP///wAA////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8J////U////6n////1////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////8////6j///9T////CQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD///8A////AAH///8AAQEBAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wcAAAA7AAAARwAAAD0AAAAzAAAABgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAPkAAADNAAAAwwAAALoAAADEAQEB+gAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wAAAAAAAf///wABAQEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wcAAAApAAAALwAAACcAAAAgAAAAIgAAABMAAAASAAAAEgAAAAAAAAAAAAAAAAAAAAAAAADuAAAA7QAAAO4AAADeAAAA4AAAANgAAADSAAAA1gEBAfoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA////AAAAAAAB////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAQAA///BEBrnRFkWfQAAAABJRU5ErkJggg==',
      'image/png:icon_cancel' : 'data:image/png;base64,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',
      'image/png:icon_error' : 'data:image/png;base64,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',
      'image/png:icon_forward' : 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC0AAAAuCAYAAAC8jpA0AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA09pVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoMTMuMCAyMDEyMDMwNS5tLjQxNSAyMDEyLzAzLzA1OjIxOjAwOjAwKSAgKE1hY2ludG9zaCkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6M0VBNjJEN0E5ODg1MTFFMUJGQzlCNDlBOTIzMzcxRjciIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6M0VBNjJEN0I5ODg1MTFFMUJGQzlCNDlBOTIzMzcxRjciPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDozRUE2MkQ3ODk4ODUxMUUxQkZDOUI0OUE5MjMzNzFGNyIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDozRUE2MkQ3OTk4ODUxMUUxQkZDOUI0OUE5MjMzNzFGNyIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PqmMpHgAAAzwSURBVHjarFkLcFTlFd67u0k2yW6eBEjIk5AKBFAEJoCK4yOMPKcUpTMdxMpIp1NGsHUYBkRKJVqmo61Iy3MUeY8gOAjVEYogKhADJIBAohBiSIAQ8n5s9pHdfud6/u3J7V0B9c6c2bv38f/ff/7z+M65muUuj5KSktD5qFGjNPxYIfRr43OreDwYZpgA3wsowbjBO5kfc1rslp92KNAEmMaK4F+NJWgArwmw3RC/EoDRF3In4K0/A2gCHAmJhjgPHTr07pQpUwbgPAmSLCTpk08+WZufn5+G8wRIHD3P70XyOBrv3m0n/TFAlZBmoyAxkFiS4uLiMr/f33T48OFVS5YsOcqa1QX3Dnd2dl5Zv379kh07dlTgmhvSwdIF8fIOBPCsqcYLCgruStNGU1DadUESIb0gfT0ej8VmsyUWFhYufe+991YMHDhwKK5nkXi9Xkt0dHTO888//3ZRUdFMXOvDuxDHC4/isa0Ap/0U89CEgxnBxrMZpEBSIek+n88CbVoIYGZm5sjVq1e/Onv27Mm4l0PX3G63JRgMOh577LEXtmzZ8pfU1NRMXrRTgqZ5A4GAxSh3Yh6asFvlaA6WGKXlBx98cOC4cePGAJTriSeemKRehsYtkZGRFk3TLGfOnKnKy8vL1gfF/4iICIvdbre0trbWrFu37s8ffPDBSdxqhLSxqZCDBo4dO9bDTMaOHfuDoKU5KNuNZtt1AUzcggULJo0cOXJqSkoKOZ5WV1fX4HK5knsMAoAEnBZAOyAPAk33uru7u06ePPm3F198cTMut7CNk30Hvvjiix6goaCwIU8CjmTNOpVJzJ07d9zEiRP/AID96GE4Hk1scTqdifRrPOg+ATTeo/9kTrin4TySlWMVsT9kEj0WexvAUdJ+odE+K1as+GNubm4hPUg2qgDrDoLDbBI6Tpw40XD//fcnG683NjbWrV279u+ff/55sWkWugPQmknsJc9OGDZsWP9ly5b9NSEhoT9phwCrAXHuu3DhQi3stuGZZ54ZIQfs6Ojwbdq0qfzjjz++vm/fvvHy3tc4oIStLS0tl9kcfCJLBu8GtE04nJMB5y5fvvwfsbGxqV1dXfqW0tHe3t726aefliC0VeCcLkU+/fTTIdDnz5+/unLlyq9g653fzx9Q5uLfu3fvgc2bN3+Gv3WQVrZjjwD+fSoNBn8QtNKync2CHC6hb9++aS+99NKrDocjFVrTTQEDBU+dOvXVW2+9dQhgPTyJblJ0HwvrRDQ4sGvXrotSc3Svubn55qpVq7aVlpZW4lozpAHSRDqQUYOeP3DgQNDMR+xhtBwyi5dffnl+XFxcLmmSNAUleZHN9nz44YdluN8pJiKVWL/77rvT0O6OqqqqVsNWBy5fvvzla6+9tqmpqamN321jLSvQHgk6nH9oJhwiloN9yrPPPjv+ySefXEoJgVYM8SEFbzly5Mh5nqiVJ/cyME0oIiBSuDq38rmPFxs2jX/00UemaRxRKzSBihhKy04E/3ik4jkUW8mGybb27NmzG4DPchJo4JjaySCCIuoEw4gC7WeAHpYuHoMAB+GwpmZhNA9py5TpnHPmzBkfFRWVqhJCeXn5yd27dxcz4HoG3Sa0I9O9BGrcWQlaRYwQYDhoWLOQoDXBK0JZDzF1AgGmAaBp94YNG/ay4zSytPD2BoR5BcMQf03w6qDBbELhDc57W8CSMPUADU6bjfCWp5JHWVnZsZs3b9YzUGXLbtaYhc0qkt938MId4jxaXIviZyMEOdIz4LRp0zT2nbBi1HSIX4wZM2YUnE/jhyj0nGDbbRdO4+N3I8EZHrn33nsXgEcMwCKb6+vrD7/xxhvrampqOkFFba+88socsLkJSNdOjHsJ8XvN66+/ftBQ0ejxGY5v3BmjU/eo7xRoB2LzIOLFBBpptv6bb76p50E9bIdKw3bwkDEwpQ3I4DlIIscRoz19+vR5CgtZjvu9Fy9e/Kd+/frNImfGbpVhYYOGDx++atasWWM4UkWLHYmRBQWfO3hn7Kq6sRpsWt9maCdNbcf169drhPP4lcOodwYNGvQbALIePHhw5fz581cDbBHopic5ObkABCoNnHoikpIf8XnFvHnz/gXWthVmZxsxYsQsAUyCdXGOiAtTklntZsUptJak7AeabjSJBmr7bKdPn94H0GUwISqforGIAdC2va2trQEaHYTzqBs3blR/++23tFPRR48e/RrVjAWRaRhrUYZCXRE5OTnx8KkI0NoATKoL2fOG8L+gXThiCDgedpID0jF69OjHH3300cfpHMlmrKFG1N55551S/FYTC0SEWQfeHH3r1i33tm3b9sMsUigCcaonTVpgQn5SCLSdwOYY4HktGzduPG0WLTDvEGHb3VYBQAG3UtRQ5kFJRXiu7G1YjTsErR9Cqr6IRUfDoaZDSy5evJW3VxcaCz4TFFFHJ2dqHnpHCpd1scpETIsAaKcDDkMPWVDufLl9+/Y9OL1mIFZ62gaZmgmbdbz55ptH1qxZ8x9cO7Vw4cLfZWVlpaalpfUlEDAFpzIpRBEXa7rFsMtRzz333K8IIJx3GfhOFjPCNrbrThUirSaBPgAQTWrV8fHxSYoPGHiEbl+INNPvueee2Q888ABVMV4A9EPDUeDIlitXrlQR14ZD9srIyCBt+lCe5THbKxeOrcBHwLxiMEYfNT9Mq4l3IkJFD0lulHRjwjo4QjrdgF1mYru14P+IbY8YWllZ+T6emTtjxozFDz/88DloKAdZLQmg6uF0pYgiSfn5+Y8gcszBtUpUP8MxfndJSckukb5DuQLhMwe8x6F8irDICl3aqF3Eytj09PQ0xNp8wgmtRSI6XALlrOHk4hYEyYbJK/CsFxVNdlJS0kBaHBZSunPnzndBQZsuXrxYgd3Q8EwGdi0Dl6qOHz/+TyoeBA2ws6PGTZ06dUJMTEw2zU1y6dKlL8F7znMW1ue3iy33MxjvuXPnzgwdOvQpWhklGUSQcdBasQjyVtWLo0oaFch2og4iTYfGhca0rVu3bsT5BkGQPILS2lS3CmYUS70SosLqOHv27Hl+R5lSQA3eLQbrQgSoQXiugmZyyK6gwaEFBQW/KC4ubmJQbpFs3DxGl+ATNqEMzcDuugXLC8psPH369ELM51Q5AuZUhV27Kri2T4W8oCDmHgbhBj/4TDkDook2fvz43yJTJooMFcHK8IoqpJkJVQNLo+DejXxf1YN+3jHandghQ4b0R2LSmaWat6Ki4hiP7RZ8J2Az6SLpbK26uroFBW0BbDqWeIPL5YofMGBACmz4rGjVSvELE/MZTMErOEu3YIZ6HdqrV68MFMQLATSeCmeyZUSwelDVLXDqW7xgxSx9tnDNRbxI4iYbo0EIeO/evRF+s1xIqxdNQmDAyI9N/muin0I7lgjT64f4vAjOlwnOYlEOCGfdcfXq1QqzwtcWplbUM9y1a9faEUn6UidJbRkiQR62MRPMrwJO2m3YKZuh7xdh+C+bP0ngIINnzpy5BA6YBfsNZWBQ2lMgYPvwzC0GrWpRjzIPYwtBdkjtSBBX8/Ly8ql3p2pFxN4MkKGHEE+bcb/JAEhna0VFRWfBWeYhtG1XJZzqVGGsFDjdr+k+xqCYHqpDoe1a1KJvI+rUMegm9hfl/D1Am7bGKGTBviv79+8/lLKVqmawnbHZ2dkPAfyIxMTESOyKGxPHqNYDEs0MAoFC+CBzhwSk9awJEyb8ctKkSS/gfDQ0a0fc1rtVbMcNqBHXgCFWcx3aKIpnVYsGNROgsh1GKbw3CZJH1uTJk38PU0lTHU9sq9715GailzIeQNQii7UgbROPsGAxe/FuMmw3E++mI7nqFJNiMfVSVKIF0Ov79+9fT2GOu043hWm4VRfVCNpi6JRGi6Y5dfl7EycoLCycgbQdan0RaIRCIkV6W1cdoKD6LzJhj2YiRQcV1tRRW1t7Gjb8PnzkOoOtFxEjpOWlS5cGULr9Xy9PJhr5uU2/R44HbWwZPHjwOZjFFJhIMoEgUX1o2gHqRauqmrSpWrpkVrI3B/ANiET/vnDhQilr9ZaJHYfaC2pMM9AWfshrIEehTIZJusAHyu+7775Rubm5Bcic6QSGwBsPCmPGA9ZTg6xbgiq/BEBkW0IloDZhEjpgUOAQZzPj00HRtfQYvvuFsiYm6wDpb4N8hfjdD045EAwuC9pPcjgcLmJqNAA07MFiWqHVRlTp1VVVVeUocGs57rYyyGZ2OJUtJeDAokWLevRDwn0JkMC9hlTvFe0EmsQJEE2QSlE5R4iaTnaUusS77aIB2S4YpEeYhA74br8jGhNHpOFDkaymHYKs201AS27TydIhOq9dBjYXrlt1Rx8/NUNkkdktSnSVogxZUILuFpxENRw9QszABn+OL7amGdOQsu0mH/YDhm/hPgHSL/rRgduBVcd/BRgAa9CGa6b6fLQAAAAASUVORK5CYII=',
      'image/png:icon_full_off' : 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC0AAAAuCAYAAAC8jpA0AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA09pVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoMTMuMCAyMDEyMDMwNS5tLjQxNSAyMDEyLzAzLzA1OjIxOjAwOjAwKSAgKE1hY2ludG9zaCkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6NTJFMEE0MDY5MEQxMTFFMTgyMzdFOUNDMjE2RjI5RTUiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RDQ5MjE3RDI5MEQxMTFFMTgyMzdFOUNDMjE2RjI5RTUiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo1MkUwQTQwNDkwRDExMUUxODIzN0U5Q0MyMTZGMjlFNSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo1MkUwQTQwNTkwRDExMUUxODIzN0U5Q0MyMTZGMjlFNSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1w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',
      'image/png:icon_full_on' : 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC0AAAAuCAYAAAC8jpA0AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA09pVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoMTMuMCAyMDEyMDMwNS5tLjQxNSAyMDEyLzAzLzA1OjIxOjAwOjAwKSAgKE1hY2ludG9zaCkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RDQ5MjE3RDk5MEQxMTFFMTgyMzdFOUNDMjE2RjI5RTUiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RDQ5MjE3REE5MEQxMTFFMTgyMzdFOUNDMjE2RjI5RTUiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpENDkyMTdENzkwRDExMUUxODIzN0U5Q0MyMTZGMjlFNSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpENDkyMTdEODkwRDExMUUxODIzN0U5Q0MyMTZGMjlFNSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PqZYNAIAAAotSURBVHja1Fl9TFTZFX/z3psPGBhkmOGjWBAwWbuwxq4f9Q8gdWskUaub/oFRSMgmtU0wut243U222v/8w6DGaIxJRcGNLa5bk1pQtLCtWU0TAd3trhhQwPoBtHT5EuaTmXk9Z3ru5HAdhsl29499ycnwHvee87vnnnPuOeeaFEUxEalAGpFKhI8BFGYUoW+G8v8/8WRr9E0hWRFZtk4DcKCZyEK/Gk3EwXNEQfrFb0p3d/fXBr527VqTJNvCMMiygwxDGCfpNMEKlAqUgtTS0vJLq9WaXl1dfSwUCvngG5IXyM+ARwSIZBZAQMWjMsA2IVvX9ZRLly7tDwQC0zt37vwdyRWyA7gAE4HFSXYgB1DG+fPn961YsWIXch4aGmqtra09Eg6HX8DrNNAsMRHADWZGygJmY4rzKwCjktJRtqZpjgsXLrxbXFz8UxzU19f3h7q6uhMkF+V7UGkaaRlBp8Mqnc3Nzb8GwDvm5uYUAKq4XK5XKisrC69du3YfNC6DUJkPmNj3hexVZyZgZYpy2my23Kampg+WL19eFQwGlUgkouTk5LwGsp2tra334D1mHhoBjq4WVvnbkpKSn+EkJASNk91ud1F5eXlJe3v7FwCc26IAojOQsgnoDKyNwKK8NNxVoCwEfObMGQRcAWahCIUZhoGyf7BhwwbX5cuXPxW2rXLbGoTH7/dHEDBOQEIGyAgWs76xsfFgenp6IYzNA8pGgUCZwPA9skkrAVQZ6cJfaFwmzcP5ecjv7NmzqKz1ArCQjTgQD5joEHNQVeXh6+DBg3+9ePHiOdBmBDUsiCYry5Yte/306dMfpKWlFcHwfBR67ty592Eb3ye7TCFz05gyLGIncRyMf48Wne9wOIqQX2Fh4Q+RvzALQYgD8Rw4cOAT5i+GHOpS7t69Ow2r9ZeVlZXiVotVC1NxOp3ZYCqv3rx585+HDx/eWVpaWo3CPoRHiqkGadkmTKGmpuYXsN2vr1q1ynXnzp2ZkydPvl1QUPCKrGEkBAwsP4KgcBPmTpAzRiOIibSQSvaFW/Y9oO9v3bq1Yvfu3W+Cc2o8DICHK2CDyszMzCxsbRoKQ9Bbtmz5Cfz7K6BJoBlyGjPtAJqE6+rVq59YLBbFbDbH5qOGUSH8AcBhsPE/tbW13YLXZ0AjQGMCuM4CuI/CCmrGBhO6gKGpvr5+GwjRBUOxdXa7PSoQQdPjoJA0y6KJysKaA+cJkDjf6/W+BBj4hcBkWjs6Orrg9T+k5Rc8zOq0pcE4nm7p7Oz8DIRo+/bt2wIHzTzgGP5wG9ljJxPTJdDi8LLjPHzQHISz8we+h06cOHH19u3bn5FmBegZAo04IwJ0iE6bl04pYNAPGkndv3//hpSUFD3BgWdlHs7Dn+BnlbXKH5/PFzp27NjfwKf64XWcaIIdKgHCGQOtkOpNzOOnyB4zent7nzx9+nQK4qgrAWhVitHyiagmAo3879+//4TkCpoRpyDhiyZQqpRNhWgLfDR4BpzF19DQ8AbEURcPRzKxXCTCMkH+Hk40H/kfOXLkDZTHwAqTCDE+sfRTYUKEYwZyc3Mjx48f/3lRUVGxCHsLkSTAYBRTRKL5yB/OgWKQtxvlkjnMSemwIoOeB37lypXWo0ePHsrKyiqdnZ2NHesJQIttDDFBYXrH755E85E/ygF5r6JclC+DlRMfRbLnVJHIYHwFctPfGRQlNNKCh+IyxudR8nZhiyGKHOgXS4hHHvHLJD5mWpiHHG6ceHzFnNBLOxXLKPV4WiZAfhKuEoBZWoyNFhjTIAX9CeblXNMB+i4OKS+Bs5F8g/h4Sd4L+uXON0/b8UIYFyZykyCBFtWFwuK7EOiRtCKiUpC+K0yrNuIlzFOEXMHLKy1eSQTaYFHExAQF2MHDI06IOVqAlUURKZQqbAe9SfAKSlHDWMimFXaK8bRSk77xolMuesNSyOP8tDjFqyopKyI5sBxCk6qOdZYBijpSkIWZiy5XMJCdfaP85FPsW3lEnvFtPN9J89DjmIbci7Cw7C1ZRxT/VyVe1iR5BRkvgykqbpyW00lRIKSyolRfJOTxNoIq9TXsjNdiIY/vgLGQpuc1UVavXp1VW1v7e6g01iRjZ3v27HlNivOKfMKeOnXqy2R4wZHe09LSUtvV1fUvwhNOFKdj1QbktaGRkZF39u7dexIyr1VJyHJKbSyDQIv+hjMZ54Qy7HOoHd8ZHR0V5dqc7Hv6QrkvToCJyqFDhxrq6up+g4nMIvIymIlopHGu6YyxsbGEDMbHxx9AqGzweJBNFHDcHF1NADpaSQMDS2Nj4x9hAcOLZHlpLJ/QpNgcrcgTzUf+KAflMT6LgjZJ3i46QXZI0IsdDod7EdA2Fhl4JBJObUs0H/mjHDKlFKl8mwdeZb9y1MDJ6evWrVu5a9euaihsLYuAjhfP+buWaD7yr6mpqUZ5lM7aWfOHd63mvfDQFM2BKyoq1lVVVb0FVYUZWwWLOFKi/MD43yG58Hxq1li2bdv2FizAd+vWrRkp2zPEGaBL/TY7OZRz48aNP66srKwPhULm6enpl8p9qNCDqampFt4BkNq/Bjsxo+UbBw3VdxCqews/9icmJpSMjAzzpk2b6gF4uLOz87qUNUbLN6FlC+sTOzdv3lwFgN9GwJOTk7GWmCAIhePNzc3tfX19X7DC1hMnneTFskeMxXlNTU3tyIfzRTkoD7RuRvmIg0Ip7xOqvD+N3u/cvn37m3Cw/AomalNTU1FmvMcGgkavXLnyF/j/6MDAwOcul8sP2lne3d19RupRhKUGkLZmzZq6x48f32hvb+8EgP6HDx8O5+XlZWO3SfAXXShd19WCgoIfAe+J/v7+QX51orEokb5jx47qsrKydwOBgIYmEQfwk9bW1j/DDgzDeDytxh49enQnPz//BWjvNrslENULd0YFxmkw/2M6rn3A3w/znyDwtLS0JVwWAtc0TV26dOl6qM7He3t7Hwjg85rq5eXl1TBwRTzAw8PDA21tbR+DhkaoiP23KEAB8N9ZESoSp4iU7ERg3D8EYCI/yAmAxocAWC4Ad3KZ2D4DPCZVVSd7eno+FQoRoKN3Lvfu3XuUmZnphu0q4ZOfP3/+ALb0IxAgA55kjRUPAxySkhyDpZsBAViMBxlzYGqPs7Oz3ZAyuLlsMKcOyENO8X6eJt2B2HDVbrcbYr0DAz1quOf69esXgcEomYQALFoFXgYgbnNFypEDEuGcEPAPAfABAL4EgGO7WXn27FknKOtDkhXbSZ6UizJHHRwcfOh0OrXZ2dnnN27cuAAMx6iLOUblv7jl8ktFaDjOjZchaTrEkirxt/geANm9OTk5KZCHfNnR0XGRdpMrKP6VHIUYGzlQUPT1WE/im7qSi92skex01jKOsN7LvCs5uakumjBe0ryJNW4SXn4ucu1sxCnvDKnMEu0FG8k2GC5fvKb6nFSNeJO4Zv469+NGnGOfm48/iWvmiOm7eKH/XwEGAJfWKyY6+KB2AAAAAElFTkSuQmCC',
      'image/png:icon_live' : 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAiCAYAAAA+stv/AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA09pVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoMTMuMCAyMDEyMDMwNS5tLjQxNSAyMDEyLzAzLzA1OjIxOjAwOjAwKSAgKE1hY2ludG9zaCkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6QjZGRThBNzg5ODhBMTFFMUJGQzlCNDlBOTIzMzcxRjciIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6QjZGRThBNzk5ODhBMTFFMUJGQzlCNDlBOTIzMzcxRjciPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo4QzdFRDg5RDk4ODkxMUUxQkZDOUI0OUE5MjMzNzFGNyIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo4QzdFRDg5RTk4ODkxMUUxQkZDOUI0OUE5MjMzNzFGNyIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1w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',
      'image/png:icon_pause' : 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC0AAAAuCAYAAAC8jpA0AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA09pVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoMTMuMCAyMDEyMDMwNS5tLjQxNSAyMDEyLzAzLzA1OjIxOjAwOjAwKSAgKE1hY2ludG9zaCkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6Mzk3NUJBNUE5MEQyMTFFMTgyMzdFOUNDMjE2RjI5RTUiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6Mzk3NUJBNUI5MEQyMTFFMTgyMzdFOUNDMjE2RjI5RTUiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpENDkyMTdEQjkwRDExMUUxODIzN0U5Q0MyMTZGMjlFNSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpENDkyMTdEQzkwRDExMUUxODIzN0U5Q0MyMTZGMjlFNSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PppSoW4AAAG5SURBVHja7JlNTsMwEIXd2IUWKgoVLDgEy97/AF1yCBYgoFJj2iZ2mCnPxSDaTcZCoLH05DQ/X54m41TKGxhjTklD0gm2eXZQBf00ItRCW9IGM//uSANwJNmNg+ER6Yx0jnmU3eAYOAHXJE+qMW9xvAJHkr2vAsMuFovFvekx5vP5HTa5woFkSWNhdnR4bFyFWYzR9BwzmO1QKVeA3eSVnnrv+4KneIwNHv2wANunRcF9NhGoxgQsj2oPC7Cdy/p61HVdX3C+yGIpdlrBO7hANZJhC64twK7y96UNIfQF24xXlWK7Ly/H/tU4OCTZavpXTAv03cEhyf77prU9tD3+W3u0bVvMtCRbe1pNq2k1rabVtP6Na3uoaV2I+glBX3na08UqnZKkIAAOGS+WYifTuyRJAJziuHSDUIC9M72PvgS+1q8zOKsqwU6mecdKoBorsBpwBwXYLUNvSZekG2xfk67MRzAz/r5Y808ZpDfAXkhPpAfSI/alSG4izH7lizi+5ajL4gJOpp7NZzBjjyyMlKgyfInrauwLWbUl2RuHgz47uTayMXMnzXbov3RigwOSgX4UZjfvAgwAPjCqmLuo6H0AAAAASUVORK5CYII=',
      'image/png:icon_play' : 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC0AAAAuCAYAAAC8jpA0AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA09pVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoMTMuMCAyMDEyMDMwNS5tLjQxNSAyMDEyLzAzLzA1OjIxOjAwOjAwKSAgKE1hY2ludG9zaCkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6Mzk3NUJBNUU5MEQyMTFFMTgyMzdFOUNDMjE2RjI5RTUiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6Mzk3NUJBNUY5MEQyMTFFMTgyMzdFOUNDMjE2RjI5RTUiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDozOTc1QkE1QzkwRDIxMUUxODIzN0U5Q0MyMTZGMjlFNSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDozOTc1QkE1RDkwRDIxMUUxODIzN0U5Q0MyMTZGMjlFNSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1w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',
      'image/png:icon_playhead' : 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADoAAAA6CAYAAADhu0ooAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA09pVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoMTMuMCAyMDEyMDMwNS5tLjQxNSAyMDEyLzAzLzA1OjIxOjAwOjAwKSAgKE1hY2ludG9zaCkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RDQ5MjE3RDU5MEQxMTFFMTgyMzdFOUNDMjE2RjI5RTUiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RDQ5MjE3RDY5MEQxMTFFMTgyMzdFOUNDMjE2RjI5RTUiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpENDkyMTdEMzkwRDExMUUxODIzN0U5Q0MyMTZGMjlFNSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpENDkyMTdENDkwRDExMUUxODIzN0U5Q0MyMTZGMjlFNSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1w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',
      'image/png:icon_replay' : 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAD0AAAAyCAYAAADvNNM8AAAD8GlDQ1BJQ0MgUHJvZmlsZQAAKJGNVd1v21QUP4lvXKQWP6Cxjg4Vi69VU1u5GxqtxgZJk6XpQhq5zdgqpMl1bhpT1za2021Vn/YCbwz4A4CyBx6QeEIaDMT2su0BtElTQRXVJKQ9dNpAaJP2gqpwrq9Tu13GuJGvfznndz7v0TVAx1ea45hJGWDe8l01n5GPn5iWO1YhCc9BJ/RAp6Z7TrpcLgIuxoVH1sNfIcHeNwfa6/9zdVappwMknkJsVz19HvFpgJSpO64PIN5G+fAp30Hc8TziHS4miFhheJbjLMMzHB8POFPqKGKWi6TXtSriJcT9MzH5bAzzHIK1I08t6hq6zHpRdu2aYdJYuk9Q/881bzZa8Xrx6fLmJo/iu4/VXnfH1BB/rmu5ScQvI77m+BkmfxXxvcZcJY14L0DymZp7pML5yTcW61PvIN6JuGr4halQvmjNlCa4bXJ5zj6qhpxrujeKPYMXEd+q00KR5yNAlWZzrF+Ie+uNsdC/MO4tTOZafhbroyXuR3Df08bLiHsQf+ja6gTPWVimZl7l/oUrjl8OcxDWLbNU5D6JRL2gxkDu16fGuC054OMhclsyXTOOFEL+kmMGs4i5kfNuQ62EnBuam8tzP+Q+tSqhz9SuqpZlvR1EfBiOJTSgYMMM7jpYsAEyqJCHDL4dcFFTAwNMlFDUUpQYiadhDmXteeWAw3HEmA2s15k1RmnP4RHuhBybdBOF7MfnICmSQ2SYjIBM3iRvkcMki9IRcnDTthyLz2Ld2fTzPjTQK+Mdg8y5nkZfFO+se9LQr3/09xZr+5GcaSufeAfAww60mAPx+q8u/bAr8rFCLrx7s+vqEkw8qb+p26n11Aruq6m1iJH6PbWGv1VIY25mkNE8PkaQhxfLIF7DZXx80HD/A3l2jLclYs061xNpWCfoB6WHJTjbH0mV35Q/lRXlC+W8cndbl9t2SfhU+Fb4UfhO+F74GWThknBZ+Em4InwjXIyd1ePnY/Psg3pb1TJNu15TMKWMtFt6ScpKL0ivSMXIn9QtDUlj0h7U7N48t3i8eC0GnMC91dX2sTivgloDTgUVeEGHLTizbf5Da9JLhkhh29QOs1luMcScmBXTIIt7xRFxSBxnuJWfuAd1I7jntkyd/pgKaIwVr3MgmDo2q8x6IdB5QH162mcX7ajtnHGN2bov71OU1+U0fqqoXLD0wX5ZM005UHmySz3qLtDqILDvIL+iH6jB9y2x83ok898GOPQX3lk3Itl0A+BrD6D7tUjWh3fis58BXDigN9yF8M5PJH4B8Gr79/F/XRm8m241mw/wvur4BGDj42bzn+Vmc+NL9L8GcMn8F1kAcXjEKMJAAAAACXBIWXMAAAsTAAALEwEAmpwYAAABZGlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNC40LjAiPgogICA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPgogICAgICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgICAgICAgICB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iPgogICAgICAgICA8eG1wOkNyZWF0b3JUb29sPkFkb2JlIEltYWdlUmVhZHk8L3htcDpDcmVhdG9yVG9vbD4KICAgICAgPC9yZGY6RGVzY3JpcHRpb24+CiAgIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+Chvleg4AAAfRSURBVGiB7VptbFPnFX7e6+vvfDrJmq8uGCKIkjg0I0sNJJSGAKKsoVSDoWXSiqrux9pOq9ZJE1v/TG2jjqwNVKxStyptJ7qJUaBMhbAkJMSwkFCWbqb5bOt8SDQxiZP489rX97778d6bZGidNPUmRXKOdGT72n59nvucc95zzmtCKUWiCfd1G/B1yCroRJFV0Ikiq6ATRVZBJ4rwK/EjhBACgADQLVEKQFauxwFIAChdgRJxRUCDAdMDMAIwAEBeXp7NYDCYPB7PuPI+pZTGV8KYZQdNCOHAAJsAJAPQr127Nu/06dM/CYVC3urq6gbVDkIIpZRKy23Tssa0ApgHA5wKIHnDhg2O5ubmF+12+4GhoSEDgCzlPQsAIyGEJ4RwSkgsiywb04rROjCXTgJgLi0tLWtqanq+rKysIhwO0y++uG0GA8wpygOIAIgBEAkhMqVU1tw2rfOGAlYFYQRgBWBxOp2VDQ0Nv3I4iksFIQpKZep2fzLS3t5+s79/4GZbW1uXKIp+AAKAEBh4ESzJaZrgNAWtuLPKmAGAGYCxurq6/OWXX3qpsLCwRBAikCkFRwgI4aDX62W/fz4wMDA4dvbsubfPnDnTEQqFggCCYOAFAJKWjGvm3ku2JQMYw0aDwZCu0+lS+vv7g729vSPZ92VvIITwsiwjTimdmZmZkySJ5uTk2JwPOsscpY6G7du2tb5y9Oix4eHhUWVpCiBKCIFmwCmlmigW3dkGIC8jI6OoqanpPc/nn3mqqqp+ZjQadz/97NPvuv/1z/Dw0AD95JZbOnLkF+dNJtOP6uvrXzt//oOBUY+Hjo2N0vdPn7paVFS0C0ABWKKzAOC0slXL7K2ybDGZTMa6urr6urpH93E63Zpnnn2mJjU11Xzi9RPNjb999S0hGg3GJYkzmUwBQRBunzx58uITTxx+4W+tl1olSZI3VXx761NPPfnj1NTULLAQMQDgNcvoGrFMwFjOAnB/WVnJIZfrymcjI4O0peXDYYfD8X0A5QAqAZQdPHjwBbe7b/r48WNvKdcrAFSkpKTsaWw82jI8PEhHRgaDe/fuOQLGdg40ZFurmF6ouJKTky1bt1btys/PWzs7Ozvf2Pjam263+2OwTBwDQE6dOvWHYDA4sXnzg3oAU2Bbm9nv90eOHTv+zsaNpevsdnvhzp21227cuNnp9XonlPVjYKXrVxKt3FvN2CQrK2tdTc2OknA4jI6OK9f7+vr6wOrqEIB5ALMAohcuXPjziRNvnAPL0nOKijMzM0PNze+0RaMxOJ3OyoKCglJlfb1W9mrF9AJom81mz83NKRaEKC5ebPk4EAhMgrEcBtt71SaDm5ycnFOeq2IMh8PcrVv9A1NT3pmsrMwMvV6Xi8VmRZOY1jKRcWAxZ5RlyRwOBqTA/Px8LBaTwECrGseiq0tLrqlKKaWBWd/MHGGebMJisXNPMb0glFIaEwQsbGJsn/1vFRC967n6mkqSBFGMQxBEyLI27C4VLUFTAJTG41I0JsZ5XsfH4nEezCV5/GcfDbBbIi/5Lq9+jhBi4TguSRAi7A6wz33Zzfu/RSv3plBcUxBF7/S0d0zHEV1+du46i8VixZIqTVG98j0LmPuqagTApaen5ScnWe+b9k6FhJhwW1lfwj0GWlKU3rlz+9Puv/f0h4JhfPfg/oczMzPV7JukqNVut693OBy1YOBTwPpsKwDOZrPl12x/qEoU4xgeGXH7fDPDYEyrOeAri5ZMiwDE6en5yZ6e3u5INBI2my3f3P5Q9X6TyZQD1kJmAsisqtpS+fxzP/3dpk3lB8DAfgNAssViSaqpefjRkpLiLbFYVOrsvOq6c8f3KRjYODTYowGNQCttXxysIyKj4+NdLtfVy5FQCLU7djyy/7G6H5pMpkwAGQByx8fH08ORUMGThw+/6HQ66wFYrVZr9u6dOw89smfXD0QxxnVfv37tem/vWUEQ4gCiyvqauLeWiUwCM87g8/kmP7xw6feZtvSCvPw8R/XWLYfS0lLXtFxqe9/j8Uz5/f70SCQSNxoNGd878Phzer3O1t3dc25iYmKeJ8Tq9U6NXmxpfdXn840p66rtpSagNeunl0xKzFBit9BuL973+GO/tK+5v5JSwO8PBDyfjw6GIpFQ+QNl23Qcx+l4HWIxMdRyqfXdri7Xe+vXr1uTlJQUdbv7uyORiFrURAHEtWotl2OIoM7ErACSU1JSbLW12w9/q/yBA2aLJV3HcRBFEbK8aL+O5yHFRd+5s3/9dXfPjQ/AXDkMZWwEQNRyiKA1aHWQwINtPxYw1o2FhfbS4uLi3VmZWc7MDFt2SkqyDQA4jgMIkXq6b/ypraPjlWAwOA8gAObSahzL9+y4CFgADiyOjJaCTwaQVl6+sWbfd/b+nNfzOgDSFde1P3Z2dr0uiuIcWEMShsIuUebCWtq4LGUoABBC1C1GrbNF5TXheX5akmUdJCnefrnzDZfr2ttg3ZYfd8Xvcpx4LNsIWDFWIoTIWKymKIBYWlrqPOFosP1y529crmt/AXNjPxbjWPOx71LR3L2/9IcIUePcuLmiolBvMRV99NE/2sLhMMDYjQCIrcTRzoqAvusAT5+enq6fnZ0VwcpQtb2UVuosayWZVg8Blj6qJ5eaZ+j/acvqn+cSRFZBJ4qsgk4UWQWdKJKQoP8NrFFCcKSAWlsAAAAASUVORK5CYII=',
      'image/png:icon_rewind' : 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC0AAAAuCAYAAAC8jpA0AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA09pVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoMTMuMCAyMDEyMDMwNS5tLjQxNSAyMDEyLzAzLzA1OjIxOjAwOjAwKSAgKE1hY2ludG9zaCkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6MEZFODFFMDM5ODdFMTFFMUJGQzlCNDlBOTIzMzcxRjciIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6MEZFODFFMDQ5ODdFMTFFMUJGQzlCNDlBOTIzMzcxRjciPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDowRkU4MUUwMTk4N0UxMUUxQkZDOUI0OUE5MjMzNzFGNyIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDowRkU4MUUwMjk4N0UxMUUxQkZDOUI0OUE5MjMzNzFGNyIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1w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',
      'image/png:icon_spinner' : 'data:image/png;base64,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',
      'image/gif:oo_spinner' : 'data:image/gif;base64,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',
      __end_marker:1 };
  }(OO));  (function(OO) { 
    OO.stylus_css = {
      'adobe_pass.styl' : "#ooyalaMvpdPickerContainer{position:absolute;height:100%;width:100%;top:0;left:0;background:rgba(0,0,0,0.50);}#ooyalaMvpdPickerContainer .innerDiv{width:360px;height:420px;border:1px solid rgba(0,0,0,0.50);text-align:left;position:absolute;top:50%;left:50%;margin:-210px 0 0 -180px;background:#fff;color:#000;outline:none;transition:all .5s ease-in-out;border:0;-webkit-border-radius:15px;-moz-border-radius:15px;-ms-border-radius:15px;-o-border-radius:15px;border-radius:15px;-webkit-box-shadow:0 0 5px #c8c8c8;-moz-box-shadow:0 0 5px #c8c8c8;-ms-box-shadow:0 0 5px #c8c8c8;-o-box-shadow:0 0 5px #c8c8c8;box-shadow:0 0 5px #c8c8c8}#ooyalaMvpdPickerContainer .cancelDiv{margin:10px 10px 20px 10px;width:16px;height:16px;background-image:url('<%= cancelIcon %>');background-size:100%;background-origin:content;cursor:pointer}#ooyalaMvpdPickerContainer .titleBar{align:center;font-size:24 p;font-weight:bold;text-align:center;margin:20px}#ooyalaMvpdPickerContainer .providerList{width:85%;height:280px;padding:0 1em;overflow:auto;overflow-x:hidden;-ms-overflow-x:hidden}#ooyalaMvpdPickerContainer ul{list-style-type:none}#ooyalaMvpdPickerContainer li{width:280px;height:audo;margin:15px;cursor:pointer}#ooyalaMvpdPickerContainer li img{vertical-align:middle;width:120px}#ooyalaMvpdPickerContainer li:hover{background-color:#9a9aef;color:#fff}",
      'basic_ui.styl' : "#<%= elementId %> .oo_promo{position:absolute;width:100%;height:100%;cursor:pointer;background:#1a1a1a;background-position:center center;-webkit-background-size:contain;-moz-background-size:contain;-ms-background-size:contain;-o-background-size:contain;background-size:contain;background-repeat:no-repeat;z-index:10001;}#<%= elementId %> .oo_promo div.oo_start_button{width:60px;height:60px;position:absolute;bottom:24px;left:24px;opacity:.8;filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=80);background:#000;border:0;-webkit-border-radius:6px;-moz-border-radius:6px;-ms-border-radius:6px;-o-border-radius:6px;border-radius:6px;background-position:center;-webkit-background-size:54% auto;-moz-background-size:54% auto;-ms-background-size:54% auto;-o-background-size:54% auto;background-size:54% auto;background-origin:content;background-repeat:no-repeat}#<%= elementId %> .plugins{position:absolute;width:100%;height:100%;z-index:10003}#<%= elementId %> .plugins.video{width:100%;height:100%}#<%= elementId %> .oo_start_spinner{width:50px;height:50px;margin:5px;-webkit-animation:spin 3.6s infinite linear;-moz-animation:spin 3.6s infinite linear;-ms-animation:spin 3.6s infinite linear;-o-animation:spin 3.6s infinite linear;animation:spin 3.6s infinite linear}#<%= elementId %> .oo_spinner{position:absolute}#<%= elementId %> .oo_tap_panel{position:absolute;z-index:10004;opacity:0;filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=0);height:100%;width:100%}#<%= elementId %> .oo_mini_controls{height:40px;left:15px;right:15px;}#<%= elementId %> .oo_mini_controls .oo_scrubber{left:-5px;right:-5px;top:4px;bottom:24px}#<%= elementId %> .oo_mini_controls .oo_scrubber_track{left:45px;right:45px}#<%= elementId %> .oo_mini_controls .oo_toolbar_item{width:16px;height:16px;top:22px}#<%= elementId %> .oo_mini_controls .oo_glow{display:none;position:absolute;left:50%;top:50%;width:0;height:0;-webkit-box-shadow:0 0 30px 13.333333333333334px #fff;-moz-box-shadow:0 0 30px 13.333333333333334px #fff;-ms-box-shadow:0 0 30px 13.333333333333334px #fff;-o-box-shadow:0 0 30px 13.333333333333334px #fff;box-shadow:0 0 30px 13.333333333333334px #fff}#<%= elementId %> .oo_mini_controls .oo_currentTime,#<%= elementId %> .oo_mini_controls .oo_timeToLive{position:absolute;left:2px;text-align:center}#<%= elementId %> .oo_mini_controls .oo_duration{right:2px;position:absolute;text-align:right}#<%= elementId %> .oo_mini_controls .oo_duration,#<%= elementId %> .oo_mini_controls .oo_currentTime,#<%= elementId %> .oo_mini_controls .oo_timeToLive{top:1px;font-size:10px;width:40px}#<%= elementId %> .oo_mini_controls .oo_playhead{height:8px;width:8px;margin:-8px;padding:8px;top:-1px}#<%= elementId %> .oo_full_controls{height:40px;left:15px;right:15px;}#<%= elementId %> .oo_full_controls .vod .oo_scrubber{left:85px;right:45px;top:9px;bottom:10px}#<%= elementId %> .oo_full_controls .live .oo_scrubber{left:165px;right:45px;top:10px;bottom:10px}#<%= elementId %> .oo_full_controls .vod .oo_scrubber_track{left:45px;right:45px}#<%= elementId %> .oo_full_controls .live .oo_scrubber_track{left:5px;right:5px}#<%= elementId %> .oo_full_controls .oo_currentTime,#<%= elementId %> .oo_full_controls .oo_timeToLive{left:5px;text-align:left;position:absolute}#<%= elementId %> .oo_full_controls .oo_duration{right:5px;text-align:right;position:absolute}#<%= elementId %> .oo_full_controls .oo_toolbar_item{width:40px;height:24px;top:8px}#<%= elementId %> .oo_full_controls .oo_button_highlight{display:none;position:absolute;left:50%;top:50%;width:0;height:0;-webkit-box-shadow:0 0 30px 13.333333333333334px #fff;-moz-box-shadow:0 0 30px 13.333333333333334px #fff;-ms-box-shadow:0 0 30px 13.333333333333334px #fff;-o-box-shadow:0 0 30px 13.333333333333334px #fff;box-shadow:0 0 30px 13.333333333333334px #fff}#<%= elementId %> .oo_full_controls .oo_duration,#<%= elementId %> .oo_full_controls .oo_currentTime{top:5px;font-size:12px;width:40px}#<%= elementId %> .oo_full_controls .oo_playhead{height:24px;width:24px;margin:-4px;padding:4px;top:-4px}#<%= elementId %> .oo_controls{position:absolute;padding:0;background:rgba(0,0,0,0.65);-webkit-border-radius:6px;-moz-border-radius:6px;-ms-border-radius:6px;-o-border-radius:6px;border-radius:6px;z-index:10004;-webkit-transition:.5s all ease;-moz-transition:.5s all ease;-ms-transition:.5s all ease;-o-transition:.5s all ease;transition:.5s all ease;}#<%= elementId %> .oo_controls .live{display:none}#<%= elementId %> .oo_controls .oo_controls_inner{position:absolute;top:0;bottom:0;left:10px;right:10px}#<%= elementId %> .oo_controls .oo_label{font-family:sans-serif;line-height:10px;color:#fff;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;-o-user-select:none;user-select:none;cursor:default;text-align:center}#<%= elementId %> .oo_controls .oo_scrubber{position:absolute;background:#000;-webkit-border-radius:12px;-moz-border-radius:12px;-ms-border-radius:12px;-o-border-radius:12px;border-radius:12px}#<%= elementId %> .oo_controls .oo_playhead{background-image:url('<%= playheadIcon %>');background-position:border;-webkit-background-size:100% auto;-moz-background-size:100% auto;-ms-background-size:100% auto;-o-background-size:100% auto;background-size:100% auto;background-origin:content;background-repeat:no-repeat;position:absolute}#<%= elementId %> .oo_controls .oo_scrubber_track{top:4px;bottom:4px;-webkit-border-radius:12px;-moz-border-radius:12px;-ms-border-radius:12px;-o-border-radius:12px;border-radius:12px;position:absolute}#<%= elementId %> .oo_controls .vod .oo_scrubber_track{left:45px}#<%= elementId %> .oo_controls .live .oo_scrubber_track{left:5px}#<%= elementId %> .oo_controls .oo_progress{height:100%;-webkit-border-radius:12px;-moz-border-radius:12px;-ms-border-radius:12px;-o-border-radius:12px;border-radius:12px;position:absolute}#<%= elementId %> .oo_controls .oo_buffer_progress{width:0}#<%= elementId %> .oo_controls .oo_playhead_progress{width:16px}#<%= elementId %> .oo_controls .oo_button{background-position:center;-webkit-background-size:contain;-moz-background-size:contain;-ms-background-size:contain;-o-background-size:contain;background-size:contain;background-repeat:no-repeat}#<%= elementId %> .oo_controls .oo_rewind{background-image:url('<%= rewindIcon %>');position:absolute;left:0}#<%= elementId %> .oo_controls .oo_play{background-image:url('<%= playIcon %>');position:absolute;left:40px}#<%= elementId %> .oo_controls .oo_pause{background-image:url('<%= pauseIcon %>');position:absolute;left:40px}#<%= elementId %> .oo_controls .oo_fullscreen{position:absolute;right:0}#<%= elementId %> .oo_controls .oo_fullscreen_on{background-image:url('<%= fullscreenOnIcon %>')}#<%= elementId %> .oo_controls .oo_fullscreen_off{background-image:url('<%= fullscreenOffIcon %>')}#<%= elementId %> .oo_controls .oo_live_indicator{background-image:url('<%= liveIcon %>');position:absolute;left:80px}#<%= elementId %> .oo_controls .oo_live_message{color:#fff;line-height:1.6em;font-size:16px;position:absolute;left:120px}#<%= elementId %> .oo_controls .oo_timer{color:#fff;font-size:13px;padding:7px}#<%= elementId %> .oo_ads_countdown{position:absolute;padding:2px 5px;opacity:.6;filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=60);width:100%;height:25px;color:#fff;background-color:#000;display:none;overflow:hidden;z-index:10005;font-size:16px;font-weight:bold}#<%= elementId %> .oo_end_screen{position:absolute;width:100%;height:100%;background:#1a1a1a;background-position:center center;-webkit-background-size:contain;-moz-background-size:contain;-ms-background-size:contain;-o-background-size:contain;background-size:contain;background-repeat:no-repeat;display:none;left:0;top:0;overflow:hidden;text-align:center;z-index:10005;}#<%= elementId %> .oo_end_screen .oo_fullscreen{width:28px;height:28px;position:absolute;display:none;top:15px;left:81px;padding:11px 16px;opacity:.65;filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=65);background:#000;border:0;-webkit-border-radius:6px;-moz-border-radius:6px;-ms-border-radius:6px;-o-border-radius:6px;border-radius:6px;background-position:center;-webkit-background-size:auto;-moz-background-size:auto;-ms-background-size:auto;-o-background-size:auto;background-size:auto;background-origin:content;background-repeat:no-repeat}#<%= elementId %> .oo_replay{width:61px;height:50px;position:absolute;top:15px;left:15px;opacity:.65;filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=65);background:#000;border:0;-webkit-border-radius:6px;-moz-border-radius:6px;-ms-border-radius:6px;-o-border-radius:6px;border-radius:6px;background-position:center;-webkit-background-size:auto;-moz-background-size:auto;-ms-background-size:auto;-o-background-size:auto;background-size:auto;background-origin:content;background-repeat:no-repeat}#<%= elementId %> .oo_spinner{top:0;z-index:10006}@-moz-keyframes spin{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-webkit-keyframes spin{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-o-keyframes spin{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-ms-keyframes spin{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes spin{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}",
      'cast_receiver.styl' : "#splash_screen{width:100%;height:100%;background-color:#000}#splash_image{display:block;width:50%;margin-left:auto;margin-right:auto}#error_screen{width:100%;height:100%;background-color:#000;display:none}#error_container{overflow:hidden;width:50%;height:50%}#loading_screen{background-color:#000;overflow:hidden;width:100%;height:100%;display:none}#loading_container{overflow:hidden;width:80%;height:70%;margin:auto}#logo_image{width:20%}#logo_wrap{margin-top:5%}#information_container{margin-top:5%}#promo_wrapper{float:left;background-color:#000;width:40%;height:100%}#promo_image{width:100%}.divider{float:left;background-color:#000;width:10%;height:100%}#information{float:left;background-color:#000;width:50%;height:100%}#loading_title{font-family:Proxima Nova;font-weight:bold;text-transform:Uppercase}#loading_description{font-family:Proxima Nova;opacity:.6;font-weight:normal}@-webkit-keyframes loading{0%{margin-left:-15%}100%{margin-left:100%}}.loading_bar{width:15%;height:100%;-webkit-animation:loading 2s infinite ease-in-out;background-color:#746ee5}.loading_bar_wrapper{position:absolute;bottom:10%;height:1%;right:5%;left:5%;overflow:hidden;background-color:#fff}.oo_controls{position:relative;overflow:hidden;height:100%;width:100%}#scrubber_wrapper{position:absolute;height:3.5%;width:100%;z-index:10001;bottom:10%}#play_pause_wrapper{float:left;margin-left:2.5%;height:100%}#pause_icon{height:100%}#play_icon{position:absolute;margin-left:2.5%;top:0;left:0;height:100%}#playhead_container{float:left;height:50%;margin-left:2.5%;width:5%;text-align:left;margin-top:.6%}#playhead{display:inline;color:#fff;line-height:50%;opacity:1;margin:auto}#seek_bar{float:left;height:28%;width:80%;background-color:#fff;margin-top:.6%}#progress{width:0%;height:100%;background-color:#746ee5}#buffered_progress{display:inline;width:0%;height:100%;background:#746ee5;opacity:.3}#duration_wrapper{float:left;height:50%;margin-left:2.5%;text-align:right;margin-top:.6%}#duration{display:inline;color:#fff;line-height:50%;opacity:1;margin:auto}#title_wrapper{float:left}#promo_title_container{position:absolute;z-index:10001;bottom:15%;left:2.5%;width:50%;margin:auto}#watermark_wrapper{position:absolute;z-index:10001;bottom:15%;right:2.5%;width:4%;opacity:.8;margin:auto}#watermark_icon{width:100%;float:right}#spinner_icon{position:absolute;z-index:10001;width:10%;display:none}.spinner{margin:10% auto;border-bottom:6px solid #fff;border-left:6px solid #fff;border-right:6px solid transparent;border-top:6px solid transparent;border-radius:100%;-webkit-animation:spin .6s infinite linear}@-webkit-keyframes spin{0%{-webkit-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(359deg);transform:rotate(359deg)}}#promo_icon{width:12%;float:left;margin-right:5%}#title_header{font-family:Proxima Nova;font-weight:bold;text-transform:uppercase;position:absolute;bottom:0;margin:0}.cast_text{color:#fff;font-family:Proxima Nova}.absolute_center{margin:auto;position:absolute;top:0;left:0;bottom:0;right:0}",
      'discovery_toaster.styl' : "#<%= elementId %> .discovery_toaster{transition:.5s all ease;-moz-transition:.5s all ease;-webkit-transition:.5s all ease;-o-transition:.5s all ease;position:absolute;height:40%;bottom:60px;opacity:0;left:15px;right:15px;border:0;-webkit-border-radius:6px;-moz-border-radius:6px;-ms-border-radius:6px;-o-border-radius:6px;border-radius:6px;z-index:10008;background:rgba(0,0,0,0.65);}#<%= elementId %> .discovery_toaster .discovery_copy{font-family:sans-serif;font-weight:normal;color:#fff;position:absolute;top:13px;margin-left:35px}#<%= elementId %> .discovery_toaster .discovery_image_holder{width:45px;position:absolute;left:0;top:12px}#<%= elementId %> .discovery_toaster .discovery_image{background-position:center center;background-size:contain;background-repeat:no-repeat;background-image:url('<%= discoveryIcon %>');position:absolute;left:12px;top:0;width:20px;height:20px}#<%= elementId %> .discovery_toaster .discovery_outer{left:12px;right:12px;position:absolute;bottom:0;}#<%= elementId %> .discovery_toaster .discovery_outer .discovery_left_scroll{position:absolute;width:10%;height:100%;left:0;top:0;z-index:10009}#<%= elementId %> .discovery_toaster .discovery_outer .discovery_left_gradient{transition:.5s all ease;-moz-transition:.5s all ease;-webkit-transition:.5s all ease;-o-transition:.5s all ease;position:absolute;width:10%;height:100%;left:0;top:0;z-index:10008;background-image:-ms-linear-gradient(left,rgba(0,0,0,0.90) 0%,rgba(0,0,0,0.00) 100%);background-image:-moz-linear-gradient(left,rgba(0,0,0,0.90) 0%,rgba(0,0,0,0.00) 100%);background-image:-o-linear-gradient(left,rgba(0,0,0,0.90) 0%,rgba(0,0,0,0.00) 100%);background-image:-webkit-gradient(linear,left center,right center,color-stop(0,rgba(0,0,0,0.90)),color-stop(1,rgba(0,0,0,0.00)));background-image:-webkit-linear-gradient(left,rgba(0,0,0,0.90) 0%,rgba(0,0,0,0.00) 100%);background-image:linear-gradient(to right,rgba(0,0,0,0.90) 0%,rgba(0,0,0,0.00) 100%)}#<%= elementId %> .discovery_toaster .discovery_outer .discovery_right_gradient{transition:.5s all ease;-moz-transition:.5s all ease;-webkit-transition:.5s all ease;-o-transition:.5s all ease;position:absolute;width:10%;height:100%;right:0;top:0;z-index:10008;background-image:-ms-linear-gradient(right,rgba(0,0,0,0.90) 0%,rgba(0,0,0,0.00) 100%);background-image:-moz-linear-gradient(right,rgba(0,0,0,0.90) 0%,rgba(0,0,0,0.00) 100%);background-image:-o-linear-gradient(right,rgba(0,0,0,0.90) 0%,rgba(0,0,0,0.00) 100%);background-image:-webkit-gradient(linear,right center,left center,color-stop(0,rgba(0,0,0,0.90)),color-stop(1,rgba(0,0,0,0.00)));background-image:-webkit-linear-gradient(right,rgba(0,0,0,0.90) 0%,rgba(0,0,0,0.00) 100%);background-image:linear-gradient(to left,rgba(0,0,0,0.90) 0%,rgba(0,0,0,0.00) 100%)}#<%= elementId %> .discovery_toaster .discovery_outer .discovery_right_scroll{position:absolute;width:10%;height:100%;right:0;top:0;z-index:10009}#<%= elementId %> .discovery_toaster .discovery_outer .discovery_holder{overflow:hidden;width:100%;height:100%;}#<%= elementId %> .discovery_toaster .discovery_outer .discovery_holder .discovery_slider{-webkit-transform:translateX(0);-webkit-backface-visibility:hidden;-moz-transform:translateX(0);-ms-transform:translateX(0);transform:translateX(0);height:100%;}#<%= elementId %> .discovery_toaster .discovery_outer .discovery_holder .discovery_slider .discovery_video{float:left;height:100%;}#<%= elementId %> .discovery_toaster .discovery_outer .discovery_holder .discovery_slider .discovery_video .discovery_video_image{background:rgba(0,0,0,0.90);background-position:center;background-size:contain;background-repeat:no-repeat;top:10%;width:90%;height:80%;position:relative;}#<%= elementId %> .discovery_toaster .discovery_outer .discovery_holder .discovery_slider .discovery_video .discovery_video_image .discovery_video_name{font-family:sans-serif;background:rgba(0,0,0,0.65);font-weight:normal;color:#fff;position:absolute;bottom:0;left:0;right:0;text-wrap:unrestricted;padding:5px}#<%= elementId %> .discovery-countdown-container{width:38px;height:38px;position:absolute;-webkit-border-radius:25px;-moz-border-radius:25px;-ms-border-radius:25px;-o-border-radius:25px;border-radius:25px;border:6px solid;top:5px;right:5px;border-color:#000;overflow:hidden}#<%= elementId %> .discovery-countdown{-webkit-mask-box-image:-webkit-radial-gradient(center,ellipse cover,#000 66%,rgba(0,0,0,0.00) 69.5%);background:#eee;width:40px;height:40px;position:absolute;top:-1px;right:-1px}#<%= elementId %> .discovery_video_name{overflow:hidden}#<%= elementId %> .countdown-play{background-image:url('<%= playIcon %>');background-position:center;background-size:contain;background-repeat:no-repeat;width:20px;height:20px;position:absolute;top:10px;right:10px;z-index:10013}#<%= elementId %> .countdown-inner{position:absolute;top:0;left:0;background:transparent;border-width:20px;width:0;height:0;border-style:solid;border-color:transparent;border-top-color:#5c5c5c;-webkit-transform:rotate(-45deg);transform:rotate(-45deg);-webkit-animation:webkit-inner 15s linear 1;animation:inner 15s linear 1}#<%= elementId %> .countdown-mask{position:absolute;top:0;left:0;background:transparent;border-width:20px;width:0;height:0;border-style:solid;border-color:transparent;border-top-color:#eee;-webkit-transform:rotate(-45deg);transform:rotate(-45deg);-webkit-animation:webkit-mask 15s linear 1;animation:mask 15s linear 1}#<%= elementId %> .countdown-mask:after,#<%= elementId %> .countdown-mask-two{display:block;content:'';opacity:1;position:absolute;top:0;left:0;background:transparent;border-width:20px;width:0;height:0;border-style:solid;border-color:transparent;border-top-color:rgba(92,92,92,0.00);-webkit-transform:rotate(45deg);transform:rotate(45deg);-webkit-animation:webkit-masktwo 15s linear 1;animation:masktwo 15s linear 1}@-webkit-keyframes webkit-inner{0%{-webkit-transform:rotate(-45deg)}25%{border-left-color:transparent}26%{border-left-color:#5c5c5c}50%{border-bottom-color:transparent}51%{border-bottom-color:#5c5c5c}75%{border-right-color:transparent}76%{border-right-color:#5c5c5c}100%{-webkit-transform:rotate(315deg);border-left-color:#5c5c5c;border-bottom-color:#5c5c5c;border-right-color:#5c5c5c}}@-webkit-keyframes webkit-mask{0%{-webkit-transform:rotate(-45deg)}75%{-webkit-transform:rotate(-45deg)}100%{-webkit-transform:rotate(45deg)}}@-webkit-keyframes webkit-masktwo{0%{border-top-color:rgba(92,92,92,0.00)}25%{border-top-color:rgba(92,92,92,0.00)}26%{border-top-color:#5c5c5c}100%{border-top-color:#5c5c5c}}@-webkit-keyframes whee{0%{-webkit-transform:rotate(0);-webkit-filter:sepia() hue-rotate(0) contrast(95%)}100%{-webkit-transform:rotate(360deg);-webkit-filter:sepia() hue-rotate(360deg) contrast(95%)}}@-moz-keyframes masktwo{0%{border-top-color:rgba(92,92,92,0.00)}25%{border-top-color:rgba(92,92,92,0.00)}26%{border-top-color:#5c5c5c}100%{border-top-color:#5c5c5c}}@-webkit-keyframes masktwo{0%{border-top-color:rgba(92,92,92,0.00)}25%{border-top-color:rgba(92,92,92,0.00)}26%{border-top-color:#5c5c5c}100%{border-top-color:#5c5c5c}}@-o-keyframes masktwo{0%{border-top-color:rgba(92,92,92,0.00)}25%{border-top-color:rgba(92,92,92,0.00)}26%{border-top-color:#5c5c5c}100%{border-top-color:#5c5c5c}}@-ms-keyframes masktwo{0%{border-top-color:rgba(92,92,92,0.00)}25%{border-top-color:rgba(92,92,92,0.00)}26%{border-top-color:#5c5c5c}100%{border-top-color:#5c5c5c}}@keyframes masktwo{0%{border-top-color:rgba(92,92,92,0.00)}25%{border-top-color:rgba(92,92,92,0.00)}26%{border-top-color:#5c5c5c}100%{border-top-color:#5c5c5c}}@-moz-keyframes inner{0%{transform:rotate(-45deg)}25%{border-left-color:transparent}26%{border-left-color:#5c5c5c}50%{border-bottom-color:transparent}51%{border-bottom-color:#5c5c5c}75%{border-right-color:transparent}76%{border-right-color:#5c5c5c}100%{transform:rotate(315deg);border-left-color:#5c5c5c;border-bottom-color:#5c5c5c;border-right-color:#5c5c5c}}@-webkit-keyframes inner{0%{transform:rotate(-45deg)}25%{border-left-color:transparent}26%{border-left-color:#5c5c5c}50%{border-bottom-color:transparent}51%{border-bottom-color:#5c5c5c}75%{border-right-color:transparent}76%{border-right-color:#5c5c5c}100%{transform:rotate(315deg);border-left-color:#5c5c5c;border-bottom-color:#5c5c5c;border-right-color:#5c5c5c}}@-o-keyframes inner{0%{transform:rotate(-45deg)}25%{border-left-color:transparent}26%{border-left-color:#5c5c5c}50%{border-bottom-color:transparent}51%{border-bottom-color:#5c5c5c}75%{border-right-color:transparent}76%{border-right-color:#5c5c5c}100%{transform:rotate(315deg);border-left-color:#5c5c5c;border-bottom-color:#5c5c5c;border-right-color:#5c5c5c}}@-ms-keyframes inner{0%{transform:rotate(-45deg)}25%{border-left-color:transparent}26%{border-left-color:#5c5c5c}50%{border-bottom-color:transparent}51%{border-bottom-color:#5c5c5c}75%{border-right-color:transparent}76%{border-right-color:#5c5c5c}100%{transform:rotate(315deg);border-left-color:#5c5c5c;border-bottom-color:#5c5c5c;border-right-color:#5c5c5c}}@keyframes inner{0%{transform:rotate(-45deg)}25%{border-left-color:transparent}26%{border-left-color:#5c5c5c}50%{border-bottom-color:transparent}51%{border-bottom-color:#5c5c5c}75%{border-right-color:transparent}76%{border-right-color:#5c5c5c}100%{transform:rotate(315deg);border-left-color:#5c5c5c;border-bottom-color:#5c5c5c;border-right-color:#5c5c5c}}@-moz-keyframes mask{0%{transform:rotate(-45deg)}75%{transform:rotate(-45deg)}100%{transform:rotate(45deg)}}@-webkit-keyframes mask{0%{transform:rotate(-45deg)}75%{transform:rotate(-45deg)}100%{transform:rotate(45deg)}}@-o-keyframes mask{0%{transform:rotate(-45deg)}75%{transform:rotate(-45deg)}100%{transform:rotate(45deg)}}@-ms-keyframes mask{0%{transform:rotate(-45deg)}75%{transform:rotate(-45deg)}100%{transform:rotate(45deg)}}@keyframes mask{0%{transform:rotate(-45deg)}75%{transform:rotate(-45deg)}100%{transform:rotate(45deg)}}",
      'hook.styl' : "div#hookDiv{font-family:sans-serif;background-color:rgba(0,0,0,0.50);z-index:10002;height:100%;width:100%;top:0;left:0;position:fixed;text-align:center;}div#hookDiv #hookCenterDiv{display:inline-block;height:100%;vertical-align:middle;margin-right:-.25em;}div#hookDiv #hookInnerDiv{border:6px solid rgba(200,200,200,0.50);max-width:360px;text-align:center;margin:auto auto;background:#0b3147;color:#fff;outline:none;-webkit-transition:all .5s ease-in-out;-moz-transition:all .5s ease-in-out;-ms-transition:all .5s ease-in-out;-o-transition:all .5s ease-in-out;transition:all .5s ease-in-out;display:inline-block;vertical-align:middle}div#hookDiv .hookTitleText{padding:10px 20px 0 20px;font-size:22px;line-height:1.5em}div#hookDiv #hookLaunchLink{margin:0 10px 0 10px;float:left;text-align:left}div#hookDiv #hookIgnoreLink{margin:0 10px 0 10px;float:right;text-align:right}div#hookDiv .singleLinkDiv{display:table-cell;width:50%;margin:10px}div#hookDiv #hookLinkDiv{width:100%;display:table;margin:0 0 30px 0}div#hookDiv a.hookLinks:link,div#hookDiv a.hookLinks:hover,div#hookDiv a.hookLinks:visited{color:#7bbade;font-size:12px;float:left;display:inline}div#hookDiv #hookDownloadLink{color:#fff;font-weight:bold;text-align:center}div#hookDiv #hookDownloadDiv{margin:0 auto 30px auto;display:block;max-width:200px;text-align:center;color:#fff;border-top:1px solid #0e5d8b;border-bottom:1px solid #042c3a;font-size:18px;padding:10px 10px;text-decoration:none;background:-moz-linear-gradient(top,#1e7aaf 0%,#185f89 100%);background:-webkit-gradient(linear,left top,left bottom,color-stop(0%,#1e7aaf),color-stop(100%,#185f89));background:-webkit-linear-gradient(top,#1e7aaf 0%,#185f89 100%);background:-o-linear-gradient(top,#1e7aaf 0%,#185f89 100%);background:-ms-linear-gradient(top,#1e7aaf 0%,#185f89 100%);}",
      'playback.styl' : "#<%= elementId %> .video,#<%= elementId %> .midroll{position:absolute;width:100%;height:100%;z-index:10000;left:-10000px}",
      'root.styl' : "#<%= elementId %>>div{width:0;height:0;position:relative;z-index:10000;overflow:hidden}#<%= elementId %> .innerWrapper{background:#000}#<%= elementId %> .innerWrapper:-webkit-full-screen{width:100%;height:100%}#<%= elementId %> .innerWrapper:-webkit-full-screen video{width:100%}#<%= elementId %> .innerWrapper.fullscreen{position:fixed;top:0;left:0;width:100%;height:100%;background:#fff}#<%= elementId %> .oo_playhead{-ms-touch-action:none}#<%= elementId %> .oo_error{position:absolute;width:100%;height:100%;cursor:pointer;background:#1a1a1a;background-position:center center;background-size:contain;background-repeat:no-repeat;z-index:10002;}#<%= elementId %> .oo_error .oo_error_image{position:absolute;width:100%;height:30%;top:20%;background-image:url('<%= errorIcon %>');background-position:center;background-size:contain;background-origin:content;background-repeat:no-repeat}#<%= elementId %> .oo_error .oo_error_message{position:absolute;width:100%;top:70%;text-align:center;}#<%= elementId %> .oo_error .oo_error_message .oo_error_message_text{color:#d0d0d0;font-size:18px;font-family:Helvetica,sans-serif;font-weight:bold;line-height:100%;text-shadow:1px 3px 4px #000}",
      __end_marker:1 };
  }(OO));    OO.publicApi.REV='b5f3533045aa845e5bdf4488cd722df4e30387a5';

  (function(OO) {
    OO.get_img_base64 = function(imgName) {
      if (!OO.asset_list || !imgName) { return null; }
      return OO.asset_list["image/png:" + imgName] || OO.asset_list["image/gif:" + imgName];
    };

    OO.get_css = function(cssName) {
      if (!OO.stylus_css || !cssName) { return null; }
      return OO.stylus_css[cssName + ".styl"];
    };

  }(OO));  (function(OO,_,$) {
    OO.getRandomString = function() { return Math.random().toString(36).substring(7); };

    OO.safeClone = function(source) {
      if (_.isNumber(source) || _.isString(source) || _.isBoolean(source) || _.isFunction(source) ||
          _.isNull(source) || _.isUndefined(source)) {
        return source;
      }
      var result = (source instanceof Array) ? [] : {};
      try {
        $.extend(true, result, source);
      } catch(e) { OO.log("deep clone error", e); }
      return result;
    };

    OO.d = function() {
      if (OO.isDebug) { OO.log.apply(OO, arguments); }
      OO.$("#OOYALA_DEBUG_CONSOLE").append(JSON.stringify(OO.safeClone(arguments))+'<br>');
    };

    // Note: This inherit only for simple inheritance simulation, the Parennt class still has a this binding
    // to the parent class. so any variable initiated in the Parent Constructor, will not be available to the
    // Child Class, you need to copy paste constructor to Child Class to make it work.
    // coffeescript is doing a better job here by binding the this context to child in the constructor.
    // Until we switch to CoffeeScript, we need to be careful using this simplified inherit lib.
    OO.inherit = function(ParentClass, myConstructor) {
      if (typeof(ParentClass) !== "function") {
        OO.log("invalid inherit, ParentClass need to be a class", ParentClass);
        return null;
      }
      var SubClass = function() {
        ParentClass.apply(this, arguments);
        if (typeof(myConstructor) === "function") { myConstructor.apply(this, arguments); }
      };
      var parentClass = new ParentClass();
      OO._.extend(SubClass.prototype, parentClass);
      SubClass.prototype.parentClass = parentClass;
      return SubClass;
    };

    var styles = {}; // keep track of all styles added so we can remove them later if destroy is called

    OO.attachStyle = function(styleContent, playerId) {
      var s = $('<style type="text/css">' + styleContent + '</style>').appendTo("head");
      styles[playerId] = styles[playerId] || [];
      styles[playerId].push(s);
    };

    OO.removeStyles = function(playerId) {
      OO._.each(styles[playerId], function(style) {
        style.remove();
      });
    };

    OO.formatSeconds = function(timeInSeconds) {
      var seconds = parseInt(timeInSeconds,10) % 60;
      var hours = parseInt(timeInSeconds / 3600, 10);
      var minutes = parseInt((timeInSeconds - hours * 3600) / 60, 10);


      if (hours < 10) {
        hours = '0' + hours;
      }

      if (minutes < 10) {
        minutes = '0' + minutes;
      }

      if (seconds < 10) {
        seconds = '0' + seconds;
      }

      return (parseInt(hours,10) > 0) ? (hours + ":" + minutes + ":" + seconds) : (minutes + ":" + seconds);
    };

    OO.timeStringToSeconds = function(timeString) {
      var timeArray = (timeString || '').split(":");
      return _.reduce(timeArray, function(m, s) { return m * 60 + parseInt(s, 10); }, 0);
    };

    OO.leftPadding = function(num, totalChars) {
      var pad = '0';
      var numString = num ? num.toString() : '';
      while (numString.length < totalChars) {
        numString = pad + numString;
      }
      return numString;
    };

    OO.getColorString = function(color) {
      return '#' + (OO.leftPadding(color.toString(16), 6)).toUpperCase();
    };

    OO.hexToRgb = function(hex) {
      var r = (hex & 0xFF0000) >> 16;
      var g = (hex & 0xFF00) >> 8;
      var b = (hex & 0xFF);
      return [r, g, b];
    };

    OO.changeColor = function(color, ratio, darker) {
      var minmax     = darker ? Math.max : Math.min;
      var boundary = darker ? 0 : 255;
      var difference = Math.round(ratio * 255) * (darker ? -1 : 1);
      var rgb = OO.hexToRgb(color);
      return [
        OO.leftPadding(minmax(rgb[0] + difference, boundary).toString(16), 2),
        OO.leftPadding(minmax(rgb[1] + difference, boundary).toString(16), 2),
        OO.leftPadding(minmax(rgb[2] + difference, boundary).toString(16), 2)
      ].join('');
    };

    OO.decode64 = function(s) {
      s = s.replace(/\n/g,"");
      var results = "";
      var j, i = 0;
      var enc = [];
      var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";

      //shortcut for browsers with atob
      if (window.atob) {
        return atob(s);
      }

      do {
        for (j = 0; j < 4; j++) {
          enc[j] = b64.indexOf(s.charAt(i++));
        }
        results += String.fromCharCode((enc[0] << 2) | (enc[1] >> 4),
                                        enc[2] == 64 ? 0 : ((enc[1] & 15) << 4) | (enc[2] >> 2),
                                        enc[3] == 64 ? 0 : ((enc[2] & 3) << 6) | enc[3]);
      } while (i < s.length);

      //trim tailing null characters
      return results.replace(/\0/g, "");
    };

    OO.pixelPing = function (url) {
      var img = new Image();
      img.onerror = img.onabort = function() { OO.d("onerror:", url); };
      img.src = OO.getNormalizedTagUrl(url);
    };

    // ping array of urls.
    OO.pixelPings = function (urls) {
        if (_.isEmpty(urls)) { return; }
        _.each(urls, function(url) {
          OO.pixelPing(url);
        }, this);
    };


    OO.regexEscape = function(value) {
      var specials = /[<>()\[\]{}]/g;
      return value.replace(specials, "\\$&");
    };

    OO.getNormalizedTagUrl = function (url, embedCode) {
      var ts = new Date().getTime();
      var pageUrl = escape(document.URL);

      var placeHolderReplace = function (template, replaceValue) {
        _.each(template, function (placeHolder) {
          var regexSearchVal = new RegExp("(" +
                                    OO.regexEscape(placeHolder) + ")", 'gi');
          url = url.replace(regexSearchVal, replaceValue);
        }, this);
      };

      // replace the timestamp and referrer_url placeholders
      placeHolderReplace(OO.TEMPLATES.RANDOM_PLACE_HOLDER, ts);
      placeHolderReplace(OO.TEMPLATES.REFERAK_PLACE_HOLDER, pageUrl);

      // first make sure that the embedCode exists, then replace the
      // oo_embedcode placeholder
      if (embedCode) {
        placeHolderReplace(OO.TEMPLATES.EMBED_CODE_PLACE_HOLDER, embedCode);
      }
      return url;
    };

    OO.safeSeekRange = function(seekRange) {
      return {
        start : seekRange.length > 0 ? seekRange.start(0) : 0,
        end : seekRange.length > 0 ? seekRange.end(0) : 0
      };
    };

    OO.loadedJS = OO.loadedJS || {};

    OO.jsOnSuccessList = OO.jsOnSuccessList || {};

    OO.safeFuncCall = function(fn) {
      if (typeof fn !== "function") { return; }
      try {
        fn.apply();
      } catch (e) {
        OO.log("Can not invoke function!", e);
      }
    };

    OO.loadScriptOnce = function(jsSrc, successCallBack, errorCallBack, timeoutInMillis) {
      OO.jsOnSuccessList[jsSrc] = OO.jsOnSuccessList[jsSrc] || [];
      if (OO.loadedJS[jsSrc]) {
        // invoke call back directly if loaded.
        if (OO.loadedJS[jsSrc] === "loaded") {
          OO.safeFuncCall(successCallBack);
        } else if (OO.loadedJS[jsSrc] === "loading") {
          OO.jsOnSuccessList[jsSrc].unshift(successCallBack);
        }
        return false;
      }
      OO.loadedJS[jsSrc] = "loading";
      $.ajax({
        url: jsSrc,
        type: 'GET',
        cache: true,
        dataType: 'script',
        timeout: timeoutInMillis || 15000,
        success: function() {
          OO.loadedJS[jsSrc] = "loaded";
          OO.jsOnSuccessList[jsSrc].unshift(successCallBack);
          OO._.each(OO.jsOnSuccessList[jsSrc], function(fn) {
            OO.safeFuncCall(fn);
          }, this);
          OO.jsOnSuccessList[jsSrc] = [];
        },
        error: function() {
          OO.safeFuncCall(errorCallBack);
        }
      });
      return true;
    };

    try {
      OO.localStorage = window.localStorage;
    } catch (err) {
      OO.log(err);
    }
    if (!OO.localStorage) {
      OO.localStorage = {
        getItem: function (sKey) {
          if (!sKey || !this.hasOwnProperty(sKey)) { return null; }
          return unescape(document.cookie.replace(new RegExp("(?:^|.*;\\s*)" + escape(sKey).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=\\s*((?:[^;](?!;))*[^;]?).*"), "$1"));
        },
        key: function (nKeyId) {
          return unescape(document.cookie.replace(/\s*\=(?:.(?!;))*$/, "").split(/\s*\=(?:[^;](?!;))*[^;]?;\s*/)[nKeyId]);
        },
        setItem: function (sKey, sValue) {
          if(!sKey) { return; }
          document.cookie = escape(sKey) + "=" + escape(sValue) + "; expires=Tue, 19 Jan 2038 03:14:07 GMT; path=/";
          this.length = document.cookie.match(/\=/g).length;
        },
        length: 0,
        removeItem: function (sKey) {
          if (!sKey || !this.hasOwnProperty(sKey)) { return; }
          document.cookie = escape(sKey) + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
          this.length--;
        },
        hasOwnProperty: function (sKey) {
          return (new RegExp("(?:^|;\\s*)" + escape(sKey).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=")).test(document.cookie);
        }
      };
      OO.localStorage.length = (document.cookie.match(/\=/g) || OO.localStorage).length;
    }

    // A container to properly request OO.localStorage.setItem
    OO.setItem = function (sKey, sValue) {
      try {
        OO.localStorage.setItem(sKey, sValue);
      } catch (err) {
        OO.log(err);
      }
    };

    OO.JSON = window.JSON;

  }(OO, OO._, OO.$));
  (function(OO,_) {

    OO.Emitter  = function(messageBus){
      this.mb = messageBus;
      this._subscribers = {};
    };

    _.extend(OO.Emitter.prototype,  {
      on  : function(eventName, subscriber, callback){
        this._subscribers[eventName] = this._subscribers[eventName]  || [];
        this._subscribers[eventName].push({callback: callback, subscriber: subscriber});
      },

      off  : function(eventName, subscriber, callback){
        this._subscribers[eventName] = _.reject(this._subscribers[eventName] || [], function(elem) {
          return (elem.callback == callback || callback === undefined) && elem.subscriber === subscriber;
        });
      },

      trigger  : function(eventName /* , args... */){
        _.each(this._subscribers[eventName] || [], _.bind(this._triggerSubscriber, this, eventName, arguments));
        _.each(this._subscribers['*'] || [], _.bind(this._triggerSubscriber, this, eventName, arguments));
      },

      _triggerSubscriber : function(eventName, params, subscriber) {
        try {
          subscriber.callback.apply(this,params);
        } catch (e) {
          var stack = e.stack || "unavailable";
          OO.log('Uncaught exception', e, 'Stack', stack,'triggering subscriber', subscriber,
            'with event',eventName, 'Parameters: ', params);
        }
      },

      __placeholder:true
    });

  }(OO, OO._));
  (function(OO,_) {
  /**
   * @classdesc Represents the Ooyala V3 Player Message Bus. Use message bus events to subscribe to or publish player events from video to ad playback. 
   * <p>When you create an {@link OO.Player} object (for example, <code>myplayer = OO.Player.create(...)</code> ), that object contains a Message Bus object named <code>mb</code>.
   * For example, you would access the <code><a href="#publish">publish()</a></code> method by calling <code>myplayer.mb.publish(...)</code>.</p>  
   * @class
   */
    OO.MessageBus = function() {
      this._emitter = new OO.Emitter(this);
      this._dependentEmitter = new OO.Emitter(this);
      this._interceptEmitter = new OO.Emitter(this);
      this._interceptArgs = {};
      this._dependentList = {};
      this._blockList = {};
      this._readyEventList = {};
      this._queuedArgs = {};
      this._dispatching = false;   // whether message bus is currently dispatching published events
      this._publishingQueue = [];
      this.blockedEvent = {};
      this.blockedParams = {};

      // public properties
      this._messageHistory = [];
      this._tracer = _.bind(this._internalTracer, this);   // default internal tracer

      // add a random ID for debug
      this.MbId = OO.getRandomString();
    };

    _.extend(OO.MessageBus.prototype,  {
      // Adds a tracer function, which will be fired for each published/executed event
      addTracer: function(newTracer) {
        if(newTracer && _.isFunction(newTracer)) {
          if(this._tracer) {
            this._tracer = _.wrap(this._tracer, function(f) { newTracer.apply(this, _.rest(arguments)); });
          } else {
            this._tracer = newTracer;
          }
        }
      },

      _internalTracer: function() {
        this._messageHistory.push(_.toArray(arguments));
      },

      messageTraceSnapshot: function() {
        return _.toArray(this._messageHistory);
      },

      /*
       * addDependent blocks eventName until dependentEvent fires, at which point onMergeParams will be
       * called.  This means that eventName MUST be fired before dependentEvent.
       */
      /**
       * Enables you to send a publish or subscribe message that is dependent on a condition or event. 
       * For example, you might want to change the UI based on the location or time of day.
       * This method blocks the event (<code>eventName</code>) until the dependent event (<code>dependentEvent</code>) fires.
       * For more information and examples of usage, see 
       * <a href="http://support.ooyala.com/developers/documentation/reference/player_v3_dev_listenevent.html" target="target">Listening to a Message Bus Event</a>.  
       * 
       * @method addDependent
       * @memberOf OO.MessageBus.prototype
       * @param {String} eventName The name of the event.
       * @param {String} dependentEvent The name of the event that triggers the specified event name.
       * @param {String} subscriber The name of the subscriber to which the message bus will publish the event.
       * @param {function} onMergeParams (Optional) A function used to pass data to the handler for the dependent event. 
       * This function is only necessary if need to complete a computation before passing data to the dependent event handler.
       * This function can take up to four arguments and returns an array of arguments to be passed into the dependent event listener.
       * @example 
       *     //  This blocks the PAUSED event from firing until
       *       // the 'user_allowed_pause' event has fired 
       *     player.mb.addDependent(
       *       OO.EVENTS.PAUSED, 
       *       'user_allowed_pause', 
       *       'example', 
       *       function(){}
       *     );
       */
      addDependent: function(eventName, dependentEvent, subscriber, onMergeParams){
        // TODO, add a circular detectecion here.
        this._dependentList[eventName] = this._dependentList[eventName] || [];
        this._dependentList[eventName].push(dependentEvent);
        this._blockList[dependentEvent] = this._blockList[dependentEvent] || [];
        this._blockList[dependentEvent].push(eventName);
        this.blockedParams[eventName] = [];

        var onSourceReady = OO._.bind(function(e) {
          if (this.blockedEvent[e] != 1) {
            delete this._queuedArgs[e];
            return;
          }
          var args = OO.safeClone(_.flatten(arguments));
          var origParams = OO.safeClone(this.blockedParams[eventName]);
          args.shift(); origParams.shift();

          var newArgs = onMergeParams.apply(this, [eventName, dependentEvent, origParams, args]) || args;
          delete this.blockedEvent[e];
          this.blockedParams[e] = [];
          this._emitter.trigger.apply(this._emitter, [e].concat(newArgs));
        }, this);

        this._dependentEmitter.on(eventName, subscriber, onSourceReady);
      },

      /**
       * Enables you to publish events to the message bus.<br/>
       * 
       * @method publish
       * @memberOf OO.MessageBus.prototype
       * @param {String} eventName The name of the event. Comma-separated arguments for the event may follow the event name as needed.
       * @example myplayer.mb.publish(OO.EVENTS.PLAY);
       * @example myplayer.mb.publish(OO.EVENTS.WILL_CHANGE_FULLSCREEN,true);
       */
      publish: function() {
        var args = OO.safeClone(_.flatten(arguments));
        this._publishingQueue.push(args);

        if(!this._dispatching) {
          this._dispatching = true;
          var ev = this._publishingQueue.shift();
          while(ev) {
            this._publish.apply(this, ev);
            ev = this._publishingQueue.shift();
          }
          this._dispatching = false;
        }
      },


      _publish: function(eventName) {
        // queue event here untill all dependency is cleared.
        // also trigger queued event if there are blocked by this event.
        this._readyEventList[eventName] = 1;
        var args = OO.safeClone(_.flatten(arguments));

        this._interceptEmitter.trigger.apply(this._interceptEmitter, args);
        if (this._interceptArgs[eventName] === false) { this._interceptArgs[eventName] = true; return; }
        if (this._interceptArgs[eventName]) {
          args = _.flatten([eventName, this._interceptArgs[eventName]]);
        }

        if(this._tracer && _.isFunction(this._tracer)) {
          var params = _.flatten(['publish'].concat(args));
          this._tracer.apply(this._tracer, params);
        }

        if (this._noDependency(eventName)) {
          this._emitter.trigger.apply(this._emitter, this._queuedArgs[eventName] || args);
          delete this._queuedArgs[eventName];
          _.each(this._blockList[eventName], function(e) {
            this._clearDependent(e, eventName);
            args[0] = e;
            this._queuedArgs[e] = args;
            this._dependentEmitter.trigger.apply(this._dependentEmitter, args);
          }, this);
        } else {
           this.blockedEvent[eventName] = 1;
           this.blockedParams[eventName] = args;
        }
      },

      /*
       * eventName is the event to intercept
       * subscriber is the subscriber
       * callback returns a list of arguments, not including the eventName
       */
      /**
       * Enables you to subscribe to events to the message bus using a callback function that 
       * allows you to manipulate the event payload and name. The returned list of arguments
       * from the callback can be used in subsequent event triggers. For more information and examples of usage, see 
       * <a href="http://support.ooyala.com/developers/documentation/reference/player_v3_dev_listenevent.html" target="target">Listening to a Message Bus Event</a>.<br/>
       * 
       * @method intercept
       * @memberOf OO.MessageBus.prototype
       * @param {String} eventName The name of the event to intercept.
       * @param {String} subscriber The name of the subscriber to which the message bus will publish the event.
       * @param {function} callback A function that returns a list of arguments used in subsequent event triggers. 
       * This allows you to manipulate the event payload and name. To cancel propagation of an event using an intercepter, 
       * return <code>false</code> instead of an array.
       * @example In the following example we subscribe to the published message bus PLAY event, 
       * specify 'test-plugin' as the subscriber and specify a payload of 'hello'. 
       * 
       * We also include an intercept that swaps the string 'goodbye' into the payload
       * so that when the message bus publishes the PLAY event, the console outputs 'goodbye' instead of 'hello':
       * 
       * mb.subscribe(OO.EVENTS.PLAY, "test-plugin", function(eventName, payload) {  
       *    console.log(eventName+": "+payload); 
       * });
       * 
       * mb.publish(OO.EVENTS.PLAY, "hello");
       *      
       * // Console displays "play: hello"
       *         
       * mb.intercept(OO.EVENTS.PLAY, "test-plugin", function(eventName, payload) {
       *     return ["goodbye"]; 
       * });
       *              
       * //   Console displays "play: goodbye"
       */
      intercept: function(eventName, subscriber, callback) {
        this._interceptEmitter.on(eventName, subscriber, _.bind(function(e) {
          var args = OO.safeClone(_.flatten(arguments));
          if (this._interceptArgs[eventName] != false) {
            this._interceptArgs[eventName] = callback.apply(this, args);
          }
        }, this));
        this._interceptArgs[eventName] = [eventName];
      },

      /** 
       * Subscribe to an event published to the message bus.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">HTML5, Flash</p><br/>
       * 
       * @method subscribe
       * @memberOf OO.MessageBus.prototype
       * @param {String} eventName The name of the event.
       * @param {String} subscriber The name of the subscriber to which the message bus will publish the event.
       * @param {Function} callback The function that will execute when the subscriber receives the event notification.
       * @example myplayer.mb.subscribe(OO.EVENTS.METADATA_FETCHED, 'example', function(eventName) {});
       * @example // Subscribes to all events published by the Message Bus
       * messageBus.subscribe("*", 'example', function(eventName) {});  
       */
      subscribe: function(eventName, subscriber, callback) {
        // TODO check if it is on the dependent queue, should not allow this action if a event is blocking
        // other event.
        this._emitter.on(eventName, subscriber, callback);
      },

      /** 
       * Unsubscribes from an event published to the message bus.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">HTML5, Flash</p><br/>
       * 
       * @method unsubscribe
       * @memberOf OO.MessageBus.prototype
       * @param {String} eventName The name of the event.
       * @param {String} subscriber The name of the subscriber to which the message bus will unsubscribe from the event.
       * @param {Function} callback The function that normally executes when the subscriber receives the event notification.
       * @example messageBus.unsubscribe(OO.EVENTS.METADATA_FETCHED, 'example', function(eventName) {});
       * @example // Unsubscribes from all events published by the Message Bus
       * messageBus.unsubscribe("*", 'example', function(eventName) {});  
       */
      unsubscribe: function(eventName, subscriber, callback) {
        this._emitter.off(eventName, subscriber, callback);
      },

      // Start of the private member function, all internal used func will prefix with _ 

      _noDependency: function(eventName) {
        if (!this._dependentList[eventName]) { return true; }
        return (this._dependentList[eventName].length === 0);

      },

      _clearDependent: function(source, target) {
        var depEvents = this._dependentList[source];
        this._dependentList[source] = OO._.filter(depEvents, function(e){ return e !== target; }, this);
      }

    });

  }(OO,OO._));

(function (OO, _) {
  OO.StateMachine = {
    //Based on https://github.com/jakesgordon/javascript-state-machine
    create: function(_cfg) {
      // validate parameters
      var cfg = OO.HM.safeObject('statemachine.create.cfg', _cfg);
      var initial = OO.HM.safeDomId('statemachine.create.cfg.initial', cfg.initial);
      var fsm = OO.HM.safeObject('statemachine.create.cfg.target', cfg.target, {});
      var events = OO.HM.safeArrayOfElements('statemachine.create.cfg.events', cfg.events, function(element){ return OO.HM.safeObject('statemachine.create.cfg.events[]', element); }, []);
      var moduleName = OO.HM.safeString('statemachine.create.cfg.moduleName', cfg.moduleName,"");
      var mb = OO.HM.safeObject('statemachine.create.cfg.messageBus', cfg.messageBus);

      var map        = {};
      var n;

      var doCallback = function(name) {
        var f = null;
        var shortEventName = name.replace(/[^\/]*\//,'').match(/^(.)(.*)/);   // transform xxx/abc into ['abc','a','bc']
        var shortMethodName = 'on'+shortEventName[1].toUpperCase() + shortEventName[2];
        if(fsm[shortMethodName]) {
          f = fsm[shortMethodName];
        } else {
          var fullEventName = name.replace(/\/.*/, '').match(/^(.)(.*)/);    // transform xyz/abc into ['xyz','x','yz']
          var fullMethodName = 'on'+fullEventName[1].toUpperCase() + fullEventName[2] + shortEventName[1].toUpperCase() + shortEventName[2];
          if(fsm[fullMethodName]) {
            f = fsm[fullMethodName];
          }
        }

        if (f) {
          try {
            var result = f.apply(fsm, arguments);
            return (result !== false ? 'ok' : 'fail');
          }
          catch(e) {
            OO.log(e);
            if(OO.TEST_TEST_TEST) {
              throw e;  // rethrow in test environment
            }
            return 'fail';
          }
        }

        // callback not found
        return 'not_found';
      };

      var add = function(e) {
        var from = (e.from instanceof Array) ? e.from : (e.from ? [e.from] : ['*']); // allow 'wildcard' transition if 'from' is not specified
        var n;
        map[e.name] = map[e.name] || {};
        for (n = 0 ; n < from.length ; n++) {
          map[e.name][from[n]] = e.to || from[n]; // allow no-op transition if 'to' is not specified
        }
      };

      var updateState = function(fsm, state) {
        if (state === "*") { return; } // no op  for * state
        fsm.currentState = state;
      };

      fsm.canReceive = function(event) { return map[event] && (map[event].hasOwnProperty(fsm.currentState) || map[event].hasOwnProperty('*')); };

      fsm.receive = function(event/*....arguments*/) {
        //drop events not valid in current state
        if (!fsm.canReceive(event)) {
          OO.log('dropped event', arguments, 'for', moduleName, 'while in state',fsm.currentState, 'with map',map);
          return;
        }

        var from  = fsm.currentState;
        var to    = map[event][from] || map[event]['*'] || from;
        var n;

        //handle transition to same state
        if (from === to) {
          doCallback.apply(fsm, arguments);
          return;
        }

        updateState(fsm, to);

        var callbackResult = 'not_found';
        if(to !== "*") { callbackResult = doCallback.apply(fsm, _.union([to], _.rest(arguments))); }
        if(callbackResult==='not_found') { callbackResult = doCallback.apply(fsm, arguments); }

        switch ( callbackResult )  {
          case 'not_found':
            OO.log('Module ' + moduleName + ' does not handle state ' + to + ' or event ', arguments);
            updateState(fsm, from);
            break;
          case 'fail':
            updateState(fsm, from);
            break;
          case 'ok':
            break;
        }
      };

      for(n = 0 ; n < events.length ; n++) {
        if(typeof(events[n]) == 'object') {
          add(events[n]);
        }
      }

      updateState(fsm, initial);
      if (mb !== undefined) {
        for(n in map) {
          mb.subscribe(n.toString(), moduleName, fsm.receive);
        }
      }

      return fsm;
    },

    __end_marker : true
  };
}(OO, OO._));  (function(OO,_, $) {
    // Module registration facility
    OO.players  = {};
    OO.modules = [];
    OO.registerModule = function(_moduleName, _moduleFactoryMethod) {
      // validate params
      var moduleName = OO.HM.safeDomId('moduleName', _moduleName, OO.HM.fixDomId),
        moduleFactoryMethod = OO.HM.safeFunction('moduleFactoryMethod', _moduleFactoryMethod);

      OO.modules.push({ name: moduleName, factory: moduleFactoryMethod});
    };

    OO.plugin = function(moduleName, moduleClassFactory) {
      OO.registerModule(moduleName, function(messageBus, id) {
        // TODO, check if we need to catch any exception here.
        var moduleClass = moduleClassFactory.apply({}, [OO, OO._, OO.$, window]);
        var plugin = new moduleClass(messageBus, id);
        return plugin;
      });
    };

    // API registration facility
    OO.exposeStaticApi = function(_apiModule, _apiObject) {
      // validate params
      var apiModule = OO.HM.safeDomId('apiModule', _apiModule),
        apiObject = OO.HM.safeObject('apiObject', _apiObject);

      OO.publicApi[apiModule] = OO.publicApi[apiModule] || {};
      OO._.extend(OO.publicApi[apiModule], apiObject);
    };

    /**
     * @classdesc Represents the Ooyala V3 Player.
     * @class
     */
    // Player class
    OO.Player = function(_elementId, _embedCode, _parameters) {
      // validate params
      // _parameters is optional. Hazmat takes care of this but throws an undesirable warning.
      _parameters = _parameters || {};

      var elementId = OO.HM.safeDomId('Player.create.elementId', _elementId),
        embedCode = OO.HM.safeStringOrNull('Player.create.embedCode', _embedCode),
        parameters = OO.HM.safeObject('Player.create.parameters', _parameters, {});

      parameters.onCreate = OO.HM.safeFunctionOrNull('Player.create.parameters.onCreate', parameters.onCreate);

      // copy parameters
      this.elementId = elementId;
      this.embedCode = embedCode;
      this.parameters = parameters;
      this.playbackReady = false;
      this.adPlaying = false;
      this.wasPlaying = false;

      $("#" + this.elementId).html(''); // clear the container for player rendering.

      var mb = this.mb = new OO.MessageBus();

      // initialize modules
      this.modules = OO._.map(OO.modules, function(moduleDefinition) {
        var id = moduleDefinition.name + '-' + OO.getRandomString();
        var module = {
          name: moduleDefinition.name,
          moduleId: id, // a random id to help debug
          instance: moduleDefinition.factory(mb, id, parameters)   // Modules Only See MB directly, not the player
        };
        return module;
      });

      // keep state
      this.state = OO.STATE.LOADING;
      this.mb.subscribe(OO.EVENTS.PLAYBACK_READY, 'player', _.bind(function() {
        this.state = OO.STATE.READY;
        this.playbackReady = true;
        if (this._playQueued) { this.play(); }
      }, this));
      this.mb.subscribe(OO.EVENTS.PLAYING, 'player', _.bind(function() {
        // initial time:
        // TODO, w3c has introduced a new attribute for HTML 5 tag: initialTime
        // http://www.w3.org/TR/2011/WD-html5-20110113/video.html#dom-media-initialtime
        // Once it is widely supported, we can directly set this attribute instead.
        if (this.state != OO.STATE.ERROR) {
          this.state = OO.STATE.PLAYING;
          this._playedOnce = true;
          this.wasPlaying = true;
        }
      }, this));
      this.mb.subscribe(OO.EVENTS.PAUSED, 'player', _.bind(function() {
        if (this.state != OO.STATE.ERROR) {
          this.state = OO.STATE.PAUSED;
        }
        this.wasPlaying = false;
      }, this));
      this.mb.subscribe(OO.EVENTS.BUFFERING, 'player', _.bind(function() {
        if (this.state != OO.STATE.ERROR) {
          this.state = OO.STATE.BUFFERING;
        }
      }, this));
      this.mb.subscribe(OO.EVENTS.BUFFERED, 'player', _.bind(function() {
        // If the video is still in a buffering state after we've finished buffering,
        // Change it to either a playing or paused state
        if (this.state === OO.STATE.BUFFERING) {
          this.state = (this.wasPlaying) ? OO.STATE.PLAYING : OO.STATE.PAUSED;
        }
      }, this));
      this.mb.subscribe(OO.EVENTS.PLAYED, 'player', _.bind(function() {
        this.state = OO.STATE.READY;
        this.wasPlaying = false;
      }, this));
      this.mb.subscribe(OO.EVENTS.WILL_PLAY_ADS, 'player', _.bind(function(event, adDuration) {
        this.adDuration = adDuration;
        this._playedOnce = true;
        this.adPlaying = true;
      }, this));
      this.mb.subscribe(OO.EVENTS.ADS_PLAYED, 'player', _.bind(function() {
        this.adDuration = -1;
        this.adPlaying = false;
      }, this));

      // listen for some events to keep a copy of metadata for APIs
      this.playheadTime = -1;
      this.duration = -1;
      this.adDuration = -1;
      this.bufferLength = -1;
      this.currentItem = this.item = null;
      this.clockOffset = 0;

      this.mb.subscribe(OO.EVENTS.CONTENT_TREE_FETCHED, 'player', _.bind(function(event, tree) {
        // NOTE[jigish]: we do not support channels yet, so currentItem *is* the root item
        this.currentItem = this.item = tree;
        if (!tree) { return; }
        // preset duration to what contentTree thinks it is. we'll change it later
        this.duration = tree.duration;
      }, this));
      this.mb.subscribe(OO.EVENTS.WILL_FETCH_AUTHORIZATION, 'player', _.bind(function(event) {
        this.authStartTime = new Date().getTime();
      }, this));
      this.mb.subscribe(OO.EVENTS.AUTHORIZATION_FETCHED, 'player', _.bind(function(event, tree) {
        if (!tree.debug_data || !tree.debug_data.user_info) { return; }
        var currentTime = new Date().getTime();
        var latency = (currentTime - this.authStartTime - tree.debug_data.server_latency) / 2;
        this.clockOffset = (tree.debug_data.user_info.request_timestamp * 1000) + latency - currentTime;
      }, this));

      this.mb.subscribe(OO.EVENTS.CAN_SEEK, 'player', _.bind(function(event) {
        var initialTime = parseInt(this.parameters.initialTime, 10);
        if (!isNaN(initialTime) && initialTime > 0 && !this.adPlaying) {
          this.seek(initialTime);
          this.parameters.initialTime = null; // unset initial time to avoid double seek.
        }
      }, this));

      this.mb.subscribe(OO.EVENTS.PLAYHEAD_TIME_CHANGED, 'player', _.bind(function(event, time, duration, buffer) {
        this.playheadTime = time;
        this.duration = duration;
        this.bufferLength = buffer;
        if (!this.startTime) { this.startTime = new Date().getTime(); }

        // initialTime is used for X-Device Resume. After it's triggered once, it should go away.
        // However it isn't possible to do an initialTime seek if we're in the loading state
        if (!this.adPlaying && this.parameters.initialTime &&
              time && this.state != OO.STATE.LOADING) {
          this.mb.publish(OO.EVENTS.CAN_SEEK);
        }
      }, this));

      this.mb.subscribe(OO.EVENTS.BLOCK_INITIAL_TIME, 'player', _.bind(function(event){
        // If a call is sent to block the initial time, then set it to null
        this.parameters.initialTime = null;
      }, this));

      this.mb.subscribe(OO.EVENTS.DOWNLOADING, 'player', _.bind(function(event, time, duration, buffer) {
        this.playheadTime = time;
        this.duration = duration;
        this.bufferLength = buffer;
      }, this));

      // keep track of fullscreen state
      this.fullscreen = false;
      this.mb.subscribe(OO.EVENTS.FULLSCREEN_CHANGED, 'player', _.bind(function(event, state) {
        this.fullscreen = state;
      }, this));

      // keep track of errors
      this.error = null;
      this.mb.subscribe(OO.EVENTS.ERROR, 'player', _.bind(function(event, err) {
        this.error = err;
        this.state = OO.STATE.ERROR;
      }, this));

      // keep track of volume
      // NOTE[jigish]: this may or may not work on some browsers.
      this.volume = 1;
      this.mb.subscribe(OO.EVENTS.VOLUME_CHANGED, 'player', _.bind(function(event, volume) {
        this.volume = volume;
      }, this));

      // reset shit on setEmbedCode
      this.mb.subscribe(OO.EVENTS.SET_EMBED_CODE, 'player', _.bind(function(event, embedCode, options) {
        this.error = null;
        this.playheadTime = -1;
        this.duration = -1;
        this.bufferLength = -1;
        this.currentItem = this.item = null;
        this.playbackReady = false;
        this.state = OO.STATE.LOADING;
        this.parameters = _.extend(this.parameters, options);
        if (this.parameters.locale !== undefined) {
          OO.setLocale(this.parameters.locale);
        }
      }, this));

      // listen for destroy
      this.mb.subscribe(OO.EVENTS.DESTROY, 'player', _.bind(function(event, embedCode) {
        $("#" + this.elementId).empty();
        delete OO.players[this.elementId];
        OO.removeStyles(this.elementId);
        this.state = OO.STATE.DESTROYED;

        // [PBW-459] Call optional destory() callback after DESTROY is complete.
        if (this.destroyCallback) {
          this.destroyCallback();
          this.destroyCallback = null;
        }
      }, this));

      // keep track of bitrates
      this.bitratesInfo = {};
      this.mb.subscribe(OO.EVENTS.BITRATE_INFO_AVAILABLE, 'player', _.bind(function(event, info) {
        this.bitratesInfo = info;
      }, this));

      // keep track of closedCaptionsLanguages
      this.closedCaptionsLanguages = {};
      this.mb.subscribe(OO.EVENTS.CLOSED_CAPTIONS_INFO_AVAILABLE, 'player', _.bind(function(event, info) {
        this.closedCaptionsLanguages = info;
      }, this));

      /*
       * Public Player API Instance Methods
       *
       * NOTE[jigish]: Some functions are aliased to maintain compatibility with the flash player. Others are
       * aliased because they are Channel APIs and Channels are not supported yet.
       *
       * TODO[jigish]:
       * setQueryStringParameters
       */

      /* Actions */
      this._playedOnce = false;
      this._playQueued = false;

      /**
       * Sets the embed code for the current player. You may optionally specify an <code>options</code> object
       * that enables you to dynamically assign an ad set or other asset-level options to the embed code.
       * For example, you can set the initial position from which the player will start.
       * This is an asynchronous method and may return before having completed the operation.
       * If your logic depends on the completion of this operation, listen to the corresponding event.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">HTML5, Flash</p><br/>
       *
       * @method setEmbedCode
       * @memberOf OO.Player.prototype
       * @param {String} embedCode An embed code belonging to the same provider as the ad set code.
       * @param {Object} options <b>(Optional)</b> An object containing a hash of key-value pairs representing the unique ad set code.
       */
      /**
       * Sets the embed code for the current player. You may optionally specify an <code>options</code> object
       * that enables you to dynamically assign an ad set or other asset-level options to the embed code.
       * For example, you can set the initial position from which the player will start.
       * This is an asynchronous method and may return before having completed the operation.
       * If your logic depends on the completion of this operation, listen to the corresponding event.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">HTML5, Flash</p><br/>
       *
       * @method setCurrentItemEmbedCode
       * @memberOf OO.Player.prototype
       * @param {String} embedCode An embed code belonging to the same provider as the ad set code.
       * @param {Object} options <b>(Optional)</b> An object containing a hash of key-value pairs representing the unique ad set code.
       */
      this.setEmbedCode = this.setCurrentItemEmbedCode = function(embedCode, options) {
        this._playedOnce = false;
        this.mb.publish(OO.EVENTS.SET_EMBED_CODE, embedCode, options || {});
      };

      /**
       * Plays the current video and the entire asset including ads, or queues it for playback if the video is not ready.
       * This is an asynchronous method and may return before having completed the operation.
       * If your logic depends on the completion of this operation, listen to the corresponding event.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">HTML5, Flash</p><br/>
       *
       * @method play
       * @memberOf OO.Player.prototype
       */
      /**
       * Plays the current video and the entire asset including ads, or queues it for playback if the video is not ready.
       * This is an asynchronous method and may return before having completed the operation.
       * If your logic depends on the completion of this operation, listen to the corresponding event.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">HTML5, Flash</p><br/>
       *
       * @method playMovie
       * @memberOf OO.Player.prototype
       */
      this.play = this.playMovie = function() {
        if (this.state == OO.STATE.ERROR) {
          return;
        } else if (!this.playbackReady) {
          this._playQueued = true;
          return;
        }
        this.mb.publish(this._playedOnce ? OO.EVENTS.PLAY : OO.EVENTS.INITIAL_PLAY);
        this._playedOnce = true;
        this._playQueued = false;
      };

      /**
       * Pauses the current video playback.
       * This is an asynchronous method and may return before having completed the operation.
       * If your logic depends on the completion of this operation, listen to the corresponding event.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">HTML5, Flash</p><br/>
       *
       * @method pause
       * @memberOf OO.Player.prototype
       */
      /**
       * Pauses the current video playback.
       * This is an asynchronous method and may return before having completed the operation.
       * If your logic depends on the completion of this operation, listen to the corresponding event.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">HTML5, Flash</p><br/>
       *
       * @method pauseMovie
       * @memberOf OO.Player.prototype
       */
      this.pause = this.pauseMovie = function() {
        this.mb.publish(OO.EVENTS.PAUSE);
      };

      /**
       * Seeks to the specified number of seconds from the beginning.
       * This is an asynchronous method and may return before having completed the operation.
       * If your logic depends on the completion of this operation, listen to the <code>BUFFERED</code> event.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">HTML5, Flash</p><br/>
       *
       * @method seek
       * @memberOf OO.Player.prototype
       * @param {Number} seconds The number of seconds from the beginning at which to begin playing the video.
       */
      /**
       * Seeks to the specified number of seconds from the beginning.
       * This is an asynchronous method and may return before having completed the operation.
       * If your logic depends on the completion of this operation, listen to the <code>BUFFERED</code> event.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">HTML5, Flash</p><br/>
       *
       * @method setPlayheadTime
       * @memberOf OO.Player.prototype
       * @param {Number} seconds The number of seconds from the beginning at which to begin playing the video.
       */
      this.seek = this.setPlayheadTime = function(seconds) {
        this.mb.publish(OO.EVENTS.SEEK, seconds);
      };

      /**
       * Sets the current volume on a best-effort basis according to the underlying device limitations.
       * This is an asynchronous method and may return before having completed the operation.
       * If your logic depends on the completion of this operation, listen to the corresponding event.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">HTML5, Flash</p><br/>
       *
       * @method setVolume
       * @memberOf OO.Player.prototype
       * @param {Number} volume The volume. Specify a value between 0 and 1, inclusive.
       */
      this.setVolume = function(volume) {
        this.mb.publish(OO.EVENTS.CHANGE_VOLUME, volume);
      };

      /**
       * Destroys the item. When this method is called, the player is removed, all activity is stopped, and any video is unloaded.
       * This is an asynchronous method and may return before having completed the operation.
       * If your logic depends on the completion of this operation, listen to the corresponding event.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">HTML5, Flash</p><br/>
       *
       * @method destroy
       * @memberOf OO.Player.prototype
       * @param {function} callback (<b>Optional</b>) A function callback used to notify a web page
       * that the <code>destroy</code> method has completed destroying the HTML5 player.
       */
      this.destroy = function(callback) {
        // [PBW-459] Save optional callback to be called after DESTROY event is unblocked.
        if (callback && typeof callback === "function") {
          this.destroyCallback = callback;
        }
        this.mb.publish(OO.EVENTS.DESTROY);
      };

      /**
       * Toggles the visibility of the player share screen.
       * This is an asynchronous method and may return before having completed the operation.
       * If your logic depends on the completion of this operation, listen to the corresponding event.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">Flash</p><br/>
       *
       * @method toggleSharePanel
       * @memberOf OO.Player.prototype
       */
      this.toggleSharePanel = function() {
        this.mb.publish(OO.EVENTS.TOGGLE_SHARE_PANEL);
      };

      /**
       * Toggles the visibility of the info screen.
       * This is an asynchronous method and may return before having completed the operation.
       * If your logic depends on the completion of this operation, listen to the corresponding event.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">Flash</p><br/>
       *
       * @method toggleInfoPanel
       * @memberOf OO.Player.prototype
       */
      this.toggleInfoPanel = function() {
        this.mb.publish(OO.EVENTS.TOGGLE_INFO_PANEL);
      };

      /**
       * When called while a player is playing, this Boolean function shows or hides
       * cue point markers on the scrubber bar during ad playback. <br/>
       * By default, cue point markers are hidden. If <code>shouldDisplayCuePointMarkers(True)</code> is
       * called and there are active mid-roll and post-roll ads available,
       * the player displays any cue point markers on the scrubber bar.
       * This is an asynchronous method and may return before having completed the operation.
       * If your logic depends on the completion of this operation, listen to the corresponding event.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">Flash</p><br/>
       *
       * @method shouldDisplayCuePointMarkers
       * @memberOf OO.Player.prototype
       * @param {Boolean} visible Set to <code>true</code> to show cue point markers on the scrubber bar
       * during ad playback; set to <code>false</code> otherwise. The default is <code>false</code>.
       */
      this.shouldDisplayCuePointMarkers = function(visible) {
        this.mb.publish(OO.EVENTS.SHOULD_DISPLAY_CUE_POINTS, visible);
      };

      /* Getters */

      /**
       * Retrieves the playhead position in seconds.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">HTML5, Flash</p>
       *
       * @method getPlayheadTime
       * @memberOf OO.Player.prototype
       * @return {Number} The playhead position, in seconds.
       */
      this.getPlayheadTime = function() {
        return this.playheadTime;
      };

      this.getLiveTime = function() {
        return new Date(this.startTime + (this.playheadTime * 1000) + this.clockOffset);
      };

      /**
       * Retrieves the total duration, in milliseconds, of the video.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">HTML5, Flash</p>
       *
       * @method getTotalTime
       * @memberOf OO.Player.prototype
       * @return {Number} The total duration of the video in milliseconds.
       */
      this.getDuration = this.getTotalTime = function() {
        if (this.embedCode === OO.CONSTANTS.STANDALONE_AD_HOLDER) {
          return this.adDuration;
        }
        return this.duration;
      };

      /**
       * Retrieves the current size of the buffer in seconds.<br/>
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">HTML5, Flash</p>
       *
       * @method getBufferLength
       * @memberOf OO.Player.prototype
       * @return {Number} The current size of the buffer in seconds when buffer length is supported; returns 0 otherwise.
       */
      this.getBufferLength = function() {
        return this.bufferLength;
      };

      /**
       * Retrieves an object describing the current video.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">HTML5, Flash</p>
       *
       * @method getCurrentItem
       * @memberOf OO.Player.prototype
       * @return {Object} The current video, described in an object containing the following attributes:
       * <ul>
       *    <li><code>embedCode</code></li>
       *    <li><code>title</code></li>
       *    <li><code>description</code></li>
       *    <li><code>time</code> (play length in seconds)</li>
       *    <li><code>lineup</code></li>
       *    <li><code>promo</code></li>
       *    <li><code>hostedAtURL</code></li>
       * </ul>
       */
      this.getItem = this.getCurrentItem = function() {
        return this.item;
      };

      /**
       * Retrieves the description of the current video. This function retrieves the description that was set
       * in the the <b>Backlot Manage Details</b> tab or the equivalent manual setting.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">HTML5, Flash</p>
       *
       * @method getCurrentItemDescription
       * @memberOf OO.Player.prototype
       * @return {String} The description of the current video. For example, <code>Season 22 Opening Game</code>.
       */
      this.getDescription = this.getCurrentItemDescription = function() {
        if (!this.item) { return null; }
        return this.item.description;
      };

      /**
       * Retrieves the embed code for the current player.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">HTML5, Flash</p>
       *
       * @method getCurrentItemEmbedCode
       * @memberOf OO.Player.prototype
       * @return {String} The embed code for the current player.
       */
      this.getEmbedCode = this.getCurrentItemEmbedCode = function() {
        if (!this.item) { return null; }
        return this.item.embedCode || this.item.embed_code; // it could be one or the other
      };

      /**
       * Retrieves the title of the current video.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">HTML5, Flash</p>
       *
       * @method getCurrentItemTitle
       * @memberOf OO.Player.prototype
       * @return {String} The title of the current video. For example, <code>My Snowboarding Channel</code>.
       */
      this.getTitle = this.getCurrentItemTitle = function() {
        if (!this.item) { return null; }
        return this.item.title;
      };

      /**
       * Determines whether the player is in full screen mode.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">HTML5, Flash</p>
       *
       * @method getFullscreen
       * @memberOf OO.Player.prototype
       * @return {Boolean} <code>true</code> if the player is in full screen mode, <code>false</code> otherwise.
       */
      this.isFullscreen = this.getFullscreen = function() {
        return this.fullscreen;
      };

      /**
       * Retrieves the current error code if it exists.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">HTML5, Flash</p>
       *
       * @method getErrorCode
       * @memberOf OO.Player.prototype
       * @return {String} The error code, if it exists.
       */
      this.getError = this.getErrorCode = function() {
        return this.error != null ? this.error.code : null;
      };

      /**
       * Retrieves a string corresponding to the current error code.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">HTML5, Flash</p>
       *
       * @method getErrorText
       * @memberOf OO.Player.prototype
       * @return {String} The error code message. For example, <code>This video is not authorized for this domain. Please contact the administrator</code>.
       */
      this.getErrorText = function() {
        // TODO[jigish]: figure out what to do here
        // TODO[gregm]: and hook up flash player as well
        return null;
      };

      /**
       * Retrieves the current player state. See {@link OO.STATE} for descriptions of the states.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">HTML5, Flash</p>
       *
       * @method getState
       * @memberOf OO.Player.prototype
       * @return {String} One of the following values:
       * <ul>
       *   <li><code>LOADING</code></li>
       *   <li><code>READY</code></li>
       *   <li><code>PLAYING</code></li>
       *   <li><code>PAUSED</code></li>
       *   <li><code>BUFFERING</code></li>
       *   <li><code>ERROR</code></li>
       *   <li><code>DESTROYED</code></li>
       * </ul>
       */
      this.getState = function() {
        return this.state;
      };

      /**
       * Retrieves the current volume on a best-effort basis according to underlying device limitations.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">HTML5, Flash</p>
       *
       * @method getVolume
       * @memberOf OO.Player.prototype
       * @return {Number} The volume, whose value is between 0 and 1, inclusive.
       */
      this.getVolume = function() {
        return this.volume;
      };

      this.skipAd = function() {
        this.mb.publish(OO.EVENTS.SKIP_AD);
      };

      /**
       * Retrieves all bitrate information, including
       * bitrates, bitrate qualities, target bitrates, and target bitrate qualities.
       * <p>For more information see
       * <a href="http://support.ooyala.com/developers/documentation/concepts/encodingsettings_videobitrate.html" target="target">Video Bit Rate</a>.</p>
       * <h5>Compatibility: </h5><p style="text-indent: 1em;">Flash</p>
       *
       *
       * @method getBitrateInfo
       * @memberOf OO.Player.prototype
       * @return {Array} An array containing all bitrate information, including
       * bitrates, bitrate qualities, target bitrates, and target bitrate qualities.
       * You can retrieve information from the array using the following indexes
       * (assume <code>bitrateInfo</code> is the returned object:
       * <ul>
       *   <li><code>bitrateInfo['bitrates']</code></li>
       *   <li><code>bitrateInfo['bitrateQualities']</code></li>
       *   <li><code>bitratesInfo['targetBitrate']</code></li>
       *   <li><code>bitrateInfo['targetBitrateQuality']</code></li>
       * </ul>
       * @see getBitratesAvailable
       * @see getBitrateQualitiesAvailable
       * @see getTargetBitrate
       * @see getTargetBitrateQuality
       * @see setTargetBitrate
       * @see setTargetBitrateQuality
       */
      this.getBitrateInfo = function() {
        return this.bitratesInfo;
      };

      /**
       * Retrieves the bitrate quality encodings that are available.
       * <p>For more information see
       * <a href="http://support.ooyala.com/developers/documentation/concepts/encodingsettings_videobitrate.html" target="target">Video Bit Rate</a>.</p>
       * <h5>Compatibility: </h5><p style="text-indent: 1em;">Flash</p>
       *
       *
       * @method getBitrateQualitiesAvailable
       * @memberOf OO.Player.prototype
       * @return {Array} An array of strings. The length of the array depends on the available encodings:
       * <ul>
       *   <li>1 encoding available: returns <code>['auto']</code></li>
       *   <li>2 encodings available: returns <code>['auto','low','high']</code></li>
       *   <li>3 or more encodings available: returns <code>['auto','low','medium','high']</code></li>
       *   <li>No bitrate quality information available: returns <code>['auto']</code></li>
       * </ul>
       * @see getBitratesAvailable
       * @see getBitrateInfo
       * @see getTargetBitrate
       * @see getTargetBitrateQuality
       * @see setTargetBitrate
       * @see setTargetBitrateQuality
       */
      this.getBitrateQualitiesAvailable = function() {
        return this.bitratesInfo['bitrateQualities'];
      };

      /**
       * Retrieves an array with the total number of bitrates, in kbps, or an empty array when the number of encodings is not available.
       * <p>For more information see
       * <a href="http://support.ooyala.com/developers/documentation/concepts/encodingsettings_videobitrate.html" target="target">Video Bit Rate</a>.</p>
       * <p><b><font color="red">NOTE: </font></b>With a Flash player you can retrieve the target bit rate, if you do so immediately.
       * However, this is not true for Quicktime, which does not permit you to control its ability to retrieve the bitrate. The default
       * with Quicktime is to use the suggested time on a best effort basis.</p>
       * <h5>Compatibility: </h5><p style="text-indent: 1em;">Flash</p>
       *
       *
       * @method getBitratesAvailable
       * @memberOf OO.Player.prototype
       * @return {Array} An array with the total number of bitrates, in kbps, or an empty array when the number of encodings is not available.
       * For example, <code>[250, 500, 1000]</code> indicates that three bitrates are available: 250 kbps, 500 kbps and 1000 kbps.
       * For a Flash-based Ooyala Player, you can use this API to get a list of available bitrates for use with the <code>{@link setTargetBitrate}()</code> API.
       * @see getBitrateInfo
       * @see getBitrateQualitiesAvailable
       * @see getTargetBitrate
       * @see getTargetBitrateQuality
       * @see setTargetBitrate
       * @see setTargetBitrateQuality
       */
      this.getBitratesAvailable = function() {
        return this.bitratesInfo['bitrates'];
      };

      /**
       * Retrieves the target bitrate quality.
       * <p>For more information see
       * <a href="http://support.ooyala.com/developers/documentation/concepts/encodingsettings_videobitrate.html" target="target">Video Bit Rate</a>.</p>
       * <h5>Compatibility: </h5><p style="text-indent: 1em;">Flash</p>
       *
       * @method getTargetBitrateQuality
       * @memberOf OO.Player.prototype
       * @return {String} The target bitrate quality, which may be one of the following values:
       * <ul>
       *   <li><code><code>'auto'</code></code></li>
       *   <li><code><code>'low'</code></code></li>
       *   <li><code><code>'medium'</code></code></li>
       *   <li><code><code>'high'</code></code></li>
       * </ul>
       * @see getBitratesAvailable
       * @see getBitrateQualitiesAvailable
       * @see getTargetBitrate
       * @see getBitrateInfo
       * @see setTargetBitrate
       * @see setTargetBitrateQuality
       */
      this.getTargetBitrateQuality = function() {
        return this.bitratesInfo['targetBitrateQuality'];
      };

      /**
       * Retrieves the target bitrate, in kpbs, if it was previously set.
       * <p>For more information see
       * <a href="http://support.ooyala.com/developers/documentation/concepts/encodingsettings_videobitrate.html" target="target">Video Bit Rate</a>.</p>
       * <h5>Compatibility: </h5><p style="text-indent: 1em;">Flash</p>
       *
       * @method getTargetBitrate
       * @memberOf OO.Player.prototype
       * @return {Number} The target bitrate, in kpbs, or <code>-1</code> if it was not previously set.
       * @see getBitratesAvailable
       * @see getBitrateQualitiesAvailable
       * @see getBitrateInfo
       * @see getTargetBitrateQuality
       * @see setTargetBitrate
       * @see setTargetBitrateQuality
       */
      this.getTargetBitrate = function() {
        return this.bitratesInfo['targetBitrate'];
      };

      /**
       * Sets the target bitrate, in kbps. You must specify an available bitrate. To determine which bitrates are available,
       * call <code>{@link getBitratesAvailable}()</code>. In OSMF, the target bitrate is adjusted to the nearest
       * matching lower available bitrate. Then the player attempts to change the bitrate to that value for the
       * upcoming chunk. In other modules the adjustment happens on usage when retrieving the upcoming chunk.
       * <br/><br/>
       * <p><b><font color="red">NOTE: </font></b>This setting does not carry over from video to video.
       * For example, consider a channel with two videos, the first havin its highest bitrate of 1000 kpbs,
       * and the second having a medium bitrate of 1000 kpbs and a highest bitrate of 2000 kpbs.
       * If you set the bitrate to 1000 kpbs, this number is converted to a bitrate quality (high in this example).
       * Since the bitrate quality carries over, the first video will play at 1000 kpbs, and the second video will play at 2000 kpbs,
       * which is its highest bitrate.</p>
       * <p>For more information see
       * <a href="http://support.ooyala.com/developers/documentation/concepts/encodingsettings_videobitrate.html" target="target">Video Bit Rate</a>.</p>
       * This is an asynchronous method and may return before having completed the operation.
       * If your logic depends on the completion of this operation, listen to the corresponding event.
       * <h5>Compatibility: </h5><p style="text-indent: 1em;">Flash</p>
       *
       * @method setTargetBitrate
       * @memberOf OO.Player.prototype
       * @param {Number} bitrate The target bitrate, in kbps.
       * @see getBitratesAvailable
       * @see getBitrateQualitiesAvailable
       * @see getTargetBitrate
       * @see getTargetBitrateQuality
       * @see getBitrateInfo
       * @see setTargetBitrateQuality
       */
      this.setTargetBitrate = function(bitrate) {
        this.mb.publish(OO.EVENTS.SET_TARGET_BITRATE, bitrate);
      };

      /**
       * Sets the target bitrate quality.
       * <p>For more information see
       * <a href="http://support.ooyala.com/developers/documentation/concepts/encodingsettings_videobitrate.html" target="target">Video Bit Rate</a>.</p>
       * This is an asynchronous method and may return before having completed the operation.
       * If your logic depends on the completion of this operation, listen to the corresponding event.
       * <h5>Compatibility: </h5><p style="text-indent: 1em;">Flash</p>
       *
       * @method setTargetBitrateQuality
       * @memberOf OO.Player.prototype
       * @param {String} bitrateQuality Specify one of the following values:
       * <ul>
       *   <li><code><code>'auto'</code></code></li>
       *   <li><code><code>'low'</code></code></li>
       *   <li><code><code>'medium'</code></code></li>
       *   <li><code><code>'high'</code></code></li>
       * </ul>
       * @see getBitratesAvailable
       * @see getBitrateQualitiesAvailable
       * @see getTargetBitrate
       * @see getTargetBitrateQuality
       * @see setTargetBitrate
       * @see getBitrateInfo
       */
      this.setTargetBitrateQuality = function(bitrateQuality) {
        this.mb.publish(OO.EVENTS.SET_TARGET_BITRATE_QUALITY, bitrateQuality);
      };

      /**
       * Retrieves a list of supported closed captions languages for the currently playing item.
       * This list is derived from the closed captions XML (DFXP [now TTML]) file for this content, uploaded via Backlot.
       * For more information about this file see
       * <a href"http://support.ooyala.com/developers/documentation/tasks/api_closed_captions_upload.html" target="target">Uploading and Viewing a Closed Captions File</a>.
       * If there is no DFXP (now TTML) file in place, this method returns an empty list. In live streaming mode,
       * the closed caption languages are derived from the stream itself.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">Flash</p>
       *
       * @method getCurrentItemClosedCaptionsLanguages
       * @memberOf OO.Player.prototype
       * @return {Array} A list of supported closed captions languages for the currently playing item.
       */
      this.getCurrentItemClosedCaptionsLanguages = function() {
        // TODO[gregm]: why not working???
        return this.closedCaptionsLanguages;
      };

      /**
       * Sets the language of the closed captions (CC) that will be shown in the player. If you do not upload the Closed Captions file,
       * the content will play back without closed captions. In Live streaming mode, the closed caption languages are derived
       * from the stream itself. Note that because of the way that closed captions are supported in iOS,
       * we are not able to add closed caption data for IOS web for remote assets.<br/><br/>
       * <p><b><font color="red">NOTE: </font></b> Because of the way that closed captions are supported in iOS,
       * closed caption data cannot be added for IOS web for remote assets.</p><br/>
       * <h5>Compatibility: </h5><p style="text-indent: 1em;">Flash</p>
       *
       * @method setClosedCaptionsLanguage
       * @memberOf OO.Player.prototype
       * @param {String} language Specify the ISO 639-1 language code. For example, specify <code>"en"</code>, <code>"de"</code>, or <code>"ja"</code>
       * for English, German, or Japanese.
       * Use <code>"zh-hans"</code> for Simplified Chinese and <code>"zh-hant"</code> for Traditional Chinese.
       * To show no closed captions, set the language to <code>"none"</code>.
       */
      this.setClosedCaptionsLanguage = function(language) {
        this.mb.publish(OO.EVENTS.SET_CLOSED_CAPTIONS_LANGUAGE, language);
      };

      this.insertCuePoint = function(type, preloadTime, duration) {
        this.mb.publish(OO.EVENTS.INSERT_CUE_POINT, type, preloadTime, duration);
      };

      /**
       * Subscribe to a specified event.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">HTML5, Flash</p><br/>
       *
       * @method subscribe
       * @memberOf OO.Player.prototype
       * @param {String} eventName The name of the event.
       * @param {String} subscriber The name of the subscriber to which the message bus will publish the event.
       * @param {Function} callback The function that will execute when the subscriber receives the event notification.
       */
      this.subscribe = function(eventName, subscriber, callback) {
        this.mb.subscribe(eventName, subscriber, function() {
          var argsArray = _.toArray(arguments);
          argsArray.unshift(callback);
          _.defer.apply(this, argsArray);
        } );
      };

      // give the creator a chance to initalize itself
      if(_.isFunction(this.parameters.onCreate)) {
        this.parameters.onCreate(this);
      }

      // announce player instance was created
      this.mb.publish(OO.EVENTS.PLAYER_CREATED, this.elementId, this.parameters);

      // initiate content loading
      if (this.embedCode) {
        this.setEmbedCode(embedCode, this.parameters);
      }
    };

    // Public Player API Class Methods
    OO.exposeStaticApi('Player', {
      // Creates player object and attaches it to the provided element.
      // If embed code is specified, the player will load that embed code video (only single video is supported)
      /**
       * Creates a player object and attaches it to the specified element.
       * This is an asynchronous method and will return before the player is completely initialized.
       * Listen for the <code>PLAYBACK_READY</code> event to determine whether the player is completely initialized.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">HTML5, Flash</p><br/>
       *
       * @method create
       * @memberOf OO.Player
       * @param {Number} elementId The ID of the element to which to attach the player object.
       * @param {Number} embedCode The embed code. The player will load the embed code video. Only a single video is supported.
       * @param {Object} parameters The player parameters. These can be used to customize player ads and behavior, and can determine player styles.
       * For more information, see <a href="http://support.ooyala.com/developers/documentation/api/player_v3_api_embedparams.html" target="target">Embedded Parameters</a>.
       * @return {Object} The created player object.
       */
      create: function(elementId, embedCode, parameters) {
        //check to see if routing matches player version
        if (OO.playerParams['core_version'] && OO.playerParams['core_version'] !== "3" && OO.playerParams['core_version'] !== 3) {
          //not v3 routing, so throw an error since v3 player doesn't accept any routing other than v3
          console.error("Error: A v3 player has been specified using a mismatching route. A v3 player can only be used with a v3 route.");
          return null;
        }

        if (OO.playerParams.platform === "flash-adset") {
          embedCode = OO.CONSTANTS.STANDALONE_AD_HOLDER;
        }

        if (typeof(window.console) != "undefined" && typeof(window.console.log) == "function") {
          console.log("V3 version: " + OO.playerParams['v3_version']);
          console.log("V3 version source: " + OO.playerParams['v3_version_source']);
        }
        // will not allow OO.players create twice for the same embedding element.
        if (!OO.players[elementId]) {
          OO.playerCount++;
          OO.players[elementId] = new OO.Player(elementId, embedCode, parameters);
        }
        return OO.players[elementId];
      },

      // Log to the Ooyala Debug Panel
      flashDebugCallback: function(msg) {
        window.postMessage({ type: "OO_LOG", text: msg }, "*");
      },

      /**
       * Isolates the specified player for debugging. <code>debug.ooyala.com</code> automatically generates a valid V3 embedded player.
       * When you call this on a player it automatically generates the corresponding <code>debug.ooyala.com</code> test page.
       * <br/><br/><h5>Compatibility: </h5><p style="text-indent: 1em;">HTML5, Flash</p><br/>
       *
       * @method isolate
       * @memberOf OO.Player.prototype
       * @param {String} targetPlayer The name of the <code>div</code> container in which to load the player.
       * @return url The link to the isolated player.
       */
      isolate:function(targetPlayer) {
        var url = "";

        // find the player
        var player;
        if (targetPlayer) {
          player = OO.players[targetPlayer];
        } else if (OO.playerCount > 1) {
          console.log("More than one player to choose.  Please specify the target div of the intended player as a parameter");
          console.log("Available players are: ", _.keys(OO.players));
          return _.keys(OO.players);
        } else if (OO.playerCount > 0) {
          // Get the only player available in the list
          player = _.values(OO.players)[0];
        }
        if (player) {
          url = "http://debug.ooyala.com/?";

          var pbid = OO.playerParams.playerBrandingId;
          var needsAmpersand = false;
          if (pbid) {
            url += "pbid=" + pbid;
            needsAmpersand = true;
          }

          var params = JSON.stringify(player.parameters);
          if (params) {
            if (needsAmpersand) {
              url += "&";
            }
            url += "options=" + encodeURIComponent(params);
            needsAmpersand = true;
          }

          var ec = player.embedCode;
          if (ec) {
            if (needsAmpersand) {
              url += "&";
            }
            url += "ec=" + ec;
            needsAmpersand = true;
          }


          // If this isn't local development or default, then there is a version specified
          if (OO.playerParams.environment !== "local-dev" && OO.playerParams.v3_version_source !== "default") {
            if (needsAmpersand) {
              url += "&";
            }
            url += "version=" + OO.playerParams.v3_version;
            needsAmpersand = true;
          }
          //We need to check if it is suppose to play a html5 player or not, so we check if the platform doesn't have flash in the string
          // and that if it doesn't then it is also not html5-fallback which would need to play the flash player.
          var environmentRF = OO.environmentRequiredFeatures;
          if (environmentRF.indexOf("html5-playback") > -1) {
            if (needsAmpersand) {
              url += "&";
            }
            url += "needsHtml5=true";
          }

          console.log("If you are copying this link, do not highlight. right click and press 'copy link address'");
        }

        return url;
      },

      __placeholder : 0
    });

  }(OO, OO._, OO.$));
(function(OO, _, $){
  /*
   *  Defines a module for simulating old style callbacks
   */
  var OldCallbacksModule = function(messageBus, id) {
    this.id = id;
    this.mb = messageBus;

    this.mb.subscribe(OO.EVENTS.PLAYER_CREATED, 'old_callbacks', _.bind(this._playerWasCreated,this));

    this.mb.subscribe(OO.EVENTS.PLAYING, 'old_callbacks', _.bind(this._playing,this));

  };

  _.extend(OldCallbacksModule.prototype, {
    _playerWasCreated: function(event, elementId, params) {
      if(params.oldStyleCallbackHandler) {
        this.playerId = elementId;
      }
    },

    _fireCustomerCallback: function(playerId, eventName, params) {
      var i;

      if (!window.OOYALA_PLAYER_JS.customerCallbackName) {return;}
      try {
        var args = [playerId, eventName, params];
        var namespaces = window.OOYALA_PLAYER_JS.customerCallbackName.split(".");
        var func = namespaces.pop();
        var context = window;
        for (i = 0; i < namespaces.length; i++) {
          context = context[namespaces[i]];
        }
        if (context && typeof(context[func]) === 'function') {
          context[func].apply(this, args);
        }
      } catch (error) {
        var errorMsg = "Severe, cannot invoke function:" + error.toString();
        if (window.console && typeof window.console.log == 'function') { console.log(errorMsg); }
      }
    },

    _playing: function() {
      if(this.playerId) {
        this._fireCustomerCallback(this.playerId, 'stateChanged', {state:'playing'});
      }
    },

    __end_marker : true

  });

  OO.registerModule('old_callbacks', function(messageBus, id) {
    return new OldCallbacksModule(messageBus, id);
  });
}(OO, OO._, OO.$));
(function(OO,_,$) {
  //local constants
  var IFRAME_URL = _.template('<%=server%>/ooyala_storage.html')({ server: OO.SERVER.API });
  var DOMAIN = OO.SERVER.API;
  var IFRAME_LOAD_MESSAGE = "LOADED";
  var IFRAME_LOAD_TIMEOUT = 3000;
  var IFRAME_STATE_INIT = 0;
  var IFRAME_STATE_ERROR = 1;
  var IFRAME_STATE_READY = 2;

  var iframeState = IFRAME_STATE_INIT; //state of iframe
  var postMessageQueue = []; //messages waiting until iframe ready
  var callbacks = {}; //Store Callback functions
  var errorTimeout = null;

  //add iframe
  var iframe = document.createElement('iframe');
  iframe.style.display = "none";
  iframe.src = IFRAME_URL;

  $(document).ready(function() {
    document.body.appendChild(iframe);
    errorTimeout = setTimeout(function() {
      onIframeLoaded(IFRAME_STATE_ERROR);
    }, IFRAME_LOAD_TIMEOUT);
  });

  //add event listener
  if (window.addEventListener) {
    window.addEventListener("message", onMessage, false);
  } else if (window.attachEvent) {
    window.attachEvent("onmessage", onMessage);
  }

  function onMessage(event) {
    if (event.origin !== DOMAIN) { return; }

    //listen for loaded message
    if (event.data === IFRAME_LOAD_MESSAGE) {
      clearTimeout(errorTimeout);
      onIframeLoaded(IFRAME_STATE_READY);
      return;
    }
    var msg = null;
    try { msg = OO.JSON.parse(event.data); } catch(e) {} //do nothing, will be caught by next line

    if (!msg || !msg.callback) { return; } //result can be null

    if (callbacks[msg.callback]) {
      callbacks[msg.callback](msg.result);
      delete callbacks[msg.callback];
    }
  }

  function onIframeLoaded(state) {
    var a;
    iframeState = state;
    while((a = postMessageQueue.pop()) != undefined) {
      callPostMessage(a[0], a[1], a[2]);
    }
  }

  function callPostMessage(method, args, callback) {
    if (iframeState === IFRAME_STATE_INIT) {
      postMessageQueue.push(arguments);
      return;
    }

    if (iframeState === IFRAME_STATE_ERROR || !iframe.contentWindow.postMessage) {
      var result;
      if (method == "setItem") {
        result = OO[method].apply(OO.localStorage, args);
      } else {
        result = OO.localStorage[method].apply(OO.localStorage, args);
      }
      if(!!callback) {
        callback(result);
      }
    } else {
      var msg = {
        method: method,
        arguments: args,
        callback: Math.random().toString(36).substring(7) //random id
      };
      callbacks[msg.callback] = callback;
      iframe.contentWindow.postMessage(JSON.stringify(msg), DOMAIN);
    }
  }

  OO.ooyalaStorage = {
    getItem: function(key, callback) {
      callPostMessage("getItem", [key], callback);
    },
    key: function(keyId, callback) {
      callPostMessage("key", [keyId], callback);
    },
    setItem: function(key, value, callback) {
      callPostMessage("setItem", [key, value], callback);
    },
    removeItem: function(key, callback) {
      callPostMessage("removeItem", [key], callback);
    },
    hasOwnProperty: function(key, callback) {
      callPostMessage("hasOwnProperty", [key], callback);
    }
  };
  if (!!OO.TEST_TEST_TEST) {
    OO.ooyalaStorage._getIframeState = function() {
      return iframeState;
    };
  }
}(OO, OO._, OO.$));
(function(OO,_,$) {
  callbackQueue = [];
  OO.GUID = undefined;

  OO.ooyalaStorage.getItem("ooyala_guid", _.bind(function(value) {
    if (value) {
      OO.GUID = value;
    } else {
      OO.GUID = generateDeviceId();
      OO.ooyalaStorage.setItem("ooyala_guid", OO.GUID);
    }
    while((callback = callbackQueue.pop()) != undefined) {
      callback(OO.GUID);
    }
  }), this);

  OO.publicApi.getGuid = OO.getGuid = function(callback) {
    if (OO.GUID) {
      if (typeof callback === "function") {
        try {
          callback(OO.GUID);
        } catch (e) {
          //do nothing on error
        }
      }
    } else {
      callbackQueue.push(callback);
    }
  };

  generateDeviceId = function() {
    var randomString = (new Date().getTime()) + window.navigator.userAgent + Math.random().toString(16).split(".")[1];
    return new OO.jsSHA(randomString, 'ASCII').getHash('SHA-256', 'B64');
  };

  OO.plugin("DeviceId", function(OO, _, $, W) {
    return function(mb, id) {
      mb.subscribe(OO.EVENTS.PLAYER_CREATED, "DeviceId", function() {
        OO.publicApi.getGuid(function(guid) {
          mb.publish(OO.EVENTS.GUID_SET, guid);
        });
      });
    };
  });

}(OO, OO._, OO.$));
(function(OO, $, _){
  /*
   *  Defines a basic chromeless UI
   */
  var ChromelessUi = function(messageBus, id) {
    this.id = id;
    this.mb = messageBus;
    this.resizeTimer = null;
    this.width = 0;
    this.height = 0;
    this.useCustomControls = !OO.uiParadigm.match(/mobile/);
    this.useNativeControls = !!OO.uiParadigm.match(/native/);

    OO.StateMachine.create({
      initial:'Init',
      messageBus:this.mb,
      moduleName:'ChromelessUi',
      target:this,
      events:[
        {name:OO.EVENTS.PLAYER_CREATED,         from:'Init',        to:'PlayerCreated'},
        {name:OO.EVENTS.EMBED_CODE_CHANGED,     from:'*'},
        {name:OO.EVENTS.ERROR,                  from:'*'},
        {name:OO.EVENTS.PLAY,                   from:'*'},
        {name:OO.EVENTS.WILL_CHANGE_FULLSCREEN, from:'*'},
        {name:OO.EVENTS.FULLSCREEN_CHANGED,     from:'*'},
        {name:OO.EVENTS.STREAM_PLAYING,         from:'*'},
        {name:OO.EVENTS.INITIAL_PLAY,           from:'*'},
        {name:OO.EVENTS.WILL_PLAY_ADS,          from:'*'},
        {name:OO.EVENTS.PLAY_MIDROLL_STREAM,    from:'*'},
        {name:OO.EVENTS.PLAYING,                from:'*'},
        ]
    });
  };

  _.extend(ChromelessUi.prototype, {
    onPlayerCreated: function(event, elementId, params) {
      this.elementId = elementId;
      this.topMostElement = $('#'+this.elementId);
      this.topMostElement.append('<div class="innerWrapper"></div>');
      this.rootElement = this.topMostElement.find("div.innerWrapper");
      this.params = params;

      var topMostWidth = this.topMostElement.width();
      var topMostHeight = this.topMostElement.height();

      if (topMostWidth == 0 || topMostHeight == 0) {
        this.topMostElement.css({width: '100%', height: '100%'});
      }

      // add root container css:
      var width = params.width || '100%';
      var height = params.height || '100%';

      if(_.isNumber(width)) {
        width = width + 'px';
      }

      if(_.isNumber(height)) {
        height = height + 'px';
      }

      var rootCss = _.template(OO.get_css("root"))({

        errorIcon : OO.get_img_base64('icon_error'),
        elementId : this.elementId
      }).replace("width:0;", "width:" + width + ';').replace("height:0;", "height:" + height + ';');

      OO.attachStyle(rootCss,this.elementId);


      //error screen UI
      this.rootElement.append('<div class="oo_error" style="display:none"></div>');
      this.errorUi = new _ErrorUi(this.rootElement.find('div.oo_error'));

      // plugins placeholder, don't create it for Flash playback
      if (!OO.requiredInEnvironment("flash-playback")) {
        this.rootElement.append("<div class='plugins' style='display:none'></div>");
      }

      // bind UI events.
      var fullscreenEvents = ["fullscreenchange", "webkitfullscreenchange"];
      var onBrowserOriginatedFullscreenChange = _.bind(this._onBrowserOriginatedFullscreenChange, this);
      var rootElement = this.rootElement;
      _.each(fullscreenEvents, function(e) { rootElement.on(e, onBrowserOriginatedFullscreenChange); });
      // https://developer.mozilla.org/en/DOM/Using_full-screen_mode
      // Mozilla is dispatching the fullscreen event to the document object instead of the dom object that
      // change to full screen.
      // TODO, keep an eye on the doc if they change the notification to the dom element instead.
      $(document).on("mozfullscreenchange", onBrowserOriginatedFullscreenChange);
      document.onwebkitfullscreenchange = onBrowserOriginatedFullscreenChange;
      $(document).on("MSFullscreenChange", onBrowserOriginatedFullscreenChange);
      //$(document).on("webkitfullscreenchange", onBrowserOriginatedFullscreenChange);
      rootElement.resize(_.bind(this._onResize, this));
      $(document).resize(_.bind(this._onResize, this));
      $(window).resize(_.bind(this._onResize, this));

      // BeforeUnload Event
      $(window).on("beforeunload", _.bind(this._onBeforeUnload, this));
    },

    onEmbedCodeChanged: function(event, embedCode) {
      this.errorUi.hide();
      if (!OO.isIos && !this.useNativeControls) {
        this.rootElement.find('div.plugins').hide();
      }
    },

    onError: function(event, error) {
      if(error && error.source != 'flash') {  // don't show empty errors or flash errors
        this.mb.publish(OO.EVENTS.PAUSE);
        this.errorUi.show(error);
      }
    },

    onStreamPlaying: function(event) {
      if (this.errorUi) { this.errorUi.hide(); }
      this._updatePlayingUi();
    },

    _isFullscreen: function() {
      if (this.rootElement.hasClass("fullscreen")) { return true; }
      var isFullscreen = document.fullscreen || document.mozFullScreen || document.webkitIsFullScreen ||
        document.webkitDisplayingFullscreen || document.msFullscreenElement;
      return !!isFullscreen;
    },

    _onBrowserOriginatedFullscreenChange: function() {
      OO.d('Fullscreen Changed',this._isFullscreen());
      this.mb.publish(OO.EVENTS.SIZE_CHANGED, this.rootElement.width(), this.rootElement.height());
      this.mb.publish(OO.EVENTS.FULLSCREEN_CHANGED, this._isFullscreen());
    },

    onFullscreenChanged: function(event, isFullscreen) {
      if(isFullscreen) {
        // increase the z-index of the player before going to fullscreen, to make sure it won't be behind other players
        // some browsers unfortunately show through elements with higher z-index even when in fullscreen mode
        this.originalZ = this.rootElement.css('z-index');
        this.originalOverflow = this.rootElement.css("overflow");
        this.rootElement.css('z-index', this.originalZ + 1000);
        this.rootElement.css('overflow','visible');
      } else {
        // reset the z-index of the player before exiting fullscreen, to make sure it is back to same level as other players
        // some browsers unfortunately show through elements with higher z-index even when in fullscreen mode
        this.rootElement.css('z-index', this.originalZ);
        this.rootElement.css("overflow", this.originalOverflow);

        if (!OO.isIos && !!OO.uiParadigm.match(/native/) && !OO.uiParadigm.match(/mobile/)) {
          this.rootElement.find('div.plugins').hide();
        }
      }
    },

    _onResize: function() {
      if(this.resizeTimer) {
        clearTimeout(this.resizeTimer);
      }
      this.resizeTimer = _.delay(_.bind(function() {
        if (this.width != this.rootElement.width() && this.height != this.rootElement.height()) {
          this.width = this.rootElement.width();
          this.height = this.rootElement.height();
          this.mb.publish(OO.EVENTS.SIZE_CHANGED, this.width, this.height);
        }
      }, this), 100);
    },

    onPlay: function() {
      if(!this.useCustomControls && !this.useNativeControls) {
        this.mb.publish(OO.EVENTS.WILL_CHANGE_FULLSCREEN, true);
      }
    },

    onWillChangeFullscreen: function(event, shouldEnterFullscreen) {
      if (!this.useNativeControls && !this.useCustomControls) { return; }
      if (shouldEnterFullscreen) {
        this._showFullscreen();
      } else {
        this._hideFullscreen();
      }
    },

    onInitialPlay: function() {
      if (!OO.isIos && !this.useNativeControls) {
        this.rootElement.find('div.plugins').show();
      }
    },

    onWillPlayAds: function() {
      this._updatePlayingUi();
    },

    onPlayMidrollStream: function() {
      this._updatePlayingUi();
    },

    onPlaying: function() {
      this._updatePlayingUi();
    },

    _getActiveVideo: function() {
      var mainVideo = this.rootElement.find("video.video");
      var midrollVideo = this.rootElement.find("video.midroll");
      var activeVideo = mainVideo.get(0);
      var pluginVideo = this.rootElement.find("div.plugins video").get(0);
      if ( this._isVideoDomVisible("video.midroll") ) {
         activeVideo = midrollVideo.get(0);
      } else if ( pluginVideo && !this._isVideoDomVisible("video.video") ) {
         activeVideo = pluginVideo;
      }
      return activeVideo;
    },

    _showFullscreen: function() {
      var el = this.rootElement[0];
      var activeVideo = this._getActiveVideo();
      var fullscreenApi = el.requestFullScreen || el.requestFullscreen || el.mozRequestFullScreen ||
            el.webkitRequestFullScreen || el.msRequestFullscreen;
      if ((!fullscreenApi || (OO.isAndroid && !OO.isChrome)) && activeVideo && activeVideo.webkitEnterFullscreen) {
        // this uglyness is cause mobile chrome on android claims to support full screen on divs (next method), but doesn't actually work
        // however we still prefer to use div fullscreen on anything else so we only try this if android is detected
        // update: Chrome on Android looks to properly support the fullscreen API for divs, so now we check
        // specifically for the native browser which still does not.
        activeVideo.isFullScreenMode = true;
        activeVideo.webkitEnterFullscreen();
      } else if (fullscreenApi) {
        $(activeVideo).css("background-color","black");
        fullscreenApi.call(el);
      } else {
        this.rootElement.addClass("fullscreen");
      }
      this.mb.publish(OO.EVENTS.FULLSCREEN_CHANGED, true);
    },

    _hideFullscreen: function() {
      var activeVideo = this._getActiveVideo();
      if (document.cancelFullScreen) {
        document.cancelFullScreen();
      } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
      } else if (document.webkitCancelFullScreen) {
        document.webkitCancelFullScreen();
      } else if (activeVideo && activeVideo.webkitExitFullscreen) {
        activeVideo.isFullScreenMode = false;
        activeVideo.webkitExitFullscreen();
      } else if (document.msExitFullscreen) {
        document.msExitFullscreen();
      } else {
        this.rootElement.removeClass("fullscreen");
      }

      $(activeVideo).css("background-color","");
      this.mb.publish(OO.EVENTS.FULLSCREEN_CHANGED, false);
    },

    _isVideoDomVisible: function(domSelector) {
       return (this.rootElement.find(domSelector).css("left") == OO.CSS.VISIBLE_POSITION);
    },

    _onBeforeUnload: function(event) {
      // A still user-cancellable page unload request has been made.
      this.mb.publish(OO.EVENTS.PAGE_UNLOAD_REQUESTED, true);
    },

    _updatePlayingUi: function() {
      if (!OO.isIos) {
        this.rootElement.find('div.plugins').show();
      }
    },

    __placeholder: true
  });

    var _ErrorUi = function(container) {
      this.container = container;
      this.container.append('<div class="oo_error_image"></div>');
      this.container.append('<div class="oo_error_message"><h1 class="oo_error_message_text"></h1></div>');
    };

    _.extend(_ErrorUi.prototype, {
      show: function(error) {
        this.container.find('h1.oo_error_message_text').html(OO.getLocalizedMessage(error.code));
        this.container.show();
      },
      hide: function() {
        this.container.hide();
      }
    });
  OO.registerModule('chromeless_ui', function(messageBus, id) {
    return new ChromelessUi(messageBus, id);
  });
}(OO, OO.$, OO._));
  (function(OO, _, $) {
    /*
     *  Defines the wrapper of video element on the page, reduce the different state introduced by different browser
     *  to a finate state that our PlayBack module cares about.
     * Reference page:
     * http://www.w3.org/2010/05/video/mediaevents.html
     * http://www.chipwreck.de/blog/2010/03/01/html-5-video-dom-attributes-and-events/
     * http://developer.apple.com/library/safari/#documentation/AudioVideo/Conceptual/Using_HTML5_Audio_Video/Introduction/Introduction.html
     */
    OO.VideoElementWrapper = OO.inherit(OO.Emitter, function(video) {
      this._video = video; // video is the dom object of video tag on the page.
      this._readyToPlay = true;
      this._playQueued = false;
      this.canAccessBufferAttribute = true;
      this.Id = OO.getRandomString();
      this.isM3u8 = false;
      this.videoEnded = false;
      this.isPlaying = false;
      this._currentUrl = '';
      this._emitErrors = true;
      this._emitErrorsTimer = null;
      this._unemittedErrors = [];
      this._loop = false;
      this._isBuffering = false;
    });

    _.extend(OO.VideoElementWrapper, {
      FULL_SCREEN_CHANGED: 'fullScreenChanged',
      WILL_PLAY: 'willPlay',
      PLAYING: 'playing',
      PAUSED: 'paused',
      SEEKING: 'seeking',
      SEEKED: 'seeked',
      BUFFERING: 'buffering',
      BUFFERED: 'buffered',
      ERROR: 'error',
      PLAYHEAD_TIME_CHANGED: 'playheadTimeChanged',
      PLAYED: 'played',
      VOLUME_CHANGED: 'volumeChanged',
      DURACTION_CHANGED: 'durationChanged',
      PLAY_NEXT: 'playNext',
      DOWNLOADING: 'downloading',
      __placeholder:true
    });

    _.extend(OO.VideoElementWrapper.prototype, {
      setup: function(params) {
        var events = {
          "loadstart": _.bind(this.onLoadStart, this), // Browser starts loading data
          "progress": _.bind(this.onProgress, this), // Browser loads data
          "suspend": _.bind(this.onSuspend, this), // Browser does not load data, waiting
          "abort": _.bind(this.onAbort, this), // Data loading was aborted
          "error": _.bind(this.onError, this), // An error occured
          "emptied": _.bind(this.onEmptied, this), // Data not present unexpectedly
          "stalled": _.bind(this.onStalled, this), // Data transfer stalled
          "play": _.bind(this.onPlay, this), // Video started playing (fired with play())
          "pause": _.bind(this.onPause, this), // Video has paused (fired with pause())
          "loadedmetadata": _.bind(this.onLoadedMetaData, this), // Metadata loaded
          "loadeddata": _.bind(this.onLoadedData, this), // Data loaded
          "waiting": _.bind(this.onWaiting, this), // Waiting for more data
          "playing": _.bind(this.onPlaying, this), // Playback started
          "canplay": _.bind(this.onCanPlay, this), // Video can be played, but possibly must stop to buffer content
          "canplaythrough": _.bind(this.onCanPlayThrough, this), // Enough data to play the whole video
          "seeking": _.bind(this.onSeeking, this), // seeking is true (browser seeks a position)
          "seeked": _.bind(this.onSeeked, this), // seeking is now false (position found)
          "timeupdate": _.bind(this.onTimeUpdate, this), // currentTime was changed
          "ended": _.bind(this.onEnded, this), // Video has ended
          "ratechange": _.bind(this.onRateChange, this), // Playback rate has changed
          "durationchange": _.bind(this.onDurationChange, this), // Duration has changed (for streams)
          "volumechange": _.bind(this.onVolumeChange, this), // Volume has changed
          "volumechangeNew": _.bind(this.onVolumeChange, this), // Volume has changed
          "webkitbeginfullscreen": _.bind(this.onFullScreenBegin, this), // ios webkit browser fullscreen event
          "webkitendfullscreen": _.bind(this.onFullScreenEnd, this), // ios webkit browser fullscreen event
          "webkitfullscreenchange": _.bind(this.onFullScreenChange, this) // webkit browser fullscreen event
        };
        _.each(events, function(v, i) { $(this._video).on(i, v); }, this);

        if (params && params.loop) {
          this.loop = params.loop;
        }
      },

      /*   Public getter function */

      setEmbedCode: function(embedCode) {
        this.isPlaying = false;
      },

      getIsActive: function() {
        return $(this._video).css("left") == "0px";
      },

      getStreamUrl: function() {
        return this._currentUrl;
      },

      resetStreamUrl: function() {
        this._currentUrl = "";
      },

      getVolume: function() {
        return this._video.volume;
      },

      getCurrentTime: function() {
        return this._video.currentTime;
      },

      getSeekableRange: function() {
        return OO.safeSeekRange(this._video.seekable); // in seconds;
      },

      getDuration: function() {
        if (this._video.duration === Infinity || isNaN(this._video.duration)) {
          // TODO, if we can not extract duration, we should use the value from the movie table
          // for vast ads, use the value in the duration field.
          return 0;
        }
        return this._video.duration; // in seconds;
      },

      getBuffer: function() {
        if (this._video.buffered && this._video.buffered.length > 0) {
          return this._video.buffered.end(0); // in sec;
        }
        return  0;
      },

      getOriginVideoWidth: function() {
        return this._video.videoWidth;
      },

      getOriginVideoHeight: function() {
        return this._video.videoHeight;
      },

      hasBrowserDefaultControl: function() {
        return this._video.controls;
      },

      /******* Start public method ******/

      setPosterUrl: function(url) {
        this._video.poster = url; // thumbnail image on start screen.
      },

      // Allow for the video src to be changed without loading the video
      // @param url: the new url to insert into the video element's src attribute
      setVideoUrl: function(url) {
        // check if we actually need to change the URL on video tag
        // compare URLs but make sure to strip out the trailing cache buster
        var urlChanged = false;
        if (this._currentUrl.replace(/[\?\&]_=[^&]+$/,'') != url) {
          this._currentUrl = url || "";

          // bust the chrome stupid caching bug
          if(this._currentUrl.length > 0 && OO.isChrome) {
            this._currentUrl = this._currentUrl + (/\?/.test(this._currentUrl) ? "&" : "?") +"_="+OO.getRandomString();
          }

          this.isM3u8 = (this._currentUrl.toLowerCase().indexOf("m3u8") > 0);
          this._readyToPlay = false;
          urlChanged = true;
          this._video.src = this._currentUrl;
        }

        if(_.isEmpty(url)) {
          this.trigger(OO.VideoElementWrapper.ERROR, 0); //0 -> no stream
        }
        return urlChanged;
      },

      load: function(rewind) {
        if(!!rewind) {
          try {
            if (OO.isIos && OO.iosMajorVersion == 8) {
              $(this._video).one("durationchange", _.bind(function() {
                this._video.currentTime = 0;}, this));
            } else {
              this._video.currentTime = 0;
            }
            this._video.pause();
          } catch (ex) {
            // error because currentTime does not exist because stream hasn't been retrieved yet
            OO.log('Failed to rewind video, probably ok');
          }
        }
        this._video.load();
      },

      reload: function() {
        this._video.load();
      },

      play: function() {
        this._video.play();
        this.isPlaying = true;
      },

      pause: function() {
        this._playQueued = false;
        this._video.pause();
        this.isPlaying = false;
      },

      safeSeekTime: function(time) {
        var safeTime = time >= this._video.duration ? this._video.duration - 0.01 : (time < 0 ? 0 : time);
        // iPad with 6.1 has an intersting bug that causes the video to break if seeking exactly to zero
        if(OO.isIpad && safeTime < 0.1) { safeTime = 0.1; }
        return safeTime;
      },

      canSeekToTime: function(time) {
        var range = this.getSeekableRange();
        if (range.start === 0 && range.end === 0) { return false; }
        var safeTime = this.safeSeekTime(time);
        if (range.start <= safeTime && range.end >= safeTime) { return true; }
        return false;
      },

      seek: function(time) {
        if (this.canSeekToTime(time)) {
          this._video.currentTime = this.safeSeekTime(time);
          return true;
        }
        this.queueSeek(time);
        return false;
      },

      queueSeek: function(time) {
        this.queuedSeekTime = time;
      },

      dequeueSeek: function() {
        if (this.queuedSeekTime === undefined) { return; }
        if (this.seek(this.queuedSeekTime)) { this.queuedSeekTime = undefined; }
      },

      setVolume: function(value) {
        if (typeof(value) !== "number" || value < 0 || value > 1) {
          OO.d("can not assign volume with invalid value", value);
          return;
        }
        //  TODO check if we need to capture any exception here. ios device will not allow volume set.
        this._video.volume = value;
      },

      delayErrorPublishing: function(e) {
        OO.d(e);
        // User-cancellable event beforeUnload has been dispatched to window.
        // Prevent errors to be dispatched due to the video element being destroyed.
        this._emitErrors = false;
        // Clear previous timeout in case the user selected "stay" and then
        // navigated away again, otherwise the error may get emitted on low bandwidth.
        clearTimeout(this._emitErrorsTimer);
        this._emitErrorsTimer = null;
        // Restore error dispatching after a timeout.
        _.delay(_.bind(function() {
          // This will happen after the user clicks on "leave" or "stay" in case
          // the embedding webpage adds another listener which gives the option.
          this._emitErrorsTimer = _.delay(_.bind(function() {
            // After 5 seconds it is assumed the user stayed on the page.
            // Any errors that occurred after selecting to "stay" and before
            // the time limit are dispatched.
            this._emitErrors = true;
            _.each(this._unemittedErrors, function(e) {
              this._emitError(e.error , e.code);
            });
            this._unemittedErrors.length = 0;
          }, this), 5000);
        }, this), 1);
      },

      onLoadStart: function(e) {
        OO.d(e.type, this._video.src);
        this._currentUrl = this._video.src;
      },

      onProgress: function(e) {
        OO.d(e.type);
        this.trigger(OO.VideoElementWrapper.DOWNLOADING);
      },

      onSuspend: function(e) {
        OO.d(e.type);
      },

      onAbort: function(e) {
        OO.d(e.type, this._currentUrl);
      },

      // HTML5 Media Error Constants:
      // MediaError.MEDIA_ERR_ABORTED = 1
      // MediaError.MEDIA_ERR_NETWORK = 2
      // MediaError.MEDIA_ERR_DECODE = 3
      // MediaError.MEDIA_ERR_SRC_NOT_SUPPORTED = 4
      // MediaError.MEDIA_ERR_ENCRYPTED = 5 (Chrome only)
      // Ooyala Extensions:
      // NO_STREAM = 0
      // UNKNOWN = -1
      onError: function(e) {
        var code = this._video.error ? this._video.error.code : -1;
        if (this._emitErrors) {
          this._emitError(e, code);
        } else {
          // The error occurred when the page was probably unloading.
          // Happens more often on low bandwith.
          OO.d("Error not emitted: " + e.type);
          this._unemittedErrors.push({error : e, code : code});
          this.mb.publish(OO.EVENTS.PAGE_PROBABLY_UNLOADING);
        }
      },

      onEmptied: function(e) {
        OO.d(e.type);
      },

      onStalled: function(e) {
        OO.d(e.type);
        // Fix multiple video tag error in iPad
        if (OO.isIpad && this._video.currentTime === 0) {
          this._video.pause();
        }
      },

      onPlay: function(e) {
        OO.d(e.type);
        this.trigger(OO.VideoElementWrapper.WILL_PLAY);
      },

      onPause: function(e) {
        OO.d(e.type, {paused: this._video.paused, ended: this._video.ended});
        this.trigger(OO.VideoElementWrapper.PAUSED);
        this.isPlaying = false;
      },

      onLoadedMetaData: function(e) {
        OO.d(e.type);
      },

      onLoadedData: function(e) {
        OO.d(e.type);
      },

      onWaiting: function(e) {
        OO.d(e.type);
        this._isBuffering = true;
        this.trigger(OO.VideoElementWrapper.BUFFERING);
      },

      onPlaying: function(e) {
        OO.d(e.type);
        this._playQueued = false;
        this.videoEnded = false;
        this.isPlaying = true;
        this.trigger(OO.VideoElementWrapper.PLAYING);
      },

      onCanPlay: function(e) {
        OO.d(e.type, this._video.readyState);
      },

      onCanPlayThrough: function(e) {
        this._isBuffering = false;
        this.trigger(OO.VideoElementWrapper.BUFFERED);
        OO.d(e.type, this._video.readyState);
      },

      onSeeking: function(e) {
        OO.d(e.type);
        this.trigger(OO.VideoElementWrapper.SEEKING);
      },

      onSeeked: function(e) {
        OO.d(e.type);
        this.trigger(OO.VideoElementWrapper.SEEKED);
      },

      onTimeUpdate: function(e) {
        this.trigger(OO.VideoElementWrapper.PLAYHEAD_TIME_CHANGED);
        if (!OO.isIos) {
          return;
        }
        // NOTE[jigish]: iOS has issues seeking so if we queue a seek handle it here
        this.dequeueSeek();
        // This is a hack fix for m3u8, current iOS has a bug that if the m3u8 EXTINF indication a different
        // duration, the ended event never got dispatched. Monkey patch here to manual trigger a onEnded event
        // need to wait OTS to fix their end.
        var duration = this.getDuration();
        var durationInt = Math.floor(duration);
        if (this.isM3u8 && this.getCurrentTime() == duration && duration > durationInt) {
          OO.log("manually triggering end", this._currentUrl, duration, this.getCurrentTime());
          _.delay(_.bind(this.onEnded, this), 0, e);
        }
      },

      onEnded: function(e) {
        OO.d(e.type);
        if (this.videoEnded) { return; } // no double firing ended event.
        this.videoEnded = true;

        this.trigger(OO.VideoElementWrapper.PLAYED);

        if (OO.isSafari && this.isM3u8) {
          if (this._isBuffering) {
            // XXX HACK: PBW-3392 - video element on Safari browser sends waiting event for HLS assets,
            // which results in firing BUFFERING event right before the end, so we want to clear it here
            this.onCanPlayThrough(e);
          }

          if (this.loop) {
            // XXX HACK: PBW-3352 - loop doesn't work on Safari browsers, manually restart after video ends
            this.reload();
            this.play();
          }
        }

        this.trigger(OO.VideoElementWrapper.PLAY_NEXT);
      },

      onRateChange: function(e) {
        OO.d(e.type);
      },

      onDurationChange: function(e) {
        OO.d(e.type);
        this.trigger(OO.VideoElementWrapper.DURATION_CHANGED);
      },

      onVolumeChange: function(e) {
        OO.d(e.type);
        this.trigger(OO.VideoElementWrapper.VOLUME_CHANGED);
      },

      onFullScreenChange: function(e) {
        OO.d(e.type);
      },

      onFullScreenBegin: function(e) {
        OO.d(e.type);
        this.trigger(OO.VideoElementWrapper.FULL_SCREEN_CHANGED, true);
      },
      onFullScreenEnd: function(e) {
        OO.d(e.type);
        this.trigger(OO.VideoElementWrapper.FULL_SCREEN_CHANGED, false, this._video.paused);
      },

      show: function(visible) {
        $(this._video).css('left', visible ? OO.CSS.VISIBLE_POSITION : OO.CSS.INVISIBLE_POSITION);
      },

      _emitError: function(error, errorCode) {
          OO.d(error.type);
          this.trigger(OO.VideoElementWrapper.ERROR, errorCode);
      },

      _asyncTriggerEvent: function(eventName) {
        _.delay(_.bind(function(){ this.trigger(eventName); }, this), 0);
      },

      kill: function() {
        this.pause();
        this._video.src = '';
      },

      __placeholder: true
    });


  }(OO, OO._, OO.$));
  (function(OO, _, $){
    OO.createVideoElementWrapper = function(parentContainer, className, params) {
      var wrapper = null;
      OO.d("Using HTML5 Playback");
      var v = $("<video>");
      v.attr("class", className);

      // NOTE(neeraj): add preload=none to video dom element to prevent automatic fetching of video stream
      // we manually force a preload in _preloadStream
      v.attr("preload", "none");

      // enable airplay for ios.
      // http://developer.apple.com/library/safari/#documentation/AudioVideo/Conceptual/AirPlayGuide/OptingInorOutofAirPlay/OptingInorOutofAirPlay.html
      if (OO.isIos) {
        v.attr("x-webkit-airplay", "allow");
      }
      parentContainer.append(v);
      wrapper = new OO.VideoElementWrapper(v[0]);
      wrapper.setup(params);
      return wrapper;
    };


  }(OO, OO._, OO.$));
  (function(OO,_,$){
    /*
     *  Defines the playback controller
     */
    var PlaybackControlModule = function(messageBus, id) {
      if (!OO.requiredInEnvironment('html5-playback') && !OO.requiredInEnvironment('cast-playback')) { return; }

      this.mb = messageBus;
      this.id = id;
      this.inlineAds = [];
      this.waitForPlaybackReady = true;
      this.isInlineAdsPlaying = false;
      this.currentMainVideoPlayhead = 0;
      this.skipPrerollAdsCheck = false;
      this.userRequest = '';
      this.playedAtLeastOnce = false;
      this.adsManagerHandlingAds = false;
      this.playInFlight = false;

      OO.StateMachine.create({
        initial:'Init',
        messageBus:this.mb,
        moduleName:'PlaybackControl',
        target:this,
        events:[
          {name:OO.EVENTS.PLAYER_CREATED,                     from:'*'},
          {name:OO.EVENTS.EMBED_CODE_CHANGED,                 from:'*',                                                                to:'WaitingForApiResponse'},
          {name:OO.EVENTS.CONTENT_TREE_FETCHED,               from:'WaitingForApiResponse'},
          {name:OO.EVENTS.METADATA_FETCHED,                   from:'WaitingForApiResponse'},
          {name:OO.EVENTS.AUTHORIZATION_FETCHED,              from:['WaitingForApiResponse', 'PlaybackReady']},
          {name:OO.EVENTS.AD_AUTHORIZATION_FETCHED,           from:'*'},
          {name:OO.EVENTS.PLAYBACK_READY,                     from:'WaitingForApiResponse',                                            to:'PlaybackReady'},
          {name:OO.EVENTS.INITIAL_PLAY,                       from:'*',                                                                to:'*'},
          {name:OO.EVENTS.PLAY,                               from:'*',                                                                to:'PlayRequested'},
          {name:OO.EVENTS.PLAY_STREAM,                        from:['PlaybackReady', 'Paused', 'SwitchingStreams', 'PauseRequested'],  to:'PlayingState'},
          {name:OO.EVENTS.PAUSE,                              from:['PlayingState', 'PlayRequested', 'PlaybackReady'],                      to:'PauseRequested'},
          {name:OO.EVENTS.PAUSE_STREAM,                       from:['PlayingState', 'PlayRequested'],                                       to:'Paused'},
          {name:OO.EVENTS.PAUSED,                             from:['PlayingState', 'PlayRequested', 'PauseRequested'],                     to:'Paused'},
          {name:OO.EVENTS.STREAM_PAUSED,                      from:['PlayingState', 'PlayRequested', 'PauseRequested'],                     to:'Paused'},
          {name:OO.EVENTS.PLAYING,                            from:['Paused', 'PlayRequested', 'PauseRequested'],                      to:'PlayingState'},
          {name:OO.EVENTS.STREAM_PLAYING,                     from:['Paused', 'PlayRequested', 'PauseRequested', 'PlayingState','SwitchingStreams'],           to:'PlayingState'},
          {name:OO.EVENTS.STREAM_PLAYED,                      from:['PlayingState','Paused'],                                               to:'SwitchingStreams'},
          {name:OO.EVENTS.PLAYED,                             from:'SwitchingStreams',                                                 to:'PlaybackReady'},
          {name:OO.EVENTS.STREAM_PLAY_FAILED,                 from:'*'},
          {name:OO.EVENTS.WILL_PLAY_STREAM,                   from:['PlaybackReady', 'Paused', 'PlayRequested']},
          {name:OO.EVENTS.SEEK,                               from:['PlaybackReady', 'Paused', 'PlayingState', 'PlayRequested']},
          {name:OO.EVENTS.PLAYHEAD_TIME_CHANGED,              from:'*'},

          // TODO, following events are ads related, we need to determine if we need to introduce new state for those events.
          {name:OO.EVENTS.WILL_FETCH_ADS,                     from:"*"},
          {name:OO.EVENTS.AD_CONFIG_READY,                    from:"*"},
          {name:OO.EVENTS.WILL_PLAY_ADS,                      from:"*"},
          {name:OO.EVENTS.ADS_PLAYED,                         from:"*"},
          {name:OO.EVENTS.ADS_ERROR,                          from:"*"},
          {name:OO.EVENTS.PLAY_MIDROLL_STREAM,                from:"*"},
          {name:OO.EVENTS.MIDROLL_PLAY_FAILED,                from:"*"},
          {name:OO.EVENTS.MIDROLL_STREAM_PLAYED,              from:"*"},
          {name:OO.EVENTS.USE_SERVER_SIDE_HLS_ADS,            from:"*"},
          {name:OO.EVENTS.ADS_MANAGER_HANDLING_ADS,           from:"*"},
          {name:OO.EVENTS.ADS_MANAGER_FINISHED_ADS,           from:"*"}
        ]
      });
    };

    _.extend(PlaybackControlModule.prototype, {
      onPlayerCreated: function(event, elementId, params) {
        this.parameters = params;
      },

      onPlayed: function(event) {
        this.onPlaybackReady(); // re-initiate the playback ready for replay.
      },

      onWillPlayAds: function(event) {
        this.isInlineAdsPlaying = true;
      },

      onAdsPlayed: function(event) {
        this.isInlineAdsPlaying = false;
      },

      onAdsError: function(event) {
        this.isInlineAdsPlaying = false;
      },

      onPlayMidrollStream: function(event) {
        this.isInlineAdsPlaying = true;
      },

      onMidrollStreamPlayed: function(event, mainVideoPlayhead) {
        this.isInlineAdsPlaying = false;
        var previousMidroll = this.currentMidrollAdItem;
        var hadMidroll = this._checkAndPlayReadyMidrolls(mainVideoPlayhead);
        // resume
        if (!hadMidroll) {
          this.mb.publish(OO.EVENTS.ADS_PLAYED, previousMidroll.item);
          this.mb.publish(OO.EVENTS.WILL_RESUME_MAIN_VIDEO);
        }
      },

      onEmbedCodeChanged: function(event, embedCode) {
        //reset data
        this.contentTree = null;
        this.metadata = null;
        this.authorization = null;
        this.currentItem = null;
        this.inlineAds = [];
        this.prerolls = [];
        this.midrolls = [];
        this.postrolls = [];
        this.inlineAdsItems = [];
        this.mainVideoItem = null;
        this.waitForPlaybackReady = true;
        this.movieIndex = -1; // offset to the prerolls.
        this.currentMidrollAdItem = null;
        this.skipPrerollAdsCheck = false;
        this.userRequest = '';
        this.playedAtLeastOnce = false;
        this.useStitchedAds = false;
        this.playInFlight = false;
        this.lastMidrollPlayhead = -1;
      },

      onContentTreeFetched:function(event, response) {
        this.contentTree = response;
        if (this.parameters && this.parameters.vastAds) {
          this.contentTree.ads = this.parameters.vastAds;
        }
        // TODO, filter out non-linear ads here.
        // need to make non-linear ads into a seperate array.
        if (OO.requiredInEnvironment('ads') && !this.useStitchedAds && this.contentTree.ads) {
          this.inlineAds = this.contentTree.ads;
        }
        else {
          this.inlineAds = [];
        }

        this.inlineAdsItems = _.map(this.inlineAds, function(ad, index) {
          return { type: 'ad', index: index, item: ad };
        }, this);
        this.prerolls = _.select(this.inlineAdsItems, _.bind(this._isPreRollAd, this), this);
        if (OO.supportMidRollAds) {
          this.midrolls = _.select(this.inlineAdsItems, _.bind(this._isMidRollAd, this), this);
        } else { this.midrolls = []; }
        this.postrolls = _.select(this.inlineAdsItems, _.bind(this._isPostRollAd, this), this);

        this.movieIndex = (_.size(this.postrolls) > 0) ? this.postrolls[0].index - 1 : _.size(this.inlineAds);

        this.mainVideoItem = {type: 'movie', index: this.movieIndex, item: this.authorization};

        // assign index for each ads.
        if (_.size(this.inlineAds) > 0) {
          // TODO, add a time out here to make sure we are not blocked by a failed ads fetch.
          OO.log("start a timer to fetch initial ads", OO.playerParams.maxAdsTimeout);
          _.delay(_.bind(this._onFetchPrerollTimeOut, this), OO.playerParams.maxAdsTimeout * 1000);
        }
        this._checkPlaybackReady();
        // AdsManager will intercept this event to fetch ads config.
        this.mb.publish(OO.EVENTS.WILL_FETCH_ADS, null);
      },

      _onFetchPrerollTimeOut: function() {
        // false playbackready here:
        OO.log("Timeout of fetching pre-roll ads.");
        this.skipPrerollAdsCheck = true;
        if (this.waitForPlaybackReady) { this._checkPlaybackReady(); }

        this.mb.publish(OO.EVENTS.AD_FETCH_FAILED, null);
      },

      onAdConfigReady: function(event, inlineAd) {
        if (inlineAd && inlineAd.vastAdUnit) {
          _.each(this.inlineAds, function(ad, index) {
            if (ad.type == "vast" && !_.isEmpty(ad.url) && ad.url === inlineAd.vastUrl) {
              _.extend(ad, inlineAd.vastAdUnit);
            }
          }, this);
        }
        this._checkPlaybackReady();
      },

      onWillFetchAds: function(event) {
        // if on one intercept 'willFetchAds', will instantanly fire playback ready.
        this.skipPrerollAdsCheck = true;
        this._checkPlaybackReady();
      },

      onMetadataFetched:function(event, response) {
        this.metadata = response;
        this._checkPlaybackReady();
      },

      onUseServerSideHlsAds: function(event, useStitchedAds) {
        this.useStitchedAds = useStitchedAds;
        if (this.useStitchedAds) {
          this.inlineAds = this.prerolls = this.midrolls = this.postrolls = [];
        }
      },

      onAuthorizationFetched:function(event, response) {
        this.authorization = response;
        this.mainVideoItem = {type: 'movie', index: this.movieIndex, item: this.authorization};
        this._checkPlaybackReady();
      },

      onAdAuthorizationFetched: function(event, response) {
        _.each(this.inlineAds, function(ad, index) {
          var authForEmbed = (ad.ad_embed_code) ? response[ad.ad_embed_code] : null;
          if (authForEmbed) {
            _.extend(ad, authForEmbed);
          }
        }, this);
        this._checkPlaybackReady();
      },

      onAdsManagerHandlingAds: function(event, response) {
        this.adsManagerHandlingAds = true;
      },

      onAdsManagerFinishedAds: function(event, response) {
        this.adsManagerHandlingAds = false;
      },

      _findFirstReadyPreRolls: function() {
        return _.find(this.prerolls, function(adItem, index) {
          return adItem && this._isAdReady(adItem.item);
        }, this);
      },

      _checkWaitForAds: function() {
        // check if any required ads were checked
        var waitForAds = true;

        if(_.size(this.prerolls) > 0) {
          var ad = this._findFirstReadyPreRolls();
          if (ad) {
            waitForAds = false;
          }
        } else { // no pre rolls ad
          waitForAds = false;
        }
        return waitForAds;
      },

      _checkPlaybackReady:function() {
        if (!this.waitForPlaybackReady) {
          if (this.currentState == "PlaybackReady" && !this.playInFlight) { this.onPlaybackReady(); }
          return;
        }
        // if all basic metadata has returned
        if (this.contentTree != null && this.metadata != null && this.authorization != null) {
          // we are ready if no longer waiting for ads
          if(this.skipPrerollAdsCheck || !this._checkWaitForAds()) {
            this.mb.publish(OO.EVENTS.PLAYBACK_READY);
          }
        }
      },

      onPlaybackReady: function() {
        // preload the next stream
        var ad = this._findFirstReadyPreRolls();
        this.currentItem = ad || this.mainVideoItem;
        this.stream_url = this._streamForItem(this.currentItem.item);

        this.mb.publish(OO.EVENTS.PRELOAD_STREAM, this.stream_url);
        this.waitForPlaybackReady = false;
        if (!OO.isChromecast) {
          // check autoplay
          var autoPlay = this.parameters.autoPlay === 'true' || this.parameters.autoPlay === true ||
              this.parameters.autoplay === 'true' || this.parameters.autoplay === true;
          if (this.playedAtLeastOnce == false && autoPlay && OO.allowAutoPlay) {
            this.playInFlight = true;
            this.mb.publish(OO.EVENTS.INITIAL_PLAY);    // initial play is special since it allows for pre-rolls
          }
        } 

        // check loop
        var loop = this.parameters.loop === 'true' || this.parameters.loop === true;
        if (this.playedAtLeastOnce && loop)
        {
          this.mb.publish(OO.EVENTS.PLAY);
        }
      },

      _isAdReady: function(ad) {
        return (ad && this._streamForItem(ad));
      },

      _isMidRollAd: function(adItem) {
        return (adItem && !this._isPreRollAd(adItem) && !this._isPostRollAd(adItem));
      },

      _isPreRollAd: function(adItem) {
        var ad = adItem ? adItem.item : null;
        return (ad && ad.time < 250);
      },

      _isPostRollAd: function(adItem) {
        var ad = adItem ? adItem.item : null;
        return (ad && ad.time == 1000000000);
      },

      _lookupNextPlaybackItem: function(type, index) {
        // Just finish prerolls, return movie item directly
        if(type == "ad" && index == _.size(this.prerolls)) { return this.mainVideoItem; }
        // still play
        if(index < _.size(this.prerolls) || index > this.mainVideoItem.index) {
          // see if any ads to play
          var nextAd = _.find(this.inlineAdsItems, _.bind(function(adItem, adIndex){
            // If we're still in preroll territory, then any non-preroll ads should be invalid
            if (index < _.size(this.prerolls) && adIndex >= _.size(this.prerolls)) { return false; }
            if (adIndex < index) { return false; }
            if (this._isAdReady(adItem.item)) {
              return true;
            }
            return false;
          },this));

          // if remaining ad is not ready, skip and play mainVideo. For postroll case, return null if no ad.
          if (index > this.mainVideoItem.index && !nextAd) { return null; }
          return nextAd || this.mainVideoItem;
        }
        // Handle mid roll here, need to find first ready ads match curent main video playhead time
        return null;
      },

      _streamForItem: function(playbackItem) {
        if (playbackItem.streamUrl) { return playbackItem.streamUrl; }
        if (_.isEmpty(playbackItem.streams)) { return null; }
        if (_.isEmpty(playbackItem.streams[0])) { return null; }
        return OO.decode64(playbackItem.streams[0].url.data);
      },

      _publishPlayItemEvent: function(playItem, streamUrl, eventName) {
        this._checkCompanionAds(playItem);
        this.mb.publish(eventName, streamUrl, playItem);
      },

      onInitialPlay:function() {
        this.playInFlight = true;
        this.mb.publish(OO.EVENTS.PLAY, this.currentItem.item);
      },

      onPlay:function() {
        this.userRequest = 'play';

        if (this.currentItem.type == "ad" || this.currentMidrollAdItem) {
          this.mb.publish(OO.EVENTS.WILL_PLAY_ADS, this.currentItem.item);
        }
        if (this.currentMidrollAdItem) {
          var midrollUrl = this._streamForItem(this.currentMidrollAdItem.item);
          this._publishPlayItemEvent(this.currentMidrollAdItem, midrollUrl, OO.EVENTS.PLAY_MIDROLL_STREAM);
        } else {
          this.playInFlight = false;
          this._publishPlayItemEvent(this.currentItem, this.stream_url, OO.EVENTS.PLAY_STREAM);
        }
      },

      onPause:function() {
        this.userRequest = 'pause';
        this.mb.publish(OO.EVENTS.PAUSE_STREAM);
      },

      _checkAndPlayReadyMidrolls: function(playhead) {
        if (this.midrolls.length == 0 || this.isInlineAdsPlaying) { return false; }
        // [pbw-1196] IE is double firing the same playhead time when the VAST ad completes,
        // so we need to dedupe it to prevent looped midrolls
        if (!this.currentMidrollAdItem && this.lastMidrollPlayhead == playhead) { return false; }
        this.lastMidrollPlayhead = playhead;
        // startIndex for next Midroll.
        var startIndex = (this.currentMidrollAdItem) ? this.currentMidrollAdItem.index : -1;

        this.currentMidrollAdItem = _.find(this.midrolls, function(adItem) {
          // map ad time to each 250 milliseconds slot.
          var adTimeSlot = Math.floor(adItem.item.time / 250);
          return (adTimeSlot == Math.floor(playhead * 1000 / 250) && adItem.index > startIndex);
        }, this);
        if (this.currentMidrollAdItem) {
          var midrollUrl = this._streamForItem(this.currentMidrollAdItem.item);
          if (midrollUrl) {
            if (startIndex == -1) { this.mb.publish(OO.EVENTS.WILL_PLAY_ADS, this.currentItem.item); }
            this._publishPlayItemEvent(this.currentMidrollAdItem, midrollUrl, OO.EVENTS.PLAY_MIDROLL_STREAM);
            return true;
          }
        }
        this.currentMidrollAdItem = null;
        return false;
      },

      _checkCompanionAds: function(playItem) {
        //WILL_SHOW_COMPANION_ADS

        if (playItem.type != "ad" || _.isNull(playItem.item) || _.isNull(playItem.item.data) ||
            playItem.item.type != "vast" || _.isEmpty(playItem.item.data.companion)) {
          return;
        }
        // Defer so that external JS exception will not hang our player.
        _.defer(_.bind(function() {
            this.mb.publish(OO.EVENTS.WILL_SHOW_COMPANION_ADS, {ads: playItem.item.data.companion});
          }, this));
      },

      onPlayheadTimeChanged: function(event, time, duration) {
        if (this.currentState != 'PlayingState'  || this.currentMidrollAdItem) { return; }
        this.currentItemActualDuration = duration;
        // TODO, this is for MO-514, using a small delta here, the reason is that for IE 9, when pause and resume
        // a video, the next playhead is fired after around 100 ms, then it will resume to fire at 250ms
        // every time. We will need to figure out a more predict way of getting the delta or find some doc
        // to prove this observation.
        if (this.currentMainVideoPlayhead < time - 0.1) { this._checkAndPlayReadyMidrolls(time); }
        this.currentMainVideoPlayhead = time;
      },

      onStreamPlayed: function() {
        if (this.adsManagerHandlingAds) {
          return;
        }

        this.playedAtLeastOnce = true;

        if (this.currentItem == null) { return; }
        if (this.currentItem.type === 'movie' && _.size(this.postrolls) == 0 && !this.isInlineAdsPlaying) {
          this.mb.publish(OO.EVENTS.PLAYED);
          return;
        }
        // play the next stream
        var previousItem = this.currentItem;
        this.currentItem = this._lookupNextPlaybackItem(this.currentItem.type, this.currentItem.index+1);
        if (!this.currentItem) {
          // PostRoll Ads finsihed:
          if (previousItem.type == "ad") { this.mb.publish(OO.EVENTS.ADS_PLAYED, previousItem.item); }
          this.mb.publish(OO.EVENTS.PLAYED);
          return;
        }
        this.stream_url = this._streamForItem(this.currentItem.item);

        if (this.currentItem.type == "movie" && previousItem.type == "ad") {
          this.mb.publish(OO.EVENTS.ADS_PLAYED, this.currentItem.item);
        } else if (this.currentItem.type == "ad" && previousItem.type == "movie") {
          this.mb.publish(OO.EVENTS.WILL_PLAY_ADS, this.currentItem.item);
        }
        this._publishPlayItemEvent(this.currentItem, this.stream_url, OO.EVENTS.PLAY_STREAM);
      },

      onStreamPlaying: function() {
        if (this.userRequest === 'play') {
          this.mb.publish(OO.EVENTS.PLAYING);
        }
        this.userRequest = '';
      },

      onStreamPaused: function() {
        if (this.userRequest === 'pause') {
          this.mb.publish(OO.EVENTS.PAUSED);
        }
        this.userRequest = '';
      },

      onSeek: function(event, seconds) {
        // this will only be triggered if we were playing, paused, playback is ready, or play was requested
        // because of the state machine
        this.mb.publish(OO.EVENTS.SEEK_STREAM, seconds);
      },

      onStreamPlayFailed: function(event, mediaErrorCode) {
        if (this.adsManagerHandlingAds) {
          // When Ads Manager are handling the ads playback don't publish more play error events as
          // they are meant for the main video and not ad
          return;
        }

        if (this.currentItem && this.currentItem.type == "ad") {
          OO.log("PreRoll failed, fallback to next stream");
          // For PreRoll/PostRoll, continue to next.
          this.currentItem.item.streams = [];
          this.currentItem.item.streamUrl = null;
          if (this.currentState === 'PlayingState') { this.onStreamPlayed(); }
          else { this._checkPlaybackReady(); }
        } else {
          this.mb.publish(OO.EVENTS.PLAY_FAILED, mediaErrorCode);

          var mediaErrorAborted = !!window.MediaError ? window.MediaError.MEDIA_ERR_ABORTED : 1;
          var mediaErrorNetwork = !!window.MediaError ? window.MediaError.MEDIA_ERR_NETWORK : 2;
          if (mediaErrorCode==mediaErrorAborted || mediaErrorCode==mediaErrorNetwork) {
            this.mb.publish(OO.EVENTS.ERROR, { code: OO.ERROR.PLAYBACK.NETWORK });
          } else {
            switch(this.contentTree.content_type) {
            case "Video":
              this.mb.publish(OO.EVENTS.ERROR, { code: OO.ERROR.PLAYBACK.STREAM });
              break;
            case "LiveStream":
              this.mb.publish(OO.EVENTS.ERROR, { code: OO.ERROR.PLAYBACK.LIVESTREAM });
              break;
            default:
              this.mb.publish(OO.EVENTS.ERROR, { code: OO.ERROR.PLAYBACK.GENERIC });
            }
          }
        }
        this.userRequest = '';
      },

      onMidrollPlayFailed: function() {
        OO.log("MidRoll failed, fall back to main video");
        // TODO, use ads played event for now to indicate ad is done, use a different event to nofity
        var item = this.currentMidrollAdItem.item;
        this.currentMidrollAdItem = null;
        this.mb.publish(OO.EVENTS.ADS_PLAYED, item);
        this.mb.publish(OO.EVENTS.WILL_RESUME_MAIN_VIDEO);
      },

      onWillPlayStream: function() {
        this.mb.publish(OO.EVENTS.WILL_PLAY);
      },

      __placeholder: true
    });

    OO.registerModule('playbackControl', function(messageBus, id) {
      return new PlaybackControlModule(messageBus, id);
    });
  }(OO, OO._, OO.$));
  (function(OO, _, $){
    /*
     *  Defines a simple debug mode
     */
    var PlaybackModule = function(messageBus, id) {
      // short circuit here if the page does not need playback
      if (!OO.requiredInEnvironment('html5-playback')) { return; }
      this.toString = function() {return 'html5-playback';};

      this.mb = messageBus;
      this.id = id;
      this.willPlayFromBeginning = true;
      this.playedAtLeastOnce = false;
      this.loadedAtLeastOnce = false;
      this.replayVideo = false;
      this._setDefaultPreloadValue();

      this.mb.subscribe(OO.EVENTS.PLAYER_CREATED, 'playback', _.bind(this._playerWasCreated,this));
      this.mb.subscribe(OO.EVENTS.PRELOAD_STREAM, 'playback', _.bind(this._preloadStream,this));
      this.mb.subscribe(OO.EVENTS.RELOAD_STREAM, 'playback', _.bind(this._reloadStream,this));
      this.mb.subscribe(OO.EVENTS.PLAY_STREAM, 'playback', _.bind(this._playStream,this));
      this.mb.subscribe(OO.EVENTS.PAUSE_STREAM, 'playback', _.bind(this._pauseStream,this));
      this.mb.subscribe(OO.EVENTS.SEEK_STREAM, 'playback', _.bind(this._seek,this));
      this.mb.subscribe(OO.EVENTS.EMBED_CODE_CHANGED, 'playback', _.bind(this._embedCodeChanged,this));
      this.mb.subscribe(OO.EVENTS.CHANGE_VOLUME, 'playback', _.bind(this._changeVolume,this));
      this.mb.subscribe(OO.EVENTS.DESTROY, 'playback', _.bind(this._destroy, this));
      this.mb.subscribe(OO.EVENTS.END_SCREEN_SHOWN, 'playback', _.bind(this._endScreenShown, this));

      this.mb.subscribe(OO.EVENTS.PLAY_MIDROLL_STREAM, 'playback', _.bind(this._playMidRoll,this));
      this.mb.subscribe(OO.EVENTS.WILL_RESUME_MAIN_VIDEO, 'playback', _.bind(this._resumeMainVideo,this));

      this.mb.subscribe(OO.EVENTS.PAGE_UNLOAD_REQUESTED, 'playback', _.bind(this._pageUnloadRequested, this));
    };

    _.extend(PlaybackModule.prototype, {
      _toggleMidrollAndMainVideo: function(showMainVideo) {
        if (this.videoWrapper) { this.videoWrapper.show(showMainVideo); }
        if (this.midrollWrapper) { this.midrollWrapper.show(!showMainVideo); }
      },

      _playMidRoll: function(event, url) {
        this.videoWrapper.pause();
        this._toggleMidrollAndMainVideo(false);
        // Only call load and rewind if we've swapped elements, otherwise we'll restart
        // the ad on pause->play
        var urlChanged = this.midrollWrapper.setVideoUrl(url);
        // Dispatch load event earlier, so we can preload midroll
        if (urlChanged) { this.midrollWrapper.load(true); }
        this.midrollWrapper.play();
      },

      _midrollPlayed: function() {
        this.mb.publish(OO.EVENTS.MIDROLL_STREAM_PLAYED, this.videoWrapper.getCurrentTime());
      },

      _midrollPaused: function() {
        if (this.videoWrapper.isPlaying) { return; }
        this.mb.publish(OO.EVENTS.STREAM_PAUSED, this.midrollWrapper.getCurrentTime());
      },

      _midrollPlayheadChanged: function() {
        this.mb.publish(OO.EVENTS.PLAYHEAD_TIME_CHANGED, this.midrollWrapper.getCurrentTime(),
            this.midrollWrapper.getDuration(), this.midrollWrapper.getBuffer());
      },

      _resumeMainVideo: function(event) {
        this._toggleMidrollAndMainVideo(true);
        this.videoWrapper.play();
        this.midrollWrapper.pause();
      },

      _embedCodeChanged: function(event, embedCode) {
        if (this.videoWrapper) { this.videoWrapper.setEmbedCode(embedCode); }
        this.willPlayFromBeginning = true;
        this.loadedAtLeastOnce = false;
      },

      _playerWasCreated: function(event, elementId, params) {
        this.elementId = elementId;
        this.rootElement = $('#'+this.elementId+' > div');
        this.params = params;

        // Set HTML5 locale
        if (this.params.locale !== undefined) {
          OO.setLocale(this.params.locale);
        }

        // load the css
        OO.attachStyle(_.template(OO.get_css("playback"))({
          elementId: this.elementId
        }), this.elementId);

        // display initial ui
        this.videoWrapper = OO.createVideoElementWrapper(this.rootElement, "video", this.params);
        this.videoWrapper.on(OO.VideoElementWrapper.WILL_PLAY, 'playback', _.bind(this._videoWillPlay, this));
        this.videoWrapper.on(OO.VideoElementWrapper.PLAYING, 'playback', _.bind(this._videoPlaying, this));
        this.videoWrapper.on(OO.VideoElementWrapper.PAUSED, 'playback', _.bind(this._videoPaused, this));
        this.videoWrapper.on(OO.VideoElementWrapper.ERROR, 'playback', _.bind(this._videoError, this));
        this.videoWrapper.on(OO.VideoElementWrapper.PLAYHEAD_TIME_CHANGED, 'playback',
                             _.bind(this._videoPlayheadTimeChanged, this));
        this.videoWrapper.on(OO.VideoElementWrapper.DURATION_CHANGED, 'playback',
                            _.bind(this._videoDurationChanged, this));
        this.videoWrapper.on(OO.VideoElementWrapper.BUFFERING, 'playback',
                             _.bind(this._videoBuffering, this));
        this.videoWrapper.on(OO.VideoElementWrapper.BUFFERED, 'playback', _.bind(this._videoBuffered, this));
        this.videoWrapper.on(OO.VideoElementWrapper.SEEKED, 'playback', _.bind(this._videoSeeked, this));
        this.videoWrapper.on(OO.VideoElementWrapper.DOWNLOADING, 'playback',
                             _.bind(this._videoDownloading, this));
        this.videoWrapper.on(OO.VideoElementWrapper.VOLUME_CHANGED, 'playback',
                             _.bind(this._videoVolumeChanged, this));
        this.videoWrapper.on(OO.VideoElementWrapper.PLAYED, 'playback',
                            _.bind(this._videoPlayed, this));
        this.videoWrapper.on(OO.VideoElementWrapper.FULL_SCREEN_CHANGED, 'playback',
                            _.bind(this._fullScreenChanged, this));

        //let page-level parameters override our default value for shouldPreload from true to false only
        if (this.params && this.params.preload == false) {
          this.shouldPreload = false;
        }

        // midroll:
        if (OO.supportMidRollAds) {
          this.midrollWrapper = OO.createVideoElementWrapper(this.rootElement, "midroll", this.params);
          this.midrollWrapper.on(OO.VideoElementWrapper.PLAYED, 'playback',
                            _.bind(this._midrollPlayed, this));

          this.midrollWrapper.on(OO.VideoElementWrapper.PAUSED, 'playback', _.bind(this._midrollPaused, this));
          this.midrollWrapper.on(OO.VideoElementWrapper.PLAYHEAD_TIME_CHANGED, 'playback',
                             _.bind(this._midrollPlayheadChanged, this));
          this.midrollWrapper.on(OO.VideoElementWrapper.ERROR, 'playback', _.bind(this._midRollVideoError, this));
        }


        //set Initial Volume
        if (this.params.initialVolume !== undefined){
          var initialVolume = parseFloat(this.params.initialVolume);
          this.mb.publish(OO.EVENTS.CHANGE_VOLUME, initialVolume);
        }


        // NOTE[jigish]: Throw initial volumeChanged
        this._videoVolumeChanged();

        if (OO.isIos && OO.iosMajorVersion == 7) {
          // [pbw-1832] iOS 7's visibilitychange event is different/bad, so use pageshow
          window.addEventListener("pageshow", _.bind(function() {
            this.mb.publish(OO.EVENTS.PAUSE);
          },this));
        } else if (OO.isAndroid || OO.isIos) {
          // [pbw-1832] on other mobile, pause when the tab is switched or the browser is backgrounded
          document.addEventListener("visibilitychange", _.bind(function(evt) {
            if (document.hidden) {
              this._pauseStream();
              this.mb.publish(OO.EVENTS.PAUSE);
            }
          }, this));
        }
      },

      _playVideoWithReport: function() {
         this._toggleMidrollAndMainVideo(true);
         this.videoWrapper.play();
         if (this.willPlayFromBeginning) {
           this.mb.publish(OO.EVENTS.WILL_PLAY_FROM_BEGINNING);
         }
         this.willPlayFromBeginning = false;
      },

      _setDefaultPreloadValue: function() {
        // TODO (neeraj): do we only need to default false on specific versions?
        if (OO.isChrome || OO.isIos || OO.isAndroid) {
          this.shouldPreload = false;
        } else {
          this.shouldPreload = true;
        }
      },

      _preloadStream: function(event, streamUrl) {
        var urlChanged = this.videoWrapper.setVideoUrl(streamUrl);
        if (this.shouldPreload && urlChanged) {
          this.loadedAtLeastOnce = true;
          this.videoWrapper.load(true);
        }
      },

      _reloadStream: function(event) {
        if (!this.loadedAtLeastOnce) {
          this.videoWrapper.reload();
          this.loadedAtLeastOnce = true;
        }
      },

      _playStream: function(event, streamUrl) {
        var urlChanged = this.videoWrapper.setVideoUrl(streamUrl);
        //on subsequent video plays we can allow _preloadStream to load the video
        this.shouldPreload = true;
        if (urlChanged) {
          this.videoWrapper.load(false);
          this.loadedAtLeastOnce = true;
        }
        this._playVideoWithReport();
      },

      _pauseStream: function(event) {
        // TODO, only need to call one pause based on if current video playing is midroll.
        this.videoWrapper.pause();
        if (this.midrollWrapper) { this.midrollWrapper.pause(); }
      },

      _seek: function(event, seconds) {
        if (this.videoWrapper.getIsActive()) {
          this.videoWrapper.seek(seconds);
        } else if (this.midrollWrapper && this.midrollWrapper.getIsActive()) {
          this.midrollWrapper.seek(seconds);
        } else {
          OO.log("Trying to seek while video element is not active");
          if (seconds == 0 && OO.isSafari && this.videoWrapper.isM3u8 && this.videoWrapper.videoEnded) {
            // XXX HACK: PBW-3392 - for HLS assets video element on Safari browser won't seek 
            // after video ended (for replay we need to seek to zero and then play) 
            this.videoWrapper.reload();
          }
        }
      },

      _changeVolume: function(event, volume) {
        this.videoWrapper.setVolume(volume);
      },

      _videoWillPlay:function() {
        this.mb.publish(OO.EVENTS.WILL_PLAY_STREAM, this.videoWrapper.getStreamUrl());
        //[pbw-1734] iOS fullscreen blocks the replay button, so mimic functionality here
        if (OO.isIos && this.replayVideo) {
          this.replayVideo = false;
          this.mb.publish(OO.EVENTS.SEEK, 0);
          this.mb.publish(OO.EVENTS.PLAY);
        }
      },

      _endScreenShown:function() {
        this.replayVideo = true;
      },

      _videoPlaying: function() {
        this.mb.publish(OO.EVENTS.STREAM_PLAYING, this.videoWrapper.getStreamUrl());
      },

      _videoPaused: function() {
        if (this.midrollWrapper && this.midrollWrapper.isPlaying) { return; }
        this.mb.publish(OO.EVENTS.STREAM_PAUSED, this.videoWrapper.getStreamUrl());
      },

      _videoPlayed: function() {
        this.willPlayFromBeginning = true;
        this.playedAtLeastOnce = true;
        this.mb.publish(OO.EVENTS.STREAM_PLAYED, this.videoWrapper.getStreamUrl());
      },

      _videoError: function(event, code) {
        this.mb.publish(OO.EVENTS.STREAM_PLAY_FAILED, code);
      },

      _videoBuffering: function() {
        this.mb.publish(OO.EVENTS.BUFFERING, this.videoWrapper.getStreamUrl());
      },

      _videoBuffered: function() {
        this.mb.publish(OO.EVENTS.BUFFERED, this.videoWrapper.getStreamUrl());
      },

      _videoSeeked: function() {
        this.mb.publish(OO.EVENTS.SEEKED);
      },

      _videoDownloading: function() {
        var currentTime, duration, buffer, seekRange, streamUrl;
        if (this.videoWrapper.getIsActive()) {
          currentTime = this.videoWrapper.getCurrentTime();
          duration = this.videoWrapper.getDuration();
          buffer = this.videoWrapper.getBuffer();
          seekRange = this.videoWrapper.getSeekableRange();
          streamUrl = this.videoWrapper.getStreamUrl();
        } else if (this.midrollWrapper && this.midrollWrapper.getIsActive()) {
          currentTime = this.midrollWrapper.getCurrentTime();
          duration = this.midrollWrapper.getDuration();
          buffer = this.midrollWrapper.getBuffer();
          seekRange = this.midrollWrapper.getSeekableRange();
          streamUrl = this.midrollWrapper.getStreamUrl();
        }
        this.mb.publish(OO.EVENTS.DOWNLOADING, currentTime, duration,
          buffer, seekRange, streamUrl);
      },

      _fullScreenChanged: function(e, isFullScreen, paused) {
        this.mb.publish(OO.EVENTS.FULLSCREEN_CHANGED, isFullScreen, paused);
      },

      _videoVolumeChanged: function() {
        this.mb.publish(OO.EVENTS.VOLUME_CHANGED, this.videoWrapper.getVolume());
      },

      _videoPlayheadTimeChanged: function() {
        var ts = this.videoWrapper.getCurrentTime();
        var dur = this.videoWrapper.getDuration();
        var buffer = this.videoWrapper.getBuffer();
        var seekRange = this.videoWrapper.getSeekableRange();
        this.mb.publish(OO.EVENTS.PLAYHEAD_TIME_CHANGED, ts, dur, buffer, seekRange);
      },

      _videoDurationChanged: function() {
        var ts = this.videoWrapper.getCurrentTime();
        var dur = this.videoWrapper.getDuration();
        var buffer = this.videoWrapper.getBuffer();
        var seekRange = this.videoWrapper.getSeekableRange();
        this.mb.publish(OO.EVENTS.PLAYHEAD_TIME_CHANGED, ts, dur, buffer, seekRange);
      },

      _midRollVideoError: function() {
        this.mb.publish(OO.EVENTS.MIDROLL_PLAY_FAILED, arguments);
      },

      _destroy: function() {
        this.videoWrapper.kill();
        if (this.midrollWrapper) { this.midrollWrapper.kill(); }
      },

      _pageUnloadRequested: function() {
        this.videoWrapper.delayErrorPublishing();
        if (this.midrollWrapper) {
          this.midrollWrapper.delayErrorPublishing();
        }
      },

      __placeholder:true
    });

    OO.registerModule('playback', function(messageBus, id) {
      return new PlaybackModule(messageBus, id);
    });

  }(OO, OO._, OO.$));
(function(OO, _, $){
  /*
   *  Defines a flashback wrapper
   */
  var FlashPlaybackModule = function(messageBus, id) {
    // short circuit here if the page does not need playback
    if (!OO.requiredInEnvironment('flash-playback')) { return; }
    OO.d("Using Flash Playback");

    this.mb = messageBus;
    this.id = id;
    this.adobeToken = null;
    this.playerEmbedded = false;
    this.playbackReady = false;
    this.queuedPlaybackReady = false;
    this.embedCodeChanged = false;
    this.sasResponse = {};
    this.playerXml = {};
    this.playerXmlRequest = null;
    this.areFlashParamsSet = false;
    this.enableChannels = false;
    this.debugHost = "";
    this.o0jsdebug = "";
    this.isTwitter = "";
    this._playingAd = false;
    this.QUERY_STRING_PARAM_WHITELIST = ['embedCode', 'adSetCode', 'autoplay', 'loop', 'playerBrandingId',
      'devModuleCategory', 'devModuleURL', 'devModuleData', 'preload', 'showInAdControlBar', 'showAdMarquee',
      'tvRatingsPosition', 'tvRatingsTimer', 'shouldDisplayCuePointMarkers', 'adRequestTimeout'];
    this.mb.subscribe(OO.EVENTS.PLAYER_CREATED, 'flash_playback', _.bind(this._playerWasCreated,this));
    this.mb.subscribe(OO.EVENTS.SET_EMBED_CODE, 'flash_playback', _.bind(this._setEmbedCode,this));
    this.mb.subscribe(OO.EVENTS.AUTHORIZATION_FETCHED, 'flash_playback', _.bind(this._onAuthorizationFetched,this));
    this.mb.subscribe(OO.EVENTS.WILL_FETCH_PLAYER_XML, 'flash_playback', _.bind(this._onWillFetchPlayerXml,this));
    this.mb.subscribe(OO.EVENTS.PLAY, 'flash_playback', _.bind(this._play,this));
    this.mb.subscribe(OO.EVENTS.INITIAL_PLAY, 'flash_playback', _.bind(this._play,this));
    this.mb.subscribe(OO.EVENTS.PAUSE, 'flash_playback', _.bind(this._pause,this));
    this.mb.subscribe(OO.EVENTS.SEEK, 'flash_playback', _.bind(this._seek,this));
    this.mb.subscribe(OO.EVENTS.CHANGE_VOLUME, 'flash_playback', _.bind(this._changeVolume,this));
    this.mb.subscribe(OO.EVENTS.ADOBE_PASS_WAITING_FOR_TOKEN, 'flash_playback', _.bind(this._adobeWaitingForToken, this));
    this.mb.subscribe(OO.EVENTS.ADOBE_PASS_TOKEN_FETCHED, 'flash_playback', _.bind(this._adobeTokenFetched, this));
    this.mb.subscribe(OO.EVENTS.ADOBE_PASS_AUTH_STATUS, 'flash_playback', _.bind(this._adobeAuthStatus, this));
    this.mb.subscribe(OO.EVENTS.ERROR, 'flash_playback', _.bind(this._onError, this));
    this.mb.subscribe(OO.EVENTS.SKIP_AD, 'flash_playback', _.bind(this._skipAd, this));
    this.mb.subscribe(OO.EVENTS.SET_TARGET_BITRATE, 'flash_playback', _.bind(this._setTargetBitrate, this));
    this.mb.subscribe(OO.EVENTS.SET_TARGET_BITRATE_QUALITY, 'flash_playback', _.bind(this._setTargetBitrateQuality, this));
    this.mb.subscribe(OO.EVENTS.SET_CLOSED_CAPTIONS_LANGUAGE, 'flash_playback', _.bind(this._setClosedCaptionsLanguage, this));
    this.mb.subscribe(OO.EVENTS.FETCH_STYLE, "flash_playback", _.bind(this._fetchStyle, this));
    this.mb.subscribe(OO.EVENTS.SET_STYLE, "flash_playback", _.bind(this._setStyle, this));
    this.mb.subscribe(OO.EVENTS.INSERT_CUE_POINT, "flash_playback", _.bind(this._insertCuePoint, this));
    this.mb.subscribe(OO.EVENTS.TOGGLE_SHARE_PANEL, 'flash_playback', _.bind(this._toggleSharePanel,this));
    this.mb.subscribe(OO.EVENTS.TOGGLE_INFO_PANEL, 'flash_playback', _.bind(this._toggleInfoPanel,this));
    this.mb.subscribe(OO.EVENTS.SHOULD_DISPLAY_CUE_POINTS, 'flash_playback', _.bind(this._shouldDisplayCuePointMarkers,this));

    //clear the Ooyala Debug Panel
    if (OO.chromeExtensionEnabled) {
      window.postMessage({ type: "OO_CLEAR_LOGS", text: "" }, "*");
    }
  };

  _.extend(FlashPlaybackModule.prototype, {

    _getDuration: function() {
      if (this._isStandaloneAd || this._playingAd) { return this._adDuration; }
      return this._duration;
    },

    _onAuthorizationFetched: function(event, response) {
      if (OO.playerParams.flash_performance) {
        // Note(bz): keep a copy of the sas response for flash playback in case the player isn't embedded yet
        // and we need to retry setting the sas response when the player is embedded
        this.sasResponse[this.embedCode] = response;
        this._setFlashParams();
      }
    },

    _onWillFetchPlayerXml: function(event, request) {
      if (OO.playerParams.flash_performance) {
        this.playerXmlRequest = $.ajax({
          url: OO.URLS.PLAYER_XML(request),
          type: 'GET',
          dataType: 'text',
          cache:false,
          success: _.bind(this._onPlayerXmlFetched, this)
        });
      }
    },

    _onPlayerXmlFetched: function(response) {
      if (OO.playerParams.flash_performance) {
        this.mb.publish(OO.EVENTS.PLAYER_XML_FETCHED);
        this.playerXml[this.embedCode] = response;
        this._setFlashParams();
      }
    },

    _createFlashElement: function(parentContainer) {
      this.flashId = 'OoFlash' + OO.getRandomString();
      OO.publicApi[this.flashId] = _.bind(this._onFlashCallBack, this);

      var params = '';
      this.params['flashParams'] = this.params['flashParams'] || {};

      // Note(jdlew): We are ignoring autoplay in the flashParams hash.
      // We only respect the top-level 'autoplay'.
      delete this.params['flashParams']['autoplay'];

      // check autoplay
      if (OO.allowAutoPlay && (this.params.autoPlay === 'true' || this.params.autoPlay === true ||
          this.params.autoplay === 'true' || this.params.autoplay === true)) {
        this.params['flashParams']['autoplay'] = '1';
      }

      delete this.params['flashParams']['loop'];

      // check loop
      if (OO.allowLoop && (this.params.loop === 'true' || this.params.loop === true)) {
        this.params['flashParams']['loop'] = '1';
      }

      var swfUrl = OO.URLS.PLAYER_SWF({
        server: OO.playerParams.flash_player_url || OO.SERVER.API + '/player.swf',
        player: OO.playerParams.playerBrandingId
      });

      if (OO.playerParams.flash_version) {
        swfUrl += "&flash_version=" + OO.playerParams.flash_version;
      }

      if (OO.playerParams.use_asp_flash_route) {
        swfUrl = swfUrl.replace("player.swf", "asp/player.swf");
      }

      var callback = (OO.playerParams.namespace || 'OO') + '.' + this.flashId;
      var flashVars = {
        playerBrandingId: OO.playerParams.playerBrandingId,
        version: 2,
        embedType: OO.playerParams.flash_performance && this.enableChannels === false ? 'mjolnir' : 'nuplayer',
        embedStyle: 'mjolnir',
        me: this.flashId,
        callback: callback,
        width: '100%',
        height: '100%'
      };

      _.extend(flashVars, this.params['flashParams']);  // take any overrides
      if(!!this.params['layout']) {       // check for top-level layout
        flashVars['layout'] = this.params['layout'];
      }
      if (this.enableDiagnostics) {
        flashVars.diagnosticCallback = callback;
      }
      if (this.debugHost) {
        flashVars.debugHost = this.debugHost;
      }
      if (this.isTwitter) {
        flashVars.isTwitter = this.isTwitter;
      }
      if (this.adSetCode) {
        flashVars.adSetCode = this.adSetCode;
      }
      if (this.params.preload !== undefined) {
        flashVars.preload = this.params.preload;
      }
      if (this.params.shouldDisplayCuePointMarkers !== undefined) {
        flashVars.shouldDisplayCuePointMarkers = this.params.shouldDisplayCuePointMarkers;
      }
      if (this.showInAdControlBar) {
        flashVars.showInAdControlBar = this.showInAdControlBar;
      }
      if (this.showAdMarquee) {
        flashVars.showAdMarquee = this.showAdMarquee;
      }
      if (this.params.tpmOverrides) {
        flashVars.tpmOverrides = this.params.tpmOverrides;
      }

      if (this.params.adRequestTimeout !== undefined) {
        flashVars.adRequestTimeout = this.params.adRequestTimeout;
      }

      if (this.params.locale !== undefined) {
        flashVars.locale = this.params.locale;
      }

      flashVars['flash_version'] = OO.playerParams.flash_version || "";
      flashVars['v3_version'] = OO.playerParams.v3_version || "";

      //Prioritize flashvars from options hash over default o0jsDebug
      flashVars.o0jsdebug = flashVars.o0jsdebug || this.o0jsdebug;

      this.flashVars = flashVars; // save those for later so we can pass them again in setQueryStringParams

      var flashEmbed = (OO.isIE && !OO.isIE11Plus) ? OO.TEMPLATES.FLASH_IE : OO.TEMPLATES.FLASH;
      var template = OO.supportsFlash ? flashEmbed : OO.TEMPLATES.MESSAGE;
      var flash_html = _.template(template)({
        playerId: this.flashId,
        swfUrl: swfUrl,
        flashVars: $.param(flashVars),
        wmode: this.params.wmode || 'direct',
        message: OO.TEMPLATES.FLASH_INSTALL,

        __end_marker:true
      });

      parentContainer.append(flash_html);
      $("#" + this.flashId).css({ left: '0px' });
      var dom = parentContainer.find("object.video")[0];
      // for non-IE, the nested dom are the actural flash object
      var nestedDom = parentContainer.find("object.video object")[0];
      return nestedDom || dom;
    },

    _onFlashCallBack: function(playerId, eventName, params) {
      if (playerId !== this.flashId) { return; }
      switch (eventName) {
        case "playerEmbedded":
          this.mb.publish(OO.EVENTS.PLAYER_EMBEDDED);
          this.playerEmbedded = true;
          this._setFlashParams();
          break;
        case "totalTimeChanged":
          this._duration = params.totalTime;
          this.mb.publish(OO.EVENTS.PLAYHEAD_TIME_CHANGED, this._playheadTime, this._getDuration(), this.videoWrapper.getBufferLength());
          break;
        case "playheadTimeChanged":
          this._playheadTime = params.playheadTime;
          this.mb.publish(OO.EVENTS.PLAYHEAD_TIME_CHANGED, this._playheadTime, this._getDuration(), this.videoWrapper.getBufferLength());
          break;
        case "embedCodeChanged":
        case "currentItemEmbedCodeChanged":
          this.mb.publish(OO.EVENTS.EMBED_CODE_CHANGED, params);
          this.mb.publish(OO.EVENTS.CONTENT_TREE_FETCHED, params);
          this.embedCodeChanged = true;
          if (this.queuedPlaybackReady) {
            this.mb.publish(OO.EVENTS.PLAYBACK_READY);
            this.queuedPlaybackReady = false;
          }
          break;
        case "fullscreenChanged":
          this.mb.publish(OO.EVENTS.FULLSCREEN_CHANGED, params.state == 'fullScreen');
          break;
        case "closedCaptionsTextReady":
          this._reportClosedCaptions();
          break;
        case "stateChanged":
          switch (params.state) {
            case "error":
              this.mb.publish(OO.EVENTS.ERROR, { code : params.errorCode, source : 'flash' });
              break;
            case "playing":
              this.mb.publish(OO.EVENTS.PLAYING);
              this._reportBitrates();
              break;
            case "paused":
              this.mb.publish(OO.EVENTS.PAUSED);
              break;
            case "buffering":
              this.mb.publish(OO.EVENTS.BUFFERING);
              break;
            default:
              OO.log('CALLBACK', arguments);
          }
          break;
        case "apiReady":
          if (((this.embedCode && this.embedCode === this.videoWrapper.getEmbedCode()) ||
              OO.CONSTANTS.STANDALONE_AD_HOLDER === this.videoWrapper.getEmbedCode()) &&
              !this.playbackReady) {
            if (!this.embedCodeChanged) {
              // PB-702 - sometimes flash player is stupid and sends apiReady before embedCodeChanged.
              this.queuedPlaybackReady = true;
            } else {
              this.mb.publish(OO.EVENTS.PLAYBACK_READY);
            }
            this.playbackReady = true;
          }
          break;
        case "playComplete":
          this.mb.publish(OO.EVENTS.PLAYED);
          break;
        case "volumeChanged":
          this.mb.publish(OO.EVENTS.VOLUME_CHANGED, params.volume);
          break;
        case 'companionAdsReady':
          this.mb.publish(OO.EVENTS.WILL_SHOW_COMPANION_ADS, {ads: params.companionAds});
          break;
        case 'adStarted':
          this._adDuration = params.adDuration / 1000;
          this._playingAd = true;
          var adItem = { duration: this._adDuration, type: 'flashad', format: params.format,
                source: params.source };
          this.mb.publish(OO.EVENTS.WILL_PLAY_ADS, adItem);
          break;
        case 'adCompleted':
          this._playingAd = false;
          this.mb.publish(OO.EVENTS.ADS_PLAYED);
          break;
        case 'singleAdStarted':
          var singleAdItem = { duration: params.adDuration / 1000, adId: params.adId,
            creativeId: params.creativeId, type: 'flashad', format: params.format,
            source: params.source };
          this.mb.publish(OO.EVENTS.WILL_PLAY_SINGLE_AD, singleAdItem);
          break;
        case 'singleAdCompleted':
          this.mb.publish(OO.EVENTS.SINGLE_AD_PLAYED);
          break;
        case 'adError':
          this._playingAd = false;
          this.mb.publish(OO.EVENTS.ADS_ERROR);
          break;
        case "seeked":
          this.mb.publish(OO.EVENTS.SCRUBBED);
          break;
        case "targetBitrateChanged":
          this._reportBitrates();
          break;
        case "adClicked":
          this.mb.publish(OO.EVENTS.ADS_CLICKED);
          break;
        case "getOoyalaStorageItem":
          OO.ooyalaStorage.getItem(params.key, _.bind(function(value) {
            this._fire("getOoyalaStorageItemResponse", [params.key, value]);
          }, this));
          break;
        case "setOoyalaStorageItem":
          OO.setItem(params.key, params.value, _.bind(function(value) {
            this._fire("setOoyalaStorageItemResponse", [params.key, value]);
          }, this));
          break;
        case "removeOoyalaStorageItem":
          OO.ooyalaStorage.removeItem(params.key, _.bind(function(value) {
            this._fire("removeOoyalaStorageItemResponse", [params.key, value]);
          }, this));
          break;
        case "sharePanelClicked":
          this.mb.publish(OO.EVENTS.SHARE_PANEL_CLICKED);
          break;
        case "infoPanelClicked":
          this.mb.publish(OO.EVENTS.INFO_PANEL_CLICKED);
          break;
        case "authTokenChanged":
          this.mb.publish(OO.EVENTS.AUTH_TOKEN_CHANGED, params);
          break;
        case "startContentDownload":
          this.mb.publish(OO.EVENTS.DOWNLOADING, this._playheadTime,
            this._getDuration(), this.videoWrapper.getBufferLength(),
            null, params.streamURL);
          break;
        case "bitrateChanged":
          var bitrateItem = { videoBitrate : params.videoBitrate };
          this.mb.publish(OO.EVENTS.BITRATE_CHANGED, bitrateItem);
          break;
        case "subscribeToMessage":
          this.mb.subscribe(params.messageName, "flash_playback", _.bind(function(){this.videoWrapper[params.callback]();}, this));
          break;
        // We need to explicitly catch all known flash events that we do NOT want to propagate to V3 clients
        // Feel free to add to this list if you find something missing
        case "loadComplete":
        case "activePanelChanged":
        case "metadataReady":
        case "recommendedContentReady":
        case "relatedMediaReady":
        case "playerResize":
        case "attemptFullScreenChange":
        case "videoShared":
          OO.log('Ignoring flash callback', eventName, params);
          break;
        // Any event that drops through here is custom event, so should be pushed into message bus
        default:
          OO.log('Propagating flash callback', eventName, params);
          this.mb.publish(eventName, params);
      }
      if (this.enableDiagnostics) {
        this.mb.publish('ASP' + eventName, params);
      }
    },

    _fire: function(type, params) {
      if (this.playerEmbedded) { this.videoWrapper.fire({type: type, params: params}); }
    },

    _notifyTokenReadyForPlayer: function() {
      if (this.waitingForToken && this.adobeToken) {
          this.waitingForToken = false;
          this._fire('setEmbedToken', [this.adobeToken]);
      }
    },

    _adobeWaitingForToken: function(event) {
      this.waitingForToken = true;
      this._notifyTokenReadyForPlayer();
    },

    _adobeTokenFetched: function(event, token) {
      OO.log("setEmbedToken", token);
      this.adobeToken = token;
      this._notifyTokenReadyForPlayer();
    },

    _adobeAuthStatus: function(event, isAuthenticated, errorCode) {
      if (!isAuthenticated) { this.adobeToken = null; }
      this._fire('setAuthenticationStatus', [isAuthenticated, errorCode]);
      //TODO (mlen): this actually isn't handled in Flash.  Should it be?
    },

    _onError: function(event, errorType, errorCode) {
      if (errorType == OO.ERROR.ADOBE_PASS_TOKEN) {
        this.adobeToken = null;
        this._fire('tokenRequestFailed', [this.embedCode, errorCode]);
      }
    },

    _setFlashParams: function() {
      if (this.videoWrapper && this.playerEmbedded && !this.areFlashParamsSet) {

        // check if we need to wait for playerXml or sasResponse
        if (OO.playerParams.flash_performance) {
          if(!this.playerXml[this.embedCode] || !this.sasResponse[this.embedCode]) {
            return;
          }
        }

        var moduleParam = this.params || {};

        if (this.adobeToken) {
          moduleParam.authorization = { "embedToken" : this.adobeToken };
        } else if (!_.isEmpty(this.embedToken)) {
          moduleParam.authorization = { "embedToken": this.embedToken };
        }

        if (!_.isEmpty(moduleParam.authToken)) {
          if (moduleParam.authorization) {
            _.extend(moduleParam.authorization, { "authToken": moduleParam.authToken });
          } else {
            moduleParam.authorization = { "authToken": moduleParam.authToken };
          }
        }

        // apply flash params to module params
        _.extend(moduleParam, moduleParam['flashParams']);
        delete moduleParam['flashParams'];
        this.videoWrapper.setModuleParams(moduleParam);

        var params = _.extend({playerBrandingId: OO.playerParams.playerBrandingId}, this.options);
        this.queryStringParams = _.pick(params, this.QUERY_STRING_PARAM_WHITELIST);
        this.videoWrapper.setQueryStringParameters(_.extend(this.queryStringParams, this.flashVars || {}));

        if (OO.playerParams.flash_performance) {
          // TODO(pb-team): When run with flash-performance mode, SAS authorization happens in JS code and the
          // response is given to the flash player here. When that happens, the account_id parameter from the
          // SAS response does not get propagated to the flash analytics module. This should be fixed before
          // we enable flash performance mode by default.

          // SAS response needs to be set before player XML is set
          this.videoWrapper.setSasResponse({
            embedCode: this.embedCode,
            response: this.sasResponse[this.embedCode]
          });
          this.videoWrapper.setPlayerXml(this.playerXml[this.embedCode]);
        }

        // don't reset params until embedCode changes.
        this.areFlashParamsSet = true;
      }
    },

    _setEmbedCode: function(event, embedCode, options) {
      // adset players do not set embed codes
      if (embedCode === OO.CONSTANTS.STANDALONE_AD_HOLDER) {
        this._isStandaloneAd = true;
        return;
      }
      this._isStandaloneAd = false;

      this.playbackReady = false;
      this.queuedPlaybackReady = false;
      this.embedCodeChanged = false;

      if (OO.playerParams.flash_performance) {
        if (this.playerXmlRequest) {
          this.playerXmlRequest.abort();
          this.playerXmlRequest = null;
        }
      }

      this.areFlashParamsSet = false;
      this.embedCode = embedCode;
      this.options = options || {};
      this.options.embedCode = embedCode;
      this.embedToken = this.options.embedToken || this.embedToken || this.adobeToken;
      // Prevent crash by not accessing and setting this.flashVars in the case it is undefined
      if (this.flashVars) {
        this.flashVars.adSetCode = this.options.adSetCode || this.flashVars.adSetCode || "";
      }
      _.extend(this.params, options);
      this._setFlashParams();
    },

    _playerWasCreated: function(event, elementId, params) {
      this.elementId = elementId;
      this.rootElement = $('#'+this.elementId + '>div');

      this.params = params;
      this.params.playerBrandingId = OO.playerParams.playerBrandingId;
      this.enableDiagnostics = params.enableDiagnostics || false;
      this.enableChannels = (OO.playerParams.enableChannels === "true" ? true : false) ||
                            (this.params.enableChannels === "true" ? true : false);
      this.debugHost = OO.playerParams.debugHost || this.params.debugHost || this.debugHost;

      //if extension enabled, hit static API for player.log. if namespaced, use that
      var defaultJsDebug = OO.chromeExtensionEnabled ? (OO.playerParams.namespace || "OO") + ".Player.flashDebugCallback" : null;
      this.o0jsdebug = OO.playerParams.o0jsdebug || this.params.o0jsdebug || defaultJsDebug;

      this.isTwitter = OO.playerParams.isTwitter || this.params.isTwitter || this.isTwitter;
      this.embedToken = params ? params.embedToken : undefined;
      this.adSetCode = params ? params.adSetCode : undefined;
      this.showInAdControlBar = params ? params.showInAdControlBar : undefined;
      this.adRequestTimeout = params ? params.adRequestTimeout : undefined;
      this.showAdMarquee = params ? params.showAdMarquee : undefined;

      // display initial ui
      this.videoWrapper = this._createFlashElement(this.rootElement);

      if (!OO.supportsFlash) {
        this.mb.publish(OO.EVENTS.ERROR, { source: "flash", code: OO.ERROR.UNPLAYABLE_CONTENT });
      }
    },

    _play: function(event, streamUrl) {
      this.videoWrapper.playMovie();
      // send out volume (flash don't have it before play)
      this.mb.publish(OO.EVENTS.VOLUME_CHANGED, this.videoWrapper.getVolume());
    },

    _pause: function(event) {
      this.videoWrapper.pauseMovie();
    },

    _toggleSharePanel: function(event) {
      this.videoWrapper.toggleSharePanel();
    },

    _toggleInfoPanel: function(event) {
      this.videoWrapper.toggleInfoPanel();
    },

    _shouldDisplayCuePointMarkers: function(event, visible) {
      this.videoWrapper.shouldDisplayCuePointMarkers(visible);
    },

    _seek: function(event, seconds) {
      this.videoWrapper.seek(seconds);
    },

    _changeVolume: function(event, volume) {
      this.videoWrapper.setVolume(volume);
    },

    _skipAd: function() {
      this.videoWrapper.skipAd();
    },

    _reportBitrates: function() {
      this.mb.publish(OO.EVENTS.BITRATE_INFO_AVAILABLE, {
        bitrateQualities: this.videoWrapper.getBitrateQualitiesAvailable(),
        bitrates: this.videoWrapper.getBitratesAvailable(),
        targetBitrateQuality: this.videoWrapper.getTargetBitrateQuality(),
        targetBitrate: this.videoWrapper.getTargetBitrate()
      });
    },

    _setTargetBitrate: function(event, bitrate) {
      this.videoWrapper.setTargetBitrate(bitrate);
    },

    _setTargetBitrateQuality: function(event, bitrateQuality) {
      this.videoWrapper.setTargetBitrateQuality(bitrateQuality);
    },

    _setClosedCaptionsLanguage: function(event, language) {
      this.videoWrapper.setClosedCaptionsLanguage(language);
    },

    _reportClosedCaptions: function() {
      try {
        this.mb.publish(OO.EVENTS.CLOSED_CAPTIONS_INFO_AVAILABLE, this.videoWrapper.getCurrentItemClosedCaptionsLanguages());
      } catch(e) {
      }
    },

    _fetchStyle: function() {
      this.mb.publish(OO.EVENTS.STYLE_FETCHED, this.videoWrapper.getStyles());
    },

    _setStyle: function(event, style) {
      this.videoWrapper.setStyles(style);
    },

    _insertCuePoint: function(event, type, preloadTime, duration) {
      this.videoWrapper.insertCuePoint(type, preloadTime || 0, duration || 0);
    },


    __placeholder:true
  });

  OO.registerModule('flash_playback', function(messageBus, id) {
    return new FlashPlaybackModule(messageBus, id);
  });

}(OO, OO._, OO.$));
(function(OO,_,$){
  /*
   *  Defines the playback controller
   */

  var ApiModule = function(messageBus, id, params) {
    if (OO.playerParams.platform === "flash-adset") { return; }
    this.mb = messageBus;
    this.id = id;
    this.params = params || {};

    this.contentTree = {};
    this.metadata = {};
    this.sasResponse = {};
    this.authToken = OO.localStorage.getItem("oo_auth_token");

    this._aborting = false;
    this._contentAjax = null;
    this._metadataAjax = null;
    this._sasAjax = null;

    OO.StateMachine.create({
      initial:'Init',
      messageBus:this.mb,
      moduleName:'Api',
      target:this,
      events:[
        {name:OO.EVENTS.SET_EMBED_CODE,                     from:'*',                                          to:'Init'},
        {name:OO.EVENTS.EMBED_CODE_CHANGED,                 from:'Init',                                       to:'WaitingForAPIResponse'},

        {name:OO.EVENTS.WILL_FETCH_CONTENT_TREE,            from:'WaitingForAPIResponse'},
        {name:OO.EVENTS.WILL_FETCH_METADATA,                from:'WaitingForAPIResponse'},
        {name:OO.EVENTS.WILL_FETCH_AUTHORIZATION,           from:'WaitingForAPIResponse'},
        {name:OO.EVENTS.WILL_FETCH_AD_AUTHORIZATION,        from:['WaitingForAPIResponse', "Init"]},

        {name:OO.EVENTS.PLAYBACK_READY,                     from:'WaitingForAPIResponse',                      to:'Init'},
      ]
    });
  };

  _.extend(ApiModule.prototype, {

    onSetEmbedCode: function(event, embedCode, options) {
      // store parameters
      this.rootEmbedCode = embedCode;
      this.adSetCode = options ? options.adSetCode : undefined;
      this.embedToken = (options && options.embedToken) || this.embedToken;
      this.authToken = (options && options.authToken) || this.authToken;
      this.mb.publish(OO.EVENTS.EMBED_CODE_CHANGED, embedCode, options);
    },

    onEmbedCodeChanged: function(event, embedCode) {
      // store parameters
      this.currentEmbedCode = embedCode;

      this._abort(this._contentAjax);
      this._abort(this._metadataAjax);
      this._abort(this._sasAjax);

      // start server request
      var request = {
        embedCode: this.currentEmbedCode,
        pcode: OO.playerParams.pcode || "unknown",
        playerBrandingId : OO.playerParams.playerBrandingId || "unknown",
        params: {}
      };

      if (!_.isEmpty(this.adSetCode)) {
        _.extend(request.params, { adSetCode: this.adSetCode });
      }
      if (!_.isEmpty(this.embedToken)) {
        _.extend(request.params, { embedToken: this.embedToken });
      }

      // Note(bz): Temporary call to fetch player xml until we move to player api
      var apiRequest = _.extend({}, request, { server: OO.SERVER.API });
      var authRequest = _.extend({}, request, { server: OO.SERVER.AUTH });

      //always publish the metadata event, but only html5 should publish the others.
      this.mb.publish(OO.EVENTS.WILL_FETCH_METADATA, apiRequest);
      if (OO.requiredInEnvironment('html5-playback') ||
        OO.requiredInEnvironment('cast-playback') || OO.playerParams.flash_performance) {
        this.mb.publish(OO.EVENTS.WILL_FETCH_PLAYER_XML, apiRequest);
        this.mb.publish(OO.EVENTS.WILL_FETCH_CONTENT_TREE, apiRequest);
        this.mb.publish(OO.EVENTS.WILL_FETCH_AUTHORIZATION, authRequest);
      }
    },

    // Ooyala API Calls

    /*
     *  Content Tree
     */
    onWillFetchContentTree: function(event, request) {
      if (typeof this.contentTree[this.currentEmbedCode] != "undefined") {
        this.mb.publish(OO.EVENTS.CONTENT_TREE_FETCHED, this.contentTree[this.currentEmbedCode]);
      } else {
        this._contentAjax = $.ajax({
          url: OO.URLS.CONTENT_TREE(request) + "?" + $.param(request.params),
          type: 'GET',
          dataType: 'json',
          crossDomain: true,
          success: _.bind(this._onContentTreeFetched, this),
          error: _.bind(this._onApiError, this)
        });
      }
    },

    _onContentTreeFetched: function(response) {
      var embed_code;
      var safe_response = OO.HM.safeObject("playbackControl.contentTree", response, {});

      this._contentAjax = null;

      if (safe_response.errors && safe_response.errors.code == 0) {
        _.each(safe_response.content_tree, _.bind(function(value, embed_code){
          this.contentTree[embed_code] = safe_response.content_tree[embed_code];

        }, this));
      }

      var supportedContentType = ["Video", "VideoAd", "LiveStream", "Channel", "MultiChannel"];
      if (this.contentTree[this.currentEmbedCode]) {
        var hostedAtURL = safe_response.content_tree[this.currentEmbedCode].hostedAtURL;
        if (hostedAtURL == "" || hostedAtURL == null) {
          safe_response.content_tree[this.currentEmbedCode].hostedAtURL = document.URL;
        }

        var contentIsSupportedInHtml5 = supportedContentType.indexOf(this.contentTree[this.currentEmbedCode].content_type) >= 0;
        if (contentIsSupportedInHtml5 || OO.playerParams.flash_performance) {
          this.mb.publish(OO.EVENTS.CONTENT_TREE_FETCHED, this.contentTree[this.currentEmbedCode], this.currentEmbedCode);
        } else {
          this.mb.publish(OO.EVENTS.ERROR, { code : OO.ERROR.API.CONTENT_TREE });
        }
      } else {
        this.mb.publish(OO.EVENTS.ERROR, { code : OO.ERROR.UNPLAYABLE_CONTENT });
      }
    },


    /*
     *  Metadata
     */
    onWillFetchMetadata: function(event, request) {
      // send the metadata request
      if (typeof this.metadata[this.currentEmbedCode] != "undefined") {
        this.mb.publish(OO.EVENTS.METADATA_FETCHED, this.metadata[this.currentEmbedCode]);
      } else {
        this._metadataAjax = $.ajax({
          url: OO.URLS.METADATA(request) + "&" + $.param(request.params),
          type: 'GET',
          dataType: 'json',
          crossDomain: true,
          success: _.bind(this._onMetadataFetched, this),
          error: _.bind(this._onApiError, this)
        });
      }
    },

    _onMetadataFetched: function(response) {
      this.metadata = this.metadata || {};
      var safeResponse = OO.HM.safeObject("api.metadata", response, {});
      this._metadataAjax = null;

      if (safeResponse.errors && safeResponse.errors.code == 0) {
        _.each(safeResponse.metadata, _.bind(function(value, embedCode){
          this.metadata[embedCode] = safeResponse.metadata[embedCode];

          // allow to override module params from player params
          this.metadata[embedCode].modules = this.metadata[embedCode].modules || {};
          this.metadata[embedCode].modules = _.extend(this.metadata[embedCode].modules, this.params.modules || {});
        }, this));
      }
      this.mb.publish(OO.EVENTS.METADATA_FETCHED, this.metadata[this.currentEmbedCode] || {});

      if (safeResponse.errors && safeResponse.errors.player_movie_mismatch &&
        typeof(window.console) != "undefined" && typeof(window.console.log) == "function") {
          console.log("WARNING: Player and movie providers do not match");
      }
    },

    /*
     *  SAS
     */
    onWillFetchAuthorization: function(event, request) {
      if (this.sasResponse[this.currentEmbedCode] && this.sasResponse[this.currentEmbedCode].code == 0) {
        this.mb.publish(OO.EVENTS.AUTHORIZATION_FETCHED, this.sasResponse[this.currentEmbedCode]);
      } else {
        //add additional params for SAS
        this._sendSasRequest(request, _.bind(this._onAuthorizationFetched, this), _.bind(this._onApiError, this));
      }
    },

    _onAuthorizationFetched: function(response) {
      var code, codes;
      this._sasAjax = null;

      if (OO.requiredInEnvironment('flash-playback')) {
        // Flash needs the entire response and will handle individual embed code authorization_data
        this.sasResponse[this.currentEmbedCode] = response;
        code = response.authorization_data[this.currentEmbedCode].code;
      } else {
        var safe_response = OO.HM.safeObject("playbackControl.sasResponse", response, {});

        //save auth token
        if (safe_response.auth_token) {
          OO.setItem("oo_auth_token", safe_response.auth_token);
          this.authToken = safe_response.auth_token;
        } else {
          OO.localStorage.removeItem("oo_auth_token");
          this.authToken = null;
        }

        _.each(safe_response.authorization_data, _.bind(function(value, embed_code){
          this.sasResponse[embed_code] = safe_response.authorization_data[embed_code];
          if (safe_response.debug_data) {
            this.sasResponse[embed_code].debug_data = safe_response.debug_data;
          }
          if (safe_response.user_info) {
            this.sasResponse[embed_code].user_info = safe_response.user_info;
          }
          if (safe_response.auth_token) {
            this.sasResponse[embed_code].auth_token = safe_response.auth_token;
          }
          if (safe_response.heartbeat_data) {
            this.sasResponse[embed_code].heartbeat_data = safe_response.heartbeat_data;
          }
        }, this));
        code = this.sasResponse[this.currentEmbedCode].code;
      }

      // Always publish the Authorization Response for Flash and only publish this on success for HTML5
      if ((code == 0) || OO.requiredInEnvironment('flash-playback')) {
        this.mb.publish(OO.EVENTS.AUTHORIZATION_FETCHED, this.sasResponse[this.currentEmbedCode]);
        return;
      }
      if (!_.isString(code)) {
        this.mb.publish(OO.EVENTS.ERROR, { code : OO.ERROR.API.SAS.GENERIC });
        return;
      }
      codes = code.split(',');
      if (_.contains(codes, '2')) {
        this.mb.publish(OO.EVENTS.ERROR, { code : OO.ERROR.API.SAS.DOMAIN });
      } else if (_.contains(codes, '3')) {
        this.mb.publish(OO.EVENTS.ERROR, { code : OO.ERROR.API.SAS.GEO });
      } else if (_.contains(codes, '4')) {
        this.mb.publish(OO.EVENTS.ERROR, { code : OO.ERROR.API.SAS.FUTURE });
      } else if (_.contains(codes, '5')) {
        this.mb.publish(OO.EVENTS.ERROR, { code : OO.ERROR.API.SAS.PAST });
      } else if (_.contains(codes, '13')) {
        this.mb.publish(OO.EVENTS.ERROR, { code : OO.ERROR.API.SAS.DEVICE });
      } else if (_.contains(codes, '18')) {
        this.mb.publish(OO.EVENTS.ERROR, { code : OO.ERROR.API.SAS.CONCURRENT_STREAMS });
      } else if (_.contains(codes, '24')) {
        this.mb.publish(OO.EVENTS.ERROR, { code : OO.ERROR.API.SAS.PROXY });
      } else {
        this.mb.publish(OO.EVENTS.ERROR, { code : OO.ERROR.API.SAS.GENERIC });
      }
    },

    onWillFetchAdAuthorization: function(event, request) {
      this._sendSasRequest(request, _.bind(this._onAdAuthorizationFetched, this));
    },

    _onAdAuthorizationFetched: function(response) {
      var safe_response = OO.HM.safeObject("playbackControl.sasResponse", response, {});

      var ooyalaAds = {};
      _.each(safe_response.authorization_data, _.bind(function(value, embed_code){
        ooyalaAds[embed_code] = safe_response.authorization_data[embed_code];
      }, this));

      this.mb.publish(OO.EVENTS.AD_AUTHORIZATION_FETCHED, ooyalaAds);
    },

    _sendSasRequest: function(request, callback, errorback) {
      var formats = _.reduce(OO.supportedVideoTypes, function(s, supported, type) {
        if (supported) { s.push(type); }
        return s;
      }, []),
      profiles = OO.supportedVideoProfiles,
      device = OO.device;

      $.extend(request.params, { device: device, domain:OO.docDomain, supportedFormats:formats.join(',')});
      if (profiles) {
       $.extend(request.params, {profiles:profiles}); // set profiles if any
      }
      if (this.authToken) {
        $.extend(request.params, { auth_token: this.authToken });
      }

      this._sasAjax = $.ajax({
        url: OO.URLS.SAS(request) + "?" + $.param(request.params),
        type: 'GET',
        dataType: 'json',
        crossDomain: true,
        success: callback,
        error: errorback
      });
    },

    _abort: function(ajax) {
      if (!ajax) { return; }
      this._aborting = true;
      ajax.abort();
      this._aborting = false;
    },

    _onApiError: function(xhr, status, error) {
      if (this._aborting) { return; }

      OO.d(error, status, xhr);
      this.mb.publish(OO.EVENTS.ERROR, { code : OO.ERROR.API.NETWORK, xhrStatus : status });
    },

    __placeholder: true
  });

  OO.registerModule('api', function(messageBus, id, params) {
    return new ApiModule(messageBus, id, params);
  });
}(OO, OO._, OO.$));
  OO.plugin("Channels", function(OO, _, $, W) {

    /*
     * Channel Module:  Intercept all CONTENT_TREE_FETCHED events.
     *   If the player is a flash player, and channels are enabled, play the flash player v2 style
     *   If the player is a flash player, and channels are disabled, publish an error
     *   If the player is html5 and channels are enabled, play the first video of the channel
     *   If the player is html5 and channels are disabled, publish an error
     */
    var Channels = function(mb, id) {
      this.id = id;
      this.mb = mb;
      this.channel_tree = null;
      this.channel_pos = -1;
      this.replay = false;

      OO.StateMachine.create({
        initial:'Init',
        messageBus:this.mb,
        moduleName:'Channels',
        target:this,
        events:[
          {name:OO.EVENTS.PLAYER_CREATED, from:'*'}
        ]
      });
    };

    _.extend(Channels.prototype, {
      onPlayerCreated: function(event, elementId, params) {
        this.enableChannels = params.enableChannels || OO.playerParams.enableChannels || false;
        this.mb.intercept(OO.EVENTS.CONTENT_TREE_FETCHED, "channels",
          _.bind(this._checkTreeForChannel, this));
      },

      _checkTreeForChannel: function(eventName, tree) {
        var supportedContentType = ["Channel", "MultiChannel"];

        //if i get a tree from V3, it will have contenttype
        if (tree && (supportedContentType.indexOf(tree.content_type) >= 0 || tree.lineup)) {
          if (this.enableChannels) {
            //if this is a html5 player, take first child's embed code
            if (OO.requiredInEnvironment('html5-playback') || OO.requiredInEnvironment('cast-playback')) {
              if(!tree.children) {
                if(tree.content_type == 'Channel') {
                  this.mb.publish(OO.EVENTS.ERROR, { code : OO.ERROR.EMPTY_CHANNEL });
                } else {
                  this.mb.publish(OO.EVENTS.ERROR, { code : OO.ERROR.EMPTY_CHANNEL_SET });
                }
                return false;
              }
              this.channel_tree = tree;
              this.channel_pos = 0;
              this.mb.subscribe(OO.EVENTS.PLAYED, 'channels', _.bind(this.onPlayed, this));
              this.mb.subscribe(OO.EVENTS.PLAYBACK_READY, 'channels', _.bind(this.onPlaybackReady, this));
              this.mb.publish(OO.EVENTS.SET_EMBED_CODE, tree.children[0].embed_code);
            }
            return false;
          }

          //If this is a channel, and channels are not enabled, error out
          this.mb.publish(OO.EVENTS.ERROR, { code : OO.ERROR.CHANNEL_CONTENT });
          return false;
        }

        return [tree];
      },


      onPlayed: function(event) {
        this.channel_pos++;

        //Every time a video is played, set the embed code to the next video.
        if(this.channel_tree.children[this.channel_pos]) {
          this.mb.publish(OO.EVENTS.SET_EMBED_CODE, this.channel_tree.children[this.channel_pos].embed_code);
        }

        //If we played the last video, reset to the first video
        else {
          this.channel_pos = 0;
          this.mb.publish(OO.EVENTS.SET_EMBED_CODE, this.channel_tree.children[0].embed_code);
        }
      },

      //Every time the video is loaded (other than first), autoplay
      onPlaybackReady: function(event) {
        if(this.channel_pos > 0) {
          this.mb.publish(OO.EVENTS.PLAY);
        }
      }
    });

    // Return class definition.
    return Channels;
  });
OO.plugin("ExternalId", function(OO, _, $, W) {

  /*
   * Channel Module:  Intercept all CONTENT_TREE_FETCHED events.
   *   If the player is a flash player, and ExternalId are enabled, play the flash player v2 style
   *   If the player is a flash player, and ExternalId are disabled, publish an error
   *   If the player is html5 and ExternalId are enabled, play the first video of the channel
   *   If the player is html5 and ExternalId are disabled, publish an error
   */
  var ExternalId = function(mb, id) {
    this.id = id;
    this.mb = mb;

    this.mb.intercept(OO.EVENTS.SET_EMBED_CODE, "ExternalId", _.bind(this._checkExternalId, this));
  };

  _.extend(ExternalId.prototype, {
    /*
     *  External ID lookup
     */
     _checkExternalId: function(event, embedCode, options) {
       var externalId = embedCode.match("^extId:(.*)");
       if (externalId && externalId[1]) {
         this.externalId = externalId[1];
         this.options = options;
         this._fetchExternalId({
           externalId: this.externalId,
           pcode: OO.playerParams.pcode || "1kNG061cgaoolOncv54OAO1ceO-I",
           server: OO.SERVER.API
         });
         return false;
       }
       return [embedCode, options];
     },

    _fetchExternalId: function(request) {
      this._contentAjax = $.ajax({
        url: OO.URLS.EXTERNAL_ID(request),
        type: 'GET',
        dataType: 'json',
        crossDomain: true,
        cache:false,
        success: _.bind(this._onExternalIdFetched, this),
        error: _.bind(this._onExternalIdError, this)
      });
    },

    _onExternalIdFetched: function(response) {
      var embedCode = null;
      var safe_response = OO.HM.safeObject("playbackControl.contentTree", response, {});

      if (safe_response.errors && safe_response.errors.code == 0) {
        _.each(safe_response.content_tree, _.bind(function(value, ec){
          if (value["external_id"] === this.externalId) {
            embedCode = ec;
          }
        }, this));
      }

      // save the external Id in the option hash (in case it's needed for analytics and such)
      _.extend(this.options, {originalId : this.externalId});

      if (embedCode) {
        this.mb.publish(OO.EVENTS.SET_EMBED_CODE, embedCode, this.options);
      } else {
        this.mb.publish(OO.EVENTS.ERROR, { code: OO.ERROR.INVALID_EXTERNAL_ID });
      }
    },

    _onExternalIdError: function(response) {
      this.mb.publish(OO.EVENTS.ERROR, { code: OO.ERROR.INVALID_EXTERNAL_ID });
    }
  });

  // Return class definition.
  return ExternalId;
});
(function(OO, _, $){

  var AuthHeartbeat = function(messageBus, id) {
    if (!OO.requiredInEnvironment('html5-playback') && !OO.requiredInEnvironment('cast-playback')) { return; }
    this.mb = messageBus;
    this.id = id;

    this.embedCode = null;
    this.authToken = null;
    this.heartbeatInterval = 300;  // in sec
    this.timer = null;
    this.retries = 3;

    //internal constants
    this.AUTH_HEARTBEAT_URL = _.template('<%=server%>/player_api/v1/auth_heartbeat/pcode/<%=pcode%>/auth_token/<%=authToken%>?embed_code=<%=embedCode%>');

    //listeners
    this.mb.subscribe(OO.EVENTS.EMBED_CODE_CHANGED, 'auth_heartbeat', _.bind(this._onEmbedCodeChanged, this));
    this.mb.subscribe(OO.EVENTS.AUTHORIZATION_FETCHED, 'auth_heartbeat', _.bind(this._onAuthorizationFetched, this));
  };

  _.extend(AuthHeartbeat.prototype, {
    _onEmbedCodeChanged: function(event, embedCode) {
      this.embedCode = embedCode;
      if (this.timer) {
        clearInterval(this.timer);
      }
      if (this.ajax) {
        this.ajax.error = null;
        this.ajax.abort();
        this.ajax = null;
      }
      this.retries = 3;
    },

    _onAuthorizationFetched: function(event, authResponse) {
      if (authResponse.heartbeat_data && authResponse.heartbeat_data.heartbeat_interval) {
        this.heartbeatInterval = authResponse.heartbeat_data.heartbeat_interval;
      }
      if (authResponse.auth_token) {
        this.authToken = authResponse.auth_token;
      }
      if (authResponse.require_heartbeat === true) {
        this.timer = setInterval(_.bind(this._onTimerTick, this), this.heartbeatInterval * 1000);
        this._onTimerTick(); //Fire first heartbeat NOW.
      }
    },

    _onTimerTick: function() {
      //send heartbeat
      this.ajax = $.ajax({
        url: this.AUTH_HEARTBEAT_URL({
          server: OO.SERVER.AUTH,
          pcode: OO.playerParams.pcode || "unknown",
          authToken: this.authToken || "",
          embedCode: this.embedCode || ""
        }),
        type: 'GET',
        dataType: 'json',
        crossDomain: true,
        cache: false,
        success: _.bind(this._onHeartbeatResponse, this),
        error: _.bind(this._onHeartbeatErrorResponse, this)
      });
    },

    _onHeartbeatResponse: function(response) {
      this.ajax = null;
      if (!response.message || response.message != "OK" || !response.signature) {
        this._onHeartbeatError(OO.ERROR.API.SAS.INVALID_HEARTBEAT);
      }
      else if (!response.expires || response.expires < new Date().getTime()/1000) {
        this._onHeartbeatError(OO.ERROR.API.SAS.INVALID_HEARTBEAT);
      }
      else {
        this.retries = 3;
        if (response.auth_token != null) {
          this.authToken = response.auth_token;
          OO.setItem("oo_auth_token", response.auth_token);
        }
      }
    },

    _onHeartbeatErrorResponse: function(response) {
      this.ajax = null;
      if (response && response.responseText && response.responseText.indexOf("Invalid entitlements") > -1) {
        this._onHeartbeatError(OO.ERROR.API.SAS.ERROR_INVALID_ENTITLEMENTS);
      } else {
        this._onHeartbeatError(OO.ERROR.API.SAS.CONCURRENT_STREAMS);
      }
    },

    _onHeartbeatError: function(errorMessage) {
      this.ajax = null;
      this.retries--;

      if (this.retries > 0) {
        this._onTimerTick();
        return;
      }

      if (this.timer) {
        clearInterval(this.timer);
      }
      this.mb.publish(OO.EVENTS.ERROR, { code: errorMessage });
    }
  });

  OO.registerModule('auth_heartbeat', function(messageBus, id) {
    return new AuthHeartbeat(messageBus, id);
  });

}(OO, OO._, OO.$));
(function(OO, _, $){
  /*
   *  Defines a util function to parse the vast inline xml response to json object
   */
  var isValidVastXML = function(vastXML) {
    var rootTagName = (vastXML && vastXML.firstChild) ? vastXML.firstChild.tagName || '' : '';
    if (rootTagName.toUpperCase() != "VAST") {
      OO.log("Invalid VAST XML for tag name: " + rootTagName);
      return false;
    }

    // VAST 2.0 and 2.0.1 are supported
    // TODO, when 3.0 is supported, update this check.
    var vastVersion = $(vastXML.firstChild).attr('version');
    if (!vastVersion.match(/^2.0(.1)?$/g)) {
      OO.log("Ad Error: The vast version '" + vastVersion + "' is not supported.");
      return false;
    }
    return true;
  };

  var TrackingEvents = ['creativeView', 'start', 'midpoint', 'firstQuartile', 'thirdQuartile', 'complete',
      'mute', 'unmute', 'pause', 'rewind', 'resume', 'fullscreen', 'expand', 'collapse', 'acceptInvitation',
      'close' ];

  var getVastTemplate = function() {
    return {
      error: [],
      impression: [],
      // Note: This means we only support at most 1 linear and 1 non-linear ad
      linear: {},
      nonLinear: {},
      companion: []
    };
  };

  var filterEmpty = function(array) {
    return _.reject(array, function(x){
             return x === null || x === "";
           }, {});
  };

  var parseTrackingEvents = function(tracking, xml, trackingEvents) {
    var events = trackingEvents || TrackingEvents;
    _.each(events, function(item) {
      var sel = "Tracking[event=" + item + "]";
      tracking[item] = filterEmpty(xml.find(sel).map(function(i, v) { return $(v).text(); }));
    }, {});
  };

  var parseLinearAd = function(linearXml) {
    var result = {
      tracking: {},
      // ClickTracking needs to be remembered because it can exist in wrapper ads
      ClickTracking: filterEmpty($(linearXml).find("ClickTracking").map(function() { return $(this).text(); })),
      ClickThrough: filterEmpty($(linearXml).find("ClickThrough").map(function() { return $(this).text(); })),
      CustomClick: filterEmpty($(linearXml).find("CustomClick").map(function() { return $(this).text(); }))
    };
    var mediaFile = linearXml.find("MediaFile");

    parseTrackingEvents(result.tracking, linearXml);
    if (mediaFile.size() > 0) {
      result.mediaFiles = filterEmpty(mediaFile.map(function(i,v) {
        return {
          type: $(v).attr("type").toLowerCase(),
          url: $.trim($(v).text()),
          bitrate: $(v).attr("bitrate"),
          width: $(v).attr("width"),
          height: $(v).attr("height")
        };
      }));
      result.Duration = linearXml.find("Duration").text();
    }

    return result;
  };

  var parseNonLinearAds = function(nonLinearAdsXml) {
    var result = { tracking: {} };
    var nonLinear = nonLinearAdsXml.find("NonLinear").eq(0);

    parseTrackingEvents(result.tracking, nonLinearAdsXml);

    if (nonLinear.size() > 0) {
      var staticResource = nonLinear.find("StaticResource");
      var iframeResource = nonLinear.find("IFrameResource");
      var htmlResource = nonLinear.find("HTMLResource");
      result.width = nonLinear.attr("width");
      result.height = nonLinear.attr("height");
      result.expandedWidth = nonLinear.attr("expandedWidth");
      result.expandedHeight = nonLinear.attr("expandedHeight");
      result.scalable = nonLinear.attr("scalable");
      result.maintainAspectRatio = nonLinear.attr("maintainAspectRatio");
      result.minSuggestedDuration = nonLinear.attr("minSuggestedDuration");
      result.NonLinearClickThrough = nonLinear.find("NonLinearClickThrough").text();

      if (staticResource.size() > 0) {
        _.extend(result, { type: "static", data: staticResource.text(), url: staticResource.text() });
      } else if (iframeResource.size() > 0) {
        _.extend(result, { type: "iframe", data: iframeResource.text(), url: iframeResource.text() });
      } else if (htmlResource.size() > 0) {
        _.extend(result, { type: "html", data: htmlResource.text(), htmlCode: htmlResource.text() });
      }
    }

    return result;
  };

  var parseCompanionAd = function(companionAdXml) {
    var result = { tracking: {} };
    var staticResource = companionAdXml.find("StaticResource");
    var iframeResource = companionAdXml.find("IFrameResource");
    var htmlResource = companionAdXml.find("HTMLResource");

    parseTrackingEvents(result.tracking, companionAdXml, ["creativeView"]);

    result.width = companionAdXml.attr("width");
    result.height = companionAdXml.attr("height");
    result.expandedWidth = companionAdXml.attr("expandedWidth");
    result.expandedHeight = companionAdXml.attr("expandedHeight");
    result.CompanionClickThrough = companionAdXml.find("CompanionClickThrough").text();

    if (staticResource.size() > 0) {
      _.extend(result, { type: "static", data: staticResource.text(), url: staticResource.text() });
    } else if (iframeResource.size() > 0) {
      _.extend(result, { type: "iframe", data: iframeResource.text(), url: iframeResource.text() });
    } else if (htmlResource.size() > 0) {
      _.extend(result, { type: "html", data: htmlResource.text(), htmlCode: htmlResource.text() });
    }

    return result;
  };

  var VastAdSingleParser = function(xml, type) {
    var result = getVastTemplate();
    var linear = $(xml).find("Linear").eq(0);
    var nonLinearAds = $(xml).find("NonLinearAds");

    if (type === "wrapper") { result.VASTAdTagURI = $(xml).find("VASTAdTagURI").text(); }
    result.error = filterEmpty($(xml).find("Error").map(function() { return $(this).text(); }));
    result.impression = filterEmpty($(xml).find("Impression").map(function() { return $(this).text(); }));

    if (linear.size() > 0) { result.linear = parseLinearAd(linear); }
    if (nonLinearAds.size() > 0) { result.nonLinear = parseNonLinearAds(nonLinearAds); }
    $(xml).find("Companion").map(function(i, v){
      result.companion.push(parseCompanionAd($(v)));
      return 1;
    });

    return result;
  };

  OO.VastParser = function(vastXML) {
    if (!isValidVastXML(vastXML)) { return null; }

    var inline = $(vastXML).find("InLine");
    var wrapper = $(vastXML).find("Wrapper");
    var result = { ads: [] };

    if (inline.size() > 0) {
      result.type = "inline";
    } else if (wrapper.size() > 0) {
      result.type = "wrapper";
    } else {
      return null;
    }
    $(vastXML).find("Ad").each(function() {
      result.ads.push(VastAdSingleParser(this, result.type));
    });

    return result;
  };

}(OO, OO._, OO.$));
  (function(OO, _, $){
    OO.VastAdLoader = OO.inherit(OO.Emitter, function(embedCode) {
      this.inlineAd = null;
      this.currentDepth = 0;
      this.vastAdUnit = null;
      this.loaded = false;
      this.errorType = '';
      this.embedCode = embedCode || 'unknown';
      this.loaderId = 'OoVastAdsLoader' + OO.getRandomString();
      this.wrapperAds = { error: [],
                          impression: [],
                          companion: [],
                          linear: { tracking: {}, ClickTracking: [] },
                          nonLinear: { tracking: {} } };
    });

    _.extend(OO.VastAdLoader, {
      ERROR: 'vastError',
      READY: 'vastReady',

      __placeholder:true
    });

    _.extend(OO.VastAdLoader.prototype, {
      loadUrl: function(url, errorCallback) {
        this.vastUrl = url;
        this._ajax(url, errorCallback || this._onVastError, 'xml');
      },

      _ajax: function(url, errorCallback, dataType) {
        var done = (dataType == "script") ? function() {} : null;
        $.ajax({
          url: OO.getNormalizedTagUrl(url, this.embedCode),
          type: 'GET',
          beforeSend: function(xhr) {
            xhr.withCredentials = true;
          },
          dataType: dataType,
          crossDomain: true,
          cache:false,
          success: done || _.bind(this._onVastResponse, this),
          error: _.bind(errorCallback, this)
        });
      },

      getVastAdUnit: function() {
        return OO.safeClone(this.vastAdUnit);
      },

      _getProxyUrl: function() {
        OO.publicApi[this.loaderId] = _.bind(this._onVastProxyResult, this);
        if (OO.playerParams.vast_proxy_url) {
          return [OO.playerParams.vast_proxy_url, "?callback=OO.", this.loaderId, "&tag_url=",
              escape(this.vastUrl), "&embed_code=", this.embedCode].join("");
        }

        return OO.URLS.VAST_PROXY({
            cb: "OO." + this.loaderId,
            embedCode: this.embedCode,
            expires: (new Date()).getTime() + 1000,
            tagUrl: escape(this.vastUrl)
        });
      },

      _onVastError: function(event) {
        this.errorType = 'directAjaxFailed';
        this._ajax(this._getProxyUrl(), this._onFinalError, 'script');
        this.trigger(OO.VastAdLoader.ERROR, this);
      },

      _onFinalError: function() {
        this.errorType = "proxyAjaxFailed";
        this.trigger(OO.VastAdLoader.ERROR, this);
      },

      _extractStreamForType: function(streams, type) {
        // TODO, also cap on bitrate and width/height if there is any device restriction.
        var filter = [];
        switch (type) {
          case "webm":
            filter.push("video/webm");
             break;
          case "mp4":
            filter.push("video/mp4");
            if (OO.isIos) { filter.push("video/quicktime"); }
            break;
        }
        var stream = _.find(streams, function(v) { return (filter.indexOf(v.type) >= 0); }, this);
        return stream ? stream.url : null;
      },

      _handleLinearAd: function() {
        // filter our playable stream:
        var firstLinearAd = _.find(this.inlineAd.ads, function(v){ return !_.isEmpty(v.linear.mediaFiles); }, this);
        if (!firstLinearAd) { return false; }
        var streams = firstLinearAd.linear.mediaFiles;
        var maxMedia = _.max(streams, function(v) { return parseInt(v.bitrate, 10); });
        this.vastAdUnit.maxBitrateStream = maxMedia && maxMedia.url;
        this.vastAdUnit.durationInMilliseconds = OO.timeStringToSeconds(firstLinearAd.linear.Duration) * 1000;
        if (OO.supportedVideoTypes.webm) {
          this.vastAdUnit.streamUrl = this._extractStreamForType(streams, "webm");
        }

        if (this.vastAdUnit.streamUrl == null && OO.supportedVideoTypes.mp4) {
          this.vastAdUnit.streamUrl = this._extractStreamForType(streams, "mp4");
        }
        // TODO, check if any ads network will return m3u8.
        if (this.vastAdUnit.streamUrl == null && OO.supportedVideoTypes.m3u8) {
          OO.log("extrac m3u8 stream here");
        }
        // TODO, need to merge field here for any array object;
        _.extend(this.vastAdUnit.data, firstLinearAd);
        // TODO: Come up with a smarter method for being linear/non-linear agnostic re: tracking
        this.vastAdUnit.data.tracking = firstLinearAd.linear.tracking;

        if (this.vastAdUnit.streamUrl == null) {
          // No Playable stream, report error.
          OO.log("Can not find playable stream in vast result", this.inlineAd);
          return false;
        }
        return true;

      },

      _mergeVastAdResult: function() {
        this.vastAdUnit = { data: {}, vastUrl: this.vastUrl, maxBitrateStream: null };
        // TODO: merge all wrapper ads here. this.wrapperAds
        _.each(this.inlineAd.ads, function(ad) {
          ad.error = this.wrapperAds.error.concat(ad.error);
          ad.impression = this.wrapperAds.impression.concat(ad.impression);
          ad.companion = this.wrapperAds.companion.concat(ad.companion);
          if (this.wrapperAds.linear.ClickTracking) {
            ad.linear.ClickTracking = this.wrapperAds.linear.ClickTracking.concat(ad.linear.ClickTracking || []);
          }
          if (this.wrapperAds.linear.tracking) {
            if (!ad.linear.tracking) { ad.linear.tracking  = {}; }
            _.each(this.wrapperAds.linear.tracking, function(value, key) {
              ad.linear.tracking[key] = ad.linear.tracking[key] ? value.concat(ad.linear.tracking[key]) : value;
            });
          }
          if (this.wrapperAds.nonLinear.tracking) {
            if (!ad.nonLinear.tracking) { ad.nonLinear.tracking = {}; }
            _.each(this.wrapperAds.nonLinear.tracking, function(value, key) {
              ad.nonLinear.tracking[key] = ad.nonLinear.tracking[key] ? value.concat(ad.nonLinear.tracking[key]) : value;
            });
          }
        }, this);
      },


      _onVastProxyResult: function(value) {
        var xml = $.parseXML(value);
        this._onVastResponse(xml);
      },

      _onVastResponse: function(xml) {
        var vastAd = OO.VastParser(xml);
        if (!vastAd) {
          this.errorType = "parseError";
          this.trigger(OO.VastAdLoader.ERROR, this);
        }
        else if (vastAd.type == "wrapper") {
          this.currentDepth++;
          if (this.currentDepth < OO.playerParams.maxVastWrapperDepth) {
            var firstWrapperAd = vastAd.ads[0];
            var _wrapperAds = this.wrapperAds;
            OO.log("vast tag url is", firstWrapperAd.VASTAdTagURI, this.currentDepth);

            if (firstWrapperAd) {
              this.wrapperAds.error = this.wrapperAds.error.concat(firstWrapperAd.error);
              this.wrapperAds.impression = this.wrapperAds.impression.concat(firstWrapperAd.impression);
              this.wrapperAds.companion = this.wrapperAds.companion.concat(firstWrapperAd.companion);
              this.wrapperAds.linear.ClickTracking = this.wrapperAds.linear.ClickTracking
                  .concat(firstWrapperAd.linear.ClickTracking);
              _.each(firstWrapperAd.linear.tracking, function(value, key) {
                _wrapperAds.linear.tracking[key] = _wrapperAds.linear.tracking[key] ?
                                                   value.concat(_wrapperAds.linear.tracking[key]) :
                                                   value;
              });
              _.each(firstWrapperAd.nonLinear.tracking, function(value, key) {
                _wrapperAds.nonLinear.tracking[key] = _wrapperAds.nonLinear.tracking[key] ?
                                                      value.concat(_wrapperAds.nonLinear.tracking[key]) :
                                                      value;
              });
              this._ajax(firstWrapperAd.VASTAdTagURI, this._onFinalError, 'xml');
            }
            else {
              this.errorType = "wrapperParseError";
              this.trigger(OO.VastAdLoader.ERROR, this);
            }
          } else {
            OO.log("Max wrapper depth reached.", this.currentDepth, OO.playerParams.maxVastWrapperDepth);
            this.errorType = "tooManyWrapper";
            this.trigger(OO.VastAdLoader.ERROR, this);
          }
        } else if (vastAd.type == "inline") {
          this.inlineAd = vastAd;
          this._mergeVastAdResult();

          // TODO: add logic for non-linear ads here:
          if (this._handleLinearAd()) {
            this.loaded = true;
            this.trigger(OO.VastAdLoader.READY, this);
          } else {
            this.errorType = "noLinearAd";
            this.trigger(OO.VastAdLoader.ERROR, this);
          }
        }
      },

      __placeholder: true
    });

  }(OO, OO._, OO.$));
  (function(OO, _, $){
    /*
     *  AdsManager will manage the Ads config load and notify playback controller when they are ready.
     *  It will intercept willFetchAds event, and send adFetched event to notify playbck to continue.
     *  PlaybackController will timeout if willFetchAds does not return in OO.playerParams.maxAdsTimeout
     *  seconds.
     */

    var VastPings = function(messageBus, id) {
      if (!OO.requiredInEnvironment('ads') ||
          OO.requiredInEnvironment('cast-playback')) {
        return;
      }
      this.Id = id;
      this.mb = messageBus;

      this.currentVastAd = null;
      this.pingedKey = {};
      this.pauseClicked = false;
      this.isMuted = false;
      // TODO, handle error: when valid vast comes back, but no stream can be played:
      OO.StateMachine.create({
        initial:'Init',
        messageBus:this.mb,
        moduleName:'vastPings',
        target:this,
        events:[
          {name:OO.EVENTS.PLAY_STREAM,                  from:'*'},
          {name:OO.EVENTS.PLAY_MIDROLL_STREAM,          from:'*'},
          {name:OO.EVENTS.STREAM_PLAYED,                from:'*'},
          {name:OO.EVENTS.MIDROLL_STREAM_PLAYED,        from:'*'},

          {name:OO.EVENTS.FULLSCREEN_CHANGED,           from:'*'},
          {name:OO.EVENTS.VOLUME_CHANGED,               from:'*'},

          {name:OO.EVENTS.PAUSED,                       from:'*'},
          {name:OO.EVENTS.PLAYHEAD_TIME_CHANGED,        from:'*'},
          {name:OO.EVENTS.ADS_CLICKED,                  from:'*'}
        ]
      });

    };

    _.extend(VastPings.prototype, {
      onFullscreenChanged: function(event, isFullScreen) {
        if (this.currentVastAd == null) { return; }
        this._vastTrackings(isFullScreen ? 'fullscreen' : 'collapse');
      },

      onVolumeChanged: function(event, volume) {
        if (this.currentVastAd == null) { return; }
        var isMuted = (volume == 0);
        this._vastTrackings( (isMuted && !this.isMuted) ? 'mute' : 'unmute');
        this.isMuted = isMuted;
      },

      onAdsClicked: function() {
        if (this.currentVastAd) {
          var clickTracking = this.currentVastAd.data && this.currentVastAd.data.linear &&
             this.currentVastAd.data.linear.ClickTracking;
          OO.log("Click Tracking:", clickTracking);
          if (clickTracking) { OO.pixelPings(clickTracking); }
        }
      },

      onPaused: function() {
        this.pauseClicked = true;
        if (this.currentVastAd) {
          this._vastTrackings('pause');
        }
      },

      onPlayStream: function(event, url, item) {
        if (this.pauseClicked) {
          this._itemResumePlay(item);
        } else {
          this._itemStartPlay(item);
        }
      },

      onPlayMidrollStream: function(event, url, item) {
        if (this.pauseClicked) {
          this._itemResumePlay(item);
        } else {
          this._itemStartPlay(item);
        }
      },

      onStreamPlayed: function(event) {
        this._itemPlayed();
      },

      onMidrollStreamPlayed: function(event, mainVideoPlayhead) {
        this._itemPlayed();
      },

      onPlayheadTimeChanged: function(event, time, duration) {
        if (this.currentVastAd == null || duration == 0) { return; }
        // send percentile pings.
        if (time > duration * 0.75) {
          this._vastTrackings('thirdQuartile');
        } else if (time > duration * 0.50) {
          this._vastTrackings('midpoint');
        } else if (time > duration * 0.25) {
          this._vastTrackings('firstQuartile');
        }
      },

      _itemStartPlay: function(item) {
        if (item.type != "ad" || !item.item) { return; }
        this.currentVastAd = item.item;
        // ping urls, this will make sure Ooyala tracking_url is also pinged.
        OO.pixelPings(this.currentVastAd.tracking_url);

        if (item.item.type != "vast") { return; }
        if (this.currentVastAd.data) {
          this.pingedKey = {};
          OO.pixelPings(this.currentVastAd.data.impression);
          this._vastTrackings('start');
          this._vastTrackings('creativeView');
        }
        this.pauseClicked = false;
      },

      _itemResumePlay: function(item) {
        if (this.currentVastAd) {
          this._vastTrackings('resume');
        }
        this.pauseClicked = false;
      },

      _itemPlayed: function() {
        if (this.currentVastAd && this.currentVastAd.data && this.currentVastAd.data.tracking) {
          OO.pixelPings(this.currentVastAd.data.tracking.complete);
        }
        this._vastTrackings('complete');
        this.currentVastAd = null;
      },

      _vastTrackings: function(key) {
        // make sure we only send each ping once for each vast ads.
        if (this.pingedKey[key] == 1) { return; }
        this.pingedKey[key] = 1;
        if (this.currentVastAd && this.currentVastAd.data && this.currentVastAd.data.tracking) {
          OO.pixelPings(this.currentVastAd.data.tracking[key]);
        }
      },

      __placeholder: true
    });

    OO.registerModule('vastPings', function(messageBus, id) {
      return new VastPings(messageBus, id);
    });

  }(OO, OO._, OO.$));
  (function(OO, $, _) {
    OO.AnalyticsBase = function(messageBus, id) { };

    _.extend(OO.AnalyticsBase.prototype, {
      loadSucceed: function() {}, // Override this function to do additional setup.

      reportEvent: function() {
        throw "Please override this function";
      },

      // Private funciton:

      setup: function(messageBus, id, analyticsType) {
        this.mb = messageBus;
        this.elementId = id;

        this._loaded = false;
        this._bufferedEvents = [];
        this.mb.subscribe('*', analyticsType, _.bind(this._onAnalyticsEvent,this));
      },

      loadExternalAnalyticsJs: function(url) {
        $.getScriptRetry(url, _.bind(this._onLoaded, this), {
          error: function() {
            // TODO: report error to some log server.
            OO.log("can not load url", url);
          }
        });
      },

      _onLoaded: function() {
        this._loaded = true;
        this.loadSucceed();
        if (!this._bufferedEvents) { return; }
        _.each(this._bufferedEvents, function(e){
          this._safeReportEvent.apply(this, e);
        }, this);
      },

      _onAnalyticsEvent: function() {
        // TODO: white labeling here.
        if (this._loaded) {
          this._safeReportEvent.apply(this, arguments);
        } else {
          this._bufferedEvents.push(arguments);
        }
      },

      _safeReportEvent: function() {
        try {
          this.reportEvent.apply(this, arguments);
        } catch (e) {
            OO.log("can not log event");
        }
      },

      __place_holder: true
    });

  }(OO, OO.$, OO._));  (function(OO, $, _) {
    var OOYALA_ANALYTICS = "ooyala_analytics";

    var OoyalaAnalytics = OO.inherit(OO.AnalyticsBase, function(messageBus, id) {
      if (!OO.requiredInEnvironment('html5-playback') && !OO.requiredInEnvironment('cast-playback')) { return; }

      this.setup(messageBus, id, OOYALA_ANALYTICS);

      this.lastEmbedCode = '';
      this.currentEmbedcode = '';
      this.playingInstreamAd = false;
      this.guid = undefined;
      this.accountId = undefined;
      this.accountIdSet = false;
      this.guidSet = false;
      this.parameters = undefined;
      this.documentUrl = undefined;

      // Note: we load the external JS analytics after the SAS response comes back, so we can propagate the
      // accountId parameter into Reporter if there is one. However, we also need to listen for error events,
      // in case the SAS Authorization fails. If that happens, we also load external JS analytics and
      // instantiate Reporter without an accountId. In either case, we unsubscribe from future authorization
      // fetched or error events.
      // TODO(playback-team): are you guys sure there's no race with SAS authorization request here?
      messageBus.subscribe(OO.EVENTS.AUTHORIZATION_FETCHED, OOYALA_ANALYTICS,
        _.bind(this._onAuthorizationFetched, this));
      messageBus.subscribe(OO.EVENTS.ERROR, OOYALA_ANALYTICS, _.bind(this._onErrorEvent, this));
      messageBus.subscribe(OO.EVENTS.GUID_SET, OOYALA_ANALYTICS, _.bind(this._onGuidSet, this));
      messageBus.subscribe(OO.EVENTS.REPORT_DISCOVERY_IMPRESSION, OOYALA_ANALYTICS,
        _.bind(this._onReportDiscoveryImpression, this));
      messageBus.subscribe(OO.EVENTS.REPORT_DISCOVERY_CLICK, OOYALA_ANALYTICS,
        _.bind(this._onReportDiscoveryClick, this));
      messageBus.subscribe(OO.EVENTS.PLAYER_CREATED, OOYALA_ANALYTICS,
        _.bind(this._onPlayerCreated, this));
    });

    _.extend(OoyalaAnalytics.prototype, {
      _onGuidSet: function(event, guid) {
        this.guid = guid;
        this.guidSet = true;
        this._onGuidAndAccountIdSet();
      },

      _onPlayerCreated: function(event, elementId, params) {
        this.parameters = params;
        if (this.parameters && this.parameters.docUrl) {
          this.documentUrl = this.parameters.docUrl;
        } else if (this.parameters && this.parameters["flashParams"] && this.parameters["flashParams"]["docUrl"]) {
          this.documentUrl = this.parameters["flashParams"]["docUrl"];
        }
      },

      _onAuthorizationFetched: function(event, tree) {
        if (tree.user_info && tree.user_info.account_id) {
          this.accountId = tree.user_info.account_id;
        } else if (tree.debug_data && tree.debug_data.user_info && tree.debug_data.user_info.account_id) {
          this.accountId = tree.debug_data.user_info.account_id;
        }
        this.mb.unsubscribe(OO.EVENTS.ERROR, OOYALA_ANALYTICS);
        this.mb.unsubscribe(OO.EVENTS.AUTHORIZATION_FETCHED, OOYALA_ANALYTICS);
        if (_.isNumber(this.accountId)) {
          // Convert numeric id to a string, since reporter.js does a strict type check for strings
          this.accountId = this.accountId.toString();
        }
        if (!_.isString(this.accountId)) {
          this.accountId = undefined;
          OO.d("OO.OoyalaAnalytics: SAS authorization fetched without an accountId");
        } else {
          OO.d("OO.OoyalaAnalytics: SAS authorization fetched with accountId == " + this.accountId);
        }
        this.accountIdSet = true;
        this._onGuidAndAccountIdSet();
      },

      _onGuidAndAccountIdSet: function() {
        if (!this.guidSet || !this.accountIdSet) { return; }
        OO.d("Loading Analtics Module...");
        this.loadExternalAnalyticsJs(OO.URLS.ANALYTICS({ server: OO.SERVER.ANALYTICS }));
      },

      _onErrorEvent: function(event, params) {
        if (!params || !params["code"]) { return; }
        var code = params["code"];
        var isAuthError = false;
        // Check if it's a SAS API error. If yes, call _onAuthorizationError, otherwise ignore.
        _.each(OO.ERROR.API.SAS, function(value, key) {
          if (value === code) { isAuthError = true; }
        });
        if (isAuthError) { this._onAuthorizationError(event, code); }
      },

      _onAuthorizationError: function(event, errorCode) {
        this.mb.unsubscribe(OO.EVENTS.ERROR, OOYALA_ANALYTICS);
        this.mb.unsubscribe(OO.EVENTS.AUTHORIZATION_FETCHED, OOYALA_ANALYTICS);
        OO.d("OO.OoyalaAnalytics: SAS authorization failed, loading external analytics module ...");
        this.loadExternalAnalyticsJs(OO.URLS.ANALYTICS({ server: OO.SERVER.ANALYTICS }));
      },

      _onReportDiscoveryImpression: function(event, params) {
        if (!this.reporter) { return; }
        try {
          this.reporter.reportDiscoveryImpression(params.relatedVideos, params.custom);
        } catch (e) {
          OO.log("Failed to report a discovery impression event with params " + JSON.stringify(params) +
            ": " + e);
        }
      },

      _onReportDiscoveryClick: function(event, params) {
        if (!this.reporter) { return; }
        try {
          this.reporter.reportDiscoveryClick(params.clickedVideo, params.custom);
        } catch (e) {
          OO.log("Failed to report a discovery click event with params " + JSON.stringify(params) +
            ": " + e);
        }
      },

      loadSucceed: function() {
        //todo this should not be possible
        if (!window.Ooyala || !window.Ooyala.Reporter) { return; }
        OoyalaAnalytics.Reporter = Ooyala.Reporter;
        OoyalaAnalytics.Pinger = Ooyala.Pinger;
        //this.guid = OoyalaAnalytics.Pinger.getOrCreateGuid();
        //this.mb.publish(OO.EVENTS.GUID_SET, this.guid);
        this.reporter = null;
        // TODO: if pcode is not set, we may have an error.
        if (!OO.playerParams.pcode) { return; }
        var analyticsParams = {
          accountId: this.accountId,
          guid: this.guid,
          playerBrandingId: OO.playerParams.playerBrandingId,
        };
        if (this.documentUrl) {
          analyticsParams = _.extend(analyticsParams, {documentUrl: this.documentUrl});
        }
        this.reporter = new OoyalaAnalytics.Reporter(OO.playerParams.pcode, analyticsParams);
      },

      reportEvent: function(eventName, arg1, arg2) {
        if (!this.reporter) { return; } // TODO report error here. should never happend
        switch (eventName) {
          case OO.EVENTS.PLAYER_CREATED :
            this.reporter.reportPlayerLoad();
            break;
          case OO.EVENTS.EMBED_CODE_CHANGED :
            // TODO: get the right duration for the video.
            // When setEmbedCode is called on the same asset it is NOT treated as a replay
            if (arg1 != this.currentEmbedcode) {
              this.lastEmbedCode = this.currentEmbedcode;
            } else {
              this.lastEmbedCode = '';
            }
            this.currentEmbedcode = arg1;
            break;
          case OO.EVENTS.CONTENT_TREE_FETCHED :
            // TODO: get the right duration for the video.
            this.reporter.initializeVideo(this.currentEmbedcode, arg1.duration);
            break;
          case OO.EVENTS.WILL_PLAY_FROM_BEGINNING:
            if (this.lastEmbedCode === this.currentEmbedcode) {
              this.reporter.reportReplay();
            } else {
              this.reporter.reportVideoStarted();
              this.lastEmbedCode = this.currentEmbedcode;
            }
            break;
          // TODO: reportAdRequest, reportAdClickToSite, reportAdPlayFailure
          // TODO: Add ad metadata
          case OO.EVENTS.WILL_PLAY_ADS :
            this.playingInstreamAd = true;
            var adSource = Ooyala.Reporter.AdSource.UNKNOWN;
            if (arg1 && arg1.type && typeof(arg1.type) == "string") {
              adSource = Ooyala.Reporter.AdSource[arg1.type.toUpperCase()];
            }
            this.reporter.setAdSource(adSource, this.currentEmbedcode, arg1 && arg1.click_url);
            this.reporter.reportAdImpression();
            break;
          case OO.EVENTS.ADS_PLAYED :
            this.playingInstreamAd = false;
            // TODO, report ads end.
            break;
          case OO.EVENTS.ADS_CLICKED :
            this.reporter.reportAdClickToVideo();
            break;
          case OO.EVENTS.PLAYHEAD_TIME_CHANGED:
            if (this.playingInstreamAd) {
              this.reporter.reportAdPlaythrough(arg1, arg2);
            } else {
              if (arg1 > 0) {
                this.reporter.reportPlayheadUpdate(Math.floor(arg1 * 1000));
              }
            }
            break;
          case OO.EVENTS.REPORT_EXPERIMENT_VARIATIONS:
            this.reporter.reportExperimentVariation(arg1.variationIds);
            break;
          case OO.EVENTS.INITIAL_PLAY:
            this.reporter.reportPlayRequested();
            break;
        }

      },

      __place_holder: true
    });

    OO.registerModule(OOYALA_ANALYTICS, function(messageBus, id) {
      return new OoyalaAnalytics(messageBus, id);
    });

  }(OO, OO.$, OO._));
/*
 * Librato Plugin
 *
 * owner: PBS
 * version: 0.1
 *
 * The Librato plugin utilizes the librato.com API to handle instrumentation
 * of various events within the player. Note: The allowed use of this plugin is only
 * under the condition that this plugin does not send/store any user information along with
 * each request.
 */
OO.plugin("Librato", function(OO, _, $, W) {
  // Throttling for now...logic by @gregm ;)
  var THROTTLE = Math.floor(Math.random() * 10);
  // Return an empty function or die
  if (THROTTLE > 0) { return (function(){}); }

  var RANGE_ABOVE_THRESHOLD_TEXT = "-above-range";
  var RANGE_BELOW_THRESHOLD_TEXT = "-below-range";
  var RANGE_WITHIN_THRESHOLD_TEXT = "-within-range";

  /**
   * The threshold configuration for each timed event
   * @private
   */
  var LibratoConfig = {
    "events": [
      {
        "name": "v3-load-time",
        "low": 500,
        "high": 2000
      },
      {
        "name": "v3-playback-ready",
        "low": 1000,
        "high": 3000
      },
      {
        "name": "v3-time-to-first-content-frame",
        "low": 1000,
        "high": 5000
      },
      {
        "name": "v3-time-to-first-ad-frame",
        "low": 1000,
        "high": 5000
      }
    ]
  };

  /**
   * @class LibratoHelper
   * @classdesc Helper class for Librato plugin; contains various helper methods like "reportSingleMetric", etc.
   * @public
   */
  var LibratoHelper = function() {
    // calculate authorization header
    this.basic_auth_token = "abelrios@ooyala.com" + ":" + "95d53e8841835839469f2a2f96fd95b564342ffadff759ad9d49f1897805db1b";
    if (window.btoa) {
      this.basic_auth_token = btoa(this.basic_auth_token);
    } else {
      this.basic_auth_token = window.base64.encode(this.basic_auth_token);
    }
    // figure out the source string
    this.source = this._generateSourceString();
  };

  _.extend(LibratoHelper.prototype, {

    /**
     * Measures the millisecond difference from 2 millisecond values
     * @method _measureDurationMilli
     * @param {number} startTs Starting millisecond value
     * @param {number} endTs Ending millisecond value
     * @return {number} The difference of endTs and startTs milliseconds
     */
    _measureDurationMilli: function(startTs, endTs) {
      return endTs - startTs;
    },

    /**
     * Creates a metric value object that is properly formatted for Librato
     * @method _addMetricValue
     * @param {object}  metrics The metrics value object
     * @param {string} name The metric name to track
     * @param {number} value The metric value (some sort of measurement)
     * @return {object} The modified metrics object
     */
    _addMetricValue: function(metrics, name, value) {
      metrics[name] = { "value" : value, "source" : this.source };
      return metrics;
    },

    /**
     * Creates and sends a single metric value to Librato API
     * @method _reportSingleMetric
     * @param {string} name The metric name
     * @param {number} value The metric value (some sorf of measurement)
     */
    _reportSingleMetric: function(name, value) {
      var metrics = {};
      this._addMetricValue(metrics, name, value);
      this._sendReport(metrics);
    },

    /**
     * AJAX request to send metric call to Librato API
     * @method _sendReport
     * @param {metrics} The metrics object
     */
    _sendReport: function(metrics) {
      // send the ping
      $.ajax({
        url: "https://metrics-api.librato.com/v1/metrics",
        type: "post",
        data: { gauges: metrics },
        dataType: "json",
        headers: { "Authorization": "Basic " + this.basic_auth_token },
        success: function (data) {
        }
      });
    },

    /**
     * Evaluates where a counting measurement falls within a defined threshold
     * @method _getThresholdText
     * @param {number} value The metric value
     * @param {object} item The configuration item that contains the threshold data
     * @return {string} The the threshold value result
     */
    _getThresholdText: function(value, item) {
      var text = RANGE_WITHIN_THRESHOLD_TEXT;
      if (value > item.high) {
        text = RANGE_ABOVE_THRESHOLD_TEXT;
      } else if (value < item.low) {
        text = RANGE_BELOW_THRESHOLD_TEXT;
      }

      return item.name + text;
    },

    /**
     * Matches a given event name with a name in configuration
     * @method _matchEvent
     * @param {string} name The event name to use as a key
     * @return {object} The matched configuration object
     */
    _matchEvent: function(name) {
      var match;
      _.each(LibratoConfig.events, function(item, idx) {
          if(item.name === name) {
            match = item;
          }
      });
      return match;
    },

    /**
     * Generates the source string to use in each metric call
     * @method _generateSourceString
     * @return {string} The properly formatted source string
     */
    _generateSourceString: function() {
      var source_data = {};
      var source_template = _.template("<%= platform %>-<%= os %>-<%= browser %>");

      // platform
      if (OO.featureEnabled("flash-playback")) {
        source_data.platform = "flash";
      } else {
        source_data.platform = "html5";
      }

      // OS
      if (OO.isIos) {
        source_data.os = "ios";
      } else if (OO.isAndroid) {
        source_data.os = "android";
      } else if (OO.isMacOs) {
        source_data.os = "macosx";
      } else if (OO.isWinPhone) {
        source_data.os = "winphone";
      } else if (OO.isWindows) {
        source_data.os = "windows";
      } else {
        source_data.os = "generic";
      }

      // browser
      if (OO.isChrome) {
        source_data.browser = "chrome";
      } else if (OO.isFirefox) {
        source_data.browser = "firefox";
      } else if (OO.isIE11Plus) {
        source_data.browser = "ie11plus";
      } else if (OO.isIE) {
        source_data.browser = "ieold";
      } else if (OO.isSafari) {
        source_data.browser = "safari";
      } else {
        source_data.browser = "generic";
      }
      return source_template(source_data);
    },

    /**
     * Plugin Initializer
     * @method start
     */
    start: function() {
      var metrics = {};
      this._addMetricValue(metrics, "v3-load", 1);

      // measure v3 load performance data
      if (!!window.performance && !!window.performance.getEntries) {
        // v3 is loaded using player_branding_id so let's search for that
        var regex = ".*\\.ooyala\\.com.*v3/" + OO.playerParams.playerBrandingId;
        var v3_performance = _.find(window.performance.getEntriesByType("resource"), function(e) { return e.name.match(regex) || e.name.match("mjolnir"); } );

        // timing data found
        if (!!v3_performance) {
          if (v3_performance.duration > 0) {
            // We have the load time, so let's log that
            this._addMetricValue(metrics, this._getThresholdText(v3_performance.duration, this._matchEvent("v3-load-time")), 1);
          }
        }
      }

      this._sendReport(metrics);
    }

  });

  // We must defer measuring player load times until after this script is processed
  // Since when this code is executed initially, it's part of the loading sequence
  var libratoHelper = new LibratoHelper();
  _.defer(_.bind(libratoHelper.start, libratoHelper));


  // ------------------------------- Instance Functions ----------------------

  var Librato = function(messageBus, id) {
    this.id = id;
    this.mb = messageBus;
    this.initializationTs = this._takeTimestamp();

    // track important events
    this.mb.subscribe(OO.EVENTS.SET_EMBED_CODE, 'librato', _.bind(this._onSetEmbedCode, this));
    this.mb.subscribe(OO.EVENTS.PLAYBACK_READY, 'librato', _.bind(this._onPlaybackReady, this));
    this.mb.subscribe(OO.EVENTS.INITIAL_PLAY, 'librato', _.bind(this._onInitialPlay, this));
    this.mb.subscribe(OO.EVENTS.PLAY, 'librato', _.bind(this._onInitialPlay, this));
    this.mb.subscribe(OO.EVENTS.PLAYING, 'librato', _.bind(this._onInitialPlay, this));
    this.mb.subscribe(OO.EVENTS.ADS_PLAYED, 'librato', _.bind(this._onAdsPlayed, this));
    this.mb.subscribe(OO.EVENTS.PLAYHEAD_TIME_CHANGED, 'librato', _.bind(this._onPlayheadTimeChanged, this));
    this.mb.subscribe(OO.EVENTS.PLAY_FAILED, 'librato', _.bind(this._onPlayerPlayFailure, this));
    this.mb.subscribe(OO.EVENTS.ERROR, 'librato', _.bind(this._onPlayerError, this));
    this.mb.subscribe(OO.EVENTS.WILL_PLAY_ADS, 'librato', _.bind(this._willPlayAds, this));
  };

  _.extend(Librato.prototype, {
    /**
     * Creates a timestamp
     * @method _takeTimestamp
     * @return {object} A date object
     */
    _takeTimestamp: function() {
      return new Date().getTime();
    },

    /**
     * Set Embed Code Event Handler
     * @method _onSetEmbedCode
     */
    _onSetEmbedCode: function() {
      this.setEmbedCodeTs = this._takeTimestamp();
      this.wasPlayStartReported = false;
      this.wasTimeToFirstFrameReported = false;
      this.wasTimeToFirstAdFrameReported = false;
      this.adsPlaying = false;
    },

    /**
     * Playback Ready Event Handler
     * @method _onPlaybackReady
     */
    _onPlaybackReady: function() {
      libratoHelper._reportSingleMetric("v3-playback-ready", 1);
      this.playbackReadyTs = this._takeTimestamp();
      var diff = libratoHelper._measureDurationMilli(this.setEmbedCodeTs, this.playbackReadyTs);
      libratoHelper._reportSingleMetric(libratoHelper._getThresholdText(diff, libratoHelper._matchEvent("v3-playback-ready")), 1);
    },

    /**
     * Initial Play Event Handler
     * @method _onInitialPlay
     */
    _onInitialPlay: function() {
      if (this.wasPlayStartReported) { return; }

      this.lastStateChangeTs = this._takeTimestamp();
      this.wasPlayStartReported = true;
      libratoHelper._reportSingleMetric("v3-play", 1);
    },

    /**
     * Will Play Ads Event Handler
     * @method _willPlayAds
     */
    _willPlayAds: function() {
      this.lastStateChangeTs = this._takeTimestamp(); // reset the state timestamp
      this.adsPlaying = true;
      libratoHelper._reportSingleMetric("v3-play-ad", 1);
    },

    /**
     * Ads Played Event Handler
     * @method _onAdsPlayed
     */
    _onAdsPlayed: function() {
      this.lastStateChangeTs = this._takeTimestamp(); // reset the state timestamp
      this.adsPlaying = false;
    },

    /**
     * Playhead Time Changed Event Handler
     * @method _onPlayheadTimeChanged
     */
    _onPlayheadTimeChanged: function(name, playhead) {
      if (this.wasTimeToFirstFrameReported && this.wasTimeToFirstAdFrameReported) { return; }
      if (!playhead || playhead <= 0) { return; }

      // first frame appeared playhead seconds ago...
      this.firstFrameTs = this._takeTimestamp(); // TODO do we need to account for already played frames?
      var diff = libratoHelper._measureDurationMilli(this.lastStateChangeTs, this.firstFrameTs);

      if (!this.wasTimeToFirstFrameReported && !this.adsPlaying) {
        libratoHelper._reportSingleMetric(libratoHelper._getThresholdText(diff, libratoHelper._matchEvent("v3-time-to-first-content-frame")), 1);
        this.wasTimeToFirstFrameReported = true;
      }

      if (this.adsPlaying && !this.wasTimeToFirstAdFrameReported) {
        libratoHelper._reportSingleMetric(libratoHelper._getThresholdText(diff, libratoHelper._matchEvent("v3-time-to-first-ad-frame")), 1);
        this.wasTimeToFirstAdFrameReported = true;
      }
    },

    /**
     * Player Play Failure Event Handler
     * @method _onPlayerPlayFailure
     */
    _onPlayerPlayFailure: function() {
      libratoHelper._reportSingleMetric("v3-play-fail", 1);
    },

    /**
     * Player Error Event Handler
     * @method _onPlayerError
     */
    _onPlayerError: function(type, error) {
      this.errorTs = this._takeTimestamp();
      // We essentially want to handle errors on a case by case basis to determine
      // which errors have more weight
      libratoHelper._reportSingleMetric("v3-error", 1);
    }

  });

  return Librato;
});
  (function(OO, $, _){
    /*
     *  Defines a simple UI
     */

    var BasicUi = function(messageBus, id, params) {
      // short circuit here if the page does not need default ui
      if (!OO.requiredInEnvironment('default-ui')) { return; }
      if (!!params['layout'] && params['layout']==='chromeless') { return; }
      if (OO.isChromecast) { return; }

      this.useCustomControls = !OO.uiParadigm.match(/mobile/);
      this.useNativeControls = !!OO.uiParadigm.match(/native/);

      this.Id = id;
      this.mb = messageBus;
      this.isFullscreen = false;
      this.bufferTime = 0;
      this.isSeeking = false;
      this.controlsVisible = false;
      this.buffering = false;
      this.isLivePlaying = false;
      this.seekRange = null;
      this.isVideoAdPlaying = false;
      this.liveSeekWindow = 0;
      this.playbackReady = false;
      this.showAdMarquee = true;

      //Internal Constants
      this.CONTROLS_TIMEOUT = 2000;
      this.SHOW_CONTROLS_DELAY = 100;

      //set flag if has been overriden already.
      this.mb.subscribe(OO.EVENTS.SHOW_AD_MARQUEE, "basic_ui", _.bind(function(event, marquee) {
        this.showAdMarquee = marquee;
      }, this));

      OO.StateMachine.create({
        initial:'Init',
        messageBus:this.mb,
        moduleName:'BasicUi',
        target:this,
        events:[
          {name:OO.EVENTS.PLAYER_CREATED,                           from:'Init',                                       to:'PlayerCreated'},
          {name:OO.EVENTS.EMBED_CODE_CHANGED,                       from:'*',                                          to:'WaitingPlaybackReady'},
          {name:OO.EVENTS.METADATA_FETCHED,                         from:'*',                                          to:'*'},
          {name:OO.EVENTS.AUTHORIZATION_FETCHED,                    from:'*'},
          {name:OO.EVENTS.PLAYBACK_READY,                           from:'WaitingPlaybackReady',                       to:'Ready'},
          {name:OO.EVENTS.WILL_PLAY,                                from:['Ready','Paused'],                           to:'StartingToPlay'},
          {name:OO.EVENTS.PLAYING,                                  from:['StartingToPlay', 'Paused'],                 to:'Playing'},
          {name:OO.EVENTS.STREAM_PLAYING,                           from:'*'},
          {name:OO.EVENTS.PLAYHEAD_TIME_CHANGED,                    from:['Playing', 'StartingToPlay'],                to:'Playing'},
          {name:OO.EVENTS.PLAYHEAD_TIME_CHANGED,                    from:'Paused',                                     to:'Paused'},
          {name:OO.EVENTS.PLAYHEAD_TIME_CHANGED,                    from:'PlayingMidroll',                             to:'PlayingMidroll'},
          {name:OO.EVENTS.PLAYHEAD_TIME_CHANGED,                    from:'Ready',                                      to:'Ready'},
          {name:OO.EVENTS.WILL_PAUSE_ADS,                           from:'*',                                          to:'Paused'},
          {name:OO.EVENTS.PAUSED,                                   from:'*',                                          to:'Paused'},
          {name:OO.EVENTS.PLAYED,                                   from:['Playing', 'Paused'],                        to:'Ready'},
          {name:OO.EVENTS.STREAM_PAUSED,                            from:'*'},
          {name:OO.EVENTS.BUFFERING,                                from:'*'},
          {name:OO.EVENTS.BUFFERED,                                 from:'*'},
          {name:OO.EVENTS.SEEKED,                                   from:'*'},
          {name:OO.EVENTS.FULLSCREEN_CHANGED,                       from:'*'},
          {name:OO.EVENTS.SIZE_CHANGED,                             from:'*'},
          {name:OO.EVENTS.DOWNLOADING,                              from:'*'},
          {name:OO.EVENTS.CONTENT_TREE_FETCHED,                     from:'*'},
          {name:OO.EVENTS.PLAY_MIDROLL_STREAM,                      from:['Playing', 'Paused'],                         to:"PlayingMidroll"},
          {name:OO.EVENTS.WILL_RESUME_MAIN_VIDEO,                   from:'PlayingMidroll',                              to:"Playing"},

          {name:OO.EVENTS.DISABLE_PLAYBACK_CONTROLS,                          from:"*"},
          {name:OO.EVENTS.ENABLE_PLAYBACK_CONTROLS,                           from:"*"},

          {name:OO.EVENTS.WILL_PLAY_ADS,                            from:"*"},
          {name:OO.EVENTS.INITIAL_PLAY,                             from:"*"},
          {name:OO.EVENTS.ADS_ERROR,                                from:"*"},
          {name:OO.EVENTS.ADS_PLAYED,                               from:"*"},
          {name:OO.EVENTS.UPDATE_AD_COUNTDOWN,                      from:"*"},
          {name:OO.EVENTS.ERROR,                                    from:"*"}

        ]
      });
    };

    _.extend(BasicUi.prototype, {
      onInitialPlay: function() {
        if (!this.playbackReady) { return; }
        this.rootElement.find('div.oo_promo').hide();
        this._prepareControl();
      },

      onWillPlayAds: function(event, params) {
        if (this.showAdMarquee) {
          this.rootElement.find('div.oo_ads_countdown').html((params && params["useCustomCountdown"] ? "" :
            OO.getLocalizedMessage(OO.TEXT.ADS_COUNTDOWN)));
          this.rootElement.find('div.oo_ads_countdown').show();
        }
        this.rootElement.find('div.oo_scrubber').css('pointer-events', 'none');
        this.rootElement.find('div.oo_tap_panel').css('display', 'none');
        this.rootElement.find('div.oo_duration').html(OO.formatSeconds(0));
        this.isVideoAdPlaying = true;
        if (typeof this.params.showInAdControlBar != 'undefined') {
          this._toggleControls(this.params.showInAdControlBar);
        }
        this._updatePlayingUi();
      },

      onUpdateAdCountdown: function(event, message) {
        if (message) {
          this.rootElement.find(".oo_ads_countdown").html(message);
        }
      },

      onAuthorizationFetched:function(event, response) {
        this.authorization = response;
        this.isLivePlaying = (this.isLivePlaying || this.authorization.streams[0].is_live_stream);
      },

      onError: function() {
        if (this.useCustomControls) {
          this.controlsRoot.css('display','none');
          this.mb.publish(OO.EVENTS.WILL_CHANGE_FULLSCREEN, false);
        }
      },

      onAdsError: function() {
        OO.log("Ads Error, hiding ads countdown.");
        this.onAdsPlayed();
      },

      onAdsPlayed: function() {
        this.rootElement.find('div.oo_ads_countdown').hide();
        this.rootElement.find('div.oo_scrubber').css('pointer-events', 'auto');
        this.isVideoAdPlaying = false;
      },

      _showDomObject: function(domSelector, show) {
        var value = show ? OO.CSS.VISIBLE_POSITION : OO.CSS.INVISIBLE_POSITION;
        this.rootElement.find(domSelector).css("left", value);
      },

      onPlayMidrollStream: function(event, streamUrl, adItem) {
        this._showDomObject('video.video', false);
        this._showDomObject('video.midroll', true);

        // Vast midrolls require the tap_panel to be visible for clickthroughs
        if (adItem && adItem.item && adItem.item.type &&
          (adItem.item.type == "vast" || adItem.item.type == "ooyala")) {
          this.rootElement.find('div.oo_tap_panel').css('display', '');
        }

        this._updatePlayingUi();
      },

      onWillResumeMainVideo: function(event) {
        this._showDomObject('video.video', true);
        this._showDomObject('video.midroll', false);
      },

      onPlayerCreated: function(event, elementId, params) {
        this.elementId = elementId;
        this.topMostElement = $('#'+this.elementId);
        this.rootElement =  this.topMostElement.find("div.innerWrapper");
        this.params = params;
        this.accentColor = params.accentColor || 0x5D8ADD;

        // do not display any UI elements unless directly specified in CSS.
        OO.attachStyle(this.elementId + ".oo_ui_element { display: none; }", this.elementId);

        //load default CSS
        OO.attachStyle(_.template(OO.get_css("basic_ui"))({
          elementId : this.elementId,
          liveIcon : OO.get_img_base64('icon_live'),
          rewindIcon : OO.get_img_base64('icon_rewind'),
          playIcon : OO.get_img_base64('icon_play'),
          pauseIcon : OO.get_img_base64('icon_pause'),
          playheadIcon : OO.get_img_base64('icon_playhead'),
          fullscreenOnIcon : OO.get_img_base64('icon_full_off'),
          fullscreenOffIcon : OO.get_img_base64('icon_full_on')
        }), this.elementId);

        if (params.css) {
          // if css is not a string, assume that the customer has already embedded it and don't load ours
          // else, load their css URL
          if (typeof params.css === "string") {
            if (params.css.match(/\.css$/)) { // if it ends with .css try to load it
              // load specified CSS - If we don't use a timeout, this will break layout measurements and
              // result in improper resizing of controls.  We need to ensure this is async from the thread
              setTimeout(function() {
                $('head').append('<link href="' + params.css + '" rel="stylesheet" type="text/css">');
              }, 0);
            } else {
              OO.attachStyle(params.css, this.elementId);
            }
          }
        }

        // ad count down:
        this.rootElement.append('<div class="oo_ads_countdown" style="display:none"></div>');

        // display initial ui
        this.rootElement.append('<div class="oo_promo"></div>');
        this.promoUi = new _PromoUi(this.rootElement.find('div.oo_promo'));

        if(this.useCustomControls) {
          // display controls
          this._createControls();
        } else {
          this.controlsRoot = this.rootElement.find('div.oo_controls');
        }
        this.spinner = new OO.Spinner(this.mb, this.rootElement.find('div.oo_spinner'), this.rootElement);

        if(this.useNativeControls) {
          this.rootElement.find('video.video').attr('controls','true');
        }
        // append endscreen:
        this.rootElement.append('<div class="oo_end_screen" style="display:none"><img class="oo_replay" src="' +
            OO.get_img_base64('icon_replay') + '"><img class="oo_fullscreen" src="' + OO.get_img_base64('icon_full_on') + '"></div>');

        this.rootElement.find('div.oo_end_screen img.oo_replay').bind('click', _.bind(this._replayClicked, this));
        this.rootElement.find('div.oo_end_screen img.oo_fullscreen').bind('click', _.bind(this._fullscreenClick, this));
      },

      _onClickOnPlayer: function(e) {
        if (this.rootElement.find("div.oo_end_screen").is(":visible") ||
            this.rootElement.find("div.oo_promo").is(":visible")) { return; }
        this.mb.publish(OO.EVENTS.PLAYER_CLICKED);
      },

      _createControls: function() {
        this.rootElement.append('<div class="oo_tap_panel" style="display:none"></div>');
        this.rootElement.append('<div class="oo_controls_wrap" style="display: none; position: relative; overflow: hidden; height: 100%; width: 100%;"></div>');
        this.rootElement.bind("mousemove.showcontrols touchstart.showcontrols MSPointerDown.showcontrols", _.bind(this._onMouseMove, this));
        var tapElement = OO.isIos ? "video.video" : "div.oo_tap_panel";
        // We don't fire both click and touchstart events because some touch-supported devices
        // will also fire the click event a few hundred ms later and we will therefore fire the
        // PLAYER_CLICKED event twice
        // We can't call preventDefault on the touchstart event because that breaks scrolling, although if we
        // cared about that we would probably use the touchend event instead...
        this.rootElement.find(tapElement).bind(OO.supportTouch ? "touchstart" : "click",
            _.bind(this._onClickOnPlayer, this));

        this.controlsWrap = this.rootElement.find('div.oo_controls_wrap');
        this.controlsWrap.append('<div class="oo_controls" style="display: none; bottom:-1000px;"></div>');
        this.controlsRoot = this.controlsWrap.find('div.oo_controls');
        this.controlsRoot.append('<div class="oo_controls_inner vod"></div><div class="oo_controls_inner live"></div>');

        this.vodControl = new _VodControlBar(this.controlsRoot.find("div.vod"), this);
        this.liveControl = new _LiveControlBar(this.controlsRoot.find("div.live"), this);

        var buttons = this.controlsRoot.find('div.oo_button');
        buttons.append('<div class="oo_button_highlight" />');
        buttons.bind('touchstart MSPointerDown mousedown', function(event) {
          $(event.target).find('div.oo_button_highlight').show();
        });
        buttons.bind('touchend MSPointerUp mouseup', function(event) {
          $(event.target).find('div.oo_button_highlight').hide();
        });

        this.controlsRoot.find('div.oo_play').bind('click', _.bind(this._playClick, this));
        this.controlsRoot.find('div.oo_pause').bind('click', _.bind(this._pauseClick, this));
        this.controlsRoot.find('div.oo_rewind').bind('click', _.bind(this._rewindClick, this));

        this.controlsRoot.find('div.oo_fullscreen').bind('click', _.bind(this._fullscreenClick, this));
        // [pbw-1155][pbw-1723] android isn't always firing a click event
        // after touchstart-touchend, so use touchend to ensure consistent behavior of the buttons.
        if (OO.isAndroid) {
          this.controlsRoot.find('div.oo_play').bind('touchend', _.bind(this._playClick, this));
          this.controlsRoot.find('div.oo_pause').bind('touchend', _.bind(this._pauseClick, this));
          this.controlsRoot.find('div.oo_rewind').bind('touchend', _.bind(this._rewindClick, this));
          this.controlsRoot.find('div.oo_fullscreen').bind('touchend', _.bind(this._fullscreenClick, this));
        }

        this.controlsRoot.find('div.oo_playhead_progress').css('background-color', OO.getColorString(this.accentColor));
        var bufferColor = 0x5C5C5C;
        this.controlsRoot.find('div.oo_buffer_progress').css('background-color', OO.getColorString(bufferColor));

        _.each([$(this.vodControl.scrubber), $(this.liveControl.scrubber)], _.bind(function(scrubber) {
          scrubber.bind('scrubStart', _.bind(this._scrubStart, this));
          scrubber.bind('scrub', _.bind(this._scrub, this));
          scrubber.bind('scrubEnd', _.bind(this._scrubEnd, this));
        }, this));

        // append spinner
        this.rootElement.append('<div class="oo_spinner" style="display:none"></div>');
        this._resizeControls();
      },

      onEmbedCodeChanged: function(event, embedCode, params) {
        if (this.isVideoAdPlaying) {
          this.onAdsPlayed();
        }

        this.params.promoUrl = null;    // some params must be reset before switching to new embed code
        this.params = _.extend(this.params, params);

        this.rootEmbedCode = embedCode;
        this.currentTime = 0;
        this.duration = 0;
        this.isLivePlaying = false;
        this.seekRange = null;
        this.liveSeekWindow = 0;
        this.controlsEnabled = true;
        this.promoImageUrl = null;

        // restore Promo UI
        this.rootElement.find('div.oo_end_screen').hide();
        this.rootElement.find('div.oo_promo').show();

        this.rootElement.find('video.video').css("left", OO.CSS.INVISIBLE_POSITION);
        this.rootElement.find('div.oo_promo').unbind('click');
        this.rootElement.find('div.oo_tap_panel').css('display','none');
        this.promoUi.disallowPlayback();
        this._toggleControls(false);
        this.playbackReady = false;
      },

      _setPromoImage: function() {
        if(_.isString(this.promoImageUrl)) {   // some providers don't use promo images.
          this.promoUi.setBackground(this.promoImageUrl);
          var endScreen = this.rootElement.find('div.oo_end_screen');
          endScreen.css('background-image', 'url('+this.promoImageUrl+')');
        }
      },

      onContentTreeFetched: function(event, contentTree) {
        this.contentTree = contentTree;

        // reset promo image if it's empty (so metadata can win)
        if(_.isString(this.promoImageUrl) && this.promoImageUrl.length == 0) {
          this.promoImageUrl = undefined;
        }

        // promo can be overriden from player params > metadata > content tree
        this.promoImageUrl = this.params.promoUrl || this.promoImageUrl || this.contentTree.promo_image ||
          this.contentTree.thumbnail_image || "";
        this._setPromoImage();

        if (this.rootEmbedCode === this.contentTree.embed_code) {
          // Note(jdlew): This means that archived live streams will still use Live UI..
          this.isLivePlaying = (this.isLivePlaying || this.contentTree.content_type === "LiveStream");
        }
      },

      onMetadataFetched: function(event, metadata) {
        // reset promo image if it's empty (so metadata can win)
        if(_.isString(this.promoImageUrl) && this.promoImageUrl.length == 0) {
          this.promoImageUrl = undefined;
        }

        this.promoImageUrl = this.promoImageUrl || (metadata && metadata.base && metadata.base.thumbnail) || "";
        this._setPromoImage();
      },

      onPlaybackReady: function(event, playbackPackage) {
        // allow playback
        this.rootElement.find('div.oo_promo').bind('click', _.bind(this._promoClick, this));
        this.promoUi.allowPlayback();
        this.playbackReady = true;
      },

      _prepareControl:function() {
        if(this.useCustomControls) {
          this.controlsWrap.css('display','');
          this.controlsRoot.css('display','');
          if (!OO.isIos) { this.rootElement.find('div.oo_tap_panel').css('display',''); }
          this._toggleControls(false);
        }
      },

      onWillPlay: function(event, streamUrl) {
        this._prepareControl();

        this._showDomObject('video.video', true);
        this._showDomObject('video.midroll', false);

        this.rootElement.find('div.oo_end_screen').hide();
      },

      onPlayed: function(event) {
        if(this.useCustomControls) {
          this.rootElement.find('div.oo_pause').hide();
          this.rootElement.find('div.oo_play').show();
        }
        this._showDomObject('video.video', false);
        this._showDomObject('video.midroll', false);

        var endScreen = this.rootElement.find('div.oo_end_screen');
        var replayButton = this.rootElement.find('div.oo_end_screen img.oo_replay');

        endScreen.show();
        this.mb.publish(OO.EVENTS.END_SCREEN_SHOWN);
      },

      onWillPauseAds: function(e) {
        this.onPaused(e);
      },

      onPaused: function(event) {
        if(this.useCustomControls) {
          this.rootElement.find('div.oo_pause').hide();
          this.rootElement.find('div.oo_play').show();
          this._onMouseMove();
        }
      },

      onStreamPaused: function(event) {
        if(this.useCustomControls) {
          this.rootElement.find('div.oo_pause').hide();
          this.rootElement.find('div.oo_play').show();
        }
      },

      onPlaying: function(event, streamUrl) {
        this._updatePlayingUi();
      },

      onStreamPlaying: function(event, streamUrl) {
        this._updatePlayingUi();
      },

      _updatePlayingUi: function() {
        if (this.useNativeControls) { return; }
        this.rootElement.find('div.oo_end_screen').hide();
        this.rootElement.find('div.oo_promo').hide();
        if(this.useCustomControls) {
          this.rootElement.find('div.oo_play').hide();
          this.controlsRoot.show();
          this.rootElement.find('div.oo_pause').show();
        }
      },

      onBuffering: function(event, streamUrl) {
        if(this.useCustomControls) {
          this.spinner.play();
        }
        this.buffering = true;
      },

      onBuffered: function(event, streamUrl) {
        if (this.useNativeControls) { return; }
        if(this.useCustomControls) {
          this.spinner.pause();
        }
        this.buffering = false;
        this._updateScrubberProgressBar();
      },

      // (PB-1635): IE10 fires an extra 'waiting' event when seeking. We need to hide
      // the spinner after we finish seeking. This function is identical to onBuffered.
      onSeeked: function(event) {
        if (this.useNativeControls) { return; }
        if (this.useCustomControls) {
          this.spinner.pause();
        }
        this.buffering = false;
        this._updateScrubberProgressBar();
      },

      onPlayheadTimeChanged: function(event, currentTime, duration, buffer, seekRange) {
        if (this.useNativeControls) { return; }
        this.bufferTime = buffer;
        this.currentTime = currentTime;
        this.duration = duration;
        this.seekRange = seekRange;

        if(this.useCustomControls && (OO.isIE || !this.buffering) ) {
          this._updateScrubberProgressBar();
        }
      },

      onFullscreenChanged: function(event, isFullscreen, paused) {
        if(isFullscreen) {
          this.controlsRoot.find('div.oo_fullscreen').removeClass("oo_fullscreen_on");
          this.controlsRoot.find('div.oo_fullscreen').addClass("oo_fullscreen_off");
          this.isFullscreen = true;

          this.rootElement.find('div.oo_end_screen img.oo_fullscreen').show();
        } else {
          // FULLSCREEN EXIT
          // check if UI state is out of sync with video state
          if (this.currentState === 'Playing' && paused) {
            this.mb.publish(OO.EVENTS.PAUSED);
          }
          this.isFullscreen = false;
          this.rootElement.css('overflow','hidden');

          this.rootElement.find('div.oo_end_screen img.oo_fullscreen').hide();

          if(this.useCustomControls) {
            // switch buttons
            this.controlsRoot.find('div.oo_fullscreen').removeClass("oo_fullscreen_off");
            this.controlsRoot.find('div.oo_fullscreen').addClass("oo_fullscreen_on");
            // try to restore controls
            this.controlsCanHide = false;
            this._toggleControls();

            if (OO.isIos && OO.iosMajorVersion < 8) {
              // Switching the src of a video tag while in fullscreen mode causes it to completely
              // ignore the "controls" attribute. You have to manually add and remove it in order to
              // to hide it again after the src swap. Of course, doing it right on fullscreen exit is
              // too early so I've added a delay because it doesn't stick otherwise.
              setTimeout(_.bind(function(){
                this.rootElement.find('video.video').attr("controls", "");
                this.rootElement.find('video.video').removeAttr("controls");
              }, this), 300);
            }
          } else if(!OO.useNativeControls) {
            OO.d('Getting promo back');
            // return promo slide
            this.rootElement.find('div.oo_promo').show();

            this.rootElement.find('video.video').css("left", OO.CSS.INVISIBLE_POSITION);
          }

        }
      },

      onSizeChanged: function(event) {
        this._resizeControls();
        this._updateScrubberProgressBar();
      },

      onDownloading: function(event, currentTime, duration, buffer, seekRange) {
        if (this.useNativeControls) { return; }
        this.bufferTime = buffer;
        this.currentTime = currentTime;
        this.duration = duration;
        this.seekRange = seekRange;
        this._updateScrubberProgressBar();
      },

      onDisablePlaybackControls: function(event) {
        this._toggleControls(false);
        this.controlsEnabled = false;
      },

      onEnablePlaybackControls: function(event) {
        this.controlsEnabled = true;
      },

      _onMouseMove: function(e) {
        if (this.rootElement.find("div.oo_end_screen").is(":visible") ||
            this.rootElement.find("div.oo_promo").is(":visible")) { return; }

        this._toggleControls(true);
      },

      _showControls: function() {
        if (!this.useCustomControls || (this.isVideoAdPlaying && this.params.showInAdControlBar == false)) {
          return;
        }
        this.controlsRoot.css('bottom', '10px');
        if (this.isLivePlaying) {
          this.vodControl.hide();
          this.liveControl.show();
        } else {
          this.vodControl.show();
          this.liveControl.hide();
        }
      },

      _toggleControls: function(force) {
        //if force is undefined, switch controls state
        var visible = false;
        if (this.isVideoAdPlaying && (typeof this.params.showInAdControlBar != 'undefined')
          && (typeof force != 'undefined')) {
          visible = this.params.showInAdControlBar;
        } else if (force === undefined) {
          visible = this.useCustomControls && !this.controlsVisible && this.controlsEnabled;
        } else {
          visible = this.useCustomControls && force && this.controlsEnabled;
        }

        //reset timer
        if(this.controlsTimer) {
          clearTimeout(this.controlsTimer);
          this.controlsTimer = null;
        }

        if (visible) {
          if(this.currentState !== "Paused" && !this.isSeeking) {
            this.controlsTimer = _.delay(_.bind(this._toggleControls, this), this.CONTROLS_TIMEOUT);
          }
          // [PBW-1698] Moved from '_toggleControls'. Need to delay styling in
          // order to show custom controls after exiting fullscreen on iOS 8.
          _.delay(_.bind(this._showControls, this), this.SHOW_CONTROLS_DELAY);
          if (!this.controlsVisible) {
            this.controlsVisible = true;
            this.mb.publish(OO.EVENTS.CONTROLS_SHOWN);
          }
        } else {
          var controlsHeight = '-' + this.controlsRoot.height() + 'px';
          this.controlsRoot.css('bottom', controlsHeight);
          if (this.controlsVisible) {
            this.controlsVisible = false;
            this.mb.publish(OO.EVENTS.CONTROLS_HIDDEN);
          }
        }
      },

      _updateScrubberProgressBar: function() {
        if (this.isSeeking || this.useNativeControls) { return; }
        var live = (this.isLivePlaying && !this.isVideoAdPlaying);
        var scrubber = live ? this.liveControl.scrubber : this.vodControl.scrubber;
        var start = (live && this.seekRange) ? this.seekRange.start : 0;
        var end = (live && this.seekRange) ? this.seekRange.end : this.duration;
        var currentTime = (live && (end - this.currentTime < 10)) ? end - 10 : this.currentTime;
        scrubber.setValue(currentTime, Math.min(this.bufferTime, end), start, end);
      },

      _resizeControls: function() {
        if(this.useCustomControls) {
          if(this.rootElement.width() < 400) {
            this.controlsRoot.addClass('oo_mini_controls').removeClass('oo_full_controls');
          } else {
            this.controlsRoot.removeClass('oo_mini_controls').addClass('oo_full_controls');
          }
        }
      },

      _promoClick: function() {
        this.mb.publish(OO.EVENTS.INITIAL_PLAY);
        return false;
      },

      _playClick: function(e) {
        this.mb.publish(OO.EVENTS.PLAY);
        return false;
      },

      _replayClicked: function(e) {
        this.rootElement.find('div.oo_end_screen').hide();
        this.mb.publish(OO.EVENTS.SEEK, 0);
        this.mb.publish(OO.EVENTS.PLAY);
        return false;
      },

      _pauseClick: function() {
        this.mb.publish(OO.EVENTS.PAUSE);
        return false;
      },

      _fullscreenClick: function() {
        this.mb.publish(OO.EVENTS.WILL_CHANGE_FULLSCREEN, !this.isFullscreen);
        return false;
      },

      _rewindClick: function() {
        this.mb.publish(OO.EVENTS.SEEK, this.currentTime - 30 < 0 ? 0 : this.currentTime - 30);
        return false;
      },

      _scrubStart: function(e) {
        this.wasPlaying = this.currentState == "Playing";
        this.mb.publish(OO.EVENTS.SCRUBBING);
        this.mb.publish(OO.EVENTS.PAUSE);
        this.isSeeking = true;
      },

      _scrub: function(e, time) {
        this.mb.publish(OO.EVENTS.SEEK, time);
      },

      _scrubEnd: function(e, time) {
        this.isSeeking = false;

        this.mb.publish(OO.EVENTS.SCRUBBED);
        if (this.wasPlaying) {
          this.mb.publish(OO.EVENTS.PLAY);
        }

        this._onMouseMove();
      },

      __placeholder: true
    });

    var _PromoUi = function(promo) {
      this.promo = promo;
      this.init();
    };

    _.extend(_PromoUi.prototype, {
      init: function() {
        this.promo.append("<div class='oo_start_button'><img class='oo_start_spinner'></div>");
        var button = this.promo.find("img.oo_start_spinner");
        button.attr({ src: OO.get_img_base64('icon_spinner') });
      },

      setBackground: function(url) {
        this.promo.css('background-image','url('+url+')');
      },

      allowPlayback: function() {
        this.promo.find("div.oo_start_button").html('');
        this.promo.find("div.oo_start_button").css({'background-image': 'url('+OO.get_img_base64('icon_play')+')' });
      },

      disallowPlayback: function() {
        this.promo.find("div.oo_start_button").html("<img class='oo_start_spinner'>");
        this.promo.find("div.oo_start_button").css({'background-image': '' });
        var button = this.promo.find("img.oo_start_spinner");
        button.attr({ src: OO.get_img_base64('icon_spinner') });
      }
    });

    var _Scrubber = function(controlsRoot, min, max) {
      this.scrubber = controlsRoot.find('div.oo_scrubber');
      this.handle = this.scrubber.find('div.oo_playhead');
      this.trackContainer = this.scrubber.find('div.oo_scrubber_track');
      this.playedTrack = this.scrubber.find('div.oo_playhead_progress');
      this.bufferTrack = this.scrubber.find('div.oo_buffer_progress');
      this.currentTime = this.scrubber.find('div.oo_currentTime');
      this.duration = this.scrubber.find('div.oo_duration');
      this.min = min || 0;
      this.max = max || 0;
      this.init();
    };

    _.extend(_Scrubber.prototype, {
      init: function() {
        this.handle.bind('mousedown.scrubber touchstart.scrubber MSPointerDown.scrubber', _.bind(this._onScrubStart, this));
        this.handle.bind('touchmove.scrubber', _.bind(this._onScrub, this));
        this.handle.bind('touchend.scrubber', _.bind(this._onScrubEnd, this));

        $(".oo_progress").each(function() {
          this.onselectstart = function() { return false; };
        });

        $(".oo_playhead").each(function() {
          this.onselectstart = function() { return false; };
        });

        this.setValue(0, 0, 0, 0);
      },

      setValue: function(played, buffered, minTime, maxTime) {
        //allow updates of played and buffered only
        this.min = minTime || this.min;
        this.max = maxTime || this.max;

        //handle and playedTrack
        var playedPercent = (played - minTime) / (maxTime - minTime);
        playedPercent = Math.min(Math.max(0, playedPercent), 1);
        var playedX = playedPercent * (this.trackContainer.width() - this.handle.width());
        this.handle.css('left', playedX);
        this.playedTrack.css('width', playedX + this.handle.width() / 2);

        //buffer precent
        var bufferedPercent = (buffered - minTime) / (maxTime - minTime);
        this.bufferTrack.css('width', (bufferedPercent * this.trackContainer.width()) + 'px');

        //labels
        this.currentTime.html(OO.formatSeconds(played || 0));
        this.duration.html(OO.formatSeconds(maxTime || 0));
      },

      _update: function(x) {
        var scrubberWidth = this.trackContainer.width() - this.handle.width();
        var mouseOffsetX = this.scrubberStartX + x - this.seekStartX;
        var effectiveX = Math.max(Math.min(mouseOffsetX, scrubberWidth), 0);
        var played = ((effectiveX / scrubberWidth) * (this.max - this.min)) + this.min;

        //handle and playedTrack
        this.handle.css('left', effectiveX);
        this.playedTrack.css('width', effectiveX + this.handle.width() / 2);

        //labels
        this.currentTime.html(OO.formatSeconds(played || 0));
        this.duration.html(OO.formatSeconds(this.max || 0));
        return played;
      },

      _onScrubStart: function(e) {
        this.seekStartX = 0;
        if (e.type === "mousedown") {
          $(document).bind('mouseup.scrubber', _.bind(this._onScrubEnd, this));
          $(document).bind('mousemove.scrubber', _.bind(this._onScrub, this));
          this.seekStartX = e.screenX;
        } else if (e.type === "touchstart") {
          this.seekStartX = e.originalEvent.touches[0].screenX;
        } else if (e.type === "MSPointerDown") {
          $(document).bind('MSPointerUp.scrubber', _.bind(this._onScrubEnd, this));
          $(document).bind('MSPointerMove.scrubber', _.bind(this._onScrub, this));
          e.originalEvent.preventDefault();
          this.seekStartX = e.originalEvent.screenX;
        }
        this.scrubberStartX = parseInt(this.handle.css("left"), 10);
        $(this).trigger("scrubStart");
      },

      _onScrub: function(e) {
        var x = 0;
        if (e.type === "mousemove") {
          x = e.screenX;
        } else if (e.type === "touchmove") {
          e.originalEvent.preventDefault();
          this.lastTouchX = e.originalEvent.touches[0].screenX;
          x = this.lastTouchX;
        } else if (e.type === "MSPointerMove") {
          e.originalEvent.preventDefault();
          x = e.originalEvent.screenX;
        }
        $(this).trigger("scrub", this._update(x));
      },

      _onScrubEnd: function(e) {
        var x = 0;
        if (e.type === "mouseup") {
          $(document).unbind('mouseup.scrubber');
          $(document).unbind('mousemove.scrubber');
          x = e.screenX;
        } else if (e.type === "touchend") {
          e.originalEvent.preventDefault();
          x = this.lastTouchX;
        } else if (e.type === "MSPointerUp") {
          $(document).unbind('MSPointerUp.scrubber');
          $(document).unbind('MSPointerMove.scrubber');
          e.originalEvent.preventDefault();
          x = e.originalEvent.screenX;
        }
        $(this).trigger("scrubEnd", this._update(x));
      },

      __end_marker: true
    });

    var _BaseControlBar = function(controlsRoot, basicUi) {
      this.controlsRoot = controlsRoot;
      this.basicUi = basicUi;
    };

    _.extend(_BaseControlBar.prototype, {
      init: function() {},
      show: function() {
        this.controlsRoot.show();
      },
      hide: function() {
        this.controlsRoot.hide();
      },
      __end_marker: true
    });

    var _VodControlBar =  OO.inherit(_BaseControlBar, function(controlsRoot, basicUi) {
      this.controlsRoot = controlsRoot;
      this.basicUi = basicUi;
      this.init();
    });

    _.extend(_VodControlBar.prototype, {
      init: function() {
        this.controlsRoot.append("<div class='oo_scrubber'>\
            <div class='oo_label oo_currentTime'></div>\
            <div class='oo_scrubber_track'>\
              <div class='oo_progress oo_buffer_progress'></div>\
              <div class='oo_progress oo_playhead_progress'></div>\
              <div class='oo_playhead'></div>\
            </div>\
            <div class='oo_label oo_duration'></div>\
          </div>");
        this.controlsRoot.append('<div class="oo_button oo_toolbar_item oo_rewind"></div>');
        this.controlsRoot.append('<div class="oo_button oo_toolbar_item oo_pause" style="display:none;"></div>');
        this.controlsRoot.append('<div class="oo_button oo_toolbar_item oo_play"></div>');
        this.controlsRoot.append('<div class="oo_button oo_toolbar_item oo_fullscreen oo_fullscreen_on"></div>');
        this.scrubber = new _Scrubber(this.controlsRoot);
      }
    });

    var _LiveControlBar = OO.inherit(_BaseControlBar, function(controlsRoot, basicUi) {
      this.controlsRoot = controlsRoot;
      this.basicUi = basicUi;
      this.init();
    });

    _.extend(_LiveControlBar.prototype, {
      init: function() {
        this.controlsRoot.append("<div class='oo_scrubber'>\
        <div class='oo_scrubber_track'>\
          <div class='oo_progress oo_buffer_progress'></div>\
          <div class='oo_progress oo_playhead_progress'></div>\
          <div class='oo_playhead'></div>\
        </div>\
          </div>");
        this.controlsRoot.append('<div class="oo_button oo_toolbar_item oo_rewind"></div>');
        this.controlsRoot.append('<div class="oo_button oo_toolbar_item oo_pause" style="display:none;"></div>');
        this.controlsRoot.append('<div class="oo_button oo_toolbar_item oo_play"></div>');
        this.controlsRoot.append('<div class="oo_live_indicator oo_button oo_toolbar_item"></div>');
        this.controlsRoot.append('<div class="oo_live_message oo_label oo_button oo_toolbar_item"></div>');
        this.controlsRoot.append('<div class="oo_button oo_toolbar_item oo_fullscreen oo_fullscreen_on"></div>');
        this.controlsRoot.find("div.oo_live_message").html(OO.getLocalizedMessage(OO.TEXT.LIVE));
        this.scrubber = new _Scrubber(this.controlsRoot);
      }
    });

    OO.registerModule('basic_ui', function(messageBus, id, params) {
      return new BasicUi(messageBus, id, params);
    });
  }(OO, OO.$, OO._));
  (function(OO, _, $){
    /*
     *  AdsManager will manage the Ads config load and notify playback controller when they are ready.
     *  It will intercept willFetchAds event, and send adFetched event to notify playbck to continue.
     *  PlaybackController will timeout if willFetchAds does not return in OO.playerParams.maxAdsTimeout
     *  seconds.
     */
    var AdsManager = function(messageBus, id) {
      if (!OO.requiredInEnvironment('ads')) {return;}
      this.Id = id;
      this.mb = messageBus;
      this.vastPassThroughAdTagUrl = null; // Will allow run time override

      this.currentEmbedCode = null;
      this.firstAdsIsOoyala = false;
      this.adsItem = null;
      this.adsClickThrough = false;

      this.adIds = [];
      this.adPlayCounts = {};
      this.ignoreClickThrough = false;
      this.rootElement = null;

      OO.StateMachine.create({
        initial:'Init',
        messageBus:this.mb,
        moduleName:'adsManager',
        target:this,
        events:[
          {name:OO.EVENTS.PLAYER_CREATED,                     from:'*',                                       to:'*'},
          {name:OO.EVENTS.EMBED_CODE_CHANGED,                 from:'*',                       to:'Init'},
          {name:OO.EVENTS.CONTENT_TREE_FETCHED,               from:'Init',                                       to:'WaitingForFirstAdRequest'},
          {name:OO.EVENTS.PLAYING,                            from:'WaitingForFirstAdRequest',                             to:'readyToFetchOtherAds'},
          {name:OO.EVENTS.WILL_PLAY_ADS,                      from:'*',                       to:'*'},
          {name:OO.EVENTS.PLAY_MIDROLL_STREAM,                from:'*',                       to:'*'},
          {name:OO.EVENTS.ADS_PLAYED,                         from:'*',                       to:'*'},
          {name:OO.EVENTS.LOAD_ALL_VAST_ADS,                  from:'*',                       to:'*'},
          {name:OO.EVENTS.PLAYER_CLICKED,                     from:'*',                       to:'*'},
          {name:OO.EVENTS.PLAY,                               from:'*',                       to:'*'}
        ]
      });
      // intercept WILL_FETCH_ADS here.
      this.mb.addDependent(OO.EVENTS.WILL_FETCH_ADS, OO.EVENTS.FIRST_AD_FETCHED, "adsManager", function() {});
    };

    _.extend(AdsManager.prototype, {
      onPlayerCreated: function(event, elementId, params) {
        debugger;
        if (params.vast && params.vast.tagUrl) {
          this.vastPassThroughAdTagUrl = params.vast.tagUrl;
        }
        this.ignoreClickThrough = !!params.ignoreClickThrough;
        this.rootElement = $('#' + elementId).find("div.innerWrapper");
      },

      onWillPlayAds: function(event, adItem) {
        this.adsItem = adItem;
        // Detect if it's vast only
        if (!OO.isIos) {
          if (adItem && adItem["type"] == "vast") {
            // Since BasicUi hides the tap element in onWillPlayAds, this depends on this module being
            // registered after BasicUi.  While this is true right now we can't rely on this model in the
            // future.  This will be fixed when vast moves to the ad manager framework.
            this.rootElement.find('div.oo_tap_panel').css('display','');
          }
        }
      },

      onPlayMidrollStream: function(event, streamUrl, adItem) {
        this.adsItem = adItem.item;
      },

      onAdsPlayed: function(event) {
        this.adsItem = null;
      },

      openUrl: function(url) {
        if (!url) { return; }
        window.open(url);
      },

      onPlayerClicked: function(event) {
        if (!this.adsItem || this.ignoreClickThrough) { return; }
        if (this.adsClickThrough) {
          this.adsClickThrough = false;
          this.mb.publish(OO.EVENTS.PLAY);
        } else {
          // Get VAST click throuhg.
          var clickThroughUrl = this.adsItem.data && this.adsItem.data.ClickThrough;
          var linearClickUrl = this.adsItem.data && this.adsItem.data.linear && this.adsItem.data.linear.ClickThrough;
          var ooyalaClickUrl = this.adsItem.click_url;

          if (clickThroughUrl || ooyalaClickUrl || linearClickUrl) {
            this.adsClickThrough = true;
            this.mb.publish(OO.EVENTS.ADS_CLICKED);
            this.openUrl(clickThroughUrl);
            this.openUrl(ooyalaClickUrl);
            this.openUrl(linearClickUrl);
            this.mb.publish(OO.EVENTS.PAUSE);
          }
        }
      },

      onLoadAllVastAds: function(event) {
        _.each(this.ads, function(ad, index){
          if (ad.type == "vast" && !ad.loader) {
            this._setVastAdLoader(ad);
          }
        }, this);
      },

      onPlaying: function(event) {
        this._incrementAdPlayCount();

        // TODO, fetch all ads that are not fetched yet.
        if (!this.firstAdsIsOoyala) { this._checkOoyalaAdsAuth(); }
        this.adsClickThrough = false;
        this.mb.publish(OO.EVENTS.LOAD_ALL_VAST_ADS);
      },

      onEmbedCodeChanged: function(event, embedCode) {
        this.currentEmbedCode = embedCode;
        this.ads = [];
        this.prerolls = [];
        this.firstAdsIsOoyala = false;
        this.adsItem = null;
      },

      _setVastAdLoader: function(ad) {
        if (ad && ad.type == "vast") {
           ad.loader = new OO.VastAdLoader(this.currentEmbedCode);
           ad.loader.on(OO.VastAdLoader.READY, "ads", _.bind(this._onVastReady, this));
           ad.loader.on(OO.VastAdLoader.ERROR, "ads", _.bind(this._onVastError, this));
           if (this.vastPassThroughAdTagUrl) {
             ad.origUrl = ad.origUrl || ad.url;
             ad.url = this.vastPassThroughAdTagUrl;
           }
           ad.loader.loadUrl(ad.url);
        }
      },

      onContentTreeFetched: function(event, content) {
        if (this.currentEmbedCode !== content.embed_code) { return false; }
        this.ads = OO.HM.safeArray("playbackControl.contentTree.ads", content.ads, []);

        // Select the ad set code(s) as well as any public ids for ads that don't belong to an ad set
        this.adIds = _.uniq(_.compact(_.map(this.ads, function(ad) {
          return ad.ad_set_code || ad.public_id;
        })));
        this.adPlayCounts = this._getAdPlayCounts();
        this._filterAdsByFrequency();
        this.prerolls = _.select(this.ads, function(ad, index) {
            // ad.time is null for cuepoints
            return (ad.time !== null && ad.time < 250);
          }, this);

        if (_.size(this.prerolls) > 0) {
          if (this.prerolls[0].type == "ooyala") {
             this._checkOoyalaAdsAuth();
          } else if (this.prerolls[0].type == "vast") {
             this._setVastAdLoader(this.prerolls[0]);
          }
        } else {
          // unblock willFetchAds if there is no preroll ads at all.
          this.mb.publish(OO.EVENTS.FIRST_AD_FETCHED, null);
        }
      },

      onPlay: function(event){
        this.adsClickThrough = false;
      },

      _onVastReady: function(event, loader) {
        this.mb.publish(OO.EVENTS.AD_CONFIG_READY, loader);
        this.mb.publish(OO.EVENTS.FIRST_AD_FETCHED, loader);
      },

      _onVastError: function(event, loader) {
        var ad = (loader.inlineAd && loader.inlineAd.ads[0]) || loader.wrapperAds;
        if (ad) {
          _.each(ad.error, function(url) {
            OO.pixelPing(url);
          }, this);
        }
        if (_.size(this.prerolls) > 0) {
          // check if there is any ooyala ads, if so, check ooyala auth.
          if (_.find(this.prerolls, function(ad) { return ad.type == "ooyala"; }, this)) {
            this._checkOoyalaAdsAuth();
          } else if (_.find(this.prerolls, function(ad) { return !ad.loader; }, this)){
            _.each(this.prerolls, function(ad) {
              if (ad.type == "vast" && !ad.loader) { this._setVastAdLoader(ad); }
            }, this);
          } else {
            this.mb.publish(OO.EVENTS.FIRST_AD_FETCHED, loader);
          }
        }
      },

      _checkOoyalaAdsAuth: function() {
        // check if we have any ooyala ads
        var ooyalaAds = _.select(this.ads, function(ad, index) { return !_.isEmpty(ad.ad_embed_code); }, this);
        var embedCodes = _.map(ooyalaAds, function(ad, index){ return ad.ad_embed_code; }, {});
        this.firstAdsIsOoyala = true;
        if(_.size(embedCodes) > 0) {
          OO.d('Ooyala Ads', this.embedCodes);
          var adsRequest = {
            pcode: OO.playerParams.pcode || "unknown",
            embedCode: embedCodes.join(","),
            server: OO.SERVER.AUTH,
            playerBrandingId: OO.playerParams.playerBrandingId || "unknown",
            params: {}
          };
          this.mb.publish(OO.EVENTS.WILL_FETCH_AD_AUTHORIZATION, adsRequest);
        }
      },

      _incrementAdPlayCount: function() {
        // Increment the play count for each ad id in the data store
        _.each(this.adIds, function(id) {
          this.adPlayCounts[id] = this.adPlayCounts[id] || 0;
          this.adPlayCounts[id] += 1;
        }, this);

        // TODO: Cull LRU from ad play counts so we don't run out of cookie/local storage space
        this._setAdPlayCounts(this.adPlayCounts);
      },

      _filterAdsByFrequency: function() {
        this.ads = _.reject(this.ads, function(ad) {
          var id = ad.ad_set_code || ad.public_id;
          var firstShown = ad.first_shown;
          var frequency = ad.frequency;

          if (!id || firstShown === null || firstShown === undefined || !frequency ||
              ["ooyala", "vast"].indexOf(ad.type) < 0) { return false; }

          var skipAd = true;
          var playCount = this.adPlayCounts[id] || 0;

          if (playCount >= firstShown && (playCount - firstShown) % frequency === 0) { skipAd = false; }
          OO.log("Frequency for ad that is played:", frequency, "first shown:", firstShown,
              "play count:", playCount, "in range =", !skipAd);

          return skipAd;
        }, this);
        this.mb.publish(OO.EVENTS.ADS_FILTERED, this.currentEmbedCode, this.ads);
      },

      _getAdPlayCounts: function() {
        var playCounts = {};
        var countsFromDataStore = OO.localStorage.getItem(OO.CONSTANTS.AD_PLAY_COUNT_KEY);
        if (countsFromDataStore) {
          countsFromDataStore = countsFromDataStore.split(OO.CONSTANTS.AD_PLAY_COUNT_DIVIDER);
          _.each(countsFromDataStore, function(count) {
            count = count.split(OO.CONSTANTS.AD_ID_TO_PLAY_COUNT_DIVIDER);
            if (count[0] !== undefined && count[1] !== undefined) {
              playCounts[count[0]] = parseInt(count[1], 10);
            }
          });
        }

        return playCounts;
      },

      _setAdPlayCounts: function(playCounts) {
        playCounts = _.map(playCounts, function(count, adId) {
          return (adId + OO.CONSTANTS.AD_ID_TO_PLAY_COUNT_DIVIDER + count);
        }).join(OO.CONSTANTS.AD_PLAY_COUNT_DIVIDER);

        OO.setItem(OO.CONSTANTS.AD_PLAY_COUNT_KEY, playCounts);
      },

      __placeholder: true
    });

    OO.registerModule('adsManager', function(messageBus, id) {
      return new AdsManager(messageBus, id);
    });

  }(OO, OO._, OO.$));
// Dummy file that depends on all the ads modules, so it's easier for stitcher to grab them all
// Don't delete, it's required by stitcher.

  OO.plugin("GoogleIma", function(OO, _, $, W){
    /*
     * Google IMA SDK v3
     * https://developers.google.com/interactive-media-ads/docs/sdks/googlehtml5_ads_v3
     * https://developers.google.com/interactive-media-ads/docs/sdks/googlehtml5_apis_v3
     */
    var IMA_MODULE_TYPE = "google-ima-ads-manager";
    var MAX_AD_MANAGER_LOAD_TIME_OUT = 10000;
    var DEFAULT_ADS_REQUEST_TIME_OUT = 3000;
    var PLAYHEAD_UPDATE_INTERVAL = 200;
    var ext = OO.DEV ? '_debug.js' : '.js';
    var IMA_JS = "//imasdk.googleapis.com/js/sdkloader/ima3" + ext;
    var protocol = OO.isSSL ? "https:" : "http:";
    var bootJsSrc = _sp_.getSafeUri(protocol + IMA_JS);

    W.googleImaSdkLoadedCbList = W.googleImaSdkLoadedCbList  || [];
    W.googleImaSdkFailedCbList = W.googleImaSdkFailedCbList || [];
    W.googleImaSdkLoaded = false;

    var onBootStrapReady = function() {
      OO.log("Bootstrap Ready!!!", W.googleImaSdkLoaded);
      if (W.googleImaSdkLoaded) { return; }
      OO._.each(W.googleImaSdkLoadedCbList, function(fn) { fn(); }, OO);
    };

    var onBootStrapFailed = function() {
      OO.log("Bootstrap failed to load!");
      W.googleImaSdkLoaded = false;
      OO._.each(W.googleImaSdkFailedCbList, function(fn) { fn(); }, OO);
    };

    OO._.defer(function() {
      OO.loadScriptOnce(bootJsSrc, onBootStrapReady, onBootStrapFailed, 15000);
    });

    // helper function to convert types to boolean
    // the (!!) trick only works to verify if a string isn't the empty string
    // therefore, we must use a special case for that
    var convertToBoolean = function(value) {
      if (typeof value === 'string') {
        return value.indexOf("true") > -1 || value.indexOf("yes") > -1;
      }
      return !!value;
    };

    var GoogleIma = function(messageBus, id) {
      this.preparePlatformExtensions();
      this.canSetupAdsRequest = false;

      if (this.platformExtensions.preConstructor) { this.platformExtensions.preConstructor(); }
      if (!OO.requiredInEnvironment('html5-playback') && !OO.requiredInEnvironment('cast-playback')) { return; }
      if (OO.isIE) { return; }
      // disable check for ads environment for now.
      //if (!OO.requiredInEnvironment('ads')) {return; }

      OO.EVENTS.GOOGLE_IMA_READY = "googleImaReady";
      OO.EVENTS.GOOGLE_RESUME_CONTENT = "googleResumeContent";
      OO.EVENTS.GOOGLE_IMA_CAN_SEEK = "googleImaCanSeek";
      OO.EVENTS.GOOGLE_IMA_CAN_PLAY = "googleImaCanPlay";
      OO.EVENTS.GOOGLE_IMA_ALL_ADS_DONE = "googleImaAllAdsDone";
      OO.EVENTS.GOOGLE_IMA_REMOVE_BUFFERING = "googleImaRemoveBuffering";

      this.Id = id;
      this.mb = messageBus;
      this.rootElement = null;

      this.currentEmbedCode = null;
      this.adsLoader = null;
      this.adTagUrl = null;
      this.adDisplayContainer = null;
      this.hasError = false;
      this.playheadUpdateTimer = null;
      this.linearAdStarted = false;
      this.adControls = null;
      this.showInAdControlBar = false;
      this.adPauseCalled = false;
      this.adsReady = false;
      this.imaAdsManagerActive = false;
      this.isLinearAd = false;
      this.adTagUrlFromEmbedHash = null;
      this.switchingAdsManager = false;
      this.additionalAdTagParameters = null;
      this.marqueePageOverride = false;
      this.adsRequested = false;
      this.contentEndedHandler = _.bind(this.onContentEnded, this);
      this.contentEnded = false;
      this.customPlayheadTracker = null;
      this.customPlayheadIntervalFunction = _.bind(this._customPlayheadUpdate, this);
      this.playWhenAdClick = null;
      this.isFullscreen = false;
      this.maxAdsRequestTimeout = DEFAULT_ADS_REQUEST_TIME_OUT;
      this.maxAdsRequestTimeoutPageOverride = false;
      this.isLivePlaying = false;
      this.googleResumeContentDispatched = false;
      this.contentResumeAlreadyCalled = false;
      this.adStarted = false;

      W.googleImaSdkLoadedCbList.unshift(OO._.bind(this.onSdkLoaded, this));
      W.googleImaSdkFailedCbList.unshift(OO._.bind(this.onImaAdError, this));

      OO.StateMachine.create({
        initial:'Init',
        messageBus:this.mb,
        moduleName:'googleIma',
        target:this,
        events:[
          {name:OO.EVENTS.PLAYER_CREATED,                     from:'Init',                                       to:'PlayerCreated'},
          {name:OO.EVENTS.SET_EMBED_CODE,                     from:'*',                                          to:'EmbedCodeChanged'},
          {name:OO.EVENTS.AUTHORIZATION_FETCHED,              from:'*'},
          {name:OO.EVENTS.METADATA_FETCHED,                   from:'EmbedCodeChanged',                           to:'*'},
          {name:OO.EVENTS.PLAYER_CLICKED,                     from:'*',                                          to:'*'},
          {name:OO.EVENTS.INITIAL_PLAY,                       from:'*',                                          to:'*'},
          {name:OO.EVENTS.WILL_PLAY_ADS,                      from:'*',                                          to:'*'},
          {name:OO.EVENTS.PAUSE,                              from:'*',                                          to:'*'},
          {name:OO.EVENTS.FULLSCREEN_CHANGED,                 from:'*',                                          to:'*'},
          {name:OO.EVENTS.WILL_PLAY_FROM_BEGINNING,           from:'*',                                          to:'*'},
          {name:OO.EVENTS.SCRUBBING,                          from:'*',                                          to:'*'},
          {name:OO.EVENTS.SCRUBBED,                           from:'*',                                          to:'*'},
          {name:OO.EVENTS.SIZE_CHANGED,                       from:'*',                                          to:'*'},
          {name:OO.EVENTS.STREAM_PAUSED,                      from:'*',                                          to:'*'}
        ]
      });
    };

    _.extend(GoogleIma.prototype, {
      onPlayerCreated: function(event, elementId, params) {
        // Setup timeout for IMA SDK load. Cleared by imaError and onSdkLoaded
        this.unblockPlaybackTimeout = _.delay(_.bind(this.onImaAdError, this), MAX_AD_MANAGER_LOAD_TIME_OUT);

        this.rootElement = $("#" + elementId + " .innerWrapper");
        this.mainVideo = this.rootElement.find("video.video");
        this.mainVideo.on("loadedmetadata", _.bind(this._onVideoMetaLoaded, this));
        this.mainVideo.on("ended", this.contentEndedHandler);

        if (this.platformExtensions.postOnPlayerCreated) { this.platformExtensions.postOnPlayerCreated(); }
        this.mb.intercept(OO.EVENTS.PLAY, 'googleIma', _.bind(this.onPlay, this));
      },

      _processParameters: function(params) {
        if (params && params[IMA_MODULE_TYPE]) {
          if (typeof params[IMA_MODULE_TYPE].adTagUrl !== 'undefined') {
            this.adTagUrl = this.adTagUrlFromEmbedHash = params[IMA_MODULE_TYPE].adTagUrl;
          }

          if (typeof params[IMA_MODULE_TYPE].additionalAdTagParameters !== 'undefined') {
            this.additionalAdTagParameters = params[IMA_MODULE_TYPE].additionalAdTagParameters;
          }

          if (typeof params.showInAdControlBar !== 'undefined') {
            this.showInAdControlBar = params.showInAdControlBar;
          } else {
            this.showInAdControlBar = !!params[IMA_MODULE_TYPE].showInAdControlBar;
          }

          if (typeof params[IMA_MODULE_TYPE].showAdMarquee !== 'undefined') {
            //this takes care of whether or not it's a boolean or a string true, false
            var showAdCountdownText = convertToBoolean(params[IMA_MODULE_TYPE].showAdMarquee);
            this.marqueePageOverride = true;
            this.mb.publish(OO.EVENTS.SHOW_AD_MARQUEE, showAdCountdownText);
          }

          if (typeof params[IMA_MODULE_TYPE].playWhenAdClick !== 'undefined') {
            var playAdClick = convertToBoolean(params[IMA_MODULE_TYPE].playWhenAdClick);
            this.playWhenAdClick = playAdClick;
          }

          if (typeof params[IMA_MODULE_TYPE].adRequestTimeout !== 'undefined') {
            var timeOut = parseInt(params[IMA_MODULE_TYPE].adRequestTimeout, 10);
            if (!_.isNaN(timeOut)) {
              this.maxAdsRequestTimeoutPageOverride = true;
              this.maxAdsRequestTimeout = timeOut;
            }
          }
        }
      },

      _addDependentEvent: function() {
        //[gfrank] setting flag here based on CR [Aldi] in cause this function is reused later at a different place.
        this.googleResumeContentDispatched = false;
        this.mb.addDependent(OO.EVENTS.PLAYBACK_READY, OO.EVENTS.GOOGLE_IMA_READY, "googleIma", function(){});
        this.mb.addDependent(OO.EVENTS.PLAY, OO.EVENTS.GOOGLE_RESUME_CONTENT, "googleIma", function(){});
        this.mb.addDependent(OO.EVENTS.INITIAL_PLAY, OO.EVENTS.GOOGLE_IMA_CAN_PLAY, "googleIma", function(){});
        this.mb.addDependent(OO.EVENTS.CAN_SEEK, OO.EVENTS.GOOGLE_IMA_CAN_SEEK, "googleIma", function(){});
      },

      onSetEmbedCode: function(event, embedCode, params) {
        this.contentResumeAlreadyCalled = false;
        this.canSetupAdsRequest = false;
        this.customPlayheadTracker = {duration: 0, currentTime: 0};
        if (this.platformExtensions.preOnSetEmbedCode) { this.platformExtensions.preOnSetEmbedCode(); }
        this.currentEmbedCode = embedCode;
        this.isLinearAd = false;
        this.adTagUrl = null;
        if (this.adsManager) {
         this.switchingAdsManager = true;
         this.adsManager.destroy();
         // Remove PLAYED addDependency that is set on onAdsManagerLoaded, in case setEmbedCode is called prior ALL_ADS_COMPLETED
         this.mb.publish(OO.EVENTS.GOOGLE_IMA_ALL_ADS_DONE);
        }

        // https://developers.google.com/interactive-media-ads/faq#8
        // let the ad server know that these are legitimate ads requests, and not accidental duplicates
        if (this.adsLoader) { this.adsLoader.contentComplete(); }
        this.adsManager = null;
        this.linearAdStarted = false;
        this.adsRequested = false;
        this.adsReady = false;
        this.contentEnded = false;
        if (this.imaAdsManagerActive) {
          // Safety when setEmbedCode is called while IMA ads is still playing.
          this.mb.publish(OO.EVENTS.ADS_MANAGER_FINISHED_ADS);
          this.disptachContentResume();
          this.imaAdsManagerActive = false;
        }
        clearInterval(this.playheadUpdateTimer);
        this.playheadUpdateTimer = null;
        this.adPauseCalled = false;
        this.isLivePlaying = false;

        // If adTagUrl is set via page level override, enable dependentEvents. Else defer to onMetadataFetched
        this._processParameters(params);
        if (this.adTagUrlFromEmbedHash) { this._addDependentEvent(); }
      },

      onAuthorizationFetched:function(event, response) {
        this.authorization = response;
        this.isLivePlaying = (this.isLivePlaying || this.authorization.streams[0].is_live_stream);
      },

      onMetadataFetched: function(event, response) {
        if (this.platformExtensions.overrideOnMetadataFetched){
          this.platformExtensions.overrideOnMetadataFetched(event, response);
          return;
        }

        OO.log("Metadata Ready:", response, this.adTagUrl, this.adTagUrlFromEmbedHash);
        this.adTagUrl = this.adTagUrlFromEmbedHash;

        var responseChecker =
            (response &&
            response['modules'] &&
            response['modules'][IMA_MODULE_TYPE] &&
            response['modules'][IMA_MODULE_TYPE]['metadata']);

        if (!this.adTagUrl) {
          // set adTagUrl if it is not set yet.
          if (responseChecker) {
            var meta1 = response['modules'][IMA_MODULE_TYPE]['metadata'];
            this.adTagUrl = meta1.adTagUrl || meta1.tagUrl;
            if (this.rootElement && this.adTagUrl) { this._addDependentEvent(); }
          }
          this._unBlockPlaybackReady();
        }

        // checks whether the page level has already overridden
        // if not, it will publish the metadata's showAdMarquee parameter
        if (!this.marqueePageOverride) {
          if (responseChecker) {
            var meta2 = response['modules'][IMA_MODULE_TYPE]['metadata'];
            if (meta2.showAdMarquee) {
              this.mb.publish(OO.EVENTS.SHOW_AD_MARQUEE, convertToBoolean(meta2.showAdMarquee));
            }
          }
        }

        // playWhenAdClick will be null if not set on page-level
        if (this.playWhenAdClick === null) {
          if (responseChecker) {
            var meta3 = response['modules'][IMA_MODULE_TYPE]['metadata'];
            this.playWhenAdClick = meta3.playWhenAdClick;
          }
        }

        if (!this.maxAdsRequestTimeoutPageOverride && responseChecker) {
          if (typeof response['modules'][IMA_MODULE_TYPE]['metadata'].adRequestTimeout !== 'undefined') {
            var timeOut = parseInt(response['modules'][IMA_MODULE_TYPE]['metadata'].adRequestTimeout, 10);
            if (!_.isNaN(timeOut)) {
              this.maxAdsRequestTimeout = timeOut;
            }
          }
        }

        if (this.platformExtensions.postOnMetadataFetched) { this.platformExtensions.postOnMetadataFetched(); }

        this.mb.publish(OO.EVENTS.GOOGLE_IMA_CAN_PLAY);
        this._unBlockPlaybackReady();
      },

      onSdkLoaded: function() {
        if (this.unblockPlaybackTimeout) {
          clearTimeout(this.unblockPlaybackTimeout);
        }

        if (this.platformExtensions.overrideOnSdkLoaded) {
          this.platformExtensions.overrideOnSdkLoaded();
          return;
        }
        OO.log("onSdkLoaded!");

        // [PBK-639] Corner case where Google's SDK 200s but isn't properly
        // loaded. Better safe than sorry..
        if (!(W.google && W.google.ima && W.google.ima.AdDisplayContainer)) {
          this.onImaAdError();
          return;
        }

        W.googleImaSdkLoaded = true;
        this.adDisplayContainer = new W.google.ima.AdDisplayContainer(this.rootElement.find("div.plugins")[0],
          this.rootElement.find("video.video")[0]);
        this.adsLoader = new W.google.ima.AdsLoader(this.adDisplayContainer);

        this.adsLoader.addEventListener(
          W.google.ima.AdsManagerLoadedEvent.Type.ADS_MANAGER_LOADED,
          _.bind(this.onAdsManagerLoaded, this),
          false);
        this.adsLoader.addEventListener(
          W.google.ima.AdErrorEvent.Type.AD_ERROR,
          _.bind(this.onImaAdError, this),
          false);
      },

      _onVideoMetaLoaded: function(event) {
        if (this.platformExtensions.overrideOnVideoMetaLoaded) {
          this.platformExtensions.overrideOnVideoMetaLoaded();
          return;
        }
        this.customPlayheadTracker.duration = this.mainVideo[0].duration;
        this._setCustomPlayheadTracker();
        if (this.imaAdsManagerActive) { return; }
      },

      _setupAdsRequest: function() {
        if (this.adsRequested || !this.canSetupAdsRequest) { return; }
        if (!W.googleImaSdkLoaded) {
          W.googleImaSdkLoadedCbList.push(OO._.bind(this._setupAdsRequest, this));
          return;
        }
        if (!this.adTagUrl || !this.rootElement) { return; }

        var adsRequest = new W.google.ima.AdsRequest();
        if (this.additionalAdTagParameters) {
          var connector = this.adTagUrl.indexOf("?") > 0 ? "&" : "?";

          // Generate an array of key/value pairings, for faster string concat
          var paramArray = [], param = null;
          for (param in this.additionalAdTagParameters) {
            paramArray.push(param + "=" +  this.additionalAdTagParameters[param]);
          }
          this.adTagUrl += connector + paramArray.join("&");
        }

        adsRequest.adTagUrl = OO.getNormalizedTagUrl(this.adTagUrl, this.currentEmbedCode);
        // Specify the linear and nonlinear slot sizes. This helps the SDK to
        // select the correct creative if multiple are returned.
        var w = this.rootElement.width();
        adsRequest.linearAdSlotWidth = w;
        adsRequest.linearAdSlotHeight = this.rootElement.height();

        adsRequest.nonLinearAdSlotWidth = w;
        adsRequest.nonLinearAdSlotHeight = Math.min(150, w / 4);

        OO.log("setup Ads request", this.adTagUrl, this.rootElement);
        this.adsLoader.requestAds(adsRequest);
        _.delay(_.bind(this._adsRequestTimeout, this), this.maxAdsRequestTimeout);
        this.adsRequested = true;
      },

       onAdsManagerLoaded: function (adsManagerLoadedEvent) {
        // AdsManager was getting instantiated multiple times, prevent this.
        if (this.adsManager) {
          return;
        }

        // https://developers.google.com/interactive-media-ads/docs/sdks/googlehtml5_apis_v3#ima.AdsRenderingSettings
        var adsSettings = new W.google.ima.AdsRenderingSettings();
        adsSettings.restoreCustomPlaybackStateOnAdBreakComplete = true;
        this.adsManager = adsManagerLoadedEvent.getAdsManager(this.customPlayheadTracker, adsSettings);

        // Add listeners to the required events.
        this.adsManager.addEventListener(
            W.google.ima.AdEvent.Type.CLICK,
            _.bind(this.onAdClick, this), false, this);
        this.adsManager.addEventListener(
            W.google.ima.AdErrorEvent.Type.AD_ERROR,
            _.bind(this.onImaAdError, this), false, this);
        this.adsManager.addEventListener(
            W.google.ima.AdEvent.Type.CONTENT_PAUSE_REQUESTED,
            _.bind(this.onContentPauseRequested, this), false, this);
        this.adsManager.addEventListener(
            W.google.ima.AdEvent.Type.CONTENT_RESUME_REQUESTED,
            _.bind(this.onContentResumeRequested, this), false, this);

        // Listen to any additional events, if necessary.
        var imaAdEvents = [
                      W.google.ima.AdEvent.Type.ALL_ADS_COMPLETED,
                      W.google.ima.AdEvent.Type.COMPLETE,
                      W.google.ima.AdEvent.Type.SKIPPED,
                      W.google.ima.AdEvent.Type.FIRST_QUARTILE,
                      W.google.ima.AdEvent.Type.LOADED,
                      W.google.ima.AdEvent.Type.MIDPOINT,
                      W.google.ima.AdEvent.Type.PAUSED,
                      W.google.ima.AdEvent.Type.RESUMED,
                      W.google.ima.AdEvent.Type.STARTED,
                      W.google.ima.AdEvent.Type.THIRD_QUARTILE];

        OO._.each(imaAdEvents, function(e) {
          this.adsManager.addEventListener(e, OO._.bind(this.onAdEvent, this), false, this);
        }, this);
        this.adsReady = true;
        this.mb.publish(OO.EVENTS.GOOGLE_IMA_REMOVE_BUFFERING);
        if (this.unblockPlaybackTimeout) {
          clearTimeout(this.unblockPlaybackTimeout);
        }

        this.mb.addDependent(OO.EVENTS.PLAYED, OO.EVENTS.GOOGLE_IMA_ALL_ADS_DONE, "googleIma", function(){});
        if (this.platformExtensions.postOnAdsManagerLoaded) {
          this.platformExtensions.postOnAdsManagerLoaded();
          return;
        }
        this._desktopPostOnAdsManagerLoaded();

      },

      _desktopPostOnAdsManagerLoaded: function() {
        if (OO.supportMultiVideo) { this.rootElement.find('div.oo_tap_panel').css('display', ''); }
        this.adDisplayContainer.initialize();
        if (!OO.supportMultiVideo) {
          this.mainVideo[0].load();
        }
        if (this.adsManager) {
          try {
            this.mb.publish(OO.EVENTS.BUFFERING);
            //ad rules will start from this call
            var width = this.rootElement.width();
            var height = this.rootElement.height();
            this.adsManager.init(width, height, W.google.ima.ViewMode.NORMAL);

            //single ads will start here
            this.adsManager.start();
          } catch(adError) {
            this.onImaAdError(adError);
          }
        }
      },

      _unBlockPlaybackReady: function() {
        this.mb.publish(OO.EVENTS.GOOGLE_IMA_READY);
      },

      _unblockMainContentPlay: function(forcePlay) {
        this.mb.publish(OO.EVENTS.GOOGLE_IMA_CAN_SEEK);
        this.disptachContentResume();
        this.mb.publish(OO.EVENTS.GOOGLE_IMA_CAN_PLAY);
        if (this.linearAdStarted) {
          OO.log("Linear ads started.");
        } else if (forcePlay) {
          _.defer(_.bind(function(){ this.mb.publish(OO.EVENTS.PLAY); }, this));
        }
      },

      _adsRequestTimeout: function() {
        if (!this.adsReady) {
          this.onImaAdError(W.google.ima.AdEvent.Type.FAILED_TO_REQUEST_ADS);
        }
      },

      onImaAdError: function(adErrorEvent) {
        if (this.unblockPlaybackTimeout) {
          clearTimeout(this.unblockPlaybackTimeout);
        }
        OO.log("Can not load Google IMA ADs!!",
          adErrorEvent && adErrorEvent.getError());
        this._unBlockPlaybackReady();

        this.linearAdStarted = false;
        this.mb.publish(OO.EVENTS.ADS_PLAYED);
        this.mb.publish(OO.EVENTS.GOOGLE_IMA_ALL_ADS_DONE);
        this.mb.publish(OO.EVENTS.GOOGLE_RESUME_CONTENT);
        this.mb.publish(OO.EVENTS.GOOGLE_IMA_CAN_PLAY);

        //only resume playing if we were already playing content.
        if (this.adStarted)
        {
          this.onContentResumeRequested();
          if (!this.showInAdControlBar) {
            _.delay(_.bind(function(){ this.mb.publish(OO.EVENTS.ENABLE_PLAYBACK_CONTROLS); }, this), 100);
          }
        }

        if (this.adsManager) {  this.adsManager.destroy(); }
        this.mb.publish(OO.EVENTS.GOOGLE_IMA_REMOVE_BUFFERING);
        this.mb.publish(OO.EVENTS.ADS_ERROR);
      },

      onPlay: function() {
        if (this.switchingAdsManager && OO.supportMultiVideo) {
          this.switchingAdsManager = false;
        } else {
          this.resume();
          if (this.linearAdStarted && this.adsManager) { return false; }
        }
      },

      onPause: function() {
        if (this.platformExtensions.overrideOnPause) {
          this.platformExtensions.overrideOnPause();
          return;
        }
        if (this.adsManager && this.imaAdsManagerActive) {
          this.adPauseCalled = true;
          this.adsManager.pause();
          this.rootElement.find('div.oo_tap_panel').css('display', '');
          // (agunawan): a hack for iPad iOS8. Safari immediately register any elem click event right away.
          // Unlike any other version or even android and desktop browser.
          _.delay(_.bind(function() { this._createTapPanelClickListener(); }, this), 100);
        }
      },

      onStreamPaused: function() {
        if (this.platformExtensions.preOnStreamPaused) {
          this.platformExtensions.preOnStreamPaused();
        }
      },

      _createTapPanelClickListener: function() {
        // (TODO): May interfere with PBI ads_manager clickthrough. Consider to revise or remove.
        this.rootElement.find('div.oo_tap_panel').on("click", _.bind(
          function() {
            this.rootElement.find('div.oo_tap_panel').css('display', 'none');
            this.rootElement.find('div.oo_tap_panel').off("click");
            this.resume();
          }, this));
      },

      onContentPauseRequested: function() {
        this.adStarted = true;
        if (!this.contentEnded) {
          this.mb.addDependent(OO.EVENTS.PLAY, OO.EVENTS.GOOGLE_RESUME_CONTENT, "googleIma", function(){});
          this.googleResumeContentDispatched = false;
        }
        this._dispatchWillPlayAdEvent();
        this.mb.publish(OO.EVENTS.ADS_MANAGER_HANDLING_ADS);
        OO.log("Content Pause Requested by Google IMA!");
        if (this.platformExtensions.preOnContentPauseRequested) { this.platformExtensions.preOnContentPauseRequested(); }
        // video div is used
        if (this.adsManager.isCustomPlaybackUsed()) {
          this.mainVideo.css("left", OO.CSS.VISIBLE_POSITION);
        } else {
          this.mainVideo.css("left", OO.CSS.INVISIBLE_POSITION);
        }
        this.mb.publish(OO.EVENTS.PAUSE);
        if (!this.showInAdControlBar) {
          _.delay(_.bind(function(){ this.mb.publish(OO.EVENTS.DISABLE_PLAYBACK_CONTROLS); }, this), 100);
        }
        this.imaAdsManagerActive = true;
        this.mainVideo.off("ended", this.contentEndedHandler);
        this._deleteCustomPlayheadTracker();
        this.mb.publish(OO.EVENTS.BUFFERING);
      },

      disptachContentResume: function() {
        if (!this.googleResumeContentDispatched) {
          this.googleResumeContentDispatched = true;
          this.mb.publish(OO.EVENTS.GOOGLE_RESUME_CONTENT);
        }
      },

      onContentResumeRequested: function() {
        this.adStarted = false;
        if (this.contentResumeAlreadyCalled) {
          OO.log("Content Already resuming");
          return;
        }
        OO.log("Content Resume Requested by Google IMA!");
        if (this.platformExtensions.preOnContentResumeRequested) { this.platformExtensions.preOnContentResumeRequested(); }
        // plugins div was used
        if (this.adsManager && !this.adsManager.isCustomPlaybackUsed()) {
          this.mainVideo.css("left", OO.CSS.VISIBLE_POSITION);
          this.mainVideo.css("visibility", "visible");
        }
        this._unblockMainContentPlay(!this.contentEnded);
        if (!this.showInAdControlBar) {
          _.delay(_.bind(function(){ this.mb.publish(OO.EVENTS.ENABLE_PLAYBACK_CONTROLS); }, this), 100);
        }
        this.imaAdsManagerActive = false;

        this.mb.publish(OO.EVENTS.ADS_MANAGER_FINISHED_ADS);
        this.mainVideo.on("ended", this.contentEndedHandler);
        this.mb.publish(OO.EVENTS.ADS_PLAYED);
        this._setCustomPlayheadTracker();
        this.mb.publish(OO.EVENTS.BUFFERED);
      },

      resume: function(e) {
        if (this.linearAdStarted && this.adsManager) {
          this.adsManager.resume();
          // adPauseCalled assignment should not needed if google SDK publishes RESUMED event
          this.adPauseCalled = false;
          this.mb.publish(OO.EVENTS.PLAYING);
        }
      },

      onAdClick: function(adEvent) {
        if (!this.linearAdStarted) {
          return;
        } else if (this.adPauseCalled) {
          this.resume();
        } else if (this.platformExtensions.onMobileAdClick) {
          // Mobile should always PAUSE ads upon clickthrough, when ads is playing
          this.platformExtensions.onMobileAdClick();
        } else if (!this.playWhenAdClick) {
          // Desktop depends on playWhenAdClick param
          this.onPause();
        }
        this.mb.publish(OO.EVENTS.ADS_CLICKED);
      },

      _dispatchWillPlayAdEvent: function() {
        // TODO: fill in other metadata useful for ooyala reporter.js
        var adItem = { type: "GOOGLE_IMA" };
        this.mb.publish(OO.EVENTS.WILL_PLAY_ADS, adItem);
        this.mb.publish(OO.EVENTS.GOOGLE_IMA_CAN_SEEK);
      },

      onAdEvent: function(adEvent) {
        // Retrieve the ad from the event. Some events (e.g. ALL_ADS_COMPLETED)
        // don't have ad object associated.
        var ad = adEvent.getAd();
        switch (adEvent.type) {
          case W.google.ima.AdEvent.Type.LOADED:
            // This is the first event sent for an ad - it is possible to
            // determine whether the ad is a video ad or an overlay.
            if (this.platformExtensions.preOnAdEventLoaded) { this.platformExtensions.preOnAdEventLoaded(); }
            this.isLinearAd = ad.isLinear();
            this._updateAdsManagerSize();
            break;
          case W.google.ima.AdEvent.Type.STARTED:
            // This event signalizes the ad has started - the video player
            // can adjust the UI, for example display a pause button and
            // remaining time.
            if (ad.isLinear()) {
              this.linearAdStarted = true;
              // For a linear ad, a timer can be started to poll for the remaining time.
              // Only publishes PlayheadTime event if it is NOT using <video> element, i.e. desktop
              // <video> element playhead is controlled by playback.js
              if (!this.adsManager.isCustomPlaybackUsed()) {
                clearInterval(this.playheadUpdateTimer);
                this.playheadUpdateTimer = setInterval(
                    _.bind(function() {
                      var remainingTime = (this.adsManager && this.adsManager.getRemainingTime() > 0) ?
                        this.adsManager.getRemainingTime() : 0;
                      var adsDuration = (ad && ad.getDuration() > 0) ? ad.getDuration() : 0;
                      this.mb.publish(OO.EVENTS.PLAYHEAD_TIME_CHANGED,
                        Math.max(adsDuration - remainingTime, 0), adsDuration, 0);
                    }, this),
                    PLAYHEAD_UPDATE_INTERVAL); // every 200ms
              }
              this.mb.publish(OO.EVENTS.BUFFERED);
            }
            break;
          case W.google.ima.AdEvent.Type.PAUSED:
            this.adPauseCalled = true;
            this.mb.publish(OO.EVENTS.WILL_PAUSE_ADS);
            break;
          case W.google.ima.AdEvent.Type.RESUMED:
            this.adPauseCalled = false;
            break;
          case W.google.ima.AdEvent.Type.SKIPPED:
          case W.google.ima.AdEvent.Type.COMPLETE:
            // This event signalizes the ad has finished - the video player
            // can do appropriate UI actions, like removing the timer for
            // remaining time detection.
            if (ad.isLinear()) {
              this.linearAdStarted = false;
              clearInterval(this.playheadUpdateTimer);
              this.playheadUpdateTimer = null;
              this.adPauseCalled = false;
            }
            this.onAdMetrics(adEvent);

            // (agunawan): Google SDK is not publishing CONTENT_RESUME with livestream!!! !@#!@#!@#@!#@
            if (this.isLivePlaying) {
              // You should know by know why I did this. Yep iOS8.
              _.delay(_.bind(function() { this.onContentResumeRequested(); }, this), 100);
            }
            if (this.platformExtensions.onAdEventComplete) { this.platformExtensions.onAdEventComplete(adEvent); }
            break;
          case W.google.ima.AdEvent.Type.ALL_ADS_COMPLETED:
            OO.log("all google ima ads completed!");
            if (this.platformExtensions.preOnAdEventAllAdsCompleted) { this.platformExtensions.preOnAdEventAllAdsCompleted(); }
            // ADS_PLAYED must be published first before GOOGLE_IMA_ALL_ADS_DONE (PLAYED)
            // for discovery toaster to show after postroll
            this.mb.publish(OO.EVENTS.ADS_PLAYED);
            this.mb.publish(OO.EVENTS.GOOGLE_IMA_ALL_ADS_DONE);
            break;
          case W.google.ima.AdEvent.Type.FIRST_QUARTILE:
          case W.google.ima.AdEvent.Type.MIDPOINT:
          case W.google.ima.AdEvent.Type.THIRD_QUARTILE:
            this.onAdMetrics(adEvent);
            break;
          default:
            OO.log("other ima event:", adEvent);
            break;
        }
      },

      onAdMetrics: function(adEvent) {
        OO.log("Google IMA Ad playthrough", adEvent.type);
      },

      onInitialPlay: function() {
        if (this.platformExtensions.overrideOnInitialPlay) {
          this.platformExtensions.overrideOnInitialPlay();
          return;
        }

        this.canSetupAdsRequest = true;
        this._setupAdsRequest();
      },

      onFullscreenChanged: function(event, shouldEnterFullscreen) {
        if (!OO.supportMultiVideo) { return; }
        this.isFullscreen = shouldEnterFullscreen;
        this._updateAdsManagerSize();
      },

      _updateAdsManagerSize: function() {
        if (this.adsManager) {
          if (this.isLinearAd) {
            // For linear ad, set the size to the full video player size.
            this.adsManager.resize(this.rootElement.width(), this.rootElement.height(),
                this.isFullscreen ? W.google.ima.ViewMode.FULLSCREEN : W.google.ima.ViewMode.NORMAL);
          } else {
            // For nonlinear ads, the ad slot can be adjusted at this time.
            // In this example, we make the ad to be shown at the bottom
            // of the slot. We also make the slot a bit shorter, so there is
            // a padding at the bottom.
            this.adsManager.resize(this.rootElement.width(), this.rootElement.height() - 40,
                W.google.ima.ViewMode.NORMAL);
            this.adsManager.align(
                W.google.ima.AdSlotAlignment.HorizontalAlignment.CENTER,
                W.google.ima.AdSlotAlignment.VerticalAlignment.BOTTOM);
          }
        }
      },

      // This method handles post roll
      onContentEnded: function() {
        this.contentEnded = true;
        if (this.adsLoader) { this.adsLoader.contentComplete(); }
      },

      onWillPlayFromBeginning: function() {
        this.contentEnded = false;
      },

      // (agunawan): This is a container to be called on constructor. Do not call this unless you know what you are doing.
      _customPlayheadUpdate: function() { this.customPlayheadTracker.currentTime = this.mainVideo[0].currentTime; },

      // Please use this and only this method to instantialize the playheadTracker interval
      _setCustomPlayheadTracker: function() {
        // (agunawan) absolutely only a single customTracker must be instantialized
        if (!this.customPlayheadTracker.updateInterval) {
          this.customPlayheadTracker.updateInterval = setInterval(this.customPlayheadIntervalFunction, 1000);
        }
      },

      // Please use this and only this method to delete the playheadTracker interval
      _deleteCustomPlayheadTracker: function() {
        clearInterval(this.customPlayheadTracker.updateInterval);
        delete this.customPlayheadTracker.updateInterval;
      },

      onScrubbing: function() {
        this._deleteCustomPlayheadTracker();
      },

      onScrubbed: function() {
        this._setCustomPlayheadTracker();
      },

      onSizeChanged: function() {
        this._updateAdsManagerSize();
      },

      preparePlatformExtensions: function() {
        if (OO.isAndroid && OO.isChrome) {
          this.platformExtensions = new (function(imaModule) {
            this.imaModule = imaModule;
          })(this);
          _.extend(this.platformExtensions, {
            preConstructor: function(messageBus, id) {
              this.imaModule.loadedMetadataFired = false;
              this.imaModule.adsLoaderReady = false;
              this.imaModule.firstClick = true;
              this.imaModule.initialPlayCalled = false;
              this.imaModule.initCalled = false;
              this.imaModule.unBlockAndroidPlayback = null;
            },
            overrideOnSdkLoaded: function() {
              clearInterval(this.imaModule.unblockPlaybackTimeout);
              W.googleImaSdkLoaded = true;
            },
            preOnSetEmbedCode: function(event, embedCode) {
              this.imaModule.loadedMetadataFired = false;
              this.imaModule.unBlockAndroidPlayback = null;
              this.imaModule.initCalled = false;
              this.imaModule.adsLoaderReady = false;
              this.imaModule.initialPlayCalled = false;
            },
            overrideOnVideoMetaLoaded: function(event) {
              if (this.imaModule.imaAdsManagerActive) { return; }
              this.imaModule.loadedMetadataFired = true;
              this.imaModule.customPlayheadTracker.duration = this.imaModule.mainVideo[0].duration;
              this.imaModule._setCustomPlayheadTracker();
              this.imaModule.platformExtensions.androidImaInit();
            },
            overrideOnMetadataFetched: function(event, response){
              OO.log("Metadata Ready:", response, this.imaModuleadTagUrl, this.imaModule.adTagUrlFromEmbedHash);
              this.imaModule.adTagUrl = this.imaModule.adTagUrlFromEmbedHash;

              var responseChecker =
                  (response &&
                  response['modules'] &&
                  response['modules'][IMA_MODULE_TYPE] &&
                  response['modules'][IMA_MODULE_TYPE]['metadata']);

              if (!this.imaModule.adTagUrl) {
                // set adTagUrl if it is not set yet.
                if (responseChecker) {
                  var meta4 = response['modules'][IMA_MODULE_TYPE]['metadata'];
                  this.imaModule.adTagUrl = meta4.adTagUrl || meta4.tagUrl;
                  if (this.imaModule.rootElement && this.imaModule.adTagUrl) { this.imaModule._addDependentEvent(); }
                }
                this.imaModule._unBlockPlaybackReady();
              }

              // checks whether the page level has already overridden
              // if not, it will publish the metadata's showAdMarquee parameter
              if (!this.imaModule.marqueePageOverride) {
                if (responseChecker) {
                  var meta5 = response['modules'][IMA_MODULE_TYPE]['metadata'];
                  if (meta5.showAdMarquee) {
                    this.imaModule.mb.publish(OO.EVENTS.SHOW_AD_MARQUEE, convertToBoolean(meta5.showAdMarquee));
                  }
                }
              }

              //playWhenAdClick will be null if not set on page-level
              if (this.imaModule.playWhenAdClick === null) {
                if (responseChecker) {
                  var meta6 = response['modules'][IMA_MODULE_TYPE]['metadata'];
                  this.imaModule.playWhenAdClick = meta6.playWhenAdClick;
                }
              }

              if (!this.imaModule.maxAdsRequestTimeoutPageOverride && responseChecker) {
                if (typeof response['modules'][IMA_MODULE_TYPE]['metadata'].adRequestTimeout !== 'undefined') {
                  var timeOut = parseInt(response['modules'][IMA_MODULE_TYPE]['metadata'].adRequestTimeout, 10);
                  if (!_.isNaN(timeOut)) {
                    this.imaModule.maxAdsRequestTimeout = timeOut;
                  }
                }
              }
              this.imaModule._unBlockPlaybackReady();
              this.imaModule.mb.publish(OO.EVENTS.GOOGLE_IMA_CAN_SEEK);
              this.imaModule.mb.publish(OO.EVENTS.GOOGLE_IMA_CAN_PLAY);
            },
            postOnAdsManagerLoaded: function(event) {
              this.imaModule.adsLoaderReady = true;
              this.imaModule.platformExtensions.androidImaInit();
            },
            preOnContentResumeRequested: function() {
              //Protecting on Android from Resume Content getting called twice.
              this.imaModule.contentResumeAlreadyCalled = true;
            },
            preOnContentPauseRequested: function() {
              //reset flag to false if content paused.
              this.imaModule.contentResumeAlreadyCalled = false;
            },
            onMobileAdClick: function(event) {
              this.imaModule.onPause();
            },
            preOnAdEventLoaded: function() {
              if (this.imaModule.unBlockAndroidPlayback) { clearTimeout(this.imaModule.unBlockAndroidPlayback); }
            },
            overrideOnInitialPlay: function() {
              this.imaModule.initialPlayCalled = true;

              this.imaModule.adDisplayContainer = new W.google.ima.AdDisplayContainer(this.imaModule.rootElement.find("div.plugins")[0],
                this.imaModule.rootElement.find("video.video")[0]);
              this.imaModule.adsLoader = new W.google.ima.AdsLoader(this.imaModule.adDisplayContainer);

              this.imaModule.adsLoader.addEventListener(
                W.google.ima.AdsManagerLoadedEvent.Type.ADS_MANAGER_LOADED,
                _.bind(this.imaModule.onAdsManagerLoaded, this.imaModule),
                false);
              this.imaModule.adsLoader.addEventListener(
                W.google.ima.AdErrorEvent.Type.AD_ERROR,
                _.bind(this.imaModule.onImaAdError, this.imaModule),
                false);

              this.imaModule.canSetupAdsRequest = true;
              this.imaModule._setupAdsRequest();
              if(OO.isAndroid && OO.isChrome) {
                this.imaModule.mb.publish(OO.EVENTS.RELOAD_STREAM);
              }
              if (OO.supportMultiVideo) { this.imaModule.rootElement.find('div.oo_tap_panel').css('display', ''); }
              this.imaModule.adDisplayContainer.initialize();
              if (!OO.supportMultiVideo) {
                this.imaModule.mainVideo[0].load();
              }
              if (this.imaModule.adsManager) {
                try {
                  this.imaModule.platformExtensions.androidImaInit();
                } catch(adError) {
                  this.imaModule.onImaAdError(adError);
                }
              }
              if (this.imaModule.adTagUrl != null) {
                // Gate BUFFERED event when there is a valid adTagURL. Unlocked by imaError or successful ad request
                this.imaModule.mb.addDependent(OO.EVENTS.BUFFERED, OO.EVENTS.GOOGLE_IMA_REMOVE_BUFFERING, "googleIma", function(){});
              }
              this.imaModule.mb.publish(OO.EVENTS.BUFFERING);
            },
            onAdEventComplete: function(adEvent) {
              //PBW-1691: IMA SDK isn't calling content resume after post-roll so we
              //don't get the chance to re-enable controls. So detect if we just completed
              //the final ad in a post-roll pod and fire content resume.
              var adPodInfo = adEvent.getAd().getAdPodInfo();
              if ( adPodInfo.getAdPosition() == adPodInfo.getTotalAds()) {
                this.imaModule.contentResumeRequest = _.delay(_.bind(function() {
                    this.imaModule.onContentResumeRequested();
                  }, this), 500);
              }
            },
            androidImaInit: function() {
              if (this.imaModule.adsLoaderReady && this.imaModule.loadedMetadataFired &&
                  this.imaModule.initialPlayCalled && !this.imaModule.initCalled) {
                this.imaModule.initCalled = true;
                //ad rules will start from this call
                var w = this.imaModule.rootElement.width();
                var h = this.imaModule.rootElement.height();
                this.imaModule.adsManager.init(w, h, W.google.ima.ViewMode.NORMAL);
                //single ads will start here
                this.imaModule.adsManager.start();

                // IMA SDK is not correctly publishing contentResumeRequested.
                // (dustin) stealing agunawan's hack for iOS.
                var _this = this;
                this.imaModule.unBlockAndroidPlayback = _.delay(function() {
                  _this.imaModule.disptachContentResume();
                  _this.imaModule.mb.publish(OO.EVENTS.BUFFERED);
                }, DEFAULT_ADS_REQUEST_TIME_OUT);
              }
            }
          });
        }
        // Android 2.3.X tweaks
        else if (OO.isAndroid && !OO.isChrome) {
          this.platformExtensions = new (function(imaModule) {
            this.imaModule = imaModule;
          })(this);
          _.extend(this.platformExtensions, {
            postOnPlayerCreated: function() {
              // 2.3.X seems to need more than 3 seconds to finish a request,
              // so give it double the time
              this.imaModule.maxAdsRequestTimeout = 6000;
            },
            preOnAdEventAllAdsCompleted: function(adEvent) {
              // force the player to play after the preroll finishes,
              // IMA SDK isn't firing content resume events.
              _.delay(_.bind(function() {
                  this.imaModule.onContentResumeRequested();
                }, this), 500);
            }
          });
        }
        else if (OO.isIos) {
           this.platformExtensions = new (function(imaModule) {
            this.imaModule = imaModule;
          })(this);
          _.extend(this.platformExtensions, {
            preConstructor: function(messageBus, id) {
              this.imaModule.loadedMetadataFired = false;
              this.imaModule.adsLoaderReady = false;
              this.imaModule.initialPlayCalled = false;
              this.imaModule.initCalled = false;
              this.imaModule.canSetupAdsRequest = false;
              this.imaModule.unBlockIOSPlayback = null;
            },
            overrideOnSdkLoaded: function() {
              // As per google guideline: prevent adDisplayContainer and adsRequest without user action (tap)
              if (this.imaModule.unblockPlaybackTimeout) {
                clearTimeout(this.imaModule.unblockPlaybackTimeout);
              }
            },
            preOnSetEmbedCode: function(event, embedCode) {
              this.imaModule.loadedMetadataFired = false;
              this.imaModule.adsLoaderReady = false;
              this.imaModule.initialPlayCalled = false;
              this.imaModule.initCalled = false;
              this.imaModule.canSetupAdsRequest = false;
              this.imaModule.unBlockIOSPlayback = null;
              // IMA SDK is not correctly publishing contentResumeRequested after postroll.
              // Manually set ended listener for the next setEmbedCode
              this.imaModule.mainVideo.on("ended", this.imaModule.contentEndedHandler);
            },
            postOnMetadataFetched: function() {
              // Unblock PLAYBACK_READY and INITIAL_PLAY onMetadataFetched, otherwise player will not be able to play
              this.imaModule._unBlockPlaybackReady();
              this.imaModule.mb.publish(OO.EVENTS.GOOGLE_IMA_CAN_PLAY);
            },
            overrideOnVideoMetaLoaded: function(event) {
              if (this.imaModule.imaAdsManagerActive) { return; }
              this.imaModule.loadedMetadataFired = true;
              this.imaModule.customPlayheadTracker.duration = this.imaModule.mainVideo[0].duration;
              this.imaModule._setCustomPlayheadTracker();
              this.imaModule.platformExtensions.iosImaInit();
            },
            postOnAdsManagerLoaded: function(event) {
              this.imaModule.adsLoaderReady = true;
              this.imaModule.platformExtensions.iosImaInit();
            },
            onMobileAdClick: function(event) {
              this.imaModule.onPause();
            },
            // IMA SDK is not correctly publishing contentResumeRequested. Clear out iOS hack set on iosImaInit.
            preOnAdEventLoaded: function() {
              if (this.imaModule.unBlockIOSPlayback) { clearTimeout(this.imaModule.unBlockIOSPlayback); }
            },
            // IMA SDK is not correctly publishing contentResumeRequested. Prevent playback_control to still think ads is still playing
            preOnAdEventAllAdsCompleted: function() {
              if (OO.isIpad) {
                this.imaModule.rootElement.find('div.plugins').css('display', 'none');
              }
              this.imaModule.mb.publish(OO.EVENTS.ENABLE_PLAYBACK_CONTROLS);
              this.imaModule.mb.publish(OO.EVENTS.ADS_MANAGER_FINISHED_ADS);
            },
            preOnContentPauseRequested: function() {
              // PBW-1910: Google IMA recommended to enable plugins div to show skippable button on iPad
              if (OO.isIpad) {
                this.imaModule.rootElement.find('div.plugins').css('display', 'block');
              }
            },
            preOnContentResumeRequested: function() {
              if (OO.isIpad) {
                this.imaModule.rootElement.find('div.plugins').css('display', 'none');
              }
            },
            // User Click will always get registered as INITIAL_PLAY on iOS. IMA module (or ads manager in future) have to PUBLISH
            // PLAY event if it is already playedOnce. Reset playedOnce on complete / setEmbedCode
            overrideOnInitialPlay: function() {
              if (this.imaModule.initialPlayCalled) {
                this.imaModule.mb.publish(OO.EVENTS.PLAY);
                return;
              }

              this.imaModule.initialPlayCalled = true;
              W.googleImaSdkLoaded = true;

              // PBW-1910: Google IMA recommended to remove custom click through out of iOS.
              this.imaModule.adDisplayContainer = new W.google.ima.AdDisplayContainer(
                this.imaModule.rootElement.find("div.plugins")[0],
                this.imaModule.rootElement.find("video.video")[0]
              );
              this.imaModule.adsLoader = new W.google.ima.AdsLoader(this.imaModule.adDisplayContainer);

              this.imaModule.adsLoader.addEventListener(
                W.google.ima.AdsManagerLoadedEvent.Type.ADS_MANAGER_LOADED,
                _.bind(this.imaModule.onAdsManagerLoaded, this.imaModule),
                false);
              this.imaModule.adsLoader.addEventListener(
                W.google.ima.AdErrorEvent.Type.AD_ERROR,
                _.bind(this.imaModule.onImaAdError, this.imaModule),
                false);

              this.imaModule.canSetupAdsRequest = true;
              this.imaModule._setupAdsRequest();

              if (OO.supportMultiVideo) { this.imaModule.rootElement.find('div.oo_tap_panel').css('display', ''); }
              this.imaModule.adDisplayContainer.initialize();
              if (!OO.supportMultiVideo) {
                this.imaModule.mainVideo[0].load();
              }

              this.imaModule.mb.publish(OO.EVENTS.BUFFERING);
              if (this.imaModule.adTagUrl != null) {
                // Gate BUFFERED event when there is a valid adTagURL. Unlocked by imaError or successful ad request
                this.imaModule.mb.addDependent(OO.EVENTS.BUFFERED, OO.EVENTS.GOOGLE_IMA_REMOVE_BUFFERING, "googleIma", function(){});
              }
              this.imaModule.platformExtensions.iosImaInit();
            },
            iosImaInit: function() {
              if (this.imaModule.adsLoaderReady && this.imaModule.loadedMetadataFired && this.imaModule.adsManager &&
                  this.imaModule.initialPlayCalled && !this.imaModule.initCalled) {
                this.imaModule.initCalled = true;
                //ad rules will start from this call
                var w = this.imaModule.rootElement.width();
                var h = this.imaModule.rootElement.height();
                this.imaModule.adsManager.init(w, h, W.google.ima.ViewMode.NORMAL);
                //single ads will start here
                this.imaModule.adsManager.start();

                // IMA SDK is not correctly publishing contentResumeRequested.
                // (agunawan) This is a hack. Google claims SDK always triggers contentResume event.
                // However I dont see it on iOS on these: solo midroll adSlot and skippable ads on iphone
                var _this = this;
                this.imaModule.unBlockIOSPlayback = _.delay(function() {
                  _this.imaModule.disptachContentResume();
                  _this.imaModule.mb.publish(OO.EVENTS.BUFFERED);
                }, DEFAULT_ADS_REQUEST_TIME_OUT);
              }
            },
            overrideOnPause: function() {
              //no-op
            },
            preOnStreamPaused: function() {
              // [PBW-1832] Fire pause logic on STREAM_PAUSED for iOS. This is for when the
              // user exits fullscreen by hitting the "Done" button which doesn't activate our pause logic.
              if (this.imaModule.adsManager && this.imaModule.imaAdsManagerActive) {
                this.imaModule.adPauseCalled = true;
                this.imaModule.adsManager.pause();
                this.imaModule.rootElement.find('div.oo_tap_panel').css('display', '');
                // (agunawan): a hack for iPad iOS8. Safari immediately register any elem click event right away.
                // Unlike any other version or even android and desktop browser.
                _.delay(_.bind(function() { this._createTapPanelClickListener(); }, this.imaModule), 100);
              }
            }
          });
        }
        else {
          this.platformExtensions = {};
        }
      },

      __placeholder: true
    });

    // Return class definition.
    return GoogleIma;
  });
  (function(OO, $, _){
     OO.Spinner = function(messageBus, div, parent) {
      this.size = 50; // size of image
      this.mb = messageBus;
      if (!div || !div[0]) { return; }
      this.div = div;
      this.parent = parent;
      this.centerInParent();

      this.div.append('<img class="oo_spinner_img"></img>');
      this.img = this.div.find('.oo_spinner_img');
      this.img.css({ width: this.size, height: this.size });
      this.img.attr({ src: OO.get_img_base64('oo_spinner') });

      OO.StateMachine.create({
        initial:'Init',
        messageBus:this.mb,
        moduleName:'Spinner',
        target:this,
        events:[
          {name:OO.EVENTS.SIZE_CHANGED,               from:'*'}
        ]
      });

    };

    _.extend(OO.Spinner.prototype, {
      onSizeChanged: function(event) {
        this.centerInParent();
      },

      centerInParent: function() {
        var x = (this.parent.width() - this.size) / 2;
        var y = (this.parent.height() - this.size) / 2;
        this.div.css({marginTop:y + 'px', marginLeft: x + 'px'});
      },

      play: function() {
        this.div.show();
      },

      pause: function() {
        this.div.hide();
      }
    });
  }(OO, OO.$, OO._));(function(OO, $, _){
  /*
   *  Defines android-specific UI
   */
  var AndroidUi = function(messageBus, id) {
    // short circuit here if the page does not need android ui
    if (!OO.requiredInEnvironment('android-ui')) { return; }

    this.Id = id;
    this.mb = messageBus;

    OO.StateMachine.create({
      initial:'Init',
      messageBus:this.mb,
      moduleName:'AndroidUi',
      target:this,
      events:[
        {name:OO.EVENTS.PLAYER_CREATED,                           from:'Init',                                       to:'PlayerCreated'},
        {name:OO.EVENTS.CONTENT_TREE_FETCHED,                     from:'*',                                          to:'PromoReady'},
        {name:OO.EVENTS.PLAYBACK_READY,                           from:'PromoReady',                                 to:'PlaybackReady'},
        {name:OO.EVENTS.INITIAL_PLAY,                             from:"*"},
        {name:OO.EVENTS.SIZE_CHANGED,                             from:'*'}
      ]
    });
  };

  _.extend(AndroidUi.prototype, {
    onPlayerCreated: function(event, elementId, params) {
      this.elementId = elementId;
      this.rootElement = $('#'+this.elementId + " > div");
      this.params = params;
      this.accentColor = params.accentColor || 0x5D8ADD;

      // load the css
      OO.attachStyle(_.template(OO.get_css("basic_ui"))({
        elementId : this.elementId,
        liveIcon : OO.get_img_base64('icon_live'),
        rewindIcon : OO.get_img_base64('icon_rewind'),
        playIcon : OO.get_img_base64('icon_play'),
        pauseIcon : OO.get_img_base64('icon_pause'),
        errorIcon : OO.get_img_base64('icon_error'),
        playheadIcon : OO.get_img_base64('icon_playhead'),
        fullscreenOnIcon : OO.get_img_base64('icon_full_off'),
        fullscreenOffIcon : OO.get_img_base64('icon_full_on')
      }));


      // display the promo ui
      this.rootElement.append("<div class='plugins' style='display:none'></div>");
      this.rootElement.append('<div class="oo_promo"></div>');
      this.promoUi = new _PromoUi(this.rootElement.find('div.oo_promo'));
    },

    onContentTreeFetched: function(event, contentTree) {
      this.contentTree = contentTree;
      this.promoUi.setBackground(this.contentTree.promo_image || this.contentTree.thumbnail_image);
    },

    onPlaybackReady: function(event, playbackPackage) {
      var title = this.contentTree.title;

      // allow playback
      this.rootElement.find('div.oo_promo').bind('click', _.bind(this._promoClick, this));
      this.promoUi.allowPlayback();
    },

    onInitialPlay: function() {
      this.mb.publish(OO.EVENTS.PLAY);
    },

    _promoClick: function() {
      this.mb.publish(OO.EVENTS.INITIAL_PLAY);
    },

    __placeholder: true
  });

  var _PromoUi = function(promo) {
    this.promo = promo;
    this.init();
  };

  _.extend(_PromoUi.prototype, {
    init: function() {
      this.promo.append("<div class='oo_start_button'><img class='oo_start_spinner'></div>");
      var button = this.promo.find("img.oo_start_spinner");
      button.attr({ src: OO.get_img_base64('icon_spinner') });
    },

    setBackground: function(url) {
      this.promo.css('background-image','url('+url+')');
    },

    allowPlayback: function() {
      this.promo.find("div.oo_start_button").html('');
      this.promo.find("div.oo_start_button").css({'background-image': 'url('+OO.get_img_base64('icon_play')+')' });
    }

  });

  var _ErrorUi = function(container) {
    this.container = container;
    this.container.append('<div class="oo_error_image"></div>');
    this.container.append('<div class="oo_error_message"></div>');
  };

  _.extend(_ErrorUi.prototype, {
    show: function(error) {
      this.container.find('div.oo_error_message').html(OO.getLocalizedMessage(error));
      this.container.show();
    },
    hide: function() {
      this.container.hide();
    }
  });

  OO.registerModule('android_ui', function(messageBus, id) {
    return new AndroidUi(messageBus, id);
  });
}(OO, OO.$, OO._));
  OO.DEV = true;
  window.MJOLNIR_INTERNAL = OO;  // TODO Remove me in production

  (function(OO, _, $){
    /*
     *  Defines a simple debug mode
     */
    var DebugModule = function(messageBus, id) {
      this.Id = id;
    };

    OO.registerModule('debug', function(messageBus, id) {
      return new DebugModule(messageBus, id);
    });
  }(OO, OO._, OO.$));
  OO.exposeStaticApi('EVENTS', OO.EVENTS);
  OO.exposeStaticApi('STATE', OO.STATE);
  OO.exposeStaticApi('ERROR', OO.ERROR);
  OO.publicApi.$ = OO.$;
  OO.publicApi._ = OO._;

  OO.publicApi.__static.apiReady = true;
  OO.$(document).ready(function() {
    OO.publicApi.__static.docReady = true;
    OO.tryCallReady();
  });
}());

} catch (err) {
  if (err && window.console && window.console.log) { window.console.log(err, err.stack); }
}