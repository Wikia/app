var javaEmbed = {    
	instanceOf:'javaEmbed',
    getEmbedHTML : function (){    
    	var controls_html ='';
    	js_log('embedObj control is: '+this.controls);
		if(this.controls){
			controls_html+= this.getControlsHtml('stop');			
			//if in playlist mode get prev/next and run postEmbedJS():
			if(this.pc){
				controls_html+= this.pc.pp.getPLControls();				
			}
			//run posEmbed
			setTimeout('document.getElementById(\''+this.id+'\').postEmbedJS()', 150);
		}   						
		//set a default duration of 30 seconds: cortao should detect duration. 
		return this.wrapEmebedContainer( this.getEmbedObj() )+ controls_html;   	
    },    
    getEmbedObj:function(){
    	if(!this.duration)this.duration=30;
		if(mv_java_iframe){			
			//make sure iframe and embed path match (java security model) 
			var iframe_src='';
			//if the src is relative add in current_url as path: 			
			if(this.src[0]=='/'){
				js_log('java: media relative path');	
				var pURL=parseUri(document.URL);		
				this.src=  pURL.protocol + '://' + pURL.authority + this.src;
			}else if(parseUri(this.src).host==this.src){
				js_log('java: media relative file');
				var pURL=parseUri(document.URL);
				this.src=  pURL.protocol + '://' + pURL.authority + pURL.directory + this.src;		
			}
			var parent_domain='';
			if(parseUri(mv_embed_path).host != parseUri(this.src).host){
				iframe_src = parseUri(this.src).protocol + '://'+
							parseUri(this.src).authority + 
							mv_media_iframe_path + 'cortado_iframe.php';
				parent_domain = '&parent_domain='+parseUri(mv_embed_path).host;
			}else{
				iframe_src = mv_embed_path + 'cortado_iframe.php';
			}			
			//js_log('base iframe src:'+ iframe_src);			
       		iframe_src+= "?media_url=" + this.src + '&id=' + this.pid;
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
				'<param name="url" value="'+this.src+'" /> ' + "\n"+
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
