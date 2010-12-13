CKEDITOR.plugins.add('rte-plbelement',
{
	init: function(editor) {
		var self = this;
		if(typeof PageLayoutBuilder == 'undefined') {
			return false;
		}
		
		$.each(PageLayoutBuilder.Library,function(i,v) {
			$(v.menuItemHtml.html);
		});
		
		// register template dropdown list
		editor.ui.addRichCombo('Plbelement', {
			label : PageLayoutBuilder.Lang['plb-editor-rte-caption'],
			title: PageLayoutBuilder.Lang['plb-editor-rte-caption'],
			className : 'cke_template',
			multiSelect : false,
			panel : {
				css : [ PageLayoutBuilder.editorcss, CKEDITOR.getUrl( editor.skinPath + 'editor.css' ) ] . concat( editor.config.contentsCss )
			},

			init : function() {
				$().log(self);
				this.addButton = $('.plb-add-element',this.el);
				var addMenu = $('ul',this.addButton);
				// ... by adding the items representing all widget types
				
				var templates = new Array();
				$.each(PageLayoutBuilder.Library,function(i,v) {
					templates.push(v.menuItemHtml);
				});

				for (t=0; t < templates.length; t++) {
					this.add(templates[t].plb_type, templates[t].html, templates[t].caption);
				}
			},

			onClick : function(value) {
				window.plb.ui.onAddElementClick(value);	
				return false;
			}
		});
	}
});