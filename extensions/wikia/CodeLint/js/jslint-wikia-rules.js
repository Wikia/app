/**
 * This file contains Wikia specific rules for JS lint
 */

exports.rules  = [
	// detect hardcoded stuff (BugId:12757)
	{
		name: 'Found hardcoded value',
		regexp: /['"]([^"']+blank.gif|\/skins\/|\/extensions\/|\/wiki\/)/,
		dontMatch: /.scss/, // ignore URLs to SASS files as they contain "hardcoded" /extensions and /skins paths
		reason: function(matches) {
			return 'Found hardcoded value: "' + matches[1] + '"';
		}
	},
	// detect $.live (BugId:28034)
	{
		name: 'Found $.live',
		regexp: /.live\(\s?['"]/,
		reason: 'jQuery.live() is deprecated'
	},
	// detect $.css (BugId:28035), but ignore css('height', ...) and css('width', ...)
	{
		name: 'Found $.css',
		regexp: /.css\(\s?['"](\S+)['"]\s?,/,
		reason: function(matches) {
			var cssPropertyName = matches[1];

			// ignore setting margin and padding
			if (/^(margin|padding)/.test(cssPropertyName)) {
				return false;
			}

			// ignore setting width and height
			if (/(height|width)$/.test(cssPropertyName)) {
				return false;
			}

			switch(cssPropertyName) {
				// use $.show or $.hide
				case 'display':
					return 'Use $.show or $.hide';

				// ignore
				case 'left':
				case 'right':
				case 'top':
				case 'bottom':
				case 'visibility':
				case 'backgroundImage':
					return false;

				default:
					return 'jQuery.css() should not be used (use CSS classes instead)';
			}
		}
	},
	// detect $.browser (BugId:28056)
	{
		name: 'Found $.browser',
		regexp: /(\$|jQuery).browser./,
		reason: 'jQuery.browser should not be used (use feature detection instead)'
	},
	// detect setTimeout / setInterval with implied eval
	{
		name: 'Implied eval',
		regexp: /set(Timeout|Interval)\(\s?["']/,
		reason: function(matches) {
			return 'Don\'t pass a string to set' + matches[1] + ' (implied eval)';
		}
	},
	// detect use of wgStyleVersion as URL suffix
	{
		name: 'wgStyleVersion used',
		regexp: /.(css|js)\?['"]\s?\+\s?wgStyleVersion/,
		reason: 'No need to use wgStyleVersion as the URL suffix'
	},
	// nested callbacks (BugId:29194)
	{
		name: 'Nested callback',
		regexp: /\(\S+[^\(\)]*function\([^\)]*\)\s*{$/,
		reason: function(matches, currLine, nextLine) {
			var nextLineRegexp = /^\s*[^\{\}]*function\([^\(]?\)\s?\{\s?$/;

			if (nextLine && nextLineRegexp.test(nextLine)) {
				return 'Nested callbacks detected (consider promise pattern instead)';
			}
			else {
				return false;
			}
		}
	},
	// skin checks
	{
		name: 'Skin check',
		regexp: /skin\s?==\s?['"]oasis['"]/,
		reason: 'Deprecated skin check found'
	},
	// MW1.19 deprecated functions and variables (BugId:32267)
	/**
	{
		name: 'MW1.19',
		regexp: require('./jslint-deprecated').regexp,
		reason: function(matches) {
			return "'" + matches[2] + "' is deprecated in MW 1.19";
		}
	},
	 **/
	// old tracking code
	/**
	{
		name: 'Tracking',
		regexp: /((WET.byId|WET.byStr|\$\(.*\).trackClick|\$.tracker).*)\(/,
		reason: function(matches) {
			return matches[1] + ' - old tracking code found (use WikiaTracker.trackEvent instead)';
		}
	},
	**/
	// detect requests to wikia.php
	{
		name: '$.get(wikia.php) request',
		regexp: /\/wikia.php/,
		reason: 'Use of direct call to wikia.php (use $.nirvana)'
	},
	// detect debugger statement (BugId:32021)
	{
		name: 'Debugger statement found',
		regexp: /debugger;/,
		reason: 'debugger statement found'
	},
	// detect direct calls to document.cookie (BugId:32020)
	{
		name: 'document.cookie direcy call',
		regexp: /document.cookie(\s?=|\.)/,
		reason: 'Use of document.cookie (use $.cookies)'
	},
	// not cached jQuery selectors (BugId: 37173)
	{
		name: 'Not cached jQuery selectors',
		regexp: /(jQuery|\$)\([^\)]+\)/,
		reason: function(matches, currLine, nextLine) {
			var selector = matches[0];

			return (nextLine.indexOf(selector) > -1)
				? ('Not cached jQuery selector found - ' + selector)
				: false;
		}
	},
	// detect YAHOO (BugId;44748)
	{
		name: 'Found YUI',
		regexp: /YAHOO\./,
		reason: 'Use of YUI library (migrate to jQuery)'
	}
];
