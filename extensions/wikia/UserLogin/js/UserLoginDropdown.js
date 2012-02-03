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
				if (!this.dropdown.hasClass('show')) {
					this.show();
				}
				else {
					this.hide();
				}
			}, this))
			.closest('li').hover($.proxy(function(e) {
				e.preventDefault();
				this.show();
			}, this), function(e) {
				// do nothing
			});
	},
	show: function() {
		if(!this.dropdown.hasClass('show')) {
			this.dropdown.addClass('show');
			if(!this.loginAjaxForm) {
				this.loginAjaxForm = new UserLoginAjaxForm(this.dropdown);
			}
			this.loginAjaxForm.inputs['username'].focus();

			$('body').
				unbind('.loginDropdown').
				bind('click.loginDropdown', $.proxy(this.outsideClickHandler, this));
		}
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
	}
};

$(function() {
	UserLoginDropdown.init();
});