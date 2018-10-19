/*global describe, it, expect*/
describe('wikibits', function() {
	'use strict';
	mw.config = new mw.Map();
	var url1 = '/index.php?title=MediaWiki:UserTags/code.js&action=raw&ctype=text/javascript';
	var url1expect = '/index.php?title=MediaWiki:UserTags.js&action=raw&ctype=text/javascript';
	var url1expect2 = '//dev.wikia.com/index.php?title=MediaWiki:UserTags.js&action=raw&ctype=text/javascript';
	var url2 = '/index.php?title=User:TK-999/common.js&action=raw&ctype=text/javascript';
	var url3 = 'http://dev.wikia.com/index.php?title=MediaWiki:UserTags/code.js&action=raw&ctype=text/javascript';
	var url3expect = '//dev.wikia.com/index.php?title=MediaWiki:UserTags/code.js&action=raw&ctype=text/javascript';
	var url4 = 'https://dev.wikia.com/index.php?title=MediaWiki:UserTags/code.js&action=raw&ctype=text/javascript';
	var url5 = 'http://platform.twitter.com/widgets.js';
	var url6 = '/index.php?title=MediaWiki:WikiaNavigationBarStyle/code.css&action=raw&ctype=text/css';
	var url6expect = '/index.php?title=MediaWiki:WikiaNavigationBarStyle.css&action=raw&ctype=text/css';
	var url7 = 'http://dev.wikia.com/index.php?title=MediaWiki:WikiaNavigationBarStyle/code.css&action=raw&ctype=text/css';
	var url7expect = '//dev.wikia.com/index.php?title=MediaWiki:WikiaNavigationBarStyle/code.css&action=raw&ctype=text/css';
	var url7expect2 = '//dev.wikia.com/index.php?title=MediaWiki:WikiaNavigationBarStyle.css&action=raw&ctype=text/css';
	var url8 = 'http://platform.twitter.com/widgets.css';
	var tsScripts = '1539643173';
	var tsReviewed = '1539734490';
	var currentParam = '&current=' + tsScripts;
	var reviewedParam = '&reviewed=' + tsReviewed;
	var mediaAttr = 'sampleMedia';

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

	it('should import a script using importScriptPage properly', function() {
		// Reset mw.config values
		mw.config = new mw.Map();
		mw.config.set('wgReviewedScriptsTimestamp', tsReviewed);
		mw.config.set('wgScript', '/index.php');
		mw.config.set('wgScriptsTimestamp', tsScripts);
		mw.config.set('wgWikiaBaseDomain', 'wikia.com');
		mw.config.set('wgWikiaBaseDomainRegex', '((wikia|fandom)\.com|(wikia|fandom)-dev\.(com|us|pl))');

		// Ensure proper local URL is being imported
		expect(window.importScriptPage('MediaWiki:UserTags/code.js').getAttribute('src'))
			.toEqual(url1);

		// Ensure proper checking is done on the second parameter
		window.loadedScripts = {};
		expect(window.importScriptPage('MediaWiki:UserTags/code.js', {}).getAttribute('src'))
			.toEqual(url1);

		// Ensure proper local URL is being imported on Dev Wiki
		window.loadedScripts = {};
		mw.config.set('wgCityId', '7931');
		expect(window.importScriptPage('MediaWiki:UserTags/code.js').getAttribute('src'))
			.toEqual(url1expect);

		// Ensure proper Dev Wiki URL is being imported
		window.loadedScripts = {};
		mw.config.set('wgCityId', '177');
		expect(window.importScriptPage('MediaWiki:UserTags/code.js', 'dev').getAttribute('src'))
			.toEqual(url1expect2);
	});

	it('should import a stylesheet by URL properly', function() {
		// Reset mw.config values
		mw.config = new mw.Map();
		mw.config.set('wgWikiaBaseDomainRegex', '((wikia|fandom)\.com|(wikia|fandom)-dev\.(com|us|pl))');

		var stylesheet = window.importStylesheetURI(url6);

		// Ensure proper DOM node attributes and insertion
		expect(stylesheet instanceof Node).toBe(true);
		expect(stylesheet.nodeName).toBe('LINK');
		expect(stylesheet.getAttribute('type')).toEqual('text/css');
		expect(stylesheet.getAttribute('rel')).toEqual('stylesheet');
		expect(stylesheet.parentElement).toBe(document.head);

		// Ensure HTTPS isn't enforced on protocol-relative URLs
		expect(stylesheet.getAttribute('href')).toEqual(url6);

		var stylesheet2 = window.importStylesheetURI(url7, mediaAttr);

		// Ensure media attribute works
		expect(stylesheet2.getAttribute('media')).toEqual(mediaAttr);
		expect(stylesheet2.getAttribute('href')).toEqual(url7expect);

		// Ensure nothing is done to external stylesheet URLs
		expect(window.importStylesheetURI(url8).getAttribute('href'))
			.toEqual(url8);
	});

	it('should import a stylesheet using importStylesheet properly', function() {
		// Reset mw.config values
		mw.config = new mw.Map();
		mw.config.set('wgScript', '/index.php');
		mw.config.set('wgWikiaBaseDomainRegex', '((wikia|fandom)\.com|(wikia|fandom)-dev\.(com|us|pl))');

		// Ensure proper local URL is being imported
		expect(window.importStylesheet('MediaWiki:WikiaNavigationBarStyle/code.css').getAttribute('href'))
			.toEqual(url6);

		// Ensure proper local URL is being imported on Dev Wiki
		mw.config.set('wgCityId', '7931');
		expect(window.importStylesheet('MediaWiki:WikiaNavigationBarStyle/code.css').getAttribute('href'))
			.toEqual(url6expect);
	});

	it('should import a stylesheet using importStylesheetPage properly', function() {
		// Reset mw.config values
		mw.config = new mw.Map();
		mw.config.set('wgScript', '/index.php');
		mw.config.set('wgWikiaBaseDomain', 'wikia.com');
		mw.config.set('wgWikiaBaseDomainRegex', '((wikia|fandom)\.com|(wikia|fandom)-dev\.(com|us|pl))');

		// Ensure proper local URL is being imported
		expect(window.importStylesheetPage('MediaWiki:WikiaNavigationBarStyle/code.css').getAttribute('href'))
			.toEqual(url6);

		// Ensure proper Dev Wiki URL is being imported
		expect(window.importStylesheetPage('MediaWiki:WikiaNavigationBarStyle/code.css', 'dev').getAttribute('href'))
			.toEqual(url7expect2);

		// Ensure proper local URL is being imported on Dev Wiki
		mw.config.set('wgCityId', '7931');
		expect(window.importStylesheetPage('MediaWiki:WikiaNavigationBarStyle/code.css').getAttribute('href'))
			.toEqual(url6expect);
	});
});
