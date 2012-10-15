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
* 1) languageSelectionWindow - Describes language selection window, which enables user to select target language to contribute.
*/

//make sure base 'windowManagement' class exists
if (typeof (wikiBhasha.windowManagement) === "undefined") {
    wikiBhasha.windowManagement = {};
}

(function() {

    //describes language selection window, which enables user to select target language to contribute.
    wikiBhasha.windowManagement.languageSelectionWindow = {

        //'languageSelection' window Id.
        windowId: "wbSelectionWindow",

        //describes the ID of the language drop down.
        languageOptionId: "wbLanguagesDropDown",

        //describes whether language drop down has to be shown or not
        showLanguageDropdown: true,

        //creates and displays language selection window
        show: function(showLanguageSelection) {

            this.showLanguageDropdown = showLanguageSelection;
            wbUIHelper.createWindow(this.windowId, wbGlobalSettings.languageSelectionWindowHTML);
            wbUIHelper.makeDraggable(this.windowId, "wbLSDraggableHandle");

            //do the DOM lookup on all the elements.
            var $languageDivElement = $("#wbLanguageDiv"),
                $articleTitleInputElement = $("#wbArticleTitleInput"),
                $articleTitleLabelElement = $("#wbArticleTitleLabel"),
                $languageOptionDivElement = $("#wbLanguageOptionsDiv");

            //set 'maxlength' for article title input field
            $articleTitleInputElement.attr("maxlength", wbGlobalSettings.inputTextMaxLength);

            //default, hide the language selection blocks
            $languageDivElement.hide();
            $languageOptionDivElement.hide();
            $("#wbOptionDiv").hide();
            $articleTitleInputElement.hide();
            $articleTitleLabelElement.hide();

            //populate supported languages in drop down
            this.populateMLTLanguages(this.languageOptionId, wbGlobalSettings.sourceLanguageCode);

            //apply localized strings in to language selection window
            this.applyLocalization();

            //adjust language selection window as per browser dimensions
            $(window).bind("resize", function() {
                wbLanguageSelection.resizeBrowserWindow(wbLanguageSelection.windowId);
            });

            //show the language options when user clicks on 'contribute' button
            $("#wbContributeBtn").click(function() {
                $languageDivElement.show();
                $languageOptionDivElement.show();
            });

            //language selection drop down item change event handler
            $("#" + this.languageOptionId).change(function() {
                wbGlobalSettings.isNewArticle = false;
                var $langOptionList = $("#" + wbLanguageSelection.languageOptionId),
                    $newArticleTitleInputElement = $("#wbArticleTitleInput");
                var $selectedItem = $langOptionList.find("option:selected");

                wbGlobalSettings.mtTargetLanguageCode = $selectedItem.val();
                if(wbGlobalSettings.mtTargetLanguageCode === 'zh-CHT' || wbGlobalSettings.mtTargetLanguageCode === 'zh-CHS'){
                       wbGlobalSettings.targetLanguageCode = 'zh';
                }else{
                    wbGlobalSettings.targetLanguageCode = wbGlobalSettings.mtTargetLanguageCode;
                }

                wbGlobalSettings.$targetLanguageName = $selectedItem.text();

                //set target language display name as per current language code
                $.each(wbGlobalSettings.mtlLanguages, function(intIndex, languageValues) {
                    if (wbGlobalSettings.mtTargetLanguageCode === languageValues[1]) {
                        wbGlobalSettings.targetLanguageDisplayName = languageValues[2];
                    }
                });

                //hide language option if selected languages is English
                if (wbGlobalSettings.targetLanguageCode === wbGlobalSettings.sourceLanguageCode) {
                    $("#wbOptionDiv").hide();
                    $articleTitleInputElement.hide();
                    $articleTitleLabelElement.hide();
                    return;
                }

                $newArticleTitleInputElement.val("");

                var currentLanguageCode = wbWikiSite.getCurrentLanguage();

                //if current article is in English, then get current page title and set to global 'sourceLanguageArticleTitle' variable
                if (currentLanguageCode === wbGlobalSettings.sourceLanguageCode) {
                    wbGlobalSettings.sourceLanguageArticleTitle = decodeURIComponent((wbWikiSite.getCurrentArticleTitle()));
                }
                wbLanguageSelection.processTitle();
            });

            //redirect article to target 'Wikipedia' page once user clicks the 'contribute' button
            $("#wbArticleTitleSubmitBtn").click(function() {
                wbLanguageSelection.loadArticle();
            });

            //captures Enter key on input box and loads new article in edit mode
            $articleTitleInputElement.keyup(function(e) {
                if (e.which === wbGlobalSettings.enterKeyCode) {
                    wbLanguageSelection.loadArticle();
                }
            });

            //closes the window on click of close button
            $("#wbExitLink").click(function() {
                wbLanguageSelection.hide();
            });

            //closes the window on click of exit link
            $("#wbExitWindow").click(function() {
                wbLanguageSelection.hide();
                wbLanguageSelection.deleteGlobalVariables();
            });
        },

        //checks for the existence of target article, if not available gives an option to 
        //create new one, else provides user with a 'contribute' button to navigate to the target article
        processTitle: function() {
            wbUIHelper.showElement("wbSearchLoading");
            wbWikiSite.getTargetLanguageTitle(wbGlobalSettings.sourceLanguageCode, wbGlobalSettings.targetLanguageCode, wbGlobalSettings.sourceLanguageArticleTitle, function(data) {
                var isTitleBeingTranslated = false;
                //if article exists
                if (data && data.length > 0) {
                    wbGlobalSettings.targetLanguageArticleTitle = decodeURIComponent(($.trim(data)));
                    $("#wbArticleTitleInput").hide();
                    $("#wbArticleTitleLabel").hide();
                }
                //if article does not exists
                else {
                    isTitleBeingTranslated = true;
                    wbGlobalSettings.targetLanguageArticleTitle = "";
                    wbGlobalSettings.isNewArticle = true;
                    $("#wbArticleTitleInput").show();
                    $("#wbArticleTitleLabel").show();
                    //translate the source article title to and use this translated title as a suggestion for target article title
                    wikiBhasha.configurations.languageServicesInterface.translate(wbGlobalSettings.sourceLanguageArticleTitle, wbGlobalSettings.sourceLanguageCode, wbGlobalSettings.mtTargetLanguageCode, function(translatedTitle) {
                        var $newArticleTitleInputElement = $("#wbArticleTitleInput"),
                            $currentUserEnteredTitle = $newArticleTitleInputElement.val();
                        if (!$currentUserEnteredTitle) {
                            $newArticleTitleInputElement.val(translatedTitle).get(0).select();
                            if ($("#wbArticleTitleInput:visible").length > 0) {
                                $newArticleTitleInputElement.get(0).focus();
                            }
                        }
                        wbUIHelper.hideElement("wbSearchLoading");
                    });
                }

                $("#wbOptionDiv").show();
                
                // show message if the invocation was using bookmarklet
                if (typeof (wbIsInvokedFromBookmarklet) !== "undefined"){
                    $("#wbUserOption").show();
                }
                else {
                    $("#wbUserOption").hide();
                }
                
                wbLanguageSelection.applyLocalization();
                if (!isTitleBeingTranslated) {
                    wbUIHelper.hideElement("wbSearchLoading");
                }
            });
        },

        //sets all the global variable values to 'undefined' to clear the browser memory
        deleteGlobalVariables: function() {
            var wbGlobalVariables =
            ["baseUrl",
            "s",
            "wbGlobalSettings",
            "wbLanguageSelection",
            "wbLanguageServices",
            "wbLocal",
            "wbSplash",
            "wbUIHelper",
            "wbUtil",
            "wbWikiSite",
            "wbWorkflow"];
            for (var i = 0; i < wbGlobalVariables.length; i++) {
                window[wbGlobalVariables[i]] = undefined;
            }
        },

        //loads target article either in edit mode or preview mode based on whether its a new article or existing article.
        loadArticle: function() {
            var urlData = "",
                $newArticleTitleInputElement = $("#wbArticleTitleInput");
            //if it is a new article, create url with new article title
            if (wbGlobalSettings.isNewArticle) {
                var $newArticleTitle = $newArticleTitleInputElement.val();
                if ($newArticleTitle && $newArticleTitle.length) {
                    $newArticleTitle = $.trim($newArticleTitle);
                    //alert warning message if input text length is zero
                    if ($newArticleTitle.length === 0) {
                        window.alert(wbLocal.emptyInputText);
                        $newArticleTitleInputElement.focus();
                        return;
                    }

                    wbGlobalSettings.targetLanguageArticleTitle = decodeURIComponent($newArticleTitle);
                    //create redirect url with help of 'wbWikiSite' class
                    urlData = this.makeEditUrl(wbWikiSite.wikiUrlFormat, wbGlobalSettings.targetLanguageCode, wbGlobalSettings.targetLanguageArticleTitle);
                    urlData = wbUtil.stringFormat("{0}&{1}={2}", urlData, "wbTitle", wbGlobalSettings.sourceLanguageArticleTitle);
                }
                //alert warning message if input text is empty
                else {
                    window.alert(wbLocal.emptyInputText);
                    $newArticleTitleInputElement.focus();
                    return false;
                }
           
                //check if user entered title already exists
                wbWikiSite.isArticleAvailable(wbGlobalSettings.targetLanguageCode, wbGlobalSettings.targetLanguageArticleTitle, function(isArticleAvailable) {  
                    if (isArticleAvailable) {
                        var confirmMessage = window.confirm(wbUtil.stringFormat(wbLocal.articleAlreadyExists, wbGlobalSettings.targetLanguageArticleTitle));
                        //prompt user whether he wants to continue with available article
                        if (confirmMessage) {
                            openTargetPage();
                        } 
                        else {
                            return false;
                        }
                    } 
                    else {
                        openTargetPage();
                    }
                });
            }
            //existing article
            else {
                //create redirect url with help of 'wbWikiSite' class
                urlData = wbUtil.stringFormat(wbWikiSite.wikiUrlFormat, wbGlobalSettings.targetLanguageCode, encodeURIComponent(wbGlobalSettings.targetLanguageArticleTitle));
                openTargetPage();
            }

            //redirects the page to target article URL
            function openTargetPage() {
                // Check if the article is protected. If so, don’t allow the user to edit it. Just show the message and close WikiBhasha. Otherwise proceed further to load the page in WikiBhasha.
                wbWikiSite.isArticleProtected(wbGlobalSettings.targetLanguageCode, wbGlobalSettings.targetLanguageArticleTitle, function(isArticleProtected) {
                    if (isArticleProtected) {
                        window.alert(wbLocal.nonEditableMessage);
                        wbLanguageSelection.hide();
                        return false;
                    }
                    else {
                        var queryStringPrefix = (urlData.match(/\?/g) === null) ? "?" : "&";
                        urlData = urlData + queryStringPrefix + "wbAutoLaunch=true&mltCode="+wbGlobalSettings.mtTargetLanguageCode;
                        window.open(urlData, "_self");
                        return true;
                    }

                });
            }
        },

        //apply localized strings to language selection window
        applyLocalization: function() {
            var local = [["#wbCollaborativeDiv", "html", wbLocal.collaborativeTitle],
                         ["#wbCurrentLanguageDiv", "html", wbUtil.stringFormat("{1}{0}{2}{0}{3}", wbLocal.space, wbLocal.currentLanguage1, "\"" + decodeURIComponent(wbWikiSite.getCurrentArticleTitle()) + "\"", wbLocal.currentLanguage2)],
                         ["#wbExitLink", "html", wbUtil.stringFormat("<a href='#'>{0}</a>", wbLocal.exit)],
                         ["#wbLanguageArticleDiv", "html", wbLocal.languageArticle],
                         ["#wbContributeLanguageDiv", "html", wbLocal.contributeLanguage],
                         ["#wbUserOption", "html", wbUtil.stringFormat("<span class='wbRedtext'>{1}</span>{0}{2}", wbLocal.space, wbLocal.important,
                                                                         wbLocal.importantNote)],
                         ["#wbContributeBtn", "attr", wbLocal.contributeBtn],
                         ["#wbDetectArticleDiv", "html", wbLocal.detectArticle],
                         ["#wbArticleTitleSubmitBtn", "attr", wbLocal.create]];

            //read local string values and update html
            $.each(local, function(i, localizedStringValues) {
                if (localizedStringValues[1] === "html") {
                    $(localizedStringValues[0]).html(localizedStringValues[2]);
                }
                else if (localizedStringValues[1] === "attr") {
                    $(localizedStringValues[0]).attr("value", localizedStringValues[2]);
                }
            });

            //update local string, if target title is not equal to empty
            if (wbGlobalSettings.targetLanguageArticleTitle !== "") {
                $("#wbDetectArticleDiv").html(wbLocal.existingtArticle);
                $("#wbArticleTitleSubmitBtn").attr("value", wbLocal.contributeTo);
            }
        },

        //generates the edit URL for the given wikiURL and the given language code
        makeEditUrl: function(wikiUrlFormat, langCode, title) {
            //Opera fix:
            //Pages displayed inside an iframe will inherit the character encoding of the parent page, unless they specify their own character encoding. 
            //a malicious page that uses the UTF-7 character encoding can include other sites for example inside iframes. This can be exploited to 
            //perform cross-site scripting on certain sites, allowing the attacker to get access to the user's session data for those sites.
            //Source: http://www.opera.com/support/kb/view/855/
            return ($.browser.opera) ? wbUtil.stringFormat(wikiUrlFormat, langCode, title) : urlData = wbWikiSite.getEditPageUrl(langCode, title);
        },

        //sets the given window on center and resizes the lightbox effect to the browser dimensions
        resizeBrowserWindow: function(windowId) {
            wbUIHelper.setWindowOnCenter(windowId);
            var resizeddocSize = wbUtil.getDocumentInnerSize();
            $("#wbBlockParentUI").css({ 'height': resizeddocSize[1], 'width': resizeddocSize[0] });
        },

        //populates the translator supported languages to drop down 
        populateMLTLanguages: function(elementId, sourceLanguageCode) {
            var divId = "#" + elementId;
            //remove all selection from div
            $(divId + ">option").remove();

            //default, load the option list with default text available in localized strings.
            var optionList = wbUtil.stringFormat("<option selected='selected' value='{0}'>{1}</option>",
                             sourceLanguageCode, wbLocal.defaultLanguageText);

            //build option list for drop down
            $.each(wbGlobalSettings.mtlLanguages, function(intIndex, languageValues) {
                //if language code is other than english
                if (sourceLanguageCode !== languageValues[1]) {
                    optionList += wbUtil.stringFormat("<option selected='selected' value='{0}'>{1}</option>", languageValues[1], languageValues[2]);
                }
            });

            //populate the language options drop down
            $(divId).html(optionList).get(0).selectedIndex = 0;
        },

        //hides and removes the language Selection window
        hide: function() {
            wbUIHelper.hideLightBox();
            $("div[class=wbTooltip]").remove();
            wbUIHelper.removeWindow(wbLanguageSelection.windowId);
        }
    };

    //shortcut to call 'wb.windowManagement.languageSelectionWindow' class
    wbLanguageSelection = wikiBhasha.windowManagement.languageSelectionWindow;
})();