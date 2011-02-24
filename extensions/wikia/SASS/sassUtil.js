/**
 * This file allows JS to include .scss files dynamically, using the current color-settings.
 * allow extensions like ThemeDesigner to pass custom params
 */
function wfGetSassUrl(fileName, sassParams){
	// Make sure that the filename doesn't start with a slash.
	if(fileName.substring(0, 1) == "/"){
		fileName = fileName.substring(1);
	}

	wgCdnRootUrl = (typeof wgCdnRootUrl != 'undefined' ? wgCdnRootUrl : '');

	if (window.wgDontRewriteSassUrl) {
		var url = window.wgCdnRootUrl + '/sassServer.php?file=' + encodeURIComponent(fileName) +
			'&styleVersion=' + window.wgStyleVersion + '&hash=' + window.sassHash + '&' + (sassParams ? sassParams : window.sassParams);
	}
	else {
		var url = window.wgCdnRootUrl + '/__sass/' + fileName + '/' + window.wgStyleVersion + '/' + window.sassHash + '/' + (sassParams ? sassParams : window.sassParams);
	}

	return url;
}