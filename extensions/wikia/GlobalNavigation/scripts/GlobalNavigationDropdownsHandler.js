define('wikia.globalNavigationDropdowns', ['wikia.window', 'jquery'], function(win, $) {
	'use strict';

	var registeredDropdowns = {},
		activeDropdown;

	function openDropdown(event) {
		var $this = $(this),
			dropdownOpts = registeredDropdowns[this.id];
		if (activeDropdown && activeDropdown !== this.id) {
			closeActiveDropdown();
		}
		$this.addClass('active');
		dropdownOpts.onOpen.call(this, event);
		win.transparentOut.show();
		activeDropdown = this.id
	}

	function closeDropdown() {
		var $this = $(this),
			dropdownOpts = registeredDropdowns[this.id];
		closeSelectedDropdown($this, dropdownOpts);
	}

	function closeActiveDropdown() {
		var $dropdown,
			dropdownOpts;
		if (activeDropdown) {
			$dropdown = $(document.getElementById(activeDropdown));
			dropdownOpts = registeredDropdowns[activeDropdown];
			closeSelectedDropdown($dropdown, dropdownOpts, true);
		}
	}

	/**
	 * @desc Close dropdown passed as argument.
	 * If dropdown's onClose method returns false - this method's body is not executed.
	 * This can be overridden by passing forceClose as true - it ignores onClose method return value.
	 * @param {jQuery} $dropdown - jquery object representing dropdown
	 * @param {Object} dropdownOpts - dropdown options
	 * @param {Boolean} forceClose - if forceClose is passed ignore return value of onClose dropdown's method
	 */
	function closeSelectedDropdown($dropdown, dropdownOpts, forceClose) {
		var onCloseReturnVal;
		if (dropdownOpts) {
			onCloseReturnVal = dropdownOpts.onClose.call(this);
		}
		if (forceClose || onCloseReturnVal !== false) {
			$dropdown.removeClass('active');
			win.transparentOut.hide();
			activeDropdown = false;
		}
	}

	function toggleDropdown(event) {
		var $target = $(event.target);
		//If click was inside dropdown - don't handle
		if ($target.closest('.global-nav-dropdown').length > 0) {
			return;
		}
		if (activeDropdown) {
			closeActiveDropdown();
			if (this.id !== activeDropdown) {
				openDropdown.call(this, event);
			}
		} else {
			openDropdown.call(this, event);
		}
	}

	function attachDropdown($entryPoint, dropdownOpts) {
		var id = $entryPoint.attr('id');
		registeredDropdowns[id] = {
			onOpen: dropdownOpts.onOpen || Function.prototype,
			onClose: dropdownOpts.onClose || Function.prototype
		};

		if (dropdownOpts.onClick) {
			$entryPoint.on('click', dropdownOpts.onClickTarget, dropdownOpts.onClick);
		} else {
			$entryPoint.on('click', toggleDropdown);
		}
	}

	$(function() {
		win.transparentOut.bindClick(closeActiveDropdown);
	});

	return {
		openDropdown: openDropdown,
		closeDropdown: closeDropdown,
		attachDropdown: attachDropdown
	};
});
