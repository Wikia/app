
/*
* @author Bartek Łapiński
* @copyright Copyright © 2007, Wikia Inc.
* @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
*/

var WikiwygInstance;

/* copied and adapted from upload image script... */
// apply tagOpen/tagClose to selection in textarea,
// use sampleText instead of selection if there is none
// copied and adapted from phpBB
function insertTags(tagOpen, tagClose, sampleText) {
	if (WikiwygInstance.enabled) {
		var out = WikiwygInstance.current_mode;
	        out.insert_html (tagOpen + sampleText + tagClose);
	}
}

/* fall back if edit mode not supported - provide a normal interface  */
function CreatePageFallBack () {
	var loading_mesg = document.getElementById ('loading_mesg');
	loading_mesg.style.display = 'none';
	var input1 = document.createElement ('textarea');
	input1.setAttribute ('name','wpTextbox1');
	input1.setAttribute ('id','wpTextbox1');
	input1.setAttribute ('rows', 25);
	input1.setAttribute ('cols', 80);
	var backup_txt = document.getElementById ('backup_textarea_placeholder');
	backup_txt.appendChild (input1);
	/* todo give standard edit toolbar - mainly for Opera users */
}

document.insertTags = insertTags;

/* modified function for image upload (omitting HACK section for non-existing watchthis link )*/
var imageUploadDialog = null;

/* provide an old-way edit */
function CreatePageNormalEdit () {
	var title = document.getElementById ('title');
	var error_msg = document.getElementById ('createpage_messenger');
	if (title.value == '') {
		error_msg.innerHTML = 'Please specify title first';
		error_msg.style.display = '';
		return;
	}
	/* check for unsaved changes (they will always be *unsaved* here... ) */
	var textarea = WikiwygInstance.current_mode.get_edit_document().body.innerHTML;
	textarea = textarea.replace ("<br>", "");
	if (textarea != "") {
		var abandon_changes = confirm ("You have unsaved changes. Clicking OK will result in abandoning them.","Unsaved changes");
		if (!abandon_changes) {
			return;
		}
	}
	var fixed_article_path = wgArticlePath.replace ('$1','');
	fixed_article_path = fixed_article_path.replace ('index.php[^\/]','index.php?title=');
	window.location = fixed_article_path + title.value + '?action=edit';
}

function fixupRelativeUrl(url) {
	var loc = String(location);
	if (loc.match (/\?index\.php/i) != '')  {
		var base = loc.replace (/&action=.*$/i, '');
		return base;
	} else {
		var base = loc.replace(/index\.php.*/, '');
		if (base == loc)
			base = loc.replace(/(.*\/wiki\/).*/, '$1');
		if (base == loc)
			throw("fixupRelativeUrl error: " + loc);	
		return base + url;
	}
}

function CreatePageShowSection (section) {
	var this_section = document.getElementById ('createpage_' + section + '_section');
	var show_this = document.getElementById ('createpage_show_' + section);
	var hide_this = document.getElementById ('createpage_hide_' + section);

	this_section.style.display = '';
	show_this.style.display = 'none';
	hide_this.style.display = '';
}

function CreatePageHideSection (section) {
	var this_section = document.getElementById ('createpage_' + section + '_section');
	var show_this = document.getElementById ('createpage_show_' + section);
	var hide_this = document.getElementById ('createpage_hide_' + section);

	this_section.style.display = 'none';
	show_this.style.display = '';
	hide_this.style.display = 'none';
}

function CreatePageAddCategory (category, num) {
	if (category != '') {		
		if (document.editform.category.value == '') {
			document.editform.category.value += category;	
		} else {
			document.editform.category.value += ',' + category;
		}
		/* change colour */
		this_button = document.getElementById ('cloud_'+ num);
		this_span = document.getElementById ('tag-' + num);
		this_button.onclick = function() { eval("CreatePageRemoveCategory('" + category  + "', " + num + ")"); return false };
	        this_button.style["color"] = "#419636";
	}
}
function CreatePageRemoveCategory (category, num) {
	category_text = document.editform.category.value;
	this_pos = category_text.indexOf(category);
	if (this_pos != -1) {
		category_text = category_text.substr (0, this_pos-1 ) + category_text.substr (this_pos + category.length);
		document.editform.category.value = category_text;
	}

	this_button = document.getElementById ('cloud_'+ num);
	this_button.onclick = function() { eval("CreatePageAddCategory('" + category  + "', " + num + ")"); return false };
	this_button.style["color"] = "";
}

function CreatePageShowThrobber (text) {
//	var Throbber = document.getElementById ('ajaxProgressIcon') ;
//	Throbber.style.visibility = 'visible' ;
}

function CreatePageHideThrobber (text) {
//	var Throbber = document.getElementById ('ajaxProgressIcon') ;
//	Throbber.style.visibility = 'hidden' ;
}


window.onload = function() {
    var WikiwygDiv = document.getElementById ('wikiwyg');
	var category_wrapper = document.getElementById ('category_wrapper');
	var subtitle = document.getElementById ('contentSub');
	var cp_subtitle = document.getElementById ('createpage_subtitle');
	subtitle.innerHTML = cp_subtitle.innerHTML;
	CreatePageShowThrobber ('') ;
	category_wrapper.style.display = 'block';
	var WikiwygConfig = {
		doubleClickToEdit: true,
		editHeightMinimum: 300,
		wysiwyg: {
			iframeId: 'wikiwyg-iframe' 			
		},
		toolbar: {
			imagesLocation: wgScriptPath + '/extensions/wikiwyg/share/MediaWiki/images/',
			markupRules: {
				 link: ['bound_phrase', '[', ']']
			 }, 
	       		 controlLayout: [
			 	'bold' ,
				'italic' ,
				'strike' ,
				'www' ,
				'unlink' ,
				'wikify' ,
				'h1' ,
				'h2' ,
				'h3' ,
				'pre' ,
                                'hr' ,				
				'unordered' ,
				'ordered' ,
				'youtube' ,
			        'table' ,
				'|l' ,
				'insertimage' ,
				'|l' ,
				'help'				
			]
		},
		modeClasses: [
		     'Wikiwyg.Wysiwyg.Custom',
		     'Wikiwyg.Wikitext.Custom'
		     ]
	} ;
	WikiwygInstance = new Wikiwyg.Test();
	WikiwygInstance.createWikiwygArea(WikiwygDiv, WikiwygConfig);	
	if (WikiwygInstance.enabled) {
		setTimeout("WikiwygInstance.editMode();",400);
	} else {
		CreatePageFallBack();
	}
	document.getElementById ('loading_mesg').style.display = 'none';

	// register edit page
	var CreatePageLinkBottom = document.getElementById ('wpSaveBottom');
	var self = WikiwygInstance;
	CreatePageLinkBottom.onclick = function() { eval('WikiwygInstance.saveChanges()'); return false };	
	CreatePageHideThrobber('');
}

proto = new Subclass('Wikiwyg.Test', 'Wikiwyg');

    proto.modeClasses = [
    'Wikiwyg.Wysiwyg.Custom',
	'Wikiwyg.Wikitext.Custom'
    ];

proto.saveChanges = function () {
	if (!this.checkContents()) {
		return false;
	}
	var title = document.getElementById ('title');
	if (!this.checkIfArticleExists (title.value)) {
		return false;
	}
}

proto.imageUpload = function (tagOpen, tagClose, sampleText) {
	Wikiwyg.prototype.imageUpload.call (this, tagOpen, tagClose, sampleText);
}

proto.checkContents = function () {
	var error_msg = document.getElementById ('createpage_messenger');
	var title = document.getElementById ('title');
	article_text = this.current_mode.get_edit_document().body.innerHTML;
	article_text = article_text.replace(/<br[^>]+./gi,"<br>");
//        article_text = article_text.replace(/<br><br>/gi,"<p>") ;
	var class_name = this.config.modeClasses[1];
	var mode_object = this.mode_objects[class_name];
	article_text = mode_object.convert_html_to_wikitext(article_text);
	if ( (title.value == '') || (article_text == '') ) {
		error_msg.innerHTML = "You need to specify both title and some content to create an article.";
		error_msg.style.display = 'block';
		return false;
	}
	return true;
}

proto.checkIfArticleExists = function (article) {
	CreatePageShowThrobber('');
	WKWAjax.post (
		fixupRelativeUrl('Special:Createpage'),
		'action=check&to_check=' + article,
		function (response) {
			WikiwygInstance.handleArticleExistsResponse (response)
		}
	);
}

proto.handleArticleExistsResponse = function (response) {
	if (response.indexOf("pagetitleexists") != -1) {
		var error_msg = document.getElementById ('createpage_messenger');
		var title = document.getElementById ('title');
		error_msg.innerHTML = "That title already exists. Please choose another title.";
		error_msg.style.display = 'block';
		CreatePageHideThrobber('');
		return false;
	} else {
		/* select wikitext mode */
		var class_name = this.config.modeClasses[1];
		var mode_object = this.mode_objects[class_name];
		this.current_mode.saveChanges (mode_object);				
		CreatePageHideThrobber('');
		return true;
	}
}

proto = new Subclass('Wikiwyg.Wysiwyg.Custom', 'Wikiwyg.Wysiwyg');

/* taken from Wysiwig.MediaWiki */

proto.insert_html = function(html) { // See IE
	this.get_edit_window().focus();
	this.exec_command('inserthtml', html);
}

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

proto.disableCreateButtons = function () {
	var CreatePageLinkBottom = document.getElementById ('wpSaveBottom') ;
	CreatePageLinkBottom.disabled = true ;
}

proto.saveChanges = function (mode) {
	var title = document.getElementById ('title');
	document.editform.action= wgScriptPath + "/index.php?title=" + title.value + "&action=submit";
	this.disableCreateButtons();
	var input1 = document.createElement ('input');
	input1.setAttribute ('name','wpTextbox1');
	input1.setAttribute ('id','wpTextbox1');
	input1.setAttribute ('type','hidden');
	document.editform.appendChild (input1);
	var article_text = this.get_edit_document().body.innerHTML;
	article_text = article_text.replace(/<br[^>]+./gi,"<br>");
	article_text = article_text.replace(/<br><br>/gi,"<p>");
	article_text = mode.convert_html_to_wikitext(article_text);
        document.editform.wpTextbox1.value = article_text;
	this.getCategories();
	document.editform.submit();
}

proto.getCategories = function () {
	/* get categories separated by commas */
	var categories = document.getElementById ('category').value;
	categories = categories.split (",");
	for (i=0;i<categories.length;i++) {
		this.addCategory (categories[i]);
	}
}

proto.addCategory = function (text) {
	if (text != '') {		
		document.editform.wpTextbox1.value += '[[Category:'+text+']]';	
	}
}

proto = new Subclass('Wikiwyg.Wikitext.Custom', 'Wikiwyg.Wikitext');

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

proto.do_youtube = function () {
	this.make_do ('youtube');	
}

Wikiwyg.Wysiwyg.prototype.do_wikify = function() {
	var selection = this.get_link_selection_text();
	if (!selection) return;
	var self = this;
	WKWAjax.post (
		fixupRelativeUrl('Special:Createpage'),
		'action=check&to_check=' + selection,		
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
	) ;
}

Wikiwyg.Wysiwyg.Custom.prototype.do_youtube = function() {

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
			self.ieRange.select();
		}
		this.insert_youtube(url);
}

Wikiwyg.Wysiwyg.Custom.prototype.extract_youtube_id = function(youTubeCode) {
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

Wikiwyg.Wysiwyg.Custom.prototype.insert_youtube = function(url) {
	youTubeID = this.extract_youtube_id(url);
	if(!id){
		alert("Invalid Youtube url");
		return;
	}
	TheURL = window.location.href
		TheURL = TheURL.substring(0,TheURL.lastIndexOf("/"))
		this.exec_command('InsertImage', TheURL + "/images/YouTube_placeholder.gif?id=" + youTubeID);
}

proto.format_table = function(element) {
	this.insert_new_line();
	this.appendOutput('{|') ;
		this.assert_blank_line();
		this.walk(element);
		this.assert_blank_line();
		this.appendOutput('|}');
		this.insert_new_line();
}

proto.format_tr = function(element) {
	this.appendOutput('|-');
	this.assert_new_line();
	this.appendOutput('|');
	this.walk(element);
	this.assert_blank_line();
	this.assert_new_line();
}

proto.format_br = function (element) {
	this.insert_new_line();
	this.insert_new_line();
}

proto.format_p = function(element) {
	if (this.is_indented(element)) {
		this.format_blockquote(element);
		return;
	}
	this.insert_new_line();
	this.insert_new_line();
	this.insert_new_line();
	this.walk(element);
}

proto.format_td = function(element) {
	this.no_following_whitespace();
	this.walk(element);
	this.chomp();
	this.appendOutput('||');
}

	proto.format_div = function(element) {
		if (! this.previous_was_newline_or_start())
			this.insert_new_line();

		this.walk(element);
		this.assert_blank_line();
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

proto.config = {
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
      table: ['line_alone', '{ | A | B | C |\n|   |   |   |\n|   |   |   | }']
	     }
}