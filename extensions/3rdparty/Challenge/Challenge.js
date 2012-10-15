	function changeFilter(usr,status){
		window.location = "index.php?title=Special:ChallengeHistory&user=" + usr + "&status=" + status
	}
	
	function challengeSend(){
		err = "";
		req = ["info|The Event", "date|Event Date", "description|Description","win|Win Terms","lose|Lose Terms"]
		for(x=0;x<=req.length-1;x++){
			fld = req[x].split("|")
			if($F(fld[0]) == ""){
				err+= fld[1] + " is required\n";
			}
		}
	
		if(!err ){//&& isDate($F("date"))==true){
			document.form1.submit();
		}else{
			if(err)alert(err)
		}
	 	
	}
	function challengeCancel(id){
		var url = "index.php?title=Special:ChallengeAction&action=1";
		var pars = "id=" + id + "&status=-2";
		var myAjax = new Ajax.Request(
			url, 
			{
				method: 'post', 
				parameters: pars,
				onSuccess: function() {
					alert("Challenge has been removed")
					 $("challange-status").innerHTML = "Challenge has been removed";
				}
			});
	}
	
	function challengeResponse( ){
		var url = "index.php?title=Special:ChallengeAction&action=1";
		var pars = 'id=' + $F("challenge_id") + '&status='+$F("challenge_action");
	
		var myAjax = new Ajax.Request(
			//"status2", 
			url, 
			{
				method: 'post', 
				parameters: pars,
				onSuccess: function() {
					switch (parseInt($F("challenge_action"))){
						case 1:
						newStatus = "Accepted";
						break;
						case -1:
						newStatus = "Rejected";
						break;
						case 2:
						newStatus = "Countered";
						break;
					}
				
					 $("challange-status").innerHTML = newStatus;
				}
			});
			
	}	
	
	function challengeApproval( ){
		var url = "index.php?title=Special:ChallengeAction&action=2";
		var pars = 'id=' + $F("challenge_id") + '&userid='+$F("challenge_winner_userid");
	
		var myAjax = new Ajax.Request(
			//"status2", 
			url, 
			{
				method: 'post', 
				parameters: pars,
				onSuccess: function() {
					 $("challange-status").innerHTML = "Challenge winner has been recorded";
				}
			});
			
	}	
	
	function challengeRate( ){
		var url = "index.php?title=Special:ChallengeAction&action=3";
		var pars = 'id=' + $F("challenge_id") + '&challenge_rate='+$F("challenge_rate") + '&rate_comment='+$F("rate_comment") + '&loser_userid='+$F("loser_userid") + '&loser_username='+$F("loser_username");
	
		var myAjax = new Ajax.Request(
			//"status2", 
			url, 
			{
				method: 'post', 
				parameters: pars,
				onSuccess: function() {
					 $("challange-status").innerHTML = "Your rating has been submitted";
				}
			});
			
	}	