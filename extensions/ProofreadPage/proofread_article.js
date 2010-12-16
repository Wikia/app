// Author : ThomasV - License : GPL

/* add backlink to index page*/
function pr_add_source() {
	var a = document.getElementById("ca-nstab-main"); 
	if(!a) return;
	var q = document.getElementById("pr_index")
	if( q ) {
		href = q.firstChild; 
		if(!href) return;
		q.removeChild(href);
		href.innerHTML = "<span>"+prp_source+"</span>";
		href.setAttribute("title", prp_source_message);
		var new_li = document.createElement("li");
		new_li.appendChild(href); 
		a.parentNode.insertBefore(new_li,a.nextSibling);
	}
}
addOnloadHook(pr_add_source);
