
var nativeEmbed = {
	instanceOf:'nativeEmbed',
	getEmbedHTML : function (){    
    	var controls_html ='';
    	js_log('embedObj control is: '+this.controls);
		if(this.controls){
			controls_html+= this.getControlsHtml('play_or_pause');
			controls_html+= this.getControlsHtml('stop');			
			//if in playlist mode get prev/next and run postEmbedJS():
			if(this.pc){
				controls_html+= this.pc.pp.getPLControls();				
			}
		}   				
		setTimeout('document.getElementById(\''+this.id+'\').postEmbedJS()', 150);
		//set a default duration of 30 seconds: cortao should detect duration. 
		return this.wrapEmebedContainer( this.getEmbedObj() )+ controls_html;   	
    },
    getEmbedObj:function(){
		return '<video " ' +
						'id="'+this.pid + '" ' + 
						'style="width:'+this.width+';height:'+this.height+';" ' +
					   	'src="'+this.src+'" >' + 						
				'</video>';
	},
	postEmbedJS:function(){
		document.getElementById(this.pid).play();
	},
	pause : function(){
		document.getElementById(this.pid).pause();
	},
	play:function(){
		if(!document.getElementById(this.pid) || this.thumbnail_disp){		
			this.parent_play();
		}else{		
			document.getElementById(this.pid).play();
		}
	}	
}