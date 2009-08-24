/* the most simple implementation used for unknown application/ogg plugin */
var genericEmbed={
	instanceOf:'genericEmbed',
    getEmbedHTML:function(){
    	return '<object type="application/ogg" '+
			      'width="'+this.width+'" height="'+this.height+'" ' +
		    	  'data="' + this.getURI( this.seek_time_sec ) + '"></object>';
    }
}