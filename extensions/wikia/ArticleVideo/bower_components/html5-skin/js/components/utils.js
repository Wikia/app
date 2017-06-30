/**
* Utility class that holds helper functions
*
* @module Utils
*/

var Utils = {
  /**
  * Trims the given text to fit inside of the given element, truncating with ellipsis.
  *
  * @function truncateTextToWidth
  * @param {DOMElement} element - The DOM Element to fit text inside
  * @param {String} text - The string to trim
  * @returns {String} String truncated to fit the width of the element
  */
  truncateTextToWidth: function(element, text) {
    var testText = document.createElement("span");
    testText.style.visibility = "hidden";
    testText.style.position = "absolute";
    testText.style.top = "0";
    testText.style.left = "0";
    testText.style.whiteSpace = "nowrap";
    testText.innerHTML = text;
    element.appendChild(testText);
    var actualWidth = element.clientWidth;
    var textWidth = testText.scrollWidth;
    var truncatedText = "";
    if (textWidth > (actualWidth * 1.8)){
      var truncPercent = actualWidth / textWidth;
      var newWidth = (Math.floor(truncPercent * text.length) * 1.8) - 3;
      truncatedText = text.slice(0,newWidth) + "...";
    }
    else {
      truncatedText = text;
    }
    element.removeChild(testText);
    return truncatedText;
  },

  /**
  * Returns a shallow clone of the object given
  *
  * @function clone
  * @param {Object} object - Object to be cloned
  * @returns {Object} Clone of the given object
  */

  clone: function(object) {
    var clonedObj = {};
    for (var key in object) {
      if (object.hasOwnProperty(key)) {
        clonedObj[key] = object[key];
      }
    }
    return clonedObj;
  },

  /**
  * Clones the given object and merges in the keys and values of the second object.
  * Attributes in the cloned original will be overwritten.
  *
  * @function extend
  * @param {Object} original - Object to be extended
  * @param {Object} toMerge - Object with properties to be merged in
  * @returns {Object} Cloned and merged object
  */

  extend: function(original, toMerge) {
    var extendedObject = Utils.clone(original);
    for (var key in toMerge) {
      if (toMerge.hasOwnProperty(key)) {
        extendedObject[key] = toMerge[key];
      }
    }
    return extendedObject;
  },

  /**
  * Convert raw seconds into human friendly HH:MM format
  *
  * @function formatSeconds
  * @param {integer} time The time to format in seconds
  * @return {String} The time as a string in the HH:MM format
  */
  formatSeconds: function(time) {
    var timeInSeconds = Math.abs(time);
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

    var timeStr = (parseInt(hours,10) > 0) ? (hours + ":" + minutes + ":" + seconds) : (minutes + ":" + seconds);
    if (time >= 0) {
      return timeStr;
    } else {
      return "-" + timeStr;
    }
  },

  /**
  * Check if the current browser is Safari
  *
  * @function isSafari
  * @returns {Boolean} Whether the browser is Safari or not
  */
  isSafari: function () {
    return (!!window.navigator.userAgent.match(/AppleWebKit/) &&
            !window.navigator.userAgent.match(/Chrome/));
  },

  /**
   * Check if the current browser is Chrome
   *
   * @function isChrome
   * @returns {Boolean} Whether the browser is Chrome or not
   */
  isChrome: function () {
    return (!!window.navigator.userAgent.match(/Chrome/) && !!window.navigator.vendor.match(/Google Inc/));
  },

  /**
  * Check if the current browser is Edge
  *
  * @function isEdge
  * @returns {Boolean} Whether the browser is Edge or not
  */
  isEdge: function () {
    return (!!window.navigator.userAgent.match(/Edge/));
  },

  /**
  * Check if the current browser is Internet Explorer
  *
  * @function isIE
  * @returns {Boolean} Whether the browser is IE or not
  */
  isIE: function() {
    return (!!window.navigator.userAgent.match(/MSIE/) || !!window.navigator.userAgent.match(/Trident/));
  },

  /**
  * Check if the current device is Android
  *
  * @function isAndroid
  * @returns {Boolean} Whether the browser is running on Android or not
  */
  isAndroid: function() {
    var os = window.navigator.appVersion;
    return !!os.match(/Android/);
  },

  /**
  * Check if the current device is iOS
  *
  * @function isIos
  * @returns {Boolean} Whether the device is iOS or not
  */
  isIos: function() {
    var platform = window.navigator.platform;
    return !!(platform.match(/iPhone/) || platform.match(/iPad/) || platform.match(/iPod/));
  },

  /**
  * Check if the current device is an iPhone
  *
  * @function isIPhone
  * @returns {Boolean} Whether the device is an iPhone or not
  */
  isIPhone: function() {
    var platform = window.navigator.platform;
    return !!(platform.match(/iPhone/) || platform.match(/iPod/));
  },

  /**
  * Check if the current device is a mobile device
  *
  * @function isMobile
  * @returns {Boolean} Whether the browser device a mobile device or not
  */
  isMobile: function() {
    return (this.isAndroid() || this.isIos());
  },

  /**
  * Check if the current browser is Internet Explorer 10
  *
  * @function isIE10
  * @returns {Boolean} Whether the browser is IE10 or not
  */
  isIE10: function() {
    return !!window.navigator.userAgent.match(/MSIE 10/);
  },

  /**
  * Determine the best language to use for localization
  *
  * @function getLanguageToUse
  * @param {Object} skinConfig - The skin configuration file to read languages from
  * @returns {String} The ISO code of the language to use
  */
  getLanguageToUse: function(skinConfig) {
    var localization = skinConfig.localization;
    var language, availableLanguages;

    // set lang to default lang in skin config
    language = localization.defaultLanguage;

    // if no default lang in skin config check browser lang settings
    if(!language) {
      if(window.navigator.languages){
        // A String, representing the language version of the browser.
        // Examples of valid language codes are: "en", "en-US", "de", "fr", etc.
        language = window.navigator.languages[0];
      }
      else {
        // window.navigator.browserLanguage: current operating system language
        // window.navigator.userLanguage: operating system's natural language setting
        // window.navigator.language: the preferred language of the user, usually the language of the browser UI
        language = window.navigator.browserLanguage || window.navigator.userLanguage || window.navigator.language;
      }

      // remove lang sub-code
      var primaryLanguage = language.substr(0,2);

      // check available lang file for browser lang
      for(var i = 0; i < localization.availableLanguageFile.length; i++) {
        availableLanguages = localization.availableLanguageFile[i];
        // if lang file available set lang to browser primary lang
        if (primaryLanguage == availableLanguages.language){
          language = primaryLanguage;
        }
      }
    }
    return language;
  },

  /**
  * Get the localized string for a given localization key
  *
  * @function getLocalizedString
  * @param {String} language - ISO code of the language to use
  * @param {String} stringId - The key of the localized string to retrieve
  * @param {Object} localizedStrings - Mapping of string keys to localized values
  * @returns {String} The localizted string
  */
  getLocalizedString: function(language, stringId, localizedStrings) {
    try {
      return localizedStrings[language][stringId];
    } catch (e) {
      return "";
    }

  },

  /**
   * Safely gets the value of an object's nested property.
   *
   * @function getPropertyValue
   * @param {Object} object - The object we want to extract the property form
   * @param {String} propertyPath - A path that points to a nested property in the object with a form like 'prop.nestedProp1.nestedProp2'
   * @param {Object} defaltValue - (Optional) A default value to return when the property is undefined
   * @return {Object} - The value of the nested property, the default value if nested property was undefined
   */
  getPropertyValue: function(object, propertyPath, defaltValue) {
    var value = null;
    var currentObject = object;
    var currentProp = null;

    try {
      var props = propertyPath.split('.');

      for (var i = 0; i < props.length; i++) {
        currentProp = props[i];
        currentObject = value = currentObject[currentProp];
      }
      return value || defaltValue;
    } catch (err) {
      return defaltValue;
    }
  },

  /**
  * Highlight the given element for hover effects
  *
  * @function Highlight
  * @param {DOMElement} target - The element to Highlight
  */
  highlight: function(target, opacity, color) {
    target.style.opacity = opacity;
    target.style.color = color;
    target.style.WebkitFilter = "drop-shadow(0px 0px 3px rgba(255,255,255,0.8))";
    target.style.filter = "drop-shadow(0px 0px 3px rgba(255,255,255,0.8))";
    target.style.msFilter = "progid:DXImageTransform.Microsoft.Dropshadow(OffX=0, OffY=0, Color='#fff')";
  },

  /**
  * Remove the highlight effect of the given element
  *
  * @function removeHighlight
  * @param {DOMElement} target - The element to remove the highlight effect from
  * @param {DOMElement} opacity - The opacity to return the element to
  */
  removeHighlight: function(target, opacity, color) {
    target.style.opacity = opacity;
    target.style.color = color;
    target.style.WebkitFilter = "";
    target.style.filter = "";
    target.style.msFilter = "";
  },

  /**
  * Determine which buttons should be shown in the control bar given the width of the player<br/>
  * Note: items which do not meet the item spec will be removed and not appear in the results.
  *
  * @function collapse
  * @param {Number} barWidth - Width of the control bar
  * @param {Object[]} orderedItems - array of left to right ordered items. Each item meets the skin's "button" schema.
  * @returns {Object} An object of the structure {fit:[], overflow:[]} where the fit object is
  *   an array of buttons that fit in the control bar and overflow are the ones that should be hidden
  */
  collapse: function( barWidth, orderedItems, responsiveUIMultiple ) {
    if( isNaN( barWidth ) || barWidth === undefined ) { return orderedItems; }
    if( ! orderedItems ) { return []; }
    var self = this;
    var validItems = orderedItems.filter( function(item) { return self._isValid(item); } );
    var r = this._collapse( barWidth, validItems, responsiveUIMultiple );
    return r;
  },

  /**
  * Find thumbnail image URL and its index that correspond to given time value
  *
  * @function findThumbnail
  * @param {Object} thumbnails - metadata object containing information about thumbnails
  * @param {Number} hoverTime - time value to find thumbnail for
  * @param {Number} duration - duration of the video
  * @returns {Object} object that contains URL and index of requested thumbnail
  */
  findThumbnail: function(thumbnails, hoverTime, duration) {
    var timeSlices = thumbnails.data.available_time_slices;
    var width = thumbnails.data.available_widths[0]; //choosing the lowest size

    var position = Math.floor((hoverTime/duration) * timeSlices.length);
    position = Math.min(position, timeSlices.length - 1);
    position = Math.max(position, 0);

    var selectedTimeSlice = null;
    var selectedPosition = position;

    if (timeSlices[position] >= hoverTime) {
      selectedTimeSlice = timeSlices[0];
      for (var i = position; i >= 0; i--) {
        if (timeSlices[i] <= hoverTime) {
          selectedTimeSlice = timeSlices[i];
          selectedPosition = i;
          break;
        }
      }
    } else {
      selectedTimeSlice = timeSlices[timeSlices.length - 1];
      for (var i = position; i < timeSlices.length; i++) {
        if (timeSlices[i] == hoverTime) {
          selectedTimeSlice = timeSlices[i];
          selectedPosition = i;
          break;
        } else if (timeSlices[i] > hoverTime) {
          selectedTimeSlice = timeSlices[i - 1];
          selectedPosition = i - 1;
          break;
        }
      }
    }

    var selectedThumbnail = thumbnails.data.thumbnails[selectedTimeSlice][width].url;
    return { url: selectedThumbnail, pos: selectedPosition };
  },

  /**
  * Check if the current browser is on a touch enabled device.
  * Function from https://hacks.mozilla.org/2013/04/detecting-touch-its-the-why-not-the-how/
  *
  * @function browserSupportsTouch
  * @returns {Boolean} Whether or not the browser supports touch events.
  */
  browserSupportsTouch: function() {
    return ('ontouchstart' in window) ||
     (navigator.maxTouchPoints > 0) ||
     (navigator.msMaxTouchPoints > 0);
  },

  /**
   * Creates wrapper object with sanitized html. This marked data can subsequently be passed into dangerouslySetInnerHTML
   * See https://facebook.github.io/react/tips/dangerously-set-inner-html.html
   *
   * @function createMarkup
   * @returns {Object} Wrapper object for sanitized markup.
   */
  createMarkup: function(html) {
    return {__html: html};
  },

  _isValid: function( item ) {
    var valid = (
      item &&
      item.location == "moreOptions" ||
      (item.location == "controlBar" &&
        item.whenDoesNotFit &&
        item.minWidth !== undefined &&
        item.minWidth >= 0)
    );
    return valid;
  },

  _collapse: function( barWidth, orderedItems, responsiveUIMultiple ) {
    var r = { fit : orderedItems.slice(), overflow : [] };
    var usedWidth = orderedItems.reduce( function(p,c,i,a) { return p + responsiveUIMultiple * c.minWidth; }, 0 );
    for( var i = orderedItems.length-1; i >= 0; --i ) {
      var item = orderedItems[ i ];
      if( this._isOnlyInMoreOptions(item) ) {
        usedWidth = this._collapseLastItemMatching(r, item, usedWidth);
      }
      if( usedWidth > barWidth && this._isCollapsable(item) ) {
        usedWidth = this._collapseLastItemMatching(r, item, usedWidth);
      }
    }
    return r;
  },

  _isOnlyInMoreOptions: function( item ) {
    var must = item.location == "moreOptions";
    return must;
  },

  _isCollapsable: function( item ) {
    var collapsable = item.location == "controlBar" && item.whenDoesNotFit && item.whenDoesNotFit != "keep";
    return collapsable;
  },

  _collapseLastItemMatching: function( results, item, usedWidth ) {
    var i = results.fit.lastIndexOf( item );
    if( i > -1 ) {
      results.fit.splice( i, 1 );
      results.overflow.unshift( item );
      if( item.minWidth ) {
        usedWidth -= item.minWidth;
      }
    }
    return usedWidth;
  }
};

module.exports = Utils;
