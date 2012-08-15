(function(window,$){
	"use strict";

	if ( !window.wgArticlesAsResources ) {
		return;
	}

	log('AAR: initializing');

	var timerId;

	var queue = {
		style: [],
		script: []
	};

	var orig = {
		importScript: window.importScript,
		importScriptURI: window.importScriptURI,
		importStylesheet: window.importStylesheet,
		importStylesheetURI: window.importStylesheetURI,
		importScriptPage: window.importScriptPage,
		importStylesheetPage: window.importStylesheetPage
	};

	function log() {
		window.console && window.console.log && window.console.log.apply
			&& window.console.log.apply(window.console,arguments);
	}

	function parseUrl( url ) {
		var REGEX = /^((([a-z]+)?:)?\/\/([^\/]+))?((\/[^?#]*)?(\?([^#]+)?)?(#(.*))?)?$/;
		var matches = REGEX.exec(url);
		var res = false;
		if (matches) {
			res = {
				proto: matches[3],
				domain: matches[4],
				path: matches[6],
				query: matches[7],
				fragment: matches[9]
			};
		}
		return res;
	}

	function guessArticleFromUrl( urlString ) {
		var PATH_REGEX = /^\/index\.php$/;
		var QUERY_REGEX = /^\?title=([^&]+)&action=raw&ctype=text\/(javascript|css)$/;
		var DOMAIN_REGEX = /^(.*)\.wikia\.com$/;
		var page, server, matches, article;
		var url = parseUrl(urlString);

		log('AAR: guessing',urlString,url);

		if ( !url ) return false;
		if ( !url.path ) return false;

		matches = PATH_REGEX.exec(url.path);
		log('AAR: guess: page',matches);
		if ( !matches ) return false;

		matches = QUERY_REGEX.exec(url.query);
		log('AAR: guess: query',matches);
		if ( !matches ) return false;
		page = matches[1];

		if ( url.domain ) {
			matches = DOMAIN_REGEX.exec(url.domain);
			log('AAR: guess: domain',matches);
			if ( matches ) server = url.domain;
		}

		if ( server ) {
			article = "u:"+server+":"+page;
		} else {
			article = "w:"+window.wgDBname+":"+page;
		}

		log('AAR: guess: article',matches);
		return article;
	}

	function buildUrl( type, articles ) {
		var only = type == 'script' ? 'scripts' : 'styles';
		var mimeType = type == 'script' ? 'text/javascript' : 'text/css';
		articles = articles.join('|');

		var request = {
			skin: mw.config.get( 'skin' ),
			lang: mw.config.get( 'wgUserLanguage' ),
			debug: mw.config.get( 'debug' ),
			only: only,
			mode: 'articles',
			articles: articles
		};

		var loadScript = mw.loader.getSource('local').loadScript;
		var url = loadScript + '?' + $.param( request ) + '&*';

		// make the url absolute
		if ( ! /^(https?:)?\/\//.test( url ) ) {
			url = window.wgServer + url;
		}

		log('AAR: buildUrl',url);

		mw.loader.load(url,mimeType,true);
	}

	function reallyRequest() {
		clearTimeout(timerId);
		timerId = false;
		log('AAR: reallyRequest',queue);
		for (var type in queue) {
			if (queue[type].length > 0) {
				var articles = queue[type];
				queue[type] = [];
				var url = buildUrl( type, articles );
			}
		}
	}

	function startTimer() {
		if (!timerId) {
			timerId = setTimeout(reallyRequest,1);
		}
	}

	function request( type, article ) {
		log('AAR: request',type,article);
		queue[type].push([article]);
		startTimer();
	}

	window.importScriptURI = function( url ) {
		var article = guessArticleFromUrl(url);
		if ( article ) {
			request('script',article);
		} else {
			orig.importScriptURI.apply(window,arguments);
		}
	}

	window.importStylesheetURI = function( url ) {
		var article = guessArticleFromUrl(url);
		if ( article ) {
			request('style',article);
		} else {
			orig.importStylesheetURI.apply(window,arguments);
		}
	}


})(window,jQuery);
