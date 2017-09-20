(function(window,$){

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable());

	/**
	 * Defines module base class
	 * 
	 * Module is always rendered as DOM node.
	 */
	WE.module = $.createClass(Observable,{

		MODULE_MESSAGES_PREFIX: 'modules-',

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

		// to be overriden if special initialization is needed
		init: function() {},

		getHeaderClass: function() {
			return this.headerClass;
		},

		getHeaderText: function() {
			if (this.headerTextId){ return this.msg(this.headerTextId); }
			if (this.headerText){ return this.headerText; }
			return '';
		},

		setHeaderText: function( text ) {
			this.headerText = text;
			this.fire('headerchange',this,text);
		},

		// can be overriden if the template is not a constant string
		getTemplate: function() {
			return this.template;
		},

		// can be overriden if the data is not a constant
		getData: function() {
			return this.data;
		},

		// can be overriden if markup has to be created in some other way
		renderHtml: function() {
			return Mustache.render(this.getTemplate(),this.getData());
		},

		// renders the element and returns it as a jQuery wrapped object
		render: function() {
			if (!this.enabled) {
				return false;
			}

			var el = $(this.renderHtml());
			this.el = el;
			this.afterRender();
			return el;
		},

		// override to perform specific actions after HTML is transformed into DOM node
		afterRender: function() {},
		// override to perform specific actions after DOM node is added to document tree
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

		// shortcut to perform translation
		msg: function() {
			var args = Array.prototype.slice.call(arguments,0);
			args[0] = this.MODULE_MESSAGES_PREFIX + args[0];
			return this.editor.msg.apply(this.editor,args);
		},

		// shortcut to create callbacks bound to this object
		proxy: function( fn ) {
			return $.proxy(fn,this);
		}

	});

	WE.modules.base = WE.module;

})(this,jQuery);