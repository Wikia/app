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
		
		// Build the regex for the character (make it ignore the match if there is a "/" immediately after the emoticon. That creates all kinds of problems with URLs).
		var regex = new RegExp("(" + regexString + ")($|[^/])", "gi");

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

			// TODO: FIXME: Rewrite this to use regexes so that we don't require the space after the asterisks (because that's not needed in normal wikitext).
			// Loop through array, construct object
			//console.log("Loading emoticon mapping...");
			for(var i=0; i<emoticonArray.length; i++) {
				if (emoticonArray[i].indexOf('* ') == 0) {
					var url = emoticonArray[i].substr(2);
					self._settings[url] = [];
					currentKey = url;
					//console.log("  " + url + "...");
				} else if (emoticonArray[i].indexOf('** ') == 0) {
					var glyph = emoticonArray[i].substr(3);
					self._settings[currentKey].push(glyph);
					//console.log("       " + glyph);
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
						// Escape the string for use in the regex (thanks to http://simonwillison.net/2006/Jan/20/escape/#p-6).
						code = code.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&");
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
		
		/**
		 * Loads a reasonable default of emoticons.
		 *
		 * TODO: Replace with loading Community Wiki's "MediaWiki:Emoticons" at startup and using that as the default
		 * until the client load's their appropriate wikitext.
		 */
		this.loadDefault = function(){
			self.loadFromWikiText('* http://images2.wikia.nocookie.net/__cb20110904035827/central/images/7/79/Emoticon_angry.png\n\
** (angry)\n\
** >:O\n\
** >:-O\n\
* http://images1.wikia.nocookie.net/__cb20110904035827/central/images/a/a3/Emoticon_argh.png\n\
** (argh)\n\
* http://images3.wikia.nocookie.net/__cb20110904035827/central/images/e/ec/Emoticon_BA.png\n\
** (ba)\n\
* http://images2.wikia.nocookie.net/__cb20110904035827/central/images/7/76/Emoticon_batman.png\n\
** (batman)\n\
* http://images1.wikia.nocookie.net/__cb20110904035828/central/images/e/e2/Emoticon_blush.png\n\
** (blush)\n\
** :]\n\
** :-]\n\
* http://images2.wikia.nocookie.net/__cb20110904040557/central/images/e/ed/Emoticon_books.png\n\
** (books)\n\
* http://images4.wikia.nocookie.net/__cb20110904035828/central/images/c/cd/Emoticon_confused.png\n\
** (confused)\n\
** :S\n\
** :-S\n\
* http://images2.wikia.nocookie.net/__cb20110904035828/central/images/2/28/Emoticon_content.png\n\
** (content)\n\
* http://images4.wikia.nocookie.net/__cb20110904035828/central/images/a/a2/Emoticon_cool.png\n\
** (cool)\n\
** B)\n\
** B-)\n\
* http://images4.wikia.nocookie.net/__cb20110904035828/central/images/1/16/Emoticon_crying.png\n\
** (crying)\n\
** ;-(\n\
** ;(\n\
** :\'(\n\
* http://images2.wikia.nocookie.net/__cb20110904040556/central/images/7/7d/Emoticon_fingers_crossed.png\n\
** (fingers crossed)\n\
** (yn)\n\
* http://images1.wikia.nocookie.net/__cb20110904040557/central/images/0/07/Emoticon_frustrated.png\n\
** (frustrated)\n\
** >:-/\n\
** >:/\n\
* http://images3.wikia.nocookie.net/__cb20110904040557/central/images/7/78/Emoticon_ghost.png\n\
** (ghost)\n\
** (swayze)\n\
* http://images1.wikia.nocookie.net/central/images/3/31/Emoticon_happy.png\n\
** (happy)\n\
** :-)\n\
** :)\n\
* http://images2.wikia.nocookie.net/__cb20110904040557/central/images/1/1e/Emoticon_heart.png\n\
** (heart)\n\
** (h)\n\
** <3\n\
* http://images1.wikia.nocookie.net/__cb20110904040557/central/images/7/7b/Emoticon_hmm.png\n\
** (hmm)\n\
* http://images1.wikia.nocookie.net/__cb20110904040557/central/images/b/b5/Emoticon_indifferent.png\n\
** (indifferent)\n\
** :/\n\
** :-/\n\
* http://images1.wikia.nocookie.net/__cb20110904040558/central/images/a/ac/Emoticon_laughing.png\n\
** (laughing)\n\
** :D\n\
** :-D\n\
* http://images2.wikia.nocookie.net/__cb20110904041805/central/images/c/c1/Emoticon_mario.png\n\
** (mario)\n\
* http://images3.wikia.nocookie.net/__cb20110904041806/central/images/4/43/Emoticon_moon.png\n\
** (moon)\n\
* http://images3.wikia.nocookie.net/__cb20110904041806/central/images/1/1d/Emoticon_ninja.png\n\
** (ninja)\n\
* http://images3.wikia.nocookie.net/__cb20110904041806/central/images/9/92/Emoticon_nintendo.png\n\
** (nintendo)\n\
* http://images2.wikia.nocookie.net/__cb20110904041806/central/images/4/40/Emoticon_no.png\n\
** (no)\n\
** (n)\n\
* http://images3.wikia.nocookie.net/__cb20110904041806/central/images/2/2d/Emoticon_owl.png\n\
** (owl)\n\
* http://images1.wikia.nocookie.net/__cb20110904041806/central/images/c/c2/Emoticon_pacmen.png\n\
** (pacmen)\n\
** (pacman)\n\
** (redghost)\n\
* http://images1.wikia.nocookie.net/__cb20110904041806/central/images/5/52/Emoticon_peace.png\n\
** (peace)\n\
* http://images3.wikia.nocookie.net/__cb20110904041806/central/images/7/74/Emoticon_pirate.png\n\
** (pirate)\n\
* http://images1.wikia.nocookie.net/__cb20110904041806/central/images/8/8a/Emoticon_sad.png\n\
** (sad)\n\
** :(\n\
** :-(\n\
* http://images1.wikia.nocookie.net/__cb20110904041912/central/images/c/c2/Emoticon_silly.png\n\
** (silly)\n\
** :P\n\
** :-P\n\
* http://images4.wikia.nocookie.net/__cb20110904041912/central/images/a/a9/Emoticon_stop.png\n\
** (stop)\n\
* http://images2.wikia.nocookie.net/__cb20110904041913/central/images/a/a2/Emoticon_unamused.png\n\
** (unamused)\n\
** :|\n\
** :-|\n\
* http://images1.wikia.nocookie.net/__cb20110904041913/central/images/d/dc/Emoticon_walter.png\n\
** (walter)\n\
* http://images1.wikia.nocookie.net/__cb20110904041913/central/images/d/dc/Emoticon_walter.png\n\
** (wikia)\n\
** (w)\n\
* http://images1.wikia.nocookie.net/__cb20110904041913/central/images/8/87/Emoticon_wink.png\n\
** (wink)\n\
** ;)\n\
** ;-)\n\
* http://images2.wikia.nocookie.net/__cb20110904041913/central/images/1/1c/Emoticon_yes.png\n\
** (yes)\n\
** (y)\n\
');
		};
	};
}
