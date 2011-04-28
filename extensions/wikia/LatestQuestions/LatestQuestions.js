$(window).load(function() {
    LatestQuestions.init();
});

var LatestQuestions = {
    init: function() {
        $.getScript(wgAnswersServer + wgAnswersScript + '?action=ajax&rs=moduleProxy&moduleName=LatestActivity&actionName=Index&outputType=data&callback=LatestQuestions.onLoad&uselang='+wgUserLanguage);
    },
    onLoad: function(data) {
	if(data.changeList.length > 0) {
            var html = "<section class='LatestQuestionsModule module'>";
	    html += "<h1 class='activity-heading'>"+wgLatestQuestionsHeader+"</h1>";
	    html += "<ul>";
            for(var i=0; i<data.changeList.length; i++) {
		html += "<li><img src='"+wgBlankImgUrl+"' class='sprite "+data.changeList[i].changeicon+"' height='20' width='20'><em>"+data.changeList[i].page_href+"</em><details>"+data.changeList[i].changemessage+"</details></li>";
            }
	    html += "</ul>";
	    html += "<a href='/wiki/Special:WikiActivity' title='Special:WikiActivity' class='more'>"+wgOasisMoreMsg+"</a>";
	    html += "</section>";
	    $("#WikiaRail").append(html).find("section.LatestQuestionsModule a").attr("href", function(i, val) {
                return wgAnswersServer + val;
            });
        }
    }
}
