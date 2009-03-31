/*
* a library for doing remote media searches 
*  
* initial targeted archives are:
	the local wiki 
	wikimedia commons 
	metavid 
	and archive.org
*/

gMsg['mv_media_search']	= 'Media Search';
gMsg['rsd_box_layout'] 	= 'Box layout';
gMsg['rsd_list_layout'] = 'List Layout';
gMsg['rsd_results_desc']= 'Results ';
gMsg['rsd_results_next'] = ' next ';
gMsg['rsd_results_prev'] = ' previus ';

gMsg['rsd_layout'] = 	  'Layout:';
gMsg['rsd_resource_edit']='Edit Resource:';

var default_remote_search_options = {
	'profile':'mediawiki_edit',	
	'target_id':null, //the div that will hold the search interface
	
	'default_provider_id':'all', //all or one of the content_providers ids
	
	'caret_pos':null,
	'local_wiki_api_url':null,
	'target_title':null,
	
	'target_textbox':null,
	'instance_name': null, //a globally accessible callback instance name
	'default_query':'', //default search query
	//specific to sequence profile
	'p_seq':null,
	'cFileNS':'Image' //what is the cannonical namespace for images 
					  //@@todo (should be able to get that from the api in the future) 
}
var remoteSearchDriver = function(initObj){
	return this.init( initObj );
}
remoteSearchDriver.prototype = {
	results_cleared:false,
	//here we define the set of possible media content providers:
	main_search_options:{
		'selprovider':{
			'title': 'Select Providers'			
		},
		'advanced_search':{
			'title': 'Advanced Options'
		}		
	},
	content_providers:{				
		/*content_providers documentation: 			
			@enabled: whether the search provider can be selected
			@checked: whether the search provideer will show up as seletable tab (todo: user prefrence) 
			@d: 	  if the current cp should be displayed (only one should be the default) 
			@title:   the title of the search provider
			@desc: 	  can use html... todo: need to localize
			@api_url: the url to query against given the library type: 
			@lib: 	  the search library to use corresponding to the 
						search object ie: 'mediaWiki' = new mediaWikiSearchSearch() 
			@local : if the content provider assets need to be imported or not.  
		*/ 		 
		'this_wiki':{
			'enabled':0,
			'checked':0,
			'd'		:0,
			'title'	:'The Current Wiki',
			'desc'	: '(should be updated with the proper text)',
			'api_url': wgScriptPath + '/api.php',
			'lib'	:'mediaWiki',
			'local'	:true
		},
		'wiki_commons':{
			'enabled':1,
			'checked':1,
			'd'		:1,
			'title'	:'Wikipedia Commons',			
			'desc'	: 'Wikimedia Commons is a media file repository making available public domain '+
			 		'and freely-licensed educational media content (images, sound and video clips) to all.',
			'homepage': 'http://commons.wikimedia.org/wiki/Main_Page',		
			'api_url':'http://commons.wikimedia.org/w/api.php',
			'lib'	:'mediaWiki',			
			'resource_prefix': 'WC_', //prefix on imported resources (not applicable if the repository is local)
			
			//list all the domains where commons is local? or set this some other way
			'local_domains': ['wikimedia','wikipedia','wikibooks'],
			//specific to wiki commons config: 
			'search_title':false, //disable title search 
			//set up default range limit
			'offset'			: 0,
			'limit'				: 30			
		},
		'metavid':{
			'enabled':1,
			'checked':1,
			'd'		:0,			
			'title'	:'Metavid.org',
			'homepage':'http://metavid.org',
			'desc'	: 'Metavid hosts thousands of hours of US house and senate floor proceedings',
			'api_url':'http://metavid.org/w/index.php?title=Special:MvExportSearch',
			'lib'	: 'metavid',
			'local'	:false,			//if local set to true we can use local 
			'resource_prefix': 'MV_', //what prefix to use on imported resources
			
			'local_domains': ['metavid'], // if the domain name contains metavid 
									   // no need to import metavid content to metavid sites
									   
			'stream_import_key': 'mv_ogg_low_quality', // which stream to import, could be mv_ogg_high_quality 
													  //or flash stream, see ROE xml for keys
													  
			'remote_embed_ext': false //if running the remoteEmbed extension no need to copy local 
									  //syntax will be [remoteEmbed:roe_url link title]							   		 
		},
		'archive_org':{
			'enabled':0,
			'checked':0,
			'd'		:0,
			'title' : 'Archive.org',
			'desc'	: 'The Internet Archive, a digital library of cultural artifacts',
			'homepage':'http://archive.org',
			'lib'	: 'archive',
			'local'	: false,
			'resource_prefix': 'AO_'
		}
	},	
	//some default layout values:		
	thumb_width 		: 80,
	image_edit_width	: 600,
	video_edit_width	: 400,
	insert_text_pos		: 0, //insert at the start (will be overwiten by the user cursor pos) 
	result_display_mode : 'box', //box or list or preview	
	
	init:function( initObj ){
		js_log('remoteSearchDriver:init');
		for( var i in default_remote_search_options ) {
			if( initObj[i]){
				this[ i ] = initObj[i];
			}else{
				this[ i ] =default_remote_search_options[i]; 
			}			
		}		
		//set up the content provider config: 
		if(this.cpconfig){
			for(var cpc in cpconfig){
				for(var cinx in this.cpconfig[cpc]){
					if( this.content_providers[cpc] )						
						this.content_providers[ cpc ][ cinx ] = this.cpconfig[cpc][ cinx];					
				}
			}
		}
		
		//overwrite the default query if a text selection was made: 
		if(this.target_textbox)
			this.getTexboxSelection();
		
		this.init_interface_html();
		this.add_interface_bindings();
	},
	//gets the in and out points for insert position or grabs the selected text for search	
	getTexboxSelection:function(){				
		if(this.caret_pos.s && this.caret_pos.e &&
			(this.caret_pos.s != this.caret_pos.e))
			this.default_query = this.caret_pos.text.substring(this.caret_pos.s, this.caret_pos.e).replace(/ /g, '\xa0') || '\xa0'		
	},
	//sets up the initial html interface 
	init_interface_html:function(){
		var out = '<div class="rsd_control_container" style="width:100%">' + 
					'<table style="width:100%;background-color:transparent;">' +
						'<tr>'+
							'<td style="width:110px">'+
								'<h3> Media Search </h3>'+
							'</td>'+
							'<td style="width:190px">'+
								'<input type="text" tabindex="1" value="' + this.default_query + '" maxlength="512" id="rsd_q" name="rsd_q" '+ 
									'size="20" autocomplete="off"/>'+
							'</td>'+
							'<td style="width:115px">'+
								'<input type="submit" value="' + getMsg('mv_media_search') + '" tabindex="2" '+
									' id="rms_search_button"/>'+
							'</td>'+
							'<td>';
			//out += '<a href="#" id="mso_selprovider" >Select Providers</a><br>';
			out += '<a href="#" id="mso_cancel" >Cancel</a><br>';
			out +=			'</td>'+
						'</tr>'+
					'</table>';			
		js_log('out: ' + out);									
				
		out+='<div id="rsd_options_bar" style="display:none;width:100%;height:0px;background:#BBB">';
			//set up the content provider selection div (do this first to get the default cp)
			out+= '<div id="cps_options">';												
			for( var cp_id in this.content_providers ){
				var cp = this.content_providers[cp_id];				 
				var checked_attr = ( cp.checked ) ? 'checked':'';					  
				out+='<div  title="' + cp.title + '" '+ 
						' style="float:left;cursor:pointer;">'+
						'<input class="mv_cps_input" type="checkbox" name="mv_cps" '+ checked_attr+'>';

				out+= '<img alt="'+cp.title+'" src="' + mv_embed_path + 'skins/' + mv_skin_name + '/remote_search/' + cp_id + '_tab.png">'; 				
				out+='</div>';
			}		 		
			out+='<div style="clear:both"/><a id="mso_selprovider_close" href="#">'+getMsg('close')+'</a></div>';
		out+='</div>';				
		//close up the control container: 
		out+='</div>';
		//search provider tabs based on "checked" and "enabled" and "combined tab"
		out+='<div id="rsd_results_container">';				
		out+='</div>';							
		$j('#'+ this.target_id ).html( out );
		//draw the tabs: 
		this.drawTabs();
		//run the default search: 
		this.runSearch();
	}, 
	add_interface_bindings:function(){
		var _this = this;
		js_log("add_interface_bindings:");		
		//setup for this.main_search_options:
		$j('#mso_cancel').click(function(){ 
			_this.closeAll(); 
		});
		
		$j('#mso_selprovider,#mso_selprovider_close').click(function(){
			if($j('#rsd_options_bar:hidden').length !=0 ){
				$j('#rsd_options_bar').animate({
					'height':'110px',
					'opacity':1
				}, "normal");
			}else{
				$j('#rsd_options_bar').animate({
					'height':'0px',
					'opacity':0					
				}, "normal", function(){
					$j(this).hide();
				});
			}
		});						
		//setup binding for search provider check box: 
		//search button: 
		$j('#rms_search_button').click(function(){
			_this.runSearch();
		});		
	},
	runSearch: function(){
		var _this = this;						
		//set loading div: 
		$j('#rsd_results').append('<div style="position:absolute;top:0px;left:0px;height:100%;width:100%;'+
			'background-color:#FFF;">' + 			
				mv_get_loading_img('top:30px;left:30px') + 
			'</div>');		
		//get a remote search object for each search provider and run the search
		for(var cp_id in  this.content_providers){
			var cp = this.content_providers[ cp_id ];			
				
			//only run the search for default item (unless combined is selected) 
			if( !cp.d || this.disp_item == 'combined' )
				continue;			
			
			//set display if unset
			if(!this.disp_item)
				this.disp_item = cp_id;
				
			//check if we need to update: 
			if(typeof cp.sObj != 'undefined'){
				if(cp.sObj.last_query == $j('#rsd_q').val() && cp.sObj.last_offset == cp.offset)
					continue;					
			}			
			//else we need to run the search: 
			var iObj = {'cp':cp, 'rsd':this};			
			eval('cp.sObj = new '+cp.lib+'Search(iObj);');
			if(!cp.sObj)
				js_log('Error: could not find search lib for ' + cp_id);
			
			//inherit defaults if not set: 
			cp.limit = (cp.limit) ? cp.limit : cp.sObj.limit;
			cp.offset = (cp.offset) ? cp.offset : cp.sObj.offset;
			
			//do search:
			cp.sObj.getSearchResults();							
		}	
		this.checkResultsDone();
	},	
	checkResultsDone: function(){
		var _this = this;
		var loading_done = true;
		for(var cp_id in  this.content_providers){
			cp = this.content_providers[ cp_id ];
			if(typeof cp['sObj'] != 'undefined'){
				if( cp.sObj.loading )
					loading_done=false; 
			}
		}
		if(loading_done){
			this.drawOutputResults();
		}else{			
			setTimeout( _this.instance_name + '.checkResultsDone()', 250);
		}		 
	},
	drawTabs: function(){
		var _this = this;
		//add the tabs to the rsd_results container: 
		var o='<div class="rsd_tabs_container" style="position:absolute;top:49px;width:100%;left:12px;height:25px;">';
		o+= '<ul class="rsd_cp_tabs" style="margin: 0 0 0 0;position:absolute;top:0px;padding:0;">'; //no idea why margin does not overwrite from the css
			o+='<li id="rsd_tab_combined" ><img src="' + mv_embed_path + 'skins/'+mv_skin_name+ '/remote_search/combined_tab.png"></li>';		 			 	
			for(var cp_id in  this.content_providers){
				var cp = this.content_providers[cp_id];
				if( cp.enabled && cp.checked){
					var class_attr = (cp.d)?'class="rsd_selected"':'';
					o+='<li id="rsd_tab_'+cp_id+'" ' + class_attr + '><img src="' + mv_embed_path + 'skins/' + mv_skin_name + '/remote_search/' + cp_id + '_tab.png">';
				}
			}
		o+='</ul>';		
		o+='</div>';
		//outout the resource results holder	
		o+='<div id="rsd_results" />';				
		$j('#rsd_results_container').html(o);
		
		//setup bindings for tabs: 
		$j('.rsd_cp_tabs li').click(function(){
			_this.selectTab( $j(this).attr('id').replace(/rsd_tab_/, '') );
		});
	},			
	//@@todo we could load the id with the content provider id to find the object faster...
	getResourceFromId:function( rid ){
		//strip out /res/ if preset: 
		rid = rid.replace(/res_/, '');
		for(var cp_id in  this.content_providers){
			cp = this.content_providers[ cp_id ];		
			if(	cp['sObj']){
				for(var rInx in cp.sObj.resultsObj){				
					if(rInx == rid)
						return cp.sObj.resultsObj[rInx];
				};
			}
		}
		js_log("ERROR: could not find " + rid);
		return false;
	},
	drawOutputResults: function(){		
		js_log('f:drawOutputResults');					
		var _this = this;			
		var o='';
		$j('#rsd_results').empty();
		//output the results bar / controls
		_this.setResultBarControl();				 
		
		//output all the results (hide based on tab selection) 
		for(var cp_id in  this.content_providers){
			cp = this.content_providers[ cp_id ];
			//output results based on display mode & input: 
			if(typeof cp['sObj'] != 'undefined'){
				$j.each(cp.sObj.resultsObj, function(rInx, rItem){					
					var disp = ( cp.d ) ? '' : 'display:none;';
					if( _this.result_display_mode == 'box' ){
						o+='<div id="mv_result_' + rInx + '" class="mv_clip_box_result" style="' + disp + 'width:' +
								_this.thumb_width + 'px;height:'+ (_this.thumb_width-20) +'px">';
							o+='<img title="'+rItem.title+'" class="rsd_res_item" id="res_' + rInx +'" style="width:' + _this.thumb_width + 'px;" src="' + rItem.poster + '">';
						o+='</div>';
					}else if(_this.result_display_mode == 'list'){
						o+='<div id="mv_result_' + rInx + '" class="mv_clip_list_result" style="' + disp + 'width:90%">';					
							o+='<img title="'+rItem.title+'" class="rsd_res_item" id="res_' + rInx +'" style="float:left;width:' + _this.thumb_width + 'px; padding:5px;" src="' + rItem.poster + '">';			
							o+= rItem.desc ;							
						o+='</div>';
						o+='<div style="clear:both" />';
					}			
				});	
			}						
		}				
		//put in the new output:  
		$j('#rsd_results').append( o )		
		//remove rss only display class if present
		$j('#rsd_results .mv_rss_view_only').remove();
		this.addResultBindings();
	},
	addResultBindings:function(){
		var _this = this;			
		$j('.mv_clip_'+_this.result_display_mode+'_result').hover(function(){
			$j(this).addClass('mv_clip_'+_this.result_display_mode+'_result_over');
		},function(){
			$j(this).removeClass('mv_clip_'+_this.result_display_mode+'_result_over');
		});				
		//resource click action: (bring up the resource editor) 		
		$j('.rsd_res_item').click(function(){				
			//get the resource obj:
			var rObj = _this.getResourceFromId( this.id );						
			//remove any existing resource edit interface: 
			$j('#rsd_resource_edit').remove();					
			//set the media type:
			if(rObj.mime.indexOf('image')!=-1){	 			
				//set width to default image_edit_width
				var maxWidth = _this.image_edit_width;		
				var mediaType = 'image';										
			}else{
				//set to default video size: 
				var maxWidth = _this.video_edit_width;
				var mediaType = 'video';
			}
			//so that transcripts show ontop
			var overflow_style = ( mediaType =='video' )?'':'overflow:auto;';
			//append to the top level of model window: 
			$j( '#'+ _this.target_id ).append('<div id="rsd_resource_edit" '+ 
				'style="position:absolute;top:0px;left:0px;width:100%;height:100%;background-color:#FFF;">' +
					'<h3 id="rsd_resource_title" style="margin:4px;">' + getMsg('rsd_resource_edit') + ' ' + rObj.title +'</h3>'+
					'<div id="clip_edit_disp" style="position:absolute;'+overflow_style+'top:30px;left:0px;bottom:0px;'+
						'width:' + (maxWidth + 30) + 'px;" >' +
							mv_get_loading_img('position:absolute;top:30px;left:30px', 'mv_img_loader') + 
					'</div>'+
					'<div id="clip_edit_ctrl" style="position:absolute;border:solid thin blue;'+
						'top:30px;left:' + (maxWidth+30) +'px;bottom:0px;right:0px;">'+
						mv_get_loading_img() +  					
					'</div>'+
				'</div>');
			$j('#rsd_resource_edit').css('opacity',0);
			
			$j('#rsd_edit_img').remove();//remove any existing rsd_edit_img 
			
			//left side holds the image right size the controls /														
			$j(this).clone().attr('id', 'rsd_edit_img').appendTo('#clip_edit_disp').css({
				'position':'absolute',
				'top':'40%',
				'left':'20%',
				'opacity':0	
			});															
			
			//assume we keep aspect ratio for the thumbnail that we clicked:			
			var tRatio = $j(this).height() / $j(this).width();
			if(	! tRatio )		
				var tRatio = 1; //set ratio to 1 if the width of the thumbnail can't be found for some reason
			
			js_log('set from ' +  $j('#rsd_edit_img').width()+'x'+ $j('#rsd_edit_img').height() + ' to init thumbimage to ' + maxWidth + ' x ' + parseInt( tRatio * maxWidth) );	
			//scale up image and swap with high res version
			$j('#rsd_edit_img').animate({
				'opacity':1,
				'top':'0px',
				'left':'0px',
				'width': maxWidth + 'px',
				'height': parseInt( tRatio * maxWidth)  + 'px'
			}, "slow"); // do it slow to give it a chance to finish loading the HQ version
			
			_this.loadHQImg(rObj, {'width':maxWidth}, 'rsd_edit_img', function(){
				$j('.mv_img_loader').remove();
			});
			//also fade in the container: 
			$j('#rsd_resource_edit').animate({
				'opacity':1,
				'background-color':'#FFF',
				'z-index':99
			});			
			_this.doMediaEdit( rObj , mediaType );			
		});
	},
	loadHQImg:function(rObj, size, target_img_id, callback){		
		//get the HQ image url: 
		rObj.pSobj.getImageObj( rObj, size, function( imObj ){			
			rObj['url'] = imObj.url;
			
			//update the rObj
			rObj['org_width'] = imObj.org_width;			
			rObj['width'] = imObj.width;
			rObj['height'] = imObj.height;
				
			//see if we need to animate some transition
			var newSize = false;
			if( size.width != imObj.width ){ 
				js_log('loadHQImg:size mismatch: ' + size.width + ' != ' + imObj.width );
				newSize={
					'width':imObj.width + 'px',
					'height':imObj.height + 'px'
				}			
				//set the target id to the new size: 
				$j('#'+target_img_id).animate( newSize );
			}else{		
				js_log('using req size: ' + imObj.width + 'x' + imObj.height);
				$j('#'+target_img_id).animate( {'width':imObj.width+'px', 'height' : imObj.height + 'px'});
			}
			//don't swap it in until its loaded: 
			var img = new Image();		
			// load the image image: 				
			$j(img).load(function () { 
	                 $j('#'+target_img_id).attr('src', imObj.url);                 
	                 //let the caller know we are done and what size we ended up with: 
	                 callback();	                 
				}).error(function () { 
					js_log("Error with:  " +  imObj.url);
				}).attr('src', imObj.url);   
		});		
	},
	//loads the media editor:
	doMediaEdit:function( rObj , mediaType){
		var _this = this;
		var mvClipInit = {
				'rObj':rObj, //the resource object	
				'parent_ct':'rsd_resource_edit',
				'clip_disp_ct':'clip_edit_disp',
				'control_ct': 'clip_edit_ctrl',
				'media_type': mediaType,
				'p_rsdObj': _this						
		};
		var loadLibs =  {'mvClipEdit':'libSequencer/mv_clipedit.js'};		
		if( mediaType == 'image'){
			//load the croping library:
			loadLibs['$j.Jcrop']='jquery/plugins/Jcrop/js/jquery.Jcrop.js';
			//@@todo integrate css calls into mvJsLoader or move jcrop css
			loadExternalCss( mv_embed_path + 'jquery/plugins/Jcrop/css/jquery.Jcrop.css');
			//display the mvClipEdit obj once we are done loading:
			mvJsLoader.doLoad( loadLibs,function(){				
				//run the image clip tools 
				_this.cEdit = new mvClipEdit( mvClipInit );
			});				
		}
		if( mediaType == 'video'){
			js_log('append html: ' + rObj.pSobj.getEmbedHTML( rObj, {id:'embed_vid'}) );
			$j('#clip_edit_disp').append(
				rObj.pSobj.getEmbedHTML( rObj, {id:'embed_vid'})				
			);	
			//rewrite by id handldes getting any libs we are missing: 		
			rewrite_by_id('embed_vid',function(){
				//grab any information that we got from the ROE xml or parsed from the media file
				rObj = rObj.pSobj.getEmbedObjParsedInfo(rObj, 'embed_vid');					
				//add the re-sizable to the doLoad request: 
				loadLibs['$j.ui.resizable']	  = 'jquery/jquery.ui-1.5.2/ui/minified/ui.resizable.min.js',
				loadLibs['$j.fn.hoverIntent'] = 'jquery/plugins/jquery.hoverIntent.js';
				mvJsLoader.doLoad( loadLibs,function(){				
					//run the image clip tools 
					_this.cEdit = new mvClipEdit( mvClipInit );
				});	
			});
		}	
	},
	checkImportResource:function( rObj, cir_callback){
		//@@todo get the localized File/Image namespace name or do a general {NS}:Title aproch
		var cp = rObj.pSobj.cp;	
		var _this = this;
		rObj.target_resource_title = rObj.titleKey.replace(/File:|Image:/,'');					
		
		//check if we can embed the content locally per a domain name check:
		var local_embed_ref=false;
		var local_host = parseUri(this.local_wiki_api_url).host;
		if( rObj.pSobj.cp.local_domains ) {								
			for(var i=0;i < rObj.pSobj.cp.local_domains.length; i++){
				var ld = rObj.pSobj.cp.local_domains[i];
				 if( local_host.indexOf( ld ) != -1)
				 	local_embed_ref=true;
			}
		}		
		//locally embeddalbe jump to callback:
		if( local_embed_ref ){
		 	cir_callback( rObj );
		}else{											
			//not a local domain update target resource name with the prefix: 
			rObj.target_resource_title = cp.resource_prefix +rObj.target_resource_title;  
			
			//check if the resource is not already on this wiki			
			reqObj={'action':'query', 'titles': _this.cFileNS + ':' + rObj.target_resource_title};					
			
			do_api_req( reqObj, this.local_wiki_api_url, function(data){	
				var found_title = false;
				for(var i in data.query.pages){
					if( i != '-1' && i != '-2' ){
						js_log('found title: ' + i + ':' +  data.query.pages[i]['title']);
						found_title=data.query.pages[i]['title'];
					}
				}			
				if( found_title ){				
					js_log("checkImportResource:found title:" + found_title);  
					//resource is already present (or resource with same name is already present)
					rObj.target_resource_title = found_title.replace(/File:|Image:/,'');			
					cir_callback( rObj );
				}else{
					js_log("resource not present: update:"+ _this.cFileNS + ':' + rObj.target_resource_title);
					
					//update the rObj with import info
					rObj.pSobj.updateDataForImport( rObj );
					
					//setup the resource description from resource description: 					
					var base_resource_desc = '{{Information '+"\n"+
					'|Description= ' + rObj.title + ' imported from ' + '[' + cp.homepage + 
								 ' ' + cp.title+']' + "\n" +
					'|Source=' + '[' + rObj.link.replace(/^\s\s*/, '').replace(/\s\s*$/, '') +' Original Source]'+ "\n";
					
					if( rObj.author )
						base_resource_desc+='|Author= ' + rObj.author +"\n";										
						
					if( rObj.date )
						base_resource_desc+='|Date=' + rObj.date +"\n";								
											
					if( rObj.permission )
						base_resource_desc+='|Permission='+ rObj.permission +"\n";
						
					if( rObj.other_versions )
						base_resource_desc+='|Other_versions=' + rObj.other_versions + "\n";
											
					base_resource_desc+='}}';
					
					//add in licence template tag: 
					if( rObj.licence_template_tag )
						base_resource_desc += "\n" +
							'== [[Commons:Copyright tags|Licensing]]: ==' +"\n"+
							'{{' + rObj.licence_template_tag + '}}';
					
					$j('#rsd_resource_import').remove();//remove any old resource imports
					//@@ show user dialog to import the resource
					$j( '#'+ _this.target_id ).append('<div id="rsd_resource_import" '+ 
					'style="position:absolute;top:50px;left:50px;right:50px;bottom:50px;background-color:#FFF;border:solid thick red;z-index:3">' +
						'<h3 style="color:red">Resource: <span style="color:black">' + rObj.title + '</span> needs to be imported</h3>'+
							'<div id="rsd_preview_import_container" style="position:absolute;width:50%;bottom:0px;left:0px;overflow:auto;top:30px;">' +
								rObj.pSobj.getEmbedHTML( rObj, {'max_height':'200','only_poster':true} )+ //get embedHTML with small thumb: 
								'<br style="clear both">'+
								'<strong>Resource Page Description:</strong>'+
								'<div id="rsd_import_desc" syle="display:inline;">'+
									mv_get_loading_img('position:absolute;top:5px;left:5px', 'mv_img_loader') +
								'</div>'+							
							'</div>'+
							'<div id="rds_edit_import_container" style="position:absolute;left:50%;' +
								'bottom:0px;top:30px;right:0px;overflow:auto;">'+
								'<strong>Local Resource Title:</strong><br>'+
								'<input type="text" size="30" value="' + rObj.target_resource_title + '" readonly="true"><br>'+
								'<strong>Edit WikiText Resource Description:</strong>(will be replaced by forms soon)'+																									
								'<textarea id="rsd_import_ta" id="mv_img_desc" style="width:90%;" rows="8" cols="50">'+
									base_resource_desc + 
								'</textarea><br>'+
								'<input type="checkbox" value="true" id="wpWatchthis" name="wpWatchthis" tabindex="7"/>'+
								'<label for="wpWatchthis">Watch this page</label><br>'+
								'<input id="rsd_import_apreview" type="button" value="Update Preview"> ' +
								'<input style="font-weight: bold" id="rsd_import_doimport" type="button" value="Do Import Resource"> '+
								'<a id="rsd_import_acancel" href="#">Cancel Import</a>'+				 
							'</div>'+
							//output the rendered and non-renderd version of description for easy swiching:	
					'</div>');			
					//load the preview text: 					
					_this.getParsedWikiText( base_resource_desc, _this.cFileNS +':'+ rObj.target_resource_title, function( o ){						
						$j('#rsd_import_desc').html(o);
					});
					//add bidings: 				
					$j('#rsd_import_apreview').click(function(){
						$j('#rsd_import_desc').show().html(
							mv_get_loading_img()
						);
						//load the preview text: 
						_this.getParsedWikiText( $j('#rsd_import_ta').val(), _this.cFileNS +':'+ rObj.target_resource_title, function( o ){
							js_log('got updated preivew: '+ o);
							$j('#rsd_import_desc').html(o);
						});
					});
					$j('#rsd_import_doimport').click(function(){
						//replace the parent with progress bar: 
						$j('#rsd_resource_import').html(
							'<h3>Importing asset</h3>'+
							mv_get_loading_img() 
						);			
						//get an edittoken: 
						var reqObj = {'action':'query','prop':'info','intoken':'edit','titles': rObj.titleKey };
						do_api_req( reqObj, _this.local_wiki_api_url, function(data){
							//could recheck if it has been created in the mean time
							if( data.query.pages[-1] ){ 								
								var editToken = data.query.pages[-1]['edittoken'];
								if(!editToken){
									//@@todo give an ajax login or be more friendly in some way:  
									js_error("You don't have permision to upload (are you logged in?)");
									//remove top level: 
									$j('#modalbox').fadeOut("normal",function(){
										$j(this).remove();
										$j('#mv_overlay').remove();
									});
								}else{								
									//not sure if we can do remote url uploads (so just do a local post) 
									js_log('got token for new page:' +editToken);
									var postVars = {
										'wpSourceType'		:'web',
										'wpUploadFileURL'	: rObj.url,
										'wpDestFile'		: rObj.target_resource_title,
										'wpUploadDescription':$j('#rsd_import_ta').val(),
										'wpWatchthis'		: $j('#wpWatchthis').val(),		
										'wpUpload'			: 'Upload file'																																									
									}
									//set to uploading: 
									$j('#rsd_resource_import').append('<div id="rsd_import_progress"'+										
										'style="position:absolute;top:0px;'+
											'left:0px;width:100%;height:100%;'+											
											'z-index:5;background:#FFF;overflow:auto;">'+
												'<div style="position:absolute;left:30%;right:30%"><h3>Importing Asset</h3><br>' + 
													mv_get_loading_img('','mv_loading_bar_img') + 
												'</div>'+					
										'</div>'																				
									);								
									$j.post(wgArticlePath.replace(/\$1/,'Special:Upload'),
										postVars,
										function(data){											
											//@@todo this will be replaced once we add upload image support to the api. 
											
											//very basic test to see if we got passed to the image page:
											//@@todo more normalization stuff
											var sstring ='var wgPageName = "' + _this.cFileNS + ':' + rObj.target_resource_title.replace(/ /g,'_') +'"';
											if(data.indexOf( sstring ) !=-1){
												js_log('found: ' + sstring);	
												$j('#rsd_resource_import').remove();											
												cir_callback( rObj );
											}else{
												js_log("Error or warning: (did not find: \"" + sstring + ' in output' );
												pos_etitle = '<h1 class="firstHeading">';
												var error_txt='';
												if(data.indexOf(pos_etitle)!=-1){
													var sp = data.indexOf(pos_etitle) + pos_etitle.length;
													error_txt = data.substr(sp , 
																(data.indexOf('</h1>',sp	)-sp)
															);
												}
												//var error_msg = 
												$j('#rsd_resource_import').html(
													'<b>error importing asset (we should have better error handling soon)</b><br>'+
													error_txt + '<br>'+
													'<a href="#" id="rsd_import_error" >Cancel import</a>'													
												);
												$j('#rsd_import_error').click(function(){
													$j('#rsd_resource_import').remove();
												});
											}
												
										}
									);
								}								
							}
						});
						
					});
					$j('#rsd_import_acancel').click(function(){
						$j('#rsd_resource_import').fadeOut("fast",function(){
							$j(this).remove();
						})
					})		
				}				
			});													
		}
	},
	previewResource:function( rObj ){
		var _this = this;
		this.checkImportResource( rObj, function(){		
			//put another window ontop:
			$j( '#'+ _this.target_id ).append('<div id="rsd_resource_preview" '+ 
					'style="position:absolute;z-index:4;top:0px;left:0px;width:100%;height:100%;background-color:#FFF;">' +
						'<h3>preview insert of resource: ' + rObj.title + '</h3>'+
						'<div id="rsd_preview_display" style="position:absolute;width:100%;top:30px;bottom:30px;overflow:auto;">' +
							mv_get_loading_img('top:30px;left:30px') + 
						'</div>' +
						'<div id="rsd_preview_control" style="position:absolute;width:60%;left:40%;bottom:0px;height:30px;">' +
							'<input type="button" id="preview_do_insert" value="Do Insert">' +
							'<a href="#" id="preview_close">Do More Modification</a>' +
						'</div>' +
					'</div>');						
			//update the preview_wtext
			_this.updatePreviewText( rObj );
										   
			_this.getParsedWikiText(_this.preview_wtext, _this.target_title,
				function(phtml){
					$j('#rsd_preview_display').html( phtml );
				}
			);			
			//add bindings: 
			$j('#preview_do_insert').click(function(){
				_this.insertResource( rObj );
			});
			$j('#preview_close').click(function(){
				$j('#rsd_resource_preview').remove();
			});
		});
	},	
	updatePreviewText:function( rObj ){
		var _this = this;		
		//insert at start if textInput cursor has not been set (ie == length) 
		if( _this.caret_pos.text.length == _this.caret_pos.s)
			_this.caret_pos.s=0;
		_this.preview_wtext = _this.caret_pos.text.substring(0, _this.caret_pos.s) + 
								rObj.pSobj.getEmbedWikiText( rObj ) + 
							   _this.caret_pos.text.substring( _this.caret_pos.s );
	},
	getParsedWikiText:function( wikitext, title,  callback ){
		var reqObj = {
			'action':'parse', 
			'text':wikitext
		};
		do_api_req( reqObj,  this.local_wiki_api_url, function(data){				
			callback( data.parse.text['*'] );
		});	
	},	
	insertResource:function( rObj){		
		var _this = this
		this.checkImportResource( rObj, function(){
			_this.updatePreviewText( rObj );
			$j('#'+_this.target_textbox).val( _this.preview_wtext );
			_this.closeAll();
		});			
	},
	closeAll:function( rObj ){
		$j('#modalbox').fadeOut("normal",function(){
				$j(this).remove();
				$j('#mv_overlay').remove();
		});
	},
	setResultBarControl:function( ){
		var _this = this;
		var box_dark_url 	= mv_embed_path + 'skins/' + mv_skin_name + '/images/box_layout_icon_dark.png';
		var box_light_url 	= mv_embed_path + 'skins/' + mv_skin_name + '/images/box_layout_icon.png';
		var list_dark_url 	= mv_embed_path + 'skins/' + mv_skin_name + '/images/list_layout_icon_dark.png';
		var list_light_url 	= mv_embed_path + 'skins/' + mv_skin_name + '/images/list_layout_icon.png';
		
		
		$j('#rsd_results').append('<div id="rds_results_bar">'+
			'<span style="position:relative;top:-5px;font-style:italic;">'+
				getMsg('rsd_layout')+' '+
			'</span>'+
				'<img id="msc_box_layout" ' +
					'title = "' + getMsg('rsd_box_layout') + '" '+ 
					'src = "' +  ( (_this.result_display_mode=='box')?box_dark_url:box_light_url ) + '" ' +			
					'style="width:20px;height:20px;cursor:pointer;"> ' + 
				'<img id="msc_list_layout" '+
					'title = "' + getMsg('rsd_list_layout') + '" '+
					'src = "' +  ( (_this.result_display_mode=='list')?list_dark_url:list_light_url ) + '" '+			
					'style="width:20px;height:20px;cursor:pointer;">'+			
			'<span id="rsd_paging_ctrl" style="position:absolute;right:5px;"></span>'+
			'</div>'
		);
		//get paging with bindings:
		this.getPaging('#rsd_paging_ctrl');
				
		$j('#msc_box_layout').hover(function(){			
			$j(this).attr("src", box_dark_url );
		}, function(){ 
			$j(this).attr("src",  ( (_this.result_display_mode=='box')?box_dark_url:box_light_url ) );		
		}).click(function(){	
			$j(this).attr("src", box_dark_url);
			$j('#msc_list_layout').attr("src", list_light_url);
			_this.setDispMode('box');
		});
		
		$j('#msc_list_layout').hover(function(){
			$j(this).attr("src", list_dark_url);
		}, function(){
			$j(this).attr("src", ( (_this.result_display_mode=='list')?list_dark_url:list_light_url ) );		
		}).click(function(){
			$j(this).attr("src", list_dark_url);
			$j('#msc_box_layout').attr("src", box_light_url);
			_this.setDispMode('list');
		});
	},
	getPaging:function(target){
		var _this = this;
		//if more than one repository displayed (disable paging)
		if(this.disp_item ==  'combined'){
			$j(target).html('no paging for combined results');
			return ;
		}				
		for(var cp_id in  this.content_providers){
			var cp = this.content_providers[ cp_id ];			
			if(this.disp_item == cp_id){				
				js_log('getPaging:'+ cp_id);
				var out = getMsg('rsd_results_desc') +  (cp.offset+1) + ' to ' + (cp.offset + cp.limit);
				//check if we have more results (next prev link)
				if(  cp.offset >=  cp.limit )
					out+=' <a href="#" id="rsd_pprev">' + getMsg('rsd_results_prev') + cp.limit + '</a>';
				if( cp.sObj.more_results )					
					out+=' <a href="#" id="rsd_pnext">' + getMsg('rsd_results_next') + cp.limit + '</a>';
				$j(target).html(out);
				//set bindings 
				$j('#rsd_pnext').click(function(){
					cp.offset += cp.limit;
					_this.runSearch();
				});
				$j('#rsd_pprev').click(function(){
					cp.offset -= cp.limit;
					if(cp.offset<0)
						cp.offset=0;
					_this.runSearch();
				});
				
				return;				
			}
		}						
		
	},
	selectTab:function( selected_cp_id ){
		js_log('select tab: ' + selected_cp_id);
		this.disp_item = selected_cp_id;
		//set display to unselected: 
		for(var cp_id in  this.content_providers){
			cp = this.content_providers[ cp_id ];
			if( (selected_cp_id == 'combined' && cp.checked ) || selected_cp_id == cp_id){
				cp.d = 1;
			}else{
				cp.d = 0;
			}			
		}	
		//redraw tabs
		this.drawTabs();
		//update the search results: 
		this.runSearch();	 		
	},
	setDispMode:function(mode){
		js_log('setDispMode:' + mode);
		this.result_display_mode=mode;	
		//run /update search display:
		this.drawOutputResults();
	}
}
//default values: 
// tag_name@{attribute}
var rsd_default_rss_item_mapping = {
	'poster'	: 'media:thumbnail@url',
	'roe_url'	: 'media:roe_embed@url',
	'title'		: 'title',
	'link'		: 'link',
	'desc'		: 'description'
}
var mvBaseRemoteSearch = function(initObj) {
	return this.init(initObj);
};
mvBaseRemoteSearch.prototype = {
	
	completed_req:0,
	num_req:0,	
		
	resultsObj:{},	
	
	//default search result values for paging: 
	offset 			:0,	
	limit  			:20,
	more_results	:false,
	num_results		:null,
	
	//init the object: 
	init:function( initObj ){		
		js_log('mvBaseRemoteSearch:init');
		for(var i in initObj){
			this[i] = initObj[i];
		}
		return this;
	},
	/*
	* Parses and adds video rss based input format
	* @data XML 		data to parse
	* @provider_url 	the source url (used to generate absolute links)  
	*/
	addRSSData:function( data , provider_url ){
		var _this = this;
		var http_host = '';
		var http_path = '';		
		if(provider_url){
			pUrl =  parseUri( provider_url );
			http_host = pUrl.protocol +'://'+ pUrl.authority;  
			http_path = pUrl.directory;
		}
		items = data.getElementsByTagName('item');
		$j.each(data.getElementsByTagName('item'), function(inx, item){		
			var rObj ={};			
			for(var i in rsd_default_rss_item_mapping){								
				var selector = rsd_default_rss_item_mapping[i].split('@');
				
				var tag_name = selector[0];
				var attr_name = null;								
				
				if( selector[1] )
					attr_name = selector[1];
				
				//grab the first match 
				var node = item.getElementsByTagName( tag_name )[0];
				//js_log('node: ' + node +  ' nv:' +  $j(node).html() + ' nv[0]'+ node.innerHTML + 
				//' cn' + node.childNodes[0].nodeValue  );				
					
				if( node!=null && attr_name == null ){
					if( node.childNodes[0] != null){			
						rObj[i] =  node.textContent;						
					}			
				}	
								
				if( node!=null && attr_name != null)
					rObj[i] = $j(node).attr( attr_name );									
			}	
			//make relative urls absolute:
			var url_param = new Array('src', 'poster'); 
			for(var j=0; j < url_param.length; j++){
				var p = url_param[j];
				if(typeof rObj[p] != 'undefined'){
					if( rObj[p].substr(0,1)=='/' ){				
						rObj[p] = http_host + rObj[p];
					}
					if( parseUri( rObj[i] ).host ==  rObj[p]){
						rObj[p] = http_host + http_path + rObj[p];
					}
				}
			}			
			//force a mime type for now.. in the future generalize for other RSS feeds 
			rObj['mime'] = 'video/ogg';
			//add pointer to parent search obj:( this.cp.limit )? this.cp.limit : this.limit,
		
			rObj['pSobj'] = _this;
			//add the result to the result set: 
			_this.resultsObj[inx] = rObj;			
		});
	},
	//by default just return the existing image: 
	getImageObj:function( rObj, size, callback){
		callback( {'url':rObj.poster} );
	},
	getEmbedObjParsedInfo:function(rObj, eb_id){
		return rObj;
	},
	getEmbedWikiText:function(rObj){
		var layout = ( rObj.layout)? rObj.layout:"right"
		var o= '[[' + this.rsd.cFileNS + ':' + rObj.target_resource_title + '|thumb|'+layout;
			
		if(rObj.target_width)
			o+='|' + rObj.target_width + 'px';
		
		if( rObj.inlineDesc ) 
			o+='|' + rObj.inlineDesc;
			
		o+=']]';
		return o;
	},
	updateDataForImport:function( rObj ){
		return rObj;
	}
}
/*
* api modes (implementations should call these objects which inherit the mvBaseRemoteSearch  
*/
var metavidSearch = function(initObj) {		
	return this.init(initObj);
};
metavidSearch.prototype = {
	reqObj:{  //set up the default request paramaters
		'order':'recent',
		'feed_format':'rss'		
	},
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
	},	
	getSearchResults:function(){
		var _this = this;
		//start loading:
		_this.loading= 1;
		js_log('metavidSearch::getSearchResults()');
		//proccess all options
		var url = this.cp.api_url;
		//add on the req_param
		for(var i in this.reqObj){
			url += '&' + i + '=' + this.reqObj[i];
		}
		//do basic query:
		this.last_query = $j('#rsd_q').val();
		this.last_offset = cp.offset;
		url += '&f[0][t]=match&f[0][v]=' + $j('#rsd_q').val();
		//add offset limit: 
		url+='&limit=' + this.cp.limit;
		url+='&offset=' + this.cp.offset;
		
		do_request(url, function(data){ 
			//should have an xml rss data object:
			_this.addRSSData( data , url );
			//do some metavid specific pos processing on the rObj data: 
			for(var i in _this.resultsObj){
				var rObj = _this.resultsObj[i];	
				var proe = parseUri( rObj['roe_url'] );				
				rObj['start_time'] = proe.queryKey['t'].split('/')[0];
				rObj['end_time'] = proe.queryKey['t'].split('/')[1];	
				rObj['stream_name'] = proe.queryKey['stream_name'];
				//transform the title into a wiki_safe title: 			
				//rObj['titleKey'] = proe.queryKey['stream_name'] + '_' + rObj['start_time'].replace(/:/g,'.') + '_' + rObj['end_time'].replace(/:/g,'.') + '.ogg';
				rObj['titleKey'] = proe.queryKey['stream_name'] + '/' + rObj['start_time'] + '/' + rObj['end_time'] + '__.ogg';						
			}			
			//done loading: 
			_this.loading=0;
		});
	},
	getEmbedWikiText:function(rObj, options){
		//if we are using a local copy do the standard b:  
		if( this.cp.local_copy == true)
			return this.parent_getEmbedWikiText(rObj, options);								
		//if local_copy is false and embed metavid extension is enabled: 		
		return 
	},
	getEmbedHTML:function( rObj , options ){
		var id_attr = (options['id'])?' id = "' + options['id'] +'" ': '';
		var style_attr = (options['max_width'])?' style="width:'+options['max_width']+'px;"':'';		
		if(options['only_poster']){
			return '<img ' + id_attr + ' src="' + rObj['poster']+'" ' + style_attr + '>';	
		}else{
			return '<video ' + id_attr + ' roe="' + rObj['roe_url'] + '"></video>';
		}
	},	
	getEmbedObjParsedInfo:function(rObj, eb_id){
		var sources = $j('#'+eb_id).get(0).media_element.getSources();
		rObj.other_versions ='*[' + rObj['roe_url'] + ' XML of all Video Formats and Timed Text]'+"\n";
		for(var i in sources){
			var cur_source = sources[i];
			//rObj.other_versions += '*['+cur_source.getURI() +' ' + cur_source.title +']' + "\n";			
			if( cur_source.id ==  this.cp.target_source_id)
				rObj['url'] = cur_source.getURI();
		}
		js_log('set url to: ' + rObj['url']);
		return rObj;			
	},
	//update rObj for import:
	updateDataForImport:function( rObj ){
		rObj['author']='US Government';
		//convert data to UTC type date:
		var dateExp = new RegExp(/_([0-9]+)\-([0-9]+)\-([0-9]+)/);	
		var dParts = rObj.link.match (dateExp);
		var d = new Date();
		var year_full = (dParts[3].length==2)?'20'+dParts[3].toString():dParts[3];
		d.setFullYear(year_full, dParts[1]-1, dParts[2]);	
		rObj['date'] = 	d.toDateString();		
		rObj['licence_template_tag']='PD-USGov';		
		//update based on new start time: 		
		js_log('url is: ' + rObj.src + ' ns: ' + rObj.start_time + ' ne:' + rObj.end_time);		
						
		return rObj;
	}
}

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
		var _this = this;
		this.loading=true;
		js_log('f:getSearchResults for:' + $j('#'+this.target_input).val() );		
		//empty out the current results: 
		this.resultsObj={};
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
		this.last_query = $j('#rsd_q').val();
		//setup the number of requests result flag: 				
		//do_api_req( reqObj, this.cp.api_url , function(data){			
			//parse the return data
		//	_this.addResults( data);				
		//	_this.checkRequestDone();			
		//});							
		//also do a request for page titles (would be nice if api could query both at the same time) 
		reqObj['gsrwhat']='text';
		do_api_req( reqObj, this.cp.api_url , function(data){
			//parse the return data
			_this.addResults( data);
			//_this.checkRequestDone(); //only need if we do two queries one for title one for text
			_this.loading = false;
		});			
	},	
	addResults:function( data ){	
		var _this = this
		//check if we have 
		if( typeof data['query-continue'].search != 'undefined')
			this.more_results = true;			
		//make sure we have pages to iderate: 
		if(data.query && data.query.pages){
			for(var page_id in  data.query.pages){
				var page =  data.query.pages[ page_id ];
				//make sure the page is not a redirect
				if(page.revisions[0]['*'].indexOf('#REDIRECT')===0){
					//skip page is redirect 
					continue;
				}
												
				this.resultsObj[page_id]={
					'titleKey':page.title,
					'link':page.imageinfo[0].descriptionurl,				
					'title':page.title.replace(/File:|.jpg|.png|.svg|.ogg|.ogv/ig, ''),
					'poster':page.imageinfo[0].thumburl,
					'thumbwidth':page.imageinfo[0].thumbwidth,
					'thumbheight':page.imageinfo[0].thumbheight,
					'mime':page.imageinfo[0].mime,
					'src':page.imageinfo[0].url,
					'desc':page.revisions[0]['*'],		
					//add pointer to parent serach obj:
					'pSobj':_this,			
					'meta':{
						'categories':page.categories
					}
				}
				//for(var i in this.resultsObj[page_id]){
				//	js_log('added '+ i +' '+ this.resultsObj[page_id][i]);
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
			'titles':rObj.titleKey,
			'prop':'imageinfo',
			'iiprop':'url|size|mime' 
		}
		//set the width: 
		if(size.width)
			reqObj['iiurlwidth']= size.width;				 
 
		do_api_req( reqObj, this.cp.api_url , function(data){
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
		if(rObj.mime.indexOf('application/ogg')!=-1){
			return '<video ' + id_attr + 
						' src="' + rObj.src + '" ' +
						style_attr +
						' poster="'+  outOpt.url + '" '+
						' ></video>'; 
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