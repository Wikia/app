/* 
 * Copyright (c) 2010 Digital Fulcrum, LLC
 *  
 * Unless other rights have been explicitly granted by the copyright holder, this 
 * work is licensed under the Creative Commons Attribution-NonCommercial-NoDerivs 3.0 Generic
 *
 * http://creativecommons.org/licenses/by-nc-nd/3.0/
 * 
 *
 */
/* 
 * Title: GhostWriter
 * */
if(window == window.top) 
window['ghostwriter']= (function(){
var 
	 D= document
	,W= window
	,HEAD= D.getElementsByTagName("HEAD")[0]
	,UA= navigator.userAgent 
	,IE= UA.indexOf("MSIE")  > -1
	,FF= !IE && UA.indexOf("Gecko/") > -1 
	,Q= []
	,R= false
	,PARSER
	,DOMBUILDER
	,AMPRE= new RegExp("&amp;", "gi")
	,INSERTFNS= { 
		"append": function(tgt,el){
			tgt.appendChild(el); 
		}
		,"before": function(tgt,el){ 
			var p= tgt.parentNode || p;
			if(!p){ 
				return; 
			}
			p.insertBefore(el,tgt); 
		}
		,"after": function(tgt,el){ 
			var p= tgt.parentNode,sib= tgt.nextSibling; 
			if(sib)
				p.insertBefore(el,sib);
			else 
				p.appendChild(el); 

		}
	}
; 
ghostwriter.queue= Q; 
ghostwriter['handlers']= {}; 
/*
 * Function: ghostwriter
*
* 
 * Runs a script within an simulated pre-load environment, 
 * handling onload event notification and document.write() output.  
 *
 * (start code)
 * function ghostwriter( 
 *      HTMLELement  element, 
 *      Object config
 * ); 
 * (end code)
 *
 * *Note*: See <ghostwriter.loadscripts> for information on how to use 
 * HTML tags to defer all scripts.   
 *
 *
 * Returns: 
 *  null
 *
 * Parameters: 
 * element - {HTMLElement} The Element around which to insert the DOM elements.  Can also be the id of an element.
 * config - {Object} Specifies the config options for execution, including the script itself . 
 */

/* Group: config attributes 
 *
 * Property: script
 * {Function|Object} Defines the script which will be attached or 
 * executed under the pre-load emulation context. 
 *
 * Function - Will execute
 * Object - A HTMLScriptElement will be created and attached to the DOM.  Must contain either  
 * +------------------------------------------------------------------
 * |url - The url of a remote script resource 
 * |text - The text of a script to execute 
 * -----------------------------------------------------------------+
 *
 *
 * Property: insertType 
 * {Function|String} Defines how output created by script should be added to <element>.   
 *
 * Function - Called *every* time a new HTML tag is encountered. 
 * String - Must be one of the following (Default is "after"). 
 * +------------------------------------------------------------------
 * |"append" - Appends to element
 * |"before" Inserts before element 
 * |"after" Inserts immediately following element
 *  ------------------------------------------------------------------+
 *
 *
 *    
 * Property: done  
 * {Function} Callback function to run after the script 
 * and all children have been loaded.  
 * 	 
 * Group: Examples
 *
 * Topic: Simple  
 * Run a JS script that appends to the #writeto element. 
 *
 * (start code) 
 * ghostwriter( 
 *     "writeto", 
 *     { 
 *          insertType: "append",
 *          script: { text: "document.write('<h4>Hello, world</h4>');" },
 *     }
 * ); 
 * (end code) 
 * 
 * The #writeto element will now have this HTML at the end
 *
 * (start code)
 * <h4>Hello, world</h4> 
 * (end code) 
 *
 *
 * Topic: Remote script
 * Loads a script and insert any content before the first script tag on the page.  
 * When complete, execute any onload observers registered during execution 
 *
 * (start code) 
 * var scriptMap= document.getElementsByTagName("SCRIPT")[0], 
 * ghostwriter(
 *     scriptMap[scriptMap.length],
 *     { 
 *         insertType: "before", 
 *         script: { url: "/js/mylib.js" },
 *         done: ghostwriter.flushloadhandlers
 *     }
 * ); 
 * (end code) 
 *
 *
 * _/js/mylib.js_: 
 * (start code) 
 * +------------------------------------------------------------------
 * | document.write('<link href="...." rel="stylesheet" type="text/css"/>'); 
 * | document.write('<script src="http://ajax.googleapis..."><\/script>'); 
 * | document.addEventListener("load", function(){ ... } ); 
 * ------------------------------------------------------------------
 *  (end code) 
 *
 *
 * Only after the ajax.googleapis script 
 * has finished loading will the ghostwriter.flushloadhandlers() method be run.  
 
 */

function ghostwriter(element, options){ 
	PARSER= PARSER || ghostwriter['htmlstreamparser']; 
	DOMBUILDER= DOMBUILDER || ghostwriter['domtree']; 
	options= options || {}; 
	if(R){ 
		ghostwriter['running']= true; 
		Q[Q.length]= [element, options];
		return false; 
	}else
		ghostwriter['running']= false; 
	if(typeof element=='string') 
		element= D.getElementById(element); 
	if(!element) 
		throw new Error(
			"Unable to find element " + element + 
			"\nUsage: docwrite(element|elementid, options);"
		);
	return new ghostload(element,options); 
}
/** 
 * constructor 
 */
function ghostload(element, options){ 
	var 
		insertfn= getinserter(element, options['insertType']) 
		,domelement= ghostwriter['domelement']
		,tree= new DOMBUILDER(insertfn)
		,parser= new PARSER({ 
			"chars": onchars, 
			"start": onstart,
			"end": onend
		}) 
		,oldwrite= D.write
		,oldwriteln= D.writeln
		,outstanding= 0
		,curr= makescript(options['script'])
		,rawmode= false
		,loadqueue= []
		,e= null
		,inserted= false
		,gwhandlers= ghostwriter['handlers']
		,handlers= options['handlers'] || gwhandlers 
		,beginfn= handlers['begin'] ||  gwhandlers['begin']|| new Function()
		,endfn= handlers['end'] || gwhandlers['end'] || new Function()
		,starthandler= handlers['startscript'] || gwhandlers['startscript'] || new Function()
		,finishhandler= handlers['finishscript'] || gwhandlers['finishscript'] || new Function()
	; 
	D.write= write;
	D.writeln= writeln;
	R= true; 
	if('tagName' in curr){
		e= domelement("script",{});
		e.isready= false; 
		e.element= curr; 
		e.parentNode= tree.current; 
		tree.current= e; 
	}
	beginfn(options['script']); 
	//starthandler(curr); 
	addscript(curr);
	inserted= true; 
	if(!outstanding) 
		finish(); 

	function writeln(text){ 
		write(text + "\n"); 
	}
	function write(text){ 
		parser.parse(text); 	
	}
	var _ffcb= null;
	function onload(complete){
		outstanding--; 
		if(_ffcb && _ffcb.parentNode && _ffcb.parentNode === HEAD) 
			HEAD.removeChild(_ffcb); 
		if(loadqueue.length > 0){ 
			finishhandler(curr); 
			curr= loadqueue.shift(); 
			starthandler(curr); 
			AL(curr,onload);
			outstanding++;
			tree.reset(); 
			insertfn(curr); 
		}else if (FF && !complete){ 
			ghostwriter['currload']= onload; 
			_ffcb= D.createElement("SCRIPT"); 
			_ffcb.text= "ghostwriter.currload(true)";
			_ffcb.type="text/javascript"; 
			outstanding++; 
			HEAD.appendChild(_ffcb); 
		}else if(outstanding <= 0 && inserted){ 
			ghostwriter['currload']= null; 
			finish(); 
		}
	}
	function ffload(){ onload(true); } 
	function onstart(tn,alist,unary){ 
		tn= tn.toLowerCase(); 
		var attrs= attrsToObject(alist); 
		if('src' in attrs){ 
			attrs.src= tweakurl(attrs.src); 
		}else if ('name' in attrs && attrs.name == 'movie') 
			attrs.value= tweakurl(attrs.value); 

		tree.add(tn,attrs);
		if(unary) tree.close(tn); 
	}

	function onend(tn){ 
		if(tn.toLowerCase() == 'script'){ 
			var el= tree.current.element;
			addscript(el);
		}else 
			tree.close(tn); 
	}
	function onchars(text){ 
		tree.addText(text); 
	}
	function addscript(s){ 
		if(!s) { 
			return;  
		}
		var 
			 runnow= !IE && !s.src && s.text 
			,txt= runnow && 'text' in s ? s.text : ""
		;
		if(s.defer){
			tree.close(); 
			return s; 
		}
		if(typeof s == 'function'){ 
			s();
			onload(false); 
		}else if(runnow){ 
			s.setAttribute("type", "any"); 
			s.removeAttribute("language"); 
			tree.close(); 
			try { W.eval(txt); }
			catch(ignore){ 
				flog('error running script ' + txt  + " ... " + ignore.message);
			}
			outstanding++; 
			onload(false); 
		}else{  
			if(outstanding && s.src){
				loadqueue[loadqueue.length]= s; 
				tree.close('script', false); 
			}else{ 
				starthandler(s); 
				outstanding++; 
				AL(s,onload);
				curr= s;	
				tree.close(); 
			}
		}
		return s; 
	}
	function finish(){
		finishhandler(curr); 
		D.write= oldwrite; 
		D.writeln= oldwriteln; 
		if(typeof options['done']=='function') { 
			options['done'](element); 
		}
		R= false; 
		endfn(options.script); 
		if(Q.length > 0) {
			ghostwriter.apply(W, Q.shift()); 
		}
		return true; 
	}
}
function tweakurl(url){ 
	url= url.replace(AMPRE, "&"); 
	if(url.indexOf("file:")===0){
		return url.replace("file", "http"); 
	}else if(url.indexOf("//")===0){
		return "http:" + url;  
	}
	return url; 
}
function getinserter(topNode, type){
	var fn= type in INSERTFNS ? INSERTFNS[type] : INSERTFNS.append; 
	return function(childNode){ 
		fn(topNode, childNode); 	
	}
}
function makescript(sa){ 
	if(
		typeof sa == 'function' || 
			typeof sa == 'object' && 
			'nodeType' in sa && 
			'tagName' in sa && 
			sa.tagName == 'SCRIPT'
	) return sa; 
	var s= D.createElement("SCRIPT"); 
	if(typeof sa == 'string') 
		sa= {src: sa}; 
	for(var a in sa){ 
		if(a=='text'||a=='innerText'){ 
			s.text= sa[a]; 
		}
		if(typeof sa[a] != 'object') 
			s[a]= sa[a]; 
	}
	return s; 
}
function AL(script, cb){
	if(script.attachEvent){
		script.attachEvent("onreadystatechange", loadhandler);  
		script.attachEvent("onerror", loadhandler);  
	}else if (script.addEventListener){
		script.addEventListener("load", loadhandler, false); 
		script.addEventListener("error", loadhandler, false); 
	}else { 
		script.onload= loadhandler; 
		script.onerror= loadhandler; 
	}
	function loadhandler(e){ 
		if(e.type == 'error') 
			flog("uh oh ... script " + script.src + " finished shamefully"); 
		if(
			e.type == 'readystatechange' && 
			script.readyState && 
			script.readyState != 'complete' && 
			script.readyState != 'loaded'
		) 
			return; 
		if(script.detachEvent){
			script.detachEvent("onreadystatechange", arguments.callee); 
			script.detachEvent("onerror", arguments.callee); 
		}else if (script.removeEventListener){
			script.removeEventListener("load", arguments.callee, false);
			script.removeEventListener("error", arguments.callee, false);
		}else{ 
			script.onload= script.onerror= null; 
		}
		cb(); 
	}
}
function attrsToObject(a_l){ 
	var _= {}; 
	for(
		var i=0,l= a_l.length,a=a_l[i]; 
		i < l; 
		a= a_l[++i]
	){
		var n= a.name, v= a.value; 
		_[n]= v; 
	}
	return _; 

}

return ghostwriter; 
})(); 
/* 
 * Section: Utility Functions
 *
 * Function: flog
 *
 * Logs a message to the YUI console or browser console if available
 *
 *
 * Parameters: 
 * 	msg - The message to log 
 *
 * Returns: 
 * 	null 
 * 
 */
function flog(msg){ 
	if (typeof Y == 'object' && typeof Y.log == 'function')
		Y.log(msg); 
	else if(typeof console== 'object' && 'log' in console) 
		console.log(msg); 
}
window['flog']= flog; 


/* 
 * Title: Load Handlers 
 *
 * The onload and DOMContentReady events (and the IE hacks) 
 * must be
 * o delayed until all in-page scripts have finished
 * o be re-fired when scripts unwittingly register for these events post-load
 *
 * Override IE's documentElement.doScroll() method or (in IE8+) 
 * the Element.prototype.doScroll method to prevent the 
 * advanced frameworks from firing "too early." 
 *
 * Override the .addEventListener and attachEvent methods so 
 * registration can be intercepted and the callback can 
 * be executed later. 
 *
 * Function: ghostwriter.flushloadhandlers
 * Execute onload and DOMReady callback functions registered after load event 
 * This is handled automatically when using <ghostwriter.loadscripts> but 
 * can also be triggered manually. 
 *
 * (start code)
 * ghostwriter.flushloadhandler()
 * (end code)
 *
 *
 * Parameters: 
 * none
 *
 * Returns: 
 * null
 */ 
window['ghostwriter']['flushloadhandlers']= (function(){ 
var 
 D= document
,W= window
,IE= "v"=="\v"
,domList= { 
	DOMContentLoaded:IE?false:[D], 
	onreadystatechange:IE?[D, W]:false, 
	load:IE?false:[W], 
	onload:IE?[W]:false
}
,_owEvents= {
	DOMContentLoaded:IE?false:[D,W], 
	onreadystatechange:IE?[D,W]:false, 
	load:IE?false:[W], 
	onload:IE?[W]:false
}
,_owDOM= [ W, D ]
,_owQ= {}
,wLoadFn= W.onload 
,haveFlushed= false
,RS= (function(){ 
	var _,$;
	if(
		typeof Element == 'object' && 
		typeof Element.prototype == 'object' && 
		Element.prototype.doScroll 
	)
		$= Element.prototype; 
	else if(D.documentElement && D.documentElement.doScroll)
		$= D.documentElement;
	if($){
		_= $.doScroll;
		$.doScroll=new Function("throw new Error;");
		return function(){
			$.doScroll= function(a){ 
				_.call(this,a); 
			}
		}
	}else{
		return new Function();
	}
})()
; 
for(var e in _owEvents){
	if(!_owEvents[e])
		continue;
	for (var 
		a=_owEvents[e], i=0, l=a.length, o=a[i]; 
		i < l; 
		o= a[++i]
	){ 
		_owQ[e]= _owQ[e] || {}; 
		_owQ[e][o]= _owQ[e][o] || []; 
		if(o.addEventListener)
			o.addEventListener(e,readyHandler(o,e),false);
		else if(o.attachEvent)
			o.attachEvent(e,readyHandler(o,e));

	}
}
for(var j=0, m= _owDOM.length; j < m ; j++){ 
	var _e= _owDOM[j]; 
	if(_e.addEventListener){ 
		_e._aeproxy= _e.addEventListener; 
		_e.addEventListener= proxyfn; 
	}else if (_e.attachEvent){ 
		_e._aeproxy= _e.attachEvent; 
		_e.attachEvent= proxyfn; 
	}
}

W.onload= null; 

function flushloadhandlers(eventtype){
	eventtype= eventtype && eventtype in _owQ ? eventtype : ""; 
	wLoadFn= W.onload || wLoadFn; 
	W.onload= null; 
	if(wLoadFn){ 
		var _event=  IE ? "onload" : "load" 
		_owQ[_event][W].push(wLoadFn); 
		wLoadFn= null; 
	}
	for(var evt in _owQ){
		if(eventtype && eventtype != evt) 
			continue; 
		var o= _owQ[evt],
		    idx= 0, 
		    el= null,
		    elo= domList[evt]
		; 
		for(var _e in o){ 
			el=  elo[idx++]; 
			var  de= _owEvents[evt][_e]
			    ,cba= o[_e]
			    ,cb
			; 
			if(!de) 
				continue; 
			while((cb= cba.shift())){
				try{cb.call(el, de);}
				catch(ex){flog("error running callback: " + cb + "\n" + ex.message);}
			}
		}
		if(eventtype)break; 
	}
	haveFlushed= true; 
	RS(); 
}

function readyHandler(a,b){ 
	var c= _owEvents,f= _owQ; 
return function(d){
     	var e= a.readyState;
	if(
		b == 'onreadystatechange' && 
		e != 'complete' && 
		e != 'loaded'
	)return;
	c[b][a]= IE ? copy(d) : d; 
	if(f[b][this].length && haveFlushed)
		flushloadhandlers(b); 
}
}
function proxyfn(type,cb){ 
	if(type in _owEvents && type in _owQ && this in _owQ[type]){ 
		_owQ[type][this].push(cb); 
		if(this in _owEvents[type] && haveFlushed){
			setTimeout(flushloadhandlers, 0);					
		}
	}else{ 
		if(arguments.length > 2){
			this._aeproxy(type,cb, arguments[2]);
		}else { 
			this._aeproxy(type,cb); 
		}
	}	
}
function copy(o){ 
	var _= {}; 
	for(var i in o)
		_[i]= o[i]; 	
	return _; 
}
return flushloadhandlers; 
})(); 

/* Title: DOMTree 
 */
window['ghostwriter']['domtree']= (function(){
	var 

		IGNORE= {
			 'html':false
			,'head':false
			,'body':false
			,'noscript':true
			,'noembed':true
			,'title':true
			,'meta':true
		}
		,ghostwriter= window['ghostwriter']
		,ELEMENT
	; 
function appendToBody(element){ 
	document.body.appendChild(element); 
}
/* 
 * Class: domtree
 * An abstraction of an element tree 
 *
 * (start code) 
 * function domtree({Function} insertFn))
 * (end code)
 *
 * Parameters: 
 * insertFn - {Function} Called when inserting top-level tree elements 
 *
 */
function domtree(insertFn){
	ELEMENT= ELEMENT || ghostwriter['domelement']; 
	var _self= this; 
	this.inserter= typeof insertFn=='function' ? insertFn : appendToBody;
	this.current=  { 
		'tagName': null
		,'appendChild': function(element){ 
			_self.elements.push(element); 
			_self.inserter(element); 
			return this; 
		}
		,'close': function(){ return this; } 
		,'parentNode': null 
		,'ready': function(){ return true; }
	}; 
	this.current.parentNode= this.current; 
	this.previous= null; 
	this.elements= []; 
	this.ignoring= 0; 
}
domtree.prototype= {
	addText: function(text){ 
		var tag= ELEMENT("", text); 
		if(!this.ignoring) 
			this.current.appendChild(tag.element); 
		return this; 
	}
	/* Method: add
	 * Add a new element and set it as the current 
	 * head 
	 *
	 * Parameters: 
	 *  tagName - {String} Name of the tag 
	 *  attributes - {Object} element attributes 
	 *
	 *  Returns: 
	 *  this
	 */
	,add: function(tagName, attributes){ 
		attributes= typeof attributes == 'undefined' ? {} : attributes; 
		if(tagName in IGNORE){ 
			if(IGNORE[tagName])
				this.ignoring++; 
			return this; 
		}else if(this.ignoring)
			return this;  
		var 
			 p= this.current
			,tag= this.current= ELEMENT(tagName, attributes)
		; 
		tag.parentNode= p;
		if(tag['ready']()){ 
			p.appendChild(tag.element); 
		}
		return this; 
	},
	/* Method: reset
	 * Reset the _current_ pointer back to the root element 
	 * 
	 * Parameters: 
	 * none
	 *
	 * Return: 
	 * this
	 */
	reset: function(){ 
		while(this.current != this.current.parentNode) 
			this.current= this.current.parentNode; 
		this.ignoring= 0; 
		return this; 
	}
	/* Method: close 
	 * Close the current element pointer and go back to the parent 
	 *
	 * Parameters: 
	 *  tn - {String} name of the tag to close 
	 *  attach - {Boolean} force attaching the element we are closing 
	 *
	 *  Returns: 
	 *  this
	 */

	,close: function(tn,attach){ 
		tn= tn||"";
		tn= tn.toLowerCase(); 
		if(attach==null) attach= true; 
		if(tn && tn in IGNORE && IGNORE[tn] && this.ignoring) { 
			this.ignoring--;
			return this; 
		}else if (tn && tn in IGNORE){ 
			return this; 	
		}else if(this.ignoring){
			return this; 
		}
		var 
			 wasready= this.current['ready']()
			,el= wasready ||  
				(this.current.close() && this.current['ready']())
		;
		this.current= this.current.parentNode;  
		if(!el){ 
			throw new Error("attempting to close tag that is not ready"); 
		}
		if(attach && !wasready){
			if(this.current){ 
				try { this.current.appendChild(el);}
				catch(e){ flog(e.message); }
			}else{
				this.inserter(el);
			}
		}
			
		return this; 
	}
}
domtree.prototype['addText']= domtree.prototype.addText; 
domtree.prototype['add']= domtree.prototype.add; 
domtree.prototype['close']= domtree.prototype.close; 
return domtree; 
})(); 

/* 
 * Title: DOMElement 
 *
 * Section: Internal Utility Classes 
 *
 * Class: domelement
 * Abstraction for HTML DOM Elements which handles
 * cross-browser creation, attribute setting 
 * and event handling 
 *
 * (start code) 
 * new domelement( 
 *       {String} tagName, 
 *       {Object} attributes
 * ); 
 * (end code) 
 *
 *
 * Parameters: 
 * tagName - {String} The element's tag name (e.g. OBJECT; TABLE; DIV; IMG)
 * attributes - {Object} The element's attribute list  
 *
 * Returns: 
 * A <domelement> 
 *
 * Property: element
 * {HTMLElement} The actual host element 
 *
 * (start code)
 * this.element
 * (end code) 
 *
 */
window['ghostwriter']['domelement']= (function(){
var 
 D= document
,W= window
,UA= navigator.userAgent
,IE= UA.indexOf("MSIE")>-1?true:false
,WK= UA.indexOf("WebKit")>-1?true:false 
,READYONOPEN= {"style":false,"script":false}
,ELQUIRKS= { }
; 
domelement.prototype={ 
/* 
 * Method: setAttribute
 * Sets the attribute name to the value, handling 
 *
 * Parameters: 
 *   name - The name of the attribute
 *   value - The value of the attribute 
 */
	setAttribute: function(name,value){ 
		return this.element.setAttribute(name,value); 
	}
/* 
 * Method: appendChild 
 * Appends to the element  
 *
 * (start code) 
 * function appendChild(
 *     {<domelement>|HTMLElement|String} appendElement, 
 * )
 * (end code)
 *  
 * Parameters: 
 *   appendElement - Appends either an HTML ELement, <domelement> or text string  
 *
 * Returns: 
 *    this
 *
 */

	,appendChild: function(e){ 
		var el= this.element; 
		if('canHaveChildren' in el  && !el.canHaveChildren){ 
			var t= 'data' in e ? e.data : e.textContent; 
			if(!t)
				return false; 
			el.text += t;
		}else{ 
			el.appendChild(e);
		}
		return this; 
	}
/* 
 * Method: ready 
 * Tests whether or not the element can be appended to the 
 * DOM.  Some elements, such as *object* and *style* 
 * elements in Internet Explorer, 
 * must be *closed* before they can be appended. 
 *
 * Parameters: 
 * none 
 *
 * Returns: 
 * true - The object can be appended
 * false - The object cannot be appended 
 *
 */
	,ready: function(){
		if(this.isready) 
			return this.element; 
		else 
			return false; 
	} 
	,close: function(){ 
		this.isready= true; 
		return this.element; 
	}
/* 
 * Method: create 
 * Creates the actual Host element, using IE-specific 
 * quirks where appropriate.  Child classes that need 
 * to implement additional quirks can override. 
 *
 * Parameters: 
 * none 
 *
 * Returns: 
 * {HTMLElement} 
 *
 */

	,create: (function(){ 
	var get= IE ? 
		function(a,b){ 
			var c,d=["<" + a];
			for(var e in b) 	
				d[d.length]= e + '="' + b[e] + '"';
			d[d.length]= ">"; 
			var f= D.createElement(d.join(" ")); 
			return f; 
		}
		: function(a,b){ 
			var c= D.createElement(a); 
			for(var d in b) 
				c.setAttribute(d,b[d]);
			return c; 
		}
	return function(a,b){ 
		a= a.toLowerCase();
		b= typeof b =='object'?b:{}; 
		return get.call(this,a,b);
	}})()
}
domelement.prototype['setAttribute']= domelement.prototype.setAttribute;  
domelement.prototype['appendChild']= domelement.prototype.appendChild;  
domelement.prototype['ready']= domelement.prototype.ready;  
domelement.prototype['close']= domelement.prototype.close;  
domelement.prototype['create']= domelement.prototype.create;  
/* 
 * Classes: Element Quirks  
 * A place to store any tag-specific quirkiness 
 *
 */

/* Class: domlink
 * Override for LINK elements.
 *
 * Quirkiness: 
 * Only add the first reference to an external 
 * stylesheet. 
 */   
ELQUIRKS['link']= (function(){
function domlink(tn,a){
	if(a.href && a.href in C) 
		return new domtext("",""); 
	C[a.href]= true; 
	return new domelement(tn,a); 
}
var C= {}; 
return domlink; 
})(); 
/* Class: domtext 
 * HTMLTextNode. 
 *
 * Quirkiness: 
 * Text nodes need to be added to the DOM in a certain 
 * way for different parent types on different browsers. 
 */

domtext.prototype= new domelement(); 
ELQUIRKS[""]= domtext; 

/* Classes: Internet Explorer Element Quirks */
if(IE)(function(){ 
domobject_ie.prototype= new domelement(); 
domstyle_ie.prototype= new domelement(); 
/* 
 * Class: domtable_ie
 * IE TABLE element. 
 * 
 * Quirkiness: 
 * IE TABLE rows (TR) elements can only be appended
 * to TBODY elements, not TABLEs directly.  
 */
function domtable_ie(){ 
	domelement.apply(this, arguments); 
	return this; 
}
domtable_ie.prototype= new domelement(); 
/* Method: appendChild
 * Add child to a TABLE, check for TBODY
 */
domtable_ie.prototype.appendChild= function(e){ 
	if(e.tagName == 'TBODY'){ 
		this.tbody= e; 
		this.element.appendChild(e); 
		return this; 
	}else if(!this.tbody){ 
		this.tbody= document.createElement("TBODY"); 
		this.element.appendChild(this.tbody); 
	}
	this.tbody.appendChild(e); 
	return this; 
}
/* Class: domstyle_ie
 * IE STYLE element
 *
 * Quirkiness: 
 * Crash when adding @import rule 
 */
function domstyle_ie(tn,a){ 
	this._text= ""; 
	this._a= a; 
	this.isready= false; 
	return this; 
}
domstyle_ie.prototype['create']=function(tn,attrs){ 
	return attrs; 
}
domstyle_ie.prototype['appendChild']=function(el){
	var t= 'data' in el ? el.data : el.text; 
	if(!t) return; 
	this._text += t; 
}
/* Method: appendChild 
 * Remove @import rules and re-add 
 *
 * Quirkiness: 
 * IE will trigger some kind of soft crash 
 * (CPU hits 100% and process must be killed 
 * with force) when adding @import rules to 
 * STYLE elements.  
 *
 * Find and remove any @import rule and make a LINK  
*/
domstyle_ie.prototype['close']=(function(){ 
	var 
	    _A= "STYLE"
	   ,_B= new RegExp("(?:^url\\([\"']?|[\"']?\\)$)", "gi")
	   ,_C= "text/css"
	   ,_D= ["<span>&nbsp;</span><"+_A]
	   ,_E= D.getElementsByTagName("HEAD")[0]
	;
return function(){
	var 
		a= this._a
		,b= ""
		,c= _D.slice() 
		,d= D.createElement("DIV")
		,e
	; 
	for(var f in a)
	    c[c.length]= [f,'"'+a[f]+'"'].join("=")
	c[c.length]= [">",this._text,"</",_A,">"].join("");
	d.innerHTML= c.join(" ");
	e= this.element= d.lastChild; 
	e= e.styleSheet.imports; 
	for(var i=0,l=e.length; i < l; i++){ 
		var 
		    p= e[i]
		   ,r= p.href
		   ,k= (new domelement(
		   	"LINK",
			{
			   href:r.replace(_D,"")
			  ,type:"text/css"
			  ,rel:"stylesheet"
			}
		   )).close()
		;
		_E.appendChild(k)
	}
	a=b=c=d=e=p=k=null; 
	this.isready= true; 
	return this.element; 
}})();
/* 
 * Class: domobject_ie
 * IE OBJECT element
 *
 * Quirkiness: 
 * Internet Explorer OBJECT elements have especially 
 * strange behavior.  Instead of being able to 
 * call <appendChild>() to add PARAM elements, 
 * this must be done using innerHTML on an 
 * anonymous DIV
 *
 */


function domobject_ie(tn,a){ 
	domelement.apply(this, arguments); 
	this.isready= false; 
	return this; 
}
var _p= {
/* Method: setAttribute
 * 
 */
	'setAttribute': function(name,value){
		this.element.a[name]= value; 
	},
/* Method: appendChild 
*/

	'appendChild': function(e){ 
		if(!e.tagName) return null; 
		if(e.tagName.toUpperCase() === 'PARAM'){ 
			var 
			 n= e.getAttribute("name")
			,p= this.element.p
			;
			if(n) 
				p[n]= e.getAttribute("value"); 
		}
		return this;
	}
/* Method: close 
 * Close the element and create the native host OBJECT 
 * using innerHTML on an anonymous DIV 
 */
	,'close': function(){
		var 
			 c= this.element
			,a= c.a
			,b= "PARAM"
			,d= D.createElement("DIV")
			,e= "object"
			,h=["<"+e]
			,p= c.p
		;
		for(var an in a)
			h[h.length]= [an,'="',a[an],'"'].join("");
		h[h.length]= ">";
		for(var pn in p)
			h[h.length]= [
				 '<',b,' name="',pn,'" value="',p[pn],'"></',b,'>'
			].join("")
		h[h.length]="</"+e+">";
		d.innerHTML= h.join(" "); 
		this.isready= true; 
		this.element= d.firstChild;
		a=c=d=h=p=null;
		return this.element;
	}

	,'create': function(t,a){ 
		a.type= "application/x-shockwave-flash";
		return {a:a,p:{}}; 
	}
}
for(var p in _p)
	domobject_ie.prototype[p]= _p[p]; 
ELQUIRKS['object']= domobject_ie; 
ELQUIRKS['table']= domtable_ie; 
ELQUIRKS['style']= domstyle_ie; 
})(); 

if(WK)ELQUIRKS.noembed= (function(){ 
_.prototype= new domelement(); 
_.prototype['create']= function(){return D.createElement("noscript");}
function _(){return domelement.apply(this, arguments);}
return _; 
})(); 
function domtext(empty, textcontent){
	this.element= D.createTextNode(textcontent);		
	this.isready= true; 
	return this; 
}
/** 
* @constructor
*/

function domelement(tn, attrs){
	if(W==this) 
		return new domelement(tn, attrs); 
	if(!tn) return this; 
	var src= attrs.src; 
	if(src) 
		delete attrs.src; 
	this.tagName= tn.toUpperCase(); 
	this.element= this.create(tn,attrs);
	if(src)
		this.setAttribute('src', src); 
	this.isready= tn in READYONOPEN ? READYONOPEN[tn] : true; 

	return this;
}
return function (tn,attributes){
	tn= tn.toLowerCase(); 
	if(tn in ELQUIRKS) 
		return new ELQUIRKS[tn](tn,attributes); 
	else 
		return new domelement(tn,attributes); 
}

})(); 


window['ghostwriter']['htmlstreamparser']= (function(){
var 
startTag= /^<(\w+)((?:\s+[\w\-:]+(?:\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|[^>\s]+))?)*)\s*(\/?)>/,
endTag= /^<\/(\w+)[^>]*>/,
commentregex= /<!--(.*?)-->/g, 
cdataregex= /<!\[CDATA\[(.*?)]]>/g,
attr= /([\w:]+)(?:\s*=\s*(?:(?:"((?:\\.|[^"])*)")|(?:'((?:\\.|[^'])*)')|([^>\s]+)))?/g,
empty= makeMap("xml,area,base,basefont,br,col,frame,hr,img,input,isindex,link,meta,param,embed"),
block= makeMap("address,applet,blockquote,button,center,dd,del,dir,div,dl,dt,fieldset,form,frameset,hr,iframe,ins,isindex,li,map,menu,noframes,noscript,object,ol,p,pre,script,table,tbody,td,tfoot,th,thead,tr,ul"), 
inline= makeMap("abbr,acronym,applet,b,basefont,bdo,big,br,button,cite,code,del,dfn,em,font,i,iframe,img,input,kbd,label,map,object,q,s,samp,script,select,small,strike,strong,sub,sup,textarea,tt,u,var"),
closeSelf= makeMap("colgroup,dd,dt,li,options,p,td,tfoot,th,thead,tr"), 
fillAttrs= makeMap("checked,compact,declare,defer,disabled,ismap,multiple,nohref,noresize,noshade,nowrap,readonly,selected"), 
special= makeMap("script,style,iframe"),
handlerList= "chars,comment,start,end".split(","),
tagRegexMap= { }
;

HTMLParser.prototype= { 
	'parse': parse,
	'flush': flush
}
function HTMLParser(handlers){
	handlers= handlers || {}; 
	this.stack= []; 
	this.remainder= "";
	this.handlers= handlers || {}; 
	this.parsecalls= 0; 
	this.lastendtagindex= -1; 
	for(var 
		i=0,l=handlerList.length,o= handlerList[i]; 
		i < l; 
		o= handlerList[++i]
	){
		if(!(o in this.handlers)){ 
			handlers[o]= new Function(); 
		}
	}
}
function parse(html){
	html= this.remainder + html; 
	var 
		index
		,chars
		,match 
		,stack= this.stack
		,last= html
		,handler= this.handlers
		,lastTag= ""
		,iterations= 0
	;
	this.remainder= ""; 
	this.parsecalls++; 
	stack.last= function(){
		return this[ this.length - 1 ];
	};

	while (html){
		lastTag= this.stack[this.stack.length - 1] 
		chars= true;
		iterations++; 
		if(!lastTag || !special[lastTag]){
			if(html.indexOf("<!--")===0){
				index= html.indexOf("-->");
				if (index >= 0){
					handler['comment'](html.substring(4, index));
					html= html.substring(index + 3);
					chars= false;
				}
			}else if (html.indexOf("</")===0){
				match= html.match(endTag);
				if (match){
					html= html.substring(match[0].length);
					match[0].replace(endTag, parseEndTag);
					chars= false;
				}
			}else if (html.indexOf("<")===0){
				match= html.match(startTag);

				if (match){
					html= html.substring(match[0].length);
					match[0].replace(startTag, parseStartTag);
					chars= false;
				}else{ 
					html= html.replace(/^<[^>]*>/, ""); 
				}
			}
			if(chars){
				index= html.indexOf("<");
				var 
					text= index < 0 ? html : html.substring(0, index)
					,c=lastTag
				;
				html= index < 0 ? "" : html.substring(index);
				if(!(c in special)) 
					text= Encoder['htmlDecode'](text); 
				if(text.length > 0)
					handler['chars'](text);
			}
		}else if(
			html.indexOf("</") > -1 && 
			html.match(new RegExp("<\/" + lastTag + "[^>]*>", "i"))
		){
			var 
			  len= html.length, 
			  re= tagRegexMap[lastTag]= tagRegexMap[lastTag] ||  
				new RegExp("((?:.|\n|\r)*?)<\/" + lastTag + "[^>]*>", "i")
			;
			html= html.replace(
				re,	
				findTagBody
			);
			if(len > html.length){ 
				parseEndTag("", lastTag);
			}
		}
		if (html==last){
			this.remainder= html; 
			return this; 
		}
		last= html;
	}
	parseEndTag();
	function findTagBody(all, text){
		text= text
			.replace(commentregex, "$1")
			.replace(cdataregex, "$1")
		;
		handler['chars'](text);
		return "";
	}
	function parseStartTag(tag, tagName, rest, unary){
		tagName= tagName.toLowerCase(); 	
		if (block[ tagName ]){
			while (stack.last() && inline[ stack.last() ]){
				parseEndTag("", stack.last());
			}
		}
		if (closeSelf[ tagName ] && stack.last()== tagName){
			parseEndTag("", tagName);
		}
		unary= empty[ tagName ] || !!unary;
		if (!unary)
			stack.push(tagName.toLowerCase());
		var attrs= [];
		rest.replace(attr, function(match, name){
			var value= arguments[2] ? arguments[2] :
				arguments[3] ? arguments[3] :
				arguments[4] ? arguments[4] :
				fillAttrs[name] ? name : "";
			attrs.push({
				name: name,
				value: value,
				escaped: value.replace(/(^|[^\\])"/g, '$1\\\"') //"
			});
		});
		handler['start'](tagName, attrs, unary);
	}
	function parseEndTag(tag, tagName){
		if (!tagName)
			return;
		var found= false,tstack= stack.slice(); 
		tagName= tagName.toLowerCase(); 
		for (var pos= stack.length - 1; pos >= 0; pos--){
			if (stack[pos]== tagName){
				found= true; 
				break;
			}
		}
		if (found){
			stack.length= pos;
			for (var i= tstack.length - 1; i >= pos; i--){
				handler['end'](tstack[i]);
			}
		}
	}
	return false;
}
function flush(){
	var h= this.handlers, t= ""; 
	if(this.remainder.length > 0)
		h.chars(this.remainder);
	while((t= this.stack.shift()))
		h.end(t); 
	this.remainder= ""; 
}
function makeMap(str){
	var obj= {}, items= str.split(",");
	for (var i= 0; i < items.length; i++)
		obj[ items[i] ]= true;
	return obj;
}

var Encoder= (function(){ 
var 
H= '&nbsp;,&iexcl;,&cent;,&pound;,&curren;,&yen;,&brvbar;,&sect;,&uml;,&copy;,&ordf;,&laquo;,&not;,&shy;,&reg;,&macr;,&deg;,&plusmn;,&sup2;,&sup3;,&acute;,&micro;,&para;,&middot;,&cedil;,&sup1;,&ordm;,&raquo;,&frac14;,&frac12;,&frac34;,&iquest;,&agrave;,&aacute;,&acirc;,&atilde;,&Auml;,&aring;,&aelig;,&ccedil;,&egrave;,&eacute;,&ecirc;,&euml;,&igrave;,&iacute;,&icirc;,&iuml;,&eth;,&ntilde;,&ograve;,&oacute;,&ocirc;,&otilde;,&Ouml;,&times;,&oslash;,&ugrave;,&uacute;,&ucirc;,&Uuml;,&yacute;,&thorn;,&szlig;,&agrave;,&aacute;,&acirc;,&atilde;,&auml;,&aring;,&aelig;,&ccedil;,&egrave;,&eacute;,&ecirc;,&euml;,&igrave;,&iacute;,&icirc;,&iuml;,&eth;,&ntilde;,&ograve;,&oacute;,&ocirc;,&otilde;,&ouml;,&divide;,&Oslash;,&ugrave;,&uacute;,&ucirc;,&uuml;,&yacute;,&thorn;,&yuml;,&quot;,&amp;,&lt;,&gt;,&oelig;,&oelig;,&scaron;,&scaron;,&yuml;,&circ;,&tilde;,&ensp;,&emsp;,&thinsp;,&zwnj;,&zwj;,&lrm;,&rlm;,&ndash;,&mdash;,&lsquo;,&rsquo;,&sbquo;,&ldquo;,&rdquo;,&bdquo;,&dagger;,&dagger;,&permil;,&lsaquo;,&rsaquo;,&euro;,&fnof;,&alpha;,&beta;,&gamma;,&delta;,&epsilon;,&zeta;,&eta;,&theta;,&iota;,&kappa;,&lambda;,&mu;,&nu;,&xi;,&omicron;,&pi;,&rho;,&sigma;,&tau;,&upsilon;,&phi;,&chi;,&psi;,&omega;,&alpha;,&beta;,&gamma;,&delta;,&epsilon;,&zeta;,&eta;,&theta;,&iota;,&kappa;,&lambda;,&mu;,&nu;,&xi;,&omicron;,&pi;,&rho;,&sigmaf;,&sigma;,&tau;,&upsilon;,&phi;,&chi;,&psi;,&omega;,&thetasym;,&upsih;,&piv;,&bull;,&hellip;,&prime;,&prime;,&oline;,&frasl;,&weierp;,&image;,&real;,&trade;,&alefsym;,&larr;,&uarr;,&rarr;,&darr;,&harr;,&crarr;,&larr;,&uarr;,&rarr;,&darr;,&harr;,&forall;,&part;,&exist;,&empty;,&nabla;,&isin;,&notin;,&ni;,&prod;,&sum;,&minus;,&lowast;,&radic;,&prop;,&infin;,&ang;,&and;,&or;,&cap;,&cup;,&int;,&there4;,&sim;,&cong;,&asymp;,&ne;,&equiv;,&le;,&ge;,&sub;,&sup;,&nsub;,&sube;,&supe;,&oplus;,&otimes;,&perp;,&sdot;,&lceil;,&rceil;,&lfloor;,&rfloor;,&lang;,&rang;,&loz;,&spades;,&clubs;,&hearts;,&diams;'.split(",")
,C= '&#160;,&#161;,&#162;,&#163;,&#164;,&#165;,&#166;,&#167;,&#168;,&#169;,&#170;,&#171;,&#172;,&#173;,&#174;,&#175;,&#176;,&#177;,&#178;,&#179;,&#180;,&#181;,&#182;,&#183;,&#184;,&#185;,&#186;,&#187;,&#188;,&#189;,&#190;,&#191;,&#192;,&#193;,&#194;,&#195;,&#196;,&#197;,&#198;,&#199;,&#200;,&#201;,&#202;,&#203;,&#204;,&#205;,&#206;,&#207;,&#208;,&#209;,&#210;,&#211;,&#212;,&#213;,&#214;,&#215;,&#216;,&#217;,&#218;,&#219;,&#220;,&#221;,&#222;,&#223;,&#224;,&#225;,&#226;,&#227;,&#228;,&#229;,&#230;,&#231;,&#232;,&#233;,&#234;,&#235;,&#236;,&#237;,&#238;,&#239;,&#240;,&#241;,&#242;,&#243;,&#244;,&#245;,&#246;,&#247;,&#248;,&#249;,&#250;,&#251;,&#252;,&#253;,&#254;,&#255;,&#34;,&#38;,&#60;,&#62;,&#338;,&#339;,&#352;,&#353;,&#376;,&#710;,&#732;,&#8194;,&#8195;,&#8201;,&#8204;,&#8205;,&#8206;,&#8207;,&#8211;,&#8212;,&#8216;,&#8217;,&#8218;,&#8220;,&#8221;,&#8222;,&#8224;,&#8225;,&#8240;,&#8249;,&#8250;,&#8364;,&#402;,&#913;,&#914;,&#915;,&#916;,&#917;,&#918;,&#919;,&#920;,&#921;,&#922;,&#923;,&#924;,&#925;,&#926;,&#927;,&#928;,&#929;,&#931;,&#932;,&#933;,&#934;,&#935;,&#936;,&#937;,&#945;,&#946;,&#947;,&#948;,&#949;,&#950;,&#951;,&#952;,&#953;,&#954;,&#955;,&#956;,&#957;,&#958;,&#959;,&#960;,&#961;,&#962;,&#963;,&#964;,&#965;,&#966;,&#967;,&#968;,&#969;,&#977;,&#978;,&#982;,&#8226;,&#8230;,&#8242;,&#8243;,&#8254;,&#8260;,&#8472;,&#8465;,&#8476;,&#8482;,&#8501;,&#8592;,&#8593;,&#8594;,&#8595;,&#8596;,&#8629;,&#8656;,&#8657;,&#8658;,&#8659;,&#8660;,&#8704;,&#8706;,&#8707;,&#8709;,&#8711;,&#8712;,&#8713;,&#8715;,&#8719;,&#8721;,&#8722;,&#8727;,&#8730;,&#8733;,&#8734;,&#8736;,&#8743;,&#8744;,&#8745;,&#8746;,&#8747;,&#8756;,&#8764;,&#8773;,&#8776;,&#8800;,&#8801;,&#8804;,&#8805;,&#8834;,&#8835;,&#8836;,&#8838;,&#8839;,&#8853;,&#8855;,&#8869;,&#8901;,&#8968;,&#8969;,&#8970;,&#8971;,&#9001;,&#9002;,&#9674;,&#9824;,&#9827;,&#9829;,&#9830;'.split(",")
;
return{ 
"EncodeType": "entity", 
"isEmpty": function(val){
	if(val){
		return ((val===null) || val.length==0 || /^\s+$/.test(val));
	}else{
		return true;
	}
},
"HTML2Numerical": function(s){
	var arr1= H,arr2= C;
	return this['swapArrayVals'](s,arr1,arr2);
},	
"NumericalToHTML": function(s){
	var arr1= C, arr2= H;
	return this['swapArrayVals'](s,arr1,arr2);
},
"numEncode": function(s){
	if(this['isEmpty'](s)) return "";
	var e = "";
	for (var i = 0; i < s.length; i++)
	{
		var c = s.charAt(i);
		if (c < " " || c > "~")
		{
			c = "&#" + c.charCodeAt() + ";";
		}
		e += c;
	}
	return e;
},
"htmlDecode": function(s){
	var a,c,m,d= s;
	if(this['isEmpty'](d)) return "";
	d = this['HTML2Numerical'](d);
	a=d.match(/&#[0-9]{1,5};/g);
	if(a!==null){
		for(var x=0;x<a.length;x++){
			m = a[x];
			c = m.substring(2,m.length-1); 
			if(c >= -32768 && c <= 65535){
				d = d.replace(m, String.fromCharCode(c));
			}else{
				d = d.replace(m, "");
			}
		}			
	}
	return d;
},		
"htmlEncode": function(s,dbl){
	if(this['isEmpty'](s)) return "";
	dbl = dbl | false; 
	if(dbl){
		if(this['EncodeType']=="numerical"){
			s = s.replace(/&/g, "&#38;");
		}else{
			s = s.replace(/&/g, "&amp;");
		}
	}
	if(this.EncodeType=="numerical" || !dbl){
		s = this['HTML2Numerical'](s);
	}
	s = this['numEncode'](s);
	if(!dbl){
		s = s.replace(/&#/g,"##AMPHASH##");
	
		if(this['EncodeType']=="numerical"){
			s = s.replace(/&/g, "&#38;");
		}else{
			s = s.replace(/&/g, "&amp;");
		}

		s = s.replace(/##AMPHASH##/g,"&#");
	}
	s = s.replace(/&#\d*([^\d;]|$)/g, "$1");
	if(!dbl){
		s = this['correctEncoding'](s);
	}
	if(this['EncodeType']=="entity"){
		s = this['NumericalToHTML'](s);
	}

	return s;					
},
"correctEncoding": function(s){
	return s.replace(/(&amp;)(amp;)+/,"$1");
},
"swapArrayVals": function(s,arr1,arr2){
	if(this['isEmpty'](s)) return "";
	var re;
	if(arr1 && arr2){
		if(arr1.length == arr2.length){
			for(var x=0,i=arr1.length;x<i;x++){
				re = new RegExp(arr1[x], 'g');
				s = s.replace(re,arr2[x]);
			}
		}
	}
	return s;
}
}
})(); 
return HTMLParser; 
})(); 


/* Section: Script Loading */
window['ghostwriter']['loadscripts']= function(){
var	
	 D= document
	,H= D.getElementsByTagName("HEAD")[0]
	,G= window['ghostwriter']
	,DV= D.defaultView
	,IE= "v" == "\v"
	,X= DV && DV.getComputedStyle ? "background-position" : "backgroundPositionX" 
	,Y= "type"
	,T= "text/html"
	,J= "text/javascript"
	,JS= "javascript"
	,L= "language"
	,C= "script"
	,F= "defer"
	,S= "src"
	,DS= F+S
	,DC= F+C
	,FL= []
	,RE= new RegExp("(?:^url\\([\"']?|[\"']?\\)$)", "gi")
	,_CURR= null
	,MAP= (function(a){ 
		var _= []; 
		for(var b=0,c=a.length;b<c;b++)
			_[_.length]= a[b][1];
		return _; 
	})( find().sort(sorter) )
	,SH
;
D.write= D.writeln= new Function("a","flog('ILLEGAL WRITE: ' + a);");
if(D.execCommand){try{D.execCommand("BackgroundImageCache",false,true);}catch(e){}}
load(); 
function load(){
	var 
	    a= MAP.shift()
	   ,SH= 'scrollHeight' in D.documentElement ? 
	   	D.documentElement.scrollHeight : 
	   	D.documentElement.clientHeight
	   ,type= (a && a[0].getAttribute(Y)||"").toLowerCase()
	   ,lang= (a && a[0].getAttribute(L)||"").toLowerCase()
	; 
	if(!a){
		return simload(); 
	}else if(!type||type.indexOf(JS)>=0||lang.indexOf(JS)>=0){ 
		return load(); 
	}else if(type.indexOf(JS) <0 && type.indexOf(DC) <0){ 
		a[0].setAttribute(Y,T);
		a[1].parentNode.replaceChild(a[0], a[1]);
		return load(); 
	}
	var 
	    b= copyscript(a[0])
	   ,c= a[1]
	   ,e= {
	   	 'insertType': 'before'
	   	,'script':b
		,'done': load
	   }
	   ,f= a[2]
	;
	if(f){ 
		b.setAttribute(S,f); 
	}
	if(b[F]){
		FL[FL.length]= [b,c];
		_CURR= null; 
		return load(); 
	}
	if(c.parentNode===H){
		e.insertType= "append";
		c= c.parentNode; 
	}
	_CURR= b;
	G(c,e);
	if(a.clearAttributes)
		a.clearAttributes(); 
	a= b= c= e= null; 
	return false; 
}
function copyscript(model){
	model.className= ""; 
	var 
		 e= IE ? model.cloneNode(false) : D.createElement(C)
		,a= model.attributes
		,t= ""
	;
	if('cssText' in e.style) 
		e.style.cssText= ""; 
	if(!IE){ 
		for(var i=0,l= a.length; i < l; i++){
			t= a[i];
			if(e.hasAttribute && e.hasAttribute(t.name)){
			e.setAttribute(t.name,t.value); 
			}
		}
	}
	e.setAttribute(Y,J);
	e.removeAttribute(L);
	e.removeAttribute(DS);
	if(model.text)
		e.text= model.text; 
	return e; 
}
function getsource(s){
	var u=    s.getAttribute(DS)
		|| s.getAttribute(S)
	; 
	return u; 
}
function sorter(c,d){ 
	var a=c[0], b= d[0]
	if(a==b){ 
		a= c[1][3];
		b= d[1][3];
		return a < b ? -1 : 1;
	}else
		return a >  b ? -1 : 1; 
}
function getstyle(a,b){ 
	var c; 
	if(DV && DV.getComputedStyle) 
		c= DV.getComputedStyle(a,"").getPropertyValue(b); 
	else if(a.currentStyle) 
		c= a.currentStyle[b]; 
	return c || ""; 
}
/* 
 * Function: ghostwriter.loadscripts
 * Iterates over all script tag searching for those with 
 * a type of "text/deferscript" and queues them one-at-a-time
 * to be executed.  Typically this is triggered via a setTimeout()
 * or a mousemove event.  
 *
 * (start code)
 * function ghostwriter.loadscripts()
 * (end code)
 *
 * Parameters: 
 * none
 *
 * Returns: 
 * null
 *
 *
 * Group: Usage Notes
 *
 * Topic: Queueing methodology  
 * Only one script is added to the <ghostwriter> queue 
 * at a time.  This is to prevent the queue from filling up 
 * so that page code can call the <ghostwriter> function 
 * and not have that script execute after the entire page.  
 */
function simload(){ 
	var a,b,c= D.getElementsByTagName(C)[0];
	for(var i=0,l=FL.length;i<l;i++){ 
		a=copyscript(FL[i][0]); 
		a.removeAttribute(F); 
		b= FL[i][1]; 
		if(b.parentNode)
			b.parentNode.replaceChild(a,b);
		else 
			c.parentNode.insertBefore(a,c);
			
	}
	setTimeout(G['flushloadhandlers'], 0); 
	return; 
}
function find(){
	var 
	   a= D.getElementsByTagName(C)
	  ,b= D.createTextNode("")
	  ,c=[]
	  ,i= 0
	; 
	while(a.length > 0){ 
		var 
		   e= ""
		  ,f= a[0]
		  ,g= b.cloneNode(false)
		  ,p= parseInt(getstyle(f,X).split(" "),10) || 0
		;
		c[c.length]= [p,[f,g,getsource(f),i]];
		f.parentNode.replaceChild(g,f); 
		i++; 
	}
	a=b=e=f=g=null;
	return c; 
}

}
/* Group: Examples 
 *
 * Topic: HTML Changes  
 * BEFORE: 
 * Browser will load /js/my.js *before rendering any content*
 * (start code) 
  * <head> 
 * <script type="text/javascript" src="/js/my.js"></script> 
 * </head> 
 * <body> 
 * <!--  
 *           {....  Rest of page  ... } 
 * --> 
 * </body> 
 * (end code)
 *
 * AFTER: 
 * Browser will *render the entire page* and then load /js/my.js  
 *
 * (start code) 
 * <head> 
 * <script type="text/deferscript" defersrc="/js/my.js"></script> 
 * </head> 
 * <body> 
 * <!--  
 *      {....  Rest of page  ... } 
 *  --> 
 * <script src="/ghostwriter/gw.min.js"></script> 
 * <script type="text/javascript> setTimeout(ghostwriter.loadscripts, 250); </script> 
 * </body> 
 * (end code)
 *
 * Topic: Configuring Prioritzed Loading
 * Execution order can be defined using the background-position-x CSS property. 
 * Scripts with the same background-position value will execute in 
 * order of DOM position. 
 *
 *
 * (start code)
 * <head> 
 * <style type="text/css"> 
 * script.adcall { background-position: 100px; } 
 * </style> 
 * <script id=mylibs type="text/deferscript" defersrc="/js/my.js"></script> 
 * <script id=adfunctions class=adcall type="text/deferscript" defersrc="/js/adfunctions.js"></script> 
 * </head> 
 * <body> 
 *
 * <script class=adcall id=adcall-1 type="text/deferscript"> 
 *     document.write(adfunctions.getscripttag("adcall-1")); 
 * </script> 
 * (end code)
 * 
 * Load Order will be  #adfunctions; #adcall-1; #mylibs 
 */

 /* wlee: merely including this library prevents window.onload from firing.
  * line below to trigger window.onload 
  */
ghostwriter.flushloadhandlers();
