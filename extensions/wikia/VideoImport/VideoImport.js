function show_youtube_search(){
	el = $("youtube-search");
	
	//temporarily disable button, so need old one to reset later
	//old_href = $("search_button").href
	//$("search_button").href = "javascript:void(0);";
	
	if( $D.getStyle(el,"display") != "none" ){
		action = YAHOO.widget.Effects.Hide(el); //new YAHOO.widget.Effects.BlindUp( el )
	}else{
		action = YAHOO.widget.Effects.Show(el); //new YAHOO.widget.Effects.BlindDown( el )
	}
	/*
	action.onEffectComplete.subscribe(
		function() {
			$("search_button").href = old_href
		}
	);
	*/
}

function submit_youtube_search(){
	show_loading();
	document.youtube.submit();
}

function show_loading(msg){   
	loading_div = document.createElement('div');
	document.body.appendChild( loading_div ); 
	loading_div.setAttribute('id', "loading"); 
	$D.addClass(loading_div,"loading-message");
	$D.setStyle(loading_div,'top',  (getYpos() + 8) + 'px' );
	$D.setStyle(loading_div, 'left',  '0px' );
	if(msg){
		loading_div.innerHTML = msg;
		$D.setStyle(loading_div, 'width',   '64px'  );
	} else {
		loading_div.innerHTML = _LOADING_MSG;
	}
}

function hide_loading(){
	YAHOO.util.Element.remove($("loading"));
}


function getYpos(){
	if (self.pageYOffset) {
		yPos = self.pageYOffset;
	} else if (document.documentElement && document.documentElement.scrollTop){
		yPos = document.documentElement.scrollTop; 
	} else if (document.body) {
		yPos = document.body.scrollTop;
	}
	return yPos
}


function detEnter(e) {
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;
	if (keycode == 13){
		submit_youtube_search();
		return false;
	} else return true;
}

function toggle_video( id, chk ){
	if( $("selected_video_" + id) ){
		remove_video(id);
	}else{
		//add_video( id, chk );
		add_video_check( id, chk );
	}
}

function update_title( id, value){
	if( $( id ) ){
		$( id ).title = value	
	}
}

function add_video_check( id, title_field){
	
	image_title = $("title-" + id).value;
	
	var url = "index.php?action=ajax";
	var pars = "rs=wfVideoTitleExists&rsargs[]="+escape( image_title.replace("+","&#43;") )
	var callback = {
		success: function( req ) {
			if(req.responseText.indexOf("OK")>=0){
				
				add_video( id )
			}else{
				title_field.checked = false
				alert("Please choose another video name");
			}
		}
	};
	var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);
}
						
function add_video( id ){
	
	$( "title-" + id ).disabled = true;

	YAHOO.widget.Effects.Hide( $("select-instructions") );
	image_url = "http://img.youtube.com/vi/" + id + "/2.jpg"
	image_title = $("title-" + id).value;

	
	el = document.createElement("div");
	el.setAttribute('id', "selected_video_" + id); 
	
	$D.addClass(el,"selected-video-container");
	$D.setStyle(el,"display","none");
	
	el.innerHTML =  "<img src=\"" + image_url + "\" id=\"" + id + "\" title=\"" + image_title + "\" /><br/>" + image_title + "<br/>";
	$D.insertAfter(el, "select-instructions" );
	
	new YAHOO.widget.Effects.Appear(el, { duration:2.0 });
}

function remove_video( id ){
	
	$( "title-" + id ).disabled = false;
	
	YAHOO.util.Element.remove("selected_video_" + id);
}

var submitted = 0;
function import_videos(){
	if(submitted == 1)return 0;
	
	submitted = 1
	selected = 0;
	video_ids = "";
	
	selectedItems = $$('selected-video-container','div')
	for(x=0;x<=selectedItems.length-1;x++){
		selected++;
		video_id = selectedItems[x].id.replace("selected_video_","");
		video_title = $( video_id ).title
		video_ids += ((video_ids)?",":"") + video_id + "|" + video_title.replace("|","");
		 
			 
	}

	if(selected==0){
		alert("Please select at least one video");
		submitted = 0;
		return 0;
	}
	
	$("ids").value =  video_ids;
	show_loading(_IMPORTING_MSG);
	document.videos.submit();
	
}


function get_results_page(page,search){
	show_loading();
	var url = "index.php?action=ajax";
	var pars = 'rs=wfGetYouTubeVideos&rsargs[]=' + page + '&rsargs[]=' + escape(search);
	var callback = {
		success: function( oResponse ) {
			$("youtube-results").innerHTML = oResponse.responseText;
			hide_loading();
			window.location.hash = "end";
		}
	};
	var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);
}	

