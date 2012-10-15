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
* 1) searchWindow   - Describes the search window, which enables user to search various articles in wikipedia for contributing to the target language article
* 
*/

//make sure the namespace exists.
if (typeof (wikiBhasha.windowManagement) === "undefined") {
    wikiBhasha.windowManagement = {};
}

(function() {
    //describes the search window, which enables user to search various articles in wikipedia 
    //for contributing to the target language article
    wikiBhasha.windowManagement.searchWindow = {

        //search window div Id.
        windowId: "wbSearchWindow",

        searchHTML: "",

        //initializes search window
        initialize: function() {
            $("#wbSearchButton").click(function() {
                wbSearch.show();
            });
        },

        //displays search window on application UI
        show: function() {
            var $searchWindowElem = $("#" + this.windowId);

            if ($searchWindowElem.length === 0) {
                wbUIHelper.createWindow(this.windowId, wbGlobalSettings.searchWindowHTML);
                $("#wbSearchHeader").html(wbLocal.searchHeader);
                $searchWindowElem = $("#" + this.windowId);
                wbUIHelper.makeDraggable(this.windowId, "wbSearchDraggableHandle");

                var $searchInputElement = $("#wbSearchInput");
                //set max length for search input field
                $searchInputElement.attr("maxlength", wbGlobalSettings.inputTextMaxLength);

                //apply localized strings
                $("#wbSearchTitle").html(wbLocal.collaborativeSearchTitle);
                
                //set focus on inputbox
                $searchInputElement.focus();

                //close the window on click of exit button
                $("#wbExitWindow").click(function() {
                    wbSearch.hide();
                });

                //search articles on click of search button
                $("#wbSearchLink").click(function() {
                    var $searchKey = $searchInputElement.val();
                    wbSearch.loadSearchResults($searchKey, "wbSearchItem");
                });

                //search for articles when user hits the enter key in the input box.
                $searchInputElement.keyup(function(e) {
                    if (e.which === wbGlobalSettings.enterKeyCode) {
                        var $searchKey = $searchInputElement.val();
                        wbSearch.loadSearchResults($searchKey, "wbSearchItem");
                    }
                });
            }
            else {
                $searchWindowElem.show();
            }
            // bring the search window always on top.
            $searchWindowElem.maxZIndex({ inc: 5 });

            // log the usage of search window.
            wbLoggerService.logFeatureUsage(wbGlobalSettings.sessionId, "SearchWindowInvoked");
        },

        //prepares inner HTML to show the search results
        prepareSearchHTML: function(data, lang) {
            var searchHTML = "",
                htmlPrefix = "",
                $contentElement = "wbSourceArticleContentDiv",
                searchLanguageStyle = "",
                searchContentStyle = "",
                searchResult = [];

            //add css for language code on the beginning of the each search result
            if (lang === wbGlobalSettings.sourceLanguageCode) {
                searchLanguageStyle = "wbSourcelangCodeBox";
                searchContentStyle = "wbSourcesearchContentStyle";
            }
            //if it is target language, add different css
            else {
                searchLanguageStyle = "wbTargetlangCodeBox";
                searchContentStyle = "wbTargetSearchContentStyle";
            }

             htmlPrefix = wbUtil.stringFormat("<div><table width='100%'><tr><td class='{0}'>{1}</td><td class='{2}'>", searchLanguageStyle, lang, searchContentStyle);
            htmlPostfix = "<br /><br /></td></tr></table></div>";
        
            //construct complete inner html with the search results
            for (var i = 0; i < data.length; i++) {
                searchHTML = htmlPrefix;
                var snippet = wbUtil.stringFormat("<div style='direction:ltr'>{0}</div>", data[i].snippet);
                searchHTML += wbUtil.stringFormat("<a href='#' style='color:#0024FF' class='searchAnchor'>{0}</a>", data[i].title);
                
                searchHTML += wbUtil.stringFormat("<br />{1}<br />{2}{0}KB{0}({0}{3}{0}words{0}){0}{4}", wbLocal.space, snippet, data[i].size, data[i].wordcount, data[i].timestamp);
                searchHTML += htmlPostfix;
                searchResult[i] = searchHTML;
            }
            return searchResult;
        },

        //gets search results in source and target languages, shows them alternate(ex: en-article,de-article,en-article....)
        getSearchResults: function(targetLanguageCode, $searchKey, elementId) {
            if ($searchKey && $searchKey.length) {
                wbUIHelper.showElement("wbSearchLoading");
                var searchHTML = "",
                //source language search result
                    searchSourceHTML = [],
                //target language search result
                    searchTargetHTML = [];
                //load source language search results
                wbWikiSite.search(wbGlobalSettings.sourceLanguageCode, $searchKey, function(data) {
                    if (data && data.length) {
                        searchSourceHTML = wbSearch.prepareSearchHTML(data, wbGlobalSettings.sourceLanguageCode);
                    }
                    //load target article search results
                    wbWikiSite.search(targetLanguageCode, $searchKey, function(data) {
                        if (data && data.length) {
                            searchTargetHTML = wbSearch.prepareSearchHTML(data, wbGlobalSettings.targetLanguageCode);
                        }
                        for (var i = 0; i < Math.max(searchSourceHTML.length, searchTargetHTML.length); i++) {
                            //source language search result
                            if (searchSourceHTML[i]) {
                                searchHTML = searchHTML + searchSourceHTML[i];
                            }
                            //target language search result
                            if (searchTargetHTML[i]) {
                                searchHTML = searchHTML + searchTargetHTML[i];
                            }
                        }
                        //if search result is empty
                        if ((searchSourceHTML.length === 0) && (searchTargetHTML.length === 0)) {
                            //display empty search result
                            searchHTML = wbUtil.stringFormat("{0}", wbLocal.emptySearchResult);
                        }
                        // Warning!!! innerHTML is set with html built by search results. It is assumed that
                        // search results should not contain malicious script tag and content. This part should be 
                        // double checked if some code changes in building searchHTML.
                        $("#" + elementId).html(searchHTML);
                        
                        wbUIHelper.hideElement("wbSearchLoading");
                        wbUIHelper.setWindowOnCenter(wbSearch.windowId);
                        
                        $('a.searchAnchor').bind('click', function() {
                            wbDisplayPaneHelper.onArticleLinkClick($(this).parent().parent().children('td:first-child').html() , wbUtil.replaceHtmlSymbolWithCode($(this).html()));
                            return;
                        });
                    });
                });
            }
            else {
                window.alert(wbLocal.emptyInputText);
            }
        },

        //loads search result as inner html to given element, for the given search key
        loadSearchResults: function($searchKey, contentElementId) {
            var $contentElement = $("#" + contentElementId);
            if ($searchKey && $searchKey.length) {
                $searchKey = $.trim($searchKey);
                if ($searchKey.length === 0) {
                    window.alert(wbLocal.emptyInputText);
                    return;
                }
                //empty the previous search results
                $contentElement.html("");
                this.getSearchResults(wbGlobalSettings.targetLanguageCode, $searchKey, contentElementId);
            }
            else {
                //empty the previous search results
                $contentElement.html("");
                window.alert(wbLocal.emptyInputText);
            }

            // log search of specific item.
            wbLoggerService.logFeatureUsage(wbGlobalSettings.sessionId, "Search", $searchKey);
        },

        //displays empty search text in given element
        displayEmptyResult: function(contentElementId) {
            searchHTML = wbUtil.stringFormat("<br /><br />{0}", wbLocal.emptySearchResult);
            $("#" + contentElementId).html(searchHTML);
            wbUIHelper.hideElement("wbSearchLoading");
        },

        //removes the search window from the application window
        unload: function() {
            wbUIHelper.removeWindow(this.windowId);
        },

        //hides the search window from application UI
        hide: function() {
            $("#" + this.windowId).hide();
        }
    };

    //shortcut to call wikiBhasha.windowManagement.searchWindow
    wbSearch = wikiBhasha.windowManagement.searchWindow;
})();