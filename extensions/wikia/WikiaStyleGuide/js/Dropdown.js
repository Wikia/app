(function($) {

Wikia = Wikia || {};

Wikia.Dropdown = $.createClass(Observable, {
	settings: {
		closeOnEscape: true,
		closeOnOutsideClick: true,
		eventNamespace: 'WikiaDropdown'
	},

	constructor: function(element, options) {
		Wikia.Dropdown.superclass.constructor.apply(this, arguments);

		this.settings = $.extend(this.settings, options);

		this.$window = $(window);
		this.$wrapper = $(element).addClass('closed');
		this.$dropdown = this.$wrapper.children('ul').eq(0);

		this.$wrapper.on('click.' + this.settings.eventNamespace, this.proxy(this.onClick));

		if (this.settings.closeOnEscape || this.settings.onKeyDown) {
			this.$window.on('keydown.' + this.settings.eventNamespace, this.proxy(this.onKeyDown));
		}

		if (this.settings.closeOnOutsideClick || this.settings.onWindowClick) {
			this.$window.on('click.' + this.settings.eventNamespace, this.proxy(this.onWindowClick));
		}

		this.fire('initialize');
	},

	/**
	 * Methods
	 */

	open: function() {
		this.$wrapper.toggleClass('open closed');
		this.fire('open');
	},

	close: function() {
		this.$wrapper.toggleClass('open closed');
		this.fire('close');
	},

	/**
	 * Getters
	 */

	getItems: function() {
		return this.$dropdown.children('li');
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
		if (!this.settings.onClick || this.settings.onClick() !== false) {
			if (!this.isOpen()) {
				this.open();
			}
		}

		this.fire('click', event);
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

	onWindowClick: function(event) {
		if (!this.settings.onWindowClick || this.settings.onWindowClick() !== false) {

			// Close when user clicks outside the dropdown if option is enabled
			if (this.settings.closeOnOutsideClick && this.isOpen() && !$.contains(this.$wrapper[0], event.target)) {
				this.close();
			}
		}

		this.fire('windowClick', event);
	}
});

Wikia.MultiSelectDropdown = $.createClass(Wikia.Dropdown, {
	constructor: function() {
		this.settings.eventNamespace = 'WikiaMultiSelectDropdown';

		Wikia.MultiSelectDropdown.superclass.constructor.apply(this, arguments);

		this.$checkboxes = this.getItems().find(':checkbox');
		this.$selectedItems = this.$wrapper.find('.selected-items');
		this.$selectedItemsList = this.$selectedItems.find('.list');

		this.$checkboxes.on('change.' + this.settings.eventNamespace, this.proxy(this.onChange));

		this.update();
	},

	/**
	 * Methods
	 */

	close: function() {
		Wikia.MultiSelectDropdown.superclass.open.apply(this, arguments);
		this.update();
	},

	update: function() {
		var remaining,
			selected = [],
			maxDisplayed = 3;

		this.$selectedItemsList.empty();

		this.getItems().each(this.proxy(function(i, element) {
			var $element = $(element),
				$checkbox = $element.find(':checkbox');

			// Clear un-selected checkboxes (Firefox bug)
			if (!$checkbox.is(':checked')) {
				$checkbox.removeAttr('checked');

			} else {
				selected.push($element.find('label').text());
			}
		}));

		// Display first 3 items in list
		this.$selectedItemsList.append($('<strong>').text(selected.slice(0, maxDisplayed).join(', ')));

		// Display "and X more" if there are more items leftover
		if ((remaining = selected.length - maxDisplayed) > 0) {
			this.$selectedItemsList.append(' and ' + remaining + ' more');
		}

		// Keep the size of the dropdown in sync with the selected items list
		this.$dropdown.css('width', this.$selectedItems.outerWidth());

		this.fire('update');
	},

	/**
	 * Getters
	 */

	getSelectedValues: function() {
		return this.getSelectedItems().map(function() {
			return $(this).find(':checked').val();
		}).get();
	},

	/**
	 * Events
	 */

	onChange: function(event) {
		var $checkbox = $(event.target);

		if (!this.settings.onChange || this.settings.onChange() !== false) {
			$checkbox.closest('li').toggleClass('selected');
		}

		this.fire('change', event);
	}
});

// Exports
window.Wikia = Wikia;

})(jQuery, Wikia);