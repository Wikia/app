//native embed library:
var nativeEmbed = {
	instanceOf:'nativeEmbed',
	canPlayThrough:false,
	grab_try_count:0,
    supports: {
    	'play_head':true, 
    	'pause':true,     	
    	'fullscreen':false, 
    	'time_display':true, 
    	'volume_control':true,
    	
    	'overlays':true,
    	'playlist_swap_loader':true //if the object supports playlist functions    	
   },
    getEmbedHTML : function (){				
		var embed_code =  this.getEmbedObj();
		js_log('embed code: ' + embed_code);
		js_log("DURATION: "+ this.getDuration() );
		return this.wrapEmebedContainer( embed_code);
		
		setTimeout('$j(\'#'+this.id+'\').get(0).postEmbedJS()', 150);
    },
    getEmbedObj:function(){
    	//we want to let mv_embed handle the controls so notice the absence of control attribute
    	// controls=false results in controls being displayed: 
    	//http://lists.whatwg.org/pipermail/whatwg-whatwg.org/2008-August/016159.html    	
    	js_log("native play url:" + this.getURI( this.seek_time_sec ));
		return '<video ' +
					'id="'+this.pid + '" ' +
					'style="width:'+this.width+'px;height:'+this.height+'px;" ' +
					'width="'+this.width+'" height="'+this.height+'" '+
				   	'src="' + this.media_element.selected_source.getURI( this.seek_time_sec ) + '" ' +				   	
				   	'oncanplaythrough="$j(\'#'+this.id+'\').get(0).oncanplaythrough();return false;" ' +
				   	'onloadedmetadata="$j(\'#'+this.id+'\').get(0).onloadedmetadata();return false;" ' + 
				   	'loadedmetadata="$j(\'#'+this.id+'\').get(0).onloadedmetadata();return false;" ' +
				   	'onprogress="$j(\'#'+this.id+'\').get(0).onprogress( event );return false;" '+
				   	'onended="$j(\'#'+this.id+'\').get(0).onended();return false;" >' +
				'</video>';
	},
	//@@todo : loading progress	
	postEmbedJS:function(){		
		this.getVID();
		if(typeof this.vid != 'undefined'){
			js_log("GOT video object sending PLAY()");			
			this.vid.play();
			//this.vid.load(); //does not seem to work so well	
			setTimeout('$j(\'#'+this.id+'\').get(0).monitor()',100);		
		}else{
			js_log('could not grab vid obj trying again:' + typeof this.vid);
			this.grab_try_count++;
			if(	this.grab_count == 10 ){
				js_log(' could not get vid object after 10 tries re-run: getEmbedObj()' ) ;
				//reload the dom:
				this.grab_try_count=0;
				this.getEmbedObj();				
			}else{
				setTimeout('$j(\'#'+this.id+'\').get(0).postEmbedJS()',100);
			}			
		}		
	},	
	monitor : function(){
		//js_log('native:monitor');
		this.getVID(); //make shure we have .vid obj
		if(!this.vid){
			js_log('could not find video embed: '+this.id + ' stop monitor');
			this.stopMonitor();			
			return false;
		}		
		//don't update status if we are not the current clip (playlist leekage?) .. should move to playlist overwite of monitor? 
		if(this.pc){
			if(this.pc.pp.cur_clip.id != this.pc.id)
				return true;
		}			
		
		//update duration if not set (for now trust the getDuration more than this.vid.duration		
		this.duration = ( this.getDuration() ) ?this.getDuration() : this.vid.duration;	
				
		//update currentTime
		this.currentTime = this.vid.currentTime;
		
		//once currentTime is updated call parent_monitor 
		this.parent_monitor();												
	},	
	/*
	 * native callbacks for the video tag: 
	 */
	oncanplaythrough : function(){		
		js_log("f:oncanplaythrough start playback");		
		//start playback (we don't yet support pre-loading clips)  	
		this.play();
	},
	onloadedmetadata: function(){
		js_log('f:onloadedmetadata get duration: ' +this.vid.duration);
		//this.
	},
	onloadedmetadata: function(){
		js_log('f:onloadedmetadata metadata ready');
		//set the clip duration 
	},
	onprogress: function(e){
		this.bufferedPercent =  Math.round(e.loaded/e.total*100);
	},
	onended:function(){
		//clip "ended" 
		js_log('f:onended ');
		//stop monitor
		this.stopMonitor();
		this.stop();
	},
	stopMonitor:function(){
		if( this.monitorTimerId != 0 )
	    {
	        clearInterval(this.monitorTimerId);
	        this.monitorTimerId = 0;
	    }
	},
	pause : function(){		
		this.getVID();
		this.parent_pause(); //update interface
		if(this.vid){
			this.vid.pause();
		}
		//stop updates: 
		this.stopMonitor();
	},
	play:function(){
		this.getVID();
		this.parent_play(); //update interface
		if( this.vid ){
			this.vid.play();
			//re-start the monitor: 
			this.monitor();
		}
	},
	playMovieAt:function(order){
		js_log('f:playMovieAt '+order);
		this.play();
	},
	// get the embed vlc object 
    getVID : function (){
    	this.vid = $j('#'+this.pid).get(0);  		
    },  
    /* 
     * playlist driver      
     * mannages native playlist calls          
     */
    playlistNext:function(){
    	if(!this.pc){//make sure we are a clip
    		//
    		
    	}
    }
}