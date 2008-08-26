/*search code could theoretically run without mv_embed */

//_global = this;
//if(typeof $j =='undefined'){
//	_global['$j'] = jQuery.noConflict();
//}
mv_addLoadEvent(mv_pre_setup_search); 	

var maxFilters = 8;
var mv_search_action='';
function mv_pre_setup_search(req_mode){
	//make sure we have jQuery and any base requried libs: 
	mvJsLoader.doLoad(mvEmbed.lib_jquery, function(){
 		_global['$j'] = jQuery.noConflict();
		mv_setup_search(req_mode);
	});
}
function mv_setup_search(req_mode){	
	js_log('mv_setup_search: '+  req_mode);
	add_highlight_function();
	//look for existing auto completes:
	for(i=0;i<maxFilters;i++){
		if( $j('#mv_person_input_'+i).get(0)){
			mv_add_person_ac(i);
		}
	}
	//if in ajax req mode (re-write "run_search" button)
	if(req_mode=='ajax'){
		//store action
		mv_search_action = $j('#mv_media_search').attr('action');
		//change form action
		$j('#mv_media_search').attr('action','javascript:mv_do_ajax_search()');
	}
	
	//look for search results (enable button actions)
	$j('.mv_stream_play_button').click(function(){
		window.location.href = wgScript+ '/'+
			$j(this).attr('name');
	})
	//set up bindings for existing date range:
	if(typeof mvDateInitObj!='undefined'){
		$j('.mv_search_select').each(function(){
			//get mv_sel_# number
			id_parts = $j(this).attr('id').split('_');
			var type = id_parts[1];
			var inx = id_parts[2]; 		
			//js_log('looking at: '+ $j("#"+this.id+" option:selected").val())
			if($j("#"+this.id+" option:selected").val()=='date_range'){
				add_date_binddings(inx, mvDateInitObj);
			}
		});
	}else{
		js_log('mvDateInitObj is undefined');
	}	
	//remove all old search_text binddings: 
	$j('.mv_search_select').unbind();
	//set up actions: 
	$j('.mv_search_select').change(function(){
		//get mv_sel_# number
		id_parts = $j(this).attr('id').split('_');
		var type = id_parts[1];
		var inx = id_parts[2]; 
		js_log("id: "+$j(this).attr('id')+" got t:" + type+ ' Index:' + inx + ' val:' + $j("#"+this.id + " option:selected").val() );
		switch($j("#"+this.id+" option:selected").val()){
			case 'category':
				$j('#mvs_'+inx+'_tc').html('<input class="mv_search_text"' +
					'size="9" type="text" name="f['+inx+'][v]" value="" >'); 
				//@@todo add autocomplete for category names
			break;
			case 'stream_name':
				$j('#mvs_'+inx+'_tc').html('<input class="mv_search_text" ' +
					'size="9"  type="text" name="f['+inx+'][v]" value="" >'); 
				////@@todo add autocomplete for stream name
			break;
			case 'match':
				//match text is special cuz it gets highlighted in resutls with class: mv_hl_text
				$j('#mvs_'+inx+'_tc').html('<input class="mv_search_text mv_hl_text" ' +
					'size="9"  type="text" name="f['+inx+'][v]" value="" >'); 
			break;
			case 'date_range':
				$j('#mvs_'+inx+'_tc').html(global_loading_txt);
				var load_js_set = { 'Date.fromString':'jquery/plugins/date.js',
									'$j.fn.datePicker':'jquery/plugins/jquery.datePicker.js'};
				if(embedTypes.msie6){
					js_log('using IE v6 need iframe as well');
					load_js_set['$j.fn.bgIframe'] = 'jquery/plugins/jquery.bgiframe.js';
				}
				uri = wgServer +
					((wgServer == null) ? (wgScriptPath + "/index.php") : wgScript);	
				mvJsLoader.doLoad(load_js_set,function(){
					searchDateObj = $j.get(uri, 
						{action:'ajax',rs:'mv_date_obj'},
						function(data){
							eval(data);
							if(mv_result){
								//we ave to load the jQuery date plugin & the date_range data set (and mesg) 
								$j('#mvs_'+inx+'_tc').html('<input class="date-pick_'+inx+' mv_search_text"  '+
									'size="9" type="text" id="vs_'+inx+'" name="f['+inx+'][vs]" value="" > to ' +
									'<input class="date-pick_'+inx+' mv_search_text"  '+
									'size="9" type="text" id="ve_'+inx+'" name="f['+inx+'][ve]" value="" >');
								add_date_binddings(inx, mv_result);
							}														
					});					
			  	});
			break;
			case 'spoken_by':				
				$j('#mvs_'+inx+'_tc').html( $j('#mv_person')
					.clone().css('display','inline').attr('id', 'mv_person_'+inx).children().each(function(){
						//append the inx to each: 
						$j(this).attr('id', $j(this).attr('id')+'_'+inx);
						js_log('' + this.id);
					}));
				//update the input name: 
				$j('#mv_person_input_'+inx).attr('name', 'f['+inx+'][v]');
				//for more logical default behavior: 
				//default to OR if any other "spoken by" are present in list else AND				
				var default_sel_inx=0;
				$j('.mv_search_select').each(function(){
					if(this.id!='mvsel_t_'+inx){
						if(this.value=='spoken_by'){
							default_sel_inx=1; //set to OR
						}
					}
				})
				$j('#mvsel_a_'+inx).get(0).selectedIndex=default_sel_inx;
				mv_add_person_ac(inx);
			break;			
			case 'smw_property':
			break;
			default:
				js_log('no select action for:'+ $j("#"+this.id+" option:selected").val());
			break;
		};	
	});
}
function mv_do_ajax_search(){
	js_log('mv_do_ajax_search '); 	
	//build req url: 
	var req_query=(mv_search_action.indexOf('?')!==-1)?'&':'?';
 	req_query+= 'seq_inline=true';
	$j('#mv_media_search :input').each(function(){
		if($j(this).attr('name')){
			req_query+='&'+$j(this).attr('name')+'='+$j(this).val();
		}
	});
	mv_do_ajax_search_request( mv_search_action+ req_query);
	
}
function mv_do_ajax_search_request(url){
	//(don't) annimate the transition: 
	//$j('#mv_search_results_container').fadeOut(function(){	
	//});
	$j('#mv_search_results_container').html(getMsg('loading_txt'));		
	$j.get(url, function(data){
		//populate results
		$j('#mv_search_results_container').html(data);
		//run callback: 
		if(typeof mv_ajax_search_callback == 'function'){
			mv_ajax_search_callback();		
		}else{
			js_log('ajax_search_callback type was: '+ typeof mv_ajax_search_callback);
		}
	});
}
function add_date_binddings(inx, mvDateInitObj){
	//@@todo load the date format from the server
	Date.format = 'mm/dd/yyyy';
	//populate with default start and end times (if empty): 
	$j('.date-pick_'+inx).each(function(){
		if($j(this).attr('name')=='f[1][vs]'){
			if($j(this).val()=='')$j(this).val(mvDateInitObj['sd']);			
		}else{
			if($j(this).val()=='')$j(this).val(mvDateInitObj['ed']);			
		}
		//update start end times: 
		d = new Date($j(this).val());
		if($j(this).id=='vs_'+inx){			
			$j('#ve_'+inx).dpSetStartDate(d.addDays(1).asString());
		}else if($j(this).id=='ve_'+inx){
			$j('#vs_'+inx).dpSetStartDate(d.addDays(-1).asString());
		}
	}).trigger('change');//apply the current val as selected date	
	//set up date range: 
	$j('.date-pick_'+inx).datePicker({
		clickInput:true,
		startDate:mvDateInitObj['sd'],
		endDate:mvDateInitObj['ed'],
		renderCallback:function($td, thisDate, month, year){		
			//@@todo fix upstream...month seems to be off by 1 ? or it starts at 0? 
			month= thisDate.getMonth()+1;
			//js_log('renderCallback: '+ thisDate.getDate() +' '+ month +' '+ year );
			//js_log(mvDateInitObj['sdays']);
			//check if thisDate is in db (mvDateInitObj)
			if(typeof mvDateInitObj['sdays'][year] != 'undefined'){
				if(typeof mvDateInitObj['sdays'][year][month] != 'undefined'){
					if(typeof mvDateInitObj['sdays'][year][month][thisDate.getDate()]!='undefined'){
						js_log("FOUND date match" + thisDate.getDate());
						$td.addClass('has_streams');
						$td.attr('title',mvDateInitObj['sdays'][year][month][thisDate.getDate()] + ' Streams');
					}
				}
			}
		}
	});
	//eliminate the "chose date text (don't ask why we need 4 &nbsp;'s)
	$j('.dp-choose-date').html('&nbsp;&nbsp;&nbsp;&nbsp;');

	//add cell render function cb (to show which days have videos) 
	
	
	//bind start date end date ranges (so you can select invalid date range): 
	$j('#vs_'+inx).bind(
		'dpClosed',
		function(e, selectedDates)
		{
			var d = selectedDates[0];
			if (d) {
				d = new Date(d);
				$j('#ve_'+inx).dpSetStartDate(d.addDays(1).asString());
			}
		}
	);
	$j('#ve_'+inx).bind(
		'dpClosed',
		function(e, selectedDates)
		{
			var d = selectedDates[0];
			if (d) {
				d = new Date(d);
				$j('#vs_'+inx).dpSetEndDate(d.addDays(-1).asString());
			}
		}
	);
}
function mv_ex(mvd_id){
	uri = wgServer +((wgServer == null) ? (wgScriptPath + "/index.php") : wgScript);	
	js_log('expand ' + mvd_id);	
	//swap the image: 
	img_parts = $j('#mv_img_ex_'+mvd_id).attr('src').split('/');
	if(img_parts.pop()=='closed.png'){
		//$j('#mvr_desc_'+mvd_id).fadeOut('fast');
		
		$j('#mv_img_ex_'+mvd_id).attr('src', img_parts.join('/') + '/opened.png');
		$j('#mv_watch_clip_'+mvd_id).fadeOut('fast', function(){
			$j('#mv_close_clip_'+mvd_id).fadeIn('fast');
		});
		
		$j('#mvr_'+mvd_id).css('display', 'block').html(global_loading_txt);
		//grab search terms:
		var terms='';
		$j('.mv_hl_text').each(function(){
			terms+='|'+$j(this).val().replace(/|/, '');		
		});
		$j.get(uri, 
		{action:'ajax',rs:'mv_expand_wt', "rsargs[0]":mvd_id, "st":terms},
		function(data){				
			//run highlighter on data: 
			//js_log('set to: '+ data);
			$j('#mvr_'+mvd_id).html(data);
			hl_search_terms('#mvr_'+mvd_id);
			//rewrite video tag: 
			rewrite_by_id('vid_'+mvd_id);
		});
	}else{
		$j('#mv_close_clip_'+mvd_id).fadeOut('fast', function(){
			$j('#mv_watch_clip_'+mvd_id).fadeIn('fast');
		});
		//$j('#mvr_desc_'+mvd_id).fadeIn('fast');
		//$j('#vrdesc_'+mvd_id).fadeIn('fast');		
		$j('#mv_img_ex_'+mvd_id).attr('src', img_parts.join('/') + '/closed.png');
		$j('#mvr_'+mvd_id).css('display', 'none');
	}		
}
function hl_search_terms(result_selector){
	//get all the terms	
	var terms = new Array();

	$j('.mv_hl_text').each(function(){
		js_log('on val: '+ $j(this).val());			
		//do_node_replace($j(result_selector).get(0), $j(this).val());		
		result = $j(this).val().replace(/\'|"/g, '');
        result = result.split(/[\s,\+\.]+/);
        for(i=0;i<result.length;i++){
        	terms.push( result[i].toUpperCase() );
        }        
	});
	$j(result_selector).each(function(){
		for(i in terms){
			term = terms[i];
			//js_log("do hl call: "+ term);
			$j.highlight(this, term);
		}
	});
	
	//if(terms.length!=0){
		//var regex = new RegExp().compile('('+terms.join('|')+')', "ig");
		//console.log(terms + ' reex: ' + regex);
		//$j(result_selector).each(function(){					
		// 	$j(this).html($j(this).html().replace(regex, '<span class="hl_term">$1</span>'));
		//});
	//}
}
/*function do_node_replace(node, te) {
   js_log('n_id:'+ node.id +' '+ node.tagName +' inner:'+ node.innerHTML);
   var pos, skip, spannode, middlebit, endbit, middleclone;
   skip = 0;
   if (node.nodeType == 3) {
    pos = node.data.toUpperCase().indexOf(te);
    if (pos >= 0) {
     spannode = document.createElement('span');
     spannode.className = 'highlight';
     middlebit = node.splitText(pos);
     endbit = middlebit.splitText(te.length);
     middleclone = middlebit.cloneNode(true);
     spannode.appendChild(middleclone);
     middlebit.parentNode.replaceChild(spannode, middlebit);
     skip = 1;
    }
   }
   else if (node.nodeType == 1 && node.childNodes && !/(script|style)/i.test(node.tagName)) {
    for (var i = 0; i < node.childNodes.length; ++i) {
     i += $j.highlight(node.childNodes[i], te);
    }
   }
   return skip;
}*/
function mv_add_ac(id){
	
}
function mv_add_person_ac(inx){
	//now add the auto complete to mv_person_input_{inx}
	uri = wgServer +
	((wgServer == null) ? (wgScriptPath + "/index.php") : wgScript);
	$j('#mv_person_input_'+inx).autocomplete(
		uri,
		{
			autoFill:true,
			onItemSelect:function(v){		
				js_log('selected:' + v.innerHTML );
				//update the image: 
				$j('#mv_person_img_'+inx).attr('src', $j(v).children('img').attr('src'));
			},
			formatItem:function(row){
				return '<img width="44" src="'+ row[2] + '">'+row[1];
			},
			matchSubset:0,
			extraParams:{action:'ajax',rs:'mv_auto_complete_person'},
			paramName:'rsargs[]',
			resultElem:'#mv_person_choices_'+inx
		});			
	$j('#mv_person_choices_'+inx).css({
		'left':$j('#mv_person_input_'+inx).get(0).offsetLeft,
		'top':$j('#mv_person_input_'+inx).get(0).offsetTop + $j('#mv_person_input_'+inx).height()+6 });
}
function mv_add_filter(){
	//close the first filter select rename inx to inx+1
	var new_t_id = 'mvsel_t_'+ ($j(".mv_search_select").length-1);
	var new_a_id = 'mvsel_a_'+ ($j(".mv_search_select").length-1);
	var inx = ($j(".mv_search_select").length-1);
	//this could be cleaned up a bit: 
	$j("#mv_active_filters").append('<span id="mvs_'+inx+'" >&nbsp;&nbsp;</span>');	
		$j('#mvs_'+inx).append( 
			$j("#mvsel_a_0").clone().attr({id:new_a_id,name:'f['+inx+'][a]'}), 
			$j("#mvsel_t_0").clone().attr({id:new_t_id,name:'f['+inx+'][t]'}) 
		);	
		//reset the selector for both selectors: : 
		$j('#'+new_t_id+',#'+new_a_id).get(0).selectedIndex=null;
		$j('#'+new_a_id).css('display', 'inline');
		$j('#mvs_'+inx).append('<span id="mvs_'+inx+'_tc"></span>');
		$j('#mvs_'+inx).append( $j("#mv_ref_remove")
			.clone().css('display', 'inline')
			.attr({id:'', href:'javascript:mv_remove_filter('+inx+')'}));
	
	mv_setup_search();
	//console.log("new id: " + new_id);	
	//$j('mv_sel_')
}
//remove filter of given inx
function mv_remove_filter(inx){
	$j('#mvs_'+inx).remove();
}

/*
highlight v1
Highlights arbitrary terms.
<http://johannburkard.de/blog/programming/javascript/highlight-javascript-text-higlighting-jquery-plugin.html>
MIT license.
Johann Burkard
<http://johannburkard.de>
<mailto:jb@eaio.com>
*/
function add_highlight_function(){
$j(function() {	
 jQuery.highlight = document.body.createTextRange ? 
/*
Version for IE using TextRanges.
*/
  function(node, te) {
   var r = document.body.createTextRange();
   r.moveToElementText(node);
   for (var i = 0; r.findText(te); i++) {
    r.pasteHTML('<span class="searchmatch">' +  r.text + '<\/span>');
    r.collapse(false);
   }
  }
 :
/*
 (Complicated) version for Mozilla and Opera using span tags.
*/
  function(node, te) {
   js_log('hl:'+ te + ' nt:'+node.nodeType + ' tn:' + node.tagName);
   var pos, skip, spannode, middlebit, endbit, middleclone;
   skip = 0;
   if (node.nodeType == 3) {
    pos = node.data.toUpperCase().indexOf(te);
    if (pos >= 0) {
     spannode = document.createElement('span');
     spannode.className = 'searchmatch';
     middlebit = node.splitText(pos);
     endbit = middlebit.splitText(te.length);
     middleclone = middlebit.cloneNode(true);
     spannode.appendChild(middleclone);
     middlebit.parentNode.replaceChild(spannode, middlebit);
     skip = 1;
    }
   }
   else if (node.nodeType == 1 && node.childNodes && !/(script|style)/i.test(node.tagName)) {
    for (var i = 0; i < node.childNodes.length; ++i) {
     i += $j.highlight(node.childNodes[i], te);
    }
   }
   return skip;
  }

 ;
});

jQuery.fn.removeHighlight = function() {
 return this.find("span.highlight").each(function() {
  this.parentNode.replaceChild(this.firstChild, this).normalize();
 });
};
}
