var posted = 0;

function detEnter(e,page) {
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;
	if (keycode == 13){
		add_category(page)
		return false;
	} else return true;
}

function doHover(divID) {
	$El(divID).setStyle('backgroundColor', '#FFFCA9'); 
}

function endHover(divID){
	$El(divID).setStyle('backgroundColor', '');
}

var category_counter = 0;
function add_category(page){
	if( $("category-"+page).value && !posted){
		category_text = $("category-"+page).value;
		posted = 1;
		var url = "index.php?action=ajax";
		var pars = 'rs=wfAddImageCategory&rsargs[]=' + page + '&rsargs[]=' + escape(category_text)
		
		var callback = {
			success: function( originalRequest ) {
				posted = 0;
					 
				if(originalRequest.responseText.indexOf("busy") >= 0){
					setTimeout("add_category(" + page + ")",1000);
					return 0;
				}
				
				//Inject new category box into section
				categories = category_text.split(",");
				for(x=0;x<=categories.length-1;x++){
					category = categories[x].replace(/^\s*/, "").replace(/\s*$/, "");
					
					//create new button and inject it
					el = document.createElement("div");
					el.setAttribute('id', "new-" + category_counter); 
					
					$D.addClass(el,"category-button");
					$D.setStyle(el,"display","none");
					el.innerHTML =  category + " Images";
					$D.insertBefore(el,"image-categories-container-end-"+page);

					//Allow clicking of new button to goto category page
					el2 = new YAHOO.util.Element("new-" + category_counter); 
					el2.on('click', function(e) { 
						title_to = wgArticlePath.replace("$1",_CATEGORY_NS_NAME + ":" + category + " Images");
						window.location = title_to
					},category); 
					
					//apply mouse events to new button
					YAHOO.util.Event.addListener(el,'mouseover', function(e) { 
						$D.setStyle(this,'backgroundColor', '#FFFCA9'); 
					} ); 
					YAHOO.util.Event.addListener(el,'mouseout', function(e) { 
						$D.setStyle(this,'backgroundColor', ''); 
					} ); 
					
					new YAHOO.widget.Effects.Appear(el, { duration:2.0 });
					
					category_counter++;
				}
				
				$("category-"+page).value = '';
			}
		};
		var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);
	}
}