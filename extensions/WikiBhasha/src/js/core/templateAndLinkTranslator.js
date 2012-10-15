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


//Make sure the base namespace exists.

if (typeof (wikiBhasha.contentManagement) === "undefined") {
    wikiBhasha.contentManagement = {};
}

// Class: templatesAndLinksTranslator
// This class takes a Div element having wikimarkup as input and looks for all links & templates within
// that div. It looks for corresponding links & templates in the given targetLanguage param and
// replaces the source links/templates with the target lanuage equivalent links/templates.
//
// If the number of links/templates are more than API supported (pageSize), it splits into multiple
// calls and makes multiple async calls to replace.

// Sample code to call the this templatesAndLinksTranslator
// step 1: before calling translator or highlighter API, as soon as we get raw wikimarkup, call this code to convert parameterized templates
//var t = new wikiBhasha.contentManagement.templatesAndLinksTranslator($("#contentDiv"), "ja");
//var wikiText = t.translateTemplatesOnWikiTextBeforeTranslation(wikiText);

// step 2: After translation finishes
//var t = new wikiBhasha.contentManagement.templatesAndLinksTranslator($("#contentDiv"), "ja");
//t.startInterwikiConversion();

wikiBhasha.contentManagement.templatesAndLinksTranslator = function (contentDiv, targetLanguage, wikiText) {

    // Public members of class
    // Does translation of templates from templates mapper. Typically done before the
    // language translation happens.
    this.translateTemplatesOnWikiTextBeforeTranslation = function () {
        replaceParameterizedTemplates();
    };

    // Starts the asynchornous interwiki conversion. 
    this.startInterwikiConversion = function () {
        getLinksToTranslate();
        getTemplatesToTranslate();
        dispatchLinksToApiForTranslation();
    };

    // Private members
    var templatesToTranslate = null,
        linksToTranslate = null;

    // Looks for all templates declared in source contentDiv and adds them to
    // templatesToTranslate array.
    function getTemplatesToTranslate() {
        if (templatesToTranslate) {
            return;
        }
        templatesToTranslate = {};
        // Get only templates with no parameters
        var regex = /{{([^|\}\<]+)}}/g,
            match;
        while (match = regex.exec(wikiText)) {
            var $template = $.trim(match[1]);
            templatesToTranslate["Template:" + $template.toLowerCase()] = null;
        }
    }

    // Looks for all links declared in source contentDiv and adds them to
    // linksToTranslate array.
    function getLinksToTranslate(text) {
        if (linksToTranslate) {
            return;
        }
        linksToTranslate = {};

        var regex = /\[\[([^|\]\:]+)(\|([^|\]\:]+))?\]\]*/g,
            match;
        while (match = regex.exec(wikiText)) {
            var link = $.trim(match[1]);
            linksToTranslate[link.toLowerCase()] = null;
        }
    }

    // Utility function to get all properties of an object as an array
    function getObjectPropertiesToArray(object) {
        var ret = [];
        for (var prop in object) {
            ret.push(prop);
        }
        return ret;
    }

    // Splits the given array into array of arrays (array or pages) with each
    // page having max pageSize items.
    function splitArrayIntoPages(inputArray, pageSize) {
        var pagesArray = [],
            currentPageArray = [],
            positionIndex = 0;
        for (var i = 0, len = inputArray.length; i < len; i++) {
            currentPageArray[positionIndex++] = inputArray[i];
            if (positionIndex === pageSize) {
                pagesArray.push(currentPageArray);
                currentPageArray = [];
                positionIndex = 0;
            }
        }
        if (positionIndex > 0) {
            pagesArray.push(currentPageArray);
        }
        return pagesArray;
    }

    // Replaces the passed old link/template with new link/template in
    // templatesToTranslate or linksToTranslate collection
    function replaceLinkOrTemplate(oldValue, newValue) {
        oldValue = oldValue.toLowerCase();
        var isTemplate = /^Template:/.test(oldValue),
            mapObject = (isTemplate) ? templatesToTranslate : linksToTranslate;
        mapObject[oldValue] = newValue;
    }

    // Callback when a page of interwiki links are queried and returned.
    function getInterWikiLinksCallback(data, titles) {
        wbGlobalSettings.noWikiAPIcallback = wbGlobalSettings.noWikiAPIcallback + 1;
        if (!data || !data.query || !data.query.pages) {
            return; // no data to process
        }

        var pages = data.query.pages;

        for (var page in pages) {
            var langLinks = pages[page].langlinks;
            if (!langLinks) {
                continue;
            }

            var linkName = pages[page].title;

            for (var i in langLinks) {
                if (langLinks[i].lang === targetLanguage) {
                    var targetLinkName = decodeURIComponent(langLinks[i]["*"]);
                    replaceLinkOrTemplate(linkName, targetLinkName);
                    break;
                }
            }
        }

        // see if more data is there.
        if (data["query-continue"] && data["query-continue"].langlinks) {
            var llcontinue = data["query-continue"].langlinks.llcontinue;
            if (llcontinue) {
                wbGlobalSettings.noWikiAPIcall = wbGlobalSettings.noWikiAPIcall + 1;
                wbWikiSite.getInterWikiLinks(titles, "llcontinue=" + llcontinue, getInterWikiLinksCallback);
            }
        }

        replaceTemplateOrLinkInDomNode(contentDiv);
    }

    // Gets inner text of an element. Also normalizes <br> tags as new line chars.
    function getInnerText(elem) {
        var innerText = (elem.nodeType === textNodeType) ? elem.nodeValue : (elem.innerText || elem.textContent || "");
        innerText = innerText.replace(/<br\s*\/?>/gi, "\n");
        return innerText;
    }

    // For given text containing complete template (including curley braces), returns
    // the translated template with translated parameters.
    function getTranslatedTemplate(templateData) {
        var data = templateData,
            match = data.match(/{{\s*([^\|\}\<]+)/);
        if (!match) {
            return null;
        }

        var srcTemplateName = match[1],
            tgtTemplateName = null;
        if (templatesToTranslate && templatesToTranslate[srcTemplateName]) {
            tgtTemplateName = templatesToTranslate[srcTemplateName];
        }
        else if (templateMapperHashMap) {
            var templateMapper = templateMapperHashMap[srcTemplateName];
            if (templateMapper) {
                tgtTemplateName = templateMapper[srcTemplateName];
            }
        }

        if (tgtTemplateName) {
            data = data.replace(match[0], "{{" + tgtTemplateName);
            data = replaceTemplateParameters(srcTemplateName, data);
            return data;
        }
        return null;
    }

    // replaces templates & links in DOM elements displayed in hybrid mode or wiki mode.
    function replaceTemplateOrLinkInDomNode(elem) {
        if ((templateMapperHashMap || templatesToTranslate) && elem.className === "wbHybridTemplate") {
            var data = wbUtil.getDataAttribute(elem),
                translatedTemplateData = getTranslatedTemplate(data);
            if (translatedTemplateData) {
                wbUtil.setDataAttribute(elem, translatedTemplateData);
            }
        }
        else if ((templateMapperHashMap || templatesToTranslate) && elem.className === "wbWikiTemplate") {
            var data = elem.innerHTML,
                translatedTemplateData = getTranslatedTemplate(data);
            if (translatedTemplateData) {
                elem.innerHTML = translatedTemplateData;
            }
        }
        else if (linksToTranslate && elem.className === "wbWikiLinkTag") {
            var data = elem.innerHTML;
            if (data.length > 2 && data.charAt(0) === '[' && data.charAt(1) === '[') {
                var newLink = linksToTranslate[data.replace("[[", "").replace("|", "")];
                if (newLink) {
                    elem.innerHTML = "[[" + newLink + "|";
                }
            }
        }
        else if (linksToTranslate && (elem.className === "wbWikiLinkText" || elem.className === "wbHybridLinkText")) {
            var linkRootNode = elem.parentNode;
            if (linkRootNode.getAttribute("isProcessed") == 1) {
                return;
            }

            var srcWord = linkRootNode.getAttribute("_wbSrcWord").toLowerCase(),
            srcLink = wbUtil.getDataAttribute(linkRootNode).toLowerCase(),
            tgtWord = elem.innerHTML.toLowerCase(),
            tgtLink = linksToTranslate[srcLink];
            if (tgtLink) {
                linkRootNode.setAttribute("isProcessed", 1);
                if (tgtLink == tgtWord) {
                    tgtLink = "";
                }
                if (srcWord == tgtWord) {
                    elem.innerHTML = tgtLink;
                    tgtLink = "";
                }
                wbUtil.setDataAttribute(linkRootNode, tgtLink);
            }
            else if (wbGlobalSettings.noWikiAPIcallback == wbGlobalSettings.noWikiAPIcall) {
                var textNode = document.createTextNode(elem.innerText || elem.textContent);
                linkRootNode.parentNode.insertBefore(textNode, linkRootNode);
                linkRootNode.parentNode.removeChild(linkRootNode);
            }
        }


        if (elem.childNodes && elem.childNodes.length > 0) {
            $.each(elem.childNodes, function (i, node) {
                replaceTemplateOrLinkInDomNode(node);
            });
        }
    }

    // dispatches the list of links & templates to wikisite API in multiple calls
    // as needed. Callback for each call will be called on successful completion of API.
    function dispatchLinksToApiForTranslation() {
        var linksData = getObjectPropertiesToArray(linksToTranslate),
            templatesData = getObjectPropertiesToArray(templatesToTranslate),
            linkItems = linksData.concat(templatesData),
            pageSize = wbWikiSite.wikiMaxTitlesPerInterWikiLinksApi,
            pagesArray = splitArrayIntoPages(linkItems, pageSize);

        for (var pageIndex = 0, len = pagesArray.length; pageIndex < len; pageIndex++) {
            var titlesArray = pagesArray[pageIndex],
                titlesString = titlesArray.join("|");
            wbGlobalSettings.noWikiAPIcall = wbGlobalSettings.noWikiAPIcall + 1;
            wbWikiSite.getInterWikiLinks(titlesString, null, getInterWikiLinksCallback);
        }
    }

    var templateMapperHashMap = null;
    function ensureGetTemplateMapperHashMap() {
        if (templateMapperHashMap) {
            return; // Already found the needed set, no need to find again.
        }

        var xmlDoc,
            rootXmlText = wikiBhasha.configurations.templateMappers.templateMapConfig;
        if (!rootXmlText) {
            return;
        }

        // load the xml configuration which specifies the template map
        if (window.DOMParser) {
            xmlDoc = (new DOMParser()).parseFromString(rootXmlText, "text/xml");
        }
        else // Internet Explorer
        {
            xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
            xmlDoc.async = "false";
            xmlDoc.loadXML(rootXmlText);
        }


        var templateMapBetweenLangPairs = [],
            currentTemplateMapBetweenLangPair;
        // get the map configuration portion or the given source and target language.
        templateMapBetweenLangPairs = xmlDoc.getElementsByTagName("templateMapBetweenLangPair");
        for (var i = 0; i < templateMapBetweenLangPairs.length; i++) {
            var oneTemplateMapBetweenLangPair = templateMapBetweenLangPairs[i];
            if (oneTemplateMapBetweenLangPair.attributes.getNamedItem("tgtLang").nodeValue === targetLanguage.toLowerCase()) {
                currentTemplateMapBetweenLangPair = oneTemplateMapBetweenLangPair;
                break;
            }
        }

        if (currentTemplateMapBetweenLangPair) {
            // get the map configuration of all templates that are defined
            var mapperNodes = currentTemplateMapBetweenLangPair.getElementsByTagName("templateMap");
            // hash to store source template names as keys and the value of this is an object that specifies the map between the source and target language template pair
            templateMapperHashMap = {};
            for (i = 0, len = mapperNodes.length; i < len; i++) {
                var currentMapperNode = mapperNodes[i];
                if (currentMapperNode) {
                    // hash to store the map information of one source and target langauge template pair
                    var mapPerTemplate = {},
                        parameterNodes = [],
                    // get the corresponding source and target language template names and store them in the hash
                        srcTemplateName = currentMapperNode.attributes.getNamedItem("srcTemplateName").nodeValue;
                    mapPerTemplate[srcTemplateName] = currentMapperNode.attributes.getNamedItem("tgtTemplateName").nodeValue;
                    // get the parameter map information one at a time and store them also in the above hash.
                    parameterNodes = currentMapperNode.getElementsByTagName("param");
                    for (var iter = 0; iter < parameterNodes.length; iter++) {
                        var srcTemplateParamName = parameterNodes[iter].attributes.getNamedItem("srcTemplateParamName").nodeValue,
                            tgtTemplateParamName = parameterNodes[iter].attributes.getNamedItem("tgtTemplateParamName").nodeValue;
                        mapPerTemplate[srcTemplateParamName] = tgtTemplateParamName;
                    }
                    templateMapperHashMap[srcTemplateName] = mapPerTemplate;
                }
            }
        }
    }

    function replaceParameterizedTemplates() {
        ensureGetTemplateMapperHashMap();
        replaceTemplateOrLinkInDomNode(contentDiv);
    }

    function replaceTemplateParameters(srcTemplateName, templateText) {
        if (!templateMapperHashMap) {
            return templateText;
        }
        var templateMapper = templateMapperHashMap[srcTemplateName];

        if (!templateMapper) {
            return templateText;
        }

        var regex = /\|\s*(.*?)\s*=/g,
            match;
        while (match = regex.exec(templateText)) {
            var param = match[1],
                paramText = match[0],
                paramMap = templateMapper[param];
            if (paramMap) {
                templateText = templateText.replace(paramText, "| " + paramMap + " =");
            }
        }
        return templateText;
    }

    function stringFormat(text) {
        var args = arguments;
        return text.replace(/\{(\d+)\}/g, function (a, b) {
            return args[parseInt(b) + 1];
        });
    }

};