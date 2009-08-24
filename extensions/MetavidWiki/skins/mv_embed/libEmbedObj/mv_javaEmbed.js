var javaEmbed = {
	instanceOf:'javaEmbed',
	iframe_src:'',
	logged_domain_error:false,
    supports: {
    	'play_head':true, 
    	'pause':true, 
    	'stop':true, 
    	'fullscreen':false, 
    	'time_display':true, 
    	'volume_control':false
    },
    getEmbedHTML : function (){
		if(this.controls)
			setTimeout('document.getElementById(\''+this.id+'\').postEmbedJS()', 150);
		//set a default duration of 30 seconds: cortao should detect duration.
		return this.wrapEmebedContainer( this.getEmbedObj() );
    },
    getEmbedObj:function(){    
    	js_log("java play url:" + this.getURI( this.seek_time_sec ));
    	//get the duration
    	this.getDuration();
    	//if still unset set to an arbitrary time 60 seconds: 
    	if(!this.duration)this.duration=60;
		if( mv_java_iframe ){
			//make sure iframe and embed path match (java security model)
			var iframe_src='';
            var src = this.getURI( this.seek_time_sec );
			//make url absolute: 
			if(src[0]=='/'){
				//js_log('java: media relative path from:'+ document.URL);
				var pURL=parseUri(document.URL);
				src=  pURL.protocol + '://' + pURL.authority + src;
			}else if(src.indexOf('://')===-1){
				//js_log('java: media relative file');
				var pURL=parseUri(document.URL);
				src=  pURL.protocol + '://' + pURL.authority + pURL.directory + src;
			}
			js_log('java media url: '+ src);
			var parent_domain='';
			//set the domain locally and for the script: 
			var doc_host = parseUri(document.location).host;
			if( doc_host ){
				js_log('set parent domain:' + doc_host);
				//set the parent domain: 
				document.domain =  doc_host;
				
				iframe_src = parseUri(src).protocol + '://'+
							parseUri(src).authority +
							mv_media_iframe_path + 'cortado_iframe.php';
				js_log('iframe source: ' + iframe_src);
				//set the domain of the script: 
				parent_domain = '&parent_domain=' + doc_host;
				
				js_log('parent_domain: ' + parent_domain);
			}else{
				iframe_src = mv_embed_path + 'cortado_iframe.php';
			}
			//js_log('base iframe src:'+ iframe_src);
       		iframe_src+= "?media_url=" + src.replace('?','%3F').replace('&','%26') + '&id=' + this.pid;
			iframe_src+= "&width=" + this.width + "&height=" + this.height;
			iframe_src+= "&duration=" + this.duration;
			iframe_src+=parent_domain;
			
			//check for the mvMsgFrame
			/*if($j('#mvMsgFrame').length == 0){
				js_log('appened mvMsgFrame');
				//add it to the dom: (sh
				$j('body').prepend( '<iframe id="mvMsgFrame" width="0" height="0" scrolling=no marginwidth=0 marginheight=0 src="#none"></iframe>' );
			}*/
			js_log("about to set iframe source and embed code");
			this.iframe_src = iframe_src;
			var embed_code = '<iframe id="iframe_' + this.pid + '" width="'+this.width+'" height="'+this.height+'" '+
	                   'frameborder="0" scrolling="no" marginwidth="0" marginheight="0" ' +
	                   'src = "'+ this.iframe_src + '"></iframe>';
	        js_log('going to embed: ' + embed_code);
			return embed_code;
		}else{
			//load directly in the page..
			// (media must be on the same server or applet must be signed)
			return ''+
			'<applet id="'+this.pid+'" code="com.fluendo.player.Cortado.class" archive="cortado-ovt-stripped_r34336.jar" width="'+this.width+'" height="'+this.height+'">	'+ "\n"+
				'<param name="url" value="'+this.media_element.selected_source.src+'" /> ' + "\n"+
				'<param name="local" value="false"/>'+ "\n"+
				'<param name="keepaspect" value="true" />'+ "\n"+
				'<param name="video" value="true" />'+"\n"+
				'<param name="audio" value="true" />'+"\n"+
				'<param name="seekable" value="true" />'+"\n"+
				'<param name="duration" value="'+this.duration+'" />'+"\n"+
				'<param name="bufferSize" value="200" />'+"\n"+
			'</applet>';
		}				
    }, 
    postEmbedJS:function(){
    	//reset logged domain error flag:
    	this.logged_domain_error = false;
    	//start monitor: 
		this.monitor();
    },
    monitor:function(){
    	if( this.getJCE() ) {    		
	   		try{	   		  	
	   			//java reads "playtime" not ogg media time.. so add the start_offset or seek_offset 
	   			//js_log(' ct: ' + this.jce.getPlayPosition() + ' so:' + this.start_offset + ' st:' + this.seek_time_sec);	   			
	    		this.currentTime = (this.seek_time_sec==0)? 
	    			this.jce.getPlayPosition() + this.start_offset :
	    			this.jce.getPlayPosition() + this.seek_time_sec ; 	    			
	    	}catch (e){
	    		///js_log('could not get time from jPlayer: ' + e);
	    	}	    		    		    	
	    }
	    //once currentTime is updated call parent_monitor 
		this.parent_monitor();
    },   
    //get java cortado embed object
    getJCE:function(){    	
    	if( ! mv_java_iframe ){
			this.jce = $j('#'+this.pid).get(0);
		}else{
			if( $j('#iframe_' + this.pid ).length > 0 )
				try{
					this.jce = $j('#iframe_' + this.pid ).get(0).contentWindow.jPlayer;
				}catch (e){
					if(!this.logged_domain_error)
						js_log("failed to grab jce we wont have time updates for java");
					this.logged_domain_error = true;
				}
			else
				return false;
		}    	
		return this.jce;
    },
    pause:function(){
    	this.parent_pause();
        this.stop();
    }
}
