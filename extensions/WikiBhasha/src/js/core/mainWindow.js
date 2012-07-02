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
* 1) mainWindow             - Describes the main application UI, initializes all the other application UI components(ex: workflow, contextmenu...)
* 2) contextMenuHandler     - Describes the custom context menu for the application, menu items of this context menu are extendible.        
* 3) splitterManager        - Includes all the methods and properties which manages splitter for the application. This splitter is used to adjust the width of the panes available in main application UI
* 4) resizeManager          - Includes all properties and methods for managing the resize of the application(which includes maximize and restore of application UI). 
* 5) tutorialWindow         - Describes the help window for the application, enables user to learn more about application.
*/

//make sure namespace exists
if (typeof (wikiBhasha.windowManagement) === "undefined") {
    wikiBhasha.windowManagement = {};
}

(function() {
    //Describes the main application UI, initializes all the other application UI components(ex: workflow, contextmenu...)
    wikiBhasha.windowManagement.mainWindow = {

        //main application window element Id.
        windowId: "wbTranslationWindow",

        previousNextButtonHideDelay: 500, //in milliseconds

        //displays appliction window on UI
        show: function() {

            //on launch make sure the page is at a scroll of (0,0) for a better user experience
            window.scrollTo(0, 0);

            //bind onscroll event to prevent scrolling of the page when application is present on UI
            $(window).bind('scroll', function() {
                window.scrollTo(0, 0);
            });

            //hide the scrollbars on the page
            wbUIHelper.hideScroll();

            wbUIHelper.createWindow(this.windowId, wbGlobalSettings.applicationWindowHTML);
            
            this.adjustWindowPosition();
            wbMainWindow.applyLocalization();
            
            
            //initialize various UI components
            wikiBhasha.windowManagement.resizeManager.initialize();
            wikiBhasha.windowManagement.splitterManager.initialize();
            wikiBhasha.windowManagement.contextMenuHandler.initialize();
            wikiBhasha.paneManagement.displayPaneHelper.initialize();
            wikiBhasha.paneManagement.displayPaneManager.initialize();
            wikiBhasha.historyManagement.historyManager.initialize();
            wikiBhasha.windowManagement.themes.initialize();
            wbScratchPad.initialize();
            wbSearch.initialize();
            wbFeedback.initialize();

            wbTransliterationServices.enableTransliteration(wbGlobalSettings.mtTargetLanguageCode);

            //when exit link clicked by user, removes the application from the document and UI
            $("#wbExitLink").click(function() {
                wbFeedback.onHideCallback = function() {
                    wbMainWindow.hide();
                };
                wbFeedback.isInvokedOnMainWindowExit = true;
                wbFeedback.show();
            });

            //when user clicks on the help button, loads the help window
            $("#wbHelpLink").click(function() {
                wbTutorial.show();
            });
            //set the title on the top header
            $("#wbLeftHeaderDiv").html(wbUtil.stringFormat("<p id='wbWorkingArticleLabel' > Target Article: '{0}' in  Language: '{1}'</p>", wbGlobalSettings.targetLanguageArticleTitle, wbGlobalSettings.targetLanguageDisplayName));
            
            wbResizeManager.bindCollapseEvents();
            wbMainWindow.attachEventRestrictions();
            wbMainWindow.loadWorkFlow();
            wbMainWindow.enablePreviousNextButtons();
            wbMainWindow.applyStepNamesToPreviousNextButtons(wbWorkflow.config.currentStep);

            //bind 'onbeforeunload' on window to show the warning message when the user goes out of WikiBhasha. 
            //few ways by which one can go out of WikiBhasha are, by refreshing, redirecting and close action.
            window.onbeforeunload = function() { return wbLocal.warningMsg; };

            //IE Fix: 
            if ($.browser.msie) {
                //The following code prevents the user to get redirected by the backspace key pressed on non-editable area in WikiBhasha. 
                //The template and wikimarkup icon images shown in the editable panes are also considered as non-editable.
                $('#'+wbMainWindow.windowId).keydown(function (event) { 
                    // check the key pressed is back space and if the content is editable or the selected item is non text content.
                    if (event.keyCode == 8 && ($(event.target).attr("contentEditable") !== 'true' || typeof(document.selection.createRange().text) == "undefined")) {//ascii value for backspace key is '8'
                        return false;
                    }else{
                        return true;
                    }
                });

                //restrict user from selecting text from UI elements as IE doesn't have any predefined HTML attribute to do the same.
                $("#wbSPDraggableHandle, #wbWrapperScratchPad, #wbScratchPadWindow, #scratchPadTable, .scratchContentLayoutRow, .scratchTopButtonLayout, .wbScratchPadSection, .scratchContentLayout, .scratchTopLayout, .wbWindowToolbarCenter, .wbHeader, .wbLeftWindowCollapsed, .wbRightWindowCollapsed, .wbLogoContainer, .wbTopButtonsDiv, .workflowNavigationBtns, .wbWindowContentLeft, .wbWindowContentRight").each(function() {
                    this.onselectstart = function() { return false; };
                });
            }
        },

        //adjusts the wikiBhasha window dimensions utilize the 90% of available window size
        //also makes sure that wikiBhasha window won't overlap with the Translation toolbar.
        adjustWindowPosition: function() {
            //do the necessary DOM lookups prior to wikiBhasha window adjustment.
            var $twoPaneOverlay = $("#" + this.windowId),
                $translationDiv = $("#wbTranslationDiv"),
                $leftPane = $("#wbLeftPane"),
                $rightPane = $("#wbRightPane"),
                $leftCollpaseContentDiv = $("#wbLeftCollapseContentDiv"),
                $rightCollapseContentDiv = $("#wbRightCollapseContentDiv"),
                $leftContentDiv = $("#wbLeftWindowContentDiv"),
                $leftWindow = $("#wbLeftWindow"),
                $rightWindow = $("#wbRightWindow"),
                $splitterContainer = $("#wbSplitter"),
                $handleDiv = $("#wbHandleDiv"),

                translationBarHeight = wbGlobalSettings.translationBarHeight,

            //parameters required for adjusting wikiBhasha window
                windowSize = wbUtil.getWindowInnerSize(),
            //get the 90% height from available window height for setting wikiBhasha height
                windowHeight = parseInt(windowSize[1] * 0.9),
            //use 5% of window height for setting wikiBhasha top position
                windowTop = parseInt(windowSize[1] * 0.05);

            //make sure that window top position is not less than translation toolbar height
            windowTop = (windowTop < translationBarHeight) ? translationBarHeight : windowTop;

            $translationDiv.css("height", windowHeight);
            $twoPaneOverlay.css("top", windowTop);

            var $transPos = $twoPaneOverlay.offset(),
                $paneDivPos = $leftContentDiv.offset();

            wbResizeManager.adjustPanesHeightOnMaximize($paneDivPos.top, $transPos.top);

            //adjust the heights of the various UI elements of the application
            $("#wbLeftMouseOverArea, #wbRightMouseOverArea").css("height", $translationDiv.height() - wbGlobalSettings.panesTopPadding);
            $splitterContainer.css("height", $translationDiv.height() - wbGlobalSettings.panesTopPadding);
            $rightPane.css("height", $translationDiv.height() - wbGlobalSettings.panesTopPadding);
            $leftPane.css("height", $translationDiv.height() - wbGlobalSettings.panesTopPadding);
            $handleDiv.css("height", $splitterContainer.height() - wbGlobalSettings.splitContainerBottomPadding);
        },

        //loads the work flow from the config to application UI window
        loadWorkFlow: function(lang, title) {
            //get all the configuration values for workflow class.
            var steps = wbWorkflow.steps,
                $workFlowNavContainer = $("#workFlowStepBtns"),
                tempStepsArray = [],
                stepsArray = [],
                orderNo;

            $workFlowNavContainer.html("");
            //store the available steps from the workflow configuration into temporary array.
            for (var i in steps) {
                orderNo = parseInt(steps[i].displayOrder);
                if (!isNaN(orderNo) && orderNo >= 0) {
                    tempStepsArray[steps[i].displayOrder] = steps[i];
                }
            }

            //if there is only one step available, then do not show step buttons.
            var tempStepsArrayLength = tempStepsArray.length;
            if (tempStepsArrayLength === 1) {
                stepsArray[stepsArray.length] = tempStepsArray[0];
                $("#workflowNavigationBtns").hide();
            }
            else {
                //if there are more than one step available then populate the step buttons in application UI
                for (i = 0; i < tempStepsArrayLength; i++) {
                    if (tempStepsArray[i] !== undefined) {
                        stepsArray[stepsArray.length] = tempStepsArray[i];
                        var curIndex = stepsArray.length - 1,
                            buttonTooltipText = (stepsArray[curIndex].buttonTooltipText) ? stepsArray[curIndex].buttonTooltipText : "",
                            buttonStyleClass = (curIndex === wbWorkflow.config.currentStep) ? stepsArray[curIndex].buttonStyleActive : stepsArray[curIndex].buttonStyleNormal,
                            buttonElmStr = wbUtil.stringFormat("<td><div class='{2}' id='workFlowButton{1}' title='{3}'><span class='workflowButtonText'>{0}</span></div></td>", stepsArray[curIndex].buttonText, curIndex, buttonStyleClass, buttonTooltipText);
                        //append steps html element to application UI
                        $(buttonElmStr).appendTo($workFlowNavContainer);
                        //bind click event on step button of the workflow
                        $("#workFlowButton" + curIndex).click(function(curIndex) {
                            return function() {
                                //If the user clicks the current step button again, then just return the function as there is no need to do anything.
                                if (curIndex === wbWorkflow.config.currentStep) {
                                    return;
                                }

                                if (stepsArray[curIndex].panesData[0].pane !== "undefined") {
                                    //if 'confirmationMessage' available then display the same    
                                    if (wbWorkflow.config.currentStep.confirmationMessage) {
                                        var confirmedFlag = window.confirm(wbWorkflow.config.currentStep.confirmationMessage);
                                        if (!confirmedFlag) {
                                            return false;
                                        }
                                    }
                                }
                                //as the steps are changing, reset the variable which says whether the content from previous steps moved to ‘Publish’ step or not.
                                wbPublishDisplayPane.isContentMovedToComposePane = false;
                                wbMainWindow.applyStepNamesToPreviousNextButtons(curIndex);
                                wbMainWindow.setThemeStyleOnPaneTitleBar(curIndex);
                                wbMainWindow.loadContentIntoPanes(curIndex, stepsArray);
                            };
                        } (curIndex));
                    }
                }

                //bind click event to toggle between wiki and html formats
                $("#wbToggleWikiFormat").click(function() {
                    wbDisplayPaneManager.toggleDisplayMode();
                });

                //bind click event to toggle between wiki and html formats
                $("#wbToggleCTF").click(function() {
                     wbDisplayPaneManager.toggleCTFDisplay();
                });
            }

            wbWorkflow.stepsArray = stepsArray;
            //set theme style to pane title bars by using settings from panes config
            this.setThemeStyleOnPaneTitleBar(wbWorkflow.config.currentStep);
            //load the content to panes for current step
            this.loadContentIntoPanes(wbWorkflow.config.currentStep, stepsArray);

        },

        //loads appropriate content to pane for the given step
        loadContentIntoPanes: function(stepIndex, stepsArray) {
            var currentHistoryItem = wbHistoryManager.getSelectedItem();
            //check if the given step is invalid, if so alert the user
            if (currentHistoryItem.langId && currentHistoryItem.langId !== wbGlobalSettings.sourceLanguageCode && typeof (wbWorkflow.config.onTargetLanguageContentLoadAsResourcePage.invalidSteps) !== "undefined") {
                var invalidSteps = wbWorkflow.config.onTargetLanguageContentLoadAsResourcePage.invalidSteps;
                if (invalidSteps[stepIndex]) {
                    alert(wbLocal.notApplicableStep);
                    return;
                }
            }

            // check if the current step is set to prevent from navigating while translation is in progress.
            // if so, alert the user and do nothing.
            if (wbDisplayPaneHelper.$showWikimarkupCheckBox[0].disabled && wbGlobalSettings.isNewArticle
                && typeof (wbWorkflow.config.preventNavigationToStepsDuringTranslationForNewArticle.stepsToPrevent) !== "undefined"
                && wbWorkflow.config.preventNavigationToStepsDuringTranslationForNewArticle.stepsToPrevent[stepIndex]) {
                // if the translation is happending on the first article then restrict the user to switch 
                if (wbHistoryManager.getHistoryEntitiesCount() === 1) {
                    window.alert(wbLocal.waitUntilTranslationComplete);
                    return false;
                }
            }

            // check if there is no source language article for the target language article and don't allow the user 
            // to go to particular step based on the configuration.
            if (wbSourceOriginalPane.isEmptyNow && typeof (wbWorkflow.config.onSourceArticleAbsence.invalidSteps) !== "undefined"
                && wbWorkflow.config.onSourceArticleAbsence.invalidSteps[stepIndex]) {
                alert(wbLocal.notApplicableStep);
                return;
            }

            // check if we can hide the panes in current steps.
            // check for both panes if current step has two pane layout.
            var currentPanesData = stepsArray[wbWorkflow.config.currentStep].panesData;
            if (!wbDisplayPaneManager.canHidePane(currentPanesData[0])) {
                return;
            }
            if (currentPanesData.length > 0 && !wbDisplayPaneManager.canHidePane(currentPanesData[1])) {
                return;
            }

            // validation is done at this stage for changing steps. Now, change the current step.
            var fromStep = wbWorkflow.config.currentStep,
                toStep = stepIndex;
            if (fromStep !== toStep) {
                wbLoggerService.logFeatureUsage(wbGlobalSettings.sessionId, "StepChange", toStep, fromStep);
            }
            wbWorkflow.config.currentStep = stepIndex;
            wbMainWindow.highlightActiveStep(stepIndex);
            var valAry;
            if (typeof stepsArray[stepIndex].onClick !== "undefined") {
                valAry = stepsArray[stepIndex].onClick();
            }
            else if (typeof stepsArray[stepIndex].panesData) {
                valAry = stepsArray[stepIndex].panesData;
            }
            var valAryLen = valAry.length;

            //show single or double pane based on the configuration
            if (valAryLen === 1) {
                valAry[0]['paneIndex'] = 0;
                wbDisplayPaneManager.displaySinglePane(valAry[0]);
            }
            else if (valAryLen === 2) {
                valAry[0]['paneIndex'] = 0;
                valAry[1]['paneIndex'] = 1;
                wbDisplayPaneManager.displayDoublePane(valAry[0], valAry[1]);
            }
        },

        //hides and removes the application window from the UI and document
        hide: function() {

            //unbind the attached events on windows
            window.onbeforeunload = null;
            $(window).unbind('scroll');
            $(window).unbind("resize");

            //Unload the context menu and search window for the application 
            wbContextMenuHandler.unload();
            wbSearch.unload();
            wbWikiMarkupEdit.unload();
            wbSplash.close();

            wbTransliterationServices.disableTransliteration(wbGlobalSettings.mtTargetLanguageCode);

            //remove Application windows from the UI 
            wbUIHelper.removeWindow(wbMainWindow.windowId);
            wbUIHelper.removeWindow(wbScratchPad.windowId);
            wbUIHelper.removeWindow(wbTutorial.windowId);
            wbUIHelper.removeWindow(wbFeedback.windowId);
            wbUIHelper.removeWindow(wbShareOnExternSystem.windowId);

            $("div[class=wbTooltip]").remove();

            //unload the themes for the application
            wbThemes.unload();

            //if translation toolbar exists, close the same while closing wikiBhasha.
            var $toolbarExitLink = $("#MSTTExitLink").get(0);
            if ($toolbarExitLink) {
                $toolbarExitLink.onclick();
            }

            wbUIHelper.hideLightBox();
            wbUIHelper.changeCursorToDefault();
            wbMainWindow.deleteGlobalVariables();
        },

        //sets all the global variable values to 'undefined' to clear the browser memory
        deleteGlobalVariables: function() {
            var wbGloablVariables =
                ["baseUrl",
                "s",
                "wbPublishDisplayPane",
                "wbContextMenuHandler",
                "wbDisplayPaneHelper",
                "wbDisplayPaneManager",
                "wbFeedback",
                "wbGlobalSettings",
                "wbHistoryManager",
                "wbHybridConverter",
                "wbLanguageServices",
                "wbLocal",
                "wbMainWindow",
                "wbShareOnExternSystem",
                "wbShortenURL",
                "wbResizeManager",
                "wbScratchPad",
                "wbSearch",
                "wbSourceOriginalPane",
                "wbSourceTranslatedPane",
                "wbSplash",
                "wbSplitterManager",
                "wbTargetContentPane",
                "wbThemes",
                "wbTransliterationServices",
                "wbTutorial",
                "wbUIHelper",
                "wbUtil",
                "wbWikiConverter",
                "wbWikiModeConverter",
                "wbWikiSite",
                "wbWorkflow",
                "wbChineseLangSelection",
                "wbWikiMarkupEditWindow",
                "wb"];

            for (var i = 0; i < wbGloablVariables.length; i++) {
                window[wbGloablVariables[i]] = undefined;
            }
        },

        //restricts the events like drag/drop/cut/copy/paste from other applications to the application.
        attachEventRestrictions: function() {
            //use these variables to track whether drag/cut/copy is from current window or not
            var isDragFromCurrentApp = false,
                isCopyFromCurrentApp = false,
                $documentBodyElement = $("BODY");

            //prevent the keyboard short-cuts Ctrl+B, Ctrl+I and Ctrl+U that can be used for formatting the text.
            wbUtil.catchCtrlKeyCombination("B", function() { return false; });
            wbUtil.catchCtrlKeyCombination("I", function() { return false; });
            wbUtil.catchCtrlKeyCombination("U", function() { return false; });

            //whenever browser window gets focus that means user coming back from some other window.
            $(window).bind("focus", function() {
                //make following variables to 'false' to restrict the cut/copy/paste/drag/drop event from outside.
                isDragFromCurrentApp = false;
                isCopyFromCurrentApp = false;
            });

            $documentBodyElement.bind("drag", function() {
                //if drag event is from current document body then allow the action.
                isDragFromCurrentApp = true;
            });

            $documentBodyElement.bind("drop", function() {
                //if drag event is not registered earlier from this window then prevent this action.
                return (!isDragFromCurrentApp) ? false : true;
            });

            $documentBodyElement.bind("copy", function() {
                //if copy event is from current document body then allow the action.
                isCopyFromCurrentApp = true;
            });

            $documentBodyElement.bind("cut", function() {
                //if copy event is from current document body then allow the action.
                isCopyFromCurrentApp = true;
            });
            $documentBodyElement.bind("paste", function(event) {
                //if cut/copy events are not registered earlier from this window or user trying to paste the content other than scratch pad text area then prevent this action.
                if (!isCopyFromCurrentApp) {
                    if((wbScratchPad.$sourceTextBox && event.target.id === wbScratchPad.$sourceTextBox.attr("id")) || (wbScratchPad.$targetTextBox && event.target.id === wbScratchPad.$targetTextBox.attr("id"))){
                        return true;
                    }else{
                        var paneDivID = wbDisplayPaneManager.getPaneForId(wbDisplayPaneHelper.getElementsPaneDivId(event.target));
                        if(paneDivID.paneConfigInfo.isContentEditable){
                            if ($.browser.msie) {
                                var copiedtext=window.clipboardData.getData("Text");
                                window.clipboardData.setData("Text", wbUtil.stripTags(copiedtext)); 
                                return true;
                            }else{
                                if(confirm(wbLocal.pasteMessage)){
                                    wbScratchPad.show();  
                                }
                            }
                        }
                        return false;
                    }
                }
                return true;
            });

            //IE fix. IE doesn't support disabling 'selection' event on HTML elements(supports only on text available within elements)
            //following code will restrict the user from Drag-Dropping or Copy-Pasting HTML elements into 'contentEditable' area by making use of 'dragend' and 'paste' events.
            if ($.browser.msie) {
                $documentBodyElement.bind("dragend", function() {
                   wbMainWindow.removeNonContentElements();
                });

                $documentBodyElement.bind("paste", function() {
                    //As paste event fires before content pasted into target element, we need to have some time delay(ex: 100ms) 
                    //to identify whether pasted content contains any unwanted HTML elements or not.
                    window.setTimeout(function() {
                        wbMainWindow.removeNonContentElements();
                    }, 100);
                });


            }
        },

        //removes cloned HTML elements(during Drag-Drop or Copy-Paste) from the element"#wbRightWindowContentDiv"
        removeNonContentElements: function() {
            var $elementsToBeRemoved = $("#wbTranslationTable, #wbScratchPadWindow, #scratchPadTable, .scratchContentLayoutRow, .scratchTopButtonLayout, .wbScratchPadSection, .scratchContentLayout, .scratchTopLayout, .wbExit, .wbLeftWindowContent, .wbLogoContainer, .wbContentContainer, #wbTwoPaneOuterWrapper, #wbLeftWindow, .wbTableBackground, .wbTopButtonsDiv, #wbTopIcons, #wbHistoryInfo, .workflowNavigationBtns, #workFlowStepBtns, .wbTable, .wbHeader, #wbWorkingArticleLabel, .tabs_li, .wbWikiMarkupEditBottomLinks, .tab_content", $("#wbRightWindowContentDiv"));
            var removeCloneNodes = function() {
                //jQuery '.remove()' method actually removes the events on original elements
                //to avoid this we need to use native DOM method to remove only the cloned elements
                this.parentNode.removeChild(this);
            };
            $elementsToBeRemoved.each(removeCloneNodes);
        },

        //enables previous and next buttons on application UI to navigate between the available workflow buttons
        enablePreviousNextButtons: function() {
            var $previousButtonElement = $("#wbPreviousButton"),
                $nextButtonElement = $("#wbNextButton"),
                previousButtonTimer,
                nextButtonTimer;

            //show or hide previous button when user mouseover or mouseout on left mouse over area
            $("#wbLeftMouseOverArea, #wbPreviousButton").bind("mouseover", function() {
                //check if the previously initiated timer to hide the button is still available, 
                //if so before showing the button, kill the timer.
                if (previousButtonTimer) {
                    window.clearInterval(previousButtonTimer);
                }
                //if the current step is not first step then show previous button
                if (!isFirstStep()) {
                    $previousButtonElement.show();
                }
            }).bind("mouseout", function() {
                var $previousButtonElm = $previousButtonElement;
                //have some time delay before hiding the button so that it will be easy for user to click on the button
                previousButtonTimer = window.setTimeout(function() {
                    $previousButtonElm.hide();
                }, wbMainWindow.previousNextButtonHideDelay);
            });

            //show or hide next button when user mouseover or mouseout on right mouse over area
            $("#wbRightMouseOverArea, #wbNextButton").bind("mouseover", function() {
                //check if the previously initiated timer to hide the button is still available, 
                //if so before showing the button, kill the timer.
                if (nextButtonTimer) {
                    window.clearInterval(nextButtonTimer);
                }
                //if the current step is not last step then show next button
                if (!isLastStep()) {
                    $nextButtonElement.show();
                }
            }).bind("mouseout", function() {
                var $nextButtonElm = $nextButtonElement;
                //have some time delay before hiding the button so that it will be easy for user to click on the button
                nextButtonTimer = window.setTimeout(function() {
                    $nextButtonElm.hide();
                }, wbMainWindow.previousNextButtonHideDelay);
            });

            //enable click on next button to navigate between steps
            $nextButtonElement.bind("click", function() {
                if (!isLastStep()) {
                    var curStep = wbWorkflow.config.currentStep,
                        nextStep = curStep + 1;
                    //get the next step index and invoke the click event on of next step to navigate.
                    if (nextStep <= wbWorkflow.stepsArray.length) {
                        $("#workFlowButton" + nextStep).click();
                    }
                    nextStep++;
                    //after navigating if the next steps is not available then hide the next button
                    if (nextStep >= wbWorkflow.stepsArray.length) {
                        $nextButtonElement.hide();
                    }
                }
            });

            //enable click on previous button to navigate between steps
            $previousButtonElement.bind("click", function() {
                if (!isFirstStep()) {
                    var curStep = wbWorkflow.config.currentStep,
                        previousStep = curStep - 1;
                    //get the previous step index and invoke the click event on of previous step to navigate.
                    if (previousStep >= 0) {
                        $("#workFlowButton" + previousStep).click();
                    }
                    previousStep--;
                    //after navigating if the previous steps is not available then hide the previoous button
                    if (previousStep < 0) {
                        $previousButtonElement.hide();
                    }
                }
            });

            //determines whether current step is the first step or not
            function isFirstStep() {
                return (wbWorkflow.config.currentStep === 0) ? true : false;
            }

            //determines whether current step is the last step or not
            function isLastStep() {
                return (wbWorkflow.config.currentStep === (wbWorkflow.stepsArray.length - 1)) ? true : false;
            }
        },

        //applies step button texts on previous and next buttons based on the current step.
        applyStepNamesToPreviousNextButtons: function(currentStep) {
            var curStep = currentStep,
                stepsAry = wbWorkflow.stepsArray,
                previousStepText = "", nextStepText = "",
                previousStep = curStep - 1,
                nextStep = curStep + 1;

            if (previousStep >= 0) {
                //determine previous step index and get the step button text
                previousStepText = stepsAry[previousStep].buttonText;
            }
            if (nextStep < stepsAry.length) {
                //determine next step index and get the step button text
                nextStepText = stepsAry[nextStep].buttonText;
            }
            //apply step button text on previous and next buttons
            $("#wbPreviousButtonText").html(previousStepText);
            $("#wbNextButtonText").html(nextStepText);
        },

        //highlights the current/active step button
        highlightActiveStep: function(whichStep) {
            for (var i = wbWorkflow.stepsArray.length; i--; ) {
                var step = wbWorkflow.stepsArray[i];
                $("#workFlowButton" + i).attr("class", (i === whichStep) ? step.buttonStyleActive : step.buttonStyleNormal);
            }
        },

        //sets given theme style from config to pane title bar.
        setThemeStyleOnPaneTitleBar: function(whichStep) {
            var currentStepPanesConfig = wbWorkflow.stepsArray[whichStep].panesData;
            for (var i = 0; i < currentStepPanesConfig.length; i++) {
                var styleToBeApplied = currentStepPanesConfig[i].titleBarThemeStyle,
                    paneTitleElementLookupPrefix = ((i === 0) ? "#wbLeftWindow" : "#wbRightWindow");
                //if pane title theme style available then apply the same on title toolbar
                if (typeof styleToBeApplied !== "undefined") {
                    $(paneTitleElementLookupPrefix + " .wbWindowToolbarCenter").removeAttr("class")
                    .addClass(wbGlobalSettings.paneTitleToolBarDefaultClass)
                    .addClass(styleToBeApplied);
                    //else apply the default title theme style
                }
                else {
                    $(paneTitleElementLookupPrefix + " .wbWindowToolbarCenter").removeAttr("class")
                    .addClass(wbGlobalSettings.paneTitleToolBarDefaultClass);
                }
            }
        },

        //applies localized strings to the application window
        applyLocalization: function() {
            var local = [["#wbThemeBlueLink", "attr", "title", wbLocal.themeBlack],
                         ["#wbThemeBlueLink", "attr", "title", wbLocal.themeBlue],
                         ["#wbThemeSilverLink", "attr", "title", wbLocal.themeSilver],
                         ["#wbHelpLink", "attr", "title", wbLocal.help],
                         ["#wbMaximizeLink", "attr", "title", wbLocal.maximize],
                         ["#wbHistoryLabel", "html", "", wbLocal.historyLabel],
                         ["#wbSearchBtn", "attr", "value", wbLocal.search],
                         ["#wbConvertEntireArticleBtn", "attr", "value", wbLocal.convertEntireArticle]];

            //read local string and update html
            $.each(local, function(i, wbValue) {
                if (wbValue[1] === "html") {
                    $(wbValue[0]).html(wbValue[3]);
                }
                else if (wbValue[1] === "attr") {
                    $(wbValue[0]).attr(wbValue[2], wbValue[3]);
                }
            });
            //apply local strings in to tooltip
            wbUIHelper.setTooltipForElement("wbCollapseLeftWindowBtn", wbLocal.collapseTooltip);
            wbUIHelper.setTooltipForElement("wbCollapseRightWindowBtn", wbLocal.collapseTooltip);
            wbUIHelper.setTooltipForElement("wbLeftCollapsedBtn", wbLocal.expandPaneTooltip);
            wbUIHelper.setTooltipForElement("wbRightCollapsedBtn", wbLocal.expandPaneTooltip);
        }
    };

    //short cut to call wikiBhasha '$twoPaneOverlay' window
    wbMainWindow = wikiBhasha.windowManagement.mainWindow;

    //describes the custom context menu for the application, menu items of this context menu are extendible.
    wikiBhasha.windowManagement.contextMenuHandler = {
        menuContainerElement: null,
        initialize: function() {
            wbContextMenuHandler.bindContextMenuToElement("wbTranslationDiv");
            wbContextMenuHandler.addContextMenuItems();
        },

        unload: function() {
            //bind disable event on context menu
            $(document).unbind("contextmenu");
            if (wbContextMenuHandler.menuContainerElement !== null) {
                wbContextMenuHandler.menuContainerElement.remove();
            }
        },

        //bind context menu on a given element
        bindContextMenuToElement: function(elementId) {
            $("#" + elementId).contextMenu("wbMenu",
                {
                    menuStyle: { width: '100%' },
                    shadow: false
                },
            //gets the selected text on right click event.
                function(trigger, menuContainerElm) {
                    //get the context menu container element if its not available.
                    if (wbContextMenuHandler.menuContainerElement === null) {
                        wbContextMenuHandler.menuContainerElement = menuContainerElm;
                    }
                    //save currently selected text. Selection gets cleared once context menu shows up, so we need to save it.
                    wbContextMenuHandler.lastSelectedText = wbUIHelper.getSelectedText();
                    if (typeof wbContextMenuHandler.lastSelectedText === "undefined") {
                        wbContextMenuHandler.lastSelectedText = "";
                    }
                });
        },

        //retrieves menu item information from configuration and add them in custom context menu as items
        addContextMenuItems: function() {
            //get the available menu items from configuration
            var contextMenuItems = wikiBhasha.configurations.contextMenuItems;

            //if there is no configuration available for menu items then do nothing
            if (typeof contextMenuItems === "undefined") {
                return false;
            }

            var $contextMenuContainer = $("#wbContextMenuItems")[0];

            //empty the context menu container before appending menu items
            $($contextMenuContainer).html("");
            //loop through menu items and build HTML for each item using given config values and append to context menu container
            for (var i in contextMenuItems) {
                var contextMenuItemStr = wbUtil.stringFormat("<li id='{0}'>", contextMenuItems[i].itemId);
                if (contextMenuItems[i].itemIcon) {
                    var iconUrl = contextMenuItems[i].itemIcon.iconSrc;
                    //Check if the given URL is absolute or relative.
                    //if the given URL is in relative path then append 'baseUrl' to it.
                    if (iconUrl.search(/(^http:\/\/)|(^https:\/\/)/g) === -1) {
                        iconUrl = wbGlobalSettings.baseUrl + iconUrl;
                    }
                    contextMenuItemStr += wbUtil.stringFormat("<img src='{0}' width='{1}' height='{2}'/>", iconUrl, contextMenuItems[i].itemIcon.iconWidth, contextMenuItems[i].itemIcon.iconHeight);
                }
                contextMenuItemStr += wbUtil.stringFormat("{0}</li>", contextMenuItems[i].itemText);
                $(contextMenuItemStr).appendTo($contextMenuContainer);

                var onClickAction;
                //if 'click' and 'shortcut' key values are available in config then bind them on menu item
                if (contextMenuItems[i].onClick) {
                    onClickAction = function(contextMenuItem) {
                        //Pass the 'selectedText' as a value to the attached function.
                        return function() {
                            contextMenuItem.onClick(wbContextMenuHandler.lastSelectedText);
                        };
                    };
                    $("#" + contextMenuItems[i].itemId).click(function(i) {
                        return onClickAction(contextMenuItems[i]);
                    } (i));

                    if (contextMenuItems[i].shortCutKey) {
                        jQuery.shortcut.add(contextMenuItems[i].shortCutKey, function(i) {
                            return onClickAction(contextMenuItems[i]);
                        } (i));
                    }
                }
            }
        }
    };

    //short cut to call context menu handler class
    wbContextMenuHandler = wikiBhasha.windowManagement.contextMenuHandler;

    //includes all the methods and properties which manages splitter for the application.
    //this splitter is used to adjust the width of the panes available in main application UI
    wikiBhasha.windowManagement.splitterManager = {

        // splitter current position
        $splitPos: 0,

        //whether the mouse move happened or not
        mouseMoved: false,

        initialize: function() {
            //do the necessary DOM lookups
            var $leftPane = $("#wbLeftPane"),
                $rightPane = $("#wbRightPane"),
                $splitterContainer = $("#wbSplitter"),
                $splitterDiv = $("#wbHandleDiv"),
                $translationDiv = $("#wbTranslationDiv"),
                $leftContentDiv = $("#wbLeftWindowContentDiv");

            //the splitter is aligned such that both panes are horizontally placed and
            //width of the panes are adjusted in accordance with the parent div.
            $leftPane.css("width", ($splitterContainer.width() / 2) - wbGlobalSettings.splitterMargin);
            $rightPane.css("width", $splitterContainer.width() - $leftPane.width() - wbGlobalSettings.$splitterWidth);
            $("#wbLeftWindowContentDiv").css({ "width": $leftPane.width() - wbGlobalSettings.contentMargin });
            $("#wbRightWindowContentDiv").css({ "width": $rightPane.width() - wbGlobalSettings.contentMargin });
            $splitterDiv.css("height", $splitterContainer.height());

            //the left position value is set to adjust the panes and to handle div parallely.
            $splitterDiv.css("left", $leftPane.width() + wbGlobalSettings.$splitterWidth);
            $rightPane.css("left", $leftPane.width() + wbGlobalSettings.$splitterWidth + wbGlobalSettings.splitterMargin);

            //set global values
            wbGlobalSettings.$contentHeight = $leftContentDiv.height();
            var $translationWindowSizes = $("#wbTranslationWindow").offset();
            wbGlobalSettings.$transWinLeft = $translationWindowSizes.left;
            wbGlobalSettings.$transWinTop = $translationWindowSizes.top;
            wbGlobalSettings.$transDivWidth = $translationDiv.width();
            wbGlobalSettings.$transDivHeight = $translationDiv.height();

            //bind the mouse down event
            $splitterDiv.bind("mousedown", wbSplitterManager.startSplitMouse);
        },


        //starts splitter to move when mouse down event fired
        startSplitMouse: function() {
            var $frameWidth = $().width(),
                $frameHeight = $().height(),
                $splitterHelper = $("#wbSplitHelperDiv"),
                $twoPaneWindow = $("#wbTranslationWindow");
            this.$splitPos = 0;

            //to allow the splitter work over the iframe, we need to place a div on whole window                      
            $splitterHelper.css({ "left": 0, "top": 0, "height": $frameHeight, "width": $frameWidth, "z-index": "1000" });
            $splitterHelper.show();

            //bind the mouse move and mouse up events for splitter to work.
            $splitterHelper.bind("mousemove", wbSplitterManager.doSplitMouse).bind("mouseup", wbSplitterManager.endSplit);
            $("#wbSplitHelperDiv, #wbLeftPane, #wbRightPane, #wbSplitter, #wbTranslationDiv, #wbTranslationWindow")
                .bind("mousemove", wbSplitterManager.doSplitMouse)
                .bind("mouseup", wbSplitterManager.endSplit);

            //IE fix, disable the selection when splitter is dragged, it should not select the content
            if ($.browser.msie) {
                $twoPaneWindow.bind("selectstart", wbUtil.disableEvent);
            }
            // for the other browsers
            else {
                $twoPaneWindow.bind("mousedown", wbUtil.disableEvent);
            }
        },

        // adjusts the panes in the main application UI when splitter is moved around
        doSplitMouse: function(e) {
            var $translationWindowOffset = $("#wbTranslationWindow").offset(),
                $splitterWidth = $("#wbSplitter").width(),
            //splitter container Margin 8 px in styles.
                splitterContainerMargin = 8,
            //the splitter 'handler' position
                handleDivLeft = e.pageX - $translationWindowOffset.left - splitterContainerMargin,
            //get the pane widths
                $rightPaneWidth = $splitterWidth - handleDivLeft - wbGlobalSettings.splitterMargin,
                leftPaneWidth = handleDivLeft - wbGlobalSettings.$splitterWidth,
            //HTML Objects
                $splitterDiv = $("#wbHandleDiv");

            //adjust left position and width of splitter while moving the splitter between min and max widths
            if ($rightPaneWidth >= wbGlobalSettings.rightPaneMinWidth && leftPaneWidth >= wbGlobalSettings.leftPaneMinWidth) {
                $splitterDiv.css("left", handleDivLeft);
                this.$splitPos = handleDivLeft;
            }
            else if (leftPaneWidth < wbGlobalSettings.leftPaneMinWidth) {
                this.$splitPos = wbGlobalSettings.leftPaneMinWidth + wbGlobalSettings.$splitterWidth;
                $splitterDiv.css("left", this.$splitPos);
            }
            else if ($rightPaneWidth < wbGlobalSettings.rightPaneMinWidth) {
                this.$splitPos = $splitterWidth - wbGlobalSettings.rightPaneMinWidth;
                $splitterDiv.css("left", this.$splitPos);
            }

            this.mouseMoved = true;
        },

        //ends the splitter movement and adjusts the panes in the application UI with respect to the splitter position.  
        endSplit: function(e) {
            // HTML objects
            var $leftPane = $("#wbLeftPane"),
                $rightPane = $("#wbRightPane"),
                $twoPaneWindow = $("#wbTranslationWindow"),
                $splitterContainer = $("#wbSplitter"),
                $helperDiv = $("#wbSplitHelperDiv");

            // if the panes were adjusted
            if (this.mouseMoved && this.$splitPos !== 0) {
                $leftPane.css("width", this.$splitPos - wbGlobalSettings.$splitterWidth);
                $rightPane.css("width", $splitterContainer.width() - this.$splitPos - wbGlobalSettings.splitterMargin);

                $("#wbLeftWindowContentDiv").css({ "width": $leftPane.width() - wbGlobalSettings.contentMargin });
                $("#wbRightWindowContentDiv").css({ "width": $rightPane.width() - wbGlobalSettings.contentMargin });

                $("#wbHandleDiv").css("left", this.$splitPos);
                $rightPane.css("left", this.$splitPos + wbGlobalSettings.splitterMargin);
                this.mouseMoved = false;
            }

            //unbind all the hooked events.
            $helperDiv.unbind("mousemove", wbSplitterManager.doSplitMouse).unbind("mouseup", wbSplitterManager.endSplit);
            $leftPane.unbind("mousemove", wbSplitterManager.doSplitMouse).unbind("mouseup", wbSplitterManager.endSplit);
            $rightPane.unbind("mousemove", wbSplitterManager.doSplitMouse).unbind("mouseup", wbSplitterManager.endSplit);
            $splitterContainer.unbind("mousemove", wbSplitterManager.doSplitMouse).unbind("mouseup", wbSplitterManager.endSplit);
            $("#wbTranslationDiv").unbind("mousemove", wbSplitterManager.doSplitMouse).unbind("mouseup", wbSplitterManager.endSplit);
            $twoPaneWindow.unbind("mousemove", wbSplitterManager.doSplitMouse).unbind("mouseup", wbSplitterManager.endSplit);

            //unbind and enable selection of elements on drag.
            $twoPaneWindow.unbind("selectstart", wbUtil.disableEvent);
            $twoPaneWindow.unbind("mousedown", wbUtil.disableEvent);
            $helperDiv.hide();
        }
    };
    //shortcut variable for 'splitterManager' class
    wbSplitterManager = wikiBhasha.windowManagement.splitterManager;

    //Includes all properties and methods for managing the resize of the application(which includes maximize and restore of application UI). 
    wikiBhasha.windowManagement.resizeManager =
    {
        initialize: function() {
            //when window is resized, resize the application window as per browser size
            $(window).bind("resize", wbResizeManager.windowResize);

            //binding event for maximize and restoring the application window	
            $("#wbMaximizeLink").click(function() {
                wbResizeManager.maximizeOrRestore();
            });

            //set visiblity on application window
            $("#wbTranslationWindow").css("visibility", "visible");
        },

        //indicates if main window is maximized
        isMaximized: false,

        //resizes the application window with respect to browser window size
        windowResize: function() {
            var $splitterContainer = $("#wbSplitter"),
                $leftPane = $("#wbLeftPane"),
                $rightPane = $("#wbRightPane"),

                $leftCollapsePos = $("#wbLeftCollapseContentDiv").offset(),
                $transPos = $("#wbTranslationWindow").offset(),
                resizedDocSize = wbUtil.getDocumentInnerSize(),
                resizedDocWidth = resizedDocSize[0],
                resizedDocHeight = resizedDocSize[1];

            //reset the width and height of 'blockUI' for application window once the window is resized
            $("#wbBlockParentUI").css({ 'height': resizedDocHeight, 'width': resizedDocWidth });
            $("#wbBlockChildUI").css({ 'height': resizedDocHeight, 'width': resizedDocWidth });

            //if left pane is collapsed
            if ($("#wbLeftWindow").is(":hidden")) {
                $rightPane.css("width", $splitterContainer.width() - $leftPane.width() - wbGlobalSettings.$splitterWidth);
                wbResizeManager.adjustPanesHeightOnMaximize($leftCollapsePos.top, $transPos.top);
            }
            //if right pane is collapsed
            else if ($("#wbRightWindow").is(":hidden")) {
                $rightPane.css("width", wbGlobalSettings.collapsePaneWidth);
                //if it is single pane layout
                if (wbDisplayPaneManager.isInSinglePaneLayout) {
                    $leftPane.css("width", $splitterContainer.width());
                }
                else {
                    $leftPane.css("width", $splitterContainer.width() - $rightPane.width() - wbGlobalSettings.$splitterWidth);
                }
            }
            else {
                $leftPane.css("width", ($splitterContainer.width() / 2) - wbGlobalSettings.splitterMargin);
                $rightPane.css("width", $splitterContainer.width() - $leftPane.width() - wbGlobalSettings.$splitterWidth);
            }

            $("#wbLeftWindowContentDiv").css({ "width": $leftPane.width() - wbGlobalSettings.contentMargin });
            $("#wbRightWindowContentDiv").css({ "width": $rightPane.width() - wbGlobalSettings.contentMargin });

            $("#wbHandleDiv").css("left", $leftPane.width() + wbGlobalSettings.$splitterWidth);
            $rightPane.css("left", $leftPane.width() + wbGlobalSettings.$splitterWidth + wbGlobalSettings.splitterMargin);

            //if window is maximized.
            if (wbResizeManager.isMaximized) {
                // On window resize, just make sure that window is always
                // maximized till the user restores the mode.
                wbResizeManager.isMaximized = false;
                wbResizeManager.maximizeOrRestore();
            }
        },

        //maximizes or restores the application window.
        maximizeOrRestore: function() {
            // do the necessary DOM lookups
            var $twoPaneOverlay = $("#wbTranslationWindow"),
                $translationDiv = $("#wbTranslationDiv"),
                $leftContentDiv = $("#wbLeftWindowContentDiv"),
                $rightContentDiv = $("#wbRightWindowContentDiv"),
                $leftPane = $("#wbLeftPane"),
                $rightPane = $("#wbRightPane"),
                $splitterContainer = $("#wbSplitter"),
                $handleDiv = $("#wbHandleDiv"),
                $leftCollpaseContentDiv = $("#wbLeftCollapseContentDiv"),
                $rightCollapseContentDiv = $("#wbRightCollapseContentDiv"),
                $rightCollapseTable = $("#wbRightCollapsedTable"),
                $leftCollapseTable = $("#wbLeftCollapsedTable"),
                $leftWindow = $("#wbLeftWindow"),
                $rightWindow = $("#wbRightWindow"),
                wbMaximizeLink = $("#wbMaximizeLink"),
                $msTranslatorSpacer = $("#MSTTSpacer"),

            // parameters required for maximizing
                $transPos = $twoPaneOverlay.offset(),
                $paneDivPos = $leftContentDiv.offset(),
                $leftCollapsePos = $leftCollpaseContentDiv.offset(),
                $rightcollapsePos = $rightCollapseContentDiv.offset(),

                $composeIFrameElement = $("#wbComposeIFrame");

            //if application window is in restored mode then maximize the same
            if (!this.isMaximized) {

                this.isMaximized = true;

                //parameters required for maximizing
                var windowSize = wbUtil.getWindowInnerSize();

                $twoPaneOverlay.css({ "left": "0px", "width": "100%" });
                // adjust the panes if the translator bar is open
                if ($msTranslatorSpacer.length === 0 || $msTranslatorSpacer.is(":hidden")) {
                    $twoPaneOverlay.css("top", "0px");
                    $translationDiv.css("height", windowSize[1]);
                }
                else {
                    var barHeight = wbGlobalSettings.translationBarHeight;
                    $twoPaneOverlay.css("top", barHeight);
                    $translationDiv.css("height", windowSize[1] - barHeight);
                }

                $translationDiv.css("width", windowSize[0]);

                //if left pane is hidden 
                if ($leftWindow.is(":hidden")) {
                    $rightPane.css("width", $splitterContainer.width() - $leftPane.width() - wbGlobalSettings.$splitterWidth);
                    this.adjustPanesHeightOnMaximize($leftCollapsePos.top, $transPos.top);
                }
                //if right pane is hidden 
                else if ($rightWindow.is(":hidden")) {
                    $rightPane.css("width", wbGlobalSettings.collapsePaneWidth);
                    if (wbDisplayPaneManager.isInSinglePaneLayout) {
                        $leftPane.css("width", $splitterContainer.width());
                    } else {
                        $leftPane.css("width", $splitterContainer.width() - (wbGlobalSettings.collapsePaneWidth + wbGlobalSettings.$splitterWidth + wbGlobalSettings.splitterMargin));
                    }

                    this.adjustPanesHeightOnMaximize($rightcollapsePos.top, $transPos.top);
                    $handleDiv.css("left", $leftPane.width() + wbGlobalSettings.$splitterWidth);
                    $rightPane.css("left", $leftPane.width() + wbGlobalSettings.$splitterWidth + wbGlobalSettings.splitterMargin);
                }
                //if both panes are expanded
                else {
                    $rightPane.css("width", $splitterContainer.width() - $leftPane.width() - wbGlobalSettings.$splitterWidth);
                    this.adjustPanesHeightOnMaximize($paneDivPos.top, $transPos.top);
                }

                wbMaximizeLink.removeClass("wbMaximize");
                wbMaximizeLink.addClass("wbMinimize");
                wbMaximizeLink.attr("title", "Minimize");
            }
            //if application window is in maximized state
            else {
                this.isMaximized = false;
                $twoPaneOverlay.css({ "left": wbGlobalSettings.$transWinLeft, "width": "95%" });

                //adjust the panes if the translator bar is open
                if ($msTranslatorSpacer.is(":visible") && $twoPaneOverlay.offset().top === 0) {
                    var barHeight = wbGlobalSettings.translationBarHeight;
                    $twoPaneOverlay.css("top", wbGlobalSettings.$transWinTop + barHeight);
                }
                else {
                    $twoPaneOverlay.css("top", wbGlobalSettings.$transWinTop);
                }

                $translationDiv.css("height", wbGlobalSettings.$transDivHeight);
                $translationDiv.css("width", "100%");
                $splitterContainer.css("width", "100%");
                //if right window is hidden
                if ($rightWindow.is(":hidden")) {
                    //adjust widths of both the panes
                    if (wbDisplayPaneManager.isInSinglePaneLayout) {
                        $leftPane.css("width", $splitterContainer.width());
                    }
                    else {
                        $leftPane.css("width", $splitterContainer.width() - (wbGlobalSettings.collapsePaneWidth + wbGlobalSettings.$splitterWidth + wbGlobalSettings.splitterMargin));
                    }
                    $leftContentDiv.css({ "width": $leftPane.width() - wbGlobalSettings.contentMargin });

                    //adjust the height to (application height - application.top offset - splitterbottom padding)   $handleDiv.css("height", $translationDiv.height() - ($rightcollapsePos.top - $transPos.top) - wbGlobalSettings.splitContainerBottomPadding);
                    $leftContentDiv.css({ "height": $translationDiv.height() - ($rightcollapsePos.top - $transPos.top) - wbGlobalSettings.splitContainerBottomPadding });
                    $rightContentDiv.css({ "height": $translationDiv.height() - ($rightcollapsePos.top - $transPos.top) - wbGlobalSettings.splitContainerBottomPadding });
                    $rightCollapseContentDiv.css({ "height": $translationDiv.height() - ($rightcollapsePos.top - $transPos.top) - wbGlobalSettings.splitContainerBottomPadding });
                    $rightCollapseTable.css("height", $leftWindow.height() - wbGlobalSettings.collapsePanePadding);

                    $handleDiv.css("left", $leftPane.width() + wbGlobalSettings.$splitterWidth);
                    $rightPane.css("left", $leftPane.width() + wbGlobalSettings.$splitterWidth + wbGlobalSettings.splitterMargin);

                }
                //if left window is collapsed and when both left and right panes are open 
                else {
                    $rightPane.css("width", $splitterContainer.width() - $leftPane.width() - wbGlobalSettings.$splitterWidth);
                    $leftContentDiv.css({ "width": $leftPane.width() - wbGlobalSettings.contentMargin });
                    $rightContentDiv.css({ "width": $rightPane.width() - wbGlobalSettings.contentMargin });

                    $handleDiv.css("height", wbGlobalSettings.$contentHeight);
                    $leftContentDiv.css({ "height": wbGlobalSettings.$contentHeight });
                    $rightContentDiv.css({ "height": wbGlobalSettings.$contentHeight });

                    $leftCollpaseContentDiv.css({ "height": wbGlobalSettings.$contentHeight - wbGlobalSettings.collapsePanePadding });
                    $leftCollapseTable.css("height", $rightWindow.height() - wbGlobalSettings.collapsePanePadding);

                    $rightCollapseContentDiv.css({ "height": wbGlobalSettings.$contentHeight - wbGlobalSettings.collapsePanePadding });
                    $rightCollapseTable.css("height", $leftWindow.height() - wbGlobalSettings.collapsePanePadding);
                }

                wbMaximizeLink.removeClass("wbMinimize");
                wbMaximizeLink.addClass("wbMaximize");
                wbMaximizeLink.attr("title", "Maximize");
            }
            $splitterContainer.css("height", $translationDiv.height() - wbGlobalSettings.panesTopPadding);
            $("#wbLeftMouseOverArea, #wbRightMouseOverArea").css("height", $splitterContainer.height());
            if ($composeIFrameElement.get(0)) {
                var adjustIFrameHeight = (wbResizeManager.isMaximized) ? 100 : 80;
                $composeIFrameElement.css("height", $splitterContainer.height() - adjustIFrameHeight);
            }
            $rightPane.css("height", $translationDiv.height() - wbGlobalSettings.panesTopPadding);
            $leftPane.css("height", $translationDiv.height() - wbGlobalSettings.panesTopPadding);
            $handleDiv.css("height", $splitterContainer.height() - wbGlobalSettings.splitContainerBottomPadding);
        },

        //adjusts the panes height on maximize.
        adjustPanesHeightOnMaximize: function(paneTopOffset, translationDivTopOffset) {
            //do the necessary DOM lookups
            var $translationDiv = $("#wbTranslationDiv"),
                $leftContentDiv = $("#wbLeftWindowContentDiv"),
                $rightContentDiv = $("#wbRightWindowContentDiv"),
                $leftPane = $("#wbLeftPane"),
                $rightPane = $("#wbRightPane"),
                wbRightWindow = $("#wbRightWindow");

            $leftContentDiv.css({ "width": $leftPane.width() - wbGlobalSettings.contentMargin });
            $rightContentDiv.css({ "width": $rightPane.width() - wbGlobalSettings.contentMargin });

            $leftContentDiv.css({ "height": $translationDiv.height() - (paneTopOffset - translationDivTopOffset) - wbGlobalSettings.splitContainerBottomPadding });
            $rightContentDiv.css({ "height": $translationDiv.height() - (paneTopOffset - translationDivTopOffset) - wbGlobalSettings.splitContainerBottomPadding });

            $("#wbLeftCollapseContentDiv").css({ "height": $translationDiv.height() - (paneTopOffset - translationDivTopOffset) - wbGlobalSettings.splitContainerBottomPadding });
            $("#wbRightCollapseContentDiv").css({ "height": $translationDiv.height() - (paneTopOffset - translationDivTopOffset) - wbGlobalSettings.splitContainerBottomPadding });

            $("#wbLeftCollapsedTable").css("height", wbRightWindow.height() - wbGlobalSettings.collapsePanePadding);
            $("#wbRightCollapsedTable").css("height", $("#wbLeftWindow").height() - wbGlobalSettings.collapsePanePadding);

            //if right window iframe is collapsed the below condition would throw error,
            //and if iframe height becomes negative, the browser would throw a browser error.
            if (!wbRightWindow.is(":hidden")) {
                var $frameHeight = $rightContentDiv.height() - wbGlobalSettings.contentMargin;
                if ($frameHeight < 100) {
                    $frameHeight = 100;
                }
                $("#wbComposeIFrame").css({ "height": $frameHeight });
            }
        },

        //adjusts panes on expand collapse
        adjustPanesOnExpandCollapse: function() {
            //do the necessary DOM lookups
            var $leftPane = $("#wbLeftPane"),
                $rightPane = $("#wbRightPane");

            $("#wbLeftWindowContentDiv").css({ "width": $leftPane.width() - wbGlobalSettings.contentMargin });
            $("#wbRightWindowContentDiv").css({ "width": $rightPane.width() - wbGlobalSettings.contentMargin });
            $("#wbHandleDiv").css("left", $leftPane.width() + wbGlobalSettings.$splitterWidth);
            $rightPane.css("left", $leftPane.width() + wbGlobalSettings.$splitterWidth + wbGlobalSettings.splitterMargin);
        },

        //binds all collapse events on appropriate elements.
        bindCollapseEvents: function() {
            var wbLeftPane = $("#wbLeftPane"),
                wbRightPane = $("#wbRightPane"),
                wbSplitter = $("#wbSplitter"),
                wbHandleDiv = $("#wbHandleDiv");

            //expand the left Pane
            $("#wbLeftCollapsedBtn").click(function() {
                expandWindow("wbLeftWindow", "wbLeftWindowCollapsed");
            });

            //expand the right window
            $("#wbRightCollapsedBtn").click(function() {
                expandWindow("wbRightWindow", "wbRightWindowCollapsed");
            });

            //collapse the left window
            $("#wbCollapseLeftWindowBtn").click(function() {
                collapseWindow("Left", "Right");
            });

            //collapse right window 	
            $("#wbCollapseRightWindowBtn").click(function() {
                collapseWindow("Right", "Left");
            });

            //expands the given window
            function expandWindow(normalWindow, collapseWindow) {
                //hide collapse window 
                $("#" + collapseWindow).hide();
                //show normal window
                $("#" + normalWindow).show();

                //adjust left pane and right pane width
                wbLeftPane.css("width", (wbSplitter.width() / 2) - wbGlobalSettings.splitterMargin);
                wbRightPane.css("width", wbSplitter.width() - wbLeftPane.width() - wbGlobalSettings.$splitterWidth);
                //bind the mouse down event
                wbHandleDiv.bind("mousedown", wbSplitterManager.startSplitMouse);

                wbResizeManager.adjustPanesOnExpandCollapse();
            }

            //collapses the given window
            function collapseWindow(windowToCollapse, windowToShow) {
                //hide window on "window to collapse"
                $("#wb" + windowToCollapse + "Window").hide();
                //show collapsed window of "window to collapse"
                $("#wb" + windowToCollapse + "WindowCollapsed").show();
                //if "window to show" is hidden
                if ($("#wb" + windowToShow + "Window").is(":hidden")) {
                    //hide collapse window "window to show"
                    $("#wb" + windowToShow + "WindowCollapsed").hide();
                    //show window of "window to show"
                    $("#wb" + windowToShow + "Window").show();
                }
                //adjust pane width
                var $windoToCollapsePane = $("#wb" + windowToCollapse + "Pane");
                $windoToCollapsePane.css("width", wbGlobalSettings.collapsePaneWidth);
                $("#wb" + windowToShow + "Pane").css("width", wbSplitter.width() - $windoToCollapsePane.width() - wbGlobalSettings.$splitterWidth);
                $("#wb" + windowToCollapse + "CollapsedTable").css("width", wbGlobalSettings.collapsePaneWidth);

                //unbind the mouse down event
                wbHandleDiv.unbind("mousedown", wbSplitterManager.startSplitMouse);
                //adjust panes
                wbResizeManager.adjustPanesOnExpandCollapse();
            }
        }
    };
    //short cut to 'resizeManager' class
    wbResizeManager = wikiBhasha.windowManagement.resizeManager;

    //describes the help window for the application, enables user to learn more about application.
    wikiBhasha.windowManagement.tutorialWindow = {
        windowId: "wbTutorialWindow",

        //describes current displayed slide number
        currentSlideNumber: 0,

        //displays tutorial window on application UI
        show: function() {

            wbUIHelper.createWindow(this.windowId, wbGlobalSettings.tutorialWindowHTML);
            wbUIHelper.makeDraggable(this.windowId, "wbTTDraggableHandle");

            this.currentSlideNumber = 0;

            var $previousButtonElement = $("#wbBackBtn"),
                $nextButtonElement = $("#wbNextBtn"),
                $tutorialTextElement = $("#wbTutorialText");

            //disable tutorial window back button
            $previousButtonElement.removeAttr("href");

            //if first slide, disable previous button
            if (wbTutorial.currentSlideNumber === 0) {
                $previousButtonElement.removeClass("wbTutorialPreviousBtn").addClass("wbTutorialDisabledPreviousBtn");
            }

            var tutorialText = wbLocal.tutorials[wbTutorial.currentSlideNumber];

            //default, push first slide text to tutorial window
            $tutorialTextElement.html(tutorialText);

            //display next tutorial slide on the click of next button of tutorial window
            $nextButtonElement.click(function() {
                wbTutorial.currentSlideNumber = wbTutorial.currentSlideNumber + 1;

                //get tutorial text for next slide
                tutorialText = wbLocal.tutorials[wbTutorial.currentSlideNumber];

                //push slide text to tutorial window
                $tutorialTextElement.html(tutorialText);

                //enable previous button of the tutorial window
                $previousButtonElement.attr("href", "#").removeClass("wbTutorialDisabledPreviousBtn").addClass("wbTutorialPreviousBtn");

                //if the current slide is last slide, disable the 'next' button of tutorial window.
                if (wbTutorial.currentSlideNumber === wbLocal.tutorials.length - 1) {
                    $nextButtonElement.removeAttr("href").addClass("wbTutorialDisabledNextBtn").removeClass("wbTutorialNextBtn");
                }
            });

            //display previous tutorial slide on the click of previous button of tutorial window
            $previousButtonElement.click(function() {
                wbTutorial.currentSlideNumber = wbTutorial.currentSlideNumber - 1;

                //get tutorial text for previous slide
                tutorialText = wbLocal.tutorials[wbTutorial.currentSlideNumber];

                //push slide text to tutorial window
                $tutorialTextElement.html(tutorialText);

                //enable next button of the tutorial window
                $nextButtonElement.attr("href", "#").removeClass("wbTutorialDisabledNextBtn").addClass("wbTutorialNextBtn");

                //if the current slide is first slide; disable the 'previous' button of tutorial window.
                if (wbTutorial.currentSlideNumber === 0) {
                    $previousButtonElement.removeAttr("href").removeClass("wbTutorialPreviousBtn").addClass("wbTutorialDisabledPreviousBtn");
                }
            });

            //closing the tutorial window on click of exit link
            $("#wbExitTutorialWindow").click(function() {
                wbTutorial.hide();
            });
        },

        //hides and removes tutorial window from application UI.
        hide: function() {
            wbUIHelper.removeWindow(this.windowId);
            wbGlobalSettings.activeWindowId = "";
        }
    };

    //shortcut to call wikiBhasha.windowManagement.tutorialWindow class
    wbTutorial = wikiBhasha.windowManagement.tutorialWindow;
})();
