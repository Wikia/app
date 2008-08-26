window.onload = function() {
    wikiwyg = new Wikiwyg.Kwiki();

    // Find the page name
    var elems = document.getElementsByTagName('a');
    for (var i = 0; i < elems.length; i++) {
        var match = elems[i].href.match(/action=edit;page_name=(\w+)/);
        if (match) {
            wikiwyg.page_name = match[1];
            break;
        }
    }

    if (! wikiwyg.page_name) return;

    var elements = document.getElementsByTagName('div');
    var mydiv;
    for (var i = 0; i < elements.length; i++) {
        if (elements[i].className == 'wiki') {
            mydiv = elements[i];
            break;
        }
    }

    var config = {
        doubleClickToEdit: false,
        toolbar: {
            imagesLocation: 'icons/wikiwyg/',
            controlLabels: {
                hcard: 'hCard'
            },
            controlLayout: [
                'save', 'cancel', 'mode_selector', '/',
                // 'selector',
                'h1', 'h2', 'h3', 'h4', 'p', 'pre', '|',
                'bold', 'italic', 'underline', 'strike', '|',
                'link', 'hr', 'hcard', '|',
                'ordered', 'unordered', '|',
                'indent', 'outdent', '|',
                'table'
            ]
        },
        wysiwyg: {
            iframeId: 'wikiwyg_iframe'
        },
        wikitext: {
            javascriptLocation: 'javascript/',
            supportCamelCaseLinks: true
        }
    };

    if (wikiwyg_double_click) {
        config.doubleClickToEdit = true;
    }

    wikiwyg.createWikiwygArea(mydiv, config);

    if (!wikiwyg.enabled) return;

    Wikiwyg.changeLinksMatching(
        'href', /action=edit/, 
        function() { wikiwyg.editMode(); return false }
    );
}

proto = new Subclass('Wikiwyg.Kwiki', 'Wikiwyg');

proto.submit_action_form = function(action, value) {
    value['action'] = action;
    var form = document.createElement('form');
    form.setAttribute('action', 'index.cgi');
    form.setAttribute('method', 'POST');
    for (var name in value) {
        var input = document.createElement('input');
        input.setAttribute('type', 'hidden');
        input.setAttribute('name', name);
        input.setAttribute('value', value[name])
        form.appendChild(input);
    }
    var div = this.div;
    div.parentNode.insertBefore(form, div);
    form.submit();
}

proto.saveChanges = function() {
    var self = this;
    var submit_changes = function(wikitext) {
        self.submit_action_form(
            'wikiwyg_save_wikitext',
            { 'page_name': self.page_name, 'content': wikitext }
        );
    }
    var self = this;
    if (this.current_mode.classname.match(/Wikitext/)) {
        submit_changes(this.current_mode.toWikitext());
    }
    else {
        this.current_mode.toHtml(
            function(html) {
                var wikitext_mode = self.mode_objects['Wikiwyg.Wikitext.Kwiki'];
                wikitext_mode.convertHtmlToWikitext(
                    html,
                    function(wikitext) { submit_changes(wikitext) }
                );
            }
        );
    }
};

proto.modeClasses = [
    'Wikiwyg.Wysiwyg',
    'Wikiwyg.Wikitext.Kwiki',
    'Wikiwyg.Preview.Kwiki',
    'Wikiwyg.HTML'
];

proto.call_action = function(action, content, func) {
    var postdata = 'action=' + action + 
                   ';page_name=' + this.page_name + 
                   ';content=' + encodeURIComponent(content);
    Wikiwyg.liveUpdate(
        'POST',
        'index.cgi',
        postdata,
        func
    );
}

proto = new Subclass('Wikiwyg.Wikitext.Kwiki', 'Wikiwyg.Wikitext');

proto.convertWikitextToHtml = function(wikitext, func) {
    this.wikiwyg.call_action('wikiwyg_wikitext_to_html', wikitext, func);
}

proto.markupRules = {
    ordered: ['start_lines', '0'],
    code: ['bound_phrase', '[=', ']']
};

proto = new Subclass('Wikiwyg.Preview.Kwiki', 'Wikiwyg.Preview');

proto.fromHtml = function(html) {
    if (this.wikiwyg.previous_mode.classname.match(/(Wysiwyg|HTML)/)) {
        var wikitext_mode = this.wikiwyg.mode_objects['Wikiwyg.Wikitext.Kwiki'];
        var self = this;
        wikitext_mode.convertWikitextToHtml(
            wikitext_mode.convert_html_to_wikitext(html),
            function(new_html) { self.div.innerHTML = new_html }
        );
    }
    else {
        this.div.innerHTML = html;
    }
}

/*==============================================================================
Support for Internet Explorer in Wikiwyg
 =============================================================================*/
if (Wikiwyg.is_ie) {

if (window.ActiveXObject && !window.XMLHttpRequest) {
  window.XMLHttpRequest = function() {
    return new ActiveXObject((navigator.userAgent.toLowerCase().indexOf('msie 5') != -1) ? 'Microsoft.XMLHTTP' : 'Msxml2.XMLHTTP');
  };
}

} // end of global if statement for IE overrides
