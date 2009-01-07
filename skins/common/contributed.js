// http://www.wikia.com/wiki/User:Dantman/global.js
// RT#9031

function importScriptPage( page, server ) {
	var url = '/index.php?title=' + encodeURIComponent(page.replace(/ /g,'_')).replace('%2F','/').replace('%3A',':') + '&action=raw&ctype=text/javascript';
	if( typeof server == "string" ) {
		if( server.indexOf( '://' ) == -1 ) url = 'http://' + server + '.wikia.com' + url;
		else url = server + url;
	}
	return importScriptURI(url);
}

function importStylesheetPage( page, server ) {
	var url = '/index.php?title=' + encodeURIComponent(page.replace(/ /g,'_')).replace('%2F','/').replace('%3A',':') + '&action=raw&ctype=text/css';
	if( typeof server == "string" ) {
		if( server.indexOf( '://' ) == -1 ) url = 'http://' + server + '.wikia.com' + url;
		else url = server + url;
	}
	return importStylesheetURI(url);
}
