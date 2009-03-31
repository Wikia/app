var CodeReview = new Object;
CodeReview.loadDiff = function(repo, rev) {
	var path = wgScriptPath +
		"/api.php" +
		"?action=codediff" +
		"&format=json" +
		"&repo=" + encodeURIComponent(repo) +
		"&rev=" + encodeURIComponent(rev);
	var xmlhttp = sajax_init_object();
	if(xmlhttp){
		try {
			injectSpinner(CodeReview.diffTarget(), 'codereview-diff');
			xmlhttp.open("GET", path, true);
			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4) {	        		
					CodeReview.decodeAndShowDiff(xmlhttp.responseText);
					removeSpinner('codereview-diff');
				}
			};
			xmlhttp.send(null);     	
		} catch (e) {
			if (window.location.hostname == "localhost") {
				alert("Your browser blocks XMLHttpRequest to 'localhost', try using a real hostname for development/testing.");
			}
			throw e;
		}
	}
};
CodeReview.decodeAndShowDiff = function(jsonText) {
	// bleah
	eval("var data=" + jsonText);
	if (typeof data.code != 'undefined' &&
		typeof data.code.rev != 'undefined' &&
		typeof data.code.rev.diff != 'undefined') {
		CodeReview.showDiff(data.code.rev.diff);
	} else {
		CodeReview.showDiff('Diff load failed. :(');
	}
};
CodeReview.diffTarget = function() {
	return document.getElementById('mw-codereview-diff');
};
CodeReview.showDiff = function(diffHtml) {
	CodeReview.diffTarget().innerHTML = diffHtml;
};
