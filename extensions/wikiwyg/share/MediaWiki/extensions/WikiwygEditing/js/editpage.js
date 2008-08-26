
/*
 @author Bartek Łapiński
 @copyright Copyright © 2007, Wikia Inc.
 @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
*/

var WikiwygInstance;
var wgFullPageEditing = true;

/* copied and adapted from upload image script... */
// apply tagOpen/tagClose to selection in textarea,
// use sampleText instead of selection if there is none
// copied and adapted from phpBB
function WKWinsertTags(tagOpen, tagClose, sampleText) {
	if (WikiwygInstance.enabled) {
		var out = WikiwygInstance.current_mode;
	        out.insert_html (tagOpen + sampleText + tagClose);
	}
}

/* fall back if edit mode not supported - provide a normal interface  */
EditPageFallBack = function () {       
	/* todo give standard edit toolbar */
	document.insertTags = insertTags;
   	WikiwygInstance.textbox.style.display = '';
	document.getElementById ('WikiwygEditingLoadingMesg').style.display = 'none';
}

document.insertTags = WKWinsertTags;

function EditPageShowSection (section) {
	var this_section = document.getElementById ('editpage_' + section + '_section');
	var show_this = document.getElementById ('editpage_show_' + section);
	var hide_this = document.getElementById ('editpage_hide_' + section);

	this_section.style.display = '';
	show_this.style.display = 'none';
	hide_this.style.display = '';
}

function EditPageHideSection (section) {
	var this_section = document.getElementById ('editpage_' + section + '_section');
	var show_this = document.getElementById ('editpage_show_' + section);
	var hide_this = document.getElementById ('editpage_hide_' + section);

	this_section.style.display = 'none';
	show_this.style.display = '';
	hide_this.style.display = 'none';
}

function EditPageAddCategory (category, num) {
	if (category != '') {
		var category_field = document.getElementById ('category_textarea');
		category = unescape (category);
		if (category_field.value == '') {
			category_field.value += category;
		} else {
			category_field.value += ',' + category;
		}
		this_button = document.getElementById ('cloud_'+ num);
		this_span = document.getElementById ('tag-' + num);
		this_button.onclick = function() { eval("EditPageRemoveCategory('" + escape(category)  + "', " + num + ")"); return false };
		this_button.style["color"] = "#419636";
	}
}
function EditPageRemoveCategory (category, num) {
	var category_field = document.getElementById('category_textarea');
	category_text = category_field.value;
	category = unescape (category);
	this_pos = category_text.indexOf(category);
	if (this_pos != -1) {
		category_text = category_text.substr (0, this_pos-1 ) + category_text.substr (this_pos + category.length);
		category_field.value = category_text;
	}

	this_button = document.getElementById ('cloud_'+ num);
	category = category.replace (/\|.*/,'');
	this_button.onclick = function() { eval("EditPageAddCategory('" + escape(category)  + "', " + num + ")"); return false };
	this_button.style["color"] = "";
}


/* modified function for image upload (omitting HACK section for non-existing watchthis link) */
var imageUploadDialog = null;

function fixupRelativeUrl(url) {
	var loc = String(location);
	var base = loc.replace(/index\.php.*/, '');
	if (base == loc)
		base = loc.replace(/(.*\/wiki\/).*/, '$1');
	if (base == loc)
		throw("fixupRelativeUrl error: " + loc);
	return base + url;
}

window.onbeforeunload = confirmExit;

window.onload = function() {
	var editform = document.getElementById ('editform');
	var edit_text = document.getElementById ('wpTextbox1');
	var wiki_diff = document.getElementById ('wikiDiff');

	if (wiki_diff) { 
	       	var upper_toolbar = document.getElementById ('WikiwygEditingUpperToolbar');	 
		var new_upper_toolbar = Wikiwyg.createElementWithAttrs ('div', {id: 'WikiwygEditingUpperToolbarBis'});
		new_upper_toolbar.innerHTML = upper_toolbar.innerHTML;
		wiki_diff.parentNode.insertBefore (new_upper_toolbar, wiki_diff);
	}

	var subtitle = document.getElementById ('contentSub');
	var cp_subtitle = document.getElementById ('wikiwyg_cancel_form');
	var copywarn = document.getElementById ('editpage-copywarn');
	copywarn.style.display = 'none';
	subtitle.innerHTML = cp_subtitle.innerHTML;
        var summary_holder = document.getElementById ('wpSummaryLabel').firstChild;
	summary_holder.innerHTML  = wgSummaryCaption + ':';
	var content = edit_text.value;

	var templates_used = document.getElementById ('templates_used_explanation');
	var editpage_table = document.getElementById ('editpage_table');	 

	if (templates_used) {
		templates_used.style.display = 'none';
		var templates_list = document.getElementById ('templates_used_list');
		templates_list.style.display = 'none';
        var templates_tr =  document.createElement ('tr');
		var templates_td_header = Wikiwyg.createElementWithAttrs ('td', {'class': 'editpage_header'});
		var templates_container = Wikiwyg.createElementWithAttrs ('div', {'style': 'border: 1px solid gray; '});
		var templates_list_ul = document.createElement ('ul');
		templates_td_header.appendChild (document.createTextNode('Templates:'));
		var templates_td_body = document.createElement ('td');
		templates_list_ul.innerHTML = templates_list.innerHTML;
		templates_list_ul.innerHTML += '<li class="last"></li>'
		templates_container.appendChild (templates_list_ul);
		templates_td_body.appendChild (templates_container);
		templates_tr.appendChild (templates_td_header);
		templates_tr.appendChild (templates_td_body);
		editpage_table.appendChild (templates_tr);
	}

	/* remove those, move to the template table */
	var summaryInput = document.getElementById ('wpSummary');
	var summaryTd = document.getElementById ('editpage_summary_td');
	var old_sum_text = summaryInput.value;
	if (summaryInput) {		
		summaryInput.parentNode.removeChild (summaryInput);
		var newSummaryInput = Wikiwyg.createElementWithAttrs ('input', 
			{'id': 'wpSummary',
			'name': 'wpSummary',
			'type': 'text',
			'value': '',
			'style': 'width: 360px !important'
		}) ;
		newSummaryInput.value = old_sum_text;
		summaryTd.appendChild (newSummaryInput);
		/* clean up too */
		var summaryLabel = getLabelFor ('wpSummary');
		summaryLabel.parentNode.removeChild (summaryLabel);
	}

	var minorInput = document.getElementById ('wpMinoredit');
	if (minorInput) {
		minorInput.parentNode.removeChild (minorInput);
		var minorInputLabel = getLabelFor ('wpMinoredit');
		var minorInputText = minorInputLabel.innerHTML;
		minorInputLabel.parentNode.removeChild (minorInputLabel);
		/* add input plus label */
		var newMinorInput = Wikiwyg.createElementWithAttrs ('input', 
			{'id': 'wpMinoredit',
			'name': 'wpMinoredit',
			'type': 'checkbox',
			'value': '1',
			'accesskey': 'i'
		}) ;
		var newMinorInputLabel = Wikiwyg.createElementWithAttrs ('label', 
			{'for': 'wpMinoredit',
			'accesskey': 'i',
			'title': '',
			'class': 'no-float'
		}) ;
		newMinorInputLabel.innerHTML = minorInputText;
		summaryTd.appendChild (newMinorInput);
		summaryTd.appendChild (newMinorInputLabel);
	}

	var watchthisInput = document.getElementById ('wpWatchthis');
	if (watchthisInput) {
		watchthisInput.parentNode.removeChild (watchthisInput);
		var watchthisLabel = getLabelFor ('wpWatchthis');
		var watchthisText = watchthisLabel.innerHTML;
		watchthisLabel.parentNode.removeChild (watchthisLabel);
		/* add input plus label */
		var newWatchthisInput = Wikiwyg.createElementWithAttrs ('input', 
			{'id': 'wpWatchthis',
			'name': 'wpWatchthis',
			'type': 'checkbox',
			'value': '1',
			'accesskey': 'w',
			'checked': 'checked'
		}) ;
		var newWatchthisInputLabel = Wikiwyg.createElementWithAttrs ('label', 
			{'for': 'wpWatchthis',
			'accesskey': 'w',
			'title': '',
			'class': 'no-float'
		}) ;
		newWatchthisInputLabel.innerHTML = watchthisText;
		summaryTd.appendChild (newWatchthisInput);
		summaryTd.appendChild (newWatchthisInputLabel);
	}

	var WikiwygDiv = document.createElement ('div');
	WikiwygDiv.setAttribute ('id','wikiwyg');

	var WikiwygIframe = document.createElement ('iframe');
	WikiwygIframe.setAttribute ('id','wikiwyg-iframe');
	WikiwygIframe.setAttribute ('height','0');
	WikiwygIframe.setAttribute ('width','0');
	WikiwygIframe.setAttribute ('frameborder','0');
	document.editform.insertBefore (WikiwygIframe, edit_text);
	document.editform.insertBefore (WikiwygDiv, WikiwygIframe);

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
			 	'bold',
				'italic',
				'strike',
				'www',
			        'link',
				'h1',
				'h2',
				'h3',
				'h4',
			        'pre',
				'hr',
				'unordered',
				'ordered',
				'|l',
				'insertimage',
				'|l',
				'help',
				'[',
				'mode_selector',
				'|r',
				'save',
				'|r',
				'cancel',
				']'

			]
		},
		modeClasses: [
		     'Wikiwyg.Wysiwyg.Custom',		
		     'Wikiwyg.Wikitext.Custom',
		     'Wikiwyg.Preview.Custom'
		     ]
	} ;
	if (wgUseWysiwyg == 0) {
		WikiwygConfig.modeClasses.shift();
	}

	WikiwygInstance = new Wikiwyg.Test();
	WikiwygInstance.textbox = edit_text;
	WikiwygInstance.createWikiwygArea(WikiwygDiv, WikiwygConfig);

	if (WikiwygInstance.enabled) {
		setTimeout("WikiwygInstance.editMode();",400);
		needToConfirm = true;
   		WikiwygInstance.textbox.style.display = 'none';
		document.getElementById ('WikiwygEditingLoadingMesg').style.display = 'none';
   		document.getElementById ('toolbar').style.display = 'none';
		var anchor = Wikiwyg.createElementWithAttrs ('a', {'name': 'article'});
        var anchor_div = Wikiwyg.createElementWithAttrs ('div', {id: 'WikiwygEditingAnchor'});
		anchor_div.appendChild (anchor);

        var SaveLink = document.getElementById ('wpSave');
		var ButtonsPanel = SaveLink.parentNode;
		ButtonsPanel.style.display = 'none';
		WikiwygInstance.toolbarObject.placeLowerLinksSection();
		WikiwygInstance.insert_clean_after (editpage_table, WikiwygInstance.toolbarObject.linksDiv);
		WikiwygInstance.insert_clean_after (WikiwygInstance.toolbarObject.div, anchor_div);
		Event.addListener ('wikiwyg_ctrl_lnk_showLicense_wikiwyg', 'click', YAHOO.Wikia.Wikiwyg.showLicensePanel);
		var cat_textarea = document.createElement('textarea');
		var cat_placeholder = document.getElementById ('category_textarea_placeholder');
		if (cat_placeholder) {
			cat_textarea.setAttribute ('id', 'category_textarea');
			cat_textarea.setAttribute ('name', 'category');
			cat_textarea.setAttribute ('rows', '1');
			cat_textarea.setAttribute ('cols', '80');
			cat_placeholder.appendChild (cat_textarea);
			/* extract categories from text and place them into the category textarea */
			WikiwygInstance.categories_array = new Array();
			cat_textarea.value += WikiwygInstance.extractCategories (WikiwygInstance.textbox.value);
			var cat_full_section = document.getElementById ('editpage_cloud_section');

			/* plus, extract the categories present in the current cloud */
			var cloud_num = document.getElementById ('category_tag_count').value;
			var n_cat_count = cloud_num;
			var cloud_categories = new Array();
			for (i=0;i<cloud_num;i++) {
				var cloud_id = 'cloud_' + i;
                		cloud_categories[i] = document.getElementById (cloud_id).innerHTML;
			}
        	        var onclick_cat_fn = function (cat, id) {
				return function () {
					EditPageRemoveCategory(escape(cat), id);
					return false;
				}
			}

			for (i=0; i<WikiwygInstance.categories_array.length;i++) {
				var c_found = false;
				for (j in cloud_categories) {
					var core_cat = WikiwygInstance.categories_array[i].replace (/\|.*/,'');
				if (cloud_categories[j] == core_cat) {
						this_button = document.getElementById ('cloud_'+ j);
						var actual_cloud = cloud_categories[j];
						var cl_num = j;

						this_button.onclick = onclick_cat_fn (WikiwygInstance.categories_array[i],j);
						this_button.style.color = "#419636";
						c_found = true;
						break;
					}				
				}
				if (!c_found) { /* that category is not present in the cloud, add it */
					var n_cat = document.createElement ('a');
					var s_cat = document.createElement ('span');
					n_cat_count++;
					var cat_num = n_cat_count - 1;
					n_cat.setAttribute ('id','cloud_' + cat_num);
					n_cat.setAttribute ('href','#');
					n_cat.onclick = onclick_cat_fn (WikiwygInstance.categories_array[i], cat_num);
					n_cat.style.color = '#419636';
					n_cat.style.fontSize = '10pt';
					s_cat.setAttribute ('id','tag-' + n_cat_count);
					t_cat = document.createTextNode (core_cat);
					space = document.createTextNode (' ');
					n_cat.appendChild (t_cat);
					s_cat.appendChild (n_cat);
	        		s_cat.appendChild (space);
					cat_full_section.appendChild (s_cat);
				}
			}
		}
	} else {
		EditPageFallBack();
	}
}

proto = new Subclass('Wikiwyg.Test', 'Wikiwyg');

proto.getCategories = function () {
	var category_txt = document.getElementById ('category_textarea');
	if (!category_txt) {
		return;
	}
	/* get categories separated by commas */
	var categories = category_txt.value;
	categories = categories.split (",");
	for (i=0;i<categories.length;i++) {
		this.addCategory (categories[i]);
	}
}

proto.imageUpload = function (tagOpen, tagClose, sampleText) {
	Wikiwyg.prototype.imageUpload.call (this, tagOpen, tagClose, sampleText);
}

proto.addCategory = function (text) {
	if (text != '') {
		WikiwygInstance.textbox.value += '\n\n[[' + wgCategoryPrefix + ':'+text+']]';
	}
}

proto.insert_clean_after = function (container, cargo) {
	if (container.parentNode.lastchild == container) {
		container.parentNode.appendChild (cargo);
	} else {
		container.parentNode.insertBefore (cargo, container.nextSibling);
	}
}

proto.cancelEdit = function () {
	var re = /http:\/\/([^\/]*)\//g;
	var matches = re.exec(window.location.href);
	if ( !matches ) {
		// TAH: firefox bug: have to do it twice for it to work
		matches = re.exec(window.location.href);
	}
	var domain = matches[1];
	needToConfirm = false;
	window.location.replace (wgServer + wgScriptPath + "/wiki/" + wgPageName);
}

proto.showChanges = function () {
	needToConfirm = false;
	this.current_mode.showChanges();
}

proto.saveChanges = function () {
	needToConfirm = false;
	var class_name = this.config.modeClasses[1];
	var mode_object = this.mode_objects[class_name];
	this.current_mode.saveChanges (mode_object);		
}

proto.extractCategories = function (wikitext) {
       var cat_reg = new RegExp ('[\\r\\n]*\\[\\[' + wgCategoryPrefix + ':[^\\[\\]]*\\]\\]','gi');
       var short_cat = new RegExp ('[\\r\\n]*\\[\\[' + wgCategoryPrefix + ':');
       var found = wikitext.match (cat_reg); 
       if (!found) {
	       return '';
       }
       this.textbox.value = this.textbox.value.replace (cat_reg,'');
       var allcategories = "";
       for (i = 0 ; i < found.length; i++) {
       		if (allcategories != '') {
			allcategories += ',';
		}

		found[i] = found[i].replace (short_cat,'')
		                   .replace (/\]\]/,'')
		allcategories += found[i];
		this.categories_array[i] = found [i];
       }
       return allcategories;
}

proto.updateStuff = function () {
	var article_text = this.current_mode.normalizeContent();
	this.textbox.value = article_text;
//      document.editform.submit();
}

proto.clearModes = function () {
	/* run through all elements and clear them */
	    for (var i = 0; i < this.config.modeClasses.length; i++) {
	            var mode_radio = document.getElementById();
		    if (this.config.modeClasses[i] == this.current_mode.classname) {
			mode_radio.checked = 'checked';
		    } else {
			mode_radio.checked = false;
		    }
		}
}

proto.switchMode = function(new_mode_key) {	
	/* don't really switch mode, just show preview plus links */		
	var preview_div = document.getElementById ('wikiwyg_preview_area');
	var preview_area = document.getElementById ('WikiwygEditingPreviewArea');
	var preview_toolbar = document.getElementById ('WikiwygEditingUpperToolbar');
	var second_preview_toolbar = document.getElementById ('WikiwygEditingUpperToolbarBis');
	var wiki_diff = document.getElementById ('wikiDiff');


	if (wiki_diff) {
		wiki_diff.style.display = 'none';
		second_preview_toolbar.style.display = 'none';
	}

	if (!preview_div) {
		var preview_div = document.createElement ('div');
		preview_div.id = 'wikiwyg_preview_area';
		preview_div.style.backgroundColor = 'lightyellow';
		preview_div.style.padding = '4px 4px 4px 4px';
		preview_div.style.border = '1px solid #cccccc';			
	} else {
		preview_div.style.display = '';
	}

	preview_area.appendChild (preview_div);

	var preview_text = WikiwygInstance.current_mode.textarea.value;
	Wikiwyg.Wysiwyg.Custom.prototype.convertWikitextToHtml (
		preview_text ,
		function (preview_text) {		
			preview_div.innerHTML =  preview_text;
			if (preview_area.style.display == 'none') {
				preview_area.style.display = '';	
				preview_toolbar.style.display = '';
			}
		}
        );

}

proto = new Subclass('Wikiwyg.Wysiwyg.Custom', 'Wikiwyg.Wysiwyg');

/* taken from Wysiwig.MediaWiki */
proto.enableThis = function() {
	Wikiwyg.Mode.prototype.enableThis.call(this);
	this.edit_iframe.style.border = '1px black solid';
	this.edit_iframe.width = '100%';
	this.setHeightOf(this.edit_iframe);
	this.fix_up_relative_imgs();
	this.get_edit_document().designMode = 'on';
	this.apply_stylesheets();
	this.enable_keybindings();
	this.clear_inner_html();
	var to_convert = WikiwygInstance.textbox.value;
	var self = this;
	this.convertWikitextToHtml (
		to_convert,
		function (to_convert) {
			self.set_inner_html (to_convert);
		}
        );
}

proto.convertWikitextToHtml = function(wikitext, func) {
	WKWAjax.post(
			fixupRelativeUrl('index.php/'+ wgSpecialPrefix +':EZParser')  + "&rtitle=" + wgPageName ,
			"text=" + encodeURIComponent(wikitext),
			func
		 );
}


proto.disableCreateButtons = function () {
	var EditPageLink = document.getElementById ('wpSave');
	EditPageLink.disabled = true;
}

proto.normalizeContent = function () {
    var class_name = WikiwygInstance.config.modeClasses[1];
	var mode_object = WikiwygInstance.mode_objects[class_name];

	var content = this.get_edit_document().body.innerHTML;
	content = content.replace(/<br[^>]+./gi,"<br>");
    content = content.replace(/<br><br>/gi,"<p>");
	content = mode_object.convert_html_to_wikitext (content);
	return content;
}

proto.saveChanges = function (mode) {
	document.editform.action="index.php?title=" + wgPageName + "&action=submit";
	this.disableCreateButtons();
	var input1 = document.createElement ('input');
	var article_text = this.get_edit_document().body.innerHTML;
	article_text = article_text.replace(/<br[^>]+./gi,"<br>");
	article_text = article_text.replace(/<br><br>/gi,"<p>");
	article_text = mode.convert_html_to_wikitext(article_text);
        WikiwygInstance.textbox.value = article_text;
        WikiwygInstance.getCategories();
	document.editform.submit();
}

proto = new Subclass('Wikiwyg.Wikitext.Custom', 'Wikiwyg.Wikitext');

proto.initialize_object = function() {
	this.div = document.createElement('div');
	if (this.config.textareaId)
		this.textarea = document.getElementById(this.config.textareaId);
	else
		this.textarea = document.createElement('textarea');
	this.textarea.setAttribute ('id', 'wikiwyg_wikitext_textarea');
        var categories_panel = document.getElementById ('category_cloud_wrapper');
	this.div.appendChild(this.textarea);
	this.area = this.textarea;
	this.clear_inner_text();
	if (categories_panel) {
		this.stripCategories (this.textarea.value);
		categories_panel.style.display = '';
	}
}

/* fetch categories from text, throw them all into textarea */
proto.stripCategories = function (text) {
	var found = text.match (/\[\[Category:.*\]\]/gi);
	if (!found) {
		return '';
	}
	var tempcat = "";
	for (i = 0 ; i < found.length; i++) {
		tempcat = found[i].replace (/\[\[Category:/,'')
				  .replace (/\]\]/,'');
	}

      var splitted = text.split (/\[\[Category:[^\]]*\]\]/);

}

proto.enableThis = function() {
	Wikiwyg.Mode.prototype.enableThis.call(this);
	this.textarea.style.width = '100%';
	this.setHeightOfEditor();
	this.enable_keybindings();
}

proto.normalizeContent = function () {
	return this.textarea.value;
}

proto.saveChanges = function () {
	article_text = this.normalizeContent();
        WikiwygInstance.textbox.value = article_text;
        WikiwygInstance.getCategories();
	document.editform.submit();
}

proto.showChanges = function () {
	article_text = this.normalizeContent ();
        WikiwygInstance.textbox.value = article_text;
        WikiwygInstance.getCategories();
	var diff = Wikiwyg.createElementWithAttrs ('input', {
		'name': 'wpDiff',
		'value': 'OK', 
		'type': 'hidden'
		}) ;
	document.editform.appendChild (diff);
	document.editform.submit();
}

proto.addCategory = function (text) {
	if (text != '') {
		WikiwygInstance.textbox.value += '[[Category:'+text+']]';
	}
}

proto.getCategories = function () {
	/* get categories separated by commas */
	var categories = document.getElementById ('category_textarea').value;
	categories = categories.split (",");
	for (i=0;i<categories.length;i++) {
		this.addCategory (categories[i]);
	}
}

proto.enableThis = function() {
	Wikiwyg.Mode.prototype.enableThis.call(this);
	this.textarea.style.width = '100%';
	this.textarea.style.height = '300px';
	this.setHeightOfEditor();
	this.enable_keybindings();
	this.textarea.value = WikiwygInstance.textbox.value;
}

proto.format_table = function(element) {
	this.insert_new_line();
	this.appendOutput ('{|');
		this.assert_blank_line();
		this.walk(element);
		this.assert_blank_line();
		this.appendOutput ('|}');
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

proto.format_td = function(element) {
	this.no_following_whitespace();
	this.walk(element);
	this.chomp();
	this.appendOutput('||');
}

proto.convertWikitextToHtml = function(wikitext, func) {
       WKWAjax.post(
			fixupRelativeUrl('index.php/' + wgSpecialPrefix + ':EZParser')  + "&rtitle=" + wgPageName ,
			"text=" + encodeURIComponent(wikitext),
			func
		 );
}

proto.normalizeContent = function () {
	return this.textarea.value;
}

proto.config = {
javascriptLocation: '/wikiwyg/lib/' ,
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
      table: ['line_alone', '{ | | A | B | C |- | D | E | F |- | G | H | I | }']
	     }
}

proto = new Subclass ('Wikiwyg.Preview.Custom', 'Wikiwyg.Preview');

proto.normalizeContent = function () {
	var content = WikiwygInstance.textbox.value;
	return content;
}

proto.saveChanges = function () {
	WikiwygInstance.getCategories();
	document.editform.submit();
}