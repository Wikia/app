var img = new Image();
img.src = "http://images.wikia.com/common/wikiany/images/overlay.png?1";

var img2 = new Image();
img.src = "http://images.wikia.com/common/wikiany/images/ajax-loader.gif?1";

var cleanTitle = document.title;

// flags an image set
function flagImg(msg){
	//var ask = confirm("Are you sure you want to report these images?");
	var ask = confirm(msg);
	if (ask){
		
		var sUrl = '?title=Special:PictureGameHome&picGameAction=flagImage&key=' + $('key').value + '&id=' + $('id').value + '';	
		var callback =
		{
		  success: function(t) {
			$('serverMessages').innerHTML = '<strong>' + t.responseText + '</strong>';
		  },
		  failure: function(t) { 
			  $('serverMessages').innerHTML = '<strong>' + t.responseText + '</strong>'; 
		  }
		}
		var transaction = YAHOO.util.Connect.asyncRequest('GET', sUrl, callback, null);
		/*
		new Ajax.Request('?title=Special:PictureGameHome&picGameAction=flagImage&key=' + $F('key') + '&id=' + $F('id') + '', {
				onSuccess: function(t){	
					$('serverMessages').innerHTML = '<strong>' + t.responseText + '</strong>';
				}, 
				onError: function(t){ $('serverMessages').innerHTML = '<strong>' + t.responseText + '</strong>' }
		});
		*/
	}
}

function doHover(divID){
	if (divID=='imageOne') {
		$El(divID).setStyle('background-color', '#4B9AF6');
	} else {
		$El(divID).setStyle('background-color', '#FF1800');
	}
	
}

function endHover(divID){
	$El(divID).setStyle('background-color', '');
}

function editPanel(){
	document.location = '?title=Special:PictureGameHome&picGameAction=editPanel&id=' + $('id').value;
}

function protectImages(msg){
	//var ask = confirm("Are you sure you want to protect these images?");
	var ask = confirm(msg);
	if (ask){
		
		var sUrl = '?title=Special:PictureGameHome&picGameAction=protectImages&key=' + $('key').value + '&id=' + $('id').value;	
		var callback =
		{
		  success: function(t) {
			$('serverMessages').innerHTML = '<strong>' + t.responseText + '</strong>';
		  }
		}
		var transaction = YAHOO.util.Connect.asyncRequest('GET', sUrl, callback, null);
		/*
		new Ajax.Request('?title=Special:PictureGameHome&picGameAction=protectImages&key=' + Form.Element.getValue('key') + '&id=' + Form.Element.getValue('id'), {
				onSuccess: function(t){	
					$('serverMessages').innerHTML = '<strong>' + t.responseText + '</strong>';	
				}
		});
		*/
	}
}

function castVote(picID){
	if (document.getElementById('lightboxText')!=null) {
		// pop up the lightbox
		objLink = new Object();
		//objLink.href = "../../images/common/ajax-loader.gif"
		objLink.href = "#";
		objLink.title = "";
		
		showLightbox(objLink);
		
		setLightboxText( '<embed src="/extensions/wikia/PictureGame/picturegame/ajax-loading.swf" quality="high" wmode="transparent" bgcolor="#ffffff"' + 
					'pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash"' + 
					'type="application/x-shockwave-flash" width="100" height="100">' +
					'</embed>' );
		
		//document.picGameVote.lastid.value = $F('id');
		document.picGameVote.lastid.value = $('id').value;
		document.picGameVote.img.value = picID;
		//var postBody = 'key=' + Form.Element.getValue('key') + '&id=' + Form.Element.getValue('id') + '&img=' + picID + '&nextid='+ $F('nextid')
		var postBody = 'key=' + $('key').value + '&id=' + $('id').value + '&img=' + picID + '&nextid='+ $('nextid').value
		//alert(postBody);
		var sUrl = '?title=Special:PictureGameHome&picGameAction=castVote';	
		var callback =
		{
		  success: function(t) {
			window.location = '?title=Special:PictureGameHome&picGameAction=startGame&lastid=' + $('id').value +'&id=' + $('nextid').value;
		  }
		}
		var transaction = YAHOO.util.Connect.asyncRequest('POST', sUrl, callback, postBody);
	
		/*
		new Ajax.Request('?title=Special:PictureGameHome&picGameAction=castVote', 
			{method:'post',
				postBody:'key=' + Form.Element.getValue('key') + '&id=' + Form.Element.getValue('id') + '&img=' + picID + '&nextid='+ $F('nextid'), 
				onSuccess:	
				function(t){
					window.location = '?title=Special:PictureGameHome&picGameAction=startGame&lastid=' + $F('id') +'&id=' + $F('nextid');
				}
			});
		*/
	}
}