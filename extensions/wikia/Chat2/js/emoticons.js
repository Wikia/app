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

'use strict';

var WikiaEmoticons,
	EmoticonMapping;

// By explicitly setting the dimensions, this will make sure the feature stays as emoticons instead of getting
// spammy or inviting disruptive vandalism (19px vandalism probably won't be AS offensive).
if (typeof WikiaEmoticons === 'undefined'){
	WikiaEmoticons = {};
}
WikiaEmoticons.EMOTICON_WIDTH = 19;
WikiaEmoticons.EMOTICON_HEIGHT = 19;

/**
 * Takes in some chat text and an emoticonMapping (which strings should be replaced with images at which URL) and
 * returns the text modified so that the replacable text (eg ":)") is replaced with the HTML for the image of
 * that emoticon.
 */
WikiaEmoticons.doReplacements = function (text, emoticonMapping) {
	// This debug is probably noisy, but I added it here just in case all of these regexes turn out
	// to be slow (so we could see that in the log & know that we need to make this function more efficient).
	$().log('Processing any emoticons... ');

	var imgUrlsByRegexString = emoticonMapping.getImgUrlsByRegexString(),
		regexString,
		imgSrc,
		numIters,
		origText,
		regex,
		glyphUsed,
		buildTagFunc;

	for (regexString in imgUrlsByRegexString){
		// Empty string for emote icons crash Chat so ignore them
		if (regexString === '') {
			continue;
		}

		imgSrc = imgUrlsByRegexString[regexString];
		imgSrc = imgSrc.replace(/"/g, '%22'); // prevent any HTML-injection

		buildTagFunc = WikiaEmoticons.buildTagGenerator(imgSrc);

		// Fix > and <
		regexString = regexString.replace(/>/g, '&gt;');
		regexString = regexString.replace(/</g, '&lt;');

		// Build the regex for the character (make it ignore the match if there is a "/" immediately
		// after the emoticon. That creates all kinds of problems with URLs).
		numIters = 0;
		origText = text;

		do {
			// NOTE: \s does not work for whitespace here for some reason.
			regex = new RegExp('(^| )(' + regexString + ')([^/]|$)', 'gi');
			glyphUsed = text.replace(regex, '$2');
			glyphUsed = glyphUsed.replace(/"/g, '&quot;'); // prevent any HTML-injection
			text = text.replace(regex, buildTagFunc);
		} while ((origText !== text) && (numIters++ < 5));
	}

	$().log('Done processing emoticons.');
	return text;
};

WikiaEmoticons.buildTagGenerator = function (imgSrc) {
	return function (match, leading, tag, trailing) {
		// Don't return any img tag if this is an external image
		if (!imgSrc.match(/^(?:https?:)?\/\/(?:[^\/]+\.)*?wikia(?:-dev)?(?:\.com|\.nocookie\.net)\//)) {
			return '';
		}

		tag = mw.html.escape(tag);
		imgSrc = mw.html.escape(imgSrc);

		return (
			leading +
			' <img ' +
				'src="' + imgSrc + '" ' +
				'width="' + WikiaEmoticons.EMOTICON_WIDTH + '"' +
				'height="' + WikiaEmoticons.EMOTICON_HEIGHT + '"' +
				'alt="' + tag + '"' +
				'title="' + tag + '"/> ' +
			trailing
		);
	};
};

// class EmoticonMapping
if (typeof EmoticonMapping === 'undefined') {
	EmoticonMapping = function () {
		var self = this;
		this._regexes = {
			// EXAMPLE DATA ONLY: This is what the generated text will look like... but it's loaded from ._settings
			// on-demand:
			//  ":\\)|:-\\)|\\(smile\\)": "http://images.wikia.com/lyricwiki/images/6/67/Smile001.gif",
			//  ":\\(|:-\\(": "http://images3.wikia.nocookie.net/__cb20100822133322/lyricwiki/images/d/d8/Sad.png",
		};

		// Since the values in here are processed and then cached, don't modify this directly.  Use mutators
		// (which can invalidate the cached data such as self._regexes).
		// TODO: fetch emoticons from nocookie domain
		// https://wikia-inc.atlassian.net/browse/SUS-449
		this._settings = {
			'http://images.wikia.com/lyricwiki/images/6/67/Smile001.gif': [':)', ':-)', '(smile)'],
			'http://images3.wikia.nocookie.net/__cb20100822133322/lyricwiki/images/d/d8/Sad.png': [':(', ':-(', ':|']
		};

		/**
		 * Convert our specific wikitext format into the hash of emoticons settings.  Overwrites all
		 * of the existing settings (instead of merging).
		 */
		this.loadFromWikiText = function (wikiText) {
			self._settings = {}; // clear out old values

			var emoticonArray = wikiText.split('\n'),
				currentKey = '',
				i,
				urlMatch,
				url,
				glyph,
				glyphMatch;

			// TODO: FIXME: Rewrite this to use regexes so that we don't require the space after the asterisks
			// (because that's not needed in normal wikitext).
			// Loop through array, construct object
			for (i = 0; i < emoticonArray.length; i++) {
				// line starting with 1 "*" then optional spaces, then some non-empty content.
				urlMatch = emoticonArray[i].match(/^\*[ ]*([^*].*)/);
				if (urlMatch && urlMatch[1]) {
					url = urlMatch[1];
					self._settings[url] = [];
					currentKey = url;
				} else if (self._settings[currentKey]) {
					// line starting with 2 "**"'s then optional spaces, then some non-empty content.
					glyphMatch = emoticonArray[i].match(/^\*\* *([^*"][^"]*)/);
					if (glyphMatch && glyphMatch[1]) {
						glyph = glyphMatch[1];
						self._settings[currentKey].push(glyph);
					}
				}
			}

			// Clear out the regexes cache (they'll be rebuilt on-demand the first time this object is used).
			self._regexes = {};
		};

		/**
		 * Returns a hash where the keys are regex strings (strings that can be passed into the constructor of RegExp)
		 * and where the values are the img url of the emoticon that should be substituted for the string.
		 */
		this.getImgUrlsByRegexString = function () {
			// If the regexes haven't been built from the config yet, build them.

			var numSettings = 0,
				numRegexes = 0,
				keyName,
				regKeyName,
				imgSrc,
				codes,
				code,
				regexString,
				index;

			// Object.keys() doesn't exist in IE 8, so do this the oldschool way.
			for (keyName in self._settings){
				numSettings++;
			}
			for (regKeyName in self._regexes){
				numRegexes++;
			}

			if (numSettings === numRegexes) {
				return self._regexes;
			}

			for (imgSrc in self._settings){
				codes = self._settings[imgSrc];
				regexString = '';
				for (index = 0; codes.length > index; index++){
					code = codes[index];
					// Escape the string for use in the regex. See: http://simonwillison.net/2006/Jan/20/escape/#p-6
					code = code.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, '\\$&');
					if (code !== '') {
						regexString += (regexString === '' ? '' : '|');
						regexString += code;
					}
				}

				// Stores the regex to img mapping.
				self._regexes[regexString] = imgSrc;
			}

			return self._regexes;
		};
	};
}
