$('.tweet_li').mouseover(function() {
	$(this).css("border-left","3px solid #BBB");
}).mouseout(function(){
	$(this).css("border-left","3px solid #FFF");
});
$(".user_subscribe").click(function() {
	var l__uniqueid = $(this).parents('.lasttweets').attr('uniqueid');
	$("#tempimg2",this).html('<img src="'+wgScriptPath+'/extensions/WikiTweet/images/ajax-loader-mini.gif" style ="padding: 0 5px 0 5px;"/>waiting...');
	var i__link = $("span",this).html();
	var i__user = $(".status_update_form[uniqueid="+l__uniqueid+"] input[name=user]").val();
	$.getJSON(wgScriptPath+"/api.php?action=query&format=json&list=wikitweet&wtwreq=subscribe&wtwlink="+i__link+"&wtwuser="+i__user+"&wtwtype=user",
		function(data) {
			$("#tempimg2").html("");
			$.each(data.query.wikitweet, function(i,item){
				$(".subscribe"+item).css("display", "none");
				$(".unsubscribe"+item).css("display", "inline");
			});
		}
	);
});
$(".user_unsubscribe").click(function() {
	var l__uniqueid = $(this).parents('.lasttweets').attr('uniqueid');
	$("#tempimg2",this).html('<img src="'+wgScriptPath+'/extensions/WikiTweet/images/ajax-loader-mini.gif" style ="padding: 0 5px 0 5px;"/>waiting...');
	var i__link = $("span",this).html();
	var i__user = $(".status_update_form[uniqueid="+l__uniqueid+"] input[name=user]").val();
	$.getJSON(wgScriptPath+"/api.php?action=query&format=json&list=wikitweet&wtwreq=unsubscribe&wtwlink="+i__link+"&wtwuser="+i__user+"&wtwtype=user",
		function(data) {
			$("#tempimg2").html("");
			$.each(data.query.wikitweet, function(i,item){
				$(".unsubscribe"+item).css("display", "none");
				$(".subscribe"+item).css("display", "inline");
			});
		}
	);
});
$(".delete_tweet").click(function() {
	var l__uniqueid = $(this).parents('.lasttweets').attr('uniqueid');
	var i__id = $("span",this).html();
	$.getJSON(wgScriptPath+"/api.php?action=query&format=json&list=wikitweet&wtwreq=delete&wtwid="+i__id,
		function(data) {
			gettweets(l__uniqueid);
		}
	);
});
$(".tresolve").click(function() {
	var l__uniqueid = $(this).parents('.lasttweets').attr('uniqueid');
	var l__id = $(this).attr('tweetid');
	$.getJSON(wgScriptPath+"/api.php?action=query&format=json&list=wikitweet&wtwreq=resolve&wtwid="+l__id,
		function(data) {
			gettweets(l__uniqueid);
		}
	);
});
$(".answer").mouseover(function(){
	$(this).css("text-decoration","underline");
}).mouseout(function(){
	$(this).css("text-decoration","");

});
$(".answer").click(function(){
	$('textarea#status').val($('textarea#status').val()+'@'+$(this).parents('.tweet_li').attr('user')+' ');
	$('textarea#status').focus();
});
$(".tag").click(function(){
	var l__uniqueid = $(this).parents('.lasttweets').attr('uniqueid');
	gettweets_with_tag(l__uniqueid, $(this).attr('value'));
});
$(".room").click(function(){
	var l__uniqueid = $(this).parents('.lasttweets').attr('uniqueid');
	gettweets_from_room(l__uniqueid, $(this).attr('value'));
});
$(".timeline").click(function(){
	var l__uniqueid = $(this).parents('.lasttweets').attr('uniqueid');
	gettweets(l__uniqueid);
});


$(".spancomment").click(function(){
	var parent_id = $(this).attr('parent_id');
	// popup(parent_id);
	$('.childssharezone[parent_id='+parent_id+']').show();
	$('textarea[parent_id='+parent_id+']').focus();
	g__cycle = false;
});
$('textarea[name=childscomment]').focusout(function() {
	var parent_id = $(this).attr('parent_id');
	$('.childssharezone[parent_id='+parent_id+']').fadeOut(300);
	g__cycle = true;
});
$('.childsharer').click(function(){
	var l__parent_id = $(this).attr('parent_id');
	var l__status  = $('textarea[parent_id='+l__parent_id+']').val();
	var l__uniqueid = $(this).parents('.lasttweets').attr('uniqueid');
	var l__room    = escape( $(".status_update_form[uniqueid="+l__uniqueid+"] input[name=room]").val()      ) ;
	var l__bstatus = '1' ;
	var l__userused = $(".status_update_form[uniqueid="+l__uniqueid+"] input[name=user]").val();

	len = l__status.length;
	if (len > 500){
		popup('Reduce your message to 500 characters max.'+len+l__status);
	}
	else if (len > 0){
		$.getJSON(wgScriptPath+"/api.php?action=query&format=json&list=wikitweet&wtwreq=update&wtwstatus="+l__status+"&wtwuser="+l__userused+"&wtwroom="+l__room+"&wtwtomail=0&wtwbstatus="+l__bstatus+"&wtwparentid="+l__parent_id,
			function(data) {
				$('textarea[parent_id='+l__parent_id+']').val("");
				gettweets(l__uniqueid);
			}
		);
	}	
});