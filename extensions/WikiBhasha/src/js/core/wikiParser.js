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

/// Trie Implementation
// Trie stores a number of keys as a hash lookup tree for fast lookups.
// Trie datastructure info at http://en.wikipedia.org/wiki/Trie
// trie.addItem: Add data with keys, where keys are searchable.
// trie.getItem: Checks if any keys are present at the asked location in given text. If any key
// is present, then the key and data are returned.
wikiBhasha.trie = function () {
    var root = {};
    this.addItem = function (key, data) {
        var currentNode = root;
        for (var i = 0; i < key.length; i++) {
            var c = key.charCodeAt(i);
            var item = currentNode[c];
            if (!item) {
                item = {};
                currentNode[c] = item;
            }
            currentNode = item;
        }
        currentNode.data = data;
    };
    this.getItem = function (input, pos) {
        var currentNode = root;
        for (var i = pos; i < input.length; i++) {
            var c = input.charCodeAt(i),
                item = currentNode[c];
            if (!item) {
                break;
            }
            currentNode = item;
        }
        if (currentNode.data) {
            var key = input.substring(pos, i);
            return { key: key, data: currentNode.data };
        }
        return null;
    };
    this.unitTest = function () {
        this.addItem("{{", "templ");
        this.addItem("[[", "link");
        this.addItem("{|", "new template");
        this.addItem("[", "single link");
        this.addItem("[[[", "triple link");
        wikiBhasha.debugHelper.assertExpr(this.getItem("{", 0) === null);
        wikiBhasha.debugHelper.assertExpr(this.getItem("{||", 0).data === "new template");
        wikiBhasha.debugHelper.assertExpr(this.getItem("", 0) === null);
        wikiBhasha.debugHelper.assertExpr(this.getItem("[[[[[", 0).data === "triple link");
        wikiBhasha.debugHelper.assertExpr(this.getItem("a[[a", 1).data === "double link");
    };
};

/// wikiParser takes wiki markup text as input and outputs the parsed content as xml.
// The wiki content is not changed and the wiki content gets wrapped in xml based markup.
// The XML contains below wrapped up markup tags:
// - wikiBlock: This indicates a wiki markup block. The name attributes tells the name of wikitag wrapped.
// - htmlBlock: This indicates a html tag or wiki tag in html tag format. For example, <ref> tag. The name
//              attributes indicates the name of tag wrapped.
// - wikiSection: Indicates a block of text. This can be used by interpreters to place extra space around blocks of text.
// - openTag: Indicates the open tag inside wikiBlock of htmlBlock. The text contents inside the tag indicates actual tag.
// - closeTag: Indicates the close tag inside wikiBlock of htmlBlock. The text contents inside the tag indicates actual tag.

wikiBhasha.contentManagement.wikiParser = function(wikiText) {
    // Private data variables.
    var xmlDoc = null,
        input = wikiText.replace(/\r/g, ''),
        leftArrowCharCode = "<".charCodeAt(0),
        inputLen = input.length;

    // public function that parses wikiText.
    this.parse = function() {
        if (xmlDoc) {
            return xmlDoc; // Already parsed, so return that info.
        }

        var pos = 0;
        xmlDoc = createXmlDocument();
        var currentNode = xmlDoc.documentElement;
        pos = parseNextItem(pos, currentNode);
        wikiBhasha.debugHelper.assertExpr(pos === inputLen);
        if (wikiBhasha.debugMode) {
            var xmlText = (xmlDoc.text) ? xmlDoc.text : xmlDoc.documentElement.textContent;
            wikiBhasha.debugHelper.assertExpr(xmlText.replace(/\s/g, "") === wikiText.replace(/\s/g, ""));
        }
        return xmlDoc;
    };

    // wikiBlocks contains the tags being handled. The key element is the actual wiki block text.
    // For each block, closeTag indicates the closing tag. parseChildren indicates if child elements
    // inside that tag needs to be parsed. For WikiBhasha needs, some elements such as Templates need not
    // be parsed and indicate false. For other needs, parseChildren field could be changed to true.
    // illegalChildTags represent list of tags that should stop parsing and treat as implicit end.
    // illegalChildTags are used to recover from wiki markup errors.
    // commonIllegalChildTags: These are common child tags illegal in most wiki blocks. 
    // FUTURE: Consider making illegalChildTags as Trie for faster lookup to improve perf.
    var commonIllegalChildTags = ["\n", "\r\n", "{{", "{|"],
        wikiBlocks = {
            "{{": { closeTag: "}}", parseChildren: false },
            "{|": { closeTag: "|}", parseChildren: false },
            "[[": { closeTag: "]]", parseChildren: false },
            "====": { closeTag: "====", parseChildren: true, illegalChildTags: commonIllegalChildTags },
            "===": { closeTag: "===", parseChildren: true, illegalChildTags: commonIllegalChildTags },
            "==": { closeTag: "==", parseChildren: true, illegalChildTags: commonIllegalChildTags },
            "'''": { closeTag: "'''", parseChildren: true, illegalChildTags: commonIllegalChildTags },
            "''": { closeTag: "''", parseChildren: true, illegalChildTags: commonIllegalChildTags },
            "<!--": { closeTag: "-->", parseChildren: false }
        },

    // sectionHtmlTag indicates the html tag to be used as marking blocks of section of text.
        sectionHtmlTag = "p",

    // donotParseChildrenWikiHtmlTags: html wiki tags that should not be parsed in this app.
        donotParseChildrenWikiHtmlTags = { source: true, code: true, nowiki: true, ref: true, gallery: true, math: true },
        standaloneHtmlTags = { br: true, img: true, hr: true },

    // internal enumeration for indicating type of block found during scaning phase.
        blockTypes = { wikiBlock: "wiki tag block",
            htmlBlock: "html block",
            lineBreak: "line break",
            closeTag: "close tag",
            invalidWikiError: "malformed wiki",
            illegalChildTag: "illegal child tag"
        },

    // create instance of Trie and add items from wikiBlocks for quick lookup.
        wikiBlocksTree = new wikiBhasha.trie();
    for (var block in wikiBlocks) {
        wikiBlocksTree.addItem(block, wikiBlocks[block]);
    }

    // checks if a match exists at given position within input wikimarkup string.
    function isMatch(pos, match) {
        var matchLen = match.length;
        if (pos + matchLen > inputLen) {
            return false;
        }
        for (var i = 0; i < matchLen; i++) {
            if (input.charCodeAt(pos + i) !== match.charCodeAt(i)) {
                return false;
            }
        }
        return true;
    }

    function isMatchInArray(pos, matches) {
        if (!matches) {
            return false;
        }
        for (var i = 0; i < matches.length; i++) {
            if (isMatch(pos, matches[i])) {
                return true;
            }
        }
        return false;
    }

    // scans lineraly for a given match from start position and returns start position of that match
    // stops scan if any of tags present in illegalMiddleTags in encountered
    // returns: position of found match. If no match found, returns -1.
    function getMatchPosition(pos, match, illegalMiddleTags) {
        for (var i = pos; i < inputLen; i++) {
            if (isMatchInArray(i, illegalMiddleTags)) {
                break;
            }
            if (isMatch(i, match)) {
                return i;
            }
        }
        wikiBhasha.debugHelper.assertExpr(false, "required match not found");
        return -1;
    }

    // scans word characters and returns the position where word characters end. At least one
    // word character is expected at start location.
    // returns: Returns position of word end
    function getWordEndPos(pos) {
        for (var i = pos; i < inputLen; i++) {
            var c = input.charAt(i);
            var isWordChar = (c >= 'a' && c <= 'z') || (c >= 'A' && c <= 'Z') || (c >= '0' && c <= '9') || c === '_';
            if (!isWordChar) {
                wikiBhasha.debugHelper.assertExpr(i > pos);
                break;
            }
        }
        return (i > pos) ? i : -1;
    }

    // Scans linearly from requested start position and returns first match for any wiki or html block.
    // if closeTag is passed, the scan stops at close tag and position of close tag is returned.
    // returns: The return object contains below fields:
    // pos: the position where the match is found.
    // type: the type of match, one of blockTypes enum values.
    // blockName: the actual block name such as "===" or html tag value.
    function getNextWikiBlockMatch(pos, closeTag, illegalChildTags) {
        for (var i = pos; i < inputLen; i++) {
            if (closeTag && isMatch(i, closeTag)) {
                return { pos: i, type: blockTypes.closeTag };
            }

            if (isMatchInArray(i, illegalChildTags)) {
                return { pos: i, type: blockTypes.illegalChildTag };
            }

            if (isMatch(i, "\n")) {
                return { blockName: "\n", pos: i, type: blockTypes.lineBreak };
            }

            var wikiBlockItem = wikiBlocksTree.getItem(input, i);
            if (wikiBlockItem) {
                return { blockName: wikiBlockItem.key, pos: i, type: blockTypes.wikiBlock };
            }

            if (input.charCodeAt(i) === leftArrowCharCode) {
                var endPos = getWordEndPos(i + 1);
                if (endPos === -1) {
                    // Possibly invalid wiki markup scenario. Seems like start of html tag but does not contain
                    // english word chars. We'll treat it as plain text to go on.
                    continue;
                }
                var htmlTag = input.substring(i + 1, endPos);
                return { blockName: htmlTag, pos: i, type: blockTypes.htmlBlock };
            }
        }

        return null;
    }

    // scans a wikiBlock from given position and adds the found children
    // blocks to the currentNode parameter. Param descriptions:
    // pos: Pos to start scan
    // blockName: wiki block name of current element
    // currentNode: xml Node to which the children should be added to.
    // returns: end position of the parsed wiki block
    function parseWikiBlock(pos, blockName, currentNode) {
        var closeTag = wikiBlocks[blockName].closeTag,
            illegalChildTags = wikiBlocks[blockName].illegalChildTags,
            parseChildren = wikiBlocks[blockName].parseChildren,
            endPos;
        wikiBhasha.debugHelper.assertExpr(isMatch(pos, blockName));
        currentNode = addWikiBlockNode(currentNode, "wikiBlock", blockName);
        addOpenTagNode(currentNode, blockName);

        if (parseChildren) {
            endPos = parseNextItem(pos + blockName.length, currentNode, closeTag, illegalChildTags);
        }
        else {
            var returnVal = getNoParseBlockEnd(pos, blockName, closeTag, illegalChildTags);
            endPos = returnVal.pos;

            if (returnVal.result === "fail") {
                wikiBhasha.debugHelper.assertExpr(false, "No end position found for block: " + blockName);
                // Invalid wiki markup scenario. Close tag for current wiki tag is missing.
                // Treat till next wikiBlock as text and move on.
                var matchInfo = getNextWikiBlockMatch(pos + blockName.length);
                endPos = (matchInfo) ? matchInfo.pos : inputLen;
                addTextNode(currentNode, input.substring(pos + blockName.length, endPos));
            }
            else if (returnVal.result === "illegalChildTag") {
                wikiBhasha.debugHelper.assertExpr(false, "an illegal child tag is found inside block : " + blockName + " at pos: " + returnVal.pos);
                // Invalid wiki markup scenario. Illegal child element is found inside this block.
                // Assume author has missed to close the current tag before starting the next element and close it for author.
                addTextNode(currentNode, input.substring(pos + blockName.length, endPos));
            }
            else {
                wikiBhasha.debugHelper.assertExpr(returnVal.result === "success");
                wikiBhasha.debugHelper.assertExpr(isMatch(endPos - closeTag.length, closeTag));
                addTextNode(currentNode, input.substring(pos + blockName.length, endPos - closeTag.length));
            }
        }
        addCloseTagNode(currentNode, closeTag);

        return endPos;
    }

    // Gets position of end of self closing html tag.
    // If the tag is not self closing, then -1 is returned.
    function getEndOfSelfClosingTag(pos, blockName) {
        wikiBhasha.debugHelper.assertExpr(input.charCodeAt(pos) == leftArrowCharCode);
        var isAutoSelfClosingTag = standaloneHtmlTags[blockName];
        for (var i = pos + 1; i < inputLen; i++) {
            if (isMatch(i, "/>")) {
                return i + 2;
            }
            if (isMatch(i, ">")) {
                return (isAutoSelfClosingTag) ? (i + 1) : -1;
            }
        }
        return -1;
    }

    // scans a html style wikiblock from given position and adds the found children
    // blocks to the currentNode parameter. Param descriptions:
    // pos: Pos to start scan
    // blockName: html block name of current element
    // currentNode: xml Node to which the children should be added to.
    // returns: end position of the parsed wiki block
    function parseHtmlBlock(pos, blockName, currentNode) {
        var closeTag = "</" + blockName + ">",
            openTag = "<" + blockName,
            isSectionTag = blockName === sectionHtmlTag,
            blockClassName = (isSectionTag) ? "wikiSection" : "htmlBlock";
        currentNode = addWikiBlockNode(currentNode, blockClassName, blockName);

        // First check short circuiting cases.
        // Case 1: Is it self closing tag?
        var selfClosingPos = getEndOfSelfClosingTag(pos, blockName);
        if (selfClosingPos > pos) {
            var text = input.substring(pos, selfClosingPos);
            addOpenTagNode(currentNode, text);
            return selfClosingPos;
        }

        // get open tag's end position 
        var openTagEndPos = getMatchPosition(pos + openTag.length, ">", commonIllegalChildTags);
        if (openTagEndPos === -1) {
            wikiBhasha.debugHelper.assertExpr(false, "open tag started, but not closed");
            // Invalid wiki markup scenario. Assume that wiki user intended to close the tag
            // right after opentag start, but forgot.
            openTagEndPos = pos + openTag.length;
        }

        // Case 2: Is this html block properly closed?
        var blockEndPosResult = getNoParseBlockEnd(pos, openTag, closeTag), endPos;
        if (blockEndPosResult.result === "fail") {
            wikiBhasha.debugHelper.assertExpr(false, "close tag not found for html block: " + blockName);
            // invalid wikimarkup case where close tag for given html open tag is not found
            // assume that this is not a valid html tag and hence just treat this content as text
            var text = input.substring(pos, openTagEndPos);
            addTextNode(currentNode, text);
            return openTagEndPos;
        }

        if (!isSectionTag) {
            addOpenTagNode(currentNode, input.substring(pos, openTagEndPos + 1));
        }

        if (donotParseChildrenWikiHtmlTags[blockName]) {
            wikiBhasha.debugHelper.assertExpr(blockEndPosResult.result === "success");
            endPos = blockEndPosResult.pos;
            var text = input.substring(openTagEndPos + 1, endPos - closeTag.length);
            addTextNode(currentNode, text);
        }
        else {
            endPos = parseNextItem(openTagEndPos + 1, currentNode, closeTag);
            wikiBhasha.debugHelper.assertExpr(isMatch(endPos - closeTag.length, closeTag));
        }
        if (!isSectionTag) {
            addCloseTagNode(currentNode, closeTag);
        }
        return endPos;
    }

    function getNoParseBlockEnd(pos, openTag, closeTag, illegalChildTags) {
        wikiBhasha.debugHelper.assertExpr(isMatch(pos, openTag));
        var depth = 1;
        for (var i = pos + openTag.length; i < inputLen; i++) {
            if (isMatchInArray(i, illegalChildTags)) {
                return { result: "illegalChildTag", pos: i };
            }
            if (isMatch(i, closeTag)) {
                depth--;
            }
            else if (isMatch(i, openTag)) {
                depth++;
            }
            if (depth === 0) {
                return { result: "success", pos: i + closeTag.length };
            }
        }
        return { result: "fail", pos: -1 };
    }

    // Helper to create a textnode and add given text to given parent node
    function addTextNode(parentNode, text) {
        var node = xmlDoc.createTextNode(text);
        parentNode.appendChild(node);
        return node;
    }

    // Helper to add a line break element to given parent node.
    function addLineBreakNode(parentNode) {
        var node = xmlDoc.createElement("wikiLineBreak");
        addTextNode(node, "\n");
        parentNode.appendChild(node);
        return node;
    }

    // Helper to create a new wikiBlock node.
    // parentNode: Parent dom node where children should be added
    // xmlNodeName: node name of child node to be created
    // wikiBlockName: optional block name of wrapped wiki tag. 
    // textContent: optional text conent to be added to created node
    function addWikiBlockNode(parentNode, xmlNodeName, wikiBlockName, textContent) {
        var node = xmlDoc.createElement(xmlNodeName);
        if (wikiBlockName) {
            node.setAttribute("name", wikiBlockName);
        }
        if (textContent) {
            addTextNode(node, textContent);
        }
        parentNode.appendChild(node);
        return node;
    }

    // Helper to create a node type of "openTag"
    function addOpenTagNode(parentNode, tagName) {
        addWikiBlockNode(parentNode, "openTag", null, tagName);
    }

    // Helper to create a node type of "closeTag"
    function addCloseTagNode(parentNode, tagName) {
        addWikiBlockNode(parentNode, "closeTag", null, tagName);
    }

    // Helper to create a new xml document
    function createXmlDocument() {
        var xmlDoc,
            rootXmlText = "<wikiRoot></wikiRoot>";
        if (window.DOMParser) {
            xmlDoc = (new DOMParser()).parseFromString(rootXmlText, "text/xml");
        }
        else // Internet Explorer
        {
            xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
            xmlDoc.async = "false";
            xmlDoc.loadXML(rootXmlText);
        }

        xmlDoc.preserveWhiteSpace = true;
        return xmlDoc;
    }

    // Scans input wikimarkup from given pos, parses and adds parsed item to given currentNode.
    // if endTag is passed, parsing stops when endTag is encountered.
    function parseNextItem(pos, currentNode, endTag, illegalChildTags) {
        var matchInfo;
        do {
            matchInfo = getNextWikiBlockMatch(pos, endTag, illegalChildTags);
            newPos = (matchInfo) ? matchInfo.pos : inputLen;
            if (newPos > pos) {
                var text = input.substring(pos, newPos);
                addTextNode(currentNode, text);
                pos = newPos;
            }
            if (!matchInfo) {
                break;
            }

            if (matchInfo.type === blockTypes.invalidWikiError) {
                // Invalid wikimarkup error situation. Implicitly close the current tag and move on.
                wikiBhasha.debugHelper.assertExpr(matchInfo.pos > pos);
                return matchInfo.pos;
            }
            else if (matchInfo.type === blockTypes.illegalChildTag) {
                // invalid tag detected for current parent. Close the tag at the current position and move on.
                return matchInfo.pos;
            }
            else if (matchInfo.type === blockTypes.closeTag) {
                wikiBhasha.debugHelper.assertExpr(endTag);
                return matchInfo.pos + endTag.length;
            }
            else if (matchInfo.type === blockTypes.lineBreak) {
                addLineBreakNode(currentNode);
                pos = pos + 1;
            }
            else {
                var blockEndPos = matchInfo.type === blockTypes.wikiBlock ?
                    parseWikiBlock(pos, matchInfo.blockName, currentNode) :
                    parseHtmlBlock(pos, matchInfo.blockName, currentNode);
                wikiBhasha.debugHelper.assertExpr(blockEndPos > pos);
                pos = blockEndPos;
            }

        }
        while (matchInfo && pos < inputLen);

        return pos;
    }
};


