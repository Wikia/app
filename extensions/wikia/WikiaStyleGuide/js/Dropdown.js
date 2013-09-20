(function(window, $) {

var Wikia = window.Wikia || {};

/**
 * An unordered list dropdown menu.
 * For checkboxes and multiselect functionality, see ./MultiSelectDropdown.js
 *
 * @author Kyle Florence
 */

Wikia.Dropdown = $.createClass(Observable, {
	settings: {
		closeOnEscape: true,
		closeOnOutsideClick: true,
		eventNamespace: 'WikiaDropdown',
		onChange: null,
		onDocumentClick: null,
		onClick: null,
		onKeyDown: null
	},

	constructor: function(element, options) {
		Wikia.Dropdown.superclass.constructor.apply(this, arguments);

		this.settings = $.extend(this.settings, options);

		this.$document = $(document);
		this.$wrapper = $(element).addClass('closed');
		this.$dropdown = this.$wrapper.find('.dropdown');
		this.$selectedItems = this.$wrapper.find('.selected-items');
		this.$selectedItemsList = this.$selectedItems.find('.selected-items-list');

		this.bindEvents();
	},

	/**
	 * Methods
	 */

	bindEvents: function() {
		this.$wrapper
			.off('click.' + this.settings.eventNamespace)
			.on('click.' + this.settings.eventNamespace, this.proxy(this.onClick));

		this.getItems()
			.off('click.' + this.settings.eventNamespace)
			.on('click.' + this.settings.eventNamespace, this.proxy(this.onChange));

		this.$document
			.off('click.' + this.settings.eventNamespace)
			.off('keydown.' + this.settings.eventNamespace);

		if (this.settings.closeOnEscape || this.settings.onKeyDown) {
			this.$document.on('keydown.' + this.settings.eventNamespace, this.proxy(this.onKeyDown));
		}

		if (this.settings.closeOnOutsideClick || this.settings.onDocumentClick) {
			this.$document.on('click.' + this.settings.eventNamespace, this.proxy(this.onDocumentClick));
		}

		this.fire('bindEvents');
	},

	disable: function() {
		this.close();
		this.$wrapper.addClass('disable');
	},

	enable: function() {
		this.$wrapper.removeClass('disable');
	},

	close: function() {
		this.$wrapper.removeClass('open').addClass('closed');
		this.fire('close');
	},

	open: function() {
		if(this.$wrapper.hasClass('disable')) {
			return true;
		}

		this.$wrapper.toggleClass('open closed');
		this.fire('open');
	},

	/**
	 * Getters
	 */

	getItems: function() {
		return this.$dropdown.find('.dropdown-item');
	},

	getSelectedItems: function() {
		return this.getItems().filter('.selected');
	},

	isOpen: function() {
		return this.$wrapper.hasClass('open');
	},

	/**
	 * Events
	 */

	onClick: function(event) {
		var $target = $(event.target);

		if($target.is(this.getItems().find('label'))) {
			return;
		}

		if (!this.settings.onClick || this.settings.onClick() !== false) {
			if (!this.isOpen()) {
				this.open();
			}
		}

		this.fire('click', event);
	},

	onChange: function(event) {
		var $target = $(event.target);

		var value = $target.text();

		if ($.isFunction(this.settings.onChange)) {
			this.settings.onChange.call(this, event, $target);
		}

		// Since this is for single (not multi) select, mark one item as selected
		this.getSelectedItems().removeClass('selected');
		$target.parent().addClass('selected');

		this.$selectedItemsList.text(value);

		this.fire('change', event);

		this.close();
	},

	onKeyDown: function(event) {
		if (!this.settings.onKeyDown || this.settings.onKeyDown() !== false) {

			// Close when the escape key is pressed if option is enabled and dropdown is open
			if (this.settings.closeOnEscape && event.keyCode == 27 && this.isOpen()) {
				this.close();
			}
		}

		this.fire('keyDown', event);
	},

	onDocumentClick: function(event) {
		if (!this.settings.onDocumentClick || this.settings.onDocumentClick() !== false) {

			// Close when user clicks outside the dropdown if option is enabled
			if (this.settings.closeOnOutsideClick && this.isOpen() && !$.contains(this.$wrapper[0], event.target)) {
				this.close();
			}
		}

		this.fire('documentClick', event);
	}
});

$.fn.wikiaDropdown = function(options) {
	return this.each(function() {
		$.data(this, 'WikiaDropdown', new Wikia.Dropdown(this, options));
	});
};

// Exports
window.Wikia = Wikia;

})(this, jQuery);
