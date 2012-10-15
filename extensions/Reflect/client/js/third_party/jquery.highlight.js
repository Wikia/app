/*
 * jQuery Highlight plugin
 * 
 * Modified version of Bartek Szopka's jQuery Highlight (http://bartaz.github.com/sandbox.js/jquery.highlight.html)
 * Copyright (c) 2009 Bartek Szopka
 *
 * Licensed under MIT license.
 *
 */

RegExp.escape = function(str){
	var specials = new RegExp("[.*+?|()\\[\\]{}\\\\]", "g"); // .*+?|()[]{}\
	return str.replace(specials, "\\$&");
};

jQuery.extend({
    _wrap_sentences: function (node, re, nodeName, className) {
        
        if (node.nodeType === 3) {
            var match = node.data.match(re);
            if (match) {
	            var wordNode = node.splitText(match.index);
	            wordNode.splitText(match[0].length);
			     
			}else if(jQuery.trim(node.nodeValue).length == 0){
			 	return 0;
			}else{
	            var wordNode = node.splitText(0);
	            //wordNode.splitText(wordNode.length);
            }
			
            var highlight = document.createElement(nodeName || 'span');
            highlight.className = className || 'highlight';
            
            var wordClone = wordNode.cloneNode(true);
            highlight.appendChild(wordClone);
            wordNode.parentNode.replaceChild(highlight, wordNode);			
			
            return 1; //skip added node in parent
            
        } else if ((node.nodeType === 1 && node.childNodes) && // only element nodes that have children
                !/(script|style)/i.test(node.tagName) && // ignore script and style nodes
                !(node.tagName === nodeName.toUpperCase() && node.className === className)) { // skip if already highlighted
            for (var i = 0; i < node.childNodes.length; i++) {
               i += jQuery._wrap_sentences(node.childNodes[i], re, nodeName, className);
            }
        }
        return 0;

    }
});

jQuery.fn.wrap_sentences = function (words, options) {
    var settings = { className: 'sentence', element: 'a', 
                     caseSensitive: false, wordsOnly: false };
    jQuery.extend(settings, options);
    
    //var pattern = "(\S.+?[.!?])(?=\s+|$)";
    var pattern = "[^\.\?!]+[\.\?!]";
	
    var re = new RegExp(pattern);
    re.escape;
    return jQuery._wrap_sentences(this[0], re, settings.element, settings.className);
};

jQuery.fn.de_sentence = function (options) {
    var settings = { className: 'sentence', element: 'a' };
    jQuery.extend(settings, options);

    return this.find(settings.element + "." + settings.className).each(function () {
        var parent = this.parentNode;
        parent.replaceChild(this.firstChild, this);
        parent.normalize();
    }).end();
};