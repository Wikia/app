	
	function detectMacXFF() {
	  var userAgent = navigator.userAgent.toLowerCase();
	  if (userAgent.indexOf('mac') != -1 && userAgent.indexOf('firefox')!=-1) {
	    return true;
	  }
	}

	function deleteQuestion(){
		
		var url = "index.php?action=ajax";
		var postBody = 'rs=wfQuestionGameAdmin&rsargs[]=deleteItem&rsargs[]=' + $( 'quizGameKey' ).value + '&rsargs[]=' + $( 'quizGameId' ).value;
		var callback = 
		{
			success:function(t){	
					$('ajax-messages').innerHTML = t.responseText + "<br />" + __quiz_js_reloading__;
					document.location = '/index.php?title=Special:QuizGameHome&questionGameAction=launchGame';
			},
			failure:function(t) { 
					alert( __quiz_js_errorwas__ + ' ' + t.responseText); }
		}
		var transaction = YAHOO.util.Connect.asyncRequest('POST', url, callback, postBody);
	}

	function showEditMenu(){
		document.location = wgServer + "/index.php?title=Special:QuizGameHome&questionGameAction=editItem&quizGameId=" + 
				     $( 'quizGameId' ).value + "&quizGameKey=" + $( 'quizGameKey' ).value;
	}

	function flagQuestion(){
		$El('flag-comment').show();
	}
	
	function doflagQuestion(){

		var url = "index.php?action=ajax";
		var postBody = 'rs=wfQuestionGameAdmin&rsargs[]=flagItem&rsargs[]=' + $( 'quizGameKey' ).value + '&rsargs[]=' + $( 'quizGameId' ).value + '&rsargs[]=' + $( 'flag-reason' ).value;
		var callback = 
		{
				success: function(t){	$('ajax-messages').innerHTML = t.responseText;$El('flag-comment').hide();},
				failure: function(t) { alert('Error was: ' + t.responseText); }
		}
		var transaction = YAHOO.util.Connect.asyncRequest('POST', url, callback, postBody);
	}

	
	function protectImage(){	
		var url = "index.php?action=ajax";
		var postBody = 'rs=wfQuestionGameAdmin&rsargs[]=protectItem&rsargs[]=' + $( 'quizGameKey' ).value + '&rsargs[]=' + $( 'quizGameId' ).value;
		var callback = 
		{
				success: function(t){	$('ajax-messages').innerHTML = t.responseText;},
				failure: function(t) { alert('Error was: ' + t.responseText); }
		}
		var transaction = YAHOO.util.Connect.asyncRequest('POST', url, callback, postBody);
		
	}
	
	var current_timestamp = __quiz_time__;
	var current_level = 0;
	var levels_array = [30,19,9,0]
	var points_array = [30,20,10,0]
	 
	var timer = 30;
	var count_second;
	var points = 30;
	function show_answers( ){
		$El('loading-answers').hide();
		$El('quizgame-answers').show();
	}
	
	function count_down(time_viewed){
		if(time_viewed)adjust_timer(time_viewed);
		set_level();

		if( (timer-next_level) ==3  ){
			
			var options = {
				ease: YAHOO.util.Easing.easeOut,
				seconds: .5,
				maxcount: 4
			};
			new YAHOO.widget.Effects.Pulse("quiz-points", options);
			
		}
		
		 
		
		$("time-countdown").innerHTML = timer;
		timer--;
		if(timer==-1){
			$("quiz-notime").innerHTML =  __quiz_js_timesup__ ;
			if(count_second)clearTimeout(count_second)
		}else{
			count_second = setTimeout("count_down(0)",1000);
		}
	}
	
	function set_level(){
		for(x=0;x<=levels_array.length-1;x++){
			if( (timer==0 && x==levels_array.length-1) || (timer<=levels_array[x] && timer > levels_array[x +1 ]) ){
				//$("quiz-level-" + (x) ).className = "quiz-level-on"
				
				points=points_array[x]
				$("quiz-points" ).innerHTML = points + ' ' + __quiz_js_points__ ;
				next_level = ((levels_array[x+1])?levels_array[x+1]:0);
			 
			}else{
				//$("quiz-level-" + (x) ).className = "quiz-level-off"
			}
		}
	}
	
	function adjust_timer(time_viewed){
		time_diff = current_timestamp - time_viewed;
		if(time_diff > 30){
			timer = 0;
		}else{
			timer=31-time_diff; //give them extra second for page load
		}
		if(timer>30)timer=30
	}
	
	function go_to_quiz(id){
		window.location = wgServer + '/index.php?title=Special:QuizGameHome&questionGameAction=launchGame&permalinkID='+id
	}
	
	function go_to_next_quiz( ){
		window.location = wgServer + '/index.php?title=Special:QuizGameHome&questionGameAction=launchGame&lastid='+$( 'quizGameId' ).value
	}
	
	function pause_quiz(){
		if($("lightbox-loader"))$("lightbox-loader").innerHTML = '';
		if(continue_timer)clearTimeout(continue_timer)
			$("quiz-controls").innerHTML = "<a  href='javascript:go_to_next_quiz();' class='stop-button'>" + __quiz_pause_continue__ + "</a> - <a href='/index.php?title=Special:QuizLeaderBoard' class='stop-button'>" + __quiz_pause_view_leaderboard__ + "</a> - <a href='/index.php?title=Special:QuizGameHome&questionGameAction=createForm' class='stop-button'>" + __quiz_pause_create_question__ + "</a><br><br><a href='" + wgServer + "' class='stop-button'>" + __quiz_main_page_button__ + "</a>";
	}
	
	function get_loader(){
		loader='';
		loader += '<div id="lightbox-loader"><embed src="/extensions/wikia/QuizGame/ajax-loading.swf" quality="high" wmode="transparent" bgcolor="#ffffff"' + 
			'pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash"' + 
			'type="application/x-shockwave-flash" width="100" height="100"></embed></div>';
		return loader;
	}
	
	function set_lightbox_text(txt){
		if( !detectMacXFF() ){
			setLightboxText(get_loader() + ((txt)?'<br /><br />' + txt:'') );
		}else{
			setLightboxText( __quiz_js_loading__ + ((txt)?'<br /><br />' + txt:''));
		}
	}
	
	function skip_question(){
		objLink = new Object();
	
		objLink.href = "";
		objLink.title =  __quiz_js_loading__ ;
	
		showLightbox(objLink);
		
		set_lightbox_text('');
		
		var url = "index.php?action=ajax";
		var postBody = 'rs=wfQuestionGameVote&rsargs[]=-1&rsargs[]=' + $( 'quizGameKey' ).value + '&rsargs[]=' + $( 'quizGameId' ).value  + '&rsargs[]=0';
		var callback = 
		{
				success: function(t){ go_to_next_quiz($( 'quizGameId' ).value) }
		}
		var transaction = YAHOO.util.Connect.asyncRequest('POST', url, callback, postBody);

	}
	
	var continue_timer;
	var voted = 0;
	// casts a vote and forwards the user to a new question
	function vote(id){
		if(count_second)clearTimeout(count_second)
			
		if(voted==1)return 0;
		
		voted = 1;
		//alert("if itss right, you get " + points + " points\");
		
		$('ajax-messages').innerHTML = '';
		
		objLink = new Object();
	
		objLink.href = "";
		objLink.title = "";
	
		showLightbox(objLink);
		
		
		quiz_controls = "<div id='quiz-controls'><a href='javascript:void(0)' onclick='pause_quiz()' class='stop-button'>" + __quiz_lightbox_pause_quiz__ + "</a></div>";
		
		view_results_button =  "<a href='javascript:go_to_quiz(" + $( 'quizGameId' ).value + ");' class='stop-button'>" + __quiz_lightbox_breakdown__ + "</a>";
		
		var url = "index.php?action=ajax";
		var postBody = 'rs=wfQuestionGameVote&rsargs[]=' + id + '&rsargs[]=' + $( 'quizGameKey' ).value + '&rsargs[]=' + $( 'quizGameId' ).value  + '&rsargs[]=' + points;
		var callback = 
		{
				success: function(t){
					var payload = eval('(' + t.responseText + ')');
					
					continue_timer = setTimeout("go_to_next_quiz()",3000);
					//window.location = 'index.php?title=Special:QuizGameHome&questionGameAction=launchGame&lastid=' + $( 'quizGameId' ).value;
					
					percent_right = payload.percentRight + __quiz_lightbox_breakdown_percent__;
					
					if( payload.isRight == 'true'){
						
						set_lightbox_text("<p class='quizgame-lightbox-righttext'>" + __quiz_lightbox_correct__ + "<br><br>" + __quiz_lightbox_correct_points__ + " " + points + " " + __quiz_js_points__ + "</p><br>" + percent_right + "<br><br>" + view_results_button + "<br><br>" + quiz_controls);
						 
					}else{
						set_lightbox_text("<p class='quizgame-lightbox-wrongtext'>" + __quiz_lightbox_incorrect__ + "<br>" + __quiz_lightbox_incorrect_correct__ + " " + payload.rightAnswer + "</p><br>" + percent_right + "<br><br>" + view_results_button + "<br><br>" + quiz_controls); 

					}							
				},
				failure: function(t) { alert('Error was: ' + t.responseText); }
		}
		var transaction = YAHOO.util.Connect.asyncRequest('POST', url, callback, postBody);
		
	}
