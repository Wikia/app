/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };
	
	var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol ? "symbol" : typeof obj; }; /** @module pbjs */
	
	var _utils = __webpack_require__(1);
	
	__webpack_require__(3);
	
	function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
	
	// if pbjs already exists in global document scope, use it, if not, create the object
	window.pbjs = window.pbjs || {};
	window.pbjs.que = window.pbjs.que || [];
	var pbjs = window.pbjs;
	var CONSTANTS = __webpack_require__(2);
	var utils = __webpack_require__(1);
	var bidmanager = __webpack_require__(4);
	var adaptermanager = __webpack_require__(6);
	var bidfactory = __webpack_require__(9);
	var adloader = __webpack_require__(10);
	var events = __webpack_require__(5);
	
	/* private variables */
	
	var objectType_function = 'function';
	var objectType_undefined = 'undefined';
	var objectType_object = 'object';
	var BID_WON = CONSTANTS.EVENTS.BID_WON;
	var AUCTION_END = CONSTANTS.EVENTS.AUCTION_END;
	
	var auctionRunning = false;
	var bidRequestQueue = [];
	var presetTargeting = [];
	var pbTargetingKeys = [];
	
	var eventValidators = {
	  bidWon: checkDefinedPlacement
	};
	
	/* Public vars */
	
	pbjs._bidsRequested = [];
	pbjs._bidsReceived = [];
	pbjs._winningBids = [];
	pbjs._adsReceived = [];
	pbjs._sendAllBids = false;
	
	//default timeout for all bids
	pbjs.bidderTimeout = pbjs.bidderTimeout || 3000;
	pbjs.logging = pbjs.logging || false;
	
	//let the world know we are loaded
	pbjs.libLoaded = true;
	
	//version auto generated from build
	utils.logInfo('Prebid.js v0.12.0 loaded');
	
	//create adUnit array
	pbjs.adUnits = pbjs.adUnits || [];
	
	/**
	 * Command queue that functions will execute once prebid.js is loaded
	 * @param  {function} cmd Annoymous function to execute
	 * @alias module:pbjs.que.push
	 */
	pbjs.que.push = function (cmd) {
	  if ((typeof cmd === 'undefined' ? 'undefined' : _typeof(cmd)) === objectType_function) {
	    try {
	      cmd.call();
	    } catch (e) {
	      utils.logError('Error processing command :' + e.message);
	    }
	  } else {
	    utils.logError('Commands written into pbjs.que.push must wrapped in a function');
	  }
	};
	
	function processQue() {
	  for (var i = 0; i < pbjs.que.length; i++) {
	    if (_typeof(pbjs.que[i].called) === objectType_undefined) {
	      try {
	        pbjs.que[i].call();
	        pbjs.que[i].called = true;
	      } catch (e) {
	        utils.logError('Error processing command :', 'prebid.js', e);
	      }
	    }
	  }
	}
	
	function checkDefinedPlacement(id) {
	  var placementCodes = pbjs._bidsRequested.map(function (bidSet) {
	    return bidSet.bids.map(function (bid) {
	      return bid.placementCode;
	    });
	  }).reduce(_utils.flatten).filter(_utils.uniques);
	
	  if (!utils.contains(placementCodes, id)) {
	    utils.logError('The "' + id + '" placement is not defined.');
	    return;
	  }
	
	  return true;
	}
	
	function resetPresetTargeting() {
	  if ((0, _utils.isGptPubadsDefined)()) {
	    window.googletag.pubads().getSlots().forEach(function (slot) {
	      pbTargetingKeys.forEach(function (key) {
	        slot.setTargeting(key, null);
	      });
	    });
	  }
	}
	
	function setTargeting(targetingConfig) {
	  window.googletag.pubads().getSlots().forEach(function (slot) {
	    targetingConfig.filter(function (targeting) {
	      return Object.keys(targeting)[0] === slot.getAdUnitPath() || Object.keys(targeting)[0] === slot.getSlotElementId();
	    }).forEach(function (targeting) {
	      return targeting[Object.keys(targeting)[0]].forEach(function (key) {
	        key[Object.keys(key)[0]].map(function (value) {
	          utils.logMessage('Attempting to set key value for slot: ' + slot.getSlotElementId() + ' key: ' + Object.keys(key)[0] + ' value: ' + value);
	          return value;
	        }).forEach(function (value) {
	          slot.setTargeting(Object.keys(key)[0], value);
	        });
	      });
	    });
	  });
	}
	
	function isNotSetByPb(key) {
	  return pbTargetingKeys.indexOf(key) === -1;
	}
	
	function getPresetTargeting() {
	  if ((0, _utils.isGptPubadsDefined)()) {
	    presetTargeting = function getPresetTargeting() {
	      return window.googletag.pubads().getSlots().map(function (slot) {
	        return _defineProperty({}, slot.getAdUnitPath(), slot.getTargetingKeys().filter(isNotSetByPb).map(function (key) {
	          return _defineProperty({}, key, slot.getTargeting(key));
	        }));
	      });
	    }();
	  }
	}
	
	function getWinningBidTargeting() {
	  var winners = pbjs._bidsReceived.map(function (bid) {
	    return bid.adUnitCode;
	  }).filter(_utils.uniques).map(function (adUnitCode) {
	    return pbjs._bidsReceived.filter(function (bid) {
	      return bid.adUnitCode === adUnitCode ? bid : null;
	    }).reduce(_utils.getHighestCpm, {
	      adUnitCode: adUnitCode,
	      cpm: 0,
	      adserverTargeting: {},
	      timeToRespond: 0
	    });
	  });
	
	  // winning bids with deals need an hb_deal targeting key
	  winners.filter(function (bid) {
	    return bid.dealId;
	  }).map(function (bid) {
	    return bid.adserverTargeting.hb_deal = bid.dealId;
	  });
	
	  winners = winners.map(function (winner) {
	    return _defineProperty({}, winner.adUnitCode, Object.keys(winner.adserverTargeting, function (key) {
	      return key;
	    }).map(function (key) {
	      return _defineProperty({}, key.substring(0, 20), [winner.adserverTargeting[key]]);
	    }));
	  });
	
	  return winners;
	}
	
	function getDealTargeting() {
	  return pbjs._bidsReceived.filter(function (bid) {
	    return bid.dealId;
	  }).map(function (bid) {
	    var dealKey = 'hb_deal_' + bid.bidderCode;
	    return _defineProperty({}, bid.adUnitCode, CONSTANTS.TARGETING_KEYS.map(function (key) {
	      return _defineProperty({}, (key + '_' + bid.bidderCode).substring(0, 20), [bid.adserverTargeting[key]]);
	    }).concat(_defineProperty({}, dealKey, [bid.adserverTargeting[dealKey]])));
	  });
	}
	
	/**
	 * Get custom targeting keys for bids that have `alwaysUseBid=true`.
	 */
	function getAlwaysUseBidTargeting() {
	  return pbjs._bidsReceived.map(function (bid) {
	    if (bid.alwaysUseBid) {
	      var _ret = function () {
	        var standardKeys = CONSTANTS.TARGETING_KEYS;
	        return {
	          v: _defineProperty({}, bid.adUnitCode, Object.keys(bid.adserverTargeting, function (key) {
	            return key;
	          }).map(function (key) {
	            // Get only the non-standard keys of the losing bids, since we
	            // don't want to override the standard keys of the winning bid.
	            if (standardKeys.indexOf(key) > -1) {
	              return;
	            }
	
	            return _defineProperty({}, key.substring(0, 20), [bid.adserverTargeting[key]]);
	          }).filter(function (key) {
	            return key;
	          }))
	        };
	      }();
	
	      if ((typeof _ret === 'undefined' ? 'undefined' : _typeof(_ret)) === "object") return _ret.v;
	    }
	  }).filter(function (bid) {
	    return bid;
	  }); // removes empty elements in array;
	}
	
	function getBidLandscapeTargeting() {
	  var standardKeys = CONSTANTS.TARGETING_KEYS;
	
	  return pbjs._bidsReceived.map(function (bid) {
	    if (bid.adserverTargeting) {
	      return _defineProperty({}, bid.adUnitCode, standardKeys.map(function (key) {
	        return _defineProperty({}, (key + '_' + bid.bidderCode).substring(0, 20), [bid.adserverTargeting[key]]);
	      }));
	    }
	  }).filter(function (bid) {
	    return bid;
	  }); // removes empty elements in array
	}
	
	function getAllTargeting() {
	  // Get targeting for the winning bid. Add targeting for any bids that have
	  // `alwaysUseBid=true`. If sending all bids is enabled, add targeting for losing bids.
	  var targeting = getDealTargeting().concat(getWinningBidTargeting()).concat(getAlwaysUseBidTargeting()).concat(pbjs._sendAllBids ? getBidLandscapeTargeting() : []);
	
	  //store a reference of the targeting keys
	  targeting.map(function (adUnitCode) {
	    Object.keys(adUnitCode).map(function (key) {
	      adUnitCode[key].map(function (targetKey) {
	        if (pbTargetingKeys.indexOf(Object.keys(targetKey)[0]) === -1) {
	          pbTargetingKeys = Object.keys(targetKey).concat(pbTargetingKeys);
	        }
	      });
	    });
	  });
	  return targeting;
	}
	
	function markComplete(adObject) {
	  pbjs._bidsRequested.filter(function (request) {
	    return request.requestId === adObject.requestId;
	  }).forEach(function (request) {
	    return request.bids.filter(function (bid) {
	      return bid.placementCode === adObject.adUnitCode;
	    }).forEach(function (bid) {
	      return bid.complete = true;
	    });
	  });
	
	  pbjs._bidsReceived.filter(function (bid) {
	    return bid.requestId === adObject.requestId && bid.adUnitCode === adObject.adUnitCode;
	  }).forEach(function (bid) {
	    return bid.complete = true;
	  });
	}
	
	function removeComplete() {
	  var requests = pbjs._bidsRequested;
	  var responses = pbjs._bidsReceived;
	
	  requests.map(function (request) {
	    return request.bids.filter(function (bid) {
	      return bid.complete;
	    });
	  }).forEach(function (request) {
	    return requests.splice(requests.indexOf(request), 1);
	  });
	
	  responses.filter(function (bid) {
	    return bid.complete;
	  }).forEach(function (bid) {
	    return responses.splice(responses.indexOf(bid), 1);
	  });
	
	  // also remove bids that have an empty or error status so known as not pending for render
	  responses.filter(function (bid) {
	    return bid.getStatusCode && bid.getStatusCode() === 2;
	  }).forEach(function (bid) {
	    return responses.slice(responses.indexOf(bid), 1);
	  });
	}
	
	//////////////////////////////////
	//                              //
	//    Start Public APIs         //
	//                              //
	//////////////////////////////////
	
	/**
	 * This function returns the query string targeting parameters available at this moment for a given ad unit. Note that some bidder's response may not have been received if you call this function too quickly after the requests are sent.
	 * @param  {string} [adunitCode] adUnitCode to get the bid responses for
	 * @alias module:pbjs.getAdserverTargetingForAdUnitCodeStr
	 * @return {array}  returnObj return bids array
	 */
	pbjs.getAdserverTargetingForAdUnitCodeStr = function (adunitCode) {
	  utils.logInfo('Invoking pbjs.getAdserverTargetingForAdUnitCodeStr', arguments);
	
	  // call to retrieve bids array
	  if (adunitCode) {
	    var res = pbjs.getAdserverTargetingForAdUnitCode(adunitCode);
	    return utils.transformAdServerTargetingObj(res);
	  } else {
	    utils.logMessage('Need to call getAdserverTargetingForAdUnitCodeStr with adunitCode');
	  }
	};
	
	/**
	* This function returns the query string targeting parameters available at this moment for a given ad unit. Note that some bidder's response may not have been received if you call this function too quickly after the requests are sent.
	 * @param adUnitCode {string} adUnitCode to get the bid responses for
	 * @returns {object}  returnObj return bids
	 */
	pbjs.getAdserverTargetingForAdUnitCode = function (adUnitCode) {
	  utils.logInfo('Invoking pbjs.getAdserverTargetingForAdUnitCode', arguments);
	
	  return getAllTargeting().filter(function (targeting) {
	    return (0, _utils.getKeys)(targeting)[0] === adUnitCode;
	  }).map(function (targeting) {
	    return _defineProperty({}, Object.keys(targeting)[0], targeting[Object.keys(targeting)[0]].map(function (target) {
	      return _defineProperty({}, Object.keys(target)[0], target[Object.keys(target)[0]].join(', '));
	    }).reduce(function (p, c) {
	      return _extends(c, p);
	    }, {}));
	  }).reduce(function (accumulator, targeting) {
	    var key = Object.keys(targeting)[0];
	    accumulator[key] = _extends({}, accumulator[key], targeting[key]);
	    return accumulator;
	  }, {})[adUnitCode];
	};
	
	/**
	 * returns all ad server targeting for all ad units
	 * @return {object} Map of adUnitCodes and targeting values []
	 * @alias module:pbjs.getAdserverTargeting
	 */
	
	pbjs.getAdserverTargeting = function () {
	  utils.logInfo('Invoking pbjs.getAdserverTargeting', arguments);
	  return getAllTargeting().map(function (targeting) {
	    return _defineProperty({}, Object.keys(targeting)[0], targeting[Object.keys(targeting)[0]].map(function (target) {
	      return _defineProperty({}, Object.keys(target)[0], target[Object.keys(target)[0]].join(', '));
	    }).reduce(function (p, c) {
	      return _extends(c, p);
	    }, {}));
	  }).reduce(function (accumulator, targeting) {
	    var key = Object.keys(targeting)[0];
	    accumulator[key] = _extends({}, accumulator[key], targeting[key]);
	    return accumulator;
	  }, {});
	};
	
	/**
	 * This function returns the bid responses at the given moment.
	 * @alias module:pbjs.getBidResponses
	 * @return {object}            map | object that contains the bidResponses
	 */
	
	pbjs.getBidResponses = function () {
	  utils.logInfo('Invoking pbjs.getBidResponses', arguments);
	  var responses = pbjs._bidsReceived;
	
	  // find the last requested id to get responses for most recent auction only
	  var currentRequestId = responses && responses.length && responses[responses.length - 1].requestId;
	
	  return responses.map(function (bid) {
	    return bid.adUnitCode;
	  }).filter(_utils.uniques).map(function (adUnitCode) {
	    return responses.filter(function (bid) {
	      return bid.requestId === currentRequestId && bid.adUnitCode === adUnitCode;
	    });
	  }).filter(function (bids) {
	    return bids && bids[0] && bids[0].adUnitCode;
	  }).map(function (bids) {
	    return _defineProperty({}, bids[0].adUnitCode, { bids: bids });
	  }).reduce(function (a, b) {
	    return _extends(a, b);
	  }, {});
	};
	
	/**
	 * Returns bidResponses for the specified adUnitCode
	 * @param  {String} adUnitCode adUnitCode
	 * @alias module:pbjs.getBidResponsesForAdUnitCode
	 * @return {Object}            bidResponse object
	 */
	
	pbjs.getBidResponsesForAdUnitCode = function (adUnitCode) {
	  var bids = pbjs._bidsReceived.filter(function (bid) {
	    return bid.adUnitCode === adUnitCode;
	  });
	  return {
	    bids: bids
	  };
	};
	
	/**
	 * Set query string targeting on all GPT ad units.
	 * @alias module:pbjs.setTargetingForGPTAsync
	 */
	pbjs.setTargetingForGPTAsync = function () {
	  utils.logInfo('Invoking pbjs.setTargetingForGPTAsync', arguments);
	  if (!(0, _utils.isGptPubadsDefined)()) {
	    utils.logError('window.googletag is not defined on the page');
	    return;
	  }
	
	  //first reset any old targeting
	  getPresetTargeting();
	  resetPresetTargeting();
	  //now set new targeting keys
	  setTargeting(getAllTargeting());
	};
	
	/**
	 * Returns a bool if all the bids have returned or timed out
	 * @alias module:pbjs.allBidsAvailable
	 * @return {bool} all bids available
	 */
	pbjs.allBidsAvailable = function () {
	  utils.logInfo('Invoking pbjs.allBidsAvailable', arguments);
	  return bidmanager.bidsBackAll();
	};
	
	/**
	 * This function will render the ad (based on params) in the given iframe document passed through. Note that doc SHOULD NOT be the parent document page as we can't doc.write() asynchrounsly
	 * @param  {object} doc document
	 * @param  {string} id bid id to locate the ad
	 * @alias module:pbjs.renderAd
	 */
	pbjs.renderAd = function (doc, id) {
	  utils.logInfo('Invoking pbjs.renderAd', arguments);
	  utils.logMessage('Calling renderAd with adId :' + id);
	  if (doc && id) {
	    try {
	      //lookup ad by ad Id
	      var adObject = pbjs._bidsReceived.find(function (bid) {
	        return bid.adId === id;
	      });
	      if (adObject) {
	        //save winning bids
	        pbjs._winningBids.push(adObject);
	        //emit 'bid won' event here
	        events.emit(BID_WON, adObject);
	
	        // mark bid requests and responses for this placement in this auction as "complete"
	        markComplete(adObject);
	        var height = adObject.height;
	        var width = adObject.width;
	        var url = adObject.adUrl;
	        var ad = adObject.ad;
	
	        if (ad) {
	          doc.write(ad);
	          doc.close();
	          if (doc.defaultView && doc.defaultView.frameElement) {
	            doc.defaultView.frameElement.width = width;
	            doc.defaultView.frameElement.height = height;
	          }
	        } else if (url) {
	          doc.write('<IFRAME SRC="' + url + '" FRAMEBORDER="0" SCROLLING="no" MARGINHEIGHT="0" MARGINWIDTH="0" TOPMARGIN="0" LEFTMARGIN="0" ALLOWTRANSPARENCY="true" WIDTH="' + width + '" HEIGHT="' + height + '"></IFRAME>');
	          doc.close();
	
	          if (doc.defaultView && doc.defaultView.frameElement) {
	            doc.defaultView.frameElement.width = width;
	            doc.defaultView.frameElement.height = height;
	          }
	        } else {
	          utils.logError('Error trying to write ad. No ad for bid response id: ' + id);
	        }
	      } else {
	        utils.logError('Error trying to write ad. Cannot find ad by given id : ' + id);
	      }
	    } catch (e) {
	      utils.logError('Error trying to write ad Id :' + id + ' to the page:' + e.message);
	    }
	  } else {
	    utils.logError('Error trying to write ad Id :' + id + ' to the page. Missing document or adId');
	  }
	};
	
	/**
	 * Remove adUnit from the pbjs configuration
	 * @param  {String} adUnitCode the adUnitCode to remove
	 * @alias module:pbjs.removeAdUnit
	 */
	pbjs.removeAdUnit = function (adUnitCode) {
	  utils.logInfo('Invoking pbjs.removeAdUnit', arguments);
	  if (adUnitCode) {
	    for (var i = 0; i < pbjs.adUnits.length; i++) {
	      if (pbjs.adUnits[i].code === adUnitCode) {
	        pbjs.adUnits.splice(i, 1);
	      }
	    }
	  }
	};
	
	pbjs.clearAuction = function () {
	  auctionRunning = false;
	  utils.logMessage('Prebid auction cleared');
	  events.emit(AUCTION_END);
	  if (bidRequestQueue.length) {
	    bidRequestQueue.shift()();
	  }
	};
	
	/**
	 *
	 * @param bidsBackHandler
	 * @param timeout
	 * @param adUnits
	 * @param adUnitCodes
	 */
	pbjs.requestBids = function (_ref15) {
	  var bidsBackHandler = _ref15.bidsBackHandler;
	  var timeout = _ref15.timeout;
	  var adUnits = _ref15.adUnits;
	  var adUnitCodes = _ref15.adUnitCodes;
	
	  var cbTimeout = timeout || pbjs.bidderTimeout;
	  adUnits = adUnits || pbjs.adUnits;
	
	  // if specific adUnitCodes filter adUnits for those codes
	  if (adUnitCodes && adUnitCodes.length) {
	    adUnits = adUnits.filter(function (adUnit) {
	      return adUnitCodes.includes(adUnit.code);
	    });
	  }
	
	  if (auctionRunning) {
	    bidRequestQueue.push(function () {
	      pbjs.requestBids({ bidsBackHandler: bidsBackHandler, cbTimeout: cbTimeout, adUnits: adUnits });
	    });
	    return;
	  } else {
	    auctionRunning = true;
	    removeComplete();
	  }
	
	  if ((typeof bidsBackHandler === 'undefined' ? 'undefined' : _typeof(bidsBackHandler)) === objectType_function) {
	    bidmanager.addOneTimeCallback(bidsBackHandler);
	  }
	
	  utils.logInfo('Invoking pbjs.requestBids', arguments);
	
	  if (!adUnits || adUnits.length === 0) {
	    utils.logMessage('No adUnits configured. No bids requested.');
	    bidmanager.executeCallback();
	    return;
	  }
	
	  //set timeout for all bids
	  var timedOut = true;
	  var timeoutCallback = bidmanager.executeCallback.bind(bidmanager, timedOut);
	  setTimeout(timeoutCallback, cbTimeout);
	
	  adaptermanager.callBids({ adUnits: adUnits, adUnitCodes: adUnitCodes, cbTimeout: cbTimeout });
	};
	
	/**
	 *
	 * Add adunit(s)
	 * @param {Array|String} adUnitArr Array of adUnits or single adUnit Object.
	 * @alias module:pbjs.addAdUnits
	 */
	pbjs.addAdUnits = function (adUnitArr) {
	  utils.logInfo('Invoking pbjs.addAdUnits', arguments);
	  if (utils.isArray(adUnitArr)) {
	    //append array to existing
	    pbjs.adUnits.push.apply(pbjs.adUnits, adUnitArr);
	  } else if ((typeof adUnitArr === 'undefined' ? 'undefined' : _typeof(adUnitArr)) === objectType_object) {
	    pbjs.adUnits.push(adUnitArr);
	  }
	};
	
	/**
	 * @param {String} event the name of the event
	 * @param {Function} handler a callback to set on event
	 * @param {String} id an identifier in the context of the event
	 *
	 * This API call allows you to register a callback to handle a Prebid.js event.
	 * An optional `id` parameter provides more finely-grained event callback registration.
	 * This makes it possible to register callback events for a specific item in the
	 * event context. For example, `bidWon` events will accept an `id` for ad unit code.
	 * `bidWon` callbacks registered with an ad unit code id will be called when a bid
	 * for that ad unit code wins the auction. Without an `id` this method registers the
	 * callback for every `bidWon` event.
	 *
	 * Currently `bidWon` is the only event that accepts an `id` parameter.
	 */
	pbjs.onEvent = function (event, handler, id) {
	  utils.logInfo('Invoking pbjs.onEvent', arguments);
	  if (!utils.isFn(handler)) {
	    utils.logError('The event handler provided is not a function and was not set on event "' + event + '".');
	    return;
	  }
	
	  if (id && !eventValidators[event].call(null, id)) {
	    utils.logError('The id provided is not valid for event "' + event + '" and no handler was set.');
	    return;
	  }
	
	  events.on(event, handler, id);
	};
	
	/**
	 * @param {String} event the name of the event
	 * @param {Function} handler a callback to remove from the event
	 * @param {String} id an identifier in the context of the event (see `pbjs.onEvent`)
	 */
	pbjs.offEvent = function (event, handler, id) {
	  utils.logInfo('Invoking pbjs.offEvent', arguments);
	  if (id && !eventValidators[event].call(null, id)) {
	    return;
	  }
	
	  events.off(event, handler, id);
	};
	
	/**
	 * Add a callback event
	 * @param {String} eventStr event to attach callback to Options: "allRequestedBidsBack" | "adUnitBidsBack"
	 * @param {Function} func  function to execute. Paramaters passed into the function: (bidResObj), [adUnitCode]);
	 * @alias module:pbjs.addCallback
	 * @returns {String} id for callback
	 */
	pbjs.addCallback = function (eventStr, func) {
	  utils.logInfo('Invoking pbjs.addCallback', arguments);
	  var id = null;
	  if (!eventStr || !func || (typeof func === 'undefined' ? 'undefined' : _typeof(func)) !== objectType_function) {
	    utils.logError('error registering callback. Check method signature');
	    return id;
	  }
	
	  id = utils.getUniqueIdentifierStr;
	  bidmanager.addCallback(id, func, eventStr);
	  return id;
	};
	
	/**
	 * Remove a callback event
	 * //@param {string} cbId id of the callback to remove
	 * @alias module:pbjs.removeCallback
	 * @returns {String} id for callback
	 */
	pbjs.removeCallback = function () /* cbId */{
	  //todo
	  return null;
	};
	
	/**
	 * Wrapper to register bidderAdapter externally (adaptermanager.registerBidAdapter())
	 * @param  {[type]} bidderAdaptor [description]
	 * @param  {[type]} bidderCode    [description]
	 * @return {[type]}               [description]
	 */
	pbjs.registerBidAdapter = function (bidderAdaptor, bidderCode) {
	  utils.logInfo('Invoking pbjs.registerBidAdapter', arguments);
	  try {
	    adaptermanager.registerBidAdapter(bidderAdaptor(), bidderCode);
	  } catch (e) {
	    utils.logError('Error registering bidder adapter : ' + e.message);
	  }
	};
	
	/**
	 * Wrapper to register analyticsAdapter externally (adaptermanager.registerAnalyticsAdapter())
	 * @param  {[type]} options [description]
	 */
	pbjs.registerAnalyticsAdapter = function (options) {
	  utils.logInfo('Invoking pbjs.registerAnalyticsAdapter', arguments);
	  try {
	    adaptermanager.registerAnalyticsAdapter(options);
	  } catch (e) {
	    utils.logError('Error registering analytics adapter : ' + e.message);
	  }
	};
	
	pbjs.bidsAvailableForAdapter = function (bidderCode) {
	  utils.logInfo('Invoking pbjs.bidsAvailableForAdapter', arguments);
	
	  pbjs._bidsRequested.find(function (bidderRequest) {
	    return bidderRequest.bidderCode === bidderCode;
	  }).bids.map(function (bid) {
	    return _extends(bid, bidfactory.createBid(1), {
	      bidderCode: bidderCode,
	      adUnitCode: bid.placementCode
	    });
	  }).map(function (bid) {
	    return pbjs._bidsReceived.push(bid);
	  });
	};
	
	/**
	 * Wrapper to bidfactory.createBid()
	 * @param  {[type]} statusCode [description]
	 * @return {[type]}            [description]
	 */
	pbjs.createBid = function (statusCode) {
	  utils.logInfo('Invoking pbjs.createBid', arguments);
	  return bidfactory.createBid(statusCode);
	};
	
	/**
	 * Wrapper to bidmanager.addBidResponse
	 * @param {[type]} adUnitCode [description]
	 * @param {[type]} bid        [description]
	 */
	pbjs.addBidResponse = function (adUnitCode, bid) {
	  utils.logInfo('Invoking pbjs.addBidResponse', arguments);
	  bidmanager.addBidResponse(adUnitCode, bid);
	};
	
	/**
	 * Wrapper to adloader.loadScript
	 * @param  {[type]}   tagSrc   [description]
	 * @param  {Function} callback [description]
	 * @return {[type]}            [description]
	 */
	pbjs.loadScript = function (tagSrc, callback, useCache) {
	  utils.logInfo('Invoking pbjs.loadScript', arguments);
	  adloader.loadScript(tagSrc, callback, useCache);
	};
	
	/**
	 * Will enable sendinga prebid.js to data provider specified
	 * @param  {object} config object {provider : 'string', options : {}}
	 */
	pbjs.enableAnalytics = function (config) {
	  if (config && !utils.isEmpty(config)) {
	    utils.logInfo('Invoking pbjs.enableAnalytics for: ', config);
	    adaptermanager.enableAnalytics(config);
	  } else {
	    utils.logError('pbjs.enableAnalytics should be called with option {}');
	  }
	};
	
	pbjs.aliasBidder = function (bidderCode, alias) {
	  utils.logInfo('Invoking pbjs.aliasBidder', arguments);
	  if (bidderCode && alias) {
	    adaptermanager.aliasBidAdapter(bidderCode, alias);
	  } else {
	    utils.logError('bidderCode and alias must be passed as arguments', 'pbjs.aliasBidder');
	  }
	};
	
	pbjs.setPriceGranularity = function (granularity) {
	  utils.logInfo('Invoking pbjs.setPriceGranularity', arguments);
	  if (!granularity) {
	    utils.logError('Prebid Error: no value passed to `setPriceGranularity()`');
	  } else {
	    bidmanager.setPriceGranularity(granularity);
	  }
	};
	
	pbjs.enableSendAllBids = function () {
	  pbjs._sendAllBids = true;
	};
	
	pbjs.getAllWinningBids = function () {
	  return pbjs._winningBids;
	};
	
	processQue();

/***/ },
/* 1 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol ? "symbol" : typeof obj; };
	
	exports.uniques = uniques;
	exports.flatten = flatten;
	exports.getBidRequest = getBidRequest;
	exports.getKeys = getKeys;
	exports.getValue = getValue;
	exports.getBidderCodes = getBidderCodes;
	exports.isGptPubadsDefined = isGptPubadsDefined;
	exports.getHighestCpm = getHighestCpm;
	var CONSTANTS = __webpack_require__(2);
	
	var objectType_object = 'object';
	var objectType_string = 'string';
	var objectType_number = 'number';
	
	var _loggingChecked = false;
	
	var t_Arr = 'Array';
	var t_Str = 'String';
	var t_Fn = 'Function';
	var t_Numb = 'Number';
	var toString = Object.prototype.toString;
	var infoLogger = null;
	try {
	  infoLogger = console.info.bind(window.console);
	} catch (e) {}
	
	/*
	 *   Substitutes into a string from a given map using the token
	 *   Usage
	 *   var str = 'text %%REPLACE%% this text with %%SOMETHING%%';
	 *   var map = {};
	 *   map['replace'] = 'it was subbed';
	 *   map['something'] = 'something else';
	 *   console.log(replaceTokenInString(str, map, '%%')); => "text it was subbed this text with something else"
	 */
	exports.replaceTokenInString = function (str, map, token) {
	  this._each(map, function (value, key) {
	    value = value === undefined ? '' : value;
	
	    var keyString = token + key.toUpperCase() + token;
	    var re = new RegExp(keyString, 'g');
	
	    str = str.replace(re, value);
	  });
	
	  return str;
	};
	
	/* utility method to get incremental integer starting from 1 */
	var getIncrementalInteger = function () {
	  var count = 0;
	  return function () {
	    count++;
	    return count;
	  };
	}();
	
	function _getUniqueIdentifierStr() {
	  return getIncrementalInteger() + Math.random().toString(16).substr(2);
	}
	
	//generate a random string (to be used as a dynamic JSONP callback)
	exports.getUniqueIdentifierStr = _getUniqueIdentifierStr;
	
	/**
	 * Returns a random v4 UUID of the form xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx,
	 * where each x is replaced with a random hexadecimal digit from 0 to f,
	 * and y is replaced with a random hexadecimal digit from 8 to b.
	 * https://gist.github.com/jed/982883 via node-uuid
	 */
	exports.generateUUID = function generateUUID(placeholder) {
	  return placeholder ? (placeholder ^ Math.random() * 16 >> placeholder / 4).toString(16) : ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, generateUUID);
	};
	
	exports.getBidIdParamater = function (key, paramsObj) {
	  if (paramsObj && paramsObj[key]) {
	    return paramsObj[key];
	  }
	
	  return '';
	};
	
	exports.tryAppendQueryString = function (existingUrl, key, value) {
	  if (value) {
	    return existingUrl += key + '=' + encodeURIComponent(value) + '&';
	  }
	
	  return existingUrl;
	};
	
	//parse a query string object passed in bid params
	//bid params should be an object such as {key: "value", key1 : "value1"}
	exports.parseQueryStringParameters = function (queryObj) {
	  var result = '';
	  for (var k in queryObj) {
	    if (queryObj.hasOwnProperty(k)) result += k + '=' + encodeURIComponent(queryObj[k]) + '&';
	  }
	
	  return result;
	};
	
	//transform an AdServer targeting bids into a query string to send to the adserver
	exports.transformAdServerTargetingObj = function (targeting) {
	  // we expect to receive targeting for a single slot at a time
	  if (targeting && Object.getOwnPropertyNames(targeting).length > 0) {
	
	    return getKeys(targeting).map(function (key) {
	      return key + '=' + encodeURIComponent(getValue(targeting, key));
	    }).join('&');
	  } else {
	    return '';
	  }
	};
	
	//Copy all of the properties in the source objects over to the target object
	//return the target object.
	exports.extend = function (target, source) {
	  target = target || {};
	
	  this._each(source, function (value, prop) {
	    if (_typeof(source[prop]) === objectType_object) {
	      target[prop] = this.extend(target[prop], source[prop]);
	    } else {
	      target[prop] = source[prop];
	    }
	  });
	
	  return target;
	};
	
	/**
	 * Parse a GPT-Style general size Array like `[[300, 250]]` or `"300x250,970x90"` into an array of sizes `["300x250"]` or '['300x250', '970x90']'
	 * @param  {array[array|number]} sizeObj Input array or double array [300,250] or [[300,250], [728,90]]
	 * @return {array[string]}  Array of strings like `["300x250"]` or `["300x250", "728x90"]`
	 */
	exports.parseSizesInput = function (sizeObj) {
	  var parsedSizes = [];
	
	  //if a string for now we can assume it is a single size, like "300x250"
	  if ((typeof sizeObj === 'undefined' ? 'undefined' : _typeof(sizeObj)) === objectType_string) {
	    //multiple sizes will be comma-separated
	    var sizes = sizeObj.split(',');
	
	    //regular expression to match strigns like 300x250
	    //start of line, at least 1 number, an "x" , then at least 1 number, and the then end of the line
	    var sizeRegex = /^(\d)+x(\d)+$/i;
	    if (sizes) {
	      for (var curSizePos in sizes) {
	        if (hasOwn(sizes, curSizePos) && sizes[curSizePos].match(sizeRegex)) {
	          parsedSizes.push(sizes[curSizePos]);
	        }
	      }
	    }
	  } else if ((typeof sizeObj === 'undefined' ? 'undefined' : _typeof(sizeObj)) === objectType_object) {
	    var sizeArrayLength = sizeObj.length;
	
	    //don't process empty array
	    if (sizeArrayLength > 0) {
	      //if we are a 2 item array of 2 numbers, we must be a SingleSize array
	      if (sizeArrayLength === 2 && _typeof(sizeObj[0]) === objectType_number && _typeof(sizeObj[1]) === objectType_number) {
	        parsedSizes.push(this.parseGPTSingleSizeArray(sizeObj));
	      } else {
	        //otherwise, we must be a MultiSize array
	        for (var i = 0; i < sizeArrayLength; i++) {
	          parsedSizes.push(this.parseGPTSingleSizeArray(sizeObj[i]));
	        }
	      }
	    }
	  }
	
	  return parsedSizes;
	};
	
	//parse a GPT style sigle size array, (i.e [300,250])
	//into an AppNexus style string, (i.e. 300x250)
	exports.parseGPTSingleSizeArray = function (singleSize) {
	  //if we aren't exactly 2 items in this array, it is invalid
	  if (this.isArray(singleSize) && singleSize.length === 2 && !isNaN(singleSize[0]) && !isNaN(singleSize[1])) {
	    return singleSize[0] + 'x' + singleSize[1];
	  }
	};
	
	exports.getTopWindowUrl = function () {
	  try {
	    return window.top.location.href;
	  } catch (e) {
	    return window.location.href;
	  }
	};
	
	exports.logWarn = function (msg) {
	  if (debugTurnedOn() && console.warn) {
	    console.warn('WARNING: ' + msg);
	  }
	};
	
	exports.logInfo = function (msg, args) {
	  if (debugTurnedOn() && hasConsoleLogger()) {
	    if (infoLogger) {
	      if (!args || args.length === 0) {
	        args = '';
	      }
	
	      infoLogger('INFO: ' + msg + (args === '' ? '' : ' : params : '), args);
	    }
	  }
	};
	
	exports.logMessage = function (msg) {
	  if (debugTurnedOn() && hasConsoleLogger()) {
	    console.log('MESSAGE: ' + msg);
	  }
	};
	
	function hasConsoleLogger() {
	  return window.console && window.console.log;
	}
	
	exports.hasConsoleLogger = hasConsoleLogger;
	
	var errLogFn = function (hasLogger) {
	  if (!hasLogger) return '';
	  return window.console.error ? 'error' : 'log';
	}(hasConsoleLogger());
	
	var debugTurnedOn = function debugTurnedOn() {
	  if (pbjs.logging === false && _loggingChecked === false) {
	    pbjs.logging = getParameterByName(CONSTANTS.DEBUG_MODE).toUpperCase() === 'TRUE';
	    _loggingChecked = true;
	  }
	
	  return !!pbjs.logging;
	};
	
	exports.debugTurnedOn = debugTurnedOn;
	
	exports.logError = function (msg, code, exception) {
	  var errCode = code || 'ERROR';
	  if (debugTurnedOn() && hasConsoleLogger()) {
	    console[errLogFn](console, errCode + ': ' + msg, exception || '');
	  }
	};
	
	exports.createInvisibleIframe = function _createInvisibleIframe() {
	  var f = document.createElement('iframe');
	  f.id = _getUniqueIdentifierStr();
	  f.height = 0;
	  f.width = 0;
	  f.border = '0px';
	  f.hspace = '0';
	  f.vspace = '0';
	  f.marginWidth = '0';
	  f.marginHeight = '0';
	  f.style.border = '0';
	  f.scrolling = 'no';
	  f.frameBorder = '0';
	  f.src = 'about:blank';
	  f.style.display = 'none';
	  return f;
	};
	
	/*
	 *   Check if a given parameter name exists in query string
	 *   and if it does return the value
	 */
	var getParameterByName = function getParameterByName(name) {
	  var regexS = '[\\?&]' + name + '=([^&#]*)';
	  var regex = new RegExp(regexS);
	  var results = regex.exec(window.location.search);
	  if (results === null) {
	    return '';
	  }
	
	  return decodeURIComponent(results[1].replace(/\+/g, ' '));
	};
	
	/**
	 * This function validates paramaters.
	 * @param  {object[string]} paramObj          [description]
	 * @param  {string[]} requiredParamsArr [description]
	 * @return {bool}                   Bool if paramaters are valid
	 */
	exports.hasValidBidRequest = function (paramObj, requiredParamsArr, adapter) {
	  var found = false;
	
	  function findParam(value, key) {
	    if (key === requiredParamsArr[i]) {
	      found = true;
	    }
	  }
	
	  for (var i = 0; i < requiredParamsArr.length; i++) {
	    found = false;
	
	    this._each(paramObj, findParam);
	
	    if (!found) {
	      this.logError('Params are missing for bid request. One of these required paramaters are missing: ' + requiredParamsArr, adapter);
	      return false;
	    }
	  }
	
	  return true;
	};
	
	// Handle addEventListener gracefully in older browsers
	exports.addEventHandler = function (element, event, func) {
	  if (element.addEventListener) {
	    element.addEventListener(event, func, true);
	  } else if (element.attachEvent) {
	    element.attachEvent('on' + event, func);
	  }
	};
	/**
	 * Return if the object is of the
	 * given type.
	 * @param {*} object to test
	 * @param {String} _t type string (e.g., Array)
	 * @return {Boolean} if object is of type _t
	 */
	exports.isA = function (object, _t) {
	  return toString.call(object) === '[object ' + _t + ']';
	};
	
	exports.isFn = function (object) {
	  return this.isA(object, t_Fn);
	};
	
	exports.isStr = function (object) {
	  return this.isA(object, t_Str);
	};
	
	exports.isArray = function (object) {
	  return this.isA(object, t_Arr);
	};
	
	exports.isNumber = function (object) {
	  return this.isA(object, t_Numb);
	};
	
	/**
	 * Return if the object is "empty";
	 * this includes falsey, no keys, or no items at indices
	 * @param {*} object object to test
	 * @return {Boolean} if object is empty
	 */
	exports.isEmpty = function (object) {
	  if (!object) return true;
	  if (this.isArray(object) || this.isStr(object)) {
	    return !(object.length > 0); // jshint ignore:line
	  }
	
	  for (var k in object) {
	    if (hasOwnProperty.call(object, k)) return false;
	  }
	
	  return true;
	};
	
	/**
	 * Return if string is empty, null, or undefined
	 * @param str string to test
	 * @returns {boolean} if string is empty
	 */
	exports.isEmptyStr = function (str) {
	  return this.isStr(str) && (!str || 0 === str.length);
	};
	
	/**
	 * Iterate object with the function
	 * falls back to es5 `forEach`
	 * @param {Array|Object} object
	 * @param {Function(value, key, object)} fn
	 */
	exports._each = function (object, fn) {
	  if (this.isEmpty(object)) return;
	  if (this.isFn(object.forEach)) return object.forEach(fn, this);
	
	  var k = 0;
	  var l = object.length;
	
	  if (l > 0) {
	    for (; k < l; k++) {
	      fn(object[k], k, object);
	    }
	  } else {
	    for (k in object) {
	      if (hasOwnProperty.call(object, k)) fn.call(this, object[k], k);
	    }
	  }
	};
	
	exports.contains = function (a, obj) {
	  if (this.isEmpty(a)) {
	    return false;
	  }
	
	  if (this.isFn(a.indexOf)) {
	    return a.indexOf(obj) !== -1;
	  }
	
	  var i = a.length;
	  while (i--) {
	    if (a[i] === obj) {
	      return true;
	    }
	  }
	
	  return false;
	};
	
	exports.indexOf = function () {
	  if (Array.prototype.indexOf) {
	    return Array.prototype.indexOf;
	  }
	
	  // ie8 no longer supported
	  //return polyfills.indexOf;
	}();
	
	/**
	 * Map an array or object into another array
	 * given a function
	 * @param {Array|Object} object
	 * @param {Function(value, key, object)} callback
	 * @return {Array}
	 */
	exports._map = function (object, callback) {
	  if (this.isEmpty(object)) return [];
	  if (this.isFn(object.map)) return object.map(callback);
	  var output = [];
	  this._each(object, function (value, key) {
	    output.push(callback(value, key, object));
	  });
	
	  return output;
	};
	
	var hasOwn = function hasOwn(objectToCheck, propertyToCheckFor) {
	  if (objectToCheck.hasOwnProperty) {
	    return objectToCheck.hasOwnProperty(propertyToCheckFor);
	  } else {
	    return typeof objectToCheck[propertyToCheckFor] !== 'undefined' && objectToCheck.constructor.prototype[propertyToCheckFor] !== objectToCheck[propertyToCheckFor];
	  }
	};
	/**
	 * Creates a snippet of HTML that retrieves the specified `url`
	 * @param  {string} url URL to be requested
	 * @return {string}     HTML snippet that contains the img src = set to `url`
	 */
	exports.createTrackPixelHtml = function (url) {
	  if (!url) {
	    return '';
	  }
	
	  var escapedUrl = encodeURI(url);
	  var img = '<div style="position:absolute;left:0px;top:0px;visibility:hidden;">';
	  img += '<img src="' + escapedUrl + '"></div>';
	  return img;
	};
	
	/**
	 * Returns iframe document in a browser agnostic way
	 * @param  {object} iframe reference
	 * @return {object}        iframe `document` reference
	 */
	exports.getIframeDocument = function (iframe) {
	  if (!iframe) {
	    return;
	  }
	
	  var doc = void 0;
	  try {
	    if (iframe.contentWindow) {
	      doc = iframe.contentWindow.document;
	    } else if (iframe.contentDocument.document) {
	      doc = iframe.contentDocument.document;
	    } else {
	      doc = iframe.contentDocument;
	    }
	  } catch (e) {
	    this.logError('Cannot get iframe document', e);
	  }
	
	  return doc;
	};
	
	exports.getValueString = function (param, val, defaultValue) {
	  if (val === undefined || val === null) {
	    return defaultValue;
	  }
	  if (this.isStr(val)) {
	    return val;
	  }
	  if (this.isNumber(val)) {
	    return val.toString();
	  }
	  this.logWarn('Unsuported type for param: ' + param + ' required type: String');
	};
	
	function uniques(value, index, arry) {
	  return arry.indexOf(value) === index;
	}
	
	function flatten(a, b) {
	  return a.concat(b);
	}
	
	function getBidRequest(id) {
	  return pbjs._bidsRequested.map(function (bidSet) {
	    return bidSet.bids.find(function (bid) {
	      return bid.bidId === id;
	    });
	  }).find(function (bid) {
	    return bid;
	  });
	}
	
	function getKeys(obj) {
	  return Object.keys(obj);
	}
	
	function getValue(obj, key) {
	  return obj[key];
	}
	
	function getBidderCodes() {
	  var adUnits = arguments.length <= 0 || arguments[0] === undefined ? pbjs.adUnits : arguments[0];
	
	  // this could memoize adUnits
	  return adUnits.map(function (unit) {
	    return unit.bids.map(function (bid) {
	      return bid.bidder;
	    }).reduce(flatten, []);
	  }).reduce(flatten).filter(uniques);
	}
	
	function isGptPubadsDefined() {
	  if (window.googletag && exports.isFn(window.googletag.pubads) && exports.isFn(window.googletag.pubads().getSlots)) {
	    return true;
	  }
	}
	
	function getHighestCpm(previous, current) {
	  if (previous.cpm === current.cpm) {
	    return previous.timeToRespond > current.timeToRespond ? current : previous;
	  }
	  return previous.cpm < current.cpm ? current : previous;
	}

/***/ },
/* 2 */
/***/ function(module, exports) {

	module.exports = {
		"JSON_MAPPING": {
			"PL_CODE": "code",
			"PL_SIZE": "sizes",
			"PL_BIDS": "bids",
			"BD_BIDDER": "bidder",
			"BD_ID": "paramsd",
			"BD_PL_ID": "placementId",
			"ADSERVER_TARGETING": "adserverTargeting",
			"BD_SETTING_STANDARD": "standard"
		},
		"REPO_AND_VERSION": "prebid_prebid_0.12.0",
		"DEBUG_MODE": "pbjs_debug",
		"STATUS": {
			"GOOD": 1,
			"NO_BID": 2
		},
		"CB": {
			"TYPE": {
				"ALL_BIDS_BACK": "allRequestedBidsBack",
				"AD_UNIT_BIDS_BACK": "adUnitBidsBack",
				"BID_WON": "bidWon"
			}
		},
		"objectType_function": "function",
		"objectType_undefined": "undefined",
		"objectType_object": "object",
		"objectType_string": "string",
		"objectType_number": "number",
		"EVENTS": {
			"AUCTION_INIT": "auctionInit",
			"AUCTION_END": "auctionEnd",
			"BID_ADJUSTMENT": "bidAdjustment",
			"BID_TIMEOUT": "bidTimeout",
			"BID_REQUESTED": "bidRequested",
			"BID_RESPONSE": "bidResponse",
			"BID_WON": "bidWon"
		},
		"EVENT_ID_PATHS": {
			"bidWon": "adUnitCode"
		},
		"GRANULARITY_OPTIONS": {
			"LOW": "low",
			"MEDIUM": "medium",
			"HIGH": "high",
			"AUTO": "auto",
			"DENSE": "dense"
		},
		"TARGETING_KEYS": [
			"hb_bidder",
			"hb_adid",
			"hb_pb",
			"hb_size"
		]
	};

/***/ },
/* 3 */
/***/ function(module, exports) {

	'use strict';
	
	/** @module polyfill
	Misc polyfills
	*/
	/*jshint -W121 */
	if (!Array.prototype.find) {
	  Object.defineProperty(Array.prototype, "find", {
	    value: function value(predicate) {
	      if (this === null) {
	        throw new TypeError('Array.prototype.find called on null or undefined');
	      }
	      if (typeof predicate !== 'function') {
	        throw new TypeError('predicate must be a function');
	      }
	      var list = Object(this);
	      var length = list.length >>> 0;
	      var thisArg = arguments[1];
	      var value;
	
	      for (var i = 0; i < length; i++) {
	        value = list[i];
	        if (predicate.call(thisArg, value, i, list)) {
	          return value;
	        }
	      }
	      return undefined;
	    }
	  });
	}
	
	if (!Array.prototype.includes) {
	  Object.defineProperty(Array.prototype, "includes", {
	    value: function value(searchElement) {
	      var O = Object(this);
	      var len = parseInt(O.length, 10) || 0;
	      if (len === 0) {
	        return false;
	      }
	      var n = parseInt(arguments[1], 10) || 0;
	      var k;
	      if (n >= 0) {
	        k = n;
	      } else {
	        k = len + n;
	        if (k < 0) {
	          k = 0;
	        }
	      }
	      var currentElement;
	      while (k < len) {
	        currentElement = O[k];
	        if (searchElement === currentElement || searchElement !== searchElement && currentElement !== currentElement) {
	          // NaN !== NaN
	          return true;
	        }
	        k++;
	      }
	      return false;
	    }
	  });
	}

/***/ },
/* 4 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol ? "symbol" : typeof obj; };
	
	var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };
	
	var _utils = __webpack_require__(1);
	
	var CONSTANTS = __webpack_require__(2);
	var utils = __webpack_require__(1);
	var events = __webpack_require__(5);
	
	var objectType_function = 'function';
	
	var externalCallbackByAdUnitArr = [];
	var externalCallbackArr = [];
	var externalOneTimeCallback = null;
	var _granularity = CONSTANTS.GRANULARITY_OPTIONS.MEDIUM;
	var defaultBidderSettingsMap = {};
	
	var _lgPriceCap = 5.00;
	var _mgPriceCap = 20.00;
	var _hgPriceCap = 20.00;
	
	/**
	 * Returns a list of bidders that we haven't received a response yet
	 * @return {array} [description]
	 */
	exports.getTimedOutBidders = function () {
	  return pbjs._bidsRequested.map(getBidderCode).filter(_utils.uniques).filter(function (bidder) {
	    return pbjs._bidsReceived.map(getBidders).filter(_utils.uniques).indexOf(bidder) < 0;
	  });
	};
	
	function timestamp() {
	  return new Date().getTime();
	}
	
	function getBidderCode(bidSet) {
	  return bidSet.bidderCode;
	}
	
	function getBidders(bid) {
	  return bid.bidder;
	}
	
	function bidsBackAdUnit(adUnitCode) {
	  var requested = pbjs.adUnits.find(function (unit) {
	    return unit.code === adUnitCode;
	  }).bids.length;
	  var received = pbjs._bidsReceived.filter(function (bid) {
	    return bid.adUnitCode === adUnitCode;
	  }).length;
	  return requested === received;
	}
	
	function add(a, b) {
	  return a + b;
	}
	
	function bidsBackAll() {
	  var requested = pbjs._bidsRequested.map(function (bidSet) {
	    return bidSet.bids.length;
	  }).reduce(add);
	  var received = pbjs._bidsReceived.length;
	  return requested === received;
	}
	
	exports.bidsBackAll = function () {
	  return bidsBackAll();
	};
	
	function getBidSetForBidder(bidder) {
	  return pbjs._bidsRequested.find(function (bidSet) {
	    return bidSet.bidderCode === bidder;
	  }) || { start: null, requestId: null };
	}
	
	/*
	 *   This function should be called to by the bidder adapter to register a bid response
	 */
	exports.addBidResponse = function (adUnitCode, bid) {
	  if (bid) {
	
	    _extends(bid, {
	      requestId: getBidSetForBidder(bid.bidderCode).requestId,
	      responseTimestamp: timestamp(),
	      requestTimestamp: getBidSetForBidder(bid.bidderCode).start,
	      cpm: bid.cpm || 0,
	      bidder: bid.bidderCode,
	      adUnitCode: adUnitCode
	    });
	
	    bid.timeToRespond = bid.responseTimestamp - bid.requestTimestamp;
	
	    if (bid.timeToRespond > pbjs.bidderTimeout) {
	      var timedOut = true;
	
	      this.executeCallback(timedOut);
	    }
	
	    //emit the bidAdjustment event before bidResponse, so bid response has the adjusted bid value
	    events.emit(CONSTANTS.EVENTS.BID_ADJUSTMENT, bid);
	
	    //emit the bidResponse event
	    events.emit(CONSTANTS.EVENTS.BID_RESPONSE, bid);
	
	    //append price strings
	    var priceStringsObj = getPriceBucketString(bid.cpm, bid.height, bid.width);
	    bid.pbLg = priceStringsObj.low;
	    bid.pbMg = priceStringsObj.med;
	    bid.pbHg = priceStringsObj.high;
	    bid.pbAg = priceStringsObj.auto;
	    bid.pbDg = priceStringsObj.dense;
	
	    //if there is any key value pairs to map do here
	    var keyValues = {};
	    if (bid.bidderCode && bid.cpm !== 0) {
	      keyValues = getKeyValueTargetingPairs(bid.bidderCode, bid);
	
	      if (bid.dealId) {
	        keyValues['hb_deal_' + bid.bidderCode] = bid.dealId;
	      }
	
	      bid.adserverTargeting = keyValues;
	    }
	
	    pbjs._bidsReceived.push(bid);
	  }
	
	  if (bid && bid.adUnitCode && bidsBackAdUnit(bid.adUnitCode)) {
	    triggerAdUnitCallbacks(bid.adUnitCode);
	  }
	
	  if (bidsBackAll()) {
	    this.executeCallback();
	  }
	};
	
	function getKeyValueTargetingPairs(bidderCode, custBidObj) {
	  var keyValues = {};
	  var bidder_settings = pbjs.bidderSettings || {};
	
	  //1) set the keys from "standard" setting or from prebid defaults
	  if (custBidObj && bidder_settings) {
	    if (!bidder_settings[CONSTANTS.JSON_MAPPING.BD_SETTING_STANDARD]) {
	      bidder_settings[CONSTANTS.JSON_MAPPING.BD_SETTING_STANDARD] = {
	        adserverTargeting: [{
	          key: 'hb_bidder',
	          val: function val(bidResponse) {
	            return bidResponse.bidderCode;
	          }
	        }, {
	          key: 'hb_adid',
	          val: function val(bidResponse) {
	            return bidResponse.adId;
	          }
	        }, {
	          key: 'hb_pb',
	          val: function val(bidResponse) {
	            if (_granularity === CONSTANTS.GRANULARITY_OPTIONS.AUTO) {
	              return bidResponse.pbAg;
	            } else if (_granularity === CONSTANTS.GRANULARITY_OPTIONS.DENSE) {
	              return bidResponse.pbDg;
	            } else if (_granularity === CONSTANTS.GRANULARITY_OPTIONS.LOW) {
	              return bidResponse.pbLg;
	            } else if (_granularity === CONSTANTS.GRANULARITY_OPTIONS.MEDIUM) {
	              return bidResponse.pbMg;
	            } else if (_granularity === CONSTANTS.GRANULARITY_OPTIONS.HIGH) {
	              return bidResponse.pbHg;
	            }
	          }
	        }, {
	          key: 'hb_size',
	          val: function val(bidResponse) {
	            return bidResponse.size;
	          }
	        }]
	      };
	    }
	
	    setKeys(keyValues, bidder_settings[CONSTANTS.JSON_MAPPING.BD_SETTING_STANDARD], custBidObj);
	  }
	
	  //2) set keys from specific bidder setting override if they exist
	  if (bidderCode && custBidObj && bidder_settings && bidder_settings[bidderCode] && bidder_settings[bidderCode][CONSTANTS.JSON_MAPPING.ADSERVER_TARGETING]) {
	    setKeys(keyValues, bidder_settings[bidderCode], custBidObj);
	    custBidObj.alwaysUseBid = bidder_settings[bidderCode].alwaysUseBid;
	    filterIfSendStandardTargeting(bidder_settings[bidderCode]);
	  }
	
	  //2) set keys from standard setting. NOTE: this API doesn't seem to be in use by any Adapter
	  else if (defaultBidderSettingsMap[bidderCode]) {
	      setKeys(keyValues, defaultBidderSettingsMap[bidderCode], custBidObj);
	      custBidObj.alwaysUseBid = defaultBidderSettingsMap[bidderCode].alwaysUseBid;
	      filterIfSendStandardTargeting(defaultBidderSettingsMap[bidderCode]);
	    }
	
	  function filterIfSendStandardTargeting(bidderSettings) {
	    if (typeof bidderSettings.sendStandardTargeting !== "undefined" && bidder_settings[bidderCode].sendStandardTargeting === false) {
	      for (var key in keyValues) {
	        if (CONSTANTS.TARGETING_KEYS.indexOf(key) !== -1) {
	          delete keyValues[key];
	        }
	      }
	    }
	  }
	
	  return keyValues;
	}
	
	exports.getKeyValueTargetingPairs = function () {
	  return getKeyValueTargetingPairs.apply(undefined, arguments);
	};
	
	function setKeys(keyValues, bidderSettings, custBidObj) {
	  var targeting = bidderSettings[CONSTANTS.JSON_MAPPING.ADSERVER_TARGETING];
	  custBidObj.size = custBidObj.getSize();
	
	  utils._each(targeting, function (kvPair) {
	    var key = kvPair.key;
	    var value = kvPair.val;
	
	    if (keyValues[key]) {
	      utils.logWarn('The key: ' + key + ' is getting ovewritten');
	    }
	
	    if (utils.isFn(value)) {
	      try {
	        value = value(custBidObj);
	      } catch (e) {
	        utils.logError('bidmanager', 'ERROR', e);
	      }
	    }
	
	    if (typeof bidderSettings.suppressEmptyKeys !== "undefined" && bidderSettings.suppressEmptyKeys === true && (utils.isEmptyStr(value) || value === null || value === undefined)) {
	      utils.logInfo("suppressing empty key '" + key + "' from adserver targeting");
	    } else {
	      keyValues[key] = value;
	    }
	  });
	
	  return keyValues;
	}
	
	exports.setPriceGranularity = function setPriceGranularity(granularity) {
	  var granularityOptions = CONSTANTS.GRANULARITY_OPTIONS;
	  if (Object.keys(granularityOptions).filter(function (option) {
	    return granularity === granularityOptions[option];
	  })) {
	    _granularity = granularity;
	  } else {
	    utils.logWarn('Prebid Warning: setPriceGranularity was called with invalid setting, using' + ' `medium` as default.');
	    _granularity = CONSTANTS.GRANULARITY_OPTIONS.MEDIUM;
	  }
	};
	
	exports.registerDefaultBidderSetting = function (bidderCode, defaultSetting) {
	  defaultBidderSettingsMap[bidderCode] = defaultSetting;
	};
	
	exports.executeCallback = function (timedOut) {
	  if (externalCallbackArr.called !== true) {
	    processCallbacks(externalCallbackArr);
	    externalCallbackArr.called = true;
	
	    if (timedOut) {
	      var timedOutBidders = this.getTimedOutBidders();
	
	      if (timedOutBidders.length) {
	        events.emit(CONSTANTS.EVENTS.BID_TIMEOUT, timedOutBidders);
	      }
	    }
	  }
	
	  //execute one time callback
	  if (externalOneTimeCallback) {
	    try {
	      processCallbacks([externalOneTimeCallback]);
	    } finally {
	      pbjs.clearAuction();
	      externalOneTimeCallback = null;
	    }
	  }
	};
	
	function triggerAdUnitCallbacks(adUnitCode) {
	  //todo : get bid responses and send in args
	  var params = [adUnitCode];
	  processCallbacks(externalCallbackByAdUnitArr, params);
	}
	
	function processCallbacks(callbackQueue) {
	  var i;
	  if (utils.isArray(callbackQueue)) {
	    for (i = 0; i < callbackQueue.length; i++) {
	      var func = callbackQueue[i];
	      func.call(pbjs, pbjs._bidsReceived.reduce(groupByPlacement, {}));
	    }
	  }
	}
	
	/**
	 * groupByPlacement is a reduce function that converts an array of Bid objects
	 * to an object with placement codes as keys, with each key representing an object
	 * with an array of `Bid` objects for that placement
	 * @param prev previous value as accumulator object
	 * @param item current array item
	 * @param idx current index
	 * @param arr the array being reduced
	 * @returns {*} as { [adUnitCode]: { bids: [Bid, Bid, Bid] } }
	 */
	function groupByPlacement(prev, item, idx, arr) {
	  // this uses a standard "array to map" operation that could be abstracted further
	  if (item.adUnitCode in Object.keys(prev)) {
	    // if the adUnitCode key is present in the accumulator object, continue
	    return prev;
	  } else {
	    // otherwise add the adUnitCode key to the accumulator object and set to an object with an
	    // array of Bids for that adUnitCode
	    prev[item.adUnitCode] = {
	      bids: arr.filter(function (bid) {
	        return bid.adUnitCode === item.adUnitCode;
	      })
	    };
	    return prev;
	  }
	}
	
	/**
	 * Add a one time callback, that is discarded after it is called
	 * @param {Function} callback [description]
	 */
	exports.addOneTimeCallback = function (callback) {
	  externalOneTimeCallback = callback;
	};
	
	exports.addCallback = function (id, callback, cbEvent) {
	  callback.id = id;
	  if (CONSTANTS.CB.TYPE.ALL_BIDS_BACK === cbEvent) {
	    externalCallbackArr.push(callback);
	  } else if (CONSTANTS.CB.TYPE.AD_UNIT_BIDS_BACK === cbEvent) {
	    externalCallbackByAdUnitArr.push(callback);
	  }
	};
	
	//register event for bid adjustment
	events.on(CONSTANTS.EVENTS.BID_ADJUSTMENT, function (bid) {
	  adjustBids(bid);
	});
	
	function adjustBids(bid) {
	  var code = bid.bidderCode;
	  var bidPriceAdjusted = bid.cpm;
	  if (code && pbjs.bidderSettings && pbjs.bidderSettings[code]) {
	    if (_typeof(pbjs.bidderSettings[code].bidCpmAdjustment) === objectType_function) {
	      try {
	        bidPriceAdjusted = pbjs.bidderSettings[code].bidCpmAdjustment.call(null, bid.cpm, utils.extend({}, bid));
	      } catch (e) {
	        utils.logError('Error during bid adjustment', 'bidmanager.js', e);
	      }
	    }
	  }
	
	  if (bidPriceAdjusted !== 0) {
	    bid.cpm = bidPriceAdjusted;
	  }
	}
	
	exports.adjustBids = function () {
	  return adjustBids.apply(undefined, arguments);
	};
	
	function getPriceBucketString(cpm) {
	  var cpmFloat = 0;
	  var returnObj = {
	    low: '',
	    med: '',
	    high: '',
	    auto: '',
	    dense: ''
	  };
	  try {
	    cpmFloat = parseFloat(cpm);
	    if (cpmFloat) {
	      //round to closest .5
	      if (cpmFloat > _lgPriceCap) {
	        returnObj.low = _lgPriceCap.toFixed(2);
	      } else {
	        returnObj.low = (Math.floor(cpm * 2) / 2).toFixed(2);
	      }
	
	      //round to closest .1
	      if (cpmFloat > _mgPriceCap) {
	        returnObj.med = _mgPriceCap.toFixed(2);
	      } else {
	        returnObj.med = (Math.floor(cpm * 10) / 10).toFixed(2);
	      }
	
	      //round to closest .01
	      if (cpmFloat > _hgPriceCap) {
	        returnObj.high = _hgPriceCap.toFixed(2);
	      } else {
	        returnObj.high = (Math.floor(cpm * 100) / 100).toFixed(2);
	      }
	
	      // round auto default sliding scale
	      if (cpmFloat <= 5) {
	        // round to closest .05
	        returnObj.auto = (Math.floor(cpm * 20) / 20).toFixed(2);
	      } else if (cpmFloat <= 10) {
	        // round to closest .10
	        returnObj.auto = (Math.floor(cpm * 10) / 10).toFixed(2);
	      } else if (cpmFloat <= 20) {
	        // round to closest .50
	        returnObj.auto = (Math.floor(cpm * 2) / 2).toFixed(2);
	      } else {
	        // cap at 20.00
	        returnObj.auto = '20.00';
	      }
	
	      // dense mode
	      if (cpmFloat <= 3) {
	        // round to closest .01
	        returnObj.dense = (Math.floor(cpm * 100) / 100).toFixed(2);
	      } else if (cpmFloat <= 8) {
	        // round to closest .05
	        returnObj.dense = (Math.floor(cpm * 20) / 20).toFixed(2);
	      } else if (cpmFloat <= 20) {
	        // round to closest .50
	        returnObj.dense = (Math.floor(cpm * 2) / 2).toFixed(2);
	      } else {
	        // cap at 20.00
	        returnObj.dense = '20.00';
	      }
	    }
	  } catch (e) {
	    this.logError('Exception parsing CPM :' + e.message);
	  }
	
	  return returnObj;
	}

/***/ },
/* 5 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	/**
	 * events.js
	 */
	var utils = __webpack_require__(1);
	var CONSTANTS = __webpack_require__(2);
	var slice = Array.prototype.slice;
	var push = Array.prototype.push;
	
	//define entire events
	//var allEvents = ['bidRequested','bidResponse','bidWon','bidTimeout'];
	var allEvents = utils._map(CONSTANTS.EVENTS, function (v) {
	  return v;
	});
	
	var idPaths = CONSTANTS.EVENT_ID_PATHS;
	
	//keep a record of all events fired
	var eventsFired = [];
	
	module.exports = function () {
	
	  var _handlers = {};
	  var _public = {};
	
	  /**
	   *
	   * @param {String} eventString  The name of the event.
	   * @param {Array} args  The payload emitted with the event.
	   * @private
	   */
	  function _dispatch(eventString, args) {
	    utils.logMessage('Emitting event for: ' + eventString);
	
	    var eventPayload = args[0] || {};
	    var idPath = idPaths[eventString];
	    var key = eventPayload[idPath];
	    var event = _handlers[eventString] || { que: [] };
	    var eventKeys = utils._map(event, function (v, k) {
	      return k;
	    });
	
	    var callbacks = [];
	
	    //record the event:
	    eventsFired.push({
	      eventType: eventString,
	      args: eventPayload,
	      id: key
	    });
	
	    /** Push each specific callback to the `callbacks` array.
	     * If the `event` map has a key that matches the value of the
	     * event payload id path, e.g. `eventPayload[idPath]`, then apply
	     * each function in the `que` array as an argument to push to the
	     * `callbacks` array
	     * */
	    if (key && utils.contains(eventKeys, key)) {
	      push.apply(callbacks, event[key].que);
	    }
	
	    /** Push each general callback to the `callbacks` array. */
	    push.apply(callbacks, event.que);
	
	    /** call each of the callbacks */
	    utils._each(callbacks, function (fn) {
	      if (!fn) return;
	      try {
	        fn.apply(null, args);
	      } catch (e) {
	        utils.logError('Error executing handler:', 'events.js', e);
	      }
	    });
	  }
	
	  function _checkAvailableEvent(event) {
	    return utils.contains(allEvents, event);
	  }
	
	  _public.on = function (eventString, handler, id) {
	
	    //check whether available event or not
	    if (_checkAvailableEvent(eventString)) {
	      var event = _handlers[eventString] || { que: [] };
	
	      if (id) {
	        event[id] = event[id] || { que: [] };
	        event[id].que.push(handler);
	      } else {
	        event.que.push(handler);
	      }
	
	      _handlers[eventString] = event;
	    } else {
	      utils.logError('Wrong event name : ' + eventString + ' Valid event names :' + allEvents);
	    }
	  };
	
	  _public.emit = function (event) {
	    var args = slice.call(arguments, 1);
	    _dispatch(event, args);
	  };
	
	  _public.off = function (eventString, handler, id) {
	    var event = _handlers[eventString];
	
	    if (utils.isEmpty(event) || utils.isEmpty(event.que) && utils.isEmpty(event[id])) {
	      return;
	    }
	
	    if (id && (utils.isEmpty(event[id]) || utils.isEmpty(event[id].que))) {
	      return;
	    }
	
	    if (id) {
	      utils._each(event[id].que, function (_handler) {
	        var que = event[id].que;
	        if (_handler === handler) {
	          que.splice(utils.indexOf.call(que, _handler), 1);
	        }
	      });
	    } else {
	      utils._each(event.que, function (_handler) {
	        var que = event.que;
	        if (_handler === handler) {
	          que.splice(utils.indexOf.call(que, _handler), 1);
	        }
	      });
	    }
	
	    _handlers[eventString] = event;
	  };
	
	  _public.get = function () {
	    return _handlers;
	  };
	
	  /**
	   * This method can return a copy of all the events fired
	   * @return {Array} array of events fired
	   */
	  _public.getEvents = function () {
	    var arrayCopy = [];
	    utils._each(eventsFired, function (value) {
	      var newProp = utils.extend({}, value);
	      arrayCopy.push(newProp);
	    });
	
	    return arrayCopy;
	  };
	
	  return _public;
	}();

/***/ },
/* 6 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol ? "symbol" : typeof obj; };
	
	var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; /** @module adaptermanger */
	
	var _utils = __webpack_require__(1);
	
	var _baseAdapter = __webpack_require__(7);
	
	var utils = __webpack_require__(1);
	var CONSTANTS = __webpack_require__(2);
	var events = __webpack_require__(5);
	
	
	var _bidderRegistry = {};
	exports.bidderRegistry = _bidderRegistry;
	
	var _analyticsRegistry = {};
	
	function getBids(_ref) {
	  var bidderCode = _ref.bidderCode;
	  var requestId = _ref.requestId;
	  var bidderRequestId = _ref.bidderRequestId;
	  var adUnits = _ref.adUnits;
	
	  return adUnits.map(function (adUnit) {
	    return adUnit.bids.filter(function (bid) {
	      return bid.bidder === bidderCode;
	    }).map(function (bid) {
	      return _extends(bid, {
	        placementCode: adUnit.code,
	        sizes: adUnit.sizes,
	        bidId: utils.getUniqueIdentifierStr(),
	        bidderRequestId: bidderRequestId,
	        requestId: requestId
	      });
	    });
	  }).reduce(_utils.flatten, []);
	}
	
	exports.callBids = function (_ref2) {
	  var adUnits = _ref2.adUnits;
	  var cbTimeout = _ref2.cbTimeout;
	
	  var requestId = utils.generateUUID();
	
	  var auctionInit = {
	    timestamp: Date.now(),
	    requestId: requestId
	  };
	  events.emit(CONSTANTS.EVENTS.AUCTION_INIT, auctionInit);
	
	  (0, _utils.getBidderCodes)(adUnits).forEach(function (bidderCode) {
	    var adapter = _bidderRegistry[bidderCode];
	    if (adapter) {
	      var bidderRequestId = utils.getUniqueIdentifierStr();
	      var bidderRequest = {
	        bidderCode: bidderCode,
	        requestId: requestId,
	        bidderRequestId: bidderRequestId,
	        bids: getBids({ bidderCode: bidderCode, requestId: requestId, bidderRequestId: bidderRequestId, adUnits: adUnits }),
	        start: new Date().getTime(),
	        timeout: cbTimeout
	      };
	      utils.logMessage('CALLING BIDDER ======= ' + bidderCode);
	      pbjs._bidsRequested.push(bidderRequest);
	      events.emit(CONSTANTS.EVENTS.BID_REQUESTED, bidderRequest);
	      if (bidderRequest.bids && bidderRequest.bids.length) {
	        adapter.callBids(bidderRequest);
	      }
	    } else {
	      utils.logError('Adapter trying to be called which does not exist: ' + bidderCode + ' adaptermanager.callBids');
	    }
	  });
	};
	
	exports.registerBidAdapter = function (bidAdaptor, bidderCode) {
	  if (bidAdaptor && bidderCode) {
	
	    if (_typeof(bidAdaptor.callBids) === CONSTANTS.objectType_function) {
	      _bidderRegistry[bidderCode] = bidAdaptor;
	    } else {
	      utils.logError('Bidder adaptor error for bidder code: ' + bidderCode + 'bidder must implement a callBids() function');
	    }
	  } else {
	    utils.logError('bidAdaptor or bidderCode not specified');
	  }
	};
	
	exports.aliasBidAdapter = function (bidderCode, alias) {
	  var existingAlias = _bidderRegistry[alias];
	
	  if ((typeof existingAlias === 'undefined' ? 'undefined' : _typeof(existingAlias)) === CONSTANTS.objectType_undefined) {
	    var bidAdaptor = _bidderRegistry[bidderCode];
	
	    if ((typeof bidAdaptor === 'undefined' ? 'undefined' : _typeof(bidAdaptor)) === CONSTANTS.objectType_undefined) {
	      utils.logError('bidderCode "' + bidderCode + '" is not an existing bidder.', 'adaptermanager.aliasBidAdapter');
	    } else {
	      try {
	        var newAdapter = null;
	        if (bidAdaptor instanceof _baseAdapter.BaseAdapter) {
	          //newAdapter = new bidAdaptor.constructor(alias);
	          utils.logError(bidderCode + ' bidder does not currently support aliasing.', 'adaptermanager.aliasBidAdapter');
	        } else {
	          newAdapter = bidAdaptor.createNew();
	          newAdapter.setBidderCode(alias);
	          this.registerBidAdapter(newAdapter, alias);
	        }
	      } catch (e) {
	        utils.logError(bidderCode + ' bidder does not currently support aliasing.', 'adaptermanager.aliasBidAdapter');
	      }
	    }
	  } else {
	    utils.logMessage('alias name "' + alias + '" has been already specified.');
	  }
	};
	
	exports.registerAnalyticsAdapter = function (_ref3) {
	  var adapter = _ref3.adapter;
	  var code = _ref3.code;
	
	  if (adapter && code) {
	
	    if (_typeof(adapter.enableAnalytics) === CONSTANTS.objectType_function) {
	      adapter.code = code;
	      _analyticsRegistry[code] = adapter;
	    } else {
	      utils.logError('Prebid Error: Analytics adaptor error for analytics "' + code + '"\n        analytics adapter must implement an enableAnalytics() function');
	    }
	  } else {
	    utils.logError('Prebid Error: analyticsAdapter or analyticsCode not specified');
	  }
	};
	
	exports.enableAnalytics = function (config) {
	  if (!utils.isArray(config)) {
	    config = [config];
	  }
	
	  utils._each(config, function (adapterConfig) {
	    var adapter = _analyticsRegistry[adapterConfig.provider];
	    if (adapter) {
	      adapter.enableAnalytics(adapterConfig);
	    } else {
	      utils.logError('Prebid Error: no analytics adapter found in registry for\n        ' + adapterConfig.provider + '.');
	    }
	  });
	};
	
	var AardvarkAdapter = __webpack_require__(8);
	exports.registerBidAdapter(new AardvarkAdapter(), 'aardvark');
	var AdequantAdapter = __webpack_require__(11);
	exports.registerBidAdapter(new AdequantAdapter(), 'adequant');
	var AdformAdapter = __webpack_require__(12);
	exports.registerBidAdapter(new AdformAdapter(), 'adform');
	var AdmediaAdapter = __webpack_require__(13);
	exports.registerBidAdapter(new AdmediaAdapter(), 'admedia');
	var AolAdapter = __webpack_require__(14);
	exports.registerBidAdapter(new AolAdapter(), 'aol');
	var AppnexusAdapter = __webpack_require__(15);
	exports.registerBidAdapter(new AppnexusAdapter.createNew(), 'appnexus');
	var AppnexusAstAdapter = __webpack_require__(17);
	exports.registerBidAdapter(new AppnexusAstAdapter.createNew(), 'appnexusAst');
	var IndexExchangeAdapter = __webpack_require__(20);
	exports.registerBidAdapter(new IndexExchangeAdapter(), 'indexExchange');
	var KruxlinkAdapter = __webpack_require__(21);
	exports.registerBidAdapter(new KruxlinkAdapter(), 'kruxlink');
	var OpenxAdapter = __webpack_require__(22);
	exports.registerBidAdapter(new OpenxAdapter(), 'openx');
	var PubmaticAdapter = __webpack_require__(23);
	exports.registerBidAdapter(new PubmaticAdapter(), 'pubmatic');
	var PulsepointAdapter = __webpack_require__(24);
	exports.registerBidAdapter(new PulsepointAdapter(), 'pulsepoint');
	var RubiconAdapter = __webpack_require__(25);
	exports.registerBidAdapter(new RubiconAdapter(), 'rubicon');
	var SekindoAdapter = __webpack_require__(26);
	exports.registerBidAdapter(new SekindoAdapter(), 'sekindo');
	var SonobiAdapter = __webpack_require__(27);
	exports.registerBidAdapter(new SonobiAdapter(), 'sonobi');
	var SovrnAdapter = __webpack_require__(28);
	exports.registerBidAdapter(new SovrnAdapter(), 'sovrn');
	var SpringserveAdapter = __webpack_require__(29);
	exports.registerBidAdapter(new SpringserveAdapter(), 'springserve');
	var TripleliftAdapter = __webpack_require__(30);
	exports.registerBidAdapter(new TripleliftAdapter(), 'triplelift');
	var YieldbotAdapter = __webpack_require__(31);
	exports.registerBidAdapter(new YieldbotAdapter(), 'yieldbot');
	var NginadAdapter = __webpack_require__(32);
	exports.registerBidAdapter(new NginadAdapter(), 'nginad');
	var BrightcomAdapter = __webpack_require__(33);
	exports.registerBidAdapter(new BrightcomAdapter(), 'brightcom');
	var WideorbitAdapter = __webpack_require__(34);
	exports.registerBidAdapter(new WideorbitAdapter(), 'wideorbit');
	var JcmAdapter = __webpack_require__(35);
	exports.registerBidAdapter(new JcmAdapter(), 'jcm');
	var UnderdogmediaAdapter = __webpack_require__(36);
	exports.registerBidAdapter(new UnderdogmediaAdapter(), 'underdogmedia');
	var MemeglobalAdapter = __webpack_require__(37);
	exports.registerBidAdapter(new MemeglobalAdapter(), 'memeglobal');
	var CentroAdapter = __webpack_require__(38);
	exports.registerBidAdapter(new CentroAdapter(), 'centro');
	exports.aliasBidAdapter('appnexus', 'brealtime');
	exports.aliasBidAdapter('appnexus', 'pagescience');
	
	null;

/***/ },
/* 7 */
/***/ function(module, exports) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();
	
	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
	
	var BaseAdapter = exports.BaseAdapter = function () {
	  function BaseAdapter(code) {
	    _classCallCheck(this, BaseAdapter);
	
	    this.code = code;
	  }
	
	  _createClass(BaseAdapter, [{
	    key: 'getCode',
	    value: function getCode() {
	      return this.code;
	    }
	  }, {
	    key: 'setCode',
	    value: function setCode(code) {
	      this.code = code;
	    }
	  }, {
	    key: 'callBids',
	    value: function callBids() {
	      throw 'adapter implementation must override callBids method';
	    }
	  }]);

	  return BaseAdapter;
	}();

/***/ },
/* 8 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var utils = __webpack_require__(1);
	var bidfactory = __webpack_require__(9);
	var bidmanager = __webpack_require__(4);
	var adloader = __webpack_require__(10);
	
	/**
	 * Adapter for requesting bids from RTK Aardvark
	 * To request an RTK Aardvark Header bidding account
	 * or for additional integration support please contact sales@rtk.io
	 */
	
	var AardvarkAdapter = function AardvarkAdapter() {
	
	  function _callBids(params) {
	    var rtkBids = params.bids || [];
	
	    _requestBids(rtkBids);
	  }
	
	  function _requestBids(bidReqs) {
	    var ref = void 0;
	    try {
	      ref = window.top.location.host;
	    } catch (err) {
	      ref = "thor.rtk.io";
	    }
	    var ai = "";
	    var shortcodes = [];
	
	    //build bid URL for RTK
	    utils._each(bidReqs, function (bid) {
	      ai = utils.getBidIdParamater('ai', bid.params);
	      var sc = utils.getBidIdParamater('sc', bid.params);
	      shortcodes.push(sc);
	    });
	
	    var scURL = "";
	
	    if (shortcodes.length > 1) {
	      scURL = shortcodes.join("_");
	    } else {
	      scURL = shortcodes[0];
	    }
	
	    var scriptUrl = '//thor.rtk.io/' + ai + "/" + scURL + "/aardvark/?jsonp=window.pbjs.aardvarkResponse&rtkreferer=" + ref;
	    adloader.loadScript(scriptUrl);
	  }
	
	  //expose the callback to the global object:
	  window.pbjs.aardvarkResponse = function (rtkResponseObj) {
	
	    //Get all initial Aardvark Bid Objects
	    var bidsObj = pbjs._bidsRequested.filter(function (bidder) {
	      return bidder.bidderCode === 'aardvark';
	    })[0];
	
	    var returnedBidIDs = {};
	    var placementIDmap = {};
	
	    if (rtkResponseObj.length > 0) {
	      rtkResponseObj.forEach(function (bid) {
	
	        if (!bid.error) {
	          var currentBid = bidsObj.bids.filter(function (r) {
	            return r.params.sc === bid.id;
	          })[0];
	          if (currentBid) {
	            var bidResponse = bidfactory.createBid(1);
	            bidResponse.bidderCode = "aardvark";
	            bidResponse.cpm = bid.cpm;
	            bidResponse.ad = bid.adm;
	            bidResponse.ad += utils.createTrackPixelHtml(decodeURIComponent(bid.nurl));
	            bidResponse.width = currentBid.sizes[0][0];
	            bidResponse.height = currentBid.sizes[0][1];
	            returnedBidIDs[bid.id] = currentBid.placementCode;
	            bidmanager.addBidResponse(currentBid.placementCode, bidResponse);
	          }
	        }
	      });
	    }
	
	    //All bids are back - lets add a bid response for anything that did not receive a bid.
	    var initialSC = [];
	    bidsObj.bids.forEach(function (bid) {
	      initialSC.push(bid.params.sc);
	      placementIDmap[bid.params.sc] = bid.placementCode;
	    });
	
	    var difference = initialSC.filter(function (x) {
	      return Object.keys(returnedBidIDs).indexOf(x) === -1;
	    });
	
	    difference.forEach(function (shortcode) {
	      var bidResponse = bidfactory.createBid(2);
	      var placementcode = placementIDmap[shortcode];
	      bidResponse.bidderCode = "aardvark";
	      bidmanager.addBidResponse(placementcode, bidResponse);
	    });
	  }; // aardvarkResponse
	
	  return {
	    callBids: _callBids
	  };
	};
	
	module.exports = AardvarkAdapter;

/***/ },
/* 9 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var utils = __webpack_require__(1);
	
	/**
	 Required paramaters
	 bidderCode,
	 height,
	 width,
	 statusCode
	 Optional paramaters
	 adId,
	 cpm,
	 ad,
	 adUrl,
	 dealId,
	 priceKeyString;
	 */
	function Bid(statusCode, bidRequest) {
	  var _bidId = bidRequest && bidRequest.bidId || utils.getUniqueIdentifierStr();
	  var _statusCode = statusCode || 0;
	
	  this.bidderCode = '';
	  this.width = 0;
	  this.height = 0;
	  this.statusMessage = _getStatus();
	  this.adId = _bidId;
	
	  function _getStatus() {
	    switch (_statusCode) {
	      case 0:
	        return 'Pending';
	      case 1:
	        return 'Bid available';
	      case 2:
	        return 'Bid returned empty or error response';
	      case 3:
	        return 'Bid timed out';
	    }
	  }
	
	  this.getStatusCode = function () {
	    return _statusCode;
	  };
	
	  //returns the size of the bid creative. Concatenation of width and height by ‘x’.
	  this.getSize = function () {
	    return this.width + 'x' + this.height;
	  };
	}
	
	// Bid factory function.
	exports.createBid = function () {
	  return new (Function.prototype.bind.apply(Bid, [null].concat(Array.prototype.slice.call(arguments))))();
	};

/***/ },
/* 10 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var utils = __webpack_require__(1);
	var _requestCache = {};
	
	//add a script tag to the page, used to add /jpt call to page
	exports.loadScript = function (tagSrc, callback, cacheRequest) {
	  //var noop = () => {};
	  //
	  //callback = callback || noop;
	  if (!tagSrc) {
	    utils.logError('Error attempting to request empty URL', 'adloader.js:loadScript');
	    return;
	  }
	
	  if (cacheRequest) {
	    if (_requestCache[tagSrc]) {
	      if (callback && typeof callback === 'function') {
	        if (_requestCache[tagSrc].loaded) {
	          //invokeCallbacks immediately
	          callback();
	        } else {
	          //queue the callback
	          _requestCache[tagSrc].callbacks.push(callback);
	        }
	      }
	    } else {
	      _requestCache[tagSrc] = {
	        loaded: false,
	        callbacks: []
	      };
	      if (callback && typeof callback === 'function') {
	        _requestCache[tagSrc].callbacks.push(callback);
	      }
	
	      requestResource(tagSrc, function () {
	        _requestCache[tagSrc].loaded = true;
	        try {
	          for (var i = 0; i < _requestCache[tagSrc].callbacks.length; i++) {
	            _requestCache[tagSrc].callbacks[i]();
	          }
	        } catch (e) {
	          utils.logError('Error executing callback', 'adloader.js:loadScript', e);
	        }
	      });
	    }
	  }
	
	  //trigger one time request
	  else {
	      requestResource(tagSrc, callback);
	    }
	};
	
	function requestResource(tagSrc, callback) {
	  var jptScript = document.createElement('script');
	  jptScript.type = 'text/javascript';
	  jptScript.async = true;
	
	  // Execute a callback if necessary
	  if (callback && typeof callback === 'function') {
	    if (jptScript.readyState) {
	      jptScript.onreadystatechange = function () {
	        if (jptScript.readyState === 'loaded' || jptScript.readyState === 'complete') {
	          jptScript.onreadystatechange = null;
	          callback();
	        }
	      };
	    } else {
	      jptScript.onload = function () {
	        callback();
	      };
	    }
	  }
	
	  jptScript.src = tagSrc;
	
	  //add the new script tag to the page
	  var elToAppend = document.getElementsByTagName('head');
	  elToAppend = elToAppend.length ? elToAppend : document.getElementsByTagName('body');
	  if (elToAppend.length) {
	    elToAppend = elToAppend[0];
	    elToAppend.insertBefore(jptScript, elToAppend.firstChild);
	  }
	}
	
	//track a impbus tracking pixel
	//TODO: Decide if tracking via AJAX is sufficent, or do we need to
	//run impression trackers via page pixels?
	exports.trackPixel = function (pixelUrl) {
	  var delimiter = void 0;
	  var trackingPixel = void 0;
	
	  if (!pixelUrl || typeof pixelUrl !== 'string') {
	    utils.logMessage('Missing or invalid pixelUrl.');
	    return;
	  }
	
	  delimiter = pixelUrl.indexOf('?') > 0 ? '&' : '?';
	
	  //add a cachebuster so we don't end up dropping any impressions
	  trackingPixel = pixelUrl + delimiter + 'rnd=' + Math.floor(Math.random() * 1E7);
	  new Image().src = trackingPixel;
	  return trackingPixel;
	};

/***/ },
/* 11 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol ? "symbol" : typeof obj; };
	
	var bidfactory = __webpack_require__(9);
	var bidmanager = __webpack_require__(4);
	var adloader = __webpack_require__(10);
	var utils = __webpack_require__(1);
	var CONSTANTS = __webpack_require__(2);
	
	module.exports = function () {
	  var req_url_base = 'https://rex.adequant.com/rex/c2s_prebid?';
	
	  function _callBids(params) {
	    var req_url = [];
	    var publisher_id = null;
	    var sizes = [];
	    var cats = null;
	    var replies = [];
	    var placements = {};
	
	    var bids = params.bids || [];
	    for (var i = 0; i < bids.length; i++) {
	      var bid_request = bids[i];
	      var br_params = bid_request.params || {};
	      placements[bid_request.placementCode] = true;
	
	      publisher_id = br_params.publisher_id.toString() || publisher_id;
	      var bidfloor = br_params.bidfloor || 0.01;
	      cats = br_params.cats || cats;
	      if ((typeof cats === 'undefined' ? 'undefined' : _typeof(cats)) === utils.objectType_string) {
	        cats = cats.split(' ');
	      }
	      var br_sizes = utils.parseSizesInput(bid_request.sizes);
	      for (var j = 0; j < br_sizes.length; j++) {
	        sizes.push(br_sizes[j] + '_' + bidfloor);
	        replies.push(bid_request.placementCode);
	      }
	    }
	    // send out 1 bid request for all bids
	    if (publisher_id) {
	      req_url.push('a=' + publisher_id);
	    }
	    if (cats) {
	      req_url.push('c=' + cats.join('+'));
	    }
	    if (sizes) {
	      req_url.push('s=' + sizes.join('+'));
	    }
	
	    adloader.loadScript(req_url_base + req_url.join('&'), function () {
	      process_bids(replies, placements);
	    });
	  }
	
	  function process_bids(replies, placements) {
	    var placement_code,
	        bid,
	        adequant_creatives = window.adequant_creatives;
	    if (adequant_creatives && adequant_creatives.seatbid) {
	      for (var i = 0; i < adequant_creatives.seatbid.length; i++) {
	        var bid_response = adequant_creatives.seatbid[i].bid[0];
	        placement_code = replies[parseInt(bid_response.impid, 10) - 1];
	        if (!placement_code || !placements[placement_code]) {
	          continue;
	        }
	
	        bid = bidfactory.createBid(CONSTANTS.STATUS.GOOD);
	        bid.bidderCode = 'adequant';
	        bid.cpm = bid_response.price;
	        bid.ad = bid_response.adm;
	        bid.width = bid_response.w;
	        bid.height = bid_response.h;
	        bidmanager.addBidResponse(placement_code, bid);
	        placements[placement_code] = false;
	      }
	    }
	    for (placement_code in placements) {
	      if (placements[placement_code]) {
	        bid = bidfactory.createBid(CONSTANTS.STATUS.NO_BID);
	        bid.bidderCode = 'adequant';
	        bidmanager.addBidResponse(placement_code, bid);
	        utils.logMessage('No bid response from Adequant for placement code ' + placement_code);
	      }
	    }
	  }
	
	  return {
	    callBids: _callBids
	  };
	};

/***/ },
/* 12 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var utils = __webpack_require__(1);
	var adloader = __webpack_require__(10);
	var bidmanager = __webpack_require__(4);
	var bidfactory = __webpack_require__(9);
	
	function AdformAdapter() {
	
	  return {
	    callBids: _callBids
	  };
	
	  function _callBids(params) {
	    //var callbackName = '_adf_' + utils.getUniqueIdentifierStr();
	    var bid;
	    var noDomain = true;
	    var bids = params.bids;
	    var request = [];
	    var callbackName = '_adf_' + utils.getUniqueIdentifierStr();
	
	    for (var i = 0, l = bids.length; i < l; i++) {
	      bid = bids[i];
	      if (bid.adxDomain && noDomain) {
	        noDomain = false;
	        request.unshift('//' + bid.adxDomain + '/adx/?rp=4');
	      }
	
	      request.push(formRequestUrl(bid.params));
	    }
	
	    if (noDomain) {
	      request.unshift('//adx.adform.net/adx/?rp=4');
	    }
	
	    pbjs[callbackName] = handleCallback(bids);
	    request.push('callback=pbjs.' + callbackName);
	
	    adloader.loadScript(request.join('&'));
	  }
	
	  function formRequestUrl(reqData) {
	    var key;
	    var url = [];
	
	    var validProps = ['mid', 'inv', 'pdom', 'mname', 'mkw', 'mkv', 'cat', 'bcat', 'bcatrt', 'adv', 'advt', 'cntr', 'cntrt', 'maxp', 'minp', 'sminp', 'w', 'h', 'pb', 'pos', 'cturl', 'iturl', 'cttype', 'hidedomain', 'cdims', 'test'];
	
	    for (var i = 0, l = validProps.length; i < l; i++) {
	      key = validProps[i];
	      if (reqData.hasOwnProperty(key)) url.push(key, '=', reqData[key], '&');
	    }
	
	    return encode64(url.join(''));
	  }
	
	  function handleCallback(bids) {
	    return function handleResponse(adItems) {
	      var bidObject;
	      var bidder = 'adform';
	      var adItem;
	      var bid;
	      for (var i = 0, l = adItems.length; i < l; i++) {
	        adItem = adItems[i];
	        bid = bids[i];
	        if (adItem && adItem.response === 'banner' && verifySize(adItem, bid.sizes)) {
	
	          bidObject = bidfactory.createBid(1);
	          bidObject.bidderCode = bidder;
	          bidObject.cpm = adItem.win_bid;
	          bidObject.cur = adItem.win_cur;
	          bidObject.ad = adItem.banner;
	          bidObject.width = adItem.width;
	          bidObject.height = adItem.height;
	          bidmanager.addBidResponse(bid.placementCode, bidObject);
	        } else {
	          bidObject = bidfactory.createBid(2);
	          bidObject.bidderCode = bidder;
	          bidmanager.addBidResponse(bid.placementCode, bidObject);
	        }
	      }
	    };
	
	    function verifySize(adItem, validSizes) {
	      for (var j = 0, k = validSizes.length; j < k; j++) {
	        if (adItem.width === validSizes[j][0] && adItem.height === validSizes[j][1]) {
	          return true;
	        }
	      }
	
	      return false;
	    }
	  }
	
	  function encode64(input) {
	    var out = [];
	    var chr1;
	    var chr2;
	    var chr3;
	    var enc1;
	    var enc2;
	    var enc3;
	    var enc4;
	    var i = 0;
	    var _keyStr = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_=';
	
	    input = utf8_encode(input);
	
	    while (i < input.length) {
	
	      chr1 = input.charCodeAt(i++);
	      chr2 = input.charCodeAt(i++);
	      chr3 = input.charCodeAt(i++);
	
	      enc1 = chr1 >> 2;
	      enc2 = (chr1 & 3) << 4 | chr2 >> 4;
	      enc3 = (chr2 & 15) << 2 | chr3 >> 6;
	      enc4 = chr3 & 63;
	
	      if (isNaN(chr2)) {
	        enc3 = enc4 = 64;
	      } else if (isNaN(chr3)) {
	        enc4 = 64;
	      }
	
	      out.push(_keyStr.charAt(enc1), _keyStr.charAt(enc2));
	      if (enc3 !== 64) out.push(_keyStr.charAt(enc3));
	      if (enc4 !== 64) out.push(_keyStr.charAt(enc4));
	    }
	
	    return out.join('');
	  }
	
	  function utf8_encode(string) {
	    string = string.replace(/\r\n/g, '\n');
	    var utftext = '';
	
	    for (var n = 0; n < string.length; n++) {
	
	      var c = string.charCodeAt(n);
	
	      if (c < 128) {
	        utftext += String.fromCharCode(c);
	      } else if (c > 127 && c < 2048) {
	        utftext += String.fromCharCode(c >> 6 | 192);
	        utftext += String.fromCharCode(c & 63 | 128);
	      } else {
	        utftext += String.fromCharCode(c >> 12 | 224);
	        utftext += String.fromCharCode(c >> 6 & 63 | 128);
	        utftext += String.fromCharCode(c & 63 | 128);
	      }
	    }
	
	    return utftext;
	  }
	}
	
	module.exports = AdformAdapter;

/***/ },
/* 13 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var _utils = __webpack_require__(1);
	
	var bidfactory = __webpack_require__(9);
	var bidmanager = __webpack_require__(4);
	var adloader = __webpack_require__(10);
	var utils = __webpack_require__(1);
	var CONSTANTS = __webpack_require__(2);
	
	/**
	 * Adapter for requesting bids from AdMedia.
	 *
	 */
	var AdmediaAdapter = function AdmediaAdapter() {
	
	  function _callBids(params) {
	    var bids,
	        bidderUrl = window.location.protocol + "//b.admedia.com/banner/prebid/bidder/?";
	    bids = params.bids || [];
	    for (var i = 0; i < bids.length; i++) {
	      var request_obj = {};
	      var bid = bids[i];
	
	      if (bid.params.aid) {
	        request_obj.aid = bid.params.aid;
	      } else {
	        utils.logError('required param aid is missing', "admedia");
	        continue;
	      }
	
	      //optional page_url macro
	      if (bid.params.page_url) {
	        request_obj.page_url = bid.params.page_url;
	      }
	
	      //if set, return a test ad for all aids
	      if (bid.params.test_ad === 1) {
	        request_obj.test_ad = 1;
	      }
	
	      var parsedSizes = utils.parseSizesInput(bid.sizes);
	      var parsedSizesLength = parsedSizes.length;
	      if (parsedSizesLength > 0) {
	        //first value should be "size"
	        request_obj.size = parsedSizes[0];
	        if (parsedSizesLength > 1) {
	          //any subsequent values should be "promo_sizes"
	          var promo_sizes = [];
	          for (var j = 1; j < parsedSizesLength; j++) {
	            promo_sizes.push(parsedSizes[j]);
	          }
	
	          request_obj.promo_sizes = promo_sizes.join(",");
	        }
	      }
	
	      //detect urls
	      request_obj.siteDomain = window.location.host;
	      request_obj.sitePage = window.location.href;
	      request_obj.siteRef = document.referrer;
	      request_obj.topUrl = utils.getTopWindowUrl();
	
	      request_obj.callbackId = bid.bidId;
	
	      var endpoint = bidderUrl + utils.parseQueryStringParameters(request_obj);
	
	      //utils.logMessage('Admedia request built: ' + endpoint);
	
	      adloader.loadScript(endpoint);
	    }
	  }
	
	  //expose the callback to global object
	  pbjs.admediaHandler = function (response) {
	    var bidObject = {};
	    var callback_id = response.callback_id;
	    var placementCode = '';
	    var bidObj = (0, _utils.getBidRequest)(callback_id);
	    if (bidObj) {
	      placementCode = bidObj.placementCode;
	    }
	
	    if (bidObj && response.cpm > 0 && !!response.ad) {
	      bidObject = bidfactory.createBid(CONSTANTS.STATUS.GOOD);
	      bidObject.bidderCode = bidObj.bidder;
	      bidObject.cpm = parseFloat(response.cpm);
	      bidObject.ad = response.ad;
	      bidObject.width = response.width;
	      bidObject.height = response.height;
	    } else {
	      bidObject = bidfactory.createBid(CONSTANTS.STATUS.NO_BID);
	      bidObject.bidderCode = bidObj.bidder;
	      utils.logMessage('No prebid response from Admedia for placement code ' + placementCode);
	    }
	
	    bidmanager.addBidResponse(placementCode, bidObject);
	  };
	
	  // Export the callBids function, so that prebid.js can execute this function
	  // when the page asks to send out bid requests.
	  return {
	    callBids: _callBids
	  };
	};
	
	module.exports = AdmediaAdapter;

/***/ },
/* 14 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var utils = __webpack_require__(1);
	var bidfactory = __webpack_require__(9);
	var bidmanager = __webpack_require__(4);
	var adloader = __webpack_require__(10);
	
	var AolAdapter = function AolAdapter() {
	
	  // constants
	  var ADTECH_URI = 'https://secure-ads.pictela.net/rm/marketplace/pubtaglib/0_4_0/pubtaglib_0_4_0.js';
	  var ADTECH_BIDDER_NAME = 'aol';
	  var ADTECH_PUBAPI_CONFIG = {
	    pixelsDivId: 'pixelsDiv',
	    defaultKey: 'aolBid',
	    roundingConfig: [{
	      from: 0,
	      to: 999,
	      roundFunction: 'tenCentsRound'
	    }, {
	      from: 1000,
	      to: -1,
	      roundValue: 1000
	    }],
	    pubApiOK: _addBid,
	    pubApiER: _addErrorBid
	  };
	
	  var bids;
	  var bidsMap = {};
	  var d = window.document;
	  var h = d.getElementsByTagName('HEAD')[0];
	  var dummyUnitIdCount = 0;
	
	  /**
	   * @private create a div that we'll use as the
	   * location for the AOL unit; AOL will document.write
	   * if the div is not present in the document.
	   * @param {String} id to identify the div
	   * @return {String} the id used with the div
	   */
	  function _dummyUnit(id) {
	    var div = d.createElement('DIV');
	
	    if (!id || !id.length) {
	      id = 'ad-placeholder-' + ++dummyUnitIdCount;
	    }
	
	    div.id = id + '-head-unit';
	    h.appendChild(div);
	    return div.id;
	  }
	
	  /**
	   * @private Add a succesful bid response for aol
	   * @param {ADTECHResponse} response the response for the bid
	   * @param {ADTECHContext} context the context passed from aol
	   */
	  function _addBid(response, context) {
	    var bid = bidsMap[context.alias];
	    var cpm;
	
	    if (!bid) {
	      utils.logError('mismatched bid: ' + context.placement, ADTECH_BIDDER_NAME, context);
	      return;
	    }
	
	    cpm = response.getCPM();
	    if (cpm === null || isNaN(cpm)) {
	      return _addErrorBid(response, context);
	    }
	
	    // clean up--we no longer need to store the bid
	    delete bidsMap[context.alias];
	
	    var bidResponse = bidfactory.createBid(1);
	    var ad = response.getCreative();
	    if (typeof response.getPixels() !== 'undefined') {
	      ad += response.getPixels();
	    }
	    bidResponse.bidderCode = ADTECH_BIDDER_NAME;
	    bidResponse.ad = ad;
	    bidResponse.cpm = cpm;
	    bidResponse.width = response.getAdWidth();
	    bidResponse.height = response.getAdHeight();
	    bidResponse.creativeId = response.getCreativeId();
	
	    // add it to the bid manager
	    bidmanager.addBidResponse(bid.placementCode, bidResponse);
	  }
	
	  /**
	   * @private Add an error bid response for aol
	   * @param {ADTECHResponse} response the response for the bid
	   * @param {ADTECHContext} context the context passed from aol
	   */
	  function _addErrorBid(response, context) {
	    var bid = bidsMap[context.alias];
	
	    if (!bid) {
	      utils.logError('mismatched bid: ' + context.placement, ADTECH_BIDDER_NAME, context);
	      return;
	    }
	
	    // clean up--we no longer need to store the bid
	    delete bidsMap[context.alias];
	
	    var bidResponse = bidfactory.createBid(2);
	    bidResponse.bidderCode = ADTECH_BIDDER_NAME;
	    bidResponse.reason = response.getNbr();
	    bidResponse.raw = response.getResponse();
	    bidmanager.addBidResponse(bid.placementCode, bidResponse);
	  }
	
	  /**
	   * @private map a prebid bidrequest to an ADTECH/aol bid request
	   * @param {Bid} bid the bid request
	   * @return {Object} the bid request, formatted for the ADTECH/DAC api
	   */
	  function _mapUnit(bid) {
	    var alias = bid.params.alias || utils.getUniqueIdentifierStr();
	
	    // save the bid
	    bidsMap[alias] = bid;
	
	    return {
	      adContainerId: _dummyUnit(bid.params.adContainerId),
	      server: bid.params.server, // By default, DAC.js will use the US region endpoint (adserver.adtechus.com)
	      sizeid: bid.params.sizeId || 0,
	      pageid: bid.params.pageId,
	      secure: document.location.protocol === 'https:',
	      serviceType: 'pubapi',
	      performScreenDetection: false,
	      alias: alias,
	      network: bid.params.network,
	      placement: parseInt(bid.params.placement),
	      gpt: {
	        adUnitPath: bid.params.adUnitPath || bid.placementCode,
	        size: bid.params.size || (bid.sizes || [])[0]
	      },
	      params: {
	        cors: 'yes',
	        cmd: 'bid',
	        bidfloor: typeof bid.params.bidFloor !== "undefined" ? bid.params.bidFloor.toString() : ''
	      },
	      pubApiConfig: ADTECH_PUBAPI_CONFIG,
	      placementCode: bid.placementCode
	    };
	  }
	
	  /**
	   * @private once ADTECH is loaded, request bids by
	   * calling ADTECH.loadAd
	   */
	  function _reqBids() {
	    if (!window.ADTECH) {
	      utils.logError('window.ADTECH is not present!', ADTECH_BIDDER_NAME);
	      return;
	    }
	
	    // get the bids
	    utils._each(bids, function (bid) {
	      var bidreq = _mapUnit(bid);
	      window.ADTECH.loadAd(bidreq);
	    });
	  }
	
	  /**
	   * @public call the bids
	   * this requests the specified bids
	   * from aol marketplace
	   * @param {Object} params
	   * @param {Array} params.bids the bids to be requested
	   */
	  function _callBids(params) {
	    window.bidRequestConfig = window.bidRequestConfig || {};
	    window.dacBidRequestConfigs = window.dacBidRequestConfigs || {};
	    bids = params.bids;
	    if (!bids || !bids.length) return;
	    adloader.loadScript(ADTECH_URI, _reqBids, true);
	  }
	
	  return {
	    callBids: _callBids
	  };
	};
	
	module.exports = AolAdapter;

/***/ },
/* 15 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var _utils = __webpack_require__(1);
	
	var CONSTANTS = __webpack_require__(2);
	var utils = __webpack_require__(1);
	var adloader = __webpack_require__(10);
	var bidmanager = __webpack_require__(4);
	var bidfactory = __webpack_require__(9);
	var Adapter = __webpack_require__(16);
	
	var AppNexusAdapter;
	AppNexusAdapter = function AppNexusAdapter() {
	  var baseAdapter = Adapter.createNew('appnexus');
	
	  baseAdapter.callBids = function (params) {
	    //var bidCode = baseAdapter.getBidderCode();
	
	    var anArr = params.bids;
	
	    //var bidsCount = anArr.length;
	
	    //set expected bids count for callback execution
	    //bidmanager.setExpectedBidsCount(bidCode, bidsCount);
	
	    for (var i = 0; i < anArr.length; i++) {
	      var bidRequest = anArr[i];
	      var callbackId = bidRequest.bidId;
	      adloader.loadScript(buildJPTCall(bidRequest, callbackId));
	
	      //store a reference to the bidRequest from the callback id
	      //bidmanager.pbCallbackMap[callbackId] = bidRequest;
	    }
	  };
	
	  function buildJPTCall(bid, callbackId) {
	
	    //determine tag params
	    var placementId = utils.getBidIdParamater('placementId', bid.params);
	
	    //memberId will be deprecated, use member instead
	    var memberId = utils.getBidIdParamater('memberId', bid.params);
	    var member = utils.getBidIdParamater('member', bid.params);
	    var inventoryCode = utils.getBidIdParamater('invCode', bid.params);
	    var query = utils.getBidIdParamater('query', bid.params);
	    var referrer = utils.getBidIdParamater('referrer', bid.params);
	    var altReferrer = utils.getBidIdParamater('alt_referrer', bid.params);
	
	    //build our base tag, based on if we are http or https
	
	    var jptCall = 'http' + (document.location.protocol === 'https:' ? 's://secure.adnxs.com/jpt?' : '://ib.adnxs.com/jpt?');
	
	    jptCall = utils.tryAppendQueryString(jptCall, 'callback', 'pbjs.handleAnCB');
	    jptCall = utils.tryAppendQueryString(jptCall, 'callback_uid', callbackId);
	    jptCall = utils.tryAppendQueryString(jptCall, 'psa', '0');
	    jptCall = utils.tryAppendQueryString(jptCall, 'id', placementId);
	    if (member) {
	      jptCall = utils.tryAppendQueryString(jptCall, 'member', member);
	    } else if (memberId) {
	      jptCall = utils.tryAppendQueryString(jptCall, 'member', memberId);
	      utils.logMessage('appnexus.callBids: "memberId" will be deprecated soon. Please use "member" instead');
	    }
	
	    jptCall = utils.tryAppendQueryString(jptCall, 'code', inventoryCode);
	
	    //sizes takes a bit more logic
	    var sizeQueryString = '';
	    var parsedSizes = utils.parseSizesInput(bid.sizes);
	
	    //combine string into proper querystring for impbus
	    var parsedSizesLength = parsedSizes.length;
	    if (parsedSizesLength > 0) {
	      //first value should be "size"
	      sizeQueryString = 'size=' + parsedSizes[0];
	      if (parsedSizesLength > 1) {
	        //any subsequent values should be "promo_sizes"
	        sizeQueryString += '&promo_sizes=';
	        for (var j = 1; j < parsedSizesLength; j++) {
	          sizeQueryString += parsedSizes[j] += ',';
	        }
	
	        //remove trailing comma
	        if (sizeQueryString && sizeQueryString.charAt(sizeQueryString.length - 1) === ',') {
	          sizeQueryString = sizeQueryString.slice(0, sizeQueryString.length - 1);
	        }
	      }
	    }
	
	    if (sizeQueryString) {
	      jptCall += sizeQueryString + '&';
	    }
	
	    //this will be deprecated soon
	    var targetingParams = utils.parseQueryStringParameters(query);
	
	    if (targetingParams) {
	      //don't append a & here, we have already done it in parseQueryStringParameters
	      jptCall += targetingParams;
	    }
	
	    //append custom attributes:
	    var paramsCopy = utils.extend({}, bid.params);
	
	    //delete attributes already used
	    delete paramsCopy.placementId;
	    delete paramsCopy.memberId;
	    delete paramsCopy.invCode;
	    delete paramsCopy.query;
	    delete paramsCopy.referrer;
	    delete paramsCopy.alt_referrer;
	    delete paramsCopy.member;
	
	    //get the reminder
	    var queryParams = utils.parseQueryStringParameters(paramsCopy);
	
	    //append
	    if (queryParams) {
	      jptCall += queryParams;
	    }
	
	    //append referrer
	    if (referrer === '') {
	      referrer = utils.getTopWindowUrl();
	    }
	
	    jptCall = utils.tryAppendQueryString(jptCall, 'referrer', referrer);
	    jptCall = utils.tryAppendQueryString(jptCall, 'alt_referrer', altReferrer);
	
	    //remove the trailing "&"
	    if (jptCall.lastIndexOf('&') === jptCall.length - 1) {
	      jptCall = jptCall.substring(0, jptCall.length - 1);
	    }
	
	    // @if NODE_ENV='debug'
	    utils.logMessage('jpt request built: ' + jptCall);
	
	    // @endif
	
	    //append a timer here to track latency
	    bid.startTime = new Date().getTime();
	
	    return jptCall;
	  }
	
	  //expose the callback to the global object:
	  pbjs.handleAnCB = function (jptResponseObj) {
	
	    var bidCode;
	
	    if (jptResponseObj && jptResponseObj.callback_uid) {
	
	      var responseCPM;
	      var id = jptResponseObj.callback_uid;
	      var placementCode = '';
	      var bidObj = (0, _utils.getBidRequest)(id);
	      if (bidObj) {
	
	        bidCode = bidObj.bidder;
	
	        placementCode = bidObj.placementCode;
	
	        //set the status
	        bidObj.status = CONSTANTS.STATUS.GOOD;
	      }
	
	      // @if NODE_ENV='debug'
	      utils.logMessage('JSONP callback function called for ad ID: ' + id);
	
	      // @endif
	      var bid = [];
	      if (jptResponseObj.result && jptResponseObj.result.cpm && jptResponseObj.result.cpm !== 0) {
	        responseCPM = parseInt(jptResponseObj.result.cpm, 10);
	
	        //CPM response from /jpt is dollar/cent multiplied by 10000
	        //in order to avoid using floats
	        //switch CPM to "dollar/cent"
	        responseCPM = responseCPM / 10000;
	
	        //store bid response
	        //bid status is good (indicating 1)
	        var adId = jptResponseObj.result.creative_id;
	        bid = bidfactory.createBid(1);
	        bid.creative_id = adId;
	        bid.bidderCode = bidCode;
	        bid.cpm = responseCPM;
	        bid.adUrl = jptResponseObj.result.ad;
	        bid.width = jptResponseObj.result.width;
	        bid.height = jptResponseObj.result.height;
	        bid.dealId = jptResponseObj.result.deal_id;
	
	        bidmanager.addBidResponse(placementCode, bid);
	      } else {
	        //no response data
	        // @if NODE_ENV='debug'
	        utils.logMessage('No prebid response from AppNexus for placement code ' + placementCode);
	
	        // @endif
	        //indicate that there is no bid for this placement
	        bid = bidfactory.createBid(2);
	        bid.bidderCode = bidCode;
	        bidmanager.addBidResponse(placementCode, bid);
	      }
	    } else {
	      //no response data
	      // @if NODE_ENV='debug'
	      utils.logMessage('No prebid response for placement %%PLACEMENT%%');
	
	      // @endif
	    }
	  };
	
	  return {
	    callBids: baseAdapter.callBids,
	    setBidderCode: baseAdapter.setBidderCode,
	    createNew: exports.createNew,
	    buildJPTCall: buildJPTCall
	  };
	};
	
	exports.createNew = function () {
	  return new AppNexusAdapter();
	};
	
	// module.exports = AppNexusAdapter;

/***/ },
/* 16 */
/***/ function(module, exports) {

	"use strict";
	
	function Adapter(code) {
	  var bidderCode = code;
	
	  function setBidderCode(code) {
	    bidderCode = code;
	  }
	
	  function getBidderCode() {
	    return bidderCode;
	  }
	
	  function callBids() {}
	
	  return {
	    callBids: callBids,
	    setBidderCode: setBidderCode,
	    getBidderCode: getBidderCode
	  };
	}
	
	exports.createNew = function (bidderCode) {
	  return new Adapter(bidderCode);
	};

/***/ },
/* 17 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol ? "symbol" : typeof obj; };
	
	var _adapter = __webpack_require__(16);
	
	var _adapter2 = _interopRequireDefault(_adapter);
	
	var _bidfactory = __webpack_require__(9);
	
	var _bidfactory2 = _interopRequireDefault(_bidfactory);
	
	var _bidmanager = __webpack_require__(4);
	
	var _bidmanager2 = _interopRequireDefault(_bidmanager);
	
	var _utils = __webpack_require__(1);
	
	var utils = _interopRequireWildcard(_utils);
	
	var _ajax = __webpack_require__(18);
	
	var _constants = __webpack_require__(2);
	
	function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }
	
	var ENDPOINT = '//ib.adnxs.com/ut/v2/prebid';
	
	/**
	 * Bidder adapter for /ut endpoint. Given the list of all ad unit tag IDs,
	 * sends out a bid request. When a bid response is back, registers the bid
	 * to Prebid.js. This adapter supports alias bidding.
	 */
	function AppnexusAstAdapter() {
	
	  var baseAdapter = _adapter2.default.createNew('appnexusAst');
	  var bidRequests = {};
	
	  /* Prebid executes this function when the page asks to send out bid requests */
	  baseAdapter.callBids = function (bidRequest) {
	    var bids = bidRequest.bids || [];
	    var tags = bids.filter(function (bid) {
	      return valid(bid);
	    }).map(function (bid) {
	      // map request id to bid object to retrieve adUnit code in callback
	      bidRequests[bid.bidId] = bid;
	
	      var tag = {};
	      tag.sizes = getSizes(bid.sizes);
	      tag.primary_size = tag.sizes[0];
	      tag.uuid = bid.bidId;
	      tag.id = parseInt(bid.params.placementId, 10);
	      tag.allow_smaller_sizes = bid.params.allowSmallerSizes || false;
	      tag.prebid = true;
	      tag.disable_psa = true;
	      if (!utils.isEmpty(bid.params.keywords)) {
	        tag.keywords = getKeywords(bid.params.keywords);
	      }
	
	      return tag;
	    });
	
	    if (!utils.isEmpty(tags)) {
	      var payload = JSON.stringify({ tags: [].concat(_toConsumableArray(tags)) });
	      (0, _ajax.ajax)(ENDPOINT, handleResponse, payload, {
	        contentType: 'text/plain',
	        preflight: false
	      });
	    }
	  };
	
	  /* Notify Prebid of bid responses so bids can get in the auction */
	  function handleResponse(response) {
	    var parsed = void 0;
	
	    try {
	      parsed = JSON.parse(response);
	    } catch (error) {
	      utils.logError(error);
	    }
	
	    if (!parsed || parsed.error) {
	      utils.logError('Bad response for ' + baseAdapter.getBidderCode() + ' adapter');
	
	      // signal this response is complete
	      Object.keys(bidRequests).map(function (bidId) {
	        return bidRequests[bidId].placementCode;
	      }).forEach(function (placementCode) {
	        _bidmanager2.default.addBidResponse(placementCode, createBid(_constants.STATUS.NO_BID));
	      });
	      return;
	    }
	
	    parsed.tags.forEach(function (tag) {
	      var cpm = tag.ads && tag.ads[0].cpm;
	      var type = tag.ads && tag.ads[0].ad_type;
	
	      var status = void 0;
	      if (cpm !== 0 && type === 'banner') {
	        status = _constants.STATUS.GOOD;
	      } else {
	        status = _constants.STATUS.NO_BID;
	      }
	
	      if (type && type !== 'banner') {
	        utils.logError(type + ' ad type not supported');
	      }
	
	      tag.bidId = tag.uuid; // bidfactory looks for bidId on requested bid
	      var bid = createBid(status, tag);
	      var placement = bidRequests[bid.adId].placementCode;
	      _bidmanager2.default.addBidResponse(placement, bid);
	    });
	  }
	
	  /* Check that a bid has required paramters */
	  function valid(bid) {
	    if (bid.params.placementId || bid.params.memberId && bid.params.invCode) {
	      return bid;
	    } else {
	      utils.logError('bid requires placementId or (memberId and invCode) params');
	    }
	  }
	
	  /* Turn keywords parameter into ut-compatible format */
	  function getKeywords(keywords) {
	    var arrs = [];
	
	    utils._each(keywords, function (v, k) {
	      if (utils.isArray(v)) {
	        (function () {
	          var values = [];
	          utils._each(v, function (val) {
	            val = utils.getValueString('keywords.' + k, val);
	            if (val) {
	              values.push(val);
	            }
	          });
	          v = values;
	        })();
	      } else {
	        v = utils.getValueString('keywords.' + k, v);
	        if (utils.isStr(v)) {
	          v = [v];
	        } else {
	          return;
	        } // unsuported types - don't send a key
	      }
	      arrs.push({ key: k, value: v });
	    });
	
	    return arrs;
	  }
	
	  /* Turn bid request sizes into ut-compatible format */
	  function getSizes(requestSizes) {
	    var sizes = [];
	    var sizeObj = {};
	
	    if (utils.isArray(requestSizes) && requestSizes.length === 2 && !utils.isArray(requestSizes[0])) {
	      sizeObj.width = parseInt(requestSizes[0], 10);
	      sizeObj.height = parseInt(requestSizes[1], 10);
	      sizes.push(sizeObj);
	    } else if ((typeof requestSizes === 'undefined' ? 'undefined' : _typeof(requestSizes)) === 'object') {
	      for (var i = 0; i < requestSizes.length; i++) {
	        var size = requestSizes[i];
	        sizeObj = {};
	        sizeObj.width = parseInt(size[0], 10);
	        sizeObj.height = parseInt(size[1], 10);
	        sizes.push(sizeObj);
	      }
	    }
	
	    return sizes;
	  }
	
	  /* Create and return a bid object based on status and tag */
	  function createBid(status, tag) {
	    var bid = _bidfactory2.default.createBid(status, tag);
	    bid.code = baseAdapter.getBidderCode();
	    bid.bidderCode = baseAdapter.getBidderCode();
	
	    if (status === _constants.STATUS.GOOD) {
	      bid.cpm = tag.ads[0].cpm;
	      bid.creative_id = tag.ads[0].creativeId;
	      bid.width = tag.ads[0].rtb.banner.width;
	      bid.height = tag.ads[0].rtb.banner.height;
	      bid.ad = tag.ads[0].rtb.banner.content;
	      try {
	        var url = tag.ads[0].rtb.trackers[0].impression_urls[0];
	        var tracker = utils.createTrackPixelHtml(url);
	        bid.ad += tracker;
	      } catch (error) {
	        utils.logError('Error appending tracking pixel', error);
	      }
	    }
	
	    return bid;
	  }
	
	  return {
	    createNew: exports.createNew,
	    callBids: baseAdapter.callBids,
	    setBidderCode: baseAdapter.setBidderCode
	  };
	}
	
	exports.createNew = function () {
	  return new AppnexusAstAdapter();
	};

/***/ },
/* 18 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	exports.ajax = undefined;
	
	var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };
	
	var _url = __webpack_require__(19);
	
	/**
	 * Simple cross-browser ajax request function
	 * https://gist.github.com/Xeoncross/7663273
	
	 * IE 5.5+, Firefox, Opera, Chrome, Safari XHR object
	 *
	 * @param url string url
	 * @param callback object callback
	 * @param data mixed data
	 * @param options object
	 */
	
	var ajax = exports.ajax = function ajax(url, callback, data) {
	  var options = arguments.length <= 3 || arguments[3] === undefined ? {} : arguments[3];
	
	  var x = void 0;
	
	  try {
	    if (window.XMLHttpRequest) {
	      x = new window.XMLHttpRequest('MSXML2.XMLHTTP.3.0');
	    }
	
	    if (window.ActiveXObject) {
	      x = new window.ActiveXObject('MSXML2.XMLHTTP.3.0');
	    }
	
	    var method = options.method || (data ? 'POST' : 'GET');
	
	    if (method === 'GET' && data) {
	      var urlInfo = (0, _url.parse)(url);
	      _extends(urlInfo.search, data);
	      url = (0, _url.format)(urlInfo);
	    }
	
	    //x = new (window.XMLHttpRequest || window.ActiveXObject)('MSXML2.XMLHTTP.3.0');
	    x.open(method, url, 1);
	
	    if (options.withCredentials) {
	      x.withCredentials = true;
	    } else {
	      x.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	      x.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
	    }
	
	    //x.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	    x.onreadystatechange = function () {
	      if (x.readyState > 3 && callback) {
	        callback(x.responseText, x);
	      }
	    };
	
	    x.send(method === 'POST' && data);
	  } catch (e) {
	    console.log(e);
	  }
	};

/***/ },
/* 19 */
/***/ function(module, exports) {

	'use strict';
	
	Object.defineProperty(exports, "__esModule", {
	  value: true
	});
	
	var _slicedToArray = function () { function sliceIterator(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"]) _i["return"](); } finally { if (_d) throw _e; } } return _arr; } return function (arr, i) { if (Array.isArray(arr)) { return arr; } else if (Symbol.iterator in Object(arr)) { return sliceIterator(arr, i); } else { throw new TypeError("Invalid attempt to destructure non-iterable instance"); } }; }();
	
	exports.parseQS = parseQS;
	exports.formatQS = formatQS;
	exports.parse = parse;
	exports.format = format;
	function parseQS(query) {
	  return !query ? {} : query.replace(/^\?/, '').split('&').reduce(function (acc, criteria) {
	    var _criteria$split = criteria.split('=');
	
	    var _criteria$split2 = _slicedToArray(_criteria$split, 2);
	
	    var k = _criteria$split2[0];
	    var v = _criteria$split2[1];
	
	    if (/\[\]$/.test(k)) {
	      k = k.replace('[]', '');
	      acc[k] = acc[k] || [];
	      acc[k].push(v);
	    } else {
	      acc[k] = v || '';
	    }
	    return acc;
	  }, {});
	}
	
	function formatQS(query) {
	  return Object.keys(query).map(function (k) {
	    return Array.isArray(query[k]) ? query[k].map(function (v) {
	      return k + '[]=' + v;
	    }).join('&') : k + '=' + query[k];
	  }).join('&');
	}
	
	function parse(url) {
	  var parsed = document.createElement('a');
	  parsed.href = decodeURIComponent(url);
	  return {
	    protocol: (parsed.protocol || '').replace(/:$/, ''),
	    hostname: parsed.hostname,
	    port: +parsed.port,
	    pathname: parsed.pathname,
	    search: parseQS(parsed.search || ''),
	    hash: (parsed.hash || '').replace(/^#/, ''),
	    host: parsed.host
	  };
	}
	
	function format(obj) {
	  return (obj.protocol || 'http') + '://' + (obj.host || obj.hostname + (obj.port ? ':' + obj.port : '')) + (obj.pathname || '') + (obj.search ? '?' + formatQS(obj.search || '') : '') + (obj.hash ? '#' + obj.hash : '');
	}

/***/ },
/* 20 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	//Factory for creating the bidderAdaptor
	// jshint ignore:start
	var utils = __webpack_require__(1);
	var bidfactory = __webpack_require__(9);
	var bidmanager = __webpack_require__(4);
	var adloader = __webpack_require__(10);
	
	var ADAPTER_NAME = 'INDEXEXCHANGE';
	var ADAPTER_CODE = 'indexExchange';
	
	var cygnus_index_parse_res = function cygnus_index_parse_res() {};
	
	window.cygnus_index_args = {};
	
	var cygnus_index_adunits = [[728, 90], [120, 600], [300, 250], [160, 600], [336, 280], [234, 60], [300, 600], [300, 50], [320, 50], [970, 250], [300, 1050], [970, 90], [180, 150]]; // jshint ignore:line
	
	var cygnus_index_start = function cygnus_index_start() {
	  window.index_slots = [];
	
	  window.cygnus_index_args.parseFn = cygnus_index_parse_res;
	  var escapable = /[\\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g;
	  var meta = {
	    '\b': '\\b',
	    '\t': '\\t',
	    '\n': '\\n',
	    '\f': '\\f',
	    '\r': '\\r',
	    '"': '\\"',
	    '\\': '\\\\'
	  };
	
	  function escapeCharacter(character) {
	    var escaped = meta[character];
	    if (typeof escaped === 'string') {
	      return escaped;
	    } else {
	      return '\\u' + ('0000' + character.charCodeAt(0).toString(16)).slice(-4);
	    }
	  }
	
	  function quote(string) {
	    escapable.lastIndex = 0;
	    if (escapable.test(string)) {
	      return string.replace(escapable, escapeCharacter);
	    } else {
	      return string;
	    }
	  }
	
	  function OpenRTBRequest(siteID, parseFn, timeoutDelay) {
	    this.initialized = false;
	    if (typeof siteID !== 'number' || siteID % 1 !== 0 || siteID < 0) {
	      throw 'Invalid Site ID';
	    }
	
	    if (typeof timeoutDelay === 'number' && timeoutDelay % 1 === 0 && timeoutDelay >= 0) {
	      this.timeoutDelay = timeoutDelay;
	    }
	
	    this.siteID = siteID;
	    this.impressions = [];
	    this._parseFnName = undefined;
	    if (top === self) {
	      this.sitePage = location.href;
	      this.topframe = 1;
	    } else {
	      this.sitePage = document.referrer;
	      this.topframe = 0;
	    }
	
	    if (typeof parseFn !== 'undefined') {
	      if (typeof parseFn === 'function') {
	        this._parseFnName = 'cygnus_index_args.parseFn';
	      } else {
	        throw 'Invalid jsonp target function';
	      }
	    }
	
	    if (typeof _IndexRequestData.requestCounter === 'undefined') {
	      _IndexRequestData.requestCounter = Math.floor(Math.random() * 256);
	    } else {
	      _IndexRequestData.requestCounter = (_IndexRequestData.requestCounter + 1) % 256;
	    }
	
	    this.requestID = String(new Date().getTime() % 2592000 * 256 + _IndexRequestData.requestCounter + 256);
	    this.initialized = true;
	  }
	
	  OpenRTBRequest.prototype.serialize = function () {
	    var json = '{"id":' + this.requestID + ',"site":{"page":"' + quote(this.sitePage) + '"';
	    if (typeof document.referrer === 'string') {
	      json += ',"ref":"' + quote(document.referrer) + '"';
	    }
	
	    json += '},"imp":[';
	    for (var i = 0; i < this.impressions.length; i++) {
	      var impObj = this.impressions[i];
	      var ext = [];
	      json += '{"id":"' + impObj.id + '", "banner":{"w":' + impObj.w + ',"h":' + impObj.h + ',"topframe":' + String(this.topframe) + '}';
	      if (typeof impObj.bidfloor === 'number') {
	        json += ',"bidfloor":' + impObj.bidfloor;
	        if (typeof impObj.bidfloorcur === 'string') {
	          json += ',"bidfloorcur":"' + quote(impObj.bidfloorcur) + '"';
	        }
	      }
	
	      if (typeof impObj.slotID === 'string' && !impObj.slotID.match(/^\s*$/)) {
	        ext.push('"sid":"' + quote(impObj.slotID) + '"');
	      }
	
	      if (typeof impObj.siteID === 'number') {
	        ext.push('"siteID":' + impObj.siteID);
	      }
	
	      if (ext.length > 0) {
	        json += ',"ext": {' + ext.join() + '}';
	      }
	
	      if (i + 1 === this.impressions.length) {
	        json += '}';
	      } else {
	        json += '},';
	      }
	    }
	
	    json += ']}';
	    return json;
	  };
	
	  OpenRTBRequest.prototype.setPageOverride = function (sitePageOverride) {
	    if (typeof sitePageOverride === 'string' && !sitePageOverride.match(/^\s*$/)) {
	      this.sitePage = sitePageOverride;
	      return true;
	    } else {
	      return false;
	    }
	  };
	
	  OpenRTBRequest.prototype.addImpression = function (width, height, bidFloor, bidFloorCurrency, slotID, siteID) {
	    var impObj = {
	      id: String(this.impressions.length + 1)
	    };
	    if (typeof width !== 'number' || width <= 1) {
	      return null;
	    }
	
	    if (typeof height !== 'number' || height <= 1) {
	      return null;
	    }
	
	    if ((typeof slotID === 'string' || typeof slotID === 'number') && String(slotID).length <= 50) {
	      impObj.slotID = String(slotID);
	    }
	
	    impObj.w = width;
	    impObj.h = height;
	    if (bidFloor !== undefined && typeof bidFloor !== 'number') {
	      return null;
	    }
	
	    if (typeof bidFloor === 'number') {
	      if (bidFloor < 0) {
	        return null;
	      }
	
	      impObj.bidfloor = bidFloor;
	      if (bidFloorCurrency !== undefined && typeof bidFloorCurrency !== 'string') {
	        return null;
	      }
	
	      impObj.bidfloorcur = bidFloorCurrency;
	    }
	
	    if (typeof siteID !== 'undefined') {
	      if (typeof siteID === 'number' && siteID % 1 === 0 && siteID >= 0) {
	        impObj.siteID = siteID;
	      } else {
	        return null;
	      }
	    }
	
	    this.impressions.push(impObj);
	    return impObj.id;
	  };
	
	  OpenRTBRequest.prototype.buildRequest = function () {
	    if (this.impressions.length === 0 || this.initialized !== true) {
	      return;
	    }
	
	    var jsonURI = encodeURIComponent(this.serialize());
	    var scriptSrc = window.location.protocol === 'https:' ? 'https://as-sec.casalemedia.com' : 'http://as.casalemedia.com';
	    scriptSrc += '/headertag?v=9&x3=1&fn=cygnus_index_parse_res&s=' + this.siteID + '&r=' + jsonURI;
	    if (typeof this.timeoutDelay === 'number' && this.timeoutDelay % 1 === 0 && this.timeoutDelay >= 0) {
	      scriptSrc += '&t=' + this.timeoutDelay;
	    }
	
	    return scriptSrc;
	  };
	
	  try {
	    if (typeof cygnus_index_args === 'undefined' || typeof cygnus_index_args.siteID === 'undefined' || typeof cygnus_index_args.slots === 'undefined') {
	      return;
	    }
	
	    if (typeof window._IndexRequestData === 'undefined') {
	      window._IndexRequestData = {};
	      window._IndexRequestData.impIDToSlotID = {};
	      window._IndexRequestData.reqOptions = {};
	    }
	
	    var req = new OpenRTBRequest(cygnus_index_args.siteID, cygnus_index_args.parseFn, cygnus_index_args.timeout);
	    if (cygnus_index_args.url && typeof cygnus_index_args.url === 'string') {
	      req.setPageOverride(cygnus_index_args.url);
	    }
	
	    _IndexRequestData.impIDToSlotID[req.requestID] = {};
	    _IndexRequestData.reqOptions[req.requestID] = {};
	    var slotDef, impID;
	
	    for (var i = 0; i < cygnus_index_args.slots.length; i++) {
	      slotDef = cygnus_index_args.slots[i];
	
	      impID = req.addImpression(slotDef.width, slotDef.height, slotDef.bidfloor, slotDef.bidfloorcur, slotDef.id, slotDef.siteID);
	      if (impID) {
	        _IndexRequestData.impIDToSlotID[req.requestID][impID] = String(slotDef.id);
	      }
	    }
	
	    if (typeof cygnus_index_args.targetMode === 'number') {
	      _IndexRequestData.reqOptions[req.requestID].targetMode = cygnus_index_args.targetMode;
	    }
	
	    if (typeof cygnus_index_args.callback === 'function') {
	      _IndexRequestData.reqOptions[req.requestID].callback = cygnus_index_args.callback;
	    }
	
	    return req.buildRequest();
	  } catch (e) {
	    utils.logError('Error calling index adapter', ADAPTER_NAME, e);
	  }
	};
	
	var IndexExchangeAdapter = function IndexExchangeAdapter() {
	  var slotIdMap = {};
	  var requiredParams = [
	  /* 0 */
	  'id',
	  /* 1 */
	  'siteID'];
	  var firstAdUnitCode = '';
	
	  function _callBids(request) {
	    var bidArr = request.bids;
	
	    if (!utils.hasValidBidRequest(bidArr[0].params, requiredParams, ADAPTER_NAME)) {
	      return;
	    }
	
	    //Our standard is to always bid for all known slots.
	    cygnus_index_args.slots = [];
	
	    var expectedBids = 0;
	
	    //Grab the slot level data for cygnus_index_args
	    for (var i = 0; i < bidArr.length; i++) {
	      var bid = bidArr[i];
	      var sizeID = 0;
	
	      expectedBids++;
	
	      // Expecting nested arrays for sizes
	      if (!(bid.sizes[0] instanceof Array)) {
	        bid.sizes = [bid.sizes];
	      }
	
	      // Create index slots for all bids and sizes
	      for (var j = 0; j < bid.sizes.length; j++) {
	        var validSize = false;
	        for (var k = 0; k < cygnus_index_adunits.length; k++) {
	          if (bid.sizes[j][0] === cygnus_index_adunits[k][0] && bid.sizes[j][1] === cygnus_index_adunits[k][1]) {
	            validSize = true;
	            break;
	          }
	        }
	
	        if (!validSize) {
	          continue;
	        }
	
	        if (bid.params.timeout && typeof cygnus_index_args.timeout === 'undefined') {
	          cygnus_index_args.timeout = bid.params.timeout;
	        }
	
	        var siteID = Number(bid.params.siteID);
	        if (!siteID) {
	          continue;
	        }
	        if (siteID && typeof cygnus_index_args.siteID === 'undefined') {
	          cygnus_index_args.siteID = siteID;
	        }
	
	        if (utils.hasValidBidRequest(bid.params, requiredParams, ADAPTER_NAME)) {
	          firstAdUnitCode = bid.placementCode;
	          var slotID = bid.params[requiredParams[0]];
	          slotIdMap[slotID] = bid;
	
	          sizeID++;
	          var size = {
	            width: bid.sizes[j][0],
	            height: bid.sizes[j][1]
	          };
	
	          var slotName = slotID + '_' + sizeID;
	
	          //Doesn't need the if(primary_request) conditional since we are using the mergeSlotInto function which is safe
	          cygnus_index_args.slots = mergeSlotInto({
	            id: slotName,
	            width: size.width,
	            height: size.height,
	            siteID: siteID || cygnus_index_args.siteID
	          }, cygnus_index_args.slots);
	
	          if (bid.params.tier2SiteID) {
	            var tier2SiteID = Number(bid.params.tier2SiteID);
	            if (typeof tier2SiteID !== 'undefined' && !tier2SiteID) {
	              continue;
	            }
	
	            cygnus_index_args.slots = mergeSlotInto({
	              id: 'T1_' + slotName,
	              width: size.width,
	              height: size.height,
	              siteID: tier2SiteID
	            }, cygnus_index_args.slots);
	          }
	
	          if (bid.params.tier3SiteID) {
	            var tier3SiteID = Number(bid.params.tier3SiteID);
	            if (typeof tier3SiteID !== 'undefined' && !tier3SiteID) {
	              continue;
	            }
	
	            cygnus_index_args.slots = mergeSlotInto({
	              id: 'T2_' + slotName,
	              width: size.width,
	              height: size.height,
	              siteID: tier3SiteID
	            }, cygnus_index_args.slots);
	          }
	        }
	      }
	    }
	
	    if (cygnus_index_args.slots.length > 20) {
	      utils.logError('Too many unique sizes on slots, will use the first 20.', ADAPTER_NAME);
	    }
	
	    //bidmanager.setExpectedBidsCount(ADAPTER_CODE, expectedBids);
	    adloader.loadScript(cygnus_index_start());
	
	    var responded = false;
	
	    // Handle response
	    window.cygnus_index_ready_state = function () {
	      if (responded) {
	        return;
	      }
	      responded = true;
	
	      try {
	        var indexObj = _IndexRequestData.targetIDToBid;
	        var lookupObj = cygnus_index_args;
	
	        // Grab all the bids for each slot
	        for (var adSlotId in slotIdMap) {
	          var bidObj = slotIdMap[adSlotId];
	          var adUnitCode = bidObj.placementCode;
	
	          var bids = [];
	
	          // Grab the bid for current slot
	          for (var cpmAndSlotId in indexObj) {
	            var match = /(T\d_)?(.+)_(\d+)_(\d+)/.exec(cpmAndSlotId);
	            var tier = match[1] || '';
	            var slotID = match[2];
	            var sizeID = match[3];
	            var currentCPM = match[4];
	
	            var slotName = slotID + '_' + sizeID;
	            var slotObj = getSlotObj(cygnus_index_args, tier + slotName);
	
	            // Bid is for the current slot
	            if (slotID === adSlotId) {
	              var bid = bidfactory.createBid(1);
	              bid.cpm = currentCPM / 100;
	              bid.ad = indexObj[cpmAndSlotId][0];
	              bid.ad_id = adSlotId;
	              bid.bidderCode = ADAPTER_CODE;
	              bid.width = slotObj.width;
	              bid.height = slotObj.height;
	              bid.siteID = slotObj.siteID;
	
	              bids.push(bid);
	            }
	          }
	
	          var currentBid = undefined;
	
	          //Pick the highest bidding price for this slot
	          if (bids.length > 0) {
	            // Choose the highest bid
	            for (var i = 0; i < bids.length; i++) {
	              var bid = bids[i];
	              if (typeof currentBid === 'undefined') {
	                currentBid = bid;
	                continue;
	              }
	
	              if (bid.cpm > currentBid.cpm) {
	                currentBid = bid;
	              }
	            }
	
	            // No bids for expected bid, pass bid
	          } else {
	            var bid = bidfactory.createBid(2);
	            bid.bidderCode = ADAPTER_CODE;
	            currentBid = bid;
	          }
	
	          bidmanager.addBidResponse(adUnitCode, currentBid);
	        }
	      } catch (e) {
	        utils.logError('Error calling index adapter', ADAPTER_NAME, e);
	        logErrorBidResponse();
	      } finally {
	        // ensure that previous targeting mapping is cleared
	        _IndexRequestData.targetIDToBid = {};
	      }
	
	      //slotIdMap is used to determine which slots will be bid on in a given request.
	      //Therefore it needs to be blanked after the request is handled, else we will submit 'bids' for the wrong ads.
	      slotIdMap = {};
	    };
	  }
	
	  /*
	  Function in order to add a slot into the list if it hasn't been created yet, else it returns the same list.
	  */
	  function mergeSlotInto(slot, slotList) {
	    for (var i = 0; i < slotList.length; i++) {
	      if (slot.id === slotList[i].id) {
	        return slotList;
	      }
	    }
	    slotList.push(slot);
	    return slotList;
	  }
	
	  function getSlotObj(obj, id) {
	    var arr = obj.slots;
	    var returnObj = {};
	    utils._each(arr, function (value) {
	      if (value.id === id) {
	        returnObj = value;
	      }
	    });
	
	    return returnObj;
	  }
	
	  function logErrorBidResponse() {
	    //no bid response
	    var bid = bidfactory.createBid(2);
	    bid.bidderCode = ADAPTER_CODE;
	
	    //log error to first add unit
	    bidmanager.addBidResponse(firstAdUnitCode, bid);
	  }
	
	  return {
	    callBids: _callBids
	  };
	};
	
	module.exports = IndexExchangeAdapter;

/***/ },
/* 21 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var bidfactory = __webpack_require__(9);
	var bidmanager = __webpack_require__(4);
	var adloader = __webpack_require__(10);
	
	function _qs(key, value) {
	  return encodeURIComponent(key) + '=' + encodeURIComponent(value);
	}
	
	function _makeBidResponse(placementCode, bid) {
	  var bidResponse = bidfactory.createBid(bid !== undefined ? 1 : 2);
	  bidResponse.bidderCode = 'kruxlink';
	  if (bid !== undefined) {
	    bidResponse.cpm = bid.price;
	    bidResponse.ad = bid.adm;
	    bidResponse.width = bid.w;
	    bidResponse.height = bid.h;
	  }
	  bidmanager.addBidResponse(placementCode, bidResponse);
	}
	
	function _makeCallback(id, placements) {
	  var callback = '_kruxlink_' + id;
	  pbjs[callback] = function (response) {
	    // Clean up our callback
	    delete pbjs[callback];
	
	    // Add in the bid respones
	    for (var i = 0; i < response.seatbid.length; i++) {
	      var seatbid = response.seatbid[i];
	      for (var j = 0; j < seatbid.bid.length; j++) {
	        var bid = seatbid.bid[j];
	        _makeBidResponse(placements[bid.impid], bid);
	        delete placements[bid.impid];
	      }
	    }
	
	    // Add any no-bids remaining
	    for (var placementCode in placements) {
	      if (placements.hasOwnProperty(placementCode)) {
	        _makeBidResponse(placementCode);
	      }
	    }
	  };
	
	  return 'pbjs.' + callback;
	}
	
	function _callBids(params) {
	  var impids = [];
	  var placements = {};
	
	  var bids = params.bids || [];
	  for (var i = 0; i < bids.length; i++) {
	    var bidRequest = bids[i];
	    var bidRequestParams = bidRequest.params || {};
	    var impid = bidRequestParams.impid;
	    placements[impid] = bidRequest.placementCode;
	
	    impids.push(impid);
	  }
	
	  var callback = _makeCallback(params.bidderRequestId, placements);
	  var qs = [_qs('id', params.bidderRequestId), _qs('u', window.location.href), _qs('impid', impids.join(',')), _qs('calltype', 'pbd'), _qs('callback', callback)];
	  var url = 'https://link.krxd.net/hb?' + qs.join('&');
	
	  adloader.loadScript(url);
	}
	
	module.exports = function KruxAdapter() {
	  return {
	    callBids: _callBids
	  };
	};

/***/ },
/* 22 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	// jshint ignore:start
	var bidfactory = __webpack_require__(9);
	var bidmanager = __webpack_require__(4);
	var adloader = __webpack_require__(10);
	
	/**
	 * Adapter for requesting bids from OpenX.
	 *
	 * @param {Object} options - Configuration options for OpenX
	 * @param {string} options.pageURL - Current page URL to send with bid request
	 * @param {string} options.refererURL - Referer URL to send with bid request
	 *
	 * @returns {{callBids: _callBids}}
	 * @constructor
	 */
	var OpenxAdapter = function OpenxAdapter(options) {
	
	  var opts = options || {};
	  var scriptUrl;
	  var bids;
	
	  function _callBids(params) {
	    bids = params.bids || [];
	    for (var i = 0; i < bids.length; i++) {
	      var bid = bids[i];
	
	      //load page options from bid request
	      if (bid.params.pageURL) {
	        opts.pageURL = bid.params.pageURL;
	      }
	
	      if (bid.params.refererURL) {
	        opts.refererURL = bid.params.refererURL;
	      }
	
	      if (bid.params.jstag_url) {
	        scriptUrl = bid.params.jstag_url;
	      }
	
	      if (bid.params.pgid) {
	        opts.pgid = bid.params.pgid;
	      }
	    }
	
	    _requestBids();
	  }
	
	  function _requestBids() {
	
	    if (scriptUrl) {
	      adloader.loadScript(scriptUrl, function () {
	        var i;
	        var POX = OX();
	
	        if (opts.pageURL) {
	          POX.setPageURL(opts.pageURL);
	        }
	
	        if (opts.refererURL) {
	          POX.setRefererURL(opts.refererURL);
	        }
	
	        if (opts.pgid) {
	          POX.addPage(opts.pgid);
	        }
	
	        // Add each ad unit ID
	        for (i = 0; i < bids.length; i++) {
	          POX.addAdUnit(bids[i].params.unit);
	        }
	
	        POX.addHook(function (response) {
	          var i;
	          var bid;
	          var adUnit;
	          var adResponse;
	
	          // Map each bid to its response
	          for (i = 0; i < bids.length; i++) {
	            bid = bids[i];
	
	            // Get ad response
	            adUnit = response.getOrCreateAdUnit(bid.params.unit);
	
	            // If 'pub_rev' (CPM) isn't returned we got an empty response
	            if (adUnit.get('pub_rev')) {
	              adResponse = adResponse = bidfactory.createBid(1);
	
	              adResponse.bidderCode = 'openx';
	              adResponse.ad_id = adUnit.get('ad_id');
	              adResponse.cpm = Number(adUnit.get('pub_rev')) / 1000;
	
	              adResponse.ad = adUnit.get('html');
	
	              // Add record/impression pixel to the creative HTML
	              var recordPixel = OX.utils.template(response.getRecordTemplate(), {
	                medium: OX.utils.getMedium(),
	                rtype: OX.Resources.RI,
	                txn_state: adUnit.get('ts')
	              });
	              adResponse.ad += '<div style="position:absolute;left:0px;top:0px;visibility:hidden;"><img src="' + recordPixel + '"></div>';
	
	              adResponse.adUrl = adUnit.get('ad_url');
	              adResponse.width = adUnit.get('width');
	              adResponse.height = adUnit.get('height');
	
	              bidmanager.addBidResponse(bid.placementCode, adResponse);
	            } else {
	              // Indicate an ad was not returned
	              adResponse = bidfactory.createBid(2);
	              adResponse.bidderCode = 'openx';
	              bidmanager.addBidResponse(bid.placementCode, adResponse);
	            }
	          }
	        }, OX.Hooks.ON_AD_RESPONSE);
	
	        // Make request
	        POX.load();
	      }, true);
	    }
	  }
	
	  return {
	    callBids: _callBids
	  };
	};
	
	module.exports = OpenxAdapter;

/***/ },
/* 23 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var utils = __webpack_require__(1);
	var bidfactory = __webpack_require__(9);
	var bidmanager = __webpack_require__(4);
	
	/**
	 * Adapter for requesting bids from Pubmatic.
	 *
	 * @returns {{callBids: _callBids}}
	 * @constructor
	 */
	var PubmaticAdapter = function PubmaticAdapter() {
	
	  var bids;
	  var _pm_pub_id;
	  var _pm_optimize_adslots = [];
	  var iframe = void 0;
	
	  function _callBids(params) {
	    bids = params.bids;
	    for (var i = 0; i < bids.length; i++) {
	      var bid = bids[i];
	      //bidmanager.pbCallbackMap['' + bid.params.adSlot] = bid;
	      _pm_pub_id = _pm_pub_id || bid.params.publisherId;
	      _pm_optimize_adslots.push(bid.params.adSlot);
	    }
	
	    // Load pubmatic script in an iframe, because they call document.write
	    _getBids();
	  }
	
	  function _getBids() {
	
	    //create the iframe
	    iframe = utils.createInvisibleIframe();
	
	    var elToAppend = document.getElementsByTagName('head')[0];
	
	    //insert the iframe into document
	    elToAppend.insertBefore(iframe, elToAppend.firstChild);
	
	    var iframeDoc = utils.getIframeDocument(iframe);
	    iframeDoc.write(_createRequestContent());
	    iframeDoc.close();
	  }
	
	  function _createRequestContent() {
	    var content = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"' + ' "http://www.w3.org/TR/html4/loose.dtd"><html><head><base target="_top" /><scr' + 'ipt>inDapIF=true;</scr' + 'ipt></head>';
	    content += '<body>';
	    content += '<scr' + 'ipt>';
	    content += '' + 'window.pm_pub_id  = "%%PM_PUB_ID%%";' + 'window.pm_optimize_adslots     = [%%PM_OPTIMIZE_ADSLOTS%%];' + 'window.pm_async_callback_fn = "window.parent.pbjs.handlePubmaticCallback";';
	    content += '</scr' + 'ipt>';
	
	    var map = {};
	    map.PM_PUB_ID = _pm_pub_id;
	    map.PM_OPTIMIZE_ADSLOTS = _pm_optimize_adslots.map(function (adSlot) {
	      return "'" + adSlot + "'";
	    }).join(',');
	
	    content += '<scr' + 'ipt src="https://ads.pubmatic.com/AdServer/js/gshowad.js"></scr' + 'ipt>';
	    content += '<scr' + 'ipt>';
	    content += '</scr' + 'ipt>';
	    content += '</body></html>';
	    content = utils.replaceTokenInString(content, map, '%%');
	
	    return content;
	  }
	
	  pbjs.handlePubmaticCallback = function () {
	    var bidDetailsMap = {};
	    var progKeyValueMap = {};
	    try {
	      bidDetailsMap = iframe.contentWindow.bidDetailsMap;
	      progKeyValueMap = iframe.contentWindow.progKeyValueMap;
	    } catch (e) {
	      utils.logError(e, 'Error parsing Pubmatic response');
	    }
	
	    var i;
	    var adUnit;
	    var adUnitInfo;
	    var bid;
	    var bidResponseMap = bidDetailsMap;
	    var bidInfoMap = progKeyValueMap;
	    var dimensions;
	
	    for (i = 0; i < bids.length; i++) {
	      var adResponse;
	      bid = bids[i].params;
	
	      adUnit = bidResponseMap[bid.adSlot] || {};
	
	      // adUnitInfo example: bidstatus=0;bid=0.0000;bidid=39620189@320x50;wdeal=
	
	      // if using DFP GPT, the params string comes in the format:
	      // "bidstatus;1;bid;5.0000;bidid;hb_test@468x60;wdeal;"
	      // the code below detects and handles this.
	      if (bidInfoMap[bid.adSlot] && bidInfoMap[bid.adSlot].indexOf('=') === -1) {
	        bidInfoMap[bid.adSlot] = bidInfoMap[bid.adSlot].replace(/([a-z]+);(.[^;]*)/ig, '$1=$2');
	      }
	
	      adUnitInfo = (bidInfoMap[bid.adSlot] || '').split(';').reduce(function (result, pair) {
	        var parts = pair.split('=');
	        result[parts[0]] = parts[1];
	        return result;
	      }, {});
	
	      if (adUnitInfo.bidstatus === '1') {
	        dimensions = adUnitInfo.bidid.split('@')[1].split('x');
	        adResponse = bidfactory.createBid(1);
	        adResponse.bidderCode = 'pubmatic';
	        adResponse.adSlot = bid.adSlot;
	        adResponse.cpm = Number(adUnitInfo.bid);
	        adResponse.ad = unescape(adUnit.creative_tag); // jshint ignore:line
	        adResponse.ad += utils.createTrackPixelHtml(decodeURIComponent(adUnit.tracking_url));
	        adResponse.width = dimensions[0];
	        adResponse.height = dimensions[1];
	        adResponse.dealId = adUnitInfo.wdeal;
	
	        bidmanager.addBidResponse(bids[i].placementCode, adResponse);
	      } else {
	        // Indicate an ad was not returned
	        adResponse = bidfactory.createBid(2);
	        adResponse.bidderCode = 'pubmatic';
	        bidmanager.addBidResponse(bids[i].placementCode, adResponse);
	      }
	    }
	  };
	
	  return {
	    callBids: _callBids
	  };
	};
	
	module.exports = PubmaticAdapter;

/***/ },
/* 24 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var bidfactory = __webpack_require__(9);
	var bidmanager = __webpack_require__(4);
	var adloader = __webpack_require__(10);
	
	var PulsePointAdapter = function PulsePointAdapter() {
	
	  var getJsStaticUrl = window.location.protocol + '//tag.contextweb.com/getjs.static.js';
	  var bidUrl = window.location.protocol + '//bid.contextweb.com/header/tag';
	
	  function _callBids(params) {
	    if (typeof window.pp === 'undefined') {
	      adloader.loadScript(getJsStaticUrl, function () {
	        bid(params);
	      }, true);
	    } else {
	      bid(params);
	    }
	  }
	
	  function bid(params) {
	    var bids = params.bids;
	    for (var i = 0; i < bids.length; i++) {
	      var bidRequest = bids[i];
	      var callback = bidResponseCallback(bidRequest);
	      var ppBidRequest = new window.pp.Ad({
	        cf: bidRequest.params.cf,
	        cp: bidRequest.params.cp,
	        ct: bidRequest.params.ct,
	        cn: 1,
	        ca: window.pp.requestActions.BID,
	        cu: bidUrl,
	        adUnitId: bidRequest.placementCode,
	        callback: callback
	      });
	      ppBidRequest.display();
	    }
	  }
	
	  function bidResponseCallback(bid) {
	    return function (bidResponse) {
	      bidResponseAvailable(bid, bidResponse);
	    };
	  }
	
	  function bidResponseAvailable(bidRequest, bidResponse) {
	    if (bidResponse) {
	      var adSize = bidRequest.params.cf.toUpperCase().split('X');
	      var bid = bidfactory.createBid(1);
	      bid.bidderCode = bidRequest.bidder;
	      bid.cpm = bidResponse.bidCpm;
	      bid.ad = bidResponse.html;
	      bid.width = adSize[0];
	      bid.height = adSize[1];
	      bidmanager.addBidResponse(bidRequest.placementCode, bid);
	    } else {
	      var passback = bidfactory.createBid(2);
	      passback.bidderCode = bidRequest.bidder;
	      bidmanager.addBidResponse(bidRequest.placementCode, passback);
	    }
	  }
	
	  return {
	    callBids: _callBids
	  };
	};
	
	module.exports = PulsePointAdapter;

/***/ },
/* 25 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	/**
	 * @file Rubicon (Rubicon) adapter
	 */
	
	// jshint ignore:start
	var utils = __webpack_require__(1);
	var bidmanager = __webpack_require__(4);
	var bidfactory = __webpack_require__(9);
	var adloader = __webpack_require__(10);
	
	/**
	 * @class RubiconAdapter
	 * Prebid adapter for Rubicon's header bidding client
	 */
	var RubiconAdapter = function RubiconAdapter() {
	  var RUBICONTAG_URL = window.location.protocol + '//ads.rubiconproject.com/header/';
	  var RUBICON_OK_STATUS = 'ok';
	  var RUBICON_BIDDER_CODE = 'rubicon';
	  var RUBICON_SIZE_MAP = {
	    '468x60': 1,
	    '728x90': 2,
	    '120x600': 8,
	    '160x600': 9,
	    '300x600': 10,
	    '300x250': 15,
	    '336x280': 16,
	    '320x50': 43,
	    '300x50': 44,
	    '300x1050': 54,
	    '970x90': 55,
	    '970x250': 57,
	    '1000x90': 58,
	    '320x480': 67,
	    '1800x1000': 68,
	    '480x320': 101,
	    '768x1024': 102,
	    '1000x300': 113,
	    '320x100': 117
	  };
	  var RUBICON_INITIALIZED = window.rubicontag === undefined ? 0 : 1;
	
	  // the fastlane creative code
	  var RUBICON_CREATIVE_START = '<script type="text/javascript">;(function (rt, fe) { rt.renderCreative(fe, "';
	  var RUBICON_CREATIVE_END = '"); }((parent.window.rubicontag || window.top.rubicontag), (document.body || document.documentElement)));</script>';
	
	  // pre-initialize the rubicon object
	  // needs to be attached to the window
	  window.rubicontag = window.rubicontag || {};
	  window.rubicontag.cmd = window.rubicontag.cmd || [];
	
	  // timestamp for logging
	  var _bidStart = null;
	  var bidCount = 0;
	
	  /**
	   * Create an error bid
	   * @param {String} placement - the adunit path
	   * @param {Object} response - the (error) response from fastlane
	   * @return {Bid} a bid, for prebid
	   */
	  function _errorBid(response, ads) {
	    var bidResponse = bidfactory.createBid(2, response.bid);
	    bidResponse.bidderCode = RUBICON_BIDDER_CODE;
	
	    // use the raw ads as the 'error'
	    bidResponse.error = ads;
	    return bidResponse;
	  }
	
	  /**
	   * Sort function for CPM
	   * @param {Object} adA
	   * @param {Object} adB
	   * @return {Float} sort order value
	   */
	  function _adCpmSort(adA, adB) {
	    return (adB.cpm || 0.0) - (adA.cpm || 0.0);
	  }
	
	  /**
	   * Produce the code to render a creative
	   * @param {String} elemId the element passed to rubicon; this is essentially the ad-id
	   * @param {Array<Integer,Integer>} size array of width, height
	   * @return {String} creative
	   */
	  function _creative(elemId, size) {
	
	    // convert the size to a rubicon sizeId
	    var sizeId = RUBICON_SIZE_MAP[size.join('x')];
	
	    if (!sizeId) {
	      utils.logError('fastlane: missing sizeId for size: ' + size.join('x') + ' could not render creative', RUBICON_BIDDER_CODE, RUBICON_SIZE_MAP);
	      return '';
	    }
	
	    return RUBICON_CREATIVE_START + elemId + '", "' + sizeId + RUBICON_CREATIVE_END;
	  }
	
	  /**
	   * Create (successful) bids for a unit,
	   * based on the given response
	   * @param {String} placement placement code/unit path
	   * @param {Object} response the response from rubicon
	   * @return {Bid} a bid objectj
	   */
	  function _makeBids(response, ads) {
	
	    // if there are multiple ads, sort by CPM
	    ads = ads.sort(_adCpmSort);
	
	    var bidResponses = [];
	
	    ads.forEach(function (ad) {
	
	      var bidResponse,
	          size = ad.dimensions;
	
	      if (!size) {
	        // this really shouldn't happen
	        utils.logError('no dimensions given', RUBICON_BIDDER_CODE, ad);
	        bidResponse = _errorBid(response, ads);
	      } else {
	        bidResponse = bidfactory.createBid(1, response.bid);
	
	        bidResponse.bidderCode = RUBICON_BIDDER_CODE;
	        bidResponse.cpm = ad.cpm;
	
	        // the element id is what the iframe will use to render
	        // itself using the rubicontag.renderCreative API
	        bidResponse.ad = _creative(response.getElementId(), size);
	        bidResponse.width = size[0];
	        bidResponse.height = size[1];
	
	        // DealId
	        if (ad.deal) {
	          bidResponse.dealId = ad.deal;
	        }
	      }
	
	      bidResponses.push(bidResponse);
	    });
	
	    return bidResponses;
	  }
	
	  /**
	   * Add success/error bids based
	   * on the response from rubicon
	   * @param {Object} response -- AJAX response from fastlane
	   */
	  function _addBids(response, ads) {
	    // get the bid for the placement code
	    var bids;
	    if (!ads || ads.length === 0) {
	      bids = [_errorBid(response, ads)];
	    } else {
	      bids = _makeBids(response, ads);
	    }
	
	    bids.forEach(function (bid) {
	      bidmanager.addBidResponse(response.getElementId(), bid);
	    });
	  }
	
	  /**
	   * Helper to queue functions on rubicontag
	   * ready/available
	   * @param {Function} callback
	   */
	  function _rready(callback) {
	    window.rubicontag.cmd.push(callback);
	  }
	
	  /**
	   * download the rubicontag sdk
	   * @param {Object} options
	   * @param {String} options.accountId
	   * @param {Function} callback
	   */
	  function _initSDK(options, done) {
	    if (RUBICON_INITIALIZED) {
	      return;
	    }
	
	    RUBICON_INITIALIZED = 1;
	
	    var accountId = options.accountId;
	    var scripttUrl = RUBICONTAG_URL + accountId + '.js';
	
	    adloader.loadScript(scripttUrl, done, true);
	  }
	
	  /**
	   * map the sizes in `bid.sizes` to Rubicon specific keys
	   * @param  {object} array of bids
	   * @return {[type]}      [description]
	   */
	  function _mapSizes(bids) {
	    utils._each(bids, function (bid) {
	      if (bid.params.sizes) {
	        return;
	      }
	
	      //return array like ['300x250', '728x90']
	      var parsedSizes = utils.parseSizesInput(bid.sizes);
	
	      //iterate the bid.sizes array to lookup codes
	      var tempSize = [];
	      for (var i = 0; i < parsedSizes.length; i++) {
	        var rubiconKey = RUBICON_SIZE_MAP[parsedSizes[i]];
	        if (rubiconKey) {
	          tempSize.push(rubiconKey);
	        }
	      }
	
	      bid.params.sizes = tempSize;
	    });
	  }
	
	  /**
	   * Define the slot using the rubicontag.defineSlot API
	   * @param {Object} bid
	   * @returns {RubiconSlot} Instance of RubiconSlot
	   */
	  function _defineSlot(bid) {
	    var userId = bid.params.userId;
	    var position = bid.params.position;
	    var visitor = bid.params.visitor || [];
	    var keywords = bid.params.keywords || [];
	    var inventory = bid.params.inventory || [];
	    var slot = window.rubicontag.defineSlot({
	      siteId: bid.params.siteId,
	      zoneId: bid.params.zoneId,
	      sizes: bid.params.sizes,
	      id: bid.placementCode
	    });
	
	    slot.clearTargeting();
	
	    if (userId) {
	      window.rubicontag.setUserKey(userId);
	    }
	
	    if (position) {
	      slot.setPosition(position);
	    }
	
	    for (var key in visitor) {
	      if (visitor.hasOwnProperty(key)) {
	        slot.addFPV(key, visitor[key]);
	      }
	    }
	
	    for (var key in inventory) {
	      if (inventory.hasOwnProperty(key)) {
	        slot.addFPI(key, inventory[key]);
	      }
	    }
	
	    slot.addKW(keywords);
	
	    slot.bid = bid;
	
	    return slot;
	  }
	
	  /**
	   * Handle the bids received (from rubicon)
	   * @param {array} slots
	   */
	  function _bidsReady(slots) {
	    // NOTE: we don't really need to do anything,
	    // because right now we're shimming XMLHttpRequest.open,
	    // but in the future we'll get data from rubicontag here
	    utils.logMessage('Rubicon Project bidding complete: ' + (new Date().getTime() - _bidStart));
	
	    utils._each(slots, function (slot) {
	      _addBids(slot, slot.getRawResponses());
	    });
	  }
	
	  /**
	   * Request the specified bids from
	   * Rubicon
	   * @param {Object} params the bidder-level params (from prebid)
	   * @param {Array} params.bids the bids requested
	   */
	  function _callBids(params) {
	
	    // start the timer; want to measure from
	    // even just loading the SDK
	    _bidStart = new Date().getTime();
	
	    _mapSizes(params.bids);
	
	    if (utils.isEmpty(params.bids)) {
	      return;
	    }
	
	    // on the first bid, set up the SDK
	    if (!RUBICON_INITIALIZED) {
	      _initSDK(params.bids[0].params);
	    }
	
	    _rready(function () {
	      var slots = [];
	      var bids = params.bids;
	
	      for (var i = 0, ln = bids.length; i < ln; i++) {
	        slots.push(_defineSlot(bids[i]));
	      }
	
	      var parameters = { slots: slots };
	      var callback = function callback() {
	        _bidsReady(slots);
	      };
	
	      window.rubicontag.setIntegration('pbjs');
	      window.rubicontag.run(callback, parameters);
	    });
	  }
	
	  return {
	    /**
	     * @public callBids
	     * the interface to Prebid
	     */
	    callBids: _callBids
	  };
	};
	
	module.exports = RubiconAdapter;

/***/ },
/* 26 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var _utils = __webpack_require__(1);
	
	var CONSTANTS = __webpack_require__(2);
	var utils = __webpack_require__(1);
	var bidfactory = __webpack_require__(9);
	var bidmanager = __webpack_require__(4);
	
	var SekindoAdapter;
	SekindoAdapter = function SekindoAdapter() {
	
	  function _callBids(params) {
	    var bids = params.bids;
	    var bidsCount = bids.length;
	
	    var pubUrl = null;
	    if (parent !== window) pubUrl = document.referrer;else pubUrl = window.location.href;
	
	    for (var i = 0; i < bidsCount; i++) {
	      var bidReqeust = bids[i];
	      var callbackId = bidReqeust.bidId;
	      _requestBids(bidReqeust, callbackId, pubUrl);
	      //store a reference to the bidRequest from the callback id
	      //bidmanager.pbCallbackMap[callbackId] = bidReqeust;
	    }
	  }
	
	  pbjs.sekindoCB = function (callbackId, response) {
	    var bidObj = (0, _utils.getBidRequest)(callbackId);
	    if (typeof response !== 'undefined' && typeof response.cpm !== 'undefined') {
	      var bid = [];
	      if (bidObj) {
	        var bidCode = bidObj.bidder;
	        var placementCode = bidObj.placementCode;
	
	        if (response.cpm !== undefined && response.cpm > 0) {
	
	          bid = bidfactory.createBid(CONSTANTS.STATUS.GOOD);
	          bid.adId = response.adId;
	          bid.callback_uid = callbackId;
	          bid.bidderCode = bidCode;
	          bid.creative_id = response.adId;
	          bid.cpm = parseFloat(response.cpm);
	          bid.ad = response.ad;
	          bid.width = response.width;
	          bid.height = response.height;
	
	          bidmanager.addBidResponse(placementCode, bid);
	        } else {
	          bid = bidfactory.createBid(CONSTANTS.STATUS.NO_BID);
	          bid.callback_uid = callbackId;
	          bid.bidderCode = bidCode;
	          bidmanager.addBidResponse(placementCode, bid);
	        }
	      }
	    } else {
	      if (bidObj) {
	        utils.logMessage('No prebid response for placement ' + bidObj.placementCode);
	      } else {
	        utils.logMessage('sekindo callback general error');
	      }
	    }
	  };
	
	  function _requestBids(bid, callbackId, pubUrl) {
	    //determine tag params
	    var spaceId = utils.getBidIdParamater('spaceId', bid.params);
	    var bidfloor = utils.getBidIdParamater('bidfloor', bid.params);
	    var protocol = 'https:' === document.location.protocol ? 's' : '';
	    var scriptSrc = 'https://live.sekindo.com/live/liveView.php?';
	
	    scriptSrc = utils.tryAppendQueryString(scriptSrc, 's', spaceId);
	    scriptSrc = utils.tryAppendQueryString(scriptSrc, 'pubUrl', pubUrl);
	    scriptSrc = utils.tryAppendQueryString(scriptSrc, 'hbcb', callbackId);
	    scriptSrc = utils.tryAppendQueryString(scriptSrc, 'dcpmflr', bidfloor);
	    scriptSrc = utils.tryAppendQueryString(scriptSrc, 'hbto', pbjs.bidderTimeout);
	    scriptSrc = utils.tryAppendQueryString(scriptSrc, 'protocol', protocol);
	
	    var html = '<scr' + 'ipt type="text/javascript" src="' + scriptSrc + '"></scr' + 'ipt>';
	
	    var iframe = utils.createInvisibleIframe();
	    iframe.id = 'skIfr_' + callbackId;
	
	    var elToAppend = document.getElementsByTagName('head')[0];
	    //insert the iframe into document
	    elToAppend.insertBefore(iframe, elToAppend.firstChild);
	
	    var iframeDoc = utils.getIframeDocument(iframe);
	    iframeDoc.open();
	    iframeDoc.write(html);
	    iframeDoc.close();
	  }
	
	  return {
	    callBids: _callBids
	  };
	};
	
	module.exports = SekindoAdapter;

/***/ },
/* 27 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var bidfactory = __webpack_require__(9);
	var bidmanager = __webpack_require__(4);
	var adloader = __webpack_require__(10);
	var utils = __webpack_require__(1);
	
	var SonobiAdapter = function SonobiAdapter() {
	  var test = false; //  tag tester = true || false
	  var cb_map = {};
	
	  function _phone_in(params) {
	    var trinity = 'https://apex.go.sonobi.com/trinity.js?key_maker=';
	    var bids = params.bids || [];
	    adloader.loadScript(trinity + JSON.stringify(_keymaker(bids)) + '&cv=' + _operator());
	  }
	
	  function _keymaker(bids) {
	    //  Make keys
	    var keyring = {};
	    utils._each(bids, function (o) {
	      var sizes = utils.parseSizesInput(o.sizes).toString();
	      if (utils.isEmpty(sizes)) {
	        utils.logWarn('Sonobi adapter expects sizes for ' + o.placementCode);
	      }
	      switch (true) {
	        case !o.params.ad_unit && !o.params.placement_id:
	          utils.logError('Sonobi unable to bid: Missing parameters for ' + o.placementCode);
	          break;
	        case !!o.params.ad_unit && !!o.params.placement_id:
	          utils.logError('Sonobi unable to bid: Extra parameters for ' + o.placementCode);
	          break;
	        case !!o.params.ad_unit && o.params.ad_unit.length === 0:
	          utils.logError('Sonobi unable to bid: Empty ad_unit for ' + o.placementCode);
	          break;
	        case !!o.params.placement_id && o.params.placement_id.length === 0:
	          utils.logError('Sonobi unable to bid: Empty placement_id for ' + o.placementCode);
	          break;
	        case !!o.params.placement_id:
	          //  Morpeus style
	          keyring[o.params.dom_id] = o.params.placement_id + (test ? '-test' : '') + '|' + sizes;
	          cb_map[o.params.dom_id] = o.placementCode;
	          break;
	        case !!o.params.ad_unit && o.params.ad_unit.charAt(0) !== '/':
	          //  DFP docs do not necessarily require leading slash? - add it in if it's not there.
	          o.params.ad_unit = '/' + o.params.ad_unit;
	        /* falls through */
	        case !!o.params.ad_unit:
	          // Cypher style
	          keyring[o.params.ad_unit + '|' + o.params.dom_id] = sizes;
	          cb_map[o.params.ad_unit + '|' + o.params.dom_id] = o.placementCode;
	          break;
	        default:
	          // I don't know how it's broken, but it is.
	          utils.logError('Sonobi unable to bid: Improper parameters for ' + o.placementCode);
	      }
	    });
	    return keyring;
	  }
	
	  function _operator() {
	    //  Uniqify callbacks
	    var uniq = "cb" + utils.getUniqueIdentifierStr();
	    window[uniq] = _trinity;
	    return uniq;
	  }
	
	  function _trinity(response) {
	    //  Callback
	    var slots = response.slots || {};
	    var sbi_dc = response.sbi_dc || '';
	    var bidObject = {};
	    for (var slot in slots) {
	      if (slots[slot].sbi_aid) {
	        bidObject = bidfactory.createBid(1);
	        bidObject.bidderCode = 'sonobi';
	        bidObject.cpm = Number(slots[slot].sbi_mouse);
	        bidObject.ad = _get_creative(sbi_dc, slots[slot].sbi_aid);
	        bidObject.width = Number(slots[slot].sbi_size.split('x')[0]);
	        bidObject.height = Number(slots[slot].sbi_size.split('x')[1]);
	        bidmanager.addBidResponse(cb_map[slot], bidObject);
	      } else {
	        //  No aid? No ad.
	        bidObject = bidfactory.createBid(2);
	        bidObject.bidderCode = 'sonobi';
	        bidmanager.addBidResponse(cb_map[slot], bidObject);
	      }
	    }
	  }
	
	  function _get_creative(sbi_dc, sbi_aid) {
	    var creative = '<scr' + 'ipt type="text/javascript"src="https://' + sbi_dc;
	    creative += 'apex.go.sonobi.com/sbi.js?as=dfps&aid=' + sbi_aid;
	    creative += '"></scr' + 'ipt>';
	    return creative;
	  }
	
	  return { callBids: _phone_in };
	};
	
	module.exports = SonobiAdapter;

/***/ },
/* 28 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var CONSTANTS = __webpack_require__(2);
	var utils = __webpack_require__(1);
	var bidfactory = __webpack_require__(9);
	var bidmanager = __webpack_require__(4);
	var adloader = __webpack_require__(10);
	
	/**
	 * Adapter for requesting bids from Sovrn
	 */
	var SovrnAdapter = function SovrnAdapter() {
	  var sovrnUrl = 'ap.lijit.com/rtb/bid';
	
	  function _callBids(params) {
	    var sovrnBids = params.bids || [];
	
	    _requestBids(sovrnBids);
	  }
	
	  function _requestBids(bidReqs) {
	    // build bid request object
	    var domain = window.location.host;
	    var page = window.location.pathname + location.search + location.hash;
	
	    var sovrnImps = [];
	
	    //build impression array for sovrn
	    utils._each(bidReqs, function (bid) {
	      var tagId = utils.getBidIdParamater('tagid', bid.params);
	      var bidFloor = utils.getBidIdParamater('bidfloor', bid.params);
	      var adW = 0;
	      var adH = 0;
	
	      //sovrn supports only one size per tagid, so we just take the first size if there are more
	      //if we are a 2 item array of 2 numbers, we must be a SingleSize array
	      var bidSizes = Array.isArray(bid.params.sizes) ? bid.params.sizes : bid.sizes;
	      var sizeArrayLength = bidSizes.length;
	      if (sizeArrayLength === 2 && typeof bidSizes[0] === 'number' && typeof bidSizes[1] === 'number') {
	        adW = bidSizes[0];
	        adH = bidSizes[1];
	      } else {
	        adW = bidSizes[0][0];
	        adH = bidSizes[0][1];
	      }
	
	      var imp = {
	        id: bid.bidId,
	        banner: {
	          w: adW,
	          h: adH
	        },
	        tagid: tagId,
	        bidfloor: bidFloor
	      };
	      sovrnImps.push(imp);
	    });
	
	    // build bid request with impressions
	    var sovrnBidReq = {
	      id: utils.getUniqueIdentifierStr(),
	      imp: sovrnImps,
	      site: {
	        domain: domain,
	        page: page
	      }
	    };
	
	    var scriptUrl = '//' + sovrnUrl + '?callback=window.pbjs.sovrnResponse' + '&src=' + CONSTANTS.REPO_AND_VERSION + '&br=' + encodeURIComponent(JSON.stringify(sovrnBidReq));
	    adloader.loadScript(scriptUrl);
	  }
	
	  function addBlankBidResponses(impidsWithBidBack) {
	    var missing = pbjs._bidsRequested.find(function (bidSet) {
	      return bidSet.bidderCode === 'sovrn';
	    }).bids.filter(function (bid) {
	      return impidsWithBidBack.indexOf(bid.bidId) < 0;
	    });
	
	    missing.forEach(function (bidRequest) {
	      // Add a no-bid response for this bid request.
	      var bid = {};
	      bid = bidfactory.createBid(2, bidRequest);
	      bid.bidderCode = 'sovrn';
	      bidmanager.addBidResponse(bidRequest.placementCode, bid);
	    });
	  }
	
	  //expose the callback to the global object:
	  pbjs.sovrnResponse = function (sovrnResponseObj) {
	    // valid object?
	    if (sovrnResponseObj && sovrnResponseObj.id) {
	      // valid object w/ bid responses?
	      if (sovrnResponseObj.seatbid && sovrnResponseObj.seatbid.length !== 0 && sovrnResponseObj.seatbid[0].bid && sovrnResponseObj.seatbid[0].bid.length !== 0) {
	        var impidsWithBidBack = [];
	        sovrnResponseObj.seatbid[0].bid.forEach(function (sovrnBid) {
	
	          var responseCPM;
	          var placementCode = '';
	          var id = sovrnBid.impid;
	          var bid = {};
	
	          // try to fetch the bid request we sent Sovrn
	          var bidObj = pbjs._bidsRequested.find(function (bidSet) {
	            return bidSet.bidderCode === 'sovrn';
	          }).bids.find(function (bid) {
	            return bid.bidId === id;
	          });
	
	          if (bidObj) {
	            placementCode = bidObj.placementCode;
	            bidObj.status = CONSTANTS.STATUS.GOOD;
	
	            //place ad response on bidmanager._adResponsesByBidderId
	            responseCPM = parseFloat(sovrnBid.price);
	
	            if (responseCPM !== 0) {
	              sovrnBid.placementCode = placementCode;
	              sovrnBid.size = bidObj.sizes;
	              var responseAd = sovrnBid.adm;
	
	              // build impression url from response
	              var responseNurl = '<img src="' + sovrnBid.nurl + '">';
	
	              //store bid response
	              //bid status is good (indicating 1)
	              bid = bidfactory.createBid(1, bidObj);
	              bid.creative_id = sovrnBid.id;
	              bid.bidderCode = 'sovrn';
	              bid.cpm = responseCPM;
	
	              //set ad content + impression url
	              // sovrn returns <script> block, so use bid.ad, not bid.adurl
	              bid.ad = decodeURIComponent(responseAd + responseNurl);
	
	              // Set width and height from response now
	              bid.width = parseInt(sovrnBid.w);
	              bid.height = parseInt(sovrnBid.h);
	
	              bidmanager.addBidResponse(placementCode, bid);
	              impidsWithBidBack.push(id);
	            }
	          }
	        });
	
	        addBlankBidResponses(impidsWithBidBack);
	      } else {
	        //no response data for all requests
	        addBlankBidResponses([]);
	      }
	    } else {
	      //no response data for all requests
	      addBlankBidResponses([]);
	    }
	  }; // sovrnResponse
	
	  return {
	    callBids: _callBids
	  };
	};
	
	module.exports = SovrnAdapter;

/***/ },
/* 29 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var bidfactory = __webpack_require__(9);
	var bidmanager = __webpack_require__(4);
	var adloader = __webpack_require__(10);
	
	var SpringServeAdapter;
	SpringServeAdapter = function SpringServeAdapter() {
	
	  function buildSpringServeCall(bid) {
	
	    var spCall = window.location.protocol + '//bidder.springserve.com/display/hbid?';
	
	    //get width and height from bid attribute
	    var size = bid.sizes[0];
	    var width = size[0];
	    var height = size[1];
	
	    spCall += '&w=';
	    spCall += width;
	    spCall += '&h=';
	    spCall += height;
	
	    var params = bid.params;
	
	    //maps param attributes to request parameters
	    var requestAttrMap = {
	      sp: 'supplyPartnerId',
	      imp_id: 'impId'
	    };
	
	    for (var property in requestAttrMap) {
	      if (requestAttrMap.hasOwnProperty && params.hasOwnProperty(requestAttrMap[property])) {
	        spCall += '&';
	        spCall += property;
	        spCall += '=';
	
	        //get property from params and include it in request
	        spCall += params[requestAttrMap[property]];
	      }
	    }
	
	    var domain = window.location.hostname;
	
	    //override domain when testing
	    if (params.hasOwnProperty('test') && params.test === true) {
	      spCall += '&debug=true';
	      domain = 'test.com';
	    }
	
	    spCall += '&domain=';
	    spCall += domain;
	    spCall += '&callback=pbjs.handleSpringServeCB';
	
	    return spCall;
	  }
	
	  function _callBids(params) {
	    var bids = params.bids || [];
	    for (var i = 0; i < bids.length; i++) {
	      var bid = bids[i];
	      //bidmanager.pbCallbackMap[bid.params.impId] = params;
	      adloader.loadScript(buildSpringServeCall(bid));
	    }
	  }
	
	  pbjs.handleSpringServeCB = function (responseObj) {
	    if (responseObj && responseObj.seatbid && responseObj.seatbid.length > 0 && responseObj.seatbid[0].bid[0] !== undefined) {
	      //look up the request attributs stored in the bidmanager
	      var responseBid = responseObj.seatbid[0].bid[0];
	      //var requestObj = bidmanager.getPlacementIdByCBIdentifer(responseBid.impid);
	      var requestBids = pbjs._bidsRequested.find(function (bidSet) {
	        return bidSet.bidderCode === 'springserve';
	      }).bids.filter(function (bid) {
	        return bid.params && bid.params.impId === +responseBid.impid;
	      });
	      var bid = bidfactory.createBid(1);
	      var placementCode;
	
	      //assign properties from the original request to the bid object
	      for (var i = 0; i < requestBids.length; i++) {
	        var bidRequest = requestBids[i];
	        if (bidRequest.bidder === 'springserve') {
	          placementCode = bidRequest.placementCode;
	          var size = bidRequest.sizes[0];
	          bid.width = size[0];
	          bid.height = size[1];
	        }
	      }
	
	      bid.bidderCode = requestBids[0].bidder;
	
	      if (responseBid.hasOwnProperty('price') && responseBid.hasOwnProperty('adm')) {
	        //assign properties from the response to the bid object
	        bid.cpm = responseBid.price;
	        bid.ad = responseBid.adm;
	      } else {
	        //make object for invalid bid response
	        bid = bidfactory.createBid(2);
	        bid.bidderCode = 'springserve';
	      }
	
	      bidmanager.addBidResponse(placementCode, bid);
	    }
	  };
	
	  // Export the callBids function, so that prebid.js can execute this function
	  // when the page asks to send out bid requests.
	  return {
	    callBids: _callBids,
	    buildSpringServeCall: buildSpringServeCall
	  };
	};
	
	module.exports = SpringServeAdapter;

/***/ },
/* 30 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var utils = __webpack_require__(1);
	var adloader = __webpack_require__(10);
	var bidmanager = __webpack_require__(4);
	var bidfactory = __webpack_require__(9);
	
	/* TripleLift bidder factory function
	*  Use to create a TripleLiftAdapter object
	*/
	
	var TripleLiftAdapter = function TripleLiftAdapter() {
	
	  function _callBids(params) {
	    var tlReq = params.bids;
	    var bidsCount = tlReq.length;
	
	    //set expected bids count for callback execution
	    //bidmanager.setExpectedBidsCount('triplelift',bidsCount);
	
	    for (var i = 0; i < bidsCount; i++) {
	      var bidRequest = tlReq[i];
	      var callbackId = bidRequest.bidId;
	      adloader.loadScript(buildTLCall(bidRequest, callbackId));
	      //store a reference to the bidRequest from the callback id
	      //bidmanager.pbCallbackMap[callbackId] = bidRequest;
	    }
	  }
	
	  function buildTLCall(bid, callbackId) {
	    //determine tag params
	    var inventoryCode = utils.getBidIdParamater('inventoryCode', bid.params);
	    var floor = utils.getBidIdParamater('floor', bid.params);
	
	    //build our base tag, based on if we are http or https
	    var tlURI = '//tlx.3lift.com/header/auction?';
	    var tlCall = document.location.protocol + tlURI;
	
	    tlCall = utils.tryAppendQueryString(tlCall, 'callback', 'pbjs.TLCB');
	    tlCall = utils.tryAppendQueryString(tlCall, 'lib', 'prebid');
	    tlCall = utils.tryAppendQueryString(tlCall, 'v', '0.12.0');
	    tlCall = utils.tryAppendQueryString(tlCall, 'callback_id', callbackId);
	    tlCall = utils.tryAppendQueryString(tlCall, 'inv_code', inventoryCode);
	    tlCall = utils.tryAppendQueryString(tlCall, 'floor', floor);
	
	    //sizes takes a bit more logic
	    var sizeQueryString = utils.parseSizesInput(bid.sizes);
	    if (sizeQueryString) {
	      tlCall += 'size=' + sizeQueryString + '&';
	    }
	
	    //append referrer
	    var referrer = utils.getTopWindowUrl();
	    tlCall = utils.tryAppendQueryString(tlCall, 'referrer', referrer);
	
	    //remove the trailing "&"
	    if (tlCall.lastIndexOf('&') === tlCall.length - 1) {
	      tlCall = tlCall.substring(0, tlCall.length - 1);
	    }
	
	    // @if NODE_ENV='debug'
	    utils.logMessage('tlCall request built: ' + tlCall);
	    // @endif
	
	    //append a timer here to track latency
	    bid.startTime = new Date().getTime();
	
	    return tlCall;
	  }
	
	  //expose the callback to the global object:
	  pbjs.TLCB = function (tlResponseObj) {
	    if (tlResponseObj && tlResponseObj.callback_id) {
	      var bidObj = utils.getBidRequest(tlResponseObj.callback_id);
	      var placementCode = bidObj.placementCode;
	
	      // @if NODE_ENV='debug'
	      utils.logMessage('JSONP callback function called for inventory code: ' + bidObj.params.inventoryCode);
	      // @endif
	
	      var bid = [];
	      if (tlResponseObj && tlResponseObj.cpm && tlResponseObj.cpm !== 0) {
	
	        bid = bidfactory.createBid(1);
	        bid.bidderCode = 'triplelift';
	        bid.cpm = tlResponseObj.cpm;
	        bid.ad = tlResponseObj.ad;
	        bid.width = tlResponseObj.width;
	        bid.height = tlResponseObj.height;
	        bid.dealId = tlResponseObj.deal_id;
	        bidmanager.addBidResponse(placementCode, bid);
	      } else {
	        //no response data
	        // @if NODE_ENV='debug'
	        utils.logMessage('No prebid response from TripleLift for inventory code: ' + bidObj.params.inventoryCode);
	        // @endif
	        bid = bidfactory.createBid(2);
	        bid.bidderCode = 'triplelift';
	        bidmanager.addBidResponse(placementCode, bid);
	      }
	    } else {
	      //no response data
	      // @if NODE_ENV='debug'
	      utils.logMessage('No prebid response for placement %%PLACEMENT%%');
	      // @endif
	    }
	  };
	
	  return {
	    callBids: _callBids
	
	  };
	};
	module.exports = TripleLiftAdapter;

/***/ },
/* 31 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	/**
	 * @overview Yieldbot sponsored Prebid.js adapter.
	 * @author elljoh
	 */
	var adloader = __webpack_require__(10);
	var bidfactory = __webpack_require__(9);
	var bidmanager = __webpack_require__(4);
	var utils = __webpack_require__(1);
	
	/**
	 * Adapter for requesting bids from Yieldbot.
	 *
	 * @returns {Object} Object containing implementation for invocation in {@link module:adaptermanger.callBids}
	 * @class
	 */
	var YieldbotAdapter = function YieldbotAdapter() {
	
	  window.ybotq = window.ybotq || [];
	
	  var ybotlib = {
	    BID_STATUS: {
	      PENDING: 0,
	      AVAILABLE: 1,
	      EMPTY: 2
	    },
	    definedSlots: [],
	    pageLevelOption: false,
	    /**
	     * Builds the Yieldbot creative tag.
	     *
	     * @param {String} slot - The slot name to bid for
	     * @param {String} size - The dimenstions of the slot
	     * @private
	     */
	    buildCreative: function buildCreative(slot, size) {
	      return '<script type="text/javascript" src="//cdn.yldbt.com/js/yieldbot.intent.js"></script>' + '<script type="text/javascript">var ybotq = ybotq || [];' + 'ybotq.push(function () {yieldbot.renderAd(\'' + slot + ':' + size + '\');});</script>';
	    },
	    /**
	     * Bid response builder.
	     *
	     * @param {Object} slotCriteria  - Yieldbot bid criteria
	     * @private
	     */
	    buildBid: function buildBid(slotCriteria) {
	      var bid = {};
	
	      if (slotCriteria && slotCriteria.ybot_ad && slotCriteria.ybot_ad !== 'n') {
	
	        bid = bidfactory.createBid(ybotlib.BID_STATUS.AVAILABLE);
	
	        bid.cpm = parseInt(slotCriteria.ybot_cpm) / 100.0 || 0; // Yieldbot CPM bids are in cents
	
	        var szArr = slotCriteria.ybot_size ? slotCriteria.ybot_size.split('x') : [0, 0];
	        var slot = slotCriteria.ybot_slot || '';
	        var sizeStr = slotCriteria.ybot_size || ''; // Creative template needs the dimensions string
	
	        bid.width = szArr[0] || 0;
	        bid.height = szArr[1] || 0;
	
	        bid.ad = ybotlib.buildCreative(slot, sizeStr);
	
	        // Add Yieldbot parameters to allow publisher bidderSettings.yieldbot specific targeting
	        for (var k in slotCriteria) {
	          bid[k] = slotCriteria[k];
	        }
	      } else {
	        bid = bidfactory.createBid(ybotlib.BID_STATUS.EMPTY);
	      }
	
	      bid.bidderCode = 'yieldbot';
	      return bid;
	    },
	    /**
	     * Yieldbot implementation of {@link module:adaptermanger.callBids}
	     * @param {Object} params - Adapter bid configuration object
	     * @private
	     */
	    callBids: function callBids(params) {
	
	      var bids = params.bids || [];
	      var ybotq = window.ybotq || [];
	
	      ybotlib.pageLevelOption = false;
	
	      ybotq.push(function () {
	        var yieldbot = window.yieldbot;
	
	        utils._each(bids, function (v) {
	          var bid = v;
	          var psn = bid.params && bid.params.psn || 'ERROR_DEFINE_YB_PSN';
	          var slot = bid.params && bid.params.slot || 'ERROR_DEFINE_YB_SLOT';
	
	          yieldbot.pub(psn);
	          yieldbot.defineSlot(slot, { sizes: bid.sizes || [] });
	
	          ybotlib.definedSlots.push(bid.bidId);
	        });
	
	        yieldbot.enableAsync();
	        yieldbot.go();
	      });
	
	      ybotq.push(function () {
	        ybotlib.handleUpdateState();
	      });
	
	      adloader.loadScript('//cdn.yldbt.com/js/yieldbot.intent.js', null, true);
	    },
	    /**
	     * Yieldbot bid request callback handler.
	     *
	     * @see {@link YieldbotAdapter~_callBids}
	     * @private
	     */
	    handleUpdateState: function handleUpdateState() {
	      var yieldbot = window.yieldbot;
	
	      utils._each(ybotlib.definedSlots, function (v) {
	        var slot;
	        var criteria;
	        var placementCode;
	        var adapterConfig;
	
	        adapterConfig = pbjs._bidsRequested.find(function (bidderRequest) {
	          return bidderRequest.bidderCode === 'yieldbot';
	        }).bids.find(function (bid) {
	          return bid.bidId === v;
	        }) || {};
	        slot = adapterConfig.params.slot || '';
	        criteria = yieldbot.getSlotCriteria(slot);
	
	        placementCode = adapterConfig.placementCode || 'ERROR_YB_NO_PLACEMENT';
	        var bid = ybotlib.buildBid(criteria);
	
	        bidmanager.addBidResponse(placementCode, bid);
	      });
	    }
	  };
	  return {
	    callBids: ybotlib.callBids
	  };
	};
	
	module.exports = YieldbotAdapter;

/***/ },
/* 32 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var CONSTANTS = __webpack_require__(2);
	var utils = __webpack_require__(1);
	var bidfactory = __webpack_require__(9);
	var bidmanager = __webpack_require__(4);
	var adloader = __webpack_require__(10);
	
	var defaultPlacementForBadBid = null;
	
	/**
	 * Adapter for requesting bids from NginAd
	 */
	var NginAdAdapter = function NginAdAdapter() {
	
	  var rtbServerDomain = 'placeholder.for.nginad.server.com';
	
	  function _callBids(params) {
	    var nginadBids = params.bids || [];
	
	    // De-dupe by tagid then issue single bid request for all bids
	    _requestBids(_getUniqueTagids(nginadBids));
	  }
	
	  // filter bids to de-dupe them?
	  function _getUniqueTagids(bids) {
	    var key;
	    var map = {};
	    var PubZoneIds = [];
	
	    for (key in bids) {
	      map[utils.getBidIdParamater('pzoneid', bids[key].params)] = bids[key];
	    }
	
	    for (key in map) {
	      if (map.hasOwnProperty(key)) {
	        PubZoneIds.push(map[key]);
	      }
	    }
	
	    return PubZoneIds;
	  }
	
	  function getWidthAndHeight(bid) {
	
	    var adW = null;
	    var adH = null;
	
	    var sizeArrayLength = bid.sizes.length;
	    if (sizeArrayLength === 2 && typeof bid.sizes[0] === 'number' && typeof bid.sizes[1] === 'number') {
	      adW = bid.sizes[0];
	      adH = bid.sizes[1];
	    } else {
	      adW = bid.sizes[0][0];
	      adH = bid.sizes[0][1];
	    }
	
	    return [adW, adH];
	  }
	
	  function _requestBids(bidReqs) {
	    // build bid request object
	    var domain = window.location.host;
	    var page = window.location.pathname + location.search + location.hash;
	
	    var nginadImps = [];
	
	    //assign the first adUnit (placement) for bad bids;
	    defaultPlacementForBadBid = bidReqs[0].placementCode;
	
	    //build impression array for nginad
	    utils._each(bidReqs, function (bid) {
	      var tagId = utils.getBidIdParamater('pzoneid', bid.params);
	      var bidFloor = utils.getBidIdParamater('bidfloor', bid.params);
	
	      var whArr = getWidthAndHeight(bid);
	
	      var imp = {
	        id: bid.bidId,
	        banner: {
	          w: whArr[0],
	          h: whArr[1]
	        },
	        tagid: tagId,
	        bidfloor: bidFloor
	      };
	
	      nginadImps.push(imp);
	      //bidmanager.pbCallbackMap[imp.id] = bid;
	
	      rtbServerDomain = bid.params.nginadDomain;
	    });
	
	    // build bid request with impressions
	    var nginadBidReq = {
	      id: utils.getUniqueIdentifierStr(),
	      imp: nginadImps,
	      site: {
	        domain: domain,
	        page: page
	      }
	    };
	
	    var scriptUrl = window.location.protocol + '//' + rtbServerDomain + '/bid/rtb?callback=window.pbjs.nginadResponse' + '&br=' + encodeURIComponent(JSON.stringify(nginadBidReq));
	
	    adloader.loadScript(scriptUrl);
	  }
	
	  function handleErrorResponse(bidReqs, defaultPlacementForBadBid) {
	    //no response data
	    if (defaultPlacementForBadBid === null) {
	      // no id with which to create an dummy bid
	      return;
	    }
	
	    var bid = bidfactory.createBid(2);
	    bid.bidderCode = 'nginad';
	    bidmanager.addBidResponse(defaultPlacementForBadBid, bid);
	  }
	
	  //expose the callback to the global object:
	  pbjs.nginadResponse = function (nginadResponseObj) {
	    var bid = {};
	    var key;
	
	    // valid object?
	    if (!nginadResponseObj || !nginadResponseObj.id) {
	      return handleErrorResponse(nginadResponseObj, defaultPlacementForBadBid);
	    }
	
	    if (!nginadResponseObj.seatbid || nginadResponseObj.seatbid.length === 0 || !nginadResponseObj.seatbid[0].bid || nginadResponseObj.seatbid[0].bid.length === 0) {
	      return handleErrorResponse(nginadResponseObj, defaultPlacementForBadBid);
	    }
	
	    for (key in nginadResponseObj.seatbid[0].bid) {
	
	      var nginadBid = nginadResponseObj.seatbid[0].bid[key];
	
	      var responseCPM;
	      var placementCode = '';
	      var id = nginadBid.impid;
	
	      // try to fetch the bid request we sent NginAd
	      /*jshint -W083 */
	      var bidObj = pbjs._bidsRequested.find(function (bidSet) {
	        return bidSet.bidderCode === 'nginad';
	      }).bids.find(function (bid) {
	        return bid.bidId === id;
	      });
	      if (!bidObj) {
	        return handleErrorResponse(nginadBid, defaultPlacementForBadBid);
	      }
	
	      placementCode = bidObj.placementCode;
	      bidObj.status = CONSTANTS.STATUS.GOOD;
	
	      //place ad response on bidmanager._adResponsesByBidderId
	      responseCPM = parseFloat(nginadBid.price);
	
	      if (responseCPM === 0) {
	        handleErrorResponse(nginadBid, id);
	      }
	
	      nginadBid.placementCode = placementCode;
	      nginadBid.size = bidObj.sizes;
	      var responseAd = nginadBid.adm;
	
	      //store bid response
	      //bid status is good (indicating 1)
	      bid = bidfactory.createBid(1);
	      bid.creative_id = nginadBid.Id;
	      bid.bidderCode = 'nginad';
	      bid.cpm = responseCPM;
	
	      //The bid is a mock bid, the true bidding process happens after the publisher tag is called
	      bid.ad = decodeURIComponent(responseAd);
	
	      var whArr = getWidthAndHeight(bidObj);
	      bid.width = whArr[0];
	      bid.height = whArr[1];
	
	      bidmanager.addBidResponse(placementCode, bid);
	    }
	  }; // nginadResponse
	
	  return {
	    callBids: _callBids
	  };
	};
	
	module.exports = NginAdAdapter;

/***/ },
/* 33 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var CONSTANTS = __webpack_require__(2);
	var utils = __webpack_require__(1);
	var bidfactory = __webpack_require__(9);
	var bidmanager = __webpack_require__(4);
	var adloader = __webpack_require__(10);
	
	/**
	 * Adapter for requesting bids from Brightcom
	 */
	var BrightcomAdapter = function BrightcomAdapter() {
	
	  // Set Brightcom Bidder URL
	  var brightcomUrl = 'hb.iselephant.com/auc/ortb';
	
	  // Define the bidder code
	  var brightcomBidderCode = 'brightcom';
	
	  // Define the callback function
	  var brightcomCallbackFunction = 'window.pbjs=window.pbjs||window.parent.pbjs||window.top.pbjs;window.pbjs.brightcomResponse';
	
	  // Manage the requested and received ad units' codes, to know which are invalid (didn't return)
	  var reqAdUnitsCode = [],
	      resAdUnitsCode = [];
	
	  function _callBids(params) {
	
	    var bidRequests = params.bids || [];
	
	    // Get page data
	    var siteDomain = window.location.host;
	    var sitePage = window.location.href;
	
	    // Prepare impressions object
	    var brightcomImps = [];
	
	    // Prepare a variable for publisher id
	    var pubId = '';
	
	    // Go through the requests and build array of impressions
	    utils._each(bidRequests, function (bid) {
	
	      // Get impression details
	      var tagId = utils.getBidIdParamater('tagId', bid.params);
	      var ref = utils.getBidIdParamater('ref', bid.params);
	      var adWidth = 0;
	      var adHeight = 0;
	
	      // If no publisher id is set, use the current
	      if (pubId === '') {
	        // Get the current publisher id (if it doesn't exist, it'll return '')
	        pubId = utils.getBidIdParamater('pubId', bid.params);
	      }
	
	      // Brightcom supports only 1 size per impression
	      // Check if the array contains 1 size or array of sizes
	      if (bid.sizes.length === 2 && typeof bid.sizes[0] === 'number' && typeof bid.sizes[1] === 'number') {
	        // The array contains 1 size (the items are the values)
	        adWidth = bid.sizes[0];
	        adHeight = bid.sizes[1];
	      } else {
	        // The array contains array of sizes, use the first size
	        adWidth = bid.sizes[0][0];
	        adHeight = bid.sizes[0][1];
	      }
	
	      // Build the impression
	      var imp = {
	        id: utils.getUniqueIdentifierStr(),
	        banner: {
	          w: adWidth,
	          h: adHeight
	        },
	        tagid: tagId
	      };
	
	      // If ref exists, create it (in the "ext" object)
	      if (ref !== '') {
	        imp.ext = {
	          refoverride: ref
	        };
	      }
	
	      // Add current impression to collection
	      brightcomImps.push(imp);
	      // Add mapping to current bid via impression id
	      //bidmanager.pbCallbackMap[imp.id] = bid;
	
	      // Add current ad unit's code to tracking
	      reqAdUnitsCode.push(bid.placementCode);
	    });
	
	    // Build the bid request
	    var brightcomBidReq = {
	      id: utils.getUniqueIdentifierStr(),
	      imp: brightcomImps,
	      site: {
	        publisher: {
	          id: pubId
	        },
	        domain: siteDomain,
	        page: sitePage
	      }
	    };
	
	    // Add timeout data, if available
	    var PREBID_TIMEOUT = PREBID_TIMEOUT || 0;
	    var curTimeout = PREBID_TIMEOUT;
	    if (curTimeout > 0) {
	      brightcomBidReq.tmax = curTimeout;
	    }
	
	    // Define the bid request call URL
	    var bidRequestCallUrl = 'https://' + brightcomUrl + '?callback=' + brightcomCallbackFunction + '&request=' + encodeURIComponent(JSON.stringify(brightcomBidReq));
	
	    // Add the call to get the bid
	    adloader.loadScript(bidRequestCallUrl);
	  }
	
	  //expose the callback to the global object:
	  pbjs.brightcomResponse = function (brightcomResponseObj) {
	
	    var bid = {};
	
	    // Make sure response is valid
	    if (brightcomResponseObj && brightcomResponseObj.id && brightcomResponseObj.seatbid && brightcomResponseObj.seatbid.length !== 0 && brightcomResponseObj.seatbid[0].bid && brightcomResponseObj.seatbid[0].bid.length !== 0) {
	
	      // Go through the received bids
	      brightcomResponseObj.seatbid[0].bid.forEach(function (curBid) {
	
	        // Get the bid request data
	        var bidRequest = pbjs._bidsRequested.find(function (bidSet) {
	          return bidSet.bidderCode === 'brightcom';
	        }).bids[0]; // this assumes a single request only
	
	        // Make sure the bid exists
	        if (bidRequest) {
	
	          var placementCode = bidRequest.placementCode;
	          bidRequest.status = CONSTANTS.STATUS.GOOD;
	
	          curBid.placementCode = placementCode;
	          curBid.size = bidRequest.sizes;
	
	          // Get the creative
	          var responseCreative = curBid.adm;
	          // Build the NURL element
	          var responseNurl = '<img src="' + curBid.nurl + '" width="1" height="1" style="display:none" />';
	          // Build the ad to display:
	          var responseAd = decodeURIComponent(responseCreative + responseNurl);
	
	          // Create a valid bid
	          bid = bidfactory.createBid(1);
	
	          // Set the bid data
	          bid.creative_id = curBid.Id;
	          bid.bidderCode = brightcomBidderCode;
	          bid.cpm = parseFloat(curBid.price);
	
	          // Brightcom tag is in <script> block, so use bid.ad, not bid.adurl
	          bid.ad = responseAd;
	
	          // Since Brightcom currently supports only 1 size, if multiple sizes are provided - take the first
	          var adWidth, adHeight;
	          if (bidRequest.sizes.length === 2 && typeof bidRequest.sizes[0] === 'number' && typeof bidRequest.sizes[1] === 'number') {
	            // Only one size is provided
	            adWidth = bidRequest.sizes[0];
	            adHeight = bidRequest.sizes[1];
	          } else {
	            // And array of sizes is provided. Take the first.
	            adWidth = bidRequest.sizes[0][0];
	            adHeight = bidRequest.sizes[0][1];
	          }
	
	          // Set the ad's width and height
	          bid.width = adWidth;
	          bid.height = adHeight;
	
	          // Add the bid
	          bidmanager.addBidResponse(placementCode, bid);
	
	          // Add current ad unit's code to tracking
	          resAdUnitsCode.push(placementCode);
	        }
	      });
	    }
	
	    // Define all unreceived ad unit codes as invalid (if Brightcom don't want to bid on an impression, it won't include it in the response)
	    for (var i = 0; i < reqAdUnitsCode.length; i++) {
	      var adUnitCode = reqAdUnitsCode[i];
	      // Check if current ad unit code was NOT received
	      if (resAdUnitsCode.indexOf(adUnitCode) === -1) {
	        // Current ad unit wasn't returned. Define it as invalid.
	        bid = bidfactory.createBid(2);
	        bid.bidderCode = brightcomBidderCode;
	        bidmanager.addBidResponse(adUnitCode, bid);
	      }
	    }
	  };
	
	  return {
	    callBids: _callBids
	  };
	};
	
	module.exports = BrightcomAdapter;

/***/ },
/* 34 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var bidfactory = __webpack_require__(9),
	    bidmanager = __webpack_require__(4),
	    utils = __webpack_require__(1),
	    adloader = __webpack_require__(10);
	
	var WideOrbitAdapter = function WideOrbitAdapter() {
	  var pageImpression = 'JSAdservingMP.ashx?pc={pc}&pbId={pbId}&clk=&exm=&jsv=1.0&tsv=1.0&cts={cts}&arp=0&fl=0&vitp=&vit=&jscb=window.pbjs.handleWideOrbitCallback&url=&fp=&oid=&exr=&mraid=&apid=&apbndl=&mpp=0&uid=&cb={cb}&hb=1',
	      pageRepeatCommonParam = '&gid{o}={gid}&pp{o}=&clk{o}=&rpos{o}={rpos}&ecpm{o}={ecpm}&ntv{o}=&ntl{o}=&adsid{o}=',
	      pageRepeatParamId = '&pId{o}={pId}&rank{o}={rank}',
	      pageRepeatParamNamed = '&wsName{o}={wsName}&wName{o}={wName}&rank{o}={rank}&bfDim{o}={width}x{height}&subp{o}={subp}',
	      base = window.location.protocol + '//p{pbId}.atemda.com/',
	      bids,
	      adapterName = 'wideorbit';
	
	  function _fixParamNames(param) {
	    if (!param) {
	      return;
	    }
	
	    var properties = ['site', 'page', 'width', 'height', 'rank', 'subPublisher', 'ecpm', 'atf', 'pId', 'pbId'],
	        prop;
	
	    utils._each(properties, function (correctName) {
	      for (prop in param) {
	        if (param.hasOwnProperty(prop) && prop.toLowerCase() === correctName.toLowerCase()) {
	          param[correctName] = param[prop];
	          break;
	        }
	      }
	    });
	  }
	
	  function _setParam(str, param, value) {
	    var pattern = new RegExp('{' + param + '}', 'g');
	
	    if (value === true) {
	      value = 1;
	    }
	    if (value === false) {
	      value = 0;
	    }
	    return str.replace(pattern, value);
	  }
	
	  function _setParams(str, keyValuePairs) {
	    utils._each(keyValuePairs, function (keyValuePair) {
	      str = _setParam(str, keyValuePair[0], keyValuePair[1]);
	    });
	    return str;
	  }
	
	  function _setCommonParams(pos, params) {
	    return _setParams(pageRepeatCommonParam, [['o', pos], ['gid', encodeURIComponent(params.tagId)], ['rpos', params.atf ? 1001 : 0], ['ecpm', params.ecpm || '']]);
	  }
	
	  function _getRankParam(rank, pos) {
	    return rank || pos;
	  }
	
	  function _setupIdPlacementParameters(pos, params) {
	    return _setParams(pageRepeatParamId, [['o', pos], ['pId', params.pId], ['rank', _getRankParam(params.rank, pos)]]);
	  }
	
	  function _setupNamedPlacementParameters(pos, params) {
	    return _setParams(pageRepeatParamNamed, [['o', pos], ['wsName', encodeURIComponent(decodeURIComponent(params.site))], ['wName', encodeURIComponent(decodeURIComponent(params.page))], ['width', params.width], ['height', params.height], ['subp', params.subPublisher ? encodeURIComponent(decodeURIComponent(params.subPublisher)) : ''], ['rank', _getRankParam(params.rank, pos)]]);
	  }
	
	  function _setupAdCall(publisherId, placementCount, placementsComponent) {
	    return _setParams(base + pageImpression, [['pbId', publisherId], ['pc', placementCount], ['cts', new Date().getTime()], ['cb', Math.floor(Math.random() * 100000000)]]) + placementsComponent;
	  }
	
	  function _setupPlacementParameters(pos, params) {
	    var commonParams = _setCommonParams(pos, params);
	
	    if (params.pId) {
	      return _setupIdPlacementParameters(pos, params) + commonParams;
	    }
	
	    return _setupNamedPlacementParameters(pos, params) + commonParams;
	  }
	
	  function _callBids(params) {
	    var publisherId,
	        bidUrl = '',
	        i;
	
	    bids = params.bids || [];
	
	    for (i = 0; i < bids.length; i++) {
	      var requestParams = bids[i].params;
	
	      requestParams.tagId = bids[i].placementCode;
	
	      _fixParamNames(requestParams);
	
	      publisherId = requestParams.pbId;
	      bidUrl += _setupPlacementParameters(i, requestParams);
	    }
	
	    bidUrl = _setupAdCall(publisherId, bids.length, bidUrl);
	
	    utils.logMessage('Calling WO: ' + bidUrl);
	
	    adloader.loadScript(bidUrl);
	  }
	
	  function _processUserMatchings(userMatchings) {
	    var headElem = document.getElementsByTagName('head')[0],
	        createdElem;
	
	    utils._each(userMatchings, function (userMatching) {
	      switch (userMatching.Type) {
	        case 'redirect':
	          createdElem = document.createElement('img');
	          break;
	        case 'iframe':
	          createdElem = utils.createInvisibleIframe();
	          break;
	        case 'javascript':
	          createdElem = document.createElement('script');
	          createdElem.type = 'text/javascript';
	          createdElem.async = true;
	          break;
	      }
	      createdElem.src = decodeURIComponent(userMatching.Url);
	      headElem.insertBefore(createdElem, headElem.firstChild);
	    });
	  }
	
	  function _getBidResponse(id, placements) {
	    var i;
	
	    for (i = 0; i < placements.length; i++) {
	      if (placements[i].ExtPlacementId === id) {
	        return placements[i];
	      }
	    }
	  }
	
	  function _isUrl(scr) {
	    return scr.slice(0, 6) === "http:/" || scr.slice(0, 7) === "https:/" || scr.slice(0, 2) === "//";
	  }
	
	  function _buildAdCode(placement) {
	    var adCode = placement.Source,
	        pixelTag;
	
	    utils._each(placement.TrackingCodes, function (trackingCode) {
	      if (_isUrl(trackingCode)) {
	        pixelTag = '<img src="' + trackingCode + '" width="0" height="0" style="position:absolute"></img>';
	      } else {
	        pixelTag = trackingCode;
	      }
	      adCode = pixelTag + adCode;
	    });
	
	    return adCode;
	  }
	
	  window.pbjs = window.pbjs || {};
	  window.pbjs.handleWideOrbitCallback = function (response) {
	    var bidResponse, bidObject;
	
	    utils.logMessage('WO response. Placements: ' + response.Placements.length);
	
	    _processUserMatchings(response.UserMatchings);
	
	    utils._each(bids, function (bid) {
	      bidResponse = _getBidResponse(bid.placementCode, response.Placements);
	
	      if (bidResponse && bidResponse.Type === 'DirectHTML') {
	        bidObject = bidfactory.createBid(1);
	        bidObject.cpm = bidResponse.Bid;
	        bidObject.ad = _buildAdCode(bidResponse);
	        bidObject.width = bidResponse.Width;
	        bidObject.height = bidResponse.Height;
	      } else {
	        bidObject = bidfactory.createBid(2);
	      }
	
	      bidObject.bidderCode = adapterName;
	      bidmanager.addBidResponse(bid.placementCode, bidObject);
	    });
	  };
	
	  return {
	    callBids: _callBids
	  };
	};
	
	module.exports = WideOrbitAdapter;

/***/ },
/* 35 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var bidfactory = __webpack_require__(9);
	var bidmanager = __webpack_require__(4);
	var adloader = __webpack_require__(10);
	var utils = __webpack_require__(1);
	
	var JCMAdapter = function JCMAdapter() {
	
	  window.pbjs = window.pbjs || {};
	  window.pbjs.processJCMResponse = function (JCMResponse) {
	    if (JCMResponse) {
	      var JCMRespObj = JSON.parse(JCMResponse);
	      if (JCMRespObj) {
	        var bids = JCMRespObj.bids;
	        for (var i = 0; i < bids.length; i++) {
	          var bid = bids[i];
	          var bidObject;
	          if (bid.cpm > 0) {
	            bidObject = bidfactory.createBid(1);
	            bidObject.bidderCode = 'jcm';
	            bidObject.cpm = bid.cpm;
	            bidObject.ad = decodeURIComponent(bid.ad.replace(/\+/g, '%20'));
	            bidObject.width = bid.width;
	            bidObject.height = bid.height;
	            bidmanager.addBidResponse(utils.getBidRequest(bid.callbackId).placementCode, bidObject);
	          } else {
	            bidObject = bidfactory.createBid(2);
	            bidObject.bidderCode = 'jcm';
	            bidmanager.addBidResponse(utils.getBidRequest(bid.callbackId).placementCode, bidObject);
	          }
	        }
	      }
	    }
	  };
	
	  function _callBids(params) {
	
	    var BidRequest = {
	      bids: []
	    };
	
	    for (var i = 0; i < params.bids.length; i++) {
	
	      var adSizes = "";
	      var bid = params.bids[i];
	      for (var x = 0; x < bid.sizes.length; x++) {
	        adSizes += utils.parseGPTSingleSizeArray(bid.sizes[x]);
	        if (x !== bid.sizes.length - 1) {
	          adSizes += ',';
	        }
	      }
	
	      BidRequest.bids.push({
	        "callbackId": bid.bidId,
	        "siteId": bid.params.siteId,
	        "adSizes": adSizes
	      });
	    }
	
	    var JSONStr = JSON.stringify(BidRequest);
	    var reqURL = document.location.protocol + "//media.adfrontiers.com/pq?t=hb&bids=" + encodeURIComponent(JSONStr);
	    adloader.loadScript(reqURL);
	  }
	
	  return {
	    callBids: _callBids
	  };
	};
	
	module.exports = JCMAdapter;

/***/ },
/* 36 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var bidfactory = __webpack_require__(9);
	var bidmanager = __webpack_require__(4);
	var adloader = __webpack_require__(10);
	var utils = __webpack_require__(1);
	
	var UnderdogMediaAdapter = function UnderdogMediaAdapter() {
	
	  var getJsStaticUrl = window.location.protocol + '//rtb.udmserve.net/udm_header_lib.js';
	
	  function _callBids(params) {
	    if (typeof window.udm_header_lib === 'undefined') {
	      adloader.loadScript(getJsStaticUrl, function () {
	        bid(params);
	      });
	    } else {
	      bid(params);
	    }
	  }
	
	  function bid(params) {
	    var bids = params.bids;
	    for (var i = 0; i < bids.length; i++) {
	      var bidRequest = bids[i];
	      var callback = bidResponseCallback(bidRequest);
	      var udmBidRequest = new window.udm_header_lib.BidRequest({
	        sizes: bidRequest.sizes,
	        siteId: bidRequest.params.siteId,
	        bidfloor: bidRequest.params.bidfloor,
	        placementCode: bidRequest.placementCode,
	        callback: callback
	      });
	      udmBidRequest.send();
	    }
	  }
	
	  function bidResponseCallback(bid) {
	    return function (bidResponse) {
	      bidResponseAvailable(bid, bidResponse);
	    };
	  }
	
	  function bidResponseAvailable(bidRequest, bidResponse) {
	    if (bidResponse.bids.length > 0) {
	      for (var i = 0; i < bidResponse.bids.length; i++) {
	        var udm_bid = bidResponse.bids[i];
	        var bid = bidfactory.createBid(1);
	        bid.bidderCode = bidRequest.bidder;
	        bid.cpm = udm_bid.cpm;
	        bid.width = udm_bid.width;
	        bid.height = udm_bid.height;
	
	        if (udm_bid.ad_url !== undefined) {
	          bid.adUrl = udm_bid.ad_url;
	        } else if (udm_bid.ad_html !== undefined) {
	          bid.ad = udm_bid.ad_html;
	        } else {
	          utils.logMessage('Underdogmedia bid is lacking both ad_url and ad_html, skipping bid');
	          continue;
	        }
	
	        bidmanager.addBidResponse(bidRequest.placementCode, bid);
	      }
	    } else {
	      var nobid = bidfactory.createBid(2);
	      nobid.bidderCode = bidRequest.bidder;
	      bidmanager.addBidResponse(bidRequest.placementCode, nobid);
	    }
	  }
	
	  return {
	    callBids: _callBids
	  };
	};
	
	module.exports = UnderdogMediaAdapter;

/***/ },
/* 37 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var CONSTANTS = __webpack_require__(2);
	var utils = __webpack_require__(1);
	var bidfactory = __webpack_require__(9);
	var bidmanager = __webpack_require__(4);
	var adloader = __webpack_require__(10);
	
	var defaultPlacementForBadBid = null;
	var bidderName = 'memeglobal';
	/**
	 * Adapter for requesting bids from Meme Global Media Group
	 * OpenRTB compatible
	 */
	var MemeGlobalAdapter = function MemeGlobalAdapter() {
	  var bidder = 'stinger.memeglobal.com/api/v1/services/prebid';
	
	  function _callBids(params) {
	    var bids = params.bids;
	
	    if (!bids) return;
	
	    // assign the first adUnit (placement) for bad bids;
	    defaultPlacementForBadBid = bids[0].placementCode;
	
	    for (var i = 0; i < bids.length; i++) {
	      _requestBid(bids[i]);
	    }
	  }
	
	  function _requestBid(bidReq) {
	    // build bid request object
	    var domain = window.location.host;
	    var page = window.location.pathname + location.search + location.hash;
	
	    var tagId = utils.getBidIdParamater('tagid', bidReq.params);
	    var bidFloor = Number(utils.getBidIdParamater('bidfloor', bidReq.params));
	    var adW = 0;
	    var adH = 0;
	
	    var bidSizes = Array.isArray(bidReq.params.sizes) ? bidReq.params.sizes : bidReq.sizes;
	    var sizeArrayLength = bidSizes.length;
	    if (sizeArrayLength === 2 && typeof bidSizes[0] === 'number' && typeof bidSizes[1] === 'number') {
	      adW = bidSizes[0];
	      adH = bidSizes[1];
	    } else {
	      adW = bidSizes[0][0];
	      adH = bidSizes[0][1];
	    }
	
	    // build bid request with impressions
	    var bidRequest = {
	      id: utils.getUniqueIdentifierStr(),
	      imp: [{
	        id: bidReq.bidId,
	        banner: {
	          w: adW,
	          h: adH
	        },
	        tagid: bidReq.placementCode,
	        bidfloor: bidFloor
	      }],
	      site: {
	        domain: domain,
	        page: page,
	        publisher: {
	          id: tagId
	        }
	      }
	    };
	
	    var scriptUrl = '//' + bidder + '?callback=window.pbjs.mgres' + '&src=' + CONSTANTS.REPO_AND_VERSION + '&br=' + encodeURIComponent(JSON.stringify(bidRequest));
	    adloader.loadScript(scriptUrl);
	  }
	
	  function getBidSetForBidder() {
	    return pbjs._bidsRequested.find(function (bidSet) {
	      return bidSet.bidderCode === bidderName;
	    });
	  }
	
	  // expose the callback to the global object:
	  pbjs.mgres = function (bidResp) {
	
	    // valid object?
	    if (!bidResp || !bidResp.id || !bidResp.seatbid || bidResp.seatbid.length === 0 || !bidResp.seatbid[0].bid || bidResp.seatbid[0].bid.length === 0) {
	      return;
	    }
	
	    bidResp.seatbid[0].bid.forEach(function (bidderBid) {
	      var responseCPM;
	      var placementCode = '';
	
	      var bidSet = getBidSetForBidder();
	      var bidRequested = bidSet.bids.find(function (b) {
	        return b.bidId === bidderBid.impid;
	      });
	      if (bidRequested) {
	        var bidResponse = bidfactory.createBid(1);
	        placementCode = bidRequested.placementCode;
	        bidRequested.status = CONSTANTS.STATUS.GOOD;
	        responseCPM = parseFloat(bidderBid.price);
	        if (responseCPM === 0) {
	          var bid = bidfactory.createBid(2);
	          bid.bidderCode = bidderName;
	          bidmanager.addBidResponse(placementCode, bid);
	          return;
	        }
	        bidResponse.placementCode = placementCode;
	        bidResponse.size = bidRequested.sizes;
	        var responseAd = bidderBid.adm;
	        var responseNurl = '<img src="' + bidderBid.nurl + '">';
	        bidResponse.creative_id = bidderBid.id;
	        bidResponse.bidderCode = bidderName;
	        bidResponse.cpm = responseCPM;
	        bidResponse.ad = decodeURIComponent(responseAd + responseNurl);
	        bidResponse.width = parseInt(bidderBid.w);
	        bidResponse.height = parseInt(bidderBid.h);
	        bidmanager.addBidResponse(placementCode, bidResponse);
	      }
	    });
	  };
	
	  return {
	    callBids: _callBids
	  };
	};
	
	module.exports = MemeGlobalAdapter;

/***/ },
/* 38 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var utils = __webpack_require__(1);
	var bidfactory = __webpack_require__(9);
	var bidmanager = __webpack_require__(4);
	var adloader = __webpack_require__(10);
	
	var CentroAdapter = function CentroAdapter() {
	  var baseUrl = '//t.brand-server.com/hb',
	      devUrl = '//staging.brand-server.com/hb',
	      bidderCode = 'centro',
	      handlerPrefix = 'adCentroHandler_',
	      LOG_ERROR_MESS = {
	    noUnit: 'Bid has no unit',
	    noAdTag: 'Bid has missmatch format.',
	    noBid: 'Response has no bid.',
	    anotherCode: 'Bid has another bidderCode - ',
	    undefBid: 'Bid is undefined',
	    unitNum: 'Requested unit is '
	  };
	
	  function _makeHandler(handlerName, unit, placementCode) {
	    return function (response) {
	      try {
	        delete window[handlerName];
	      } catch (err) {
	        //catching for old IE
	        window[handlerName] = undefined;
	      }
	      _responseProcessing(response, unit, placementCode);
	    };
	  }
	
	  function _sendBidRequest(bid) {
	    var placementCode = bid.placementCode,
	        size = bid.sizes && bid.sizes[0];
	
	    bid = bid.params;
	    if (!bid.unit) {
	      //throw exception, or call utils.logError
	      utils.logError(LOG_ERROR_MESS.noUnit, bidderCode);
	      return;
	    }
	    var query = ['s=' + bid.unit]; //,'url=www.abc15.com','sz=320x50'];
	    var isDev = bid.unit.toString() === '28136';
	
	    if (bid.page_url) {
	      query.push('url=' + encodeURIComponent(bid.page_url));
	    }
	    //check size format
	    if (size instanceof Array && size.length === 2 && typeof size[0] === 'number' && typeof size[1] === 'number') {
	      query.push('sz=' + size.join('x'));
	    }
	    //make handler name for JSONP request
	    var handlerName = handlerPrefix + bid.unit + size.join('x');
	    query.push('callback=' + handlerName);
	
	    //maybe is needed add some random parameter to disable cache
	    //query.push('r='+Math.round(Math.random() * 1e5));
	
	    window[handlerName] = _makeHandler(handlerName, bid.unit, placementCode);
	
	    adloader.loadScript((document.location.protocol === 'https:' ? 'https:' : 'http:') + (isDev ? devUrl : baseUrl) + '?' + query.join('&'));
	  }
	
	  /*
	   "sectionID": 7302,
	   "height": 250,
	   "width": 300,
	   "value": 3.2,
	   "adTag":''
	   */
	  function _responseProcessing(resp, unit, placementCode) {
	    var bidObject;
	    var bid = resp && resp.bid || resp;
	
	    if (bid && bid.adTag && bid.sectionID === unit) {
	      bidObject = bidfactory.createBid(1);
	      bidObject.cpm = bid.value;
	      bidObject.ad = bid.adTag;
	      bidObject.width = bid.width;
	      bidObject.height = bid.height;
	    } else {
	      //throw exception, or call utils.logError with resp.statusMessage
	      utils.logError(LOG_ERROR_MESS.unitNum + unit + '. ' + (bid ? bid.statusMessage || LOG_ERROR_MESS.noAdTag : LOG_ERROR_MESS.noBid), bidderCode);
	      bidObject = bidfactory.createBid(2);
	    }
	    bidObject.bidderCode = bidderCode;
	    bidmanager.addBidResponse(placementCode, bidObject);
	  }
	
	  /*
	   {
	   bidderCode: "centro",
	   bids: [
	   {
	   unit:  '3242432',
	   page_url: "http://",
	   size: [300, 250]
	   */
	  function _callBids(params) {
	    var bid,
	        bids = params.bids || [];
	    for (var i = 0; i < bids.length; i++) {
	      bid = bids[i];
	      if (bid && bid.bidder === bidderCode) {
	        _sendBidRequest(bid);
	      }
	    }
	  }
	
	  return {
	    callBids: _callBids
	  };
	};
	
	module.exports = CentroAdapter;

/***/ }
/******/ ]);
//# sourceMappingURL=prebid.js.map
