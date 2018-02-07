CKEDITOR.plugins.add('rte-template',
{
	init: function(editor) {
		var self = this;

		// register template editor dialog
		CKEDITOR.dialog.add('rte-template', this.path + 'dialogs/template.js');

		// register template dropdown list
		editor.ui.addRichCombo('Template', {
			label : editor.lang.templateDropDown.label,
			title: editor.lang.templateDropDown.title,
			className : 'cke_template',
			multiSelect : false,

			panel : {
				css : [ CKEDITOR.getUrl( editor.skinPath + 'editor.css' ) ] . concat( editor.config.contentsCss )
			},

			init : function() {

				this.startGroup(editor.lang.templateDropDown.title);

				// list of templates to be added to dropdown
				var templates = window.RTETemplatesDropdown;

				for (var t=0; t < templates.length; t++) {
					var value = templates[t].replace(/_/g, ' ');
					var label = window.RTEMessages.template + ':' + value;

					// add the template entry to the panel list
					this.add(templates[t], label, value);
				}

				// add "Other template / magic word"
				this.add('--other--',
					'<strong>' + editor.lang.templateDropDown.chooseAnotherTpl  + '</strong>',
					editor.lang.templateDropDown.chooseAnotherTpl);

				// add "List of used templates"
				this.add('--list--',
					'<strong>' + editor.lang.templateDropDown.showUsedList  + '</strong>',
					editor.lang.templateDropDown.showUsedList);
				// add "Make a layout"
				this.add('--make-layout--',
					'<strong>' + editor.lang.templateDropDown.makeLayout  + '</strong>',
					editor.lang.templateDropDown.makeLayout);
			},

			onClick : function(value) {
				RTE.log('template dropdown: "' + value +'"');

				switch (value) {
					case '--other--':
						// show template editor with list of templates to choose
						RTE.templateEditor.createTemplateEditor(false);
						break;
					case '--list--':
						RTE.templateHelpers.showUsedList(editor);
						break;
					case '--make-layout--':
						RTE.templateHelpers.makeLayout(editor);
						break;
					default:
						// show template editor with selected template
						RTE.templateEditor.createTemplateEditor(value);
				}

				// don't show selected template on toolbar
				var dropdown = this;
				setTimeout(function() {
					dropdown.setValue(false);
				}, 50);
			}
		});

		// list of templates to be added to dropdown
		/*
		var templates = window.RTETemplatesDropdown;

		for (var t=0; t < templates.length && t < 4; t++) {
			var name = templates[t].replace(/_/g, ' ');

			editor.ui.addButton('Template_Popular'+t, {
				label: name,
				title: name,
				click: (function(templateName){
					return function() {
						RTE.templateEditor.createTemplateEditor(templateName);
					}
				})(templates[t])
			});
		}
		*/
		editor.addCommand('InsertTemplate',{
			exec: function( editor, data ) {
				editor.fire('insertTemplate', data);
				if (data && data.templateName)
					RTE.templateEditor.createTemplateEditor(data.templateName);
			}
		});
	}
});

RTE.templateHelpers = {
	showUsedList: function(editor) {
		editor = editor || RTE.getInstance();
		var el = $('#editform > .templatesUsed');
		if (el.exists()) {
			var list = $('<div>');
			list.html(el.html());
			list.children().not('ul').remove();
			list.find('a').attr('target','_blank');
			$.showModal(editor.lang.templateEditor.usedTemplates.title,list.html(),{
				width: 400
			});
		}
	},
	makeLayout: function() {
		if (typeof window.PLBMakeLayoutUrl != 'undefined') {
			$("#editform")
				.attr("action", window.PLBMakeLayoutUrl)
				.submit();
		} else {
			// XXX: show error message
		}
	}
};

// object used between plugin and template editor
RTE.templateEditor = {
	// reference to placeholder of currently edited template / magic word
	placeholder: false,

	// RTE meta data (get from placeholder, will be stored after OK)
	data: {},

	// reference to CKEDITOR.dialog object
	dialog: {},

	// generate preview
	doPreview: function(callback) {
		RTE.log('generating preview...');

		// remove current preview
		$('#templatePreview').html('').addClass('loading');

		// get list of parameters and their values
		var params = {};

		$('#templateParameters').find('textarea').each(function() {
			var key = $(this).attr('rel');
			var value = $(this).attr('value');

			params[key] = value;
		});

		// generate wikitext
		var wikitext = this.data.wikitext = this.generateWikitext(this.data.title, params);

		// parse it
		RTE.tools.parse(wikitext, function(html) {
			$('#templatePreview').html(html).removeClass('loading');

			// make links in preview unclickable
			$('#templatePreview').bind('click', function(ev) {
				ev.preventDefault();
			});

			if (typeof callback == 'function') {
				callback();
			}
		});
	},

	// generate template wikitext from given name and list of parameters
	generateWikitext: function(name, params) {
		var wikitext,
			currentData = this.placeholder.getData(),
			availableParams = RTE.tools.resolveDoubleBracketsCache[currentData.wikitext].availableParams,
			availableUnnamedParams = availableParams.filter(function(elem) {
				return !isNaN(elem);
			}),
			availableNamedParams = availableParams.filter(isNaN),
			passedParams = RTE.tools.resolveDoubleBracketsCache[currentData.wikitext].passedParams,
			passedUnnamedParams = [],
			passedNamedParams = [],
			allUnnamedParams = [],
			templateTitle = currentData.title,
			multiline = currentData.wikitext.indexOf("\n|") !== -1,
			updatedParams = [],
			glue = multiline ? "\n|" : "|";

			if (passedParams) {
				passedUnnamedParams = Object.keys(passedParams).filter(function(elem) {
					return !isNaN(elem);
				}).map(Number);
				passedNamedParams = Object.keys(passedParams).filter(isNaN);
			}
			allUnnamedParams = availableUnnamedParams.concat(passedUnnamedParams);


		// filter duplicates
		allUnnamedParams = allUnnamedParams.filter(function(value, index) {
			return allUnnamedParams.indexOf(value) === index;
		}).sort();

		// sorted unnamed parameters goes first
		allUnnamedParams.forEach(function(paramKey) {
			if (params[paramKey] !== "" && typeof params[paramKey] !== 'undefined' ) {
				updatedParams.push(params[paramKey]);
			} else {
				if (typeof passedParams !== 'undefined' && passedParams[paramKey] !== "" && typeof passedParams[paramKey] !== 'undefined' ) {
					updatedParams.push(passedParams[paramKey]);
				}
			}
		});

		// then named parameters, order is not crucial
		availableNamedParams.forEach(function(paramKey) {
			if (params[paramKey] !== "" && typeof params[paramKey] !== 'undefined') {
				updatedParams.push(paramKey + " = " + params[paramKey]);
			}
		});

		// XW-4540: save named parameters that are not yet supported by template but were passed in template invocation
		// (unnamed were handled before)
		if (passedParams) {
			passedNamedParams.forEach(function (key) {
				if (!params.hasOwnProperty(key)) {
					updatedParams.push(key + " = " + passedParams[key]);
				}
			});
		}

		// generate new wikitext
		wikitext = '{{' + templateTitle;
		if (updatedParams.length > 0) {
			wikitext += "|" + updatedParams.join(glue);
			if (multiline) {
				wikitext += "\n";
			}
		}
		wikitext += '}}';

		return wikitext;
	},

	// select editor step and fill it fields
	selectStep: function(stepId) {
		RTE.log('showing step #' + stepId);
		RTE.log(this.placeholder);

		var dialog = this.dialog;
		dialog.selectPage('step' + stepId);

		// get template info and RTE meta data
		var info = this.placeholder.data('info');
		var data = this.placeholder.getData();

		// hide dialog footer - buttons
		$('.templateEditorDialog').find('.cke_dialog_footer').hide();

		// fill the fields
		switch(stepId) {
			// frequently used templates / magic words / search
			case 1:
				var renderFirstStep = function() {
					// render list of frequently used templates
					var html = '';
					$(window.RTEHotTemplates).each(function(i, template) {
						html += '<li><a rel="' + template + '">' + template.replace(/_/g, ' ') + '</a></li>';
					});
					$('#templateEditorHotTemplates').html(html);

					// render list of magic words
					var html = '';
					$(window.RTEMagicWords.magicWords).each(function(i, magic) {
						html += '<li><a rel="' + magic + '">' + magic.toUpperCase() + '</a></li>';
					});
					$('#templateEditorMagicWords').html(html);

					// add click handlers
					var self = this;
					$('#templateEditorHotTemplates').find('a').click(function(ev) {
						var templateName = $(this).attr('rel');

						 RTE.templateEditor.selectTemplate(dialog, templateName);
					});

					$('#templateEditorMagicWords').find('a').click(function(ev) {
						var name = $(this).attr('rel');
						RTE.log('adding magic word: ' + name);

						// set meta data
						var data = {};

						// __TOC__ vs {{PAGENAME}}
						var isDoubleUnderscore = RTEMagicWords.doubleUnderscores.indexOf(name) > -1;

						if (isDoubleUnderscore) {
							// __TOC__
							data.type = 'double-underscore';
							data.wikitext = '__' + name.toUpperCase() + '__';
						}
						else {
							// {{PAGENAME}}
							data.type = 'double-brackets';
							data.title = name.toUpperCase();
							data.wikitext = '{{' + name.toUpperCase() + '}}';
						}

						// update placeholder type and meta-data
						RTE.log(data);

						var placeholder = RTE.templateEditor.placeholder;
						placeholder.setPlaceholderType(data.type);
						placeholder.setData(data);

						// update placeholder
						RTE.templateEditor.usePlaceholder(placeholder);

						// close dialog
						dialog.hide();

						// insert / update placeholder
						RTE.templateEditor.commitChanges();
					});

					// setup MW suggest (search only in NS_TEMPLATE = 10)
					dialog.enableSuggesionsOn(dialog.getContentElement('step1', 'templateSearchQuery'), [10]);
				}

				if (typeof window.RTEHotTemplates == 'undefined') {
					dialog.setLoading(true);

					// fetch list of frequently used templates via AJAX
					RTE.ajax('getHotTemplates', {}, function(hotTemplates) {
						dialog.setLoading(false);

						window.RTEHotTemplates = hotTemplates;
						renderFirstStep();
					});
				}
				else {
					renderFirstStep();
				}

				break;

			// parameters editor
			case 2:
				// show dialog footer - buttons
				$('.templateEditorDialog').find('.cke_dialog_footer').show();

				var $chooseAnotherTemplateButton = $('.cke_dialog_choose_another_tpl' );

				//hide the 'Choose another template' button if the template is an infobox
				if (info.html.search( 'infobox' ) === -1 ) {
					$chooseAnotherTemplateButton.css('visibility', 'visible');
				} else {
					$chooseAnotherTemplateButton.css('visibility', 'hidden');
				}

				// template name (with localised namespace - RT #3808 - and spaces instead of underscores)
				var templateName = info.title.replace(/_/g, ' ');
				templateName = templateName.replace(/^Template:/, window.RTEMessages.template + ':');

				$('#templateEditorTemplateName').html(templateName);

				// URL to template source
				var viewHref = window.wgServer + window.wgArticlePath.replace(/\$1/, encodeURI(info.title.replace(/ /g, '_')));
				$('#templateEditorViewLink').attr('href', viewHref);

				// render list of parameters and their values
				var html = '';

				$.each(info.availableParams, function(i, key) {
					// parameter value
					var value = (info.passedParams && typeof info.passedParams[key] != 'undefined') ? info.passedParams[key] : '';

					// fix for HTML in value
					value = value.replace(/&/g, '&amp;');

					// show different message for unnamed template parameters (#1 / foo)
					var keyLabel = !!parseInt(key) ? ('#' + key) : key;

					// render key - value pair
					html += '<dt><label for="templateEditorParameter' + i + '">' + keyLabel  + '</label></dt>';
					html += '<dd><textarea rel="' + key + '" id="templateEditorParameter' + i +'">' + value + '</textarea></dd>';
				});

				$('#templateParameters')
					.html(html)
					.find('dd > textarea').keydown(this.onTextareaKeyDown);

				// generate preview
				this.doPreview();
				break;

			// wikitext source editor (advanced mode)
			case 3:
				// get wikitext source
				$('#templateAdvEditorSource').attr('value', data.wikitext);

				// generate preview
				RTE.tools.parse(data.wikitext, function(html) {
					$('#templateAdvPreview').html(html);
				});
				break;
		}
	},

	// handle keydown event on textarea elements
	onTextareaKeyDown: function(ev) {
		// tinymce will not handle tab key correctly.
		if( ev.which == 9 /* tab */ ) {
			// select next textarea to focus
			var next = $(this).parent('dd').next('dt').next('dd').children('textarea').first();
			if( next.size() == 1 ) {
				next.focus();
				// prevent tinymce and browser from handling this event
				ev.stopPropagation();
				ev.preventDefault();
			}
		}
	},

	// select given template from step #1 of template editor
	// either add it to editor or open params editor (step #2)
	selectTemplate: function(dialog, templateName) {
		RTE.log('selecting template: ' + templateName);

		// generate meta-data
		var data = {
			title: templateName,
			wikitext: '{{' + templateName + '}}'
		};

		this.placeholder.setPlaceholderType('double-brackets');
		this.placeholder.setData(data);

		RTE.templateEditor.usePlaceholder(this.placeholder);
		dialog.setLoading(true);

		// get template info
		var self = this;
		RTE.tools.resolveDoubleBrackets(data.wikitext, function(info) {
			dialog.setLoading(false);

			// store template info
			self.placeholder.data('info', info);

			// show step #2 - params editor
			if ( (typeof info.availableParams != 'undefined') && (info.availableParams.length > 0) ) {
				RTE.templateEditor.selectStep(2);
			}
			else {
				RTE.log('given template contains no params - inserting / updating...');
				RTE.templateEditor.commitChanges();

				// close editor
				dialog.hide();
				return;
			}
		});
	},

	// use given placeholder within editor
	usePlaceholder: function(placeholder) {
		this.placeholder = placeholder;
		this.data = placeholder.getData();
	},

	// commit changes from template editor to template placeholder
	commitChanges: function() {
		RTE.log('storing modified template data');
		RTE.log(this.data);

		RTE.tools.parseRTE(this.data.wikitext, function(html) {
			// store saved meta data
			this.placeholder.setData(RTE.templateEditor.data);
			// regenerate template preview and data
			this.placeholder.removeData('preview');
			this.placeholder.removeData('info');

			if (this.placeholder.parent().exists()) {
				// If placeholder has a parent = it's already inserted in the article
				// So we are editing, not creating. Thus, replacing the existing article element
				// With it's edited version (but keeping the placeholder).
				// If html consists of multiple nodes at the top level, $(html).html() returns only inner html of first node
				// so as long as placeholder is first node, it should work
				this.placeholder.html($(html).html());
			} else {
				RTE.tools.insertElement(html);
			}

			// cleanup
			this.placeholder = false;
			this.data = {};
		}.bind(this));
	},

	// show template editor
	showTemplateEditor: function(placeholder) {
		RTE.log('calling template editor...');

		// open editor for this element
		RTE.templateEditor.usePlaceholder(placeholder);

		// open template editor
		RTE.getInstance().openDialog('rte-template');

	},

	// create new template placeholder (and maybe show template editor for it)
	createTemplateEditor: function(templateName) {
		// quick hack to make it work in source mode
		if (RTE.getInstance().mode == 'source') {
			if (templateName) {
				insertTags('{{'+templateName,'}}','');
			}
			return
		}

		// create template placeholder
		var placeholder = RTE.tools.createPlaceholder('double-brackets');

		// open editor to add new template
		if (templateName == false) {
			RTE.log('calling template editor to choose a template...');
			this.showTemplateEditor(placeholder);
			return;
		}

		RTE.log('calling template editor for new template "' + templateName + '"');

		// set meta-data
		var wikitext = '{{' + templateName + '}}';
		placeholder.setData({title: templateName, wikitext: wikitext});

		// get template info
		var self = this;

		RTE.tools.resolveDoubleBrackets(wikitext, function(info) {
			// store template info
			placeholder.data('info', info);

			// only show template editor if template contains params
			if ( (typeof info.availableParams != 'undefined') && (info.availableParams.length > 0) ) {
				// call template editor
				self.showTemplateEditor(placeholder);
			}
			else {
				RTE.log('given template contains no params - inserting...');

				RTE.tools.insertElement(placeholder);

				return;
			}
		});
	}
};
