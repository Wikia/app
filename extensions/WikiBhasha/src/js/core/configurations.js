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
*   ‘http:*www.apache.org/licenses/’ are reproduced 
*   in ‘Apache2_license.txt’
*
*/

/* 
Available Classes:
1) configurations   - Includes all the available configurations for the application.
    
    Available Sub-Classes:
        1) defaultWorkFlow          - describes the configuration for application workflow steps.
        2) defaultContextMenuItems  - describes configurations for application context menu items
*/


// Make sure the base namespace exists.
// includes all the available configurations for the application.
if (typeof (wikiBhasha.configurations) === "undefined") {
    wikiBhasha.configurations = {}; 
}

// initializes all the configuration settings for the application, it initializes all the customizable components of the application.
wikiBhasha.configurations.initialize = function() {
    wikiBhasha.configurations.workFlow = wikiBhasha.configurations.defaultWorkFlow;
    wikiBhasha.configurations.contextMenuItems = wikiBhasha.configurations.defaultContextMenuItems;
    wikiBhasha.configurations.wikiInterface = wikiBhasha.extern.wikipediaInterface;
    wikiBhasha.configurations.languageServicesInterface = wikiBhasha.extern.msLanguageServicesInterface;
    wikiBhasha.configurations.transliterationServicesInterface = wikiBhasha.extern.msTransliterationServicesInterface;
    wikiBhasha.configurations.loggerInterface = wikiBhasha.extern.wikipediaLoggerInterface;

    // shortcut global members for easy access from other places
    wbWorkflow = wikiBhasha.configurations.workFlow;
    wbWikiSite = wikiBhasha.configurations.wikiInterface;
    wbLanguageServices = wikiBhasha.configurations.languageServicesInterface;
    wbTransliterationServices = wikiBhasha.configurations.transliterationServicesInterface;
    wbLoggerService = wikiBhasha.configurations.loggerInterface;
};


// describes the configuration for application workflow steps.
wikiBhasha.configurations.defaultWorkFlow = {
    //configuration for each step that is part of application workflow
    steps: {
        step1: {
            //display order of the given step from left to right
            displayOrder: 0,
            //name of the step displayed on the button
            buttonText: "Collect",
            //tooltip text to be displayed when user mouse hovers on button
            buttonTooltipText: "Collect content from multiple resource articles",
            //class names of button when button is in normal or active states
            buttonStyleNormal: "wbCollectNormal",
            buttonStyleActive: "wbCollectActive",
            //configuration of panes display data
            panesData: [
            //configuration for left hand side(LHS) pane
                        {
                        //assign one of the pane available in 'wb.paneManagement'
                        pane: "#wbSourceOriginalArticlePane",
                        //format of the title to be displayed as pane title
                        title: "{sourceArticleTitle} ({sourceLanguage}, read only)",
                        //default title to be displayed
                        defaultTitle: "English Article (Original, read only)",
                        //theme style to be applied on pane title bar
                        titleBarThemeStyle: "wbLightYellowTitleBar"
                    },
            //configuration for right hand side(RHS) pane
                        {
                        pane: "#wbSourceTranslatedArticlePane",
                        title: "{sourceArticleTitle} ({sourceLanguage}->{targetLanguage}, editable)",
                        defaultTitle: "English Article (Translated, editable)",
                        //is pane data editable or not
                        isContentEditable: true,
                        titleBarThemeStyle: "wbLightYellowTitleBar"
                    }
                    ]
        },
        step2: {
            displayOrder: 1,
            buttonText: "Compose",
            buttonTooltipText: "Compose all the collected content to the target article",
            buttonStyleNormal: "wbComposeNormal",
            buttonStyleActive: "wbComposeActive",
            panesData: [
                        { pane: "#wbSourceTranslatedArticlePane",
                          title: "{sourceArticleTitle} ({sourceLanguage}->{targetLanguage}, corrected & read only)",
                          defaultTitle: "English Article (Translated, read only)",
                          isContentEditable: false, 
                          titleBarThemeStyle: "wbLightYellowTitleBar" },
                        { pane: "#wbTargetContentPane",
                          title: "{targetArticleTitle} ({targetLanguage}, editable)",
                          defaultTitle: "Target Language Article (editable)",
                          isContentEditable: true, 
                          titleBarThemeStyle: "wbLightBlueTitleBar" }

            //Following describes various future enhancements that can be implemented to 
            //populate the different types of data for panes.            
            /*
            //To set some HTML text into the pane we can think of supporting following format
            {html:"<h1>This is some test content</h1>"},
            
            //To set some data from external API call then we can think of supporting following format
            //Example:
            //This API should support "callback" mechanism with JSON format
            {api:"http://fr.wikipedia.org/w/api.php?&action=query&titles=Microsoft&rvprop=content&prop=revisions&redirects=1&format=json",
            //callback function to handle the JSON data returned by JSONP api
            callback:function(data) {
            var pages = data.query.pages;
            for(var i in pages) {                                        
            return pages[i].revisions[0]["*"];   
            }                       
            }
            }*/
            ]
        },
        step3: {
            displayOrder: 2,
            buttonText: "Submit",
            buttonTooltipText: "Publish the composed article content to Wikipedia",
            buttonStyleNormal: "wbPublishNormal",
            buttonStyleActive: "wbPublishActive",
            panesData: [
                        { pane: "#wbTargetArticleComposeDiv", title: "Save {targetArticleTitle} ({targetLanguage}) article", defaultTitle: "Target Language Wikipedia Edit Page", isEditable: false }
                    ]
        }
    },

    //default configurations of application workflow
    config: {
        //default step to load on application launch
        currentStep: 0,        

        // Describes behavior when target language article is loaded as one of sourcing articles for building content.
        // Target language article can be loaded on source pane by clicking on target language results in search results
        // or by clicking links on target language article.
        onTargetLanguageContentLoadAsResourcePage: {
            defaultStep: 1,
            invalidSteps: { 0: true },
            newPaneTitles: { "#wbSourceTranslatedArticlePane": "{sourceArticleTitle} ({targetLanguage}, read only)" }
        },

        // Describes behavior when source language article is loaded as one of sourcing articles for building content. 
        onSourceLanguageContentLoadAsResourcePage: {
            defaultStep: 0
        },

        // Describes which are all the steps that need to be considered to enable links for a translated source article content        
        onSourceArticleTranslatedContentLinksClicked: {
            stepsToConsider: { 1: true },
            //which language to target for searching the clicked link title
            languageCodeToChoose: "targetLanguageCode" //Possible values: 'sourceLanguageCode' OR 'targetLanguageCode'
        },

        // Describes which are all the steps that need to be prevented from navigation while translation is going on.
        // this applies only to new articles for better usability
        preventNavigationToStepsDuringTranslationForNewArticle: {
            stepsToPrevent: { 2: true }
        },

        //When the user invokes WikiBhasha from a target language article for which there is no corresponding article 
        //in source language, we would like to load WikiBhasha in step 2 as we don’t have anything to show in step1. 
        //The below code portion defines this behavior.
        onSourceArticleAbsence: {
            defaultStep: 1,
            invalidSteps: { 0: true }   
        }
    },
    //array to hold the steps data
    stepsArray: []
};


// describes configurations for application context menu items
if(!wikiBhasha.configurations.defaultContextMenuItems) {
    wikiBhasha.configurations.defaultContextMenuItems = {};
}

// describes configuration for scratch pad context menu item
wikiBhasha.configurations.defaultContextMenuItems["scratchPad"] = {
    //menu item id
    "itemId": "scratchPad",
    //icon configuration of the menu item
    "itemIcon": {
        //icon src url
    "iconSrc": "images/contextScratchpad.png",
        //icon image width
        "iconWidth": "22",
        //icon image height
        "iconHeight": "22"
    },
    //text to be displayed in the menu item
    "itemText": "Scratch Pad (Alt+Ctrl+S)",
    //action to be performed on the menu item
    "onClick": function() {        
        wbScratchPad.show();
    },
    "shortCutKey": "Alt+Ctrl+s"
};

// describes configuration for bing search menu item
wikiBhasha.configurations.defaultContextMenuItems["bingSearch"] = {
    "itemId":"bingSearch",
    "itemIcon":{ "iconSrc":"http://www.bing.com/s/wlflag.ico", "iconWidth":"22", "iconHeight":"22"},
    "itemText": "Bing Search (Alt+Ctrl+b)",
    "onClick": function() {
        //make sure not to nullify the user selected text
        var selectedText = wbUIHelper.getSelectedText() || wbContextMenuHandler.lastSelectedText;
        window.open("http://www.bing.com/search?q=" + encodeURIComponent(selectedText) );
    },
    "shortCutKey": "Alt+Ctrl+b"
};