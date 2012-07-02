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
* 1) wikiMarkupEditWindow   - Describes the wiki markup edit window, which enables user to edit the wiki markup and privew the same and save the same to the target language article
* 
*/

//make sure the namespace exists.
if (typeof (wikiBhasha.windowManagement) === "undefined") {
    wikiBhasha.windowManagement = {};
}

(function() {
    //describes the search window, which enables user to search various articles in wikipedia 
    //for contributing to the target language article
    wikiBhasha.windowManagement.wikiMarkupEditWindow = {

        //search window div Id.
        windowId: "wbWikiMarkupEditWindow",

        wikiMarkupEditWindowHTML: "",

        wikiMarkupEditObject:'',

        lang:'',

        timer:'',

        hasChanged:false,

        pane:null,

        showMenu: function(elem) {
            if(wbWikiMarkupEdit.hasChanged == true)
            {
                return;
            }
            var $wikiMarkupEditWindowElem = $("#" + wbWikiMarkupEdit.windowId),
                wikiMarkupText = elem ? wbUtil.getDataAttribute(elem) : null;

            //store the mouse hover element reference
            wbWikiMarkupEdit.wikiMarkupEditObject = elem;
            // normalize the <br> tags as new line chars
            wikiMarkupText=wikiMarkupText.replace(/<br\s*\/?>/gi, "\n");
            //check if the window was created already
            if ($wikiMarkupEditWindowElem.length === 0) {
                wbUIHelper.createWindow(wbWikiMarkupEdit.windowId, wbGlobalSettings.wikiMarkupEditWindowHTML);
                $wikiMarkupEditWindowElem = $("#" + wbWikiMarkupEdit.windowId);
                //preview $link
                $("#wbWikiMarkupEditPreviewLi").click(function(){  wbWikiMarkupEdit.preview();  });
                //markup content $link
                $("#wbWikiMarkupEditLi").click(function(){  wbWikiMarkupEdit.show(); });
                //save link
                $("#wbWikiMarkupEditSaveLink").click(function(){ wbWikiMarkupEdit.submit();});
                //cancel link
                $("#wbWikiMarkupEditCancelLink").click(function(){ wbWikiMarkupEdit.hide(); });
                // prevent drag drop of UI elements
                $("#wbWikiMarkupEditPreviewTab, .wbExit, .tabs_li, .wbWikiMarkupEditBottomLinks").each( function(){
                    $(this).mousedown(
                        function(event){
                            if ($.browser.msie) {
                                this.onselectstart = function() { return false; };
                            }else{
                                event.stopPropagation();
                                event.preventDefault();
                            }
                            return false;
                    });
                });
                $('#wbTranslationWindow').click(function() { 
                    if(wbWikiMarkupEdit.hasChanged == false)
                    {
                        wbWikiMarkupEdit.hide();
                    }
                    return;
                });
                //clicking inside the div, should not hide the wiki markup edit popup
                $('#wbWikiMarkupEditDiv').click(function(event){  event.stopPropagation(); });
                //closes the window on click of exit link
                $("#wbWikiMarkupEditExit").click(function() {  wbWikiMarkupEdit.hide(); });
                wbUIHelper.makeDraggable(wbWikiMarkupEdit.windowId, "wbWikiMarkupEditDraggableHandle");
            } 

            wbWikiMarkupEdit.hide();
            $('#'+wbWikiMarkupEdit.windowId).height($('#wbWikiMarkupEditDraggableHandle').height());

            // get the present pane object
            wbWikiMarkupEdit.pane = wbDisplayPaneManager.getPaneForId(wbDisplayPaneHelper.getElementsPaneDivId(elem));

            // set the language of the popup according to the pane
            wbWikiMarkupEdit.lang = wbWikiMarkupEdit.pane.contentLang;

            // get if the present pane is editable
            wbWikiMarkupEdit.isEditable = wbWikiMarkupEdit.pane.paneConfigInfo.isContentEditable;

            //populate the $content
            $("#wbWikiMarkupEditTab").val(wikiMarkupText);
            $("#wbWikiMarkupEditPreviewTab").html(wbLocal.loadingPreviewContent);

            wbUIHelper.setWindowOnContext(wbWikiMarkupEdit.windowId, elem);
            // bring the window always on top.
            $wikiMarkupEditWindowElem.maxZIndex({ inc: 5 });
       
            //hide the content divs
            $('#wbWikiMarkupEditPreviewTab').hide();
            $('#wbWikiMarkupEditTab').hide();
            $("#wbWikiMarkupEditTabsContainer").hide();

            $('#wbWikiMarkupEditLi').removeClass('active');
            $('#wbWikiMarkupEditPreviewLi').removeClass('active');

            // show / hide save cancel buttons
            if(wbWikiMarkupEdit.isEditable == true){
                $('#wbWikiMarkupEditSubmitLinks').show();
                $("#wbWikiMarkupEditTab").attr("readonly", false);
                $('#wbWikiMarkupEditLink').html('Edit Text');
            }else{
                $('#wbWikiMarkupEditSubmitLinks').hide();
                $("#wbWikiMarkupEditTab").attr("readonly", true);
                $('#wbWikiMarkupEditLink').html('View Text');
            }

            $wikiMarkupEditWindowElem.show();

            // log the usage of search window.
            wbLoggerService.logFeatureUsage(wbGlobalSettings.sessionId, "WikiMarkupEditWindowInvoked");
            
            //clear the previous timeout
            if(wbWikiMarkupEdit.timer){
                clearTimeout(wbWikiMarkupEdit.timer);
            }
            //set timeout to hide the popup
            wbWikiMarkupEdit.timer = setTimeout(function(){
                if($("#wbWikiMarkupEditTab").css("display") == "none" && $("#wbWikiMarkupEditPreviewTab").css("display") == "none"){
                    wbWikiMarkupEdit.hide();
                }
            },2500);
        },
        //displays search window on application UI
        show: function() {
            // reset the preview tab
            $("#wbWikiMarkupEditPreviewTab").html(wbLocal.loadingPreviewContent);
            //unhide the content div
            $("#wbWikiMarkupEditTabsContainer").show();
            if($("#wbWikiMarkupEditTab").css("display") == "none" && $("#wbWikiMarkupEditPreviewTab").css("display") == "none"){
                $(".tab_content").hide();
                $('#wbWikiMarkupEditTab').slideToggle("slow", function(){
                    $('#'+wbWikiMarkupEdit.windowId).height($('#wbWikiMarkupEditTab').height());
                    wbUIHelper.setWindowOnContext(wbWikiMarkupEdit.windowId, wbWikiMarkupEdit.wikiMarkupEditObject);
                });
            }else{
                $('#wbWikiMarkupEditPreviewTab').hide();
                $('#wbWikiMarkupEditTab').show();
            }
            // set property to disable/enable show / hide popup
            if(wbWikiMarkupEdit.isEditable == true){
                wbWikiMarkupEdit.hasChanged=true;
            }else{
                wbWikiMarkupEdit.hasChanged=false;
            }
            $('#wbWikiMarkupEditLi').addClass('active');
            $('#wbWikiMarkupEditPreviewLi').removeClass('active');
            return true;
        },

        preview : function(){
            wbWikiSite.getPreviewContent(wbWikiMarkupEdit.lang, $("#wbWikiMarkupEditTab").val(), function(previewData){ 
                        if(previewData){
                            $("#wbWikiMarkupEditPreviewTab").html(previewData); 
                        }else{
                            $("#wbWikiMarkupEditPreviewTab").html(wbLocal.previewErrorMessage);
                        }
                    });
            
            //unhide the preview tab
            $("#wbWikiMarkupEditTabsContainer").show();
            if($("#wbWikiMarkupEditPreviewTab").css("display") == "none" && $("#wbWikiMarkupEditTab").css("display") == "none"){
                $(".tab_content").hide();
                $('#wbWikiMarkupEditPreviewTab').slideToggle("slow", function(){
                    $('#'+wbWikiMarkupEdit.windowId).height($('#wbWikiMarkupEditPreviewTab').height());
                    wbUIHelper.setWindowOnContext(wbWikiMarkupEdit.windowId, wbWikiMarkupEdit.wikiMarkupEditObject);
                });
            }else{
                $('#wbWikiMarkupEditPreviewTab').show();
                $('#wbWikiMarkupEditTab').hide();
            }
            $('#wbWikiMarkupEditLi').removeClass('active');
            $('#wbWikiMarkupEditPreviewLi').addClass('active');
            return true;
        },

        submit : function(){
            wbUtil.setDataAttribute(wbWikiMarkupEdit.wikiMarkupEditObject, $("#wbWikiMarkupEditTab").val());
            wbWikiMarkupEdit.hide();
        },

        //removes the window from the application window
        unload: function() {
            wbUIHelper.removeWindow(this.windowId);
        },

        //hides the window from application UI
        hide: function() {
            $("#wbWikiMarkupEditTab").html("");
            // reset the preview tab
            $("#wbWikiMarkupEditPreviewTab").html(wbLocal.loadingPreviewContent);
            wbWikiMarkupEdit.hasChanged=false;
            $("#" + this.windowId).hide();
        }
    };

    //shortcut to call wikiBhasha.windowManagement.wikiMarkupEditWindow
    wbWikiMarkupEdit = wikiBhasha.windowManagement.wikiMarkupEditWindow;
})();