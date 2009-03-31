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

//used to grab fresh copies of scripts. (should be changed on every deployable commit)  
var MV_EMBED_VERSION = '1.0rc3';

//the name of the player skin (default is mvpcf)
var mv_skin_name = 'mvpcf';

//whether or not to load java from an iframe.
//note: this is necessary for remote embedding because of java security model)
var mv_java_iframe = true;

//media_server mv_embed_path (the path on media servers to mv_embed for java iframe with leading and trailing slashes)
var mv_media_iframe_path = '/mv_embed/';

//the default height/width of the video (if no style or width attribute provided)
var mv_default_video_size = '400x300'; 

//this restricts playable sources to ROE xml media without start end time attribute
var mv_restrict_roe_time_source = true;

var global_player_list = new Array();
var global_req_cb = new Array();//the global request callback array
var _global = this;
var mv_init_done=false;
var global_cb_count =0;

/*
 * its best if you just require all your external data sources to serve up json data.
 * or
 * have a limited set of domains that you accept data from
 * enabling mv_proxy is not such a good idea from security standpoint but if you know what your doing 
 * you can enable it here (also you have to un comment mv_data_proxy die(); line)  
*/  
var MV_ENABLE_DATA_PROXY=false;

/*parseUri class:*/
var parseUri=function(d){var o=parseUri.options,value=o.parser[o.strictMode?"strict":"loose"].exec(d);for(var i=0,uri={};i<14;i++){uri[o.key[i]]=value[i]||""}uri[o.q.name]={};uri[o.key[12]].replace(o.q.parser,function(a,b,c){if(b)uri[o.q.name][b]=c});return uri};parseUri.options={strictMode:false,key:["source","protocol","authority","userInfo","user","password","host","port","relative","path","directory","file","query","anchor"],q:{name:"queryKey",parser:/(?:^|&)([^&=]*)=?([^&]*)/g},parser:{strict:/^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,loose:/^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/)?((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/}};

//get mv_embed location if it has not been set
if( !mv_embed_path ){
	var mv_embed_path =getMvEmbedPath();
}
//set the unique request id (for ensuring fresh copies of scripts on udpates) 
if( !mv_embed_urid ){
	var mv_embed_urid = getMvUniqueReqId();
}

//the default thumbnail for missing images:
var mv_default_thumb_url = mv_embed_path + 'images/vid_default_thumb.jpg';

if(!gMsg){var gMsg={};}
//all default msg in [English] should be overwritten by the CMS language msg system.
gMsg['loading_txt'] = 'loading <blink>...</blink>';
gMsg['loading_plugin'] = 'loading plugin<blink>...</blink>';
gMsg['select_playback'] = 'Set Playback Preference';
gMsg['link_back'] = 'Link Back';
gMsg['error_load_lib'] = 'mv_embed: Unable to load required javascript libraries\n'+
			 	'insert script via DOM has failed, try reloading?  ';
			 	
gMsg['error_swap_vid'] = 'Error:mv_embed was unable to swap the video tag for the mv_embed interface';

gMsg['download_segment'] = 'Download Selection:';
gMsg['download_full'] = 'Download Full Video File:'
gMsg['download_clip'] = 'Download the Clip';
gMsg['download_text'] = 'Download Text (<a style="color:white" title="cmml" href="http://wiki.xiph.org/index.php/CMML">cmml</a> xml):';

gMsg['clip_linkback'] = 'Clip Source Page';
//plugin names:
gMsg['ogg-player-vlc-mozilla'] = 'VLC Plugin';
gMsg['ogg-player-videoElement'] = 'Native Ogg Video Support';
gMsg['ogg-player-vlc-activex'] = 'VLC ActiveX';
gMsg['ogg-player-oggPlay'] = 'Annodex OggPlay Plugin';
gMsg['ogg-player-oggPlugin'] = 'Generic Ogg Plugin';
gMsg['ogg-player-quicktime-mozilla'] = 'Quicktime Plugin';
gMsg['ogg-player-quicktime-activex'] = 'Quicktime ActiveX';
gMsg['ogg-player-cortado'] = 'Java Cortado';
gMsg['ogg-player-flowplayer'] = 'Flowplayer';
gMsg['ogg-player-selected'] = ' (selected)';
gMsg['generic_missing_plugin'] = 'You browser does not appear to support playback type: <b>$1</b><br>' +
		'visit the <a href="http://metavid.org/wiki/Client_Playback">Playback Methods</a> page to download a player<br>';
		
gMsg['add_to_end_of_sequence'] = 'Add to End of Sequence';

gMsg['missing_video_stream'] = 'The video file for this stream is missing';

gMsg['select_transcript_set'] = 'Select Text Layers';
gMsg['auto_scroll'] = 'auto scroll';
gMsg['close'] = 'close';
gMsg['improve_transcript'] = 'Improve Transcript';

gMsg['next_clip_msg'] = 'Play Next Clip';
gMsg['prev_clip_msg'] = 'Play Previous Clip';
gMsg['current_clip_msg'] = 'Continue Playing this Clip';

gMsg['seek_to'] = 'Seek to';

//grabs from the globalMsg obj
//@@todo integrate msg serving into CMS
function getMsg( key , args ) {
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

/*  the base video control JSON object with default attributes
*    for supported attribute details see README
*/
var default_video_attributes = {
    "id":null,
    "class":null,
    "style":null,
    "name":null,
    "innerHTML":null,
    "width":"320",
    "height":"240",

    //video attributes:
    "src":null,
    "autoplay":false,
    "start":0,
    "end":null,
    "controls":true,
	"muted":false,
	
    //roe url (for xml based metadata)
    "roe":null,
    //if roe includes metadata tracks we can expose a link to metadata
	"show_meta_link":true,

	//default state attributes per html5 spec:
	//http://www.whatwg.org/specs/web-apps/current-work/#video)
	"paused":true,
	"readyState":0,  //http://www.whatwg.org/specs/web-apps/current-work/#readystate
	"currentTime":0, //current playback position (should be updated by plugin)
	"duration":null,   //media duration (read from file or the temporal url)

    //custom attributes for mv_embed:
    "play_button":true,    
    "thumbnail":null,
    "linkback":null,
    "embed_link":true,
    "download_link":true,
    "type":null 	//the content type of the media 
};

/*********** INITIALIZATION CODE *************
 * the mvEmbed object drives basic loading of libs
 * its load_libs function will be called during initialization
 *********************************************/
var mvEmbed = {
  Version: MV_EMBED_VERSION,
  loaded:false,
  load_time:0,
  flist:Array(),
  load_callback:false,
  loading:false,
  libs_loaded:false,
  //plugin libs var names and paths:
  lib_jquery:{'window.jQuery':'jquery/jquery-1.2.6.js'},
  lib_plugins:{  	
	'$j.ui.mouse'	 	:'jquery/jquery.ui-1.5.2/ui/minified/ui.core.min.js', //load the core ui
	'$j.secureEvalJSON'	:'jquery/plugins/jquery.json-1.3.min.js' //load json lib for *more* trusted JSON evals	
  },
  // not used: 
  //'$j.timer.global':'jquery/plugins/jquery.timers.js',
  lib_controlui:{
  	'$j.ui.droppable':'jquery/jquery.ui-1.5.2/ui/minified/ui.droppable.min.js',
	'$j.ui.draggable':'jquery/jquery.ui-1.5.2/ui/minified/ui.draggable.min.js'		
  },
  /* @@todo move to single packaged jquery ui library:   
	, //include draggable
	'$j.ui.resizable':'jquery/jquery.ui-1.5.2/ui/minified/ui.resizable.min.js'
	'$j.ui.progressbar':'jquery/jquery-ui-personalized-1.6rc1.debug.js'	
   */
  pc:null, //used to store pointer to parent clip (when in playlist mode)
  load_libs:function( callback , target_id){
  	//js_log('f:load_libs: '+callback);
  	if( callback )this.load_callback = callback;
  	
  	//if libs are already loaded jump directly to the callback
  	if(this.libs_loaded){
  		mvEmbed.init( target_id );
  		return true;
  	}  
 	//two loading stages, first get jQuery
	var _this = this;
  	mvJsLoader.doLoad(this.lib_jquery,function(){
  		js_log("type of " + typeof window.jQuery);
  		//once jQuery is loaded set up no conflict & load plugins:
 		_global['$j'] = jQuery.noConflict();
 		//set up ajax to not send dynamic urls for loading scripts
 		$j.ajaxSetup({		  
		  cache: true
		});
 		js_log('jquery loaded'); 		 		
		mvJsLoader.doLoad(_this.lib_plugins, function(){
			//load control ui after ui.core loaded
			mvJsLoader.doLoad(_this.lib_controlui, function(){
				js_log('plugins loaded');
				mvEmbed.libs_loaded=true;
				mvEmbed.init();
			});
		});
  	});
  },  
  addLoadEvent:function(fn){
  	this.flist.push(fn);
  },
  init: function( target_id ){
    //load mv_embed skin stylesheet: 
  	if(!styleSheetPresent(mv_embed_path+'skins/'+mv_skin_name+'/styles.css'))
		loadExternalCss(mv_embed_path+'skins/'+mv_skin_name+'/styles.css');
  	
	mv_embed( target_id );	
	
	this.check_init_done();	
  },
  /*
   * should be cleaned up ... the embedType loading should be part of load_libs above:
   */
  check_init_done:function(){  	  	
  	//check if all videos are "ready to play"
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
    //js_log('f:check_init_done '+ is_ready + ' ' + cur_vid.load_error + ' rtp: '+ cur_vid.ready_to_play);
  	if( !is_ready ){
  		//js_log('some ' + global_player_list + ' not ready');
  		setTimeout( 'mvEmbed.check_init_done()', 50 );
  	}else{
		//call the callback:
		if(typeof this.load_callback == 'function')
			if(this.load_callback)this.load_callback();		
		
		//js_log('run queue functions:' + mvEmbed.flist);
		while (mvEmbed.flist.length){
			mvEmbed.flist.shift()();
		}  	
  	}
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
        return getMsg('ogg-player-' + this.id);
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
			//js_log('DO LOAD: '+this.library); 
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
/* this is too verbose, 
* and we should not have to redefine it below with default_players
* should just be a single object
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
        
        this.default_players['video/ogg'] = ['native','vlc','java'];        
        this.default_players['application/ogg'] = ['native','vlc','java'];
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
                js_log('load preference for ' + name_value[0] + ' is ' + name_value[1]);
            }
        }
    },
    savePreferences : function()
    {
        var cookieVal = '';
        for(var i=0; i < this.preference.length;i++)
            cookieVal+= i + '='+ this.preference[i] + '&';
            
        cookieVal=cookieVal.substr(0, cookieVal.length-1);
        js_log('setting preference cookie to ' + cookieVal);
		var week = 7*86400*1000;
		setCookie( 'ogg_player_exp', cookieVal, week, false, false, false, false );
    }
};

var getCookie = function ( cookieName ) {
		 var m = document.cookie.match( cookieName + '=(.*?)(;|$)' );
		 js_log('getCookie:' + (m ? unescape( m[1] ) : false));
		 return m ? unescape( m[1] ) : false;
}

function setCookie(name, value, expiry, path, domain, secure) {
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
 * controlsBuilder:
 * 
 */
var ctrlBuilder = {
	height:29,
	supports:{
  		'options':true,     			
  		'borders':true   			
   	},
	getControls:function(embedObj){	
		js_log('f:controlsBuilder');		
    	this.id = (embedObj.pc)?embedObj.pc.pp.id:embedObj.id;
    	this.avaliable_width=embedObj.playerPixelWidth();
    	//make pointer to the embedObj
    	this.embedObj =embedObj;
    	var _this = this;    	
    	$j.each( embedObj.supports, function( i, sup ){
    		_this.supports[i] = embedObj.supports[i];
    	});
    		    	
    	//special case vars: 
    	if( ( embedObj.roe || embedObj.media_element.timedTextSources() )  
    			&& embedObj.show_meta_link  )
    		this.supports['closed_captions']=true;   
    	
    		
    	//append options to body (if not already there)
		if($j('#mv_embedded_options_'+ctrlBuilder.id).length==0)
			$j('body').append( this.components['mv_embedded_options'].o() );		
		    		
    	var o='';    
    	for( var i in this.components ){
    		if( this.supports[i] ){
    			if( this.avaliable_width > this.components[i].w ){
    				//special case with playhead don't add unless we have 60px
	    			if( i=='play_head' && ctrlBuilder.avaliable_width < 60 )
	    				continue;	    				
    				o+=this.components[i].o();
    				this.avaliable_width -= this.components[i].w;
    			}else{
    				js_log('not enough space for control component:'+i);
    			}
    		}
    	}
    	return o;
	},
	 /*
     * addControlHooks
     * to be run once controls are attached to the dom
     */
    addControlHooks:function(embedObj){        	    	    	    
    	//add in drag/seek hooks: 
		if(!embedObj.base_seeker_slider_offset &&  $j('#mv_seeker_slider_'+embedObj.id).get(0))
        	embedObj.base_seeker_slider_offset = $j('#mv_seeker_slider_'+embedObj.id).get(0).offsetLeft;              
        
        //js_log('looking for: #mv_seeker_slider_'+embedObj.id + "\n " +
		//		'start sec: '+embedObj.start_time_sec + ' base offset: '+embedObj.base_seeker_slider_offset);
        
        //add play hook: 
        $j('#mv_play_pause_button_' + embedObj.id).unbind( "click" ).click(function(){
        	$j('#' + embedObj.id).get(0).play();
        });        
        
        //big_play_link_ play binding: 
		$j('#big_play_link_' + embedObj.id).unbind('click').click(function(){
			$j('#' + embedObj.id).get(0).play();
		});
        
        //build draggable hook here:        
	    $j('#mv_seeker_slider_'+embedObj.id).draggable({
        	containment:'#seeker_bar_'+embedObj.id,
        	axis:'x',
        	opacity:.6,
        	start:function(e, ui){
        		var id = (embedObj.pc!=null)?embedObj.pc.pp.id:embedObj.id;
        		embedObj.userSlide=true;
        		js_log("started dragging set userSlide"+embedObj.userSlide)
        		var options = ui.options;      
        		//remove "play button"   	
        		$j('#big_play_link_'+id).fadeOut('fast');
        		 //if playlist always start at 0
		        embedObj.start_time_sec = (embedObj.instanceOf == 'mvPlayList')?0:
        						ntp2seconds(embedObj.getTimeReq().split('/')[0]);       
        	},
        	drag:function(e, ui){
        		//@@todo get the -14 number from the skin somehow
        		var perc = (($j('#mv_seeker_slider_'+embedObj.id).get(0).offsetLeft-embedObj.base_seeker_slider_offset)
						/
					($j('#mv_seeker_'+embedObj.id).width()-14));   															
									 													
				embedObj.jump_time = seconds2ntp(parseInt(embedObj.getDuration()*perc)+ embedObj.start_time_sec);	
				//js_log('perc:' + perc + ' * ' + embedObj.getDuration() + ' jt:'+  this.jump_time);
				embedObj.setStatus( getMsg('seek_to')+' '+embedObj.jump_time );    
				//update the thumbnail / frame 
				embedObj.updateThumbPerc( perc );					
        	},
        	stop:function(e, ui){
        		embedObj.userSlide=false;
        		var perc = (($j('#mv_seeker_slider_'+embedObj.id).get(0).offsetLeft-embedObj.base_seeker_slider_offset)
						/
					($j('#mv_seeker_'+embedObj.id).width()-14));   
        		js_log('do jump to: '+embedObj.jump_time + ' perc:' +perc);
        		
        		//set seek time (in case we have to do a url seek)        		
        		embedObj.seek_time_sec=ntp2seconds(embedObj.jump_time);   
        		var test = embedObj;        		
        		embedObj.doSeek(perc);
        	}
        });
    },
	components:{
		'borders':{
			'w':8,
			'o':function(){
				return	'<span class="border_left">&nbsp;</span>'+
						'<span class="border_right">&nbsp;</span>';
			}
		},
		'fullscreen':{
			'w':20,
			'o':function(){
				return '<div class="fullscreen"><a href="javascript:$j(\'#'+ctrlBuilder.id+'\').get(0).fullscreen();"></a></div>'
			}
		},
		'options':{
			'w':26,
			'o':function(){
				return '<div id="options_button_'+ctrlBuilder.id+'" class="options"><a href="javascript:$j(\'#'+ctrlBuilder.id+'\').get(0).doOptionsHTML();"></a></div>';			 			
			}
		},
		'mv_embedded_options':{
			'w':0,
			'o':function(){
				return '<div id="mv_embedded_options_'+ctrlBuilder.id+'" class="videoOptions">'
+'				<div class="videoOptionsTop"></div>'
+'				<div class="videoOptionsBox">'
+'					<div class="block">'
+'						<h6>Video Options</h6>'
+'					</div>'
+'					<div class="block">'
+'						<p class="short_match"><a href="javascript:$j(\'#'+ctrlBuilder.id+'\').get(0).selectPlaybackMethod();" onClick="$j(\'#mv_embedded_options_'+ctrlBuilder.id+'\').hide();"><span><strong>Stream Selection</strong></span></a></p>'
+'						<p class="short_match"><a href="javascript:$j(\'#'+ctrlBuilder.id+'\').get(0).showVideoDownload();" onClick="$j(\'#mv_embedded_options_'+ctrlBuilder.id+'\').hide();" ><span><strong>Download</strong></span></a></p>'
+'						<p class="short_match"><a href="javascript:$j(\'#'+ctrlBuilder.id+'\').get(0).showEmbedCode();" onClick="$j(\'#mv_embedded_options_'+ctrlBuilder.id+'\').hide();" ><span><strong>Share or Embed</strong></span></a></p>'
+'					</div>'
+'				</div><!--videoOptionsInner-->'
+'				<div class="videoOptionsBot"></div>'
+'			</div><!--videoOptions-->';
			}
		},
		'pause':{
			'w':24,
			'o':function(){
				return '<div id="mv_play_pause_button_' + ctrlBuilder.id + '" class="play_button"></div>';
			}
		},
		'closed_captions':{
			'w':40,
			'o':function(){
				return '<div class="closed_captions"><a href="javascript:$j(\'#'+ctrlBuilder.id+'\').get(0).showTextInterface();"></a></div>'
			}			
		},
		'volume_control':{
			'w':22,
			'o':function(){
				return '<div id="volume_icon_'+ctrlBuilder.id+'" class="volume_icon volume_on"><a href="javascript:$j(\'#'+ctrlBuilder.id+'\').get(0).toggleMute();"></a></div>'
			}
		},
		'time_display':{
			'w':80,
			'o':function(){
				return '<div id="mv_time_'+ctrlBuilder.id+'" class="time">'+ctrlBuilder.embedObj.getTimeReq()+'</div>'
			}
		},
		'play_head':{
			'w':0, //special case (takes up remaning space) 
			'o':function(){
				return '<div class="seeker" id="mv_seeker_'+ctrlBuilder.id+'" style="width: ' + (ctrlBuilder.avaliable_width - 18) + 'px;">'+           
                    '		<div id="seeker_bar_'+ctrlBuilder.id+'" class="seeker_bar">'+
                    '			<div class="seeker_bar_outer"></div>'+
                    '			<div id="mv_seeker_slider_'+ctrlBuilder.id+'" class="seeker_slider"></div>'+
                    '			<div class="mv_progress mv_playback"></div>'+
                    '			<div class="mv_progress mv_buffer"></div>'+
                    '			<div class="mv_progress mv_highlight"></div>'+
                    '			<div class="seeker_bar_close"></div>'+
                    '		</div>'+            
                    '	</div><!--seeker-->'
			}
		}	    	                            
	}    
}

js_log("mv embed path:"+ mv_embed_path);
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
		
		 // <video> element (should not need to be attached to the dom to test)(
		 var v = document.createElement("video");
		 if( v.play )
		 	this.players.addPlayer( videoElementPlayer );
		
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
var mvJsLoader = {
	 libreq:{},
	 libs:{},
	 //to keep consistency across threads: 
	 ptime:0,
	 ctime:0,	 
	 load_error:false,//load error flag (false by default)
	 
	 load_time:0,
	 callbacks:new Array(),
	 doLoad:function(libs,callback){	
	 	 this.ctime++;
	 	 //js_log('doLoad: '+this.ctime);
	 	 //stack callbacks	
	 	 if(callback){ 
	 	 	this.callbacks.push(callback);
	 	 }				 	 		
		 //merge any new requested libs
		 if(libs){
		 	for(var i in libs){ //for in loop oky on object
		 		//js_log('add lib: '+i + ' = ' + libs[i]);
		 		this.libs[i]=libs[i];
		 	}
		 }		 		 
		 var loading=0;
		 var i=null;
		 for(var i in this.libs){ //for in loop oky on object
		 	 //if(i=='vlcEmbed')alert('got called with '+i+' ' + typeof(vlcEmbed));
			 //itor the objPath (to avoid 'has no properties' errors)
			 var objPath = i.split('.');
			 var cur_path ='';
			 var cur_load=0;
			 for(var p=0; p < objPath.length; p++){
				 cur_path = (cur_path=='')?cur_path+objPath[p]:cur_path+'.'+objPath[p];				 
				 if(eval('typeof '+cur_path)=='undefined'){
					 cur_load = loading=1;
					 //js_log("cur_load = loading=1");
					 break;
				 }
				 //if we have made the full comparison break out:
				 if(cur_path==i){
				 	break;
				 }
		 	 }
			 if(cur_load==1){				 
				 if(!this.libreq[i])loadExternalJs(mv_embed_path + this.libs[i]);
				 this.libreq[i]=1;
			 }
		 }
		 if(loading){
			 if( this.load_time++ > 2000){ //time out after ~50seconds
			 	js_error( getMsg('error_load_lib') +  cur_path);
			 	this.load_error=true;			 	
			 }else{
				setTimeout('mvJsLoader.doLoad()',25);
			 }
		 }else{
		 	//only do callback if we are in the same range: 		 	
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
		 			setTimeout('mvJsLoader.doLoad()',25);
		 			break;
		 		}
		 	}		 	
		 }
		 this.ptime=this.ctime;
	 }
}

/*********** INITIALIZATION CODE *************
 * this will get called when DOM is ready
 *********************************************/
/* jQuery .ready does not work when jQuery is loaded dynamically
 * for an example of the problem see:1.1.3 working:http://pastie.caboo.se/92588
 * and >= 1.1.4 not working: http://pastie.caboo.se/92595
 * $j(document).ready( function(){ */
function init_mv_embed(force){
	js_log('f:init_mv_embed');
	if(!force && mv_init_done  ){
		js_log("mv_init_done do nothing...");
		return false;
	}

	mv_init_done=true;	
	//check if this page does have video or playlist
	if(document.getElementsByTagName("video").length!=0 ||
	   document.getElementsByTagName("playlist").length!=0){
		js_log('we have vids to process');		
		//load libaries		    		
		mvEmbed.load_libs();		
	}else{
		js_log('no video or playlist on the page... (done)');
		//run any queued functions:
		while (mvEmbed.flist.length){
			mvEmbed.flist.shift()();
		}
	}
}

/*
 * this function allows for targeted rewriting 
 */
function rewrite_by_id( vid_id, ready_callback ){
	js_log('f:rewrite_by_id: ' + vid_id);	
	//force a recheck of the dom for playlist or video element: 	
	mvEmbed.load_libs( ready_callback, vid_id );
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
function mv_embed( force_id ){
	//get mv_embed location if it has not been set
	js_log('mv_embed ' + mvEmbed.Version);
	
	var loadPlaylistLib=false;
	//set up the jQuery selector: 
	var j_selector = 'video,playlist';
	if( force_id !=null )
		var j_selector = '#'+force_id;
	
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
            	getMsg('loading_txt')+'</div>' );
        */ 
        
        //if video doSwap
        if( this.tagName.toLowerCase() == 'video'){
        	var videoInterface = new embedVideo(this);	 
			swapEmbedVideoElement( this, videoInterface );
        }else{
        	js_log( this.tagName.toLowerCase()+ ' != video' );
        }        
        //if playlist set do load playlist
        if( this.tagName.toLowerCase() == 'playlist' )
        	loadPlaylistLib=true; 
	});	
	if(loadPlaylistLib){
		js_log('f:load Playlist Lib:');
		mvJsLoader.doLoad({'mvPlayList':'libSequencer/mv_playlist.js'},function(){
			$j('playlist').each(function(){		
				//check if we are in sequence mode load sequence libs (if not already loaded)				 				
				if( $j(this).attr('sequencer')=="true" ){
					var pl_element = this;
					//load the mv_sequencer and the json util lib:
					mvJsLoader.doLoad({
							'mvSeqPlayList':'libSequencer/mv_sequencer.js'							
						},function(){
							var seqObj = new mvSeqPlayList( pl_element );
							swapEmbedVideoElement( pl_element, seqObj );								
						}
					); 
				}else{					
					//create new playlist interface:
					var plObj = new mvPlayList( this );		
					swapEmbedVideoElement(this, plObj);
					var added_height = plObj.pl_layout.title_bar_height + plObj.pl_layout.control_height;		
					//move into a blocking display container with height + controls + title height: 
					$j('#'+plObj.id).wrap('<div style="display:block;height:' + (plObj.height + added_height) + 'px;"></div>');	
				}											
			});
		});
	}		
}

/* init remote search */
function mv_do_remote_search(initObj){
	js_log(':::::mv_do_remote_search::::');
	//insure we have the basic libs (jquery etc) : 
	mvEmbed.load_libs(function(){
		//load search specifc extra stuff 
		mvJsLoader.doLoad({
			'mvBaseRemoteSearch':'libRemoteMediaSearch/mv_remote_media_search.js'
		}, function(){
			initObj['instance_name']= 'rsdMVRS';
			rsdMVRS = new remoteSearchDriver( initObj );
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
	mvEmbed.load_libs(function(){		
		//load playlist object and drag,drop,resize,hoverintent,libs
		mvJsLoader.doLoad({
				'mvPlayList':'libSequencer/mv_playlist.js',
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
						'mvSequencer':'libSequencer/mv_sequencer.js'						
					},function(){												
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
* swapEmbedVideoElement
* takes a video element as input and swaps it out with
* an embed video interface based on the video_elements attributes
*/
function swapEmbedVideoElement(video_element, videoInterface){
	js_log('do swap ' + videoInterface.id + ' for ' + video_element);
	embed_video = document.createElement('div');
	//make sure our div has a hight/width set:
		
	$j(embed_video).css({'width':videoInterface.width,'height':videoInterface.height});
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
}

/**
  * mediaSource class represents a source for a media element.
  * @param {String} type MIME type of the source.
  * @param {String} uri URI of the source.
  * @constructor
  */
function mediaSource(element)
{
    this.init(element);
}

var mv_default_source_attr= new Array(
	'id',
	'src',
	'title',
	'timeFormat',
	'start',
	'end',	
	'default',
	'lang'
);
mediaSource.prototype =
{
    /** MIME type of the source. */
    mime_type:null,
    /** URI of the source. */
    uri:null,
    /** Title of the source. */
    title:null,
    /** True if the source has been marked as the default. */
    marked_default:null,
	/** True if the source supports url specification of offset and duration */
	supports_url_time_encoding:null,
    /** Start offset of the requested segment */
    start_offset:null,
    /** Duration of the requested segment (NaN if not known) */
    duration:NaN,
    is_playable:null,
    upddate_interval:null,

    id:null,
    start_ntp:null,
    end_ntp:null,

    init : function(element)
    {
    	//js_log('adding mediaSource: ' + element);    	    	
        this.src = $j(element).attr('src');
        this.marked_default = false;
        if ( element.tagName.toLowerCase() == 'video')
            this.marked_default = true;        
        
        //set default timeFormat if we have a time  url:
        //not ideal way to discover if content is on an oggz_chop server. 
        //should check some other way. 
        var pUrl = parseUri ( this.src );
        if(typeof pUrl['queryKey']['t'] != 'undefined'){
        	this['timeFormat']='anx';
        }        
                    
        for(var i=0; i < mv_default_source_attr.length; i++){ //for in loop oky on object
        	var attr = mv_default_source_attr[ i ];
        	if( $j(element).attr( attr ) ) {
        		this[ attr ] =  $j(element).attr( attr );
        	}
        }
        
        
        if ( $j(element).attr('type'))
            this.mime_type = $j(element).attr('type');
        else if ($j(element).attr('content-type'))
            this.mime_type = $j(element).attr('content-type');
        else        	
            this.mime_type = this.detectType(this.src);
		
		//set the title if unset:
        if( !this.title )
            this.title = this.mime_type;

        this.parseURLDuration();
    },
    updateSource:function(element){
    	//for now just update the title: 
    	if ($j(element).attr("title"))
        	this.title = $j(element).attr("title");    	
    },
    /** updates the src time and start & end
     *  @param {String} start_time in NTP format
     *  @param {String} end_time in NTP format
     */
    updateSrcTime:function (start_ntp, end_ntp){
    	//js_log("f:updateSrcTime: "+ start_ntp+'/'+ end_ntp + ' from org: ' + this.start_ntp+ '/'+this.end_ntp);
    	//js_log("pre uri:" + this.src);
    	//if we have time we can use:
    	if( this.supports_url_time_encoding ){
    		//make sure its a valid start time / end time (else set default) 
    		if( !ntp2seconds(start_ntp) ) 
    			start_ntp = this.start_ntp;
    			
    		if( !ntp2seconds(end_ntp) )
    			end_ntp = this.end_ntp;
    			
    		if( this.timeFormat == 'anx' ){
    			this.src = getUpdateTimeURL(this.src, start_ntp +'/'+end_ntp);
    		}else if ( this.timeFormat =='mp4'){
    			var mp4URL =  parseUri( this.src );
	    		this.src =  mp4URL.protocol+'://'+mp4URL.authority + mp4URL.path + 
	    					'?start=' + ( ntp2seconds( start_ntp ) ) +
	    					'&end=' + ( ntp2seconds( end_ntp ) );
    		}	
    		
	        //update the duration
			this.parseURLDuration();
    	}    	
    	//this.setDuration( )
	  	//js_log("post uri:" + this.src);
    },
	setDuration:function (duration)
	{
		this.duration = duration;
		this.end_ntp = seconds2ntp(this.start_offset + duration);
	},
    /** MIME type accessor function.
        @return the MIME type of the source.
        @type String
    */
    getMIMEType : function()
    {
        return this.mime_type;
    },
    /** URI accessor function.
     * 	@param int seek_time_sec (used to adjust the URI for players that can't do local seeks well on given media types) 
        @return the URI of the source.
        @type String
    */
    getURI : function(seek_time_sec)
    {    	
    	js_log("f:getURI: tf:" + this.timeFormat +' uri_enc:'+this.supports_url_time_encoding);
    	if( !seek_time_sec || !this.supports_url_time_encoding ){    		
       		return this.src;       		       	
    	}
       	if( this.timeFormat == 'anx' ){
       		var new_url = getUpdateTimeURL(this.src,  seconds2ntp(seek_time_sec)+'/'+ this.end_ntp);
       	}else if(this.timeFormat=='mp4'){
       		var mp4URL =  parseUri( this.src );
	    	var new_url = mp4URL.protocol+'://'+mp4URL.authority + mp4URL.path + '?start='
	    					 + ( seek_time_sec + parseInt(mp4URL.queryKey['start']) );       		
       	}
       	//js_log('getURI seek url:'+ new_url);
       	return new_url;
    },
    /** Title accessor function.
        @return the title of the source.
        @type String
    */
    getTitle : function()
    {
        return this.title;
    },
    /** Index accessor function.
        @return the source's index within the enclosing mediaElement container.
        @type Integer
    */
    getIndex : function()
    {
        return this.index;
    },
    /*
	 * function getDuration in milliseconds
     * special case derive duration from request url
	 * supports media_url?t=ntp_start/ntp_end url request format
     */
    parseURLDuration : function(){              
        //check if we have a timeFormat: 
        if( this.timeFormat ){
	        if( this.timeFormat == 'anx' ){
	        	var annoURL = parseUri( this.src );
	        	if( annoURL.queryKey['t'] ){
		    		var times = annoURL.queryKey['t'].split('/');
		    		this.start_ntp = times[0];
				    this.end_ntp = times[1];
				}
	    	}
	    	if( this.timeFormat == 'mp4' ){
	    		var mp4URL =  parseUri( this.src );	    		
	    		if( typeof mp4URL.queryKey['start'] != 'undefined' )    		 	
	    			this.start_ntp = seconds2ntp( mp4URL.queryKey['start'] );
	    
	    		if( typeof mp4URL.queryKey['end'] != 'undefined' ){
	    			this.end_ntp = seconds2ntp( mp4URL.queryKey['end'] );
	    			
	    			//strip the &end param here (as per the mp4 format request (should fix server side)  
	    			this.src = mp4URL.protocol+'://'+mp4URL.authority + mp4URL.path + '?start=' + mp4URL.queryKey['start'];
	    		}	    			    			    		  	    		
	    	}
	    	this.supports_url_time_encoding = true;
	    	this.start_offset = ntp2seconds(this.start_ntp);
	    	this.duration = ntp2seconds( this.end_ntp ) - this.start_offset;
    	} //time format	   		
    	
        if( !this.supports_url_time_encoding ){ 
	     	//else normal media request (can't predict the duration without the plugin reading it)
	     	this.duration = null;
	   	 	this.start_offset = 0;
			this.start_ntp = seconds2ntp(this.start_offset);			
        }
        //js_log('f:parseURLDuration() for:' + this.src  + ' d:' + this.duration);
	},
    /** Attempts to detect the type of a media file based on the URI.
        @param {String} uri URI of the media file.
        @returns The guessed MIME type of the file.
        @type String
    */
    detectType:function(uri)
    {
    	//@@todo if media is on the same server as the javascript or we have mv_proxy configured
    	//we can issue a HEAD request and read the mime type of the media...
    	// (this will detect media mime type independently of the url name)
    	//http://www.jibbering.com/2002/4/httprequest.html (this should be done by extending jquery's ajax objects)
    	var end_inx =  (uri.indexOf('?')!=-1)? uri.indexOf('?') : uri.length;
    	var no_param_uri = uri.substr(0, end_inx);
        switch( no_param_uri.substr(no_param_uri.lastIndexOf('.'),4) ){
        	case '.flv':return 'video/x-flv';break;
        	case '.ogg':return 'video/ogg';break;
        	case '.anx':return 'video/ogg';break;
	    }
    }
};

/** A media element corresponding to a <video> element.
    It is implemented as a collection of mediaSource objects.  The media sources
    will be initialized from the <video> element, its child <source> elements,
    and/or the ROE file referenced by the <video> element.
    @param {element} video_element <video> element used for initialization.
    @constructor
*/
function mediaElement(video_element)
{
    this.init(video_element);
};

mediaElement.prototype =
{
    /** The array of mediaSource elements. */
    sources:null,    
    addedROEData:false,    
    /** Selected mediaSource element. */
    selected_source:null,
    thumbnail:null,
    linkback:null,    

    /** @private */
    init:function( video_element )
    {
        var _this = this;
        js_log('Initializing mediaElement...' + video_element);
        this.sources = new Array();
        this.thumbnail = mv_default_thumb_url;
        // Process the <video> element
        if($j(video_element).attr("src"))
        	this.tryAddSource(video_element);        	  
        
        if($j(video_element).attr('thumbnail'))
            this.thumbnail=$j(video_element).attr('thumbnail');
            
        if($j(video_element).attr('poster'))
            this.thumbnail=$j(video_element).attr('poster');
            
        // Process all inner <source> elements    
        //js_log("inner source count: " + video_element.getElementsByTagName('source').length );
        
        $j(video_element).children('source,text').each(function(inx, inner_source){        	
        	_this.tryAddSource( inner_source );
        });                          
    },
    /** Updates the time request for all sources that have a standard time request argument (ie &t=start_time/end_time)
     */
    updateSourceTimes:function(start_ntp, end_ntp){
    	var _this = this;
    	$j.each(this.sources, function(inx, mediaSource){
    		mediaSource.updateSrcTime(start_ntp, end_ntp);
    	});
    },
    /*timed Text check*/
    timedTextSources:function(){
    	for(var i=0; i < this.sources.length; i++){    		
    		if(	this.sources[i].mime_type == 'text/cmml' ||
    			this.sources[i].mime_type == 'text/x-srt')
    				return true;    			    			
    	};
    	return false;
    },
    /** Returns the array of mediaSources of this element.
        \returns {Array} Array of mediaSource elements.
    */
    getSources:function( mime_filter )
    {
    	if(!mime_filter)
        	return this.sources;
        //apply mime filter: 
       	var source_set = new Array();
        for(var i=0; i < this.sources; i++){
        	if( this.sources[i].mime_type.indexOf( mime_filter ) != -1 )
        		source_set.push( this.sources[i] );
        }
        return source_set;
    },
    getSourceById:function( source_id ){
    	for(var i=0; i < this.sources; i++){
    		if( this.sources[i].id ==  source_id)
    			return this.sources[i];
    	}
    	return null;
    },
    /** Selects a particular source for playback.
    */
    selectSource:function(index)
    {
    	js_log('f:selectSource:'+index);
    	var playable_sources = this.getPlayableSources();
    	for(var i=0; i < playable_sources.length; i++){
    		if( i==index ){
    			this.selected_source = playable_sources[i];
    			//update the user prefrance: 
    			embedTypes.players.userSelectFormat( playable_sources[i].mime_type);
    			break;
    		}
    	}
    	js_log("selected source " + this.sources[index].getTitle());    	
    },
    /** selects the default source via cookie preference, default marked, or by id order
     * */
    autoSelectSource:function(){ 
    	js_log('f:autoSelectSource:');    
    	//@@todo read user preference for source    	
    	// Select the default source
    	var playable_sources = this.getPlayableSources();          	       		
    	var flash_flag=ogg_flag=false;  	    
    	//debugger;
        for(var source=0; source < playable_sources.length; source++){
        	var mime_type =playable_sources[source].mime_type;
            if( playable_sources[source].marked_default ){
            	js_log('set via marked default: ' + playable_sources[source].marked_default);
                this.selected_source = playable_sources[source];                
                return true;
            }
            //set via user-preference
            if(embedTypes.players.preference['format_prefrence']==mime_type){
            	 js_log('set via preference: '+playable_sources[source].mime_type);
            	 this.selected_source = playable_sources[source];
            	 return true; 
            }                                	                        
        }       
        //set Ogg via player support
        for(var source=0; source < playable_sources.length; source++){
        	js_log('f:autoSelectSource:' + playable_sources[source].mime_type);
        	var mime_type =playable_sources[source].mime_type;        	
       		//set source via player                 
            if(mime_type=='video/ogg' || mime_type=='ogg/video' || mime_type=='video/annodex' || mime_type=='application/ogg'){
            	for(var i in embedTypes.players){ //for in loop on object oky
	        		var player = embedTypes.players[i];
	        		//debugger;
	        		if(player.library=='vlc' || player.library=='native'){
	        			js_log('set via ogg via order')
	        			this.selected_source = playable_sources[source];    
	        			return true;
	        		}
	        	}
            }
        }
        //set h264 flash 
        for(var source=0; source < playable_sources.length; source++){  
        	var mime_type =playable_sources[source].mime_type;	        		        	        
            if( mime_type=='video/h264' ){
            	js_log('set via by player preference h264 flash')
            	this.selected_source = playable_sources[source];
            	return true;
            }   	        
        }        
        //set basic flash
        for(var source=0; source < playable_sources.length; source++){  
        	var mime_type =playable_sources[source].mime_type;	        		        	        
            if( mime_type=='video/x-flv' ){
            	js_log('set via by player preference normal flash')
            	this.selected_source = playable_sources[source];
            	return true;
            }            	        
        }
    	
        //select first source        
        if (!this.selected_source)
        {
            js_log('set via first source:' + playable_sources[0]);
            this.selected_source = playable_sources[0];
            return true;
        }
    },
    /** Returns the thumbnail URL for the media element.
        \returns {String} thumbnail URL
    */
    getThumbnailURL:function()
    {
        return this.thumbnail;
    },
    /** Checks whether there is a stream of a specified MIME type.
        @param {String} mime_type MIME type to check.
        @type {BooleanPrimitive}.
    */
    hasStreamOfMIMEType:function(mime_type)
    {
        for(source in this.sources)
        {
            if(this.sources[source].getMIMEType() == mime_type)
                return true;
        }
        return false;
    },
    isPlayableType:function(mime_type)
    {
    	if( embedTypes.players.defaultPlayer( mime_type ) ){
    		return true;
    	}else{
    		return false;
    	}
        //if(this.selected_player){
        //return mime_type=='video/ogg' || mime_type=='ogg/video' || mime_type=='video/annodex' || mime_type=='video/x-flv';
    },
    /** Adds a single mediaSource using the provided element if
        the element has a 'src' attribute.        
        @param element {element} <video>, <source> or <mediaSource> element.
    */
    tryAddSource:function(element)
    {
    	//js_log('f:tryAddSource:'+ $j(element).attr("src"));    	
        if (! $j(element).attr("src")){
        	//js_log("element has no src");
            return false;
        }
        var new_src = $j(element).attr('src');
        //make sure an existing element with the same src does not already exist:         
        for( var i=0; i < this.sources.length; i++ ){            	
        	if(this.sources[i].src == new_src){
        		//js_log('checking existing: '+this.sources[i].getURI() + ' != '+ new_src);     
        		//can't add it all but try to update any additional attr: 
        		this.sources[i].updateSource(element);
        		return false;
        	}
        }
        var source = new mediaSource( element );        
        this.sources.push(source);        
        //js_log('pushed source to stack'+ source + 'sl:'+this.sources.length);
    },
    getPlayableSources: function(){    	 
    	 var playable_sources= new Array();
    	 for(var i=0; i < this.sources.length; i++){    	     	 	    	 	
    	 	if( this.isPlayableType( this.sources[i].mime_type ) ){    	 		
    	 		playable_sources.push( this.sources[i] );
    	 	}else{
    	 		js_log("type "+ this.sources[i].mime_type + 'is not playable');
    	 	}
    	 };    	 
    	 return playable_sources;
    },
    /* Imports media sources from ROE data.
     *   @param roe_data ROE data.
    */
    addROE:function(roe_data){    	
    	js_log('f:addROE');
    	this.addedROEData=true;
        var _this = this;        
        if( typeof roe_data == 'string' )
        {
            var parser=new DOMParser();
            js_log('ROE data:' + roe_data);
            roe_data=parser.parseFromString(roe_data,"text/xml");
        }
        if( roe_data ){
	        $j.each(roe_data.getElementsByTagName('mediaSource'), function(inx, source){
				_this.tryAddSource(source);
	        });
	        //set the thumbnail:
			$j.each(roe_data.getElementsByTagName('img'), function(inx, n){
	            if($j(n).attr("id")=="stream_thumb"){
	                js_log('roe:set thumb to '+$j(n).attr("src"));
	                _this['thumbnail'] =$j(n).attr("src");
	            }
	        });
	        //set the linkback:
			$j.each(roe_data.getElementsByTagName('link'), function(inx, n){
	            if($j(n).attr('id')=='html_linkback'){
	                js_log('roe:set linkback to '+$j(n).attr("href"));
	                _this['linkback'] = $j(n).attr('href');
	            }
	        });
        }else{
			js_log('ROE data empty.');
		}				
    }
};

/** base embedVideo object
    @param element <video> tag used for initialization.
    @constructor
*/
var embedVideo = function(element) {
	return this.init(element);
};

embedVideo.prototype = {
    /** The mediaElement object containing all mediaSource objects */
    media_element:null,
    preview_mode:false,
	slider:null,		
	ready_to_play:false, //should use html5 ready state
	load_error:false, //used to set error in case of error
	loading_external_data:false,
	thumbnail_updating:false,
	thumbnail_disp:true,
	init_with_sources_loadedDone:false,
	inDOM:false,
	//for onClip done stuff: 
	anno_data_cache:null,
	seek_time_sec:0,
	base_seeker_slider_offset:null,
	onClipDone_disp:false,
	supports:{},
	//for seek thumb updates:
	cur_thumb_seek_time:0,
	thumb_seek_interval:null,
	//set the buffered percent:	
	bufferedPercent:0,	
	//utility functions for property values:
	hx : function ( s ) {
		if ( typeof s != 'String' ) {
			s = s.toString();
		}
		return s.replace( /&/g, '&amp;' )
			. replace( /</g, '&lt;' )
			. replace( />/g, '&gt;' );
	},
	hq : function ( s ) {
		return '"' + this.hx( s ) + '"';
	},
	playerPixelWidth : function()
	{
		var player = $j('#mv_embedded_player_'+this.id).get(0);
		if(typeof player!='undefined' && player['offsetWidth'])
			return player.offsetWidth;
		else
			return parseInt(this.width);
	},
	playerPixelHeight : function()
	{
		var player = $j('#mv_embedded_player_'+this.id).get(0);
		if(typeof player!='undefined' && player['offsetHeight'])
			return player.offsetHeight;
		else
			return parseInt(this.height);
	},
	init: function(element){		
		//this.element_pointer = element;

		//inherit all the default video_attributes
	    for(var attr in default_video_attributes){ //for in loop oky on user object
	        if(element.getAttribute(attr)){
	            this[attr]=element.getAttribute(attr);
	            //js_log('attr:' + attr + ' val: ' + video_attributes[attr] +" "+'elm_val:' + element.getAttribute(attr) + "\n (set by elm)");
	        }else{
	            this[attr]=default_video_attributes[attr];
	            //js_log('attr:' + attr + ' val: ' + video_attributes[attr] +" "+ 'elm_val:' + element.getAttribute(attr) + "\n (set by attr)");
	        }
	    }		   
	    if( this.duration!=null && this.duration.split(':').length >= 2)
	    	this.duration = ntp2seconds( this.duration );	    
	        	
	    //if style is set override width and height
	    var dwh = mv_default_video_size.split('x');
	    this.width = element.style.width ? element.style.width : dwh[0];
	    this.height = element.style.height ? element.style.height : dwh[1];
	    //set the plugin id
	    this.pid = 'pid_' + this.id;

	    //grab any innerHTML and set it to missing_plugin_html
	    //@@todo we should strip source tags instead of checking and skipping
	    if(element.innerHTML!='' && element.getElementsByTagName('source').length==0){
            js_log('innerHTML: ' + element.innerHTML);
	        this.user_missing_plugin_html=element.innerHTML;
	    }	      	    
	    // load all of the specified sources
        this.media_element = new mediaElement(element);                         	
	},
	on_dom_swap: function(){
		js_log('f:on_dom_swap');				
		// Process the provided ROE file... if we don't yet have sources
        if(this.roe && this.media_element.sources.length==0 ){
			js_log('loading external data');
        	this.loading_external_data=true;
        	var _this = this;              	  
            do_request(this.roe, function(data)
            {            	            
            	//continue      	         	
            	_this.media_element.addROE(data);                                      
                js_log('added_roe::' + _this.media_element.sources.length);                               
                                                       
                js_log('set loading_external_data=false');     
                _this.loading_external_data=false;                               
                
                _this.init_with_sources_loaded();
            });
    	}
	},
	init_with_sources_loaded : function()
	{	
		js_log('f:init_with_sources_loaded');
		//set flag that we have run this function:
		this.init_with_sources_loadedDone=true;				
		//autoseletct the source
		this.media_element.autoSelectSource();		
		//auto select player based on prefrence or default order
		if( !this.media_element.selected_source )
		{
			//check for parent clip: 
			if( typeof this.pc != 'undefined' ){			
				js_log('no sources, type:' +this.type + ' check for html');				
				//do load player if just displaying innerHTML: 
				if(this.pc.type =='text/html'){
					this.selected_player = embedTypes.players.defaultPlayer( 'text/html' );
					js_log('set selected player:'+ this.selected_player.mime_type);	
				}
			}
		}else{		
        	this.selected_player = embedTypes.players.defaultPlayer( this.media_element.selected_source.mime_type );
		}			      
        if( this.selected_player ){
            js_log('selected ' + this.selected_player.getName());
            js_log("PLAYBACK TYPE: "+this.selected_player.library);
            this.thumbnail_disp = true;	    
			this.inheritEmbedObj();
        }else{        	        
        	//no source's playable
        	var missing_type ='';
        	var or ='';  
        	for( var i=0; i < this.media_element.sources.length; i++){
        		missing_type+=or + this.media_element.sources[i].mime_type;
        		or=' or ';
        	}        	
        	if( this.pc )
        		var missing_type = this.pc.type;        		        	
        	
           	js_log('no player found for given source type ' + missing_type);
           	this.load_error= getMsg('generic_missing_plugin', missing_type );             	          	            
        }        
	},
	inheritEmbedObj:function(){		
		//@@note: tricky cuz direct overwrite is not so ideal.. since the extended object is already tied to the dom
		//clear out any non-base embedObj stuff:
		if(this.instanceOf){
			eval('tmpObj = '+this.instanceOf);
			for(var i in tmpObj){ //for in loop oky for object  
				if(this['parent_'+i]){
					this[i]=this['parent_'+i];
				}else{
					this[i]=null;
				}
			}
		}    		  	
		//set up the new embedObj
        js_log('f: inheritEmbedObj: embedding with ' + this.selected_player.library);
		var _this = this;		
		this.selected_player.load( function()
		{
			//js_log('inheriting '+_this.selected_player.library +'Embed to ' + _this.id + ' ' + $j('#'+_this.id).length);
			//var _this = $j('#'+_this.id).get(0);
			//js_log( 'type of ' + _this.selected_player.library +'Embed + ' +
			//		eval('typeof '+_this.selected_player.library +'Embed')); 
			eval('embedObj = ' +_this.selected_player.library +'Embed;');
			for(var method in embedObj){ //for in loop oky for object  
				//parent method preservation for local overwritten methods
				if(_this[method])
					_this['parent_' + method] = _this[method];
				_this[method]=embedObj[method];
			}
			js_log('TYPEOF_ppause: ' + typeof _this['parent_pause']);
			
			if(_this.inheritEmbedOverride){
				_this.inheritEmbedOverride();
			}
			//update controls if possible
			if(!_this.loading_external_data)
				_this.refreshControlsHTML();												
			
			//js_log("READY TO PLAY:"+_this.id);			
			_this.ready_to_play=true;
			_this.getDuration();
			_this.getHTML();
		});
	},
    selectPlayer:function(player)
    {
		var _this = this;
		if(this.selected_player.id != player.id){
	        this.selected_player = player;
	        this.inheritEmbedObj();
		}
    },
	getTimeReq:function(){
		js_log('f:getTimeReq:'+ this.getDurationNTP());
		var default_time_req = '0:00:00/' + this.getDurationNTP() ;
		if(!this.media_element)
			return default_time_req;
		if(!this.media_element.selected_source)
			return default_time_req;		
		if(!this.media_element.selected_source.end_ntp)
			return default_time_req;		
		return this.media_element.selected_source.start_ntp+'/'+this.media_element.selected_source.end_ntp;
	},	
    getDuration:function(){
    	//update some local pointers for the selected source:
    	if( this.media_element.selected_source.duration != 0 )  	
        	this.duration = this.media_element.selected_source.duration;        	        	
        this.start_offset = this.media_element.selected_source.start_offset;
        this.start_ntp = this.media_element.selected_source.start_ntp;
        this.end_ntp = this.media_element.selected_source.end_ntp;         
        //return the duration
        return this.duration;
    },
  	/* get the duration in ntp format */
	getDurationNTP:function(){
		return seconds2ntp(this.getDuration());
	},
	/*
	 * wrapEmebedContainer
     * wraps the embed code into a container to better support playlist function
     *  (where embed element is swapped for next clip
     *  (where plugin method does not support playlsits) 
	 */
	wrapEmebedContainer:function(embed_code){
		//check if parent clip is set( ie we are in a playlist so name the embed container by playlistID)
		var id = (this.pc!=null)?this.pc.pp.id:this.id;
		return '<div id="mv_ebct_'+id+'" style="width:'+this.width+'px;height:'+this.height+'px;">' + 
					embed_code + 
				'</div>';
	},	
	getEmbedHTML : function(){
		//return this.wrapEmebedContainer( this.getEmbedObj() );
		return 'function getEmbedHTML should be overiten by embedLib ';
	},
	//do seek function (should be overwritten by implementing embedLibs)
	// first check if seek can be done on locally downloaded content. 
	doSeek : function( perc ){
		js_log('f:mv_embed:doSeek:'+perc);
		if( this.supportsURLTimeEncoding() ){
			js_log('Seeking to ' + this.seek_time_sec + ' (local copy of clip not loaded at' + perc + '%)');
			this.stop();			
			//this.seek_time_sec = 0; 
		}
		//do play in 100ms (give things time to clear) 
		setTimeout('$j(\'#' + this.id + '\').get(0).play()',100);
	},	
    doEmbedHTML:function()
    {
    	js_log('f:doEmbedHTML');
    	js_log('thum disp:'+this.thumbnail_disp);
		var _this = this;
		this.closeDisplayedHTML();

//		if(!this.selected_player){
//			return this.getPluginMissingHTML();		
		//Set "loading" here
		$j('#mv_embedded_player_'+_this.id).html(''+
			'<div style="color:black;width:'+this.width+'px;height:'+this.height+'px;">' + 
				getMsg('loading_plugin') + 
			'</div>'					
		);
		// schedule embedding
		this.selected_player.load(function()
		{
			js_log('performing embed for ' + _this.id);			
			var embed_code = _this.getEmbedHTML();
			//js_log(embed_code);
			$j('#mv_embedded_player_'+_this.id).html(embed_code);	
		});
    },
    /* todo abstract out onClipDone chain of functions and merge with textInterface */
    onClipDone:function(){
    	//stop the clip (load the thumbnail etc) 
    	this.stop();
    	var _this = this;
    	
    	//if the clip resolution is < 320 don't do fancy onClipDone stuff 
    	if(this.width<300){
    		return ;
    	}
    	this.onClipDone_disp=true;
    	this.thumbnail_disp=true;
    	//make sure we are not in preview mode( no end clip actions in preview mode) 
    	if( this.preview_mode )
    		return ;
    		
    	$j('#img_thumb_'+this.id).css('zindex',1);
    	$j('#big_play_link_'+this.id).hide();
    	//add the liks_info_div black back 
    	$j('#dc_'+this.id).append('<div id="liks_info_'+this.id+'" ' +
	    			'style="width:' +parseInt(parseInt(this.width)/2)+'px;'+	    
	    			'height:'+ parseInt(parseInt(this.height)) +'px;'+
	    			'position:absolute;top:10px;overflow:auto'+    			
	    			'width: '+parseInt( ((parseInt(this.width)/2)-15) ) + 'px;'+
	    			'left:'+ parseInt( ((parseInt(this.width)/2)+15) ) +'px;">'+	    			
    			'</div>' +
    			'<div id="black_back_'+this.id+'" ' +
	    			'style="z-index:-2;position:absolute;background:#000;' +
	    			'top:0px;left:0px;width:'+parseInt(this.width)+'px;' +
	    			'height:'+parseInt(this.height)+'px;">' +
	    		'</div>'
	   	);    	
    	
    	//start animation (make thumb small in uper left add in div for "loading"    	    
    	$j('#img_thumb_'+this.id).animate({    			
    			width:parseInt(parseInt(_this.width)/2),
    			height:parseInt(parseInt(_this.height)/2),
    			top:20,
    			left:10
    		},
    		1000, 
    		function(){
    			//animation done.. add "loading" to div if empty    	
    			if($j('#liks_info_'+_this.id).html()==''){
    				$j('#liks_info_'+_this.id).html(getMsg('loading_txt'));
    			}		
    		}
    	)       	 	   
    	//now load roe if run the showNextPrevLinks
    	if(this.roe && this.media_element.addedROEData==false){
    		do_request(this.roe, function(data)
            {            	                        	      	         
            	_this.media_element.addROE(data);
            	_this.getNextPrevLinks();
            });    
    	}else{
    		this.getNextPrevLinks();
    	}
    },
    //@@todo we should merge getNextPrevLinks with textInterface .. there is repeated code between them. 
    getNextPrevLinks:function(){
    	js_log('f:getNextPrevLinks');
    	var anno_track_url = null;
    	var _this = this; 
    	//check for annoative track
    	$j.each(this.media_element.sources, function(inx, n){    		
			if(n.mime_type=='text/cmml'){
				if( n.id == 'Anno_en'){
					anno_track_url = n.src;
				}
			}
    	});
    	if( anno_track_url ){
    		js_log('found annotative track:'+ anno_track_url);
    		//zero out seconds (should improve cache hit rate and generally expands metadata search)
    		//@@todo this could be repalced with a regExp
    		var annoURL = parseUri(anno_track_url);
    		var times = annoURL.queryKey['t'].split('/');      		
    		var stime_parts = times[0].split(':');   
    		var etime_parts = times[1].split(':');         				
    		//zero out the hour:
    		var new_start = stime_parts[0]+':'+'0:0';
    		//zero out the end sec
    		var new_end   = (etime_parts[0]== stime_parts[0])? (etime_parts[0]+1)+':0:0' :etime_parts[0]+':0:0';
    		 		
    		var etime_parts = times[1].split(':');
    		
    		var new_anno_track_url = annoURL.protocol +'://'+ annoURL.host + annoURL.path +'?';
    		$j.each(annoURL.queryKey, function(i, val){
    			new_anno_track_url +=(i=='t')?'t='+new_start+'/'+new_end +'&' :
    									 i+'='+ val+'&';
    		});
    		var request_key = new_start+'/'+new_end;
    		//check the anno_data cache: 
    		//@@todo search cache see if current is in range.  
    		if(this.anno_data_cache){
    			js_log('anno data found in cache: '+request_key);
    			this.showNextPrevLinks();
    		}else{    			    			
	    		do_request(new_anno_track_url, function(cmml_data){
	    			js_log('raw response: '+ cmml_data);
				    if(typeof cmml_data == 'string')
			        {
			            var parser=new DOMParser();
			            js_log('Parse CMML data:' + cmml_data);
			            cmml_data=parser.parseFromString(cmml_data,"text/xml");
			        }
	    			//init anno_data_cache
	    			if(!_this.anno_data_cache)
	    				_this.anno_data_cache={};	    			
	    			//grab all metadata and put it into the anno_data_cache: 	    			
	    			$j.each(cmml_data.getElementsByTagName('clip'), function(inx, clip){
	    				_this.anno_data_cache[ $j(clip).attr("id") ]={
	    						'start_time_sec':ntp2seconds($j(clip).attr("start").replace('npt:','')),
	    						'end_time_sec':ntp2seconds($j(clip).attr("end").replace('npt:','')),
	    						'time_req':$j(clip).attr("start").replace('npt:','')+'/'+$j(clip).attr("end").replace('npt:','')
	    					};
	    				//grab all its meta
	    				_this.anno_data_cache[ $j(clip).attr("id") ]['meta']={};
	    				$j.each(clip.getElementsByTagName('meta'),function(imx, meta){	    					
	    					//js_log('adding meta: '+ $j(meta).attr("name")+ ' = '+ $j(meta).attr("content"));
	    					_this.anno_data_cache[$j(clip).attr("id")]['meta'][$j(meta).attr("name")]=$j(meta).attr("content");
	    				});
	    			});
	    			_this.showNextPrevLinks();	    			
	    		});
    		}
    	}else{
    		js_log('no annotative track found');
    		$j('#liks_info_'+this.id).html('no metadata found for next, previous links');
    	}
    	//query current request time +|- 60s to get prev next speech links. 
    },
    showNextPrevLinks:function(){
    	js_log('f:showNextPrevLinks');
    	//int requested links: 
    	var link = {
    		'prev':'',
    		'current':'',
    		'next':''
    	}    	
    	var curTime = this.getTimeReq().split('/');
    	
    	var s_sec = ntp2seconds(curTime[0]);
    	var e_sec = ntp2seconds(curTime[1]); 
    	js_log('showNextPrevLinks: req time: '+ s_sec + ' to ' + e_sec);
    	//now we have all the data in anno_data_cache
    	var current_done=false;
    	for(var clip_id in this.anno_data_cache){  //for in loop oky for object
		 	var clip =  this.anno_data_cache[clip_id];
		 	//js_log('on clip:'+ clip_id);
		 	//set prev_link (if cur_link is still empty)
			if( s_sec > clip.end_time_sec){
				link.prev = clip_id;
				js_log('showNextPrevLinks: ' + s_sec + ' < ' + clip.end_time_sec + ' set prev');
			}
				
			if(e_sec==clip.end_time_sec && s_sec== clip.start_time_sec)
				current_done = true;
			//current clip is not done:
			if(  e_sec < clip.end_time_sec  && link.current=='' && !current_done){
				link.current = clip_id;
				js_log('showNextPrevLinks: ' + e_sec + ' < ' + clip.end_time_sec + ' set current'); 
			}
			
			//set end clip (first clip where start time is > end_time of req
			if( e_sec <  clip.start_time_sec && link.next==''){
				link.next = clip_id;
				js_log('showNextPrevLinks: '+  e_sec + ' < '+ clip.start_time_sec + ' && ' + link.next );
			}
    	}   
    	var html='';   
    	if(link.prev=='' && link.current=='' && link.next==''){
    		html='<p><a href="'+this.media_element.linkbackgetMsg+'">clip page</a>';
    	}else{    	
	    	for(var link_type in link){
	    		var link_id = link[link_type];    		
	    		if(link_id!=''){
	    			var clip = this.anno_data_cache[link_id];    			
	    			var title_msg='';
					for(var j in clip['meta']){
						title_msg+=j.replace(/_/g,' ') +': ' +clip['meta'][j].replace(/_/g,' ') +" <br>";
					}    	
					var time_req = 	clip.time_req;
					if(link_type=='current') //if current start from end of current clip play to end of current meta: 				
						time_req = curTime[1]+ '/' + seconds2ntp( clip.end_time_sec );
					
					//do special linkbacks for metavid content: 
					var regTimeCheck = new RegExp(/[0-9]+:[0-9]+:[0-9]+\/[0-9]+:[0-9]+:[0-9]+/);				
					html+='<p><a  ';
					if( regTimeCheck.test( this.media_element.linkback ) ){
						html+=' href="'+ this.media_element.linkback.replace(regTimeCheck,time_req) +'" '; 
					}else{
						html+=' href="#" onClick="$j(\'#'+this.id+'\').get(0).playByTimeReq(\''+ 
		    					time_req + '\'); return false; "';				
					}
					html+=' title="' + title_msg + '">' + 
		    	 		getMsg(link_type+'_clip_msg') + 	    	 	
		    		'</a><br><span style="font-size:small">'+ title_msg +'<span></p>';
	    		}    	    				
	    	}
    	}	
    	//js_og("should set html:"+ html);
    	$j('#liks_info_'+this.id).html(html);
    },
    playByTimeReq: function(time_req){
    	js_log('f:playByTimeReq: '+time_req );
    	this.stop();
    	this.updateVideoTimeReq(time_req);
    	this.play();    	
    },
    doThumbnailHTML:function()
    {  	
    	var _this = this;
    	js_log('f:doThumbnailHTML'+ this.thumbnail_disp);
        this.closeDisplayedHTML();
        this.thumbnail_disp = true;

        $j('#mv_embedded_player_'+this.id).html( this.getThumbnailHTML() );
		this.paused = true;		
    },
    refreshControlsHTML:function(){
    	js_log('refreshing controls HTML');
		if($j('#mv_embedded_controls_'+this.id).length==0)
		{
			js_log('#mv_embedded_controls_'+this.id + ' not present, returning');
			return;
		}else{
			$j('#mv_embedded_controls_'+this.id).html( this.getControlsHTML() );
			ctrlBuilder.addControlHooks(this);						
		}		
    },   
    getControlsHTML:function()
    {        	
    	return ctrlBuilder.getControls( this );
    },	
	getHTML : function (){		
		//@@todo check if we have sources avaliable	
		js_log('f:getHTML : ' + this.id );			
		var _this = this; 				
		var html_code = '';		
        html_code = '<div id="videoPlayer_'+this.id+'" style="width:'+this.width+'px;" class="videoPlayer">';        
			html_code += '<div style="width:'+parseInt(this.width)+'px;height:'+parseInt(this.height)+'px;"  id="mv_embedded_player_'+this.id+'">' +
							this.getThumbnailHTML() + 
						'</div>';											
			//js_log("mvEmbed:controls "+ typeof this.controls);									
	        if(this.controls)
	        {
	        	js_log("f:getHTML:AddControls");
	            html_code +='<div id="mv_embedded_controls_'+this.id+'" class="controls" style="width:'+this.width+'px">';
	            html_code += this.getControlsHTML();       
	            html_code +='</div>';      
	            //block out some space by encapulating the top level div 
	            $j(this).wrap('<div style="width:'+parseInt(this.width)+'px;height:'
	            		+(parseInt(this.height)+ctrlBuilder.height)+'px"></div>');    	            
	        }
        html_code += '</div>'; //videoPlayer div close        
        //js_log('should set: '+this.id);
        $j(this).html( html_code );                    
		//add hooks once Controls are in DOM
		ctrlBuilder.addControlHooks(this);		
		                  
        //js_log('set this to: ' + $j(this).html() );	
        //alert('stop');
        //if auto play==true directly embed the plugin
        if(this.autoplay)
		{
			js_log('activating autoplay');
            this.play();
		}
	},
	/*
	* get missing plugin html (check for user included code)
	*/
	getPluginMissingHTML : function(){
		//keep the box width hight:
		var out = '<div style="width:'+this.width+'px;height:'+this.height+'px">';
	    if(this.user_missing_plugin_html){
	      out+= this.user_missing_plugin_html;
	    }else{
		  out+= getMsg('generic_missing_plugin') + ' or <a title="'+getMsg('download_clip')+'" href="'+this.src +'">'+getMsg('download_clip')+'</a>';
		}
		return out + '</div>';
	},
	updateVideoTimeReq:function(time_req){
		js_log('f:updateVideoTimeReq');
		var time_parts =time_req.split('/');
		this.updateVideoTime(time_parts[0], time_parts[1]);
	},
	//update video time
	updateVideoTime:function(start_ntp, end_ntp){					
		//update media
		this.media_element.updateSourceTimes( start_ntp, end_ntp );
		//update mv_time
		this.setStatus(start_ntp+'/'+end_ntp);
		//reset slider
		this.setSliderValue(0);
		//reset seek_offset:
		if(this.media_element.selected_source.supports_url_time_encoding)
			this.seek_time_sec=0;
		else
			this.seek_time_sec=ntp2seconds(start_ntp);
	},		
	//@@todo overwite by embed library if we can render frames natavily 
	renderTimelineThumbnail:function( options ){
		var my_thumb_src = this.media_element.getThumbnailURL();
		
		if( my_thumb_src.indexOf('t=') !== -1){
			var time_ntp =  seconds2ntp ( options.time + parseInt(this.start_offset) );
			my_thumb_src = getUpdateTimeURL( my_thumb_src, time_ntp, options.size );
		}
		var thumb_class = (typeof options['thumb_class'] !='undefined')? options['thumb_class'] : '';
		return '<div class="' + thumb_class + '" src="' + my_thumb_src +'" '+
				'style="height:' + options.height + 'px;' +
				'width:' + options.width + 'px" >' + 
				 	'<img src="' + my_thumb_src +'" '+
						'style="height:' + options.height + 'px;' +
						'width:' + options.width + 'px">' +
				'</div>';
	},
	updateThumbTimeNTP:function( time){
		this.updateThumbTime( ntp2seconds(time) - parseInt(this.start_offset) );
	},
	updateThumbTime:function( float_sec ){
		js_log('updateThumbTime:'+float_sec);
		var _this = this;									   				
		if( typeof this.org_thum_src=='undefined' ){		
			this.org_thum_src = this.media_element.getThumbnailURL();
		}							
		if( this.org_thum_src.indexOf('t=') !== -1){
			this.last_thumb_url = getUpdateTimeURL(this.org_thum_src,seconds2ntp( float_sec + parseInt(this.start_offset)));									
			if(!this.thumbnail_updating){				
				this.updateThumbnail(this.last_thumb_url ,false);
				this.last_thumb_url =null;
			}
		}
	},
	//for now provide a src url .. but need to figure out how to copy frames from video for plug-in based thumbs
	updateThumbPerc:function( perc ){	
		return this.updateThumbTime( (this.getDuration() * perc) );
	},
	//updates the thumbnail if the thumbnail is being displayed
	updateThumbnail : function(src, quick_switch){		
		js_log('update thumb: ' + src);
		//make sure we don't go to the same url if we are not already updating: 
		if( !this.thumbnail_updating && $j('#img_thumb_'+this.id).attr('src')== src )
			return false;
		//if we are updating don't re-go to the updating url: 
		if(this.thumbnail_updating && $j('#new_img_thumb_'+this.id).attr('src')== src )
			return false;
				
		if(quick_switch){
			$j('#img_thumb_'+this.id).attr('src', src);
		}else{
			var _this = this;			
			//if still animating remove new_img_thumb_
			if(this.thumbnail_updating==true)
				$j('#new_img_thumb_'+this.id).stop().remove();		
					
			if(this.thumbnail_disp){
				js_log('set to thumb:'+ src);
				this.thumbnail_updating=true;
				$j('#dc_'+this.id).append('<img src="'+src+'" ' +
					'style="display:none;position:absolute;zindex:2;top:0px;left:0px;" ' +
					'width="'+this.width+'" height="'+this.height+'" '+
					'id = "new_img_thumb_'+this.id+'" />');						
				//js_log('appended: new_img_thumb_');		
				$j('#new_img_thumb_'+this.id).fadeIn("slow", function(){						
						//once faded in remove org and rename new:
						$j('#img_thumb_'+_this.id).remove();
						$j('#new_img_thumb_'+_this.id).attr('id', 'img_thumb_'+_this.id);
						$j('#img_thumb_'+_this.id).css('zindex','1');
						_this.thumbnail_updating=false;						
						//js_log("done fadding in "+ $j('#img_thumb_'+_this.id).attr("src"));
						
						//if we have a thumb queued update to that
						if(_this.last_thumb_url){
							var src_url =_this.last_thumb_url;
							_this.last_thumb_url=null;
							_this.updateThumbnail(src_url);
						}
				});
			}
		}
	},
    /** Returns the HTML code for the video when it is in thumbnail mode.
        This includes the specified thumbnail as well as buttons for
        playing, configuring the player, inline cmml display, HTML linkback,
        download, and embed code.
    */
	getThumbnailHTML : function ()
    {
	    var thumb_html = '';
	    var class_atr='';
	    var style_atr='';
	    //if(this.class)class_atr = ' class="'+this.class+'"';
	    //if(this.style)style_atr = ' style="'+this.style+'"';
	    //    else style_atr = 'overflow:hidden;height:'+this.height+'px;width:'+this.width+'px;';
        this.thumbnail = this.media_element.getThumbnailURL();

	    //put it all in the div container dc_id
	    thumb_html+= '<div id="dc_'+this.id+'" style="position:relative;'+
	    	' overflow:hidden; top:0px; left:0px; width:'+this.playerPixelWidth()+'px; height:'+this.playerPixelHeight()+'px; z-index:0;">'+
	        '<img width="'+this.playerPixelWidth()+'" height="'+this.playerPixelHeight()+'" style="position:relative;width:'+this.playerPixelWidth()+';height:'+this.playerPixelHeight()+'"' +
	        ' id="img_thumb_'+this.id+'" src="' + this.thumbnail + '">';
		
	    if(this.play_button==true)
		  	thumb_html+=this.getPlayButton();
		  	
   	    thumb_html+='</div>';
	    return thumb_html;
    },
	getEmbeddingHTML:function()
	{
		var thumbnail = this.media_element.getThumbnailURL();

		var embed_thumb_html;
		if(thumbnail.substring(0,1)=='/'){
			eURL = parseUri(mv_embed_path);
			embed_thumb_html = eURL.protocol + '://' + eURL.host + thumbnail;
			//js_log('set from mv_embed_path:'+embed_thumb_html);
		}else{
			embed_thumb_html = (thumbnail.indexOf('http://')!=-1)?thumbnail:mv_embed_path + thumbnail;
		}
		var embed_code_html = '&lt;script type=&quot;text/javascript&quot; ' +
					'src=&quot;'+mv_embed_path+'mv_embed.js&quot;&gt;&lt;/script&gt' +
					'&lt;video ';
		if(this.roe){
			embed_code_html+='roe=&quot;'+this.roe+'&quot; &gt;';
		}else{
			embed_code_html+='src=&quot;'+this.src+'&quot; ' +
				'thumbnail=&quot;'+embed_thumb_html+'&quot;&gt;';
		}
		//close the video tag
		embed_code_html+='&lt;/video&gt;';

		return embed_code_html;
	},
    doOptionsHTML:function()
    {
    	var sel_id = (this.pc!=null)?this.pc.pp.id:this.id;
    	var pos = $j('#options_button_'+sel_id).offset();
    	pos['top']=pos['top']+24;
		pos['left']=pos['left']-124;
		//js_log('pos of options button: t:'+pos['top']+' l:'+ pos['left']);
        $j('#mv_embedded_options_'+sel_id).css(pos).toggle();
        return;
	},
	getPlayButton:function(id){
		if(!id)id=this.id;
		return '<div id="big_play_link_'+id+'" class="large_play_button" '+
			'style="left:'+((this.playerPixelWidth()-130)/2)+'px;'+
			'top:'+((this.playerPixelHeight()-96)/2)+'px;"></div>';
	},
	//display the code to remotely embed this video:
	showEmbedCode : function(embed_code){
		if(!embed_code)
			embed_code = this.getEmbeddingHTML();
		var o='';
		if(this.linkback){
			o+='<a class="email" href="'+this.linkback+'">Share Clip via Link</a> '+
			'<p>or</p> ';
		}
		o+='<span style="color:#FFF;font-size:14px;">Embed Clip in Blog or Site</span>'+
			'<div class="embed_code"> '+
				'<textarea onClick="this.select();" id="embedding_user_html_'+this.id+'" name="embed">' +
					embed_code+
				'</textarea> '+
				'<button onClick="$j(\'#'+this.id+'\').get(0).copyText(); return false;" class="copy_to_clipboard">Copy to Clipboard</button> '+
			'</div> '+
		'</div>';
		this.displayHTML(o);
	},
	copyText:function(){
	  $j('#embedding_user_html_'+this.id).focus().select();	   	 
	  if(document.selection){  	
		  CopiedTxt = document.selection.createRange();	
		  CopiedTxt.execCommand("Copy");
	  }
	},
	showTextInterface:function(){	
		var _this = this;
		//display the text container with loading text: 
		//@@todo support position config
		var loc = $j(this).position();			
		if($j('#metaBox_'+this.id).length==0){
			$j(this).after('<div style="position:absolute;z-index:10;'+
						'top:' + (loc.top) + 'px;' +
						'left:' + (parseInt( loc.left ) + parseInt(this.width) + 10 )+'px;' +
						'height:'+ parseInt( this.height )+'px;width:400px;' +
						'background:white;border:solid black;' +
						'display:none;" ' +
						'id="metaBox_' + this.id + '">'+
							getMsg('loading_txt') +
						'</div>');					
		}
		//fade in the text display
		$j('#metaBox_'+this.id).fadeIn("fast");	
		//check if textObj present:
		if(typeof this.textInterface == 'undefined' ){
			//load the default text interface:
			mvJsLoader.doLoad({
					'textInterface':'libTimedText/mv_timed_text.js',
					'$j.fn.hoverIntent':'jquery/plugins/jquery.hoverIntent.js'
				}, function(){
					
					_this.textInterface = new textInterface( _this );							
					//show interface
					_this.textInterface.show();
					js_log("NEW TEXT INTERFACE");
					for(var i in _this.textInterface.availableTracks){
						js_log("tracks in new interface: "+_this.id+ ' tid:' + i);						
					}
				}
			);
		}else{
			//show interface
			this.textInterface.show();
		}
	},
	closeTextInterface:function(){
		js_log('closeTextInterface '+ typeof this.textInterface);
		if(typeof this.textInterface !== 'undefined' ){
			this.textInterface.close();
		}
	},
    /** Generic function to display custom HTML inside the mv_embed element.
        The code should call the closeDisplayedHTML function to close the
        display of the custom HTML and restore the regular mv_embed display.
        @param {String} HTML code for the selection list.
    */
    displayHTML:function(html_code)
    {
    	var sel_id = (this.pc!=null)?this.pc.pp.id:this.id;
    	
    	if(!this.supports['overlays'])
        	this.stop();
        
        //put select list on-top
        //make sure the parent is relatively positioned:
        $j('#'+sel_id).css('position', 'relative');
        //set height width (check for playlist container)
        var width = (this.pc)?this.pc.pp.width:this.playerPixelWidth();
        var height = (this.pc)?this.pc.pp.height:this.playerPixelHeight();
        
        if(this.pc)
        	height+=(this.pc.pp.pl_layout.title_bar_height + this.pc.pp.pl_layout.control_height);
      
        var fade_in = true;
        if($j('#blackbg_'+sel_id).length!=0)
        {
            fade_in = false;
            $j('#blackbg_'+sel_id).remove();
        }
        //fade in a black bg div ontop of everything
         var div_code = '<div id="blackbg_'+sel_id+'" class="videoComplete" ' +
			 'style="height:'+parseInt(height)+'px;width:'+parseInt(width)+'px;">'+
//       			 '<span class="displayHTML" id="con_vl_'+this.id+'" style="position:absolute;top:20px;left:20px;color:white;">' +
	  		'<div class="videoOptionsComplete">'+
			//@@TODO: this style should go to .css
			'<span style="float:right;margin-right:10px">' +			
		    		'<a href="#" style="color:white;" onClick="$j(\'#'+sel_id+'\').get(0).closeDisplayedHTML();return false;">close</a>' +
		    '</span>'+
            '<div id="mv_disp_inner_'+sel_id+'" style="padding-top:10px;">'+
            	 html_code 
           	+'</div>'+
//                close_link+'</span>'+
      		 '</div></div>';
        $j('#'+sel_id).prepend(div_code);
        if (fade_in)
            $j('#blackbg_'+sel_id).fadeIn("slow");
        else
            $j('#blackbg_'+sel_id).show();
        return false; //onclick action return false
    },
    /** Close the custom HTML displayed using displayHTML and restores the
        regular mv_embed display.
    */
    closeDisplayedHTML:function(){
	 	 var sel_id = (this.pc!=null)?this.pc.pp.id:this.id;
		 $j('#blackbg_'+sel_id).fadeOut("slow", function(){
			 $j('#blackbg_'+sel_id).remove();
		 });
 		return false;//onclick action return false
	},
    selectPlaybackMethod:function(){    	
    	//get id (in case where we have a parent container)
        var this_id = (this.pc!=null)?this.pc.pp.id:this.id;
        
        var _this=this;               
        var out='<span style="color:white"><blockquote>';
        var _this=this;
        //js_log('selected src'+ _this.media_element.selected_source.url);
		$j.each(this.media_element.getPlayableSources(), function(index, source)
        {     		
	        var default_player = embedTypes.players.defaultPlayer( source.getMIMEType() );
	        var source_select_code = '$j(\'#'+this_id+'\').get(0).closeDisplayedHTML(); $j(\'#'+_this.id+'\').get(0).media_element.selectSource(\''+index+'\');';
	        
	        //var player_code = _this.getPlayerSelectList( source.getMIMEType(), index, source_select_code);
	        
	        var is_selected = (source == _this.media_element.selected_source);
	        var image_src = mv_embed_path+'images/stream/';
	        if( source.mime_type == 'video/x-flv' ){
	        	image_src += 'flash_icon_';
	        }else if( source.mime_type == 'video/h264'){
	        	//for now all mp4 content is pulled from archive.org (so use archive.org icon) 
	        	image_src += 'archive_org_';
	        }else{
	        	image_src += 'fish_xiph_org_';
	        }
	        image_src += is_selected ? 'color':'bw';
	        image_src += '.png';
	        if (default_player)
	        {
	            out += '<img src="'+image_src+'"/>';
	            if( ! is_selected )
	                out+='<a href="#" onClick="' + source_select_code + 'embedTypes.players.userSelectPlayer(\''+default_player.id+'\',\''+source.getMIMEType()+'\'); return false;">';
	            out += source.getTitle()+ (is_selected?'</a>':'') + ' ';
	        	//output the player select code: 
	        	var supporting_players = embedTypes.players.getMIMETypePlayers( source.getMIMEType() );		
				out+='<div id="player_select_list_' + index + '" class="player_select_list"><ul>';
				for(var i=0; i < supporting_players.length ; i++){				
					if( _this.selected_player.id == supporting_players[i].id && is_selected ){
						out+='<li style="border-style:dashed;margin-left:20px;">'+
									'<img border="0" width="16" height="16" src="'+mv_embed_path+'images/plugin.png">'+
									supporting_players[i].getName() +
							'</li>';
					}else{
						//else gray plugin and the plugin with link to select
						out+='<li style="margin-left:20px;">'+
								'<a href="#" onClick="'+ source_select_code + 'embedTypes.players.userSelectPlayer(\''+supporting_players[i].id+'\',\''+ source.getMIMEType()+'\');return false;">'+
									'<img border="0" width="16" height="16" src="'+mv_embed_path+'images/plugin_disabled.png">'+
									supporting_players[i].getName() +
								'</a>'+
							'</li>';
					}
				 }
				 out+='</ul></div>';           
	        }else
	            out+= source.getTitle() + ' - no player available';
        });
        out+='</blockquote></span>';
        this.displayHTML(out);
    },
	/*download list is exessivly complicated ... rewrite for clarity: */
	showVideoDownload:function(){		
		//load the roe if avaliable (to populate out download options:
		js_log('f:showVideoDownload '+ this.roe + ' ' + this.media_element.addedROEData);
		if(this.roe && this.media_element.addedROEData==false){
			var _this = this;
			this.displayHTML(getMsg('loading_txt'));
			do_request(this.roe, function(data)
            {
               _this.media_element.addROE(data);                             
               $j('#mv_disp_inner_'+_this.id).html(_this.getShowVideoDownload());
            });	           
		}else{
			this.displayHTML(this.getShowVideoDownload());
		}       
	},
	getShowVideoDownload:function(){ 
		var out='<b style="color:white;">'+getMsg('download_segment')+'</b><br>';
		out+='<span style="color:white"><blockquote>';
		var dl_list='';
		var dl_txt_list='';
		
        $j.each(this.media_element.getSources(), function(index, source){
        	var dl_line = '<li>' + '<a style="color:white" href="' + source.getURI() +'"> '
                + source.getTitle()+'</a> '+ '</li>'+"\n";            
			if(	 source.getURI().indexOf('?t=')!==-1){
                out+=dl_line;
			}else if(this.getMIMEType()=="text/cmml"){
				dl_txt_list+=dl_line;
			}else{
				dl_list+=dl_line;
			}
        });
        if(dl_list!='')
        	out+='</blockquote>'+getMsg('download_full')+"<blockquote>"+dl_list+'</blockquote>';
        if(dl_txt_list!='')
			out+='</blockquote>'+getMsg('download_text')+"<blockquote>"+dl_txt_list+'</blockquote></span>';
       	return out;
	},
	/*
	*  base embed controls
	*	the play button calls
	*/
	play:function(){
		var this_id = (this.pc!=null)?this.pc.pp.id:this.id;		
		js_log( "mv_embed play:" + this.id);		
		js_log('thum disp:'+this.thumbnail_disp);
		//check if thumbnail is being displayed and embed html
		if( this.thumbnail_disp ){			
			if( !this.selected_player ){
				js_log('no selected_player');
				//this.innerHTML = this.getPluginMissingHTML();
				//$j(this).html(this.getPluginMissingHTML());
				$j('#'+this.id).html( this.getPluginMissingHTML() );
			}else{
                this.doEmbedHTML();
                this.onClipDone_disp=false;               
            	this.paused=false;       
            	this.thumbnail_disp=false;     	
			}
		}else{
			//the plugin is already being displayed			
			this.paused=false; //make sure we are not "paused"
		}				
       	$j("#mv_play_pause_button_" + this_id).attr({
       		'class':'pause_button'
       	}).unbind( "click" ).click(function(){
       		$j('#' + this_id ).get(0).pause();
       	});
	},
	/*
	 * base embed pause
	 * 	there is no general way to pause the video
	 *  must be overwritten by embed object to support this functionality.
	 */
	pause: function(){
		var this_id = (this.pc!=null)?this.pc.pp.id:this.id;		
		js_log('mv_embed:do pause');		
        //(playing) do pause        
        this.paused=true; 
        //update the ctrl "paused state"            	
        $j("#mv_play_pause_button_" + this_id).attr({
        		'class':'play_button'        		
        }).unbind( "click" ).click(function(){
        	$j('#'+this_id).get(0).play();
        });
	},	
	/*
	 * base embed stop (can be overwritten by the plugin)
	 */
	stop: function(){
		var _this = this;
		js_log('mvEmbed:stop:'+this.id);
		//first issue pause to update interface	(only call the parent) 
		if(this['parent_pause']){
			this.parent_pause();
		}else{
			this.pause();
		}	
		//check if thumbnail is being displayed in which case do nothing
		if(this.thumbnail_disp){
			//already in stooped state
			js_log('already in stopped state');
		}else{
			//rewrite the html to thumbnail disp
			this.doThumbnailHTML();
			this.bufferedPercent=0; //reset buffer state
			this.setSliderValue(0);
			this.setStatus( this.getTimeReq() );
		}
		//make sure the big playbutton is has click action: 
		$j('#big_play_link_' + _this.id).unbind('click').click(function(){
			$j('#' +_this.id).get(0).play();
		});
		
        if(this.update_interval)
        {
            clearInterval(this.update_interval);
            this.update_interval = null;
        }
	},
	toggleMute:function(){
		var this_id = (this.pc!=null)?this.pc.pp.id:this.id;
		js_log('f:toggleMute');		
		if(this.muted){
			this.muted=false;
			$j('#volume_icon_'+this_id).removeClass('volume_off').addClass('volume_on');
		}else{
			this.muted=true;
			$j('#volume_icon_'+this_id).removeClass('volume_on').addClass('volume_off');
		}
	},
	fullscreen:function(){
		js_log('fullscreen not supported for this plugin type');
	},
	/* returns bool true if playing or paused, false if stooped
	 */
	isPlaying : function(){
		if(this.thumbnail_disp){
			//in stoped state
			return false;
		}else if( this.paused ){
			//paused state
			return false;
		}else{
			return true;
		}
	},
	isPaused : function(){
		return this.isPlaying() && this.paused;
	},
	isStoped : function(){
		return this.thumbnail_disp;
	},
	playlistSupport:function(){
		//by default not supported (implemented in js)
		return false;
	},
	postEmbedJS:function(){
		return '';
	},
	getPluginEmbed : function(){
		if (window.document[this.pid]){
	        return window.document[this.pid];
		}
		if (embedTypes.msie){
			return document.getElementById(this.pid );
		}else{
	    	 if (document.embeds && document.embeds[this.pid])
	        	return  document.embeds[this.pid];
		}
		return null;
	},
	//HELPER Functions for selected source	
	/*
	* returns the selected source url for players to play
	*/
	getURI : function(seek_time_sec){
		return this.media_element.selected_source.getURI( this.seek_time_sec );
	},
	supportsURLTimeEncoding: function(){
		return this.media_element.selected_source.supports_url_time_encoding;
	},
	setSliderValue: function(perc, hide_progress){
		
		//js_log('setSliderValue:'+perc+' ct:'+ this.currentTime);
		var this_id = (this.pc)?this.pc.pp.id:this.id;
		//alinment offset: 
		if(!this.mv_seeker_width)
			this.mv_seeker_width = $j('#mv_seeker_slider_'+this_id).width();				
		
		var val = Math.round( perc  * $j('#mv_seeker_'+this_id).width() - (this.mv_seeker_width*perc));
		if(val > ($j('#mv_seeker_'+this_id).width() -this.mv_seeker_width) )
			val = $j('#mv_seeker_'+this_id).width() -this.mv_seeker_width ;
		$j('#mv_seeker_slider_'+this_id).css('left', (val)+'px' );
		
		//update the playback progress bar
		if( ! hide_progress ){
			$j('#mv_seeker_' + this_id + ' .mv_playback').css("width",  Math.round( val + (this.mv_seeker_width*.5) ) + 'px' );
		}else{
			//hide the progress bar
			$j('#mv_seeker_' + this_id + ' .mv_playback').css("width", "0px");
		}
		
		//update the buffer progress bar (if available )
		if( this.bufferedPercent!=0 ){
			//js_log('bufferedPercent: ' + this.bufferedPercent);			
			if(this.bufferedPercent > 1)
				this.bufferedPercent=1;				
			$j('#mv_seeker_' + this_id + ' .mv_buffer').css("width", (this.bufferedPercent*100) +'%' );
		}else{
			$j('#mv_seeker_' + this_id + ' .mv_buffer').css("width", '0px' );
		}
		
		//js_log('set#mv_seeker_slider_'+this_id + ' perc in: ' + perc + ' * ' + $j('#mv_seeker_'+this_id).width() + ' = set to: '+ val + ' - '+ Math.round(this.mv_seeker_width*perc) );
		//js_log('op:' + offset_perc + ' *('+perc+' * ' + $j('#slider_'+id).width() + ')');
	},
	highlightPlaySection:function(options){
		js_log('highlightPlaySection');		
		var this_id = (this.pc)?this.pc.pp.id:this.id;
		var dur = this.getDuration();
		var hide_progress = true;
		//set the left percet and update the slider: 
		rel_start_sec = ( ntp2seconds( options['start']) - this.start_offset );
		
		var slider_perc=0;
		if( rel_start_sec <= 0 ){
			left_perc =0; 			
			options['start'] = seconds2ntp( this.start_offset );
			rel_start_sec=0;			
			this.setSliderValue( 0 , hide_progress);
		}else{
			left_perc = parseInt( (rel_start_sec / dur)*100 ) ;		
			slider_perc = (left_perc / 100);
		}			
		if( ! this.isPlaying() ){
			this.setSliderValue( slider_perc , hide_progress);		
		}
		
		width_perc = parseInt( (( ntp2seconds( options['end'] ) - ntp2seconds( options['start'] ) ) / dur)*100 ) ; 							
		if( (width_perc + left_perc) > 100 ){
			width_perc = 100 - left_perc; 
		}		
		//js_log('should hl: '+rel_start_sec+ '/' + dur + ' re:' + rel_end_sec+' lp:'  + left_perc + ' width: ' + width_perc);	
		$j('#mv_seeker_' + this_id + ' .mv_highlight').css({
			'left':left_perc+'%',
			'width':width_perc+'%'			
		}).show();				
		
		this.jump_time =  options['start'];
		this.seek_time_sec = ntp2seconds( options['start']);
		//trim output to 
		this.setStatus( getMsg('seek_to')+' '+ seconds2ntp( this.seek_time_sec ) );
		js_log('DO update: ' +  this.jump_time);
		this.updateThumbTime( rel_start_sec );	
	},
	hideHighlight:function(){
		var this_id = (this.pc)?this.pc.pp.id:this.id;
		$j('#mv_seeker_' + this_id + ' .mv_highlight').hide();
		this.setStatus( this.getTimeReq() );
		this.setSliderValue( 0 );
	},
	setStatus:function(value){
		var id = (this.pc)?this.pc.pp.id:this.id;
		//update status:
		$j('#mv_time_'+id).html(value);
	}	
}
/*
* utility functions:
*/
//simple url re-writer for standard temporal and size request urls: 
function getUpdateTimeURL(url, new_time, size){	
	var pSrc = parseUri(url);	
	if(pSrc.protocol != '' ){
		var new_url = pSrc.protocol +'://'+ pSrc.authority + pSrc.path +'?';       			
	}else{
		var new_url = pSrc.path +'?';      
	}	
	var amp = '';
	if(new_time && pSrc.queryKey['t'])
		pSrc.queryKey['t'] = new_time;
	
	if(size &&  pSrc.queryKey['size'])
		pSrc.queryKey['size']=size;
			
	$j.each(pSrc.queryKey, function(key, val){		
		new_url+= amp + key + '=' + val;			
		amp = '&';    	
	});
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
	mvEmbed.addLoadEvent(func);
}

//does a remote or local api request based on request url 
function do_api_req(req_param, api_url, callback){
	if(typeof req_param != 'object'){
		js_log('Error: request paramaters must be an object');
		return false;
	}
	if( !api_url){
		if(!wgServer || ! wgScriptPath){
			js_log('Error: no api url');
			return false;
		}
		
		api_url =  wgServer +((wgServer == null) ? parseUri(document.URL).host + (wgScriptPath + "/api.php") : parseUri(document.URL).host + wgScript);
		//update to api.php (if index.php was in the wgScript path): 
		api_url = api_url.replace('index.php', 'api.php');		
	}					
	//build request string: (force the format to json):	
	var req_url = api_url + '?format=json';		
	if( parseUri(document.URL).host == parseUri(api_url).host ){
		//local request do api request directly		
		$j.ajax({
			type: "POST",
			url:req_url,
			data: req_param,
            async: false,
			success:function(data){
				eval('var result_data=' + data );		
				callback(  result_data );
			}
		});
	}else{	
		//put all the values into the GET req: 	
		for(var i in req_param){
			req_url += '&' + encodeURIComponent( i ) + '=' + encodeURIComponent( req_param[i] );		
		}
		var fname = 'mycpfn_' + ( global_cb_count++ );
		_global[ fname ]  =  callback ;				
		req_url += '&callback=' + fname;								
		loadExternalJs( req_url );				
	}	
}
//do a "normal" request (should be deprecated via extending the mediaWiki API) 
function do_request(req_url, callback){	
	//pass along a unique inentifier if set
 	js_log('do request: ' + req_url);
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
//@@todo swich over to jQuery injection
function loadExternalJs(url, callback){
	//add a unquie request id to ensure fresh copies where appopriate 
	if( url.indexOf('?')==-1 ){
		url+='?'+mv_embed_urid;
	}
   	js_log('load js: '+ url);
    //if(window['$j'])
    	//have to use direct ajax call insted of $j.getScript()
    	//since you can't send "cache" option to $j.getScript()
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
	if( url.indexOf('?')==-1 ){
		url+='?'+mv_embed_urid;
	}
   js_log('load css: ' + url);
   var e = document.createElement("link");
   e.href = url;
   e.type = "text/css";
   e.rel = 'stylesheet';
   document.getElementsByTagName("head")[0].appendChild(e);
}

function getMvEmbedURL(){
	js_elements = document.getElementsByTagName("script");
	for(var i=0;i<js_elements.length; i++){		
		if( js_elements[i].src.indexOf('mv_embed.js') !=-1){
			return  js_elements[i].src;			
		}
	}
	return false;
}
//gets a unique id from the mv_embed url else returns the version number
function getMvUniqueReqId(){
	var mv_embed_url = getMvEmbedURL();
	if( mv_embed_url.indexOf('?')!=-1 ){
		return mv_embed_url.substr( mv_embed_url.indexOf('?')+1 );
	}
	return MV_EMBED_VERSION;
}
/*
 * sets the global mv_embed path based on the scripts location
 */
function getMvEmbedPath(){	
	var mv_embed_url = getMvEmbedURL();
	mv_embed_path = mv_embed_url.substr(0, mv_embed_url.indexOf('mv_embed.js'));
	//absolute the url (if relative) (if we don't have mv_embed path)
	if(mv_embed_path.indexOf('://')==-1){	
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
     /*var log_elm = document.getElementById('mv_js_log');
     if(!log_elm){
     	document.write('<div style="position:absolute;z-index:500;top:0px;left:0px;right:0px;height:150px;"><textarea id="mv_js_log" cols="80" rows="6"></textarea></div>');
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
}

