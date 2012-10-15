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
* 
* Available Classes:
* 1) scratchPadWindow     - Describes scratch window for the application, which enables user to translate given string and also maintains the history of translation done by the user.
* 
*/

//make sure the namespace exists.
if (typeof (wikiBhasha.windowManagement) === "undefined") {
    wikiBhasha.windowManagement = {};
}

(function() {
    //describes scratch window for the application, which enables user to translate given string and also 
    //maintains the history of translation done by the user.
    wikiBhasha.windowManagement.scratchPadWindow = {

        //scratchpad window div Id.
        windowId: "wbScratchPadWindow",

        // previous row id used for inserting item before the current item	
        previousRowId: "",

        // scratchpad current row number
        currentRowId: 1,

        // number of rows
        rowCount: 1,

        $clearAllButton: null,
        $sourceTextBox: null,
        $targetTextBox: null,

        //initializes scratchpad window
        initialize: function() {
            $("#wbScratchPadBtn").click(function() {
                //launch scratchpad
                wbScratchPad.show();
            });
        },

        //displays scratchpad window on application UI
        show: function() {

            var $scratchPadWindowElement = $("#" + this.windowId);
            wbLoggerService.logFeatureUsage(wbGlobalSettings.sessionId, "ScratchPad");

            //get user selected text
            var selectedText = wbUIHelper.getSelectedText() || wbContextMenuHandler.lastSelectedText;

            if ($scratchPadWindowElement.length === 0) {

                wbUIHelper.createWindow(this.windowId, wbGlobalSettings.scratchpadWindowHTML);

                $scratchPadWindowElement = $("#" + this.windowId);
                this.$clearAllButton = $("#wbClearAllBtn");
                this.$sourceTextBox = $("#wbSourceText");
                this.$targetTextBox = $("#wbTargetText");

                $("#scratchPadLimitNoteText").html(wbUtil.stringFormat(wbLocal.scratchPadTextLimitNote, wbGlobalSettings.scratchpadTextMaxLength));
                $("#wbScratchpadHeadLabelLeft").html(wbUtil.stringFormat("<h4>{0} Text</h4>", wbLocal.english));
                $("#wbScratchpadHeadLabelRight").html(wbUtil.stringFormat("<h4>{0} Text</h4>", wbGlobalSettings.targetLanguageDisplayName));
                $('#wbSourceToTargetBtn').val(wbUtil.stringFormat("{0} >> {1}", wbGlobalSettings.sourceLanguageCode, wbGlobalSettings.mtTargetLanguageCode));
                $('#wbTargetToSourceBtn').val(wbUtil.stringFormat("{0} << {1}", wbGlobalSettings.sourceLanguageCode, wbGlobalSettings.mtTargetLanguageCode));
                wbUIHelper.makeDraggable(this.windowId, "wbSPDraggableHandle");

                //set focus on text area
                this.$sourceTextBox.focus();
                this.applyLocalization();

                //close the scratchpad when user clicks on exit button
                $("#wbSPExitWindow").click(function() {
                    wbScratchPad.hide();
                });

                $("#wbSaveScratchPadContentBtn").click(function() {
                    wbScratchPad.saveScratchPadText(wbGlobalSettings.sourceLanguageCode, wbGlobalSettings.mtTargetLanguageCode);
                });
                
                //clear the text area when user clicks on 'clearAll' button
                this.$clearAllButton.click(function() {
                    wbScratchPad.clearAll();
                });

                //bind context menu on scratchpad window
                wbContextMenuHandler.bindContextMenuToElement(this.windowId);

                //default, disable the clear all button as there won't be any translations
                this.$clearAllButton.attr("disabled", "true");

                //when user clicks, translates the given string from source to target language
                $("#wbSourceToTargetBtn").click(function() {
                    wbScratchPad.translateScratchPadText("wbSourceText", wbGlobalSettings.sourceLanguageCode, wbGlobalSettings.mtTargetLanguageCode);
                });
                //set title for the button
                $("#wbSourceToTargetBtn").attr("Title", wbUtil.stringFormat(wbLocal.transleteButton, wbLocal.english, wbGlobalSettings.targetLanguageDisplayName));
                //when user clicks, translates the given string from target to source language

                $("#wbTargetToSourceBtn").click(function() {
                    wbScratchPad.translateScratchPadText("wbTargetText", wbGlobalSettings.mtTargetLanguageCode, wbGlobalSettings.sourceLanguageCode);
                });
                //set title for the button
                $("#wbTargetToSourceBtn").attr("Title", wbUtil.stringFormat(wbLocal.transleteButton, wbGlobalSettings.targetLanguageDisplayName, wbLocal.english));

                //handle the resizing for scratchpad window
                var scratchPad = $("#wbWrapperScratchPad"),
                    $scratchPadTableElement = $("#scratchPadTable");
                //assign the width and height.
                scratchPad.css("width", $scratchPadTableElement.width());
                $scratchPadTableElement.css("height", scratchPad.height());

                //bind the resizable component of jQuery to the scratchpad window
                scratchPad.resizable({
                    // when the scratchpad resize starts, launch the drag helper 
                    // div, which enables dragging over iframe.
                    start: function() {
                        var $frameWidth = $().width(),
                            $frameHeight = $().height(),
                            $splitterHelper = $("#wbSplitHelperDiv");
                        //to allow the resize work over the iframe we need to place a div over the complete window
                        $splitterHelper.css({
                            "left": 0,
                            "top": 0,
                            "height": $frameHeight,
                            "width": $frameWidth,
                            "z-index": "1000"
                        }).show();
                    },
                    // this event is fired while resizing the scratchpad
                    resize: function() {
                        var $translateArea = $("#wbTranslatedArea"),
                            sourceTextArea = wbScratchPad.$sourceTextBox,
                            targetTextArea = wbScratchPad.$targetTextBox,
                            offset = $translateArea.offset(),
                            $scratchPadTableElement = $("#scratchPadTable"),

                        //margin constants for scratchpad                        
                            contentMargin = 32,
                            contentHeightMargin = 136;

                        // resize the textarea and listint div width
                        $(".scratchTopLayout").css({"width": ($scratchPadTableElement.width()/2)-120,"display":"block"});
                        $(".scratchContentLayout").css({"width": ($scratchPadTableElement.width()/2)-120,"display":"block"});
                      
                        // resize the translated div height
                        $translateArea.css({"height": ($("#wbWrapperScratchPad").height() - sourceTextArea.height() - contentHeightMargin)});
                    },
                    // this event is fired while resizing of the scratchpad is stopped
                    stop: function() {
                        $("#wbSplitHelperDiv").hide();
                    }
                });
                //other resizable configuration on a scratchpad window
                scratchPad.resizable('option', 'alsoResize', '#scratchPadTable');
                scratchPad.resizable('option', 'minWidth', scratchPad.width());
                scratchPad.resizable('option', 'minHeight', scratchPad.height());
            }
            else {
                wbUIHelper.makeDraggable(this.windowId, "wbSPDraggableHandle");
                $scratchPadWindowElement.show();
            }

            this.$sourceTextBox.val($.trim(selectedText));

            //disable/enable clear all button as per row count
            if (this.rowCount === 1) {
                this.$clearAllButton.attr("disabled", "true");
            }
            else {
                this.$clearAllButton.removeAttr("disabled");
            }

            //clear the user selected text.
            wbContextMenuHandler.lastSelectedText = "";
        },

        //deletes given row from the translation history
        deleteRow: function(rowId) {
            $('#wbTargetRow'+rowId).remove();
            this.rowCount = this.rowCount - 1;
            if (this.rowCount === 1) {
                this.$clearAllButton.attr("disabled", "true");
            }
            return true;
        },

        //loads given row from the translation history to the edit/add form
        editRow: function(rowId) {
            this.$sourceTextBox.val($('#wbSourceCol'+rowId).text());
            this.$targetTextBox.val($('#wbTargetCol'+rowId).text());
            return true;
        },

        //clears text from the scratchpad text area and translation history
        clearAll: function() {
            this.$sourceTextBox.val("");
            this.$targetTextBox.val("");
            //disable clear button 
            this.$clearAllButton.attr("disabled", "true");
            $('#wbTranslatedArea').html("");
            this.rowCount = 1;
            this.currentRowId = 1;
        },

        //translates the given scratchpad text
        translateScratchPadText: function(elementId, sourceCode, targetCode) {
            var $scratchPadTextElement = $("#" + elementId),
                $sourceText = $scratchPadTextElement.val();
            if ($sourceText && $sourceText.length) {
                $sourceText = $.trim($sourceText);
                if ($sourceText.length === 0) {
                    window.alert(wbLocal.emptyInputText, wbGlobalSettings.applicationName);
                    return;
                }

                if ($sourceText.length > wbGlobalSettings.scratchpadTextMaxLength) {
                    var ans = window.confirm(wbUtil.stringFormat(wbLocal.scratchPadTextLimitConfirmMsg, wbGlobalSettings.scratchpadTextMaxLength));
                    if (ans) {
                        $sourceText = wbUtil.truncateString($sourceText, wbGlobalSettings.scratchpadTextMaxLength, false);
                        $scratchPadTextElement.val($sourceText);
                    } 
                    else {
                        return;
                    }
                }

                wbUIHelper.showElement("wbTranslationLoading");
                //call the translate function to translate the given text
                wbLanguageServices.translate($sourceText, sourceCode, targetCode, function(translatedText) {
                    if (translatedText && translatedText.length) {
                        if(sourceCode!='en'){
                            $('#wbSourceText').val(translatedText);
                        }else{
                            $('#wbTargetText').val(translatedText);
                        }
                    }
                    wbUIHelper.hideElement("wbTranslationLoading");
                    return;
                });
            }
            else {
                window.alert(wbLocal.emptyInputText);
                wbUIHelper.hideElement("wbTranslationLoading");
                return;
            }
        },

        //saves the scratchpad text for future use
        saveScratchPadText: function(sourceCode, targetCode){
            //add new row with source text and translated text
            if($.trim($('#wbSourceText').val()).length === 0 && $.trim($('#wbTargetText').val()).length === 0){
                window.alert(wbLocal.emptyInputText, wbGlobalSettings.applicationName);
            }else{
                wbScratchPad.addRow($('#wbSourceText').val(), $('#wbTargetText').val(), sourceCode, targetCode);
                $('#wbSourceText').val("");
                $('#wbTargetText').val("")
                wbScratchPad.$clearAllButton.removeAttr("disabled");
            }
            return;
        },

        //adds row in to the scratchpad's translation history table
        addRow: function($sourceText, translatedText, sourceCode, targetCode) {
            //target row element id
            var targetRowId = "wbTargetRow" + this.currentRowId,
            //source text column element id
                sourceColId = "wbSourceCol" + this.currentRowId,
            //target text column id
                targetColId = "wbTargetCol" + this.currentRowId,
            //delete image row element id
                deleteRowBtn = "wbDeleteRowBtn" + this.currentRowId,
            //load image row element id
                editRowBtn = "wbEditRowBtn" + this.currentRowId,
            //scratchpad content box element
                $scratchPadTableElement = $("#scratchPadTable"),
            //create new translation history row
                newRow = wbUtil.stringFormat("<div id={0} class='scratchContentLayoutRow'><div class='scratchContentLayout' id={1}></div>"+
                                    "<div class='scratchTopButtonLayout'>&nbsp;</div>"+
                                    "<div class='scratchContentLayout' id={2} ></div>" +
                                    "<div class='scratchTopButtonLayout'>" +
                                    "<a id={3} class='wbDelete' href='#' name='{5}' title='Delete this row' class='scratchContentLayout'></a>" +
                                    "<a id={4} class='wbEdit' href='#' name='{5}' title='Load this row' class='scratchContentLayout'></a>" +
                                    "</div></div>", targetRowId, sourceColId, targetColId, deleteRowBtn, editRowBtn, this.currentRowId);

            
            //append row if the row contained in scratchpad is equal to 1 
            if (this.rowCount === 1) {
                $("#wbTranslatedArea").append(newRow);
            }
            else if (this.rowCount > 1) {
                // find the second TR (1st TR is for header of the table) 
                $(newRow).insertBefore("#" + $("#wbTranslatedArea").get(0).getElementsByTagName("div")[0].id);
            }

            // Warning! Do not use html() or innerHTML, which could cause script injection. 
            // Use text() method that sets pure text.
            $("#" + sourceColId).text($sourceText);
            $("#" + targetColId).text(translatedText);

            if(wbGlobalSettings.direction === 'rtl'){
                if(wbGlobalSettings.isLanguageRTL(sourceCode)){
                    $("#" + sourceColId).css("direction", wbGlobalSettings.direction);
                    $("#" + sourceColId).css("text-align", "right");
                } else {
                    $("#" + targetColId).css("direction", wbGlobalSettings.direction);
                    $("#" + targetColId).css("text-align", "right");
                }
            }
            this.$sourceTextBox.val("");
            //delete the row when user clicks on delete image
            $("#" + deleteRowBtn).bind('click', function() {
                wbScratchPad.deleteRow(this.name);
            });

            //Load the row when user clicks on load image
            $("#" + editRowBtn).bind('click', function() {
                wbScratchPad.editRow(this.name);
            });
            // resize the textarea and listint div width
            $(".scratchTopLayout").css({"width": ($scratchPadTableElement.width()/2)-120,"display":"block"});
            $(".scratchContentLayout").css({"width": ($scratchPadTableElement.width()/2)-120,"display":"block"});
                      
            this.rowCount = this.rowCount + 1;
            this.currentRowId = this.currentRowId + 1;
            this.$clearAllButton.removeAttr("disabled");
            this.previousRowId = targetRowId;
        },

        //applies localization on scratchpad window
        applyLocalization: function() {
            $("#wbScratchPadHeader").html(wbLocal.scratchPad);
            wbScratchPad.$clearAllButton.attr("value", wbLocal.clearAll);
            $("#wbSourceTextHeader").html(wbLocal.sourceTextHeader);
            $("#wbTranslatedTextHeader").html(wbLocal.translatedTextHeader);
        },

        //hides the scratchpad window from application UI
        hide: function() {
            $("#" + wbScratchPad.windowId).hide();
            wbUIHelper.hideElement("wbTranslationLoading");
        }
    };

    //shortcut to scratchpad class
    wbScratchPad = wikiBhasha.windowManagement.scratchPadWindow;

})();