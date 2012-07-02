/*
*
*   Copyright (c) Microsoft. 
*
*	This code is licensed under the Apache License, Version 2.0.
*   THIS CODE IS PROVIDED *AS IS* WITHOUT WARRANTY OF
*   ANY KIND, EITHER EXPRESS OR IMPLIED, INCLUDING ANY
*   IMPLIED WARRANTIES OF FITNESS FOR A PARTICULAR
*   PURPOSE, MERCHANTABILITY, OR NON-INFRINGEMENT.
*
*   The apache license details from 
*   ‘http://www.apache.org/licenses/’ are reproduced 
*   in ‘Apache2_license.txt’ 
*
*/

/* 
* Available Class:
* 1) extern - Includes all the properties and methods to interact with external interfaces(Ex: interacting with wikipedia APIs).
*/

//make sure the namespace exists.
if (typeof (wikiBhasha.extern) === "undefined") {
    wikiBhasha.extern = {};
}

(function() {
    //includes all the properties and methods to interact with external interfaces
    //(Ex: interacting with wikipedia APIs).
    wikiBhasha.extern.wikipediaInterface = {

        //regular expression to check wikipedia page url
        wikiPageUrlRegex: /^(http):\/\/[A-Za-z]+\.(wikipedia.org)/,

        //API to get wikipedia article
        wikiArticleMarkupAPI: "http://{0}.wikipedia.org/w/api.php?&action=query&titles={1}&rvprop=content&prop=revisions&redirects=1&format=json",

        //API to search wikipedia article
        wikiSearchAPI: "http://{0}.wikipedia.org/w/api.php?action=query&list=search&srsearch={1}&format=json",

        //API to search wikipedia article
        wikiPreviewAPI: "http://{0}.wikipedia.org/w/api.php?action=parse&text={1}&format=json",

        //API to get wikipedia language links
        wikiLangLinksAPI: "http://{0}.wikipedia.org/w/api.php?action=query&prop=langlinks&format=json&redirects=1&titles={1}&lllimit=5000",

        //API to get wikipedia article page Id
        wikiArticlePageIdAPI: "http://{0}.wikipedia.org/w/api.php?action=query&titles={1}&indexpageids&redirects=1&format=json",

        //wikipedia URL to get the article in Edit mode
        wikiEditUrl: "http://{0}.wikipedia.org/w/index.php?title={1}&action=edit",

        // wikipedia URL to get the protection information for a given article
        wikiArticleProtectionInfoAPI: "http://{0}.wikipedia.org/w/api.php?action=query&prop=info&inprop=protection&titles={1}&format=json",

        //API to get interwiki links for given titles
        wikiGetInterWikiLinksAPI: "http://{0}.wikipedia.org/w/api.php?action=query&titles={1}&prop=langlinks&lllimit=500&format=json",
        
        wikiMaxTitlesPerInterWikiLinksApi: 50,
        
        //wikipedia base URL
        wikiUrlFormat: "http://{0}.wikipedia.org/wiki/{1}",

        //wikipedia Editable 'textarea' Id/name
        wikiComposeTextArea: "wpTextbox1",

        //wikipedia Editable summery field Id/name
        wikiSummeryField: "wpSummary",

        //list of elements to be removed for publish step to give more real-estate to edit text area
        wikiEditPageNonCriticalDivs: "#mw-panel, #p-Contribuer, #p-help,#p-cactions,#centralNotice,#p-navigation,#p-logo,#firstHeading,#siteSub,#p-search,#p-interaction,#p-tb,#p-lang,#coordinates",

        //wikipedia compose area element id
        wikiComposeDiv: "#content",

        //wikipedia compose links 
        wikiComposeLinks: "#globalWrapper a",        

        //wikipedia save button id
        wikiSaveButton: "wpSave",

        //gets the corresponding source language article title for a given target language article
        getSourceTitle: function(targetLanguageCode, sourceLanguageCode, targetLanguageArticleTitle, callback) {
            this.getTargetLanguageTitle(targetLanguageCode, sourceLanguageCode, targetLanguageArticleTitle, function(data) {
                var sourceLanguageArticleTitle = (data && data.length) ? $.trim(data) : null;
                callback(sourceLanguageArticleTitle);
            });
        },

        //searches wikipedia articles for the given search key
        search: function(lang, $searchKey, callback) {            
            if (lang && lang.length && $searchKey && $searchKey.length) {
                var results = [],
                    urlData = wbUtil.stringFormat(this.wikiSearchAPI, lang, encodeURIComponent($searchKey)),
                    kbSize = 1024,
                    searchResult = "",
                    targetUrl = "";

                $.getJSON(urlData, 'callback=?', function(data) {
                    if (data && data.query && data.query.search) {
                        for (i = 0; i < data.query.search.length; i++) {
                            searchResult = data.query.search[i];
                            //opera fix:
                            //Pages displayed inside an iframe will inherit the character encoding of the parent page, unless they specify their own character encoding. 
                            //A malicious page that uses the UTF-7 character encoding can include other sites for example inside iframes. This can be exploited to perform cross-site scripting on certain sites, allowing the attacker to get access to the user's session data for those sites. 
                            //http://www.opera.com/support/kb/view/855/
                            if ($.browser.opera) {
                                targetUrl = wbUtil.stringFormat(wbWikiSite.wikiUrlFormat, lang, searchResult.title);
                            }
                            //Other browsers, open with edit url
                            else {
                                targetUrl = wbUtil.stringFormat(wbWikiSite.wikiEditUrl, lang, searchResult.title);
                            }
                            results[i] = { wikiUrlFormat: targetUrl,
                                title: searchResult.title,
                                snippet: searchResult.snippet,
                                size: Math.round((searchResult.size / kbSize), 2),
                                wordcount: searchResult.wordcount,
                                timestamp: searchResult.timestamp
                            };
                        }
                    }
                    callback(results);
                });
            }
        },

        //gets the title of target language article for given source language article title
        getTargetLanguageTitle: function(sourceLanguage, targetLanguage, sourceLanguageArticleTitle, callback) {            
            if (sourceLanguage && sourceLanguage.length && targetLanguage &&
                targetLanguage.length && sourceLanguageArticleTitle && sourceLanguageArticleTitle.length) {
                var result = "",
                    urlData = wbUtil.stringFormat(this.wikiLangLinksAPI, sourceLanguage, encodeURIComponent(sourceLanguageArticleTitle.replace("%20", " ")));

                this.getArticlePageId(sourceLanguage, sourceLanguageArticleTitle, function(pageID) {
                    if (pageID) {
                        $.getJSON(urlData, 'callback=?', function(data) {
                            var langLinkList = data.query.pages[pageID].langlinks;
                            if (langLinkList) {
                                for (i = 0; i < langLinkList.length; i++) {
                                    if (targetLanguage === langLinkList[i].lang) {
                                        result = langLinkList[i]["*"];
                                        break;
                                    }
                                }
                                callback(result);
                            }
                            else {
                                callback(null);
                            }
                        });
                    }
                    else {
                        callback(null);
                    }
                });
            }
        },

        //gets source article content in wiki format for a given article title        
        getArticleInWikiFormat: function(lang, title, callback) {            
            if (lang && lang.length && title && title.length) {
                var markupArticle = "";
                this.getArticlePageId(lang, title, function(data) {
                    if (data) {
                        var pageId = data;
                        var urlData = wbUtil.stringFormat(wbWikiSite.wikiArticleMarkupAPI, lang, encodeURIComponent(title.replace("%20", " ")));                        
                        $.getJSON(urlData, 'callback=?', function(data) {
                            if (data && data.query && data.query.pages && data.query.pages[pageId].revisions) {
                                markupArticle = data.query.pages[pageId].revisions[0]["*"];
                                callback(markupArticle);
                            } 
                            else {
                                callback(null);
                            }
                        });
                    }
                    else {
                        callback(null);
                    }
                });
            }
        },

        //checks the protection information for the given article title in the given langauge. Returns ‘true’
        //for the callback function, if the given article is protected. Otherwise returns ‘false’ for the callback function.
        isArticleProtected: function(lang, title, callback) {
            if (lang && lang.length && title && title.length) {
                var urlData = wbUtil.stringFormat(wbWikiSite.wikiArticleProtectionInfoAPI, lang, encodeURIComponent(title.replace("%20", " ")));
                $.getJSON(urlData, 'callback=?', function(data) {
                    if (data && data.query && data.query.pages) {
                        var pages = data.query.pages;
                        for (var page in pages) {
                            if (typeof pages[page].protection !== "undefined" && pages[page].protection.length > 0) {
                                callback(true);
                                return;
                            } 
                            else {
                                callback(false);
                                return;
                            }
                        }

                    } 
                    else {
                        callback(false);
                        return;
                    }
                });
            }
        },

        //gets article page Id for a given article title
        getArticlePageId: function(lang, title, callback) {            
            if (lang && lang.length && title && title.length) {
                var pageId = "",
                    urlData = wbUtil.stringFormat(this.wikiArticlePageIdAPI, lang, encodeURIComponent(title.replace("%20", " ")));                
                $.getJSON(urlData, 'callback=?', function(data) {
                    if (data && data.query && data.query.pageids) {
                        pageId = data.query.pageids[0];
                        callback(pageId);
                    }
                    else {
                        callback(null);
                    }
                });
            }
        },

        //gets inter wiki links for a given set of titles
        getInterWikiLinks: function(titles, optionalApiTags, interWikiLinksCallback) {            
            if (titles && titles.length) {
                var urlData = wbUtil.stringFormat(this.wikiGetInterWikiLinksAPI, "en", encodeURIComponent(titles.replace("%20", " ")));
                if (optionalApiTags) {
                    urlData = urlData + "&" + optionalApiTags;
                    }
                
                $.getJSON(urlData, 'callback=?', function(data) {
                    if (data) {
                        interWikiLinksCallback(data, titles);
                    }
                });
            }
        },
        
        //gets the wiki edit page URL for the given title and language code
        getEditPageUrl: function(lang, title) {
            //if all the parameters are not null
            if (lang && lang.length && title && title.length) {
                return wbUtil.stringFormat(this.wikiEditUrl, lang, encodeURIComponent(title));
            }
        },

        //gets the current article language code
        getCurrentLanguage: function() {
            return (typeof wikiSourceLanguage !== "undefined") ? wikiSourceLanguage : "en";
        },

        //checks for the given article availability in particular language.
        isArticleAvailable: function(lang, title, callback) {            
            if (lang && lang.length && title && title.length) {
                var targetArticleWikiApi = wbUtil.stringFormat(wbWikiSite.wikiArticleMarkupAPI, lang, encodeURIComponent(title.replace("%20", " ")));                               
                $.getJSON(targetArticleWikiApi, 'callback=?', function(data) {
                    var pages = data.query.pages;
                    if (pages) {
                        for (var i in pages) {
                            //if article data available
                            if (pages[i].revisions) {
                                callback(true);
                                return;
                            } 
                            else {
                                callback(false);
                                return;
                            }
                        }
                    } 
                    else {
                        callback(false);
                    }
                });
            }
        },

        //gets current page article title
        //NOTE: we need to depend on wikipedia's javascript variables to get current article title
        getCurrentArticleTitle: function() {            
            if (typeof wgTitle !== "undefined") {
                if (wgAction === "view" && wgArticleId === 0 && wgIsArticle === false) {
                    return false;
                }
                //in addition to the page title, get the name space also if it exists.
                if (typeof wgCanonicalNamespace !== "undefined" && wgCanonicalNamespace.length > 0) {
                    return wgCanonicalNamespace + ":" + wgTitle;
                }
                return wgTitle;
            }
        },

        //checks whether current page is wikipedia main page or not
        //NOTE: we need to depend on wikipedia's javascript variables to check whether current page is main page or not
        isWikiMainPage: function() {
            return ((typeof wgPageName !== "undefined") && ((wgPageName === wgMainPageTitle) || (wgTitle === wgMainPageTitle))) ? true : false;
        },

        //checks whether current domain is wikipedia or not
        isWikiDomain: function(url) {
            return (url.match(this.wikiPageUrlRegex) === null) ? false : true;
        },
         //function to view the preview of the edited article
        getPreviewContent: function(lang, composeText, callback) {
            urlData = wbUtil.stringFormat(wbWikiSite.wikiPreviewAPI, lang, encodeURIComponent(composeText.replace(/<br>/gi, '').replace(/<br\/>/ig, '').replace('\'\'', '\'')).replace(/'/g, '%27'));
            $.getJSON(urlData, 'callback=?', function(data) {
                if (data && data.parse && data.parse.text) {
                    callback(data.parse.text['*']);
                }else{
                    callback(false);
                }
            });
        }
    };
})();