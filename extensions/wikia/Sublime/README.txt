This is an experimental extension that should be renamed to something more helpful when possible.
- Sean Colombo 9/11/2010


Dependencies:
	/extensions/wikia/JavascriptAPI/Mediawiki.js (Nick Sullivan's Javascript client to MediaWiki's API).
	/extensions/wikia/RTE (Wikia's RichTextEditor - for reverse-parsing HTML into wikitext)


TODO:
	- Step 1: Store data
		- Get a prototype page where I can put in some arbitrary text (plaintext or wikitext) and then submit it to be stored in a MediaWiki API successfully.
		- Change previous prototype to take HTML as input, then use the reverse-parser to turn it into wikitext before submitting to the MediaWiki API.
	
	- Step 2: Retrieve data
		- Go to a page and have it check for a match for the article.
		- Pull up the parsed article from MediaWiki using the Javascript API.
