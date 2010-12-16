/*==================================================
 *  Exhibit.LensRegistry
 *==================================================
 */
 
Exhibit.LensRegistry = function(parentRegistry) {
    this._parentRegistry = parentRegistry;
    this._defaultLens = null;
    this._typeToLens = {};
    this._lensSelectors = [];
};

Exhibit.LensRegistry.prototype.registerDefaultLens = function(elmtOrURL) {
    this._defaultLens = (typeof elmtOrURL == "string") ? elmtOrURL : elmtOrURL.cloneNode(true);
};

Exhibit.LensRegistry.prototype.registerLensForType = function(elmtOrURL, type) {
    this._typeToLens[type] = (typeof elmtOrURL == "string") ? elmtOrURL : elmtOrURL.cloneNode(true);
};

Exhibit.LensRegistry.prototype.addLensSelector = function(lensSelector) {
    this._lensSelectors.unshift(lensSelector);
};

Exhibit.LensRegistry.prototype.getLens = function(itemID, database) {
    for (var i = 0; i < this._lensSelectors.length; i++) {
        var lens = this._lensSelectors[i](itemID, database);
        if (lens != null) {
            return lens;
        }
    }
    
    var type = database.getObject(itemID, "type");
    if (type in this._typeToLens) {
        return this._typeToLens[type];
    }
    if (this._defaultLens != null) {
        return this._defaultLens;
    }
    if (this._parentRegistry) {
        return this._parentRegistry.getLens(itemID, database);
    }
    return null;
};

Exhibit.LensRegistry.prototype.createLens = function(itemID, div, uiContext) {
    var lens = new Exhibit.Lens();
    
    var lensTemplate = this.getLens(itemID, uiContext.getDatabase());
    if (lensTemplate == null) {
        lens._constructDefaultUI(itemID, div, uiContext);
    } else if (typeof lensTemplate == "string") {
        lens._constructFromLensTemplateURL(itemID, div, uiContext, lensTemplate);
    } else {
        lens._constructFromLensTemplateDOM(itemID, div, uiContext, lensTemplate);
    }
    return lens;
};
 
/*==================================================
 *  Exhibit.Lens
 *  http://simile.mit.edu/wiki/Exhibit/API/Lens
 *==================================================
 */
Exhibit.Lens = function() {
};

Exhibit.Lens._commonProperties = null;
Exhibit.Lens.prototype._constructDefaultUI = function(itemID, div, uiContext) {
    var database = uiContext.getDatabase();
    
    if (Exhibit.Lens._commonProperties == null) {
        Exhibit.Lens._commonProperties = database.getAllProperties();
    }
    var properties = Exhibit.Lens._commonProperties;
    
    var label = database.getObject(itemID, "label");
    label = label != null ? label : itemID;
    
    if (Exhibit.params.safe) {
        label = Exhibit.Formatter.encodeAngleBrackets(label);
    }
    
    var template = {
        elmt:       div,
        className:  "exhibit-lens",
        children: [
            {   tag:        "div",
                className:  "exhibit-lens-title",
                title:      label,
                children:   [ 
                    label + " (",
                    {   tag:        "a",
                        href:       Exhibit.Persistence.getItemLink(itemID),
                        target:     "_blank",
                        children:   [ Exhibit.l10n.itemLinkLabel ]
                    },
                    ")"
                ]
            },
            {   tag:        "div",
                className:  "exhibit-lens-body",
                children: [
                    {   tag:        "table",
                        className:  "exhibit-lens-properties",
                        field:      "propertiesTable"
                    }
                ]
            }
        ]
    };
    var dom = SimileAjax.DOM.createDOMFromTemplate(template);
    
    div.setAttribute("ex:itemID", itemID);
    //Exhibit.ToolboxWidget.createFromDOM(div, div, uiContext);
    
    var pairs = Exhibit.ViewPanel.getPropertyValuesPairs(
        itemID, properties, database);
        
    for (var j = 0; j < pairs.length; j++) {
        var pair = pairs[j];
        
        var tr = dom.propertiesTable.insertRow(j);
        tr.className = "exhibit-lens-property";
        
        var tdName = tr.insertCell(0);
        tdName.className = "exhibit-lens-property-name";
        tdName.innerHTML = pair.propertyLabel + ": ";
        
        var tdValues = tr.insertCell(1);
        tdValues.className = "exhibit-lens-property-values";
        
        if (pair.valueType == "item") {
            for (var m = 0; m < pair.values.length; m++) {
                if (m > 0) {
                    tdValues.appendChild(document.createTextNode(", "));
                }
                tdValues.appendChild(Exhibit.UI.makeItemSpan(pair.values[m], null, uiContext));
            }
        } else {
            for (var m = 0; m < pair.values.length; m++) {
                if (m > 0) {
                    tdValues.appendChild(document.createTextNode(", "));
                }
                tdValues.appendChild(Exhibit.UI.makeValueSpan(pair.values[m], pair.valueType));
            }
        }
    }
};

Exhibit.Lens._compiledTemplates = {};
Exhibit.Lens._handlers = [
    "onblur", "onfocus", 
    "onkeydown", "onkeypress", "onkeyup", 
    "onmousedown", "onmouseenter", "onmouseleave", "onmousemove", "onmouseout", "onmouseover", "onmouseup", "onclick",
    "onresize", "onscroll"
];

Exhibit.Lens.prototype._constructFromLensTemplateURL = 
    function(itemID, div, uiContext, lensTemplateURL) {
    
    var job = {
        lens:           this,
        itemID:         itemID,
        div:            div,
        uiContext:      uiContext
    };
    
    var compiledTemplate = Exhibit.Lens._compiledTemplates[lensTemplateURL];
    if (compiledTemplate == null) {
        Exhibit.Lens._startCompilingTemplate(lensTemplateURL, job);
    } else if (!compiledTemplate.compiled) {
        compiledTemplate.jobs.push(job);
    } else {
        job.template = compiledTemplate;
        Exhibit.Lens._performConstructFromLensTemplateJob(job);
    }
};

Exhibit.Lens.prototype._constructFromLensTemplateDOM = 
    function(itemID, div, uiContext, lensTemplateNode) {
    
    var job = {
        lens:           this,
        itemID:         itemID,
        div:            div,
        uiContext:      uiContext
    };
    
    var id = lensTemplateNode.id;
    if (id == null || id.length == 0) {
        id = "exhibitLensTemplate" + Math.floor(Math.random() * 10000);
        lensTemplateNode.id = id;
    }
    
    var compiledTemplate = Exhibit.Lens._compiledTemplates[id];
    if (compiledTemplate == null) {
        compiledTemplate = {
            url:        id,
            template:   Exhibit.Lens.compileTemplate(lensTemplateNode, false, uiContext),
            compiled:   true,
            jobs:       []
        };
        Exhibit.Lens._compiledTemplates[id] = compiledTemplate;
    }
    job.template = compiledTemplate;
    Exhibit.Lens._performConstructFromLensTemplateJob(job);
};

Exhibit.Lens._startCompilingTemplate = function(lensTemplateURL, job) {
    var compiledTemplate = {
        url:        lensTemplateURL,
        template:   null,
        compiled:   false,
        jobs:       [ job ]
    };
    Exhibit.Lens._compiledTemplates[lensTemplateURL] = compiledTemplate;
    
    var fError = function(statusText, status, xmlhttp) {
        SimileAjax.Debug.log("Failed to load view template from " + lensTemplateURL + "\n" + statusText);
    };
    var fDone = function(xmlhttp) {
        try {
            compiledTemplate.template = Exhibit.Lens.compileTemplate(
                xmlhttp.responseXML.documentElement, true, job.uiContext);
                
            compiledTemplate.compiled = true;
            
            for (var i = 0; i < compiledTemplate.jobs.length; i++) {
                try {
                    var job2 = compiledTemplate.jobs[i];
                    job2.template = compiledTemplate;
                    Exhibit.Lens._performConstructFromLensTemplateJob(job2);
                } catch (e) {
                    SimileAjax.Debug.exception(e, "Lens: Error constructing lens template in job queue");
                }
            }
            compiledTemplate.jobs = null;
        } catch (e) {
            SimileAjax.Debug.exception(e, "Lens: Error compiling lens template and processing template job queue");
        }
    };
    
    SimileAjax.XmlHttp.get(lensTemplateURL, fError, fDone);

    return compiledTemplate;
};

Exhibit.Lens.compileTemplate = function(rootNode, isXML, uiContext) {
    return Exhibit.Lens._processTemplateNode(rootNode, isXML, uiContext);
};

Exhibit.Lens._processTemplateNode = function(node, isXML, uiContext) {
    if (node.nodeType == 1) {
        return Exhibit.Lens._processTemplateElement(node, isXML, uiContext);
    } else {
        return node.nodeValue;
    }
};

Exhibit.Lens._processTemplateElement = function(elmt, isXML, uiContext) {
    var templateNode = {
        tag:                    elmt.tagName.toLowerCase(),
        uiContext:              uiContext,
        control:                null,
        condition:              null,
        content:                null,
        contentAttributes:      null,
        subcontentAttributes:   null,
        attributes:             [],
        styles:                 [],
        handlers:               [],
        children:               null
    };
    
    var parseChildTextNodes = true;
    
    var attributes = elmt.attributes;
    for (var i = 0; i < attributes.length; i++) {
        var attribute = attributes[i];
        var name = attribute.nodeName;
        var value = attribute.nodeValue;
        
        if (value == null || typeof value != "string" || value.length == 0 || name == "contentEditable") {
            continue;
        }
        if (name == "ex:onshow") {
            templateNode.attributes.push({
                name:   name,
                value:  value
            });
        } else if (name.length > 3 && name.substr(0,3) == "ex:") {
            name = name.substr(3);
            if (name == "formats") {
                templateNode.uiContext = Exhibit.UIContext._createWithParent(uiContext);
                
                Exhibit.FormatParser.parseSeveral(templateNode.uiContext, value, 0, {});
            } else if (name == "control") {
                templateNode.control = value;
            } else if (name == "content") {
                templateNode.content = Exhibit.ExpressionParser.parse(value);
            } else if (name == "if-exists") {
                templateNode.condition = {
                    test:       "if-exists",
                    expression: Exhibit.ExpressionParser.parse(value)
                };
            } else if (name == "if") {
                templateNode.condition = {
                    test:       "if",
                    expression: Exhibit.ExpressionParser.parse(value)
                };
                parseChildTextNodes = false;
            } else if (name == "select") {
                templateNode.condition = {
                    test:       "select",
                    expression: Exhibit.ExpressionParser.parse(value)
                };
            } else if (name == "case") {
                templateNode.condition = {
                    test:   "case",
                    value:  value
                };
                parseChildTextNodes = false;
            } else {
                var isStyle = false;
                var x = name.indexOf("-style-content");
                if (x > 0) {
                    isStyle = true;
                } else {
                    x = name.indexOf("-content");
                }
                
                if (x > 0) {
                    if (templateNode.contentAttributes == null) {
                        templateNode.contentAttributes = [];
                    }
                    templateNode.contentAttributes.push({
                        name:       name.substr(0, x),
                        expression: Exhibit.ExpressionParser.parse(value),
                        isStyle:    isStyle
                    });
                } else {
                    x = name.indexOf("-style-subcontent");
                    if (x > 0) {
                        isStyle = true;
                    } else {
                        x = name.indexOf("-subcontent");
                    }
                    
                    if (x > 0) {
                        if (templateNode.subcontentAttributes == null) {
                            templateNode.subcontentAttributes = [];
                        }
                        templateNode.subcontentAttributes.push({
                            name:       name.substr(0, x),
                            fragments:  Exhibit.Lens._parseSubcontentAttribute(value),
                            isStyle:    isStyle
                        });
                    }
                }
            }
        } else {
            if (name == "style") {
                Exhibit.Lens._processStyle(templateNode, value);
            } else if (name != "id") {
                if (name == "class") {
                    if (SimileAjax.Platform.browser.isIE) {
                        name = "className";
                    }
                } else if (name == "cellspacing") {
                    name = "cellSpacing";
                } else if (name == "cellpadding") {
                    name = "cellPadding";
                } else if (name == "bgcolor") {
                    name = "bgColor";
                }
                
                templateNode.attributes.push({
                    name:   name,
                    value:  value
                });
            }
        }
    }
    
    if (!isXML && SimileAjax.Platform.browser.isIE) {
        /*
         *  IE swallows style and event handler attributes of HTML elements.
         *  So our loop above will not catch them.
         */
         
        /* Need to handle this for IE
        var style = elmt.getAttribute("style");
        if (style != null && style.length > 0) {
            Exhibit.Lens._processStyle(templateNode, value);
        }
        */
        
        var handlers = Exhibit.Lens._handlers;
        for (var h = 0; h < handlers.length; h++) {
            var handler = handlers[h];
            var code = elmt[handler];
            if (code != null) {
                templateNode.handlers.push({ name: handler, code: code });
            }
        }
    }
    
    var childNode = elmt.firstChild;
    if (childNode != null) {
        templateNode.children = [];
        while (childNode != null) {
            if ((parseChildTextNodes && childNode.nodeType == 3) || childNode.nodeType == 1) {
                templateNode.children.push(Exhibit.Lens._processTemplateNode(childNode, isXML, templateNode.uiContext));
            }
            childNode = childNode.nextSibling;
        }
    }
    return templateNode;
};

Exhibit.Lens._processStyle = function(templateNode, styleValue) {
    var styles = styleValue.split(";");
    for (var s = 0; s < styles.length; s++) {
        var pair = styles[s].split(":");
        if (pair.length > 1) {
            var n = pair[0].trim();
            var v = pair[1].trim();
            if (n == "float") {
                n = SimileAjax.Platform.browser.isIE ? "styleFloat" : "cssFloat";
            } else if (n == "-moz-opacity") {
                n = "MozOpacity";
            } else {
                if (n.indexOf("-") > 0) {
                    var segments = n.split("-");
                    n = segments[0];
                    for (var x = 1; x < segments.length; x++) {
                        n += segments[x].substr(0, 1).toUpperCase() + segments[x].substr(1);
                    }
                }
            }
            templateNode.styles.push({ name: n, value: v });
        }
    }
};

Exhibit.Lens._parseSubcontentAttribute = function(value) {
    var fragments = [];
    var current = 0;
    var open;
    while (current < value.length && (open = value.indexOf("{{", current)) >= 0) {
        var close = value.indexOf("}}", open);
        if (close < 0) {
            break;
        }
        
        fragments.push(value.substring(current, open));
        fragments.push(Exhibit.ExpressionParser.parse(value.substring(open + 2, close)));
        
        current = close + 2;
    }
    if (current < value.length) {
        fragments.push(value.substr(current));
    }
    return fragments;
};

Exhibit.Lens.constructFromLensTemplate = function(itemID, templateNode, parentElmt, uiContext) {
    return Exhibit.Lens._performConstructFromLensTemplateJob({
        itemID:     itemID,
        template:   { template: templateNode },
        div:        parentElmt,
        uiContext:  uiContext
    });
};

Exhibit.Lens._performConstructFromLensTemplateJob = function(job) {
    Exhibit.Lens._constructFromLensTemplateNode(
        {   "value" :   job.itemID
        },
        {   "value" :   "item"
        },
        job.template.template, 
        job.div
    );
    
    var node = job.div.lastChild;
    var tagName = node.tagName;
    if (tagName == "span") {
        node.style.display = "inline";
    } else {
        node.style.display = "block";
    }
    
    node.setAttribute("ex:itemID", job.itemID);
    
    if (!Exhibit.params.safe) {
        var onshow = Exhibit.getAttribute(node, "onshow");
        if (onshow != null && onshow.length > 0) {
            try {
                eval("(function() { " + onshow + " })").call(node);
            } catch (e) {
                SimileAjax.Debug.log(e);
            }
        }
    }
    
    //Exhibit.ToolboxWidget.createFromDOM(job.div, job.div, job.uiContext);
    return node;
};

Exhibit.Lens._constructFromLensTemplateNode = function(
    roots, rootValueTypes, templateNode, parentElmt
) {
    if (typeof templateNode == "string") {
        parentElmt.appendChild(document.createTextNode(templateNode));
        return;
    }
    
    var database = templateNode.uiContext.getDatabase();
    var children = templateNode.children;
    if (templateNode.condition != null) {
        if (templateNode.condition.test == "if-exists") {
            if (!templateNode.condition.expression.testExists(
                    roots,
                    rootValueTypes,
                    "value",
                    database
                )) {
                return;
            }
        } else if (templateNode.condition.test == "if") {
            if (templateNode.condition.expression.evaluate(
                    roots,
                    rootValueTypes,
                    "value",
                    database
                ).values.contains(true)) {
                
                if (children != null && children.length > 0) {
                    Exhibit.Lens._constructFromLensTemplateNode(
                        roots, rootValueTypes, children[0], parentElmt);
                }
            } else {
                if (children != null && children.length > 1) {
                    Exhibit.Lens._constructFromLensTemplateNode(
                        roots, rootValueTypes, children[1], parentElmt);
                }
            }
            return;
        } else if (templateNode.condition.test == "select") {
            var values = templateNode.condition.expression.evaluate(
                roots,
                rootValueTypes,
                "value",
                database
            ).values;
            
            if (children != null) {
                var lastChildTemplateNode = null;
                for (var c = 0; c < children.length; c++) {
                    var childTemplateNode = children[c];
                    if (childTemplateNode.condition != null && 
                        childTemplateNode.condition.test == "case") {
                        
                        if (values.contains(childTemplateNode.condition.value)) {
                            Exhibit.Lens._constructFromLensTemplateNode(
                                roots, rootValueTypes, childTemplateNode, parentElmt);
                                
                            return;
                        }
                    } else if (typeof childTemplateNode != "string") {
                        lastChildTemplateNode = childTemplateNode;
                    }
                }
            }
            
            if (lastChildTemplateNode != null) {
                Exhibit.Lens._constructFromLensTemplateNode(
                    roots, rootValueTypes, lastChildTemplateNode, parentElmt);
            }
            return;
        }
    }
    
    var elmt = Exhibit.Lens._constructElmtWithAttributes(templateNode, parentElmt, database);
    if (templateNode.contentAttributes != null) {
        var contentAttributes = templateNode.contentAttributes;
        for (var i = 0; i < contentAttributes.length; i++) {
            var attribute = contentAttributes[i];
            var values = [];
            
            attribute.expression.evaluate(
                roots,
                rootValueTypes,
                "value",
                database
            ).values.visit(function(v) { values.push(v); });
            
            var value = values.join(";");
            if (attribute.isStyle) {
                elmt.style[attribute.name] = value;
            } else if ("class" == attribute.name) {
                elmt.className = value;
            } else if (Exhibit.Lens._attributeValueIsSafe(attribute.name, value)) {
                elmt.setAttribute(attribute.name, value);
            }
        }
    }
    if (templateNode.subcontentAttributes != null) {
        var subcontentAttributes = templateNode.subcontentAttributes;
        for (var i = 0; i < subcontentAttributes.length; i++) {
            var attribute = subcontentAttributes[i];
            var fragments = attribute.fragments;
            var results = "";
            for (var r = 0; r < fragments.length; r++) {
                var fragment = fragments[r];
                if (typeof fragment == "string") {
                    results += fragment;
                } else {
                    results += fragment.evaluateSingle(
                        roots,
                        rootValueTypes,
                        "value",
                        database
                    ).value;
                }
            }
            
            if (attribute.isStyle) {
                elmt.style[attribute.name] = results;
            } else if ("class" == attribute.name) {
                elmt.className = results;
            } else if (Exhibit.Lens._attributeValueIsSafe(attribute.name, results)) {
                elmt.setAttribute(attribute.name, results);
            }
        }
    }
    
    if (!Exhibit.params.safe) {
        var handlers = templateNode.handlers;
        for (var h = 0; h < handlers.length; h++) {
            var handler = handlers[h];
            elmt[handler.name] = handler.code;
        }
    }
    
    if (templateNode.control != null) {
        switch (templateNode.control) {
        case "item-link":
            var a = document.createElement("a");
            a.innerHTML = Exhibit.l10n.itemLinkLabel;
            a.href = Exhibit.Persistence.getItemLink(roots["value"]);
            a.target = "_blank";
            elmt.appendChild(a);
        }
    } else if (templateNode.content != null) {
        var results = templateNode.content.evaluate(
            roots,
            rootValueTypes,
            "value",
            database
        );
        if (children != null) {
            var rootValueTypes2 = { "value" : results.valueType, "index" : "number" };
            var index = 1;
            
            var processOneValue = function(childValue) {
                var roots2 = { "value" : childValue, "index" : index++ };
                for (var i = 0; i < children.length; i++) {
                    Exhibit.Lens._constructFromLensTemplateNode(
                        roots2, rootValueTypes2, children[i], elmt);
                }
            };
            if (results.values instanceof Array) {
                for (var i = 0; i < results.values.length; i++) {
                    processOneValue(results.values[i]);
                }
            } else {
                results.values.visit(processOneValue);
            }
        } else {
            Exhibit.Lens._constructDefaultValueList(results.values, results.valueType, elmt, templateNode.uiContext);
        }
    } else if (children != null) {
        for (var i = 0; i < children.length; i++) {
            Exhibit.Lens._constructFromLensTemplateNode(roots, rootValueTypes, children[i], elmt);
        }
    }
};

Exhibit.Lens._constructElmtWithAttributes = function(templateNode, parentElmt, database) {
    var elmt;
    if (templateNode.tag == "input" && SimileAjax.Platform.browser.isIE) {
        var a = [ "<input" ];
        var attributes = templateNode.attributes;
        for (var i = 0; i < attributes.length; i++) {
            var attribute = attributes[i];
            if (Exhibit.Lens._attributeValueIsSafe(attribute.name, attribute.value)) {
                a.push(attribute.name + "=\"" + attribute.value + "\"");
            }
        }
        a.push("></input>");
        
        elmt = SimileAjax.DOM.createElementFromString(a.join(" "));
        parentElmt.appendChild(elmt);
    } else {
        switch (templateNode.tag) {
        case "tr":
            elmt = parentElmt.insertRow(parentElmt.rows.length);
            break;
        case "td":
            elmt = parentElmt.insertCell(parentElmt.cells.length);
            break;
        default:
            elmt = document.createElement(templateNode.tag);
            parentElmt.appendChild(elmt);
        }
        
        var attributes = templateNode.attributes;
        for (var i = 0; i < attributes.length; i++) {
            var attribute = attributes[i];
            if (Exhibit.Lens._attributeValueIsSafe(attribute.name, attribute.value)) {
                try {
                    elmt.setAttribute(attribute.name, attribute.value);
                } catch (e) {
                    // ignore; this happens on IE for attribute "type" on element "input"
                }
            }
        }
    }
    
    var styles = templateNode.styles;
    for (var i = 0; i < styles.length; i++) {
        var style = styles[i];
        elmt.style[style.name] = style.value;
    }
    return elmt;
};

Exhibit.Lens._constructDefaultValueList = function(values, valueType, parentElmt, uiContext) {
    uiContext.formatList(values, values.size(), valueType, function(elmt) {
        parentElmt.appendChild(elmt);
    });
};

Exhibit.Lens._attributeValueIsSafe = function(name, value) {
    if (Exhibit.params.safe) {
        if ((name == "href" && value.startsWith("javascript:")) ||
            (name.startsWith("on"))) {
            return false;
        }
    }
    return true;
};