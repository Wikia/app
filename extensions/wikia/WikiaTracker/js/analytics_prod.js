/*!
 * Google Analytics customizations for "Wikia"
 *
 * ! Please don't touch this file without consulting Cardinal Path.
 *
 * Based on GAS https://bitbucket.org/dpc/gas/
 *
 * @preserve Copyright(c) 2012 Cardinal Path
 * @author Eduardo Cereto <ecereto@cardinalpath.com>
 *
 * @version: prod_5
 */

(function(window, undefined){
    /**
     * Main Tracker, uses GAS
     *
     * https://github.com/CardinalPath/gas
     *
     * To be used for everything that is not advertisement
     */
    var _gas = window._gas = window._gas || [];

    // Main Roll-up Account - UA-32129070-1
    _gas.push(['_setAccount', 'UA-32129070-1']); // PROD
    _gas.push(['_setSampleRate', '10']); // 10% Sampling

    if(window.wgIsGASpecialWiki) {
        // Special Wikis account - UA-32132943-1
        _gas.push(['special._setAccount', 'UA-32132943-1']); // PROD
        _gas.push(['special._setSampleRate', '100']); // No Sample
    }

    // All domains that host content for wikia.
    _gas.push(['_setDomainName', 'wikia.com']);
    _gas.push(['_setDomainName', 'ffxiclopedia.org']);
    _gas.push(['_setDomainName', 'jedipedia.de']);
    _gas.push(['_setDomainName', 'marveldatabase.com']);
    _gas.push(['_setDomainName', 'memory-alpha.org']);
    _gas.push(['_setDomainName', 'uncyclopedia.org']);
    _gas.push(['_setDomainName', 'websitewiki.de']);
    _gas.push(['_setDomainName', 'wowwiki.com']);
    _gas.push(['_setDomainName', 'yoyowiki.org']);

    // Trigger cross-domain tracking
    _gas.push(['_setAllowLinker', 'true']);
    _gas.push(['_gasMultiDomain', 'click']);

    /**** High-Priority CVs ****/
    // Or wgCityId
    _gas.push(['_setCustomVar', 1, 'DBname', window.wgDBname, 3]);
    _gas.push(['_setCustomVar', 2, 'ContentLanguage', 
        window.wgContentLanguage, 3]);
    // Or cityShort, cscoreCat, wgCatId
    _gas.push(['_setCustomVar', 3, 'Hub', window.cscoreCat, 3]);
    _gas.push(['_setCustomVar', 4, 'Skin', window.skin, 3]);
    _gas.push(['_setCustomVar', 5, 'LoginStatus', 
        !!window.wgUserName ? 'user' : 'anon', 3]);

    // To be used for MS#2
    //_gas.push(['_setCustomVar', 2, 'wgSitename', window.wgSitename, 3]);
    /*
    _gas.push(['_setCustomVar', 11, 'UserLanguage', 
        window.wgUserLanguage, 3]);
    */

    /**** Medium-Priority CVs ****/
    _gas.push(['_setCustomVar', 8, 'PageType', 
        window.adLogicPageType, 3]);

    _gas.push(['_setCustomVar', 9, 'CityId', window.wgCityId, 3]);

    // Tracks the first DB Name and first landing page as User level Custom Var
    // Uses slots 6 and 7
    // It's important that nothing else goes into these slots
    _gas.push(function(){
        var i,
            _gas = window._gas,
            firstLandingDB_slot = 6,
            firstLandingPage_slot = 7,
            trackers = _gat._getTrackers(),
            prevDB, prevPage
            firstLandingPage = document.location.hostname + document.location.pathname + document.location.search,
            firstLandingDB = window.wgDBname;

        for (i=0 ; i < trackers.length ; i++){
            prevPage = trackers[i]._getVisitorCustomVar(firstLandingPage_slot);
            prevDB = trackers[i]._getVisitorCustomVar(firstLandingDB_slot);
            if(prevDB || prevPage){
                return;
            }
        }
        _gas.push(['_setCustomVar', firstLandingDB_slot, 'firstDBName', 
            firstLandingDB, 1]);
        _gas.push(['_setCustomVar', firstLandingPage_slot, 'firstPage', 
            firstLandingPage, 1]);
    });

    // Some extra logic to get the WikiHistory right
    // Keeps a list of all visited wikis.
    // The list is ordered so that the first ones are the latest ones visited
    // If the CV get's longer than 164 It may discard ols ones.
    // It's important that nothing else goes into this slot. Uses slot #10.
    _gas.push(function(){
        var _gas = window._gas,
            history_key = 'History',
            history_slot = 10,
            trackers = _gat._getTrackers(),
            history = '',
            current = window.wgDBname,
            i;

        if(!current){
            // No current found, give up
            return;
        }

        // Look for a previous history
        for (i=0 ; i < trackers.length ; i++){
            history = trackers[i]._getVisitorCustomVar(history_slot);
            if(history) break;
        }
        // If a previous history is found
        if(!!history){
            history = history.split(':');
            // Look if current site already in there and remove it
            for (i=0 ; i < history.length ; i++){
                if(history[i] === current) {
                    history.pop(i);
                    break;
                }
            }
            // Current site will be the first in the list
            history.unshift(current);
            history = history.join(':');
            // Remove duplicate colons just to be safe
            history.replace(/::/g, ':');
        }else{
            // If no previous history is found just set the current one
            history = current;
        }
        while(history_key.length + history.length > 164){
            history = history.split(':');
            history.pop();
            history = history.join(':');
        }
        _gas.push(['_setCustomVar', history_slot, history_key, history, 1]);
    });

    // Unleash
    _gas.push(['_trackPageview']);

    /**
     * Advertisement Tracker, doesn't use GAS.
     *
     * To be used for all ad impression and click events
     */

    var _gaq = window._gaq = window._gaq || [];
    // Advertisment Account UA-32129071-1
    _gaq.push(['ads._setAccount', 'UA-32129071-1']); // PROD 

    // Try to use the full domain to get a different cookie domain
    _gaq.push(['ads._setDomainName', document.location.hostname]);
    // Use allow linker to make cookies compatible in case we use the same
    _gaq.push(['ads._setAllowLinker', 'true']);

    // No pageview for this account

    /**
     * Function used by the backend to trigger advertisement events
     *
     * Will sample the advertisement hits and send them to the appropriate 
     * account.
     *
     * Has the same parameters as _trackEvent. 
     * eg:
     *    gaTrackAdEvent('Impression', 'Top Banner', 'AdId');
     *
     * @param {string} category Event Category
     * @param {string} action Event Action
     * @param {string=""} opt_value Event Label 
     * @param {number=0} opt_value Event Value. Have to be an integer. 
     * @param {boolean=false} opt_noninteractive Event noInteractive 
     */
    window.gaTrackAdEvent = function(category, action, opt_label, opt_value, 
    opt_noninteractive){
        var ad_hit_sample = 1; //1%
        if(Math.random()*100 <= ad_hit_sample){
            var args = Array.prototype.slice.call(arguments);
            args.unshift('ads._trackEvent');
            window._gaq.push(args);
        }
    };

})(window);

/**
 * @preserve Copyright 2011, Cardinal Path and DigitalInc.
 *
 * GAS - Google Analytics on Steroids
 * https://github.com/CardinalPath/gas
 *
 * @author Eduardo Cereto <eduardocereto@gmail.com>
 * Licensed under the GPLv3 license.
 */(function(a,b){function n(){var a=this;a.version="1.8",a._accounts={},a._accounts_length=0,a._queue=d,a._default_tracker="_gas1",a.gh={},a._hooks={_addHook:[a._addHook]},a.push(function(){a.gh=new c})}function o(a){return a===_gas._default_tracker?"":a+"."}function p(b){if(_gas.debug_mode)try{console.log(b)}catch(c){}return a._gaq.push(b)}function q(a,b){if(typeof a!="string")return!1;var c=a.split("?")[0];return c=c.split("."),c=c[c.length-1],c&&this.inArray(b,c)?c:!1}function s(a){while(a&&a.nodeName!=="HTML"){if(a.nodeName==="FORM")break;a=a.parentNode}return a.nodeName==="FORM"?a.name||a.id||"none":"none"}function u(a){_gas.push(["_trackEvent",this.tagName,a.type,this.currentSrc])}function z(){return a.innerHeight||m.clientHeight||e.body.clientHeight||0}function A(){return a.pageYOffset||e.body.scrollTop||m.scrollTop||0}function B(){return Math.max(e.body.scrollHeight||0,m.scrollHeight||0,e.body.offsetHeight||0,m.offsetHeight||0,e.body.clientHeight||0,m.clientHeight||0)}function C(){return(A()+z())/B()*100}function F(a){D&&clearTimeout(D);if(a===!0){E=Math.max(C(),E);return}D=setTimeout(function(){E=Math.max(C(),E)},400)}function G(){F(!0),E=Math.floor(E);if(E<=0||E>100)return;var a=(E>10?1:0)*(Math.floor((E-1)/10)*10+1);a=String(a)+"-"+String(Math.ceil(E/10)*10),_gas.push(["_trackEvent",H.category,l,a,Math.floor(E),!0])}function I(b){if(!!this._maxScrollTracked)return;this._maxScrollTracked=!0,H=b||{},H.category=H.category||"Max Scroll",this._addEventListener(a,"scroll",F),this._addEventListener(a,"beforeunload",G)}function L(a){if(!this._multidomainTracked){this._multidomainTracked=!0;var b=e.location.hostname,c=this,d,f,g,h=e.getElementsByTagName("a");a!=="now"&&a!=="mousedown"&&(a="click");for(d=0;d<h.length;d++){g=h[d];if(k.call(g.href,"http")===0){if(g.hostname==b||k.call(g.hostname,K)>=0)continue;for(f=0;f<J.length;f++)k.call(g.hostname,J[f])>=0&&(a==="now"?g.href=c.tracker._getLinkerUrl(g.href,_gas._allowAnchor):a==="click"?this._addEventListener(g,a,function(a){return _gas.push(["_link",this.href,_gas._allowAnchor]),a.preventDefault?a.preventDefault():a.returnValue=!1,!1}):this._addEventListener(g,a,function(){this.href=c.tracker._getLinkerUrl(this.href,_gas._allowAnchor)}))}}return!1}return}function R(a){P[a.player_id]||(P[a.player_id]={},P[a.player_id].timeTriggers=i.call(O));if(P[a.player_id].timeTriggers.length>0&&a.data.percent*100>=P[a.player_id].timeTriggers[0]){var b=P[a.player_id].timeTriggers.shift();_gas.push(["_trackEvent","Vimeo Video",b+"%",Q[a.player_id]])}}function S(a,b,c){if(!c.contentWindow||!c.contentWindow.postMessage||!JSON)return!1;var d=c.getAttribute("src").split("?")[0],e=JSON.stringify({method:a,value:b});return c.contentWindow.postMessage(e,d),!0}function V(a){if(k.call(a.origin,"//player.vimeo.com")>-1){var b=JSON.parse(a.data);b.event==="ready"?W.call(_gas.gh):b.method?b.method=="getVideoUrl"&&(Q[b.player_id]=b.value):b.event==="playProgress"?R(b):_gas.push(["_trackEvent",U.category,b.event,Q[b.player_id]])}}function W(){var b=e.getElementsByTagName("iframe"),c=0,d,f,g,h=U.force,i=U.percentages;for(var j=0;j<b.length;j++)if(k.call(b[j].src,"//player.vimeo.com")>-1){d="gas_vimeo_"+j,f=b[j].src,g="?",k.call(f,"?")>-1&&(g="&");if(k.call(f,"api=1")<0){if(!h)continue;f+=g+"api=1&player_id="+d}else k.call(f,"player_id=")<-1&&(f+=g+"player_id="+d);c++,b[j].id=d;if(b[j].src!==f){b[j].src=f;break}S("getVideoUrl","",b[j]),S("addEventListener","play",b[j]),S("addEventListener","pause",b[j]),S("addEventListener","finish",b[j]),i&&(O=i,S("addEventListener","playProgress",b[j]))}c>0&&T===!1&&(this._addEventListener(a,"message",V,!1),T=!0)}function _(a){if(Y&&Y.length){var b=a.getVideoData().video_id;$[b]?bb(a):($[b]={},$[b].timeTriggers=i.call(Y)),$[b].timer=setTimeout(ab,1e3,a,b)}}function ab(a,c){if($[c]==b||$[c].timeTriggers.length<=0)return!1;var d=a.getCurrentTime()/a.getDuration()*100;if(d>=$[c].timeTriggers[0]){var e=$[c].timeTriggers.shift();_gas.push(["_trackEvent",Z.category,e+"%",a.getVideoUrl()])}$[c].timer=setTimeout(ab,1e3,a,c)}function bb(a){var b=a.getVideoData().video_id;$[b]&&$[b].timer&&(ab(a,b),clearTimeout($[b].timer))}function cb(a){var b="";switch(a.data){case 0:b="finish",bb(a.target);break;case 1:b="play",_(a.target);break;case 2:b="pause",bb(a.target)}b&&_gas.push(["_trackEvent",Z.category,b,a.target.getVideoUrl()])}function db(a){_gas.push(["_trackEvent",Z.category,"error ("+a.data+")",a.target.getVideoUrl()])}function eb(){var a=e.getElementsByTagName("object"),b,c,d,f=/(https?:\/\/www\.youtube(-nocookie)?\.com[^/]*).*\/v\/([^&?]+)/;for(var g=0;g<a.length;g++){b=a[g].getElementsByTagName("param");for(var h=0;h<b.length;h++)if(b[h].name=="movie"&&b[h].value){d=b[h].value.match(f),d&&d[1]&&d[3]&&(c=e.createElement("iframe"),c.src=d[1]+"/embed/"+d[3]+"?enablejsapi=1",c.width=a[g].width,c.height=a[g].height,c.setAttribute("frameBorder","0"),c.setAttribute("allowfullscreen",""),a[g].parentNode.insertBefore(c,a[g]),a[g].parentNode.removeChild(a[g]),g--);break}}}function fb(b){var c=b.force,d=b.percentages;if(c)try{eb()}catch(f){_gas.push(["_trackException",f,"GAS Error on youtube.js:_ytMigrateObjectEmbed"])}var g=[],h=e.getElementsByTagName("iframe");for(var i=0;i<h.length;i++)if(k.call(h[i].src,"//www.youtube.com/embed")>-1){if(k.call(h[i].src,"enablejsapi=1")<0){if(!c)continue;k.call(h[i].src,"?")<0?h[i].src+="?enablejsapi=1":h[i].src+="&enablejsapi=1"}g.push(h[i])}if(g.length>0){d&&d.length&&(Y=d),a.onYouTubePlayerAPIReady=function(){var b;for(var c=0;c<g.length;c++)b=new a.YT.Player(g[c]),b.addEventListener("onStateChange",cb),b.addEventListener("onError",db)};var j=e.createElement("script"),l="http:";e.location.protocol==="https:"&&(l="https:"),j.src=l+"//www.youtube.com/player_api",j.type="text/javascript",j.async=!0;var m=e.getElementsByTagName("script")[0];m.parentNode.insertBefore(j,m)}}var c=function(){this._setDummyTracker()};c.prototype._setDummyTracker=function(){if(!this.tracker){var b=a._gat._getTrackers();b.length>0&&(this.tracker=b[0])}},c.prototype.inArray=function(a,b){if(a&&a.length)for(var c=0;c<a.length;c++)if(a[c]===b)return!0;return!1},c.prototype._sanitizeString=function(a,b){return a=a.toLowerCase().replace(/^\ +/,"").replace(/\ +$/,"").replace(/\s+/g,"_").replace(/[áàâãåäæª]/g,"a").replace(/[éèêëЄ€]/g,"e").replace(/[íìîï]/g,"i").replace(/[óòôõöøº]/g,"o").replace(/[úùûü]/g,"u").replace(/[ç¢©]/g,"c"),b&&(a=a.replace(/[^a-z0-9_-]/g,"_")),a.replace(/_+/g,"_")},c.prototype._addEventListener=function(b,c,d,e){var f=function(c){if(!c||!c.target)c=a.event,c.target=c.srcElement;return d.call(b,c)};return b.addEventListener?(b.addEventListener(c,f,!!e),!0):b.attachEvent?b.attachEvent("on"+c,f):(c="on"+c,typeof b[c]=="function"&&(f=function(a,b){return function(){a.apply(this,arguments),b.apply(this,arguments)}}(b[c],f)),b[c]=f,!0)},c.prototype._liveEvent=function(a,b,c){var d=this;a=a.toUpperCase(),a=a.split(","),d._addEventListener(e,b,function(b){for(var e=b.target;e.nodeName!=="HTML";e=e.parentNode)if(d.inArray(a,e.nodeName)||e.parentNode===null)break;e&&d.inArray(a,e.nodeName)&&c.call(e,b)},!0)},c.prototype._DOMReady=function(b){var c=this,d=function(){if(arguments.callee.done)return;arguments.callee.done=!0,b.apply(c,arguments)};if(/^(interactive|complete)/.test(e.readyState))return d();this._addEventListener(e,"DOMContentLoaded",d,!1),this._addEventListener(a,"load",d,!1)},a._gaq=a._gaq||[];var d=a._gas||[];if(d._accounts_length>=0)return;var e=a.document,f=Object.prototype.toString,g=Object.prototype.hasOwnProperty,h=Array.prototype.push,i=Array.prototype.slice,j=String.prototype.trim,k=String.prototype.indexOf,l=e.location.href,m=e.documentElement;n.prototype._addHook=function(a,b){return typeof a=="string"&&typeof b=="function"&&(typeof _gas._hooks[a]=="undefined"&&(_gas._hooks[a]=[]),_gas._hooks[a].push(b)),!1},n.prototype._execute=function(){var a=i.call(arguments),c=this,d=a.shift(),e=!0,f,h,j,l,m,n=0;if(typeof d=="function")return p(function(a,b){return function(){a.call(b)}}(d,c.gh));if(typeof d=="object"&&d.length>0){h=d.shift(),k.call(h,".")>=0?(l=h.split(".")[0],h=h.split(".")[1]):l=b,j=c._hooks[h];if(j&&j.length>0)for(f=0;f<j.length;f++)try{m=j[f].apply(c.gh,d),m===!1?e=!1:m&&m.length>0&&(d=m)}catch(q){h!=="_trackException"&&c.push(["_trackException",q])}if(e===!1)return 1;if(h==="_setAccount"){for(f in c._accounts)if(c._accounts[f]==d[0]&&l===b)return 1;return l=l||"_gas"+String(c._accounts_length+1),typeof c._accounts["_gas1"]=="undefined"&&k.call(l,"_gas")!=-1&&(l="_gas1"),c._accounts[l]=d[0],c._accounts_length+=1,l=o(l),n=p([l+h,d[0]]),c.gh._setDummyTracker(),n}if(h==="_link"||h==="_linkByPost"||h==="_require")return a=i.call(d),a.unshift(h),p(a);var r;if(l&&c._accounts[l])return r=o(l)+h,a=i.call(d),a.unshift(r),p(a);if(c._accounts_length>0){for(f in c._accounts)g.call(c._accounts,f)&&(r=o(f)+h,a=i.call(d),a.unshift(r),n+=p(a));return n?1:0}return a=i.call(d),a.unshift(h),p(a)}},n.prototype.push=function(){var b=this,c=i.call(arguments);for(var d=0;d<c.length;d++)(function(b,c){a._gaq.push(function(){c._execute.call(c,b)})})(c[d],b)},a._gas=_gas=new n,_gas.push(["_addHook","_trackException",function(a,b){return _gas.push(["_trackEvent","Exception "+(a.name||"Error"),b||a.message||a,l]),!1}]),_gas.push(["_addHook","_setDebug",function(a){_gas.debug_mode=!!a}]),_gas.push(["_addHook","_popHook",function(a){var b=_gas._hooks[a];return b&&b.pop&&b.pop(),!1}]),_gas.push(["_addHook","_gasSetDefaultTracker",function(a){return _gas._default_tracker=a,!1}]),_gas.push(["_addHook","_trackPageview",function(){var a=i.call(arguments);return a.length>=2&&typeof a[0]=="string"&&typeof a[1]=="string"?[{page:a[0],title:a[1]}]:a}]);var r=function(a){var b=this;if(!b._downloadTracked){b._downloadTracked=!0,a?typeof a=="string"?a={extensions:a.split(",")}:a.length>=1&&(a={extensions:a}):a={extensions:[]},a.category=a.category||"Download";var c="xls,xlsx,doc,docx,ppt,pptx,pdf,txt,zip";return c+=",rar,7z,exe,wma,mov,avi,wmv,mp3,csv,tsv",c=c.split(","),a.extensions=a.extensions.concat(c),b._liveEvent("a","mousedown",function(c){var d=this;if(d.href){var e=q.call(b,d.href,a.extensions);e&&_gas.push(["_trackEvent",a.category,e,d.href])}}),!1}return};_gas.push(["_addHook","_gasTrackDownloads",r]),_gas.push(["_addHook","_trackDownloads",r]),_gas.push(["_addHook","_trackEvent",function(){var a=i.call(arguments);return a[3]&&(a[3]=(a[3]<0?0:Math.round(a[3]))||0),a}]);var t=function(a){if(!!this._formTracked)return;this._formTracked=!0;var b=this;typeof a!="object"&&(a={}),a.category=a.category||"Form Tracking";var c=function(b){var c=b.target,d=c.name||c.id||c.type||c.nodeName,e=s(c),f="form ("+e+")",g=d+" ("+b.type+")";_gas.push(["_trackEvent",a.category,f,g])};b._DOMReady(function(){var a=["input","select","textarea","hidden"],d=["form"],f=[],g,h;for(g=0;g<a.length;g++){f=e.getElementsByTagName(a[g]);for(h=0;h<f.length;h++)b._addEventListener(f[h],"change",c)}for(g=0;g<d.length;g++){f=e.getElementsByTagName(d[g]);for(h=0;h<f.length;h++)b._addEventListener(f[h],"submit",c)}})};_gas.push(["_addHook","_gasTrackForms",t]),_gas.push(["_addHook","_trackForms",t]);var v=function(a){var b=this;b._liveEvent(a,"play",u),b._liveEvent(a,"pause",u),b._liveEvent(a,"ended",u)},w=function(){if(!!this._videoTracked)return;this._videoTracked=!0,v.call(this,"video")},x=function(){if(!!this._audioTracked)return;this._audioTracked=!0,v.call(this,"audio")};_gas.push(["_addHook","_gasTrackVideo",w]),_gas.push(["_addHook","_gasTrackAudio",x]),_gas.push(["_addHook","_trackVideo",w]),_gas.push(["_addHook","_trackAudio",x]);var y=function(a){if(!this._mailtoTracked)return this._mailtoTracked=!0,a||(a={}),a.category=a.category||"Mailto",this._liveEvent("a","mousedown",function(b){var c=b.target;c&&c.href&&c.href.toLowerCase&&k.call(c.href.toLowerCase(),"mailto:")===0&&_gas.push(["_trackEvent",a.category,c.href.substr(7)])}),!1;return};_gas.push(["_addHook","_gasTrackMailto",y]),_gas.push(["_addHook","_trackMailto",y]);var D=null,E=0,H;_gas.push(["_addHook","_gasTrackMaxScroll",I]),_gas.push(["_addHook","_trackMaxScroll",I]),_gas._allowAnchor=!1,_gas.push(["_addHook","_setAllowAnchor",function(a){_gas._allowAnchor=!!a}]),_gas.push(["_addHook","_link",function(a,c){return c===b&&(c=_gas._allowAnchor),[a,c]}]),_gas.push(["_addHook","_linkByPost",function(a,c){return c===b&&(c=_gas._allowAnchor),[a,c]}]);var J=[],K=b;_gas.push(["_addHook","_setDomainName",function(a){if(k.call("."+e.location.hostname,a)<0)return J.push(a),!1;K=a}]),_gas.push(["_addHook","_addExternalDomainName",function(a){return J.push(a),!1}]);var M=function(){var a=this,b=i.call(arguments);a._DOMReady(function(){L.apply(a,b)})};_gas.push(["_addHook","_gasMultiDomain",M]),_gas.push(["_addHook","_setMultiDomain",M]);var N=function(a){if(!!this._outboundTracked)return;this._outboundTracked=!0;var b=this;a||(a={}),a.category=a.category||"Outbound",b._liveEvent("a","mousedown",function(b){var c=this;if((c.protocol=="http:"||c.protocol=="https:")&&k.call(c.hostname,e.location.hostname)===-1){var d=c.pathname+c.search+"",f=k.call(d,"__utm");f!==-1&&(d=d.substring(0,f)),_gas.push(["_trackEvent",a.category,c.hostname,d])}})};_gas.push(["_addHook","_gasTrackOutboundLinks",N]),_gas.push(["_addHook","_trackOutboundLinks",N]);var O=[],P={},Q={},T=!1,U,X=function(a){var b=this;if(typeof a=="boolean"||a==="force")a={force:!!a};return a=a||{},a.category=a.category||"Vimeo Video",a.percentages=a.percentages||[],a.force=a.force||!1,U=a,b._DOMReady(function(){W.call(b)}),!1};_gas.push(["_addHook","_gasTrackVimeo",X]),_gas.push(["_addHook","_trackVimeo",X]);var Y=[],Z,$={},gb=function(a){var b=i.call(arguments);b[0]&&(typeof b[0]=="boolean"||b[0]==="force")&&(a={force:!!b[0]},b[1]&&b[1].length&&(a.percentages=b[1])),a=a||{},a.force=a.force||!1,a.category=a.category||"YouTube Video",a.percentages=a.percentages||[],Z=a;var c=this;return c._DOMReady(function(){fb.call(c,a)}),!1};_gas.push(["_addHook","_gasTrackYoutube",gb]),_gas.push(["_addHook","_trackYoutube",gb]);while(_gas._queue.length>0)_gas.push(_gas._queue.shift());_gaq&&_gaq.length>=0&&function(){var a=e.createElement("script");a.type="text/javascript",a.async=!0,a.src=("https:"==e.location.protocol?"https://ssl":"http://www")+".google-analytics.com/ga.js";var b=e.getElementsByTagName("script")[0];b.parentNode.insertBefore(a,b)}()})(window);
