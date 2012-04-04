(function(window,$){

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable());

	WE.ui = WE.ui || {};

	/**
	 * Defines UI element base class.
	 *
	 * UI element is always returned as HTML string.
	 */
	WE.ui.base = $.createClass(Observable,{

		constructor: function( editor, config, data ) {
			WE.ui.base.superclass.constructor.call(this);
			this.editor = editor;
			this.config = config;
			if (typeof config == 'object') {
				for (var k in config) {
					this[k] = config[k];
				}
			}
			this.data = data || {};
			this.data.button = this;
			this.init();
		},

		init: function() {
		},

		beforeRender: function() {
		},

		renderHtml: function() {
			return '';
		},

		render: function() {
			if (!this.config)
				return '';
			this.beforeRender();
			return this.renderHtml();
		},

		proxy: function( fn ) {
			return $.proxy(fn,this);
		}

	});

	WE.ui.button = $.createClass(WE.ui.base,{

		statics: {
			nextId: 1
		},

		clickButtonHandler: function() {
			var mode = this.editor.mode;
			if (typeof this['click'+mode] == 'function')
				return this['click'+mode].apply(this,arguments);
			else
				this.editor.warn('Mode "'+mode+'" not supported for button: '+this.name);
		},

		buildClickHandler: function() {
			this.click = this.clickButtonHandler;
			this.editor.fire('uiBuildClickHandler',this.editor,this);
		},

		beforeRender: function() {
			// set up label
			this.label || (this.label = $.msg(this.labelId));
			if(typeof this.label != 'undefined') {
				if(this.label.match(/<.*>/)) {
					this.label = $.msg(this.label.replace('<','').replace('>',''));
				}
			}
			this.label = this.label || '';
			// set up title
			this.title || (this.titleId && (this.title = $.msg(this.titleId))) || (this.title = this.label);
			this.title = this.title || '';
			// set up id
			this.id = 'uielem_' + WE.ui.button.nextId++;
			// set up buttonClass
			this.buttonClass = 'cke_' + this.type;
			// set up classes
			this.classes = (this.className || '');
			// set up label class
			this.labelClass = this.labelClass || 'cke_label';
			// set up arrow class
			this.arrowClass = this.arrowClass || 'cke_openbutton';
			// set up click callback
			this.click = this.click || this.buildClickHandler();
			this.clickFn = this.clickFn || this.editor.addFunction(this.proxy(this.click));
		},

		renderHtml: function() {
			var html = '';

			html += '<span class="' + this.buttonClass + ' ' + this.classes + '">';
			html += '<a id="' + this.id + '" class="cke_off ' + this.classes + '"'
				+ ' title="' + this.title + '"'
				+ ' tabindex="-1"'
				+ ' hidefocus="true"'
			    + ' role="button"'
				+ ' aria-labelledby="' + this.id + '_label"';

			// Some browsers don't cancel key events in the keydown but in the
			// keypress.
			// TODO: Check if really needed for Gecko+Mac.
			/*
			if ( env.opera || ( env.gecko && env.mac ) )
			{
				html += ' onkeypress="return false;"';
			}
			*/

			// With Firefox, we need to force the button to redraw, otherwise it
			// will remain in the focus state.
			/*
			if ( env.gecko )
			{
				html += ' onblur="this.style.cssText = this.style.cssText;"';
			}
			*/

			//html +=	' onclick="WikiaEditor.callFunction(' + this.clickFn + ', this); return false;">';
			//html += ' onclick="return false;"';
			html += ' onmousedown="WikiaEditor.callFunction(' + this.clickFn + ', this); return false;">';

			if ( this.hasIcon !== false ) {
				html += '<span class="cke_icon">&nbsp;</span>';
			}
			if ( this.hasLabel !== false ) {
				html += '<span id="' + this.id + '_label" class="' + this.labelClass + '">' + this.label + '</span>';
			}

			if ( this.hasArrow ) {
				html += '<span class="' + this.arrowClass + '">&nbsp;</span>';
			}

			html += '</a>' + '</span>';

			this.data.id = this.id;

			return html;
		}

	});

	WE.ui.panelbutton = $.createClass(WE.ui.button,{

		getEl: function() {
			var button = $('#'+this.id);
			return button.exists() && button.closest('.cke_'+this.type);
		},

		moveInside: function() {
			this.data.inside++;
		},

		moveOutside: function() {
			this.data.inside--;
		},

		renderPanel: function() {
			var button = $('#'+this.id),
				el = this.getEl();
			if (button && el && !this.panel) {
				var pos = el.position();
				var panel = this.panel = $('<div>');
				panel.addClass('cke_panel_dropdown').addClass(this.panelClass || '').appendTo(el.offsetParent());
				this.positionPanel();
				this.panelOnInit && this.panelOnInit(this.panel,this,panel);
				panel.hide();

				button.add(panel)
					.mouseenter(this.proxy(this.moveInside))
					.mouseleave(this.proxy(this.moveOutside));
				panel
					.delegate('.cke_button, .text-links a','mouseenter',this.proxy(this.moveOutside))
					.delegate('.cke_button, .text-links a','mouseleave',this.proxy(this.moveInside));
			}
		},

		positionPanel: function() {
			var el = this.getEl();
			var pos = el.position();
			var mod = { left: 5, top: -20 };
			this.panel.css({
				position: 'absolute',
				left: pos.left + mod.left,
				top: pos.top + mod.top + el.outerHeight(),
				'padding-top': -mod.top
			});
		},

		clickHandler: function() {
			var button = $('#'+this.id),
				el = button.closest('.cke_'+this.type);
			if (!this.panel)
				this.renderPanel();
			if (!this.opened) {
				el.addClass('cke_opened');
				this.panelOnShow && this.panelOnShow(this.panel,this);
				this.positionPanel();
				this.panel.show();
				this.opened = true;
				this.inside = 1;
			} else {
				el.removeClass('cke_opened');
				this.panelOnHide && this.panelOnHide(this.panel,this);
				this.panel.hide();
				this.opened = false;
				this.inside = 0;
			}
		},


		beforeRender: function() {
			this.opened = false;
			this.click = this.clickHandler;

			// call superclass
			WE.ui.panelbutton.superclass.beforeRender.call(this);

			this.editor.ui.on('bodyClick',this.proxy(function() {
				if (this.opened && this.inside == 0) {
					this.click();
				}
			}));
			this.editor.on('editorFocus',this.proxy(function() {
				if (this.opened) {
					this.click();
				}
			}));
			this.hasArrow = true;
			this.labelClass = 'cke_text';

			if (this.autorenderpanel) {
				this.editor.on('toolbarsRendered',this.proxy(this.renderPanel));
			};
		},

		panelOnInit: function() {},
		panelOnShow: function() {},
		panelOnHide: function() {}

	});

	WE.ui.modulebutton = $.createClass(WE.ui.panelbutton,{

		panelOnInit: function( panel, config, data ) {
			var module = this.moduleObject = this.editor.modules.create(config.module);
			var el = module.render();

			// immitate that module sits in rail
			var headerClass = module.getHeaderClass();
			var elcontent = $('<div>')
				.addClass('module_content')
				.append(el)
			var elmodule = $('<div>')
				.addClass('module module_' + headerClass)
				.attr('data-id',headerClass)
				.append(elcontent);

			panel.append(elmodule);
			module.afterAttach();
		},

		beforeRender: function() {
			this.panelClass = this.panelClass ? this.panelClass + ' ' : '';

			// call sueprclass
			WE.ui.modulebutton.superclass.beforeRender.call(this);
		}

	});

})(this,jQuery);
