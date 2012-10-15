	var submitted = 0;
	function XMLHttp(){
		if (window.XMLHttpRequest){ //Moz
			var xt = new XMLHttpRequest();
		}else{ //IE
			var xt = new ActiveXObject('Microsoft.XMLHTTP');
		}
		return xt
	}
	
	function cv(cid,vt,mk,vg){
		//var url = "extensions/CommentAction.php?Action=1";
		var url = "index.php?title=Special:CommentAction&Action=1";
		var pars = 'cid=' + cid + '&vt=' + vt + '&mk=' + mk + '&vg=' + vg + '&pid=' + document.commentform.pid.value;
		var myAjax = new Ajax.Updater(
			"Comment" + cid, 
			url, 
			{
				method: 'post', 
				parameters: pars,
				onSuccess: function() {
					$("CommentBtn" + cid).innerHTML = "<img src=http://www.development.wikiscripts.org/images/myfeed.gif align=absbottom hspace=2><span class=CommentVoted>voted</span>";
				}
			});
	}	
	 
	function ViewComments(pid,ord,end){
		$("allcomments").innerHTML = "Loading...<br><br>";
		//var url = "extensions/CommentAction.php?Action=2";
		var url = "index.php?title=Special:CommentAction&Action=2";
		var pars = 'pid=' + pid + '&ord='+ord;
		var myAjax = new Ajax.Updater(
			"allcomments", 
			url, 
			{
				method: 'post', 
				parameters: pars,
				onSuccess: function() {
					submitted = 0
					if(end)window.location.hash = "end";
				}
			});
			
	}	
	
	function showResponse(originalRequest)
	{
		//put returned XML in the textarea
		alert(originalRequest.responseText);
	}

	function FixStr(str){
		str = str.replace(/&/gi,"%26");
		str = str.replace(/\+/gi,"%2B")
		return str;
	}
	
	function SubmitComment(){
		if(submitted==0){
			submitted = 1;
			sXMLHTTP = XMLHttp();
			sXMLHTTP.onreadystatechange=function(){
			if(sXMLHTTP.readyState==4){
					if(sXMLHTTP.status==200){
						//alert(sXMLHTTP.responseText)
						document.commentform.comment_text.value=''
						ViewComments(document.commentform.pid.value,0,1)
					}
				}
			}
	
			//sXMLHTTP.open("POST","extensions/CommentAction.php?Action=3", true );
			sXMLHTTP.open("POST","index.php?title=Special:CommentAction&Action=3", true );
	
			sXMLHTTP.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			sXMLHTTP.send('pid=' + document.commentform.pid.value + '&par=' + document.commentform.comment_parent_id.value + '&ct='+ FixStr(document.commentform.comment_text.value) + '&sid=' + document.commentform.sid.value + '&mk=' + document.commentform.mk.value);
			Cancel_Reply()
		}
	}
	
	function Ob(e,f){
		if(document.all){
			return ((f)? document.all[e].style:document.all[e]);
		}else{
			return ((f)? document.getElementById(e).style:document.getElementById(e));
		}
	}
	
	var isBusy = false;
	var timer;
	var updateDelay = 7000;
	var LatestCommentID = "";
	var CurLatestCommentID = "";
	var pause = 0;
	
	function ToggleLiveComments(status){
		if(status){
			Pause=0
		}else{
			Pause=1
		}
		Ob("spy").innerHTML= "<a href=javascript:ToggleLiveComments(" + ((status)?0:1) + ") style='font-size:10px'>" + ((status)?"Pause":"Enable") + " Comment Auto-Refresher</a>"
		if(!pause){
			LatestCommentID = document.commentform.lastcommentid.value
			timer = setTimeout('checkUpdate()', updateDelay);
		}
	}
	
	function checkUpdate(){
		if (isBusy) {
			return;
		}
		oXMLHTTP = XMLHttp();
		url="index.php?title=Special:CommentAction&Action=4&pid=" + document.commentform.pid.value;

		//url="extensions/CommentAction.php?Action=4&pid=" + document.commentform.pid.value;
		oXMLHTTP.open("GET",url,true);
		oXMLHTTP.onreadystatechange=UpdateResults;
		oXMLHTTP.send(null);
		isBusy = true;
		return false;
	}
	
	function UpdateResults(){
		if (!oXMLHTTP || oXMLHTTP.readyState != 4) return;
		if (oXMLHTTP.status == 200){
			//get last new id
			CurLatestCommentID = oXMLHTTP.responseText
			//alert(CurLatestCommentID + "--" + LatestCommentID)
			if(CurLatestCommentID != LatestCommentID){
				ViewComments(document.commentform.pid.value,0,1)
				LatestCommentID = CurLatestCommentID
			}
	
		}
    	isBusy = false;
		if (!pause) {
			clearTimeout(timer);
     		timer = setTimeout('checkUpdate()', updateDelay);
		}
	}
	
	function Reply(parentid,poster){
		$("replyto").innerHTML = "Reply to " + poster + " (<a href=javascript:Cancel_Reply()>cancel</a>) <br>"
		document.commentform.comment_parent_id.value = parentid
	}
	
	function Cancel_Reply(){
		$("replyto").innerHTML = ""
		document.commentform.comment_parent_id.value = ""
	}
	
	function ChangeToStep(Stp,Drt){
		$("Step" + Stp).style.visibility="visible"
		$("Step" + Stp).style.display="block";

		$("Step" + (Stp-Drt)).style.visibility="hidden"
		$("Step" + (Stp-Drt)).style.display="none";
	}

