(function () {
	'use strict';

	var UserLoginDropdown = {
		dropdown: false,
		loginAjaxForm: false,
		init: function () {
			// DOM cache
			this.dropdown = $('#UserLoginDropdown');

			$('#AccountNavigation').find('.ajaxLogin')
				.click($.proxy(function (ev) {
					ev.preventDefault();
					ev.stopPropagation(); // BugId:16984
					this.show();
				}, this))
				.closest('li').hover(function (e) {
					e.preventDefault();
					UserLoginDropdown.hoverHandle = setTimeout(function () {
						UserLoginDropdown.show();
					}, 300);
				}, function () {
					// do nothing on hover out
					clearTimeout(UserLoginDropdown.hoverHandle);
				});

			window.HoverMenuGlobal.menus.push(UserLoginDropdown);
		},
		show: function () {
			if (!this.dropdown.hasClass('show')) {
				this.dropdown.addClass('show');
				this.dropdown.trigger('hovermenu-shown');

				if (!this.loginAjaxForm) {
					this.loginAjaxForm = new window.UserLoginAjaxForm(this.dropdown);

					// lazy load jquery.wikia.tooltip.js (BugId:22143)
					window.UserLoginFacebook.init(window.UserLoginFacebook.origins.DROPDOWN);
				}

				$('body').
				unbind('.loginDropdown').
				bind('click.loginDropdown', $.proxy(this.outsideClickHandler, this));
			}
			this.loginAjaxForm.inputs.username.focus();
		},
		hide: function () {
			this.dropdown.removeClass('show');
			this.dropdown.trigger('hovermenu-hidden');

			$('body').unbind('.loginDropdown');
		},
		outsideClickHandler: function (e) {
			var target = $(e.target);

			if (!target.closest('#AccountNavigation').exists()) {
				this.hide();
			}
		},
		hideNav: function () {
			UserLoginDropdown.hide();
		}
	};

	window.UserLoginDropdown = UserLoginDropdown;

	$(function () {
		UserLoginDropdown.init();
	});
})();
