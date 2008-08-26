// ==UserScript==
// @name          Wikiwyg.Wikipedia
// @namespace     http://www.wikiwyg.net
// @description   Wikiwyg for Wikipedia
// @include       http://*.wikipedia.org/wiki*
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
    'http://www.wikiwyg.net/download/bleed/lib/Wikiwyg/GreaseMonkey.js',
    'http://www.wikiwyg.net/download/bleed/demo/wikipedia/wikipedia.js'
]);
