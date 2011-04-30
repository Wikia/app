(function(window,$){
	
	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable);
	
	WE.module = $.createClass(Observable,{

		MESSAGE_MODULE_PREFIX: 'modules-',
		
		// module is only visible in wysiwyg mode
		modes: {
			wysiwyg: true
		},

		enabled: true,
		
		headerClass: '',
		headerText: '',
		headerTextId: '',

		constructor: function( editor, options ) {
			WE.module.superclass.constructor.call(this);
			this.editor = editor;
			this.options = options;
			this.ui = this.editor.ui;
			this.init();
		},

		init: function() {},

		getHeaderClass: function() {
			return this.headerClass;
		},

		getHeaderText: function() {
			if (this.headerTextId) return this.msg(this.headerTextId);
			if (this.headerText) return this.headerText;
			return '';
		},
		
		setHeaderText: function( text ) {
			this.headerText = text;
			this.fire('headerchange',this,text);
		},

		getTemplate: function() {
			return this.template;
		},

		getData: function() {
			return this.data;
		},

		renderHtml: function() {
			return $.tmpl(this.getTemplate(),this.getData());
		},

		render: function() {
			if (!this.enabled) {
				return false;
			}
			
			var el = $(this.renderHtml());
			this.el = el;
			this.afterRender();
			return el;
		},

		afterRender: function() {},
		afterAttach: function() {},

		// show / hide module wrapper - controlled by space
		show: function() {
			this.el.show();
			this.fire('show',this);
		},
		
		hide: function() {
			this.el.hide();
			this.fire('hide',this);
		},
		
		msg: function() {
			var args = Array.prototype.slice.call(arguments,0);
			args[0] = this.MESSAGE_MODULE_PREFIX + args[0];
			return this.editor.msg.apply(this.editor,args);
		}
		
	});
	
	WE.modules.base = WE.module;
	
})(this,jQuery);