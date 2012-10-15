/*
 * The "kaltura player" embedPlayer interface for fallback h.264 and flv video format support
 */
( function( mw, $ ) {

// Called from the kdp.swf
window.jsInterfaceReadyFunc = function() {
	return true;
}

mw.EmbedPlayerKplayer = {

	// Instance name:
	instanceOf : 'Kplayer',

	// List of supported features:
	supports : {
		'playHead' : true,
		'pause' : true,
		'stop' : true,
		'timeDisplay' : true,
		'volumeControl' : true,
		'overlays' : true,
		'fullscreen' : true
	},

	// Stores the current time as set from flash player
	flashCurrentTime : 0,

	/*
	 * Write the Embed html to the target
	 */
	embedPlayerHTML : function() {
		var _this = this;

		mw.log("kPlayer:: embed src::" + _this.getSrc());
		var flashvars = {};
		flashvars.autoPlay = "true";

		var playerPath = mw.getMwEmbedPath() + 'modules/EmbedPlayer/binPlayers/kaltura-player';
		flashvars.entryId = mw.absoluteUrl( _this.getSrc() );

		// Use a relative url if the protocol is file://
		if ( mw.parseUri(document.URL).protocol == 'file') {
			playerPath = mw.getRelativeMwEmbedPath() + 'modules/EmbedPlayer/binPlayers/kaltura-player';
			flashvars.entryId = _this.getSrc();
		}

		flashvars.debugMode = "false";
		flashvars.fileSystemMode = "true";
		flashvars.widgetId = "_7463";
		flashvars.partnerId = "7463";
		flashvars.pluginDomain = "kdp3/plugins/";
		flashvars.kml = "local";
		flashvars.kmlPath = playerPath + '/config.xml';
		flashvars.sourceType = "url";
		flashvars.jsInterfaceReadyFunc = "jsInterfaceReadyFunc";

		// flashvars.host = "www.kaltura.com";
		flashvars.externalInterfaceDisabled = "false";
		flashvars.skinPath = playerPath + '/skin.swf';

		flashvars["full.skinPath"] = playerPath + '/LightDoodleskin.swf';
		var flashVarParam = '';
		$.each( flashvars, function( fKey, fVal ){
			flashVarParam += '&' + fKey + '=' + encodeURIComponent( fVal );
		} );
		
		var kdpPath = playerPath + "/kdp3.3.5.27.swf";
		
		mw.log( "KPlayer:: embedPlayerHTML" ); 
		// remove any existing pid ( if present ) 
		$( '#' + this.pid ).remove();
		
		var orgJsReadyCallback = window.jsCallbackReady;
		window.jsCallbackReady = function( playerId ){
			_this.postEmbedActions();
			window.jsCallbackReady = orgJsReadyCallback;
		};
		// attributes and params:
		flashembed( $( this ).attr('id'),
				{	
					id :				this.pid,
					src : 				kdpPath,
					height :			'100%',
					width :				'100%',
					bgcolor :			"#000000",
					allowNetworking : 	"all",
					version :			[10,0],
				},
				flashvars
		)
		
		// Flash player loses its bindings once it changes sizes::
		$(_this).bind('onOpenFullScreen', function() {
			_this.postEmbedActions();
		});
		$(_this).bind('onCloseFullScreen', function() {
			_this.postEmbedActions();
		});
	},
	
	// The number of times we have tried to bind the player
	bindTryCount : 0,
	
	/**
	 * javascript run post player embedding
	 */
	postEmbedActions : function() {
		var _this = this;
		this.getPlayerElement();
		
		if ( this.playerElement && this.playerElement.addJsListener ) {
			var bindEventMap = {
				'playerPaused' : 'onPause',
				'playerPlayed' : 'onPlay',
				'durationChange' : 'onDurationChange',
				'playerPlayEnd' : 'onClipDone',
				'playerUpdatePlayhead' : 'onUpdatePlayhead',
				'bytesTotalChange' : 'onBytesTotalChange',
				'bytesDownloadedChange' : 'onBytesDownloadedChange'
			};
			
			$.each( bindEventMap, function( bindName, localMethod ) {
				_this.bindPlayerFunction(bindName, localMethod);
			});
			this.bindTryCount = 0;
			// Start the monitor
			this.monitor();
		} else {
			this.bindTryCount++;
			// Keep trying to get the player element
			if( this.bindTryCount > 500 ){ // 5 seconds
				mw.log('Error:: KDP player never ready for bindings!');
				return ;
			}
			setTimeout(function() {
				_this.postEmbedActions();
			}, 10);
		}
	},

	/**
	 * Bind a Player Function,
	 * 
	 * Build a global callback to bind to "this" player instance:
	 * 
	 * @param {String}
	 *            flash binding name
	 * @param {String}
	 *            function callback name
	 */
	bindPlayerFunction : function(bindName, methodName) {
		// The kaltura kdp can only call a global function by given name
		var gKdpCallbackName = 'kdp_' + methodName + '_cb_' + this.id.replace(/[^a-zA-Z 0-9]+/g,'');

		// Create an anonymous function with local player scope
		var createGlobalCB = function(cName, embedPlayer) {
			window[ cName ] = function(data) {
				if ( embedPlayer._propagateEvents ) {
					embedPlayer[methodName](data);
				}
			};
		}(gKdpCallbackName, this);
		// Add the listener to the KDP flash player:
		this.playerElement.addJsListener(bindName, gKdpCallbackName);
	},

	/**
	 * on Pause callback from the kaltura flash player calls parent_pause to
	 * update the interface
	 */
	onPause : function() {
		this.parent_pause();
	},

	/**
	 * onPlay function callback from the kaltura flash player directly call the
	 * parent_play
	 */
	onPlay : function() {
		this.parent_play();
	},

	onDurationChange : function(data, id) {
		// Update the duration ( only if not in url time encoding mode:
		if( !this.supportsURLTimeEncoding() ){
			this.duration = data.newValue;
			$(this).trigger('durationchange');
		}
	},

	/**
	 * play method calls parent_play to update the interface
	 */
	play: function() {
		if ( this.playerElement && this.playerElement.sendNotification ) {
			this.playerElement.sendNotification('doPlay');
		}
		this.parent_play();
	},

	/**
	 * pause method calls parent_pause to update the interface
	 */
	pause: function() {
		if (this.playerElement && this.playerElement.sendNotification) {
			this.playerElement.sendNotification('doPause');
		}
		this.parent_pause();
	},
	/**
	 * switchPlaySrc switches the player source working around a few bugs in browsers
	 * 
	 * @param {string}
	 *            src Video url Source to switch to.
	 * @param {function}
	 *            switchCallback Function to call once the source has been switched
	 * @param {function}
	 *            doneCallback Function to call once the clip has completed playback
	 */
	switchPlaySrc: function( src, switchCallback, doneCallback ){
		var _this = this;
		var waitCount = 0;
		
		if( !src || src == this.getSrc ){
			if( switchCallback ){
				switchCallback();
			}
			setTimeout(function(){
				if( doneCallback )
					doneCallback();
			}, 100);
			return ;
		}
		
		var waitForJsListen = function( callback ){
			if(  _this.getPlayerElement() &&  _this.getPlayerElement().addJsListener ){
				callback();
			} else {
				// waited for 2 seconds fail
				if( waitCount > 20 ){
					mw.log( "Error: Failed to swtich player source");
					if( switchCallback )
						switchCallback();
					if( doneCallback )
						doneCallback();
					return;
				}
				
				setTimeout(function(){
					waitCount++;
					waitForJsListen( callback );
				},100)
			}
		};
		// wait for jslistener to be ready:
		waitForJsListen( function(){
			var gPlayerReady = 'kdp_' + _this.id + '_switchSrcReady';
			var gDoneName = 'kdp_' + _this.id + '_switchSrcEnd';
			window[gPlayerReady] = function(){
				mw.log("Kplayer switchPlaySrc: " + src);
				
				_this.getPlayerElement().sendNotification("changeMedia", { 'entryId': src } );
				_this.monitor();
				switchCallback( _this );
				
				window[ gDoneName ] = function(){
					if( doneCallback )
						doneCallback();
				};
				_this.getPlayerElement().addJsListener( 'playerPlayEnd', gDoneName);
			};
			// This is very fragile..it sucks we can't use 
			_this.getPlayerElement().addJsListener( 'playerReady', gPlayerReady );
		
		});
	},
	
	/**
	 * Issues a seek to the playerElement
	 * 
	 * @param {Float}
	 *            percentage Percentage of total stream length to seek to
	 */
	seek : function(percentage) {
		var _this = this;
		var seekTime = percentage * this.getDuration();
		mw.log( 'EmbedPlayerKalturaKplayer:: seek: ' + percentage + ' time:' + seekTime );
		if (this.supportsURLTimeEncoding()) {

			// Make sure we could not do a local seek instead:
			if (!(percentage < this.bufferedPercent
					&& this.playerElement.duration && !this.didSeekJump)) {
				// We support URLTimeEncoding call parent seek:
				this.parent_seek( percentage );
				return;
			}
		}
		// Add a seeked callback event: 
		var seekedCallback = 'kdp_seek_' + this.id + '_' + new Date().getTime();
		window[ seekedCallback ] = function(){
			_this.seeking = false;
			$( this ).trigger( 'seeked' );
			if( seekInterval  ) {
				clearInterval( seekInterval );
			}
		};
		this.playerElement.addJsListener('playerSeekEnd', seekedCallback );
		
		if ( this.getPlayerElement() ) {		
			// trigger the html5 event: 
			$( this ).trigger( 'seeking' );
			
			// Issue the seek to the flash player:
			this.playerElement.sendNotification('doSeek', seekTime);
			
			// Include a fallback seek timer: in case the kdp does not fire 'playerSeekEnd'
			var orgTime = this.flashCurrentTime;
			var seekInterval = setInterval( function(){
				if( _this.flashCurrentTime != orgTime ){
					_this.seeking = false;
					clearInterval( seekInterval );
					$( this ).trigger( 'seeked' );
				}
			}, mw.getConfig( 'EmbedPlayer.MonitorRate' ) );
			
		} else {
			// try to do a play then seek:
			this.doPlayThenSeek(percentage);
		}
		
		// Run the onSeeking interface update
		this.controlBuilder.onSeek();
	},

	/**
	 * Seek in a existing stream
	 * 
	 * @param {Float}
	 *            percentage Percentage of the stream to seek to between 0 and 1
	 */
	doPlayThenSeek : function(percentage) {
		mw.log('flash::doPlayThenSeek::');
		var _this = this;
		// issue the play request
		this.play();
	
		// let the player know we are seeking
		_this.seeking = true;
		$( this ).trigger( 'seeking' );
	
		var getPlayerCount = 0;
		var readyForSeek = function() {
			_this.getPlayerElement();
			// if we have duration then we are ready to do the seek ( flash can't
			// seek untill there is some buffer )
			if (_this.playerElement && _this.playerElement.sendNotification
					&& _this.getDuration() && _this.bufferedPercent) {
				var seekTime = percentage * _this.getDuration();
				// Issue the seek to the flash player:
				_this.playerElement.sendNotification('doSeek', seekTime);
			} else {
				// Try to get player for 20 seconds:
				if (getPlayerCount < 400) {
					setTimeout(readyForSeek, 50);
					getPlayerCount++;
				} else {
					mw.log('Error:doPlayThenSeek failed');
				}
			}
		};
		readyForSeek();
	},
	
	/**
	 * Issues a volume update to the playerElement
	 * 
	 * @param {Float}
	 *            percentage Percentage to update volume to
	 */
	setPlayerElementVolume : function(percentage) {
		if ( this.getPlayerElement() && this.playerElement.sendNotification ) {
			this.playerElement.sendNotification('changeVolume', percentage);
		}
	},
	
	/**
	 * function called by flash at set interval to update the playhead.
	 */
	onUpdatePlayhead : function( playheadValue ) {
		//mw.log('Update play head::' + playheadValue);
		this.flashCurrentTime = playheadValue;
	},
	
	/**
	 * function called by flash when the total media size changes
	 */
	onBytesTotalChange : function(data, id) {
		this.bytesTotal = data.newValue;
	},
	
	/**
	 * function called by flash applet when download bytes changes
	 */
	onBytesDownloadedChange : function(data, id) {
		mw.log('onBytesDownloadedChange');
		this.bytesLoaded = data.newValue;
		this.bufferedPercent = this.bytesLoaded / this.bytesTotal;
	
		// Fire the parent html5 action
		$( this ).trigger('progress', {
			'loaded' : this.bytesLoaded,
			'total' : this.bytesTotal
		});
	},
	
	/**
	 * Get the embed player time
	 */
	getPlayerElementTime : function() {
		// update currentTime
		return this.flashCurrentTime;
	},
	
	/**
	 * Get the embed fla object player Element
	 */
	getPlayerElement : function() {
		this.playerElement = document.getElementById( this.pid );
		return this.playerElement;
	}
};

} )( mediaWiki, jQuery );

/*
 * jQuery Tools 1.2.5 - The missing UI library for the Web
 * 
 * [toolbox.flashembed]
 * 
 * NO COPYRIGHTS OR LICENSES. DO WHAT YOU LIKE.
 * 
 * http://flowplayer.org/tools/
 * 
 * File generated: Fri Oct 22 13:51:38 GMT 2010
 */
(function(){function f(a,b){if(b)for(var c in b)if(b.hasOwnProperty(c))a[c]=b[c];return a}function l(a,b){var c=[];for(var d in a)if(a.hasOwnProperty(d))c[d]=b(a[d]);return c}function m(a,b,c){if(e.isSupported(b.version))a.innerHTML=e.getHTML(b,c);else if(b.expressInstall&&e.isSupported([6,65]))a.innerHTML=e.getHTML(f(b,{src:b.expressInstall}),{MMredirectURL:location.href,MMplayerType:"PlugIn",MMdoctitle:document.title});else{if(!a.innerHTML.replace(/\s/g,"")){a.innerHTML="<h2>Flash version "+b.version+
" or greater is required</h2><h3>"+(g[0]>0?"Your version is "+g:"You have no flash plugin installed")+"</h3>"+(a.tagName=="A"?"<p>Click here to download latest version</p>":"<p>Download latest version from <a href='"+k+"'>here</a></p>");if(a.tagName=="A")a.onclick=function(){location.href=k}}if(b.onFail){var d=b.onFail.call(this);if(typeof d=="string")a.innerHTML=d}}if(i)window[b.id]=document.getElementById(b.id);f(this,{getRoot:function(){return a},getOptions:function(){return b},getConf:function(){return c},
getApi:function(){return a.firstChild}})}var i=document.all,k="http://www.adobe.com/go/getflashplayer",n=typeof jQuery=="function",o=/(\d+)[^\d]+(\d+)[^\d]*(\d*)/,j={width:"100%",height:"100%",id:"_"+(""+Math.random()).slice(9),allowfullscreen:true,allowscriptaccess:"always",quality:"high",version:[3,0],onFail:null,expressInstall:null,w3c:false,cachebusting:false};window.attachEvent&&window.attachEvent("onbeforeunload",function(){__flash_unloadHandler=function(){};__flash_savedUnloadHandler=function(){}});
window.flashembed=function(a,b,c){if(typeof a=="string")a=document.getElementById(a.replace("#",""));if(a){if(typeof b=="string")b={src:b};return new m(a,f(f({},j),b),c)}};var e=f(window.flashembed,{conf:j,getVersion:function(){var a,b;try{b=navigator.plugins["Shockwave Flash"].description.slice(16)}catch(c){try{b=(a=new ActiveXObject("ShockwaveFlash.ShockwaveFlash.7"))&&a.GetVariable("$version")}catch(d){try{b=(a=new ActiveXObject("ShockwaveFlash.ShockwaveFlash.6"))&&a.GetVariable("$version")}catch(h){}}}return(b=
o.exec(b))?[b[1],b[3]]:[0,0]},asString:function(a){if(a===null||a===undefined)return null;var b=typeof a;if(b=="object"&&a.push)b="array";switch(b){case "string":a=a.replace(new RegExp('(["\\\\])',"g"),"\\$1");a=a.replace(/^\s?(\d+\.?\d+)%/,"$1pct");return'"'+a+'"';case "array":return"["+l(a,function(d){return e.asString(d)}).join(",")+"]";case "function":return'"function()"';case "object":b=[];for(var c in a)a.hasOwnProperty(c)&&b.push('"'+c+'":'+e.asString(a[c]));return"{"+b.join(",")+"}"}return String(a).replace(/\s/g,
" ").replace(/\'/g,'"')},getHTML:function(a,b){a=f({},a);var c='<object width="'+a.width+'" height="'+a.height+'" id="'+a.id+'" name="'+a.id+'"';if(a.cachebusting)a.src+=(a.src.indexOf("?")!=-1?"&":"?")+Math.random();c+=a.w3c||!i?' data="'+a.src+'" type="application/x-shockwave-flash"':' classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"';c+=">";if(a.w3c||i)c+='<param name="movie" value="'+a.src+'" />';a.width=a.height=a.id=a.w3c=a.src=null;a.onFail=a.version=a.expressInstall=null;for(var d in a)if(a[d])c+=
'<param name="'+d+'" value="'+a[d]+'" />';a="";if(b){for(var h in b)if(b[h]){d=b[h];a+=h+"="+(/function|object/.test(typeof d)?e.asString(d):d)+"&"}a=a.slice(0,-1);c+='<param name="flashvars" value=\''+a+"' />"}c+="</object>";return c},isSupported:function(a){return g[0]>a[0]||g[0]==a[0]&&g[1]>=a[1]}}),g=e.getVersion();if(n){jQuery.tools=jQuery.tools||{version:"1.2.5"};jQuery.tools.flashembed={conf:j};jQuery.fn.flashembed=function(a,b){return this.each(function(){$(this).data("flashembed",flashembed(this,
a,b))})}}})();
