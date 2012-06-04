(function($) {

Wikia = Wikia || {};

/**
 * An unordered list dropdown menu.
 *
 * @author Kyle Florence
 */
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
		this.$dropdown = this.$wrapper.find('.dropdown');

		this.bindEvents();
	},

	/**
	 * Methods
	 */

	bindEvents: function() {
		this.$wrapper
			.off('click.' + this.settings.eventNamespace)
			.on('click.' + this.settings.eventNamespace, this.proxy(this.onClick));

		this.$window
			.off('click.' + this.settings.eventNamespace)
			.off('keydown.' + this.settings.eventNamespace);

		if (this.settings.closeOnEscape || this.settings.onKeyDown) {
			this.$window.on('keydown.' + this.settings.eventNamespace, this.proxy(this.onKeyDown));
		}

		if (this.settings.closeOnOutsideClick || this.settings.onWindowClick) {
			this.$window.on('click.' + this.settings.eventNamespace, this.proxy(this.onWindowClick));
		}

		this.fire('bindEvents');
	},

	close: function() {
		this.$wrapper.toggleClass('open closed');
		this.fire('close');
	},

	open: function() {
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

/**
 * A dropdown list with checkboxes.
 * See: https://internal.wikia-inc.com/wiki/File:Recent_changes_filter_redlines-01.png
 *
 * @author Kyle Florence
 */
Wikia.MultiSelectDropdown = $.createClass(Wikia.Dropdown, {
	constructor: function() {
		$.extend(this.settings, {
			eventNamespace: 'WikiaMultiSelectDropdown',
			maxHeight: 390,
			minHeight: 30
		});

		Wikia.MultiSelectDropdown.superclass.constructor.apply(this, arguments);

		this.dropdownMarginBottom = parseFloat(this.$dropdown.css('marginBottom')) || 10;
		this.dropdownItemHeight = parseFloat(this.getItems().eq(0).css('lineHeight')) || 30;

		this.$checkboxes = this.getItems().find(':checkbox');
		this.$footerToolbar = $('.WikiaFooter .toolbar');
		this.$selectedItems = this.$wrapper.find('.selected-items');
		this.$selectedItemsList = this.$selectedItems.find('.selected-items-list');

		this.$checkboxes.on('change.' + this.settings.eventNamespace, this.proxy(this.onChange));
		this.$window.on(
			'resize.' + this.settings.eventNamespace + ' ' +
			'scroll.' + this.settings.eventNamespace, this.proxy(this.updateDropdownHeight));

		this.updateDropdownHeight();
		this.updateSelectedItemsList();
	},

	/**
	 * Methods
	 */

	close: function() {
		Wikia.MultiSelectDropdown.superclass.close.apply(this, arguments);
		this.updateSelectedItemsList();
	},

	open: function() {
		Wikia.MultiSelectDropdown.superclass.open.apply(this, arguments);
		this.updateDropdownHeight();
	},

	// Change the height of the dropdown between a minimum and maximum height
	// to make sure it doesn't overlap the footer toolbar.
	updateDropdownHeight: function() {
		var dropdownOffset = this.$dropdown.offset().top,
			footerToolbarOffset = this.$footerToolbar.offset().top,
			dropdownHeight = Math.min(this.settings.maxHeight, footerToolbarOffset - dropdownOffset - this.dropdownMarginBottom);

		// Filter the new height through the dropdown minimum height and item height
		dropdownHeight = Math.max(this.settings.minHeight, Math.floor(dropdownHeight / this.dropdownItemHeight) * this.dropdownItemHeight);

		this.$dropdown.height(dropdownHeight);
	},

	updateSelectedItemsList: function() {
		var all,
			remaining,
			items = this.getItems(),
			maxDisplayed = 3,
			selected = [];

		this.$selectedItemsList.empty();

		items.each(this.proxy(function(i, element) {
			var $element = $(element),
				$checkbox = $element.find(':checkbox');

			// Clear un-selected checkboxes (Firefox bug)
			if (!$checkbox.is(':checked')) {
				$checkbox.removeAttr('checked');

			} else {
				selected.push($element.find('label').text());
			}
		}));

		all = (items.length == selected.length);

		// Display first three items in list, or 'All' if everything is selected
		this.$selectedItemsList.append($('<strong>').text(all ? $.msg('wikiastyleguide-dropdown-all') : selected.slice(0, maxDisplayed).join(', ')));

		// Display "and X more" if there are more items leftover
		if (!all && (remaining = selected.length - maxDisplayed) > 0) {
			this.$selectedItemsList.html($.msg('wikiastyleguide-dropdown-selected-items-list', this.$selectedItemsList.html(), remaining));
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
			$checkbox.closest('.dropdown-item').toggleClass('selected');
		}

		this.fire('change', event);
	}
});

// Exports
window.Wikia = Wikia;

})(jQuery, Wikia);