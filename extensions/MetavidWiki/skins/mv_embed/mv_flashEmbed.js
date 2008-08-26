
var flashEmbed = {    
	instanceOf:'flashEmbed',
    getEmbedHTML : function (){
    	var controls_html ='';
    	js_log('embedObj control is: '+this.controls);
		if(this.controls){
			controls_html+= this.getControlsHtml('stop');			
		}
        setTimeout('document.getElementById(\''+this.id+'\').postEmbedJS()', 150);
		return this.wrapEmebedContainer( this.getEmbedObj() )+ controls_html;
    },
    getEmbedObj:function(){
    	if(!this.duration)this.duration=30;
        return '<div id="FlowPlayerAnnotationHolder"></div>'+"\n";
    },
    postEmbedJS : function()
    {
        var script = document.createElement("script");
        script.src = mv_embed_path + 'flashembed.js';
        script.type="text/javascript";
        document.getElementsByTagName("head")[0].appendChild(script);
        setTimeout('document.getElementById(\''+this.id+'\').doFlashEmbed()', 150);
    },
    doFlashEmbed : function()
    {
        var video_file = this.src;
        video_file = video_file.substring(0, video_file.search(".anx"));
        
        new flashembed("FlowPlayerAnnotationHolder",
        { src: mv_embed_path + 'FlowPlayerDark.swf', width: this.width, height: this.height, id: this.pid },
        { config: { autoPlay: false, showStopButton: false, showPlayButton: false,
           videoFile: video_file } });
    }
}
