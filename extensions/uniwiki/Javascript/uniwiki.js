/* vim: noet ts=4 sw=4
 * http://www.mediawiki.org/wiki/Extension:Uniwiki_Javascript
 * http://www.gnu.org/licenses/gpl-3.0.txt */

// global uniwiki stuff
var Uniwiki = {
	i18n: {

		/* other extensions should use this function
		 * to make their i18n strings accessible to JS */
		add: function(obj) {
			for (i in obj) {
				Uniwiki.i18n[i] = obj[i];
			}
		}
	}
};

/* global function to make internationalization rather
 * easier, by looking up strings in the i18n hash */
function wfMsg (key) {
	return Uniwiki.i18n[key];
}
