/*
 * bezen.dom.js - Document Object Model utilities
 *
 * author:    Eric Bréchemier <bezen@eric.brechemier.name>
 * license:   Creative Commons Attribution 3.0 Unported
 *            http://creativecommons.org/licenses/by/3.0/
 * version:   2010-01-14 "Calvin's Snowball"
 *
 * To Cecile, with Love,
 * you were the first to wait for the conception of this library
 *
 * Tested successfully in
 *   Firefox 2, Firefox 3, Firefox 3.5,
 *   Internet Explorer 6, Internet Explorer 7, Internet Explorer 8,
 *   Chrome 3, Safari 3, Safari 4,
 *   Opera 9.64, Opera 10.10
 */
/*requires bezen.js       */
/*requires bezen.error.js */
/*jslint nomen:false, white:false, onevar:false, plusplus:false */
/*global bezen, document */
bezen.dom = (function() {
  // Builder of
  // Closure for DOM utilities

  // Declare aliases
  var catchError = bezen.error.catchError;
   
  // DOM Node Type
  // Ref: W3C REC-DOM-Level-1-19981001
  var ELEMENT_NODE = 1,
      ATTRIBUTE_NODE = 2,
      TEXT_NODE = 3;
   
  var element = function(name,attributes) {
    // Create a new element with given name, attributes and children.
    //
    // params:
    //   name - (string) (!nil) name of the new element to be created
    //   attributes - (object) (!nil) name/value pairs of attributes
    //                for the new element
    //   ... - (list of DOM elements and/or strings) (optional) 
    //         remaining args are added as children elements and text nodes
    //
    // Example:
    //   element('ul',{},
    //     element('li',{},
    //       element('a',{href:"#first"},"first link")
    //     ),
    //     element('li',{},
    //       element('a',{href:"#second"},"second link")
    //     ),
    //     element('li',{},
    //       element('a',{href:"#third"},"third link")
    //     )
    //   );
    //
    // Warnings: in IE
    //   - attributes in uppercase can prevent new object from loading
    //     properly in IE: 'SRC' for IFrame is not converted to 'src'
    //     using this method. The lowercase version should be specified
    //     in calls to this method. A later version of the code may also 
    //     convert received values in lowercase just in case.
    //
    //   - setting the 'class' attribute does not update the className
    //     property as expected. A later version of this code might set
    //     the className property directly when the attribute name is 'class'.
    //
    //   - setting the 'style' attribute does not work either. A later version
    //     of this code might set the style property directly.
    //
    //   - some elements cannot be added as child of others, e.g.
    //     'embed' as child of 'object'. They are silently ignored here.
     
    var parent = document.createElement(name);
    if (!attributes) {
      return parent;
    }
     
    for (var attribute in attributes) {
      if ( attributes.hasOwnProperty(attribute) ) {
        parent.setAttribute( attribute, attributes[attribute] );
      }
    }
    
    if (parent.canHaveChildren===false) {
      // avoid error in IE: children forbidden
      return parent;
    }
     
    for (var i=2; i<arguments.length; i++) {
      var child = arguments[i];
      if (typeof child === 'string') {
        child = document.createTextNode(child);
      }
      parent.appendChild( child );
    }
    return parent;
  };
  
  var clear = function(element) {
    // Clear an element contents by resetting its innerHTML
    //
    // param:
    //   element - (DOM element) (!nil) the element to empty
    //
    // Note:
    //   in case the element cannot have children (IE) the call is ignored
    //
    if (element.canHaveChildren===false) {
      return;
    }
     
    element.innerHTML = '';
  };

  var insertBefore = function(node,newNode) {
    // Insert a new node before given node
    //
    // params:
    //   node - (DOM node)(!nil) the reference node, will be next sibling 
    //          of the new node after insertion
    //   newNode - (DOM node) the new node, to insert before
     
    var parent = node.parentNode;
    parent.insertBefore(newNode,node);
  };
  
  var insertAfter = function(node,newNode) {
    // Insert a new node after given node
    //
    // params:
    //   node - (DOM node)(!nil) the reference node, will be previous sibling 
    //          of the new node after insertion
    //   newNode - (DOM node) the new node, to insert after
    //
    // Reference for this implementation based on element.insertBefore:
    //   https://developer.mozilla.org/en/insertBefore 

    var parent = node.parentNode;
    parent.insertBefore(newNode, node.nextSibling);
  };

  var remove = function(element) {
    // Remove an element from the DOM
    //
    // param:
    //   element - (DOM element) (!nil) the element to remove
    //
    // Notes:
    //   - nothing happens if the element has no parent
    //   - the parentNode property is read-only
    //   - in IE, the parentNode is not set to null like in other browsers,
    //     but to a document fragment object. To detect this case, I check
    //     here the presence of the innerHTML property on the parent. In case
    //     no innerHTML is present, the parent is considered to be such a
    //     foster document fragment.
     
    if (element.parentNode && element.parentNode.innerHTML) {
      element.parentNode.removeChild(element);
    }
  };
   
  var hasAttribute = function(node, attributeName) {
    // emulate hasAttribute by checking DOM level 2 specified property
    // of the attribute node. The native function is used when available.
    // 
    // params:
    //   node - (DOM element) (!nil) the element to check for given attribute
    //   attributeName - (string) (!nil) an attribute name
    //
    // return: (boolean)
    //   true if the attribute is present on the element,
    //   false otherwise
    //
    // Note: when the behavior is emulated, in IE, the attribute may not 
    //       have been defined in the original document, but may be an
    //       optional attribute set to its default value.
      
    if (node.hasAttribute) {
      return node.hasAttribute(attributeName);
    }
     
    var attributeNode = node.getAttributeNode(attributeName);
    if (attributeNode === null) {
      return false;
    }
    return attributeNode.specified;
  };
  
  var appendScript = function(parent, scriptElt, listener) {
    // append a script element as last child in parent and configure 
    // provided listener function for the script load event
    //
    // params:
    //   parent - (DOM element) (!nil) the parent node to append the script to
    //   scriptElt - (DOM element) (!nil) a new script element 
    //   listener - (function) (!nil) listener function for script load event
    //
    // Notes:
    //   - in IE, the load event is simulated by setting an intermediate 
    //     listener to onreadystate which filters events and fires the
    //     callback just once when the state is "loaded" or "complete"
    //
    //   - Opera supports both readyState and onload, but does not behave in
    //     the exact same way as IE for readyState, e.g. "loaded" may be
    //     reached before the script runs.
    //
    //   - a listener can be set to the 'onerror' property of the script
    //     beforehand to detect errors in loading external scripts. I thought
    //     about adding an optional parameter for this listener function,
    //     and came to the conclusion that it was unnecessary: like other
    //     properties of the script, it can be set on the script element
    //     before calling this function to append and load the script.
    //
    // Known Limitation:
    //   - When trying to load dynamically a script with src '//:' using this
    //     method, the listener function is not triggered (and neither is the
    //     onerror function if set): in Firefox the onload function is not
    //     called, in Internet Explorer the onreadystatechange function is
    //     triggered once for 'loaded', but never for 'complete'. The behavior
    //     of a static script with src '//:' is the same in Firefox, but 
    //     differs in Internet Explorer: with a static script the function
    //     onreadystatechange is triggered once for 'complete'.
    //     This special src value is used in some old hacks to detect the
    //     DOM readiness in Internet Explorer. Extra attention should be taken
    //     when loading scripts relying on this hack dynamically.
     
    var safelistener = catchError(listener,'script.onload');
     
    // Opera has readyState too, but does not behave in a consistent way
    if (scriptElt.readyState && scriptElt.onload!==null) {
      // IE only (onload===undefined) not Opera (onload===null)
      scriptElt.onreadystatechange = function() {
        if ( scriptElt.readyState === "loaded" || 
             scriptElt.readyState === "complete" ) {
          // Avoid memory leaks (and duplicate call to callback) in IE
          scriptElt.onreadystatechange = null;
          scriptElt.onerror = null;
          safelistener();
        }
      };
    } else {
      // other browsers (DOM Level 0)
      scriptElt.onload = safelistener;
    }
    parent.appendChild( scriptElt );
  };
   
  return { // public API
    ELEMENT_NODE: ELEMENT_NODE,
    ATTRIBUTE_NODE: ATTRIBUTE_NODE,
    TEXT_NODE: TEXT_NODE,
    element: element,
    clear: clear,
    insertBefore: insertBefore,
    insertAfter: insertAfter,
    remove: remove,
    hasAttribute: hasAttribute,
    appendScript: appendScript,
      
    _: { // private section, for unit tests
    }
  };
}());
