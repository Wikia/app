(function(w,d,s,p,v,e,r) {w['$igniter_var']=v;w[v]=w[v]||function(){(w[v].q=w[v].q||[]).push(
arguments)};w[v].l=1*new Date();e=d.createElement(s),r=d.getElementsByTagName(s)[0];e.async=1;
e.src=p+'?ts='+(+new Date()/3600000|0);
r.parentNode.insertBefore(e,r)})(window,document,'script','//cdn.petametrics.com/l9ehhrb6mtv75bp2.js','$p');

function getLiftIgniterGlobalContext() {
    var context = {};
    if (window.ads && window.ads.context && window.ads.context.targeting) {
        var targeting = window.ads.context.targeting;

        context = {
            _wCategory: targeting.wikiCategory,
            _wName: targeting.wikiDbName,
            _wTop: targeting.wikiIsTop1000,
            _wikiLanguage: targeting.wikiLanguage,
            _wVert: targeting.wikiVertical,
            _pType: targeting.pageType,
            _pName: targeting.pageName
        };

        if (targeting.wikiCustomKeyValues) {
            targeting.wikiCustomKeyValues
                .split(';')
                .map(function(keyVal) {
                    return keyVal.split('=');
                })
                .forEach(function(parts) {
                    var key = '_'+parts[0];
                    if (!context[key]) {
                        context[key] = [parts[1]];
                    } else {
                        context[key].push(parts[1]);
                    }
                })
        }
    }

    if (localStorage.kxallsegs) {
        context['_kruxTags'] = localStorage.kxallsegs.split(',');
    }

    return context;
}

$p("init", "l9ehhrb6mtv75bp2", {
    config: {
        globalCtx: getLiftIgniterGlobalContext()
    }
});
$p("send", "pageview");
$p("setRequestFields", ["rank", "thumbnail", "title", "url", "presented_by", "author", "site_name", "type", "altImage", "altTitle"]);
