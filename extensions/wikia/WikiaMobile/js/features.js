/**
 *
 * Think of it as a Modernizr replacement
 * we just need couple of tests, not the full feature set of this library
 *
 * @author Jakub "Student" Olek <jakubolek@wikia-inc.com>
 *
 *     This can't be module now as AdConfig.js needs this info
 *     Modules are async and this could cause problems in aforementioned js
 *
 *     TODO: When we find better solution for AdConfig change it to be a module
 *
 */
/*global window*/

window.Features = {
	addTest: function(name, test){
		//we don't want WeIrd names
		name = name.toLowerCase();

		//evaluate test
		var result = test() || false;

		//store it in global object for easy reference
		this[name] = result;

		//add class to HTML tag with a feature name
		//if it is not available append 'no-' to the feature name
		document.documentElement.className += (result ? ' ' : ' no-') + name;
	}
};

