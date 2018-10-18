/*global describe, it, expect*/
describe('wikibits', function() {
	'use strict';
	mw.config = new mw.Map();
	var url1 = '/index.php?title=MediaWiki:UserTags/code.js&action=raw&ctype=text/javascript';
	var url1expect = '/index.php?title=MediaWiki:UserTags.js&action=raw&ctype=text/javascript';
	var url2 = '/index.php?title=User:TK-999/common.js&action=raw&ctype=text/javascript';
	var url3 = 'http://dev.wikia.com/index.php?title=MediaWiki:UserTags/code.js&action=raw&ctype=text/javascript';
	var url3expect = '//dev.wikia.com/index.php?title=MediaWiki:UserTags/code.js&action=raw&ctype=text/javascript';
	var url4 = 'https://dev.wikia.com/index.php?title=MediaWiki:UserTags/code.js&action=raw&ctype=text/javascript';
	var url5 = 'http://platform.twitter.com/widgets.js';
	var tsScripts = '1539643173';
	var tsReviewed = '1539734490';
	var currentParam = '&current=' + tsScripts;
	var reviewedParam = '&reviewed=' + tsReviewed;

	it('should define needed global functions', function () {
		expect(typeof window.addOnloadHook).toBe('function');
		expect(typeof window.forceReviewedContent).toBe('function');
		expect(typeof window.importScript).toBe('function');
		expect(typeof window.importScriptURI).toBe('function');
		expect(typeof window.importScriptPage).toBe('function');
		expect(typeof window.importStylesheet).toBe('function');
		expect(typeof window.importStylesheetURI).toBe('function');
		expect(typeof window.importStylesheetPage).toBe('function');
		expect(typeof window.loadedScripts).toBe('object');
	});

	it('should force reviewed content properly', function() {
		// Reset mw.config values
		mw.config = new mw.Map();

		// No JavaScript review, nothing should be done
		expect(window.forceReviewedContent(url1)).toEqual(url1);
		expect(window.forceReviewedContent(url2)).toEqual(url2);

		// Enable Content Review
		mw.config.set('wgContentReviewExtEnabled', true);
		mw.config.set('wgReviewedScriptsTimestamp', tsReviewed);
		mw.config.set('wgScriptsTimestamp', tsScripts);

		// MediaWiki pages should get a 'reviewed' URL parameter
		expect(window.forceReviewedContent(url1)).toEqual(url1 + reviewedParam);
		expect(window.forceReviewedContent(url2)).toEqual(url2);

		// Enable test mode
		mw.config.set('wgContentReviewTestModeEnabled', true);
		expect(window.forceReviewedContent(url1)).toEqual(url1 + currentParam);
		expect(window.forceReviewedContent(url2)).toEqual(url2);
	});

	it('should import a script by URL properly', function() {
		// Reset mw.config values
		mw.config = new mw.Map();
		mw.config.set('wgReviewedScriptsTimestamp', tsReviewed);
		mw.config.set('wgScriptsTimestamp', tsScripts);
		mw.config.set('wgWikiaBaseDomainRegex', '((wikia|fandom)\.com|(wikia|fandom)-dev\.(com|us|pl))');

		var script = window.importScriptURI(url2);

		// Ensure proper DOM node attributes and insertion
		expect(script instanceof Node).toBe(true);
		expect(script.nodeName).toBe('SCRIPT');
		expect(script.getAttribute('type')).toEqual('text/javascript');
		expect(script.parentElement).toBe(document.head);

		// Ensure HTTPS isn't enforced when URL isn't insecure
		// and that reviewed content isn't forced when not enabled
		expect(script.getAttribute('src')).toEqual(url2);

		// Ensure double-loading prevention
		expect(window.importScriptURI(url2)).toBe(null);

		// Ensure Content Review forcing works
		mw.config.set('wgContentReviewExtEnabled', true);
		expect(window.importScriptURI(url1).getAttribute('src'))
			.toEqual(url1 + reviewedParam);

		// Ensure HTTPS conversion works
		expect(window.importScriptURI(url3).getAttribute('src'))
			.toEqual(url3expect + reviewedParam);

		// Ensure HTTPS conversion isn't changing already-HTTPS links
		expect(window.importScriptURI(url4).getAttribute('src'))
			.toEqual(url4 + reviewedParam);

		// Ensure Content Review and HTTPS conversion aren't affecting
		// external imports
		expect(window.importScriptURI(url5).getAttribute('src')).toEqual(url5);
	});

	it('should import a script using importScript properly', function() {
		// Reset mw.config values
		mw.config = new mw.Map();
		mw.config.set('wgReviewedScriptsTimestamp', tsReviewed);
		mw.config.set('wgScript', '/index.php');
		mw.config.set('wgScriptsTimestamp', tsScripts);
		mw.config.set('wgWikiaBaseDomainRegex', '((wikia|fandom)\.com|(wikia|fandom)-dev\.(com|us|pl))');

		// Ensure proper URL is being imported
		expect(window.importScript('MediaWiki:UserTags/code.js').getAttribute('src'))
			.toEqual(url1);

		// Ensure Dev Wiki's /code.js pages are redirected to .js
		window.loadedScripts = {};
		mw.config.set('wgCityId', '7931');
		expect(window.importScript('MediaWiki:UserTags/code.js').getAttribute('src'))
			.toEqual(url1expect);
	});
});
