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
* 1) feedbackWindow     - Describes feedback window for the application, which enables user to give some feedback about the application.
* 
*/

//make sure the namespace exists.
if (typeof (wikiBhasha.windowManagement) === "undefined") {
    wikiBhasha.windowManagement = {};
}

(function() {
    //describes feedback window for the application, which enables user to give some feedback about the application.    
    wikiBhasha.windowManagement.feedbackWindow = {

        //feedback window div Id.
        windowId: "wbFeedbackWindow",

        $feedbackTextBox: null,

        //holds the selected option value from the feedback window.
        $selectedOptionValue: "",

        //max length of characters allowed in feedback window
        feedbackTextMaxLength: 1600,

        thankyouMessageDisplayDuration: 2000, //in milliseconds

        // function needed to call after submit or hide action.
        onHideCallback: null,

        //set this variable to 'true' when feedback window is invoked on main application window exit.
        //Use this variable to show 'Exit WikiBhasha' link on feedback window.
        isInvokedOnMainWindowExit: false,

        //initializes feedback window
        initialize: function() {
            $("#wbFeedbackButton").click(function() {
                //launch feedback window
                wbFeedback.show();
            });
        },

        //displays feedback window on application UI
        show: function() {

            var $feedbackWindowElement = $("#" + this.windowId);

            if ($feedbackWindowElement.length === 0) {

                wbUIHelper.createWindow(this.windowId, wbGlobalSettings.feedbackWindowHTML);

                $feedbackWindowElement = $("#" + this.windowId);
                this.$feedbackTextBox = $("#wbFeedbackText");

                //set focus on text area
                this.$feedbackTextBox.focus();

                $("#feedbackLimitNoteText").html(wbUtil.stringFormat(wbLocal.feedbackTextLimitNote, this.feedbackTextMaxLength));

                //close the feedback winow when user clicks on exit button
                $("#wbFBExitWindow").click(function() {
                    wbFeedback.onHideCallback = null;
                    wbFeedback.hide();
                });

                //submit the feedback when user clicks on submit button
                $("#wbSubmitFeedbackButton").click(function() {
                    wbFeedback.submit();
                });

                //close the feedback when user clicks on cancel button
                $("#wbCancelFeedbackButton").click(function() {
                    wbFeedback.onHideCallback = null;
                    wbFeedback.hide();
                });

                //enable feedback options for user to select one
                wbFeedback.enableFeedbackOptions();

                $("#feedBackMessageDiv").html(wbLocal.feedbackThankYouMessage);

                $("#wbFeedbackEmail").attr("href", "mailto:" + wbGlobalSettings.feedbackEmail + "?subject=WikiBhasha beta Feedback");
            }
            else {
                //always show the feedback form area and hide the thank you message.
                $("#wbFeedbackFormArea").css("display", "block");
                $("#wbFeedbackMsgArea").css("display", "none");
                $feedbackWindowElement.show();
            }

            //if feedback window invoked on main window exit link then show the additional UI elements
            if (wbFeedback.isInvokedOnMainWindowExit) {
                $("#feedbackQuestionMessage").html(wbLocal.feedbackQuestionMessage).show();
                $("#wbExitLinkInFeedbackWindow").show();
                $("#wbExitLinkInFeedbackWindow a").click(function() {
                    wbFeedback.onHideCallback = null;
                    wbFeedback.hide();
                    wbMainWindow.hide();
                });
            }
            else {
                $("#feedbackQuestionMessage").html(wbLocal.feedbackQuestionMessage).hide();
                $("#wbExitLinkInFeedbackWindow").hide();
            }

            wbUIHelper.makeDraggable(this.windowId, "wbFBDraggableHandle");
       },

        //hides the feedback window from application UI
        hide: function() {
            $("#" + wbFeedback.windowId).hide();
            // call the callback function if there is any
            if (this.onHideCallback) {
                this.onHideCallback();
            }
            wbFeedback.isInvokedOnMainWindowExit = false;
        },

        //enables feedback options for user to select one
        enableFeedbackOptions: function() {
            var $optionElements = $(".tdHover", $("#wbFeedbackIconsTable"));
            $optionElements.click(function() {
                $optionElements.removeClass("tdSelected");
                $selectedOptionElement = $(this);
                $selectedOptionElement.addClass("tdSelected");
                var $selectedOptionValue = $selectedOptionElement.attr("data");
                if ($selectedOptionValue) {
                    wbFeedback.$selectedOptionValue = $selectedOptionValue;
                }
            });
        },

        //resets the feedback window
        resetFeedback: function() {
            $(".tdSelected", $("#wbFeedbackIconsTable")).removeClass("tdSelected");
            wbFeedback.$selectedOptionValue = "";
            wbFeedback.$feedbackTextBox.val("");
        },

        //submits the feedback to given API
        submit: function() {
            var $feedbackTextValue = $.trim(wbFeedback.$feedbackTextBox.val());
            //before submitting the feedback, make sure either one option has been selected or 
            //user entered some text in the feedback form
            if ($feedbackTextValue === "" && wbFeedback.$selectedOptionValue === "") {
                window.alert(wbLocal.feedbackEmptyTextAlertMessage);
                wbFeedback.$feedbackTextBox.get(0).focus();
                return;
            } 
            else {
            
                wbLoggerService.logUserFeedback(wbGlobalSettings.sessionId, $feedbackTextValue, wbFeedback.$selectedOptionValue, function(status) {
                    var $feedbackMessageDivElement = $("#feedBackMessageDiv"),
                        responseSmile = '';

                    $("#wbFeedbackFormArea").css("display", "none");
                    $("#wbFeedbackMsgArea").css("display", "block");

                    if (status) {
                        $feedbackMessageDivElement.html(wbLocal.feedbackThankYouMessage);
                        //show the thank you message for a specified duration and close it automatically.
                        window.setTimeout(function() {
                            $("#" + wbFeedback.windowId).fadeOut("slow", function() {
                                wbFeedback.resetFeedback();
                                if (wbFeedback.onHideCallback) {
                                    wbFeedback.onHideCallback();
                                }
                            });
                        }, wbFeedback.thankyouMessageDisplayDuration);
                    } 

                    if(wbFeedback.$selectedOptionValue == 1){
                        responseSmile=" (-): ";
                    }else if(wbFeedback.$selectedOptionValue == 2){
                        responseSmile=" (+): ";
                    }

                    document.location=wbUtil.stringFormat("mailto:{0}?subject=WikiBhasha beta feedback{1}&body={2}",wbGlobalSettings.feedbackEmail, responseSmile, $feedbackTextValue);
                    
                    wbFeedback.isInvokedOnMainWindowExit = false;
                    $("#" + wbFeedback.windowId).hide();
                });
            }
        }
    };

    //shortcut to feedback class
    wbFeedback = wikiBhasha.windowManagement.feedbackWindow;

})();