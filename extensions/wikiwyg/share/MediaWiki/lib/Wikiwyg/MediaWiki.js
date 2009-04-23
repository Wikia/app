/* ToDo:

    == Numbered tickets can be found in http://trac.wikiwyg.net/trac/report/1

*/

// XXX CrappyHacks to get around mediawiki/config stuff.
// These hacks should be removed eventually.

// This fixes some mediawiki js error that pops up at various times.
if (typeof(LivePreviewInstall) == 'undefined')
    LivePreviewInstall = function() {};

function fixupRelativeUrl(url) {
    var loc = String(location);
    var base = loc.replace(/index\.php.*/, '');
    if (base == loc)
        base = loc.replace(/(.*\/wiki\/).*/, '$1');
    if (base == loc)
        throw("fixupRelativeUrl error: " + loc);
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
})();

//------------------------------------------------------------------------------

proto = new Subclass('Wikiwyg.MediaWiki', 'Wikiwyg');
klass = Wikiwyg.MediaWiki;
klass.edit_buttons = [];

klass.initialize = function() {
    if (! Wikiwyg.browserIsSupported) return;

    var wikiwyg_divs = grepElementsByTag('div',
        function(e) { return e.id.match(/^wikiwyg_section_\d+$/) }
    );
    Wikiwyg.MediaWiki.wikiwyg_divs = wikiwyg_divs;
    if (! Wikiwyg.MediaWiki.wikiwyg_enabled()) return;
    Wikiwyg.MediaWiki.enable();
}

klass.wikiwyg_enabled = function() {
    Wikiwyg.MediaWiki.main_edit_button = findEditLink();
    if (! Wikiwyg.MediaWiki.main_edit_button) return false;
    try {
        var div = document.getElementById('p-tb');
        var ul = div.getElementsByTagName('ul')[0];
    } catch(e) {return false}
    var li = document.createElement('li');
    ul.appendChild(li);
    var a = Wikiwyg.createElementWithAttrs('a', {
        id: 'wikiwyg-enabler',
        href: '#'
    });
    li.appendChild(a);

    var enabled = Cookie.get('wikiwyg_enabled');
    if (! enabled) enabled = "false";
    enabled = eval(enabled);
    Cookie.set('wikiwyg_enabled', String(enabled));

    a.innerHTML = enabled
        ? 'Wikiwyg Enabled'
        : 'Wikiwyg Disabled';
    a.onclick = enabled
        ? Wikiwyg.MediaWiki.disable
        : Wikiwyg.MediaWiki.enable;

    return enabled;
}

klass.enable = function() {
    if (Wikiwyg.MediaWiki.busy) return false;
    if (Wikiwyg.MediaWiki.checkEditInProgress()) return false;
    Wikiwyg.MediaWiki.busy = true;
    a = document.getElementById('wikiwyg-enabler');
    a.innerHTML = 'Wikiwyg Enabled';
    a.onclick = Wikiwyg.MediaWiki.disable;
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
    a = document.getElementById('wikiwyg-enabler');
    a.innerHTML = 'Wikiwyg Disabled';
    a.onclick = Wikiwyg.MediaWiki.enable;
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
            imagesLocation: '/wikiwyg/share/MediaWiki/images/',
            imagesExtension: '.gif'
        },
        wysiwyg: {
            iframeId: 'wikiwyg_iframe_' + section_number
        },
        modeClasses: [
            'Wikiwyg.Wysiwyg.MediaWiki',
            'Wikiwyg.Wikitext.MediaWiki',
            'Wikiwyg.Preview.MediaWiki'
        ]
    }

    var hasWysiwyg = true;
    if (! klass.canSupportWysiwyg(section_div)) {
        hasWysiwyg = false;
        myConfig.modeClasses.shift();
    }

    var myWikiwyg = new Wikiwyg.MediaWiki();
    myWikiwyg.createWikiwygArea(section_div, myConfig);
    if (! myWikiwyg.enabled) return false;
    var edit_button_span =
        document.getElementById('wikiwyg_edit_' + section_number);
    var edit_button = edit_button_span.getElementsByTagName('a')[0];

    edit_button.edit_button_text = hasWysiwyg
        ? 'Wikiwyg Edit'
        : 'Quick Edit';
    edit_button.innerHTML = edit_button.edit_button_text;
    edit_button.onclick = function() {
        myWikiwyg.editMode();
        return false;
    }
    Wikiwyg.MediaWiki.edit_buttons.push(edit_button);

    myWikiwyg.section_number = section_number;
    return true;
}

klass.disable_wikiwyg_section = function(section_div, section_number) {
    var edit_button_span =
        document.getElementById('wikiwyg_edit_' + section_number);
    var edit_button = edit_button_span.getElementsByTagName('a')[0];

    edit_button.innerHTML = 'edit';
    edit_button.onclick = null;
}

klass.canSupportWysiwyg = function(div) {
    check_walk = function(elem) {
        for (var part = elem.firstChild; part; part = part.nextSibling) {
            if (part.nodeType == 1) {      // element
                var tag = part.nodeName;
                if (tag.match(/^(H2|P|BR|HR|UL|LI|A|S)$/)) {
                    check_walk(part);
                    continue;
                }
                if (tag == 'SPAN') {
                    var class_name = part.className;
                    if (class_name && (class_name == 'wikiwyg-nowiki')) {
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
    try {check_walk(div)} catch(e) {return false}
    return true;
}

proto.editMode = function() {
    Wikiwyg.MediaWiki.editInProgress = true;
    this.disableEditButtons();
    this.getRawPage();
    this.disableDoubleClicks();

    if ( Wikiwyg.MediaWiki.canSupportWysiwyg(this.div) ) {
        var modeName = Cookie.get("WikiwygEditMode");
        if ( modeName ) {
            this.first_mode = this.modeByName(modeName);
        } else {
            Cookie.set("WikiwygEditMode", this.first_mode.classname);
        }
        // Fake click on mode radio.
        var modeRadios = this.toolbarObject.div.getElementsByTagName("input");
        for ( var i = 0; i < modeRadios.length ; i++ ) {
            if( modeRadios[i].value == modeName ) {
                this.toolbarObject.firstModeRadio = modeRadios[i];
                break;
            }
        }
    }
    Wikiwyg.prototype.editMode.call(this);
}


proto.switchMode = function(new_mode_key) {
    if ( Wikiwyg.MediaWiki.canSupportWysiwyg(this.div) ) {
        if ( ! new_mode_key.match(/preview/i) ) {
            Cookie.set("WikiwygEditMode", new_mode_key);
        }
    }
    var new_mode = this.modeByName(new_mode_key);
    Wikiwyg.prototype.switchMode.call(this, new_mode_key);
}


proto.disableEditButtons = function() {
    // Disable the main page button but save the old values
    // in case the user does cancels the edit.
    Wikiwyg.MediaWiki.main_edit_button.old_href =
        Wikiwyg.MediaWiki.main_edit_button.getAttribute('href');
    Wikiwyg.MediaWiki.main_edit_button.old_color =
        Wikiwyg.MediaWiki.main_edit_button.style.color;
    Wikiwyg.MediaWiki.main_edit_button.style.color = 'black';
    Wikiwyg.MediaWiki.main_edit_button.removeAttribute('href');

    var buttons = Wikiwyg.MediaWiki.edit_buttons;
    for (var i = 0; i < buttons.length; i++) {
        var button = buttons[i];
        button.innerHTML = '';
    }
}

proto.getRawPage = function() {
    if (this.config.modeClasses[0].match(/Wysiwyg/)) return;    
    if (! this.raw_section_orig)
        this.raw_section_orig = this.get_raw_section();
    this.raw_section = this.raw_section_orig;
}

proto.get_raw_section = function() {
    var url = location.toString().replace(/#.*/, '');
    var page_title = url.replace(/.*index\.php\/(\w+).*/, '$1');
    url = url.replace(/(.*index\.php).*/, '$1');
    url = url +
        "?title=" + page_title + 
        "&action=edit" +
        "&section=" + this.section_number;
    var html = WKWAjax.get(url);
    var raw_text = html.replace(
        /[\s\S]*<textarea[^>]*?>([\s\S]*)<\/textarea>[\s\S]*/,
        '$1'
    );
    raw_text = raw_text
        .replace(/\&lt;/g, '<')
        .replace(/\&gt;/g, '>')
        .replace(/\&amp;/g, '&');
    return raw_text;
    // XXX Use code like this when action=raw is fixed in 1.7a 
    // var sections = raw_text.match(/\n== [\s\S]*?(?=(\n== |$))/g);
    // if (!sections) return;
    // this.raw_section = sections[this.section_number - 1].
    //     replace(/^\n/, '');
}

proto.disableDoubleClicks = function () {
    var wikiwyg_divs = grepElementsByTag('div',
        function(e) { return e.id.match(/^wikiwyg_section_\d+$/) }
    );
    this.wikiwyg_divs_ondblclick = new Array();
    for ( var i = 0 ; i < wikiwyg_divs.length ; i++ ) {
        this.wikiwyg_divs_ondblclick[i] = wikiwyg_divs[i].ondblclick;
        wikiwyg_divs[i].ondblclick = function() {return false; };
    }
}

proto.cancelEdit = function() {
    Wikiwyg.MediaWiki.editInProgress = false;
    this.displayMode();
    this.toolbarObject.disableMessage();

    Wikiwyg.MediaWiki.main_edit_button.setAttribute(
        'href', Wikiwyg.MediaWiki.main_edit_button.old_href
    );
    Wikiwyg.MediaWiki.main_edit_button.style.color =
        Wikiwyg.MediaWiki.main_edit_button.old_color;
    var buttons = Wikiwyg.MediaWiki.edit_buttons;
    for (var i = 0; i < buttons.length; i++) {
        var button = buttons[i];
        button.innerHTML = button.edit_button_text;
    }
    var wikiwyg_divs = grepElementsByTag('div',
        function(e) { return e.id.match(/^wikiwyg_section_\d+$/) }
    );
    for ( var i = 0 ; i < wikiwyg_divs.length ; i++ ) {
        wikiwyg_divs[i].ondblclick = this.wikiwyg_divs_ondblclick[i];
    }
}

proto.get_page_title = function() {
    return String(window.location).replace(/.*\//, '').replace(/.*title=/, '').replace(/;.*/, '').replace(/#.*/,'');
}

// XXX This all seems so fragile and crufty...
proto.submit_action_form = function(action, value) {
    var self = this;
    var page_title = this.get_page_title();
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
        form.submit();
        wait(function() {
            return (check_doc(IFrameDoc)) ? true : false;
        },function() {
            // Without remove tempIFrame here, the page scrolls down
            // to the bottom, where the tempIFrame is located.
            document.body.removeChild(tempIFrame);            
            // XXX CrappyHack for save until we figure out how
            // to submit without iframe.
            setTimeout(function() {
                // With this setTimeout it avoids page for being cached.
                // Without this setTimeout the reloaded page is usually
                // a cached one, weird.
                location.reload();
            }, 1000);
        });
    }
    wait(condition, callback);
}

proto.saveChanges = function() {
    var page_title = this.get_page_title();
    var self = this;
    var submit_changes = function(wikitext) {
        self.submit_action_form(
            fixupRelativeUrl('index.php'),
            {
            'title': page_title,
            'action': "submit",
            'wpSection': self.section_number,
            'wpTextbox1': wikitext,
            'wpSave': "Save page"
            }
        );
    }
    var self = this;
    if (this.raw_section) {
        submit_changes(this.raw_section);
    }
    else if (this.current_mode.classname.match(/(Wysiwyg|Preview)/)) {
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
    imagesLocation: 'images/',
    imagesExtension: '.png',
    controlLayout: [
        'bold', 'italic', 'strike',
        'link', 'www',
        'h2', 'p',
        'hr',
        'unordered', 'ordered', 'outdent', 'indent',
        'mode_selector', '|', 'save', '|', 'cancel'
    ],
    controlLabels: {
        save: 'Save',
        cancel: 'Cancel',
        bold: 'Bold (Ctrl+b)',
        italic: 'Italic (Ctrl+i)',
        hr: 'Horizontal Rule',
        ordered: 'Numbered List',
        unordered: 'Bulleted List',
        indent: 'More Indented',
        outdent: 'Less Indented',
        label: '[Style]',
        p: 'Normal Text',
        pre: 'Preformatted',
        h1: 'Heading 1',
        h2: 'Heading 2',
        h3: 'Heading 3',
        h4: 'Heading 4',
        link: 'Create Link',
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
            style.color          = "red";
            style.background     = "#fff";
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
    for ( var i = 0 ; i < b.length ; i++ ) {
        if ( b[i].className && b[i].className.match(/wikiwyg_button/) ) {
            buttons.push(b[i]);
        }
    }
    return buttons;
}

proto.disableButtons = function() {
    var buttons = this.getButtons();
    this.button_handlers = new Array();
    for ( var i = 0 ; i < buttons.length ; i++ ) {
        buttons[i].className = "wikiwyg_button_disabled";
        this.button_handlers.push(buttons[i].onclick);
        buttons[i].onclick = function() { return false;};
    }
}

proto.enableButtons = function() {
    if ( !this.button_handlers ) { return; }
    var buttons = this.getButtons();
    for ( var i = 0 ; i < buttons.length ; i++ ) {
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

//------------------------------------------------------------------------------
proto = new Subclass('Wikiwyg.Wikitext.MediaWiki', 'Wikiwyg.Wikitext');

proto.fromHtml = function(html) {
    if (this.wikiwyg.raw_section) {
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
        fixupRelativeUrl('index.php/Special:EZParser'),
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
}

proto.format_span = function(element) {
    var class_name = element.className;
    if (!(class_name && class_name == 'wikiwyg-nowiki')) {
        this.pass(element);
        return;
    }
    this.appendOutput('<nowiki>');
    this.no_collapse_text = true;
    this.walk(element);
    this.appendOutput('</nowiki>');
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
                                    .replace(/<\/div><iframe.*/i,"")
                                    .replace(/^.*<div.*?class="wikiwyg_section".*?>/i,"");
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
