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

//
//  TODO: To apply localization on wikiBhasha for DE language, replace all the strings with appropriate German text.
//

(function() {

    wikiBhasha.localStrings = {

        failureMsg: "Unable to launch WikiBhasha\n",
        collaborativeTitle: "Welcome to WikiBhasha beta, a collaborative tool for enhancing multilingual content in Wikipedias.",
        collaborativeSearchTitle: "Please input terms to search for within English and the target language Wikipedias.",
        currentLanguage1: "You are currently on the",
        currentLanguage2: "article in the English Wikipedia.",
        exit: "Exit WikiBhasha",
        languageArticle: "Select the target language.",
        detectArticle: "This article does not exist in the target language Wikpedia. Please provide a title to create one.",
        existingtArticle: "This article already exists in the target language.",
        notApplicableStep: "This step in not applicable for current article.",
        important: "Important!",
        importantNote: "Please click on the \"WikiBhasha (Beta)\" bookmarklet again when you are in the target language Wikipedia!",
        contributeBtn: "Contribute to its version in another language",
        articleTitle: "Article Title",
        searchTabTitle: "Search for source article",
        contributeTo: "Enhance existing article in target language",
        create: "Create new article in the target langauge",
        space: " ",
        dot: ".",
        themeBlue: "Theme Blue",
        themeBlack: "Theme Black",
        themeSilver: "Theme Silver",
        help: "Help",
        maximize: "Maximize",
        close: "Close",
        sourceArticle: "Source Article",
        search: "Search",
        historyLabel: "Visited Topics",
        translate: "Translate to",
        scratchPad: "Scratch Pad",
        searchHeader: "Search",
        convertEntireArticle: "Get the entire article from Source",
        emptySearchResult: "There were no results matching the query.",
        english: "English",
        toText: "to",
        bringContentFromPane: "Bring the translated & corrected source content",
        articleAlreadyExists: "An article with title '{0}' already exists in target language Wikipedia, do you want to edit this page?",
        emptySearchResult: "There were no results matching the query.",
        emptySource: "No Inter-wiki-linked English article exists, for the topic you are working on currently.  You may want to search for appropriate material using the ‘Search’ feature.",
        emptyInputText: "Please enter a valid text and continue.",
        unSupportedLanguage: "This target language is not currently supported in WikiBhasha.",
        invalidBookmarklet: "Please select appropriate book marklet",
        defaultLanguageText: "Select Language",
        warningMsg: "Please save your work",
        clearAll: "Clear All",
        sourceTextHeader: "Source Text",
        translatedTextHeader: "Translated Text",
        loadingElementContent: "Loading article...",
        sourceArticleNotApplicable: "Source langauge content is not applicable here.",
        scratchPadTextLimitConfirmMsg: "The entered text exceeds given limit of {0} characters.\n\nIf you continue to translate, it will discard the text that is beyond the limit",
        scratchPadTextLimitNote: "Maximum characters allowed per translation are {0} characters",
        feedbackTextLimitNote: "[Maximum of {0} characters]",
        feedbackThankYouMessage: "Thank you for the feedback.",
        feedbackErrorMessage: "Could not submit your feedback.<br/><br/>Click <a href='javascript:;' id='feedbackEmailLink'>here</a> to submit via e-mail.",
        feedbackEmptyTextAlertMessage: "Please select one option or enter some text in the provided text area.",
        warningSaveComposeChanges: "Any changes made in this step would be lost if you move to an earlier step.  Do you want to move anyway?",
        noTargetLanguageArticleFound: "Linked article not found in target language Wikipedia.",
        feedbackQuestionMessage: "Before leaving WikiBhasha, would you like to give us feedback?",
        previewErrorMessage: "Unable to show the preview.",
        loadingPreviewContent: "Loading Preview...",
        exitMessage: "Thank you for your enhancement to {0} Wikipedia!  Now is a great time to tell your friends about your contribution...",
        defaultShareMessage: "I contributed to {0} Wikipedia using WikiBhasha http://www.wikibhasha.org.",
        shareMessage: "edited {0} in {1} Wikipedia using WikiBhasha http://www.wikibhasha.org.",
        shareMesgTitle: "Share Message",
        shareToolTip: "Share On",
        newWindowMessage: "<center><h2>Your edited content has been loaded into a Wikipedia edit page in the new window. <br>Please use that new window to save the content. Once you save the content to Wikipedia, you will be redirected back here.</h2></center>",
        transleteButton: "Translate {0} to {1}",
        copyToClipboard: "(Copy to clipboard)",
        pasteMessage: "To use the WikiBhasha Copy/Paste feature in mozilla/firefox you need to use scratchpad.\nDo you want to invoke scratchpad?",

        //tooptip strings
        searchInputTooltip: "Search",
        collapseTooltip: "Collapse",
        expandPaneTooltip: "Expand",

        //help tutorials array[slideNo,text]
        tutorials: ["Welcome to WikiBhasha beta, a collaborative tool that helps Wikipedia user communities enhance" +
                                    " content in their respective language Wikipedias. WikiBhasha started as a research project in" +
                                    " Microsoft Research. It is now being made available as an open source project on MediaWiki." +
                                    " The tools is also available as a user gadget in Wikipedia as well as a bookmarklet from" +
                                    " <a href=\"www.wikibhasha.org\">www.WikiBhasha.org</a>. Please comply with Wikipedia’s norms" +
                                    " for content contribution." +
                                    "<br><br>" +
                                    "Current WikiBhasha beta version: 1.0.0<br><br>" +
                                    "<a href=\"mailto:wikibfb@microsoft.com?subject=WikiBhasha Feedback\">Feedback to WikiBhasha team</a> welcome.",
                                    "<b>Supported Platforms: </b><P><P>\tIE 7/8 on Windows XP/Vista/Win7 and " +
                                    "Firefox 3.5 or above on Linux Fedora 11/12.  " +
                                    "<b><P><P> Supported Languages: </b><P><P>\t" +
                                    "Currently WikiBhasha (Beta) supports all language pairs supported by" +
                                    " <a href=' http://www.microsofttranslator.com' target='_BLANK'>Microsoft Translator</a> (where" +
                                    " the source language is English)<P><P>"
                                    ],
        nonWikiDomainMsg: "Please select a valid article from wikipedia and invoke WikiBhasha.",
        noSourceArticleFound: "In English Wikipedia, WikiBhasha may be invoked only on an existing article.",
        waitUntilTranslationComplete: "Please wait till the translation completes.",
        thanksMessage: "Thank you for your contribution to Wikipedia. Would you like to give feedback?",
        nonEditableMessage: "WikiBhasha may be invoked only on editable articles; this article is protected in Wikipedia."
    }

    //short cut to call local strings
    wbLocal = wikiBhasha.localStrings;

})();
