proto = Wikiwyg.Toolbar.prototype;
proto.config.controlLayout = [
//'mode_selector','/',
    'bold',
    'italic',
	'strike',
	'|',
	 'ordered',
	 'unordered',
	'|',
	'h1',
    'h2',
	'h3',
	'h4',
	'hr',
	'pre',
	  '|',
	'link', 'unlink',
	'table','|','wikify', '|', 'youtube'
];

proto.make_button = function(type, label) {
    var base = '/extensions/Wikiwyg-Mag/images/';

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
proto.config.controlLabels.link = "Create Link";
proto.config.controlLabels.unlink = "Unlink";
proto.config.controlLabels.wikify = 'Internal Link';
proto.config.controlLabels.youtube = 'Add YouTube Video';

proto = Wikiwyg.Wikitext.prototype;
proto.config.markupRules.bold = ['bound_phrase', "'''", "'''"];
proto.config.markupRules.italic = ['bound_phrase', "''", "''"];
proto.config.markupRules.strike = ['bound_phrase', '<s>', '</s>'];
proto.config.markupRules.h1 = ['bound_line', '= ', ' ='];
proto.config.markupRules.h2 = ['bound_line', '== ', ' =='];
proto.config.markupRules.h3 = ['bound_line', '=== ', ' ==='];
proto.config.markupRules.h4 = ['bound_line', '==== ', ' ===='];
proto.config.markupRules.h5 = ['bound_line', '===== ', ' ====='];
proto.config.markupRules.h6 = ['bound_line', '====== ', ' ======'];
proto.config.markupRules.underline = ['bound_phrase', '', ''];
proto.config.markupRules.wikify = ['bound_phrase', '[[', ']]'];
proto.do_wikify = Wikiwyg.Wikitext.make_do('wikify');
proto.do_youtube = Wikiwyg.Wikitext.make_do('youtube');


proto.format_img = function(element) {
	var style = element.getAttribute('style');
	
	img_width = "";
	img_height = "";
	if (style) {
		if(typeof(style)=="object"){
			img_width = style.width;
			img_heght = style.height;
		}else{
			style_atts = style.split(";")
			for(sa=0;sa<=style_atts.length-1;sa++){	
				att = style_atts[sa].split(":");
				name = att[0]
				val = att[1]
				if(name=="width")img_width=val;
				if(name=="height")img_height=val;
			}
		}
	}

    var uri = element.getAttribute('src');
    if(uri.indexOf("YouTube_placeholder.gif") > -1){
	    idPos = uri.indexOf("id=");
	    id = uri.substring(idPos+3)
	    if(!img_width)img_width=250;
	    if(!img_height)img_height=250;
	    this.appendOutput("<youtube>" + nLG + "source=http://www.youtube.com/v/" + id + nLG + "width=" + img_width + nLG + "height=" + img_height + nLG + "</youtube>");
    }else{
	    if (uri) {
		this.assert_space_or_newline();
			img_dir = uri.split("/")
			img_name = img_dir[img_dir.length-1];
			if(img_width.replace("px")>200)img_width="200px";
			wiki_img = "[[Image:" + img_name + ((img_width)?"|" + img_width:"|200px") + "|right]]";
		this.appendOutput(wiki_img);
	    }
    }
}

Wikiwyg.Wysiwyg.prototype.do_table = function() {
    var html =
        '<table><tbody>' +
        '<tr><td>A</td>' +
            '<td>B</td>' +
            '<td>C</td></tr>' +
        '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>' +
        '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>' +
        '</tbody></table>';
    if (! Wikiwyg.is_ie)
        this.get_edit_window().focus();
    this.insert_table(html);
}

Wikiwyg.Wysiwyg.prototype.insert_image = function(img) { // See IE
	TheURL = window.location.href
	TheURL = TheURL.substring(0,TheURL.lastIndexOf("/"))
    this.exec_command('InsertImage',  img);
}

Wikiwyg.Wysiwyg.prototype.enableThis = function() {
    this.superfunc('enableThis').call(this);
    this.edit_iframe.style.borderLeft = '2px #848484 solid';
	this.edit_iframe.style.borderTop = '2px #848484 solid';
	this.edit_iframe.style.borderBottom = '1px #fafafa solid';
	this.edit_iframe.style.borderRight = '1px #fafafa solid';
    this.edit_iframe.width = '100%';
	
    this.setHeightOf(this.edit_iframe);
    this.fix_up_relative_imgs();
    this.get_edit_document().designMode = 'on';
	this.get_edit_document().body.style.fontFamily = 'Arial';
	this.get_edit_document().body.style.fontSize = '13px';
	this.get_edit_document().body.style.padding = '2px';
	this.get_edit_document().body.style.margin = '0px';
    // XXX - Doing stylesheets in initializeObject might get rid of blue flash
    this.apply_stylesheets();
    this.enable_keybindings();
    this.clear_inner_html();
}

proto.make_wikitext_link = function(label, href, element) {
    var before = this.config.markupRules.link[1];
    var after  = this.config.markupRules.link[2];
 	var before_wiki = this.config.markupRules.wikify[1];
    var after_wiki  = this.config.markupRules.wikify[2];
	
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
        else
            this.appendOutput(before_wiki + label + after_wiki);
    }
    else {
        this.appendOutput(before + href + ' ' + label + after);
    }
}

Wikiwyg.Wysiwyg.prototype.do_wikify = function() {
	
	var selection = this.get_link_selection_text();
	
	page = new CreatePage();
	if(!page.checkPageTitleExists(selection)){
		link_color = "FF0000";
	}else{
		link_color = "26579A";
	}
  
 
    if (! selection) return;
    var url;
    var match = selection.match(/(.*?)\b((?:http|https|ftp|irc):\/\/\S+)(.*)/);
    if (match) {
        if (match[1] || match[3]) return null;
        url = match[2];
    }
    else {
        url = '?' + escape(selection); 
    }

    this.exec_command('createlink', url);
	this.exec_command('underline', selection);
	this.exec_command('ForeColor', "#" + link_color);
	
 
}

Wikiwyg.Wysiwyg.prototype.do_youtube = function() {
	
	if (Wikiwyg.is_ie) {
		//hack to remember Caret Position in IE
		this.ieRange = this.get_edit_document().selection.createRange();
		this.ieRange.moveStart ('character', -this.get_inner_html().length) ;
		this.ieCaretPos = this.ieRange.text.length;
	}
	txt = "";
	txt+= '<div class="wikiwyg_link">'
	+		'<span class="wikiwyg_link_title">Add YouTube Video</span><br>'
	+		'<span class="wikiwyg_link_label">Copy and paste the video\'s URL or Embed code</span> '
	+		'<textarea id="wikiwyg_link_url" class="wikiwyg_link" style="width:200px" rows="2" /></textarea><br>'
	+		'<input type="button" value="Insert Video" id="insert_link" />'
	+	'</div>';
	LinkWindow = new jsWindow(txt,{className:"wikiwyg_wysiwyg_popup"});
	var self = this;
	
    $("insert_link").onclick = function() {
	    	if(Wikiwyg.is_ie){
			// Move selection start and end to 0 position
		       self.ieRange.moveStart ('character', -self.get_inner_html().length);
		  
		       // Move selection start and end to desired position
		       self.ieRange.moveStart ('character', self.ieCaretPos);
		       self.ieRange.moveEnd ('character', 0);
		       self.ieRange.select ();
		 }
		self.insert_youtube($("wikiwyg_link_url").value )
		YAHOO.util.Element.remove(LinkWindow.editWindow);
    };
}

Wikiwyg.Wysiwyg.prototype.extract_youtube_id = function(youTubeCode) {
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

Wikiwyg.Wysiwyg.prototype.insert_youtube = function(url) {
	youTubeID = this.extract_youtube_id(url);
	if(!id){
		alert("Invalid Youtube url");
		return;
	}
	TheURL = window.location.href
	TheURL = TheURL.substring(0,TheURL.lastIndexOf("/"))
	this.exec_command('InsertImage', TheURL + "/images/YouTube_placeholder.gif?id=" + youTubeID);
}

Wikiwyg.Wysiwyg.prototype.insert_link = function(url,text) {
	this.exec_command('createlink', url);
	this.exec_command('underline', this.get_link_selection_text());
	this.exec_command('ForeColor', "#26579A");
}

Wikiwyg.Wysiwyg.prototype.do_link = function() {
	if (Wikiwyg.is_ie) {
		this.ieRange = this.get_edit_document().selection.createRange();
		this.ieSelectionBookmark = this.ieRange.getBookmark();
	}
	var selection = this.get_link_selection_text();
	if(!selection)return;
	txt = "";
	txt+= '<div class="wikiwyg_link">'
	+		'<span class="wikiwyg_link_title">Create Link</span><br>'
	+		'<span class="wikiwyg_link_label">Link URL</span> '
	+		'<input id="wikiwyg_link_url" type="text" value="http://" style="width:175px" /><br>'
	+		'<span class="wikiwyg_link_label">Link Text</span> '
	+		'<input id="wikiwyg_link_text" type="text" value="' + ((selection)?selection:"") + '" style="width:175px" /><br/><br/>'
	+		'<input type="button" value="Insert Link" id="insert_link" />'
	+	'</div>';
	LinkWindow = new jsWindow(txt,{className:"wikiwyg_wysiwyg_popup"});
    var self = this;
	
    $("insert_link").onclick = function() {
		if(Wikiwyg.is_ie){
			self.ieRange.moveToBookmark(self.ieSelectionBookmark);
			self.ieRange.select()
		 }
		self.insert_link($("wikiwyg_link_url").value,$("wikiwyg_link_text").value);
		
		YAHOO.util.Element.remove(LinkWindow.editWindow);
    };
}

Wikiwyg.Wysiwyg.prototype.do_unlink = function() {
	this.exec_command('underline', this.get_link_selection_text());
	this.exec_command('ForeColor', "#000000");
	this.exec_command('unlink', false);
}

Wikiwyg.Wikitext.prototype.cleanText = function(content){
			var bull = String.fromCharCode(8226);
			var middot = String.fromCharCode(183);
			content = content.replace(new RegExp('<p class=MsoHeading.*?>(.*?)<\/p>', 'gi'), '<p><b>$1</b></p>');
			content = content.replace(new RegExp('tab-stops: list [0-9]+.0pt">', 'gi'), '">' + "--list--");
			content = content.replace(new RegExp(bull + "(.*?)<BR>", "gi"), "<p>" + middot + "$1</p>");
			content = content.replace(new RegExp('<SPAN style="mso-list: Ignore">', 'gi'), "<span>" + bull); // Covert to bull list
			content = content.replace(/<o:p><\/o:p>/gi, "");
			content = content.replace(/<(\w[^>]*) lang=([^ |>]*)([^>]*)/gi, "<$1$3");
			content = content.replace(/<\\?\?xml[^>]*>/gi, "");
			content = content.replace(/<\/?\w+:[^>]*>/gi, "");
			content = content.replace(new RegExp('<br style="page-break-before: always;.*>', 'gi'), '-- page break --'); // Replace pagebreaks
			content = content.replace(new RegExp('<(!--)([^>]*)(--)>', 'g'), "");  // Word comments
			content = content.replace(/<\/?font[^>]*>/gi, "");
			content = content.replace(/-- page break --\s*<p>&nbsp;<\/p>/gi, ""); // Remove pagebreaks
			content = content.replace(/-- page break --/gi, ""); // Remove pagebreaks
			content = content.replace(/<\/?span[^>]*>/gi, "");
			content = content.replace(new RegExp('<(\\w[^>]*) style="([^"]*)"([^>]*)', 'gi'), "<$1$3")
			content = content.replace(new RegExp('<(\\w[^>]*) class="?mso([^ |>]*)([^>]*)', 'gi'), "<$1$3");
			return content;
}
