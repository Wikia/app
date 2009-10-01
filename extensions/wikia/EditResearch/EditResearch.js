var wikipedia_server = "http://" + wgContentLanguage + ".wikipedia.org"
var research_page = 0;
var research_page_limit = 10;
var current_title = "";

jQuery("#research_box").ready(function() {
	jQuery("#research_box").mouseup(function() {
		var sel = getSelection()
		if(sel){
			insertTags("","", sel);

			if( document.getElementById("wpTextbox1").value.indexOf("{{wikipedia|" + current_title + "}}") == -1 ){
				document.getElementById("wpTextbox1").value = document.getElementById("wpTextbox1").value + "\n{{wikipedia|" + current_title + "}}";
			}
		}
	});
	jQuery("#search_input").keydown(function(e) {
		if (e.keyCode == 13) {
			WET.byStr( 'editpage/wikipedia/enter' );			
			research();
			return false;
		}
	});
});

jQuery("#firstHeading").ready(function() {
	jQuery("#firstHeading").mouseup(function() {
		var sel = getSelection();
		if(sel){
			document.getElementById("search_input").value = sel;
			document.getElementById("search_input").focus();
			research();
		}
	});
});

function getSelection(){
	var sel = "";
	if(document.getSelection) {
		sel = document.getSelection();
	} else if(document.selection) {
		sel = document.selection.createRange().text;
	} else if(window.getSelection) {
		sel = window.getSelection();
	}
	return sel;
}

function research(){
	var search = document.getElementById("search_input").value;
	if( !search ) {
		return;
	}
	jQuery("#research_box").css("overflow", "");
	jQuery("#research-inner").css("background-color", "#FFF").css("background-image", "none");
	url = wikipedia_server + "/w/api.php?action=query&list=search&srsearch=" + encodeURIComponent(search) + "&sroffset=" + (research_page * research_page_limit) + "&format=json&callback=?";
	jQuery.getJSON( url, "", function( data ){

		if( data.query ){
			var search_html = ""
			for(x=0; x<=data.query.search.length-1;x++){
				title = data.query.search[x].title;
				search_html += "<div class='research-search-result'><a href='#research-search' onclick='research_wikipedia_article(this)'>" + title + "</a></div>";
			}
			if( search_html ){
				search_html += "<div id='research-search-nav'>" + ((research_page>0)?"<a href=javascript:research_paginate(-1)>" + wgPrevMsg + "</a>":"") + " <a href=javascript:research_paginate(1)>" + wgNextMsg + "</a></div>";
			}else{
				search_html = wgNoResultsMsg;
			}
			document.getElementById("research_box").innerHTML = search_html;
		}
	} );
}

function research_paginate(dir){
	if( dir > 0 ) {
		WET.byStr( 'editpage/wikipedia/next' );
	} else if ( dir < 0 ) {
		WET.byStr( 'editpage/wikipedia/previous' );
	}
	research_page = research_page + dir;
	research();
}

function research_wikipedia_article(node) {

	var article = jQuery(node).html().replace(/\s/g, '_');

	injectSpinner( document.getElementById("research_box"), "wikipedia");

	//sometimes Wikipedia links have a hash to point to a section...need to strip that out for the API
	article = article.replace(/#.*/g,"");

	//save for attribution
	current_title = article;

	document.getElementById("research_box").innerHTML = "";
	document.getElementById("research_box").style.overflow = "";

	var url = wikipedia_server + "/w/api.php?action=parse&page=" + encodeURIComponent(article) + "&format=json&callback=?";

	jQuery.getJSON( url, "", function( data ){
		html = data.parse.text["*"];

		//replace all the wiki links so they point to this function
		//<a href=\"\/wiki\/Eli_Manning\"
		html = html.replace(/<a\shref=\"(\/wiki\/(.*?))\".*?>(.*?)<\/a>/g,"<a href='#research-search' onclick='research_wikipedia_article(this)'>$3</a>" );

		//we should also remove red links and edit links
		html = html.replace(/<a\shref=\"(\/w\/index\.php\?title=(.*?)&.*?)\".*?>(.*?)<\/a>/g,"$3" );

		removeSpinner("wikipedia");

		document.getElementById("research_box").style.overflow="scroll";
		document.getElementById("research_box").innerHTML = html;
	});
}
