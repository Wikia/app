/**
 * @author Sean Colombo
 * @date 20110902
 * @hackathon ;)
 *
 * This file contains the structure and functionality for Community-powered emoticons for use
 * in MediaWiki Chat (specifically at Wikia... but it will almost certainly be reusable by
 * anyone using our Node.js Chat server).
 *
 * The 
 * 
 */

 
/** CONSTANTS & VARIABLES **/
// By explicitly setting the dimensions, this will make sure the feature stays as emoticons instead of getting
// spammy or inviting disruptive vandalism (19px vandalism probably won't be AS offensive).
exports.EMOTICON_WIDTH = 19;
exports.EMOTICON_HEIGHT = 19;
exports.EMOTICON_ARTICLE = "MediaWiki:Emoticons";


/** FUNCTIONS **/

/**
 * Takes in some chat text and an emoticonMapping (which strings should be replaced with images at which URL) and returns
 * the text modified so that the replacable text (eg ":)") is replaced with the HTML for the image of that emoticon.
 */
exports.doReplacements = function(text, emoticonMapping){
	// This debug is probably noisy, but I added it here just in case all of these regexes turn out to be slow (so we could
	// see that in the log & know that we need to make this function more efficient).
	console.log("Processing any emoticons... ");

	var imgUrlsByRegexString = emoticonMapping.getImgUrlsByRegexString();
	for(var regexString in imgUrlsByRegexString){
		imgSrc = imgUrlsByRegexString[regexString];
		var regex = new RegExp(regexString, "gi");

		imgSrc = imgSrc.replace(/"/g, "%22"); // prevent any HTML-injection
		var emoticon = " <img src=\""+imgSrc+"\" width='"+exports.EMOTICON_WIDTH+"' height='"+exports.EMOTICON_HEIGHT+"'/> ";

		text = text.replace(regex, emoticon );
		//text = text.replace(/(^| ):\)( |$)/g, emoticon );
	}

	console.log("Done processing emoticons.");
	return text;
} // end doReplacements()

// class EmoticonMapping
if(typeof EmoticonMapping === 'undefined'){
	EmoticonMapping = function(){
		var self = this;
		this._regexes = {
			// EXAMPLE DATA ONLY: This is what the generated text will look like... but it's loaded from ._settings on-demand.
			//			":\\)|:-\\)|\\(smile\\)": "http://images.wikia.com/lyricwiki/images/6/67/Smile001.gif",
			//			":\\(|:-\\(": "http://images3.wikia.nocookie.net/__cb20100822133322/lyricwiki/images/d/d8/Sad.png",
		};
		
		// Since the values in here are processed and then cached, don't modify this directly.  Use mutators (which can invalidate the cached data such as self._regexes).
		this._settings = {
			"http://images.wikia.com/lyricwiki/images/6/67/Smile001.gif": [":)", ":-)", "(smile)"],
			"http://images3.wikia.nocookie.net/__cb20100822133322/lyricwiki/images/d/d8/Sad.png": [":(", ":-(", ":|"],
		};
		
		/**
		 * Convert our specific wikitext format into the hash of emoticons settings.  Overwrites all
		 * of the existing settings (instead of merging).
		 */
		this.loadFromWikiText = function(wikiText){
			self._settings = {}; // clear out old values

			var emoticonArray = wikiText.split("\n");
			var currentKey = '';

			// Loop through array, construct object
			for(var i=0; i<emoticonArray.length; i++) {
				if (emoticonArray[i].indexOf('* ') == 0) {
					var url = emoticonArray[i].substr(2);
					self._settings[url] = [];
					currentKey = url;
				} else if (emoticonArray[i].indexOf('** ') == 0) {
					var glyph = emoticonArray[i].substr(3);
					self._settings[currentKey].push(glyph);
				}
			}
		
			// Clear out the regexes cache (they'll be rebuilt on-demand the first time this object is used).
			self._regexes = {}; 
		};

		/**
		 * Returns a hash where the keys are regex strings (strings that can be passed into the constructor of RegExp) and
		 * where the values are the img url of the emoticon that should be substituted for the string.
		 */
		this.getImgUrlsByRegexString = function(){
			// If the regexes haven't been built from the config yet, build them.
			//console.log("settings len: " + Object.keys(self._settings).length + " regex len: " + Object.keys(self._regexes).length);
			if(Object.keys(self._settings).length != Object.keys(self._regexes).length){
				//console.log("..Processing settings");
				for(var imgSrc in self._settings){
					var codes = self._settings[imgSrc];
					var regexString = "";
					for(var index in codes){
						var code = codes[index];
						//console.log("..Code: " + code);
						// Escape the string for use in the regex (thanks to http://simonwillison.net/2006/Jan/20/escape/#p-6).
						code = code.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&");
						//console.log("..Rewritten to " + code);
						if(code != ""){
							regexString += ((regexString =="")?"":"|");
							regexString += code;
						}
					}
					//console.log("...Regexstr: " + regexString);

					// Stores the regex to img mapping.
					self._regexes[regexString] = imgSrc;
				}
			}
			
			return self._regexes;
		};
	};
}
