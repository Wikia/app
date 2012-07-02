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

//* Available Classes:
//* 1) splashWindow     - Describes the splash window for the application, to notify the user that the application is in the process of loading.
//*
//* Available Methods:
//* 1) loadApplicationRequiredFiles   - wikiBhasha function to download application styles and JavaScript files
//* 2) loadLocalizedStrings           - load localized strings(javascript file) as per user settings
//* 3) loadJQuery                     - loads jQuery library.
//* 4) loadApplication                - initiates the application load on UI, once the required JavaScript,CSS and localized strings are loaded.

//make sure the base namespace exists.
if (typeof (wikiBhasha) === "undefined") {
    wikiBhasha = {};
}

// settings for enabling debug mode to get asserts & debug breaks when an assert expression fails.
// for production, debugMode is set to false. Change it to true when debugging application.
wikiBhasha.debugMode = false;
wikiBhasha.debugHelper = {};
wikiBhasha.debugHelper.assertExpr = (wikiBhasha.debugMode) ?
    function(expr, message) { if (!expr) { alert(message || "debug assert failed"); debugger; } }
    : function() { };

//initiates the application load on UI, once the required JavaScript,CSS and localized strings are loaded.
wikiBhasha.loadApplication = function() {

    //remove 'loading...' div after successful call of wikiBhasha.
    $("#wbLoadDiv").remove();

    //describes whether current domain is 'Wikipedia' or not.
    var isWikipediaDomain = true,
        currentLanguageCode = wbWikiSite.getCurrentLanguage();

    //set the current domain is Wikipedia or not
    isWikipediaDomain = wbWikiSite.isWikiDomain(document.location.href);

    //avoid launching of application on non-wiki domain articles and on any special pages from Wikipedia.
    if ((wbWikiSite.isWikiMainPage()) || (typeof wbWikiSite.getCurrentArticleTitle() == "undefined")
                || (!wbWikiSite.getCurrentArticleTitle()) || wgNamespaceNumber != 0) {
        window.alert(wbLocal.nonWikiDomainMsg);
        return;
    }

    //set the direction for the content. Eg: Arabic, Hebrew are with orientation of right to left.
    wbGlobalSettings.direction = (wbGlobalSettings.isLanguageRTL(currentLanguageCode)) ? "rtl" : "ltr";


    //set target language, if current language code is not english 
    if (currentLanguageCode !== wbGlobalSettings.sourceLanguageCode) {
        wbGlobalSettings.targetLanguageCode = currentLanguageCode;
        if (currentLanguageCode === 'zh') {
            var urlGetMltCode = wbUtil.getQueryStringValue('mltCode');
            if (urlGetMltCode) {
                wbGlobalSettings.mtTargetLanguageCode = urlGetMltCode;
            }
        } else {
            wbGlobalSettings.mtTargetLanguageCode = currentLanguageCode;
        }
    }

    if (isWikipediaDomain) {

        if (currentLanguageCode === 'en' && !wgArticleId) {
            //check if the user clicked title exists in Wikipedia or not
            wbUIHelper.hideLightBox();
            window.alert(wbLocal.noSourceArticleFound);
            return false;
        }

        //display language selection window if current article language code and target article language code both are english
        if (currentLanguageCode == wbGlobalSettings.sourceLanguageCode) {
            try {
                wbUIHelper.hideScroll();
                wbUIHelper.showLightBox();

                //display language selection window
                //if application is launched in source language article from the same language application link
                if (wbGlobalSettings.targetLanguageCode == wbGlobalSettings.sourceLanguageCode) {
                    wikiBhasha.windowManagement.languageSelectionWindow.show(true /*show the language dropdown*/);
                }
                else {
                    wikiBhasha.windowManagement.languageSelectionWindow.show(false /*hide the language dropdown*/);
                }
                return;
            }
            catch (e) {
                wbUIHelper.hideLightBox();
                window.alert(wbLocal.failureMsg + "\n" + e);
                return;
            }
        }
        //invalid application link clicked,
        //if current article language and target language code are different
        else if ((currentLanguageCode != wbGlobalSettings.sourceLanguageCode) &&
                  (currentLanguageCode != wbGlobalSettings.targetLanguageCode) &&
                  (wbGlobalSettings.targetLanguageCode != wbGlobalSettings.sourceLanguageCode)) {
            wbUIHelper.hideLightBox();
            window.alert(wbLocal.invalidBookmarklet);
            return;
        }
    }

    //check the current language is supported by application or not.
    if (!(wbGlobalSettings.isWikiBhashaSupportedLanguage(wbGlobalSettings.mtTargetLanguageCode))) {
        window.alert(wbLocal.unSupportedLanguage);
        return;
    }

    wbGlobalSettings.setTargetLanguageValues();

    //set source title, if target language code is english
    if (currentLanguageCode == wbGlobalSettings.sourceLanguageCode) {
        wbGlobalSettings.sourceLanguageArticleTitle = decodeURIComponent($.trim(wbWikiSite.getCurrentArticleTitle()));
    }
    //set target title, if target language code is other than english
    else {
        wbGlobalSettings.targetLanguageArticleTitle = decodeURIComponent($.trim(wbWikiSite.getCurrentArticleTitle()));
    }

    //if source title is empty, try to get new article title from browser Url (New article)
    if (wbGlobalSettings.sourceLanguageArticleTitle.length == 0) {
        var newArticleKey = "wbTitle",
        //new article title from query string
            sTitle = wbUtil.getQueryStringValue(newArticleKey);
        if (sTitle && sTitle.length && sTitle.length > 0) {
            wbGlobalSettings.sourceLanguageArticleTitle = decodeURIComponent($.trim(sTitle));
            wbGlobalSettings.isNewArticle = true;
        }
    }

    //load application window with source and target articles
    try {
        wbSplash.show();
        wbMainWindow.show();
    }
    catch (e) {
        wbSplash.close();
        window.alert(wbLocal.failureMsg + "\n" + e);
    }
};

//describes the splash window for the application, to notify the user that the 
//application is in the process of loading.
wikiBhasha.splashWindow = {
    //splash window div Id.
    windowId: "wbSplashWindow",
    //creates and displays splash window on application UI
    show: function() {
        wbUIHelper.blockUI();
        wbUIHelper.createWindow(this.windowId, wbGlobalSettings.splashWindowHTML);
    },

    //hides and removes splash window from application UI
    close: function() {
        wbUIHelper.unblockUI();
        $("#" + this.windowId).remove();
    }
};

//shortcut to call wikiBhasha.splashWindow window
wbSplash = wikiBhasha.splashWindow;

//downloads styles and JavaScript files for application
wikiBhasha.loadApplicationRequiredFiles = function() {

    //if jQuery object is loaded and '$' symbol is not defined then assign jQuery object to '$' symbol
    //in wikiPedia article '$' is set to 'undefined' by some tracking code, so we need to reassign 
    //jQuery object to '$' for normal use.
    if (typeof $ == 'undefined' && typeof jQuery != 'undefined') {
        $ = jQuery;
    }

    function attachStyle(url, id /*[Optional]*/) {
        if (url && url.length > 0) {
            var head = document.getElementsByTagName("head")[0];
            var link = document.createElement("link");
            if (id) {
                link.id = id;
            }
            link.type = "text/css";
            link.rel = "stylesheet";
            link.media = "screen";
            link.href = url;
            head.appendChild(link);
        }
    };

    if (typeof baseUrl != "undefined") {
        //wikiBhasha application css files
        var reqCSS = ["styles/jquery-ui-1.7.2.css",
                    "styles/hybridModeStyles.css",
                    "styles/wikiBhasha.css"],

        //files required for loading language selection window
            reqJSForLanguageSelection = ["js/jsLib/jquery-ui-1.7.2.min.js",
                    "js/extern/wikipediaInterface.js",
                    "js/extern/languageServicesInterface.js",
                    "js/extern/loggerInterface.js",
                    "js/core/configurations.js",
                    "js/core/configurations.templateMappers.js",
                    "js/core/globalSettings.js",
                    "js/core/languageSelectionWindow.js",
                    "js/core/utils.js"],

        //files required for loading complete application
            reqJSForCoreApplication = ["js/jsLib/jquery-ui-1.7.2.min.js",
                    "js/jsLib/jquery.contextmenu.js",
                    "js/jsLib/jquery.shortcut.js",
                    "js/extern/wikipediaInterface.js",
                    "js/extern/languageServicesInterface.js",
                    "js/extern/transliterationServicesInterface.js",
                    "js/extern/loggerInterface.js",
                    "js/extern/shareOnExternSystems.js",
                    "js/extern/shortenURL.js",
                    "js/core/configurations.js",
                    "js/core/configurations.templateMappers.js",
                    "js/core/globalSettings.js",
                    "js/core/historyManagement.js",
                    "js/core/mainWindow.js",
                    "js/core/paneManagement.js",
                    "js/core/scratchpadWindow.js",
                    "js/core/shareWikiBhasha.js",
                    "js/core/feedbackWindow.js",
                    "js/core/searchWindow.js",
                    "js/core/wikiMarkupEditWindow.js",
                    "js/core/templateAndLinkTranslator.js",
                    "js/core/themes.js",
                    "js/core/utils.js",
                    "js/core/wikiModeConverters.js",
                    "js/core/chineaseLangSelection.js",
                    "js/core/wikiParser.js"],

        //wikiBhasha default theme
            themeCss = ["styles/themes/wikiBhasha.blue.css"];

        //load css files
        for (var i = 0; i < reqCSS.length; i++) {
            //create url
            var url = baseUrl + reqCSS[i];
            //attach other style expect themes
            attachStyle(url);
        }

        //load themes css files
        for (var i = 0; i < themeCss.length; i++) {
            //create url
            var url = baseUrl + themeCss[i],
                id = "wbCSSBlue";
            attachStyle(url, id);
        }

        //load javascript files
        var fileCount = 0,
        //check whether source language is 'english' or not. if so then load the language selection window else complete application files
            reqJS = (wikiSourceLanguage == "en") ? reqJSForLanguageSelection : reqJSForCoreApplication;
        for (var i = 0; i < reqJS.length; i++) {
            var url = baseUrl + reqJS[i];
            $.getScript(url, function() {
                fileCount = fileCount + 1;
                //check if all the files are loaded
                if (fileCount == reqJS.length) {
                    //download strings after downloading all application files
                    wikiBhasha.loadLocalizedStrings();
                }
            });
        }
    }
};

//loads localized strings(javascript file) as per user settings
wikiBhasha.loadLocalizedStrings = function() {
    // set global values
    wbGlobalSettings.baseUrl = baseUrl;
    wbGlobalSettings.targetLanguageCode = targetLanguageCode;
    wbGlobalSettings.userLanguageCode = wbGlobalSettings.getUserLanguage();

    //create localized string file URL
    var url = wbGlobalSettings.baseUrl + wbGlobalSettings.languageFolder + wbGlobalSettings.userLanguageCode + "/strings.js";
    $.getScript(url, function() {
        try {
            // Initialize configurations and create session first.
            wikiBhasha.configurations.initialize();
            wbUIHelper.createSession();

            var curLangCode = wbWikiSite.getCurrentLanguage();
            if (curLangCode != wbGlobalSettings.sourceLanguageCode) {
                // Check if the article is protected. If so, don’t allow the user to edit it. Just show the message and close WikiBhasha. Otherwise proceed further to load the page in WikiBhasha.
                wbWikiSite.isArticleProtected(curLangCode, $.trim(wbWikiSite.getCurrentArticleTitle()), function(isArticleProtected) {
                    if (isArticleProtected) {
                        window.alert(wbLocal.nonEditableMessage);
                        //remove 'loading...' div after successful call of wikiBhasha.
                        $("#wbLoadDiv").remove();
                    } else {
                        if (curLangCode === 'zh') {
                            var urlGetMltCode = wbUtil.getQueryStringValue('mltCode');
                            if (!urlGetMltCode) {
                                $("#wbLoadDiv").remove();
                                wbChineseLangSelection.show();
                                return;
                            }
                        }
                        wikiBhasha.loadApplication();
                    }
                    return;
                });
            } else {
                wikiBhasha.loadApplication();
            }
            return;
        }
        catch (e) {
            window.alert(wbLocal.failureMsg + "\n" + e);
            return;
        }
    });
};

// load jquery library if it is not downloaded yet
// We require separate function for loading jQuery because this should not use any jQuery methods by itself.
// NOTE: Never use any jQuery functions within this function.
wikiBhasha.loadJQuery = function (callback) {
    if (typeof baseUrl != "undefined") {
        var script = document.createElement("script");
        script.type = "text/javascript";
        //check whether file is loaded or not if so, call the the 'callback' function
        //IE fix, in IE 'readyState' event is fired once the file is loaded
        if (script.readyState) {
            script.onreadystatechange = function () {
                if (script.readyState == "loaded" ||
                    script.readyState == "complete") {
                    script.onreadystatechange = null;
                    callback();
                }
            };
        }
        //other browsers, 'onload' event will be fired
        else {
            script.onload = function () {
                callback();
            };
        }
        script.src = baseUrl + "js/jsLib/jquery-1.4.4.min.js";
        document.body.appendChild(script);
    }
};

//load jquery library if it is not loaded
if (typeof jQuery === "undefined") {
    //after loading jQuery load other required files only after some time gap(ex:100ms), assuming that jQuery will take some time to load into browser.
    wikiBhasha.loadJQuery(function() { window.setTimeout("wikiBhasha.loadApplicationRequiredFiles()", 100); });
} else {
    wikiBhasha.loadApplicationRequiredFiles();
}