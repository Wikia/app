CKEDITOR.plugins.add('rte-plbelement',
{
	init: function(editor) {
		var self = this;
		if(typeof PageLayoutBuilder == 'undefined') {
			return false;
		}

		$.each(PageLayoutBuilder.Library,function(i,v) {
			var re = /<img[^>]*src="([^>"]*)"/i.exec(v.menuItemHtml.html);
			if (re) {
				$().log('preloading image '+re[1]);
				var img = new Image(64,64);
				img.src = re[1];
			}
//			$(v.menuItemHtml.html).appendTo(itemsContainer);
		});

		// macbre: to be removed - magic is performed in PLB/js/editor.js
		/**
		// register template dropdown list
		editor.ui.addRichCombo('Plbelement', {
			label : PageLayoutBuilder.Lang['plb-editor-rte-caption'],
			title: PageLayoutBuilder.Lang['plb-editor-rte-caption'],
			className : 'cke_template',
			trackingName : 'plbAddItem',
			multiSelect : false,
			panel : {
				css : [ PageLayoutBuilder.editorcss, CKEDITOR.getUrl( editor.skinPath + 'editor.css' ) ] . concat( editor.config.contentsCss )
			},

			init : function() {
//				$().log(self);
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

		function addElement(type) {
			var plb = window.plb;
			if (editor.mode == 'source') {
				plb.creator.onAddElementClick( type );
			} else {
				plb.onCreateWidgetRequest( type );
			}
		};

		$.each(PageLayoutBuilder.Library,function(type,def){
			var name = 'PLBAddElement_' + type;
			editor.ui.addButton(name,{
				label: def.caption,
				title: def.caption,
				className: name,
				click: (function(type){
					return function() {
						addElement(type);
					};
				})(type)
			});
		});
		**/
	}
});