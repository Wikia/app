/**
 * Added by Wikia
 * Credit: https://github.com/KyleAMathews/deepmerge
 */

(function (root, factory) {
  // Wikia quickfix for issues with Modil.js (require(['deepMerge']) was returning an empty object)
  window.ooyalaDeepMerge = factory();
}(this, function () {

  function isMergeableObject(val) {
    var nonNullObject = val && typeof val === 'object';

    return nonNullObject
      && Object.prototype.toString.call(val) !== '[object RegExp]'
      && Object.prototype.toString.call(val) !== '[object Date]'
  }

  function emptyTarget(val) {
    return Array.isArray(val) ? [] : {}
  }

  function cloneIfNecessary(value, optionsArgument) {
    var clone = optionsArgument && optionsArgument.clone === true;
    return (clone && isMergeableObject(value)) ? deepmerge(emptyTarget(value), value, optionsArgument) : value
  }

  function defaultArrayMerge(target, source, optionsArgument) {
    //console.log("****** utils defaultArrayMerge target: ", target);
    //console.log("****** utils defaultArrayMerge source: ", source);

    var destination = target.slice();
    source.forEach(function(e, i) {
      if (typeof destination[i] === 'undefined') {
        destination[i] = cloneIfNecessary(e, optionsArgument)
      } else if (isMergeableObject(e)) {
        destination[i] = deepmerge(target[i], e, optionsArgument)
      } else if (target.indexOf(e) === -1) {
        destination.push(cloneIfNecessary(e, optionsArgument))
      }
    });
    //console.log("****** utils defaultArrayMerge destination: ", destination);
    return destination;
  }

  function mergeObject(target, source, optionsArgument) {
    var destination = {};
    if (isMergeableObject(target)) {
      Object.keys(target).forEach(function (key) {
        destination[key] = cloneIfNecessary(target[key], optionsArgument)
      })
    }
    Object.keys(source).forEach(function (key) {
      if (!isMergeableObject(source[key]) || !target[key]) {
        destination[key] = cloneIfNecessary(source[key], optionsArgument)
      } else {
        destination[key] = deepmerge(target[key], source[key], optionsArgument)
      }
    });
    return destination
  }

  function deepmerge(target, source, optionsArgument) {
    var array = Array.isArray(source);
    var options = optionsArgument || { arrayMerge: defaultArrayMerge };
    var arrayMerge = options.arrayMerge || defaultArrayMerge;

    if (array) {
      return Array.isArray(target) ? arrayMerge(target, source, optionsArgument) : cloneIfNecessary(source, optionsArgument)
    } else {
      return mergeObject(target, source, optionsArgument)
    }
  }

  deepmerge.all = function deepmergeAll(array, optionsArgument) {
    if (!Array.isArray(array) || array.length < 2) {
      throw new Error('first argument should be an array with at least two elements')
    }

    // we are sure there are at least 2 values, so it is safe to have no initial value
    return array.reduce(function(prev, next) {
      return deepmerge(prev, next, optionsArgument)
    })
  };

  return deepmerge

}));
