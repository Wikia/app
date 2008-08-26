var itemMax;
var timestamp = 0;
var edits = 1;
var comments = 1;
var votes = 1;
var play = 1;
var items = new Array(0);
var reload = 0;

var edits_count = 0;
var votes_count = 0;
var comments_count = 0;

var largest_value = 0;

function start_scout() {getItems();}


function togglePlay() {
	play = ((play)?0:1);
	if(play){
		$("off").src = "http://www.armchairgm.com/mwiki/brand/pause_down.gif";
		$("on").src = "http://www.armchairgm.com/mwiki/brand/play_up.gif";
	}else{
		$("on").src = "http://www.armchairgm.com/mwiki/brand/play_down.gif";
		$("off").src = "http://www.armchairgm.com/mwiki/brand/pause_up.gif";
	}
}       

function toggleEdits() {edits = ((edits)?0:1);updateAll()}    
function toggleVotes() {votes = ((votes)?0:1);updateAll()}    
function toggleComments() {comments = ((comments)?0:1);updateAll()}    
                 
function getItems() {
        var url = "index.php?title=Special:SiteScoutUpdate";
        var querystring = "edits=" + edits + "&votes=" + votes + "&comments=" + comments + "&timestamp=" + timestamp + "&rnd=" + Math.random();
	var myAjax = null;
        myAjax = new Ajax.Request(
       	url,
        	{
             	method: 'get',
                asynchronous: true,
                parameters: querystring,
                onComplete: processItems
		});
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
        Element.setOpacity('comment-1', 0.0);
        for (i = (itemMax - 1); i >= 1; i--) {
	        cell = document.getElementById("comment-" + i);
	        cellnext = document.getElementById("comment-" + (i + 1));
	        if (cell.innerHTML != "") {
	        	cellnext.innerHTML = cell.innerHTML;
	        }
        }
        document.getElementById("comment-1").innerHTML = text;
        Effect.Appear('comment-1', { duration: 1.5 });
        if (items.length > 0) {
			setTimeout("push()", 2000);
        }else {
			setTimeout("getItems()", 5000);
        }
}

function updateAll(){
	timestamp = 0;
	reload = 1;
  	var url = "index.php?title=Special:SiteScoutUpdate";
    	var querystring = "edits=" + edits + "&votes=" + votes + "&comments=" + comments + "&timestamp=" + timestamp + "&rnd=" + Math.random();
	sXMLHTTP = XMLHttp();
	sXMLHTTP.open("GET",url + "?" + querystring, false );
	sXMLHTTP.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	sXMLHTTP.send(null);
	processItems(sXMLHTTP);
	for (x = 0; x <= itemMax; x++) {
		var itemtemp
		itemtemp = items[x];
		document.getElementById("comment-" + (x+1)).innerHTML = displayLine(itemtemp);
		if(x==0)timestamp = items[x].timestamp;
	}
	reload = 0;
	getItems()
}


function displayLine(item){
		if(!reload)updateStat(item.type)
		comment = item.comment
		if(item.type=="comment")comment="<a href=" + item.url + "#" + item.item_id + ">" + comment + "</a>"
		text= "<div class=site-scout>"
		text+=	"<span class=item-info>"
		+		"<img src=images/" + item.type_icon + " border='0'>"
		+			((item.is_new==1)?"<br><span class=edit-new>new</span>":((item.is_minor==1)?"<br><span class=edit-minor>minor</span>":""))
		+	"</span>"
		+	"<a href=" + item.url + " class=item-title>"
		+		item.title
		+	"</a>"
		//+	"<span class=item-time>"
		//+		item.date
		//+	"</span>"
		+	"<span class=item-comment>"
		+		((comment)?comment:"-")
		+	"</span>"
		+	"<span class=item-user>"
		+	"<a href='" +item.user_page + "' class=item-user-link>"
		+		"<img src=images/avatars/" + item.avatar + " border='0'> "
		+		item.username
		+	"</a>"
		+	"<a href='" + item.user_talkpage + "' class=item-user-talk><img src=images/commentIcon.gif border=0 hspace=3 align=middle></a>"
		+	"</span>"
		+	"</div>";
		return text
}

function setLargestValue(){
	if(edits_count>largest_value)largest_value=edits_count;
	if(comments_count>largest_value)largest_value=comments_count;
	if(votes_count>largest_value)largest_value=votes_count;
}

function updateStat(stat){
	eval(stat + "s_count=" + stat + "s_count+1;")
	setLargestValue();
	updateStatChart();
}

function updateStatChart(){
	$("edit_stats").innerHTML = "<table><tr><td><table bgcolor=\"#285C98\"  height=7 width=\"" + (edits_count / largest_value * 300) + "\"><tr><td></td></tr></table></td><td>" +  edits_count  + "</td></tr></table>";
	$("vote_stats").innerHTML = "<table><tr><td><table bgcolor=\"#009900\"  height=7 width=\"" + (votes_count / largest_value * 300) + "\"><tr><td></td></tr></table></td><td>" + votes_count + "</td></tr></table>";
	$("comment_stats").innerHTML = "<table><tr><td><table bgcolor=\"#990000\"  height=7 width=\"" + (comments_count / largest_value * 300) + "\"><tr><td></td></tr></table></td><td>" + comments_count + "</td></tr></table>";
	
}