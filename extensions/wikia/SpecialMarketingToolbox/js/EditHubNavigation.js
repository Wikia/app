var ModuleNavigation = function() {
};

ModuleNavigation.prototype = {
	boxes: undefined,

	init: function () {
		this.boxes = $('#marketing-toolbox-form').find('.module-box');
		this.initButtons();
	},

	initButtons: function() {
		this.boxes.filter(':first').find('.nav-up').attr('disabled', 'disabled');
		this.boxes.filter(':last').find('.nav-down').attr('disabled', 'disabled');

		this.boxes.find('.nav-up').filter(':not(:disabled)').click($.proxy(this.moveUp, this));
		this.boxes.find('.nav-down').filter(':not(:disabled)').click($.proxy(this.moveDown, this));
	},

	moveUp: function(event) {
		var sourceBox = $(event.target).parents('.module-box');
		var destBox = $(event.target).parents('.module-box').prev();
		this.switchValues(sourceBox, destBox);
		return false;
	},

	moveDown: function() {
		var sourceBox = $(event.target).parents('.module-box');
		var destBox = $(event.target).parents('.module-box').next();
		this.switchValues(sourceBox, destBox);
		return false;
	},

	switchValues: function(source, dest) {
		// TODO switch module data
		console.log(source);
		console.log(dest);
	}
};

var moduleNavigation = new ModuleNavigation();
$(function () {
	moduleNavigation.init();
});