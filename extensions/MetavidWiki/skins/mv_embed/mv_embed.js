/*
 * ~mv_embed version 1.0~
 * for details see: http://metavid.org/wiki/index.php/Mv_embed
 *
 * All Metavid Wiki code is Released under the GPL2
 * for more info visit http://metavid.org/wiki/Code
 *
 * @url http://metavid.org
 *
 * parseUri:
 * http://stevenlevithan.com/demo/parseuri/js/
 *
 * config values you can manually set the location of the mv_embed folder here
 * (in cases where media will be hosted in a different place than the embedding page)
 *
 */
//fix multiple instances of mv_embed (ie include twice from two different servers) 
var MV_DO_INIT=true;
if( MV_EMBED_VERSION ){
	js_log('mv_embed already included do nothing');
	MV_DO_INIT=false;	
}
//used to grab fresh copies of scripts. (should be changed on commit)  
var MV_EMBED_VERSION = '1.0r12';

//the name of the player skin (default is mvpcf)
var mv_skin_name = 'mvpcf';

//whether or not to load java from an iframe.
//note: this is necessary for remote embedding because of java security model)
var mv_java_iframe = true;

//media_server mv_embed_path (the path on media servers to mv_embed for java iframe with leading and trailing slashes)
var mv_media_iframe_path = '/mv_embed/';

//the default height/width of the video (if no style or width attribute provided)
var mv_default_video_size = '400x300'; 

var global_player_list = new Array();
var global_req_cb = new Array(); //the global request callback array
var _global = this;
var mv_init_done=false;
var global_cb_count =0;

/*parseUri class parses URIs:*/
var parseUri=function(d){var o=parseUri.options,value=o.parser[o.strictMode?"strict":"loose"].exec(d);for(var i=0,uri={};i<14;i++){uri[o.key[i]]=value[i]||""}uri[o.q.name]={};uri[o.key[12]].replace(o.q.parser,function(a,b,c){if(b)uri[o.q.name][b]=c});return uri};parseUri.options={strictMode:false,key:["source","protocol","authority","userInfo","user","password","host","port","relative","path","directory","file","query","anchor"],q:{name:"queryKey",parser:/(?:^|&)([^&=]*)=?([^&]*)/g},parser:{strict:/^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,loose:/^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/)?((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/}};

//get mv_embed location if it has not been set
if( !mv_embed_path ){
	var mv_embed_path = getMvEmbedPath();
}

var mvLoadEvent = new Array() //the onReady global event.. @@todo should be removed and use jquery style document.ready stuff instead
//the default thumbnail for missing images:
var mv_default_thumb_url = mv_embed_path + 'images/vid_default_thumb.jpg';

//init the global Msg if not already
if(!gMsg){var gMsg={};}
//laguage loader:
function loadGM( msgSet ){
	for(var i in msgSet){
		gMsg[ i ] = msgSet[i];
	}
}

//all default msg in [English] should be overwritten by the CMS language msg system.
loadGM({ 
	"loading_txt":"loading <blink>...</blink>",
	"loading_plugin" : "loading plugin<blink>...</blink>",
	"select_playback" : "Set Playback Preference",
	"link_back" : "Link Back",
	"error_load_lib" : "mv_embed: Unable to load required javascript libraries\n insert script via DOM has failed, try reloading?  ",
				 	
	"error_swap_vid" : "Error:mv_embed was unable to swap the video tag for the mv_embed interface",
	
	"download_segment" : "Download Selection:",
	"download_full" : "Download Full Video File:",
	"download_clip" : "Download the Clip",
	"download_text" : "Download Text (<a style=\"color:white\" title=\"cmml\" href=\"http://wiki.xiph.org/index.php/CMML\">cmml</a> xml):",
	
	"clip_linkback" : "Clip Source Page",
	
	"mv_ogg-player-vlc-mozilla" : "VLC Plugin",
	"mv_ogg-player-videoElement" : "Native Ogg Video Support",
	"mv_ogg-player-vlc-activex" : "VLC ActiveX",
	"mv_ogg-player-oggPlay" : "Annodex OggPlay Plugin",
	"mv_ogg-player-oggPlugin" : "Generic Ogg Plugin",
	"mv_ogg-player-quicktime-mozilla" : "Quicktime Plugin",
	"mv_ogg-player-quicktime-activex" : "Quicktime ActiveX",
	"mv_ogg-player-cortado" : "Java Cortado",
	"mv_ogg-player-flowplayer" : "Flowplayer",
	"mv_ogg-player-selected" : " (selected)",
	"mv_generic_missing_plugin" : "You browser does not appear to support playback type: <b>$1</b><br> visit the <a href=\"http://metavid.org/wiki/Client_Playback\">Playback Methods</a> page to download a player<br>",
			
	"add_to_end_of_sequence" : "Add to End of Sequence",
	
	"missing_video_stream" : "The video file for this stream is missing",
	
	"select_transcript_set" : "Select Text Layers",
	"auto_scroll" : "auto scroll",
	"close" : "close",
	"improve_transcript" : "Improve Transcript",
	
	"next_clip_msg" : "Play Next Clip",
	"prev_clip_msg" : "Play Previous Clip",
	"current_clip_msg" : "Continue Playing this Clip",	
	"seek_to" : "Seek to"
});

//get a language message 
function gM( key , args ) {
	 if ( key in gMsg ) {
	    if(typeof args == 'object'){	    		 
		 	for(var v in args){
		 		gMsg[key] = gMsg[key].replace('\$'+v, args[v]);
		 	}		 	
	 	}else if(typeof args =='string'){
	 		gMsg[key] = gMsg[key].replace(/\$1/, args);
	 	}
	 	return gMsg[key];
	 } else{
	 	return '[' + key + ']';
	 }	 
}

//gets the loading image:
function mv_get_loading_img( style , class_attr ){
	var style_txt = (style)?style:'';
	var class_attr = (class_attr)?'class="'+class_attr+'"':'class="mv_loading_img"';
	return '<div '+class_attr+' style="' + style +'"></div>';
}

function mv_set_loading(target, load_id){
	var id_attr = ( load_id )?' id="' + load_id + '" ':'';
	$j(target).append('<div '+id_attr+' style="position:absolute;top:0px;left:0px;height:100%;width:100%;'+
		'background-color:#FFF;">' + 			
			mv_get_loading_img('top:30px;left:30px') + 
		'</div>');	
}

var mvBaseLoader = {
	calledloadBaseLibs:false,	
	callbacks:new Array(),
	done:false,
	load:function( callback){
		//if we are done loading the libs just jump directly to the callback
		if(this.done==true){
			callback();
			return ;
		}
		//queue the callback: 
	 	if(callback)
	 		mvBaseLoader.addLoadEvent(callback);
	 	//run if not already running: 
	 	if( ! mvBaseLoader.calledloadBaseLibs ){	 		
		 	js_log("called loadBaseLibs");  	
		 	//only call load base libs once
		 	mvBaseLoader.calledloadBaseLibs=true;    	
		 	//issue a style sheet request can come in whenever:
		 	if(!styleSheetPresent(mv_embed_path+'skins/'+mv_skin_name+'/styles.css'))
				loadExternalCss(mv_embed_path+'skins/'+mv_skin_name+'/styles.css');
			  	  	  
			//two loading stages, first get jQuery
			var _this = this;
		 	mvJsLoader.doLoad({
		 		'window.jQuery'		:'jquery/jquery-1.2.6.js'	 		
		 	},function(){  				 		
		 		//once jQuery is loaded set up no conflict & load plugins:
				_global['$j'] = jQuery.noConflict();
				//set up ajax to not send dynamic urls for loading scripts
				$j.ajaxSetup({		  
			  		cache: true
				});
				js_log('jquery loaded');
				//load the jQuery dependent plugins:  		 		
				mvJsLoader.doLoad({
					'embedVideo'	  : 'libEmbedObj/mv_baseEmbed.js',
					'$j.ui.mouse'	  : 'jquery/jquery.ui-1.5.2/ui/minified/ui.core.min.js',
					'$j.ui.droppable' : 'jquery/jquery.ui-1.5.2/ui/minified/ui.droppable.min.js',
					'$j.ui.draggable' : 'jquery/jquery.ui-1.5.2/ui/minified/ui.draggable.min.js'
					},function(){			
						js_log('plugins loaded: ');			
						mvBaseLoader.done = true;						
						// run queued functions from (addLoadEvent)
						mvBaseLoader.runQuededFunctions();									
					});
			 	});
	 	}
	},
	runQuededFunctions:function(){	 	
	 	js_log('runQuededFunctions::');
		 while( mvBaseLoader.callbacks.length ){
			mvBaseLoader.callbacks.shift()();
		}	
	 },
	 addLoadEvent:function(fn){
	 	mvBaseLoader.callbacks.push(fn);
	 }	
}

/**
  * mvJsLoader class handles initialization and js file loads 
  */
var mvJsLoader = {
	 libreq:{},
	 libs:{},
	 //to keep consistency across threads: 
	 ptime:0,
	 ctime:0,	 
	 load_error:false,//load error flag (false by default)
	 load_time:0,	 
	 callbacks:new Array(),	 	  	 
	 doLoad:function(libs, callback){	 	
	 	this.ctime++;
	 	if(libs){ //setup this.libs: 	 		 		 	
	 		//first check if we already have this lib loaded
	 		var all_libs_loaded=true;
	 		for(var i in libs){
	 			//check if the lib is already loaded: 
				if( ! this.checkObjPath( i ) ){
					all_libs_loaded=false;							
				}		
	 		}
	 		if( all_libs_loaded ){
	 			js_log('all libs already loaded skipping...' + libs);
				callback();
				return ;
			}					 						
	 		//check if we should use the script loader to combine all the requests into one:
		 	if( usingScriptLoaderCheck() ){		
		 		var class_set = '';
		 	 	var last_class = '';	
		 	 	var coma = ''; 
		 	 	for( var i in libs ){
		 	 		//only add if not included yet: 
		 	 		if( ! this.checkObjPath( i ) ){
			 	 		class_set+=coma + i ;	 	 		
			 	 		last_class=i;
			 	 		coma=',';
		 	 		}
		 	 	}	 
		 	 	var dbug_attr = (parseUri( getMvEmbedURL() ).queryKey['debug'])?'&debug=true':''; 		 					 	 	 	
		 	 	this.libs[ last_class ] = 'mvwScriptLoader.php?class=' + class_set +
		 	 						'&urid=' + getMvUniqueReqId() + dbug_attr;
		 	 								
		 	}else{			 	 		 	 			 		 	 
				//do many requests:
			 	for(var i in libs){ //for in loop oky on object
			 		// do a direct load of the file (pass along unique id from request or mv_embed Version ) 
			 		var qmark = (libs[i].indexOf('?')!==true)?'?':'&';
			 		this.libs[i]=libs[i] + qmark + 'urid='+ getMvUniqueReqId(); 
			 	}	 				
			}
		}
		if( callback ){ 
		 	 	this.callbacks.push(callback);
		}		
		if( mvJsLoader.checkLoading() ){
			 if( this.load_time++ > 2000){ //time out after ~50seconds
			 	js_error( gM('error_load_lib') +  this.cur_path );
			 	this.load_error=true;			 	
			 }else{
				setTimeout( 'mvJsLoader.doLoad()', 25 );
			 }
		 }else{
		 	js_log('checkLoading passed for:  do run callbacks');
		 	//only do callback if we are in the same instance (weird concurency issue) 		 	
		 	var cb_count=0;
		 	for(var i=0; i < this.callbacks.length; i++)
		 		cb_count++;		 		
		 	//js_log('REST LIBS: loading is: '+ loading + ' run callbacks: '+cb_count +' p:'+ this.ptime +' c:'+ this.ctime);
		 	//reset the libs
		 	this.libs={};		 			 			 			
		 	//js_log('done loading do call: ' + this.callbacks[0] );		 
		 	while( this.callbacks.length !=0 ){
		 		if( this.ptime== ( this.ctime-1) ){ //enforce thread consistency
		 			this.callbacks.pop()();
		 			//func = this.callbacks.pop();
		 			//js_log(' run: '+this.ctime+ ' p: ' + this.ptime + ' ' +loading+ ' :'+ func);
					//func();		
		 		}else{
		 			//re-issue doLoad ( ptime will be set to ctime so we should catch up) 
		 			setTimeout( 'mvJsLoader.doLoad()', 25 );
		 			break;
		 		}
		 	}		 	
		 }
		 this.ptime=this.ctime;		
	 },
	 checkLoading:function(){
	 	 var loading=0;
		 var i=null;
		 for(var i in this.libs){ //for in loop oky on object			 		 
			 if( ! this.checkObjPath( i ) ){				 
				 if(!this.libreq[i]) loadExternalJs( getMvEmbedPath() + this.libs[i] );
				 this.libreq[i]=1;
				 loading=1;
			 }
		 }		 
		 return loading;
	},
	checkObjPath:function( libVar ){
	 	 var objPath = libVar.split('.')
		 var cur_path ='';		 
		 for(var p=0; p < objPath.length; p++){
			 cur_path = (cur_path=='')?cur_path+objPath[p]:cur_path+'.'+objPath[p];
			 eval( 'var ptest = typeof ( '+ cur_path + ' ); ');				 
			 if( ptest == 'undefined'){				 			
				 return false;
			 }			 
	 	 }
		 this.cur_path = cur_path;
		 return true;
	},
	loadBaseLibs:function( callback ){
		mvBaseLoader.load( callback);
	}
}




/**
  * mediaPlayer represents a media player plugin.
  * @param {String} id id used for the plugin.
  * @param {Array<String>} supported_types n array of supported MIME types.
  * @param {String} library external script containing the plugin interface code. (mv_<library>Embed.js)
  * @constructor
  */
function mediaPlayer(id, supported_types, library)
{
    this.id=id;
    this.supported_types = supported_types;
    this.library = library;
	this.loaded = false;
	this.loading_callbacks = new Array();
    return this;
}
mediaPlayer.prototype =
{
    id:null,
    supported_types:null,
    library:null,
	loaded:false,
	loading_callbacks:null,	
    supportsMIMEType : function(type)
    {    	
        for (var i=0; i < this.supported_types.length; i++)
            if(this.supported_types[i] == type)
                return true;
        return false;
    },
    getName : function()
    {
        return gM('mv_ogg-player-' + this.id);
    },
	load : function(callback)
	{
		if(this.loaded)
		{
			js_log('plugin loaded, scheduling immediate processing');
			callback();
		}
		else
		{
			var _this = this;
			var plugin_path = mv_embed_path + 'libEmbedObj/mv_'+this.library+'Embed.js';	
			//add the callback: 
			this.loading_callbacks.push(callback);									
			//jQuery based get script does not work so well. 
			/*$j.getScript(plugin_path, function(){				
				js_log(_this.id + ' plugin loaded');
				_this.loaded = true;
				for(var i in _this.loading_callbacks)
					_this.loading_callbacks[i]();	
				_this.loading_callbacks = null;
			});*/
			
			eval('var lib = {"'+this.library+'Embed":\'libEmbedObj/mv_'+this.library+'Embed.js\'}');
			js_log('DO LOAD: '+this.library); 
			mvJsLoader.doLoad(lib,function(){
				//js_log( 'type of lib: ' + eval( 'typeof ' + this.library + 'Embed' ) );
				//js_log(_this.id + ' plugin loaded');
				_this.loaded = true;
				//make sure we have not already cleared the callbacks: 		
				if(_this.loading_callbacks != null){ 		
					for(var i=0; i < _this.loading_callbacks.length; i++ )
						_this.loading_callbacks[i]();	
				}
				_this.loading_callbacks = null;
								
			});
		}
	}	
}
/* players and supported mime types 
@@todo ideally we query the plugin to get what mime types it supports in practice not always reliable/avaliable
*/
var flowPlayer = new mediaPlayer('flowplayer',['video/x-flv', 'video/h264'],'flash');

var cortadoPlayer = new mediaPlayer('cortado',['video/ogg'],'java');
var videoElementPlayer = new mediaPlayer('videoElement',['video/ogg'],'native');
var vlcMozillaPlayer = new mediaPlayer('vlc-mozilla',['video/ogg', 'video/x-flv', 'video/mp4',  'video/h264'],'vlc');
var vlcActiveXPlayer = new mediaPlayer('vlc-activex',['video/ogg', 'video/x-flv', 'video/mp4',  'video/h264'],'vlc');

var oggPlayPlayer = new mediaPlayer('oggPlay',['video/ogg'],'oggplay');
var oggPluginPlayer = new mediaPlayer('oggPlugin',['video/ogg'],'generic');
var quicktimeMozillaPlayer = new mediaPlayer('quicktime-mozilla',['video/ogg'],'quicktime');
var quicktimeActiveXPlayer = new mediaPlayer('quicktime-activex',['video/ogg'],'quicktime');

var htmlPlayer = new mediaPlayer('html',['text/html', 'image/jpeg', 'image/png'],'html');

/**
  * mediaPlayers is a collection of mediaPlayer objects supported by the client.
  * It could be merged with embedTypes, since there is one embedTypes per script
  * and one mediaPlayers per embedTypes.
  */
function mediaPlayers()
{
    this.init();
}

mediaPlayers.prototype =
{
    players : null,
    preference : null,
    default_players : {},
    init : function()
    {
        this.players = new Array();
        this.loadPreferences();
        //set up default players library mapping        
        this.default_players['video/x-flv'] = ['flash','vlc'];
        this.default_players['video/h264'] = ['flash', 'vlc'];
        
        this.default_players['video/ogg'] = ['native','vlc','java', 'generic'];        
        this.default_players['application/ogg'] = ['native','vlc','java', 'generic'];
        
		this.default_players['video/mp4'] = ['vlc'];
		
		this.default_players['text/html'] = ['html'];
		this.default_players['image/jpeg'] = ['html'];
		
    },
    addPlayer : function(player, mime_type)
    {    	
        //js_log('Adding ' + player.id + ' with mime_type ' + mime_type);
        for (var i =0; i < this.players.length; i++){
            if (this.players[i].id == player.id)
            {
                if(mime_type!=null)
                {
                	//make sure the mime_type is not already there:
                	var add_mime = true; 
                	for(var j=0; j < this.players[i].supported_types.length; j++ ){
                		if( this.players[i].supported_types[j]== mime_type)
                			add_mime=false;
                	}                    
                    if(add_mime)
                    	this.players[i].supported_types.push(mime_type);
                }
                return;
            }
        }
        //player not found: 
        if(mime_type!=null)
        	player.supported_types.push(mime_type);      
                 
        this.players.push(player);
    },
    getMIMETypePlayers : function(mime_type)
    {    	    	
        var mime_players = new Array();
        var _this = this;
        var inx = 0;
		if( this.default_players[mime_type] ){						
			$j.each( this.default_players[mime_type], function(d, lib){				
				var library = _this.default_players[mime_type][d];				
				for ( var i=0; i < _this.players.length; i++ ){					
					if ( _this.players[i].library == library && _this.players[i].supportsMIMEType(mime_type) ){
						mime_players[ inx ] = _this.players[i];						
						inx++;
					}
				}
			});
		}		
        return mime_players;
    },
    defaultPlayer : function(mime_type)
    {    	    	
    	js_log("f:defaultPlayer: " + mime_type);
        var mime_players = this.getMIMETypePlayers(mime_type);        
        if( mime_players.length > 0)
        {
            // check for prior preference for this mime type
            for( var i=0; i < mime_players.length; i++ ){
                if( mime_players[i].id==this.preference[mime_type] )
                    return mime_players[i];
            }                    
            // otherwise just return the first compatible player
			// (it will be chosen according to the default_players list
            return mime_players[0];
        }
        js_log( 'No default player found for ' + mime_type );
        return null;
    },
    userSelectFormat : function (mime_format){
    	 this.preference['format_prefrence'] = mime_format;
    	 this.savePreferences();
    },
    userSelectPlayer : function(player_id, mime_type)
    {
        var selected_player=null;
        for(var i=0; i < this.players.length; i++){
            if(this.players[i].id == player_id)
            {
                selected_player = this.players[i];
                js_log('choosing ' + player_id + ' for ' + mime_type);
                this.preference[mime_type]=player_id;
                this.savePreferences();
                break;
            }
        }
        if(selected_player)
        {
            for(var i=0; i < global_player_list.length; i++)
            {
                var embed = $j('#'+global_player_list[i]).get(0);
                if(embed.media_element.selected_source && (embed.media_element.selected_source.mime_type == mime_type))
                {
                    embed.selectPlayer(selected_player);
                    js_log('using ' + embed.selected_player.getName() + ' for ' + embed.media_element.selected_source.getTitle());
                }
            }
        }
    },
    loadPreferences : function()
    {
        this.preference = new Object();
    	// see if we have a cookie set to a clientSupported type:
		var cookieVal = getCookie( 'ogg_player_exp' );
		if (cookieVal)
        {
            var pairs = cookieVal.split('&');
            for(var i=0; i < pairs.length; i++)
            {
                var name_value = pairs[i].split('=');
                this.preference[name_value[0]]=name_value[1];
                //js_log('load preference for ' + name_value[0] + ' is ' + name_value[1]);
            }
        }
    },
    savePreferences : function()
    {
        var cookieVal = '';        
        for(var i in this.preference)
            cookieVal+= i + '='+ this.preference[i] + '&';
            
        cookieVal=cookieVal.substr(0, cookieVal.length-1);        
		var week = 7*86400*1000;
		setCookie( 'ogg_player_exp', cookieVal, week, false, false, false, false );
    }
};

function getCookie ( cookieName ) {
	var m = document.cookie.match( cookieName + '=(.*?)(;|$)' );
	//js_log('getCookie:' + cookieName + ' v:' + (m ? unescape( m[1] ) : false));
	return m ? unescape( m[1] ) : false;
}

function setCookie(name, value, expiry, path, domain, secure) {
	js_log('setCookie:' + name + ' v:' + value);
   	var expiryDate = false;
	if ( expiry ) {
		expiryDate = new Date();
		expiryDate.setTime( expiryDate.getTime() + expiry );
	}
	document.cookie = name + "=" + escape(value) + 
		(expiryDate ? ("; expires=" + expiryDate.toGMTString()) : "") + 
		(path ? ("; path=" + path) : "") + 
		(domain ? ("; domain=" + domain) : "") + 
		(secure ? "; secure" : "");
}
/*
 * embedTypes object handles setting and getting of supported embed types:
 * closely mirrors OggHandler so that its easier to share efforts in this area:
 * http://svn.wikimedia.org/viewvc/mediawiki/trunk/extensions/OggHandler/OggPlayer.js
 */
var embedTypes = {
	 // List of players
	 players: null,
	 detect_done:false,	 
	 init: function(){
		//detect supported types
		this.detect();
		this.detect_done=true;
	},
	clientSupports: { 'thumbnail' : true },
 	detect: function() {
 		js_log("running detect");
        this.players = new mediaPlayers();
		//every browser supports html rendering:
		this.players.addPlayer( htmlPlayer );
		 // First some browser detection
		 this.msie = ( navigator.appName == "Microsoft Internet Explorer" );
		 this.msie6 = ( navigator.userAgent.indexOf("MSIE 6")===false);
		 this.opera = ( navigator.appName == 'Opera' );
		 this.safari = ( navigator.vendor && navigator.vendor.substr( 0, 5 ) == 'Apple' );
		
		 // In Mozilla, navigator.javaEnabled() only tells us about preferences, we need to
		 // search navigator.mimeTypes to see if it's installed
		 var javaEnabled = navigator.javaEnabled();
		 // In Opera, navigator.javaEnabled() is all there is
		 var invisibleJava = this.opera;
		 // Some browsers filter out duplicate mime types, hiding some plugins
		 var uniqueMimesOnly = this.opera || this.safari;
		 // Opera will switch off javaEnabled in preferences if java can't be found.
		 // And it doesn't register an application/x-java-applet mime type like Mozilla does.
		 if ( invisibleJava && javaEnabled )
		 	this.players.addPlayer( cortadoPlayer );
		
		 // ActiveX plugins
		 if(this.msie){
		 	 // check for flash		 
		 	  if ( this.testActiveX( 'ShockwaveFlash.ShockwaveFlash'))
		 	  	this.players.addPlayer(flowPlayer);
			 // VLC
			 if ( this.testActiveX( 'VideoLAN.VLCPlugin.2' ) )
			 	this.players.addPlayer(vlcActiveXPlayer);
			 // Java
			 if ( javaEnabled && this.testActiveX( 'JavaWebStart.isInstalled' ) )
			 	this.players.addPlayer(cortadoPlayer);
			 // quicktime
			 if ( this.testActiveX( 'QuickTimeCheckObject.QuickTimeCheck.1' ) )
			 	this.players.addPlayer(quicktimeActiveXPlayer);			 
		 }				 
		// <video> element
		if ( typeof HTMLVideoElement == 'object' // Firefox, Safari
				|| typeof HTMLVideoElement == 'function' ) // Opera
		{
			//do another test for safari: 
			if( this.safari ){
				var dummyvid = document.createElement("video");
				if (dummyvid.canPlayType("video/ogg;codecs=\"theora,vorbis\"") == "probably")
				{
					this.players.addPlayer( videoElementPlayer );
				} else {
					/* could add some user nagging to install the xiph qt */
				}
			}else{
				this.players.addPlayer( videoElementPlayer );
			}
		}
		 	
		
		 // Mozilla plugins
		if( navigator.mimeTypes && navigator.mimeTypes.length > 0) {
			for ( var i = 0; i < navigator.mimeTypes.length; i++ ) {
				var type = navigator.mimeTypes[i].type;
				var semicolonPos = type.indexOf( ';' );
				if ( semicolonPos > -1 ) {
					type = type.substr( 0, semicolonPos );
				}
				//js_log('on type: '+type);
				var pluginName = navigator.mimeTypes[i].enabledPlugin ? navigator.mimeTypes[i].enabledPlugin.name : '';
				if ( !pluginName ) {
					// In case it is null or undefined
					pluginName = '';
				}				
		        if ( pluginName.toLowerCase() == 'vlc multimedia plugin' || pluginName.toLowerCase() == 'vlc multimedia plug-in' ) {
		            this.players.addPlayer(vlcMozillaPlayer, type);
		            continue;
		        }
		
				if ( javaEnabled && type == 'application/x-java-applet' ) {
					this.players.addPlayer(cortadoPlayer);
					continue;
				}
				if( type=='application/liboggplay'){
					this.players.addPlayer(oggPlayPlayer);
					continue;
				}
		
				if ( type == 'application/ogg' ) {
					if ( pluginName.toLowerCase() == 'vlc multimedia plugin' )
						this.players.addPlayer(vlcMozillaPlayer, type);
					else if ( pluginName.indexOf( 'QuickTime' ) > -1 )
						this.players.addPlayer(quicktimeMozillaPlayer);
					else
						this.players.addPlayer(oggPluginPlayer);
					continue;
				} else if ( uniqueMimesOnly ) {
					if ( type == 'application/x-vlc-player' ) {
						this.players.addPlayer(vlcMozillaPlayer, type);
						continue;
					} else if ( type == 'video/quicktime' ) {
						this.players.addPlayer(quicktimeMozillaPlayer);
						continue;
					}
				}
		
				/*if ( type == 'video/quicktime' ) {
					this.players.addPlayer(vlcMozillaPlayer, type);
					continue;
				}*/
				if(type=='application/x-shockwave-flash'){
					this.players.addPlayer(flowPlayer);
					continue;
				}
			}
		}
		//@@The xiph quicktime component does not work well with annodex streams (temporarly disable)
		//this.clientSupports['quicktime-mozilla'] = false;
		//this.clientSupports['quicktime-activex'] = false;
		//js_log(this.clientSupports);
	 },
	testActiveX : function ( name ) {
		 var hasObj = true;
		 try {
			 // No IE, not a class called "name", it's a variable
			 var obj = new ActiveXObject( '' + name );
		 } catch ( e ) {
			 hasObj = false;
		 }
		 return hasObj;
	 }	 
}
//set up embedTypes		
embedTypes.init();

//load an external JS (similar to jquery .require plugin)
//but checks for object availability rather than load state

/*********** INITIALIZATION CODE *************
 * this will get called when DOM is ready
 *********************************************/
/* jQuery .ready does not work when jQuery is loaded dynamically
 * for an example of the problem see:1.1.3 working:http://pastie.caboo.se/92588
 * and >= 1.1.4 not working: http://pastie.caboo.se/92595
 * $j(document).ready( function(){ */
function init_mv_embed(force){
	js_log('f:init_mv_embed');
	if( !force && mv_init_done  ){
		js_log("mv_init_done do nothing...");
		return false;
	}
	mv_init_done=true;	
	//check if this page does have video or playlist
	if(document.getElementsByTagName("video").length!=0 ||
	   document.getElementsByTagName("playlist").length!=0){
		js_log('we have vids to process');		
		//load libs and proccess: 		    		
		mvJsLoader.loadBaseLibs(function(){
			//run any queded global events:
			mv_embed( function(){
				while(mvLoadEvent.length){
					mvLoadEvent.pop()();		
				}
			});					
		});		
	}else{
		//run any queded global events: 
		while(mvLoadEvent.length){
			mvLoadEvent.pop()();		
		}
	}
}
/*
 * this function allows for targeted rewriting 
 */
function rewrite_by_id( vid_id, ready_callback ){
	js_log('f:rewrite_by_id: ' + vid_id);	
	//force a recheck of the dom for playlist or video element: 	
	mvJsLoader.loadBaseLibs(function(){
	 	mv_embed(ready_callback, vid_id ); 
	});
}
function rewrite_for_oggHanlder( vidIdList ){		
	for(var i = 0; i < vidIdList.length ; i++){		
		var vidId = vidIdList[i];
		js_log('looking at vid: ' + i +' ' + vidId);		
		//grab the thumbnail and src video
		var pimg = $j('#'+vidId + ' img');
		var poster = pimg.attr('src');
		var pwidth = pimg.attr('width');
		var pheight = pimg.attr('height');		
		//reg videoUrl\":\s*"([^"]*)
		
		var re = new RegExp( /videoUrl(&quot;:?\s*)*([^&]*)/ );
		var src  = re.exec( $j('#'+vidId).html() )[2];
		//replace the top div with mv_embed based player: 
		var vid_html = '<video id="vid_' + i +'" '+ 
		 		'src="' + src + ' poster="' + poster + '" style="width:' + pwidth +
		 			 	'px;height:' + pheight + 'px;"></video>';
		if( src && poster)	
		 	$j('#'+vidId).replaceWidth( vid_html );		
		//rewrite that video id: 
		rewrite_by_id('vid_' + i);
	}
}


/*********** INITIALIZATION CODE *************
 * set DOM ready callback to init_mv_embed
 *********************************************/
// for Mozilla browsers
if (document.addEventListener && !embedTypes.safari ) {
    document.addEventListener("DOMContentLoaded", function(){init_mv_embed()}, false);
}else{	
	//backup "onload" method in case on DOMContentLoaded does not exist
	window.onload = function(){init_mv_embed()};
}
//for IE (temporarily disabled causing empty document rewrites:
/*if (document.all && !window.opera){ //Crude test for IE
	js_log('doing IE on ready');
//Define a "blank" external JavaScript tag
  document.write('<script type="text/javascript" id="contentloadtag" defer="defer" src="javascript:void(0)"><\/script>')
  var contentloadtag=document.getElementById("contentloadtag")
  contentloadtag.onreadystatechange=function(){
    if (this.readyState=="complete" || this.readyState=='loaded')
      init_mv_embed();
  }
}*/
//safari now supports dom injection (code removed below)

/*
* Converts all occurrences of <video> tag into video object
*/
function mv_embed(swap_done_callback, force_id){
	mvEmbed.init( swap_done_callback, force_id );
}
mvEmbed = {	
	flist:new Array(),
	init:function( swap_done_callback, force_id ){
		if(swap_done_callback)
			mvEmbed.flist.push( swap_done_callback );
		//get mv_embed location if it has not been set
		js_log('mv_embed ' + MV_EMBED_VERSION);
		
		this.swap_done_callback = swap_done_callback;
		
		var loadPlaylistLib=false;
		//set up the jQuery selector: 				
		if( force_id == null && force_id != '' ){
			var j_selector = 'video,audio,playlist';
		}else{
			var j_selector = '#'+force_id;
		}
		
		js_log('SELECTOR: '+ j_selector);
		
		//process selected elements: 
		$j(j_selector).each(function(){
			js_log( "Do SWAP: " + $j(this).attr("id") + ' tag: '+ this.tagName.toLowerCase() );
					
			if( $j(this).attr("id") == '' ){
				$j(this).attr("id", 'v'+ global_player_list.length);
			}			
			//stre a global reference to the id    
		   	global_player_list.push( $j(this).attr("id") );
			//add loading: (pre-loading div) 		
			/*$j(this).after('<div id="pre_loading_div_'+elm_id + '">'+
		           	gM('loading_txt')+'</div>' );
		       */ 
		       
		       //if video doSwap
		       switch( this.tagName.toLowerCase()){
		       	case 'video':
		       		var videoInterface = new embedVideo(this);	 
					mvEmbed.swapEmbedVideoElement( this, videoInterface );
		       	break;
		       	case 'audio':
		       		var videoInterface = new embedVideo(this);	 
		       		videoInterface.type ='audio';
					mvEmbed.swapEmbedVideoElement( this, videoInterface );
		       	break;
		       	case 'playlist':
		       		loadPlaylistLib=true;
		       	break;
		       }        
		});	
		if(loadPlaylistLib){		
			mvJsLoader.doLoad({ 'mvPlayList' : 'libSequencer/mvPlayList.js' },function(){
				$j('playlist').each(function(){		
					//check if we are in sequence mode load sequence libs (if not already loaded)				 				
					if( $j(this).attr('sequencer')=="true" ){
						var pl_element = this;
						//load the mv_sequencer and the json util lib:
						mvJsLoader.doLoad({
								'mvSeqPlayList':'libSequencer/mvSequencer.js'							
							},function(){
								var seqObj = new mvSeqPlayList( pl_element );
								mvEmbed.swapEmbedVideoElement( pl_element, seqObj );																					
							}
						); 
					}else{					
						//create new playlist interface:
						var plObj = new mvPlayList( this );		
						mvEmbed.swapEmbedVideoElement(this, plObj);
						var added_height = plObj.pl_layout.title_bar_height + plObj.pl_layout.control_height;		
						//move into a blocking display container with height + controls + title height: 
						$j('#'+plObj.id).wrap('<div style="display:block;height:' + (plObj.height + added_height) + 'px;"></div>');					
					}											
				});
			});
		}
		this.checkClipsReady();
	},
	/*
	* swapEmbedVideoElement
	* takes a video element as input and swaps it out with
	* an embed video interface based on the video_elements attributes
	*/
	swapEmbedVideoElement:function(video_element, videoInterface){
		js_log('do swap ' + videoInterface.id + ' for ' + video_element);
		embed_video = document.createElement('div');
		//make sure our div has a hight/width set:
			
		$j(embed_video).css({
			'width':videoInterface.width,
			'height':videoInterface.height
		});
		//inherit the video interface
		for(var method in videoInterface){ //for in loop oky in Element context	
			if(method!='readyState'){ //readyState crashes IE
				if(method=='style'){
						embed_video.setAttribute('style', videoInterface[method]);
				}else if(method=='class'){
					if(embedTypes.msie)
						embed_video.setAttribute("className", videoInterface['class']);
					else
						embed_video.setAttribute("class", videoInterface['class']);
				}else{
					//normal inherit:
					embed_video[method]=videoInterface[method];
				}
			}
			//string -> boolean:
			if(embed_video[method]=="false")embed_video[method]=false;
			if(embed_video[method]=="true")embed_video[method]=true;
		}	
		///js_log('did vI style');  
		//now swap out the video element for the embed_video obj:  	
	  	$j(video_element).after(embed_video).remove();	
	  	//js_log('did swap');    	  
	  	$j('#'+embed_video.id).get(0).on_dom_swap();
	  	//remove loading: 
	  	$j('#pre_loading_div_'+embed_video.id).remove();
		// now that "embed_video" is stable, do more initialization (if we are ready)
		if($j('#'+embed_video.id).get(0).loading_external_data==false && 
		   	$j('#'+embed_video.id).get(0).init_with_sources_loadedDone==false){
			//load and set ready state since source are available: 
			$j('#'+embed_video.id).get(0).init_with_sources_loaded();
		}   
	    js_log('done with child: ' + embed_video.id + ' len:' + global_player_list.length);
	 	return true;
	},
	//this should not be needed.
	checkClipsReady : function(){
		var is_ready=true;  	
	  	for(var i=0; i < global_player_list.length; i++){
	  		if( $j('#'+global_player_list[i]).length !=0){
		  		var cur_vid =  $j('#'+global_player_list[i]).get(0);  		
		    	is_ready = ( cur_vid.ready_to_play ) ? is_ready : false;
		    	if( !is_ready && cur_vid.load_error ){ 
		    		is_ready=true;
		    		$j(cur_vid).html( cur_vid.load_error );
		    	}
	    	}
	    }
		if( is_ready ){
			mvEmbed.allClipsReady = true;
			// run queued functions 
			js_log('run queded functions:');
			while (mvEmbed.flist.length){
				mvEmbed.flist.shift()();
			}
		}else{			 	
	 		setTimeout( 'mvEmbed.checkClipsReady()', 25 );
	 	}	  		
	}
}
/* init remote search */
function mv_do_remote_search(initObj){
	js_log(':::::mv_do_remote_search::::');
	//insure we have the basic libs (jquery etc) : 
	mvJsLoader.loadBaseLibs(function(){
		//load search specifc extra stuff 
		mvJsLoader.doLoad({
			'remoteSearchDriver':'libAddMedia/remoteSearchDriver.js'
		}, function(){
			initObj['instance_name']= 'rsdMVRS';
			rsdMVRS = new remoteSearchDriver( initObj );
			rsdMVRS.doInitDisplay();
		});
	});
}
 
/* init the sequencer */
function mv_do_sequence(initObj){
	//debugger;
	//issue a request to get the css file (if not already included):
	if(!styleSheetPresent(mv_embed_path+'skins/'+mv_skin_name+'/mv_sequence.css'))
		loadExternalCss(mv_embed_path+'skins/'+mv_skin_name+'/mv_sequence.css');
	//make sure we have the required mv_embed libs (they are not loaded when no video element is on the page)	
	mvJsLoader.loadBaseLibs(function(){		
		//load playlist object and drag,drop,resize,hoverintent,libs
		mvJsLoader.doLoad({
				'mvPlayList':'libSequencer/mvPlayList.js',
				'$j.ui.sortable':'jquery/jquery.ui-1.5.2/ui/minified/ui.sortable.min.js',
				'$j.ui.resizable':'jquery/jquery.ui-1.5.2/ui/minified/ui.resizable.min.js',
				'$j.contextMenu':'jquery/plugins/jquery.contextMenu.js'
				//'$j.ui'			:'jquery/jquery.ui-1.5.2/ui/minified/ui.core.min.js',
				//'$j.effects':'jquery/jquery.ui-1.5.2/ui/minified/effects.core.min.js',	
				//'$j.effects.slide':'jquery/jquery.ui-1.5.2/ui/minified/effects.slide.min.js'
				//'$j.effects.puff':'jquery/jquery.ui-1.5.2/ui/minified/effects.scale.min.js'
				//'$j.ui.sortable':'jquery/plugins/ui.sortable.js'
			},function(){
				//debugger;
				//load the sequencer
				mvJsLoader.doLoad({
						'mvSequencer':'libSequencer/mvSequencer.js'						
					},function(){					
						js_log('calling new mvSequencer');						
						//init the sequence object (it will take over from there) no more than one mvSeq obj: 
						if(!_global['mvSeq']){
							_global['mvSeq'] = new mvSequencer(initObj);
						}else{
							js_log('mvSeq already init');
						}
					});
		});
	});
}
/*
* utility functions:
*/
//simple url re-writer for standard temporal and size request urls: 
function getURLParamReplace( url, opt ){	
	var pSrc = parseUri( url );	
	if(pSrc.protocol != '' ){
		var new_url = pSrc.protocol +'://'+ pSrc.authority + pSrc.path +'?';       			
	}else{
		var new_url = pSrc.path +'?';      
	}	
	var amp = '';
	for(var key in pSrc.queryKey){
		var val = pSrc.queryKey[ key ];
		//do override if requested 
		if( opt[ key ] )
			val = opt[ key ];
		new_url+= amp + key + '=' + val;					
		amp = '&';    	
	};
	
	return new_url;
}

function seconds2ntp(sec){	
	var sec = parseInt(sec);
	if( isNaN( sec ) ){
		return '0:0:0';
	}		
	var hours = Math.floor(sec/ 3600);
	var minutes = Math.floor((sec/60) % 60);
	var seconds = sec % 60;
	if ( minutes < 10 ) minutes = "0" + minutes;
	if ( seconds < 10 ) seconds = "0" + seconds;
	return hours+":"+minutes+":"+seconds;
}
/* 
 * takes hh:mm:ss,ms or  hh:mm:ss.ms input returns number of seconds 
 */
function ntp2seconds(ntp){
	if(!ntp){		
		//js_log('ntp2seconds:not valid ntp:'+ntp);
		return false;
	}
	times = ntp.split(':');
	if(times.length!=3){		
		js_log('ntp2seconds:not valid ntp:'+ntp);
		return false;
	}
	//sometimes the comma is used inplace of pereid for ms
	times[2] = times[2].replace(/,\s?/,'.');
	//return seconds float (ie take seconds float value if present):
	return parseInt(times[0]*3600)+parseInt(times[1]*60)+parseFloat(times[2]);
}

//addLoadEvent for adding functions to be run when the page DOM is done loading
function mv_addLoadEvent(func) {
	mvLoadEvent.push(func);
}

//does a remote or local api request based on request url 
//@param options: url, data, cbParam, callback
function do_api_req( options, callback ){	
	if(typeof options.data != 'object'){
		js_log('Error: request paramaters must be an object');
		return false;
	}
	if( typeof options.url == 'undefined' ){
		if(!wgServer || ! wgScriptPath){
			js_log('Error: no api url');
			return false;
		}		
		if (wgServer && wgScript)
			options.url = wgServer + wgScript;
		//update to api.php (if index.php was in the wgScript path): 
	 	options.url =  options.url.replace(/index.php/, 'api.php');		
	}			
	if(typeof options.data == 'undefined')
		options.data = {};	
	
	//force format to json (if not already set)  		
	options.data['format'] = 'json';
	
	js_log('do api req: ' + options.url + options.data);			
	//build request string:	 		
	if( parseUri( document.URL ).host == parseUri( options.url ).host ){		
		//local request do api request directly		
		$j.ajax({
			type: "POST",
			url: options.url,
			data: options.data,
			dataType:'json', //api requests _should_ always return JSON data: 
            async: false,
			success:function(data){			
				callback(  data );
			},
			error:function(e){
				js_error( ' error' + e +' in getting: ' + options.url); 
			}
		});
	}else{			
		//set the callback param if not already set: 
		if( typeof options.jsonCB == 'undefined')
			options.jsonCB = 'callback';
						
		var req_url = options.url;		
		var paramAnd = (req_url.indexOf('?')==-1)?'?':'&';		
		//put all the values into the GET req: 	
		for(var i in options.data){
			req_url += paramAnd + encodeURIComponent( i ) + '=' + encodeURIComponent( options.data[i] );		
			paramAnd ='&';
		}
		var fname = 'mycpfn_' + ( global_cb_count++ );
		_global[ fname ]  =  callback;				
		req_url += '&' + options.jsonCB + '=' + fname;								
		loadExternalJs( req_url );				
	}	
}
//do a "normal" request 
function do_request(req_url, callback){		 	
	//if we are doing a request to the same domain or relative link do a normal GET: 
	if( parseUri(document.URL).host == parseUri(req_url).host ||
		req_url == parseUri( req_url).host ){ //relative url
		//do a direct request:
		$j.ajax({
			type: "GET",
			url:req_url,
               async: false,
			success:function(data){		
				callback( data );
			}
		});
	}else{						
		//get data via DOM injection with callback
		global_req_cb.push(callback);
		//prepend json_ to feed_format if not already requesting json format
		if( req_url.indexOf("feed_format=")!=-1 &&  req_url.indexOf("feed_format=json")==-1)
			req_url = req_url.replace(/feed_format=/, 'feed_format=json_');													
		loadExternalJs(req_url+'&cb=mv_jsdata_cb&cb_inx='+(global_req_cb.length-1));			
	}
}

function mv_jsdata_cb(response){
	js_log('f:mv_jsdata_cb:'+ response['cb_inx']);
	//run the callback from the global req cb object:
	if( !global_req_cb[response['cb_inx']] ){
		js_log('missing req cb index');
		return false;
	}
	if( !response['pay_load'] ){
		js_log("missing pay load");
		return false;
	}
	//switch on content type:
	switch(response['content-type']){
		case 'text/plain':
		break;
		case 'text/xml':
			if(typeof response['pay_load'] == 'string'){
				//js_log('load string:'+"\n"+ response['pay_load']);
				//debugger;
				//attempt to parse as xml for IE
				if( embedTypes.msie ){
					var xmldata=new ActiveXObject("Microsoft.XMLDOM");
					xmldata.async="false";
					xmldata.loadXML(response['pay_load']);
				}else{ //for others (firefox, safari etc)	
					try {
    					var xmldata = (new DOMParser()).parseFromString(response['pay_load'], "text/xml");		
    				}catch(e) {
  							js_log('XML parse ERROR: ' + e.message);
  					}  					
				}
				//@@todo hanndle xml parser errors
				if(xmldata)response['pay_load']=xmldata;
			}
		break
		default:
			js_log('bad response type' + response['content-type']);
			return false;
		break;
	}
	global_req_cb[response['cb_inx']]( response['pay_load'] );
}
//load external js via dom injection
function loadExternalJs( url ){
   	js_log('load js: '+ url);
    //if(window['$j']) //use jquery call:    
       /*$j.ajax({
			type: "GET",
			url: url,
			dataType: 'script',
			cache: true
		});*/
  //  else{
    	var e = document.createElement("script");
        e.setAttribute('src', url);
        e.setAttribute('type',"text/javascript");
        //e.setAttribute('defer', true);
        document.getElementsByTagName("head")[0].appendChild(e);
   // }
}

function styleSheetPresent(url){
    style_elements = document.getElementsByTagName('link');
    if( style_elements.length > 0) {
        for(i = 0; i < style_elements.length; i++) {
			if(style_elements[i].href==url)
				return true;
		}
    }
    return false;
}
function loadExternalCss(url){
	if( url.indexOf('?') == -1 ){
		url+='?'+getMvUniqueReqId();
	}
   js_log('load css: ' + url);
   var e = document.createElement("link");
   e.href = url;
   e.type = "text/css";
   e.rel = 'stylesheet';
   document.getElementsByTagName("head")[0].appendChild(e);
}
function usingScriptLoaderCheck(){
	return ( getMvEmbedURL().indexOf('mvwScriptLoader.php') != -1 )?true:false;
	
}
function getMvEmbedURL(){
	js_elements = document.getElementsByTagName("script");
	for(var i=0;i<js_elements.length; i++){		
		//check for normal mv_embed.js and or script loader
		if( js_elements[i].src.indexOf('mv_embed.js') !=-1 ||
			( js_elements[i].src.indexOf('mvwScriptLoader.php')!=-1 && js_elements[i].src.indexOf('mv_embed') != -1) ){
			return  js_elements[i].src;			
		}
	}
	return false;
}
//gets a unique request id to ensure fresh javascript 
function getMvUniqueReqId(){
	var mv_embed_url = getMvEmbedURL();		
	//if in debug mode get a fresh unique request key: 
	if(  parseUri( mv_embed_url ).queryKey['debug'] == 'true'){
		var d = new Date();
		return d.getTime()
	}
	//if we have a uri retun that: 
	var urid = parseUri( mv_embed_url).queryKey['urid']
	if( urid )
		return urid;
	//else just return the mv_embed version;
	return MV_EMBED_VERSION;
}
/*
 * sets the global mv_embed path based on the scripts location
 */
function getMvEmbedPath(){	
	var mv_embed_url = getMvEmbedURL();
	
	if( !mv_embed_url )
		return js_error('error: could not get Mv Embed Path');
		
	if( mv_embed_url.indexOf('mv_embed.js') !== -1 ){
		mv_embed_path = mv_embed_url.substr(0, mv_embed_url.indexOf('mv_embed.js'));
	}else{
		mv_embed_path = mv_embed_url.substr(0, mv_embed_url.indexOf('mvwScriptLoader.php'));
	}
	//absolute the url (if relative) (if we don't have mv_embed path)
	if( mv_embed_path.indexOf('://') == -1){	
		var pURL = parseUri( document.URL );		
		if(mv_embed_path.charAt(0)=='/'){
			mv_embed_path = pURL.protocol + '://' + pURL.authority + mv_embed_path;
		}else{
			//relative:
			if(mv_embed_path==''){
				mv_embed_path = pURL.protocol + '://' + pURL.authority + pURL.directory + mv_embed_path;
			}
		}		
	}
	return mv_embed_path;
}
if (typeof DOMParser == "undefined") {
   DOMParser = function () {}
   DOMParser.prototype.parseFromString = function (str, contentType) {
      if (typeof ActiveXObject != "undefined") {
         var d = new ActiveXObject("MSXML.DomDocument");
         d.loadXML(str);
         return d;
      } else if (typeof XMLHttpRequest != "undefined") {
         var req = new XMLHttpRequest;
         req.open("GET", "data:" + (contentType || "application/xml") +
                         ";charset=utf-8," + encodeURIComponent(str), false);
         if (req.overrideMimeType) {
            req.overrideMimeType(contentType);
         }
         req.send(null);
         return req.responseXML;
      }
   }
}
/*
* utility functions:
*/
function js_log(string){
  if( window.console ){
       window.console.log(string);        
  }else{
     /*
      * IE and non-firebug debug:
      */
    /* var log_elm = document.getElementById('mv_js_log');
     if(!log_elm){
     	document.write('<div style="position:absolute;z-index:500;top:0px;left:0px;right:0px;height:10px;"><textarea id="mv_js_log" cols="120" rows="5"></textarea></div>');
     	var log_elm = document.getElementById('mv_js_log');
     }
     if(log_elm){
     	log_elm.value+=string+"\n";
     }*/
  }
  //return false;
}

function js_error(string){
	alert(string);
	return false;
}

