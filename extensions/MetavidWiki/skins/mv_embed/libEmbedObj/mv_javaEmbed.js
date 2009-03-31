var javaEmbed = {
	instanceOf:'javaEmbed',
    supports: {
    	'play_head':true, 
    	'pause':true, 
    	'stop':true, 
    	'fullscreen':true, 
    	'time_display':true, 
    	'volume_control':true
    },
    getEmbedHTML : function (){
		if(this.controls)
			setTimeout('document.getElementById(\''+this.id+'\').postEmbedJS()', 150);
		//set a default duration of 30 seconds: cortao should detect duration.
		return this.wrapEmebedContainer( this.getEmbedObj() );
    },
    getEmbedObj:function(){
    	if(!this.duration)this.duration=30;
		if(mv_java_iframe){
			//make sure iframe and embed path match (java security model)
			var iframe_src='';
            var src = this.media_element.selected_source.getURI();
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
			if(parseUri(mv_embed_path).host != parseUri(src).host){
				iframe_src = parseUri(src).protocol + '://'+
							parseUri(src).authority +
							mv_media_iframe_path + 'cortado_iframe.php';
				parent_domain = '&parent_domain='+parseUri(mv_embed_path).host;
			}else{
				iframe_src = mv_embed_path + 'cortado_iframe.php';
			}
			//js_log('base iframe src:'+ iframe_src);
       		iframe_src+= "?media_url=" + src + '&id=' + this.pid;
			iframe_src+= "&width=" + this.width + "&height=" + this.height;
			iframe_src+= "&duration=" + this.duration;
			iframe_src+=parent_domain;
			return '<iframe id="iframe_'+this.pid+'" width="'+this.width+'" height="'+this.height+'" '+
	                   'frameborder=0  scrolling=no marginwidth=0 marginheight=0 ' +
	                   'src = "'+ iframe_src + '"></iframe>';
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
		this.getJCE();
    },
    //get java cortado embed object
    getJCE:function(){
    	if(!mv_java_iframe){
	    	this.jce = $j('#'+this.pid).get(0);
    	}else{
    		//set via iframe refrence:
    		//(does not work even if we set window.domain on the remote iframe)
    		//this.jce =  $j('#iframe_'+this.pid).get(0).contentDocument.getElementById(this.pid);
    	}
    },
    pause:function(){
    	this.parent_pause();
        this.stop();
    },
    currentTime:function(){
    	if(typeof this.jce != 'undefined' ){
			if(typeof this.jce.getPlayPosition != 'undefined' ){
				return this.jce.getPlayPosition();
			}
		}
		return '0';
    }
}
