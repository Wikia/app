// ==UserScript==
// @name          Wikiwyg.C2
// @namespace     http://www.wikiwyg.net
// @description   Wikiwyg for Ward Cunnighams c2.com Wiki
// @include       http://www.c2.com/cgi/wiki*
// @include       http://c2.com/cgi/wiki*
// ==/UserScript==

use = function(urls) {
    var url = urls.shift();
    if (!url) return;

    var fetch_eval = function(response) {
        var javascript = response.responseText;
        try {
            eval(javascript);
        } catch(e) {
            alert('Javascript use failed:\n' + url + '\n' + e);
        }
        use(urls);
    }

    GM_xmlhttpRequest({
        method: 'GET',
        'url': url,
        onload: fetch_eval,
    });
}

use([
    'http://www.wikiwyg.net/download/bleed/lib/Wikiwyg.js',
    'http://www.wikiwyg.net/download/bleed/lib/Wikiwyg/Toolbar.js',
    'http://www.wikiwyg.net/download/bleed/lib/Wikiwyg/Wysiwyg.js',
    'http://www.wikiwyg.net/download/bleed/lib/Wikiwyg/Wikitext.js',
    'http://www.wikiwyg.net/download/bleed/lib/Wikiwyg/Preview.js',
    'http://www.wikiwyg.net/download/bleed/demo/c2/wikiwyg-c2.js',
]);
