var posted = 0;
function send_message(){
	if($("message").value && !posted){
		posted = 1;
		var url = "index.php?action=ajax";
		var pars = 'rs=wfSendBoardMessage&rsargs[]=' + $("user_name_to").value +'&rsargs[]=' + encodeURIComponent($("message").value) + '&rsargs[]=' + $("message_type").value +'&rsargs[]=10'
		var callback = {
			success: function(originalRequest){
				$("user-page-board").innerHTML = originalRequest.responseText
				posted = 0;
				$("message").value='';
			}
		};
		var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);
	}
}

function delete_message(id){
	if(confirm('Are you sure you want to delete this message?')){
		var url = "index.php?action=ajax";
		var pars = 'rs=wfDeleteBoardMessage&rsargs[]=' + id
		var callback = {
			success: function(originalRequest){
				window.location.reload();
			}
		};
		var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);
	}
}

var numReplaces = 0;
var replaceID = 0;
var replaceSrc = '';
var oldHtml = '';

function showUploadFrame(){
	new YAHOO.widget.Effects.Show('upload-container');
}

function uploadError(message){
	$('mini-gallery-' + replaceID).innerHTML = oldHtml;
	$('upload-frame-errors').innerHTML = message;
	$('imageUpload-frame').src = 'index.php?title=Special:MiniAjaxUpload&wpThumbWidth=75';

	new YAHOO.widget.Effects.Show('upload-container');
}

function textError(message){
	$('upload-frame-errors').innerHTML = message;
	new YAHOO.widget.Effects.Show('upload-frame-errors');
}

function completeImageUpload(){
	new YAHOO.widget.Effects.Hide('upload-frame-errors');
	$('upload-frame-errors').innerHTML = '';
	oldHtml = $('mini-gallery-' + replaceID).innerHTML;

	for(x=7;x>0;x--){
		$('mini-gallery-' + (x) ).innerHTML = $('mini-gallery-' + (x-1) ).innerHTML.replace('slideShowLink('+(x-1)+')','slideShowLink('+(x)+')')
	}
	$('mini-gallery-0').innerHTML ='<a><img height=\"75\" width=\"75\" src=\"http://images.wikia.com/common/wikiany/images/ajax-loader-white.gif\"/></a>';

	//new YAHOO.widget.Effects.Hide('mini-gallery-nopics');
	if($('no-pictures-containers')) {
		new YAHOO.widget.Effects.Hide('no-pictures-containers');
	}
	new YAHOO.widget.Effects.Show('pictures-containers');
}

function uploadComplete(imgSrc, imgName, imgDesc){
	replaceSrc = imgSrc;

	$('upload-frame-errors').innerHTML = '';

	//$('imageUpload-frame').onload = function(){
		var idOffset = -1 - numReplaces;
		//$D.addClass('mini-gallery-0','mini-gallery');
		//$('mini-gallery-0').innerHTML = '<a href=\"javascript:slideShowLink(' + idOffset + ')\">' + replaceSrc + '</a>';
		$('mini-gallery-0').innerHTML = '<a href=\"' + __image_prefix + imgName + '\">' + replaceSrc + '</a>';

		//replaceID = (replaceID == 7) ? 0 : (replaceID + 1);
		numReplaces += 1;

	//}
	//if ($('imageUpload-frame').captureEvents) $('imageUpload-frame').captureEvents(Event.LOAD);

	$('imageUpload-frame').src = 'index.php?title=Special:MiniAjaxUpload&wpThumbWidth=75&extra=' + numReplaces;
}

function slideShowLink(id){
	//window.location = 'index.php?title=Special:UserSlideShow&user=' + __slideshow_user + '&picture=' + ( numReplaces + id );
	window.location = 'Image:' + id;
}

function doHover(divID) {
	$El(divID).setStyle('backgroundColor', '#4B9AF6');

}

function endHover(divID){
	$El(divID).setStyle('backgroundColor', '');
}
