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
1) historyManager   - Includes all the properties and methods to handle user visited article in the application.
*/

//make sure the base namespace exists.
if (typeof (wikiBhasha.historyManagement) === "undefined") {
    wikiBhasha.historyManagement = {};
}

//creates an entity with information from user visited article.
wikiBhasha.historyManagement.historyEntity = function (title, langId, content, $translatedContent) {
    //title of the article
    this.title = title;
    //language ID of the article
    this.langId = langId;
    //content of the article
    this.content = content;
    //translated content of the article
    //this will be null if the article is in target language
    this.$translatedContent = $translatedContent;
};

// includes all the properties and methods to handle user visited article in the application.
// manages(adding/retrieving) the history entities of the user visited articles.
wikiBhasha.historyManagement.historyManager = new function() {
    var $historyDropDown,
        historyEntitiesCount = 0,
        historyEntitiesList = new function() {
            //hashtable, which has combination of ‘languageID-articleTitle’ as key and the corresponding history entity object as value. 
            var historyEntities = {};

            //adds a history entity object to the history hash table.
            this.addItem = function(historyEntity) {
                // form the key as ‘languageID-articleTitle’
                var key = historyEntity.langId + "-" + historyEntity.title;

                if (!this.isExists(historyEntity.title, historyEntity.langId)) {
                    // insert the history entity object for the above formed key
                    historyEntities[key] = historyEntity;
                    historyEntitiesCount++;
                    return historyEntity;
                }
                else {
                    return historyEntities[key];
                }
            };

            //checks the availability of an article in the history hash
            this.isExists = function(title, langId) {
                var key = langId + "-" + title;
                return !!historyEntities[key];
            };

            //retrieves the history entity object for the given article from the history hash and returns it.
            this.getHistoryEntity = function(title, langId) {
                var key = langId + "-" + title;
                return historyEntities[key];
            };
        };

    //initializes the visited article drop down
    this.initialize = function() {
        if (!$historyDropDown) {
            $historyDropDown = $("#wbHistoryContainer");
            $historyDropDown.html("");
        }

        //binds the change event to the history drop down list
        $historyDropDown.change(function() {
            var $selectedItem = wbHistoryManager.getSelectedItem(),
                historyItem = historyEntitiesList.getHistoryEntity($selectedItem.title, $selectedItem.langId);
            wbDisplayPaneHelper.updatePanesWithHistoryItem(historyItem);
        });
    };

    //adds a new article into the visited articles drop down box
    this.addItem = function(title, langId, historyEntity) {
        var historyDropDownItem = wbUtil.stringFormat("<option selected='selected' value='{0}'>{1}</option>", langId, title);
        $historyDropDown.append($(historyDropDownItem));
        historyEntitiesList.addItem(historyEntity);
    };

    //gets the selected article item from the drop down box
    this.getSelectedItem = function() {
        var $historyDropDownSelected = $("#wbHistoryContainer :selected");
        return { "langId": $historyDropDownSelected.val(), "title": $historyDropDownSelected.text() };
    };

    //sets a particular article item as the selected item in the drop down box
    this.setSelectedItem = function(title, langId) {
        title = title.toLowerCase();
        var options = $historyDropDown.children(),
            option;
        for (var i = 0; i < options.length; i++) {
            option = options[i];
            if (option.value === langId && option.innerHTML.toLowerCase() === title) {
                option.selected = 'selected';
                return;
            }
        }
        wikiBhasha.debugHelper.assertExpr(false, "Non existent item is asked for selection in history dropdown");
    };

    //checks the availability of an article in the history
    this.isExists = function(title, langId) {
        return historyEntitiesList.isExists(title, langId);
    };

    //gets the history entity for the given article
    this.getHistoryEntity = function(title, langId) {
        return historyEntitiesList.getHistoryEntity(title, langId);
    };

    // get the number of history items that the history manager has
    this.getHistoryEntitiesCount = function() {
        return historyEntitiesCount;
    };
};

//shortcuts for the above two classes
wbHistoryManager = wikiBhasha.historyManagement.historyManager;
