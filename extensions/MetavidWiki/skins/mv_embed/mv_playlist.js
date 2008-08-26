/* 
 * the playlist object code 
 * only included if playlist object found
 * 
 * part of mv_embed: 
 * http://metavid.ucsc.edu/wiki/index.php/Mv_embed 
 */
 js_log('load mv_playlist');
var playlist_attributes = {
	//playlist attributes :
	"id":null,
	"title":null,
	"width":320,
	"height":240,
	"desc":'',
	"controls":true,
	//playlist user controlled features
    "linkback":null, 
	"src":null,
	"embed_link":true,
	
	//enable sequencer? (only display top frame no navigation or accompanying text
	"sequencer":false
}
//the layout for the playlist object
var pl_layout = {
	seq_title:.1,
	clip_desc:.63, //displays the clip description
	clip_aspect:1.33,  // 4/3 video aspect ratio
	seq:.25,		   	  //display clip thumbnails 
	seq_thumb:.25,	 //size for thumbnails (same as seq by default) 
	seq_nav:0	//for a nav bar at the base (currently disabled)
}
//globals:
var mv_lock_vid_updates=false;
//10 possible colors for clips: (can be in hexadecimal)
var mv_clip_colors = new Array('aqua', 'blue', 'fuchsia', 'green', 'lime', 'maroon', 'navy', 'olive', 'purple', 'red');
//the base url for requesting stream metadata 
if(typeof wgServer=='undefined'){
	var defaultMetaDataProvider = 'http://metavid.ucsc.edu/overlay/archive_browser/export_cmml?stream_name=';
}else{
	var defaultMetaDataProvider = wgServer+wgScript+'?title=Special:MvExportStream&feed_format=roe&stream_name=';
}

var mvPlayList = function(element) {		
	return this.init(element);
};
//set up the mvPlaylist object
mvPlayList.prototype = {
	pl_duration:null,
	update_tl_hook:null,
	cur_clip:null,	
	start_clip:null, 
	start_clip_src:null,
	disp_play_head:null,
	loading:true,
	external_data:true,
	init:function(element){
		js_log('init');
		//init tracks
		this.init_tracks();
		//get all the attributes:
	  	for(var attr in playlist_attributes){       
	        if(element.getAttribute(attr)){
	            this[attr]=element.getAttribute(attr);
	            //js_log('attr:' + attr + ' val: ' + video_attributes[attr] +" "+'elm_val:' + element.getAttribute(attr) + "\n (set by elm)");  
	        }else{        
	            this[attr]=playlist_attributes[attr];
	            //js_log('attr:' + attr + ' val: ' + video_attributes[attr] +" "+ 'elm_val:' + element.getAttribute(attr) + "\n (set by attr)");  
	        }
	    }
		//make sure height and width are int:
		this.width=	parseInt(this.width);
		this.height=parseInt(this.height);
		
	    //if style is set override width and height
	    if(element.style.width)this.width = parseInt(element.style.width.replace('px',''));
	    if(element.style.height)this.height = parseInt(element.style.height.replace('px',''));
	    
	   
	    //@@todo more attribute value checking: 
	    
    	//if no src is specified try and use the innerHTML as a sorce type:
    	if(!this.src){	    	
    		//no src set check for innerHTML: 
    		if(element.innerHTML==''){
    			//check if we are in IE .. (ie does not expose innerHTML for video or playlist tags) 
    			if(embedTypes.msie){
    				var bodyHTML = document.body.innerHTML;
    				var vpos = bodyHTML.indexOf(element.outerHTML);
    				if(vpos!=-1){
    					//js_log('vpose:'+vpos +' '+ element.outerHTML.length );
    					vpos= vpos+ element.outerHTML.length;
    					vclose = bodyHTML.indexOf('</'+element.nodeName+'>', vpos);
    					//js_log("found vopen at:"+vpos + ' close:'+ vclose);
    					//js_log('innerHTML:'+bodyHTML.substring(vpos, vclose));
    					this['data'] = bodyHTML.substring(vpos, vclose);
						this.external_data=false;
    				}    				
    			}
    		}else{
	    		this.data = element.innerHTML;
    			this.external_data=false;
    		}
    	}else{
    		js_log('src exists');
	        this.inner_playlist_html=element.innerHTML;
    	}
	    //get and parse the src playlist *and update the page*
	    return this;	    
	},
	//run inheritEmbedObj on every clip (we have changed the playback method) 
	inheritEmbedObj:function(){
		$j.each(this.tracks[0].clips, function(i,clip){	
			clip.embed.inheritEmbedObj();
		});
	},
	//set up the skeleton mvPlayList structure: 
	//@@todo make videoTrack a proper object 
	/*
	 * 	1:{
				title:'text track',
				desc:'primary text track',
				clips:new Array()
			}
	 */
	init_tracks:function(){
		this.tracks={
			0:{
				title:'video track',
				desc:'primary video clips track',
				//possible options, thumb, text
				disp_mode:'thumb', 
				clips:new Array()
			}		
		}
	},
	getPlaylist:function(){		
		js_log("getPlaylist: " + this.srcType );
		eval('var plObj = '+this.srcType+'Playlist;');	
   	  	//export methods from the plObj to this
   	  	for(var method in plObj){
        	//js parent preservation for local overwritten methods
        	if(this[method])this['parent_' + method] = this[method];
            this[method]=plObj[method];
        }        
        if(typeof this.doParse == 'function'){
	   	  	if( this.doParse() ){
	   	  		this.doWhenParseDone();	
	   	  	}else{
	   	  		//js_log("LINKBACK:"+ this['linkback']);
	   	  		//error or parse needs to do ajax requests	
	   	  	}
        }else{
        	js_log('error: method doParse not found in plObj');		        	
        }        
        		
	},
	doWhenParseDone:function(){
		js_log("do when parse done: "+ this.tracks[0].clips.length);
		this.loading=false;	    	
	    this.getHTML();	
	},
	getPlDuration:function(){
		//js_log("GET PL DURRATION for : "+ this.tracks[0].clips.length + 'clips');
		if(!this.pl_duration){
			durSum=0;
			$j.each(this.tracks[0].clips, function(i,clip){	
				if(clip.embed){			
					js_log('add : '+ clip.getDuration());
					durSum+=clip.getDuration();
				}else{
					js_log("ERROR: clip " +clip.id + " not ready");
				}
			});
			this.pl_duration=durSum;
		}
		return this.pl_duration;
	},
	getPlDurationNTP:function(){
		//get duration in ms and return in NTP
		return seconds2ntp(this.getPlDuration()/1000);
		//return 'wtf';
	},
	getDataSource:function(){	
		js_log("get data source");
		//determine the type / first is it m3u or xml? 	
		var pl_parent = this;
		this.makeURLAbsolute();
		js_log("src:" + this.src);
		if(this.src!=null){
			do_request(this.src, function(data){
				pl_parent.data=data;
				pl_parent.getSourceType();
			});	
		}
	},
	getSourceType:function(){
		js_log('data type of: '+ this.src + ' = ' + typeof (this.data) + "\n"+ this.data);
		this.srcType =null;
		//if not external use different detection matrix
		if(this.external_data){				
			if(typeof this.data == 'object' ){
				//object assume xml (either xspf or rss) 
				js_log('get pl tag:');
				plElm = this.data.getElementsByTagName('playlist')[0];
				if(plElm){
					if(plElm.getAttribute('xmlns')=='http://xspf.org/ns/0/'){
						this.srcType ='xspf';
					}
				}
				js_log('get rss tag:');
				//check itunes style rss "items" 
				rssElm = this.data.getElementsByTagName('rss')[0];
				if(rssElm){
					if(rssElm.getAttribute('xmlns:itunes')=='http://www.itunes.com/dtds/podcast-1.0.dtd'){
						this.srcType='itunes';
					}
				}
			}else if(typeof this.data == 'string'){
				//string
				if(this.data.indexOf('#EXTM3U')!=-1){
					this.srcType = 'm3u';
				}
			}
		}else{
			js_log("data is inline");
			//inline xml not supported:
			//if(this.data.getAttribute('xmlns')=='http://xspf.org/ns/0/'){
			//	this.srcType='xspf';
			//}else{
				//@@todo do inline version processing: 
				this.srcType='inline';
			//}		
		}
		if(this.srcType){
			js_log('is of type:'+ this.srcType);
			this.getPlaylist();
		}else{
			//unkown playlist type
			js_log('unknown playlist type?');
			if(this.src){
				this.innerHTML= 'error: unknown playlist type at url:<br> ' + this.src;
			}else{
				this.innerHTML='error: unset src or unknown inline playlist data<br>';
			}
		}			
	},	
	//simple function to make a path into an absolute url if its not already
	makeURLAbsolute:function(){		
		if(this.src){
			if(this.src.indexOf('://')==-1){
				if(this.src.charAt(0)=='/'){
					var purl = parseUri(mv_embed_path);
					this.src = purl.protocol + purl.host + this.src;
				}else{
					this.src=mv_embed_path + this.src;				
				}
			}
		}
	},	
	//@@todo needs to update for multi-track clip counts
	getClipCount:function(){
		return this.tracks[0].clips.length; 
	},	
	//},
	//takes in the playlist 
	// inherits all the properties 
	// swaps in the playlist object html/interface div	
	getHTML:function(){						
		if(this.loading){
			js_log('called getHTML (loading)');
			$j('#'+this.id).html('loading playlist<blink>...</blink>'); 
			if(this.external_data){
				//load the data source chain of functions (to update the innerHTML)   			
				this.getDataSource();  
			}else{
				//detect datatype and parse directly: 
				this.getSourceType();
			}
		}else{
			js_log('track length: ' +this.tracks[0].clips.length);''
			if(this.tracks[0].clips.length==0){
				$j(this).html('empty playlist');
				return ;	
			}
			var sh=Math.round(this.height* pl_layout.seq_title);
			var ay=Math.round(this.height* pl_layout.clip_desc);
			//var by=Math.round(this.height* pl_layout.nav);
			var cy=Math.round(this.height* pl_layout.seq);		
			var sy=Math.round(this.height* pl_layout.seq_nav);	
			
			//empty out the html and insert the container
			var cheight =(this.sequencer=='true')?this.height+27:this.height;
			$j(this).html('<div id="dc_'+this.id+'" style="border:solid thin;width:'+this.width+'px;' +
					'height:'+cheight+'px;position:relative;"></div>');

			//set up the sequence info link if present
			js_log('linkback: '+ this.linkback);
			var pl_info_link = (this.linkback)?	 
				'<span style="position:absolute;right:0px;top:0px">'+
			     '<a title="playlist linkback" target="_new" href="'+this.linkback+'">'+
			     getTransparentPng({id:'link_'+this.id, width:"27", height:"27", border:"0", 
					src:mv_embed_path + 'images/vid_info_sm.png' })+'</a></span>':'';
			var rp=0;
			if(pl_info_link!='')rp=30;
			var pl_embed_link = (this.embed_link)?
				'<span style="position:absolute;right:'+rp+'px;top:0px">'+
			     '<a id="a_eblink_'+this.id+'" title="Embed Playlist Code" ' +
			     'onclick="document.getElementById(\''+this.id+'\').showEmbedLink();return false;" href="#">'+
			     getTransparentPng({id:'eblink_'+this.id, width:"27", height:"27", border:"0", 
					src:mv_embed_path + 'images/vid_embed_sm.png' })+'</a></span>':'';
			
			//set title to 'Untitled' (if still missing) 
			if(!this.title)this.title='Untitled';			
			
			//append title container: & info /embed links
			$j('#dc_'+this.id).append('<span id="ptitle_'+this.id+'" style="height:'+sh+'px" class="pl_desc">'+				
				'</span>'+ pl_info_link + pl_embed_link);
								
			this.updateTitle();
			//check if we are in sequence mode (for seq layout don't display clips)
			js_log('seq: ' + this.sequencer);
			if(this.sequencer=='true'){ //string val
				var plObj=this;
				//append all embed details
				$j.each(this.tracks[0].clips, function(i, clip){
					$j('#dc_'+plObj.id).append('<div class="clip_container" id="clipDesc_'+clip.id+'" '+
						'style="display:none;position:absolute;text-align: center;width:'+plObj.width + 'px;'+
						'height:'+(plObj.height)+'px;'+
						'top:27px;left:0px"></div>');	
					//update the embed html: 					
					clip.embed.height=plObj.height;
					clip.embed.width=Math.round(plObj.height*pl_layout.clip_aspect);
					clip.embed.getHTML();								
					$j(clip.embed).css({ 'position':"absolute",'top':"0px", 'left':"0px"});					
					if($j('#clipDesc_'+clip.id).get(0))
						$j('#clipDesc_'+clip.id).get(0).appendChild(clip.embed);
				}); 				
				if(this.cur_clip)
					$j('#clipDesc_'+this.cur_clip.id).css({display:'inline'});		
			}else{																													
				//append all clip descriptions 
				this.getAllClipDesc();			
				//display the first clip
				$j('#clipDesc_'+this.cur_clip.id).css({display:'inline'});			
				$j('#dc_'+this.id).append('<div id="seqThumb_'+this.id+'" ' +
					'style="white-space:nowrap;position:absolute;width:'+this.width+'px;'+
					'height:'+cy + 'px;'+
					'bottom:'+Math.round(this.height* pl_layout.seq_nav)+'px;left:0px;'+
					'overflow-x:auto;overflow-y:hidden;"></div>');
				//append seq thumbnails
				this.getSeqThumb();
			}
			//append the playhead (for highlighting current sequence) 
			//this.getPlayHead();
			
			//add the default background image xiph_logo_lg_transparent.png
			//out+='<div id="'
			//js_log('set:'+ this.id+' to: ' + out);
			//this.this_elm = 
			//this_elm = document.getElementById(this.id);
			//this_elm.innerHTML=out;
			//this.innerHTML=out;
		}
	},
	updateTitle:function(){
		js_log('update title');
		$j('#ptitle_'+this.id).html(''+
			'<b>' + this.title + '</b> '+				
			this.getClipCount()+' clips,<i>'+
			this.getPlDurationNTP() + '</i>' );
	},
	/*gets adds hidden desc to the #dc container*/
	getAllClipDesc : function(){		
		//js_log("build all clip details pages");		
		//debugger;
		var ay=Math.round(this.height* pl_layout.clip_desc);		
		var plObj =this;
		$j.each(plObj.tracks[0].clips, function(i, clip){
			//js_log('clip parent pl:'+ clip.pp.id);
			//border:solid thin
			$j('#dc_'+plObj.id).append('<div class="clip_container" id="clipDesc_'+clip.id+'" '+
				'style="display:none;position:absolute;width:'+plObj.width + 'px;'+
				'height:'+ay+'px;'+
				'top:27px;left:0px"></div>');	
			clip.getDetail();
		});
	},
	getSeqThumb: function(){
		//for each clip 
		if(this.getClipCount()>3){
			pl_layout.seq_thumb=.17;
		}else{
			pl_layout.seq_thumb=.25;
		}
		$j.each(this.tracks[0].clips, function(i,n){
			//js_log('add thumb for:' + n.src);
			n.getThumb();
		});
	},
	getPlayHeadPos: function(prec_done){
		var	plObj = this;		
		var track_len = $j('#slider_'+this.id).css('width').replace(/px/, '');
		//assume the duration is static and present at .duration during playback
		var clip_perc = this.cur_clip.embed.duration / this.getPlDuration();
		var perc_offset =time_offset = 0;
		for(var i in this.tracks[0].clips){
			var clip = this.tracks[0].clips[i];
			if(this.cur_clip.id ==clip.id)break;
			perc_offset+=(clip.embed.duration /  plObj.getPlDuration());
			time_offset+=clip.embed.duration;
		} 		
		//run any update time line hooks:		
		if(this.update_tl_hook){	
			var cur_time_ms = time_offset + Math.round(this.cur_clip.embed.duration*prec_done);
			if(typeof update_tl_hook =='function'){
				this.update_tl_hook(cur_time_ms);
			}else{
				//string type passed use eval: 
				eval(this.update_tl_hook+'('+cur_time_ms+');');
			}
		}
		
		//handle offset hack @@todo fix so this is not needed:
		if(perc_offset > .66)
			perc_offset+=(8/track_len);
		//js_log('perc:'+ perc_offset +' c:'+ clip_perc + '*' + prec_done + ' v:'+(clip_perc*prec_done));
		return perc_offset + (clip_perc*prec_done);
	},
	//attempts to load the embed object with the playlist
	loadEmbedPlaylist: function(){
		//js_log('load playlist');
	},
	//called when the plugin advances to the next clip in the playlist
	playlistNext:function(){
		js_log('pl advance');
		this.cur_clip=this.getClip(1);
	},
	next: function(){		
		//advance the playhead to the next clip			
		var next_clip = this.getClip(1);
		if(this.cur_clip.embed.playlistSupport()){
			//do next clip action on start_clip embed cuz its the one being displayed: 
			this.start_clip.embed.playlistNext();
			this.cur_clip=next_clip;					
		}else{
			js_log('do next');								
			this.switchPlayingClip(next_clip);
		}		
	},
	prev: function(){
		//advance the playhead to the previous clip			
		var prev_clip = this.getClip(-1);
		if(this.cur_clip.embed.playlistSupport()){
			this.start_clip.embed.playlistPrev();
			this.cur_clip=prev_clip;	
		}else{			
			js_log('do prev');										
			this.switchPlayingClip(prev_clip);
		}		
	},
	switchPlayingClip:function(new_clip){
		//swap out the existing embed code for next clip embed code
		$j('#mv_ebct_'+this.id).empty();
		new_clip.embed.width=this.width;
		new_clip.embed.height=this.height;
		//js_log('set embed to: '+ new_clip.embed.getEmbedObj());
		$j('#mv_ebct_'+this.id).html( new_clip.embed.getEmbedObj() );
		this.cur_clip=new_clip;
		//run js code: 
		this.cur_clip.embed.pe_postEmbedJS();
	},
	//playlist play
	play:function(){
		var plObj=this;
		js_log('pl play');
		//update cur clip based if sequence playhead set: 
			
		this.start_clip = this.cur_clip;		
		this.start_clip_src= this.cur_clip.src;
		//load up the ebmed object with the playlist (if it supports it) 
		if(this.cur_clip.embed.playlistSupport() ){
			this.cur_clip.embed.playMovieAt(this.cur_clip.order);
		}else{
			//play cur_clip			
			this.cur_clip.embed.play();		
		}

	},
	//wrappers for call to pl object to current embed obj
	play_or_pause:function(){		
		this.start_clip.embed.play_or_pause();
	},
	fullscreen:function(){
		this.start_clip.embed.fullscreen();
	},
	//playlist stops playback for the current clip (and resets state for start clips)
	stop:function(){
		js_log("pl stop:"+ this.start_clip.id + ' c:'+this.cur_clip.id);
		//if start clip 
		if(this.start_clip.id!=this.cur_clip.id){
			//restore clipDesc visibility & hide desc for start clip: 
			$j('#clipDesc_'+this.start_clip.id).html('');
			this.start_clip.getDetail();
			$j('#clipDesc_'+this.start_clip.id).css({display:'none'});
			this.start_clip.setBaseEmbedDim(this.start_clip.embed);
			//equivalent of base stop
			$j('#'+this.start_clip.embed.id).html(this.start_clip.embed.getThumbnailHTML());
			this.start_clip.embed.thumbnail_disp=true;
		}
		//empty the play-back container
		$j('#mv_ebct_'+this.id).empty();
		//set the current clip desc to visable:
		$j('#clipDesc_'+this.cur_clip.id).css({display:'inline'});
		
		//do an animated stop of the current clip
		this.cur_clip.embed.stop();
	},
	//ads colors/dividers between tracks
	colorPlayHead: function(){
		//total duration:		
		var pl_duration = this.getPlDuration();
		var track_len = $j('#slider_'+this.id).css('width').replace(/px/, '');
		var cur_pixle=0;
		
		//set up plObj
		var plObj = this;
		//js_log("do play head total dur: "+pl_duration );
		$j.each(this.tracks[0].clips, function(i, clip){
			var perc = (clip.embed.getDuration() / pl_duration );
			pwidth = Math.round(perc*track_len);
			//do div border-1 from pixle to current pixle
			$j('#slider_'+plObj.id).append('<div style="' +
					'position:absolute;' + 
					'left:'+cur_pixle +'px;'+
					'width:'+pwidth + 'px;'+
					'height:4px;'+
					'top:0px;'+
					'z-index:1;'+
					'border:solid thin;' +
					'filter:alpha(opacity=40);'+
					'-moz-opacity:.40;'+
					'background:'+clip.getColor()+'"></div>');			
			//put colors on top of playhead/track						
			//js_log('offset:' + cur_pixle +' width:'+pwidth+' add clip'+ clipID + 'is '+clip.embed.getDuration()+' = ' + perc +' of ' + track_len);
			cur_pixle+=pwidth;						
		});
				
		//$j('#dc_'+this.id).append('');
	},
	setUpHover:function(){
		js_log('Setup Hover');
		//set up hover for prev,next 
		var th = 50;
		var tw = th*pl_layout.clip_aspect;
		var plObj = this;
		$j('#mv_prev_link_'+plObj.id+',#mv_next_link_'+plObj.id).hover(function() {
		  	var clip = (this.id=='mv_prev_link_'+plObj.id)?
		  		plObj.getClip(-1):plObj.getClip(1);
		  	//get the position of #mv_perv|next_link:
  			var loc = getAbsolutePos(this.id);
		  	//js_log('Hover: x:'+loc.x + ' y:' + loc.y + ' :'+clip.img);
		   	$j("body").append('<div id="mv_Athub" style="position:absolute;' +
	   			'top:'+loc.y+'px;left:'+loc.x+'px;width:'+tw+'px;height:'+th+'px;">'+
				'<img style="border:solid 2px '+clip.getColor()+';position:absolute;top:0px;left:0px;" width="'+tw+'" height="'+th+'" src="'+clip.img+'"/>'+
			'</div>');
      }, function() {
      		$j('#mv_Athub').remove();
      });     
	},
	//returns a clip. If offset is out of bound returns first or last clip
	getClip: function(clip_offset){		
		if(!clip_offset)clip_offset=0;		
		//idorate through clips for this.cur_clipID (more complicated to allow for id of clips
		var cov = this.cur_clip.order + clip_offset;
		var cmax = this.getClipCount()-1;
		//js_log('cov:'+cov +' cmax:'+ cmax);
		if( cov >= 0 && cov <= cmax ){
			return this.tracks[0].clips[cov]
		}else{
			if(cov<0)return this.tracks[0].clips[0];
			if(cov>cmax)return this.tracks[0].clips[cmax];
		}
	},
	addCliptoTrack: function(clipObj, pos){
		js_log('add clip' + clipObj.id +' to track');
		if(clipObj.order==0){
			if(!this.cur_clip)this.cur_clip=clipObj;
		}
		this.tracks[0].clips.push(clipObj);
	},
	swapClipDesc: function(req_clipID, callback){
		//hide all but the requested
		var plObj=this;
		js_log('r:'+req_clipID+' cur:'+plObj.id);
		if(req_clipID==plObj.cur_clip.id){
			js_log('no swap to same clip');
		}else{
			//fade out clips
			req_clip=null;
			$j.each(this.tracks[0].clips, function(i, clip){
				if(clip.id!=req_clipID){
					//fade out if display!=none already
					if($j('#clipDesc_'+clip.id).css('display')!='none'){
						$j('#clipDesc_'+clip.id).fadeOut("slow");
					}
				}else{
					req_clip =clip;
				}
			});
			//fade in requested clip *and set req_clip to current
			$j('#clipDesc_'+req_clipID).fadeIn("slow", function(){
					plObj.cur_clip = req_clip;
					if(callback)
						callback();
			});		
		}
	},
	//display the embed code
	showEmbedLink: function(){
		//js_log('do show embed link');		
		var topOffset = (pl_layout.seq_title*this.height)-2;
		//make sure the parent is relativly positioned:
		$j('#'+this.id).css('position', 'relative');
		//fade in a black bg div ontop of everything
		var embed_code = '<div id="blackbg_'+this.id+'" ' +
			'style="position:absolute;display:none;z-index:2;background:black;top:'+topOffset+'px;left:0px;' +
			'height:'+parseInt(this.height-topOffset+2)+'px;width:'+parseInt(this.width+2)+'px;">' +
				'<span style="position:relative;top:20px;left:20px">' +
					'<b style="color:white">Playlist Embed Code:</b><br>'+
					'<textarea onClick="this.select();" style="width:'+parseInt(this.width*.75)+'px" rows="4" cols="30">'+
						'&lt;script type=&quot;text/javascript&quot; '+
						'src=&quot;'+mv_embed_path+'mv_embed.js&quot;&gt;&lt;/script&gt '+"\n" + 
						'&lt;playlist id=&quot;'+this.id+'&quot; ';
						if(this.src){
							embed_code+='src=&quot;'+this.src+'&quot; /&gt;';
						}else{
							embed_code+='&gt;'+"\n";
							embed_code+= this.data.htmlEntities();
							embed_code+='&lt;playlist/&gt;';
						}						
					embed_code+='</textarea><br>'+
					'<a href="#" style="color:white" onClick="document.getElementById(\''+this.id+'\').closeEmbedLink();return false;">close</a>'+
				'</span>'+
			'</div>';
		js_log("append to:"+ this.id  + ' c:'+embed_code);
		$j('#'+this.id).append(embed_code);
		$j('#blackbg_'+this.id).fadeIn("slow");
		//update the embed link to close		
		var dp	='document.getElementById(\''+this.id+'\')';
		$j('#a_eblink_'+this.id).get(0).setAttribute('onclick',dp+'.closeEmbedLink();return false;');		
		//js_log('update onclick:'+$j('#a_eblink_'+this.id).get(0).getAttribute('onclick')) ;
		return false; //onclick action return false
	},
	closeEmbedLink:function(){
		js_log('close embed link');
		plObj = this;
		$j('#blackbg_'+this.id).fadeOut("slow", function(){
			$j('#blackbg_'+plObj.id).remove();
		}); 
		//update the embed link to open
		var dp	='document.getElementById(\''+this.id+'\')';
		$j('#a_eblink_'+this.id).get(0).setAttribute('onclick', dp+'.showEmbedLink();return false;');
		return false;//onclick action return false
	},
	getPLControls: function(){
		js_log('getPL cont');
		return 	'<a id="mv_prev_link_'+this.id+'" title="Previus Clip" onclick="document.getElementById(\''+this.id+'\').prev();return false;" href="#">'+
					getTransparentPng({id:'mv_prev_btn_'+this.id,style:'float:left',width:'27', height:'27', border:"0", 
						src:mv_embed_path+'images/vid_prev_sm.png' }) + 
				'</a>'+
				'<a id="mv_next_link_'+this.id+'"  title="Next Clip"  onclick="document.getElementById(\''+this.id+'\').next();return false;" href="#">'+
					getTransparentPng({id:'mv_next_btn_'+this.id,style:'float:left',width:'27', height:'27', border:"0", 
						src:mv_embed_path+'images/vid_next_sm.png' }) + 
				'</a>';		
	}
}	
var gclipFocus=null;
//delay the swap by .2 seconds
function mvSeqOver(clipID,playlistID){
	setTimeout('doMvSeqOver(\''+clipID+'\',\''+playlistID+'\')', 200);
	gclipFocus=clipID;
}
function mvSeqOut(){
	gclipFocus=null;
}
function doMvSeqOver(clipID, playlistID){
	if(!mv_lock_vid_updates){
		if(gclipFocus==clipID){
			plElm = document.getElementById(playlistID);
			//js_log("got playlist by id: "+ plElm.id);
			if(plElm)plElm.swapClipDesc(clipID);
		}
	}
}
/* Object Stubs: 
 * 
 * @videoTrack ... stores clips and layer info
 * 
 * @clip... each clip segment is a clip object. 
 * */
var mvClip = function(o) {	
	if(o)this.init(o);
	return this;
};
//set up the mvPlaylist object
mvClip.prototype = {
	id:null, //clip id
	pp:null, // parent playlist
	order:null, //the order/array key for the current clip
	src:null,
	info:null,
	title:null,
	mvclip:null,
	type:null,
	img:null,
	duration:null,
	loading:false,
	isAnimating:false,
	init:function(o){		
		//init object including pointer to parent
		for(var i in o){
			//js_log('clip init vars: '+ i + ' ' + o[i]);
			this[i]=o[i];
		};		
	},
	//setup the embed object:
	setUpEmbedObj:function(){
		//init:
		this.embed=null;
		
		js_log('setup embed for clip '+ this.id); 
		//set up the pl_mv_embed object:
		var init_pl_embed={id:'e_'+this.id,
			pc:this, //parent clip
			src:this.src};
			
		this.setBaseEmbedDim(init_pl_embed);
		//always display controls for playlists: 
		
		//if in sequence mode hide controls / embed links 		
		//			init_pl_embed.play_button=false;
		init_pl_embed.controls=true;	
		if(this.pp.sequencer=='true'){
			init_pl_embed.embed_link=null;	
			init_pl_embed.linkback=null;	
		}else{						
			//set optional values if present
			if(this.linkback)init_pl_embed.linkback=this.linkback;
			if(this.pp.embed_link)init_pl_embed.embed_link=true;
		}
		if(this.img)init_pl_embed['thumbnail']=this.img;
		this.embed = new PlMvEmbed(init_pl_embed);		
		js_log('type of embed:' + typeof(this.embed) + 'seq:' + this.pp.sequencer+' pb:'+ this.embed.play_button);
	},
	//returns the mvClip representation of the clip ie stream_name?start_time/end_time
	getMvClip:function(){
		if(this.mvclip)return this.mvclip;
		return false;
	},
	//@@todo group all remote data requests
	//set src and image & title & desc from metavid source data 
	getRemoteData:function(callback){
		var thisClip =this;	
		//check for mvclip type:	
		if(thisClip.mvclip){
			thisClip.loading=true;
			if(!thisClip.mvMetaDataProvider){
				thisClip.mvMetaDataProvider = defaultMetaDataProvider;
			}
			//get xml data to resolve location of the media, desc + caption data
			var url = thisClip.mvMetaDataProvider +	this.mvclip.replace(/\?/, "&");			
			
			do_request(url, function(data){
				//ajax return (done loading) 
				thisClip.loading=false;
				//search for and set video src:
				js_log('data:'+data);
				$j.each(data.getElementsByTagName('video'), function(inx,n){	
					if(n.getAttribute('default')=='true'){
						thisClip.src=n.getAttribute('src');						
					};
				});				
				js_log('set src: '+ thisClip.src);
				
				//idorate through top head nodes: 			
				$j.each(data.getElementsByTagName('head')[0].childNodes, function(inx,n){
					//js_log('node:'+ n.nodeName+ ' inx:'+inx);
					if(!thisClip.title){
						if(n.nodeName.toLowerCase()=='title'){
							thisClip.title = n.textContent;
						}
					}
					//search for and set linkback: 
					if(!thisClip.linkback){							
						if(n.nodeName.toLowerCase()=='link' && n.getAttribute('type')=='text/html'){
							thisClip.linkback=n.getAttribute('href');
						};
					}
					//search for and set img:
					if(!thisClip.img){
						if(n.nodeName.toLowerCase()=='img'){
							thisClip.img=n.getAttribute('src');
						};
					}
				});
				js_log('set title to: ' + thisClip.title + "\n"+
					   'set linkback to: '+ thisClip.linkback + "\n"+
					   'set img to: ' + thisClip.img);
																				
				//now build the desc (if not already set) 
				if(!thisClip.desc){
					thisClip.desc='';
					$j.each(data.getElementsByTagName('clip'), function(inx,n){						
						if(n.getElementsByTagName('desc').length!=0){
							for(i=0;i< n.getElementsByTagName('desc').length; i++){
								thisClip.desc += n.getElementsByTagName('desc')[i].textContent + '<br>';
							}
						}
						if(n.getElementsByTagName('meta').length!=0){
							for(i=0;i<n.getElementsByTagName('meta').length;i++){
								if( n.getElementsByTagName('meta')[i].getAttribute('name')=='Person'){
									thisClip.desc+='<i>'+n.getElementsByTagName('meta')[i].getAttribute('content') + '</i><br>';
								}
							}
						}
					});
				}								
				//set up the embed object for this clip: 
				thisClip.setUpEmbedObj();	
				
				//check if we are in callbackmode or clip batch load
				js_log('callback: '+ callback);
				if(typeof callback!='undefined'){
					callback();
				}else{				
					//check if the rest of the clips are done loading
					//  if so call doWhenParseDone
					var parseDone=true;
					$j.each(thisClip.pp.tracks[0].clips, function(i,clip){
						if(clip.loading==true)
							parseDone=false;
					});		
					if(parseDone){
						js_log('parse done for:' + thisClip.pp.tracks[0].clips.length);
						//re-order clips based on clip.order: 
						function sortClip(cA,cB){return cA.order-cB.order;}
						thisClip.pp.tracks[0].clips.sort(sortClip);
						//set the current clip to the first clip: 
						thisClip.pp.cur_clip = thisClip.pp.tracks[0].clips[0];
						thisClip.pp.doWhenParseDone();
					}
				}
			});		
		}
		
	},
	doAdjust:function(side, delta){
		if(this.embed){
			if(this.src.indexOf('?')!=-1){
				var base_src = this.src.substr(0,this.src.indexOf('?'));
				js_log("delta:"+ delta);
				if(side=='start'){
					//since we adjust start invert the delta: 
					var start_offset =parseInt(this.embed.start_offset/1000)+parseInt(delta*-1);
					this.src = base_src +'?t='+ seconds2ntp(start_offset) +'/'+ this.embed.end_ntp;							
				}else if(side=='end'){
					//put back into seconds for adjustment: 
					var end_offset = parseInt(this.embed.start_offset/1000) + parseInt(this.embed.duration/1000) + parseInt(delta);
					this.src = base_src +'?t='+ this.embed.start_ntp +'/'+ seconds2ntp(end_offset);
				}
				js_log('new src:'+this.src);
				this.embed.updateVideoSrc(this.src);
				//update values
				this.duration = this.embed.getDuration();
				this.pp.pl_duration=null;
				//update playlist stuff:
				this.pp.updateTitle();
			}
		}
	},	
	getDuration:function(){
		//return duration if clips already has duration
		if(this.duration)return this.duration;
		if(!this.embed)this.setUpEmbedObj();
		return this.embed.getDuration();
	},
	setBaseEmbedDim:function(o){
		if(!o)o=this;
		o.height=Math.round(pl_layout.clip_desc*this.pp.height)-2;//give it some padding:
		o.width=Math.round(o.height*pl_layout.clip_aspect)-2;		
	},	
	/*doRestoreEmbed:function(){
		//set the th and tw for the 
		this.setBaseEmbedDim(this.embed);		
		//call the appropriate stop to restore the thumbnail
		if(this.embed['parent_stop']){
			this.embed.parent_stop();
		}else{
			this.embed.pe_stop();
		}
	},*/
	//output the detail view:
	//@@todo
	getDetail:function(){
		//js_log('get detail:' + this.pp.title);
		var th=Math.round(pl_layout.clip_desc*this.pp.height);	
		var tw=Math.round(th*pl_layout.clip_aspect);		
		
		var twDesc = (this.pp.width-tw)-2;
		
		if(this.title==null)
			this.title='clip ' + this.order + ' ' +this.pp.title;
		if(this.desc==null)
			this.desc=this.pp.desc;
		//update the embed html: 
		this.embed.getHTML();
					
		$j(this.embed).css({ 'position':"absolute",'top':"0px", 'left':"0px"});
		
		//js_log('append child to:#clipDesc_'+this.id);
		if($j('#clipDesc_'+this.id).get(0)){
			$j('#clipDesc_'+this.id).get(0).appendChild(this.embed);
			
			$j('#clipDesc_'+this.id).append(''+
			'<div id="pl_desc_txt_'+this.id+'" class="pl_desc" style="position:absolute;left:'+(tw+2)+'px;width:'+twDesc+'px;height:'+th+'px;overflow:auto;">'+
					'<b>'+this.title+'</b><br>'+			
					this.desc + '<br>' + 
					'<b>clip length:</b> '+ this.embed.getDurationNTP()+ 
			'</div>');		
		}
	},
	getThumb:function(){
		var out='';
		//if we have the parent playlist grab it to get the image scale 
		if(this.pp){
			//js_log('pl height:' + this.pp.height + ' * ' +  pl_layout.seq);
			var th = Math.round(this.pp.height * pl_layout.seq_thumb);
			//assume standard 4 by 3 video thumb res:
			var tw = Math.round(th*pl_layout.clip_aspect);
			//js_log('set by relative position:'+ th + ' '+tw);
		}					
		var img = this.getClipImg();
		
		out+='<span ';
		if(this.title)out+='title="'+this.title+'" ';
		out+='style="position:relative;display:inline;padding:2px;" ';
		out+='onclick="document.getElementById(\''+this.pp.id+'\').play()" ';
		out+='onmouseover="mvSeqOver(\''+this.id+'\',\''+this.pp.id+'\')" ';
		out+='onmouseout="mvSeqOut()" ';
		out+='>';
		out+='<img style="border:solid 2px '+this.getColor()+'" height="'+th+'" width="'+tw+'" src="'+img+'"></span>';
	
		$j('#seqThumb_'+this.pp.id).append(out);
	},
	getClipImg:function(start_offset, size){	
		//if its a metavid image (grab the requested size)
		if(!this.img){
			return mv_default_thumb_url; 
		}else{
			if(!size && !start_offset){			
				return this.img;
			}else{
				//if a metavid image (has request parameters) use size and time args
				if(this.img.indexOf('?')!=-1){
					js_log('get with offset: '+ start_offset);
					var time = seconds2ntp( start_offset+ (this.embed.start_offset/1000) );
					js_log("time is: " + time);
					this.img = this.img.replace(/t\=[^&]*/gi, "t="+time);
					if(this.img.indexOf('&size=')!=-1){
						this.img = this.img.replace(/size=[^&]*/gi, "size="+size);
					}else{
						this.img+='&size='+size;
					}
				}
				return this.img;
				
			}
		}
	},
	getColor: function(){
		//js_log('get color:'+ num +' : '+  num.toString().substr(num.length-1, 1) + ' : '+colors[ num.toString().substr(num.length-1, 1)] );
		var num = this.id.substr( this.id.length-1, 1);
		if(!isNaN(num)){
			num=num.charCodeAt(0);
		}
		if(num >= 10)num=num % 10;
		return mv_clip_colors[num];
	}
}
/* mv_embed extensions for playlists */
var PlMvEmbed=function(vid_init){
	//js_log('PlMvEmbed: '+ vid_init.id);	
	//create the div container
	ve = document.createElement('div');
	//extend ve with all this 
	this.init(vid_init);	
	for(method in this){
		if(method!='readyState'){			
			ve[method]= this[method];
		}
	}
	return ve;
}
//all the overwritten and new methods for playlist extension of mv_embed
PlMvEmbed.prototype = {	
	init:function(vid_init){				
		//send embed_video a created video element: 
		ve = document.createElement('div');
		for(i in vid_init){		
			//set the parent clip pointer: 	
			if(i=='pc'){
				this['pc']=vid_init['pc'];
			}else{
				ve.setAttribute(i,vid_init[i]);
			}
		}
		var videoInterface = new embedVideo(ve);	
		//js_log('created Embed Video');
		//inherit the videoInterface
		for(method in videoInterface){			
			if(method!='style'){
				if(this[method]){
					//perent embed method preservation:
					this['pe_'+method]=videoInterface[method];	
				}else{
					this[method]=videoInterface[method];
				}
			}
		}
	},
	stop:function(){
		//set up connivance pointer to parent playlist
		var plObj = this.pc.pp;
		var plEmbed = this;					
		
		//now animate rezie back to small size:
		js_log('do stop');
		var th=Math.round(pl_layout.clip_desc*plObj.height);	
		var tw=Math.round(th*pl_layout.clip_aspect);
		//run the parent stop:
		this.pe_stop();
		var pl_height = (plObj.sequencer=='true')?plObj.height+27:plObj.height;
		//restore control offsets: 		
		if(this.pc.pp.controls){
			$j('#dc_'+plObj.id).animate({
				height:pl_height
			},"slow");
		}		
		if(plObj.sequencer=='true'){			
			plEmbed.getHTML();
		}else{
			//fade in elements
			$j('#big_play_link_'+this.id+',#lb_'+this.id+',#le_'+this.id+',#seqThumb_'+plObj.id+',#pl_desc_txt_'+this.pc.id).fadeIn("slow");	
			//animate restor of resize 
			var res ={};
			this.pc.setBaseEmbedDim(res);
			//debugger;
			$j('#img_thumb_'+this.id).animate(res,"slow",null,function(){
				plEmbed.pc.setBaseEmbedDim(plEmbed);
				plEmbed.getHTML();
				//restore the detail
				$j('#clipDesc_'+plEmbed.pc.id).empty();
				plEmbed.pc.getDetail();
				//$j('#seqThumb_'+plObj.id).css({position:'absolute',bottom:Math.round(this.height* pl_layout.seq_nav)});
				//$j('#'+plEmbed.id+',#dc_'+plEmbed.id).css({position:'absolute', zindex:0,width:tw,height:th});		
			});
		}
	},
	play:function(){
		js_log('pl eb play');
		var plEmbed = this;
		var plObj = this.pc.pp;	
		//check if we are already playing
		if(!this.thumbnail_disp){
			plEmbed.pe_play();	
			return '';
		}
		mv_lock_vid_updates=true; 
		//if we have controls expand dc so we can display them 
		if(plObj.controls){
			$j('#dc_'+plObj.id).animate({
				height:(parseInt(plObj.height)+80)
			},"slow");
		}
		js_log('controls: '+plObj.controls);
		//fade out interface elements
		$j('#big_play_link_'+this.id+',#seqThumb_'+plObj.id+',#pl_desc_txt_'+this.pc.id).fadeOut("slow");		
		js_log('got here in play');
		$j('#'+this.id+',#dc_'+this.id).css({
			position:'absolute', zindex:5,
			width:plObj.width,
			height:plObj.height
		});		
		$j('#img_thumb_'+this.id).animate({
			height:plObj.height,
			width:plObj.width
		},"slow",null,function(){
			//set the parent properties: 
			plEmbed.height=plObj.height;
			plEmbed.width=plObj.width;
			plEmbed.pe_play();						
		});	
	},
	//do post interface operations
	postEmbedJS:function(){		
		//add playlist clips (if plugin supports it) 
		if(this.pc.pp.cur_clip.embed.playlistSupport())
			this.pc.pp.loadEmbedPlaylist();
		//color playlist points (if play_head present)
		if(this.pc.pp.disp_play_head)
			this.pc.pp.colorPlayHead();
		//setup hover images (for playhead and next/prev buttons)
		this.pc.pp.setUpHover();
		//call the parent postEmbedJS
	 	this.pe_postEmbedJS();
	 	mv_lock_vid_updates=false;
	},
	getPlayButton:function(){
		return this.pe_getPlayButton(this.pc.pp.id);
	},
	//overide getControlsHTML for playlists: 
	getControlsHtml:function(type){
		switch(type){
			case 'all':
				//get all the normal embed control objects and add playlist specific before info
				return 	this.getControlsHtml('play_head') +					
						this.getControlsHtml('play_or_pause') + 
						this.getControlsHtml('stop') + 
						this.getControlsHtml('fullscreen') + 											
						//get playlist specific controls
						this.pc.pp.getPLControls()+
						this.getControlsHtml('info_span');
			break;
			case 'play_head':
				this.pc.pp.disp_play_head=true;
				return this.pe_getControlsHtml(type);
				//use style for bg (to use paths
				/*return '<div id="slider_'+this.pc.pp.id+'" class="mv_track" ' +
						'style="z-index:5;background: url('+mv_embed_path+'images/bd-gray.gif);' +
						'width:'+(this.width)+'px; height:4px;">'+
					'<div id="playhead_'+this.pc.pp.id+'" class="mv_playhead" style="' +
					'z-index:5;background:url(\''+mv_embed_path+'images/slider_handle.gif\');">' +
						//'<div id="playhead_img_'+this.pc.pp.id+'" style="position:relative;z-index:5;top:0px;left:8px;width:17px;height:21px;' +
						//	'background:url(\''+mv_embed_path+'images/slider_handle.gif\');"></div>' + 
					'</div>'+
				'</div>';*/
			break;
			default:
				return this.pe_getControlsHtml(type);
			break;
		}		
	}, 
	setStatus:function(value){		
		var plObj = this.pc.pp;	
		//js_log('set status:'+ value);
		var pl_value='On clip ' + (plObj.cur_clip.order+1) + ' of ' + plObj.getClipCount() + '<br>';
		this.pe_setStatus(pl_value + value);
	},
	setSliderValue:function(value){		
		var sliderVal = this.pc.pp.getPlayHeadPos(value);		
		//js_log('set slider value:c:'+this.id+' v:'+ value + ' trueVa:'+ sliderVal);
		this.pe_setSliderValue(sliderVal);
	},
	activateSlider:function(){
		//map the slider to the parent playlist slider id:
		this.pe_activateSlider(this.pc.pp.id);
	},
	doSeek:function(v){
		var plObj = this.pc.pp;
		var prevClip=null;
		//jump to the clip in the current percent. 
		var perc_offset=0;
		for(var i in plObj.tracks[0].clips){
			var clip = plObj.tracks[0].clips[i];		
			perc_offset+=(clip.embed.duration /  plObj.getPlDuration());
			if(perc_offset > v ){	
				if(this.playMovieAt){							
					this.playMovieAt(i);				
					plObj.cur_clip = clip;
					return '';
				}
			}
		} 	
	}
}

/* mu parse
 *  
 */
var m3uPlaylist = {
	doParse:function(){
		//for each line not # add as clip 
		var inx =0;
		var this_pl = this;
		//js_log('data:'+ this.data.toString());
		$j.each(this.data.split("\n"), function(i,n){			
			//js_log('on line '+i+' val:'+n+' len:'+n.length);
			if(n.charAt(0)!='#'){
				if(n.length>3){ 
					//@@todo make sure its a valid url
					//js_log('add url: '+i + ' '+ n);
					var cur_clip = new mvClip({type:'srcClip',id:'p_'+this_pl.id+'_c_'+inx,pp:this_pl,src:n,order:inx});
					//setup the embed object 
					cur_clip.setUpEmbedObj();	
					this_pl.addCliptoTrack(cur_clip);					
					inx++;
				}
			}
		});
		return true;
	}
}
/*
 * parse inline playlist format
 */
var inlinePlaylist = {
	parseClipWait:{},
	doParse:function(){
		js_log("doParse inline");
		var properties = { title:'title', linkback:'linkback', 
						   desc:'desc', image:'img'};
		var lines = this.data.split("\n");
		var cur_attr=null;
		var cur_clip=null;
		var clip_inx=0;
		var ajax_flag = false;
		var plObj = this;
		
		function close_clip(){		
			if(cur_clip!=null){	
				plObj.addCliptoTrack(cur_clip);
				if(cur_clip.src){
					cur_clip.setUpEmbedObj();	
				}else{
					if(cur_clip.mvclip){
						ajax_flag=true;
						cur_clip.getRemoteData();
					}else{					
						js_log('clip '+ clip_inx +' not added (no src or mvclip');
						return '';
					}
				}
				cur_clip=null;
				cur_attr=null;
				clip_inx++;
			}
		}
		js_log("line length: "+ lines.length);
		for(var i=0;i<lines.length;i++){		
			var n = lines[i];
			if(n.charAt(0)!='#' && n.substring(0,3)!='-->' && n.substring(0,4)!='<!--'){
				var ix = n.indexOf('=');
				if(ix!=-1){
					cur_attr=n.substring(1,ix);
				}
				js_log("on line: "+ i + ' n:'+ cur_attr);
				if(cur_attr=='mvClip'){
					close_clip();
					cur_clip = new mvClip({type:'mvClip',id:'p_'+this.id+'_c_'+clip_inx,pp:this,order:clip_inx});
					cur_clip.mvclip = n.substring(ix+1);
					//js_log('NEW mvclip '+ clip_inx + ' '+ cur_clip.mvclip);
					cur_attr=null;
				}
				if(cur_attr=='srcClip'){
					close_clip();
					cur_clip = new mvClip({type:'srcClip',id:'p_'+this.id+'_c_'+clip_inx,pp:this,order:clip_inx});				
					cur_clip.src = n.substring(ix+1);
					//js_log('NEW clip '+ clip_inx + ' '+ cur_clip.src);
					cur_attr=null;
				}		
				if(properties[cur_attr]){
					var k = properties[cur_attr]; 		
					var v = n.substring(ix+1);	
					if(cur_clip==null){ //not bound to any clip apply property to playlist
						this[k]=v;			
					}else{ //clip				
						if(cur_clip[k]){
							cur_clip[k]+=v;
						}else{
							cur_clip[k]=v;
						}			
					}
				}
				//close the current attr if not desc
				if(cur_attr!='desc')cur_attr=null;
			}
		}
		js_log("LINKBACK:"+ this.linkback);
		//close the last clip:
		close_clip();	
		//paser done		
		if(ajax_flag){
			//we have to wait for an ajax request don't continue processing
			return false;
		}else{
			return true;
		}
	}
}

var itunesPlaylist = {
	doParse:function(){ 
		var properties = { title:'title', linkback:'link', 
						   author:'itunes:author',desc:'description',
						   date:'pubDate' };
		var tmpElm = null;
		for(i in properties){
			tmpElm = this.data.getElementsByTagName(properties[i])[0];
			if(tmpElm){
				this[i] = tmpElm.childNodes[0].nodeValue;
				//js_log('set '+i+' to '+this[i]);
			}
		}
		//image src is nested in itunes rss:
		tmpElm = this.data.getElementsByTagName('image')[0];
		if(tmpElm){
			imgElm = tmpElm.getElementsByTagName('url')[0];
				if(imgElm){
					this.img = imgElm.childNodes[0].nodeValue;
				}
		}
		//get the clips: 
		var clips = this.data.getElementsByTagName("item");
		properties.src = 'guid';
		for (var i=0;i<clips.length;i++){
			var cur_clip = new mvClip({type:'srcClip',id:'p_'+this.id+'_c_'+i,pp:this,order:i});			
			for(var j in properties){
				tmpElm = clips[i].getElementsByTagName( properties[j] )[0];
				if(tmpElm!=null){
					cur_clip[j] = tmpElm.childNodes[0].nodeValue;
					//js_log('set clip property: ' + j+' to '+cur_clip[j]);
				}
			}
			//image is nested
			tmpElm = clips[i].getElementsByTagName('image')[0];
			if(tmpElm){
				imgElm = tmpElm.getElementsByTagName('url')[0];
					if(imgElm){
						cur_clip.img = imgElm.childNodes[0].nodeValue;
					}
			}
			//set up the embed object now that all the values have been set
			cur_clip.setUpEmbedObj();
			//add the current clip to the clip list
			this.addCliptoTrack(cur_clip);
		}
		return true;
	}
}

/* 
 * parse xsfp: 
 * http://www.xspf.org/xspf-v1.html
 */
var xspfPlaylist ={
	doParse:function(){
		//js_log('do xsfp parse: '+ this.data.innerHTML);
		var properties = { title:'title', linkback:'info', 
						   author:'creator',desc:'annotation',
						   img:'image', date:'date' };
		var tmpElm = null;
		//get the first instance of any of the meta tags (ok that may be the meta on the first clip)
		//js_log('do loop on properties:' + properties);
		for(i in properties){
			js_log('on property: '+i);			
			tmpElm = this.data.getElementsByTagName(properties[i])[0];
			if(tmpElm){
				if(tmpElm.childNodes[0]){
					this[i] = tmpElm.childNodes[0].nodeValue;
					js_log('set pl property: ' + i+' to '+this[i]);
				}
			}
		}
		var clips = this.data.getElementsByTagName("track");
		js_log('found clips:'+clips.length);
		//add any clip specific properties 
		properties.src = 'location';
		for (var i=0;i<clips.length;i++){
			var cur_clip = new mvClip({type:'srcClip',id:'p_'+this.id+'_c_'+i,pp:this,order:i});			
			//js_log('cur clip:'+ cur_clip.id);
			for(var j in properties){
				tmpElm = clips[i].getElementsByTagName( properties[j] )[0];
				if(tmpElm!=null){				
					if( tmpElm.childNodes.length!=0){
						cur_clip[j] = tmpElm.childNodes[0].nodeValue;
						js_log('set clip property: ' + j+' to '+cur_clip[j]);
					}
				}
			}			
			//add mvClip ref from info link: 
			if(cur_clip.linkback){
				//if mv linkback
				mvInx = 'Stream:';
				mvclippos = cur_clip.linkback.indexOf(mvInx);
				if(mvclippos!==false){
					cur_clip.mvclip=cur_clip.linkback.substr( mvclippos+mvInx.length );
				}
			}			
			//set up the embed object now that all the values have been set
			cur_clip.setUpEmbedObj();
			//add the current clip to the clip list
			this.addCliptoTrack(cur_clip);
		}
		//js_log('done with parse');
		return true;
	}
}
/* utility functions 
 * (could be combined with other stuff) 
 */

function getAbsolutePos(objectId) {
	// Get an object left position from the upper left viewport corner
	o = document.getElementById(objectId);
	oLeft = o.offsetLeft;            // Get left position from the parent object	
	while(o.offsetParent!=null) {   // Parse the parent hierarchy up to the document element
		oParent = o.offsetParent    // Get parent object reference
		oLeft += oParent.offsetLeft // Add parent left position
		o = oParent
	}	
	o = document.getElementById(objectId);
	oTop = o.offsetTop;
	while(o.offsetParent!=null) { // Parse the parent hierarchy up to the document element
		oParent = o.offsetParent  // Get parent object reference
		oTop += oParent.offsetTop // Add parent top position
		o = oParent
	}
	return {x:oLeft,y:oTop};
}
String.prototype.htmlEntities = function(){
  var chars = new Array ('&','à','á','â','ã','ä','å','æ','ç','è','é',
                         'ê','ë','ì','í','î','ï','ð','ñ','ò','ó','ô',
                         'õ','ö','ø','ù','ú','û','ü','ý','þ','ÿ','À',
                         'Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë',
                         'Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö',
                         'Ø','Ù','Ú','Û','Ü','Ý','Þ','€','\"','ß','<',
                         '>','¢','£','¤','¥','¦','§','¨','©','ª','«',
                         '¬','­','®','¯','°','±','²','³','´','µ','¶',
                         '·','¸','¹','º','»','¼','½','¾');

  var entities = new Array ('amp','agrave','aacute','acirc','atilde','auml','aring',
                            'aelig','ccedil','egrave','eacute','ecirc','euml','igrave',
                            'iacute','icirc','iuml','eth','ntilde','ograve','oacute',
                            'ocirc','otilde','ouml','oslash','ugrave','uacute','ucirc',
                            'uuml','yacute','thorn','yuml','Agrave','Aacute','Acirc',
                            'Atilde','Auml','Aring','AElig','Ccedil','Egrave','Eacute',
                            'Ecirc','Euml','Igrave','Iacute','Icirc','Iuml','ETH','Ntilde',
                            'Ograve','Oacute','Ocirc','Otilde','Ouml','Oslash','Ugrave',
                            'Uacute','Ucirc','Uuml','Yacute','THORN','euro','quot','szlig',
                            'lt','gt','cent','pound','curren','yen','brvbar','sect','uml',
                            'copy','ordf','laquo','not','shy','reg','macr','deg','plusmn',
                            'sup2','sup3','acute','micro','para','middot','cedil','sup1',
                            'ordm','raquo','frac14','frac12','frac34');

  newString = this;
  for (var i = 0; i < chars.length; i++)
  {
    myRegExp = new RegExp();
    myRegExp.compile(chars[i],'g')
    newString = newString.replace (myRegExp, '&' + entities[i] + ';');
  }
  return newString;
}
