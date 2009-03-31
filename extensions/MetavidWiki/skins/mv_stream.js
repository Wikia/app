/*
 * metavid.js Created on June 29, 2007
 *
 * All Metavid Wiki code is Released under the GPL2
 * for more info visit http://metavid.org/wiki/Code
 *
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.org
 *
 *
 * Metavid.js handles all interface js functions for Metavid: namespace
 * [DEPENDENT ON mv_embed]
 * http://metavid.org/wiki/index.php/Mv_embed
 *
 * assumes a few utility functions are available from mv_embed:
 * 	loadExternalJs()
 * 	addLoadEvent()
 */
var org_vid_time_req =null; //store the original time req:
var org_vid_title = null; //stores the original title
//store the original range request:
// @@todo could replace the above 4 globals as they are all org request derived
var current_stream_context='';

var org_height_vid_contain=false;
var org_top_tool_contain=false;

/* flags / state arrays */
//for locking the interface (locked while loading)
var mv_lock_vid_updates=true;
//array for storing sliders
//(deprecated) var mv_sliders = new Object();
//array of original colors for restoring field color.
var mv_tl_mvd_org_color = new Array();
//array to manage state transitions of shaky mouses/browsers
var flag_do_mv_mvd_tlOver = new Array();
//more flags for state transitions
var cur_mvd_over = false;
var mv_flag_fdOver=false;
var golobal_org_ptext=false;

var mvTextScrollMonitorTimer = null;

var mv_open_edit_mvd=null;
if(!gMsg){var gMsg={};}

gMsg['mv_open_edit'] ='you can only edit one at a time, please save or cancel other open edits first';

//@@todo context sensitive init scripts
//init the interface on page load
mv_addLoadEvent(mv_load_interface_libs);

function mv_load_interface_libs(){
	js_log('f:mv_load_interface_libs');
	//we will need mv_embed stuff:
	mvEmbed.load_libs(function(){
		js_log('load stream js');
		//load some additional plugins/components:
		//:hoverIntent
		//http://cherne.net/brian/resources/jquery.hoverIntent.html
		mvJsLoader.doLoad({
			'$j.autocomplete'	: 'jquery/plugins/jquery.autocomplete.js',
			'$j.fn.hoverIntent'	: 'jquery/plugins/jquery.hoverIntent.js',
			'$j.ui.resizable'	: 'jquery/jquery.ui-1.5.2/ui/minified/ui.resizable.min.js',
			'mvClipEdit'		: 'libSequencer/mv_clipedit.js'
	  	},function(){
	  		//now extend draggable
	  		mvJsLoader.doLoad({
				'$j.ui.draggable.prototype.plugins.drag':'jquery/plugins/ui.draggable.ext.js'
		  	},function(){
	  			mv_stream_interface.init();
		  	});
	  	});
	});
}
/*
 * init_interface (on DOM ready)
 *
 * re sizes the mv_overlay component and mv_tools component
 *  to take up the full page space.
 */
var mv_stream_interface = {
	cur_mvd_id:'base',
	interfaceLoaded:false,
	monitorTimerId:0,
	init:function(){
		//don't call multiple times:
		if(this.interfaceLoaded)
			return;
		//set interfaceLoaded flag:
		this.interfaceLoaded=true;
		
		js_log('f:mv_stream_interface.init call');
		//add_custom_effects();
		//set up the init values for mouse over restore:
		org_vid_title = $j('#mv_stream_time').html();
		if( $j('#embed_vid').length==0 || !$j('#embed_vid').get(0).ready_to_play){
			//no embed video present stop init
			js_log('no clip ready to play');
			return false;
		}
		org_vid_time_req = $j('#embed_vid').get(0).getTimeReq();
		$j('#embed_vid').get(0).org_thum_src = $j('#embed_vid').get(0).thumbnail;

		//@@TODO override stop function in player:

		//current range or search parameter
		stream_current_context =$j('#mv_stream_time').html();
		js_log('set org_vid_time_req: ' + org_vid_time_req );
		ebvid = $j('#embed_vid').get(0);		
		//setup text scroll monitor: 
		mv_doTextScrollMonitor();
				
		//add all the hover hooks:
		this.addHoverHooks();

		//add odd even classes (for non-annoative layers
		this.oddEvenPaint();

		//add edit/navigate hook
		var st_input_mode=false;
		$j('#mv_stream_time').click(function(){
			if(!st_input_mode){
				var st = $j('#'+this.id+' .mv_start_time').html();
				var et =  $j('#'+this.id+' .mv_end_time').html();
				$j(this).hide();
				$j(this).after('<form style="display:inline" action="javascript:alert(\'wtf\');" id="td_st_mv_stream_time">' +
						'<input class="videoHeader" id="mv_td_start_time" size="7" value="'+st+'">'+
						'<input class="videoHeader" id="mv_td_end_time" size="7" value="'+et+'"> '+
						'<a href="#" id="mv_td_st_go">go</a> :: '+
						'<a href="#" id="mv_td_st_cancel">cancel</a></form>');
			}
			if(!st_input_mode)st_input_mode=true;
			//bind actions for go/cancel
			function getNavUrl(){
				return wgArticlePath.replace('$1',wgPageName+'/'+$j('#mv_td_start_time').val()+'/'+$j('#mv_td_end_time').val());
			}
			$j('#mv_td_st_go').click(function(){
				window.location=getNavUrl();
				return false;
			});
			$j('#td_st_mv_stream_time input').keypress(function (e) {
				if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
					window.location=getNavUrl();
				}
			});
			$j('#mv_td_st_cancel').click(function(){
				$j('#mv_stream_time').show();
				$j('#td_st_mv_stream_time').remove();
				st_input_mode=false;
				return false;
			});
		});


		//do any tool specific hooks:
		this.tool_key = parseUri(document.URL).queryKey.tool_disp;
		if(this.tool_key){
			mv_proc_tool_result(this.tool_key, {'status':'ok','innerHTML':$j('#mv_tool_cont').html()} );
		}

		//unlock the interface updates once everything is setup:
		mv_lock_vid_updates=false;
		js_log('done with mv_init_inerface');
		//$j('#embed_vid').get(0).stop();		
	},
	oddEvenPaint:function(){
		//remove existing class:
		$j('.mv_fd_mvd').removeClass("odd").removeClass("even");
		$j('.mv_fd_mvd:odd').addClass("odd");
		$j('.mv_fd_mvd:even').addClass("even");		
		//remove odd/even class for annoative layer: 
		$j('.anno_en').removeClass("odd").removeClass("even");
	},
	addHoverHooks:function(selector){
		this_stream=this;
		if(!selector){
			//null selector do init:
			selector='.mv_timeline_mvd_jumper,.mv_fd_mvd';
		}
		js_log('selector: '+selector);
		$j(selector).hoverIntent({
			interval:200, //polling interval
			timeout:200, //delay before onMouseOut
			over:function(){
				//get the mvd_id (the last part of the this.id)
				mvd_id = this.id.split('_').pop();
				//if timeline scroll to position:
				if($j(this).attr('class').indexOf('mv_timeline_mvd_jumper')!=-1){
					scroll_to_pos(mvd_id);
					 	//also add onclick to mv_timeline_mvd_jumper
					$j(this).click(function(){
						mv_do_play(mvd_id);
					});
				}
				this_stream.mvdOver(mvd_id);
			},
			out:function(){
				//get the mvd_id (the last part of the this.id)
				mvd_id = this.id.split('_').pop();
				this_stream.mvdOut(mvd_id);
				//disable the play on click (if not highlighted)
				if($j(this).attr('class').indexOf('mv_timeline_mvd_jumper')!=-1)
					$j(this).click(function(){
						return ;
				});
			}
		});
	},
	mvdOver:function(mvd_id){
		js_log('f:mvdOver' + mvd_id );
		var vid_elm = $j('#embed_vid').get(0);
		//never do mvdOver while video is playing: 
		if( vid_elm.isPlaying() ){
			return false;
		}			
		//stop the video if not already stopped	
		vid_elm.stop();
		mv_lock_vid_updates=false;
		//set the onClipDone_disp to false:	
		this.cur_mvd_id=this.delay_cur_mvd_id=mvd_id;
		do_video_mvd_update(mvd_id);
		highlight_tl_ts(mvd_id);
		highlight_fd(mvd_id);	
	},
	mvdOut:function(mvd_id){		
		var vid_elm = $j('#embed_vid').get(0);
		//only process out if in "stoped" state
		if( vid_elm.isStoped()  ){
			js_log('do out ' + mvd_id );
			this.cur_mvd_id='base';
			de_highlight_tl_ts(mvd_id);
			de_highlight_fd(mvd_id);
			js_log('calling interface restore: ');
			vid_elm.hideHighlight();
			setTimeout('mv_stream_interface.doRestore()',500);
		}else{
			setTimeout('mv_stream_interface.mvdOut(\''+mvd_id+'\')',100);
		}
	},
	//delay video updates until we are not playing the clip and clipEnd is not displayed
	delayDoVidMvdUpdate:function(){
		if(mv_lock_vid_updates){
			setTimeout("mv_stream_interface.delayDoVidMvdUpdate()", 250);
		}else{
			//only restore if the onClipDone_disp is false
			if( !$j('#embed_vid').get(0).onClipDone_disp){
				if(this.cur_mvd_id!=this.delay_cur_mvd_id){
					this.cur_mvd_id = this.delay_cur_mvd_id;
					do_video_mvd_update(this.cur_mvd_id);
				}
			}
		}
	},
	/* based on a a mvd_id update the video thumbnail to the correct location
	 */
	doRestore:function(){		
		//js_log('f:doRestore');
		var vid_elm = $j('#embed_vid').get(0);		
		if(vid_elm){
			if( vid_elm.isPlaying()){
				//js_log('vid elm is playing delay restore:')			
				if(!vid_elm.userSlide){ //dont' restore if userSlide is true			
					if( ! this.monitorTimerId ){				    	
				       // this.monitorTimerId = setInterval('mv_stream_interface.doRestore()', 250);
				    }
				}
			}else{
				//stop restore monitor: 
				clearInterval(this.monitorTimerId);
	        	this.monitorTimerId = 0;
				//only restore if onClipDone_disp is false
				if(!vid_elm.onClipDone_disp){
					//only restore if the cur_mvd = 'base' and interface updates are not locked
					if(this.cur_mvd_id=='base'){
						vid_elm.updateThumbnail(  $j('#embed_vid').get(0).org_thum_src );
						vid_elm.updateVideoTimeReq(org_vid_time_req);
						//vid_elm.updateVideoSrc(org_vid_src);
						$j('#mv_videoPlayerTime').html(org_vid_title);
					}
				}
			}
		}
	}
}
function mv_doTextScrollMonitor(){
	if(!mvTextScrollMonitorTimer)
		mvTextScrollMonitorTimer=setInterval('mv_doTextScrollMonitor()',1000);
		
	if(!mv_open_edit_mvd){
		var evid = $j('#embed_vid').get(0);
		if( evid.isPlaying() ){
			if(evid.currentTime!=0)
				mv_scroll2Time(evid.currentTime);
		}
		if( evid.userSlide ){		
			var mvd_id = mv_scroll2Time( ntp2seconds(evid.jump_time) );
			//also update the image:
			var img_url = $j('#mv_fd_mvd_'+mvd_id).attr('image_url');
			//js_log('set imag via mv_doTextScrollMonitor:'+img_url);
			$j('#embed_vid').get(0).updateThumbnail(img_url);
		}
		 		
		
	}
	//if userScroll scroll/update
}
var previus_scroll2Time_time=null;
var previus_scrollMvd_id=null;
function mv_scroll2Time(sec_time){
	if(previus_scroll2Time_time!=sec_time){
		var scroll_mvd_id = null;
		//init pMvd_id
		if( $j('.mv_fd_mvd:first').length != 0 ){
			var pMvd_id=$j('.mv_fd_mvd:first').attr("id").split('_').pop();
			$j('.mv_fd_mvd').each(function(){		
				var curTitle = get_titleObject($j(this).attr('name'));
				if( curTitle.start_time >= sec_time ){
					//js_log('found mvd pos: ' + curTitle.start_time + ' for sec time: ' + sec_time);				
					if(previus_scrollMvd_id != pMvd_id){								
						scroll_to_pos( pMvd_id ) ;
						previus_scrollMvd_id = pMvd_id;
					}
					return false;//break out of for loop:		
				}	
				pMvd_id = $j(this).attr("id").split('_').pop();
			});				
		}
	}
	return pMvd_id;
}
/*function mv_doShowVideoDownload(){
	js_log('f:mv_doShowVideoDownload');
	//restores orginal state before showing download links: 	
	mv_stream_interface.doRestore();
	return $j('#embed_vid').get(0).org_showVideoDownload();
}*/
/* the mvdObject
 *
 * eventually a lot of mvd_based functionality should be ported over to this structure.
 *  */
function getMvdObject(mvd_id){
	if(mvdAry[mvd_id])return mvdAry[mvd_id];
	if($j('#mv_fd_mvd_'+mvd_id).get(0)){
		var mvdObj = new Object({
			id:mvd_id,
			name:$j('#mv_fd_mvd_'+mvd_id).attr('name'),
			parseTitle:function(){
				parts = this.name.split('/');
				this.start_ntp = parts[1];
				this.end_ntp = parts[2];
				this.start_time = ntp2seconds(this.start_ntp);
				this.end_time = ntp2seconds(this.end_ntp);
			}
		});
	}
	mvdObj.parseTitle();
	mvdAry[mvd_id] = mvdObj;
	return mvdAry[mvd_id];
}

function mv_disp_add_mvd(mvd_type){
	if(mv_open_edit_mvd){
		js_error(gMsg['mv_open_edit']);
		return ;
	}
	mv_open_edit_mvd=mvd_type;
	$j('#embed_vid').get(0).preview_mode=true;//turn on clip preivew mode:
	
	sajax_request_type='GET';
	sajax_do_call( "mv_add_disp",[wgTitle, mvd_type, org_vid_time_req], f );
	//insert before the first mvd:	
	$j('#mv_add_new_mvd').css({display:'inline'});
	$j('#mv_add_new_mvd').html( getMsg('loading_txt') );
	var mvd_id='new';
	//scroll to the new (loading) (top of mvd_cont)
	$j('#selectionsBox').animate({scrollTop: 0}, 'slow');
	function f( request ) {
		result= request.responseText;
		if (request.status != 200){
			$j('#mv_fd_mvd_new').html( "<div class='error'> " +
			request.status + " " + request.statusText + ": " + result + "</div>");
		}else{
			$j('#mv_add_new_mvd').html(result);
			//add the javascrip based hooks:
			if(mvd_type=='ht_en'){
				add_autocomplete('new');
				add_adjust_hooks('new');
			}
			if(mvd_type=='anno_en'){
				add_adjust_hooks('new');
			}
			//add edit buttons
			if(typeof mwSetupToolbar =='function'){
				mwSetupToolbar();
			}
			mwEditButtons = []; //empty edit buttons
			
			if(mvd_type=='anno_en'){
				//add mv_helpers autocompletes
				add_mv_helpers_ac(mvd_id);
				if($j('#adv_basic_'+mvd_id).val()=='basic'){
					$j('.mv_advanced_edit').hide();
				}else{
					$j('.mv_basic_edit').hide();
				}
			}
		}
	}
}
function mv_edit_disp(titleKey, mvd_id){
	if(mv_open_edit_mvd && mv_open_edit_mvd!=mvd_id){
		alert(gMsg['mv_open_edit']);
		return ;
	}
	var title_parts = titleKey.split(':');
	var mvd_type = title_parts[0].toLowerCase();

	mv_open_edit_mvd=mvd_id;
	 //set sajax to do a GET request
	 sajax_request_type='GET';

	 sajax_do_call( "mv_edit_disp", [titleKey, mvd_id], f );
	 $j('#mv_fcontent_'+mvd_id).html( getMsg('loading_txt') );
	 //handle the response:
	 function f( request ) {
		result= request.responseText;
		if (request.status != 200) result= "<div class='error'> " + request.status + " " + request.statusText + ": " + result + "</div>";
		$j('#mv_fcontent_'+mvd_id).html( result );
		//add javascript hooks
		add_autocomplete(mvd_id);
		add_adjust_hooks(mvd_id);


		//if mvd_type==anno_en
		//add buttons
		//mwSetupToolbar();
		mwEditButtons = []; //empty edit buttons

		if(mvd_type=='anno_en'){
			//add mv_helpers autocompletes
			add_mv_helpers_ac(mvd_id);
			if($j('#adv_basic_'+mvd_id).val()=='basic'){
				$j('.mv_advanced_edit').hide();
			}else{
				$j('.mv_basic_edit').hide();
			}
		}
	  }
}/* interface ajax actions */
function mv_disp_mvd(titleKey, mvd_id){
	if(mvd_id=='new'){
		//@@todo confirm (user will lose text in window
		$j('#mv_add_new_mvd').fadeOut("slow", function(){$j(this).empty();});
		//@@todo confirm cancel:
        //if (confirm("unsaved changes will be lost")) {
	    //    $j('#mv_add_mvd_cont').remove();
        //}
	}else{
		//set sajax to do a GET request
		sajax_request_type='GET';
		sajax_do_call( "mv_disp_mvd", [titleKey, mvd_id], f );
		$j('#mv_fcontent_'+mvd_id).html( getMsg('loading_txt') );
	}
	//free the editor slot:
	js_log('mv_disp_mvd: nset mv_open_edit_mvd');
	mv_open_edit_mvd=null;	
	$j('#embed_vid').get(0).preview_mode=false;//turn off clip preivew mode:
	
	function f( request ) {
  		result= request.responseText;
  		if (request.status != 200) result= "<div class='error'> " + request.status + " " + request.statusText + ": " + result + "</div>";
  		//fill in div
  		$j('#mv_fcontent_'+mvd_id).html( result );
	    //add_autocomplete(mvd_id);
        //add_adjust_hooks(mvd_id);
  	}
}

function mv_history_disp(titleKey, mvd_id){
	 sajax_request_type='GET';
	 sajax_do_call( "mv_history_disp", [titleKey, mvd_id], f );
	 $j('#mv_fcontent_'+mvd_id).html( getMsg('loading_txt') );
	 function f( request ) {
		result= request.responseText;
		if (request.status != 200) result= "<div class='error'> " + request.status + " " + request.statusText + ": " + result + "</div>";
		$j('#mv_fcontent_'+mvd_id).html( result );
		//do javascript actions:
      }
}
/*function mv_adjust_disp(titleKey, mvd_id){
	sajax_request_type='GET';
	sajax_do_call( "mv_adjust_disp", [titleKey, mvd_id], f );
	$j('#mv_fcontent_'+mvd_id).html(global_loading_txt);
	//hanndle the response:
	function f( request ) {
		result= request.responseText;
		if (request.status != 200) result= "<div class='error'> " + request.status + " " + request.statusText + ": " + result + "</div>";
		$j('#mv_fcontent_'+mvd_id).html( result );
		//do javascript actions:
		add_adjust_hooks(mvd_id);
    }
}*/

/* non-ajax preview of clip adjustment*/
function mv_adjust_preview(mvd_id){		
	js_log('start val:#mv_start_hr_'+mvd_id+' ' + $j('#mv_start_hr_'+mvd_id).val() + ' end:'+ $j('#mv_end_hr_'+mvd_id).val() );
	$j('#embed_vid').get(0).hideHighlight();
	$j('#embed_vid').get(0).stop();
	$j('#embed_vid').get(0).preview_mode=true;
	mv_lock_vid_updates=false;
	do_video_time_update($j('#mv_start_hr_'+mvd_id).val(), $j('#mv_end_hr_'+mvd_id).val() );
	mv_lock_vid_updates=true;
	//start playing
	$j('#embed_vid').get(0).play();
	//mv_lock_vid_updates=false;
}
/*
 * adds autocomplete to semantic forms
 * with special case for speech by and "categories"
 * @@todo generalize for all autocompletes
 */
function add_mv_helpers_ac(mvd_id){
	js_log('add_mv_helpers_ac:'+mvd_id);
	$j('.mv_anno_ac_'+mvd_id).each(function(i, input_item){
		var prop_name =$j(input_item).attr('name');
		js_log('add ac for: '+ prop_name);
		uri = wgServer + ((wgServer == null) ? (wgScriptPath + "/index.php") : wgScript);
		$j(input_item).autocomplete(
			uri,
			{
				autoFill:true,
				onItemSelect:function(v){
					js_log('selected:' + v.innerHTML + 'fill with' + $j(input_item).val() );
					//@@todo better way to determin type
					//js_log("img src: " + $j(v).children('img').attr('src'));
					//'mv_edit_im_'+mvd_id
					if($j(v).children('img').length!=0){
						$j('#smw_Speech_by_img').attr('src', $j(v).children('img').attr('src'));
					}
					//add category and empty input (@@todo make cat_ns multi-lengual friendly
					var cat_ns="Category:"
					if($j(input_item).val().indexOf(cat_ns)==0){
						mv_add_category(mvd_id, $j(input_item).val().substr(cat_ns.length));
						$j(input_item).val('');
					}
				},
				formatItem:function(row){
					if(row[2]=='no_image'){
						return row[1];
					}else{
						return '<img width="44" src="'+ row[2] + '">'+row[1];
					}
				},
				matchSubset:0,
				extraParams:{action:'ajax',rs:'mv_helpers_auto_complete',prop_name:prop_name},
				paramName:'rsargs[]',
				resultElem:'#'+prop_name+'_choices_'+mvd_id
			});
	});
}
function mv_add_category(mvd_id, cat_name){
	js_log("add cat: "+ cat_name);
	if(cat_name=='')return false;
	var currentDate = new Date()
	var unique_inx = currentDate.getUTCMilliseconds();
	$j('#mv_ext_cat_container_'+mvd_id).append('<span id="ext_cat_'+unique_inx+'"><input value="'+cat_name+'" type="hidden" style="display:none;" name="ext_cat_'+unique_inx+'" class="mv_ext_cat">'+
							cat_name.replace(/_/g," ") +
							'<a  href="#" onclick="$j(\'#ext_cat_'+unique_inx+'\').fadeOut(\'fast\').remove();return false;">'+
								'<img border="0" src="'+mvgScriptPath+'/skins/images/delete.png">'+
							'</a></span><br>');
}
/*
 * @@TODO add_autocomplete should be merged with generalized mv_helpers_ac
 */
function add_autocomplete(mvd_id){
		js_log("f:auto_comp_choices_:"+mvd_id);
		//make sure the target elements exist:
		//if(!document.getElementById("auto_comp_"+mvd_id))return ;
		//if(!document.getElementById("auto_comp_choices_"+mvd_id))return ;
		uri = wgServer +
		((wgServer == null) ? (wgScriptPath + "/index.php") : wgScript);
		$j('#auto_comp_'+mvd_id).autocomplete(
			uri,
			{
				autoFill:true,
				onItemSelect:function(v){
					js_log('selected:' + v.innerHTML );
					//update the image:
					//js_log("img src: " + $j(v).children('img').attr('src'));
					//'mv_edit_im_'+mvd_id
					$j('#mv_edit_im_'+mvd_id).attr('src', $j(v).children('img').attr('src'));
				},
				formatItem:function(row){
					return '<img width="44" src="'+ row[2] + '">'+row[1];
				},
				matchSubset:0,
				extraParams:{action:'ajax',rs:'mv_auto_complete_person'},
				paramName:'rsargs[]',
				resultElem:'#auto_comp_choices_'+mvd_id
			});
}
//submit the adjust

//use start time of elements in the to position pieces.
function mv_add_new_fd_mvd(titleKey, node_html){
	//js_log('add: ' + mv_result['titleKey'] + node_html);
	//get start time and end time from titleKey:
	var insertTitle = get_titleObject(titleKey);

	//for each element selectionsBox
	var inserted = false;
	$j('.mv_fd_mvd').each(function(i){
		if(!inserted){
			var curTitle = get_titleObject($j(this).attr('name'));
			if(insertTitle.start_time < curTitle.start_time){
				$j(this).before(node_html).show("slow");
				js_log('inserted before: '+curTitle.title +' id:'+insertTitle.start_time);
	   			inserted=true;
	   			return ;
			}
		}
	});
	//add at the end (if not before some other mvd page)
	if(!inserted){
		js_log('insert to end: ' + insertTitle.start_time + "\n" + node_html);
		$j('#selectionsBox').append(node_html);
	}
	//repaint row colors: 
	mv_stream_interface.oddEvenPaint();
}

function get_titleObject(titleKey){
	var titleObj = new Object({
		title:titleKey,
		parseTitle:function(){
			parts = this.title.split('/');
			this.start_ntp = parts[1];
			this.end_ntp = parts[2];
			this.start_time = ntp2seconds(this.start_ntp);
			this.end_time = ntp2seconds(this.end_ntp);
		}
	});
	titleObj.parseTitle();
	return titleObj;
}
function mv_disp_remove_mvd(titleKey, mvd_id){
	 sajax_request_type='GET';
	 sajax_do_call( "mv_disp_remove_mvd", [titleKey, mvd_id], f );
	 $j('#mv_fcontent_'+mvd_id).html( getMsg('loading_txt') );
	 function f( request ) {
		result= request.responseText;
		if (request.status != 200) result= "<div class='error'> " + request.status + " " + request.statusText + ": " + result + "</div>";
		$j('#mv_fcontent_'+mvd_id).html( result );
		//dirty hack to avoid re-write of article->delete();
		update_delete_submit(titleKey, mvd_id);		
      }
}
function update_delete_submit(titleKey, mvd_id){
	$j('#deleteconfirm').attr('id', 'deleteconfirm_'+mvd_id);
	$j('#deleteconfirm_'+mvd_id).attr('onSubmit', 'mv_remove_mvd(\'' +
			titleKey + '\', \''+ mvd_id+'\', this); return false;');
}
function mv_remove_mvd(titleKey, mvd_id, form){
	var post_vars = new Object();
	var args = new Object();
	$j('input', form).each(function(){
		post_vars[this.name] = this.value;
	});
	post_vars['title']=titleKey;
	post_vars['mvd_id'] = mvd_id;

	var setHtmlId ='#mv_fcontent_'+mvd_id;
	//@@todo switch over to jquery ajax
	/*uri = wgServer +
		((wgServer == null) ? (wgScriptPath + "/index.php") : wgScript) +
		"?action=ajax&rs=mv_remove_mvd";
	$j.ajax({
			url:uri,
			data:post_vars,
			error:function(error){},
			success:function(result){}
		}
	);
	}*/
	sajax_request_type='POST';
	mv_sajax_do_call('mv_remove_mvd',args, f, post_vars);
	js_log('did request');
	function f( request ) {
		result = request.responseText;
		js_log("got response:");
		if (request.status != 200){
         	result= "<div class='error'> " + request.status + " " + request.statusText + ": " + request.responseText + "</div>";
			$j(setHtmlId).html( result) ;
			return ;
        }else{
        	js_log("going to eval: " + request.responseText);
        	eval(request.responseText);
        	js_log('status: ' + mv_result['status']);
  			if(mv_result['status']=='ok'){
  				js_log(" status ok should remove: "+mvd_id);
  				//delete success remove mvd:
				$j('#mv_fd_mvd_'+mvd_id).remove();
  				$j('#mv_tl_mvd_'+mvd_id).remove();
  				//repaint colors: 
				mv_stream_interface.oddEvenPaint();
  			}else if(mv_result['status']=='error'){
  				$j(setHtmlId).html( mv_result['error_txt'] );
  				update_delete_submit(titleKey, mvd_id);
  			}
        }
	}
}
//do a form submit to a given function
function mv_do_ajax_form_submit(mvd_id, edit_action){
	//set sajax to do a post request
	sajax_request_type='POST';
	//init the var:
	var args = new Object();
	var post_vars = new Object();
	var buttonList = {'wpSave':true, 'wpPreview':true, 'wpLivePreview':true, 'wpDiff':true};
	var move_on_done=false;

	var form =  document.getElementById('mvd_form_'+mvd_id);
	for(i=0;i<form.elements.length;i++){
		if(buttonList[ form.elements[i].name ]){
			//don't include button unless its the edit action
			// (to simulate button press for edit actions (save, preview, show changes)
			if(form.elements[i].name.toLowerCase().indexOf( edit_action.toLowerCase() )!=-1){
				post_vars[ form.elements[i].name ]=form.elements[i].value;
			}
		}else{
			post_vars[ form.elements[i].name ]=form.elements[i].value;
		}
		//js_log(form.elements[i].name + ' = ' + form.elements[i].value);
	}
	//do edit action specific calls:
	switch(edit_action){
		case 'save':
			var setHtmlId ='#mv_fcontent_'+mvd_id;			
		break;
		case 'preview':
			mv_lock_vid_updates=true;
			var setHtmlId = '#wikiPreview_'+mvd_id
			mv_adjust_preview(mvd_id);
		break;
	}
	//check if we are adjusting (if so move then save text)
	if(mvd_id=='new'){
		post_vars['do_adjust']=false;
		post_vars['wgTitle']=mvTitle;
	}else{
		js_log('get title from: ' + $j('#mv_fd_mvd_'+mvd_id).attr('name'));
		var curTitle = get_titleObject( $j('#mv_fd_mvd_'+mvd_id).attr('name') );
		if(edit_action=='save'){
			if( curTitle.start_ntp != $j('#mv_start_hr_'+mvd_id).val() ||
				curTitle.end_ntp != $j('#mv_end_hr_'+mvd_id).val()){
				post_vars['do_adjust']=true;
				js_log('do adjustment move '+ curTitle.start_ntp + '!=' + $j('#mv_start_hr_'+mvd_id).val()
					+ ' & ' + curTitle.end_ntp + '!=' + $j('#mv_end_hr_'+mvd_id).val() );
				post_vars['wgTitle']=mvTitle;
				post_vars['titleKey'] = $j('#mv_fd_mvd_'+mvd_id).attr('name');
				//js_log('titlekey:'+post_vars['titleKey'] );
				//get new title:
				post_vars['newTitle'] = post_vars['titleKey'].substr(0, post_vars['titleKey'].indexOf('/')) + '/' +
					$j('#mv_start_hr_'+mvd_id).val() + "/" + $j('#mv_end_hr_'+mvd_id).val();
			}
		}
	}

	$j(setHtmlId).html( getMsg('loading_txt') );
	//@@todo switch over to jquery ajax
	mv_sajax_do_call('mv_edit_submit',args, f, post_vars);
	//js_log('mv_sajax_do_call ' + fajax +' ' +  args);
	function f( request ) {
        result = request.responseText;
        if (request.status != 200){
         	result= "<div class='error'> " + request.status + " " + request.statusText + ": " + result + "</div>";
			mv_lock_vid_updates=false;
			$j(setHtmlId).html( result) ;
			return ;
        }
        js_log('req status:'+ request.status);
		if(mvd_id=='new' && edit_action=='save'){
			js_log("new and save");
			eval(result);
			js_log('newsave status: '+mv_result['status'] );
  			if(mv_result['status']=='ok'){
  				//empty the add div:
		  		$j('#mv_add_new_mvd').empty();

				//add mv_time_line element
		  		$j('#mv_time_line').append(mv_result['tl_mvd']);
		  		mv_add_new_fd_mvd(mv_result['titleKey'], mv_result['fd_mvd']);

		  		mv_stream_interface.addHoverHooks('#mv_fd_mvd_'+mv_result['mvd_id']+',#mv_tl_mvd_'+mv_result['mvd_id']);
		  		//scroll to the new mvd:
		  		scroll_to_pos(mv_result['mvd_id']);
  			}
		}
        if(post_vars['do_adjust']){
        	js_log('do_adjust');
         	//remove and add encapsulated mvd_fd
         	eval(result);
  			if(mv_result['status']=='ok'){
  				//@@could be a (fade but first rename)
  				js_log('remove: #mv_fd_mvd_'+mvd_id + ' len br:'+ $j('#mv_fd_mvd_'+mvd_id).length);
				$j('#mv_fd_mvd_'+mvd_id).remove();
  				$j('#mv_tl_mvd_'+mvd_id).remove();
  				
				js_log('removed! len br:'+ $j('#mv_fd_mvd_'+mvd_id).length);


  				//add new mv_time_line element (already has position so place at end)
				$j('#mv_time_line').append(mv_result['tl_mvd']).show("slow");

				//add new selectionsBox  mvd element (based on start time)
				//(use the titleKey returned from ajax request (in case it got clean or whatever)
				mv_add_new_fd_mvd(mv_result['titleKey'], mv_result['fd_mvd']);

		  		mv_stream_interface.addHoverHooks('#mv_fd_mvd_'+mvd_id);
				//add tails
				//mv_add_mvd_tails(mv_result['titleKey']);
				//scroll to the new location (it should have keept its id (cuz its just a move)
				scroll_to_pos(mvd_id);
  			}else if(mv_result['status']=='error'){
  				$j(setHtmlId).html( mv_result['error_txt']);
  			}
        }else{
         	//just update the current mvd
    		$j(setHtmlId).html( result) ;
	  		scroll_to_pos(mvd_id);
        }
        if(edit_action!='preview'){
	        //unlock the interface updates        
			mv_lock_vid_updates=false;
			//free the editor slot:
			mv_open_edit_mvd=null;
			$j('#embed_vid').get(0).preview_mode=false;//turn off clip preivew mode:
        }
	}
	//return false to prevent the form being submitted
	return false;
}
function mv_pause(){
	 // unlock updates, but issue a pause - if an update occurs, it should
     // stop.
	 var ebvid = $j('#embed_vid').get(0);
	 if( ebvid.isPlaying())
     {
        js_log('f:mv_pause: should pause');
        // calling original play_or_pause
	 	ebvid.pause();
        // lock updates if we're not paused,  and vice versa
	 	mv_lock_vid_updates =! ebvid.isPaused();
	 }else{	 
	 	js_log('f:mv_pause called WHILE Paused: (should play)');	 		 	
	 	mv_do_play();	 	
	 }
}
function mv_do_play(mvd_id){
	js_log('mv_do_play:'+mvd_id);
	//stop the current
	$j('#embed_vid').get(0).stop();
	//stop any defered updates:
	
	//force a given mvd if set
	if(mvd_id){		
		mv_lock_vid_updates=false;
		//highlight the current / update url:
		mv_stream_interface.mvdOver(mvd_id);
	}	
	$j('#embed_vid').get(0).
	//disable interface actions (mouse in out etc)
	mv_lock_vid_updates=true;
	//update the src if nesesary and no mvd provided:
	if(!mvd_id){
		if(mv_stream_interface.cur_mvd_id!=mv_stream_interface.delay_cur_mvd_id){
			mv_stream_interface.cur_mvd_id =mv_stream_interface.delay_cur_mvd_id;
			do_video_mvd_update(mv_stream_interface.cur_mvd_id);
		}
	}
	//update the embed video actual play time
	//time_chunk = $j('#embed_vid').get(0).src.split('t=');
	//$j('#mv_videoPlayerTime').html( time_chunk[1] );
	//stop the video if playing and play:
	//@@todo extend mv_embed to support src switching
	$j('#embed_vid').get(0).play();

}

//adjusts the interface to show the play controls:
function mv_disp_play_controls(disp){
	js_log('mv_controls: ' + disp);
	if(!org_height_vid_contain)
		org_height_vid_contain = $j('#MV_VideoPlayer').height();

	if(!org_top_tool_contain)
		org_top_tool_contain= parseInt($j('#MV_Tools').css('top').replace('px',''));

	if(disp){
		//based on the embed type give space for controls:
		//@@todo pull pix_offset from players code
		/*switch(embedTypes.getPlayerLib()){
			case 'java':
			case 'generic':
				var pix_offset= 30;
			break;
			case 'native':
			case 'vlc':
			case 'oggplay':
				var pix_offset=55;
			break;
		}*/
		//give room for all players:
		var pix_offset=55;
		js_log("set con space: " + org_height_vid_contain+parseInt(pix_offset));
		$j('#MV_VideoPlayer').css({'height':(org_height_vid_contain+parseInt(pix_offset))+'px'});
		$j('#MV_StreamMeta,#MV_Tools').css({'top':(org_top_tool_contain+parseInt(pix_offset))+'px'});
	}else{
		js_log('return org height');
		$j('#MV_VideoPlayer').css({'height':org_height_vid_contain+'px'});
		$j('#MV_StreamMeta,#MV_Tools').css({'top':org_top_tool_contain+'px'});
	}
}
//hackish globals .. needs a rewrite
var mv_currently_scroll_to_pos=false;
function scroll_to_pos(mvd_id){
	js_log('scroll_to_pos:'+mvd_id);
	var speed = (mv_currently_scroll_to_pos)?'fast':'slow';
	if( $j('#mv_fd_mvd_'+mvd_id).get(0)){		
		//@@todo debug IE issues with scrolling
		$j('#selectionsBox').animate({
			scrollTop: ($j('#mv_fd_mvd_'+mvd_id).get(0).offsetTop-40)
			}, 
			speed,
			function(){
				mv_currently_scroll_to_pos=false;
			});
	}	
}
function highlight_fd(mvd_id){	
	$j('#mv_fd_mvd_'+mvd_id).css('border','1px solid #F00');
}
function de_highlight_fd(mvd_id){
	$j('#mv_fd_mvd_'+mvd_id).css('border', '1px solid #FFF');
}

function highlight_tl_ts(mvd_id){
	//make sure we don't set the original as red:
	if($j('#mv_tl_mvd_'+mvd_id).get(0)){
		if($j('#mv_tl_mvd_'+mvd_id).css('background').indexOf("red")==-1)
			mv_tl_mvd_org_color[mvd_id] = $j('#mv_tl_mvd_'+mvd_id).css('background');
		//js_log(mvd_id + ' org color: ' + mv_tl_mvd_org_color[mvd_id]);
		$j('#mv_tl_mvd_'+mvd_id).css({background:'red',opacity:.4}).css("z-index",10);
	}
}
function de_highlight_tl_ts(mvd_id){
	if(mv_tl_mvd_org_color[mvd_id]){
		if($j('#mv_tl_mvd_'+mvd_id).get(0)){
			//alert(mvd_id + ' restore ' + mv_tl_mvd_org_color[mvd_id] + ' ' + rgb2hex(mv_tl_mvd_org_color[mvd_id]));
			$j('#mv_tl_mvd_'+mvd_id).css({background:mv_tl_mvd_org_color[mvd_id],opacity:1}).css("z-index",0);
		}
	}
}

function do_video_mvd_update(mvd_id){
	if(mvd_id){
		var time_ary = $j('#mv_fd_mvd_'+mvd_id).attr('name').split('/');
		//get the current thumbnail
		var vid_elm = document.getElementById('embed_vid');
		if(!vid_elm)return '';
		//make the play button vissable again (if its hidden) : 
		$j('#big_play_link_embed_vid').show();
		//do_video_time_update(time_ary[1], time_ary[2],mvd_id);
		var embedObj = $j('#embed_vid').get(0);
		
		//add coloring to stream where we would play: 
		$j('#embed_vid').get(0).highlightPlaySection({
			'start': time_ary[1],
			'end':	 time_ary[2]			
		});				
	}
}
function mv_tool_disp(tool_id){
	//set content to loading
	$j('#mv_tool_cont').html( getMsg('loading_txt') );
	//populate post vars with any necessary tool specific items:
	var post_vars=new Object();
	if(tool_id=='navigate'||tool_id=='export'){
		//assumes stream name ends with time range
		//time_range = org_vid_src.substr( org_vid_src.indexOf('?t=')+3 );
		post_vars['time_range']=org_vid_time_req;
	}
	//set tracks from mv var:
	if(tool_id=='mang_layers'){
		post_vars['tracks']=mvTracks;
	}
	sajax_request_type='POST';
	//@@todo switch over to jquery ajax
	mv_sajax_do_call('mv_tool_disp', [tool_id, wgNamespaceNumber, wgTitle], f, post_vars);
	function f( request ) {
        result = request.responseText;
	 	if (request.status != 200){
  			 result= "<div class='error'> " + request.status + " " + request.statusText + ": " + result + "</div>";
  			 $j('#mv_tool_cont').html( result);
  		}else{
  			//result should set up object mv_result
  			eval(result);
  			mv_proc_tool_result(tool_id, mv_result);
  		}
		 //unlock the interface updates
		 mv_lock_vid_updates=false;
	}
}
function mv_proc_tool_result(tool_id, mv_result){
	if(mv_result['status']=='ok'){
		//run any request javascript call backs
		//do per tool post-req js actions:
		switch(tool_id){
			/*case 'navigate':
				//set the content payload
  				$j('#mv_tool_cont').html( mv_result['innerHTML']);
				eval(mv_result['js_eval']);
				$j('#mv_go_nav').click(function() {
						window.location.href = wgScript+
						'/'+wgPageName+'/'+$j('#mv_start_hr_nav').val()+
						'/'+$j('#mv_end_hr_nav').val();
				});
				add_adjust_hooks('nav', end_time);
			break;*/
			case 'search':
				//load search.js  ... @@todo cleanup path
				mvJsLoader.doLoad({
					'mv_setup_search':'../mv_search.js'
			  	},function(){
			  		$j('#mv_tool_cont').html( mv_result['innerHTML']);
			  		mv_setup_search();
			  	});
			break;
			case 'mang_layers':
				$j('#mv_tool_cont').html( mv_result['innerHTML']);
				//add in hooks for turnning on off layers (via click on link)
				$j('a.mv_mang_layers').click(function(){
					$j('#option_'+this.id.substring(2)).get(0).checked = !$j('#option_'+this.id.substring(2)).get(0).checked;
					return false;
				});
				//add in function for page rewrite on submit
				$j('#submit_mang_layers').click(function(){
					var track_req = coma = '';
					//build track_req:
					$j('a.mv_mang_layers').each(function(){
						if($j('#option_'+this.id.substring(2)).get(0).checked){
							track_req+=coma+this.id.substring(2);
							coma=',';
						}
					})
					window.location.href = wgScript+'/'+wgCanonicalNamespace+':'+mvTitle+'?tracks='+track_req+'&tool_disp=mang_layers';
					return false;
				});
			break;
			default:
				//set the content payload
  				$j('#mv_tool_cont').html( mv_result['innerHTML']);
			break;
		}
	}else if(mv_result['status']=='error'){
		$j('#mv_tool_cont').html( mv_result['error_txt']);
	}
}
/* js functions that are slight modification of
 * existing mediawiki code (if adopted upstream these can be removed)
 * @@todo we could switch to jquery ajax calls)
 */
//added in payload submit single dimension key.value pair object:
function mv_sajax_do_call(func_name, args, target, post_vars) {
	var i, x, n;
	var uri;
	var post_data;
	uri = wgServer +
		((wgServer == null) ? (wgScriptPath + "/index.php") : wgScript) +
		"?action=ajax";
	if (sajax_request_type == "GET") {
		if (uri.indexOf("?") == -1)
			uri = uri + "?rs=" + encodeURIComponent(func_name);
		else
			uri = uri + "&rs=" + encodeURIComponent(func_name);
		for (i = 0; i < args.length; i++)
			uri = uri + "&rsargs[]=" + encodeURIComponent(args[i]);
		//uri = uri + "&rsrnd=" + new Date().getTime();
		post_data = null;
	} else {
		post_data = "rs=" + encodeURIComponent(func_name);
		for (i = 0; i < args.length; i++)
			post_data = post_data + "&rsargs[]=" + encodeURIComponent(args[i]);
		//for (i = 0; i < args.length; i++)
		//	post_data = post_data + "&rsargs[]=" + encodeURIComponent(args[i]);
	}
	x = sajax_init_object();
	if (!x) {
		alert("AJAX not supported");
		return false;
	}

	try {
		x.open(sajax_request_type, uri, true);
	} catch (e) {
		if (window.location.hostname == "localhost") {
			alert("Your browser blocks XMLHttpRequest to 'localhost', try using a real hostname for development/testing.");
		}
		throw e;
	}
	if (sajax_request_type == "POST") {
		x.setRequestHeader("Method", "POST " + uri + " HTTP/1.1");
		x.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	}
	x.setRequestHeader("Pragma", "cache=yes");
	x.setRequestHeader("Cache-Control", "no-transform");
	x.onreadystatechange = function() {
		if (x.readyState != 4)
			return;

		sajax_debug("received (" + x.status + " " + x.statusText + ") " + x.responseText);

		//if (x.status != 200)
		//	alert("Error: " + x.status + " " + x.statusText + ": " + x.responseText);
		//else

		if ( typeof( target ) == 'function' ) {
			target( x );
		}
		else if ( typeof( target ) == 'object' ) {
			if ( target.tagName == 'INPUT' ) {
				if (x.status == 200) target.value= x.responseText;
				//else alert("Error: " + x.status + " " + x.statusText + " (" + x.responseText + ")");
			}
			else {
				if (x.status == 200) target.innerHTML = x.responseText;
				else target.innerHTML= "<div class='error'>Error: " + x.status + " " + x.statusText + " (" + x.responseText + ")</div>";
			}
		}
		else {
			alert("bad target for sajax_do_call: not a function or object: " + target);
		}

		return;
	}
	//add payload to post data (as long as i does not equal rs or rsargs
	if(post_vars){
		for(var i in post_vars){
			if(i!='rs' && i!='rsargs')
				post_data+= '&'+ i +'='+ encodeURIComponent(post_vars[i]);
		}
	}
	//js_log(func_name + " uri = " + uri + " / post = " + post_data);
	x.send(post_data);
	sajax_debug(func_name + " waiting..");
	delete x;

	return true;
}
/*
 * togle advanced and simply display of mvd annotation edits
 */
function mv_mvd_advs_toggle(mvd_id){
	js_log('form val:#adv_basic_'+mvd_id+' '+$j('#adv_basic_'+mvd_id).val());
	if($j('#adv_basic_'+mvd_id).val()=='basic'){
		js_log('form is currently basic; SET to ADV');
		//set to advanced
		$j('#adv_basic_'+mvd_id).val('advanced');
		//hide all basic
		$j('.mv_basic_edit').fadeOut('fast');
		//show all advanced
		$j('.mv_advanced_edit').fadeIn('fast');
	}else{
		js_log('form is currently advanced; SET to basic');
		//set to basic
		$j('#adv_basic_'+mvd_id).val('basic');
		//hide all advanced
		$j('.mv_advanced_edit').fadeOut('fast');
		//show all basic
		$j('.mv_basic_edit').fadeIn('fast');
	}
}

/* custom effects */
/*function add_custom_effects(){
	Effect.ScrollVertical = Class.create();
	Object.extend(Object.extend(Effect.ScrollVertical.prototype, Effect.Base.prototype),
	{
	    initialize: function(element)
	    {
	        if(typeof element == "string")
	        {
	            this.element = $(element);
	            if(!this.element)
	            {
	                throw(Effect._elementDoesNotExistError);
	            }
	        }

	        var options = Object.extend({
	           from: this.element.scrollTop || 0,
	            to:   this.element.offsetHeight
	        }, arguments[1] || {});
	        //set to pos via target if set
			if(options.target){
				target_elm = $(options.target);
				Position.prepare(target_elm);
				to_ary=Position.positionedOffset(target_elm);
				//@@todo subtract 1/2 of height of container (as to center)
				//for now just hardcode 227
				options.to = to_ary[1]-227;
			}
			/*target_elm = $(options.target);
			if(!target_elm)js_log('wft'+ options.target);
			//Position.absolutize(target_elm);
			if(options.target)js_log(Position.positionedOffset(target_elm) );
			*/ /*
	        this.start(options);
	    },

	    update: function(position)
	    {
	        this.element.scrollTop = position;
	    }
	});

	Effect.ScrollHorizontal = Class.create();
	Object.extend(Object.extend(Effect.ScrollHorizontal.prototype, Effect.Base.prototype),
	{
	    initialize: function(element)
	    {
	        if(typeof element == "string")
	        {
	            this.element = $(element);
	            if(!this.element)
	            {
	                throw(Effect._elementDoesNotExistError);
	            }
	        }

	        var options = Object.extend({
	            from: this.element.scrollLeft || 0,
	            to:   this.element.offsetWidth
	        }, arguments[1] || {});

	        this.start(options);
	    },

	    update: function(position)
	    {
	        this.element.scrollLeft = position;
	    }
	});
}
 */
