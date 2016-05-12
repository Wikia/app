// Code provided by Lateral
(function(i) {
	try { var a = mw.config.get("wgArticleId"); }
	catch(e) { a = document.location.pathname.replace(/\/+$/,"").split("/").pop() }
	var b = RegExp("wikia_beacon_id=([A-Za-z0-9_-]{10})").exec(document.cookie);
	if (b) { i.src="https://assets.lateral.io/w.gif?beacon="+b[1]+"&aid="+a+"&ts="+Date.now(); }
})(new Image);
