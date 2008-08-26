/*
// <![CDATA[
// from the scriptalicous treasure chest

Effect.divSwap = function(element,container){
	var div = document.getElementById(container);
	var nodeList = div.childNodes;
	var queue = Effect.Queues.get('menuScope');
	
	if(queue.toArray().length<1){
		if(Element.visible(element)==false){
			for(i=0;i<nodeList.length;i++){
				if(nodeList.item(i).nodeName=="DIV" && nodeList.item(i).id!=element){
					if(Element.visible(nodeList.item(i))==true){
						Effect.Fade(nodeList.item(i))
					}
				}
			}
			Effect.Appear(element)
		}
	}
}
// ]]>
*/
var n = new Image();
n.src = '../../images/common/ajax-loader-white.gif';

function reupload(id){
	isReload = true;
	
	if(id == 1){
		
		$El("imageOne").hide();
		$El("imageOneLoadingImg").show();
		
		$("imageOneUpload-frame").onload = function handleResponse(st, doc) {
			$El("imageOneLoadingImg").hide();
			$El("imageOneUpload-frame").show();
			this.onload = function(st, doc){ return; };
		};
		
		// passes in the description of the image
		$("imageOneUpload-frame").src = $("imageOneUpload-frame").src + '&wpUploadDescription=' + $('picOneDesc').value;
		
	}else{
		
		$El("imageTwo").hide();
		$El("imageTwoLoadingImg").show();
		
		$("imageTwoUpload-frame").onload = function handleResponse(st, doc) {
			$El("imageTwoLoadingImg").hide();
			$El("imageTwoUpload-frame").show();
			this.onload = function(st, doc){ return; };
		};
		// passes in the description of the image
		$("imageTwoUpload-frame").src = $("imageTwoUpload-frame").src + '&wpUploadDescription=' + $('picTwoDesc').value;
		
	}
}

function imageOne_uploadError(message){
	$El("imageOneLoadingImg").hide();
	
	$("imageOneUploadError").innerHTML = '<h1>' + message + '</h1>';
	$("imageOneUpload-frame").src = $("imageOneUpload-frame").src
	$El("imageOneUpload-frame").show();
}

function imageTwo_uploadError(message){
	$El("imageTwoLoadingImg").hide();
	
	$("imageTwoUploadError").innerHTML = '<h1>' + message + '</h1>';
	$("imageTwoUpload-frame").src = $("imageTwoUpload-frame").src;
	$El("imageTwoUpload-frame").show();
}

function imageOne_completeImageUpload(){
	$El("imageOneUpload-frame").hide();
	$El("imageOneLoadingImg").show();
}

function imageTwo_completeImageUpload(){
	$El("imageTwoUpload-frame").hide();
	$El("imageTwoLoadingImg").show();
}

function imageOne_uploadComplete(imgSrc, imgName, imgDesc){
	$El("imageOneLoadingImg").hide();
	$El("imageOneUpload-frame").hide();
	
	$("imageOne").innerHTML = 
	'<p><b>' + imgDesc + '</b></p>' + 
	imgSrc +
	'<p><a href="javascript:reupload(1)">Edit</a></p>';
	
	document.picGamePlay.picOneURL.value = imgName;
	//document.picGamePlay.picOneDesc.value = imgDesc;
		
	YAHOO.widget.Effects.Appear("imageOne");
	
	if(document.picGamePlay.picTwoURL.value != "" && document.picGamePlay.picOneURL.value != "")
		YAHOO.widget.Effects.Appear("startButton");
}

function imageTwo_uploadComplete(imgSrc, imgName, imgDesc){
	$El("imageTwoLoadingImg").hide();
	$El("imageTwoUpload-frame").hide();
	
	$("imageTwo").innerHTML = 
	'<p><b>' + imgDesc + '</b></p>' +
	imgSrc +
	'<p><a href="javascript:reupload(2)">Edit</a></p>';
	
	document.picGamePlay.picTwoURL.value = imgName;
	//document.picGamePlay.picTwoDesc.value = imgDesc;
	
	YAHOO.widget.Effects.Appear("imageTwo");
	
	if(document.picGamePlay.picOneURL.value != "")
		YAHOO.widget.Effects.Appear("startButton");
}

function startGame(){
	
	var iserror = false;
	var gameTitle = $('picGameTitle').value;
	var imgOneURL = $('picOneURL').value;
	var imgTwoURL = $('picTwoURL').value;
	
	var errorText = "";
	
	if(gameTitle.length == 0){
		iserror = true;
		
		$El("picGameTitle").setStyle('border-style', 'solid');
		$El("picGameTitle").setStyle('border-color', 'red');
		$El("picGameTitle").setStyle('border-width', '2px');
		
		errorText = errorText + "Please enter a title!<br>";
	}
	
	if(imgOneURL.length == 0){
		iserror = true;
	
		$El("imageOneUpload").setStyle('border-style', 'solid');
		$El("imageOneUpload").setStyle('border-color', 'red');
		$El("imageOneUpload").setStyle('border-width', '2px');
		
		errorText = errorText + "Please upload image one!<br>";
	}
	
	if(imgTwoURL.length == 0){
		iserror = true;
		
		$El("imageTwoUpload").setStyle('border-style', 'solid');
		$El("imageTwoUpload").setStyle('border-color', 'red');
		$El("imageTwoUpload").setStyle('border-width', '2px');
		
		errorText = errorText + "Please upload image two!<br>";
	}
	
	if(!iserror)
		document.picGamePlay.submit();
	else
		$('picgame-errors').innerHTML = errorText;
	
}

function skipToGame(){
	document.location = 'index.php?title=Special:PictureGameHome&picGameAction=startGame';	
}