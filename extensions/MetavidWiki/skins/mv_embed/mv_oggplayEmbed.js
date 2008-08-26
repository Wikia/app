/*
 * oggPlay embed 
 * plugin: http://www.annodex.net/software/plugin/index.html
 * javascript refrence: http://wiki.xiph.org/index.php/OggPlayJavascriptAPI
 */
var oggplayEmbed = {
	instanceOf:'oggplayEmbed',
	pl_aqueue:Array(),
	pl_pqueue:Array(),
	start_pos:0,
	getEmbedHTML:function(){
		var controls_html='';
		//setup the interface controls if requested		
		if(this.controls){
			/*for the ogg playhead we need scriptaculus/prototype */
			//try and get the interface  
			if( this.get_interface_lib(true) ){
				js_log('interface loaded');				
				controls_html =this.getControlsHtml('all');
				controls_html+='<div style="clear:both;">';
			}else{
				//if not present, it's loading
				return 'loading interface <blink>...</blink>';
			}		
		}
		setTimeout('document.getElementById(\''+this.id+'\').postEmbedJS()', 150);
		return 	this.wrapEmebedContainer(this.getEmbedObj() ) + controls_html;
	},	
	getEmbedObj:function(){
		return '<embed type="application/liboggplay" ' +
						'id="'+this.pid + '" ' + 
					   	'src="'+this.src+'" '+
						'width="'+this.width+'" height="'+this.height+'">' + 
				'</embed>';
	},
	postEmbedJS:function(){
		 this.getOggElement();	
		 if(this.controls){				
			this.activateSlider();  
		    setTimeout('document.getElementById(\''+this.id+'\').monitor()',250);		    		
		}
		//check if in playlist mode: 
		if(this.pc){
			var plObj = this.pc.pp;
			var _this = this;
			
			//register a callback for next clip: 
			this.ogg.registerPlaylistCallback(
				{
				call:function(){document.getElementById(plObj.id).playlistNext();}
				}
			);
					
			//js_log('current pl pos:'+this.ogg.getCurrentPlaylistPosition() );
			//load up the playlist inserting on either side of the current clip
			$j.each(plObj.tracks[0].clips, function(i, clip){
				if(i < plObj.cur_clip.order){
					//js_log('insert before:'+ clip.src);
					_this.insertMovieBefore(clip.src);
				}else if(i > plObj.cur_clip.order){
					//js_log('insert after:'+ clip.src);
					_this.appendMovie(clip.src);			
				}
			});
			//js_log('current pl pos:'+this.ogg.getCurrentPlaylistPosition() );
			//js_log('current pl length:'+this.ogg.getPlaylistLength() );
			//append/insert any clips that the user added (before the ogg object was ready) 
			while(this.pl_aqueue.length!=0){				
				this.appendMovie(this.pl_aqueue.pop() );
			}
			while(this.pl_pqueue.length!=0){
				this.insertMovieBefore(this.pl_pqueue.pop() );
			}
		}		
		//update the duration
		this.getDuration();
	},
	monitor:function(){		
		if(this.ogg){			
			//js_log('state:' + this.ogg.getCurrentState());
			if(this.ogg){
				switch(this.ogg.getCurrentState()){
					//paused
					case 0:
						this.onPaused();
					break;
					//plaing
					case 1:
						this.onPlaying();				
					break;
					//finished
					case 2:
						this.onStop();
						//assume reached the end: 
						this.streamEnd();
					break;
				}
			}
		}
		if(!this.monitorTimerId ){
	        this.monitorTimerId = setInterval('document.getElementById(\''+this.id+'\').monitor()', 250);
	    }
	},
	onPlaying:function(){
        var mediaLen = this.ogg.getMovieLength();
        if( mediaLen > 0 )
        {
          // seekable media
          //as long as the user is not interacting with the playhead update:
           if(! this.userSlide){           	
        		var start_offset=this.start_offset;      
       			//if in playlist mode make sure we have the right start_offset: 
           		if(this.pc) 
           			start_offset = this.pc.pp.cur_clip.embed.start_offset;  
           			
	            var oog_position = (this.ogg.getPlayPosition()-start_offset) / this.duration;	            
	            //js_log('current pos: ' + this.ogg.getPlayPosition() + '-' +start_offset+' /'+ this.ogg.getMovieLength() + ' =' + oog_position);
	            this.setSliderValue(oog_position);	            
	            this.setStatus(this.getTimeInfo());
           }else{
           		//update info to seek to:            	
	           this.setStatus('seek to: '	+ seconds2ntp( (this.start_offset /1000)+ 
	           	 Math.round((this.sliderVal*mediaLen)/1000) ));
           }
        }else{
        	//@@todo find out if movie is buffering or live stream  
            this.setStatus(innerHTML = 'buffering<blink>...</blink>');
        }      
    },
    getTimeInfo:function(){
		return  seconds2ntp(Math.round(this.ogg.getPlayPosition() / 1000) )+ 
            	"/" + seconds2ntp(Math.round(this.duration+this.start_offset) / 1000);
    },   
    doSeek:function(v){
     	var mediaLen = this.ogg.getMovieLength();
    	js_log('seek to: '+v+' in ntp:' + seconds2ntp(Math.round( (v*mediaLen)/1000) ) );
    	var mediaLen = this.ogg.getMovieLength();
    	//usto need: this.start_offset
	    this.ogg.setPlayPosition( v*mediaLen );
	    //js_log('seeking to: '+( v*mediaLen)+ ' of ' +mediaLen );
    	this.setStatus('seeking<blink>...</blink>');
	},
   onPaused:function(){
   		//document.getElementById("PlayOrPause").value = " Play ";
   },
   onStop:function(){			   	
		if(this.controls){
		    this.setSliderValue(0);
		    this.setStatus("-:--:--/-:--:--");
		}			
		//call the stop to (reload the thumbnail) 
	    //document.getElementById("PlayOrPause").value = " Play ";
	    //document.getElementById("PlayOrPause").disabled = false;
    },  
    getDuration:function(){
    	//trust the url more than (getMovieLength) for anx content
    	if(this.parent_getDuration()==null){
    		//make sure the ogg is ready: 
    		if(!this.thumbnail_disp){
    			this.getOggElement();    			
	    		if(this.ogg){
	    			this.duration = this.ogg.getMovieLength();
	    		}else{
	    			this.duration=null;
	    		}
    		}
    	}
    	return this.duration;
    },
    getOggElement:function(){    	
    	if(document.getElementById(this.pid)){
	    	this.ogg = this.getPluginEmbed();
    	}else{
    		this.ogg=null;
    	}
    	js_log('this.ogg: '+ this.ogg);
	},
	playlistSupport:function(){
		return true;
	},
	playlistPrev:function(){
		if(this.ogg){
			this.ogg.playlistPrev();
		}
	},
	playlistNext:function(){
		if(this.ogg){
			this.ogg.playlistNext();
			//update the start_offset value:
			this.getDuration();
		}
	},
	insertMovieBefore:function(url, pos){
		if(url){
			if(this.ogg){
				if(!pos)var pos = this.ogg.getCurrentPlaylistPosition();
				this.ogg.insertMovieBefore(pos, url);
			}else{
				this.pl_pqueue.push(url);
			}
		}
	},
	//append the url if this.ogg is present else put it in the plqueue
	appendMovie:function(url){
		if(url){
			if(this.ogg){
				this.ogg.appendMovie(url);
			}else{
				this.pl_aqueue.push(url);
			}
		}
	},
	playMovieAt:function(pos){	
		this.getOggElement();	
		if(this.ogg){
			js_log('ogg.playMovieAT');
			this.ogg.playMovieAt(pos);
		}else{
			js_log('this.play');
			this.start_pos = pos;
			this.play();
		}
	},
	play:function (){
		this.getOggElement();
		if(!this.ogg || this.thumbnail_disp){
			this.parent_play();
		}else{		
			//if finished restart
			if(this.ogg.getCurrentState()==2){
				this.ogg.restart();
			//if paused:play
			}else if(this.ogg.getCurrentState()==0){
				this.ogg.play();
			}
			this.paused=false;
		}
		//update the duration
		this.getDuration();
	},
	pause:function(){
		this.ogg.pause();
	},
	stop: function(){    
		js_log('oggplay stop:' + this.thumbnail_disp);
		if(!this.thumbnail_disp){
	    	if( this.monitorTimerId != 0 )
		    {
		        clearInterval(this.monitorTimerId);
		        this.monitorTimerId = 0;
		    }	    
		    //do a full stop ( swap out the embed code) 	    
		    this.onStop();
		    this.parent_stop();
		}
    }
}