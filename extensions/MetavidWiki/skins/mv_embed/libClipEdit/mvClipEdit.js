/*
	hanndles clip edit controls 
	'inoutpoints':0,	//should let you set the in and out points of clip
	'panzoom':0, 		//should allow setting keyframes and tweenning modes			
	'overlays':0, 		//should allow setting "locked to clip" overlay tracks 
	'audio':0			//should allow controlling the audio volume (with keyframes) 
*/
//set gMsg object:
loadGM( { 
	"mv_crop":"Crop Image",
	"mv_apply_crop":"Apply Crop to Image",
	"mv_reset_crop":"Rest Crop",
	"mv_insert_image_page":"Insert Into page",
	"mv_preview_insert":"Preview Insert",
	"mv_cancel_image_insert":"Cancel Image Insert",
	
	"sc_fileopts":"Clip Detail Edit",
	"sc_inoutpoints":"Set In-Out points",
	"sc_panzoom":"Pan Zoom Crop",
	"sc_overlays":"Overlays",
	"sc_audio":"Audio Control",
	"sc_duration":"Duration",
		
	"mv_template_properties":"Template Properties",
	"mv_custom_title":"Custom Title",
	"mv_edit_properties":"Edit Properties",
	"mv_other_properties":"Other Properties",
	"mv_resource_page":"Resource Page"
});

var default_clipedit_values = {
	'rObj':	null, 		// the resource object
	'clip_disp_ct':null,//target clip disp
	'control_ct':null, 	//control container
	'media_type': null, //media type
	'parent_ct': null, 	//parent container
			
	'p_rsdObj': null,	//parent remote search object
	'p_seqObj': null, 	//parent sequence Object
	
	'edit_action': null, //the requested edit action
	'profile': 'inpage' //the given profile either "inpage" or "sequence"
						//timeline invokes the timeline editor (letting you set keyframes)
}
var mvClipEdit = function(initObj) {		
	return this.init(initObj);
};
mvClipEdit.prototype = {
	
	selTool:null, //selected tool
	crop: null, //the crop values
	base_img_src:null,
	
	init:function( initObj){
		//init object: 
		for(var i in default_clipedit_values){
			if( initObj[i] ){   
				this[i] = initObj[i];
			}
		}

		//if media type was not supplied detect for resource if possible:
		//@@todo more advanced detection. 
		if(!this.media_type){
			if( this.rObj.type.indexOf("image/") === 0){
				this.media_type = 'image';
			}else if( this.rObj.type.indexOf("video/") === 0){
				this.media_type = 'video';
			}else if( this.rObj.type.indexOf("text/") === 0){
				this.media_type = 'template';
			}
		}		
		//display control:
		if(this.profile == 'sequence'){			
			this.doEditTypesMenu();
			this.doDisplayEdit();
		}else{				
			//check the media_type:
			js_log('mvClipEdit:: media type:' + this.media_type + ' base width: ' + this.rObj.width + ' bh: ' + this.rObj.height);		
			//could seperate out into media Types objects for now just call method
			if(this.media_type == 'image'){
				this.setUpImageCtrl();
			}else if(this.media_type=='video'){
				this.setUpVideoCtrl();
			}		
		}
	},
	
	//master edit types object:
	//maybe we should refactor these into their own classes  
	//more refactor each media type should be its own class inheriting the shared baseEditType object
	edit_types:{		
		'duration':{
			d:1,
			'media':['image','template'],
			'doEdit':function( _this ){
				//do clock mouse scroll duration editor
				$j('#sub_cliplib_ic').html('cur dur: ' + _this.rObj.dur );
			}			
		},
		'inoutpoints':{
			'd':1,
			'media':['video'],
			'doEdit':function( _this ){
				var cat = _this.rObj
				//debugger;
				//do clock mouse scroll duration editor
				var end_ntp = ( _this.rObj.embed.end_ntp) ? _this.rObj.embed.end_ntp : _this.rObj.embed.getDuration();
				if(!end_ntp)
					end_ntp = seconds2ntp( _this.rObj.dur );
				$j('#sub_cliplib_ic').html(
					_this.getSetInOut({
						'start_ntp'	: _this.rObj.embed.start_ntp, 
						'end_ntp'	: 	end_ntp
					})		
				);
				_this.setInOutBindings();
			}		
		},
		'fileopts':{
			'd':0,
			'media':['image','video','template'],
			'doEdit':function( _this ){		
				var doEditHtml = function(){
					//add html for rObj resource:
					var o=	'<table>' +
							'<tr>' +
								'<td colspan="2"><b>'+gM('mv_edit_properties')+'</b></td>'+
							'</tr>'+
							'<tr>'+
								'<td>' + 
									gM('mv_custom_title') + 
								'</td>'+
								'<td><input type="text" size="15" maxwidth="255" value="';
									if(_this.rObj.title != null)
										o+=_this.rObj.title;
									o+='">'+
								'</td>'+
							'</tr>';		
					if( _this.rObj.tVars){
						var existing_p = _this.rObj.params;
						var testing_a = _this.rObj.tVars;
						//debugger;
						o+= '<tr>'+
								'<td colspan="2"><b>'+gM('mv_template_properties')+'</b></td>'+
							'</tr>';
						for(var i =0; i < _this.rObj.tVars.length ; i++){
							o+='<tr>'+
								'<td>' + 
									_this.rObj.tVars[i] + 
								'</td>' +
								'<td><input type="text" size="15" maxwidth="255" value="';
							if(_this.rObj.params[ _this.rObj.tVars[i] ]){
								o+= _this.rObj.params[ _this.rObj.tVars[i] ];
							}
							o+='">'+ 
								'</td>'+
							'</tr>';		
						}
					}		
					o+=		'<tr>'+
								'<td colspan="2"><b>'+gM('mv_other_properties')+'</b></td>'+
							'</tr>'+
							'<tr>'+
								'<td>' + 
									gM('mv_resource_page') + 
								'</td>' +
								'<td><a href="' + wgArticlePath.replace(/\$1/, _this.rObj.uri ) +
									' target="new">'+
										_this.rObj.uri + '</a>'+
								'</td>'+
							'</tr>';
					o+='</table>'; 
					
					$j('#sub_cliplib_ic').html ( o );
					//add update bindings	
							
					//update doFocusBindings
					if( _this.p_seqObj )
						_this.p_seqObj.doFocusBindings();
				}	
				//if media type is template we have to query to get its URI to get its paramaters
				if(_this.media_type == 'template' && !_this.rObj.tVars){		
					mv_set_loading('#sub_cliplib_ic');
					var reqObj ={	'action':'query',
									'prop':'revisions',
									'titles': _this.rObj.uri,
									'rvprop':'content' 
								};
					//get the interface uri from the plObject
					var api_url = _this.p_seqObj.plObj.interface_url.replace(/index\.php/, 'api.php'); 
					//first check 					
					do_api_req( {
						'data':reqObj,
						'url':api_url
						}, function(data){
							if(typeof data.query.pages == 'undefined')
								return doEditHtml();
							for(var i in data.query.pages){
								var page = data.query.pages[i];
								var template_rev = page['revisions'][0]['*'];
							}						
							
							//do a regular ex to get the ~likely~ template values 
							//(ofcourse this sucks)
							//but maybe this will make its way into the api sometime soon to support wysiwyg type editors
							//idealy it would expose a good deal of info about the template params
							js_log('matching against: ' + template_rev);
							var tempVars = template_rev.match(/\{\{\{([^\}]*)\}\}\}/gi);
							//clean up results:
							_this.rObj.tVars = new Array();
							for(var i=0; i < tempVars.length; i++){
								var tvar = tempVars[i].replace('{{{','').replace('}}}','');
								//strip anything after a | 
								if(tvar.indexOf('|') != -1){
									tvar = tvar.substr(0, tvar.indexOf('|'));
								}														
								//check for duplicates: 
								var do_add=true;
								for(var j=0; j < _this.rObj.tVars.length; j++){
									js_log('checking: ' + _this.rObj.tVars[j] + ' against:' + tvar);
									if( _this.rObj.tVars[j] == tvar)
										do_add=false;
								}
								//add the template vars to the output obj
								if(do_add)
									_this.rObj.tVars.push( tvar );
							}					
							doEditHtml();
						}
					);
				}else{
					doEditHtml();
				}
				
				
			}		
		},
		'panzoom':{
			'd':0,
			'media':['image','video'],
			'doEdit':function( _this ){
				//do clock mouse scroll duration editor
				$j('#sub_cliplib_ic').html('<h3>Set Position</h3><h3>Set Zoom</h3><h3>Set Crop</h3><h3>Set Aspect</h3>');
			}	
		},				
		'overlays':{
			'd':0,
			'media':['image','video'],
			'doEdit':function( _this ){
				//do clock mouse scroll duration editor
				$j('#sub_cliplib_ic').html('<h3>Current Overlays:</h3>Add,Remove,Modify');
			}	
		},
		'audio':{
			'd':0,
			'media':['image','video', 'template'],
			'doEdit':function( _this ){
				//do clock mouse scroll duration editor
				$j('#sub_cliplib_ic').html('<h3>Audio Volume:</h3>');
			}	
		}		
	},	
	doEditTypesMenu:function(){
		var _this = this;
		//add in subMenus if set
		//check for submenu and add to item container		
		var o='';								
		o+= '<ul id="mv_submenu_clipedit" class="mv_submenu">';		 
		$j.each(this.edit_types, function(sInx, editType){			
			//check if the given editType is valid for our given media type
			var include = false;
			for(var i =0; i < editType.media.length;i++){
				if( editType.media[i] == _this.media_type)
					include = true; 
			}
			if(include){
				var sub_sel_class = (editType.d == 1)?'class="mv_sub_selected"':'';							 
				o+= '<li ' + sub_sel_class + ' id="mv_smi_' + sInx + '">' + 
					gM('sc_' + sInx ) + '</li>';
			} 	
		});
		o+= '</ul>';
		//add sub menu container with menu html: 
		o+= '<div id="sub_cliplib_ic" class="submenu_container"></div>';	
		$j('#'+this.control_ct).html( o ) ;	
		//set up bindings: 	
		for( var i in this.edit_types){
			$j('#mv_smi_'+ i).click( function(){				
				_this.doDisplayEdit( $j(this).attr("id").replace('mv_smi_','')  );
			});
		}
	},
	doDisplayEdit:function( edit_type ){
		if(!edit_type)
			for(var i in this.edit_types){
				if(this.edit_types[i].d == 1)
					edit_type = i;
			}
		js_log('doDisplayEdit: ' + edit_type );
		//remove from all
		$j('#mv_submenu_clipedit li').removeClass('mv_sub_selected');
		//add selected class:
		$j('#mv_smi_' + edit_type).addClass('mv_sub_selected');		
		
		//do edit interface for that edit type: 
		if( this.edit_types[ edit_type ].doEdit )
			this.edit_types[ edit_type ].doEdit( this );
	},
	setUpVideoCtrl:function(){
		js_log('setUpVideoCtrl:f');
		var _this = this;
		var eb = $j('#embed_vid').get(0);
		//turn on preview to avoid onDone actions
		eb.preview_mode = true;
		$j('#'+this.control_ct).html('<h3>Edit Video Tools:</h3>');
		if( eb.supportsURLTimeEncoding() ){			
			$j('#'+this.control_ct).append( 
				_this.getSetInOut({
					'start_ntp'	: eb.start_ntp, 
					'end_ntp'	: eb.end_ntp		
				}) 
			);
			_this.setInOutBindings();			
		}
		$j('#'+this.control_ct).append(	this.getInsertDesc() );
		
		if( _this.p_rsdObj && _this.p_rsdObj.import_url_mode == 'none'){
			// in theory this code should never run since we should nto get past the repository checks 
			$j('#'+this.control_ct).append(	 gM('no_import_by_url') + '<br>' + 			
				'<a href="#" class="mv_cancel_img_edit" title="' + gM('mv_cancel_image_insert')+'">' + gM('mv_cancel_image_insert') + '</a> ' );
		}else{										
			$j('#'+this.control_ct).append(  this.getInsertAction()	);
		}						
		this.applyInsertControlBindings();
	},
	setInOutBindings:function(){
		//setup bindings for adjust / preview:
		add_adjust_hooks( 'rsd' );			 
		$j('#mv_preview_clip').click(function(){			
			$j('#embed_vid').get(0).stop();
			$j('#embed_vid').get(0).play();
		});		
	},
	getSetInOut:function( setInt ){
		return '<strong>Set in-out points</strong>'+
			'<table border="0" style="background: transparent; width:94%;height:50px;">'+
				'<tr>' +
					'<td style="width:50px">'+
						'<span style="font-size: small;" id="track_time_start_rsd">' + setInt.start_ntp +'</span>'+
					'</td>' +
					'<td>' +
						'<div style="border: 1px solid black; width: 100%; height: 5px; background-color: #888;" '+
							'id="container_track_rsd">'+					
							'<div id="resize_rsd" class="ui-resizable ui-draggable">'+						
								'<div class="ui-resizable-w ui-resizable-handle"'+
									' id="handle1_rsd" unselectable="on"/>'+	
									
								'<div class="ui-resizable-e ui-resizable-handle" '+ 
									' id="handle2_rsd" unselectable="on"/>'+
										
								'<div class="ui-dragSpan" id="dragSpan_rsd" style="cursor: move;"/>'+		
							'</div>'+
						'</div>'+
					'</td>' +
					'<td style="width:50px">'+
						'<span style="font-size: small;" id="track_time_end_rsd">'+ setInt.end_ntp +'</span>'+
					'</td>' +
				'</tr>' +
			'</table>'+
			'<span style="float: left;">'+
				'<label class="mv_css_form" for="mv_start_hr_rsd"><i>Start time:</i></label>'+
				'<input id="mv_start_hr_rsd" class="mv_adj_hr" name="mv_start_hr_rsd" value="' + setInt.start_ntp + '" maxlength="8" size="8"/>'+
			'</span>'+
			'<span style="float: left;">'+
				'<label for="mv_end_hr_rsd" class="mv_css_form"><i>End time:</i></label>'+
				'<input name="mv_end_hr_rsd" id="mv_end_hr_rsd" value="' + setInt.end_ntp + '" maxlength="8" size="8" class="mv_adj_hr"/>'+
			'</span>'+
			'<div style="clear: both;"/>'+		
			'<input id="mv_preview_clip" type="button" value="Preview/Play In-out points">';
	},
	getInsertDesc:function(){		
		var o= '<h3>Inline Description</h3>'+ 				
					'<textarea style="width:375px;" id="mv_inline_img_desc" rows="5" cols="30">';				
		if( this.p_rsdObj ){
			//if we have a parent remote search driver let it parse the inline description		
			o+= this.rObj.pSobj.getInlineDescWiki( this.rObj );
		}
		o+='</textarea><br>';		
		return o;
	},
	getInsertAction:function(){
		return '<h3>Actions</h3>'+
				'<input type="button" class="mv_insert_image_page" value="' + gM('mv_insert_image_page') + '"> '+				
				'<input type="button" style="font-weight:bold" class="mv_preview_insert" value="' + gM('mv_preview_insert')+ '"> '+		
				'<a href="#" class="mv_cancel_img_edit" title="' + gM('mv_cancel_image_insert')+'">' + gM('mv_cancel_image_insert') + '</a> ';
	},
	applyEdit:function(){
		js_log('applyEdit::' + this.media_type);
		if(this.media_type == 'image'){
			this.applyCrop();
		}else if(this.media_type == 'video'){
			this.applyVideoAdj();
		}
	},
	applyInsertControlBindings:function(){
		var _this = this;
		$j('.mv_insert_image_page').click(function(){
			_this.applyEdit();			
			//copy over the desc text to the resource object
			_this.rObj['inlineDesc']= $j('#mv_inline_img_desc').val();
			_this.p_rsdObj.insertResource( _this.rObj );
		});
		$j('.mv_preview_insert').click(function(){		
			_this.applyEdit();
			//copy over the desc text to the resource object
			_this.rObj['inlineDesc']= $j('#mv_inline_img_desc').val();
			js_log('going to call previewResource on rObj');
			_this.p_rsdObj.previewResource( _this.rObj );
		});
		$j('.mv_cancel_img_edit').click( function(){
			$j('#' + _this.parent_ct).fadeOut("fast");
		});
	},
	setUpImageCtrl:function(){
		var _this = this;		
		//by default apply Crop tool 
		$j('#'+this.control_ct).html(
			'<h3>Edit tools</h3>' + 				
					'<div class="mv_edit_button mv_crop_button_base" id="mv_crop_button" alt="crop" title="'+gM('mv_crop')+'"/>'+
					'<a href="#" class="mv_crop_msg">' + gM('mv_crop') + '</a> '+
					'<span style="display:none" class="mv_crop_msg_load">' + gM('loading_txt') + '</span> '+
					'<a href="#" style="display:none" class="mv_apply_crop">' + gM('mv_apply_crop') + '</a> '+
					'<a href="#" style="display:none" class="mv_rest_crop">' + gM('mv_reset_crop') + '</a> '+
				'<br style="clear:both"><br>'+				
				/*'<div class="mv_edit_button mv_scale_button_base" id="mv_scale_button" alt="crop" title="'+gM('mv_scale')+'"></div>'+				
				'<a href="#" class="mv_scale_msg">' + gM('mv_scale') + '</a><br>'+
				'<a href="#" style="display:none" class="mv_apply_scale">' + gM('mv_apply_scale') + '</a> '+
				'<a href="#" style="display:none" class="mv_rest_scale">' + gM('mv_reset_scale') + '</a><br> '+
				*/
				_this.getInsertDesc() + 
				_this.getInsertAction()					
		);
		//add bindings: 
		$j('#mv_crop_button,.mv_crop_msg,.mv_apply_crop').click(function(){
			js_log('click:mv_crop_button: base width: ' + _this.rObj.width + ' bh: ' + _this.rObj.height);
			if($j('#mv_crop_button').hasClass('mv_crop_button_selected')){				
				_this.applyCrop();
			}else{
				js_log('click:turn on');
				_this.enableCrop();
			}
		}); 
		$j('.mv_rest_crop').click(function(){
			$j('.mv_apply_crop,.mv_rest_crop').hide();
			$j('.mv_crop_msg').show();
			$j('#mv_crop_button').removeClass('mv_crop_button_selected').addClass('mv_crop_button_base').attr('title',gM('mv_crop'));
			_this.rObj.crop=null;
			$j('#' + _this.clip_disp_ct ).empty().html(
				'<img src="' + _this.rObj.url + '" id="rsd_edit_img">'
			);
		});		
		this.applyInsertControlBindings();
	},
	applyVideoAdj:function(){		
		js_log('applyVideoAdj::');				
		//update video related keys		
		this.rObj['start_time'] = $j('#mv_start_hr_rsd').val();
		this.rObj['end_time'] = $j('#mv_end_hr_rsd').val();
		//if the video is "roe" based select the ogg stream		
		if( this.rObj.roe_url && this.rObj.pSobj.cp.stream_import_key){			
			var source = $j('#embed_vid').get(0).media_element.getSourceById( this.rObj.pSobj.cp.stream_import_key );
			this.rObj['src'] = source.getURI();
			js_log("g src_key: " + this.rObj.pSobj.cp.stream_import_key + ' src:' + this.rObj['src']) ;
		}		
	},
	applyCrop:function(){
		var _this = this;
		$j('.mv_apply_crop').hide();
		$j('.mv_crop_msg').show();
		$j('#mv_crop_button').removeClass('mv_crop_button_selected').addClass('mv_crop_button_base').attr('title',gM('mv_crop'));
		js_log('click:turn off');
		if(_this.rObj.crop){
			//empty out and display croped:
			$j('#'+_this.clip_disp_ct ).empty().html(
				'<div id="mv_cropcotainer" style="overflow:hidden;position:absolute;'+
					'width:' + _this.rObj.crop.w + 'px;'+
					'height:' + _this.rObj.crop.h + 'px;">'+
					'<div id="mv_crop_img" style="position:absolute;'+
						'top:-' + _this.rObj.crop.y +'px;'+
						'left:-' + _this.rObj.crop.x + 'px;">'+
						'<img src="' + _this.rObj.url + '">'+
					'</div>'+
				'</div>'						
			);
		}
	},
	//right now enableCrop loads "just in time" 
	//@@todo we really need an "auto loader" type system. 
	enableCrop:function(){
		var _this = this;
		$j('.mv_crop_msg').hide();
		$j('.mv_crop_msg_load').show();
		var doEnableCrop = function(){	
			$j('.mv_crop_msg_load').hide();
			$j('.mv_rest_crop,.mv_apply_crop').show();				
			$j('#mv_crop_button').removeClass('mv_crop_button_base').addClass('mv_crop_button_selected').attr('title',gM('mv_crop_done'));				
			$j('#' + _this.clip_disp_ct + ' img').Jcrop({
			 		onSelect: function(c){
			 			js_log('on select:' + c.x +','+ c.y+','+ c.x2+','+ c.y2+','+ c.w+','+ c.h);
			 			_this.rObj.crop = c;
			 		},
	      			onChange: function(c){            				
	      			}        				
			});
		}		
		if(typeof $j.Jcrop == 'undefined'){
			loadExternalCss( mv_embed_path + 'jquery/plugins/Jcrop/css/jquery.Jcrop.css');
			//load the jcrop library if needed:
			mvJsLoader.doLoad({'$j.Jcrop':'jquery/plugins/Jcrop/js/jquery.Jcrop.js'},function(){
				doEnableCrop();
			});			
		}else{
			doEnableCrop();
		}
		
	}
}



// mv_lock_vid_updates defined in mv_stream.js (we need to do some more refactoring )
if(typeof mv_lock_vid_updates == 'undefined')
	mv_lock_vid_updates= false;

function add_adjust_hooks(mvd_id){
	js_log('add_adjust_hooks: ' + mvd_id );	
	//if options are unset populate functions:
	//add mouse over end time frame highlight
	$j('#mv_end_hr_'+mvd_id).hoverIntent({interval:200,over:function(){
		//js_log('pre style: ' + $j(this).css('border'));
		$j(this).css('border','solid red');
 		do_video_time_update( $j('#mv_end_hr_'+mvd_id).val(), $j('#mv_end_hr_'+mvd_id).val() );
	},out:function(){
		$j(this).css('border','solid black thin');
		do_video_time_update($j('#mv_start_hr_'+mvd_id).val(), $j('#mv_end_hr_'+mvd_id).val() );
	}});
	//add onchange js hooks:
	$j('.mv_adj_hr').change(function(){
		//preserve track duration for nav and seq:
		//ie seems to crash so no interface updates for IE for the time being
		if(!$j.browser.msie){
			if(mvd_id=='nav'||mvd_id=='seq'){
				add_adjust_hooks(mvd_id);
			}else{
				add_adjust_hooks(mvd_id)
			}
		}
		//update the video time for onChange
		do_video_time_update($j('#mv_start_hr_'+mvd_id).val(), $j('#mv_end_hr_'+mvd_id).val() );
	});
	//read the ntp time from the fields
	var start_sec = ntp2seconds( $j('#mv_start_hr_'+mvd_id).val() );
	var end_sec = ntp2seconds( $j('#mv_end_hr_'+mvd_id).val() );
	js_log('start_sec:'+start_sec + ' end: ' + end_sec);
	if(start_sec > end_sec){
		js_log('start > end : ' + start_sec + ' > ' + end_sec);
		//update end time to start_time + 1 second
		end_sec = parseInt(start_sec+1);
		$j('#mv_end_hr_'+mvd_id).val(seconds2ntp(end_sec));
	}

	var duration = end_sec - start_sec;
	//set the track duration as 2 min or 2*duration (whatever is longer)
	var track_dur = (duration*2<120)?120:duration*2;

	//set the base offset
	if(start_sec==0){
		var base_offset = 0
	}else{
		//make sure we won't go into negative with a 1/4 track offset
		//alert('wtf:s:' + start_sec + '-' + (track_dur*.25) );
		var base_offset= start_sec-(track_dur*.25);
		//alert('wtf: '+ base_offset);
		if(base_offset < 0)
			base_offset=0;
		//js_log('set base offset: '+track_dur +'* .25 = '+ parseInt(base_offset) );
	}
	js_log('BASE OFFSET: '+ base_offset);
	//set the base offset / track_dur interface vars:
	$j('#track_time_start_'+mvd_id).html( seconds2ntp(base_offset) );
	$j('#track_time_end_'+mvd_id).html( seconds2ntp( base_offset+track_dur ));

	//set up start /end slider values:
	var slider_start = (start_sec - base_offset) / track_dur;
	var slider_end = (end_sec - base_offset) / track_dur;
	var slider_dur = slider_end -slider_start;
	//clear out the existing effect if present
	//if(mv_sliders[mvd_id])mv_sliders[mvd_id].dispose();

	//update the slider values (left right)
	track_width = $j('#container_track_'+mvd_id).width();

	js_log('start: '+ slider_start + ' =' + (slider_start*track_width) +
		 ' se:'+ slider_end + ' =' + (slider_end*track_width)  +
		 ' width would be: :' + Math.round((slider_end*track_width)-(slider_start*track_width)));

	//if re-size width less than width of image bump it up:
	var resize_width = Math.round((slider_end*track_width)-(slider_start*track_width));
	if( resize_width < 17 ) resize_width=17;

	$j('#resize_'+mvd_id).css({
		left:Math.round(slider_start*track_width)+'px',
		width: resize_width+'px'
	});
	js_log("track width: " +  $j('#container_track_'+mvd_id).width() +
	' slider_width: ' + $j('#resize_'+mvd_id).width());
	//add an additional flag
	var cur_handle = '';
	$j('.ui-resizable-handle').mousedown( function(){
		js_log('hid: ' + this.id);
		cur_handle = this.id;
	});
	org_start = org_end ='';
	//jQuery slider:
	$j('#resize_'+mvd_id).resizable({
		minWidth: 10,
		maxWidth:  $j('#resize_'+mvd_id).width(),
		minHeight: 20,
		maxHeight: 20,
		handles: {
			e: '.ui-resizable-e',
			w: '.ui-resizable-w'
		},
		start: function(e,ui) {
			mv_lock_vid_updates=true;
			org_start = $j('#mv_start_hr_'+mvd_id).val();
			org_end = 	$j('#mv_end_hr_'+mvd_id).val();
			//js_log("org maxWidth: " + ui.options.maxWidth);
			right_x = ( $j('#resize_'+mvd_id).position().left+
					  $j('#resize_'+mvd_id).width()
				);
			/*js_log('left:' + $j('#resize_'+mvd_id).position().left + ' width: '+
			*	$j('#resize_'+mvd_id).width() + ' right_x:'+ right_x);
			*/
			if(cur_handle.indexOf('handle1')!=-1){
				ui.options.maxWidth= right_x;
			}else{
				ui.options.maxWidth= (
					 $j('#container_track_'+mvd_id).width() -
					$j('#resize_'+mvd_id).position().left
				);
			}
			js_log("updated maxWidth: " + ui.options.maxWidth);
			//js_log('grabbed: ' + e.explicitOriginalTarget.id);
			//console.log('start ', ui);
		},
		stop: function(e,ui) {
			mv_lock_vid_updates=false;
			//console.log('stop ', ui);
			//return the non-adjusted to its original value:
			if(cur_handle.indexOf('handle1')!=-1){
				$j('#mv_end_hr_'+mvd_id).val(org_end);
			}else{
				$j('#mv_start_hr_'+mvd_id).val(org_start);
			}
			//update the clip
			do_video_time_update($j('#mv_start_hr_'+mvd_id).val(), $j('#mv_end_hr_'+mvd_id).val() );
		},
		resize: function(e,ui) {
			base_offset = ntp2seconds( $j('#track_time_start_'+mvd_id).html());
			mv_slider_update_stats(mvd_id);
		}
	});
	$j('#dragSpan_'+mvd_id).css('cursor','move');
	$j('#resize_'+mvd_id).draggable({
		axis:'x',
		containment:'parent',
		handle: "#dragSpan_"+mvd_id,
		drag:function(e, ui){
			mv_slider_update_stats(mvd_id, true);
		},
		stop:function(e,ui){					
			do_video_time_update($j('#mv_start_hr_'+mvd_id).val(), $j('#mv_end_hr_'+mvd_id).val() );
		}
	});
   	//store the necessary values in the slider obj
   	//mv_sliders[mvd_id]['base_offset']=base_offset;
    //mv_sliders[mvd_id]['track_dur']=track_dur;
    function mv_slider_update_stats(mvd_id, drag){
    	var update_start=update_end=false;
    	//only update the side we are dragging:
    	if(cur_handle.indexOf('handle1')!=-1){
    		update_start=true;
    	}else{
    		update_end=true;
    	}
    	if(drag)update_end=update_start=true;
    	if(update_end){
    		var end_time = base_offset + (track_dur *(($j('#resize_'+mvd_id).position().left +
			 	$j('#resize_'+mvd_id).width())	/
			 	$j('#container_track_'+mvd_id).width()));
			if(end_time>(track_dur+base_offset))end_time=track_dur+base_offset;
			$j('#mv_end_hr_'+mvd_id).val( seconds2ntp(end_time) );
    	}
    	if(update_start)
			$j('#mv_start_hr_'+mvd_id).val( seconds2ntp(base_offset + (track_dur *($j('#resize_'+mvd_id).position().left /
				$j('#container_track_'+mvd_id).width()) ) ));
	}
}
function do_video_time_update(start_time, end_time, mvd_id)	{
	js_log('do_video_time_update: ' +start_time + end_time);
	if(mv_lock_vid_updates==false){
		//update the vid title:
		$j('#mv_videoPlayerTime').html( start_time + ' to ' + end_time );
        var ebvid = $j('#embed_vid').get(0);
        if( ebvid ){
	        if(ebvid.isPaused())
	            ebvid.stop();
			ebvid.updateVideoTime(start_time, end_time);
			js_log('update thumb: '+ start_time);		
			ebvid.updateThumbTimeNTP( start_time );
		}
	}
}