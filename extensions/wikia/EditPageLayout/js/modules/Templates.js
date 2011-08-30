(function(window){

	var WE = window.WikiaEditor;

	WE.modules.Templates = $.createClass(WE.modules.ButtonsList,{

		modes: true,

		headerClass: 'templates',
		headerTextId: 'templates-title',

		items: false,

		init: function() {
			this.items = [];
			var list = this.editor.config.popularTemplates || [];
			for (var i=0;i<list.length;i++) {
				var templateName = list[i],
					buttonId = 'Template_Popular'+i,
					self = this,
					label = this.msg('templates-add-tooltip', templateName);

				this.editor.ui.addElement(buttonId,{
					type: 'button',
					label: templateName,
					title: label,
					clicksource: (function(templateName){
						var buttonId = i+1;
						return function(sourceEditor) {
							// XXX: fix for multiple instances
							insertTags('{{'+templateName,'}}','');

							// tracking
							self.track(buttonId);
						};
					})(templateName),
					ckcommand: 'InsertTemplate',
					clickdatawysiwyg: {
						templateName: templateName,
						buttonId: i
					}
				});
				this.items.push(buttonId);
			}

			// tracking specific for CKeditor
			if (this.editor.ck) {
				this.editor.ck.on('insertTemplate', this.proxy(this.onInsertTemplate));
			}
		},

		track: function(ev) {
			this.editor.track(this.editor.getTrackerMode(), 'templates', ev);
		},

		onInsertTemplate: function(ev) {
			var data = ev.data;

			if (typeof data.buttonId != 'undefined') {
				this.track(data.buttonId + 1);
			}
		},

		getLinkHtml: function( cls, msg, fn ) {
			var fnId = this.editor.addFunction(fn);
			return '<li class="' + cls + '"><a onclick="WikiaEditor.callFunction(' + fnId + ')">'
				+ this.msg('templates-'+msg) + '</a></li>'
		},

		getTemplate: function() {
			var self = this;
			var tmpl = WE.modules.Templates.superclass.getTemplate.call(this);
			tmpl += '<ul class="text-links">';
			if (typeof window.RTE != 'undefined') {
				tmpl += this.getLinkHtml('tmpl_other','otherTemplates',function(){
					self.openTemplatesShowcase();
					self.track('other');
				});
			}
			tmpl += this.getLinkHtml('tmpl_listused','showUsedList',function(){
				self.showUsedTemplates();
				self.track('list');
			});
			if (typeof window.PLBMakeLayoutUrl != 'undefined') {
				tmpl += this.getLinkHtml('tmpl_makelayout','makeLayout',function(){
					self.makeLayoutFromPage();
					self.track('plbLayout');
				});
			}
			tmpl += '</ul>';
			return tmpl;
		},

		modeChanged: function() {
			this.el.filter('.cke_text_links')[this.editor.mode == 'wysiwyg' ? 'show' : 'hide']();
			this.el.find('.cke_text_links')[this.editor.mode == 'wysiwyg' ? 'show' : 'hide']();
			this.el.find('.tmpl_other')[this.editor.mode == 'wysiwyg' ? 'show' : 'hide']();
		},

		afterRender: function() {
			WE.modules.Templates.superclass.afterRender.call(this);
			this.el.find('.cke_button').addClass('cke_button_big');
			this.editor.bind({
				mode: this.modeChanged,
				scope: this
			});
			this.modeChanged();

			// hide "Make new layout" link when rendering for Special:LayoutBuilder (BugId:6722)
			if (window.wgCanonicalSpecialPageName === 'PageLayoutBuilder') {
				this.el.find('.tmpl_makelayout').hide();
			}
		},

		openTemplatesShowcase: function() {
			RTE.templateEditor.createTemplateEditor(false);
		},

		showUsedTemplates: function() {
			var el = this.editor.element.find('.templatesUsed');
			if (el.exists()) {
				var list = $('<div>');
				list.html(el.html());
				list.children().not('ul').remove();
				list.find('a').attr('target','_blank');
				$.showModal(this.msg('templates-showUsedList-dialog-title'),list.html(),{
					width: 400
				});
			}
		},

		makeLayoutFromPage: function() {
			if (typeof window.PLBMakeLayoutUrl != 'undefined') {
				$.confirm({
					title: this.msg('templates-makeLayout-confirmation-title'),
					content: this.msg('templates-makeLayout-confirmation-text'),
					width: 500,
					onOk: function() {
						$("#editform")
							.attr("action", window.PLBMakeLayoutUrl)
							.submit();
					}
				});
			} else {
				// XXX: show error message
			}
		}

	});

	WE.modules.ToolbarTemplates = $.createClass(WE.modules.ButtonsList,{

		modes: true,

		headerClass: 'templates_button',

		items: [
			'TemplatesButton'
		]

	});

	WE.modules.RailTemplates = WE.modules.Templates;

	window.wgEditorExtraButtons['TemplatesButton'] = {
		type: 'modulebutton',
		label: $.msg('wikia-editor-modules-templates-title'),
		title: $.msg('wikia-editor-modules-templates-title'),
		module: 'RailTemplates'
	};


})(this);