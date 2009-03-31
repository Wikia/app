//add media wizard integration for mediaWiki

/* config */
//Setup your content providers (see the remoteSearchDriver::content_providers for all options)
var wg_content_proivers_config = {}; //you can overwrite by defining (after)

var wg_local_wiki_api_url = wgServer + wgScriptPath + '/api.php';

//if mv_embed is hosted somewhere other than near by the external_media_wizzard you can define it here: 
var mv_embed_url = null;

//*code should not have to modify anything below*/
//check if we are on a edit page:
if(wgAction=='edit'){
	//add onPage ready request:
	addOnloadHook( function(){			
		var toolbar = document.getElementById("toolbar");
		var imE = document.createElement('img');
		imE.style.cursor = 'pointer';		
		imE.src = 'http://upload.wikimedia.org/wikipedia/commons/8/86/Button_add_media.png';
		toolbar.appendChild(imE);	
		imE.setAttribute('onClick', 'mv_do_load_wiz()');
		//addHandler only works once
		/*addHandler( imE, 'click', function() {
			mv_do_load_wiz();
		});*/
	});
}
var caret_pos={};
function mv_do_load_wiz(){
	caret_pos={};	
	var txtarea = document.editform.wpTextbox1;
	caret_pos.s = getTextCusorStartPos( txtarea );
	caret_pos.e = getTextCusorEndPos( txtarea );		
	caret_pos.text = txtarea.value;	
	//show the loading screen:
	var elm = document.getElementById('modalbox')
	if(elm){
		//use jquery to re-display the search
		if( typeof $j != 'undefined'){
			$j('#modalbox,#mv_overlay').show();
		}
	}else{
		var body_elm = document.getElementsByTagName("body")[0];
		body_elm.innerHTML = body_elm.innerHTML + ''+		
			'<div id="modalbox" style="background:#DDD;border:3px solid #666666;font-size:115%;'+
				'top:30px;left:20px;right:20px;bottom:30px;position:fixed;z-index:100;">'+			
				'loading external media wizard<blink>...</blink>'+			
			'</div>'+		
			'<div id="mv_overlay" style="background:#000;cursor:wait;height:100%;left:0;position:fixed;'+
				'top:0;width:100%;z-index:5;filter:alpha(opacity=60);-moz-opacity: 0.6;'+
				'opacity: 0.6;"/>';
	}

	//get mv_embed path from _this_ file location: 
	if(!mv_embed_url)
		mv_embed_url = getMvEmbedUrl();
		
	//inject mv_embed
	if( typeof MV_EMBED_VERSION == 'undefined'){
		var e = document.createElement("script");
	    e.setAttribute('src', mv_embed_url);
	    e.setAttribute('type',"text/javascript");
	    document.getElementsByTagName("head")[0].appendChild(e);
	    setTimeout('check_for_mv_embed();', 25); 
	}else{
		check_for_mv_embed();
	}      	
	return false;
}
function check_for_mv_embed(){
	if( typeof MV_EMBED_VERSION == 'undefined'){
		setTimeout('check_for_mv_embed();', 25);
	}else{
		//restore text value: 
		var txtarea = document.editform.wpTextbox1;		
		txtarea.value = caret_pos.text;
		//do the remote search interface:		
		mv_do_remote_search({
			'target_id':'modalbox',
			'profile':'mediawiki_edit',
			'target_textbox': 'wpTextbox1', 
			'caret_pos': caret_pos,			
			//note selections in the textbox will take over the default query
			'default_query': wgTitle,
			'target_title':wgPageName,
			'cpconfig':wg_content_proivers_config,
			'local_wiki_api_url': wg_local_wiki_api_url
		});
	}
}
function getMvEmbedUrl(){
	for(var i=0; i < document.getElementsByTagName('script').length; i++){
		var s = document.getElementsByTagName('script')[i];
		if( s.src.indexOf('external_media_wizard.js') != -1 ){
			//use the path: 
			return s.src= s.src.replace('external_media_wizard.js', '') + 'mv_embed/mv_embed.js';
		}
	}
	alert('Error: could not find mv_embed path');
}
/*once we modify the dom we lose the text selection :( so here are some get pos functions  */
function getTextCusorStartPos(o){		
	if (o.createTextRange) {
			var r = document.selection.createRange().duplicate()
			r.moveEnd('character', o.value.length)
			if (r.text == '') return o.value.length
			return o.value.lastIndexOf(r.text)
		} else return o.selectionStart
}
function getTextCusorEndPos(o){
	if (o.createTextRange) {
		var r = document.selection.createRange().duplicate();
		r.moveStart('character', -o.value.length);
		return r.text.length;
	} else{ 
		return o.selectionEnd
	}
}

