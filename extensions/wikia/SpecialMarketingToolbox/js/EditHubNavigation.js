var ModuleNavigation = function() {
};

ModuleNavigation.prototype = {
	boxes: undefined,
	switchSelector: 'input:not(:button), textarea, .filename-placeholder, .image-placeholder img',

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

	moveDown: function(event) {
		var sourceBox = $(event.target).parents('.module-box');
		var destBox = $(event.target).parents('.module-box').next();
		this.switchValues(sourceBox, destBox);
		return false;
	},

	switchValues: function(source, dest) {
		var sourceContainers = source.find(this.switchSelector);
		var destContainers = dest.find(this.switchSelector);

		var sourceContainersLength = sourceContainers.length;
		var destContainersLength = destContainers.length;

		if (sourceContainersLength != destContainersLength) {
			throw "Switchable length not equals";
		}
		for (var i = 0; i < sourceContainersLength; i++) {
			this.switchElementValue(sourceContainers[i], destContainers[i]);
		}
	},

	switchElementValue: function(source, dest) {
		if (source.nodeName.toLowerCase() != dest.nodeName.toLowerCase()) {
			throw "Switchable type not equals";
		}

		var fncName = this.getSwitchFunctionName(source.nodeName.toLowerCase());

		source = $(source);
		dest = $(dest);

		var tmp = source[fncName]();
		source[fncName](dest[fncName]());
		dest[fncName](tmp);
	},

	getSwitchFunctionName: function (tagName) {
		var fncName;

		switch(tagName) {
			case 'span':
			case 'textarea':
				fncName = 'html';
				break;
			case 'img':
				fncName = 'src';
				break;
			default:
				fncName = 'val';
		}

		return fncName
	}
};

var moduleNavigation = new ModuleNavigation();
$(function () {
	moduleNavigation.init();
});