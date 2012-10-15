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
    wikiBhasha.windowManagement.shareOnExternSystemWindow =  {

    windowId : "wbshareOnExternSystemWindow",

    shortenURL: "",

    listShareSystems:['wbFacebook',
                      'wbTwitter'],
    
    show : function() {
        var $shareOnExternSystemElement = $("#" + this.windowId);
        wbUIHelper.blockUI();
        wbUIHelper.createWindow(this.windowId, wbGlobalSettings.shareOnExternSystemHTML);
        wbUIHelper.makeDraggable(this.windowId, "wbSWESDraggableHandle");
        wbShortenURL.getShortenURL(window.location.href.replace(/&action=edit/ig, ""), function(url){ 
            wbUIHelper.changeCursorToHourGlass();
            wbShareOnExternSystem.shortenURL = url;
            for (var i = 0; i < wbShareOnExternSystem.listShareSystems.length; i++) {
                $(window[wbShareOnExternSystem.listShareSystems[i]].showItemElement()).appendTo($('#wbShareIconsSection'));
                window[wbShareOnExternSystem.listShareSystems[i]].initialize();
            }
            $('#msgText').html(wbUtil.stringFormat(wbLocal.shareMessage, wbShareOnExternSystem.setShortenURL(wbGlobalSettings.targetLanguageArticleTitle, true), wbGlobalSettings.$targetLanguageName));
            wbUIHelper.changeCursorToDefault();
        });

        $('#thxMsg').text(wbUtil.stringFormat(wbLocal.exitMessage, wbGlobalSettings.$targetLanguageName, wbShareOnExternSystem.shortenURL));
        $('#msgTitle').text(wbLocal.shareMesgTitle);
        $('#copyToClipboard').text(wbLocal.copyToClipboard);
        
        $("#wbSWESExitButton").click(function() {
            wbShareOnExternSystem.hide();
            wbShareOnExternSystem.reloadWikiPage();
            wbMainWindow.hide();
        });

        if ($.browser.msie) {
            $("#copyToClipboard").click(function() {
                wbUtil.copyContentToClipboard($("#msgText").text());
            });
        }else{
            $("#copyToClipboardDiv").hide();
        }        
    },
    //removes the window from memory
    hide : function(){
        wbUIHelper.unblockUI();
        wbUIHelper.removeWindow(wbShareOnExternSystem.windowId);
        var currentPageUrl = window.location.href;
        currentPageUrl = currentPageUrl.replace(/&action=edit/ig, "");
        window.location.href = currentPageUrl;
        return;
    },
    // closes the application and loads the wiki view page
    reloadWikiPage : function() {
        var currentPageUrl = window.location.href;
        currentPageUrl = currentPageUrl.replace(/&action=edit/ig, "");
        window.location.href = currentPageUrl;
        return;
    },
    // if shorten url exist format messages
    setShortenURL: function(message, withAnchor){
        if(wbShareOnExternSystem.shortenURL){
            if(withAnchor){
                return message + ' (<a href="' + wbShareOnExternSystem.shortenURL + '" target="_BLANK">'+wbShareOnExternSystem.shortenURL+'</a>)';
            }else{
                return message + ' ('+ wbShareOnExternSystem.shortenURL +')';
            }
        }else{
            return message;
        }
    }
};

wbShareOnExternSystem = wikiBhasha.windowManagement.shareOnExternSystemWindow;

})();