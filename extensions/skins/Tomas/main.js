function xhr() {
	var httpRequest;
	if (window.XMLHttpRequest) { // Mozilla, Safari, ...
		httpRequest = new XMLHttpRequest();
	} else if (window.ActiveXObject) { // IE
		httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
	}
	return httpRequest;
}

function story(s) {
	var httpRequest = xhr();
	if ( !httpRequest ) {
		return;
	}
	var url = "story.php?s=" + s;
	var storyContent = document.getElementById( 'storycontent' );
	storyContent.innerHTML = '<tr><td align="center"><img src="images/spinner.gif"/></td></tr>';
	httpRequest.onreadystatechange = function() {
		if (httpRequest.readyState != 4) {
			return;
		}
		var storyBox = document.getElementById( 'storybox' );
		if (httpRequest.status != 200) {
			storyBox.innerHTML = '<tr><td align="center">Error loading story</td></tr>';
		} else {
			storyBox.innerHTML = httpRequest.responseText;
		}
	}
	httpRequest.open( 'GET', url, true );
	httpRequest.send(null);
}

function tab(baseId, newIndex) {
	if ( !document.getElementById ) {
		return;
	}
	var header = document.getElementById( baseId );
	header.style.display = 'inline';
	
	for ( i = 0; i < 10; i++ ) {
		var anchor = document.getElementById(baseId + '-a-' + i);
		var pane = document.getElementById(baseId + '-pane-' + i);
		if ( !anchor || !pane ) {
			break;
		}
		if ( i == newIndex ) {
			anchor.className = 'active';
			anchor.href = 'javascript:;';
			pane.style.display = 'block';
		} else {
			anchor.className = '';
			anchor.href = 'javascript:tab("' + baseId + '", ' + i + ')';
			pane.style.display = 'none';
		}
	}
}




