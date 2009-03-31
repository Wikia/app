//any plugin specific msg:
gMsg['ogg-no-xiphqt']='You do not appear to have the XiphQT component for QuickTime. QuickTime cannot play ' + 
	'Ogg files without this component. Please ' + 
	'<a href="http://www.mediawiki.org/wiki/Extension:OggHandler/Client_download">download XiphQT</a> or choose another player.';

var quicktimeEmbed = {    
	instanceOf:'quicktimeEmbed',
	qtTimers:{},
    getEmbedHTML : function (){    
    	var controls_html ='';
    	js_log('embedObj control is: '+this.controls);
		if(this.controls){
			controls_html+= this.getControlsHtml('stop');			
			//if in playlist mode get prev/next and run postEmbedJS():
			if(this.pc){
				controls_html+= this.pc.pp.getPLControls();
				setTimeout('document.getElementById(\''+this.id+'\').postEmbedJS()', 150);
			}
		}   				
		return this.wrapEmebedContainer( this.getEmbedObj() )+ controls_html;   	
    },
    getEmbedObj:function(){
		var controllerHeight = 16; // by observation
		var extraAttribs = '';
		if ( embedTypes.playerType == 'quicktime-activex' ) {
			extraAttribs = 'classid="clsid:02BF25D5..."';
		}
		// Poll for completion
		var this_ = this;
		this.qtTimers[this.pid] = window.setInterval( this.makeQuickTimePollFunction(), 500 );
		
		return "<div><object id=" + this.pid + 
			" type='video/quicktime'" +
			" width=" + this.width  + 
			" height=" + this.height + controllerHeight  + 
			
			// See http://svn.wikimedia.org/viewvc/mediawiki?view=rev&revision=25605
			" data=" + this.hq( this.extPathUrl + '/null_file.mov' ) +
			' ' + extraAttribs + 
			">" + 
			// Scale, don't clip
			"<param name='SCALE' value='Aspect'/>" + 
			"<param name='AUTOPLAY' value='True'/>" +
			"<param name='src' value=" + mv_embed_path + 'null_file.mov' +  "/>" +
			"<param name='QTSRC' value=" + this.media_element.selected_source.getURI(this.seek_time_sec) + "/>" +
			"</object></div>";		
    },
    makeQuickTimePollFunction : function ( ) {
		var this_ = this;
		return function () {			
			var videoElt = document.getElementById( this_.pid );
			if ( videoElt ) {
				// Detect XiphQT (may throw)
				var xiphQtVersion = false, done = false;
				js_log('try quicktime: getComponent:');
				try {
					xiphQtVersion = videoElt.GetComponentVersion('imdc','XiTh', 'Xiph');
					done = true;
				} catch ( e ) {}
				js_log('done with try');
				if ( done ) {
					window.clearInterval( this_.qtTimers[this_.pid] );
					if ( !xiphQtVersion || xiphQtVersion == '0.0' ) {
						$j(this_).html(getMsg('ogg-no-xiphqt'));						
						/*var div = document.createElement( 'div' );
						div.className = 'ogg-player-options';
						div.style.cssText = 'width:' + ( params.width - 10 ) + 'px;'
						div.innerHTML = this_.getMsg( 'ogg-no-xiphqt' );
						var optionsDiv = document.getElementById( params.id + '_options_box' );
						if ( optionsDiv ) {
							elt.insertBefore( div, optionsDiv.parentNode );
						} else {
							elt.appendChild( div );
						}*/
					}
					// Disable autoplay on back button
					//this_.setParam( videoElt, 'AUTOPLAY', 'False' );
				}
			}
		};
	},
}
