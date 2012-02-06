
function Room(client) {
//	var path = client.wgServer + client.wgArticlePath;
	this.articlePath = client.wgServer + client.wgArticlePath;
}

exports = module.exports = Room;

/**
 * Does pre-processing of text (currently used BEFORE storing it in redis).
 *
 * Some wg variables (stored in the client) are needed for link rewriting, etc. so
 * the second param should be the client of the user who sent the message.
 */
Room.prototype.processText = function(text) {
	// Prevent simple HTML/JS vulnerabilities (need to do this before other rewrites).
	text = text.replace(/</g, "&lt;");
	text = text.replace(/>/g, "&gt;");

	// TODO: Use the wgServer and wgArticlePath from the chat room. Maybe the room should be passed into this function? (it seems like it could be called a bunch of times in rapid succession).

	// Linkify local wiki links (eg: http://thiswiki.wikia.com/wiki/Page_Name ) as shortened links (like bracket links)
	var localWikiLinkReg = this.articlePath.replace(/\$1/, "([-A-Z0-9+&@#\/%?=~_|'!:,.;]*[-A-Z0-9+&@#\/%=~_|'])");
	text = text.replace(new RegExp(localWikiLinkReg, "i"), "[[$1]]"); // easy way... will re-write this to a shortened link later in the function.

	// Linkify http://links
	var exp = /(\b(https?):\/\/[-A-Z0-9+&@#\/%?=~_|'!:,.;]*[-A-Z0-9+&@#\/%=~_|'])/ig;
	var pageLink = "";
	if(text.match(exp)){
		pageLink = unescape( exp.exec(text)[1] );
	}
	text = text.replace(exp, "<a href='$1'>" + pageLink + "</a>");

	// Linkify [[Pipes|Pipe-notation]] in bracketed links.
	exp = /\[\[([ %!\"$&'()*,\-.\/0-9:;=?@A-Z\\^_`a-z~\x80-\xFF+#]*)\|([^\]\|]*)\]\]/ig;
	text = text.replace(exp, function(wholeMatch, article, linkText) {
		article = article.replace(/ /g, "_");
		linkText = linkText.replace(/_/g, " ");
		linkText = unescape( linkText );

		article = escape( article );
		article = article.replace(/%3a/ig, ":"); // make colons more human-readable (they don't really need to be escaped)
		var url = this.articlePath.replace("$1", article);
		return '<a href="' + url + '">' + linkText + '</a>';
	});

	// Linkify [[links]] - the allowed characters come from http://www.mediawiki.org/wiki/Manual:$wgLegalTitleChars
	exp = /(\[\[[ %!\"$&'()*,\-.\/0-9:;=?@A-Z\\^_`a-z~\x80-\xFF+#]*\]\])/ig;
	text = text.replace(exp, function(match) {
		var article = match.substr(2, match.length - 4);
		article = article.replace(/ /g, "_");
		var linkText = article.replace(/_/g, " ");
		linkText = unescape( linkText );

		article = escape( article );
		article = article.replace(/%3a/ig, ":"); // make colons more human-readable (they don't really need to be escaped)
		var url = this.articlePath.replace("$1", article);
		return '<a href="' + url + '">' + linkText + '</a>';
	});

	return text;
}; // end processText()