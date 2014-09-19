/* 
 * 
 * @preserve Copyright(c) 2010-2011 Digital Fulrcum, LLC 
 * (http://digital-fulcrum.com). All rights reserved.
 * License: See license.txt or http://digital-fulcrum.com/ghostwriter-license/ 
 * GhostWriter: http://digital-fulcrum.com/ghostwriter-complete-control
 * Release: 12.4.4 
 */
/*
 * Title: GhostWriter
 *
 */
this['ghostwriter']= this['ghostwriter'] || (function(){
var
	 W= this
	,D= W.document
	,$Head= D.head || D.getElementsByTagName("HEAD")[0]
	,$ToString= 'toString'
	,$NativeToString= 'nativeToString'

	,$Parser
	,$Dombuilder
	,$Domelement
	,$Capabilities

	,$Queue= []
	,$Initialized= false
	,$Running= false
	,$Debug= W.location.hash.toLowerCase().indexOf("gwrdebug") >= 0 ? true : false
	,$Noop= new Function()
	,getInserter

	,$UA= (function(ua){
		var $= {ie: false, ie6: false, fx: false }
		$.ie= /msie/i.test(ua)
		$.ie6= $.ie && /msie 6/i.test(ua)
		$.fx= !$.ie && /firefox/i.test(ua)
		$.opera= !!W.opera
		return $
	 })(navigator.userAgent)

	,$Messages= (function($){
		for(var m in $)
			$[m]= ["ghostwriter.js  >> ", $[m],""].join("");
		return $;
	 })({
		 enqueue: "ENQUEUE script"
		,dequeue: "DEQUEUE script"
		,start: "BEGIN ghostload"
		,done: "FINISHED ghostload"
		,attach: "\tattach/execute script"
		,finish: "\tloaded/finished script"
		,handlerError:" !!! ERROR !!!!  Error executing handler "
		,removed: "Root element no longer in document, will skip pending scripts" 
		,demolish: "demolish() called, removing script "
	})
;
ghostwriter['queue']= $Queue
ghostwriter['handlers']= {}
ghostwriter['debug']= debug
ghostwriter['currload']= $Noop
ghostwriter['getscriptidentifier']= getscriptidentifier
getInserter= (function($){
	return function(topNode,type){
		var
			 fn= type in $ ? $[type] : $.append
			,failback= topNode.parentNode
		;
		return function(childNode){
			fn(topNode, childNode, failback)
		}
	}
})({
	"append": function(tgt,el){
		tgt.appendChild(el)
	 }
	,"before": function(tgt,el,p){
		var p= tgt.parentNode || p
		if(!p){
			return
		}else if (
			p != tgt.parentNode ||
			(   $UA.ie6
			 && tgt.nodeType == 3
			 && el.tagName.toLowerCase() == 'script'
			)
		)
			p.appendChild(el)
		else
			p.insertBefore(el,tgt)
	}
	,"after": function(tgt,el){
		var p= tgt.parentNode,sib= tgt.nextSibling
		p.insertBefore(el,sib)
	 }
})
;
return ghostwriter

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
 *     scriptMap[scriptMap.length - 1],
 *     {
 *         insertType: "before",
 *         script: { src: "/js/mylib.js" },
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
	options= options || {};

	if(!$Initialized)
		Initialize()

	if($Running)
		return Enqueue(element,options)
	$Running= true

	element= getElement(element)

	var a = [ element, options ]
	a['demolish'] = ghostload(element,options)
	return a

}

function Initialize(){
	$Initialized= true

	$Parser= ghostwriter['htmlstreamparser']
	$Dombuilder= ghostwriter['domtree']
	$Domelement= ghostwriter['domelement']
	$Capabilities= ghostwriter['capabilities']

	ghostwriter['fh']['set']()
}

function Enqueue(element,options){
	if($Debug)
		logScriptActivity($Messages.enqueue, options['script'])

	var handle= Array.prototype.slice.call(arguments)
	$Queue[$Queue.length]= handle
	handle['demolish']= demolish;
	return handle
}

function Dequeue(){
	$Running= false;
	if($Queue.length < 1)
		return

	var args= $Queue.shift()
	if($Debug)
		logScriptActivity($Messages.dequeue, args[1]['script'])

	ghostwriter.apply(ghostwriter,args)
	return $Queue.length
}


function getElement(element){
	if(typeof element=='string')
		element= D.getElementById(element)

	if(!element)
		throw new Error(
			"Unable to find element " + element +
			"\nUsage: ghostwriter(element|elementid, options)"
		);

	return element
}

function logScriptActivity(message,script){
	var id= getscriptidentifier(script)
	flog( [message, id, ""].join(' "') )
}
/*
 * Method: debug({Boolean} enable])
 *  Gets or sets the current debugging state.  Enabling debugging
 *   will cause ghostwriter to print information about every script
 *   it loads to the console.
 *
 * Returns:
 *   [Boolean] The current debugging state
 *
 * Parameters: {Boolean} enable
 *   Pass true to enable debugging, false to disable it or null to
 *   retrieve the current debugging state
 */
function debug(y){
	return y == null ? $Debug : ($Debug=y)
}
/**
 * constructor
 */
function ghostload(element, options){
	var
		 insertfn= getInserter(element, options['insertType'])
		,parser= new $Parser({
			"chars": parserCharHandler,
			"start": parserTagStartHandler,
			"end": parserTagEndHandler
		 })

		,oldwrite= D.write
		,oldwriteln= D.writeln

		,e= null
		,curr= makescript(options['script'])

		,onDone= typeof options['done'] == 'function' ?
			options['done'] : $Noop

		,callHook= createHookCallback(
			 ghostwriter['handlers'] || {}
			,options['handlers'] || {}
		 )

		,tree= new $Dombuilder(
			insertfn,
			function(){
				var args= Array.prototype.slice.call(arguments)
				args.unshift('onelement')
				callHook.apply(W,args)
			}
		)

		,outstanding= 0
		,loadqueue= []

		,inserted= false

		,localAsyncTrigger= null
		,demolished= false
	;
	if($Debug)
		logScriptActivity($Messages.start, options['script'])

	D.write= write;
	write[$ToString]= ghostwriter[$NativeToString]("write")

	D.writeln= writeln;
	writeln[$ToString]= ghostwriter[$NativeToString]("writeln")

	callHook('begin', options['script'])

	if('tagName' in curr)
		initializeDomTree(tree,curr)

	if(inDocument(element)) 
		addscript(curr)
	else if($Debug) 
		flog([$Messages.removed,element,""].join(" '"))

	inserted= true;

	if(outstanding < 1)
		finish();

	return demolish

	function writeln(text){
		parser.parse(text + "\n");
	}

	function write(text){
		parser.parse(text);
	}

	function onload(complete){
		var synchronous= $Capabilities['synchronous']
		outstanding--;

		if($Debug && !complete)
			logScriptActivity($Messages.finish, this)

		if(!synchronous)
			removeAsyncTrigger()
		

		if(!complete) 
			callHook("finishscript",this)

		if(demolished) 
			return
		else if(loadqueue.length > 0)
			loadNext()
		else if (!(synchronous || complete))
			setTrigger()
		else if(outstanding < 1 && inserted)
			finish();

		return true
	}

	function parserTagEndHandler(tn){
		if(tn.toLowerCase() == 'script')
			addscript(tree.current.element);
		else
			tree.close(tn);
	}

	function parserCharHandler(text){
		tree.addText(text);
	}

	function parserTagStartHandler(tn,alist,unary){
		tn= tn.toLowerCase();
		var attrs= attrsToObject(alist);

		if( !callHook ('check',tn,attrs) )
			return false;

		tree.add(tn,attrs);
		if(unary) tree.close(tn);
	}

	function loadNext(){
		if(outstanding)
			return

		var nextScript= curr= loadqueue.shift()
		AddLoadHandler(nextScript,onload)

		if(!inDocument(element)){ 
			if($Debug)
				flog([$Messages.removed,element,""].join(" '"))
			return onload.call(nextScript) 
		}

		callHook('startscript',nextScript)

		outstanding++
		tree.reset()

		if($Debug)
			logScriptActivity($Messages.attach,nextScript)

		callHook('onelement', nextScript)
		if(tree.current && tree.current.element!= nextScript) 
			tree.current.appendChild(nextScript)
		else
			insertfn(nextScript)
	}

	function setTrigger(){
		ghostwriter['currload']= onload

		localAsyncTrigger= D.createElement("SCRIPT")
		localAsyncTrigger.text= "ghostwriter.currload(true)"
		localAsyncTrigger.type="text/javascript"

		flog('setting local trigger')

		outstanding++
		$Head.appendChild(localAsyncTrigger)
	}

	function removeAsyncTrigger(){
		   localAsyncTrigger
		&& localAsyncTrigger.parentNode
		&& localAsyncTrigger.parentNode === $Head
		&& $Head.removeChild(localAsyncTrigger);
	}

	function addscript(s){
		if(!s) {
			return
		}else if(s.defer){
			tree.close()
			return s
		}
		if (outstanding && s.src){
			loadqueue[loadqueue.length]= s
			tree.close('script', false)
			return s
		}else if(typeof s == 'function'){
			s();
			if($Debug)
				flog([$Messages.attach,s+"",""].join(" '"));
			onload.call(s,true);
			return s
		}

		outstanding++;
		D.write= write
		D.writeln= writeln
		return runScript(s)
	}
	function runScript(scriptElement){ 
		var mustEval= false

		if(!inDocument(element)){ 
			if($Debug)
				flog([$Messages.removed,element,""].join(" '"))
			return onload.call(scriptElement) 
		}


		if($Debug)
			logScriptActivity($Messages.attach,scriptElement)
		callHook('startscript',scriptElement)

		if(isEmptyScript(scriptElement)) { 
			tree.close() 
			outstanding--
			return scriptElement
		}
		if(!scriptElement.src) 
			mustEval= mutateLocalScript(scriptElement)

		mustEval || AddLoadHandler(scriptElement,onload)
		tree.close();

		mustEval &&
			evalScript(scriptElement.text,scriptElement.language) &&
				onload.call(scriptElement)

		return scriptElement
	}
	function mutateLocalScript(scriptElement){
		var
			   C= $Capabilities
			  ,mustEval= !(C['synchronous'] && C['localonload']) 
		;
		if(mustEval){
			scriptElement.setAttribute("type","text/any")
			scriptElement.removeAttribute("language")
		}else if (C['usedatauri']){
			scriptElement.setAttribute(
				"src",
				"data:text/javascript,"+encodeURIComponent(scriptElement.text)
			)
			scriptElement.async= true
		}
		return mustEval
	}

	function evalScript(scriptCode,type){
		var geval= W.execScript || eval
		try { 
			if(W.execScript && type)
				geval(scriptCode,type)
			else
				geval(scriptCode) 
		}
		finally{ return true }
	}

	function finish(){

		D.write= oldwrite;
		D.writeln= oldwriteln;

		if($Debug)
			logScriptActivity($Messages.done, options['script'])

		callHook('end', options['script'])

		demolished || setTimeout(onDone,0)
		demolished= true;

		Dequeue()

		return true;
	}
	function demolish(){
		if($Debug)
			logScriptActivity($Messages.demolish, curr) 

		curr && onload.call(curr,true)
		if(curr.parentNode)
			curr.parentNode.removeChild(curr)
	}

}
function demolish(){ 
	for(var i=0, l= $Queue.length; i < l; i++) 
		if($Queue[i] === this){ 
			$Queue.splice(i,1)
			break;
		}
}
function isEmptyScript(scriptElement){
	return !(scriptElement.src || scriptElement.text || scriptElement.textContent)
}
function initializeDomTree(domTree,scriptElement){
	var
		e= new $Domelement("script",{})
	;
	e.isready= false;
	e.element= scriptElement;
	e.parentNode= domTree.current;

	domTree.current= e;
}

function createHookCallback(global,local){
	var
		hooks= {
			 'begin': []
			,'end': []
			,'onelement': []
			,'check': []
			,'startscript': []
			,'finishscript': []
		}
	;

	Iterator(hooks, function(key,value){
		typeof global[key] == 'function' && value.push(global[key])
		typeof local[key] == 'function' && value.push(local[key])
	})

	return function(type){
		var
			  handledBy= hooks[type]
			 ,args= Array.prototype.slice.call(arguments)
		;
		args.shift()
		for(var i=0,l= handledBy.length,hookReturn; i < l; i++){
			try {
				hookReturn= handledBy[i].apply(W,args)
			}
			catch(e){
				flog( [
					$Messages.handlererror,
					'handler type: "' + type + "'",
					'callback funtion: "' + handledBy[i]+'"',
					'exception: "' + e + '"'
				      ].join("\n")
				)
			}
			if(hookReturn != null && !hookReturn)
				return hookReturn
		}
		return true
	}
}
function inDocument(target){
	while(target){ 
		if(target === D) 
			return true
		target= target.parentNode
	}
	return false
}

function Iterator(collection, callback){
	for (var key in collection)
		if(collection.hasOwnProperty(key))
			callback.call(collection,key,collection[key])
	return collection
}
function tweakurl(url){
	if(url.indexOf("file:")===0){
		return url.replace("file", "http");
	}else if(url.indexOf("//")===0){
		return "http:" + url;
	}
	return url;
}
function makescript(sa){
	if(
		typeof sa == 'function' ||
			typeof sa == 'object' &&
			'nodeType' in sa &&
			'tagName' in sa &&
			sa.tagName == 'SCRIPT'
	) 
		return sa;
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
function AddLoadHandler(script, cb){
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
		cb.call(script);
	}
}
/*
 * Section: Utility Functions
 *
 * Function: ghostwriter.getscriptidentifier({Object} script)
 *
 * Given a script object, gets a printable identifier
 * using either its id, src, or text attributes
 *
 * Params: script - script object
 *
 * Returns: {String}
 *
 *
 * */
function getscriptidentifier(script){
	var
		 scriptText= typeof script == 'function' ?
		 	script + "" :
			(script.src ? script.src : script.text)
		,scriptId= script.id || ""
		,charCount= 40
		,scriptTextLength= scriptText.length
		,separator="{...}"
	;
	scriptId = scriptId ? "(#" + scriptId +") ":"";
	scriptText= scriptText.replace(/\n/g," ");
	if(scriptTextLength <= charCount + separator.length )
		return scriptText;

	return [
		scriptId,
		scriptText.substr(0,charCount),
		separator,
		scriptText.substr(scriptTextLength - charCount, scriptTextLength - 1)
	].join("");

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
window['flog']= (function(){
var startTime= new Date();
return flog;
function flog(msg){
	var diff= ((new Date() - startTime) / 100).toFixed(1);
	msg= [ "#gwr[+" , diff, "] ",  msg ].join ("");

	if (typeof Y == 'object' && typeof Y.log == 'function')
		Y.log(msg);
	if(typeof console== 'object' && 'log' in console)
		console.log(msg);
}
})();
ghostwriter['nativeToString']= (function(){
	var
		 $= "function 00() {\n    [native code]\n}".split(0)
		,slice= "slice"
	;
	return function stringMaker(methodName){
		var _= $[slice]()
		_[1]= methodName
		return function(){ return _.join("") }
	}
})();
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
 * ghostwriter.flushloadhandlers()
 * (end code)
 *
 *
 * Parameters: 
 * none
 *
 * Returns: 
 * null
 *
 * Function: ghostwriter.flushloadhandlers.set
 * Set the DOM overrides necessary to proxy event listener registration. 
 * By default, this will be called the first time ghostwriter() loads a script 
 * so normally this does not need to executed manually; however, it can be useful in 
 * cases where you want to begin overriding the event subscribers before you have 
 * started loading any deferred scripts. 
 *
 * (start code) 
 * var setOverrides= ghostwriter.flushloadhandlers.set()
 * if(!setOverrides) 
 * 	alert("Overrides were previously set")
 * (end code) 
 *
 * Parameters: 
 * none
 *
 * Returns: 
 * Boolean value indicating whether or not the load handlers were actually 
 * overridden (as opposed to having previously been) 
 *
 */ 
window['ghostwriter']['flushloadhandlers']= window['ghostwriter']['fh']= (function($W){ 
var 
	 Debug= $W['ghostwriter']['debug']
	,$D= document

	,$Split= "split"

	,$OverridableElementList= [ $W, $D ]
	,$EventList
	,$DispatchEventPrefix= "gwrsim"

	,$GlobalOnload= $W.onload

	,$HaveFlushed= false
	,$Overridden= false

	,$resetDoScrollOverride= new Function() 

	,$Messages= (function($){  
		for(var m in $)
			$[m]= ["loadhandlers.js >> ", $[m],""].join("")
		return $
	 })({ 
		 domeventreceived: "Received DOM load event of type "
		,registerdomevent: "Registering for event of type "
		,addedlistener: "Adding new event listener " 
		,callbackerror: "!!ERROR!! Exception thrown running callback function "
	 })
; 
$EventList= registerOnloadListeners(
	  "DOMContentLoaded0load0readystatechange".split(0)
	 ,$OverridableElementList
)

simulateOnload['set']= setOverrides 
simulateOnload['eventlist']= $EventList
$W.onload= null

return simulateOnload 

function simulateOnload(){ 
	$resetDoScrollOverride()
	fireOverrideEvents()
	$HaveFlushed= true
}

function setOverrides(){ 
	$resetDoScrollOverride= setDoScrollOverride()
	setDocumentOverrides()
	installEventHandlerProxies($EventList)
	setGlobalOnload()
	if($Overridden) 
		return false
	else{
		$Overridden= true
		return $Overridden
	}
}

function setGlobalOnload(){ 
	var 
		 globalLoad= $W.onload || $GlobalOnload	
		,loadEvent= $D.addEventListener ? "load":"onload"
	;
	$W.onload= $GlobalOnload= null; 

	if(!globalLoad) 
		return 
	if($W.addEventListener) 
		$W.addEventListener(loadEvent,globalLoad,false)
	else if($W.attachEvent) 
		$W.attachEvent(loadEvent,globalLoad)
} 

function setDoScrollOverride(){ 
	if($Overridden) 
		return $resetDoScrollOverride
	var 
		 overrideObject 
		,nativeDoScroll
		,docElement= $D.documentElement
	; 
	if(
		typeof Element == 'object' && 
		typeof Element.prototype == 'object' && 
		Element.prototype.doScroll 
	)
		overrideObject= Element.prototype; 
	else if(docElement && docElement.doScroll)
		overrideObject= $D.documentElement;
	
	if(!overrideObject) 
		return new Function("return new Function()")

	nativeDoScroll= overrideObject.doScroll
	overrideObject.doScroll=new Function("throw new Error;")

	return resetDoScroll
	
	function resetDoScroll(){
		if(overrideObject == $D.documentElement)
			$D.documentElement.doScroll= nativeDoScroll
		else 
			overrideObject.doScroll= function(){ 
				nativeDoScroll.call(this)
			}
	}
}

function setDocumentOverrides(){
	var 
		 fnList= "write0writeln0close0open"[$Split](0)
		,body= "flog('Illegal call to document.00(): \"'+ a + '\"')"[$Split](0)
		,toStringMaker= $W['ghostwriter']['nativeToString']
		,toString= 'toString'
		,i= 0 
		,name
	;
	while( (name = fnList[i++]) ){ 
		body[1]= name
		fn= new Function("a", body.join("")) 
		$D[name]= fn 
		fn[toString]= toStringMaker(name) 
	}
}

function registerOnloadListeners(eventNameList, domObjectList){ 
	var $= {}
	Each(eventNameList, function(eventName){ 
		Each(domObjectList, function(domObject){ 
			addListener(eventName, domObject) 
		})
	})
	return $
	function addListener(eventName, domObject){ 
		if(Debug()) 
			logActivity($Messages.registerdomevent, eventName, domObject)

		if(domObject.addEventListener){ 
			$[eventName]= $[eventName] || {}
			$[eventName][domObject]= { event:  null, target: domObject }

			domObject.addEventListener(
				eventName, 
				handleReady, 
				false
			)
		}
		if(domObject.attachEvent){ 
			eventName= 'on' + eventName
			$[eventName]= $[eventName] || {}
			$[eventName][domObject]= { event: null,target: domObject }

			domObject.attachEvent(
				eventName,
				handleReady
			) 
		}
	}
	function handleReady(event){
		var 
			 domObject= event.currentTarget || this
			,msEvent= !event.target 
			,eventName= msEvent ? 'on' + event.type : event.type
			,eventCache=  $[eventName][domObject]
		;

		if(!eventCache) 
			return

		if(Debug()) 
			logActivity($Messages.domeventreceived, eventName, domObject)

		eventCache.event= msEvent ? copyEventObject(event) : event

		if(domObject.removeEventListener)
			domObject.removeEventListener(eventName,handleReady,false)

		if(domObject.detachEvent && !eventName.indexOf("on") == 0)
			domObject.detachEvent(eventName, handleReady)

		if($HaveFlushed)
			dispatchEventCache(eventCache,eventName)
	}
	function copyEventObject(event){
		if(document.createEventObject) 
			return document.createEventObject(event)
		var $= {}
		for( var key in event )
			$[key]= event[key]
		return $
	}
}

function fireOverrideEvents(){
	var eventList= $EventList
	Iterator(eventList, function(eventType){
		var domObjectEventList= eventList[eventType]
		Iterator(domObjectEventList, function(domObject){
			var eventCache= domObjectEventList[domObject]
			if(eventCache.event)
				dispatchEventCache(eventCache, eventType)
		})
	})
}

function dispatchEventCache(eventCache,actualType){ 
	var 
		 quirky= actualType.indexOf("on") == 0 
		,domTarget= eventCache.target
	;
	if(domTarget.dispatchEvent && !quirky) 
		standardDispatcher.apply(this,arguments)
	else 
		msiequirkDispatcher.apply(this,arguments)
}

function standardDispatcher(eventCache){ 
	var 
		 originalEvent= eventCache.event
		,domTarget= eventCache.target
		,customOnloadEvent= $D.createEvent("UIEvents")
		,fakeEvent= $DispatchEventPrefix + originalEvent.type
	;
	customOnloadEvent.originalEvent= originalEvent
	customOnloadEvent.initEvent(fakeEvent, false, false)
	domTarget.dispatchEvent(customOnloadEvent)
}

function msiequirkDispatcher(eventCache){ 
	var 
		 originalEvent= eventCache.event
		,domTarget= eventCache.target
		,listeners= eventCache.listeners
	;
	if(!listeners)
		return
	while((listener= listeners.shift())){
		try { 
			listener.call(domTarget,originalEvent) 
		}
		catch(e){
			logActivity($Messages.callbackerror, listener+"", e.message)
		}
	}
}
function installEventHandlerProxies(overrideEventList){ 
	if($Overridden) 
		return false

	Each($OverridableElementList, function(domObject){
		// Support both attachEvent and addEventListener in IE9
		if(domObject.addEventListener)
			domObject.addEventListener= 
				eventListenerProxyFactory.call(
					 domObject
					,domObject.addEventListener
				)

		if(domObject.attachEvent)
			domObject.attachEvent= 
				attachEventProxyFactory.call(
					 domObject
					,domObject.attachEvent
				)
	});

	function eventListenerProxyFactory(method){ 
		var eventList= $EventList
		return function eventListenerProxy(eventType){ 
			var args
			if(eventType in eventList){ 
				args=[ 
					 $DispatchEventPrefix + eventType
					,createEventListener(arguments[1],eventType) 
					,false
				]
				if(Debug()) 
					logActivity($Messages.addedlistener, eventType, this) 
			}else 
				args= Array.prototype.slice.call(arguments)

			return Function.prototype.apply.call( 
				method,
				this,
				args
			)
		}
	}	

	function attachEventProxyFactory(method){
		var eventList= $EventList 
		return function attachEvent(eventType,callback){
			if(!(eventType in eventList))
				return Function.prototype.apply.call(
					method,
					this,
 					Array.prototype.slice.call(arguments) 	
				)
			var 
				 eventCache= eventList[eventType][this]
				,listeners= eventCache.listeners= eventCache.listeners||[]
			;
			listeners[listeners.length]= callback
			return true
			
		}
	}
	function createEventListener(callback){
		return function eventListener(event){
			var
				 dom= event.target
				,originalEvent= event.originalEvent
			;
			if(dom.removeEventListener) 	
				dom.removeEventListener(event.type, arguments.callee, false)

			callback.call(dom,originalEvent)
		}
	}
}



function Each(array, callback){ 
	for( var i=0, l= array.length; i < l; i++)
		callback.call(array, array[i])
	return array
}

function Iterator(collection, callback){
	for( var key in collection ){ 
		if(collection.hasOwnProperty(key)) 
			callback.call(collection, key, collection[key])
	}
	return collection
}

function logActivity(message, type, target){ 
	flog( 
		[ 
			message, ' "', type, '" / "', target.toString(), '"'
		].join("") 
	)
}


})(this); 

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
function domtree(insertFn,onadd){
	ELEMENT= ELEMENT || ghostwriter['domelement']; 
	var _self= this; 

	this.inserter= typeof insertFn=='function' ? insertFn : appendToBody;
	this.addhandler= onadd || new Function(); 
	this.current=  { 
		'tagName': null
		,'appendChild': function(element){ 
			_self.inserter(element); 
			return this; 
		}
		,'close': function(){ return this; } 
		,'parentNode': null 
		,'ready': function(){ return true; }
	}; 
	this.current.parentNode= this.current; 
	this.previous= null; 
	this.ignoring= 0; 
}
domtree.prototype= {
	addText: function(text){ 
		var tag= ELEMENT("", text); 
		if(!this.ignoring && text !== "\n" && text !== "\r\n") 
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
			try { this.addhandler(tag.element) } 
			catch(e){ flog("ERROR executing element add handler: " + e.message) }
			p.appendChild(tag.element)
		}
		return this
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
		if(attach==null) 
			attach= true; 

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
		if(!el)
			throw new Error("attempting to close tag that is not ready"); 
		 
		if(attach && !wasready){

			try { this.addhandler(el) } 
			catch(e){ flog("ERROR executing element add handler: " + e.message) }

			if(this.current)
				this.current.appendChild(el)
			else
				this.inserter(el)
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
		// This is a guard against IE9's premature 
		// execution of script elements.  
		// http://ghostwriter.unfuddle.com/a#/projects/1/tickets/by_number/9 
		if(el.tagName.toLowerCase() == 'script' && el.src)
			return 		
		
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
		var 
			 get= IE && (!D.documentMode || D.documentMode < 9) ? 
				msieMaker : domMaker 
			,encoder= null
		; 
		return function(a,b){ 
			a= a.toLowerCase();
			b= typeof b =='object'?b:{}; 
			return get.call(this,a,b);
		}

		function msieMaker (a,b){ 
			var c,d=["<" + a]
			$Iterator(b, function(key,value){ 
				if(key.toLowerCase().indexOf("on") == 0) 
					value= value.replace(/\"/g, "&quot;")
				d[d.length]= key + '="' + value + '"'
			})
			d[d.length]= ">"
			var f= D.createElement(d.join(" "))
			return f
		}
		function domMaker(a,b){ 
			encoder= encoder || window['ghostwriter']['htmlstreamparser']['Encoder']
			var 
				c= D.createElement(a)
			;
			$Iterator(b, function(key,value){
				value= typeof value == 'string' ? 
					 encoder['htmlDecode'](value) : 
					 value
				;
				c.setAttribute(key,value)
			});
			return c; 
		}
		function $Iterator(object,fn){
			for(var key in object){ 
				if(object.hasOwnProperty(key)) 
					fn.call(object,key,object[key])
			}
			return object
		}
	
	})()
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
	this.tagName= tn.toUpperCase(); 
	this.element= this.create(tn,attrs);
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
endTag= /^<\/(\w+) *[>\n]/,

comments= { 
	startre: /^\s*(?:<!--).*/
	,startix: "<!--"
	,endre: /--[^>]*>/
	,endix: "-->"
}, 
cdataregex= /<!\[CDATA\[(.*?)]]>/g,
attr= /([\w:-]+)(?:\s*=\s*(?:(?:"((?:\\.|[^"])*)")|(?:'((?:\\.|[^'])*)')|([^>\s]+)))?/g,
empty= makeMap("xml,area,base,basefont,br,col,frame,hr,img,input,isindex,link,meta,param,embed"),
block= makeMap("address,applet,blockquote,button,center,dd,del,dir,div,dl,dt,fieldset,form,frameset,hr,iframe,ins,isindex,li,map,menu,noframes,noscript,object,ol,p,pre,script,table,tbody,td,tfoot,th,thead,tr,ul"), 
inline= makeMap("abbr,acronym,applet,b,basefont,bdo,big,br,button,cite,code,del,dfn,em,font,i,iframe,img,input,kbd,label,map,q,s,samp,script,select,small,strike,strong,sub,sup,textarea,tt,u,var"),
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
	this['get']= function(){ return "" }
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
	this['get']= this['html']= getHtml
	this.parsecalls++; 
	stack.last= function(){
		return this[ this.length - 1 ];
	};

	while (html){
		lastTag= this.stack[this.stack.length - 1] 
		chars= true;
		iterations++; 
		if(!lastTag || !special[lastTag]){
			if(html.indexOf(comments.startix)===0){
				if((index= comments.endre.exec(html.substr(comments.startix.length)))){ 
					html= html.substr( comments.startix.length ) 
					if(index[0].length > 3) 
						index= index.index + index[0].length - 3; 
					else
						index= index.index

					handler['comment'](
						html.substr(index)
					);
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
			html.match(new RegExp("<\/" + lastTag + " *[>\n]", "i"))
		){
			var 
			  len= html.length, 
			  re= tagRegexMap[lastTag]= tagRegexMap[lastTag] ||  
				new RegExp("((?:.|\n|\r)*?)<\/" + lastTag + " *[>\n]", "i")
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
			.replace(comments.startre, "")
			.replace(cdataregex, "$1")
		;
		if(text.length > 0) 
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
				fillAttrs[name] ? name : ""
			;
			attrs.push({
				'name': name,
				'value': value
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
	function getHtml(){ 
		return html; 
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

var Encoder= HTMLParser['Encoder']= (function(){ 

	var entityToCode = { 
		'apos':0x0027,'quot':0x0022,'amp':0x0026,'lt':0x003C,
		'gt':0x003E,'nbsp':0x00A0,'iexcl':0x00A1,'cent':0x00A2,'pound':0x00A3,
		'curren':0x00A4,'yen':0x00A5,'brvbar':0x00A6,'sect':0x00A7,
		'uml':0x00A8,'copy':0x00A9,'ordf':0x00AA,'laquo':0x00AB,
		'not':0x00AC,'shy':0x00AD,'reg':0x00AE,'macr':0x00AF,
		'deg':0x00B0,'plusmn':0x00B1,'sup2':0x00B2,'sup3':0x00B3,
		'acute':0x00B4,'micro':0x00B5,'para':0x00B6,'middot':0x00B7,
		'cedil':0x00B8,'sup1':0x00B9,'ordm':0x00BA,'raquo':0x00BB,
		'frac14':0x00BC,'frac12':0x00BD,'frac34':0x00BE,'iquest':0x00BF,
		'Agrave':0x00C0,'Aacute':0x00C1,'Acirc':0x00C2,'Atilde':0x00C3,
		'Auml':0x00C4,'Aring':0x00C5,'AElig':0x00C6,'Ccedil':0x00C7,
		'Egrave':0x00C8,'Eacute':0x00C9,'Ecirc':0x00CA,'Euml':0x00CB,
		'Igrave':0x00CC,'Iacute':0x00CD,'Icirc':0x00CE,'Iuml':0x00CF,
		'ETH':0x00D0,'Ntilde':0x00D1,'Ograve':0x00D2,'Oacute':0x00D3,
		'Ocirc':0x00D4,'Otilde':0x00D5,'Ouml':0x00D6,'times':0x00D7,
		'Oslash':0x00D8,'Ugrave':0x00D9,'Uacute':0x00DA,'Ucirc':0x00DB,
		'Uuml':0x00DC,'Yacute':0x00DD,'THORN':0x00DE,'szlig':0x00DF,
		'agrave':0x00E0,'aacute':0x00E1,'acirc':0x00E2,'atilde':0x00E3,
		'auml':0x00E4,'aring':0x00E5,'aelig':0x00E6,'ccedil':0x00E7,
		'egrave':0x00E8,'eacute':0x00E9,'ecirc':0x00EA,'euml':0x00EB,
		'igrave':0x00EC,'iacute':0x00ED,'icirc':0x00EE,'iuml':0x00EF,
		'eth':0x00F0,'ntilde':0x00F1,'ograve':0x00F2,'oacute':0x00F3,
		'ocirc':0x00F4,'otilde':0x00F5,'ouml':0x00F6,'divide':0x00F7,
		'oslash':0x00F8,'ugrave':0x00F9,'uacute':0x00FA,'ucirc':0x00FB,
		'uuml':0x00FC,'yacute':0x00FD,'thorn':0x00FE,'yuml':0x00FF,
		'OElig':0x0152,'oelig':0x0153,'Scaron':0x0160,'scaron':0x0161,
		'Yuml':0x0178,'fnof':0x0192,'circ':0x02C6,'tilde':0x02DC,
		'Alpha':0x0391,'Beta':0x0392,'Gamma':0x0393,'Delta':0x0394,
		'Epsilon':0x0395,'Zeta':0x0396,'Eta':0x0397,'Theta':0x0398,
		'Iota':0x0399,'Kappa':0x039A,'Lambda':0x039B,'Mu':0x039C,
		'Nu':0x039D,'Xi':0x039E,'Omicron':0x039F,'Pi':0x03A0,
		'Rho':0x03A1,'Sigma':0x03A3,'Tau':0x03A4,'Upsilon':0x03A5,
		'Phi':0x03A6,'Chi':0x03A7,'Psi':0x03A8,'Omega':0x03A9,
		'alpha':0x03B1,'beta':0x03B2,'gamma':0x03B3,'delta':0x03B4,
		'epsilon':0x03B5,'zeta':0x03B6,'eta':0x03B7,'theta':0x03B8,
		'iota':0x03B9,'kappa':0x03BA,'lambda':0x03BB,'mu':0x03BC,
		'nu':0x03BD,'xi':0x03BE,'omicron':0x03BF,'pi':0x03C0,
		'rho':0x03C1,'sigmaf':0x03C2,'sigma':0x03C3,'tau':0x03C4,
		'upsilon':0x03C5,'phi':0x03C6,'chi':0x03C7,'psi':0x03C8,
		'omega':0x03C9,'thetasym':0x03D1,'upsih':0x03D2,'piv':0x03D6,
		'ensp':0x2002,'emsp':0x2003,'thinsp':0x2009,'zwnj':0x200C,
		'zwj':0x200D,'lrm':0x200E,'rlm':0x200F,'ndash':0x2013,
		'mdash':0x2014,'lsquo':0x2018,'rsquo':0x2019,'sbquo':0x201A,
		'ldquo':0x201C,'rdquo':0x201D,'bdquo':0x201E,'dagger':0x2020,
		'Dagger':0x2021,'bull':0x2022,'hellip':0x2026,'permil':0x2030,
		'prime':0x2032,'Prime':0x2033,'lsaquo':0x2039,'rsaquo':0x203A,
		'oline':0x203E,'frasl':0x2044,'euro':0x20AC,'image':0x2111,
		'weierp':0x2118,'real':0x211C,'trade':0x2122,'alefsym':0x2135,
		'larr':0x2190,'uarr':0x2191,'rarr':0x2192,'darr':0x2193,
		'harr':0x2194,'crarr':0x21B5,'lArr':0x21D0,'uArr':0x21D1,
		'rArr':0x21D2,'dArr':0x21D3,'hArr':0x21D4,'forall':0x2200,
		'part':0x2202,'exist':0x2203,'empty':0x2205,'nabla':0x2207,
		'isin':0x2208,'notin':0x2209,'ni':0x220B,'prod':0x220F,
		'sum':0x2211,'minus':0x2212,'lowast':0x2217,'radic':0x221A,
		'prop':0x221D,'infin':0x221E,'ang':0x2220,'and':0x2227,
		'or':0x2228,'cap':0x2229,'cup':0x222A,'int':0x222B,
		'there4':0x2234,'sim':0x223C,'cong':0x2245,'asymp':0x2248,
		'ne':0x2260,'equiv':0x2261,'le':0x2264,'ge':0x2265,
		'sub':0x2282,'sup':0x2283,'nsub':0x2284,'sube':0x2286,
		'supe':0x2287,'oplus':0x2295,'otimes':0x2297,'perp':0x22A5,
		'sdot':0x22C5,'lceil':0x2308,'rceil':0x2309,'lfloor':0x230A,
		'rfloor':0x230B,'lang':0x2329,'rang':0x232A,'loz':0x25CA,
		'spades':0x2660,'clubs':0x2663,'hearts':0x2665,'diams':0x2666
	}
	,charToEntity= (function(e2c){  
		var $= {}
		for (var entityName in e2c)
       		 	$[String.fromCharCode(e2c[entityName])]= entityName
		return $
	})(entityToCode)
	,entityRegex= /&(.+?);/g
;
return { 'htmlDecode': decodeEntities } 

function decodeEntities(str){
	return str.replace(entityRegex, entityReplace)
}
function entityReplace(str, ent){
	var code= ""
	if(ent[0]=='#'){
		if(ent[1] == 'x') 
			code= parseInt(ent.substr(2),16)
		else 
			code= parseInt(ent.substr(1))
	}else if(ent in entityToCode)
		code= entityToCode[ent]	

	return code ? String.fromCharCode(code) : str 
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
	,DEBUG= G['debug']
	,GETID= G['getscriptidentifier']
	,DV= D.defaultView
	,IE= navigator.userAgent.indexOf("MSIE")  >= 0
	,X= DV && DV.getComputedStyle ? "background-position" : "backgroundPositionX" 
	,Y= "type"
	,T= "text/html"
	,J= "text/javascript"
	,JS= "javascript"
	,L= "language"
	,C= "script"
	,F= "defer"
	,DEFER= F
	,S= "src"
	,DS= F+S
	,DC= F+C
	,FL= []
	,RE= new RegExp("(?:^url\\([\"']?|[\"']?\\)$)", "gi")
	,SCRIPTCHARCOUNT= 20
	,_CURR= null
	,MAP= (function(a){ 
		var _= []; 
		for(var b=0,c=a.length;b<c;b++)
			_[_.length]= a[b][2];
		return _; 
	})( find().sort(sorter) )
	,MESSAGES= (function($){ 
		for(var m in $)
			$[m]= ["scriptloader.js >> ", $[m], " text/deferscript "].join(""); 
		return $; 
	})({ 
		 start:"Starting "
		,end:"Complete"
		,begin: "BEGIN loading"
		,finish:"LOADED all" 
	}); 
;
if(DEBUG())
	flog(MESSAGES.begin); 
if(IE) 
	addtoken()
load(); 
function load(){
	if(!MAP.length){
		if(DEBUG())
			flog(MESSAGES.finish); 
		return simload(); 
	}

	var 
	    a= MAP.shift() || []
	   ,scripttoload= a[0]
	   ,marker= a[1]
	   ,isghost= a[2]
	   ,gwoptions
	; 
	if(!isghost){ 
		marker.parentNode.replaceChild(scripttoload, marker); 
		return load(); 
	}
	if(scripttoload[DEFER]){
		FL[FL.length]= [b,c];
		_CURR= null; 
		return load(); 
	}
	gwoptions= {
	   	 'insertType':'before'
	   	,'script':scripttoload
		,'done':load
	}
	if(marker.parentNode===H){
		gwoptions['insertType']= "append";
		marker= H; 
	}
	_CURR= scripttoload;
		if(DEBUG())(function(scriptId){ 
			flog([ 
				MESSAGES.start,
				"'", scriptId, "'"
			].join(""));
			gwoptions.done= function(){ 
				flog(MESSAGES.end); 
				load(); 
			}
		})(GETID(scripttoload)); 
	G(marker, gwoptions);
	return false; 
}

function addtoken(){ 
	var 
		 script= D.createElement(C) 
		,head= H
	script.text= "void null"
	H.insertBefore(script,H.firstChild)
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
				e.setAttribute(t.name,t.value); 
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
	return s.getAttribute(DS)|| s.getAttribute(S);
}
function sorter(c,d){ 
	var a=c[0], b= d[0]
	if(a==b){ 
		a= c[1];
		b= d[1];
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
		a= copyscript(FL[i][0]); 
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
	   a= toArray(D.getElementsByTagName(C))
	  ,c=[]
	  ,index= 0
	  ,type= ""
	  ,foundFirst= false 
	; 
	for(var i =0 , l = a.length ; i < l; i++) {
		var 
		   e= ""
		  ,deferscript = a[i]
		  ,type= (deferscript.getAttribute(Y) || "")
			.toLowerCase()
		  ,lang= (deferscript.getAttribute(L) || "")
			.toLowerCase()
		  ,marker= D.createTextNode("")
		  ,isdefer= type.indexOf(DEFER)>=0
		  ,isjs= type.indexOf(JS) > 0 || !type
		  ,src= getsource(deferscript)
		  ,priority= isdefer ? parseInt(getstyle(deferscript,X).split(" "),10) || 0 : 0
		  ,newscript= isdefer ? copyscript(deferscript) : deferscript
		  ,inhead= deferscript.parentNode == H
		;
		if(src && !newscript.src){
			newscript.removeAttribute(DS); 
			newscript.src= src; 
		}
		if(!isjs) 
			c[c.length]= [
				priority,index,[newscript,marker,isdefer]
			];

		if(isdefer || foundFirst || !isjs)
			deferscript.parentNode.replaceChild(marker,deferscript); 

		if(!foundFirst && !inhead && isdefer)
			foundFirst = isdefer
		index++; 
	}
	//a=b=e=f=g=null;
	return c; 
}
function toArray(a){
	var b= []
	for(var i=0, l= a.length; i < l; i++)
		b[i] = a[i]
	return b
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

this['ghostwriter']['capabilities']= (function(document){
	var 
		 $return = {
		 	'synchronous': false, 
			'localonload': false, 
			'usedatauri' : false,
			'complete': false
		 }
		,$script= "script"
		,$dataUri= "data:text/javascript,void 0"
		,$anchor= document.head || document.getElementsByTagName("head")[0]
	;

	testSynchronousExec()
	testLocalOnload()

	return $return

	function testSynchronousExec(){
		var 
			 asyncBlocker= document.createElement($script)
			,synchronous= document.createElement($script)
			,scriptText= "$gwsynctest= true"
		;
		asyncBlocker.async= synchronous.async= false
		asyncBlocker.src= $dataUri 
		synchronous.text= scriptText

		$anchor.appendChild(asyncBlocker,$anchor)
		$anchor.appendChild(synchronous,$anchor)

		$return['synchronous']= typeof this['$gwsynctest'] == 'boolean'
	}
	function testLocalOnload(){
		var 
			s= document.createElement($script)
			,timer
		;
		s.onload= s.onreadystatechange= function(){
			loadHandler.apply(this,arguments)
			$return['localonload']= true
			$return['usedatauri']= false 
			$return['complete']= true
			clearTimeout(timer)
		}

		timer= setTimeout(function(){
			var s= document.createElement($script)
			s.src= "data:text/javascript,void 0"
			s.onload= s.onreadystatechange= function(){ 
				if(loadHandler.apply(this,arguments)){
					$return['localonload']= 
					  $return['complete']= 
					  $return['usedatauri']= true
				}
			}
			$anchor.appendChild(s)
		}, 1)
		$anchor.appendChild(s)
		return false
	}
	function loadHandler(){ 
		if(
			this.readyState && 
			this.readyState != "complete" && 
			this.readyState != "loaded"
		)
			return false; 
		this.onload= this.onreadystatechange= null
		return true
	}
})(document);
