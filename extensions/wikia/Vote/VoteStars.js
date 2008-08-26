		
	
	var MaxRating = 5;
	var clearRatingTimer = "";
	var voted_new = new Array();
	
	var id=0;
	var last_id = 0;
	
	function clickVoteStars(TheVote,PageID,mk,id,action){
		
		voted_new[id] = TheVote
		var url = "index.php?title=Special:VoteAction&Action="+action;
		var pars = 'TheVote=' + TheVote + '&pid=' + PageID+'&mk=' + mk
		var myAjax = new Ajax.Updater('rating_'+id, url, {method: 'post', parameters: pars});
	}	
	
	function unVoteStars(PageID,mk){
		var url = "index.php?title=Special:VoteAction&Action=6";
		var pars = 'pid=' + PageID + '&mk=' + mk;
		var myAjax = new Ajax.Updater('rating', url, {method: 'post', parameters: pars});
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
				$("rating_" + id + "_" + x).src = "images/star_" + star_on + ".gif";
			}else{
				$("rating_" + id + "_" + x).src = "images/star_off.gif";
			}
		}
	}
	
	function updateRating(id,num,prev_rating) {
		if(clearRatingTimer && last_id==id)clearTimeout(clearRatingTimer);
		clearRating(id,num,prev_rating)
		for (var x=1;x<=num;x++) {
			$("rating_" + id + "_" + x).src = "images/star_voted.gif";
		}
		last_id = id;
	}
