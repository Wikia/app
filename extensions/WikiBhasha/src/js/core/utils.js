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
* 1) wbUtil     - Includes all the utility methods for the application
* 2) wbUIHelper - Includes all the helper methods that manipulates application UI.
* 
*/

(function () {
    //includes all the utility methods for the application
    wikiBhasha.util = {

        //formats the given text. Eg:http://{0}/wikipedia.org/{1}
        //Example Input: stringFormat("<div id='{0}' class='{1}'>", "divId", "divClass").
        //Example Output: <div id='divId' class='divClass'>        
        stringFormat: function (text) {
            var args = arguments;
            return text.replace(/\{(\d+)\}/g, function (matchedPattern, matchedValue) {
                return args[parseInt(matchedValue) + 1];
            });
        },

        //gets the document inner size
        getDocumentInnerSize: function () {
            var documentElement = $(document);
            return [documentElement.width() + "px", documentElement.height() + "px"];
        },

        //disables event, used to prevent the default behavior of the event
        disableEvent: function () {
            return false;
        },

        //gets the window screen inner size
        getWindowInnerSize: function () {
            var winW, winH;

            //IE fix, IE uses 'innerWidth' and 'innerHeight' properties for window inner sizes
            if (!$.browser.msie) {
                winW = window.innerWidth;
                winH = window.innerHeight;
            }
            //other browsers use 'clientWidth' and 'clientHeight' properties for window inner sizes.
            else {
                winW = document.documentElement.clientWidth;
                winH = document.documentElement.clientHeight;
            }
            return [winW, winH];
        },

        //gets query string value for the given 'key' from current page URL
        getQueryStringValue: function (key) {
            //add escape characters to square brackets like '[' or ']'
            key = key.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
            //create a RegExp to match the query string values with given 'key'
            var regex = new RegExp("[\\?&]" + key + "=([^&#]*)"),
                qs = regex.exec(window.location.href);
            if (qs && qs.length) {
                return qs[1];
            }
        },

        //catches the 'Ctrl' key combinations. Ex: Ctrl + B or Ctrl + A
        catchCtrlKeyCombination: function (key, callback, args) {
            $(document).keydown(function (e) {
                //IE Fix: Browser throws an error when args is null
                if (!args) {
                    args = [];
                }
                if (e.which === key.charCodeAt(0) && e.ctrlKey) {
                    callback.apply(this, args);
                    return false;
                }
            });
        },

        //truncates the given string if its length is more than the cutoff length 
        //and adds suffixstring at the end of the new string
        truncateString: function (originalString, cutoffLength, isSuffixRequired) {
            var sufficStr = (isSuffixRequired) ? wbGlobalSettings.suffixStringForCutoffString : "";
            if (originalString.length > cutoffLength) {
                return (originalString.substr(0, cutoffLength - 1) + sufficStr);
            }
            return originalString;
        },

        //replaces HTML symbols(non encodeURL symbols) by their corresponding codes(Ex: (single quote)' will be replaced by &#39;) 
        replaceHtmlSymbolWithCode: function (text) {
            var symbolAndCode = { "'": "&#39;", "\"": "&#34;" };
            for (var symbol in symbolAndCode) {
                text = text.replace(new RegExp(symbol, "g"), symbolAndCode[symbol]);
            }
            return text;
        },

        //gets data attribute stored by elements
        getDataAttribute: function (elem) {
            //the below commented statement, which is using ‘jQuery.data()’ will work with “jquery-1.4.2.min.js” and the above versions. 
            //return $(elem).data("_wbData");
            var data = elem["_wbData"];
            if (!data && elem.getAttribute) {
                data = elem.getAttribute("_wbData");
            }
            return data;
        },

        // sets data attribute 
        setDataAttribute: function (elem, data) {
            // The below commented statement, which is using ‘jQuery.data()’ will work with “jquery-1.4.2.min.js” and the above versions. 
            //$(elem).data("_wbData", data);
            elem.setAttribute("_wbData", data);
        },

        //copy content to clipboard
        copyContentToClipboard: function (text) {
            if (window.clipboardData) {
                window.clipboardData.setData('text', text);
                return true;
            } else {
                return false;
            }
        },

        //remove html tags from the target object content
        stripTags: function (htmlContent) {
            $("body").append("<div id='tmpData'></div>");
            $('#tmpData').hide();
            $('#tmpData').html(htmlContent);
            var text = $('#tmpData').text();
            $('#tmpData').remove();
            return text
        }
    };

    //includes all the helper methods that manipulate application UI.
    wikiBhasha.UIHelper = {
        //attaches style sheet file in to the document body
        attachStyle: function (url, id /*[Optional]*/) {
            if (url && url.length > 0) {
                var head = document.getElementsByTagName("head")[0],
                    link = document.createElement("link");
                if (id) {
                    link.id = id;
                }
                link.type = "text/css";
                link.rel = "stylesheet";
                link.media = "screen";
                link.href = url;
                head.appendChild(link);
            }
        },

        //shows the scroll for the page
        showScroll: function () {
            //enable scroll when maximized, IE 7 html tag has overflow
            if ($.browser.msie && parseInt($.browser.version) <= 7) {
                $("html").css("overflow", "auto");
            }
            else {
                $("body").css("overflow", "auto");
            }
        },

        //hides the scroll for the page
        hideScroll: function () {
            //sets overflow hidden for the page
            var rootElem = ($.browser.msie && parseInt($.browser.version) <= 7) ? $("html") : $("body");
            rootElem.css("overflow", "hidden");
        },

        //removes the given theme style sheet from the document
        removeThemeStyles: function (theme) {
            var head = document.getElementsByTagName("head")[0],
                link = document.getElementById("wbCSS" + theme);
            if (link) {
                head.removeChild(link);
            }
        },

        //gets the user selected text.
        getSelectedText: function () {
            var selectedText = "";
            //FF specific property
            if (document.getSelection) {
                selectedText = document.getSelection();
            }
            //other browsers specific property
            else if (window.getSelection) {
                selectedText = window.getSelection();
            }
            //IE 6/7 specific property
            else if (document.selection) {
                selectedText = document.selection.createRange().text;
            }
            return selectedText;
        },

        //creates a window for given HTML id and the content.
        createWindow: function (windowId, innerHtml) {
            var $windowElement = $("#" + windowId);
            if ($windowElement.length === 0) {
                //attaches the div on the document.
                $("<div></div>").attr("id", windowId).html(innerHtml).appendTo(document.body);
                $windowElement = $("#" + windowId);
                //change image relative path in to absolute path 
                var regHttp = /(http):/;
                $windowElement.find("img").each(function () {
                    var source = $(this).attr("src");
                    if (source.match(regHttp)) {
                        //change the domain name
                        var wikiHostName = wbGlobalSettings.baseUrl.replace("http://", "");
                        source = source.replace(window.location.host, wikiHostName);
                    }
                    else {
                        //append base url in to image relative path
                        source = (wbGlobalSettings.imgBaseUrl ? wbGlobalSettings.imgBaseUrl : baseUrl) + source.substring(3, source.length);
                    }
                    $(this).attr("src", source);
                });

                //display window on center of the screen
                this.setWindowOnCenter(windowId);

                //move top of the window
                $(window).scrollTop(0);

                //set maximum Z-index, get maximum Z-index and increment by 5
                $windowElement.maxZIndex({ inc: 5 });
            }
        },

        //enables draggability for the given window id and handler DIV id 
        makeDraggable: function (windowId, handle) {
            //set maximum Z-index. get maximum Z-index and increment by 5
            var $windowElement = $("#" + windowId);
            $windowElement.maxZIndex({ inc: 5 });
            $windowElement.click(function () { $windowElement.maxZIndex({ inc: 5 }); });
            $windowElement.draggable({ handle: '#' + handle });
        },

        //sets the given window position to the center of the screen.
        setWindowOnCenter: function (windowId) {
            var $windowElement = $("#" + windowId),
                $browserWindowElement = $(window),
            //vertical offset of the dialog from center screen, in pixels
                verticalOffset = -10,
            //horizontal offset of the dialog from center screen, in pixels
                horizontalOffset = 0,
                top = (($browserWindowElement.height() / 2) - ($windowElement.outerHeight() / 2)) + verticalOffset,
                left = (($browserWindowElement.width() / 2) - ($windowElement.outerWidth() / 2)) + horizontalOffset;
            if (top < 0) {
                top = 0;
            }
            if (left < 0) {
                left = 0;
            }

            //set top and left to the window
            $windowElement.css({
                top: top + 'px',
                left: left + 'px'
            });
        },

        //removes the given element
        removeWindow: function (elementId) {
            $("#" + elementId).remove();
        },

        //creates a light box effect on the document body
        showLightBox: function () {
            var docSize = wbUtil.getDocumentInnerSize();
            if ($("#wbBlockParentUI").length === 0) {
                $("body").append(wbUtil.stringFormat('<div id="wbBlockParentUI" style="width:{0}; height:{1};"></div>',
                            docSize[0], docSize[1]));
            }
        },

        //blocks the UI for splash window
        blockUI: function () {
            var docSize = wbUtil.getDocumentInnerSize();
            if ($("#wbBlockChildUI").length === 0) {
                $("body").append(wbUtil.stringFormat('<div id="wbBlockChildUI" style="width:{0}; height:{1}"></div>', docSize[0], docSize[1]));
                $("#wbBlockChildUI").maxZIndex({ inc: 5 });
            }
        },

        //hides the lightbox effect
        hideLightBox: function () {
            var wbBlockParentUI = $("#wbBlockParentUI");
            //remove parent block and child block
            if (wbBlockParentUI.length !== 0) {
                wbBlockParentUI.remove();
            }
            //show the scroll back for the page.
            this.showScroll();
        },

        //unblocks the UI on splash window exit
        unblockUI: function () {
            //remove only child block if it is exists
            var wbBlockChildUI = $("#wbBlockChildUI");
            if (wbBlockChildUI.length !== 0) {
                wbBlockChildUI.remove();
            }
        },

        //displays the given element
        showElement: function (elementId) {
            $("#" + elementId).show();
        },

        //hides the given element
        hideElement: function (elementId) {
            $("#" + elementId).hide();
        },

        //constructs the time stamp, for versioning the user edits done through wikiBhasha
        getTimeStamp: function () {
            var date = new Date(),
                timeStamp = date.getFullYear() + "-" + (date.getUTCMonth() + 1) + "-" + date.getUTCDate() + ":";
            timeStamp = timeStamp + date.getUTCHours() + ":" + date.getUTCMinutes() + ":" + date.getUTCSeconds() + ":" + date.getMilliseconds();
            return timeStamp;
        },

        //creates a new session and registers wbGlobalSettings.sessionId
        createSession: function () {
            var $browserName = $.browser.name,
                $browserVer = $.browser.version,
                ua = navigator.userAgent.toLowerCase(),
                osName = (/win/.test(ua)) ? "Windows"
                : (/mac/.test(ua)) ? "Macintosh"
                : (/linux/.test(ua)) ? "Linux" : "Other";

            wbLoggerService.createSession(document.location.href /*url*/,
                $browserName + ":" + $browserVer /* browserInfo */,
                 osName /* operatingSystemInfo */,
                 function (sessionId) { wbGlobalSettings.sessionId = sessionId; }
                 );
        },

        //creates tool tip for the given elementId
        setTooltipForElement: function (elementId, tooltipText) {
            var newContentId = elementId + "TooltipText",
                emptyTable = "<table><tr><td></td></tr></table>",
                tooltipWindowHTML = wbGlobalSettings.tooltipWindowHTML.replace("wbDynamicId", newContentId),


            //display tooltip little away from the element
                xAdj = 10,
                yAdj = 20,
                tooltipId = elementId + "tooltipElement";

            if ($("#" + tooltipId).length === 0) {
                var tooltipElement = $("<div></div>").attr("id", tooltipId).html(tooltipWindowHTML).appendTo(document.body);

                tooltipElement.maxZIndex({ inc: 5 });
                tooltipElement.addClass("wbTooltip");
                $("#" + newContentId).html(tooltipText);
                $("#" + elementId).removeAttr("title").mouseover(function () {
                    tooltipElement.css({ display: "block" }).fadeIn("fast");
                }).mousemove(function (kmouse) {
                    tooltipElement.css({ left: kmouse.pageX - xAdj, top: kmouse.pageY + yAdj });
                    tooltipElement.innerHTML = emptyTable;
                }).mouseout(function () {
                    tooltipElement.fadeOut("fast");
                    tooltipElement.innerHTML = emptyTable;
                }).keydown(function () {
                    tooltipElement.fadeOut("fast");
                    tooltipElement.innerHTML = emptyTable;
                }).keypress(function () {
                    tooltipElement.fadeOut("fast");
                    tooltipElement.innerHTML = emptyTable;
                });
            }
        },
        //sets the given window position to the context of the mouse pointer hovered element.
        setWindowOnContext: function (windowId, elem) {
            var $windowElement = $("#" + windowId),
                $browserWindowElement = $(window),
                pos = $(elem).offset(),
                left = pos.left,
                top = pos.top,
                wHeight = $windowElement.height(),
                wWidth = $windowElement.width();

            if ((top + wHeight + 30) > $(window).height()) {
                top = top - wHeight;
            }

            if ((left + wWidth + 30) > $(window).width()) {
                left = left - wWidth;
            } else {
                left = left + $(elem).width();
            }

            //set top and left to the window
            $windowElement.css({
                top: top + 'px',
                left: left + 'px'
            });
        },
        // changed the mouse pointer to hourglass pointer
        changeCursorToHourGlass: function () {
            $("body").css("cursor", "progress");
        },
        // changed the mouse pointer to default pointer
        changeCursorToDefault: function () {
            $("body").css("cursor", "auto");
        }
    };

    //shortcut to call wikiBhasha.util class
    wbUtil = wikiBhasha.util;

    //short cut to call wikiBhasha helper class
    wbUIHelper = wikiBhasha.UIHelper;

})();