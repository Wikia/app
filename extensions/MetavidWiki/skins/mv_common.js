/*@@TODO should be set by mediaWiki so it uses wfMsg */
var global_loading_txt = 'loading<blink>...</blink>';


function add_adjust_hooks(mvd_id, track_dur){
	if(track_dur)track_dur=parseInt(track_dur);
	js_log('add_adjust_hooks: ' + mvd_id + ' td: '+ track_dur);
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
				add_adjust_hooks(mvd_id, track_dur);
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
	if(!track_dur)
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
	if(resize_width<17)resize_width=17;
	
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
			$j('#resize_'+mvd_id).css('top', 0);	
			//if in seq mode:update the clip 
			if(mvd_id=='seq')do_video_time_update($j('#mv_start_hr_'+mvd_id).val(), $j('#mv_end_hr_'+mvd_id).val() );			
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

//alert(typeof js_log);
//logging: 
function js_log(string){
  if( window.console ){
        console.log(string); 
   }else{   	 
     /*
      * IE and non-firebug debug append text box:
      */
      /* var log_elm = document.getElementById('mv_js_log');
     if(!log_elm){
     	document.write('<textarea id="mv_js_log" cols="80" rows="6"></textarea>');
     	var log_elm = document.getElementById('mv_js_log');
     }
     if(log_elm){
     	log_elm.value+=string+"\n";
     }*/
   }
}
