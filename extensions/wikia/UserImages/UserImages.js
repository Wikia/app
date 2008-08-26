function doHover(divID) {
	$El(divID).setStyle('backgroundColor', '#4B9AF6'); 
}

function endHover(divID){
	$El(divID).setStyle('backgroundColor', ''); 
}


function loadImage (current_page, user, direction) {
	var url = "index.php?action=ajax";
	var pars = 'rs=wfSlideShow&rsargs[]='+current_page+'&rsargs[]='+user+'&rsargs[]='+direction
	var callback = {
		success: function( oResponse ) {
			$('user-image-container').innerHTML = oResponse.responseText
			current_page++;

		}
	};
	var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);
	
}