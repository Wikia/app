	var submitted = 0;
	function XMLHttp(){
		if (window.XMLHttpRequest){ //Moz
			var xt = new XMLHttpRequest();
		}else{ //IE
			var xt = new ActiveXObject('Microsoft.XMLHTTP');
		}
		return xt
	}

	function show_comment(id){
		fadeOut = new YAHOO.widget.Effects.Fade( ("ignore-"+id));
		fadeOut.onEffectComplete.subscribe(
			function() {
				new YAHOO.widget.Effects.BlindDown( ("comment-"+id) )
			}
		);
	}
	
	function block_user(user_name,user_id,c_id,mk){
		if(!user_name){
			user_name = _COMMENT_BLOCK_ANON;
		}else{
			user_name = _COMMENT_BLOCK_USER + " " + user_name;
		}
		if(confirm(_COMMENT_BLOCK_WARNING + " "+user_name+" ?")){
			var url = "index.php?action=ajax";
			var pars = 'rs=wfCommentBlock&rsargs[]=' + c_id + '&rsargs[]=' + user_id + '&rsargs[]=' + mk
			var callback = {
				success: function( oResponse ) {
					alert(oResponse)
					window.location.href=window.location
				}
			};
			var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);
		}
	}
	
	function cv(cid,vt,mk,vg){
		var url = "index.php?action=ajax";
		var pars = 'rs=wfCommentVote&rsargs[]=' + cid + '&rsargs[]=' + vt + '&rsargs[]=' + mk + '&rsargs[]=' + ((vg)?vg:0) + '&rsargs[]=' + document.commentform.pid.value;
		var callback = {
			success: function( oResponse ) {
				$("Comment" + cid).innerHTML = oResponse.responseText
				$("CommentBtn" + cid).innerHTML = "<img src=images/common/voted.gif align=absbottom hspace=2><span class=CommentVoted>" + _COMMENT_VOTED + "</span>";
			}
		};
		var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);
	}	
	 
	function ViewComments(pid,ord,end){
		$("allcomments").innerHTML = _COMMENT_LOADING + "<br><br>";
		var url = wgScript + "?title=Special:CommentListGet&pid="+pid+"&ord="+ord;
		var pars = '';
		var callback = {
			success: function(oResponse) {
					$("allcomments").innerHTML = oResponse.responseText
					submitted = 0
					if(end)window.location.hash = "end";
			}
		};
		var request = YAHOO.util.Connect.asyncRequest('GET', url, callback, pars);	
	}		


	function FixStr(str){
		str = str.replace(/&/gi,"%26");
		str = str.replace(/\+/gi,"%2B")
		return str;
	}
	
	function submit_comment(){
		if(submitted==0){
			submitted = 1;
			sXMLHTTP = XMLHttp();
			sXMLHTTP.onreadystatechange=function(){
			if(sXMLHTTP.readyState==4){
					if(sXMLHTTP.status==200){
						document.commentform.comment_text.value=''
						ViewComments(document.commentform.pid.value,0,1)
					}
				}
			}
	
			sXMLHTTP.open("POST", wgScript + "?action=ajax", true );
	
			sXMLHTTP.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			sXMLHTTP.send('rs=wfCommentSubmit&rsargs[]=' + document.commentform.pid.value + '&rsargs[]=' + ((!document.commentform.comment_parent_id.value)?0:document.commentform.comment_parent_id.value) + '&rsargs[]='+ FixStr(document.commentform.comment_text.value) + '&rsargs[]=' + document.commentform.sid.value + '&rsargs[]=' + document.commentform.mk.value);
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
		Ob("spy").innerHTML= "<a href=javascript:ToggleLiveComments(" + ((status)?0:1) + ") style='font-size:10px'>" + ((status)?_COMMENT_PAUSE_REFRESHER:_COMMENT_ENABLE_REFRESHER) + " " + _COMMENT_REFRESHER + "</a>"
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
		url="index.php?action=ajax&rs=wfCommentLatestID&rsargs[]=" + document.commentform.pid.value;
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
		$("replyto").innerHTML = _COMMENT_REPLY_TO + " " + poster + " (<a href=javascript:Cancel_Reply()>" + _COMMENT_CANCEL_REPLY + "</a>) <br>"
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

