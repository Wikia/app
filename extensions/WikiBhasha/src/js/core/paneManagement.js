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
* Available Classes:
* 1) displayPaneInterface   - This is interface that each pane should follow.
* 2) publishDisplayPane     - Pane to show wikipedia edit page
* 3) sourceOriginalPane     - Pane to display the original source article content
* 4) sourceTranslatedPane   - Pane to show translated source article content
* 5) targetContentPane      - Pane to show target article content
* 6) displayPaneManager     - manages the manipulation of above defined panes according to the given configuration.
* 7) displayPaneHelper      - class to hold utility methods for 'displayManager' class
*/

//make sure the namespace exists.
if (typeof (wikiBhasha.paneManagement) === "undefined") {
    wikiBhasha.paneManagement = {};
}

(function() {

    // This is interface that each pane should follow. To create a new pane, implement a new class and
    // implement at least the required members, then add an instance of this pane to
    // 'wb.paneManagement.displayPaneManager.allPanesArray' array. Use this pane in 'wb.workFlow' 
    // which is defined in 'configurations.js' at necessary steps.
    wikiBhasha.paneManagement.displayPaneInterface = {

        // Required Member. An unique id of div element that contains all pane contents
        contentDivId: "SomeUniqueContentDivIdString",

        // Required Member. jQuery reference to the div element identified by above 'contentDivId' string
        // Typically, this element is created and initialized in this class's 'initialize()' call.
        $contentElem: null,

        // language of the content the pane contains
        contentLang: null,

        // Required Member. This is called only once per WikiBhasha session before this pane is used or displayed.
        initialize: function() {
            // Create necessary elements and initializations here and append item to 'this.$contentElem'. The '$contentElem'
            // will be automatically used in correct steps and correct panes by wikiBhasha framework.
        },

        // Optional Member. If the pane wants to get notified whenever user changes history item in 'visited topics',
        // implement this method
        onHistoryChanged: function(historyItem) {
            // Current history item reference is passed as parameter. Do necessary things to
            // display correct content for given 'historyItem'
        },

        // Optional Member. If this method is implemented, then this method gets called by wikiBhasha framework
        // each time this pane is added to the UI and displayed.
        onShow: function() {
            // Implement functionality that should be executed before displaying this pane to UI each time.
        },

        // Optional Member. Implement this method if notification is needed when "show wikimarkup" checkbox changes value
        // The value of checkbox is passed as first parameter
        onDisplayModeChanged: function(isShowWikimarkupMode) {
        },

        // Optional Member. This function gets called just before the pane is to be hidden, for example, when user
        // changes steps. Return false to cancel the hide operation and be in the current step.
        canHide: function() {
        },

        // Optional: This field is set by the framework, and can be referred by the pane optionally. 
        // This field contains the configuration information set under 'config'
        // section for this pane for the current step.
        paneConfigInfo: null
    };


    // This is an example simplest possible pane that shows some HTML content.
    // To use this pane, register this one time to the array 'wb.paneManagement.displayPaneManager.allPanesArray'
    // and start referencing in 'wb.workflow' steps configuration.
    wikiBhasha.paneManagement.exampleHelloWorldPane = {
        contentDivId: "wbExampleHelloWorldPane",
        $contentElem: null,
        initialize: function() {
            this.$contentElem = $("<div>Hello world</div>").attr("id", this.contentDivId);
        }
    };

    //Pane to show wikipedia edit page
    wikiBhasha.paneManagement.publishDisplayPane = {
        contentDivId: "wbTargetArticleComposeDiv",
        $contentElem: null,
        //If 'doNotAppendAgain' property present for any pane(specifically for wiki compose pane) then
        //that pane content won't be removed from the DOM tree. In this case, we won't load IFRAME again and again.
        doNotAppendAgain: false,
        isWikiPediaEditWindowLoaded: false,
        // It is a Boolean variable to store whether the content moved to Wikipedia or not.
        isContentMovedToWikipedia: false,
        //It is a Boolean variable to store whether the content moved from previous steps to Wikipedia edit page.
        isContentMovedToComposePane: false,

        wbChildWikipedia: null,

        timeoutObj: null,

        initialize: function() {
            wbPublishDisplayPane.$contentElem = $("#" + this.contentDivId);
            //get wikipedia article compose url
            var urlData = wbWikiSite.getEditPageUrl(wbGlobalSettings.targetLanguageCode, wbGlobalSettings.targetLanguageArticleTitle);
            // window object
            
            wbPublishDisplayPane.wbChildWikipedia = window.open(urlData, 'wbChildWikipediaWindow');
             
            wbPublishDisplayPane.check_load();
            return;
        },
        check_load: function (){
            if( wbPublishDisplayPane.wbChildWikipedia.document.readyState == "complete" && !wbPublishDisplayPane.wbChildWikipedia.loaded){
                wbPublishDisplayPane.loadWikiEditPage();
                if(wbPublishDisplayPane && wbPublishDisplayPane.wbChildWikipedia){
                    wbPublishDisplayPane.wbChildWikipedia.loaded = 1;
                }
            }else{
                wbPublishDisplayPane.timeoutObj = setTimeout(wbPublishDisplayPane.check_load,100);
            }
            return;
        },
        loadWikiEditPage : function () {
            wbDisplayPaneHelper.setPaneTitleFromConfig(wbPublishDisplayPane.$contentElem, wbPublishDisplayPane.paneConfigInfo);
            wbPublishDisplayPane.$contentElem.html(wbLocal.newWindowMessage);
            // get the existance of the text area in the child window.
            var noOfTextAreas = wbPublishDisplayPane.getWikiTextareaElement().length;

            // Check the state of the content and the text area. If the content is already moved to 
            // Wikipedia and there is no text area present in the window, then close the application 
            // and load the updated Wikipedia page. 
            if (wbPublishDisplayPane.isContentMovedToWikipedia && (noOfTextAreas === 0)) {
                var currentPageUrl = window.location.href;
                currentPageUrl = currentPageUrl.replace(/&action=edit/ig, "");
                wbPublishDisplayPane.wbChildWikipedia.close();
                clearTimeout(wbPublishDisplayPane.timeoutObj);
                wbPublishDisplayPane.$contentElem.html(" ");
                //show WikiBhasha share exit popup.
                wbShareOnExternSystem.show();
                return;
            }

            wbPublishDisplayPane.isWikiPediaEditWindowLoaded = true;

            //collect all edits from target content pane and post the same to wiki edit page.
            wbPublishDisplayPane.postDataToWikiPage();

            // call the method to bind the click event to the wikipedia save button
            wbPublishDisplayPane.addSnippetInjectCodeToSaveButton();

            wbDisplayPaneHelper.configureComposeArea(wbPublishDisplayPane.wbChildWikipedia);
            // Reset isChangedByUser and hook to text area to turn that flag on, when user makes changes.
            wbPublishDisplayPane.getWikiTextareaElement().change(function() {
                wbPublishDisplayPane.isChangedByUser = true;
            });
        },
        // Binds the click event on wikipedia edit page's save button. This is to add the wikiBhasha versioning code snippet and creating the interwiki links
        // into wikipedia article content when user clicks the save button.
        addSnippetInjectCodeToSaveButton : function () {

                    // get the child window which contains the wikipedia text area and the save button
                    var childWindowDoc = wbPublishDisplayPane.wbChildWikipedia.document,
                    // get the save button from the childWindowDoc
                        saveButton = childWindowDoc.getElementById(wbWikiSite.wikiSaveButton);
                    if (saveButton) {
                        // bind the click event to the save button
                        saveButton.onclick = function() {

                            // get the text from the wikipedia edit text area.
                            var composedContent = new String(wbPublishDisplayPane.getWikiTextareaElement().val()); 
                            var summeryContent = new String(wbPublishDisplayPane.getWikiSummeryFieldElement().val()); 
                            
                            if(!(summeryContent.indexOf(wbGlobalSettings.snippet) > -1) ){
                                //insert the snippet to the summery field'.
                                summeryContent = wbGlobalSettings.snippet + " " + summeryContent;
                                // update the summery field content with the snippet.
                                wbPublishDisplayPane.getWikiSummeryFieldElement().val(summeryContent);
                            }

                            // call the method to check and insert the interwiki link
                            composedContent = wbPublishDisplayPane.insertInterWikiLink(composedContent);
                            // update the text area content with the snippet.
                            wbPublishDisplayPane.getWikiTextareaElement().val(composedContent);
                            // returning true will allow the execution to continue on saving the content in wikipedia.
                            window.onbeforeunload = null;
                            // as the content is about to move to Wikipedia, update the state of the respective variable
                            wbPublishDisplayPane.isContentMovedToWikipedia = true;

                            // log the usage of save button
                            wbLoggerService.logFeatureUsage(wbGlobalSettings.sessionId, "ArticleSaved", wbGlobalSettings.targetLanguageArticleTitle, wbGlobalSettings.targetLanguageCode);
                            wbPublishDisplayPane.check_load();
                            return true;
                        };
                    }
                },
        onShow: function() {
                this.initialize();
        },

        // this function gets called just before the pane is to be hidden, for example, when user
        // changes steps. Return false to cancel the hide operation and be in the current step.
        canHide: function() {
            // return false if user has unsaved changes and if user wants to be here to save changes.
            return (wbPublishDisplayPane.isChangedByUser) ?
                window.confirm(wbLocal.warningSaveComposeChanges) : true;
        },

        // posts updated content from target/translated pane to wikiPedia edit page's text area
        postDataToWikiPage: function() {
            // if the content from previous steps already moved to Wikipedia edit page, then we don’t want to do it again and so returning the function. 
            if (wbPublishDisplayPane.isContentMovedToComposePane) {
                return;
            }

            // if the content from previous steps not yet moved to Wikipedia edit page then we need to move it with the following code.
            // As the following code will move the content to Wikipedia edit page, set the corresponding variable to true for latter reference. 
            wbPublishDisplayPane.isContentMovedToComposePane = true;
            var wikiText = "";
            wbPublishDisplayPane.isChangedByUser = false;
            // if there is content in targetContentPane, then copy that content to compose textbox area
            if (wbTargetContentPane.isInitialized && wbPublishDisplayPane.isWikiPediaEditWindowLoaded) {
                wikiText = wbWikiModeConverter.getWikiFromHtmlDomElement(wbTargetContentPane.$contentElem[0]);
            }
            // if user has not visited targetContentPane (step 2 in default config), then copy the translated content
            // from sourceTranslatedPane (step 1 in default config) only when it is new article.
            else if (!wbTargetContentPane.isInitialized && wbPublishDisplayPane.isWikiPediaEditWindowLoaded && wbGlobalSettings.isNewArticle) {
                var originalSrcContent = wbHistoryManager.getHistoryEntity(wbGlobalSettings.sourceLanguageArticleTitle, wbGlobalSettings.sourceLanguageCode);
                wikiText = wbWikiModeConverter.getWikiFromHtmlDomElement(originalSrcContent.$translatedContent[0]);
            }

            if (wikiText) {
                wbPublishDisplayPane.getWikiTextareaElement().val(wikiText);
            }
        },

        //gets the textarea element available in wiki edit page
        getWikiTextareaElement: function() {
            return $("#" + wbWikiSite.wikiComposeTextArea , wbPublishDisplayPane.wbChildWikipedia.document);
        },

        //gets the Summery Field element available in wiki edit page
        getWikiSummeryFieldElement: function() {
            return $("#" + wbWikiSite.wikiSummeryField , wbPublishDisplayPane.wbChildWikipedia.document);
        },

        // checks the inverwiki link and creates if it does not exist.
        insertInterWikiLink: function(wikiContent) {
            var regEx = new RegExp("\\[\\[" + wbGlobalSettings.sourceLanguageCode + ":.*\\]\\]", "gi");
            if (wikiContent.search(regEx) === -1) {
                wikiContent = wikiContent + "\n[[" + wbGlobalSettings.sourceLanguageCode + ":" + wbGlobalSettings.sourceLanguageArticleTitle + "]]";
            }
            return wikiContent;
        }

    };

    //shortcut for 'publishDisplayPane' class
    wbPublishDisplayPane = wikiBhasha.paneManagement.publishDisplayPane;

    //Pane to display the original source article content
    wikiBhasha.paneManagement.sourceOriginalPane = {
        contentDivId: "wbSourceOriginalArticlePane",
        $contentElem: null,
        $currentChildElem: null,
        isEmptyNow: null,

        initialize: function() {
            wbUIHelper.changeCursorToHourGlass();
            wbSourceOriginalPane.contentLang = wbGlobalSettings.sourceLanguageCode;
            this.$contentElem = $("<div>" + wbLocal.loadingElementContent + "</div>").attr("id", this.contentDivId);
            if (!wbGlobalSettings.sourceLanguageArticleTitle) {

                //get source article title.
                wbWikiSite.getSourceTitle(wbGlobalSettings.targetLanguageCode, wbGlobalSettings.sourceLanguageCode,
                wbGlobalSettings.targetLanguageArticleTitle, function(title) {
                    if (title) {
                        wbSourceOriginalPane.isEmptyNow = false;
                        wbGlobalSettings.sourceLanguageArticleTitle = decodeURIComponent(title);
                        wbWikiSite.getArticleInWikiFormat(wbGlobalSettings.sourceLanguageCode,
                            wbGlobalSettings.sourceLanguageArticleTitle,
                            wbSourceOriginalPane.getArticleCallback);
                    }
                    else {
                        wbSourceOriginalPane.isEmptyNow = true;
                        //If source article title is not available then handle the empty source title.
                        wbSourceOriginalPane.handleEmptySourceTitle();
                    }
                });
            }
            else {
                wbSourceOriginalPane.isEmptyNow = false;
                wbWikiSite.getArticleInWikiFormat(wbGlobalSettings.sourceLanguageCode,
                            wbGlobalSettings.sourceLanguageArticleTitle,
                            wbSourceOriginalPane.getArticleCallback);
            }
            wbUIHelper.changeCursorToHourGlass();
        },

        //callback method to process article data
        getArticleCallback: function(data, historyItem) {
        if (data && data.length) {
                wbSourceOriginalPane.isEmptyNow = false;
                // Highlight wiki data
                var $childElem = wbDisplayPaneHelper.loadHighlightContent(data, wbSourceOriginalPane);

                if (!historyItem) {
                    // First time on initialization. Add new history item
                    historyItem = new wikiBhasha.historyManagement.historyEntity(wbGlobalSettings.sourceLanguageArticleTitle,
                        wbGlobalSettings.sourceLanguageCode, $childElem, null);
                    wbHistoryManager.addItem(wbGlobalSettings.sourceLanguageArticleTitle, wbGlobalSettings.sourceLanguageCode, historyItem);
                }
                else if (historyItem && historyItem.langId === wbGlobalSettings.sourceLanguageCode) {
                    // update history item
                    historyItem.content = $childElem;
                }
                else {
                    historyItem.content = "<div>" + wbLocal.sourceArticleNotApplicable + "</div>";
                }

                // pass it to 'wbSourceTranslatedPane'
                if (wbSourceTranslatedPane.isInitialized) {
                    wbSourceTranslatedPane.loadAndTranslateContent(data, $childElem, historyItem);
                }

                // Register links for history tracking and set pane titles using config info
                // Note: Register links for tracking only after passing this element to wbSourceTranslatedPane
                // because a jquery bug causes links to be disabled, if links are unbound in a cloned node.
                wbDisplayPaneHelper.registerLinksForHistoryTracking($childElem);
                wbDisplayPaneHelper.setPaneTitleFromConfig(wbSourceOriginalPane.$currentChildElem, wbSourceOriginalPane.paneConfigInfo);
            }
            else {
                wbSourceOriginalPane.isEmptyNow = true;
                wbSourceOriginalPane.loadEmptySourceTitle();
            }
        },
        // handles the empty source title
        handleEmptySourceTitle: function() {
            wbSplash.close();

            if (typeof (wbWorkflow.config.onSourceArticleAbsence.defaultStep) !== "undefined") {
                var defaultStep = wbWorkflow.config.onSourceArticleAbsence.defaultStep;
                wbMainWindow.loadContentIntoPanes(defaultStep, wbWorkflow.stepsArray);
            }
            wbSourceOriginalPane.loadEmptySourceTitle();
        },

        // loads the messge 'No inter-wiki-linked source lnaguage article...' on the panes.
        loadEmptySourceTitle: function() {
            var messageForEmptySourceTitle = wbGlobalSettings.noSourceArticleInfoWindowHTML;

            //change the relative path of image url to absolute path
            messageForEmptySourceTitle = messageForEmptySourceTitle.replace(/src="([a-zA-Z.\/-]*)"/g, function(matchedPattern, matchedValue) {
                var absoluteImageUrl = wbGlobalSettings.baseUrl + matchedValue;
                return 'src="' + absoluteImageUrl + '"';
            });

            //FF fix: adding an extra space at the end of 'messageForEmptySourceTitle' enables user to copy text into 'contentEditable' area
            wbDisplayPaneHelper.loadHighlightContent(messageForEmptySourceTitle + "&nbsp;", wbSourceOriginalPane, true /*do not parse*/, true /*is system text */);
            if (wbSourceTranslatedPane.isInitialized) {
                wbDisplayPaneHelper.loadHighlightContent(messageForEmptySourceTitle + "&nbsp;", wbSourceTranslatedPane, true /*do not parse*/, true /*is system text */);
            }
        },

        onHistoryChanged: function(historyItem) {
            var title = historyItem.title;
             
            if (historyItem.langId === wbGlobalSettings.sourceLanguageCode) {
                //If content available in history item
                if (historyItem.content) {
                    //load content from history item
                    wbDisplayPaneHelper.loadHighlightContent(historyItem.content, wbSourceOriginalPane);
                    wbDisplayPaneHelper.setPaneTitleFromConfig(wbSourceOriginalPane.$currentChildElem, wbSourceOriginalPane.paneConfigInfo);

                    // Rehook events to links. Once element is removed and added back, link events disappear, so rehooking is needed.
                    wbDisplayPaneHelper.registerLinksForHistoryTracking(wbSourceOriginalPane.$currentChildElem);
                    //getting the language service provider object for CTF popup
                    if(wbLanguageServices.fetchLanguageServiceProviderObject){
                        wbLanguageServices.fetchLanguageServiceProviderObject(historyItem);
                    }
                }
                else {
                    //if content not available in history item then load it from API calls
                    wbUIHelper.changeCursorToHourGlass();
                    wbDisplayPaneHelper.loadHighlightContent(wbLocal.loadingElementContent, wbSourceOriginalPane);

                    // Load the wiki article asynchronously 
                    wbWikiSite.getArticleInWikiFormat(wbGlobalSettings.sourceLanguageCode, title,
                        function(data) {
                            wbSourceOriginalPane.getArticleCallback(data, historyItem);
                        });
                }
            }
            else {
                this.$contentElem.html("<div>" + wbLocal.sourceArticleNotApplicable + "</div>");
            }
            //apply the CTF popup state
            wbDisplayPaneManager.toggleCTFDisplay();
        },

        onShow: function() {
            wbDisplayPaneHelper.setPaneTitleFromConfig(wbSourceOriginalPane.$currentChildElem, wbSourceOriginalPane.paneConfigInfo);
            wbDisplayPaneHelper.setPaneEditPropertyFromConfig(wbSourceOriginalPane.$currentChildElem, wbSourceOriginalPane.paneConfigInfo);
            // Rehook events to links. Once element is removed and added back, link events disappear, so rehooking is needed.
            wbDisplayPaneHelper.registerLinksForHistoryTracking(wbSourceOriginalPane.$currentChildElem);
        },

        onDisplayModeChanged: function(isShowWikimarkupMode) {
            var $contentElem = this.$currentChildElem;
            if (isShowWikimarkupMode) {
                wbWikiModeConverter.showWikiHighlightMode($contentElem[0]);
            }
            else {
                wbWikiModeConverter.showHybridMode($contentElem[0]);
            }
            // Rehook events to links. Once DOM elements change, link events disappear, so rehooking is needed.
            wbDisplayPaneHelper.registerLinksForHistoryTracking($contentElem);
        }
    };
    //shortcut for 'sourceOriginalPane' class
    wbSourceOriginalPane = wikiBhasha.paneManagement.sourceOriginalPane;

    //Pane to show translated source article content
    wikiBhasha.paneManagement.sourceTranslatedPane = {
        contentDivId: "wbSourceTranslatedArticlePane",
        $contentElem: null,
        $currentChildElem: null,

        initialize: function() {
            wbUIHelper.changeCursorToHourGlass();
            wbSourceTranslatedPane.contentLang = wbGlobalSettings.targetLanguageCode;
            this.$contentElem = $("<div>" + wbLocal.loadingElementContent + "</div>").attr("id", this.contentDivId);

            // set the orientation of the content based on the language
            if (wbGlobalSettings.direction === "rtl") {
                this.$contentElem.css("direction", wbGlobalSettings.direction);
                this.$contentElem.css("text-align", "right");
            }
        },
        //loads the article and then translates the article content
        loadAndTranslateContent: function($sourceText, sourceElem, historyItem) {
            // Clone the source element. Do not use jQuery.clone(), because jQuery's close sometimes adds extra tags.
            var sourceContent = (sourceElem) ? $(sourceElem[0].cloneNode(true)) :
                ($sourceText) ? $sourceText : wbLocal.emptySource;
            var $childElem = wbDisplayPaneHelper.loadHighlightContent(sourceContent, wbSourceTranslatedPane);
            wbDisplayPaneHelper.setPaneTitleFromConfig(wbSourceTranslatedPane.$currentChildElem, wbSourceTranslatedPane.paneConfigInfo);

            //If the loading page is actual wikipedia page, enable the links. Or if it was through WikiBhasha first step then disable the links.
            if (typeof (wbWorkflow.config.onTargetLanguageContentLoadAsResourcePage.newPaneTitles) !== "undefined"
                && wbHistoryManager.getSelectedItem().langId === wbGlobalSettings.targetLanguageCode) {
                // enable the links.
                wbDisplayPaneHelper.registerLinksForHistoryTracking($childElem);
            }
            else {
                //IE Fix:
                // Jquery doesnt let you bind the click event to anchor tag for dynamically created elements
                // for such elements use live to bind the events.
                // IE 7: fires onbefore unload event for all the links broken or not., hence to overcome this 
                // we need to attach a click event to the anchor tags, and return false to it. so its a combined fix.
                if ($.browser.msie && parseInt($.browser.version) === 7) {
                    // disable link clicks on content element.
                    $childElem.find("a").live('click', function() { return false; });
                }
                else {
                    $childElem.find("a").unbind("click");
                }
            }

            //If article is loaded for the first time then adds the same to history
            if (historyItem && historyItem.langId === wbGlobalSettings.sourceLanguageCode) {
                historyItem.$translatedContent = $childElem;
                if (sourceElem) {
                    var templatesTranslator = new wikiBhasha.contentManagement.templatesAndLinksTranslator($childElem[0], wbGlobalSettings.mtTargetLanguageCode, $sourceText);
                    templatesTranslator.translateTemplatesOnWikiTextBeforeTranslation();

                    wbDisplayPaneHelper.$showWikimarkupCheckBox.attr("disabled", "true").attr("title", wbLocal.waitUntilTranslationComplete);

                    wbUIHelper.changeCursorToHourGlass();
                    
                    wbLanguageServices.translateParallelElements(sourceElem, $childElem, function() {
                        //as soon as translation is done, enable the toggle mode check box.
                        wbDisplayPaneHelper.$showWikimarkupCheckBox.removeAttr("disabled").removeAttr("title");
                        //start conversion of interwiki links by using wikisite's apis.
                        templatesTranslator.startInterwikiConversion();
                        //if application window is closed by the time translation is completed, close the translation toolbar.
                        if (wbLanguageServices.exitButtonElementId && $("#" + wbMainWindow.windowId).length === 0) {
                            $("#" + wbLanguageServices.exitButtonElementId).get(0).onclick();
                        }
                        //create language service provider object in the history item 
                        if(wbLanguageServices.setLanguageServiceProviderObject){
                            wbLanguageServices.setLanguageServiceProviderObject(historyItem);
                        }
                        wbDisplayPaneManager.toggleCTFDisplay();
                        //as soon as translation is done, enable the default Cursor
                        wbUIHelper.changeCursorToDefault();
                    });
                    
                }
            }
            //else updates the history item with the content
            else if (historyItem) {
                historyItem.content = $childElem;
                //create language service provider object in the history item
                if(wbLanguageServices.setLanguageServiceProviderObject){
                    wbLanguageServices.setLanguageServiceProviderObject(historyItem);
                }
            }
        },

        onHistoryChanged: function(historyItem) {
            if (historyItem.langId === wbGlobalSettings.sourceLanguageCode) {
                if (historyItem.$translatedContent) {
                    // Content already exists, so just plop it in.
                    wbDisplayPaneHelper.loadHighlightContent(historyItem.$translatedContent, wbSourceTranslatedPane);

                    wbDisplayPaneHelper.setPaneTitleFromConfig(wbSourceTranslatedPane.$currentChildElem, wbSourceTranslatedPane.paneConfigInfo);
                }
                else {
                    // If it does not exist, the new content will be loaded asynchronously by 'loadAndTranslateContent' method
                    // Show "loading..." message till then
                    wbUIHelper.changeCursorToHourGlass();
                    wbDisplayPaneHelper.loadHighlightContent(wbLocal.loadingElementContent, wbSourceTranslatedPane);

                }
            }
            else if (historyItem.langId === wbGlobalSettings.targetLanguageCode && historyItem.content !== null) {
                //If the history article is from target language and has content in history then load the content to pane.
                wbDisplayPaneHelper.loadHighlightContent(historyItem.content, wbSourceTranslatedPane);

                wbDisplayPaneHelper.setPaneTitleFromConfig(wbSourceTranslatedPane.$currentChildElem, wbSourceTranslatedPane.paneConfigInfo);
            }
            else {
                // If it does not exist, the new content will be loaded asynchronously by 'getArticleInWikiFormat' method below
                // Show "loading..." message till then
                wbUIHelper.changeCursorToHourGlass();
                wbDisplayPaneHelper.loadHighlightContent(wbLocal.loadingElementContent, wbSourceTranslatedPane);
                wbWikiSite.getArticleInWikiFormat(historyItem.langId,
                    historyItem.title,
                    function(data) {
                        wbSourceTranslatedPane.loadAndTranslateContent(data, null, historyItem);
                    });

            }
        },

        onShow: function() {
            wbDisplayPaneHelper.setPaneTitleFromConfig(wbSourceTranslatedPane.$currentChildElem, wbSourceTranslatedPane.paneConfigInfo);
            wbDisplayPaneHelper.setPaneEditPropertyFromConfig(wbSourceTranslatedPane.$currentChildElem, wbSourceTranslatedPane.paneConfigInfo);

            //if the left pane is not set to contentEditable then enable the links, otherwise disable them
            var currentStepPaneEditable = wbWorkflow.stepsArray[wbWorkflow.config.currentStep].panesData[0].isContentEditable;
            if (currentStepPaneEditable === false) {
                wbDisplayPaneHelper.registerLinksForHistoryTracking(wbSourceTranslatedPane.$currentChildElem);
            }
            else if (wbSourceTranslatedPane.$currentChildElem) {
                wbSourceTranslatedPane.$currentChildElem.find("a").unbind("click");
            }
        },

        onDisplayModeChanged: function(isShowWikimarkupMode) {
            var $contentElem = this.$currentChildElem;
            if (isShowWikimarkupMode) {
                wbWikiModeConverter.showWikiHighlightMode($contentElem[0]);
            }
            else {
                wbWikiModeConverter.showHybridMode($contentElem[0]);
            }
        }
    };
    //shortcut for 'sourceTranslatedPane' class
    wbSourceTranslatedPane = wikiBhasha.paneManagement.sourceTranslatedPane;

    //Pane to show target article content
    wikiBhasha.paneManagement.targetContentPane = {
        contentDivId: "wbTargetContentPane",
        $contentElem: null,
        isEmptyNow: true,

        initialize: function() { 
            wbUIHelper.changeCursorToHourGlass();
            wbTargetContentPane.contentLang = wbGlobalSettings.targetLanguageCode;
            wbTargetContentPane.$contentElem = $("<div>" + wbLocal.loadingElementContent + "</div>").attr("id", this.contentDivId);
           
            // set the orientation of the content based on the language
            if (wbGlobalSettings.direction === "rtl") {
                this.$contentElem.css("direction", wbGlobalSettings.direction);
                this.$contentElem.css("text-align", "right");
            }

            var targetArticleWikiApi = wbUtil.stringFormat(wbWikiSite.wikiArticleMarkupAPI, wbGlobalSettings.targetLanguageCode, encodeURIComponent(wbGlobalSettings.targetLanguageArticleTitle.replace("%20", " ")));
            $.getJSON(targetArticleWikiApi, 'callback=?', function(data) {
                var pages = data.query.pages,
                    articleFormattedText = null;

                for (var i in pages) {
                    if (pages[i].revisions) {
                        articleFormattedText = pages[i].revisions[0]["*"];
                        break;
                    }
                }

                if (!articleFormattedText) { // New article case
                    // for this new article, if user already visited compose pane, then we should copy the translated content
                    // automatically to targetContentPane. This is for better usability.
                    if (wbPublishDisplayPane.isInitialized && wbPublishDisplayPane.isWikiPediaEditWindowLoaded && wbGlobalSettings.isNewArticle) {
                        // get the translated and corrected content of the original source article for which the user is intended to create local language version
                        var originalSrcContent = wbHistoryManager.getHistoryEntity(wbGlobalSettings.sourceLanguageArticleTitle, wbGlobalSettings.sourceLanguageCode);

                        wbDisplayPaneHelper.bringHistoryItemTransContentToPane(originalSrcContent, wbTargetContentPane);
                        wbTargetContentPane.isEmptyNow = false;
                    }
                    else {
                        wbTargetContentPane.isEmptyNow = true;
                        
                        if(wbSourceOriginalPane.isEmptyNow === false){
                            // This is a new article with no content. So show a link for easy transfer of content from left pane to right pane.
                            articleFormattedText = wbGlobalSettings.bringContentFromPaneWindowHTML;
                            //change the relative path of image url to absolute path
                            articleFormattedText = articleFormattedText.replace(/src="([\S]*)"/g, function(matchedPattern, matchedValue) {
                                if(matchedValue.charAt(0)=='/'){
                                    return 'src="' + (wbGlobalSettings.imgBaseUrl ? wbGlobalSettings.imgBaseUrl : wbGlobalSettings.baseUrl) + matchedValue.slice(1, (matchedValue.length)) + '"';
                                } else {
                                    return 'src="' + (wbGlobalSettings.imgBaseUrl ? wbGlobalSettings.imgBaseUrl : wbGlobalSettings.baseUrl) + matchedValue + '"';
                                }
                            });
                        
                            //FF fix: adding an extra space at the end of 'articleFormattedText' enables user to copy text into 'contentEditable' area
                            wbDisplayPaneHelper.loadHighlightContent(articleFormattedText + "&nbsp;", wbTargetContentPane, true /*do not parse*/, true /*is system text */);
                            wbTargetContentPane.$currentChildElem.attr("contentEditable", "false");
                            wbTargetContentPane.addClickEventToImage();
                        }else{
                            // If the source article is empty, don't show any message and make the pane editable
                            wbDisplayPaneHelper.loadHighlightContent("", wbTargetContentPane);
                            wbTargetContentPane.$currentChildElem.attr("contentEditable", "true");
                            wbTargetContentPane.isEmptyNow = false;
                        }
                    }
                }
                else { // existing article case
                    wbTargetContentPane.isEmptyNow = false;
                    wbDisplayPaneHelper.loadHighlightContent(articleFormattedText, wbTargetContentPane);
                    wbUIHelper.changeCursorToDefault();
                }
                return;
            });

        },
        
        // adds the click event to buttons when there is no target language article
        addClickEventToImage: function() {
            $("#wbBCFPyesButton").click(function() {
                // get the translated and corrected content of the original source article for which the user is intended to create local language version
                var originalSrcContent = wbHistoryManager.getHistoryEntity(wbGlobalSettings.sourceLanguageArticleTitle, wbGlobalSettings.sourceLanguageCode);

                if (wbDisplayPaneHelper.bringHistoryItemTransContentToPane(originalSrcContent, wbTargetContentPane)) {
                    wbTargetContentPane.$currentChildElem.attr("contentEditable", "true");
                    wbTargetContentPane.isEmptyNow = false;
                    return true;
                }
                return false;
            });
            $("#wbBCFPcancelButton").click(function() {
                wbDisplayPaneHelper.loadHighlightContent("", wbTargetContentPane);
                wbTargetContentPane.$currentChildElem.attr("contentEditable", "true");
                wbTargetContentPane.isEmptyNow = false;
                return true;
            });
        },

        onDisplayModeChanged: function(isShowWikimarkupMode) {
            var $contentElem = this.$currentChildElem || this.$contentElem;
            if (isShowWikimarkupMode) {
                wbWikiModeConverter.showWikiHighlightMode($contentElem[0]);
            }
            else {
                wbWikiModeConverter.showHybridMode($contentElem[0]);
            }
        },

        onShow: function() {
            wbDisplayPaneHelper.setPaneTitleFromConfig(wbTargetContentPane.$currentChildElem, wbTargetContentPane.paneConfigInfo);
            if (!wbTargetContentPane.isEmptyNow) {
                wbDisplayPaneHelper.setPaneEditPropertyFromConfig(wbTargetContentPane.$currentChildElem, wbTargetContentPane.paneConfigInfo);
            }
            else {
                wbTargetContentPane.addClickEventToImage();
            }
        }
    };
    //shortcut for 'targetContentPane' class
    wbTargetContentPane = wikiBhasha.paneManagement.targetContentPane;

    //manages the manipulation of above defined panes according to the given configuration.
    wikiBhasha.paneManagement.displayPaneManager = {
        initialize: function() {
            this.$leftPaneContainer = $("#wbSourceArticleContentDiv");
            this.$rightPaneContainer = $("#wbRightWindowContentDiv");
        },

        //list of defined pane classes
        allPanesArray: [
            wikiBhasha.paneManagement.sourceOriginalPane,
            wikiBhasha.paneManagement.sourceTranslatedPane,
            wikiBhasha.paneManagement.targetContentPane,
            wikiBhasha.paneManagement.publishDisplayPane
        ],

        allPanesMap: null,

        $leftPaneContainer: null,
        $rightPaneContainer: null,

        //returns the pane for the given 'paneId'
        getPaneForId: function(paneId) {
            var allPanesMap = this.allPanesMap,
                allPanesArray = this.allPanesArray;
            if (!allPanesMap) {
                allPanesMap = {};
                // Initialize 'allPanesMap' with data from 'allPanesArray' for quick lookup
                for (var i = 0; i < allPanesArray.length; i++) {
                    var pane = allPanesArray[i];
                    if (pane) {
                        allPanesMap[pane.contentDivId] = pane;
                    }
                }
                this.allPanesMap = allPanesMap;
            }

            var lookupPane = allPanesMap[paneId];
            if (lookupPane && !lookupPane.isInitialized) {
                lookupPane.initialize();
                lookupPane.isInitialized = true;
            }
            return lookupPane;
        },
        //resolves the pane element id for given pane element
        resolvePaneElementId: function(paneElem) {
            if (typeof (paneElem) === "string") {
                return this.getPaneForId(paneElem.replace(/#/, ""));
            }
            return paneElem;
        },

        //adds the given pane data to parent pane element
        addPane: function(paneData, parentElement) {
            var paneElement = this.resolvePaneElementId(paneData.pane);
            paneElement.paneConfigInfo = paneData;

            var oldChildren = parentElement.children();
            if (oldChildren && oldChildren.length > 0) {
                oldChildren.hide();
            }

            //If 'doNotAppendAgain' property present for any pane then
            //that pane content won't be removed from the DOM tree.
            if (typeof paneElement.doNotAppendAgain === "undefined" || paneElement.doNotAppendAgain === false) {
                paneElement.$contentElem.remove();
                parentElement.append(paneElement.$contentElem);

                //Make the value as 'true' so that next time this pane won't enter this IF condition
                if (paneElement.doNotAppendAgain === false) {
                    paneElement.doNotAppendAgain = true;
                }
            }

            if(paneElement.$contentElem){
                paneElement.$contentElem.show();
                if (paneElement.onShow) {
                    paneElement.onShow();
                }
            }
        },

        // returns true if required pane can be hiden, such as when the current step is changed.
        canHidePane: function(paneData) {
            if (paneData) {
                var paneElement = this.resolvePaneElementId(paneData.pane);
                if (paneElement && paneElement.canHide) {
                    return paneElement.canHide();
                }
            }
            return true;
        },

        //displays single pane layout on application UI
        displaySinglePane: function(paneData) {
            wbDisplayPaneManager.setupSinglePaneLayout(paneData.title);
            wbUIHelper.showLightBox();

            //add given pane to the display holder
            wbDisplayPaneManager.addPane(paneData, wbDisplayPaneManager.$leftPaneContainer);
        },

        //displays double pane layout on application UI
        displayDoublePane: function(paneData1, paneData2) {
            //determine left and right panes data
            var leftPaneData = (paneData1.paneIndex === 0) ? paneData1 : paneData2;
            var rightPaneData = (paneData1.paneIndex === 1) ? paneData1 : paneData2;

            wbDisplayPaneManager.setupDoublePaneLayout(leftPaneData.title, rightPaneData.title);

            wbUIHelper.showLightBox();

            //add given panes to left and right side display holder
            wbDisplayPaneManager.addPane(leftPaneData, wbDisplayPaneManager.$leftPaneContainer);
            wbDisplayPaneManager.addPane(rightPaneData, wbDisplayPaneManager.$rightPaneContainer);
            
            //adjust the panes dimension.
            wbResizeManager.windowResize();
        },

        isInSinglePaneLayout: null,

        //sets up single pane layout on application UI
        setupSinglePaneLayout: function(title) {
            // return early if we are already in single pane layout
            if (this.isInSinglePaneLayout) {
                return;
            }

            var $wbLeftWindowElement = $("#wbLeftWindow"),
                $wbHandleDivElement = $("#wbHandleDiv");

            $("#wbLeftPaneTitle").html(title);

            $("#wbRightWindow").hide();
            $("#wbCollapseLeftWindowBtn").hide();
            $("#wbRightWindowCollapsed").hide();

            //if left window is hidden            
            if ($wbLeftWindowElement.is(":hidden")) {
                //hide left window collapse pane
                $("#wbLeftWindowCollapsed").hide();
                //show left window pane
                $wbLeftWindowElement.show();
            }

            //hide the width adjust bar
            $wbHandleDivElement.hide();

            //adjust pane width
            $("#wbRightPane").css("width", "0px");
            $("#wbLeftPane").css("width", $("#wbSplitter").width());
            $("#wbLeftWindowContentDiv").css("width", "100%");
            $("#wbRightCollapsedTable").css("width", "0px");

            //unbind the mouse down event
            $wbHandleDivElement.unbind("mousedown", wbSplitterManager.startSplitMouse);

            this.isInSinglePaneLayout = true;
        },

        //sets up double pane layout on application UI
        setupDoublePaneLayout: function(title1, title2) {
            // return early if we are already in two pane layout
            if (this.isInSinglePaneLayout === false) {
                return;
            }

            var $wbSplitterWidth = $("#wbSplitter").width(),
                wbLeftPane = $("#wbLeftPane"),
                wbHandleDiv = $("#wbHandleDiv");

            $("#wbLeftPaneTitle").html(title1);
            $("#wbRightPaneTitle").html(title2);

            $("#wbCollapseLeftWindowBtn").show();
            $("#wbRightWindowCollapsed").hide();
            $("#wbRightWindow").show();

            //adjust left pane and right pane width            
            wbLeftPane.css("width", ($wbSplitterWidth / 2) - wbGlobalSettings.splitterMargin);
            $("#wbRightPane").css("width", $wbSplitterWidth - wbLeftPane.width() - wbGlobalSettings.$splitterWidth);

            //Show the width adjust bar            
            wbHandleDiv.show();

            //bind the mouse down event
            wbHandleDiv.bind("mousedown", wbSplitterManager.startSplitMouse);

            wbSplash.close();

            this.isInSinglePaneLayout = false;
        },

        //toggles between wiki and hybrid mode
        toggleDisplayMode: function() {
            var isShowWikimarkupMode = wbDisplayPaneHelper.isShowWikimarkupChecked();

            for (var i = 0; i < this.allPanesArray.length; i++) {
                var pane = this.allPanesArray[i];
                if (pane && pane.isInitialized && pane.onDisplayModeChanged) {
                    pane.onDisplayModeChanged(isShowWikimarkupMode);
                }
            }

            // log the fact that user used this feature
            wbLoggerService.logFeatureUsage(wbGlobalSettings.sessionId, "WikiModeSwitch", isShowWikimarkupMode);
        },

        //enable/disable CTF popup display
        toggleCTFDisplay: function() {
            var isShowCTFPopup = wbDisplayPaneHelper.isShowCTFPopupChecked();
            if (wbLanguageServices.onCTFDisplayModeChanged) {
                wbLanguageServices.onCTFDisplayModeChanged(isShowCTFPopup);
            }

            // log the fact that user used this feature
            wbLoggerService.logFeatureUsage(wbGlobalSettings.sessionId, "CTFPopupDisplay", isShowCTFPopup);
        },

        //removes content DIVs from application display.
        removeContentDiv: function(parentElement) {
            var previousArticleContent = parentElement.find(".articleContentDiv");
            if (previousArticleContent && previousArticleContent.length > 0) {
                for (var i = 0; i < previousArticleContent.length; i++) {
                    var elementToRemove = previousArticleContent.get(i);
                    elementToRemove.parentNode.removeChild(elementToRemove);
                }
            }
            else {
                parentElement.html("");
            }
        }
    };
    //shortcut for 'displayPaneManager' class
    wbDisplayPaneManager = wikiBhasha.paneManagement.displayPaneManager;

    //class to hold utility methods for 'displayManager' class
    wikiBhasha.paneManagement.displayPaneHelper = {
        $showWikimarkupCheckBox: null,

        initialize: function() {
            wbDisplayPaneHelper.$showWikimarkupCheckBox = $("#wbToggleWikiFormat");
            wbDisplayPaneHelper.$showCTFPopup = $("#wbToggleCTF");
            $('.wbHybridTemplate').live('mouseover', function () { wbWikiMarkupEdit.showMenu(this); });
            //TODO: uncomment this to implement the template preview popup for wikimarkup preview
            //$('.wbHybridTag').live('mouseover', function () { wbWikiMarkupEdit.showMenu(this); });
        },

        //checks the value of display mode check box.
        isShowWikimarkupChecked: function() {
            return wbDisplayPaneHelper.$showWikimarkupCheckBox.attr("checked");
        },

        //checks the value of CTF popup display check box.
        isShowCTFPopupChecked: function() {
            return wbDisplayPaneHelper.$showCTFPopup.attr("checked");
        },

        //loads the content to pane and highlights it using wiki or hybrid mode appropriately
        loadHighlightContent: function(childContent, displayPane, doNotParse, isSystemText) {
            wbUIHelper.changeCursorToHourGlass();
            var parentElem = displayPane.$contentElem,
                $childElem = childContent,
                wikiTextContent = null;
            if (typeof childContent === "string") {
                $childElem = $("<div class='articleContentDiv'/>");
                wikiTextContent = childContent;
            }

            if (!doNotParse) {
                if (wbDisplayPaneHelper.isShowWikimarkupChecked()) {
                    wbWikiModeConverter.showWikiHighlightMode($childElem[0], wikiTextContent);
                }
                else {
                    wbWikiModeConverter.showHybridMode($childElem[0], wikiTextContent);
                }
            }
            else {
                // Warning!!! Script injection is possible as we are setting innerHTML for passed childContent.
                // We should be injection only text from localized strings, not user's input. Additional
                // param "isSystemText" validates this one more time along with doNotParse param
                if (isSystemText) {
                    $childElem.html(wikiTextContent);
                }
            }

            displayPane.$currentChildElem = $childElem;
            wbDisplayPaneHelper.setPaneEditPropertyFromConfig($childElem, displayPane.paneConfigInfo);

            wbDisplayPaneManager.removeContentDiv(parentElem);
            parentElem.append($childElem);
            wbUIHelper.changeCursorToDefault();
            return $childElem;
        },

        //brings the translated and corrected content of the given history item to the given panes
        bringHistoryItemTransContentToPane: function(historyItem, toPane) {
        wbUIHelper.changeCursorToHourGlass();
            var $toPaneElement = toPane.$contentElem[0].childNodes[0];
            //Allow the user to navigate through hyper click only after translation completes.
            if (!wbDisplayPaneHelper.alertIfTranslationNotDone()) {
                return false;
            }

            if ($toPaneElement) {
                //if the node is textNode
                if ($toPaneElement.nodeType === 3) {
                    //check whether pane is set for contentEditable or not. 
                    //If so, create a DIV with contentEditable property and set this as '$toPaneElement' to copy the content to.
                    if (typeof toPane.paneConfigInfo.isContentEditable !== "undefined" && toPane.paneConfigInfo.isContentEditable === true) {
                        $toPaneElement = $toPaneElement.parentNode;
                        $toPaneElement.innerHTML = "";
                        $("<div class='articleContentDiv' contentEditable='true'></div>").appendTo($($toPaneElement));
                        $toPaneElement = $($toPaneElement)[0].childNodes[0];
                        
                    }
                    else {
                        //otherwise refer its parent node to append the content
                        $toPaneElement = $toPaneElement.parentNode;
                    }
                }
                $toPaneElement.innerHTML = historyItem.$translatedContent[0].innerHTML;
            }
            wbUIHelper.changeCursorToDefault();
            return true;
        },

        //applies config values to given pane
        setPaneEditPropertyFromConfig: function($contentElem, paneConfigInfo) {
            if ($contentElem) {
                var isContentEditable = paneConfigInfo && paneConfigInfo.isContentEditable;
                $contentElem.attr("contentEditable", (isContentEditable) ? "true" : "false");
            }
        },

        //configures the compose area for wikipedia edit page pane
        configureComposeArea: function() {
            //child window document object
            var childWindowDoc = wbPublishDisplayPane.wbChildWikipedia.document;

            //removing unwanted divs from compose area
            $(wbWikiSite.wikiEditPageNonCriticalDivs, childWindowDoc).hide();
            //set margin
            $(wbWikiSite.wikiComposeDiv, childWindowDoc).css("margin-left", 0).css("margin-right", 0);
            //disable links inside compose area
            $(wbWikiSite.wikiComposeLinks, childWindowDoc).click(function() { return false; });
        },

        //checks the translateion status and returns true if it was done otherwise it returns false.
        alertIfTranslationNotDone: function() {
            if (wbDisplayPaneHelper.$showWikimarkupCheckBox[0].disabled) {
                window.alert(wbLocal.waitUntilTranslationComplete);
                return false;
            }
            else {
                return true;
            }
        },

        //when user clicks on any link available within the article, this method checks the existence of article available for the clicked link, 
        //if so load the same into the application.
        onArticleLinkClick: function(langDefault, titleDefault) {
            
            //Allow the user to navigate through hyper click only after translation completes.
            if (!wbDisplayPaneHelper.alertIfTranslationNotDone()) {
                return false;
            }

            //determine the 'langId' and 'title' values
            var langId,
                linkClicksConfig = wbWorkflow.config.onSourceArticleTranslatedContentLinksClicked;
            //if links are enabled for translated source article content then always choose traget language code.
            if (typeof linkClicksConfig.stepsToConsider !== "undefined" &&
                linkClicksConfig.stepsToConsider[wbWorkflow.config.currentStep] && typeof langDefault !== "string") {
                langId = wbGlobalSettings[linkClicksConfig.languageCodeToChoose];
            }
            else {
                langId = (typeof langDefault === "string") ? langDefault : wbHistoryManager.getSelectedItem().langId;
            }

            var data = (this.parentNode) ? wbUtil.getDataAttribute(this.parentNode): null;
            var title = (typeof titleDefault === "string") ? titleDefault : (data || this.innerHTML);
            var historyItem = null;

            //check if the user clicked title exists in Wikipedia or not
            wbWikiSite.isArticleAvailable(langId, title, function(isArticleAvailable) {
                
                if (!isArticleAvailable) {
                    window.alert(wbLocal.noTargetLanguageArticleFound);
                    return false;
                }
                else {
                    wbUIHelper.changeCursorToHourGlass();
                    wbSourceOriginalPane.isEmptyNow = false;
                    //if article exists in history; load the article content from the same
                    if (wbHistoryManager.isExists(title, langId)) {
                        historyItem = wbHistoryManager.getHistoryEntity(title, langId);
                        wbHistoryManager.setSelectedItem(title, langId);
                    }
                    //else load the article content from API call
                    else {
                        historyItem = new wikiBhasha.historyManagement.historyEntity(title, langId, null, null);
                        wbHistoryManager.addItem(title, langId, historyItem);
                    }

                    wbDisplayPaneHelper.updatePanesWithHistoryItem(historyItem);

                    wbLoggerService.logFeatureUsage(wbGlobalSettings.sessionId, "AdditionalResourceArticle", title, langId);

                    //make sure to hide all other windows before loading a new article
                    wbSearch.hide();
                    wbScratchPad.hide();
                    wbFeedback.hide();
                    wbTutorial.hide();
                    wbUIHelper.changeCursorToDefault();
                    return false;
                }
            });
        },

        //updates panes with history item content
        updatePanesWithHistoryItem: function(historyItem) {
            wbUIHelper.changeCursorToHourGlass();
            // call history changed on all panes that ask for history change event
            var allPanesArray = wbDisplayPaneManager.allPanesArray;
            for (var i = 0; i < allPanesArray.length; i++) {
                var pane = allPanesArray[i];
                if (pane && pane.onHistoryChanged) {
                    pane.onHistoryChanged(historyItem);
                }
            }

            if (historyItem.langId !== wbGlobalSettings.sourceLanguageCode
                && typeof (wbWorkflow.config.onTargetLanguageContentLoadAsResourcePage.defaultStep) !== "undefined") {
                var defaultStep = wbWorkflow.config.onTargetLanguageContentLoadAsResourcePage.defaultStep;
                wbMainWindow.loadContentIntoPanes(defaultStep, wbWorkflow.stepsArray);
            }
            else if (historyItem.langId === wbGlobalSettings.sourceLanguageCode
                && typeof (wbWorkflow.config.onSourceLanguageContentLoadAsResourcePage.defaultStep) !== "undefined") {
                var defaultStep = wbWorkflow.config.onSourceLanguageContentLoadAsResourcePage.defaultStep;
                wbMainWindow.loadContentIntoPanes(defaultStep, wbWorkflow.stepsArray);
            }
            wbUIHelper.changeCursorToDefault();
        },

        //binds the click event on available links in a given article
        registerLinksForHistoryTracking: function($contentElem) {
            if ($contentElem) {
                $contentElem.find("a").click(wbDisplayPaneHelper.onArticleLinkClick);
            }
        },

        //get the pane id of the pane in which the element exists
        getElementsPaneDivId: function (elem) {
            return $(elem).closest('.articleContentDiv').parent().attr('id');
        },

        //sets pane title according to the format given in configuration.
        setPaneTitleFromConfig: function($contentElem, paneConfigInfo) {
            var paneTitle = paneConfigInfo.title;
            if (typeof (wbWorkflow.config.onTargetLanguageContentLoadAsResourcePage.newPaneTitles) !== "undefined"
                && wbHistoryManager.getSelectedItem().langId === wbGlobalSettings.targetLanguageCode) {
                var newPaneTitles = wbWorkflow.config.onTargetLanguageContentLoadAsResourcePage.newPaneTitles;
                paneTitle = newPaneTitles[paneConfigInfo.pane] || paneTitle;
            }

            // get the title of the 
            var currentTitle = wbHistoryManager.getSelectedItem().title;

            // check the availability of the pane title
            var isTitleExists;

            // check if the title configuration has “{sourceArticleTitle}”
            if (paneConfigInfo.title.search(/{sourceArticleTitle}/ig) !== -1) {
                isTitleExists = (currentTitle.length === 0) ? false : true;
            }

            // check if the title configuration has “{targetArticleTitle}”
            if (paneConfigInfo.title.search(/{targetArticleTitle}/ig) !== -1) {
                isTitleExists = (wbGlobalSettings.targetLanguageArticleTitle.length === 0) ? false : true;
            }

            // check if the title configuration has both "{sourceArticleTitle}" and "{targetArticleTitle}”
            if (paneConfigInfo.title.search(/{sourceArticleTitle}/ig) !== -1 && paneConfigInfo.title.search(/{targetArticleTitle}/ig) !== -1) {
                isTitleExists = (currentTitle.length !== 0 && wbGlobalSettings.targetLanguageArticleTitle.length !== 0) ? true : false;
            }

            //if panes data is not fully loaded, use default title
            if (!isTitleExists) {
                paneTitle = paneConfigInfo.defaultTitle;
            }
            //if 'paneTitle' is available in config then use the format to populate titles
            else {
                paneTitle = paneTitle.replace(/{sourceArticleTitle}/gi, currentTitle);
                paneTitle = paneTitle.replace(/{targetArticleTitle}/gi, wbGlobalSettings.targetLanguageArticleTitle);
                paneTitle = paneTitle.replace(/{sourceLanguage}/gi, wbGlobalSettings.sourceLanguageCode);
                paneTitle = paneTitle.replace(/{targetLanguage}/gi, wbGlobalSettings.targetLanguageCode);
            }

            var titleElem = (paneConfigInfo.paneIndex === 0) ? $("#wbLeftPaneTitle") : $("#wbRightPaneTitle"),
                originalPaneTitle = paneTitle;
            //FF fix: As firefox doesn't support CSS property 'text-verflow:ellipsis',
            //we need to user a JavaScript method which handles the same on a given string.
            if ($.browser.mozilla) {
                paneTitle = wbUtil.truncateString(paneTitle, wbGlobalSettings.paneTitleCutoffLength, true /*suffix required*/);
            }
            titleElem.html(paneTitle).attr("title", originalPaneTitle);
        }
    };
    //shortcut for 'displayPaneHelper' class
    wbDisplayPaneHelper = wikiBhasha.paneManagement.displayPaneHelper;
})();
