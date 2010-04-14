
// BEGIN ../../lib/Wikiwyg/Init.js

/*==============================================================================
Initial stuff by Bartek Łapiński

COPYRIGHT:

    Copyright © 2005 Socialtext Corporation
    655 High Street
    Palo Alto, CA 94301 U.S.A.
    All rights reserved.

    Copyright © 2007, Wikia Inc.

CHANGES AUTHOR:

    Bartek Łapiński <bartek@wikia.com>

    Copyright © 2007, Wikia Inc.

Wikiwyg is free software.

This library is free software; you can redistribute it and/or modify it
under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation; either version 2.1 of the License, or (at
your option) any later version.

This library is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser
General Public License for more details.

    http://www.gnu.org/copyleft/lesser.txt

 =============================================================================*/

var currentWikiwyg;
var needToConfirm = false;

/* comfirming exit from page */
function confirmExit(){
	if (needToConfirm){
	return "You have attempted to leave this page. If you have made any changes to the fields without clicking the Save button, your changes will be lost. Are you sure you want to exit this page?";
}
}

/* Yahoo stuff - Bartek Łapiński */
YAHOO.namespace('Wikia');
var Event = YAHOO.util.Event;

YAHOO.Wikia.Wikiwyg = {
	buildLicensePanel: function () {		
		var copywarn = document.getElementById ('editpage-copywarn');
		var copywarn_copy = document.createElement ('div');
		copywarn_copy.id = 'copywarn-license';
		copywarn_copy.innerHTML  = copywarn.innerHTML;
                YAHOO.Wikia.Wikiwyg.applyTargetToLinks (copywarn_copy, "_new");
		document.body.appendChild (copywarn_copy);
		YAHOO.Wikia.Wikiwyg.licensePanel = new YAHOO.widget.Panel('copywarn-license', {
			width: "600px",
			modal: true,
			constraintoviewport: true,
			draggable: false,
			fixedcenter: true,
			underlay: "none"
		} );
		YAHOO.Wikia.Wikiwyg.licensePanel.render();		
	} ,

       	// apply target to all links included in the selected element
	applyTargetToLinks: function (element, target) {
		var links = element.getElementsByTagName('a');
		if (links && (links.length > 0)) {
			for (var i=0; i < links.length; i++) {
				links[i].target = target;
			}
		}
	} ,

	showLicensePanel: function (e) {
		YAHOO.util.Event.preventDefault(e);
		if (!YAHOO.Wikia.Wikiwyg.licensePanel) {
                	YAHOO.Wikia.Wikiwyg.buildLicensePanel();
		}
		YAHOO.Wikia.Wikiwyg.licensePanel.show();
	}
}

// BEGIN ../../lib/Wikiwyg.js
/*==============================================================================
Wikiwyg - Turn any HTML div into a wikitext /and/ wysiwyg edit area.

DESCRIPTION:

Wikiwyg is a Javascript library that can be easily integrated into any
wiki or blog software. It offers the user multiple ways to edit/view a
piece of content: Wysiwyg, Wikitext, Raw-HTML and Preview.

The library is easy to use, completely object oriented, configurable and
extendable.

See the Wikiwyg documentation for details.

AUTHORS:

    Ingy döt Net <ingy@cpan.org>
    Casey West <casey@geeknest.com>
    Chris Dent <cdent@burningchrome.com>
    Matt Liggett <mml@pobox.com>
    Ryan King <rking@panoptic.com>
    Dave Rolsky <autarch@urth.org>
    Kang-min Liu <gugod@gugod.org>

COPYRIGHT:

    Copyright © 2005 Socialtext Corporation
    655 High Street
    Palo Alto, CA 94301 U.S.A.
    All rights reserved.


CHANGES AUTHOR:

    Bartek Łapiński <bartek@wikia.com>

    Copyright © 2007, Wikia Inc.

Wikiwyg is free software.

This library is free software; you can redistribute it and/or modify it
under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation; either version 2.1 of the License, or (at
your option) any later version.

This library is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser
General Public License for more details.

    http://www.gnu.org/copyleft/lesser.txt

 =============================================================================*/

/*==============================================================================
Subclass - this can be used to create new classes
 =============================================================================*/
Subclass = function(class_name, base_class_name) {
    if (!class_name) throw("Can't create a subclass without a name");

    var parts = class_name.split('.');
    var subclass = window;
    for (var i = 0; i < parts.length; i++) {
        if (! subclass[parts[i]])
            subclass[parts[i]] = function() {};
        subclass = subclass[parts[i]];
    }

    if (base_class_name) {
        var baseclass = eval('new ' + base_class_name + '()');
        subclass.prototype = baseclass;
        subclass.prototype.baseclass = baseclass;
    }

    subclass.prototype.classname = class_name;
    return subclass.prototype;
}

/*==============================================================================
Wikiwyg - Primary Wikiwyg base class
 =============================================================================*/

// Constructor and class methods
proto = new Subclass('Wikiwyg');

Wikiwyg.VERSION = '0.13';

// Browser support properties
Wikiwyg.ua = navigator.userAgent.toLowerCase();
Wikiwyg.is_ie = (
    Wikiwyg.ua.indexOf("msie") != -1 &&
    Wikiwyg.ua.indexOf("opera") == -1 &&
    Wikiwyg.ua.indexOf("webtv") == -1
);
Wikiwyg.is_gecko = (
    Wikiwyg.ua.indexOf('gecko') != -1 &&
    Wikiwyg.ua.indexOf('safari') == -1 &&
    Wikiwyg.ua.indexOf('konqueror') == -1
);
Wikiwyg.is_safari = (
    Wikiwyg.ua.indexOf('safari') != -1
);
Wikiwyg.is_opera = (
    Wikiwyg.ua.indexOf('opera') != -1
);
Wikiwyg.is_konqueror = (
    Wikiwyg.ua.indexOf("konqueror") != -1
)
Wikiwyg.browserIsSupported = (
    Wikiwyg.is_gecko ||
    Wikiwyg.is_ie
);

// Wikiwyg environment setup public methods
proto.createWikiwygArea = function(div, config) {
    this.set_config(config);
    this.initializeObject(div, config);
};

proto.default_config = {
    javascriptLocation: '/wikiwyg/lib/',
    doubleClickToEdit: false,
    toolbarClass: 'Wikiwyg.Toolbar',
    firstMode: null,
    modeClasses: [
	'Wikiwyg.Wysiwyg' ,
	'Wikiwyg.Wikitext' ,
        'Wikiwyg.Preview'
    ]
};

proto.initializeObject = function(div, config) {
    /* enable people to use Special:Createpage regardless of this preference */
    if ((wgUseInPage == 0) && (wgCanonicalSpecialPageName != "Createpage") ) return;

    if (! Wikiwyg.browserIsSupported) return;
    if (this.enabled) return;
    this.enabled = true;
    this.div = div;
    this.divHeight = this.div.offsetHeight;
    if (!config) config = {};

    this.set_config(config);

    this.mode_objects = {};
    for (var i = 0; i < this.config.modeClasses.length; i++) {
        var class_name = this.config.modeClasses[i];
        var mode_object = eval('new ' + class_name + '()');
        mode_object.wikiwyg = this;
        mode_object.set_config(config[mode_object.classtype]);
        mode_object.initializeObject();
        this.mode_objects[class_name] = mode_object;
    }
    var firstMode = this.config.firstMode
        ? this.config.firstMode
        : this.config.modeClasses[0];
    this.setFirstModeByName(firstMode);
    var section_number = this.div.id.replace(/.*?(\d+)$/, '$1');

    if (this.config.toolbarClass) {
        var class_name = this.config.toolbarClass;
        this.toolbarObject = eval('new ' + class_name + '()');
        this.toolbarObject.wikiwyg = this;
        this.toolbarObject.set_config(config.toolbar);
        this.toolbarObject.initializeObject(section_number);
        this.placeToolbar(this.toolbarObject.div);

	if (!wgFullPageEditing) {
		this.toolbarObject.placeLowerToolbar();
		this.placeLowerToolbar (this.toolbarObject.linksDiv);
		this.placeLowerToolbar (this.toolbarObject.summaryDiv);
       	/* attach the event for the license */
		Event.addListener ('wikiwyg_ctrl_lnk_showLicense_' + section_number, 'click', YAHOO.Wikia.Wikiwyg.showLicensePanel);
	}
    }
      
    // These objects must be _created_ before the toolbar is created
    // but _inserted_ after.
    for (var i = 0; i < this.config.modeClasses.length; i++) {
        var mode_class = this.config.modeClasses[i];
        var mode_object = this.modeByName(mode_class);
        this.insert_div_before(mode_object.div);
    }

    if (this.config.doubleClickToEdit) {
        var self = this;
        this.div.ondblclick = function() { self.editMode() };
    }
}

// Wikiwyg environment setup private methods
proto.set_config = function(user_config) {
    var new_config = {};
    var keys = [];
    for (var key in this.default_config) {
        keys.push(key);
    }
    if (user_config != null) {
        for (var key in user_config) {
            keys.push(key);
        }
    }
    for (var ii = 0; ii < keys.length; ii++) {
        var key = keys[ii];
        if (user_config != null && user_config[key] != null) {
            new_config[key] = user_config[key];
        } else if (this.default_config[key] != null) {
            new_config[key] = this.default_config[key];
        } else if (this[key] != null) {
            new_config[key] = this[key];
        }
    }
    this.config = new_config;
}

proto.insert_div_before = function (div) {
    div.style.display = 'none';
    if (! div.iframe_hack) {
        this.div.parentNode.insertBefore(div, this.div);
    }
}

proto.toggleCategory = function () {
	var category_tab = document.getElementById ('editpage_cloud_section');
	var category_link = document.getElementById ('wikiwyg_ctrl_lnk_toggleCategory_wikiwyg');
	if (category_tab.style.display == 'none') {
		category_tab.style.display = '';
		category_link.innerHTML = 'Hide category';
	} else {
		category_tab.style.display = 'none';
		category_link.innerHTML = 'Add category';
	}
}

proto.showLicense = function () {

}

/* this 'prototype' is here for purpose */
proto.imageUpload = function (tagOpen, tagClose, sampleText) {
	var re = /http:\/\/([^\/]*)\//g;
	var matches = re.exec(window.location.href);
	if ( !matches ) {
		// TAH: firefox bug: have to do it twice for it to work
		matches = re.exec(window.location.href);
	}
	var domain = matches[1];
	if (imageUploadDialog && imageUploadDialog.open && !imageUploadDialog.closed)
		imageUploadDialog.close();

	/*      check if the user is logged-in
		if not, avoid the road of pain and use AjaxLogin if enabled
	 */
	if ((wgEnableAjaxLogin == 1) && (typeof wgUserName != 'string')) {
		wgAjaxLoginSkipSuccess = true;
		openLogin(null);
		return;
	}
	/* add a guard for Ajax login disabled and reload in this window, as done before */
	if (typeof wgUserName == 'string') {
		imageUploadDialog = window.open("http://" + domain + "/wiki/Special:MiniUpload?type=image", "upload_file", "height=520,width=500,toolbar=no,location=no,resizable=no,top=0,left=0,menubar=0");

	} else {
		window.location.replace ("http://" + domain + "/wiki/Special:Userlogin?returnto=" + wgPageName);
	}
}

proto.insert_div_after = function (div) {
	div.style.display = 'none';
	if (! div.iframe_hack) {
		if (this.div.parentNode.lastchild == this.div) {
			this.div.parentNode.appendChild (div);
		} else {
			this.div.parentNode.insertBefore (div, this.div.nextSibling);
		}
	}
}

// Wikiwyg actions - public methods
proto.saveChanges = function() {
    alert('Wikiwyg.prototype.saveChanges not subclassed');
}

/* indicate action */
proto.toggleThrobber = function (section) {
	return;
	var Throbber = document.getElementById ('ajaxProgressIcon_' + section);
	if (Throbber.style.visibility == 'hidden') {
		Throbber.style.visibility = 'visible';
	} else {
		Throbber.style.visibility = 'hidden';
	}
	return true;
}

proto.editMode = function() { // See IE, below
    currentWikiwyg = this;
    this.current_mode = this.first_mode;
    this.current_mode.initHtml(this.div.innerHTML);
    this.toolbarObject.resetModeSelector();
    this.current_mode.enableThis();
}

proto.displayMode = function() {
    for (var i = 0; i < this.config.modeClasses.length; i++) {
        var mode_class = this.config.modeClasses[i];
        var mode_object = this.modeByName(mode_class);
        mode_object.disableThis();
    }
    this.toolbarObject.disableThis();
    this.div.style.display = 'block';
    this.divHeight = this.div.offsetHeight;
}

proto.switchMode = function(new_mode_key) {
    var new_mode = this.modeByName(new_mode_key);
    var old_mode = this.current_mode;
    var self = this;
    new_mode.enableStarted();
    old_mode.disableStarted();
    old_mode.toHtml(
        function(html) {
            self.previous_mode = old_mode;
            new_mode.fromHtml(html);
            old_mode.disableThis();
            new_mode.enableThis();
            new_mode.enableFinished();
            old_mode.disableFinished();
            self.current_mode = new_mode;
        }
    );
}

proto.modeByName = function(mode_name) {
    return this.mode_objects[mode_name]
}

proto.cancelEdit = function() {
    this.displayMode();
}

proto.initHtml = function (html) {
	this.fromHtml (html);
}

proto.fromHtml = function(html) {
    this.div.innerHTML = html;
}

proto.placeToolbar = function(div) {
    this.insert_div_before(div);
}

proto.placeLowerToolbar = function (div) {
    this.insert_div_after(div);
}

proto.setFirstModeByName = function(mode_name) {
    if (!this.modeByName(mode_name)) {
        die('No mode named ' + mode_name);
}
    this.first_mode = this.modeByName(mode_name);
}

// Class level helper methods
Wikiwyg.unique_id_base = 0;
Wikiwyg.createUniqueId = function() {
    return 'wikiwyg_' + Wikiwyg.unique_id_base++;
}

// This method is deprecated. Use WKWAjax.get and WKWAjax.post.
Wikiwyg.liveUpdate = function(method, url, query, callback) {
    if (method == 'GET') {
        return WKWAjax.get(
            url + '?' + query,
            callback
        );
    }
    if (method == 'POST') {
        return WKWAjax.post(
            url,
            query,
            callback
        );
    }
    throw("Bad method: " + method + " passed to Wikiwyg.liveUpdate");
}

Wikiwyg.htmlUnescape = function(escaped) {
    // thanks to Randal Schwartz for the correct solution to this one
    // (from CGI.pm, CGI::unescapeHTML())
    return escaped.replace(
        /&(.*?);/g,
        function(dummy,s) {
            return s.match(/^amp$/i) ? '&' :
                s.match(/^quot$/i) ? '"' :
                s.match(/^gt$/i) ? '>' :
                s.match(/^lt$/i) ? '<' :
                s.match(/^#(\d+)$/) ?
                    String.fromCharCode(s.replace(/#/,'')) :
                s.match(/^#x([0-9a-f]+)$/i) ?
                    String.fromCharCode(s.replace(/#/,'0')) :
                s
        }
    );
}

Wikiwyg.showById = function(id) {
    document.getElementById(id).style.visibility = 'inherit';
}

Wikiwyg.hideById = function(id) {
    document.getElementById(id).style.visibility = 'hidden';
}

proto.showChanges = function () {
	wikitext = this.current_mode.toWikitext();
	var self = this;
    	WKWAjax.post(
	        fixupRelativeUrl('index.php/' + wgSpecialPrefix + ':PocketDiff') + "&rtitle=" + wgPageName + "&rsection=" + this.section_number ,
	        "text=" + encodeURIComponent(wikitext),
		function (html) {		
			/*	hide the textbox, make return to editing links, allow save and all that stuff 
				remove all pre-existing wrappers
			*/
			self.toolbarObject.rebuildDiffs ();
			var diff_div_wrapper = document.getElementById ('wikiwyg_diff_wrapper');
			if (!diff_div_wrapper) {
				diff_div_wrapper = Wikiwyg.createElementWithAttrs ('div', {id: 'wikiwyg_diff_wrapper'});
			}
			diff_div_wrapper.innerHTML = html;
      			self.insert_div_before(diff_div_wrapper);  								
			self.current_mode.textarea.style.display = 'none';
			diff_div_wrapper.style.display = '';
		}	       	
	    );	
}

Wikiwyg.changeLinksMatching = function(attribute, pattern, func) {
    var links = document.getElementsByTagName('a');
    for (var i = 0; i < links.length; i++) {
        var link = links[i];
        var my_attribute = link.getAttribute(attribute);
        if (my_attribute && my_attribute.match(pattern)) {
            link.setAttribute('href', '#');
            link.onclick = func;
        }
    }
}

Wikiwyg.createElementWithAttrs = function(element, attrs, doc) {
    if (doc == null)
        doc = document;
    return Wikiwyg.create_element_with_attrs(element, attrs, doc);
}

// See IE, below
Wikiwyg.create_element_with_attrs = function(element, attrs, doc) {
    var elem = doc.createElement(element);
    for (name in attrs)
        elem.setAttribute(name, attrs[name]);
    return elem;
}

die = function(e) { // See IE, below
    throw(e);
}

String.prototype.times = function(n) {
    return n ? this + this.times(n-1) : "";
}

String.prototype.ucFirst = function () {
    return this.substr(0,1).toUpperCase() + this.substr(1,this.length);
}

/*==============================================================================
Base class for Wikiwyg classes
 =============================================================================*/
proto = new Subclass('Wikiwyg.Base');

proto.set_config = function(user_config) {
    for (var key in this.config) {
        if (user_config != null && user_config[key] != null)
            this.merge_config(key, user_config[key]);
        else if (this[key] != null)
            this.merge_config(key, this[key]);
        else if (this.wikiwyg.config[key] != null)
            this.merge_config(key, this.wikiwyg.config[key]);
    }
}

proto.merge_config = function(key, value) {
    if (value instanceof Array) {
        this.config[key] = value;
    }
    // cross-browser RegExp object check
    else if (typeof value.test == 'function') {
        this.config[key] = value;
    }
    else if (value instanceof Object) {
        if (!this.config[key])
            this.config[key] = {};
        for (var subkey in value) {
            this.config[key][subkey] = value[subkey];
        }
    }
    else {
        this.config[key] = value;
    }
}

/*==============================================================================
Base class for Wikiwyg Mode classes
 =============================================================================*/
proto = new Subclass('Wikiwyg.Mode', 'Wikiwyg.Base');

proto.enableThis = function() {
    this.div.style.display = 'block';
    this.display_unsupported_toolbar_buttons('none');
    this.wikiwyg.toolbarObject.enableThis();
    this.wikiwyg.div.style.display = 'none';
    if (!wgFullPageEditing && (wgCanonicalSpecialPageName != 'Createpage')) {
    	this.wikiwyg.toolbarObject.summaryDiv.style.display = 'block';
    	this.wikiwyg.toolbarObject.linksDiv.style.display = 'block';
    }
}

proto.display_unsupported_toolbar_buttons = function(display) {
    if (!this.config) return;
    var disabled = this.config.disabledToolbarButtons;
    if (!disabled || disabled.length < 1) return;

    var toolbar_div = this.wikiwyg.toolbarObject.div;
    var toolbar_buttons = toolbar_div.childNodes;
    for (var i in disabled) {
        var action = disabled[i];

        for (var i in toolbar_buttons) {
            var button = toolbar_buttons[i];
            var src = button.src;
            if (!src) continue;

            if (src.match(action)) {
                button.style.display = display;
                break;
            }
        }
    }
}

proto.enableStarted = function() {}
proto.enableFinished = function() {}
proto.disableStarted = function() {}
proto.disableFinished = function() {}

proto.disableThis = function() {
    this.display_unsupported_toolbar_buttons('inline');
    this.div.style.display = 'none';
    if (!wgFullPageEditing) {
	    this.wikiwyg.toolbarObject.summaryDiv.style.display = 'none';
	    this.wikiwyg.toolbarObject.linksDiv.style.display = 'none';
    }
}

proto.process_command = function(command) {
    if (this['do_' + command])
        this['do_' + command](command);
}

proto.enable_keybindings = function() { // See IE
    if (!this.key_press_function) {
        this.key_press_function = this.get_key_press_function();
        this.get_keybinding_area().addEventListener(
            'keypress', this.key_press_function, true
        );
    }
}

proto.get_key_press_function = function() {
    var self = this;
    return function(e) {
        if (! e.ctrlKey) return;
        var key = String.fromCharCode(e.charCode).toLowerCase();
        var command = '';
        switch (key) {
            case 'b': command = 'bold'; break;
            case 'i': command = 'italic'; break;
            case 'u': command = 'underline'; break;
            case 'd': command = 'strike'; break;
            case 'l': command = 'link'; break;
        };

        if (command) {
            e.preventDefault();
            e.stopPropagation();
            self.process_command(command);
        }
    };
}

proto.get_edit_height = function() {
    var height = parseInt(
        this.wikiwyg.divHeight *
        this.config.editHeightAdjustment
    );
    var min = this.config.editHeightMinimum;
    if (this.config.overrideHeightMinimum) {
	return min;
    }
    return height < min
        ? min
        : height;
}

proto.setHeightOf = function(elem) {
    elem.height = this.get_edit_height() + 'px';
}

proto.sanitize_html = function(html) { // See IE, below
    var dom = this.create_dom(html);
    return this.element_transforms(dom, {
        del: {
            name: 'strike',
            attr: { }
        },
        strong: {
            name: 'span',
            attr: { style: 'font-weight: bold;' }
        },
        em: {
            name: 'span',
            attr: { style: 'font-style: italic;' }
        }
    }).innerHTML;
}

proto.create_dom = function(html) {
    var dom = document.createElement('div');
    dom.innerHTML = html;
    return dom;
}

proto.element_transforms = function(dom, el_transforms) {
    for (var orig in el_transforms) {
        var elems = dom.getElementsByTagName(orig);
        if (elems.length == 0) continue;
        for (var i = 0; i < elems.length; i++) {
            var elem = elems[i];
            var replace = el_transforms[orig];
            var new_el =
              Wikiwyg.createElementWithAttrs(replace.name, replace.attr);
            new_el.innerHTML = elem.innerHTML;
            elem.parentNode.replaceChild(new_el, elem);
        }
    }
    return dom;
}

/*==============================================================================
Support for Internet Explorer in Wikiwyg
 =============================================================================*/
if (Wikiwyg.is_ie) {

Wikiwyg.create_element_with_attrs = function(element, attrs, doc) {
     var str = '';
     // Note the double-quotes (make sure your data doesn't use them):
     for (name in attrs)
         str += ' ' + name + '="' + attrs[name] + '"';
     return doc.createElement('<' + element + str + '>');
}

die = function(e) {
    alert(e);
    throw(e);
}

proto = Wikiwyg.Mode.prototype;

proto.enable_keybindings = function() {}

proto.sanitize_html = function(html) {
    var dom = this.create_dom(html);
    return this.element_transforms(dom, {
        del: {
            name: 'strike',
            attr: { }
        }
    }).innerHTML;
}

} // end of global if statement for IE overrides
// BEGIN ../../lib/Wikiwyg/Util.js
/*==============================================================================
This Wikiwyg mode supports a textarea editor with toolbar buttons.

COPYRIGHT:

    Copyright © 2005 Socialtext Corporation
    655 High Street
    Palo Alto, CA 94301 U.S.A.
    All rights reserved.

CHANGES AUTHOR:

    Bartek Łapiński <bartek@wikia.com>

    Copyright © 2007, Wikia Inc.

Wikiwyg is free software.

This library is free software; you can redistribute it and/or modify it
under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation; either version 2.1 of the License, or (at
your option) any later version.

This library is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser
General Public License for more details.

    http://www.gnu.org/copyleft/lesser.txt

 =============================================================================*/

function addEvent(name, func) {
    if (window.addEventListener) {
        name = name.replace(/^on/, '');
        window.addEventListener(name, func, false);
    }
    else if (window.attachEvent) {
        window.attachEvent(name, func);
    }
}

function grepElementsByTag(tag, func) {
    var elements = document.getElementsByTagName(tag);
    var list = [];
    for (var i = 0; i < elements.length; i++) {
        var element = elements[i];
        if (func(element)) {
            list.push(element);
        }
    }
    return list;
}

// WKWgetStyle()
// http://www.robertnyman.com/2006/04/24/get-the-rendered-style-of-an-element/
function WKWgetStyle(oElm, strCssRule) {
    var strValue = "";
    if(document.defaultView && document.defaultView.getComputedStyle){
        strValue = document.defaultView.getComputedStyle(oElm, "").getPropertyValue(strCssRule);
    }
    else if(oElm.currentStyle){
        strCssRule = strCssRule.replace(/\-(\w)/g, function (strMatch, p1){
            return p1.toUpperCase();
        });
        strValue = oElm.currentStyle[strCssRule];
    }
    return strValue;
}
//------------------------------------------------------------------------------

Cookie = {};

Cookie.get = function(name) {
    var cookieStart = document.cookie.indexOf(name + "=")
    if (cookieStart == -1) return null
    var valueStart = document.cookie.indexOf('=', cookieStart) + 1
    var valueEnd = document.cookie.indexOf(';', valueStart);
    if (valueEnd == -1) valueEnd = document.cookie.length
    var val = document.cookie.substring(valueStart, valueEnd);
    return val == null
        ? null
        : unescape(document.cookie.substring(valueStart, valueEnd))
}

Cookie.set = function(name, val, expiration) {
    // Default to 25 year expiry if not specified by the caller.
    if (typeof(expiration) == 'undefined')
        expiration = new Date(
            new Date().getTime() + 25 * 365 * 24 * 60 * 60 * 1000
        )
    var str = name + '=' + escape(val) + '; expires=' + expiration.toGMTString()
    document.cookie = str;
}

Cookie.del = function(name) {
    Cookie.set(name, '', new Date(new Date().getTime() - 1));
}

//------------------------------------------------------------------------------

// XXX Move Wait into Wikiwyg.Util
if ( typeof Wait == 'undefined' ) {
    Wait = {}
}

Wait.VERSION = 0.01;
Wait.EXPORT  = [ 'wait' ];
Wait.EXPORT_TAGS = { ':all': Wait.EXPORT };

Wait.interval = 300;

Wait.wait = function(arg1, arg2, arg3, arg4) {
    if (   typeof arg1 == 'function'
        && typeof arg2 == 'function'
        && typeof arg3 == 'function'
        ) {
            return Wait._wait3(arg1, arg2, arg3, arg4);
        }

    if (   typeof arg1 == 'function'
        && typeof arg2 == 'function'
        ) {
            return Wait._wait2(arg1, arg2, arg3);
        }
}

Wait._wait2 = function(test, callback, max) {
    Wait._wait3(test, callback, function(){}, max);
}

Wait._wait3 = function(test, callback, failed_callback ,max) {
    var func = function() {
        var interval = Wait.interval;
        var time_elapsed = 0;
        var intervalId;
        var check_and_callback = function () {
            if ( test() ) {
                callback();
                clearInterval(intervalId);
            }
            time_elapsed += interval;
            if ( typeof max == 'number' ) {
                if ( time_elapsed >= max ) {
                    if ( typeof failed_callback == 'function')
                        failed_callback();
                    clearInterval(intervalId);
                }
            }
        }
        intervalId = setInterval(check_and_callback, interval );
    }
    func();
}

// Manually export the wait() function.
window.wait = Wait.wait;


//------------------------------------------------------------------------------
// Ajax support
//------------------------------------------------------------------------------
if (! this.WKWAjax) WKWAjax = {};

WKWAjax.get = function(url, callback) {
    var req = new XMLHttpRequest();
    req.open('GET', url, Boolean(callback));
    return WKWAjax._send(req, null, callback);
}

WKWAjax.post = function(url, data, callback) {
    var req = new XMLHttpRequest();
    req.open('POST', url, Boolean(callback));
    req.setRequestHeader(
        'Content-Type',
        'application/x-www-form-urlencoded'
    );
    return WKWAjax._send(req, data, callback);
}

WKWAjax._send = function(req, data, callback) {
    if (callback) {
        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                if(req.status == 200)
                    callback(req.responseText);
            }
        };
    }
    req.send(data);
    if (!callback) {
        if (req.status != 200)
            throw('Request for "' + url +
                  '" failed with status: ' + req.status);
        return req.responseText;
    }
}

//------------------------------------------------------------------------------
// Cross-Browser XMLHttpRequest v1.1
//------------------------------------------------------------------------------
/*
Emulate Gecko 'XMLHttpRequest()' functionality in IE and Opera. Opera requires
the Sun Java Runtime Environment <http://www.java.com/>.

by Andrew Gregory
http://www.scss.com.au/family/andrew/webdesign/xmlhttprequest/

This work is licensed under the Creative Commons Attribution License. To view a
copy of this license, visit http://creativecommons.org/licenses/by/1.0/ or send
a letter to Creative Commons, 559 Nathan Abbott Way, Stanford, California 94305,
USA.
*/

// IE support
if (window.ActiveXObject && !window.XMLHttpRequest) {
  window.XMLHttpRequest = function() {
    return new ActiveXObject((navigator.userAgent.toLowerCase().indexOf('msie 5') != -1) ? 'Microsoft.XMLHTTP' : 'Msxml2.XMLHTTP');
  };
}

// Opera support
if (window.opera && !window.XMLHttpRequest) {
  window.XMLHttpRequest = function() {
    this.readyState = 0; // 0=uninitialized,1=loading,2=loaded,3=interactive,4=complete
    this.status = 0; // HTTP status codes
    this.statusText = '';
    this._headers = [];
    this._aborted = false;
    this._async = true;
    this.abort = function() {
      this._aborted = true;
    };
    this.getAllResponseHeaders = function() {
      return this.getAllResponseHeader('*');
    };
    this.getAllResponseHeader = function(header) {
      var ret = '';
      for (var i = 0; i < this._headers.length; i++) {
        if (header == '*' || this._headers[i].h == header) {
          ret += this._headers[i].h + ': ' + this._headers[i].v + '\n';
        }
      }
      return ret;
    };
    this.setRequestHeader = function(header, value) {
      this._headers[this._headers.length] = {h:header, v:value};
    };
    this.open = function(method, url, async, user, password) {
      this.method = method;
      this.url = url;
      this._async = true;
      this._aborted = false;
      if (arguments.length >= 3) {
        this._async = async;
      }
      if (arguments.length > 3) {
        // user/password support requires a custom Authenticator class
        opera.postError('XMLHttpRequest.open() - user/password not supported');
      }
      this._headers = [];
      this.readyState = 1;
      if (this.onreadystatechange) {
        this.onreadystatechange();
      }
    };
    this.send = function(data) {
      if (!navigator.javaEnabled()) {
        alert("XMLHttpRequest.send() - Java must be installed and enabled.");
        return;
      }
      if (this._async) {
        setTimeout(this._sendasync, 0, this, data);
        // this is not really asynchronous and won't execute until the current
        // execution context ends
      } else {
        this._sendsync(data);
      }
    }
    this._sendasync = function(req, data) {
      if (!req._aborted) {
        req._sendsync(data);
      }
    };
    this._sendsync = function(data) {
      this.readyState = 2;
      if (this.onreadystatechange) {
        this.onreadystatechange();
      }
      // open connection
      var url = new java.net.URL(new java.net.URL(window.location.href), this.url);
      var conn = url.openConnection();
      for (var i = 0; i < this._headers.length; i++) {
        conn.setRequestProperty(this._headers[i].h, this._headers[i].v);
      }
      this._headers = [];
      if (this.method == 'POST') {
        // POST data
        conn.setDoOutput(true);
        var wr = new java.io.OutputStreamWriter(conn.getOutputStream());
        wr.write(data);
        wr.flush();
        wr.close();
      }
      // read response headers
      // NOTE: the getHeaderField() methods always return nulls for me :(
      var gotContentEncoding = false;
      var gotContentLength = false;
      var gotContentType = false;
      var gotDate = false;
      var gotExpiration = false;
      var gotLastModified = false;
      for (var i = 0;; i++) {
        var hdrName = conn.getHeaderFieldKey(i);
        var hdrValue = conn.getHeaderField(i);
        if (hdrName == null && hdrValue == null) {
          break;
        }
        if (hdrName != null) {
          this._headers[this._headers.length] = {h:hdrName, v:hdrValue};
          switch (hdrName.toLowerCase()) {
            case 'content-encoding': gotContentEncoding = true; break;
            case 'content-length'  : gotContentLength   = true; break;
            case 'content-type'    : gotContentType     = true; break;
            case 'date'            : gotDate            = true; break;
            case 'expires'         : gotExpiration      = true; break;
            case 'last-modified'   : gotLastModified    = true; break;
          }
        }
      }
      // try to fill in any missing header information
      var val;
      val = conn.getContentEncoding();
      if (val != null && !gotContentEncoding) this._headers[this._headers.length] = {h:'Content-encoding', v:val};
      val = conn.getContentLength();
      if (val != -1 && !gotContentLength) this._headers[this._headers.length] = {h:'Content-length', v:val};
      val = conn.getContentType();
      if (val != null && !gotContentType) this._headers[this._headers.length] = {h:'Content-type', v:val};
      val = conn.getDate();
      if (val != 0 && !gotDate) this._headers[this._headers.length] = {h:'Date', v:(new Date(val)).toUTCString()};
      val = conn.getExpiration();
      if (val != 0 && !gotExpiration) this._headers[this._headers.length] = {h:'Expires', v:(new Date(val)).toUTCString()};
      val = conn.getLastModified();
      if (val != 0 && !gotLastModified) this._headers[this._headers.length] = {h:'Last-modified', v:(new Date(val)).toUTCString()};
      // read response data
      var reqdata = '';
      var stream = conn.getInputStream();
      if (stream) {
        var reader = new java.io.BufferedReader(new java.io.InputStreamReader(stream));
        var line;
        while ((line = reader.readLine()) != null) {
          if (this.readyState == 2) {
            this.readyState = 3;
            if (this.onreadystatechange) {
              this.onreadystatechange();
            }
          }
          reqdata += line + '\n';
        }
        reader.close();
        this.status = 200;
        this.statusText = 'OK';
        this.responseText = reqdata;
        this.readyState = 4;
        if (this.onreadystatechange) {
          this.onreadystatechange();
        }
        if (this.onload) {
          this.onload();
        }
      } else {
        // error
        this.status = 404;
        this.statusText = 'Not Found';
        this.responseText = '';
        this.readyState = 4;
        if (this.onreadystatechange) {
          this.onreadystatechange();
        }
        if (this.onerror) {
          this.onerror();
        }
      }
    };
  };
}
// ActiveXObject emulation
if (!window.ActiveXObject && window.XMLHttpRequest) {
  window.ActiveXObject = function(type) {
    switch (type.toLowerCase()) {
      case 'microsoft.xmlhttp':
      case 'msxml2.xmlhttp':
        return new XMLHttpRequest();
    }
    return null;
  };
}


//------------------------------------------------------------------------------
// JSON Support
//------------------------------------------------------------------------------

/*
Copyright © 2005 JSON.org
*/
var JSON = function () {
    var m = {
            '\b': '\\b',
            '\t': '\\t',
            '\n': '\\n',
            '\f': '\\f',
            '\r': '\\r',
            '"' : '\\"',
            '\\': '\\\\'
        },
        s = {
            'boolean': function (x) {
                return String(x);
            },
            number: function (x) {
                return isFinite(x) ? String(x) : 'null';
            },
            string: function (x) {
                if (/["\\\x00-\x1f]/.test(x)) {
                    x = x.replace(/([\x00-\x1f\\"])/g, function(a, b) {
                        var c = m[b];
                        if (c) {
                            return c;
                        }
                        c = b.charCodeAt();
                        return '\\u00' +
                            Math.floor(c / 16).toString(16) +
                            (c % 16).toString(16);
                    });
                }
                return '"' + x + '"';
            },
            object: function (x) {
                if (x) {
                    var a = [], b, f, i, l, v;
                    if (x instanceof Array) {
                        a[0] = '[';
                        l = x.length;
                        for (i = 0; i < l; i += 1) {
                            v = x[i];
                            f = s[typeof v];
                            if (f) {
                                v = f(v);
                                if (typeof v == 'string') {
                                    if (b) {
                                        a[a.length] = ',';
                                    }
                                    a[a.length] = v;
                                    b = true;
                                }
                            }
                        }
                        a[a.length] = ']';
                    } else if (x instanceof Object) {
                        a[0] = '{';
                        for (i in x) {
                            v = x[i];
                            f = s[typeof v];
                            if (f) {
                                v = f(v);
                                if (typeof v == 'string') {
                                    if (b) {
                                        a[a.length] = ',';
                                    }
                                    a.push(s.string(i), ':', v);
                                    b = true;
                                }
                            }
                        }
                        a[a.length] = '}';
                    } else {
                        return;
                    }
                    return a.join('');
                }
                return 'null';
            }
        };
    return {
        copyright: '© 2005 JSON.org',
        license: 'http://www.crockford.com/JSON/license.html',
        stringify: function (v) {
            var f = s[typeof v];
            if (f) {
                v = f(v);
                if (typeof v == 'string') {
                    return v;
                }
            }
            return null;
        },
        parse: function (text) {
            try {
                return !(/[^,:{}\[\]0-9.\-+Eaeflnr-u \n\r\t]/.test(
                        text.replace(/"(\\.|[^"\\])*"/g, ''))) &&
                    eval('(' + text + ')');
            } catch (e) {
                return false;
            }
        }
    };
}();
// BEGIN ../../lib/Wikiwyg/Debug.js
/*==============================================================================
This Wikiwyg mode supports a textarea editor with toolbar buttons.

COPYRIGHT:

    Copyright © 2005 Socialtext Corporation
    655 High Street
    Palo Alto, CA 94301 U.S.A.
    All rights reserved.

CHANGES AUTHOR:

    Bartek Łapiński <bartek@wikia.com>

    Copyright © 2007, Wikia Inc.


Wikiwyg is free software.

This library is free software; you can redistribute it and/or modify it
under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation; either version 2.1 of the License, or (at
your option) any later version.

This library is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser
General Public License for more details.

    http://www.gnu.org/copyleft/lesser.txt

 =============================================================================*/

// Like alert but uses confirm and throw in case you are looped
function XXX(msg) {
    if (! confirm(msg))
        throw("terminated...");
}

// A JSON dumper that uses XXX
function JJJ(obj) {
    XXX(JSON.stringify(obj));
}


// A few handy debugging functions
(function() {

var klass = Debug = function() {};

klass.sort_object_keys = function(o) {
    var a = [];
    for (p in o) a.push(p);
    return a.sort();
}

klass.dump_keys = function(o) {
    var a = klass.sort_object_keys(o);
    var str='';
    for (p in a)
        str += a[p] + "\t";
    XXX(str);
}

klass.dump_object_into_screen = function(o) {
    var a = klass.sort_object_keys(o);
    var str='';
    for (p in a) {
        var i = a[p];
        try {
            str += a[p] + ': ' + o[i] + '\n';
        } catch(e) {
            // alert('Died on key "' + i + '":\n' + e.message);
        }
    }
    document.write('<xmp>' + str + '</xmp>');
}

})();

// BEGIN ../../lib/Wikiwyg/Toolbar.js
/*==============================================================================
This Wikiwyg class provides toolbar support

COPYRIGHT:

    Copyright © 2005 Socialtext Corporation
    655 High Street
    Palo Alto, CA 94301 U.S.A.
    All rights reserved.

CHANGES AUTHOR:

    Bartek Łapiński <bartek@wikia.com>

    Copyright © 2007, Wikia Inc.

Wikiwyg is free software.

This library is free software; you can redistribute it and/or modify it
under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation; either version 2.1 of the License, or (at
your option) any later version.

This library is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser
General Public License for more details.

    http://www.gnu.org/copyleft/lesser.txt

 =============================================================================*/

proto = new Subclass('Wikiwyg.Toolbar', 'Wikiwyg.Base');
proto.classtype = 'toolbar';

proto.config = {
    divId: null,
    imagesLocation: 'images/',
    imagesExtension: '.gif',
    controlLayout: [
        'save', 'cancel', 'mode_selector', '/',
        'h1', 'h2', 'h3', 'h4', 'p', 'pre', '|',
        'bold', 'italic', 'underline', 'strike', '|',
        'link', 'hr', '|',
        'ordered', 'unordered', '|',
        'indent', 'outdent', '|',
        'table', '|', 'timestamp' ,
        'help'
    ],
    styleSelector: [
        'label', 'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'pre'
    ],

    controlLabels: {
        save: wgSaveCaption ,
        cancel: wgCancelCaption ,
        bold: 'Bold (Ctrl+b)',
        italic: 'Italic (Ctrl+i)',
        underline: 'Underline (Ctrl+u)',
	insertimage: wgInsertImageCaption ,
	youtube: 'Add YouTube Video' ,
	wikify: 'Wikify' ,
        strike: 'Strike Through (Ctrl+d)',
        hr: wgHrTip ,
        ordered: 'Numbered List',
        unordered: 'Bulleted List',
        indent: 'More Indented',
        outdent: 'Less Indented',
        help: 'About Wikiwyg',
	timestamp: wgTimestampTip ,
        label: '[Style]',
        p: 'Normal Text',
        pre: 'Preformatted',
        h1: 'Heading 1',
        h2: 'Heading 2',
        h3: 'Heading 3',
        h4: 'Heading 4',
        h5: 'Heading 5',
        h6: 'Heading 6',
        link: wgIntlinkTip ,
	www: wgExtlinkTip ,
        unlink: 'Remove Linkedness',
        table: 'Create Table'
    }
};

proto.initializeObject = function(section_number) {
    if (this.config.divId) {
        this.div = document.getElementById(this.config.divId);
    }
    else {
        this.div = Wikiwyg.createElementWithAttrs(
            'div', {
                'class': 'wikiwyg_toolbar',
                id: 'wikiwyg_toolbar_' + section_number
            }
        );
    }
    this.section_number = section_number;
    var config = this.config;

    /* add two containers for two sets of controls */
    var left_div = Wikiwyg.createElementWithAttrs(
	'div', {
		id: 'wikiwyg_toolbar_left' + section_number
        }
    );

    var right_div = Wikiwyg.createElementWithAttrs(
	'div', {
		id: 'wikiwyg_toolbar_right' + section_number ,
		'style': 'float: right'
        }
    );

    this.div.appendChild (right_div);   
    this.div.appendChild (left_div);
    this.addControls (config, left_div, right_div);
}

proto.addControls = function (config, left_div, right_div) {
    for (var i = 0; i < config.controlLayout.length; i++) {
        var action = config.controlLayout[i];
        var label = config.controlLabels[action];
        if (action == 'save') {
            if (right_div != '') {
	            this.addControlItem(label, 'saveChanges', right_div, '');
	    }
	}
        else if (action == 'cancel') {
	    if (right_div != '') {
            	    this.addControlItem(label, 'cancelEdit', right_div, '');
 	    }
	}
        else if (action == 'mode_selector') {
	    if (right_div != '') {	    
            	    this.addFixedModeSelector ('', right_div, 'Wikitext', '');
	    }
	}
	else if (action == 'insertimage')
		this.addControlItem(label, "imageUpload('[[Image:',']]')", left_div, '');
        else if (action == 'selector')
            this.add_styles();
        else if (action == 'help')
            this.addHelpItem (left_div);
        else if (action == '|l')
            this.add_separator (left_div);
	else if (action == '|r') {
             if (right_div != '') {
	    	this.add_separator (right_div);
	     }
	}
        else if (action == '/')
            this.add_break (left_div);
	else if (action == '[') {
	     if (right_div != '') {
	    	this.add_text ('[', right_div) ;
	     }
	}
	else if (action == ']') {
	     if (right_div != '') {
	    	this.add_text (']', right_div);
	     }
	}
        else
            this.add_button (action, label, left_div);
    }
}

/* rebuild the toolbar for preview mode mostly */
proto.changeMode = function () {
        this.rebuild ();
}

/* divided for more convenience */
proto.placeSummarySection = function () {
      this.summaryDiv = Wikiwyg.createElementWithAttrs (
            'div', {
                'class': '',
                id: 'wikiwyg_summary_' + this.section_number ,
		'style': 'clear'

            }
        );

      /* place bowels of the summary here */
      var summaryInput = Wikiwyg.createElementWithAttrs(
	    'input', { 
	   	'type': 'text' ,
		'value': '',
		'name': 'wpSummary_' + this.section_number ,
		id: 'wpSummary_' + this.section_number ,
		'style': 'min-width:300px; max-width:600px'
	    }
      );

      var edit_table = document.createElement ('table');
      var first_row = document.createElement ('tr');
      var edit_td1 = Wikiwyg.createElementWithAttrs ('td', {'class': 'editpage-header'} );
      var edit_td2 = document.createElement ('td');

      edit_td1.appendChild (document.createTextNode (wgSummaryCaption + ':') );
      edit_td2.appendChild (summaryInput);

      /* for logged in, create two additional checkboxes */
      if ((typeof wgUserName == 'string') && (wgCanonicalSpecialPageName != "Createpage") ) {
	      var newMinorInput = Wikiwyg.createElementWithAttrs ('input',
			      {'id': 'wpMinoredit_' + this.section_number ,
			      'name': 'wpMinoredit' + this.section_number ,
			      'type': 'checkbox' ,
			      'value': '1' ,
			      'accesskey': 'i'
			      });

	      var newMinorInputLabel = Wikiwyg.createElementWithAttrs ('label',
			      {'for': 'wpMinoredit_' + this.section_number ,
			      'accesskey': 'i' ,
			      'title': '' ,
			      'class': 'no-float'
			      });

	      newMinorInputLabel.innerHTML = wgMinoreditCaption;

	      var newWatchthisInput = Wikiwyg.createElementWithAttrs ('input',
			      {'id': 'wpWatchthis_' + this.section_number ,
			      'name': 'wpWatchthis_' + this.section_number ,
			      'type': 'checkbox' ,
			      'value': '1' ,
			      'accesskey': 'w',
			      'checked': 'checked'
			      });

	      var newWatchthisInputLabel = Wikiwyg.createElementWithAttrs ('label',
			      {'for': 'wpWatchthis_' + this.section_number ,
			      'accesskey': 'w' ,
			      'title': '' ,
			      'class': 'no-float'
			      });

	      newWatchthisInputLabel.innerHTML = wgWatchthisCaption;
   	      edit_td2.appendChild (newMinorInput);
	      edit_td2.appendChild (newMinorInputLabel);

	      edit_td2.appendChild (newWatchthisInput);
	      edit_td2.appendChild (newWatchthisInputLabel);
      }


      first_row.appendChild (edit_td1);
      first_row.appendChild (edit_td2);
      edit_table.appendChild (first_row);
      this.summaryDiv.appendChild (edit_table);
}

proto.placeLowerLinksSection = function () {
      /* two more divs, one will include real edit summary, the second will hold checkboxes  */
      this.linksDiv = Wikiwyg.createElementWithAttrs (
            'div', {
                'class': 'wikiwyg_toolbar' ,
                id: 'wikiwyg_links_' + this.section_number
            }
        );

      /* left and right, one floats, one not  */ 
      var linksLeft = Wikiwyg.createElementWithAttrs (
            'div', {
                'class': '' ,
                id: 'wikiwyg_links_l_' + this.section_number
            }
        );

      var linksRight = Wikiwyg.createElementWithAttrs (
            'div', {
                'class': '' ,
                id: 'wikiwyg_links_r_' + this.section_number ,
		'style': 'float: right'
            }
        );

      this.linksDiv.appendChild (linksRight);
      this.linksDiv.appendChild (linksLeft);     
      if (wgFullPageEditing == true) {
	      this.addCategoryItem (linksLeft);
	      this.add_separator (linksLeft);
      }
      this.addControlItem ('Show changes', 'showChanges', linksLeft, '');
      this.add_separator (linksLeft);
      this.addControlItem ('License', 'showLicense',  linksLeft, '');
      
      this.add_text ('[', linksRight);
      this.addFixedModeSelector ('', linksRight, 'Wikitext', 'lower');
      this.add_separator (linksRight);
      this.addControlItem (wgSaveCaption,'saveChanges', linksRight, 'lower');
      this.add_separator (linksRight);
      this.addControlItem(wgCancelCaption, 'cancelEdit', linksRight, 'lower');
      this.add_text (']', linksRight);
}

/* let's do it here, then apply this within the initialization process */
proto.placeLowerToolbar = function () {
	this.placeSummarySection();
	this.placeLowerLinksSection();
}

proto.addCategoryItem = function (div) {
	/*	if categories are shown, procure a link to hide them, if not,
		procure a link to show them
	*/
	var cloud_section = document.getElementById ('editpage_cloud_section');
	if (!cloud_section) {
		/* temporary placeholder to avoid error */
		this.addControlItem ('Add category', 'toggleCategory', div, '');
		return;
	}
	if (cloud_section.style.display == 'none' ) {
		this.addControlItem ('Add category', 'toggleCategory', div, '');
	} else {
		this.addControlItem ('Hide category', 'toggleCategory', div, '');	
	}
}

proto.enableThis = function() {
    this.div.style.display = 'block';
}

proto.disableThis = function() {
    this.div.style.display = 'none';
}

proto.rebuild = function () {   
    /* depending on current mode, mangle the toolbar or rebuild it */
    var left_links = document.getElementById ('wikiwyg_toolbar_left' + this.section_number);
    var lower_left_links = document.getElementById ('wikiwyg_links_l_' + this.section_number);
    var right_mode = document.getElementById ('wikiwyg_ctrl_lnk_preview' + this.section_number );
    var right_lower_mode = document.getElementById ('wikiwyg_ctrl_lnk_lower_preview' + this.section_number );

    left_links.innerHTML = '';
    lower_left_links.innerHTML = '';

    if (this.wikiwyg.current_mode.classname.match(/(Wikitext)/)) {
	    this.addFixedModeSelector ('Return to editing', left_links, 'Preview', '');
	    this.addFixedModeSelector ('Return to editing', lower_left_links, 'Preview', 'lower');
	    right_mode.innerHTML = wgEditCaption.toLowerCase();
	    right_lower_mode.innerHTML = wgEditCaption.toLowerCase();
	    this.updateModeSelector (right_mode, 'Preview');
	    this.updateModeSelector (right_lower_mode, 'Preview');
    } else {
    	    /* rebuild the toolbar */	
	    this.addControls (this.config, left_links, '');
      	    this.addControlItem ('Show changes', 'showChanges', lower_left_links, '');
            this.add_separator (lower_left_links);
            this.addControlItem ('License', 'showLicense',  lower_left_links, '');
	    Event.addListener ('wikiwyg_ctrl_lnk_showLicense_' + this.section_number, 'click', YAHOO.Wikia.Wikiwyg.showLicensePanel);
	    right_mode.innerHTML = wgPreviewCaption.toLowerCase();
	    right_lower_mode.innerHTML = wgPreviewCaption.toLowerCase();
	    this.updateModeSelector (right_mode, 'Wikitext');
	    this.updateModeSelector (right_lower_mode, 'Wikitext');
    }
}

proto.rebuildDiffs = function () {   
    /* depending on showing/not showing Diffs, mangle the toolbar or rebuild it */
    var left_links = document.getElementById ('wikiwyg_toolbar_left' + this.section_number);
    var lower_left_links = document.getElementById ('wikiwyg_links_l_' + this.section_number);
    var right_mode = document.getElementById ('wikiwyg_ctrl_lnk_preview' + this.section_number );
    var right_lower_mode = document.getElementById ('wikiwyg_ctrl_lnk_lower_preview' + this.section_number );
    var diff_div = document.getElementById ('wikiwyg_diff_wrapper');
    left_links.innerHTML = '';
    lower_left_links.innerHTML = '';
    if (!diff_div) {
	    this.addFakeModeSelector ('Return to editing', left_links);
	    this.addFakeModeSelector ('Return to editing', lower_left_links);
	    /* todo change caption for Preview button to Edit plus switch functionality */
	    right_mode.innerHTML = wgEditCaption.toLowerCase();
	    right_lower_mode.innerHTML = wgEditCaption.toLowerCase();
	    this.updateFakeModeSelector (right_mode);
	    this.updateFakeModeSelector (right_lower_mode);
    } else {
    	    /* rebuild the toolbar */	
	    this.addControls (this.config, left_links, '');      	  	
      	    this.addControlItem ('Show changes', 'showChanges', lower_left_links, '');
            this.add_separator (lower_left_links);
            this.addControlItem ('License', 'showLicense',  lower_left_links, '');
	    Event.addListener ('wikiwyg_ctrl_lnk_showLicense_' + this.section_number, 'click', YAHOO.Wikia.Wikiwyg.showLicensePanel);
	    right_mode.innerHTML = wgPreviewCaption.toLowerCase();
	    right_lower_mode.innerHTML = wgPreviewCaption.toLowerCase();
	    this.updateModeSelector (right_mode, 'Wikitext');
	    this.updateModeSelector (right_lower_mode, 'Wikitext');
      	    this.wikiwyg.current_mode.textarea.style.display = '';
	    diff_div.parentNode.removeChild (diff_div);
    }
}

proto.make_button = function(type, label) {
    var base = this.config.imagesLocation;
    var ext = this.config.imagesExtension;
    return Wikiwyg.createElementWithAttrs(
        'img', {
            'class': 'wikiwyg_button',
            onmouseup: "this.style.border='1px outset';",
            onmouseover: "this.style.border='1px outset';",
            onmouseout:
                "this.style.borderColor=this.style.backgroundColor;" +
                "this.style.borderStyle='solid';",
            onmousedown:     "this.style.border='1px inset';",
            alt: label,
            title: label,
            src: base + type + ext
        }
    );
}

proto.add_button = function(type, label, div) {
    var img = this.make_button(type, label);
    var self = this;
    img.onclick = function() {
        self.wikiwyg.current_mode.process_command(type);
    };
    div.appendChild(img);
}

proto.addHelpItem = function(div) {
    	var span = Wikiwyg.createElementWithAttrs(
        'span', { 'class': 'wikiwyg_control_link' }
    );

    var link = Wikiwyg.createElementWithAttrs(
    	'a', {
            target: 'wikiwyg_button',
            href: 'http://www.wikia.com/wiki/Help:Tutorial_2'	
	}
    );
    link.appendChild(document.createTextNode(wgHelpCaption));
    span.appendChild(link);
    div.appendChild(span);
}

proto.add_text = function (text, div) {
	div.appendChild(
		document.createTextNode(text)
	);
}

proto.add_separator = function (div) {
    var base = this.config.imagesLocation;
    var ext = this.config.imagesExtension;
    div.appendChild(
        Wikiwyg.createElementWithAttrs(
            'img', {
                'class': 'wikiwyg_separator',
                alt: ' | ',
                title: '',
                src: base + 'separator' + ext
            }
        )
    );
}

proto.addControlItem = function (text, method, div, place) {
    var span = Wikiwyg.createElementWithAttrs(
        'span', { 'class': 'wikiwyg_control_link' }
    );

    if (place != '') {
	place = place + '_';		
    }

    var link = Wikiwyg.createElementWithAttrs(
	    	'a', { href: '#', id: 'wikiwyg_ctrl_lnk_' + method + '_' + place + this.section_number }
    );

    link.appendChild(document.createTextNode(text));
    span.appendChild(link);

    var self = this;

    if ( method.match (/\(/) ) {
	var add = '';
    } else {
	var add = '()';
    }
    link.onclick = function() { eval('self.wikiwyg.' + method + add); return false };

    div.appendChild(span);
}

proto.addFixedModeSelector = function (text, div, mode, place) {
    var span = Wikiwyg.createElementWithAttrs(
        'span', { 'class': 'wikiwyg_control_link' }
    );
    var class_name = this.wikiwyg.first_mode.classname; 
    var second_mode_short = '';
    var second_mode_full = '';
    /*	for now, extract the _other_ mode classname
    	in our case, it's preview
	but let's not be _too_ sure about it...
	*/
    var mode_regex = new RegExp(mode);

    for (var i = 0; i < this.wikiwyg.config.modeClasses.length; i++) {        
        var class_name = this.wikiwyg.config.modeClasses[i];
	if (!class_name.match (mode_regex)) {
	       second_mode_short = this.wikiwyg.mode_objects[class_name].modeDescription.toLowerCase();
	       second_mode_full = class_name;
	}
    }
    if (place != '') {
	place = place + '_';		
    }

    var link = Wikiwyg.createElementWithAttrs(
    	'a', { href: '#', id: 'wikiwyg_ctrl_lnk_' + place + second_mode_short + this.section_number }
    );
    if (text == '') {
	    link.appendChild (document.createTextNode (second_mode_short));
    } else {
    	    link.appendChild (document.createTextNode (text));
    }
    span.appendChild(link);

    var self = this;
    link.onclick = function() { self.wikiwyg.switchMode (second_mode_full); return false };
    div.appendChild(span);
}

proto.updateFakeModeSelector = function (link) {
    	var self = this;
	/* todo track this properly */
	link.onclick = function() { self.rebuildDiffs (); return false };
}

proto.updateModeSelector = function (link, mode) {
    var second_mode_short = '';
    var second_mode_full = '';
    var mode_regex = new RegExp(mode);

    for (var i = 0; i < this.wikiwyg.config.modeClasses.length; i++) {        
        var class_name = this.wikiwyg.config.modeClasses[i];
	if (!class_name.match (mode_regex)) {
	       second_mode_short = this.wikiwyg.mode_objects[class_name].modeDescription.toLowerCase();
	       second_mode_full = class_name;
	}
    }

    var self = this;
    link.onclick = function() { self.wikiwyg.switchMode (second_mode_full); return false };
}

proto.resetModeSelector = function() {
    if (this.firstModeRadio) {
        var temp = this.firstModeRadio.onclick;
        this.firstModeRadio.onclick = null;
        this.firstModeRadio.click();
        this.firstModeRadio.onclick = temp;
    }
}

proto.addFakeModeSelector = function (text, div, mode) {
    var span = Wikiwyg.createElementWithAttrs(
        'span', { 'class': 'wikiwyg_control_link' }
    );
    var class_name = this.wikiwyg.first_mode.classname; 
    var second_mode_short = '';
    var second_mode_full = '';

    /* todo there are *two* buttons - make each have unique div */
    var link = Wikiwyg.createElementWithAttrs(
    	'a', { href: '#', id: 'wikiwyg_ctrl_lnk_ReturnFromDiff'}
    );
    if (text == '') {
	    link.appendChild (document.createTextNode (second_mode_short));
    } else {
    	    link.appendChild (document.createTextNode (text));
    }
    span.appendChild(link);

    var self = this;
    link.onclick = function() { self.rebuildDiffs (); return false };
    div.appendChild(span);
}

proto.resetModeSelector = function() {
    if (this.firstModeRadio) {
        var temp = this.firstModeRadio.onclick;
        this.firstModeRadio.onclick = null;
        this.firstModeRadio.click();
        this.firstModeRadio.onclick = temp;
    }
}


proto.addModeSelector = function() {
    var span = document.createElement('span');

    var radio_name = Wikiwyg.createUniqueId();
    for (var i = 0; i < this.wikiwyg.config.modeClasses.length; i++) {
        var class_name = this.wikiwyg.config.modeClasses[i];
        var mode_object = this.wikiwyg.mode_objects[class_name];

        var radio_id = Wikiwyg.createUniqueId();
        var radio = Wikiwyg.createElementWithAttrs(
            'input', {
                type: 'radio' ,
                name: radio_name ,
                id: radio_id ,
                value: mode_object.classname
            }
        );
        if (!this.firstModeRadio)
            this.firstModeRadio = radio;

        var self = this;

        radio.onclick = function() {
            self.wikiwyg.switchMode(this.value);
        };

        var label = Wikiwyg.createElementWithAttrs(
            'label', { 'for': radio_id }
        );
        label.appendChild(document.createTextNode(mode_object.modeDescription));

        span.appendChild(radio);
        span.appendChild(label);
    }
    this.div.appendChild(span);
}

proto.add_break = function (div) {
    div.appendChild(document.createElement('br'));
}

proto.add_styles = function (div) {
    var options = this.config.styleSelector;
    var labels = this.config.controlLabels;

    this.styleSelect = Wikiwyg.createElementWithAttrs(
        'select', {
            'class': 'wikiwyg_selector'
        }
    );

    for (var i = 0; i < options.length; i++) {
        value = options[i];
        var option = Wikiwyg.createElementWithAttrs(
            'option', { 'value': value }
        );
        option.appendChild(document.createTextNode(labels[value]));
        this.styleSelect.appendChild(option);
    }
    var self = this;
    this.styleSelect.onchange = function() {
        self.set_style(this.value)
    };
    div.appendChild(this.styleSelect);
}

proto.set_style = function(style_name) {
    var idx = this.styleSelect.selectedIndex;
    // First one is always a label
    if (idx != 0)
        this.wikiwyg.current_mode.process_command(style_name);
    this.styleSelect.selectedIndex = 0;
}
// BEGIN ../../lib/Wikiwyg/Preview.js
/*==============================================================================
This Wikiwyg mode supports a preview of current changes

COPYRIGHT:

    Copyright © 2005 Socialtext Corporation
    655 High Street
    Palo Alto, CA 94301 U.S.A.
    All rights reserved.

CHANGES AUTHOR:

    Bartek Łapiński <bartek@wikia.com>

    Copyright © 2007, Wikia Inc.

Wikiwyg is free software.

This library is free software; you can redistribute it and/or modify it
under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation; either version 2.1 of the License, or (at
your option) any later version.

This library is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser
General Public License for more details.

    http://www.gnu.org/copyleft/lesser.txt

 =============================================================================*/

proto = new Subclass('Wikiwyg.Preview', 'Wikiwyg.Mode');

proto.classtype = 'preview';
proto.modeDescription = wgPreviewCaption;

proto.config = {
    divId: null
}

proto.initializeObject = function() {
    if (this.config.divId)
        this.div = document.getElementById(this.config.divId);
    else
        this.div = document.createElement('div');
    // XXX Make this a config option.
    this.div.id = 'wikiwyg_preview_area';
    this.div.style.backgroundColor = 'lightyellow';
    this.div.style.padding = '4px 4px 4px 4px';
    this.div.style.border = '1px solid #cccccc';
}

proto.initHtml = function (html) {
    this.fromHtml(html);
}

proto.fromHtml = function(html) {
    this.div.innerHTML = html;
}

proto.toHtml = function(func) {
    func(this.div.innerHTML);
}

proto.disableStarted = function() {
    this.wikiwyg.divHeight = this.div.offsetHeight;
}
// BEGIN ../../lib/Wikiwyg/Wikitext.js
/*==============================================================================
This Wikiwyg mode supports a textarea editor with toolbar buttons.

COPYRIGHT:

    Copyright © 2005 Socialtext Corporation
    655 High Street
    Palo Alto, CA 94301 U.S.A.
    All rights reserved.

CHANGES AUTHOR:

    Bartek Łapiński <bartek@wikia.com>

    Copyright © 2007, Wikia Inc.

Wikiwyg is free software.

This library is free software; you can redistribute it and/or modify it
under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation; either version 2.1 of the License, or (at
your option) any later version.

This library is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser
General Public License for more details.

    http://www.gnu.org/copyleft/lesser.txt

 =============================================================================*/

proto = new Subclass('Wikiwyg.Wikitext', 'Wikiwyg.Mode');
klass = Wikiwyg.Wikitext;

proto.classtype = 'wikitext';
proto.modeDescription = 'Wikitext';

proto.config = {
    textareaId: null,
    supportCamelCaseLinks: false,
    javascriptLocation: null,
    clearRegex: null,
    editHeightMinimum: 10,
    editHeightAdjustment: 1.3,
    markupRules: {
        link: ['bound_phrase', '[', ']'],
        bold: ['bound_phrase', '*', '*'],
        code: ['bound_phrase', '`', '`'],
        italic: ['bound_phrase', '/', '/'],
        underline: ['bound_phrase', '_', '_'],
        strike: ['bound_phrase', '-', '-'],
        p: ['start_lines', ''],
        pre: ['start_lines', '    '],
        h1: ['start_line', '= '],
        h2: ['start_line', '== '],
        h3: ['start_line', '=== '],
        h4: ['start_line', '==== '],
        h5: ['start_line', '===== '],
        h6: ['start_line', '====== '],
        ordered: ['start_lines', '#'],
        unordered: ['start_lines', '*'],
        indent: ['start_lines', '>'],
        hr: ['line_alone', '----'],
        table: ['line_alone', '| A | B | C |\n|   |   |   |\n|   |   |   |'],
        www: ['bound_phrase', '[', ']']
    }
}

proto.initializeObject = function() { // See IE
    this.initialize_object();
}

proto.initialize_object = function() {
    this.div = document.createElement('div');
    if (this.config.textareaId)
        this.textarea = document.getElementById(this.config.textareaId);
    else
        this.textarea = document.createElement('textarea');
    this.textarea.setAttribute('id', 'wikiwyg_wikitext_textarea');
    this.div.appendChild(this.textarea);
    this.area = this.textarea;
    this.clear_inner_text();
}

proto.clear_inner_text = function() {
    if ( Wikiwyg.is_safari ) return;
    var self = this;
    this.area.onclick = function() {
        var inner_text = self.area.value;
        var clear = self.config.clearRegex;
        if (clear && inner_text.match(clear))
            self.area.value = '';
    }
}

proto.enableThis = function() {
    Wikiwyg.Mode.prototype.enableThis.call(this);
    this.textarea.style.width = '100%';
    this.setHeightOfEditor();
    this.enable_keybindings();
}

proto.setHeightOfEditor = function() {
    var config = this.config;
    var adjust = config.editHeightAdjustment;
    var area   = this.textarea;

    if ( Wikiwyg.is_safari) return area.setAttribute('rows', 25);

    var text   = this.getTextArea();
    var rows   = text.split(/\n/).length;

    var height = parseInt(rows * adjust);
    if (height < config.editHeightMinimum)
        height = config.editHeightMinimum;

    area.setAttribute('rows', height);
}

proto.toWikitext = function() {
    return this.getTextArea();
}

proto.toHtml = function(func) {
    var wikitext = this.canonicalText();
    this.convertWikitextToHtml(wikitext, func);
}

proto.canonicalText = function() {
    var wikitext = this.getTextArea();
    if (wikitext[wikitext.length - 1] != '\n')
        wikitext += '\n';
    return wikitext;
}

proto.initHtml = function (html) {
    this.fromHtml (html);
}

proto.fromHtml = function(html) {
    this.setTextArea('Loading...');
    var self = this;
    this.convertHtmlToWikitext(
        html,
        function(value) {
        	value = self.fixDoubleWeightBug(value);
		self.setTextArea(value);
	}
    );
}

/* seven apostrophes' solution */
proto.fixDoubleWeightBug = function (text) {
	text = this.fixBoldItalic (text);
	text = this.fixItalicBold (text);
	return text;
}

proto.fixBoldItalic = function (text) {
	var found = text.match (/'''''[^']+'''''''[^']+''/gi);
        var split = "";
	var modtext = "";
	if (!found) { /* do not touch otherwise */
		return text;
	}
	var vtext = text;
	var tofix = "";
	split = vtext.split (/'''''[^']+'''''''[^']+''/gi);
	for (i=0; i < found.length; i++) {
		tofix = found[i].replace ("'''''''","'''");
		modtext = modtext + split[i] + tofix;
	}
	return modtext + split[found.length];
}

proto.fixItalicBold = function (text) {
	var found = text.match (/'''''[^']+''''''''[^']+'''/gi);
        var split = "";
	var modtext = "";
	if (!found) { /* do not touch otherwise */
		return text;
	}
	var vtext = text;
	var tofix = "";
	split = vtext.split (/'''''[^']+''''''''[^']+'''/gi);
	for (i=0; i < found.length; i++) {
		tofix = found[i].replace ("''''''''","''");
		modtext = modtext + split[i] + tofix;
	}
	return modtext + split[found.length];
}

proto.getTextArea = function() {
    return this.textarea.value;
}

proto.setTextArea = function(text) {
    this.textarea.value = text;
}

proto.convertWikitextToHtml = function(wikitext, func) {
    alert('Wikitext changes cannot be converted to HTML\nWikiwyg.Wikitext.convertWikitextToHtml is not implemented here');
    func(this.copyhtml);
}

proto.convertHtmlToWikitext = function(html, func) {
    func(this.convert_html_to_wikitext(html));
}

proto.get_keybinding_area = function() {
    return this.textarea;
}

/*==============================================================================
Code to markup wikitext
 =============================================================================*/
Wikiwyg.Wikitext.phrase_end_re = /[\s\.\:\;\,\!\?\(\)]/;

proto.find_left = function(t, selection_start, matcher) {
    var substring = t.substr(selection_start - 1, 1);
    var nextstring = t.substr(selection_start - 2, 1);
    if (selection_start == 0)
        return selection_start;
    if (substring.match(matcher)) {
        // special case for word.word
        if ((substring != '.') || (nextstring.match(/\s/)))
            return selection_start;
    }
    return this.find_left(t, selection_start - 1, matcher);
}

proto.find_right = function(t, selection_end, matcher) {
    var substring = t.substr(selection_end, 1);
    var nextstring = t.substr(selection_end + 1, 1);
    if (selection_end >= t.length)
        return selection_end;
    if (substring.match(matcher)) {
        // special case for word.word
        if ((substring != '.') || (nextstring.match(/\s/)))
            return selection_end;
    }
    return this.find_right(t, selection_end + 1, matcher);
}

proto.get_lines = function() {
    t = this.area; // XXX needs "var"?
    var selection_start = t.selectionStart;
    var selection_end = t.selectionEnd;

    if (selection_start == null) {
        selection_start = selection_end;
        if (selection_start == null) {
            return false
        }
        selection_start = selection_end =
            t.value.substr(0, selection_start).replace(/\r/g, '').length;
    }

    var our_text = t.value.replace(/\r/g, '');
    selection = our_text.substr(selection_start,
        selection_end - selection_start);

    selection_start = this.find_right(our_text, selection_start, /[^\r\n]/);
    selection_end = this.find_left(our_text, selection_end, /[^\r\n]/);

    this.selection_start = this.find_left(our_text, selection_start, /[\r\n]/);
    this.selection_end = this.find_right(our_text, selection_end, /[\r\n]/);
    t.setSelectionRange(selection_start, selection_end);
    t.focus();

    this.start = our_text.substr(0,this.selection_start);
    this.sel = our_text.substr(this.selection_start, this.selection_end -
        this.selection_start);
    this.finish = our_text.substr(this.selection_end, our_text.length);

    return true;
}

proto.alarm_on = function() {
    var area = this.area;
    var background = area.style.background;
    area.style.background = '#f88';

    function alarm_off() {
        area.style.background = background;
    }

    window.setTimeout(alarm_off, 250);
    area.focus()
}

proto.get_words = function() {
    function is_insane(selection) {
        return selection.match(/\r?\n(\r?\n|\*+ |\#+ |\=+ )/);
    }

    t = this.area; // XXX needs "var"?
    var selection_start = t.selectionStart;
    var selection_end = t.selectionEnd;
    if (selection_start == null) {
        selection_start = selection_end;
        if (selection_start == null) {
            return false
        }
        selection_start = selection_end =
            t.value.substr(0, selection_start).replace(/\r/g, '').length;
    }

    var our_text = t.value.replace(/\r/g, '');
    selection = our_text.substr(selection_start,
        selection_end - selection_start);

    selection_start = this.find_right(our_text, selection_start, /(\S|\r?\n)/);
    if (selection_start > selection_end)
        selection_start = selection_end;
    selection_end = this.find_left(our_text, selection_end, /(\S|\r?\n)/);
    if (selection_end < selection_start)
        selection_end = selection_start;

    if (is_insane(selection)) {
        this.alarm_on();
        return false;
    }

    this.selection_start =
        this.find_left(our_text, selection_start, Wikiwyg.Wikitext.phrase_end_re);
    this.selection_end =
        this.find_right(our_text, selection_end, Wikiwyg.Wikitext.phrase_end_re);

    t.setSelectionRange(this.selection_start, this.selection_end);
    t.focus();

    this.start = our_text.substr(0,this.selection_start);
    this.sel = our_text.substr(this.selection_start, this.selection_end -
        this.selection_start);
    this.finish = our_text.substr(this.selection_end, our_text.length);

    return true;
}

proto.markup_is_on = function(start, finish) {
    return (this.sel.match(start) && this.sel.match(finish));
}

proto.clean_selection = function(start, finish) {
    this.sel = this.sel.replace(start, '');
    this.sel = this.sel.replace(finish, '');
}

proto.toggle_same_format = function(start, finish) {
    start = this.clean_regexp(start);
    finish = this.clean_regexp(finish);
    var start_re = new RegExp('^' + start);
    var finish_re = new RegExp(finish + '$');
    if (this.markup_is_on(start_re, finish_re)) {
        this.clean_selection(start_re, finish_re);
        return true;
    }
    return false;
}

proto.clean_regexp = function(string) {
    string = string.replace(/([\^\$\*\+\.\?\[\]\{\}])/g, '\\$1');
    return string;
}

proto.insert_text_at_cursor = function(text) {
    var t = this.area;

    var selection_start = t.selectionStart;
    var selection_end = t.selectionEnd;

    if (selection_start == null) {
        selection_start = selection_end;
        if (selection_start == null) {
            return false
        }
    }

    var before = t.value.substr(0, selection_start);
    var after = t.value.substr(selection_end, t.value.length);
    t.value = before + text + after;
}

proto.set_text_and_selection = function(text, start, end) {
    this.area.value = text;
    this.area.setSelectionRange(start, end);
}

proto.add_markup_words = function(markup_start, markup_finish, example) {
    if (this.toggle_same_format(markup_start, markup_finish)) {
        this.selection_end = this.selection_end -
            (markup_start.length + markup_finish.length);
        markup_start = '';
        markup_finish = '';
    }
    if (this.sel.length == 0) {
        if (example)
            this.sel = example;
        var text = this.start + markup_start + this.sel +
            markup_finish + this.finish;
        var start = this.selection_start + markup_start.length;
        var end = this.selection_end + markup_start.length + this.sel.length;
        this.set_text_and_selection(text, start, end);
    } else {
        var text = this.start + markup_start + this.sel +
            markup_finish + this.finish;
        var start = this.selection_start;
        var end = this.selection_end + markup_start.length +
            markup_finish.length;
        this.set_text_and_selection(text, start, end);
    }
    this.area.focus();
}

// XXX - A lot of this is hardcoded.
proto.add_markup_lines = function(markup_start) {
    var already_set_re = new RegExp( '^' + this.clean_regexp(markup_start), 'gm');
    var other_markup_re = /^(\^+|\=+|\*+|#+|>+|    )/gm;

    var match;
    // if paragraph, reduce everything.
    if (! markup_start.length) {
        this.sel = this.sel.replace(other_markup_re, '');
        this.sel = this.sel.replace(/^\ +/gm, '');
    }
    // if pre and not all indented, indent
    else if ((markup_start == '    ') && this.sel.match(/^\S/m))
        this.sel = this.sel.replace(/^/gm, markup_start);
    // if not requesting heading and already this style, kill this style
    else if (
        (! markup_start.match(/[\=\^]/)) &&
        this.sel.match(already_set_re)
    ) {
        this.sel = this.sel.replace(already_set_re, '');
        if (markup_start != '    ')
            this.sel = this.sel.replace(/^ */gm, '');
    }
    // if some other style, switch to new style
    else if (match = this.sel.match(other_markup_re))
        // if pre, just indent
        if (markup_start == '    ')
            this.sel = this.sel.replace(/^/gm, markup_start);
        // if heading, just change it
        else if (markup_start.match(/[\=\^]/))
            this.sel = this.sel.replace(other_markup_re, markup_start);
        // else try to change based on level
        else
            this.sel = this.sel.replace(
                other_markup_re,
                function(match) {
                    return markup_start.times(match.length);
                }
            );
    // if something selected, use this style
    else if (this.sel.length > 0)
        this.sel = this.sel.replace(/^(.*\S+)/gm, markup_start + ' $1');
    // just add the markup
    else
        this.sel = markup_start + ' ';

    var text = this.start + this.sel + this.finish;
    var start = this.selection_start;
    var end = this.selection_start + this.sel.length;
    this.set_text_and_selection(text, start, end);
    this.area.focus();
}

// XXX - A lot of this is hardcoded.
proto.bound_markup_lines = function(markup_array) {
    var markup_start = markup_array[1];
    var markup_finish = markup_array[2];
    var already_start = new RegExp('^' + this.clean_regexp(markup_start), 'gm');
    var already_finish = new RegExp(this.clean_regexp(markup_finish) + '$', 'gm');
    var other_start = /^(\^+|\=+|\*+|#+|>+) */gm;
    var other_finish = /( +(\^+|\=+))?$/m;

    var match;
    if (this.sel.match(already_start)) {
        this.sel = this.sel.replace(already_start, '');
        this.sel = this.sel.replace(already_finish, '');
    }
    else if (match = this.sel.match(other_start)) {
        this.sel = this.sel.replace(other_start, markup_start);
        this.sel = this.sel.replace(other_finish, markup_finish);
    }
    // if something selected, use this style
    else if (this.sel.length > 0) {
        this.sel = this.sel.replace(
            /^(.*\S+)/gm,
            markup_start + '$1' + markup_finish
        );
    }
    // just add the markup
    else
        this.sel = markup_start + markup_finish;

    var text = this.start + this.sel + this.finish;
    var start = this.selection_start;
    var end = this.selection_start + this.sel.length;
    this.set_text_and_selection(text, start, end);
    this.area.focus();
}

proto.markup_bound_line = function(markup_array) {
    var scroll_top = this.area.scrollTop;
    if (this.get_lines())
        this.bound_markup_lines(markup_array);
    this.area.scrollTop = scroll_top;
}

proto.markup_start_line = function(markup_array) {
    var markup_start = markup_array[1];
    markup_start = markup_start.replace(/ +/, '');
    var scroll_top = this.area.scrollTop;
    if (this.get_lines())
        this.add_markup_lines(markup_start);
    this.area.scrollTop = scroll_top;
}

proto.markup_start_lines = function(markup_array) {
    var markup_start = markup_array[1];
    var scroll_top = this.area.scrollTop;
    if (this.get_lines())
        this.add_markup_lines(markup_start);
    this.area.scrollTop = scroll_top;
}

proto.markup_bound_phrase = function(markup_array) {
    var markup_start = markup_array[1];
    var markup_finish = markup_array[2];
    var scroll_top = this.area.scrollTop;
    if (markup_finish == 'undefined')
        markup_finish = markup_start;
    if (this.get_words()) {
        this.add_markup_words(markup_start, markup_finish, null);
	}
    this.area.scrollTop = scroll_top;
}

klass.make_do = function(style) {
    return function() {
        var markup = this.config.markupRules[style];
        var handler = markup[0];
        if (! this['markup_' + handler])
            die('No handler for markup: "' + handler + '"');
        this['markup_' + handler](markup);
    }
}

proto.do_link = klass.make_do('link');
proto.do_bold = klass.make_do('bold');
proto.do_code = klass.make_do('code');
proto.do_italic = klass.make_do('italic');
proto.do_underline = klass.make_do('underline');
proto.do_strike = klass.make_do('strike');
proto.do_p = klass.make_do('p');
proto.do_pre = klass.make_do('pre');
proto.do_h1 = klass.make_do('h1');
proto.do_h2 = klass.make_do('h2');
proto.do_h3 = klass.make_do('h3');
proto.do_h4 = klass.make_do('h4');
proto.do_h5 = klass.make_do('h5');
proto.do_h6 = klass.make_do('h6');
proto.do_ordered = klass.make_do('ordered');
proto.do_unordered = klass.make_do('unordered');
proto.do_hr = klass.make_do('hr');
proto.do_timestamp = klass.make_do('timestamp');
proto.do_table = klass.make_do('table');

do_wikify = function() {
	var selection = this.get_link_selection_text();
	if (!selection) return;
	var self = this;
	WKWAjax.post (
			fixupRelativeUrl('Special:Createpage') ,
			'action=check&to_check=' + selection ,
			function (response) {
			if (response.indexOf("pagetitleexists") != -1) {
			link_color = "26579A";
			} else {
			link_color = "FF0000";
			}
			var url;
			var match = selection.match(/(.*?)\b((?:http|https|ftp|irc):\/\/\S+)(.*)/);
			if (match) {
			if (match[1] || match[3]) return null;
			url = match[2];
			}
			else {
			url = '?' + escape(selection);
			}

			self.exec_command('createlink', url);
			self.exec_command('underline', selection);
			self.exec_command('ForeColor', "#" + link_color);
			}
	);
}

proto.do_youtube = function() {

	if (Wikiwyg.is_ie) {
		//hack to remember Caret Position in IE
		this.ieRange = this.get_edit_document().selection.createRange();
		this.ieRange.moveStart ('character', -this.get_inner_html().length);
		this.ieCaretPos = this.ieRange.text.length;
	}

	var  url =  prompt("Add YouTube Video. Copy and paste the video's URL or Embed code.", "");
	if (url == null) return;

	if(Wikiwyg.is_ie){
		// Move selection start and end to 0 position
		self.ieRange.moveStart ('character', -self.get_inner_html().length);

		// Move selection start and end to desired position
		self.ieRange.moveStart ('character', self.ieCaretPos);
		self.ieRange.moveEnd ('character', 0);
		self.ieRange.select ();
	}
	this.insert_youtube(url);
}

proto.extract_youtube_id = function(youTubeCode) {
	id = 0;
	inURL = youTubeCode.indexOf("watch?v=")
		if(inURL > -1){
			id = youTubeCode.substring(inURL+8)
		}else{
			r = /http:\/\/www.youtube.com\/v\/\w+/
				test =   r.exec(youTubeCode);
			if(test){
				id = test.toString().replace("http://www.youtube.com/v/","")
			}
		}
	return id;
}

proto.insert_youtube = function(url) {
	youTubeID = this.extract_youtube_id(url);
	if(!id){
		alert("Invalid Youtube url");
		return;
	}
	TheURL = window.location.href
		TheURL = TheURL.substring(0,TheURL.lastIndexOf("/"))
		this.exec_command('InsertImage', TheURL + "/images/YouTube_placeholder.gif?id=" + youTubeID);
}

proto.do_www = function() {
    var  url =  prompt("Enter the link or leave blank to link to selected page", "http://");
    	if (url == null) return;
	var old = this.config.markupRules.www[1];
	this.config.markupRules.www[1] += url + " ";

	// do the transformation
	var markup = this.config.markupRules['www'];
    var handler = markup[0];
     if (! this['markup_' + handler])
    	die('No handler for markup: "' + handler + '"');
    this['markup_' + handler](markup);

	// reset
	this.config.markupRules.www[1] = old;
}

proto.selection_mangle = function(method) {
    var scroll_top = this.area.scrollTop;
    if (! this.get_lines()) {
        this.area.scrollTop = scroll_top;
        return;
    }

    if (method(this)) {
        var text = this.start + this.sel + this.finish;
        var start = this.selection_start;
        var end = this.selection_start + this.sel.length;
        this.set_text_and_selection(text, start, end);
    }
    this.area.focus();
}

proto.do_indent = function() {
    this.selection_mangle(
        function(that) {
            if (that.sel == '') return false;
            that.sel = that.sel.replace(/^(([\*\-\#])+(?=\s))/gm, '$2$1');
            that.sel = that.sel.replace(/^([\>\=])/gm, '$1$1');
            that.sel = that.sel.replace(/^([^\>\*\-\#\=\r\n])/gm, '> $1');
            that.sel = that.sel.replace(/^\={7,}/gm, '======');
            return true;
        }
    )
}

proto.do_outdent = function() {
    this.selection_mangle(
        function(that) {
            if (that.sel == '') return false;
            that.sel = that.sel.replace(/^([\>\*\-\#\=] ?)/gm, '');
            return true;
        }
    )
}

proto.do_unlink = function() {
    this.selection_mangle(
        function(that) {
            that.sel = that.kill_linkedness(that.sel);
            return true;
        }
    );
}

// TODO - generalize this to allow Wikitext dialects that don't use "[foo]"
proto.kill_linkedness = function(str) {
    while (str.match(/\[.*\]/))
        str = str.replace(/\[(.*?)\]/, '$1');
    str = str.replace(/^(.*)\]/, '] $1');
    str = str.replace(/\[(.*)$/, '$1 [');
    return str;
}

// uncomment these to run tests:
// assertEquals('turkey', proto.kill_linkedness('[turkey]'), 'basic')
// assertEquals('a s d f', proto.kill_linkedness('a [s] d [f]'), 'in the midst')
// assertEquals('] xyz', proto.kill_linkedness('xyz]'), 'tail end snip')
// assertEquals('abc [', proto.kill_linkedness('[abc'), 'circumcision')
// assertEquals('h j k [', proto.kill_linkedness('[h] j [k'), 'devious combo 1')
// assertEquals('] q w e', proto.kill_linkedness('q] w [e]'), 'devious combo 2')
// assertEquals('robot', proto.kill_linkedness('robot'), 'no-change')

proto.markup_line_alone = function(markup_array) {
    var t = this.area;
    var scroll_top = t.scrollTop;
    var selection_start = t.selectionStart;
    var selection_end = t.selectionEnd;
    if (selection_start == null) {
        selection_start = selection_end;
    }

    var text = t.value;
    this.selection_start = this.find_right(text, selection_start, /\r?\n/);
    this.selection_end = this.selection_start;
    t.setSelectionRange(this.selection_start, this.selection_start);
    t.focus();

    var markup = markup_array[1];
    this.start = t.value.substr(0, this.selection_start);
    this.finish = t.value.substr(this.selection_end, t.value.length);
    var text = this.start + '\n' + markup + this.finish;
    var start = this.selection_start + markup.length + 1;
    var end = this.selection_end + markup.length + 1;
    this.set_text_and_selection(text, start, end);
    t.scrollTop = scroll_top;
}


/*==============================================================================
Code to convert from html to wikitext.
 =============================================================================*/
proto.convert_html_to_wikitext = function(html) {
    this.copyhtml = html;
    var dom = document.createElement('div');
    dom.innerHTML = html;
    this.output = [];
    this.list_type = [];
    this.indent_level = 0;
    this.no_collapse_text = false;
    dom = this.fixChangedStructure (dom);
    this.normalizeDomWhitespace(dom);
    this.normalizeDomStructure(dom);
    this.walk(dom);

    // add final whitespace
    this.assert_new_line();
    return this.join_output(this.output);
}

proto.fixChangedStructure = function (dom) {
	var divs = this.array_elements_by_tag_name (dom, 'div', false);
        for (var i = 0; i < divs.length; i++) {
		if (divs[i].id == "wikiwyg_toolbar") {
			divs[i].parentNode.removeChild (divs[i]);
		}
	}
	var textareas = this.array_elements_by_tag_name (dom, 'textarea', false);
	for (var i = 0; i < textareas.length; i++) {
		textareas[i].parentNode.removeChild (textareas[i]);
	}
	var spans = this.array_elements_by_tag_name (dom, 'span', false);
	for (var i = 0; i <  spans.length; i++) {
		if (spans[i].className == "editsection") {
			spans[i].parentNode.removeChild (spans[i]);
		}
	}
	return dom;
}

proto.normalizeDomStructure = function(dom) {
    this.normalize_styled_blocks(dom, 'p');
    this.normalize_styled_lists(dom, 'ol');
    this.normalize_styled_lists(dom, 'ul');
    this.normalize_styled_blocks(dom, 'li');
    this.normalize_span_whitespace(dom, 'span');
}

proto.normalize_span_whitespace = function(dom,tag ) {
    var grep = function(element) {
       return Boolean(element.getAttribute('style'));
    }

    var elements = this.array_elements_by_tag_name(dom, tag, grep);
    for (var i = 0; i < elements.length; i++) {
        var element = elements[i];
        var node = element.firstChild;
        while (node) {
            if (node.nodeType == 3) {
                node.nodeValue = node.nodeValue.replace(/^\n+/,"");
                break;
            }
            node = node.nextSibling;
        }
        var node = element.lastChild;
        while (node) {
            if (node.nodeType == 3) {
                node.nodeValue = node.nodeValue.replace(/\n+$/,"");
                break;
            }
            node = node.previousSibling;
        }
    }
}

proto.normalize_styled_blocks = function(dom, tag) {
    var elements = this.array_elements_by_tag_name(dom, tag);
    for (var i = 0; i < elements.length; i++) {
        var element = elements[i];
        var style = element.getAttribute('style');
        if (!style) continue;
        element.removeAttribute('style');
        element.innerHTML =
            '<span style="' + style + '">' + element.innerHTML + '</span>';
    }
}

proto.normalize_styled_lists = function(dom, tag) {
    var elements = this.array_elements_by_tag_name(dom, tag);
    for (var i = 0; i < elements.length; i++) {
        var element = elements[i];
        var style = element.getAttribute('style');
        if (!style) continue;
        element.removeAttribute('style');

        var items = element.getElementsByTagName('li');
        for (var j = 0; j < items.length; j++) {
            items[j].innerHTML =
                '<span style="' + style + '">' + items[j].innerHTML + '</span>';
        }
    }
}

proto.array_elements_by_tag_name = function(dom, tag, grep) {
    var result = dom.getElementsByTagName(tag);
    var elements = [];
    for (var i = 0; i < result.length; i++) {
        if (grep && ! grep(result[i]))
            continue;
        elements.push(result[i]);
    }
    return elements;
}

proto.normalizeDomWhitespace = function(dom) {
    var tags = ['span', 'strong', 'em', 'strike', 'del', 'tt'];
    for (var ii = 0; ii < tags.length; ii++) {
        var elements = dom.getElementsByTagName(tags[ii]);
        for (var i = 0; i < elements.length; i++) {
            this.normalizePhraseWhitespace(elements[i]);
        }
    }
    this.normalizeNewlines(dom, ['br', 'blockquote'], 'nextSibling');
    this.normalizeNewlines(dom, ['p', 'div', 'blockquote'], 'firstChild');
}

proto.normalizeNewlines = function(dom, tags, relation) {
    for (var ii = 0; ii < tags.length; ii++) {
        var nodes = dom.getElementsByTagName(tags[ii]);
        for (var jj = 0; jj < nodes.length; jj++) {
            var next_node = nodes[jj][relation];
            if (next_node && next_node.nodeType == '3') {
                next_node.nodeValue = next_node.nodeValue.replace(/^\n/, '');
            }
        }
    }
}

proto.normalizePhraseWhitespace = function(element) {
    if (this.elementHasComment(element)) return;

    var first_node = this.getFirstTextNode(element);
    var prev_node = this.getPreviousTextNode(element);
    var last_node = this.getLastTextNode(element);
    var next_node = this.getNextTextNode(element);

    if (this.destroyPhraseMarkup(element)) return;

    if (first_node && first_node.nodeValue.match(/^ /)) {
        first_node.nodeValue = first_node.nodeValue.replace(/^ +/, '');
        if (prev_node && ! prev_node.nodeValue.match(/ $/))
            prev_node.nodeValue = prev_node.nodeValue + ' ';
    }

    if (last_node && last_node.nodeValue.match(/ $/)) {
        last_node.nodeValue = last_node.nodeValue.replace(/ $/, '');
        if (next_node && ! next_node.nodeValue.match(/^ /))
            next_node.nodeValue = ' ' + next_node.nodeValue;
    }
}

proto.elementHasComment = function(element) {
    var node = element.lastChild;
    return node && (node.nodeType == 8);
}

proto.destroyPhraseMarkup = function(element) {
    if (this.start_is_no_good(element) || this.end_is_no_good(element))
        return this.destroyElement(element);
    return false;
}

proto.start_is_no_good = function(element) {
    var first_node = this.getFirstTextNode(element);
    var prev_node = this.getPreviousTextNode(element);

    if (! first_node) return true;
    if (first_node.nodeValue.match(/^ /)) return false;
    if (! prev_node || prev_node.nodeValue == '\n') return false;
    return ! prev_node.nodeValue.match(/[ "]$/);
}

proto.end_is_no_good = function(element) {
    var last_node = this.getLastTextNode(element);
    var next_node = this.getNextTextNode(element);

    for (var n = element; n && n.nodeType != 3; n = n.lastChild) {
        if (n.nodeType == 8) return false;
    }

    if (! last_node) return true;
    if (last_node.nodeValue.match(/ $/)) return false;
    if (! next_node || next_node.nodeValue == '\n') return false;
    return ! next_node.nodeValue.match(/^[ ."\n]/);
}

proto.destroyElement = function(element) {
    var span = document.createElement('font');
    span.innerHTML = element.innerHTML;
    element.parentNode.replaceChild(span, element);
    return true;
}

proto.getFirstTextNode = function(element) {
    for (node = element; node && node.nodeType != 3; node = node.firstChild) {
    }
    return node;
}

proto.getLastTextNode = function(element) {
    for (node = element; node && node.nodeType != 3; node = node.lastChild) {
    }
    return node;
}

proto.getPreviousTextNode = function(element) {
    var node = element.previousSibling;
    if (node && node.nodeType != 3)
        node = null;
    return node;
}

proto.getNextTextNode = function(element) {
    var node = element.nextSibling;
    if (node && node.nodeType != 3)
        node = null;
    return node;
}

proto.appendOutput = function(string) {
    this.output.push(string);
}

proto.join_output = function(output) {
    var list = this.remove_stops(output);
    list = this.cleanup_output(list);
    return list.join('');
}

// This is a noop, but can be subclassed.
proto.cleanup_output = function(list) {
    return list;
}

proto.remove_stops = function(list) {
    var clean = [];
    for (var i = 0; i < list.length; i++) {
        if (typeof(list[i]) != 'string') continue;
        clean.push(list[i]);
    }
    return clean;
}

proto.walk = function(element) {
    if (!element) return;
    for (var part = element.firstChild; part; part = part.nextSibling) {
        if (part.nodeType == 1) {
            this.dispatch_formatter(part);
        }
        else if (part.nodeType == 3) {
            if (part.nodeValue.match(/[^\n]/) &&
                ! part.nodeValue.match(/^\n[\ \t]*$/)
               ) {
                if (this.no_collapse_text) {
                    this.appendOutput(part.nodeValue);
                }
                else {
                    this.appendOutput(this.collapse(part.nodeValue));
                }
            }
        }
    }
    this.no_collapse_text = false;
}

proto.dispatch_formatter = function(element) {
    var dispatch = 'format_' + element.nodeName.toLowerCase();
    if (! this[dispatch])
        dispatch = 'handle_undefined';
    this[dispatch](element);
}

proto.skip = function() { }
proto.pass = function(element) {
    this.walk(element);
}
proto.handle_undefined = function(element) {
    this.appendOutput('<' + element.nodeName + '>');
    this.walk(element);
    this.appendOutput('</' + element.nodeName + '>');
}
proto.handle_undefined = proto.skip;

proto.format_abbr = proto.pass;
proto.format_acronym = proto.pass;
proto.format_address = proto.pass;
proto.format_applet = proto.skip;
proto.format_area = proto.skip;
proto.format_basefont = proto.skip;
proto.format_base = proto.skip;
proto.format_bgsound = proto.skip;
proto.format_big = proto.pass;
proto.format_blink = proto.pass;
proto.format_body = proto.pass;
//proto.format_br = proto.skip;
proto.format_button = proto.skip;
proto.format_caption = proto.pass;
proto.format_center = proto.pass;
proto.format_cite = proto.pass;
proto.format_col = proto.pass;
proto.format_colgroup = proto.pass;
proto.format_dd = proto.pass;
proto.format_dfn = proto.pass;
proto.format_dl = proto.pass;
proto.format_dt = proto.pass;
proto.format_embed = proto.skip;
proto.format_field = proto.skip;
proto.format_fieldset = proto.skip;
proto.format_font = proto.pass;
proto.format_form = proto.skip;
proto.format_frame = proto.skip;
proto.format_frameset = proto.skip;
proto.format_head = proto.skip;
proto.format_html = proto.pass;
proto.format_iframe = proto.pass;
proto.format_input = proto.skip;
proto.format_ins = proto.pass;
proto.format_isindex = proto.skip;
proto.format_label = proto.skip;
proto.format_legend = proto.skip;
proto.format_link = proto.skip;
proto.format_map = proto.skip;
proto.format_marquee = proto.skip;
proto.format_meta = proto.skip;
proto.format_multicol = proto.pass;
proto.format_nobr = proto.skip;
proto.format_noembed = proto.skip;
proto.format_noframes = proto.skip;
proto.format_nolayer = proto.skip;
proto.format_noscript = proto.skip;
proto.format_nowrap = proto.skip;
proto.format_object = proto.skip;
proto.format_optgroup = proto.skip;
proto.format_option = proto.skip;
proto.format_param = proto.skip;
proto.format_select = proto.skip;
proto.format_small = proto.pass;
proto.format_spacer = proto.skip;
proto.format_style = proto.skip;
proto.format_sub = proto.pass;
proto.format_submit = proto.skip;
proto.format_sup = proto.pass;
proto.format_tbody = proto.pass;
proto.format_textarea = proto.skip;
proto.format_tfoot = proto.pass;
proto.format_thead = proto.pass;
proto.format_wiki = proto.pass;
proto.format_www = proto.skip;

proto.format_img = function(element) {
    var uri = element.getAttribute('src');
    if (uri) {
        this.assert_space_or_newline();
        this.appendOutput(uri);
    }
}

// XXX This little dance relies on knowning lots of little details about where
// indentation fangs are added and deleted by the various insert/assert calls.
proto.format_blockquote = function(element) {
    var margin  = parseInt(element.style.marginLeft);
    var indents = 0;
    if (margin)
        indents += parseInt(margin / 40);
    if (element.tagName.toLowerCase() == 'blockquote')
        indents += 1;

    if (!this.indent_level)
        this.first_indent_line = true;
    this.indent_level += indents;

    this.output = defang_last_string (this.output);
    this.assert_new_line();
    this.walk(element);
    this.indent_level -= indents;

    if (! this.indent_level)
        this.assert_blank_line();
    else
        this.assert_new_line();

    function defang_last_string(output) {
        function non_string(a) { return typeof(a) != 'string' }

        // Strategy: reverse the output list, take any non-strings off the
        // head (tail of the original output list), do the substitution on the
        // first item of the reversed head (this is the last string in the
        // original list), then join and reverse the result.
        //
        // Suppose the output list looks like this, where a digit is a string,
        // a letter is an object, and * is the substituted string: 01q234op.

        var rev = output.slice().reverse();                     // po432q10
        var rev_tail = takeWhile(non_string, rev);              // po
        var rev_head = dropWhile(non_string, rev);              // 432q10

        if (rev_head.length)
            rev_head[0].replace(/^>+/, '');                     // *32q10

        // po*3210 -> 0123*op
        return rev_tail.concat(rev_head).reverse();             // 01q23*op
    }
}

proto.format_div = function(element) {
    if (this.is_opaque(element)) {
        this.handle_opaque_block(element);
        return;
    }
    if (this.is_indented(element)) {
        this.format_blockquote(element);
        return;
    }
    this.walk(element);
}

proto.format_span = function(element) {

    if (this.is_opaque(element)) {
        this.handle_opaque_phrase(element);
        return;
    }

    var style = element.getAttribute('style');
    if (!style) {
        this.pass(element);
        return;
    }
    if (   ! this.element_has_text_content(element)
        && ! this.element_has_only_image_content(element)) return;
    var attributes = [ 'line-through', 'bold', 'italic', 'underline' ];
    for (var i = 0; i < attributes.length; i++)
        this.check_style_and_maybe_mark_up(style, attributes[i], 1);
    this.no_following_whitespace();
    this.walk(element);
    for (var i = attributes.length; i >= 0; i--)
        this.check_style_and_maybe_mark_up(style, attributes[i], 2);
}

proto.element_has_text_content = function(element) {
    return element.innerHTML.replace(/<.*?>/g, '')
                            .replace(/&nbsp;/g, '').match(/\S/);
}

proto.element_has_only_image_content = function(element) {
    return    element.childNodes.length == 1
           && element.firstChild.nodeType == 1
           && element.firstChild.tagName.toLowerCase() == 'img';
}

proto.check_style_and_maybe_mark_up = function(style, attribute, open_close) {
    var markup_rule = attribute;
    if (markup_rule == 'line-through')
        markup_rule = 'strike';
    if (this.check_style_for_attribute(style, attribute))
        this.appendOutput(this.config.markupRules[markup_rule][open_close]);
}

proto.check_style_for_attribute = function(style, attribute) {
    var string = this.squish_style_object_into_string(style);
    return string.match("\\b" + attribute + "\\b");
}

proto.squish_style_object_into_string = function(style) {
    if ((style.constructor+'').match('String'))
        return style;
    var interesting_attributes = [
        [ 'font', 'weight' ],
        [ 'font', 'style' ],
        [ 'text', 'decoration' ]
    ];
    var string = '';
    for (var i = 0; i < interesting_attributes.length; i++) {
        var pair = interesting_attributes[i];
        var css = pair[0] + '-' + pair[1];
        var js = pair[0] + pair[1].ucFirst();
        string += css + ': ' + style[js] + '; ';
    }
    return string;
}

proto.basic_formatter = function(element, style) {
    var markup = this.config.markupRules[style];
    var handler = markup[0];
    this['handle_' + handler](element, markup);
}

klass.make_empty_formatter = function(style) {
    return function(element) {
        this.basic_formatter(element, style);
    }
}

klass.make_formatter = function(style) {
    return function(element) {
        if (this.element_has_text_content(element))
            this.basic_formatter(element, style);
    }
}

proto.format_b = klass.make_formatter('bold');
proto.format_strong = proto.format_b;
proto.format_code = klass.make_formatter('code');
proto.format_kbd = proto.format_code;
proto.format_samp = proto.format_code;
proto.format_tt = proto.format_code;
proto.format_var = proto.format_code;
proto.format_i = klass.make_formatter('italic');
proto.format_em = proto.format_i;
proto.format_u = klass.make_formatter('underline');
proto.format_strike = klass.make_formatter('strike');
proto.format_del = proto.format_strike;
proto.format_s = proto.format_strike;
proto.format_hr = klass.make_empty_formatter('hr');
proto.format_h1 = klass.make_formatter('h1');
proto.format_h2 = klass.make_formatter('h2');
proto.format_h3 = klass.make_formatter('h3');
proto.format_h4 = klass.make_formatter('h4');
proto.format_h5 = klass.make_formatter('h5');
proto.format_h6 = klass.make_formatter('h6');
proto.format_pre = klass.make_formatter('pre');

proto.format_br = function (element) {
	this.insert_new_line ();
	this.insert_new_line ();
}

proto.format_p = function(element) {
    if (this.is_indented(element)) {
        this.format_blockquote(element);
        return;
    }
    this.assert_blank_line();
    this.assert_blank_line();
    this.walk(element);
//    this.assert_blank_line();
}

proto.format_a = function(element) {
    var label = Wikiwyg.htmlUnescape(element.innerHTML);
    label = label.replace(/<[^>]*?>/g, ' ');
    label = label.replace(/\s+/g, ' ');
    label = label.replace(/^\s+/, '');
    label = label.replace(/\s+$/, '');
    var href = element.getAttribute('href');
    /* fix for IE's absolute url */
    if (Wikiwyg.is_ie) {
	if (href.indexOf(wgServer) != -1) {
		href = href.replace (wgServer, "");
	}
    }
    if (! href) href = ''; // Necessary for <a name="xyz"></a>'s
    this.make_wikitext_link(label, href, element);
}

proto.format_table = function(element) {
    this.assert_blank_line();
    this.walk(element);
    this.assert_blank_line();
}

proto.format_tr = function(element) {
    this.walk(element);
    this.appendOutput('|');
    this.insert_new_line();
}

proto.format_td = function(element) {
    this.appendOutput('| ');
    this.no_following_whitespace();
    this.walk(element);
    this.chomp();
    this.appendOutput(' ');
}
proto.format_th = proto.format_td;

// Generic functions on lists taken from the Haskell Prelude.
// See http://xrl.us/jbko
//
// These sorts of thing should probably be moved to some general-purpose
// Javascript library.

function takeWhile(f, a) {
    for (var i = 0; i < a.length; ++i)
        if (! f(a[i])) break;

    return a.slice(0, i);
}

function dropWhile(f, a) {
    for (var i = 0; i < a.length; ++i)
        if (! f(a[i])) break;

    return a.slice(i);
}

proto.previous_line = function() {
    function newline(s) { return s['match'] && s.match(/\n/) }
    function non_newline(s) { return ! newline(s) }

    return this.join_output(
        takeWhile(non_newline,
            dropWhile(newline,
                this.output.slice().reverse()
            )
        ).reverse()
    );
}

proto.make_list = function(element, list_type) {
    if (! this.previous_was_newline_or_start())
        this.insert_new_line();

    this.list_type.push(list_type);
    this.walk(element);
    this.list_type.pop();
    if (this.list_type.length == 0)
        this.assert_blank_line();
}

proto.format_ol = function(element) {
    this.make_list(element, 'ordered');
}

proto.format_ul = function(element) {
    this.make_list(element, 'unordered');
}

proto.format_li = function(element) {
    var level = this.list_type.length;
    if (!level) die("Wikiwyg list error");
    var type = this.list_type[level - 1];
    var markup = this.config.markupRules[type];
    this.appendOutput(markup[1].times(level) + ' ');

    // Nasty ie hack which I don't want to talk about.
    // But I will...
    // *Sometimes* when pulling html out of the designmode iframe it has
    // <LI> elements with no matching </LI> even though the </LI>s existed
    // going in. This needs to be delved into, and we need to see if
    // quirksmode and friends can/should be set somehow on the iframe
    // document for wikiwyg. Also research whether we need an iframe at all on
    // IE. Could we just use a div with contenteditable=true?
    if (Wikiwyg.is_ie &&
        element.firstChild &&
        element.firstChild.nextSibling &&
        element.firstChild.nextSibling.nodeName.match(/^[uo]l$/i))
    {
        try {
            element.firstChild.nodeValue =
              element.firstChild.nodeValue.replace(/ $/, '');
        }
        catch(e) { }
    }

    this.walk(element);

    this.chomp();
    this.insert_new_line();
}

proto.chomp = function() {
    var string;
    while (this.output.length) {
        string = this.output.pop();
        if (typeof(string) != 'string') {
            this.appendOutput(string);
            return;
        }
        if (! string.match(/^\n+>+ $/) && string.match(/\S/))
            break;
    }
    if (string) {
        string = string.replace(/[\r\n\s]+$/, '');
        this.appendOutput(string);
    }
}

proto.collapse = function(string) {
    return string.replace(/[ \u00a0\r\n]+/g, ' ');
}

proto.trim = function(string) {
    return string.replace(/^\s+/, '');
}

proto.insert_new_line = function() {
    var fang = '';
    var indentChar = this.config.markupRules.indent[1];
    var newline = '\n';
    if (this.indent_level > 0) {
        fang = indentChar.times(this.indent_level);
        if (fang.length)
            fang += ' ';
    }
    // XXX - ('\n' + fang) MUST be in the same element in this.output so that
    // it can be properly matched by chomp above.
    if (fang.length && this.first_indent_line) {
        this.first_indent_line = false;
        newline = newline + newline;
    }
    if (this.output.length)
        this.appendOutput(newline + fang);
    else if (fang.length)
        this.appendOutput(fang);
}

proto.previous_was_newline_or_start = function() {
    for (var ii = this.output.length - 1; ii >= 0; ii--) {
        var string = this.output[ii];
        if (typeof(string) != 'string')
            continue;
        return string.match(/\n$/);
    }
    return true;
}

proto.assert_new_line = function() {
    this.chomp();
    this.insert_new_line();
}

proto.assert_blank_line = function() {
    if (! this.should_whitespace()) return
    this.chomp();
    this.insert_new_line();
    this.insert_new_line();
}

proto.assert_space_or_newline = function() {
    if (! this.output.length || ! this.should_whitespace()) return;
    if (! this.previous_output().match(/(\s+|[\(])$/))
        this.appendOutput(' ');
}

proto.no_following_whitespace = function() {
    this.appendOutput({whitespace: 'stop'});
}

proto.should_whitespace = function() {
    return ! this.previous_output().whitespace;
}

// how_far_back defaults to 1
proto.previous_output = function(how_far_back) {
    if (! how_far_back)
        how_far_back = 1;
    var length = this.output.length;
    return length && how_far_back <= length ? this.output[length - how_far_back] : '';
}

proto.handle_bound_phrase = function(element, markup) {
    if (! this.element_has_text_content(element)) return;

    /* If an italics/bold/etc element starts with a
       <br> tag we want to make sure the newline comes _before_ the
       wiki markup we are adding, or we end up with this:

       _
       foo_
    */
    if (element.innerHTML.match(/^\s*<br\s*\/?\s*>/)) {
        this.appendOutput("\n");
        element.innerHTML = element.innerHTML.replace(/^\s*<br\s*\/?\s*>/, '');
    }
    this.appendOutput(markup[1]);
    this.no_following_whitespace();
    this.walk(element);
    // assume that walk leaves no trailing whitespace.
    this.appendOutput(markup[2]);
}

// XXX - A very promising refactoring is that we don't need the trailing
// assert_blank_line in block formatters.
proto.handle_bound_line = function(element,markup) {
    this.assert_blank_line();
    this.appendOutput(markup[1]);
    this.walk(element);
    this.appendOutput(markup[2]);
    this.assert_blank_line();
}

proto.handle_start_line = function (element, markup) {
    this.assert_blank_line();
    this.appendOutput(markup[1]);
    this.walk(element);
    this.assert_blank_line();
}

proto.handle_start_lines = function (element, markup) {
    var text = element.firstChild.nodeValue;
    if (!text) return;
    this.assert_blank_line();
    text = text.replace(/^/mg, markup[1]);
    this.appendOutput(text);
    this.assert_blank_line();
}

proto.handle_line_alone = function (element, markup) {
    this.assert_blank_line();
    this.appendOutput(markup[1]);
    this.assert_blank_line();
}

proto.COMMENT_NODE_TYPE = 8;
proto.get_wiki_comment = function(element) {
    for (var node = element.firstChild; node; node = node.nextSibling) {
        if (node.nodeType == this.COMMENT_NODE_TYPE
            && node.data.match(/^\s*wiki/))
            return node;
    }
    return null;
}

proto.is_indented = function (element) {
    var margin = parseInt(element.style.marginLeft);
    return margin > 0;
}

proto.is_opaque = function(element) {
    var comment = this.get_wiki_comment(element);
    if (!comment) return false;

    var text = comment.data;
    if (text.match(/^\s*wiki:/)) return true;
    return false;
}

proto.handle_opaque_phrase = function(element) {
    var comment = this.get_wiki_comment(element);
    if (comment) {
        var text = comment.data;
        text = text.replace(/^ wiki:\s+/, '')
                   .replace(/-=/g, '-')
                   .replace(/==/g, '=')
                   .replace(/\s$/, '')
                   .replace(/\{(\w+):\s*\}/, '{$1}');
        this.appendOutput(Wikiwyg.htmlUnescape(text))
        this.smart_trailing_space(element);
    }
}

proto.smart_trailing_space = function(element) {
    var next = element.nextSibling;
    if (! next) {
        // do nothing
    }
    else if (next.nodeType == 1) {
        if (next.nodeName == 'BR') {
            var nn = next.nextSibling;
            if (! (nn && nn.nodeType == 1 && nn.nodeName == 'SPAN'))
                this.appendOutput('\n');
        }
        else {
            this.appendOutput(' ');
        }
    }
    else if (next.nodeType == 3) {
        if (! next.nodeValue.match(/^\s/))
            this.no_following_whitespace();
    }
}

proto.handle_opaque_block = function(element) {
    var comment = this.get_wiki_comment(element);
    if (!comment) return;

    var text = comment.data;
    text = text.replace(/^\s*wiki:\s+/, '');
    this.appendOutput(text);
}

proto.make_wikitext_link = function(label, href, element) {
    var before = this.config.markupRules.link[1];
    var after  = this.config.markupRules.link[2];
	// handle external links
	if (this.looks_like_a_url(href)) {
		before = this.config.markupRules.www[1];
		after = this.config.markupRules.www[2];
	}

    this.assert_space_or_newline();
    if (! href) {
        this.appendOutput(label);
    }
    else if (href == label) {
        this.appendOutput(href);
    }
    else if (this.href_is_wiki_link(href)) {
        if (this.camel_case_link(label))
            this.appendOutput(label);
        else {
	    if (label != href) {
	    	href = href.replace (/^\/index.php\?title=/i,"?");
		href = href.replace (/wiki\//i, "");
		href = href.replace (/&action=.*$/i, "");
	            	this.appendOutput(before + href.substring(1) + '|' + label + after);
	    } else {
            	this.appendOutput(before + label + after);
	    }
	}
    }
    else {
        this.appendOutput(before + href + ' ' + label + after);
    }
}

proto.camel_case_link = function(label) {
    if (! this.config.supportCamelCaseLinks)
        return false;
    return label.match(/[a-z][A-Z]/);
}

proto.href_is_wiki_link = function(href) {
    if (! this.looks_like_a_url(href))
        return true;
    if (! href.match(/\?/))
        return false;
    if (href.match(/\/static\/\d+\.\d+\.\d+\.\d+\//))
        href = location.href;
    var no_arg_input   = href.split('?')[0];
    var no_arg_current = location.href.split('?')[0];
    if (no_arg_current == location.href)
        no_arg_current =
          location.href.replace(new RegExp(location.hash), '');
    return no_arg_input == no_arg_current;
}

proto.looks_like_a_url = function(string) {
    return string.match(/^(http|https|ftp|irc|mailto|file):/);
}

/*==============================================================================
Support for Internet Explorer in Wikiwyg.Wikitext
 =============================================================================*/
if (Wikiwyg.is_ie) {

proto.setHeightOf = function() {
    // XXX hardcode this until we can keep window from jumping after button
    // events.
    this.textarea.style.height = '200px';
}

proto.initializeObject = function() {
    this.initialize_object();
    this.area.addBehavior(this.config.javascriptLocation + "Selection.htc");
}

} // end of global if

// BEGIN ../../lib/Wikiwyg/Wysiwyg.js
/*==============================================================================
This Wikiwyg mode supports a DesignMode wysiwyg editor with toolbar buttons

COPYRIGHT:

    Copyright © 2005 Socialtext Corporation
    655 High Street
    Palo Alto, CA 94301 U.S.A.
    All rights reserved.

CHANGES AUTHOR:

    Bartek Łapiński <bartek@wikia.com>

    Copyright © 2007, Wikia Inc.

Wikiwyg is free software.

This library is free software; you can redistribute it and/or modify it
under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation; either version 2.1 of the License, or (at
your option) any later version.

This library is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser
General Public License for more details.

    http://www.gnu.org/copyleft/lesser.txt

 =============================================================================*/

proto = new Subclass('Wikiwyg.Wysiwyg', 'Wikiwyg.Mode');

proto.classtype = 'wysiwyg';
proto.modeDescription = wgWysiwygCaption;

proto.config = {
    useParentStyles: true,
    useStyleMedia: 'wikiwyg',
    iframeId: null,
    iframeObject: null,
    disabledToolbarButtons: [],
    editHeightMinimum: 250,
    overrideHeightMinimum: true ,
    editHeightAdjustment: 1.3,
    clearRegex: null
};

proto.initializeObject = function() {
    this.edit_iframe = this.get_edit_iframe();
    this.div = this.edit_iframe;
    this.set_design_mode_early();
}

proto.set_design_mode_early = function() { // See IE, below
    // Unneeded for Gecko
}

proto.initHtml = function (html) {
    this.fromHtml (html);
}

proto.fromHtml = function(html) {
    this.set_inner_html(this.sanitize_html(html));
}

proto.toHtml = function(func) {
    func(this.get_inner_html());
}

// This is needed to work around the broken IMGs in Firefox design mode.
// Works harmlessly on IE, too.
// TODO - IMG URLs that don't match /^\//
proto.fix_up_relative_imgs = function() {
    var base = location.href.replace(/(.*?:\/\/.*?\/).*/, '$1');
    var imgs = this.get_edit_document().getElementsByTagName('img');
    for (var ii = 0; ii < imgs.length; ++ii)
        imgs[ii].src = imgs[ii].src.replace(/^\//, base);
}

proto.enableThis = function() {
    Wikiwyg.Mode.prototype.enableThis.call(this);
    this.edit_iframe.style.border = '1px black solid';
    if (this.edit_iframe.contentDocument) {
	    this.edit_iframe.contentDocument.body.style.background = '#fff';
    } else {
	    this.edit_iframe.document.body.style.background = '#fff';
    }
    this.edit_iframe.width = '100%';
    this.setHeightOf(this.edit_iframe);
    this.fix_up_relative_imgs();
    this.get_edit_document().designMode = 'on';
    this.apply_stylesheets();
    this.enable_keybindings();
    this.clear_inner_html();
    if ( Wikiwyg.is_ie ) {
	    var self = this;
	    var win = this.get_edit_window();
	    var doc = this.get_edit_document();
	    self.ieSelectionBookmark = null;
	    var bookmark = function() {
		    var range = doc.selection.createRange();
		    if ( range.getBookmark ) {
			    self.ieSelectionBookmark = range.getBookmark();
		    }
	    }
	    doc.attachEvent("onbeforedeactivate", bookmark);
	    var restoreBookmark = function() {
		    if (self.ieSelectionBookmark) {
			    var range = doc.body.createTextRange();
			    range.moveToBookmark(self.ieSelectionBookmark);
			    range.collapse();
			    range.select();
		    }
	    }
	    doc.attachEvent("onactivate", restoreBookmark);
    }
}

proto.clear_inner_html = function() {
    var inner_html = this.get_inner_html();
    var clear = this.config.clearRegex;
    if (clear && inner_html.match(clear))
        this.set_inner_html('');
}

proto.get_keybinding_area = function() {
    return this.get_edit_document();
}

proto.get_edit_iframe = function() {
    var iframe;
    if (this.config.iframeId) {
        iframe = document.getElementById(this.config.iframeId);
        iframe.iframe_hack = true;
    }
    else if (this.config.iframeObject) {
        iframe = this.config.iframeObject;
        iframe.iframe_hack = true;
    }
    else {
        // XXX in IE need to wait a little while for iframe to load up
        iframe = document.createElement('iframe');
    }
    return iframe;
}

proto.get_edit_window = function() { // See IE, below
    return this.edit_iframe.contentWindow;
}

proto.get_edit_document = function() { // See IE, below
    return this.get_edit_window().document;
}

proto.get_inner_html = function() {
    return this.get_edit_document().body.innerHTML;
}
proto.set_inner_html = function(html) {
    this.get_edit_document().body.innerHTML = html;
}

proto.apply_stylesheets = function() {
    var styles = document.styleSheets;
    var head   = this.get_edit_document().getElementsByTagName("head")[0];

    for (var i = 0; i < styles.length; i++) {
        var style = styles[i];

        if (style.href == location.href)
            this.apply_inline_stylesheet(style, head);
        else
            if (this.should_link_stylesheet(style))
                this.apply_linked_stylesheet(style, head);
    }
}

proto.apply_inline_stylesheet = function(style, head) {
    var style_string = "";
    for ( var i = 0; i < style.cssRules.length; i++ ) {
        if ( style.cssRules[i].type == 3 ) {
            // IMPORT_RULE

            /* It's pretty strange that this doesnt work.
               That's why WKWAjax.get() is used to retrive the css text.

            this.apply_linked_stylesheet({
                href: style.cssRules[i].href,
                type: 'text/css'
            }, head);
            */

            style_string += WKWAjax.get(style.cssRules[i].href);
        } else {
            style_string += style.cssRules[i].cssText + "\n";
        }
    }
    if (style_string.length > 0) {
        style_string += "\nbody { padding: 5px; }\n";
        this.append_inline_style_element(style_string, head);
    }
}

proto.append_inline_style_element = function(style_string, head) {
    // Add a body padding so words are not touching borders.
    var style_elt = document.createElement("style");
    style_elt.setAttribute("type", "text/css");
    if ( style_elt.styleSheet ) { /* IE */
        style_elt.styleSheet.cssText = style_string;
    }
    else { /* w3c */
        var style_text = document.createTextNode(style_string);
        style_elt.appendChild(style_text);
        head.appendChild(style_elt);
    }
    // XXX This doesn't work in IE!!
    // head.appendChild(style_elt);
}

proto.should_link_stylesheet = function(style, head) {
        var media = style.media;
        var config = this.config;
        var media_text = media.mediaText ? media.mediaText : media;
        var use_parent =
             ((!media_text || media_text == 'screen') &&
             config.useParentStyles);
        var use_style = (media_text && (media_text == config.useStyleMedia));
        if (!use_parent && !use_style) // TODO: simplify
            return false;
        else
            return true;
}

proto.apply_linked_stylesheet = function(style, head) {
    var link = Wikiwyg.createElementWithAttrs(
        'link', {
            href:  style.href,
            type:  style.type,
            media: 'screen',
            rel:   'STYLESHEET'
        }, this.get_edit_document()
    );
    head.appendChild(link);
}

proto.process_command = function(command) {
    if (this['do_' + command])
        this['do_' + command](command);
    if (! Wikiwyg.is_ie)
        this.get_edit_window().focus();
}

proto.exec_command = function(command, option) {
    this.get_edit_document().execCommand(command, false, option);
}

proto.format_command = function(command) {
    this.exec_command('formatblock', '<' + command + '>');
}

proto.do_bold = function () {
	this.exec_command ('bold');
}

proto.do_italic = function () {
	this.exec_command ('italic');
}

proto.do_underline = proto.exec_command;
proto.do_strike = function() {
    this.exec_command('strikethrough');
}
proto.do_hr = function() {
    this.exec_command('inserthorizontalrule');
}
proto.do_ordered = function() {
    this.exec_command('insertorderedlist');
}

proto.do_timestamp = function () {
	this.exec_command ('inserthtml', '~~~~');
}

proto.do_unordered = function() {
    this.exec_command('insertunorderedlist');
}
proto.do_indent = proto.exec_command;
proto.do_outdent = proto.exec_command;

proto.do_h1 = proto.format_command;
proto.do_h2 = proto.format_command;
proto.do_h3 = proto.format_command;
proto.do_h4 = proto.format_command;
proto.do_h5 = proto.format_command;
proto.do_h6 = proto.format_command;
proto.do_pre = proto.format_command;
proto.do_p = proto.format_command;

proto.do_table = function() {
    var html =
        '<table><tbody>' +
        '<tr><td>A</td>' +
            '<td>B</td>' +
            '<td>C</td></tr>' +
        '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>' +
        '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>' +
        '</tbody></table>';
    this.insert_table(html);
}

proto.insert_table = function(html) { // See IE
    this.get_edit_window().focus();
    this.exec_command('inserthtml', html);
}

proto.do_unlink = proto.exec_command;

proto.do_link = function() {
    var selection = this.get_link_selection_text();
    if (! selection) return;
    var url;
    url = prompt("Enter the link or leave blank to link to selected page", "");
    /* if blank, get selection */
    if (!url) {
    	url = selection;
    }
    var match = url.match(/(.*?)\b((?:http|https|ftp|irc|file):\/\/\S+)(.*)/);
    if (match) {
        if (match[1] || match[3]) return null;
        url = match[2];
    }
    else {
        url = '?' + escape(url);
    }
    this.exec_command('createlink', url);
}

proto.do_www = function() {
    var selection = this.get_link_selection_text();
	if (selection != null) {
		var  url =  prompt("Enter the link or leave blank to link to selected page", "http://");
		this.exec_command('createlink', url);
	}
}

proto.get_selection_text = function() { // See IE, below
    return this.get_edit_window().getSelection().toString();
}

proto.get_link_selection_text = function() {
    var selection = this.get_selection_text();
    if (! selection) {
        alert("Please select the text you would like to turn into a link.");
        return;
    }
    return selection;
}

/*==============================================================================
Support for Internet Explorer in Wikiwyg.Wysiwyg
 =============================================================================*/
if (Wikiwyg.is_ie) {

proto.set_design_mode_early = function(wikiwyg) {
    // XXX - need to know if iframe is ready yet...
    this.get_edit_document().designMode = 'on';
}

proto.get_edit_window = function() {
    return this.edit_iframe;
}

proto.get_edit_document = function() {
    return this.edit_iframe.contentWindow.document;
}

proto.get_selection_text = function() {
    var selection = this.get_edit_document().selection;
    if (selection != null)
        return selection.createRange().htmlText;
    return '';
}

proto.insert_table = function(html) {
    var doc = this.get_edit_document();
    var range = this.get_edit_document().selection.createRange();
    if (range.boundingTop == 2 && range.boundingLeft == 2)
        return;
    range.pasteHTML(html);
    range.collapse(false);
    range.select();
}

// Use IE's design mode default key bindings for now.
proto.enable_keybindings = function() {}

} // end of global if
// BEGIN ../../lib/Wikiwyg/HTML.js

/*==============================================================================
This Wikiwyg mode supports a simple HTML editor

COPYRIGHT:

    Copyright © 2005 Socialtext Corporation
    655 High Street
    Palo Alto, CA 94301 U.S.A.
    All rights reserved.

CHANGES AUTHOR:

    Bartek Łapiński <bartek@wikia.com>

    Copyright © 2007, Wikia Inc.

Wikiwyg is free software.

This library is free software; you can redistribute it and/or modify it
under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation; either version 2.1 of the License, or (at
your option) any later version.

This library is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser
General Public License for more details.

    http://www.gnu.org/copyleft/lesser.txt

 =============================================================================*/

proto = new Subclass('Wikiwyg.HTML', 'Wikiwyg.Mode');

proto.classtype = 'html';
proto.modeDescription = 'HTML';

proto.config = {
    textareaId: null
}

proto.initializeObject = function() {
    this.div = document.createElement('div');
    if (this.config.textareaId)
        this.textarea = document.getElementById(this.config.textareaId);
    else
        this.textarea = document.createElement('textarea');
    this.div.appendChild(this.textarea);
}

proto.enableThis = function() {
    Wikiwyg.Mode.prototype.enableThis.call(this);
    this.textarea.style.width = '100%';
    this.textarea.style.height = '300px';
}

proto.initHtml = function (html) {
    this.fromHtml (html);
}

proto.fromHtml = function(html) {
    this.textarea.value = this.sanitize_html(html);
}

proto.toHtml = function(func) {
    func(this.textarea.value);
}

proto.process_command = function(command) {};
// BEGIN lib/Wikiwyg/MediaWiki.js
/* ToDo:

    == Numbered tickets can be found in http://trac.wikiwyg.net/trac/report/1

*/

// XXX CrappyHacks to get around mediawiki/config stuff.
// These hacks should be removed eventually.

// This fixes some mediawiki js error that pops up at various times.
if (typeof(LivePreviewInstall) == 'undefined')
    LivePreviewInstall = function() {};

function fixupRelativeUrl(url) {
	return  FixupRelativeUrl(url);
}

function FixupRelativeUrl(url) {
    var loc = String(location);

    if (wgArticlePath.match (/index\.php\?title=/) != '' ) {
	url = url.replace (/index\.php\//, '?title=');
    }
    var base = loc.replace(/index\.php.*/, '');
    if (base == loc)
        base = loc.replace(/(.*\/wiki\/).*/, '$1');
    if (base == loc)
        throw ("fixupRelativeUrl error: " + loc);
    return base + url;
}

function findEditLink() {
    var li = document.getElementById('ca-edit');
    if (! li) return null;
    return li.getElementsByTagName('a')[0];
}

// XXX End of CrappyHacks

// Wikiwyg initialization/startup code
(function() {
    addEvent("onload", function() {Wikiwyg.MediaWiki.initialize()});
    window.onbeforeunload = confirmExit;
})();

//------------------------------------------------------------------------------

proto = new Subclass('Wikiwyg.MediaWiki', 'Wikiwyg');
klass = Wikiwyg.MediaWiki;
klass.edit_buttons = [];

klass.initialize = function() {
    if (! Wikiwyg.browserIsSupported) return;

    var wikiwyg_divs = grepElementsByTag('span',
        function(e) { return e.id.match(/^wikiwyg_section_\d+$/) }
    );
    Wikiwyg.MediaWiki.wikiwyg_divs = wikiwyg_divs;
    if (! Wikiwyg.MediaWiki.wikiwyg_enabled()) return;
}

klass.wikiwyg_enabled = function() {
    Wikiwyg.MediaWiki.main_edit_button = findEditLink();
    if (!wgIsArticle) return false;
    var enabled = Cookie.get('wikiwyg_enabled');
    if (! enabled) enabled = "false";
    enabled = eval(enabled);
    Cookie.set('wikiwyg_enabled', String(enabled));
    Wikiwyg.MediaWiki.enable ();

    return enabled;
}

klass.enable = function() {
    if (Wikiwyg.MediaWiki.busy) return false;
    if (Wikiwyg.MediaWiki.checkEditInProgress()) return false;
    Wikiwyg.MediaWiki.busy = true;
    Cookie.set('wikiwyg_enabled', true);
    // Code to actually enable Wikiwyg
    var wikiwyg_divs = Wikiwyg.MediaWiki.wikiwyg_divs;
    for (var i = 0; i < wikiwyg_divs.length; i++) {
        var div = wikiwyg_divs[i];
        var section_number = div.id.replace(/.*?(\d+)$/, '$1');
        var success = Wikiwyg.MediaWiki.enable_wikiwyg_section(
            div, section_number
        );
        if (! success) return false;
    }

    Wikiwyg.MediaWiki.busy = false;
    return false;
}

klass.disable = function() {
    if (Wikiwyg.MediaWiki.busy) return false;
    if (Wikiwyg.MediaWiki.checkEditInProgress()) return false;
    Wikiwyg.MediaWiki.busy = true;
    Cookie.set('wikiwyg_enabled', false);
    // XXX Code to actually disable Wikiwyg
    var wikiwyg_divs = Wikiwyg.MediaWiki.wikiwyg_divs;
    for (var i = 0; i < wikiwyg_divs.length; i++) {
        var div = wikiwyg_divs[i];
        var section_number = div.id.replace(/.*?(\d+)$/, '$1');
        Wikiwyg.MediaWiki.disable_wikiwyg_section(
            div, section_number
        );
    }

    Wikiwyg.MediaWiki.busy = false;
    return false;
}

klass.checkEditInProgress = function() {
    if (Wikiwyg.MediaWiki.editInProgress) {
        alert("Can't change the Wikiwyg option while editing in progress.");
        return true;
    }
    return false;
}

klass.enable_wikiwyg_section = function(section_div, section_number) {
    var myConfig = {
        doubleClickToEdit: true,
        toolbarClass: 'Wikiwyg.Toolbar.MediaWiki',
        toolbar: {
	    imagesLocation: wgScriptPath + '/extensions/wikiwyg/share/MediaWiki/images/',
            imagesExtension: '.gif'
        },
        wysiwyg: {
            iframeId: 'wikiwyg_iframe_' + section_number
        },
        modeClasses: [
            'Wikiwyg.Wysiwyg.MediaWiki' ,
	    'Wikiwyg.Wikitext.MediaWiki' ,
            'Wikiwyg.Preview.MediaWiki'
        ]
    }

    var hasWysiwyg = true;
    if (! klass.canSupportWysiwyg(section_div) || (wgUseWysiwyg == 0)) {
        hasWysiwyg = false;
        myConfig.modeClasses.shift();
    }

    var myWikiwyg = new Wikiwyg.MediaWiki();
    myWikiwyg.createWikiwygArea(section_div, myConfig);
    if (! myWikiwyg.enabled) return false;
    var edit_button_span =
        document.getElementById('wikiwyg_edit_' + section_number);
    var edit_button = edit_button_span.getElementsByTagName('a')[0];

    edit_button.edit_button_text = wgEditCaption;
    edit_button.innerHTML = edit_button.edit_button_text;
    edit_button.onclick = function() {
    	if ((Wikiwyg.MediaWiki.sectionEdited == myWikiwyg.section_number) && Wikiwyg.MediaWiki.editInProgress) {
		myWikiwyg.cancelEdit ();
		return false;
	} else {
        	myWikiwyg.editMode();
        	return false;
	}
    }
    Wikiwyg.MediaWiki.edit_buttons.push(edit_button);

    myWikiwyg.section_number = section_number;
    return true;
}

klass.disable_wikiwyg_section = function(section_div, section_number) {
    var edit_button_span =
        document.getElementById('wikiwyg_edit_' + section_number);
    var edit_button = edit_button_span.getElementsByTagName('a')[0];
    edit_button.innerHTML = wgEditCaption;
    edit_button.onclick = null;
}

klass.canSupportWysiwyg = function(div) {
    /* now here the real fun begins */
    check_walk = function(elem) {
        for (var part = elem.firstChild; part; part = part.nextSibling) {
            if (part.nodeType == 1) {      // element
                var tag = part.nodeName;
                if (tag.match(/^(H2|P|BR|HR|UL|LI|A|S|I|B|PRE)$/)) {
                    check_walk(part);
                    continue;
                }
                if (tag == 'SPAN') {
                    var class_name = part.className;
                    if (class_name && ((class_name == 'wikiwyg-nowiki')  || (class_name == 'mw-headline'))) {
                        check_walk(part);
                        continue;
                    }
                }
                throw("This section contains stuff that is not yet handled in Wysiwyg mode");
            }
            else if (part.nodeType == 3) { // text
            }
            else if (part.nodeType == 8) { // comment
            }
        }
    }
//    return true;
    try {check_walk(div)} catch(e) { return false; }
    return true;
}

proto.editMode = function() {
    if (Wikiwyg.MediaWiki.editInProgress) {
    	/* an open section exists, ask whether to abandon it or not */
	/* todo check if we have any changes */
	var c = confirm ("Another section is already opened. Do you wish to discard changes and open a new one?");
	if (c) {
		Wikiwyg.MediaWiki.instance.cancelEdit ();
	} else {
		return;
	}
    }
    needToConfirm = true;
    Wikiwyg.MediaWiki.editInProgress = true;
    Wikiwyg.MediaWiki.sectionEdited = this.section_number;
    Wikiwyg.MediaWiki.instance = this;
    this.disableEditButtons (this.section_number);
    if ( !this.getRawPage() ) {
    	Wikiwyg.MediaWiki.editInProgress = false;
	this.enableEditButtons ();
	return;
    }
    this.disableDoubleClicks();

    if ( Wikiwyg.MediaWiki.canSupportWysiwyg(this.div) ) {
    	if (wgFullPageEditing == true) {
		var cookieName = "WikiwygFPEditMode";
	} else {
		var cookieName = "WikiwygEditMode";
	}
        if (wgUseWysiwyg == 0) {
		var modeName = "Wikiwyg.Wikitext.MediaWiki" ;
	} else {
    		/* change that to correspond */
		    if (wgDefaultMode == 'wysiwyg') {
			var modeName = 'Wikiwyg.Wysiwyg.MediaWiki';
		    } else {
			var modeName = 'Wikiwyg.Wikitext.MediaWiki';
		    }
	        //var modeName = Cookie.get (cookieName);
	}
        if ( modeName ) {
            this.first_mode = this.modeByName(modeName);
        } else {
            Cookie.set (cookieName, this.first_mode.classname);
        }
        // Fake click on mode radio.
        var modeRadios = this.toolbarObject.div.getElementsByTagName("input");
        for ( var i = 0; i < modeRadios.length; i++ ) {
            if( modeRadios[i].value == modeName ) {
                this.toolbarObject.firstModeRadio = modeRadios[i];
                break;
            }
        }
    }
    Wikiwyg.prototype.editMode.call(this);
    needToConfirm = true;
}

proto.switchMode = function(new_mode_key) {
    if ( Wikiwyg.MediaWiki.canSupportWysiwyg(this.div) ) {
        if ( ! new_mode_key.match(/preview/i) ) {
            Cookie.set("WikiwygEditMode", new_mode_key);
        }
    }
    var new_mode = this.modeByName(new_mode_key);
    this.toolbarObject.changeMode ();
    Wikiwyg.prototype.switchMode.call(this, new_mode_key);
}

proto.disableEditButtons = function(section_number) {
    // Disable the main page button but save the old values
    // in case the user does cancels the edit.
    if (Wikiwyg.MediaWiki.main_edit_button){
	    Wikiwyg.MediaWiki.main_edit_button.old_href =
	        Wikiwyg.MediaWiki.main_edit_button.getAttribute('href');
	    Wikiwyg.MediaWiki.main_edit_button.old_color =
	        Wikiwyg.MediaWiki.main_edit_button.style.color;
	    Wikiwyg.MediaWiki.main_edit_button.style.color = 'black';
	    Wikiwyg.MediaWiki.main_edit_button.removeAttribute('href');
    }

    var buttons = Wikiwyg.MediaWiki.edit_buttons;
    for (var i = 0; i < buttons.length; i++) {
        var button = buttons[i];
	if ((i+1) == section_number) {
      		button.innerHTML = wgCancelCaption;
		button.parentNode.style.display = 'none';
	}
    }
}

proto.enableEditButtons = function () {
    if (Wikiwyg.MediaWiki.main_edit_button){
	Wikiwyg.MediaWiki.main_edit_button.setAttribute(
			'href', Wikiwyg.MediaWiki.main_edit_button.old_href
			);
	Wikiwyg.MediaWiki.main_edit_button.style.color =
		Wikiwyg.MediaWiki.main_edit_button.old_color;
    }
	var buttons = Wikiwyg.MediaWiki.edit_buttons;
	for (var i = 0; i < buttons.length; i++) {
		var button = buttons[i];
		button.innerHTML = button.edit_button_text;
		button.parentNode.style.display = 'inline';
	}
}

proto.getRawPage = function() {
//	if (this.config.modeClasses[0].match(/Wysiwyg/)) return true;
    	if (! this.raw_section_orig) {
        	this.raw_section_orig = this.get_raw_section();
	}
    	this.raw_section = this.raw_section_orig;
	if (!this.raw_section) {
		return false;
	}
	return true;
}

proto.get_raw_section = function() {
    var url = location.toString().replace(/#.*/, '');
	/* look out for titles already containing title... */
	if (url.match ('/title/') != '') {
		var correctPath = '';
		if (wgArticlePath.match (/\/\$1/) != '') {
			correctPath = wgArticlePath.replace (/\$1/, '');
			if(wgArticlePath.indexOf('?') > 0) {
	   			url = wgServer + correctPath + encodeURI(wgPageName) + "&action=edit" + "&section=" + this.section_number;
	   		} else {
	   			url = wgServer + correctPath + encodeURI(wgPageName) + "?action=edit" + "&section=" + this.section_number;
	   		}
		} else {
			correctPath = wgArticlePath.replace (/\?title=\$1/, '');
       			url = wgServer + correctPath + "?title=" + encodeURI(wgPageName) + "&action=edit" + "&section=" + this.section_number;
		}
	} else {
	    	var page_title = url.replace(/.*index\.php\/(\w+).*/, '$1');
		url = url.replace(/(.*index\.php).*/, '$1');
	    	url = url +
        	"?title=" + encodeURI(wgPageName) +
        	"&action=edit" +
        	"&section=" + this.section_number;
    	}

    var html = WKWAjax.get(url);

    /* 	do not allow blocked users to edit...
    	it won't actually save, but will it look nice?
    */
    if (html.match (/<textarea[^>]*?readonly=\"readonly\"[^>]*?>/) ) {
    	return false;
    }

    /*	fetch things like wpStarttime and wpEdittime _here_
    */

    var matched_sttime = html.match(
	/<input[^>]*? name=\"wpStarttime\" \/>/
    );

    var matched_edtime = html.match(
	/<input[^>]*? name=\"wpEdittime\" \/>/
    );

    if (matched_sttime && matched_edtime) {
	    var starttime = matched_sttime[0];
	    var edittime = matched_edtime[0];

	    starttime = starttime.match (
		/[0-9]+/
	    );
	    edittime = edittime.match (
		/[0-9]+/
	    );
	    var starttime = starttime[0];
	    var edittime = edittime[0];
	    Wikiwyg.MediaWiki.starttime = starttime;
	    Wikiwyg.MediaWiki.edittime = edittime;
    }

    var raw_text = html.replace(
        /[\s\S]*<textarea[^>]*?>([\s\S]*)<\/textarea>[\s\S]*/,
        '$1'
    );

    raw_text = raw_text
        .replace(/\&lt;/g, '<')
        .replace(/\&gt;/g, '>')
        .replace(/\&amp;/g, '&')
	.replace(/\&quot;/g,'"');

    return raw_text;
    // XXX Use code like this when action=raw is fixed in 1.7a
    // var sections = raw_text.match(/\n== [\s\S]*?(?=(\n== |$))/g);
    // if (!sections) return;
    // this.raw_section = sections[this.section_number - 1].
    //     replace(/^\n/, '');
}

proto.disableDoubleClicks = function () {
    var wikiwyg_divs = grepElementsByTag('span',
        function(e) { return e.id.match(/^wikiwyg_section_\d+$/) }
    );
    this.wikiwyg_divs_ondblclick = new Array();
    for ( var i = 0; i < wikiwyg_divs.length; i++ ) {
        this.wikiwyg_divs_ondblclick[i] = wikiwyg_divs[i].ondblclick;
        wikiwyg_divs[i].ondblclick = function() {return false; };
    }
}

proto.cancelEdit = function() {
    Wikiwyg.MediaWiki.editInProgress = false;
    this.displayMode();
    this.toolbarObject.disableMessage();
    if (Wikiwyg.MediaWiki.main_edit_button){
	    Wikiwyg.MediaWiki.main_edit_button.setAttribute(
	        'href', Wikiwyg.MediaWiki.main_edit_button.old_href
	    );
	    Wikiwyg.MediaWiki.main_edit_button.style.color =
	        Wikiwyg.MediaWiki.main_edit_button.old_color;
    }
    var buttons = Wikiwyg.MediaWiki.edit_buttons;
    for (var i = 0; i < buttons.length; i++) {
        var button = buttons[i];
        button.innerHTML = button.edit_button_text;
	button.parentNode.style.display = 'inline';
    }
    var wikiwyg_divs = grepElementsByTag('span',
        function(e) { return e.id.match(/^wikiwyg_section_\d+$/) }
    );
    for ( var i = 0; i < wikiwyg_divs.length; i++ ) {
        wikiwyg_divs[i].ondblclick = this.wikiwyg_divs_ondblclick[i];
    }
    /* if show diff, disable it */
    var diff_div = document.getElementById ('wikiwyg_diff_wrapper');
    if (diff_div) {
	this.toolbarObject.rebuildDiffs ();
    }
    if (this.current_mode.classname.match(/Preview/)) {
	this.toolbarObject.rebuild ();
    }
    needToConfirm = false;
}

proto.get_page_title = function() {
    return String(window.location).replace(/.*\//, '').replace(/.*title=/, '').replace(/;.*/, '').replace(/#.*/,'');
}

// XXX This all seems so fragile and crufty...
proto.submit_action_form = function(action, value) {
    var self = this;
    var page_title = wgPageName;
    var url = fixupRelativeUrl(
        'index.php?title=' + page_title + '&action=edit&section=' + this.section_number
    );
    var tempIFrame=document.createElement('iframe');
    tempIFrame.setAttribute('id','RSIFrame');
    tempIFrame.style.height = "1px";
    tempIFrame.style.width = "1px";
    var IFrameObj = document.body.appendChild(tempIFrame);
    var IFrameDoc = Wikiwyg.is_ie
        ? IFrameObj.contentWindow.document
        : IFrameObj.contentDocument;
    IFrameDoc.location.replace(url);

    var check_doc = function(doc) {
        if (typeof doc.getElementsByTagName != 'undefined'
         && typeof doc.getElementById != 'undefined'
         && ( doc.getElementsByTagName('body')[0] != null
              || doc.body != null ) ) {
                return true;
        }
        return false;
    }

    var condition = function() {
        var IFrameDoc = Wikiwyg.is_ie
            ? IFrameObj.contentWindow.document
            : IFrameObj.contentDocument;
        if (!check_doc(IFrameDoc)) return false;
        form = IFrameDoc.getElementById('editform');
        return (form)? true: false;
    }
    var callback = function() {
        var IFrameDoc = Wikiwyg.is_ie
            ? IFrameObj.contentWindow.document
            : IFrameObj.contentDocument;
        form.wpTextbox1.value = value.wpTextbox1;
	form.wpSummary.value = value.wpSummary;
        if (typeof wgUserName == 'string') {
		form.wpMinoredit.value = 1;
		form.wpWatchthis.value = 1;
		/* checkboxes, ah */
		form.wpMinoredit.checked = value.wpMinoredit;
		form.wpWatchthis.checked = value.wpWatchthis;
	}
	/* also give variables needed for edit conflicts... */
	form.wpEdittime.value = Wikiwyg.MediaWiki.edittime;
  	form.wpStarttime.value = Wikiwyg.MediaWiki.starttime;
        form.submit();
        wait(function() {
	    // fix this up to *always* write
		return (check_doc(IFrameDoc)) ? true : false;
        },function() {
            // Without remove tempIFrame here, the page scrolls down
            // to the bottom, where the tempIFrame is located.
      //      document.body.removeChild(tempIFrame);
          self.cancelEdit ();
            // XXX CrappyHack for save until we figure out how
            // to submit without iframe.
            setTimeout(function() {
                // With this setTimeout it avoids page for being cached.
                // Without this setTimeout the reloaded page is usually
                // a cached one, weird.
		document.body.removeChild(tempIFrame);
		form.reset();
                location.reload();
            }, 400);
        });
    }
    wait(condition, callback);
}

proto.imageUpload = function (tagOpen, tagClose, sampleText) {
	Wikiwyg.prototype.imageUpload.call (this, tagOpen, tagClose, sampleText);
}

proto.saveChanges = function() {
    var page_title = encodeURI(wgPageName);
    var summary = document.getElementById ('wpSummary_'+ this.section_number).value;    
    var self = this;
    if (typeof wgUserName == 'string') {
    	    var minoredit = document.getElementById ('wpMinoredit_'+ this.section_number).checked;
	    var watchthis = document.getElementById ('wpWatchthis_'+ this.section_number).checked;
	    var submit_changes = function(wikitext) {
        	self.submit_action_form(
	            fixupRelativeUrl('index.php'),
	            {
	            'title': page_title,
	            'action': "submit",
	            'wpSection': self.section_number,
	            'wpTextbox1': wikitext,
		    'wpSummary' : summary,
		    'wpMinoredit' : minoredit,
		    'wpWatchthis' : watchthis,
	            'wpSave': "Save page"
	            }
	        );
	    }
    } else {	
	    var submit_changes = function(wikitext) {
        	self.submit_action_form(
	            fixupRelativeUrl('index.php'),
	            {
	            'title': page_title,
	            'action': "submit",
	            'wpSection': self.section_number,
	            'wpTextbox1': wikitext,
		    'wpSummary' : summary,
	            'wpSave': "Save page"
	            }
	        );
	    }
    }
    var self = this;
    if (this.raw_section) {
//    	submit_changes(this.raw_section);
    }
    if (this.current_mode.classname.match(/(Wysiwyg|Preview)/)) {
        this.current_mode.toHtml(
            function(html) {
                var wikitext_mode = self.mode_objects['Wikiwyg.Wikitext.MediaWiki'];
                wikitext_mode.convertHtmlToWikitext(
                    html,
                    function(wikitext) { submit_changes(wikitext) }
                );
            }
        );
    }
    else {
        submit_changes(this.current_mode.toWikitext());
    }

    this.current_mode.toHtml( function(html) {
        self.div.innerHTML = html;
    });
}

//------------------------------------------------------------------------------
proto = new Subclass('Wikiwyg.Toolbar.MediaWiki', 'Wikiwyg.Toolbar');

proto.config = {
    divId: null,
    imagesLocation: 'images/' ,
    imagesExtension: '.png' ,
    controlLayout: [
        'bold', 'italic', 'strike' ,
        'www' , 'link' ,
	'h1', 'h2', 'h3',
         'p' ,
        'hr' ,
        'unordered', 'ordered' ,
	'|l' ,
	'insertimage' ,
        '[' ,
        'mode_selector' ,
	'|r' ,
	'save' ,
        '|r' ,
	'cancel' ,
	']' ,
	'|l' ,
	'help'
    ],
    controlLabels: {
        save: wgSaveCaption ,
        cancel: wgCancelCaption ,
	insertimage: wgInsertImageCaption ,
	help: wgHelpCaption ,
        bold: wgBoldTip +' (Ctrl+b)',
        italic: wgItalicTip + ' (Ctrl+i)',
        hr: wgHrTip ,
        ordered: 'Numbered List',
        unordered: 'Bulleted List',
        indent: 'More Indented',
        outdent: 'Less Indented',
        label: '[Style]',
        p: wgNowikiTip ,
        pre: 'Preformatted',
        h1: 'Heading 1',
        h2: 'Heading 2',
        h3: 'Heading 3',
        h4: 'Heading 4',
	timestamp : wgTimestampTip ,
        link: wgIntlinkTip ,
	www: wgExtlinkTip ,
	template: 'insert Template' ,
        table: 'Create Table'
    }
};

proto.make_button = function(type, label) {
    var base = this.config.imagesLocation;
    var ext = this.config.imagesExtension;
    return Wikiwyg.createElementWithAttrs(
        'img', {
            'class': 'wikiwyg_button',
            alt: label,
            title: label,
	    id: 'wikiwyg_button_' + type + '_' + this.section_number ,
            src: base + type + ext
        }
    );
}

proto.enableMessage = function () {
    if ( !this.toolbar_message ) {
        this.toolbar_message = document.createElement("div");
        this.div.parentNode.insertBefore(this.toolbar_message,
                                         this.div);
        /*
         Make sure the div and the message occupy same height on
         screen to prevent editing area from being jumpy.
        */
        with (this.toolbar_message) {
            innerHTML            = "Loading";
            style.textDecoration = "blink";
            style.color          = "green";
            style.background     = "#fff";
            style.fontWeight     = "bold";
            style.width          = WKWgetStyle(this.div, "width");
            style.height         = WKWgetStyle(this.div, "height");
            style.marginTop      = WKWgetStyle(this.div, "margin-top")
            style.marginBottom   = WKWgetStyle(this.div, "margin-bottom")
            style.lineHight      = WKWgetStyle(this.div, "line-height")
            style.fontSize       = WKWgetStyle(this.div, "font-size")
        }
    }
    this.toolbar_message.style.display = "block";
}

proto.disableMessage = function () {
    if ( this.toolbar_message ) {
        this.toolbar_message.style.display = "none";
    }
}


proto.getButtons = function() {
    var buttons = new Array();
    var b = this.div.childNodes;
    for ( var i = 0; i < b.length; i++ ) {
        if ( b[i].className && b[i].className.match(/wikiwyg_button/) ) {
            buttons.push(b[i]);
        }
    }
    return buttons;
}

proto.disableButtons = function (section_number) {
    var buttons = this.getButtons();
    this.button_handlers = new Array();
    for ( var i = 0; i < buttons.length; i++ ) {
        buttons[i].className = "wikiwyg_button_disabled";
        this.button_handlers.push(buttons[i].onclick);
        buttons[i].onclick = function() { return false;};
    }
}

proto.enableButtons = function() {
    if ( !this.button_handlers ) { return; }
    var buttons = this.getButtons();
    for ( var i = 0; i < buttons.length; i++ ) {
        buttons[i].className = "wikiwyg_button";
        buttons[i].onclick = this.button_handlers[i];
    }
}

//------------------------------------------------------------------------------
proto = new Subclass('Wikiwyg.Wysiwyg.MediaWiki', 'Wikiwyg.Wysiwyg');

// CSS Override here.
proto.apply_stylesheets = function() {
    Wikiwyg.Wysiwyg.prototype.apply_stylesheets.apply(this, arguments);
    var head = this.get_edit_document().getElementsByTagName("head")[0];
    var style_string = "body { font-size: small; }";
    this.append_inline_style_element(style_string, head);
}

proto.enableStarted = function () {
    this.wikiwyg.toolbarObject.disableThis();
    this.wikiwyg.toolbarObject.enableMessage();
}

proto.enableFinished = function (){
    this.wikiwyg.toolbarObject.enableThis();
    this.wikiwyg.toolbarObject.disableMessage();
}

// a first strike tactic on templates and other stuff
// fetch the wikitext and then convert to html
// don't operate on plain html in any case
proto.initHtml = function(html) {
    var dom = document.createElement('div');
    dom.innerHTML = html;
    var myInstance = Wikiwyg.MediaWiki.instance;
    var wikitext_mode = myInstance.mode_objects['Wikiwyg.Wikitext.MediaWiki'];
    wikitext_mode.fixChangedStructure (dom);
    var fixed_content = myInstance.raw_section;
    // do things with stuff here
    fixed_content = this.disableTemplates (fixed_content);
    var self = this;
    wikitext_mode.convertWikitextToHtml (
    	fixed_content,
	function (html) {
		self.set_inner_html (self.sanitize_html (html) );
	}
    );
}

// for future use
proto.disableTemplates = function (wikitext) {    	    
	wikitext = wikitext.replace (/\{\{.+\}\}/gi, '');
	return wikitext;
}

proto.fromHtml = function(html) {
    var dom = document.createElement('div');
    dom.innerHTML = html;
    var myInstance = Wikiwyg.MediaWiki.instance;
    var wikitext_mode = myInstance.mode_objects['Wikiwyg.Wikitext.MediaWiki'];
    wikitext_mode.fixChangedStructure (dom);
    html = dom.innerHTML;
    this.set_inner_html(this.sanitize_html(html));
}


//------------------------------------------------------------------------------
proto = new Subclass('Wikiwyg.Wikitext.MediaWiki', 'Wikiwyg.Wikitext');

proto.initHtml = function (html) {
    this.fromHtml (html);
}

proto.fromHtml = function(html) {
//	this.wikiwyg.previous_mode.classname;
	if (!this.wikiwyg.previous_mode) {
		this.setTextArea(this.wikiwyg.raw_section);
		delete this.wikiwyg.raw_section;
		return;
	}
	if (this.wikiwyg.raw_section && (!this.wikiwyg.previous_mode.classname.match(/Wysiwyg/))) {
		this.setTextArea(this.wikiwyg.raw_section);
		delete this.wikiwyg.raw_section;
		return;
	}
        Wikiwyg.Wikitext.prototype.fromHtml.call(this, html);
}

proto.toHtml = function(func) {
    var wikitext = this.canonicalText();
    if (this.wikiwyg.raw_section_orig)
        this.wikiwyg.raw_section = wikitext;
    this.convertWikitextToHtml(wikitext, func);
}

proto.convertWikitextToHtml = function(wikitext, func) {
    WKWAjax.post(
        fixupRelativeUrl('index.php/' + wgSpecialPrefix + ':EZParser') + "&rtitle=" + wgPageName,
        "text=" + encodeURIComponent(wikitext),
        func
    );
}

proto.collapse = function(string) {
    string = string.replace(/&(\w)/g, '&amp;$1');
    return string.replace(/[ \u00a0\r\n]+/g, ' ');
}

/*
proto.convert_html_to_wikitext = function(html) {
    var ret = Wikiwyg.Wikitext.prototype.convert_html_to_wikitext.call(this, html);
    // Post-processing the converted wikitext.
    // MediaWiki's wikitext treat these HTML entities to be real HTML entities.
    // Therefore, we escape them here because the conversion makes them normal text.
    ret = ret.replace(/&/g,"&amp;")
        .replace(/</g,"&lt;")
        .replace(/>/g,"&gt;");
    return ret;
}
*/

proto.config = {
    textareaId: null,
    supportCamelCaseLinks: false,
    javascriptLocation: null,
    clearRegex: null,
    editHeightMinimum: 10,
    editHeightAdjustment: 1.3,
    markupRules: {
        link: ['bound_phrase', '[[', ']]'],
        www: ['bound_phrase', '[', ']'],
        bold: ['bound_phrase', "'''", "'''"],
        italic: ['bound_phrase', "''", "''"],
        strike: ['bound_phrase', "<s>", "</s>"],
        pre: ['start_lines', '    '],
        p: ['bound_line', '', ''],
        h1: ['bound_line', '= ', ' ='],
        h2: ['bound_line', '== ', ' =='],
        h3: ['bound_line', '=== ', ' ==='],
        h4: ['bound_line', '==== ', ' ===='],
        ordered: ['start_lines', '#'],
        unordered: ['start_lines', '*'],
        indent: ['start_lines', ''],
        hr: ['line_alone', '----'],
	timestamp: ['line_alone', '~~~~'] ,
        table: ['line_alone', '| A | B | C |\n|   |   |   |\n|   |   |   |']
    }
}

proto.enableStarted = function () {
    this.wikiwyg.toolbarObject.disableThis();
    this.wikiwyg.toolbarObject.enableMessage();
}

proto.enableFinished = function (){
    this.wikiwyg.toolbarObject.enableThis();
    this.wikiwyg.toolbarObject.disableMessage();
    this.textarea.style.height = '250px';
}

proto.normalizeDomWhitespace = function(dom) {
    Wikiwyg.Wikitext.prototype.normalizeDomWhitespace.call(this, dom);
    var tags = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'li'];
    for (var ii = 0; ii < tags.length; ii++) {
        var elements = dom.getElementsByTagName(tags[ii]);
        for (var i = 0; i < elements.length; i++) {
            var element = elements[i];
            if (element.firstChild && element.firstChild.nodeType == '3') {
                element.firstChild.nodeValue =
                    element.firstChild.nodeValue.replace(/^\s*/, '');
            }
            if (element.lastChild && element.lastChild.nodeType == '3') {
                element.lastChild.nodeValue =
                    element.lastChild.nodeValue.replace(/\s*$/, '');
            }
        }
    }
}

proto.do_indent = function() {
    this.selection_mangle(
        function(that) {
            if (that.sel == '') return false;
            that.sel = that.sel.replace(/^(([\*\#])+(?=\s))/gm, '$2$1');
            that.sel = that.sel.replace(/^([\=])/gm, '$1$1');
            that.sel = that.sel.replace(/([\=])$/gm, '$1$1');
            that.sel = that.sel.replace(/\={7,}/gm, '======');
            return true;
        }
    )
}

proto.do_outdent = function() {
    this.selection_mangle(
        function(that) {
            if (that.sel == '') return false;
            that.sel = that.sel.replace(/^([\*\#] ?)/gm, '');
            that.sel = that.sel.replace(/^\= ?/gm, '');
            that.sel = that.sel.replace(/ ?\=$/gm, '');
            return true;
        }
    )
}

proto.do_p = function() {
    this.selection_mangle(
        function(that) {
            if (that.sel == '') return false;
            that.sel = that.sel.replace(/^\=* */gm, '');
            that.sel = that.sel.replace(/ *\=*$/gm, '');
            return true;
        }
    )
}

proto.format_div = function(element) {
    if (! this.previous_was_newline_or_start())
        this.insert_new_line();

    this.walk(element);
    this.assert_blank_line();
}

//------------------------------------------------------------------------------
proto = new Subclass('Wikiwyg.Preview.MediaWiki', 'Wikiwyg.Preview');

proto.fromHtml = function(html) {
    if ( this.wikiwyg.previous_mode.classname.match(/Wysiwyg/) ) {
        var self = this;
        this.wikiwyg.previous_mode.toHtml(
            function(html) {
                var wikitext_mode = self.wikiwyg.mode_objects['Wikiwyg.Wikitext.MediaWiki'];
                wikitext_mode.convertHtmlToWikitext(
                    html,
                    function(wikitext) {
                        wikitext_mode.convertWikitextToHtml(
                            wikitext,
                            function(html) {
                                // Strip wrapper tags from ezparser.
                                html = html
                                    .replace(/<\/span><iframe.*/i,"")
                                    .replace(/^.*<span.*?class="wikiwyg_section".*?>/i,"");
                                Wikiwyg.Preview.prototype.fromHtml.call(self, html);
                            }
                        )
                    }
                )
            }
        )
    } else {
        Wikiwyg.Preview.prototype.fromHtml.call(this, html);
    }
}

proto.enableStarted = function () {
    this.wikiwyg.toolbarObject.disableThis();
    this.wikiwyg.toolbarObject.enableMessage();
}

proto.enableFinished = function (){
    this.wikiwyg.toolbarObject.enableThis();
    this.wikiwyg.toolbarObject.disableMessage();
    this.wikiwyg.toolbarObject.disableButtons();
}

proto.disableStarted = function () {
    Wikiwyg.Preview.prototype.disableStarted.apply(this, arguments);
    this.wikiwyg.toolbarObject.enableButtons();
}
