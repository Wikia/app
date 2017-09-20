(function(window){

	var WE = window.WikiaEditor;

	WE.modules.FormatExpanded = $.createClass(WE.modules.ButtonsList,{
		headerClass: 'format_expanded',
		items: [
			'Underline',
			'Strike',
			'Signature'
		],
		storageEntry: 'wgFormatToolbarExpandState',
		
		buttonsTemplate: '<div class="cke_toolbar_expand">' +
			'<a class="expand"><label>{{more}}</label><span>+</span></a>' +
			'<a class="collapse"><label>{{less}}</label><span>-</span></a>' +
			'</div>',

		afterAttach: function() {
			// render more / less buttons
			var buttonsData = {
				more: $.msg('editpagelayout-more'),
				less: $.msg('editpagelayout-less')
			};
			this.buttons = $(Mustache.render(this.buttonsTemplate, buttonsData));
			this.buttons.insertAfter(this.el);

			this.expandButton = this.buttons.find('.expand');
			this.collapseButton = this.buttons.find('.collapse');

			// apply initial state and attach events
			var self = this;
			this.expandButton.bind('click', function(ev) {
				self.expand(true);
			});
			this.collapseButton.bind('click', function(ev) {
				self.expand(false);
			});

			// init toolbar
			this.show();
		},

		// is toolbar expanded
		readState: function() {
			if (this.editor.config.formatExpanded) {
				return true;
			}
			return $.storage.get(this.storageEntry) || false;
		},

		saveState: function(isExpanded) {
			if (!this.editor.config.formatExpanded) {
				$.storage.set(this.storageEntry, isExpanded === true);
			}
		},

		show: function() {
			var isShown = this.readState();
			this.expand(isShown);
			this.buttons.show();
		},

		hide: function() {
			this.el.hide();
			this.buttons.hide();
		},

		// expand (or collapse) toolbar
		expand: function(expand) {
			if (expand) {
				this.el.show();
				this.expandButton.hide();
				this.collapseButton.show();
			}
			else {
				this.el.hide();
				this.expandButton.show();
				this.collapseButton.hide();
			}

			this.saveState(expand);

			// rescale editor
			this.editor.element.trigger('resize');
		}
	});
})(this);