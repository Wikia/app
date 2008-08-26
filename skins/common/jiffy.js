/*								
  Copyright 2008 Whitepages.com, Inc.

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

var Jiffy = function (){
  this.addBulkLoad = function(_eventName, elapsedTime){
	measures.captured[_eventName] = elapsedTime;	
  }
  
  this.getUID = function(){
    return Math.round(Math.random() * 1000000000000000);
  }
  
  this.checkRemoveEvent = function(eventName){
	if(eventsForRemoval[eventName] != null){
	  var captureDetails = eventsForRemoval[eventName];
	  Jiffy.utils.removeEvent(captureDetails.element_id, captureDetails.browser_event, captureDetails.callback_func, true);
	}
  }
  
	this.addMarksMeasures = function(referenceID, eventName, elapseTime, refTime){
		marks_measures.push({name: referenceID, evt:eventName, et:elapseTime, rt:refTime});
	}
	
  var eventsForRemoval = {};
  var pageTimer = (window.JiffyParams == undefined) ? (new Date()).getTime():(JiffyParams.jsStart != undefined) ? JiffyParams.jsStart:(new Date()).getTime();
  
  var pname = (window.JiffyParams == undefined) ? window.location:(JiffyParams.pname != undefined) ? JiffyParams.pname:window.location;
  var uid = (window.JiffyParams == undefined) ?  getUID():(JiffyParams.uid != undefined) ? JiffyParams.uid:getUID();
  
  var markers = [];
  var measures = {
	pn:pname,
	st:pageTimer,
	uid:uid,
	captured:{}
  };
  	/* marks_measures
	JSON Obj used for storing all captured marks and measures. This is mainly used by the 
	Jiffy Firebug plugin but we use it for the bulk load operation. sample layout of the 
	object looks like the following:
	{
     	"PageStart": { et: 2676, m: [
			{et:2676, evt:"load", rt:1213159816044}
      ]},
      	"onLoad": { et: 74, m: [
        	{et:7,  evt:"carouselcreated", rt:1213159818722},
        	{et:67, evt:"finishedonLoad",  rt:1213159818729}
      ]}
	}
	*/
  var marks_measures = [];
  
  return{
  	// Creating a mark sets the startTime and lastTime to the curr time
	mark : function(referenceID){
		var currTime = (new Date()).getTime();
		markers[referenceID] = {startTime: currTime, lastTime: currTime}; 
	},
	
	// Creating a measure will calculate 
	// et (elapsed time) as current time - markers[].currTime
	measure : function(eventName, referenceID){
		if(Jiffy.options.USE_JIFFY == undefined || !Jiffy.options.USE_JIFFY){return};
		/*Check to see if the eventName is a string which we use for wrapping
		around tags or an Event Object being passed by the attachevent
		method for builtin browser events we are tracking.*/

		var _eventName = (typeof eventName == "string" ? eventName : eventName.type); 
		// -- >

		var currTime = new Date().getTime();
		
		var refStartTime;
		var elapsedTime;
		
		// We want the previous time stamp to measure this event against
		if(referenceID != null && markers[referenceID] != null) {
			refStartTime = markers[referenceID].lastTime;
			elapsedTime = currTime - refStartTime;
			markers[referenceID].lastTime = currTime;
		}
		else
		{
			refStartTime = pageTimer;
			elapsedTime = currTime - refStartTime;
		}
		
		if(referenceID != null) {
			addMarksMeasures(referenceID, _eventName, elapsedTime, refStartTime);
		}
		else{
			markers["PageStart"] = {startTime: refStartTime, lastTime: currTime};
			addMarksMeasures("PageStart", _eventName, elapsedTime, refStartTime); // pageTimer?
		}
				
		if(Jiffy.options.ISBULKLOAD && _eventName != "unload"){
			addBulkLoad(_eventName, elapsedTime);
		}
		else{
			var curMeasures = Jiffy.utils.hashToJiffyList({id:_eventName,et:elapsedTime,rt:refStartTime});
			Jiffy.Ajax.get('/rx',{uid:uid,st:pageTimer,pn:pname,ets:curMeasures});
		}
		checkRemoveEvent(eventName);
	},

	_bulkLoad: function(){
	  var bulkmeasures = Jiffy.getMeasures();
	  var bulkmeasuresCount = bulkmeasures.length;
	  var measuresStr = "";
	  for(x=0;x<bulkmeasuresCount;x++){
		measuresStr += bulkmeasures[x].evt +":"+ bulkmeasures[x].et+ ",";
	  }
	  measuresStr = measuresStr.replace(/\,$/g,'');
	  Jiffy.Ajax.get('/rx',{uid:uid,st:pageTimer,pn:pname,ets:measuresStr});	
	},

	getMeasures: function(){
	  return marks_measures;
	},
	
	clearMeasures: function() {
		marks_measures = [];
		markers = [];
	}
  } 
}();

/*Default options
  These can be overridden by providing a globally scoped hash named 'JiffyOptions' with
  values for each option you would like to override.
  
  bool USE_JIFFY: This is stop all Jiffy code from executing calls to the server log. This will allow you to have Jiffy mark and measure tags in a page and still turn Jiffy off.
  
  bool ISBULKLOAD: This will enable bulk loading of all Jiffy measures to be sent in one call to the server logger.
  
  object/hash BROWSER_EVENTS: These are builin events such as load and unload events and the object to which we should attach a measure callback to. These will automaticly be mmaeasured against the start time mark.
  
  bool SOFT_ERRORS: In some functions we will use a try catch statement and if these are enabled they will alert with the message or the error. This is meant for ddeveloper debugging only and should left to false in a production enviroment.
  */
Jiffy.options = {
  USE_JIFFY:false,
  ISBULKLOAD: false,
  BROWSER_EVENTS: { "load":window, "DOMReady":window},
  SOFT_ERRORS: false
};

Jiffy.utils = {
  inArray: function(ary,target) {
	for ( var i=0,len=ary.length;i<len;i++ ) {
	  if ( target == ary[i] ) {
		return true;
	  }
	}
	return false;
  },
  get: function(id) {
	return document.getElementById(id);
  },
  onDOMReady: function(func) {
	if (document.addEventListener) {
	  document.addEventListener("DOMContentLoaded",func,false);
	}
	/*@cc_on @*/
	/*@if (@_win32)
	document.write("<script id=__ie_onload defer src=javascript:void(0)><\/script>");
	var script = document.getElementById("__ie_onload");
	script.onreadystatechange = function() {
	  if (this.readyState == "complete") {
		func.call();
	  }
	};
	/*@end @*/
	if ( /WebKit/i.test(navigator.userAgent)) {
	  var _timer = setInterval(function() {
		if ( /loaded|complete/.test(document.readyState)) {
		  func;
		}
	  },10);
	}
  },
  on: function(elem,evt,func,bubble) {
	bubble = bubble || false;
	if (evt=='DOMReady') {
	  this.onDOMReady(func);
	  return true;
	}
	else {
	  var el = (typeof(elem)=='string') ? this.get(elem) : elem;
	  if (window.addEventListener) {
		el.addEventListener(evt,func,bubble); return true;
	  }
	  else 
	  if (window.attachEvent) {
		el.attachEvent('on'+evt,func); return true;
	  }
	  else {
		return false;
	  }
	}
  },
  serialize: function(obj) {
	var str = '';
	if ( typeof(obj) == 'object' ) {
	  for (key in obj) { str += key+'='+obj[key]+'&'; }
	}
	return str.replace(/&$/,'');
  },
  hashToJiffyList: function(obj) {
	var str = '';
	if ( typeof(obj) == 'object' ) {
	  for (key in obj) {
		if(typeof(obj[key]) == 'object'){Jiffy.utils.hashToJiffyList(obj[key]);}
		else{str += key+':'+obj[key]+',';}
	  }
	}
	return str.replace(/,$/,'');
  },
  removeEvent: function(elem, evt, func, bubble){
	var el = (typeof(elem)=='string') ? this.get(elem) : elem;
	if (window.removeEventListener) {
	  el.removeEventListener(evt,func,bubble); return true;
	}
	else 
	if (window.detachEvent) {
	  el.detachEvent('on'+evt,func); return true;
	}
	else {
	  return false;
	}
  },
  getUID: function(){
    return Math.round(Math.random() * 1000000000000000);
  },
  hashMerge: function(hash1, hash2){
	for (var option in hash1)
	{
	  if(hash2[option] != null){
		hash2[option] = hash1[option];
	  }
	}
  }
};

Jiffy.Ajax = {
  connection: function(){
	return ((window.XMLHttpRequest) 
	? new XMLHttpRequest() : (window.ActiveXObject) 
	  ? new ActiveXObject("Microsoft.XMLHTTP") : null);
	},
  post: function(url,params,success,failure) {
	var req = this.connection();	
	var strParams = (typeof(params)=='string') ? params : Jiffy.utils.serialize(params);
	req.onreadystatechange = (!success && !failure)
	  ? function() { return; }
	  : function() {
	  if (this.status == 200) { if (success){success.call(req);} }
	  else { if(failure){failure.call(req);} }
	};
	req.open('POST',url,true);
	req.send(strParams);
  },
  get: function(url,params,success,failure) {
  	var req = this.connection();	
	var strParams = (typeof(params)=='string') ? params : Jiffy.utils.serialize(params);
	url += '?'+strParams;
	req.onreadystatechange = (!success && !failure)
	  ? function() { return; }
	  : function() {
	if (req.readyState != 4)
	  return;
		
	  if (req.status == 200) { if (success){success.call(req);} }
	  else { if(failure){failure.call(req);} }
	};

	req.open('GET',url,true);
	req.send(null);
  }
};

Jiffy.init = function(){
  //Merge the site defined options with the defaults if the site has provided overrides.
  if(window.JiffyOptions != undefined){Jiffy.utils.hashMerge(window.JiffyOptions, Jiffy.options);}
  //insure that we should execute Jiffy by reviewing the options hash
  if(Jiffy.options.USE_JIFFY == undefined || !Jiffy.options.USE_JIFFY){return};
  //Set up built in brower events to fire if they are in the options settings
  var BROWSER_EVENTS = Jiffy.options.BROWSER_EVENTS;
  for (var bEvents in BROWSER_EVENTS)
  {
	var objToBind = BROWSER_EVENTS[bEvents];
	if(objToBind){
	  Jiffy.utils.on(objToBind,bEvents, Jiffy.measure);
	}
  }
  if(Jiffy.options.ISBULKLOAD){
	//Attach body onload to call bulk loader sending all data at once.
	Jiffy.utils.on(window, "load", Jiffy._bulkLoad);
  }
};

Jiffy.init();