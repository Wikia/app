(function(window){

	var WE = window.WikiaEditor;

	WE.modules.Container = $.createClass(WE.modules.base,{
		
		items: false,
		modules: false,
		moduleEls: false,
		
		init: function() {
			if (this.options.items && !this.items) {
				this.items = this.options.items;
			}
			// Initialize
			this.modules = {};
			this.moduleEls = {};
			// Find all required module names
			var modules = this.modules;
			function traverse(item) {
				if (typeof item == 'string') {
					modules[item] = false;
				} else if ($.isArray(item)) {
					for (var i=0;i<item.length;i++) {
						traverse(item[i]);
					}
				} else {
					traverse(item.items);
				}
			}
			traverse(this.items);
			
			// Create module instances
			var module = false;
			for (var name in modules) {
				modules[name] = this.editor.modules.create(name); // returns "false" if module not found
			}
		},
		
		afterRenderChild: function( no, module, el ) {
			return el;
		},
		
		renderChildren: function( el, children ) {
			var childEls = [];
			for (var i=0;i<children.length;i++) {
				var child = children[i], childEl = false;
				if (typeof child == 'string') {
					if (this.modules[child]) {
						childEl = this.modules[child].render();
						
					}
					if (childEl) {
						this.moduleEls[child] = childEl;
					}
					if (childEl) {
						childEl = this.afterRenderChild(child,this.modules[child],childEl);
					}
				} else {
					childEl = $('<div>');
					if (child['cls']) childEl.addClass(child.cls);
					childEl = this.renderChildren(childEl,child.items);
				}
				if (childEl)
					childEls.push(childEl);
			}
			
			if (childEls.length == 0) {
				return false;
			}
			
			for (var i=0;i<childEls.length;i++) {
				if (childEls[i])
					el.append(childEls[i]);
			}
			return el;
		},
		
		modeChanged: function() {
			var mode = this.editor.mode;

			for (var name in this.modules) {
				if (this.modules[name] && this.moduleEls[name]) {
					var module = this.modules[name];
					if (typeof module.modes == 'object') {
						module[ module.modes[mode] ? 'show' : 'hide' ]();
					}
				}
			}
		},
		
		render: function() {
			var el = this.options.element || $('<div>');
			el.addClass(this.containerClass);
			this.el = this.renderChildren(el,this.items) || el;
			
			return this.el;
			/*
			var modules = this.modules = {'Insert':false,'ToolbarTempalates':false,'ToolbarCategories':false,'ToolbarLicense':false};
			var els = this.els = {}, module, moduleEl;
			for (var name in modules) {
				module = WE.createModule(name,this.env);
				if (module) {
					moduleEl = module.render();
					if (moduleEl) {
						modules[name] = module;
						els[name] = $(moduleEl);
					} else {
						delete modules[name];
					}
				} else {
					delete module[name];
				}
			}
			var el = this.el = this.addChildren($('<div class="widescreen-toolbar"/>"'),[
				module['Insert'],
				this.addChildren($('<div class="right right-top"/>'),[modules['ToolbarTemplates'],modules['ToolbarCategories']]),
				this.addChildren($('<div class="right right-bottom"/>'),[modules['ToolbarLicense']])
			]);
			return el;
			*/
		},
		
		afterAttach: function() {
			for (var name in this.modules) {
				if (this.modules[name] && this.moduleEls[name]) {
					this.modules[name].afterAttach();
					this.afterAttachChild(this.modules[name],this.moduleEls[name]);
				}
			}
			
			this.editor.on('mode', this.modeChanged, this);
			this.modeChanged();
		},
		
		afterAttachChild: function( module, el ) {
		}
		
	});
	
	WE.modules.container = WE.modules.Container;

})(this);