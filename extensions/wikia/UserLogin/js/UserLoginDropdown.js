var UserLoginDropdown = {
	dropdown: false,
	loginAjaxForm: false,
	init: function() {
		// DOM cache
		this.dropdown = $("#UserLoginDropdown");

		$("#AccountNavigation .ajaxLogin")
			.click($.proxy(function(ev) {
				ev.preventDefault();
				ev.stopPropagation(); // BugId:16984
				this.show();
			}, this))
			.closest('li').hover(function(e) {
				e.preventDefault();
				UserLoginDropdown.hoverHandle = setTimeout(function() {
					UserLoginDropdown.show();
				}, 300);
			}, function(e) {
				// do nothing on hover out
				clearTimeout(UserLoginDropdown.hoverHandle);
			});

		HoverMenuGlobal.menus.push(UserLoginDropdown);
	},
	show: function() {
		if(!this.dropdown.hasClass('show')) {
			this.dropdown.addClass('show');
			if(!this.loginAjaxForm) {
				this.loginAjaxForm = new UserLoginAjaxForm(this.dropdown);

				// lazy load jquery.wikia.tooltip.js (BugId:22143)
				UserLoginFacebook.init();
			}

			$('body').
				unbind('.loginDropdown').
				bind('click.loginDropdown', $.proxy(this.outsideClickHandler, this));
		}
		this.loginAjaxForm.inputs['username'].focus();
	},
	hide: function() {
		this.dropdown.removeClass('show');

		$('body').unbind('.loginDropdown');
	},
	outsideClickHandler: function(e) {
		var target = $(e.target);

		if(!target.closest('#AccountNavigation').exists()) {
			this.hide();
		}
	},
	hideNav: function() {
		UserLoginDropdown.hide();
	}
};

$(function() {
	UserLoginDropdown.init();
});