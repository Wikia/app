	
	
	function clickVote(TheVote,PageID,mk) {
		var url = "index.php?action=ajax";
		var params = 'rs=wfVoteClick&rsargs[]=' + TheVote + '&rsargs[]=' + PageID+'&rsargs[]=' + mk
	
		var callback = {
			success: function( oResponse ) {
				
				YAHOO.util.Dom.setStyle('votebox', 'cursor', "default");
				$("PollVotes").innerHTML = oResponse.responseText;
				$("Answer").innerHTML = "<a href=javascript:unVote(" + PageID + ",'" + mk + "')>" + _UNVOTE_LINK + "</a>";
			}
		};

		var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, params);
	}
	
	function unVote(PageID,mk){
		var url = "index.php?action=ajax";
		var params = 'rs=wfVoteDelete&rsargs[]=' + PageID + '&rsargs[]=' + mk;
		var callback = {
			success: function( oResponse ) {
				YAHOO.util.Dom.setStyle('votebox', 'cursor', "pointer");
				$("PollVotes").innerHTML = oResponse.responseText;
				$('Answer').innerHTML = "<a href=javascript:clickVote(1," + PageID + ",'" + mk + "')>" + _VOTE_LINK + "</a>";
			}
		};

		var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, params);
	}	
	
			
	
	var MaxRating = 5;
	var clearRatingTimer = "";
	var voted_new = new Array();
	
	var id=0;
	var last_id = 0;
	
	function clickVoteStars(TheVote,PageID,mk,id,action){
		voted_new[id] = TheVote
		if(action==3)rsfun="wfVoteStars";
		if(action==5)rsfun="wfVoteStarsMulti";

		var url = "index.php?action=ajax";
		var pars = 'rs=' + rsfun + '&rsargs[]=' + TheVote + '&rsargs[]=' + PageID+'&rsargs[]=' + mk
		var callback = {
			success: function( oResponse ) {
				$('rating_'+id).innerHTML = oResponse.responseText;
			}
		};
		var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);
	}	
	
	function unVoteStars(PageID,mk,id){
		var url = "index.php?action=ajax";
		var pars = 'rs=wfVoteStarsDelete&rsargs[]=' + PageID + '&rsargs[]=' + mk;
		var callback = {
			success: function( oResponse ) {
				$('rating_'+id).innerHTML = oResponse.responseText;
			}
		};
		var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);
	}
	
	
	function startClearRating(id,rating,voted){clearRatingTimer = setTimeout("clearRating('" + id + "',0," + rating + "," + voted + ")", 200);}
	
	function clearRating(id,num,prev_rating,voted){
		if(voted_new[id])voted=voted_new[id];
		
		for (var x=1;x<=MaxRating;x++) {     
			if(voted){
				star_on = "voted";
				old_rating = voted;
			}else{	
				star_on = "on";
				old_rating = prev_rating;
			}
			if(!num && old_rating >= x){
				$("rating_" + id + "_" + x).src = "/images/common/star_" + star_on + ".gif";
			}else{
				$("rating_" + id + "_" + x).src = "/images/common/star_off.gif";
			}
		}
	}
	
	function updateRating(id,num,prev_rating) {
		if(clearRatingTimer && last_id==id)clearTimeout(clearRatingTimer);
		clearRating(id,num,prev_rating)
		for (var x=1;x<=num;x++) {
			$("rating_" + id + "_" + x).src = "/images/common/star_voted.gif";
		}
		last_id = id;
	}
