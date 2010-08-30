/**
 * This file allows JS to include .scss files dynamically, using the current color-settings.
 */
function wfGetSassUrl(fileName){
	// Make sure that the filename doesn't start with a slash.
	if(fileName.substring(0, 1) == "/"){
		fileName = fileName.substring(1);
	}

	wgCdnRootUrl = (wgCdnRootUrl?wgCdnRootUrl:"");
	url = wgCdnRootUrl + "/__sass/" + fileName + "/" + wgStyleVersion + "/" + sassHash + "/" + sassParams;

	return url;
}
