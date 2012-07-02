
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
Available Classes:
1) globalSettings   - Includes all the global settings and the methods manipulating these settings. 
                      Also inclused HTML for the UI components of application.
*/

// Make sure the base namespace exists.
if (typeof (wikiBhasha.configurations) === "undefined") {
    wikiBhasha.configurations = {};
}

(function() {
    // includes all the global settings and the methods manipulating these settings. 
    // also inclused HTML for the UI components of application.
    wikiBhasha.configurations.globalSettings = {
        //application name
        applicationName: "WikiBhasha (Beta)",

        //application version
        applicationVersion: "1.0 beta",
        
        //image base url: in case of using default path pass 'false' to this variable
        imgBaseUrl: false,

        //application base URL
        baseUrl: "",

        //language string files folder path
        languageFolder: "lang/",

        //themes css folder path
        themesFolder: "styles/themes/",        
      
        //user language code, english by default
        userLanguageCode: "en",

        //source language code, english by default
        sourceLanguageCode: "en",        
        
        //target language code
        targetLanguageCode: "",

        //Microsoft Translator specific target language code
        mtTargetLanguageCode: "",

        //target language name, english by default
        $targetLanguageName: "english",

        //target language name in native language, english by default
        targetLanguageDisplayName: "english",

        //target language article title
        targetLanguageArticleTitle: "",
        
        //source language article title
        sourceLanguageArticleTitle: "",

        //whether the article is new
        isNewArticle: false,

        //email id where user can send feedback on WikiBhasha
        feedbackEmail: "wikibfb@microsoft.com",

        //id of current session
        sessionId: 0,
    
        //string to be append at the end of cutoff string.
        suffixStringForCutoffString: "...",
        
        //cutoff length to be used for pane titles
        paneTitleCutoffLength: 100,

        //cutoff length to be used for edit page summery field
        summeryFieldCutoffLength: 200,

        //WikiBhasha usage monitoring summery field snipet
        snippet: "<<WB1.1>>",

        //max length of characters allowed by scratch pad window
        scratchpadTextMaxLength: 1600,        

        //application window UI variables
        $contentHeight: 0,
        $transWinLeft: 0,
        $transWinTop: 0,
        $transDivWidth: 0,
        $transDivHeight: 0,

        //pane constant and values
        //minimum width on pane collapse
        collapsePaneWidth: 65,
        //right pane minimum width
        rightPaneMinWidth: 420,
        //left pane minimum width
        leftPaneMinWidth: 360,
        //panes' content margin constant
        contentMargin: 9,
        //pane padding constant when collapsed
        collapsePanePadding: 25,
        //panes' top padding constant
        panesTopPadding: 85,
        
        //splitter related constants
        splitterMargin: 5,        
        $splitterWidth: 10,
        splitContainerBottomPadding: 10,
      
        //microsoft translation progress bar height constant
        translationBarHeight: 40,

        //max length for input fields
        inputTextMaxLength: 100,

        //"Enter" key code
        enterKeyCode: 13,
        
        //default class name to be applied on pane title toolbars in main application UI
        paneTitleToolBarDefaultClass: "wbWindowToolbarCenter",

        //array of microsoft translator supported languages. [language name, language code, display text]
        mtlLanguages: [ ['Arabic', 'ar', 'العربية'],
                        ['Bulgarian', 'bg', 'български'],
                        ['Czech', 'cs', 'čeština'],
                        ['Danish', 'da', 'Dansk'],
                        ['German', 'de', 'Deutsch'],
                        ['English', 'en', 'English'],
                        ['Estonian', 'et', 'Eesti'],
                        ['Greek', 'el', 'ελληνικά'],
                        ['Spanish', 'es', 'Español'],
                        ['French', 'fr', 'Français'],
                        ['Korean', 'ko', '한국어'],
                        ['Hindi', 'hi', 'हिन्दी'],
                        ['Indonesian', 'id', 'Bahasa Indonesia'],
                        ['Italian', 'it', 'Italiano'],
                        ['Hebrew', 'he', 'עברית'],
                        ['HaitianCreole', 'ht', 'Kreyòl ayisyen'],
                        ['Latvian', 'lv', 'Latviešu'],
                        ['Lithuanian', 'lt', 'Lietuvių'],
                        ['Hungarian', 'hu', 'Magyar'],
                        ['Dutch', 'nl', 'Nederlands'],
                        ['Japanese', 'ja', '日本語'],
                        ['Norwegian', 'no', 'Norsk'],
                        ['Polish', 'pl', 'Polski'],
                        ['Portugese', 'pt', 'Português'],
                        ['Romanian', 'ro', 'Română'],
                        ['Russian', 'ru', 'Русский'],
                        ['Slovak', 'sk', 'Slovenčina'],
                        ['Slovenian', 'sl', 'Slovenščina'],
                        ['Finnish', 'fi', 'Suomi'],
                        ['Swedish', 'sv', 'Svenska'],
                        ['Tamil', 'ta', 'தமிழ்'],
                        ['Thai', 'th', 'ไทย'],
                        ['Turkish', 'tr', 'Türkçe'],
                        ['Ukrainian', 'uk', 'Українська'],
                        ['Vietnamese', 'vi', 'Tiếng Việt'],
                        ['ChineseSimplified', 'zh-CHS', '简体中文'],
                        ['ChineseTraditional', 'zh-CHT', '繁體中文']
                       ],

        //array of localized languages supported by application.[language name, language code]
        localizedLanguages: [['English', 'en'],
                             ['German', 'de']],

        //array of right to left oriented languages supported by the application
        rtlLanguages: [['Hebrew', 'he'],
                        ['Arabic', 'ar']],

        //checks if the given language is supported by the translator
        isWikiBhashaSupportedLanguage: function(language) {
            var result = false;
            $.each(wbGlobalSettings.mtlLanguages, function(intIndex, wbValue) {
                if (language === wbValue[1]) {
                    result = true;
                }
            });
            return result;
        },

        //checks if the given language is RTL or LTR oriented
        isLanguageRTL: function(language) {
            var result = false;
            $.each(wbGlobalSettings.rtlLanguages, function(intIndex, wbValue) {
                if (language === wbValue[1]) {
                    result = true;
                }
            });
            return result;
        },

        //gets the user selected language, checks whether localized string are available for the same.
        //if not sets 'english' as default
        getUserLanguage: function() {
            var userlanguage = wbGlobalSettings.targetLanguageCode;
            //check user language is supporting localization or not, if not display English
            if (!(this.areLocalizedStringsAvailable(userlanguage)) || (null === userlanguage)) {
                userlanguage = wbGlobalSettings.sourceLanguageCode;
            }
            return userlanguage;
        },

        //sets target language name and display name as per current language code        
        setTargetLanguageValues: function() {
            $.each(wbGlobalSettings.mtlLanguages, function(intIndex, languageValues) {
                if (wbGlobalSettings.mtTargetLanguageCode == languageValues[1]) {
                    wbGlobalSettings.$targetLanguageName = languageValues[0];
                    wbGlobalSettings.targetLanguageDisplayName = languageValues[2];
                }
            });
        },

        //checks the user selected language is supported by the application for localization, if not selects english as default.
        areLocalizedStringsAvailable: function(userlanguage) {
            var result = false;
            $.each(wbGlobalSettings.localizedLanguages, function(intIndex, objValue) {
                if (userlanguage === objValue[1]) {
                    result = true;
                }
            });
            return result;
        },
        
        //holds number of times the currently loaded target article been edited through wikiBhasha 
        wbEditRevisionCount: null,

        noWikiAPIcall:null,
        noWikiAPIcallback:null,

// Below lines are automatically generated code. DO NOT CHANGE MANUALLY.
//Don not delete below comment as it needed by the HTML Engine to insert HTML code from HTML files.

/*HTML BLOCK BEGIN*/

applicationWindowHTML:'<div id="wbTranslationDiv" >\
<div id="wbLeftMouseOverArea"></div>\
<div id="wbRightMouseOverArea"></div>\
<table id="wbTranslationTable" style="vertical-align:top;" height="100%" width="100%" border="0" cellspacing="0" cellpadding="0" >\
<tr>\
<td class="wbBgTopLeft"><img src="../images/trans.gif" width="8" height="8" alt="" /></td>\
<td class="wbBgTopRight"><img src="../images/trans.gif" width="8" height="8" alt="" /></td>\
</tr>\
<tr>\
<td class="wbBgContentArea" style="vertical-align:top;" >\
<div class="wbLogoContainer" ></div>\
<div class="wbTopButtonsDiv" oncontextmenu="return false;">\
<table style="background-color:Transparent;">\
<tr id="wbHistoryInfo">\
<td>\
<table style="background-color:Transparent;">\
<tr>\
<td style="text-align:right;padding-left:25px" id="wbHistoryLabel" nowrap>History</td>\
<td>\
<select name="History:" id="wbHistoryContainer"  class="wbHistorySelect" tabindex="0">\
</select>\
</td>\
</tr>\
</table>\
</td>\
<td>\
<div id="wbTopIcons">\
<ul>\
<li style="width:20px"></li>\
<li><a id="wbSearchButton" class="wbSearchButton" href="#" title="Search" tabindex="0"></a></li>\
<li><a id="wbScratchPadBtn" class="wbScratchPadButton" href="#" title="Scratch Pad" tabindex="0"></a></li>\
<li style="width:20px"></li>\
<li><a id="wbBlue" class="wbBlueSelectedIcon" href="#" title="Theme Blue" tabindex="0"></a></li>\
<li><a id="wbSilver" class="wbSilverIcon" href="#" title="Theme Silver" tabindex="0"></a></li>\
<li><a id="wbBlack" class="wbBlackIcon" href="#" title="Theme Black" tabindex="0"></a></li>\
<li style="width:20px"></li>\
<li><a id="wbFeedbackButton" title="Feedback" href="#" class="wbFeedbackButton" tabindex="0"></a></li>\
<li><a id="wbHelpLink" class="wbHelp" href="#" title="Help" tabindex="0"></a></li>\
<li><a id="wbMaximizeLink" class="wbMaximize" href="#" title="Maximize" tabindex="0"></a></li>\
<li><a id="wbExitLink" class="wbClose" href="#" title="Close" tabindex="0"></a></li>\
</ul>\
</div>\
</td>\
</tr>\
</table>\
</div>\
<div class="wbContentContainer">\
<div id="wbPreviousButton">\
<span id="wbPreviousButtonText">Previous</span>\
</div>\
<div id="wbNextButton">\
<span id="wbNextButtonText">Next</span>\
</div>\
<div class="workflowNavigationBtns" id="workflowNavigationBtns">\
<table id="workflowNavigationBtnsTable" cellpadding="0" cellspacing="0">\
<tr>\
<td class="workflowNavigationBtnsCentre" valign="middle">\
<table cellpadding=0 cellspacing=0>\
<tr id="workFlowStepBtns">\
<td><div class="workFlowBtnNormal">1. Research</div></td>\
<td><div class="workFlowBtnClicked">2. Compose</div></td>\
<td><div class="workFlowBtnNormal">3. Publish</div></td>\
</tr>\
</table>\
</td>\
</tr>\
</table>\
</div>\
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="vertical-align:top;background-color:Transparent;" id="wbTwoPaneOuterWrapper">\
<tr valign="top">\
<td>\
<div id="wbSplitter">\
<div id="wbLeftPane">\
<div id="wbLeftWindowCollapsed" style="display:none" class="wbLeftWindowCollapsed">\
<div style="height:25px;">\
</div>\
<table id="wbLeftCollapsedTable" width="65px" border="0" cellspacing="0" cellpadding="0" class="wbTableBackground">\
<tr>\
<td class="wbWindowTopLeft"><img src="../images/trans.gif" width="4" height="4" alt="" /></td>\
<td class="wbWindowTopCenter"><img src="../images/trans.gif" width="4" height="3" alt="" /></td>\
<td class="wbWindowTopRight"><img src="../images/trans.gif" width="4" height="4" alt="" /></td>\
</tr>\
<tr>\
<td class="wbWindowToolbarLeft"><img src="../images/trans.gif" width="3" height="3" alt="" /></td>\
<td class="wbCollapseWindowToolbarCenter">\
<div class="wbToolbarRightIcons">\
<input name="" id="wbLeftCollapsedBtn" type="button" value=" "  class="wbCollapseRightButton" />\
</div>\
</td>\
<td class="wbWindowToolbarRight"><img src="../images/trans.gif" width="3" height="3" alt="" /></td>\
</tr>\
<tr>\
<td class="wbWindowContentLeft"><img src="../images/trans.gif" width="3" height="3" alt="" /></td>\
<td class="wbWindowContentCenter"></p>\
<div id="wbLeftCollapseContentDiv" class="wbLeftWindowContent" style="width:50px;"></div>\
</td>\
<td class="wbWindowContentRight"><img src="../images/trans.gif" width="3" height="3" alt="" /></td>\
</tr>\
<tr>\
<td class="wbWindowBottomLeft"><img src="../images/trans.gif" width="4" height="4" alt="" /></td>\
<td class="wbWindowBottomCenter"><img src="../images/trans.gif" width="4" height="3" alt="" /></td>\
<td class="wbWindowBottomRight"><img src="../images/trans.gif" width="4" height="4" alt="" /></td>\
</tr>\
</table>\
</div>\
<div id="wbLeftWindow">\
<div id="wbLeftHeaderDiv" class="wbHeader" style="height:20px;">\
</div>\
<table  width="100%" border="0" cellspacing="0" cellpadding="0" class="wbTable">\
<tr>\
<td class="wbWindowTopLeft"><img src="../images/trans.gif" width="4" height="5" alt="" /></td>\
<td class="wbWindowTopCenter"><img src="../images/trans.gif" width="4" height="3" alt="" /></td>\
<td class="wbWindowTopRight"><img src="../images/trans.gif" width="4" height="5" alt="" /></td>\
</tr>\
<tr>\
<td class="wbWindowToolbarLeft"><img src="../images/trans.gif" width="3" height="3" alt="" /></td>\
<td class="wbWindowToolbarCenter">\
<div id="wbSourceTabHeaderDiv" class="wbToolbarLeftIcons">\
<div id="wbLeftPaneTitle"></div>\
</div>\
<div class="wbToolbarRightIcons">\
<input id="wbCollapseLeftWindowBtn" type="button" class="wbCollapseButton" tabindex="0" />\
</div>\
</td>\
<td class="wbWindowToolbarRight"><img src="../images/trans.gif" width="3" height="3" alt="" /></td>\
</tr>\
<tr>\
<td class="wbWindowContentLeft"><img src="../images/trans.gif" width="3" height="3" alt="" /></td>\
<td valign="top" class="wbWindowContentCenter">\
<div id="wbLeftWindowContentDiv" class="wbLeftWindowContent">\
<div id="wbSourceArticleContentDiv" style="word-wrap:break-word;"/>\
</div>\
</td>\
<td class="wbWindowContentRight"><img src="../images/trans.gif" width="3" height="3" alt="" /></td>\
</tr>\
<tr>\
<td class="wbWindowBottomLeft"><img src="../images/trans.gif" width="4" height="4" alt="" /></td>\
<td class="wbWindowBottomCenter"><img src="../images/trans.gif" width="4" height="3" alt="" /></td>\
<td class="wbWindowBottomRight"><img src="../images/trans.gif" width="4" height="4" alt="" /></td>\
</tr>\
</table>\
</div>\
</div>\
<div id="wbHandleDiv" style="z-index:1001;position:absolute;height:100%;width:5px;cursor:e-resize" >\
<div style="height:32px;"> </div>\
<div class="wbSplitter">\
</div>\
</div>\
<div id="wbRightPane">\
<div id="wbRightWindowCollapsed" style="display:none" class="wbRightWindowCollapsed">\
<div style="height:25px;">\
</div>\
<table id="wbRightCollapsedTable" width="65px" border="0" cellspacing="0" cellpadding="0" class="wbTableBackground">\
<tr>\
<td class="wbWindowTopLeft"><img src="../images/trans.gif" width="4" height="4" alt="" /></td>\
<td class="wbWindowTopCenter"><img src="../images/trans.gif" width="4" height="3" alt="" /></td>\
<td class="wbWindowTopRight"><img src="../images/trans.gif" width="4" height="4" alt="" /></td>\
</tr>\
<tr>\
<td class="wbWindowToolbarLeft"><img src="../images/trans.gif" width="3" height="3" alt="" /></td>\
<td class="wbCollapseWindowToolbarCenter">\
<div class="wbToolbarRightIcons">\
<input name="" id="wbRightCollapsedBtn" type="button" value=" " class="wbCollapseButton"  tabindex="0"/>\
</div>\
</td>\
<td class="wbWindowToolbarRight"><img src="../images/trans.gif" width="3" height="3" alt="" /></td>\
</tr>\
<tr>\
<td class="wbWindowContentLeft"><img src="../images/trans.gif" width="3" height="3" alt="" /></td>\
<td class="wbWindowContentCenter">\
<div id="wbRightCollapseContentDiv" class="wbLeftWindowContent" style="width:50px;"></div>\
</td>\
<td class="wbWindowContentRight"><img src="../images/trans.gif" width="3" height="3" alt="" /></td>\
</tr>\
<tr>\
<td class="wbWindowBottomLeft"><img src="../images/trans.gif" width="4" height="4" alt="" /></td>\
<td class="wbWindowBottomCenter"><img src="../images/trans.gif" width="4" height="3" alt="" /></td>\
<td class="wbWindowBottomRight"><img src="../images/trans.gif" width="4" height="4" alt="" /></td>\
</tr>\
</table>\
</div>\
<div id="wbRightWindow">\
<div class="wbHeader" style="height:25px;">\
<div class="wikiModeSwitcher">\
<label id="wbToggleCTFLabel" for="wbToggleCTF"><input id="wbToggleCTF" type="checkbox" tabindex="0" />Disable Translation Popup</label>\
<label id="wbToggleLabel" for="wbToggleWikiFormat"><input id="wbToggleWikiFormat" type="checkbox" tabindex="0" />Show Wikiformat</label>\
</div>\
</div>\
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="wbTable">\
<tr>\
<td class="wbWindowTopLeft"><img src="../images/trans.gif" width="4" height="4" alt="" /></td>\
<td class="wbWindowTopCenter"><img src="../images/trans.gif" width="4" height="3" alt="" /></td>\
<td class="wbWindowTopRight"><img src="../images/trans.gif" width="4" height="4" alt="" /></td>\
</tr>\
<tr>\
<td class="wbWindowToolbarLeft"><img src="../images/trans.gif" width="3" height="3" alt="" /></td>\
<td class="wbWindowToolbarCenter">\
<div class="wbRightPanetoolbarLefticons">\
<input id="wbCollapseRightWindowBtn" type="button" class="wbCollapseRightButton" tabindex="0"/>\
<div id="wbRightPaneTitle"></div>\
</div>\
<div id="wbTargetTabHeaderDiv" class="wbRightPanetoolbarRighticons" >\
<input id="wbConvertEntireArticleBtn" type="button" value="Get the entire article from Source" class="wbGetEntireButton" tabindex="0"/>\
</div>\
</td>\
<td class="wbWindowToolbarRight"><img src="../images/trans.gif" width="3" height="3" alt="" /></td>\
</tr>\
<tr>\
<td class="wbWindowContentLeft"><img src="../images/trans.gif" width="3" height="3" alt=""  /></td>\
<td valign="top" class="wbWindowContentCenter">\
<div id="wbRightWindowContentDiv" class="wbRightWindowContent" >\
<div id="wbTargetArticleComposeDiv" style="word-wrap:break-word;">\
<iframe id="wbComposeIFrame"></iframe>\
</div>\
<div id="wbPreviewLoading" class="wbLoadingDiv"><img src="../images/loading.gif" alt="loading"/> Loading..</div>\
<div id="wbTargetArticlePreviewDiv" />\
</div>\
</td>\
<td class="wbWindowContentRight"><img src="../images/trans.gif" width="3" height="3" alt="" /></td>\
</tr>\
<tr>\
<td class="wbWindowBottomLeft"><img src="../images/trans.gif" width="4" height="4" alt="" /></td>\
<td class="wbWindowBottomCenter"><img src="../images/trans.gif" width="4" height="3" alt="" /></td>\
<td class="wbWindowBottomRight"><img src="../images/trans.gif" width="4" height="4" alt="" /></td>\
</tr>\
</table>\
</div>\
</div>\
</div>\
</td>\
</tr>\
</table>\
</div>\
</td>\
<td class="wbBgContentAreaRight"></td>\
</tr>\
<tr>\
<td class="wbBgBottomLeft"><img src="../images/trans.gif" width="8" height="8" alt="" /></td>\
<td class="wbBgBottomRight"><img src="../images/trans.gif" width="8" height="8" alt="" /></td>\
</tr>\
</table>\
<div class="wbContextMenu" style="z-index:100000" id="wbMenu">\
<ul id="wbContextMenuItems" style="direction:ltr;">\
</ul>\
</div>\
<div id="wbSplitHelperDiv" style="position:absolute;" />\
<div id="wbTempIdToStoreWiki" style="display:none" />\
</div>',


bringContentFromPaneWindowHTML:'<div class="wbEmptyContentMessage">\
<img src="/images/bringTranslatedContent.png" usemap="#wbImageMap"/>\
<map name="wbImageMap">\
<area shape ="rect" coords ="145,123,199,146" id="wbBCFPyesButton" />\
<area shape ="rect" coords ="221,123,289,146" id="wbBCFPcancelButton" />\
</map>\
</div>',

chineseLangSelectionHTML:'<div id="wbchineseLangSelectionDiv">\
<div id="wbContent" >\
<div class="wbLogoContainer">\
</div>\
<div style="float:right;"><a id="wbCLSExitWindow" class="wbExit" href="#" title="Close" tabindex="0" oncontextmenu = "return false;"></a>\
</div>\
<table id="wbContentTable" border="0" cellpadding="0" cellspacing="0">\
<tr>\
<td class="wbWindowTopLeft"></td>\
<td class="wbWindowTopCenter"></td>\
<td class="wbWindowTopRight"></td>\
</tr>\
<tr>\
<td class="wbWindowContentLeft" />\
<td class="wbWindowContentCenter">\
<div class="wbSection">\
<div id="wbCollaborativeDiv" class="wbContent">\
Please select the appropriate Chinese language translation system to be used.\
</div>\
<div id="wbIntroDiv" style="margin:20px">\
<div style="text-align:center"><div style="float:left;margin-left:100px"><input type="button" value="简体中文" id="wbCHSLangButton"></div>\
<div style="float:right;margin-right:100px"><input type="button" value="繁體中文" id="wbCHTLangButton"></div></div>\
</div>\
</div>\
</td>\
<td class="wbWindowContentRight" ><img src="../images/trans.gif" width="3" height="3" /></td>\
</tr>\
<tr>\
<td class="wbWindowBottomLeft" ><img src="../images/trans.gif" width="4" height="4" /></td>\
<td class="wbWindowBottomCenter" ><img src="../images/trans.gif" width="4" height="3" /></td>\
<td class="wbWindowBottomRight" ><img src="../images/trans.gif" width="4" height="4" /></td>\
</tr>\
</table>\
</div>\
<div id="wbFooterDiv" style="float:right;"></div>\
</div>',

shareOnExternSystemHTML:'<div id="wbshareOnExternSystemHTMLDiv">\
<div id="wbSWESContent">\
<div id="wbSWESDraggableHandle" class="wbHeaderContainer" style="cursor:move;">\
<div class="wbH3" style="width:300px;float:left">Exiting WikiBhasha...</div>\
<div style="float: right;">\
</div>\
</div>\
<table border="0" cellpadding="0" cellspacing="0" style="margin:5px;width:387px">\
<tr>\
<td class="wbWindowTopLeft" />\
<td class="wbWindowTopCenter" />\
<td class="wbWindowTopRight" />\
</tr>\
<tr>\
<td class="wbWindowContentLeft" />\
<td class="wbWindowContentCenter">\
<div style="clear:both;text-align:left">\
<div class="wbContent" id="wbExitContent">\
<div id="thxMsg"></div>\
<div id="msgTitle"></div>\
<div id="msgText"></div>\
<div id="copyToClipboardDiv"><a href="#" id="copyToClipboard"></a></div>\
</div>\
<div style="padding:5px;" id="wbShareIconsSection"></div>\
<div style="padding:10px;clear:both;width:100%;text-align:center"><input type="button" id="wbSWESExitButton" value="Exit WikiBhasha"></div>\
</div>\
</td>\
<td class="wbWindowContentRight"></td>\
</tr>\
<tr>\
<td class="wbWindowBottomLeft" />\
<td class="wbWindowBottomCenter" />\
<td class="wbWindowBottomRight" />\
</tr>\
</table>\
</div>\
<div id="wbSWESFooterDiv"></div>\
</div>',


feedbackWindowHTML:'<div id="wbFeedbackDiv" >\
<table border="0" cellspacing="0" cellpadding="0" id="wbFeedbackTable" class="wbFeedbackTableBackground">\
<tr>\
<td class="wbWindowTopLeft"><img src="../images/trans.gif" width="4" height="4" alt="" /></td>\
<td class="wbWindowTopCenter"><img src="../images/trans.gif" width="4" height="3" alt="" /></td>\
<td class="wbWindowTopRight"><img src="../images/trans.gif" width="4" height="4"  alt=""/></td>\
</tr>\
<tr valign="top">\
<td class="wbWindowToolbarLeft"><img src="../images/trans.gif" width="3" height="3"  alt=""/></td>\
<td class="wbWindowToolbarCenter">\
<div id="wbFBDraggableHandle" style="cursor:move;width:85%" class="wbToolbarLeftIcons">\
<div class="wbH3" id="wbFeedbackHeader">Feedback</div>\
</div>\
<div class="wbToolbarRightIcons">\
<a id="wbFBExitWindow" class="wbClose" href="#" title="Close" ></a>\
</div>\
</td>\
<td class="wbWindowToolbarRight"><img src="../images/trans.gif" width="3" height="3" alt="" /></td>\
</tr>\
<tr valign="top">\
<td class="wbWindowContentLeft"><img src="../images/trans.gif" width="3" height="3" alt="" /></td>\
<td class="wbWindowContentCenter">\
<div id="wbFeedbackFormArea">\
<div id="feedbackQuestionMessage">Before leaving WikiBhasha, would you like to give us feedback?</div>\
<table id="wbFeedbackIconsTable">\
<tbody>\
<tr>\
<td id="wbFeedback0" class="tdHover" data="2" title="Nice Tool!!">\
<img src="../images/feedbackImgForNiceTool.png" id="_feedbackc">\
</td>\
<td rowspan=3>\
<textarea id="wbFeedbackText" cols="30" rows="3" name="wbFeedbackText"></textarea>\
<div id="feedbackNoteHolder">\
<span id="feedbackLimitNoteText">[Limit of the feedback text]</span>\
</div>\
</td>\
</tr>\
<tr>\
<td id="wbFeedback1" class="tdHover" data="1" title="Needs improvement...">\
<img src="../images/feedbackImgForNeedsImprove.png" id="_feedbacka">\
</td>\
</tr>\
<tr>\
<td id="wbFeedback2" class="tdHover" data="0" title="Others">\
<img src="../images/feedbackImgForOthers.png" id="_feedbackb">\
</td>\
</tr>\
</tbody>\
</table>\
<br/>\
<input type="button" id="wbSubmitFeedbackButton" value="Send via email"/>&nbsp;&nbsp;&nbsp;&nbsp;\
<input type="button" id="wbCancelFeedbackButton" value="Cancel"/>\
<span id="wbExitLinkInFeedbackWindow">&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;">Exit WikiBhasha</a></span></div>\
</div>\
<div id="wbFeedbackMsgArea">\
<table id="wbFeedbackMsgAreaTable" width="100%">\
<tbody>\
<tr>\
<td align="center" valign="center">\
<div id="feedBackMessageDiv">Thank you for the feedback.</div>\
</td>\
</tr>\
</tbody>\
</table>\
</div>\
</td>\
<td class="wbWindowContentRight"><img src="../images/trans.gif" width="3" height="3" alt="" /></td>\
</tr>\
<tr valign="top">\
<td class="wbWindowBottomLeft"><img src="../images/trans.gif" width="4" height="4" alt="" /></td>\
<td class="wbWindowBottomCenter"><img src="../images/trans.gif" width="4" height="3" alt="" /></td>\
<td class="wbWindowBottomRight"><img src="../images/trans.gif" width="4" height="4" alt="" /></td>\
</tr>\
</table>\
</div>',


languageSelectionWindowHTML:'<div id="wbSelectionDiv">\
<div id="wbContent">\
<div id="wbLSDraggableHandle" class="wbLogoContainer" style="cursor:move;">\
</div>\
<div style="float:right;"><a id="wbExitWindow" class="wbExit" href="#" title="Close" tabindex="0" oncontextmenu = "return false;"></a>\
</div>\
<table id="wbContentTable" border="0" cellpadding="0" cellspacing="0">\
<tr>\
<td class="wbWindowTopLeft"></td>\
<td class="wbWindowTopCenter"></td>\
<td class="wbWindowTopRight"></td>\
</tr>\
<tr>\
<td class="wbWindowContentLeft" />\
<td class="wbWindowContentCenter">\
<div class="wbSection">\
<div id="wbCollaborativeDiv" class="wbContent">\
WikiBhasha is a collaborative platform for creating multilingual content in non-English Wikipedias.\
</div>\
<div id="wbIntroDiv"><div id="wbCurrentLanguageDiv" class="wbheader">You are currently in an English\
Wikipedia article. Do you want to contribute to multilingual article?\
</div>\
<div class="wbContent" id="wbCollaborateContainer">\
<div id="wbContributeDiv" class="wbContributeButtonDiv">\
<input id="wbContributeBtn" name="" class="wbFormButtons" value="Contribute to multilingual version" type="button" tabindex="0" />\
</div>\
<div class="wbExitLink"><a id="wbExitLink" href="#" tabindex="0">Exit WikiBhasha</a>\
</div>\
</div></div>\
<div id="wbLanguageDiv">\
<div id="wbLanguageArticleDiv" class="wbheader">Select the language for the article</div>\
</div>\
<div style="height:10px"><div id="wbSearchLoading" class="wbLoadingDiv" style="margin:3px;text-align:center;width:100%;position:absolute"><img src="../images/loading.gif" alt="Searching" /> Searching...</div></div>\
<div id="wbLanguageOptionsDiv" style="float:left;margin:10px;width:25%">\
<table>\
<tr>\
<td>\
<select id="wbLanguagesDropDown" class="wbFormSelect" size="12">\
<option selected="selected" value="en" tabindex="0">Select Language</option>\
</select>\
</td>\
</tr>\
</table>\
</div>\
<div id="wbOptionDiv" style="float:right;width:65%;margin-top:10px;">\
<div id="wbDetectArticleDiv" class="wbheader">This article is not available in Arabic. Do you want to create the article?</div>\
<div class="wbContent">\
<table>\
<tr>\
<td><div id="wbArticleTitleLabel" style="margin-top:4px;margin-right:3px;float:left">Article Title</div><div style="margin-right:3px;float:left"><input id="wbArticleTitleInput" value="" style="width:190px" type="text" tabindex="0"/></div>\
<div><input id="wbArticleTitleSubmitBtn" value="Create article" class="wbFormButtons" type="button" tabindex="0" style="margin:4px"/></div>\
</td>\
</tr>\
<tr>\
<td colspan="2">\
<p id="wbUserOption"><span class="wbRedtext">Important!</span>Please click on the "WikiBhasha" bookmarklet again on arriving in Arabic Wikipedia.</p>\
</td>\
</tr>\
</table>\
</div>\
</div>\
</div>\
</td>\
<td class="wbWindowContentRight" ><img src="../images/trans.gif" width="3" height="3" /></td>\
</tr>\
<tr>\
<td class="wbWindowBottomLeft" ><img src="../images/trans.gif" width="4" height="4" /></td>\
<td class="wbWindowBottomCenter" ><img src="../images/trans.gif" width="4" height="3" /></td>\
<td class="wbWindowBottomRight" ><img src="../images/trans.gif" width="4" height="4" /></td>\
</tr>\
</table>\
</div>\
<div id="wbFooterDiv"></div>\
</div>',


noSourceArticleInfoWindowHTML:'<div class="wbEmptyContentMessage">\
<img src="/images/noSrcArticle.png" />\
</div>',


scratchpadWindowHTML:'<div id="wbWrapperScratchPad" >\
<table height="100%" border="0" cellspacing="0" cellpadding="0" id="scratchPadTable" width="100%">\
<tr>\
<td class="wbWindowTopLeft"><img src="../images/trans.gif" width="4" height="4" alt="" /></td>\
<td class="wbWindowTopCenter"><img src="../images/trans.gif" width="4" height="3" alt="" /></td>\
<td class="wbWindowTopRight"><img src="../images/trans.gif" width="4" height="4"  alt=""/></td>\
</tr>\
<tr valign="top">\
<td class="wbWindowToolbarLeft"><img src="../images/trans.gif" width="3" height="3"  alt=""/></td>\
<td class="wbWindowToolbarCenter">\
<div id="wbSPDraggableHandle" style="cursor:move;width:90%" class="wbToolbarLeftIcons">\
<div class="wbH3" id="wbScratchPadHeader">Scratch Pad</div>\
</div>\
<div class="wbToolbarRightIcons">\
<a id="wbSPExitWindow" class="wbClose" href="#" title="Close" ></a>\
</div>\
</td>\
<td class="wbWindowToolbarRight"><img src="../images/trans.gif" width="3" height="3" alt="" /></td>\
</tr>\
<tr valign="top">\
<td class="wbWindowContentLeft"><img src="../images/trans.gif" width="3" height="3" alt="" /></td>\
<td class="wbWindowContentCenter">\
<div class="wbScratchPadSection">\
<form><div class="wbTranslatedAreaHead" id="wbHeaderRow"><div class="scratchTopLayout" id="wbScratchpadHeadLabelLeft"><h4>Source Text</h4></div>\
<div class="scratchTopButtonLayout"><div style="float:left;width:75px;display:none;text-align:center" id="wbTranslationLoading">\
<img src="../images/loading.gif" alt="Translating"/>\
</div></div>\
<div class="scratchTopLayout" id="wbScratchpadHeadLabelRight"><h4>Translated Text</h4></div><div class="scratchTopButtonLayout">&nbsp;</div></div>\
<div><div class="scratchTopLayout">\
<textarea id="wbSourceText" rows="5" tabindex="0">\
</textarea>\
</div><div class="scratchTopButtonLayout">\
<input id="wbSourceToTargetBtn" type="button" value=">>" /><br />\
<input id="wbTargetToSourceBtn"  type="button" value="<<" />\
</div><div class="scratchTopLayout">\
<textarea id="wbTargetText" rows="5" tabindex="0">\
</textarea>\
</div>\
<div class="scratchTopButtonLayout">\
<input id="wbSaveScratchPadContentBtn" type="button" value="Save" tabindex="0"/><br/>\
<input type="reset" value="Reset" tabindex="0"/><br/>\
<input id="wbClearAllBtn" type="button" value="Clear All" tabindex="0" />\
</div>\
</div></form>\
<div id="scratchPadLimitNoteHolder">\
<span class="scratchPadLimitNotePrefix">Note:&nbsp;</span><span id="scratchPadLimitNoteText"></span>\
</div>\
</div>\
<div class="wbScratchPadSectionContent">\
<div id="wbTranslatedArea" style="clear:both;overflow-x: auto; overflow-y: auto; height:150px">\
</div>\
</div>\
</div>\
</td>\
<td class="wbWindowContentRight"><img src="../images/trans.gif" width="3" height="3" alt="" /></td>\
</tr>\
<tr valign="top">\
<td class="wbWindowBottomLeft"><img src="../images/trans.gif" width="4" height="4" alt="" /></td>\
<td class="wbWindowBottomCenter"><img src="../images/trans.gif" width="4" height="3" alt="" /></td>\
<td class="wbWindowBottomRight"><img src="../images/trans.gif" width="4" height="4" alt="" /></td>\
</tr>\
</table>\
</div>',


searchWindowHTML:'<div id="wbSearchDiv">\
<div id="wbContent">\
<div id="wbSearchDraggableHandle" class="wbHeaderContainer" style="cursor:move;">\
<div id="wbSearchHeader" class="wbH3">Search</div>\
<div style="float: right;">\
<a id="wbExitWindow" class="wbSearchExit" href="#" title="Close" oncontextmenu = "return false;"></a>\
</div>\
</div>\
<table id="wbContentTable" border="0" cellpadding="0" cellspacing="0">\
<tr>\
<td class="wbWindowTopLeft" />\
<td class="wbWindowTopCenter" />\
<td class="wbWindowTopRight" />\
</tr>\
<tr>\
<td class="wbWindowContentLeft" />\
<td class="wbWindowContentCenter">\
<div>\
<div id="wbSearchTitle" class="wbContent" style="font-size:9pt;line-height:normal;padding-left:0px;">\
Search for Wikipedia article to be used as a source.\
</div>\
<table id="wbSearchTable" border="0" cellpadding="0" cellspacing="0" width="100%">\
<tr>\
<td>\
<div>\
<div id="wikiBableSearchInputDiv">\
<input id="wbSearchInput" type="text" style="width:350px;margin:10px"/>\
</div>\
<div id="wbSearchLinkDiv">\
<a id="wbSearchLink" class="wbSearchLink" href="#" title="Search" style="margin:9px"></a>\
</div>\
</div>\
</td>\
</tr>\
<tr>\
<td>\
<div id="wbSearchLoading" class="wbLoadingDiv">\
<img src="../images/loading.gif" alt="searching" />Searching...</div>\
</td>\
</tr>\
</table>\
</div>\
</td>\
<td class="wbWindowContentRight"></td>\
</tr>\
<tr>\
<td class="wbWindowContentLeft" />\
<td style="line-height:normal">\
<div id="wbSearchItem" class="wbSearch" />\
</td>\
<td class="wbWindowContentRight"></td>\
</tr>\
<tr>\
<td class="wbWindowBottomLeft" />\
<td class="wbWindowBottomCenter" />\
<td class="wbWindowBottomRight" />\
</tr>\
</table>\
</div>\
<div id="wbFooterDiv"></div>\
</div>',


splashWindowHTML:'<div id="wbSplashWindow">\
<div style="position:absolute; top:95px; left:85px; display:block"><img src="../images/loadingIcon.gif" alt="" /></div>\
<div style="position:absolute; top:98px; left:115px; color:#FFFFFF">Loading...</div>\
</div>',


tooltipWindowHTML:'<table border="0" cellspacing="0" cellpadding="0" style="overflow:auto">\
<tr>\
<td class="wbTooltipContentTD">\
<div class="wbTooltipContent" id="wbDynamicId"></div>\
</td>\
</tr>\
</table>',

wikiMarkupEditWindowHTML:'<div id="wbWikiMarkupEditDiv">\
<div id="wbWikiMarkupEditDraggableHandle">\
<div style="float:left;height:25px;"><ul class="tabs" id="wbWikiMarkupEditDivTab">\
<li id="wbWikiMarkupEditLi"><a href="#" id="wbWikiMarkupEditLink" class="tabs_li">Edit Text</a></li>\
<li id="wbWikiMarkupEditPreviewLi"><a href="#" id="wbWikiMarkupEditPreviewLink" class="tabs_li">Preview</a></li>\
</ul></div>\
<div style="float:right"><a id="wbWikiMarkupEditExit" class="wbExit" href="#" title="Close" oncontextmenu="return false;" style="margin:4px;padding:0;"></a></div>\
</div>\
<div id="wbWikiMarkupEditTabsContainer" class="tab_container">\
<textarea id="wbWikiMarkupEditTab" class="tab_content">\
</textarea>\
<div id="wbWikiMarkupEditPreviewTab" class="tab_content">\
Loading Preview</div>\
<div id="wbWikiMarkupEditSubmitLinks" class="wbWikiMarkupEditBottomLinks">\
<input type="button" id="wbWikiMarkupEditSaveLink" value="Save"/>&nbsp;&nbsp;&nbsp;&nbsp;\
<input type="button" id="wbWikiMarkupEditCancelLink" value="Cancel"/>\
</div>\
</div>\
</div>',

tutorialWindowHTML:'<div id="wbTutorialDiv" class="wbTutorialBgContentArea" >\
<div id="wbTutorialContent">\
<div id="wbTTDraggableHandle" class="wbTutorial" style="cursor:move;">\
</div>\
<div style="float:right;"><a id="wbExitTutorialWindow" class="wbExit" href="#" title="Close" tabindex="0"></a></div>\
<table id="wbTutorialContentTable" border="0" cellpadding="0" cellspacing="0">\
<tr>\
<td class="wbWindowTopLeft" ><img src="../images/trans.gif" width="4" height="4" /></td>\
<td class="wbWindowTopCenter" ><img src="../images/trans.gif" width="4" height="3" /></td>\
<td class="wbWindowTopRight" ><img src="../images/trans.gif" width="4" height="4" /></td>\
</tr>\
<tr>\
<td class="wbWindowContentLeft"><img src="../images/trans.gif" width="3" height="3" /></td>\
<td class="wbWindowContentCenter">\
<div id="wbTutorialText" class="wbTutorialContent"></div>\
</td>\
<td class="wbWindowContentRight" ><img src="../images/trans.gif" width="3" height="3" /></td>\
</tr>\
<tr>\
<td class="wbWindowBottomLeft" ><img src="../images/trans.gif" width="4" height="4" /></td>\
<td class="wbWindowBottomCenter" ><img src="../images/trans.gif" width="4" height="3" /></td>\
<td class="wbWindowBottomRight" ><img src="../images/trans.gif" width="4" height="4" /></td>\
</tr>\
</table>\
<table style="background-color:Transparent">\
<tr>\
<td/>\
<td class="wbTutorialNavigation" >\
<a class="wbTutorialPreviousBtn" id="wbBackBtn" href="#" title="Previous"/>\
<a class="wbTutorialNextBtn" id="wbNextBtn" href="#" title="Next"/>\
</td>\
<td/>\
</tr>\
</table>\
</div>\
</div>'

/*HTML BLOCK END*/

//Don not delete above comment as it needed by the HTML Engine to insert HTML code from HTML files.
};

wbGlobalSettings = wikiBhasha.configurations.globalSettings;

})();