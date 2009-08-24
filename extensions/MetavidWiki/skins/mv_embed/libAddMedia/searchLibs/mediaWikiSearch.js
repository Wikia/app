var mediaWikiSearch = function( initObj ) {		
	return this.init( initObj );
};
mediaWikiSearch.prototype = {
	init:function( initObj ){
		//init base class and inherit: 
		var baseSearch = new mvBaseRemoteSearch( initObj );
		for(var i in baseSearch){
			if(typeof this[i] =='undefined'){
				this[i] = baseSearch[i];
			}else{
				this['parent_'+i] =  baseSearch[i];
			}
		}
		//inherit the cp settings for 
	},
	getSearchResults:function(){
		//call parent: 
		this.parent_getSearchResults();
		
		var _this = this;
		this.loading=true;
		js_log('f:getSearchResults for:' + $j('#rsd_q').val() );		
		//do two queries against the Image / File / MVD namespace:
		 								
		//build the image request object: 
		var reqObj = {
			'action':'query', 			
			'generator':'search',
			'gsrsearch': encodeURIComponent( $j('#rsd_q').val() ),  
			'gsrnamespace':6, //(only search the "file" namespace (audio, video, images)
			'gsrwhat':'title',
			'gsrlimit':  this.cp.limit,
			'gsroffset': this.cp.offset,
			'prop':'imageinfo|revisions|categories',
			'iiprop':'url|mime',
			'iiurlwidth': parseInt( this.rsd.thumb_width ),
			'rvprop':'content'
		};				
		//set up the number of request: 
		this.completed_req=0;
		this.num_req=1;		
		//setup the number of requests result flag: 											
		//also do a request for page titles (would be nice if api could query both at the same time) 
		reqObj['gsrwhat']='text';
		do_api_req( {
			'data':reqObj, 
			'url':this.cp.api_url 
			}, function(data){
				//parse the return data
				_this.addResults( data);
				//_this.checkRequestDone(); //only need if we do two queries one for title one for text
				_this.loading = false;
		});			
	},	
	addResults:function( data ){	
		js_log("f:addResults");
		var _this = this		
		//check if we have 
		if( typeof data['query-continue'] != 'undefined'){
			if( typeof data['query-continue'].search != 'undefined')
				this.more_results = true;			
		}
		//make sure we have pages to iderate: 
		
		if(data.query && data.query.pages){
			for(var page_id in  data.query.pages){
				var page =  data.query.pages[ page_id ];
				//make sure the reop is shared
				if( page.imagerepository == 'shared'){
					continue;
				}
				//make sure the page is not a redirect
				if(page.revisions[0]['*'].indexOf('#REDIRECT')===0){
					//skip page is redirect 
					continue;
				}								
				//skip if its an empty or missing imageinfo: 
				if( !page.imageinfo )
					continue;
										
				this.resultsObj[page_id]={
					'titleKey'	 : page.title,
					'link'		 :page.imageinfo[0].descriptionurl,				
					'title'		 :page.title.replace(/File:|.jpg|.png|.svg|.ogg|.ogv|.oga/ig, ''),
					'poster'	 :page.imageinfo[0].thumburl,
					'thumbwidth' :page.imageinfo[0].thumbwidth,
					'thumbheight':page.imageinfo[0].thumbheight,
					'mime'		 :page.imageinfo[0].mime,
					'src'		 :page.imageinfo[0].url,
					'desc'		 :page.revisions[0]['*'],		
					//add pointer to parent search obj:
					'pSobj'		 :_this,			
					'meta':{
						'categories':page.categories
					}
				}
				
				//likely a audio clip if no poster and type application/ogg 
				//@@todo we should return audio/ogg for the mime type or some other way to specify its "audio" 
				if( ! this.resultsObj[page_id].poster && this.resultsObj[page_id].mime == 'application/ogg' ){					
					this.resultsObj[page_id].mime = 'audio/ogg';
				}
				
				this.num_results++;	
				//for(var i in this.resultsObj[page_id]){
				//	js_log('added: '+ i +' '+ this.resultsObj[page_id][i]);
				//}
			}
		}else{
			js_log('no results:' + data);
		}
	},	
	//check request done used for when we have multiple requests to check before formating results. 
	checkRequestDone:function(){
		//display output if done: 
		this.completed_req++;
		if(this.completed_req == this.num_req){
			this.loading = 0;
		}
	},	
	getImageObj:function( rObj, size, callback ){			
		if( rObj.mime=='application/ogg' )
			return callback( {'url':rObj.src, 'poster' : rObj.url } );
	
		//build the query to get the req size image: 
		var reqObj = {
			'action':'query',
			'format':'json',
			'titles':rObj.titleKey,
			'prop':'imageinfo',
			'iiprop':'url|size|mime' 
		}
		//set the width: 
		if(size.width)
			reqObj['iiurlwidth']= size.width;				 
 
		do_api_req( {
			'data':reqObj, 
			'url' : this.cp.api_url
			}, function(data){
				var imObj = {};
				for(var page_id in  data.query.pages){
					var iminfo =  data.query.pages[ page_id ].imageinfo[0];
					//store the orginal width: 				
					imObj['org_width']=iminfo.width;
					//check if thumb size > than image size and is jpeg or png (it will not scale well above its max res)				
					if( ( iminfo.mime=='image/jpeg' || iminfo=='image/png' ) &&
						iminfo.thumbwidth > iminfo.width ){ 		
						imObj['url'] = iminfo.url;
						imObj['width'] = iminfo.width;
						imObj['height'] = iminfo.height;					
					}else{					
						imObj['url'] = iminfo.thumburl;					
						imObj['width'] = iminfo.thumbwidth;
						imObj['height'] = iminfo.thumbheight;
					}
				}
				js_log('getImageObj: get: ' + size.width + ' got url:' + imObj.url);			
				callback( imObj ); 
		});
	},
	//the insert image function   
	insertImage:function( cEdit ){
		if(!cEdit)
			var cEdit = _this.cEdit;		
	},
	getEmbedHTML: function( rObj , options) {
		//set up the output var with the default values: 
		var outOpt = { 'width': rObj.width, 'height': rObj.height};
		if( options['max_height'] ){			
			outOpt.height = (options.max_height > rObj.height) ? rObj.height : options.max_height;	
			outOpt.width = (rObj.width / rObj.height) *outOpt.height;			
		}						
		var style_attr = 'style="width:' + outOpt.width + 'px;height:' + outOpt.height +'px"';
		var id_attr = (options['id'])?' id = "' + options['id'] +'" ': '';
		
		//return the html type: 
		if(rObj.mime.indexOf('image')!=-1){
			return '<img ' + id_attr + ' src="' + rObj.url  + '"' + style_attr + ' >';
		}
		var ahtml='';
		if(rObj.mime == 'application/ogg' || rObj.mime == 'audio/ogg'){
			ahtml = id_attr + 
						' src="' + rObj.src + '" ' +
						style_attr +
						' poster="'+  rObj.poster + '" '										
			if(rObj.mime.indexOf('application/ogg')!=-1){
				return '<video ' + ahtml + '></video>'; 
			}
					
			if(rObj.mime.indexOf('audio/ogg')!=-1){
				return '<audio ' + ahtml + '></audio>';
			}
		}		
		js_log('ERROR:unsupored mime type: ' + rObj.mime);
	},
	//returns the inline wikitext for insertion (template based crops for now) 
	getEmbedWikiText: function( rObj ){		
			//set default layout to right justified
			var layout = ( rObj.layout)? rObj.layout:"right"
			//if crop is null do base output: 
			if( rObj.crop == null)
				return this.parent_getEmbedWikiText( rObj );											
			//using the preview crop template: http://en.wikipedia.org/wiki/Template:Preview_Crop
			//@@todo should be replaced with server side cropping 
			return '{{Preview Crop ' + "\n" +
						'|Image   = ' + rObj.target_resource_title + "\n" +
						'|bSize   = ' + rObj.width + "\n" + 
						'|cWidth  = ' + rObj.crop.w + "\n" +
						'|cHeight = ' + rObj.crop.h + "\n" +
						'|oTop    = ' + rObj.crop.y + "\n" +
						'|oLeft   = ' + rObj.crop.x + "\n" +
						'|Location =' + layout + "\n" +
						'|Description =' + rObj.inlineDesc + "\n" +
					'}}';
	}
}