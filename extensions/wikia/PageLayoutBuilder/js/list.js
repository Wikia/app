window.PageLayoutBuilder = window.PageLayoutBuilder || {};


PageLayoutBuilder.list = {};


PageLayoutBuilder.list.doAction = function(e, action) {
	var val = parseInt(String($(e.target).attr("href")).replace("#plbId-",""));
	if((typeof val) == "number" ) {
		switch(action) {
			case "delete":
				if(confirm(plb_list_confirm_delete)) {
					PageLayoutBuilder.list.postAction(val, action);
				}
			break;
			case "publish":
				if(confirm(plb_list_confirm_publish)) {
					PageLayoutBuilder.list.postAction(val, action);
				}
			break;
		}
		return false;
	} else {
		return false;
	}
}

PageLayoutBuilder.list.postAction = function(id, action) {
	$("#PLBActionForm #plbId").val(id);
	$("#PLBActionForm #subaction").val(action);
	$("#PLBActionForm").submit();
}


PageLayoutBuilder.list.initList = function() {
	var links = $('.PLBActionLink');
	links.filter(".publish").click(function(e) {
		PageLayoutBuilder.list.doAction(e, "publish");
	});
	
	links.filter(".delete").click(function(e) {
		PageLayoutBuilder.list.doAction(e, "delete");
	});
	
	var button = $("#plbNewButton").clone().attr("id", "").css("margin-left", "100px");
	$("#WikiaPageHeader h1").append(button);
}


$(PageLayoutBuilder.list.initList);