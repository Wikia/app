var img = new Image();
img.src = "http://images.wikia.com/common/wikiany/images/overlay.png?1";

var img2 = new Image();
img.src = "http://images.wikia.com/common/wikiany/images/ajax-loader.gif?1";


	function detectMacXFF() {
	  var userAgent = navigator.userAgent.toLowerCase();
	  if (userAgent.indexOf('mac') != -1 && userAgent.indexOf('firefox')!=-1) {
	    return true;
	  }
	}

	function show_poll( ){
		$El('loading-poll').hide();
		$El('poll-display').show();
	}
	
	function poll_loading_light_box(){
		// pop up the lightbox
		objLink = new Object();
		//objLink.href = "../../images/common/ajax-loader.gif"
		objLink.href = "";
		objLink.title = "";
		
		showLightbox(objLink);
		
		if( !detectMacXFF() ){
		setLightboxText( '<embed src="/extensions/wikia/Poll/ajax-loading.swf" quality="high" wmode="transparent" bgcolor="#ffffff"' + 
					'pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash"' + 
					'type="application/x-shockwave-flash" width="100" height="100">' +
					'</embed>' );
		}else{
			setLightboxText( 'Loading...');
		}
	}
	
	function poll_skip(){
		poll_loading_light_box()
		var url = "index.php?action=ajax";
		var pars = 'rs=wfPollVote&rsargs[]=' + $("poll_id").value + '&rsargs[]=-1'
		var callback = {
			success: function( oResponse ) {
				goto_new_poll()
			}
		};
		var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);	
	}
	
	var voted = 0;
	function poll_vote(){
		if(voted==1)return 0;
		
		voted = 1;

		poll_loading_light_box()
		choice_id=0;
		for (var i=0; i < document.poll.poll_choice.length; i++){
			if (document.poll.poll_choice[i].checked){
				choice_id = document.poll.poll_choice[i].value;
			}
			
		}
		
		if(choice_id){
			//cast vote
			var url = "index.php?action=ajax";
			var pars = 'rs=wfPollVote&rsargs[]=' + $("poll_id").value + '&rsargs[]=' + choice_id
			var callback = {
				success: function( oResponse ) {
					goto_new_poll()
				}
			};
			var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);	
		}
		
	}
	
	function goto_new_poll(){
		//cast vote
		var url = "index.php?action=ajax&rs=wfGetRandomPoll";
		var pars = ''
		var callback = {
			success: function( req ) {
				//redirect to next poll they haven't voted for
				if( req.responseText.indexOf("error") == -1 ){
					window.location = wgServer + "/index.php?title=" + req.responseText + "&prev_id=" + wgArticleId 
				}else{
					//have run out of polls
					//lightbox prompting to create 
					setLightboxText(_POLL_FINISHED);
				}
			}
		};
		var request = YAHOO.util.Connect.asyncRequest('GET', url, callback, pars);			
	}
	
	function poll_toggle_status(status){
		if(status==0)msg = _POLL_CLOSE_MESSAGE
		if(status==1)msg = _POLL_OPEN_MESSAGE
		if(status==2)msg = _POLL_FLAGGED_MESSAGE
		var ask = confirm(msg);
	
		if (ask){
			var url = "index.php?action=ajax";
			var pars = 'rs=wfUpdatePollStatus&rsargs[]=' + $("poll_id").value + '&rsargs[]=' + status
			var callback = {
				success: function( oResponse ) {
					window.location.reload()
				}
			};
			var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);			
		}			
	}

	