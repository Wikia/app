(function () {
	'use strict';

	var UserLoginDropdown = {
		dropdown: false,
		loginAjaxForm: false,
		bucky: window.Bucky('UserLoginDropdown'),
		init: function () {
			this.bucky.timer.start('init');
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
			this.bucky.timer.stop('init');
		},
		show: function () {
			this.bucky.timer.start('show');
			if (!this.dropdown.hasClass('show')) {
				this.dropdown.addClass('show');
				this.dropdown.trigger('hovermenu-shown');

				if (!this.loginAjaxForm && !window.wgUserName) {
					this.loginAjaxForm = new window.UserLoginAjaxForm(this.dropdown);
					window.FacebookLogin.init(window.FacebookLogin.origins.DROPDOWN);
				}

				$('body')
					.unbind('.loginDropdown')
					.bind('click.loginDropdown', $.proxy(this.outsideClickHandler, this));
			}
			this.loginAjaxForm.inputs.username.focus();
			this.bucky.timer.stop('show');
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
