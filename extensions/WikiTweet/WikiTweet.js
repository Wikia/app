if(!alreadydeclared)
{
	var alreadydeclared = true;
	var g__timer = {};
	var g__cycle = true;
	function gettweets(i__uniqueid) {
		var l__size = $(".status_update_form[uniqueid="+i__uniqueid+"] input[name=size]").val();
		var l__rows = $(".status_update_form[uniqueid="+i__uniqueid+"] input[name=rows]").val();
		var l__room = $(".status_update_form[uniqueid="+i__uniqueid+"] input[name=room]").val();
		var l__user = $(".status_update_form[uniqueid="+i__uniqueid+"] input[name=user]").val();
		var l__bstatus = $(".status_update_form[uniqueid="+i__uniqueid+"] input[name=alertslevel]").val();
		$(".status_update_form[uniqueid="+i__uniqueid+"] .img_loader").css("display","inline");
		var l__query = wgScriptPath+"/api.php?action=query&format=json&list=wikitweet&wtwreq=get&wtwrows="+l__rows+"&wtwroom="+l__room+"&wtwuser="+l__user+"&wtwsize="+l__size+"&wtwbstatus="+l__bstatus;
		$.getJSON(l__query,
			function(data) {
				$.each(data.query.wikitweet, function(i,item){
					$(".status_update_form[uniqueid="+i__uniqueid+"] .img_loader").css("display","none");
					if(g__cycle==true){
						$("#lasttweets_"+i__uniqueid).html(item);
					}
					if (g__timer['_'+i__uniqueid]) clearTimeout(g__timer['_'+i__uniqueid]);
					g__timer['_'+i__uniqueid] = setTimeout('gettweets("'+i__uniqueid+'")', refreshTime);
				});
			}
		);
	}
	function gettweets_with_tag(i__uniqueid, i__tag) {
		var l__size = $(".status_update_form[uniqueid="+i__uniqueid+"] input[name=size]").val();
		var l__rows = $(".status_update_form[uniqueid="+i__uniqueid+"] input[name=rows]").val();
		var l__room = $(".status_update_form[uniqueid="+i__uniqueid+"] input[name=room]").val();
		var l__user = $(".status_update_form[uniqueid="+i__uniqueid+"] input[name=user]").val();
		$(".status_update_form[uniqueid="+i__uniqueid+"] .img_loader").css("display","inline");
		$.getJSON(wgScriptPath+"/api.php?action=query&format=json&list=wikitweet&wtwreq=get&wtwrows="+l__rows+"&wtwroom="+l__room+"&wtwuser="+l__user+"&wtwsize="+l__size+"&wtwtag="+i__tag,
			function(data) {
				$.each(data.query.wikitweet, function(i,item){
					$(".status_update_form[uniqueid="+i__uniqueid+"] .img_loader").css("display","none");
					$("#lasttweets_"+i__uniqueid).html(item);
					if (g__timer) clearTimeout(g__timer);
				});
			}
		);
	}
	function gettweets_from_room(i__uniqueid, i__room) {
		var l__size = $(".status_update_form[uniqueid="+i__uniqueid+"] input[name=size]").val();
		var l__rows = $(".status_update_form[uniqueid="+i__uniqueid+"] input[name=rows]").val();
		var l__room = $(".status_update_form[uniqueid="+i__uniqueid+"] input[name=room]").val();
		var l__user = $(".status_update_form[uniqueid="+i__uniqueid+"] input[name=user]").val();
		$(".status_update_form[uniqueid="+i__uniqueid+"] .img_loader").css("display","inline");
		$.getJSON(wgScriptPath+"/api.php?action=query&format=json&list=wikitweet&wtwreq=get&wtwrows="+l__rows+"&wtwroom="+l__room+"&wtwuser="+l__user+"&wtwsize="+l__size+"&wtwother_room="+i__room,
			function(data) {
				$.each(data.query.wikitweet, function(i,item){
					$(".status_update_form[uniqueid="+i__uniqueid+"] .img_loader").css("display","none");
					$("#lasttweets_"+i__uniqueid).html(item);
					if (g__timer) clearTimeout(g__timer);
				});
			}
		);
	}
	function updatetweet(i__uniqueid, i__mail, i__userused){
		var l__status  = escape( $(".status_update_form[uniqueid="+i__uniqueid+"] textarea[name=status]").val() ) ;
		var l__room    = escape( $(".status_update_form[uniqueid="+i__uniqueid+"] input[name=room]").val()      ) ;
		var l__bstatus = escape( $(".status_update_form[uniqueid="+i__uniqueid+"] select[name=bstatus]").val()  ) ;
		$.getJSON(wgScriptPath+"/api.php?action=query&format=json&list=wikitweet&wtwreq=update&wtwstatus="+l__status+"&wtwuser="+i__userused+"&wtwroom="+l__room+"&wtwtomail="+i__mail+"&wtwbstatus="+l__bstatus,
			function(data) {
				$(".status_update_form[uniqueid="+i__uniqueid+"] textarea[name=status]").val("");
				$(".status_update_form[uniqueid="+i__uniqueid+"] .stringlength").html("<span>500</span>");
				gettweets(i__uniqueid);
			}
		);
	}

	$(document).ready(function() {
		$(".status_update_form textarea[name=status]").keyup(function(event) {
			event.stopPropagation();
			var l__uniqueid = $(this).parents('.status_update_form').attr('uniqueid');
			len = $(".status_update_form[uniqueid="+l__uniqueid+"] textarea[name=status]").val().length;
			addcolor = "";
			if (len >= 500){
				addcolor = " style='color:red;' ";
			}
			len2 = 500-len;
			$(".status_update_form[uniqueid="+l__uniqueid+"] .stringlength").html("<span"+addcolor+">"+len2+"</span>");
			if ($(".status_update_form[uniqueid="+l__uniqueid+"] textarea[name=status]").val().indexOf("@") != -1){
				//status contains @ character
				$(".status_update_form[uniqueid="+l__uniqueid+"] input[name=submitandmail]").css("display","inline");
				$(".status_update_form[uniqueid="+l__uniqueid+"] input[name=submitprivate]").css("display","inline");
			}
			else if($(".status_update_form[uniqueid="+l__uniqueid+"] input[name=submitandmail]").css("display")=="inline"){
				$(".status_update_form[uniqueid="+l__uniqueid+"] input[name=submitandmail]").css("display","none");
				$(".status_update_form[uniqueid="+l__uniqueid+"] input[name=submitprivate]").css("display","none");
			}
	
		});
		function submit(i__uniqueid, mail, userused){
			if(userused == ''){
				userused = $(".status_update_form[uniqueid="+i__uniqueid+"] input[name=user]").val();
			}
			$(".status_update_form[uniqueid="+i__uniqueid+"] input[name=submitandmail]").css("display","none");
			$(".status_update_form[uniqueid="+i__uniqueid+"] input[name=submitprivate]").css("display","none");
			len = $(".status_update_form[uniqueid="+i__uniqueid+"] textarea[name=status]").val().length;
			if (len > 500){
				alert('Reduce your message to 500 characters max.');
			}
			else if (len == 0){
				gettweets(i__uniqueid);
			}
			else {
				updatetweet(i__uniqueid, mail, userused);
			}
		}



		$(".status_update_form input[name=submit]").click(function() {
			submit($(this).parents('.status_update_form').attr('uniqueid'),0,'');
		});
		$(".status_update_form input[name=submitandmail]").click(function() {
			submit($(this).parents('.status_update_form').attr('uniqueid'),1,'');
		});
		$(".status_update_form input[name=submitbyinformer]").click(function() {
			submit($(this).parents('.status_update_form').attr('uniqueid'),0,InformerUser);
		});
		$(".status_update_form input[name=submitanonymously]").click(function() {
			submit($(this).parents('.status_update_form').attr('uniqueid'),0,AnonymousUser);
		});
		$(".status_update_form input[name=submitprivate]").click(function() {
			submit($(this).parents('.status_update_form').attr('uniqueid'),2,'');
		});
		$(".room_subscribe").click(function() {
			l__uniqueid = $(this).attr('uniqueid');
			$("#tempimg_"+l__uniqueid).html('<img src="'+wgScriptPath+'/extensions/WikiTweet/images/ajax-loader-mini.gif" style ="padding: 0 5px 0 5px;"/>waiting...');
			var i__link = $(".status_update_form[uniqueid="+l__uniqueid+"] input[name=room]").val();
			var i__user = $(".status_update_form[uniqueid="+l__uniqueid+"] input[name=user]").val();
			$.getJSON(wgScriptPath+"/api.php?action=query&format=json&list=wikitweet&wtwreq=subscribe&wtwlink="+i__link+"&wtwuser="+i__user+"&wtwtype=room",
				function(data) {
					$("#tempimg_"+l__uniqueid).html("");
					$(".room_subscribe[uniqueid="+l__uniqueid+"]").css("display", "none");
					$(".room_unsubscribe[uniqueid="+l__uniqueid+"]").css("display", "inline");
				}
			);
		});
		$(".room_unsubscribe").click(function() {
			l__uniqueid = $(this).attr('uniqueid');
			$("#tempimg_"+l__uniqueid).html('<img src="'+wgScriptPath+'/extensions/WikiTweet/images/ajax-loader-mini.gif" style ="padding: 0 5px 0 5px;"/>waiting...');
			var i__link = $(".status_update_form[uniqueid="+l__uniqueid+"] input[name=room]").val();
			var i__user = $(".status_update_form[uniqueid="+l__uniqueid+"] input[name=user]").val();
			$.getJSON(wgScriptPath+"/api.php?action=query&format=json&list=wikitweet&wtwreq=unsubscribe&wtwlink="+i__link+"&wtwuser="+i__user+"&wtwtype=room",
				function(data) {
					$("#tempimg_"+l__uniqueid).html("");
					$(".room_subscribe[uniqueid="+l__uniqueid+"]").css("display", "inline");
					$(".room_unsubscribe[uniqueid="+l__uniqueid+"]").css("display", "none");
				}
			);
		});

	});
}
