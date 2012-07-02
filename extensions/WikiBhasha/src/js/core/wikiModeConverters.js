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


if (typeof (wikiBhasha.contentManagement) === "undefined") {
    wikiBhasha.contentManagement = {};
}

// This class converts between wikimarkup and displayed Hybrid and Sytax Highlighted modes.
wikiBhasha.contentManagement.wikiModeConverter = new function () {

    // Public Members start

    // Shows given contentNode in hybrid mode. If passed wikiContent is actual wiki markup,
    // then it is parsed and displayed in hybrid mode. Else, if contentNode is already initialized, then
    // the mode is switched to hybrid mode.
    this.showHybridMode = function (contentNode, wikiContent) {
        if (contentNode.currentMode === "hybrid") {
            return; // already in hybrid mode
        }

        if (typeof (wikiContent) === "string") {
            var domRoot = fromWikiTextToHybridModeHtml(wikiContent);
            contentNode.innerHTML = "";
            contentNode.appendChild(domRoot);
        }
        else if (contentNode) {
            convertWikiToHybridElem(contentNode);
        }
        else {
            wikiBhasha.debugHelper.assertExpr(false);
        }
        contentNode.currentMode = "hybrid";
    };

    // Shows given contentNode in wiki-highlight mode. If passed wikiContent is actual wiki markup,
    // then it is parsed and displayed in wiki-highlight mode. Else, if contentNode is already initialized, then
    // the mode is switched to wiki-highlight mode.
    this.showWikiHighlightMode = function (contentNode, wikiContent) {
        if (contentNode.currentMode === "highlight") {
            return; //already in highlight mode
        }

        if (typeof (wikiContent) === "string") {
            var domRoot = fromWikiTextToHighlightModeHtml(wikiContent);
            contentNode.innerHTML = "";
            contentNode.appendChild(domRoot);
        }
        else if (contentNode) {
            convertHybridToWikiElem(contentNode);
        }
        else {
            wikiBhasha.debugHelper.assertExpr(false);
        }
        contentNode.currentMode = "highlight";
    };

    // Gets the wiki markup for currently displayed DOM tree. The DOM tree could be either in hybrid mode
    // or in wiki-highlight mode. Eitherway, it decodes the DOM tree and returns the wiki markup.
    this.getWikiFromHtmlDomElement = function (contentNode) {
        return fromHtmlToWikiText(contentNode);
    };
    // public members end

    var textNodeType = 3;

    // Takes the wiki markup text and returns the html DOM tree with wiki-highlight mode
    var fromWikiTextToHighlightModeHtml = function (wikiText) {
        var wikiParser = new wikiBhasha.contentManagement.wikiParser(wikiText),
            xmlDoc = wikiParser.parse(),
            domRoot = wikiBhasha.contentManagement.wikiConverter.instance.parse(xmlDoc);
        return domRoot;
    };

    // Takes the wiki markup text and returns the html DOM tree with hybrid mode
    var fromWikiTextToHybridModeHtml = function (wikiText) {
        var wikiParser = new wikiBhasha.contentManagement.wikiParser(wikiText),
            xmlDoc = wikiParser.parse(),
            domRoot = wikiBhasha.contentManagement.hybridConverter.instance.parse(xmlDoc);
        return domRoot;
    };

    // Gets the wiki markup for currently displayed DOM tree. The DOM tree could be either in hybrid mode
    // or in wiki-highlight mode. Eitherway, it decodes the DOM tree and returns the wiki markup.
    var fromHtmlToWikiText = function (contentNode) {
        return $.trim(decodeElem(contentNode));
    };

    // Gets inner text of an element. Also normalizes <br> tags as new line chars.
    function getInnerText(elem) {
        var innerText = (elem.nodeType === textNodeType) ? elem.nodeValue : (elem.innerText || elem.textContent || "");
        innerText = innerText.replace(/<br\s*\/?>/gi, "\n");
        return innerText;
    }

    // switches the element that already has hybrid mode content into wiki-highlight mode.
    function convertHybridToWikiElem(elem) {
        var data = wbUtil.getDataAttribute(elem),
        newClassName = null,
        openOrCloseTag = null,
        processChildren = true,
        parentElem = elem.parentNode;
        if (data) {
            data = data.replace(/<br\s*\/?>/gi, "\n");
        }

        if (elem.className && elem.className.indexOf("wbHybrid") >= 0) {
            newClassName = elem.className.replace("wbHybrid", "wbWiki");
        }

        switch (elem.className) {
            case "wbHybridTemplate":
            case "wbHybridTag":
            case "wbHybridOpenOrCloseTag":
                var newElem = wbWikiConverter.getNonTranslatableNode(newClassName, data);
                parentElem.replaceChild(newElem, elem);
                processChildren = false;
                break;

            case "wbHybridLinkRoot":
                var innerText = getInnerText(elem),
                    text = (data) ? stringFormat("[[{0}|{1}]]", data, innerText) : stringFormat("[[{0}]]", innerText),
                    newElem = wbWikiConverter.getLinkNode(text);
                parentElem.replaceChild(newElem, elem);
                processChildren = false;
                break;

            default:
                if (newClassName) {
                    openOrCloseTag = wbWikiConverter.getTagForClassName(newClassName);
                }
                break;
        }

        if (newClassName) {
            elem.className = newClassName;
            elem.setAttribute("className", newClassName);
        }

        if (openOrCloseTag) {
            var openTag = wbWikiConverter.getOpenOrCloseTagNode(openOrCloseTag),
                closeTag = openTag.cloneNode(true);
            elem.insertBefore(openTag, elem.firstChild);
            elem.appendChild(closeTag);
        }

        if (!processChildren) {
            return;
        }

        if (elem.childNodes && elem.childNodes.length > 0) {
            $.each(elem.childNodes, function (i, node) {
                convertHybridToWikiElem(node);
            });
        }

    }

    // switches the element that already has wiki-highlight mode content into hybrid mode
    function convertWikiToHybridElem(elem) {
        var newClassName = null,
            processChildren = true,
            parentElem = elem.parentNode;
        if (elem.className && elem.className.indexOf("wbWiki") >= 0) {
            newClassName = elem.className.replace("wbWiki", "wbHybrid");
        }

        switch (elem.className) {

            case "wbWikiOpenOrCloseTag":
                var data = getInnerText(elem),
                    isHtmlTag = data.charAt(0) === "<";
                if (!isHtmlTag) {
                    parentElem.replaceChild(document.createTextNode(""), elem);
                    processChildren = false;
                    break;
                }

            case "wbWikiTemplate":
            case "wbWikiTag":
                var data = getInnerText(elem),
                    newElem = wbHybridConverter.getNonTranslatableNode(newClassName, data);
                parentElem.replaceChild(newElem, elem);
                processChildren = false;
                break;

            case "wbWikiLinkRoot":
                var text = getInnerText(elem),
                    newElem = wbHybridConverter.getLinkNode(text);
                parentElem.replaceChild(newElem, elem);
                processChildren = false;
                break;

            case "wbWikiLinkTag":
                parentElem.replaceChild(document.createTextNode(""), elem);
                processChildren = false;
                break;

            /* For other tags: No specific changes to be made. Class name change below and removal of open/close tags takes care of it */ 
        }

        if (newClassName) {
            elem.className = newClassName;
            elem.setAttribute("className", newClassName);
        }

        if (!processChildren) {
            return;
        }

        if (elem.childNodes && elem.childNodes.length > 0) {
            $.each(elem.childNodes, function (i, node) {
                convertWikiToHybridElem(node);
            });
        }

    }

    // traverses through the html DOM tree and extracts the wiki markup. Returns extracted wiki markup.
    // the passed element could be in either wiki-highlight mode or hybrid mode.
    function decodeElem(elem) {
        var output = "",
            data = wbUtil.getDataAttribute(elem),
            processChildren = true,
            openOrCloseTag = null;
        if (data) {
            data = data.replace(/<br\s*\/?>/gi, "\n");
        }

        switch (elem.className) {
            case "wbHybridTemplate":
            case "wbHybridTag":
            case "wbHybridOpenOrCloseTag":
                output += data;
                processChildren = false;
                break;
            case "wbHybridLinkRoot":
                var text = getInnerText(elem);
                output += (data) ? stringFormat("[[{0}|{1}]]", data, text) : stringFormat("[[{0}]]", text);
                processChildren = false;
                break;

            default:
                if (elem.nodeType === textNodeType) {
                    var text = getInnerText(elem);
                    output += text;
                }
                else if (elem.className) {
                    openOrCloseTag = wbHybridConverter.getTagForClassName(elem.className);
                }
                else if (elem.nodeName.toLowerCase() === "br" || elem.nodeName.toLowerCase() === "p" || elem.nodeName.toLowerCase() === "div") {
                    output += "\n";
                }
        }


        if (!processChildren) {
            return output;
        }

        if (openOrCloseTag) {
            output += openOrCloseTag;
        }
        if (elem.childNodes && elem.childNodes.length > 0) {
            $.each(elem.childNodes, function (i, node) {
                output += decodeElem(node);
            });
        }
        if (openOrCloseTag) {
            output += openOrCloseTag;
        }

        return output;
    }

    function stringFormat(text) {
        var args = arguments;
        return text.replace(/\{(\d+)\}/g, function (a, b) {
            return args[parseInt(b) + 1];
        });
    }

    function trim(text) {
        return (text || "").replace(/^\s+|\s+$/g, "");
    }

};


// Base classes for converters that take xml version of wikimarkup and convert to 
// displayable DOM trees.
wikiBhasha.contentManagement.baseWikiConverter = function () {
    this.nonTranslatableTags = ["{{", "{|", "nowiki", "<!--", "ref", "math", "gallery", "code", "source"];
    this.translatableTags = {};
    this.templateClass = "wbWikiTemplate";
    this.wikiTagClass = "wbWikiTag";
    this.templateMarker = (wbGlobalSettings.imgBaseUrl ? wbGlobalSettings.imgBaseUrl : baseUrl) + "images/templateAsImage.jpg";
    this.wikiTagMarker = (wbGlobalSettings.imgBaseUrl ? wbGlobalSettings.imgBaseUrl : baseUrl) + "images/wikiTagAsImage.jpg";

    this.parse = function (xmlDoc) {
        var xmlRoot = xmlDoc.documentElement,
            domRoot = this.convertNode(xmlRoot);
        return domRoot;
    };

    this.isNonTranslatableTag = function (tagName) {
        if (!nonTranslatableTagMap) {
            nonTranslatableTagMap = {};
            for (var i = 0; i < this.nonTranslatableTags.length; i++) {
                nonTranslatableTagMap[this.nonTranslatableTags[i]] = true;
            }
        }
        return nonTranslatableTagMap[tagName];
    };

    this.createElem = function (elemName, className, innerTextContent, isTranslatable, title) {
        var elem = document.createElement(elemName);
        if (className) {
            elem.setAttribute("className", className);
            elem.className = className;
        }
        if (isTranslatable === false) {
            elem.setAttribute("translate", "skip");
        }
        if (title) {
            elem.setAttribute("title", title);
        }
        if (innerTextContent) {
            elem.appendChild(document.createTextNode(innerTextContent));
        }
        return elem;
    };

    this.createSpan = function (className, innerTextContent, isTranslatable, title) {
        return this.createElem("span", className, innerTextContent, isTranslatable, title);
    };

    this.getNonTranslatableNode = function (className, content, title) { };
    this.getLinkNode = function (linkText) { };
    this.getOpenOrCloseTagNode = function (content) { };

    this.convertNode = function (xmlNode) {
        var domNode,
            processChildren = true;

        if (xmlNode.nodeName === "wikiSection") {
            domNode = document.createElement("p");
        }
        else if (xmlNode.nodeName === "wikiLineBreak") {
            domNode = document.createElement("br");
            processChildren = false;
        }
        else if (xmlNode.nodeName === "wikiBlock" || xmlNode.nodeName === "htmlBlock") {
            var wikiTagName = xmlNode.attributes.getNamedItem("name").nodeValue;
            if (this.isNonTranslatableTag(wikiTagName)) {
                var isTemplateTypeTag = (wikiTagName === "{{" || wikiTagName === "{|"),
                    className = (isTemplateTypeTag) ? this.templateClass : this.wikiTagClass,
                    title = (isTemplateTypeTag) ? "Template Tag" : "Wiki Tag",
                    xmlText = xmlNode.text || xmlNode.textContent;
                domNode = this.getNonTranslatableNode(className, xmlText, title);
                processChildren = false;
            }
            else if (wikiTagName === "[[") {
                var linkText = xmlNode.text || xmlNode.textContent;
                domNode = this.getLinkNode(linkText);
                processChildren = false;
            }
            else {
                var wikiTagName = xmlNode.attributes.getNamedItem("name").nodeValue,
                    classMap = this.translatableTags[wikiTagName],
                    className = (classMap) ? classMap.className : null;
                domNode = this.createSpan(className);
            }
        }
        else if (xmlNode.nodeName === "openTag" || xmlNode.nodeName === "closeTag") {
            var content = xmlNode.text || xmlNode.textContent;
            domNode = this.getOpenOrCloseTagNode(content);
            processChildren = false;
        }
        else if (xmlNode.nodeType === 3) { //text node
            domNode = document.createTextNode(xmlNode.nodeValue);
            processChildren = false;
        }
        else if (xmlNode.nodeName === "wikiRoot") {
            domNode = document.createElement("div");
        }
        else {
            wikiBhasha.debugHelper.assertExpr(false, "Invalid xml node found");
        }

        if (!domNode || processChildren === false) {
            return domNode;
        }

        for (var i = 0; i < xmlNode.childNodes.length; i++) {
            var childXmlNode = xmlNode.childNodes[i],
                childDomNode = this.convertNode(childXmlNode);
            if (childDomNode) {
                domNode.appendChild(childDomNode);
            }
        }
        return domNode;
    };

    this.getTagForClassName = function (className) {
        if (!classToTagMap) {
            classToTagMap = {};
            for (var tag in this.translatableTags) {
                classToTagMap[this.translatableTags[tag].className] = tag;
            }
        }

        return classToTagMap[className];
    };

    this.escapeHtml = function (text) {
        return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace("/>/g", "&gt;");
    };

    var classToTagMap = null,
        nonTranslatableTagMap = null;

};

// Subclass of base wiki converter that knows how to convert to wiki-highlight mode
wikiBhasha.contentManagement.wikiConverter = function () {
    this.translatableTags = {
        "===": { className: "wbWikiHeader3" },
        "==": { className: "wbWikiHeader2" },
        "'''": { className: "wbWikiBold" },
        "''": { className: "wbWikiItalic" },
        "====": { className: "wbWikiHeader4" }
    };

    this.templateClass = "wbWikiTemplate";
    this.wikiTagClass = "wbWikiTag";
    this.openCloseTagClass = "wbWikiOpenOrCloseTag";

    this.getNonTranslatableNode = function (className, content) {
        var elem = this.createSpan(className, null, false);
        // We need to set the inner text of element without losing original formatting.
        // In IE innerText does the job neatly. In Firefox, using textContent removes the
        // newlines though. Need to figure out why it removes newlines and a better way to do it
        // for FF instead of using innerHTML. The problem using innerHTML is that sometimes formatting
        // using multiple spaces could get reduced to single space, such as inside <source> tags.
        if (typeof elem.innerText === "string") {
            elem.innerText = content;
        }
        else {
            content = this.escapeHtml(content);
            elem.innerHTML = content.replace(/\n/g, "<br/>");
        }
        return elem;

    };

    this.getOpenOrCloseTagNode = function (content) {
        var elem = this.createSpan(this.openCloseTagClass, content, false);
        elem.setAttribute("contentEditable", "false");
        return elem;
    };

    this.getLinkNode = function (linkText) {
        var parts = linkText.replace(/^\[\[/, "").replace(/]]$/, "").split("|");
        if (linkText.indexOf(":") >= 0 || parts.length > 2) {
            return this.getNonTranslatableNode(this.wikiTagClass, linkText, "Wiki Tag");
        }

        var link = (parts.length === 2) ? parts[0] : null,
            text = (parts.length === 2) ? parts[1] : parts[0];

        var linkTextElem = document.createElement("a");
        linkTextElem.className = "wbWikiLinkText";
        linkTextElem.setAttribute("className", "wbWikiLinkText");
        linkTextElem.setAttribute("href", "javascript:void()");
        linkTextElem.setAttribute("onclick", "return false;");
        linkTextElem.appendChild(document.createTextNode(text));

        var linkText = (link) ? link + "|" : "",
            domNode = this.createSpan("wbWikiLinkRoot"),
            openTag = this.createSpan("wbWikiLinkTag", "[[" + linkText, false),
            closeTag = this.createSpan("wbWikiLinkTag", "]]", false);
        openTag.setAttribute("contentEditable", "false");
        domNode.appendChild(openTag);
        domNode.appendChild(linkTextElem);
        closeTag.setAttribute("contentEditable", "false");
        domNode.appendChild(closeTag);
        return domNode;
    };
};

// Subclass of base wiki converter that knows how to convert to hybrid mode
wikiBhasha.contentManagement.hybridConverter = function () {
    this.translatableTags = {
        "===": { className: "wbHybridHeader3" },
        "==": { className: "wbHybridHeader2" },
        "'''": { className: "wbHybridBold" },
        "''": { className: "wbHybridItalic" },
        "====": { className: "wbHybridHeader4" }
    };

    this.templateClass = "wbHybridTemplate";
    this.wikiTagClass = "wbHybridTag";
    this.openCloseTagClass = "wbHybridOpenOrCloseTag";

    this.getNonTranslatableNode = function (className, content, title) {
        var imageSource = (className === this.templateClass) ? this.templateMarker : this.wikiTagMarker;
        title = title || (className === this.templateClass) ? "Template Tag" : "Wiki Tag";
        var elem = this.createElem("img", className, false /*isTranslatable*/, title);
        $(elem).attr("src", imageSource);
        wbUtil.setDataAttribute(elem, content.replace(/\n/g, "<br/>"));
        return elem;
    };

    this.getOpenOrCloseTagNode = function (content) {
        var isHtmlNode = content.charAt(0) === "<";
        return (isHtmlNode) ? this.getNonTranslatableNode(this.openCloseTagClass, content, content) : null;
    };

    this.getLinkNode = function (linkText) {
        var parts = linkText.replace(/^\[\[/, "").replace(/]]$/, "").split("|"),
            link = (parts.length === 2) ? parts[0] : null,
            text = (parts.length === 2) ? parts[1] : parts[0],
            linkTextElem = document.createElement("a"),
            domNode = this.createSpan("wbHybridLinkRoot");
        if (linkText.indexOf(":") >= 0 || parts.length > 2) {
            return this.getNonTranslatableNode(this.wikiTagClass, linkText, "Wiki Tag");
        }

        linkTextElem.className = "wbHybridLinkText";
        linkTextElem.setAttribute("className", "wbHybridLinkText");
        linkTextElem.setAttribute("href", "javascript:void()");
        linkTextElem.setAttribute("onclick", "return false;");
        linkTextElem.appendChild(document.createTextNode(text));

        wbUtil.setDataAttribute(domNode, link || text);
        domNode.setAttribute("_wbSrcWord", text);
        domNode.setAttribute("isProcessed", 0);
        domNode.appendChild(linkTextElem);
        return domNode;
    };

};

// Shortcut global members for easy access from other places
wikiBhasha.contentManagement.wikiConverter.prototype = new wikiBhasha.contentManagement.baseWikiConverter();
wikiBhasha.contentManagement.wikiConverter.instance = new wikiBhasha.contentManagement.wikiConverter();
wbWikiConverter = wikiBhasha.contentManagement.wikiConverter.instance;

wikiBhasha.contentManagement.hybridConverter.prototype = new wikiBhasha.contentManagement.baseWikiConverter();
wikiBhasha.contentManagement.hybridConverter.instance = new wikiBhasha.contentManagement.hybridConverter();
wbHybridConverter = wikiBhasha.contentManagement.hybridConverter.instance;

wbWikiModeConverter = wikiBhasha.contentManagement.wikiModeConverter;
