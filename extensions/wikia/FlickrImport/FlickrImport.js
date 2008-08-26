function show_flickr_search(){
	el = $("flickr-search");

	if( $D.getStyle(el,"display") != "none" ){
		action = YAHOO.widget.Effects.Hide(el); //new YAHOO.widget.Effects.BlindUp( el )
	}else{
		action = YAHOO.widget.Effects.Show(el); //new YAHOO.widget.Effects.BlindDown( el )
	}
}

function submit_flickr_search(){
	show_loading();
	setTimeout("document.flickr.submit();",500);
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


function detEnter(e) {
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;
	if (keycode == 13){
		submit_flickr_search()
		return false;
	} else return true;
}

function toggle_photo( id, image_url, chk ){
	if( $("selected_flickr_" + id) ){
		remove_photo(id);
	}else{
		add_photo_check( id, image_url, chk );
	}
}

function update_title( id, value){
	if( $( id ) ){
		$( id ).title = value	
	}
}

function add_photo_check( id, image_url, title_field){
	
	image_title = $("title-" + id).value;
	
	var url = "index.php?action=ajax";
	var pars = "rs=wfImageExists&rsargs[]="+escape( image_title )
	var callback = {
		success: function( req ) {
			if(req.responseText.indexOf("OK")>=0){
				
				add_photo( id, image_url )
			}else{
				title_field.checked = false
				alert("Please choose another video name");
			}
		}
	};
	var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);
}

function add_photo( id, image_url ){
	
	$( "title-" + id ).disabled = true;
	image_title = $("title-" + id).value;
	
	YAHOO.widget.Effects.Hide( $("select-instructions") );
	
	el = document.createElement("div");
	el.setAttribute('id', "selected_flickr_" + id); 
	$D.addClass(el,"selected-photo-container");
	$D.setStyle(el,"display","none");
	el.innerHTML =  "<img src=\"" + image_url + "\" id=\"" + id + "\" title=\"" + image_title + "\"   /><br/>" + image_title + "<br/>";
	$D.insertAfter(el, "select-instructions" );
	
	new YAHOO.widget.Effects.Appear(el, { duration:2.0 });
}

function remove_photo( id ){
	$( "title-" + id ).disabled = false;
	YAHOO.util.Element.remove("selected_flickr_" + id);
}

var submitted = 0;
function import_photos(){
	if(submitted == 1)return 0;
	
	submitted = 1
	selected = 0;
	photo_ids = "";
	
	selectedItems = $$('selected-photo-container','div')
	for(x=0;x<=selectedItems.length-1;x++){
		selected++;
		photo_id = selectedItems[x].id.replace("selected_flickr_","");
		photo_title = $( photo_id ).title
		photo_ids += ((photo_ids)?",":"") + photo_id + "|" + photo_title.replace("|","");
	}


	if(selected==0){
		alert("Please select at least one photo");
		submitted = 0;
		return 0;
	}
	
	$("ids").value =  photo_ids;
	show_loading(_IMPORTING_MSG);
	 
	document.photos.submit();
	
}


function get_results_page(page,search){
	show_loading();
	var url = "index.php?action=ajax";
	var pars = 'rs=wfGetFlickrPhotos&rsargs[]=' + page + '&rsargs[]=' + escape(search);
	var callback = {
		success: function( oResponse ) {
			$("flickr-results").innerHTML = oResponse.responseText;
			hide_loading();
		}
	};
	var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);
}	
