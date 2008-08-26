/* the most simple implementation used for unknown application/ogg plugin */
var genericEmbed={
	instanceOf:'genericEmbed',
    getEmbedObj:function(){
    	return '<object type="application/ogg" '+
			      'width="'+this.width+'" height="'+this.height+'" ' +
		    	  'data="' + this.src + '"></object>';
    }
} 