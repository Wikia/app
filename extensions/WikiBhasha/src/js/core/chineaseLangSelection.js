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
* 1) Chinese Language Selection Window     - Describes chinese language selection window for the application, which enables the user to select chinese language translation type for translation.
* 
*/

//make sure the namespace exists.
if (typeof (wikiBhasha.windowManagement) === "undefined") {
    wikiBhasha.windowManagement = {};
}

(function() {
    wikiBhasha.windowManagement.chineseLangSelectionBox =  {

    windowId : "wbChineseLangSelectionWindow",
    
    show : function() {
        var $chineseLangSelectionElement = $("#" + this.windowId);
        wbUIHelper.showLightBox();
        if ($chineseLangSelectionElement.length === 0) {
            wbUIHelper.createWindow(this.windowId, wbGlobalSettings.chineseLangSelectionHTML);

            //close the winow when user clicks on exit button
            $("#wbCLSExitWindow").click(function() {
                wbChineseLangSelection.hide();
                wbChineseLangSelection.deleteGlobalVariables();
            });
                
            //assigns the MTS language to zh-CHT
            $("#wbCHTLangButton").click(function() {
                wbGlobalSettings.mtTargetLanguageCode = 'zh-CHT';
                wikiBhasha.loadApplication();
                wbChineseLangSelection.hide();
            });

            //assigns the MTS language to zh-CHS
            $("#wbCHSLangButton").click(function() {
                wbGlobalSettings.mtTargetLanguageCode = 'zh-CHS';
                wikiBhasha.loadApplication();
                wbChineseLangSelection.hide();
            });
        }
        $chineseLangSelectionElement.maxZIndex({ inc: 5 });
    },
    //removes the window from memory
    hide: function(){
        wbUIHelper.hideLightBox();
        wbUIHelper.removeWindow(wbChineseLangSelection.windowId);
    },
    //clean the objects from the memory
    deleteGlobalVariables: function() {
            var wbGlobalVariables =
            ["baseUrl",
            "s",
            "wbGlobalSettings",
            "wbChineseLangSelection",
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
        }
};

wbChineseLangSelection = wikiBhasha.windowManagement.chineseLangSelectionBox;

})();