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
				var templateName = list[i];
				var buttonId = 'Template_Popular'+i;
				this.editor.ui.addElement(buttonId,{
					type: 'button',
					label: templateName,
					clicksource: (function(templateName){
						return function(sourceEditor) {
							// XXX: fix for multiple instances
							insertTags('{{'+templateName,'}}','');
						};
					})(templateName),
					ckcommand: 'InsertTemplate',
					clickdatawysiwyg: {
						templateName: templateName
					}
				});
				this.items.push(buttonId);
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
				});
			}
			tmpl += this.getLinkHtml('tmpl_listused','showUsedList',function(){
				self.showUsedTemplates();
			});
			if (typeof window.PLBMakeLayoutUrl != 'undefined') {
				tmpl += this.getLinkHtml('tmpl_makelayout','makeLayout',function(){
					self.makeLayoutFromPage();
				});
			}
			tmpl += '</ul>';
			return tmpl;
		},

		modeChanged: function() {
			this.el.filter('.cke_text_links')[this.editor.mode == 'wysiwyg' ? 'show' : 'hide']();
			this.el.find('.cke_text_links')[this.editor.mode == 'wysiwyg' ? 'show' : 'hide']();
		},

		afterRender: function() {
			WE.modules.Templates.superclass.afterRender.call(this);
			this.el.find('.cke_button').addClass('cke_button_big');
			this.editor.bind({
				mode: this.modeChanged,
				scope: this
			});
			this.modeChanged();
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
						alert(2); return;
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
		label: 'templates',
		title: 'Templates',
		module: 'RailTemplates'
	};


})(this);