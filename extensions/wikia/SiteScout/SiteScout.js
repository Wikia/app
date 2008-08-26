var itemMax;
var timestamp = 0;
var scout_edits = 1;
var scout_comments = 1;
var scout_votes = 1;
var networkupdates = 1;
var play = 1;
var items = new Array(0);
var reload = 0;

var edits_count = 0;
var votes_count = 0;
var comments_count = 0;
var networkupdates_count = 0;

var largest_value = 0;

function start_scout() {getItems();}

                 
function getItems() {
	var url = wgServer + "/index.php?title=Special:SiteScoutUpdate";
        var querystring = "&edits=" + scout_edits + "&votes=" + scout_votes + "&comments=" + scout_comments + "&networkupdates=" + networkupdates + "&timestamp=" + timestamp + "&rnd=" + Math.random();
	var callback = {
		success: function(r){
			processItems(r);
		}
	};
	var request = YAHOO.util.Connect.asyncRequest('GET', url+querystring, callback, null);

}

function processItems(request) {
        try {
			var itemsXML;
			var item;
			itemsXML = request.responseXML.getElementsByTagName("items")[0];
			item = itemsXML.getElementsByTagName("item");
        }catch (e) {
			if(!reload){
				setTimeout("getItems()", 10000);
			}
			return;
        }
        for (i = 0; i < item.length; i++) {
			items[i] = { 
				type: item[i].getElementsByTagName("type")[0].firstChild.nodeValue,
				type_icon: item[i].getElementsByTagName("type_icon")[0].firstChild.nodeValue,
				date: item[i].getElementsByTagName("date")[0].firstChild.nodeValue,
				timestamp: item[i].getElementsByTagName("timestamp")[0].firstChild.nodeValue,
				title: item[i].getElementsByTagName("title")[0].firstChild.nodeValue,
				url: item[i].getElementsByTagName("url")[0].firstChild.nodeValue,
				comment: item[i].getElementsByTagName("comment")[0].firstChild.nodeValue,
				username: item[i].getElementsByTagName("user")[0].firstChild.nodeValue,
				user_page: item[i].getElementsByTagName("user_page")[0].firstChild.nodeValue,
				user_talkpage: item[i].getElementsByTagName("user_talkpage")[0].firstChild.nodeValue,
				avatar: item[i].getElementsByTagName("avatar")[0].firstChild.nodeValue,
				is_new: item[i].getElementsByTagName("edit_new")[0].firstChild.nodeValue,
				is_minor: item[i].getElementsByTagName("edit_minor")[0].firstChild.nodeValue,
				item_id: item[i].getElementsByTagName("id")[0].firstChild.nodeValue
			}
			if(i==0)timestamp = items[i].timestamp; 
        }  
		if(!reload){    
        	push();
		}
			
}

function push() {
        if (play == 0) {
			setTimeout("push()", 1000);
            return;
        }
        var cell;
        var cellnext;
        var text;
        var style = "";
        var item = items.pop();
	text = displayLine(item)
	
	YAHOO.util.Dom.setStyle('comment-1', 'opacity', 0.0);
        for (i = (itemMax - 1); i >= 1; i--) {
	        cell = document.getElementById("comment-" + i);
	        cellnext = document.getElementById("comment-" + (i + 1));
	        if (cell.innerHTML != "") {
	        	cellnext.innerHTML = cell.innerHTML;
	        }
        }
	new YAHOO.widget.Effects.Appear( ('comment-1'));
        document.getElementById("comment-1").innerHTML = text;
       
        if (items.length > 0) {
			setTimeout("push()", 2000);
        }else {
			setTimeout("getItems()", 5000);
        }
}


function displayLine(item){
		if(!reload)updateStat(item.type)
		comment = item.comment
		if(item.type=="comment")comment="<a href=" + item.url + "#" + item.item_id + ">" + comment + "</a>"
		text= "<div class=site-scout>"
		text+=	"<span class=item-info>"
		+		"<img src='http://images.wikia.com/common/wikiany/images/" + item.type_icon + "' border='0'>"
		+			((item.is_new==1)?"<br><span class=edit-new>" + _NEW + "</span>":((item.is_minor==1)?"<br><span class=edit-minor>" + _MINOR + "</span>":""))
		+	"</span>"
		+	"<a href=" + item.url + " class=item-title>"
		+		item.title
		+	"</a>"

		+	"<span class=item-comment>"
		+		((comment)?comment:"-")
		+	"</span>"
		+	"<span class=item-user>"
		+	"<a href='" +item.user_page + "' class=item-user-link>"
		+		"<img src='" + wgUploadPath + "/avatars/" + item.avatar + "' border='0'> "
		+		item.username
		+	"</a>"
		+	"<a href='" + item.user_talkpage + "' class=item-user-talk><img src='http://images.wikia.com/common/wikiany/images/talkPageIcon.png' border=0 hspace=3 align=middle></a>"
		+	"</span>"
		+	"</div>";
		return text
}

function setLargestValue(){
	if(edits_count>largest_value)largest_value=edits_count;
	if(comments_count>largest_value)largest_value=comments_count;
	if(votes_count>largest_value)largest_value=votes_count;
	if($("networkupdates_stats") && networkupdates_count>largest_value)largest_value=networkupdates_count;
}

function updateStat(stat){
	eval(stat + "s_count=" + stat + "s_count+1;")
	setLargestValue();
	updateStatChart();
}

function updateStatChart(){
	$("edit_stats").innerHTML = "<table><tr><td><table style=\"background-color:#285C98; height:7px;\" width=\"" + (edits_count / largest_value * 300) + "\"><tr><td></td></tr></table></td><td>" +  edits_count  + "</td></tr></table>";
	$("vote_stats").innerHTML = "<table><tr><td><table style=\"background-color:#009900; height:7px;\" width=\"" + (votes_count / largest_value * 300) + "\"><tr><td></td></tr></table></td><td>" + votes_count + "</td></tr></table>";
	$("comment_stats").innerHTML = "<table><tr><td><table style=\"background-color:#990000; height:7px;\" width=\"" + (comments_count / largest_value * 300) + "\"><tr><td></td></tr></table></td><td>" + comments_count + "</td></tr></table>";
	if($("networkupdates_stats"))$("networkupdates_stats").innerHTML = "<table><tr><td><table style=\"background-color:#FFFCA9; height:7px;\" width=\"" + (networkupdates_count / largest_value * 300) + "\"><tr><td></td></tr></table></td><td>" + networkupdates_count + "</td></tr></table>";
	
}

function XMLHttp(){
	if (window.XMLHttpRequest){ //Moz
		var xt = new XMLHttpRequest();
	}else{ //IE
		var xt = new ActiveXObject('Microsoft.XMLHTTP');
	}
	return xt
}