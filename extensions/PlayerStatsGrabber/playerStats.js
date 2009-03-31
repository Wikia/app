//wgServerOveride: leave empty to use the current server
// (else provide the absolute url to index.php of the wiki you are recording stats to)
var global_req_cb = new Array();//the global request callback array

//extened version of OggHandler
wgExtendedOggPlayerStats = {
	videoUrl:false,
	init:function(player, params){
		this.parent_init( player, params );
		this.videoUrl = params.videoUrl;
		this.doStats();
	},
	doStats:function() {
		//make sure we ran detect:
		if (!this.detectionDone) {
			this.detect();
		}
		
		//build our request url
		/*if( wgServerOverride!="" ){
			url= wgServerOverride;
		}else{
			url = wgServer +((wgScript == null) ? (wgScriptPath + "/index.php") : wgScript);
		}
		url += "?action=ajax&rs=mw_push_player_stats";
		*/

		//detect windows media player ( direct show filters could be installed)
		if ( navigator.mimeTypes && navigator.mimeTypes["video/x-ms-wm"]     &&
			navigator.mimeTypes["video/x-ms-wm"].enabledPlugin){
			this.clientSupports['ms_video'];
		}
		//@@todo research if we can detect if MS video support a given codec

		//detect flash support
		if( FlashDetect.installed )
			this.clientSupports['flash']=true;
		var post_vars='';
		var j=0;
		for(var i in this.clientSupports){
			post_vars+='&cs[]='+encodeURIComponent(i);
			j++;
		}

		//get the flash version:
		post_vars+='&fv='+ encodeURIComponent( FlashDetect.raw );


		//detect java version if possible: (ie not IE with default security)
		if( javaDetect.version ){
			post_vars+= '&jv='+ encodeURIComponent ( javaDetect.version );
		}

		//add some additional params seperated out to enum keys:
		post_vars+= '&b_user_agent=' +encodeURIComponent( navigator.userAgent );		
		
		if(this.videoUrl)
			post_vars+= '&purl='+ encodeURIComponent( this.videoUrl ) ;
		//and finaly add the user hash:
		post_vars+='&uh=' + encodeURIComponent ( wgOggPlayer.userHash );

		//now send out our stats update (run via javascript include to support remote servers:
		//force logger on same server using ajax call:
		mv_sajax_do_call('mw_push_player_stats', '', mv_proc_result, post_vars);
		
		//do_request ( url, function( responseObj ){
		//	wg_ran_stats( responseObj );
		//});
	}
}
//extend the OggHandler object for stats collection
if( typeof wgOggPlayer.doStats =='undefined' ){
	for(var i in wgExtendedOggPlayerStats){
		if(typeof wgOggPlayer[ i ]!='undefined'){
			wgOggPlayer['parent_'+i]= wgOggPlayer[i];		
		}
		wgOggPlayer[ i ]=wgExtendedOggPlayerStats[i];	
	}
}
function wg_ran_stats(responseObj){
	js_log('did stats with id:' + responseObj['id']);
	//add a pointer to the log if we are on the survey page:
	var formElm=document.getElementById('ps_editform'); 
	if(formElm){
		var inputElm = document.createElement('input');
		inputElm.setAttribute( 'name', 'player_stats_log_id' );
		inputElm.setAttribute( 'value', responseObj['id'] );
		inputElm.setAttribute( 'type', 'hidden');		
		formElm.appendChild(inputElm);		
	}
}
function mv_proc_result( request ){
	if ( request.status != 200 ) {
		alert("Error: " + request.status + " " + request.statusText + ": " + request.responseText);
		return;
	}
	//the resutl is just the insert id:
	var result = request.responseText;
	wg_ran_stats({'id':result});
}
//proposed modifications to sajax_do_call:
function mv_sajax_do_call(func_name, args, target, post_vars) {
	var i, x, n;
	var uri;
	var post_data;
	sajax_request_type="POST";
	
	uri = wgServer +
		((wgServer == null) ? (wgScriptPath + "/index.php") : wgScript) +
		"?action=ajax";
	if (sajax_request_type == "GET") {
		if (uri.indexOf("?") == -1)
			uri = uri + "?rs=" + encodeURIComponent(func_name);
		else
			uri = uri + "&rs=" + encodeURIComponent(func_name);
		for (i = 0; i < args.length; i++)
			uri = uri + "&rsargs[]=" + encodeURIComponent(args[i]);
		//uri = uri + "&rsrnd=" + new Date().getTime();
		post_data = null;
	} else {
		post_data = "rs=" + encodeURIComponent(func_name);
		for (var i = 0; i < args.length; i++)
			post_data = post_data + "&rsargs[]=" + encodeURIComponent(args[i]);		
	}
	x = sajax_init_object();
	if (!x) {
		alert("AJAX not supported");
		return false;
	}

	try {
		x.open(sajax_request_type, uri, true);
	} catch (e) {
		if (window.location.hostname == "localhost") {
			alert("Your browser blocks XMLHttpRequest to 'localhost', try using a real hostname for development/testing.");
		}
		throw e;
	}
	if (sajax_request_type == "POST") {
		x.setRequestHeader("Method", "POST " + uri + " HTTP/1.1");
		x.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	}
	x.setRequestHeader("Pragma", "cache=yes");
	x.setRequestHeader("Cache-Control", "no-transform");
	x.onreadystatechange = function() {
		if (x.readyState != 4)
			return;

		sajax_debug("received (" + x.status + " " + x.statusText + ") " + x.responseText);

		//if (x.status != 200)
		//	alert("Error: " + x.status + " " + x.statusText + ": " + x.responseText);
		//else

		if ( typeof( target ) == 'function' ) {
			target( x );
		}
		else if ( typeof( target ) == 'object' ) {
			if ( target.tagName == 'INPUT' ) {
				if (x.status == 200) target.value= x.responseText;
				//else alert("Error: " + x.status + " " + x.statusText + " (" + x.responseText + ")");
			}
			else {
				if (x.status == 200) target.innerHTML = x.responseText;
				else target.innerHTML= "<div class='error'>Error: " + x.status + " " + x.statusText + " (" + x.responseText + ")</div>";
			}
		}
		else {
			alert("bad target for sajax_do_call: not a function or object: " + target);
		}

		return;
	}
	//add payload to post data 	
	if(typeof post_vars=='object' ){
		for(var i in post_vars){
			if(i!='rs' && i!='rsargs')
				post_data+= '&'+ i +'='+ encodeURIComponent(post_vars[i]);
		}
	}else if(typeof post_vars=='string'){
		post_data+='&'+post_vars;
	}
	//js_log(func_name + " uri = " + uri + " / post = " + post_data);
	x.send(post_data);
	sajax_debug(func_name + " waiting..");
	delete x;

	return true;
}
/*
 * a few utily functions
 * to enable cross site requests via json:
 */
function loadExternalJs(url){
   	js_log('load js: '+ url);
    var e = document.createElement("script");
    e.setAttribute('src', url);
    e.setAttribute('type',"text/javascript");
    document.getElementsByTagName("head")[0].appendChild(e);
}
function do_request(req_url, callback, mv_json_response){ 	
 	global_req_cb.push(callback);
	loadExternalJs(req_url+'&cb=mv_jsdata_cb&cb_inx='+(global_req_cb.length-1));
}
function mv_jsdata_cb(response){
	js_log('f:mv_jsdata_cb:'+ response['cb_inx']);
	//run the callback from the global req cb object:
	if(!global_req_cb[response['cb_inx']]){
		js_log('missing req cb index');
		return false;
	}
	global_req_cb[response['cb_inx']](response);
}
function js_log(string){
  if( window.console ){
        console.log(string);
  }else{
     /*
      * IE and non-firebug debug:
      */
    /*var log_elm = document.getElementById('mv_js_log');
     if(!log_elm){
     	document.write('<div style="position:absolute;z-index:500;top:0px;left:0px;right:0px;height:150px;"><textarea id="mv_js_log" cols="80" rows="6"></textarea></div>');
     	var log_elm = document.getElementById('mv_js_log');
     }
     if(log_elm){
     	log_elm.value+=string+"\n";
     }*/
   }
   //in case of "throw error" type usage
   return false;
}

//records java version if possible (without full applet based check)
var javaDetect = {
	javaEnabled: false,
	version: false,
  	init:function(){
	  if (typeof navigator != 'undefined' && typeof navigator.javaEnabled != 'undefined'){
	    this.javaEnabled = navigator.javaEnabled();
	  }else{
	    this.javaEnabled = 'unknown';
	  }
	  if (navigator.javaEnabled() && typeof java != 'undefined')
	    this.version = java.lang.System.getProperty("java.version");
	  //try to get the IE version of java (not likely to work with default security setting)
	  if( wgOggPlayer.msie ){
	    var shell;
		try {
			// Create WSH(WindowsScriptHost) shell, available on Windows only
			shell = new ActiveXObject("WScript.Shell");

			if (shell != null) {
			// Read JRE version from Window Registry
			try {
				this.version = shell.regRead("HKEY_LOCAL_MACHINE\\Software\\JavaSoft\\Java Runtime Environment\\CurrentVersion");
			} catch(e) {
				// handle exceptions raised by 'shell.regRead(...)' here
				// so that the outer try-catch block would receive only
				// exceptions raised by 'shell = new ActiveXObject(...)'
				}
			}
		} catch(e) {
			//could not get it
		}
	  }
  }
}
javaDetect.init();

/*
Copyright (c) Copyright (c) 2007, Carl S. Yestrau All rights reserved.
Code licensed under the BSD License: http://www.featureblend.com/license.txt
Version: 1.0.3
*/
var FlashDetect = new function(){
	var self = this;
	self.installed = false;
	self.raw = "";
	self.major = -1;
	self.minor = -1;
	self.revision = -1;
	self.revisionStr = "";
	var activeXDetectRules = [
		{
			"name":"ShockwaveFlash.ShockwaveFlash.7",
			"version":function(obj){
				return getActiveXVersion(obj);
			}
		},
		{
			"name":"ShockwaveFlash.ShockwaveFlash.6",
			"version":function(obj){
				var version = "6,0,21";
				try{
					obj.AllowScriptAccess = "always";
					version = getActiveXVersion(obj);
				}catch(err){}
				return version;
			}
		},
		{
			"name":"ShockwaveFlash.ShockwaveFlash",
			"version":function(obj){
				return getActiveXVersion(obj);
			}
		}
	];
	var getActiveXVersion = function(activeXObj){
		var version = -1;
		try{
			version = activeXObj.GetVariable("$version");
		}catch(err){}
		return version;
	};
	var getActiveXObject = function(name){
		var obj = -1;
		try{
			obj = new ActiveXObject(name);
		}catch(err){}
		return obj;
	};
	var parseActiveXVersion = function(str){
		var versionArray = str.split(",");//replace with regex
		return {
			"raw":str,
			"major":parseInt(versionArray[0].split(" ")[1], 10),
			"minor":parseInt(versionArray[1], 10),
			"revision":parseInt(versionArray[2], 10),
			"revisionStr":versionArray[2]
		};
	};
	var parseStandardVersion = function(str){
		var descParts = str.split(/ +/);
		var majorMinor = descParts[2].split(/\./);
		var revisionStr = descParts[3];
		return {
			"raw":str,
			"major":parseInt(majorMinor[0], 10),
			"minor":parseInt(majorMinor[1], 10), 
			"revisionStr":revisionStr,
			"revision":parseRevisionStrToInt(revisionStr)
		};
	};
	var parseRevisionStrToInt = function(str){
		return parseInt(str.replace(/[a-zA-Z]/g, ""), 10) || self.revision;
	};
	self.majorAtLeast = function(version){
		return self.major >= version;
	};
	self.FlashDetect = function(){
		if(navigator.plugins && navigator.plugins.length>0){
			var type = 'application/x-shockwave-flash';
			var mimeTypes = navigator.mimeTypes;
			if(mimeTypes && mimeTypes[type] && mimeTypes[type].enabledPlugin && mimeTypes[type].enabledPlugin.description){
				var version = mimeTypes[type].enabledPlugin.description;
				var versionObj = parseStandardVersion(version);
				self.raw = versionObj.raw;
				self.major = versionObj.major;
				self.minor = versionObj.minor; 
				self.revisionStr = versionObj.revisionStr;
				self.revision = versionObj.revision;
				self.installed = true;
			}
		}else if(navigator.appVersion.indexOf("Mac")==-1 && window.execScript){
			var version = -1;
			for(var i=0; i<activeXDetectRules.length && version==-1; i++){
				var obj = getActiveXObject(activeXDetectRules[i].name);
				if(typeof obj == "object"){
					self.installed = true;
					version = activeXDetectRules[i].version(obj);
					if(version!=-1){
						var versionObj = parseActiveXVersion(version);
						self.raw = versionObj.raw;
						self.major = versionObj.major;
						self.minor = versionObj.minor; 
						self.revision = versionObj.revision;
						self.revisionStr = versionObj.revisionStr;
					}
				}
			}
		}
	}();
};
FlashDetect.release = "1.0.3";
