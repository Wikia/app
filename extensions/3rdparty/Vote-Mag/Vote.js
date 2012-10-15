	function clickVote(TheVote,PageID,mk){
		var url = "index.php?title=Special:VoteAction&Action=1";
		var pars = 'TheVote=' + TheVote + '&pid=' + PageID+'&mk=' + mk
		var myAjax = new Ajax.Updater(
			'PollVotes', url, {
				method: 'post', 
				parameters: pars,
				onSuccess: function(originalRequest) {
					$('Answer').innerHTML = "<a href=javascript:unVote(" + PageID + ",'" + mk + "')>unvote</a>";
			}
		});
	}	
	
	
	function unVote(PageID,mk){
		var url = "index.php?title=Special:VoteAction&Action=2";
		var pars = 'pid=' + PageID + '&mk=' + mk;
		var myAjax = new Ajax.Updater(
			'PollVotes', url, {
				method: 'post', 
				parameters: pars,
				onSuccess: function() {
					$('Answer').innerHTML = "<a href=javascript:clickVote(1," + PageID + ",'" + mk + "')>vote</a>";
			}
		});
	}	
	
	var MaxRating = 5;
	var clearRatingTimer = "";
	
	function clickVoteStars(TheVote,PageID,mk){
		var url = "index.php?title=Special:VoteAction&Action=3";
		var pars = 'TheVote=' + TheVote + '&pid=' + PageID+'&mk=' + mk
		var myAjax = new Ajax.Updater('rating', url, {method: 'post', parameters: pars});
	}	
	
	function unVoteStars(PageID,mk){
		var url = "index.php?title=Special:VoteAction&Action=4";
		var pars = 'pid=' + PageID + '&mk=' + mk;
		var myAjax = new Ajax.Updater('rating', url, {method: 'post', parameters: pars});
	}
	
	
	function startClearRating(){clearRatingTimer = setTimeout("clearRating()", 200);}
	
	function clearRating(){
		for (var x=1;x<=MaxRating;x++) {
			$("rating_" + x).src = "images/star_off.gif";
		}
	}
	function updateRating(num) {
		if(clearRatingTimer)clearTimeout(clearRatingTimer);
		clearRating()
		for (var x=1;x<=num;x++) {
			$("rating_" + x).src = "images/star_on.gif";
		}
	}
