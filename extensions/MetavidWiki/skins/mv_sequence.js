/*sequencer helper code */

mv_addLoadEvent(setup_sequencer); 	
mvSeq=null;
function setup_sequencer(){	
	mv_do_sequence({
		mv_pl_url_id:'mv_pl_url',
		video_container_id:'mv_video_container',
		sequence_tools_id:'MV_SequenceTools',
		timeline_id:'MV_SequenceTimeline'
	});		
}	


/*
 * similar to mv_d_ajax_form_submit in mv_stream.js
 * @@todo could be merged with mv_do_ajax_form_submit from mv_stream (into mv_common.js or something like that)
 * */
function mv_do_ajax_form_submit(mvd_id, edit_action){
	if(mvSeq==null){
		js_error('sequence is not ready...');
		return '';
	}
	//set sajax to do a post request
	sajax_request_type='POST';
	var args = new Object(); 
	var post_vars = new Object();			
	
	var form =  document.getElementById('mvd_form_'+mvd_id);
	var buttonList = {'wpSave':true, 'wpPreview':true, 'wpLivePreview':true, 'wpDiff':true};
	for(i=0;i<form.elements.length;i++){		
		if(buttonList[ form.elements[i].name ]){
			//don't include button unless its the edit action 	
			if(form.elements[i].name.toLowerCase().indexOf( edit_action.toLowerCase() )!=-1){				
				post_vars[ form.elements[i].name ]=form.elements[i].value;
			}
		}else{
			post_vars[ form.elements[i].name ]=form.elements[i].value;	
		}
		//js_log(form.elements[i].name + ' = ' + form.elements[i].value);
	}
	post_vars['inline_seq'] = mvSeq.getSeqText('inline');	
	
	js_log("sending: edit action:"+ edit_action + ' url:'+ post_vars.toSource());
		
	$j('#mv_seq_edit_preview').html( global_loading_txt);	
	uri = wgServer +
		((wgServer == null) ? (wgScriptPath + "/index.php") : wgScript) +
		"?action=ajax";
	//add in mediaWiki ajax hook req 
	uri+='&rs=mv_edit_sequence_submit';
	$j.post(uri, post_vars, function(data){
		switch(edit_action){
			case 'save':
				eval(data);
				if(mv_result['status']=='ok'){					
					//wait 1 seconds to give time for defered updates
					setTimeout(function(){
						window.location.href = wgServer+
						((wgServer == null) ? (wgScriptPath + "/index.php") : wgScript) +
						'/' + wgPageName + '?action=purge';
					}, 1000);
				}else if(mv_result['status']=='error'){
  					$j('#mv_seq_edit_preview').html( mv_result['error_txt'] );   				
	  			}
			break;
			case 'preview':
				$j('#mv_seq_edit_preview').html(data);
			break;
		}
	})
	//do not actually submit
	return false;
}
function mv_seqtool_disp(tool_key){
	//hide all not part of the key 
	$j('.mv_seq_tool').each(function(i){
		if(this.id!='mvseq_'+tool_key)$j(this).fadeOut("fast");
	});
	if($j('#mvseq_'+tool_key).length==0){		
		$j('#mv_seqtool_cont').append('<div class="mv_seq_tool" id="mvseq_'+tool_key+'">' +
				global_loading_txt + '</div>');
		//do the request load the added tool
		uri = wgServer +
		((wgServer == null) ? (wgScriptPath + "/index.php") : wgScript) +
		"?action=ajax";
		uri+='&rs=mv_seqtool_disp&rsargs[]='+tool_key;
		$j('#mvseq_'+tool_key).load(uri, function(){
			//add post hooks based on key: 
			switch(tool_key){
				case 'add_clips_manual': 
					mv_manual_hooks(); 
				break;
				case 'add_clips_search':
					mvJsLoader.doLoad({'mv_setup_search':'../mv_search.js'},function(){
						mv_setup_search('ajax');
					});
				break;
			}
		});
	}else{
		$j('#mvseq_'+tool_key).fadeIn("fast");
	}
	
}
function mv_ajax_search_callback(){
	js_log('mv_ajax_search_callback');
	//rewrite pagging with ajax
	$j('#mv_search_pagging a').each(function(){
			$j(this).attr('href', 'javascript:mv_do_ajax_search_request(\''+$j(this).attr('href')+'&seq_inline=true\')');
	});
	//$j('.mv_rtdesc').each(function(){
	//	$j(this).prepend('<img onClick=" title="'+getMsg('add_to_end_of_sequence')+'" src="'+mv_embed_path + 'images/application_side_expand.png">');			
	//});
}
//applies mv_seq manual javascript bindings
function mv_manual_hooks(){
	js_log('mv_manual_hooks');
	//load empty mv_embed in #mv_seq_manual_embed
		//will be updated based on autocomplete and selected range of selectors
	//add autocomplete hook to stream_name #mv_add_stream_name
		uri = wgServer +
		((wgServer == null) ? (wgScriptPath + "/index.php") : wgScript);
		$j('#mv_add_stream_name').autocomplete(
			uri,
			{
				autoFill:true,
				onItemSelect:function(v){		
					js_log('selected:' + v.innerHTML );
					//unhide adjustment & add hooks (with duration) : 
					$j('#mv_add_adj_cnt').fadeIn('fast');
					add_adjust_hooks('seq', $j(v).children('.mv_stream_duration').html() );
					//add embed video clip: 
					var embedCode = $j(v).children('.mv_vid_embed').html();					
					$j('#mv_seq_manual_embed').fadeIn('fast');
					$j('#mv_seq_manual_embed').html( embedCode );			
					
					js_log("embed code:"+ $j('#mv_seq_manual_embed').html() );	
					
					//base height: 
					var mv_seq_base_height = $j('#mv_seq_manual_embed').height();
											
					//run mv_embed rewrite for the video tag: 
					rewrite_by_id('vid_seq');
					var vid_seq = $j('#vid_seq').get(0);
					//override play action:
					vid_seq['old_play']= vid_seq['play'];
					vid_seq['old_stop']= vid_seq['stop'];
					vid_seq['play'] = function(){
						vid_seq.old_play();
						$j('#mv_seq_manual_embed').css('height', (mv_seq_base_height+70) +'px');
						js_log('height is: ' + $j('#mv_seq_manual_embed').css('height'));										}
					vid_seq['stop']=function(){
						$j('#mv_seq_manual_embed').css('height',mv_seq_base_height +'px');
						vid_seq.old_stop();
					}
					//@@todo add_drag_drop_hook();
					
					//add a title output: 
					$j('#mv_seq_manual_embed').append('<span id="mv_seq_player_time" class="mv_video_time_hr">0:00:00 to 0:00:30</span>');	
					//'mv_edit_im_'+mvd_id
					//$j('#mv_edit_im_'+mvd_id).attr('src', $j(v).children('img').attr('src'));
				},
				formatItem:function(row){
					//hide the duration and embed video in there: 	
					 var out = '<div style="display:none;" class="mv_stream_duration">'+row[3]+'</div>' +
						   '<div style="display:none;" class="mv_vid_embed">'+row[4]+'</div>' + 
						   '<img width="80" height="60" src="'+ row[2] + '">'+row[1];	
					js_log('OUT:'+ out);
					return	out;			
				},
				matchSubset:0,
				extraParams:{action:'ajax',rs:'mv_auto_complete_stream_name'},
				paramName:'rsargs[]',
				resultElem:'#mv_add_stream_name_choices'
			});			
	
	//add clip adjustment hooks			
}
function mv_add_to_seq(target){
	js_log('mv_add_to_seq');
	//add to the seq: 
	if(mvSeq){
		if(target){
			mvSeq.addClip({
				track_id:0,
				type:'mvClip',
				mvclip:target.mvclip,
				src: target.src,
				img:target.img_url
			});
		}else{
			//do a preloaded mvSeq clip (get the src) 
			var spos = $j('#vid_seq').get(0).thumbnail.indexOf('size=');
			var sepos = $j('#vid_seq').get(0).thumbnail.indexOf('&', spos);
			var end_img_url = (sepos!=-1)? $j('#vid_seq').get(0).thumbnail.substring(sepos):'';
			
			var img_url = (spos!=-1)?
				 $j('#vid_seq').get(0).thumbnail.substring(0, spos) + 'size=320x240'+end_img_url:
			 	 $j('#vid_seq').get(0).thumbnail;
			mvSeq.addClip({
				track_id:0,
				type:'mvClip',
				mvclip:$j('#mv_add_stream_name').val() +'?t='+ $j('#mv_start_hr_seq').val() + '/'+
					 $j('#mv_end_hr_seq').val(),
				src: $j('#vid_seq').get(0).src,
				img:img_url
			});
		}
	}else{
		js_error("error: sequence is not present");
	}
}
//currently disabled: 
function add_drag_drop_hook(){
	/* helper: function(){
				$j('body').append($j(this).clone().attr({
					id:'img_thum_vid_seq_drag',
					style:'position:absolute',
					zindex:99
				}).get(0));		
				return $j('#img_thum_vid_seq_drag').get(0);		
			},
	 */
	$j('#img_thumb_vid_seq').draggable({
			opacity:50,
			scroll:true,			
			zindex:99,
			drag:function(e, ui){
				js_log('left: '+ui.position.left);
			}
	});
	//add drop targets on clips if sequence 
	if(mvSeq){
		for(i in mvSeq.tracks){
			for(j in mvSeq.tracks[i]){
				clip = mvSeq.tracks[i].clips[j];
				$j('#track_'+i+'_clip_'+j).droppable({
					over:function(e, ui){
						$j(this).css('border-left', 'solid thick red');
					},
					out:function(e, ui){
						$j(this).css('border-left', 'solid thin white');
					},
					drop:function(e, ui){
						js_log('drop');
					}
				});
			}
		}
	}
}
function do_video_time_update(start_time, end_time){
	$j('#mv_seq_player_time').html( start_time + ' to ' + end_time );
	if(typeof embed_id=='undefined')embed_id='vid_seq';
	js_log('embed_id:' + embed_id + ' src:'+$j('#'+embed_id).get(0).src );
	if(typeof org_vid_src=='undefined')org_vid_src=$j('#'+embed_id).get(0).src;
	if(typeof org_thum_src=='undefined')org_thum_src=$j('#'+embed_id).get(0).thumbnail;
	
	if(org_vid_src.indexOf('?')!=-1){
		var url = org_vid_src.split('?');
		var new_vid_url = url[0] + '?t=' + start_time+'/'+end_time;
		//js_log("new vid url:" +new_vid_url);
		if(new_vid_url!=$j('#'+embed_id).attr('src'))
			$j('#'+embed_id).get(0).updateVideoSrc(new_vid_url);
	}
	if(org_thum_src.indexOf('?')!=-1){
		var url = org_thum_src.split('?');
		var sloc = org_thum_src.indexOf('size=');
		if( sloc !=-1 ){
			var size = '&'+ org_thum_src.substr(org_thum_src.indexOf('size=')) ;
			//strip additonal arguments if they past size=
			if(size.indexOf('&')!=-1){
				size = size.substr(0, size.indexOf('&'));
			}
		}else{
			var size ='';
		}
		var new_thumb = url[0] +'?t='+ start_time +size;	 
		//js_log("new thumb:" + new_thumb);
		if(new_thumb!=$j('#'+embed_id).get(0).thumbnail)
			$j('#'+embed_id).get(0).updateThumbnail(new_thumb);		
	}	
	//make sure the drag hook is applied to the new thumb: 
	//add_drag_drop_hook();
}
/* build_sequence_from_playlist_state()
 * 
 * gets sequence tag code from the current playlist object
 */
function build_sequence_from_playlist_state(){
	
}
